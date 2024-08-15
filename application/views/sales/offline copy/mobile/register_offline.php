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
<div class="mobile_footer" id="mobile_footer">
		
        <div class="  row py-1 px-6">
            <div class="fw-bolder border footer-btn border-gray-200 border btn btn-primary col-4 border-radius-0 "
                id="show_products">
                Products
            </div>
            <div class="fw-bolder border footer-btn border-gray-200 border  btn btn-secondary col-4 border-radius-0  "
                id="show_cart">
                Cart
            </div>
            <div class=" fw-bolder border  border-gray-300 border  btn  btn-light col-4 border-radius-0 text-success " id="show_total">
                0
            </div>
        </div>
    </div>
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
	<div class="col-12 no-padding-right no-padding-left" id="left-section">
	<div id="drag-handle" style="cursor: ew-resize;width: 7px;position: relative;background-color: #0009;height: 100%;float: right;z-index: 99;"></div>
		<div class="d-flex">
			<div id="kt_app_sidebar_toggle" class="w-100px text-center pt-2  text-light cursor-pointer bg-black rotate d-none" data-kt-rotate="true">

				<span class="svg-icon svg-icon-muted svg-icon-2x rotate-180" style="margin: 0 auto;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M14.4 11H2.99999C2.39999 11 1.99999 11.4 1.99999 12C1.99999 12.6 2.39999 13 2.99999 13H14.4V11Z" fill="currentColor"/>
				<path d="M17.7762 13.2561C18.4572 12.5572 18.4572 11.4429 17.7762 10.7439L13.623 6.48107C13.1221 5.96697 12.25 6.32158 12.25 7.03934V16.9607C12.25 17.6785 13.1221 18.0331 13.623 17.519L17.7762 13.2561Z" fill="currentColor"/>
				<rect opacity="0.5" width="2" height="16" rx="1" transform="matrix(-1 0 0 1 22 4)" fill="currentColor"/>
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
				<div class="register-box register-items-form  row  justify-content-space-between ">
					<a tabindex="-1" href="#" class="dismissfullscreen <?php echo !$fullscreen ? 'hidden' : ''; ?>"><i class="ion-close-circled"></i></a>
					<div id="itemForm" class="item-form bg-light-100  col-12 ">
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

					<div class="col-12">
					

						<?php echo form_open("sales/cancel_sale", array('id' => 'cancel_sale_form', 'autocomplete' => 'off', 'class' => 'row justify-content-center')); ?>
						
							<?php if ($mode != 'store_account_payment' && $mode != 'purchase_points') { ?>

								<?php if ($this->Employee->has_module_action_permission('sales', 'suspend_sale', $this->Employee->get_logged_in_employee_info()->person_id) && $customer_required_check && $suspended_sale_customer_required_check && !$this->config->item('test_mode')) { ?>
									<div class="d-flex flex-column bg-primary p-3 flex-center w-75px h-40px me-1 " id="kt_drawer_suspend" class="menu-icon w-100 " data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover" data-bs-original-title="Metronic Builder" data-kt-initialized="1">
										
										<div class=" py-2">
											<?= lang('save_as') ?> </div>
									</div>
									<div class="d-flex flex-column bg-primary  p-3 flex-center w-75px h-40px me-1 " id="cancel_sale_button">
									
										<div class=" py-2"><?php echo $this->cart->get_previous_receipt_id() ||  $this->cart->suspended ? lang('back') : lang('clear'); ?></div>
									</div>

								<?php } ?>
							<?php } ?>


							<?php
							if (($this->cart->get_previous_receipt_id() || $this->cart->suspended) && $this->Employee->has_module_action_permission('sales', 'delete_sale', $this->Employee->get_logged_in_employee_info()->person_id)) {
							?>

								<div class="d-flex flex-column bg-primary  p-3 flex-center w-75px h-40px me-1 " id="delete_sale_button">
									

										<div class=" py-2"><?php echo lang('void'); ?></div>
									</div>


							<?php
							}
							?>
						<div class="d-flex flex-column bg-primary p-3 flex-center w-75px h-40px ddd " id="advance_details" >
							
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
			<div class="w-100px bg-black pos-sidebar d-none">
				<!--begin::Sidebar menu-->
				<div class="app-sidebar-menu app-sidebar-menu-arrow hover-scroll-overlay-y my-5 my-lg-5 px-3  pos-menu" id="kt_app_sidebar_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_toolbar, #kt_app_sidebar_footer" data-kt-scroll-offset="0" style="height: 490px;">
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
							<a class=" menu-link " href="<?php echo site_url('sales/sales_list'); ?>">
								<span class="menu-icon  w-100 " >
								<!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/arrows/arr043.svg-->
									<span class="svg-icon svg-icon-muted svg-icon-2x w-100 "><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path opacity="0.3" d="M21 22H12C11.4 22 11 21.6 11 21V3C11 2.4 11.4 2 12 2H21C21.6 2 22 2.4 22 3V21C22 21.6 21.6 22 21 22Z" fill="currentColor"/>
									<path d="M19 11H6.60001V13H19C19.6 13 20 12.6 20 12C20 11.4 19.6 11 19 11Z" fill="currentColor"/>
									<path opacity="0.3" d="M6.6 17L2.3 12.7C1.9 12.3 1.9 11.7 2.3 11.3L6.6 7V17Z" fill="currentColor"/>
									</svg>
									<span class="menu-title w-100"><?= lang('back_to_sale'); ?></span>
									</span>
									<!--end::Svg Icon-->
								</span> 
							
										</a>

						</div>
						</div>


						<div class="menu-item pt-5">
							<div class="menu-content">
								<span class="text-uppercase fw-bold menu-heading fs-7">
									<strong>
										<?php echo lang('quick_access') ?>
									</strong>
								</span>
								<span class="fw-bold menu-heading fs-7" style="color: var(--bs-app-light-sidebar-logo-icon-custom-color);font-family: Inter, sans-serif;font-style: italic;font-weight: bold;" onclick="show_quick_access()">&nbsp; &nbsp;
									<?php echo lang('edit') ?>
								</span>
							</div>
						</div>

						<?php

						if (get_quick_access()) :
							$quick_access = get_quick_access();
						?>

							<?php if ($this->Employee->has_module_permission('sales', $employee_id) && in_array('pos', $quick_access)) { ?>
								<div class="menu-item" <?php echo array_search('sales', $disable_modules) === false ? ''
															: 'style="display: none;"' ?>>
									<a class="menu-link  " href="<?php echo site_url('sales'); ?>">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/art/art006.svg-->
											<span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M22 19V17C22 16.4 21.6 16 21 16H8V3C8 2.4 7.6 2 7 2H5C4.4 2 4 2.4 4 3V19C4 19.6 4.4 20 5 20H21C21.6 20 22 19.6 22 19Z" fill="currentColor" />
													<path d="M20 5V21C20 21.6 19.6 22 19 22H17C16.4 22 16 21.6 16 21V8H8V4H19C19.6 4 20 4.4 20 5ZM3 8H4V4H3C2.4 4 2 4.4 2 5V7C2 7.6 2.4 8 3 8Z" fill="currentColor" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</span>
										<?php if (!isset($is_pos)) : ?>
											<span class="menu-title">
												<?php echo lang('pos') ?>
											</span>
										<?php endif; ?>
									</a>
								</div>

							<?php } ?>


							<?php if ($this->Employee->has_module_permission('items', $this->Employee->get_logged_in_employee_info()->person_id) && in_array('items', $quick_access)) { ?>
								<div class="menu-item">
									<a class="menu-link  <?= ($this->uri->segment(1) == 'items') ?  'active' : '' ?>" href="<?php echo site_url('items'); ?>">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/general/gen002.svg-->
											<span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M4.05424 15.1982C8.34524 7.76818 13.5782 3.26318 20.9282 2.01418C21.0729 1.98837 21.2216 1.99789 21.3618 2.04193C21.502 2.08597 21.6294 2.16323 21.7333 2.26712C21.8372 2.37101 21.9144 2.49846 21.9585 2.63863C22.0025 2.7788 22.012 2.92754 21.9862 3.07218C20.7372 10.4222 16.2322 15.6552 8.80224 19.9462L4.05424 15.1982ZM3.81924 17.3372L2.63324 20.4482C2.58427 20.5765 2.5735 20.7163 2.6022 20.8507C2.63091 20.9851 2.69788 21.1082 2.79503 21.2054C2.89218 21.3025 3.01536 21.3695 3.14972 21.3982C3.28408 21.4269 3.42387 21.4161 3.55224 21.3672L6.66524 20.1802L3.81924 17.3372ZM16.5002 5.99818C16.2036 5.99818 15.9136 6.08615 15.6669 6.25097C15.4202 6.41579 15.228 6.65006 15.1144 6.92415C15.0009 7.19824 14.9712 7.49984 15.0291 7.79081C15.0869 8.08178 15.2298 8.34906 15.4396 8.55884C15.6494 8.76862 15.9166 8.91148 16.2076 8.96935C16.4986 9.02723 16.8002 8.99753 17.0743 8.884C17.3484 8.77046 17.5826 8.5782 17.7474 8.33153C17.9123 8.08486 18.0002 7.79485 18.0002 7.49818C18.0002 7.10035 17.8422 6.71882 17.5609 6.43752C17.2796 6.15621 16.8981 5.99818 16.5002 5.99818Z" fill="currentColor" />
													<path d="M4.05423 15.1982L2.24723 13.3912C2.15505 13.299 2.08547 13.1867 2.04395 13.0632C2.00243 12.9396 1.9901 12.8081 2.00793 12.679C2.02575 12.5498 2.07325 12.4266 2.14669 12.3189C2.22013 12.2112 2.31752 12.1219 2.43123 12.0582L9.15323 8.28918C7.17353 10.3717 5.4607 12.6926 4.05423 15.1982ZM8.80023 19.9442L10.6072 21.7512C10.6994 21.8434 10.8117 21.9129 10.9352 21.9545C11.0588 21.996 11.1903 22.0083 11.3195 21.9905C11.4486 21.9727 11.5718 21.9252 11.6795 21.8517C11.7872 21.7783 11.8765 21.6809 11.9402 21.5672L15.7092 14.8442C13.6269 16.8245 11.3061 18.5377 8.80023 19.9442ZM7.04023 18.1832L12.5832 12.6402C12.7381 12.4759 12.8228 12.2577 12.8195 12.032C12.8161 11.8063 12.725 11.5907 12.5653 11.4311C12.4057 11.2714 12.1901 11.1803 11.9644 11.1769C11.7387 11.1736 11.5205 11.2583 11.3562 11.4132L5.81323 16.9562L7.04023 18.1832Z" fill="currentColor" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</span>
										<?php if (!isset($is_pos)) : ?>
											<span class="menu-title">
												<?php echo lang("module_items"); ?>
											</span>
										<?php endif; ?>
									</a>
								</div>

							<?php } ?>

							<?php if ($this->Employee->has_module_permission('receivings', $employee_id) && in_array('receivings', $quick_access)) { ?>
								<div class="menu-item">
									<a class="menu-link  <?= ($this->uri->segment(1) == 'receivings' && $this->uri->segment(2) != 'transfer') ?  'active' : '' ?>" href="<?php echo site_url('receivings'); ?>">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/abstract/abs027.svg-->
											<span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor" />
													<path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</span>
										<?php if (!isset($is_pos)) : ?>
											<span class="menu-title">
												<?php echo lang("receiving"); ?>
											</span>
										<?php endif; ?>
									</a>
								</div>

							<?php } ?>

							<?php if (check_allowed_module($allowed_modules->result(), 'customers')  && in_array('customers', $quick_access)) : ?>
								<!--begin:Menu item-->
								<?php if (module_access_check_view('invoices')) { ?>
									<div class="menu-item">
										<a class="menu-link  <?= ($this->uri->segment(1) == 'customers') ?  'active' : '' ?> " href="<?php echo site_url('customers'); ?>">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/communication/com013.svg-->
												<span class="svg-icon svg-icon-muted svg-icon-2x rotate-0"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor" />
														<rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor" />
													</svg>
												</span>
												<!--end::Svg Icon-->
											</span>
											<?php if (!isset($is_pos)) : ?>
												<span class="menu-title">
													<?php echo lang('customers') ?>
												</span>
											<?php endif; ?>
										</a>
									</div>

								<?php } ?>

							<?php endif; ?>


						<?php endif; ?>
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
	<div class="col-12" id="sales_section" style="display:none" >

	

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

						// Check if the drawer instance is already created
						if (!operationsbox_modal.drawerInstance) {
							// Create the drawer instance and attach it to the DOM element
							operationsbox_modal.drawerInstance = KTDrawer.getInstance(operationsbox_modal);
						}

						// Show the drawer
				operationsbox_modal.drawerInstance.show();
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
  const sidebarToggleElement = $('#kt_app_sidebar_toggle');
  const sidebarClass = 'pos-sidebar'; // Class to toggle on sidebar elements

  // Retrieve stored toggle state from localStorage (default to inactive)
  let isSidebarActive = localStorage.getItem('sidebarState') === 'active';

 

  // Apply initial toggle based on localStorage
  sidebarToggleElement.toggleClass('active', isSidebarActive);
//   $(`.${sidebarClass}`).fadeToggle(isSidebarActive); // Use class selector with dot
if(!isSidebarActive){
	$(`.${sidebarClass}`).show();
  }else{
	$(`.${sidebarClass}`).hide();
  }
  // Handle click event on toggle element
  sidebarToggleElement.click(function() {
    isSidebarActive = !isSidebarActive; // Toggle active state

    // Update localStorage
    localStorage.setItem('sidebarState', isSidebarActive ? 'active' : 'inactive');

    // Toggle classes based on updated state
    $(this).toggleClass('active');
    $(`.${sidebarClass}`).fadeToggle();
  });
});
</script>