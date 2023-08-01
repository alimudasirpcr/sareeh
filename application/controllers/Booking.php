<?php
require_once (APPPATH."models/cart/PHPPOSCartSale.php");
class Booking extends CI_Controller 
{	
	public $cart;
    function __construct()
	{
		parent::__construct();
		$this->lang->load('sales');
		$this->lang->load('module');
		$this->load->helper('order');
		$this->load->helper('items');
		$this->load->helper('sale');
		$this->load->model('Sale');
		$this->load->model('Customer');
		$this->load->model('Tier');
		$this->load->model('Category');
		$this->load->model('Giftcard');
		$this->load->model('Tag');
		$this->load->model('Item');
		$this->load->model('Item_location');
		$this->load->model('Item_kit_location');
		$this->load->model('Item_kit_location_taxes');
		$this->load->model('Item_kit');
		$this->load->model('Item_kit_items');
		$this->load->model('Item_kit_taxes');
		$this->load->model('Item_location_taxes');
		$this->load->model('Item_taxes');
		$this->load->model('Item_taxes_finder');
		$this->load->model('Item_kit_taxes_finder');
		$this->load->model('Appfile');
		$this->load->model('Item_serial_number');
		$this->load->model('Price_rule');
		$this->load->model('Shipping_provider');
		$this->load->model('Shipping_method');
		$this->lang->load('deliveries');
		$this->load->model('Item_variation_location');
		$this->load->model('Item_variations');
		$this->load->helper('giftcards');
		$this->load->model('Item_attribute_value');
		$this->load->model('Item_modifier');
		$this->load->model('Delivery_category');
		$this->load->model('Work_order');
		$this->load->helper('text');
		$this->load->model('Supplier');
		$this->lang->load('work_orders');
	    $this->load->model('Credit_card_charge_unconfirmed');

		$this->cart = PHPPOSCartSale::get_instance('sale');
        
    }
        public function index(){
  


             $tables = get_query_data('select * from phppos_tables ', 'array');
             $new_table=array();
             $i=0;
             foreach( $tables as $table){
                $chairs = get_query_data('select * from phppos_charis where table_id='.$table['id'].' ', 'array');
                $new_table[$i]['table'] = $table;
                $new_table[$i]['chairs'] = $chairs;
                $i++;
             }
            $data['tablest'] = $new_table ; 
            $this->load->view('booking' ,  $data);
        }

		public function kitchen_view(){


			$data =array();
			
			$this->load->view('kitchen' ,  $data);
			
			
		}


		public function change_status(){
			update_data_by_where('phppos_sales' , ['order_status' => $this->input->post('status')] , ['sale_id' =>$this->input->post('id') ]  );

			echo 'true';
		}
		public function load_kitchen_view(){


			$data = array();
			//and  DATE(phppos_sales.sale_time) = CURDATE(); for today only
			
            $allsales = get_query_data('select phppos_sales.* ,phppos_tables.title as table_name , phppos_reserved.date_from , phppos_reserved.date_to ,  phppos_reserved.created_date ,  phppos_reserved.from_new_time ,  phppos_reserved.to_new_time from phppos_sales  left join   phppos_reserved on phppos_reserved.id = phppos_sales.table_id left join phppos_tables on   phppos_tables.id=phppos_reserved.table_id where  phppos_sales.is_order =1  and  DATE(phppos_sales.sale_time) = CURDATE() order by phppos_sales.sale_time desc  ');
			$i=0;
		

		   if($allsales){
			foreach($allsales as $sales){
				$data[$sales->order_status][$i]['receipt'] =  $this->get_single_sales($sales->sale_id);
				$data[$sales->order_status][$i]['sales'] = $sales;
				$i++;
			}
		   }
			
			// echo "<pre>";
			// print_r($data);
			// exit();
			$this->load->view('kitchen_view' ,  $data);

		}

		public function load_order_list(){


			$data = array();
			//and  DATE(phppos_sales.sale_time) = CURDATE(); for today only
			
            $allsales = get_query_data('select phppos_sales.*  ,  phppos_tables.title as table_name , phppos_reserved.date_from , phppos_reserved.date_to ,  phppos_reserved.created_date ,  phppos_reserved.from_new_time ,  phppos_reserved.to_new_time from phppos_sales  left join   phppos_reserved on phppos_reserved.id = phppos_sales.table_id left join phppos_tables on   phppos_tables.id=phppos_reserved.table_id LEFT JOIN phppos_people on phppos_people.person_id= phppos_sales.customer_id where  phppos_people.email="'.$this->input->post('storedEmail').'"  and  phppos_sales.is_order =1  and  DATE(phppos_sales.sale_time) = CURDATE() order by phppos_sales.sale_time desc ');
			$i=0;
		

		   if($allsales){
			foreach($allsales as $sales){
				$data['orders'][$i]['receipt'] =  $this->get_single_sales($sales->sale_id);
				$data['orders'][$i]['sales'] = $sales;
				$i++;
			}
		   }
			
			// echo "<pre>";
			// print_r($data);
			// exit();
			$this->load->view('load_orders' ,  $data);

		}

		public function get_single_sales($sale_id){
			$receipt_cart = PHPPOSCartSale::get_instance_from_sale_id($sale_id);
		
			// if ($receipt_cart->suspended && !$this->Employee->has_module_action_permission('sales', 'view_suspended_receipt', $this->Employee->get_logged_in_employee_info()->person_id))
			// {
			// 	redirect('no_access/'.$this->module_id);
			// }
			
			if ($this->config->item('sort_receipt_column'))
			{
				$receipt_cart->sort_items($this->config->item('sort_receipt_column'));
			}
			
			$data = $this->_get_shared_data();
			
			$data = array_merge($data,$receipt_cart->to_array());
			$data['is_sale'] = FALSE;
			$sale_info = $this->Sale->get_info($sale_id)->row_array();
			$data['is_sale_cash_payment'] = $this->cart->has_cash_payment();
			$data['show_payment_times'] = TRUE;
			$data['signature_file_id'] = $sale_info['signature_image_id'];
			
			$tier_id = $sale_info['tier_id'];
			$tier_info = $this->Tier->get_info($tier_id);
			$data['tier'] = $tier_info->name;
			$data['register_name'] = $this->Register->get_register_name($sale_info['register_id']);
			$data['override_location_id'] = $sale_info['location_id'];
			$data['deleted'] = $sale_info['deleted'];

			$data['receipt_title']= $this->config->item('override_receipt_title') ? $this->config->item('override_receipt_title') : ( !$receipt_cart->suspended ? lang('sales_receipt') : '');
			$data['sales_card_statement']= $this->config->item('override_signature_text') ? $this->config->item('override_signature_text') : lang('sales_card_statement','',array(),TRUE);
			
			$data['transaction_time']= date(get_date_format().' '.get_time_format(), strtotime($sale_info['sale_time']));
			$customer_id=$this->cart->customer_id;
			
			$emp_info=$this->Employee->get_info($sale_info['employee_id']);
			$sold_by_employee_id=$sale_info['sold_by_employee_id'];
			$sale_emp_info=$this->Employee->get_info($sold_by_employee_id);
			$data['payment_type']=$sale_info['payment_type'];
			$data['amount_change']=$receipt_cart->get_amount_due() * -1;
			$data['employee']=$emp_info->first_name.' '.$emp_info->last_name.($sold_by_employee_id && $sold_by_employee_id != $sale_info['employee_id'] ? '/'. $sale_emp_info->first_name.' '.$sale_emp_info->last_name: '');
			$data['employee_firstname']=$emp_info->first_name.($sold_by_employee_id && $sold_by_employee_id != $sale_info['employee_id'] ? '/'. $sale_emp_info->first_name: '');
			$data['ref_no'] = $sale_info['cc_ref_no'];
			$data['auth_code'] = $sale_info['auth_code'];
			$data['discount_exists'] = $this->_does_discount_exists($data['cart_items']);
			$data['disable_loyalty'] = 0;
			$data['sale_id']=$this->config->item('sale_prefix').' '.$sale_id;
			$data['sale_id_raw']=$sale_id;
			$data['store_account_payment'] = FALSE;
			$data['is_purchase_points'] = FALSE;
			
			foreach($data['cart_items'] as $item)
			{
				if ($item->name == lang('common_store_account_payment'))
				{
					$data['store_account_payment'] = TRUE;
					break;
				}
			}

			foreach($data['cart_items'] as $item)
			{
				if ($item->name == lang('common_purchase_points'))
				{
					$data['is_purchase_points'] = TRUE;
					break;
				}
			}
			
			if ($sale_info['suspended'] > 0)
			{
				if ($sale_info['suspended'] == 1)
				{
					$data['sale_type'] = ($this->config->item('user_configured_layaway_name') ? $this->config->item('user_configured_layaway_name') : lang('common_layaway'));
				}
				elseif ($sale_info['suspended'] == 2)
				{
					$data['sale_type'] = ($this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('common_estimate'));
				}
				else
				{
					$this->load->model('Sale_types');
					$data['sale_type'] = $this->Sale_types->get_info($sale_info['suspended'])->name;				
				}
			}
			
			$exchange_rate = $receipt_cart->get_exchange_rate() ? $receipt_cart->get_exchange_rate() : 1;
			
			if($receipt_cart->get_has_delivery())
			{
				$data['delivery_person_info'] = $receipt_cart->get_delivery_person_info();
							
				$data['delivery_info'] = $receipt_cart->get_delivery_info();
			}
			return $data;
		}

		public function get_tables_for_datetime(){


			// $tables = get_query_data('SELECT t.*
			// FROM phppos_tables t
			// WHERE NOT EXISTS (
			// 	SELECT 1
			// 	FROM phppos_reserved r
			// 	WHERE t.id = r.table_id
			// 	  AND (
			// 		  r.date_from <= "2023-07-02 13:44"
			// 		  AND r.date_to >= "2023-07-02 12:44"
			// 	  )
			// ) ', 'array');

			$from_Date = $this->input->post('selected_date');
			$dateTime = new DateTime($from_Date);
			$dateTime->modify("+1 hour");
			$to_Date = $dateTime->format("Y-m-d H:i");

			$tables = get_query_data('SELECT  t.*, t.id AS table_id , COALESCE(r.id, "0") AS reservid , COALESCE(r.status, "Free") AS status
			FROM phppos_tables t
			LEFT JOIN phppos_reserved r ON t.id = r.table_id
				AND r.date_from <= "'.$to_Date.'"
				AND r.date_to >= "'.$from_Date.'"  ', 'array');

			$new_table=array();
            $i=0;

			$total_free=0;
			$total_resereved=0;
			$total_checkedin=0;
            foreach( $tables as $table){
				if($table['status']=='Free'){
					$total_free++;
				}else if($table['status']=='Reserved'){
					$total_resereved++;
				}else{
					$total_checkedin++;
				}
               $chairs = get_query_data('select * from phppos_charis where table_id='.$table['id'].' ', 'array');
               $new_table[$i]['table'] = $table;
               $new_table[$i]['chairs'] = $chairs;
               $i++;
            }
           $tablest = $new_table ; 
 ?>

<style>
<?php foreach($tablest as $tables){ ?>
		.table-square-<?php echo $tables['table']['id']; ?> {
			width: <?php echo calculateTableWidth(count($tables['chairs'])) ?>px;
			background: white;
			border-radius: 9px;
			height: 100px;
			margin: 0 auto;
			position: relative;
			/* background: #d34a220f; */
			color: #d9dee4;
			font-weight: 500;
		}
		.table-square-<?php echo $tables['table']['id']; ?>::before {
			content: "";
			position: absolute;
			border-radius: 10px 0px 0px 10px;
			height: 100%;
			width: 6px;
			left: 0px;
			background-color: <?php if($tables['table']['status']=='Free'){
				echo "#d9dee4";
			}elseif($tables['table']['status']=='Reserved'){
				echo "#ffc144";
			}else{
				echo "#0dc266";
			} ?>;
		}
		.chair-square-<?php echo $tables['table']['id']; ?> {
			position: absolute;
			width: 50px;
			height: 25px;
			border-radius: 0 0 50% 50%;
			
		}
		
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(1) {
			left: -44px;
			top: 35px;
			transform: rotate(90deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(2) {
			left: <?php echo calculatesecondchairposition(count($tables['chairs'])) ?>px;
			top: 35px;
			transform: rotate(270deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(3) {
			left: 52px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(4) {
			left: 52px;
			top: 104px;
			transform: rotate(0deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(5) {
			left: <?= 52 + 150 ?>px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(6) {
			left: <?= 52 + 150 ?>px;
			top: 104px;
			transform: rotate(0deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(7) {
			left: <?= 52 + 300 ?>px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(8) {
			left: <?= 52 + 300 ?>px;
			top: 104px;
			transform: rotate(0deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(9) {
			left: <?= 52 + 400 ?>px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(10) {
			left: <?= 52 + 400 ?>px;
			top: 104px;
			transform: rotate(0deg);
		}
 <?php } ?>

 .plate {
    width: 63%;
    margin-top: -71px;
    margin-left: 9px;
}
</style>

 	<input type="hidden" id="total_free" value="<?php echo  $total_free; ?>">
				<input type="hidden" id="total_resereved" value="<?php echo  $total_resereved; ?>">
				<input type="hidden" id="total_checkedin" value="<?php echo  $total_checkedin; ?>">

				<?php 
		   foreach($tablest as $tablesd){ ?>
			
			<div  data-rotate="<?= ($tablesd['table']['rotate']=='')?'0':$tablesd['table']['rotate']; ?>" data-title="<?php echo $tablesd['table']['title'] ?>" data-status="<?php echo $tablesd['table']['status'] ?>"   <?php if($tablesd['table']['status']=='Free'){ ?>  onclick="change_table_status(this)" <?php } ?> data-title="<?php echo $tablesd['table']['id'] ?>"  id="<?php echo $tablesd['table']['id'] ?>" data-left="<?php echo $tablesd['table']['pleft'] ?>" data-top="<?php echo $tablesd['table']['ptop'] ?>" class="  draggable col-<?= (count($tablesd['chairs']) >6)?6:4; ?> " style="position: absolute; left:<?php echo $tablesd['table']['pleft'] ?>; top:<?php echo $tablesd['table']['ptop'] ?>; transform: rotate(<?php echo $tablesd['table']['rotate'] ?>deg)">
			<div  class=" table-text" style="width: <?php echo count($tablesd['chairs']) * 30 ?>px ">
			
			<?php echo $tablesd['table']['title'] ?>  
				 (<?php echo $tablesd['table']['status'] ?>) <br>
			
				<?php if($this->cart->get_reserve_id()==$tablesd['table']['reservid']): ?>
				<i class="fa fa-check-circle text-success"></i>

			
				<?php endif; ?>
				</div>	
				
			<div class="table-square-<?php echo $tablesd['table']['id'] ?>">
				
					<?php foreach( $tablesd['chairs'] as $chair ){ ?>
							<div  class="chair-square-<?php echo $tablesd['table']['id'] ?>" style="background-color: <?php if($tablesd['table']['status']=='Free'){
						echo "#d9dee4";
					}elseif($tablesd['table']['status']=='Reserved'){
						echo "#ffc144";
					}else{
						echo "#0dc266";
					} ?>;"> <img class="plate" src="<?php  echo base_url() ?>assets/img/plate.png"> </div>
					<?php } ?>
				</div>
			</div>
			<?php } 
		}

        public function table(){
  


            $tables = get_query_data('select * from phppos_tables ', 'array');
            $new_table=array();
            $i=0;
            foreach( $tables as $table){
               $chairs = get_query_data('select * from phppos_charis where table_id='.$table['id'].' ', 'array');
               $new_table[$i]['table'] = $table;
               $new_table[$i]['chairs'] = $chairs;
               $i++;
            }
           $data['tablest'] = $new_table ; 

		   $unpaid_store_account_sales= 0;

		//This is used for upgrade installs that never had this set (sales in progress)
		if ($this->cart->limit === NULL)
		{
			$this->cart->limit = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;	
			$this->cart->save();			
		}
		
		if ($this->cart->offset === NULL)
		{
			$this->cart->offset = 0;	
			$this->cart->save();			
		}
		
		$the_cart_items = $this->cart->get_items();
		
		if ($this->cart->offset >= count($the_cart_items))
		{
			$this->cart->offset = 0;	
			$this->cart->save();			
		}
		$data = array_merge($this->_get_shared_data(),$data);
		$config['base_url'] = site_url('booking/paginate');
		$config['per_page'] = $this->cart->limit; 
		$config['uri_segment'] = -1; //Set this to non possible url so it doesn't use URL
		
		//Undocumented feature to get page
		$config['cur_page'] = $this->cart->offset; 
		
		$config['total_rows'] = count($the_cart_items);


		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['line_for_flat_discount_item'] = $this->cart->get_index_for_flat_discount_item();
		$tiers = array();

		$tiers[0] = lang('common_none');
		foreach($this->Tier->get_all()->result() as $tier)
		{
			$tiers[$tier->id]=$tier->name;
		}
		
		$data['tiers'] = $tiers;


           $this->load->view('bookingfront' ,  $data);
       }

	   public function add_booking(){
		$customer_id = -1;
		$email_send = false;
		$sms_receipt = false;

		if ($this->config->item('sort_receipt_column'))
		{
			$this->cart->sort_items($this->config->item('sort_receipt_column'));
		}

		
		$data = $this->_get_shared_data();
		if($this->config->item('do_not_allow_sales_with_zero_value')){
			if($data['total'] == 0){
				echo json_encode(['status' => false , 'msg' => lang('common_error_if_total_is_zero')] );
			}
		}


		if ($this->cart->get_mode() == 'estimate')
		{
			$data['sale_type'] = $this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('common_estimate');
		}
		$this->load->helper('sale');
		$this->lang->load('deliveries');
		
		if ($this->config->item('do_not_allow_item_with_variations_to_be_sold_without_selecting_variation') && !$this->cart->do_all_variation_items_have_variation_selected())
		{
			
			echo json_encode(['status' => false , 'msg' => lang('common_you_did_not_select_variations_for_applicable_variation_items')] );


		}
		
		if ($this->cart->get_mode() != 'return' && $this->cart->get_mode() != 'estimate' && $this->config->item('do_not_allow_out_of_stock_items_to_be_sold'))
		{
			foreach($this->cart->get_items() as $item)
			{
				if($item->out_of_stock())
				{

					echo json_encode(['status' => false , 'msg' => lang('sales_one_or_more_out_of_stock_items')] );

				}	
			}
		}
		if (empty($data['cart_items']))
		{
			echo json_encode(['status' => false , 'msg' => lang('common_error_if_total_is_zero') ] );
		}

		


		$customer_info = $this->Customer->get_info_by_email($this->input->post('email'));
		if($customer_info!=FALSE){
			$customer_id = $customer_info->person_id;
		}

	
			// adding new customer 
			$person_data = array(
				'title' => $this->input->post('title') ? $this->input->post('title') : null,
				'first_name'	=>	$this->input->post('first_name'),
				'last_name'		=>	$this->input->post('last_name'),
				'email'			=>	$this->input->post('email'),
				'phone_number'	=>	$this->input->post('phone'),
				'address_1'		=>	$this->input->post('address'),
				'address_2'		=>	$this->input->post('address_2') ? $this->input->post('address_2') : '',
				'city'			=>	'',
				'state'			=>	$this->input->post('state') ? $this->input->post('state') : '',
				'zip'			=>	$this->input->post('zip') ? $this->input->post('zip') : '',
				'country'		=>	$this->input->post('country') ? $this->input->post('country') : '',
				'comments'		=>	$this->input->post('comments') ? $this->input->post('comments') : '',
				);
				
			
			$customer_data=array(
				'company_name' 			=> 	'',
				'tier_id' 				=> 	$this->input->post('tier_id') ? $this->input->post('tier_id') : NULL,
				'account_number'		=>	$this->input->post('account_number')=='' ? null:$this->input->post('account_number'),
				'taxable'				=>	$this->input->post('taxable')=='' ? 0:1,
				'tax_certificate' 		=> 	$this->input->post('tax_certificate') ? $this->input->post('tax_certificate') : '',
				'override_default_tax'	=> 	$this->input->post('override_default_tax') ? $this->input->post('override_default_tax') : 0,
				'tax_class_id'			=> 	$this->input->post('tax_class') ? $this->input->post('tax_class') : NULL,
				'internal_notes' 		=> 	$this->input->post('internal_notes') ? $this->input->post('internal_notes') : '',
				'customer_info_popup' 	=> 	'',
				'auto_email_receipt' 	=> 	$this->input->post('auto_email_receipt') ? 1 : 0,
				'always_sms_receipt' 	=> 	$this->input->post('always_sms_receipt') ? 1 : 0,
				'default_term_id' 		=> 	$this->input->post('default_term_id') ? $this->input->post('default_term_id') : NULL,
			);
			
			if ($this->input->post('location_id'))
			{
				$customer_data['location_id'] = $this->input->post('location_id');
			}
			else
			{
				$customer_data['location_id'] = NULL;			
			}

			for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++)
		{
			if ($this->Customer->get_custom_field($k) !== FALSE)
			{			
				if ($this->Customer->get_custom_field($k,'type') == 'checkbox')
				{
					$customer_data["custom_field_{$k}_value"] = $this->input->post("custom_field_{$k}_value");
				}
				elseif($this->Customer->get_custom_field($k,'type') == 'date')
				{
					$customer_data["custom_field_{$k}_value"] = $this->input->post("custom_field_{$k}_value") !== '' ? strtotime($this->input->post("custom_field_{$k}_value")) : NULL;
				}
				elseif(isset($_FILES["custom_field_{$k}_value"]['tmp_name']) && $_FILES["custom_field_{$k}_value"]['tmp_name'])
				{
					if ($this->Customer->get_custom_field($k,'type') == 'image')
					{
				    $this->load->library('image_lib');
					
						$allowed_extensions = array('png', 'jpg', 'jpeg', 'gif');
						$extension = strtolower(pathinfo($_FILES["custom_field_{$k}_value"]['name'], PATHINFO_EXTENSION));
				    if (in_array($extension, $allowed_extensions))
				    {
					    $config['image_library'] = 'gd2';
					    $config['source_image']	= $_FILES["custom_field_{$k}_value"]['tmp_name'];
					    $config['create_thumb'] = FALSE;
					    $config['maintain_ratio'] = TRUE;
					    $config['width']	 = 1200;
					    $config['height']	= 900;
							$this->image_lib->initialize($config);
					    $this->image_lib->resize();
				   	 	$this->load->model('Appfile');
					    $image_file_id = $this->Appfile->save($_FILES["custom_field_{$k}_value"]['name'], file_get_contents($_FILES["custom_field_{$k}_value"]['tmp_name']));
							$customer_data["custom_field_{$k}_value"] = $image_file_id;
						}
					}
					else
					{
			   	 	$this->load->model('Appfile');
						
				    $custom_file_id = $this->Appfile->save($_FILES["custom_field_{$k}_value"]['name'], file_get_contents($_FILES["custom_field_{$k}_value"]['tmp_name']));
						$customer_data["custom_field_{$k}_value"] = $custom_file_id;
						
					}
					
				}
				elseif($this->Customer->get_custom_field($k,'type') != 'image' && $this->Customer->get_custom_field($k,'type') != 'file')
				{
					$customer_data["custom_field_{$k}_value"] = $this->input->post("custom_field_{$k}_value");
				}
			}
		}
		
		if ($this->config->item('enable_customer_loyalty_system'))
		{
			$customer_data['disable_loyalty'] = $this->input->post('disable_loyalty') ? 1 : 0;
		}


		if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced' &&  count(explode(":",$this->config->item('spend_to_point_ratio'),2)) == 2)
		{
      	list($spend_amount_for_points, $points_to_earn) = explode(":",$this->config->item('spend_to_point_ratio'),2);
		
		$spend_amount_for_points = (float)$spend_amount_for_points;
		$points_to_earn = (float)$points_to_earn;
		
			$customer_data['current_spend_for_points'] = $spend_amount_for_points - $this->input->post('amount_to_spend_for_next_point');
		}
		elseif ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'simple')
		{
			$number_of_sales_for_discount = $this->config->item('number_of_sales_for_discount'); 
			$customer_data['current_sales_for_discount'] = $number_of_sales_for_discount - (float)$this->input->post('sales_until_discount');			
		}
		
		if ($this->input->post('balance')!== NULL && is_numeric($this->input->post('balance')))
		{
			$customer_data['balance'] = $this->input->post('balance');
		}

		if ($this->input->post('credit_limit')!== NULL && is_numeric($this->input->post('credit_limit')))
		{
			$customer_data['credit_limit'] = $this->input->post('credit_limit');
		}
		elseif($this->input->post('credit_limit') === '')
		{
			$customer_data['credit_limit'] = NULL;
		}
		
		if ($this->input->post('points')!== NULL && is_numeric($this->input->post('points')))
		{
			$customer_data['points'] = $this->input->post('points');
		}
		
		$redirect_code=$this->input->post('redirect_code');

		if ($this->input->post('delete_cc_info'))
		{
			$customer_data['cc_token'] = NULL;
			$customer_data['cc_expire'] = NULL;
			$customer_data['cc_ref_no'] = NULL;
			$customer_data['cc_preview'] = NULL;
			$customer_data['card_issuer'] = NULL;			
		}

		if($this->Customer->save_customer($person_data,$customer_data,$customer_id))
		{
			if ($this->Location->get_info_for_key('mailchimp_api_key'))
			{
				$this->Person->update_mailchimp_subscriptions($this->input->post('email'), $this->input->post('first_name'), $this->input->post('last_name'), $this->input->post('mailing_lists'));
			}
			
			
			if ($this->Location->get_info_for_key('platformly_api_key'))
			{
				$this->Person->update_platformly_subscriptions($this->input->post('email'), $this->input->post('first_name'), $this->input->post('last_name'), $this->input->post('segments'));
			}
			
	

			$success_message = '';
			
			//New customer
			if($customer_id==-1)
			{
				$this->Appconfig->save('wizard_add_customer',1);				
				$success_message = lang('customers_successful_adding').' '.$person_data['first_name'].' '.$person_data['last_name'];
				$customer_id = $customer_data['person_id'];
				
			}
			else //previous customer
			{
				$this->Appconfig->save('wizard_add_customer',1);
			// 	$success_message = lang('customers_successful_updating').' '.$person_data['first_name'].' '.$person_data['last_name'];
			// 	$this->session->set_flashdata('manage_success_message', H($success_message));
			// 	echo json_encode(array('success'=>true,'message'=>H($success_message),'person_id'=>$customer_id,'redirect_code'=>$redirect_code));
			 }
			
			$customers_taxes_data = array();
			$tax_names = $this->input->post('tax_names');
			$tax_percents = $this->input->post('tax_percents');
			$tax_cumulatives = $this->input->post('tax_cumulatives');

			if (isset($tax_percents)) {
				for($k=0;$k<count($tax_percents);$k++)
				{
					if (is_numeric($tax_percents[$k]))
					{
						$customers_taxes_data[] = array('name'=>$tax_names[$k], 'percent'=>$tax_percents[$k], 'cumulative' => isset($tax_cumulatives[$k]) ? $tax_cumulatives[$k] : '0' );
					}
				}
			}
			
			$this->load->model('Customer_taxes');
			$this->Customer_taxes->save($customers_taxes_data, $customer_id);
			
			$customer_info = $this->Customer->get_info($customer_id);
							
		}
		// end adding new customer
		$this->cart->customer_id = $customer_id;

		
		$tier_id = $this->cart->selected_tier_id;
		$tier_info = $this->Tier->get_info($tier_id);
		$exchange_rate = $this->cart->get_exchange_rate() ? $this->cart->get_exchange_rate() : 1;
		
		$data['tier'] = $tier_info->name;
		$data['register_name'] = $this->Register->get_register_name($this->Employee->get_logged_in_employee_current_register_id());
		$data['is_sale'] = TRUE;
		$data['receipt_title']= $this->config->item('override_receipt_title') ? $this->config->item('override_receipt_title') : ( !$this->cart->suspended ? lang('sales_receipt') : '');
		$data['sales_card_statement']= $this->config->item('override_signature_text') ? $this->config->item('override_signature_text') : lang('sales_card_statement','',array(),TRUE);
		$employee_id=null;
		$customer_id=$this->cart->customer_id;
		$sold_by_employee_id=$this->cart->sold_by_employee_id;
		$emp_info=$this->Employee->get_info($employee_id);
		$sale_emp_info=$this->Employee->get_info($sold_by_employee_id);
		$data['is_sale_cash_payment'] = $this->cart->has_cash_payment();
		$data['amount_change']=$this->cart->get_amount_due() * -1;
		$this->session->set_userdata('amount_change', $data['amount_change'] - $this->session->userdata('tip_amount'));
		
		$store_account_in_all_languages = get_all_language_values_for_key('common_store_account','common');
		
		$data['balance'] = 0;
		//Add up balances for all languages
		foreach($store_account_in_all_languages as $store_account_lang)
		{
				//Thanks Mike for math help on how to convert exchange rate back to get correct balance
				$data['balance']+= $this->cart->get_payment_amount($store_account_lang)*pow($exchange_rate,-1);
		}

		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name.($sold_by_employee_id && $sold_by_employee_id != $employee_id ? '/'. $sale_emp_info->first_name.' '.$sale_emp_info->last_name: '');
		$data['employee_firstname']=$emp_info->first_name.($sold_by_employee_id && $sold_by_employee_id != $employee_id ? '/'. $sale_emp_info->first_name: '');
		$data['ref_no'] = '';
		$data['auth_code'] = '';
		$data['discount_exists'] = $this->_does_discount_exists($data['cart_items']);
		$data['can_email_receipt'] = !$this->cart->email_receipt;
		$data['can_sms_receipt'] = !$this->cart->sms_receipt;
		$masked_account = $this->session->userdata('masked_account') ? $this->session->userdata('masked_account') : '';
		$card_issuer = $this->session->userdata('card_issuer') ? $this->session->userdata('card_issuer') : '';
		$auth_code = $this->session->userdata('auth_code') ? $this->session->userdata('auth_code') : '';
		$ref_no = $this->session->userdata('ref_no') ? $this->session->userdata('ref_no') : '';
		$cc_token = $this->session->userdata('cc_token') ? $this->session->userdata('cc_token') : '';
		$acq_ref_data = $this->session->userdata('acq_ref_data') ? $this->session->userdata('acq_ref_data') : '';
		$process_data = $this->session->userdata('process_data') ? $this->session->userdata('process_data') : '';
		$entry_method = $this->session->userdata('entry_method') ? $this->session->userdata('entry_method') : '';
		$aid = $this->session->userdata('aid') ? $this->session->userdata('aid') : '';
		$tvr = $this->session->userdata('tvr') ? $this->session->userdata('tvr') : '';
		$iad = $this->session->userdata('iad') ? $this->session->userdata('iad') : '';
		$tsi = $this->session->userdata('tsi') ? $this->session->userdata('tsi') : '';
		$arc = $this->session->userdata('arc') ? $this->session->userdata('arc') : '';
		$cvm = $this->session->userdata('cvm') ? $this->session->userdata('cvm') : '';
		$tran_type = $this->session->userdata('tran_type') ? $this->session->userdata('tran_type') : '';
		$application_label = $this->session->userdata('application_label') ? $this->session->userdata('application_label') : '';
		if ($ref_no)
		{
			if (count($this->cart->get_payment_ids(lang('common_credit'))) || count($this->cart->get_payment_ids(lang('common_ebt'))) || count($this->cart->get_payment_ids(lang('common_ebt_cash'))))
			{
				$cc_payment_id = current($this->cart->get_payment_ids(lang('common_credit')));
				if ($cc_payment_id !== FALSE)
				{
					$cc_payment = $data['payments'][$cc_payment_id];
					$this->cart->edit_payment($cc_payment_id, array('payment_type' => $cc_payment->payment_type, 'payment_amount' => $cc_payment->payment_amount,'payment_date' => $cc_payment->payment_date, 'truncated_card' => $masked_account, 'card_issuer' => $card_issuer,'auth_code' => $auth_code, 'ref_no' => $ref_no, 'cc_token' => $cc_token, 'acq_ref_data' => $acq_ref_data, 'process_data' => $process_data, 'entry_method' => $entry_method, 'aid' => $aid, 'tvr' => $tvr, 'iad' => $iad, 'tsi' => $tsi,'arc' => $arc, 'cvm' => $cvm,'tran_type' => $tran_type,'application_label' => $application_label));
				}
				
				$ebt_payment_id = current($this->cart->get_payment_ids(lang('common_ebt')));
				if ($ebt_payment_id !== FALSE)
				{
					$ebt_payment = $data['payments'][$ebt_payment_id];
					
					$ebt_voucher_no = $this->cart->ebt_voucher_no;
					$ebt_auth_code = $this->cart->ebt_auth_code;
						
					$this->cart->edit_payment($ebt_payment_id, array('payment_type' => $ebt_payment->payment_type, 'payment_amount' => $ebt_payment->payment_amount,'payment_date' => $ebt_payment->payment_date, 'truncated_card' => $masked_account, 'card_issuer' => $card_issuer,'auth_code' => $auth_code, 'ref_no' => $ref_no, 'cc_token' => $cc_token, 'acq_ref_data' => $acq_ref_data, 'process_data' => $process_data, 'entry_method' => $entry_method, 'aid' => $aid, 'tvr' => $tvr, 'iad' => $iad, 'tsi' => $tsi,'arc' => $arc, 'cvm' => $cvm,'tran_type' => $tran_type,'application_label' => $application_label,'ebt_voucher_no' => $ebt_voucher_no,'ebt_auth_code' => $ebt_auth_code));
					
					$data['ebt_balance'] = $this->session->userdata('ebt_balance');
					
				}
				
				$ebt_cash_payment_id = current($this->cart->get_payment_ids(lang('common_ebt_cash')));
				if ($ebt_cash_payment_id !== FALSE)
				{
					$ebt_cash_payment = $data['payments'][$ebt_cash_payment_id];
					$this->cart->edit_payment($ebt_cash_payment_id, array('payment_type' => $ebt_cash_payment->payment_type, 'payment_amount' => $ebt_cash_payment->payment_amount,'payment_date' => $ebt_cash_payment->payment_date, 'truncated_card' => $masked_account, 'card_issuer' => $card_issuer,'auth_code' => $auth_code, 'ref_no' => $ref_no, 'cc_token' => $cc_token, 'acq_ref_data' => $acq_ref_data, 'process_data' => $process_data, 'entry_method' => $entry_method, 'aid' => $aid, 'tvr' => $tvr, 'iad' => $iad, 'tsi' => $tsi,'arc' => $arc, 'cvm' => $cvm,'tran_type' => $tran_type,'application_label' => $application_label));
					
					$data['ebt_balance'] = $this->session->userdata('ebt_balance');
					
				}
				
				//Make sure our payments has the latest change to masked_account
				$data['payments'] = $this->cart->get_payments();
			}
		}



		$old_date = $this->cart->get_previous_receipt_id()  ? $this->Sale->get_info($this->cart->get_previous_receipt_id())->row_array() : false;
		$old_date=  $old_date ? date(get_date_format().' '.get_time_format(), strtotime($old_date['sale_time'])) : date(get_date_format().' '.get_time_format());
	
		
		$suspended_change_sale_id=$this->cart->get_previous_receipt_id();
				
		$data['store_account_payment'] = $this->cart->get_mode() == 'store_account_payment' ? 1 : 0;
		$data['is_purchase_points'] = $this->cart->get_mode() == 'purchase_points' ? 1 : 0;
		//If we have a suspended sale, update the date for the sale
		$data['change_cart_date'] = FALSE;
		
		if ($this->cart->change_date_enable)
		{
			$data['change_cart_date'] = $this->cart->change_cart_date;
			$this->cart->change_date_enable = TRUE;
			$this->cart->change_cart_date = $data['change_cart_date'];
		}
		elseif ($this->cart->get_previous_receipt_id() && $this->cart->suspended && $this->config->item('change_sale_date_when_completing_suspended_sale'))
		{
			$data['change_cart_date'] = date('Y-m-d H:i:s');
			$this->cart->change_date_enable = TRUE;
			$this->cart->change_cart_date = $data['change_cart_date'];
		}

				
		$data['transaction_time']= $this->cart->change_date_enable ?  date(get_date_format().' '.get_time_format(), strtotime($this->cart->change_cart_date)) : $old_date;
		
		$this->cart->suspended = 0;
		$this->cart->employee_id = 1;
		//SAVE sale to database
		$sale_id_raw = $this->Sale->save($this->cart , 1); 
		$saved_sale_info = $this->Sale->get_info($sale_id_raw)->row_array();
		if (isset($saved_sale_info['signature_image_id']))
		{
			$data['signature_file_id'] = $saved_sale_info['signature_image_id'];
		}
		
		$tip_amount = $this->session->userdata('tip_amount');
			
		if ($tip_amount)
		{
			$sale_data = array('tip' => $tip_amount);
			$this->Sale->update($sale_data, $sale_id_raw);
		}
		
		//Set exchange details in so receipt has correct info on it (Sale->save clears it out but we need for receipt)
		if ($data['exchange_name'])
		{
			$this->cart->set_exchange_details($this->Sale->get_exchange_details($sale_id_raw));
			for($k=0;$k<count($data['payments']);$k++)
			{
				$data['payments'][$k]->payment_amount = $data['payments'][$k]->payment_amount*$exchange_rate;
			}
			
		}
		
		$data['sale_id']=$this->config->item('sale_prefix').' '.$sale_id_raw;
		$data['sale_id_raw']=$sale_id_raw;
		
		$data['disable_loyalty'] = 0;
		
		if($customer_id)
		{
			$cust_info=$this->Customer->get_info($customer_id);
			$data['customer']=$cust_info->first_name.' '.$cust_info->last_name.($cust_info->account_number==''  ? '':' - '.$cust_info->account_number);
			$data['customer_company']= $cust_info->company_name;
			$data['customer_address_1'] = $cust_info->address_1;
			$data['customer_address_2'] = $cust_info->address_2;
			$data['customer_city'] = $cust_info->city;
			$data['customer_state'] = $cust_info->state;
			$data['customer_zip'] = $cust_info->zip;
			$data['customer_country'] = $cust_info->country;
			$data['customer_phone'] = format_phone_number($cust_info->phone_number);
			$data['customer_email'] = $cust_info->email;			
			
			$data['customer_points'] = $cust_info->points;			
		  	$data['sales_until_discount'] = ($this->config->item('number_of_sales_for_discount') ? $this->config->item('number_of_sales_for_discount') : 0) - $cust_info->current_sales_for_discount;
 			$data['disable_loyalty'] = $cust_info->disable_loyalty;
	
			$cust_info=$this->Customer->get_info($customer_id);
			if($this->config->item('customers_store_accounts'))
			{	
				$data['customer_balance_for_sale'] = $cust_info->balance;
			}
		}
		
		
		if ($data['sale_id'] == $this->config->item('sale_prefix').' -1')
		{
			$data['error_message'] = '';
			$this->load->helper('sale');
			if (is_sale_integrated_cc_processing($this->cart))
			{
				$this->cart->change_credit_card_payments_to_partial();
				$data['error_message'].='<span class="text-success">'.lang('sales_credit_card_transaction_completed_successfully').'. </span><br /<br />';
			}
			$data['error_message'] .= '<span class="text-danger">'.lang('sales_transaction_failed').'</span>';
			$data['error_message'] .= '<br /><br />'.anchor('sales','&laquo; '.lang('sales_register'));
			$data['error_message'] .= '<br /><br />'.anchor('sales/complete',lang('common_try_again'). ' &raquo;');
		}
		else
		{			

			$this->session->unset_userdata('scroll_to');
			
			if ($this->session->userdata('CC_SUCCESS'))
			{
				$credit_card_processor = $this->_get_cc_processor();
		
				if ($credit_card_processor)
				{
					$cc_processor_class_name = strtoupper(get_class($credit_card_processor));
					$cc_processor_parent_class_name = strtoupper(get_parent_class($credit_card_processor));
			
					if ($cc_processor_class_name == 'CORECLEARBLOCKCHYPPROCESSOR')
					{
						$data['prompt_for_customer_info'] = TRUE;
					}
					
					if ($cc_processor_parent_class_name == 'DATACAPUSBPROCESSOR')
					{
						$data['reset_params'] = $credit_card_processor->get_emv_pad_reset_params();
					}
					
					if ($cc_processor_parent_class_name == 'DATACAPTRANSCLOUDPROCESSOR')
					{
						$data['trans_cloud_reset'] = TRUE;
					}
				}		
			}
			
			
			if ($this->cart->email_receipt && !empty($cust_info->email))
			{
				$email_send = true;
			}

			if ($this->cart->sms_receipt && !empty($cust_info->phone_number))
			{
				$sms_receipt = true;
			}
			
		}
		
		if($this->cart->get_has_delivery())
		{
			$data['delivery_person_info'] = $this->cart->get_delivery_person_info();
						
			$data['delivery_info'] = $this->cart->get_delivery_info();
		}
		
		if($email_send === true || (isset($cust_info) && $cust_info->auto_email_receipt == 1)){
			
			if($this->config->item('enable_pdf_receipts')){
				$receipt_data = $this->load->view("sales/receipt_html", $data, true);
				
				if($this->config->item('receipt_download_filename_prefix')){
					$filename = $this->config->item('receipt_download_filename_prefix').'_receipt_'.$sale_id_raw.'.pdf';
				}else{
					$filename = 'receipt_'.$sale_id_raw.'.pdf';
				}
				$this->load->library("m_pdf");
				$pdf_content = $this->m_pdf->generate_pdf($receipt_data);
			}
			
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($this->Location->get_info_for_key('email') ? $this->Location->get_info_for_key('email') : $this->config->item('branding')['no_reply_email'], $this->config->item('company'));
			$this->email->to($cust_info->email);
			
			if($this->Location->get_info_for_key('cc_email'))
			{
				$this->email->cc($this->Location->get_info_for_key('cc_email'));
			}
			
			if($this->Location->get_info_for_key('bcc_email'))
			{
				$this->email->bcc($this->Location->get_info_for_key('bcc_email'));
			}
			
			$this->email->subject($this->config->item('emailed_receipt_subject') ? $this->config->item('emailed_receipt_subject') : lang('sales_receipt'));
			
			if($this->config->item('enable_pdf_receipts')){
				if(isset($pdf_content) && $pdf_content){
					$this->email->attach($pdf_content, 'attachment', $filename, 'application/pdf');
					$this->email->message(nl2br($this->config->item('pdf_receipt_message')));
				}
			}else{
				$this->email->message($this->load->view("sales/receipt_email",$data, true));	
			}
			$this->email->send();
			$data['email_sent'] = TRUE;
		}

		if($sms_receipt || (isset($cust_info) && $cust_info->always_sms_receipt)){
			$this->Sale->sms_receipt($sale_id_raw);
		}
		
		if ($this->Location->get_info_for_key('email_sales_email'))
		{
			if($this->config->item('enable_pdf_receipts')){
				$receipt_data = $this->load->view("sales/receipt_html", $data, true);
				
				if($this->config->item('receipt_download_filename_prefix')){
					$filename = $this->config->item('receipt_download_filename_prefix').'_receipt_'.$sale_id_raw.'.pdf';
				}else{
					$filename = 'receipt_'.$sale_id_raw.'.pdf';
				}
				$this->load->library("m_pdf");
					$pdf_content = $this->m_pdf->generate_pdf($receipt_data);
				}
			
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($this->Location->get_info_for_key('email') ? $this->Location->get_info_for_key('email') : $this->config->item('branding')['no_reply_email'], $this->config->item('company'));
			$this->email->to($this->Location->get_info_for_key('email_sales_email'));
			
			if($this->Location->get_info_for_key('cc_email'))
			{
				$this->email->cc($this->Location->get_info_for_key('cc_email'));
			}
			
			if($this->Location->get_info_for_key('bcc_email'))
			{
				$this->email->bcc($this->Location->get_info_for_key('bcc_email'));
			}
			
			$this->email->subject($this->config->item('emailed_receipt_subject') ? $this->config->item('emailed_receipt_subject') : lang('sales_receipt'));
			
			if($this->config->item('enable_pdf_receipts')){
				if(isset($pdf_content) && $pdf_content){
					$this->email->attach($pdf_content, 'attachment', $filename, 'application/pdf');
					$this->email->message(nl2br($this->config->item('pdf_receipt_message')));
				}
			}else{
				$this->email->message($this->load->view("sales/receipt_email",$data, true));	
			}
			$this->email->send();
		}
		
		// Get Store Config work_order_status_on_complete and update work order status if needed 
		if($this->config->item('work_order_status_on_complete')) {
			$work_order_status_on_complete = $this->config->item('work_order_status_on_complete');
			if($work_order_status_on_complete != lang('config_do_not_change')){
				// Get Sale Work Order ID
				$work_order_info 	= $this->Work_order->get_info_by_sale_id($sale_id_raw)->row();
				$work_order_id 		= $work_order_info->id;
				
				if($work_order_id != '0'){
					// Update Work Order Status
					
					if (!$this->cart->create_work_order)
					{
						$this->Work_order->change_status($work_order_id, $work_order_status_on_complete);
					}
				}
			}
		}
		
		//$this->load->view("sales/receipt",$data);
		
		if ($data['sale_id'] != $this->config->item('sale_prefix').' -1')
		{
			$this->cart->destroy();
			$this->cart->save();
			$this->Appconfig->save('wizard_create_sale',1);				
		}
		
		//We need to reset this data because is already gone when saving sale
		$final_cart_data = array();
		$final_cart_data['subtotal'] = $data['subtotal'];
		$final_cart_data['total'] = $data['total'];
		$final_cart_data['tax'] = $data['total'] - $data['subtotal'];
		$final_cart_data['exchange_rate'] = $data['exchange_rate'];
		$final_cart_data['exchange_name'] = $data['exchange_name'];
		$final_cart_data['exchange_symbol'] = $data['exchange_symbol'];
		$final_cart_data['exchange_symbol_location'] = $data['exchange_symbol_location'];
		$final_cart_data['exchange_number_of_decimals'] = $data['exchange_number_of_decimals'];
		$final_cart_data['exchange_thousands_separator'] = $data['exchange_thousands_separator'];
		$final_cart_data['exchange_decimal_point'] = $data['exchange_decimal_point'];
		//Update cutomer facing display
		$this->Register_cart->set_data($final_cart_data,$this->Employee->get_logged_in_employee_current_register_id());
		$this->Register_cart->add_data(array('can_email' => $data['can_email_receipt'], 'can_sms' => $data['can_sms_receipt'], 'sale_id' => $sale_id_raw),$this->Employee->get_logged_in_employee_current_register_id());		

		echo json_encode(['status' => true , 'msg' => 'Completed successfully'] );



	   }



	   function _does_discount_exists($cart)
	   {
		   foreach($cart as $line=>$item)
		   {
			   if( (isset($item->discount) && $item->discount >0 ) || (is_array($item) && isset($item['discount_percent']) && $item['discount_percent'] >0 ) )
			   {
				   return TRUE;
			   }
		   }
		   
		   return FALSE;
	   }
	   
	   function _payments_cover_total()
			{
				$total_payments = 0;

				foreach($this->cart->get_payments() as $payment)
				{
					$total_payments += $payment->payment_amount;
				}

				/* Changed the conditional to account for floating point rounding */
				if ( ( $this->cart->get_mode() == 'sale' || $this->cart->get_mode() == 'store_account_payment' ) && ( ( to_currency_no_money( $this->cart->get_total() ) - $total_payments ) > 1e-6 ) )
				{
					return false;
				}
				return true;
			}
	   private function _validate_custom_fields()
	   {
		   $current_location = $this->Employee->get_logged_in_employee_current_location_id();
		   for ($k = 1; $k <= NUMBER_OF_PEOPLE_CUSTOM_FIELDS; $k++) { 
			   $custom_field = $this->Sale->get_custom_field($k);
			   if ($custom_field !== FALSE) {
				   if($this->Sale->get_custom_field($k,'required') && in_array($current_location,$this->Sale->get_custom_field($k,'locations')) && !$this->cart->{"custom_field_${k}_value"}){
					   $this->_reload(array('error' => $custom_field.' '.lang('is_required')), false);
					   return FALSE;
				   }
			   }
		   }
		   
		   return TRUE;
	   }

	   public function update_table_status_front(){
		

		if ($this->cart->get_reserve_id() !== NULL)
		{
			delete_data('phppos_reserved' , $this->cart->get_reserve_id());
		}
		$table_id = $this->input->post('table_id');
		$from_Date = $this->input->post('date_from');
		$dateTime = new DateTime($from_Date);
		$dateTime->modify("+1 hour");
		$to_Date = $dateTime->format("Y-m-d H:i");

		$from_new_time = $this->date_time_convertions_timezone($from_Date ,$this->input->post('user_timezone'));
		$to_new_time = $this->date_time_convertions_timezone($to_Date ,$this->input->post('user_timezone'));
		$created_date =date('Y-m-d H:i');



		$last_id = save_data('phppos_reserved', [
			'table_id' => $table_id , 
			'date_from' => $from_Date , 
			'date_to' => $to_Date,
			'from_new_time' => $from_new_time,
			'to_new_time' => $to_new_time,
			'created_date' => $created_date,
		]);
		 $this->cart->set_reserve_id($last_id);
		 $this->cart->save();

		}

		function date_time_convertions_timezone($from_date , $user_timz){
			$userDateTime = $from_date; // Assuming you're receiving the user's datetime from a form

			$userTimezone = new DateTimeZone( $user_timz); // Assuming you're receiving the user's timezone from a form
			
			$serverTimezone = new DateTimeZone(date_default_timezone_get()); // Replace 'Your Server Timezone' with your server's timezone
			
			$userDateTimeObject = new DateTime($userDateTime, $userTimezone);
			$userDateTimeObject->setTimezone($serverTimezone);
			
			$serverDateTime = $userDateTimeObject->format('Y-m-d H:i:s');

			return $serverDateTime;
	
		}


	   function add()
	   {				
		   $barcode_scan_data = $this->input->post("item");
		   $quantity = $this->input->post("quantity");
		   $secondary_supplier_id = $this->input->post("secondary_supplier_id");
		   $default_supplier_id = $this->input->post("default_supplier_id");
   
		   $this->cart->sort_clean();
		   if($this->cart->is_valid_receipt($barcode_scan_data) && $this->cart->get_mode()=='sale')
		   {
			   $this->_edit_or_suspend_sale($barcode_scan_data);
			   $this->_reload();
			   return;
		   }
		   
		   $this->cart->process_barcode_scan($barcode_scan_data,array('quantity' => $quantity,'run_price_rules' => TRUE, 'secondary_supplier_id' => $secondary_supplier_id, 'default_supplier_id'=> $default_supplier_id));
		   if ($this->cart->has_recurring_item())
		   {
			   $this->cart->selected_payment = lang('common_credit');
		   }
		   
		   $this->cart->save();
   
		   $this->_reload();
	   }

	   function _reload($data=array(), $is_ajax = true){
		$unpaid_store_account_sales= 0;

		

		//This is used for upgrade installs that never had this set (sales in progress)
		if ($this->cart->limit === NULL)
		{
			$this->cart->limit = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;	
			$this->cart->save();			
		}
		
		if ($this->cart->offset === NULL)
		{
			$this->cart->offset = 0;	
			$this->cart->save();			
		}
		
		$the_cart_items = $this->cart->get_items();
		
		if ($this->cart->offset >= count($the_cart_items))
		{
			$this->cart->offset = 0;	
			$this->cart->save();			
		}
		$data = array_merge($this->_get_shared_data(),$data);
		$config['base_url'] = site_url('booking/paginate');
		$config['per_page'] = $this->cart->limit; 
		$config['uri_segment'] = -1; //Set this to non possible url so it doesn't use URL
		
		//Undocumented feature to get page
		$config['cur_page'] = $this->cart->offset; 
		
		$config['total_rows'] = count($the_cart_items);
		$cart_items = $data['cart_items'];
		$cart = $data['cart'];
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$pagination = $this->pagination->create_links();
		$line_for_flat_discount_item = $this->cart->get_index_for_flat_discount_item();
		
		


			?>
			<?php 
															
															$cart_count = 0;
															if ($pagination) { ?>
				<div class="page_pagination pagination-top hidden-print  text-center" id="pagination_top">
					<?php echo $pagination; ?>
				</div>
			<?php } ?>

			<?php if ($this->config->item('allow_drag_drop_sale') && !$this->agent->is_mobile() && !$this->agent->is_tablet()) {  ?>

			<style>
				#register tbody{
					cursor: move;
				}
				#register th.item_sort_able{
					cursor: pointer;
				}
				#grid-loader2.spinner > div {
					height: 100px;
					width: 8px;
					margin-right: 2px;
					margin-top: 30px;
					top: 50%;
				}						
			</style>
			<?php } ?>
			<div class="spinner" id="grid-loader2" style="display: none;">
				<div class="rect1"></div>
				<div class="rect2"></div>
				<div class="rect3"></div>
			</div>	
			<table id="register" class="table table-striped gy-7 gs-7">
				<thead>
					<tr class="register-items-header">
						<th><a href="javascript:void(0);" id="sale_details_expand_collapse" class="expand">-</a></th>
						<th class="item_sort_able item_name_heading <?php echo $this->cart->sort_column && $this->cart->sort_column == 'name'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('sales_item_name'); ?></th>
						<th class="item_sort_able sales_price <?php echo $this->cart->sort_column && $this->cart->sort_column == 'unit_price'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('common_price'); ?></th>
						<th class="item_sort_able sales_quantity <?php echo $this->cart->sort_column && $this->cart->sort_column == 'quantity'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('common_quantity'); ?></th>
						<th class="item_sort_able sales_discount <?php echo $this->cart->sort_column && $this->cart->sort_column == 'discount'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('common_discount_percent'); ?></th>
						<th class="item_sort_able sales_total <?php echo $this->cart->sort_column && $this->cart->sort_column == 'total'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('common_total'); ?></th>
					</tr>
				</thead>

					<?php
					if($this->config->item('allow_drag_drop_sale') == 1 && !$this->agent->is_mobile() && !$this->agent->is_tablet()){
						$cart_items = $cart->get_list_sort_by_receipt_sort_order();
					}

					if (count($cart_items) == 0) { ?>
					<tbody class="register-item-content">
						<tr class="cart_content_area">
							<td colspan='6'>
								<div class='text-center text-warning'>
									<h3><?php echo lang('common_no_items_in_cart'); ?><span class="flatGreenc"> [<?php echo lang('module_sales') ?>]</span></h3>
								</div>
							</td>
						</tr>
					</tbody>
						<?php
					} else {

						$start_index = $cart->offset + 1;
						$end_index = $cart->offset + $cart->limit;

						$the_cart_row_counter = 1;
						foreach (array_reverse($cart_items, true) as $line => $item) {
							if($this->config->item('hide_repair_items_in_sales_interface')){
								if($item->is_repair_item == 1){
									continue;
								}
							}
							if($this->config->item('allow_drag_drop_sale') == 1 && !$this->agent->is_mobile() && !$this->agent->is_tablet()){
								$line = $item->line_index;
							}

							if ($item->quantity > 0 && $item->name != lang('common_store_account_payment') && $item->name != lang('common_discount')) {
								$cart_count = $cart_count + $item->quantity;
							}

							if (!(($start_index <= $the_cart_row_counter) && ($the_cart_row_counter <= $end_index))) {
								$the_cart_row_counter++;
								continue;
							}
							$the_cart_row_counter++;

							?>
							<tbody class="register-item-content" data-line="<?php echo $line; ?>">
								<tr class="register-item-details">

									
										<td class="text-center"> <?php echo anchor("sales/delete_item/$line", '<i class="icon ion-android-cancel"></i>', array('class' => 'delete-item', 'tabindex' => '-1')); ?> </td>
									
									<td>
											<?php if (property_exists($item,'is_recurring') && $item->is_recurring)
											{
											?>	
											<i class="icon ti-loop"></i>
											
											<?php
											}
											?>
										
										<a tabindex="-1" href="<?php echo isset($item->item_id) ? site_url('home/view_item_modal/' . $item->item_id) . "?redirect=sales" : site_url('home/view_item_kit_modal/' . $item->item_kit_id) . "?redirect=sales"; ?>" data-toggle="modal" data-target="#myModal" class="register-item-name"><?php echo H($item->name).(property_exists($item, 'variation_name') && $item->variation_name ? '<span class="show-collpased" style="display:none">  ['.$item->variation_name.']</span>' : '') ?><?php echo $item->size ? ' (' . H($item->size) . ')' : ''; ?></a>
									</td>
									<td class="text-center">
									

										<?php 
											echo to_currency($item->unit_price);
										
										?>

									</td>
									<td class="text-center">
										<?php  
												if ($this->config->item('number_of_decimals_displayed_on_sales_interface')) {
													echo to_currency_no_money($item->quantity, $this->config->item('number_of_decimals_displayed_on_sales_interface'));
												} else {
													echo to_quantity($item->quantity);
												}
											
										?>
									</td>
									<td class="text-center">
										<?php
									
											echo to_quantity($item->discount) . '%';
										
										?>
									</td>
									<td class="text-center">
										<?php
										
											echo to_currency($item->unit_price * $item->quantity - $item->unit_price * $item->quantity * $item->discount / 100);
										
										?>

									</td>
								</tr>
								
							</tbody>
					<?php }
					}  ?>
			</table>

			<?php if ($pagination) { ?>
				<div class="page_pagination pagination-top hidden-print  text-center" id="pagination_top">
					<?php echo $pagination; ?>
				</div>
			<?php } ?>
       <?php

	   }
	   private function _get_shared_data()
	   {
		   $data = $this->cart->to_array();
		   
		   $modes = array('sale'=>lang('sales_sale'),'return'=>lang('sales_return'), 'estimate' => $this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('common_estimate'));
		   
		//    if (!$this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id))
		//    {
		// 	   unset($modes['return']);
		//    }
		   if($this->config->item('customers_store_accounts')) 
		   {
			   $modes['store_account_payment'] = lang('common_store_account_payment');
		   }
		   $data['modes'] = $modes;
		   
		   if(isset($this->view_data)){
				foreach($this->view_data as $key=>$value)
				{
					$data[$key] = $value;
				}
		   }
		  
		   
		   $this->load->model('Sale_types');
		   $data['additional_sale_types_suspended'] = $this->Sale_types->get_all(!$this->config->item('ecommerce_platform') ? $this->config->item('ecommerce_suspended_sale_type_id') : NULL)->result_array();
		   return $data;
	   }


        public function save_position(){
                $tables = json_decode($this->input->post('tables'));
               foreach($tables as $table){
                    if(isset($table->id)){
                      
                        update_data('phppos_tables', ['pleft' => $table->newleft , 'ptop' => $table->newtop, 'rotate' => $table->rotate] ,  $table->id );
                        echo "<br>".$this->db->last_query();
                    }
               }

        }

        public function add_table(){
            $title = $this->input->post('title');
            $chairs = $this->input->post('chairs');

             $last_id = save_data('phppos_tables' , ['status' => 'Free' , 'title' => $title, 'ptop' => '25px'   , 'pleft' => '25px' , 'no_of_chairs' =>$chairs  ]);

                for($i=0; $i < $chairs; $i++    ){
                    save_data('phppos_charis', ['table_id' => $last_id , 'status'=> 'free']);
                }
        }

        public function update_chair_status(){
            $status = $this->input->post('status');
            $chair_id = $this->input->post('chair_id');
            update_data('phppos_charis', ['status' => $status ] ,$chair_id  );
        }

        public function update_table_status(){
            $table_status = $this->input->post('table_status');
            $table_id = $this->input->post('table_id');
            $table_title = $this->input->post('table_title');
            update_data('phppos_tables', ['status' => $table_status , 'title' => $table_title  ] ,$table_id  );
        }

        public function categories($parent_id = NULL, $offset = 0)
	{
		//allow parallel searchs to improve performance.
		session_write_close();
		
		//If a false value, make sure it is NULL
		if (!$parent_id)
		{
				$parent_id = NULL;
		}
		$categories = $this->Category->get_all($parent_id,FALSE, $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 14, $offset);
		
		$categories_count = $this->Category->count_all($parent_id);		
		$config['base_url'] = site_url('sales/categories/'.($parent_id ? $parent_id : 0));
		$config['uri_segment'] = 4;
		$config['total_rows'] = $categories_count;
		$config['per_page'] = $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 14; 
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$categories_response = array();
		$this->load->model('Appfile');
		foreach($categories as $id=>$value)
		{
			$categories_response[] = array('id' => $id, 'name' => $value['name'], 'color' => $value['color'], 'image_id' => $value['image_id'], 'image_timestamp' => $this->Appfile->get_file_timestamp($value['image_id']));
		}
		
		$data = array();
		$data['categories'] = H($categories_response);
		$data['pagination'] = $this->pagination->create_links();
		
		echo json_encode($data);	
	}

    function categories_and_items($category_id = NULL, $offset = 0)
	{
		$this->load->model('Item_variations');
		
		//allow parallel searchs to improve performance.
		session_write_close();
		
		//If a false value, make sure it is NULL
		if (!$category_id)
		{
			$category_id = NULL;
		}
		
		//Categories
		$categories = $this->Category->get_all($category_id);
		$categories_count = count($categories);		
		$config['base_url'] = site_url('sales/categories_and_items/'.($category_id ? $category_id : 0));
		$config['uri_segment'] = 4;
		$config['per_page'] = $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 14; 
		
		$categories_and_items_response = array();
		$this->load->model('Appfile');
		foreach($categories as $id=>$value)
		{
			$categories_and_items_response[] = array('id' => $id, 'name' => $value['name'], 'color' => $value['color'], 'image_id' => $value['image_id'],'image_timestamp' => $this->Appfile->get_file_timestamp($value['image_id']),'type' => 'category');
		}
		
		//Items
		$items = array();
		
		$items_offset = ($offset - $categories_count > 0 ? $offset - $categories_count : 0);		
		$items_result = $this->Item->get_all_by_category($category_id, $this->config->item('hide_out_of_stock_grid') ? TRUE : FALSE, $items_offset, $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 14)->result();
		
		foreach($items_result as $item)
		{
			$img_src = "";
			if ($item->image_id != 'no_image' && $item->image_id && trim($item->image_id) != '') {
				$img_src = cacheable_app_file_url($item->image_id);
			}
			
			$size = $item->size ? ' - '.$item->size : '';
			
			if (strpos($item->item_id, 'KIT') === 0)
			{
				$price_to_use = $this->Item_kit->get_sale_price(array('item_kit_id' => str_replace('KIT','',$item->item_id)));
			}
			else
			{
				$price_to_use = $this->Item->get_sale_price(array('item_id' => $item->item_id));
			}
			
			$categories_and_items_response[] = array(
				'id' => $item->item_id,
				'name' => character_limiter($item->name, 58).$size,				
				'image_src' => 	$img_src,
				'has_variations' => count($this->Item_variations->get_variations($item->item_id)) > 0 ? TRUE : FALSE,
				'type' => 'item',		
				'price' => $price_to_use != '0.00' ? to_currency($price_to_use) : FALSE,
				'regular_price' => to_currency($item->unit_price),	
				'different_price' => $price_to_use != $item->unit_price,	
			);	
		}
	
		$items_count = $this->Item->count_all_by_category($category_id);		
		$categories_and_items_response = array_slice($categories_and_items_response, $offset > $categories_count ? $categories_count : $offset, $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : 14);
		
		$data = array();
		$data['categories_and_items'] = H($categories_and_items_response);
		$config['total_rows'] = $categories_count + $items_count;
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		echo json_encode($data);
	}
	
	function item_variations($item_id)
	{
		$variations = array();
		$this->load->model('Item_variations');

		$variation_result = $this->Item_variations->get_variations($item_id);
	
		foreach($variation_result as $variation_id => $variation)
		{
			
			$img_src = "";
			if (isset($variation['image']['image_id']) && $variation['image']['image_id']) 
			{
				$img_src = cacheable_app_file_url($variation['image']['image_id']);
			}
					
			$cur_item_info = $this->Item->get_info($item_id);
			$cur_item_location_info = $this->Item_location->get_info($item_id);
			
			if ($variation['unit_price'])
			{
				$price_to_use = $variation['unit_price'];
			}
			else
			{
				$price_to_use = ($cur_item_location_info && $cur_item_location_info->unit_price) ? $cur_item_location_info->unit_price : $cur_item_info->unit_price;
			}
			
			$cur_item_variation_location_info = $this->Item_variation_location->get_info($variation_id);
			
			if (!($this->config->item('hide_out_of_stock_grid') && $cur_item_variation_location_info->quantity <=0))
			{
			
			$variations[] = array(
				'id' => $item_id.'#'.$variation_id,
				'name' => $variation['name'] ? $variation['name'] : implode(', ', array_column($variation['attributes'],'label')),				
				'image_src' => 	$img_src,
				'type' => 'variation',		
				'has_variations' => FALSE,
				'price' => $price_to_use !== FALSE ? to_currency($price_to_use) : FALSE,		
				);	
			}
		}

		
		echo json_encode(H($variations));
	}
}