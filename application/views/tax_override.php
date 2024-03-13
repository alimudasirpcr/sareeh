
			<div class="" style="width: inherit;">
				<!--begin::Modal content-->
				<div class="">
					<!--begin::Form-->
				
						<!--begin::Modal body-->
						<div class="  px-lg-17">
							<!--begin::Scroll-->
							<div class="scroll-y me-n7 pe-7" id="kt_modal_create_api_key_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_create_api_key_header" data-kt-scroll-wrappers="#kt_modal_create_api_key_scroll" data-kt-scroll-offset="300px">
								<!--begin::Notice-->
							
								<!--end::Notice-->
								<!--begin::Input group-->
								<?php echo form_open($controller_name.'/save_tax_overrides'.(isset($line) ? '_line/'.$line: ''),array('id'=>'tax_form','class'=>'form-horizontal')); ?>
							<div class="row">
								<div class="col-md-12">




							<!-- /////////// -->

									<div class="mb-2 fv-row">
							
									<label class=" fs-5 fw-semibold mb-2 "><?php echo form_label(lang('tax_class').': ', 'tax_class'); ?></label>
								
									<?php echo form_dropdown('tax_class', $tax_classes, $tax_class_selected, array('id' =>'tax_class','class' => 'form-control form-control-solid'));?>

									</div>
									<h4 class="text-center"><?php echo lang('or') ?></h4>

									<!-- ///// -->
									<div class="mb-2 fv-row">
							
									<label class=" fs-5 fw-semibold mb-2 "><?php echo form_label(lang('tax_1').':', 'tax_percent_1'); ?></label>
								
									<?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_1',
									'size'=>'8',
									'class'=>'form-control  form-control-solid',
									'placeholder' => lang('tax_name'),
									'value'=> isset($tax_info[0]['name']) ? $tax_info[0]['name'] : '')
								);?>

									</div>
							<!-- ////// -->
							<div class="mb-5 fv-row">
							
							<?php echo form_input(array(
									'name'=>'tax_percents[]',
									'id'=>'tax_percent_name_1',
									'size'=>'3',
									'class'=>'form-control form-inps-tax form-control-solid',
									'placeholder' => lang('tax_percent'),
									'value'=> isset($tax_info[0]['percent']) ? $tax_info[0]['percent'] : '')
								);?>
							<div class="clear"></div>
								<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
							</div>
							<!-- /////////// -->

							<div class="mb-2 fv-row">
							
							<label class=" fs-5 fw-semibold mb-2 "><?php  echo form_label(lang('tax_2').':', 'tax_percent_2'); ?></label>
						
							<?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_2',
									'size'=>'8',
									'class'=>'form-control form-inps margin10 form-control-solid',
									'placeholder' => lang('tax_name'),
									'value'=> isset($tax_info[1]['name']) ? $tax_info[1]['name'] : '')
								);?>

							</div>

							<div class="mb-5 fv-row">
							
						
							<?php echo form_input(array(
									'name'=>'tax_percents[]',
									'id'=>'tax_percent_name_2',
									'size'=>'3',
									'class'=>'form-control form-inps-tax form-control-solid',
									'placeholder' => lang('tax_percent'),
									'value'=> isset($tax_info[1]['percent']) ? $tax_info[1]['percent'] : '')
								);?>
							<div class="clear"></div>
								<!-- <?php echo form_checkbox('tax_cumulatives[]', '1', (isset($tax_info[1]['cumulative']) && $tax_info[1]['cumulative']) ? (boolean)$tax_info[1]['cumulative'] : false, 'class="cumulative_checkbox" id="tax_cumulatives"'); ?> -->

								<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
							</div>
							<!-- ///////////// -->
							

							<!-- ///// -->
							<div class="mb-2 fv-row">
							
							<label class=" fs-5 fw-semibold mb-2 "><?php  echo form_label(lang('tax_3').':', 'tax_percent_3'); ?></label>
							<?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_2',
									'size'=>'8',
									'class'=>'form-control form-inps margin10 form-control-solid',
									'placeholder' => lang('tax_name'),
									'value'=> isset($tax_info[1]['name']) ? $tax_info[1]['name'] : '')
								);?>

							</div>

							<div class="mb-5 fv-row">
							
						
							<?php echo form_input(array(
										'name'=>'tax_percents[]',
										'id'=>'tax_percent_name_3',
										'size'=>'3',
										'class'=>'form-control form-inps-tax margin10 form-control-solid',
										'placeholder' => lang('tax_percent'),
										'value'=> isset($tax_info[2]['percent']) ? $tax_info[2]['percent'] : '')
									);?>
					<!-- <div class="tax-percent-icon">%</div> -->
								<div class="clear"></div>

								<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
							</div>



							<!-- ///// -->
							<div class="mb-2 fv-row">
							
							<label class=" fs-5 fw-semibold mb-2 "><?php  echo form_label(lang('tax_4').':', 'tax_percent_4'); ?></label>
							<?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_4',
									'size'=>'8',
									'class'=>'form-control  form-inps margin10 form-control-solid',
									'placeholder' => lang('tax_name'),
									'value'=> isset($tax_info[3]['name']) ? $tax_info[3]['name'] : '')
								);?>

							</div>

							<div class="mb-5 fv-row">
							
						
							<?php echo form_input(array(
									'name'=>'tax_percents[]',
									'id'=>'tax_percent_name_4',
									'size'=>'3',
									'class'=>'form-control form-inps-tax form-control-solid', 
									'placeholder' => lang('tax_percent'),
									'value'=> isset($tax_info[3]['percent']) ? $tax_info[3]['percent'] : '')
								);?>
<!-- <div class="tax-percent-icon">%</div> -->
								<div class="clear"></div>

								<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
							</div>
							<!-- //////// -->







							<!-- ///// -->
							<div class="mb-2 fv-row">
							
							<label class=" fs-5 fw-semibold mb-2 "><?php echo form_label(lang('tax_5').':', 'tax_percent_5'); ?>
</label>
<?php echo form_input(array(
										'name'=>'tax_names[]',
										'id'=>'tax_percent_5',
										'size'=>'8',
										'class'=>'form-control  form-inps margin10 form-control-solid',
										'placeholder' => lang('tax_name'),
										'value'=> isset($tax_info[4]['name']) ? $tax_info[4]['name'] : '')
									);?>

							</div>

							<div class="mb-5 fv-row">
							
						
							<?php echo form_input(array(
										'name'=>'tax_percents[]',
										'id'=>'tax_percent_name_5',
										'size'=>'3',
										'class'=>'form-control form-inps-tax margin10 form-control-solid',
										'placeholder' => lang('tax_percent'),
										'value'=> isset($tax_info[4]['percent']) ? $tax_info[4]['percent'] : '')
									);?>
<!-- <div class="tax-percent-icon">%</div> -->
								<div class="clear"></div>

								<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
							</div>
							<!-- //////// -->
							</div>
							<!--end::Scroll-->
						</div>
						<!--end::Modal body-->
						<!--begin::Modal footer-->
						<div class="modal-footer ">
							<!--begin::Button-->
							<?php
									echo form_submit(array(
										'name'=>'submitf',
										'id'=>'submitf',
										'value'=>lang('save'),
										'class'=>'submit_button btn btn-primary pt-2')
									);
								?>
							<!--end::Button-->
							<!--begin::Button-->
							<!-- <button type="submit" id="kt_modal_create_api_key_submit" class="btn btn-primary">
								<span class="indicator-label">Submit</span>
								<span class="indicator-progress">Please wait...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
							</button> -->
							<!--end::Button-->
						</div>
						<!--end::Modal footer-->
					<!--end::Form-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->

<script>
$("#tax_form").submit(function(e)
{
	e.preventDefault();
	//If we don't have prop checked for tax_cumulatives add another tax_cumulatives[] = 0 to form
	if (!$("#tax_cumulatives").prop('checked'))
	{
		$('<input>').attr({
		    type: 'hidden',
		    name: 'tax_cumulatives[]',
				value: '0'
		}).appendTo('#tax_form');
	}
	$('#myModal').modal('hide');
	$("#tax_form").ajaxSubmit({
		success:function(response)
		{
			$("#sales_section").html(response);
		}
	});	
});	
</script>