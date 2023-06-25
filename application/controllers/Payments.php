<?php
require_once ("Secure_area.php");
require_once (APPPATH."models/cart/PHPPOSCartRecv.php");
require_once (APPPATH."traits/taxOverrideTrait.php");
class Payments extends Secure_area
{
	// function __construct()
	// {
	// 	parent::__construct('plans');
	// 	$this->lang->load('plans');
	// 	$this->lang->load('module');
	// 	$this->load->model('Plans_model');
	// }
	
    public function index(){
 
        $result['payments']  =  get_query_data("select * from phppos_payments order by id desc" , 'array');
   
        $result['invoices'] = get_query_data("select * from phppos_invoice where status=0 order by id desc");
	
		$this->load->view('payments/list',$result);

    }

    public function pay_thawani($id){
        create_thawani_session($id);
    }

    public function check_for_invoices(){
        check_for_invoices_erp();
    }

    public function success(){
		if ($this->session->has_userdata('thawani_session_id')) {
			// Session variable exists
			 $session_id = $this->session->userdata('thawani_session_id');
			 save_thwani_session($session_id);
             $this->session->set_flashdata('success','Payment Successfully completed');
             redirect('payments');
		}
	}
	public function cancel(){
		//payment cancel
            $this->session->set_flashdata('error','Payment has been  canceled please try again');
             redirect('payments');
	}

}