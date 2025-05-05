<?php
$company = ($company = $this->Location->get_info_for_key('company')) ? $company : $this->config->item('company');

if(isset($export_excel) && $export_excel == 1)
{
	//Clean all buffers
	while (ob_get_level())
	{
		ob_end_clean();
	}
	$rows = array();
	$row = array();
	foreach ($headers as $header) 
	{
		$row[] = strip_tags($header['data']);
	}
	
	$rows[] = $row;
	
	foreach($data as $datarow)
	{
		$row = array();
		foreach($datarow as $cell)
		{
			$row[] = str_replace('<span style="white-space:nowrap;">-</span>', '-', strip_tags($cell['data']));
		}
		$rows[] = $row;
	}
	$this->load->helper('spreadsheet');
	array_to_spreadsheet($rows, strip_tags($title) . '.'.($this->config->item('spreadsheet_format') == 'XLSX' ? 'xlsx' : 'csv'), true);
	exit;
}
?>
<div class="row ">
	<div class=" col-sm-6   visible-print-inline-block  " style="padding-left: 30px;">
		<?php

			$locations_info_config = $this->Appconfig->get_key_directly_from_database_via_location( 'company_logo',1);
			$file = 	cacheable_app_file_url($locations_info_config);

			echo img(
				array(
					'src' => $file,
					'class'=>'theme-light-show h-50px',
					'id'=>'header-logo',

				));
				echo "<br>Company: ".$this->config->item('company');	
				echo "<br>Location: ".$this->Employee->get_current_location_info()->address;
				echo "<br>Phone: ".$this->Employee->get_current_location_info()->phone;
					?>
	</div>
	<div class=" col-sm-6  d-flex justify-content-end  " style="padding-right: 30px;">
		<div class="visible-print-inline-block">
			<?php
			
			$companies ='';
			if(isset($_GET['location_ids'])){
				foreach($_GET['location_ids'] as $loc){
					$locations_info = $this->Location->get_info($loc);
				    
					
					$companies .=  $locations_info->name. ',';
				}
				if(count($_GET['location_ids'])==1){
					$locations_info_config = $this->Appconfig->get_key_directly_from_database_via_location( 'company_logo',$_GET['location_ids'][0]);
					$file = 	cacheable_app_file_url($locations_info_config);

					echo img(
						array(
							'src' => $file,
							'class'=>'theme-light-show h-50px',
							'id'=>'header-logo',
	
						));
				}
				
				echo "<br>Locations: ".$companies;	
			}
			

					
					
						?>
		</div>
	</div>
	
  </div>
  <div class="card">
<div class="row hidden-print mt-5 mx-3">
	<?php foreach($summary_data as $name=>$value) { ?>
	    <div class="col-md-3 col-xs-12 col-sm-6 summary-data mt-4">
	        <!-- <div class="info-seven primarybg-info">
	            <div class="logo-seven hidden-print"><i class="ti-widget dark-info-primary"></i></div>
					
					
	        </div> -->

			<div class="card card-flush  mb-5 mb-xl-10">
												<!--begin::Header-->
												<div class="card-header pt-5">
													<!--begin::Title-->
													<div class="card-title d-flex flex-column">
														<?php
																if(!is_numeric($value))
																{
																echo '<span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted" >'.$value.'</span>';
																echo '<span class="text-gray-400 pt-1 fw-semibold fs-6">'.lang('reports_'.$name).'</span>';						
																}
																elseif($name == 'total_number_of_items_sold' || $name == 'damaged_qty' || $name == 'average_quantity' || $name == 'total_items_in_inventory' || $name == 'number_items_counted' || $name == 'hours' || $name == 'times_rules_applied' || $name == 'sales_per_time_period')
																{
																echo '<span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted" >'.str_replace(' ','&nbsp;', to_quantity($value)).'</span>';
																echo '<span class="text-gray-400 pt-1 fw-semibold fs-6">'.lang('reports_'.$name).'</span>';
																}
																else
																{
																echo '<span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted" >'.to_currency($value).'</span>';
																echo '<span class="text-gray-400 pt-1 fw-semibold fs-6">'.lang('reports_'.$name).'</span>';
																}
															?>
													</div>
													<!--end::Title-->
													
													
												</div>

											</div>


	    </div>
	<?php }?>

</div>
</div>


<?php if(isset($pagination) && $pagination) {  ?>
	<div class="pagination hidden-print alternate text-center" id="pagination_top" >
		<?php echo $pagination;?>
	</div>
<?php }  ?>




<div class="row">
	<div class="col-md-12">
		<div class="card  reports-printable">
			<input type="hidden" name="url_segment" id="url_segment" value="<?php echo $this->uri->segment(3); ?>">
			<div class="card-header rounded rounded-3 p-12">
				<form> <?php echo lang('reports_reports'); ?> - <?php echo $company; ?> <?php echo $title ?> </form>
				
				<small class="reports-range"><?php echo $subtitle ?> </small>
				<br /><small class="reports-range"><?php echo lang('reports_generation_date').' '.date(get_date_format().' '.get_time_format()); ?></small>
				<span class="pull-right">
					<?php
					if ($this->uri->segment(3) == 'detailed_timeclock')
					{
					?>
					&nbsp;&nbsp;&nbsp;
						<?php echo lang('current_ip_address').': '.$this->input->ip_address();?>
						&nbsp;&nbsp;&nbsp;
						<?php echo anchor('timeclocks/view/-1?'.$_SERVER['QUERY_STRING'], lang('reports_new_timeclock'), 'class="btn btn-primary btn-radius"');?>
					<?php } ?>
					
					<?php
					if ($this->uri->segment(3) == 'summary_customers')
					{
					?>
					&nbsp;&nbsp;&nbsp;
						<?php echo anchor('customers/mailing_label_from_summary_customers_report/'.$this->input->get('start_date').'/'.$this->input->get('end_date').'/'.$this->input->get('sale_type').'/'.$this->input->get('total_spent_condition').'/'.$this->input->get('total_spent_amount'), lang('mailing_labels'), 'class="btn btn-primary btn-radius" target="_blank"');?>
					<?php } ?>
					
				</span>
				
				<?php /* Html code for hide show and sort columns */ ?>
				<form id="config_columns" class="report-config hidden-print">
					<div  id="config_columns" class="piluku-dropdown btn-group table_buttons pull-right m-left-20">
						
						<button type="button" class="btn btn-more btn-light-primary dropdown-toggle" style="margin-top: -21px;" data-toggle="dropdown" aria-expanded="false">
							<i class="ion-gear-a"></i>
						</button>
							<ul id="" class="dropdown-menu dropdown-menu-left col-config-dropdown" role="menu">
								<li class="dropdown-header"><a id="reset_to_default" class="pull-right"><span class="ion-refresh"></span> <?= lang('Reset'); ?> </a><?php echo lang('column_configuration'); ?></li>
																	
								<?php $i = 0; foreach($headersshow as $col_key) {
									$checked = '';
									if($col_key['view'] == 1) {
										$checked = 'checked ="checked" ';
									}
									?>
									<li class="col<?php echo $i; ?>"><a><input <?php echo $checked; ?> name="selected_columns[]" type="checkbox" class="columns" id="<?php echo $col_key['column_id']; ?>" value="<?php echo $col_key['column_id']; ?>"><label class="sortable_column_name" for="<?php echo $col_key['column_id']; ?>"><span></span><?php echo H($col_key['data']); ?></label><span class=""></span></a></li>									
								<?php } ?>
							</ul>
					</div>
				</form>
				<?php /* End html code for hide show and sort columns */ ?>
				<!-- dddd -->
				<button class="btn btn-primary text-white hidden-print print_button pull-right" style="margin-top: -21px;"> <?php echo lang('print'); ?> </button>
				
				<?php if($key) { ?>
					<a href="<?php echo site_url("reports/delete_saved_report/".$key);?>" class="btn btn-primary text-white hidden-print delete_saved_report pull-right"> <?php echo lang('reports_unsave_report'); ?></a>	
				<?php } else { ?>
					<button class="btn btn-primary text-white hidden-print save_report_button pull-right" style="margin-top: -21px;" data-message="<?php echo H(lang('reports_enter_report_name'));?>"> <?php echo lang('reports_save_report'); ?></button>
				<?php } ?>
				
				
			</div>

			
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-rounded table-striped border gy-7 gs-7 table-bordered tablesorter" id="sortable_table">
						<thead>
							<tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
								<?php foreach ($headersshow as $header) { ?>
								<th align="<?php echo $header['align'];?>" class="colsho <?php echo $header['column_id']; ?>" style="<?php if($header['view'] == 0) { ?>display:none;<?php } ?>"><?php echo $header['data']; ?></th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($data as $row) { ?>
						<tr>
							<?php $i = 0; foreach ($row as $cell) { ?>
							<td align="<?php echo is_array($cell) && isset($cell['align']) ? $cell['align'] : 'left'; ?>"
								class="colsho <?php echo $i; ?>">
								<?php echo is_array($cell) ? $cell['data'] : $cell; ?>
							</td>
							<?php $i++; } ?>
						</tr>
						<?php } ?>
					</tbody>

					</table>
				</div>
				<div class="text-center">
					<button class="btn btn-primary text-white hidden-print print_button pull-right"> <?php echo lang('print'); ?> </button>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(isset($pagination) && $pagination) {  ?>
	<div class="pagination hidden-print alternate text-center" id="pagination_top" >
		<?php echo $pagination;?>
	</div>
<?php }  ?>
	
</div>

<div class=" visible-print-inline-block" >
<div class="d-flex justify-content-end   " style="padding-right: 50px;">
	<!--begin::Section-->
	<div class="mw-300px">
	<?php foreach($summary_data as $name=>$value) { ?>
		<!--begin::Item-->
		<div class="d-flex flex-stack mb-3">
			<!--begin::Accountnumber-->
			<div class="fw-semibold pe-10 text-gray-600 fs-7"><?php echo lang('reports_'.$name); ?></div>
			<!--end::Accountnumber-->
			<!--begin::Number-->
			<div class="text-end fw-bold fs-6 text-gray-800"> <?php 

						if($name == 'items_having_warranty' || $name == 'items_having_nowarranty' ||$name == 'number_items_counted' || $name == 'points_used' || $name =='points_gained')
						{
							
							echo to_quantity($value);								
						}
						else
						{
							echo to_currency($value);
			
						}
						?>
						</div>
			<!--end::Number-->
		</div>
		<!--end::Item-->

		<?php }?>

	</div>
	<!--end::Section-->
</div>
</div>
<span class="text-muted fs-5 visible-print-inline-block"><?=  $this->config->item('terms'); ?></span>
<?php 
foreach ($headersshow as $header) { 
	if($header['view'] == 0) {
?>
<script>
	var $th = $(".<?php echo $header['column_id']; ?>");
	var $td = $th.closest('table').find('td:nth-child('+($th.index()+1)+')');
	$th.hide();
	$td.hide();
</script>
<?php 
	}
}
?>

<script type="text/javascript" language="javascript">
function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(); 
	}
}
function print_report()
{
	window.print();
}
$(document).ready(function()
{
	
	<?php if ($this->uri->segment(3) != 'closeout')  { ?>
	init_table_sorting();
	
	var headIndex = 0;
	<?php if($this->uri->segment(3)== 'detailed_register_log' || $this->uri->segment(3) == 'detailed_inventory' || $this->uri->segment(3) =='detailed_timeclock' || $this->uri->segment(3) == 'detailed_expenses') { ?>
		headIndex = 2;	
	<?php } ?>

		<?php if($this->uri->segment(3)== 'summary_items' || $this->uri->segment(3)== 'summary_customers' || $this->uri->segment(3)== 'store_account_activity' || $this->uri->segment(3) =='specific_customer_store_account' ||
		$this->uri->segment(3)== 'inventory_low' || $this->uri->segment(3) =='inventory_summary' 
		) { ?>
			headIndex = 1;	
		<?php } ?>
		
	$("#sortable_table").stacktable({headIndex: headIndex});
	<?php } ?>

	$('.print_button').click(function(e){
		e.preventDefault();
		print_report();
	});
});

</script>