<?php
class Item_serial_number extends MY_Model
{
	private $ecom_model;
	
	function __construct()
	{
		$this->load->model('Inventory');
		$this->load->model('Appconfig');
		$this->load->model('Item_variation_location');
		if ($this->Appconfig->get_key_directly_from_database("ecommerce_platform"))
		{
			require_once (APPPATH."models/interfaces/Ecom.php");
			$this->ecom_model = Ecom::get_ecom_model();
		}
	}
	function get_all($item_id, $location_id = NULL, $can_cache = TRUE)
	{		
		if ($can_cache)
		{
			static $cache  = array();
		
			if (isset($cache[$item_id.'|'.$location_id]))
			{
				return $cache[$item_id.'|'.$location_id];
			}
		}
		else
		{
			$cache = array();
		}
		
		$this->db->from('items_serial_numbers');
		$this->db->where('item_id',$item_id);
		
		if ($location_id)
		{
			$this->db->group_start();
			$this->db->where('serial_location_id',$location_id);
			$this->db->or_where('serial_location_id',NULL);
			$this->db->group_end();
			$this->db->order_by('id');
		}
		
		$query = $this->db->get();

		if ($query !== FALSE && $query->num_rows()>0) {
		$cache[$item_id.'|'.$location_id] = $query->result_array();
		return $cache[$item_id.'|'.$location_id];
		}else{
			return false;
		}
		
	}
	
	function save($item_id, $serial_numbers, $serial_number_cost_prices = array(), $serial_number_prices = array(), $serial_number_variations = array(),$serials_to_delete = FALSE, $add_to_inventory = array(),$serial_locations = array(),$serial_number_warranty_start = array(),$serial_number_warranty_end = array(),$serial_number_replace_sale_date= array())
	{
		$this->db->trans_start();
		$add_to_inventory = is_array($add_to_inventory) ? $add_to_inventory : array();
		if(!is_array($serial_numbers)){
			return false;
		}
		if (empty($serial_number_prices) || count($serial_numbers) != count($serial_number_prices))
		{
			$serial_number_prices = array_fill(0,count($serial_numbers),'');
		}
		
		if (empty($serial_number_cost_prices) || count($serial_number_cost_prices) != count($serial_number_cost_prices))
		{
			$serial_number_cost_prices = array_fill(0,count($serial_numbers),'');
		}
		
		if (empty($serial_number_variations) || count($serial_number_variations) != count($serial_number_variations))
		{
			$serial_number_variations = array_fill(0,count($serial_numbers),'');
		}


		if (empty($serial_locations) || count($serial_locations) != count($serial_locations))
		{
			$serial_locations = array_fill(0,count($serial_numbers),'');
		}

		if (empty($serial_number_warranty_start) || count($serial_number_warranty_start) != count($serial_number_warranty_start))
		{
			$serial_number_warranty_start = array_fill(0,count($serial_numbers),'');
		}

		if (empty($serial_number_warranty_end) || count($serial_number_warranty_end) != count($serial_number_warranty_end))
		{
			$serial_number_warranty_end = array_fill(0,count($serial_numbers),'');
		}

		if (empty($serial_number_replace_sale_date) || count($serial_number_replace_sale_date) != count($serial_number_replace_sale_date))
		{
			$serial_number_replace_sale_date = array_fill(0,count($serial_number_replace_sale_date),'');
		}
		
		//If we do NOT have $serials_to_delete then delete all
		if ($serials_to_delete === FALSE)
		{
			$this->delete($item_id);
		}
		else
		{
			if (is_array($serials_to_delete))
			{
				foreach($serials_to_delete as $deleted_serial)
				{
					$this->delete_serial($item_id, $deleted_serial);
				}
			}
		}
		foreach($serial_numbers as $k => $v)
		{
			
			$serial_number = $serial_numbers[$k];
			if ($serial_number != '')
			{
				$unit_price = $serial_number_prices[$k];
				$cost_price = $serial_number_cost_prices[$k];
				$variation_id = $serial_number_variations[$k];
				$location_id = $serial_locations[$k];
				$warranty_start = $serial_number_warranty_start[$k];
				$warranty_end = $serial_number_warranty_end[$k];
				$replace_sale_date = isset($serial_number_replace_sale_date[$k])?1:0;
				
				if($unit_price === '')
				{
					$unit_price = NULL;
				}
				
				if($cost_price === '')
				{
					$cost_price = NULL;
				}
				
				if($variation_id === '')
				{
					$variation_id = NULL;
				}
				
				if ($location_id === '')
				{
					$location_id = NULL;
				}
				if($warranty_start === '')
				{
					$warranty_start = NULL;
				}
				if($warranty_end === '')
				{
					$warranty_end = NULL;
				}
				$this->add_serial($item_id, $serial_number, 'manually',$cost_price, $unit_price,$variation_id, $location_id,$k > 0 ? $k : false ,$warranty_start ,$warranty_end ,$replace_sale_date);

				if(!array_key_exists($k, $add_to_inventory)){
					continue;
				}

				$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
				$location_id = $this->Employee->get_logged_in_employee_current_location_id();
				$cur_item_variation_location_info = $this->Item_variation_location->get_info($variation_id);
				
				$cur_item_info = $this->Item->get_info($item_id);

				if($variation_id){
					$current_quantity = ($cur_item_variation_location_info->quantity ? $cur_item_variation_location_info->quantity : 0) + 1;
					$inv_data = array(
						'trans_date'=>date('Y-m-d H:i:s'),
						'trans_items'=>$item_id,
						'item_variation_id'=>$variation_id,
						'trans_user'=>$employee_id,
						'trans_comment'=>'',
						'trans_inventory'=>1,
						'location_id'=> $location_id,
						'trans_current_quantity' => $current_quantity,
					);
		
					$this->Inventory->insert($inv_data);
					$this->Item_variation_location->save_quantity($current_quantity,$variation_id);


					//Ecommerce							
					if (isset($this->ecom_model))
					{
						$cur_ecom_location_sync = $this->Appconfig->get_ecommerce_locations();
						$ecom_sync_status = $cur_ecom_location_sync[$location_id];
						
						if ($cur_item_info->is_ecommerce && $location_id  == $this->ecom_model->ecommerce_store_location && $ecom_sync_status)
						{		
							if (strtolower(get_class($this->ecom_model)) == 'shopify')		
							{
								$cur_item_variation_info = $this->Item_variations->get_info($variation_id);
								
								if ($cur_item_variation_info->is_ecommerce)
								{
									$ecommerce_inventory_item_id = $cur_item_variation_info->ecommerce_inventory_item_id;
									$ecom_item_data = array(
										'stock_quantity' => $current_quantity,
										'ecommerce_inventory_item_id' => $ecommerce_inventory_item_id,
										'manage_stock' => true,
									);
							
									$this->ecom_model->update_item_from_phppos_to_ecommerce($item_id, $ecom_item_data);
								}
				
							}
							else
							{
								$ecom_item_data = array('manage_stock' => false);
								$this->ecom_model->update_item_from_phppos_to_ecommerce($item_id, $ecom_item_data);
								$this->ecom_model->save_item_variations($item_id);
							}
						}
					}	
				}else{
					$this->load->model('Item_location');
					$cur_item_location_info = $this->Item_location->get_info($item_id);
					$current_quantity = ($cur_item_location_info->quantity ? $cur_item_location_info->quantity : 0) + 1;

					$inv_data = array(
						'trans_date'=>date('Y-m-d H:i:s'),
						'trans_items'=>$item_id,
						'trans_user'=>$employee_id,
						'trans_comment'=>'',
						'trans_inventory'=>1,
						'location_id'=>$location_id,
						'trans_current_quantity' => $current_quantity,
					);
				
					$this->Inventory->insert($inv_data);
					
					//Update stock quantity
					if($this->Item_location->save_quantity($current_quantity,$item_id))
					{
						//Ecommerce
						if (isset($this->ecom_model))
						{
							$cur_ecom_location_sync = $this->Appconfig->get_ecommerce_locations();
							$ecom_sync_status = $cur_ecom_location_sync[$location_id];
							
							if ($cur_item_info->is_ecommerce && $location_id  == $this->ecom_model->ecommerce_store_location && $ecom_sync_status)
							{
								$ecom_item_data = array(
									'stock_quantity' => $current_quantity,
									'manage_stock' => true,
								);
								
								$this->ecom_model->update_item_from_phppos_to_ecommerce($item_id, $ecom_item_data);
							}
						}
					}
				}
			}
		}
				
		$this->db->trans_complete();
		
		return TRUE;
	}
	
	function get_price_for_serial($serial_number)
	{
		$this->db->from('items_serial_numbers');
		$this->db->where('serial_number',$serial_number);
		$row = $this->db->get()->row_array();
		
		if (isset($row['unit_price']) && $row['unit_price'] !== NULL)
		{
			return $row['unit_price'];
		}
		
		return FALSE;
	}
	
	function get_cost_price_for_serial($serial_number)
	{
		$this->db->from('items_serial_numbers');
		$this->db->where('serial_number',$serial_number);
		$row = $this->db->get()->row_array();
		
		if (isset($row['cost_price']) && $row['cost_price'] !== NULL)
		{
			return $row['cost_price'];
		}
		
		return FALSE;
	}
	
	/*
	Deletes one item
	*/
	function delete($item_id)
	{		
		return $this->db->delete('items_serial_numbers', array('item_id' => $item_id));
	}
	
	function delete_serial($item_id, $serial_number)
	{
		return $this->db->delete('items_serial_numbers', array('item_id' => $item_id, 'serial_number' => $serial_number));		
	}

	function add_serial($item_id, $serial_number, $type_serial_number = 'manually', $cost_price = NULL, $unit_price = NULL,$variation_id = NULL, $location_id = NULL, $serial_number_id = false, $warranty_start = NULL, $warranty_end = NULL, $replace_sale_date =0 )
	{
		if(!$serial_number_id or !$this->exists($serial_number_id)){

			 $this->db->replace('items_serial_numbers', array('item_id' => $item_id, 'serial_number' => $serial_number,'cost_price' => $cost_price, 'unit_price' => $unit_price,'variation_id' => $variation_id, 'serial_location_id' => $location_id, 'warranty_start' => $warranty_start, 'warranty_end' => $warranty_end , 'replace_sale_date' => $replace_sale_date));
		  	$new = $this->db->insert_id();
			$this->add_sn_log($new , 'Added' , 'Added Serial no '.$type_serial_number );
			return true;
		}

		$this->db->where('id', $serial_number_id);
		return $this->db->update('items_serial_numbers', array('item_id' => $item_id, 'serial_number' => $serial_number,'cost_price' => $cost_price, 'unit_price' => $unit_price,'variation_id' => $variation_id, 'serial_location_id' => $location_id, 'warranty_start' => $warranty_start, 'warranty_end' => $warranty_end, 'replace_sale_date' => $replace_sale_date));
	}

	function update_serial($serial_number_id, $field , $value ){
		
		
		$this->add_sn_log($serial_number_id , 'Updated' , 'Updated-'.$field  );

		$this->db->where('id', $serial_number_id);
		return $this->db->update(
			'items_serial_numbers', 
			array(
				$field  => $value, 
			)

		);
	}


	function add_sn_log($serial_number_id , $action , $remarks )
	{
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$this->db->insert('sn_log', [
			'sn_id' => $serial_number_id,
			'action' => $action,
			'remarks' => $remarks,
			'added_by' => $employee_id,
		]);	
	}
	/*
	Determines if a given register_id is a register
	*/
	function exists($serial_number_id)
	{
		$this->db->from('items_serial_numbers');	
		$this->db->where('id',$serial_number_id);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	
	function get_item_id($serial_number)
	{
		$this->db->from('items_serial_numbers');
		$this->db->where('serial_number',$serial_number);

		$query = $this->db->get();

		if($query->num_rows() >= 1)
		{
			return $query->row()->item_id;
		}
		
		return FALSE;
	}

	function get_warranty_days($item_id)
	{
		$this->db->from('items');
		$this->db->where('item_id',$item_id);

		$query = $this->db->get();

		if($query->num_rows() >= 1)
		{
			return $query->row()->warranty_days;
		}
		
		return FALSE;
	}
	
	function get_variation_id($serial_number)
	{
		$this->db->from('items_serial_numbers');
		$this->db->where('serial_number',$serial_number);

		$query = $this->db->get();

		if($query->num_rows() >= 1)
		{
			return $query->row()->variation_id;
		}
		
		return FALSE;
	}
	
	function cleanup()
	{
		$item_serial_numbers_table = $this->db->dbprefix('items_serial_numbers');
		$items_table = $this->db->dbprefix('items');
		return $this->db->query("DELETE FROM $item_serial_numbers_table WHERE item_id IN (SELECT item_id FROM $items_table WHERE deleted = 1)");
	}	
}
?>