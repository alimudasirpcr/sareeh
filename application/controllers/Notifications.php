<?php
require_once ("Secure_area.php");

require_once (APPPATH."libraries/google2fa/vendor/autoload.php");
require_once (APPPATH."libraries/bacon-qr-code/vendor/autoload.php");

use PragmaRX\Google2FAQRCode\Google2FA;

class Notifications extends Secure_area 
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
        $this->load->model('Message');
		$this->load->model('Employee');
		$this->load->model('Giftcard');
		$this->load->model('Sale');
		$this->load->helper('cloud');
		$this->load->helper('text');
		$this->load->model('Appfile');
	}
	
    function index()
	{	
        $data = array();
        $data['notifications'] = [];
         $noti_count =  $this->Employee->get_notifications(); 
          $new_message_count =  $this->Employee->get_messages();
         $data['notifications']  = array_merge($noti_count , $new_message_count);
         usort($data['notifications'], function($a, $b) {
            return strtotime($a['created_at']) - strtotime($b['created_at']);
        });
        // dd($data);
        $this->load->view("notifications/notification" , $data);

    }

    function update(){
        // dd($_POST['message']);
        if(isset($_POST['message'])){
            foreach($_POST['message'] as $message) {
                $this->Message->read_message($message);
            }
        }
        if(isset($_POST['transfer'])){
            foreach($_POST['transfer'] as $transfer) {
                $this->Employee->update_notifications($transfer , ['status' => 1]);
            }
        }
        echo true;
    }
}