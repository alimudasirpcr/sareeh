<?php
require_once ("Secure_area.php");
class Receipt extends Secure_area 
{
	public $log_text = '';

	function _log($msg)
	{
		$msg = date(get_date_format().' h:i:s ').': '.$msg."\n"; 
		if (is_cli())
		{
			echo $msg;
		}
		$this->log_text.=$msg;
	}

	function _save_log()
	{
		$CI =& get_instance();	
		$CI->load->model("Appfile");
		$this->Appfile->save('quickbooks_log.txt',$this->log_text,'+72 hours');
	}

	function __construct()
	{
		parent::__construct('receipt');
		$this->module_access_check();
		$this->lang->load('config');
		$this->lang->load('module');	
		$this->load->model('Appfile');	
		$this->load->model('Sale');
		$this->load->model('License_lib');
	}

    public function index(){
		//  $result = get_query_data('SELECT GROUP_CONCAT(module_id) AS module_ids FROM phppos_modules');

		//  echo "<pre>";
		// 	print_r($result);
		//  exit();
		// $this->load->library('License_lib');
		 // $res = $this->License_lib->generate_license(1);
		//  $res = $this->License_lib->check_license();
		//   echo "<pre>";
		//   print_r($res);
		//   exit();
		$query = $this->db->query("select * from phppos_receipts_template");
		$data['receipts'] = $query->result_array();
		$this->load->view("customize_receipts", $data);
	}

	public function customize_receipt($id){
		$query = $this->db->query("select * from phppos_receipts_template where id=".$id." ");
		$data['receipt'] = $query->result_array()[0];
		$this->load->view("customize_receipt", $data);
	}

	public function update_receipt(){
		$tables = $this->input->post('tables');
		$recp = $this->input->post('receipt');
		update_data('phppos_receipts_template', ['positions' =>$tables] , $recp );
		echo "true";
	}

	public function submitForm(){
		$title = $this->input->post('title');
		save_data('phppos_receipts_template', ['title' =>$title]  );
		echo json_encode(['success' => true]);
	}

	public  function delete(){
		$id = $this->input->post('form_id');
		delete_data('phppos_receipts_template',$id);
		echo json_encode(['success' => true]);
	}

}