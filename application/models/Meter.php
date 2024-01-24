<?php
class Meter extends MY_Model
{
	function __construct()
	{
		parent::__construct('config');	
	}
	
	/*
	Determines if a given meter_id is an meter
	*/
	function exists( $meter_id )
	{
		$this->db->from('meters');
		$this->db->where('meter_id',$meter_id);
		$this->db->where('deleted',0);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	function is_inactive($meter_id)
	{
		$info = $this->get_info($meter_id);
		
		return $info->inactive;
	}
	/*
	Returns all the meters
	*/
	function get_all($deleted=0,$limit=10000,$offset=0,$col='meter_number',$order='asc')
	{
		if (!$deleted)
		{
			$deleted = 0;
		}
		$this->db->select('meters.*,people.*,customers.account_number as account_number');
		$this->db->from('meters');
		$this->db->join('people','people.person_id = meters.customer_id', 'left');
        $this->db->join('customers','people.person_id = customers.person_id', 'left');

		$this->db->where('meters.deleted',$deleted);
		
		if (!$this->config->item('speed_up_search_queries'))
		{
			$this->db->order_by($col, $order);
		}
		
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}

	function get_customer_meters($customer_id)
	{
		$this->db->from('meters');
		$this->db->where('customer_id',$customer_id);
		$this->db->where('deleted',0);
		$this->db->where('inactive',0);
		$this->db->where('integrated_gift_card',0);
		
		if (!$this->config->item('show_meters_even_if_0_balance'))
		{
			$this->db->where('value > ',0);			
		}
		$this->db->order_by('value', 'desc');
		$this->db->limit(20);

		$query =  $this->db->get();
		return $query->result();
	}
	
	function count_all($deleted = 0)
	{
		if (!$deleted)
		{
			$deleted = 0;
		}
		
		$this->db->from('meters');
		$this->db->where('deleted',$deleted);
		$query = $this->db->get();
		if($query!=false && $query->num_rows() > 0 )
		{
			return $query->num_rows();
		}
		
	}

	/*
	Gets information about a particular meter
	*/
	function get_info($meter_id)
	{
		$this->db->from('meters');
		$this->db->where('meter_id',$meter_id);
		
		$query = $this->db->get();

		if($query!=false && $query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $meter_id is NOT an meter
			$meter_obj=new stdClass();

			//Get all the fields from meters table
			$fields = array('meter_id','meter_number','description','value','customer_id','inactive','deleted','integrated_gift_card','integrated_auth_code');

			foreach ($fields as $field)
			{
				$meter_obj->$field='';
			}

			return $meter_obj;
		}
	}

	/*
	Get an meter id given an meter number
	*/
	function get_meter_id($meter_number,$deleted=false)
	{
		$this->db->from('meters');
		$this->db->where('meter_number',$meter_number);
		if(!$deleted)
		{
			$this->db->where('deleted',0);
		}
		
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row()->meter_id;
		}

		return false;
	}

	/*
	Gets information about multiple meters
	*/
	function get_multiple_info($meter_ids)
	{
		$this->db->from('meters');
		$this->db->where_in('meter_id',$meter_ids);
		$this->db->where('deleted',0);
		$this->db->order_by("meter_number", "asc");
		return $this->db->get();
	}

	/*
	Inserts or updates a meter
	*/
	function save(&$meter_data,$meter_id=false)
	{
		if (!$meter_id or !$this->exists($meter_id))
		{
			if($this->db->insert('meters',$meter_data))
			{
				$meter_data['meter_id']=$this->db->insert_id();
				return true;
			}
			return false;
		}

		$this->db->where('meter_id', $meter_id);
		return $this->db->update('meters',$meter_data);
	}

	/*
	Updates multiple meters at once
	*/
	function update_multiple($meter_data,$meter_ids)
	{
		$this->db->where_in('meter_id',$meter_ids);
		return $this->db->update('meters',$meter_data);
	}

	/*
	Deletes one meter
	*/
	function delete($meter_id)
	{
		$this->db->where('meter_id', $meter_id);
		return $this->db->update('meters', array('deleted' => 1));
	}
	
	/*
	Deletes a list of meters
	*/
	function delete_list($meter_ids)
	{
		$this->db->where_in('meter_id',$meter_ids);
		return $this->db->update('meters', array('deleted' => 1));
 	}
	
	/*
	undeletes one meter
	*/
	function undelete($meter_id)
	{
		$this->db->where('meter_id', $meter_id);
		return $this->db->update('meters', array('deleted' => 0));
	}
	
	/*
	undeletes a list of meters
	*/
	function undelete_list($meter_ids)
	{
		$this->db->where_in('meter_id',$meter_ids);
		return $this->db->update('meters', array('deleted' => 0));
 	}

	/*
	Get search suggestions to find meters
	*/
	function get_search_suggestions($search,$deleted = 0,$limit=25)
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
		
			$this->db->from('meters');
			$this->db->group_start();
			$this->db->like('meter_number', $search,'after');
			$this->db->or_like('description', $search,'after');
			$this->db->group_end();
			$this->db->where('deleted',$deleted);
			$this->db->limit($limit);
			$by_number = $this->db->get();
		
			$temp_suggestions = array();
			foreach($by_number->result() as $row)
			{
				$data = array(
						'name' => H($row->meter_number),
						'email' => to_currency(H($row->value)),
						'avatar' => base_url()."assets/img/meter.png" 
						);

				$temp_suggestions[$row->meter_id] = $data;
			}
		
			$this->load->helper('array');
			uasort($temp_suggestions, 'sort_assoc_array_by_name');

			foreach($temp_suggestions as $key => $value)
			{
				$suggestions[]=array('value'=> $key, 'label' => $value['name'],'avatar'=>$value['avatar'],'subtitle'=>$value['email']);
			}
		
			$this->db->from('meters');
			$this->db->join('people','meters.customer_id=people.person_id');	
		
			$this->db->where("(first_name LIKE '".$this->db->escape_like_str($search)."%' or 
			last_name LIKE '".$this->db->escape_like_str($search)."%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '".$this->db->escape_like_str($search)."%') and ".$this->db->dbprefix('meters').".deleted=$deleted");
		
			$this->db->limit($limit);
			$by_name = $this->db->get();
		
		
			$temp_suggestions = array();
			foreach($by_name->result() as $row)
			{
				$data = array(
						'name' => $row->first_name.' '.$row->last_name,
						'email' => $row->email,
						'avatar' => $row->image_id ?  cacheable_app_file_url($row->image_id) : base_url()."assets/img/user.png" 
						);

				$temp_suggestions[$row->meter_id] = $data;
			}
		
			uasort($temp_suggestions, 'sort_assoc_array_by_name');

			foreach($temp_suggestions as $key => $value)
			{
				$suggestions[]=array('value'=> $key, 'label' => $value['name'],'avatar'=>$value['avatar'],'subtitle'=>$value['email']);
			}
			
			//only return $limit suggestions
		$suggestions = array_map("unserialize", array_unique(array_map("serialize", $suggestions)));
		if(count($suggestions) > $limit)
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	}

	/*
	Preform a search on meters
	*/
	function search($search, $deleted = 0,$limit=20,$offset=0,$column="meter_number",$orderby='asc')
	{
		if (!$deleted)
		{
			$deleted = 0;
		}
	 //The queries are done as 2 unions to speed up searches to use indexes.
	 //When doing OR WHERE across 2 tables; performance is not good
    $this->db->select('meters.*,people.*,customers.account_number as account_number');
		$this->db->from('meters');
		$this->db->join('people','meters.customer_id=people.person_id', 'left');	
		$this->db->join('customers','people.person_id = customers.person_id', 'left');
		
		if ($search)
		{
				$this->db->where("(first_name LIKE '".$this->db->escape_like_str($search)."%' or 
				last_name LIKE '".$this->db->escape_like_str($search)."%' or 
				email LIKE '".$this->db->escape_like_str($search)."%' or 
				phone_number LIKE '".$this->db->escape_like_str($search)."%' or 
				full_name LIKE '".$this->db->escape_like_str($search)."%') and meters.deleted=$deleted");		
		}
		else
		{
			$this->db->where('meters.deleted',$deleted);
		}	
					
		$people_search = $this->db->get_compiled_select();

    $this->db->select('meters.*,people.*,customers.account_number as account_number');
 		$this->db->from('meters');
 		$this->db->join('people','meters.customer_id=people.person_id', 'left');	
 		$this->db->join('customers','people.person_id = customers.person_id', 'left');
		
		if ($search)
		{
				$this->db->where("(meter_number LIKE '".$this->db->escape_like_str($search)."%' or 
				description LIKE '".$this->db->escape_like_str($search)."%') and meters.deleted=$deleted");		
		}
		else
		{
			$this->db->where('gifcards.deleted',$deleted);
		}	
		
		$meter_search = $this->db->get_compiled_select();
		
		$order_by = '';
		if (!$this->config->item('speed_up_search_queries'))
		{
			$order_by = " ORDER BY $column $orderby ";
		}			
		
		return $this->db->query($people_search." UNION ".$meter_search." $order_by LIMIT $limit OFFSET $offset");	
	}
	
	function search_count_all($search, $deleted=0,$limit=10000)
	{
		
		if (!$deleted)
		{
			$deleted = 0;
		}
 	 //The queries are done as 2 unions to speed up searches to use indexes.
 	 //When doing OR WHERE across 2 tables; performance is not good
     $this->db->select('meters.*,people.*,customers.account_number as account_number');
 		$this->db->from('meters');
 		$this->db->join('people','meters.customer_id=people.person_id', 'left');	
 		$this->db->join('customers','people.person_id = customers.person_id', 'left');
		
 		if ($search)
 		{
 				$this->db->where("(first_name LIKE '".$this->db->escape_like_str($search)."%' or 
 				last_name LIKE '".$this->db->escape_like_str($search)."%' or 
 				email LIKE '".$this->db->escape_like_str($search)."%' or 
 				phone_number LIKE '".$this->db->escape_like_str($search)."%' or 
 				full_name LIKE '".$this->db->escape_like_str($search)."%') and meters.deleted=$deleted");		
 		}
 		else
 		{
 			$this->db->where('meters.deleted',$deleted);
 		}	
					
 		$people_search = $this->db->get_compiled_select();

     $this->db->select('meters.*,people.*,customers.account_number as account_number');
  		$this->db->from('meters');
  		$this->db->join('people','meters.customer_id=people.person_id', 'left');	
  		$this->db->join('customers','people.person_id = customers.person_id', 'left');
		
 		if ($search)
 		{
 				$this->db->where("(meter_number LIKE '".$this->db->escape_like_str($search)."%' or 
 				description LIKE '".$this->db->escape_like_str($search)."%') and meters.deleted=$deleted");		
 		}
 		else
 		{
 			$this->db->where('meters.deleted',$deleted);
 		}	
		
 		$meter_search = $this->db->get_compiled_select();
		
 		$result = $this->db->query($people_search." UNION ".$meter_search);	
		return $result->num_rows();
	}
	
	public function get_meter_value( $meter_number )
	{
		if ( !$this->exists( $this->get_meter_id($meter_number)))
			return 0;
		
		$this->db->from('meters');
		$this->db->where('meter_number',$meter_number);
		return $this->db->get()->row()->value;
	}
	
	function add_meter_balance($meter_number,$add_value)
	{
	  $this->db->set('value','value+'.$add_value,false);
		$this->db->where('meter_number', $meter_number);
		$this->db->update('meters');
	}
	
	function update_meter_value( $meter_number, $value )
	{
		$this->db->where('meter_number', $meter_number);
		$this->db->update('meters', array('value' => $value));
	}
	
	function update_meter_customer( $meter_number, $customer_id )
	{
		$this->db->where('meter_number', $meter_number);
		$this->db->update('meters', array('customer_id' => $customer_id));
	}
	
	
	function log_modification($data)
	{		
		$transaction_amount = floatval($data['new_value']) - floatval($data['old_value']);
				
		$this->db->from('meters');
		$this->db->where('meter_number',$data['number']);
		$row = $this->db->get()->row_array();
		
		if($data['type'] == "sale")
		{
			$spent = to_currency($transaction_amount);
			$new_value = to_currency($row['value']);
			$log_message = lang('common_sale_id'). ': '.$this->config->item('sale_prefix'). ' '.$data['sale_id'].' '.$data['person'].' '.lang('meters_spent').' '.$spent. " ".lang('meters_with_a_new_value_of')." ". $new_value;
		}
		elseif($data['type'] == 'sale_delete')
		{
			$spent = to_currency($transaction_amount);
			$new_value = to_currency($row['value']);
			$log_message = lang('common_sale_id'). ': '.$this->config->item('sale_prefix'). ' '.$data['sale_id'].' '.lang('sales_deleted_voided').' '.lang('meters_added').' '.$spent. " ".lang('meters_with_a_new_value_of')." ". $new_value;
		}
		elseif($data['type'] == 'sale_undelete')
		{
			$spent = to_currency($transaction_amount);
			$new_value = to_currency($row['value']);
			$log_message = lang('common_sale_id'). ': '.$this->config->item('sale_prefix'). ' '.$data['sale_id'].' '.lang('sales_undeleted_voided').' '.lang('meters_removed').' '.$spent. " ".lang('meters_with_a_new_value_of')." ". $new_value;
		}
		else if($data['type'] == "update")
		{
			$log_message = $data['person']." ". $data['keyword']." ".to_currency($transaction_amount)." ".lang('meters_to_meter_with_value_of')." ".to_currency($data['new_value']);
		}
		elseif ($data['type'] == 'create')
		{
			$transaction_amount = $data['new_value'];
			
			$sale_id_message = '';
			if (isset($data['sale_id']))
			{
				$sale_id_message = lang('common_sale_id'). ': '.anchor('sales/receipt/'.$data['sale_id'], $this->config->item('sale_prefix'). ' '.$data['sale_id'], array('target' => '_blank')).' ';
			}
			
			$log_message = $sale_id_message.$data['person']." ".lang('meters_created_meter_with_value')." ".to_currency($transaction_amount);
		}
		if ($row['meter_id'])
		{
			$this->db->insert('meters_log',array("meter_id" => $row['meter_id'], "log_message" => $log_message, "transaction_amount" => $transaction_amount, 'log_date' => date('Y-m-d H:i:s')));
	
		}
	}
	
	function get_meter_log($meter_id)
	{
		$this->db->from('meters_log');
		$this->db->where('meter_id', $meter_id);
		$this->db->order_by("id", "desc");
		 $query = $this->db->get();
		 if( $query!=false && $query->num_rows() > 0){
			return $query->result();
		 }else{
			return false;
		 }
		
	}
	
	function cleanup()
	{
		$meter_data = array('meter_number' => null);
		$this->db->where('deleted', 1);
		$this->db->update('meters',$meter_data);
		
		
		$meter_data = array('meter_number' => null, 'deleted' => 1);
		$this->db->where('value', 0);
		return $this->db->update('meters',$meter_data);
	}
	
	function is_integrated($meter_id)
	{
		$this->db->from('meters');
		$this->db->where('meter_id',$meter_id);
		$this->db->where('deleted',0);
		$this->db->where('integrated_gift_card',1);
		$query = $this->db->get();

		return ($query->num_rows()==1);
		
	}
}
?>
