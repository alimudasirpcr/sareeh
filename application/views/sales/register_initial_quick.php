<?php $this->load->view("partial/header"); ?>
<style>
	#kt_app_page {
		display: none;
	}

	#kt_app_content_container {
		padding-right: 0.75rem !important;
		padding-left: 0.75rem !important;
	}
</style>
<div id="sales_page_holder">
	<!-- <img onclick="full_screen()" src="<?php echo base_url() . 'assets/css_good/media/icons/icons8-full-screen.gif'; ?>" >  -->




	<div id="register_container" class="sales clearfix">
		<?php $this->load->view("sales/register"); ?>
	</div>
</div>

<div id="operationsbox_modal" class="bg-white hidden-print" data-kt-drawer="true" data-kt-drawer-activate="true"  data-kt-drawer-close="#kt_drawer_example_basic_close" data-kt-drawer-width="700px">
	
<div class="card border-0 shadow-none rounded-0 w-100">
			<!--begin::Card header-->
			<div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4" id="kt_app_layout_builder_header" style="background-image:url('<?php echo base_url() ?>assets/css_good/media/misc/pattern-4.jpg')">

				<!--begin::Card title-->
				<h3 class="card-title fs-3 fw-bold text-white flex-column m-0" >
				<?= lang('advance_details') ?>
				</h3>
				<!--end::Card title-->

				<!--begin::Card toolbar-->
				<div class="card-toolbar">
					<button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1" id="kt_app_layout_builder_close">
						x </button>
				</div>
				<!--end::Card toolbar-->
			</div>
			<!--end::Card header-->
			<!--begin::Card body-->
			<div class="card-body position-relative" id="kt_app_layout_builder_body">
				<!--begin::Content-->
				<div id="kt_app_settings_content" class="position-relative gotodrawer scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_app_layout_builder_body" data-kt-scroll-dependencies="#kt_app_layout_builder_header, #kt_app_layout_builder_footer" data-kt-scroll-offset="5px">

				
						<div class="card-body p-0" >


					<div class="row">
						<!-- Tiers if its greater than 1 -->
						<?php if (count($tiers) > 1) {  ?>
							<div class="tier-group col-12  border border-dashed rounded min-w-125px h-50px py-5 px-4 ">
								<a tabindex="-1" href="#" class="item-tier <?php $this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id) ? 'enable-click' : ''; ?>">
									<?php echo lang('sales_item_tiers'); ?>: <span class="selected-tier"><?php echo H($tiers[$selected_tier_id]); ?></span>
								</a>
								<?php if ($this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id)) {	?>
									<div class="list-group item-tiers " style="display:none">
										<?php foreach ($tiers as $key => $value) { ?>
											<a tabindex="-1" href="#" data-value="<?php echo $key; ?>" class="list-group-item"><?php echo H($value); ?></a>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						<?php  }  ?>

						<!-- Tiers if its greater than 1 -->
						<?php if ($this->config->item('select_sales_person_during_sale')) {  ?>
							<div class="tier-group col-12  border border-dashed rounded min-w-125px  h-50px	 py-5 px-4 ">
								<a href="#" class="select-sales-person <?php $this->config->item('select_sales_person_during_sale') ? 'enable-click' : ''; ?>">
									<?php echo lang('sales_person'); ?>: <span class="selected-sales-person"><?php echo H($employees[$selected_sold_by_employee_id]); ?></span>
								</a>


								<div class="list-group select-sales-persons" style="display:none">
									<?php foreach ($employees as $key => $employee) { ?>
										<a href="#" data-value="<?php echo $key; ?>" class="list-group-item"><?php echo H($employee); ?></a>
									<?php } ?>
								</div>

							</div>
						<?php  }  ?>
						<?php if ($this->Employee->has_module_action_permission('sales', 'change_sale_date', $this->Employee->get_logged_in_employee_info()->person_id) && ($this->cart->get_previous_receipt_id() || $this->config->item('change_sale_date_for_new_sale'))) { ?>
							<div class="change-date form-check  col-12  border border-dashed rounded min-w-125px py-2  px-4">
								<div class="d-flex justify-content-between">
									<?php echo form_checkbox(array(
										'name' => 'change_date_enable',
										'id' => 'change_date_enable',
										'value' => '1',
										'class' => 'form-check-input ml-0',
										'checked' => (bool) $change_date_enable
									));
									echo '<label class="form-check-label" for="change_date_enable"><span></span>' . lang('change_date') . '</label>';

									?>

									<div id="change_cart_date_picker" class="input-group w-62 date datepicker">
										<span class="input-group-text"><i class="ion-calendar"></i></span>

										<?php echo form_input(array(
											'name' => 'change_cart_date',
											'id' => 'change_cart_date',
											'size' => '8',
											'class' => 'form-control',
											'value' => date(get_date_format() . " " . get_time_format(), $change_cart_date ? strtotime($change_cart_date) : time()),
										)); ?>
									</div>
								</div>
							</div>

						<?php } ?>

						<div class="comment-block col-12  border border-dashed rounded min-w-125px py-1  px-4">
							<?php
							foreach ($markup_predictions as $mark_payment_type => $mark_payment_data) {
								$amount = $mark_payment_data['amount'];
							?>
								<div class="markup_predictions" id="<?php echo $mark_payment_data['id']; ?>" style="display: none;">
									<span style="font-size: 19px;font-weight: bold;"><?php echo lang('sales_total_with_markup'); ?> </span> <span style="color: #6FD64B;font-size: 24px;font-weight: bold;float: right"><?php echo to_currency($total + $amount) ?></span>
								</div>
							<?php
							}
							?>

							<div class="d-flex justify-content-start">
								<div class="form-check form-check-custom form-check-solid w-62 ">
									<?php echo form_checkbox(array(
										'name' => 'show_comment_on_receipt',
										'id' => 'show_comment_on_receipt',
										'value' => '1',
										'class' => 'form-check-input mt-1 ',
										'checked' => (bool) $show_comment_on_receipt
									));
									echo '<label class="form-check-label " for="show_comment_on_receipt" ><span></span>' . lang('comments_receipt') . '</label>'; ?>
								</div>
								<div>
									<?php if ($comment) { ?>
										<i data-dismiss="true" data-placement="top" data-toggle="popover" title="<?= lang('comment') ?>" data-content="<?php echo  isset($comment) &&  $comment ? $comment : ''; ?>" class='fas fa-comment comment-popover mt-5'></i>
										<a href="#" id="comment" class="xeditable" data-validate-number="false" data-placement="bottom" data-type="text" data-pk="1" data-name="comment" data-url="<?php echo site_url('sales/set_comment'); ?>" data-title="<?php echo H(lang('comment')); ?>" data-emptytext="<i class='fas mt-3 fa-pencil'></i>" data-placeholder="<?php echo H(lang('comment')); ?>"><i class='fas mt-3 fa-pencil'></i></a>

										<script>
											$(function() {

												$('.comment-popover').popover({
													container: 'body'
												})
											})
										</script>

									<?php } else { ?>

										<a href="#" id="comment" class="xeditable" data-validate-number="false" data-placement="bottom" data-type="text" data-pk="1" data-name="comment" data-url="<?php echo site_url('sales/set_comment'); ?>" data-title="<?php echo H(lang('comment')); ?>" data-emptytext="<i class='fa mt-3 fa-comment'></i>" data-placeholder="<?php echo H(lang('comment')); ?>"><?php echo isset($comment)  ?  $comment : '' ?></a>

									<?php } ?>


								</div>
							</div>


						</div>







						<?php for ($k = 1; $k <= NUMBER_OF_PEOPLE_CUSTOM_FIELDS; $k++) { ?>
							<?php
							$custom_field = $this->Sale->get_custom_field($k);
							if ($custom_field !== FALSE) {

								$required = false;
								$required_text = '';
								if ($this->Sale->get_custom_field($k, 'required') && in_array($current_location, $this->Sale->get_custom_field($k, 'locations'))) {
									$required = true;
									$required_text = 'required';
									$text_alert = "text-danger";
								} else {
									$text_alert = '';
								}

							?>
								<div class="custom_field_block col-12 my-1  border border-dashed rounded min-w-125px  px-4 d-flex <?php echo "custom_field_${k}_value"; ?>">
									<?php echo form_label($custom_field, "custom_field_${k}_value", array('class' => 'control-label w-25 mt-3 ' . $text_alert)); ?>

									<?php if ($this->Sale->get_custom_field($k, 'type') == 'checkbox') { ?>
										<div class="form-check">
											<?php echo form_checkbox("custom_field_${k}_value", '1', (bool) $cart->{"custom_field_${k}_value"}, "id='custom_field_${k}_value' class='custom-fields-checkbox customFields form-check-input' $required_text"); ?>
											<label class="form-check-label w-25" for="<?php echo "custom_field_${k}_value"; ?>"><span></span></label>
										</div>
									<?php } elseif ($this->Sale->get_custom_field($k, 'type') == 'date') { ?>

										<?php echo form_input(array(
											'name' => "custom_field_${k}_value",
											'id' => "custom_field_${k}_value",
											'class' => "custom_field_${k}_value" . ' form-control custom-fields-date customFields',
											'value' => is_numeric($cart->{"custom_field_${k}_value"}) ? date(get_date_format(), $cart->{"custom_field_${k}_value"})	 : '',
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

									<?php } elseif ($this->Sale->get_custom_field($k, 'type') == 'dropdown') { ?>

										<?php
										$choices = explode('|', $this->Sale->get_custom_field($k, 'choices'));
										$select_options = array('' => lang('please_select'));
										foreach ($choices as $choice) {
											$select_options[$choice] = $choice;
										}
										echo form_dropdown("custom_field_${k}_value", $select_options, $cart->{"custom_field_${k}_value"}, 'class="form-control custom-fields-select customFields" ' . $required_text); ?>

									<?php } elseif ($this->Sale->get_custom_field($k, 'type') == 'image' || $this->Sale->get_custom_field($k, 'type') == 'file') {
										echo form_input(
											array(
												'name' => "custom_field_${k}_value",
												'id' => "custom_field_${k}_value",
												'type' => 'file',
												'class' => "custom_field_${k}_value" . ' form-control custom-fields-file customFields'
											),
											NULL,
											$cart->{"custom_field_${k}_value"} ? "" : $required_text
										);

										if ($cart->{"custom_field_${k}_value"} && $this->Sale->get_custom_field($k, 'type') == 'image') {
											echo "<img width='30%' src='" . app_file_url($cart->{"custom_field_${k}_value"}) . "' />";
											echo "<div class='delete-custom-image-sale'><a href='" . site_url('sales/delete_custom_field_value/' . $k) . "'>" . lang('delete') . "</a></div>";
										} elseif ($cart->{"custom_field_${k}_value"} && $this->Sale->get_custom_field($k, 'type') == 'file') {
											echo anchor('sales/download/' . $cart->{"custom_field_${k}_value"}, $this->Appfile->get_file_info($cart->{"custom_field_${k}_value"})->file_name, array('target' => '_blank'));
											echo "<div class='delete-custom-image-sale'><a href='" . site_url('sales/delete_custom_field_value/' . $k) . "'>" . lang('delete') . "</a></div>";
										}
									} else {

										echo form_input(array(
											'name' => "custom_field_${k}_value",
											'id' => "custom_field_${k}_value",
											'class' => "custom_field_${k}_value" . ' form-control custom-fields customFields',
											'value' => $cart->{"custom_field_${k}_value"},
											($required ? $required_text : $required_text) => ($required ? $required_text : $required_text)
										)); ?>
									<?php } ?>
									<?php echo '</div>' ?>
								<?php } //end if
								?>

							<?php } //end for loop
							?>

							<script>
								$('.custom-fields').change(function() {
									$.post('<?php echo site_url("sales/save_custom_field"); ?>', {
										name: $(this).attr('name'),
										value: $(this).val()
									});
								});

								$('.custom-fields-checkbox').change(function() {
									$.post('<?php echo site_url("sales/save_custom_field"); ?>', {
										name: $(this).attr('name'),
										value: $(this).prop('checked') ? 1 : 0
									});
								});

								$('.custom-fields-select').change(function() {
									$.post('<?php echo site_url("sales/save_custom_field"); ?>', {
										name: $(this).attr('name'),
										value: $(this).val()
									});
								});

								$(".custom-fields-date").on("dp.change", function(e) {
									$.post('<?php echo site_url("sales/save_custom_field"); ?>', {
										name: $(this).attr('name'),
										value: $(this).val()
									});
								});

								$('.custom-fields-file').change(function() {

									var formData = new FormData();
									formData.append('name', $(this).attr('name'));
									formData.append('value', $(this)[0].files[0]);

									$.ajax({
										url: '<?php echo site_url("sales/save_custom_field"); ?>',
										type: 'POST',
										data: formData,
										processData: false,
										contentType: false
									});
								});
							</script>

							<?php

							?>

							<!-- Finish Sale Button Handler -->

							<?php
							$this->load->helper('sale');


							if ($has_coupons_for_today) { ?>
								<div class="add-coupon col-6  border border-dashed rounded min-w-125px py-4 px-4">
									<div class="side-heading"><?php echo lang('add_coupon'); ?></div>

									<div id="coupons" class="input-group" data-title="coupons">
										<span class="input-group-text xl icon ion-ios-pricetags-outline"></span>
										<?php echo form_input(array('name' => 'coupons', 'id' => 'coupons', 'class' => 'coupon_codes input-lg add-input form-control', 'placeholder' => '', 'data-title' => lang('enter_a_coupon'))); ?>
									</div>

								</div>
							<?php } ?>

							<?php



							// Only show this part if there is at least one payment entered.
							//if ((is_all_sale_credit_card_payments_confirmed($cart) && count($payments) > 0) || (count($payments) > 0 && !is_sale_integrated_cc_processing($cart) && !is_sale_integrated_ebt_sale($cart) )) { 
								if (1==1) { ?>
							<div id="finish_sale" class="finish-sale col-6  border border-dashed rounded min-w-125px py-1  px-4 d-flex">
									<?php echo form_open("sales/complete", array('id' => 'finish_sale_form',  'class' => 'form-check form-check-custom form-check-solid', 'autocomplete' => 'off')); ?>
									<?php
									if ($payments_cover_total && $customer_required_check) {
										echo "<input type='button' class='btn btn-success d-none btn-large btn-block' id='finish_sale_button' value='" . lang('sales_complete_sale') . "' />";
									}


									echo form_checkbox(array(
										'name' => 'prompt_for_card',
										'id' => 'prompt_for_card',
										'class' => 'form-check-input mt-1',
										'value' => '1',
										'checked' => (bool) $prompt_for_card
									));
									echo '<label class="form-check-label" for="prompt_for_card"><span></span>' . lang('prompt_for_card') . '</label>';


									if ($cc_processor_class_name == 'CORECLEARBLOCKCHYPPROCESSOR' && $this->Location->get_info_for_key('blockchyp_terms_and_conditions')) {
										echo '<br />';
										echo form_checkbox(array(
											'name' => 'show_terms_and_conditions',
											'id' => 'show_terms_and_conditions',
											'value' => '1',
											'class' => 'form-check-input',
											'checked' => (bool) $show_terms_and_conditions
										));
										echo '<label  class="form-check-label" for="show_terms_and_conditions"><span></span>' . lang('show_terms_and_conditions') . '</label>';
									}
									echo form_close();
									?>
								</div>

							<?php } else { ?>
								<div id="finish_sale" class="finish-sale col-6  border border-dashed rounded min-w-125px py-4 px-4 d-flex">
									<?php echo form_open("sales/start_cc_processing?provider=" . rawurlencode($this->Location->get_info_for_key('credit_card_processor') ? $this->Location->get_info_for_key('credit_card_processor') : ''), array('id' => 'finish_sale_form', 'class' => 'form-check form-check-custom form-check-solid', 'autocomplete' => 'off')); ?>
									<?php
									if ($this->Location->get_info_for_key('enable_credit_card_processing')) {
										echo '<div id="credit_card_options" style="display: none;">';
										if (isset($customer) && $customer_cc_token && $customer_cc_preview) {
											echo form_checkbox(array(
												'name' => 'use_saved_cc_info',
												'id' => 'use_saved_cc_info',
												'class' => 'form-check-input',
												'value' => '1',
												'checked' => (bool) $use_saved_cc_info
											));
											echo '<label class="form-check-label" for="use_saved_cc_info"><span></span>' . lang('sales_use_saved_cc_info') . ' ' . $customer_cc_preview . '</label>';
										} elseif (isset($customer)) {
											echo form_checkbox(array(
												'name' => 'save_credit_card_info',
												'id' => 'save_credit_card_info',
												'class' => 'form-check-input',
												'value' => '1',
												'checked' => (bool) $save_credit_card_info
											));
											echo '<label class="form-check-label" for="save_credit_card_info"><span></span>' . lang('sales_save_credit_card_info') . '</label>';
										}

										//If we are an EMV processor OR transcloud we need a way to prompt for card
										if ($cc_processor_parent_class_name == 'DATACAPUSBPROCESSOR' || $cc_processor_parent_class_name == 'DATACAPTRANSCLOUDPROCESSOR' || $cc_processor_class_name == 'CARDCONNECTPROCESSOR' || $cc_processor_class_name == 'CORECLEARBLOCKCHYPPROCESSOR') {
											echo '<div style="text-align: center;">';

											if (is_system_integrated_ebt($cart)) {
									?>
												<div class="btn-group btn-group-lg .btn-group-justified" role="group" aria-label="..." id="ebt-balance-buttons" style="display: none;">
													<a role="button" href="<?php echo site_url('sales/get_emv_ebt_balance/Foodstamp'); ?>" class="btn btn-default"><span class="icon ti-wallet"></span> <?php echo lang('sales_ebt_balance'); ?></a>
													<a role="button" href="<?php echo site_url('sales/get_emv_ebt_balance/Cash'); ?>" class="btn btn-default"><span class="icon ti-money"></span> <?php echo lang('sales_ebt_cash_balance'); ?></a>
												</div>
									<?php
											}
											echo '</div>';

											echo form_checkbox(array(
												'name' => 'prompt_for_card',
												'id' => 'prompt_for_card',
												'value' => '1',
												'class' => 'form-check-input',
												'checked' => (bool) $prompt_for_card
											));
											echo '<label class="form-check-label" for="prompt_for_card"><span></span>' . lang('prompt_for_card') . '</label>';


											if ($cc_processor_class_name == 'CORECLEARBLOCKCHYPPROCESSOR' && $this->Location->get_info_for_key('blockchyp_terms_and_conditions')) {
												echo '<br />';

												echo form_checkbox(array(
													'name' => 'show_terms_and_conditions',
													'id' => 'show_terms_and_conditions',
													'value' => '1',
													'class' => 'form-check-input',
													'checked' => (bool) $show_terms_and_conditions
												));
												echo '<label class="form-check-label" for="show_terms_and_conditions"><span></span>' . lang('show_terms_and_conditions') . '</label>';
											}


											if (is_system_integrated_ebt($cart)) {
												echo '<div id="ebt_voucher_toggle_holder">';
												echo form_checkbox(array(
													'name' => 'ebt_voucher_toggle',
													'id' => 'ebt_voucher_toggle',
													'value' => '1',
													'class' => 'form-check-input',
													'checked' => (bool) $ebt_voucher
												));
												echo '<label class="form-check-label" for="ebt_voucher_toggle"><span></span>' . lang('sales_enter_voucher') . '</label>';
												echo '</div>';
											}
										}

										echo '<div id="ebt_voucher" style="display:none;">';
										echo '<input value="' . H($ebt_voucher_no) . '" type="text" class="form-control text-center" name="ebt_voucher_no" id="ebt_voucher_no" placeholder="' . lang('sales_ebt_voucher_no') . '">';
										echo '<input value="' . H($ebt_auth_code) . '" type="text" class="form-control text-center" name="ebt_auth_code" id="ebt_auth_code" placeholder="' . lang('sales_ebt_auth_code') . '">';
										echo '</div>';
										echo '</div>';
									}


								
												echo "<input type='button' class='btn btn-success d-none btn-large btn-block' id='finish_sale_button' value='" . lang('sales_process_credit_card') . "' />";
											
									echo form_close();
									?>
								</div>
								</div>
							<?php }

							?>


					</div>
				</div>

				<?php
				if ($mode == 'store_account_payment') {
					if (!empty($unpaid_store_account_sales)) {
				?>
						<table id="unpaid_sales" class="table table-hover table-condensed">
							<thead>
								<tr class="register-items-header">
									<th class="sp_sale_id"><?php echo lang('sale_id'); ?></th>
									<th class="sp_date"><?php echo lang('date'); ?></th>
									<th class="sp_charge"><?php echo lang('total_charge_to_account'); ?></th>
									<th class="sp_comment"><?php echo lang('comment'); ?></th>
									<th class="sp_pay"><?php echo lang('pay'); ?></th>
								</tr>
							</thead>

							<tbody id="unpaid_sales_data">

								<?php
								foreach ($unpaid_store_account_sales as $unpaid_sale) {

									$row_class = isset($unpaid_sale['paid']) && $unpaid_sale['paid'] == TRUE ? 'success' : 'active';
									$btn_class = isset($unpaid_sale['paid']) && $unpaid_sale['paid'] == TRUE ? 'btn-danger' : 'btn-primary';
								?>
									<tr class="<?php echo $row_class; ?>">
										<td class="sp_sale_id text-center"><?php echo anchor('sales/receipt/' . $unpaid_sale['sale_id'], ($this->config->item('sale_prefix') ? $this->config->item('sale_prefix') : 'POS') . ' ' . $unpaid_sale['sale_id'], array('target' => '_blank')); ?></td>
										<td class="sp_date text-center"><?php echo date(get_date_format() . ' ' . get_time_format(), strtotime($unpaid_sale['sale_time'])); ?></td>
										<td class="sp_charge text-center">
											<?php
											if (isset($exchange_name) && $exchange_name) {
												echo to_currency_as_exchange($cart, $unpaid_sale['payment_amount'] * $exchange_rate);
											} else {
												echo to_currency($unpaid_sale['payment_amount']);
											}
											?>
										</td>
										<td class="sp_comment text-center"><?php echo $unpaid_sale['comment'] ?></td>
										<td class="sp_pay text-center">
											<?php echo form_open("sales/" . ((isset($unpaid_sale['paid']) && $unpaid_sale['paid'] == TRUE) ? "delete" : "pay") . "_store_account_sale/" . $unpaid_sale['sale_id'] . "/" . to_currency_no_money($unpaid_sale['payment_amount']), array('class' => 'pay_store_account_sale_form', 'autocomplete' => 'off', 'data-full-amount' => to_currency_no_money($unpaid_sale['payment_amount']))); ?>
											<button type="submit" class="btn <?php echo $btn_class; ?> pay_store_account_sale"><?php echo isset($unpaid_sale['paid']) && $unpaid_sale['paid'] == TRUE  ? lang('remove_payment') : lang('pay'); ?></button>
											</form>
										</td>
									</tr>
							<?php
								}
							}
							?>
							</tbody>
						</table>
						<?php
						?>

					<?php

				}
					?>
					<div class="model-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal"><?= lang('close') ?></button>
					</div>
			</div>

		</div>

	</div>

	<script type="text/javascript">
		$(document).ready(function() {

			$('#advance_details').on('click', function() {

				var operationsbox_modal = document.querySelector("#operationsbox_modal");

					var drawer  = KTDrawer.getInstance(operationsbox_modal);
					drawer.show();
			});
			<?php if ($this->config->item('require_employee_login_before_each_sale') && isset($dont_switch_employee) && !$dont_switch_employee) { ?>
				$('#switch_user').trigger('click');
			<?php } ?>

			$(window).load(function() {
				setTimeout(function() {
					<?php if ($fullscreen) { ?>
						$('.fullscreen').click();
					<?php } else {
					?>
						$('.dismissfullscreen').click();
					<?php
					} ?>

				}, 0);
			});

			<?php if ($this->config->item('always_show_item_grid') && $mode != 'store_account_payment') { ?>
				$(".show-grid").click();
			<?php } ?>

			var current_category_id = null;
			var current_tag_id = null;
			var current_supplier_id = null;

			var categories_stack = [{
				category_id: 0,
				name: <?php echo json_encode(lang('all')); ?>
			}];

			function updateBreadcrumbs(item_name) {
				var breadcrumbs = '<span class="svg-icon svg-icon-2 svg-icon-primary me-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 12C22 12.2 22 12.5 22 12.7L19.5 10.2L16.9 12.8C16.9 12.5 17 12.3 17 12C17 9.5 15.2 7.50001 12.8 7.10001L10.2 4.5L12.7 2C17.9 2.4 22 6.7 22 12ZM11.2 16.9C8.80001 16.5 7 14.5 7 12C7 11.7 7.00001 11.5 7.10001 11.2L4.5 13.8L2 11.3C2 11.5 2 11.8 2 12C2 17.3 6.09999 21.6 11.3 22L13.8 19.5L11.2 16.9Z" fill="currentColor"/><path opacity="0.3" d="M22 12.7C21.6 17.9 17.3 22 12 22C11.8 22 11.5 22 11.3 22L13.8 19.5L11.2 16.9C11.5 16.9 11.7 17 12 17C14.5 17 16.5 15.2 16.9 12.8L19.5 10.2L22 12.7ZM10.2 4.5L12.7 2C12.5 2 12.2 2 12 2C6.7 2 2.4 6.1 2 11.3L4.5 13.8L7.10001 11.2C7.50001 8.8 9.5 7 12 7C12.3 7 12.5 7.00001 12.8 7.10001L10.2 4.5Z" fill="currentColor"/></svg></span> ';
				for (var k = 0; k < categories_stack.length; k++) {
					var category_name = categories_stack[k].name;
					var category_id = categories_stack[k].category_id;

					breadcrumbs += (k != 0 ? '  ' : '') + '<a href="javascript:void(0);"class="category_breadcrumb_item " data-category_id = "' + category_id + '">' + category_name + ' 	<span class="svg-icon svg-icon-2 svg-icon-primary mx-1"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path></svg></span> </a>';
				}

				if (typeof item_name != "undefined" && item_name) {
					breadcrumbs += '  : ' + item_name;
				}

				$("#grid_breadcrumbs").html(breadcrumbs);
			}

			$(document).on('click', ".category_breadcrumb_item", function() {
				var clicked_category_id = $(this).data('category_id');
				var categories_size = categories_stack.length;
				current_category_id = clicked_category_id;

				for (var k = 0; k < categories_size; k++) {
					var current_category = categories_stack[k]
					var category_id = current_category.category_id;

					if (category_id == clicked_category_id) {
						if (categories_stack[k + 1] != undefined) {
							categories_stack.splice(k + 1, categories_size - k - 1);
						}
						break;
					}
				}

				if (current_category_id != 0) {
					loadCategoriesAndItems(current_category_id, 0);
				} else {
					loadTopCategories();
				}
			});

			function loadTopCategories() {
				$('#grid-loader').show();
				$.get('<?php echo site_url("sales/categories"); ?>', function(json) {
					processCategoriesResult(json);
					$('#category_item_selection li:first-child').trigger('click');
				}, 'json');
			}

			function loadTags() {
				$('#grid-loader').show();
				$.get('<?php echo site_url("sales/tags"); ?>', function(json) {
					processTagsResult(json);
				}, 'json');
			}

			function loadSuppliers() {
				$('#grid-loader').show();
				$.get('<?php echo site_url("sales/suppliers"); ?>', function(json) {
					processSuppliersResult(json);
				}, 'json');
			}


			function loadCategoriesAndItems(category_id, offset) {
				$('#grid-loader').show();
				current_category_id = category_id;
				//Get sub categories then items
				$.get('<?php echo site_url("sales/categories_and_items"); ?>/' + current_category_id + '/' + offset, function(json) {
					processCategoriesAndItemsResult(json);
				}, "json");
			}

			function loadCategoriesAndItemsUrl(category_id, url) {
				$('#grid-loader').show();
				current_category_id = category_id;
				//Get sub categories then items
				$.get(url, function(json) {
					processCategoriesAndItemsResult(json);
				}, "json");
			}

			function loadTagItems(tag_id, offset) {
				$('#grid-loader').show();
				current_tag_id = tag_id;
				//Get sub categories then items
				$.get('<?php echo site_url("sales/tag_items"); ?>/' + tag_id + '/' + offset, function(json) {
					processTagItemsResult(json);
				}, "json");
			}

			function loadTagItemsUrl(tag_id, url) {
				$('#grid-loader').show();
				current_tag_id = tag_id;
				//Get sub categories then items
				$.get(url, function(json) {
					processTagItemsResult(json);
				}, "json");
			}

			function loadFavoriteItems(offset) {
				$('#grid-loader').show();
				//Get sub categories then items
				$.get('<?php echo site_url("sales/favorite_items"); ?>/' + offset, function(json) {
					processFavoriteItemsResult(json);
				}, "json");
			}

			function loadFavoriteItemsUrl(url) {
				$('#grid-loader').show();
				$.get(url, function(json) {
					processFavoriteItemsResult(json);
				}, "json");
			}

			function loadSupplierItem(supplier_id, offset) {
				$('#grid-loader').show();
				current_supplier_id = supplier_id;
				//Get sub categories then items
				$.get('<?php echo site_url("sales/supplier_items"); ?>/' + supplier_id + '/' + offset, function(json) {
					processSupplierItemsResult(json);
				}, "json");
			}

			function loadSupplierItemsUrl(supplier_id, url) {
				$('#grid-loader').show();
				current_supplier_id = supplier_id;
				//Get sub categories then items
				$.get(url, function(json) {
					processSupplierItemsResult(json);
				}, "json");
			}



			$(document).on('click', ".pagination.categories a", function(event) {
				$('#grid-loader').show();
				event.preventDefault();
				$.get($(this).attr('href'), function(json) {
					processCategoriesResult(json);

				}, "json");
			});

			$(document).on('click', ".pagination.tags a", function(event) {
				$('#grid-loader').show();
				event.preventDefault();

				$.get($(this).attr('href'), function(json) {
					processTagsResult(json);

				}, "json");
			});

			$(document).on('click', ".pagination.suppliers a", function(event) {
				$('#grid-loader').show();
				event.preventDefault();

				$.get($(this).attr('href'), function(json) {
					processSuppliersResult(json);

				}, "json");
			});

			$(document).on('click', ".pagination.categoriesAndItems a", function(event) {
				$('#grid-loader').show();
				event.preventDefault();
				loadCategoriesAndItemsUrl(current_category_id, $(this).attr('href'));
			});

			$(document).on('click', ".pagination.items a", function(event) {
				$('#grid-loader').show();
				event.preventDefault();
				loadTagItemsUrl(current_tag_id, $(this).attr('href'));
			});

			$(document).on('click', ".pagination.favorite a", function(event) {
				$('#grid-loader').show();
				event.preventDefault();
				loadFavoriteItemsUrl($(this).attr('href'));
			});

			$(document).on('click', ".pagination.supplierItems a", function(event) {
				$('#grid-loader').show();
				event.preventDefault();
				loadSupplierItemsUrl(current_supplier_id, $(this).attr('href'));
			});



			$('#category_item_selection_wrapper').on('click', '.category_item.category', function(event) {
				event.preventDefault();
				current_category_id = $(this).data('category_id');
				category_count = $(this).data('category_count');
				var category_obj = {
					category_id: current_category_id,
					name: $(this).find('p').text()
				};
				if (category_count > 0) {
					categories_stack.push(category_obj);
				}

				loadCategoriesAndItems($(this).data('category_id'), 0);
			});

			$('#category_item_selection_wrapper').on('click', '.category_item.tag', function(event) {
				event.preventDefault();
				current_tag_id = $(this).data('tag_id');
				loadTagItems($(this).data('tag_id'), 0);
			});

			$('#category_item_selection_wrapper').on('click', '.category_item.supplier', function(event) {
				event.preventDefault();
				current_supplier_id = $(this).data('supplier_id');
				loadSupplierItem($(this).data('supplier_id'), 0);
			});


			$('#grid_selection').on('click', '#by_category', function(event) {
				current_category_id = null;
				current_tag_id = null;
				$("#grid_breadcrumbs").html('');
				$('.menu-link').removeClass('active');
				$(this).addClass('active');
				categories_stack = [{
					category_id: 0,
					name: <?php echo json_encode(lang('all')); ?>
				}];
				loadTopCategories();
			});

			$('#grid_selection').on('click', '#by_tag', function(event) {
				current_category_id = null;
				current_tag_id = null;
				$('.menu-link').removeClass('active');
				$(this).addClass('active');
				$("#grid_breadcrumbs").html('');
				loadTags();
			});

			$('#grid_selection').on('click', '#by_favorite', function(event) {
				current_category_id = null;
				current_tag_id = null;
				$('.menu-link').removeClass('active');
				$(this).addClass('active');
				$("#grid_breadcrumbs").html('');
				loadFavoriteItems(0);
			});

			$('#grid_selection').on('click', '#by_supplier', function(event) {
				current_category_id = null;
				current_tag_id = null;
				current_supplier_id = null;
				$("#grid_breadcrumbs").html('');
				$('.menu-link').removeClass('active');
				$(this).addClass('active');
				loadSuppliers();
			});


			$('#category_item_selection_wrapper').on('click', '.category_item.item', function(event) {
				$('#grid-loader').show();
				event.preventDefault();
				alert("ues");
			return false;
				var $that = $(this);
				if ($(this).data('has-variations')) {
					$.getJSON('<?php echo site_url("sales/item_variations"); ?>/' + $(this).data('id'), function(json) {
						$("#category_item_selection").html('');
						$("#category_item_selection_wrapper .pagination").html('');

						if (current_category_id) {
							//var back_button = $("<div/>").attr('id', 'back_to_category').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');

							var back_button = '<li id="back_to_category" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
						} else if (current_supplier_id) {
							//var back_button = $("<div/>").attr('id', 'back_to_supplier').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');

							var back_button = '<li id="back_to_supplier" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


						} else if ($that.data('is_favorite')) {
							//var back_button = $("<div/>").attr('id', 'back_to_favorite').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');

							var back_button = '<li id="back_to_favorite" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

						} else {
							//	var back_button = $("<div/>").attr('id', 'back_to_tag').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');
							var back_button = '<li id="back_to_tag" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
						}



						$("#category_item_selection").append(back_button);

						for (var k = 0; k < json.length; k++) {
							var image_src = json[k].image_src;
							var prod_image = "";
							var image_class = "no-image";
							var item_parent_class = "";
							if (image_src != '') {
								var item_parent_class = "item_parent_class";
								var prod_image = '<img  class="rounded-3 mb-4 h-50px" src="' + image_src + '" alt="" />';
								var image_class = "";
							} else {
								var item_parent_class = "item_parent_class";
								var prod_image = '<img class="rounded-3 mb-4 h-50px " src="' + SITE_URL + '/assets/css_good/media/icons/varient.png" alt="" />';
								var image_class = "";
							}
							/// dynamic attributes for item:varients

							//	var item = $("<div/>").attr('data-has-variations', 0).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json[k].id).append(prod_image + '<p>' + json[k].name + '<br /> <span class="text-bold">' + (json[k].price ? '(' + json[k].price + ')' : '') + '</span></p>');


							var item = '<li data-has-variations="0" data-id="' + json[k].id + '" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> ' + prod_image + '</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json[k].name + ' <span class="text-bold">' + (json[k].price ? '(' + decodeHtml(json[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
							$("#category_item_selection").append(item);
							if (current_category_id) {
								updateBreadcrumbs($that.text());
							}
						}

						$('#grid-loader').hide();

					});
				} else {

					$.post('<?php echo site_url("sales/add"); ?>', {
						item: $(this).data('id') + "|FORCE_ITEM_ID|"
					}, function(response) {
						<?php
						if (!$this->config->item('disable_sale_notifications')) {
							echo "show_feedback('success', " . json_encode(lang('successful_adding')) . ", " . json_encode(lang('success')) . ");";
						}

						?>
						$('#grid-loader').hide();
						$("#sales_section").html(response);
						$('.show-grid').addClass('hidden');
						$('.hide-grid').removeClass('hidden');

					});
				}
			});



			$('#category_item_selection_wrapper_new').on('click', '.category_item.item', function(event) {
				$('#grid-loader').show();
				event.preventDefault();
				
				if($(this).data('id')=='add_item'){
					$('#grid-loader').hide();

					window.location.href = '<?= site_url("items/view/-1?redirect=sales/index/1&progression=1"); ?>';
					return;
				}
				var $that = $(this);
				if ($(this).data('has-variations')) {
					$.getJSON('<?php echo site_url("sales/item_variations"); ?>/' + $(this).data('id'), function(json) {
						$("#category_item_selection").html('');
						$("#category_item_selection_wrapper .pagination").html('');

						if (current_category_id) {
							//var back_button = $("<div/>").attr('id', 'back_to_category').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');

							var back_button = '<li id="back_to_category" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
						} else if (current_supplier_id) {
							//var back_button = $("<div/>").attr('id', 'back_to_supplier').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');

							var back_button = '<li id="back_to_supplier" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


						} else if ($that.data('is_favorite')) {
							//var back_button = $("<div/>").attr('id', 'back_to_favorite').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');

							var back_button = '<li id="back_to_favorite" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

						} else {
							//	var back_button = $("<div/>").attr('id', 'back_to_tag').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');
							var back_button = '<li id="back_to_tag" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
						}



						$("#category_item_selection").append(back_button);

						for (var k = 0; k < json.length; k++) {
							var image_src = json[k].image_src;
							var prod_image = "";
							var image_class = "no-image";
							var item_parent_class = "";
							if (image_src != '') {
								var item_parent_class = "item_parent_class";
								var prod_image = '<img class="rounded-3 mb-4 h-50px" src="' + image_src + '" alt="" />';
								var image_class = "";
							} else {
								var item_parent_class = "item_parent_class";
								var prod_image = '<img class="rounded-3 mb-4 h-50px" src="' + SITE_URL + '/assets/css_good/media/icons/varient.png" alt="" />';
								var image_class = "";
							}
							/// dynamic attributes for item:varients

							//	var item = $("<div/>").attr('data-has-variations', 0).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json[k].id).append(prod_image + '<p>' + json[k].name + '<br /> <span class="text-bold">' + (json[k].price ? '(' + json[k].price + ')' : '') + '</span></p>');


							var item = '<li data-has-variations="0" data-id="' + json[k].id + '" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> ' + prod_image + '</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json[k].name + ' <span class="text-bold">' + (json[k].price ? '(' + decodeHtml(json[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
							$("#category_item_selection").append(item);
							if (current_category_id) {
								updateBreadcrumbs($that.text());
							}
						}

						$('#grid-loader').hide();

					});
				} else {




					$.post('<?php echo site_url("sales/add"); ?>', {
						item: $(this).data('id') + "|FORCE_ITEM_ID|"
					}, function(response) {
						<?php
						if (!$this->config->item('disable_sale_notifications')) {
							echo "show_feedback('success', " . json_encode(lang('successful_adding')) . ", " . json_encode(lang('success')) . ");";
						}

						?>
						$('#grid-loader').hide();
						$("#sales_section").html(response);
						$('.show-grid').addClass('hidden');
						$('.hide-grid').removeClass('hidden');

					});
				}
			});





			$("#category_item_selection_wrapper").on('click', '#back_to_categories', function(event) {
				$('#grid-loader').show();
				event.preventDefault();

				//Remove element from stack
				categories_stack.pop();

				//Get current last element
				var back_category = categories_stack[categories_stack.length - 1];

				if (back_category.category_id != 0) {
					loadCategoriesAndItems(back_category.category_id, 0);
				} else {
					loadTopCategories();
				}
			});

			$("#category_item_selection_wrapper").on('click', '#back_to_tags', function(event) {
				$('#grid-loader').show();
				event.preventDefault();
				loadTags();
			});

			$("#category_item_selection_wrapper").on('click', '#back_to_tag', function(event) {
				$('#grid-loader').show();
				event.preventDefault();
				loadTagItems(current_tag_id, 0);
			});

			$("#category_item_selection_wrapper").on('click', '#back_to_category', function(event) {
				$('#grid-loader').show();
				event.preventDefault();

				//Get current last element
				var back_category = categories_stack[categories_stack.length - 1];

				if (back_category.category_id != 0) {
					loadCategoriesAndItems(back_category.category_id, 0);
				} else {
					loadTopCategories();
				}
			});

			$("#category_item_selection_wrapper").on('click', '#back_to_favorite', function(event) {
				$('#grid-loader').show();
				event.preventDefault();
				loadFavoriteItems(0);
			});

			$("#category_item_selection_wrapper").on('click', '#back_to_suppliers', function(event) {
				$('#grid-loader').show();
				event.preventDefault();
				loadSuppliers();
			});

			$("#category_item_selection_wrapper").on('click', '#back_to_supplier', function(event) {
				$('#grid-loader').show();
				event.preventDefault();
				loadSuppliersItems(current_supplier_id, 0);
			});



			function processCategoriesResult(json) {
				$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('tags').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('categories');
				$("#category_item_selection_wrapper .pagination").html(json.pagination);

				$("#category_item_selection").html('');

				for (var k = 0; k < json.categories.length; k++) {
					var category_item = $("<div/>").attr('class', 'category_item category col-md-2 register-holder categories-holder col-sm-3 col-xs-6').css('background-color', json.categories[k].color).data('category_id', json.categories[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.categories[k].name + '</p>');

					if (json.categories[k].image_id) {
						category_item.css('background-color', 'white');
						category_item.css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.categories[k].image_id + '?timestamp=' + json.categories[k].image_timestamp + ')');
					}

					var categ_badge = '';
					if (json.categories[k].categories_count > 0) {
						categ_badge = '<span class="symbol-badge badge badge-circle bg-danger top-10 start-15">' + json.categories[k].categories_count + '</span>';
					}
					var item_badge = '';
					if (json.categories[k].items_count > 0) {
						item_badge = '<span class="symbol-badge badge badge-circle bg-success top-10 start-80">' + json.categories[k].items_count + '</span>';
					}
					if (json.categories[k].color != '') {
						category_style = "style='background-color:" + json.categories[k].color + " '";
					} else {
						category_style = "";
					}

					category_item = '<li data-category_count="' + json.categories[k].categories_count + '" data-category_id="' + json.categories[k].id + '" class="  category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation" ' + category_style + ' ><a class="border border-gray-900  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active symbol" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"> ' + item_badge + ' ' + categ_badge + ' <div class="nav-icon "> <img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.categories[k].image_id + '?timestamp=' + json.categories[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


					$("#category_item_selection").append(category_item);
					$('.register-holder.categories-holder').click(function() {
						if ($(this).data('category_count') == 0) {
							// Remove selected-holder class from siblings
							$(this).siblings().removeClass('selected-holder');

							// Add selected-holder class to the clicked element
							$(this).addClass('selected-holder');
						}
					});
				}

				updateBreadcrumbs();
				$('#grid-loader').hide();
			}

			function processTagsResult(json) {
				$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('categories').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('tags');
				$("#category_item_selection_wrapper .pagination").html(json.pagination);

				$("#category_item_selection").html('');

				for (var k = 0; k < json.tags.length; k++) {
					//var tag_item = $("<div/>").attr('class', 'category_item tag col-md-2 register-holder tags-holder col-sm-3 col-xs-6').data('tag_id', json.tags[k].id).append('<p> <i class="ion-ios-pricetag-outline"></i> ' + json.tags[k].name + '</p>');

					var tag_item = '<li data-tag_id="' + json.tags[k].id + '"  class=" col-1  category_item tag register-holder tags-holder  nav-item mb-3 me-3 me-lg-6" role="presentation"><div class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active " data-bs-toggle="pill"  aria-selected="true" role="tab"><div class="nav-icon"><i class="ion-ios-pricetag-outline text-danger " style="font-size:60px"></i> </div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.tags[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></div></li>';

					$("#category_item_selection").append(tag_item);
				}

				$('#grid-loader').hide();
			}

			function processSuppliersResult(json) {
				$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('tags').removeClass('items').removeClass('categories').removeClass("supplierItems").addClass('suppliers');
				$("#category_item_selection_wrapper .pagination").html(json.pagination);

				$("#category_item_selection").html('');

				for (var k = 0; k < json.suppliers.length; k++) {
					// var supplier_item = $("<div/>").attr('class', 'category_item supplier col-md-2 register-holder categories-holder col-sm-3 col-xs-6').data('supplier_id', json.suppliers[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.suppliers[k].name + '</p>');

					// if (json.suppliers[k].image_id) {
					// 	supplier_item.css('background-color', 'white');
					// 	supplier_item.css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.suppliers[k].image_id + '?timestamp=' + json.suppliers[k].image_timestamp + ')');
					// }

					supplier_item = '<li data-supplier_id="' + json.suppliers[k].id + '" class=" col-2 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-125px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.suppliers[k].image_id + '?timestamp=' + json.suppliers[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.suppliers[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


					$("#category_item_selection").append(supplier_item);
				}
				$('#grid-loader').hide();
			}

			function processCategoriesAndItemsResult(json) {



				$("#category_item_selection_wrapper_new").html('');

				if (json.categories_count > 0) {
					$("#category_item_selection").html('');
					var back_to_categories_button = '<li id="back_to_categories" class="  nav-item mb-3 me-3 pr-0 pl-0 register-holder" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

					$("#category_item_selection").append(back_to_categories_button);
				}


				for (var k = 0; k < json.categories_and_items.length; k++) {
					var categ_badge = '';
					if (json.categories_and_items[k].categories_count > 0) {
						categ_badge = '<span class="symbol-badge badge badge-circle bg-danger top-10 start-15">' + json.categories_and_items[k].categories_count + '</span>';
					}
					var item_badge = '';
					if (json.categories_and_items[k].items_count > 0) {
						item_badge = '<span class="symbol-badge badge badge-circle bg-success top-10 start-80">' + json.categories_and_items[k].items_count + '</span>';
					}

					if (json.categories_and_items[k].type == 'category') {
						// var category_item = $("<div/>").attr('class', 'category_item category col-md-2 register-holder categories-holder col-sm-3 col-xs-6').css('background-color', json.categories_and_items[k].color).css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.categories_and_items[k].image_id + '?timestamp=' + json.categories_and_items[k].image_timestamp + ')').data('category_id', json.categories_and_items[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.categories_and_items[k].name + '</p>');
						if (json.categories_and_items[k].color != '') {
							category_style = "style='background-color:" + json.categories_and_items[k].color + " '";
						} else {
							category_style = "";
						}
						var category_item = '<li data-category_id="' + json.categories_and_items[k].id + '" class=" category_item category nav-item mb-3 me-3  pr-0 pl-0 register-holder" role="presentation" ' + category_style + '><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active symbol" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab">' + categ_badge + '' + item_badge + '<div class="nav-icon"><img class="rounded-3 mb-4 " alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.categories_and_items[k].image_id + '?timestamp=' + json.categories_and_items[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-8 lh-1"><p>' + json.categories_and_items[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


						$("#category_item_selection").append(category_item);
					} else if (json.categories_and_items[k].type == 'item') {
						var image_src = json.categories_and_items[k].image_src;
						var has_variations = json.categories_and_items[k].has_variations ? 1 : 0;

						var prod_image = "";
						var image_class = "no-image";
						var item_parent_class = "";
						if (image_src != '') {
							var item_parent_class = "item_parent_class";
							var prod_image = '<img class="rounded-3 mb-4 h-auto" src="' + image_src + '" alt="" />';
							var image_class = "has-image";
						} else {
							image_src = '' + SITE_URL + '/assets/css_good/media/placeholder.png';
						}

						//  var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.categories_and_items[k].id).append(prod_image + '<p>' + json.categories_and_items[k].name + '<br /> <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>');

						//var item = '<li data-has-variations="'+has_variations+'" data-id="'+json.categories_and_items[k].id+'" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories_and_items[k].name + '  <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
						//$("#category_item_selection").append(item);
						currency_ = "<?php echo get_store_currency(); ?>"
						price = (json.categories_and_items[k].price ? ' ' + decodeHtml(json.categories_and_items[k].price) + ' ' : '');
						price_val = (json.categories_and_items[k].price ? decodeHtml(json.categories_and_items[k].price) : '');
						price_val = price_val.replace(currency_, '');
						htm = '<div class="col-sm-2  mb-2 col-xxl-2 category_item item  register-holder ' + image_class + ' ' + item_parent_class + ' " data-has-variations="' + has_variations + '"  data-price="' + price_val + '" data-id="' + json.categories_and_items[k].id + '" "><div class="card card-flush bg-light h-xl-100"><!--begin::Body--><div class="card-body text-center pb-5"><!--begin::Overlay--><div class="d-block overlay" ><!--begin::Image--><div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded mb-7" style="height: 90px;background-image:url(' + image_src + ')"><span   class="position-absolute symbol-badge badge  badge-light top-75 end-0 price_of_item ">' + price + '</span></div><!--end::Image--><!--begin::Action--><div class="overlay-layer card-rounded bg-dark bg-opacity-25"><i class="bi  fs-2x text-white"></i></div><!--end::Action--></div><!--end::Overlay--><!--begin::Info--><span class="fw-bold text-left text-gray-800 cursor-pointer text-hover-primary fs-6 d-block mt-minus-10">' + json.categories_and_items[k].name + '</span><div class="d-flex align-items-end flex-stack mb-1"></div><!--end::Info--></div><!--end::Body--><span class="position-absolute symbol-badge badge   badge-circle badge-light-primary fs-2 h-30px w-30px  bottom-5 end-5 ">+</span></div><!--end::Card widget 14--></div>';
						$("#category_item_selection_wrapper_new").append(htm);

					}
				}



				$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('items').removeClass('favorite').removeClass('suppliers').removeClass("supplierItems").addClass('categoriesAndItems');
				$("#category_item_selection_wrapper .pagination").html(json.pagination);

				updateBreadcrumbs();
				$('#grid-loader').hide();

			}

			function processTagItemsResult(json) {
				$("#category_item_selection").html('');
				//var back_to_categories_button = $("<div/>").attr('id', 'back_to_tags').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back_to_tags')); ?> + '</p>');

				var back_to_categories_button = '<li id="back_to_tags" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


				$("#category_item_selection").append(back_to_categories_button);

				for (var k = 0; k < json.items.length; k++) {
					var image_src = json.items[k].image_src;
					var has_variations = json.items[k].has_variations ? 1 : 0;
					var prod_image = "";
					var image_class = "no-image";
					var item_parent_class = "";
					if (image_src != '') {
						var item_parent_class = "item_parent_class";
						var prod_image = '<img src="' + image_src + '" alt="" />';
						var image_class = "";
					}

					// var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.items[k].id).append(prod_image + '<p>' + json.items[k].name + '<br /> <span class="text-bold">' + (json.items[k].price ? '(' + json.items[k].price + ')' : '') + '</span></p>');

					var item = '<li data-has-variations="' + has_variations + '" data-id="' + json.items[k].id + '" class=" col-1 category_item item  ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> ' + prod_image + '</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.items[k].name + ' <span class="text-bold">' + (json.items[k].price ? '(' + decodeHtml(json.items[k].price) + ')' : '') + '</span></p>   </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


					$("#category_item_selection").append(item);

				}

				$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('favorite').removeClass('suppliers').removeClass("supplierItems").addClass('items');
				$("#category_item_selection_wrapper .pagination").html(json.pagination);

				$('#grid-loader').hide();
			}

			function processFavoriteItemsResult(json) {
				$("#category_item_selection").html('');
				for (var k = 0; k < json.items.length; k++) {
					var image_src = json.items[k].image_src;
					var has_variations = json.items[k].has_variations ? 1 : 0;
					var prod_image = "";
					var image_class = "no-image";
					var item_parent_class = "";
					if (image_src != '') {
						var item_parent_class = "item_parent_class";
						var prod_image = '<img src="' + image_src + '" alt="" />';
						var image_class = "";
					}

					//    var item = $("<div/>").attr('data-is_favorite','yes').attr('data-has-variations',has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  '+item_parent_class).attr('data-id', json.items[k].id).append(prod_image+'<p>'+json.items[k].name+'<br /> <span class="text-bold">'+(json.items[k].price ? '('+json.items[k].price+')' : '')+'</span></p>');

					item = '<li data-supplier_id="' + json.items[k].id + '" class=" col-2 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-125px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + image_src + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.items[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


					$("#category_item_selection").append(item);

				}

				$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('favorite');
				$("#category_item_selection_wrapper .pagination").html(json.pagination);

				$('#grid-loader').hide();
			}

			function processSupplierItemsResult(json) {
				$("#category_item_selection").html('');
				var back_to_categories_button = $("<div/>").attr('id', 'back_to_suppliers').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back_to_suppliers')); ?> + '</p>');
				$("#category_item_selection").append(back_to_categories_button);

				for (var k = 0; k < json.items.length; k++) {
					var image_src = json.items[k].image_src;
					var has_variations = json.items[k].has_variations ? 1 : 0;
					var prod_image = "";
					var image_class = "no-image";
					var item_parent_class = "";
					if (image_src != '') {
						var item_parent_class = "item_parent_class";
						var prod_image = '<img src="' + image_src + '" alt="" />';
						var image_class = "";
					}

					var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.items[k].id).append(prod_image + '<p>' + json.items[k].name + '<br /> <span class="text-bold">' + (json.items[k].price ? '(' + json.items[k].price + ')' : '') + '</span></p>');
					$("#category_item_selection").append(item);

				}

				$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('favorite').removeClass('suppliers').removeClass('items').addClass("supplierItems");
				$("#category_item_selection_wrapper .pagination").html(json.pagination);

				$('#grid-loader').hide();
			}


			<?php if ($this->config->item('default_type_for_grid') == 'tags') {  ?>
				<?php if ($this->config->item('hide_tags_sales_grid') != 1) { ?>
					loadTags();
				<?php } ?>
			<?php } else if ($this->config->item('default_type_for_grid') == 'favorites') { ?>
				<?php if ($this->config->item('hide_favorites_sales_grid') != 1) { ?>
					loadFavoriteItems(0);
				<?php } ?>
			<?php } else if ($this->config->item('default_type_for_grid') == 'suppliers') { ?>
				<?php if ($this->config->item('hide_suppliers_sales_grid') != 1) { ?>
					loadSuppliers();
				<?php } ?>
			<?php } else { ?>
				<?php if ($this->config->item('hide_categories_sales_grid') != 1) { ?>
					loadTopCategories();
				<?php } ?>
			<?php	} ?>
		});

		var last_focused_id = null;

		setTimeout(function() {
			$('#item').focus();
		}, 10);
	</script>

	<script type="text/javascript">
		//Keyboard events...only want to load once
		$(document).keyup(function(event) {
			var mycode = event.keyCode;

			//tab
			if (mycode == 9) {
				var $tabbed_to = $(event.target);

				if ($tabbed_to.hasClass('xeditable')) {
					$tabbed_to.trigger('click').editable('show');
				}
			}

		});

		$(document).keydown(function(event) {
			var mycode = event.keyCode;

			//F2
			if (mycode == 113) {
				$("#item").focus();
				return;
			}

			//F4
			if (mycode == 115) {
				event.preventDefault();
				$("#finish_sale_alternate_button").click();
				$("#finish_sale_button").click();
				return;
			}

			//F7
			if (mycode == 118) {
				event.preventDefault();
				$("#amount_tendered").focus();
				$("#amount_tendered").select();
				return;
			}

			//F8
			if (mycode == 119) {
				window.location = '<?php echo site_url('sales/suspended'); ?>';
				return;
			}

			//ESC
			if (mycode == 27) {
				event.preventDefault();
				$("#cancel_sale_button").click();
				return;
			}


		});
	</script>

	<script type="text/javascript">
		var is_full_screen = false;

		function full_screen() {
			if (is_full_screen) {
				$("#kt_app_header").show();
				$('#kt_app_sidebar').show();
				$('#kt_app_wrapper').removeAttr('style');
				is_full_screen = false;
			} else {
				$("#kt_app_header").hide();
				$('#kt_app_sidebar').hide();
				$('#kt_app_wrapper').attr('style', 'margin-left:0px');
				is_full_screen = true;
			}

		}
		<?php
		if (isset($cash_in_register) && $cash_in_register && $this->config->item('cash_alert_low') !== NULL && $this->config->item('cash_alert_low') !== '' && $cash_in_register < $this->config->item('cash_alert_low')) {
			echo "show_feedback('warning', " . json_encode(lang('sales_cash_low') . ' (' . to_currency($this->config->item('cash_alert_low')) . ')') . ", " . json_encode(lang('warning')) . ",{timeOut: 10000});";
		}

		if (isset($cash_in_register) && $cash_in_register && $this->config->item('cash_alert_high') !== NULL && $this->config->item('cash_alert_high') !== '' && $cash_in_register > $this->config->item('cash_alert_high')) {
			echo "show_feedback('warning', " . json_encode(lang('sales_cash_high') . ' (' . to_currency($this->config->item('cash_alert_high')) . ')') . ", " . json_encode(lang('warning')) . ",{timeOut: 10000});";
		}

		if ($this->session->flashdata('error_if_total_is_zero')) {
			echo "show_feedback('warning', " . json_encode($this->session->flashdata('error_if_total_is_zero')) . ", " . json_encode(lang('warning')) . ",  {timeOut: 10000}  );";
		}

		?>

		<?php
		if ($this->Location->get_info_for_key('enable_credit_card_processing') && $this->Location->get_info_for_key('blockchyp_api_key')) {
		?>

			function update_blockchyp_terminal_status() {
				var register_id = <?php echo json_encode($this->Employee->get_logged_in_employee_current_register_id()); ?>;

				$.getJSON(SITE_URL + '/sales/get_blockchyp_terminal_status?register_id=' + encodeURIComponent(register_id), function(terminal_status) {
					if (terminal_status.online) {
						$("#terminal_status_offline").hide();
					} else {
						$("#terminal_status_offline").show();
					}
				});

			}

			update_blockchyp_terminal_status();
		<?php
		}
		?>
		

	</script>



	<?php $this->load->view("partial/footer"); ?>