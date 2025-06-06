<?php
require_once ("Report.php");
class Summary_suppliers extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		$columns = array();
		
		$columns[] = array('data'=>lang('reports_supplier'), 'align'=> 'left');
		$columns[] = array('data'=>lang('reports_subtotal'), 'align'=> 'right');
		$columns[] = array('data'=>lang('discounts'), 'align'=> 'right');
		$columns[] = array('data'=>lang('reports_total'), 'align'=> 'right');
		$columns[] = array('data'=>lang('tax'), 'align'=> 'right');

		if($this->has_profit_permission)
		{
			$columns[] = array('data'=>lang('profit'), 'align'=> 'right');
			$columns[] = array('data'=>lang('margin'), 'align'=> 'right');
		}
		
		return $columns;		
	}
	
	public function getInputData()
	{
		
		$input_params = array();

		if ($this->settings['display'] == 'tabular')
		{
			$input_data = Report::get_common_report_input_data(TRUE);
			
			$input_params = array(
				array('view' => 'date_range', 'with_time' => TRUE),
				array('view' => 'dropdown','dropdown_label' =>lang('reports_sale_type'),'dropdown_name' => 'sale_type','dropdown_options' =>array('all' => lang('reports_all'), 'sales' => lang('reports_sales'), 'returns' => lang('reports_returns')),'dropdown_selected_value' => 'all'),
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
				array('view' => 'dropdown','dropdown_label' =>lang('reports_sale_type'),'dropdown_name' => 'sale_type','dropdown_options' =>array('all' => lang('reports_all'), 'sales' => lang('reports_sales'), 'returns' => lang('reports_returns')),'dropdown_selected_value' => 'all'),
				array('view' => 'locations'),
				array('view' => 'submit'),
			);
			
		}
		
		$input_data['input_report_title'] = lang('reports_report_options');
		$input_data['input_params'] = $input_params;
		return $input_data;
	}
	
	public function getOutputData()
	{
		$this->setupDefaultPagination();
		$tabular_data = array();
		$report_data = $this->getData();
		$summary_data = $this->getSummaryData();
		
		if ($this->settings['display'] == 'tabular')
		{				

			foreach($report_data as $row)
			{
				$data_row = array();
			
				$data_row[] = array('data'=>$row['supplier'], 'align' => 'left');
				$data_row[] = array('data'=>to_currency($row['subtotal']), 'align'=>'right');
				$data_row[] = array('data'=>to_currency($row['discount_total']), 'align'=>'right');
				$data_row[] = array('data'=>to_currency($row['total']), 'align'=>'right');
				$data_row[] = array('data'=>to_currency($row['tax']), 'align'=> 'right');
			
				if($this->has_profit_permission)
				{
					$data_row[] = array('data'=>to_currency($row['profit']), 'align'=>'right');
					$data_row[] = array('data'=>round(($row['profit']/($row['subtotal']+$row['discount_total']))*100,2).'%', 'align'=>'right');
				}
				$tabular_data[] = $data_row;			
			}

			$data = array(
				"view" => 'tabular',
				"title" => lang('reports_suppliers_summary_report'),
				"subtitle" => date(get_date_format(), strtotime($this->params['start_date'])) .'-'.date(get_date_format(), strtotime($this->params['end_date'])),
				"headers" => $this->getDataColumns(),
				"data" => $tabular_data,
				"summary_data" => $summary_data,
				"export_excel" => $this->params['export_excel'],
				"pagination" => $this->pagination->create_links(),
			);
		}
		else
		{
			$graph_data = array();
			foreach($report_data as $row)
			{
				$graph_data[$row['supplier']] = to_currency_no_money($row['total']);
			}

			$currency_symbol = $this->config->item('currency_symbol') ? $this->config->item('currency_symbol') : '$';

			$data = array(
				"view" => 'graphical',
				'graph' => 'pie',
				"summary_data" => $summary_data,
				"title" => lang('reports_suppliers_summary_report'),
				"data" => $graph_data,
				"tooltip_template" => "<%=label %>: ".((!$this->config->item('currency_symbol_location') || $this->config->item('currency_symbol_location') =='before') ? $currency_symbol : '')."<%= parseFloat(Math.round(value * 100) / 100).toFixed(".$this->decimals.") %>".($this->config->item('currency_symbol_location') =='after' ? $currency_symbol: ''),
			   "legend_template" => "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%> (".((!$this->config->item('currency_symbol_location') || $this->config->item('currency_symbol_location') =='before') ? $currency_symbol : '')."<%=parseFloat(Math.round(segments[i].value * 100) / 100).toFixed(".$this->decimals.")%>".($this->config->item('currency_symbol_location') =='after' ?  $currency_symbol : '').")<%}%></li><%}%></ul>"
			);
		
			
		}
		return $data;
	}
	
	public function getData()
	{
		$location_ids = self::get_selected_location_ids();		
		$this->db->select('SUM(item_unit_price * quantity_purchased*(discount_percent/100)) as discount_total,CONCAT(company_name, " (",first_name, " ",last_name, ")") as supplier, sum('.$this->db->dbprefix('sales_items').'.subtotal) as subtotal, sum('.$this->db->dbprefix('sales_items').'.total) as total, sum('.$this->db->dbprefix('sales_items').'.tax) as tax,sum('.$this->db->dbprefix('sales_items').'.profit) as profit', false);
		$this->db->from('sales');
		$this->db->join('sales_items', 'sales.sale_id = sales_items.sale_id');
		$this->db->join('items', 'items.item_id = sales_items.item_id');
		$this->db->join('suppliers', 'suppliers.person_id = items.supplier_id','left');
		$this->db->join('people', 'suppliers.person_id = people.person_id');
		$this->db->join('locations', 'sales.location_id = locations.location_id');
		if (isset($this->params['company']) && $this->params['company'] && $this->params['company'] !='All')
		{
			$this->db->where('locations.company',$this->params['company']);
		}
		if (isset($this->params['business_type']) && $this->params['business_type'] && $this->params['business_type'] !='All')
		{
			$this->db->where('locations.business_type',$this->params['business_type']);
		}	
		$this->sale_time_where();
		$this->db->where_in('sales.location_id', $location_ids);
		
		$this->db->where('sales.deleted', 0);
		
		
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('sales_items.quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('sales_items.quantity_purchased < 0');
		}
		
		
		$this->db->group_by('suppliers.id');
		$this->db->order_by('people.last_name');
		
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
		
		$this->db->select('COUNT(DISTINCT('.$this->db->dbprefix('people').'.person_id)) as supplier_count');
		$this->db->from('sales');
		$this->db->join('sales_items', 'sales_items.sale_id = sales.sale_id');
		$this->db->join('items', 'items.item_id = sales_items.item_id');
		$this->db->join('suppliers', 'suppliers.person_id = items.supplier_id','left');
		$this->db->join('people', 'suppliers.person_id = people.person_id');
		$this->db->join('locations', 'sales.location_id = locations.location_id');
		if (isset($this->params['company']) && $this->params['company'] && $this->params['company'] !='All')
		{
			$this->db->where('locations.company',$this->params['company']);
		}
		if (isset($this->params['business_type']) && $this->params['business_type'] && $this->params['business_type'] !='All')
		{
			$this->db->where('locations.business_type',$this->params['business_type']);
		}	
		$this->db->where_in('sales.location_id', $location_ids);
		$this->sale_time_where();
		
		$this->db->where('sales.deleted', 0);
				

		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('sales_items.quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('sales_items.quantity_purchased < 0');
		}
						
		$ret = $this->db->get()->row_array();
		return $ret['supplier_count'];
	}
	
	
	public function getSummaryData()
	{
		$location_ids = self::get_selected_location_ids();
		$this->db->select('sum('.$this->db->dbprefix('sales_items').'.subtotal) as subtotal, sum('.$this->db->dbprefix('sales_items').'.total) as total, sum('.$this->db->dbprefix('sales_items').'.tax) as tax, sum('.$this->db->dbprefix('sales_items').'.profit) as profit', false);
		
		$this->db->from('sales');
		$this->db->join('sales_items', 'sales.sale_id = sales_items.sale_id');
		$this->db->join('items', 'items.item_id = sales_items.item_id');
		$this->db->join('suppliers', 'suppliers.person_id = items.supplier_id','left');
		$this->db->join('people', 'suppliers.person_id = people.person_id');
		$this->sale_time_where();
		
		$this->db->where_in('sales.location_id', $location_ids);
		$this->db->where('sales.deleted', 0);
		
		
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('sales_items.quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('sales_items.quantity_purchased < 0');
		}
		
			
		$this->db->group_by('sales.sale_id');
		
		$return = array(
			'subtotal' => 0,
			'total' => 0,
			'tax' => 0,
			'profit' => 0,
		);
		
		foreach($this->db->get()->result_array() as $row)
		{
			$return['subtotal'] += to_currency_no_money($row['subtotal'],2);
			$return['total'] += to_currency_no_money($row['total'],2);
			$return['tax'] += to_currency_no_money($row['tax'],2);
			$return['profit'] += to_currency_no_money($row['profit'],2);
		}
		if(!$this->has_profit_permission)
		{
			unset($return['profit']);
		}
		return $return;
	}
}
?>