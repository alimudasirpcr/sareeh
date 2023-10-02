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
    
    public function lang_update($code='english')
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