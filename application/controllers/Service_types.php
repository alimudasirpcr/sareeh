<?php
require_once ("Secure_area.php");
require_once (APPPATH."models/cart/PHPPOSCartRecv.php");
require_once (APPPATH."traits/taxOverrideTrait.php");
class Service_types extends Secure_area
{
	// function __construct()
	// {
	// 	parent::__construct('plans');
	// 	$this->lang->load('plans');
	// 	$this->lang->load('module');
	// 	$this->load->model('Plans_model');
	// }
	
    public function index(){
		$result['rec'] = get_query_data('select * from phppos_service_types');
        // echo "<pre>";
        // print_r($rec );
        // exit();

		$this->load->view('service_types/index',$result);
	

    }

    public function save_service_types(){
        $d =  save_data('phppos_service_types' , ['title' => $this->input->post('title') , 'status' =>$this->input->post('status')  ]);
        echo $d;
    }

    public function get_service_types(){
        $rec =  get_query_data('select * from  phppos_service_types where id='.$this->input->post('id').' ' , 'array');
        if($rec){
            echo json_encode(['status' => true , 'data' => $rec[0] ]);
        }else{
            echo json_encode(['status'=> false]);
        }
        
    }

    public function update_service_types(){
        $r = update_data('phppos_service_types' , ['title' => $this->input->post('title') , 'status' => (int) $this->input->post('status')  ] , (int) $this->input->post('id'));
      
        echo true;
    }

    public function delete_item(){
        $id = $this->input->post('id');
        delete_data('phppos_service_types' , $id);
        echo true;
    }
}