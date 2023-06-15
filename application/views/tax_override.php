<!-- <div class="modal fade" id="kt_modal_new_card" tabindex="-1" aria-hidden="true"> -->

<div class="modal-dialog mw-650px" id="kt_modal_view_users">
	
		<div class="modal-dialog modal-dialog-centered mw-650px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
						<!--begin::Modal title-->
						<h2><?php echo lang('common_edit_taxes'); ?></h2>
						<!--end::Modal title-->
						<!--begin::Close-->
						<!-- <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						
							<span class="svg-icon svg-icon-1">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
							</span>
					
						</div> -->
						<!--end::Close-->
					</div>
		<div class="modal-body" id="myTabModalBody">
						
						<?php echo form_open($controller_name.'/save_tax_overrides'.(isset($line) ? '_line/'.$line: ''),array('id'=>'tax_form','class'=>'form-horizontal')); ?>
							<div class="row">
								<div class="col-md-12">



								<div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
															<?php echo form_label(lang('common_tax_class').': ', 'tax_class'); ?>
									<!-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i> -->
								</label>
								<!--end::Label-->
								<?php echo form_dropdown('tax_class', $tax_classes, $tax_class_selected, array('id' =>'tax_class','class' => 'form-control tax_class form-control-solid'));?>

								</div>

								


						
						
						
						<div class="form-group">
							<h4 class="text-center"><?php echo lang('common_or') ?></h4>
						</div>
						
						
						
							


							<div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<?php echo form_label(lang('common_tax_1').':', 'tax_percent_1'); ?>
									<!-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i> -->
								</label>
								<!--end::Label-->
								<?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_1',
									'size'=>'8',
									'class'=>'form-control margin10 form-inps form-control-solid',
									'placeholder' => lang('common_tax_name'),
									'value'=> isset($tax_info[0]['name']) ? $tax_info[0]['name'] : '')
								);?>

								</div>
								<div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								
								<!--end::Label-->
								<?php echo form_input(array(
									'name'=>'tax_percents[]',
									'id'=>'tax_percent_name_1',
									'size'=>'3',
									'class'=>'form-control form-inps-tax form-control-solid',
									'placeholder' => lang('common_tax_percent'),
									'value'=> isset($tax_info[0]['percent']) ? $tax_info[0]['percent'] : '')
								);?>
								<!-- <div class="tax-percent-icon">%</div> -->
								<div class="clear"></div>
								<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
								</div>


							
		                   <!-- ////// -->
						   <div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<?php  echo form_label(lang('common_tax_2').':', 'tax_percent_2'); ?>
									<!-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i> -->
								</label>
								<!--end::Label-->
								<?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_2',
									'size'=>'8',
									'class'=>'form-control form-inps margin10 form-control-solid',
									'placeholder' => lang('common_tax_name'),
									'value'=> isset($tax_info[1]['name']) ? $tax_info[1]['name'] : '')
								);?>
								</div>
								<div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								
								<!--end::Label-->
								<?php echo form_input(array(
									'name'=>'tax_percents[]',
									'id'=>'tax_percent_name_2',
									'size'=>'3',
									'class'=>'form-control form-inps-tax form-control-solid',
									'placeholder' => lang('common_tax_percent'),
									'value'=> isset($tax_info[1]['percent']) ? $tax_info[1]['percent'] : '')
								);?>
								<!-- <div class="tax-percent-icon">%</div> -->
								<div class="clear"></div>
								<?php echo form_checkbox('tax_cumulatives[]', '1', (isset($tax_info[1]['cumulative']) && $tax_info[1]['cumulative']) ? (boolean)$tax_info[1]['cumulative'] : false, 'class="cumulative_checkbox" id="tax_cumulatives"'); ?>

								<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
								</div>
								<!-- ///// -->
						

						
		                   <!-- ////// -->
						   <div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<?php  echo form_label(lang('common_tax_3').':', 'tax_percent_3'); ?>
									<!-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i> -->
								</label>
								<!--end::Label-->
								<?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_2',
									'size'=>'8',
									'class'=>'form-control form-inps margin10 form-control-solid',
									'placeholder' => lang('common_tax_name'),
									'value'=> isset($tax_info[1]['name']) ? $tax_info[1]['name'] : '')
								);?>
								</div>
								<div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								
								<!--end::Label-->
								<?php echo form_input(array(
										'name'=>'tax_percents[]',
										'id'=>'tax_percent_name_3',
										'size'=>'3',
										'class'=>'form-control form-inps-tax margin10 form-control-solid',
										'placeholder' => lang('common_tax_percent'),
										'value'=> isset($tax_info[2]['percent']) ? $tax_info[2]['percent'] : '')
									);?>
<!-- <div class="tax-percent-icon">%</div> -->
								<div class="clear"></div>

								<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
								</div>
								<!-- ///// -->
					


								 <!-- ////// -->
								 <div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<?php  echo form_label(lang('common_tax_4').':', 'tax_percent_4'); ?>
									<!-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i> -->
								</label>
								<!--end::Label-->
								<?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_4',
									'size'=>'8',
									'class'=>'form-control  form-inps margin10 form-control-solid',
									'placeholder' => lang('common_tax_name'),
									'value'=> isset($tax_info[3]['name']) ? $tax_info[3]['name'] : '')
								);?>
								</div>
								<div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								
								<!--end::Label-->
								<?php echo form_input(array(
									'name'=>'tax_percents[]',
									'id'=>'tax_percent_name_4',
									'size'=>'3',
									'class'=>'form-control form-inps-tax form-control-solid', 
									'placeholder' => lang('common_tax_percent'),
									'value'=> isset($tax_info[3]['percent']) ? $tax_info[3]['percent'] : '')
								);?>
<!-- <div class="tax-percent-icon">%</div> -->
								<div class="clear"></div>

								<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
								</div>
								<!-- ///// -->
							
						
								 <!-- ////// -->
								 <div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<?php echo form_label(lang('common_tax_5').':', 'tax_percent_5'); ?>
									<!-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i> -->
								</label>
								<!--end::Label-->
								<?php echo form_input(array(
										'name'=>'tax_names[]',
										'id'=>'tax_percent_5',
										'size'=>'8',
										'class'=>'form-control  form-inps margin10 form-control-solid',
										'placeholder' => lang('common_tax_name'),
										'value'=> isset($tax_info[4]['name']) ? $tax_info[4]['name'] : '')
									);?>
								</div>
								<div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								
								<!--end::Label-->
								<?php echo form_input(array(
										'name'=>'tax_percents[]',
										'id'=>'tax_percent_name_5',
										'size'=>'3',
										'class'=>'form-control form-inps-tax margin10 form-control-solid',
										'placeholder' => lang('common_tax_percent'),
										'value'=> isset($tax_info[4]['percent']) ? $tax_info[4]['percent'] : '')
									);?>
<!-- <div class="tax-percent-icon">%</div> -->
								<div class="clear"></div>

								<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
								</div>
								<!-- ///// -->
							
							
							<div class="form-actions taxoverridescss">
								<?php
									echo form_submit(array(
										'name'=>'submitf',
										'id'=>'submitf',
										'value'=>lang('common_save'),
										'class'=>'submit_button btn btn-bg-primary pt-2')
									);
								?>
							</div>
							
						</div>
					</div>
				</div>
				
			</form>
		</div>
	</div>
	</div>
	</div>



</div>
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
			$("#register_container").html(response);
		}
	});	
});	
</script>