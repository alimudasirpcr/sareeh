<?php
require_once ("Report.php");
class Summary_meterreadings extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		$columns = array();
		
		$columns[] = array('data'=>lang('meterreading_id'), 'align'=> 'left');
		$columns[] = array('data'=>lang('meter_number'), 'align'=> 'right');
		$columns[] = array('data'=>lang('customer'), 'align'=> 'right');
		$columns[] = array('data'=>lang('rate'), 'align'=> 'right');
		$columns[] = array('data'=>lang('reading'), 'align'=> 'right');
		$columns[] = array('data'=>lang('bill'), 'align'=> 'right');
		$columns[] = array('data'=>lang('reading_date'), 'align'=> 'right');
		$columns[] = array('data'=>lang('billing_month'), 'align'=> 'right');
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
	
	function getOutputData()
	{
		$this->load->model('Sale');
		$this->load->model('Tag');
		
		$do_compare = isset($this->params['compare_to']) && $this->params['compare_to'];		
		$subtitle = date(get_date_format(), strtotime($this->params['start_date'])) .'-'.date(get_date_format(), strtotime($this->params['end_date'])).($do_compare  ? ' '. lang('reports_compare_to'). ' '. date(get_date_format(), strtotime($this->params['start_date_compare'])) .'-'.date(get_date_format(), strtotime($this->params['end_date_compare'])) : '');

		$tabular_data = array();
		$report_data = $this->getData();
		$summary_data = $this->getSummaryData();
		$start_date = $this->params['start_date'];
		$end_date = $this->params['end_date'];
		$sale_type = $this->params['sale_type'];
		
		if ($this->settings['display'] == 'tabular')
		{
			$this->setupDefaultPagination();
			$export_excel = $this->params['export_excel'];
			
			if ($do_compare)
			{
				$compare_start_date = $this->params['start_date_compare'];
				$compare_end_date = $this->params['end_date_compare'];
				
				$compare_to_meterreadings = array();
			
				foreach(array_keys($report_data) as $meterreading_name)
				{
					$compare_to_meterreadings[] = $meterreading_name;
				}
			
				$report_data_compare_model = new Summary_meterreadings();
				$report_data_compare_model->report_key = $this->report_key;
				$report_data_compare_model->setSettings($this->settings);
				$report_data_compare_model->setParams(array_merge($this->params,array('start_date'=>$this->params['start_date_compare'], 'end_date'=>$this->params['end_date_compare'])));

				$report_data_compare = $report_data_compare_model->getData();
				$report_data_summary_compare = $report_data_compare_model->getSummaryData();
			}


			foreach($report_data as $row)
			{
				
			  
				$data_row = array();
			
				$data_row[] = array('data'=>$row['reading_id'], 'align' => 'left');
				$data_row[] = array('data'=>$row['meter_number'], 'align' => 'left');
				$data_row[] = array('data'=>$row['customer_name'], 'align' => 'left');
				$data_row[] = array('data'=>$row['rate'], 'align' => 'left');
				$data_row[] = array('data'=>$row['reading_value'], 'align' => 'left');
				$data_row[] = array('data'=>$row['rate'] * $row['reading_value'], 'align' => 'left');
				$data_row[] = array('data'=>$row['reading_date'], 'align' => 'left');
				$data_row[] = array('data'=> date('M Y' , strtotime($row['reading_date'])) , 'align' => 'left');
				$tabular_data[] = $data_row;				
			}		

			$data = array(
				"view" => 'tabular',
				"title" => lang('reports_meterreadings_summary_report'),
				"subtitle" => date(get_date_format(), strtotime($start_date)) .'-'.date(get_date_format(), strtotime($end_date)).($do_compare  ? ' '. lang('reports_compare_to'). ' '. date(get_date_format(), strtotime($compare_start_date)) .'-'.date(get_date_format(), strtotime($compare_end_date)) : ''),
				"headers" => $this->getDataColumns(),
				"data" => $tabular_data,
				"summary_data" => $summary_data,
				"export_excel" => $export_excel,
				"pagination" => $this->pagination->create_links(),
			);
		}
		elseif ($this->settings['display'] == 'graphical')
		{
			$graph_data = array();
			foreach($report_data as $row)
			{
				$graph_data[$row['reading_date']] = to_currency_no_money($row['total']);
			}
			$currency_symbol = $this->config->item('currency_symbol') ? $this->config->item('currency_symbol') : '$';

			$data = array(
				"view" => "graphical",
				"graph" => 'line',
				"title" => lang('reports_meterreadings_summary_report'),
				"data" => $graph_data,
				'summary_data' => array(),
				"tooltip_template" => "<%=label %>: ".((!$this->config->item('currency_symbol_location') || $this->config->item('currency_symbol_location') =='before') ? $currency_symbol : '')."<%= parseFloat(Math.round(value * 100) / 100).toFixed(".$this->decimals.") %>".($this->config->item('currency_symbol_location') =='after' ? $currency_symbol: ''),
			   "legend_template" => "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%> (".((!$this->config->item('currency_symbol_location') || $this->config->item('currency_symbol_location') =='before') ? $currency_symbol : '')."<%=parseFloat(Math.round(segments[i].value * 100) / 100).toFixed(".$this->decimals.")%>".($this->config->item('currency_symbol_location') =='after' ?  $currency_symbol : '').")<%}%></li><%}%></ul>"
			);
		}
			
		return $data;
		
	}
	
	public function getData()
	{

		$this->db->save_queries = true;
		$this->db->select(''.$this->db->dbprefix('meterreading').'.* , '.$this->db->dbprefix('meters').'.meter_number, concat ('.$this->db->dbprefix('people').'.first_name , " " ,'.$this->db->dbprefix('people').'.last_name) as customer_name , sum('.$this->db->dbprefix('meterreading').'.reading_value) as total ', false);
		$this->db->from('meterreading');
		$this->db->join('people','meterreading.customer_id=people.person_id');	
		$this->db->join('meters','meters.meter_id=meterreading.meter_id');	
		$this->db->group_start();
		$this->db->where('meterreading.deleted', 0);
		$this->db->group_end();
		
		$this->meterreadings_time_where();
		
		
		$this->db->group_by('meterreading.reading_id');
		$this->db->order_by('meterreading.reading_id');
		//If we are exporting NOT exporting to excel make sure to use offset and limit
		if (isset($this->params['export_excel']) && !$this->params['export_excel'])
		{
			$this->db->limit($this->report_limit);
			
			if (isset($this->params['offset']))
			{
				$this->db->offset($this->params['offset']);
			}
		}

		$items = $this->db->get()->result_array();	
		
		return $items;
	}
	
	
	
	public function getSummaryData()
	{
		return array();
	}
	
	function getTotalRows()
	{
		return $this->Tag->count_all();
	}
}
?>