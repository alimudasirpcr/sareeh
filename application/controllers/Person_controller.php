<?php
require_once ("interfaces/Iperson_controller.php");
require_once ("Secure_area.php");

abstract class Person_controller extends Secure_area implements iPerson_controller
{
	function __construct($module_id=null)
	{
		parent::__construct($module_id);		
	}
	
	/*
	This returns a mailto link for persons with a certain id. This is called with AJAX.
	*/
	function mailto()
	{
		$people_to_email=$this->input->post('ids');
		
		if($people_to_email!=false)
		{
			$mailto_url='';
			foreach($this->Person->get_multiple_info($people_to_email)->result() as $person)
			{
				if ($person->email &&  $person->email!='')
				{
					$mailto_url.=$person->email.',';	
				}
			}
			//remove last comma
			$mailto_url=substr($mailto_url,0,strlen($mailto_url)-1);
			if($mailto_url!=''){
				$mailto_url='mailto:'.$mailto_url;
			}else{
				$mailto_url = 'javascript:void(0);';
			}
			
			echo $mailto_url;
			exit;
		}
		echo 'javascript:void(0);';
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
	
	function delete_file($file_id)
	{
		$this->check_action_permission('add_update');
		$this->Person->delete_file($file_id);
	}

	function add_title(){
		$title = $this->input->post("title");
		$search_result = $this->Person->search_title($title);
		if($search_result){
			echo json_encode(array('success'=>false, 'message'=>lang('title_already_exists')));
			exit();
		}

		$ret = $this->Person->add_title($title);
		if($ret){
			echo json_encode(array('success'=>true, 'value'=>$ret, 'message'=>lang('title_successful_added')));
			exit();
		}
		echo json_encode(array('success'=>false, 'message'=>lang('title_error_adding_updating')));
	}
}
?>