<?php
$company = ($company = $this->Location->get_info_for_key('company')) ? $company : $this->config->item('company');

if($export_excel == 1)
{
	$this->load->view('reports/outputs/tabular_details_excel_export');
}
?>
<style>
.row-container {
    display: flex; /* Display columns in a row */
    flex-wrap: wrap; /* Ensure columns wrap as needed */
	border-bottom: 1px solid  black;
}

.cell-list.column {
    list-style-type: none;
    padding: 0;
    margin: 0 10px; /* Adjust spacing between columns */
    flex: 1; /* Ensures the columns take up equal space */
    min-width: 0; /* Prevents flex items from not shrinking */
}

.cell-list.column li {
    padding: 4px;
    border-bottom: 1px solid #eee; /* Visual separator for items */
}



.clear-fix {
    clear: both; /* Ensures that the next row starts on a new line */
}
</style>

<div class="modal fade skip-labels" id="skip-labels" role="dialog" aria-labelledby="skipLabels" aria-hidden="true">
    <div class="modal-dialog customer-recent-sales">
      	<div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('common_close')); ?>><span aria-hidden="true">&times;</span></button>
	          	<h4 class="modal-title" id="skipLabels"><?php echo lang('common_skip_labels') ?></h4>
	        </div>
	        <div class="modal-body">
				
	          	<?php echo form_open("items/generate_barcodes", array('id'=>'generate_barcodes_form','autocomplete'=> 'off')); ?>				
				<input type="text" class="form-control text-center" name="num_labels_skip" id="num_labels_skip" placeholder="<?php echo lang('common_skip_labels') ?>">
					<?php echo form_submit('generate_barcodes_form',lang("common_submit"),'class="btn btn-block btn-primary"'); ?>
				<?php echo form_close(); ?>
				
	        </div>
    	</div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
<div class="card  hidden-print">
	<div class="row">
	<?php foreach($overall_summary_data as $name=>$value) { ?>
	    <div class="col-md-3 col-xs-12 col-sm-6 ">
	        <div class="info-seven primarybg-info position-relative me-5">
			<span data-id="<?= $name ?>" class=" hide_print position-absolute  top-0 start-100 translate-middle  badge badge-circle badge-danger"><i class="fa fa-eye " style="color:white"></i></span>
	            <div class="logo-seven hidden-print"><i class="ti-widget dark-info-primary"></i></div>
	            <?php 
							
							if($name == 'items_having_warranty' || $name == 'items_having_nowarranty' ||$name == 'number_items_counted' || $name == 'points_used' || $name =='points_gained')
							{
								
								echo to_quantity($value);								
							}
							else
							{
								echo to_currency($value);
	            
							}
							?>
							<p><?php echo lang('reports_'.$name); ?></p>
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
	
	
<div class="row card">
	<div class="col-md-12">
		<div class="panel panel-piluku reports-printable">
			<div class="panel-heading rounded rounded-3 p-5">
				<form id="config_columns" class="report-config hidden-print">
				<div class="piluku-dropdown btn-group table_buttons pull-right m-left-20">
				<input type="hidden" name="url_segment" id="url_segment" value="<?php echo $this->uri->segment(3); ?>">
					<button type="button" class="btn btn-more btn-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<i class="ion-gear-a"></i>
					</button>
						<ul id="" class="dropdown-menu dropdown-menu-left col-config-dropdown" role="menu">
							<li class="dropdown-header"><a id="reset_to_default" class="pull-right"><span class="ion-refresh"></span> Reset</a><?php echo lang('common_column_configuration'); ?></li>
																
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
				<?php echo lang('reports_reports'); ?> - <?php echo $company; ?> <?php echo $title ?>
				<small class="reports-range"><?php echo $subtitle ?></small>
				<br /><small class="reports-range"><?php echo lang('reports_generation_date').' '.date(get_date_format().' '.get_time_format()); ?></small>
				
			

				


				<button class="btn btn-primary text-white hidden-print print_button pull-right" style="margin-top: -19px;"> <?php echo lang('common_print'); ?> </button>	
				<?php if($key) { ?>
					<a href="<?php echo site_url("reports/delete_saved_report/".$key);?>" class="btn btn-primary text-white hidden-print delete_saved_report pull-right"> <?php echo lang('reports_unsave_report'); ?></a>	
				<?php } else { ?>
					<button class="btn btn-primary text-white hidden-print save_report_button pull-right" style="margin-top: -19px;" data-message="<?php echo H(lang('reports_enter_report_name'));?>"> <?php echo lang('reports_save_report'); ?></button>
				<?php } ?>	
<div class="d-flex hidden-print ">
				<div class="form-check form-check-custom form-check-solid form-check-lg  w-200px  ">
    <input class="form-check-input" type="radio" value="list" name="options" id="flexCheckboxSmlist" checked onchange="radioChanged()"  />
    <label class="form-check-label" for="flexCheckboxSmlist">
	<?= lang('detail_data_list_view'); ?>
    </label>
</div>
<select class="form-select w-200px " id="select_columns" aria-label="Select example" onchange="radioChanged()">
    <option value="1">Select no of columns</option>
    <option value="1">One</option>
    <option value="2">Two</option>
    <option value="3" selected>Three</option>
	<option value="4">Four</option>
	<option value="5">Five</option>
	<option value="6">Six</option>
</select>
</div>
<div class="form-check form-check-custom form-check-solid form-check-lg hidden-print">
    <input class="form-check-input" type="radio" value="table" name="options" id="flexCheckboxSmtbl"   onchange="radioChanged()" />
    <label class="form-check-label" for="flexCheckboxSmtbl">
	<?= lang('detail_data_table_view'); ?>
    </label>
</div>
				
			</div>
			
			
			<div class="panel-body">
				<div class="table-responsive">
				<table class="table table-hover detailed-reports table-reports table-bordered  tablesorter table-rounded table-striped border gy-7 gs-7" id="sortable_table">
					<thead>
						<tr align="center" style="font-weight:bold">
							<td class="hidden-print"><a href="#" class="expand_all" >+</a></td>
							<?php foreach ($headersshow as $header) { ?>
							<td align="<?php echo $header['align']; ?>" class="colsho <?php echo $header['column_id']; ?>" style="<?php if($header['view'] == 0) { ?>display:none;<?php } ?>"><?php echo $header['data']; ?></td>
							<?php } ?>
						
						</tr>
					</thead>
					<tbody>
						<?php 
						$ids=array();
						foreach ($summary_data as $key=>$row) { 
						$ids[]=$row[0]['detail_id'];
						?>
						<tr>
							<td class="hidden-print"><a href="#" id="<?php echo $row[0]['detail_id']; ?>" class="expand" style="font-weight: bold;">+</a></td>
							<?php foreach ($row as $cell) { ?>
							<td align="<?php echo $cell['align']; ?>"><?php echo $cell['data']; ?></td>
							<?php } ?>
						</tr>
						<tr class="sale_details" id="res_<?php echo $row[0]['detail_id']; ?>" style="display:none;">
						</tr>
						<?php } 
						$ids=implode(',',$ids);
						?>
					</tbody>
				</table>
				</div>
				<div class="text-center">
					<button class="btn btn-primary text-white hidden-print print_button pull-right"  > <?php echo lang('common_print'); ?> </button>	
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
	<?php foreach($overall_summary_data as $name=>$value) { ?>
		<!--begin::Item-->
		<div class="d-flex flex-stack mb-3 <?= $name ?> ">
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
	$(".innertable td").show();
	
</script>
<?php 
	}
}
?>

<script type="text/javascript" language="javascript">
$(document).ready(function() {
    // Function to update the visibility based on localStorage or default to visible
    function updateVisibility() {
        $('.hide_print').each(function() {
            var targetClass = $(this).data('id').trim();
            // Check if the item exists in localStorage; if not, default to true (visible)
            var isVisible = localStorage.getItem('isVisible_' + targetClass);
            isVisible = (isVisible === null) ? 'true' : isVisible; // Default to visible if not set

            if (isVisible === 'true') {
                $('.' + targetClass).removeClass('hidden-print');
                $(this).find('i').addClass('fa-eye').removeClass('fa-eye-slash');
            } else {
                $('.' + targetClass).addClass('hidden-print');
                $(this).find('i').addClass('fa-eye-slash').removeClass('fa-eye');
            }
        });
    }

    // Initially update visibility based on stored values or default to visible
    updateVisibility();

    $('.hide_print').click(function() {
        var targetClass = $(this).data('id').trim();
        // If not set, default to making it visible (opposite of current logic, since we're toggling)
        var isVisible = localStorage.getItem('isVisible_' + targetClass) !== 'true';
        localStorage.setItem('isVisible_' + targetClass, isVisible);

        // Toggle visibility and icon
        $('.' + targetClass).toggleClass('hidden-print');
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');

        // Optional: Ensure consistency across similar elements
        updateVisibility();
    });
});
var base_sheet_url = '';
$(document).ready(function()
{
	$(".tablesorter a.expand").click(function(event)
	{
		$(event.target).parent().parent().next().find('td.innertable').toggle();
		
		if ($(event.target).text() == '+')
		{
			$(event.target).text('-');
			id=$(event.target).attr("id");
			show_report_details(id);
		}
		else
		{
			$(event.target).text('+');
		}
		return false;
	});
	
	$(".tablesorter a.expand_all").click(function(event)
	{
		$('td.innertable').toggle();
		
		if ($(event.target).text() == '+')
		{
			$(event.target).text('-');
			$(".tablesorter a.expand").text('-');
			
			ids='<?php echo $ids; ?>';
				show_report_details(ids);
			
		}
		else
		{
			$(event.target).text('+');
			$(".tablesorter a.expand").text('+');
		}
		return false;
	});

	
	$(".generate_barcodes_from_recv").click(function()
	{
		base_sheet_url = $(this).attr('href');
		$("#skip-labels").modal('show');
		return false;
	
	});
		
	$("#generate_barcodes_form").submit(function(e)
	{
		e.preventDefault()
		var num_labels_skip = $("#num_labels_skip").val() ? $("#num_labels_skip").val() : 0;
		var url = base_sheet_url+'/'+num_labels_skip;
		window.location = url;
		return false;
	});
});
function radioChanged() {
		ids='<?php echo $ids; ?>';
		show_report_details(ids);
		
		
	}
function print_report()
{
	window.print();
}

function show_report_details(ids){
	var $view = $("input[name='options']:checked").val() || "None";
	$view = $("input[name='options']:checked").val() || "None";
	if($view=='list'){
			$('#select_columns').show();
		}else{
			$('#select_columns').hide();
		}
        if(ids){
            var report_model = '<?php echo $report_model; ?>';
			var url = '<?php echo site_url('reports/get_report_details'); ?>';
			var params = <?php echo json_encode($this->input->get());?>;
			
            var ids = ids.split(',');
			$.ajax({
                url: url,
				type: 'POST',
				data:{'ids':ids,'key':report_model, params:JSON.stringify(params)},
				datatype: 'json',
				cache: false,
				success:function(data){
				
				var obj = JSON.parse(data);
				var headers = obj.headers['details'];
				var summary = obj.headers['summary'];
				var cellData= obj.details_data;

				for (i = 0; i < ids.length; i++) { 
					
					var res = '#res_'+ids[i];

					if($view=='list'){

					
					no_of_coumns = 	$('#select_columns').val();
					var tableData = '<td colspan="100" class="inner-content innertable">';

							$.each(cellData, function (x) {
								var transData = cellData[x];
								var rowContent = ''; // Initialize an empty string to accumulate row content
								$.each(transData, function (key, value) {
									if (key == ids[i] && value && value.length > 0) { // Check if there's data to display
										var headersPerColumn = Math.ceil(headers.length / no_of_coumns); // Calculate headers per column for 3 columns
										for (let colIndex = 0; colIndex < no_of_coumns; colIndex++) { // Iterate to create 3 columns
											var columnContent = ''; // Initialize column content
											for (let itemIndex = colIndex * headersPerColumn; itemIndex < (colIndex + 1) * headersPerColumn && itemIndex < headers.length; itemIndex++) {
												if (value[itemIndex] && value[itemIndex].data) { // Check for non-empty data
													var data = value[itemIndex].data;
													var header = headers[itemIndex].data; // Access the header using itemIndex
													columnContent += `<li><strong>${header}:</strong> ${data}</li>`; // Accumulate column content
												}
											}
											if (columnContent) { // Only add column if there's content
												rowContent += '<ul class="cell-list column">' + columnContent + '</ul>';
											}
										}
										if (rowContent) { // Only create a row container if there's row content
											rowContent = '<div class="row-container">' + rowContent + '<div class="clear-fix"></div></div>';
											tableData += rowContent; // Append the row container to the table data
										}
									}
								});
							});

							tableData += '</td>';

						}else{


							var tableData='<td colspan="100" class="innertable"><table class="table table-bordered">';
					tableData+='<thead>';
					tableData+='<tr>';
					$.each(headers, function (k, v) {
						tableData += '<th align="'+ v.align + '">' + v.data + '</th>';					
					});
					tableData +='</tr></thead>';
					
					tableData+='<tbody>';
					$.each(cellData, function (x) {
					var transData= cellData[x];
						$.each(transData, function (key, value){
							var rowId=key;
							var rowData=value;
							if(rowId == ids[i])
							{
								tableData+='<tr>';
								$.each(rowData, function (a,b) {
									if(b.data == null){b.data='';}
									tableData += '<td align="'+ b.align + '">' + b.data + '</td>';					
								});
								tableData+='</tr>';
								
							}
						
						});
						
					});
					tableData+='</tbody>';
					tableData+='</table></td>';
						}
					
					$(res).empty();
					$(res).append(tableData);
					$(res).css('display','');
				}
				
				},
				error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError);
				}
				
               
            });
        }
    }

$(document).ready(function()
{
	$('.print_button').click(function(e){
		e.preventDefault();
		print_report();
	});
});

</script>