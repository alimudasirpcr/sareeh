<?php
require_once ("Report.php");
require_once ("Summary_sales_locations.php");
class Summary_sales_locations_work_order extends Report
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Tier');
		
	}
	
	public function getInputData()
	{
		
		$input_params = array();
		
		$specific_entity_data['specific_input_name'] = 'item_id';
		$specific_entity_data['specific_input_label'] = lang('item');
		$specific_entity_data['search_suggestion_url'] = site_url('reports/item_search');
		$specific_entity_data['view'] = 'specific_entity';
		
		
		$tier_entity_data = array();
		$tier_entity_data['specific_input_name'] = 'tier_id';
		$tier_entity_data['specific_input_label'] = lang('tier_name');
		$tier_entity_data['view'] = 'specific_entity';
	
		$tiers = array();
		$tiers[''] =lang('no_tier_or_tier');
		$tiers['none'] = lang('none');
		$tiers['all'] = lang('all');
	
		$tiers_phppos= $this->Tier->get_all()->result_array();
		foreach($tiers_phppos as $value)
		{
			$tiers[$value['id']] = $value['name'];
		}
	
		$tier_entity_data['specific_input_data'] = $tiers;
		
		
		if ($this->settings['display'] == 'tabular')
		{
			$input_data = Report::get_common_report_input_data(TRUE);
			
			$input_params = array(
				array('view' => 'date_range', 'with_time' => TRUE),
				array('view' => 'date_range', 'with_time' => TRUE, 'compare_to' => TRUE),
				$specific_entity_data,
				array('view' => 'dropdown','dropdown_label' =>lang('reports_sale_type'),'dropdown_name' => 'sale_type','dropdown_options' =>array('all' => lang('reports_all'), 'sales' => lang('reports_sales'), 'returns' => lang('reports_returns')),'dropdown_selected_value' => 'all'),
				array('view' => 'dropdown','dropdown_label' => lang('reports_group_by'),'dropdown_name' => 'group_by','dropdown_options' =>array('' => lang('day'),'YEAR(sale_date), MONTH(sale_date), WEEK(sale_date)' => lang('week'), 'YEAR(sale_date), MONTH(sale_date)' => lang('month'), 'YEAR(sale_date)' => lang('year')),'dropdown_selected_value' => ''),
				array('view' => 'excel_export'),
				array('view' => 'locations'),
				array('view' => 'submit'),
			);
		}
		elseif ($this->settings['display'] == 'graphical')
		{
			$input_data = Report::get_common_report_input_data(FALSE);
			$input_params = array(
				array('view' => 'date_range', 'with_time' => TRUE),
				$specific_entity_data,
				array('view' => 'dropdown','dropdown_label' =>lang('reports_sale_type'),'dropdown_name' => 'sale_type','dropdown_options' =>array('all' => lang('reports_all'), 'sales' => lang('reports_sales'), 'returns' => lang('reports_returns')),'dropdown_selected_value' => 'all'),
				array('view' => 'dropdown','dropdown_label' => lang('reports_group_by'),'dropdown_name' => 'group_by','dropdown_options' =>array('' => lang('day'),'YEAR(sale_date), MONTH(sale_date), WEEK(sale_date)' => lang('week'), 'YEAR(sale_date), MONTH(sale_date)' => lang('month'), 'YEAR(sale_date)' => lang('year')),'dropdown_selected_value' => ''),
				array('view' => 'locations'),
				array('view' => 'submit'),
			);
		
		}
		
		if (count($tiers_phppos))
		{
			array_unshift($input_params,$tier_entity_data);
		}
		
		
		$input_data['input_report_title'] = lang('reports_report_options');
		$input_data['input_params'] = $input_params;
		return $input_data;
	}
	
	function getOutputData()
	{
		$do_compare = isset($this->params['compare_to']) && $this->params['compare_to'];		
		$subtitle = date(get_date_format(), strtotime($this->params['start_date'])) .'-'.date(get_date_format(), strtotime($this->params['end_date'])).($do_compare  ? ' '. lang('reports_compare_to'). ' '. date(get_date_format(), strtotime($this->params['start_date_compare'])) .'-'.date(get_date_format(), strtotime($this->params['end_date_compare'])) : '');

		$report_data = $this->getData();
		$summary_data = $this->getSummaryData();
		
		if ($this->settings['display'] == 'tabular')
		{				
			$this->setupDefaultPagination();
			$tabular_data = array();
			
			if ($do_compare)
			{
				$report_data_compare_model = new Summary_sales_locations();
				$report_data_compare_model->report_key = $this->report_key;
				$report_data_compare_model->setSettings($this->settings);
				$report_data_compare_model->setParams(array_merge($this->params,array('start_date'=>$this->params['start_date_compare'], 'end_date'=>$this->params['end_date_compare'])));

				$report_data_compare = $report_data_compare_model->getData();
				$report_data_summary_compare = $report_data_compare_model->getSummaryData();
			}

			$index = 0;
			foreach($report_data as $row)
			{
				$data_row = array();
				if ($do_compare)
				{
					if (isset($report_data_compare[$index]))
					{
						$row_compare = $report_data_compare[$index];
					}
					else
					{
						$row_compare = FALSE;
					}
				}
				$data_row[] = array('data'=> $row['location_name'], 'align'=>'left');
			
				$data_row[] = array('data'=>date(get_date_format(), strtotime($row['sale_date'])).($do_compare && $row_compare ? ' / <span class="compare ">'.date(get_date_format(), strtotime($row_compare['sale_date'])).'</span>':''), 'align'=>'left');
				$data_row[] = array('data'=>to_quantity($row['count']).($do_compare && $row_compare ? ' / <span class="compare '.($row_compare['count'] >= $row['count'] ? ($row['count'] == $row_compare['count'] ?  '' : 'compare_better') : 'compare_worse').'">'.to_quantity($row_compare['count']) .'</span>':''), 'align'=>'center');
				$data_row[] = array('data'=>to_currency($row['subtotal']).($do_compare && $row_compare ? ' / <span class="compare '.($row_compare['subtotal'] >= $row['subtotal'] ? ($row['subtotal'] == $row_compare['subtotal'] ?  '' : 'compare_better') : 'compare_worse').'">'.to_currency($row_compare['subtotal']) .'</span>':''), 'align'=>'right');
				$data_row[] = array('data'=>to_currency($row['total']).($do_compare && $row_compare ? ' / <span class="compare '.($row_compare['total'] >= $row['total'] ? ($row['total'] == $row_compare['total'] ?  '' : 'compare_better') : 'compare_worse').'">'.to_currency($row_compare['total']) .'</span>':''), 'align'=>'right');
				$data_row[] = array('data'=>to_currency($row['tax']).($do_compare && $row_compare ? ' / <span class="compare '.($row_compare['tax'] >= $row['tax'] ? ($row['tax'] == $row_compare['tax'] ?  '' : 'compare_better') : 'compare_worse').'">'.to_currency($row_compare['tax']) .'</span>':''), 'align'=>'right');
			
				if($this->has_profit_permission)
				{
					$data_row[] = array('data'=>to_currency($row['profit']).($do_compare && $row_compare ? ' / <span class="compare '.($row_compare['profit'] >= $row['profit'] ? ($row['profit'] == $row_compare['profit'] ?  '' : 'compare_better') : 'compare_worse').'">'.to_currency($row_compare['profit']) .'</span>':''), 'align'=>'right');
				}
				$tabular_data[] = $data_row;
			
				$index++;
			}
		
			if ($do_compare)
			{
				foreach($summary_data as $key=>$value)
				{
					if ($key == 'sales_per_time_period')
					{
						$summary_data[$key] = to_quantity($value) . ' / <span class="compare '.($report_data_summary_compare[$key] >= $value ? ($value == $report_data_summary_compare[$key] ?  '' : 'compare_better') : 'compare_worse').'">'.to_quantity($report_data_summary_compare[$key]).'</span>';
					}
					else
					{
						$summary_data[$key] = to_currency($value) . ' / <span class="compare '.($report_data_summary_compare[$key] >= $value ? ($value == $report_data_summary_compare[$key] ?  '' : 'compare_better') : 'compare_worse').'">'.to_currency($report_data_summary_compare[$key]).'</span>';
					}
				}
			
			}
			
	 		$data = array(
				'view' => 'tabular',
				"title" => lang('reports_sales_summary_report'),
				"subtitle" => $subtitle,
				"headers" => $this->getDataColumns(),
				"data" => $tabular_data,
				"summary_data" => $summary_data,
				"export_excel" => $this->params['export_excel'],
				"pagination" => $this->pagination->create_links(),
			);
			
		}
		elseif($this->settings['display'] == 'graphical')
		{
			$graph_data = array();
			foreach($report_data as $row)
			{
				$graph_data[date(get_date_format(), strtotime($row['sale_date']))]= to_currency_no_money($row['total']);
			}

			$currency_symbol = $this->config->item('currency_symbol') ? $this->config->item('currency_symbol') : '$';

			$data = array(
				'view' => 'graphical',
				'graph' => 'line',
				"summary_data" => $summary_data,
				"title" => lang('reports_sales_summary_report'),
				"data" => $graph_data,
				"subtitle" => $subtitle,
				"tooltip_template" => "<%=label %>: ".((!$this->config->item('currency_symbol_location') || $this->config->item('currency_symbol_location') =='before') ? $currency_symbol : '')."<%= parseFloat(Math.round(value * 100) / 100).toFixed(".$this->decimals.") %>".($this->config->item('currency_symbol_location') =='after' ? $currency_symbol: ''),
			);
		}
		
		return $data;
	}
	
	public function getDataColumns()
	{
		$columns = array();
		
		$columns[] = array('data'=>lang('location'), 'align'=> 'left');
		$columns[] = array('data'=>lang('reports_date'), 'align'=> 'left');
		$columns[] = array('data'=>lang('reports_sales_per_time_period'), 'align'=> 'center');
		$columns[] = array('data'=>lang('reports_subtotal'), 'align'=> 'right');
		$columns[] = array('data'=>lang('reports_total'), 'align'=> 'right');
		$columns[] = array('data'=>lang('tax'), 'align'=> 'right');

		if($this->has_profit_permission)
		{
			$columns[] = array('data'=>lang('profit'), 'align'=> 'right');
		}
		
		return $columns;		
	}
	
	public function getData()
	{		

		$this->db->save_queries = true;
		$location_ids = self::get_selected_location_ids();
		
		$this->db->select("*,locations.name as location_name");
		
		$this->sale_time_where(true);
		$this->db->from('sales');
		if(isset($this->params['item_id']) && $this->params['item_id'])
		{
			$this->db->join('sales_items', 'sales_items.sale_id = sales.sale_id');
			$sales_items= $this->db->dbprefix('sales_items');
			$this->db->select("count(sale_time) as count, date(sale_time) as sale_date, sum($sales_items.subtotal) as subtotal, sum($sales_items.total) as total, sum($sales_items.tax) as tax, sum($sales_items.profit) as profit", false);
			
			
			$this->db->where('sales_items.item_id',$this->params['item_id']);
		}
		else
		{
			$this->db->select('count(sale_time) as count, date(sale_time) as sale_date, sum(subtotal) as subtotal, sum(total) as total, sum(tax) as tax, sum(profit) as profit', false);
			
		}
		$this->db->join('locations', 'sales.location_id = locations.location_id');
		
		if (isset($this->params['tier_id']) && $this->params['tier_id'])
		{
			if ($this->params['tier_id'] == 'none')
			{
				$this->db->where('sales.tier_id is NULL');				
			}
			elseif($this->params['tier_id'] == 'all')
			{
				$this->db->where('sales.tier_id is NOT NULL');				
			}
			else
			{
				$this->db->where('sales.tier_id',$this->params['tier_id']);
			}
		}
		
		
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('total_quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('total_quantity_purchased < 0');
		}
		
		
		$this->db->where('sales.deleted', 0);
		$this->db->where('sales.is_work_order' , 1);
		$this->db->where_in('sales.location_id', $location_ids);
		
		if (isset($this->params['group_by']) && $this->params['group_by'])
		{
			$this->db->group_by('sales.location_id,'.$this->params['group_by'], TRUE);
		}
		else
		{
			$this->db->group_by('sales.location_id,sale_date');
		}
		$this->db->order_by('sale_time', ($this->config->item('report_sort_order')) ? $this->config->item('report_sort_order') : 'asc');
		
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
		
		$this->db->select('date(sale_time) as sale_date', false);
		$this->db->from('sales');
		$this->db->join('locations', 'sales.location_id = locations.location_id');
		
		if (isset($this->params['tier_id']) && $this->params['tier_id'])
		{
			if ($this->params['tier_id'] == 'none')
			{
				$this->db->where('sales.tier_id is NULL');				
			}
			elseif($this->params['tier_id'] == 'all')
			{
				$this->db->where('sales.tier_id is NOT NULL');				
			}
			else
			{
				$this->db->where('sales.tier_id',$this->params['tier_id']);
			}
		}
		
		
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('total_quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('total_quantity_purchased < 0');
		}
		$this->sale_time_where(true);
		$this->db->where('sales.is_work_order' , 1);
		$this->db->where('sales.deleted', 0);
		$this->db->where_in('sales.location_id', $location_ids);
		if (isset($this->params['group_by']) && $this->params['group_by'])
		{
			$this->db->group_by('sales.location_id,'.$this->params['group_by'], TRUE);
		}
		else
		{
			$this->db->group_by('sales.location_id,sale_date');
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
		$location_ids = self::get_selected_location_ids();
		
		$this->db->from('sales');
		
		if(isset($this->params['item_id']) && $this->params['item_id'])
		{
			$this->db->join('sales_items', 'sales_items.sale_id = sales.sale_id');
			$sales_items= $this->db->dbprefix('sales_items');
			$this->db->select("count(sale_time) as count,date(sale_time) as sale_date, sum($sales_items.subtotal) as subtotal, sum($sales_items.total) as total, sum($sales_items.tax) as tax, sum($sales_items.profit) as profit", false);
			$this->db->where('sales_items.item_id',$this->params['item_id']);
		}
		else
		{
			$this->db->select('count(sale_time) as count,date(sale_time) as sale_date, sum(subtotal) as subtotal, sum(total) as total, sum(tax) as tax, sum(profit) as profit', false);
		}
		
		if (isset($this->params['tier_id']) && $this->params['tier_id'])
		{
			if ($this->params['tier_id'] == 'none')
			{
				$this->db->where('sales.tier_id is NULL');				
			}
			elseif($this->params['tier_id'] == 'all')
			{
				$this->db->where('sales.tier_id is NOT NULL');				
			}
			else
			{
				$this->db->where('sales.tier_id',$this->params['tier_id']);
			}
		}
		
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('total_quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('total_quantity_purchased < 0');
		}
		
		if ($this->config->item('hide_store_account_payments_from_report_totals'))
		{
			$this->db->where('sales.store_account_payment', 0);
		}
		
		
		$this->sale_time_where(true);
		$this->db->where('sales.deleted', 0);
		$this->db->where('sales.is_work_order' , 1);
		$this->db->where_in('sales.location_id', $location_ids);
		if (isset($this->params['group_by']) && $this->params['group_by'])
		{
			$this->db->group_by($this->params['group_by'], TRUE);
		}
		else
		{
			$this->db->group_by('sale_date');
		}
		
		$return = array(
			'subtotal' => 0,
			'total' => 0,
			'tax' => 0,
			'profit' => 0,
			'sales_per_time_period' => 0,
		);
		
		$rows = 0;
		foreach($this->db->get()->result_array() as $row)
		{
			$return['subtotal'] += to_currency_no_money($row['subtotal'],2);
			$return['total'] += to_currency_no_money($row['total'],2);
			$return['tax'] += to_currency_no_money($row['tax'],2);
			$return['profit'] += to_currency_no_money($row['profit'],2);
			$return['sales_per_time_period'] += $row['count'];
			$rows++;
		}
		if($rows > 0){
			$return['sales_per_time_period'] = round($return['sales_per_time_period']/$rows,2);
		}else{
			$return['sales_per_time_period'] = round($return['sales_per_time_period']/1,2);
		}
		
		
		if(!$this->has_profit_permission)
		{
			unset($return['profit']);
		}
		return $return;
	}

}
?>