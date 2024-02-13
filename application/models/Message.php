<?php
class Message extends MY_Model
{

	function save_message($data)
	{
		$message_data = array(
		'message'=>$data['message'],
		'created_at' => date('Y-m-d H:i:s'),
		'sender_id'=>$this->Employee->get_logged_in_employee_info()->person_id,
		);

			if($this->db->insert('messages', $message_data))
			{
				$message_id = $this->db->insert_id();


				if($data['all_employees']=="all")
				{
					
					if($data["all_locations"]=="all")
					{
						$employee_ids = array();

						foreach ($this->Location->get_all()->result() as $location)
						{
							$location_ids[] = $location->location_id;
						}

						$employee_ids = $this->Employee->get_multiple_locations_employees($location_ids)->result_array();

					}
					else
					{
						$employee_ids = $this->Employee->get_multiple_locations_employees($data['locations'])->result_array();

					}

					//Prepare the employees ids format 
					$person_ids = array();
					foreach ($employee_ids as $value) {

						if ($this->Employee->get_logged_in_employee_info()->person_id != $value['employee_id'])
						{
							$message_receiver = array(
								'message_id'=>$message_id,
								'receiver_id'=>$value['employee_id'],
							);	
						
							$this->db->insert('message_receiver',$message_receiver);		
						}

					}

					return true;

				}
				else
				{
					if(empty($data["employees"]))
					{
						return false;
					}
					foreach ($data["employees"] as $employee_id) {
						
						if ($this->Employee->get_logged_in_employee_info()->person_id != $employee_id)
						{
						
								$message_receiver = array(
									'message_id'=>$message_id,
									'receiver_id'=>$employee_id,
								);	
								
							$this->db->insert('message_receiver',$message_receiver);	
						}
					}

					return true;
				}

				return false;

				
			}
		
		
	}

	function get_messages($limit=20, $offset=0)
	{

		$logged_employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

		$this->db->from('messages');
		$this->db->join('message_receiver','messages.id=message_receiver.message_id');	
		$this->db->where('receiver_id',$logged_employee_id);		
		$this->db->where('messages.deleted',0);		
		$this->db->order_by("created_at", "desc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		$query=$this->db->get();

		return $query->result_array();
	}


	function get_info($message_id)
	{

		$this->db->from('messages');
		$this->db->where('messages.deleted',0);		
		$this->db->where('messages.id',$message_id);		
		$query=$this->db->get();
		$this->read_message($message_id);

		return $query->result_array();
	}



	function get_messages_count()
	{
		$logged_employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		
		$this->db->from('messages');
		$this->db->join('message_receiver','messages.id=message_receiver.message_id');	
		$this->db->where('receiver_id',$logged_employee_id);		
		$this->db->where('messages.deleted',0);
		
		$query = $this->db->get();
		
		
		if ($query != false && $query->num_rows() > 0) {
			return $query->num_rows(); // Count the number of rows returned by the query
		}else{
			return false;
		}
	}


	
	function get_sent_messages($limit=20, $offset=0)
	{

		$logged_employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		$this->db->select('messages.*, GROUP_CONCAT('.$this->db->dbprefix('people').'.first_name, " ",'.$this->db->dbprefix('people').'.last_name SEPARATOR ", ") as sent_to', false);
		$this->db->from('messages');
		$this->db->join('people', 'people.person_id = sender_id');
		$this->db->where('sender_id',$logged_employee_id);		
		$this->db->where('messages.deleted',0);		
		$this->db->order_by("created_at", "desc");
		$this->db->group_by('messages.id');
		$this->db->limit($limit);
		$this->db->offset($offset);
		
		$query=$this->db->get();
		return $query->result_array();
	}
	
	function get_sent_messages_count()
	{

		$logged_employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		$this->db->from('messages');
		$this->db->where('sender_id',$logged_employee_id);		
		$this->db->where('messages.deleted',0);		
		
		$query = $this->db->get();
		
		
		if ($query != false && $query->num_rows() > 0) {
			return $query->num_rows(); // Count the number of rows returned by the query
		}else{
			return false;
		}
	}

	function allUser(){
		$logged_employee_id = $this->Employee->get_logged_in_employee_info()->id;
		$this->db->from('employees');
		$this->db->where('id  !=' . $logged_employee_id);
		$this->db->where('deleted' , 0);
		return  $this->db->get()->result_array();
	}
	public function sentMessage($data){
		$this->db->insert('messages',$data);
	}
	public function getLastMessage($data){
		$session_id = $this->Employee->get_logged_in_employee_info()->id;
		$this->db->select('*');
		$where = "sender_id = '$session_id' AND receiver_id = '$data' OR 
		sender_id = '$data' AND receiver_id = '$session_id'";
		$this->db->where($where);
		$this->db->order_by('time', 'DESC');
		$result = $this->db->get('messages', 1)->result_array();
		return $result;
	}
	public function getmessage($data){
		$session_id = $this->Employee->get_logged_in_employee_info()->id;
		$this->db->select('*');
		$where = "sender_id = '$session_id' AND receiver_id = '$data' OR 
		sender_id = '$data' AND receiver_id = '$session_id'";
		$this->db->where($where);
		// $this->db->order_by('time', 'ASC');
		$result = $this->db->get('messages')->result_array();

		$this->db->update('messages' , ['seen' => 1]);
		$this->db->where($where);
		return $result;
	}

	function get_unread_messages_count($limit=20, $offset=0)
	{
		$logged_employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		$this->db->from('message_receiver');
		$this->db->join('messages','messages.id=message_receiver.message_id');	
		$this->db->where('receiver_id',$logged_employee_id);		
		$this->db->where('message_read',0);		
		$this->db->where('deleted',0);
		$this->db->limit($limit);
		$this->db->offset($offset);
		
		$query = $this->db->get();
		
		
		if ($query != false && $query->num_rows() > 0) {
			return $query->num_rows(); // Count the number of rows returned by the query
		}else{
			return false;
		}
	}	 

	function read_message($message_id)
	{
		$logged_employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		$this->db->where('receiver_id',$logged_employee_id);		
		$this->db->where('message_id', $message_id);
		return $this->db->update('message_receiver', array('message_read' => 1));		
	}
	function make_employee_active()
	{
		$logged_employee_id = $this->Employee->get_logged_in_employee_info()->id;
		$this->db->where('id',$logged_employee_id);		
	
		return $this->db->update('employees', array('is_active' => 1));		
	}
	function delete_message($message_id)
	{
		$this->db->where('id', $message_id);
		return $this->db->update('messages', array('deleted' => 1));		
	}
	
	function can_read_message($message_id,$sent_message = 0)
	{
		$logged_employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		
		if ($sent_message)
		{
			$this->db->from('messages');
			$this->db->where('id',$message_id);		
			$this->db->where('sender_id',$logged_employee_id);		
			$this->db->where('messages.deleted',0);
		}
		else
		{
			$this->db->from('messages');
			$this->db->join('message_receiver','messages.id=message_receiver.message_id');	
			$this->db->where('receiver_id',$logged_employee_id);		
			$this->db->where('message_id',$message_id);		
			$this->db->where('deleted',0);
		
		}
		$query = $this->db->get();
		
		return ($query->num_rows()>=1);	
	}
}
?>
