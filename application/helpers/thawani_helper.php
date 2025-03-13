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


    function create_thawani_session_for_plan($id){
        $CI =& get_instance();
        $CI->load->model('License_lib');
        $res = $CI->License_lib->get_single_package($id);
        if($res->status=='success'){
         

            $invoices = get_query_data("select * from phppos_sales where sale_id=".$id." ");
            $amount = (float)$res->packages->price * 1000;
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
                            'name' => 'Sareeh plan Payment',
                            'quantity' => 1,
                            'unit_amount' => $amount
                    ]
                ],
                'success_url' => base_url().'plans/success',
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
                
                $CI->session->set_userdata('thawani_session_id_plan', $session_id);
                redirect(get_thawani_pay_url($session_id));
            }
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

    function save_thwani_session_plan($session_id){
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


                $CI->load->model('License_lib');
                $res = $CI->License_lib->generate_license($rec->data->client_reference_id , $session_id );

                
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
    function get_due_alerts() {
        $CI =& get_instance();
        $today = date('Y-m-d');
        $sevenDaysFromNow = date('Y-m-d', strtotime('+7 days'));
        
        // Alerts for invoices due within 7 days

        $payments = get_query_data('select * from phppos_payments ');
    
        $CI->db->save_queries = true;
        if($payments){
            $upcomingDueQuery = $CI->db->query(
                "SELECT i.id, i.erp_invoice_id, i.amount, i.currency, i.hash, i.duedate, i.recurring, DATEDIFF(i.duedate, ?) as days_remaining 
                FROM phppos_invoice i
                LEFT JOIN (
                    SELECT erp_invoice_id, SUM(total_amount) as total_paid
                    FROM phppos_payments
                    GROUP BY erp_invoice_id
                ) p ON i.erp_invoice_id = p.erp_invoice_id
                WHERE i.duedate BETWEEN ? AND ? AND (p.total_paid IS NULL OR p.total_paid < i.amount)",
                [$today, $today, $sevenDaysFromNow]
        );
        }else{
       
            $upcomingDueQuery = $CI->db->query(
                "SELECT i.id, i.erp_invoice_id, i.amount, i.currency, i.hash, i.duedate, i.recurring, DATEDIFF(i.duedate, ?) as days_remaining 
                FROM phppos_invoice i
                WHERE i.duedate BETWEEN ? AND ? ",
                [$today, $today, $sevenDaysFromNow]
        );
        }
       
            $upcomingDueAlerts = $upcomingDueQuery->result();
         
 

       
        
         
        
         

         if($payments){
            $overdueQuery = $CI->db->query(
                "SELECT i.id, i.erp_invoice_id, i.amount, i.currency, i.hash, i.duedate, i.recurring, ABS(DATEDIFF(i.duedate, ?)) as overdue_days 
                FROM phppos_invoice i
                LEFT JOIN (
                    SELECT erp_invoice_id, SUM(total_amount) as total_paid
                    FROM phppos_payments
                    GROUP BY erp_invoice_id
                ) p ON i.erp_invoice_id = p.erp_invoice_id
                WHERE i.duedate < ? AND (p.total_paid IS NULL OR p.total_paid < i.amount)",
                [$today, $today]
            );
    
         }else{
            $overdueQuery = $CI->db->query(
                "SELECT i.id, i.erp_invoice_id, i.amount, i.currency, i.hash, i.duedate, i.recurring, ABS(DATEDIFF(i.duedate, ?)) as overdue_days 
                FROM phppos_invoice i
                
                WHERE i.duedate < ? ",
                [$today, $today]
            );
    
         }

      
             $overdueAlerts = $overdueQuery->result();
        

        $alerts =  [
            'upcoming_due' => $upcomingDueAlerts,
            'overdue' => $overdueAlerts
        ];

        $response_alerts = [
            'upcoming_due' => array_map(function($alert) {
                return [
                    'id' => $alert->id,
                    'erp_invoice_id' => $alert->erp_invoice_id,
                    'amount' => $alert->amount,
                    'currency' => $alert->currency,
                    'hash' => $alert->hash,
                    'duedate' => $alert->duedate,
                    'recurring' => $alert->recurring,
                    'days_remaining' => $alert->days_remaining
                ];
            }, $alerts['upcoming_due']),
            'overdue' => array_map(function($alert) {
                return [
                    'id' => $alert->id,
                    'erp_invoice_id' => $alert->erp_invoice_id,
                    'amount' => $alert->amount,
                    'currency' => $alert->currency,
                    'hash' => $alert->hash,
                    'duedate' => $alert->duedate,
                    'recurring' => $alert->recurring,
                    'overdue_days' => $alert->overdue_days
                ];
            }, $alerts['overdue'])
        ];

        $is_upcoming_due = 0;
        if( count($response_alerts['upcoming_due'])  > 0 ){

            $is_upcoming_due =  $response_alerts['upcoming_due'][0]['days_remaining'];
        }

        $is_over_due = 0;
        if( count($response_alerts['overdue'])  > 0 ){

            $is_over_due =  $response_alerts['overdue'][0]['overdue_days'];
        }
        return [
            'is_upcoming_due' => $is_upcoming_due,
            'is_over_due' => $is_over_due,
            'alerts' => $response_alerts

        ];
     
    
}

    function is_over_due(){
        $alerts = get_due_alerts();
        if(isset($alerts['is_over_due']) &&  $alerts['is_over_due'] > 10){  
            return true;

        }else{
            return false;
        }
    }
    // function get_erp_data() {
    //     $CI =& get_instance();
        
    //     // Fetch ERP data dynamically (modify this based on your data source)
    //     $erpData = $CI->db->get('phppos_invoice')->result_array();  // Example: Fetch from DB
        
    //     if (empty($erpData)) {
    //         return []; // Return empty array if no data
    //     }
    
    //     // Convert database records to structured format
    //     $invoice = (object)[
    //         'id' => $erpData[0]['id'],
    //         'status' => $erpData[0]['status'],

    //         'status' => $invoice->status,
    //         'amount' => $invoice->total,
    //         'hash' => $invoice->hash,
    //         'currency' => $invoice->currency,
    //         'duedate' => $invoice->duedate,
    //         'recurring' => $invoice->recurring,
    //         'last_sync' => date('Y-m-d H:i:s'),
           
    //     ];
    
    //     // Fetch payments dynamically
    //     $payments = $CI->db->get('phppos_payments')->result_array();
    
    //     $formattedPayments = array_map(function ($payment) {
    //         return (object)[
    //             'invoiceid' => $payment['invoice_id'],
    //             'amount' => $payment['amount'],
    //             // 'name' => $payment['payment_method'],
    //             'date' => $payment['payment_date'],
    //             'transactionid' => $payment['transaction_id']
    //         ];
    //     }, $payments);
    
    //     return [
    //         'invoice' => $invoice,
    //         'payments' => $formattedPayments
    //     ];
    // }
    
    
    function sync_erp_data($erpData) {
        $CI =& get_instance();
        // Extract invoice and payments from ERP data
        $invoice = $erpData['invoice'];
        $payments = $erpData['payments'];


        // Check if invoice already exists in Sareeh
        $existingInvoice = get_query_data('select * from  phppos_invoice where erp_invoice_id= '.$invoice->id.' ');

        if (!empty($existingInvoice)) {  
            // Update existing invoice
            $updateInvoiceData = [
                'status' => $invoice->status,
                'amount' => $invoice->total,
                'hash' => $invoice->hash,
                'currency' => $invoice->currency,
                'duedate' => $invoice->duedate,
                'recurring' => $invoice->recurring,
                'last_sync' => date('Y-m-d H:i:s')
            ];
            $CI->db->where('erp_invoice_id', $invoice->id);
            $CI->db->update('phppos_invoice', $updateInvoiceData);
        } else {
            // Insert new invoice
            $insertInvoiceData = [
                'erp_invoice_id' => $invoice->id,
                'status' => $invoice->status,
                'amount' => $invoice->total,
                'hash' => $invoice->hash,
                'currency' => $invoice->currency,
                'duedate' => $invoice->duedate,
                'recurring' => $invoice->recurring,
                'last_sync' => date('Y-m-d H:i:s')
            ];
            $CI->db->insert('phppos_invoice', $insertInvoiceData);
        }
        // $CI->db->delete('phppos_payments');
        execute_query(' delete from phppos_payments');
        // Process payments
        foreach ($payments as $payment) {
            // Check if payment already exists
            
           
                // Insert new payment
                $insertPaymentData = [
                    'erp_invoice_id' => $payment->invoiceid,
                    'total_amount' => $payment->amount,
                    'currency' => $invoice->currency,
                    'payment_status' =>  'Active' ,
                    'mode' => $payment->name,
                    'payment_date' => $payment->date,
                    'transaction_id' => $payment->transactionid,
                    'pay_json' => json_encode($payment)
                ];
                $CI->db->insert('phppos_payments', $insertPaymentData);
            
        }

        return "Sync completed successfully.";
    }
    
    function check_limitations_items() {
        $CI =& get_instance();
    
        
        $query = $CI->db->select('invoice_json')->get('phppos_invoice');
        $invoicedata = $query->row();
    
        if (!$invoicedata || empty($invoicedata->invoice_json)) {
            return ['success' => false, 'message' => "No invoice JSON found in the database."];

        }
    
       
        $invoiceObj = json_decode($invoicedata->invoice_json, true);
    
       
        if (!$invoiceObj || !isset($invoiceObj['metadata']['limitations'])) {
            return ['success' => false, 'message' => "Invalid data structure in invoice JSON."];

        }
    
        
        $limitations = $invoiceObj['metadata']['limitations'];
    
        
        $itemslimit = (int) $limitations['items'];
        // echo "pre";
        // print_r($itemslimit);
        // exit();
        
        $itemscount = $CI->db->count_all('items');
    
        
            if ($itemslimit > 0 && $itemscount >= $itemslimit) {
                return ['success' => false, 'message' => "You have reached the maximum item limit. Cannot add more items."];
            }
        
            return ['success' => true]; 
        
    
        
    }
    function check_limitations_staff() {
        $CI =& get_instance();
    
        
        $query = $CI->db->select('invoice_json')->get('phppos_invoice');
        $invoicedata = $query->row();
    
        if (!$invoicedata || empty($invoicedata->invoice_json)) {
            return ['success' => false, 'message' => "No invoice JSON found in the database."];
        }
    
       
        $invoiceObj = json_decode($invoicedata->invoice_json, true);
    
        if (!$invoiceObj || !isset($invoiceObj['metadata']['limitations'])) {
            return ['success' => false, 'message' => "Invalid data structure in invoice JSON."];
        }
    
        
        $limitations = $invoiceObj['metadata']['limitations'];
        $stafflimit = isset($limitations['staff']) ? (int) $limitations['staff'] : 0;
    
       
        $staffcount = $CI->db->count_all('employees');
    
      
        if ($stafflimit > 0 && $staffcount >= $stafflimit) {
            return ['success' => false, 'message' => "You have reached the maximum staff limit. Cannot add more employees."];
        }
    
        return ['success' => true]; 
    }
    
    function check_limitations_invoice() {
        $CI =& get_instance();
    
        
        $query = $CI->db->select('invoice_json')->get('phppos_invoice');
        $invoicedata = $query->row();
    
        if (!$invoicedata || empty($invoicedata->invoice_json)) {
            return ['success' => false, 'message' => "No invoice JSON found in the database."];
        }
    
       
        $invoiceObj = json_decode($invoicedata->invoice_json, true);
    
        if (!$invoiceObj || !isset($invoiceObj['metadata']['limitations'])) {
            return ['success' => false, 'message' => "Invalid data structure in invoice JSON."];
        }
    
        
        $limitations = $invoiceObj['metadata']['limitations'];
        $invoicelimit = isset($limitations['invoices']) ? (int) $limitations['invoices'] : 0;
    
       
        $salecount = $CI->db->where('is_work_order', 0)->count_all_results('sales');
    
      
        if ($invoicelimit > 0 && $salecount >= $invoicelimit) {
            return ['success' => false, 'message' => "You have reached the maximum invoice limit. Cannot add more invoice."];
        }
    
        return ['success' => true]; 
    }
    

    function check_limitations_workorder() {
        $CI =& get_instance();
    
        
        $query = $CI->db->select('invoice_json')->get('phppos_invoice');
        $invoicedata = $query->row();
    
        if (!$invoicedata || empty($invoicedata->invoice_json)) {
            return ['success' => false, 'message' => "No invoice JSON found in the database."];
        }
    
       
        $invoiceObj = json_decode($invoicedata->invoice_json, true);
    
        if (!$invoiceObj || !isset($invoiceObj['metadata']['limitations'])) {
            return ['success' => false, 'message' => "Invalid data structure in invoice JSON."];
        }
    
        
        $limitations = $invoiceObj['metadata']['limitations'];
        $workorderlimit = isset($limitations['workorder']) ? (int) $limitations['workorder'] : 0;
    
       
        $salecount = $CI->db->where('is_work_order', 1)->count_all_results('sales');
    
      
        if ($workorderlimit > 0 && $salecount >= $workorderlimit) {
            return ['success' => false, 'message' => "You have reached the maximum work order limit. Cannot add more work order."];
        }
    
        return ['success' => true]; 
    }

    function check_limitations_location() {
        $CI =& get_instance();
    
       
        $query = $CI->db->select('invoice_json')->get('phppos_invoice');
        $invoicedata = $query->row();
    
        if (!$invoicedata || empty($invoicedata->invoice_json)) {
            return ['success' => false, 'message' => "No invoice JSON found in the database."];
        }
    
        
        $invoiceObj = json_decode($invoicedata->invoice_json, true);
    
        if (!$invoiceObj || !isset($invoiceObj['metadata']['limitations'])) {
            return ['success' => false, 'message' => "Invalid data structure in invoice JSON."];
        }
    
       
        $limitations = $invoiceObj['metadata']['limitations'];
        $locationlimit = isset($limitations['location']) ? (int) $limitations['location'] : 0;
    
       
        $locationscount = $CI->db->count_all('locations');
    
     
    
       
        if ($locationlimit > 0 && $locationscount >= $locationlimit) {
            return ['success' => false, 'message' => "You have reached the maximum location limit of $locationscount ."];
        }
    
        return ['success' => true];
    }
    

    function check_limitations_receivings() {
        $CI =& get_instance();
    
        
        $query = $CI->db->select('invoice_json')->get('phppos_invoice');
        $invoicedata = $query->row();
    
        if (!$invoicedata || empty($invoicedata->invoice_json)) {
            return ['success' => false, 'message' => "No invoice JSON found in the database."];
        }
    
       
        $invoiceObj = json_decode($invoicedata->invoice_json, true);
    
        if (!$invoiceObj || !isset($invoiceObj['metadata']['limitations'])) {
            return ['success' => false, 'message' => "Invalid data structure in invoice JSON."];
        }
    
        
        $limitations = $invoiceObj['metadata']['limitations'];
        $receivinglimit = isset($limitations['receiving']) ? (int) $limitations['receiving'] : 0;
    
       
        $receivingscount = $CI->db->count_all('receivings');
    
      
        if ($receivinglimit > 0 && $receivingscount >= $receivinglimit) {
            return ['success' => false, 'message' => "You have reached the maximum receiving limit. Cannot add more receiving."];
        }
    
        return ['success' => true]; 
    }
    // function check_limitations_staff() {
    //     $CI =& get_instance();
    
        
    //     $query = $CI->db->select('invoice_json')->get('phppos_invoice');
    //     $invoicedata = $query->row();
        
    //     if (!$invoicedata || empty($invoicedata->invoice_json)) {
    //         return "No invoice JSON found in the database.";
    //     }
    
       
    //     $invoiceObj = json_decode($invoicedata->invoice_json, true);
    
        
    //     if (!$invoiceObj || !isset($invoiceObj['metadata']['limitations'])) {
    //         return "Invalid data structure in invoice JSON.";
    //     }
    
        
    //     $limitations = $invoiceObj['metadata']['limitations'];
        
        
    //     $stafflimit = (int) $limitations['staff'];
    
    //     echo "pre";
    //     print_r($stafflimit);
    //     exit();
    //     $staffcount = $CI->db->count_all('employees');
    
       
        
    //         if ($stafflimit > 0 && $staffcount >= $stafflimit) {
    //             return true;
    //         }
    //         return false;
   
    
        
    // }

    function check_for_invoices_erp($is_force = false){
        $CI =& get_instance();
        $CI->db->where('id', 1);
        $last_run =  $CI->db->get('sync_log')->row()->last_run;
        // Compare with current date
        $current_date = date('Y-m-d');
        $last_run_date = date('Y-m-d', strtotime($last_run));
    
        if(!$is_force){
            if ($current_date === $last_run_date) {
                return; // Exit if already run today
            }
        }
        // $this->server_url = getenv('ERP_SERVER_URL').'/saas/api/';
        // $this->token = getenv('ERP_SERVER_TOKEN');
        // $this->client_id = getenv('ERP_SERVER_CLIENT');
        $client_id = getenv('ERP_SERVER_CLIENT');
        $erp_url = getenv('ERP_SERVER_URL');
        $token = getenv('ERP_SERVER_TOKEN');
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => ''.$erp_url.'/saas/api/plans?tenant_id='.$client_id.'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'MY-Authorization: '.$token.'',
                'Cookie: csrf_cookie_name=bbd75b8af71c6c4aed774878e7937601; sp_session=93c9bshabu537deuvk20gf509odtamjl'
            ),
            ));

            $response = curl_exec($curl);
            
            curl_close($curl);
            
        $res = json_decode($response);
        curl_close($curl);

        $erpData = [
            "invoice" => $res->invoice, // Replace with actual ERP invoice object
            "payments" => $res->payments // Replace with actual ERP payments array
        ];
        $invoice = $erpData['invoice']; 
        $invoiceJson = json_encode($invoice, JSON_PRETTY_PRINT);

       
        $existingInvoice = get_query_data('SELECT * FROM phppos_invoice WHERE erp_invoice_id = ' . $invoice->id);

        
        if (!empty($existingInvoice)) {  
           
            $updateInvoiceData = [
                'status' => $invoice->status,
                'amount' => $invoice->total,
                'hash' => $invoice->hash,
                'currency' => $invoice->currency,
                'duedate' => $invoice->duedate,
                'recurring' => $invoice->recurring,
                'last_sync' => date('Y-m-d H:i:s'),
                'invoice_json' => $invoiceJson
            ];
            $CI->db->where('erp_invoice_id', $invoice->id);
            $CI->db->update('phppos_invoice', $updateInvoiceData);
        } else {
          
            $insertInvoiceData = [
                'erp_invoice_id' => $invoice->id,
                'status' => $invoice->status,
                'amount' => $invoice->total,
                'hash' => $invoice->hash,
                'currency' => $invoice->currency,
                'duedate' => $invoice->duedate,
                'recurring' => $invoice->recurring,
                'last_sync' => date('Y-m-d H:i:s'),
                'invoice_json' => $invoiceJson
            ];
            $CI->db->insert('phppos_invoice', $insertInvoiceData);
        }

        // dd($erpData);

        $result = sync_erp_data($erpData);
        $CI->db->where('id', 1);
        $CI->db->update('sync_log', ['last_run' => date('Y-m-d H:i:s')]);

        return true; 

            // if ($err) {
            //     echo "cURL Error #:" . $err;
            // } else {
               
            //     $res = json_decode($response)->invoice;
               
            
            //     if($res){
            //         foreach($res->data as $inv){
            //             if($inv->recurring){
            //                 $recurring = $inv->recurring; // Number of recurring months


            //                 $CI->db->select_max('duedate', 'max_date');
            //                 $CI->db->from('phppos_invoice');
            //                 $CI->db->where('invoice_id ',  $inv->id);
            //                 $query = $CI->db->get();
            //                 $max_date = $query->row()->max_date;
                           

            //                 if($max_date){
                              
            //                     $date = $inv->date; // The date to check

            //                     // Calculate the start and end date range for the month
            //                     $start_date = date('Y-m-01', strtotime("+1 months", strtotime($max_date)));
            //                     $end_date = date('Y-m-t', strtotime($max_date));
    
            //                     // Calculate the future end date based on recurring months
            //                     $future_end_date = date('Y-m-d', strtotime("+" . $recurring . " months", strtotime($max_date)));
    

            //                     // Check if the next invoice date is more than 10 days from today
            //                     $today = date('Y-m-d');
            //                     $ten_days_from_today = date('Y-m-d', strtotime("+10 days", strtotime($today)));
            //                     if ($future_end_date < $ten_days_from_today) {


            //                         // Prepare the query conditions
            //                         $CI->db->select('*');
            //                         $CI->db->from('phppos_invoice');
            //                         $CI->db->where('invoice_id ',  $inv->id);
            //                         $CI->db->where('duedate >=', $start_date);
            //                         $CI->db->where('duedate <=', $future_end_date);
            //                         $CI->db->limit(1);
        
            //                         // Execute the query
            //                         $query = $CI->db->get();
                                
            //                         if ($query->num_rows() > 0) {
            //                             echo  $start_date;
            //                             echo $CI->db->last_query();
            //                             exit();
            //                             // Invoice already generated within the recurring months
            //                             echo "Invoice already generated within the recurring months.";
            //                         } else {
            //                             // Generate new invoice for the month
            //                             save_data('phppos_invoice' ,
            //                             [
            //                                 'invoice_id' => $inv->id,
            //                                 'amount' => $inv->total,
            //                                 'duedate' => $future_end_date,
            //                             ]);
            //                             echo "Generate new invoice for the month.";
            //                         }
            //                     }else{
            //                         echo "Invoice already generated within the recurring months more than 10 days.";
            //                     }
            //                 }else{
            //                     $date = $inv->date; // The date to check

            //                     // Calculate the start and end date range for the month
            //                     $start_date = date('Y-m-01', strtotime($date));
            //                     $end_date = date('Y-m-t', strtotime($date));
    
            //                     // Calculate the future end date based on recurring months
            //                     $future_end_date = date('Y-m-t', strtotime("+" . $recurring . " months", strtotime($start_date)));
    
            //                     // Prepare the query conditions
            //                     $CI->db->select('*');
            //                     $CI->db->from('phppos_invoice');
            //                     $CI->db->where('invoice_id ',  $inv->id);
            //                     $CI->db->where('duedate >=', $start_date);
            //                     $CI->db->where('duedate <=', $future_end_date);
            //                     $CI->db->limit(1);
    
            //                     // Execute the query
            //                     $query = $CI->db->get();
    
            //                     if ($query->num_rows() > 0) {
            //                         // Invoice already generated within the recurring months
            //                         echo "Invoice already generated within the recurring months.";
            //                     } else {
            //                         // Generate new invoice for the month
            //                         save_data('phppos_invoice' ,
            //                          [
            //                             'invoice_id' => $inv->id,
            //                             'amount' => $inv->total,
            //                             'duedate' => $future_end_date,
            //                          ]);
            //                         echo "Generate new invoice for the month.";
            //                     }
            //                 }
                           
            //             }else{

            //                 $recurring = 1; // Number of recurring months
            //                 $date = $inv->date; // The date to check

            //                 // Calculate the start and end date range for the month
            //                 $start_date = date('Y-m-01', strtotime($date));
            //                 $end_date = date('Y-m-t', strtotime($date));

            //                 // Calculate the future end date based on recurring months
            //                 $future_end_date = date('Y-m-t', strtotime("+" . $recurring . " months", strtotime($start_date)));



            //                 $CI->db->select('*');
            //                 $CI->db->from('phppos_invoice');
            //                 $CI->db->where('invoice_id ',  $inv->id);
            //                 $CI->db->limit(1);
            //                   // Execute the query
            //                   $query = $CI->db->get();

            //                   if ($query->num_rows() > 0) {
            //                       // Invoice already generated within the recurring months
            //                       echo "Invoice already generated within the recurring months.";
            //                   } else {
            //                       // Generate new invoice for the month
            //                       save_data('phppos_invoice' ,
            //                        [
            //                           'invoice_id' => $inv->id,
            //                           'amount' => $inv->total,
            //                           'duedate' => $future_end_date,
            //                        ]);
            //                       echo "Generate new invoice for the month.";
            //                   }
            //             }
            //         }
            //     }
            
            // }


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