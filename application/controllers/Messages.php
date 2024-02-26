<?php
require_once ("Secure_area.php");
class Messages extends Secure_area 
{
	function __construct()
	{
		parent::__construct('messages');
		$this->module_access_check();	
		$this->load->model('Message');
		$this->lang->load('messages');
		$this->lang->load('module');		
		
	}
	
	function index($offset = 0)
	{
		$config['base_url'] = site_url('messages/index');

		$data['messages'] = array();
		// $config['total_rows'] = $this->Message->get_messages_count(); 
		// $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		// $this->load->library('pagination');$this->pagination->initialize($config);
		// $data['messages'] = $this->Message->get_messages($config['per_page'], $offset);
		// $data['pagination'] = $this->pagination->create_links();

		$this->Message->make_employee_active();
		
		$this->load->view("messages/messages",$data);
	}

	public function allUser(){
		$data['data'] = $this->Message->allUser();
		$data['last_msg'] = array();
		$this->load->helper('url');
		
		if(!is_array($data['data'])){
			echo "<p class='text-center'>No user available.</p>";
		}else{
			$count = count($data['data']);
			for($i = 0; $i < $count; $i++){
				$unique_id = $data['data'][$i]['id'];
				$msg = $this->Message->getLastMessage($unique_id);
				for($j = 0; $j < count($msg); $j++){

					$time = explode(" ",$msg[0]['time']); //00:00:00.0000
					$time = explode(".", $time[1]);//00:00:00
					$time = explode(":",$time[0]);//00 00 00
					if((int)$time[0] == 12){
						$time = $time[0].":".$time[1]." PM";
					}
					elseif((int)$time[0] > 12){
						$time = ($time[0] - 12).":".$time[1]." PM";
					}else{
						$time = $time[0].":".$time[1]." AM";
					}

					array_push($data['last_msg'],array(
						'message' => $msg[0]['message'],
						'sender_id' => $msg[0]['sender_id'],
						'receiver_id' => $msg[0]['receiver_id'],
						'time' => $time //00:00
					));
				}
			}

		
			$this->load->view('messages/sampleDataShow',$data);
		}
		
	}
	public function getIndividual(){
		$returnVal = $this->Message->getIndividual($_POST['data']);
		print_r(json_encode($returnVal,true));
	}
	public function getMessage(){
		if(isset($_POST['data'])){
			$data['data'] = $this->Message->getmessage($_POST);
			$data['image'] = $_POST['image'];
			$data['othername'] = $_POST['othername'];
		    $data['mysession'] =  $_POST['myid'];

			$this->load->view('messages/sampleMessageShow',$data);
		}
	}


	public function sendMessage(){
		if(isset($_POST['data']) ){
		$jsonDecode = json_decode($_POST['data'],true);
		$uniq =  $this->Employee->get_logged_in_employee_info()->id;
		$arr = array(
			'time' => $jsonDecode['datetime'],
			'sender_id' => $uniq,
			'receiver_id' => $jsonDecode['uniq'],
			'message' => $jsonDecode['message'],
		);
			$this->Message->sentMessage($arr);




		}

		

	}

	
	function sent_messages($offset = 0)
	{
		$data = array();
		
		$config = array();
		$config['base_url'] = site_url('messages/sent_messages');
		$config['total_rows'] = $this->Message->get_sent_messages_count(); 
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20; 
		$config['uri_segment'] = 3;
		$this->load->library('pagination');$this->pagination->initialize($config);
		$data['messages'] = $this->Message->get_sent_messages($config['per_page'], $offset);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view("messages/sent_messages",$data);
	}

	/*
	Loads the customer edit form
	*/
	function view($message_id,$sent_message = 0)
	{
		if ($this->Message->can_read_message($message_id,$sent_message))
		{
			$data['message']=$this->Message->get_info($message_id);
			$this->load->view("messages/single-message",$data);
		}
		else
		{
			$data['message'] = array();
			$this->load->view("messages/single-message",$data);
		}
	}

	function delete_message()
	{
		$message_id = $this->input->post('message_id');
		$status = $this->Message->delete_message($message_id);			
		echo json_encode(array('message_id' => $message_id,'status' => $status ));
	}
	
	function send_message()
	{

		$this->check_action_permission('send_message');

		$data['employees'] = array();
		
		foreach ($this->Employee->get_all()->result() as $employee)
		{
			$data['employees'][$employee->person_id] = $employee->first_name . ' '. $employee->last_name;
		}

		
		$data['locations'] = array();
		
		foreach ($this->Location->get_all()->result() as $location)
		{
			$data['locations'][$location->location_id] = $location->name;
		}
	
		$this->load->view("messages/send_message",$data);
	}

	function send_invidual_message($person_id)
	{

		$this->check_action_permission('send_message');

		$data['employee'] = $this->Employee->get_info($person_id);
		
		$this->load->view("messages/send_individual_message",$data);
	}

	function save_message()
	{

		$message_data = array(
		'all_locations'=>$this->input->post('all_locations'),
		'all_employees'=>$this->input->post('all_employees'),
		'locations'=>$this->input->post('locations'),
		'employees'=>$this->input->post('employees'),
		'subject'=>$this->input->post('subject'),
		'message'=>$this->input->post('message'),
		
		);
		if(!$this->input->post('all_employees') && !$this->input->post('employees'))
		{
			echo json_encode(array('status'=>false,'message'=>lang("messages_employees_required")));
		}
		else if($this->Message->save_message($message_data))
		{
			echo json_encode(array('status'=>true,'message'=>$this->input->post('message')));
		}
		else
		{
			echo json_encode(array('status'=>false,'message'=>$this->input->post('message')));
		}
	}

	function read_message()
	{
		$message_id = $this->input->post('message_id');
		$this->Message->read_message($message_id);
	}
	
	function get_locations_employees()
	{

		$selected_locations = $this->input->post('selected_locations');

		// Get all the employees in selected locations
		$employee_ids = $this->Employee->get_multiple_locations_employees($selected_locations)->result_array();

		//Prepare the employees ids format 
		$person_ids = array();
		foreach ($employee_ids as $value) {
			$person_ids[] = $value['employee_id'];
		}
		
		// Get all the empoyees data
		$employees_data = $this->Employee->get_multiple_info($person_ids)->result_array();
		$employees = array();
		
		foreach ($employees_data as $employee) {
			
			$employees[$employee['person_id']] = $employee['first_name'] . ' '. $employee['last_name'];
		}
		

		echo json_encode(array('success'=>true,'employees'=>$employees));

	}
}
?>