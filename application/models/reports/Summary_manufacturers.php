<?php
require_once ("Report.php");
class Summary_manufacturers extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		$columns = array();
		
		$columns[] = array('data'=>lang('manufacturer'), 'align'=> 'left');
		$columns[] = array('data'=>lang('reports_subtotal'), 'align'=> 'right');
		$columns[] = array('data'=>lang('reports_total'), 'align'=> 'right');
		$columns[] = array('data'=>lang('tax'), 'align'=> 'right');

		if($this->has_profit_permission)
		{
			$columns[] = array('data'=>lang('profit'), 'align'=> 'right');
		}
		$columns[] = array('data'=>lang('items_sold'), 'align'=> 'right');
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
				array('view' => 'date_range', 'with_time' => TRUE, 'compare_to' => TRUE),
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
	
	// function getOutputData()
	// {
	// 	$this->setupDefaultPagination();
	// 	$do_compare = isset($this->params['compare_to']) && $this->params['compare_to'];		
	// 	$start_date = $this->params['start_date'];
	// 	$end_date = $this->params['end_date'];
		
	// 	$tabular_data = array();
	// 	$report_data = $this->getData();
	// 	$summary_data = $this->getSummaryData();
	// 	if ($this->settings['display'] == 'tabular')
	// 	{				
			
	// 		$compare_start_date = $this->params['start_date_compare'];
	// 		$compare_end_date = $this->params['end_date_compare'];
		
	// 		if ($do_compare)
	// 		{
	// 			$compare_to_categories = array();
			
	// 			for($k=0;$k<count($report_data);$k++)
	// 			{
	// 				$compare_to_manufacturers[] = $report_data[$k]['manufacturer_id'];
	// 			}
			
	// 			$report_data_compare_model = new Summary_manufacturers();
	// 			$report_data_compare_model->report_key = $this->report_key;
	// 			$report_data_compare_model->setSettings($this->settings);
	// 			$report_data_compare_model->setParams(array_merge($this->params,array('start_date'=>$this->params['start_date_compare'], 'end_date'=>$this->params['end_date_compare'])));

	// 			$report_data_compare = $report_data_compare_model->getData();
	// 			$report_data_summary_compare = $report_data_compare_model->getSummaryData();
	// 		}

	// 		foreach($report_data as $row)
	// 		{
	// 			if ($do_compare)
	// 			{
	// 				$index_compare = -1;
	// 				$compare_to_manufacturer = $row['manufacturer_id'];
				
	// 				for($k=0;$k<count($report_data_compare);$k++)
	// 				{
	// 					if ($report_data_compare[$k]['manufacturer_id'] == $compare_to_manufacturer)
	// 					{
	// 						$index_compare = $k;
	// 						break;
	// 					}
	// 				}
				
	// 				if (isset($report_data_compare[$index_compare]))
	// 				{
	// 					$row_compare = $report_data_compare[$index_compare];
	// 				}
	// 				else
	// 				{
	// 					$row_compare = FALSE;
	// 				}
	// 			}
			
	// 			$data_row = array();
			
	// 			$data_row[] = array('data'=>$row['manufacturer'] ? $row['manufacturer'] : lang('none'), 'align' => 'left');
	// 			$data_row[] = array('data'=>to_currency($row['subtotal']).($do_compare && $row_compare ? ' / <span class="compare '.($row_compare['subtotal'] >= $row['subtotal'] ? ($row['subtotal'] == $row_compare['subtotal'] ?  '' : 'compare_better') : 'compare_worse').'">'.to_currency($row_compare['subtotal']) .'</span>':''), 'align' => 'right');
	// 			$data_row[] = array('data'=>to_currency($row['total']).($do_compare && $row_compare ? ' / <span class="compare '.($row_compare['total'] >= $row['total'] ? ($row['total'] == $row_compare['total'] ?  '' : 'compare_better') : 'compare_worse').'">'.to_currency($row_compare['total']) .'</span>':''), 'align' => 'right');
	// 			$data_row[] = array('data'=>to_currency($row['tax']).($do_compare && $row_compare ? ' / <span class="compare '.($row_compare['tax'] >= $row['tax'] ? ($row['tax'] == $row_compare['tax'] ?  '' : 'compare_better') : 'compare_worse').'">'.to_currency($row_compare['tax']) .'</span>':''), 'align' => 'right');
	// 			if($this->has_profit_permission)
	// 			{
	// 				$data_row[] = array('data'=>to_currency($row['profit']).($do_compare && $row_compare ? ' / <span class="compare '.($row_compare['profit'] >= $row['profit'] ? ($row['profit'] == $row_compare['profit'] ?  '' : 'compare_better') : 'compare_worse').'">'.to_currency($row_compare['profit']) .'</span>':''), 'align' => 'right');
	// 			}
	// 			$data_row[] = array('data'=>floatval($row['item_sold']).($do_compare && $row_compare ? ' / <span class="compare '.($row_compare['item_sold'] >= $row['item_sold'] ? ($row['item_sold'] == $row_compare['item_sold'] ?  '' : 'compare_better') : 'compare_worse').'">'.floatval($row_compare['item_sold']) .'</span>':''), 'align' => 'right');
	// 			$tabular_data[] = $data_row;				
	// 		}

	// 		if ($do_compare)
	// 		{
	// 			foreach($summary_data as $key=>$value)
	// 			{
	// 				$summary_data[$key] = to_currency($value) . ' / <span class="compare '.($report_data_summary_compare[$key] >= $value ? ($value == $report_data_summary_compare[$key] ?  '' : 'compare_better') : 'compare_worse').'">'.to_currency($report_data_summary_compare[$key]).'</span>';
	// 			}
			
	// 		}

	// 		$data = array(
	// 			"view" => "tabular",
	// 			"title" => lang('reports_manufacturers_report'),
	// 			"subtitle" => date(get_date_format(), strtotime($start_date)) .'-'.date(get_date_format(), strtotime($end_date)).($do_compare  ? ' '. lang('reports_compare_to'). ' '. date(get_date_format(), strtotime($compare_start_date)) .'-'.date(get_date_format(), strtotime($compare_end_date)) : ''),
	// 			"headers" => $this->getDataColumns(),
	// 			"data" => $tabular_data,
	// 			"summary_data" => $summary_data,
	// 			"export_excel" => $this->params['export_excel'],
	// 			"pagination" => $this->pagination->create_links(),
	// 		);
	// 	}
	// 	elseif($this->settings['display'] == 'graphical')
	// 	{
			
	// 		$graph_data = array();
	// 		foreach($report_data as $row)
	// 		{
	// 			$graph_data[$row['manufacturer'] ? $row['manufacturer'] : lang('none')] = to_currency_no_money($row['total']);
	// 		}

	// 		$currency_symbol = $this->config->item('currency_symbol') ? $this->config->item('currency_symbol') : '$';
			

	// 		$data = array(
	// 			'view' => 'graphical',
	// 			'graph' => 'pie',
	// 			"summary_data" => $summary_data,
	// 			"title" => lang('reports_manufacturers_report'),
	// 			"data" => $graph_data,
	// 			"tooltip_template" => "<%=label %>: ".((!$this->config->item('currency_symbol_location') || $this->config->item('currency_symbol_location') =='before') ? $currency_symbol : '')."<%= parseFloat(Math.round(value * 100) / 100).toFixed(".$this->decimals.") %>".($this->config->item('currency_symbol_location') =='after' ? $currency_symbol: ''),
	// 		   "legend_template" => "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%> (".((!$this->config->item('currency_symbol_location') || $this->config->item('currency_symbol_location') =='before') ? $currency_symbol : '')."<%=parseFloat(Math.round(segments[i].value * 100) / 100).toFixed(".$this->decimals.")%>".($this->config->item('currency_symbol_location') =='after' ?  $currency_symbol : '').")<%}%></li><%}%></ul>"
	// 			);
	// 	}
		
	// 	return $data;
		
	// }
	function getOutputData()
{
    $this->setupDefaultPagination();
    $do_compare = isset($this->params['compare_to']) && $this->params['compare_to'];
    $start_date = $this->params['start_date'];
    $end_date = $this->params['end_date'];

    $tabular_data = array();
    $report_data = $this->getData();
    $summary_data = $this->getSummaryData();
	

    if ($this->settings['display'] == 'tabular')
    {
        $compare_start_date = $this->params['start_date_compare'];
        $compare_end_date = $this->params['end_date_compare'];

        if ($do_compare)
        {
            $compare_to_manufacturers = array();

            if (!empty($report_data)) {
                foreach ($report_data as $row) {
                    if (isset($row['manufacturer_id'])) {
                        $compare_to_manufacturers[] = $row['manufacturer_id'];
                    }
                }
            }

            $report_data_compare_model = new Summary_manufacturers();
            $report_data_compare_model->report_key = $this->report_key;
            $report_data_compare_model->setSettings($this->settings);
            $report_data_compare_model->setParams(array_merge($this->params, [
                'start_date' => $this->params['start_date_compare'],
                'end_date' => $this->params['end_date_compare']
            ]));

            $report_data_compare = $report_data_compare_model->getData();
            $report_data_summary_compare = $report_data_compare_model->getSummaryData();
        }

        foreach ($report_data as $row)
        {
            $row_compare = null;

            if ($do_compare && !empty($report_data_compare))
            {
                foreach ($report_data_compare as $compare_row) {
                    if (isset($compare_row['manufacturer_id']) && $compare_row['manufacturer_id'] == $row['manufacturer_id']) {
                        $row_compare = $compare_row;
                        break;
                    }
                }
            }

            $data_row = array();
            $data_row[] = array('data' => $row['manufacturer'] ?? lang('none'), 'align' => 'left');
            $data_row[] = array('data' => to_currency($row['subtotal']) . ($do_compare && $row_compare ? ' / <span class="compare ' . ($row_compare['subtotal'] >= $row['subtotal'] ? ($row['subtotal'] == $row_compare['subtotal'] ?  '' : 'compare_better') : 'compare_worse') . '">' . to_currency($row_compare['subtotal']) . '</span>' : ''), 'align' => 'right');
            $data_row[] = array('data' => to_currency($row['total']) . ($do_compare && $row_compare ? ' / <span class="compare ' . ($row_compare['total'] >= $row['total'] ? ($row['total'] == $row_compare['total'] ?  '' : 'compare_better') : 'compare_worse') . '">' . to_currency($row_compare['total']) . '</span>' : ''), 'align' => 'right');
            $data_row[] = array('data' => to_currency($row['tax']) . ($do_compare && $row_compare ? ' / <span class="compare ' . ($row_compare['tax'] >= $row['tax'] ? ($row['tax'] == $row_compare['tax'] ?  '' : 'compare_better') : 'compare_worse') . '">' . to_currency($row_compare['tax']) . '</span>' : ''), 'align' => 'right');
            if ($this->has_profit_permission)
            {
                $data_row[] = array('data' => to_currency($row['profit']) . ($do_compare && $row_compare ? ' / <span class="compare ' . ($row_compare['profit'] >= $row['profit'] ? ($row['profit'] == $row_compare['profit'] ?  '' : 'compare_better') : 'compare_worse') . '">' . to_currency($row_compare['profit']) . '</span>' : ''), 'align' => 'right');
            }
            $data_row[] = array('data' => floatval($row['item_sold']) . ($do_compare && $row_compare ? ' / <span class="compare ' . ($row_compare['item_sold'] >= $row['item_sold'] ? ($row['item_sold'] == $row_compare['item_sold'] ?  '' : 'compare_better') : 'compare_worse') . '">' . floatval($row_compare['item_sold']) . '</span>' : ''), 'align' => 'right');
            $tabular_data[] = $data_row;
        }

        if ($do_compare)
        {
            foreach ($summary_data as $key => $value)
            {
                $summary_data[$key] = to_currency($value) . ' / <span class="compare ' . ($report_data_summary_compare[$key] >= $value ? ($value == $report_data_summary_compare[$key] ? '' : 'compare_better') : 'compare_worse') . '">' . to_currency($report_data_summary_compare[$key]) . '</span>';
            }
        }

        $data = array(
            "view" => "tabular",
            "title" => lang('reports_manufacturers_report'),
            "subtitle" => date(get_date_format(), strtotime($start_date)) . '-' . date(get_date_format(), strtotime($end_date)) . ($do_compare ? ' ' . lang('reports_compare_to') . ' ' . date(get_date_format(), strtotime($compare_start_date)) . '-' . date(get_date_format(), strtotime($compare_end_date)) : ''),
            "headers" => $this->getDataColumns(),
            "data" => $tabular_data,
            "summary_data" => $summary_data,
            "export_excel" => $this->params['export_excel'],
            "pagination" => $this->pagination->create_links(),
        );
    }elseif($this->settings['display'] == 'graphical')
	{
		
		$graph_data = array();
		foreach($report_data as $row)
		{
			$graph_data[$row['manufacturer'] ? $row['manufacturer'] : lang('none')] = to_currency_no_money($row['total']);
		}

		$currency_symbol = $this->config->item('currency_symbol') ? $this->config->item('currency_symbol') : '$';
		

		$data = array(
			'view' => 'graphical',
			'graph' => 'pie',
			"summary_data" => $summary_data,
			"title" => lang('reports_manufacturers_report'),
			"data" => $graph_data,
			"tooltip_template" => "<%=label %>: ".((!$this->config->item('currency_symbol_location') || $this->config->item('currency_symbol_location') =='before') ? $currency_symbol : '')."<%= parseFloat(Math.round(value * 100) / 100).toFixed(".$this->decimals.") %>".($this->config->item('currency_symbol_location') =='after' ? $currency_symbol: ''),
		   "legend_template" => "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%> (".((!$this->config->item('currency_symbol_location') || $this->config->item('currency_symbol_location') =='before') ? $currency_symbol : '')."<%=parseFloat(Math.round(segments[i].value * 100) / 100).toFixed(".$this->decimals.")%>".($this->config->item('currency_symbol_location') =='after' ?  $currency_symbol : '').")<%}%></li><%}%></ul>"
			);
	}

    return $data;
}

	
	public function getData()
	{
		$this->db->select('items.manufacturer_id, manufacturers.name as manufacturer, sum('.$this->db->dbprefix('sales_items').'.subtotal) as subtotal, sum('.$this->db->dbprefix('sales_items').'.total) as total, sum('.$this->db->dbprefix('sales_items').'.tax) as tax, sum('.$this->db->dbprefix('sales_items').'.profit) as profit, sum('.$this->db->dbprefix('sales_items').'.quantity_purchased) as item_sold', false);
		
		$this->db->from('sales_items');
		$this->db->join('sales', 'sales.sale_id = sales_items.sale_id');
		$this->db->join('items', 'sales_items.item_id = items.item_id');
		$this->db->join('manufacturers', 'manufacturers.id = items.manufacturer_id', 'left');
		$this->sale_time_where();
		$this->db->group_start();
		$this->db->where('sales.deleted', 0);
		$this->db->or_where('items.name IS NULL');
		$this->db->group_end();
		
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		if (isset($this->params['compare_to_manufacturers']) && count($this->params['compare_to_manufacturers']) > 0)
		{
			$this->db->where_in('items.manufacturer_id', $this->params['compare_to_manufacturers']);
		}	
		
		$this->db->group_by('manufacturers.id');
		$this->db->order_by('manufacturers.name');
		//If we are exporting NOT exporting to excel make sure to use offset and limit
		if (isset($this->params['export_excel']) && !$this->params['export_excel'])
		{
			$this->db->limit($this->report_limit);
			if(isset($this->params['offset']))
			{
				$this->db->offset($this->params['offset']);
			}
		}
		

		$items= $this->db->get()->result_array();	
		
		$this->db->select('item_kits.manufacturer_id, manufacturers.name as manufacturer, sum('.$this->db->dbprefix('sales_item_kits').'.subtotal) as subtotal, sum('.$this->db->dbprefix('sales_item_kits').'.total) as total, sum('.$this->db->dbprefix('sales_item_kits').'.tax) as tax, sum('.$this->db->dbprefix('sales_item_kits').'.profit) as profit, sum('.$this->db->dbprefix('sales_item_kits').'.quantity_purchased) as item_sold', false);
		$this->db->from('sales_item_kits');
		$this->db->join('sales', 'sales.sale_id = sales_item_kits.sale_id');
		$this->db->join('item_kits', 'sales_item_kits.item_kit_id = item_kits.item_kit_id');
		$this->db->join('manufacturers', 'manufacturers.id = item_kits.manufacturer_id', 'left');
		$this->sale_time_where();
		
		$this->db->group_start();
		$this->db->where('item_kits.name !=', lang('discount'));
		$this->db->where('sales.deleted', 0);		
		$this->db->or_where('item_kits.name IS NULL');
		$this->db->group_end();
				
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		if (isset($this->params['compare_to_manufacturers']) && count($this->params['compare_to_manufacturers']) > 0)
		{
			$this->db->where_in('item_kits.manufacturer_id', $this->params['compare_to_manufacturers']);
		}	

		$this->db->group_by('item_kits.manufacturer_id');
		$this->db->order_by('sales.sale_time', ($this->config->item('report_sort_order')) ? $this->config->item('report_sort_order') : 'asc');
		//If we are exporting NOT exporting to excel make sure to use offset and limit
		if (isset($this->params['export_excel']) && !$this->params['export_excel'])
		{
			$this->db->limit($this->report_limit);
			if(isset($this->params['offset']))
			{
				$this->db->offset($this->params['offset']);
			}
		}
		
		$item_kits = $this->db->get()->result_array();		
		return $this->merge_item_and_item_kits($items, $item_kits);		
	}
	
	
	public function getSummaryData()
	{
		$this->db->select('items.manufacturer_id, manufacturers.name as manufacturer, sum('.$this->db->dbprefix('sales_items').'.subtotal) as subtotal, sum('.$this->db->dbprefix('sales_items').'.total) as total, sum('.$this->db->dbprefix('sales_items').'.tax) as tax, sum('.$this->db->dbprefix('sales_items').'.profit) as profit, sum('.$this->db->dbprefix('sales_items').'.quantity_purchased) as item_sold', false);
		
		$this->db->from('sales_items');
		$this->db->join('sales', 'sales.sale_id = sales_items.sale_id');
		$this->db->join('items', 'sales_items.item_id = items.item_id');
		$this->db->join('manufacturers', 'manufacturers.id = items.manufacturer_id', 'left');
		$this->sale_time_where();
		
		$this->db->group_start();
		$this->db->where('sales.deleted', 0);		
		$this->db->or_where('items.name IS NULL');
		$this->db->group_end();
				
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		if (isset($this->params['compare_to_manufacturers']) && count($this->params['compare_to_manufacturers']) > 0)
		{
			$this->db->where_in('items.manufacturer_id', $this->params['compare_to_manufacturers']);
		}	
		
		$this->db->group_by('manufacturers.id');
		$this->db->order_by('manufacturers.name');

		$items= $this->db->get()->result_array();	
		
		$this->db->select('item_kits.manufacturer_id, manufacturers.name as manufacturer, sum('.$this->db->dbprefix('sales_item_kits').'.subtotal) as subtotal, sum('.$this->db->dbprefix('sales_item_kits').'.total) as total, sum('.$this->db->dbprefix('sales_item_kits').'.tax) as tax, sum('.$this->db->dbprefix('sales_item_kits').'.profit) as profit, sum('.$this->db->dbprefix('sales_item_kits').'.quantity_purchased) as item_sold', false);
		$this->db->from('sales_item_kits');
		$this->db->join('sales', 'sales.sale_id = sales_item_kits.sale_id');
		$this->db->join('item_kits', 'sales_item_kits.item_kit_id = item_kits.item_kit_id');
		$this->db->join('manufacturers', 'manufacturers.id = item_kits.manufacturer_id', 'left');
		
		$this->sale_time_where();
		$this->db->group_start();
		$this->db->where('item_kits.name !=', lang('discount'));
		$this->db->where('sales.deleted', 0);
		$this->db->or_where('item_kits.name IS NULL');
		$this->db->group_end();

		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('quantity_purchased < 0');
		}
		
		if (isset($this->params['compare_to_manufacturers']) && count($this->params['compare_to_manufacturers']) > 0)
		{
			$this->db->where_in('item_kits.manufacturer_id', $this->params['compare_to_manufacturers']);
		}	
		
		
		$this->db->group_by('item_kits.manufacturer_id');
		$this->db->order_by('sales.sale_time', ($this->config->item('report_sort_order')) ? $this->config->item('report_sort_order') : 'asc');
		
		$item_kits = $this->db->get()->result_array();
		$result= $this->merge_item_and_item_kits($items, $item_kits);		

		$return = array(
			'subtotal' => 0,
			'total' => 0,
			'tax' => 0,
			'profit' => 0,
		);
		
		foreach($result as $row)
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
	
	function getTotalRows()
	{
		$this->db->select('COUNT(DISTINCT('.$this->db->dbprefix('items').'.manufacturer_id)) as category_count');
		$this->db->from('sales');
		$this->db->join('sales_items', 'sales_items.sale_id = sales.sale_id');
		$this->db->join('items', 'items.item_id = sales_items.item_id');
		$this->db->join('manufacturers', 'manufacturers.id = items.manufacturer_id');
		$this->sale_time_where();
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('sales.total_quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('sales.total_quantity_purchased < 0');
		}
		
		$this->db->where('sales.deleted',0);
		
		$ret = $this->db->get()->row_array();
		return $ret['category_count'];
	}
	
	private function merge_item_and_item_kits($items, $item_kits)
	{
		$new_items = array();
		$new_item_kits = array();
		
		foreach($items as $item)
		{
			$new_items[$item['manufacturer']] = $item;
		}
		
		foreach($item_kits as $item_kit)
		{
			$new_item_kits[$item_kit['manufacturer']] = $item_kit;
		}
		
		$merged = array();
		
		foreach($new_items as $manufacturer=>$row)
		{
			if (!isset($merged[$manufacturer]))
			{
				$merged[$manufacturer] = $row;
			}
			else
			{
				$merged[$category]['manufacturer']+= $row['subtotal'];
				$merged[$category]['manufacturer']+= $row['total'];
				$merged[$category]['manufacturer']+= $row['tax'];
				$merged[$category]['manufacturer']+= $row['profit'];
				$merged[$category]['manufacturer']+= $row['item_sold'];
				
			}
		}
		
		foreach($new_item_kits as $manufacturer=>$row)
		{
			if (!isset($merged[$manufacturer]))
			{
				$merged[$manufacturer] = $row;
			}
			else
			{
				$merged[$manufacturer]['subtotal']+= $row['subtotal'];
				$merged[$manufacturer]['total']+= $row['total'];
				$merged[$manufacturer]['tax']+= $row['tax'];
				$merged[$manufacturer]['profit']+= $row['profit'];
				$merged[$manufacturer]['item_sold']+= $row['item_sold'];
				
			}
		}
		
		
		return $merged;
	}
}
?>