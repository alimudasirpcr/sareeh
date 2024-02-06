<?php 
/*
Gets the html table to manage meterreading.
*/
function get_meterreadings_manage_table( $meterreading, $controller )
{
	
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$params = $CI->session->userdata($controller_name.'_search_data') ? $CI->session->userdata($controller_name.'_search_data') : array('deleted' => 0);
	
	$table='<table class="tablesorter table table-hover table-row-dashed" id="sortable_table">';	
	$headers[] = array('label' => '<input class="form-check-input" type="checkbox" class="form-check-input" id="select_all" /><label for="select_all"><span></span></label>', 'sort_column' => '');
	
	if(!$params['deleted'])
	{
		$headers[] = array('label' => lang('edit'), 'sort_column' => '');
	}
	
	$headers[] = array('label' => lang('id'), 'sort_column' => 'meter_number');
	$headers[] = array('label' => lang('meter_number'), 'sort_column' => 'value');
	$headers[] = array('label' => lang('reading_date'), 'sort_column' => 'value');
	$headers[] = array('label' => lang('rate'), 'sort_column' => 'value');
	$headers[] = array('label' => lang('reading'), 'sort_column' => 'value');
	$headers[] = array('label' => lang('current_bill'), 'sort_column' => 'value');
	$headers[] = array('label' => lang('description'), 'sort_column' => 'description');
	$headers[] = array('label' => lang('customer_name'), 'sort_column' => 'last_name');
	$headers[] = array('label' => lang('active').'/'.lang('inactive'), 'sort_column' => 'inactive');
	
	
	
	$headers[] = array('label' => lang('clone'), 'sort_column' => '');
		
	$table.='<thead><tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0" >';
	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		$label = $header['label'];
		$sort_col = $header['sort_column'];
		if ($count == 1)
		{
			$table.="<th data-sort-column='$sort_col' class=' form-check form-check-sm form-check-custom form-check-solid leftmost'>$label</th>";
		}
		elseif ($count == count($headers))
		{
			$table.="<th data-sort-column='$sort_col' class='rightmost'>$label</th>";
		}
		else
		{
			$table.="<th data-sort-column='$sort_col'>$label</th>";		
		}
	}
	
	$table.='</tr></thead><tbody>';
	$table.=get_meterreading_manage_table_data_rows( $meterreading, $controller );
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the meter.
*/
function get_meterreading_manage_table_data_rows( $meterreading, $controller )
{
	$CI =& get_instance();
	$table_data_rows='';

	
	if($meterreading!=false){
		foreach($meterreading->result() as $meter)
		{
		
			$table_data_rows.=get_meterreading_data_row( $meter, $controller );
		}
	}
	
	
	if($meterreading==false || $meterreading->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='1000'><span class='col-md-12 text-center' ><span class='text-warning'>".lang('meterreading_no_meterreading_to_display')."</span>&nbsp;&nbsp;<a class='btn btn-primary' href='". site_url('meterreading/excel_import') ."'>". lang('meterreading_import_meterreading')."</a></span></tr>";
	}
	
	return $table_data_rows;
}

function get_meterreading_data_row($meter,$controller)
{
	
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$params = $CI->session->userdata($controller_name.'_search_data') ? $CI->session->userdata($controller_name.'_search_data') : array('deleted' => 0);
	
	$link = site_url('reports/generate/detailed_'.$controller_name.'?customer_id='.$meter->customer_id.'&export_excel=0&meter_number='.$meter->meter_number);
	$cust_info = $CI->Customer->get_info($meter->customer_id);
	
	$table_data_row='<tr>';
	
	
	$table_data_row.="<td class='form-check form-check-sm form-check-custom form-check-solid'><input  class='form-check-input' type='checkbox' id='meter_$meter->reading_id' value='".$meter->reading_id."'/><label for='meter_$meter->reading_id'><span></span></label></td>";

	
	if(!$params['deleted'])
	{
		$table_data_row.='<td>'.anchor($controller_name."/view/$meter->reading_id/2	", lang('edit'),array('class'=>' text-gray-800 text-hover-primary mb-1 ','title'=>lang($controller_name.'_update'))).'</td>';
	}
	$table_data_row.='<td>'.H($meter->reading_id).'</td>';
	$table_data_row.='<td>'.H($meter->meter_number).'</td>';
	$table_data_row.='<td>'.$meter->reading_date.'</td>';
	$table_data_row.='<td>'.$meter->rate.'</td>';
    $table_data_row.='<td>'.$meter->reading_value.'</td>';
	$table_data_row.='<td>'.$meter->rate*$meter->reading_value.'</td>';
	$table_data_row.='<td>'.H($meter->description).'</td>';
	$table_data_row.='<td><a target="blank" class="underline text-gray-800 text-hover-primary mb-1" href="'.$link.'">'.H($cust_info->first_name). ' '.H($cust_info->last_name).'</a></td>';
	$table_data_row.='<td>'.($meter->inactive ? lang('inactive') : lang('active')).'</td>';
	
	
	
	
		$table_data_row.="<td>&nbsp;</td>";
	
	$table_data_row.='</tr>';
	return $table_data_row;
}


?>