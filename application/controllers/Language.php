<?php

require_once ("Secure_area.php");

require_once (APPPATH."libraries/google2fa/vendor/autoload.php");
require_once (APPPATH."libraries/bacon-qr-code/vendor/autoload.php");
class Language  extends Secure_area 
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
		$this->load->model('Employee');
		$this->load->model('Giftcard');
		$this->load->model('Sale');
		$this->load->helper('cloud');
		$this->load->helper('text');
		$this->load->model('Appfile');
    }
    
    public function index(){
        $data = array();
       
        
        // Define the path to the language directory
        $languageDirPath = APPPATH . 'language/*';

        // Use glob function to get all directories in the language directory
        $directories = glob($languageDirPath, GLOB_ONLYDIR);

        // Get the folder names
        $folderNames = array_map('basename', $directories);
        $data['langs'] = $folderNames;

        $this->load->view('language/list',$data); 
    }

    public function test_trans(){
        // Initialize cURL session
$curl = curl_init();

// URL and query parameters
$url = "https://api.lecto.ai/v1/translate/text";

// Form data to be sent in the POST request
$params = http_build_query([
    'to' => ['es'], // Note: 'to' as array may need to be handled based on API specification
    'from' => 'en',
    'texts' => ['hi'],
]);

dd($params);

// Set cURL options
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $params,
    CURLOPT_HTTPHEADER => [
        'content-type:application/json',
        'X-API-Key:F7QMFZ6-KBX45ZA-Q21JWBR-9CDT34D', // Replace with your actual RapidAPI key
    ],
]);

// Execute the request and capture the response
$response = curl_exec($curl);

// Check for errors
if (curl_errno($curl)) {
    $error_msg = curl_error($curl);
    echo "cURL Error: $error_msg";
}

// Close cURL session
curl_close($curl);

// Decode and print the response
$responseData = json_decode($response, true);
echo "<pre>";
print_r($responseData);
echo "</pre>";
    }
    
    public function lang_update($code='arabic'){
             $data = array();
             $jsonString = file_get_contents(APPPATH.'language/'.$code.'/'.$code.'.json');
             $datajs = json_decode($jsonString, true);
             $data['langdata']=$datajs;
             $data['code'] = $code;
            //  dd($data);
           $this->load->view('language/editable_datatable',$data); 
    }

    public function update($code , $id){
        $jsonString = file_get_contents(APPPATH.'language/'.$code.'/'.$code.'.json');
        $datajs = json_decode($jsonString, true);
        $value_new = $this->input->post('Value');
        foreach($datajs as $key => $value){
            if( $id ==  $key ){
                $datajs[$key]=$value_new;
            }
        }
    
        $newJsonString = json_encode($datajs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        //dd($newJsonString);
        file_put_contents(APPPATH.'language/'.$code.'/'.$code.'.json', $newJsonString);
    }

    public function lang_update_old($code='english')
	{


         $data = array();
         	
         //	$jsonString = file_get_contents('jsonFile.json');
         	$jsonString = file_get_contents(APPPATH.'language/'.$code.'/'.$code.'.json');
			$datajs = json_decode($jsonString, true);
			$data['langdata']=$datajs;
            $data['code'] = $code;
            $this->load->view('language/manage',$data); 
		}

        public function update_arabic_lang(){
            // update json file of the arabic language
            $code = $this->input->post('hidden_code_lanauge');
            $jsonString = file_get_contents(APPPATH.'language/'.$code.'/'.$code.'.json');
            $datajs = json_decode($jsonString, true);
        
            foreach($datajs as $key => $value){
                if(isset($_POST[$key]) &&  $_POST[$key]!=''){
                    $datajs[$key]=$_POST[$key];
                }
            }
        
            $newJsonString = json_encode($datajs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            file_put_contents(APPPATH.'language/'.$code.'/'.$code.'.json', $newJsonString);
        
                redirect(base_url().'language/index');
        }
	
}