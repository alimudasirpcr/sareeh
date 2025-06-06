<?php
require_once ("Report.php");
class Detailed_work_order extends Report
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Tier');
	}
	
	public function getInputData()
	{
		$input_data = Report::get_common_report_input_data(TRUE);
		
		$input_params = array();

		if ($this->settings['display'] == 'tabular')
		{
			
			$register_input_data_entry = array();
			$register_input_data_entry['view']  = 'specific_entity';
			$register_input_data_entry['specific_input_name'] = 'register_id';
			$register_input_data_entry['specific_input_label'] = lang('reports_register');
			$registers = array();
			$registers[''] = lang('all');
			foreach($this->Register->get_all()->result() as $register)
			{
				$location_info = $this->Location->get_info($register->location_id);
				$registers[$register->register_id] = $location_info->name.' - '.$register->name;
			}
			$register_input_data_entry['specific_input_data'] = $registers;
			
			
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
			
			
			$exchange_data = array();
			$exchange_data['specific_input_name'] = 'currency';
			$exchange_data['specific_input_label'] = lang('exchange_to');
			$exchange_data['view'] = 'specific_entity';
		
			$exchange_rates_dropdown = array();
			$exchange_rates_dropdown[''] =lang('all');
			$exchange_rates_dropdown['0'] =lang('default');
		
			$exchange_rates = $this->Appconfig->get_exchange_rates()->result_array();

			foreach($exchange_rates as $exchange_rate)
			{
				$exchange_rates_dropdown[$exchange_rate['currency_code_to']] = $exchange_rate['currency_code_to'];
			}
		
			$exchange_data['specific_input_data'] = $exchange_rates_dropdown;
			
			
			$input_params = array(
				array('view' => 'date_range', 'with_time' => TRUE),
				array('view' => 'dropdown','dropdown_label' =>lang('reports_sale_type'),'dropdown_name' => 'sale_type','dropdown_options' =>array('all' => lang('reports_all'), 'sales' => lang('reports_sales'), 'returns' => lang('reports_returns')),'dropdown_selected_value' => 'all'),
				$exchange_data,
				$register_input_data_entry,
				array('view' => 'checkbox','checkbox_label' => lang('reports_show_summary_only'), 'checkbox_name' => 'show_summary_only'),
				array('view' => 'text', 'name' => 'email', 'label' => lang('email'), 'default' => ''),
				array('view' => 'excel_export'),
				array('view' => 'locations'),
				array('view' => 'submit'),
			);
			
			if (count($tiers_phppos))
			{
				array_unshift($input_params,$tier_entity_data);
			}
		}
		
		$input_data['input_report_title'] = lang('reports_report_options');
		$input_data['input_params'] = $input_params;
		return $input_data;
	}
	
	function getOutputData()
	{
		$this->load->model('Sale');			
		$this->load->model('Category');
		
		$this->setupDefaultPagination();
		
		$headers = $this->getDataColumns();
		
		$report_data = $this->getData();
		$tier_count = $this->Tier->count_all();
		//  dd($report_data );
		$location_count = $this->Location->count_all();
		$summary_data = array();
		$owner_have_to_pay_to_sp = 0 ;
		$owner_have_to_pay_for_parts =0;
		$net_amount_for_owner =0;

		foreach($this->params['export_excel'] == 1 && isset($report_data['summary']) ? $report_data['summary']:$report_data as $key=>$row)
		{
			$summary_data_row = array();

			$link = site_url('reports/generate/specific_customer?report_type=complex&start_date='.$this->params['start_date'].'&start_date_formatted='.date(get_date_format().' '.get_time_format(), strtotime($this->params['start_date'])).'&end_date='.$this->params['end_date'].'&end_date_formatted='.date(get_date_format().' '.get_time_format(), strtotime($this->params['end_date'])).'&customer_id='.$row['customer_id'].'&sale_type=all&export_excel=0');
			
			$summary_data_row[] = array('data'=>anchor('sales/receipt/'.$row['sale_id'], '<i class="ion-printer"></i>', 
			array('target' => '_blank', 'class'=>'hidden-print')).'<span class="visible-print">'.$row['sale_id'].'</span>'.anchor('sales/edit/'.$row['sale_id'], '<i class="ion-document-text"></i>', 
			array('target' => '_blank')).' '.anchor('sales/edit/'.$row['sale_id'], lang('edit').' '.$row['sale_id'], 
			array('target' => '_blank','class'=>'hidden-print')).'<br />'.anchor('sales/clone_sale/'.$row['sale_id'], lang('clone'), 
			array('target' => '_blank','class'=>'hidden-print')), 'align'=>'left', 'detail_id' => $row['sale_id']);
			
			if ($location_count > 1)
			{
				$summary_data_row[] = array('data'=>$row['location_name'], 'align' => 'left');
			}
			$owner_have_to_pay_to_sp = $owner_have_to_pay_to_sp  +  $row['owner_have_to_pay_to_sp'];
			$owner_have_to_pay_for_parts =$owner_have_to_pay_for_parts +  $row['owner_have_to_pay_for_parts'];
			$net_amount_for_owner =$net_amount_for_owner +  $row['net_amount_for_owner'];
			//i need to update here later

			$summary_data_row[] = array('data'=>date(get_date_format().'-'.get_time_format(), strtotime($row['sale_time'])), 'align'=>'left');
			$summary_data_row[] = array('data'=>$row['register_name'], 'align'=>'left');
			$summary_data_row[] = array('data'=>to_quantity($row['items_purchased']), 'align'=>'left');
			$summary_data_row[] = array('data'=>$row['employee_name'].($row['sold_by_employee'] && $row['sold_by_employee'] != $row['employee_name'] ? '/'. $row['sold_by_employee']: ''), 'align'=>'left');
			$summary_data_row[] = array('data'=>'<a href="'.$link.'" target="_blank">'.$row['customer_name'].(isset($row['account_number']) && $row['account_number'] ? ' ('.$row['account_number'].')' : '').'</a>', 'align'=>'left');
			$summary_data_row[] = array('data'=>$row['customer_email'], 'align'=>'left');
			$summary_data_row[] = array('data'=>$row['customer_phone'], 'align'=>'left');
			$summary_data_row[] = array('data'=>$row['person_id'], 'align'=>'left');
			$summary_data_row[] = array('data'=>to_currency($row['subtotal']), 'align'=>'right');
			$summary_data_row[] = array('data'=>to_currency($row['total']), 'align'=>'right');
			$summary_data_row[] = array('data'=>to_currency($row['net_customer_will_pay']), 'align'=>'right');
			$summary_data_row[] = array('data'=>to_currency($row['customer_will_pay_for_services']), 'align'=>'right');
			$summary_data_row[] = array('data'=>to_currency($row['customer_will_pay_for_parts']), 'align'=>'right');
			$summary_data_row[] = array('data'=>to_currency($row['sp_will_pay_to_owner']), 'align'=>'right');
			$summary_data_row[] = array('data'=>to_currency($row['sp_will_receive_from_customer']), 'align'=>'right');
			$summary_data_row[] = array('data'=>to_currency($row['sp_will_receive_for_his_services']), 'align'=>'right');
			$summary_data_row[] = array('data'=>to_currency($row['owner_have_to_pay_to_sp']), 'align'=>'right');
			$summary_data_row[] = array('data'=>to_currency($row['owner_have_to_pay_for_parts']), 'align'=>'right');
			// $summary_data_row[] = array('data'=>to_currency($row['total_items_having_warranty']), 'align'=>'right');
			// $summary_data_row[] = array('data'=>to_currency($row['total_items_having_nowarranty']), 'align'=>'right');
			$summary_data_row[] = array('data'=>to_currency($row['net_amount_for_owner']), 'align'=>'right');
			$summary_data_row[] = array('data'=>to_currency($row['net_amount_sp']), 'align'=>'right');
			if ($this->config->item('enable_tips'))
			{
				$summary_data_row[] = array('data'=>to_currency($row['tip']), 'align'=>'right');
			}
			$summary_data_row[] = array('data'=>to_currency($row['tax']), 'align'=>'right');
			$summary_data_row[] = array('data'=>to_currency($row['non_taxable']), 'align'=>'right');
			
			if($this->has_profit_permission)
			{
				$summary_data_row[] = array('data'=>to_currency($row['profit']), 'align'=>'right');
				$summary_data_row[] = array('data'=>to_currency($row['subtotal'] - $row['profit']), 'align'=>'right');
			}
			
			$summary_data_row[] = array('data'=>$row['payment_type'], 'align'=>'right');
			$summary_data_row[] = array('data'=>$row['comment'], 'align'=>'right');
			$summary_data_row[] = array('data'=>$row['discount_reason'], 'align'=>'right');
			
			if ($tier_count)
			{
				$summary_data_row[] = array('data'=>$row['tier_name'], 'align'=>'right');
			}
			
		  for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) 
			{
				$custom_field = $this->Sale->get_custom_field($k);
				if($custom_field !== FALSE)
				{
					if ($this->Sale->get_custom_field($k,'type') == 'checkbox')
					{
						$format_function = 'boolean_as_string';
					}
					elseif($this->Sale->get_custom_field($k,'type') == 'date')
					{
						$format_function = 'date_as_display_date';				
					}
					elseif($this->Sale->get_custom_field($k,'type') == 'email')
					{
						$format_function = 'strsame';					
					}
					elseif($this->Sale->get_custom_field($k,'type') == 'url')
					{
						$format_function = 'strsame';					
					}
					elseif($this->Sale->get_custom_field($k,'type') == 'phone')
					{
						$format_function = 'strsame';					
					}
					elseif($this->Sale->get_custom_field($k,'type') == 'image')
					{
						$this->load->helper('url');
						$format_function = 'file_id_to_image_thumb';					
					}
					elseif($this->Sale->get_custom_field($k,'type') == 'file')
					{
						$this->load->helper('url');
						$format_function = 'file_id_to_download_link';					
					}
					else
					{
						$format_function = 'strsame';
					}
					
					$summary_data_row[] = array('data'=>$format_function($row["custom_field_${k}_value"]), 'align'=>'right');					
				}
			}
			
			if($this->params['export_excel'] == 1)
			{
				$summary_data[$key] = gzencode(json_encode($summary_data_row));
			}
			else
			{
				$summary_data[$key] = $summary_data_row;
			}
			if($this->params['export_excel'] == 1)
			{
				if(isset($report_data['details'][$key])):
				foreach($report_data['details'][$key] as $drow)
				{
					// dd($report_data['details']);
					$details_data_row = array();
					
					$details_data_row[] = array('data'=>$drow['item_id'], 'align'=>'left');
					$details_data_row[] = array('data'=>$drow['item_number'], 'align'=>'left');
					$details_data_row[] = array('data'=>$drow['item_product_id'], 'align'=>'left');
					$details_data_row[] = array('data'=>$drow['item_name'], 'align'=>'left');
					$details_data_row[] = array('data'=>$this->Category->get_full_path($drow['category_id']), 'align'=>'left');
					$details_data_row[] = array('data'=>$drow['size'], 'align'=>'left');
					$details_data_row[] = array('data'=>$drow['supplier_name']. ' ('.$drow['supplier_id'].')', 'align'=>'left');
					$details_data_row[] = array('data'=>$drow['manufacturer'], 'align'=>'left');
					$details_data_row[] = array('data'=>$drow['serialnumber'], 'align'=>'left');
					$details_data_row[] = array('data'=>character_limiter($drow['description'],150), 'align'=>'left');
					$details_data_row[] = array('data'=>to_currency($drow['unit_price']), 'align'=>'left');
					$details_data_row[] = array('data'=>to_quantity($drow['quantity_purchased']), 'align'=>'left');
					$details_data_row[] = array('data'=>($drow['unit_quantity']), 'align'=>'left');
					$details_data_row[] = array('data'=>to_currency($drow['subtotal']), 'align'=>'right');
					$details_data_row[] = array('data'=>to_currency($drow['total']), 'align'=>'right');
					
					
					if($this->has_profit_permission)
					{
						$details_data_row[] = array('data'=>to_currency($drow['profit']), 'align'=>'right');					
						$details_data_row[] = array('data'=>to_currency($drow['subtotal'] - $drow['profit']), 'align'=>'right');					
					}
					
					$details_data_row[] = array('data'=>$drow['discount_percent'].'%', 'align'=>'left');
					
	    			  for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) 
	    				{
	    					$custom_field = $this->Item->get_custom_field($k);
	    					if($custom_field !== FALSE)
	    					{
	    						if ($this->Item->get_custom_field($k,'type') == 'checkbox')
	    						{
	    							$format_function = 'boolean_as_string';
	    						}
	    						elseif($this->Item->get_custom_field($k,'type') == 'date')
	    						{
	    							$format_function = 'date_as_display_date';				
	    						}
	    						elseif($this->Item->get_custom_field($k,'type') == 'email')
	    						{
	    							$format_function = 'strsame';					
	    						}
	    						elseif($this->Item->get_custom_field($k,'type') == 'url')
	    						{
	    							$format_function = 'strsame';					
	    						}
	    						elseif($this->Item->get_custom_field($k,'type') == 'phone')
	    						{
	    							$format_function = 'strsame';					
	    						}
	    						elseif($this->Item->get_custom_field($k,'type') == 'image')
	    						{
	    							$this->load->helper('url');
	    							$format_function = 'file_id_to_image_thumb';					
	    						}
	    						elseif($this->Item->get_custom_field($k,'type') == 'file')
	    						{
	    							$this->load->helper('url');
	    							$format_function = 'file_id_to_download_link';					
	    						}
	    						else
	    						{
	    							$format_function = 'strsame';
	    						}
				
	    						$details_data_row[] = array('data'=>$format_function($drow["custom_field_${k}_value"]), 'align'=>'right');					
	    					}
	    				}				
					
					$details_data[$key][] = gzencode(json_encode($details_data_row));
				}
			endif;
			
			}
		
		}
		$sumarry_data = $this->getSummaryData();
		$sumarry_data['owner_have_to_pay_to_sp']  =  $owner_have_to_pay_to_sp;
		$sumarry_data['owner_have_to_pay_for_parts']  = $owner_have_to_pay_for_parts;
		$sumarry_data['net_amount_for_owner']  = $net_amount_for_owner ;

// dd($sumarry_data);
		if(isset($this->params['show_summary_only']) && $this->params['show_summary_only'])
		{
			$data = array(
				'view' => 'tabular',
				"title" =>lang('reports_detailed_sales_report'),
				"subtitle" => date(get_date_format(), strtotime($this->params['start_date'])) .'-'.date(get_date_format(), strtotime($this->params['end_date'])),
				"headers" => $this->getDataColumns(),
				"data" => $summary_data,
				"summary_data" => $sumarry_data,
				"export_excel" => $this->params['export_excel'],
				"pagination" => $this->pagination->create_links()
			);
			
			if ($this->params['export_excel'] == 1)
			{
				$rows = array();
				$row = array();
				foreach ($headers as $header) 
				{
					$row[] = strip_tags($header['data']);
				}
	
				//headers are not gzencoded so we must do this
				$rows[] = gzencode(json_encode($row));
	
				foreach($summary_data as $gz_datarow)
				{
					$datarow = json_decode(gzdecode($gz_datarow), TRUE);
					
					$row = array();
					foreach($datarow as $cell)
					{
						$row[] = str_replace('<span style="white-space:nowrap;">-</span>', '-', strip_tags($cell['data']));
					}
					$rows[] = gzencode(json_encode($row));
				}
				$this->load->helper('spreadsheet');
				array_to_spreadsheet_gz_json_encoded($rows, strip_tags($data['title']) . '.'.($this->config->item('spreadsheet_format') == 'XLSX' ? 'xlsx' : 'csv'), true, isset($this->params['email']) ? $this->params['email'] : NULL);
				exit();
			}
			
			
		}
		else
		{
			$data = array(
				'view' => 'tabular_details_lazy_load',
				"title" =>lang('reports_detailed_sales_report'),
				"subtitle" => date(get_date_format(), strtotime($this->params['start_date'])) .'-'.date(get_date_format(), strtotime($this->params['end_date'])),
				"headers" => $this->getDataColumns(),
				"summary_data" => $summary_data,
				"overall_summary_data" => $sumarry_data,
				"export_excel" => $this->params['export_excel'],
				"pagination" => $this->pagination->create_links(),
				"report_model" => get_class($this),
			);
		}
		isset($details_data) && !empty($details_data) ? $data["details_data"]=$details_data: '' ;
			
		if ($this->params['export_excel'] == 1)
		{
			
			if (!$this->config->item('legacy_detailed_report_export'))
			{
				$rows = array();
	
				$row = array();
		
				if (!empty($details_data))
				{
					foreach ($headers['details'] as $header) 
					{
						$row[] = strip_tags($header['data']);
					}
				}
				foreach ($headers['summary'] as $header) 
				{
					$row[] = strip_tags($header['data']);
				}
				
				//headers are not gzencoded so we must do this
				$rows[] = gzencode(json_encode($row));
	
				foreach ($summary_data as $key=>$gz_encoded_row) 
				{		
					$datarow = json_decode(gzdecode($gz_encoded_row), TRUE);
					
					if(isset($details_data[$key])) 
					{
						foreach($details_data[$key] as $gz_datarow2)
						{
							$datarow2 = json_decode(gzdecode($gz_datarow2), TRUE);
							$row = array();
							foreach($datarow2 as $cell)
							{
								$row[] = str_replace('<span style="white-space:nowrap;">-</span>', '-', strip_tags($cell['data']));				
							}
			
							foreach($datarow as $cell)
							{
								$row[] = str_replace('<span style="white-space:nowrap;">-</span>', '-', strip_tags($cell['data']));
							}
							$rows[] = gzencode(json_encode($row));
						}
					}
					else
					{
						$row = array();
						if (!empty($details_data))
						{
							foreach ($headers['details'] as $empty_row) 
							{
								$row[]=lang('na');
							}	
						}
						foreach($datarow as $cell)
						{
							$row[] = str_replace('<span style="white-space:nowrap;">-</span>', '-', strip_tags($cell['data']));
						}
						$rows[] = gzencode(json_encode($row));
					}		
				}
			}
			else
			{
				$rows = array();
				$row = array();
				foreach ($headers['summary'] as $header) 
				{
					$row[] = strip_tags($header['data']);
				}
				//headers are not gzencoded so we must do this
				$rows[] = gzencode(json_encode($row));
	
				foreach ($summary_data as $key=>$gz_encoded_row) 
				{
					$datarow = json_decode(gzdecode($gz_encoded_row), TRUE);
					
					$row = array();
					foreach($datarow as $cell)
					{
						$row[] = str_replace('<span style="white-space:nowrap;">-</span>', '-', strip_tags($cell['data']));			
					}
		
					$rows[] = gzencode(json_encode($row));

					$row = array();
					foreach ($headers['details'] as $header) 
					{
						$row[] = strip_tags($header['data']);
					}
		
					$rows[] = gzencode(json_encode($row));
		
					if(isset($details_data[$key]))
					{
						foreach($details_data[$key] as $gz_datarow2)
						{
							$datarow2 = json_decode(gzdecode($gz_datarow2), TRUE);
							$row = array();
							foreach($datarow2 as $cell)
							{
								$row[] = str_replace('<span style="white-space:nowrap;">-</span>', '-', strip_tags($cell['data']));				
							}
							$rows[] = gzencode(json_encode($row));
						}
					}
				}
				
			}
			$this->load->helper('spreadsheet');
			array_to_spreadsheet_gz_json_encoded($rows, strip_tags($data['title']) . '.'.($this->config->item('spreadsheet_format') == 'XLSX' ? 'xlsx' : 'csv'), true, isset($this->params['email']) ? $this->params['email'] : NULL);
			exit();
		}	
		return $data;
	}
	
	
	public function getDataColumns()
	{
		$return = array();
		
		$return['summary'] = array();
		$location_count = $this->Location->count_all();
		
		$return['summary'][] = array('data'=>lang('reports_sale_id'), 'align'=> 'left');
		if ($location_count > 1)
		{
			$return['summary'][] = array('data'=>lang('location'), 'align'=> 'left');
		}
		$return['summary'][] = array('data'=>lang('reports_date'), 'align'=> 'left');
		$return['summary'][] = array('data'=>lang('reports_register'), 'align'=> 'left');
		$return['summary'][] = array('data'=>lang('items_purchased'), 'align'=> 'left');
		$return['summary'][] = array('data'=>lang('reports_sold_by'), 'align'=> 'left');
		$return['summary'][] = array('data'=>lang('reports_sold_to'), 'align'=> 'left');		
		$return['summary'][] = array('data'=>lang('email'), 'align'=> 'left');		
		$return['summary'][] = array('data'=>lang('phone_number'), 'align'=> 'left');		
		$return['summary'][] = array('data'=>lang('person_id'), 'align'=> 'left');		
		$return['summary'][] = array('data'=>lang('reports_subtotal'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('reports_total'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('net_customer_will_pay'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('customer_will_pay_for_services'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('customer_will_pay_for_parts'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('sp_will_pay_to_owner'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('sp_will_receive_from_customer'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('sp_will_receive_for_his_services'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('owner_have_to_pay_to_sp'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('owner_have_to_pay_for_parts'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('net_amount_for_owner'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('net_amount_sp'), 'align'=> 'right');
		if ($this->config->item('enable_tips'))
		{
			$return['summary'][] = array('data'=>lang('tip'), 'align'=> 'right');
		}
		$return['summary'][] = array('data'=>lang('tax'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('reports_non_taxable'), 'align'=> 'right');
				
		if($this->has_profit_permission)
		{
			$return['summary'][] = array('data'=>lang('profit'), 'align'=> 'right');
			$return['summary'][] = array('data'=>lang('cogs'), 'align'=> 'right');
		}
		$return['summary'][] = array('data'=>lang('reports_payment_type'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('reports_comments'), 'align'=> 'right');
		$return['summary'][] = array('data'=>lang('discount_reason'), 'align'=> 'right');
		
		$tier_count = $this->Tier->count_all();
		if ($tier_count)
		{
			$return['summary'][] = array('data'=>lang('tier_name'), 'align'=> 'right');
		}
		
	  for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) 
		{
			$this->load->model('Sale');
			$custom_field = $this->Sale->get_custom_field($k);
			if($custom_field !== FALSE)
			{
				$return['summary'][] = array('data'=>$custom_field, 'align'=> 'right');
			}
		}
		
		if(isset($this->params['show_summary_only']) && $this->params['show_summary_only'])
		{
			return $return['summary'];
		}
		
		$return['details'] = $this->get_details_data_columns_sales();
		return $return;
	}
	
	public function getData()
	{	
		$this->db->save_queries = TRUE;	
		$this->db->select('sales.customer_id as person_id,customer.email as customer_email,customer.phone_number as customer_phone,sales.tip as tip,sales.custom_field_1_value,sales.custom_field_2_value,sales.custom_field_3_value,sales.custom_field_4_value,sales.custom_field_5_value,sales.custom_field_6_value,sales.custom_field_7_value,sales.custom_field_8_value,sales.custom_field_9_value,sales.custom_field_10_value,price_tiers.name as tier_name,locations.name as location_name, sale_id, sale_time, date(sale_time) as sale_date, registers.name as register_name, total_quantity_purchased as items_purchased, CONCAT(sold_by_employee.first_name," ",sold_by_employee.last_name) as sold_by_employee, CONCAT(sold_by_employee.first_name," ",sold_by_employee.last_name) as sold_by_employee, CONCAT(employee.first_name," ",employee.last_name) as employee_name, customer.person_id as customer_id, CONCAT(customer.first_name," ",customer.last_name) as customer_name, customer_data.account_number as account_number,subtotal as subtotal, total as total, tax as tax, non_taxable as non_taxable,profit as profit, payment_type, comment, discount_reason

		
		', false);
		$this->db->from('sales');
		$this->db->join('locations', 'sales.location_id = locations.location_id');
		$this->db->join('registers', 'sales.register_id = registers.register_id', 'left');
		$this->db->join('price_tiers', 'sales.tier_id = price_tiers.id', 'left');
		$this->db->join('people as employee', 'sales.employee_id = employee.person_id');
		$this->db->join('people as sold_by_employee', 'sales.sold_by_employee_id = sold_by_employee.person_id', 'left');
		$this->db->join('people as customer', 'sales.customer_id = customer.person_id', 'left');
		$this->db->join('customers as customer_data', 'sales.customer_id = customer_data.person_id', 'left');
		
		if (isset($this->params['company']) && $this->params['company'] && $this->params['company'] !='All')
		{
			$this->db->where('locations.company',$this->params['company']);
		}
		if (isset($this->params['business_type']) && $this->params['business_type'] && $this->params['business_type'] !='All')
		{
			$this->db->where('locations.business_type',$this->params['business_type']);
		}
		if (isset($this->params['register_id']) && $this->params['register_id'])
		{
			$this->db->where('sales.register_id',$this->params['register_id']);
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
		
		
		
		if (isset($this->params['currency']) && $this->params['currency'] !== '')
		{
			if ($this->params['currency'] == '0')
			{
				$this->db->where('sales.exchange_name = ""');
			}
			else
			{
				$this->db->where('sales.exchange_name',$this->params['currency']);
			}
		}
		if (isset($this->params['status']))
		{
			$prefix = $this->db->dbprefix;
			$this->db->where('(select '.$prefix.'sales_work_orders.status from '.$prefix.'sales_work_orders where '.$prefix.'sales_work_orders.sale_id='.$prefix.'sales.sale_id order by '.$prefix.'sales_work_orders.id desc limit 1 )  ='  .$this->params['status'] );
		}
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('sales.total_quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('sales.total_quantity_purchased < 0');
		}
		
		$this->sale_time_where();
		$this->db->where('sales.deleted', 0);
		$this->db->where('sales.is_work_order' , 1);
		$this->db->order_by('sale_time', ($this->config->item('report_sort_order')) ? $this->config->item('report_sort_order') : 'asc');
		
		//If we are exporting NOT exporting to excel make sure to use offset and limit
		if (isset($this->params['export_excel']) && !$this->params['export_excel'])
		{
			
			$this->db->limit($this->report_limit);
			if (isset($this->params['offset']))
			{
				$this->db->offset($this->params['offset']);
			}
			$result = $this->db->get()->result_array(); 
			
			if($result){
				$prefix = $this->db->dbprefix;
				$total_items_having_nowarranty =0 ;
				$total_items_having_warranty =0 ;
				foreach($result  as $key => $res){
					$result[$key]['net_customer_will_pay'] =0 ;
					$result[$key]['customer_will_pay_for_services'] =0 ;
					$result[$key]['customer_will_pay_for_parts'] =0 ;
					$result[$key]['sp_will_pay_to_owner']=0;
					$result[$key]['sp_will_receive_from_customer']=0;
					$result[$key]['sp_will_receive_for_his_services']=0;
					$result[$key]['owner_have_to_pay_to_sp']=0;
					$result[$key]['owner_have_to_pay_for_parts']=0;
					$result[$key]['net_amount_for_owner']=0;
					$result[$key]['net_amount_sp']=0 ;


				

					  	$result[$key]['total_amount_for_repair_item_without_serial_number'] = 	get_query_data('SELECT COUNT(si.total) as tot FROM `' . $prefix .'sales_items` as si where si.sale_id='.$res['sale_id'].' and si.is_repair_item=1')[0]->tot;
						$result[$key]['total_amount_for_non_repair_item_without_serial_number'] = 	get_query_data('SELECT COUNT(si.total) as tot FROM `' . $prefix .'sales_items` as si where si.sale_id='.$res['sale_id'].' and si.is_repair_item=0')[0]->tot;
						$items_having_warranty = get_query_data('SELECT si.* , isn.unit_price   FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items_serial_numbers as isn on isn.item_id= si.item_id and isn.serial_number = si.serialnumber  where si.sale_id='.$res['sale_id'].' and si.is_repair_item=1 and isn.is_sold=1 and (
							(isn.replace_sale_date = 1 and	isn.warranty_end > STR_TO_DATE('.$res['sale_date'].', "%Y-%m-%d"))
							or
						(isn.replace_sale_date != 1 and isn.sold_warranty_end > STR_TO_DATE('.$res['sale_date'].', "%Y-%m-%d") )
						) ');

						// dd($this->db->last_query());
						
						

						$result[$key]['items_having_warranty'] = $items_having_warranty;
						if($items_having_warranty){
							
							foreach($items_having_warranty as $ihw){

								$result[$key]['items_having_warranty_sub'] = 	get_query_data('SELECT si.* , i.is_service , isn.unit_price   FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items as i on i.item_id=si.item_id left join ' . $prefix .'items_serial_numbers as isn on isn.item_id= si.item_id and isn.serial_number = si.serialnumber where si.sale_id='.$res['sale_id'].' and si.is_repair_item=0   and si.assigned_repair_item = '.$ihw->item_id.' ');
								if($result[$key]['items_having_warranty_sub']){
								if(count($result[$key]['items_having_warranty_sub']) > 0){
									foreach($result[$key]['items_having_warranty_sub'] as $item){
										if($item->is_service){
											$result[$key]['sp_will_receive_for_his_services']=  $result[$key]['sp_will_receive_for_his_services'] + ($item->unit_price)?$item->unit_price * $item->quantity_purchased:$item->total;
											$result[$key]['owner_have_to_pay_to_sp']=$result[$key]['owner_have_to_pay_to_sp']=($item->unit_price)?$item->unit_price * $item->quantity_purchased:$item->total;
										}else{
											$result[$key]['owner_have_to_pay_for_parts'] =  $result[$key]['owner_have_to_pay_for_parts'] + ($item->unit_price)?$item->unit_price * $item->quantity_purchased :$item->total;
										}
									}
								}
							}
							}
							$total_items_having_warranty =  $total_items_having_warranty + 1; 
						}
						$items_having_nowarranty = get_query_data('SELECT si.* , isn.unit_price   FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items_serial_numbers as isn on isn.item_id= si.item_id and isn.serial_number = si.serialnumber  where si.sale_id='.$res['sale_id'].' and si.is_repair_item=1 and isn.is_sold=1 and and (
							(isn.replace_sale_date = 1 and	isn.warranty_end < STR_TO_DATE('.$res['sale_date'].', "%Y-%m-%d"))
							or
						(isn.replace_sale_date != 1 and isn.sold_warranty_end < STR_TO_DATE('.$res['sale_date'].', "%Y-%m-%d") )
						) ');
						$result[$key]['items_having_nowarranty'] = $items_having_nowarranty;

						if($items_having_nowarranty){
							foreach($items_having_nowarranty as $ihw){
								
								$result[$key]['items_having_not_warranty_sub'] = 	get_query_data('SELECT si.* , i.is_service , isn.unit_price   FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items as i on i.item_id=si.item_id left join ' . $prefix .'items_serial_numbers as isn on isn.item_id= si.item_id and isn.serial_number = si.serialnumber where si.sale_id='.$res['sale_id'].' and si.is_repair_item=0   and si.assigned_repair_item = '.$ihw->item_id.' ');
								if($result[$key]['items_having_not_warranty_sub'] ){
								if(count($result[$key]['items_having_not_warranty_sub']) > 0){
									foreach($result[$key]['items_having_not_warranty_sub'] as $item){
										$amount = ($item->unit_price)?$item->unit_price * $item->quantity_purchased:$item->total;
										if($item->is_service){
											
											$result[$key]['sp_will_receive_for_his_services']=  $result[$key]['sp_will_receive_for_his_services'] + $amount;
											$result[$key]['customer_will_pay_for_services']=$result[$key]['customer_will_pay_for_services'] + $amount;
											$result[$key]['sp_will_receive_from_customer']=$result[$key]['sp_will_receive_from_customer'] + $amount;
										}else{
									
											$result[$key]['customer_will_pay_for_parts']=  $result[$key]['customer_will_pay_for_parts'] +   $amount;
											$result[$key]['sp_will_pay_to_owner']=  $result[$key]['sp_will_pay_to_owner']  + $amount;
											$result[$key]['sp_will_receive_from_customer']=$result[$key]['sp_will_receive_from_customer'] + $amount;
										}
									}
								}
								}
							}
							$total_items_having_nowarranty =  $total_items_having_nowarranty + 1; 
						}
						$no_serial = false;

						if(!$items_having_warranty && !$items_having_nowarranty){
							$report_data['items_having_not_warranty_sub'] = 	get_query_data('SELECT si.* , i.is_service    FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items as i on i.item_id=si.item_id  where si.sale_id='.$res['sale_id'].'    ');

								if($report_data['items_having_not_warranty_sub'] ){
								if(count($report_data['items_having_not_warranty_sub']) > 0){
									$no_serial = true;
									foreach($report_data['items_having_not_warranty_sub'] as $item){
										// dd($item);
										$amount = ($item->item_unit_price)?$item->item_unit_price * $item->quantity_purchased:$item->total;
										if($item->is_service){
											$result[$key]['sp_will_receive_for_his_services']=  $result[$key]['sp_will_receive_for_his_services'] + $amount;
											$result[$key]['customer_will_pay_for_services']=$result[$key]['customer_will_pay_for_services'] + $amount;
											$result[$key]['sp_will_receive_from_customer']=$result[$key]['sp_will_receive_from_customer'] + $amount;
										}else{
											$result[$key]['customer_will_pay_for_parts']=  $result[$key]['customer_will_pay_for_parts'] +   $amount;
											$result[$key]['sp_will_receive_from_customer']=$result[$key]['sp_will_receive_from_customer'] + $amount;
										}
									}
								}
								}

						}


						$result[$key]['net_customer_will_pay'] = $result[$key]['customer_will_pay_for_services'] + $result[$key]['customer_will_pay_for_parts'] ;
						if(!$no_serial){
							$result[$key]['net_amount_for_owner']= $result[$key]['customer_will_pay_for_parts'] - $result[$key]['owner_have_to_pay_to_sp'];
							$result[$key]['net_amount_sp']= $result[$key]['sp_will_receive_for_his_services'] - $result[$key]['customer_will_pay_for_parts'];
						}else{
							$result[$key]['net_amount_sp']= $result[$key]['sp_will_receive_for_his_services'] + $result[$key]['customer_will_pay_for_parts'];
						}
						
						
						
						$result[$key]['total_items_having_nowarranty']= $total_items_having_nowarranty;
						$result[$key]['total_items_having_warranty']= $total_items_having_nowarranty;


				}
			}
			
			// dd($result);
			return $result;
			
		}
		
		if (isset($this->params['export_excel']) && $this->params['export_excel'] == 1)
		{
			$data=array();
			$data['summary']=array();
			$data['details']=array();
			$prefix = $this->db->dbprefix;
			$total_items_having_warranty = 0;
			$total_items_having_nowarranty = 0;
			foreach($this->db->get()->result_array() as $key => $res)
			{
				$res['net_customer_will_pay'] =0 ;
				$res['customer_will_pay_for_services'] =0 ;
				$res['customer_will_pay_for_parts'] =0 ;
				$res['sp_will_pay_to_owner']=0;
				$res['sp_will_receive_from_customer']=0;
				$res['sp_will_receive_for_his_services']=0;
				$res['owner_have_to_pay_to_sp']=0;
				$res['owner_have_to_pay_for_parts']=0;
				$res['net_amount_for_owner']=0;
				$res['net_amount_sp']=0 ;


			

					  $res['total_amount_for_repair_item_without_serial_number'] = 	get_query_data('SELECT COUNT(si.total) as tot FROM `' . $prefix .'sales_items` as si where si.sale_id='.$res['sale_id'].' and si.is_repair_item=1')[0]->tot;
					$res['total_amount_for_non_repair_item_without_serial_number'] = 	get_query_data('SELECT COUNT(si.total) as tot FROM `' . $prefix .'sales_items` as si where si.sale_id='.$res['sale_id'].' and si.is_repair_item=0')[0]->tot;
					$items_having_warranty = get_query_data('SELECT si.* , isn.unit_price   FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items_serial_numbers as isn on isn.item_id= si.item_id and isn.serial_number = si.serialnumber  where si.sale_id='.$res['sale_id'].' and si.is_repair_item=1 and isn.is_sold=1 and (
						(isn.replace_sale_date = 1 and	isn.warranty_end > STR_TO_DATE('.$res['sale_date'].', "%Y-%m-%d"))
						or
					(isn.replace_sale_date != 1 and isn.sold_warranty_end > STR_TO_DATE('.$res['sale_date'].', "%Y-%m-%d") )
					) ');
					
					

					 $res['items_having_warranty'] = $items_having_warranty;
					if($items_having_warranty){
						
						foreach($items_having_warranty as $ihw){

							$items_having_warranty_sub = 	get_query_data('SELECT si.* , i.is_service , isn.unit_price   FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items as i on i.item_id=si.item_id left join ' . $prefix .'items_serial_numbers as isn on isn.item_id= si.item_id and isn.serial_number = si.serialnumber where si.sale_id='.$res['sale_id'].' and si.is_repair_item=0   and si.assigned_repair_item = '.$ihw->item_id.' ');
							if($items_having_warranty_sub){
							if(count($items_having_warranty_sub) > 0){
								foreach($items_having_warranty_sub as $item){
									if($item->is_service){
										$res['sp_will_receive_for_his_services']=  $res['sp_will_receive_for_his_services'] + ($item->unit_price)?$item->unit_price * $item->quantity_purchased:$item->total;
										$res['owner_have_to_pay_to_sp']=$res['owner_have_to_pay_to_sp']=($item->unit_price)?$item->unit_price * $item->quantity_purchased:$item->total;
									}else{
										$res['owner_have_to_pay_for_parts'] =  $res['owner_have_to_pay_for_parts'] + ($item->unit_price)?$item->unit_price * $item->quantity_purchased :$item->total;
									}
								}
							}
						}
						}
						$total_items_having_warranty =  $total_items_having_warranty + 1; 

					}
					$items_having_nowarranty = get_query_data('SELECT si.* , isn.unit_price   FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items_serial_numbers as isn on isn.item_id= si.item_id and isn.serial_number = si.serialnumber  where si.sale_id='.$res['sale_id'].' and si.is_repair_item=1 and isn.is_sold=1 and (
						(isn.replace_sale_date = 1 and	isn.warranty_end < STR_TO_DATE('.$res['sale_date'].', "%Y-%m-%d"))
						or
					(isn.replace_sale_date != 1 and isn.sold_warranty_end < STR_TO_DATE('.$res['sale_date'].', "%Y-%m-%d") )
					) ');
					$res['items_having_nowarranty'] = $items_having_nowarranty;

					if($items_having_nowarranty){
						foreach($items_having_nowarranty as $ihw){
							
							$items_having_not_warranty_sub = 	get_query_data('SELECT si.* , i.is_service , isn.unit_price   FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items as i on i.item_id=si.item_id left join ' . $prefix .'items_serial_numbers as isn on isn.item_id= si.item_id and isn.serial_number = si.serialnumber where si.sale_id='.$res['sale_id'].' and si.is_repair_item=0   and si.assigned_repair_item = '.$ihw->item_id.' ');
							if($items_having_not_warranty_sub  ){
							if(count($items_having_not_warranty_sub ) > 0){
								foreach($items_having_not_warranty_sub  as $item){
									$amount = ($item->unit_price)?$item->unit_price * $item->quantity_purchased:$item->total;
									if($item->is_service){
									
										$res['sp_will_receive_for_his_services']=  $res['sp_will_receive_for_his_services'] + $amount;
										$res['customer_will_pay_for_services']=$res['customer_will_pay_for_services'] + $amount;
										$res['sp_will_receive_from_customer']=$res['sp_will_receive_from_customer'] + $amount;
									}else{
										
										$res['customer_will_pay_for_parts']=  $res['customer_will_pay_for_parts'] +   $amount;
										$res['sp_will_pay_to_owner']=  $res['sp_will_pay_to_owner']  + $amount;
										$res['sp_will_receive_from_customer']=$res['sp_will_receive_from_customer'] + $amount;
									}
								}
							}
							}
						}
						$total_items_having_nowarranty =  $total_items_having_nowarranty + 1; 
					}
					$no_serial = false;
					if(!$items_having_warranty && !$items_having_nowarranty){
						$report_data['items_having_not_warranty_sub'] = 	get_query_data('SELECT si.* , i.is_service    FROM `' . $prefix .'sales_items` as si inner join ' . $prefix .'items as i on i.item_id=si.item_id  where si.sale_id='.$res['sale_id'].'    ');
						
							if($report_data['items_having_not_warranty_sub'] ){
							if(count($report_data['items_having_not_warranty_sub']) > 0){
								$no_serial = true;
								foreach($report_data['items_having_not_warranty_sub'] as $item){
									// dd($item);
									$amount = ($item->item_unit_price)?$item->item_unit_price * $item->quantity_purchased:$item->total;
									if($item->is_service){
										$res['sp_will_receive_for_his_services']=  $res['sp_will_receive_for_his_services'] + $amount;
										$res['customer_will_pay_for_services']=$res['customer_will_pay_for_services'] + $amount;
										$res['sp_will_receive_from_customer']=$res['sp_will_receive_from_customer'] + $amount;
									}else{
										$res['customer_will_pay_for_parts']=  $res['customer_will_pay_for_parts'] +   $amount;
										$res['sp_will_receive_from_customer']=$res['sp_will_receive_from_customer'] + $amount;
									}
									$total_items_having_nowarranty =  $total_items_having_nowarranty + 1; 
								}
							}
							}

					}
			
					$res['net_customer_will_pay'] = $res['customer_will_pay_for_services'] + $res['customer_will_pay_for_parts'] ;
					if(!$no_serial){
						$res['net_amount_for_owner']= $res['customer_will_pay_for_parts'] - $res['owner_have_to_pay_to_sp'];
						$res['net_amount_sp']= $res['sp_will_receive_for_his_services'] - $res['customer_will_pay_for_parts'];
					}else{
						$res['net_amount_sp']= $res['sp_will_receive_for_his_services'] + $res['customer_will_pay_for_parts'];
					}
						
					
					$res['total_items_having_warranty'] = $total_items_having_warranty ;
					$res['total_items_having_nowarranty'] = $total_items_having_nowarranty ;
					$data['summary'][$res['sale_id']] = $res; 
				
				
			}

			  
			$sale_ids = array();
			
			foreach($data['summary'] as $sale_row)
			{
				$sale_ids[] = $sale_row['sale_id'];
			}
			// dd($data['summary']);
			$result = $this->get_report_details($sale_ids,1);
			
			foreach($result  as $key => $sale_item_row)
			{
				
				
				$data['details'][$sale_item_row['sale_id']][] = $sale_item_row;
			}
			
			
			return $data;
			exit;
		}
		
		
	}

	public function getTotalRows()
	{

		$this->db->save_queries = TRUE;
		$this->db->from('sales');
		$this->db->join('locations', 'sales.location_id = locations.location_id');
		if (isset($this->params['company']) && $this->params['company'] && $this->params['company'] !='All')
		{
			$this->db->where('locations.company',$this->params['company']);
		}
		if (isset($this->params['business_type']) && $this->params['business_type'] && $this->params['business_type'] !='All')
		{
			$this->db->where('locations.business_type',$this->params['business_type']);
		}
		if (isset($this->params['register_id']) && $this->params['register_id'])
		{
			$this->db->where('sales.register_id',$this->params['register_id']);
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
		
		if (isset($this->params['currency']) && $this->params['currency'] !== '')
		{
			if ($this->params['currency'] == '0')
			{
				$this->db->where('sales.exchange_name = ""');
			}
			else
			{
				$this->db->where('sales.exchange_name',$this->params['currency']);
			}
		}
		
		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('sales.total_quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('sales.total_quantity_purchased < 0');
		}
		$this->db->where('sales.is_work_order' , 1);
		$this->sale_time_where(true);
		$this->db->where('sales.deleted', 0);
		
		$query = $this->db->get();
		
		if ($query && $query->num_rows() > 0) {
			$query = $this->db->get();
		
		
		if ($query != false && $query->num_rows() > 0) {
			return $query->num_rows(); // Count the number of rows returned by the query
		}else{
			return false;
		}
		}else{
			return 0;
		}	
	}
	public function getSummaryData()
	{
		$this->db->select('sum(non_taxable) as non_taxable,sum(subtotal) as subtotal, sum(total) as total, sum(tax) as tax, sum(profit) as profit', false);
		$this->db->from('sales');
		
		if (isset($this->params['register_id']) && $this->params['register_id'])
		{
			$this->db->where('sales.register_id',$this->params['register_id']);
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
		
		if (isset($this->params['currency']) && $this->params['currency'] !== '')
		{
			if ($this->params['currency'] == '0')
			{
				$this->db->where('sales.exchange_name = ""');
			}
			else
			{
				$this->db->where('sales.exchange_name',$this->params['currency']);
			}
		}

		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('sales.total_quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('sales.total_quantity_purchased < 0');
		}
		
		if ($this->config->item('hide_store_account_payments_from_report_totals'))
		{
			$this->db->where('sales.store_account_payment', 0);
		}
		
		$this->db->where('sales.is_work_order' , 1);
		$this->sale_time_where(true);
		$this->db->where('sales.deleted', 0);
		
		$return = array(
			'subtotal' => 0,
			'total' => 0,
			'tax' => 0,
			'non_taxable' => 0,
			'profit' => 0,
			'cogs' => 0,
		);
		
		foreach($this->db->get()->result_array() as $row)
		{
			$return['subtotal'] += to_currency_no_money($row['subtotal'],2);
			$return['total'] += to_currency_no_money($row['total'],2);
			$return['tax'] += to_currency_no_money($row['tax'],2);
			$return['non_taxable'] += to_currency_no_money($row['non_taxable'],2);
			$return['profit'] += to_currency_no_money($row['profit'],2);
			$return['cogs'] += to_currency_no_money($row['subtotal']-$row['profit'],2);
		}
		$custom_sum =  $this->get_custom_summary();
		$return['items_having_warranty'] = $custom_sum['items_having_warranty'];
		$return['items_having_no_warranty'] = $custom_sum['items_having_nowarranty'];
	


		
		if(!$this->has_profit_permission)
		{
			unset($return['profit']);
			unset($return['cogs']);
		}
		return $return;
	}

	function get_custom_summary(){
		$return['items_having_warranty']=0;
		$return['items_having_nowarranty']=0;
		$this->db->save_queries = TRUE;

		$prefix = $this->db->dbprefix;
		$this->db->select('count(si.item_id) as items_having_warranty', false);
		$this->db->from('sales_items as si');
		$this->db->join('sales' , 'sales.sale_id = si.sale_id ');
		$this->db->join('items_serial_numbers as isn' , 'isn.item_id= si.item_id and isn.serial_number = si.serialnumber');

		if (isset($this->params['register_id']) && $this->params['register_id'])
		{
			$this->db->where('sales.register_id',$this->params['register_id']);
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
		
		if (isset($this->params['currency']) && $this->params['currency'] !== '')
		{
			if ($this->params['currency'] == '0')
			{
				$this->db->where('sales.exchange_name = ""');
			}
			else
			{
				$this->db->where('sales.exchange_name',$this->params['currency']);
			}
		}

		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('sales.total_quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('sales.total_quantity_purchased < 0');
		}
		
		if ($this->config->item('hide_store_account_payments_from_report_totals'))
		{
			$this->db->where('sales.store_account_payment', 0);
		}
		
		$this->db->where('sales.is_work_order' , 1);
		$this->db->where('si.is_repair_item' , 1);
		$this->db->where('isn.is_sold' , 1);
			$this->db->where('(  (`isn`.`replace_sale_date` = 1 AND `isn`.`warranty_end` > STR_TO_DATE('.$prefix.'sales.sale_time, "%Y-%m-%d"))
			   OR (
				   `isn`.`replace_sale_date` != 1 AND `isn`.`sold_warranty_end` > STR_TO_DATE('.$prefix.'sales.sale_time, "%Y-%m-%d")) 
				  )');
		



		$this->sale_time_where(true);
		$this->db->where('sales.deleted', 0);

		$return['items_having_warranty']=$this->db->get()->result_array()[0]['items_having_warranty'];
		

		$this->db->select('count(si.item_id) as items_having_nowarranty', false);
		$this->db->from('sales_items as si');
		$this->db->join('sales' , 'sales.sale_id = si.sale_id ');
		$this->db->join('items_serial_numbers as isn' , 'isn.item_id= si.item_id and isn.serial_number = si.serialnumber');

		if (isset($this->params['register_id']) && $this->params['register_id'])
		{
			$this->db->where('sales.register_id',$this->params['register_id']);
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
		
		if (isset($this->params['currency']) && $this->params['currency'] !== '')
		{
			if ($this->params['currency'] == '0')
			{
				$this->db->where('sales.exchange_name = ""');
			}
			else
			{
				$this->db->where('sales.exchange_name',$this->params['currency']);
			}
		}

		if ($this->params['sale_type'] == 'sales')
		{
			$this->db->where('sales.total_quantity_purchased > 0');
		}
		elseif ($this->params['sale_type'] == 'returns')
		{
			$this->db->where('sales.total_quantity_purchased < 0');
		}
		
		if ($this->config->item('hide_store_account_payments_from_report_totals'))
		{
			$this->db->where('sales.store_account_payment', 0);
		}
		
		$this->db->where('sales.is_work_order' , 1);
		$this->db->where('si.is_repair_item' , 1);
		$this->db->where('isn.is_sold' , 1);
		$this->db->where('(  (`isn`.`replace_sale_date` = 1 AND `isn`.`warranty_end` < STR_TO_DATE('.$prefix.'sales.sale_time, "%Y-%m-%d"))
		OR (
			`isn`.`replace_sale_date` != 1 AND `isn`.`sold_warranty_end` < STR_TO_DATE('.$prefix.'sales.sale_time, "%Y-%m-%d")) 
		   )');

		$this->sale_time_where(true);
		$this->db->where('sales.deleted', 0);

		$return['items_having_nowarranty']=$this->db->get()->result_array()[0]['items_having_nowarranty'];
		return $return;


	}
	
	
	
	function get_details_data_columns_sales()
	{
		$details = array();
		$details[] = array('data'=>lang('item_id'), 'align'=> 'left');
		$details[] = array('data'=>lang('item_number'), 'align'=> 'left');
		$details[] = array('data'=>lang('product_id'), 'align'=> 'left');
		$details[] = array('data'=>lang('reports_name'), 'align'=> 'left');
		$details[] = array('data'=>lang('reports_category'), 'align'=> 'left');
		$details[] = array('data'=>lang('size'), 'align'=> 'left');
		$details[] = array('data'=>lang('supplier'), 'align'=> 'left');
		$details[] = array('data'=>lang('manufacturer'), 'align'=> 'left');
		$details[] = array('data'=>lang('reports_serial_number'), 'align'=> 'left');
		if (!$this->config->item('hide_item_descriptions_in_reports') || (isset($this->params['export_excel']) && $this->params['export_excel']))
		{
			$details[] = array('data'=>lang('reports_description'), 'align'=> 'left');
		}
		
		$details[] = array('data'=>lang('unit_price'), 'align'=> 'left');
		
		$details[] = array('data'=>lang('reports_quantity_purchased'), 'align'=> 'left');
		$details[] = array('data'=>lang('quantity_units'), 'align'=> 'left');
		$details[] = array('data'=>lang('reports_subtotal'), 'align'=> 'right');
		$details[] = array('data'=>lang('reports_total'), 'align'=> 'right');
		

		$details[] = array('data'=>lang('tax'), 'align'=> 'right');
		if($this->has_profit_permission)
		{
			$details[] = array('data'=>lang('profit'), 'align'=> 'right');			
			$details[] = array('data'=>lang('cogs'), 'align'=> 'right');			
		}
		
		
		if (strpos($this->report_key, 'commission') !== false)
		{
			$details[] = array('data'=>lang('reports_commission'), 'align'=> 'right');			
		}
		
		$details[] = array('data'=>lang('discount'), 'align'=> 'right');
		
		for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) 
		{
			$this->load->model('Item');
			$this->load->model('Item_kit');
			$custom_field = $this->Item->get_custom_field($k);
			$custom_field_item_kit = $this->Item_kit->get_custom_field($k);

			if($custom_field !== FALSE && $custom_field_item_kit !== FALSE)
			{
				if($custom_field == $custom_field_item_kit){
					$details[] = array('data'=>$custom_field, 'align'=> 'right');
				}else{
					$details[] = array('data'=>$custom_field.' / '.$custom_field_item_kit, 'align'=> 'right');
				}
			}else if($custom_field !== FALSE){
				$details[] = array('data'=>$custom_field, 'align'=> 'right');
			}else if($custom_field_item_kit !== FALSE){
				$details[] = array('data'=>$custom_field_item_kit, 'align'=> 'right');
			}
		}
		
		return $details;
	}
	
	function get_report_details($ids, $export_excel=0)
	{
		$this->db->select('items.custom_field_1_value,items.custom_field_2_value,items.custom_field_3_value,items.custom_field_4_value,items.custom_field_5_value,items.custom_field_6_value,items.custom_field_7_value,items.custom_field_8_value,items.custom_field_9_value,items.custom_field_10_value,manufacturers.name as manufacturer,sales_items.item_unit_price as unit_price,sales_items.item_variation_id, items.item_id, sales_items.sale_id, items.category_id, items.item_id as item_id,items.item_number, items.product_id as item_product_id, items.name as item_name, categories.name as category, quantity_purchased, CONCAT(phppos_items_quantity_units.unit_name," - ",ROUND(phppos_sales_items.unit_quantity,2)) as unit_quantity, serialnumber, sales_items.description, subtotal, total, tax, profit, commission, discount_percent, items.size as size, items.unit_price as current_selling_price, suppliers.company_name as supplier_name, suppliers.person_id as supplier_id, "item" as row_flag', false);
		$this->db->from('sales_items');
		$this->db->join('items', 'sales_items.item_id = items.item_id', 'left');
		$this->db->join('items_quantity_units', 'items_quantity_units.id = sales_items.items_quantity_units_id', 'left');
		$this->db->join('manufacturers','manufacturers.id=items.manufacturer_id', 'left');
		$this->db->join('categories', 'categories.id = items.category_id', 'left');
		$this->db->join('suppliers', 'items.supplier_id = suppliers.person_id', 'left');
		if (!empty($ids))
		{
			$sale_ids_chunk = array_chunk($ids,25);
			$this->db->group_start();
			foreach($sale_ids_chunk as $sale_ids)
			{
				$this->db->or_where_in('sales_items.sale_id', $sale_ids);
			}
			$this->db->group_end();
		}
		else
		{
			$this->db->where('1', '2', FALSE);		
		}		
		$qry1=$this->db->get_compiled_select();
		
		$this->db->select('item_kits.custom_field_1_value,item_kits.custom_field_2_value,item_kits.custom_field_3_value,item_kits.custom_field_4_value,item_kits.custom_field_5_value,item_kits.custom_field_6_value,item_kits.custom_field_7_value,item_kits.custom_field_8_value,item_kits.custom_field_9_value,item_kits.custom_field_10_value,manufacturers.name as manufacturer, sales_item_kits.item_kit_unit_price as unit_price, 0 as item_variation_id, item_kits.item_kit_id, sales_item_kits.sale_id,item_kits.category_id, item_kits.item_kit_id as item_id,item_kits.item_kit_number as item_number, item_kits.product_id as item_product_id, item_kits.name as item_name, categories.name as category, quantity_purchased, NULL as unit_quantity,NULL as serialnumber, sales_item_kits.description, subtotal, total, tax, profit, commission, discount_percent, NULL as size, item_kits.unit_price as current_selling_price, NULL as supplier_name, NULL as supplier_id, "item_kit" as row_flag', false);
		$this->db->from('sales_item_kits');
		$this->db->join('item_kits', 'sales_item_kits.item_kit_id = item_kits.item_kit_id', 'left');
		$this->db->join('manufacturers','manufacturers.id=item_kits.manufacturer_id','left');
		$this->db->join('categories', 'categories.id = item_kits.category_id', 'left');
		if (!empty($ids))
		{
			$sale_ids_chunk = array_chunk($ids,25);
			$this->db->group_start();
			foreach($sale_ids_chunk as $sale_ids)
			{
				$this->db->or_where_in('sales_item_kits.sale_id', $sale_ids);
			}
			$this->db->group_end();
		}
		else
		{
			$this->db->where('1', '2', FALSE);		
		}
		
		$qry2=$this->db->get_compiled_select();
		
		$query = $this->db->query($qry1." UNION ALL ".$qry2);
		
		$res=$query->result_array();
		
		if($export_excel == 1)
		{
			$variation_ids = array();
			foreach($res as $key=>$drow)
			{			
				if (isset($drow['item_variation_id']) && $drow['item_variation_id'])
				{
					$variation_ids[] = $drow['item_variation_id'];
				}
			}
		
			$variations_info = $this->Item_variations->get_multiple_info($variation_ids);
		
		
		
			$this->load->model('Item_variations');
			$variation_attrs = $this->Item_variations->get_attributes($variation_ids);
			$variations_info = $this->Item_variations->get_multiple_info($variation_ids);
			
			
			$variation_labels = array();
		
			foreach($variation_attrs as $variation_id => $attrs)
			{
				 $variation_labels[$variation_id] = implode(', ', array_column($attrs,'label'));
			}
			
			for($k=0;$k<count($res);$k++)
			{
				if (isset($variations_info[$res[$k]['item_variation_id']]['item_variation_item_number']) && $variations_info[$res[$k]['item_variation_id']]['item_variation_item_number'])
				{
					$res[$k]['item_number'] = $variations_info[$res[$k]['item_variation_id']]['item_variation_item_number'];
				}
				
				if (isset($variations_info[$res[$k]['item_variation_id']]) && $variations_info[$res[$k]['item_variation_id']])
				{
					$res[$k]['item_name'].=(isset($variation_labels[$res[$k]['item_variation_id']]) ? ': '.$variation_labels[$res[$k]['item_variation_id']] : '');
				}
			}
			return $res;
			exit;
		}
		$this->load->model('Category');
		
		$variation_ids = array();
		foreach($res as $key=>$drow)
		{			
			if (isset($drow['item_variation_id']) && $drow['item_variation_id'])
			{
				$variation_ids[] = $drow['item_variation_id'];
			}
		}
			
		
		$this->load->model('Item_variations');
		$variation_attrs = $this->Item_variations->get_attributes($variation_ids);
		$variations_info = $this->Item_variations->get_multiple_info($variation_ids);
		$variation_labels = array();
		
		foreach($variation_attrs as $variation_id => $attrs)
		{
			 $variation_labels[$variation_id] = implode(', ', array_column($attrs,'label'));
		}
		
		$details_data = array();
		foreach($res as $key=>$drow)
			{	
				$details_data_row = array();
				$details_data_row[] = array('data'=>$drow['item_id'], 'align'=>'left');
				$details_data_row[] = array('data'=>isset($variations_info[$drow['item_variation_id']]['item_variation_item_number']) ? $variations_info[$drow['item_variation_id']]['item_variation_item_number'] : $drow['item_number'], 'align'=>'left');
				$details_data_row[] = array('data'=>$drow['item_product_id'], 'align'=>'left');
				$details_data_row[] = array('data'=>$drow['item_name'].(isset($variation_labels[$drow['item_variation_id']]) ? ': '.$variation_labels[$drow['item_variation_id']] : ''), 'align'=>'left');
				$details_data_row[] = array('data'=>$this->Category->get_full_path($drow['category_id']), 'align'=>'left');
				$details_data_row[] = array('data'=>$drow['size'], 'align'=>'left');
				$details_data_row[] = array('data'=>$drow['supplier_name'], 'align'=>'left');
				$details_data_row[] = array('data'=>$drow['manufacturer'], 'align'=>'left');
				$details_data_row[] = array('data'=>$drow['serialnumber'], 'align'=>'left');
				if (!$this->config->item('hide_item_descriptions_in_reports') || (isset($this->params['export_excel']) && $this->params['export_excel']))
				{
					$details_data_row[] = array('data'=>character_limiter($drow['description'],150), 'align'=>'left');
				}
				$details_data_row[] = array('data'=>to_currency($drow['unit_price']), 'align'=>'left');
				$details_data_row[] = array('data'=>to_quantity($drow['quantity_purchased']), 'align'=>'left');
				$details_data_row[] = array('data'=>($drow['unit_quantity']), 'align'=>'left');
				
				$details_data_row[] = array('data'=>to_currency($drow['subtotal']), 'align'=>'right');
				$details_data_row[] = array('data'=>to_currency($drow['total']), 'align'=>'right');
				$details_data_row[] = array('data'=>to_currency($drow['tax']), 'align'=>'right');
				
				if($this->has_profit_permission)
				{
					$details_data_row[] = array('data'=>to_currency($drow['profit']), 'align'=>'right');					
					$details_data_row[] = array('data'=>to_currency($drow['subtotal']-$drow['profit']), 'align'=>'right');					
				}
				
				if (strpos($this->report_key, 'commission') !== false)
				{
					$details_data_row[] = array('data'=>to_currency($drow['commission']), 'align'=>'right');					
				}
				$details_data_row[] = array('data'=>$drow['discount_percent'].'%', 'align'=> 'left');
				
				if($drow['row_flag'] == 'item'){
					for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) {
						$custom_field = $this->Item->get_custom_field($k);
						if($custom_field !== FALSE)
						{
							if ($this->Item->get_custom_field($k,'type') == 'checkbox')
							{
								$format_function = 'boolean_as_string';
							}
							elseif($this->Item->get_custom_field($k,'type') == 'date')
							{
								$format_function = 'date_as_display_date';				
							}
							elseif($this->Item->get_custom_field($k,'type') == 'email')
							{
								$format_function = 'strsame';					
							}
							elseif($this->Item->get_custom_field($k,'type') == 'url')
							{
								$format_function = 'strsame';					
							}
							elseif($this->Item->get_custom_field($k,'type') == 'phone')
							{
								$format_function = 'strsame';					
							}
							elseif($this->Item->get_custom_field($k,'type') == 'image')
							{
								$this->load->helper('url');
								$format_function = 'file_id_to_image_thumb';					
							}
							elseif($this->Item->get_custom_field($k,'type') == 'file')
							{
								$this->load->helper('url');
								$format_function = 'file_id_to_download_link';					
							}
							else
							{
								$format_function = 'strsame';
							}
				
							$details_data_row[] = array('data'=>$format_function($drow["custom_field_${k}_value"]), 'align'=>'right');					
						}
					}
				}else if($drow['row_flag'] == 'item_kit'){
					for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) {				  
						$custom_field_item_kit = $this->Item_kit->get_custom_field($k);
						if($custom_field_item_kit !== FALSE)
						{
							if ($this->Item_kit->get_custom_field($k,'type') == 'checkbox')
							{
								$format_function = 'boolean_as_string';
							}
							elseif($this->Item_kit->get_custom_field($k,'type') == 'date')
							{
								$format_function = 'date_as_display_date';				
							}
							elseif($this->Item_kit->get_custom_field($k,'type') == 'email')
							{
								$format_function = 'strsame';					
							}
							elseif($this->Item_kit->get_custom_field($k,'type') == 'url')
							{
								$format_function = 'strsame';					
							}
							elseif($this->Item_kit->get_custom_field($k,'type') == 'phone')
							{
								$format_function = 'strsame';					
							}
							elseif($this->Item_kit->get_custom_field($k,'type') == 'image')
							{
								$this->load->helper('url');
								$format_function = 'file_id_to_image_thumb';					
							}
							elseif($this->Item_kit->get_custom_field($k,'type') == 'file')
							{
								$this->load->helper('url');
								$format_function = 'file_id_to_download_link';					
							}
							else
							{
								$format_function = 'strsame';
							}
				  
							$details_data_row[] = array('data'=>$format_function($drow["custom_field_${k}_value"]), 'align'=>'right');					
						}
					  }
				}
				
				$details_data[$key][$drow['sale_id']] = $details_data_row;
			}
		
		$data=array(
		"headers" => $this->getDataColumns(),
		"details_data" => $details_data
		);
		
		return $data;
	}
	
}

?>