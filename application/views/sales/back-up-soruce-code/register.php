<style>
	#category_item_selection_wrapper_new {
		height: calc(100vh - 45vh);
		overflow-y: scroll;
	}
</style>

<script>
	<?php
	if ($this->session->flashdata('cc_process_error_message')) { ?>
		show_feedback('error', <?php echo json_encode($this->session->flashdata('cc_process_error_message')); ?>, <?php echo json_encode(lang('error')); ?>);
	<?php } ?>

	function amount_tendered_input_changed() {
		if ($("#payment_types").val() == <?php echo json_encode(lang('giftcard')); ?>) {
			$('#finish_sale_alternate_button').removeClass('hidden');
			$('#add_payment_button').addClass('hidden');
		} else if ($("#payment_types").val() == <?php echo json_encode(lang('points')); ?>) {
			$('#finish_sale_alternate_button').addClass('hidden');
			$('#add_payment_button').removeClass('hidden');
		} else {
			if ((<?php echo $amount_due; ?> >= 0 && $('#amount_tendered').val() >= <?php echo $amount_due; ?>) || (<?php echo $amount_due; ?> < 0 && $('#amount_tendered').val() <= <?php echo $amount_due; ?>)) {
				$('#finish_sale_alternate_button').removeClass('hidden');
				$('#add_payment_button').addClass('hidden');
			} else {
				$('#finish_sale_alternate_button').addClass('hidden');
				$('#add_payment_button').removeClass('hidden');
			}
		}

	}
</script>
<?php $this->load->helper('demo'); ?>

<?php
if ($this->Location->get_info_for_key('enable_credit_card_processing') && $this->Location->get_info_for_key('blockchyp_api_key')) {
?>
	<div class="alert alert-danger" id="terminal_status_offline" style="display:none;">
		<strong><?php echo lang('sales_credit_card_terminal_offline'); ?></strong>

		<?php
		$cur_location_info = $this->Location->get_info($this->Employee->get_logged_in_employee_current_location_id());

		?>
		<div class="text-center">
			<?php

			if (!$this->session->userdata('use_manual_entry')) {
			?>
				<button class="btn btn-primary use_manual_entry"><?php echo lang('sales_use_manual_entry'); ?></h3>
				<?php } ?>
		</div>
	</div>
<?php } ?>

<?php
if ($this->session->userdata('use_manual_entry')) {
?>
	<div class="text-center">
		<button class="btn btn-danger disable_manual_entry"><?php echo lang('sales_disable_manual_entry'); ?></button>
		<br />
		<br />
	</div>
<?php } ?>

<?php if (($previous_sale_id = $cart->get_previous_receipt_id()) && !$suspended) { ?>
	<div class="alert alert-danger">
		<?php echo lang('sales_editing_sale'); ?> <strong><?php echo $this->config->item('sale_prefix') . ' ' . $previous_sale_id; ?></strong>
	</div>
<?php } ?>

<?php if ($this->config->item('remind_customer_facing_display') && !$this->session->userdata('opened_customer_facing_display')) { ?>
	<div class="alert alert-warning" id="customer_facing_display_warning">
		<strong><?php echo lang('sales_remind_customer_facing_display'); ?></strong>
	</div>
<?php } ?>


<?php if (isset($orig_location) && $orig_location != $this->Employee->get_logged_in_employee_current_location_id()) { ?>
	<div class="alert alert-danger">
		<strong><?php echo lang('sales_editing_sale_not_in_wrong_location'); ?></strong>
	</div>
<?php } ?>

<?php if ($this->config->item('test_mode')) { ?>
	<div class="alert alert-danger">
		<strong><?php echo lang('in_test_mode'); ?>. <a href="sales/disable_test_mode"></strong>
		<a href="<?php echo site_url('sales/disable_test_mode'); ?>" id="disable_test_mode"><?php echo lang('disable_test_mode'); ?></a>
	</div>
<?php } ?>

<?php
if (count($this->Credit_card_charge_unconfirmed->get_all($cart)) > 0) {
?>
	<div class="alert alert-danger" style="font-size: 250%;">
		<strong><?php echo lang('there_are_unconfirmed_transactions'); ?>. <a href="sales/disable_test_mode"></strong>
		<div class="text-center">
			<strong><a href="<?php echo site_url('sales/view_unconfirmed'); ?>"><?php echo lang('view_unconfirmed_transactions'); ?></a></strong>
		</div>
	</div>
<?php
}
?>

<div class=" register d-flex" id="main-container">


	<!--begin::View component-->
	<div id="kt_drawer_example_basic" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_drawer_example_basic_button" data-kt-drawer-close="#kt_drawer_example_basic_close" data-kt-drawer-width="500px">
		<div class="card border-0 shadow-none rounded-0 w-100">
			<!--begin::Card header-->
			<div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4" id="kt_app_layout_builder_header" style="background-image:url('<?php echo base_url() ?>assets/css_good/media/misc/pattern-4.jpg')">

				<!--begin::Card title-->
				<h3 class="card-title fs-3 fw-bold text-white flex-column m-0">
					<?php echo lang("pos_builder") ?>

					<small class="text-white opacity-50 fs-7 fw-semibold pt-1">
						<?php echo lang("get_ready_to_customize_your_own_pos_interface") ?>
					</small>
				</h3>
				<!--end::Card title-->

				<!--begin::Card toolbar-->
				<div class="card-toolbar">
					<button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1" id="kt_app_layout_builder_close">
						<i class="ki-duotone ki-cross-square fs-2"><span class="path1"></span><span class="path2"></span></i> </button>
				</div>
				<!--end::Card toolbar-->
			</div>
			<!--end::Card header-->
			<!--begin::Card body-->
			<div class="card-body position-relative" id="kt_app_layout_builder_body">
				<!--begin::Content-->
				<div id="kt_app_settings_content" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_app_layout_builder_body" data-kt-scroll-dependencies="#kt_app_layout_builder_header, #kt_app_layout_builder_footer" data-kt-scroll-offset="5px" style="height: 213px;">

					<!--begin::Form-->
					<form class="form" method="POST" id="kt_app_layout_builder_form" action="#">
						<input type="hidden" id="kt_app_layout_builder_action" name="layout-builder[action]">

						<!--begin::Card body-->
						<div class="card-body p-0">


							<div class="separator separator-dashed my-5"></div>

							<!--begin::Form group-->
							<div class="form-group d-flex flex-stack">
								<!--begin::Heading-->
								<div class="d-flex flex-column">
									<h4 class="fw-bold text-gray-900"><?php echo lang('hide_categories') ?></h4>
									<div class="fs-7 fw-semibold text-muted">
										<?php echo lang('click_on_toggle_to_hide_show_the_categories') ?>


									</div>
								</div>
								<!--end::Heading-->

								<!--begin::Option-->
								<div class="d-flex justify-content-end">
									<!--begin::Check-->
									<div class="form-check form-check-custom form-check-solid form-check-success form-switch">

										<input class="form-check-input w-45px h-30px" <?= ($register_info->hide_categories) ? 'checked' : ''; ?> type="checkbox" value="true" name="hide_categories">
									</div>
									<!--end::Check-->
								</div>
								<!--end::Option-->
							</div>
							<!--end::Form group-->
							<div class="separator separator-dashed my-5"></div>



							<!--begin::Form group-->
							<div class="form-group d-flex flex-stack">
								<!--begin::Heading-->
								<div class="d-flex flex-column">
									<h4 class="fw-bold text-gray-900"><?php echo lang('hide_search_bar') ?></h4>
									<div class="fs-7 fw-semibold text-muted">
										<?php echo lang('click_on_toggle_to_hide_show_search_bar') ?>


									</div>
								</div>
								<!--end::Heading-->

								<!--begin::Option-->
								<div class="d-flex justify-content-end">
									<!--begin::Check-->
									<div class="form-check form-check-custom form-check-solid form-check-success form-switch">

										<input class="form-check-input w-45px h-30px" type="checkbox" <?= ($register_info->hide_search_bar) ? 'checked' : ''; ?> value="true" name="hide_search_bar">
									</div>
									<!--end::Check-->
								</div>
								<!--end::Option-->
							</div>
							<!--end::Form group-->
							<div class="separator separator-dashed my-5"></div>


							<!--begin::Form group-->
							<div class="form-group d-flex flex-stack">
								<!--begin::Heading-->
								<div class="d-flex flex-column">
									<h4 class="fw-bold text-gray-900"><?php echo lang('hide_top_buttons') ?></h4>
									<div class="fs-7 fw-semibold text-muted">
										<?php echo lang('click_on_toggle_to_hide_show_top_buttons') ?>


									</div>
								</div>
								<!--end::Heading-->

								<!--begin::Option-->
								<div class="d-flex justify-content-end">
									<!--begin::Check-->
									<div class="form-check form-check-custom form-check-solid form-check-success form-switch">

										<input class="form-check-input w-45px h-30px" type="checkbox" <?= ($register_info->hide_top_buttons) ? 'checked' : ''; ?> value="true" name="hide_top_buttons">
									</div>
									<!--end::Check-->
								</div>
								<!--end::Option-->
							</div>
							<!--end::Form group-->
							<div class="separator separator-dashed my-5"></div>

							<!--begin::Form group-->
							<div class="form-group d-flex flex-stack">
								<!--begin::Heading-->
								<div class="d-flex flex-column">
									<h4 class="fw-bold text-gray-900"><?php echo lang('hide_top_item_details') ?></h4>
									<div class="fs-7 fw-semibold text-muted">
										<?php echo lang('click_on_toggle_to_hide_show_item_details') ?>


									</div>
								</div>
								<!--end::Heading-->

								<!--begin::Option-->
								<div class="d-flex justify-content-end">
									<!--begin::Check-->
									<div class="form-check form-check-custom form-check-solid form-check-success form-switch">

										<input class="form-check-input w-45px h-30px" type="checkbox" <?= ($register_info->hide_top_item_details) ? 'checked' : ''; ?> value="true" name="hide_top_item_details">
									</div>
									<!--end::Check-->
								</div>
								<!--end::Option-->
							</div>
							<!--end::Form group-->
							<div class="separator separator-dashed my-5"></div>


							<div class="separator separator-dashed my-5"></div>

							<!--begin::Form group-->
							<div class="form-group d-flex flex-stack">
								<!--begin::Heading-->
								<div class="d-flex flex-column">
									<h4 class="fw-bold text-gray-900"><?php echo lang('hide_top_category_navigation') ?></h4>
									<div class="fs-7 fw-semibold text-muted">
										<?php echo lang('click_on_toggle_to_hide_show_category_navigation') ?>


									</div>
								</div>
								<!--end::Heading-->

								<!--begin::Option-->
								<div class="d-flex justify-content-end">
									<!--begin::Check-->
									<div class="form-check form-check-custom form-check-solid form-check-success form-switch">

										<input class="form-check-input w-45px h-30px" type="checkbox" <?= ($register_info->hide_top_category_navigation) ? 'checked' : ''; ?> value="true" name="hide_top_category_navigation">
									</div>
									<!--end::Check-->
								</div>
								<!--end::Option-->
							</div>
							<!--end::Form group-->
							<div class="separator separator-dashed my-5"></div>



						</div>
						<!--end::Card body-->
					</form>
					<!--end::Form-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Card body-->

			<!--begin::Card footer-->

			<!--end::Card footer-->
		</div>
	</div>
	<!--end::View component-->
	<!--begin::View component-->

	<div id="kt_drawer_example_basic" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_drawer_suspend" data-kt-drawer-close="#kt_drawer_example_basic_close" data-kt-drawer-width="500px">
		<div class="card border-0 shadow-none rounded-0 w-100">
			<!--begin::Card header-->
			<div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4" id="kt_app_layout_builder_header" style="background-image:url('<?php echo base_url() ?>assets/css_good/media/misc/pattern-4.jpg')">

				<!--begin::Card title-->
				<h3 class="card-title fs-3 fw-bold text-white flex-column m-0">
					<?php echo lang("save_as") ?>

				</h3>
				<!--end::Card title-->

				<!--begin::Card toolbar-->
				<div class="card-toolbar">
					<button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1" id="kt_app_layout_builder_close">
						<i class="ki-duotone ki-cross-square fs-2"><span class="path1"></span><span class="path2"></span></i> </button>
				</div>
				<!--end::Card toolbar-->
			</div>
			<!--end::Card header-->
			<!--begin::Card body-->
			<div class="card-body position-relative" id="kt_app_layout_builder_body">
				<!-- Check Store Config Change Work Order Status -->
				<?php if ($this->config->item('change_work_order_status_from_sales') && $cart->is_work_order == 1) { ?>
											<ul>
												<?php if ($suspended == 2) { ?>
													<?php foreach ($work_order_statuses as $id => $status) { ?>
														<li><a href="#" class="work_order_status_button" data-suspend-index="<?php echo H($id); ?>"><i class="ion-pause"></i> <?php echo H($status['name']); ?></a></li>
													<?php } ?>
												<?php } ?>
											</ul>
										<?php } else { ?>

											<ul>
												<li><a href="#" id="layaway_sale_button" class="text-danger"><i class="ion-pause"></i> <?php echo ($this->config->item('user_configured_layaway_name') ? $this->config->item('user_configured_layaway_name') : lang('layaway')); ?></a></li>
												<li><a href="#" id="estimate_sale_button"><i class="ion-help-circled"></i> <?php echo ($this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate')); ?></a></li>

												<?php if (isset($additional_sale_types_suspended)) : foreach ($additional_sale_types_suspended as $sale_suspend_type) { ?>
														<li><a href="#" class="additional_suspend_button" data-suspend-index="<?php echo H($sale_suspend_type['id']); ?>"><i class="ion-arrow-graph-up-right"></i> <?php echo H($sale_suspend_type['name']); ?></a></li>
											<?php }
												endif;
											}  ?>

											</ul>

			</div>
		</div>
	</div>


	<div id="kt_drawer_example_basic" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_drawer_goto" data-kt-drawer-close="#kt_drawer_example_basic_close" data-kt-drawer-width="500px">
		<div class="card border-0 shadow-none rounded-0 w-100">
			<!--begin::Card header-->
			<div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4" id="kt_app_layout_builder_header" style="background-image:url('<?php echo base_url() ?>assets/css_good/media/misc/pattern-4.jpg')">

				<!--begin::Card title-->
				<h3 class="card-title fs-3 fw-bold text-white flex-column m-0">
					<?php echo lang("go_to") ?>

				</h3>
				<!--end::Card title-->

				<!--begin::Card toolbar-->
				<div class="card-toolbar">
					<button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1" id="kt_app_layout_builder_close">
						<i class="ki-duotone ki-cross-square fs-2"><span class="path1"></span><span class="path2"></span></i> </button>
				</div>
				<!--end::Card toolbar-->
			</div>
			<!--end::Card header-->
			<!--begin::Card body-->
			<div class="card-body position-relative" id="kt_app_layout_builder_body">
				<!--begin::Content-->
				<div id="kt_app_settings_content" class="position-relative gotodrawer scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_app_layout_builder_body" data-kt-scroll-dependencies="#kt_app_layout_builder_header, #kt_app_layout_builder_footer" data-kt-scroll-offset="5px">

					<!--begin::Form-->
					<form class="form" method="POST" id="kt_app_layout_builder_form" action="#">
						<input type="hidden" id="kt_app_layout_builder_action" name="layout-builder[action]">

						<!--begin::Card body-->
						<div class="card-body p-0">
							<!--begin::template-->



							<?php
							// Define the generate_action_template function if not already defined
							// Assume all necessary permissions are checked within the function calls or before calling it

							// Integrated Gift Cards - Sell and Refill
							if ($mode != 'store_account_payment' && $mode != 'purchase_points') {


								if ($this->Employee->has_module_action_permission('giftcards', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {

									if ($this->Location->get_info_for_key('integrated_gift_cards')) {

										generate_action_template(
											true, // Assuming permission is true, replace with actual check
											"ion-card",
											"bg-primary",
											"sales/new_integrated_giftcard",
											'sales_sell_integrated_gift_card',
											'',
											'_self'
										);

										generate_action_template(
											true, // Assuming permission is true, replace with actual check
											"ion-card",
											"bg-success",
											"sales/refill_integrated_giftcard",
											'sales_refill_integrated_gift_card',
											'',
											'_self'
										);
									}

									// New Gift Card
									generate_action_template(
										true, // Replace with actual permission check
										"ion-card",
										"bg-info",
										"sales/new_giftcard",
										'sales_new_giftcard',
										'',
										'_self'
									);
								}
								// Suspended Sales
								generate_action_template(
									true, // Replace with actual permission check
									"ion-ios-list-outline",
									"bg-warning",
									"sales/suspended",
									'suspended_sales',
									'',
									'_self'
								);

								// Work Orders
								generate_action_template(
									true, // Replace with actual permission check
									"ion-ios-list-outline",
									"bg-danger",
									"sales/work_orders",
									'work_orders',
									'',
									'_self'
								);

								// Deliveries Orders
								if ($this->Employee->has_module_action_permission('deliveries', 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {
									generate_action_template(
										true, // Assuming permission is true, replace with actual check
										"ion-ios-list-outline",
										"bg-dark",
										"deliveries",
										'deliveries_orders',
										'',
										'_self'
									);
								}

								// Sales Search Reports
								if ($this->Employee->has_module_action_permission('reports', 'view_sales_generator', $this->Employee->get_logged_in_employee_info()->person_id)) {
									generate_action_template(
										true, // Assuming permission is true, replace with actual check
										"ion-search",
										"bg-secondary",
										"reports/sales_generator",
										'sales_search_reports',
										'',
										'_self'
									);
								}

								// Store Account Payment - Conditional based on configuration
								if ($this->config->item('customers_store_accounts') && $this->Employee->has_module_action_permission('sales', 'receive_store_account_payment', $this->Employee->get_logged_in_employee_info()->person_id)) {
									generate_action_template(
										true, // Replace with actual permission check
										"ion-toggle-filled",
										"bg-primary",
										"sales/change_mode/store_account_payment/1",
										'store_account_payment',
										'',
										'_self'
									);
								}

								// Batch Sale
								generate_action_template(
									true, // Assuming permission is true, replace with actual check
									"ion-bag",
									"bg-info",
									"sales/batch_sale/",
									'batch_sale',
									'none suspended_sales_btn',
									'_self'
								);





								// Assuming CORECLEARBLOCKCHYPPROCESSOR related permissions
								if ($cc_processor_class_name == 'CORECLEARBLOCKCHYPPROCESSOR' && $this->Employee->has_module_action_permission('sales', 'view_edit_transaction_history', $this->Employee->get_logged_in_employee_info()->person_id)) {
									// CoreClear Portal
									generate_action_template(
										true,
										"ion-ios-world",
										"bg-primary",
										"sales/coreclear_portal",
										'sales_coreclear_portal',
										'',
										'_blank'
									);

									// View/Edit Transaction History
									generate_action_template(
										true,
										"ion-card",
										"bg-success",
										"sales/view_transaction_history",
										'sales_view_edit_transaction_history',
										'',
										'_self'
									);

									// Batches
									generate_action_template(
										true,
										"ti-receipt",
										"bg-info",
										"sales/batches",
										'sales_batches',
										'',
										'_self'
									);
								}
							}

							// Additional functionality like lookup last receipt, adding/removing cash, etc.
							if ($this->Employee->has_module_action_permission('sales', 'can_lookup_last_receipt', $this->Employee->get_logged_in_employee_info()->person_id)) {
								if ($last_sale_id = $this->Sale->get_last_sale_id()) {
									// Last Sale Receipt
									generate_action_template(
										true,
										"ion-document",
										"bg-warning",
										"sales/receipt/$last_sale_id",
										'sales_last_sale_receipt',
										'look-up-receipt',
										'_blank'
									);
								}
							}

							// Clear Register
							if ($this->Register->count_all($this->Employee->get_logged_in_employee_current_location_id()) > 1) {
								generate_action_template(
									true,
									"ion-eject",
									"bg-danger",
									"sales/clear_register",
									'sales_change_register',
									'',
									'_self'
								);
							}

							// Customer Facing Display
							generate_action_template(
								true,
								"ion-ios-monitor-outline",
								"bg-dark",
								"sales/customer_display/" . $this->Employee->get_logged_in_employee_current_register_id(),
								'sales_customer_facing_display',
								'',
								'_blank',
								false ,
								'customer_facing_display_link'
							);

							// Open Cash Drawer
							if ($this->Employee->has_module_action_permission('sales', 'add_remove_amounts_from_cash_drawer', $this->Employee->get_logged_in_employee_info()->person_id)) {
								generate_action_template(
									true,
									"ion-android-open",
									"bg-secondary",
									"sales/open_drawer",
									'pop_open_cash_drawer',
									'pop_open_cash_drawer',
									'_blank'
								);
							}

							// Register Add/Subtract
							$track_payment_types = $this->config->item('track_payment_types') ? unserialize($this->config->item('track_payment_types')) : array();
							if (!empty($track_payment_types)) {
								// Add Cash to Register
								generate_action_template(
									true,
									"ion-cash",
									"bg-primary",
									"sales/register_add_subtract/add/common_cash",
									'sales_add_cash_to_register',
									'',
									'_self'
								);

								// Subtract Cash from Register
								generate_action_template(
									true,
									"ion-log-out",
									"bg-warning",
									"sales/register_add_subtract/subtract/common_cash",
									'remove_cash_from_register',
									'',
									'_self'
								);

								// Close Register
								generate_action_template(
									true,
									"ion-close-circled",
									"bg-danger",
									"sales/closeregister?continue=closeoutreceipt",
									'sales_close_register',
									'',
									'_self'
								);
							}

							// Enable/Disable Test Mode
							if (!is_on_demo_host() && !$this->config->item('disable_test_mode')) {
								$test_mode_enabled = $this->config->item('test_mode');
								generate_action_template(
									true,
									"ion-ios-settings-strong",
									$test_mode_enabled ? "bg-success" : "bg-secondary",
									$test_mode_enabled ? "sales/disable_test_mode" : "sales/enable_test_mode",
									$test_mode_enabled ? 'disable_test_mode' : 'enable_test_mode',
									'',
									'_self'
								);
							}

							// Custom Field Configuration
							generate_action_template(
								true, // Assume permission is granted
								"ion-wrench",
								"bg-info",
								"sales/custom_fields",
								'custom_field_config',
								'',
								'_self'
							);
							// Assuming this permission check verifies if the logged-in employee can lookup receipts
							$canLookupReceipt = $this->Employee->has_module_action_permission('sales', 'can_lookup_receipt', $this->Employee->get_logged_in_employee_info()->person_id);

							// Template for "Lookup Receipt"
							generate_action_template(
								$canLookupReceipt,
								"ion-document",
								"bg-primary",
								"#look-up-receipt", // Ensure this URL is correct based on your routing and controller action for looking up receipts
								'lookup_receipt', // Assuming 'lookup_receipt' is the correct language key for "Lookup Receipt"
								'look-up-receipt', // Additional CSS class for styling if needed
								'_self', // Opening in the same window, change to '_blank' if it should open in a new tab/window
								true,
							);
							// Show All Receipts for Today
							if ($this->Employee->has_module_action_permission('sales', 'can_lookup_receipt', $this->Employee->get_logged_in_employee_info()->person_id)) {
								generate_action_template(
									true, // Assuming permission is true, replace with actual check
									"ion-document",
									"bg-info",
									"sales/receipts?date=" . date('Y-m-d') . '&location_id=' . $this->Employee->get_logged_in_employee_current_location_id(),
									'sales_show_all_receipts_for_today',
									'look-up-receipt',
									'_blank'
								);
							}

							?>





						</div>
						<!--end::Card body-->
					</form>
					<!--end::Form-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Card body-->

			<!--begin::Card footer-->

			<!--end::Card footer-->
		</div>
	</div>
	<!--end::View component-->
	<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 no-padding-right no-padding-left" id="left-section">
	<div id="drag-handle" style="cursor: ew-resize;width: 7px;position: relative;background-color: #0009;height: 100%;float: right;z-index: 99;"></div>
	
	<div class="d-flex">
			<div id="kt_app_sidebar_toggle" class="w-100px text-center pt-2  text-light cursor-pointer bg-black rotate" data-kt-rotate="true">

				<span class="svg-icon svg-icon-muted svg-icon-2x rotate-180" style="margin: 0 auto;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M14.4 11H2.99999C2.39999 11 1.99999 11.4 1.99999 12C1.99999 12.6 2.39999 13 2.99999 13H14.4V11Z" fill="currentColor" />
						<path d="M17.7762 13.2561C18.4572 12.5572 18.4572 11.4429 17.7762 10.7439L13.623 6.48107C13.1221 5.96697 12.25 6.32158 12.25 7.03934V16.9607C12.25 17.6785 13.1221 18.0331 13.623 17.519L17.7762 13.2561Z" fill="currentColor" />
						<rect opacity="0.5" width="2" height="16" rx="1" transform="matrix(-1 0 0 1 22 4)" fill="currentColor" />
					</svg>
				</span>
				<!--end::Svg Icon-->
				<!--end::Svg Icon-->
			</div>
			<?php
			$cart_count = 0;
			$check_for_buttons = true;
			if($cart->suspended){
				if(!$this->Employee->has_module_action_permission('sales', 'edit_suspended_sale_data', $this->Employee->get_logged_in_employee_info()->person_id)){
					$check_for_buttons = false;
				}
			}
			if ($check_for_buttons) {
			?>
				<div class="register-box register-items-form w-100 d-flex justify-content-space-between h-70px">
					<a tabindex="-1" href="#" class="dismissfullscreen <?php echo !$fullscreen ? 'hidden' : ''; ?>"><i class="ion-close-circled"></i></a>
					<div id="itemForm" class="item-form bg-light-100 w-60">
						<!-- Item adding form -->

						<?php echo form_open("sales/add", array('id' => 'add_item_form', 'class' => 'form-inline', 'autocomplete' => 'off')); ?>

						<div class="input-group input-group-mobile contacts">
							<span class="input-group-text">
								<?php echo anchor("items/view/-1?redirect=sales/index/1&progression=1", "<i class='icon ti-pencil-alt'></i> <span class='register-btn-text'>" . lang('new_item') . "</span>", array('class' => 'none add-new-item', 'title' => lang('new_item'), 'id' => 'new-item-mobile', 'tabindex' => '-1')); ?>
							</span>
							<div class="input-group-text register-mode <?php echo $mode; ?>-mode dropdown">
								<?php echo anchor("#", "<i class='icon ti-shopping-cart'></i> <span class='register-btn-text mode_text'>" . H($modes[$mode]) . "</span>", array('class' => 'none active', 'tabindex' => '-1', 'title' => $modes[$mode], 'id' => 'select-mode-1', 'data-target' => '#', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true', 'role' => 'button', 'aria-expanded' => 'false')); ?>
								<ul class="dropdown-menu sales-dropdown">
									<?php foreach ($modes as $key => $value) {
										if ($key != $mode) {
									?>
											<li><a tabindex="-1" href="#" data-mode="<?php echo H($key); ?>" class="change-mode"><?php echo H($value); ?></a></li>
									<?php }
									} ?>
								</ul>
							</div>

							<span class="input-group-text grid-buttons <?php echo $mode == 'store_account_payment' || $mode == 'purchase_points' ? 'hidden' : ''; ?>">
								<?php echo anchor("#", "<i class='icon ti-layout'></i> <span class='register-btn-text'>" . lang('show_grid') . "</span>", array('class' => 'none show-grid', 'tabindex' => '-1', 'title' => lang('show_grid'))); ?>
								<?php echo anchor("#", "<i class='icon ti-layout'></i> <span class='register-btn-text'>" . lang('hide_grid') . "</span>", array('class' => 'none hide-grid hidden', 'tabindex' => '-1', 'title' => lang('hide_grid'))); ?>
							</span>
						</div>

						<div class="input-group contacts register-input-group d-flex">

							<!-- Css Loader  -->
							<div class="spinner" id="ajax-loader" style="display:none">
								<div class="rect1"></div>
								<div class="rect2"></div>
								<div class="rect3"></div>
							</div>

							<div class="input-group-text register-mode <?php echo H($mode); ?>-mode dropdown">
								<?php echo anchor("#", "<i class='icon ti-shopping-cart'></i>" . $modes[$mode], array('class' => 'none active text-light  text-hover-primary mode_text', 'tabindex' => '-1', 'title' => H($modes[$mode]), 'id' => 'select-mode-2', 'data-target' => '#', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true', 'role' => 'button', 'aria-expanded' => 'false')); ?>
								<ul class="dropdown-menu sales-dropdown">
									<?php foreach ($modes as $key => $value) {
										if ($key != $mode) {
									?>
											<li><a tabindex="-1" href="#" data-mode="<?php echo H($key); ?>" class="change-mode"><?php echo H($value); ?></a></li>
									<?php }
									} ?>
								</ul>
							</div>
							<input type="text" id="item" name="item" <?php echo ($mode == "store_account_payment" || $mode == 'purchase_points') ? 'disabled="disabled"' : '' ?> class="add-item-input w-50 pull-left keyboardTop" placeholder="<?php echo lang('start_typing_item_name'); ?>" data-title="<?php echo lang('item_name'); ?>">
							<input type="hidden" name="secondary_supplier_id" id="secondary_supplier_id" />
							<input type="hidden" name="default_supplier_id" id="default_supplier_id" />
							

							<span class="input-group-text d-none grid-buttons  <?php echo $mode == 'store_account_payment' || $mode == 'purchase_points' ? 'hidden' : ''; ?>">
								<?php echo anchor("#", "<i class='icon ti-layout'></i> " . lang('show_grid'), array('class' => 'none show-grid', 'tabindex' => '-1', 'title' => lang('show_grid'))); ?>
								<?php echo anchor("#", "<i class='icon ti-layout'></i> " . lang('hide_grid'), array('class' => 'none hide-grid hidden', 'tabindex' => '-1', 'title' => lang('hide_grid'))); ?>
							</span>
							<span class="input-group-text  grid-buttons ">
								<div class="card-toolbar">
									<!--begin::Menu-->
									<button id="category_selection_btn" class="btn h-20px w-70px btn-icon btn-color-light-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
									<?php echo lang('categories') ?>
									</button>
									<div id="grid_selection" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true" style="">
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<div class="menu-content fs-6 text-dark fw-bold px-3 py-4"><?= lang('select_option') ?></div>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu separator-->
										<div class="separator mb-3 opacity-75"></div>
										<!--end::Menu separator-->
										<!--begin::Menu item-->
										<?php if ($this->config->item('hide_categories_sales_grid') != 1) { ?>
											<div class="menu-item px-3">
												<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'categories' || !$this->config->item('default_type_for_grid') ? 'btn active' : ''; ?> menu-link px-3" id="by_category"><?php echo lang('categories') ?></a>
											</div>
										<?php }
										if ($this->config->item('hide_tags_sales_grid') != 1) { ?>
											<div class="menu-item px-3">
												<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'tags' ? 'btn active' : ''; ?> menu-link px-3" id="by_tag"><?php echo lang('tags') ?></a>
											</div>
										<?php }
										if ($this->config->item('hide_suppliers_sales_grid') != 1) { ?>
											<div class="menu-item px-3">
												<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'suppliers' ? 'btn active' : ''; ?> menu-link px-3" id="by_supplier"><?php echo lang('suppliers') ?></a>
											</div>
										<?php }
										if ($this->config->item('hide_favorites_sales_grid') != 1) { ?>
											<div class="menu-item px-3">
												<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'favorites' ? 'btn active' : ''; ?> menu-link px-3" id="by_favorite"><?php echo lang('favorite') ?></a>
											</div>
										<?php } ?>
										<!--end::Menu item-->

									</div>
									<!--begin::Menu 2-->

									<!--end::Menu 2-->
									<!--end::Menu-->
								</div>
							</span>


						</div>

						</form>
					</div>

					<div class="d-flex justify-content-end w-40">
					

						<?php echo form_open("sales/cancel_sale", array('id' => 'cancel_sale_form', 'autocomplete' => 'off', 'class' => 'd-flex    h-75px')); ?>
						
							<?php if ($mode != 'store_account_payment' && $mode != 'purchase_points') { ?>

								<?php if ($this->Employee->has_module_action_permission('sales', 'suspend_sale', $this->Employee->get_logged_in_employee_info()->person_id) && $customer_required_check && $suspended_sale_customer_required_check && !$this->config->item('test_mode')) { ?>
									<div class="d-flex flex-column bg-primary p-3 flex-center w-75px h-50px me-1 " id="kt_drawer_suspend" class="menu-icon w-100 " data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover" data-bs-original-title="Metronic Builder" data-kt-initialized="1">
										<!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
										<span class="svg-icon  svg-icon-3x mt-3"><!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/general/gen056.svg-->
											<svg class="pos-top-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M16.0077 19.2901L12.9293 17.5311C12.3487 17.1993 11.6407 17.1796 11.0426 17.4787L6.89443 19.5528C5.56462 20.2177 4 19.2507 4 17.7639V5C4 3.89543 4.89543 3 6 3H17C18.1046 3 19 3.89543 19 5V17.5536C19 19.0893 17.341 20.052 16.0077 19.2901Z" fill="currentColor" />
											</svg>
											<!--end::Svg Icon-->
										</span>
										<!--end::Svg Icon-->
										<div class=" py-2">
											<?= lang('save_as') ?> </div>
									</div>
									<div class="d-flex flex-column bg-primary  p-3 flex-center w-75px h-50px me-1 " id="cancel_sale_button">
										<!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
										<span class="svg-icon svg-icon-3x mt-3">
										<svg class="pos-top-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect opacity="0.3" x="4" y="11" width="12" height="2" rx="1" fill="currentColor"/>
										<path d="M5.86875 11.6927L7.62435 10.2297C8.09457 9.83785 8.12683 9.12683 7.69401 8.69401C7.3043 8.3043 6.67836 8.28591 6.26643 8.65206L3.34084 11.2526C2.89332 11.6504 2.89332 12.3496 3.34084 12.7474L6.26643 15.3479C6.67836 15.7141 7.3043 15.6957 7.69401 15.306C8.12683 14.8732 8.09458 14.1621 7.62435 13.7703L5.86875 12.3073C5.67684 12.1474 5.67684 11.8526 5.86875 11.6927Z" fill="currentColor"/>
										<path d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z" fill="currentColor"/>
										</svg>
											<!--end::Svg Icon-->


										</span>
										<!--end::Svg Icon-->
										<div class=" py-2"><?php echo $this->cart->get_previous_receipt_id() ||  $this->cart->suspended ? lang('back') : lang('clear'); ?></div>
									</div>

								<?php } ?>
							<?php } ?>


							<?php
							if (($this->cart->get_previous_receipt_id() || $this->cart->suspended) && $this->Employee->has_module_action_permission('sales', 'delete_sale', $this->Employee->get_logged_in_employee_info()->person_id)) {
							?>

								<div class="d-flex flex-column bg-primary  p-3 flex-center w-75px h-50px me-1 " id="delete_sale_button">
										<!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
										<span class="svg-icon svg-icon-3x text-danger svg-icon-light mt-3">

											<svg class="pos-top-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"/>
											<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"/>
											<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"/>
											</svg>
											<!--end::Svg Icon-->


										</span>
										<!--end::Svg Icon-->

										<div class=" py-2"><?php echo lang('void'); ?></div>
									</div>


							<?php
							}
							?>
						<div class="d-flex flex-column bg-primary p-3 flex-center w-75px h-50px ddd " id="advance_details" >
							<!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
							<span class="svg-icon svg-icon-3x mt-3"><!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/general/gen045.svg-->
								<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg class="pos-top-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
										<rect x="11" y="17" width="7" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
										<rect x="11" y="9" width="2" height="2" rx="1" transform="rotate(-90 11 9)" fill="currentColor" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</span>
							<!--end::Svg Icon-->
							<div class=" py-2">
								<?= lang('add_info') ?> </div>
						</div>
						
						</form>


						

					</div>

				</div>
			<?php } ?>
		</div>
		<?php
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;


		?>
		<div class="d-flex">
			<div class="w-100px bg-black pos-sidebar">
				<!--begin::Sidebar menu-->
				<div class="app-sidebar-menu app-sidebar-menu-arrow hover-scroll-overlay-y my-5 my-lg-5 px-3 pos-menu" id="kt_app_sidebar_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_toolbar, #kt_app_sidebar_footer" data-kt-scroll-offset="0" style="height: 490px;">
					<!--begin::Menu-->
					<div class="menu menu-column menu-sub-indention menu-active-bg fw-semibold     " id="#kt_sidebar_menu" data-kt-menu="true">
						<!--begin:Menu item-->



						<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" class="menu-item <?php echo $this->uri->segment(1) == 'home' && $this->uri->segment(2) != 'payvantage'  ? 'here show' : ''; ?>  ">




							<span class=" menu-link ">
								<span id="kt_drawer_goto" class="menu-icon w-100 " data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover" data-bs-original-title="Metronic Builder" data-kt-initialized="1">
									<span class="svg-icon svg-icon-muted svg-icon-2x  w-100"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path opacity="0.3" d="M17 6H3C2.4 6 2 6.4 2 7V21C2 21.6 2.4 22 3 22H17C17.6 22 18 21.6 18 21V7C18 6.4 17.6 6 17 6Z" fill="currentColor" />
											<path d="M17.8 4.79999L9.3 13.3C8.9 13.7 8.9 14.3 9.3 14.7C9.5 14.9 9.80001 15 10 15C10.2 15 10.5 14.9 10.7 14.7L19.2 6.20001L17.8 4.79999Z" fill="currentColor" />
											<path opacity="0.3" d="M22 9.09998V3C22 2.4 21.6 2 21 2H14.9L22 9.09998Z" fill="currentColor" />
										</svg>
										<span class="menu-title w-100"><?= lang('go_to'); ?></span>
									</span>
								</span>
							</span>
						

							




							<div class="menu-item">
								<a class=" menu-link " href="<?php echo site_url('sales/suspended/' . select_column_name_by_where('id', 'sale_types', ['name' => 'hold_cart']) . '');  ?>">
									<span class="menu-icon  w-100 ">
										<!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/arrows/arr043.svg-->
										<span class="svg-icon svg-icon-muted svg-icon-2x w-100 ">
											<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
												<g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
													<!-- Cart Icon -->
													<path d="M6 6h15l-1.68 9H6.75A4.75 4.75 0 0 1 2 10.25v-.5A4.75 4.75 0 0 1 6.75 5H19M6 6H4" />
													<circle cx="9" cy="19" r="1" />
													<circle cx="18" cy="19" r="1" />
													<!-- Single Slash Overlay -->
													<line x1="3" y1="3" x2="21" y2="21" />
												</g>
											</svg>

											<span class="menu-title w-100"><?= lang('hold_cart'); ?></span>
										</span>
										<!--end::Svg Icon-->
									</span>

								</a>

							</div>


							<span class=" menu-link ">
								<span id="kt_drawer_example_basic_button" class="menu-icon w-100 " data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover" data-bs-original-title="Metronic Builder" data-kt-initialized="1">
									<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/text/txt001.svg-->
									<span class="svg-icon svg-icon-muted svg-icon-2x  w-100"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="currentColor" />
											<path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="currentColor" />
										</svg>
										<span class="menu-title w-100"><?= lang('pos_builder'); ?></span>
									</span>
									<!--end::Svg Icon-->
								</span>
							</span>

						<div class="menu-item">
						<span class=" menu-link ">
								<a href="<?php echo  site_url('sales/quick_modal') ?>"  tabindex="-1" id="kt_drawer_general" class=" " data-target="#kt_drawer_general" data-target-title="<?= lang('pos_help') ?>"  data-target-width="md" data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover" data-bs-original-title="Metronic Builder" data-kt-initialized="1">
								<span class="menu-icon w-100">
									<span class="svg-icon svg-icon-muted svg-icon-2x  w-100">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
<path d="M11.276 13.654C11.276 13.2713 11.3367 12.9447 11.458 12.674C11.5887 12.394 11.738 12.1653 11.906 11.988C12.0833 11.8107 12.3167 11.61 12.606 11.386C12.942 11.1247 13.1893 10.896 13.348 10.7C13.5067 10.4947 13.586 10.2427 13.586 9.944C13.586 9.636 13.4833 9.356 13.278 9.104C13.082 8.84267 12.69 8.712 12.102 8.712C11.486 8.712 11.066 8.866 10.842 9.174C10.6273 9.482 10.52 9.82267 10.52 10.196L10.534 10.574H8.826C8.78867 10.3967 8.77 10.2333 8.77 10.084C8.77 9.552 8.90067 9.07133 9.162 8.642C9.42333 8.20333 9.81067 7.858 10.324 7.606C10.8467 7.354 11.4813 7.228 12.228 7.228C13.1987 7.228 13.9687 7.44733 14.538 7.886C15.1073 8.31533 15.392 8.92667 15.392 9.72C15.392 10.168 15.322 10.5507 15.182 10.868C15.042 11.1853 14.874 11.442 14.678 11.638C14.482 11.834 14.2253 12.0533 13.908 12.296C13.544 12.576 13.2733 12.8233 13.096 13.038C12.928 13.2527 12.844 13.528 12.844 13.864V14.326H11.276V13.654ZM11.192 15.222H12.928V17H11.192V15.222Z" fill="currentColor"/>
</svg>
										<span class="menu-title w-100"><?= lang('help'); ?></span>
									</span>
									</span>
										</a>
							</span>
						</div>

						<?php

						if (get_quick_access()) :
							$quick_access = get_quick_access();
						?>




							<?php if ($this->Employee->has_module_permission('items', $this->Employee->get_logged_in_employee_info()->person_id) && in_array('items', $quick_access)) { ?>
								<div class="menu-item">
									<a class="menu-link  <?= ($this->uri->segment(1) == 'items') ?  'active' : '' ?>" href="<?php echo site_url('items'); ?>">
										<span class="menu-icon  w-100">
											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/general/gen002.svg-->
											<span class="svg-icon svg-icon-muted svg-icon-2x w-100"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M4.05424 15.1982C8.34524 7.76818 13.5782 3.26318 20.9282 2.01418C21.0729 1.98837 21.2216 1.99789 21.3618 2.04193C21.502 2.08597 21.6294 2.16323 21.7333 2.26712C21.8372 2.37101 21.9144 2.49846 21.9585 2.63863C22.0025 2.7788 22.012 2.92754 21.9862 3.07218C20.7372 10.4222 16.2322 15.6552 8.80224 19.9462L4.05424 15.1982ZM3.81924 17.3372L2.63324 20.4482C2.58427 20.5765 2.5735 20.7163 2.6022 20.8507C2.63091 20.9851 2.69788 21.1082 2.79503 21.2054C2.89218 21.3025 3.01536 21.3695 3.14972 21.3982C3.28408 21.4269 3.42387 21.4161 3.55224 21.3672L6.66524 20.1802L3.81924 17.3372ZM16.5002 5.99818C16.2036 5.99818 15.9136 6.08615 15.6669 6.25097C15.4202 6.41579 15.228 6.65006 15.1144 6.92415C15.0009 7.19824 14.9712 7.49984 15.0291 7.79081C15.0869 8.08178 15.2298 8.34906 15.4396 8.55884C15.6494 8.76862 15.9166 8.91148 16.2076 8.96935C16.4986 9.02723 16.8002 8.99753 17.0743 8.884C17.3484 8.77046 17.5826 8.5782 17.7474 8.33153C17.9123 8.08486 18.0002 7.79485 18.0002 7.49818C18.0002 7.10035 17.8422 6.71882 17.5609 6.43752C17.2796 6.15621 16.8981 5.99818 16.5002 5.99818Z" fill="currentColor" />
													<path d="M4.05423 15.1982L2.24723 13.3912C2.15505 13.299 2.08547 13.1867 2.04395 13.0632C2.00243 12.9396 1.9901 12.8081 2.00793 12.679C2.02575 12.5498 2.07325 12.4266 2.14669 12.3189C2.22013 12.2112 2.31752 12.1219 2.43123 12.0582L9.15323 8.28918C7.17353 10.3717 5.4607 12.6926 4.05423 15.1982ZM8.80023 19.9442L10.6072 21.7512C10.6994 21.8434 10.8117 21.9129 10.9352 21.9545C11.0588 21.996 11.1903 22.0083 11.3195 21.9905C11.4486 21.9727 11.5718 21.9252 11.6795 21.8517C11.7872 21.7783 11.8765 21.6809 11.9402 21.5672L15.7092 14.8442C13.6269 16.8245 11.3061 18.5377 8.80023 19.9442ZM7.04023 18.1832L12.5832 12.6402C12.7381 12.4759 12.8228 12.2577 12.8195 12.032C12.8161 11.8063 12.725 11.5907 12.5653 11.4311C12.4057 11.2714 12.1901 11.1803 11.9644 11.1769C11.7387 11.1736 11.5205 11.2583 11.3562 11.4132L5.81323 16.9562L7.04023 18.1832Z" fill="currentColor" />
												</svg>
												<span class="menu-title w-100"><?= lang('module_items'); ?></span>
											</span>
											<!--end::Svg Icon-->
										</span>
									</a>
								</div>

							<?php } ?>

							<?php if ($this->Employee->has_module_permission('receivings', $employee_id) && in_array('receivings', $quick_access)) { ?>
								<div class="menu-item">
									<a class="menu-link  <?= ($this->uri->segment(1) == 'receivings' && $this->uri->segment(2) != 'transfer') ?  'active' : '' ?>" href="<?php echo site_url('receivings'); ?>">
										<span class="menu-icon  w-100">
											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/abstract/abs027.svg-->
											<span class="svg-icon svg-icon-muted svg-icon-2x w-100"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor" />
													<path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor" />
												</svg>
												<span class="menu-title w-100"><?= lang('receiving'); ?></span>
											</span>
											<!--end::Svg Icon-->
										</span>
									</a>
								</div>

							<?php } ?>

							<?php if (check_allowed_module($allowed_modules->result(), 'customers')  && in_array('customers', $quick_access)) : ?>
								<!--begin:Menu item-->
								<?php if (module_access_check_view('invoices')) { ?>
									<div class="menu-item  w-100">
										<a class="menu-link  <?= ($this->uri->segment(1) == 'customers') ?  'active' : '' ?> " href="<?php echo site_url('customers'); ?>">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/communication/com013.svg-->
												<span class="svg-icon svg-icon-muted svg-icon-2x w-100 rotate-0"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor" />
														<rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor" />
													</svg>
													<span class="menu-title w-100"><?= lang('customers'); ?></span>
												</span>
												<!--end::Svg Icon-->
											</span>
										</a>
									</div>

								<?php } ?>

							<?php endif; ?>


						<?php endif; ?>
					</div>
				</div>

				<div class="menu-item" style="bottom: 30px !important;position: absolute;">
								<a class=" menu-link " href="<?php echo site_url('sales/sales_list'); ?>">
									<span class="menu-icon  w-100 ">
										<!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/arrows/arr043.svg-->
										<span class="svg-icon svg-icon-muted svg-icon-2x w-100 "><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path opacity="0.3" d="M21 22H12C11.4 22 11 21.6 11 21V3C11 2.4 11.4 2 12 2H21C21.6 2 22 2.4 22 3V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
												<path d="M19 11H6.60001V13H19C19.6 13 20 12.6 20 12C20 11.4 19.6 11 19 11Z" fill="currentColor" />
												<path opacity="0.3" d="M6.6 17L2.3 12.7C1.9 12.3 1.9 11.7 2.3 11.3L6.6 7V17Z" fill="currentColor" />
											</svg>
											<span class="menu-title w-100"><?= lang('back_to_sale'); ?></span>
										</span>
										<!--end::Svg Icon-->
									</span>

								</a>

							</div>
						</div>
			</div>
			<div class="w-100">
				<div id="sale-grid-big-wrapper" class="clearfix register <?php echo $this->config->item('hide_images_in_grid') ? 'hide_images' : ''; ?>">
					<div class="clearfix" id="category_item_selection_wrapper">
						<div id="grid_breadcrumbs" class="py-1 pos-bg-dark h-45px p-5 rounded-1 d-flex align-items-center flex-wrap"></div>

						<div class="horizontal-scroll h-120px ">
							<div class="spinner" id="grid-loader" style="display:none">
								<div class="rect1"></div>
								<div class="rect2"></div>
								<div class="rect3"></div>
							</div>



							<ul id="category_item_selection" class=" scrollable-list register-grid nav nav-pills nav-pills-custom  p-0 mt-1 m-0"></ul>
							<div class="pagination hidden-print alternate text-center"></div>
						</div>
					</div>
				</div>


				<!-- Register Items. @contains : Items table -->

				<div class="row" id="category_item_selection_wrapper_new">

				</div>

			</div>
		</div>

		

	</div>
	<!-- /.Col-lg-8 @end of left Column -->

	<!-- col-lg-4 @start of right Column -->
	<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" id="sales_section">
	

		<div class="tab-content" id="myTabContent">

			<div class="register-box register-right">

				<!-- Sale Top Buttons  -->


				<!-- If customer is added to the sale -->
				<?php if (isset($customer)) { ?>
					<div class="d-flex flex-wrap flex-sm-nowrap mb-3 my-4">
						<!--begin: Pic-->
						<div class="me-7 mb-4 w-50px">
							<div class="symbol symbol-50px  symbol-fixed position-relative">
								<img src="<?php echo $avatar; ?>" onerror="this.onerror=null; this.src='<?php echo base_url() ?>assets/css_good/media/avatars/blank.png';" alt="image">

								<?php
								if ($this->config->item('enable_customer_quick_add')) {
								?>
									<?php echo anchor("customers/quick_modal/$customer_id/1", '<i class="ion-ios-compose-outline"></i>',  array('id' => 'edit_customer', 'data-target' => "#kt_drawer_general", 'data-target-title' =>lang('new_customer'), 'data-target-width' =>'xl', 'class' => 'position-absolute translate-middle bottom-0 start-100 mb-6 rounded-circle bg-light text-center border border-2 border-body h-25px w-25px p-1', 'title' => lang('update_customer'))) . ''; ?>

								<?php
								} else {
								?>
									<?php echo anchor("customers/view/$customer_id/1", '<i class="ion-ios-compose-outline"></i>',  array('id' => 'edit_customer', 'class' => 'position-absolute translate-middle bottom-0 start-100 mb-6 rounded-circle bg-light text-center border border-2 border-body h-25px w-25px p-1', 'title' => lang('update_customer'))) . ''; ?>
								<?php
								}
								?>
							</div>
						</div>
						<!--end::Pic-->
						<!--begin::Info-->
						<div class="flex-grow-1">
							<!--begin::Title-->
							<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
								<!--begin::User-->
								<div class="d-flex flex-column">
									<!--begin::Name-->
									<div class="d-flex align-items-center mb-2">
										<a href="#" class="text-gray-900 text-hover-primary fs-5 fw-bold me-1"><?php if (!$this->config->item('hide_customer_recent_sales') && isset($customer)) { ?>
												<a href="<?php echo site_url('sales/customer_recent_sales/' . $customer_id); ?>" data-toggle="modal" data-target="#myModal" class="name"><?php echo character_limiter(H($customer), 30); ?></a>
											<?php } else if (isset($customer)) { ?>
												<a href="<?php echo site_url('customers/view/' . $customer_id . '/1'); ?>" class="name"><?php echo character_limiter(H($customer), 30); ?></a>
											<?php } else { ?>
												<?php echo character_limiter(H($customer), 30); ?>
											<?php } ?></a>

									</div>
									<!--end::Name-->
									<!--begin::Info-->
									<div class="d-flex flex-wrap fw-semibold fs-8 mb-4 pe-2">

										<?php if (!empty($customer_email)) { ?>

											<a href="mailto:<?php echo $customer_email; ?>" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
												<!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
												<span class="svg-icon svg-icon-4 me-1">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor"></path>
														<path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor"></path>
													</svg>
												</span>
												<!--end::Svg Icon--><?php echo character_limiter(H($customer_email), 25); ?></a>
										<?php } ?>
									</div>
									<!--end::Info-->
								</div>
								<!--end::User-->
								<!--begin::Actions-->
								<div class="d-flex my-4">
									<div id="popover-content" class="d-none">
										<!--begin::ShareArea-->
										<div class="d-flex flex-wrap justify-content-around fw-semibold fs-6 mb-4 pe-2">


											<div class="symbol round w-50px h-50px text-center p-4  bg-success me-2">
												<i class="fa-solid fa-square-phone fs-2rem text-light"></i>
											</div>

											<?php if (!empty($customer_email)) { ?>

												<div class="symbol round w-50px h-50px text-center p-4  bg-danger me-2">

													<i class="fa-regular fa-envelope fs-2rem text-light <?php echo ((bool) $email_receipt || (bool) $auto_email_receipt) ? 'checked' : ''; ?> " id="toggle_email_receipt"></i>
												</div>
											<?php }  ?>

											<?php if ($this->Location->get_info_for_key('twilio_sms_from') && $this->Location->get_info_for_key('twilio_token') && $this->Location->get_info_for_key('twilio_sid')) { ?>
												<?php if (!empty($customer_phone)) { ?>

													<div class="symbol round w-50px h-50px text-center p-4  bg-warning me-2">
														<i class="fa-solid fa-comment-sms fs-2rem text-light <?php echo ((bool) $sms_receipt || (bool) $always_sms_receipt) ? 'checked' : ''; ?>" id="toggle_sms_receipt"></i>
													</div>
											<?php }
											} ?>



										</div>





										<!--End::ShareArea-->
									</div>

									<a onclick="event.preventDefault();" data-dismiss="true" data-placement="bottom" data-toggle="popover" data-html="true" title="<?= lang('send_receipt_via') ?>" href="#" class="btn btn-sm btn-light me-2 p-2" id="share-popover">

										<i class="fa-solid fa-share"></i>
										<!--end::Svg Icon-->
										<!--begin::Indicator label-->
										<span class="indicator-label"><?php echo lang('share') ?></span>
										<!--end::Indicator label-->
									</a>
									<script>
										$(function() {

											$('#share-popover').popover({
												container: 'body',
												template: '<div class="popover fade bottom in bg-dark border-dark min-w-300px " role="tooltip"><div class="arrow" style="left: 25%;"></div><h3 class="popover-header"></h3><div class="popover-body">' + $('#popover-content').html() + '</div></div>',
												content: function() {
													return $('#popover-content').html();
												}
											})


										})
									</script>
									<?php if ($mode != 'store_account_payment' && $this->Employee->has_module_action_permission('deliveries', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
										<a href="<?php echo site_url('sales/view_delivery_modal/') ?>" class="btn btn-sm btn-light me-2 p-2 <?php echo (bool) $has_delivery ? 'checked' : ''; ?>" id="open_delivery_modal" data-toggle="modal" data-target="#myModal">
											<i class="ion-android-car"></i>
											<?php echo lang('Delivery'); ?>
										</a>
									<?php } ?>
									<a href="<?php echo site_url("sales/delete_customer");  ?>" class="btn btn-sm btn-light me-2 p-2" id="delete_customer">

										<i class="ion-close-circled text-danger"></i>
										<!--end::Svg Icon-->
										<!--begin::Indicator label-->
										<span class="indicator-label"><?php echo lang('detach') ?></span>
										<!--end::Indicator label-->
									</a>


								</div>
								<!--end::Actions-->
							</div>
							<!--end::Title-->
							<!--begin::Stats-->
							<div class="d-flex flex-wrap flex-stack" style="margin-top:-20px">
								<!--begin::Wrapper-->
								<div class="d-flex flex-column flex-grow-1 ">
									<!--begin::Stats-->
									<div class="d-flex flex-wrap">

										<div class="<?php echo $is_over_credit_limit ? 'text-danger' : 'text-success'; ?> balance"></div>


										<?php if ($this->config->item('customers_store_accounts') && isset($customer_balance)) { ?>
											<!--begin::Stat-->
											<div class="border border-gray-300 border-dashed rounded w-25 py-3 px-1 me-2  mb-3">
												<!--begin::Number-->
												<div class="d-flex align-items-center">
													<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->

													<!--end::Svg Icon-->
													<div class="fs-6 fw-bold counted <?php echo $is_over_credit_limit ? 'text-danger' : 'text-success'; ?> balance" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1"><?php echo (isset($exchange_name) && $exchange_name ? (to_currency($customer_balance) . ' (' . (to_currency_as_exchange($cart, $customer_balance * $exchange_rate)) . ')') : to_currency($customer_balance)); ?></div>
												</div>
												<!--end::Number-->
												<!--begin::Label-->
												<div class="fw-semibold fs-8 text-gray-400"><?php echo lang('sales_balance') ?></div>
												<!--end::Label-->
											</div>
										<?php } ?>
										<!--end::Stat-->
										<?php if (!$disable_loyalty) { ?>
											<?php if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'simple' && isset($sales_until_discount)) { ?>
												<!--begin::Stat-->
												<div class="border border-gray-300 border-dashed rounded w-25 py-3 px-1 me-2  mb-3">
													<!--begin::Number-->
													<div class="d-flex align-items-center">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->

														<!--end::Svg Icon-->
														<div class="fs-6 fw-bold counted <?php echo $sales_until_discount > 0 ? 'text-danger' : 'text-success'; ?> sales_until_discount" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1"><?php echo   to_quantity($sales_until_discount) . ($sales_until_discount <= 0 && !$redeem ? ' ' . anchor('sales/redeem_discount', '<i class="ion-ios-compose-outline"></i>', array('id' => 'redeem_discount')) . '' : ($redeem ? ' ' . anchor('sales/unredeem_discount', '<i class="ion-ios-compose-outline"></i>', array('id' => 'unredeem_discount')) . '' : '')) ?></div>
													</div>
													<!--end::Number-->
													<!--begin::Label-->
													<div class="fw-semibold fs-8 text-gray-400"><?php echo lang('sales_until_discount') ?></div>
													<!--end::Label-->
												</div>
												<!--end::Stat-->
											<?php } ?>
											<?php if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced' && isset($points)) { ?>
												<!--begin::Stat-->
												<div class="border border-gray-300 border-dashed rounded w-25 py-3 px-1 me-2  mb-3">
													<!--begin::Number-->
													<div class="d-flex align-items-center">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->

														<!--end::Svg Icon-->
														<div class="fs-6 fw-bold counted <?php echo $points < 1 ? 'text-danger' : 'text-success'; ?> points" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1"><?php echo  to_quantity($points); ?></div>
													</div>
													<!--end::Number-->
													<!--begin::Label-->
													<div class="fw-semibold fs-8 text-gray-400"><?php echo lang('points') ?></div>
													<!--end::Label-->
												</div>
											<?php } ?>
											<!--end::Stat-->
										<?php } ?>

										<div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-2 w-45">
											<!--begin::Icon-->


											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/communication/com007.svg-->
											<span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor" />
													<path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor" />
												</svg>
											</span>
											<!--end::Svg Icon-->
											<!--end::Svg Icon-->
											<!--end::Icon-->
											<!--begin::Wrapper-->
											<div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
												<!--begin::Content-->
												<div class="mb-3 mb-md-0 fw-semibold">
													<div class="fs-6 text-gray-700 pe-7">
														<?php if ($this->config->item('capture_internal_notes_during_sale')) { ?>


															<a href="#" id="internal_notes" class="xeditable-comment edit-internal_notes" data-type="text" data-validate-number="false" data-pk="1" data-name="internal_notes" data-url="<?php echo site_url("sales/set_internal_notes"); ?>" data-title="<?php echo lang('internal_notes') ?>"><?php echo  $customer_internal_notes; ?></a>


														<?php } ?>

													</div>
												</div>
												<!--end::Content-->
											</div>
											<!--end::Wrapper-->
										</div>
									</div>
									<!--end::Stats-->



								</div>
								<!--end::Wrapper-->
							</div>
							<!--end::Stats-->
						</div>
						<!--end::Info-->
					</div>
					<!-- Customer Badge when customer is added -->

					<div class="customer-action-buttons  btn-group btn-group-justified  d-flex justify-content-center mb-2">







						<?php
						echo form_checkbox(array(
							'name' => 'email_receipt',
							'id' => 'email_receipt',
							'value' => '1',
							'class'       => 'email_receipt_checkbox hidden',
							'checked' => (bool) $email_receipt
						));

						echo form_checkbox(array(
							'name' => 'sms_receipt',
							'id' => 'sms_receipt',
							'value' => '1',
							'class'       => 'sms_receipt_checkbox hidden',
							'checked' => (bool) $sms_receipt
						));

						echo form_checkbox(array(
							'name' => 'delivery',
							'id' => 'delivery',
							'value' => '1',
							'class' => 'delivery_checkbox hidden',
							'checked' => (bool) $has_delivery
						));

						?>




					<?php $btn_w = "w-100px";
				} else {  ?>

						<div class="customer-form d-flex flex-wrap">

							<!-- if the customer is not set , show customer adding form -->
							<?php echo form_open("sales/select_customer", array('id' => 'select_customer_form', 'autocomplete' => 'off', 'class' => 'form-inline  w-100 mb-2')); ?>
							<div class="input-group contacts d-flex">
								<span class="input-group-text">
									<?php
									if ($this->config->item('enable_customer_quick_add')) {
									?>
										<?php echo anchor("customers/quick_modal/-1/1", "<i class='ion-person-add'></i>", array('class' => 'none ', 'title' => lang('new_customer'), 'id' => 'new-customer', 'data-target' => "#kt_drawer_general", 'data-target-title' =>lang('new_customer'), 'data-target-width' =>'xl', 'tabindex' => '-1')); ?>
									<?php
									} else {
									?>
										<?php echo anchor("customers/view/-1/1", "<i class='ion-person-add'></i>", array('class' => 'none', 'title' => lang('new_customer'), 'id' => 'new-customer', 'tabindex' => '-1')); ?>
									<?php
									}
									?>
								</span>
								<input type="text" id="customer" name="customer" class="add-customer-input keyboardLeft w-75" data-title="<?php echo lang('customer_name'); ?>" placeholder="<?php echo lang('sales_start_typing_customer_name') . ($this->config->item('require_customer_for_sale') ? ' (' . lang('required') . ')' : ''); ?>">
							</div>
							</form>




						<?php $btn_w = "";
					} ?>









						</div>


					</div>


					<div class="register-box register-items paper-cut itemboxnew">


						<div class="register-items-holder">
							<?php if ($mode != 'store_account_payment') { ?>


								<?php if ($pagination) { ?>
									<div class="page_pagination pagination-top hidden-print  text-center" id="pagination_top">
										<?php echo $pagination; ?>
									</div>
								<?php } ?>

								<?php if ($this->config->item('allow_drag_drop_sale') && !$this->agent->is_mobile() && !$this->agent->is_tablet()) {  ?>

									<style>
										#register tbody {
											cursor: move;
										}

										#register th.item_sort_able {
											cursor: pointer;
										}

										#grid-loader2.spinner>div {
											height: 100px;
											width: 8px;
											margin-right: 2px;
											margin-top: 30px;
											top: 50%;
										}
									</style>
								<?php } ?>
								<div class="spinner" id="grid-loader2" style="display: none;">
									<div class="rect1"></div>
									<div class="rect2"></div>
									<div class="rect3"></div>
								</div>
								<table id="register" class="table align-middle table-row-dashed fs-6 gy-3 dataTable no-footer">
									<?php

									if ($this->config->item('allow_drag_drop_sale') == 1 && !$this->agent->is_mobile() && !$this->agent->is_tablet()) {
										$cart_items = $cart->get_list_sort_by_receipt_sort_order();
									}
									$total_items = 0;
									$total_quantity = 0;
									if (count($cart_items) > 0) {
										$total_items = count($cart_items);
										foreach ($cart_items as $line => $item) {
											$total_quantity = $total_quantity + $item->quantity;
										}
									}

									?>
									<thead>
										<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 pos-bg-dark">
											<th class="py-1 min-w-50px text-center"><a href="javascript:void(0);" id="sale_details_expand_collapse" class="expand">-</a><?php if ($total_items > 0) : ?><span class=" symbol-badge badge   badge-circle badge-warning  "><?= $total_items; ?></span><?php endif; ?></th>
											<th class="py-1 item_sort_able  text-light item_name_heading <?php echo $this->cart->sort_column && $this->cart->sort_column == 'name' ? ($this->cart->sort_type == 'asc' ? "ion-arrow-down-b" : "ion-arrow-up-b") : ""; ?>"><?php echo lang('sales_item_name'); ?></th>
											<th class="py-1 item_sort_able min-w-150px text-center text-light sales_price <?php echo $this->cart->sort_column && $this->cart->sort_column == 'unit_price' ? ($this->cart->sort_type == 'asc' ? "ion-arrow-down-b" : "ion-arrow-up-b") : ""; ?>"><?php echo lang('price'); ?></th>
											<th class="py-1 item_sort_able sales_quantity  text-light<?php echo $this->cart->sort_column && $this->cart->sort_column == 'quantity' ? ($this->cart->sort_type == 'asc' ? "ion-arrow-down-b" : "ion-arrow-up-b") : ""; ?>"><?php echo lang('quantity'); ?><?php if ($total_quantity > 0) : ?><span class=" symbol-badge badge   badge-circle badge-warning  "><?= $total_quantity; ?></span><?php endif; ?></th>

											<th class="py-1 item_sort_able min-w-150px text-center sales_total text-light<?php echo $this->cart->sort_column && $this->cart->sort_column == 'total' ? ($this->cart->sort_type == 'asc' ? "ion-arrow-down-b" : "ion-arrow-up-b") : ""; ?>"><?php echo lang('total'); ?></th>
										</tr>
									</thead>

									<?php

									if (count($cart_items) == 0) { ?>
										<tbody class="fw-bold text-gray-600">
											<tr class="cart_content_area">
												<td colspan='6'>
													<div class='text-center text-warning'>
														<h3><?php echo lang('no_items_in_cart'); ?><span class="flatGreenc"> [<?php echo lang('module_sales') ?>]</span></h3>
													</div>
												</td>
											</tr>
										</tbody>
										<?php
									} else {

										$start_index = $cart->offset + 1;
										$end_index = $cart->offset + $cart->limit;

										$the_cart_row_counter = 1;
										foreach (array_reverse($cart_items, true) as $line => $item) {
											if ($this->config->item('hide_repair_items_in_sales_interface')) {
												if ($item->is_repair_item == 1) {
													continue;
												}
											}
											if ($this->config->item('allow_drag_drop_sale') == 1 && !$this->agent->is_mobile() && !$this->agent->is_tablet()) {
												$line = $item->line_index;
											}

											if ($item->quantity > 0 && $item->name != lang('store_account_payment') && $item->name != lang('discount')) {
												$cart_count = $cart_count + $item->quantity;
											}

											if (!(($start_index <= $the_cart_row_counter) && ($the_cart_row_counter <= $end_index))) {
												$the_cart_row_counter++;
												continue;
											}
											$the_cart_row_counter++;

										?>
											<tbody class="register-item-content" data-line="<?php echo $line; ?>">
												<tr class="register-item-details">


													<td class="text-center  fs-6"> <span class="toggle_rows btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" style="position:relative"><!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
															<span class="svg-icon svg-icon-3 m-0 toggle-off">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor"></rect>
																	<rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>
																</svg>
															</span>
															<!--end::Svg Icon-->
															<!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
															<span class="svg-icon svg-icon-3 m-0 toggle-on">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>
																</svg>
															</span>
															<!--end::Svg Icon--></span> &nbsp;</td>

													<td class=" fs-6">
														<?php if (property_exists($item, 'is_recurring') && $item->is_recurring) {
														?>
															<i class="icon ti-loop"></i>

														<?php
														}
														?>

														<a  tabindex="-1" href="<?php echo isset($item->item_id) ? site_url('home/view_item_modal/' . $item->item_id) . "?redirect=sales" : site_url('home/view_item_kit_modal/' . $item->item_kit_id) . "?redirect=sales"; ?>" data-target="#kt_drawer_general" data-target-title="<?= lang('view_item') ?>"  data-target-width="xl" class="register-item-name text-dark" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="<?php echo H($item->name); ?>"><?php echo character_limiter(H($item->name), 30) . (property_exists($item, 'variation_name') && $item->variation_name ? '<span class="show-collpased" style="display:none">  [' . $item->variation_name . ']</span>' : '') ?><?php echo $item->size ? ' (' . H($item->size) . ')' : ''; ?></a>
													</td>
													<td class="text-center  fs-6">
														<?php
														if (!$cart->suspended || $this->Employee->has_module_action_permission('sales', 'edit_suspended_sale_data', $this->Employee->get_logged_in_employee_info()->person_id)) {
														?>
															<?php if ($item->product_id != lang('integrated_gift_card') && ($item->allow_price_override_regardless_of_permissions || $this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id))) { ?>
																<a href="#" id="price_<?php echo $line; ?>" class="xeditable xeditable-price" data-validate-number="true" data-type="text" data-value="<?php echo H(to_currency_no_money($item->unit_price, 10)); ?>" data-pk="1" data-name="unit_price" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo H(lang('price')); ?>"><?php echo to_currency($item->unit_price, 10); ?></a>
															<?php } else {
																echo to_currency($item->unit_price, 10);
															}	?>

														<?php } else {
															echo to_currency($item->unit_price);
														}
														?>

													</td>
													<td class="text-center  fs-6">
														<?php if ($item->product_id != lang('integrated_gift_card') && (!$cart->suspended || $this->Employee->has_module_action_permission('sales', 'edit_suspended_sale_data', $this->Employee->get_logged_in_employee_info()->person_id))) { ?>
															<?php if ($this->config->item('number_of_decimals_displayed_on_sales_interface')) { ?>
																<a href="#" id="quantity_<?php echo $line; ?>" class="xeditable edit-quantity" data-type="text" data-validate-number="true" data-pk="1" data-name="quantity" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo lang('quantity') ?>"><?php echo to_currency_no_money($item->quantity, $this->config->item('number_of_decimals_displayed_on_sales_interface')); ?></a>
															<?php } else { ?>
																<a href="#" id="quantity_<?php echo $line; ?>" class="xeditable edit-quantity" data-type="text" data-validate-number="true" data-pk="1" data-name="quantity" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo lang('quantity') ?>"><?php echo to_quantity($item->quantity); ?></a>
															<?php } ?>
														<?php } else {
															if ($this->config->item('number_of_decimals_displayed_on_sales_interface')) {
																echo to_currency_no_money($item->quantity, $this->config->item('number_of_decimals_displayed_on_sales_interface'));
															} else {
																echo to_quantity($item->quantity);
															}
														}
														?>
													</td>

													<td class="text-center  fs-6" style="padding-right:10px">
														<?php
														if ($item->product_id != lang('integrated_gift_card') && (!$cart->suspended || $this->Employee->has_module_action_permission('sales', 'edit_suspended_sale_data', $this->Employee->get_logged_in_employee_info()->person_id))) {
														?>

															<?php if ($item->allow_price_override_regardless_of_permissions || $this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
																<a href="#" id="total_<?php echo $line; ?>" class="xeditable" data-type="text" data-validate-number="true" data-pk="1" data-name="total" data-value="<?php echo H(to_currency_no_money($item->unit_price * $item->quantity - $item->unit_price * $item->quantity * $item->discount / 100)); ?>" data-url="<?php echo site_url('sales/edit_line_total/' . $line); ?>" data-title="<?php echo lang('total') ?>"><?php echo to_currency($item->unit_price * $item->quantity - $item->unit_price * $item->quantity * $item->discount / 100); ?></a>
															<?php } else {
																echo to_currency($item->unit_price * $item->quantity - $item->unit_price * $item->quantity * $item->discount / 100);
															}	?>

														<?php } else {
															echo to_currency($item->unit_price * $item->quantity - $item->unit_price * $item->quantity * $item->discount / 100);
														}
														?>
														<?php
														if (!$cart->suspended || $this->Employee->has_module_action_permission('sales', 'edit_suspended_sale_data', $this->Employee->get_logged_in_employee_info()->person_id)) {
														?>
															<?php echo anchor("sales/delete_item/$line", '<i class="icon ion-android-cancel"></i>', array('class' => 'delete-item pull-right', 'tabindex' => '-1')); ?>
														<?php
														}
														?>

													</td>
												</tr>
												<tr class="register-item-bottom">
													<td>&nbsp;</td>
													<td colspan="5">
														<div class="row">
															<div class="col-md-3 mt-3">
																<div class="text-gray-800 fs-7"><?php echo lang('discount_percent'); ?></div>
																<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><?php
																																			if ($item->product_id != lang('integrated_gift_card') && (!$cart->suspended || $this->Employee->has_module_action_permission('sales', 'edit_suspended_sale', $this->Employee->get_logged_in_employee_info()->person_id)) && $this->config->item('disable_discounts_percentage_per_line_item') != 1) {
																																			?>
																		<?php if ($line !== $line_for_flat_discount_item && $this->Employee->has_module_action_permission('sales', 'give_discount', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
																			<a href="#" id="discount_<?php echo $line; ?>" class="xeditable" data-type="text" data-validate-number="true" data-pk="1" data-name="discount" data-value="<?php echo H(to_quantity($item->discount)); ?>" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo lang('discount_percent') ?>"><?php echo to_quantity($item->discount); ?>%</a>

																		<?php } else { ?>

																			<?php echo to_quantity($item->discount); ?>%

																		<?php }	?>
																	<?php } else {
																																				echo to_quantity($item->discount) . '%';
																																			}
																	?>
																</div>
															</div>
															<?php
															$mods_for_item = $this->Item_modifier->get_modifiers_for_item($item)->result_array();

															if (count($mods_for_item) > 0) {
															?>
																<div class="col-md-3 mt-3">
																	<div class="text-gray-800 fs-7"><?php echo lang('modifiers') ?></div>
																	<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
																		<a style="cursor:pointer;" onclick="enable_popup_modifier(<?php echo $line; ?>);"><?php echo lang('edit'); ?></a>
																		<?php
																		if (count($item->modifier_items)) {
																			foreach ($item->modifier_items as $modifier_item_id => $modifier_item) {

																				$modifier_item_info = $this->Item_modifier->get_modifier_item_info($modifier_item_id);
																				$edit_modifier_price = '<a href="#" id="modifier_' . $line . '" class="xeditable edit-price" data-type="text" data-validate-number="true" data-pk="1" data-name="modifier_price" data-modifier-item-id="' . $modifier_item_id . '" data-url="' . site_url('sales/edit_item/' . $line . '/' . $modifier_item_id) . '" data-title="' . lang('price') . '" data-value="' . H(to_currency_no_money($modifier_item['unit_price'])) . '">' . to_currency($modifier_item['unit_price']) . '</a>';

																				$display_name = $edit_modifier_price . ': ' . $modifier_item_info['modifier_name'] . ' > ' . $modifier_item_info['modifier_item_name'];

																				echo '<p>' . $display_name . '</p>';
																			}
																		}
																		?>
																	</div>
																</div>
															<?php
															}
															?>

															<?php if (property_exists($item, 'is_recurring') && $item->is_recurring) { ?>
																<div class="col-md-3 mt-3">
																	<div class="text-gray-800 fs-7"><?php echo lang('recurring_amount'); ?></div>
																	<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><?php echo to_currency($this->Item->get_sale_price(array('ignore_recurring_price' => TRUE, 'item_id' => $item->item_id, 'variation_id' => $item->variation_id))); ?></div>
																</div>
															<?php } ?>


															<?php if ($cart->get_previous_receipt_id()) { ?>
																<div class="col-md-3 mt-3">
																	<div class="text-gray-800 fs-7"><?php echo lang('qty_picked_up'); ?></div>
																	<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><a href="#" id="quantity_received_<?php echo $line; ?>" class="xeditable" data-type="text" data-validate-number="true" data-pk="1" data-name="quantity_received" data-value="<?php echo H(to_quantity($item->quantity_received)); ?>" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo H(lang('qty_received')); ?>"><?php echo H(to_quantity($item->quantity_received)); ?></a></div>
																</div>
															<?php } ?>

															<?php
															if (property_exists($item, 'quantity_units') && count($item->quantity_units) > 0) { ?>
																<div class="col-md-3 mt-3">
																	<div class="text-gray-800 fs-7"><?php echo lang('quantity_units'); ?> </div>
																	<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">

																		<a href="#" id="quantity_unit_<?php echo $line; ?>" data-name="quantity_unit_id" data-type="select" data-pk="1" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo H(lang('quantity_units')); ?>"><?php echo character_limiter(H($item->quantity_unit_id ? $item->quantity_units[$item->quantity_unit_id] : lang('none')), 50); ?></a>
																	</div>
																</div>
																<?php
																$source_data = array();
																$source_data[] = array('value' => 0, 'text' => lang('none'));

																foreach ($item->quantity_units as $quantity_unit_id => $quantity_unit_name) {
																	$source_data[] = array('value' => $quantity_unit_id, 'text' => $quantity_unit_name);
																}
																?>
																<script>
																	$('#quantity_unit_<?php echo $line; ?>').editable({
																		value: <?php echo (H($item->quantity_unit_id) ? H($item->quantity_unit_id) : 0); ?>,
																		source: <?php echo json_encode($source_data); ?>,
																		success: function(response, newValue) {
																			last_focused_id = $(this).attr('id');
																			$("#sales_section").html(response);
																		}
																	});
																</script>
															<?php } ?>
															<?php

															if (!$this->config->item('always_use_average_cost_method') && $item->change_cost_price && ($item->allow_price_override_regardless_of_permissions || $this->Employee->has_module_action_permission('sales', 'edit_sale_cost_price', $this->Employee->get_logged_in_employee_info()->person_id))) {
															?>
																<div class="col-md-3 mt-3">
																	<div class="text-gray-800 fs-7"><?php echo lang('cost_price'); ?></div>
																	<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
																		<a href="#" id="cost_price_<?php echo $line; ?>" class="xeditable xeditable-cost-price" data-validate-number="true" data-type="text" data-value="<?php echo H(to_currency_no_money($item->cost_price)); ?>" data-pk="1" data-name="cost_price" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo H(lang('cost_price')); ?>"><?php echo to_currency($item->cost_price); ?></a>
																	</div>
																</div>
															<?php
															}
															?>
															<?php
															$supplier_name = lang('none');
															$supplier_id = $item->cart_line_supplier_id;

															$variation_choices = isset($item->variation_choices) ? $item->variation_choices : array();
															if (!empty($variation_choices)) { ?>
																<div class="col-md-3 mt-3">
																	<div class="text-gray-800 fs-7"><?php echo lang('variation'); ?> </div>
																	<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
																		<?php if ($this->Employee->has_module_action_permission('sales', 'edit_variation', $this->Employee->get_logged_in_employee_info()->person_id)) : ?>
																			<a style="cursor:pointer;" onclick="enable_popup(<?php echo $line; ?>);"><?php echo lang('edit'); ?></a>
																		<?php endif; ?>
																		<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
																			<?php if ($this->Employee->has_module_action_permission('sales', 'edit_variation', $this->Employee->get_logged_in_employee_info()->person_id)) : ?>
																				<a href="#" id="variation_<?php echo $line; ?>" data-name="variation" data-type="select" data-pk="1" data-url="<?php echo site_url('sales/edit_item_variation/' . $line); ?>" data-title="<?php echo H(lang('variation')); ?>"><?php echo character_limiter(H($item->variation_name), 50); ?></a>
																			<?php else : ?>
																				<?php echo character_limiter(H($item->variation_name), 50); ?>
																			<?php endif; ?>
																		</div>
																	</div>
																</div>

																<?php
																$source_data = array();

																foreach ($variation_choices as $variation_id => $variation_name) {
																	$variation_info = $this->Item_variations->get_info($variation_id);

																	$temp_supplier = false;
																	if (isset($variation_info->supplier_id) && !$this->config->item('hide_supplier_on_sales_interface')) {
																		$temp_supplier = $this->Supplier->get_name($variation_info->supplier_id);
																	}

																	if ($temp_supplier) {
																		$source_data[] = array('value' => $variation_id, 'text' => $variation_name . ", " . lang("supplier") . ": " . $temp_supplier);
																	} else {
																		$source_data[] = array('value' => $variation_id, 'text' => $variation_name);
																	}
																}
																?>
																<script>
																	$('#variation_<?php echo $line; ?>').editable({
																		value: <?php echo json_encode(H($item->variation_id) ? H($item->variation_id) : ''); ?>,
																		source: <?php echo json_encode($source_data); ?>,
																		success: function(response, newValue) {
																			last_focused_id = $(this).attr('id');
																			$("#sales_section").html(response);
																		}

																	});
																</script>

															<?php } ?>

															<?php
															if ($supplier_id && !$this->config->item('hide_supplier_on_sales_interface') && !$this->config->item('disable_supplier_selection_on_sales_interface')) {
																$supplier_name =  $this->Supplier->get_name($supplier_id);
															?>

																<div class="col-md-3 mt-3">
																	<div class="text-gray-800 fs-7"><?php echo lang('supplier'); ?> </div>
																	<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><a href="#" id="supplier_<?php echo $line; ?>" data-name="supplier" data-type="select" data-pk="1" data-url="<?php echo site_url('sales/edit_item_supplier/' . $line); ?>" data-title="<?php echo H(lang('supplier')); ?>"><?php echo character_limiter(H($supplier_name), 50); ?></a></div>
																</div>

																<?php
																$source_data = array();
																//array('-1' => lang('none'));
																foreach ($this->Item->get_all_suppliers_of_an_item($item->item_id)->result_array() as $row) {
																	$source_data[] = array('value' => $row['supplier_id'], 'text' => $row['company_name'] . ' (' . $row['full_name'] . ')');
																}
																?>

																<script>
																	$('#supplier_<?php echo $line; ?>').editable({
																		value: <?php echo json_encode(H($supplier_id) ? H($supplier_id) : ''); ?>,
																		source: <?php echo json_encode($source_data); ?>,
																		success: function(response, newValue) {
																			last_focused_id = $(this).attr('id');
																			$("#sales_section").html(response);
																		}

																	});
																</script>
															<?php } ?>


															<?php
															if (count($tiers) > 1) { ?>
																<div class="col-md-3 mt-3">
																	<div class="text-gray-800 fs-7"><?php echo lang('tier'); ?> </div>
																	<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">

																		<?php if ($item->allow_price_override_regardless_of_permissions || $this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id)) {	?>
																			<a href="#" id="tier_<?php echo $line; ?>" data-name="tier_id" data-type="select" data-pk="1" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo H(lang('tier')); ?>"><?php echo character_limiter(H($item->tier_id ? $item->tier_name : $tiers[$selected_tier_id]), 50); ?></a>
																	</div>
																</div>
															<?php } else { ?>
																<?php echo character_limiter(H($item->tier_id ? $item->tier_name : $tiers[$selected_tier_id]), 50); ?>
															<?php } ?>
															<?php
																$source_data = array();

																foreach ($tiers as $tier_id => $tier_name) {
																	$source_data[] = array('value' => $tier_id, 'text' => $tier_name);
																}
															?>
															<?php if ($item->allow_price_override_regardless_of_permissions || $this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id)) {	?>
																<script>
																	$('#tier_<?php echo $line; ?>').editable({
																		value: <?php echo (H($item->tier_id) ? H($item->tier_id) : $selected_tier_id); ?>,
																		source: <?php echo json_encode($source_data); ?>,
																		success: function(response, newValue) {
																			last_focused_id = $(this).attr('id');
																			$("#sales_section").html(response);
																		}

																	});
																</script>
															<?php } ?>
														<?php } ?>

														<?php if (!$this->config->item('hide_description_on_sales_and_recv')) { ?>
															<div class="col-md-3 mt-3">
																<div class="text-gray-800 fs-7"><?php echo lang('description') ?></div>
																<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
																	<?php if (isset($item->allow_alt_description) && $item->allow_alt_description == 1) { ?>
																		<a href="#" id="description_<?php echo $line; ?>" class="xeditable" data-type="textarea" data-pk="1" data-name="description" data-value="<?php echo clean_html($item->description); ?>" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo H(lang('sales_description_abbrv')); ?>"><?php echo clean_html(character_limiter($item->description), 50); ?></a>
																<?php	} else {
																		if ($item->description != '') {
																			echo clean_html($item->description);
																		} else {
																			echo lang('none');
																		}
																	}
																}
																?>
																</div>
															</div>

															<div class="col-md-3 mt-3">
																<div class="text-gray-800 fs-7"><?php echo lang('category') ?></div>
																<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><?php echo $this->Category->get_full_path($item->category_id) ?></div>
															</div>

															<div class="col-md-3 mt-3">
																<div class="text-gray-800 fs-7">
																	<?php

																	if (isset($item->rule['name'])) {
																		echo  $item->rule['name'];
																	}
																	?>
																</div>
																<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
																	<?php

																	if (isset($item->rule['rule_discount'])) {
																		echo '-' . to_currency($item->rule['rule_discount']);
																	}
																	?>
																</div>
															</div>
															<!-- Serial Number if exists -->
															<?php if (isset($item->is_serialized) && $item->is_serialized == 1  && $item->name != lang('giftcard')) { ?>
																<div class="col-md-3 mt-3">
																	<div class="text-gray-800 fs-7"><?php echo lang('serial_number'); ?> </div>
																	<?php
																	$serial_numbers = $this->Item_serial_number->get_all($item->item_id, $this->Employee->get_logged_in_employee_current_location_id());
																	$source_data = array();
																	if (check_count($serial_numbers) > 0) {
																	?>
																		<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><a href="#" id="serialnumber_<?php echo $line; ?>" data-name="serialnumber" data-type="select" data-pk="1" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo H(lang('serial_number')); ?>"><?php echo character_limiter(H($item->serialnumber), 50); ?></a></div>
																</div>
															<?php
																	} else {
															?>

																<?php if ($this->Employee->has_module_action_permission('sales', 'edit_serail_no', $this->Employee->get_logged_in_employee_info()->person_id)) {	?>
																	<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
																		<a href="#" id="serialnumber_<?php echo $line; ?>" class="xeditable" data-type="text" data-pk="1" data-name="serialnumber" data-value="<?php echo H($item->serialnumber); ?>" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo H(lang('serial_number')); ?>"><?php echo character_limiter(H($item->serialnumber), 50); ?></a>
																	</div>
																<?php } else { ?>
																	<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
																		<span id="serialnumber_<?php echo $line; ?>" data-type="text" data-pk="1" data-name="serialnumber" data-title="<?php echo H(lang('serial_number')); ?>"><?php echo character_limiter(H($item->serialnumber), 50); ?></span>
																	</div>

																<?php } ?>
														</div>
													<?php
																	}
																	if ($item->serialnumber == '' && $this->config->item('require_to_add_serial_number_in_pos')) {


													?>
														<div class="modal fade look-up-receipt" id="add_sn_modal_<?php echo $line; ?>" role="dialog" aria-labelledby="lookUpReceipt" aria-hidden="true">
															<div class="modal-dialog customer-recent-sales">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true">&times;</span></button>
																		<h4 class="modal-title" id="lookUpReceipt"><?php echo lang('add_serial_number') ?></h4>
																	</div>
																	<div class="modal-body">
																		<label><?php echo lang('Please_select_Serial_Number') ?></label>
																		<?php
																		if (check_count($serial_numbers) > 0) {
																		?>
																			<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><a href="#" id="sserialnumber_<?php echo $line; ?>" data-name="serialnumber" data-type="select" data-pk="1" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo H(lang('serial_number')); ?>"><?php echo character_limiter(H(($item->serialnumber) ? $item->serialnumber : 'Empty'), 50); ?></a></div>
																	</div>
																<?php
																		} else {
																?>
																	<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
																		<a href="#" id="sserialnumber_<?php echo $line; ?>" class="xeditable" data-type="text" data-pk="1" data-name="serialnumber" data-value="<?php echo H(($item->serialnumber) ? $item->serialnumber : 'Empty'); ?>" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo H(lang('serial_number')); ?>"><?php echo character_limiter(H(($item->serialnumber) ? $item->serialnumber : 'Empty'), 50); ?></a>
																	</div>
																</div>
															<?php
																		} ?>
															</div>
														</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

					<script>
						$(document).ready(function() {
							$('#add_sn_modal_<?php echo $line; ?>').show();
						});
					</script>

				<?php
																	}
																	if (check_count($serial_numbers) > 0) {
																		$source_data[] = array('value' => '-1', 'text' => lang('sales_new_serial_number'));

																		foreach ($serial_numbers as $serial_number) {
																			$source_data[] = array('value' => $serial_number['serial_number'], 'text' => $serial_number['serial_number']);
																		}

				?>
					<script>
						$('#serialnumber_<?php echo $line; ?>').editable({
							value: <?php echo json_encode(H($item->serialnumber) ? H($item->serialnumber) : ''); ?>,
							source: <?php echo json_encode($source_data); ?>,
							success: function(response, newValue) {
								if (newValue == -1) {

									bootbox.prompt({
										title: <?php echo json_encode(lang('sales_enter_serial_number')); ?>,
										inputType: 'text',
										value: '',
										callback: function(serial_number) {
											if (serial_number) {
												$.post(<?php echo json_encode(site_url('sales/edit_item/' . $line)); ?>, {
													name: 'serialnumber',
													value: serial_number
												}, function(response) {
													$("#sales_section").html(response);
												});
											}
										}
									})

								} else {
									last_focused_id = $(this).attr('id');
									$("#sales_section").html(response);
								}
							}

						});
						$('#sserialnumber_<?php echo $line; ?>').editable({
							value: <?php echo json_encode(H($item->serialnumber) ? H($item->serialnumber) : ''); ?>,
							source: <?php echo json_encode($source_data); ?>,
							success: function(response, newValue) {
								if (newValue == -1) {

									bootbox.prompt({
										title: <?php echo json_encode(lang('sales_enter_serial_number')); ?>,
										inputType: 'text',
										value: '',
										callback: function(serial_number) {
											if (serial_number) {
												$.post(<?php echo json_encode(site_url('sales/edit_item/' . $line)); ?>, {
													name: 'serialnumber',
													value: serial_number
												}, function(response) {
													$("#sales_section").html(response);
												});
											}
										}
									})

								} else {
									last_focused_id = $(this).attr('id');
									$("#sales_section").html(response);
								}
							}

						});
					</script>
				<?php

																	}
				?>
			<?php } ?>

			<div class="col-md-3 mt-3">
				<div class="text-gray-800 fs-7">
					<?php
											switch ($this->config->item('id_to_show_on_sale_interface')) {
												case 'number':
													echo lang('item_number_expanded');
													break;

												case 'product_id':
													echo lang('product_id');
													break;

												case 'id':
													echo lang('item_id');
													break;

												default:
													echo lang('item_number_expanded');
													break;
											}
					?>
				</div>
				<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
					<?php
											switch ($this->config->item('id_to_show_on_sale_interface')) {
												case 'number':

													if (property_exists($item, 'item_number') && $item->item_number) {
														echo H($item->item_number);
													} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
														echo H($item->item_kit_number);
													} else {
														echo lang('none');
													}

													break;

												case 'product_id':
													echo property_exists($item, 'product_id') ? H($item->product_id) : lang('none');
													break;

												case 'id':
													echo property_exists($item, 'item_id') ? H($item->item_id) : 'KIT ' . H($item->item_kit_id);
													break;

												default:
													if (property_exists($item, 'item_number') && $item->item_number) {
														echo H($item->item_number);
													} elseif (property_exists($item, 'item_kit_number') && $item->item_kit_number) {
														echo H($item->item_kit_number);
													} else {
														echo lang('none');
													}
													break;
											}
					?>
				</div>
			</div>
			<?php if (isset($item->item_id) && $item->item_id) {
												if ($item->variation_id) {
													$item_variation_location_info = $this->Item_variation_location->get_info($item->variation_id, false, true);

													$cur_quantity = $item_variation_location_info->quantity;
												} else {
													$item_location_info = $this->Item_location->get_info($item->item_id, false, true);

													$cur_quantity = $item_location_info->quantity;
												}
			?>
				<div class="col-md-3 mt-3">
					<div class="text-gray-800 fs-7"><?php echo lang('stock'); ?></div>
					<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><?php echo to_quantity($cur_quantity); ?></div>
				</div>

				<?php
												if ($item->quantity < 0) {
				?>

					<div class="col-md-3 mt-3">
						<div class="text-gray-800 fs-7"><?php echo lang('number_damaged_not_return_to_stock'); ?></div>
						<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><a href="#" id="damaged_qty_<?php echo $line; ?>" class="xeditable" data-type="text" data-pk="1" data-name="damaged_qty" data-value="<?php echo to_quantity($item->damaged_qty, false); ?>" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo H(lang('number_damaged_not_return_to_stock')); ?>"><?php echo to_quantity($item->damaged_qty, false); ?></a></div>
					</div>

				<?php
												}
				?>
				<?php

												if ($item->is_series_package) { ?>
					<div class="col-md-3 mt-3">
						<div class="text-gray-800 fs-7"><?php echo lang('series_quantity'); ?></div>
						<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><?php echo to_quantity($item->series_quantity); ?></div>
					</div>

					<div class="col-md-3 mt-3">
						<div class="text-gray-800 fs-7"><?php echo lang('series_days_to_use_within'); ?></div>
						<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><?php echo to_quantity($item->series_days_to_use_within); ?></div>
					</div>

				<?php } ?>
			<?php } ?>

			<?php if ($this->Employee->has_module_action_permission('sales', 'edit_taxes', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>

				<div class="col-md-3 mt-3">
					<div class="text-gray-800 fs-7"><?php echo lang('tax'); ?></div>
					<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
						<a href="<?php echo site_url("sales/edit_taxes_line/$line") ?>" class="" id="edit_taxes" data-target="#kt_drawer_general" data-target-title="<?= lang('edit_taxes') ?>"  data-target-width="lg" ><?php echo lang('edit_taxes'); ?></a>
					</div>
				</div>
			<?php } ?>

			</div>
			</td>
			</tr>
			</tbody>
	<?php }
									}  ?>
	</table>

	<?php if ($pagination) { ?>
		<div class="page_pagination pagination-top hidden-print  text-center" id="pagination_top">
			<?php echo $pagination; ?>
		</div>
	<?php } ?>


		</div>

		<!-- End of Sales or Return Mode -->
	<?php } else {  ?>

		<table id="register" class="table table-hover ">

			<thead>
				<tr class="register-items-header">
					<th><?php echo lang('sales_item_name'); ?></th>
					<th><?php echo lang('payment_amount'); ?></th>
					<?php if (!empty($unpaid_store_account_sales)) { ?>
						<th>&nbsp;</th>
					<?php
								} ?>
				</tr>
			</thead>
			<tbody id="cart_contents">
				<?php

								foreach (array_reverse($cart_items, true) as $line => $item) {
				?>

					<tr id="reg_item_top">
						<td class="text text-center text-success"><a tabindex="-1" href="<?php echo isset($item->item_id) ? site_url("home/view_item_modal/" . $item->item_id) : site_url('home/view_item_kit_modal/' . $item->item_kit_id . "?redirect=sales"); ?>" data-toggle="modal" data-target="#kt_drawer_general" data-target-title="<?= lang('view_item_kit') ?>" ><?php echo H($item->name); ?></a></td>
						<td class="text-center">
							<?php
									echo form_open("sales/edit_item/$line", array('class' => 'line_item_form', 'autocomplete' => 'off'));

							?>
							<a href="#" id="price_<?php echo $line; ?>" class="xeditable" data-validate-number="true" data-type="text" data-value="<?php echo H(to_currency_no_money($item->unit_price, 10)); ?>" data-pk="1" data-name="unit_price" data-url="<?php echo site_url('sales/edit_item/' . $line); ?>" data-title="<?php echo H(lang('price')); ?>"><?php echo to_currency_no_money($item->unit_price, 10); ?></a>
							<?php
									echo form_hidden('quantity', to_quantity($item->quantity));
									echo form_hidden('description', '');
									echo form_hidden('serialnumber', '');
							?>

							</form>
						</td>
						<?php if (!empty($unpaid_store_account_sales)) {
										$pay_all_btn_class = count($paid_store_account_ids) > 0 ? 'btn-danger' : 'btn-primary';
										$pay_all_btn_text = count($paid_store_account_ids) > 0 ? lang('unpay_all') : lang('pay_all');
						?>
							<td>
								<button id="pay_or_unpay_all" type="submit" class="btn <?php echo $pay_all_btn_class; ?> pay_store_account_sale pull-right"><?php echo $pay_all_btn_text ?></button>
							</td>
						<?php } ?>
					</tr>



				<?php } /*Foreach*/ ?>
			</tbody>
		</table>

	</div>

<?php }  ?>
<!-- End of Store Account Payment Mode -->

<div id="discountbox_modal_reload_data" style="display:none">
	
	<div class="card border-0 shadow-none rounded-0 w-100">
		<!--begin::Card header-->
		<div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4" id="kt_app_layout_builder_header" style="background-image:url('<?php echo base_url() ?>assets/css_good/media/misc/pattern-4.jpg')">

			<!--begin::Card title-->
			<h3 class="card-title fs-3 fw-bold text-white flex-column m-0" >
			<?= lang('discount_details') ?>
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
						<div class="row p-5">

								<?php if (!$this->config->item('disable_discount_by_percentage')) { ?>
								<div class="mb-10">
									<label for="exampleFormControlInput1" class=" form-label"><?php echo lang('discount') . ' %: '; ?></label>
									<input type="number" id="discount_all_percent" value="<?php echo isset($discount_all_percent) &&  $discount_all_percent > 0 ?  to_quantity($discount_all_percent) : '' ?>" class="form-control form-control-solid" />
								</div>
								<?php } ?>

								<?php if (!$this->config->item('disabled_fixed_discounts')) { ?>
								<div class="mb-10">
									<label for="exampleFormControlInput1" class=" form-label"><?php echo lang('discount_fixed') . ': '; ?> 	<?php
											$symbol = "";
											if (isset($discount_all_fixed) &&  $discount_all_fixed) {
												$symbol = ($this->config->item('currency_symbol') ? $this->config->item('currency_symbol') : '$');
											}
											?>
											<span id="TEST"><?php echo $symbol; ?></span></label>
									<input type="number"  id="discount_all_flat" value="<?php echo isset($discount_all_fixed) &&  $discount_all_fixed ? $discount_all_fixed : ''; ?>" class="form-control form-control-solid" />
								</div>
								<?php } ?>


								<?php if ($has_discount) { ?>
								<div class="mb-10">
									<label for="exampleFormControlInput1" class=" form-label"><?php echo lang('reason'); ?></label>
									<textarea   id="discount_reason" class="form-control form-control-solid" ><?php echo  isset($discount_reason) &&  $discount_reason ? $discount_reason : ''; ?></textarea>
								</div>
								<?php } ?>

								<button type="button" class="btn btn-primary w-100px update_discount_details"  ><?= lang('update') ?></button>

						</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- /.Register Items first pan end here -->
<div class="register-box register-summary paper-cut  pos_footer d-flex flex-wrap bg-light-100">






<?php if ($this->Employee->has_module_action_permission('sales', 'give_discount', $this->Employee->get_logged_in_employee_info()->person_id) && $mode != 'store_account_payment' && $mode != 'purchase_points') { ?>



<span class="list-group-item global-discount-group border border-light border-dashed rounded min-w-125px h-80px py-3 px-4  ">
	


	
	<div class="side-heading text-center fw-semibold fs-6 text-dark-400">
			Discount (OMR) <i class="fonticon-content-marketing" id="discount_details_reload" ></i>
		</div>						

	<div class="fs-1 fw-bold counted text-center">

			<?= to_money($cart->get_total_discount()) ?>
	</div>
</span>
<span class="svg-icon   svg-icon-primary svg-icon-2x">
	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
		<rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
	</svg>
</span>


<script type="text/javascript">
	$(document).ready(function() {

			
			

$('#discount_details_reload').on('click', function() {
 $('#discountbox_modal_reload').html($('#discountbox_modal_reload_data').html()); 
	var discountbox_modal_reload = document.querySelector("#discountbox_modal_reload");
		 var drawer  = KTDrawer.getInstance(discountbox_modal_reload);
		
		drawer.show();

		$('.update_discount_details').on('click', function() {
		jQuery.ajax({
									
			type:"post",
			url: "<?php echo site_url('sales/discount_all_update'); ?>",
			data: {
				"discount_all_percent": $('#discount_all_percent').val(),
				"discount_all_flat": $('#discount_all_flat').val(),
				"discount_reason": $('#discount_reason').val(),
			},
			cache: false,
			success: function(response) {
				$('#sales_section').html(response);
			<?php 	echo "show_feedback('success', " . json_encode(lang('successfully_updated_discount')) . ", " . json_encode(lang('success')) . ");"; ?>
			}
		});
		});
	});
});


</script>

<?php } ?>


	<div class="sub-total list-group-item bg-light  border border-light border-dashed rounded min-w-125px h-80px py-3 px-4 ">
		<div class="fw-semibold fs-6 text-dark-400"><?php echo lang('sub_total'); ?>  (<?= get_store_currency(); ?>) <?php if ($this->Employee->has_module_action_permission('sales', 'edit_taxes', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
				<a href="<?php echo site_url('sales/edit_taxes/') ?>" class="" id="edit_taxes" data-target="#kt_drawer_general" data-target-title="<?= lang('edit_taxes') ?>"  data-target-width="lg"><i class='icon ti-pencil-alt'></i></a>
			<?php } ?><i class="fonticon-content-marketing" data-dismiss="true" data-placement="top" data-html="true" title="<?= lang('tax') ?>" id="tax-paid-popover"></i>
		</div>
		<div class="fs-1 fw-bold counted">


			<?php if (!(isset($exchange_name) && $exchange_name) && $this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id) && !$this->config->item('do_not_allow_edit_of_overall_subtotal')) { ?>

				<a href="#" id="subtotal" class="xeditable xeditable-price" data-validate-number="true" data-type="text" data-value="<?php echo H(to_currency_no_money($subtotal)); ?>" data-pk="1" data-name="subtotal" data-url="<?php echo site_url('sales/edit_subtotal'); ?>" data-title="<?php echo H(lang('sub_total')); ?>"><?php echo to_money($subtotal, 10); ?></a>

			<?php } else { ?>
				<?php if (isset($exchange_name) && $exchange_name) {
					echo to_currency_as_exchange($cart, $subtotal);
				?>
				<?php } else {  ?>
					<?php echo to_money($subtotal); ?>
			<?php
				}
			}
			?>


		</div>


	</div>

	<span class="svg-icon   svg-icon-primary svg-icon-2x">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
			<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
		</svg>
	</span>
	<div class="d-none" id="list_tax">
		<?php if (count($taxes) > 0) {
			foreach ($taxes as $name => $value) { ?>
				<div class="list-group-item  border border-dashed rounded min-w-125px h-80px py-3 px-4 me-3  mb-3">
					<div class="fw-semibold fs-6 text-dark-400">
						<?php if (!$is_tax_inclusive && $this->Employee->has_module_action_permission('sales', 'delete_taxes', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
							<?php echo anchor("sales/delete_tax/" . rawurlencode($name ? $name : ''), '<i class="icon ion-android-cancel"></i>', array('class' => 'delete-tax remove')); ?>

						<?php } ?>
						<?php echo $name; ?>:</td>
					</div>
					<div class="fs-1 fw-bold counted">
						<?php if (isset($exchange_name) && $exchange_name) {
							echo to_currency_as_exchange($cart, $value * $exchange_rate);
						?>
						<?php } else {  ?>
							<?php echo to_money($value * $exchange_rate); ?>
						<?php
						}
						?>
					</div>
				</div>


			<?php }  ?>

		<?php
		} ?>
	</div>
	<script>
		$(function() {

			$('#tax-paid-popover').popover({
				container: 'body',
				content: function() {
					return $('#list_tax').html();
				}
			})
		})
	</script>

<?php

if (count($taxes) > 0) { ?> 
<div class="amount-block border border-light border-dashed rounded min-w-125px h-80px py-3 px-4 ">
		<div class="tax amount">
			<div class="side-heading text-center fw-semibold fs-6 text-dark-400">
					<?= lang('tax') ?>	 (<?= get_store_currency(); ?>)		</div>
			<div class="amount total-tax fs-1 fw-bold counted" data-speed="1000" data-currency="OMR" data-decimals="0">
									<?= to_money($total - $subtotal) ?>				
			</div>
		</div>
	</div>
	<span class="svg-icon   mt-3 svg-icon-primary svg-icon-2x">
			<!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/arrows/arr080.svg-->
			<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg class="pos-top-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path opacity="0.5" d="M9.63433 11.4343L5.45001 7.25C5.0358 6.83579 5.0358 6.16421 5.45001 5.75C5.86423 5.33579 6.5358 5.33579 6.95001 5.75L12.4929 11.2929C12.8834 11.6834 12.8834 12.3166 12.4929 12.7071L6.95001 18.25C6.5358 18.6642 5.86423 18.6642 5.45001 18.25C5.0358 17.8358 5.0358 17.1642 5.45001 16.75L9.63433 12.5657C9.94675 12.2533 9.94675 11.7467 9.63433 11.4343Z" fill="currentColor"></path>
			<path d="M15.6343 11.4343L11.45 7.25C11.0358 6.83579 11.0358 6.16421 11.45 5.75C11.8642 5.33579 12.5358 5.33579 12.95 5.75L18.4929 11.2929C18.8834 11.6834 18.8834 12.3166 18.4929 12.7071L12.95 18.25C12.5358 18.6642 11.8642 18.6642 11.45 18.25C11.0358 17.8358 11.0358 17.1642 11.45 16.75L15.6343 12.5657C15.9467 12.2533 15.9467 11.7467 15.6343 11.4343Z" fill="currentColor"></path>
			</svg>
			</span>
			<!--end::Svg Icon-->
		</span> 
<?php }  ?>

			<div class="amount-block  min-w-125px h-80px py-3 px-4 bg-primary ">
		<div class="total amount">
			<div class="side-heading text-center fw-semibold fs-6 text-dark-400">
				<?php echo lang('total'); ?> (<?= get_store_currency(); ?>)
			</div> 
			<div class="amount total-amount fs-1 fw-bold counted" data-speed="1000" data-currency="<?php echo $this->config->item('currency_symbol'); ?>" data-decimals="<?php echo $this->config->item('number_of_decimals') !== NULL && $this->config->item('number_of_decimals') != '' ? (int) $this->config->item('number_of_decimals') : 2; ?>">
				<?php if (isset($exchange_name) && $exchange_name) {
					echo to_currency_as_exchange($cart, $total);
				?>
				<?php } else {  ?>
					<?php echo to_money($total); ?>
				<?php
				}
				?>

			</div>
		</div>
	</div>


	<?php

	if (count($payments) > 0) { ?>

		<ul class=" list-group payments col-6  border border-dashed rounded min-w-200px py-4 px-4 d-none " id="list_payments_done">

			<?php foreach ($payments as $payment_id => $payment) { ?>
				<li class="list-group-item ">
					<span class="key">

						<?php
						if ($payment->payment_type != lang('sales_partial_credit') && !$payment->ref_no) {
						?>
							<?php echo anchor("sales/delete_payment/$payment_id", '<i class="icon ion-android-cancel"></i>', array('class' => 'delete-payment remove', 'id' => 'delete_payment_' . $payment_id)); ?>
						<?php
						}
						?>
						<?php echo character_limiter(H($payment->payment_type), 21); ?>
						<?php if (strpos($payment->payment_type, lang('giftcard')) === 0) { ?>
							<?php $giftcard_payment_row = explode(':', H($payment->payment_type)); ?>
							<?php echo '<span class="giftcard_balance">[' . lang('balance') . ' ' . to_currency($this->Giftcard->get_giftcard_value(end($giftcard_payment_row)) - $payment->payment_amount) . ']</span>'; ?>
						<?php } ?>

					</span>
					<span class="value">

						<?php
						if (isset($exchange_name) && $exchange_name) {
							echo  to_currency_as_exchange($cart, $payment->payment_amount);
						} else {
							echo  to_currency($payment->payment_amount);
						}
						?>
					</span>
				</li>
			<?php } ?>
			<script>
				$('.delete-item, .delete-payment, #delete_customer').click(function(event) {
					event.preventDefault();

					$.get($(this).attr('href'), function(response) {
						$("#sales_section").html(response);
					});
				});
			</script>
		</ul>

	<?php }
	$paid_amount = 0;
	if (count($payments) > 0) { ?>


		<?php foreach ($payments as $payment_id => $payment) {
			$paid_amount = $paid_amount + $payment->payment_amount;
		} ?>
	<?php }

	if ($paid_amount > 0) {

	?>


		<span class="svg-icon   svg-icon-primary svg-icon-2x">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
			</svg>
		</span>
		<div class="amount-block  min-w-125px h-80px py-3 px-4 bg-paid  me-3">
			<div class="total amount-due">
				<div class="side-heading text-center fw-semibold fs-6 text-dark-400">
					<?php echo lang('amount_paid'); ?> (<?= get_store_currency(); ?>) <i class="fonticon-content-marketing" data-dismiss="true" data-placement="top" data-html="true" title="<?= lang('amount_paid') ?>" id="amount-paid-popover"></i>
				</div>
				<div class="amount fs-1 fw-bold counted">
					<?php if (isset($exchange_name) && $exchange_name) {
						echo to_currency_as_exchange($cart, $paid_amount);
					?>
					<?php } else {  ?>
						<?php echo to_money($paid_amount); ?>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	<?php } ?>
	<script>
		$(function() {

			$('#amount-paid-popover').popover({
				container: 'body',
				content: function() {
					return $('#list_payments_done').html();
				}
			})
		})
	</script>
<span class="svg-icon   mt-3 svg-icon-primary svg-icon-2x">
			<!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/arrows/arr080.svg-->
			<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg class="pos-top-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path opacity="0.5" d="M9.63433 11.4343L5.45001 7.25C5.0358 6.83579 5.0358 6.16421 5.45001 5.75C5.86423 5.33579 6.5358 5.33579 6.95001 5.75L12.4929 11.2929C12.8834 11.6834 12.8834 12.3166 12.4929 12.7071L6.95001 18.25C6.5358 18.6642 5.86423 18.6642 5.45001 18.25C5.0358 17.8358 5.0358 17.1642 5.45001 16.75L9.63433 12.5657C9.94675 12.2533 9.94675 11.7467 9.63433 11.4343Z" fill="currentColor"></path>
			<path d="M15.6343 11.4343L11.45 7.25C11.0358 6.83579 11.0358 6.16421 11.45 5.75C11.8642 5.33579 12.5358 5.33579 12.95 5.75L18.4929 11.2929C18.8834 11.6834 18.8834 12.3166 18.4929 12.7071L12.95 18.25C12.5358 18.6642 11.8642 18.6642 11.45 18.25C11.0358 17.8358 11.0358 17.1642 11.45 16.75L15.6343 12.5657C15.9467 12.2533 15.9467 11.7467 15.6343 11.4343Z" fill="currentColor"></path>
			</svg>
			</span>
			<!--end::Svg Icon-->
		</span> 
	<div class="amount-block  min-w-125px h-80px py-3 px-4 bg-due  me-3">
		<div class="total amount-due">
			<div class="side-heading text-center fw-semibold fs-6 text-dark-400">
				<?php echo lang('amount_due'); ?> (<?= get_store_currency(); ?>)
			</div>
			<div class="amount fs-1 fw-bold counted">
				<?php if (isset($exchange_name) && $exchange_name) {
					echo to_currency_as_exchange($cart, $amount_due);
				?>
				<?php } else {  ?>
					<?php echo to_money($amount_due); ?>
				<?php
				}
				?>
			</div>
		</div>
	</div>
	<!-- ./amount block -->

	<?php
	$exchange_rates = $this->Appconfig->get_exchange_rates()->result_array();
	if (count($exchange_rates)) {
		$exchange_options = array('1|' . $this->config->item('currency_code') . '|' . $this->config->item('currency_symbol') . '|' . $this->config->item('currency_symbol_location') . '|' . $this->config->item('number_of_decimals') . '|' . $this->config->item('thousands_separator') . '|' . $this->config->item('decimal_point') => $this->config->item('currency_code') ? $this->config->item('currency_code') : lang('default'));

		foreach ($exchange_rates as $exchange_row) {
			$exchange_options[$exchange_row['exchange_rate'] . '|' . $exchange_row['currency_code_to'] . '|' . $exchange_row['currency_symbol'] . '|' . $exchange_row['currency_symbol_location'] . '|' . $exchange_row['number_of_decimals'] . '|' . $exchange_row['thousands_separator'] . '|' . $exchange_row['decimal_point']] = $exchange_row['currency_code_to'];
		}
	?>
		<div class="amount-block exchange border border-dashed rounded min-w-125px h-80px py-3 px-4  mb-3">
			<div class="side-heading fw-semibold fs-6 text-dark-400">
				<?php echo lang('exchange_to'); ?>
			</div>
			<div class="amount total-amount fs-1 fw-bold counted"">
			<?php
			echo form_dropdown('exchange_to', $exchange_options, $exchange_details, 'id="exchange_to" class="form-control"');
			?>
		</div>
	</div>
<?php
	}
?>

<?php if (count($cart_items) > 0) { ?>
	<!-- Payment Applied -->
	

		<!-- Add Payment -->
		<?php if ($customer_required_check) { ?>
			<div class=" add-payment border border-light border-dashed rounded min-w-125px py-3 px-4">

				<?php /** 
			<div class="side-heading"><?php echo lang('add_payment'); ?></div>
				 */ ?>

				<?php
				if (!$selected_payment) {
					$selected_payment = $default_payment_type;
				}
				?>

				<?php

				if ($this->config->item('disable_store_account_when_over_credit_limit') && isset($customer_credit_limit) && ($is_over_credit_limit || $customer_credit_limit <= 0)) {
					unset($payment_options[lang('store_account')]);
				}

				?>



				<!-- Check Work Order Permission -->
				<?php if ($this->config->item('create_work_order_for_customer')) { ?>
					<?php if (isset($customer)) { ?>
						<div class="row">
							<div id="create_work_order_holder" class="create_work_order_holder col-md-6">
								<div class="text-left">
									<?php echo form_label(lang('sales_create_work_order'), 'create_work_order', array('class' => 'control-label wide')); ?>
									<?php echo form_checkbox(array(
										'name' => 'create_work_order',
										'id' => 'create_work_order',
										'value' => '1',
										'checked' => (bool)$cart->create_work_order,
									)); ?>
									<label for="create_work_order" style="padding-left: 10px; margin-top:0px;"><span></span></label>
								</div>
							</div>
						</div>
				<?php }
				} ?>
				<div class="row">
					<div id="create_invoice_holder" class="create_invoice_holder col-md-6 <?php echo $cart->selected_payment == lang("store_account") ? '' : 'hidden'; ?>">
						<div class="text-left">
							<?php echo form_label(lang('create_invoice'), 'create_invoice', array('class' => 'control-label wide')); ?>
							<?php echo form_checkbox(array(
								'name' => 'create_invoice',
								'id' => 'create_invoice',
								'value' => '1',
								'checked' => (bool)$cart->create_invoice,
							)); ?>
							<label for="create_invoice" style="padding-left: 10px; margin-top:0px;"><span></span></label>
						</div>
					</div>
				</div>
				<?php echo form_open("sales/add_payment", array('id' => 'add_payment_form', 'autocomplete' => 'off')); ?>

				<div class="input-group add-payment-form" >
					<?php
					if (!in_array($selected_payment, $payment_options)) {
						$selected_payment = 'Cash';
					}
					echo form_dropdown('payment_type', $payment_options, $selected_payment, 'id="payment_types" class="hidden"'); ?>
					<div class="input-group-text register-mode sale-mode dropup">


						<?php foreach ($payment_options as $key => $value) {
							if ($selected_payment == $value) {
						?>
								<a tabindex="-1" href="#" class="none active text-light  text-hover-primary" tabindex="-1" title="Sales Sale" id="select-mode-3" data-target="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false"><i class="fa fa-money-bill"></i>
									<?php echo H($value); ?>
								</a>
						<?php }
						} ?>



						<ul class="dropdown-menu sales-dropdown">


							<?php foreach ($payment_options as $key => $value) {
								$active_payment =  ($selected_payment == $value) ? "active" : "";
							?>
								<li><a tabindex="-1" href="#" class=" select-payment pt-2 text-gray-800 text-hover-primary <?php echo $active_payment; ?>" data-payment="<?php echo H($value); ?>"><i class="fa fa-money-bill"></i>
										<?php echo H($value); ?>
									</a></li>
							<?php } ?>

							<?php if (!$this->config->item('hide_available_giftcards') && isset($customer_giftcards) && count($customer_giftcards) > 0) { ?>
								<div class="available-giftcards">
									<div class="side-heading"><?php echo lang('sales_available_giftcards') ?></div>
									<div class="list-group">
										<?php foreach ($customer_giftcards as $customer_giftcard) { ?>
											<a href="#" class="list-group-item customer-giftcard-item" data-giftcard-number="<?php echo $customer_giftcard->giftcard_number ?>">#<?php echo $customer_giftcard->giftcard_number ?> - <b><?php echo to_currency($customer_giftcard->value) ?></b></a>
										<?php } ?>
									</div>
								</div>
							<?php } ?>
						</ul>
					</div>
					<?php echo form_input(array(
						'name' => 'amount_tendered',
						'type' => 'input',
						'id' => 'amount_tendered',
						'value' => to_currency_no_money($amount_due),
						'class' => 'form-control',
						'data-title' => lang('payment_amount')
					));	?>
					<span class="input-group-text">
						<a href="#" class="" id="add_payment_button"><?php echo lang('add_payment'); ?></a>
						<a href="#" class="hidden" id="finish_sale_alternate_button"><?php echo lang('complete_sale'); ?></a>
					</span>

					<!-- <div class="form-group">
					<label for="exampleInputPassword1"></label>
					<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
					</div> -->
				</div>

				</form>
			</div>

	<?php
		}
	} ?>


	<!-- End of complete sale button -->
			
		</div>



		<div id="sync_offline_sales" class="pull-right" style="display: none;">
			<br />

			<button class="btn btn-primary" id="sync_offline_sales_button">
				<?php echo lang('sales_sync_offline_sales'); ?> [<span id="number_of_offline_sales"></span>]
				<span id="offline_sync_spining" style="display: none" class="glyphicon glyphicon-refresh spinning"></span>
			</button>
			<br /><br />
			<a href="<?php echo site_url('home/offline'); ?>"><?php echo lang('sales_edit_offline_sales'); ?></a>

		</div>

</div>



</div>



<div class="modal fade look-up-receipt" id="look-up-receipt" role="dialog" aria-labelledby="lookUpReceipt" aria-hidden="true">
	<div class="modal-dialog customer-recent-sales">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="lookUpReceipt"><?php echo lang('lookup_receipt') ?></h4>
			</div>
			<div class="modal-body">
				<?php echo form_open("sales/receipt_validate", array('class' => 'look-up-receipt-form', 'autocomplete' => 'off')); ?>
				<span class="text-danger text-center has-error look-up-receipt-error"></span>
				<input type="text" class="form-control text-center" name="sale_id" id="sale_id" placeholder="<?php echo lang('sale_id') ?>">
				<?php echo form_submit('submit_look_up_receipt_form', lang("lookup_receipt"), 'class="btn btn-block btn-primary"'); ?>
				<?php echo form_close(); ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade look-up-receipt" id="choose_var" role="dialog" aria-labelledby="lookUpReceipt" aria-hidden="true">
	<div class="modal-dialog customer-recent-sales">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="lookUpReceipt"><?php echo lang('variation'); ?></h4>
			</div>
			<div class="modal-body clearfix">
				<?php
				echo "<div class='placeholder_attribute_vals pull-left'>";
				if (isset($show_model)) {
					foreach ($show_model as $key => $variation) {
						echo "<a href='javascript:fetch_attr_values(" . htmlspecialchars(json_encode(trim($key)), ENT_QUOTES) . ");' class='popup_button' style='margin:5px;' id='attri_" . htmlspecialchars(trim($key), ENT_QUOTES) . "'>" . trim($key) . "</a>";
					}
				}
				echo "</div>";

				?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade look-up-receipt" id="choose_modifiers" role="dialog" aria-labelledby="lookUpReceipt" aria-hidden="true">
	<div class="modal-dialog customer-recent-sales">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="lookUpReceipt"><?php echo lang('modifiers'); ?></h4>
			</div>
			<div class="modal-body clearfix">

			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<div class="modal fade look-up-receipt" id="choose_quick_cash" role="dialog" aria-labelledby="lookUpReceipt" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo lang('amount_tendered'); ?>&nbsp;<span id="amount_holder"></span></h4>
			</div>
			<div class="modal-body clearfix">
				<?php $currency_symbol = $this->config->item('currency_symbol'); ?>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-text"><?php echo $currency_symbol; ?></div>
								<input type="text" class="form-control" id="custom_amount" autocomplete="off">
							</div>
						</div>
					</div>
				</div>

				<div class="row" id="quick_cash_holder">

				</div>


			</div>

			<div class="modal-footer">
				<button data-dismiss="modal" type="button" class="btn btn-default"><?php echo lang('close'); ?></button>
				<button data-bb-handler="confirm" data-quick_amount="0" type="button" class="btn btn-primary quick_amount" id="collect_amount"><?php echo lang('collect'); ?></button>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<div class="modal fade" id="var_popup_ss" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span id="var-customize-ss"></span></h4>
			</div>
			<div class="modal-body clearfix">
				<div class="placeholder_supplier_vals2">
					<table style="width: 100%" class="table table-hover secondary-supplier-table">
						<thead>
							<tr>
								<th></th>
								<th><?php echo H(lang('suppliers')); ?></th>
								<?php if ($this->Employee->has_module_action_permission('items', 'see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
									<th><?php echo H(lang('cost_price')); ?></th>
									<th><?php echo H(lang('unit_price')); ?></th>
								<?php } ?>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="add_supplier" class="btn btn-primary"><?php echo lang('save'); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="var_popup_ss_1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo H(lang('suppliers')); ?> <span id="var-customize-ss"></span></h4>
			</div>

			<div class="modal-body clearfix">
				<div class="placeholder_supplier_vals2">
					<table style="width: 100%" class="table table-hover secondary-supplier-table">
						<thead>
							<tr>
								<th></th>
								<th><?php echo H(lang('suppliers')); ?></th>
								<?php if ($this->Employee->has_module_action_permission('items', 'see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
									<th><?php echo H(lang('cost_price')); ?></th>
									<th><?php echo H(lang('unit_price')); ?></th>
								<?php } ?>
							</tr>

							<?php if (isset($default_supplier)) {
								foreach ($default_supplier as $supplier) { ?>
									<tr class="default_supplier_row" style="cursor:pointer;" data-supplier_id="<?php echo $supplier->supplier_id; ?>">
										<td><input class="default_supplier" type="radio" style="display:block;" value="<?php echo $supplier->supplier_id; ?>" name="default_supplier" checked></td>
										<td><?php echo $supplier->company_name; ?>, <?php echo $supplier->full_name; ?></td>
										<?php if ($this->Employee->has_module_action_permission('items', 'see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
											<td><?php echo to_currency($supplier->cost_price); ?></td>
											<td><?php echo to_currency($supplier->unit_price); ?></td>
										<?php } ?>
									</tr>
							<?php }
							} ?>

							<?php if (isset($secondary_suppliers_cart)) {
								foreach ($secondary_suppliers_cart as $supplier) { ?>
									<tr class="secondary_supplier_row" style="cursor:pointer;" data-supplier_id="<?php echo $supplier->supplier_id; ?>">
										<td><input class="secondary_supplier" type="radio" style="display:block;" value="<?php echo $supplier->supplier_id; ?>" name="secondary_supplier"></td>
										<td><?php echo $supplier->company_name; ?>, <?php echo $supplier->full_name; ?></td>
										<?php if ($this->Employee->has_module_action_permission('items', 'see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
											<td><?php echo to_currency($supplier->cost_price); ?></td>
											<td><?php echo to_currency($supplier->unit_price); ?></td>
										<?php } ?>
									</tr>
							<?php }
							} ?>
						</thead>
					</table>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" id="add_supplier" class="btn btn-primary"><?php echo lang('save'); ?></button>
			</div>
		</div>
	</div>
</div>

<?php
if (isset($number_of_points_to_use) && $number_of_points_to_use > 0 && $this->config->item('prompt_to_use_points') && $customer_points >= $this->config->item('minimum_points_to_redeem')) {
?>
	<script>
		bootbox.confirm({
			message: <?php echo json_encode(lang("sales_use_points")); ?>,
			buttons: {
				confirm: {
					label: <?php echo json_encode(lang('yes')) ?>,
					className: 'btn-primary'
				},
				cancel: {
					label: <?php echo json_encode(lang('no')) ?>,
					className: 'btn-default'
				}
			},
			callback: function(result) {
				if (result) {
					$.post('<?php echo site_url("sales/add_payment"); ?>', {
						amount_tendered: <?php echo json_encode($number_of_points_to_use); ?>,
						payment_type: <?php echo json_encode(lang('points')); ?>
					}, function(response) {
						$("#sales_section").html(response);
					});
				}
			}
		});
	</script>

<?php
}
?>


<!-- price rules prompt-->
<?php
if (isset($number_to_add) && isset($item_to_add)) {
?>

	<script>
		var dialog = bootbox.confirm({
			message: <?php echo json_encode(lang("sales_price_rules_bogo_prompt")); ?>,
			buttons: {
				confirm: {
					label: <?php echo json_encode(lang('yes')) ?>,
					className: 'btn-primary'
				},
				cancel: {
					label: <?php echo json_encode(lang('no')) ?>,
					className: 'btn-default'
				}
			},
			callback: function(result) {
				if (result) {
					$.post('<?php echo site_url("sales/add"); ?>', {
						item: <?php echo json_encode($item_to_add); ?>,
						quantity: <?php echo json_encode($number_to_add); ?>
					}, function(response) {
						$("#sales_section").html(response);
					});
				}
			}
		});
	</script>

<?php
}
?>

<?php if (isset($info_popup_message) && $info_popup_message) { ?>
	<script type="text/javascript">
		bootbox.alert(<?php echo json_encode(nl2br($info_popup_message)); ?>, function(result) {
			setTimeout(function() {
				$('#item').focus();
			}, 50);
		});
	</script>
<?php } ?>


<?php if ($this->config->item('confirm_error_adding_item') && isset($error)) { ?>
	<script type="text/javascript">
		bootbox.alert(<?php echo json_encode($error); ?>, function(result) {
			setTimeout(function() {
				$('#item').focus();
			}, 50);
		});
	</script>
<?php } ?>

<?php if (!$this->config->item('disable_sale_notifications')) { ?>
	<script type="text/javascript">
		<?php

		if (isset($error) && isset($prompt_to_create_giftcard)) {
		?>
			bootbox.confirm(<?php echo json_encode(lang("sales_giftcard_not_exist")); ?>, function(result) {
				if (result) {
					$.post(<?php echo json_encode(site_url('sales/create_return_on_giftcard')); ?>, {
						giftcard_number: <?php echo json_encode($prompt_to_create_giftcard); ?>
					}, function() {
						$("#sales_section").load('<?php echo site_url("sales/sales_reload"); ?>');
					});
				}
			});

		<?php
		} elseif (isset($error) && !$this->config->item('confirm_error_adding_item')) {
			echo "show_feedback('error', " . json_encode($error) . ", " . json_encode(lang('error')) . ");";
		}

		if (isset($vendor_search) && count($vendor_search) > 0) {
		?>
			setTimeout(function() {
				var search_item_key = localStorage.getItem('item_search_key');
				if (search_item_key.trim() != "") {

					$("#add_item_form #item").val(search_item_key);
					bootbox.dialog({
						message: '<?php echo lang("sales_ask_search_in_other_vendors"); ?>',
						size: 'large',
						onEscape: true,
						backdrop: true,
						buttons: {
							<?php
							if (in_array("ig_api_bearer_token", $vendor_search)) {
							?>
								api_ig: {
									label: 'Injured Gadgets',
									className: 'btn-info',
									callback: function() {

										$("#item").autocomplete('option', 'source', '<?php echo site_url("home/sync_ig_item_search"); ?>');

										$("#item").autocomplete('option', 'response',
											function(event, ui) {
												$("#add_item_form .spinner").hide();
												var source_url = $("#item").autocomplete('option', 'source');

												if (ui.content.length == 0 && (source_url.indexOf('sales/item_search') > -1) && $("#add_item_form #item").val().trim() != "") {

												} else if (ui.content.length == 0 && (source_url.indexOf('home/sync_ig_item_search') > -1)) {
													var noResult = {
														value: "",
														image: "<?php echo base_url() . "assets/img/item.png"; ?>",
														label: "<?php echo lang("sales_no_result_found_ig"); ?>"
													};
													ui.content.push(noResult);
													$("#item").autocomplete('option', 'source', '<?php echo site_url("sales/item_search"); ?>');
												} else {
													$("#item").autocomplete('option', 'source', '<?php echo site_url("sales/item_search"); ?>');
												}
											}
										);

										$("#item").autocomplete('search');
										$("#add_item_form .spinner").show();

									}
								},
							<?php
							}
							?>
							<?php
							if (in_array("wgp_integration_pkey", $vendor_search)) {
							?>
								api_wgp: {
									label: 'WGP',
									className: 'btn-info',
									callback: function() {

										$("#item").autocomplete('option', 'source', '<?php echo site_url("home/sync_wgp_inventory_search"); ?>');

										$("#item").autocomplete('option', 'response',
											function(event, ui) {
												$("#add_item_form .spinner").hide();
												var source_url = $("#item").autocomplete('option', 'source');

												if (ui.content.length == 0 && (source_url.indexOf('sales/item_search') > -1) && $("#add_item_form #item").val().trim() != "") {

												} else if (ui.content.length == 0 && (source_url.indexOf('home/sync_wgp_inventory_search') > -1)) {
													var noResult = {
														value: "",
														image: "<?php echo base_url() . "assets/img/item.png"; ?>",
														label: "<?php echo lang("sales_no_result_found_wgp"); ?>"
													};
													ui.content.push(noResult);
													$("#item").autocomplete('option', 'source', '<?php echo site_url("sales/item_search"); ?>');
												} else {
													$("#item").autocomplete('option', 'source', '<?php echo site_url("sales/item_search"); ?>');
												}
											}
										);

										$("#item").autocomplete('search');
										$("#add_item_form .spinner").show();

									}
								},
							<?php
							}
							?>
							<?php
							if (in_array("p4_api_bearer_token", $vendor_search)) {
							?>
								api_p4: {
									label: 'Parts4cells',
									className: 'btn-info',
									callback: function() {

										$("#item").autocomplete('option', 'source', '<?php echo site_url("home/sync_p4_item_search"); ?>');

										$("#item").autocomplete('option', 'response',
											function(event, ui) {
												$("#add_item_form .spinner").hide();
												var source_url = $("#item").autocomplete('option', 'source');

												if (ui.content.length == 0 && (source_url.indexOf('sales/item_search') > -1) && $("#add_item_form #item").val().trim() != "") {

												} else if (ui.content.length == 0 && (source_url.indexOf('home/sync_p4_item_search') > -1)) {
													var noResult = {
														value: "",
														image: "<?php echo base_url() . "assets/img/item.png"; ?>",
														label: "<?php echo lang("sales_no_result_found_p4"); ?>"
													};
													ui.content.push(noResult);
													$("#item").autocomplete('option', 'source', '<?php echo site_url("sales/item_search"); ?>');
												} else {
													$("#item").autocomplete('option', 'source', '<?php echo site_url("sales/item_search"); ?>');
												}
											}
										);

										$("#item").autocomplete('search');
										$("#add_item_form .spinner").show();

									}
								},
							<?php
							}
							?>
							cancel: {
								label: '<?php echo lang("cancel"); ?>',
								className: 'btn-info',
								callback: function() {}
							}
						}
					})
				}
			}, 100);
			<?php
		}

		if (isset($warning)) {
			echo "show_feedback('warning', " . json_encode($warning) . ", " . json_encode(lang('warning')) . ");";
		}

		if (isset($success)) {
			if (isset($success_no_message)) {
			?>
				if (ENABLE_SOUNDS) {
					$.playSound(BASE_URL + 'assets/sounds/success');
				}
		<?php
			} else {
				echo "show_feedback('success', " . json_encode($success) . ", " . json_encode(lang('success')) . ");";
			}
		}

		if ($this->session->flashdata('cash_drawer_add_subtract_message')) {
			echo "show_feedback('success', " . json_encode($this->session->flashdata('cash_drawer_add_subtract_message')) . ", " . json_encode(lang('success')) . ");";
		}

		?>
	</script>
<?php } ?>
<!--- Variation Popup --->
<script type="text/javascript" language="javascript">
	if (has_offline_sales()) {
		$("#sync_offline_sales").show();
		$("#number_of_offline_sales").text(get_number_of_offline_sales());
	}

	$("#sync_offline_sales_button").click(sync_offline_sales);

	function sync_offline_sales() {
		$('#sync_offline_sales_button').prop('disabled', true);
		$("#offline_sync_spining").show();
		var allSales = JSON.parse(localStorage.getItem("sales")) || [];

		$.post('<?php echo site_url("sales/sync_offline_sales"); ?>', {
				offline_sales: JSON.stringify(allSales),
			},
			function(response) {
				if (response.success) {
					$('#sync_offline_sales_button').remove();
					localStorage.removeItem("sales");
					bootbox.alert(<?php echo json_encode(lang('sales_offline_synced_successfully')); ?> + " [" + response.sale_ids.length + "]");
				}
			}, 'json');
	}


	<?php
	if ($this->config->item('auto_sync_offline_sales')) {
	?>
		if (has_offline_sales()) {
			sync_offline_sales();
		}
	<?php
	}
	?>

	function has_offline_sales() {
		var allSales = JSON.parse(localStorage.getItem("sales")) || [];
		return allSales.length > 0;
	}

	function get_number_of_offline_sales() {
		var allSales = JSON.parse(localStorage.getItem("sales")) || [];
		return allSales.length
	}


	function fetch_attr_values($attr_id) {

		jQuery('#choose_var').modal('show');
		jQuery.ajax({
			url: "<?php echo site_url('sales/get_attributes_values'); ?>",
			data: {
				"attr_id": $attr_id
			},
			cache: false,
			success: function(response) {
				jQuery(".customer-recent-sales .modal-body .placeholder_attribute_vals").html(response);
				$('#choose_var').load();
			}
		});
	}

	function fetch_attr_value($attr_id) {
		jQuery.ajax({
			url: "<?php echo site_url('sales/get_attributes_values'); ?>",
			data: {
				"attr_id": $attr_id
			},
			cache: false,
			success: function(html) {
				jQuery(".customer-recent-sales .modal-body .placeholder_attribute_vals").html(html);
			}
		});
	}

	function enable_popup($attr_id, ) {
		jQuery('#choose_var').modal('show');
		jQuery.ajax({
			url: "<?php echo site_url('sales/get_attribute_values'); ?>",
			data: {
				"attr_id": $attr_id
			},
			cache: false,
			success: function(response) {
				jQuery(".customer-recent-sales .modal-body .placeholder_attribute_vals").html(response);

			}
		});
	}

	function enable_popup_modifier(line) {
		jQuery('#choose_modifiers').modal('show');
		jQuery.ajax({
			url: "<?php echo site_url('sales/get_modifiers'); ?>",
			data: {
				"line": line
			},
			cache: false,
			success: function(response) {
				jQuery("#choose_modifiers .modal-body").html(response);

			}
		});
	}
	<?php
	//EMV Usb Reset
	if (isset($reset_params)) {
	?>
		var data = {};
		<?php
		foreach ($reset_params['post_data'] as $name => $value) {
			if ($name && $value) {
		?>
				data['<?php echo $name; ?>'] = '<?php echo $value; ?>';
		<?php
			}
		}
		?>

		mercury_emv_pad_reset(<?php echo json_encode($reset_params['post_host']); ?>, <?php echo $this->Location->get_info_for_key('listener_port'); ?>, data);
	<?php
	}

	?>

	var submitting = false;

	$(document).ready(function() {

		var hasSuggestions = false;
		$('.coupon_codes').tokenfield({
			tokens: <?php echo json_encode($coupon_codes); ?>,
			autocomplete: {
				source: '<?php echo site_url("sales/search_coupons"); ?>',
				delay: 100,
				autoFocus: true,
				minLength: 0,
				showAutocompleteOnFocus: false,
				create: function() {
					$(this).data('ui-autocomplete')._renderItem = function(ul, item) {
						return $("<li class='item-suggestions'></li>")
							.data("item.autocomplete", item)
							.append('<a class="suggest-item">' +

								'<div class="name">' +
								item.label +
								'</div>'
							)
							.appendTo(ul);
					}
				},
				open: function() {
					hasSuggestions = true;
				},
				close: function() {
					hasSuggestions = false;
				}
			}
		});

		$('.coupon_codes').on("change", function() {
			$.post('<?php echo site_url("sales/set_coupons"); ?>', {
					coupons: $('.coupon_codes').tokenfield('getTokens'),
				},
				function(response) {
					$("#sales_section").html(response);
				});
		});

		$('.coupon_codes').on('tokenfield:createtoken', function(event) {
			var existingTokens = $(this).tokenfield('getTokens');
			$.each(existingTokens, function(index, token) {
				if (token.value === event.attrs.value) {
					event.preventDefault();
				}
			});

			var menu = $("#coupons-tokenfield").data("uiAutocomplete").menu.element,
				focused = menu.find("li:has(a.ui-state-focus)");

			if (focused.length !== 1 || !hasSuggestions) {
				event.preventDefault();
			}
		});

		$("#ebt_voucher_no").bind('keyup change', function() {
			$.post('<?php echo site_url("sales/set_ebt_voucher_no"); ?>', {
				ebt_voucher_no: $(this).val()
			});
		});

		$("#ebt_auth_code").bind('keyup change', function() {
			$.post('<?php echo site_url("sales/set_ebt_auth_code"); ?>', {
				ebt_auth_code: $(this).val()
			});
		});

		$("#keyboard_toggle").click(function(e) {
			e.preventDefault();
			$("#keyboardhelp").toggle();
		});

		$.fn.editable.defaults.mode = 'popup';

		$('.fullscreen').on('click', function(e) {
			e.preventDefault();
			salesRecvFullScreen();
			$.get('<?php echo site_url("home/set_fullscreen/1"); ?>');
		});

		$('.customer-giftcard-item').on('click', function(e) {
			e.preventDefault();
			$.post('<?php echo site_url("sales/set_selected_payment"); ?>', {
				payment: <?php echo json_encode(lang('giftcard')); ?>
			});
			$('#select-mode-3').html('<i class="fa fa-money-bill"></i>' + $(this).data('payment'));
			$('#payment_types').val(<?php echo json_encode(lang('giftcard')); ?>);

			$('.select-payment').removeClass('active');
			$('a[data-payment=<?php echo json_encode(lang('giftcard')); ?>]').addClass('active');
			$("#amount_tendered").focus();

			$("#amount_tendered").val($(this).data('giftcard-number'));

		});


		$('.dismissfullscreen').on('click', function(e) {
			e.preventDefault();
			salesRecvDismissFullscren();
			$.get('<?php echo site_url("home/set_fullscreen/0"); ?>');
		});

		$('.xeditable').editable({
			validate: function(value) {
				if ($.isNumeric(value) == '' && $(this).data('validate-number')) {
					return <?php echo json_encode(lang('only_numbers_allowed')); ?>;
				}
			},
			success: function(response, newValue) {
				last_focused_id = $(this).attr('id');
				$("#sales_section").html(response);
			},
			savenochange: true
		});
		$('.xeditable-comment').editable();
		$('.xeditable').on('shown', function(e, editable) {

			$(this).closest('.table-responsive').css('overflow-x', 'hidden');

			editable.input.postrender = function() {
				//Set timeout needed when calling price_to_change.editable('show') (Not sure why)
				setTimeout(function() {
					editable.input.$input.select();
				}, 200);
			};
		});

		$('.xeditable').on('hidden', function(e, editable) {
			$(this).closest('.table-responsive').css('overflow-x', 'auto');
		});

		$('.xeditable').on('hidden', function(e, editable) {
			last_focused_id = $(this).attr('id');
			$('#' + last_focused_id).focus();
			$('#' + last_focused_id).select();
		});

		<?php
		if (isset($price_zero) && $price_zero) {
		?>
			var price_to_change = $('#register a[data-name="unit_price"]').first();
			price_to_change.editable('show');
		<?php
		}
		?>

		<?php
		if (isset($quantity_set) && $quantity_set) {
		?>
			var quantity_to_change = $('#register a[data-name="quantity"]').first();
			quantity_to_change.editable('show');
		<?php
		}
		?>

		<?php
		if (isset($do_verify_age) && $do_verify_age) {
		?>
			bootbox.prompt({
				title: <?php echo json_encode(lang('sales_please_enter_date_of_birth')); ?>,
				inputType: 'text',
				placeholder: <?php echo json_encode(get_date_format_extended()); ?>,
				callback: function(dob) {
					if (dob) {
						$.post('<?php echo site_url("sales/save_dob/" . (count($cart_items) - 1)); ?>', {
							dob: dob
						}, function(response) {
							if (response.success) {
								show_feedback('success', response.message, <?php echo json_encode(lang('success')); ?>);
							} else {
								show_feedback('error', response.message, <?php echo json_encode(lang('error')); ?>);
								$("#sales_section").load('<?php echo site_url("sales/sales_reload"); ?>');
							}
						}, "json");
					} else {
						$('#register a.delete-item pull-right').first().click();
					}
				}
			});

		<?php
		}
		?>
		// Look up receipt form handling

		$('#look-up-receipt').on('shown.bs.modal', function() {
			$('#sale_id').focus();
		});

		$('.look-up-receipt-form').on('submit', function(e) {
			e.preventDefault();

			$('.look-up-receipt-form').ajaxSubmit({
				success: function(response) {
					if (response.success) {
						window.location.href = '<?php echo site_url("sales/receipt"); ?>/' + response.sale_id;
					} else {
						$('.look-up-receipt-error').html(response.message);
					}
				},
				dataType: 'json'
			});
		});

		//Set Item tier after selection
		$('.item-tiers a').on('click', function(e) {
			e.preventDefault();

			$('.selected-tier').html($(this).text());
			$.post('<?php echo site_url("sales/set_tier_id"); ?>', {
				tier_id: $(this).data('value')
			}, function(response) {
				$('.item-tiers').slideToggle("fast", function() {
					$("#sales_section").html(response);
				});
			});
		});

		//Slide Toggle item tier options
		$('.item-tier').on('click', function(e) {
			e.preventDefault();
			$('.item-tiers').slideToggle("fast");
		});

		//Set Item tier after selection
		$('.select-sales-persons a').on('click', function(e) {
			e.preventDefault();

			$('.selected-sales-person').html($(this).text());
			$.post('<?php echo site_url("sales/set_sold_by_employee_id"); ?>', {
				sold_by_employee_id: $(this).data('value')
			}, function() {
				$('.select-sales-persons').slideToggle("fast");
				$("#sales_section").load('<?php echo site_url("sales/sales_reload"); ?>');
			});
		});

		//Slide Toggle item tier options
		$('.select-sales-person').on('click', function(e) {
			e.preventDefault();
			$('.select-sales-persons').slideToggle("fast");
		});

		checkPaymentTypes();

		$('#toggle_email_receipt').on('click', function(e) {
			e.preventDefault();
			var checkBox = $("#email_receipt");
			checkBox.prop("checked", !checkBox.prop("checked")).trigger("change");
			$(this).toggleClass('checked');
		});

		$('#email_receipt').change(function(e) {
			e.preventDefault();
			$.post('<?php echo site_url("sales/set_email_receipt"); ?>', {
				email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'
			});
		});

		$('#toggle_sms_receipt').on('click', function(e) {
			e.preventDefault();
			var checkBox = $("#sms_receipt");
			checkBox.prop("checked", !checkBox.prop("checked")).trigger("change");
			$(this).toggleClass('checked');
		});

		$('#sms_receipt').change(function(e) {
			e.preventDefault();
			$.post('<?php echo site_url("sales/set_sms_receipt"); ?>', {
				sms_receipt: $('#sms_receipt').is(':checked') ? '1' : '0'
			});
		});

		$('#delivery').change(function(e) {
			e.preventDefault();
			$.post('<?php echo site_url("sales/set_delivery"); ?>', {
				delivery: $('#delivery').is(':checked') ? '1' : '0'
			}, function(response) {
				if (!$('#delivery').is(':checked')) {
					$("#sales_section").html(response);
				}
			});
		});

		// Customer form script
		$('#item,#customer').click(function() {
			$(this).attr('value', '');
		});


		// if #mode is changed
		$('.change-mode').click(function(e) {
			$('.mode_text').html("<i class='icon ti-shopping-cart'></i>" + $(this).data('mode'));
			$(".sales-dropdown li:first-child").remove();
			if ($(this).data('mode') == 'sale') {
				$('.sales-dropdown').prepend('<li><a tabindex="-1" href="#" data-mode="return" class="change-mode"><?php echo lang('return'); ?></a></li>');
			} else {
				$('.sales-dropdown').prepend('<li><a tabindex="-1" href="#" data-mode="sale" class="change-mode"><?php echo lang('sale'); ?></a></li>');
			}
			e.preventDefault();
			if ($(this).data('mode') == "store_account_payment") { // Hiding the category grid
				$('#show_hide_grid_wrapper, #category_item_selection_wrapper').fadeOut();
			} else { // otherwise, show the categories grid
				$('#show_hide_grid_wrapper, #show_grid').fadeIn();
				$('#hide_grid').fadeOut();
			}
			$.post('<?php echo site_url("sales/change_mode"); ?>', {
				mode: $(this).data('mode')
			}, function(response) {

				$("#sales_section").html(response);
			});
		});


		<?php if (!$this->agent->is_mobile()) { ?>
			<?php if (!$this->config->item('auto_focus_on_item_after_sale_and_receiving')) { ?>
				if (last_focused_id && last_focused_id != 'item') {
					setTimeout(function() {
						$('#' + last_focused_id).focus();
						$('#' + last_focused_id).select();
					}, 10);
				}
			<?php
			} else {
			?>
				setTimeout(function() {
					$("#item").focus();
				}, 10);
			<?php
			}
			?>
			$(document).off('focusin');
			$(document).focusin(function(event) {
				last_focused_id = $(event.target).attr('id');
			});
			<?php
		} else {
			if ($this->config->item('wireless_scanner_support_focus_on_item_field')) {
			?>
				setTimeout(function() {
					$("#item").focus();
				}, 10);
			<?php } ?>


		<?php } ?>

		$(".pay_store_account_sale_form").submit(function(e) {
			e.preventDefault();

			var action = $(this).attr('action');
			var is_delete_payment = action.indexOf('delete_store_account') !== -1;

			if (!is_delete_payment) {
				var that = this
				bootbox.prompt({
					title: <?php echo json_encode(lang('please_enter_payment_amount')); ?>,
					inputType: 'text',
					value: $(this).data('full-amount'),
					callback: function(amount) {
						if (amount) {
							var new_action = action.replace($(that).data('full-amount'), amount);
							$(that).attr('action', new_action);
							$(that).ajaxSubmit({
								target: "#sales_section"
							});
						}
					}
				});
			} else {
				$(this).ajaxSubmit({
					target: "#sales_section"
				});
			}
		});

		$('#pay_or_unpay_all').click(function() {
			$("#sales_section").load(<?php echo json_encode(site_url('sales/toggle_pay_all_store_account')); ?>);
		});

		$(document).on("click", ".secondary_supplier_row", function() {
			$(this).find(".secondary_supplier").prop("checked", true);
			$("#secondary_supplier_id").val($(this).find(".secondary_supplier").val());
			$(".default_supplier_row").find(".default_supplier").prop("checked", false);
			$("#default_supplier_id").val("");
		});

		$(document).on("click", ".default_supplier_row", function() {
			$(this).find(".default_supplier").prop("checked", true);
			$("#default_supplier_id").val($(this).find(".default_supplier").val());
			$("#secondary_supplier_id").val("");

			$(".secondary_supplier_row").each(function() {
				$(this).find(".secondary_supplier").prop("checked", false);
			});
		});

		$(document).on("change", ".secondary_supplier", function() {
			$("#secondary_supplier_id").val($(this).val());
		});

		$(document).on('click', '#add_supplier', function() {

			var default_supplier_id = $("#default_supplier_id").val();
			var secondary_supplier_id = $("#secondary_supplier_id").val();

			if (!default_supplier_id && !secondary_supplier_id) {
				$("#default_supplier_id").val($(".default_supplier_row").find(".default_supplier").val());
			}

			$('#var_popup_ss').modal('hide');
			$('#var_popup_ss_1').modal('hide');
			$('#add_item_form').ajaxSubmit({
				target: "#sales_section",
				beforeSubmit: salesBeforeSubmit,
				success: itemScannedSuccess
			});
		});

		if ($("#item").length) {

			<?php
			if ($this->Employee->has_module_action_permission('sales', 'allow_item_search_suggestions_for_sales', $this->Employee->get_logged_in_employee_info()->person_id)) {
			?>
				$("#item").autocomplete({
					source: '<?php echo site_url("sales/item_search"); ?>',
					delay: 500,
					autoFocus: false,
					minLength: 0,
					select: function(event, ui) {

						if (ui.item.value == "") return;

						//if item has secondary suppliers and has no variation
						<?php if (!$this->config->item('disable_supplier_selection_on_sales_interface')) { ?>
							if (ui.item.hasOwnProperty('secondary_suppliers')) {
								if (ui.item.secondary_suppliers.length > 0 && !ui.item.hasOwnProperty('attributes')) {
									$('#var-customize-ss').text(ui.item.label);
									$('#var_popup_ss').modal('show');
									$('.placeholder_supplier_vals2 .secondary-supplier-table tr').not(':first').remove();

									$.each(ui.item.default_supplier, function(supplier_key, supplier) {
										$('.placeholder_supplier_vals2 .secondary-supplier-table tr:last').after('<tr class="default_supplier_row" style="cursor:pointer;" data-supplier_id="' + supplier.supplier_id + '"> <td><input class="default_supplier" type="radio" style="display:block;" value="' + supplier.supplier_id + '" name="default_supplier" ></td> <td>' + supplier.company_name + ', ' + supplier.full_name + '</td> <td>' + parseFloat(supplier.cost_price).toFixed(2) + '</td> <td>' + parseFloat(supplier.unit_price).toFixed(2) + '</td> </tr>');
										$("#default_supplier_id").val(supplier.supplier_id);
									});

									$(".default_supplier_row").find(".default_supplier").prop("checked", true);

									$.each(ui.item.secondary_suppliers, function(supplier_key, supplier) {
										$('.placeholder_supplier_vals2 .secondary-supplier-table tr:last').after('<tr class="secondary_supplier_row" style="cursor:pointer;" data-supplier_id="' + supplier.supplier_id + '"> <td><input class="secondary_supplier" type="radio" style="display:block;" value="' + supplier.supplier_id + '" name="secondary_supplier" ></td> <td>' + supplier.company_name + ', ' + supplier.full_name + '</td> <td>' + parseFloat(supplier.cost_price).toFixed(2) + '</td> <td>' + parseFloat(supplier.unit_price).toFixed(2) + '</td> </tr>');
									});

									if (ui.item.serial_number != undefined && ui.item.serial_number != '') {
										$("#item").val(decodeHtml(ui.item.serial_number));
									} else {
										$("#item").val(decodeHtml(ui.item.value) + '|FORCE_ITEM_ID|');
									}

									return true;
								}
							}
						<?php } ?>

						if (ui.item.serial_number != undefined && ui.item.serial_number != '') {
							$("#item").val(decodeHtml(ui.item.serial_number));
						} else {
							$("#item").val(decodeHtml(ui.item.value) + '|FORCE_ITEM_ID|');
						}
						$('#add_item_form').ajaxSubmit({
							target: "#sales_section",
							beforeSubmit: salesBeforeSubmit,
							success: itemScannedSuccess
						});

					},
				}).data("ui-autocomplete")._renderItem = function(ul, item) {
					return $("<li class='item-suggestions'></li>")
						.data("item.autocomplete", item)
						.append('<a class="suggest-item"><div class="item-image symbol symbol-50px">' +
							'<img src="' + item.image + '" alt="">' +
							'</div>' +
							'<div class="details">' +
							'<div class="name">' +
							decodeHtml(item.label) +
							'</div>' +
							'<span class="attributes">' + '<?php echo lang("category"); ?>' + ' : <span class="value">' + (item.category ? item.category : <?php echo json_encode(lang('none')); ?>) + '</span></span>' +
							<?php if ($this->Employee->has_module_action_permission('items', 'see_item_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>(typeof item.quantity !== 'undefined' && item.quantity !== null ? '<span class="attributes">' + '<?php echo lang("quantity"); ?>' + ' <span class="value">' + item.quantity + '</span></span>' : '') +
							<?php } ?>(item.attributes ? '<span class="attributes">' + '<?php echo lang("attributes"); ?>' + ' : <span class="value">' + item.attributes + '</span></span>' : '') +
							'<?php if (!$this->config->item('hide_supplier_in_item_search_result')) { ?>' +
							(item.supplier_name ? '<span class="attributes">' + '<?php echo lang("supplier"); ?>' + ' : <span class="value">' + item.supplier_name + '</span></span>' : '') +
							'<?php } ?>' +
							'</div>')
						.appendTo(ul);
				};
			<?php } ?>
		}


		<?php if (!$ref_sale_id && $this->config->item('use_saudi_tax_config')) { ?>
			$("#ref_sale_id").autocomplete({
				source: '<?php echo site_url("zatca/invoice_search"); ?>',
				delay: 500,
				autoFocus: false,
				minLength: 0,
				select: function(event, ui) {
					$.post('<?php echo site_url("sales/select_zatca_invoice"); ?>', {
						ref_sale_id: decodeHtml(ui.item.value) + '|FORCE_SALE_ID|'
					}, function(response) {
						$("#register_container").html(response);
					});
				},
			}).data("ui-autocomplete")._renderItem = function(ul, item) {

				return $("<li class='customer-badge suggestions'></li>")
					.data("item.autocomplete", item)
					.append('<a class="suggest-item"><div class="avatar">' +
						'<img src="' + item.avatar + '" alt="">' +
						'</div>' +
						'<div class="details">' +
						'<div class="name">' +
						item.label +
						'</div>' +
						'<span class="email">' +
						item.subtitle +
						'</span>' +
						'</div></a>')
					.appendTo(ul);
			};

			$('#select_zatca_invoice_form').bind('keypress', function(e) {
				if (e.keyCode == 13) {
					e.preventDefault();
					$('#select_zatca_invoice_form').ajaxSubmit({
						target: "#register_container",
						beforeSubmit: salesBeforeSubmit
					});
				}
			});

		<?php } else { ?>
			$('#del_ref_sale_id').click(function(event) {
				event.preventDefault();
				$("#register_container").load($(this).attr('href'));
			});
		<?php } ?>
		<?php if (!isset($customer)) { ?>

			if ($("#customer").length) {


				<?php
				if ($this->Employee->has_module_action_permission('sales', 'allow_customer_search_suggestions_for_sales', $this->Employee->get_logged_in_employee_info()->person_id)) {
				?>


					$("#customer").autocomplete({
						source: '<?php echo site_url("sales/customer_search"); ?>',
						delay: 500,
						autoFocus: false,
						minLength: 0,
						select: function(event, ui) {
							$.post('<?php echo site_url("sales/select_customer"); ?>', {
								customer: decodeHtml(ui.item.value) + '|FORCE_PERSON_ID|'
							}, function(response) {
								$("#sales_section").html(response);
							});
						},
					}).data("ui-autocomplete")._renderItem = function(ul, item) {
						return $("<li class='customer-badge suggestions'></li>")
							.data("item.autocomplete", item)
							.append('<a class="suggest-item"><div class="avatar">' +
								'<img src="' + item.avatar + '" alt="">' +
								'</div>' +
								'<div class="details">' +
								'<div class="name">' +
								item.label +
								'</div>' +
								'<span class="email">' +
								item.subtitle +
								'</span>' +
								'</div></a>')
							.appendTo(ul);
					};
				<?php } ?>
			}
		<?php } ?>

		$('#change_date_enable').is(':checked') ? $("#change_cart_date_picker").show() : $("#change_cart_date_picker").hide();

		$('#change_date_enable').click(function() {
			if ($(this).is(':checked')) {
				$("#change_cart_date_picker").show();
			} else {
				$("#change_cart_date_picker").hide();
			}
		});

		$('#comment').change(function() {
			$.post('<?php echo site_url("sales/set_comment"); ?>', {
				comment: $('#comment').val() ? $('#comment').val() : "",
				ref_sale_desc: $('#ref_sale_desc').val() ? $('#ref_sale_desc').val() : ""
			});
		});

		$('#return_reason').change(function() {
			$.post('<?php echo site_url("sales/set_return_reason"); ?>', {
				return_reason: $('#return_reason').val() ? $('#return_reason').val() : "",
			});
		});


		$('#ref_sale_desc').change(function() {
			$.post('<?php echo site_url("sales/set_comment"); ?>', {
				comment: $('#comment').val() ? $('#comment').val() : "",
				ref_sale_desc: $('#ref_sale_desc').val() ? $('#ref_sale_desc').val() : ""
			});
		});



		$('#show_comment_on_receipt').change(function() {
			$.post('<?php echo site_url("sales/set_comment_on_receipt"); ?>', {
				show_comment_on_receipt: $('#show_comment_on_receipt').is(':checked') ? '1' : '0'
			});
		});

		$('#create_invoice').change(function() {
			$.post('<?php echo site_url("sales/set_create_invoice"); ?>', {
				create_invoice: $('#create_invoice').is(':checked') ? '1' : '0'
			});
		});


		// Create Work Order 
		$('#create_work_order').change(function() {
			$.post('<?php echo site_url("sales/set_create_work_order"); ?>', {
				create_work_order: $('#create_work_order').is(':checked') ? '1' : '0'
			});
		});


		date_time_picker_field($("#change_cart_date"), JS_DATE_FORMAT + " " + JS_TIME_FORMAT);

		$("#change_cart_date").on("dp.change", function(e) {
			$.post('<?php echo site_url("sales/set_change_cart_date"); ?>', {
				change_cart_date: $('#change_cart_date').val()
			});
		});

		//Input change
		$("#change_cart_date").change(function() {
			$.post('<?php echo site_url("sales/set_change_cart_date"); ?>', {
				change_cart_date: $('#change_cart_date').val()
			});
		});

		$('#change_date_enable').change(function() {
			$.post('<?php echo site_url("sales/set_change_date_enable"); ?>', {
				change_date_enable: $('#change_date_enable').is(':checked') ? '1' : '0'
			});
		});


		$('.delete-item, .delete-payment, #delete_customer').click(function(event) {
			event.preventDefault();
			// $("#sales_section").load();
			$.get($(this).attr('href'), function(response) {
				$("#sales_section").html(response);
			});

		});

		$('.delete-tax').click(function(event) {
			event.preventDefault();
			var $that = $(this);
			bootbox.confirm(<?php echo json_encode(lang("confirm_sale_tax_delete")); ?>, function(result) {
				if (result) {
					$("#sales_section").load($that.attr('href'));
				}
			});
		});


		$('#redeem_discount,#unredeem_discount').click(function(event) {
			event.preventDefault();
			$("#sales_section").load($(this).attr('href'));
		});

		//Layaway Sale
		$("#layaway_sale_button").click(function(e) {
			e.preventDefault();
			bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>, function(result) {
				if (result) {
					$.post('<?php echo site_url("sales/set_comment"); ?>', {
						comment: $('#comment').val()
					}, function() {
						<?php if ($this->config->item('show_receipt_after_suspending_sale')) { ?>
							window.location = '<?php echo site_url("sales/suspend"); ?>';
						<?php } else { ?>
							$("#sales_section").load('<?php echo site_url("sales/suspend"); ?>');
						<?php } ?>
					});
				}
			});
		});

		//Estimate Sale
		$("#estimate_sale_button").click(function(e) {
			e.preventDefault();
			bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>, function(result) {
				if (result) {
					$.post('<?php echo site_url("sales/set_comment"); ?>', {
						comment: $('#comment').val()
					}, function() {
						<?php if ($this->config->item('show_receipt_after_suspending_sale')) { ?>
							window.location = '<?php echo site_url("sales/suspend/2"); ?>';
						<?php } else { ?>
							$("#sales_section").load('<?php echo site_url("sales/suspend/2"); ?>');
						<?php } ?>
					});
				}
			});
		});

		// Work Order Status Update 
		// On work_order_status_button click Call Ajax to update status

		$(".work_order_status_button").click(function(e) {
			e.preventDefault();
			var workOrderID = <?php echo $work_order_id ?? 0; ?>;
			var getID = $(this).data('suspend-index');
			var makeURL = '<?php echo site_url("work_orders/change_status/"); ?>' + workOrderID + '/' + getID;
			bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>, function(result) {
				if (result) {
					$.get(makeURL, {}, function() {
						$("#sales_section").load('<?php echo site_url("sales/suspend/2"); ?>');
					});
				}
			});
		});
		$(".additional_suspend_button").click(function(e) {
			var suspend_index = $(this).data('suspend-index');
			e.preventDefault();
			bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>, function(result) {
				if (result) {
					$.post('<?php echo site_url("sales/set_comment"); ?>', {
						comment: $('#comment').val()
					}, function() {
						<?php if ($this->config->item('show_receipt_after_suspending_sale')) { ?>
							window.location = '<?php echo site_url("sales/suspend"); ?>/' + suspend_index;
						<?php } else { ?>
							$("#sales_section").load('<?php echo site_url("sales/suspend"); ?>/' + suspend_index);
						<?php } ?>
					});
				}
			});
		});

		//Cancel Sale
		$("#cancel_sale_button").click(function(e) {
			e.preventDefault();
			bootbox.confirm(<?php echo json_encode(lang("sales_confirm_cancel_sale")); ?>, function(result) {
				if (result) {
					localStorage.setItem('cart_oc', JSON.stringify([]));
					$('#cancel_sale_form').ajaxSubmit({
						target: "#sales_section",
						beforeSubmit: salesBeforeSubmit
					});
				}
			});
		});
		//Select Payment
		$('.select-payment').on('click mousedown', selectPayment);

		<?php
		if ($selected_payment == lang('integrated_gift_card') || ($selected_payment == lang('credit') && $this->Location->get_info_for_key('enable_credit_card_processing')) || ($selected_payment == lang('ebt') && $this->Location->get_info_for_key('enable_credit_card_processing')) || ($selected_payment == lang('ebt_cash') && $this->Location->get_info_for_key('enable_credit_card_processing'))) {
		?>
			$("#credit_card_options").show();

		<?php
		}
		?>

		<?php
		if ($selected_payment == lang('ebt') && $this->Location->get_info_for_key('enable_credit_card_processing')) {
		?>
			if ($('#ebt_voucher_toggle').is(':checked')) {
				$("#ebt_voucher").show();
			} else {
				$("#ebt_voucher").hide();
			}
		<?php } ?>


		<?php
		if (($selected_payment == lang('ebt') || $selected_payment == lang('ebt_cash')) && $this->Location->get_info_for_key('enable_credit_card_processing')) {
		?>
			$("#ebt-balance-buttons").show();
		<?php } ?>


		function selectPayment(e) {
			showMarkupIfNeeded($(this).data('payment'));
			e.preventDefault();
			$.post('<?php echo site_url("sales/set_selected_payment"); ?>', {
				payment: $(this).data('payment')
			});
			$('#payment_types').val($(this).data('payment'));
			$('#select-mode-3').html('<i class="fa fa-money-bill"></i>' + $(this).data('payment'));
			<?php if ($this->Location->get_info_for_key('enable_credit_card_processing')) { ?>
				if ($(this).data('payment') == <?php echo json_encode(lang('integrated_gift_card')) ?> || $(this).data('payment') == <?php echo json_encode(lang('credit')) ?> || $(this).data('payment') == <?php echo json_encode(lang('ebt')) ?> || $(this).data('payment') == <?php echo json_encode(lang('ebt_cash')) ?>) {
					$("#credit_card_options").show();
				} else {
					$("#credit_card_options").hide();
				}

				if ($(this).data('payment') == <?php echo json_encode(lang('ebt')) ?> || $(this).data('payment') == <?php echo json_encode(lang('ebt_cash')) ?>) {
					$("#ebt-balance-buttons").show();
				} else {
					$("#ebt-balance-buttons").hide();
				}
				if ($(this).data('payment') == <?php echo json_encode(lang('ebt')) ?>) {
					$("#ebt_voucher_toggle_holder").show();
				} else {
					$("#ebt_voucher_toggle_holder").hide();
				}

				if ($('#ebt_voucher_toggle').is(':checked') && $(this).data('payment') == <?php echo json_encode(lang('ebt')) ?>) {
					$("#ebt_voucher").show();
				} else {
					$("#ebt_voucher").hide();
				}

			<?php } ?>
			// start_cc_processing
			$('.select-payment').removeClass('active');
			$(this).addClass('active');
			$("#amount_tendered").focus();
			$("#amount_tendered").attr('placeholder', '');

			checkPaymentTypes();

			if ($(this).data('payment') == <?php echo json_encode(lang('store_account')) ?>) {
				$("#create_invoice_holder").removeClass('hidden');
			} else {
				$("#create_invoice_holder").addClass('hidden');
			}


		}

		//Add payment to the sale 
		$("#add_payment_button").click(function(e) {
			e.preventDefault();

			$('#add_payment_form').ajaxSubmit({
				target: "#sales_section",
				beforeSubmit: addPaymentSalesBeforeSubmit
			});
		});

		$('#select_customer_form').bind('keypress', function(e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				$('#select_customer_form').ajaxSubmit({
					target: "#sales_section",
					beforeSubmit: salesBeforeSubmit
				});
			}
		});

		$('#add_item_form').ajaxForm({
			target: "#sales_section",
			beforeSubmit: salesBeforeSubmit,
			success: itemScannedSuccess
		});

		$('#add_item_form').bind('keypress', function(e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				localStorage.setItem('item_search_key', $("#add_item_form #item").val());

				$('#add_item_form').ajaxSubmit({
					target: "#sales_section",
					beforeSubmit: salesBeforeSubmit,
					success: itemScannedSuccess
				});
			}
		});

		//Add payment to the sale when hit enter on amount tendered input
		$('#amount_tendered').bind('keypress', function(e) {
			if (e.keyCode == 13) {
				e.preventDefault();

				//Quick complete possible
				if ($("#finish_sale_alternate_button").is(":visible")) {
					$('#add_payment_form').ajaxSubmit({
						target: "#sales_section",
						beforeSubmit: addPaymentSalesBeforeSubmit,
						complete: function() {
							$('#finish_sale_button').trigger('click');
						}
					});
				} else {
					$('#add_payment_form').ajaxSubmit({
						target: "#sales_section",
						beforeSubmit: addPaymentSalesBeforeSubmit
					});
				}
			}
		});

		//Select all text in the input when input is clicked
		$("input:text, textarea").not(".description,#comment,#internal_notes").click(function() {
			$(this).select();
		});

		// Finish Sale button
		$("#finish_sale_button").click(function(e) {
			e.preventDefault();
			<?php
			if ($this->config->item('use_saudi_tax_config')) {
			?>
				if ($("#ref_sale_desc").length > 0 && $("#ref_sale_desc").val().trim().length == 0) {
					<?php echo "show_feedback('error', " . '"Please enter the reason for the credit/debit note."' . ", " . json_encode(lang('error')) . ");" ?>
					return;
				}


				<?php
				if (!isset($customer)) {
				?>
					if ($("#ref_sale_desc").length > 0) {
						<?php echo "show_feedback('error', " . '"Please choose a customer for the credit/debit note."' . ", " . json_encode(lang('error')) . ");" ?>
						return;
					}
				<?php
				}
				?>

			<?php
			}
			?>
			var confirm_messages = [];

			//Prevent double submission of form
			$("#finish_sale_button").hide();
			$('#grid-loader').show();


			<?php if ($this->cart->get_payment_amount(lang('store_account')) > 0) { ?>
				<?php if ($is_over_credit_limit && $mode != 'store_account_payment' && !$this->config->item('disable_store_account_when_over_credit_limit')) { ?>
					confirm_messages.push(<?php echo json_encode(lang('sales_over_credit_limit_warning')); ?>);
				<?php } elseif ($is_over_credit_limit && $mode != 'store_account_payment' && $this->config->item('disable_store_account_when_over_credit_limit')) {
					echo "show_feedback('error', " . json_encode(lang('sales_over_credit_limit_error')) . ", " . json_encode(lang('error')) . ");";
					echo '$("#finish_sale_button").show();';
					echo "$('#grid-loader').hide();";
					echo 'return;';
				} ?>
			<?php } ?>
			<?php if (!$payments_cover_total) { ?>
				confirm_messages.push(<?php echo json_encode(lang('sales_payment_not_cover_total_confirmation')); ?>);
			<?php } ?>

			<?php if (!$this->config->item('disable_confirmation_sale')) { ?>
				confirm_messages.push(<?php echo json_encode(lang("sales_confirm_finish_sale")); ?>);
			<?php } ?>

			if (confirm_messages.length) {
				bootbox.confirm(confirm_messages.join("<br />"), function(result) {
					if (result) {
						finishSale();
					} else {
						//Bring back submit and unmask if fail to confirm
						$("#finish_sale_button").show();
						$('#grid-loader').hide();
					}
				});
			} else {
				finishSale();
			}
		});

		<?php if (!$this->config->item('disable_quick_complete_sale')) { ?>

			if ($("#payment_types").val() == <?php echo json_encode(lang('giftcard')); ?>) {
				$('#finish_sale_alternate_button').removeClass('hidden');
				$('#add_payment_button').addClass('hidden');
			} else if ($("#payment_types").val() == <?php echo json_encode(lang('points')); ?>) {
				$('#finish_sale_alternate_button').addClass('hidden');
				$('#add_payment_button').removeClass('hidden');
			} else {
				if ((<?php echo $amount_due; ?> >= 0 && $('#amount_tendered').val() >= <?php echo $amount_due; ?>) || (<?php echo $amount_due; ?> < 0 && $('#amount_tendered').val() <= <?php echo $amount_due; ?>)) {
					$('#finish_sale_alternate_button').removeClass('hidden');
					$('#add_payment_button').addClass('hidden');
				} else {
					$('#finish_sale_alternate_button').addClass('hidden');
					$('#add_payment_button').removeClass('hidden');
				}
			}

			$('#amount_tendered').on('input', amount_tendered_input_changed);

			$('#finish_sale_alternate_button').on('click', function(e) {
				e.preventDefault();

				if (noPaymentSelected()) {
					return false;
				}
				if (!checkRequiredFields()) {
					return false;
				}
				$('#add_payment_form').ajaxSubmit({
					target: "#sales_section",
					beforeSubmit: salesBeforeSubmit,
					complete: function() {
						$('#finish_sale_button').trigger('click');
					}
				});
			});

		<?php } ?>



		function show_grid() {
			$("#category_item_selection_wrapper").promise().done(function() {
				$("#category_item_selection_wrapper").slideDown();
				$('.show-grid').addClass('hidden');
				$('.hide-grid').removeClass('hidden');
			});
		}

		function hide_grid() {
			$("#category_item_selection_wrapper").promise().done(function() {
				$("#category_item_selection_wrapper").slideUp();
				$('.hide-grid').addClass('hidden');
				$('.show-grid').removeClass('hidden');
			});
		}

		// Show or hide item grid
		$("#show_grid, .show-grid").on('click', function(e) {
			e.preventDefault();
			if (!$(':animated').length) {}

			show_grid();
		});

		$("#hide_grid,#hide_grid_top, .hide-grid").on('click', function(e) {
			e.preventDefault();
			if (!$(':animated').length) {}

			hide_grid();
		});



		// Save credit card info
		$('#save_credit_card_info').change(function() {
			$.post('<?php echo site_url("sales/set_save_credit_card_info"); ?>', {
				save_credit_card_info: $('#save_credit_card_info').is(':checked') ? '1' : '0'
			});
		});

		// Use saved cc info
		$('#use_saved_cc_info').change(function() {
			$.post('<?php echo site_url("sales/set_use_saved_cc_info"); ?>', {
				use_saved_cc_info: $('#use_saved_cc_info').is(':checked') ? '1' : '0'
			});
		});

		// Prompt for cc info (EMV integration only)
		$('#prompt_for_card').change(function() {
			$.post('<?php echo site_url("sales/set_prompt_for_card"); ?>', {
				prompt_for_card: $('#prompt_for_card').is(':checked') ? '1' : '0'
			});
		});

		$('#show_terms_and_conditions').change(function() {
			$.post('<?php echo site_url("sales/set_show_terms_and_conditions"); ?>', {
				show_terms_and_conditions: $('#show_terms_and_conditions').is(':checked') ? '1' : '0'
			});
		});


		$('#ebt_voucher_toggle').change(function() {
			if ($('#ebt_voucher_toggle').is(':checked')) {
				$("#ebt_voucher").show();
			} else {
				$("#ebt_voucher").hide();
			}

			$.post('<?php echo site_url("sales/set_ebt_voucher"); ?>', {
				ebt_voucher: $('#ebt_voucher_toggle').is(':checked') ? '1' : '0'
			});
		});

		<?php if (isset($cart_count)) { ?>
			$('.cart-number').html(<?php echo $cart_count; ?>);
		<?php } ?>


	});
	// end of document ready


	// Re-usable Functions 


	function showMarkupIfNeeded(payment_type) {
		var payments_added = <?php echo json_encode((bool) count($this->cart->get_payments())); ?>;

		if (!payment_type || payments_added) {
			return;
		}

		$('.markup_predictions').hide();

		var markup_predictions = <?php echo json_encode($markup_predictions); ?>;

		if (markup_predictions.length == 0) {
			return;
		}

		var amount = markup_predictions[payment_type]['amount'];
		var id = markup_predictions[payment_type]['id'];

		if (amount) {
			$('#' + id).show();
		}
	}

	function checkPaymentTypes() {
		var paymentType = $("#payment_types").val();

		switch (paymentType) {
			<?php if (!$this->config->item('prompt_amount_for_cash_sale')) { ?>
				case <?php echo json_encode(lang('cash')); ?>:
					$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
					$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('cash') . ' ' . lang('amount')); ?>);
					break;
				<?php } else { ?>
				case <?php echo json_encode(lang('cash')); ?>:
					$("#amount_tendered").val("");
					$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('cash') . ' ' . lang('amount')); ?>);
					break;
				<?php } ?>

			case <?php echo json_encode(lang('check')); ?>:
				$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('check') . ' ' . lang('amount')); ?>);
				break;
			case <?php echo json_encode(lang('giftcard')); ?>:
				$("#amount_tendered").val('');
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('sales_swipe_type_giftcard')); ?>);
				<?php if (!$this->config->item('disable_giftcard_detection')) { ?>
					giftcard_swipe_field($("#amount_tendered"));
				<?php } ?>
				break;
			case <?php echo json_encode(lang('debit')); ?>:
				$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('debit') . ' ' . lang('amount')); ?>);
				break;
			case <?php echo json_encode(lang('credit')); ?>:
				$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('credit') . ' ' . lang('amount')); ?>);
				break;
			case <?php echo json_encode(lang('store_account')); ?>:
				$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('store_account') . ' ' . lang('amount')); ?>);
				break;
			case <?php echo json_encode(lang('points')); ?>:
				$("#amount_tendered").val(<?php echo (isset($number_of_points_to_use) && $number_of_points_to_use) ? $number_of_points_to_use : '""'; ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('points') . ' ' . lang('amount')); ?>);
				break;
			case <?php echo json_encode(lang('ebt')); ?>:
				<?php
				if (count($payments) == 0) {
				?>
					$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($ebt_total)); ?>);
				<?php
				}
				?>
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('ebt') . ' ' . lang('amount')); ?>);
				break;
			case <?php echo json_encode(lang('wic')); ?>:
				<?php
				if (count($payments) == 0) {
				?>
					$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($ebt_total)); ?>);
				<?php
				}
				?>
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('wic') . ' ' . lang('amount')); ?>);
				break;
			case <?php echo json_encode(lang('ebt_cash')); ?>:
				$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('ebt_cash') . ' ' . lang('amount')); ?>);
				break;
			default:
				$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter')); ?> + ' ' + paymentType + ' ' + <?php echo json_encode(lang('amount')); ?>);
		}

		showMarkupIfNeeded(paymentType);
		<?php if (!$this->config->item('disable_quick_complete_sale')) { ?>
			amount_tendered_input_changed();
		<?php } ?>

	}

	function salesBeforeSubmit(formData, jqForm, options) {
		if (submitting) {
			return false;
		}
		submitting = true;


		<?php if (isset($cart_count)) { ?>
			$('.cart-number').html(<?php echo $cart_count; ?>);
		<?php } ?>
		$("#ajax-loader").show();
		$("#add_payment_button").hide();
		$("#finish_sale_button").hide();
	}

	function addPaymentSalesBeforeSubmit(formData, jqForm, options) {
		if (submitting) {
			return false;
		}
		submitting = true;

		if (noPaymentSelected()) {
			submitting = false;
			return false;
		}
		if (!checkRequiredFields()) {
			submitting = false;
			return false;
		}
		if ($('#amount_tendered').val().length >= 10) {
			bootbox.confirm(<?php echo json_encode(lang("large_payment_amount")); ?>, function(result) {

				if (result) {
					$('#add_payment_form').ajaxSubmit({
						target: "#sales_section"
					});
				}
			});

			submitting = false;
			return false;

		}


		if (<?php echo $amount_due; ?> == 0) {
			bootbox.confirm(<?php echo json_encode(lang("sales_no_amount_due_confirm")); ?>, function(result) {
				if (result) {
					$('#add_payment_form').ajaxSubmit({
						target: "#sales_section"
					});
				}
			});

			submitting = false;
			//Prevent form form submitting
			return false;
		}

		<?php if (isset($cart_count)) { ?>
			$('.cart-number').html(<?php echo $cart_count; ?>);
		<?php } ?>
		$("#ajax-loader").show();
		$("#add_payment_button").hide();
		$("#finish_sale_button").hide();
	}

	function itemScannedSuccess(responseText, statusText, xhr, $form) {
		<?php if ($this->config->item('clean_input_after_add_item')) { ?>
			$('#item').val('');
		<?php } ?>


		$("#ajax-loader").hide();
		setTimeout(function() {
			$('#item').focus();
		}, 10);
	}

	function finishSale() {
		if ($("#comment").val() || $("#ref_sale_desc").val()) {
			$.post('<?php echo site_url("sales/set_comment"); ?>', {
				comment: ($('#comment').val() ? $('#comment').val() : ''),
				ref_sale_desc: ($('#ref_sale_desc').val() ? $('#ref_sale_desc').val() : '')
			}, function() {
				$('#finish_sale_form').submit();
			});
		} else {
			$('#finish_sale_form').submit();
		}
	}

	<?php
	if (isset($prompt_convert_sale_to_return) && $prompt_convert_sale_to_return == TRUE) {
	?>

		bootbox.confirm({
			message: <?php echo json_encode(lang("sales_confirm_convert_sale_to_return")); ?>,
			buttons: {
				confirm: {
					label: <?php echo json_encode(lang('yes')) ?>,
					className: 'btn-primary'
				},
				cancel: {
					label: <?php echo json_encode(lang('no')) ?>,
					className: 'btn-default'
				}
			},
			callback: function(result) {
				if (result) {
					$.get('<?php echo site_url("sales/convert_sale_to_return"); ?>', function(response) {
						$("#sales_section").html(response);
					});
				}
			}
		});

	<?php
	}
	?>


	<?php
	if (isset($prompt_convert_return_to_sale) && $prompt_convert_return_to_sale == TRUE) {
	?>

		bootbox.confirm({
			message: <?php echo json_encode(lang("sales_confirm_convert_return_to_sale")); ?>,
			buttons: {
				confirm: {
					label: <?php echo json_encode(lang('yes')) ?>,
					className: 'btn-primary'
				},
				cancel: {
					label: <?php echo json_encode(lang('no')) ?>,
					className: 'btn-default'
				}
			},
			callback: function(result) {
				if (result) {
					$.get('<?php echo site_url("sales/convert_return_to_sale"); ?>', function(response) {
						$("#sales_section").html(response);
					});
				}
			}
		});

	<?php
	}
	?>
	<?php
	if (isset($prompt_for_return_sale_id) && $prompt_for_return_sale_id == TRUE) {
	?>

		bootbox.prompt({
			title: <?php echo json_encode(lang('sales_enter_sale_id')); ?>,
			inputType: 'text',
			value: '',
			callback: function(sale_id) {
				if (sale_id) {
					window.location.href = "<?php echo site_url('sales/return_order/'); ?>" + encodeURIComponent(sale_id);
				}
			}
		});

	<?php
	}
	?>
	$("#exchange_to").change(function() {
		var rate = $(this).val();
		$.post('<?php echo site_url("sales/exchange_to"); ?>', {
			'rate': rate
		}, function(response) {
			$("#sales_section").html(response);
		});
	});

	$("#delete_sale_button").click(function() {
		bootbox.confirm({
			message: <?php echo json_encode(lang("sales_confirm_void_delete")); ?>,
			buttons: {
				confirm: {
					label: <?php echo json_encode(lang('yes')) ?>,
					className: 'btn-primary'
				},
				cancel: {
					label: <?php echo json_encode(lang('no')) ?>,
					className: 'btn-default'
				}
			},
			callback: function(result) {
				if (result) {
					var post_data = [];

					post_data.push({
						'name': 'sales_void_and_refund_credit_card',
						'value': <?php echo json_encode($was_cc_sale); ?>
					});

					post_data.push({
						'name': 'sales_void_and_cancel_return',
						'value': <?php echo json_encode($was_cc_return); ?>
					});

					post_data.push({
						'name': 'do_delete',
						'value': 1
					});

					post_data.push({
						'name': 'clear_sale',
						'value': 1
					});

					post_submit('<?php echo site_url("sales/delete/$sale_id_of_edit_or_suspended_sale"); ?>', 'POST', post_data);
				}
			}

		});
	});


	<?php
	if ($this->session->userdata('amount_change')) { ?>
		show_feedback('success', <?php echo json_encode($this->session->userdata('manage_success_message')); ?>, <?php echo json_encode(lang('change_due') . ': ' . to_currency($this->session->userdata('amount_change'))); ?>, {
			timeOut: 30000
		});
	<?php
		$this->session->unset_userdata('amount_change');
	}
	?>

	$("#customer_facing_display_link").click(function() {
		$("#customer_facing_display_warning").hide();
		$.get(<?php echo json_encode(site_url('sales/opened_customer_facing_display')); ?>);
	});

	$(".delete-custom-image-sale a").click(function(e) {
		e.preventDefault();
		var $that = $(this);
		bootbox.confirm(CONFIRM_IMAGE_DELETE, function(result) {
			if (result) {
				$.get($that.attr('href'), function() {
					//face out image and link
					$that.parent().fadeOut();
					$that.parent().prev().fadeOut();
				});
			}
		});
	});

	function noPaymentSelected() {
		var no_payment = $(".select-payment.active").length == 0;
		if (no_payment) {
			bootbox.alert(<?php echo json_encode(lang('must_select_payment')); ?>);
		}
		return no_payment
	}

	function checkRequiredFields() {

		var allFilled = true; // Flag to track if all required fields are filled

		// Iterate over all required input fields and selects within #operationsbox_modal
		$('#operationsbox_modal input[required], #operationsbox_modal select[required]').each(function() {
			if ($(this).val() === '') {
				allFilled = false; // Set the flag to false if a field is empty
			}
		});
		if (!allFilled) {

			var operationsbox_modal = document.querySelector("#operationsbox_modal");

			var drawer  = KTDrawer.getInstance(operationsbox_modal);
			drawer.show();
			return false; // Return false to indicate not all required fields are filled
		}

		return true; // Return true if all required fields are filled


	}


	$('.toggle_rows').click(function() {

		$(this).parent().parent().next().toggleClass('collapse');

		if ($(this).parent().parent().next().hasClass("collapse")) {
			$(this).text("+");
			$(this).parent().parent().next().addClass("d-none")
		} else {
			$(this).text("-");
			$(this).parent().parent().next().removeClass("d-none")
		}

	});
	$("#sale_details_expand_collapse").click(function() {
		$('.register-item-bottom').toggleClass('collapse');

		if ($('.register-item-bottom').hasClass('collapse')) {
			$.post('<?php echo site_url("sales/set_details_collapsed"); ?>', {
				value: '1'
			});
			$("#sale_details_expand_collapse").text('+');
			$(".show-collpased").show();

		} else {
			$.post('<?php echo site_url("sales/set_details_collapsed"); ?>', {
				value: '0'
			});
			$("#sale_details_expand_collapse").text('-');
			$(".show-collpased").hide();

		}
	});

	<?php if ($details_collapsed) { ?>
		$("#sale_details_expand_collapse").text('+');
		$('.register-item-bottom').addClass('collapse');
		$(".show-collpased").show();
	<?php } ?>

	$(".page_pagination a").click(function(e) {
		e.preventDefault();
		$("#sales_section").load($(this).attr('href'));
	});

	<?php
	$denominations = $this->Register->get_register_currency_denominations()->result();

	$bills = array();
	foreach ($denominations as $denom) {
		if ($denom->value >= 1 && count($bills) <= 8) {
			$bills[] = $denom->value;
		}
	}

	sort($bills);
	?>

	var $bills = <?php echo json_encode($bills, JSON_NUMERIC_CHECK); ?>;

	<?php if (count($bills) > 0) { ?>

		$(".btn-pay").dblclick(function() {
			var $currency_symbol = "<?php echo $this->config->item('currency_symbol'); ?>";
			var $amount_tendered = $("#amount_tendered").val();


			var $possible_amount = get_possible_amount($amount_tendered, $bills);


			var $html = '';

			$.each($possible_amount, function($index, $value) {

				$html += '<div class="col-md-3" style="margin-bottom:15px;">';
				$html += '<button tabindex="' + ($index) + '" class="btn btn-primary btn-block quick_amount" data-quick_amount="' + $value + '.00" style="height:50px; border-radius:0px; font-size:16px; font-weight:bold;">' + $currency_symbol + '' + $value + '.00</button>';
				$html += '</div>';

			});

			$("#quick_cash_holder").html($html);

			$("#choose_quick_cash").modal("show");
		});

	<?php } ?>
	var get_possible_amount = function($sales_amount, $bills) {

		var $found_amount, $get_extra, $key, $bill, $current_bill, $previous_bill, $qutnt, $mod, $quotient, $new_extra_amount, $possible_amount_using_this_bill;

		$sales_amount = Math.ceil($sales_amount);

		$found_amount = [$sales_amount];

		$get_extra = [];

		for ($key in $bills) {
			$bill = $bills[$key];
			if ($key == 0) {
				$get_extra.push(0);
				continue;
			} else {
				$current_bill = $bill;
				$previous_bill = $bills[$key - 1];

				$qutnt = $current_bill / $previous_bill;

				$mod = $current_bill % $previous_bill;

				if ($mod != 0) {
					$get_extra.push($previous_bill * Math.ceil($qutnt));
				} else {
					$get_extra.push(0);
				}
			}
		}

		for ($key in $bills) {
			$bill = $bills[$key];
			$quotient = $sales_amount / $bill;

			if ($sales_amount % $bill == 0) {
				$new_extra_amount = ($sales_amount - $bill) + $get_extra[$key];
				if ($new_extra_amount >= $sales_amount && !inArray($new_extra_amount, $found_amount)) {
					$found_amount.push($new_extra_amount);
				}
			}

			$possible_amount_using_this_bill = $bill * Math.ceil($quotient);

			if (inArray($possible_amount_using_this_bill, $found_amount)) {
				continue;
			}

			if (isNaN($possible_amount_using_this_bill)) {
				continue;
			}

			$found_amount.push($possible_amount_using_this_bill);
		}

		$found_amount.sort();

		return $found_amount.sort(function(a, b) {
			return a - b
		});

	}


	function inArray(needle, haystack) {
		var length = haystack.length;
		for (var i = 0; i < length; i++) {
			if (haystack[i] == needle) return true;
		}
		return false;
	}

	$('#choose_quick_cash').on('shown.bs.modal', function(e) {
		$("#custom_amount").focus();
	});

	$(document).on('click', '.quick_amount', function() {
		var amount_tendered = $(this).data("quick_amount");
		$("#amount_tendered").val(amount_tendered);
		$('#choose_quick_cash').modal('hide');
		$("#finish_sale_alternate_button").trigger('click');
		$("#finish_sale_button").trigger('click');
	});

	$(document).on('keyup', '#custom_amount', function() {
		var amount_tendered = $(this).val();
		$("#collect_amount").data("quick_amount", amount_tendered);
	});

	$(window).keydown(function(event) {
		if (event.ctrlKey && event.which == 81) {
			$('.btn-pay').trigger("dblclick");
			event.preventDefault();
		}

		if ($("#custom_amount").focus() && $("#custom_amount").val() > 0 && event.which == 13) {
			$('#collect_amount').trigger("click");
			event.preventDefault();
		}
	});

	<?php
	if (isset($update_transaction_display) && $update_transaction_display) {
	?>
		$.get('<?php echo site_url("sales/update_transaction_display"); ?>');
	<?php
	}
	?>

	$(document).ready(function() {

		<?php if ($this->config->item('allow_drag_drop_sale') && !$this->agent->is_mobile() && !$this->agent->is_tablet()) {  ?>

			$("#register th").on("click", function() {
				var column = ""
				if ($(this).hasClass("item_name_heading")) {
					column = "name";
				} else if ($(this).hasClass("sales_price")) {
					column = "price";
				} else if ($(this).hasClass("sales_quantity")) {
					column = "quantity";
				} else if ($(this).hasClass("sales_discount")) {
					column = "discount";
				} else if ($(this).hasClass("sales_total")) {
					column = "total";
				}
				if (column == '') return;

				var type = "asc";
				if ($(this).hasClass("ion-arrow-down-b")) {
					type = "desc";
					$("#register th").removeClass("ion-arrow-down-b");
					$("#register th").removeClass("ion-arrow-up-b");
					$(this).addClass("ion-arrow-up-b");
				} else if ($(this).hasClass("ion-arrow-up-b")) {
					type = "asc";
					$("#register th").removeClass("ion-arrow-down-b");
					$("#register th").removeClass("ion-arrow-up-b");
					$(this).addClass("ion-arrow-down-b");
				} else {
					type = "asc";
					$("#register th").removeClass("ion-arrow-down-b");
					$("#register th").removeClass("ion-arrow-up-b");
					$(this).addClass("ion-arrow-down-b");
				}
				$('#grid-loader2').show();
				$.post('<?php echo site_url("sales/sort"); ?>', {
					sort_column: column,
					sort_type: type,
				}, function(response) {
					$('#grid-loader2').hide();
					$("#sales_section").html(response);
				});
			});

			$(function() {
				var start_pos = 0;
				if ($("#register tbody").length > 1) {
					$("#register").sortable({
						items: 'tbody',
						cursor: 'pointer',
						axis: 'y',
						dropOnEmpty: false,
						start: function(e, ui) {
							ui.item.addClass("selected");
							var td_width = [];
							var td_height = [];
							for (let i = 0; i < $("#register tbody").length; i++) {
								if ($($("#register tbody")[i]).hasClass('selected') || $($("#register tbody")[i]).hasClass('ui-sortable-placeholder')) {
									continue;
								} else {
									td_height = $($("#register tbody")[i]).height();
									for (let j = 0; j < $($("#register tbody")[i]).find(".register-item-details td").length; j++) {
										td_width.push($($($("#register tbody")[i]).find(".register-item-details td")[j]).width());
									}
									break;
								}
							}
							$(".ui-sortable-placeholder").html("<tr><td>&nbsp;</td></tr>");
							$(".ui-sortable-placeholder").height(td_height + 'px');
							for (let k = 0; k < $($("#register tbody.selected tr")[0]).find('td').length; k++) {
								$($($("#register tbody.selected tr")[0]).find('td')[k]).width(td_width[k] + 'px');
							}
							start_pos = $("#register tbody.selected").parent().children().index($("#register tbody.selected"));
						},
						stop: function(e, ui) {

							let current_pos = $("#register tbody.selected").parent().children().index($("#register tbody.selected"));
							var drop_index = 0;
							if (current_pos < start_pos) // up
							{
								drop_index = $("#register tbody.selected").next().data('line');
							} else if (current_pos > start_pos) { // dwon
								drop_index = $("#register tbody.selected").prev().data('line');
							} else {
								return;
							}
							var drag_index = $("#register tbody.selected").data('line');

							for (let k = 0; k < $($("#register tbody.selected tr")[0]).find('td').length; k++) {
								$($($("#register tbody.selected tr")[0]).find('td')[k]).attr('style', '');
							}
							ui.item.removeClass("selected");
							$("#register th").removeClass("ion-arrow-down-b");
							$("#register th").removeClass("ion-arrow-up-b");

							if (drag_index != drop_index) {
								$('#grid-loader2').show();
								$.post('<?php echo site_url("sales/sort"); ?>', {
									'drag_index': drag_index,
									'drop_index': drop_index,
									'sort_column': 'drag_drop',
								}, function(response) {
									$('#grid-loader2').hide();
									$("#sales_section").html(response);
								});
							}
						},
						sort: function(e) {
							$(".ui-sortable-helper").css("width", $("table#register").width() + 'px');
							$(".ui-sortable-helper tr").css("width", $("table#register").width() + 'px');
						}
					});
				}
			});
		<?php } ?>
	});

	$(document).ready(function() {
		// Attach a change event listener to the checkbox
		$('input[name="hide_categories"]').change(function() {
			// When the state of the checkbox changes, toggle the 'd-none' class
			if (this.checked) {
				$('#category_item_selection').addClass('d-none');
				change_pos_settings('hide_categories', 1);
			} else {
				$('#category_item_selection').removeClass('d-none');
				change_pos_settings('hide_categories', 0);
			}
		});

		if ($('input[name="hide_categories"]').is(':checked')) {
			$('#category_item_selection').addClass('d-none');
		} else {
			$('#category_item_selection').removeClass('d-none');
		}

	});
	$(document).ready(function() {
		// Attach a change event listener to the checkbox
		$('input[name="hide_search_bar"]').change(function() {
			// When the state of the checkbox changes, toggle the 'd-none' class
			if (this.checked) {
				$('.register-items-form').addClass('d-none');
				change_pos_settings('hide_search_bar', 1);
			} else {
				$('.register-items-form').removeClass('d-none');
				change_pos_settings('hide_search_bar', 0);
			}
		});

		if ($('input[name="hide_search_bar"]').is(':checked')) {
			$('.register-items-form').addClass('d-none');
		} else {
			$('.register-items-form').removeClass('d-none');
		}
	});
	$(document).ready(function() {
		// Attach a change event listener to the checkbox
		$('input[name="hide_top_buttons"]').change(function() {
			// When the state of the checkbox changes, toggle the 'd-none' class
			if (this.checked) {
				$('#grid_selection').addClass('d-none');
				change_pos_settings('hide_top_buttons', 1);
			} else {
				$('#grid_selection').removeClass('d-none');
				change_pos_settings('hide_top_buttons', 0);
			}
		});

		if ($('input[name="hide_top_buttons"]').is(':checked')) {
			$('#grid_selection').addClass('d-none');
		} else {
			$('#grid_selection').removeClass('d-none');
		}
	});
	$(document).ready(function() {
		// Attach a change event listener to the checkbox
		$('input[name="hide_top_category_navigation"]').change(function() {
			// When the state of the checkbox changes, toggle the 'd-none' class
			if (this.checked) {
				$('#grid_breadcrumbs').addClass('d-none');
				change_pos_settings('hide_top_category_navigation', 1);
			} else {
				$('#grid_breadcrumbs').removeClass('d-none');
				change_pos_settings('hide_top_category_navigation', 0);
			}
		});

		if ($('input[name="hide_top_category_navigation"]').is(':checked')) {
			$('#grid_breadcrumbs').addClass('d-none');
		} else {
			$('#grid_breadcrumbs').removeClass('d-none');
		}
	});
	$(document).ready(function() {
		// Attach a change event listener to the checkbox
		$('input[name="hide_top_item_details"]').change(function() {
			// When the state of the checkbox changes, toggle the 'd-none' class
			if (this.checked) {
				$('.register-item-bottom').addClass('d-none');
				change_pos_settings('hide_top_item_details', 1);
			} else {
				$('.register-item-bottom').removeClass('d-none');
				change_pos_settings('hide_top_item_details', 0);
			}
		});

		if ($('input[name="hide_top_item_details"]').is(':checked')) {
			$('.register-item-bottom').addClass('d-none');
		} else {
			$('.register-item-bottom').removeClass('d-none');
		}
	});

	$(document).ajaxComplete(function() {
		$("#ajax-loader").hide();
	});
</script>
<script>
	$(".disable_manual_entry").click(function(e) {
		e.preventDefault();
		$("#register_container").load('<?php echo site_url("sales/set_session_var/use_manual_entry/0"); ?>');
	});

	$(".use_manual_entry").click(function(e) {
		e.preventDefault();
		$("#register_container").load('<?php echo site_url("sales/set_session_var/use_manual_entry/1"); ?>');
	});

	$(".disable_backup_gateway").click(function(e) {
		e.preventDefault();
		$("#register_container").load('<?php echo site_url("sales/set_session_var/use_backup_gateway/0"); ?>');
	});

	$(".use_backup_gateway").click(function(e) {
		e.preventDefault();
		$("#register_container").load('<?php echo site_url("sales/set_session_var/use_backup_gateway/1"); ?>');
	});



	<?php
	if (isset($async_inventory_updates) && $async_inventory_updates && $_SESSION['do_async_inventory_updates']) {
		if (!empty($_SESSION['async_inventory_updates'])) {
	?>
			$.get(<?php echo json_encode(site_url('home/async_inventory_updates')); ?>);
	<?php
		}

		unset($_SESSION['do_async_inventory_updates']);
	}
	?>

	$(document).ajaxComplete(function() {
		$("#ajax-loader").hide();
		$('.popover').remove();
	});

	$(document).ready(function() {
		// Setup click event listener
		$('#kt_app_sidebar_toggle').click(function() {
			// Toggle 'active' class on #kt_app_sidebar_toggle
			$(this).toggleClass('active');

			// Toggle 'd-none' class on all elements with the class 'pos-sidebar'
			$('.pos-sidebar').fadeToggle();
		});
	});

</script>


<script>

$(document).ready(function () {




	function checkTableRows() {
    var trElements = $('#register tbody tr:not(.cart_content_area)');
	
    // Check if there are any tr elements excluding those with the class "cart_content_area"
    if (trElements.length > 0) {
		$('#cancel_sale_button').addClass('d-flex');
		$('#cancel_sale_button').removeClass('d-none');
		$('#advance_details').addClass('d-flex');
		$('#advance_details').removeClass('d-none');
		$('#kt_drawer_suspend').addClass('d-flex');
		$('#kt_drawer_suspend').removeClass('d-none');
    } else {
		$('#cancel_sale_button').addClass('d-none');
		$('#cancel_sale_button').removeClass('d-flex');
		$('#advance_details').addClass('d-none');
		$('#advance_details').removeClass('d-flex');
		$('#kt_drawer_suspend').addClass('d-none');
		$('#kt_drawer_suspend').removeClass('d-flex');
    }
  }

  // Call the function initially
  checkTableRows();

  // Check every second
  setInterval(checkTableRows, 1000);
});

$(document).ready(function() {
    var isResizing = false;

    $('#drag-handle').on('mousedown', function(e) {
        e.preventDefault();
        isResizing = true;
        $(document).mousemove(mouseMoveHandler); // Bind mousemove when mousedown
        $(document).mouseup(stopResize); // Unbind mousemove when mouseup
    });

    function mouseMoveHandler(e) {
        if (!isResizing) return;

        var containerOffsetLeft = $('#main-container').offset().left;
        var containerWidth = $('#main-container').outerWidth();
        var leftWidth = e.clientX - containerOffsetLeft;

        var percentageLeft = (leftWidth / containerWidth) * 100;
        percentageLeft = Math.max(40, Math.min(percentageLeft, 60)); // Ensure the width is between 40% and 60%
        var percentageRight = 100 - percentageLeft;

        $('#left-section').css('width', `${percentageLeft}%`);
        $('#sales_section').css('width', `${percentageRight}%`);

        adjustColumnClasses(leftWidth); // Adjust columns continuously as the mouse moves
    }

    function stopResize() {
        $(document).off('mousemove', mouseMoveHandler); // Unbind mousemove
        isResizing = false;
    }

	function adjustColumnClasses() {
        var containerWidth = $('#left-section').width();
        // Example: Adjust based on the new width of the left-section
        if (containerWidth <= 576) { // Smaller devices
            $('#category_item_selection_wrapper_new .col-md-3, #category_item_selection_wrapper_new .col-lg-2').addClass('col-sm-4').removeClass('col-md-3 col-lg-2');
        } else if (containerWidth > 576 && containerWidth <= 768) { // Medium devices
            $('#category_item_selection_wrapper_new .col-sm-4, #category_item_selection_wrapper_new .col-lg-2').addClass('col-md-3').removeClass('col-sm-4 col-lg-2');
        } else { // Larger devices
            $('#category_item_selection_wrapper_new .col-sm-4, #category_item_selection_wrapper_new .col-md-3').addClass('col-lg-2').removeClass('col-sm-4 col-md-3');
        }
    }
});


// $(document).ready(function() {
//     var isResizing = false;

//     $('#drag-handle').on('mousedown', function(e) {
//         isResizing = true;
//         $(document).on('mousemove', mouseMoveHandler);
//         $(document).on('mouseup', function() {
//             $(document).off('mousemove', mouseMoveHandler);
//             isResizing = false;
//             adjustColumnClasses(); // Adjust columns after resizing is complete
//         });
//     });

//     function mouseMoveHandler(e) {
//         if (!isResizing) {
//             return;
//         }
//         var containerOffsetLeft = $('#main-container').offset().left;
//         var newLeftWidth = e.clientX - containerOffsetLeft;

//         // Calculate percentages
//         var containerWidth = $('#main-container').width();
//         var percentageLeft = (newLeftWidth / containerWidth) * 100;
//         var percentageRight = 100 - percentageLeft;

//         // Constrain the resizing between 40% and 60%
//         if (percentageLeft < 40 || percentageLeft > 60) {
//             return; // Restrict resizing beyond 40-60% range
//         }

//         $('#left-section').css('width', `${percentageLeft}%`);
//         $('#sales_section').css('width', `${percentageRight}%`);
//     }

//     function adjustColumnClasses() {
//         var containerWidth = $('#left-section').width();
//         // Example: Adjust based on the new width of the left-section
//         if (containerWidth <= 576) { // Smaller devices
//             $('#category_item_selection_wrapper_new .col-md-3, #category_item_selection_wrapper_new .col-lg-2').addClass('col-sm-4').removeClass('col-md-3 col-lg-2');
//         } else if (containerWidth > 576 && containerWidth <= 768) { // Medium devices
//             $('#category_item_selection_wrapper_new .col-sm-4, #category_item_selection_wrapper_new .col-lg-2').addClass('col-md-3').removeClass('col-sm-4 col-lg-2');
//         } else { // Larger devices
//             $('#category_item_selection_wrapper_new .col-sm-4, #category_item_selection_wrapper_new .col-md-3').addClass('col-lg-2').removeClass('col-sm-4 col-md-3');
//         }
//     }

//     adjustColumnClasses(); // Initial adjustment
// });
</script>