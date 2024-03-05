<?php
require_once ("Report.php");
class Item_kit_price_history extends Report
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Tier');
		
	}
	
	public function getInputData()
	{
		
		$input_params = array();
		
		$specific_entity_data['specific_input_name'] = 'item_kit_id';
		$specific_entity_data['specific_input_label'] = lang('item_kit');
		$specific_entity_data['search_suggestion_url'] = site_url('reports/item_kit_search');
		$specific_entity_data['view'] = 'specific_entity';		
		
		if ($this->settings['display'] == 'tabular')
		{
			$input_data = Report::get_common_report_input_data(TRUE);
			
			$input_params = array(
				array('view' => 'date_range', 'with_time' => TRUE),
				$specific_entity_data,
				array('view' => 'excel_export'),
				array('view' => 'locations'),
				array('view' => 'submit'),
			);
		}
				
		
		$input_data['input_report_title'] = lang('reports_report_options');
		$input_data['input_params'] = $input_params;
		return $input_data;
	}
	
	function getOutputData()
	{
		$location_count = $this->Location->count_all();
		
		$subtitle = date(get_date_format(), strtotime($this->params['start_date'])) .'-'.date(get_date_format(), strtotime($this->params['end_date']));

		$report_data = $this->getData();
		$summary_data = $this->getSummaryData();
		
		if ($this->settings['display'] == 'tabular')
		{				
			$this->setupDefaultPagination();
			$tabular_data = array();
			
			$index = 0;
			foreach($report_data as $row)
			{
				$data_row = array();
				$data_row[] = array('data'=>date(get_date_format().' '.get_time_format(), strtotime($row['on_date'])), 'align'=>'left');
				$data_row[] = array('data'=>$row['employee'], 'align'=>'left');
				$data_row[] = array('data'=>$row['item_kit_name'], 'align'=>'left');
				if ($location_count > 1)
				{
					$data_row[] = array('data'=>$row['location_name'], 'align'=>'left');
				}
				$data_row[] = array('data'=>to_currency($row['cost_price']), 'align'=>'right');
				$data_row[] = array('data'=>to_currency($row['unit_price']), 'align'=>'right');
			
				$tabular_data[] = $data_row;
			
				$index++;
			}
					
	 		$data = array(
				'view' => 'tabular',
				"title" => lang('reports_pricing_history'),
				"subtitle" => $subtitle,
				"headers" => $this->getDataColumns(),
				"data" => $tabular_data,
				"summary_data" => $summary_data,
				"export_excel" => $this->params['export_excel'],
				"pagination" => $this->pagination->create_links(),
			);
			
		}
		
		return $data;
	}
	
	public function getDataColumns()
	{
		$location_count = $this->Location->count_all();
		
		$columns = array();
		
		$columns[] = array('data'=>lang('date'), 'align'=> 'center');
		$columns[] = array('data'=>lang('employee'), 'align'=> 'center');
		$columns[] = array('data'=>lang('item_kit'), 'align'=> 'left');
		
		if ($location_count > 1)
		{
			$columns[] = array('data'=>lang('location'), 'align'=> 'left');
		}
		$columns[] = array('data'=>lang('cost_price'), 'align'=> 'left');
		$columns[] = array('data'=>lang('unit_price'), 'align'=> 'left');
		
		return $columns;		
	}
	
	public function getData()
	{		
		$location_ids = self::get_selected_location_ids();
		
		$this->db->select('employee_person.full_name as employee,locations.name as location_name,item_kits_pricing_history.*,item_kits.name as item_kit_name');
		$this->db->from('item_kits_pricing_history');
		$this->db->join('people as employee_person', 'item_kits_pricing_history.employee_id = employee_person.person_id', 'left');
		$this->db->join('locations', 'item_kits_pricing_history.location_id = locations.location_id','left');
		$this->db->join('item_kits','item_kits.item_kit_id=item_kits_pricing_history.item_kit_id');
		$this->db->group_start();
		$this->db->where_in('item_kits_pricing_history.location_id', $location_ids);
		$this->db->or_where('item_kits_pricing_history.location_id',NULL);
		$this->db->group_end();
		$this->db->where('on_date BETWEEN '.$this->db->escape($this->params['start_date']).' and '.$this->db->escape($this->params['end_date']));
		$this->db->order_by('on_date', ($this->config->item('report_sort_order')) ? $this->config->item('report_sort_order') : 'asc');
		if(isset($this->params['item_kit_id']) && $this->params['item_kit_id'])
		{
			$this->db->where('item_kits_pricing_history.item_kit_id',str_replace('KIT ','',$this->params['item_kit_id']));
		}
		if (isset($this->params['company']) && $this->params['company'] && $this->params['company'] !='All')
		{
			$this->db->where('locations.company',$this->params['company']);
		}
		if (isset($this->params['business_type']) && $this->params['business_type'] && $this->params['business_type'] !='All')
		{
			$this->db->where('locations.business_type',$this->params['business_type']);
		}
		//If we are exporting NOT exporting to excel make sure to use offset and limit
		if (isset($this->params['export_excel']) && !$this->params['export_excel'])
		{
			$this->db->limit($this->report_limit);
			if (isset($this->params['offset']))
			{
				$this->db->offset($this->params['offset']);
			}
		}
		
		return $this->db->get()->result_array();
	}
	
	
	function getTotalRows()
	{
		$location_ids = self::get_selected_location_ids();
		
		$this->db->from('item_kits_pricing_history');
		$this->db->join('locations', 'item_kits_pricing_history.location_id = locations.location_id','left');
		$this->db->join('item_kits','item_kits.item_kit_id=item_kits_pricing_history.item_kit_id');
		$this->db->group_start();
		$this->db->where_in('item_kits_pricing_history.location_id', $location_ids);
		$this->db->or_where('item_kits_pricing_history.location_id',NULL);
		$this->db->group_end();
		$this->db->where('on_date BETWEEN '.$this->db->escape($this->params['start_date']).' and '.$this->db->escape($this->params['end_date']));
		if (isset($this->params['company']) && $this->params['company'] && $this->params['company'] !='All')
		{
			$this->db->where('locations.company',$this->params['company']);
		}
		if (isset($this->params['business_type']) && $this->params['business_type'] && $this->params['business_type'] !='All')
		{
			$this->db->where('locations.business_type',$this->params['business_type']);
		}	
		if(isset($this->params['item_kit_id']) && $this->params['item_kit_id'])
		{
			$this->db->where('item_kits_pricing_history.item_kit_id',str_replace('KIT ','',$this->params['item_kit_id']));
		}		
		$query = $this->db->get();
		
		
		if ($query != false && $query->num_rows() > 0) {
			return $query->num_rows(); // Count the number of rows returned by the query
		}else{
			return false;
		}
		
	}
	
	public function getSummaryData()
	{
		return array();
	}

}
?>