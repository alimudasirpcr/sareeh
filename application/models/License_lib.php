<?php defined('BASEPATH') OR exit('No direct script access allowed');

class License_lib  extends CI_Model {

    protected $CI;
    private $server_url = 'https://your-prefix-erp-url.com/api/';

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
    }

    public function get_all_packages(){
        $this->CI =& get_instance();
        $CI =$this->CI ;
        $this->server_url = $CI->config->item('erp_url');
        $endpoint = $this->server_url . 'admin/api/get_all_packages';
        //  echo $endpoint;
        $response = $this->send_request($endpoint);
        return $response;
        // echo "<pre>";
        // print_r($response);
        // exit();
    }

    public function get_single_package($id){
        $this->CI =& get_instance();
        $CI =$this->CI ;
        $this->server_url = $CI->config->item('erp_url');
        $endpoint = $this->server_url . 'admin/api/get_single_package?id='.$id.'';
        //  echo $endpoint;
        $response = $this->send_request($endpoint);
        return $response;
       
    }

    public function check_license() {
        $this->CI =& get_instance();
        $CI =$this->CI ;
        $this->server_url = $CI->config->item('erp_url');
        $license_key = $CI->config->item('license_key');
        $client_id = $CI->config->item('client_id');

        /// this is temporary code

        $modules= 'appointments,config,customers,deliveries,employees,expenses,invoices,item_kits,price_rules,items,locations,reports,salesappointments,config,customers,deliveries,employees,expenses,giftcards,invoices,item_kits,price_rules,items,locations,messages,receipt,receivings,reports,sales,suppliers,work_orders,booking';
        $this->CI->session->set_userdata('package',4);
        $this->CI->session->set_userdata('license_status', 'valid');
        $this->CI->session->set_userdata('module_ids', explode(',', $modules)); // save module_ids in session
        return true;
/// this is temporary code

//         $endpoint = $this->server_url . 'admin/api/check_license?client_id='.$client_id.'&license_key='.$license_key.'';
// //  echo $endpoint;
//         $response = $this->send_request($endpoint);
      
//         if ($response && $response->status === 'success') {
//             $this->CI->session->set_userdata('package',$response->package);
//             $this->CI->session->set_userdata('license_status', 'valid');
//             $this->CI->session->set_userdata('module_ids', explode(',', $response->module_ids)); // save module_ids in session
//             return true;
//         } else {
//             $this->CI->session->set_userdata('license_status', 'invalid');
//             return false;
//         }
    }

    public function generate_license( $package_id , $trx) {
       
        $this->CI =& get_instance();
        $CI =$this->CI ;
        $this->server_url = $CI->config->item('erp_url');
        $client_id = $CI->config->item('client_id');
        $endpoint = $this->server_url . 'admin/api/generate_license?client_id='.$client_id.'&package_id='.$package_id.'&trx='.$trx.'';
 

        // echo $endpoint;
        // exit();
        
        $response = $this->send_request($endpoint);
       
        if($response && $response->status === 'success') {
            $this->Appconfig->save('license_key',$response->license_data->license_key);
            $this->Appconfig->save('package',$package_id);
            $this->CI->session->set_userdata('package',$package_id);
            $this->CI->session->set_userdata('module_ids', explode(',', $response->license_data->module_ids)); // save module_ids in session
            return $response;
        } else {
            return $response;
        }
    }

  

    private function send_request($url) {
        $api_url = $url; // Use sandbox or production URL as required

        $curl = curl_init();
        
        curl_setopt_array($curl, [
          CURLOPT_URL => $api_url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => [
            "Accept: application/json"
          ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);

        return json_decode($response);
    }

    public function is_license_valid() {
        return $this->CI->session->userdata('license_status') === 'valid';
    }

    public function has_module_access($module_id) {
        $module_ids = $this->CI->session->userdata('module_ids');
        return in_array($module_id, $module_ids);
    }

}