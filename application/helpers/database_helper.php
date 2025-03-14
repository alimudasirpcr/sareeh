<?php
function create_and_execute_large_update_query_items($item_ids, $item_data , $cleanup =false)
{
	$CI =& get_instance();
	$items_table = $CI->db->dbprefix('items');
	
	$set_statements = array();
	foreach($item_data as $key=>$value)
	{
		$value = $CI->db->escape($value);
		$set_statements[] =" $key = $value "; 

		


	}
	
	if($cleanup){
			foreach($item_ids as $valued){

			$CI->load->model('Additional_item_numbers');
			$CI->Additional_item_numbers->cleanup($valued);
			$CI->load->model('Item_serial_number');
			$CI->Item_serial_number->cleanup($valued);
			$CI->load->model('Item_variations');
			$CI->Item_variations->cleanup($valued);

			


		}
	}
	$set_statements[] = ' last_modified = "'.date('Y-m-d H:i:s').'" ';
	$set = implode(',',$set_statements);	
	$in = implode(',',$item_ids);
	if($cleanup){
		$set_statements[] = ' item_number = NULL '; 
		$set_statements[] = ' product_id = NULL ';

		$item_tier_prices_table = $CI->db->dbprefix('items_tier_prices');
		$items_table = $CI->db->dbprefix('items');
		$item_images_table = $CI->db->dbprefix('item_images');
		$app_files_table = $CI->db->dbprefix('app_files');
		$CI->db->query('SET FOREIGN_KEY_CHECKS = 0');
		$CI->db->query("DELETE FROM $item_images_table WHERE item_id IN ($in)");
		$CI->db->query('SET FOREIGN_KEY_CHECKS = 1');
		$CI->db->query("DELETE FROM $item_tier_prices_table WHERE item_id IN ($in)");

	}
	

	$query = "UPDATE $items_table SET $set WHERE item_id IN ($in)";
	return $CI->db->simple_query($query);
}
function create_and_execute_large_update_query_location_items($item_ids, $location_id, $item_location_data)
{
	$CI =& get_instance();
	$location_items_table = $CI->db->dbprefix('location_items');
	$items_table = $CI->db->dbprefix('items');
	
	$set_statements = array();
	foreach($item_location_data as $key=>$value)
	{
		$value = $CI->db->escape($value);
		$set_statements[] =" $key = $value "; 
	}
	
	$set = implode(',',$set_statements);
	$in = implode(',',$item_ids);
	
	$location_id = $CI->db->escape($location_id);
	
	$lm = date('Y-m-d H:i:s');
	$query = "UPDATE $items_table SET last_modified = '$lm' WHERE item_id IN ($in)";
	$CI->db->simple_query($query);
	
	$query = "UPDATE $location_items_table SET $set WHERE item_id IN ($in) and location_id=$location_id";
	return $CI->db->simple_query($query);
}

function create_and_execute_large_update_query_location_items_percent($item_ids, $cost_price_percent,$unit_price_percent,$promo_price_percent,$promo_price_use_selling_price = FALSE)
{
	$CI =& get_instance();
	$items_table = $CI->db->dbprefix('items');
		
	$set_statements = array();
	
	if ($cost_price_percent)
	{
		$set_statements[] = " cost_price = cost_price * (1+($cost_price_percent/100)) ";
	}

	if ($unit_price_percent)
	{
		$set_statements[] = " unit_price = unit_price * (1+($unit_price_percent/100)) ";
	}

	if ($promo_price_percent)
	{
		if ($promo_price_percent)
		{
			$set_statements[] = " promo_price = unit_price * (1+($promo_price_percent/100)) ";			
		}
		else
		{
			$set_statements[] = " promo_price = promo_price * (1+($promo_price_percent/100)) ";
		}
	}
	
	
	$set_statements[] = ' last_modified = "'.date('Y-m-d H:i:s').'" ';
	
	$set = implode(',',$set_statements);	
	$in = implode(',',$item_ids);
	$query = "UPDATE $items_table SET $set WHERE item_id IN ($in)";
	return $CI->db->simple_query($query);
}
?>