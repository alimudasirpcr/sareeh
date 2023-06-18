<?php
require_once ("Secure_area.php");
require_once (APPPATH."models/cart/PHPPOSCartRecv.php");
require_once (APPPATH."traits/taxOverrideTrait.php");
class Plans extends Secure_area
{
	// function __construct()
	// {
	// 	parent::__construct('plans');
	// 	$this->lang->load('plans');
	// 	$this->lang->load('module');
	// 	$this->load->model('Plans_model');
	// }
	
    public function index(){
 
		$query = $this->db->query("select * from phppos_plans");
		$result['plans'] = $query->result_array();
		// echo "<pre>";
		// print_r($result['plans']);
		// exit;
		$this->load->view('plans/form',$result);
	

    }

	public function get_plans(){
		$query = $this->db->query("SELECT * FROM phppos_plans");
$plans = $query->result_array();

$response = array(
    'status' => 'success',
    'message' => 'Plans data loaded successfully',
    'data' => $plans
);

echo json_encode($response);
	}

	// public function getall(){

	// 	$query = $this->db->query("select * from phppos_plans");
	// 	$response = $query->result_array();
	// 	echo json_encode($response);
	// }


	
	public function submitForm() {
		// Handle the form submission
		$name = $this->input->post('name');
		$amount = $this->input->post('amount');
		$frequency = $this->input->post('frequency');
	
		$data = array(
			'name' =>$name,
			'amount' => $amount,
			'frequency' => $frequency
		);

		$this->db->insert('phppos_plans', $data);
		$response = array('success' => true);
	
		// Send the response back to the client
		echo json_encode($response);
	}

	public function edit()
	{
		$formId = $this->input->post('form_id');
	
		$query = $this->db->query("SELECT * FROM phppos_plans WHERE id = '$formId'");
		$response = $query->row_array(); // Retrieve a single row
	
		// Prepare the response
		$response = array(
			'success' => true,
			'data' => $response // Include the retrieved data in the response
		);
	
		// Send the response back to the client
		echo json_encode($response);
	}
	
	public function update()
{
    // Get the form data from the request
    $formId = $this->input->post('form_id');
    $name = $this->input->post('name');
    $amount = $this->input->post('amount');
    $frequency = $this->input->post('frequency');

    // Update the data in the database
    $data = array(
        'name' => $name,
        'amount' => $amount,
        'frequency' => $frequency
    );
    $this->db->where('id', $formId);
    $this->db->update('phppos_plans', $data);

    // Prepare the response
    $response = array('success' => true);

    // Send the response back to the client
    echo json_encode($response);
}

public function delete()
{
    // Get the form ID from the request
    $formId = $this->input->post('form_id');

    // Delete the record from the database
    $this->db->where('id', $formId);
    $this->db->delete('phppos_plans');

    // Prepare the response
    $response = array('success' => true);

    // Send the response back to the client
    echo json_encode($response);
}


	  
	  
}