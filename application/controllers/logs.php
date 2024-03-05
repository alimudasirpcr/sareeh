<?php
require_once ("Secure_area.php");

require_once (APPPATH."libraries/google2fa/vendor/autoload.php");
require_once (APPPATH."libraries/bacon-qr-code/vendor/autoload.php");

use PragmaRX\Google2FAQRCode\Google2FA;

class Logs extends Secure_area 
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
        $this->load->model('Work_order');
        $this->load->model('Message');
		$this->load->model('Employee');
		$this->load->model('Giftcard');
		$this->load->model('Log');
		$this->load->helper('cloud');
		$this->load->helper('text');
		$this->load->model('Appfile');
	}
	
    function index()
	{	
        $data = array();
		$types = array('-1' => lang('all') , 'work_order' => 'work_order' , 'sn_log' =>'sn_log','register_log' =>'register_log' );
		$data['types'] = $types;
		$data['type'] = -1;

		$employees = array('-1' => lang('all'));

		foreach($this->Employee->get_all(0,10000,0,'first_name')->result() as $employee)
		{
			$employees[$employee->full_name] = $employee->full_name ;
		}
		$data['employees'] = $employees;

		$data['employee'] = -1;
        $this->load->view("logs/log" , $data);
    }

    public function ajaxList() {
        $input = $this->input->post();
        $tableName = 'log';
        $columns = get_table_columns($tableName);
		$columns['default_order'] = ['created_at' => 'desc'];	
		
        $list = $this->Log->getDatatable($tableName, $columns, $input);
        // dd($list);
        $data = [];
        foreach ($list as $item) {
			$row = [];
			foreach ($columns as $col => $val) {
				// Skip 'default_order' when assembling rows
				if ($col === 'default_order') {
					continue;
				}
				if ($col === 'comment' && $item->type=='register_log'  ) {
					 $dates = explode('==', $item->$col);
					 $item->$col = "Shift from:".date('d M Y h:i A', strtotime($dates[0]))." to:".date('d M Y h:i A', strtotime($dates[1]));
					// $item->$col ='testing';
				// 	$item->$col = '<a href="http://localhost/sareeh/sales/receipt/'.$item->$col.'" target="_blank">POS '.$item->$col.'</a>';
				}elseif ($col === 'comment' && $item->type=='work_order'  ) {
					$item->$col =  $this->work_order->transform_activity_text($item->$col);
				}elseif ($col === 'main_id' && $item->type=='work_order'  ) {
					$item->$col = '<a href="'.site_url('work_orders/view/'.$item->$col.'').'?form_id=edit" target="_blank">POS '.$item->$col.'</a>';
				}
				

				$row[$col] = isset($item->$col) ? $item->$col : null; // Safely access property, provide default value if not set
			}
			$data[] = $row;
		}
	
        $output = [
            "draw" => $input['draw'],
            "recordsTotal" =>  $this->Log->countAll($tableName),
            "recordsFiltered" => $this->Log->countFiltered($tableName, $columns, $input),
            "data"=>$data
        ];

        echo json_encode($output);
    }
}