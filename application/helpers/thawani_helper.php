<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('thawani_payment'))
{
    function thawani_payment()
    {
        // Thawani API endpoint
        $api_url = 'https://uatcheckout.thawani.om/api/v1/payment_intents'; // Use sandbox or production URL as required

        // Thawani API credentials from your Thawani account
        $api_key = 'rRQ26GcsZzoEhbrP2HZvLYDbn9C9et';
        $api_secret = 'YOUR_API_SECRET';

        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'amount' => 100,
            'client_reference_id' => '12345',
            'return_url' => 'https://thw.om/success',
            'metadata' => [
                'customer' => 'thawani developers'
            ]
        ]),
        CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Content-Type: application/json",
            "thawani-api-key: ".$api_key.""
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
           
        echo $response;
        confirm_payment(json_decode($response)->data->id);
        }
    }

    function create_thawani_session($id){
        $CI =& get_instance();

        $invoices = get_query_data("select * from phppos_invoice where status=0 and id=".$id." ");
	    $amount = (float)$invoices[0]->amount * 1000;
         $sandbox = ($CI->config->item('thawani_is_sandbox')=='true')?"uat":"";
         // Thawani API endpoint
         $api_url = 'https://'.$sandbox .'checkout.thawani.om/api/v1/checkout/session'; // Use sandbox or production URL as required

         // Thawani API credentials from your Thawani account
         $api_key = $CI->config->item('thawani_api_key');
         $api_secret = $CI->config->item('thawani_sec_key');
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL =>  $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'client_reference_id' => $id,
            'mode' => 'payment',
            'products' => [
                [
                        'name' => 'Sareeh Pos Payment',
                        'quantity' => 1,
                        'unit_amount' => $amount
                ]
            ],
            'success_url' => base_url().'payments/success',
            'cancel_url' => base_url().'payments/cancel',
            'metadata' => [
                'Customer name' => 'somename',
                'order id' => 0
            ]
        ]),
        CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Content-Type: application/json",
            "thawani-api-key: ".$api_key.""
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            $rec = json_decode($response);
            $session_id = $rec->data->session_id;
            // echo "<pre>";
            // print_r($rec);
            // exit();
            
            $CI->session->set_userdata('thawani_session_id', $session_id);
            redirect(get_thawani_pay_url($session_id));
        }
    }


    function create_thawani_session_for_sales($id){
        $CI =& get_instance();

        $invoices = get_query_data("select * from phppos_sales where sale_id=".$id." ");
	    $amount = (float)$invoices[0]->total * 1000;
         $sandbox = ($CI->config->item('thawani_is_sandbox')=='true')?"uat":"";
         // Thawani API endpoint
         $api_url = 'https://'.$sandbox .'checkout.thawani.om/api/v1/checkout/session'; // Use sandbox or production URL as required

         // Thawani API credentials from your Thawani account
         $api_key = $CI->config->item('thawani_api_key');
         $api_secret = $CI->config->item('thawani_sec_key');
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL =>  $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'client_reference_id' => $id,
            'mode' => 'payment',
            'products' => [
                [
                        'name' => 'Sareeh Pos Payment',
                        'quantity' => 1,
                        'unit_amount' => $amount
                ]
            ],
            'success_url' => base_url().'booking/success',
            'cancel_url' => base_url().'payments/cancel',
            'metadata' => [
                'Customer name' => 'somename',
                'order id' => 0
            ]
        ]),
        CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Content-Type: application/json",
            "thawani-api-key: ".$api_key.""
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            $rec = json_decode($response);
            $session_id = $rec->data->session_id;
            // echo "<pre>";
            // print_r($rec);
            // exit();
            
            $CI->session->set_userdata('thawani_session_id_booking', $session_id);
            redirect(get_thawani_pay_url($session_id));
        }
    }


   function get_thawani_pay_url($session_id){
        $CI =& get_instance();
        $sandbox = ($CI->config->item('thawani_is_sandbox')=='true')?"uat":"";
        $api_key = $CI->config->item('thawani_api_key');
        $api_secret = $CI->config->item('thawani_sec_key');
        return 'https://'.$sandbox.'checkout.thawani.om/pay/'.$session_id.'?key='.$api_secret.'';
   }

     function save_thwani_session($session_id){
        $CI =& get_instance();
     
        // Thawani API credentials from your Thawani account
        $sandbox = ($CI->config->item('thawani_is_sandbox')=='true')?"uat":"";
        $api_key = $CI->config->item('thawani_api_key');
        $api_secret = $CI->config->item('thawani_sec_key');

        $api_url = 'https://'.$sandbox.'checkout.thawani.om/api/v1/checkout/session/'.$session_id.''; // Use sandbox or production URL as required

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
            "Accept: application/json",
            "thawani-api-key: ".$api_key.""
          ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
            $rec = json_decode($response);
            if($rec->data->payment_status=='paid'){
                $data = array(
                    'total_amount' => $rec->data->total_amount,
                    'currency' => $rec->data->currency,
                    'payment_status' => $rec->data->payment_status,
                    'mode' => $rec->data->mode,
                    'pay_json' => $response,
                    'session_id' => $session_id 
                );
                $CI->db->insert('phppos_payments', $data);
                update_data('phppos_invoice' , ['status' => 1 ] , $rec->data->client_reference_id );
                update_erp($session_id , $rec->data->client_reference_id , $rec->data->total_amount);
            }
            
        }
    }
    


    function save_thwani_session_booking($session_id){
        $CI =& get_instance();
        $return ='table';
        // Thawani API credentials from your Thawani account
        $sandbox = ($CI->config->item('thawani_is_sandbox')=='true')?"uat":"";
        $api_key = $CI->config->item('thawani_api_key');
        $api_secret = $CI->config->item('thawani_sec_key');

        $api_url = 'https://'.$sandbox.'checkout.thawani.om/api/v1/checkout/session/'.$session_id.''; // Use sandbox or production URL as required

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
            "Accept: application/json",
            "thawani-api-key: ".$api_key.""
          ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
            $rec = json_decode($response);
            if($rec->data->payment_status=='paid'){
                $data = array(
                    'payment_type' => 'Debit Card',
                    'payment_amount' => $rec->data->total_amount / 1000,
                    'ref_no' => $session_id,
                    'sale_id' => $rec->data->client_reference_id,
                );
                $CI->db->insert('phppos_sales_payments', $data);

                $invoices = get_query_data("select * from phppos_sales where sale_id=".$rec->data->client_reference_id." ");

                if($invoices[0]->delivery_type=='Pickup'){
                    $return ='Pickup';
                }else if($invoices[0]->delivery_type=='Home Delivery'){
                    $return ='HomeDelivery';
                }

                
            }
            
        }

        return $return;
    }

    function update_erp($trans , $ref , $amount){
        $invoices = get_query_data("select * from phppos_invoice where  id=".$ref." ")[0];
        $CI =& get_instance();
        $erp_url =  $CI->config->item('erp_url');
        $api_url = ''.$erp_url.'admin/api/add_payment?invoiceid='.$invoices->invoice_id.'&amount='. $invoices->amount.'&api_key=omancloudapikey123123ERP&transactionid='.$trans.''; // Use sandbox or production URL as required

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

    }

    function check_for_invoices_erp(){

        $CI =& get_instance();
        $client_id =  $CI->config->item('client_id');
        $erp_url =  $CI->config->item('erp_url');
      
        $api_url = ''.$erp_url.'admin/api/check_invoices?api_key=omancloudapikey123123ERP&client='.$client_id.''; // Use sandbox or production URL as required
// echo $api_url;
// exit();
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

        if ($err) {
            echo "cURL Error #:" . $err;
            } else {
               
                $res = json_decode($response);
            
                if($res->msg){
                    foreach($res->data as $inv){
                        if($inv->recurring){
                            $recurring = $inv->recurring; // Number of recurring months


                            $CI->db->select_max('duedate', 'max_date');
                            $CI->db->from('phppos_invoice');
                            $CI->db->where('invoice_id ',  $inv->id);
                            $query = $CI->db->get();
                            $max_date = $query->row()->max_date;
                           

                            if($max_date){
                              
                                $date = $inv->date; // The date to check

                                // Calculate the start and end date range for the month
                                $start_date = date('Y-m-01', strtotime("+1 months", strtotime($max_date)));
                                $end_date = date('Y-m-t', strtotime($max_date));
    
                                // Calculate the future end date based on recurring months
                                $future_end_date = date('Y-m-d', strtotime("+" . $recurring . " months", strtotime($max_date)));
    

                                // Check if the next invoice date is more than 10 days from today
                                $today = date('Y-m-d');
                                $ten_days_from_today = date('Y-m-d', strtotime("+10 days", strtotime($today)));
                                if ($future_end_date < $ten_days_from_today) {


                                    // Prepare the query conditions
                                    $CI->db->select('*');
                                    $CI->db->from('phppos_invoice');
                                    $CI->db->where('invoice_id ',  $inv->id);
                                    $CI->db->where('duedate >=', $start_date);
                                    $CI->db->where('duedate <=', $future_end_date);
                                    $CI->db->limit(1);
        
                                    // Execute the query
                                    $query = $CI->db->get();
                                
                                    if ($query->num_rows() > 0) {
                                        echo  $start_date;
                                        echo $CI->db->last_query();
                                        exit();
                                        // Invoice already generated within the recurring months
                                        echo "Invoice already generated within the recurring months.";
                                    } else {
                                        // Generate new invoice for the month
                                        save_data('phppos_invoice' ,
                                        [
                                            'invoice_id' => $inv->id,
                                            'amount' => $inv->total,
                                            'duedate' => $future_end_date,
                                        ]);
                                        echo "Generate new invoice for the month.";
                                    }
                                }else{
                                    echo "Invoice already generated within the recurring months more than 10 days.";
                                }
                            }else{
                                $date = $inv->date; // The date to check

                                // Calculate the start and end date range for the month
                                $start_date = date('Y-m-01', strtotime($date));
                                $end_date = date('Y-m-t', strtotime($date));
    
                                // Calculate the future end date based on recurring months
                                $future_end_date = date('Y-m-t', strtotime("+" . $recurring . " months", strtotime($start_date)));
    
                                // Prepare the query conditions
                                $CI->db->select('*');
                                $CI->db->from('phppos_invoice');
                                $CI->db->where('invoice_id ',  $inv->id);
                                $CI->db->where('duedate >=', $start_date);
                                $CI->db->where('duedate <=', $future_end_date);
                                $CI->db->limit(1);
    
                                // Execute the query
                                $query = $CI->db->get();
    
                                if ($query->num_rows() > 0) {
                                    // Invoice already generated within the recurring months
                                    echo "Invoice already generated within the recurring months.";
                                } else {
                                    // Generate new invoice for the month
                                    save_data('phppos_invoice' ,
                                     [
                                        'invoice_id' => $inv->id,
                                        'amount' => $inv->total,
                                        'duedate' => $future_end_date,
                                     ]);
                                    echo "Generate new invoice for the month.";
                                }
                            }
                           
                        }else{

                            $recurring = 1; // Number of recurring months
                            $date = $inv->date; // The date to check

                            // Calculate the start and end date range for the month
                            $start_date = date('Y-m-01', strtotime($date));
                            $end_date = date('Y-m-t', strtotime($date));

                            // Calculate the future end date based on recurring months
                            $future_end_date = date('Y-m-t', strtotime("+" . $recurring . " months", strtotime($start_date)));



                            $CI->db->select('*');
                            $CI->db->from('phppos_invoice');
                            $CI->db->where('invoice_id ',  $inv->id);
                            $CI->db->limit(1);
                              // Execute the query
                              $query = $CI->db->get();

                              if ($query->num_rows() > 0) {
                                  // Invoice already generated within the recurring months
                                  echo "Invoice already generated within the recurring months.";
                              } else {
                                  // Generate new invoice for the month
                                  save_data('phppos_invoice' ,
                                   [
                                      'invoice_id' => $inv->id,
                                      'amount' => $inv->total,
                                      'duedate' => $future_end_date,
                                   ]);
                                  echo "Generate new invoice for the month.";
                              }
                        }
                    }
                }
            
            }


    }
    function confirm_payment($id){

        $curl = curl_init();
        // Thawani API credentials from your Thawani account
        $api_key = 'rRQ26GcsZzoEhbrP2HZvLYDbn9C9et';
        $api_secret = 'YOUR_API_SECRET';
        curl_setopt_array($curl, [
        CURLOPT_URL => "https://uatcheckout.thawani.om/api/v1/payment_intents/".$id."/confirm",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            '// send empty request to confirm the payment intent' => null
        ]),
        CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Content-Type: application/json",
            "thawani-api-key: ".$api_key.""
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            echo "confirmation <br>";
        echo $response;
        }

    }
}