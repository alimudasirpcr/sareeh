<?php
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: text/html; charset=utf-8");
		header("Cache-Control: no-store, must-revalidate");

require_once ("Secure_area.php");

require_once (APPPATH."libraries/google2fa/vendor/autoload.php");
require_once (APPPATH."libraries/bacon-qr-code/vendor/autoload.php");

use PragmaRX\Google2FAQRCode\Google2FA;

class Home extends Secure_area 
{
	function __construct()
	{
		parent::__construct();	
		$this->load->helper('report');
		$this->lang->load('module');
		$this->lang->load('home');
		$this->load->model('Item');
		$this->load->model('Item_kit');
		$this->load->model('Supplier');
		$this->load->model('Customer');
		$this->load->model('Employee');
		$this->load->model('Giftcard');
		$this->load->model('Sale');
		$this->load->helper('cloud');
		$this->load->helper('text');
		$this->load->model('Appfile');
	}
	function payvantage()
	{
		$this->load->view("payvantage");
		
	}


	
	function index($choose_location=0)
	{		
		require_once (APPPATH.'models/reports/Report.php');
		
		if (!$choose_location && $this->config->item('timeclock') && !$this->Employee->is_clocked_in() && !$this->Employee->get_logged_in_employee_info()->not_required_to_clock_in)
		{
			redirect('timeclocks');
		}

		

		$data['choose_location'] = $choose_location;
		
		$data['total_items']=$this->Item->count_all();
		$data['total_item_kits']=$this->Item_kit->count_all();
		$data['total_suppliers']=$this->Supplier->count_all();
		$data['total_customers']=$this->Customer->count_all($this->config->item('only_allow_current_location_customers') ? $this->Employee->get_logged_in_employee_current_location_id() : '');
		$data['total_employees']=$this->Employee->count_all();
		$data['total_locations']=$this->Location->count_all();
		$data['total_giftcards']=$this->Giftcard->count_all();
		$data['total_sales']=$this->Sale->count_all();
		$data['saved_reports'] = Report::get_saved_reports();
		
		$current_location = $this->Location->get_info($this->Employee->get_logged_in_employee_current_location_id());
		$current_location_id = $this->Employee->get_logged_in_employee_current_location_id();
		$data['message']  = "";
		if ($this->Employee->has_module_action_permission('reports', 'view_dashboard_stats', $this->Employee->get_logged_in_employee_info()->person_id))
		{	
			
			$data['month_sale'] = $this->sales_widget();
			$data['weekly_sale'] = $this->sales_widget('weekly');
		}
		dd($data['month_sale']);
		$this->load->helper('demo');
		$data['can_show_mercury_activate'] =0; // (!is_on_demo_host() && !$this->config->item('mercury_activate_seen')) && !$this->Location->get_info_for_key('enable_credit_card_processing') && $this->config->item('branding_code') == 'phpsalesmanager';		
		$data['can_show_setup_wizard'] = !$this->config->item('shown_setup_wizard');
		$data['can_show_feedback_promotion'] = !$this->config->item('shown_feedback_message')  && $this->config->item('branding_code') == 'phpsalesmanager';		
		$data['can_show_reseller_promotion'] = !$this->config->item('reseller_activate_seen')  && $this->config->item('branding_code') == 'phpsalesmanager';
		if (is_on_phppos_host())
		{
			$this->lang->load('login');
			$site_db = $this->load->database('site', TRUE);
			
			if (!is_on_demo_host())
			{
				$data['announcement'] = get_cloud_announcement($site_db);
			}
			
			if (is_subscription_cancelled($site_db) || is_subscription_failed($site_db) || is_in_trial($site_db))
			{
				$data['cloud_customer_info'] = get_cloud_customer_info($site_db);
				
				if (is_in_trial($site_db))
				{
						$data['trial_on']  = TRUE;
				}
				elseif (is_subscription_failed($site_db))
				{
					$data['subscription_payment_failed']  = TRUE;
				}
				elseif (is_subscription_cancelled_within_grace_period($site_db))
				{
					$data['subscription_cancelled_within_5_days']  = TRUE;
				}
			}
		}
		
				
		$start_date = date('Y-m-d 00:0:00');
		$end_date = date('Y-m-d 23:59:59',strtotime('+6 months'));
		$this->db->select('locations.name as location_name, items.name, SUM(quantity_purchased) as quantity_expiring,items.size,receivings_items.expire_date, categories.id as category_id,categories.name as category, company_name, item_number, product_id, 
		'.$this->db->dbprefix('receivings_items').'.item_unit_price as cost_price, 
		IFNULL('.$this->db->dbprefix('location_items').'.unit_price, '.$this->db->dbprefix('items').'.unit_price) as unit_price,
		SUM(quantity) as quantity, 
		IFNULL('.$this->db->dbprefix('location_items').'.reorder_level, '.$this->db->dbprefix('items').'.reorder_level) as reorder_level, 
		items.description', FALSE);
		$this->db->from('items');
		$this->db->join('receivings_items', 'receivings_items.item_id = items.item_id');
		$this->db->join('receivings', 'receivings_items.receiving_id = receivings.receiving_id');
		$this->db->join('suppliers', 'items.supplier_id = suppliers.person_id', 'left outer');
		$this->db->join('categories', 'items.category_id = categories.id', 'left outer');
		$this->db->join('locations', 'locations.location_id = receivings.location_id');
		$this->db->join('location_items', "location_items.item_id = items.item_id and location_items.location_id = $current_location_id", 'left');

		$this->db->where('items.deleted', 0);
		$this->db->where('items.system_item',0);
		
		$this->db->where('receivings.location_id', $current_location_id);
			
		$this->db->where('receivings_items.expire_date >=', $start_date);
		$this->db->where('receivings_items.expire_date <=', $end_date);

		$this->db->group_by('receivings_items.receiving_id,receivings_items.item_id,receivings_items.line');
		$this->db->order_by('receivings_items.expire_date');
		
		$expire_result = $this->db->get()->result_array();
		$sales_tbl= $this->db->dbprefix('sales');
		$sales_type_tbl= $this->db->dbprefix('sale_types');
		
		 $sale_status = get_query_data("
				SELECT 
					st.id AS sale_type_id,
					st.name AS sale_type_name,
					COALESCE(COUNT(s.sale_id), 0) AS sale_count,
					ROUND(CASE 
						WHEN total_sales.total_count > 0 
						THEN COALESCE(COUNT(s.sale_id), 0) / total_sales.total_count * 100 
						ELSE 0 
					END ,2) AS percentage,
					CASE 
						WHEN total_sales.total_count > 0 AND COALESCE(COUNT(s.sale_id), 0) / total_sales.total_count * 100 BETWEEN 0 AND 15 THEN 'danger'
						WHEN total_sales.total_count > 0 AND COALESCE(COUNT(s.sale_id), 0) / total_sales.total_count * 100 BETWEEN 15 AND 30 THEN 'warning'
						WHEN total_sales.total_count > 0 AND COALESCE(COUNT(s.sale_id), 0) / total_sales.total_count * 100 BETWEEN 30 AND 45 THEN 'dark'
						WHEN total_sales.total_count > 0 AND COALESCE(COUNT(s.sale_id), 0) / total_sales.total_count * 100 BETWEEN 45 AND 60 THEN 'primary'
						WHEN total_sales.total_count > 0 AND COALESCE(COUNT(s.sale_id), 0) / total_sales.total_count * 100 BETWEEN 60 AND 75 THEN 'secondary'
						WHEN total_sales.total_count > 0 AND COALESCE(COUNT(s.sale_id), 0) / total_sales.total_count * 100 BETWEEN 75 AND 90 THEN 'info'
						ELSE 'success'
					END AS color
				FROM 
				".$sales_type_tbl." st
				LEFT JOIN ".$sales_tbl." s ON st.id = s.suspended AND s.location_id = 1 -- Adjust this condition as needed
				CROSS JOIN (SELECT COUNT(*) AS total_count FROM ".$sales_tbl." WHERE location_id = 1) AS total_sales -- This assumes location is a relevant filter
				GROUP BY 
					st.id, st.name
				ORDER BY 
					CASE 
						WHEN total_sales.total_count > 0 
						THEN COALESCE(COUNT(s.sale_id), 0) / total_sales.total_count * 100 
						ELSE 0 
					END desc
		 ");
	
		$data['sale_status'] = $sale_status;
		$data['expiring_items'] = $expire_result;
		
		$data['ecommerce_realtime'] = $this->config->item('ecommerce_realtime');
		
		if (isset($site_db) && $site_db)
		{
			$site_db->close();
		}

		$this->load->model('sale');
		
		// $times = [  'TODAY' , 'THIS_WEEK' , 'THIS_MONTH' , 'THIS_YEAR' ] ;
		$times = [  'THIS_MONTH'  ] ;
		foreach($times as $time){
		
				$data['stats'][$time."_sales_top_employees"] = $this->sale->get_stats_for_graph($time);
			
		}
		// $data['stats']['all_time_sales_top_employees'] = $this->sale->get_stats_for_graph();
		check_for_invoices_erp();
		$this->load->view("home",$data);
	}
	public function sync(){
		check_for_invoices_erp(true);
		redirect('home');
	}
	// public function check_limits() {
    //     $type = $this->input->get('type'); // Get type from request (staff/items)
        
    //     if (!$type) {
    //         echo "Please specify a valid type (staff or items).";
    //         return;
    //     }

    //     $result = check_limitations_items($type); // Call helper function
    //     echo $result; // Display the result
    // }
	
	
	public function ajax_get_stats_for_graph(){
		$time = $this->input->post('time');
		$from_date='';
		$to_date='';
		if(isset($_POST['from_date'])){
			$from_date = $_POST['from_date'];
		}
		if(isset($_POST['to_date'])){
            $to_date = $_POST['to_date'];
        }
		
        $data = $this->sale->get_stats_for_graph($time , $from_date , $to_date);
        echo json_encode($data);
	}
	public function ajax_get_stats_for_graph_wo(){
		$this->load->model('work_order');
		$time = $this->input->post('time');
		$status = $this->input->post('status');
		$from_date='';
		$to_date='';
		if(isset($_POST['from_date'])){
			$from_date = $_POST['from_date'];
		}
		if(isset($_POST['to_date'])){
            $to_date = $_POST['to_date'];
        }
		
        $data = $this->work_order->get_stats_for_graph($status , $time , $from_date , $to_date);
        echo json_encode($data);
	}
	public function ajax_get_stats_for_graph_wo_emp(){
		$this->load->model('work_order');
		$time = $this->input->post('time');
		$emp = $this->input->post('emp');
		$from_date='';
		$to_date='';
		if(isset($_POST['from_date'])){
			$from_date = $_POST['from_date'];
		}
		if(isset($_POST['to_date'])){
            $to_date = $_POST['to_date'];
        }
		
        $data = $this->work_order->get_stats_for_graph_no_employee( $time , $from_date , $to_date , $emp);
        echo json_encode($data);
	}
	function work_order_dashboard(){
		$data = array();
		$this->load->model('work_order');
		$data['status_boxes'] = $this->Work_order->get_work_orders_by_status();
		$data['stats']['all_time_current_location'] = $this->work_order->get_stats_for_graph();
		$times = [  'THIS_YEAR'  ] ;
		// $status =['new' , 'in_progress' , 'out_of_repair' , 'waiting_on_customer' , 'repaired' , 'completed' , 'cancelled'];
		foreach($times as $time){
			
		
				$data['work_orders_'.$time] = $this->work_order->get_stats_for_graph(1, $time);
		}
		
		foreach($times as $time){
		
				$data['work_orders_status_wise_'.$time] = $this->work_order->get_stats_for_graph_no_employee($time);
			
		}

		
		// dd($data);
		
		$this->load->view("dashboard/work_order_dashboard",$data);
	}
	
	function dismiss_setup_wizard()
	{
		$this->Appconfig->save('shown_setup_wizard',1);
	}
	
	function dismiss_feedback_message()
	{
		$this->Appconfig->save('shown_feedback_message',1);
	}

	function dismiss_mercury_message()
	{
		$this->Appconfig->mark_mercury_activate(true);
	}
	
	function dismiss_reseller_message()
	{
		$this->Appconfig->mark_reseller_message(true);		
	}
	
	function logout()
	{
		if (isset($_SESSION['samlNameId']) && $this->config->item('saml_single_logout_service'))
		{
			redirect('login/samlassertionconsumerservice?slo');
		}
		else
		{
			$this->Employee->logout();
		}
	}

	function save_quick_access(){
		// $this->session->set_userdata('quick_access', $this->input->post('quick_access'));
		// save_data ('phppos_app_config' , ['key' => 'quick_access' , 'value' => json_encode($this->input->post('items'))]);
		$id = $this->Employee->get_logged_in_employee_info()->id;
		update_data('phppos_employees', ['quick_access' => json_encode($this->input->post('items'))],$id );


	}	
	
	function set_employee_current_location_id()
	{

		
		$this->Employee->set_employee_current_location_id($this->input->post('employee_current_location_id'));
		
		//Clear out logged in register when we switch locations
		$this->Employee->set_employee_current_register_id(null);
		
	}

	function get_employee_current_location_id()
	{
		
		$current_location = $this->Location->get_info($this->Employee->get_logged_in_employee_current_location_id());

		echo $current_location->current_announcement;

	}
	
	function keep_alive()
	{
		//Set keep alive session to prevent logging out
		$this->session->set_userdata("keep_alive",time());
		echo $this->session->userdata('keep_alive');
	}
	
	function set_fullscreen($on = 0)
	{
		$this->session->set_userdata("fullscreen",$on);		
	}
		
	function view_item_modal($item_id)
	{
		$this->lang->load('items');
		$this->lang->load('receivings');
		$this->load->model('Tier');
		$this->load->model('Category');
		$this->load->model('Manufacturer');
		$this->load->model('Tag');
		$this->load->model('Item_location');
		$this->load->model('Item_taxes_finder');
		$this->load->model('Item_location_taxes');
		$this->load->model('Receiving');
		$this->load->model('Item_taxes');
		$this->load->model('Additional_item_numbers');
		$this->load->model('Item_variations');
		$this->load->model('Item_variation_location');
		
		$data['redirect'] = $this->input->get('redirect');
			
		$data['item_info'] = $this->Item->get_info($item_id);
		$data['item_images'] = $this->Item->get_item_images($item_id);
		$data['item_variations'] = $this->Item_variations->get_variations($item_id);
		$data['item_variation_location'] = $this->Item_variation_location->get_variations_with_quantity($item_id);
		
		$data['additional_item_numbers'] = $this->Additional_item_numbers->get_item_numbers($item_id);
		
		$data['tier_prices'] = array();
		
		foreach($this->Tier->get_all()->result() as $tier)
		{
			$tier_id = $tier->id;
			$tier_price = $this->Item->get_tier_price_row($tier_id,$item_id);
			
			if ($tier_price)
			{
				$value = $tier_price->unit_price !== NULL ? to_currency($tier_price->unit_price) : $tier_price->percent_off.'%';			
				$data['tier_prices'][] = array('name' => $tier->name, 'value' => $value);
			}
		}
		
		$data['category'] = $this->Category->get_full_path($data['item_info']->category_id);
		$data['manufacturer'] = $this->Manufacturer->get_info($data['item_info']->manufacturer_id)->name;
		$logged_in_employee_info=$this->Employee->get_logged_in_employee_info();
		
	
		if ($this->Employee->has_module_action_permission('items', 'view_inventory_at_all_locations', $this->Employee->get_logged_in_employee_info()->person_id))
		{
			//Make all locations authed for modal to see all locations inventory
			$authed_locations = array();
			
			foreach($this->Location->get_all()->result_array() as $all_loc)
			{
				$authed_locations[] = $all_loc['location_id'];
			}
		}
		else
		{
			$authed_locations = $this->Employee->get_authenticated_location_ids($logged_in_employee_info->person_id);
		}
		
		$data['item_location_info']=$this->Item_location->get_info($item_id);
		
		$data['authed_locations'] = $authed_locations;
		foreach($authed_locations as $authed_location_id)
		{
			$data['item_location_info_all'][$authed_location_id]=$this->Item_location->get_info($item_id,$authed_location_id);
			$data['reorder_level'][$authed_location_id] = ($data['item_location_info_all'][$authed_location_id] && $data['item_location_info_all'][$authed_location_id]->reorder_level) ? $data['item_location_info_all'][$authed_location_id]->reorder_level : $data['item_info']->reorder_level;
		}
		foreach($authed_locations as $authed_location_id)
		{
			foreach(array_keys($data['item_variations']) as $variation_id)
			{
				$data['item_variation_location_info_all'][$authed_location_id][$variation_id]=$this->Item_variation_location->get_info($variation_id,$authed_location_id);
			}
		}
		
		$data['item_tax_info']=$this->Item_taxes_finder->get_info($item_id);
		
		if ($supplier_id = $this->Item->get_info($item_id)->supplier_id)
		{
			$supplier = $this->Supplier->get_info($supplier_id);
			$data['supplier'] = $supplier->company_name . ' ('.$supplier->first_name.' '.$supplier->last_name.')';
		}
		
		$data['suspended_receivings'] = $this->Receiving->get_suspended_receivings_for_item($item_id);		
		$this->load->view("items/items_modal",$data);
	}
	
	// Function to show the modal window when clicked on kit name
	function view_item_kit_modal($item_kit_id)
	{
		$this->lang->load('item_kits');
		$this->lang->load('items');
		$this->lang->load('receivings');
		$this->load->model('Item');
		$this->load->model('Item_kit');
		$this->load->model('Item_kit_items');
		$this->load->model('Tier');
		$this->load->model('Category');
		$this->load->model('Manufacturer');
		$this->load->model('Tag');
		$this->load->model('Item_kit_location');
		$this->load->model('Item_kit_taxes_finder');
		$this->load->model('Item_kit_location_taxes');
		$this->load->model('Receiving');
		$this->load->model('Item_kit_taxes');
		
		$data['redirect'] = $this->input->get('redirect');
		
		// Fetching Kit information using kit_id
		$data['item_kit_info']=$this->Item_kit->get_info($item_kit_id);
		
		$tier_prices = $this->Item->get_all_tiers_prices();
		
		$data['tier_prices'] = array();
		foreach($this->Tier->get_all()->result() as $tier)
		{
			$tier_id = $tier->id;
			$tier_price = $this->Item_kit->get_tier_price_row($tier_id,$item_kit_id);
			
			if ($tier_price)
			{
				$value = $tier_price->unit_price !== NULL ? to_currency($tier_price->unit_price) : $tier_price->percent_off.'%';			
				$data['tier_prices'][] = array('name' => $tier->name, 'value' => $value);
			}
		}
		
		$data['manufacturer'] = $this->Manufacturer->get_info($data['item_kit_info']->manufacturer_id)->name;
		$data['category'] = $this->Category->get_full_path($data['item_kit_info']->category_id);
		
		//$data['item_kit_location_info']=$this->Item_kit_location->get_info($item_kit_id);
		
		
		$this->load->view("item_kits/items_modal",$data);
	}

	function sales_widget($type = 'monthly')
	{
		
		$day = array();
		$count = array();

		if($type == 'monthly')
		{
			$start_date = date('Y-m-d', mktime(0,0,0,date("m"),1,date("Y"))).' 00:00:00';
			$end_date = date('Y-m-d').' 23:59:59';
		}
		else
		{
			$current_week = strtotime("-0 week +1 day");
			$current_start_week = strtotime("last monday midnight",$current_week);
			$current_end_week = strtotime("next sunday",$current_start_week);

			$start_date = date("Y-m-d",$current_start_week).' 00:00:00';
			$end_date = date("Y-m-d",$current_end_week).' 23:59:59';
		}

		$return = $this->Sale->get_sales_amount_for_range($start_date, $end_date);	
		dd($return);
		$date = array();
		
		foreach ($return as $key => $value) {
			if($type == 'monthly')
			{
				$day[] = date('d M',strtotime($value['sale_date']));	
			}
			else
			{
				$day[] = lang(''.strtolower(date('l',strtotime($value['sale_date']))));
			}
			$amount[] = $value['sale_amount'];
			$start_date = date('Y-m-d' ,strtotime($value['sale_date']));
			$end_date = date('Y-m-d' ,strtotime($value['sale_date']));

			// Start time (beginning of the day)
// Create DateTime objects
$dated = new DateTime($value['sale_date']);

// Start time (beginning of the day)
$startTime = clone $dated;
$startTime->setTime(0, 0, 0);

// End time (end of the day)
$endTime = clone $dated;
$endTime->setTime(23, 59, 59);
$startTimeformat = date(get_date_format().' '.get_time_format(), strtotime($startTime->format('Y-m-d H:i:s')));
$endTimeforamt = date(get_date_format().' '.get_time_format(), strtotime($endTime->format('Y-m-d H:i:s')));

$start_date = $startTime->format('Y-m-d H:i:s');
$end_date = $endTime->format('Y-m-d H:i:s');
$location_id = $this->Employee->get_logged_in_employee_current_location_id(); 
$location_params = '&location_ids%5B%5D=' . $location_id;
$date[] = site_url().'reports/generate/detailed_sales?tier_id=&report_type=complex&report_date_range_simple=CUSTOM&start_date='.$start_date.'&start_date_formatted='.$startTimeformat.'&end_date='.$end_date.'&end_date_formatted='.$endTimeforamt.'&with_time=1&end_date_end_of_day=0&sale_type=all&currency=&register_id=&email=&export_excel=0&select_all=1'.$location_params.'&company=All&business_type=All&num_labels_skip=';
			
		}	

		
		if(empty($return))
		{
			$day = array(0);
			$amount = array(0);
			$data['message'] = lang('not_found');
		}
		$data['day'] = json_encode($day);
		$data['amount'] = json_encode($amount);
		$data['date'] = json_encode($date);
		if($this->input->is_ajax_request())
		{
			if(empty($return))
			{
				echo json_encode(array('message'=>lang('not_found')));
				die();
			}
		    echo json_encode(array('day'=>$day,'amount'=>$amount,'date'=>$date));
		    die();
		}
		//  dd($data);
		return $data;
	}
	
	function enable_test_mode()
	{
		$this->load->helper('demo');
		if (!is_on_demo_host())
		{
			$this->Appconfig->save('test_mode','1');
		}
		redirect('home');
	}
	
	function disable_test_mode()
	{
		$this->load->helper('demo');
		if (!is_on_demo_host())
		{
			$this->Appconfig->save('test_mode','0');
		}
		redirect('home');	
	}
	
	function dismiss_test_mode()
	{
		$this->Appconfig->save('hide_test_mode_home','1');		
	}
	
	
	function get_ecommerce_sync_progress()
	{	
		if ($this->config->item("ecommerce_platform"))
		{
			require_once (APPPATH."models/interfaces/Ecom.php");
			$ecom_model = Ecom::get_ecom_model();
			
			$progress = $ecom_model->get_sync_progress();
			echo json_encode(array('running' => $this->Appconfig->get_raw_ecommerce_cron_running() ? $this->Appconfig->get_raw_ecommerce_cron_running() : FALSE,'percent_complete' => $progress['percent_complete'],'message' => $progress['message']));
		}
		else
		{
			echo json_encode(array('running' => FALSE,'progress' =>0,'message' => ''));
		}
	}
	
	function get_qb_sync_progress()
	{	
		$this->load->model('QuickbooksModel');
		$progress = $this->QuickbooksModel->get_sync_progress();
		echo json_encode(array('running' => $this->Appconfig->get_raw_qb_cron_running() ? $this->Appconfig->get_raw_qb_cron_running() : FALSE,'percent_complete' => $progress['percent_complete'],'message' => $progress['message']));
	}
	
	function reset_barcode_labels()
	{
		$this->load->model('Appconfig');
		$this->Appconfig->save('barcode_width','');
		$this->Appconfig->save('barcode_height','');
		$this->Appconfig->save('scale','');
		$this->Appconfig->save('thickness','');
		$this->Appconfig->save('font_size','');
		$this->Appconfig->save('overall_font_size','');
		$this->Appconfig->save('zerofill_barcode','');
		redirect($_SERVER['HTTP_REFERER'] ? strtok($_SERVER['HTTP_REFERER'], '?') : site_url('items'));
	}
	
	function save_barcode_settings()
	{
		$this->load->model('Appconfig');
		$saved_name = $this->input->get('saved_name');
		foreach($this->input->get() as $var=>$value)
		{
			$this->Appconfig->save($var,$value);
		}
		
		if ($saved_name)
		{
			$this->Appconfig->save('barcoded_labels_'.$saved_name,serialize($this->input->get()));
		}
	}
	
	function save_scroll()
	{
		$save_scroll = $this->input->get('scroll_to');
		$this->session->set_userdata('scroll_to',$save_scroll);
	}
	
	
	function download($file_id)
	{
		//Don't allow images to cause hangups with session
		session_write_close();
		$this->load->model('Appfile');
		$file = $this->Appfile->get($file_id);
		$this->load->helper('file');
		$this->load->helper('download');
		force_download($file->file_name,$file->file_data);
	}
	
	function offline($ignore_timestamp='0')
	{

		

		$this->load->model('Appconfig');
		
		$data  = array();
		
		$data['default_payment_type'] = $this->config->item('default_payment_type') ? $this->config->item('default_payment_type') : lang('cash');
		
		$payment_options=array(
			lang('cash') => lang('cash'),
			lang('check') => lang('check'),
			lang('debit') => lang('debit'),
			lang('credit') => lang('credit')
			);
			
		foreach($this->Appconfig->get_additional_payment_types() as $additional_payment_type)
		{
			$payment_options[$additional_payment_type] = $additional_payment_type;
		}
		$data['remove_topbar'] = true;
		$data['is_pos'] = true;
		$data['payment_options'] = $payment_options;
		if($this->agent->is_mobile()){
			$this->load->view('sales/standby/mobile',$data);
		}else{
	
			$this->load->view('sales/standby/offline',$data);
		}
	}
	
	function datatable_language()
	{
		$this->load->model('Employee');
		$table_lang = $this->Employee->datatable_language();
		echo $table_lang;
	}
	
	function sync_wgp_inventory_search()
	{
		session_write_close();
		$search = $this->input->get('term');
		$url_parameter = rawurlencode($this->config->item('wgp_integration_pkey'));
		$url_userid = rawurlencode($this->config->item('wgp_integration_userid'));
		$url = "https://api.wgp.com/wgpjson.aspx?reqtype=user-sku-price&wgpcustid=".$url_userid."&sku=".$search."&pkey=".$url_parameter;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		
		$headers = array(
		"Accept: application/json",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$resp = curl_exec($curl);
		curl_close($curl);
		$ret_array = json_decode($resp, true);
		
		$search_item_list = array();

		foreach($ret_array as $item_info)
		{

			//there is a match add that item to the database and then add that same item to the sale
			$item_data = array(
				'name'=>$item_info['name'],
				'cost_price'=>((isset($item_info['tier_price']) && $item_info['tier_price']) ? $item_info['tier_price'] : 0),
				'unit_price'=>((isset($item_info['tier_price']) && $item_info['tier_price']) ? $item_info['tier_price'] : 0),
				'product_id'=> $item_info['SKU']
			);

			if(isset($item_info['itemId'])){
				$phppos_additional_item_numbers = array(
					"WGP-".$item_info['itemId']
				);
			}else{
				$phppos_additional_item_numbers = array();
			}

			$item_image_link = "";
			if(isset($item_info['image_url'])){
				$item_image_link = $item_info['image_url'];
			}

			$res = $this->Item->lookup_item_id($item_data['product_id'], array('item_id', 'item_number'));
			$search_item_id = false;
			if($res['status']){
				$search_item_id = $res['value'];
			}


			$new_item = 0;
			if($search_item_id == false){
				$new_item = 1;
			}
			$this->Item->save($item_data, $search_item_id);
			$res = $this->Item->lookup_item_id($item_data['product_id'], array('item_id', 'item_number'));
			
			if($res['status']){
				$search_item_id = $res['value'];
			}
			if($new_item == 1){

				$image_contents = @file_get_contents($item_image_link);

				if ($image_contents)
				{
					$image_file_id = $this->Appfile->save(basename($item_image_link), $image_contents);
				}

				if (isset($image_file_id))
				{
					$this->Item->add_image($search_item_id, $image_file_id);
					$this->Item->set_main_image($search_item_id, $image_file_id);
				}


				if(count($phppos_additional_item_numbers) > 0){
					//additional item number process
					$this->Additional_item_numbers->save($search_item_id, $phppos_additional_item_numbers);
				}

				$supplier_id = $this->Supplier->find_supplier_id('WGP');
			}

			$this->set_supplier_item("WGP", $search_item_id);

			$item_data1 = $this->Item->get_info($search_item_id, false);
			$item_data2 = array(
				'category' => null,
				'default_supplier' => [],
				'image' => $item_data1->main_image_id ?  cacheable_app_file_url($item_data1->main_image_id) : base_url()."assets/img/item.png",
				'quantity' => "Not set",
				'secondary_suppliers' => [],
				'supplier_name' => "WGP",

				'item_number' => $item_data1->item_number,
				'cost_price'=>to_currency($item_data1->cost_price),
				'unit_price'=>to_currency($item_data1->unit_price),
				'label' => $item_data1->product_id." (".$item_data1->name.") - ".to_currency($item_data1->unit_price),
				'product_id'=>$item_data1->product_id,

				'value' => $search_item_id,
			);
			array_push($search_item_list, $item_data2);
			break;

		}

		echo json_encode(H($search_item_list));
		
	}
	
	function sync_ig_item_search(){
		session_write_close();

		// $search_key = "IP5S-Assem-Premium-Black";
		$search_key = $this->input->get("term");
		$search_key = rawurlencode($search_key);

		$url = "https://www.injuredgadgets.com/rest/V1/pos/products?searchCriteria[filterGroups][0][filters][0][field]=sku&searchCriteria[filterGroups][0][filters][0][value]=".$search_key."&[filterGroups][0][filters][0][conditionType]=eq&searchCriteria[pageSize]=20&searchCriteria[currentPage]=1";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		$headers = array(
		   "Accept: application/json",
		   "Authorization: Bearer ".$this->config->item('ig_api_bearer_token'),
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$resp = curl_exec($curl);
		curl_close($curl);
		// var_dump($resp);
		$ret_array = json_decode($resp, true);

		if(isset($ret_array->message) && (strpos($ret_array->message, "The consumer isn't authorized to access") > -1)){
			echo json_encode(array('success'=>false,'message'=>lang('items_sync_ig_bestsellers_failed')));
		}if(isset($ret_array->message) && $ret_array->message == "Request does not match any route."){
			echo json_encode(array('success'=>false,'message'=>lang('items_sync_ig_bestsellers_failed')));
		}else{

			$search_item_list = array();
			if(count($ret_array) == 0){
				//upc search
				$url = "https://www.injuredgadgets.com/rest/V1/pos/products?searchCriteria[filterGroups][0][filters][0][field]=upc&searchCriteria[filterGroups][0][filters][0][value]=".$search_key."&[filterGroups][0][filters][0][conditionType]=eq&searchCriteria[pageSize]=20&searchCriteria[currentPage]=1";
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				
				$headers = array(
				   "Accept: application/json",
				   "Authorization: Bearer ".$this->config->item('ig_api_bearer_token'),
				);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
				//for debug only!
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				
				$resp = curl_exec($curl);
				curl_close($curl);
				// var_dump($resp);
				$ret_array = json_decode($resp, true);
			}

			foreach($ret_array as $item_info){

				//there is a match add that item to the database and then add that same item to the sale
				$item_data = array(
					'name'=>$item_info['name'],
					'item_number'=>((isset($item_info['upc']) && $item_info['upc']) ? $item_info['upc'] : NULL),
					'cost_price'=>((isset($item_info['price']) && $item_info['price']) ? $item_info['price'] : 0),
					'unit_price'=>((isset($item_info['price']) && $item_info['price']) ? $item_info['price'] : 0),
					'product_id'=> $item_info['sku']
				);

				if(isset($item_info['entity_id'])){
					$phppos_additional_item_numbers = array(
						"IG-".$item_info['entity_id']
					);
				}else{
					$phppos_additional_item_numbers = array();
				}

				$item_image = "";
				if(isset($item_info['image'])){
					$item_image = $item_info['image'];
				}

				$res = $this->Item->lookup_item_id($item_data['product_id'], array('item_id', 'item_number'));

				$search_item_id = false;
				if($res['status']){
					$search_item_id = $res['value'];
				}


				$new_item = 0;
				if($search_item_id == false){
					$new_item = 1;
				}
				$this->Item->save($item_data, $search_item_id);
				$res = $this->Item->lookup_item_id($item_data['product_id'], array('item_id', 'item_number'));
			
				if($res['status']){
					$search_item_id = $res['value'];
				}
				if($new_item == 1){

					$item_image_link = "https://www.injuredgadgets.com/pub/media/catalog/product".$item_image;

					$image_contents = @file_get_contents($item_image_link);

					if ($image_contents)
					{
						$image_file_id = $this->Appfile->save(basename($item_image), $image_contents);
					}

					if (isset($image_file_id))
					{
						$this->Item->add_image($search_item_id, $image_file_id);
						$this->Item->set_main_image($search_item_id, $image_file_id);
					}

					//update category : skip now

					if(count($phppos_additional_item_numbers) > 0){
						//additional item number process
						$this->Additional_item_numbers->save($search_item_id, $phppos_additional_item_numbers);
					}

					$supplier_id = $this->Supplier->find_supplier_id('Injured Gadgets');
				}

				$this->set_supplier_item("Injured Gadgets", $search_item_id);

				$item_data1 = $this->Item->get_info($search_item_id, false);
				$item_data2 = array(
					'category' => null,
					'default_supplier' => [],
					'image' => $item_data1->main_image_id ?  cacheable_app_file_url($item_data1->main_image_id) : base_url()."assets/img/item.png",
					'quantity' => "Not set",
					'secondary_suppliers' => [],
					'supplier_name' => "Injured Gadgets",

					'item_number' => $item_data1->item_number,
					'cost_price'=>to_currency($item_data1->cost_price),
					'unit_price'=>to_currency($item_data1->unit_price),
					'label' => $item_data1->product_id." (".$item_data1->name.") - ".to_currency($item_data1->unit_price),
					'product_id'=>$item_data1->product_id,

					'value' => $search_item_id,
				);
				array_push($search_item_list, $item_data2);

			}

			echo json_encode(H($search_item_list));
		}
	}

	function sync_p4_item_search(){
		session_write_close();

		$search_key = $this->input->get("term");
		$search_key = rawurlencode($search_key);

		$url = "https://parts4cells.com/rest/all/V1/products?searchCriteria[currentPage]=1&searchCriteria[pageSize]=20&searchCriteria[filterGroups][0][filters][0][field]=sku&searchCriteria[filterGroups][0][filters][0][value]=".$search_key."&searchCriteria[filterGroups][0][filters][0][conditionType]=eq";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		$headers = array(
		   "Accept: application/json",
		   "Authorization: Bearer ".$this->config->item('p4_api_bearer_token'),
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$resp = curl_exec($curl);
		curl_close($curl);
		// var_dump($resp);
		$ret_array = json_decode($resp, true);

		if(isset($ret_array['message']) && (strpos($ret_array['message'], "The consumer isn't authorized to access") > -1)){
			echo json_encode(array('success'=>false,'message'=>lang('items_sync_p4_inventory_failed')));
			exit(0);
		}
		
		if(isset($ret_array['message']) && $ret_array['message'] == "Request does not match any route."){
			echo json_encode(array('success'=>false,'message'=>lang('items_sync_p4_inventory_failed')));
			exit(0);

		}else{

			$search_item_list = array();
			// if(count($ret_array) == 0){
			// 	//upc search
			// 	$url = "https://parts4cells.com/rest/all/V1/products?searchCriteria[filterGroups][0][filters][0][field]=upc&searchCriteria[filterGroups][0][filters][0][value]=".$search_key."&[filterGroups][0][filters][0][conditionType]=eq&searchCriteria[pageSize]=20&searchCriteria[currentPage]=1";
			// 	$curl = curl_init($url);
			// 	curl_setopt($curl, CURLOPT_URL, $url);
			// 	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				
			// 	$headers = array(
			// 	   "Accept: application/json",
			// 	   "Authorization: Bearer ".$this->config->item('p4_api_bearer_token'),
			// 	);
			// 	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			// 	//for debug only!
			// 	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			// 	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				
			// 	$resp = curl_exec($curl);
			// 	curl_close($curl);
			// 	// var_dump($resp);
			// 	$ret_array = json_decode($resp, true);
			// }

			if(!isset($ret_array['items'])){
				echo json_encode(array('success'=>false,'message'=>"API Error."));
				exit(0);
			}

			foreach($ret_array['items'] as $item_info){

				//there is a match add that item to the database and then add that same item to the sale
				$item_data = array(
					'name'=>$item_info['name'],
					'item_number'=>((isset($item_info['upc']) && $item_info['upc']) ? $item_info['upc'] : NULL),
					'cost_price'=>((isset($item_info['price']) && $item_info['price']) ? $item_info['price'] : 0),
					'unit_price'=>((isset($item_info['price']) && $item_info['price']) ? $item_info['price'] : 0),
					'product_id'=> $item_info['sku'],
				);

				if(isset($item_info['entity_id'])){
					$phppos_additional_item_numbers = array(
						"P4-".$item_info['entity_id']
					);
				}else{
					$phppos_additional_item_numbers = array();
				}

				$item_image = "";
				$item_description = "";
				if(isset($item_info['custom_attributes'])){
					foreach($item_info['custom_attributes'] as $item_attribute){
						if($item_attribute['attribute_code'] == "image"){
							$item_image = $item_attribute['value'];
						}
						if($item_attribute['attribute_code'] == "description"){
							$item_description = $item_attribute['value'];
						}
					}
				}
				$item_data['description'] = $item_description;

				$res = $this->Item->lookup_item_id($item_data['product_id'], array('item_id', 'item_number'));
				$search_item_id = false;
				if($res['status']){
					$search_item_id = $res['value'];
				}


				$new_item = 0;
				if($search_item_id == false){
					$new_item = 1;
				}
				$this->Item->save($item_data, $search_item_id);
				$res = $this->Item->lookup_item_id($item_data['product_id'], array('item_id', 'item_number'));
			
				if($res['status']){
					$search_item_id = $res['value'];
				}

				if($new_item == 1){

					$item_image_link = "https://parts4cells.com/media/catalog/product".$item_image;

					$image_contents = @file_get_contents($item_image_link);

					if ($image_contents)
					{
						$image_file_id = $this->Appfile->save(basename($item_image), $image_contents);
					}

					if (isset($image_file_id))
					{
						$this->Item->add_image($search_item_id, $image_file_id);
						$this->Item->set_main_image($search_item_id, $image_file_id);
					}

					//update category : skip now

					if(count($phppos_additional_item_numbers) > 0){
						//additional item number process
						$this->Additional_item_numbers->save($search_item_id, $phppos_additional_item_numbers);
					}

				}

				$this->set_supplier_item("Parts4cells", $search_item_id);

				$item_data1 = $this->Item->get_info($search_item_id, false);
				$item_data2 = array(
					'category' => null,
					'default_supplier' => [],
					'image' => $item_data1->main_image_id ?  cacheable_app_file_url($item_data1->main_image_id) : base_url()."assets/img/item.png",
					'quantity' => "Not set",
					'secondary_suppliers' => [],
					'supplier_name' => "Parts4cells",

					'item_number' => $item_data1->item_number,
					'cost_price'=>to_currency($item_data1->cost_price),
					'unit_price'=>to_currency($item_data1->unit_price),
					'label' => $item_data1->product_id." (".$item_data1->name.") - ".to_currency($item_data1->unit_price),
					'product_id'=>$item_data1->product_id,

					'value' => $search_item_id,
				);
				array_push($search_item_list, $item_data2);
			}

			echo json_encode(H($search_item_list));
		}
	}
	
	private function set_supplier_item($company_name, $item_id){

		$this->load->model('Supplier');

		$supplier_id = $this->Supplier->find_supplier_id($company_name);
		if(!$supplier_id){
			$person_data = array('first_name' => '', 'last_name' => '');
			$supplier_data = array('company_name' => $company_name);
			$this->Supplier->save_supplier($person_data, $supplier_data);
			$supplier_id = $this->Supplier->find_supplier_id($company_name);
		}

		if($supplier_id){
			$item_data = array('supplier_id' => $supplier_id);
			$this->Item->save($item_data, $item_id);
		}
	}

	function async_inventory_updates()
	{
		$async_updates = $_SESSION['async_inventory_updates'];
		unset($_SESSION['async_inventory_updates']);
		session_write_close();
		$this->load->model('Inventory');
		foreach($async_updates as $inventory_update)
		{
			$this->Inventory->insert($inventory_update);
		}
	}




	function delete_gallery_image(){
		$image_id = $this->input->post('id');
		$this->load->model('Appfile');
        $this->Appfile->delete($image_id);
        echo json_encode(array('success'=>true));
	}


	function gallery_upload(){
		
		$new_images = array();
		
		foreach($_FILES['file']['tmp_name'] as $key => $value) {
			$tempFile = $_FILES['file']['tmp_name'][$key];
			$fileName =  $_FILES['file']['name'][$key];
		    $image_file_id = $this->Appfile->save($fileName, file_get_contents($tempFile) , null , false , 1);
			$new_images[$image_file_id] = cacheable_app_file_url($image_file_id);
		}


		foreach($new_images as $key => $img){ ?>

<div class="col-md-6" id="img_cont_<?= $key; ?>">
                        <span class="svg-icon svg-icon-gray-800 svg-icon-2hx image-action"
                            data-placement="auto" data-toggle="popover" data-html="true" data-content="
											<div class='popover-header'>header</div>
												<div class='popover-body w-175px p-0'>
												<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<path opacity='0.3' d='M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z' fill='currentColor'/>
								<path d='M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z' fill='currentColor'/>
								</svg>
								</span>
													Insert into 
													<div class='d-flex gap-1'>
													<div class='popover-item btn btn-primary btn-xsm' onclick='insert_img(&#34;<?= cacheable_app_file_url($key); ?>&#34;, &#34;<?= $key; ?>&#34;, &#34;header&#34;)'>
														<!-- Insert Icon -->
													
														Header 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='insert_img(&#34;<?= cacheable_app_file_url($key); ?>&#34;, &#34;<?= $key; ?>&#34; , &#34;body&#34;)'>
													
														Body 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='insert_img(&#34;<?= cacheable_app_file_url($key); ?>&#34;, &#34;<?= $key; ?>&#34; , &#34;footer&#34;)'>
													
														Footer 
													</div>
					</div>
													<div class='popover-item '  onclick='set_bg(&#34;<?= cacheable_app_file_url($key); ?>&#34;, &#34;<?= $key; ?>&#34;)'>
														<!-- Set as Background Icon -->
														<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<rect opacity='0.3' x='2' y='2' width='20' height='20' rx='10' fill='currentColor'/>
								<path d='M15.8054 11.639C15.6757 11.5093 15.5184 11.4445 15.3331 11.4445H15.111V10.1111C15.111 9.25927 14.8055 8.52784 14.1944 7.91672C13.5833 7.30557 12.8519 7 12 7C11.148 7 10.4165 7.30557 9.80547 7.9167C9.19432 8.52784 8.88885 9.25924 8.88885 10.1111V11.4445H8.66665C8.48153 11.4445 8.32408 11.5093 8.19444 11.639C8.0648 11.7685 8 11.926 8 12.1112V16.1113C8 16.2964 8.06482 16.4539 8.19444 16.5835C8.32408 16.7131 8.48153 16.7779 8.66665 16.7779H15.3333C15.5185 16.7779 15.6759 16.7131 15.8056 16.5835C15.9351 16.4539 16 16.2964 16 16.1113V12.1112C16.0001 11.926 15.9351 11.7686 15.8054 11.639ZM13.7777 11.4445H10.2222V10.1111C10.2222 9.6204 10.3958 9.20138 10.7431 8.85421C11.0903 8.507 11.5093 8.33343 12 8.33343C12.4909 8.33343 12.9097 8.50697 13.257 8.85421C13.6041 9.20135 13.7777 9.6204 13.7777 10.1111V11.4445Z' fill='currentColor'/>
								</svg>
								</span>
														Set as Background
													</div>
													<div class='popover-item' onclick='delete_img(<?= $key; ?>)'>
														<!-- Delete Icon -->
														<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='22' height='22' viewBox='0 0 22 22' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<path opacity='0.3' d='M19.5997 3.52344H2.39639C2.09618 3.53047 1.8003 3.59658 1.52565 3.718C1.25101 3.83941 1.00298 4.01375 0.79573 4.23106C0.588484 4.44837 0.426087 4.70438 0.317815 4.98447C0.209544 5.26456 0.157521 5.56324 0.164719 5.86344C0.157521 6.16364 0.209544 6.46232 0.317815 6.74241C0.426087 7.0225 0.588484 7.27851 0.79573 7.49581C1.00298 7.71312 1.25101 7.88746 1.52565 8.00888C1.8003 8.1303 2.09618 8.19641 2.39639 8.20344H19.5997C19.8999 8.19641 20.1958 8.1303 20.4704 8.00888C20.7451 7.88746 20.9931 7.71312 21.2004 7.49581C21.4076 7.27851 21.57 7.0225 21.6783 6.74241C21.7866 6.46232 21.8386 6.16364 21.8314 5.86344C21.8386 5.56324 21.7866 5.26456 21.6783 4.98447C21.57 4.70438 21.4076 4.44837 21.2004 4.23106C20.9931 4.01375 20.7451 3.83941 20.4704 3.718C20.1958 3.59658 19.8999 3.53047 19.5997 3.52344Z' fill='currentColor' fill-opacity='0.8'/>
								<path d='M2.39453 8.20361L4.01953 18.3111C4.15644 19.145 4.58173 19.9043 5.22121 20.4567C5.8607 21.009 6.6738 21.3194 7.5187 21.3336H14.5712C15.4215 21.3202 16.2395 21.006 16.8801 20.4468C17.5207 19.8875 17.9424 19.1193 18.0704 18.2786L19.5979 8.20361H2.39453ZM9.28453 16.3178C9.28453 16.5333 9.19893 16.7399 9.04656 16.8923C8.89418 17.0447 8.68752 17.1303 8.47203 17.1303C8.25654 17.1303 8.04988 17.0447 7.89751 16.8923C7.74513 16.7399 7.65953 16.5333 7.65953 16.3178V12.4069C7.65953 12.1915 7.74513 11.9848 7.89751 11.8324C8.04988 11.68 8.25654 11.5944 8.47203 11.5944C8.68752 11.5944 8.89418 11.68 9.04656 11.8324C9.19893 11.9848 9.28453 12.1915 9.28453 12.4069V16.3178ZM14.322 16.3178C14.322 16.5333 14.2364 16.7399 14.0841 16.8923C13.9317 17.0447 13.725 17.1303 13.5095 17.1303C13.294 17.1303 13.0874 17.0447 12.935 16.8923C12.7826 16.7399 12.697 16.5333 12.697 16.3178V12.4069C12.697 12.1915 12.7826 11.9848 12.935 11.8324C13.0874 11.68 13.294 11.5944 13.5095 11.5944C13.725 11.5944 13.9317 11.68 14.0841 11.8324C14.2364 11.9848 14.322 12.1915 14.322 12.4069V16.3178Z' fill='currentColor' fill-opacity='0.8'/>
								<path d='M17.3895 4.87755C17.2529 4.87776 17.1185 4.84303 16.999 4.77667C16.8796 4.71031 16.7791 4.61452 16.707 4.49839L14.5945 1.24839C14.488 1.07063 14.4544 0.858502 14.5009 0.656521C14.5473 0.45454 14.6702 0.2784 14.8437 0.165055C15.0215 0.0626479 15.2311 0.0303209 15.4315 0.0744071C15.6319 0.118493 15.8086 0.235816 15.927 0.403388L18.0395 3.70755C18.1434 3.88599 18.1755 4.09728 18.1292 4.2985C18.0829 4.49972 17.9618 4.67577 17.7904 4.79089C17.6659 4.85225 17.5282 4.88202 17.3895 4.87755Z' fill='currentColor' fill-opacity='0.8'/>
								<path d='M4.49988 4.8885C4.34679 4.8928 4.19591 4.85131 4.06655 4.76933C3.89514 4.65422 3.77399 4.47817 3.72771 4.27694C3.68143 4.07572 3.71349 3.86443 3.81738 3.686L5.98405 0.435999C6.09739 0.262485 6.27353 0.13961 6.47551 0.0931545C6.6775 0.0466989 6.88962 0.0802727 7.06738 0.186832C7.23676 0.303623 7.35627 0.479597 7.40239 0.680101C7.4485 0.880606 7.41788 1.09111 7.31655 1.27017L5.20405 4.52017C5.12881 4.63747 5.0243 4.73313 4.90082 4.79773C4.77733 4.86232 4.63914 4.8936 4.49988 4.8885Z' fill='currentColor' fill-opacity='0.8'/>
								</svg>
								</span>
														Delete
													</div>
												</div>
											">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            </svg>
                        </span>
                        <div class="d-flex flex-center h-200px">
                            <img src="<?= cacheable_app_file_url($key); ?>"
                                class="lozad rounded mw-100 gallery-image" alt="" />
                        </div>
                    </div>


					<script>
                $(document).ready(function() {
                    $('[data-toggle="popover"]').popover(); // Initialize all popovers
                });

				function delete_img(id){
					$('#img_cont_'+id).remove();

					$.ajax({
						type: "POST",
						url: "<?= site_url('home/delete_gallery_image')?>",
						data: {
							id: id
						},
						success: function(data) {
							
						}
					});
				}
				</script>
		 <?php }
	}
	
}
?>
