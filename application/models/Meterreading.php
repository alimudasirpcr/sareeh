<?php
class Meterreading extends MY_Model
{
	function __construct()
	{
		parent::__construct('config');	
	}
	
	/*
	Determines if a given reading_id is an meterreading
	*/
	function exists( $reading_id )
	{
		$this->db->from('meterreading');
		$this->db->where('reading_id',$reading_id);
		$this->db->where('deleted',0);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	function is_inactive($reading_id)
	{
		$info = $this->get_info($reading_id);
		
		return $info->inactive;
	}
	/*
	Returns all the meterreading
	*/
	function get_all($deleted=0,$limit=10000,$offset=0,$col='reading_id',$order='asc')
	{
		if (!$deleted)
		{
			$deleted = 0;
		}
		$this->db->select('meterreading.*,people.* ,meters.meter_number ');
		$this->db->from('meterreading');
		$this->db->join('people','people.person_id = meterreading.customer_id', 'left');
        $this->db->join('customers','people.person_id = customers.person_id', 'left');
		$this->db->join('meters','meters.meter_id = meterreading.meter_id', 'left');
		$this->db->where('meterreading.deleted',$deleted);
		
		if (!$this->config->item('speed_up_search_queries'))
		{
			$this->db->order_by($col, $order);
		}
		
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
	function search_single($term)
	{
	
		$this->db->save_queries = true;
		$deleted = 0;
		
		$this->db->select('meterreading.*,people.* ,meters.meter_number ');
		$this->db->from('meterreading');
		$this->db->join('people','people.person_id = meterreading.customer_id', 'left');
        $this->db->join('customers','people.person_id = customers.person_id', 'left');
		$this->db->join('meters','meters.meter_id = meterreading.meter_id', 'left');
		$this->db->where('meterreading.deleted',$deleted);
		$this->db->where('meters.meter_number' , $term  );
		$this->db->order_by('meterreading.reading_id', 'desc');
	
		
		$this->db->limit(2);
		$re = $this->db->get();
		if($re!=false){
			$res = $re->result_array();
			$resd['current'] = $res[0];
			
			$resd['current']['over_due'] = 0;
			$resd['current']['fine_delay'] = 0;
			$resd['current']['total'] = 0;
		 	$ext = 	get_query_data('SELECT 
						meter_id,
						SUM(reading_value * rate ) AS overdue_amount,
						SUM(reading_value * rate + 5) AS overdue_amount_with_fine,
						SUM(5) AS fine,
						SUM(extra_money) AS extra_money,
						SUM(reading_value * rate + 5  + extra_money) AS overdue_amount_full
					FROM 
						phppos_meterreading
					WHERE 
						paid != "paid"
						AND reading_date < (SELECT MAX(reading_date) FROM phppos_meterreading AS latest WHERE latest.meter_id = phppos_meterreading.meter_id)
						AND inactive = 0 
						AND deleted = 0
						AND meter_id = '.$res[0]['meter_id'].'
			');
			$resd['current']['over_due'] = $ext[0]->overdue_amount;
			$resd['current']['fine_delay'] = $ext[0]->fine;
			$resd['current']['extra_money'] = $ext[0]->extra_money;
			$resd['current']['total'] = ($res[0]['reading_value'] * $res[0]['rate']) + $ext[0]->overdue_amount_full;
			if(isset($res[1])){
				$resd['previous'] = $res[1];
			}
		}else{
			$resd = false;
		}
		return $resd;
	}

	function get_customer_meterreading($customer_id)
	{

		$this->db->from('meterreading');
		$this->db->where('customer_id',$customer_id);
		$this->db->where('deleted',0);
		$this->db->where('inactive',0);
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
		
		$this->db->from('meterreading');
		$this->db->where('deleted',$deleted);
		$query = $this->db->get();
		if($query!=false && $query->num_rows() > 0 )
		{
			return $query->num_rows();
		}
		
	}

	/*
	Gets information about a particular meterreading
	*/
	function get_info($reading_id)
	{
		
	
		$this->db->from('meterreading');
		$this->db->where('reading_id',$reading_id);
		$this->db->join('meters','meters.meter_id = meterreading.meter_id', 'left');
		$query = $this->db->get();

		if($query!=false && $query->num_rows()> 0)
		{
			
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $reading_id is NOT an meterreading
			$meterreading_obj=new stdClass();

			//Get all the fields from meterreading table
			$fields = array('reading_id','reading_value','description','reading_date','customer_id','inactive' , 'meter_number','deleted');

			foreach ($fields as $field)
			{
				$meterreading_obj->$field='';
			}

			return $meterreading_obj;
		}
	}

	/*
	Get an meterreading id given an meterreading number
	*/
	function get_reading_id($reading_id,$deleted=false)
	{
		$this->db->from('meterreading');
		$this->db->where('reading_id',$reading_id);
		if(!$deleted)
		{
			$this->db->where('deleted',0);
		}
		
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row()->reading_id;
		}

		return false;
	}

	/*
	Gets information about multiple meterreading
	*/
	function get_multiple_info($reading_ids)
	{
		$this->db->from('meterreading');
		$this->db->where_in('reading_id',$reading_ids);
		$this->db->where('deleted',0);
		$this->db->order_by("reading_id", "asc");
		return $this->db->get();
	}
	function get_customer_meters($customer_id)
	{
		$this->db->from('meters');
		$this->db->where('customer_id',$customer_id);
		$this->db->where('deleted',0);
		$this->db->where('inactive',0);
		$this->db->limit(1);

		$query =  $this->db->get();
		return $query->result()[0];
	}
	/*
	Inserts or updates a meterreading
	*/
	function save(&$meterreading_data,$reading_id=false)
	{
		
		
		if (!$reading_id or !$this->exists($reading_id))
		{
			if($this->db->insert('meterreading',$meterreading_data))
			{
				$meterreading_data['reading_id']=$this->db->insert_id();
				return true;
			}
			return false;
		}

		$this->db->where('reading_id', $reading_id);
		return $this->db->update('meterreading',$meterreading_data);
	}

	/*
	Updates multiple meterreading at once
	*/
	function update_multiple($meterreading_data,$reading_ids)
	{
		$this->db->where_in('reading_id',$reading_ids);
		return $this->db->update('meterreading',$meterreading_data);
	}

	/*
	Deletes one meterreading
	*/
	function delete($reading_id)
	{
		$this->db->where('reading_id', $reading_id);
		return $this->db->update('meterreading', array('deleted' => 1));
	}
	
	/*
	Deletes a list of meterreading
	*/
	function delete_list($reading_ids)
	{
		$this->db->where_in('reading_id',$reading_ids);
		return $this->db->update('meterreading', array('deleted' => 1));
 	}
	
	/*
	undeletes one meterreading
	*/
	function undelete($reading_id)
	{
		$this->db->where('reading_id', $reading_id);
		return $this->db->update('meterreading', array('deleted' => 0));
	}
	
	/*
	undeletes a list of meterreading
	*/
	function undelete_list($reading_ids)
	{
		$this->db->where_in('reading_id',$reading_ids);
		return $this->db->update('meterreading', array('deleted' => 0));
 	}

	/*
	Get search suggestions to find meterreading
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
		
			$this->db->from('meterreading');
			$this->db->group_start();
			$this->db->like('reading_id', $search,'after');
			$this->db->or_like('description', $search,'after');
			$this->db->group_end();
			$this->db->where('deleted',$deleted);
			$this->db->limit($limit);
			$by_number = $this->db->get();
		
			$temp_suggestions = array();
			foreach($by_number->result() as $row)
			{
				$data = array(
						'name' => H($row->reading_id),
						'email' => $row->reading_value,
						'avatar' => base_url()."assets/img/meterreading.png" 
						);

				$temp_suggestions[$row->reading_id] = $data;
			}
		
			$this->load->helper('array');
			uasort($temp_suggestions, 'sort_assoc_array_by_name');

			foreach($temp_suggestions as $key => $value)
			{
				$suggestions[]=array('value'=> $key, 'label' => $value['name'],'avatar'=>$value['avatar'],'subtitle'=>$value['email']);
			}
		
			$this->db->from('meterreading');
			$this->db->join('people','meterreading.customer_id=people.person_id');	
		
			$this->db->where("(first_name LIKE '".$this->db->escape_like_str($search)."%' or 
			last_name LIKE '".$this->db->escape_like_str($search)."%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '".$this->db->escape_like_str($search)."%') and ".$this->db->dbprefix('meterreading').".deleted=$deleted");
		
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

				$temp_suggestions[$row->reading_id] = $data;
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

	function get_customer_search_suggestions($search,$deleted = 0,$limit=25)
	{
		$this->db->save_queries = TRUE;
		if (!trim($search))
		{
			return array();
		}
		
		if (!$deleted)
		{
			$deleted = 0;
		}
		
		
		$suggestions = array();
		
			$current_location = $this->Employee->get_logged_in_employee_current_location_id();
			
			$this->db->from('customers');
			$this->db->join('people','customers.person_id=people.person_id');	
			$this->db->join('meters','meters.customer_id=customers.id' , 'inner');
		
			$this->db->where("(first_name LIKE '".($this->config->item('customer_allow_partial_match') ? '%' : '').$this->db->escape_like_str($search)."%' or 
			meters.meter_number LIKE '".($this->config->item('customer_allow_partial_match') ? '%' : '').$this->db->escape_like_str($search)."%' or 
			
			last_name LIKE '".($this->config->item('customer_allow_partial_match') ? '%' : '').$this->db->escape_like_str($search)."%' or 
			full_name LIKE '".($this->config->item('customer_allow_partial_match') ? '%' : '').$this->db->escape_like_str($search)."%') and customers.deleted=$deleted and (location_id IS NULL or location_id = $current_location)");			
		
			$this->db->limit($limit);	
			$by_name = $this->db->get();
			
			
			$temp_suggestions = array();
		
			foreach($by_name->result() as $row)
			{
				// Remove Person ID from Search Suggestion
				if($row->account_number)
				{
					$name_label = $row->first_name.' '.$row->last_name.' ('.$row->account_number.')';
				}
				else
				{
					$name_label = $row->first_name.' '.$row->last_name;
				}
				
				// if ($row->phone_number)
				// {
				// 	$name_label.=' ('.format_phone_number($row->phone_number).')';
				// }
				if ($row->meter_number)
				{
					$name_label.=' ('.lang('meter_number').":".$row->meter_number.')';
				}
				
				$data = array(
					'name' => $name_label,
					'email' => $row->email,
					'avatar' => $row->image_id ?  cacheable_app_file_url($row->image_id) : base_url()."assets/img/user.png" 
					 );
				$temp_suggestions[$row->id] = $data;
			}
		
			$this->load->helper('array');
			uasort($temp_suggestions, 'sort_assoc_array_by_name');
			
			foreach($temp_suggestions as $key => $value)
			{
				$suggestions[]=array('value'=> $key, 'label' => $value['name'],'avatar'=>$value['avatar'],'subtitle'=>$value['email']);		
			}
		
		
		
		
		//Cleanup blank entries
		for($k=count($suggestions)-1;$k>=0;$k--)
		{
			if (!$suggestions[$k]['label'])
			{
				unset($suggestions[$k]);
			}
		}
		
		//Probably not needed; but doesn't hurt
		$suggestions = array_values($suggestions);
		
		
		//only return $limit suggestions
		$suggestions = array_map("unserialize", array_unique(array_map("serialize", $suggestions)));
		if(count($suggestions) > $limit)
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}

	function get_custom_field($number,$key="name")
	{
		static $config_data;
		
		if (!$config_data)
		{
			$config_data = $this->config->item('customer_custom_field_prefs') ? unserialize($this->config->item('customer_custom_field_prefs')) : array();
		}
		
		return isset($config_data["custom_field_${number}_${key}"]) && $config_data["custom_field_${number}_${key}"] ? $config_data["custom_field_${number}_${key}"] : FALSE;
	}

	/*
	Preform a search on meterreading
	*/
	function search($search, $deleted = 0,$limit=20,$offset=0,$column="reading_id",$orderby='asc')
	{
		if (!$deleted)
		{
			$deleted = 0;
		}
	 //The queries are done as 2 unions to speed up searches to use indexes.
	 //When doing OR WHERE across 2 tables; performance is not good
    $this->db->select('meterreading.*,people.*,customers.account_number as account_number');
		$this->db->from('meterreading');
		$this->db->join('people','meterreading.customer_id=people.person_id', 'left');	
		$this->db->join('customers','people.person_id = customers.person_id', 'left');
		
		if ($search)
		{
				$this->db->where("(first_name LIKE '".$this->db->escape_like_str($search)."%' or 
				last_name LIKE '".$this->db->escape_like_str($search)."%' or 
				email LIKE '".$this->db->escape_like_str($search)."%' or 
				phone_number LIKE '".$this->db->escape_like_str($search)."%' or 
				description LIKE '".$this->db->escape_like_str($search)."%' or 
				reading_value LIKE '".$this->db->escape_like_str($search)."%' or 
				reading_id  LIKE '".$this->db->escape_like_str($search)."%' or 
				meter_id  LIKE '".$this->db->escape_like_str($search)."%' or 
				full_name LIKE '".$this->db->escape_like_str($search)."%') and meterreading.deleted=$deleted");		
		}
		else
		{
			$this->db->where('meterreading.deleted',$deleted);
		}	
					
		$people_search = $this->db->get_compiled_select();

    $this->db->select('meterreading.*,people.*,customers.account_number as account_number');
 		$this->db->from('meterreading');
 		$this->db->join('people','meterreading.customer_id=people.person_id', 'left');	
 		$this->db->join('customers','people.person_id = customers.person_id', 'left');
		
		if ($search)
		{
				$this->db->where("(reading_id LIKE '".$this->db->escape_like_str($search)."%' or 
				description LIKE '".$this->db->escape_like_str($search)."%') and meterreading.deleted=$deleted");		
		}
		else
		{
			$this->db->where('meterreading.deleted',$deleted);
		}	
		
		$meterreading_search = $this->db->get_compiled_select();
		
		$order_by = '';
		if (!$this->config->item('speed_up_search_queries'))
		{
			$order_by = " ORDER BY $column $orderby ";
		}			
		
		return $this->db->query($people_search." UNION ".$meterreading_search." $order_by LIMIT $limit OFFSET $offset");	
	}
	
	function search_count_all($search, $deleted=0,$limit=10000)
	{
		
		if (!$deleted)
		{
			$deleted = 0;
		}
 	 //The queries are done as 2 unions to speed up searches to use indexes.
 	 //When doing OR WHERE across 2 tables; performance is not good
     $this->db->select('meterreading.*,people.*,customers.account_number as account_number');
 		$this->db->from('meterreading');
 		$this->db->join('people','meterreading.customer_id=people.person_id', 'left');	
 		$this->db->join('customers','people.person_id = customers.person_id', 'left');
		
 		if ($search)
 		{
 				$this->db->where("(first_name LIKE '".$this->db->escape_like_str($search)."%' or 
 				last_name LIKE '".$this->db->escape_like_str($search)."%' or 
 				email LIKE '".$this->db->escape_like_str($search)."%' or 
				 phone_number LIKE '".$this->db->escape_like_str($search)."%' or 
				 description LIKE '".$this->db->escape_like_str($search)."%' or 
				 reading_value LIKE '".$this->db->escape_like_str($search)."%' or 
				 reading_id  LIKE '".$this->db->escape_like_str($search)."%' or 
				 meter_id  LIKE '".$this->db->escape_like_str($search)."%' or 
 				full_name LIKE '".$this->db->escape_like_str($search)."%') and meterreading.deleted=$deleted");		
 		}
 		else
 		{
 			$this->db->where('meterreading.deleted',$deleted);
 		}	
					
 		$people_search = $this->db->get_compiled_select();

     $this->db->select('meterreading.*,people.*,customers.account_number as account_number');
  		$this->db->from('meterreading');
  		$this->db->join('people','meterreading.customer_id=people.person_id', 'left');	
  		$this->db->join('customers','people.person_id = customers.person_id', 'left');
		
 		if ($search)
 		{
 				$this->db->where("(reading_id LIKE '".$this->db->escape_like_str($search)."%' or 
 				description LIKE '".$this->db->escape_like_str($search)."%') and meterreading.deleted=$deleted");		
 		}
 		else
 		{
 			$this->db->where('meterreading.deleted',$deleted);
 		}	
		
 		$meterreading_search = $this->db->get_compiled_select();
		
 		$result = $this->db->query($people_search." UNION ".$meterreading_search);	
		return $result->num_rows();
	}
	
	public function get_meterreading_value( $reading_id )
	{
		if ( !$this->exists( $this->get_reading_id($reading_id)))
			return 0;
		
		$this->db->from('meterreading');
		$this->db->where('reading_id',$reading_id);
		return $this->db->get()->row()->value;
	}
	
	function add_meterreading_balance($reading_id,$add_value)
	{
	  $this->db->set('reading_value','reading_value+'.$add_value,false);
		$this->db->where('reading_id', $reading_id);
		$this->db->update('meterreading');
	}
	
	function update_meterreading_value( $reading_id, $value )
	{
		$this->db->where('reading_id', $reading_id);
		$this->db->update('meterreading', array('reading_value' => $value));
	}
	
	function update_meterreading_customer( $reading_id, $customer_id )
	{
		$this->db->where('reading_id', $reading_id);
		$this->db->update('meterreading', array('customer_id' => $customer_id));
	}
	
	
	function log_modification($data)
	{		
		$transaction_amount = floatval($data['new_value']) - floatval($data['old_value']);
				
		$this->db->from('meterreading');
		$this->db->where('reading_id',$data['number']);
		$row = $this->db->get()->row_array();
		
		 if($data['type'] == "update")
		{
			$log_message = $data['person']." ". $data['keyword']." ".to_currency($transaction_amount)." ".lang('meterreading_to_meterreading_with_value_of')." ".to_currency($data['new_value']);
		}
		elseif ($data['type'] == 'create')
		{
			$transaction_amount = $data['new_value'];
			
			$sale_id_message = '';
			
			
			$log_message = $sale_id_message.$data['person']." ".lang('meterreading_created_meterreading_with_value')." ".to_currency($transaction_amount);
		}
		if ($row['reading_id'])
		{
			$this->db->insert('meterreading_log',array("reading_id" => $row['reading_id'], "log_message" => $log_message, "transaction_amount" => $transaction_amount, 'log_date' => date('Y-m-d H:i:s')));
	
		}
	}
	
	function get_meterreading_log($reading_id)
	{
		$this->db->from('meterreading_log');
		$this->db->where('reading_id', $reading_id);
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
		$meterreading_data = array('reading_id' => null);
		$this->db->where('deleted', 1);
		$this->db->update('meterreading',$meterreading_data);
		
		
		$meterreading_data = array('reading_id' => null, 'deleted' => 1);
		$this->db->where('value', 0);
		return $this->db->update('meterreading',$meterreading_data);
	}
	
	function is_integrated($reading_id)
	{
		$this->db->from('meterreading');
		$this->db->where('reading_id',$reading_id);
		$this->db->where('deleted',0);
		$query = $this->db->get();

		return ($query->num_rows()==1);
		
	}
}
?>
