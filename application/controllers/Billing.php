<?php


class Billing extends CI_Controller
{
   
	function __construct()
	{
		parent::__construct();
        $this->load->model('meterreading');
	}
    function index(){
        $data = array();
        if(isset($_GET['search'])){
            if($this->config->item('customized_receipt')){
				
				$query = $this->db->query("select * from phppos_receipts_template where id=7 ");
				if(isset($query->result_array()[0])){
					$data['receipt_pos'] =	$query->result_array()[0];

                    $res = $this->meterreading->search_single($_GET['search']);
                    if($res){
                        $data['meter_data'] = $res;
                  
                        $this->load->view('billing/receipt',$data);
                    }else{
                        $this->load->view('billing/index',$data);
                    }
                    
				}else{
					$this->load->view('billing/index',$data);
				}
			}
          
        }else{
            $this->load->view('billing/index',$data);
        }
       
    }
}


?>