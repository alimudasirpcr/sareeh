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
			left: 26px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(4) {
			left: 26px;
			top: 104px;
			transform: rotate(0deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(5) {
			left: <?= 26 + 100 ?>px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(6) {
			left: <?= 26 + 100 ?>px;
			top: 104px;
			transform: rotate(0deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(7) {
			left: <?= 26 + 200 ?>px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(8) {
			left: <?= 26 + 200 ?>px;
			top: 104px;
			transform: rotate(0deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(9) {
			left: <?= 26 + 300 ?>px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(10) {
			left: <?= 26 + 300 ?>px;
			top: 104px;
			transform: rotate(0deg);
		}
 <?php } ?>
</style>

 	<input type="hidden" id="total_free" value="<?php echo  $total_free; ?>">
				<input type="hidden" id="total_resereved" value="<?php echo  $total_resereved; ?>">
				<input type="hidden" id="total_checkedin" value="<?php echo  $total_checkedin; ?>">

				<?php 
		   foreach($tablest as $tablesd){ ?>
			
			<div  data-rotate="<?= ($tablesd['table']['rotate']=='')?'0':$tablesd['table']['rotate']; ?>" data-title="<?php echo $tablesd['table']['title'] ?>" data-status="<?php echo $tablesd['table']['status'] ?>"   <?php if($tablesd['table']['status']=='Free'){ ?>  onclick="change_table_status(this)" <?php } ?> data-title="<?php echo $tablesd['table']['id'] ?>"  id="<?php echo $tablesd['table']['id'] ?>" data-left="<?php echo $tablesd['table']['pleft'] ?>" data-top="<?php echo $tablesd['table']['ptop'] ?>" class="  draggable col-<?= (count($tablesd['chairs']) >6)?6:4; ?> " style="position: absolute; left:<?php echo $tablesd['table']['pleft'] ?>; top:<?php echo $tablesd['table']['ptop'] ?>; transform: rotate(<?php echo $tablesd['table']['rotate'] ?>deg)">
			<div  class=" table-text">
			
			<?php echo $tablesd['table']['title'] ?>  <br>
				<?php echo $tablesd['table']['status'] ?> <br>
			
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
					} ?>;"> </div>
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
		$last_id = save_data('phppos_reserved', ['table_id' => $table_id , 'date_from' => $from_Date , 'date_to' => $to_Date]);
		 $this->cart->set_reserve_id($last_id);
		 $this->cart->save();

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