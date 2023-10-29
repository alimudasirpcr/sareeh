<?php 

$companies = get_all_companies();
		$business_types = get_all_business_types();

	// 	echo "<pre>";
	// print_r($companies);
	// 	exit();
$locations_to_use = $authenticated_locations;

if (isset($can_view_inventory_at_all_locations) && $can_view_inventory_at_all_locations)
{
	$locations_to_use = $all_locations_in_system;
}

if (count($locations_to_use) > 1) {?>		
<div class="form-group">	
	<?php echo form_label(isset($label) ? $label : lang('common_locations').':', null,array('class'=>'col-sm-3 col-md-3 col-lg-2 col-sm-3 col-md-3 col-lg-2 form-label form-control-solid')); ?>
		<div class="col-sm-9 col-md-9 col-lg-10">
		<ul id="reports_locations_list" class="list-inline">
			<?php
			echo '<li class="form-check form-check-custom form-check-solid">'.form_checkbox(
				array(
								'id' => 'select_all',
								'class' => 'all_checkboxes form-check-input',
								'name' => 'select_all',
								'value' => '1',
							)
				). '<label for="select_all"><span></span><strong>'.lang('common_select_all').'</strong></label></li>';
			foreach($locations_to_use as $location_id => $location_name) 
			{
				$checkbox_options = array(
				'id' => 'reports_selected_location_ids'.$location_id,
				'class' => 'reports_selected_location_ids_checkboxes form-check-input',
				'name' => 'location_ids[]',
				'value' => $location_id,
				'checked' => in_array($location_id, Report::get_selected_location_ids()),
			);
																
				echo '<li class="form-check form-check-custom form-check-solid">'.form_checkbox($checkbox_options). '<label for="reports_selected_location_ids'.$location_id.'"><span></span>'.$location_name.'</label></li>';
			}
		?>
		</ul>
	</div>
	
</div>
<div class="row g-9 mb-7">
	<!--begin::Col-->
	<div class="col-md-6 fv-row fv-plugins-icon-container">
		<!--begin::Label-->
		<label class=" fs-6 fw-semibold mb-2"><?php echo lang('company') ?></label>
		<!--end::Label-->
		<!--begin::Input-->
		<select name="company" id="company" class="form-select form-select-solid" tabindex="-1">
			<option>All</option>
			<?php 
			$sel_company = Report::get_selected_company();
			
			foreach($companies as $c): ?>
					<option <?php if($sel_company == $c['company']){ echo  'selected';} ?> value="<?php echo $c['company']; ?>"> <?php echo $c['company'] ; ?> </option>
				<?php endforeach; ?>
		</select>
		<!--end::Input-->
	<div class="fv-plugins-message-container invalid-feedback"></div></div>
	<!--end::Col-->
	<!--begin::Col-->
	<div class="col-md-6 fv-row fv-plugins-icon-container">
		<!--begin::Label-->
		<label class=" fs-6 fw-semibold mb-2"><?php echo lang('business_type') ?></label>
		<!--end::Label-->
		<!--begin::Input-->
		<select name="business_type" id="business_type" class="form-select form-select-solid" tabindex="-1">
		<option>All</option>
			<?php
			$business_type = Report::get_selected_business_type();
			foreach($business_types as $c): ?>
					<option  <?php if($business_type == $c['business_type']){ echo  'selected';} ?> value="<?php echo $c['business_type']; ?>"> <?php echo $c['business_type'] ; ?> </option>
				<?php endforeach; ?>
		</select>
		<!--end::Input-->
	<div class="fv-plugins-message-container invalid-feedback"></div></div>
	<!--end::Col-->
</div>
<script>
$("#select_all").click(function(e)
{
	
	if(!$(this).prop('checked'))
	{
		$(".reports_selected_location_ids_checkboxes").prop('checked',false);
	}
	else
	{
		$(".reports_selected_location_ids_checkboxes").prop('checked', true);
		check_boxes();
	}
	
});
$('.reports_selected_location_ids_checkboxes').click(function()
{
	check_boxes();
});
check_boxes();
function check_boxes()
{
	var total_checkboxes = $(".reports_selected_location_ids_checkboxes").length;
	var checked_boxes = 0;
	$(".reports_selected_location_ids_checkboxes").each(function( index ) {
		if ($(this).prop('checked'))
		{
			checked_boxes++;
		}
	});

	if (checked_boxes == total_checkboxes)
	{
		$("#select_all").prop('checked', true);
	}
	else
	{
		$("#select_all").prop('checked', false);
	}
}
	
</script>
<?php } ?>