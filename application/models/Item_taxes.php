<?php
class Item_taxes extends MY_Model
{
	/*
	Gets tax info for a particular item
	*/
	function get_info($item_id)
	{
		$this->db->from('items_taxes');
		$this->db->where('item_id',$item_id);
		$this->db->order_by('cumulative');
		$this->db->order_by('id');
		//return an array of taxes for an item
		return $this->db->get()->result_array();
	}
	
	/*
	Inserts or updates an item's taxes
	*/
	function save(&$items_taxes_data, $item_id)
	{
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		$current_taxes = $this->get_info($item_id);
		
		//Delete and add
		if (count($current_taxes) != count($items_taxes_data))
		{
			$this->delete($item_id);
		
			foreach ($items_taxes_data as $row)
			{
				$row['item_id'] = $item_id;
				$this->db->insert('items_taxes',$row);		
			}
		}
		else //Update
		{
			for($k=0;$k<count($current_taxes);$k++)
			{
				$current_tax = $current_taxes[$k];
				$new_tax = $items_taxes_data[$k];
				
				$this->db->where('id', $current_tax['id']);
				$this->db->update('items_taxes', $new_tax);
			}
			
		}
		$this->db->trans_complete();
		return true;
	}
	
	function save_multiple(&$items_taxes_data, $item_ids,$select_inventory=false)
	{
		if($select_inventory)
		{
			$params = $this->session->userdata('items_search_data') ? $this->session->userdata('items_search_data') : array('offset' => 0, 'order_col' => 'item_id', 'order_dir' => 'asc', 'search' => FALSE, 'category_id' => FALSE, 'fields' => 'all');
			$result = $this->Item->search(isset($params['search']) ? $params['search'] : '',0,isset($params['category_id']) ? $params['category_id'] : '',$this->Item->count_all(),0,'name','asc', isset($params['fields']) ? $params['fields']: 'all');
		
			foreach($result->result() as $item)
			{
				$this->save($items_taxes_data, $item->item_id);
			}			
		}
		else
		{	
			foreach($item_ids as $item_id)
			{
				$this->save($items_taxes_data, $item_id);
			}
		}
	}
	/*
	Deletes taxes given an item
	*/
	function delete($item_id)
	{
		return $this->db->delete('items_taxes', array('item_id' => $item_id)); 
	}

	function get_info_by_name($tax_name){

	}
}
?>
