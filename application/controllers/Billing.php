<?php


class Billing extends CI_Controller
{
   
	function __construct()
	{
		parent::__construct();
        $this->load->model('meterreading');
        $this->load->model('captcha');
	}
    function index(){
        $data = array();
     
        if(isset($_GET['search'])){
            if($this->config->item('customized_receipt')){

                $expiration = time() - 7200; // Two hour limit
                $this->db->where('captcha_time < ', $expiration)
                        ->delete('captcha');

                // Then see if a captcha exists:
                $sql = 'SELECT COUNT(*) AS count FROM phppos_captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
                $binds = array($_GET['captcha'], $this->input->ip_address(), $expiration);
                $query = $this->db->query($sql, $binds);
                $row = $query->row();
                // $row->count =1;
                if ($row->count == 0)
                {
                    $cap = $this->captcha->create_captcha();
                    $data['cap'] = $cap;
                        $msg =  lang('wrong_captcha');
                        $messge = array('message' => $msg ,'class' => 'alert alert-danger fade in');
                        $this->session->set_flashdata('item', $messge);
                        $this->load->view('billing/index',$data);
                }else{
                    $query = $this->db->query("select * from phppos_receipts_template where default_public=1 ");
                    if(isset($query->result_array()[0])){
                        $data['receipt_pos'] =	$query->result_array()[0];
    
                        $res = $this->meterreading->search_single($_GET['search']);
                        if($res){
                            $data['meter_data'] = $res;
                      
                            $this->load->view('billing/receipt',$data);
                        }else{
                            $cap = $this->captcha->create_captcha();
                            $data['cap'] = $cap;
                            $messge = array('message' => lang('record_does_not_exist').': '.$_GET['search'],'class' => 'alert alert-danger fade in');
                            $this->session->set_flashdata('item', $messge);
                            $this->load->view('billing/index',$data);
                        }
                        
                    }else{
                        $cap = $this->captcha->create_captcha();
                        $data['cap'] = $cap;
                        $messge = array('message' => lang('Technical_issue_please_contact_admin'),'class' => 'alert alert-warning fade in');
                        $this->session->set_flashdata('item', $messge);
                        $this->load->view('billing/index',$data);
                    }
                }


				
				
			}
          
        }else{
            
            $cap = $this->captcha->create_captcha();
            $data['cap'] = $cap;

            $this->load->view('billing/index',$data);
        }
       
    }
}


?>