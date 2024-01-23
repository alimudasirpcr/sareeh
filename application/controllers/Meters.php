<?php
require_once ("Secure_area.php");
require_once ("interfaces/Idata_controller.php");
class Meters extends Secure_area implements Idata_controller
{
	function __construct()
	{
		parent::__construct('meters');
		$this->module_access_check();
		$this->lang->load('meters');
		$this->lang->load('module');
		$this->load->model('Meter');		
		$this->load->model('Customer');	
		$this->load->helper('meters');	
		
	}

	function index($offset=0)
	{
		$params = $this->session->userdata('meters_search_data') ? $this->session->userdata('meters_search_data') : array('offset' => 0, 'order_col' => 'meter_number', 'order_dir' => 'asc', 'search' => FALSE,'deleted' => 0);
		if ($offset!=$params['offset'])
		{
		   redirect('meters/index/'.$params['offset']);
		}
		$this->check_action_permission('search');
		$config['base_url'] = site_url('meters/sorting');
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		
		$data['controller_name']=strtolower(get_class());
		$data['per_page'] = $config['per_page'];
		$data['search'] = $params['search'] ? $params['search'] : "";
		$data['deleted'] = $params['deleted'];
		
		if ($data['search'])
		{
			$config['total_rows'] = $this->Meter->search_count_all($data['search'],$params['deleted']);
			$table_data = $this->Meter->search($data['search'],$params['deleted'],$data['per_page'],$params['offset'],$params['order_col'],$params['order_dir']);
		}
		else
		{
			$config['total_rows'] = $this->Meter->count_all($params['deleted']);
			$table_data = $this->Meter->get_all($params['deleted'],$data['per_page'],$params['offset'],$params['order_col'],$params['order_dir']);
		}
		$this->load->library('pagination');$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['order_col'] = $params['order_col'];
		$data['order_dir'] = $params['order_dir'];
		$data['total_rows'] = $config['total_rows'];		
		$data['manage_table']=get_meters_manage_table($table_data,$this);
		$this->load->view('meters/manage',$data);
	}
	
	function sorting()
	{
		$this->check_action_permission('search');
		$params = $this->session->userdata('meters_search_data');
		$search=$this->input->post('search') ? $this->input->post('search') : "";
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;

		$offset = $this->input->post('offset') ? $this->input->post('offset') : 0;
		$order_col = $this->input->post('order_col') ? $this->input->post('order_col') : 'meter_number';
		$order_dir = $this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc';
		$deleted = $this->input->post('deleted') ? $this->input->post('deleted'): $params['deleted'];

		$meters_search_data = array('offset' => $offset, 'order_col' => $order_col, 'order_dir' => $order_dir, 'search' => $search,'deleted' => $deleted);
		$this->session->set_userdata("meters_search_data",$meters_search_data);

		if ($search)
		{
			$config['total_rows'] = $this->Meter->search_count_all($search,$deleted);
			$table_data = $this->Meter->search($search,$deleted,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'meter_number' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Meter->count_all($deleted);
			$table_data = $this->Meter->get_all($deleted,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'meter_number' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('meters/sorting');
		$config['per_page'] = $per_page; 
		$this->load->library('pagination');$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_Meters_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination'],'total_rows' => $config['total_rows']));	
	}

	function clear_state()
	{
		$params = $this->session->userdata('meters_search_data');
		$this->session->set_userdata('meters_search_data', array('offset' => 0, 'order_col' => 'meter_number', 'order_dir' => 'asc', 'search' => FALSE,'deleted' => $params['deleted']));
		redirect('meters');
	}
	
	function excel()
	{
		$this->load->helper('report');
		$header_row = $this->_excel_get_header_row();
		$this->load->helper('spreadsheet');
		array_to_spreadsheet(array($header_row),'meters_import.'.($this->config->item('spreadsheet_format') == 'XLSX' ? 'xlsx' : 'csv'));
	}

	function _excel_get_header_row()
	{
		return array(lang('meters_meter_number'),lang('common_description'),lang('meters_card_value'), lang('common_inactive'), lang('common_customer'));
	}
	/* added for excel expert */
	function excel_export() {
		$this->check_action_permission('excel_export');
		ini_set('memory_limit','1024M');
		set_time_limit(0);
		ini_set('max_input_time','-1');
		
		
		$params = $this->session->userdata('meters_search_data') ? $this->session->userdata('meters_search_data') : array('offset' => 0, 'order_col' => 'meter_number', 'order_dir' => 'asc', 'search' => FALSE,'deleted' => 0);
		
		$search = $params['search'] ? $params['search'] : "";
		
		//Filter based on search
		if ($search)
		{
			$data = $this->Meter->search($search,$params['deleted'],$this->Meter->search_count_all($search),0,$params['order_col'],$params['order_dir'])->result_object();
		}
		else
		{
			$data = $this->Meter->get_all($params['deleted'])->result_object();
		}
		$this->load->helper('report');
		$rows = array();
		$rows[] = $this->_excel_get_header_row();
		foreach ($data as $r) {
			$row = array(
				$r->meter_number,
				$r->description,
				to_currency_no_money($r->value),
				$r->inactive ? 'y' : '',
				$r->full_name,
			);
			$rows[] = $row;
		}
		
		$this->load->helper('spreadsheet');
		array_to_spreadsheet($rows,'meters_export.'.($this->config->item('spreadsheet_format') == 'XLSX' ? 'xlsx' : 'csv'));
	}

	/**
	 * @Loads the form for customers excel import
     */
	function excel_import()
	{
		$this->check_action_permission('add_update');
		$this->load->view("meters/excel_import", null);
	}

	/**
	 * @imports gift cards
	 * imports as new if gift card number is not found
     */
	function do_excel_import()
	{
		ini_set('memory_limit','1024M');
		$this->load->helper('demo');
		$employee_info = $this->Employee->get_logged_in_employee_info();

		set_time_limit(0);
		ini_set('max_input_time','-1');
		$this->check_action_permission('add_update');
		$this->db->trans_start();

		$msg = 'do_excel_import';
		$failCodes = array();
		if ($_FILES['file_path']['error']!=UPLOAD_ERR_OK)
		{
			$msg = lang('common_excel_import_failed');
			echo json_encode( array('success'=>false,'message'=>$msg) );
			$this->db->trans_complete();
			return;
		}
		else
		{
			if (($handle = fopen($_FILES['file_path']['tmp_name'], "r")) !== FALSE)
			{
				$this->load->helper('spreadsheet');
				$file_info = pathinfo($_FILES['file_path']['name']);
				$sheet = file_to_spreadsheet($_FILES['file_path']['tmp_name'],$file_info['extension']);
				$num_rows = $sheet->getNumberOfRows();

				//Loop through rows, skip header row
				for($k = 2;$k<=$num_rows; $k++)
				{
					$meter_number = $sheet->getCellByColumnAndRow(0, $k);
					if (!$meter_number)
					{
						$meter_number = '';
					}


					$meter_description = $sheet->getCellByColumnAndRow(1, $k);
					if (!$meter_description)
					{
						$meter_description = '';
					}

					$value = $sheet->getCellByColumnAndRow(2, $k);
					
					$meter_id = $this->Meter->get_meter_id($meter_number);
					
					$current_meter = $this->Meter->get_info($meter_id);
					$old_meter_value = $current_meter->value;
					
					$inactive = $sheet->getCellByColumnAndRow(3, $k);
					$inactive = ($inactive == 'y' || $inactive == '1') ? '1' : '0';
					
					$customer_person_id = NULL;
					
					$customer_full_name = $sheet->getCellByColumnAndRow(4, $k);
					
					$g_customer_info = $this->Customer->get_info_by_name($customer_full_name);
					if ($g_customer_info && $g_customer_info->person_id)
					{
						$customer_person_id = $g_customer_info->person_id;
					}
					
					//If we don't have a gift card number skip the import
					if (!$meter_number)
					{
						continue;
					}
					
					$meter_data = array(
					'meter_number'=>$meter_number,
					'description' => $meter_description,
					'value'=>$value,
					'inactive'=>$inactive,
					'customer_id' => $customer_person_id,
					);

					if(!$this->Meter->save( $meter_data, $meter_id ? $meter_id : FALSE))
					{
						echo json_encode( array('success'=>false,'message'=>lang('meters_duplicate_meter')));
						return;
					}
					
					$keyword = '';
					if ($meter_id)
					{
						$keyword = $value > $old_meter_value ? lang('meters_added') : lang('meters_removed');
					}
					
					if ($old_meter_value != $meter_data['value'])
					{
						$this->Meter->log_modification(array("number" => $meter_data['meter_number'], "person"=>$employee_info->first_name . " " . $employee_info->last_name, "new_value" => $meter_data['value'],'keyword' => $keyword, 'old_value' => $old_meter_value, "type" => $meter_id ? 'update' : 'create'));
					}
				}
			}
			else
			{
				echo json_encode( array('success'=>false,'message'=>lang('common_upload_file_not_supported_format')));
				return;
			}
		}
		$this->db->trans_complete();
		echo json_encode(array('success'=>true,'message'=>lang('meters_import_success')));
	}

	function search()
	{
		$this->check_action_permission('search');
		$params = $this->session->userdata('meters_search_data');
		
		$search=$this->input->post('search');
		$offset = $this->input->post('offset') ? $this->input->post('offset') : 0;
		$order_col = $this->input->post('order_col') ? $this->input->post('order_col') : 'meter_number';
		$order_dir = $this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc';
		$deleted = $this->input->post('deleted') ? $this->input->post('deleted') : $params['deleted'];
		
		$meters_search_data = array('offset' => $offset, 'order_col' => $order_col, 'order_dir' => $order_dir, 'search' => $search,'deleted' => $deleted);
		$this->session->set_userdata("meters_search_data",$meters_search_data);
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->Meter->search($search,$deleted,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'meter_number' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('meters/search');
		$config['total_rows'] = $this->Meter->search_count_all($search,$deleted);
		$config['per_page'] = $per_page ;
		
		$this->load->library('pagination');$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_meters_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination'],'total_rows' => $config['total_rows']));
		
	}
	
	

	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		//allow parallel searchs to improve performance.
		session_write_close();
		$params = $this->session->userdata('meters_search_data') ? $this->session->userdata('meters_search_data') : array('deleted' => 0);
		$suggestions = $this->Meter->get_search_suggestions($this->input->get('term'),$params['deleted'],100);
		echo json_encode(H($suggestions));
	}
	
	/*
	Gives search suggestions for customer based on what is being searched for
	*/
	function suggest_customer()
	{
		//allow parallel searchs to improve performance.
		session_write_close();
		$suggestions = $this->Customer->get_customer_search_suggestions($this->input->get('term'),0,100);
		echo json_encode(H($suggestions));
	}
	
	
	function clone_meter($meter_id)
	{
		$this->check_action_permission('add_update');
		$data = $this->_get_meter_data($meter_id);
		$data['redirect']=2;
		//Unset unique identifiers
		$data['meter_info']->meter_number = '';
		$data['is_clone'] = TRUE;
		$this->load->view("meters/form",$data);
	}
	
	function _get_meter_data($meter_id)
	{
		$data = array();		
		$data['meter_info']=$this->Meter->get_info($meter_id);
		
		if ($data['meter_info']->customer_id)
		{
			$customer = $this->Customer->get_info($data['meter_info']->customer_id);			
			$data['selected_customer_name'] = $customer->first_name . ' '. $customer->last_name;
		}			
								
		$logs = '<ul class="list-group">';
		foreach($this->Meter->get_meter_log($meter_id) as $row)
		{			
			
			$row->log_message = strip_tags($row->log_message);
			$row->log_message = preg_replace('/'.$this->config->item('sale_prefix').' ([0-9]+)/', anchor('sales/receipt/$1', $this->config->item('sale_prefix').' $1'), $row->log_message);
			if($row->transaction_amount <=0)
			{
				
				$logs.= '<li class="list-group-item list-group-item-danger">'.date(get_date_format(). ' '.get_time_format(), strtotime($row->log_date)).' '.$row->log_message.'</li>';
			}
			else
			{
				$logs.= '<li class="list-group-item list-group-item-success">'.date(get_date_format(). ' '.get_time_format(), strtotime($row->log_date)).' '.$row->log_message."</li>";
			}
		}
		$logs.= '</ul>';
		$data['meter_logs']=$logs;
		
		return $data;
		
	}
	

	function view($meter_id=-1,$redirect=0)
	{
		$this->check_action_permission('add_update');
		$data = $this->_get_meter_data($meter_id);
		$data['redirect']= $redirect;
		$data['meter_id'] = $meter_id;
		$this->load->view("meters/form",$data);
	}
	
	function meter_exists()
	{
		if($this->Meter->get_meter_id($this->input->post('description') ? $this->input->post('description') : $this->input->post('meter_number'), TRUE))
		echo 'false';
		else
		echo 'true';
		
	}
		
	function save($meter_id=-1)
	{
		$employee_info = $this->Employee->get_logged_in_employee_info();
		$current_meter = $this->Meter->get_info($meter_id);
		$old_meter_value = $current_meter->value;

		$meter_data = array(
		'meter_number'=>$this->input->post('meter_number'),
		'value'=>$this->input->post('value'),
		'description'=>$this->input->post('description'),
		'customer_id'=>$this->input->post('customer_id')=='' ? null:$this->input->post('customer_id'),
		'inactive'=>$this->input->post('inactive') ? 1:0,
		'integrated_gift_card'=>$this->input->post('integrated_gift_card') ? 1:0,
		'integrated_auth_code' => $this->input->post('integrated_auth_code') ? $this->input->post('integrated_auth_code') : NULL,
		);
		
		
		$redirect=$this->input->post('redirect');
		if( $this->Meter->save( $meter_data, $meter_id ) )
		{
			$success_message = '';
			
			if($meter_id==-1)
			{
				$this->Meter->log_modification(array("number" => $meter_data['meter_number'], "person"=>$employee_info->first_name . " " . $employee_info->last_name, "new_value" => $meter_data['value'], 'old_value' => $old_meter_value, "type" => 'create'));
				$meter_id = $meter_data['meter_id'];

				$success_message = H(lang('meters_successful_adding').' '.$meter_data['meter_number']);
				echo json_encode(array('success'=>true,'message'=>$success_message,'meter_id'=>$meter_data['meter_id']));				
			}
			else //previous meter
			{
				if($meter_data['value'] > $old_meter_value)
				{
					$this->Meter->log_modification(array("number" => $meter_data['meter_number'], "person"=>$employee_info->first_name . " " . $employee_info->last_name, "new_value" => $meter_data['value'], 'old_value' => $old_meter_value, "type" => "update", "keyword" => lang('meters_added')));
					
				}
				else if($meter_data['value'] < $old_meter_value)
				{	
					$this->Meter->log_modification(array("number" => $meter_data['meter_number'], "person"=>$employee_info->first_name . " " . $employee_info->last_name, "new_value" => $meter_data['value'], 'old_value' => $old_meter_value, "type" => "update", "keyword" => lang('meters_removed')));
					
				}
				
				$success_message = H(lang('meters_successful_updating').' '.$meter_data['meter_number']);
				$this->session->set_flashdata('manage_success_message', $success_message);
				
				echo json_encode(array('success'=>true,'message'=>$success_message,'meter_id'=>$meter_id,'redirect' => $redirect));
			}			
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('meters_error_adding_updating').' '.
			H($meter_data['meter_number']),'meter_id'=>-1));
		}

	}

	function delete()
	{
		$this->check_action_permission('delete');		
		$meters_to_delete=$this->input->post('ids');

		if($this->Meter->delete_list($meters_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>lang('meters_successful_deleted').' '.
			count($meters_to_delete).' '.lang('meters_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('meters_cannot_be_deleted')));
		}
	}
	
	function undelete()
	{
		$this->check_action_permission('delete');		
		$meters_to_undelete=$this->input->post('ids');

		if($this->Meter->undelete_list($meters_to_undelete))
		{
			echo json_encode(array('success'=>true,'message'=>lang('meters_successful_undeleted').' '.
			count($meters_to_undelete).' '.lang('meters_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('meters_cannot_be_undeleted')));
		}
	}
	

	function generate_barcodes($meter_ids, $skip=0)
	{
		$result = array();

		$meter_ids = explode('~', $meter_ids);
		foreach ($meter_ids as $meter_id)
		{
			$meter_info = $this->Meter->get_info($meter_id);
			$result[] = array('name' =>$meter_info->meter_number. ': '.to_currency($meter_info->value, 10), 'id'=> $meter_info->meter_number);
		}

		$data['items'] = $result;
		$data['scale'] = 1;
		$data['skip'] = $skip;
		$this->load->view("barcode_sheet", $data);
	}
	
	function generate_barcode_labels($meter_ids)
	{
		$result = array();

		$meter_ids = explode('~', $meter_ids);
		foreach ($meter_ids as $meter_id)
		{
			$meter_info = $this->Meter->get_info($meter_id);
			$result[] = array('name' =>$meter_info->meter_number. ': '.to_currency($meter_info->value, 10), 'id'=> $meter_info->meter_number);
		}

		$data['items'] = $result;
		$data['scale'] = 1;
		$this->load->view("barcode_labels", $data);
	}
	
	function save_item($item_id=-1)
	{
		$this->load->model('Item');
		$this->load->model('Category');
		$this->check_action_permission('add_update');		
		$item_data = array(
		'deleted' => 0,
		'name'=>$this->input->post('name'),
		'description'=>$this->input->post('description'),
		'tax_included'=>$this->input->post('tax_included') ? $this->input->post('tax_included') : 0,
		'category_id'=> $this->Category->save(lang('common_meter'), TRUE, NULL, $this->Category->get_category_id(lang('common_meter'))),
		'size'=>$this->input->post('size'),
		'supplier_id'=>$this->input->post('supplier_id')=='' ? null:$this->input->post('supplier_id'),
		'item_number'=>$this->input->post('item_number')=='' ? null:$this->input->post('item_number'),
		'product_id'=>$this->input->post('product_id')=='' ? null:$this->input->post('product_id'),
		'cost_price'=>$this->input->post('cost_price'),
		'unit_price'=>$this->input->post('unit_price'),
		'promo_price'=>$this->input->post('promo_price') ? $this->input->post('promo_price') : NULL,
		'start_date'=>$this->input->post('start_date') ? date('Y-m-d', strtotime($this->input->post('start_date'))) : NULL,
		'end_date'=>$this->input->post('end_date') ?date('Y-m-d', strtotime($this->input->post('end_date'))) : NULL,
		'reorder_level'=>$this->input->post('reorder_level')!='' ? $this->input->post('reorder_level') : NULL,
		'is_service'=>$this->input->post('is_service') ? $this->input->post('is_service') : 0 ,
		'allow_alt_description'=>$this->input->post('allow_alt_description') ? $this->input->post('allow_alt_description') : 0 ,
		'is_serialized'=>$this->input->post('is_serialized') ? $this->input->post('is_serialized') : 0,
		'system_item'=>$this->input->post('system_item') ? $this->input->post('system_item') : 0,
		'override_default_tax'=> $this->input->post('override_default_tax') ? $this->input->post('override_default_tax') : 0,
		'is_ecommerce' => 0,
		'disable_loyalty' => $this->input->post('disable_loyalty') ? $this->input->post('disable_loyalty') : 0,
		);
		

		$redirect=$this->input->post('redirect');
		$sale_or_receiving=$this->input->post('sale_or_receiving');

		if($this->Item->save($item_data,$item_id))
		{
			//New item
			if($item_id==-1)
			{				
				echo json_encode(array('success'=>true,'message'=>lang('common_successful_adding').' '.
				H($item_data['name']),'item_id'=>$item_data['item_id'],'redirect' => $redirect, 'sale_or_receiving'=>$sale_or_receiving));
				$item_id = $item_data['item_id'];
			}
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>lang('common_items_successful_updating').' '.
				H($item_data['name']),'item_id'=>$item_id,'redirect' => $redirect, 'sale_or_receiving'=>$sale_or_receiving));
			}			
		}
		else //failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('common_error_adding_updating').' '.
			H($item_data['name']),'item_id'=>-1));
		}

	}
	
	function toggle_show_deleted($deleted=0)
	{
		$this->check_action_permission('search');
		
		$params = $this->session->userdata('meters_search_data') ? $this->session->userdata('meters_search_data') : array('offset' => 0, 'order_col' => 'meter_number', 'order_dir' => 'asc', 'search' => FALSE,'deleted' => 0);
		$params['deleted'] = $deleted;
		$params['offset'] = 0;
		
		$this->session->set_userdata("meters_search_data",$params);
	}
	
	function cleanup()
	{
		$this->Meter->cleanup();
		echo json_encode(array('success'=>true,'message'=>lang('meters_cleanup_sucessful')));
	}
	
	function issue_integrated_meter()
	{
		$value = $this->input->post('value');
		$manually_enter_card = $this->input->post('manually_enter_card');
		
		$processor = get_meter_processor();
		
		echo $processor->issue_integrated_meter($value,$manually_enter_card);
		
	}
	
	function void_issue_integrated_meter()
	{
		$value = $this->input->post('value');
		$auth_code = $this->input->post('auth_code');
		$manually_enter_card = $this->input->post('manually_enter_card');
		
		$processor = get_meter_processor();
		
		echo $processor->void_issue_integrated_meter($value,$auth_code,$manually_enter_card);
	}
	
	function sale_integrated_meter()
	{
		$sale_value = $this->input->post('sale_value');
		$manually_enter_card = $this->input->post('manually_enter_card');
		
		$processor = get_meter_processor();
		
		echo $processor->sale_integrated_meter($sale_value,$manually_enter_card);
	}
	
	function reload_integrated_meter()
	{
		$reload_amount = $this->input->post('reload_amount');
		$manually_enter_card = $this->input->post('manually_enter_card');
		
		$processor = get_meter_processor();
		
		echo $processor->reload_integrated_meter($reload_amount,$manually_enter_card);
	}
	
}
?>