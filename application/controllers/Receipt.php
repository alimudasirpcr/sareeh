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

	public function update_receipt_detail(){

		$custom_logo='';
		if(!empty($_FILES["custom_logo"]) && $_FILES["custom_logo"]["error"] == UPLOAD_ERR_OK  )
		{
			$allowed_extensions = array('png', 'jpg', 'jpeg', 'gif');
			$extension = strtolower(pathinfo($_FILES["custom_logo"]["name"], PATHINFO_EXTENSION));
			
			if (in_array($extension, $allowed_extensions))
			{
				$config['image_library'] = 'gd2';
				$config['source_image']	= $_FILES["custom_logo"]["tmp_name"];
				$this->load->library('image_lib', $config); 
				
				$custom_logo = $this->Appfile->save($_FILES["custom_logo"]["name"], file_get_contents($_FILES["custom_logo"]["tmp_name"]), NULL, $this->input->post('delete_custom_logo'));
			}
		}
		$background_image='';
		if(!empty($_FILES["background_image"]) && $_FILES["background_image"]["error"] == UPLOAD_ERR_OK )
		{
			$allowed_extensions = array('png', 'jpg', 'jpeg', 'gif');
			$extension = strtolower(pathinfo($_FILES["background_image"]["name"], PATHINFO_EXTENSION));
			
			if (in_array($extension, $allowed_extensions))
			{
				$config['image_library'] = 'gd2';
				$config['source_image']	= $_FILES["background_image"]["tmp_name"];
				$this->load->library('image_lib', $config); 
				
				$background_image = $this->Appfile->save($_FILES["background_image"]["name"], file_get_contents($_FILES["background_image"]["tmp_name"]), NULL, $this->input->post('delete_background_image'));
			}
		}
		$title = $this->input->post('title');
		$size = $this->input->post('size');
		$width = $this->input->post('width');
		$height = $this->input->post('height');
		$custom_text = $this->input->post('custom_text');
		$default_wo = $this->input->post('default_wo');
		$default_pos = $this->input->post('default_pos');
		$default_estimate = $this->input->post('default_estimate');
		$id = $this->input->post('id');
		 $data= array(
			'title' =>$title,
			'size' =>$size,
			'width' =>$width,
			'height' =>$height,
			'custom_text' =>$custom_text,
			'default_wo' =>$default_wo,
			'default_pos' =>$default_pos,
			'default_estimate' =>$default_estimate,
		 );
		 if($custom_logo!=''){
			$data['logo_image'] =$custom_logo;
		 }
		 if($background_image!=''){
			$data['background_image'] =$background_image;
		 }
		update_data('phppos_receipts_template', 
		$data, $id );
		redirect('Receipt/customize_receipt/'.$id);
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