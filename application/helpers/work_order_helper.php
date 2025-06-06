<?php

/*
Gets the html table to manage work orders.
*/


function check_if_underwarranty($sale_id){;
	    
		$CI =& get_instance();
		$prefix = $CI->db->dbprefix;
		$CI->db->select('count(si.item_id) as items_having_warranty', false);
		$CI->db->from('sales_items as si');
		$CI->db->join('sales' , 'sales.sale_id = si.sale_id ');
		$CI->db->join('items_serial_numbers as isn' , 'isn.item_id= si.item_id and isn.serial_number = si.serialnumber');
		$CI->db->where('si.sale_id' , $sale_id);
	
		$CI->db->where('sales.is_work_order' , 1);
		$CI->db->where('si.is_repair_item' , 1);
		$CI->db->where('isn.is_sold' , 1);
		$CI->db->where('(  (`isn`.`replace_sale_date` = 1 AND `isn`.`warranty_end` > STR_TO_DATE('.$prefix.'sales.sale_time, "%Y-%m-%d"))
		OR (
			`isn`.`replace_sale_date` != 1 AND `isn`.`sold_warranty_end` > STR_TO_DATE('.$prefix.'sales.sale_time, "%Y-%m-%d")) 
		   )');
		$CI->db->where('sales.deleted', 0);
		$return =  $CI->db->get()->result_array()[0]['items_having_warranty'];
		 

		return $return;

		
}
function get_work_orders_manage_table($orders,$controller)
{
	$CI =& get_instance();
	$CI->load->model('Employee');
	$table='<table class="table align-middle table-row-dashed tablesorter " id="sortable_table">';	
	$columns_to_display = $CI->Employee->get_work_order_columns_to_display();



	$headers[] = array('label' => '<span class="form-check form-check-custom form-check-solid"><input type="checkbox" class="form-check-input" id="select_all" /><label class="form-check-label" for="select_all"><span></span></label></span>', 'sort_column' => '');

	$has_edit_permission = $CI->Employee->has_module_action_permission('work_orders','edit', $CI->Employee->get_logged_in_employee_info()->person_id);
	
	$controller_name=strtolower(get_class($CI));
	$params = $CI->session->userdata($controller_name.'_search_data') ? $CI->session->userdata($controller_name.'_search_data') : array('deleted' => 0);
	
	if ($has_edit_permission && !$params['deleted'])
	{
		$headers[] = array('label' => lang('edit'), 'sort_column' => '');
	}
	
	foreach(array_values($columns_to_display) as $value)
	{
		$headers[] = H($value);
	}
	
		
	$table.='<thead><tr>';
	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		$label = $header['label'];
		$sort_col = $header['sort_column'];
		if ($count == 1)
		{
			$table.="<th data-sort-column='$sort_col' class='leftmost'>$label</th>";
			// $table.='<th>'.lang('work_orders_collect_payment').'</th>';
			
		}
		elseif ($count == count($headers))
		{
			$table.="<th data-sort-column='$sort_col'>$label</th>";
		}
		else
		{
			$table.="<th data-sort-column='$sort_col'>$label</th>";		
		}
	}
	$table.='</tr></thead><tbody>';
	$table.=get_work_orders_manage_table_data_rows($orders,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the work orders.
*/
function get_work_orders_manage_table_data_rows($orders,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($orders->result() as $order)
	{
		$table_data_rows.=get_work_order_data_row($order,$controller);
	}
	
	if($orders->num_rows()==0)
	{
		$table_data_rows.="<tr>
			<td colspan='13'><span class='col-md-12 text-center' ><span class='text-warning'>".lang('work_orders_no_work_orders')."</span></span></td>
		</tr>";
	}
		
	return $table_data_rows;
}

function work_order_status($status)
{
	$CI =& get_instance();
	
	return $CI->Work_order->get_status_name($CI->Work_order->get_status_info($status)->name);
}

function work_order_status_badge($status ,$s='')
{	if($status){
		$CI =& get_instance();	

		$status_info = $CI->Work_order->get_status_info($status);
		$change_status_array = array(''=>lang('work_orders_change_status'));

		$all_statuses = $CI->Work_order->get_all_statuses();
		foreach($all_statuses as $id => $row)
		{
			$change_status_array[$id] = $row['name'];
		}
		return form_dropdown('change_status_single', $change_status_array,$status_info->id, 'class="panel_heading_option visibility-hidden form-select form-select-solid w-150px" style="display: inline;"  onchange="change_status_single('.$s.' , this)" id=""')."<script>
		function change_status_single(id , d){
			var status = $(d).val();
			var selected_values = new Array();
			selected_values.push(id);
			$.post('".site_url("work_orders/work_orders_status_change/")."', 
				{work_order_ids : selected_values,status:status ,supplier_id:''},
				function(response) {
					$('#grid-loader').hide();
					show_feedback(response.success ? 'success' : 'error', response.message,response.success ? ".json_encode(lang('success')).":".json_encode(lang('error')).");

					//Refresh tree if success
					if (response.success)
					{
						setTimeout(function(){location.href = location.href;},800);
					}
				},
				 'json'
			);
		}</script>";
	}

	return '';

}

function date_time_to_date($date_time)
{

	return $date_time ? date(get_date_format(), strtotime($date_time)) : '';
}

function date_time_to_datetime($date_time)
{

	return $date_time ? date(get_date_format().' '.get_time_format(), strtotime($date_time)) : '';
}


function get_work_order_data_row($order,$controller)
{
		$CI =& get_instance();	
		$controller_name=strtolower(get_class($CI));
		
		$params = $CI->session->userdata($controller_name.'_search_data') ? $CI->session->userdata($controller_name.'_search_data') : array('deleted' => 0);

		$table_data_row='<tr data-row_num="'.$order->id.'">';
		$table_data_row.="<td class='form-check form-check-sm form-check-custom form-check-solid' data-column_name='select_checkbox'><input type='checkbox' class='form-check-input' id='order_$order->id' value='".$order->id."'/><label for='item_$order->id'><span></span></label></td>";		
		$displayable_columns = $CI->Employee->get_work_order_columns_to_display();
	
		$CI->load->helper('text');
		$CI->load->helper('date');
		$CI->load->helper('currency');
		
		$has_edit_permission = $CI->Employee->has_module_action_permission('work_orders','edit', $CI->Employee->get_logged_in_employee_info()->person_id);
		
   		$edit_sale_url = $order->suspended ? 'unsuspend' : 'change_sale';
		   $collect_payments='';
		if($order->suspended > 0){
			$collect_payments.='<li>'.anchor("sales/$edit_sale_url/$order->sale_id",lang('work_orders_collect_payment'),array('title'=>lang('work_orders_collect_payment'),'class'=>'text-gray-800 text-hover-primary mb-1 btn-pay')).'</li>';
		}
		
		$edit_view='';
		if ($has_edit_permission && !$params['deleted'])
		{
			$edit_view.='<li>'.anchor($controller_name."/view/$order->id?form_id=edit", lang('edit'),array('class'=>' text-gray-800 text-hover-primary mb-1 ','title'=>lang($controller_name.'_update'))).'</li>';		
		}

		$table_data_row.='<td data-column_name="edit_work_order"> <div class="piluku-dropdown dropdown btn-group table_buttons upordown"> <button type="button" class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		'.lang('more').'
	</button>
	<ul class="dropdown-menu dropdown-menu-left " role="menu">
		'.$edit_view.'
		'.$collect_payments.'
	</ul>
	</div></td>';
	
		foreach($displayable_columns as $column_id => $column_values)
		{

			  
				$val = $order->{$column_id};
			

			if (isset($column_values['format_function']))
			{
				// dd($column_values);
				if (isset($column_values['data_function']))
				{
					$data_function = $column_values['data_function'];
					$data = $data_function($order);
				}
				
				$format_function = $column_values['format_function'];
				
				if (isset($data))
				{
					$val = $format_function($val,$data);
				}
				else
				{
					$val = $format_function($val,$order->id);					
				}
			}
			
			if (!isset($column_values['html']) || !$column_values['html'])
			{
				$val = H($val);
			}
			
			$table_data_row.='<td>'.$val.'</td>';
			//Unset for next round of the loop
			unset($data);
		}	
			
	$table_data_row.='</tr>';
	return $table_data_row;
}


?>