<?php
require_once("Secure_area.php");
require_once(APPPATH . "models/cart/PHPPOSCartSale.php");
require_once(APPPATH . "traits/taxOverrideTrait.php");
require_once(APPPATH . "traits/creditcardProcessingTrait.php");
require_once(APPPATH . "traits/emailSalesReceiptTrait.php");
require_once(APPPATH . "libraries/Fatoora.php");

class Sales extends Secure_area
{
	use taxOverrideTrait;
	use creditcardProcessingTrait;
	use emailSalesReceiptTrait;


	public $cart;
	public $view_data = array();

	function __construct()
	{
		parent::__construct('sales');
		if (is_over_due()) {
			redirect('home');
		}
		$this->module_access_check();
		$this->lang->load('sales');
		$this->lang->load('module');
		$this->load->helper('order');
		$this->load->helper('items');
		$this->load->helper('sale');
		$this->load->model('Sale');
		$this->load->model('Customer');
		$this->load->model('Tier');
		$this->load->model('Category');
		$this->load->model('Giftcard');
		$this->load->model('Tag');
		$this->load->model('Item');
		$this->load->model('Item_location');
		$this->load->model('Item_kit_location');
		$this->load->model('Item_kit_location_taxes');
		$this->load->model('Item_kit');
		$this->load->model('Item_kit_items');
		$this->load->model('Item_kit_taxes');
		$this->load->model('Item_location_taxes');
		$this->load->model('Item_taxes');
		$this->load->model('Item_taxes_finder');
		$this->load->model('Item_kit_taxes_finder');
		$this->load->model('Additional_item_numbers');
		$this->load->model('Appfile');
		$this->load->model('Item_serial_number');
		$this->load->model('Price_rule');
		$this->load->model('Shipping_provider');
		$this->load->model('Shipping_method');
		$this->lang->load('deliveries');
		$this->load->model('Item_variation_location');
		$this->load->model('Item_variations');
		$this->load->helper('giftcards');
		$this->load->model('Item_attribute_value');
		$this->load->model('Item_modifier');
		$this->load->model('Delivery_category');
		$this->load->model('Work_order');
		$this->load->helper('text');
		$this->load->model('Supplier');
		$this->lang->load('work_orders');
		$this->load->model('Credit_card_charge_unconfirmed');
		$this->config->set_item('speedy_pos', true);
		$this->cart = PHPPOSCartSale::get_instance('sale');
		cache_item_and_item_kit_cart_info($this->cart->get_items());
	}


	public function sales_list()
	{

		if (!$this->Employee->has_module_action_permission('sales', 'list', $this->Employee->get_logged_in_employee_info()->person_id)) {
			redirect('no_access/sales_list');
		}
		$locations = array('-1' => lang('all_locations'));

		foreach ($this->Location->get_all(0, 10000, 0, 'name')->result() as $location) {
			$locations[$location->location_id] = $location->name;
		}

		$customers = array('-1' => lang('all_customers'));
		foreach ($this->Customer->get_all(0, 0, 1000, 0, 'full_name')->result() as $customer) {
			$customers[$customer->person_id] = $customer->full_name;
		}
		$data['locations'] = $locations;
		$data['location'] = -1;
		$data['customers'] = $customers;
		$data['customer'] = -1;

		$this->load->model('Sale_types');
		$sales_types = array('-1' => lang('all_sale_types'));
		$sales_types[0] = lang('Completed');
		$res = $this->sale_types->get_all();
		if ($res) {
			foreach ($res->result() as $sale_type) {
				$sales_types[$sale_type->id] = $sale_type->name;
			}
		}

		$data['sales_types'] = $sales_types;
		$data['sales_type'] = -1;

		$data['default_columns'] = $this->Sale->get_list_sales_default_columns();
		$data['selected_columns'] = $this->Employee->get_list_sales_columns_to_display();
		$data['all_columns'] = array_merge($data['selected_columns'], $this->Sale->get_list_sales_displayable_columns());


		$this->load->view('sales/sales_list', $data);
	}
	public function ajaxList()
	{
		$input = $this->input->post();
		$tableName = 'sales';
		$data['default_columns'] = $this->Sale->get_list_sales_default_columns();
		$data['selected_columns'] = $this->Employee->get_list_sales_columns_to_display();
		$columns = array_merge($data['selected_columns'], $this->Sale->get_list_sales_displayable_columns());
		$columns['default_order'] = ['sale_id' => 'desc'];
		$list = $this->sale->getDatatable($tableName, $columns, $input);
		$data = [];
		foreach ($list as $item) {
			$row = [];
			foreach ($columns as $col => $val) {
				// Skip 'default_order' when assembling rows
				if ($col === 'default_order') {
					continue;
				}
				if ($col === 'sale_id') {
					$item->$col = '<a href="' . site_url() . 'sales/receipt/' . $item->$col . '" target="_blank">POS ' . $item->$col . '</a>';
				}
				if ($col === 'profit') {
					$item->$col = to_currency_no_money($item->$col);
				}
				if ($col === 'total') {
					$item->$col = to_currency_no_money($item->$col);
				}
				if ($col === 'tax') {
					$item->$col = to_currency_no_money($item->$col);
				}
				if ($col === 'subtotal') {
					$item->$col = to_currency_no_money($item->$col);
				}
				$row[$col] = isset($item->$col) ? $item->$col : null; // Safely access property, provide default value if not set
			}
			$data[] = $row;
		}

		$output = [
			"draw" => $input['draw'],
			"recordsTotal" =>  $this->sale->countAll($tableName),
			"recordsFiltered" => $this->sale->countFiltered($tableName, $columns, $input),
			"data" => $data
		];

		echo json_encode($output);
	}


	public function select_regeister()
	{
		$this->load->view('sales/choose_register');
	}

	public function change_pos_settings()
	{
		// dd($_SESSION['employee_current_register_id']);
		$res = $this->db->update('registers', array(
			$_POST['id'] => $_POST['status'],
		), array('register_id' => $_SESSION['employee_current_register_id']));
		echo true;
	}

	function index($dont_switch_employee = 0)
	{


		// $this->cart->destroy();
		if (count($this->cart->get_items()) > 0) {
			$dont_switch_employee = 1;
		}
		if ($this->config->item('automatically_show_comments_on_receipt')) {
			$this->cart->show_comment_on_receipt = 1;
			$this->cart->save();
		}

		if ($this->config->item('default_sales_person') != 'not_set' && !$this->cart->sold_by_employee_id) {
			$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
			$this->cart->sold_by_employee_id = $employee_id;
			$this->cart->save();
		}

		$location_id = $this->Employee->get_logged_in_employee_current_location_id();

		$register_count = $this->Register->count_all($location_id);

		if ($register_count > 0) {
			if ($register_count == 1) {
				$registers = $this->Register->get_all($location_id);
				$register = $registers->row_array();

				if (isset($register['register_id'])) {
					$this->Employee->set_employee_current_register_id($register['register_id']);
				}
			}

			if (!$this->Employee->get_logged_in_employee_current_register_id()) {
				$default_register = $this->Employee->getDefaultRegister($this->Employee->get_logged_in_employee_info()->person_id, $this->Employee->get_logged_in_employee_current_location_id());

				if ($default_register && $default_register['location_id'] == $location_id) {
					$this->Employee->set_employee_current_register_id($default_register['register_id']);
					redirect(site_url('sales'));
				} else {
					$this->load->view('sales/choose_register');
					return;
				}
			}
		}
		$track_payment_types = $this->config->item('track_payment_types') ? unserialize($this->config->item('track_payment_types')) : NULL;

		if ($this->config->item('track_payment_types') && !empty($track_payment_types)) {


			if ($this->input->post('opening_amount') != '' && !$this->Register->is_register_log_open()) {

				$now = date('Y-m-d H:i:s');

				$cash_register = new stdClass();
				$cash_register->register_id = $this->Employee->get_logged_in_employee_current_register_id();
				$cash_register->employee_id_open = $this->session->userdata('person_id');
				$cash_register->shift_start = $now;
				$regiser_payment_data  = array();
				foreach ($this->input->post('opening_amount') as $payment_type => $opening_amount) {
					$regiser_payment_data[] = array('payment_type' => $payment_type, 'open_amount' => $opening_amount);
				}

				$register_log_id = $this->Register->insert_register($cash_register, $regiser_payment_data);

				$cash_register = $this->Register->get_current_register_log();
				$this->Register->insert_denoms($cash_register, $this->input->post('denoms'), 'open');

				redirect(site_url('sales'));
			} else if ($this->Register->is_register_log_open()) {
				$cash_in_register = NULL;


				if (($this->config->item('cash_alert_low') !== NULL && $this->config->item('cash_alert_low') !== '') || ($this->config->item('cash_alert_high') !== NULL && $this->config->item('cash_alert_high') !== '')) {

					if (in_array('common_cash', $track_payment_types)) {

						$cash_register = $this->Register->get_current_register_log();
						$register_log_id = $cash_register->register_log_id;

						$payment_sales = array();
						foreach ($track_payment_types as $payment_type) {
							$payment_sales[$payment_type] = $this->Sale->get_payment_sales_total_for_shift($cash_register->shift_start, date("Y-m-d H:i:s"), $payment_type);
						}

						$closeout = $this->Register->get_closeout_amounts($register_log_id, $payment_sales);

						if (isset($closeout['common_cash'])) {
							$cash_in_register = $closeout['common_cash'];
						}
					}
				}

				$this->_reload(array('dont_switch_employee' => $dont_switch_employee, 'cash_in_register' => $cash_in_register), false);
			} else {


				$this->load->view('sales/opening_amount', array('previous_closings' => $this->Register->get_closing_amounts($this->Register->get_last_closing_register_log_id($this->Employee->get_logged_in_employee_current_register_id())), 'denominations' => $this->Register->get_register_currency_denominations()->result_array()));
			}
		} else {
			$this->_reload(array('dont_switch_employee' => $dont_switch_employee), false);
		}
	}

	function choose_register($register_id)
	{
		if ($this->Register->exists($register_id)) {
			$this->Employee->set_employee_current_register_id($register_id);
		}

		redirect(site_url('sales'));
		return;
	}

	function clear_register()
	{
		//Clear out logged in register when we switch locations
		$this->Employee->set_employee_current_register_id(null);

		redirect(site_url('sales'));
		return;
	}

	function register_add_subtract($mode, $payment_type, $return = 'sales')
	{
		$data = array();
		$data['mode'] = $mode;
		$data['payment_type'] = $payment_type;
		$data['return'] = $return;
		$cash_register = $this->Register->get_current_register_log();
		$additions = $this->Register->get_total_payment_additions($cash_register->register_log_id);
		$subtractions = $this->Register->get_total_payment_subtractions($cash_register->register_log_id);

		if (!$this->Register->is_register_log_open()) {
			redirect(site_url('home'));
			return;
		}

		if ($this->input->post('amount') != '') {
			$message = '';
			$amount = to_currency_no_money($this->input->post('amount'));

			if ($mode == 'add') {
				$payment_data = array('total_payment_additions' => $additions[$payment_type] + $this->input->post('amount'));
				$message = lang('sales_cash_successfully_added_to_drawer');
			} else {
				$payment_data = array('total_payment_subtractions' => $subtractions[$payment_type] + $this->input->post('amount'));
				$message = lang('sales_cash_successfully_removed_from_drawer');
			}
			$this->Register->update_register_log_payment($cash_register->register_log_id, $payment_type, $payment_data);


			$employee_id_audit = $this->Employee->get_logged_in_employee_info()->person_id;
			$register_audit_log_data = array(
				'register_log_id' => $cash_register->register_log_id,
				'employee_id' => $employee_id_audit,
				'date' => date('Y-m-d H:i:s'),
				'payment_type' => $payment_type,
				'amount' => $mode == 'add' ? $amount : -$amount,
				'note' => $this->input->post('note'),
			);

			$this->Register->insert_audit_log($register_audit_log_data);

			$this->session->set_flashdata('cash_drawer_add_subtract_message', $message);

			if ($return == 'sales') {
				redirect('sales');
			} elseif ($return == 'closeregister') {
				redirect('sales/closeregister?continue=home');
			}
		} else {
			if ($mode == 'add') {
				$data['amount'] = to_currency($additions[$payment_type]);
			} else {
				$data['amount'] = to_currency($subtractions[$payment_type]);
			}

			$this->load->view('sales/register_add_subtract', $data);
		}
	}

	function closeregister()
	{
		if (!$this->Register->is_register_log_open()) {
			redirect(site_url('home'));
			return;
		}

		$cash_register = $this->Register->get_current_register_log();
		$register_log_id = $cash_register->register_log_id;
		$payment_types = unserialize($this->config->item('track_payment_types'));
		$open_amounts = 0;
		$total_payment_additions = 0;
		$total_payment_subtractions = 0;
		$closeout_amounts = 0;
		$payment_sales = array();
		foreach ($payment_types as $payment_type) {
			$payment_sales[$payment_type] = $this->Sale->get_payment_sales_total_for_shift($cash_register->shift_start, date("Y-m-d H:i:s"), $payment_type);

			if ($payment_type == 'common_credit') {
				$payment_sales[$payment_type] += $this->Sale->get_payment_sales_total_for_shift($cash_register->shift_start, date("Y-m-d H:i:s"), 'sales_partial_credit');
			}
		}

		$continueUrl = $this->input->get('continue');
		if ($this->input->post('closing_amount') != '') {
			$now = date('Y-m-d H:i:s');
			$cash_register->register_id = $this->Employee->get_logged_in_employee_current_register_id();
			$cash_register->employee_id_close = $this->session->userdata('person_id');
			$cash_register->shift_end = $now;
			$register_log_id_to_update = $cash_register->register_log_id;
			$this->Register->insert_denoms($cash_register, $this->input->post('denoms'), 'close');
			unset($cash_register->register_log_id);
			$cash_register->notes = $this->input->post('notes');
			$this->Register->update_register_log($cash_register, $cash_register->register_id);

			foreach ($this->input->post('closing_amount') as $payment_type => $closing_amount) {
				$this->Register->update_register_log_payment($register_log_id, $payment_type, array('close_amount' => $closing_amount, 'payment_sales_amount' => $payment_sales[$payment_type]));
			}
			if ($continueUrl == 'logout') {
				redirect(site_url('home/logout'));
			} elseif ($continueUrl == 'timeclocks') {
				redirect(site_url('timeclocks'));
			} elseif ($continueUrl == 'closeoutreceipt') {
				redirect(site_url("reports/register_log_details/$register_log_id"));
			} else {
				redirect(site_url('home'));
			}
		} else {

			if (!empty($payment_types)) {
				$open_amounts = $this->Register->get_opening_amounts($register_log_id);
				$total_payment_additions = $this->Register->get_total_payment_additions($register_log_id);
				$total_payment_subtractions = $this->Register->get_total_payment_subtractions($register_log_id);
				$closeout_amounts = $this->Register->get_closeout_amounts($register_log_id, $payment_sales);
			}

			$this->load->view('sales/closing_amount', array(
				'continue' => $continueUrl ? "?continue=$continueUrl" : '',
				'open_amounts' => $open_amounts,
				'notes' => '',
				'closeout_amounts' => $closeout_amounts,
				'payment_sales' => $payment_sales,
				'total_payment_additions' => $total_payment_additions,
				'total_payment_subtractions' => $total_payment_subtractions,
				'denominations' => $this->Register->get_register_currency_denominations()->result_array(),
				'register_log_id' => $register_log_id,
			));
		}
	}


	function edit_register($register_log_id)
	{
		$payment_types =  $this->config->item('track_payment_types') ? unserialize($this->config->item('track_payment_types')) : array();
		$payment_sales = array();

		$cash_register = $this->Register->get_existing_register_log($register_log_id);
		foreach ($payment_types as $payment_type) {
			$payment_sales[$payment_type] = $this->Sale->get_payment_sales_total_for_shift($cash_register->shift_start, date("Y-m-d H:i:s"), $payment_type);
		}

		$continueUrl = $this->input->get('continue');
		if ($this->input->post('closing_amount') != '') {


			$this->Register->update_existing_register_log(array('notes' => $this->input->post('notes')), $register_log_id);

			$this->Register->insert_denoms($cash_register, $this->input->post('denoms'), 'close');

			foreach ($this->input->post('closing_amount') as $payment_type => $closing_amount) {
				$this->Register->update_register_log_payment($register_log_id, $payment_type, array('close_amount' => $closing_amount));
			}

			foreach ($this->input->post('opening_amount') as $payment_type => $open_amount) {
				$this->Register->update_register_log_payment($register_log_id, $payment_type, array('open_amount' => $open_amount));
			}

			redirect(site_url("reports/register_log_details/$register_log_id"));
		} else {
			if (!empty($payment_types)) {
				$open_amounts = $this->Register->get_opening_amounts($register_log_id);
				$total_payment_additions = $this->Register->get_total_payment_additions($register_log_id);
				$total_payment_subtractions = $this->Register->get_total_payment_subtractions($register_log_id);
				$closeout_amounts = $this->Register->get_closing_amounts($register_log_id);
			}

			$this->load->view('sales/closing_amount', array(
				'continue' => $continueUrl ? "?continue=$continueUrl" : '',
				'open_amounts' => $open_amounts,
				'notes' => $cash_register->notes,
				'closeout_amounts' => $closeout_amounts,
				'payment_sales' => $payment_sales,
				'total_payment_additions' => $total_payment_additions,
				'total_payment_subtractions' => $total_payment_subtractions,
				'denominations' => $this->Register->get_register_currency_denominations()->result_array(),
				'register_log_id' => $register_log_id,
				'update' => true,
				'open_amount_editable' => true,
			));
		}
	}
	function item_validate_and_add()
	{
		$CI = &get_instance();
		$scan = $this->input->get('term');

		$return = parse_item_scan_data($scan);

		if (!$return) {

			if ($CI->config->item('enable_scale')) {
				$return = parse_scale_data($scan);
				if ($return) {
					$return['scale'] = true;
				}
			}
		} else {
			$return['scale'] = false;
		}

		if ($return) {

			$suggestion['value'] = $scan;




			$max_discount_employee = $this->Employee->get_logged_in_employee_info()->max_discount_percent;
			$can_override_price_adjustments = $this->Employee->get_logged_in_employee_info()->override_price_adjustments;
			$max_discount_config = $this->config->item('max_discount_percent') !== '' ? $this->config->item('max_discount_percent') : NULL;
			$item_id = $return['item_id'];

			$item_taxes = $this->Item_taxes->get_info($item_id);
			$tax = [];
			if (!empty($item_taxes)) {
				$tax = $item_taxes[0]['percent'];
			}
			$employee_location_id = $this->Employee->get_logged_in_employee_current_location_id();
			$suggestions['item_taxes'] = $item_taxes;
			$suggestions['tax'] = $tax;
			$rule = $CI->Price_rule->get_all_rule_for_item(6);
			// $item_id = explode('#',$item_id)[0];
			$item_info = $this->Item->get_info($item_id);
			$suggestion['value'] = $item_id;
			$size = $item_info->size ? ' - ' . $item_info->size : '';
			$suggestion['label'] = character_limiter($item_info->name, 30) . $size;
			$suggestion['serial_number'] = (isset($item_info->serial_number)) ? $item_info->serial_number : '';
			$suggestion['tax_included'] = (isset($item_info->tax_included)) ? $item_info->tax_included : 0;
			$suggestion['override_default_tax'] = (isset($item_info->override_default_tax)) ? $item_info->override_default_tax : 0;
			$suggestion['image'] =  $item_info->image_id && !$this->config->item('dont_show_images_in_search_suggestions') ?  cacheable_app_file_url($item_info->image_id) : base_url() . "assets/img/item.png";
			$suggestion['quantity'] = 1;





			$allow_price_override_regardless_of_permissions =  $item_info->allow_price_override_regardless_of_permissions ? 1 : 0;
			$permissions = array(
				'allow_price_override_regardless_of_permissions' => $allow_price_override_regardless_of_permissions,
				'always_use_average_cost_method' => $this->config->item('always_use_average_cost_method'),
				'hide_supplier_on_sales_interface' => $this->config->item('hide_supplier_on_sales_interface'),
				'disable_supplier_selection_on_sales_interface' => $this->config->item('disable_supplier_selection_on_sales_interface'),
				'hide_description_on_sales_and_recv' => $this->config->item('hide_description_on_sales_and_recv'),
				'allow_alt_description' => $item_info->allow_alt_description,
				'change_cost_price' =>  $item_info->change_cost_price,
				'edit_serail_no' =>  	$this->Employee->has_module_action_permission('sales', 'edit_serail_no', $this->Employee->get_logged_in_employee_info()->person_id),
				'require_to_add_serial_number_in_pos' => $this->config->item('require_to_add_serial_number_in_pos'),
				'id_to_show_on_sale_interface' =>	$this->config->item('id_to_show_on_sale_interface'),
				'do_not_allow_out_of_stock_items_to_be_sold' =>	$this->config->item('do_not_allow_out_of_stock_items_to_be_sold'),
				'process_returns' => (!$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)),
				'process_returns_error' => lang('sales_not_allowed_returns'),
				'sales_could_not_discount_item_above_max' => lang('sales_could_not_discount_item_above_max'),
				'do_not_allow_below_cost' => $this->config->item('do_not_allow_below_cost'),

			);

			$source_supplier_data = array();

			$secondary_supplier_details = array();
			foreach ($this->Item->get_all_suppliers_of_an_item($item_id)->result_array() as $row) {
				$source_supplier_data[$row['supplier_id']] = array('value' => $row['supplier_id'], 'text' => $row['company_name'] . ' (' . $row['full_name'] . ')');
				$secondary_supplier = $this->Item->get_secondary_supplier_details($item_id, $row['supplier_id']);
				if ($secondary_supplier) {
					$secondary_supplier_details[$row['supplier_id']] = (array) $secondary_supplier;
				}
			}

			$max_discount = $item_info->max_discount_percent;

			//Try employee
			if (!$can_override_price_adjustments && $max_discount === NULL) {
				$max_discount = $max_discount_employee;
			}

			//Try globally
			if (!$can_override_price_adjustments && $max_discount === NULL) {
				$max_discount = $max_discount_config;
			}
			$rule = $CI->Price_rule->get_all_rule_for_item($item_id);
			$size = $item_info->size ? ' - ' . $item_info->size : '';
			$variatons = 	$this->item_variations($suggestion['value'], true);

			$quantity_units = $this->Item->get_quantity_units($suggestion['value'], true);
			$quantity_units_res = array();
			$quantity_units_info = array();
			if (!empty($quantity_units)) {
				$quantity_units_res[0]['value'] = "0";
				$quantity_units_res[0]['text'] = lang('None');
				foreach ($quantity_units as $key => $value) {
					$quantity_units_res[$value['id']]['value'] = $value['id'];
					$quantity_units_res[$value['id']]['text'] = $value['unit_name'];
					$quantity_units_info[$value['id']] = (array) $this->Item->get_quantity_unit_info($value['id']);
				}
				// dd($quantity_units);
			}
			/// getting items and categories


			$mods_for_item = $this->Item_modifier->get_modifiers_for_item_id($suggestion['value'])->result_array();

			if ($mods_for_item) {
				foreach ($mods_for_item as $modifier_item_id => $modifier_item) {

					// dd($modifier_item);
					$Item_modifier  = $this->Item_modifier->get_modifier_item_info($modifier_item['id']);
					// dd($Item_modifier);
					$mods_for_item[$modifier_item_id]['modifier_item_id'] = $modifier_item['id'];
					$mods_for_item[$modifier_item_id]['unit_price'] =  $Item_modifier['unit_price'];
					$mods_for_item[$modifier_item_id]['cost_price'] =  $Item_modifier['cost_price'];
					$mods_for_item[$modifier_item_id]['unit_price_currency'] =  to_currency($Item_modifier['unit_price']);
					$mods_for_item[$modifier_item_id]['modifier_item_name'] =   $Item_modifier['modifier_item_name'];
				}
			}


			if (!$return['scale']) {
				if (strpos($suggestion['value'], 'KIT') === 0) {
					$price_to_use = $this->Item_kit->get_sale_price(array('item_kit_id' => str_replace('KIT', '', $suggestion['value'])));
				} else {
					$price_to_use = $this->Item->get_sale_price(array('item_id' => $suggestion['value']));
				}
			} else {

				$price_to_use =  $return['sell_price'];
				$suggestion['quantity'] = $return['sell_quantity'];
			}



			$id_to_show_on_sale_interface_val = '';
			switch ($this->config->item('id_to_show_on_sale_interface')) {
				case 'number':

					if (property_exists($item_info, 'item_number') && $item_info->item_number) {
						$id_to_show_on_sale_interface_val =  H($item_info->item_number);
					} elseif (property_exists($item_info, 'item_kit_number') && $item_info->item_kit_number) {
						$id_to_show_on_sale_interface_val =  H($item_info->item_kit_number);
					} else {
						$id_to_show_on_sale_interface_val =  lang('none');
					}

					break;

				case 'product_id':
					$id_to_show_on_sale_interface_val =  property_exists($item_info, 'product_id') ? H($item_info->product_id) : lang('none');
					break;

				case 'id':
					$id_to_show_on_sale_interface_val =  property_exists($item_info, 'item_id') ? H($item_info->item_id) : 'KIT ' . H($item_info->item_kit_id);
					break;

				default:
					if (property_exists($item_info, 'item_number') && $item_info->item_number) {
						$id_to_show_on_sale_interface_val =  H($item_info->item_number);
					} elseif (property_exists($item_info, 'item_kit_number') && $item_info->item_kit_number) {
						$id_to_show_on_sale_interface_val =  H($item_info->item_kit_number);
					} else {
						$id_to_show_on_sale_interface_val =  lang('none');
					}
					break;
			}

			$cur_quantity = 0;
			$item_variation_location_info = [];
			$item_location_info = [];
			if (isset($item_info->variation_id)) {
				$item_variation_location_info = $this->Item_variation_location->get_info($item_info->variation_id, $employee_location_id, true, 0);

				$cur_quantity = (int)$item_variation_location_info->quantity;
			} else {
				$item_location_info = $this->Item_location->get_info($item_info->item_id, $employee_location_id, false, 0);

				$cur_quantity = (int)$item_location_info->quantity;
			}
			$item_location_quantity = (int)$this->Item_location->get_location_quantity($item_info->item_id);

			$item_location_info  = (array) $item_location_info;
			$item_tier_row = [];
			$item_location_tier_row = [];
			$all_tier_info = [];
			foreach ($this->Tier->get_all()->result() as $key  => $tier) {
				$all_tier_info[$tier->id] = (array) $tier;
				$item_tier_row[$tier->id] = (array) $this->Item->get_tier_price_row($tier->id, $item_info->item_id);
				$item_location_tier_row[$tier->id] = (array)  $this->Item_location->get_tier_price_row($tier->id, $item_info->item_id, $employee_location_id);
			}

			if (count($variatons) > 0) {
				foreach ($variatons as $key => $var) {
					$variatons[$key]['item_variation_location_info'] = (array) $this->Item_variation_location->get_info(explode('#', $var['id'])[1], $employee_location_id, true, 0);
				}
			}

			$this->load->model('Item_attribute');
			$item_attributes_available = $this->Item_attribute->get_attributes_for_item_with_attribute_values_updated($item_info->item_id);
			$item_location_quantity = $this->Item_location->get_location_quantity($item_info->item_id);

			if (isset($return['variation_id']) &&  $return['variation_id']) {
				$suggestion['label'] = $suggestion['label'] . ' [' . $return['variation_name'] . ']';
				$suggestion['variation_id'] = $return['variation_id'];
				$suggestion['value'] = $suggestion['value'] . '#' . $return['variation_id'];
				$suggestion['selected_variation'] = '';
				$variations = $CI->Item_variations->get_attributes($return['variation_id']);
				$selectedAttributes = array();
				if ($variations) {
					$i = 1;
					foreach ($variations as $var) {
						$selectedAttributes[$i] = $var['value'];
						$suggestion['selected_variation'] = $suggestion['selected_variation'] . $var['value'];
						$i++;
					}
				}
				$suggestion['selectedAttributes'] = $selectedAttributes;
			} else {
				$suggestion['variation_id'] = 0;
			}



			$suggestions = $suggestion;
			$suggestions['description'] = $item_info->description;
			$suggestions['price'] = $price_to_use;
			$suggestions['item_taxes'] = $item_taxes;
			$suggestions['modifiers'] = $mods_for_item;
			$suggestions['regular_price'] = $item_info->unit_price;
			$suggestions['cost_price'] = $item_info->cost_price;

			if (isset($return['serial_numbers'])) {
				$suggestions['serialnumber'] = $return['serial_numbers']->id;
				$suggestions['serialnumberText'] = $return['serial_numbers']->serial_number;
			}



			$serial_numbers = [];
			$employee_location_id = $this->Employee->get_logged_in_employee_current_location_id();
			if ($item_info->is_serialized) {
				$serial_numbers = $this->Item_serial_number->get_all_data($item_info->item_id, $employee_location_id, $input = array());
			}


			$suggestions['all_data'] = [
				'permissions' => $permissions,
				'source_supplier_data' => $source_supplier_data,
				'secondary_supplier_details' => $secondary_supplier_details,
				'can_override_price_adjustments' => $can_override_price_adjustments,
				'id' => $item_id,
				'rules' => $rule,
				'item_location_info' => $item_location_info,
				'item_tier_row' => $item_tier_row,
				'item_variation_location_info' => $item_variation_location_info,
				'item_location_tier_row' => $item_location_tier_row,
				'all_tier_info' => $all_tier_info,
				'max_discount' => $max_discount,
				'name' => character_limiter($suggestion['label'], 30) . $size,
				'item_taxes' => $item_taxes,
				"is_serialized" => $item_info->is_serialized,
				"serial_numbers" =>  $serial_numbers,
				'tax_percent' => $tax,
				'is_recurring' => $item_info->is_recurring,
				'tax_included' => (isset($suggestion['tax_included'])) ? $suggestion['tax_included'] : 0,
				'override_default_tax' => (isset($suggestion['override_default_tax'])) ? $suggestion['override_default_tax'] : 0,
				'image_src' => 	$suggestion['image'],
				'category_name' => 	$this->Category->get_full_path($item_info->category_id),
				'category_id' => 	$item_info->category_id,
				'description' => 	clean_html($item_info->description),
				'has_variations' => count($variatons) > 0 ? $variatons : FALSE,
				'item_attributes_available' => $item_attributes_available,
				'type' => 'item',
				'quantity_units' => $quantity_units_res,
				'quantity_units_info' => $quantity_units_info,
				'modifiers'	=> $mods_for_item,
				"cost_price" => $item_info->cost_price,
				'price' => $price_to_use != '0.00' ? to_currency($price_to_use) : FALSE,
				'regular_price' => $item_info->unit_price,
				'different_price' => $price_to_use != $item_info->unit_price,
				'id_to_show_on_sale_interface_val' => $id_to_show_on_sale_interface_val,
				'cur_quantity' => to_quantity($cur_quantity),
				'is_series_package' => $item_info->is_series_package,
				'series_quantity' => $item_info->series_quantity,
				'series_days_to_use_within' => $item_info->series_days_to_use_within,
				'item_location_quantity' => $item_location_quantity,
				'is_service' => $item_info->is_service,
				'max_edit_price' => $item_info->max_edit_price,
				'min_edit_price' => $item_info->min_edit_price,
			];


			$suggestions['quantity_units'] = $quantity_units_res;
			echo json_encode(['response' => 'true',  'data' => H($suggestions)]);
		} else {
			echo 	json_encode(
				['response' => false,  'msg'   => lang('item_not_found')]
			);
		}
	}
	function item_search()
	{
		//allow parallel searchs to improve performance.
		session_write_close();


		if (!$this->config->item('speed_up_search_queries')) {
			$suggestions = $this->Item->get_item_search_suggestions($this->input->get('term'), 0, 'unit_price', $this->config->item('items_per_search_suggestions') ? (int)$this->config->item('items_per_search_suggestions') : 20, TRUE);


			$suggestions = array_merge($suggestions, $this->Item_kit->get_item_kit_search_suggestions_sales_recv($this->input->get('term'), 0, 'unit_price', 100, TRUE));
		} else {

			$suggestions = $this->Item->get_item_search_suggestions_without_variations($this->input->get('term'), 0, $this->config->item('items_per_search_suggestions') ? (int)$this->config->item('items_per_search_suggestions') : 20, 'unit_price', TRUE);
			$suggestions = array_merge($suggestions, $this->Item_kit->get_item_kit_search_suggestions_sales_recv($this->input->get('term'), 0, 'unit_price', 100, TRUE));

			for ($k = 0; $k < count($suggestions); $k++) {
				if (isset($suggestions[$k]['avatar'])) {
					$suggestions[$k]['image'] = $suggestions[$k]['avatar'];
				}

				if (isset($suggestions[$k]['subtitle'])) {
					$suggestions[$k]['category'] = $suggestions[$k]['subtitle'];
				}
			}
		}
		$CI = &get_instance();

		$max_discount_employee = $this->Employee->get_logged_in_employee_info()->max_discount_percent;
		$can_override_price_adjustments = $this->Employee->get_logged_in_employee_info()->override_price_adjustments;
		$max_discount_config = $this->config->item('max_discount_percent') !== '' ? $this->config->item('max_discount_percent') : NULL;
		if (count($suggestions) > 0) {
			$j = 0;
			foreach ($suggestions as $suggestion) {

				$item_taxes = $this->Item_taxes->get_info($suggestion['value']);
				$tax = [];
				if (!empty($item_taxes)) {
					$tax = $item_taxes[0]['percent'];
				}
				$employee_location_id = $this->Employee->get_logged_in_employee_current_location_id();
				$suggestions[$j]['item_taxes'] = $item_taxes;
				$suggestions[$j]['tax'] = $tax;
				$rule = $CI->Price_rule->get_all_rule_for_item(6);
				$item_id = explode('#', $suggestion['value'])[0];
				$item_info = $this->Item->get_info($item_id);
				$allow_price_override_regardless_of_permissions =  $item_info->allow_price_override_regardless_of_permissions ? 1 : 0;
				$permissions = array(
					'allow_price_override_regardless_of_permissions' => $allow_price_override_regardless_of_permissions,
					'always_use_average_cost_method' => $this->config->item('always_use_average_cost_method'),
					'hide_supplier_on_sales_interface' => $this->config->item('hide_supplier_on_sales_interface'),
					'disable_supplier_selection_on_sales_interface' => $this->config->item('disable_supplier_selection_on_sales_interface'),
					'hide_description_on_sales_and_recv' => $this->config->item('hide_description_on_sales_and_recv'),
					'allow_alt_description' => $item_info->allow_alt_description,
					'change_cost_price' =>  $item_info->change_cost_price,
					'edit_serail_no' =>  	$this->Employee->has_module_action_permission('sales', 'edit_serail_no', $this->Employee->get_logged_in_employee_info()->person_id),
					'require_to_add_serial_number_in_pos' => $this->config->item('require_to_add_serial_number_in_pos'),
					'id_to_show_on_sale_interface' =>	$this->config->item('id_to_show_on_sale_interface'),
					'do_not_allow_out_of_stock_items_to_be_sold' =>	$this->config->item('do_not_allow_out_of_stock_items_to_be_sold'),
					'process_returns' => (!$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)),
					'process_returns_error' => lang('sales_not_allowed_returns'),
					'sales_could_not_discount_item_above_max' => lang('sales_could_not_discount_item_above_max'),
					'do_not_allow_below_cost' => $this->config->item('do_not_allow_below_cost'),

				);

				$source_supplier_data = array();

				$secondary_supplier_details = array();
				foreach ($this->Item->get_all_suppliers_of_an_item($item_id)->result_array() as $row) {
					$source_supplier_data[$row['supplier_id']] = array('value' => $row['supplier_id'], 'text' => $row['company_name'] . ' (' . $row['full_name'] . ')');
					$secondary_supplier = $this->Item->get_secondary_supplier_details($item_id, $row['supplier_id']);
					if ($secondary_supplier) {
						$secondary_supplier_details[$row['supplier_id']] = (array) $secondary_supplier;
					}
				}

				$max_discount = $item_info->max_discount_percent;

				//Try employee
				if (!$can_override_price_adjustments && $max_discount === NULL) {
					$max_discount = $max_discount_employee;
				}

				//Try globally
				if (!$can_override_price_adjustments && $max_discount === NULL) {
					$max_discount = $max_discount_config;
				}
				$rule = $CI->Price_rule->get_all_rule_for_item($item_id);
				$size = $item_info->size ? ' - ' . $item_info->size : '';
				$variatons = 	$this->item_variations($suggestion['value'], true);

				$quantity_units = $this->Item->get_quantity_units($suggestion['value'], true);
				$quantity_units_res = array();
				$quantity_units_info = array();
				if (!empty($quantity_units)) {
					$quantity_units_res[0]['value'] = "0";
					$quantity_units_res[0]['text'] = lang('None');
					foreach ($quantity_units as $key => $value) {
						$quantity_units_res[$value['id']]['value'] = $value['id'];
						$quantity_units_res[$value['id']]['text'] = $value['unit_name'];
						$quantity_units_info[$value['id']] = (array) $this->Item->get_quantity_unit_info($value['id']);
					}
					// dd($quantity_units);
				}
				/// getting items and categories


				$mods_for_item = $this->Item_modifier->get_modifiers_for_item_id($suggestion['value'])->result_array();

				if ($mods_for_item) {
					foreach ($mods_for_item as $modifier_item_id => $modifier_item) {

						// dd($modifier_item);
						$Item_modifier  = $this->Item_modifier->get_modifier_item_info($modifier_item['id']);
						// dd($Item_modifier);
						$mods_for_item[$modifier_item_id]['modifier_item_id'] = $modifier_item['id'];
						$mods_for_item[$modifier_item_id]['unit_price'] =  $Item_modifier['unit_price'];
						$mods_for_item[$modifier_item_id]['cost_price'] =  $Item_modifier['cost_price'];
						$mods_for_item[$modifier_item_id]['unit_price_currency'] =  to_currency($Item_modifier['unit_price']);
						$mods_for_item[$modifier_item_id]['modifier_item_name'] =   $Item_modifier['modifier_item_name'];
					}
				}

				if (strpos($suggestion['value'], 'KIT') === 0) {
					$price_to_use = $this->Item_kit->get_sale_price(array('item_kit_id' => str_replace('KIT', '', $suggestion['value'])));
				} else {
					$price_to_use = $this->Item->get_sale_price(array('item_id' => $suggestion['value']));
				}

				$id_to_show_on_sale_interface_val = '';
				switch ($this->config->item('id_to_show_on_sale_interface')) {
					case 'number':

						if (property_exists($item_info, 'item_number') && $item_info->item_number) {
							$id_to_show_on_sale_interface_val =  H($item_info->item_number);
						} elseif (property_exists($item_info, 'item_kit_number') && $item_info->item_kit_number) {
							$id_to_show_on_sale_interface_val =  H($item_info->item_kit_number);
						} else {
							$id_to_show_on_sale_interface_val =  lang('none');
						}

						break;

					case 'product_id':
						$id_to_show_on_sale_interface_val =  property_exists($item_info, 'product_id') ? H($item_info->product_id) : lang('none');
						break;

					case 'id':
						$id_to_show_on_sale_interface_val =  property_exists($item_info, 'item_id') ? H($item_info->item_id) : 'KIT ' . H($item_info->item_kit_id);
						break;

					default:
						if (property_exists($item_info, 'item_number') && $item_info->item_number) {
							$id_to_show_on_sale_interface_val =  H($item_info->item_number);
						} elseif (property_exists($item_info, 'item_kit_number') && $item_info->item_kit_number) {
							$id_to_show_on_sale_interface_val =  H($item_info->item_kit_number);
						} else {
							$id_to_show_on_sale_interface_val =  lang('none');
						}
						break;
				}

				$cur_quantity = 0;
				$item_variation_location_info = [];
				$item_location_info = [];
				if (isset($item_info->variation_id)) {
					$item_variation_location_info = $this->Item_variation_location->get_info($item_info->variation_id, $employee_location_id, true, 0);

					$cur_quantity = (int)$item_variation_location_info->quantity;
				} else {
					$item_location_info = $this->Item_location->get_info($item_info->item_id, $employee_location_id, false, 0);

					$cur_quantity = (int)$item_location_info->quantity;
				}
				$item_location_quantity = (int)$this->Item_location->get_location_quantity($item_info->item_id);

				$item_location_info  = (array) $item_location_info;
				$item_tier_row = [];
				$item_location_tier_row = [];
				$all_tier_info = [];
				foreach ($this->Tier->get_all()->result() as $key  => $tier) {
					$all_tier_info[$tier->id] = (array) $tier;
					$item_tier_row[$tier->id] = (array) $this->Item->get_tier_price_row($tier->id, $item_info->item_id);
					$item_location_tier_row[$tier->id] = (array)  $this->Item_location->get_tier_price_row($tier->id, $item_info->item_id, $employee_location_id);
				}

				if (count($variatons) > 0) {
					foreach ($variatons as $key => $var) {
						$variatons[$key]['item_variation_location_info'] = (array) $this->Item_variation_location->get_info(explode('#', $var['id'])[1], $employee_location_id, true, 0);
					}
				}

				$this->load->model('Item_attribute');
				$item_attributes_available = $this->Item_attribute->get_attributes_for_item_with_attribute_values_updated($item_info->item_id);
				$item_location_quantity = $this->Item_location->get_location_quantity($item_info->item_id);
				$serial_numbers = [];
				$employee_location_id = $this->Employee->get_logged_in_employee_current_location_id();
				if ($item_info->is_serialized) {
					$serial_numbers = $this->Item_serial_number->get_all_data($item_info->item_id, $employee_location_id, $input = array());
				}

				$suggestions[$j]['all_data'] = [
					'permissions' => $permissions,
					'source_supplier_data' => $source_supplier_data,
					'secondary_supplier_details' => $secondary_supplier_details,
					'can_override_price_adjustments' => $can_override_price_adjustments,
					'id' => $item_id,
					'rules' => $rule,
					'item_location_info' => $item_location_info,
					'item_tier_row' => $item_tier_row,
					'item_variation_location_info' => $item_variation_location_info,
					'item_location_tier_row' => $item_location_tier_row,
					'all_tier_info' => $all_tier_info,
					'max_discount' => $max_discount,
					'name' => character_limiter($suggestion['label'], 30) . $size,
					'item_taxes' => $item_taxes,
					"is_serialized" => $item_info->is_serialized,
					"serial_numbers" => $serial_numbers,
					'tax_percent' => $tax,
					'is_recurring' => $item_info->is_recurring,
					'tax_included' => (isset($suggestion['tax_included'])) ? $suggestion['tax_included'] : 0,
					'override_default_tax' => (isset($suggestion['override_default_tax'])) ? $suggestion['override_default_tax'] : 0,
					'image_src' => 	$suggestion['image'],
					'category_name' => 	$this->Category->get_full_path($item_info->category_id),
					'category_id' => 	$item_info->category_id,
					'description' => 	clean_html($item_info->description),
					'has_variations' => count($variatons) > 0 ? $variatons : FALSE,
					'item_attributes_available' => $item_attributes_available,
					'type' => 'item',
					'quantity_units' => $quantity_units_res,
					'quantity_units_info' => $quantity_units_info,
					'modifiers'	=> $mods_for_item,
					"cost_price" => $item_info->cost_price,
					'price' => $price_to_use != '0.00' ? to_currency($price_to_use) : FALSE,
					'regular_price' => $item_info->unit_price,
					'different_price' => $price_to_use != $item_info->unit_price,
					'id_to_show_on_sale_interface_val' => $id_to_show_on_sale_interface_val,
					'cur_quantity' => to_quantity($cur_quantity),
					'is_series_package' => $item_info->is_series_package,
					'series_quantity' => $item_info->series_quantity,
					'series_days_to_use_within' => $item_info->series_days_to_use_within,
					'item_location_quantity' => $item_location_quantity,
					'is_service' => $item_info->is_service,
					'max_edit_price' => $item_info->max_edit_price,
					'min_edit_price' => $item_info->min_edit_price,
				];


				$suggestions[$j]['quantity_units'] = $quantity_units_res;
				$j++;
			}
		}



		echo json_encode(H($suggestions));
	}
	function customer_search()
	{
		//allow parallel searchs to improve performance.
		session_write_close();
		$suggestions = $this->Customer->get_customer_search_suggestions($this->input->get('term'), 0, 100);
		$store_account_payment_item_id = $this->Item->create_or_update_store_account_item();
		foreach ($suggestions as $k => $suggestion) {
			$cust_info =    $this->Customer->get_info($suggestion['value']);
			$suggestions[$k]['unpaid_store_account_sale_ids']  =  $this->Sale->get_unpaid_store_account_sales($this->Sale->get_unpaid_store_account_sale_ids($suggestion['value']));
			$suggestions[$k]['points'] = to_quantity($cust_info->points);
			$suggestions[$k]['sales_until_discount'] = ($this->config->item('number_of_sales_for_discount') ? $this->config->item('number_of_sales_for_discount') : 0) - $cust_info->current_sales_for_discount;
			$suggestions[$k]['customer_credit_limit'] = $cust_info->credit_limit;
			$suggestions[$k]['disable_loyalty'] = $cust_info->disable_loyalty;
			$suggestions[$k]['is_over_credit_limit'] = $this->Customer->is_over_credit_limit($suggestion['value'], $this->cart->get_payment_amount(lang('store_account')));
			$suggestions[$k]['store_account_payment_item_id'] = $store_account_payment_item_id;
		}
		// dd($suggestions);
		// 
		// $data['customer_credit_limit'] = $cust_info->credit_limit;
		// $data['is_over_credit_limit'] = $this->Customer->is_over_credit_limit($customer_id,$this->cart->get_payment_amount(lang('store_account')));
		if ($this->config->item('enable_customer_quick_add')) {
			$suggestions[] = array('subtitle' => '', 'avatar' => base_url() . "assets/img/user.png", 'sales_until_discount' => $this->config->item('number_of_sales_for_discount') ? $this->config->item('number_of_sales_for_discount') : 0,   'value' => 'QUICK_ADD|' . $this->input->get('term'), 'label' => lang('customers_add_new_customer') . ' ' . $this->input->get('term'));
		}

		echo json_encode(H($suggestions));
	}

	function select_customer()
	{
		if ($this->config->item('enable_customer_quick_add') && strpos($this->input->post('customer'), 'QUICK_ADD|') !== FALSE) {
			$_POST['customer'] = str_replace('QUICK_ADD|', '', $_POST['customer']);
			$_POST['customer'] = str_replace('|FORCE_PERSON_ID|', '', $_POST['customer']);
			$this->load->helper('text');
			list($first_name, $last_name) = split_name($this->input->post('customer'));
			$person_data = array('first_name' => $first_name, 'last_name' => $last_name);
			$customer_data = array();
			$this->Customer->save_customer($person_data, $customer_data);
			$_POST['customer'] =  $person_data['person_id'];
		}

		$data = $this->cart->select_customer($this->input->post("customer"));

		$items = $this->cart->get_items();
		$run_tier_change = FALSE;

		//Remove any rules
		foreach ($items as $line => $item) {
			if (!empty($item->rule)) {
				if ($this->Price_rule->is_rule_excluded_by_tier($item->rule)) {
					$this->cart->get_item($line)->rule = array();
					$this->cart->get_item($line)->unit_price = $this->cart->get_item($line)->regular_price;
					$this->cart->get_item($line)->discount = 0;
					$run_tier_change = TRUE;
				}
			}
		}

		if ($run_tier_change) {
			$this->cart->determine_new_prices_for_tier_change();
		}

		$this->cart->save();
		$this->sales_reload($data);
	}

	function change_mode($mode = false, $redirect = false)
	{
		$previous_mode = $this->cart->get_mode();

		$mode = $mode === FALSE ? $this->input->post("mode") : $mode;

		if ($previous_mode == 'store_account_payment' && ($mode == 'sale' || $mode == 'return')) {
			$this->cart->empty_items();
		}

		$this->cart->set_mode($mode);

		if ($mode == 'store_account_payment') {
			$store_account_payment_item_id = $this->Item->create_or_update_store_account_item();
			$this->cart->empty_items();
			$this->cart->add_item(new PHPPOSCartItemSale(array('cost_price' => 0, 'unit_price' => 0, 'scan' => $store_account_payment_item_id . '|FORCE_ITEM_ID|', 'cart' => $this->cart)));
			$this->cart->save();
		}

		if ($mode == 'purchase_points') {
			$purchase_points_item_id = $this->Item->create_or_update_purchase_points_item();
			$this->cart->empty_items();
			$this->cart->add_item(new PHPPOSCartItemSale(array('scan' => $purchase_points_item_id . '|FORCE_ITEM_ID|', 'cart' => $this->cart)));
			$this->cart->save();
		}

		if ($redirect) {
			redirect('sales');
		} else {
			$data = array();
			if ($previous_mode == 'sale' && $mode == 'return') {
				if ($this->cart->can_convert_cart_from_sale_to_return()) {
					$data  = array('prompt_convert_sale_to_return' => TRUE);
				} elseif ($this->config->item('prompt_for_sale_id_on_return')) {
					$data  = array('prompt_convert_sale_to_return' => FALSE, 'prompt_for_return_sale_id' => TRUE);
				} else {
					$data  = array('prompt_convert_sale_to_return' => FALSE);
				}
			} elseif ($previous_mode == 'return' && $mode == 'sale') {
				if ($this->cart->can_convert_cart_from_return_to_sale()) {
					$data  = array('prompt_convert_return_to_sale' => TRUE);
				} else {
					$data  = array('prompt_convert_return_to_sale' => FALSE);
				}
			}
			$this->cart->save();
			$this->sales_reload($data);
		}
	}

	function convert_sale_to_return()
	{
		//do logic for making a sale a return
		$this->cart->do_convert_cart_from_sale_to_return();
		$this->cart->save();
		$this->sales_reload();
	}

	function convert_return_to_sale()
	{
		//do logic for making a sale a return
		$this->cart->do_convert_cart_from_return_to_sale();
		$this->cart->save();
		$this->sales_reload();
	}

	function set_comment()
	{
		$this->cart->comment = $this->input->post('value');
		$this->cart->ref_sale_desc = $this->input->post('ref_sale_desc');
		$this->cart->save();
		$this->sales_reload();
	}
	function set_return_reason()
	{
		$this->cart->return_reason = $this->input->post('return_reason');
		$this->cart->save();
	}
	function set_selected_payment()
	{
		$this->cart->selected_payment = $this->input->post('payment');
		$this->cart->save();
	}

	function set_change_cart_date()
	{
		$this->cart->change_cart_date = $this->input->post('change_cart_date');
		$this->cart->save();
	}

	function set_change_date_enable()
	{
		$this->cart->change_date_enable = $this->input->post('change_date_enable');
		if (!$this->cart->change_cart_date) {
			$this->cart->change_cart_date = date(get_date_format());
		}
		$this->cart->save();
	}

	function set_comment_on_receipt()
	{
		$this->cart->show_comment_on_receipt = $this->input->post('show_comment_on_receipt');
		$this->cart->save();
	}

	function set_email_receipt()
	{
		$this->cart->email_receipt = $this->input->post('email_receipt');
		$this->cart->save();
	}

	function set_sms_receipt()
	{
		$this->cart->sms_receipt = $this->input->post('sms_receipt');
		$this->cart->save();
	}

	function set_save_credit_card_info()
	{
		$this->cart->save_credit_card_info = $this->input->post('save_credit_card_info');
		$this->cart->save();
	}

	function set_use_saved_cc_info()
	{
		$this->cart->use_cc_saved_info = $this->input->post('use_saved_cc_info');
		$this->cart->save();
	}

	function set_prompt_for_card()
	{
		$this->cart->prompt_for_card = $this->input->post('prompt_for_card');
		$this->cart->save();
	}

	function set_show_terms_and_conditions()
	{
		$this->cart->show_terms_and_conditions = $this->input->post('show_terms_and_conditions');
		$this->cart->save();
	}

	function set_supplier_id_speedy()
	{
		$item = json_decode($this->input->post('item'), TRUE);
		$supplier_id = $this->input->post('supplier_id');
		$item_id = 0;
		$variation_id = 0;
		if (strpos($item['item_id'], '#') !== false) {
			$exp = explode("#", $item['item_id']);
			$item_id = $exp[0];
			$variation_id = $exp[1];
		} else {
			$item_id = $item['item_id'];
		}





		if (!$this->Item->has_variations($item_id) && $this->Item->has_secondary_supplier($item_id)) {

			$secondary_supplier = $this->Item->get_secondary_supplier_details($item_id, $supplier_id);

			if ($secondary_supplier) {
				$item['unit_price'] = $secondary_supplier->unit_price;
				$item['price'] = $secondary_supplier->unit_price;
				$item['cost_price'] = $secondary_supplier->cost_price;
			} else {
				$item_details = $this->Item->get_info($item_id);
				$item['unit_price'] = $item_details->unit_price;
				$item['price'] = $item_details->unit_price;
				$item['cost_price'] = $item_details->cost_price;
			}
		} else if ($this->Item->has_variations($item_id) && $this->Item->has_secondary_supplier($item_id)) {



			$secondary_supplier = $this->Item->get_secondary_supplier_details($item_id, $supplier_id);

			if ($secondary_supplier) {
				$item['unit_price'] = $secondary_supplier->unit_price;
				$item['price'] = $secondary_supplier->unit_price;
				$item['cost_price'] = $secondary_supplier->cost_price;
			} else {
				$item_details = $this->Item->get_info($item_id);
				$item['unit_price'] = $item_details->unit_price;
				$item['price'] = $item_details->unit_price;
				$item['cost_price'] = $item_details->cost_price;
			}
			//get current variation attributes
			$current_attributes = $this->Item_variations->get_attributes($variation_id);
			$attribute_group = array();
			foreach ($current_attributes as $k => $v) {
				$attribute_group[] = $v['value'];
			}

			sort($attribute_group);

			//get variations for selected supplier
			$item_variations = $this->item->get_variations_for_item_based_on_supplier($item_id, $supplier_id);
			$variation_group = array();
			foreach ($item_variations as $k => $v) {
				$variation_group[] = $v->id;
			}
			sort($variation_group);

			//get new variation based on selected supplier
			if (!empty($attribute_group) && !empty($variation_group)) {
				$variation_id = $this->Item->get_new_variation_based_on_selected_supplier($attribute_group, $variation_group);


				if ($variation_id) {
					$item['variation_id'] = $variation_id;
					$item = $this->edit_item_variation_speedy($item, $variation_id, $item_id);
				} else {
					// error
				}
			} else {
				// error
			}
		} else {
			// error
			// echo "error";
		}

		echo json_encode($item);
	}

	public function edit_item_variation_speedy($item, $variation_id, $item_id)
	{
		// $this->cart->was_last_edit_quantity = false;


		$var_item_info = $this->Item_variations->get_item_info_for_variation($variation_id);

		// dd($var_item_info);

		if ($item_id == $var_item_info->item_id) {


			$item['variation_id'] = $variation_id;

			$item['variation_name'] = $this->Item_variations->get_variation_name($variation_id);

			//Get new price when switching variations
			$item['unit_price'] = $this->Item->get_sale_price(array('item_id' => $item_id, 'tier_id' => (isset($item['tier_id'])) ? $item['tier_id'] : 0, 'variation_id' => $variation_id, 'quantity_unit_quantity' => (isset($item['quantity_unit_quantity'])) ? $item['quantity_unit_quantity'] : 0));
			$cur_item_variation_info = $this->Item_variations->get_info($item['variation_id']);
			$item['variation_name'] = $item['variation_name'];
			$cur_item_variation_location_info = $this->Item_variation_location->get_info($item['variation_id']);

			if ($cur_item_variation_location_info->cost_price) {
				$item['cost_price'] = $cur_item_variation_location_info->cost_price;
			} elseif ($cur_item_variation_info->cost_price) {
				$item['cost_price'] = $cur_item_variation_info->cost_price;
			}

			if ($cur_item_variation_location_info->unit_price) {
				$item['regular_price'] = $cur_item_variation_location_info->unit_price;
			} elseif ($cur_item_variation_info->unit_price) {
				$item['regular_price'] = $cur_item_variation_info->unit_price;
			}
		}

		return $item;
	}


	function set_quantity_unit_id_speedy()
	{
		$item = json_decode($this->input->post('item'), TRUE);
		$quantity_unit_id = $this->input->post('quantity_unit_id');
		$item_id = 0;
		$variation_id = 0;
		if (strpos($item['item_id'], '#') !== false) {
			$exp = explode("#", $item['item_id']);
			$item_id = $exp[0];
			$variation_id = $exp[1];
		} else {
			$item_id = $item['item_id'];
		}
		$qui = $this->Item->get_quantity_unit_info($quantity_unit_id);
		$cur_item_info = $this->Item->get_info($item_id);


		$cur_item_location_info = $this->Item_location->get_info($item['item_id']);

		$this->load->model('Item_variations');
		$this->load->model('Item_variation_location');

		$cur_item_variation_info = $this->Item_variations->get_info($variation_id);


		$cur_item_variation_location_info = $this->Item_variation_location->get_info($variation_id);




		if ($qui !== NULL) {
			$item['quantity_unit_quantity'] = $qui->unit_quantity;
			$item['quantity_unit_id'] = $quantity_unit_id;
			if ($qui->unit_price !== NULL) {
				$item['unit_price'] = $qui->unit_price;
			} else {
				$item['unit_price'] = $this->Item->get_sale_price(array('item_id' => $item_id, 'tier_id' => (isset($item['tier_id'])) ? $item['tier_id'] : 0, 'variation_id' => $variation_id, 'quantity_unit_quantity' =>  $item['quantity_unit_quantity']));
			}

			$item['regular_price'] = $item['unit_price'];

			//  echo $variation_id;


			if ($qui->cost_price !== NULL) {
				$item['cost_price'] = $qui->cost_price;
			} else {
				if (($cur_item_variation_info && $cur_item_variation_info->cost_price) || ($cur_item_variation_location_info && $cur_item_variation_location_info->cost_price)) {
					$item['cost_price'] = $cur_item_variation_location_info->cost_price ? $cur_item_variation_location_info->cost_price : $cur_item_variation_info->cost_price;
				} else {
					$item['cost_price'] = ($cur_item_location_info && $cur_item_location_info->cost_price) ? $cur_item_location_info->cost_price : $cur_item_info->cost_price;
				}

				$item['cost_price'] = $item->cost_price * $item->quantity_unit_quantity;
			}
			$items[0] = $item;
			$item =  $this->sale->determine_new_prices_for_tier_change_speedy($items)[0];
		} else //Didn't select quantity unit; reset to be empty
		{
			$item['quantity_unit_quantity'] = NULL;
			$item['quantity_unit_id'] = NULL;
			$item['unit_price'] = $this->Item->get_sale_price(array('item_id' => $item_id, 'tier_id' => (isset($item['tier_id'])) ? $item['tier_id'] : 0, 'variation_id' => $variation_id, 'quantity_unit_quantity' =>  $item['quantity_unit_quantity']));
			$item['regular_price'] = $item['unit_price'];

			if (($cur_item_variation_info && $cur_item_variation_info->cost_price) || ($cur_item_variation_location_info && $cur_item_variation_location_info->cost_price)) {
				$item['cost_price'] = $cur_item_variation_location_info->cost_price ? $cur_item_variation_location_info->cost_price : $cur_item_variation_info->cost_price;
			} else {
				$item['cost_price'] = ($cur_item_location_info && $cur_item_location_info->cost_price) ? $cur_item_location_info->cost_price : $cur_item_info->cost_price;
			}
		}

		$item['price']  = $item['unit_price'];
		$item['orig_price']  = $item['unit_price'];
		echo json_encode($item);
	}

	function set_tier_id_speedy()
	{

		$sales = json_decode($this->input->post('offline_sales'), TRUE);

		$tier_id = $this->input->post('tier_id');
		$previous_tire_id = $this->input->post('previous_tier_id');

		// // dd($sales[0]);
		$data = $this->sale->determine_new_prices_for_tier_change_speedy($sales[0]['items'], $previous_tire_id, $tier_id);



		$sales[0]['items'] = $data;
		// echo $this->input->post('only_current') . $tier_id;
		if ($this->input->post('only_current') === "false") {

			$sales[0]['extra']['tier_id'] =  $tier_id;
		}

		echo json_encode($sales[0]);
	}

	function set_price_rule_speedy()
	{
		$coupons = $this->input->post('coupons');
		if ($this->input->post('all_items') == 'true') {
			$items = json_decode($this->input->post('items'), TRUE);

			$items_duplicate = [];

			$CI = &get_instance();
			$this->cart->destroy();
			// $this->cart->save();


			$j = 0;
			// dd($items );
			foreach ($items as $item) {
				if (isset($item['free_item']) && $item['free_item'] == true) {
					// echo "yes";

				} else {
					$items_duplicate[$j] = $item;
					$fee_item = new PHPPOSCartItemSale(array('cart' => $this->cart, 'scan' => $item['item_id'] . '|FORCE_ITEM_ID|', 'cost_price' => 0, 'unit_price' => $item['orig_price'], 'description' =>  $item['description'] . ' ' . lang('fee'), 'quantity' => $item['quantity']));
					$this->cart->process_barcode_scan($fee_item->scan, array('quantity' => $fee_item->quantity, 'run_price_rules' => true, 'secondary_supplier_id' => $fee_item->secondary_supplier_id, 'default_supplier_id' => $fee_item->supplier_id));
					$this->cart->save();
					$j++;
				}
			}
			// echo "coup";
			// dd(  $coupons['coupons'][0]);
			// dd($items_duplicate);

			if ((isset($coupons['coupons']))) {
				// echo "coupons";
				$this->cart->set_coupons($coupons['coupons']);
				$this->cart->save();
			}
			$items_all = $this->cart->get_items();

			// dd($items_all);
			$i = 0;
			$scan = [];
			foreach ($items_all as $item_all) {

				// print_r($item_all->rule);


				// echo $item_all->scan;
				$index = array_search($item_all->scan, $scan);

				if ($index !== false) {

					// echo $index;
					// items this is buy x quantity

					$items_duplicate[$i] = $items_duplicate[$index];
					$items_duplicate[$i]['quantity'] = $item_all->quantity;
					$items_duplicate[$i]['cost_price'] = 0;
					$items_duplicate[$i]['price'] = 0.00;
					$items_duplicate[$i]['orig_price'] = 0.00;
					$items_duplicate[$i]['free_item'] = true;


					// dd($items_duplicate[$i]);;
				}

				if ($item_all->rule && isset($item_all->rule['discount_per_unit_percent'])) {
					$items_duplicate[$i]['discount_percent'] = $item_all->rule['discount_per_unit_percent'];
				} else {
					$items_duplicate[$i]['discount_percent'] = 0;
				}

				if ($item_all->rule && isset($item_all->rule['discount_per_unit_fixed'])) {
					$items_duplicate[$i]['discount_per_unit_fixed'] = $item_all->rule['discount_per_unit_fixed'];
				} else {
					$items_duplicate[$i]['discount_per_unit_fixed'] = 0;
				}
				if ($item_all->rule) {
					$items_duplicate[$i]['selected_rule'] = $item_all->rule;
					// dd($item_all);
					// $item_all->all_data->rules = $item_all->rule;
				}

				if ($item_all->change_cost_price) {
					$items_duplicate[$i]['price'] = $item_all->unit_price;
				}

				$items_duplicate[$i]['tier_id'] = 0;
				$scan[$i] = $item_all->scan;
				$i++;
			}

			$items = $items_duplicate;

			$this->cart->destroy();
			echo json_encode($items_duplicate);
		} else {


			$item = json_decode($this->input->post('item'), TRUE);


			$CI = &get_instance();
			$this->cart->destroy();

			$fee_item = new PHPPOSCartItemSale(array('cart' => $this->cart, 'scan' => $item['item_id'] . '|FORCE_ITEM_ID|', 'cost_price' => 0, 'unit_price' => $item['orig_price'], 'description' =>  $item['description'] . ' ' . lang('fee'), 'quantity' => $item['quantity']));
			$this->cart->process_barcode_scan($fee_item->scan, array('quantity' => $fee_item->quantity, 'run_price_rules' => TRUE, 'secondary_supplier_id' => $fee_item->secondary_supplier_id, 'default_supplier_id' => $fee_item->supplier_id));
			$this->cart->save();
			$this->cart->set_coupons((isset($coupons['coupons'])) ? $coupons['coupons'][0] : []);
			$items = $this->cart->get_items();
			// dd($items[0]);
			if ($items[0]->rule && isset($items[0]->rule['discount_per_unit_percent'])) {
				$item['discount_percent'] = $items[0]->rule['discount_per_unit_percent'];
			} else {
				$item['discount_percent'] = 0;
			}

			if ($items[0]->rule && isset($items[0]->rule['discount_per_unit_fixed'])) {
				$item['discount_per_unit_fixed'] = $items[0]->rule['discount_per_unit_fixed'];
			} else {
				$item['discount_per_unit_fixed'] = 0;
			}

			$item['selected_rule'] = $items[0]->rule;
			if ($items[0]->change_cost_price) {
				$item['price'] = $items[0]->unit_price;
			}

			$item['tier_id'] = 0;

			$this->cart->destroy();
			echo json_encode($item);
		}
	}


	function set_tier_id()
	{
		$data = array();
		$this->cart->previous_tier_id = $this->cart->selected_tier_id;
		$this->cart->selected_tier_id = $this->input->post('tier_id');

		$items = $this->cart->get_items();

		//Remove any rules
		foreach ($items as $line => $item) {
			if (!empty($item->rule)) {
				if ($this->Price_rule->is_rule_excluded_by_tier($item->rule)) {
					$this->cart->get_item($line)->rule = array();
					$this->cart->get_item($line)->unit_price = $this->cart->get_item($line)->regular_price;
					$this->cart->get_item($line)->discount = 0;
				}
			}
		}

		$this->cart->determine_new_prices_for_tier_change();

		foreach ($items as $line => $item) {
			if ($item->below_cost_price()) {
				if ($this->config->item('do_not_allow_below_cost')) {
					//switch previous tier to what we posted and the current tier to what we had before; then determine new prices
					$this->cart->selected_tier_id = $this->cart->previous_tier_id;
					$this->cart->previous_tier_id = $this->input->post('tier_id');
					$this->cart->determine_new_prices_for_tier_change();
					$data['error'] = lang('sales_selling_item_below_cost');
					break;
				} else {
					$data['warning'] = lang('sales_selling_item_below_cost');
				}
			}
		}

		$this->cart->save();
		$this->sales_reload($data);
	}

	function set_sold_by_employee_id()
	{
		$this->cart->sold_by_employee_id = $this->input->post('sold_by_employee_id') ? $this->input->post('sold_by_employee_id') : NULL;

		if ($this->config->item('default_sales_person') != 'not_set' && !$this->cart->sold_by_employee_id) {
			$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
			$this->cart->sold_by_employee_id = $employee_id;
		}

		$this->cart->save();
	}




	function payment_check($amount)
	{
		return ($amount != '0' || $this->cart->get_total() == 0) && is_numeric($amount);
	}


	function check_coupon_offline()
	{
		$data['success'] = true;
		$data['error'] = '';
		$rule = $this->Price_rule->get_price_rule_by_coupon_code($this->input->post('term'));

		if ($rule) {
			$data['success'] = true;
			$data['data'] = array('value' => $rule->id, 'label' => $rule->name . ' - ' . $rule->coupon_code);
		} else {
			$data['error'] = lang('coupon_not_found');
			$data['success'] = false;
		}
		echo json_encode($data);
	}

	function search_coupons()
	{
		//allow parallel searchs to improve performance.
		session_write_close();

		$suggestions = $this->Price_rule->search_coupons($this->input->get('term'));
		$result = array();

		foreach ($suggestions as $k => $v) {
			if (!empty($v['coupon_code'])) {
				$result[$k] = array('value' => $v['value'], 'label' => $v['label'] . ' - ' . $v['coupon_code']);
			}
		}

		echo json_encode(H($result));
	}

	function set_coupons()
	{
		$data = array();
		$this->cart->set_coupons($this->input->post('coupons'));
		$this->cart->save();
		$this->sales_reload($data);
	}


	public function check_gift_Card_offline()
	{
		$data['success'] = true;
		$data['error'] = '';

		$giftcard_number = $this->input->post('amount_tendered');
		$giftcard_id = $this->Giftcard->get_giftcard_id($giftcard_number);
		$data['balance'] = 0;

		if (
			!$this->Giftcard->exists($giftcard_id) ||
			$this->Giftcard->is_integrated($giftcard_id) ||
			$this->Giftcard->is_inactive($giftcard_id)
		) {
			$data['success'] = false;
			$data['error'] = lang('sales_giftcard_does_not_exist');
		} else {
			$data['balance'] = $this->Giftcard->get_giftcard_value($giftcard_number);
		}

		echo json_encode($data);
	}

	//Alain Multiple Payments
	function add_payment()
	{
		
		//Percent of amount due
		if (strpos($this->input->post('amount_tendered'), '%') !== FALSE) {
			$percentage = (float)$this->input->post('amount_tendered');
			$_POST['amount_tendered'] = $this->cart->get_amount_due() * ($percentage / 100);
		}

		$data = array();
		$this->form_validation->set_rules('amount_tendered', 'lang:sales_amount_tendered', 'required|callback_payment_check');

		if ($this->input->post('payment_type') !== lang('giftcard')) {
			if ($this->form_validation->run() == FALSE) {

				if ($this->input->post('amount_tendered') == '0' && $this->cart->get_total() != 0) {
					if ($this->cart->get_amount_due() != 0) {
						$data['error'] = lang('cannot_add_zero_payment');
					}
				} else {
					$data['error'] = lang('must_enter_numeric');
				}

				$this->sales_reload($data);
				return;
			}
		}

		if ($this->cart->has_series_packages() && !$this->cart->customer_id) {
			$data['error'] = lang('sales_customer_required_store_account');
			$this->sales_reload($data);
			return;
		}

		if ($this->cart->get_mode() == 'purchase_points'  && !$this->cart->customer_id) {
			$data['error'] = lang('sales_customer_required_store_account');
			$this->sales_reload($data);
			return;
		}

		if (($this->input->post('payment_type') == lang('store_account') && !$this->cart->customer_id) ||
			($this->cart->get_mode() == 'store_account_payment' && !$this->cart->customer_id)
		) {
			$data['error'] = lang('sales_customer_required_store_account');
			$this->sales_reload($data);
			return;
		}

		$store_account_payment_amount = $this->cart->get_total();

		if ($this->cart->get_mode() == 'store_account_payment'  && $store_account_payment_amount == 0) {
			$data['error'] = lang('store_account_payment_item_must_not_be_0');
			$this->sales_reload($data);
			return;
		}

		$this->load->helper('sale');
		if ((is_sale_integrated_cc_processing($this->cart) && $this->input->post('payment_type') == lang('credit')) || is_sale_integrated_ebt_sale($this->cart)) {
			$data['error'] = lang('sales_process_card_first');
			$this->sales_reload($data);
			return;
		}

		if ((is_sale_integrated_giftcard_processing($this->cart) && $this->input->post('payment_type') == lang('integrated_gift_card')) || is_sale_integrated_giftcard_processing($this->cart)) {
			$data['error'] = lang('sales_process_card_first');
			$this->sales_reload($data);
			return;
		}

		if ((is_sale_integrated_ebt_sale($this->cart) && ($this->input->post('payment_type') == lang('ebt') ||  $this->input->post('payment_type') == lang('ebt_cash'))) || is_sale_integrated_cc_processing($this->cart)) {
			$data['sales_reload'] = lang('sales_process_card_first');
			$this->sales_reload($data);
			return;
		}

		if (($this->input->post('payment_type') == lang('ebt') && ($this->input->post('amount_tendered') + $this->cart->get_payment_amount(lang('wic')) + $this->cart->get_payment_amount(lang('ebt'))) > $this->cart->get_ebt_total_amount_to_charge() + 1e-6) || ($this->input->post('payment_type') == lang('wic') && ($this->input->post('amount_tendered') +  $this->cart->get_payment_amount(lang('ebt')) + $this->cart->get_payment_amount(lang('wic'))) > $this->cart->get_ebt_total_amount_to_charge() + 1e-6)) {
			$data['error'] = lang('sales_ebt_too_high');
			$this->sales_reload($data);
			return;
		}

		if ($this->config->item('select_sales_person_during_sale') && !$this->cart->sold_by_employee_id) {
			$data['error'] = lang('sales_must_select_sales_person');
			$this->sales_reload($data);
			return;
		}


		$payment_type = $this->input->post('payment_type');

		if ($payment_type == lang('points')) {
			$customer_info = $this->Customer->get_info($this->cart->customer_id);
			if ($this->input->post('amount_tendered') > to_currency_no_money($customer_info->points) || $this->input->post('amount_tendered') <= 0 || $this->cart->get_amount_due() <= 0) {
				$data['error'] = lang('sales_points_to_much');
				$this->sales_reload($data);
				return;
			}

			if ($this->config->item('minimum_points_to_redeem') && $customer_info->points < $this->config->item('minimum_points_to_redeem')) {
				$data['error'] = lang('sales_points_to_little');
				$this->sales_reload($data);
				return;
			}

			$max_points = ceil($this->cart->get_amount_due() / $this->config->item('point_value'));
			$payment_amount = min($max_points * $this->config->item('point_value'), to_currency_no_money($this->input->post('amount_tendered') * $this->config->item('point_value')), $this->cart->get_amount_due());
		} elseif ($payment_type == lang('giftcard')) {
			if (!$this->Giftcard->exists($this->Giftcard->get_giftcard_id($this->input->post('amount_tendered'))) || $this->Giftcard->is_integrated($this->Giftcard->get_giftcard_id($this->input->post('amount_tendered'))) || $this->Giftcard->is_inactive($this->Giftcard->get_giftcard_id($this->input->post('amount_tendered')))) {
				$data['error'] = lang('sales_giftcard_does_not_exist');

				if ($this->cart->get_total() < 0) {
					$data['prompt_to_create_giftcard'] = $this->input->post('amount_tendered');
				}

				$this->sales_reload($data);
				return;
			}

			$payment_type = $this->input->post('payment_type') . ':' . $this->input->post('amount_tendered');
			$current_payments_with_giftcard = $this->cart->get_payment_amount($payment_type);
			$cur_giftcard_value = $this->Giftcard->get_giftcard_value($this->input->post('amount_tendered')) - $current_payments_with_giftcard;
			if ($cur_giftcard_value <= 0 && $this->cart->get_total() > 0) {
				$data['error'] = lang('sales_giftcard_balance_is') . ' ' . to_currency($this->Giftcard->get_giftcard_value($this->input->post('amount_tendered'))) . ' !';
				$this->sales_reload($data);
				return;
			} elseif (($this->Giftcard->get_giftcard_value($this->input->post('amount_tendered')) - $this->cart->get_total()) > 0) {
				$data['warning'] = lang('sales_giftcard_balance_is') . ' ' . to_currency($this->Giftcard->get_giftcard_value($this->input->post('amount_tendered')) - $this->cart->get_total()) . ' !';
			}
			$payment_amount = min($this->cart->get_amount_due(), $this->Giftcard->get_giftcard_value($this->input->post('amount_tendered')));
		} else {
			$payment_amount = $this->input->post('amount_tendered');
		}

		if (!$this->cart->validate_payment($payment_type, $payment_amount)) {
			$data['error'] = lang('unable_to_add_payment');
			$this->sales_reload($data);
			return;
		}

		$markup_markdown = $this->config->item('markup_markdown');

		if ($markup_markdown && $this->cart->get_total() > 0 && !$this->Location->get_info_for_key('disable_markup_markdown')) {
			$markup_markdown_config = unserialize($markup_markdown);

			if (isset($markup_markdown_config[$this->input->post('payment_type')]) && $markup_markdown_config[$this->input->post('payment_type')]) {
				$fee_percent = $markup_markdown_config[$this->input->post('payment_type')];

				if ($fee_percent > 0) {
					$fee_item_id = $this->Item->create_or_update_fee_item();
				} else {
					$fee_item_id = $this->Item->create_or_update_flat_discount_item();
				}

				$total_payment_amount = $this->cart->get_payments_total($this->input->post('payment_type')) + $payment_amount;

				$total_before_adding_fee = $this->cart->get_total() - ($this->cart->get_total() - $total_payment_amount);
				$fee_item_in_cart_already = $this->cart->find_similiar_item(new PHPPOSCartItemSale(array('cart' => $this->cart, 'scan' => $fee_item_id . '|FORCE_ITEM_ID|')));

				if ($fee_item_in_cart_already) {
					$fee_already_added = $fee_item_in_cart_already->get_total();
				} else {
					$fee_already_added = 0;
				}
				$fee_amount = to_currency_no_money(($this->cart->get_total() - ($this->cart->get_total() - $total_payment_amount) - $fee_already_added) * ($fee_percent / 100));

				$fee_item = new PHPPOSCartItemSale(array('cart' => $this->cart, 'scan' => $fee_item_id . '|FORCE_ITEM_ID|', 'cost_price' => 0, 'unit_price' => $fee_amount, 'description' => $this->input->post('payment_type') . ' ' . lang('fee'), 'quantity' => 1));

				if ($fee_item_in_cart = $this->cart->find_similiar_item($fee_item)) {
					$this->cart->delete_item($this->cart->get_item_index($fee_item_in_cart));
				}
				$this->cart->add_item($fee_item);

				//Only chnage payment amount of the amount is greater than or eqaul than the total (round to fix floating point comparision rounding)
				if (round($payment_amount, 2) >= round($total_before_adding_fee, 2)) {
					$payment_amount += $fee_amount;
				}
			}
		}
		if (!$this->cart->add_payment(new PHPPOSCartPaymentSale(array('payment_type' => $payment_type, 'payment_amount' => $payment_amount)))) {
			
			$data['error'] = lang('unable_to_add_payment');
		}
	
		$this->cart->save();
		if($this->cart->get_mode() == 'store_account_payment'){
			return;
		}

		$this->sales_reload($data);
	}

	function create_return_on_giftcard()
	{
		$giftcard_data = array(
			'giftcard_number' => $this->input->post('giftcard_number'),
			'value' => 0,
			'customer_id' => $this->cart->customer_id ? $this->cart->customer_id : NULL,
		);

		$this->Giftcard->save($giftcard_data);
		$payment_type = lang('giftcard') . ':' . $giftcard_data['giftcard_number'];
		$payment_amount = $this->cart->get_amount_due();
		$this->cart->add_payment(new PHPPOSCartPaymentSale(array('payment_type' => $payment_type, 'payment_amount' => $payment_amount)));
		$this->cart->save();
	}

	//Alain Multiple Payments
	function delete_payment($payment_id)
	{
		$this->cart->delete_payment($payment_id);
		$this->cart->save();
		$this->sales_reload();
	}


	function add_giftcard()
	{
		$barcode_scan_data = $this->input->post("item");
		$quantity = $this->input->post("quantity");

		$item_to_add = new PHPPOSCartItemSale(array('cart' => $this, 'scan' => $barcode_scan_data, 'quantity' => 1, 'unit_price' => null, 'cost_price' => null));
		$this->cart->add_item($item_to_add);
		$this->cart->save();
		$this->_reload();
	}


	function update_cart()
	{
		if ($this->input->post("cart_oc") != null) {
			$cartItems = json_decode($this->input->post("cart_oc"), true);
			$i = 0;
			if ($cartItems !== null) {
				//$cartItems = array_reverse($cartItems);
				foreach ($cartItems as $item) {
					// echo $i."==". $item['price']."==". $item['qty']."<br>";
					$qty =  $item['qty'];

					$this->edit_item_without_reload($i, $sub_line = 0, 'quantity', $qty);
					$i++;
				}
			}
		}
		if (isset($_POST['lastUpdated'])) {

			$data = $this->sales_reload([], true);
			if ($this->config->item('speedy_pos')) {

				if ($this->agent->is_mobile()) {
					$res = $this->load->view("sales/offline/mobile/register_sales_offline", $data, TRUE);
				} else {
					$res = $this->load->view("sales/offline/register_initial_quick_offline", $data, TRUE);
				}
				//offline version mudasir

				//offline version mudasir
			} else {
				$res  = $this->load->view("sales/register_sales", $data, TRUE);
			}


			echo json_encode(['data' => $data,  'html' => $res, 'lastUpdated' =>  $_POST['lastUpdated']]);
		} else {

			$this->sales_reload();
		}
	}
	function add()
	{
		$barcode_scan_data = $this->input->post("item");
		$quantity = $this->input->post("quantity");
		$secondary_supplier_id = $this->input->post("secondary_supplier_id");
		$default_supplier_id = $this->input->post("default_supplier_id");
		if ($this->input->post("cart_oc") != null) {
			$cartItems = json_decode($this->input->post("cart_oc"), true);
			$i = 0;
			if ($cartItems !== null) {
				//$cartItems = array_reverse($cartItems);
				foreach ($cartItems as $item) {
					// echo $i."==". $item['price']."==". $item['qty']."<br>";
					$qty =  $item['qty'];

					$this->edit_item_without_reload($i, $sub_line = 0, 'quantity', $qty);
					$i++;
				}
			}
		}


		$this->cart->sort_clean();
		if ($this->cart->is_valid_receipt($barcode_scan_data) && $this->cart->get_mode() == 'sale') {
			$this->_edit_or_suspend_sale($barcode_scan_data);
			$this->sales_reload();
			return;
		}

		$this->cart->process_barcode_scan($barcode_scan_data, array('quantity' => $quantity, 'run_price_rules' => TRUE, 'secondary_supplier_id' => $secondary_supplier_id, 'default_supplier_id' => $default_supplier_id));
		if ($this->cart->has_recurring_item()) {
			$this->cart->selected_payment = lang('credit');
		}

		$this->cart->save();



		if (isset($_POST['lastUpdated'])) {

			$data = $this->sales_reload([], true);
			if ($this->config->item('speedy_pos')) {

				if ($this->agent->is_mobile()) {
					$res = $this->load->view("sales/offline/mobile/register_sales_offline", $data, TRUE);
				} else {
					$res = $this->load->view("sales/offline/register_initial_quick_offline", $data, TRUE);
				}
				//offline version mudasir

				//offline version mudasir
			} else {
				$res  = $this->load->view("sales/register_sales", $data, TRUE);
			}



			echo json_encode(['html' => $res, 'lastUpdated' =>  $_POST['lastUpdated']]);
		} else {

			$this->sales_reload();
		}
	}

	private function _edit_or_suspend_sale($receipt_sale_id)
	{

		if (!$this->Employee->has_module_action_permission('sales', 'edit_sale', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$data['error'] = lang('error');
			$this->sales_reload($data);
			return;
		}

		$pieces = explode(' ', $receipt_sale_id);

		if (count($pieces) == 2 && strtolower($pieces[0]) == strtolower($this->config->item('sale_prefix') ? $this->config->item('sale_prefix') : 'POS')) {
			$sale_id = $pieces[1];
		} else {
			$sale_id = $receipt_sale_id;
		}

		$this->cart->destroy();
		$this->cart = PHPPOSCartSale::get_instance_from_sale_id($sale_id, 'sale', TRUE);

		$this->cart->save();
	}

	public function edit_item_variation($line)
	{
		$this->cart->was_last_edit_quantity = false;

		if ($item = $this->cart->get_item($line)) {
			$variation_id = $this->input->post('value');
			$var_item_info = $this->Item_variations->get_item_info_for_variation($variation_id);

			if ($item->item_id == $var_item_info->item_id) {


				$item->variation_id = $variation_id;

				$item->variation_name = $this->Item_variations->get_variation_name($variation_id);

				//Get new price when switching variations
				$item->unit_price = $item->get_price_for_item();
				$cur_item_variation_info = $this->Item_variations->get_info($item->variation_id);
				$item->variation_name = $item->variation_name;
				$cur_item_variation_location_info = $this->Item_variation_location->get_info($item->variation_id);

				if ($cur_item_variation_location_info->cost_price) {
					$item->cost_price = $cur_item_variation_location_info->cost_price;
				} elseif ($cur_item_variation_info->cost_price) {
					$item->cost_price = $cur_item_variation_info->cost_price;
				}

				if ($cur_item_variation_location_info->unit_price) {
					$item->regular_price = $cur_item_variation_location_info->unit_price;
				} elseif ($cur_item_variation_info->unit_price) {
					$item->regular_price = $cur_item_variation_info->unit_price;
				}

				$this->cart->save();
			}
		}

		$this->_reload();
	}
	public function edit_item_supplier($line)
	{
		if ($item = $this->cart->get_item($line)) {
			$supplier_id = $this->input->post('value');

			$item->cart_line_supplier_id = $supplier_id;

			if (!$this->Item->has_variations($item->item_id) && $this->Item->has_secondary_supplier($item->item_id)) {
				$secondary_supplier = $this->Item->get_secondary_supplier_details($item->item_id, $supplier_id);

				if ($secondary_supplier) {
					$item->unit_price = $secondary_supplier->unit_price;
					$item->cost_price = $secondary_supplier->cost_price;
				} else {
					$item_details = $this->Item->get_info($item->item_id);
					$item->unit_price = $item_details->unit_price;
					$item->cost_price = $item_details->cost_price;
				}
				$this->cart->save();
				$this->_reload();
			} else if ($this->Item->has_variations($item->item_id) && $this->Item->has_secondary_supplier($item->item_id)) {
				$secondary_supplier = $this->Item->get_secondary_supplier_details($item->item_id, $supplier_id);

				if ($secondary_supplier) {
					$item->unit_price = $secondary_supplier->unit_price;
					$item->cost_price = $secondary_supplier->cost_price;
				} else {
					$item_details = $this->Item->get_info($item->item_id);
					$item->unit_price = $item_details->unit_price;
					$item->cost_price = $item_details->cost_price;
				}
				//get current variation attributes
				$current_attributes = $this->Item_variations->get_attributes($item->variation_id);
				$attribute_group = array();
				foreach ($current_attributes as $k => $v) {
					$attribute_group[] = $v['value'];
				}

				sort($attribute_group);

				//get variations for selected supplier
				$item_variations = $this->item->get_variations_for_item_based_on_supplier($item->item_id, $supplier_id);
				$variation_group = array();
				foreach ($item_variations as $k => $v) {
					$variation_group[] = $v->id;
				}
				sort($variation_group);

				//get new variation based on selected supplier
				if (!empty($attribute_group) && !empty($variation_group)) {
					$variation_id = $this->Item->get_new_variation_based_on_selected_supplier($attribute_group, $variation_group);
					if ($variation_id) {
						$item->variation_id = $variation_id;
						$_POST['value'] = $item->variation_id;
						$this->edit_item_variation($line);
					} else {
						// error
					}
				} else {
					// error
				}
			} else {
				// error
			}
		}
	}

	function edit_line_total($line)
	{


		$this->cart->was_last_edit_quantity = false;

		$data = array();
		$item = $this->cart->get_item($line);
		//Have a copy of item before we change so we can revert
		$item_before_edit = clone $item;

		$total = $this->input->post('value');

		if ($total < 0 && !$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$data['error'] = lang('sales_not_allowed_returns');
			$this->sales_reload($data);
			return;
		}

		$item->unit_price = -1 * ((100 * $total) / ($item->quantity * ($item->discount - 100)));
		$item->has_edit_price = TRUE;

		$can_override_price_adjustments = $this->Employee->get_logged_in_employee_info()->override_price_adjustments;

		$max = $this->cart->get_item($line)->max_edit_price;
		$min = $this->cart->get_item($line)->min_edit_price;

		if (!$can_override_price_adjustments && isset($min) && floatval($item->unit_price) < floatval($min)) {
			$item->unit_price = $min;
			$data['warning'] = lang('sales_could_not_set_item_price_bellow_min') . " " . to_currency($min);
		}

		if (!$can_override_price_adjustments && isset($max) && floatval($item->unit_price) > floatval($max)) {
			$item->unit_price = $max;
			$data['warning'] = lang('sales_could_not_set_item_price_above_max') . " " . to_currency($max);
		}

		$can_edit = TRUE;

		if ($item->below_cost_price()) {
			if ($this->config->item('do_not_allow_below_cost')) {
				$can_edit = FALSE;
				$data['error'] = lang('sales_selling_item_below_cost');
			} else {
				$data['warning'] = lang('sales_selling_item_below_cost');
			}
		}

		//Revert back to previous item
		if (!$can_edit) {
			$item->unit_price = $item_before_edit->unit_price;
		} else {
			$params = array('line' => $line);
			$this->cart->do_price_rules($params);
		}



		$this->cart->save();
		$this->sales_reload($data);
	}
	function edit_item_speedy($line, $sub_line = 0)
	{
		$can_override_price_adjustments = $this->Employee->get_logged_in_employee_info()->override_price_adjustments;
		$this->cart->was_last_edit_quantity = false;

		$data = array();

		if ($this->input->post("name")) {
			$variable = $this->input->post("name");
			$$variable = $this->input->post("value");
		}

		//Do edit fist... we can revert at the end if we aren't allowed to edit
		$item = $this->cart->get_item($line);
		$this->cart->sort_clean();

		if (!$item) {
			echo $this->Customer->get_store_account_details($this->cart, $this->cart->customer_id);
			return;
		}

		if ($variable == 'quantity' && $quantity < 0 && !$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$data['error'] = lang('sales_not_allowed_returns');
			echo $this->Customer->get_store_account_details($this->cart, $this->cart->customer_id);
			return;
		}

		if ($variable == 'unit_price' && $unit_price < 0 && !$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$data['error'] = lang('sales_not_allowed_returns');
			echo $this->Customer->get_store_account_details($this->cart, $this->cart->customer_id);
			return;
		}

		if ($variable == 'modifier_price' && $modifier_price < 0 && !$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$data['error'] = lang('sales_not_allowed_returns');
			echo $this->Customer->get_store_account_details($this->cart, $this->cart->customer_id);
			return;
		}

		//Have a copy of item before we change so we can revert
		$item_before_edit = clone $item;

		//Do change first
		try {
			if ($variable == "modifier_price") {
				$modifier_item_id = $sub_line;

				$modifier_item_info = $this->Item_modifier->get_modifier_item_info($modifier_item_id);
				$display_name = to_currency($$variable) . ': ' . $modifier_item_info['modifier_name'] . ' > ' . $modifier_item_info['modifier_item_name'];
				$item->modifier_items[$modifier_item_id]['display_name'] = $display_name;
				$item->modifier_items[$modifier_item_id]['unit_price'] = $$variable;
			} else {
				$item->$variable = $$variable;
			}

			if ($variable == 'quantity') {
				$this->cart->was_last_edit_quantity = true;
			}

			if ($variable == 'unit_price') {
				$item->has_edit_price = TRUE;
			}

			if ($variable == 'tier_id') {
				$this->load->model('Tier');
				$info = $this->Tier->get_info($item->tier_id);
				$item->tier_name = $info->name;
				if (property_exists($item, 'item_kit_id')) {
					$item->unit_price = $item->get_price_for_item_kit();
				} else {
					$item->unit_price = $item->get_price_for_item();
				}
			}

			if ($variable == 'quantity_unit_id') {
				$qui = $this->Item->get_quantity_unit_info($$variable);

				$cur_item_info = $this->Item->get_info($item->item_id);
				$cur_item_location_info = $this->Item_location->get_info($item->item_id);

				$this->load->model('Item_variations');
				$this->load->model('Item_variation_location');

				$cur_item_variation_info = $this->Item_variations->get_info($item->variation_id);
				$cur_item_variation_location_info = $this->Item_variation_location->get_info($item->variation_id);

				if ($qui !== NULL) {
					$item->quantity_unit_quantity = $qui->unit_quantity;

					if ($qui->unit_price !== NULL) {
						$item->unit_price = $qui->unit_price;
					} else {
						$item->unit_price = $item->get_price_for_item();
					}

					$item->regular_price = $item->unit_price;

					if ($qui->cost_price !== NULL) {
						$item->cost_price = $qui->cost_price;
					} else {
						if (($cur_item_variation_info && $cur_item_variation_info->cost_price) || ($cur_item_variation_location_info && $cur_item_variation_location_info->cost_price)) {
							$item->cost_price = $cur_item_variation_location_info->cost_price ? $cur_item_variation_location_info->cost_price : $cur_item_variation_info->cost_price;
						} else {
							$item->cost_price = ($cur_item_location_info && $cur_item_location_info->cost_price) ? $cur_item_location_info->cost_price : $cur_item_info->cost_price;
						}

						$item->cost_price = $item->cost_price * $item->quantity_unit_quantity;
					}

					$this->cart->determine_new_prices_for_tier_change();
				} else //Didn't select quantity unit; reset to be empty
				{
					$item->quantity_unit_quantity = NULL;
					$item->$variable = NULL;
					$item->unit_price = $item->get_price_for_item();
					$item->regular_price = $item->unit_price;

					if (($cur_item_variation_info && $cur_item_variation_info->cost_price) || ($cur_item_variation_location_info && $cur_item_variation_location_info->cost_price)) {
						$item->cost_price = $cur_item_variation_location_info->cost_price ? $cur_item_variation_location_info->cost_price : $cur_item_variation_info->cost_price;
					} else {
						$item->cost_price = ($cur_item_location_info && $cur_item_location_info->cost_price) ? $cur_item_location_info->cost_price : $cur_item_info->cost_price;
					}
				}
			}
		} catch (Exception $e) {
			echo $this->Customer->get_store_account_details($this->cart, $this->cart->customer_id);
			return;
		}

		if (isset($serialnumber)) {
			$serial_number_price = $this->Item_serial_number->get_price_for_serial($serialnumber);
			if ($serial_number_price !== FALSE) {
				$item->unit_price = $serial_number_price;
			}

			$serial_number_cost_price = $this->Item_serial_number->get_cost_price_for_serial($serialnumber);
			if ($serial_number_cost_price !== FALSE) {
				$item->cost_price = $serial_number_cost_price;
			}
		}


		if (isset($discount) && $discount !== NULL) {
			if ($discount == '') {
				$item->discount = 0;
			}

			$max_discount = $this->cart->get_item($line)->max_discount_percent;

			//Try employee
			if (!$can_override_price_adjustments && $max_discount === NULL) {
				$max_discount = $this->Employee->get_logged_in_employee_info()->max_discount_percent;
			}

			//Try globally
			if (!$can_override_price_adjustments && $max_discount === NULL) {
				$max_discount = $this->config->item('max_discount_percent') !== '' ? $this->config->item('max_discount_percent') : NULL;
			}

			if (!$can_override_price_adjustments & $max_discount !== NULL && floatval($discount) > floatval($max_discount)) {
				$item->discount = $max_discount;
				$data['warning'] = lang('sales_could_not_discount_item_above_max') . " " . to_percent($max_discount);
			}
		}

		$can_edit = TRUE;

		if ($this->config->item('do_not_allow_out_of_stock_items_to_be_sold')) {
			if (isset($quantity)) {
				$current_item = $this->cart->get_item($line);

				if ($this->cart->get_mode() != 'estimate' && $current_item->out_of_stock()) {
					$can_edit = FALSE;
				}
			}

			if (!$can_edit) {
				$data['error'] = lang('sales_unable_to_add_item_out_of_stock');
			}
		}

		if ($item->only_integer && $item->quantity != (int)$item->quantity) {
			$data['error'] = lang('must_be_whole_number');
			$can_edit = FALSE;
		}


		if ($can_edit && isset($unit_price)) {
			$max = $this->cart->get_item($line)->max_edit_price;
			$min = $this->cart->get_item($line)->min_edit_price;

			if (!$can_override_price_adjustments && isset($min) && floatval($unit_price) < floatval($min)) {
				$item->unit_price = $min;
				$data['warning'] = lang('sales_could_not_set_item_price_bellow_min') . " " . to_currency($min);
			}

			if (!$can_override_price_adjustments && isset($max) && floatval($unit_price) > floatval($max)) {
				$item->unit_price = $max;
				$data['warning'] = lang('sales_could_not_set_item_price_above_max') . " " . to_currency($max);
			}
		}

		if ($this->cart->get_item($line)->out_of_stock() && !$this->config->item('do_not_allow_out_of_stock_items_to_be_sold')) {
			$data['warning'] = lang('sales_quantity_less_than_zero');
		}

		if ($item->below_cost_price()) {
			if ($this->config->item('do_not_allow_below_cost')) {
				$can_edit = FALSE;
				$data['error'] = lang('sales_selling_item_below_cost');
			} else {
				$data['warning'] = lang('sales_selling_item_below_cost');
			}
		}


		//Revert back to previous item
		if (!$can_edit) {
			if ($variable == "modifier_price") {
				$modifier_item_id = $sub_line;
				$item->modifier_items[$modifier_item_id]['unit_price'] = $item_before_edit->modifier_items[$modifier_item_id]['unit_price'];
			} else {
				$item->$variable = $item_before_edit->$variable;
			}

			if ($variable == 'quantity_unit_id') {
				$item->unit_price = $item_before_edit->unit_price;
				$item->cost_price = $item_before_edit->cost_price;
			}
		} else {
			$params = array('line' => $line);
			$this->cart->do_price_rules($params);
		}


		//Reset so we don't break price rules when adding an item after an edit
		$this->cart->was_last_edit_quantity = false;

		$this->cart->save();
		echo $this->Customer->get_store_account_details($this->cart, $this->cart->customer_id);
	}
	function edit_item($line, $sub_line = 0)
	{
		$can_override_price_adjustments = $this->Employee->get_logged_in_employee_info()->override_price_adjustments;
		$this->cart->was_last_edit_quantity = false;

		$data = array();

		if ($this->input->post("name")) {
			$variable = $this->input->post("name");
			$$variable = $this->input->post("value");
		}

		//Do edit fist... we can revert at the end if we aren't allowed to edit
		$item = $this->cart->get_item($line);
		$this->cart->sort_clean();

		if (!$item) {
			$this->sales_reload($data);
			return;
		}

		if ($variable == 'quantity' && $quantity < 0 && !$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$data['error'] = lang('sales_not_allowed_returns');
			$this->sales_reload($data);
			return;
		}

		if ($variable == 'unit_price' && $unit_price < 0 && !$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$data['error'] = lang('sales_not_allowed_returns');
			$this->sales_reload($data);
			return;
		}

		if ($variable == 'modifier_price' && $modifier_price < 0 && !$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$data['error'] = lang('sales_not_allowed_returns');
			$this->sales_reload($data);
			return;
		}

		//Have a copy of item before we change so we can revert
		$item_before_edit = clone $item;

		//Do change first
		try {
			if ($variable == "modifier_price") {
				$modifier_item_id = $sub_line;

				$modifier_item_info = $this->Item_modifier->get_modifier_item_info($modifier_item_id);
				$display_name = to_currency($$variable) . ': ' . $modifier_item_info['modifier_name'] . ' > ' . $modifier_item_info['modifier_item_name'];
				$item->modifier_items[$modifier_item_id]['display_name'] = $display_name;
				$item->modifier_items[$modifier_item_id]['unit_price'] = $$variable;
			} else {
				$item->$variable = $$variable;
			}

			if ($variable == 'quantity') {
				$this->cart->was_last_edit_quantity = true;
			}

			if ($variable == 'unit_price') {
				$item->has_edit_price = TRUE;
			}

			if ($variable == 'tier_id') {
				$this->load->model('Tier');
				$info = $this->Tier->get_info($item->tier_id);
				$item->tier_name = $info->name;
				if (property_exists($item, 'item_kit_id')) {
					$item->unit_price = $item->get_price_for_item_kit();
				} else {
					$item->unit_price = $item->get_price_for_item();
				}
			}

			if ($variable == 'quantity_unit_id') {
				$qui = $this->Item->get_quantity_unit_info($$variable);

				$cur_item_info = $this->Item->get_info($item->item_id);
				$cur_item_location_info = $this->Item_location->get_info($item->item_id);

				$this->load->model('Item_variations');
				$this->load->model('Item_variation_location');

				$cur_item_variation_info = $this->Item_variations->get_info($item->variation_id);
				$cur_item_variation_location_info = $this->Item_variation_location->get_info($item->variation_id);

				if ($qui !== NULL) {
					$item->quantity_unit_quantity = $qui->unit_quantity;

					if ($qui->unit_price !== NULL) {
						$item->unit_price = $qui->unit_price;
					} else {
						$item->unit_price = $item->get_price_for_item();
					}

					$item->regular_price = $item->unit_price;

					if ($qui->cost_price !== NULL) {
						$item->cost_price = $qui->cost_price;
					} else {
						if (($cur_item_variation_info && $cur_item_variation_info->cost_price) || ($cur_item_variation_location_info && $cur_item_variation_location_info->cost_price)) {
							$item->cost_price = $cur_item_variation_location_info->cost_price ? $cur_item_variation_location_info->cost_price : $cur_item_variation_info->cost_price;
						} else {
							$item->cost_price = ($cur_item_location_info && $cur_item_location_info->cost_price) ? $cur_item_location_info->cost_price : $cur_item_info->cost_price;
						}

						$item->cost_price = $item->cost_price * $item->quantity_unit_quantity;
					}

					$this->cart->determine_new_prices_for_tier_change();
				} else //Didn't select quantity unit; reset to be empty
				{
					$item->quantity_unit_quantity = NULL;
					$item->$variable = NULL;
					$item->unit_price = $item->get_price_for_item();
					$item->regular_price = $item->unit_price;

					if (($cur_item_variation_info && $cur_item_variation_info->cost_price) || ($cur_item_variation_location_info && $cur_item_variation_location_info->cost_price)) {
						$item->cost_price = $cur_item_variation_location_info->cost_price ? $cur_item_variation_location_info->cost_price : $cur_item_variation_info->cost_price;
					} else {
						$item->cost_price = ($cur_item_location_info && $cur_item_location_info->cost_price) ? $cur_item_location_info->cost_price : $cur_item_info->cost_price;
					}
				}
			}
		} catch (Exception $e) {
			$this->sales_reload($data);
			return;
		}

		if (isset($serialnumber)) {
			$serial_number_price = $this->Item_serial_number->get_price_for_serial($serialnumber);
			if ($serial_number_price !== FALSE) {
				$item->unit_price = $serial_number_price;
			}

			$serial_number_cost_price = $this->Item_serial_number->get_cost_price_for_serial($serialnumber);
			if ($serial_number_cost_price !== FALSE) {
				$item->cost_price = $serial_number_cost_price;
			}
		}


		if (isset($discount) && $discount !== NULL) {
			if ($discount == '') {
				$item->discount = 0;
			}

			$max_discount = $this->cart->get_item($line)->max_discount_percent;

			//Try employee
			if (!$can_override_price_adjustments && $max_discount === NULL) {
				$max_discount = $this->Employee->get_logged_in_employee_info()->max_discount_percent;
			}

			//Try globally
			if (!$can_override_price_adjustments && $max_discount === NULL) {
				$max_discount = $this->config->item('max_discount_percent') !== '' ? $this->config->item('max_discount_percent') : NULL;
			}

			if (!$can_override_price_adjustments & $max_discount !== NULL && floatval($discount) > floatval($max_discount)) {
				$item->discount = $max_discount;
				$data['warning'] = lang('sales_could_not_discount_item_above_max') . " " . to_percent($max_discount);
			}
		}

		$can_edit = TRUE;

		if ($this->config->item('do_not_allow_out_of_stock_items_to_be_sold')) {
			if (isset($quantity)) {
				$current_item = $this->cart->get_item($line);

				if ($this->cart->get_mode() != 'estimate' && $current_item->out_of_stock()) {
					$can_edit = FALSE;
				}
			}

			if (!$can_edit) {
				$data['error'] = lang('sales_unable_to_add_item_out_of_stock');
			}
		}

		if ($item->only_integer && $item->quantity != (int)$item->quantity) {
			$data['error'] = lang('must_be_whole_number');
			$can_edit = FALSE;
		}


		if ($can_edit && isset($unit_price)) {
			$max = $this->cart->get_item($line)->max_edit_price;
			$min = $this->cart->get_item($line)->min_edit_price;

			if (!$can_override_price_adjustments && isset($min) && floatval($unit_price) < floatval($min)) {
				$item->unit_price = $min;
				$data['warning'] = lang('sales_could_not_set_item_price_bellow_min') . " " . to_currency($min);
			}

			if (!$can_override_price_adjustments && isset($max) && floatval($unit_price) > floatval($max)) {
				$item->unit_price = $max;
				$data['warning'] = lang('sales_could_not_set_item_price_above_max') . " " . to_currency($max);
			}
		}

		if ($this->cart->get_item($line)->out_of_stock() && !$this->config->item('do_not_allow_out_of_stock_items_to_be_sold')) {
			$data['warning'] = lang('sales_quantity_less_than_zero');
		}

		if ($item->below_cost_price()) {
			if ($this->config->item('do_not_allow_below_cost')) {
				$can_edit = FALSE;
				$data['error'] = lang('sales_selling_item_below_cost');
			} else {
				$data['warning'] = lang('sales_selling_item_below_cost');
			}
		}


		//Revert back to previous item
		if (!$can_edit) {
			if ($variable == "modifier_price") {
				$modifier_item_id = $sub_line;
				$item->modifier_items[$modifier_item_id]['unit_price'] = $item_before_edit->modifier_items[$modifier_item_id]['unit_price'];
			} else {
				$item->$variable = $item_before_edit->$variable;
			}

			if ($variable == 'quantity_unit_id') {
				$item->unit_price = $item_before_edit->unit_price;
				$item->cost_price = $item_before_edit->cost_price;
			}
		} else {
			$params = array('line' => $line);
			$this->cart->do_price_rules($params);
		}


		//Reset so we don't break price rules when adding an item after an edit
		$this->cart->was_last_edit_quantity = false;

		$this->cart->save();
		$this->sales_reload($data);
	}
	function edit_item_without_reload($line, $sub_line = 0, $name = '', $value = '')
	{
		$can_override_price_adjustments = $this->Employee->get_logged_in_employee_info()->override_price_adjustments;
		$this->cart->was_last_edit_quantity = false;

		$data = array();


		$variable = $name;
		$$variable = $value;


		//Do edit fist... we can revert at the end if we aren't allowed to edit
		$item = $this->cart->get_item($line);
		$this->cart->sort_clean();

		if (!$item) {
			return;
		}

		if ($variable == 'quantity' && $quantity < 0 && !$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$data['error'] = lang('sales_not_allowed_returns');

			return;
		}

		if ($variable == 'unit_price' && $unit_price < 0 && !$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$data['error'] = lang('sales_not_allowed_returns');

			return;
		}

		if ($variable == 'modifier_price' && $modifier_price < 0 && !$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$data['error'] = lang('sales_not_allowed_returns');

			return;
		}

		//Have a copy of item before we change so we can revert
		$item_before_edit = clone $item;

		//Do change first
		try {
			if ($variable == "modifier_price") {
				$modifier_item_id = $sub_line;

				$modifier_item_info = $this->Item_modifier->get_modifier_item_info($modifier_item_id);
				$display_name = to_currency($$variable) . ': ' . $modifier_item_info['modifier_name'] . ' > ' . $modifier_item_info['modifier_item_name'];
				$item->modifier_items[$modifier_item_id]['display_name'] = $display_name;
				$item->modifier_items[$modifier_item_id]['unit_price'] = $$variable;
			} else {
				$item->$variable = $$variable;
			}

			if ($variable == 'quantity') {
				$this->cart->was_last_edit_quantity = true;
			}

			if ($variable == 'unit_price') {
				$item->has_edit_price = TRUE;
			}

			if ($variable == 'tier_id') {
				$this->load->model('Tier');
				$info = $this->Tier->get_info($item->tier_id);
				$item->tier_name = $info->name;
				if (property_exists($item, 'item_kit_id')) {
					$item->unit_price = $item->get_price_for_item_kit();
				} else {
					$item->unit_price = $item->get_price_for_item();
				}
			}

			if ($variable == 'quantity_unit_id') {
				$qui = $this->Item->get_quantity_unit_info($$variable);

				$cur_item_info = $this->Item->get_info($item->item_id);
				$cur_item_location_info = $this->Item_location->get_info($item->item_id);

				$this->load->model('Item_variations');
				$this->load->model('Item_variation_location');

				$cur_item_variation_info = $this->Item_variations->get_info($item->variation_id);
				$cur_item_variation_location_info = $this->Item_variation_location->get_info($item->variation_id);

				if ($qui !== NULL) {
					$item->quantity_unit_quantity = $qui->unit_quantity;

					if ($qui->unit_price !== NULL) {
						$item->unit_price = $qui->unit_price;
					} else {
						$item->unit_price = $item->get_price_for_item();
					}

					$item->regular_price = $item->unit_price;

					if ($qui->cost_price !== NULL) {
						$item->cost_price = $qui->cost_price;
					} else {
						if (($cur_item_variation_info && $cur_item_variation_info->cost_price) || ($cur_item_variation_location_info && $cur_item_variation_location_info->cost_price)) {
							$item->cost_price = $cur_item_variation_location_info->cost_price ? $cur_item_variation_location_info->cost_price : $cur_item_variation_info->cost_price;
						} else {
							$item->cost_price = ($cur_item_location_info && $cur_item_location_info->cost_price) ? $cur_item_location_info->cost_price : $cur_item_info->cost_price;
						}

						$item->cost_price = $item->cost_price * $item->quantity_unit_quantity;
					}

					$this->cart->determine_new_prices_for_tier_change();
				} else //Didn't select quantity unit; reset to be empty
				{
					$item->quantity_unit_quantity = NULL;
					$item->$variable = NULL;
					$item->unit_price = $item->get_price_for_item();
					$item->regular_price = $item->unit_price;

					if (($cur_item_variation_info && $cur_item_variation_info->cost_price) || ($cur_item_variation_location_info && $cur_item_variation_location_info->cost_price)) {
						$item->cost_price = $cur_item_variation_location_info->cost_price ? $cur_item_variation_location_info->cost_price : $cur_item_variation_info->cost_price;
					} else {
						$item->cost_price = ($cur_item_location_info && $cur_item_location_info->cost_price) ? $cur_item_location_info->cost_price : $cur_item_info->cost_price;
					}
				}
			}
		} catch (Exception $e) {
			return;
		}

		if (isset($serialnumber)) {
			$serial_number_price = $this->Item_serial_number->get_price_for_serial($serialnumber);
			if ($serial_number_price !== FALSE) {
				$item->unit_price = $serial_number_price;
			}

			$serial_number_cost_price = $this->Item_serial_number->get_cost_price_for_serial($serialnumber);
			if ($serial_number_cost_price !== FALSE) {
				$item->cost_price = $serial_number_cost_price;
			}
		}


		if (isset($discount) && $discount !== NULL) {
			if ($discount == '') {
				$item->discount = 0;
			}

			$max_discount = $this->cart->get_item($line)->max_discount_percent;

			//Try employee
			if (!$can_override_price_adjustments && $max_discount === NULL) {
				$max_discount = $this->Employee->get_logged_in_employee_info()->max_discount_percent;
			}

			//Try globally
			if (!$can_override_price_adjustments && $max_discount === NULL) {
				$max_discount = $this->config->item('max_discount_percent') !== '' ? $this->config->item('max_discount_percent') : NULL;
			}

			if (!$can_override_price_adjustments & $max_discount !== NULL && floatval($discount) > floatval($max_discount)) {
				$item->discount = $max_discount;
				$data['warning'] = lang('sales_could_not_discount_item_above_max') . " " . to_percent($max_discount);
			}
		}

		$can_edit = TRUE;

		if ($this->config->item('do_not_allow_out_of_stock_items_to_be_sold')) {
			if (isset($quantity)) {
				$current_item = $this->cart->get_item($line);

				if ($this->cart->get_mode() != 'estimate' && $current_item->out_of_stock()) {
					$can_edit = FALSE;
				}
			}

			if (!$can_edit) {
				$data['error'] = lang('sales_unable_to_add_item_out_of_stock');
			}
		}

		if ($item->only_integer && $item->quantity != (int)$item->quantity) {
			$data['error'] = lang('must_be_whole_number');
			$can_edit = FALSE;
		}


		if ($can_edit && isset($unit_price)) {
			$max = $this->cart->get_item($line)->max_edit_price;
			$min = $this->cart->get_item($line)->min_edit_price;

			if (!$can_override_price_adjustments && isset($min) && floatval($unit_price) < floatval($min)) {
				$item->unit_price = $min;
				$data['warning'] = lang('sales_could_not_set_item_price_bellow_min') . " " . to_currency($min);
			}

			if (!$can_override_price_adjustments && isset($max) && floatval($unit_price) > floatval($max)) {
				$item->unit_price = $max;
				$data['warning'] = lang('sales_could_not_set_item_price_above_max') . " " . to_currency($max);
			}
		}

		if ($this->cart->get_item($line)->out_of_stock() && !$this->config->item('do_not_allow_out_of_stock_items_to_be_sold')) {
			$data['warning'] = lang('sales_quantity_less_than_zero');
		}

		if ($item->below_cost_price()) {
			if ($this->config->item('do_not_allow_below_cost')) {
				$can_edit = FALSE;
				$data['error'] = lang('sales_selling_item_below_cost');
			} else {
				$data['warning'] = lang('sales_selling_item_below_cost');
			}
		}


		//Revert back to previous item
		if (!$can_edit) {;
			if ($variable == "modifier_price") {
				$modifier_item_id = $sub_line;
				$item->modifier_items[$modifier_item_id]['unit_price'] = $item_before_edit->modifier_items[$modifier_item_id]['unit_price'];
			} else {
				$item->$variable = $item_before_edit->$variable;
			}

			if ($variable == 'quantity_unit_id') {
				$item->unit_price = $item_before_edit->unit_price;
				$item->cost_price = $item_before_edit->cost_price;
			}
		} else {
			$params = array('line' => $line);
			$this->cart->do_price_rules($params);
		}



		//Reset so we don't break price rules when adding an item after an edit
		$this->cart->was_last_edit_quantity = false;
		// dd($this->cart);

		$this->cart->save();
	}


	function delete_item($item_line)
	{
		if ($this->cart->get_item($item_line) !== FALSE) {
			if (!$this->cart->is_price_rule_discount_line($item_line)) {
				$cart_item = $this->cart->get_item($item_line);

				if (!$this->config->item('do_not_group_same_items')  && !$cart_item->is_serialized) {
					if (property_exists($cart_item, 'item_kit_id')) {
						$price_rule_params = array('item_kit' => $cart_item);
					} else {
						$price_rule_params = array('item' => $cart_item);
					}
				}
			}

			$this->cart->delete_item($item_line);

			if (isset($price_rule_params)) {
				$price_rule_params['delete'] = TRUE;
				$this->cart->do_price_rules($price_rule_params);
			}

			$this->cart->save();
		}

		if (isset($_POST['lastUpdated'])) {

			$data = $this->sales_reload([], true);
			if ($this->config->item('speedy_pos')) {

				if ($this->agent->is_mobile()) {
					$res = $this->load->view("sales/offline/mobile/register_sales_offline", $data, TRUE);
				} else {
					$res = $this->load->view("sales/offline/register_initial_quick_offline", $data, TRUE);
				}
				//offline version mudasir

				//offline version mudasir
			} else {
				$res  = $this->load->view("sales/register_sales", $data, TRUE);
			}






			echo json_encode(['html' => $res, 'lastUpdated' =>  $_POST['lastUpdated']]);
		} else {

			$this->sales_reload();
		}
	}

	function delete_customer()
	{
		$this->cart->customer_id = NULL;
		$this->cart->previous_tier_id = $this->cart->selected_tier_id;
		$this->cart->selected_tier_id = 0;

		if ($this->cart->previous_tier_id != $this->cart->selected_tier_id) {
			$this->cart->determine_new_prices_for_tier_change();
		}

		$this->cart->delete_payment($this->cart->get_payment_ids(lang('points')));

		$this->cart->save();
		$this->sales_reload();
	}

	function start_cc_processing()
	{
		if ($this->config->item('test_mode')) {
			$this->_reload(array('error' => lang('in_test_mode')), false);
			return;
		}

		if ($this->config->item('do_not_allow_item_with_variations_to_be_sold_without_selecting_variation') && !$this->cart->do_all_variation_items_have_variation_selected()) {
			$this->_reload(array('error' => lang('you_did_not_select_variations_for_applicable_variation_items')), false);
			return;
		}

		$data = $this->_get_shared_data();


		if ($this->config->item('do_not_allow_sales_with_zero_value')) {
			if ($data['total'] == 0) {
				$this->session->set_flashdata('error_if_total_is_zero', lang('error_if_total_is_zero'));
				redirect('sales');
				return;
			};
		}

		if ($this->config->item('do_not_allow_sales_with_zero_value_line_items')) {

			foreach ($this->cart->get_items() as $item) {
				$line_total = $item->unit_price * $item->quantity - $item->unit_price * $item->quantity * $item->discount / 100;
				if ($line_total == 0) {
					$this->session->set_flashdata('error_if_total_is_zero', lang('error_if_total_is_zero_line_item'));
					redirect('sales');
					return;
				};
			}
		}


		if ($data['total'] < 0 && $this->config->item('require_receipt_for_return') && !$this->cart->return_sale_id) {
			$this->_reload(array('error' => lang('sales_receipt_required_for_return')), false);
			return;
		}

		if ($data['total'] < 0 && $this->config->item('require_customer_for_return') && !$this->cart->customer_id) {
			$this->_reload(array('error' => lang('sales_customer_required_for_return')), false);
			return;
		}
		if ($this->_validate_custom_fields() === false) {
			return;
		}

		$cc_amount = round($this->cart->get_payment_amount(lang('credit')), 2);
		$total = round($this->cart->get_total(), 2);

		if ($total >= 0 && $cc_amount > $total) {
			$this->_reload(array('error' => lang('sales_credit_card_payment_is_greater_than_total_cannot_complete')), false);
		} elseif ($total < 0 && $cc_amount < $total) {
			$this->_reload(array('error' => lang('sales_cannot_refund_more_than_sale_total')), false);
		} else {
			$credit_card_processor = $this->_get_cc_processor();

			if ($credit_card_processor) {
				$credit_card_processor->start_cc_processing();
			} else {
				$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
				return;
			}
		}
	}
	function start_cc_processing_square_terminal()
	{
		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor) {
			$credit_card_processor->do_start_cc_processing();
		} else {
			$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
			return;
		}
	}
	public function start_cc_processing_coreclear2()
	{
		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor) {
			$credit_card_processor->do_start_cc_processing();
		} else {
			$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
			return;
		}
	}


	public function start_cc_processing_card_connect()
	{
		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor) {
			$credit_card_processor->do_start_cc_processing();
		} else {
			$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
			return;
		}
	}

	function start_cc_processing_trans_cloud()
	{
		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor) {
			$credit_card_processor->do_start_cc_processing();
		} else {
			$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
			return;
		}
	}

	function finish_cc_processing()
	{
		$credit_card_processor = $this->_get_cc_processor();
		if ($credit_card_processor) {
			$credit_card_processor->finish_cc_processing();
		} else {
			$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
			return;
		}
	}

	function finish_cc_processing_saved_card()
	{
		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor) {
			$credit_card_processor->finish_cc_processing_saved_card();
		} else {
			$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
			return;
		}
	}

	function get_emv_ebt_balance($type = "EBT")
	{
		$credit_card_processor = $this->_get_cc_processor();
		if ($credit_card_processor && method_exists($credit_card_processor, 'get_emv_ebt_balance')) {
			$credit_card_processor->get_emv_ebt_balance($type);
		} else {
			$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
			return;
		}
	}
	function reset_pin_pad()
	{
		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor && method_exists($credit_card_processor, 'pad_reset')) {
			$credit_card_processor->pad_reset();
		} else {
			$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
			return;
		}
	}

	function cancel_cc_processing()
	{
		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor) {
			$credit_card_processor->cancel_cc_processing();
		} else {
			$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
			return;
		}
	}

	function set_sequence_no_emv()
	{
		if ($this->input->post('sequence_no')) {
			$this->session->set_userdata('sequence_no', $this->input->post('sequence_no'));
		}
	}

	function declined()
	{
		$this->load->model('Register_cart');

		$customer_id = $this->cart->customer_id;
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		$sold_by_employee_id = $this->cart->sold_by_employee_id;
		$emp_info = $this->Employee->get_info($employee_id);
		$sale_emp_info = $this->Employee->get_info($sold_by_employee_id);

		$data['is_sale'] = FALSE;
		$data['total'] = $this->cart->get_total();
		$data['receipt_title'] = $this->config->item('override_receipt_title') ? $this->config->item('override_receipt_title') : lang('sales_receipt');
		$data['sales_card_statement'] = $this->config->item('override_signature_text') ? $this->config->item('override_signature_text') : lang('sales_card_statement', '', array(), TRUE);

		$data['transaction_time'] = date(get_date_format() . ' ' . get_time_format());
		$data['payments'] = $this->cart->get_payments();
		$data['register_name'] = $this->Register->get_register_name($this->Employee->get_logged_in_employee_current_register_id());
		$data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name . ($sold_by_employee_id && $sold_by_employee_id != $employee_id ? '/' . $sale_emp_info->first_name . ' ' . $sale_emp_info->last_name : '');

		if ($customer_id) {
			$cust_info = $this->Customer->get_info($customer_id);
			$data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name . ($cust_info->account_number == ''  ? '' : ' - ' . $cust_info->account_number);
			$data['customer_company'] = $cust_info->company_name;
			$data['customer_address_1'] = $cust_info->address_1;
			$data['customer_address_2'] = $cust_info->address_2;
			$data['customer_city'] = $cust_info->city;
			$data['customer_state'] = $cust_info->state;
			$data['customer_zip'] = $cust_info->zip;
			$data['customer_country'] = $cust_info->country;
			$data['customer_phone'] = format_phone_number($cust_info->phone_number);
			$data['customer_email'] = $cust_info->email;
		}

		$data['auth_code'] = $this->session->userdata('auth_code') ? $this->session->userdata('auth_code') : '';
		$data['ref_no'] = $this->session->userdata('ref_no') ? $this->session->userdata('ref_no') : '';
		$data['entry_method'] = $this->session->userdata('entry_method') ? $this->session->userdata('entry_method') : '';
		$data['aid'] = $this->session->userdata('aid') ? $this->session->userdata('aid') : '';
		$data['tvr'] = $this->session->userdata('tvr') ? $this->session->userdata('tvr') : '';
		$data['iad'] = $this->session->userdata('iad') ? $this->session->userdata('iad') : '';
		$data['tsi'] = $this->session->userdata('tsi') ? $this->session->userdata('tsi') : '';
		$data['arc'] = $this->session->userdata('arc') ? $this->session->userdata('arc') : '';
		$data['cvm'] = $this->session->userdata('cvm') ? $this->session->userdata('cvm') : '';
		$data['tran_type'] = $this->session->userdata('tran_type') ? $this->session->userdata('tran_type') : '';
		$data['application_label'] = $this->session->userdata('application_label') ? $this->session->userdata('application_label') : '';
		$data['masked_account'] = $this->session->userdata('masked_account') ? $this->session->userdata('masked_account') : '';
		$data['text_response'] = $this->session->userdata('text_response') ? $this->session->userdata('text_response') : '';
		$this->cart->clear_cc_info();
		$this->load->view("sales/receipt_decline", $data);
	}

	private function _validate_custom_fields()
	{
		$current_location = $this->Employee->get_logged_in_employee_current_location_id();
		for ($k = 1; $k <= NUMBER_OF_PEOPLE_CUSTOM_FIELDS; $k++) {
			$custom_field = $this->Sale->get_custom_field($k);
			if ($custom_field !== FALSE) {
				if ($this->Sale->get_custom_field($k, 'required') && in_array($current_location, $this->Sale->get_custom_field($k, 'locations')) && !$this->cart->{"custom_field_${k}_value"}) {
					$this->_reload(array('error' => $custom_field . ' ' . lang('is_required')), false);
					return FALSE;
				}
			}
		}

		return TRUE;
	}
	function complete($dont_check_validation = false)
	{
		
		if (!$this->Employee->has_module_action_permission('sales', 'complete_sale', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$this->_reload(array('error' => lang('sales_you_do_not_have_permission_to_complete_sales')), false);
			return;
		}

		$email_send = false;
		$sms_receipt = false;

		if ($this->config->item('sort_receipt_column')) {
			$this->cart->sort_items($this->config->item('sort_receipt_column'));
		}

		if ($dont_check_validation == false) {
			if ($this->_validate_custom_fields() === false) {
				return;
			}
		}

		
		$data = $this->_get_shared_data();

		if ($this->config->item('do_not_allow_sales_with_zero_value')) {
			if ($data['total'] == 0) {
				$this->session->set_flashdata('error_if_total_is_zero', lang('error_if_total_is_zero'));
				redirect('sales');
			};
		}
		
		if ($this->config->item('do_not_allow_sales_with_zero_value_line_items')) {

			foreach ($this->cart->get_items() as $item) {
				$line_total = $item->unit_price * $item->quantity - $item->unit_price * $item->quantity * $item->discount / 100;
				if ($line_total == 0) {
					$this->session->set_flashdata('error_if_total_is_zero', lang('error_if_total_is_zero_line_item'));
					redirect('sales');
				};
			}
		}

	
		if ($data['total'] < 0 && $this->config->item('require_receipt_for_return') && !$this->cart->return_sale_id) {
			$this->_reload(array('error' => lang('sales_receipt_required_for_return')), false);
			return;
		}

		if ($data['total'] < 0 && $this->config->item('require_customer_for_return') && !$this->cart->customer_id) {
			$this->_reload(array('error' => lang('sales_customer_required_for_return')), false);
			return;
		}
	
		if ($this->cart->get_mode() == 'estimate') {
			$data['sale_type'] = $this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate');
		}
		$this->load->helper('sale');
		$this->lang->load('deliveries');

		if ($this->config->item('do_not_allow_item_with_variations_to_be_sold_without_selecting_variation') && !$this->cart->do_all_variation_items_have_variation_selected()) {
			$this->_reload(array('error' => lang('you_did_not_select_variations_for_applicable_variation_items')), false);
			return;
		}

		if ($this->cart->get_mode() != 'return' && $this->cart->get_mode() != 'estimate' && $this->config->item('do_not_allow_out_of_stock_items_to_be_sold')) {
			foreach ($this->cart->get_items() as $item) {
				if ($item->out_of_stock()) {
					$this->_reload(array('error' => lang('sales_one_or_more_out_of_stock_items')), false);
					return;
				}
			}
		}
		
		if (!is_all_sale_credit_card_payments_confirmed($this->cart)) {
			///Make sure we have actually processed a transaction before compelting sale
			if (is_sale_integrated_cc_processing($this->cart) && !$this->session->userdata('CC_SUCCESS')) {
				$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
				return;
			}
		}

		if (empty($data['cart_items'])) {
		
			redirect('sales');
		}

		if (!$this->_payments_cover_total()) {
		
			$this->_reload(array('error' => lang('sales_cannot_complete_sale_as_payments_do_not_cover_total')), false);
			return;
		}
		

		$tier_id = $this->cart->selected_tier_id;
		$tier_info = $this->Tier->get_info($tier_id);
		$exchange_rate = $this->cart->get_exchange_rate() ? $this->cart->get_exchange_rate() : 1;

		$data['tier'] = $tier_info->name;
		$data['register_name'] = $this->Register->get_register_name($this->Employee->get_logged_in_employee_current_register_id());
		$data['is_sale'] = TRUE;
		$data['receipt_title'] = $this->config->item('override_receipt_title') ? $this->config->item('override_receipt_title') : (!$this->cart->suspended ? lang('sales_receipt') : '');
		$data['sales_card_statement'] = $this->config->item('override_signature_text') ? $this->config->item('override_signature_text') : lang('sales_card_statement', '', array(), TRUE);
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		$customer_id = $this->cart->customer_id;
		$sold_by_employee_id = $this->cart->sold_by_employee_id;
		$emp_info = $this->Employee->get_info($employee_id);
		$sale_emp_info = $this->Employee->get_info($sold_by_employee_id);
		$data['is_sale_cash_payment'] = $this->cart->has_cash_payment();

		$data['amount_change'] = $this->cart->get_amount_due() * -1;
		$this->session->set_userdata('amount_change', $data['amount_change'] - $this->session->userdata('tip_amount'));

		$store_account_in_all_languages = get_all_language_values_for_key('common_store_account', 'common');

		$data['balance'] = 0;
		//Add up balances for all languages
		foreach ($store_account_in_all_languages as $store_account_lang) {
			//Thanks Mike for math help on how to convert exchange rate back to get correct balance
			$data['balance'] += $this->cart->get_payment_amount($store_account_lang) * pow($exchange_rate, -1);
		}

		$data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name . ($sold_by_employee_id && $sold_by_employee_id != $employee_id ? '/' . $sale_emp_info->first_name . ' ' . $sale_emp_info->last_name : '');
		$data['employee_firstname'] = $emp_info->first_name . ($sold_by_employee_id && $sold_by_employee_id != $employee_id ? '/' . $sale_emp_info->first_name : '');
		$data['ref_no'] = '';
		$data['auth_code'] = '';
		$data['discount_exists'] = $this->_does_discount_exists($data['cart_items']);
		$data['can_email_receipt'] = !$this->cart->email_receipt;
		$data['can_sms_receipt'] = !$this->cart->sms_receipt;
		$masked_account = $this->session->userdata('masked_account') ? $this->session->userdata('masked_account') : '';
		$card_issuer = $this->session->userdata('card_issuer') ? $this->session->userdata('card_issuer') : '';
		$auth_code = $this->session->userdata('auth_code') ? $this->session->userdata('auth_code') : '';
		$ref_no = $this->session->userdata('ref_no') ? $this->session->userdata('ref_no') : '';
		$cc_token = $this->session->userdata('cc_token') ? $this->session->userdata('cc_token') : '';
		$acq_ref_data = $this->session->userdata('acq_ref_data') ? $this->session->userdata('acq_ref_data') : '';
		$process_data = $this->session->userdata('process_data') ? $this->session->userdata('process_data') : '';
		$entry_method = $this->session->userdata('entry_method') ? $this->session->userdata('entry_method') : '';
		$aid = $this->session->userdata('aid') ? $this->session->userdata('aid') : '';
		$tvr = $this->session->userdata('tvr') ? $this->session->userdata('tvr') : '';
		$iad = $this->session->userdata('iad') ? $this->session->userdata('iad') : '';
		$tsi = $this->session->userdata('tsi') ? $this->session->userdata('tsi') : '';
		$arc = $this->session->userdata('arc') ? $this->session->userdata('arc') : '';
		$cvm = $this->session->userdata('cvm') ? $this->session->userdata('cvm') : '';
		$tran_type = $this->session->userdata('tran_type') ? $this->session->userdata('tran_type') : '';
		$application_label = $this->session->userdata('application_label') ? $this->session->userdata('application_label') : '';
		
		if ($ref_no) {
			if (count($this->cart->get_payment_ids(lang('credit'))) || count($this->cart->get_payment_ids(lang('ebt'))) || count($this->cart->get_payment_ids(lang('ebt_cash')))) {
				$cc_payment_id = current($this->cart->get_payment_ids(lang('credit')));
				if ($cc_payment_id !== FALSE) {
					$cc_payment = $data['payments'][$cc_payment_id];
					$this->cart->edit_payment($cc_payment_id, array('payment_type' => $cc_payment->payment_type, 'payment_amount' => $cc_payment->payment_amount, 'payment_date' => $cc_payment->payment_date, 'truncated_card' => $masked_account, 'card_issuer' => $card_issuer, 'auth_code' => $auth_code, 'ref_no' => $ref_no, 'cc_token' => $cc_token, 'acq_ref_data' => $acq_ref_data, 'process_data' => $process_data, 'entry_method' => $entry_method, 'aid' => $aid, 'tvr' => $tvr, 'iad' => $iad, 'tsi' => $tsi, 'arc' => $arc, 'cvm' => $cvm, 'tran_type' => $tran_type, 'application_label' => $application_label));
				}

				$ebt_payment_id = current($this->cart->get_payment_ids(lang('ebt')));
				if ($ebt_payment_id !== FALSE) {
					$ebt_payment = $data['payments'][$ebt_payment_id];

					$ebt_voucher_no = $this->cart->ebt_voucher_no;
					$ebt_auth_code = $this->cart->ebt_auth_code;

					$this->cart->edit_payment($ebt_payment_id, array('payment_type' => $ebt_payment->payment_type, 'payment_amount' => $ebt_payment->payment_amount, 'payment_date' => $ebt_payment->payment_date, 'truncated_card' => $masked_account, 'card_issuer' => $card_issuer, 'auth_code' => $auth_code, 'ref_no' => $ref_no, 'cc_token' => $cc_token, 'acq_ref_data' => $acq_ref_data, 'process_data' => $process_data, 'entry_method' => $entry_method, 'aid' => $aid, 'tvr' => $tvr, 'iad' => $iad, 'tsi' => $tsi, 'arc' => $arc, 'cvm' => $cvm, 'tran_type' => $tran_type, 'application_label' => $application_label, 'ebt_voucher_no' => $ebt_voucher_no, 'ebt_auth_code' => $ebt_auth_code));

					$data['ebt_balance'] = $this->session->userdata('ebt_balance');
				}

				$ebt_cash_payment_id = current($this->cart->get_payment_ids(lang('ebt_cash')));
				if ($ebt_cash_payment_id !== FALSE) {
					$ebt_cash_payment = $data['payments'][$ebt_cash_payment_id];
					$this->cart->edit_payment($ebt_cash_payment_id, array('payment_type' => $ebt_cash_payment->payment_type, 'payment_amount' => $ebt_cash_payment->payment_amount, 'payment_date' => $ebt_cash_payment->payment_date, 'truncated_card' => $masked_account, 'card_issuer' => $card_issuer, 'auth_code' => $auth_code, 'ref_no' => $ref_no, 'cc_token' => $cc_token, 'acq_ref_data' => $acq_ref_data, 'process_data' => $process_data, 'entry_method' => $entry_method, 'aid' => $aid, 'tvr' => $tvr, 'iad' => $iad, 'tsi' => $tsi, 'arc' => $arc, 'cvm' => $cvm, 'tran_type' => $tran_type, 'application_label' => $application_label));

					$data['ebt_balance'] = $this->session->userdata('ebt_balance');
				}

				//Make sure our payments has the latest change to masked_account
				$data['payments'] = $this->cart->get_payments();
			}
		}

		$old_date = $this->cart->get_previous_receipt_id()  ? $this->Sale->get_info($this->cart->get_previous_receipt_id())->row_array() : false;
		$old_date =  $old_date ? date(get_date_format() . ' ' . get_time_format(), strtotime($old_date['sale_time'])) : date(get_date_format() . ' ' . get_time_format());

	
		$suspended_change_sale_id = $this->cart->get_previous_receipt_id();

		$data['store_account_payment'] = $this->cart->get_mode() == 'store_account_payment' ? 1 : 0;
		$data['is_purchase_points'] = $this->cart->get_mode() == 'purchase_points' ? 1 : 0;
		//If we have a suspended sale, update the date for the sale
		$data['change_cart_date'] = FALSE;

		if ($this->cart->change_date_enable) {
			$data['change_cart_date'] = $this->cart->change_cart_date;
			$this->cart->change_date_enable = TRUE;
			$this->cart->change_cart_date = $data['change_cart_date'];
		} elseif ($this->cart->get_previous_receipt_id() && $this->cart->suspended && $this->config->item('change_sale_date_when_completing_suspended_sale')) {
			$data['change_cart_date'] = date('Y-m-d H:i:s');
			$this->cart->change_date_enable = TRUE;
			$this->cart->change_cart_date = $data['change_cart_date'];
		}


		$data['transaction_time'] = $this->cart->change_date_enable ?  date(get_date_format() . ' ' . get_time_format(), strtotime($this->cart->change_cart_date)) : $old_date;

		$this->cart->suspended = 0;

		//SAVE sale to database
		
		$sale_id_raw = $this->Sale->save($this->cart);

		

		$isWorkOrder = $this->work_order->get_info_by_sale_id($sale_id_raw)->row();
		if (isset($isWorkOrder->sale_id)) {

			$this->cart->is_work_order = 1;
		}

		$saved_sale_info = $this->Sale->get_info($sale_id_raw)->row_array();
		if (isset($saved_sale_info['signature_image_id'])) {
			$data['signature_file_id'] = $saved_sale_info['signature_image_id'];
		}

		$tip_amount = $this->session->userdata('tip_amount');

		if ($tip_amount) {
			$sale_data = array('tip' => $tip_amount);
			$this->Sale->update($sale_data, $sale_id_raw);
		}

		//Set exchange details in so receipt has correct info on it (Sale->save clears it out but we need for receipt)
		if ($data['exchange_name']) {
			$this->cart->set_exchange_details($this->Sale->get_exchange_details($sale_id_raw));
			for ($k = 0; $k < count($data['payments']); $k++) {
				$data['payments'][$k]->payment_amount = $data['payments'][$k]->payment_amount * $exchange_rate;
			}
		}

		$data['sale_id'] = $this->config->item('sale_prefix') . ' ' . $sale_id_raw;
		$data['sale_id_raw'] = $sale_id_raw;

		$data['disable_loyalty'] = 0;

		if ($customer_id) {
			$cust_info = $this->Customer->get_info($customer_id);
			$data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name . ($cust_info->account_number == ''  ? '' : ' - ' . $cust_info->account_number);
			$data['customer_company'] = $cust_info->company_name;
			$data['customer_address_1'] = $cust_info->address_1;
			$data['customer_address_2'] = $cust_info->address_2;
			$data['customer_city'] = $cust_info->city;
			$data['customer_state'] = $cust_info->state;
			$data['customer_zip'] = $cust_info->zip;
			$data['customer_country'] = $cust_info->country;
			$data['customer_phone'] = format_phone_number($cust_info->phone_number);
			$data['customer_email'] = $cust_info->email;

			$data['customer_points'] = $cust_info->points;
			$data['sales_until_discount'] = ($this->config->item('number_of_sales_for_discount') ? $this->config->item('number_of_sales_for_discount') : 0) - $cust_info->current_sales_for_discount;
			$data['disable_loyalty'] = $cust_info->disable_loyalty;

			$cust_info = $this->Customer->get_info($customer_id);
			if ($this->config->item('customers_store_accounts')) {
				$data['customer_balance_for_sale'] = $cust_info->balance;
			}
		}


		if ($data['sale_id'] == $this->config->item('sale_prefix') . ' -1') {
			$data['error_message'] = '';
			$this->load->helper('sale');
			if (is_sale_integrated_cc_processing($this->cart)) {
				$this->cart->change_credit_card_payments_to_partial();
				$data['error_message'] .= '<span class="text-success">' . lang('sales_credit_card_transaction_completed_successfully') . '. </span><br /<br />';
			}
			$data['error_message'] .= '<span class="text-danger">' . lang('sales_transaction_failed') . '</span>';
			$data['error_message'] .= '<br /><br />' . anchor('sales', '&laquo; ' . lang('sales_register'));
			$data['error_message'] .= '<br /><br />' . anchor('sales/complete', lang('try_again') . ' &raquo;');
		} else {

			$this->session->unset_userdata('scroll_to');

			if ($this->session->userdata('CC_SUCCESS')) {
				$credit_card_processor = $this->_get_cc_processor();

				if ($credit_card_processor) {
					$cc_processor_class_name = strtoupper(get_class($credit_card_processor));
					$cc_processor_parent_class_name = strtoupper(get_parent_class($credit_card_processor));

					if ($cc_processor_class_name == 'CORECLEARBLOCKCHYPPROCESSOR') {
						$data['prompt_for_customer_info'] = TRUE;
					}

					if ($cc_processor_parent_class_name == 'DATACAPUSBPROCESSOR') {
						$data['reset_params'] = $credit_card_processor->get_emv_pad_reset_params();
					}

					if ($cc_processor_parent_class_name == 'DATACAPTRANSCLOUDPROCESSOR') {
						$data['trans_cloud_reset'] = TRUE;
					}
				}
			}


			if ($this->cart->email_receipt && !empty($cust_info->email)) {
				$email_send = true;
			}

			if ($this->cart->sms_receipt && !empty($cust_info->phone_number)) {
				$sms_receipt = true;
			}
		}

		if ($this->cart->get_has_delivery()) {
			$data['delivery_person_info'] = $this->cart->get_delivery_person_info();

			$data['delivery_info'] = $this->cart->get_delivery_info();
		}

		if ($email_send === true || (isset($cust_info) && $cust_info->auto_email_receipt == 1)) {

			if ($this->config->item('enable_pdf_receipts')) {
				$receipt_data = $this->load->view("sales/receipt_html", $data, true);

				if ($this->config->item('receipt_download_filename_prefix')) {
					$filename = $this->config->item('receipt_download_filename_prefix') . '_receipt_' . $sale_id_raw . '.pdf';
				} else {
					$filename = 'receipt_' . $sale_id_raw . '.pdf';
				}
				$this->load->library("m_pdf");
				$pdf_content = $this->m_pdf->generate_pdf($receipt_data);
			}

			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($this->Location->get_info_for_key('email') ? $this->Location->get_info_for_key('email') : $this->config->item('branding')['no_reply_email'], $this->config->item('company'));
			$this->email->to($cust_info->email);

			if ($this->Location->get_info_for_key('cc_email')) {
				$this->email->cc($this->Location->get_info_for_key('cc_email'));
			}

			if ($this->Location->get_info_for_key('bcc_email')) {
				$this->email->bcc($this->Location->get_info_for_key('bcc_email'));
			}

			$this->email->subject($this->config->item('emailed_receipt_subject') ? $this->config->item('emailed_receipt_subject') : lang('sales_receipt'));

			if ($this->config->item('enable_pdf_receipts')) {
				if (isset($pdf_content) && $pdf_content) {
					$this->email->attach($pdf_content, 'attachment', $filename, 'application/pdf');
					$this->email->message(nl2br($this->config->item('pdf_receipt_message')));
				}
			} else {
				$this->email->message($this->load->view("sales/receipt_email", $data, true));
			}
			$this->email->send();
			$data['email_sent'] = TRUE;
		}

		if ($sms_receipt || (isset($cust_info) && $cust_info->always_sms_receipt)) {
			$this->Sale->sms_receipt($sale_id_raw);
		}

		if ($this->Location->get_info_for_key('email_sales_email')) {
			if ($this->config->item('enable_pdf_receipts')) {
				$receipt_data = $this->load->view("sales/receipt_html", $data, true);

				if ($this->config->item('receipt_download_filename_prefix')) {
					$filename = $this->config->item('receipt_download_filename_prefix') . '_receipt_' . $sale_id_raw . '.pdf';
				} else {
					$filename = 'receipt_' . $sale_id_raw . '.pdf';
				}
				$this->load->library("m_pdf");
				$pdf_content = $this->m_pdf->generate_pdf($receipt_data);
			}

			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($this->Location->get_info_for_key('email') ? $this->Location->get_info_for_key('email') : $this->config->item('branding')['no_reply_email'], $this->config->item('company'));
			$this->email->to($this->Location->get_info_for_key('email_sales_email'));

			if ($this->Location->get_info_for_key('cc_email')) {
				$this->email->cc($this->Location->get_info_for_key('cc_email'));
			}

			if ($this->Location->get_info_for_key('bcc_email')) {
				$this->email->bcc($this->Location->get_info_for_key('bcc_email'));
			}

			$this->email->subject($this->config->item('emailed_receipt_subject') ? $this->config->item('emailed_receipt_subject') : lang('sales_receipt'));

			if ($this->config->item('enable_pdf_receipts')) {
				if (isset($pdf_content) && $pdf_content) {
					$this->email->attach($pdf_content, 'attachment', $filename, 'application/pdf');
					$this->email->message(nl2br($this->config->item('pdf_receipt_message')));
				}
			} else {
				$this->email->message($this->load->view("sales/receipt_email", $data, true));
			}
			$this->email->send();
		}

		// Get Store Config work_order_status_on_complete and update work order status if needed 
		if ($this->config->item('work_order_status_on_complete')) {
			$work_order_status_on_complete = $this->config->item('work_order_status_on_complete');
			if ($work_order_status_on_complete != lang('config_do_not_change')) {
				// Get Sale Work Order ID
				$work_order_info 	= $this->Work_order->get_info_by_sale_id($sale_id_raw)->row();
				$work_order_id 		= $work_order_info->id;

				if ($work_order_id != '0') {
					// Update Work Order Status

					if (!$this->cart->create_work_order) {
						$this->Work_order->change_status($work_order_id, $work_order_status_on_complete);
					}
				}
			}
		}
		if ($this->config->item('show_receipt_popup')) {
			echo $sale_id_raw;
		} else {
			$this->load->view("sales/receipt", $data);
		}


		if ($data['sale_id'] != $this->config->item('sale_prefix') . ' -1') {
			$this->cart->destroy();
			$this->cart->save();
			$this->Appconfig->save('wizard_create_sale', 1);
		}

		//We need to reset this data because is already gone when saving sale
		$final_cart_data = array();
		$final_cart_data['subtotal'] = $data['subtotal'];
		$final_cart_data['total'] = $data['total'];
		$final_cart_data['tax'] = $data['total'] - $data['subtotal'];
		$final_cart_data['exchange_rate'] = $data['exchange_rate'];
		$final_cart_data['exchange_name'] = $data['exchange_name'];
		$final_cart_data['exchange_symbol'] = $data['exchange_symbol'];
		$final_cart_data['exchange_symbol_location'] = $data['exchange_symbol_location'];
		$final_cart_data['exchange_number_of_decimals'] = $data['exchange_number_of_decimals'];
		$final_cart_data['exchange_thousands_separator'] = $data['exchange_thousands_separator'];
		$final_cart_data['exchange_decimal_point'] = $data['exchange_decimal_point'];
		//Update cutomer facing display
		$this->Register_cart->set_data($final_cart_data, $this->Employee->get_logged_in_employee_current_register_id());
		$this->Register_cart->add_data(array('can_email' => $data['can_email_receipt'], 'can_sms' => $data['can_sms_receipt'], 'sale_id' => $sale_id_raw), $this->Employee->get_logged_in_employee_current_register_id());
	}

	public function prompt_for_customer_info($sale_id = NULL)
	{
		session_write_close();

		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor) {
			$cc_processor_class_name = strtoupper(get_class($credit_card_processor));
			$cc_processor_parent_class_name = strtoupper(get_parent_class($credit_card_processor));

			if ($cc_processor_class_name == 'CORECLEARBLOCKCHYPPROCESSOR') {
				//Check for idle so we don't interupt survey/balance message
				$times_to_check_idle = 10;
				$times_to_sleep_between_idle_check = 4;

				for ($k = 1; $k <= $times_to_check_idle; $k++) {
					sleep($times_to_sleep_between_idle_check);

					if ($credit_card_processor->is_terminal_idle()) {
						break;
					}
				}


				$customer_info = $this->Sale->get_customer($sale_id);
				$customer_id = $customer_info->person_id;

				$blockchyp_for_loyalty = FALSE;

				if ($this->Location->get_info_for_key('blockchyp_prompt_for_loyalty') && !$customer_id) {
					if (!$this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id()) || !isset($this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id())['cart']) || count($this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id())['cart']) == 0) {
						$blockchyp_for_loyalty = $credit_card_processor->boolean_prompt(lang('sales_join_loyalty'));
					}
				} else if ($this->Location->get_info_for_key('blockchyp_prompt_for_loyalty')) {
					if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced' && count(explode(":", $this->config->item('spend_to_point_ratio'), 2)) == 2) {
						$message = lang('sales_you_have_points') . ' ' . to_quantity($customer_info->points) . ' ' . lang('points') . '. ' . lang('sales_1_point_worth') . ' ' . to_currency($this->config->item('point_value')) . '. ' . lang('sales_your_points_have_value') . ' ' . to_currency($customer_info->points * $this->config->item('point_value'));
						$credit_card_processor->display_message($message);
					}
				}

				if (!$customer_id || $this->Location->get_info_for_key('blockchyp_ask_for_missing_info')) {
					$blockchyp_prompt_first_name = '';
					$blockchyp_prompt_last_name = '';
					$blockchyp_prompt_for_email = '';
					$blockchyp_prompt_for_phone_number = '';

					if ($this->Location->get_info_for_key('blockchyp_prompt_for_name') && (!$customer_info->first_name || !$customer_info->last_name)) {
						if (!$customer_info->first_name) {
							if (!$this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id()) || !isset($this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id())['cart']) || count($this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id())['cart']) == 0) {
								$blockchyp_prompt_first_name = $credit_card_processor->text_prompt('first-name');
							}
						}

						if (!$customer_info->last_name) {
							if (!$this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id()) || !isset($this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id())['cart']) || count($this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id())['cart']) == 0) {
								$blockchyp_prompt_last_name = $credit_card_processor->text_prompt('last-name');
							}
						}
					}

					if ($this->Location->get_info_for_key('blockchyp_prompt_for_email') && !$customer_info->email) {
						if (!$this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id()) || !isset($this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id())['cart']) || count($this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id())['cart']) == 0) {
							$blockchyp_prompt_for_email = $credit_card_processor->text_prompt('email');
						}
					}

					if ($this->Location->get_info_for_key('blockchyp_prompt_for_phone_number') && !$customer_info->phone_number) {
						if (!$this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id()) || !isset($this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id())['cart']) || count($this->Register_cart->get_data($this->Employee->get_logged_in_employee_current_register_id())['cart']) == 0) {
							$blockchyp_prompt_for_phone_number = $credit_card_processor->text_prompt('phone');
						}
					}

					$the_person_data = array(
						'first_name'   => $blockchyp_prompt_first_name ?: $customer_info->first_name,
						'last_name'    => $blockchyp_prompt_last_name ?: $customer_info->last_name,
						'email'        => $blockchyp_prompt_for_email ?: $customer_info->email,
						'phone_number' => $blockchyp_prompt_for_phone_number ?: $customer_info->phone_number
					);
					$the_customer_data = array('disable_loyalty' => !$blockchyp_for_loyalty);

					if ($the_person_data['first_name'] || $the_person_data['last_name'] || $the_person_data['email'] || $the_person_data['phone_number']) {
						$this->Customer->save_customer($the_person_data, $the_customer_data, $customer_id);
						$customer_id = $the_customer_data['person_id'];
					}


					if ($sale_id && $customer_id) {
						$this->Sale->update_sale_data(array('customer_id' => $customer_id), $sale_id);
					}
				}
			}
		}
	}

	function download_receipt($sale_id)
	{
		$receipt_cart = PHPPOSCartSale::get_instance_from_sale_id($sale_id);
		if ($this->config->item('sort_receipt_column')) {
			$receipt_cart->sort_items($this->config->item('sort_receipt_column'));
		}

		$data = $this->_get_shared_data();
		$data = array_merge($data, $receipt_cart->to_array());
		$this->lang->load('deliveries');
		$sale_info = $this->Sale->get_info($sale_id)->row_array();
		$data['deleted'] = $sale_info['deleted'];
		$data['is_sale_cash_payment'] = $receipt_cart->has_cash_payment();
		$tier_id = $sale_info['tier_id'];
		$tier_info = $this->Tier->get_info($tier_id);
		$data['tier'] = $tier_info->name;
		$data['register_name'] = $this->Register->get_register_name($sale_info['register_id']);
		$data['receipt_title'] = $this->config->item('override_receipt_title') ? $this->config->item('override_receipt_title') : lang('sales_receipt');
		$data['sales_card_statement'] = $this->config->item('override_signature_text') ? $this->config->item('override_signature_text') : lang('sales_card_statement', '', array(), TRUE);

		$data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
		$data['override_location_id'] = $sale_info['location_id'];
		$data['discount_exists'] = $this->_does_discount_exists($data['cart_items']);
		$customer_id = $receipt_cart->customer_id;
		$emp_info = $this->Employee->get_info($sale_info['employee_id']);
		$sold_by_employee_id = $sale_info['sold_by_employee_id'];
		$sale_emp_info = $this->Employee->get_info($sold_by_employee_id);

		$data['payment_type'] = $sale_info['payment_type'];
		$data['amount_change'] = $receipt_cart->get_amount_due_round($sale_id) * -1;
		$data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name . ($sold_by_employee_id && $sold_by_employee_id != $sale_info['employee_id'] ? '/' . $sale_emp_info->first_name . ' ' . $sale_emp_info->last_name : '');
		$data['employee_firstname'] = $emp_info->first_name . ($sold_by_employee_id && $sold_by_employee_id != $sale_info['employee_id'] ? '/' . $sale_emp_info->first_name : '');

		$data['ref_no'] = $sale_info['cc_ref_no'];
		$data['auth_code'] = $sale_info['auth_code'];

		$exchange_rate = $receipt_cart->get_exchange_rate() ? $receipt_cart->get_exchange_rate() : 1;

		$data['disable_loyalty'] = 0;


		$data['sale_id'] = $this->config->item('sale_prefix') . ' ' . $sale_id;
		$data['sale_id_raw'] = $sale_id;
		$data['store_account_payment'] = FALSE;

		foreach ($data['cart_items'] as $item) {
			if ($item->name == lang('store_account_payment')) {
				$data['store_account_payment'] = TRUE;
				break;
			}
		}

		if ($sale_info['suspended'] > 0) {
			if ($sale_info['suspended'] == 1) {
				$data['sale_type'] = ($this->config->item('user_configured_layaway_name') ? $this->config->item('user_configured_layaway_name') : lang('layaway'));
			} elseif ($sale_info['suspended'] == 2) {
				$data['sale_type'] = ($this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate'));
			} else {
				$this->load->model('Sale_types');
				$data['sale_type'] = $this->Sale_types->get_info($sale_info['suspended'])->name;
			}
		}

		if ($receipt_cart->get_has_delivery()) {
			$data['delivery_person_info'] = $receipt_cart->get_delivery_person_info();

			$data['delivery_info'] = $receipt_cart->get_delivery_info();
		}


		$data['signature_file_id'] = $sale_info['signature_image_id'];
		$receipt_data = $this->load->view("sales/receipt_html", $data, true);
		if ($this->config->item('receipt_download_filename_prefix')) {
			$filename = $this->config->item('receipt_download_filename_prefix') . '_receipt_' . $sale_id . '.pdf';
		} else {
			$filename = 'receipt_' . $sale_id . '.pdf';
		}

		$this->load->library("m_pdf");
		$pdf_content = $this->m_pdf->generate_pdf($receipt_data, TRUE, $filename);
	}

	function sms_receipt($sale_id)
	{
		$this->Sale->sms_receipt($sale_id);
	}



	function receipt_validate()
	{
		if ($this->cart->is_valid_receipt($this->input->post('sale_id'))) {
			$sale_id = substr(strtolower($this->input->post('sale_id')), strpos(strtolower($this->input->post('sale_id')), $this->config->item('sale_prefix') . ' ') + strlen(strtolower($this->config->item('sale_prefix')) . ' '));
		} else {
			$sale_id = $this->input->post('sale_id');
		}

		$sale_info = $this->Sale->get_info($sale_id)->row_array();
		if (!$sale_info) {
			echo json_encode(array('success' => false, 'message' => lang('sales_sale_id_not_found')));
			die();
		} else {
			echo json_encode(array('success' => true, 'sale_id' => $sale_id));
			die();
		}
	}

	function receipt($sale_id, $options = null)
	{
		$receipt_cart = PHPPOSCartSale::get_instance_from_sale_id($sale_id);




		$isWorkOrder = $this->work_order->get_info_by_sale_id($sale_id)->row();
		if (isset($isWorkOrder->sale_id)) {

			$receipt_cart->is_work_order = 1;
		}
		if ($receipt_cart->suspended && !$this->Employee->has_module_action_permission('sales', 'view_suspended_receipt', $this->Employee->get_logged_in_employee_info()->person_id)) {
			redirect('no_access/' . $this->module_id);
		}

		if ($this->config->item('sort_receipt_column')) {
			$receipt_cart->sort_items($this->config->item('sort_receipt_column'));
		}

		$data = $this->_get_shared_data();

		$data = array_merge($data, $receipt_cart->to_array());
		// dd($receipt_cart->to_array()['general_taxes_list']);
		$data['general_total_tax']  = $data['cart']->general_total_tax;

		$data['is_sale'] = FALSE;
		$sale_info = $this->Sale->get_info($sale_id)->row_array();
		$data['is_sale_cash_payment'] = $this->cart->has_cash_payment();
		$data['show_payment_times'] = TRUE;
		$data['signature_file_id'] = $sale_info['signature_image_id'];

		$tier_id = $sale_info['tier_id'];
		$tier_info = $this->Tier->get_info($tier_id);
		$data['tier'] = $tier_info->name;
		$data['register_name'] = $this->Register->get_register_name($sale_info['register_id']);
		$data['override_location_id'] = $sale_info['location_id'];
		$data['deleted'] = $sale_info['deleted'];

		$data['receipt_title'] = $this->config->item('override_receipt_title') ? $this->config->item('override_receipt_title') : (!$receipt_cart->suspended ? lang('sales_receipt') : '');
		$data['sales_card_statement'] = $this->config->item('override_signature_text') ? $this->config->item('override_signature_text') : lang('sales_card_statement', '', array(), TRUE);

		$data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
		$customer_id = $this->cart->customer_id;

		$emp_info = $this->Employee->get_info($sale_info['employee_id']);
		$sold_by_employee_id = $sale_info['sold_by_employee_id'];
		$sale_emp_info = $this->Employee->get_info($sold_by_employee_id);
		$data['payment_type'] = $sale_info['payment_type'];
		$data['amount_change'] = $receipt_cart->get_amount_due() * -1;
		$data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name . ($sold_by_employee_id && $sold_by_employee_id != $sale_info['employee_id'] ? '/' . $sale_emp_info->first_name . ' ' . $sale_emp_info->last_name : '');
		$data['employee_firstname'] = $emp_info->first_name . ($sold_by_employee_id && $sold_by_employee_id != $sale_info['employee_id'] ? '/' . $sale_emp_info->first_name : '');
		$data['ref_no'] = $sale_info['cc_ref_no'];
		$data['auth_code'] = $sale_info['auth_code'];
		$data['discount_exists'] = $this->_does_discount_exists($data['cart_items']);
		$data['disable_loyalty'] = 0;
		$data['sale_id'] = $this->config->item('sale_prefix') . ' ' . $sale_id;
		$data['sale_id_raw'] = $sale_id;
		$data['store_account_payment'] = FALSE;
		$data['is_purchase_points'] = FALSE;

		foreach ($data['cart_items'] as $item) {
			if ($item->name == lang('store_account_payment')) {
				$data['store_account_payment'] = TRUE;
				break;
			}
		}

		foreach ($data['cart_items'] as $item) {
			if ($item->name == lang('purchase_points')) {
				$data['is_purchase_points'] = TRUE;
				break;
			}
		}

		if ($sale_info['suspended'] > 0) {
			if ($sale_info['suspended'] == 1) {
				$data['sale_type'] = ($this->config->item('user_configured_layaway_name') ? $this->config->item('user_configured_layaway_name') : lang('layaway'));
			} elseif ($sale_info['suspended'] == 2) {
				$data['sale_type'] = ($this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate'));
			} else {
				$this->load->model('Sale_types');
				$data['sale_type'] = $this->Sale_types->get_info($sale_info['suspended'])->name;
			}
		}

		$exchange_rate = $receipt_cart->get_exchange_rate() ? $receipt_cart->get_exchange_rate() : 1;

		if ($receipt_cart->get_has_delivery()) {
			$data['delivery_person_info'] = $receipt_cart->get_delivery_person_info();

			$data['delivery_info'] = $receipt_cart->get_delivery_info();
		}
		if ($options) {
			if (isset($options['zatca']) && isset($options['zatca']['get_receipt_data'])) {
				return $data;
			}
		}

		if ($this->config->item('use_saudi_tax_config')) {
			$zatca_invoice = $this->Invoice->get_zatca_invoice_by_sale_id($sale_id);
			$data['zatca_invoice'] = $zatca_invoice;

			$location_id = $sale_info['location_id'];
			$location_zatca_config = $this->Appconfig->get_zatca_config($location_id);
			$data['location_zatca_config'] = $location_zatca_config;
		}


		$data['register_receipt'] = $this->Register->get_register_receipt_type($sale_info['register_id']);



		$data['exchange_name'] = 'exchange name';

		if ($data['register_receipt']) {

			if ($this->config->item('customized_receipt')) {

				$query = $this->db->query("select * from phppos_receipts_template where id=" . $data['register_receipt'] . " ");

				if (isset($query->result_array()[0])) {

					$data['receipt'] =	$query->result_array()[0];
					$query = $this->db->query("select * from phppos_receipts_template  ");
					$data['all_templates'] =	$query->result_array();
					$query = $this->db->query("select * from phppos_receipts_template_label where receipts_template_id=" . $data['register_receipt'] . " or is_general=1 ");
					$data['labels'] = $query->result_array();


					$this->load->view("sales/customized_receipt", $data);
				} else {
					$this->load->view("sales/receipt", $data);
				}
			} else {
				$this->load->view("sales/receipt", $data);
			}
		} else {
			$this->load->view("sales/receipt", $data);
		}


		//$this->load->view("sales/receipt",$data);
	}

	function preview_receipt($sale_id, $id = null , $is_return = null)
	{
		$receipt_cart = PHPPOSCartSale::get_instance_from_sale_id($sale_id);

		$isWorkOrder = $this->work_order->get_info_by_sale_id($sale_id)->row();
		if (isset($isWorkOrder->sale_id)) {

			$receipt_cart->is_work_order = 1;
		}
		if ($receipt_cart->suspended && !$this->Employee->has_module_action_permission('sales', 'view_suspended_receipt', $this->Employee->get_logged_in_employee_info()->person_id)) {
			redirect('no_access/' . $this->module_id);
		}

		if ($this->config->item('sort_receipt_column')) {
			$receipt_cart->sort_items($this->config->item('sort_receipt_column'));
		}

		$data = $this->_get_shared_data();

		$data = array_merge($data, $receipt_cart->to_array());
		$data['is_sale'] = FALSE;
		$sale_info = $this->Sale->get_info($sale_id)->row_array();
		$data['is_sale_cash_payment'] = $this->cart->has_cash_payment();
		$data['show_payment_times'] = TRUE;
		$data['signature_file_id'] = $sale_info['signature_image_id'];

		$tier_id = $sale_info['tier_id'];
		$tier_info = $this->Tier->get_info($tier_id);
		$data['tier'] = $tier_info->name;
		$data['register_name'] = $this->Register->get_register_name($sale_info['register_id']);
		$data['override_location_id'] = $sale_info['location_id'];
		$data['deleted'] = $sale_info['deleted'];

		$data['receipt_title'] = $this->config->item('override_receipt_title') ? $this->config->item('override_receipt_title') : (!$receipt_cart->suspended ? lang('sales_receipt') : '');
		$data['sales_card_statement'] = $this->config->item('override_signature_text') ? $this->config->item('override_signature_text') : lang('sales_card_statement', '', array(), TRUE);

		$data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
		$customer_id = $this->cart->customer_id;

		$emp_info = $this->Employee->get_info($sale_info['employee_id']);
		$sold_by_employee_id = $sale_info['sold_by_employee_id'];
		$sale_emp_info = $this->Employee->get_info($sold_by_employee_id);
		$data['payment_type'] = $sale_info['payment_type'];
		$data['amount_change'] = $receipt_cart->get_amount_due() * -1;
		$data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name . ($sold_by_employee_id && $sold_by_employee_id != $sale_info['employee_id'] ? '/' . $sale_emp_info->first_name . ' ' . $sale_emp_info->last_name : '');
		$data['employee_firstname'] = $emp_info->first_name . ($sold_by_employee_id && $sold_by_employee_id != $sale_info['employee_id'] ? '/' . $sale_emp_info->first_name : '');
		$data['ref_no'] = $sale_info['cc_ref_no'];
		$data['auth_code'] = $sale_info['auth_code'];
		$data['discount_exists'] = $this->_does_discount_exists($data['cart_items']);
		$data['disable_loyalty'] = 0;
		$data['sale_id'] = $this->config->item('sale_prefix') . ' ' . $sale_id;
		$data['sale_id_raw'] = $sale_id;
		$data['store_account_payment'] = FALSE;
		$data['is_purchase_points'] = FALSE;

		foreach ($data['cart_items'] as $item) {
			if ($item->name == lang('store_account_payment')) {
				$data['store_account_payment'] = TRUE;
				break;
			}
		}

		foreach ($data['cart_items'] as $item) {
			if ($item->name == lang('purchase_points')) {
				$data['is_purchase_points'] = TRUE;
				break;
			}
		}

		if ($sale_info['suspended'] > 0) {
			if ($sale_info['suspended'] == 1) {
				$data['sale_type'] = ($this->config->item('user_configured_layaway_name') ? $this->config->item('user_configured_layaway_name') : lang('layaway'));
			} elseif ($sale_info['suspended'] == 2) {
				$data['sale_type'] = ($this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate'));
			} else {
				$this->load->model('Sale_types');
				$data['sale_type'] = $this->Sale_types->get_info($sale_info['suspended'])->name;
			}
		}

		$exchange_rate = $receipt_cart->get_exchange_rate() ? $receipt_cart->get_exchange_rate() : 1;

		if ($receipt_cart->get_has_delivery()) {
			$data['delivery_person_info'] = $receipt_cart->get_delivery_person_info();

			$data['delivery_info'] = $receipt_cart->get_delivery_info();
		}


		if ($this->config->item('use_saudi_tax_config')) {
			$zatca_invoice = $this->Invoice->get_zatca_invoice_by_sale_id($sale_id);
			$data['zatca_invoice'] = $zatca_invoice;

			$location_id = $sale_info['location_id'];
			$location_zatca_config = $this->Appconfig->get_zatca_config($location_id);
			$data['location_zatca_config'] = $location_zatca_config;
		}


		if (!$id) {
			$id = $this->Register->get_register_receipt_type($sale_info['register_id']);
		}


		$data['exchange_name'] = 'exchange name';
		$data['register_receipt'] = $this->Register->get_register_receipt_type($sale_info['register_id']);

		if ($this->config->item('customized_receipt')) {
			$query = $this->db->query("select * from phppos_receipts_template where id=" . $id . " ");
			if (isset($query->result_array()[0])) {
				$data['receipt'] =	$query->result_array()[0];
				$query = $this->db->query("select * from phppos_receipts_template  ");
				$data['all_templates'] =	$query->result_array();
				$query = $this->db->query("select * from phppos_receipts_template_label where receipts_template_id=" . $data['register_receipt'] . " or is_general=1 ");
				$data['labels'] = $query->result_array();

				$this->load->view("sales/preview_receipt", $data);
			} else {
				if($is_return){
					return  $this->load->view("sales/receipt_view", $data, true);
				}else{
					echo $this->load->view("sales/receipt_view", $data, true);
				}
			}
		} else {
			if($is_return){
				return  $this->load->view("sales/receipt_view", $data, true);
			}else{
				echo $this->load->view("sales/receipt_view", $data, true);
			}
			
		}
	}
	function kitchen_receipt()
	{
		$sale_id = $this->input->post('id');
		$receipt_cart = PHPPOSCartSale::get_instance_from_sale_id($sale_id);

		if ($receipt_cart->suspended && !$this->Employee->has_module_action_permission('sales', 'view_suspended_receipt', $this->Employee->get_logged_in_employee_info()->person_id)) {
			redirect('no_access/' . $this->module_id);
		}

		if ($this->config->item('sort_receipt_column')) {
			$receipt_cart->sort_items($this->config->item('sort_receipt_column'));
		}

		$data = $this->_get_shared_data();

		$data = array_merge($data, $receipt_cart->to_array());
		$data['is_sale'] = FALSE;
		$sale_info = $this->Sale->get_info($sale_id)->row_array();
		$data['is_sale_cash_payment'] = $this->cart->has_cash_payment();
		$data['show_payment_times'] = TRUE;
		$data['signature_file_id'] = $sale_info['signature_image_id'];

		$tier_id = $sale_info['tier_id'];
		$tier_info = $this->Tier->get_info($tier_id);
		$data['tier'] = $tier_info->name;
		$data['register_name'] = $this->Register->get_register_name($sale_info['register_id']);
		$data['override_location_id'] = $sale_info['location_id'];
		$data['deleted'] = $sale_info['deleted'];

		$data['receipt_title'] = $this->config->item('override_receipt_title') ? $this->config->item('override_receipt_title') : (!$receipt_cart->suspended ? lang('sales_receipt') : '');
		$data['sales_card_statement'] = $this->config->item('override_signature_text') ? $this->config->item('override_signature_text') : lang('sales_card_statement', '', array(), TRUE);

		$data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
		$customer_id = $this->cart->customer_id;

		$emp_info = $this->Employee->get_info($sale_info['employee_id']);
		$sold_by_employee_id = $sale_info['sold_by_employee_id'];
		$sale_emp_info = $this->Employee->get_info($sold_by_employee_id);
		$data['payment_type'] = $sale_info['payment_type'];
		$data['amount_change'] = $receipt_cart->get_amount_due() * -1;
		$data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name . ($sold_by_employee_id && $sold_by_employee_id != $sale_info['employee_id'] ? '/' . $sale_emp_info->first_name . ' ' . $sale_emp_info->last_name : '');
		$data['employee_firstname'] = $emp_info->first_name . ($sold_by_employee_id && $sold_by_employee_id != $sale_info['employee_id'] ? '/' . $sale_emp_info->first_name : '');
		$data['ref_no'] = $sale_info['cc_ref_no'];
		$data['auth_code'] = $sale_info['auth_code'];
		$data['discount_exists'] = $this->_does_discount_exists($data['cart_items']);
		$data['disable_loyalty'] = 0;
		$data['sale_id'] = $this->config->item('sale_prefix') . ' ' . $sale_id;
		$data['sale_id_raw'] = $sale_id;
		$data['store_account_payment'] = FALSE;
		$data['is_purchase_points'] = FALSE;

		foreach ($data['cart_items'] as $item) {
			if ($item->name == lang('store_account_payment')) {
				$data['store_account_payment'] = TRUE;
				break;
			}
		}

		foreach ($data['cart_items'] as $item) {
			if ($item->name == lang('purchase_points')) {
				$data['is_purchase_points'] = TRUE;
				break;
			}
		}

		if ($sale_info['suspended'] > 0) {
			if ($sale_info['suspended'] == 1) {
				$data['sale_type'] = ($this->config->item('user_configured_layaway_name') ? $this->config->item('user_configured_layaway_name') : lang('layaway'));
			} elseif ($sale_info['suspended'] == 2) {
				$data['sale_type'] = ($this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate'));
			} else {
				$this->load->model('Sale_types');
				$data['sale_type'] = $this->Sale_types->get_info($sale_info['suspended'])->name;
			}
		}

		$exchange_rate = $receipt_cart->get_exchange_rate() ? $receipt_cart->get_exchange_rate() : 1;

		if ($receipt_cart->get_has_delivery()) {
			$data['delivery_person_info'] = $receipt_cart->get_delivery_person_info();

			$data['delivery_info'] = $receipt_cart->get_delivery_info();
		}
		$query = $this->db->query("select * from phppos_receipts_template where id=1 ");
		$data['receipt_pos'] = $query->result_array()[0];
		echo $this->load->view("customized_kitchen_receipt", $data, true);
		//echo $this->load->view("kitchen_receipt",$data, true);
	}




	function fulfillment($sale_id)
	{
		$sale_info = $this->Sale->get_info($sale_id)->row_array();
		$data['total'] = $sale_info['total'];
		$data['override_location_id'] = $sale_info['location_id'];
		$data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
		$customer_id = $sale_info['customer_id'];

		$emp_info = $this->Employee->get_info($sale_info['employee_id']);
		$data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name;

		if ($customer_id) {
			$cust_info = $this->Customer->get_info($customer_id);
			$data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name . ($cust_info->account_number == ''  ? '' : ' - ' . $cust_info->account_number);
			$data['customer_company'] = $cust_info->company_name;
			$data['customer_address_1'] = $cust_info->address_1;
			$data['customer_address_2'] = $cust_info->address_2;
			$data['customer_city'] = $cust_info->city;
			$data['customer_state'] = $cust_info->state;
			$data['customer_zip'] = $cust_info->zip;
			$data['customer_country'] = $cust_info->country;
			$data['customer_phone'] = format_phone_number($cust_info->phone_number);
			$data['customer_email'] = $cust_info->email;
		}

		$data['sale_id'] = $this->config->item('sale_prefix') . ' ' . $sale_id;
		$data['sale_id_raw'] = $sale_id;
		$data['comment'] = $sale_info['comment'];
		$data['show_comment_on_receipt'] = $sale_info['show_comment_on_receipt'];
		$data['sale_id_raw'] = $sale_id;
		$data['sales_items'] = $this->Sale->get_sale_items_ordered_by_category($sale_id)->result_array();
		$data['sales_item_kits'] = $this->Sale->get_sale_item_kits_ordered_by_category($sale_id)->result_array();
		$data['discount_exists'] = $this->_does_discount_exists($data['sales_items']) || $this->_does_discount_exists($data['sales_item_kits']);

		$this->load->model('Delivery');
		$this->load->model('Person');

		$delivery = $this->Delivery->get_info_by_sale_id($sale_id);

		if ($delivery->num_rows() == 1) {
			$data['delivery_info'] = $delivery->row_array();

			if (isset($data['delivery_info']['contact_preference'])) {
				$data['delivery_info']['contact_preference'] = unserialize($data['delivery_info']['contact_preference']);
			} else {
				$data['delivery_info']['contact_preference'] = array();
			}

			$data['delivery_person_info'] = (array)$this->Person->get_info($this->Delivery->get_delivery_person_id($sale_id));
		}

		$this->load->view("sales/fulfillment", $data);
	}




	function edit($sale_id)
	{
		$data = array();

		$data['sale_info'] = $this->Sale->get_info($sale_id)->row_array();
		$data['is_ecommerce'] = $data['sale_info']['is_ecommerce'];
		if ($data['sale_info']['customer_id']) {
			$customer = $this->Customer->get_info($data['sale_info']['customer_id']);
			$data['selected_customer_name'] = $customer->first_name . ' ' . $customer->last_name;
			$data['selected_customer_email'] = $customer->email;
		} else {
			$data['selected_customer_name'] = lang('none');
		}

		$data['employees'] = array();
		foreach ($this->Employee->get_all()->result() as $employee) {
			$data['employees'][$employee->person_id] = $employee->first_name . ' ' . $employee->last_name;
		}


		$data['store_account_payment'] = $data['sale_info']['store_account_payment'];
		$data['is_purchase_points'] = $data['sale_info']['is_purchase_points'];
		$data['store_account_charge'] = $this->Sale->get_store_account_payment_total($sale_id) != 0 ? true : false;


		$this->load->view('sales/edit', $data);
	}

	function delete_sale_only($sale_id)
	{
		$this->check_action_permission('delete_sale');
		if ($this->Sale->delete($sale_id)) {
			echo json_encode(array('success' => true, 'message' => lang('sales_successfully_deleted')));
		} else {
			echo json_encode(array('success' => true, 'message' => lang('sales_unsuccessfully_deleted')));
		}
	}

	function delete($sale_id)
	{
		$this->check_action_permission('delete_sale');

		if (!$this->input->post('do_delete') || $this->Sale->is_sale_deleted($sale_id)) {
			$this->load->view('sales/delete', array('success' => false));
			return;
		}

		$data = array();

		$can_delete = TRUE;

		if ($this->input->post('sales_void_and_refund_credit_card') || $this->input->post('sales_void_and_cancel_return')) {
			$credit_card_processor = $this->_get_cc_processor();
			if ($credit_card_processor) {
				$cc_processor_class_name = strtoupper(get_class($credit_card_processor));
				$cc_processor_parent_class_name = strtoupper(get_parent_class($credit_card_processor));
				if ($cc_processor_class_name == 'CARDCONNECTPROCESSOR' || $cc_processor_class_name == 'MERCURYHOSTEDCHECKOUTPROCESSOR' || $cc_processor_parent_class_name == 'DATACAPTRANSCLOUDPROCESSOR' || $cc_processor_class_name == 'STRIPEPROCESSOR' || $cc_processor_class_name == 'BRAINTREEPROCESSOR' || $cc_processor_class_name == 'CORECLEARBLOCKCHYPPROCESSOR' || $cc_processor_class_name == 'SQUARETERMINALPROCESSOR') {
					if ($this->input->post('sales_void_and_refund_credit_card')) {
						$can_delete = $credit_card_processor->void_sale($sale_id);
					} elseif ($this->input->post('sales_void_and_cancel_return')) {
						$can_delete = $credit_card_processor->void_return($sale_id);
					}

					if ($can_delete && $this->Sale->delete($sale_id)) {
						$data['success'] = true;
						if ($this->input->post('clear_sale')) {
							$this->cart->destroy();
							$this->cart->save();
						}
						$data['sale_id'] = $sale_id;
					} else {
						$data['success'] = false;
					}

					$this->load->view('sales/delete', $data);
				} elseif ($cc_processor_parent_class_name == 'DATACAPUSBPROCESSOR') {
					if ($this->input->post('sales_void_and_refund_credit_card')) {
						$can_delete = $credit_card_processor->void_sale($sale_id);
					} elseif ($this->input->post('sales_void_and_cancel_return')) {
						$can_delete = $credit_card_processor->void_return($sale_id);
					}

					if ($can_delete && $this->input->post('clear_sale')) {
						$this->cart->destroy();
						$this->cart->save();
					}
				}
			}
		} else {
			if ($this->Sale->delete($sale_id)) {
				$data['success'] = true;
				if ($this->input->post('clear_sale')) {
					$this->cart->destroy();
					$this->cart->save();
				}
				$data['sale_id'] = $sale_id;
			} else {
				$data['success'] = false;
			}

			$this->load->view('sales/delete', $data);
		}
	}

	function undelete($sale_id)
	{
		if (!$this->input->post('do_undelete') || $this->Sale->is_sale_undeleted($sale_id)) {
			$this->load->view('sales/undelete', array('success' => false));
			return;
		}
		$data = array();

		if ($this->Sale->undelete($sale_id)) {
			$data['success'] = true;
		} else {
			$data['success'] = false;
		}

		$this->load->view('sales/undelete', $data);
	}

	function save($sale_id)
	{
		$sale_data = array(
			'sale_time' => date('Y-m-d H:i:s', strtotime($this->input->post('date'))),
			'customer_id' => $this->input->post('customer_id') ? $this->input->post('customer_id') : null,
			'employee_id' => $this->input->post('employee_id'),
			'comment' => $this->input->post('comment'),
			'show_comment_on_receipt' => $this->input->post('show_comment_on_receipt') ? 1 : 0
		);

		$sale_info = $this->Sale->get_info($sale_id)->row_array();


		if ($this->Sale->update($sale_data, $sale_id)) {
			echo json_encode(array('success' => true, 'message' => lang('sales_successfully_updated')));
		} else {
			echo json_encode(array('success' => false, 'message' => lang('sales_unsuccessfully_updated')));
		}
	}

	function _payments_cover_total()
	{
		$total_payments = 0;

		foreach ($this->cart->get_payments() as $payment) {
			$total_payments += $payment->payment_amount;
		}

		/* Changed the conditional to account for floating point rounding */
		// if ( ( $this->cart->get_mode() == 'sale' || $this->cart->get_mode() == 'store_account_payment' ) && ( ( to_currency_no_money( $this->cart->get_total() ) - $total_payments ) > 1e-6 ) )
		// {
		// 	return false;
		// }
		return true;
	}

	function redeem_discount()
	{
		$customer_id = $this->cart->customer_id;

		if ($customer_id) {
			$cust_info = $this->Customer->get_info($customer_id);
			$sales_until_discount = ($this->config->item('number_of_sales_for_discount') ? $this->config->item('number_of_sales_for_discount') : 0) - $cust_info->current_sales_for_discount;

			if ($sales_until_discount <= 0) {
				$discount_all_percent = $this->config->item('discount_percent_earned');
				$this->cart->redeem_discount = 1;
				$this->cart->discount_all($discount_all_percent);

				foreach ($this->cart->get_items() as $item) {
					if ($item->below_cost_price()) {
						if ($this->config->item('do_not_allow_below_cost')) {
							$this->cart->discount_all(0);
							$this->cart->redeem_discount = 0;
							$data['error'] = lang('sales_selling_item_below_cost');
						} else {
							$data['warning'] = lang('sales_selling_item_below_cost');
						}
						$this->cart->save();
						$this->sales_reload($data);
						return;
					}
				}
			}
		}
		$this->cart->save();
		$this->sales_reload();
	}

	function unredeem_discount()
	{
		$this->cart->redeem_discount = 0;
		$this->cart->discount_all(0);
		$this->cart->save();
		$this->sales_reload();
	}

	function set_ebt_voucher_no()
	{
		$this->cart->ebt_voucher_no = $this->input->post('ebt_voucher_no');
		$this->cart->save();
	}

	function set_ebt_voucher()
	{
		$this->cart->ebt_voucher = $this->input->post('ebt_voucher');
		$this->cart->save();
	}


	function set_ebt_auth_code()
	{
		$this->cart->ebt_auth_code = $this->input->post('ebt_auth_code');
		$this->cart->save();
	}

	function reload()
	{
		$this->_reload();
	}

	function paginate($offset = 0)
	{
		$this->cart->offset = $offset;
		$this->cart->save();
		$this->sales_reload(array());
	}

	function _reload($data = array(), $is_ajax = true)
	{


		//This is used for upgrade installs that never had this set (sales in progress)
		if ($this->cart->limit === NULL) {
			$this->cart->limit = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
			$this->cart->save();
		}

		if ($this->cart->offset === NULL) {
			$this->cart->offset = 0;
			$this->cart->save();
		}

		$the_cart_items = $this->cart->get_items();

		if ($this->cart->offset >= count($the_cart_items)) {
			$this->cart->offset = 0;
			$this->cart->save();
		}

		$data = array_merge($this->_get_shared_data(), $data);

		$config['base_url'] = site_url('sales/paginate');
		$config['per_page'] = $this->cart->limit;
		$config['uri_segment'] = -1; //Set this to non possible url so it doesn't use URL

		//Undocumented feature to get page
		$config['cur_page'] = $this->cart->offset;

		$config['total_rows'] = count($the_cart_items);


		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$data['is_tax_inclusive'] = $this->cart->is_tax_inclusive();
		$data['ebt_total'] = $this->cart->get_ebt_total_amount_to_charge() - $this->cart->get_payment_amount(lang('wic')) - $this->cart->get_payment_amount(lang('ebt'));

		$person_info = $this->Employee->get_logged_in_employee_info();
		$modes = array('sale' => lang('sales_sale'), 'return' => lang('sales_return'), 'estimate' => $this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate'));

		if (!$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) {
			unset($modes['return']);
		}

		$can_receive_store_account_payment = $this->Employee->has_module_action_permission('sales', 'receive_store_account_payment', $this->Employee->get_logged_in_employee_info()->person_id);

		if ($this->cart->get_mode() == 'store_account_payment' || ($this->config->item('customers_store_accounts') && $can_receive_store_account_payment)) {
			// Only allow Store Account Payment if there are items in the cart there are zero items in the cart
			if ($this->cart->get_mode() == 'store_account_payment' || count($the_cart_items) == 0) {
				$modes['store_account_payment'] = lang('store_account_payment');
			}
		}

		// if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced' &&  count(explode(":",$this->config->item('spend_to_point_ratio'),2)) == 2)
		// {
		// 	$modes['purchase_points'] = lang('sales_purchase_points');
		// }

		$data['has_coupons_for_today'] = $this->Sale->has_coupons_for_today();
		$data['sale_id_of_edit_or_suspended_sale'] = $this->cart->get_previous_receipt_id();

		if (!$data['sale_id_of_edit_or_suspended_sale']) {
			$data['sale_id_of_edit_or_suspended_sale'] = '';
			$data['was_cc_return'] = 0;
			$data['was_cc_sale'] = 0;
		} else {
			$sale_info = $this->Sale->get_info($data['sale_id_of_edit_or_suspended_sale'])->row();
			$data['was_cc_return'] = $this->Sale->can_void_cc_return($data['sale_id_of_edit_or_suspended_sale'])  ? 1 : 0;
			$data['was_cc_sale'] = $this->Sale->can_void_cc_sale($data['sale_id_of_edit_or_suspended_sale']) ? 1 : 0;
		}

		$data['coupons'] = array();
		$data['has_discount'] = $this->cart->has_discount();
		$data['modes'] = $modes;
		$data['line_for_flat_discount_item'] = $this->cart->get_index_for_flat_discount_item();
		$data['discount_all_percent'] = $this->cart->get_discount_all_percent();
		$data['discount_all_fixed'] = $this->cart->get_discount_all_fixed();
		$data['items_module_allowed'] = $this->Employee->has_module_permission('items', $person_info->person_id);
		$data['current_location'] = $this->Employee->get_logged_in_employee_current_location_id();
		if (!$this->session->userdata('foreign_language_to_cur_language_sales')) {
			$this->load->helper('directory');
			$language_folder = directory_map(APPPATH . 'language', 1);

			$languages = array();

			foreach ($language_folder as $language_folder) {
				$languages[] = substr($language_folder, 0, strlen($language_folder) - 1);
			}

			$cur_lang = array();
			foreach ($this->Sale->get_payment_options_with_language_keys() as $cur_lang_value => $lang_key) {
				$cur_lang[$lang_key] = $cur_lang_value;
			}


			foreach ($languages as $language) {
				$this->lang->load('common', $language);

				foreach ($this->Sale->get_payment_options_with_language_keys() as $cur_lang_value => $lang_key) {
					if (strpos($lang_key, 'common') !== FALSE) {
						$foreign_language_to_cur_language[lang($lang_key)] = $cur_lang[$lang_key];
					} else {
						$foreign_language_to_cur_language[$cur_lang_value] = $cur_lang_value;
					}
				}
			}

			$this->session->set_userdata('foreign_language_to_cur_language_sales', $foreign_language_to_cur_language);
			//Switch back
			$this->lang->switch_to($this->config->item('language'));
		} else {
			$foreign_language_to_cur_language = $this->session->userdata('foreign_language_to_cur_language_sales');
		}

		$default_payment_type_translated = false;
		if (isset($foreign_language_to_cur_language[$this->config->item('default_payment_type')])) {
			$default_payment_type_translated = $foreign_language_to_cur_language[$this->config->item('default_payment_type')];
		} else {
			$default_payment_type_translated = $this->config->item('default_payment_type');
		}

		$data['default_payment_type'] = $default_payment_type_translated ? $default_payment_type_translated : lang('cash');

		$data['is_over_credit_limit'] = false;
		$data['fullscreen'] = $this->session->userdata('fullscreen');
		$data['redeem'] = $this->cart->redeem_discount;

		$customer_id = $this->cart->customer_id;

		if ($customer_id) {
			$cust_info = $this->Customer->get_info($customer_id, TRUE);

			$customer_giftcards = $this->Giftcard->get_customer_giftcards($customer_id);
		}

		$data['prompt_for_card'] = $this->cart->prompt_for_card;
		$data['show_terms_and_conditions'] = $this->cart->show_terms_and_conditions;
		$data['cc_processor_class_name'] = $this->_get_cc_processor() ? strtoupper(get_class($this->_get_cc_processor())) : '';
		$data['cc_processor_parent_class_name'] = $this->_get_cc_processor() ? strtoupper(get_parent_class($this->_get_cc_processor())) : '';

		$data['ebt_voucher'] = $this->cart->ebt_voucher;
		$data['ebt_voucher_no'] = $this->cart->ebt_voucher_no;
		$data['ebt_auth_code'] = $this->cart->ebt_auth_code;


		if ($this->config->item('select_sales_person_during_sale')) {
			$employees = array('' => lang('not_set'));

			foreach ($this->Employee->get_all()->result() as $employee) {
				if ($this->Employee->is_employee_authenticated($employee->person_id, $this->Employee->get_logged_in_employee_current_location_id())) {
					$employees[$employee->person_id] = $employee->first_name . ' ' . $employee->last_name;
				}
			}
			$data['employees'] = $employees;
			$data['selected_sold_by_employee_id'] = $this->cart->sold_by_employee_id;
		}

		$tiers = array();

		$tiers[0] = lang('none');
		foreach ($this->Tier->get_all()->result() as $tier) {
			$tiers[$tier->id] = $tier->name;
		}

		$data['tiers'] = $tiers;

		$data['payment_options'] = $this->Sale->get_payment_options($this->cart);

		if ($customer_id) {
			$data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name . ($cust_info->company_name == ''  ? '' : ' (' . $cust_info->company_name . ')');
			$data['customer_email'] = $cust_info->email;
			$data['customer_phone'] = format_phone_number($cust_info->phone_number);
			$data['customer_internal_notes'] = $cust_info->internal_notes;

			$this->load->model('Customer');
			$data['customer_has_address'] = $this->Customer->does_customer_have_address($customer_id);
			$data['customer_balance'] = $cust_info->balance;
			$data['customer_credit_limit'] = $cust_info->credit_limit;
			$data['is_over_credit_limit'] = $this->Customer->is_over_credit_limit($customer_id, $this->cart->get_payment_amount(lang('store_account')));
			$data['customer_id'] = $customer_id;
			$data['customer_cc_token'] = $cust_info->cc_token;
			$data['customer_cc_preview'] = $cust_info->cc_preview;
			$data['save_credit_card_info'] = $this->cart->save_credit_card_info;
			$data['use_saved_cc_info'] = $this->cart->use_cc_saved_info;
			$data['avatar'] = $cust_info->image_id ?  cacheable_app_file_url($cust_info->image_id) : base_url() . "assets/img/user.png"; //can be changed to  base_url()."img/avatar.png" if it is required
			if (count($customer_giftcards)) {
				$data['customer_giftcards'] = $customer_giftcards;
			}
			$data['disable_loyalty'] = $cust_info->disable_loyalty;
			$data['auto_email_receipt'] = $cust_info->auto_email_receipt;
			$data['always_sms_receipt'] = $cust_info->always_sms_receipt;

			$data['points'] = to_currency_no_money($cust_info->points);
			$data['sales_until_discount'] = ($this->config->item('number_of_sales_for_discount')) ? (float)$this->config->item('number_of_sales_for_discount') - (float)$cust_info->current_sales_for_discount : 0;
		}
		$data['customer_required_check'] = (!$this->config->item('require_customer_for_sale') || ($this->config->item('require_customer_for_sale') && isset($customer_id) && $customer_id));

		if ($this->cart->has_recurring_item() && !$customer_id) {
			$data['customer_required_check'] = FALSE;
		}
		$data['suspended_sale_customer_required_check'] = (!$this->config->item('require_customer_for_suspended_sale') || ($this->config->item('require_customer_for_suspended_sale') && isset($customer_id) && $customer_id));
		$data['payments_cover_total'] = $this->_payments_cover_total();

		if ($data['mode'] == 'store_account_payment' && $customer_id) {
			$sale_ids = $this->Sale->get_unpaid_store_account_sale_ids($customer_id);

			$paid_sales = $this->cart->get_paid_store_account_ids();

			$data['unpaid_store_account_sales'] = $this->Sale->get_unpaid_store_account_sales($sale_ids);

			for ($k = 0; $k < count($data['unpaid_store_account_sales']); $k++) {
				if (isset($paid_sales[$data['unpaid_store_account_sales'][$k]['sale_id']])) {
					$data['unpaid_store_account_sales'][$k]['paid'] = TRUE;
				}
			}
		}


		//fixing this for arabic
		if (is_rtl_lang()) {
			$data['discount_editable_placement'] = $this->agent->is_mobile() && !$this->agent->is_tablet() ? 'right' : 'right';
		} else {
			$data['discount_editable_placement'] = $this->agent->is_mobile() && !$this->agent->is_tablet() ? 'right' : 'right';
		}


		$payment_options = array_values($this->Sale->get_payment_options($this->cart));

		$markup_markdown = $this->config->item('markup_markdown');
		$markup_markdown_config = $markup_markdown ? unserialize($markup_markdown) : null;


		$data['markup_predictions'] = array();
		if ($markup_markdown && $this->cart->get_total() > 0 && !$this->Location->get_info_for_key('disable_markup_markdown')) {
			foreach ($payment_options as $payment_type) {
				if (isset($markup_markdown_config[$payment_type])) {
					$fee_percent = $markup_markdown_config[$payment_type];
					$fee_amount = $this->cart->get_total() * ($fee_percent / 100);

					$data['markup_predictions'][$payment_type] = array('amount' => $fee_amount, 'id' => md5($payment_type));
				} else {
					$data['markup_predictions'][$payment_type] = array('amount' => 0, 'id' => md5($payment_type));
				}
			}
		}

		// Get Work Order Statuses for dropdown list in register view 
		$data['work_order_statuses'] = $this->Work_order->get_all_statuses();
		// Get Work Order ID 
		$data['work_order_id'] = $this->Work_order->get_info_by_sale_id($data['cart']->sale_id)->row()->id ?? NULL;

		$data['is_pos'] = true;
		$credit_card_processor = $this->_get_cc_processor();

		if (isset($_SESSION['employee_current_register_id'])) {
			$data['register_info'] = $this->register->get_info($_SESSION['employee_current_register_id']);
		} else {
			$data['register_info'] = $this->register->get_info(1);
		}

		if ($credit_card_processor && method_exists($credit_card_processor, 'update_transaction_display')) {
			$data['update_transaction_display'] = TRUE;
		}
		// $this->items_offline_data();
		// echo "here";
		// dd($data);
		if ($is_ajax) {


			if ($this->config->item('speedy_pos')) {


				//offline version mudasir
				if ($this->agent->is_mobile()) {
					$this->load->view("sales/offline/mobile/register_offline", $data);
				} else {

					$this->load->view("sales/offline/register_initial_quick_offline", $data);
				}

				//offline version mudasir	
			} else {
				$this->load->view("sales/register", $data);
			}
		} else {

			$data['remove_topbar']  =  true;

			if ($this->config->item('quick_variation_grid')) {

				if ($this->config->item('speedy_pos')) {

					if ($this->agent->is_mobile()) {
						$this->load->view("sales/offline/mobile", $data);
					} else {


						$this->load->view("sales/offline/register_initial_quick_offline", $data);
					}
					//offline version mudasir

					//offline version mudasir	
				} else {

					$this->load->view("sales/register_initial_quick", $data);
				}
			} else {

				if ($this->config->item('speedy_pos')) {


					if ($this->agent->is_mobile()) {
						$this->load->view("sales/offline/mobile", $data);
					} else {
						$this->load->view("sales/offline/register_initial_quick_offline", $data);
					}
					//offline version mudasir

					//offline version mudasir	
				} else {
					$this->load->view("sales/register_initial", $data);
				}
			}
		}
	}

	function check_and_get_suspended_sale()
	{
		$response = [
			"items" => [],

		];
		$CI = &get_instance();


		$this->cart->destroy();


		// $this->cart->set_mode('return');


		$data = get_query_data(" select * from phppos_sales where sale_id =" . $this->input->post('sale_id') . " ");

		if ($data && $data[0]->sale_json != '' && $data[0]->sale_json != null) {

			$response = json_decode($data[0]->sale_json);

			$response[0]->extra->suspended = $data[0]->suspended;
			$response[0]->extra->sale_id = $this->input->post('sale_id');
			if ($this->input->post('is_returned')) {
				$response[0]->extra->mode = 'return';
				$response[0]->extra->return_sale_id = $this->input->post('sale_id');
			}
			$response = $response[0];
			// dd($response[0]->extra);return
			// $response->extra->return_sale_id =$this->input->post('sale_id');

		} else {


			$response['payments'] = [];
			$response['customer'] = []; // to return an empty object instead of an empty array
			$response['extra'] = [];
			$response['taxes'] = [];
			$response['extra']['coupons'] = [];
			$sale_id = $this->input->post('sale_id');
			$this->cart = PHPPOSCartSale::get_instance_from_sale_id($sale_id, 'sale', TRUE);
			// dd($this->cart);

			if ($this->config->item('automatically_email_receipt')) {
				$this->cart->email_receipt = 1;
			}

			if ($this->config->item('automatically_sms_receipt_that_works_like_automatically_email_receipt')) {
				$this->cart->sms_receipt = 1;
			}

			if ($this->config->item('create_invoices_for_customer_store_account_charges')) {
				$this->cart->create_invoice = 1;
			}

			// Verify if the sale is a work order and if so, set the flag to create a work order 
			$isWorkOrder = $this->work_order->get_info_by_sale_id($sale_id)->row();
			if (isset($isWorkOrder->sale_id)) {

				$this->cart->is_work_order = 1;
				$response['extra']['is_work_order'] = 1;
			}

			$this->cart->save();
			$this->Sale->delete_open_suspended_sales();
			$this->Sale->save_open_suspended_sale($sale_id);


			if (!$this->agent->is_mobile() && !$this->agent->is_tablet()) {
				$cart_items = $this->cart->get_list_sort_by_receipt_sort_order();
			}

			$response['extra']['sale_id'] = ($this->cart->sale_id) ? $this->cart->sale_id : $_POST['sale_id'];
			$response['extra']['suspended_type'] = $CI->Sale->get_info($response['extra']['sale_id'])->row()->suspended;



			$this->load->model('Item_attribute');

			// dd($this->cart->get_coupons());
			foreach (array_reverse($cart_items, true) as $line => $item) {

				if ($item->rule  && $item->rule['coupon_code'] != '') {
					$response['extra']['coupons'][][0] = ['value' => $item->rule['rule_id'],  'label' => $item->rule['name']];
					// dd($item->rule);
				}




				if (isset($item->modifier_items) && count($item->modifier_items) > 0) {
					foreach ($item->modifier_items as $key => $modifier) {
						$item->modifier_items[$key]['name'] = $modifier['display_name'];
						$item->modifier_items[$key]['id'] = $key;
						$item->modifier_items[$key]['modifier_item_id'] = $key;
						$item->modifier_items[$key]['unit_price_currency'] = to_currency($modifier['unit_price']);
					}
				}

				// dd($item->modifier_items);
				if ($item->discount > 0) {
					$response['extra']['discount_all_percent'] = $item->discount;
				}
				if ($item->quantity < 0) {
					$response['extra']['discount_all_flat'] = $item->unit_price;
				}

				$mods_for_item = $this->Item_modifier->get_modifiers_for_item_id($item->item_id)->result_array();

				if ($mods_for_item) {
					foreach ($mods_for_item as $modifier_item_id => $modifier_item) {

						// dd($modifier_item);
						$Item_modifier  = $this->Item_modifier->get_modifier_item_info($modifier_item['id']);
						// dd($Item_modifier);
						$mods_for_item[$modifier_item_id]['modifier_item_id'] = $modifier_item['id'];
						$mods_for_item[$modifier_item_id]['unit_price'] =  $Item_modifier['unit_price'];
						$mods_for_item[$modifier_item_id]['cost_price'] =  $Item_modifier['cost_price'];
						$mods_for_item[$modifier_item_id]['unit_price_currency'] =  to_currency($Item_modifier['unit_price']);
						$mods_for_item[$modifier_item_id]['modifier_item_name'] =   $Item_modifier['modifier_item_name'];
					}
				}

				$variatons = 	$this->item_variations($item->item_id, true);


				$quantity_units = $this->Item->get_quantity_units($item->item_id, true);
				$quantity_units_res = array();
				if (!empty($quantity_units)) {
					$quantity_units_res[0]['value'] = "0";
					$quantity_units_res[0]['text'] = lang('None');
					foreach ($quantity_units as $key => $value) {
						$quantity_units_res[$value['id']]['value'] = $value['id'];
						$quantity_units_res[$value['id']]['text'] = $value['unit_name'];
					}
					// dd($quantity_units);
				}
				// dd($item);

				// $item['quantity_unit_quantity'] = NULL;
				// $item['quantity_unit_id'] = NULL;
				$permissions = array(
					'allow_price_override_regardless_of_permissions' =>  $item->allow_price_override_regardless_of_permissions,
					'always_use_average_cost_method' => $this->config->item('always_use_average_cost_method'),
					'hide_supplier_on_sales_interface' => $this->config->item('hide_supplier_on_sales_interface'),
					'disable_supplier_selection_on_sales_interface' => $this->config->item('disable_supplier_selection_on_sales_interface'),
					'hide_description_on_sales_and_recv' => $this->config->item('hide_description_on_sales_and_recv'),
					'allow_alt_description' => $item->allow_alt_description,
					'change_cost_price' =>  $item->change_cost_price,
					'edit_serail_no' =>  	$this->Employee->has_module_action_permission('sales', 'edit_serail_no', $this->Employee->get_logged_in_employee_info()->person_id),
					'require_to_add_serial_number_in_pos' => $this->config->item('require_to_add_serial_number_in_pos'),
					'id_to_show_on_sale_interface' =>	$this->config->item('id_to_show_on_sale_interface'),
					'do_not_allow_out_of_stock_items_to_be_sold' =>	$this->config->item('do_not_allow_out_of_stock_items_to_be_sold'),
					'process_returns' => (!$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)),
					'process_returns_error' => lang('sales_not_allowed_returns'),
					'sales_could_not_discount_item_above_max' => lang('sales_could_not_discount_item_above_max'),
					'do_not_allow_below_cost' => $this->config->item('do_not_allow_below_cost'),
				);


				$id_to_show_on_sale_interface_val = '';
				switch ($this->config->item('id_to_show_on_sale_interface')) {
					case 'number':

						if (property_exists($item, 'item_number') && $item->item_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_number);
						} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_kit_number);
						} else {
							$id_to_show_on_sale_interface_val =  lang('none');
						}

						break;

					case 'product_id':
						$id_to_show_on_sale_interface_val =  property_exists($item, 'product_id') ? H($item->product_id) : lang('none');
						break;

					case 'id':
						$id_to_show_on_sale_interface_val =  property_exists($item, 'item_id') ? H($item->item_id) : 'KIT ' . H($item->item_kit_id);
						break;

					default:
						if (property_exists($item, 'item_number') && $item->item_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_number);
						} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_kit_number);
						} else {
							$id_to_show_on_sale_interface_val =  lang('none');
						}
						break;
				}


				$source_supplier_data = array();
				//array('-1' => lang('none'));
				foreach ($this->Item->get_all_suppliers_of_an_item($item->item_id)->result_array() as $row) {
					$source_supplier_data[$row['supplier_id']] = array('value' => $row['supplier_id'], 'text' => $row['company_name'] . ' (' . $row['full_name'] . ')');
				}


				$serial_numbers = [];
				$serialnumber = '';
				$serialnumberText = '';
				if ($item->is_serialized) {

					$sn_rec = $this->Item_serial_number->get_info_via_sn($item->serialnumber);
					// dd($sn_rec);
					if ($sn_rec) {
						$serialnumber = $sn_rec->id;
						$serialnumberText = $item->serialnumber;

						$serial_number_price = $this->Item_serial_number->get_price_for_serial($item->serialnumber);
						if ($serial_number_price !== FALSE) {
							$item->unit_price = $serial_number_price;
						}

						$serial_number_cost_price = $this->Item_serial_number->get_cost_price_for_serial($item->serialnumber);
						if ($serial_number_cost_price !== FALSE) {
							$item->cost_price = $serial_number_cost_price;
						}
					}
					$serial_numbers = $this->Item_serial_number->get_all_data($item->item_id, $this->Employee->get_logged_in_employee_current_location_id(), $input = array());
				}

				$item_info = $this->item->get_info($item->item_id);
				$quantity_in_sale = 0;
				if ($response['extra']['suspended_type'] != 2) {
					$quantity_in_sale = $CI->Sale->get_quantity_sold_for_item_in_sale($response['extra']['sale_id'], $item->item_id, $item->variation_id);
				}
				$item_location_quantity = $this->Item_location->get_location_quantity($item_info->item_id);
				$response['items'][] = [
					'all_data' => [
						"quantity_in_sale" => $quantity_in_sale,
						"rules" => $CI->Price_rule->get_all_rule_for_item($item->item_id),
						"is_serialized" => $item->is_serialized,
						"serial_numbers" => $serial_numbers,
						"permissions" => $permissions,
						'source_supplier_data' => $source_supplier_data,
						"is_suspended" => true,
						"quantity_received" => to_quantity($item->quantity_received),
						"name" => $item->name,
						"description" => "",
						"tier_id" => $item->tier_id,
						"is_serialized" => $item->is_serialized,
						'category_name' => 	$this->Category->get_full_path($item->category_id),
						'category_id' => 	$item->category_id,
						"tier_name" => $item->tier_name,
						"item_id" => $item->item_id,
						'description' => 	clean_html($item->description),
						"quantity" => $item->quantity,
						"price" => $item->unit_price,
						"orig_price" => $item->unit_price,
						"cost_price" => $item->cost_price,
						"quantity_unit_id" => $item->quantity_unit_id,
						"supplier_id" => $item->cart_line_supplier_id,
						"quantity_unit_quantity" => $item->quantity_unit_quantity,
						"discount_percent" =>  $item->discount,
						'has_variations' => count($variatons) > 0 ? $variatons : FALSE,
						"modifiers" => $mods_for_item,
						"quantity_units" => $quantity_units_res,
						"selected_item_modifiers" => $item->modifier_items,
						"taxes" => $this->cart->get_item($line)->get_override_tax_info(),
						"item_attributes_available" => $this->Item_attribute->get_attributes_for_item_with_attribute_values_updated($item->item_id),
						"tax_included" => $item->tax_included,
						"line_total" => isset($item->line_total) ? $item->line_total : 0,
						"index" => $line,
						"id_to_show_on_sale_interface_val" => $id_to_show_on_sale_interface_val,
						"damaged_qty" => $item->damaged_qty,
						'is_series_package' => $item_info->is_series_package,
						'series_quantity' => $item_info->series_quantity,
						'series_days_to_use_within' => $item_info->series_days_to_use_within,
						'item_location_quantity' => $item_location_quantity,
						'is_service' => $item_info->is_service,
						'max_edit_price' => $item_info->max_edit_price,
						'min_edit_price' => $item_info->min_edit_price,
					],
					"quantity_in_sale" => $quantity_in_sale,
					"permissions" => $permissions,
					'source_supplier_data' => $source_supplier_data,
					"is_suspended" => true,
					"quantity_received" => to_quantity($item->quantity_received),
					"name" => $item->name,
					"description" => "",
					"tier_id" => $item->tier_id,
					'category_name' => 	$this->Category->get_full_path($item->category_id),
					'category_id' => 	$item->category_id,
					"tier_name" => $item->tier_name,
					"item_id" => $item->item_id,
					'description' => clean_html($item->description),
					"quantity" => $item->quantity,
					"price" => $item->unit_price,
					"orig_price" => $item->unit_price,
					"cost_price" => $item->cost_price,
					"quantity_unit_id" => $item->quantity_unit_id,
					"supplier_id" => $item->cart_line_supplier_id,
					"quantity_unit_quantity" => $item->quantity_unit_quantity,
					"discount_percent" =>  $item->discount,
					'has_variations' => count($variatons) > 0 ? $variatons : FALSE,
					"modifiers" => $mods_for_item,
					"quantity_units" => $quantity_units_res,
					"selected_item_modifiers" => $item->modifier_items,
					"taxes" => $this->cart->get_item($line)->get_override_tax_info(),
					"item_attributes_available" => $this->Item_attribute->get_attributes_for_item_with_attribute_values_updated($item->item_id),
					"tax_included" => $item->tax_included,
					"line_total" => isset($item->line_total) ? $item->line_total : 0,
					"index" => $line,
					"free_item" => ($item->unit_price == 0) ? true : false,
					"is_repair_item" => $item->is_repair_item,
					"selected_rule" => $item->rule,
					"serialnumber" => $serialnumber,
					"serialnumberText" => $serialnumberText,
					"id_to_show_on_sale_interface_val" => $id_to_show_on_sale_interface_val,
					"damaged_qty" => $item->damaged_qty,
					'is_series_package' => $item_info->is_series_package,
					'series_quantity' => $item_info->series_quantity,
					'series_days_to_use_within' => $item_info->series_days_to_use_within,
					'item_location_quantity' => $item_location_quantity,
					'is_service' => $item_info->is_service,
					'max_edit_price' => $item_info->max_edit_price,
					'min_edit_price' => $item_info->min_edit_price,
				];
			}
			// dd($this->cart->get_payments());

			if (count($this->cart->get_payments()) > 0) {
				foreach ($this->cart->get_payments() as $payment) {
					$response['payments'][] = [
						"payment_type" => $payment->payment_type,
						"amount" => $payment->payment_amount,
					];
				}
			}

			if (isset($this->cart->customer_id)) {
				$customer_info = $this->Customer->get_info($this->cart->customer_id);
				if (!empty($customer_info)) {
					$response['customer']['customer_name'] = $customer_info->full_name . "( " . $customer_info->phone_number . " )";
					$response['customer']['balance'] = $customer_info->balance;
					$response['customer']['email'] = $customer_info->email;
					$response['customer']['internal_notes'] = $customer_info->internal_notes;
					$response['customer']['person_id'] = $customer_info->person_id;
				}
			}

			if (isset($this->cart->override_tax_names[0])) {
				$i = 0;
				foreach ($this->cart->override_tax_names[0] as $name) {
					if ($this->cart->override_tax_percents[0][$i] > 0) {
						$response['taxes'][] = [
							"id" => $i + 1,
							"order" => $i,
							"tax_class_id" => $this->cart->override_tax_class,
							"name" => $name,
							"percent" => $this->cart->override_tax_percents[0][$i],
							"cumulative" => $this->cart->override_tax_cumulatives[0][$i],
							"ecommerce_tax_class_tax_rate_id" => null
						];
					}

					$i++;
				}
			}
		}

		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	function sales_reload($data = array(), $is_data = false)
	{

	

		//This is used for upgrade installs that never had this set (sales in progress)
		if ($this->cart->limit === NULL) {
			$this->cart->limit = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
			$this->cart->save();
		}

		if ($this->cart->offset === NULL) {
			$this->cart->offset = 0;
			$this->cart->save();
		}

		$the_cart_items = $this->cart->get_items();

		if ($this->cart->offset >= count($the_cart_items)) {
			$this->cart->offset = 0;
			$this->cart->save();
		}

		$data = array_merge($this->_get_shared_data(), $data);


		$config['base_url'] = site_url('sales/paginate');
		$config['per_page'] = $this->cart->limit;
		$config['uri_segment'] = -1; //Set this to non possible url so it doesn't use URL

		//Undocumented feature to get page
		$config['cur_page'] = $this->cart->offset;

		$config['total_rows'] = count($the_cart_items);


		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$data['is_tax_inclusive'] = $this->cart->is_tax_inclusive();
		$data['ebt_total'] = $this->cart->get_ebt_total_amount_to_charge() - $this->cart->get_payment_amount(lang('wic')) - $this->cart->get_payment_amount(lang('ebt'));

		$person_info = $this->Employee->get_logged_in_employee_info();
		$modes = array('sale' => lang('sales_sale'), 'return' => lang('sales_return'), 'estimate' => $this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate'));

		if (!$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) {
			unset($modes['return']);
		}

		$can_receive_store_account_payment = $this->Employee->has_module_action_permission('sales', 'receive_store_account_payment', $this->Employee->get_logged_in_employee_info()->person_id);

		if ($this->config->item('customers_store_accounts') && $can_receive_store_account_payment) {
			// Only allow Store Account Payment if there are items in the cart there are zero items in the cart
			if (count($the_cart_items) == 0) {
				$modes['store_account_payment'] = lang('store_account_payment');
			}
		}

		// if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced' &&  count(explode(":",$this->config->item('spend_to_point_ratio'),2)) == 2)
		// {
		// 	$modes['purchase_points'] = lang('sales_purchase_points');
		// }

		$data['has_coupons_for_today'] = $this->Sale->has_coupons_for_today();
		$data['sale_id_of_edit_or_suspended_sale'] = $this->cart->get_previous_receipt_id();

		if (!$data['sale_id_of_edit_or_suspended_sale']) {
			$data['sale_id_of_edit_or_suspended_sale'] = '';
			$data['was_cc_return'] = 0;
			$data['was_cc_sale'] = 0;
		} else {
			$sale_info = $this->Sale->get_info($data['sale_id_of_edit_or_suspended_sale'])->row();
			$data['was_cc_return'] = $this->Sale->can_void_cc_return($data['sale_id_of_edit_or_suspended_sale'])  ? 1 : 0;
			$data['was_cc_sale'] = $this->Sale->can_void_cc_sale($data['sale_id_of_edit_or_suspended_sale']) ? 1 : 0;
		}

		$data['coupons'] = array();
		$data['has_discount'] = $this->cart->has_discount();
		$data['modes'] = $modes;
		$data['line_for_flat_discount_item'] = $this->cart->get_index_for_flat_discount_item();
		$data['discount_all_percent'] = $this->cart->get_discount_all_percent();
		$data['discount_all_fixed'] = $this->cart->get_discount_all_fixed();
		$data['items_module_allowed'] = $this->Employee->has_module_permission('items', $person_info->person_id);
		$data['current_location'] = $this->Employee->get_logged_in_employee_current_location_id();
		if (!$this->session->userdata('foreign_language_to_cur_language_sales')) {
			$this->load->helper('directory');
			$language_folder = directory_map(APPPATH . 'language', 1);

			$languages = array();

			foreach ($language_folder as $language_folder) {
				$languages[] = substr($language_folder, 0, strlen($language_folder) - 1);
			}

			$cur_lang = array();
			foreach ($this->Sale->get_payment_options_with_language_keys() as $cur_lang_value => $lang_key) {
				$cur_lang[$lang_key] = $cur_lang_value;
			}


			foreach ($languages as $language) {
				$this->lang->load('common', $language);

				foreach ($this->Sale->get_payment_options_with_language_keys() as $cur_lang_value => $lang_key) {
					if (strpos($lang_key, 'common') !== FALSE) {
						$foreign_language_to_cur_language[lang($lang_key)] = $cur_lang[$lang_key];
					} else {
						$foreign_language_to_cur_language[$cur_lang_value] = $cur_lang_value;
					}
				}
			}

			$this->session->set_userdata('foreign_language_to_cur_language_sales', $foreign_language_to_cur_language);
			//Switch back
			$this->lang->switch_to($this->config->item('language'));
		} else {
			$foreign_language_to_cur_language = $this->session->userdata('foreign_language_to_cur_language_sales');
		}

		$default_payment_type_translated = false;
		if (isset($foreign_language_to_cur_language[$this->config->item('default_payment_type')])) {
			$default_payment_type_translated = $foreign_language_to_cur_language[$this->config->item('default_payment_type')];
		} else {
			$default_payment_type_translated = $this->config->item('default_payment_type');
		}

		$data['default_payment_type'] = $default_payment_type_translated ? $default_payment_type_translated : lang('cash');

		$data['is_over_credit_limit'] = false;
		$data['fullscreen'] = $this->session->userdata('fullscreen');
		$data['redeem'] = $this->cart->redeem_discount;

		$customer_id = $this->cart->customer_id;

		if ($customer_id) {
			$cust_info = $this->Customer->get_info($customer_id, TRUE);

			$customer_giftcards = $this->Giftcard->get_customer_giftcards($customer_id);
		}

		$data['prompt_for_card'] = $this->cart->prompt_for_card;
		$data['show_terms_and_conditions'] = $this->cart->show_terms_and_conditions;
		$data['cc_processor_class_name'] = $this->_get_cc_processor() ? strtoupper(get_class($this->_get_cc_processor())) : '';
		$data['cc_processor_parent_class_name'] = $this->_get_cc_processor() ? strtoupper(get_parent_class($this->_get_cc_processor())) : '';

		$data['ebt_voucher'] = $this->cart->ebt_voucher;
		$data['ebt_voucher_no'] = $this->cart->ebt_voucher_no;
		$data['ebt_auth_code'] = $this->cart->ebt_auth_code;


		if ($this->config->item('select_sales_person_during_sale')) {
			$employees = array('' => lang('not_set'));

			foreach ($this->Employee->get_all()->result() as $employee) {
				if ($this->Employee->is_employee_authenticated($employee->person_id, $this->Employee->get_logged_in_employee_current_location_id())) {
					$employees[$employee->person_id] = $employee->first_name . ' ' . $employee->last_name;
				}
			}
			$data['employees'] = $employees;
			$data['selected_sold_by_employee_id'] = $this->cart->sold_by_employee_id;
		}

		$tiers = array();

		$tiers[0] = lang('none');
		foreach ($this->Tier->get_all()->result() as $tier) {
			$tiers[$tier->id] = $tier->name;
		}

		$data['tiers'] = $tiers;

		$data['payment_options'] = $this->Sale->get_payment_options($this->cart);

		if ($customer_id) {
			$data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name . ($cust_info->company_name == ''  ? '' : ' (' . $cust_info->company_name . ')');
			$data['customer_email'] = $cust_info->email;
			$data['customer_phone'] = format_phone_number($cust_info->phone_number);
			$data['customer_internal_notes'] = $cust_info->internal_notes;

			$this->load->model('Customer');
			$data['customer_has_address'] = $this->Customer->does_customer_have_address($customer_id);
			$data['customer_balance'] = $cust_info->balance;
			$data['customer_credit_limit'] = $cust_info->credit_limit;
			$data['is_over_credit_limit'] = $this->Customer->is_over_credit_limit($customer_id, $this->cart->get_payment_amount(lang('store_account')));
			$data['customer_id'] = $customer_id;
			$data['customer_cc_token'] = $cust_info->cc_token;
			$data['customer_cc_preview'] = $cust_info->cc_preview;
			$data['save_credit_card_info'] = $this->cart->save_credit_card_info;
			$data['use_saved_cc_info'] = $this->cart->use_cc_saved_info;
			$data['avatar'] = $cust_info->image_id ?  cacheable_app_file_url($cust_info->image_id) : base_url() . "assets/img/user.png"; //can be changed to  base_url()."img/avatar.png" if it is required
			if (count($customer_giftcards)) {
				$data['customer_giftcards'] = $customer_giftcards;
			}
			$data['disable_loyalty'] = $cust_info->disable_loyalty;
			$data['auto_email_receipt'] = $cust_info->auto_email_receipt;
			$data['always_sms_receipt'] = $cust_info->always_sms_receipt;

			$data['points'] = to_currency_no_money($cust_info->points);
			$data['sales_until_discount'] = ($this->config->item('number_of_sales_for_discount')) ? (float)$this->config->item('number_of_sales_for_discount') - (float)$cust_info->current_sales_for_discount : 0;
		}
		$data['customer_required_check'] = (!$this->config->item('require_customer_for_sale') || ($this->config->item('require_customer_for_sale') && isset($customer_id) && $customer_id));

		if ($this->cart->has_recurring_item() && !$customer_id) {
			$data['customer_required_check'] = FALSE;
		}
		$data['suspended_sale_customer_required_check'] = (!$this->config->item('require_customer_for_suspended_sale') || ($this->config->item('require_customer_for_suspended_sale') && isset($customer_id) && $customer_id));
		$data['payments_cover_total'] = $this->_payments_cover_total();

		if ($data['mode'] == 'store_account_payment' && $customer_id) {
			$sale_ids = $this->Sale->get_unpaid_store_account_sale_ids($customer_id);

			$paid_sales = $this->cart->get_paid_store_account_ids();

			$data['unpaid_store_account_sales'] = $this->Sale->get_unpaid_store_account_sales($sale_ids);

			for ($k = 0; $k < count($data['unpaid_store_account_sales']); $k++) {
				if (isset($paid_sales[$data['unpaid_store_account_sales'][$k]['sale_id']])) {
					$data['unpaid_store_account_sales'][$k]['paid'] = TRUE;
				}
			}
		}


		//fixing this for arabic
		if (is_rtl_lang()) {
			$data['discount_editable_placement'] = $this->agent->is_mobile() && !$this->agent->is_tablet() ? 'right' : 'right';
		} else {
			$data['discount_editable_placement'] = $this->agent->is_mobile() && !$this->agent->is_tablet() ? 'right' : 'right';
		}


		$payment_options = array_values($this->Sale->get_payment_options($this->cart));

		$markup_markdown = $this->config->item('markup_markdown');
		$markup_markdown_config = $markup_markdown ? unserialize($markup_markdown) : null;


		$data['markup_predictions'] = array();
		if ($markup_markdown && $this->cart->get_total() > 0 && !$this->Location->get_info_for_key('disable_markup_markdown')) {
			foreach ($payment_options as $payment_type) {
				if (isset($markup_markdown_config[$payment_type])) {
					$fee_percent = $markup_markdown_config[$payment_type];
					$fee_amount = $this->cart->get_total() * ($fee_percent / 100);

					$data['markup_predictions'][$payment_type] = array('amount' => $fee_amount, 'id' => md5($payment_type));
				} else {
					$data['markup_predictions'][$payment_type] = array('amount' => 0, 'id' => md5($payment_type));
				}
			}
		}

		// Get Work Order Statuses for dropdown list in register view 
		$data['work_order_statuses'] = $this->Work_order->get_all_statuses();
		// Get Work Order ID 
		$data['work_order_id'] = $this->Work_order->get_info_by_sale_id($data['cart']->sale_id)->row()->id ?? NULL;

		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor && method_exists($credit_card_processor, 'update_transaction_display')) {
			$data['update_transaction_display'] = TRUE;
		}
		$data['override_taxes'] = $this->cart->get_override_taxes();

		if ($is_data) {
			return $data;
		} else {

			if ($this->config->item('speedy_pos')) {
				if ($this->agent->is_mobile()) {
					$this->load->view("sales/offline/mobile/register_sales_offline", $data);
				} else {
					$this->load->view("sales/offline/register_initial_quick_offline", $data);
				}
				//offline version mudasir

				//offline version mudasir	
			} else {
				$this->load->view("sales/register_sales", $data);
			}
		}
	}

	function update_transaction_display()
	{
		session_write_close();
		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor && method_exists($credit_card_processor, 'update_transaction_display')) {
			$credit_card_processor->update_transaction_display($this->cart);
		}
	}

	function pay_store_account_sale($sale_id, $amount)
	{
		
		$this->cart->add_paid_store_account_payment_id($sale_id, $amount);
		$cart = $this->cart->get_items();
	
		foreach ($cart as $item) {
			if ($item->name == lang('store_account_payment')) {
				$item->unit_price += $amount;
				break;
			}
		}
		$comment = lang('sales_pays_sales') . ' - ' . implode(', ', array_keys($this->cart->get_paid_store_account_ids()));
	
		$this->cart->comment = $comment;
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		$this->cart->sold_by_employee_id =$employee_id;
		$this->cart->save();
	
		// $this->_reload();
		echo $this->Customer->get_store_account_details($this->cart, $this->cart->customer_id);
	}

	function toggle_pay_all_store_account()
	{
		$sale_ids = $this->Sale->get_unpaid_store_account_sale_ids($this->cart->customer_id);

		$unpaid_sales = $this->Sale->get_unpaid_store_account_sales($sale_ids);

		if (count($this->cart->get_paid_store_account_ids()) ==  0) {
			$amount_to_pay = 0;

			foreach ($unpaid_sales as $unpaid_sale) {
				$this->cart->add_paid_store_account_payment_id($unpaid_sale['sale_id'], $unpaid_sale['payment_amount']);
				$amount_to_pay += $unpaid_sale['payment_amount'];
			}

			$cart = $this->cart->get_items();
			foreach ($cart as $item) {
				if ($item->name == lang('store_account_payment')) {
					$item->unit_price = $amount_to_pay;
					break;
				}
			}

			$comment = lang('sales_pays_sales') . ' - ' . implode(', ', array_keys($this->cart->get_paid_store_account_ids()));
		} else {
			$comment  = '';
			$this->cart->delete_all_paid_store_account_payment_ids();

			$cart = $this->cart->get_items();
			foreach ($cart as $item) {
				if ($item->name == lang('store_account_payment')) {
					$item->unit_price = 0;
					break;
				}
			}
		}

		$this->cart->comment = $comment;
		$this->cart->save();
		echo $this->Customer->get_store_account_details($this->cart, $this->cart->customer_id);
	}

	function delete_store_account_sale($sale_id, $amount)
	{
		if (isset($this->cart->paid_store_account_amounts[$sale_id])) {
			$amount = $this->cart->paid_store_account_amounts[$sale_id];
		}

		$this->cart->delete_paid_store_account_id($sale_id);
		$cart = $this->cart->get_items();
		foreach ($cart as $item) {
			if ($item->name == lang('store_account_payment')) {
				$item->unit_price -= $amount;
				break;
			}
		}
		$comment = lang('sales_pays_sales') . ' - ' . implode(', ', array_keys($this->cart->get_paid_store_account_ids()));

		$this->cart->comment = $comment;
		$this->cart->save();
		// $this->_reload();
		echo $this->Customer->get_store_account_details($this->cart, $this->cart->customer_id);
	}


	//this method also used for customer wise suspended sales also
	function customer_recent_sales($customer_id)
	{
		$data['customer'] = $this->Customer->get_info($customer_id)->first_name . ' ' . $this->Customer->get_info($customer_id)->last_name;
		$data['customer_comments'] = $this->Customer->get_info($customer_id)->comments;
		$data['customer_id'] = $customer_id;

		$data['recent_sales'] = $this->Sale->get_recent_sales_for_customer($customer_id);


		$data['suspended_sales'] = $this->Sale->get_all_suspended(NULL, $customer_id);

		$this->load->view("sales/customer_recent_sales", $data);
	}


	function cancel_sale()
	{
		if ($this->Location->get_info_for_key('enable_credit_card_processing')) {
			$credit_card_processor = $this->_get_cc_processor();

			if ($credit_card_processor && method_exists($credit_card_processor, 'void_partial_transactions')) {
				if (!$credit_card_processor->void_partial_transactions()) {
					$this->cart->destroy();
					$this->cart->save();
					$this->sales_reload(array('error' => lang('sales_attempted_to_reverse_transactions_failed_please_contact_support')), true);
					return;
				}
			}
		}

		$this->cart->destroy();
		$this->cart->save();
		$this->Sale->delete_open_suspended_sales();
		$this->sales_reload();
	}

	function clear_sale()
	{
		$this->cart->destroy();
		$this->cart->save();
		$this->_reload();
	}

	function suspend_speedy($suspend_type = 1)
	{






		if (!$this->Employee->has_module_action_permission('sales', 'suspend_sale', $this->Employee->get_logged_in_employee_info()->person_id)) {
			echo 	json_encode(array('error' => lang('sales_you_do_not_have_permission_to_suspend_sales')), false);
			return;
		}


		$sales = json_decode($this->input->post('offline_sales'), TRUE);
		$offline_sale = $sales[0];


		$offline_sale_cart = new PHPPOSCartSale();



		$line = 0;
		$offline_sale_cart->location_id = $this->Employee->get_logged_in_employee_current_location_id();;
		date_default_timezone_set($this->Location->get_info_for_key('timezone', $offline_sale_cart->location_id));

		$offline_sale_cart->register_id = $this->Employee->get_logged_in_employee_current_register_id();

		if (!$offline_sale_cart->register_id) {
			$offline_sale_cart->register_id = $this->Employee->getDefaultRegister($this->Employee->get_logged_in_employee_info()->person_id, $this->Employee->get_logged_in_employee_current_location_id());
		}
		$offline_sale_cart->employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

		if (isset($offline_sale['customer']['person_id'])) {
			if ($this->config->item('enable_customer_quick_add') && strpos($offline_sale['customer']['person_id'], 'QUICK_ADD|') !== FALSE) {
				$offline_sale['customer']['person_id'] = str_replace('QUICK_ADD|', '', $offline_sale['customer']['person_id']);
				$offline_sale['customer']['person_id'] = str_replace('|FORCE_PERSON_ID|', '', $offline_sale['customer']['person_id']);
				$this->load->helper('text');
				list($first_name, $last_name) = split_name($offline_sale['customer']['person_id']);
				$person_data = array('first_name' => $first_name, 'last_name' => $last_name);
				$customer_data = array();
				$customer_data['internal_notes'] = (isset($offline_sale['customer']['internal_notes'])) ? $offline_sale['customer']['internal_notes'] : '';
				$this->Customer->save_customer($person_data, $customer_data);
				$offline_sale['customer']['person_id'] =  $person_data['person_id'];
				$offline_sale_cart->customer_id = $offline_sale['customer']['person_id'];
			} else {

				$offline_sale_cart->customer_id = $offline_sale['customer']['person_id'];
				$customer_data['internal_notes'] = (isset($offline_sale['customer']['internal_notes'])) ? $offline_sale['customer']['internal_notes'] : '';
				$person_data = array();
				$this->Customer->save_customer($person_data, $customer_data, $offline_sale['customer']['person_id']);
			}
		}






		if (isset($offline_sale['payments'])) {
			foreach ($offline_sale['payments'] as $payment) {
				$offline_sale_cart->add_payment(new PHPPOSCartPaymentSale(array(
					'payment_type' => $payment['type'],
					'payment_amount' => $payment['amount'],
					'payment_date' => date('Y-m-d H:i:s'),
				)));
			}
		}
		if (isset($offline_sale['extra']['discount_all_flat']) && $offline_sale['extra']['discount_all_flat']) {
			$line = 1;
			$value = $offline_sale['extra']['discount_all_flat'];
			$item_id = $this->Item->create_or_update_flat_discount_item($offline_sale_cart->is_tax_inclusive() ? 1 : 0);
			$description =  strpos($value, '%', 0) ? lang('sales_discount_percent') . ': ' . $value : '';
			$discount_amount = strpos($value, '%', 0) !== FALSE ? (($offline_sale_cart->get_subtotal() + $offline_sale_cart->get_discount_all_fixed()) * (float)$value / 100) : (float)$value;
			$discount_item = new PHPPOSCartItemSale(array('cart' => $offline_sale_cart, 'scan' => $item_id . '|FORCE_ITEM_ID|', 'cost_price' => 0, 'unit_price' => to_currency_no_money($discount_amount), 'description' => $description, 'quantity' => -1));
			$offline_sale_cart->add_item($discount_item);
		}

		if (isset($offline_sale['taxes']) && $offline_sale['taxes']) {
			$max = 4;
			$data = array();
			$tax_names = array();
			$tax_percents = array();
			$tax_cumulatives = array(0, 0, 0, 0, 0);
			$override_tax_class = '';

			if (!isset($offline_sale['taxes'][0]['tax_class_id'])) {
				for ($i = 0; $i <= $max; $i++) {
					if (isset($offline_sale['taxes'][$i]['name'])) {
						$tax_names[$i] =	$offline_sale['taxes'][$i]['name'];
						$tax_percents[$i] =	$offline_sale['taxes'][$i]['percent'];
					} else {
						$tax_names[$i] =	'';
						$tax_percents[$i] =	'';
					}
				};
			} else {
				$override_tax_class = $offline_sale['taxes'][0]['tax_class_id'];
			}




			$offline_sale_cart->override_tax_names = $tax_names;
			$offline_sale_cart->override_tax_percents = $tax_percents;
			$offline_sale_cart->override_tax_cumulatives = $tax_cumulatives;
			$offline_sale_cart->override_tax_class = $override_tax_class;
		}

		$offline_sale['items'] = array_filter($offline_sale['items'], function ($item) {
			return $item['name'] !== 'discount';
		});
		// dd($offline_sale['items']);

		if (isset($offline_sale['items'])) {


			// dd($offline_sale_cart);
			foreach ($offline_sale['items'] as $item) {


				if (isset($item['free_item'])) {
					continue; /// this is free item not actual item
				}


				if (isset($item['selected_item_modifiers']) && is_array($item['selected_item_modifiers'])) {
					$modifier_items = array();

					foreach ($item['selected_item_modifiers'] as $mi) {
						$display_name = to_currency($mi['unit_price']) . ': ' . $mi['modifier_item_name'];
						$modifier_items[$mi['modifier_item_id']] = array('display_name' => $display_name, 'unit_price' => $mi['unit_price'], 'cost_price' => $mi['cost_price']);
					}

					$item['modifier_items'] = $modifier_items;
				}

				$cur_item_info = $this->Item->get_info($item['item_id']);
				$cur_item_location_info = $this->Item_location->get_info($item['item_id'], $offline_sale_cart->location_id);
				$cur_item_variation_info = $this->Item_variations->get_info(isset($item['variation_id']) ? $item['variation_id'] : -1);

				$item['type'] = 'sale';
				if ($cur_item_variation_info && $cur_item_variation_info->unit_price) {
					$item['regular_price'] = $cur_item_variation_info->unit_price;
				} else {
					$item['regular_price'] = ($cur_item_location_info && $cur_item_location_info->unit_price) ? $cur_item_location_info->unit_price : $cur_item_info->unit_price;
				}

				$cart_item_to_add = array();

				$cart_item_to_add['cart'] = $offline_sale_cart;

				$cart_item_to_add['scan'] = $item['item_id'] . (isset($item['selected_variation']) && $item['selected_variation'] ? '#' . $item['selected_variation'] : '') . '|FORCE_ITEM_ID|';

				$cart_item_to_add['unit_price'] = $item['price'];
				$cart_item_to_add['discount'] = $item['discount_percent'];
				$cart_item_to_add['description'] = $item['description'];
				$cart_item_to_add['quantity'] = $item['quantity'];

				$cart_item_to_add['tier_id'] = (isset($item['tier_id'])) ? $item['tier_id'] : '';
				$cart_item_to_add['quantity_received'] = (isset($item['quantity_received'])) ? $item['quantity_received'] : 0;
				if (isset($item['serialnumberText']) &&  $item['serialnumberText'] != '') {
					$cart_item_to_add['serialnumber'] = $item['serialnumberText'];
				}
				$cart_item_to_add['damaged_qty'] = (isset($item['damaged_qty'])) ? $item['damaged_qty'] : 0;
				$cart_item_to_add['tier_name'] = (isset($item['tier_name'])) ? $item['tier_id'] : '';

				$cart_item_to_add['modifier_items'] =  array();

				if (isset($item['selected_item_modifiers'])) {
					foreach ($item['selected_item_modifiers']  as $key => $mid) {

						$mi = $this->Item_modifier->get_modifier_item_info($key);
						$display_name = to_currency($mid['unit_price']) . ': ' . $mi['modifier_item_name'];

						$cart_item_to_add['modifier_items'][$key] = array('display_name' => $display_name, 'unit_price' => $mid['unit_price'], 'cost_price' => $mid['cost_price']);
					}
				}

				if (strtoupper(substr($item['item_id'], 0, 3)) == 'KIT') {
					$item_to_add = new PHPPOSCartItemKitSale($cart_item_to_add);
				} else {
					$item_to_add = new PHPPOSCartItemSale($cart_item_to_add);
				}
				// dd($item_to_add->item_id);
				$offline_sale_cart->add_item($item_to_add);


				if (isset($item['taxes']) && is_array($item['taxes'])) {
					// dd($item['taxes']);
					$max = 4;
					$tax_names = array();
					$tax_percents = array();
					$tax_cumulatives = array(0, 0, 0, 0, 0);
					$override_tax_class = '';
					for ($i = 0; $i <= $max; $i++) {
						if (isset($item['taxes'][$i]) && $item['taxes'][$i]['name'] != '') {
							$tax_names[$i] =    $item['taxes'][$i]['name'];
							$tax_percents[$i] =    $item['taxes'][$i]['percent'];
							$tax_cumulatives[$i] =    $item['taxes'][$i]['cumulative'];
						}

						if (isset($item['taxes'][$i]['tax_class_id']) && $item['taxes'][$i]['tax_class_id'] != '') {
							$override_tax_class = $item['taxes'][$i]['tax_class_id'];
						}
					}



					$offline_sale_cart->get_item($line)->override_tax_names = $tax_names;
					$offline_sale_cart->get_item($line)->override_tax_percents = $tax_percents;
					$offline_sale_cart->get_item($line)->override_tax_cumulatives =  $tax_cumulatives;
					$offline_sale_cart->get_item($line)->override_tax_class = $override_tax_class;





					$offline_sale_cart->save();
				}

				if (isset($item['quantity_unit_id'])) {

					$offline_sale_cart->get_item($line)->quantity_unit_quantity = $item['quantity_unit_quantity'];
					$offline_sale_cart->get_item($line)->quantity_unit_id = $item['quantity_unit_id'];
				}

				if (isset($item['supplier_id'])) {
					$offline_sale_cart->get_item($line)->cart_line_supplier_id = $item['supplier_id'];
				}

				if (isset($offline_sale['customer']['person_id']) && $offline_sale['customer']['person_id']) {
					if (isset($item['all_data']['is_series_package']) && $item['all_data']['is_series_package'] == 1) {

						$offline_sale_cart->get_item($line)->is_series_package = 1;
						$offline_sale_cart->get_item($line)->series_quantity = $item['all_data']['series_quantity'];
						$offline_sale_cart->get_item($line)->series_days_to_use_within = $item['all_data']['series_days_to_use_within'];
					}
				}


				$offline_sale_cart->get_item($line)->unit_price = $item['price'];
				$offline_sale_cart->get_item($line)->cost_price = $item['cost_price'];

				// dd($offline_sale_cart);
				$line++;
			}
		}
		// dd($offline_sale_cart);


		if (isset($offline_sale['extra']['comment']) && $offline_sale['extra']['comment']) {
			$offline_sale_cart->comment = $offline_sale['extra']['comment'];
		}

		if ($this->config->item('sort_receipt_column')) {
			$offline_sale_cart->sort_items($this->config->item('sort_receipt_column'));
		}

		$data = $this->_get_shared_data();
		$data['receipt_title'] = $this->config->item('override_receipt_title') ? $this->config->item('override_receipt_title') : '';
		$data['transaction_time'] = date(get_date_format() . ' ' . get_time_format());
		$data['sales_card_statement'] = $this->config->item('override_signature_text') ? $this->config->item('override_signature_text') : lang('sales_card_statement', '', array(), TRUE);
		$exchange_rate = $offline_sale_cart->get_exchange_rate() ? $offline_sale_cart->get_exchange_rate() : 1;
		$store_account_in_all_languages = get_all_language_values_for_key('common_store_account', 'common');

		$data['balance'] = 0;
		//Add up balances for all languages
		foreach ($store_account_in_all_languages as $store_account_lang) {
			//Thanks Mike for math help on how to convert exchange rate back to get correct balance
			$data['balance'] += $offline_sale_cart->get_payment_amount($store_account_lang) * pow($exchange_rate, -1);
		}
		$offline_sale_cart->suspended = $suspend_type;
		$sale_date = $this->config->item('change_sale_date_when_suspending') ? date('Y-m-d H:i:s') : FALSE;
		if ($offline_sale_cart->change_date_enable) {
			$sale_date = $offline_sale_cart->change_cart_date;
		}

		if ($sale_date !== FALSE) {
			$offline_sale_cart->change_date_enable = TRUE;
			$offline_sale_cart->change_cart_date = $sale_date;
		}

		$offline_sale_cart->save();
		if ((isset($offline_sale['extra']['coupons'])) && $offline_sale['extra']['coupons'][0]) {
			$offline_sale_cart->set_coupons($offline_sale['extra']['coupons'][0]);
		}
		if ((isset($offline_sale['extra']['mode']))) {
			$offline_sale_cart->set_mode($offline_sale['extra']['mode']);
		} else {
			$offline_sale_cart->set_mode('sale');
		}
		$sale_id = $this->Sale->save($offline_sale_cart, false);

		if ($sale_id == $this->config->item('sale_prefix') . ' -1') {
			echo 	json_encode(array('error' => lang('sales_transaction_failed')));
			return;
		}
		$offline_sale_cart->destroy();
		$offline_sale_cart->save();

		update_data_by_where('phppos_sales', array('sale_json' => $this->input->post('offline_sales')), 'sale_id = ' . $sale_id . ' ');


		$work_order_info = $this->Work_order->get_info_by_sale_id($sale_id)->row_array();

		if (isset($work_order_info['id'])) {
			$work_order_id = $work_order_info['id'];
			if ($work_order_id) {

				if ($suspend_type == 1) {
					$suspended_type_text = ($this->config->item('user_configured_layaway_name') ? $this->config->item('user_configured_layaway_name') : lang('layaway'));
				} elseif ($suspend_type == 2) {
					$suspended_type_text = ($this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate'));
				} else {
					$this->load->model('Sale_types');
					$suspended_type_text = $this->Sale_types->get_info($suspend_type)->name;
				}


				$activity_text = lang('suspended_work_order') . ' [' . $suspended_type_text . ']';
				$this->Work_order->log_activity($work_order_id, $activity_text);
			}
		}


		echo json_encode(array('success' => lang('sales_successfully_suspended_sale'), 'async_inventory_updates' => TRUE, 'sale_id' => $sale_id));
	}


	function suspend($suspend_type = 1)
	{
		if (!$this->Employee->has_module_action_permission('sales', 'suspend_sale', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$this->sales_reload(array('error' => lang('sales_you_do_not_have_permission_to_suspend_sales')), false);
			return;
		}

		if ($this->config->item('sort_receipt_column')) {
			$this->cart->sort_items($this->config->item('sort_receipt_column'));
		}

		$data = $this->_get_shared_data();
		$data['receipt_title'] = $this->config->item('override_receipt_title') ? $this->config->item('override_receipt_title') : '';
		$data['transaction_time'] = date(get_date_format() . ' ' . get_time_format());
		$data['sales_card_statement'] = $this->config->item('override_signature_text') ? $this->config->item('override_signature_text') : lang('sales_card_statement', '', array(), TRUE);

		$exchange_rate = $this->cart->get_exchange_rate() ? $this->cart->get_exchange_rate() : 1;
		$store_account_in_all_languages = get_all_language_values_for_key('common_store_account', 'common');

		$data['balance'] = 0;
		//Add up balances for all languages
		foreach ($store_account_in_all_languages as $store_account_lang) {
			//Thanks Mike for math help on how to convert exchange rate back to get correct balance
			$data['balance'] += $this->cart->get_payment_amount($store_account_lang) * pow($exchange_rate, -1);
		}

		$this->cart->suspended = $suspend_type;
		//SAVE sale to database

		$sale_date = $this->config->item('change_sale_date_when_suspending') ? date('Y-m-d H:i:s') : FALSE;
		if ($this->cart->change_date_enable) {
			$sale_date = $this->cart->change_cart_date;
		}

		if ($sale_date !== FALSE) {
			$this->cart->change_date_enable = TRUE;
			$this->cart->change_cart_date = $sale_date;
		}

		$sale_id = $this->Sale->save($this->cart);


		if ($sale_id == $this->config->item('sale_prefix') . ' -1') {
			$this->sales_reload(array('error' => lang('sales_transaction_failed')));
			return;
		}


		$this->cart->destroy();
		$this->cart->save();

		$work_order_info = $this->Work_order->get_info_by_sale_id($sale_id)->row_array();

		if (isset($work_order_info['id'])) {
			$work_order_id = $work_order_info['id'];
			if ($work_order_id) {

				if ($suspend_type == 1) {
					$suspended_type_text = ($this->config->item('user_configured_layaway_name') ? $this->config->item('user_configured_layaway_name') : lang('layaway'));
				} elseif ($suspend_type == 2) {
					$suspended_type_text = ($this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate'));
				} else {
					$this->load->model('Sale_types');
					$suspended_type_text = $this->Sale_types->get_info($suspend_type)->name;
				}


				$activity_text = lang('suspended_work_order') . ' [' . $suspended_type_text . ']';
				$this->Work_order->log_activity($work_order_id, $activity_text);
			}
		}

		if ($this->config->item('show_receipt_after_suspending_sale')) {
			redirect('sales/receipt/' . $sale_id);
		} else {
			$this->sales_reload(array('success' => lang('sales_successfully_suspended_sale'), 'async_inventory_updates' => TRUE));
		}
	}


	function batch_sale()
	{
		$this->load->view("sales/batch");
	}

	function _excel_get_header_row()
	{
		return array(lang('item_id') . '/' . lang('item_number') . '/' . lang('product_id'), lang('unit_price'), lang('quantity'), lang('discount_percent'), lang('description'), lang('serial_number'));
	}

	function excel()
	{
		$this->load->helper('report');
		$header_row = $this->_excel_get_header_row();
		$this->load->helper('spreadsheet');
		array_to_spreadsheet(array($header_row), 'batch_sale_export.' . ($this->config->item('spreadsheet_format') == 'XLSX' ? 'xlsx' : 'csv'));
	}


	function do_excel_import()
	{
		$this->load->helper('demo');

		$file_info = pathinfo($_FILES['file_path']['name']);
		if ($file_info['extension'] != 'xlsx' && $file_info['extension'] != 'csv') {
			echo json_encode(array('success' => false, 'message' => lang('upload_file_not_supported_format')));
			return;
		}

		set_time_limit(0);
		ini_set('max_input_time', '-1');
		//$this->check_action_permission('add_update');
		$this->db->trans_start();

		$msg = 'do_excel_import';
		$failCodes = array();

		if ($_FILES['file_path']['error'] != UPLOAD_ERR_OK) {
			$msg = lang('excel_import_failed');
			echo json_encode(array('success' => false, 'message' => $msg));
			$this->db->trans_complete();
			return;
		} else {
			if (($handle = fopen($_FILES['file_path']['tmp_name'], "r")) !== FALSE) {
				$this->load->helper('spreadsheet');
				$file_info = pathinfo($_FILES['file_path']['name']);

				$sheet = file_to_spreadsheet($_FILES['file_path']['tmp_name'], $file_info['extension']);
				$num_rows = $sheet->getNumberOfRows();

				//Loop through rows, skip header row
				for ($k = 2; $k <= $num_rows; $k++) {

					$item_id = $sheet->getCellByColumnAndRow(0, $k);
					if (!$item_id) {
						continue;
					}

					$price = $sheet->getCellByColumnAndRow(1, $k);
					if (!$price) {
						$price = null;
					}

					$quantity = $sheet->getCellByColumnAndRow(2, $k);
					if (!$quantity) {
						continue;
					}

					$discount = $sheet->getCellByColumnAndRow(3, $k);
					if (!$discount) {
						$discount = 0;
					}

					$description = $sheet->getCellByColumnAndRow(4, $k);
					if (!$description) {
						$description = null;
					}

					$serial_number = $sheet->getCellByColumnAndRow(5, $k);
					if (!$serial_number) {
						$serial_number = null;
					}


					if ($this->cart->is_valid_item_kit($item_id)) {
						if (!$this->cart->add_item_kit(new PHPPOSCartItemKitSale(array('unit_price' => $price, 'description' => $description, 'discount' => $discount, 'cart' => $this->cart, 'scan' => $item_id, 'quantity' => $quantity)))) {
							$this->cart->empty_items();
							$this->cart->save();
							echo json_encode(array('success' => false, 'message' => lang('batch_sales_error')));
							return;
						}
					} else {
						$item_to_add = new PHPPOSCartItemSale(array('unit_price' => $price, 'description' => $description, 'discount' => $discount, 'cart' => $this->cart, 'scan' => $item_id, 'quantity' => $quantity, 'serialnumber' => $serial_number));

						if ($item_to_add->item_id && !$this->cart->add_item($item_to_add)) {
							$this->cart->empty_items();
							$this->cart->save();
							echo json_encode(array('success' => false, 'message' => lang('batch_sales_error')));
							$this->db->trans_complete();
							return;
						}
					}
				}
			} else {
				$this->cart->save();
				echo json_encode(array('success' => false, 'message' => lang('upload_file_not_supported_format')));
				$this->db->trans_complete();
				return;
			}
		}
		$this->cart->save();
		$this->db->trans_complete();
		echo json_encode(array('success' => true, 'message' => lang('sales_import_successfull')));
	}

	function giftcard_exists_and_balance()
	{
		$response = NULL;

		if ($this->Giftcard->get_giftcard_id($this->input->get('giftcard_number'))) {
			$giftcard_info = $this->Giftcard->get_info($this->Giftcard->get_giftcard_id($this->input->get('giftcard_number')));
			$response['exists'] = TRUE;
			$response['value'] = to_currency($giftcard_info->value);
		} else {
			$response['exists'] = FALSE;
		}

		echo json_encode($response);
	}


	function new_integrated_giftcard()
	{
		if (!$this->Employee->has_module_action_permission('giftcards', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {
			redirect('no_access/' . $this->module_id);
		}

		$data = array();
		$this->load->view("sales/integrated_giftcard_form", $data);
	}

	function new_giftcard()
	{
		if (!$this->Employee->has_module_action_permission('giftcards', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {
			redirect('no_access/' . $this->module_id);
		}

		$data = array();
		$data['item_id'] = $this->Item->get_item_id(lang('giftcard'));
		$this->load->view("sales/giftcard_form", $data);
	}

	function set_search_suspended_sale_types()
	{
		$this->session->set_userdata('search_suspended_sale_types', $this->input->post('suspended_types'));
	}

	function suspended($type = '', $offset = 0)
	{
		$data = array();
		$params = $this->session->userdata('search_suspended_sale_types') ? $this->session->userdata('search_suspended_sale_types') : array('offset' => 0, 'order_col' => 'sale_id', 'order_dir' => 'desc', 'search' => FALSE,  'fields' => 'all', 'deleted' => 0);

		if ($offset != $params['offset']) {
			redirect('sales/suspended/'.$type.'/' . $params['offset']);
		}
		
		$data['controller_name'] = strtolower(get_class());

		$config['base_url'] = site_url('sales/sorting');
		$config['per_page'] = 10;
		$data['per_page'] = $config['per_page'];
		if ($type == '') {
			
			$config['total_rows'] = $this->Sale->count_suspended($this->session->userdata('search_suspended_sale_types'));
		} else {
			$config['total_rows'] = $this->Sale->count_suspended($this->session->userdata('search_suspended_sale_types'));
		}
		
		
	

		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
	
		$data['fields'] = $params['fields'] ? $params['fields'] : "all";
		$data['order_col'] = $params['order_col'];
		$data['order_dir'] = $params['order_dir'];
		$data['deleted'] = $params['deleted'];
		$data['total_rows'] = $config['total_rows'];
		$data['type'] = $type;
		$table_data = $this->Sale->get_all_suspended_data_table($params['deleted'], $data['per_page'], $params['offset'], $params['order_col'], $params['order_dir'] , $data['type'] );
	

		



		$data['manage_table'] = get_suspended_sales_manage_table_list($table_data, $this);
		$data['suspended_sale_types'] = [];
		if ($this->Sale_types->get_all(!$this->config->item('ecommerce_platform') ? $this->config->item('ecommerce_suspended_sale_type_id') : NULL)) {
			$data['suspended_sale_types'] = $this->Sale_types->get_all(!$this->config->item('ecommerce_platform') ? $this->config->item('ecommerce_suspended_sale_type_id') : NULL)->result_array();
		}

		$data['default_columns'] = $this->Sale->get_suspended_sales_default_columns();
		$data['selected_columns'] = $this->Employee->get_suspended_sales_columns_to_display();
		$data['page_title'] = lang('sales_list_of_suspended_sales');
		$data['all_columns'] = array_merge($data['selected_columns'], $this->Sale->get_suspended_sales_displayable_columns());
		$this->load->view('sales/suspended', $data);
	}
	function sorting()
	{
		$this->check_action_permission('search');
		$params = $this->session->userdata('search_suspended_sale_types') ? $this->session->userdata('search_suspended_sale_types') : array('order_col' => 'sale_types.name', 'order_dir' => 'asc', 'deleted' => 0);
		$search = $this->input->post('search') ? $this->input->post('search') : "";
		
		$fields = $this->input->post('fields') ? $this->input->post('fields') : 'all';

		$per_page = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 5;
		$offset = $this->input->post('offset') ? $this->input->post('offset') : 0;
		$order_col = $this->input->post('order_col') ? $this->input->post('order_col') : $params['order_col'];
		$order_dir = $this->input->post('order_dir') ? $this->input->post('order_dir') : $params['order_dir'];
		$deleted = $this->input->post('deleted') ? $this->input->post('deleted') : $params['deleted'];
	

		$items_search_data = array('offset' => $offset, 'order_col' => $order_col, 'order_dir' => $order_dir, 'search' => $search,  'fields' => $fields, 'deleted' => $deleted);

		$this->session->set_userdata("search_suspended_sale_types", $items_search_data);
	


		$config['total_rows'] = $this->Sale->count_suspended($this->session->userdata('search_suspended_sale_types'));

		if($search){
			$table_data = $this->Sale->get_all_suspended_data_table_search($search, $deleted,  $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $order_col, $order_dir, $fields);
		}else{
			$table_data = $this->Sale->get_all_suspended_data_table( $deleted,  $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $order_col, $order_dir, $fields);
		}
	

		$config['base_url'] = site_url('sales/sorting');
		$config['per_page'] = $per_page;
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$this->load->model('Employee_appconfig');
		$data['default_columns'] = $this->Sale->get_suspended_sales_default_columns();
		$data['manage_table'] = get_suspended_sales_manage_table_list($table_data, $this);

		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination'], 'total_rows' => $config['total_rows']));
	}

	function reload_table_sus()
	{

		$data['total_rows'] =  $this->Sale->count_suspended($this->session->userdata('search_suspended_sale_types'));
		$params = $this->session->userdata('search_suspended_sale_types') ? $this->session->userdata('search_suspended_sale_types') : array('offset' => 0, 'order_col' => 'sale_id', 'order_dir' => 'desc', 'search' => FALSE, 'category_id' => FALSE, 'fields' => 'all', 'deleted' => 0);
		$data['fields'] = $params['fields'] ? $params['fields'] : "all";
		$data['order_col'] = $params['order_col'];
		$data['order_dir'] = $params['order_dir'];
		$data['deleted'] = $params['deleted'];
		$data['type'] = '';
		$data['controller_name'] = strtolower(get_class());
		$data['per_page'] =10;
		$table_data = $this->Sale->get_all_suspended_data_table($params['deleted'], $data['per_page'], $params['offset'], $params['order_col'], $params['order_dir'] , $data['type'] );
	

		echo get_suspended_sales_manage_table_list($table_data, $this);
	}


	public function suspended_quick($type = '')
	{

		
		$type = '';
		$offset = 0;
				$data = array();
		$params = $this->session->userdata('search_suspended_sale_types') ? $this->session->userdata('search_suspended_sale_types') : array('offset' => 0, 'order_col' => 'sale_id', 'order_dir' => 'desc', 'search' => FALSE,  'fields' => 'all', 'deleted' => 0);

		if ($offset != $params['offset']) {
			redirect('sales/suspended/'.$type.'/' . $params['offset']);
		}
		
		$data['controller_name'] = strtolower(get_class());

		$config['base_url'] = site_url('sales/sorting');
		$config['per_page'] = 10;
		$data['per_page'] = $config['per_page'];
		if ($type == '') {
			
			$config['total_rows'] = $this->Sale->count_suspended($this->session->userdata('search_suspended_sale_types'));
		} else {
			$config['total_rows'] = $this->Sale->count_suspended($this->session->userdata('search_suspended_sale_types'));
		}
		
		
	

		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
	
		$data['fields'] = $params['fields'] ? $params['fields'] : "all";
		$data['order_col'] = $params['order_col'];
		$data['order_dir'] = $params['order_dir'];
		$data['deleted'] = $params['deleted'];
		$data['total_rows'] = $config['total_rows'];
		$data['type'] = $type;
		$table_data = $this->Sale->get_all_suspended_data_table($params['deleted'], $data['per_page'], $params['offset'], $params['order_col'], $params['order_dir'] , $data['type'] );
	

		



		$data['manage_table'] = get_suspended_sales_manage_table_list($table_data, $this);
		$data['suspended_sale_types'] = [];
		if ($this->Sale_types->get_all(!$this->config->item('ecommerce_platform') ? $this->config->item('ecommerce_suspended_sale_type_id') : NULL)) {
			$data['suspended_sale_types'] = $this->Sale_types->get_all(!$this->config->item('ecommerce_platform') ? $this->config->item('ecommerce_suspended_sale_type_id') : NULL)->result_array();
		}

		$data['default_columns'] = $this->Sale->get_suspended_sales_default_columns();
		$data['selected_columns'] = $this->Employee->get_suspended_sales_columns_to_display();
		$data['page_title'] = lang('sales_list_of_suspended_sales');
		$data['all_columns'] = array_merge($data['selected_columns'], $this->Sale->get_suspended_sales_displayable_columns());


		$this->load->view('sales/suspended_quick', $data);
	}

	function work_orders()
	{
		$data = array();
		$data['controller_name'] = strtolower(get_class());
		$table_data = $this->Sale->get_all_suspended($this->session->userdata('search_suspended_sale_types'), null, null, true);
		$data['manage_table'] = get_suspended_sales_manage_table($table_data, $this);
		$data['suspended_sale_types'] = [];
		if ($this->Sale_types->get_all(!$this->config->item('ecommerce_platform') ? $this->config->item('ecommerce_suspended_sale_type_id') : NULL)) {
			$data['suspended_sale_types'] = $this->Sale_types->get_all(!$this->config->item('ecommerce_platform') ? $this->config->item('ecommerce_suspended_sale_type_id') : NULL)->result_array();
		}


		$data['default_columns'] = $this->Sale->get_suspended_sales_default_columns();
		$data['selected_columns'] = $this->Employee->get_suspended_sales_columns_to_display();
		$data['page_title'] = lang('sales_list_of_work_order_sales');
		$data['all_columns'] = array_merge($data['selected_columns'], $this->Sale->get_suspended_sales_displayable_columns());
		$this->load->view('sales/suspended', $data);
	}



	function save_column_prefs()
	{
		$this->load->model('Employee_appconfig');

		if ($this->input->post('columns')) {
			$this->Employee_appconfig->save('suspended_sales_column_prefs', serialize($this->input->post('columns')));
		} else {
			$this->Employee_appconfig->delete('suspended_sales_column_prefs');
		}
	}
	function save_list_column_prefs()
	{
		$this->load->model('Employee_appconfig');

		if ($this->input->post('columns')) {
			$this->Employee_appconfig->save('list_sales_column_prefs', serialize($this->input->post('columns')));
		} else {
			$this->Employee_appconfig->delete('list_sales_column_prefs');
		}
	}
	function reload_table()
	{
		$data['controller_name'] = strtolower(get_class());
		$table_data = $this->Sale->get_all_suspended($this->session->userdata('search_suspended_sale_types'));
		echo get_suspended_sales_manage_table($table_data, $this);
	}

	function change_sale($sale_id)
	{

		$this->check_action_permission('edit_sale');
		$this->Sale->set_default_register_if_not_set($sale_id);

		$this->cart->destroy();
		$this->cart = PHPPOSCartSale::get_instance_from_sale_id($sale_id, 'sale', TRUE);

		if ($this->Location->get_info_for_key('enable_credit_card_processing')) {
			$this->cart->change_credit_card_payments_to_partial();
		}

		$this->cart->save();


		$this->_reload(array(), false);
	}

	function clone_sale($sale_id)
	{
		if ($this->config->item('disable_sale_cloning')) {
			$this->_reload(array(), false);
			return;
		}

		$this->cart->destroy();
		$this->cart = PHPPOSCartSale::get_instance_from_sale_id($sale_id, 'sale', TRUE);
		$this->cart->sale_id = NULL;
		$this->cart->payments = array();
		$this->cart->suspended = 0;
		$this->cart->save();

		$track_payment_types = $this->config->item('track_payment_types') ? unserialize($this->config->item('track_payment_types')) : array();
		if ($this->config->item('track_payment_types') && !empty($track_payment_types)) {
			if (!$this->Register->is_register_log_open()) {
				redirect(site_url('sales'));
			}
		}

		$this->_reload(array(), false);
	}


	function unsuspend($sale_id = 0)
	{
		$this->check_action_permission('edit_suspended_sale');
		$this->Sale->set_default_register_if_not_set($sale_id);

		$sale_id = $this->input->post('suspended_sale_id') ? $this->input->post('suspended_sale_id') : $sale_id;

		if ($sale_id) {
			$sale_data = get_query_data(" select * from phppos_sales where sale_id =" . $sale_id . " ");
			if ($sale_data) {
				if (!$sale_data[0]->suspended) {
					$this->cart->destroy();
					redirect(site_url('sales'));
				}
				// if($sale_data->suspened)
			}
		} else {
			$this->cart->destroy();
			redirect(site_url('sales'));
		}


		$this->cart->destroy();
		$this->cart = PHPPOSCartSale::get_instance_from_sale_id($sale_id, 'sale', TRUE);
		// dd($this->cart);

		if ($this->config->item('automatically_email_receipt')) {
			$this->cart->email_receipt = 1;
		}

		if ($this->config->item('automatically_sms_receipt_that_works_like_automatically_email_receipt')) {
			$this->cart->sms_receipt = 1;
		}

		if ($this->config->item('create_invoices_for_customer_store_account_charges')) {
			$this->cart->create_invoice = 1;
		}

		// Verify if the sale is a work order and if so, set the flag to create a work order 
		$isWorkOrder = $this->work_order->get_info_by_sale_id($sale_id)->row();
		if (isset($isWorkOrder->sale_id)) {

			$this->cart->is_work_order = 1;
		}

		$this->cart->save();
		$this->Sale->delete_open_suspended_sales();
		$this->Sale->save_open_suspended_sale($sale_id);

		$this->_reload(array(), false);
	}

	function is_open_suspended_sale()
	{
		$sale_id = $this->input->get('sale_id');
		if ($this->Sale->is_open_suspended_sale($sale_id)) {
			$opened_sale_info = $this->Sale->get_opened_sale_info($sale_id);
			echo json_encode(array('success' => false, 'message' => sprintf($this->lang->line('sales_already_open_error'), $opened_sale_info->register_name, $opened_sale_info->employee_name)));
		} else {
			echo json_encode(array('success' => true));
		}
	}

	function delete_suspended_sale()
	{
		$this->check_action_permission('delete_suspended_sale');
		$suspended_sale_id = $this->input->post('suspended_sale_id');
		if ($suspended_sale_id) {
			$this->cart->is_editing_previous = FALSE;
			$this->cart->sale_id = NULL;

			if (is_array($suspended_sale_id)) {

				foreach ($suspended_sale_id as $sale_id) {
					if (!$this->Sale->is_sale_deleted($sale_id)) {
						$this->Sale->delete($sale_id);
					}
				}
			} else {
				if (!$this->Sale->is_sale_deleted($suspended_sale_id)) {
					$this->Sale->delete($suspended_sale_id);
				}
			}
		}
		if ($this->input->post('redirection')) {
			redirect($this->input->post('redirection'));
			return false;
		}
		redirect('sales/suspended');
	}


	function discount_all_update()
	{
		$discount_all_percent = (float)$this->input->post('discount_all_percent');

		if (isset($_POST['discount_all_percent']) && $_POST['discount_all_percent'] != '' &&  $_POST['discount_all_percent'] > 0) {
			$discount_all_percent = $_POST['discount_all_percent'];
			$result = $this->cart->discount_all($discount_all_percent);
			if (!$result) {
				$data['error'] = lang('sales_could_not_discount_item_above_max') . ' ' . lang('sales_the_items_in_the_cart');
				$this->sales_reload($data);
				return;
			}

			foreach ($this->cart->get_items() as $item) {
				if ($item->below_cost_price()) {
					if ($this->config->item('do_not_allow_below_cost')) {
						$this->cart->discount_all(0);
						$data['error'] = lang('sales_selling_item_below_cost');
						break;
					} else {
						$data['warning'] = lang('sales_selling_item_below_cost');
					}
				}
			}
		}


		if (isset($_POST['discount_all_flat'])  && $_POST['discount_all_flat'] != '' &&  $_POST['discount_all_flat'] > 0) {
			$value = $_POST['discount_all_flat'];
			$item_id = $this->Item->create_or_update_flat_discount_item($this->cart->is_tax_inclusive() ? 1 : 0);
			$description =  strpos($value, '%', 0) ? lang('sales_discount_percent') . ': ' . $value : '';
			$discount_amount = strpos($value, '%', 0) !== FALSE ? (($this->cart->get_subtotal() + $this->cart->get_discount_all_fixed()) * (float)$value / 100) : (float)$value;
			$discount_item = new PHPPOSCartItemSale(array('cart' => $this->cart, 'scan' => $item_id . '|FORCE_ITEM_ID|', 'cost_price' => 0, 'unit_price' => to_currency_no_money($discount_amount), 'description' => $description, 'quantity' => -1));

			if ($discount_item_in_cart = $this->cart->find_similiar_item($discount_item)) {
				$this->cart->delete_item($this->cart->get_item_index($discount_item_in_cart));
			}
			$this->cart->add_item($discount_item);
		}
		if (isset($_POST['discount_reason'])) {
			$this->cart->discount_reason = $_POST['discount_reason'];
		}
		$this->cart->save();
		$this->sales_reload();
	}
	function discount_all()
	{
		$discount_all_percent = (float)$this->input->post('discount_all_percent');

		if ($this->input->post('name') == "discount_all_percent") {
			$discount_all_percent = (float)$this->input->post('value');
			$result = $this->cart->discount_all($discount_all_percent);
			if (!$result) {
				$data['error'] = lang('sales_could_not_discount_item_above_max') . ' ' . lang('sales_the_items_in_the_cart');
				$this->sales_reload($data);
				return;
			}

			foreach ($this->cart->get_items() as $item) {
				if ($item->below_cost_price()) {
					if ($this->config->item('do_not_allow_below_cost')) {
						$this->cart->discount_all(0);
						$data['error'] = lang('sales_selling_item_below_cost');
						break;
					} else {
						$data['warning'] = lang('sales_selling_item_below_cost');
					}
				}
			}
		} elseif ($this->input->post('name') == 'discount_all_flat') {
			$item_id = $this->Item->create_or_update_flat_discount_item($this->cart->is_tax_inclusive() ? 1 : 0);
			$description =  strpos($this->input->post('value'), '%', 0) ? lang('sales_discount_percent') . ': ' . $this->input->post('value') : '';
			$discount_amount = strpos($this->input->post('value'), '%', 0) !== FALSE ? (($this->cart->get_subtotal() + $this->cart->get_discount_all_fixed()) * (float)$this->input->post('value') / 100) : (float)$this->input->post('value');
			$discount_item = new PHPPOSCartItemSale(array('cart' => $this->cart, 'scan' => $item_id . '|FORCE_ITEM_ID|', 'cost_price' => 0, 'unit_price' => to_currency_no_money($discount_amount), 'description' => $description, 'quantity' => -1));

			if ($discount_item_in_cart = $this->cart->find_similiar_item($discount_item)) {
				$this->cart->delete_item($this->cart->get_item_index($discount_item_in_cart));
			}
			$this->cart->add_item($discount_item);
		}

		$this->cart->save();
		$this->sales_reload();
	}

	function discount_reason()
	{
		$discount_reason = $this->input->post('value');
		$this->cart->discount_reason = $discount_reason;
		$this->cart->save();
		$this->sales_reload();
	}


	public function get_quick_item_data($item_id)
	{
		$item_info = $this->item->get_info($item_id);
		$item = $item_info;
		$img_src = "";
		$can_override_price_adjustments = $this->Employee->get_logged_in_employee_info()->override_price_adjustments;
		$max_discount_employee = $this->Employee->get_logged_in_employee_info()->max_discount_percent;
		$max_discount_config = $this->config->item('max_discount_percent') !== '' ? $this->config->item('max_discount_percent') : NULL;


		if ($item->image_id != 'no_image' && $item->image_id && trim($item->image_id) != '') {
			$img_src = cacheable_app_file_url($item->image_id);
		}

		$size = $item->size ? ' - ' . $item->size : '';

		if (strpos($item->item_id, 'KIT') === 0) {
			$price_to_use = $this->Item_kit->get_sale_price(array('item_kit_id' => str_replace('KIT', '', $item->item_id)));
		} else {
			$price_to_use = $this->Item->get_sale_price(array('item_id' => $item->item_id));
		}
		$item_taxes = $this->Item_taxes->get_info($item->item_id);
		$tax  = [];
		if (!empty($item_taxes)) {
			$tax = $item_taxes[0]['percent'];
		}

		$allow_price_override_regardless_of_permissions =  $item_info->allow_price_override_regardless_of_permissions ? 1 : 0;

		$max_discount = $item_info->max_discount_percent;
		//Try employee
		if (!$can_override_price_adjustments && $max_discount === NULL) {
			$max_discount = $max_discount_employee;
		}

		//Try globally
		if (!$can_override_price_adjustments && $max_discount === NULL) {
			$max_discount = $max_discount_config;
		}

		$variatons = 	$this->item_variations($item->item_id, true);

		$this->load->model('Item_attribute');
		$item_attributes_available = $this->Item_attribute->get_attributes_for_item_with_attribute_values_updated($item->item_id);

		$mods_for_item = $this->Item_modifier->get_modifiers_for_item_id($item->item_id)->result_array();

		if ($mods_for_item) {
			foreach ($mods_for_item as $modifier_item_id => $modifier_item) {

				// dd($modifier_item);
				$Item_modifier  = $this->Item_modifier->get_modifier_item_info($modifier_item['id']);
				// dd($Item_modifier);
				$mods_for_item[$modifier_item_id]['modifier_item_id'] = $modifier_item['id'];
				$mods_for_item[$modifier_item_id]['unit_price'] =  $Item_modifier['unit_price'];
				$mods_for_item[$modifier_item_id]['cost_price'] =  $Item_modifier['cost_price'];
				$mods_for_item[$modifier_item_id]['unit_price_currency'] =  to_currency($Item_modifier['unit_price']);
				$mods_for_item[$modifier_item_id]['modifier_item_name'] =   $Item_modifier['modifier_item_name'];
			}
		}
		$item_id = $item->item_id;


		$quantity_units = $this->Item->get_quantity_units($item_id, true);
		$quantity_units_res = array();
		$quantity_units_info = array();
		if (!empty($quantity_units)) {
			$quantity_units_res[0]['value'] = "0";
			$quantity_units_res[0]['text'] = lang('None');
			foreach ($quantity_units as $key => $value) {
				$quantity_units_res[$value['id']]['value'] = $value['id'];
				$quantity_units_res[$value['id']]['text'] = $value['unit_name'];
				$quantity_units_info[$value['id']] = (array) $this->Item->get_quantity_unit_info($value['id']);
			}
			// dd($quantity_units);
		}
		/// getting items and categories




		$permissions = array(
			'allow_price_override_regardless_of_permissions' => $allow_price_override_regardless_of_permissions,
			'always_use_average_cost_method' => $this->config->item('always_use_average_cost_method'),
			'hide_supplier_on_sales_interface' => $this->config->item('hide_supplier_on_sales_interface'),
			'disable_supplier_selection_on_sales_interface' => $this->config->item('disable_supplier_selection_on_sales_interface'),
			'hide_description_on_sales_and_recv' => $this->config->item('hide_description_on_sales_and_recv'),
			'allow_alt_description' => $item_info->allow_alt_description,
			'change_cost_price' =>  $item_info->change_cost_price,
			'edit_serail_no' =>  	$this->Employee->has_module_action_permission('sales', 'edit_serail_no', $this->Employee->get_logged_in_employee_info()->person_id),
			'require_to_add_serial_number_in_pos' => $this->config->item('require_to_add_serial_number_in_pos'),
			'id_to_show_on_sale_interface' =>	$this->config->item('id_to_show_on_sale_interface'),
			'do_not_allow_out_of_stock_items_to_be_sold' =>	$this->config->item('do_not_allow_out_of_stock_items_to_be_sold'),
			'process_returns' => (!$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)),
			'process_returns_error' => lang('sales_not_allowed_returns'),
			'sales_could_not_discount_item_above_max' => lang('sales_could_not_discount_item_above_max'),
			'do_not_allow_below_cost' => $this->config->item('do_not_allow_below_cost'),

		);
		// dd( $quantity_units);
		$source_supplier_data = array();

		$secondary_supplier_details = array();
		foreach ($this->Item->get_all_suppliers_of_an_item($item->item_id)->result_array() as $row) {
			$source_supplier_data[$row['supplier_id']] = array('value' => $row['supplier_id'], 'text' => $row['company_name'] . ' (' . $row['full_name'] . ')');
			$secondary_supplier = $this->Item->get_secondary_supplier_details($item->item_id, $row['supplier_id']);
			if ($secondary_supplier) {
				$secondary_supplier_details[$row['supplier_id']] = (array) $secondary_supplier;
			}
		}
		// $params['item'] = $item;
		// $params['quantity'] = 1;
		$CI = &get_instance();

		$rule = $CI->Price_rule->get_all_rule_for_item($item->item_id);
		// dd($rule);
		$serial_numbers = [];
		$employee_location_id = $this->Employee->get_logged_in_employee_current_location_id();
		if ($item_info->is_serialized) {
			$serial_numbers = $this->Item_serial_number->get_all_data($item_info->item_id, $employee_location_id, $input = array());
		}



		$id_to_show_on_sale_interface_val = '';
		switch ($this->config->item('id_to_show_on_sale_interface')) {
			case 'number':

				if (property_exists($item, 'item_number') && $item->item_number) {
					$id_to_show_on_sale_interface_val =  H($item->item_number);
				} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
					$id_to_show_on_sale_interface_val =  H($item->item_kit_number);
				} else {
					$id_to_show_on_sale_interface_val =  lang('none');
				}

				break;

			case 'product_id':
				$id_to_show_on_sale_interface_val =  property_exists($item, 'product_id') ? H($item->product_id) : lang('none');
				break;

			case 'id':
				$id_to_show_on_sale_interface_val =  property_exists($item, 'item_id') ? H($item->item_id) : 'KIT ' . H($item->item_kit_id);
				break;

			default:
				if (property_exists($item, 'item_number') && $item->item_number) {
					$id_to_show_on_sale_interface_val =  H($item->item_number);
				} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
					$id_to_show_on_sale_interface_val =  H($item->item_kit_number);
				} else {
					$id_to_show_on_sale_interface_val =  lang('none');
				}
				break;
		}

		$cur_quantity = 0;
		$item_variation_location_info = [];
		$item_location_info = [];
		if (isset($item_info->variation_id)) {
			$item_variation_location_info = $this->Item_variation_location->get_info($item_info->variation_id, $employee_location_id, true, 0);

			$cur_quantity = (int) $item_variation_location_info->quantity;
		} else {
			$item_location_info = $this->Item_location->get_info($item_info->item_id, $employee_location_id, false, 0);

			$cur_quantity = (int)$item_location_info->quantity;
		}
		$item_location_quantity = (int) $this->Item_location->get_location_quantity($item_info->item_id);

		$item_location_info  = (array) $item_location_info;
		$item_tier_row = [];
		$item_location_tier_row = [];
		$all_tier_info = [];
		foreach ($this->Tier->get_all()->result() as $key  => $tier) {
			$all_tier_info[$tier->id] = (array) $tier;
			$item_tier_row[$tier->id] = (array) $this->Item->get_tier_price_row($tier->id, $item_info->item_id);
			$item_location_tier_row[$tier->id] = (array)  $this->Item_location->get_tier_price_row($tier->id, $item_info->item_id, $employee_location_id);
		}

		if (count($variatons) > 0) {
			foreach ($variatons as $key => $var) {
				$variatons[$key]['item_variation_location_info'] = (array) $this->Item_variation_location->get_info(explode('#', $var['id'])[1], $employee_location_id, true, 0);
			}
		}





		$item = array(
			'permissions' => $permissions,
			'source_supplier_data' => $source_supplier_data,
			'secondary_supplier_details' => $secondary_supplier_details,
			'can_override_price_adjustments' => $can_override_price_adjustments,
			'id' => $item->item_id,
			'rules' => $rule,
			'item_location_info' => $item_location_info,
			'item_tier_row' => $item_tier_row,
			'item_location_tier_row' => $item_location_tier_row,
			'all_tier_info' => $all_tier_info,
			'max_discount' => $max_discount,
			'name' => character_limiter($item->name, 30) . $size,
			'item_taxes' => $item_taxes,
			"is_serialized" => $item_info->is_serialized,
			"serial_numbers" => $serial_numbers,
			'tax_percent' => $tax,
			'is_recurring' => $item_info->is_recurring,
			'tax_included' => $item->tax_included,
			'override_default_tax' => $item->override_default_tax,
			'image_src' => 	$img_src,
			'category_name' => 	$this->Category->get_full_path($item_info->category_id),
			'category_id' => 	$item_info->category_id,
			'description' => 	clean_html($item_info->description),
			'has_variations' => count($variatons) > 0 ? $variatons : FALSE,
			'item_attributes_available' => $item_attributes_available,
			'type' => 'item',
			'quantity_units' => $quantity_units_res,
			'quantity_units_info' => $quantity_units_info,
			'modifiers'	=> $mods_for_item,
			"cost_price" => $item_info->cost_price,
			'price' => $price_to_use != '0.00' ? to_currency($price_to_use) : FALSE,
			'regular_price' => $item->unit_price,
			'different_price' => $price_to_use != $item->unit_price,
			'id_to_show_on_sale_interface_val' => $id_to_show_on_sale_interface_val,
			'cur_quantity' => to_quantity($cur_quantity),
			'is_series_package' => $item_info->is_series_package,
			'series_quantity' => $item_info->series_quantity,
			'series_days_to_use_within' => $item_info->series_days_to_use_within,
			'item_location_quantity' => $item_location_quantity,
			'is_service' => $item_info->is_service,
			'max_edit_price' => $item_info->max_edit_price,
			'min_edit_price' => $item_info->min_edit_price,

		);
		$data['item'] = H($item);
		echo json_encode($data);
	}



	function categories_and_items($category_id = NULL, $offset = 0)
	{
		$this->load->model('Item_variations');

		//allow parallel searchs to improve performance.
		session_write_close();

		//If a false value, make sure it is NULL
		if (!$category_id) {
			$category_id = NULL;
		}
		$number = $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40;

		$config['base_url'] = site_url('sales/categories_and_items/' . ($category_id ? $category_id : 0));
		$config['uri_segment'] = 4;
		$config['per_page'] = $number;
		$categories_and_items_response = array();
		if ($category_id != 'top' && $category_id != 'my_sareeh') {
			$categories = $this->Category->get_all($category_id);
			$categories_count = count($categories);


			$this->load->model('Appfile');
			foreach ($categories as $id => $value) {
				$sub_categories = count($this->Category->get_all($id));
				$items_count = $this->Item->count_all_by_category($id);
				$categories_and_items_response[] = array('id' => $id, 'name' => $value['name'], 'color' => $value['color'], 'image_id' => $value['image_id'], 'image_timestamp' => $this->Appfile->get_file_timestamp($value['image_id']), 'type' => 'category', 'categories_count' => $sub_categories, 'items_count' => $items_count);
			}
		} else {
			$categories_count = 0;
		}
		//Categories

		//Items
		$items = array();

		$items_offset = ($offset - $categories_count > 0 ? $offset - $categories_count : 0);
		if ($category_id == 'my_sareeh') {
		} else {


			$items_result = $this->Item->get_all_by_category($category_id, $this->config->item('hide_out_of_stock_grid') ? TRUE : FALSE, $items_offset, $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40)->result();
		}
		$tax = 0;
		$store_config_tax_class = $this->config->item('tax_class_id');


		if ($store_config_tax_class) {
			$return_tax =  $this->Tax_class->get_taxes($store_config_tax_class);
			if (!empty($return_tax)) {
				$tax = $return_tax[0]['percent'];
			}
		}


		$can_override_price_adjustments = $this->Employee->get_logged_in_employee_info()->override_price_adjustments;
		$max_discount_employee = $this->Employee->get_logged_in_employee_info()->max_discount_percent;
		$max_discount_config = $this->config->item('max_discount_percent') !== '' ? $this->config->item('max_discount_percent') : NULL;

		if ($category_id == 'top') {
			$categories_and_items_response[] = array(
				'can_override_price_adjustments' => $can_override_price_adjustments,
				'id' => 'add_item',
				'max_discount' => 0,
				'name' => lang('add_new_item'),
				'tax_percent' => 0,
				'tax_included' => 0,
				'override_default_tax' => 0,
				'image_src' => 	'',
				'has_variations' => 0,
				'type' => 'item',
				'price' => 0,
				'regular_price' => 0,
				'different_price' => 0,

			);
		}
		if ($category_id == 'my_sareeh') {


			if ($this->Employee->has_module_action_permission('giftcards', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {

				$categories_and_items_response[] = array(
					'can_override_price_adjustments' => $can_override_price_adjustments,
					'id' => 'Gift_card',
					'max_discount' => 0,
					'name' => lang('Gift_card'),
					'tax_percent' => 0,
					'tax_included' => 0,
					'override_default_tax' => 0,
					'image_src' => 	'',
					'has_variations' => 0,
					'type' => 'item',
					'price' => 0,
					'regular_price' => 0,
					'different_price' => 0,

				);
			}

			if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced' &&  count(explode(":", $this->config->item('spend_to_point_ratio'), 2)) == 2) {
				$purchase_points_item_id = $this->Item->create_or_update_purchase_points_item();
				$unit_price = $this->config->item('point_value');
				$price_to_use = $this->config->item('point_value');
				$categories_and_items_response[] = array(
					'can_override_price_adjustments' => $can_override_price_adjustments,
					'id' => $purchase_points_item_id,
					'max_discount' => 0,
					'name' => lang('Purchase_point'),
					'tax_percent' => 0,
					'tax_included' => 0,
					'override_default_tax' => 0,
					'image_src' => 	'',
					'has_variations' => 0,
					'type' => 'item',
					'price' => $price_to_use != '0.00' ? to_currency($price_to_use) : FALSE,
					'regular_price' => to_currency($unit_price),
					'different_price' => $price_to_use != $unit_price,

				);
			}
		}
		if (isset($items_result)) {


			foreach ($items_result as $line => $item) {

				$img_src = "";
				if ($item->image_id != 'no_image' && $item->image_id && trim($item->image_id) != '') {
					$img_src = cacheable_app_file_url($item->image_id);
				}

				$size = $item->size ? ' - ' . $item->size : '';

				if (strpos($item->item_id, 'KIT') === 0) {
					$price_to_use = $this->Item_kit->get_sale_price(array('item_kit_id' => str_replace('KIT', '', $item->item_id)));
				} else {
					$price_to_use = $this->Item->get_sale_price(array('item_id' => $item->item_id));
				}
				$item_taxes = $this->Item_taxes->get_info($item->item_id);

				if (!empty($item_taxes)) {
					$tax = $item_taxes[0]['percent'];
				}
				$item_info = $this->item->get_info($item->item_id);
				$allow_price_override_regardless_of_permissions =  $item_info->allow_price_override_regardless_of_permissions ? 1 : 0;

				$max_discount = $item_info->max_discount_percent;
				//Try employee
				if (!$can_override_price_adjustments && $max_discount === NULL) {
					$max_discount = $max_discount_employee;
				}

				//Try globally
				if (!$can_override_price_adjustments && $max_discount === NULL) {
					$max_discount = $max_discount_config;
				}

				$variatons = 	$this->item_variations($item->item_id, true);

				$this->load->model('Item_attribute');
				$item_attributes_available = $this->Item_attribute->get_attributes_for_item_with_attribute_values_updated($item->item_id);
				//  dd($item_attributes_available);
				// $variation_ids_to_lookup = [];

				// foreach($variatons as $var)
				// {
				// 	$variation_ids_to_lookup[] =  explode('#' , $var['id'])[1] ;
				// }



				// $item_attributes_available = $this->Item_variations->get_attributes($variation_ids_to_lookup);

				$mods_for_item = $this->Item_modifier->get_modifiers_for_item_id($item->item_id)->result_array();

				if ($mods_for_item) {
					foreach ($mods_for_item as $modifier_item_id => $modifier_item) {

						// dd($modifier_item);
						$Item_modifier  = $this->Item_modifier->get_modifier_item_info($modifier_item['id']);
						// dd($Item_modifier);
						$mods_for_item[$modifier_item_id]['modifier_item_id'] = $modifier_item['id'];
						$mods_for_item[$modifier_item_id]['unit_price'] =  $Item_modifier['unit_price'];
						$mods_for_item[$modifier_item_id]['cost_price'] =  $Item_modifier['cost_price'];
						$mods_for_item[$modifier_item_id]['unit_price_currency'] =  to_currency($Item_modifier['unit_price']);
						$mods_for_item[$modifier_item_id]['modifier_item_name'] =   $Item_modifier['modifier_item_name'];
					}
				}
				$item_id = $item->item_id;


				$quantity_units = $this->Item->get_quantity_units($item_id, true);
				$quantity_units_res = array();
				$quantity_units_info = array();
				if (!empty($quantity_units)) {
					$quantity_units_res[0]['value'] = "0";
					$quantity_units_res[0]['text'] = lang('None');
					foreach ($quantity_units as $key => $value) {
						$quantity_units_res[$value['id']]['value'] = $value['id'];
						$quantity_units_res[$value['id']]['text'] = $value['unit_name'];
						$quantity_units_info[$value['id']] = (array) $this->Item->get_quantity_unit_info($value['id']);
					}
					// dd($quantity_units);
				}
				/// getting items and categories




				$permissions = array(
					'allow_price_override_regardless_of_permissions' => $allow_price_override_regardless_of_permissions,
					'always_use_average_cost_method' => $this->config->item('always_use_average_cost_method'),
					'hide_supplier_on_sales_interface' => $this->config->item('hide_supplier_on_sales_interface'),
					'disable_supplier_selection_on_sales_interface' => $this->config->item('disable_supplier_selection_on_sales_interface'),
					'hide_description_on_sales_and_recv' => $this->config->item('hide_description_on_sales_and_recv'),
					'allow_alt_description' => $item_info->allow_alt_description,
					'change_cost_price' =>  $item_info->change_cost_price,
					'edit_serail_no' =>  	$this->Employee->has_module_action_permission('sales', 'edit_serail_no', $this->Employee->get_logged_in_employee_info()->person_id),
					'require_to_add_serial_number_in_pos' => $this->config->item('require_to_add_serial_number_in_pos'),
					'id_to_show_on_sale_interface' =>	$this->config->item('id_to_show_on_sale_interface'),
					'do_not_allow_out_of_stock_items_to_be_sold' =>	$this->config->item('do_not_allow_out_of_stock_items_to_be_sold'),
					'process_returns' => (!$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)),
					'process_returns_error' => lang('sales_not_allowed_returns'),
					'sales_could_not_discount_item_above_max' => lang('sales_could_not_discount_item_above_max'),
					'do_not_allow_below_cost' => $this->config->item('do_not_allow_below_cost'),

				);
				// dd( $quantity_units);
				$source_supplier_data = array();

				$secondary_supplier_details = array();
				foreach ($this->Item->get_all_suppliers_of_an_item($item->item_id)->result_array() as $row) {
					$source_supplier_data[$row['supplier_id']] = array('value' => $row['supplier_id'], 'text' => $row['company_name'] . ' (' . $row['full_name'] . ')');
					$secondary_supplier = $this->Item->get_secondary_supplier_details($item->item_id, $row['supplier_id']);
					if ($secondary_supplier) {
						$secondary_supplier_details[$row['supplier_id']] = (array) $secondary_supplier;
					}
				}
				// $params['item'] = $item;
				// $params['quantity'] = 1;
				$CI = &get_instance();

				$rule = $CI->Price_rule->get_all_rule_for_item($item->item_id);
				// dd($rule);
				$serial_numbers = [];
				$employee_location_id = $this->Employee->get_logged_in_employee_current_location_id();
				if ($item_info->is_serialized) {
					$serial_numbers = $this->Item_serial_number->get_all_data($item_info->item_id, $employee_location_id, $input = array());
				}



				$id_to_show_on_sale_interface_val = '';
				switch ($this->config->item('id_to_show_on_sale_interface')) {
					case 'number':

						if (property_exists($item, 'item_number') && $item->item_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_number);
						} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_kit_number);
						} else {
							$id_to_show_on_sale_interface_val =  lang('none');
						}

						break;

					case 'product_id':
						$id_to_show_on_sale_interface_val =  property_exists($item, 'product_id') ? H($item->product_id) : lang('none');
						break;

					case 'id':
						$id_to_show_on_sale_interface_val =  property_exists($item, 'item_id') ? H($item->item_id) : 'KIT ' . H($item->item_kit_id);
						break;

					default:
						if (property_exists($item, 'item_number') && $item->item_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_number);
						} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_kit_number);
						} else {
							$id_to_show_on_sale_interface_val =  lang('none');
						}
						break;
				}

				$cur_quantity = 0;
				$item_variation_location_info = [];
				$item_location_info = [];


				if (isset($item_info->variation_id)) {
					$item_location_quantity = $CI->Item_variation_location->get_location_quantity($item_info->variation_id);

					$cur_quantity = (int) $item_location_quantity;
				} else {
					$item_location_info = $this->Item_location->get_info($item_info->item_id, $employee_location_id, false, 0);
					$item_location_quantity = (int) $this->Item_location->get_location_quantity($item_info->item_id);
					$cur_quantity = (int) $item_location_quantity;
				}


				$item_location_info  = (array) $item_location_info;
				$item_tier_row = [];
				$item_location_tier_row = [];
				$all_tier_info = [];
				foreach ($this->Tier->get_all()->result() as $key  => $tier) {
					$all_tier_info[$tier->id] = (array) $tier;
					$item_tier_row[$tier->id] = (array) $this->Item->get_tier_price_row($tier->id, $item_info->item_id);
					$item_location_tier_row[$tier->id] = (array)  $this->Item_location->get_tier_price_row($tier->id, $item_info->item_id, $employee_location_id);
				}

				if (count($variatons) > 0) {
					foreach ($variatons as $key => $var) {
						$variatons[$key]['item_variation_location_info'] = (array) $this->Item_variation_location->get_info(explode('#', $var['id'])[1], $employee_location_id, true, 0);
					}
				}





				$categories_and_items_response[] = array(
					'permissions' => $permissions,
					'source_supplier_data' => $source_supplier_data,
					'secondary_supplier_details' => $secondary_supplier_details,
					'can_override_price_adjustments' => $can_override_price_adjustments,
					'id' => $item->item_id,
					'rules' => $rule,
					'item_location_info' => $item_location_info,
					'item_tier_row' => $item_tier_row,
					'item_location_tier_row' => $item_location_tier_row,
					'all_tier_info' => $all_tier_info,
					'max_discount' => $max_discount,
					'name' => character_limiter($item->name, 30) . $size,
					'item_taxes' => $item_taxes,
					"is_serialized" => $item_info->is_serialized,
					"serial_numbers" => $serial_numbers,
					'tax_percent' => $tax,
					'is_recurring' => $item_info->is_recurring,
					'tax_included' => $item->tax_included,
					'override_default_tax' => $item->override_default_tax,
					'image_src' => 	$img_src,
					'category_name' => 	$this->Category->get_full_path($item_info->category_id),
					'category_id' => 	$item_info->category_id,
					'description' => 	clean_html($item_info->description),
					'has_variations' => count($variatons) > 0 ? $variatons : FALSE,
					'item_attributes_available' => $item_attributes_available,
					'type' => 'item',
					'quantity_units' => $quantity_units_res,
					'quantity_units_info' => $quantity_units_info,
					'modifiers'	=> $mods_for_item,
					"cost_price" => $item_info->cost_price,
					'price' => $price_to_use != '0.00' ? to_currency($price_to_use) : FALSE,
					'regular_price' => $item->unit_price,
					'different_price' => $price_to_use != $item->unit_price,
					'id_to_show_on_sale_interface_val' => $id_to_show_on_sale_interface_val,
					'cur_quantity' => to_quantity($cur_quantity),
					'is_series_package' => $item_info->is_series_package,
					'series_quantity' => $item_info->series_quantity,
					'series_days_to_use_within' => $item_info->series_days_to_use_within,
					'item_location_quantity' => $item_location_quantity,
					'is_service' => $item_info->is_service,
					'max_edit_price' => $item_info->max_edit_price,
					'min_edit_price' => $item_info->min_edit_price,

				);
			}
		}

		$items_count = $this->Item->count_all_by_category($category_id);
		$categories_and_items_response = array_slice($categories_and_items_response, $offset > $categories_count ? $categories_count : $offset, $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40);


		$data = array();
		$data['categories_and_items'] = H($categories_and_items_response);
		$config['total_rows'] =  $items_count;

		$config['first_link'] = '<<';
		$config['last_link']  = '>>';
		$config['full_tag_open'] = '<ul class="pagination " style="marigin : 10px 0px 0px 0px !important" >'; // or any class
		$config['full_tag_close'] = '</ul>';
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['categories_count'] = $categories_count;
		$data['items_count'] = $items_count;
		echo json_encode($data);
	}

	function item_variations($item_id, $is_return = false)
	{
		$variations = array();
		$this->load->model('Item_variations');
		save_query();

		$variation_result = $this->Item_variations->get_variations($item_id);

		$tax = 0;
		$store_config_tax_class = $this->config->item('tax_class_id');
		if ($store_config_tax_class) {
			$return_tax =  $this->Tax_class->get_taxes($store_config_tax_class);
			if (!empty($return_tax)) {
				$tax = $return_tax[0]['percent'];
			}
		}
		$can_override_price_adjustments = $this->Employee->get_logged_in_employee_info()->override_price_adjustments;
		$max_discount_employee = $this->Employee->get_logged_in_employee_info()->max_discount_percent;
		$max_discount_config = $this->config->item('max_discount_percent') !== '' ? $this->config->item('max_discount_percent') : NULL;
		// if($variation_result){
		// 	dd($variation_result);
		// }

		foreach ($variation_result as $variation_id => $variation) {

			$img_src = "";
			if (isset($variation['image']['image_id']) && $variation['image']['image_id']) {
				$img_src = cacheable_app_file_url($variation['image']['image_id']);
			}

			$cur_item_info = $this->Item->get_info($item_id);
			$cur_item_location_info = $this->Item_location->get_info($item_id);

			if ($variation['unit_price']) {
				$price_to_use = $variation['unit_price'];
			} else {
				$price_to_use = ($cur_item_location_info && $cur_item_location_info->unit_price) ? $cur_item_location_info->unit_price : $cur_item_info->unit_price;
			}

			$cur_item_variation_location_info = $this->Item_variation_location->get_info($variation_id);

			if (!($this->config->item('hide_out_of_stock_grid') && $cur_item_variation_location_info->quantity <= 0)) {

				$item_taxes = $this->Item_taxes->get_info($item_id);

				if (!empty($item_taxes)) {
					$tax = $item_taxes[0]['percent'];
				}

				$max_discount = $this->item->get_info($item_id)->max_discount_percent;

				//Try employee
				if (!$can_override_price_adjustments && $max_discount === NULL) {
					$max_discount = $max_discount_employee;
				}

				//Try globally
				if (!$can_override_price_adjustments && $max_discount === NULL) {
					$max_discount = $max_discount_config;
				}
				$attribute_string = "";
				if (isset($variation['attributes'])  &&  count($variation['attributes']) > 0) {
					foreach ($variation['attributes'] as $var) {
						$attribute_string .= $var['value'];
					}
				}

				$supplier = '';
				if (isset($variation['supplier_id']) && $variation['supplier_id'] > 0 && !$this->config->item('hide_supplier_on_sales_interface')) {
					$supplier = lang("supplier") . ": " . $variation['supplier_name'];
				}
				$CI = &get_instance();
				$CI->load->model('Item_variation_location');
				$item_location_quantity = $CI->Item_variation_location->get_location_quantity($variation_id);
				$variations[] = array(
					'can_override_price_adjustments' => $can_override_price_adjustments,
					'max_discount' => $max_discount,
					'tax_percent' => $tax,
					'tax_included' => $cur_item_info->tax_included,
					'override_default_tax' => $cur_item_info->override_default_tax,
					'id' => $item_id . '#' . $variation_id,
					'attribute_string' => $attribute_string,
					'variation_main' => $variation,
					'name' => $variation['name'] ? $variation['name'] : implode(', ', array_column($variation['attributes'], 'label')),
					'image_src' => 	$img_src,
					'supplier' => $supplier,
					'supplier_id' => $variation['supplier_id'],
					'type' => 'variation',
					'has_variations' => FALSE,
					'price' => $price_to_use !== FALSE ? to_currency($price_to_use) : FALSE,
					'cost_price' => $variation['cost_price'],
					'promo_price' => $variation['promo_price'],
					'start_date' => $variation['start_date'],
					'end_date' => $variation['end_date'],
					'price_without_currency' => $price_to_use !== FALSE ? $price_to_use : FALSE,
					'item_location_quantity' => $item_location_quantity,
				);
			}
		}

		if ($is_return) {
			return H($variations);
		} else {
			echo json_encode(H($variations));
		}
	}


	function categories($parent_id = NULL, $offset = 0)
	{
		//allow parallel searchs to improve performance.
		session_write_close();

		//If a false value, make sure it is NULL
		if (!$parent_id) {
			$parent_id = NULL;
		}
		///$this->config->item('number_of_items_in_grid')  previously for pagination ;
		$numbers = 999999;
		$categories = $this->Category->get_all($parent_id, FALSE, $numbers, $offset);

		$categories_count = $this->Category->count_all($parent_id);
		$config['base_url'] = site_url('sales/categories/' . ($parent_id ? $parent_id : 0));
		$config['uri_segment'] = 4;
		$config['total_rows'] = $categories_count;
		$config['per_page'] = $numbers;
		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$categories_response = array();
		$this->load->model('Appfile');

		$categories_response[] = array(
			'items_count' => 0,
			'categories_count' => 0,
			'id' => 'top',
			'name' => lang('top_items'),
			'color' => '',
			'image_id' => 0,
			'image_timestamp' => ''
		);
		$categories_response[] = array(
			'items_count' => 0,
			'categories_count' => 0,
			'id' => 'favorite',
			'name' => lang('favorite'),
			'color' => '',
			'image_id' => 0,
			'image_timestamp' => ''
		);


		$categories_response[] = array(
			'items_count' => 0,
			'categories_count' => 0,
			'id' => 'my_sareeh',
			'name' => lang('my_sareeh'),
			'color' => '',
			'image_id' => 0,
			'image_timestamp' => ''
		);

		foreach ($categories as $id => $value) {

			$items_count = $this->Item->count_all_by_category($id);
			$categoriesd = $this->Category->get_all($id);
			$categories_count = count($categoriesd);
			$categories_response[] = array(
				'items_count' => $items_count,
				'categories_count' => $categories_count,
				'id' => $id,
				'name' => $value['name'],
				'color' => $value['color'],
				'image_id' => $value['image_id'],
				'image_timestamp' => $this->Appfile->get_file_timestamp($value['image_id'])
			);
		}

		$data = array();
		$data['categories'] = H($categories_response);
		//$data['pagination'] = $this->pagination->create_links();

		echo json_encode($data);
	}

	function tags($offset = 0)
	{
		//allow parallel searchs to improve performance.
		session_write_close();

		$tags = $this->Tag->get_all($this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40, $offset, 'name', 'asc', FALSE);

		$tags_count = $this->Tag->count_all(FALSE);
		$config['base_url'] = site_url('sales/tags');
		$config['uri_segment'] = 3;
		$config['total_rows'] = $tags_count;
		$config['per_page'] = $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40;
		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$tags_response = array();

		foreach ($tags as $id => $value) {
			$tags_response[] = array('id' => $id, 'name' => $value['name']);
		}

		$data = array();
		$data['tags'] = H($tags_response);
		$data['pagination'] = $this->pagination->create_links();

		echo json_encode($data);
	}

	function suppliers($offset = 0)
	{
		//allow parallel searchs to improve performance.
		session_write_close();

		$suppliers = $this->Supplier->get_all(0, $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 49, $offset);

		$suppliers_count = $this->Supplier->count_all();
		$config['base_url'] = site_url('sales/suppliers');
		$config['uri_segment'] = 3;
		$config['total_rows'] = $suppliers_count;
		$config['per_page'] = $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40;
		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$suppliers_response = array();
		$this->load->model('Appfile');
		foreach ($suppliers->result_array() as $id => $value) {
			$suppliers_response[] = array('id' => $value['pid'], 'name' => $value['company_name'], 'image_id' => $value['image_id'], 'image_timestamp' => $this->Appfile->get_file_timestamp($value['image_id']));
		}

		$data = array();
		$data['suppliers'] = H($suppliers_response);
		$data['pagination'] = $this->pagination->create_links();

		echo json_encode($data);
	}


	function tag_items($tag_id, $offset = 0)
	{
		$this->load->model('Item_variations');

		//allow parallel searchs to improve performance.
		session_write_close();

		$config['base_url'] = site_url('sales/tag_items/' . ($tag_id ? $tag_id : 0));
		$config['uri_segment'] = 4;
		$config['per_page'] = $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40;


		//Items
		$items = array();

		$items_result = $this->Item->get_all_by_tag($tag_id, $this->config->item('hide_out_of_stock_grid') ? TRUE : FALSE, $offset, $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40)->result();
		$tax = 0;
		$store_config_tax_class = $this->config->item('tax_class_id');
		if ($store_config_tax_class) {
			$return_tax =  $this->Tax_class->get_taxes($store_config_tax_class);
			if (!empty($return_tax)) {
				$tax = $return_tax[0]['percent'];
			}
		}
		$can_override_price_adjustments = $this->Employee->get_logged_in_employee_info()->override_price_adjustments;
		$max_discount_employee = $this->Employee->get_logged_in_employee_info()->max_discount_percent;
		$max_discount_config = $this->config->item('max_discount_percent') !== '' ? $this->config->item('max_discount_percent') : NULL;
		$categories_and_items_response = [];
		if (isset($items_result)) {


			foreach ($items_result as $line => $item) {

				$img_src = "";
				if ($item->image_id != 'no_image' && $item->image_id && trim($item->image_id) != '') {
					$img_src = cacheable_app_file_url($item->image_id);
				}

				$size = $item->size ? ' - ' . $item->size : '';

				if (strpos($item->item_id, 'KIT') === 0) {
					$price_to_use = $this->Item_kit->get_sale_price(array('item_kit_id' => str_replace('KIT', '', $item->item_id)));
				} else {
					$price_to_use = $this->Item->get_sale_price(array('item_id' => $item->item_id));
				}
				$item_taxes = $this->Item_taxes->get_info($item->item_id);

				if (!empty($item_taxes)) {
					$tax = $item_taxes[0]['percent'];
				}
				$item_info = $this->item->get_info($item->item_id);
				$allow_price_override_regardless_of_permissions =  $item_info->allow_price_override_regardless_of_permissions ? 1 : 0;

				$max_discount = $item_info->max_discount_percent;
				//Try employee
				if (!$can_override_price_adjustments && $max_discount === NULL) {
					$max_discount = $max_discount_employee;
				}

				//Try globally
				if (!$can_override_price_adjustments && $max_discount === NULL) {
					$max_discount = $max_discount_config;
				}

				$variatons = 	$this->item_variations($item->item_id, true);

				$this->load->model('Item_attribute');
				$item_attributes_available = $this->Item_attribute->get_attributes_for_item_with_attribute_values_updated($item->item_id);
				//  dd($item_attributes_available);
				// $variation_ids_to_lookup = [];

				// foreach($variatons as $var)
				// {
				// 	$variation_ids_to_lookup[] =  explode('#' , $var['id'])[1] ;
				// }



				// $item_attributes_available = $this->Item_variations->get_attributes($variation_ids_to_lookup);

				$mods_for_item = $this->Item_modifier->get_modifiers_for_item_id($item->item_id)->result_array();

				if ($mods_for_item) {
					foreach ($mods_for_item as $modifier_item_id => $modifier_item) {

						// dd($modifier_item);
						$Item_modifier  = $this->Item_modifier->get_modifier_item_info($modifier_item['id']);
						// dd($Item_modifier);
						$mods_for_item[$modifier_item_id]['modifier_item_id'] = $modifier_item['id'];
						$mods_for_item[$modifier_item_id]['unit_price'] =  $Item_modifier['unit_price'];
						$mods_for_item[$modifier_item_id]['cost_price'] =  $Item_modifier['cost_price'];
						$mods_for_item[$modifier_item_id]['unit_price_currency'] =  to_currency($Item_modifier['unit_price']);
						$mods_for_item[$modifier_item_id]['modifier_item_name'] =   $Item_modifier['modifier_item_name'];
					}
				}
				$item_id = $item->item_id;


				$quantity_units = $this->Item->get_quantity_units($item_id, true);
				$quantity_units_res = array();
				$quantity_units_info = array();
				if (!empty($quantity_units)) {
					$quantity_units_res[0]['value'] = "0";
					$quantity_units_res[0]['text'] = lang('None');
					foreach ($quantity_units as $key => $value) {
						$quantity_units_res[$value['id']]['value'] = $value['id'];
						$quantity_units_res[$value['id']]['text'] = $value['unit_name'];
						$quantity_units_info[$value['id']] = (array) $this->Item->get_quantity_unit_info($value['id']);
					}
					// dd($quantity_units);
				}
				/// getting items and categories




				$permissions = array(
					'allow_price_override_regardless_of_permissions' => $allow_price_override_regardless_of_permissions,
					'always_use_average_cost_method' => $this->config->item('always_use_average_cost_method'),
					'hide_supplier_on_sales_interface' => $this->config->item('hide_supplier_on_sales_interface'),
					'disable_supplier_selection_on_sales_interface' => $this->config->item('disable_supplier_selection_on_sales_interface'),
					'hide_description_on_sales_and_recv' => $this->config->item('hide_description_on_sales_and_recv'),
					'allow_alt_description' => $item_info->allow_alt_description,
					'change_cost_price' =>  $item_info->change_cost_price,
					'edit_serail_no' =>  	$this->Employee->has_module_action_permission('sales', 'edit_serail_no', $this->Employee->get_logged_in_employee_info()->person_id),
					'require_to_add_serial_number_in_pos' => $this->config->item('require_to_add_serial_number_in_pos'),
					'id_to_show_on_sale_interface' =>	$this->config->item('id_to_show_on_sale_interface'),
					'do_not_allow_out_of_stock_items_to_be_sold' =>	$this->config->item('do_not_allow_out_of_stock_items_to_be_sold'),
					'process_returns' => (!$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)),
					'process_returns_error' => lang('sales_not_allowed_returns'),
					'sales_could_not_discount_item_above_max' => lang('sales_could_not_discount_item_above_max'),
					'do_not_allow_below_cost' => $this->config->item('do_not_allow_below_cost'),

				);
				// dd( $quantity_units);
				$source_supplier_data = array();

				$secondary_supplier_details = array();
				foreach ($this->Item->get_all_suppliers_of_an_item($item->item_id)->result_array() as $row) {
					$source_supplier_data[$row['supplier_id']] = array('value' => $row['supplier_id'], 'text' => $row['company_name'] . ' (' . $row['full_name'] . ')');
					$secondary_supplier = $this->Item->get_secondary_supplier_details($item->item_id, $row['supplier_id']);
					if ($secondary_supplier) {
						$secondary_supplier_details[$row['supplier_id']] = (array) $secondary_supplier;
					}
				}
				// $params['item'] = $item;
				// $params['quantity'] = 1;
				$CI = &get_instance();

				$rule = $CI->Price_rule->get_all_rule_for_item($item->item_id);
				// dd($rule);
				$serial_numbers = [];
				$employee_location_id = $this->Employee->get_logged_in_employee_current_location_id();
				if ($item_info->is_serialized) {
					$serial_numbers = $this->Item_serial_number->get_all_data($item_info->item_id, $employee_location_id, $input = array());
				}



				$id_to_show_on_sale_interface_val = '';
				switch ($this->config->item('id_to_show_on_sale_interface')) {
					case 'number':

						if (property_exists($item, 'item_number') && $item->item_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_number);
						} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_kit_number);
						} else {
							$id_to_show_on_sale_interface_val =  lang('none');
						}

						break;

					case 'product_id':
						$id_to_show_on_sale_interface_val =  property_exists($item, 'product_id') ? H($item->product_id) : lang('none');
						break;

					case 'id':
						$id_to_show_on_sale_interface_val =  property_exists($item, 'item_id') ? H($item->item_id) : 'KIT ' . H($item->item_kit_id);
						break;

					default:
						if (property_exists($item, 'item_number') && $item->item_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_number);
						} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_kit_number);
						} else {
							$id_to_show_on_sale_interface_val =  lang('none');
						}
						break;
				}

				$cur_quantity = 0;
				$item_variation_location_info = [];
				$item_location_info = [];


				if (isset($item_info->variation_id)) {
					$item_location_quantity = $CI->Item_variation_location->get_location_quantity($item_info->variation_id);

					$cur_quantity = (int) $item_location_quantity;
				} else {
					$item_location_info = $this->Item_location->get_info($item_info->item_id, $employee_location_id, false, 0);
					$item_location_quantity = (int) $this->Item_location->get_location_quantity($item_info->item_id);
					$cur_quantity = (int) $item_location_quantity;
				}


				$item_location_info  = (array) $item_location_info;
				$item_tier_row = [];
				$item_location_tier_row = [];
				$all_tier_info = [];
				foreach ($this->Tier->get_all()->result() as $key  => $tier) {
					$all_tier_info[$tier->id] = (array) $tier;
					$item_tier_row[$tier->id] = (array) $this->Item->get_tier_price_row($tier->id, $item_info->item_id);
					$item_location_tier_row[$tier->id] = (array)  $this->Item_location->get_tier_price_row($tier->id, $item_info->item_id, $employee_location_id);
				}

				if (count($variatons) > 0) {
					foreach ($variatons as $key => $var) {
						$variatons[$key]['item_variation_location_info'] = (array) $this->Item_variation_location->get_info(explode('#', $var['id'])[1], $employee_location_id, true, 0);
					}
				}





				$categories_and_items_response[] = array(
					'permissions' => $permissions,
					'source_supplier_data' => $source_supplier_data,
					'secondary_supplier_details' => $secondary_supplier_details,
					'can_override_price_adjustments' => $can_override_price_adjustments,
					'id' => $item->item_id,
					'rules' => $rule,
					'item_location_info' => $item_location_info,
					'item_tier_row' => $item_tier_row,
					'item_location_tier_row' => $item_location_tier_row,
					'all_tier_info' => $all_tier_info,
					'max_discount' => $max_discount,
					'name' => character_limiter($item->name, 30) . $size,
					'item_taxes' => $item_taxes,
					"is_serialized" => $item_info->is_serialized,
					"serial_numbers" => $serial_numbers,
					'tax_percent' => $tax,
					'is_recurring' => $item_info->is_recurring,
					'tax_included' => $item->tax_included,
					'override_default_tax' => $item->override_default_tax,
					'image_src' => 	$img_src,
					'category_name' => 	$this->Category->get_full_path($item_info->category_id),
					'category_id' => 	$item_info->category_id,
					'description' => 	clean_html($item_info->description),
					'has_variations' => count($variatons) > 0 ? $variatons : FALSE,
					'item_attributes_available' => $item_attributes_available,
					'type' => 'item',
					'quantity_units' => $quantity_units_res,
					'quantity_units_info' => $quantity_units_info,
					'modifiers'	=> $mods_for_item,
					"cost_price" => $item_info->cost_price,
					'price' => $price_to_use != '0.00' ? to_currency($price_to_use) : FALSE,
					'regular_price' => $item->unit_price,
					'different_price' => $price_to_use != $item->unit_price,
					'id_to_show_on_sale_interface_val' => $id_to_show_on_sale_interface_val,
					'cur_quantity' => to_quantity($cur_quantity),
					'is_series_package' => $item_info->is_series_package,
					'series_quantity' => $item_info->series_quantity,
					'series_days_to_use_within' => $item_info->series_days_to_use_within,
					'item_location_quantity' => $item_location_quantity,
					'is_service' => $item_info->is_service,
					'max_edit_price' => $item_info->max_edit_price,
					'min_edit_price' => $item_info->min_edit_price,

				);
			}
		}


		$items_count = $this->Item->count_all_by_tag($tag_id);

		$number = $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40;

		$config['base_url'] = site_url('sales/tag_items/' . ($tag_id ? $tag_id : 0));
		$config['uri_segment'] = 4;
		$config['per_page'] = $number;

		$categories_count = 0;
		$categories_and_items_response = array_slice($categories_and_items_response, $offset > $categories_count ? $categories_count : $offset, $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40);


		$data = array();
		$data['categories_and_items'] = H($categories_and_items_response);
		$config['total_rows'] =  $items_count;

		$config['first_link'] = '<<';
		$config['last_link']  = '>>';
		$config['full_tag_open'] = '<ul class="pagination " style="marigin : 10px 0px 0px 0px !important" >'; // or any class
		$config['full_tag_close'] = '</ul>';
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['categories_count'] = $categories_count;
		$data['items_count'] = $items_count;
		echo json_encode($data);;
	}

	function favorite_items($offset = 0)
	{
		$this->load->model('Item_variations');

		//allow parallel searchs to improve performance.
		session_write_close();

		$config['base_url'] = site_url('sales/favorite_items/');
		$config['uri_segment'] = 3;
		$config['per_page'] = $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40;

		//Items
		$items = array();

		$items_result = $this->Item->get_all_favorite_items($this->config->item('hide_out_of_stock_grid') ? TRUE : FALSE, $offset, $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') + 4 : 18)->result();


		foreach ($items_result as $item) {
			$size = $item->size ? ' - ' . $item->size : '';

			$img_src = "";
			if ($item->image_id != 'no_image' && trim($item->image_id) != '') {
				$img_src = cacheable_app_file_url($item->image_id);
			}

			if (strpos($item->item_id, 'KIT') === 0) {
				$price_to_use = $this->Item_kit->get_sale_price(array('item_kit_id' => str_replace('KIT', '', $item->item_id)));
			} else {
				$price_to_use = $this->Item->get_sale_price(array('item_id' => $item->item_id));
			}

			$items[] = array(
				'id' => $item->item_id,
				'name' => character_limiter($item->name, 58) . $size,
				'image_src' => 	$img_src,
				'type' => 'item',
				'has_variations' => count($this->Item_variations->get_variations($item->item_id)) > 0 ? TRUE : FALSE,
				'price' => $price_to_use != '0.00' ? to_currency($price_to_use) : FALSE,
				'regular_price' => to_currency($item->unit_price),
				'different_price' => $price_to_use != $item->unit_price,
			);
		}

		$items_count = $this->Item->count_all_favorite_items();

		$data = array();
		$data['items'] = H($items);
		$config['total_rows'] = $items_count;
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		echo json_encode($data);
	}

	function supplier_items($supplier_id, $offset = 0)
	{
		$this->load->model('Item_variations');

		//allow parallel searchs to improve performance.
		session_write_close();

		$config['base_url'] = site_url('sales/supplier_items/' . ($supplier_id ? $supplier_id : 0));
		$config['uri_segment'] = 4;
		$config['per_page'] = $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40;


		//Items
		$items = array();

		$items_result = $this->Item->get_all_item_by_supplier($supplier_id, $this->config->item('hide_out_of_stock_grid') ? TRUE : FALSE, $offset, $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40)->result();
		$tax = 0;
		$store_config_tax_class = $this->config->item('tax_class_id');
		if ($store_config_tax_class) {
			$return_tax =  $this->Tax_class->get_taxes($store_config_tax_class);
			if (!empty($return_tax)) {
				$tax = $return_tax[0]['percent'];
			}
		}
		$can_override_price_adjustments = $this->Employee->get_logged_in_employee_info()->override_price_adjustments;
		$max_discount_employee = $this->Employee->get_logged_in_employee_info()->max_discount_percent;
		$max_discount_config = $this->config->item('max_discount_percent') !== '' ? $this->config->item('max_discount_percent') : NULL;
		$categories_and_items_response = [];
		if (isset($items_result)) {


			foreach ($items_result as $line => $item) {

				$img_src = "";
				if ($item->image_id != 'no_image' && $item->image_id && trim($item->image_id) != '') {
					$img_src = cacheable_app_file_url($item->image_id);
				}

				$size = $item->size ? ' - ' . $item->size : '';

				if (strpos($item->item_id, 'KIT') === 0) {
					$price_to_use = $this->Item_kit->get_sale_price(array('item_kit_id' => str_replace('KIT', '', $item->item_id)));
				} else {
					$price_to_use = $this->Item->get_sale_price(array('item_id' => $item->item_id));
				}
				$item_taxes = $this->Item_taxes->get_info($item->item_id);

				if (!empty($item_taxes)) {
					$tax = $item_taxes[0]['percent'];
				}
				$item_info = $this->item->get_info($item->item_id);
				$allow_price_override_regardless_of_permissions =  $item_info->allow_price_override_regardless_of_permissions ? 1 : 0;

				$max_discount = $item_info->max_discount_percent;
				//Try employee
				if (!$can_override_price_adjustments && $max_discount === NULL) {
					$max_discount = $max_discount_employee;
				}

				//Try globally
				if (!$can_override_price_adjustments && $max_discount === NULL) {
					$max_discount = $max_discount_config;
				}

				$variatons = 	$this->item_variations($item->item_id, true);

				$this->load->model('Item_attribute');
				$item_attributes_available = $this->Item_attribute->get_attributes_for_item_with_attribute_values_updated($item->item_id);
				//  dd($item_attributes_available);
				// $variation_ids_to_lookup = [];

				// foreach($variatons as $var)
				// {
				// 	$variation_ids_to_lookup[] =  explode('#' , $var['id'])[1] ;
				// }



				// $item_attributes_available = $this->Item_variations->get_attributes($variation_ids_to_lookup);

				$mods_for_item = $this->Item_modifier->get_modifiers_for_item_id($item->item_id)->result_array();

				if ($mods_for_item) {
					foreach ($mods_for_item as $modifier_item_id => $modifier_item) {

						// dd($modifier_item);
						$Item_modifier  = $this->Item_modifier->get_modifier_item_info($modifier_item['id']);
						// dd($Item_modifier);
						$mods_for_item[$modifier_item_id]['modifier_item_id'] = $modifier_item['id'];
						$mods_for_item[$modifier_item_id]['unit_price'] =  $Item_modifier['unit_price'];
						$mods_for_item[$modifier_item_id]['cost_price'] =  $Item_modifier['cost_price'];
						$mods_for_item[$modifier_item_id]['unit_price_currency'] =  to_currency($Item_modifier['unit_price']);
						$mods_for_item[$modifier_item_id]['modifier_item_name'] =   $Item_modifier['modifier_item_name'];
					}
				}
				$item_id = $item->item_id;


				$quantity_units = $this->Item->get_quantity_units($item_id, true);
				$quantity_units_res = array();
				$quantity_units_info = array();
				if (!empty($quantity_units)) {
					$quantity_units_res[0]['value'] = "0";
					$quantity_units_res[0]['text'] = lang('None');
					foreach ($quantity_units as $key => $value) {
						$quantity_units_res[$value['id']]['value'] = $value['id'];
						$quantity_units_res[$value['id']]['text'] = $value['unit_name'];
						$quantity_units_info[$value['id']] = (array) $this->Item->get_quantity_unit_info($value['id']);
					}
					// dd($quantity_units);
				}
				/// getting items and categories




				$permissions = array(
					'allow_price_override_regardless_of_permissions' => $allow_price_override_regardless_of_permissions,
					'always_use_average_cost_method' => $this->config->item('always_use_average_cost_method'),
					'hide_supplier_on_sales_interface' => $this->config->item('hide_supplier_on_sales_interface'),
					'disable_supplier_selection_on_sales_interface' => $this->config->item('disable_supplier_selection_on_sales_interface'),
					'hide_description_on_sales_and_recv' => $this->config->item('hide_description_on_sales_and_recv'),
					'allow_alt_description' => $item_info->allow_alt_description,
					'change_cost_price' =>  $item_info->change_cost_price,
					'edit_serail_no' =>  	$this->Employee->has_module_action_permission('sales', 'edit_serail_no', $this->Employee->get_logged_in_employee_info()->person_id),
					'require_to_add_serial_number_in_pos' => $this->config->item('require_to_add_serial_number_in_pos'),
					'id_to_show_on_sale_interface' =>	$this->config->item('id_to_show_on_sale_interface'),
					'do_not_allow_out_of_stock_items_to_be_sold' =>	$this->config->item('do_not_allow_out_of_stock_items_to_be_sold'),
					'process_returns' => (!$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)),
					'process_returns_error' => lang('sales_not_allowed_returns'),
					'sales_could_not_discount_item_above_max' => lang('sales_could_not_discount_item_above_max'),
					'do_not_allow_below_cost' => $this->config->item('do_not_allow_below_cost'),

				);
				// dd( $quantity_units);
				$source_supplier_data = array();

				$secondary_supplier_details = array();
				foreach ($this->Item->get_all_suppliers_of_an_item($item->item_id)->result_array() as $row) {
					$source_supplier_data[$row['supplier_id']] = array('value' => $row['supplier_id'], 'text' => $row['company_name'] . ' (' . $row['full_name'] . ')');
					$secondary_supplier = $this->Item->get_secondary_supplier_details($item->item_id, $row['supplier_id']);
					if ($secondary_supplier) {
						$secondary_supplier_details[$row['supplier_id']] = (array) $secondary_supplier;
					}
				}
				// $params['item'] = $item;
				// $params['quantity'] = 1;
				$CI = &get_instance();

				$rule = $CI->Price_rule->get_all_rule_for_item($item->item_id);
				// dd($rule);
				$serial_numbers = [];
				$employee_location_id = $this->Employee->get_logged_in_employee_current_location_id();
				if ($item_info->is_serialized) {
					$serial_numbers = $this->Item_serial_number->get_all_data($item_info->item_id, $employee_location_id, $input = array());
				}



				$id_to_show_on_sale_interface_val = '';
				switch ($this->config->item('id_to_show_on_sale_interface')) {
					case 'number':

						if (property_exists($item, 'item_number') && $item->item_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_number);
						} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_kit_number);
						} else {
							$id_to_show_on_sale_interface_val =  lang('none');
						}

						break;

					case 'product_id':
						$id_to_show_on_sale_interface_val =  property_exists($item, 'product_id') ? H($item->product_id) : lang('none');
						break;

					case 'id':
						$id_to_show_on_sale_interface_val =  property_exists($item, 'item_id') ? H($item->item_id) : 'KIT ' . H($item->item_kit_id);
						break;

					default:
						if (property_exists($item, 'item_number') && $item->item_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_number);
						} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
							$id_to_show_on_sale_interface_val =  H($item->item_kit_number);
						} else {
							$id_to_show_on_sale_interface_val =  lang('none');
						}
						break;
				}

				$cur_quantity = 0;
				$item_variation_location_info = [];
				$item_location_info = [];


				if (isset($item_info->variation_id)) {
					$item_location_quantity = $CI->Item_variation_location->get_location_quantity($item_info->variation_id);

					$cur_quantity = (int) $item_location_quantity;
				} else {
					$item_location_info = $this->Item_location->get_info($item_info->item_id, $employee_location_id, false, 0);
					$item_location_quantity = (int) $this->Item_location->get_location_quantity($item_info->item_id);
					$cur_quantity = (int) $item_location_quantity;
				}


				$item_location_info  = (array) $item_location_info;
				$item_tier_row = [];
				$item_location_tier_row = [];
				$all_tier_info = [];
				foreach ($this->Tier->get_all()->result() as $key  => $tier) {
					$all_tier_info[$tier->id] = (array) $tier;
					$item_tier_row[$tier->id] = (array) $this->Item->get_tier_price_row($tier->id, $item_info->item_id);
					$item_location_tier_row[$tier->id] = (array)  $this->Item_location->get_tier_price_row($tier->id, $item_info->item_id, $employee_location_id);
				}

				if (count($variatons) > 0) {
					foreach ($variatons as $key => $var) {
						$variatons[$key]['item_variation_location_info'] = (array) $this->Item_variation_location->get_info(explode('#', $var['id'])[1], $employee_location_id, true, 0);
					}
				}





				$categories_and_items_response[] = array(
					'permissions' => $permissions,
					'source_supplier_data' => $source_supplier_data,
					'secondary_supplier_details' => $secondary_supplier_details,
					'can_override_price_adjustments' => $can_override_price_adjustments,
					'id' => $item->item_id,
					'rules' => $rule,
					'item_location_info' => $item_location_info,
					'item_tier_row' => $item_tier_row,
					'item_location_tier_row' => $item_location_tier_row,
					'all_tier_info' => $all_tier_info,
					'max_discount' => $max_discount,
					'name' => character_limiter($item->name, 30) . $size,
					'item_taxes' => $item_taxes,
					"is_serialized" => $item_info->is_serialized,
					"serial_numbers" => $serial_numbers,
					'tax_percent' => $tax,
					'is_recurring' => $item_info->is_recurring,
					'tax_included' => $item->tax_included,
					'override_default_tax' => $item->override_default_tax,
					'image_src' => 	$img_src,
					'category_name' => 	$this->Category->get_full_path($item_info->category_id),
					'category_id' => 	$item_info->category_id,
					'description' => 	clean_html($item_info->description),
					'has_variations' => count($variatons) > 0 ? $variatons : FALSE,
					'item_attributes_available' => $item_attributes_available,
					'type' => 'item',
					'quantity_units' => $quantity_units_res,
					'quantity_units_info' => $quantity_units_info,
					'modifiers'	=> $mods_for_item,
					"cost_price" => $item_info->cost_price,
					'price' => $price_to_use != '0.00' ? to_currency($price_to_use) : FALSE,
					'regular_price' => $item->unit_price,
					'different_price' => $price_to_use != $item->unit_price,
					'id_to_show_on_sale_interface_val' => $id_to_show_on_sale_interface_val,
					'cur_quantity' => to_quantity($cur_quantity),
					'is_series_package' => $item_info->is_series_package,
					'series_quantity' => $item_info->series_quantity,
					'series_days_to_use_within' => $item_info->series_days_to_use_within,
					'item_location_quantity' => $item_location_quantity,
					'is_service' => $item_info->is_service,
					'max_edit_price' => $item_info->max_edit_price,
					'min_edit_price' => $item_info->min_edit_price,

				);
			}
		}
		$categories_count = 0;
		$items_count = count($items_result);
		$categories_and_items_response = array_slice($categories_and_items_response, $offset > $categories_count ? $categories_count : $offset, $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 40);


		$data = array();
		$data['categories_and_items'] = H($categories_and_items_response);
		$config['total_rows'] =  $items_count;

		$config['first_link'] = '<<';
		$config['last_link']  = '>>';
		$config['full_tag_open'] = '<ul class="pagination " style="marigin : 10px 0px 0px 0px !important" >'; // or any class
		$config['full_tag_close'] = '</ul>';
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['categories_count'] = $categories_count;
		$data['items_count'] = $items_count;
		echo json_encode($data);;
	}

	function delete_tax($name)
	{
		$this->check_action_permission('delete_taxes');
		$name = rawurldecode($name);
		$this->cart->add_excluded_tax($name);
		$this->cart->save();
		$this->sales_reload();
	}

	function view_receipt_modal()
	{
		$this->load->view('sales/lookup_modal');
	}

	function set_delivery()
	{
		$this->cart->set_has_delivery($this->input->post('delivery'));

		if ($this->input->post('delivery') == '0') {
			$index_to_delete = $this->cart->get_index_for_delivery_item();
			if ($index_to_delete !== FALSE) {
				$this->cart->delete_item($index_to_delete);
			}
		}

		$data = array();
		$this->cart->save();

		$this->sales_reload($data);
	}

	function set_delivery_info()
	{
		$data = array();
		$this->cart->set_has_delivery(1);

		$this->cart->set_delivery_person_info($this->input->post('delivery_person_info'));
		$this->cart->set_delivery_info($this->input->post('delivery_info'));
		$this->cart->set_delivery_tax_group_id($this->input->post('delivery_tax_group_id'));

		$delivery_item_id = $this->Item->create_or_update_delivery_item();

		$delivery_fee = $this->input->post('delivery_fee');

		if ($delivery_fee) {
			$delivery_item = new PHPPOSCartItemSale(array('cart' => $this->cart, 'scan' => $delivery_item_id . '|FORCE_ITEM_ID|', 'cost_price' => to_currency_no_money($delivery_fee), 'unit_price' => to_currency_no_money($delivery_fee), 'quantity' => 1));

			if ($delivery_item_in_cart = $this->cart->find_similiar_item($delivery_item)) {
				$this->cart->delete_item($this->cart->get_item_index($delivery_item_in_cart));
			}

			$this->cart->add_item($delivery_item);
		}

		$this->cart->save();
		$this->sales_reload($data);
	}

	function view_delivery_modal()
	{
		$this->lang->load('deliveries');
		$this->load->model('Tax_class');
		$this->load->model('Shipping_zone');
		$this->load->model('Zip');
		$this->load->model('Delivery');

		$tax_classes = array();
		$tax_classes[''] = lang('none');

		foreach ($this->Tax_class->get_all()->result_array() as $tax_class) {
			$tax_classes[$tax_class['id']] = $tax_class['name'];
		}

		$delivery_info = $this->cart->get_delivery_info();

		if (empty($delivery_info)) {
			$delivery_info['comment'] = '';
			$delivery_info['sale_id'] = '';
			$delivery_info['tracking_number'] = '';
			$delivery_info['is_pickup'] = 0;
			$delivery_info['delivery_employee_person_id'] = $this->config->item('default_employee_for_deliveries') ? $this->config->item('default_employee_for_deliveries') : $this->Employee->get_logged_in_employee_info()->person_id;
			$delivery_info['status'] = NULL;
			$delivery_info['category_id'] = NULL;
			$delivery_info['duration'] = 30;
			$delivery_info['contact_preference'] = array();
			$delivery_info['location_id'] = $this->Employee->get_logged_in_employee_current_location_id();
		}

		$delivery_person_info = $this->cart->get_delivery_person_info();

		$customer_info = $this->Customer->get_info($this->cart->customer_id);

		if (empty($delivery_person_info)) {
			$delivery_person_info['first_name'] = $customer_info->first_name;
			$delivery_person_info['last_name'] = $customer_info->last_name;
			$delivery_person_info['phone_number'] = format_phone_number($customer_info->phone_number);
			$delivery_person_info['email'] = $customer_info->email;
			$delivery_person_info['address_1'] = $customer_info->address_1;
			$delivery_person_info['address_2'] = $customer_info->address_2;
			$delivery_person_info['city'] = $customer_info->city;
			$delivery_person_info['state'] = $customer_info->state;
			$delivery_person_info['zip'] = $customer_info->zip;
			$delivery_person_info['country'] = $customer_info->country;

			$this->cart->set_delivery_person_info($delivery_person_info);
		}

		$zip_lookup = $this->Zip->lookup($delivery_person_info['zip'])->row_array();
		$zip_zones = array();

		foreach ($this->Zip->get_all()->result_array() as $zip) {
			$zip_zones[$zip['name']] = $zip['shipping_zone_id'];
		}

		$shipping_zones = array();
		$shipping_zones['0'] = lang('none');

		$shipping_zone_id = isset($delivery_info['shipping_zone_id']) ? $delivery_info['shipping_zone_id'] : (isset($zip_lookup['shipping_zone_id']) ? $zip_lookup['shipping_zone_id'] : '');

		foreach ($this->Shipping_zone->get_all()->result_array() as $shipping_zone) {
			$shipping_zones[$shipping_zone['id']] = $shipping_zone['name'];
		}

		$shipping_zone_info = array();
		foreach ($this->Shipping_zone->get_all()->result_array() as $shipping_zone) {
			$shipping_zone_info[$shipping_zone['id']] = array('name' => $shipping_zone['name'], 'fee' => $shipping_zone['fee'], 'tax_class_id' => $shipping_zone['tax_class_id']);
		}

		$delivery_tax_group_id = $this->cart->get_delivery_tax_group_id();
		if ($delivery_tax_group_id === NULL) //haven't set group
		{
			$delivery_tax_group_id = $customer_info->tax_class_id;
		}

		$delivery_providers = $this->Shipping_provider->get_all()->result_array();
		$delivery_methods = $this->Shipping_method->get_all()->result_array();

		$providers_with_methods = array();

		foreach ($delivery_providers as $provider) {
			$providers_with_methods[$provider['id']] = $provider;
		}

		foreach ($delivery_methods as $method) {
			$providers_with_methods[$method['shipping_provider_id']]['methods'][] = $method;
		}

		$delivery_fee = $this->cart->get_delivery_item_price_in_cart();

		$deliveries_status[''] = lang('none');

		foreach ($this->Delivery->get_all_statuses() as $id => $row) {
			$deliveries_status[$id] = $row['name'];
		}

		$data['deliveries_status'] = $deliveries_status;

		$categories = $this->Delivery_category->get_all();

		$contact_preference = array(
			lang('phone'),
			lang('email'),
			lang('text')
		);

		$locations = $this->Location->get_all()->result();

		$this->load->view('sales/delivery_modal', array('delivery_person_info' => $delivery_person_info, 'delivery_info' => $delivery_info, 'providers_with_methods' => $providers_with_methods, 'tax_classes' => $tax_classes, 'delivery_tax_group_id' => $delivery_tax_group_id, 'shipping_zone_id' => $shipping_zone_id, 'shipping_zone_info' => $shipping_zone_info, 'shipping_zones' => $shipping_zones, 'delivery_fee' => $delivery_fee, 'zip_zones' => $zip_zones, 'deliveries_status' => $deliveries_status, 'categories' => $categories, 'locations' => $locations, 'contact_preference' => $contact_preference));
	}

	function sig_save($sale_register_id_display = false)
	{
		$this->load->model('Register_cart');

		$this->load->model('Appfile');
		$sale_id = $this->input->post('sale_id');
		$sale_info = $this->Sale->get_info($sale_id)->row_array();

		//If we have a signature delete it
		if ($sale_info['signature_image_id']) {
			$this->Sale->update(array('signature_image_id' => NULL), $sale_id);
			$this->Appfile->delete($sale_info['signature_image_id']);
		}

		$image = base64_decode($this->input->post('image'));
		$image_file_id = $this->Appfile->save('signature_' . $sale_id . '.png', $image);
		$this->Sale->update(array('signature_image_id' => $image_file_id), $sale_id);

		$this->Register_cart->remove_data('sale_id', $sale_register_id_display ? $sale_register_id_display : $this->Employee->get_logged_in_employee_current_register_id());

		echo json_encode(array('file_id' => $image_file_id, 'file_timestamp' => $this->Appfile->get_file_timestamp($image_file_id)));
	}

	function customer_display($register_id = false)
	{
		if (!$register_id) {
			$register_id = $this->Employee->get_logged_in_employee_current_register_id();
		}

		if ($this->Register->exists($register_id)) {
			// $data['is_pos'] = true;


			$data = array(
				'remove_topbar' => true,
				'is_pos' => true,
				'register_id' => $register_id,
				'fullscreen_customer_display' => $this->session->userdata('fullscreen_customer_display')
			);
			$tiers = array();

			$tiers[0] = lang('none');
			foreach ($this->Tier->get_all()->result() as $tier) {
				$tiers[$tier->id] = $tier->name;
			}

			$data['tiers'] = $tiers;
			$this->load->view('sales/customer_display_initial', $data);
		}
	}

	function customer_display_update($register_id = false)
	{
		//allow parallel searchs to improve performance.
		session_write_close();
		$this->load->model('Register_cart');

		if (!$register_id) {
			$register_id = $this->Employee->get_logged_in_employee_current_register_id();
		}

		if ($this->Register->exists($register_id)) {
			$data = $this->Register_cart->get_data($register_id);
			$data['mode'] = "sale";

			if (isset($data['sale_id'])) {
				$sale_info = $this->Sale->get_info($data['sale_id'])->row_array();
				$customer_id = $sale_info['customer_id'];

				if ($customer_id) {
					$cust_info = $this->Customer->get_info($customer_id);
					$data['customer'] = $cust_info->first_name . ' ' . $cust_info->last_name . ($cust_info->account_number == ''  ? '' : ' - ' . $cust_info->account_number);
					$data['customer_company'] = $cust_info->company_name;
					$data['customer_email'] = $cust_info->email;
				}
			}

			$data['fullscreen_customer_display'] = $this->session->userdata('fullscreen_customer_display');

			$this->load->view("sales/customer_display", $data);
		}
	}

	function customer_display_info($register_id)
	{

		//allow parallel searchs to improve performance.
		session_write_close();

		$this->load->model('Register_cart');

		$return = array();
		$return['sale_id'] = false;

		if (!$register_id) {
			$register_id = $this->Employee->get_logged_in_employee_current_register_id();
		}

		if ($this->Register->exists($register_id)) {
			$data = $this->Register_cart->get_data($register_id);
			if (isset($data['sale_id'])) {

				$sale_info = $this->Sale->get_info($data['sale_id'])->row_array();
				$return['sale_id'] = $data['sale_id'];
				$signature_needed = $this->config->item('capture_sig_for_all_payments') || (strpos($sale_info['payment_type'], lang('credit')) !== FALSE) ||  (strpos($sale_info['payment_type'], lang('store_account')) !== FALSE);
				$return['signature_needed'] = $signature_needed;
			}
		}
		echo json_encode(H($return));
	}

	function open_drawer()
	{
		//incase user call by url
		if ($this->Employee->has_module_action_permission('sales', 'add_remove_amounts_from_cash_drawer', $this->Employee->get_logged_in_employee_info()->person_id)) {
			$this->load->view('sales/open_drawer');
		} else {
			return false;
		}
	}

	function disable_test_mode()
	{
		$this->load->helper('demo');
		if (!is_on_demo_host()) {
			$this->Appconfig->save('test_mode', '0');
		}

		redirect(site_url('sales'));
	}

	function enable_test_mode()
	{
		$this->load->helper('demo');
		if (!is_on_demo_host()) {
			$this->Appconfig->save('test_mode', '1');
		}
		redirect(site_url('sales'));
	}

	function create_po($sale_id)
	{
		$this->load->model('Sale');
		$this->load->model('Item_location');
		$this->load->model('Item');


		require_once(APPPATH . "models/cart/PHPPOSCartRecv.php");
		$cart = PHPPOSCartRecv::get_instance('receiving');
		$cart->destroy();


		$items = $this->Sale->get_sale_items($sale_id)->result_array();

		$item_ids = array();

		foreach ($items as $item) {
			$item_id = $item['item_id'];
			$item_ids[$item_id] = TRUE;
		}

		foreach (array_keys($item_ids) as $item_id) {
			$quantity_to_add = 1;
			$cur_item_location_info = $this->Item_location->get_info($item_id);
			$cur_item_info = $this->Item->get_info($item_id);
			$replenish_level = ($cur_item_location_info && $cur_item_location_info->replenish_level) ? $cur_item_location_info->replenish_level : $cur_item_info->replenish_level;
			$reorder_level = ($cur_item_location_info && $cur_item_location_info->reorder_level) ? $cur_item_location_info->reorder_level : $cur_item_info->reorder_level;

			$val = $replenish_level ? $replenish_level : $reorder_level;
			if ($val == null) {
				$val = 0;
			}
			$quantity_to_add = $val - (int)$cur_item_location_info->quantity;
			$cart->add_item(new PHPPOSCartItemRecv(array(
				'scan' => $item_id . '|FORCE_ITEM_ID|',
				'quantity' => max(0, $quantity_to_add),
				'cart' => $cart,
			)));
		}

		$cart->is_po = TRUE;
		$cart->set_mode('purchase_order');
		$cart->save();

		redirect('receivings');
	}

	function exchange_to()
	{
		$data = array();
		$rate = $this->input->post('rate');
		$this->cart->set_exchange_details($rate);
		$this->cart->save();
		$this->sales_reload($data);
	}



	function _is_dob_in_correct_format($dob)
	{
		$format = get_date_format_extended();
		$pattern = "/[^\-\/]/";
		$format = preg_replace($pattern, "#", $format);
		$dob_format = preg_replace($pattern, "#", $dob);

		return $dob_format == $format;
	}

	function save_dob($line_just_added)
	{
		$data = array();
		$dob = $this->input->post('dob');

		if ($this->config->item('strict_age_format_check')) {
			if (!$this->_is_dob_in_correct_format($dob)) {
				$message = lang('sales_age_date_format_incorrect') . ' (' . get_date_format_extended() . ')';
				$this->cart->delete_item($line_just_added);
				$this->cart->save();
				echo json_encode(array('success' => false, 'message' => $message));
				return;
			}
		}
		$age = round((time() - strtotime($dob)) / (3600 * 24 * 365.25));
		$this->cart->age = $age;
		$age_verified = $this->cart->is_cart_age_verified();

		if (!$age_verified) {
			$this->cart->delete_item($line_just_added);
		}

		$this->cart->save();

		if ($age_verified) {
			$message = lang('sales_age_verify_success');
		} else {
			$message = lang('sales_age_verify_error');
		}
		echo json_encode(array('success' => $age_verified, 'message' => $message));
	}
	function opened_customer_facing_display()
	{
		$this->session->set_userdata('opened_customer_facing_display', TRUE);
	}

	function add_integrated_giftcard()
	{
		if (!$this->Employee->has_module_action_permission('giftcards', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {
			redirect('no_access/' . $this->module_id);
		}

		$giftcard_data = array(
			'giftcard_number' => $this->input->post('giftcard_number'),
			'value' => $this->input->post('value'),
			'customer_id' => $this->cart->customer_id ? $this->cart->customer_id : NULL,
			'integrated_gift_card' => 1,
			'integrated_auth_code' => $this->input->post('integrated_auth_code') ? $this->input->post('integrated_auth_code') : NULL,
		);

		$this->Giftcard->save($giftcard_data);

		$this->load->model('Item');
		$this->load->model('Category');
		$item_id = $this->Item->create_or_update_integrated_gift_card_item($this->input->post('value'), $this->input->post('giftcard_number'));


		echo json_encode(array('success' => true, 'item_id' => $item_id));
	}

	function do_refill_integrated_giftcard()
	{
		if (!$this->Employee->has_module_action_permission('giftcards', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {
			redirect('no_access/' . $this->module_id);
		}

		$this->Giftcard->add_giftcard_balance($this->input->post('giftcard_number'), $this->input->post('value'));
		$this->load->model('Item');
		$this->load->model('Category');
		$item_id = $this->Item->create_or_update_integrated_gift_card_item($this->input->post('value'), $this->input->post('giftcard_number'));

		echo json_encode(array('success' => true, 'item_id' => $item_id));
	}

	function refill_integrated_giftcard()
	{
		if (!$this->Employee->has_module_action_permission('giftcards', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {
			redirect('no_access/' . $this->module_id);
		}

		$data = array('refill' => TRUE);
		$this->load->view("sales/integrated_giftcard_form", $data);
	}

	function custom_fields()
	{
		$this->lang->load('config');
		$fields_prefs = $this->config->item('sale_custom_field_prefs') ? unserialize($this->config->item('sale_custom_field_prefs')) : array();
		$data = array_merge(array('controller_name' => strtolower(get_class())), $fields_prefs);
		$locations_list = $this->Location->get_all()->result();
		$data['locations'] = $locations_list;
		$this->load->view('custom_fields', $data);
	}

	function save_custom_fields()
	{
		$this->load->model('Appconfig');
		$this->Appconfig->save('sale_custom_field_prefs', serialize($this->input->post()));
	}

	function save_custom_field()
	{
		$k = str_replace(array('custom_field_', '_value'), array('', ''), $this->input->post('name'));
		if ($this->Sale->get_custom_field($k) !== FALSE) {
			if ($this->Sale->get_custom_field($k, 'type') == 'date') {
				$this->cart->{$this->input->post('name')} = (string)strtotime($this->input->post('value'));
			} elseif ($this->Sale->get_custom_field($k, 'type') == 'image') {
				$this->load->library('image_lib');

				$config['image_library'] = 'gd2';
				$config['source_image']	= $_FILES["value"]['tmp_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width']	 = 1200;
				$config['height']	= 900;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->load->model('Appfile');
				$image_file_id = $this->Appfile->save($_FILES['value']['name'], file_get_contents($_FILES["value"]['tmp_name']));
				$this->cart->{$this->input->post('name')} = $image_file_id;
			} elseif ($this->Sale->get_custom_field($k, 'type') == 'file') {
				$this->load->model('Appfile');
				$image_file_id = $this->Appfile->save($_FILES['value']['name'], file_get_contents($_FILES["value"]['tmp_name']));
				$this->cart->{$this->input->post('name')} = $image_file_id;
			} else {
				$this->cart->{$this->input->post('name')} = $this->input->post('value');
			}
		}

		$this->cart->save();
	}

	function save_files_for_speedy()
	{
		$k = str_replace(array('custom_field_', '_value'), array('', ''), $this->input->post('name'));
		if ($this->Sale->get_custom_field($k) !== FALSE) {
			if ($this->Sale->get_custom_field($k, 'type') == 'image') {

				$this->load->library('image_lib');
				$config['image_library'] = 'gd2';
				$config['source_image']	= $_FILES["value"]['tmp_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width']	 = 1200;
				$config['height']	= 900;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->load->model('Appfile');
				$image_file_id = $this->Appfile->save($_FILES['value']['name'], file_get_contents($_FILES["value"]['tmp_name']));
				echo  $image_file_id;
			} else {
				$this->load->model('Appfile');
				$image_file_id = $this->Appfile->save($_FILES['value']['name'], file_get_contents($_FILES["value"]['tmp_name']));
				echo  $image_file_id;
			}
		}
		echo '';
	}

	function set_internal_notes()
	{
		$person_data = array();
		$customer_data = array('internal_notes' => $this->input->post('value'));
		$this->load->model('Customer');
		$this->Customer->save_customer($person_data, $customer_data, $this->cart->customer_id);
	}

	function edit_subtotal()
	{
		$new_subtotal = $this->input->post('value');
		$this->cart->edit_subtotal($new_subtotal);
		$this->cart->save();
		$this->sales_reload(array());
	}
	function get_attribute_values()
	{
		/*
		** Destroy Session if already Exits 
		** Fetch Variations for Edit 
		** Use function in sales/register.php
		*/
		$this->session->unset_userdata('editable_popup');
		/* 
		** Requst Cart Line Number 
		** Fetch Result against Line Number
		*/
		$attr_id 				= 	(int) $_REQUEST["attr_id"];
		$variation 				= 	$this->cart->get_item($attr_id);
		$variation 				= 	$variation->variation_choices_model;
		/* 
		** Create Variations Array, Post Line Number in Session
		*/
		$editable_popup 		= 	$this->session->set_userdata('editable_popup', $attr_id);
		$attributes_available   = 	array();
		$attributes_final_array = 	array();
		foreach ($variation as $variation_id => $single_variation) {
			$variation_temp = array();
			$variation_temp = explode(", ", trim($single_variation));
			foreach ($variation_temp as $single_temp) {
				$attributes_available[$variation_id][] = explode(": ", trim($single_temp))[1];
			}
		}
		/*
		** Variations Loop for Child
		*/
		foreach ($attributes_available as $key => $attibute) {
			$total_index = count($attibute);

			switch ($total_index):
				case 1:
					$attributes_final_array[$attibute[0]][$key] = NULL;
					break;
				case 2:
					$attributes_final_array[$attibute[0]][$attibute[1]][$key] = NULL;
					break;
				case 3:
					@$attributes_final_array[$attibute[0]][$attibute[1]][$attibute[2]][$key] = NULL;
					break;
				case 4:
					@$attributes_final_array[$attibute[0]][$attibute[1]][$attibute[2]][$attibute[3]][$key] = NULL;
					break;
				case 5:
					@$attributes_final_array[$attibute[0]][$attibute[1]][$attibute[2]][$attibute[3]][$attibute[4]][$key] = NULL;
					break;
				case 6:
					@$attributes_final_array[$attibute[0]][$attibute[1]][$attibute[2]][$attibute[3]][$attibute[4]][$attibute[5]][$key] = NULL;
					break;
				case 7:
					@$attributes_final_array[$attibute[0]][$attibute[1]][$attibute[2]][$attibute[3]][$attibute[4]][$attibute[5]][$attibute[6]][$key] = NULL;
					break;
			endswitch;
		}

		/*
		** Show Variations for Edit in Model
		*/
		foreach ($attributes_final_array as $key => $variation) {
			echo "<a href='javascript:fetch_attr_values(" . htmlspecialchars(json_encode(trim($key)), ENT_QUOTES) . ");' class='btn btn-primary popup_button' style='margin:5px;' id='attri_" . htmlspecialchars(trim($key)) . "'>" . trim($key) . "</a>";
		}

		$this->session->set_userdata('show_model', $attributes_final_array);
		return;
	}

	function get_attributes_values()
	{
		// echo $_REQUEST["attr_id"];
		// exit();
		$current_location = $this->Employee->get_logged_in_employee_current_location_id();

		$attr_id 		= 	$_GET["attr_id"];
		$check_attr 	= 	explode(",", $attr_id);
		$count 			=  	count($check_attr);
		$get_data 		= 	$this->session->userdata('popup');
		$is_service 	= 	$this->session->userdata('is_service');
		switch ($count):
			case 1:
				$get_data 	= 	$get_data[$check_attr[0]];
				$link  		= 	$check_attr[0];
				break;
			case 2:
				$get_data 	= 	$get_data[$check_attr[0]][$check_attr[1]];
				$link  		= 	$check_attr[0] . ',' . $check_attr[1];
				break;
			case 3:
				$get_data 	= 	$get_data[$check_attr[0]][$check_attr[1]][$check_attr[2]];
				$link  		= 	$check_attr[0] . ',' . $check_attr[1] . ',' . $check_attr[2];
				break;
			case 4:
				$get_data 	= 	$get_data[$check_attr[0]][$check_attr[1]][$check_attr[2]][$check_attr[3]];
				$link  		= 	$check_attr[0] . ',' . $check_attr[1] . ',' . $check_attr[2] . ',' . $check_attr[3];
				break;
			case 5:
				@$get_data 	= 	$get_data[$check_attr[0]][$check_attr[1]][$check_attr[2]][$check_attr[3]][$check_attr[4]];
				@$link  	= 	$check_attr[0] . ',' . $check_attr[1] . ',' . $check_attr[2] . ',' . $check_attr[3] . ',' . $check_attr[4];
				break;
			case 6:
				@$get_data 	= 	$get_data[$check_attr[0]][$check_attr[1]][$check_attr[2]][$check_attr[3]][$check_attr[4]][$check_attr[5]];
				@$link  	= 	$check_attr[0] . ',' . $check_attr[1] . ',' . $check_attr[3] . ',' . $check_attr[4] . ',' . $check_attr[5];
				break;
			case 7:
				@$get_data 	= 	$get_data[$check_attr[0]][$check_attr[1]][$check_attr[2]][$check_attr[3]][$check_attr[4]][$check_attr[5]][$check_attr[6]];
				@$link  	= 	$check_attr[0] . ',' . $check_attr[1] . ',' . $check_attr[3] . ',' . $check_attr[4] . ',' . $check_attr[5] . ',' . $check_attr[6];
				break;
			case 8:
				@$get_data 	= 	$get_data[$check_attr[0]][$check_attr[1]][$check_attr[2]][$check_attr[3]][$check_attr[4]][$check_attr[5]][$check_attr[6]][$check_attr[7]];
				@$link  	= 	$check_attr[0] . ',' . $check_attr[1] . ',' . $check_attr[3] . ',' . $check_attr[4] . ',' . $check_attr[5] . ',' . $check_attr[6] . ',' . $check_attr[7];
				break;
		endswitch;

		foreach ($get_data as $index => $attribute) {
			/* 
				** SAVE Variation 
				*/
			if (is_numeric($index) and empty($attribute)) {
				$line_no   = $this->cart->get_items();

				if ($this->session->userdata('editable_popup') !== NULL) {
					$line_no 	= $this->session->userdata('editable_popup');
					$this->session->unset_userdata('editable_popup');
				} else {
					$line_no 	= count($line_no) - 1;
				}
				$variation_qty = 0;
				$this->db->from('location_item_variations');
				$this->db->where('item_variation_id', $index);
				$this->db->where('location_id', $current_location);
				$query = $this->db->get();

				$variation_tbl = $query->row();
				if ($variation_tbl)
					$variation_qty = $variation_tbl->quantity;
				else
					$variation_qty = 0;

				if ($this->config->item('do_not_allow_out_of_stock_items_to_be_sold') && $variation_qty <= 0 && $is_service == 0) {
					self::delete_item($line_no);
					echo '<script>show_feedback("error","' . lang('sales_unable_to_add_item_out_of_stock') . '");</script>';
				} else {
					$_POST["name"] 	= "variation";
					$_POST["value"] = $index;
					self::edit_item_variation($line_no);
				}
				echo '<script>
						
						$("#choose_var").modal("hide");
						setTimeout(function()
						{
 							jQuery("#register_container").load("' . site_url('sales/reload') . '");
						},200);
						</script>';
				die;
			} else {
				echo "<a href='javascript:fetch_attr_value(" . htmlspecialchars(json_encode(trim($link . "," . $index)), ENT_QUOTES) . ");' class='btn btn-success popup_button' style='margin:5px;' id='attri_" . htmlspecialchars(trim($index), ENT_QUOTES) . "'>" . trim($index) . "</a>";
			}
		}
	}

	function delete_custom_field_value($k)
	{
		$this->cart->{"custom_field_${k}_value"} = NULL;
		$this->cart->save();
	}

	function enter_tips()
	{
		$this->load->view('sales/enter_tips');
	}

	function save_tip($sale_id)
	{
		$can_save_tip = TRUE;

		$tip_amount = $this->input->post('tip');
		if ($this->Sale->can_cc_tip_sale($sale_id)) {

			$credit_card_processor = $this->_get_cc_processor();
			if ($credit_card_processor && ($result = $credit_card_processor->tip($sale_id, $tip_amount)) !== TRUE) {
				$can_save_tip = FALSE;
			}
		}

		if ($can_save_tip) {
			$sale_data = array('tip' => $tip_amount);
			if (!$this->Sale->update($sale_data, $sale_id)) {
				echo $result;
				$this->output->set_status_header(400);
			}
		} else {
			echo $result;
			$this->output->set_status_header(400);
		}
	}


	function download($file_id)
	{
		//Don't allow images to cause hangups with session
		session_write_close();
		$this->load->model('Appfile');
		$file = $this->Appfile->get($file_id);
		$this->load->helper('file');
		$this->load->helper('download');
		force_download($file->file_name, $file->file_data);
	}

	function customers_offline_data($limit = 100, $offset = 0)
	{
		session_write_close();
		$this->load->helper('array');
		$customers = $this->Customer->get_all('', 0, $limit, $offset);

		$return = array();
		while ($customer = $customers->unbuffered_row('array')) {
			$return[] = array(
				'first_name' => $customer['first_name'],
				'last_name' => $customer['last_name'],
				'account_number' => $customer['account_number'],
				'phone_number' => $customer['phone_number'],
				'email' => $customer['email'],
				'balance' => $customer['balance'],
				'person_id' => $customer['person_id'],
				'internal_notes' => $customer['internal_notes'],
			);
		}

		echo json_encode($return);
	}

	function categories_offline_data($limit = 100, $offset = 0)
	{

		session_write_close();
		$this->load->helper('array');
		$categories = $this->category->get_all('', 0, $limit, $offset);



		$topcateg = array(
			'items_count' => 0,
			'categories_count' => 0,
			'id' => 'top',
			'name' => lang('top_items'),
			'color' => '',
			'image_id' => 0,
			'image_timestamp' => ''
		);

		$return = array();
		foreach ($categories as $index => $category) {


			$return[] = $this->format_category($category, $index);
		}
		// $return[] = $this->format_category($topcateg, 'top');
		echo json_encode($return);
	}
	function taxes_offline_data($limit = 100, $offset = 0)
	{

		session_write_close();
		$this->load->helper('array');
		$taxes = $this->Tax_class->get_all()->result_array();
		$return = array();

		foreach ($taxes as $index => $tax) {
			$return[] = $this->format_taxes($tax, $tax['id']);
		}

		echo json_encode($return);
	}

	function format_taxes($category, $category_id)
	{


		$formatted_category = array(
			'is_default' => $this->config->item('tax_class_id') == $category_id ? 1 : 0,
			'name' => $category['name'],
			'id' => $category_id,
			'group' => $this->Tax_class->get_taxes($category_id)
		);

		return $formatted_category;
	}
	function format_category($category, $category_id)
	{
		$img_src = "";
		if ($category['image_id'] != 'no_image' && $category['image_id'] && trim($category['image_id']) != '') {
			$img_src = cacheable_app_file_url($category['image_id'], false);
		}

		// Initialize 'sub_categories' as an empty array instead of a count
		$sub_categories = $this->Category->get_all($category_id);
		$sub_categories_formatted = [];
		foreach ($sub_categories as $sub_index => $sub_category) {
			$sub_categories_formatted[] = $this->format_category($sub_category, $sub_index);
		}

		$items_count = $this->Item->count_all_by_category($category_id);

		$formatted_category = array(
			'name' => $category['name'],
			'id' => $category_id,
			'img_src' => $img_src,
			'sub_categories' => $sub_categories_formatted,  // Use the formatted subcategories array
			'items_count' => $items_count,
			'sub_categories_count' => count($sub_categories_formatted),
		);

		return $formatted_category;
	}

	function items_offline_data($limit = 100, $offset = 0)
	{
		session_write_close();
		$this->load->helper('array');
		$this->load->model('Item_modifier');
		$this->load->model('Item_variations');



		$items_result = $this->Item->get_all_offline($limit, $offset)->result();

		$items_result_top = $this->Item->get_all_by_category('top', $this->config->item('hide_out_of_stock_grid') ? TRUE : FALSE)->result();

		$top_item_ids = array_column($items_result_top, 'item_id');


		$return = array();
		$can_override_price_adjustments = $this->Employee->get_logged_in_employee_info()->override_price_adjustments;
		$max_discount_employee = $this->Employee->get_logged_in_employee_info()->max_discount_percent;
		$max_discount_config = $this->config->item('max_discount_percent') !== '' ? $this->config->item('max_discount_percent') : NULL;


		foreach ($items_result as $line => $item) {

			$img_src = "";
			if ($item->image_id != 'no_image' && $item->image_id && trim($item->image_id) != '') {
				$img_src = cacheable_app_file_url($item->image_id);
			}

			$size = $item->size ? ' - ' . $item->size : '';

			if (strpos($item->item_id, 'KIT') === 0) {
				$price_to_use = $this->Item_kit->get_sale_price(array('item_kit_id' => str_replace('KIT', '', $item->item_id)));
			} else {
				$price_to_use = $this->Item->get_sale_price(array('item_id' => $item->item_id));
			}



			$item_taxes = $this->Item_taxes->get_info($item->item_id);
			$tax = array();
			if (!empty($item_taxes)) {
				$tax = $item_taxes[0]['percent'];
			}
			$item_info = $this->item->get_info($item->item_id);
			$allow_price_override_regardless_of_permissions =  $item_info->allow_price_override_regardless_of_permissions ? 1 : 0;

			$max_discount = $item_info->max_discount_percent;
			//Try employee
			if (!$can_override_price_adjustments && $max_discount === NULL) {
				$max_discount = $max_discount_employee;
			}

			//Try globally
			if (!$can_override_price_adjustments && $max_discount === NULL) {
				$max_discount = $max_discount_config;
			}

			$variatons = 	$this->item_variations($item->item_id, true);

			$this->load->model('Item_attribute');
			$item_attributes_available = $this->Item_attribute->get_attributes_for_item_with_attribute_values_updated($item->item_id);

			$mods_for_item = $this->Item_modifier->get_modifiers_for_item_id($item->item_id)->result_array();

			if ($mods_for_item) {
				foreach ($mods_for_item as $modifier_item_id => $modifier_item) {

					// dd($modifier_item);
					$Item_modifier  = $this->Item_modifier->get_modifier_item_info($modifier_item['id']);
					// dd($Item_modifier);
					$mods_for_item[$modifier_item_id]['modifier_item_id'] = $modifier_item['id'];
					$mods_for_item[$modifier_item_id]['unit_price'] =  $Item_modifier['unit_price'];
					$mods_for_item[$modifier_item_id]['cost_price'] =  $Item_modifier['cost_price'];
					$mods_for_item[$modifier_item_id]['unit_price_currency'] =  to_currency($Item_modifier['unit_price']);
					$mods_for_item[$modifier_item_id]['modifier_item_name'] =   $Item_modifier['modifier_item_name'];
				}
			}
			$item_id = $item->item_id;


			$quantity_units = $this->Item->get_quantity_units($item_id, true);
			$quantity_units_res = array();
			$quantity_units_info = array();
			if (!empty($quantity_units)) {
				$quantity_units_res[0]['value'] = "0";
				$quantity_units_res[0]['text'] = lang('None');
				foreach ($quantity_units as $key => $value) {
					$quantity_units_res[$value['id']]['value'] = $value['id'];
					$quantity_units_res[$value['id']]['text'] = $value['unit_name'];
					$quantity_units_info[$value['id']] = (array) $this->Item->get_quantity_unit_info($value['id']);
				}
				// dd($quantity_units);
			}
			/// getting items and categories




			$permissions = array(
				'allow_price_override_regardless_of_permissions' => $allow_price_override_regardless_of_permissions,
				'always_use_average_cost_method' => $this->config->item('always_use_average_cost_method'),
				'hide_supplier_on_sales_interface' => $this->config->item('hide_supplier_on_sales_interface'),
				'disable_supplier_selection_on_sales_interface' => $this->config->item('disable_supplier_selection_on_sales_interface'),
				'hide_description_on_sales_and_recv' => $this->config->item('hide_description_on_sales_and_recv'),
				'allow_alt_description' => $item_info->allow_alt_description,
				'change_cost_price' =>  $item_info->change_cost_price,
				'edit_serail_no' =>  	$this->Employee->has_module_action_permission('sales', 'edit_serail_no', $this->Employee->get_logged_in_employee_info()->person_id),
				'require_to_add_serial_number_in_pos' => $this->config->item('require_to_add_serial_number_in_pos'),
				'id_to_show_on_sale_interface' =>	$this->config->item('id_to_show_on_sale_interface'),
				'do_not_allow_out_of_stock_items_to_be_sold' =>	$this->config->item('do_not_allow_out_of_stock_items_to_be_sold'),
				'process_returns' => (!$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)),
				'process_returns_error' => lang('sales_not_allowed_returns'),
				'sales_could_not_discount_item_above_max' => lang('sales_could_not_discount_item_above_max'),
				'do_not_allow_below_cost' => $this->config->item('do_not_allow_below_cost'),

			);
			// dd( $quantity_units);
			$source_supplier_data = array();

			$secondary_supplier_details = array();
			foreach ($this->Item->get_all_suppliers_of_an_item($item->item_id)->result_array() as $row) {
				$source_supplier_data[$row['supplier_id']] = array('value' => $row['supplier_id'], 'text' => $row['company_name'] . ' (' . $row['full_name'] . ')');
				$secondary_supplier = $this->Item->get_secondary_supplier_details($item->item_id, $row['supplier_id']);
				if ($secondary_supplier) {
					$secondary_supplier_details[$row['supplier_id']] = (array) $secondary_supplier;
				}
			}
			// $params['item'] = $item;
			// $params['quantity'] = 1;
			$CI = &get_instance();

			$rule = $CI->Price_rule->get_all_rule_for_item($item->item_id);
			// dd($rule);
			$serial_numbers = [];

			$employee_location_id = $this->Employee->get_logged_in_employee_current_location_id();
			if ($item_info->is_serialized) {
				$serial_numbers = $this->Item_serial_number->get_all_data($item_info->item_id, $employee_location_id, $input = array());
			}


			$id_to_show_on_sale_interface_val = '';
			switch ($this->config->item('id_to_show_on_sale_interface')) {
				case 'number':

					if (property_exists($item, 'item_number') && $item->item_number) {
						$id_to_show_on_sale_interface_val =  H($item->item_number);
					} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
						$id_to_show_on_sale_interface_val =  H($item->item_kit_number);
					} else {
						$id_to_show_on_sale_interface_val =  lang('none');
					}

					break;

				case 'product_id':
					$id_to_show_on_sale_interface_val =  property_exists($item, 'product_id') ? H($item->product_id) : lang('none');
					break;

				case 'id':
					$id_to_show_on_sale_interface_val =  property_exists($item, 'item_id') ? H($item->item_id) : 'KIT ' . H($item->item_kit_id);
					break;

				default:
					if (property_exists($item, 'item_number') && $item->item_number) {
						$id_to_show_on_sale_interface_val =  H($item->item_number);
					} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
						$id_to_show_on_sale_interface_val =  H($item->item_kit_number);
					} else {
						$id_to_show_on_sale_interface_val =  lang('none');
					}
					break;
			}

			$cur_quantity = 0;
			$item_variation_location_info = [];
			$item_location_info = [];


			if (isset($item_info->variation_id)) {
				$item_location_quantity = $CI->Item_variation_location->get_location_quantity($item_info->variation_id);

				$cur_quantity = (int) $item_location_quantity;
			} else {
				$item_location_info = $this->Item_location->get_info($item_info->item_id, $employee_location_id, false, 0);
				$item_location_quantity = (int) $this->Item_location->get_location_quantity($item_info->item_id);
				$cur_quantity = (int) $item_location_quantity;
			}


			$item_location_info  = (array) $item_location_info;
			$item_tier_row = [];
			$item_location_tier_row = [];
			$all_tier_info = [];
			foreach ($this->Tier->get_all()->result() as $key  => $tier) {
				$all_tier_info[$tier->id] = (array) $tier;
				$item_tier_row[$tier->id] = (array) $this->Item->get_tier_price_row($tier->id, $item_info->item_id);
				$item_location_tier_row[$tier->id] = (array)  $this->Item_location->get_tier_price_row($tier->id, $item_info->item_id, $employee_location_id);
			}

			if (count($variatons) > 0) {
				foreach ($variatons as $key => $var) {
					$variatons[$key]['item_variation_location_info'] = (array) $this->Item_variation_location->get_info(explode('#', $var['id'])[1], $employee_location_id, true, 0);
				}
			}



			// echo $item->item_id . "<br>";



			$return[] = array(
				'is_top_item' => in_array($item->item_id, $top_item_ids) ? 1 : 0,
				'permissions' => $permissions,
				'source_supplier_data' => $source_supplier_data,
				'secondary_supplier_details' => $secondary_supplier_details,
				'can_override_price_adjustments' => $can_override_price_adjustments,
				'id' => $item->item_id,
				'rules' => $rule,
				'item_location_info' => $item_location_info,
				'item_tier_row' => $item_tier_row,
				'item_location_tier_row' => $item_location_tier_row,
				'all_tier_info' => $all_tier_info,
				'max_discount' => $max_discount,
				'name' => character_limiter($item->name, 30) . $size,
				'item_taxes' => $item_taxes,
				'taxes' =>  $tax,
				"is_serialized" => $item_info->is_serialized,
				"serial_numbers" => $serial_numbers,
				'tax_percent' => $tax,
				'is_recurring' => $item_info->is_recurring,
				'tax_included' => $item->tax_included,
				'override_default_tax' => $item->override_default_tax,
				'image_src' => 	$img_src,
				'category_name' => 	$this->Category->get_full_path($item_info->category_id),
				'category_id' => 	$item_info->category_id,
				'description' => 	clean_html($item_info->description),
				'has_variations' => count($variatons) > 0 ? $variatons : FALSE,
				'item_attributes_available' => $item_attributes_available,
				'type' => 'item',
				'quantity_units' => $quantity_units_res,
				'quantity_units_info' => $quantity_units_info,
				'modifiers'	=> $mods_for_item,
				"cost_price" => $item_info->cost_price,
				'price' => $price_to_use != '0.00' ? to_currency($price_to_use) : FALSE,
				'regular_price' => $item->unit_price,
				'different_price' => $price_to_use != $item->unit_price,
				'id_to_show_on_sale_interface_val' => $id_to_show_on_sale_interface_val,
				'cur_quantity' => to_quantity($cur_quantity),
				'is_series_package' => $item_info->is_series_package,
				'series_quantity' => $item_info->series_quantity,
				'series_days_to_use_within' => $item_info->series_days_to_use_within,
				'item_location_quantity' => $item_location_quantity,
				'is_service' => $item_info->is_service,
				'max_edit_price' => $item_info->max_edit_price,
				'min_edit_price' => $item_info->min_edit_price,
				'currency' =>  get_store_currency(),
				'item_number' => $item_info->item_number,
				'product_id' => $item_info->product_id,
				'additional_item_numbers' => $CI->Additional_item_numbers->get_item_numbers($item->item_id)->result_array()
			);
		}

		echo json_encode(H($return));
	}


	function set_details_collapsed()
	{
		if ($this->input->post('value')) {
			$this->cart->details_collapsed = TRUE;
		} else {
			$this->cart->details_collapsed = FALSE;
		}

		$this->cart->save();
	}

	function save_modifiers($line)
	{
		$item = $this->cart->get_item($line);

		$modifiers = $this->input->post('modifiers') ? $this->input->post('modifiers') : array();
		$item->modifier_items = array();
		foreach ($modifiers as $modifier_item_id) {
			$modifier_item_info = $this->Item_modifier->get_modifier_item_info($modifier_item_id);
			$display_name = to_currency($modifier_item_info['unit_price']) . ': ' . $modifier_item_info['modifier_name'] . ' > ' . $modifier_item_info['modifier_item_name'];
			$item->modifier_items[$modifier_item_id] = array('display_name' => $display_name, 'unit_price' => $modifier_item_info['unit_price'], 'cost_price' => $modifier_item_info['cost_price']);
		}

		$this->cart->save();
		$data = array();
		$this->sales_reload($data);
	}

	function get_modifiers()
	{
		$line = $this->input->get('line');
		$item = $this->cart->get_item($line);

		echo '<div class="container"><form action="' . site_url('sales/save_modifiers/' . $line) . '" id="modifier_form" method="POST">';
		foreach ($this->Item_modifier->get_modifiers_for_item($item)->result_array() as $modifier) {
			foreach ($this->Item_modifier->get_modifier_items($modifier['id'])->result_array() as $modifier_item) {
				echo '<div class="row">';
				echo form_label($modifier['name'] . ' > ' . $modifier_item['name'] . ': ' . to_currency($modifier_item['unit_price']), '', array('class' => 'col-sm-4 col-md-4 col-lg-4 control-label wide'));
				echo form_checkbox(array(
					'name' => 'modifiers[]',
					'id' => 'modifier_' . $modifier_item['id'],
					'class' => 'modifier',
					'value' => $modifier_item['id'],
					'checked' => $this->cart->get_item($line)->has_modifier_item($modifier_item['id'])
				));
				echo '<label for="modifier_' . $modifier_item['id'] . '"><span></span></label></div>';
			}
		}

		echo '<input type="submit" class="btn btn-primary" /></form><script>$("#modifier_form").ajaxForm({target: "#register_container", beforeSubmit: function(){jQuery("#choose_modifiers").modal("hide");}, success: itemScannedSuccess});</script>';
	}

	function receipts()
	{
		session_write_close();
		$date = $this->input->get('date');
		$location_id = $this->input->get('location_id');
		$sale_type = $this->input->get('sale_type');

		$this->load->view('sales/receipt_date_selector');

		foreach ($this->Sale->get_sale_ids_for_date($date, $location_id, $sale_type) as $sale_id) {
			$receipt_cart = PHPPOSCartSale::get_instance_from_sale_id($sale_id);
			if ($this->config->item('sort_receipt_column')) {
				$receipt_cart->sort_items($this->config->item('sort_receipt_column'));
			}

			$data = $this->_get_shared_data();

			$data = array_merge($data, $receipt_cart->to_array());
			$data['is_sale'] = FALSE;
			$sale_info = $this->Sale->get_info($sale_id)->row_array();
			$data['is_sale_cash_payment'] = $this->cart->has_cash_payment();
			$data['show_payment_times'] = TRUE;
			$data['signature_file_id'] = $sale_info['signature_image_id'];

			$tier_id = $sale_info['tier_id'];
			$tier_info = $this->Tier->get_info($tier_id);
			$data['tier'] = $tier_info->name;
			$data['register_name'] = $this->Register->get_register_name($sale_info['register_id']);
			$data['override_location_id'] = $sale_info['location_id'];
			$data['deleted'] = $sale_info['deleted'];

			$data['receipt_title'] = $this->config->item('override_receipt_title') ? $this->config->item('override_receipt_title') : (!$receipt_cart->suspended ? lang('sales_receipt') : '');
			$data['sales_card_statement'] = $this->config->item('override_signature_text') ? $this->config->item('override_signature_text') : lang('sales_card_statement', '', array(), TRUE);

			$data['transaction_time'] = date(get_date_format() . ' ' . get_time_format(), strtotime($sale_info['sale_time']));
			$customer_id = $this->cart->customer_id;

			$emp_info = $this->Employee->get_info($sale_info['employee_id']);
			$sold_by_employee_id = $sale_info['sold_by_employee_id'];
			$sale_emp_info = $this->Employee->get_info($sold_by_employee_id);
			$data['payment_type'] = $sale_info['payment_type'];
			$data['amount_change'] = $receipt_cart->get_amount_due() * -1;
			$data['employee'] = $emp_info->first_name . ' ' . $emp_info->last_name . ($sold_by_employee_id && $sold_by_employee_id != $sale_info['employee_id'] ? '/' . $sale_emp_info->first_name . ' ' . $sale_emp_info->last_name : '');
			$data['ref_no'] = $sale_info['cc_ref_no'];
			$data['auth_code'] = $sale_info['auth_code'];
			$data['discount_exists'] = $this->_does_discount_exists($data['cart_items']);
			$data['disable_loyalty'] = 0;
			$data['sale_id'] = $this->config->item('sale_prefix') . ' ' . $sale_id;
			$data['sale_id_raw'] = $sale_id;
			$data['store_account_payment'] = FALSE;
			$data['is_purchase_points'] = FALSE;

			foreach ($data['cart_items'] as $item) {
				if ($item->name == lang('store_account_payment')) {
					$data['store_account_payment'] = TRUE;
					break;
				}
			}

			foreach ($data['cart_items'] as $item) {
				if ($item->name == lang('purchase_points')) {
					$data['is_purchase_points'] = TRUE;
					break;
				}
			}

			if ($sale_info['suspended'] > 0) {
				if ($sale_info['suspended'] == 1) {
					$data['sale_type'] = ($this->config->item('user_configured_layaway_name') ? $this->config->item('user_configured_layaway_name') : lang('layaway'));
				} elseif ($sale_info['suspended'] == 2) {
					$data['sale_type'] = ($this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate'));
				} else {
					$this->load->model('Sale_types');
					$data['sale_type'] = $this->Sale_types->get_info($sale_info['suspended'])->name;
				}
			}

			$exchange_rate = $receipt_cart->get_exchange_rate() ? $receipt_cart->get_exchange_rate() : 1;

			if ($receipt_cart->get_has_delivery()) {
				$data['delivery_person_info'] = $receipt_cart->get_delivery_person_info();

				$data['delivery_info'] = $receipt_cart->get_delivery_info();
			}

			$data['standalone'] = TRUE;
			$this->load->view('sales/receipt', $data);
		}
	}

	function sync_offline_sales()
	{

		$get_preview =false;
		if(isset($_POST['preview'])  && $_POST['preview'] == 'true') {
			$get_preview =true;
		}


		$sales = json_decode($this->input->post('offline_sales'), TRUE);

		foreach ($sales as $offline_sale) {


			$offline_sale_cart = new PHPPOSCartSale();



			$line = 0;
			if (isset($offline_sale['extra']['sale_id']) && $offline_sale['extra']['sale_id']) {
				$offline_sale_cart->sale_id = $offline_sale['extra']['sale_id'];
			}
			if (isset($offline_sale['extra']['is_work_order']) && $offline_sale['extra']['is_work_order']) {
				$offline_sale_cart->is_work_order = 1;
			}
			$offline_sale_cart->location_id = $this->Employee->get_logged_in_employee_current_location_id();;
			date_default_timezone_set($this->Location->get_info_for_key('timezone', $offline_sale_cart->location_id));

			$offline_sale_cart->register_id = $this->Employee->get_logged_in_employee_current_register_id();

			if (!$offline_sale_cart->register_id) {
				$offline_sale_cart->register_id = $this->Employee->getDefaultRegister($this->Employee->get_logged_in_employee_info()->person_id, $this->Employee->get_logged_in_employee_current_location_id());
			}
			$offline_sale_cart->employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

			if (isset($offline_sale['customer']['person_id']) && $offline_sale['customer']['person_id']) {

				if ($this->config->item('enable_customer_quick_add') && strpos($offline_sale['customer']['person_id'], 'QUICK_ADD|') !== FALSE) {
					$offline_sale['customer']['person_id'] = str_replace('QUICK_ADD|', '', $offline_sale['customer']['person_id']);
					$offline_sale['customer']['person_id'] = str_replace('|FORCE_PERSON_ID|', '', $offline_sale['customer']['person_id']);
					$this->load->helper('text');
					list($first_name, $last_name) = split_name($offline_sale['customer']['person_id']);
					$person_data = array('first_name' => $first_name, 'last_name' => $last_name);
					$customer_data = array();
					$customer_data['internal_notes'] = (isset($offline_sale['customer']['internal_notes'])) ? $offline_sale['customer']['internal_notes'] : '';
					$this->Customer->save_customer($person_data, $customer_data);
					$offline_sale['customer']['person_id'] =  $person_data['person_id'];
					$offline_sale_cart->customer_id = $offline_sale['customer']['person_id'];
				} else {

					$offline_sale_cart->customer_id = $offline_sale['customer']['person_id'];
					$customer_data['internal_notes'] = (isset($offline_sale['customer']['internal_notes'])) ? $offline_sale['customer']['internal_notes'] : '';
					$person_data = array();
					$this->Customer->save_customer($person_data, $customer_data, $offline_sale['customer']['person_id']);
				}


				if (isset($offline_sale['customer']['paid_store_account_sale_ids']) && $offline_sale['customer']['paid_store_account_sale_ids']) {
					foreach ($offline_sale['customer']['paid_store_account_sale_ids'] as $store_account_id) {
						$offline_sale_cart->add_paid_store_account_payment_id($store_account_id['sale_id'], $store_account_id['amount']);
					}



					$comment = lang('sales_pays_sales') . ' - ' . implode(', ', array_keys($offline_sale_cart->get_paid_store_account_ids()));

					$offline_sale_cart->comment = $comment;
				}
			}
			// dd($offline_sale['payments']);
			if (isset($offline_sale['payments'])) {
				foreach ($offline_sale['payments'] as $payment) {
					$offline_sale_cart->add_payment(new PHPPOSCartPaymentSale(array(
						'payment_type' => (isset($payment['type'])) ? $payment['type'] : $payment['payment_type'],
						'payment_amount' => $payment['amount'],
						'payment_date' => date('Y-m-d H:i:s'),
					)));
				}
			}
			if (isset($offline_sale['extra']['discount_all_flat']) && $offline_sale['extra']['discount_all_flat']) {
				$line = 1;
				$value = $offline_sale['extra']['discount_all_flat'];
				$item_id = $this->Item->create_or_update_flat_discount_item($offline_sale_cart->is_tax_inclusive() ? 1 : 0);
				$description =  strpos($value, '%', 0) ? lang('sales_discount_percent') . ': ' . $value : '';
				$discount_amount = strpos($value, '%', 0) !== FALSE ? (($offline_sale_cart->get_subtotal() + $offline_sale_cart->get_discount_all_fixed()) * (float)$value / 100) : (float)$value;
				$discount_item = new PHPPOSCartItemSale(array('cart' => $offline_sale_cart, 'scan' => $item_id . '|FORCE_ITEM_ID|', 'cost_price' => 0, 'unit_price' => to_currency_no_money($discount_amount), 'description' => $description, 'quantity' => -1));
				$offline_sale_cart->add_item($discount_item);
			}
			if (isset($offline_sale['extra']['tire_id']) && (int) $offline_sale['extra']['tire_id']  != 0) {
				$offline_sale_cart->selected_tier_id = $offline_sale['extra']['tire_id'];
			}


			if (isset($offline_sale['extra']['sold_by_employee_id']) && (int) $offline_sale['extra']['sold_by_employee_id']  != 0) {
				$offline_sale_cart->sold_by_employee_id = $offline_sale['extra']['sold_by_employee_id'];
			}
			if (isset($offline_sale['extra']['create_invoice']) && (int) $offline_sale['extra']['create_invoice']  != 0) {
				$offline_sale_cart->create_invoice = $offline_sale['extra']['create_invoice'];
			}
			if ($this->config->item('default_sales_person') != 'not_set' && !$offline_sale_cart->sold_by_employee_id) {
				$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
				$offline_sale_cart->sold_by_employee_id = $employee_id;
			}


			if (isset($offline_sale['custom_fields']['change_cart_date']) && $offline_sale['custom_fields']['change_cart_date']) {
				$offline_sale_cart->change_cart_date = $offline_sale['custom_fields']['change_cart_date'];
			}

			if (isset($offline_sale['custom_fields']['prompt_for_card']) && $offline_sale['custom_fields']['prompt_for_card']) {
				$offline_sale_cart->prompt_for_card = $offline_sale['custom_fields']['prompt_for_card'];
			}
			if (isset($offline_sale['custom_fields']['receipt-comment']) && $offline_sale['custom_fields']['receipt-comment']) {
				$offline_sale_cart->comment = $offline_sale['custom_fields']['receipt-comment'];
			}


			for ($k = 1; $k <= NUMBER_OF_PEOPLE_CUSTOM_FIELDS; $k++) {
				// $custom_field = $this->Sale->get_custom_field($k);



				if (isset($offline_sale['custom_fields']["custom_field_" . $k . "_value"]) && $offline_sale['custom_fields']["custom_field_" . $k . "_value"]) {
					$offline_sale_cart->{"custom_field_" . $k . "_value"} = $offline_sale['custom_fields']["custom_field_" . $k . "_value"];
				}
			}


			if (isset($offline_sale['taxes']) && $offline_sale['taxes']) {
				$max = 4;
				$data = array();
				$tax_names = array();
				$tax_percents = array();
				$tax_cumulatives = array(0, 0, 0, 0, 0);
				$override_tax_class = '';

				if (!isset($offline_sale['taxes'][0]['tax_class_id'])) {
					for ($i = 0; $i <= $max; $i++) {
						if (isset($offline_sale['taxes'][$i]['name'])) {
							$tax_names[$i] =	$offline_sale['taxes'][$i]['name'];
							$tax_percents[$i] =	$offline_sale['taxes'][$i]['percent'];
						} else {
							$tax_names[$i] =	'';
							$tax_percents[$i] =	'';
						}
					};
				} else {
					$override_tax_class = $offline_sale['taxes'][0]['tax_class_id'];
				}




				$offline_sale_cart->override_tax_names = $tax_names;
				$offline_sale_cart->override_tax_percents = $tax_percents;
				$offline_sale_cart->override_tax_cumulatives = $tax_cumulatives;
				$offline_sale_cart->override_tax_class = $override_tax_class;
			}
			// dd($offline_sale_cart);
			// dd($offline_sale_cart->get_item(0));
			// remove disocount form it 
			$offline_sale['items'] = array_filter($offline_sale['items'], function ($item) {
				return $item['name'] !== 'discount';
			});


			if (isset($offline_sale['items'])) {



				foreach ($offline_sale['items'] as $key_item => $item) {


					// if((int)$item['item_id']==0){
					// 	continue; /// this is discounted item not actual item
					// }

					if (isset($item['is_repair_item'])  &&  (int)$item['is_repair_item'] == 1) {
					} else {
						if (isset($item['free_item'])  &&  $item['free_item'] == true) {
							continue; /// this is free item not actual item
						}
					}






					// if($this->input->post('tax_class')==''){
					// 	for($i=0; $i<=$max; $i++){
					// 		if(isset($_POST['kt_docs_repeater_basic'][$i]['tax_names'])){
					// 			$tax_names[$i] =	$_POST['kt_docs_repeater_basic'][$i]['tax_names'];
					// 			$tax_percents[$i] =	$_POST['kt_docs_repeater_basic'][$i]['tax_percents'];
					// 		}

					// 	};
					// }	






					if (isset($item['selected_item_modifiers']) && is_array($item['selected_item_modifiers'])) {
						$modifier_items = array();

						foreach ($item['selected_item_modifiers'] as $mi) {
							$display_name = to_currency($mi['unit_price']) . ': ' . $mi['modifier_item_name'];
							$modifier_items[$mi['modifier_item_id']] = array('display_name' => $display_name, 'unit_price' => $mi['unit_price'], 'cost_price' => $mi['cost_price']);
						}

						$item['modifier_items'] = $modifier_items;
					}
					// dd($item['modifier_items']);
					$cur_item_info = $this->Item->get_info($item['item_id']);
					$cur_item_location_info = $this->Item_location->get_info($item['item_id'], $offline_sale_cart->location_id);
					$cur_item_variation_info = $this->Item_variations->get_info(isset($item['variation_id']) ? $item['variation_id'] : -1);

					$item['type'] = 'sale';
					if ($cur_item_variation_info && $cur_item_variation_info->unit_price) {
						$item['regular_price'] = $cur_item_variation_info->unit_price;
					} else {
						$item['regular_price'] = ($cur_item_location_info && $cur_item_location_info->unit_price) ? $cur_item_location_info->unit_price : $cur_item_info->unit_price;
					}

					$cart_item_to_add = array();
					$cart_item_to_add['cart'] = $offline_sale_cart;

					$cart_item_to_add['scan'] = $item['item_id'] . (isset($item['selected_variation']) && $item['selected_variation'] ? '#' . $item['selected_variation'] : '') . '|FORCE_ITEM_ID|';


					$cart_item_to_add['price'] = $item['price'];
					$cart_item_to_add['tier_id'] = (isset($item['tier_id'])) ? $item['tier_id'] : '';
					$cart_item_to_add['quantity_received'] = (isset($item['quantity_received'])) ? $item['quantity_received'] : 0;
					$cart_item_to_add['is_repair_item'] = (isset($item['is_repair_item'])) ? $item['is_repair_item'] : false;
					$cart_item_to_add['tier_name'] = (isset($item['tier_name'])) ? $item['tier_id'] : '';
					$cart_item_to_add['discount'] = (isset($item['discount_percent'])) ? $item['discount_percent'] : 0;
					$cart_item_to_add['description'] = (isset($item['description'])) ? $item['description'] : '';
					$cart_item_to_add['quantity'] = $item['quantity'];
					$cart_item_to_add['modifier_items'] =  array();
					$cart_item_to_add['damaged_qty'] = (isset($item['damaged_qty'])) ? $item['damaged_qty'] : 0;
					if (isset($item['serialnumberText']) &&  $item['serialnumberText'] != '') {
						$cart_item_to_add['serialnumber'] = $item['serialnumberText'];
					}


					if (isset($item['selected_item_modifiers'])) {
						foreach ($item['selected_item_modifiers']  as $key => $mid) {

							$mi = $this->Item_modifier->get_modifier_item_info($key);
							$display_name = to_currency($mid['unit_price']) . ': ' . $mi['modifier_item_name'];

							$cart_item_to_add['modifier_items'][$key] = array('display_name' => $display_name, 'unit_price' => $mid['unit_price'], 'cost_price' => $mid['cost_price']);
						}
					}

					if (strtoupper(substr($item['item_id'], 0, 3)) == 'KIT') {
						$item_to_add = new PHPPOSCartItemKitSale($cart_item_to_add);
					} else {
						$item_to_add = new PHPPOSCartItemSale($cart_item_to_add);
					}


					$resds = $offline_sale_cart->add_item($item_to_add);


					//  dd($offline_sale_cart);
					if (isset($item['taxes']) && is_array($item['taxes'])) {
						// dd($item['taxes']);
						$max = 4;
						$tax_names = array();
						$tax_percents = array();
						$tax_cumulatives = array(0, 0, 0, 0, 0);
						$override_tax_class = '';
						for ($i = 0; $i <= $max; $i++) {
							if (isset($item['taxes'][$i]) && $item['taxes'][$i]['name'] != '') {
								$tax_names[$i] =    $item['taxes'][$i]['name'];
								$tax_percents[$i] =    $item['taxes'][$i]['percent'];
								$tax_cumulatives[$i] =    $item['taxes'][$i]['cumulative'];
							}

							if (isset($item['taxes'][$i]['tax_class_id']) && $item['taxes'][$i]['tax_class_id'] != '') {
								$override_tax_class = $item['taxes'][$i]['tax_class_id'];
							}
						}



						$offline_sale_cart->get_item($line)->override_tax_names = $tax_names;
						$offline_sale_cart->get_item($line)->override_tax_percents = $tax_percents;
						$offline_sale_cart->get_item($line)->override_tax_cumulatives =  $tax_cumulatives;
						$offline_sale_cart->get_item($line)->override_tax_class = $override_tax_class;

						$offline_sale_cart->save();
					}


					if (isset($item['quantity_unit_id']) &&  $item['quantity_unit_id'] != null &&  $item['quantity_unit_id'] != 0  &&  $item['quantity_unit_id'] != '0') {

						$offline_sale_cart->get_item($line)->quantity_unit_quantity = $item['quantity_unit_quantity'];
						$offline_sale_cart->get_item($line)->quantity_unit_id = $item['quantity_unit_id'];
					}

					if (isset($item['supplier_id'])) {
						$offline_sale_cart->get_item($line)->cart_line_supplier_id = $item['supplier_id'];
					}


					if (isset($offline_sale['customer']['person_id']) && $offline_sale['customer']['person_id']) {
						if (isset($item['all_data']['is_series_package']) && $item['all_data']['is_series_package'] == 1) {

							$offline_sale_cart->get_item($line)->is_series_package = 1;
							$offline_sale_cart->get_item($line)->series_quantity = $item['all_data']['series_quantity'];
							$offline_sale_cart->get_item($line)->series_days_to_use_within = $item['all_data']['series_days_to_use_within'];
						}
					}
					$offline_sale_cart->get_item($line)->unit_price = $item['price'];
					$offline_sale_cart->get_item($line)->cost_price = $item['cost_price'];

					$line++;
				}
			}
			if (isset($offline_sale['extra']['redeem']) &&  $offline_sale['extra']['redeem']) {

				$offline_sale_cart->redeem_discount = 1;
			}
			if (isset($offline_sale['extra']['redeem']) &&  $offline_sale['extra']['redeem']) {

				$offline_sale_cart->redeem_discount = 1;
			}
			if ((isset($offline_sale['extra']['sale_id'])) && $offline_sale['extra']['sale_id'] != '') {
				$offline_sale_cart->sale_id = $offline_sale['extra']['sale_id'];
			}
			// if((isset($offline_sale['extra']['suspended'])) && $offline_sale['extra']['suspended'] !=''){
			// 	$offline_sale_cart->suspended = $offline_sale['extra']['suspended']  ; 
			// 	$offline_sale_cart->sale_id = $offline_sale['extra']['suspended']  ; 
			// }

			if ((isset($offline_sale['extra']['mode']))) {
				$offline_sale_cart->set_mode($offline_sale['extra']['mode']);
				if ($offline_sale['extra']['mode'] == 'return') {
					if ((isset($offline_sale['extra']['return_sale_id'])) && $offline_sale['extra']['return_sale_id'] != '') {
						$offline_sale_cart->return_sale_id = $offline_sale['extra']['return_sale_id'];
						$offline_sale_cart->return_order($offline_sale['extra']['return_sale_id']);
					}
				}
			} else {
				$offline_sale_cart->set_mode('sale');
			}






			$sale_id = $this->Sale->save($offline_sale_cart, false);
			if($sale_id != lang('sales_test_mode_transaction')){
				update_data_by_where('phppos_sales', array('sale_json' => json_encode(array($offline_sale))), 'sale_id = ' . $sale_id . ' ');
			}
			
			// dd($sale_id);
			$sale_ids[] = $sale_id;
		}

		$preview ='';


		if($get_preview){

			if($sale_ids[0] != lang('sales_test_mode_transaction')){
				$preview = 	$this->preview_receipt($sale_ids[0], null ,  true);	
			}else{
				$preview = lang('sales_test_mode_transaction' ) . ": ". lang('Test_mode_will_not_have_any_receipt_or_entry' ) ;
			}
			
		}

	


		echo json_encode(array('success' => TRUE, 'sale_ids' => $sale_ids , 'preview' => $preview));
	}

	function view_transaction_history()
	{
		$this->check_action_permission('view_edit_transaction_history');
		$credit_card_processor = $this->_get_cc_processor();

		if (!$credit_card_processor || !method_exists($credit_card_processor, 'get_transaction_history')) {
			$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
			return;
		}

		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$params = [
			'startDate' => date('c', strtotime($start_date ? $start_date : '-2 days')),
			'endDate' => date('c', strtotime($end_date ? $end_date : '+1 day')),
			'maxResults' => 50,
			'startIndex' => 0,
		];

		$all_transactions = array();

		$transactions = $credit_card_processor->get_transaction_history($params);

		if ($transactions['success'] == FALSE) {
			$transactions['transactions'] = array();
			$transactions['totalResultCount'] = 0;
		}

		$all_transactions = array_merge($all_transactions, $transactions['transactions']);
		$total_transactions = $transactions['totalResultCount'];

		$total_pages = ceil($total_transactions / $params['maxResults']);
		for ($startIndex = $params['maxResults']; $startIndex < $params['maxResults'] * $total_pages; $startIndex += $params['maxResults']) {
			$params['startIndex'] = $startIndex;
			$transactions = $credit_card_processor->get_transaction_history($params);
			$all_transactions = array_merge($all_transactions, $transactions['transactions']);
		}

		if (!$this->input->get('transaction_type')) {
			$transaction_types = array('charge', 'refund', 'void');
		} else {
			$transaction_types = $this->input->get('transaction_type');
		}
		$all_transactions = array_filter($all_transactions, function ($transaction) use ($transaction_types) {
			if (in_array($transaction['transactionType'], $transaction_types)) {
				if ($this->input->get('show_declines')) {
					return TRUE;
				} else {
					//Only approved transactions
					return $transaction['approved'];
				}
			}

			return FALSE;
		});

		$all_transaction_ids = array_column($all_transactions, 'transactionId');

		$total_amount = 0;
		foreach ($all_transactions as $transaction) {
			if ($transaction['transactionType'] == 'refund' || $transaction['transactionType'] == 'void') {
				//need to call make_currency_no_money because authorizedAmount has a comma in it and won't add correctly
				$total_amount -= $transaction['approved'] ? make_currency_no_money($transaction['authorizedAmount']) : 0;
			} else {
				//need to call make_currency_no_money because authorizedAmount has a comma in it and won't add correctly
				$total_amount += $transaction['approved'] ? make_currency_no_money($transaction['authorizedAmount']) : 0;
			}
		}

		//This will pre-warm cache so we don't make a ton of database queries
		$this->Sale->get_sale_id_from_payment_ref_no($all_transaction_ids);
		$data = array(
			'start_date' => date(get_date_format(), strtotime($start_date ? $start_date : '-2 days')),
			'end_date' => date(get_date_format(), strtotime($start_date ? $end_date : '+1 day')),
			'transaction_types' => $transaction_types,
			'transactions' => $all_transactions,
			'total_amount' => to_currency($total_amount),
			'length_dropdown' => range($params['maxResults'], $total_pages * $params['maxResults'], 10)
		);


		$this->load->view('sales/blockchyp_transaction_history', $data);
	}

	function excel_export_batch_history($batch_id)
	{
		$params = [
			'batchId' => $batch_id,
			'maxResults' => 50,
			'startIndex' => 0,
		];

		$this->excel_export_history($params, 'pos_batch_history');
	}

	function batches()
	{
		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor) {
			$cc_processor_class_name = strtoupper(get_class($credit_card_processor));
		}

		$is_core_clear_processor =  strpos(strtoupper($this->Location->get_info_for_key('credit_card_processor')), 'CORE') !== false;
		if (!$credit_card_processor || !$is_core_clear_processor) {
			$this->load->view('coreclear/coreclear_info');
			return;
		}

		if ($cc_processor_class_name != 'CORECLEARBLOCKCHYPPROCESSOR') {
			$this->load->view('coreclear/coreclear_transaction_history_not_supported');
			return;
		}

		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$params = [
			'startDate' => date('c', strtotime($start_date ? $start_date : '-10 days')),
			'endDate' => date('c', strtotime($end_date ? $end_date : '+1 day')),
			'maxResults' => 50,
			'startIndex' => 0,
		];

		$all_batches = array();

		$batches = $credit_card_processor->get_batch_history($params);
		$all_batches = array_merge($all_batches, $batches['batches']);
		$total_batches = $batches['totalResultCount'];

		$total_pages = ceil($total_batches / $params['maxResults']);
		for ($startIndex = $params['maxResults']; $startIndex < $params['maxResults'] * $total_pages; $startIndex += $params['maxResults']) {
			$params['startIndex'] = $startIndex;
			$batches = $credit_card_processor->get_batch_history($params);
			$all_batches = array_merge($all_batches, $batches['batches']);
		}

		$data = array(
			'start_date' => date(get_date_format(), strtotime($start_date ? $start_date : '-10 days')),
			'end_date' => date(get_date_format(), strtotime($start_date ? $end_date : '+1 day')),
			'batches' => $all_batches,
			'length_dropdown' => range($params['maxResults'], $total_pages * $params['maxResults'], 10)
		);


		$this->load->view('sales/blockchyp_batch_history', $data);
	}


	function batch_details()
	{
		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor) {
			$cc_processor_class_name = strtoupper(get_class($credit_card_processor));
		}

		$is_core_clear_processor =  strpos(strtoupper($this->Location->get_info_for_key('credit_card_processor')), 'CORE') !== false;
		if (!$credit_card_processor || !$is_core_clear_processor) {
			$this->load->view('coreclear/coreclear_info');
			return;
		}

		if ($cc_processor_class_name != 'CORECLEARBLOCKCHYPPROCESSOR') {
			$this->load->view('sales/coreclear_transaction_history_not_supported');
			return;
		}

		echo json_encode($credit_card_processor->get_batch_details(array('batchId' => $this->input->post('batch_id'))));
	}

	function get_transastions_for_batch()
	{
		$credit_card_processor = $this->_get_cc_processor();

		if ($credit_card_processor) {
			$cc_processor_class_name = strtoupper(get_class($credit_card_processor));
		}

		$is_core_clear_processor =  strpos(strtoupper($this->Location->get_info_for_key('credit_card_processor')), 'CORE') !== false;
		if (!$credit_card_processor || !$is_core_clear_processor) {
			$this->load->view('coreclear/coreclear_info');
			return;
		}

		if ($cc_processor_class_name != 'CORECLEARBLOCKCHYPPROCESSOR') {
			$this->load->view('coreclear/coreclear_transaction_history_not_supported');
			return;
		}

		$batch_id = $this->input->post('batch_id');

		$params = [
			'batchId' => $batch_id,
			'maxResults' => 50,
			'startIndex' => 0,
		];

		$headers = array(
			array('data' => lang('date'), 'align' => 'left'),
			array('data' => lang('id'), 'align' => 'left'),
			array('data' => lang('sale_id'), 'align' => 'left'),
			array('data' => lang('approved'), 'align' => 'left'),
			array('data' => lang('sales_response_description'), 'align' => 'left'),
			array('data' => lang('sales_card_holder'), 'align' => 'left'),
			array('data' => lang('amount'), 'align' => 'left'),
			array('data' => lang('sales_transaction_type'), 'align' => 'left'),
			array('data' => lang('sales_entry_method'), 'align' => 'left'),
			array('data' => lang('payment_type'), 'align' => 'left'),
			array('data' => lang('sales_masked_card'), 'align' => 'left'),
		);


		$all_transactions = array();

		$transactions = $credit_card_processor->get_transaction_history($params);
		$all_transactions = array_merge($all_transactions, $transactions['transactions']);
		$total_transactions = $transactions['totalResultCount'];

		$total_pages = ceil($total_transactions / $params['maxResults']);
		for ($startIndex = $params['maxResults']; $startIndex < $params['maxResults'] * $total_pages; $startIndex += $params['maxResults']) {
			$params['startIndex'] = $startIndex;
			$transactions = $credit_card_processor->get_transaction_history($params);
			$all_transactions = array_merge($all_transactions, $transactions['transactions']);
		}

		$transaction_types = array('charge', 'refund', 'void');

		$all_transactions = array_filter($all_transactions, function ($transaction) use ($transaction_types) {
			if (in_array($transaction['transactionType'], $transaction_types)) {
				if ($this->input->get('show_declines')) {
					return TRUE;
				} else {
					//Only approved transactions
					return $transaction['approved'];
				}
			}

			return FALSE;
		});

		$all_transaction_ids = array_column($all_transactions, 'transactionId');

		//This will pre-warm cache so we don't make a ton of database queries
		$this->Sale->get_sale_id_from_payment_ref_no($all_transaction_ids);

		$details_data = array();

		foreach ($all_transactions as $transaction) {
			$details_data_row = array();
			$details_data_row[] = array('data' => date(get_date_format() . ' ' . get_time_format(), strtotime($transaction['timestamp'])), 'align' => 'left');
			$details_data_row[] = array('data' => $transaction['transactionId'], 'align' => 'left');

			if ($sale_id = $this->Sale->get_sale_id_from_payment_ref_no($transaction['transactionId'])) {
				$details_data_row[] = array('data' => anchor('sales/receipt/' . $sale_id, $this->config->item('sale_prefix') . ' ' . $sale_id, array('target' => '_blank')), 'align' => 'left');
			} else {
				$details_data_row[] = array('data' => lang('unknown'), 'align' => 'left');
			}
			$details_data_row[] = array('data' => $transaction['approved'] ? lang('yes') : lang('no'), 'align' => 'left');
			$details_data_row[] = array('data' => $transaction['responseDescription'], 'align' => 'left');
			$details_data_row[] = array('data' => $transaction['cardHolder'], 'align' => 'left');
			$details_data_row[] = array('data' => to_currency(make_currency_no_money($transaction['authorizedAmount'])), 'align' => 'left');
			$details_data_row[] = array('data' => $transaction['transactionType'], 'align' => 'left');
			$details_data_row[] = array('data' => $transaction['entryMethod'], 'align' => 'left');
			$details_data_row[] = array('data' => isset($transaction['paymentType']) ? $transaction['paymentType'] : "", 'align' => 'left');
			$details_data_row[] = array('data' => $transaction['maskedPan'], 'align' => 'left');

			$details_data[] = $details_data_row;
		}


		$data = array(
			"headers" => $headers,
			"details_data" => $details_data
		);

		echo json_encode($data);
	}


	function void_return_by_transaction_id($transactionId)
	{
		$this->check_action_permission('view_edit_transaction_history');
		$credit_card_processor = $this->_get_cc_processor();

		if (!$credit_card_processor || !method_exists($credit_card_processor, 'void_return_transaction_by_id')) {
			$this->_reload(array('error' => lang('sales_credit_card_processing_is_down')), false);
			return;
		}

		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$amount = $this->input->post('amount');
		if ($response = $credit_card_processor->void_return_transaction_by_id($transactionId, $amount)) {
			$sale_id = $this->input->post('sale_id');
			$this->load->model('Processing_logging');
			$log_data = array(
				'return_time' => date('Y-m-d H:i:s'),
				'employee_id' => $this->Employee->get_logged_in_employee_info()->person_id,
				'orig_voided_processor_transaction_id' => $transactionId,
				'voided_processor_transaction_id' => $response['transactionId'],
				'amount' => $response['authorizedAmount'],
				'sale_id' => $sale_id ? $sale_id : NULL,
			);

			$this->Processing_logging->insert_log($log_data);

			$success = rawurlencode(lang('sales_success_void_transaction') . ' ' . $transactionId);
			redirect("sales/view_transaction_history?success=$success&start_date=$start_date&end_date=$end_date");
		} else {
			$error = rawurlencode(lang('sales_cannot_void_transaction') . ' ' . $transactionId);
			redirect("sales/view_transaction_history?error=$error&start_date=$start_date&end_date=$end_date");
		}
	}

	function excel_export_transaction_history()
	{
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$params = [
			'startDate' => date('c', strtotime($start_date ? $start_date : date('Y-m-d 00:00:00', strtotime('-1 days')))),
			'endDate' => date('c', strtotime($end_date ? $end_date . ' 23:59:59' : date('Y-m-d 23:59:59', strtotime('+1 days')))),
			'maxResults' => 50,
			'startIndex' => 0,
		];

		$this->excel_export_history($params, 'pos_transaction_history');
	}

	function excel_export_history($params, $file_name)
	{
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		ini_set('max_input_time', '-1');

		$this->load->helper('report');

		$credit_card_processor = $this->_get_cc_processor();

		$all_transactions = array();

		$transactions = $credit_card_processor->get_transaction_history($params);
		$all_transactions = array_merge($all_transactions, $transactions['transactions']);
		$total_transactions = $transactions['totalResultCount'];

		$total_pages = ceil($total_transactions / $params['maxResults']);
		for ($startIndex = $params['maxResults']; $startIndex < $params['maxResults'] * $total_pages; $startIndex += $params['maxResults']) {
			$params['startIndex'] = $startIndex;
			$transactions = $credit_card_processor->get_transaction_history($params);
			$all_transactions = array_merge($all_transactions, $transactions['transactions']);
		}

		if (!$this->input->get('transaction_type')) {
			$transaction_types = array('charge', 'refund', 'void');
		} else {
			$transaction_types = $this->input->get('transaction_type');
		}

		$all_transactions = array_filter($all_transactions, function ($transaction) use ($transaction_types) {
			if (in_array($transaction['transactionType'], $transaction_types)) {
				if ($this->input->get('show_declines')) {
					return TRUE;
				} else {
					//Only approved transactions
					return $transaction['approved'];
				}
			}

			return FALSE;
		});

		$rows = array();

		$header_row = $this->_blockchyp_excel_get_header_row();
		$rows[] = $header_row;
		foreach ($all_transactions as $transaction) {
			$sale_id = $this->Sale->get_sale_id_from_payment_ref_no($transaction['transactionId']) ?: lang('unknown');

			$amount = $transaction['approved'] ? $transaction['authorizedAmount'] : $transaction['requestedAmount'];

			if ($transaction['transactionType'] == 'refund' || $transaction['transactionType'] == 'void') {
				$amount = make_currency_no_money($amount);
				$amount *= -1;
			}

			$row = array(
				date(get_date_format() . ' ' . get_time_format(), strtotime($transaction['timestamp'])),
				$transaction['transactionId'],
				$sale_id,
				$transaction['approved'] ? lang('yes') : lang('no'),
				$transaction['responseDescription'],
				$transaction['cardHolder'],
				make_currency_no_money($amount, 2, TRUE) . (!$transaction['approved'] ? '(' . lang('declined') . ')' : ''),
				$transaction['transactionType'],
				$transaction['entryMethod'],
				$transaction['paymentType'],
				$transaction['maskedPan'],
			);

			$rows[] = $row;
		}

		$this->load->helper('spreadsheet');
		array_to_spreadsheet($rows, $file_name . '.' . ($this->config->item('spreadsheet_format') == 'XLSX' ? 'xlsx' : 'csv'), TRUE);
	}

	function _blockchyp_excel_get_header_row()
	{
		return array(lang('date'), lang('id'), lang('sale_id'), lang('approved'), lang('sales_response_description'), lang('sales_card_holder'), lang('amount'), lang('sales_transaction_type'), lang('sales_entry_method'), lang('payment_type'), lang('sales_masked_card'));
	}

	function sort()
	{
		$sort_column_1 = $this->input->post("sort_column");
		$sort_column = "";
		if ($sort_column_1 == 'price') {
			$sort_column = 'unit_price';
		} else if ($sort_column_1 == 'quantity') {
			$sort_column = 'quantity';
		} else if ($sort_column_1 == 'name') {
			$sort_column = 'name';
		} else if ($sort_column_1 == 'discount') {
			$sort_column = 'discount';
		} else if ($sort_column_1 == 'total') {
			$sort_column = 'total';
		}

		if ($sort_column != "") {
			$sort_type = $this->input->post("sort_type");
			$this->cart->sort($sort_column, $sort_type);
			$this->cart->save();
		} else if ($sort_column_1 == 'drag_drop') {
			$drag_index = $this->input->post("drag_index");
			$drop_index = $this->input->post("drop_index");
			if ($drag_index > -1 && $drop_index > -1 & $drag_index != $drop_index) {
				$this->cart->drag_drop($drag_index, $drop_index);
				$this->cart->save();
			}
		}
		$this->sales_reload();
	}
	function update_sales_item_order()
	{
		$list = $this->input->post("item_lines");

		foreach ($list as $item_line) {
			$item_id = $item_line['item_id'];
			$sale_id = $item_line['sale_id'];
			$item_class = $item_line['item_class'];
			$receipt_line_sort_order = $item_line['receipt_line_sort_order'];
			$this->Sale->sale_item_receipt_line_sort_order_update($sale_id, $item_id, $item_class, $receipt_line_sort_order);
		}

		$result = array(
			'state' => 1
		);
		echo json_encode($result);
		exit;
	}


	function set_create_invoice()
	{
		$this->cart->create_invoice = $this->input->post('create_invoice');
		$this->cart->save();
	}

	function mode_return()
	{
		$this->change_mode('return');
		redirect('sales');
	}

	function mode_sale()
	{
		$this->change_mode('sale');
		redirect('sales');
	}

	function mode_estimate()
	{
		$this->change_mode('estimate');
		redirect('sales');
	}

	function coreclear_portal()
	{
		redirect(base_url() . 'coreclear.html');
	}

	function return_order($order_id)
	{

		$order_id =  str_replace(($this->config->item('sale_prefix') ? $this->config->item('sale_prefix') : 'POS') . '%20', '', $order_id);
		if ($this->Sale->exists($order_id)) {

			$payments = PHPPOSCartSale::get_instance_from_sale_id($order_id, 'sale', TRUE)->get_payments();
			// dd($payments);
			$this->cart->destroy();

			$this->cart->set_mode('return');
			$this->cart->set_payments($payments);
			if ($this->cart->get_mode() == 'return') {
				$this->cart->return_order($order_id);
			}
		}
		// dd($this->cart);
		redirect('sales');
		return;
	}
	function select_zatca_invoice()
	{
		$_POST['ref_sale_id'] = str_replace('|FORCE_SALE_ID|', '', $_POST['ref_sale_id']);
		$ref_sale_id = $_POST['ref_sale_id'];
		$data = $this->cart->select_ref_sale($ref_sale_id);
		$this->cart->save();
		$this->sales_reload($data);
	}

	function delete_ref_sale()
	{
		$this->cart->delete_ref_sale();
		$this->cart->save();
		$this->_reload();
	}
	function set_create_work_order()
	{
		// Set the value of create_work_order to the post data and save it to the cart object
		$this->cart->create_work_order 			= $this->input->post('create_work_order');
		$this->cart->save();
	}

	function view_unconfirmed()
	{
		$this->load->model('Credit_card_charge_unconfirmed');
		$data = array();
		$data['transactions'] = $this->Credit_card_charge_unconfirmed->get_all($this->cart);
		$this->load->view('sales/view_unconfirmed', $data);
	}

	function load_unconfirmed($credit_card_charge_id)
	{
		$this->load->model('Credit_card_charge_unconfirmed');

		$charge_info = $this->Credit_card_charge_unconfirmed->get($credit_card_charge_id);
		if ($cart_data = $charge_info['cart_data']) {
			$this->cart->destroy();
			$this->Employee->set_employee_current_register_id($charge_info['register_id_of_charge']);
			$this->cart = unserialize($cart_data);
			$this->cart->save();
		}
		$this->_reload(array(), false);
	}

	function import_sales()
	{
		$this->load->view("sales/import_sales", null);
	}

	function do_excel_upload_sale()
	{
		ini_set('memory_limit', '1024M');
		$this->load->helper('demo');

		//Write to app files
		$this->load->model('Appfile');
		$cur_timezone = date_default_timezone_get();
		//We are doing this to make sure same timezone is used for expiration date
		date_default_timezone_set('America/New_York');
		$app_file_file_id = $this->Appfile->save($_FILES["file"]["name"], file_get_contents($_FILES["file"]["tmp_name"]), '+3 hours');
		date_default_timezone_set($cur_timezone);
		//Store file_id from app files in session so we can reference later
		$this->session->set_userdata("excel_import_file_id_sale", $app_file_file_id);

		$file_info = pathinfo($_FILES["file"]["name"]);
		$file = $this->Appfile->get($this->session->userdata('excel_import_file_id_sale'));
		$tmpFilename = tempnam(ini_get('upload_tmp_dir'), 'cexcel');

		file_put_contents($tmpFilename, $file->file_data);
		$this->load->helper('spreadsheet');

		$first_row = get_spreadsheet_first_row($tmpFilename, $file_info['extension']);
		unlink($tmpFilename);

		$fields = $this->_get_database_fields_for_import_as_array_sale();

		$k = 0;
		foreach ($first_row as $col_name) {
			$column = array('Spreadsheet Column' => $col_name, 'Index' => $k);

			if ($column['Spreadsheet Column'] == '') {
				echo json_encode(array(
					'success' => false,
					'message' => lang('spreadsheet_columns_must_have_labels')
				));
				return;
			}

			$cols = array_column($fields, 'Name');
			$cols = array_map('strtolower', $cols);
			$search = strtolower($column['Spreadsheet Column']);
			$matchIndex = array_search($search, $cols);

			if (is_numeric($matchIndex)) {
				$column['Database Field'] = $fields[$matchIndex]['Id'];
			}

			$columns[] = $column;
			$k++;
		}

		$this->session->set_userdata("import_sales_excel_import_column_map", $columns);
		echo json_encode(array('success' => true, 'message' => lang('import_successful')));
	}

	function do_excel_import_map_sale()
	{
		ini_set('memory_limit', '1024M');
		$this->load->helper('text');
		$this->load->model('Appfile');

		$file = $this->Appfile->get($this->session->userdata('excel_import_file_id_sale'));

		$tmpFilename = tempnam(ini_get('upload_tmp_dir'), 'cexcel');

		file_put_contents($tmpFilename, $file->file_data);
		$this->load->helper('spreadsheet');

		$file_info = pathinfo($file->file_name);
		$sheet = file_to_spreadsheet($tmpFilename, $file_info['extension']);
		unlink($tmpFilename);

		$this->sheet_data = array();

		$columns = array();
		$k = 0;

		$fields = $this->_get_database_fields_for_import_as_array_sale();
		$numRows = $sheet->getNumberOfRows();

		while ($col_name = $sheet->getCellByColumnAndRow($k, 1)) {
			$column = array('Spreadsheet Column' => $col_name, 'Index' => $k);

			$cols = array_column($fields, 'Name');
			$cols = array_map('strtolower', $cols);
			$search = strtolower($column['Spreadsheet Column']);
			$matchIndex = array_search($search, $cols);

			if (is_numeric($matchIndex)) {
				$column['Database Field'] = $fields[$matchIndex]['Id'];
			}

			$col_data = array();
			for ($i = 2; $i <= $numRows; $i++) {
				$col_data[] = trim(clean_string($sheet->getCellByColumnAndRow($k, $i)));
			}

			$column["data"] = $col_data;

			$columns[] = $column;
			$k++;
		}

		$this->session->set_userdata("import_sales_excel_import_num_rows", $numRows);
		$this->session->set_userdata("import_sales_excel_import_column_map", $columns);
	}

	function get_database_fields_for_import_sale()
	{
		$fields = $this->_get_database_fields_for_import_as_array_sale();
		array_unshift($fields, array('Name' => '', 'Id' => -1));
		echo json_encode($fields);
	}

	private function _get_database_fields_for_import_as_array_sale()
	{
		ini_set('memory_limit', '1024M');
		$fields = array();

		$fields[] = array('Name' => lang('sale_id'), 'key' => 'sale_id');
		$fields[] = array('Name' => lang('sale_date'), 'key' => 'sale_time');
		$fields[] = array(
			'Name' => lang('person_id') . '/' . lang('sales_customer_name'),
			'key'  => 'customer_id'
		);
		$fields[] = array('Name' => lang('sales_employee_id'), 'key' => 'employee_id');
		$fields[] = array('Name' => lang('sales_sold_by_employee_id'), 'key' => 'sold_by_employee_id');
		$fields[] = array('Name' => lang('sales_location_id'), 'key' => 'location_id');
		$fields[] = array('Name' => lang('comment'), 'key' => 'comment');
		$fields[] = array('Name' => lang('sales_suspended'), 'key' => 'suspended');
		$fields[] = array(
			'Name' => lang('item_id') . '/' . lang('item_number') . '/' . lang('product_id'),
			'key'  => 'item_id'
		);
		$fields[] = array('Name' => lang('sales_quantity_ordered'), 'key' => 'quantity_purchased');
		$fields[] = array('Name' => lang('sales_cost'), 'key' => 'item_cost_price');
		$fields[] = array('Name' => lang('sales_price'), 'key' => 'item_unit_price');
		$fields[] = array('Name' => lang('sales_tax'), 'key' => 'tax');
		$fields[] = array('Name' => lang('sales_paid_amount'), 'key' => 'payment_amount');
		$fields[] = array('Name' => lang('sales_payment_date'), 'key' => 'payment_date');
		$fields[] = array('Name' => lang('sales_payment_type'), 'key' => 'payment_type');

		for ($k = 1; $k <= NUMBER_OF_PEOPLE_CUSTOM_FIELDS; $k++) {
			if ($this->Sale->get_custom_field($k) !== FALSE) {
				$fields[] = array(
					'Name' => $this->Sale->get_custom_field($k),
					'key'  => 'custom_field_' . $k . '_value'
				);
			}
		}

		$id = 0;
		foreach ($fields as &$field) {
			$field['Id'] = $id;
			$id++;
		}
		unset($field);

		usort($fields, function ($a, $b) {
			return $a['Name'] <=> $b['Name'];
		});

		return $fields;
	}

	function get_uploaded_excel_columns_sale()
	{
		$data = $this->session->userdata("import_sales_excel_import_column_map");

		foreach ($data as &$col) {
			unset($col["data"]);
		}

		echo json_encode($data);
	}

	public function set_excel_columns_map_sale()
	{
		ini_set('memory_limit', '1024M');
		$data = $this->session->userdata("import_sales_excel_import_column_map");

		$mapKeys = json_decode($this->input->post('mapKeys'), true);

		foreach ($mapKeys as $mapKey) {
			foreach ($data as $key => $col) {
				if ($col['Index'] == $mapKey["Index"]) {
					$data[$key]["Database Field"] = $mapKey["Database Field"];
				}
			}
		}

		$this->session->set_userdata("import_sales_excel_import_column_map", $data);
	}

	private function _indexColumnArray($n)
	{
		if (isset($n['Database Field'])) {
			return $n['Database Field'];
		}

		return 'N/A';
	}

	//new function
	function complete_excel_import_sale()
	{
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		ini_set('max_input_time', '-1');

		$this->session->set_userdata('excel_import_error_log_sale', NULL);

		$employee_info = $this->Employee->get_logged_in_employee_info();

		$numRows = $this->session->userdata("import_sales_excel_import_num_rows");
		$columns_with_data = $this->session->userdata("import_sales_excel_import_column_map");

		$fields = $this->_get_database_fields_for_import_as_array_sale();

		$fieldId_to_colIndex = array_flip(array_map(array($this, '_indexColumnArray'), $columns_with_data));
		unset($fieldId_to_colIndex['N/A']);

		$can_commit = TRUE;
		$this->db->trans_begin();

		for ($i = 0; $i < $numRows - 1; $i++) {
			$is_new_sale = FALSE;
			$sale_id = FALSE;
			$sale_data = array();
			$sale_item_data = array();
			$sale_payment_data = array();

			$sale_data_keys = array(
				"sale_time",
				"customer_id",
				"employee_id",
				"sold_by_employee_id",
				"location_id",
				"comment",
				"suspended"
			);
			for ($k = 1; $k <= NUMBER_OF_PEOPLE_CUSTOM_FIELDS; $k++) {
				if ($this->Sale->get_custom_field($k) !== FALSE) {
					$sale_data_keys[] = 'custom_field_' . $k . '_value';
				}
			}

			$sale_item_data_keys = array(
				"item_id",
				"quantity_purchased",
				"quantity_shipped",
				"item_cost_price",
				"item_unit_price",
				"tax"
			);
			$sale_payment_data_keys = array("payment_amount", "payment_date", "payment_type");

			foreach ($fields as $field) {

				if (array_key_exists($field['Id'], $fieldId_to_colIndex)) {
					$key = $fieldId_to_colIndex[$field['Id']];
				} else { //if its not mapped skip
					continue;
				}

				if ($field['key'] !== "") {
					if (in_array($field['key'], $sale_data_keys)) {
						$sale_data[$field['key']] = $this->_clean($field['key'], $columns_with_data[$key]['data'][$i], $i + 2);
					} else if (in_array($field['key'], $sale_item_data_keys)) {
						$sale_item_data[$field['key']] = $this->_clean($field['key'], $columns_with_data[$key]['data'][$i], $i + 2);
					} else if (in_array($field['key'], $sale_payment_data_keys)) {
						$sale_payment_data[$field['key']] = $this->_clean($field['key'], $columns_with_data[$key]['data'][$i], $i + 2);
					} else if ($field['key'] == "sale_id") {
						$sale_id = $this->_clean($field['key'], $columns_with_data[$key]['data'][$i]);
					}
				}
			} //end field foreach

			if (!$sale_item_data['item_id']) {
				$message = lang('item_id') . '/' . lang('item_number') . '/' . lang('product_id') . ' ' . lang('is_empty');
				$this->_log_validation_error($i + 2, $message, 'Error');

				$this->db->trans_rollback();

				echo json_encode(array(
					'type'    => 'error',
					'message' => lang('errors_occured_durring_import'),
					'title'   => lang('error')
				));
				return;
			}

			if ($sale_item_data['item_id'] == 'invalid') {
				$message = lang('item_id') . '/' . lang('item_number') . '/' . lang('product_id') . ' ' . lang('is_invalid');
				$this->_log_validation_error($i + 2, $message, 'Error');

				$this->db->trans_rollback();

				echo json_encode(array(
					'type'    => 'error',
					'message' => lang('errors_occured_durring_import'),
					'title'   => lang('error')
				));
				return;
			}

			if (!$sale_item_data['quantity_purchased']) {
				$message = lang('sales_quantity_ordered') . ' ' . lang('is_empty');
				$this->_log_validation_error($i + 2, $message, 'Error');

				$this->db->trans_rollback();

				echo json_encode(array(
					'type'    => 'error',
					'message' => lang('errors_occured_durring_import'),
					'title'   => lang('error')
				));
				return;
			}

			$item_info = $this->Item->get_info($sale_item_data['item_id']);

			if ($sale_id) {
				if ($this->Sale->exists($sale_id)) {
					$sale_info = $this->Sale->get_info($sale_id)->row();

					if (!$this->Sale->sale_item_exists($sale_id, $sale_item_data['item_id'])) {
						$sale_item_data['sale_id'] = $sale_id;
						$sale_item_data['description'] = $item_info->name;
						@$sale_item_data['subtotal'] = $sale_item_data['item_unit_price'] * $sale_item_data['quantity_purchased'];
						@$sale_item_data['total'] = $sale_item_data['subtotal'] + $sale_item_data['tax'];
						@$sale_item_data['profit'] = ($sale_item_data['item_unit_price'] * $sale_item_data['quantity_purchased']) - ($sale_item_data['item_cost_price'] * $sale_item_data['quantity_purchased']);
						@$sale_item_data['line'] = $this->Sale->get_max_sale_item_line($sale_id) + 1;

						if ($this->Sale->save_sales_item_data($sale_item_data)) {
							if ($sale_info->suspended) {
								$sale_type_update_inventory = $this->Sale_types->get_info($sale_info->suspended)->update_inventory;
								if ($sale_type_update_inventory == 'commit') {
									$this->Sale->increase_item_quantity_committed($sale_item_data['item_id'], $sale_item_data['quantity_purchased'], $sale_data['location_id']);
								}
							}
							$this->Sale->update_sale_statistics($sale_id);

							if ($sale_payment_data['payment_amount'] > 0 && $sale_payment_data['payment_type']) {
								$sale_payment_data['sale_id'] = $sale_id;
								$this->Sale->save_sales_payment_data($sale_payment_data);
							}

							if ($sale_item_data['tax'] > 0) {
								$sales_items_taxes_data = array(
									'sale_id' => $sale_id,
									'item_id' => $sale_item_data['item_id'],
									'line'    => $sale_item_data['line'],
									'name'    => 'TAX',
									'percent' => round(($sale_item_data['tax'] / ($sale_item_data['item_unit_price'] * $sale_item_data['quantity_purchased'])) * 100, 2),
								);
								$this->Sale->save_sales_items_taxes($sales_items_taxes_data);
							}
						} else {
							$this->_logDbError($i + 2);
							$can_commit = FALSE;
							continue;
						}
					} else {
						continue;
					}
				} else {
					$sale_data['sale_id'] = $sale_id;
					$is_new_sale = TRUE;
				}
			} else {
				$is_new_sale = TRUE;
			}

			if ($is_new_sale) {

				if (!isset($sale_data['employee_id'])) {
					$sale_data['employee_id'] = 1;
				}

				if (!isset($sale_data['location_id'])) {
					$sale_data['location_id'] = 1;
				}


				$sale_data['register_id'] = $this->Employee->get_logged_in_employee_current_register_id();
				$sale_data['exchange_rate'] = 1;
				$sale_data['exchange_currency_symbol'] = '$';
				$sale_data['exchange_currency_symbol_location'] = 'before';
				$sale_data['exchange_thousands_separator'] = ',';
				$sale_data['exchange_decimal_point'] = '.';

				$sale_id = $this->Sale->save_sale_data($sale_data);
				if ($sale_id) {
					$sale_item_data['sale_id'] = $sale_id;
					$sale_item_data['description'] = $item_info->name;
					$sale_item_data['subtotal'] = $sale_item_data['item_unit_price'] * $sale_item_data['quantity_purchased'];
					$sale_item_data['total'] = $sale_item_data['subtotal'] + $sale_item_data['tax'];
					$sale_item_data['profit'] = ($sale_item_data['item_unit_price'] * $sale_item_data['quantity_purchased']) - ($sale_item_data['item_cost_price'] * $sale_item_data['quantity_purchased']);
					$sale_item_data['line'] = 0;

					if ($this->Sale->save_sales_item_data($sale_item_data)) {
						$this->Sale->update_sale_statistics($sale_id);

						if ($sale_payment_data['payment_amount'] > 0 && $sale_payment_data['payment_type']) {
							$sale_payment_data['sale_id'] = $sale_id;
							$this->Sale->save_sales_payment_data($sale_payment_data);
						}

						if ($sale_item_data['tax'] > 0) {
							$sales_items_taxes_data = array(
								'sale_id' => $sale_id,
								'item_id' => $sale_item_data['item_id'],
								'line'    => $sale_item_data['line'],
								'name'    => 'TAX',
								'percent' => round(($sale_item_data['tax'] / ($sale_item_data['item_unit_price'] * $sale_item_data['quantity_purchased'])) * 100, 2),
							);
							$this->Sale->save_sales_items_taxes($sales_items_taxes_data);
						}
					} else {
						$this->_logDbError($i + 2);
						$can_commit = FALSE;
						continue;
					}
				} else {
					$this->_logDbError($i + 2);
					$can_commit = FALSE;
					continue;
				}
			}
		} //loop done for sales

		if ($can_commit) {
			$this->db->trans_commit();
		} else {
			$this->db->trans_rollback();
		}

		//if there were any errors or warnings
		if ($this->db->trans_status() === FALSE && !$can_commit) {
			echo json_encode(array(
				'type'    => 'error',
				'message' => lang('errors_occured_durring_import'),
				'title'   => lang('error')
			));
		} else if ($this->db->trans_status() === FALSE && $can_commit) {
			echo json_encode(array(
				'type'    => 'warning',
				'message' => lang('warnings_occured_durring_import'),
				'title'   => lang('warning')
			));
		} else {
			//Clear out session data used for import
			$this->session->unset_userdata('excel_import_file_id_sale');
			$this->session->unset_userdata('import_sales_excel_import_column_map');
			$this->session->unset_userdata('import_sales_excel_import_num_rows');
			echo json_encode(array(
				'type'    => 'success',
				'message' => lang('import_successful'),
				'title'   => lang('success')
			));
		}
	}

	private function _clean($key, $value, $row = NULL)
	{
		if ($key == 'sale_id') {
			if (!$value) {
				return '';
			}
			return $value;
		}

		if ($key == 'sale_time') {
			if (!$value || strtotime($value) === FALSE) {
				return date('Y-m-d H:i:s');
			}
			return date('Y-m-d H:i:s', strtotime($value));
		}

		if ($key == 'customer_id') {
			if ($value) {
				$supplier_name_before_searching = $value;
				$value = $this->Customer->exists($value) ? $value : $this->Customer->find_customer_id($value);

				if (!$value) {
					$first_and_last_name = explode(' ', $supplier_name_before_searching);
					$first_name = $first_and_last_name[0] ?: '';
					$last_name = $first_and_last_name[1] ?: '';
					$person_data = array('first_name' => $first_name, 'last_name' => $last_name);
					$customer_data = array();
					$this->Customer->save_customer($person_data, $customer_data);
					$value = $customer_data['person_id'];
				}

				return $value;
			}

			return NULL;
		}

		if ($key == 'employee_id') {
			if ($value) {
				return $this->Employee->exists($value) ? $value : $this->Employee->get_logged_in_employee_info()->person_id;
			}

			return $this->Employee->get_logged_in_employee_info()->person_id;
		}

		if ($key == 'sold_by_employee_id') {
			if ($value) {
				return $this->Employee->exists($value) ? $value : NULL;
			}

			return NULL;
		}

		if ($key == 'location_id') {
			if ($value) {

				if ($this->Location->exists($value)) {
					return $value;
				}

				if ($location_info = $this->Location->get_info_by_name($value)) {
					return $location_info->location_id;
				}
			}

			return $this->Employee->get_logged_in_employee_current_location_id();
		}

		if ($key == 'comment') {
			if (!$value) {
				return '';
			}

			return $value;
		}

		if ($key == 'suspended') {
			if (!$value) {
				return 0;
			}

			return $value;
		}

		if ($key == 'item_id') {
			if ($value) {
				$item_id = $this->Item->lookup_item_by_item_id($value);
				if (!$item_id) {
					$item_id = $this->Item->lookup_item_by_item_number($value);

					if (!$item_id) {
						$item_id = $this->Item->lookup_item_by_product_id($value);
					}

					if (!$item_id) {
						$item_id = $this->Item->lookup_item_by_item_name($value);
					}
				}

				if (!$item_id) {
					return $this->Item->create_or_update_item_by_name($value);
				} else {
					return $item_id;
				}
			}

			return '';
		}

		if ($key == 'quantity_purchased') {
			if ($value !== '' && $value == (float)$value) {
				return strval((float)$value);
			}
			return 0;
		}

		if ($key == 'quantity_shipped') {
			if ($value !== '' && $value == (float)$value) {
				return strval((float)$value);
			}
			return 0;
		}

		if ($key == 'item_cost_price') {
			if ($value !== "") {
				return make_currency_no_money($value);
			}
			return 0;
		}

		if ($key == 'item_unit_price') {
			if ($value !== "") {
				return make_currency_no_money($value);
			}
			return 0;
		}

		if ($key == 'tax') {
			if ($value !== "") {
				return make_currency_no_money($value);
			}
			return 0;
		}

		if ($key == 'payment_amount') {
			if ($value !== "") {
				return make_currency_no_money($value);
			}
			return 0;
		}

		if ($key == 'payment_date') {
			if (!$value || strtotime($value) === FALSE) {
				return date('Y-m-d H:i:s');
			}
			return date('Y-m-d H:i:s', strtotime($value));
		}

		if ($key == 'payment_type') {
			if (!$value) {
				return '';
			}
			return $value;
		}

		$custom_fields = array();
		for ($k = 1; $k <= NUMBER_OF_PEOPLE_CUSTOM_FIELDS; $k++) {
			if ($this->Sale->get_custom_field($k) !== FALSE) {
				$custom_fields[] = "custom_field_${k}_value";
			}
		}

		if (in_array($key, $custom_fields)) {
			if (!$value) {
				return '';
			}

			$k = substr($key, strlen('custom_field_'), 1);
			$type = $this->Sale->get_custom_field($k, 'type');

			if ($type == 'date') {
				$value = strtotime($value);
			}

			return $value;
		}
	}

	private function _logDbError($index)
	{
		$error = $this->db->error();
		$matches = array();
		preg_match('/for key \'(.+)\'/', $error['message'], $matches);

		if (isset($matches[1])) {
			$col_name = $matches[1];
			$data = $this->_get_database_fields_for_import_as_array_sale();
			$cols = array_column($data, 'key');
			$match_index = array_search($col_name, $cols);

			if ($match_index !== FALSE) {
				$column_human_name = $data[$match_index]['Name'];
				$error['message'] = str_replace($col_name, $column_human_name, $error['message']);
			}
		}
		$this->_log_validation_error($index, $error['message'], "Error");
	}

	private function _log_validation_error($row, $message, $type = "Warning")
	{
		//log errors and warnings for import
		if (!$log = $this->session->userdata('excel_import_error_log_sale')) {
			$log = array();
		}

		$log[] = array("row" => $row, "message" => $message, "type" => $type);

		$this->session->set_userdata('excel_import_error_log_sale', $log);
	}

	public function get_import_errors()
	{
		echo json_encode($this->session->userdata('excel_import_error_log_sale'));
	}

	function _excel_get_header_row_import_sales()
	{
		$header_row = array();

		$header_row[] = lang('sale_id');
		$header_row[] = lang('sale_date');
		$header_row[] = lang('person_id') . '/' . lang('sales_customer_name');
		$header_row[] = lang('sales_employee_id');
		$header_row[] = lang('sales_sold_by_employee_id');
		$header_row[] = lang('sales_location_id');
		$header_row[] = lang('comment');
		$header_row[] = lang('sales_suspended');
		$header_row[] = lang('item_id') . '/' . lang('item_number') . '/' . lang('product_id');
		$header_row[] = lang('sales_quantity_ordered');
		$header_row[] = lang('sales_cost');
		$header_row[] = lang('sales_price');
		$header_row[] = lang('sales_tax');
		$header_row[] = lang('sales_paid_amount');
		$header_row[] = lang('sales_payment_date');
		$header_row[] = lang('sales_payment_type');

		for ($k = 1; $k <= NUMBER_OF_PEOPLE_CUSTOM_FIELDS; $k++) {
			if ($this->Sale->get_custom_field($k) !== FALSE) {
				$header_row[] = $this->Sale->get_custom_field($k);
			}
		}

		return $header_row;
	}

	function excel_template_for_new_sales()
	{
		$this->load->helper('report');
		$header_row = $this->_excel_get_header_row_import_sales();
		$this->load->helper('spreadsheet');
		array_to_spreadsheet(array($header_row), 'sales_import.' . ($this->config->item('spreadsheet_format') == 'XLSX' ? 'xlsx' : 'csv'));
	}

	function excel_export_sales()
	{
		ini_set('memory_limit', '1024M');
		$this->load->helper('download');
		set_time_limit(0);
		ini_set('max_input_time', '-1');

		$data = $this->Sale->get_all_sales()->result_object();

		$this->load->helper('report');
		$rows = array();

		$header_row = $this->_excel_get_header_row_import_sales();
		$rows[] = $header_row;

		foreach ($data as $r) {

			$row = array(
				$r->sale_id,
				date(get_date_format(), strtotime($r->sale_time)),
				$r->customer_id,
				$r->employee_id,
				$r->sold_by_employee_id,
				$r->location_id,
				$r->comment,
				$r->suspended,
				$r->item_id,
				to_quantity($r->quantity_purchased, FALSE),
				to_currency_no_money($r->item_cost_price, 2, TRUE),
				to_currency_no_money($r->item_unit_price, 2, TRUE),
				to_currency_no_money($r->tax, 2, TRUE),
				$r->payment_amount ? to_currency_no_money($r->payment_amount, 2, TRUE) : '',
				$r->payment_date ? date(get_date_format(), strtotime($r->payment_date)) : '',
				$r->sales_payments_payment_type,
			);

			for ($k = 1; $k <= NUMBER_OF_PEOPLE_CUSTOM_FIELDS; $k++) {
				$type = $this->Sale->get_custom_field($k, 'type');
				$name = $this->Sale->get_custom_field($k, 'name');

				if ($name !== FALSE) {
					if ($type == 'date') {
						$value = $r->{"custom_field_{$k}_value"};
						if ($value && is_numeric($value)) {
							$row[] = date(get_date_format(), $value);
						} else {
							$row[] = '';
						}
					} else if ($type == 'checkbox') {
						$row[] = $r->{"custom_field_{$k}_value"} ? '1' : '0';
					} else {
						$row[] = $r->{"custom_field_{$k}_value"};
					}
				}
			}

			$rows[] = $row;
		}

		$this->load->helper('spreadsheet');
		array_to_spreadsheet($rows, 'sales_export.' . ($this->config->item('spreadsheet_format') == 'XLSX' ? 'xlsx' : 'csv'));
	}

	function customer_person_id_exists()
	{
		$term = $this->input->post('term');
		if ($this->Customer->exists($term)) {
			echo json_encode(["exists" => true]);
		} else {
			echo json_encode(["exists" => false]);
		}
	}

	function set_session_var($key, $value, $reload = 1)
	{
		$_SESSION[$key] = $value;
		if ($reload) {
			$this->_reload();
		}
	}

	function quick_modal()
	{
?>
		<div>
			<span>[F1,F3] => <?php echo lang('start_new_sale'); ?></span><br />
			<span>[F4] => <?php echo lang('sales_completes_currrent_sale'); ?></span><br />
			<span>[F2] => <?php echo lang('sales_set_focus_item'); ?></span><br />
			<span>[F7] => <?php echo lang('sales_set_focus_payment'); ?></span><br />
			<span>[F8] => <?php echo lang('reports_suspended_sales'); ?></span><br />
			<span>[F9] => <?php echo lang('open_cash_drawer'); ?></span><br />
			<span>[ESC] => <?php echo lang('sales_esc_cancel_sale'); ?></span><br>
			<span>[CTRL + Q] => <?php echo lang('quick_cash_help'); ?></span><br>

		</div>
<?php
	}
}
?>