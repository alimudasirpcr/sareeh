<script src="<?php echo base_url() ?>assets/css_good/plugins/custom/formrepeater/formrepeater.bundle.js"></script>

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
				<?php echo form_open($controller_name . '/save_tax_overrides_rep' . (isset($line) ? '_line/' . $line : ''), array('id' => 'tax_form', 'class' => 'form-horizontal')); ?>
				<div class="row">
					<div class="col-md-12">




						<!-- /////////// -->

						<div class="mb-2 fv-row">

							<label class=" fs-5 fw-semibold mb-2 "><?php echo form_label(lang('tax_class') . ': ', 'tax_class'); ?></label>

							<?php echo form_dropdown('tax_class', $tax_classes, $tax_class_selected, array('id' => 'tax_class', 'class' => 'form-control form-control-solid')); ?>

						</div>

						<div id="all_tax">
							<h4 class="text-center"><?php echo lang('or') ?></h4>
							<!-- ///// -->
							

							<!--begin::Repeater-->
<div id="kt_docs_repeater_basic">
    <!--begin::Form group-->
    <div class="">
        <div data-repeater-list="kt_docs_repeater_basic">
			<?php 
				$max = 4;
				for($i=0; $i <= $max; $i++):
					if(isset($tax_info[$i]['percent'])):
			?>
            <div  class="repeater-item" data-repeater-item>
                <div class=" row">
                    <div class="col-md-5">
                        <label class="form-label">Tax:</label>
						
                        <input type="text" name="tax_names" value="<?= $tax_info[$i]['name']; ?>" class="form-control mb-2 mb-md-0" placeholder="Name" />
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Percent:</label>
						<input type="hidden" name="tax_cumulatives" value="0">
                        <input type="text" name="tax_percents" value="<?= $tax_info[$i]['percent']; ?>" class="form-control mb-2 mb-md-0" placeholder="Percent" />
                    </div>
                   
                    <div class="col-md-2">
                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                           <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
			<?php endif; endfor;  ?>
<?php if(!isset($tax_info[4]['percent'])): ?>
			<div class="repeater-item" data-repeater-item>
                <div class=" row">
                    <div class="col-md-5">
                        <label class="form-label">Tax:</label>
						
                        <input type="text" name="tax_names"  class="form-control mb-2 mb-md-0" placeholder="Name" />
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Percent:</label>
						<input type="hidden" name="tax_cumulatives" value="0">
                        <input type="text" name="tax_percents" class="form-control mb-2 mb-md-0" placeholder="Percent" />
                    </div>
                   
                    <div class="col-md-2">
                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                           <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>

			<?php endif;   ?>
        </div>
    </div>
    <!--end::Form group-->

    <!--begin::Form group-->
    <div class="form-group mt-5">
        <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
            <i class="ki-duotone ki-plus fs-3"></i>
            Add
        </a>
    </div>
    <!--end::Form group-->
</div>
<!--end::Repeater-->
							<!-- //////// -->
						</div>
					</div>
					<!--end::Scroll-->
				</div>
				<!--end::Modal body-->
				<!--begin::Modal footer-->
				<div class="modal-footer ">
					<!--begin::Button-->
					<?php
					echo form_submit(
						array(
							'name' => 'submitf',
							'id' => 'submitf',
							'value' => lang('save'),
							'class' => 'submit_button btn btn-primary pt-2'
						)
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
			$("#tax_form").submit(function(e) {
				e.preventDefault();
				//If we don't have prop checked for tax_cumulatives add another tax_cumulatives[] = 0 to form
				if (!$("#tax_cumulatives").prop('checked')) {
					$('<input>').attr({
						type: 'hidden',
						name: 'tax_cumulatives[]',
						value: '0'
					}).appendTo('#tax_form');
				}
				$('#myModal').modal('hide');
				$("#tax_form").ajaxSubmit({
					success: function(response) {
						$("#sales_section").html(response);
					}
				});
			});
		</script>
		<script>
			$(document).ready(function() {
				$('#tax_class').change(function() {
					// Check if the selected value is "None"
					if ($(this).val() == "") {
						$('#all_tax').show(); // Show the div
					} else {
						$('#all_tax').hide(); // Hide the div
					}
				});
				if ($('#tax_class').val() == "") {
					$('#all_tax').show(); // Show the div
				} else {
					$('#all_tax').hide(); // Hide the div
				}
				var maxItems = 5;

				$('#kt_docs_repeater_basic').repeater({
					initEmpty: false,

					defaultValues: {
						'text-input': 'foo'
					},

					show: function () {
						 // Check the current number of items
						 var currentItems = $('#kt_docs_repeater_basic .repeater-item').length; // +1 includes the one being added now
						console.log("s",currentItems);
						if(currentItems <= maxItems) {
							$(this).slideDown();
						} else {
							alert('Maximum of ' + maxItems + ' items can be added.');
							// This is crucial: prevents the item from being added if max is reached
							$(this).remove(); 
						}
					},

					hide: function (deleteElement) {
						$(this).slideUp(deleteElement);
					}
				});
			});


		</script>