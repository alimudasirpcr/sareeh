<?php
class Work_order extends CI_Model
{
	public function __construct()
	{
      parent::__construct();
	}
	
	public function get_info($work_order_id)
	{
		$this->db->select('sales_work_orders.*, date(sale_time) as sale_date ,sales.sale_time,CONCAT(first_name, " ",last_name) as employee_name,people.email,people.phone_number,sales.customer_id');
		$this->db->from('sales_work_orders');
		$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id');
		$this->db->join('people', 'people.person_id = sales_work_orders.employee_id','left');
		$this->db->where('id',$work_order_id);
		return $this->db->get();
	}

	public function getSummaryData($work_order_id)
	{
		
		
		$row = $this->get_info($work_order_id)->result()[0];
		$this->db->from('sales');
		
		
		$this->db->select('sales.sale_id , date(sale_time) as sale_date, subtotal ,  total,  tax,  profit', false);
		
		
	
		$this->db->where('sales.is_work_order' , 1);
		$this->db->where('sales.sale_id' , $row->sale_id);
		
		
		$return = array(
			'subtotal' => 0,
			'total' => 0,
			'tax' => 0,
			'profit' => 0,
			'sales_per_time_period' => 0,
			'sale_date' => 0,
			'sale_id' => 0,
		);
		
		$rows = 0;
		
	// dd($this->db->get()->result_array());
		
		foreach($this->db->get()->result_array() as $row)
		{
			$return['subtotal'] += to_currency_no_money($row['subtotal'],2);
			$return['total'] += to_currency_no_money($row['total'],2);
			$return['tax'] += to_currency_no_money($row['tax'],2);
			$return['profit'] += to_currency_no_money($row['profit'],2);
			$return['sale_date'] = $row['sale_date'];
			$return['sale_id'] = $row['sale_id'];
			$rows++;
		}
		
		
		
			
		
		return $return;
	}

	public function get_single_work_order_summary($work_order_id){
		$row = $this->getSummaryData($work_order_id);
		// dd($row);
		
		
		$prefix = $this->db->dbprefix;
			$graph_data = array();
			$net_customer_will_pay = array();
			$customer_will_pay_for_services =array();
			$customer_will_pay_for_parts =array();
			$sp_will_pay_to_owner=array();
			$sp_will_receive_from_customer=array();
			$sp_will_receive_for_his_services=array();
			$owner_have_to_pay_to_sp=array();
			$owner_have_to_pay_for_parts=array();
			$net_amount_for_owner=array();
			$net_amount_sp=array();


		
			$report_data = $row;
					$report_data['net_customer_will_pay'] =0 ;
					$report_data['customer_will_pay_for_services'] =0 ;
					$report_data['customer_will_pay_for_parts'] =0 ;
					$report_data['sp_will_pay_to_owner']=0;
					$report_data['sp_will_receive_from_customer']=0;
					$report_data['sp_will_receive_for_his_services']=0;
					$report_data['owner_have_to_pay_to_sp']=0;
					$report_data['owner_have_to_pay_for_parts']=0;
					$report_data['net_amount_for_owner']=0;
					$report_data['net_amount_sp']=0 ;


		$this->db->save_queries = true;
				$items_having_warranty = get_query_data('SELECT si.* , isn.unit_price   FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items_serial_numbers as isn on isn.item_id= si.item_id and isn.serial_number = si.serialnumber  where si.sale_id='.$row['sale_id'].' and  si.is_repair_item=1 and isn.is_sold=1 and (
					(isn.replace_sale_date = 1 and	isn.warranty_end > STR_TO_DATE("'.$row['sale_date'].'", "%Y-%m-%d"))
					or
				(isn.replace_sale_date != 1 and isn.sold_warranty_end > STR_TO_DATE("'.$row['sale_date'].'", "%Y-%m-%d") )
				) ');

				

					$report_data['items_having_warranty'] = $items_having_warranty;
						if($items_having_warranty){
							
							foreach($items_having_warranty as $ihw){

								$report_data['items_having_warranty_sub'] = 	get_query_data('SELECT si.* , i.is_service , isn.unit_price   FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items as i on i.item_id=si.item_id left join ' . $prefix .'items_serial_numbers as isn on isn.item_id= si.item_id and isn.serial_number = si.serialnumber where si.sale_id='.$ihw->sale_id.' and si.is_repair_item=0   and si.assigned_repair_item = '.$ihw->item_id.' ');
								// echo $this->db->last_query();
								
								
								if($report_data['items_having_warranty_sub']){
								if(count($report_data['items_having_warranty_sub']) > 0){
									foreach($report_data['items_having_warranty_sub'] as $item){
										
										if($item->is_service){
											$report_data['sp_will_receive_for_his_services']=  $report_data['sp_will_receive_for_his_services'] + ( ($item->unit_price)?$item->unit_price * $item->quantity_purchased:$item->total ) ;
											$report_data['owner_have_to_pay_to_sp']=$report_data['owner_have_to_pay_to_sp'] + ( ($item->unit_price)?$item->unit_price * $item->quantity_purchased:$item->total );
										}else{
											$report_data['owner_have_to_pay_for_parts'] =  $report_data['owner_have_to_pay_for_parts'] + ( ($item->unit_price)?$item->unit_price * $item->quantity_purchased :$item->total);

											
										}

									}
								}
							}
							}

						}

						$items_having_nowarranty = get_query_data('SELECT si.* , isn.unit_price   FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items_serial_numbers as isn on isn.item_id= si.item_id and isn.serial_number = si.serialnumber  where si.sale_id='.$row['sale_id'].' and  si.is_repair_item=1 and isn.is_sold=1 and (
							(isn.replace_sale_date = 1 and	isn.warranty_end < STR_TO_DATE('.$row['sale_date'].', "%Y-%m-%d"))
							or
						(isn.replace_sale_date != 1 and isn.sold_warranty_end < STR_TO_DATE('.$row['sale_date'].', "%Y-%m-%d") )
						) ');
					
						
						$report_data['items_having_nowarranty'] = $items_having_nowarranty;

						if($items_having_nowarranty){
							foreach($items_having_nowarranty as $ihw){
								
								$report_data['items_having_not_warranty_sub'] = 	get_query_data('SELECT si.* , i.is_service , isn.unit_price   FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items as i on i.item_id=si.item_id left join ' . $prefix .'items_serial_numbers as isn on isn.item_id= si.item_id and isn.serial_number = si.serialnumber where si.sale_id='.$ihw->sale_id.' and si.is_repair_item=0   and si.assigned_repair_item = '.$ihw->item_id.' ');
								if($report_data['items_having_not_warranty_sub'] ){
								if(count($report_data['items_having_not_warranty_sub']) > 0){
									foreach($report_data['items_having_not_warranty_sub'] as $item){
										$amount = ($item->unit_price)?$item->unit_price * $item->quantity_purchased:$item->total;
										if($item->is_service){
											$report_data['sp_will_receive_for_his_services']=  $report_data['sp_will_receive_for_his_services'] + $amount;
											$report_data['customer_will_pay_for_services']=$report_data['customer_will_pay_for_services'] + $amount;
											$report_data['sp_will_receive_from_customer']=$report_data['sp_will_receive_from_customer'] + $amount;
										}else{
											
											$report_data['customer_will_pay_for_parts']=  $report_data['customer_will_pay_for_parts'] +   $amount;
											$report_data['sp_will_pay_to_owner']=  $report_data['sp_will_pay_to_owner']  + $amount;
											$report_data['sp_will_receive_from_customer']=$report_data['sp_will_receive_from_customer'] + $amount;
										}
									}
								}
								}
							}

						}
						$no_serial = false;
						if(!$items_having_warranty && !$items_having_nowarranty){
							$report_data['items_having_not_warranty_sub'] = 	get_query_data('SELECT si.* , i.is_service    FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items as i on i.item_id=si.item_id  where si.sale_id='.$row['sale_id'].'    ');
							
								if($report_data['items_having_not_warranty_sub'] ){
								if(count($report_data['items_having_not_warranty_sub']) > 0){
									$no_serial = true;
									foreach($report_data['items_having_not_warranty_sub'] as $item){
										// dd($item);
										$amount = ($item->item_unit_price)?$item->item_unit_price * $item->quantity_purchased:$item->total;
										if($item->is_service){
											$report_data['sp_will_receive_for_his_services']=  $report_data['sp_will_receive_for_his_services'] + $amount;
											$report_data['customer_will_pay_for_services']=$report_data['customer_will_pay_for_services'] + $amount;
											$report_data['sp_will_receive_from_customer']=$report_data['sp_will_receive_from_customer'] + $amount;
										}else{
											$report_data['customer_will_pay_for_parts']=  $report_data['customer_will_pay_for_parts'] +   $amount;
											$report_data['sp_will_receive_from_customer']=$report_data['sp_will_receive_from_customer'] + $amount;
										}
									}
								}
								}

						}

						// dd($report_data);

						$report_data['net_customer_will_pay'] = $report_data['customer_will_pay_for_services'] + $report_data['customer_will_pay_for_parts'] ;
						if(!$no_serial){
							$report_data['net_amount_for_owner']= $report_data['customer_will_pay_for_parts'] - $report_data['owner_have_to_pay_to_sp'];
							$report_data['net_amount_sp']= $report_data['sp_will_receive_for_his_services'] - $report_data['customer_will_pay_for_parts'];
						}else{
							$report_data['net_amount_sp']= $report_data['sp_will_receive_for_his_services'] + $report_data['customer_will_pay_for_parts'];
						}
					
						

				
						$report_data['net_customer_will_pay']= to_currency($report_data['net_customer_will_pay']);
						$report_data['owner_have_to_pay_to_sp']= to_currency($report_data['owner_have_to_pay_to_sp']);
						$report_data['owner_have_to_pay_for_parts']= to_currency($report_data['owner_have_to_pay_for_parts']);
						$report_data['net_amount_for_owner']= to_currency($report_data['net_amount_for_owner']);
		

			
			return $report_data; 
	}
	
	
	
	function get_info_by_sale_id($sale_id)
	{
		$this->db->from('sales_work_orders');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get();
	}
	
	function get_work_order_id_by_sale_id($sale_id)
	{
		$info = $this->get_info_by_sale_id($sale_id)->row();
		
		return $info->id ?? false;
	}
	
	/*
	Perform a search on work orders
	*/
	function search($search, $deleted = 0, $limit=20, $offset=0, $column='id', $orderby='desc',$status='',$technician='',$hide_completed_work_orders='' , $location ='')
	{
		if (!$deleted)
		{
			$deleted = 0;
		}
		$custom_fields = array();
		for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++)
		{
			if ($this->get_custom_field($k) !== FALSE)
			{
				if ($this->get_custom_field($k,'type') != 'date')
				{
					$custom_fields[$k]=$this->db->dbprefix('sales_work_orders').".custom_field_${k}_value LIKE '".$this->db->escape_like_str($search)."%' ESCAPE '!'";
				}
				else
				{
					$custom_fields[$k]= "FROM_UNIXTIME(".$this->db->dbprefix('sales_work_orders').".custom_field_${k}_value, '%Y-%m-%d') !='1969-12-31' and FROM_UNIXTIME(".$this->db->dbprefix('sales_work_orders').".custom_field_${k}_value, '%Y-%m-%d') = ".$this->db->escape(date('Y-m-d', strtotime($search)));
				}

			}
		}

		if (!empty($custom_fields))
		{
			$custom_fields = implode(' or ',$custom_fields);
		}
		else
		{
			$custom_fields='1=2';
		}
	
		$location_id = $this->Employee->get_logged_in_employee_current_location_id();
		$complete_status_id = $this->get_status_id_by_name('lang:work_orders_complete');
		$logged_employee_id = $this->Employee->get_logged_in_employee_info()->id;


		
		$this->db->select('sales.suspended,sales_work_orders.*,sales.sale_time,sales.location_id as location_id,CONCAT(customer_person.address_1, " ", customer_person.address_2) as full_address,customer_person.*,CONCAT(employee_person.first_name, " ", employee_person.last_name) as technician_name, GROUP_CONCAT(DISTINCT phppos_items.name) as item_name_being_repaired, GROUP_CONCAT(IF(is_repair_item = 1 and sales_items.description !="", sales_items.description, phppos_items.name) SEPARATOR ",") as item_name_being_repaired , locations.name as location ');
		

		$this->db->from('sales_work_orders');
		$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id');
		$this->db->join('people as customer_person', 'sales.customer_id = customer_person.person_id','left');
		$this->db->join('people as employee_person', 'sales_work_orders.employee_id = employee_person.person_id','left');
		$this->db->join('sales_items as sales_items', 'sales_items.sale_id = sales_work_orders.sale_id','left');
		$this->db->join('items', 'items.item_id = sales_items.item_id','left');
		$this->db->join('locations', 'locations.location_id = sales.location_id','left');
		if ($search)
		{
			$this->db->where("(
			customer_person.first_name LIKE '".$this->db->escape_like_str($search)."%' or
			customer_person.last_name LIKE '".$this->db->escape_like_str($search)."%' or
			customer_person.address_1 LIKE '".$this->db->escape_like_str($search)."%' or
			customer_person.address_2 LIKE '".$this->db->escape_like_str($search)."%' or
			customer_person.city LIKE '".$this->db->escape_like_str($search)."%' or
			customer_person.state LIKE '".$this->db->escape_like_str($search)."%' or
			customer_person.zip LIKE '".$this->db->escape_like_str($search)."%' or
			sales_work_orders.sale_id  = ".$this->db->escape($search)." or
			customer_person.email LIKE '".$this->db->escape_like_str($search)."%' or 
			customer_person.phone_number LIKE '".$this->db->escape_like_str($search)."%' or
			CONCAT(customer_person.`first_name`,' ',customer_person.`last_name`) LIKE '".$this->db->escape_like_str($search)."%' or 
			CONCAT(customer_person.`last_name`,' ',customer_person.`first_name`) LIKE '".$this->db->escape_like_str($search)."%' or $custom_fields)");		
		}

		if($status){
			$this->db->where('sales_work_orders.status',$status);
		}
		
		if($technician && $technician!=-1){
			$this->db->where('sales_work_orders.employee_id',$technician);
		}
		
		if($hide_completed_work_orders){
			$this->db->where('sales_work_orders.status !=',$complete_status_id);
		}
		
		if(getenv('MASTER_USER')!=$logged_employee_id){
			
			$this->db->where('sales.location_id',$location_id);
		 }else{
			if($location && $location!=-1){
				$this->db->where('sales.location_id',$location);
			}
		 }
		$this->db->where('sales.deleted',0);
		$this->db->where('sales_work_orders.deleted',$deleted);
		
		if (!$this->config->item('speed_up_search_queries'))
		{
			$this->db->order_by($column, $orderby);
		}
		
		$this->db->group_by('sales_work_orders.sale_id');
		$this->db->limit($limit);
		$this->db->offset($offset);
		
		
	 	return $this->db->get();
		 
	}
	
	function search_count_all($search, $deleted = 0,$limit=10000,$status='',$technician='',$hide_completed_work_orders='', $location="")
	{
		if (!$deleted)
		{
			$deleted = 0;
		}


		$custom_fields = array();
		for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++)
		{
			if ($this->get_custom_field($k) !== FALSE)
			{
				if ($this->get_custom_field($k,'type') != 'date')
				{
					$custom_fields[$k]=$this->db->dbprefix('sales_work_orders').".custom_field_${k}_value LIKE '".$this->db->escape_like_str($search)."%' ESCAPE '!'";
				}
				else
				{
					$custom_fields[$k]= "FROM_UNIXTIME(".$this->db->dbprefix('sales_work_orders').".custom_field_${k}_value, '%Y-%m-%d') !='1969-12-31' and FROM_UNIXTIME(".$this->db->dbprefix('sales_work_orders').".custom_field_${k}_value, '%Y-%m-%d') = ".$this->db->escape(date('Y-m-d', strtotime($search)));
				}

			}
		}

		if (!empty($custom_fields))
		{
			$custom_fields = implode(' or ',$custom_fields);
		}
		else
		{
			$custom_fields='1=2';
		}
		
		$location_id = $this->Employee->get_logged_in_employee_current_location_id();
		$complete_status_id = $this->get_status_id_by_name('lang:work_orders_complete');
		$logged_employee_id = $this->Employee->get_logged_in_employee_info()->id;


		$this->db->select('sales_work_orders.*,sales.sale_time,sales.location_id as location_id,CONCAT(customer_person.address_1, " ", customer_person.address_2) as full_address,customer_person.*');
		$this->db->from('sales_work_orders');
		$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id');
		$this->db->join('people as customer_person', 'sales.customer_id = customer_person.person_id','left');
		
		if ($search)
		{
			$this->db->where("(
			customer_person.first_name LIKE '".$this->db->escape_like_str($search)."%' or
			customer_person.last_name LIKE '".$this->db->escape_like_str($search)."%' or
			customer_person.address_1 LIKE '".$this->db->escape_like_str($search)."%' or
			customer_person.address_2 LIKE '".$this->db->escape_like_str($search)."%' or
			customer_person.city LIKE '".$this->db->escape_like_str($search)."%' or
			customer_person.state LIKE '".$this->db->escape_like_str($search)."%' or
			customer_person.zip LIKE '".$this->db->escape_like_str($search)."%' or
			sales_work_orders.sale_id  = ".$this->db->escape($search)." or
			customer_person.email LIKE '".$this->db->escape_like_str($search)."%' or 
			customer_person.phone_number LIKE '".$this->db->escape_like_str($search)."%' or
			CONCAT(customer_person.`first_name`,' ',customer_person.`last_name`) LIKE '".$this->db->escape_like_str($search)."%' or 
			CONCAT(customer_person.`last_name`,', ',customer_person.`first_name`) LIKE '".$this->db->escape_like_str($search)."%' or $custom_fields)");		
		}

		if($status){
			$this->db->where('sales_work_orders.status',$status);
		}

		if($technician && $technician!=-1){
			$this->db->where('sales_work_orders.employee_id',$technician);
		}

		if($hide_completed_work_orders){
			
			$this->db->where('sales_work_orders.status !=',$complete_status_id);
		}
		
		if(getenv('MASTER_USER')!=$logged_employee_id){
			
			$this->db->where('sales.location_id',$location_id);
		 }else{
			
			if($location && $location!=-1){
				
				$this->db->where('sales.location_id',$location);
			}
		 }
		


		$this->db->where('sales.deleted',0);
		$this->db->where('sales_work_orders.deleted',$deleted);
		
		$this->db->limit($limit);
		
		
		return $this->db->get()->num_rows();
	}
	
	/*
	Get search suggestions to find deliveries
	*/
	function get_search_suggestions($search,$deleted=0,$limit=5)
	{
		
		if (!trim($search))
		{
			return array();
		}
		if (!$deleted)
		{
			$deleted = 0;
		}
		
			$suggestions = array();
			$location_id = $this->Employee->get_logged_in_employee_current_location_id();

			$this->db->from('sales_work_orders');
			$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id');
			
			$this->db->join('people', 'sales.customer_id = people.person_id','left');
			$this->db->where('sales.deleted',0);
			$this->db->where('sales_work_orders.deleted',$deleted);		
			$this->db->where("(first_name LIKE '".$this->db->escape_like_str($search)."%' or
			CONCAT(`first_name`,' ',`last_name`) LIKE '".$this->db->escape_like_str($search)."%' or 
		  last_name LIKE '".$this->db->escape_like_str($search)."%' or 
			CONCAT(`last_name`,', ',`first_name`) LIKE '".$this->db->escape_like_str($search)."%')");		
			$this->db->where('sales.location_id',$location_id);
			$this->db->limit($limit);
			
			$query=$this->db->get();
			
			$temp_suggestions = array();
						
			foreach($query->result() as $row)
			{
				$data = array(
					'name' => $row->first_name . ' ' .  $row->last_name,
					'subtitle' => $row->address_1 . ', ' . $row->address_2 . ', ' . $row->city . ', ' . $row->state . ', ' . $row->zip . ', ' . $row->country,
					'avatar' => base_url()."assets/img/giftcard.png",
					 );
				$temp_suggestions[$row->id] = $data;
			}
		
		
			$this->load->helper('array');
			uasort($temp_suggestions, 'sort_assoc_array_by_name');
			
			foreach($temp_suggestions as $key => $value)
			{
				$suggestions[]=array('value'=> $key, 'label' => $value['name'],'avatar'=>$value['avatar'],'subtitle'=>$value['subtitle']);		
			}


			$this->db->from('sales_work_orders');
			$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id');
			
			$this->db->join('people', 'sales.customer_id = people.person_id','left');
		
			$this->db->where('sales.deleted',0);
			$this->db->where('sales_work_orders.deleted',$deleted);
			$this->db->where("(address_1 LIKE '".$this->db->escape_like_str($search)."%' or
			address_2 LIKE '".$this->db->escape_like_str($search)."%' or 
		  city LIKE '".$this->db->escape_like_str($search)."%' or 
		  state LIKE '".$this->db->escape_like_str($search)."%' or 
			zip LIKE '".$this->db->escape_like_str($search)."%')");		
			$this->db->where('sales.location_id',$location_id);
			
			$this->db->limit($limit);
			
			$query=$this->db->get();
			
			$temp_suggestions = array();
						
			foreach($query->result() as $row)
			{
				$data = array(
					'name' => $row->address_1 . ', ' . $row->address_2 . ', ' . $row->city . ', ' . $row->state . ', ' . $row->zip . ', ' . $row->country,
					'subtitle' => $row->first_name . ' ' .  $row->last_name,
					'avatar' => base_url()."assets/img/giftcard.png",
					 );
				$temp_suggestions[$row->id] = $data;
			}
		
		
			$this->load->helper('array');
			uasort($temp_suggestions, 'sort_assoc_array_by_name');
			
			foreach($temp_suggestions as $key => $value)
			{
				$suggestions[]=array('value'=> $key, 'label' => $value['name'],'avatar'=>$value['avatar'],'subtitle'=>$value['subtitle']);		
			}
			
			
			
			$this->db->from('sales_work_orders');
			$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id');
			
			$this->db->join('people', 'sales.customer_id = people.person_id','left');
			$this->db->where("phone_number LIKE '".$this->db->escape_like_str($search)."%'");
			$this->db->where('sales.location_id',$location_id);
			$this->db->where('sales.deleted',0);
			$this->db->where('sales_work_orders.deleted',$deleted);
			
			$this->db->limit($limit);
			
			$query=$this->db->get();
			
			$temp_suggestions = array();
						
			foreach($query->result() as $row)
			{
				$data = array(
					'name' => $row->phone_number,
					'subtitle' => $row->first_name.' '.$row->last_name,
					'avatar' => base_url()."assets/img/giftcard.png",
					 );
				$temp_suggestions[$row->id] = $data;
			}
		
		
			$this->load->helper('array');
			uasort($temp_suggestions, 'sort_assoc_array_by_name');
			
			foreach($temp_suggestions as $key => $value)
			{
				$suggestions[]=array('value'=> $key, 'label' => $value['name'],'avatar'=>$value['avatar'],'subtitle'=>$value['subtitle']);		
			}


			
			
			$this->db->from('sales_work_orders');
			$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id');
			
			$this->db->join('people', 'sales.customer_id = people.person_id','left');
			$this->db->where("email LIKE '".$this->db->escape_like_str($search)."%'");
			$this->db->where('sales.location_id',$location_id);
			$this->db->where('sales.deleted',0);
			$this->db->where('sales_work_orders.deleted',$deleted);
			
			$this->db->limit($limit);
			
			$query=$this->db->get();
			
			$temp_suggestions = array();
						
			foreach($query->result() as $row)
			{
				$data = array(
					'name' => $row->email,
					'subtitle' => $row->first_name.' '.$row->last_name,
					'avatar' => base_url()."assets/img/giftcard.png",
					 );
				$temp_suggestions[$row->id] = $data;
			}
		
		
			$this->load->helper('array');
			uasort($temp_suggestions, 'sort_assoc_array_by_name');
			
			foreach($temp_suggestions as $key => $value)
			{
				$suggestions[]=array('value'=> $key, 'label' => $value['name'],'avatar'=>$value['avatar'],'subtitle'=>$value['subtitle']);		
			}
			
			for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++)
			{
				if ($this->get_custom_field($k)) 
				{
					$this->load->helper('date');
					if ($this->get_custom_field($k,'type') != 'date')
					{
						$this->db->select('sales_work_orders.custom_field_'.$k.'_value as custom_field, sales_work_orders.id', false);						
					}
					else
					{
						$this->db->select('FROM_UNIXTIME('.$this->db->dbprefix('sales_work_orders').'.custom_field_'.$k.'_value, "'.get_mysql_date_format().'") as custom_field, sales_work_orders.id', false);
					}
					$this->db->from('sales_work_orders');
					$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id');
					$this->db->where('sales.location_id',$location_id);
					$this->db->where('sales.deleted',0);
					$this->db->where('sales_work_orders.deleted',$deleted);
					if ($this->get_custom_field($k,'type') != 'date')
					{
						$this->db->like("sales_work_orders.custom_field_${k}_value",$search,'after');
					}
					else
					{
						$this->db->where("FROM_UNIXTIME(".$this->db->dbprefix('sales_work_orders').".custom_field_${k}_value, '%Y-%m-%d') !='1969-12-31' and FROM_UNIXTIME(".$this->db->dbprefix('sales_work_orders').".custom_field_${k}_value, '%Y-%m-%d') = ".$this->db->escape(date('Y-m-d', strtotime($search))), NULL, FALSE);
					}
					$this->db->limit($limit);
					$by_custom_field = $this->db->get();
		
					$temp_suggestions = array();
		
					foreach($by_custom_field->result() as $row)
					{
						$data = array(
							'name' => $row->custom_field,
							'subtitle' => $this->get_custom_field($k),
							'avatar' => base_url()."assets/img/giftcard.png",
							 );
						$temp_suggestions[$row->id] = $data;
					}
			
					uasort($temp_suggestions, 'sort_assoc_array_by_name');
					
					foreach($temp_suggestions as $key => $value)
					{
						$suggestions[]=array('value'=> $key, 'label' => $value['name'],'avatar'=>$value['avatar'],'subtitle'=>$value['subtitle']);		
					}
				}			
			}
			
		
		$suggestions = array_map("unserialize", array_unique(array_map("serialize", $suggestions)));
		if(count($suggestions) > $limit)
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	
	}
	
	
	function get_all($deleted=0,$limit=10000, $offset=0,$col='id',$order='desc')
	{	
		if (!$deleted)
		{
			$deleted = 0;
		}

		$repair_item_id = $this->create_or_update_repair_item();
	
		$location_id = $this->Employee->get_logged_in_employee_current_location_id();

		$logged_employee_id = $this->Employee->get_logged_in_employee_info()->id;

		$this->db->select('sales.suspended,sales_work_orders.*,sales.sale_time,sales.location_id as location_id,CONCAT(customer_person.address_1, " ", customer_person.address_2) as full_address,customer_person.*');
		
		if($repair_item_id){
			$this->db->select('GROUP_CONCAT(DISTINCT IF(sales_items.is_repair_item = 1 AND phppos_items.item_id = '.$repair_item_id.', sales_items.description, phppos_items.name)) as item_name_being_repaired');
		}else{
			$this->db->select('GROUP_CONCAT(DISTINCT phppos_items.name) as item_name_being_repaired');
		}

			$this->db->select('TRIM(CONCAT(employee_person.first_name, " ",employee_person.last_name)) as technician_name');
			$this->db->select('locations.name as location');

			

		$this->db->from('sales_work_orders');
		$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id');
		$this->db->join('people as customer_person', 'sales.customer_id = customer_person.person_id','left');
		$this->db->join('people as employee_person', 'sales_work_orders.employee_id = employee_person.person_id','left');
		$this->db->join('sales_items as sales_items', 'sales_items.sale_id = sales_work_orders.sale_id','left');
		$this->db->join('items', 'items.item_id = sales_items.item_id','left');
		$this->db->join('locations', 'locations.location_id = sales.location_id','left');

		 if(getenv('MASTER_USER')!=$logged_employee_id){
			
			$this->db->where('sales.location_id',$location_id);
		 }

		
		
	

		$this->db->where('sales.deleted',0);
		$this->db->where('sales_work_orders.deleted',$deleted);
		if(!$this->config->item('speed_up_search_queries'))
		{
			$this->db->order_by($col, $order);
		}
		$this->db->group_by('sales_work_orders.sale_id');
		$this->db->limit($limit, $offset);
 		$return = $this->db->get();
 	 	return $return;
	}

	function get_by_id($id)
	{	
		
		$this->db->select('sales_work_orders.*,sales.sale_time,sales.location_id as location_id,CONCAT(customer_person.address_1, " ", customer_person.address_2) as full_address,customer_person.*');
		$this->db->from('sales_work_orders');
		$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id');
		$this->db->join('people as customer_person', 'sales.customer_id = customer_person.person_id','left');
				
		$this->db->where('sales_work_orders.id',$id);
		
		return $this->db->get()->row();
	}
	
	function count_all($deleted=0)
	{
		if (!$deleted)
		{
			$deleted = 0;
		}
		
		$location_id = $this->Employee->get_logged_in_employee_current_location_id();
		
		$this->db->from('sales_work_orders');
		$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id');
		$this->db->where('sales.location_id',$location_id);
		$this->db->where('sales.deleted',0);
		$this->db->where('sales_work_orders.deleted',$deleted);
		$query = $this->db->get();
		
		
		if ($query != false && $query->num_rows() > 0) {
			return $query->num_rows(); // Count the number of rows returned by the query
		}else{
			return false;
		}
	}
	
	function exists($id)
	{
		$this->db->from('sales_work_orders');
		$this->db->where('id',$id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}
	
	function exists_by_sale_id($sale_id)
	{
		$this->db->from('sales_work_orders');
		$this->db->where('sale_id',$sale_id);
		$query = $this->db->get();

		return ($query->num_rows()!=0);
	}
	
	/*
	Inserts or updates a delivery
	*/
	function save(&$work_order_data, $work_order_id = false)
	{		
		//If we are overwriting a delivery make sure sale is gone
		if (isset($work_order_data['sale_id']))
		{
			$this->delete_by_sale_id($work_order_data['sale_id']);
		}
		
		if (!$work_order_id or !$this->exists($work_order_id))
		{			
			if($this->db->insert('sales_work_orders',$work_order_data))
			{
				$work_order_data['id'] = $this->db->insert_id();
				return true;
			}
			
			return false;
		}
		
		$work_order_info = $this->get_info($work_order_id)->row_array();
		
		foreach($work_order_data as $field=>$value)
		{
			if ($value != $work_order_info[$field])
			{
				$this->log_activity($work_order_id,'[field]'.$field.'[/field] '.lang('changed').' '.lang('from').' [oldvalue]'.$work_order_info[$field].'[/oldvalue] '.lang('to').' [newvalue]'.$value.'[/newvalue]');
			}
		}
		
			
			
			
		$this->db->where('id', $work_order_id);
		return $this->db->update('sales_work_orders', $work_order_data);
	}
	
	function delete($id)
	{	
		$sale_id = $this->get_info($id)->row()->sale_id;

		$this->Sale->delete($sale_id);

		$this->db->where('id', $id);
		return $this->db->update('sales_work_orders', array('deleted' => 1));
	}
	
	function delete_list($work_order_ids)
	{
		foreach($work_order_ids as $work_order_id)
		{
			$result = $this->Work_order->delete($work_order_id);
			
			if(!$result)
			{
				return false;
			}
		}
		
		return true;
 	}
	
	function delete_by_sale_id($sale_id)
	{
		$this->db->query('SET FOREIGN_KEY_CHECKS = 0');
		$this->db->where('sale_id', $sale_id);
		$return = $this->db->delete('sales_work_orders'); 
		$this->db->query('SET FOREIGN_KEY_CHECKS = 1');
		return $return;
	}
	
	function undelete($id)
	{	
		$this->db->where('id', $id);
		return $this->db->update('sales_work_orders', array('deleted' => 0));
	}
	
	function undelete_list($work_order_ids)
	{
		foreach($work_order_ids as $work_order_id)
		{
			$result = $this->Work_order->undelete($work_order_id);
			
			if(!$result)
			{
				return false;
			}
		}
		
		return true;
 	}
		
	function get_displayable_columns()
	{
				
		$this->load->helper('people_helper');
		$this->lang->load('work_orders');
		$this->load->helper('sale');
		
		$return = array(
			'id' =>       	                       array('sort_column' => 'sales_work_orders.ID', 'label' => lang('id'),'format_function'),
			'sale_id' =>                           array('sort_column' => 'sales_work_orders.sale_id', 'label' => lang('work_orders_work_order').' '.lang('sale_id'),'format_function' => 'sale_id_receipt_link_formatter','html' => TRUE),
			'sale_time' =>                         array('sort_column' => 'sales.sale_time', 'label' => lang('work_orders_date'), 'format_function' => 'date_time_to_date'),
			'estimated_repair_date' =>             array('sort_column' => 'sales_work_orders.estimated_repair_date', 'label' => lang('work_orders_estimated_repair_date'), 'format_function' => 'date_time_to_datetime'),
			'estimated_parts' =>                   array('sort_column' => 'sales_work_orders.estimated_parts', 'label' => lang('work_orders_estimated_parts'), 'format_function' => 'to_currency'),
			'estimated_labor' =>                   array('sort_column' => 'sales_work_orders.estimated_labor', 'label' => lang('work_orders_estimated_labor'), 'format_function' => 'to_currency'),
			'status' =>                            array('sort_column' => 'sales_work_orders.status', 'label' => lang('status'), 'format_function' => 'work_order_status_badge', 'html' => TRUE),
			'technician_name' =>                   array('sort_column' => 'employee_person.first_name', 'label' => lang('work_orders_technician')),
			'location' =>                   array('sort_column' => 'location.name', 'label' => lang('location')),
			'first_name' =>                        array('sort_column' => 'customer_person.first_name', 'label' => lang('first_name')),
			'last_name' =>                         array('sort_column' => 'customer_person.last_name', 'label' => lang('last_name')),
			'item_name_being_repaired' =>          array('sort_column' => 'items.name', 'label' => lang('work_orders_item_name_being_repaired')),
			'full_address' =>                      array('sort_column' => 'customer_person.address_1', 'label' => lang('address'), 'html' => TRUE),
			'city' =>                              array('sort_column' => 'customer_person.city', 'label' => lang('city')),
			'state' =>                             array('sort_column' => 'customer_person.state', 'label' => lang('state')),
			'zip' =>                               array('sort_column' => 'customer_person.zip', 'label' => lang('zip')),
			'email' =>                             array('sort_column' => 'customer_person.email', 'label' => lang('email'), 'format_function' => 'email_formatter', 'html' => TRUE),
			'phone_number' =>                      array('sort_column' => 'customer_person.phone_number', 'label' => lang('phone_number'), 'format_function' => 'tel', 'html' => TRUE),
		);

		for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++)
		{
			if($this->get_custom_field($k) !== false)
			{
				$field = array();
				$field['sort_column'] ="custom_field_${k}_value";
				$field['label']= $this->get_custom_field($k);
			
				if ($this->get_custom_field($k,'type') == 'checkbox')
				{
					$format_function = 'boolean_as_string';
				}
				elseif($this->get_custom_field($k,'type') == 'date')
				{
					$format_function = 'date_as_display_date';				
				}
				elseif($this->get_custom_field($k,'type') == 'email')
				{
					$this->load->helper('url');
					$format_function = 'mailto';					
					$field['html'] = TRUE;
				}
				elseif($this->get_custom_field($k,'type') == 'url')
				{
					$this->load->helper('url');
					$format_function = 'anchor_or_blank';					
					$field['html'] = TRUE;
				}
				elseif($this->get_custom_field($k,'type') == 'phone')
				{
					$this->load->helper('url');
					$format_function = 'tel';					
					$field['html'] = TRUE;
				}
				elseif($this->get_custom_field($k,'type') == 'image')
				{
					$this->load->helper('url');
					$format_function = 'file_id_to_image_thumb';					
					$field['html'] = TRUE;
				}
				elseif($this->get_custom_field($k,'type') == 'file')
				{
					$this->load->helper('url');
					$format_function = 'file_id_to_download_link';					
					$field['html'] = TRUE;
				}
				else
				{
					$format_function = 'strsame';
				}
				$field['format_function'] = $format_function;
				$return["custom_field_${k}_value"] = $field;
			}
		}

		return $return;


	}
	
	function get_default_columns()
	{
		return array('id','sale_id','sale_time','status','technician_name','estimated_repair_date','first_name','last_name','item_name_being_repaired','email','phone_number' , 'location');
	}

	function change_status($id,$status)
	{	
		$this->db->where('id', $id);
		return $this->db->update('sales_work_orders', array('status' => $status));
	}
	
	function change_status_list($work_order_ids,$status)
	{
		foreach($work_order_ids as $work_order_id)
		{
			$result = $this->Work_order->change_status($work_order_id,$status);
			
			if(!$result)
			{
				return false;
			}
		}
		
		return true;
	}
	 
	 public function get_raw_print_data($work_order_id)
	{
		$this->db->from('sales_work_orders');
		$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id','left');
		$this->db->join('sales_items', 'sales_items.sale_id = sales_work_orders.sale_id','left');
		$this->db->join('items', 'items.item_id = sales_items.item_id','left');
		$this->db->join('people', 'people.person_id = sales.customer_id','left');
		$this->db->where('id',$work_order_id);
		return $this->db->get()->result_array();
	}

	public function get_customer_info($work_order_id)
	{
		$this->db->select('people.*');
		$this->db->from('sales_work_orders');
		$this->db->join('sales', 'sales.sale_id = sales_work_orders.sale_id','left');
		$this->db->join('people', 'people.person_id = sales.customer_id','left');
		$this->db->where('id',$work_order_id);
		return $this->db->get()->row_array();
	}

	public function get_item_being_repaired_info($work_order_id)
	{
		$this->db->select('items.*,sales_items.serialnumber');
		$this->db->from('sales_work_orders');
		$this->db->join('sales_items', 'sales_items.sale_id = sales_work_orders.sale_id','left');
		$this->db->join('items', 'items.item_id = sales_items.item_id','left');
		$this->db->where('id',$work_order_id);
		$this->db->where('line',0);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}

	function get_sales_items_notes($work_order_id, $get_last_note=false)
	{
		$this->db->select('sales_items_notes.*,people.first_name,people.last_name');
		$this->db->from('sales_items_notes');
		$this->db->join('sales_work_orders', 'sales_items_notes.sale_id = sales_work_orders.sale_id','left');
		$this->db->join('people', 'people.person_id = sales_items_notes.employee_id','left');
		$this->db->where('sales_work_orders.id',$work_order_id);
		$this->db->order_by('sales_items_notes.note_timestamp', 'desc');
		if($get_last_note){
			$this->db->limit(1);
		}
		return $this->db->get()->result_array();
	}

	function get_first_line_note($work_order_id)
	{
		$this->db->select('sales_items_notes.*');
		$this->db->from('sales_items_notes');
		$this->db->join('sales_work_orders', 'sales_items_notes.sale_id = sales_work_orders.sale_id','left');
		$this->db->where('sales_work_orders.id',$work_order_id);
		$this->db->where('sales_items_notes.line',0);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}

	public function get_work_order_items($work_order_id,$is_repair_item=NULL)
	{	
		// Get Sale ID from Work Order By Work Order ID
		$this->db->from('sales_work_orders');
		$this->db->where('id', $work_order_id);
		$sale_id = $this->db->get()->row_array();
		$sale_id = $sale_id['sale_id'];

		// Get Sale Items By Sale ID and is_repair_item flag
		$this->db->select('sales_items.*,items.name as item_name,items.description as item_description,items.category_id,items.is_serialized,items.item_number,items.allow_alt_description');
		$this->db->from('sales_items');
		$this->db->join('items', 'items.item_id = sales_items.item_id','left');
		$this->db->where('sales_items.sale_id',$sale_id);
		
		if ($is_repair_item !== NULL)
		{
			$this->db->where('sales_items.is_repair_item',$is_repair_item);
		}
		$this->db->order_by('sales_items.line', 'desc');

		$return = $this->db->get()->result_array();
		
		// Get Sale Item Kits By Sale ID and is_repair_item flag
		$this->db->select('sales_item_kits.*,item_kit_cost_price as item_cost_price,item_kit_unit_price as item_unit_price,item_kits.name as item_name,item_kits.description as item_description,item_kits.category_id');
		$this->db->from('sales_item_kits');
		$this->db->join('item_kits', 'item_kits.item_kit_id = sales_item_kits.item_kit_id','left');
		$this->db->where('sale_id',$sale_id);
		if ($is_repair_item !== NULL)
		{
			$this->db->where('sales_item_kits.is_repair_item',$is_repair_item);
		}
		$this->db->order_by('sales_item_kits.line', 'desc');
		$this->db->group_by('item_kit_id');
		$return = array_merge($return,$this->db->get()->result_array());

		return $return;
	}

	function get_custom_field($number,$key="name")
	{
		static $config_data;
		
		if (!$config_data)
		{
			$config_data = $this->config->item('work_order_custom_field_prefs') ? unserialize($this->config->item('work_order_custom_field_prefs')) : array();
		}
		
		return isset($config_data["custom_field_${number}_${key}"]) && $config_data["custom_field_${number}_${key}"] ? $config_data["custom_field_${number}_${key}"] : FALSE;
	}

	// function get_all_statuses()
	// {
	// 	$this->db->from('workorder_statuses');
	// 	$this->db->order_by('sort_order','asc');
		
	// 	return $this->db->get()->result_array();
	// }

	function get_all_statuses($limit=10000, $offset=0,$col='sort_order',$order='asc')
	{
		$this->db->from('workorder_statuses');
		$this->db->order_by($col, $order);
		
		
		$this->db->limit($limit);
		$this->db->offset($offset);
		
		$return = array();
		
		foreach($this->db->get()->result_array() as $result)
		{
			$return[$result['id']] = array('name' => $this->get_status_name($result['name']),'description' => $result['description'],'notify_by_email' => $result['notify_by_email'],'notify_by_sms' => $result['notify_by_sms'],'color' => $result['color'],'sort_order' => $result['sort_order']);		
		}
		
		return $return;
	}

	function get_status_name($status_string)
	{
		if (strpos($status_string,'lang:') !== FALSE)
		{
			return lang(str_replace('lang:','',$status_string));
		}
		return $status_string;
	}

	function get_status_info($status_id, $can_cache = FALSE)
	{
		if ($can_cache)
		{
			static $cache = array();
		
			if (isset($cache[$status_id]))
			{
				return $cache[$status_id];
			}
		}
		else
		{
			$cache = array();
		}
				
		$this->db->from('workorder_statuses');	
		$this->db->where('id',$status_id);
		$query = $this->db->get();
		
		if($query!=false && $query->num_rows()==1)
		{
			$cache[$status_id] = $query->row();
			return $cache[$status_id];
		}
		else
		{
			$man_obj = new stdclass();
			
			$fields = $this->db->list_fields('workorder_statuses');
			
			foreach ($fields as $field)
			{
				$man_obj->$field='';
			}
			
			return $man_obj;
		}
	}

	function convert_status_name_to_lang_key($status_name)
	{
		if ($status_name == lang('work_orders_new'))
		{
			return 'lang:work_orders_new';
		}
		
		if ($status_name == lang('work_orders_in_progress'))
		{
			return 'lang:work_orders_in_progress';
		}
		
		if ($status_name == lang('work_orders_out_for_repair'))
		{
			return 'lang:work_orders_out_for_repair';
		}
		
		if ($status_name == lang('work_orders_waiting_on_customer'))
		{
			return 'lang:work_orders_waiting_on_customer';
		}
		
		if ($status_name == lang('work_orders_repaired'))
		{
			return 'lang:work_orders_repaired';
		}
		
		if ($status_name == lang('work_orders_complete'))
		{
			return 'lang:work_orders_complete';
		}
		
		if ($status_name == lang('work_orders_cancelled'))
		{
			return 'lang:work_orders_cancelled';
		}
		
		return FALSE;		
	}
	function get_status_id_by_name($status_name)
	{
		$convert_status_name_to_lang_key = FALSE;
		if (strpos($status_name,'lang:') === FALSE)
		{
			$convert_status_name_to_lang_key = $this->convert_status_name_to_lang_key($status_name);
		}
		
		$this->db->from('workorder_statuses');
		$this->db->group_start();
		$this->db->where('name', $status_name);
		$this->db->or_where('name', $this->get_status_name($status_name));
		
		if ($convert_status_name_to_lang_key)
		{
			$this->db->or_where('name', $convert_status_name_to_lang_key);
		}
		$this->db->group_end();
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			$row = $query->row();
			return $row->id;
		}
		
		return FALSE;
		
	}

	function status_exists( $status_id )
	{
		$this->db->from('workorder_statuses');
		$this->db->where('id',$status_id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	function status_save(&$status_data,$status_id=false)
	{
		if (!$status_id or !$this->status_exists($status_id))
		{
			if($this->db->insert('workorder_statuses',$status_data))
			{
				$status_data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}

		$this->db->where('id', $status_id);
		return $this->db->update('workorder_statuses',$status_data);
	}

	function delete_status($status_id)
	{	
		$this->db->query('SET FOREIGN_KEY_CHECKS = 0');
		$this->db->where('id', $status_id);
		$result = $this->db->delete('workorder_statuses');
		$this->db->query('SET FOREIGN_KEY_CHECKS = 0');
		return $result;
	}

	//type 1 : pre, type 2: post 
	function get_all_checkboxes($group_id, $type = 0, $limit=10000, $offset=0,$col='sort_order',$order='asc')
	{
		$this->db->from('workorder_checkboxes');

		if($type > 0){
			$this->db->where('type', $type);
		}
		
		$this->db->where('deleted', 0);
		$this->db->where('group_id', $group_id);
		$this->db->order_by($col, $order);

		$this->db->limit($limit);
		$this->db->offset($offset);

		$return = array();

		foreach($this->db->get()->result_array() as $result){
			$return[] = array('id' => $result['id'],'name' => $this->get_checkbox_name($result['name']), 'description' => $result['description'], 'sort_order' => $result['sort_order']);
		} 

		return $return;
	}

	function get_checkbox_name($checkbox_string)
	{
		if (strpos($checkbox_string,'lang:') !== FALSE)
		{
			return lang(str_replace('lang:','',$checkbox_string));
		}
		return $checkbox_string;
	}

	function get_checkbox_info($checkbox_id, $can_cache = FALSE)
	{
		if ($can_cache)
		{
			static $cache = array();
		
			if (isset($cache[$checkbox_id]))
			{
				return $cache[$checkbox_id];
			}
		}
		else
		{
			$cache = array();
		}
		
		$this->db->from('workorder_checkboxes');
		if(is_array($checkbox_id) ){
			$this->db->where('id',$checkbox_id['checkbox_id']);
		}else{
			$this->db->where('id',$checkbox_id);
		}



		
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			if(is_array($checkbox_id) ){
				$cache[$checkbox_id['checkbox_id']] = $query->row();
			return $cache[$checkbox_id['checkbox_id']];
			}else{
				$cache[$checkbox_id] = $query->row();
			return $cache[$checkbox_id];
			}

			
		}
		else
		{
			$man_obj = new stdclass();
			
			$fields = $this->db->list_fields('workorder_checkboxes');
			
			foreach ($fields as $field)
			{
				$man_obj->$field='';
			}
			
			return $man_obj;
		}
	}

	function get_checkbox_id_by_name($checkbox_name)
	{
		$this->db->from('workorder_checkboxes');
		$this->db->group_start();
		$this->db->where('name', $checkbox_name);
		$this->db->or_where('name', $this->get_checkbox_name($checkbox_name));
		$this->db->group_end();
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			$row = $query->row();
			return $row->id;
		}
		
		return FALSE;
	}

	function checkbox_exists( $checkbox_id )
	{
		$this->db->from('workorder_checkboxes');
		$this->db->where('id',$checkbox_id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	function delete_checkbox($group_id)
	{
		$this->db->where('group_id', $group_id);
		$this->db->update('workorder_checkboxes', array('deleted' => 1));

		$this->db->where('id', $group_id);
		return $this->db->update('workorder_checkbox_groups', array('deleted' => 1));
	}

	function workorder_checkbox_exists($workorder_id, $checkbox_id = false)
	{
		$this->db->from('workorder_checkboxes_states');
		$this->db->where('workorder_id', $workorder_id);

		if($checkbox_id){
			$this->db->where('checkbox_id', $checkbox_id);
		}

		$query = $this->db->get();

		return ($query->num_rows() > 0);
	}

	function workorder_checkbox_state_save($data, $workorder_id)
	{
		if ($this->workorder_checkbox_exists($workorder_id)){
			$this->db->where('workorder_id',$workorder_id);
			$this->db->delete('workorder_checkboxes_states');
		}

		if (!$this->workorder_checkbox_exists($workorder_id) && !empty($data)) {
			if(!$this->db->insert_batch('workorder_checkboxes_states', $data)){
				return false;
			}
		}

		return true;
	}

	function get_checkboxes_states($workorder_id){
		$this->db->from('workorder_checkboxes_states');
		$this->db->where('workorder_id', $workorder_id);
		return $this->db->get()->result_array();
	}

	function delete_note($note_id)
	{		
		$this->db->where('note_id', $note_id);
		return $this->db->delete('sales_items_notes');
	}

	function save_new_work_order($customer_id,$items){
	
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		$location_id = $this->Employee->get_logged_in_employee_current_location_id();
		$register_id = $this->Register->get_first_register_id_by_location_id($location_id);

		$count_items = count($items);
		$sale_time= date('Y-m-d H:i:s');
		//insert to phppos_sales
		$sales_data = array(
			'customer_id'=> $customer_id,
			'employee_id'=>$employee_id,
			'suspended'=>2, //99
			'location_id' => $location_id,
			'register_id' =>$register_id,
			'total_quantity_purchased' => $count_items,
			'subtotal' => 0,
			'total' => 0,
			'tax' => 0,
			'profit' =>0,
			'exchange_rate'=>1,
			'exchange_currency_symbol' => $this->config->item('currency_symbol') ? $this->config->item('currency_symbol') : '$',
			'exchange_currency_symbol_location'=>"before",
			'exchange_thousands_separator'=>",",
			'exchange_decimal_point'=>".",
			'sale_time' =>$sale_time ,
			'is_work_order' => 1,
		);
		$this->db->insert('sales', $sales_data);
		$sale_id = $this->db->insert_id();

		//insert to phppos_sales_work_orders
		$status_id = $this->Work_order->get_status_id_by_name('lang:work_orders_new');
		if(!$status_id){
			$work_order_status_data = array(
				'name'=>'lang:work_orders_new',
				'color' => '#4594cc',
			);
			$this->Work_order->status_save($work_order_status_data);
			$status_id = $work_order_status_data['id'];
		}

		// if default_tech_is_logged_employee is true then set employee_id to logged employee 
		$default_tech_is_logged_employee = $this->config->item('default_tech_is_logged_employee');
		if ($default_tech_is_logged_employee) {
			$tech_employee_id = $employee_id;
		} else {
			$tech_employee_id = NULL;
		}

		$work_order_data = array(
			'sale_id'		=>	$sale_id,
			'status' 		=> 	$status_id,
			'employee_id' 	=> 	$tech_employee_id,
		);
		

		$this->Work_order->save($work_order_data);
		$work_order_id = $this->db->insert_id();

		$line = 0;
		
		// Convert Object to Array
		$items = json_decode(json_encode($items), true);
		
		foreach($items as $item){
			@$serial_number 	= $item['serial_number'] ? $item['serial_number'] : $item['serialnumber'];
			


			$item_id 		= $item['item_id'];
			$item_info 		= $this->Item->get_info($item_id,false);
			
			$variation_id 	= $item['item_variation_id'];
			
			$cost_price 	= $item_info->cost_price;
			$unit_price 	= $item_info->unit_price;
			$warranty = 0;
			$original_sale_id = NULL;
			$original_sale_time=NULL;
			if( $serial_number !=''){
				$warranty = $item_info->warranty_days;
				//getting the original sales_id and date
				 $original = get_query_data('SELECT phppos_sales_items.sale_id as original_sale_id, phppos_sales.sale_time as original_sale_time FROM `phppos_sales_items` left join phppos_sales on  phppos_sales.sale_id=phppos_sales_items.sale_id   where   serialnumber ="'.$serial_number.'" AND is_repair_item =0');
				 if($original){
					$original_sale_id = $original[0]->original_sale_id;
					$original_sale_time=$original[0]->original_sale_time;
				 }
				
			}
			if($serial_number){
				//insert to phppos_items_serialnumbers
				//$this->Item_serial_number->add_serial($item_id, $serial_number,0,0, $variation_id);
				$cost_price = $this->Item_serial_number->get_cost_price_for_serial($serial_number) ? $this->Item_serial_number->get_cost_price_for_serial($serial_number) : $item_info->cost_price;
				$unit_price = $this->Item_serial_number->get_price_for_serial($serial_number) ? $this->Item_serial_number->get_price_for_serial($serial_number) : $item_info->unit_price;
			}
			
			if($item_id && $variation_id){
				$unit_price = $this->Item->get_sale_price(array('item_id' => $item_id, 'variation_id' => $variation_id));
			}

			$item_description = $item['description'];

			// If Item is Kit == 1 then insert to phppos_sales_item_kits else insert to phppos_sales_items
			if(@$item['is_item_kit'] == 1){
				$cost_price = $item['cost_price'];
				$unit_price = $item['unit_price'];
				if ($cost_price && $unit_price)
				{
				//insert to phppos_sales_item_kits
				$sales_items_data = array(
					'sale_id'				=>	$sale_id,
					'item_kit_id'			=>	$item_id,
					'line'					=>	$line,
					'description'			=>	$item_description,
					'quantity_purchased'	=> 	$item['quantity'],
					'item_kit_cost_price' 	=> 	$cost_price,
					'item_kit_unit_price'	=> 	$unit_price,
					'commission' 			=>	0,
					'subtotal' 				=> 	0,
					'total' 				=> 	0,
					'tax' 					=> 	0,
					'profit' 				=> 	0,
					'is_repair_item' 		=> 	1,
					'warranty'				=>$warranty
				);

				$this->db->insert('sales_item_kits',$sales_items_data);

			}
			else
			{
				//Get All Items for Kit
				$kit_items = $this->Item_kit_items->get_info($item_id);

				//Check each item
				foreach ($kit_items as $item)
				{
					
					$item_info = $this->Item->get_info($item->item_id);
					//insert to phppos_sales_items
					$sales_items_data = array(
						'sale_id'				=>	$sale_id,
						'item_id'				=>	$item->item_id,
						'item_variation_id'		=>	$item->item_variation_id,
						'line'					=>	$line,
						'description'			=>	$item_info->description,
						'quantity_purchased'	=> 	$this->Item_kit->get_quantity_to_be_added_from_kit($item_id, $item->item_id, 1),
						'item_cost_price' 		=> 	$item_info->cost_price,
						'item_unit_price'		=> 	$item_info->unit_price,
						'commission' 			=>	0,
						'subtotal' 				=> 	0,
						'total' 				=> 	0,
						'tax' 					=> 	0,
						'profit' 				=> 	0,
						'is_repair_item' 		=> 	1
					);

					$this->db->insert('sales_items',$sales_items_data);
					$line++;
					
				}
				
				}
			} else {
				//insert to phppos_sales_items
				$sales_items_data = array(
					'sale_id'				=>	$sale_id,
					'item_id'				=>	$item_id,
					'item_variation_id'		=>	$variation_id,
					'line'					=>	$line,
					'description'			=>	$item_description,
					'serialnumber'			=>	$serial_number,
					'quantity_purchased'	=> 	$item['quantity'],
					'item_cost_price' 		=> 	$cost_price,
					'item_unit_price'		=> 	$unit_price,
					'commission' 			=>	0,
					'subtotal' 				=> 	0,
					'total' 				=> 	0,
					'tax' 					=> 	0,
					'profit' 				=> 	0,
					'is_repair_item' 		=> 	1,
					'warranty'				=>$warranty,
					'original_sale_id' => $original_sale_id,
					'original_sale_time' => $original_sale_time,
				);

				$this->db->insert('sales_items',$sales_items_data);
				if($serial_number){
				//need to check if the serial number is not sold we will make it sold
				//if its not sold then we will check if serial number has warranty start and end dates 
				//if its has warranty start and end dates then we will update sales warranty start and end dates
				//else it does not have warranty start and end dates we will update all four dates with current dates 


					$serial_number_info = $this->Item_serial_number->get_info_via_sn($serial_number);
					if($serial_number_info){
						if(!$serial_number_info->is_sold){	
							if($serial_number_info->warranty_start && $serial_number_info->warranty_end){
								$ser['sold_warranty_start'] =$serial_number_info->warranty_start; 
								$ser['sold_warranty_end'] =$serial_number_info->warranty_end; 
								$ser['is_sold'] =1;
								$this->db->where('serial_number',  $serial_number);
								$this->db->update('items_serial_numbers',$ser);	
							}else{
								
								$dateString = $sale_time; // Format: Y-m-d
								$date = new DateTime($dateString);
								$date->add(new DateInterval('P'.$warranty.'D'));
								$ser['sold_warranty_start'] =$sales_data['sale_time']; 
								$ser['sold_warranty_end'] =$date->format('Y-m-d');
								$ser['warranty_start'] =$sales_data['sale_time']; 
								$ser['warranty_end'] =$date->format('Y-m-d');
								$ser['is_sold'] =1;
								$this->db->where('serial_number',  $serial_number);
								$this->db->update('items_serial_numbers',$ser);	
							}

						}
					}
				}
				
			



			}
			

			$line++;
		}
		
		if($this->config->item('new_work_order_web_hook'))
		{
			$this->load->helper('webhook');
			$work_order_info = $this->get_info($work_order_id)->row_array();
			$work_order_info['items'] = $this->get_work_order_items($work_order_id);
			do_webhook($work_order_info,$this->config->item('new_work_order_web_hook'));
		}
		return $work_order_id;
	}

	function get_work_orders_by_status()
	{	
		$location_id = $this->Employee->get_logged_in_employee_current_location_id();
		$phppos_workorder_statuses = $this->db->dbprefix('workorder_statuses');
		$phppos_sales_work_orders = $this->db->dbprefix('sales_work_orders');
		$phppos_sales = $this->db->dbprefix('sales');

		$query = "SELECT `$phppos_workorder_statuses`.`id`,`$phppos_workorder_statuses`.`name`,`$phppos_workorder_statuses`.`color`, IF(sales_work_orders_query.total_number is NULL,0,sales_work_orders_query.total_number) as total_number
			FROM `$phppos_workorder_statuses`
			LEFT JOIN(
				SELECT `$phppos_sales_work_orders`.`status`, COUNT(*) as total_number
	       		FROM `$phppos_sales_work_orders`
				INNER JOIN `$phppos_sales` ON `$phppos_sales`.`sale_id` = `$phppos_sales_work_orders`.`sale_id`
				WHERE `$phppos_sales`.`location_id` = $location_id
				AND `$phppos_sales`.`deleted` = 0
				AND `$phppos_sales_work_orders`.`deleted` = 0
				GROUP BY `$phppos_sales_work_orders`.`status`
			) as sales_work_orders_query ON sales_work_orders_query.status = `$phppos_workorder_statuses`.`id` ORDER BY `$phppos_workorder_statuses`.`sort_order` ASC";
		
		return $this->db->query($query)->result_array();
	}


    /*
      Gets work_order attached files
     */

	function get_files($work_order_id)
	{
		$this->db->select('work_order_files.*,app_files.file_name');
		$this->db->from('work_order_files');
		$this->db->join('app_files','app_files.file_id = work_order_files.file_id');
		$this->db->where('work_order_id',$work_order_id);
		$this->db->order_by('work_order_files.id');
		return $this->db->get();
	}

	function add_file($work_order_id,$file_id)
	{
		$this->db->insert('work_order_files', array('file_id' => $file_id, 'work_order_id' => $work_order_id));
	}

	function delete_file($file_id)
	{
		$this->db->where('file_id',$file_id);
		$this->db->delete('work_order_files');
		$this->load->model('Appfile');
		return $this->Appfile->delete($file_id);
	}
	
	function get_status_id($id)
	{
		$this->db->from('phppos_work_orders_email_templates');
		$this->db->where('status_id', $id);

		return $this->db->get()->row();
	}

	/*
	Inserts or updates a Work Order
	*/
	function save_template($data)
	{		
		$status_id = $data['status_id'];
		$content   = $data['content'];
		$this->db->where('status_id', $status_id);
		$this->db->from('phppos_work_orders_email_templates');

		if ($this->db->get()->num_rows()) {
			$this->db->where('status_id', $status_id);
			return $this->db->update('phppos_work_orders_email_templates', array('content' => $content));
		} else {
			$this->db->insert('phppos_work_orders_email_templates', array('status_id' => $status_id,'content' => $content));
			return TRUE;
		}
	}
	
	function log_activity($work_order_id,$activity_text)
	{		
		$data = array(
			'work_order_id' => $work_order_id,
			'activity_date' => date('Y-m-d H:i:s'),
			'employee_id' => $this->Employee->get_logged_in_employee_info()->person_id,
			'activity_text' => $activity_text,
		);
		return $this->db->insert('work_order_log',$data);
	}
	
	function get_activity($work_order_id)
	{
		$this->db->from('work_order_log');
		if($work_order_id!='all'){
			$this->db->where('work_order_id', $work_order_id);
		}
	
		$this->db->order_by('activity_date');
		
		$return =  $this->db->get()->result_array();
		
		for($k=0;$k<count($return);$k++)
		{
			$return[$k]['activity_text'] = $this->transform_activity_text($return[$k]['activity_text']);
		}
		
		if ($return)
		{
			return $return;
		}
		return array();
	}
	
	public function transform_activity_text($activity_text)
	{	
		$field_db_name = get_text_between_delimiters($activity_text,'[field]','[/field]');
		$field = $this->get_field($activity_text);
		
		if ($field === FALSE)
		{
			return $activity_text;
		}
		
		$old_value = $this->get_old_value($activity_text,$field_db_name);
		$new_value = $this->get_new_value($activity_text,$field_db_name);
		
		$activity_text = replace_text_between_delimiters($activity_text,'[field]','[/field]',$field);
		$activity_text = replace_text_between_delimiters($activity_text,'[oldvalue]','[/oldvalue]',$old_value);
		$activity_text = replace_text_between_delimiters($activity_text,'[newvalue]','[/newvalue]',$new_value);
		
		$activity_text = str_replace('[field]','',$activity_text);
		$activity_text = str_replace('[/field]','',$activity_text);

		$activity_text = str_replace('[oldvalue]','',$activity_text);
		$activity_text = str_replace('[/oldvalue]','',$activity_text);

		$activity_text = str_replace('[newvalue]','',$activity_text);
		$activity_text = str_replace('[/newvalue]','',$activity_text);
		return $activity_text;
	}
	
	private function get_field($activity_text)
	{
		$this->lang->load('locations');
		
		$fields_to_langs = array(
			'sale_id' => lang('sale_id'),		
			'unit_price' => lang('unit_price'),		
			'status' => lang('status'),		
			'employee_id' => lang('employee'),		
			'estimated_repair_date' => lang('work_orders_estimated_repair_date'),		
			'estimated_parts' => lang('work_orders_estimated_parts'),		
			'estimated_labor' => lang('work_orders_estimated_labor'),		
			'warranty' => lang('work_orders_warranty_repair'),		
			'comment' => lang('comment'),		
			'images' => lang('images'),		
			'deleted' => lang('deleted'),		
			'pre_auth_signature_file_id' => lang('locations_blockchyp_work_order_pre_auth'),
			'post_auth_signature_file_id' => lang('locations_blockchyp_work_order_post_auth'),
			'approved_by' => lang('approved_by'),
			'assigned_to' => lang('assigned_to'),
			'assigned_repair_item' => lang('assigned_repair_item'),
		);
		
		
		for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) 
		{
			$custom_field = $this->Work_order->get_custom_field($k);
			if($custom_field !== FALSE)
			{
				$fields_to_langs['custom_field_'.$k.'_value'] = $custom_field;
			}
		}
		
		
		$this->load->helper('text');
		$field = get_text_between_delimiters($activity_text,'[field]','[/field]');
		
		if (isset($fields_to_langs[$field]))
		{
			return $fields_to_langs[$field];
	
		}
		
		return FALSE;
	}
	
	private function get_old_value($activity_text,$field)
	{
		$this->load->helper('text');
		$value = get_text_between_delimiters($activity_text,'[oldvalue]','[/oldvalue]');
		
		return $this->translate_field_value($value,$field);
		
	}
	
	private function get_new_value($activity_text,$field)
	{
		$this->load->helper('text');
		$value = get_text_between_delimiters($activity_text,'[newvalue]','[/newvalue]');
		
		return $this->translate_field_value($value,$field);
	}
	
	private function translate_field_value($field_value,$field)
	{
		if($field == 'sale_id')
		{
			return $field_value;
		}
		elseif($field == 'status')
		{
			$status_string = $this->get_status_info($field_value)->name;
			return $this->get_status_name($status_string);
		}
		elseif($field == 'employee_id')
		{
			return $this->Employee->get_info($field_value)->full_name;
		}
		elseif($field == 'estimated_repair_date')
		{
			return date(get_date_format().' '.get_time_format(), strtotime($field_value));
		}
		elseif($field == 'estimated_parts')
		{
			return to_currency($field_value);
		}
		elseif($field == 'estimated_labor')
		{
			return to_currency($field_value);			
		}
		elseif($field == 'warranty')
		{
			return boolean_as_string($field_value);
		}
		elseif($field == 'comment' || $field == 'description')
		{
			return $field_value;
		}
		elseif($field == 'images')
		{
			$images = $field_value && unserialize($field_value) ? unserialize($field_value) : array();
			
			if (count($images) == 0)
			{
				return lang('none');
			}
			
			return count($images);
			
		}
		elseif($field == 'deleted')
		{
			return boolean_as_string($field_value);
		}
		elseif($field == 'pre_auth_signature_file_id')
		{
			return boolean_as_string($field_value);
		}
		elseif($field == 'post_auth_signature_file_id')
		{
			return boolean_as_string($field_value);
		}
		elseif($field == 'unit_price')
		{
			return to_currency($field_value);			
		}
		
		return $field_value;
	}

	function get_checkbox_groups($group_id=null,$limit=10000, $offset=0, $col='sort_order',$order='asc')
	{
		$this->db->select($this->db->dbprefix('workorder_checkbox_groups').'.id');
		$this->db->select($this->db->dbprefix('workorder_checkbox_groups').'.name');
		$this->db->select("GROUP_CONCAT( IF(".$this->db->dbprefix('workorder_checkboxes').".type = 1, ".$this->db->dbprefix('workorder_checkboxes').".name, NULL) ORDER BY ".$this->db->dbprefix('workorder_checkboxes').".sort_order ASC SEPARATOR ', ') as pre_checkboxes"); 
		$this->db->select("GROUP_CONCAT( IF(".$this->db->dbprefix('workorder_checkboxes').".type = 2, ".$this->db->dbprefix('workorder_checkboxes').".name, NULL) ORDER BY ".$this->db->dbprefix('workorder_checkboxes').".sort_order ASC SEPARATOR ', ') as post_checkboxes"); 
		
		$this->db->from('workorder_checkbox_groups');

		$this->db->join('workorder_checkboxes', 'workorder_checkboxes.group_id = workorder_checkbox_groups.id');

		$this->db->where('workorder_checkbox_groups.deleted', 0);
		$this->db->where('workorder_checkboxes.deleted', 0);

		if($group_id){
			$this->db->where('workorder_checkbox_groups.id', $group_id);
		}

		$this->db->group_by($this->db->dbprefix('workorder_checkbox_groups').'.id');
		$this->db->group_by($this->db->dbprefix('workorder_checkbox_groups').'.name');

		$this->db->order_by($this->db->dbprefix('workorder_checkbox_groups').".".$col, $order);

		$this->db->limit($limit);
		$this->db->offset($offset);

		return $this->db->get()->result();
	}

	function get_checkbox_group_info($id = 0)
	{
		$this->db->from('workorder_checkbox_groups');
		$this->db->where('id', $id);
		$query = $this->db->get();
		
		if($query->num_rows()==1) {
			return $query->row();
		} else {
			$mod_obj=new stdClass();
			
			//Get all the fields from customer table
			$fields = array('id','name','sort_order', 'deleted');
			//append those fields to base parent object, we we have a complete empty object
			foreach ($fields as $field) {
				$mod_obj->$field='';
			}
			
			return $mod_obj;
		}
	}

	function save_checkbox($id, $data)
	{
		$checkbox_group_data = array('name' => $data['group_name'], 'sort_order' => $data['sort_order']);

		if($id) {
			$this->db->where('id', $id);
			$this->db->update('workorder_checkbox_groups', $checkbox_group_data);
		} else {
			$this->db->insert('workorder_checkbox_groups', $checkbox_group_data);
			$id = $this->db->insert_id();
		}
		
		foreach($data['pre_checkboxes'] as $checkbox){
			if(!$checkbox['name']){
				continue;
			}
			$checkbox_data = array(
				'group_id' => $id,
				'name' => $checkbox['name'],
				'description' => $checkbox['description'],
				'sort_order' => $checkbox['sort_order'],
				'type' => 1
			);

			if($checkbox['id'] > 0) {
				$this->db->where('id', $checkbox['id']);
				$this->db->update('workorder_checkboxes', $checkbox_data);
			} else {
				$this->db->insert('workorder_checkboxes', $checkbox_data);
			}
		}

		foreach($data['post_checkboxes'] as $checkbox){
			if(!$checkbox['name']){
				continue;
			}
			$checkbox_data = array(
				'group_id' => $id,
				'name' => $checkbox['name'],
				'description' => $checkbox['description'],
				'sort_order' => $checkbox['sort_order'],
				'type' => 2
			);

			if($checkbox['id'] > 0) {
				$this->db->where('id', $checkbox['id']);
				$this->db->update('workorder_checkboxes', $checkbox_data);
			} else {
				$this->db->insert('workorder_checkboxes', $checkbox_data);
			}
		}
		
		if(is_array($data['checkbox_items_to_delete'])){
			foreach($data['checkbox_items_to_delete'] as $checkbox_to_delete) {
				$this->db->where('id', $checkbox_to_delete);
				$this->db->update('workorder_checkboxes',array('deleted' => 1));
			}
		}

		return $id;
	}

	function delete_item($sale_id,$line){
		$this->db->query('SET FOREIGN_KEY_CHECKS = 0');
		$where = array('sale_id' => $sale_id,'line' => $line);
		$this->db->delete('sales_items_taxes', $where);
		$this->db->delete('sales_items', $where);
		$this->db->delete('sales_items_modifier_items', $where);
		$this->db->query('SET FOREIGN_KEY_CHECKS = 1');
	}

	function get_workorder_checkbox_group_id($workorder_id){
		$this->db->from('workorder_checkboxes_states');
		$this->db->where('workorder_id', $workorder_id);
		$state_query = $this->db->get();
		
		if($state_query->num_rows() > 0){
			$group_query = $this->db->get_where('workorder_checkboxes', array('id' => $state_query->row('checkbox_id')));
			if($group_query->num_rows() > 0){
				return $group_query->row('group_id');
			}
		}
		return false;
	}

	function get_status_email_template($status_id){
		// Search and Replace Template 
		$this->db->select('content');
		$this->db->from('work_orders_email_templates');
		$this->db->where('status_id', $status_id);
		$status_template = $this->db->get()->row();

		
		if (empty($status_template)) {
			$this->db->select('content');
			$this->db->from('work_orders_email_templates');
			$this->db->where('status_id', 0);
			$status_template = $this->db->get()->row();
		}

		if ($status_template) {
			return $status_template;
		}

		return false;
	}
	
	function get_modifiers_unit_total($sale_id, $item_id,$line = null)
	{
		$this->db->from('sales_items_modifier_items');
		$where = array('sale_id' => $sale_id, 'item_id' => $item_id);
		
		if ($line!== NULL)
		{
			$where['line'] = $line;
		}
		
		$this->db->where($where);
		$return = 0;
		foreach($this->db->get()->result_array() as $row)
		{
			$return+=$row['unit_price'] ? $row['unit_price'] : 0;
		}
		
		return $return;
	}
	
	function get_modifiers_modifier_unit_total($modifier_id,$sale_id, $item_id,$line = null)
	{
		$this->db->from('sales_items_modifier_items');
		$where = array('modifier_item_id' => $modifier_id,'sale_id' => $sale_id, 'item_id' => $item_id);
		
		if ($line!== NULL)
		{
			$where['line'] = $line;
		}
		
		$this->db->where($where);
		$return = 0;
		foreach($this->db->get()->result_array() as $row)
		{
			$return+=$row['unit_price'] ? $row['unit_price'] : 0;
		}
		
		return $return;
	}
	
	
	function get_modifiers_cost_total($sale_id, $item_id,$line=null)
	{
		$this->db->from('sales_items_modifier_items');
		$where = array('sale_id' => $sale_id, 'item_id' => $item_id);
		
		if ($line!== NULL)
		{
			$where['line'] = $line;
		}
		
		$return = 0;
		foreach($this->db->get()->result_array() as $row)
		{
			$return+=$row['cost_price'] ? $row['cost_price'] : 0;
		}
		
		return $return;
	}
	
	

	function save_modifiers($sale_id, $item_id, $line, $modifier_items){

		$before_modifiers_unit_total = $this->get_modifiers_unit_total($sale_id,$item_id,$line);
		$before_modifiers_cost_total = $this->get_modifiers_cost_total($sale_id,$item_id,$line);
		
		$this->db->delete('sales_items_modifier_items', array('sale_id' => $sale_id, 'item_id' => $item_id, 'line' => $line));

		foreach($modifier_items as $modifier_item_id => $modifier_item){
			$sales_items_modifier_items_data = array(
				'modifier_item_id' => $modifier_item_id,
				'sale_id' => $modifier_item['sale_id'],
				'item_id' => $modifier_item['item_id'],
				'line' => $modifier_item['line'],
				'unit_price' => $modifier_item['unit_price'] ? $modifier_item['unit_price'] : 0,
				'cost_price' => $modifier_item['cost_price'] ? $modifier_item['cost_price'] : 0,
			);
			$this->db->insert('sales_items_modifier_items', $sales_items_modifier_items_data);
		}
		
		$after_modifiers_unit_total = $this->get_modifiers_unit_total($sale_id,$item_id,$line);
		$after_modifiers_cost_total = $this->get_modifiers_cost_total($sale_id,$item_id,$line);
		$this->db->set('item_unit_price', 'item_unit_price+'.($after_modifiers_unit_total-$before_modifiers_unit_total), false);
		$this->db->set('item_cost_price', 'item_cost_price+'.($after_modifiers_cost_total-$before_modifiers_cost_total), false);
		$this->db->where(array('sale_id' => $sale_id, 'item_id' => $item_id, 'line' => $line));
		$this->db->update('sales_items');
	}

	function update_item_modifier_price($sale_id, $item_id, $line, $modifier_item_id, $value)
	{
		$before_modifiers_modifier_unit_total = $this->get_modifiers_modifier_unit_total($modifier_item_id,$sale_id,$item_id,$line);
		
		$this->db->where(array('sale_id' => $sale_id, 'item_id' => $item_id, 'line' => $line, 'modifier_item_id' => $modifier_item_id));
		$this->db->update('sales_items_modifier_items', array('unit_price' => $value));
		
		$this->db->where(array('sale_id' => $sale_id, 'item_id' => $item_id, 'line' => $line));
		$this->db->set('item_unit_price', 'item_unit_price+'.($value-$before_modifiers_modifier_unit_total), false);
		$this->db->update('sales_items');

	}

	function create_or_update_repair_item($description=false, $item_id=false){
		$item_data = array(
			'deleted' => 0,
			'name'=> lang('work_orders_repair_item'),
			'description'=> $description ? $description : lang('work_orders_repair_item'),
			'category_id'=> $this->Category->save(lang('work_orders_repair_item'), TRUE, NULL, $this->Category->get_category_id(lang('work_orders_repair_item'))),
			'size'=>'',
			'item_number'=> lang('work_orders_repair_item'),
			'product_id'=> lang('work_orders_repair_item'),
			'cost_price'=> 0,
			'unit_price'=> 0,
			'allow_alt_description'=> 1,
			'is_serialized'=>1,
			'system_item'=> 0,
			'override_default_tax'=> $this->config->item('work_repair_item_taxable') ? 0 : 1,
			'is_ecommerce' => 0,
			'is_service'=> 1,
			'disable_loyalty' => 1,
		);
		
		if ($item_id == FALSE)
		{
			$item_id = $this->Item->get_item_id(lang('work_orders_repair_item'));
		}
		if($this->Item->save($item_data, $item_id)) {
			if(isset($item_data['item_id'])){
				return $item_data['item_id'];
			}
			else
			{
				return $item_id;
			}
		}
		return false; 
	}

	function create_or_update_repair_item_kits($description = false, $item_kit_id = false){
		$item_kit_data = array(
			'deleted' 				=>	0,
			'name'					=> 	lang('work_orders_repair_item'),
			'description'			=> 	$description ? $description : lang('work_orders_repair_item'),
			'category_id'			=> 	$this->Category->save(lang('work_orders_repair_item'), TRUE, NULL, $this->Category->get_category_id(lang('work_orders_repair_item'))),
			'item_kit_number'		=> 	lang('work_orders_repair_item'),
			'product_id'			=> 	lang('work_orders_repair_item'),
			'cost_price'			=> 	0,
			'unit_price'			=> 	0,
			'override_default_tax'	=> 	$this->config->item('work_repair_item_taxable') ? 0 : 1,
			'disable_loyalty' 		=> 	1,
		);
		
		
		if ($item_kit_id == FALSE)
		{
			$item_kit_id = $this->Item_kit->get_item_kit_id(lang('work_orders_repair_item'));
		}
		if($this->Item_kit->save($item_kit_data, $item_kit_id)) {
			if(isset($item_kit_data['item_kit_id'])){
				return $item_kit_data['item_kit_id'];
			}
			else
			{
				return $item_kit_id;
			}
		}
		return false;
	}

	function delete_item_kit($sale_id,$line){
		$this->db->query('SET FOREIGN_KEY_CHECKS = 0');
		$where = array('sale_id' => $sale_id,'line' => $line);
		$this->db->delete('sales_item_kits_taxes', $where);
		$this->db->delete('sales_item_kits', $where);
		$this->db->delete('sales_item_kits_modifier_items', $where);
		$this->db->query('SET FOREIGN_KEY_CHECKS = 1');
	}


	// Delete Work Order Log Entry 
	function delete_work_order_log($work_order_id)
	{
		$this->db->where('id', $work_order_id);
		return $this->db->delete('work_order_log');
	}

	function update_work_order_sales($sale_id, $employee_id)
	{
		$previous_work_order_data = $this->get_info_by_sale_id($sale_id)->row_array();
		
		// if default_tech_is_logged_employee is true then set employee_id to logged employee 
		$default_tech_is_logged_employee = $this->config->item('default_tech_is_logged_employee');
		if ($default_tech_is_logged_employee) {
			$tech_employee_id = $employee_id;
		} else {
			$tech_employee_id = NULL;
		}
		$work_order_data = array(
			'sale_id'		=>	$sale_id,
			'employee_id' 	=> 	$tech_employee_id,
		);
		if ($previous_work_order_data)
		{
			$work_order_data = array_merge($previous_work_order_data,$work_order_data);
		}
		$this->Work_order->save($work_order_data);
	}


	function get_stats_for_graph($status=0 , $time ='all_time' , $from_date='' , $to_date = ''){
		$location_id = $this->Employee->get_logged_in_employee_current_location_id();
		$prefix = $this->db->dbprefix;
		$this->db->save_queries = true;
		$query = 'SELECT count(sales.sale_id) as total , CONCAT(pep.first_name ," ", pep.last_name) as full_name   FROM `'.$prefix.'sales` as sales left join '.$prefix.'employees as emp on emp.id=sales.employee_id left join '.$prefix.'people as pep on pep.person_id = emp.person_id LEFT JOIN '.$prefix.'sales_work_orders as swo on swo.sale_id = sales.sale_id WHERE sales.is_work_order=1 and sales.location_id='.$location_id.'  ';
		if($status!=0){
			$query .=' AND swo.status='.$status.' ';
		}
		if($time!='all_time'){
			if($time=='THIS_MONTH'){
				$query .=' AND MONTH(sales.sale_time) = MONTH(CURDATE()) AND YEAR(sales.sale_time) = YEAR(CURDATE()) ';
			}else if($time=='THIS_YEAR'){
				$query .=' AND MONTH(sales.sale_time) = MONTH(CURDATE()) AND YEAR(sales.sale_time) = YEAR(CURDATE()) ';
			}else if($time=='THIS_WEEK'){
				$query .=' AND YEAR(sales.sale_time) = YEAR(CURDATE()) AND WEEK(sales.sale_time, 1) = WEEK(CURDATE(), 1) ';
			}
			else if($time=='TODAY'){
				$query .=' AND DATE(sales.sale_time) = CURDATE() ';
			}else if ($time == 'CUSTOM') {
				// Ensure $from_date and $to_date are properly sanitized to prevent SQL injection
				$query .= ' AND DATE(sales.sale_time) BETWEEN \'' . $from_date . '\' AND \'' . $to_date . '\' ';
			}
			
		}
		
		$query .='GROUP by sales.employee_id ORDER BY count(sales.sale_id) DESC  ';

		$data = get_query_data($query , 'array');
		// echo $this->db->last_query();
		return $data;

	}
	function get_stats_for_graph_no_employee( $time ='all_time' , $from_date='' , $to_date = '' , $location_id = false){
		
		
		if(!$location_id){
			$location_id = $this->Employee->get_logged_in_employee_current_location_id();
		}
		$location_query='';
		if(getenv('MASTER_LOCATION')!=$this->Employee->get_logged_in_employee_current_location_id())
		{
			$location_query='and sales.location_id='.$location_id;
		}
		$prefix = $this->db->dbprefix;
		$this->db->save_queries = true;
		$query = 'SELECT count(sales.sale_id) as total  , 
		     	  REPLACE(REPLACE(ws.name, "lang:", ""),"_", " ") AS full_name,
				 ws.color AS colors
			  FROM `'.$prefix.'sales` as sales  
			  LEFT JOIN '.$prefix.'sales_work_orders as swo on swo.sale_id = sales.sale_id 
			  LEFT JOIN '.$prefix.'workorder_statuses AS ws ON swo.status = ws.id WHERE sales.is_work_order=1 '.$location_query.'   ';
		
		if($time!='all_time'){
			if($time=='THIS_MONTH'){
				$query .=' AND MONTH(sales.sale_time) = MONTH(CURDATE()) AND YEAR(sales.sale_time) = YEAR(CURDATE()) ';
			}else if($time=='THIS_YEAR'){
				$query .=' AND MONTH(sales.sale_time) = MONTH(CURDATE()) AND YEAR(sales.sale_time) = YEAR(CURDATE()) ';
			}else if($time=='THIS_WEEK'){
				$query .=' AND YEAR(sales.sale_time) = YEAR(CURDATE()) AND WEEK(sales.sale_time, 1) = WEEK(CURDATE(), 1) ';
			}
			else if($time=='TODAY'){
				$query .=' AND DATE(sales.sale_time) = CURDATE() ';
			}else if ($time == 'CUSTOM') {
				// Ensure $from_date and $to_date are properly sanitized to prevent SQL injection
				$query .= ' AND DATE(sales.sale_time) BETWEEN \'' . $from_date . '\' AND \'' . $to_date . '\' ';
			}
			
		}
		
		$query .='GROUP by swo.status ORDER BY count(sales.sale_id) DESC  ';

		$data = get_query_data($query , 'array');
		// echo $this->db->last_query();
		// exit();
		return $data;

	}

}
