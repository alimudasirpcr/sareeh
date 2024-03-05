<?php $this->load->view("partial/header"); ?>
<style>
label.form-check-label {
    padding-left: 26px;
}

</style>
<div class="row" id="form">
	<div class="col-md-12">
		<div class="card ">
			<div class="card-header rounded rounded-3 p-5">
				<?php echo lang('custom_field_config'); ?>
			</div>

			<div class="card-body">
				<div class="row form-group">
					<div class="col-xs-12">

						<?php echo form_open($controller_name . '/save_custom_fields', array('id' => 'save_custom_fields', 'class' => 'form-horizontal')); ?>

						<?php for ($k = 1; $k <= NUMBER_OF_PEOPLE_CUSTOM_FIELDS; $k++) { ?>

							<div class="panel panel-piluku">
								<div class="panel-heading rounded rounded-3 p-5">
									<h3 class="panel-title"><?php echo lang('custom_field') . ' ' . $k ?></h3>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<?php echo form_label(lang("name") . ' :', '', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
										<div class="col-sm-9 col-md-9 col-lg-8 ">
											<?php echo form_input(array(
												'placeholder' => 'Name',
												'name' => "custom_field_${k}_name",
												'class ' => 'form-control form-inps form-control-solid',
												'value' => isset(${"custom_field_${k}_name"}) ? ${"custom_field_${k}_name"} : '',
											)); ?>
											
										</div>
									</div>

									<div class="form-group">
										<?php echo form_label(lang("type") . ' :', '', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
										<div class="col-sm-9 col-md-9 col-lg-8">

											<?php echo form_dropdown(
												"custom_field_${k}_type",
												array(
													'text'    => lang('text'),
													'dropdown'    => lang('dropdown'),
													'checkbox'    => lang('checkbox'),
													'email'    => lang('email'),
													'url'    => lang('website'),
													'phone'    => lang('phone_number'),
													'date'    => lang('date'),
													'image'    => lang('image'),
													'file'    => lang('file'),
												),
												isset(${"custom_field_${k}_type"}) ? ${"custom_field_${k}_type"} : '',
												'class="form-control field_type form-control-solid"'
											);
											?>


											<?php echo form_input(array(
												'name' => "custom_field_${k}_choices",
												'class ' => 'form-control form-inps choices ' . (empty(${"custom_field_${k}_type"}) || ${"custom_field_${k}_type"} != 'dropdown' ? 'hidden' : ''),
												'value' => isset(${"custom_field_${k}_choices"}) ? ${"custom_field_${k}_choices"} : '',
											)); ?>

										</div>
									</div>

									<div class="row">
									<div class="col-md-2">
									</div>
									<div class="col-md-3">
									

									<div class="form-check ">
											<?php echo form_checkbox(array(
												'name' => "custom_field_${k}_show_on_receipt",
												'id' => "custom_field_${k}_show_on_receipt",
												'style' => 'margin-left: 44px;',
												'class' => 'delete-checkbox form-check-input',
												'value' => 1,
												'checked' => isset(${"custom_field_${k}_show_on_receipt"}) ? ${"custom_field_${k}_show_on_receipt"} : ''
											)); ?>
											<label class="form-check-label" for="<?php echo 'custom_field_'.$k.'_show_on_receipt';  ?>"><?php echo lang("show_on_receipt"); ?></label>
										</div>
									
									</div>

									<div class="col-md-3">

									<div class="form-check">
											<?php echo form_checkbox(array(
												'name' => "custom_field_${k}_hide_field_label",
												'style' => 'margin-left: 44px;',
												'id' => "custom_field_${k}_hide_field_label",
												'class' => 'delete-checkbox form-check-input',
												'value' => 1,
												'checked' => isset(${"custom_field_${k}_hide_field_label"}) ? ${"custom_field_${k}_hide_field_label"} : ''
											)); ?>
											<label class="form-check-label" for="<?php echo 'custom_field_'.$k.'_hide_field_label';  ?>"><?php echo lang("hide_field_label"); ?></label>
										</div>
									
									</div>

									<div class="col-md-3">

									<div class="form-check">
											<?php echo form_checkbox(array(
												'name' => "custom_field_${k}_required",
												'id' => "custom_field_${k}_required",
												'style' => 'margin-left: 44px;',
												'class' => "custom_field_required form-check-input",
												'value' => 1,
												'data-field_id' => $k,
												'checked' => isset(${"custom_field_${k}_required"}) ? ${"custom_field_${k}_required"} : ''
											)); ?>
											<label class="form-check-label" for="<?php echo 'custom_field_'.$k.'_required';  ?>"><?php echo lang("required"); ?></label>
										</div>
								
									</div>
									</div>

									<div class="col-md-1">
									</div>

									<div class="form-group" id="location_area_<?php echo $k;?>">
										<?php echo form_label(lang('locations') . ':', null, array('class' => "col-sm-3 col-md-3 col-lg-2 col-sm-3 col-md-3 col-lg-2 control-label mt-3 text-center location_label_${k}")); ?>
										<div class="col-sm-9 col-md-9 col-lg-8">
											<ul id="locations_list_<?php echo $k; ?>" class="list-inline d-flex justify-content-start">
												<?php
												echo '<li class="form-check  min-w-150px">';
												echo form_checkbox(
													array(
														'id' => "custom_field_${k}_select_all_location",
														'class' => 'all_checkboxes form-check-input',
														'name' => "custom_field_${k}_select_all_location",
														'checked' => isset(${"custom_field_${k}_select_all_location"}) ? ${"custom_field_${k}_select_all_location"} : '',
														'data-locations' => "custom_field_${k}_location"
													)
												);
												echo '<label class="form-check-label" for="custom_field_' . $k . '_select_all_location"><strong>' . lang('select_all') . '</strong></label>';
												
												
												echo '</li>';

												$selected_locations = isset(${"custom_field_${k}_locations"}) ? ${"custom_field_${k}_locations"} : array();

												foreach ($locations as $location_id => $location) {
													$checkbox_options = array(
														'name' => "custom_field_${k}_locations[]",
														'class' => "location_checkbox custom_field_${k}_location form-check-input",
														'id' => "custom_field_${k}_location_${location_id}",
														'value' => $location->location_id,
														'checked' => in_array($location->location_id, $selected_locations),
														'data-location_class' => "custom_field_${k}_location",
														'data-select_all_location_id' => "custom_field_${k}_select_all_location",
													);

													echo  '<li class="form-check min-w-150px">' .form_checkbox($checkbox_options) . '<label class="form-check-label" for="custom_field_' . $k . '_location_' . $location_id . '">' . $location->name . '</label> </li>';
												}
												?>
											</ul>
										</div>
									</div>

								</div>
							</div>

						<?php } ?>
						<div class="form-actions">
							<?php echo form_submit(array(
								'name' => 'submitf',
								'id' => 'submitf',
								'value' => lang('save'),
								'class' => 'submit_button btn btn-primary btn-lg pull-right'
							)); ?>
						</div>

						<?php
						echo form_close();
						?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type='text/javascript'>
	$('.choices').selectize({
		delimiter: '|',
		create: true,
		render: {
			option_create: function(data, escape) {
				var add_new = <?php echo json_encode(lang('add_value')) ?>;
				return '<div class="create">' + escape(add_new) + ' <strong>' + escape(data.input) + '</strong></div>';
			}
		},
	});

	$(".field_type").change(function() {
		if ($(this).val() == 'dropdown') {
			$(this).parent().find('.choices').removeClass('hidden');
		} else {
			$(this).parent().find('.choices').addClass('hidden');
		}

	});

	$("#save_custom_fields").ajaxForm({
		success: function() {
			show_feedback('success', <?php echo json_encode(lang('saved_successfully')); ?>, <?php echo json_encode(lang('success')); ?>);
			setTimeout(function() {
				window.location = '<?php echo site_url($controller_name . '/'); ?>';
			}, 1000);
		}
	});

	$(".all_checkboxes").click(function(e) {
		var all_locations = $(this).data('locations');
		if (!$(this).prop('checked')) {
			$("." + all_locations).prop('checked', false);
		} else {
			$("." + all_locations).prop('checked', true);
		}
	});

	$(".location_checkbox").click(function(e) {
		var location_class = $(this).data('location_class');
		var select_all_location_id = $(this).data('select_all_location_id');
		check_boxes(location_class, select_all_location_id);
	});

	$(".location_checkbox").each(function() {
		var location_class = $(this).data('location_class');
		var select_all_location_id = $(this).data('select_all_location_id');
		check_boxes(location_class, select_all_location_id);
	});

	function check_boxes(location_checkboxes, select_all) {
		var total_checkboxes = $("." + location_checkboxes).length;
		var checked_boxes = 0;
		$("." + location_checkboxes).each(function(index) {
			if ($(this).prop('checked')) {
				checked_boxes++;
			}
		});

		if (checked_boxes == total_checkboxes) {
			$("#" + select_all).prop('checked', true);
		} else {
			$("#" + select_all).prop('checked', false);
		}
	}

	$(".custom_field_required").click(function() {
		var field_id = $(this).data("field_id");
		make_location_required(field_id, $(this).prop('checked'));
	});

	$(".custom_field_required").each(function() {
		var field_id = $(this).data("field_id");
		init_location_required(field_id, $(this).prop('checked'));
	});
	
	function init_location_required(field_id, checked)
	{
		if (!checked) 
		{
			$(".location_label_" + field_id).removeClass('required');
			$("#custom_field_" + field_id + "_select_all_location").prop('checked', false);
			$("#location_area_"+field_id).hide(300);
		} else {
			$(".location_label_" + field_id).addClass('required');
			$("#custom_field_" + field_id + "_select_all_location").prop('checked', true);
			$("#location_area_"+field_id).show(300);
		}
	}
	function make_location_required(field_id, checked) {
		if (!checked) {
			$(".location_label_" + field_id).removeClass('required');
			$("#custom_field_" + field_id + "_select_all_location").prop('checked', false);
			$(".custom_field_" + field_id + "_location").each(function() {
				$(this).prop('checked', false);
			});
			$("#location_area_"+field_id).hide(300);
		} else {
			$(".location_label_" + field_id).addClass('required');
			$("#custom_field_" + field_id + "_select_all_location").prop('checked', true);
			$(".custom_field_" + field_id + "_location").each(function() {
				$(this).prop('checked', true);
			});
			$("#location_area_"+field_id).show(300);
		}
	}
</script>
<?php $this->load->view('partial/footer'); ?>