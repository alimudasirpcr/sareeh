<div class="d-flex flex-wrap gap-5">

    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
        <?php echo form_label(lang('employees_login_start_time') . ':', 'login_start_time', array('class' => 'form-label text-info wide')); ?>

        <div class="input-group date">
            <span class="input-group-text bg">
                <i class="ion ion-ios-calendar-outline"></i>
            </span>
            <?php echo form_input(array(
												'name' => 'login_start_time',
												'id' => 'login_start_time',
												'class' => 'form-control timepicker',
												'value' => $person_info->login_start_time ? date(get_time_format(), strtotime($person_info->login_start_time)) : ''
											)); ?>
        </div>

    </div>


    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
        <?php echo form_label(lang('employees_login_end_time') . ':', 'login_end_time', array('class' => 'form-label text-info wide')); ?>

        <div class="input-group date">
            <span class="input-group-text bg">
                <i class="ion ion-ios-calendar-outline"></i>
            </span>
            <?php echo form_input(array(
												'name' => 'login_end_time',
												'id' => 'login_end_time',
												'class' => 'form-control timepicker',
												'value' => $person_info->login_end_time ? date(get_time_format(), strtotime($person_info->login_end_time)) : ''
											)); ?>
        </div>

    </div>

</div>



<div class="form-group">

    <div class=" form-check form-check-custom form-check-solid">
        <?php
											echo	form_checkbox(array(
												'name' => 'override_price_adjustments',
												'id' => 'override_price_adjustments',
												'value' => 1,
												'class' => 'form-check-input',
												'checked' => $person_info->override_price_adjustments,
											));
											echo '<label class="form-check-label" for="override_price_adjustments">'.lang('override_price_adjustments').'</label>';;
											?>
    </div>
</div>

<div class="d-flex flex-wrap gap-5">

    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
        <?php echo form_label(lang('max_discount_percent') . ':', 'max_discount_percent', array('class' => 'form-label')); ?>

        <div class="input-group">
            <?php echo form_input(array(
												'name' => 'max_discount_percent',
												'id' => 'max_discount_percent',
												'class' => 'form-control',
												'value' => $person_info->max_discount_percent
											)); ?>
            <span class="input-group-text">%</span>

        </div>
    </div>


    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
        <?php echo form_label(lang('commission_default_rate') . ':', 'commission_percent', array('class' => 'form-label')); ?>

        <div class="input-group">
            <?php echo form_input(array(
													'name' => 'commission_percent',
													'id' => 'commission_percent',
													'class' => 'form-control',
													'value' => to_quantity($person_info->commission_percent, FALSE)
												)); ?>
            <span class="input-group-text">%</span>
        </div>

    </div>
</div>

<div class="d-flex flex-wrap gap-5">

    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">

        <?php echo form_label(lang('commission_percent_calculation') . ': ', 'commission_percent_type', array('class' => 'form-label')); ?>

        <?php echo form_dropdown(
											'commission_percent_type',
											array(
												'selling_price'  => lang('unit_price'),
												'profit'    => lang('profit'),
											),
											$person_info->commission_percent_type,
											array(
												'class' => 'form-control',
												'id' => 'commission_percent_type'
											)
										)
										?>

    </div>


    <?php if ($this->config->item('timeclock')) { ?>
    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
        <?php echo form_label(lang('hourly_pay_rate'), 'hourly_pay_rate', array('class' => 'form-label')); ?>

        <div class="input-group">

            <?php echo form_input(array(
												'name' => 'hourly_pay_rate',
												'id' => 'hourly_pay_rate',
												'class' => 'form-control',
												'value' => $person_info->hourly_pay_rate ? to_currency_no_money($person_info->hourly_pay_rate, 2) : ''
											)); ?>
            <div class="input-group-text">
                <?php echo $this->config->item('currency_symbol'); ?></div>
        </div>


    </div>

</div>
<?php
									} else {
										echo form_hidden('hourly_pay_rate', 0);
									}
									?>


<div class="d-flex flex-wrap gap-5">

    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
        <?php echo form_label(lang('employees_hire_date') . ':', 'hire_date', array('class' => 'form-label text-info wide')); ?>

        <div class="input-group date">

            <?php echo form_input(array(
												'name' => 'hire_date',
												'id' => 'hire_date',
												'class' => 'form-control datepicker',
												'value' => $person_info->hire_date ? date(get_date_format(), strtotime($person_info->hire_date)) : ''
											)); ?>
            <span class="input-group-text bg">
                <i class="ion ion-ios-calendar-outline"></i>
            </span>
        </div>
    </div>


    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
        <?php echo form_label(lang('employees_birthday') . ':', 'birthday', array('class' => 'form-label text-info wide')); ?>

        <div class="input-group date">

            <?php echo form_input(array(
												'name' => 'birthday',
												'id' => 'birthday',
												'class' => 'form-control datepicker',
												'value' => $person_info->birthday ? date(get_date_format(), strtotime($person_info->birthday)) : ''
											)); ?>
            <span class="input-group-text bg">
                <i class="ion ion-ios-calendar-outline"></i>
            </span>
        </div>

    </div>
</div>


<div class="d-flex flex-wrap gap-5">

    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
        <?php echo form_label(lang('employees_number') . ':', 'employee_number', array('class' => 'form-label')); ?>

        <?php echo form_input(array(
											'name' => 'employee_number',
											'id' => 'employee_number',
											'class' => 'form-control',
											'value' => $person_info->employee_number
										)); ?>

    </div>



    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
        <?php echo form_label(lang('language') . ':', 'language', array('class' => ' form-label  required')); ?>

        <?php echo form_dropdown(
											'language',
											array(
												'english'  => 'English',
												'indonesia'    => 'Indonesia',
												'spanish'   => 'Español',
												'french'    => 'Fançais',
												'italian'    => 'Italiano',
												'german'    => 'Deutsch',
												'dutch'    => 'Nederlands',
												'portugues'    => 'Portugues',
												'arabic' => 'العَرَبِيةُ‎‎',
												'khmer' => 'Khmer',
												'vietnamese' => 'Vietnamese',
												'chinese' => '中文',
												'chinese_traditional' => '繁體中文',
												'tamil' => 'Tamil'
											),
											$person_info->language ? $person_info->language : $this->Appconfig->get_raw_language_value(),
											'class="form-control" id="language"'
										);
										?>
    </div>
</div>



<div class="d-flex flex-wrap gap-5">

    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
    <?php echo form_label(lang('default_register') . ':', 'language', array('class' => ' form-label ')); ?>
    
        <?php echo form_dropdown('default_register', $registers, $default_register, 'class="form-control"'); ?>
   
</div>
</div>

<?php if (count($locations) == 1) { ?>
<?php
									echo form_hidden('locations[]', current(array_keys($locations)));
									?>
<?php } else { ?>
    <div class="d-flex flex-wrap gap-5">
    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
    <?php echo form_label(lang('locations') . ':', null, array('class' => ' form-label  required')); ?>
  
        <ul id="locations_list" class="list-inline">
            <?php
												echo '<li class=" form-check form-check-custom form-check-solid">' . form_checkbox(
													array(
														'id' => 'select_all',
														'class' => 'all_checkboxes form-check-input',
														'name' => 'select_all',
														'value' => '1',
													)
												) . '<label class="form-check-label"   for="select_all"><span></span><strong>' . lang('select_all') . '</strong></label></li>';

												foreach ($locations_new as $location_id => $location) {
													$checkbox_options = array(
														'name' => 'locations[]',
														'class' => 'location_checkboxes form-check-input',
														'id' => 'locations' . $location_id,
														'value' => $location_id,
														'checked' => $location['has_access'],
													);

													if (!$location['can_assign_access']) {
														$checkbox_options['disabled'] = 'disabled';

														//Only send permission if checked
														if ($checkbox_options['checked']) {
															echo form_hidden('locations[]', $location_id);
														}
													}

													echo '<li class=" form-check form-check-custom form-check-solid">' . form_checkbox($checkbox_options) . '<label class="form-check-label" for="locations' . $location_id . '"><span></span></label> ' . $location['name'] . '</li>';
												}
												?>
        </ul>
    </div>
</div>
<?php } ?>
 
<?php for ($k = 1; $k <= NUMBER_OF_PEOPLE_CUSTOM_FIELDS; $k++) { ?>
<?php
									$custom_field = $this->Employee->get_custom_field($k);
									if ($custom_field !== FALSE) { 
										
										$required = false;
										$required_text = '';
										if($this->Employee->get_custom_field($k,'required') && in_array($current_location,$this->Employee->get_custom_field($k,'locations'))){
											$required = true;
											$required_text = 'required';
										}
										
										?>
<div class="form-group">
    <?php echo form_label($custom_field . ' :', "custom_field_${k}_value", array('class' => 'form-label '.$required_text)); ?>

    <div class="col-sm-9 col-md-9 col-lg-10 ">
        <?php if ($this->Employee->get_custom_field($k, 'type') == 'checkbox') { ?>

        <?php echo form_checkbox("custom_field_${k}_value", '1', (bool) $person_info->{"custom_field_${k}_value"}, "id='custom_field_${k}_value' $required_text"); ?>
        <label for="<?php echo "custom_field_${k}_value"; ?>"><span></span></label>

        <?php } elseif ($this->Employee->get_custom_field($k, 'type') == 'date') { ?>

        <?php echo form_input(array(
											'name' => "custom_field_${k}_value",
											'id' => "custom_field_${k}_value",
											'class' => "custom_field_${k}_value" . ' form-control',
											'value' => is_numeric($person_info->{"custom_field_${k}_value"}) ? date(get_date_format(), $person_info->{"custom_field_${k}_value"}) : '',
											($required ? $required_text : $required_text) => ($required ? $required_text : $required_text)
										)); ?>
        <script type="text/javascript">
        var $field = <?php echo "\$('#custom_field_${k}_value')"; ?>;
        $field.datetimepicker({
            format: JS_DATE_FORMAT,
            locale: LOCALE,
            ignoreReadonly: IS_MOBILE ? true : false
        });
        </script>

        <?php } elseif ($this->Employee->get_custom_field($k, 'type') == 'dropdown') { ?>

        <?php
																$choices = explode('|', $this->Employee->get_custom_field($k, 'choices'));
																$select_options = array('' => lang('please_select'));
																foreach ($choices as $choice) {
																	$select_options[$choice] = $choice;
																}
																echo form_dropdown("custom_field_${k}_value", $select_options, $person_info->{"custom_field_${k}_value"}, 'class="form-control" '.$required_text); ?>

        <?php } elseif ($this->Employee->get_custom_field($k, 'type') == 'image') {
																	echo form_input(
																		array(
																			'name'=>"custom_field_${k}_value",
																			'id'=>"custom_field_${k}_value",
																			'type' => 'file',
																			'class'=>"custom_field_${k}_value".' form-control',
																			'accept'=>".png,.jpg,.jpeg,.gif"
																		),
																		NULL,
																		$person_info->{"custom_field_${k}_value"} ? "" : $required_text
																	);

																if ($person_info->{"custom_field_${k}_value"}) {
																	echo "<img width='30%' src='" . cacheable_app_file_url($person_info->{"custom_field_${k}_value"}) . "' />";
																	echo "<div class='delete-custom-image'><a href='" . site_url('employees/delete_custom_field_value/' . $person_info->person_id . '/' . $k) . "'>" . lang('delete') . "</a></div>";
																}
															?>
        <?php
															} elseif ($this->Employee->get_custom_field($k, 'type') == 'file') {
																echo form_input(
																	array(
																	'name'=>"custom_field_${k}_value",
																	'id'=>"custom_field_${k}_value",
																	'type' => 'file',
																	'class'=>"custom_field_${k}_value".' form-control'
																	),
																NULL,
																$person_info->{"custom_field_${k}_value"} ? "" : $required_text
																);

																if ($person_info->{"custom_field_${k}_value"}) {
																	echo anchor('employees/download/' . $person_info->{"custom_field_${k}_value"}, $this->Appfile->get_file_info($person_info->{"custom_field_${k}_value"})->file_name, array('target' => '_blank'));
																	echo "<div class='delete-custom-image'><a href='" . site_url('employees/delete_custom_field_value/' . $person_info->person_id . '/' . $k) . "'>" . lang('delete') . "</a></div>";
																}
															} else {

																echo form_input(array(
																	'name' => "custom_field_${k}_value",
																	'id' => "custom_field_${k}_value",
																	'class' => "custom_field_${k}_value" . ' form-control',
																	'value' => $person_info->{"custom_field_${k}_value"},
																	($required ? $required_text : $required_text) => ($required ? $required_text : $required_text)
																)); ?>
        <?php } ?>
    </div>
</div>
<?php } //end if
												?>
<?php } //end for loop
											?>


<?php echo form_hidden('redirect_code', $redirect_code); ?>