<?php 

$this->load->view("partial/offline_header"); ?>
<div id="network-status">You are offline</div>
<div class="modal fade look-up-receipt" id="print_modal" role="dialog" aria-labelledby="lookUpReceipt"
    aria-hidden="true">
    <div class="modal-dialog customer-recent-sales">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label=<?php echo json_encode(lang('close')); ?>><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="lookUpReceipt"><?php echo lang('Receipt'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <div id="print_receipt_holder" style="display: none;">

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div id="sales_page_holder">

</div>
<div class=" register d-flex" id="main-container">

    <!--begin::View component-->
    <div id="kt_drawer_example_basic" class="bg-white drawer drawer-end" data-kt-drawer="true"
        data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_drawer_example_basic_button"
        data-kt-drawer-close="#kt_drawer_example_basic_close" data-kt-drawer-width="500px"
        style="width: 500px !important;">
        <div class="card border-0 shadow-none rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4"
                id="kt_app_layout_builder_header"
                style="background-image:url('<?= base_url(); ?>assets/css_good/media/misc/pattern-4.jpg')">

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-white flex-column m-0">
                    Pos Builder
                    <small class="text-white opacity-50 fs-7 fw-semibold pt-1">
                        Get Ready To Customize Your Own Pos Interface </small>
                </h3>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1"
                        id="kt_app_layout_builder_close">
                        <i class="ki-duotone ki-cross-square fs-2"><span class="path1"></span><span
                                class="path2"></span></i> </button>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body position-relative" id="kt_app_layout_builder_body">
                <!--begin::Content-->
                <div id="kt_app_settings_content" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true"
                    data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_app_layout_builder_body"
                    data-kt-scroll-dependencies="#kt_app_layout_builder_header, #kt_app_layout_builder_footer"
                    data-kt-scroll-offset="5px" style="height: 213px;">

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
                                    <h4 class="fw-bold text-gray-900">Hide Categories</h4>
                                    <div class="fs-7 fw-semibold text-muted">
                                        Click On Toggle To Hide Show The Categories

                                    </div>
                                </div>
                                <!--end::Heading-->

                                <!--begin::Option-->
                                <div class="d-flex justify-content-end">
                                    <!--begin::Check-->
                                    <div
                                        class="form-check form-check-custom form-check-solid form-check-success form-switch">

                                        <input class="form-check-input w-45px h-30px" type="checkbox" value="true"
                                            name="hide_categories">
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
                                    <h4 class="fw-bold text-gray-900">Hide Search Bar</h4>
                                    <div class="fs-7 fw-semibold text-muted">
                                        Click On Toggle To Hide Show Search Bar

                                    </div>
                                </div>
                                <!--end::Heading-->

                                <!--begin::Option-->
                                <div class="d-flex justify-content-end">
                                    <!--begin::Check-->
                                    <div
                                        class="form-check form-check-custom form-check-solid form-check-success form-switch">

                                        <input class="form-check-input w-45px h-30px" type="checkbox" value="true"
                                            name="hide_search_bar">
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
                                    <h4 class="fw-bold text-gray-900">Hide Top Buttons</h4>
                                    <div class="fs-7 fw-semibold text-muted">
                                        Click On Toggle To Hide Show Top Buttons

                                    </div>
                                </div>
                                <!--end::Heading-->

                                <!--begin::Option-->
                                <div class="d-flex justify-content-end">
                                    <!--begin::Check-->
                                    <div
                                        class="form-check form-check-custom form-check-solid form-check-success form-switch">

                                        <input class="form-check-input w-45px h-30px" type="checkbox" value="true"
                                            name="hide_top_buttons">
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
                                    <h4 class="fw-bold text-gray-900">Hide Top Item Details</h4>
                                    <div class="fs-7 fw-semibold text-muted">
                                        Click On Toggle To Hide Show Item Details

                                    </div>
                                </div>
                                <!--end::Heading-->

                                <!--begin::Option-->
                                <div class="d-flex justify-content-end">
                                    <!--begin::Check-->
                                    <div
                                        class="form-check form-check-custom form-check-solid form-check-success form-switch">

                                        <input class="form-check-input w-45px h-30px" type="checkbox" value="true"
                                            name="hide_top_item_details">
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
                                    <h4 class="fw-bold text-gray-900">Hide Top Category Navigation</h4>
                                    <div class="fs-7 fw-semibold text-muted">
                                        Click On Toggle To Hide Show Category Navigation

                                    </div>
                                </div>
                                <!--end::Heading-->

                                <!--begin::Option-->
                                <div class="d-flex justify-content-end">
                                    <!--begin::Check-->
                                    <div
                                        class="form-check form-check-custom form-check-solid form-check-success form-switch">

                                        <input class="form-check-input w-45px h-30px" type="checkbox" value="true"
                                            name="hide_top_category_navigation">
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
    <div id="kt_drawer_example_basic" class="bg-white drawer drawer-end" data-kt-drawer="true"
        data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_drawer_payments_list"
        data-kt-drawer-close="#kt_drawer_example_basic_close" data-kt-drawer-width="500px"
        style="width: 500px !important;">
        <div class="card border-0 shadow-none rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4"
                id="kt_app_layout_builder_header"
                style="background-image:url('<?= base_url(); ?>assets/css_good/media/misc/pattern-4.jpg')">

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-white flex-column m-0">
                    Pos Builder
                    <small class="text-white opacity-50 fs-7 fw-semibold pt-1">
                        Get Ready To Customize Your Own Pos Interface </small>
                </h3>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1"
                        id="kt_app_layout_builder_close">
                        <i class="ki-duotone ki-cross-square fs-2"><span class="path1"></span><span
                                class="path2"></span></i> </button>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body position-relative" id="kt_app_layout_builder_body">
                <!--begin::Content-->
                <div id="kt_app_settings_content" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true"
                    data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_app_layout_builder_body"
                    data-kt-scroll-dependencies="#kt_app_layout_builder_header, #kt_app_layout_builder_footer"
                    data-kt-scroll-offset="5px" style="height: 213px;">

                    <ul class="list-group payments" id="payments">

                    </ul>
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
    <div id="kt_drawer_example_basic" class="bg-white drawer drawer-end" data-kt-drawer="true"
        data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_drawer_completed_sales"
        data-kt-drawer-close="#kt_drawer_example_basic_close" data-kt-drawer-width="900px"
        style="width: 900px !important;">
        <div class="card border-0 shadow-none rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4"
                id="kt_app_layout_builder_header"
                style="background-image:url('<?= base_url(); ?>assets/css_good/media/misc/pattern-4.jpg')">

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-white flex-column m-0">
                    Saved Sales
                    <small class="text-white opacity-50 fs-7 fw-semibold pt-1">
                        Get Ready To Customize Your Own Pos Interface </small>
                </h3>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1"
                        id="kt_app_layout_builder_close">
                        <i class="ki-duotone ki-cross-square fs-2"><span class="path1"></span><span
                                class="path2"></span></i> </button>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body position-relative" id="kt_app_layout_builder_body">
                <!--begin::Content-->
                <div id="kt_app_settings_content" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true"
                    data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_app_layout_builder_body"
                    data-kt-scroll-dependencies="#kt_app_layout_builder_header, #kt_app_layout_builder_footer"
                    data-kt-scroll-offset="5px" style="height: 213px;">

                    <div id="saved_sales_list">

                    </div>
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
    <div id="kt_drawer_example_basic" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#kt_drawer_suspend" data-kt-drawer-close="#kt_drawer_example_basic_close"
        data-kt-drawer-width="500px">
        <div class="card border-0 shadow-none rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4"
                id="kt_app_layout_builder_header"
                style="background-image:url('<?php echo base_url() ?>assets/css_good/media/misc/pattern-4.jpg')">

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-white flex-column m-0">
                    <?php echo lang("save_as") ?>

                </h3>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1"
                        id="kt_app_layout_builder_close">
                        <i class="ki-duotone ki-cross-square fs-2"><span class="path1"></span><span
                                class="path2"></span></i> </button>
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
                    <li><a href="#" class="work_order_status_button" data-suspend-index="<?php echo H($id); ?>"><i
                                class="ion-pause"></i> <?php echo H($status['name']); ?></a></li>
                    <?php } ?>
                    <?php } ?>
                </ul>
                <?php } else { ?>

                <ul>
                    <li><a href="#" id="layaway_sale_button" class="text-danger"><i class="ion-pause"></i>
                            <?php echo ($this->config->item('user_configured_layaway_name') ? $this->config->item('user_configured_layaway_name') : lang('layaway')); ?></a>
                    </li>
                    <li><a href="#" id="estimate_sale_button"><i class="ion-help-circled"></i>
                            <?php echo ($this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate')); ?></a>
                    </li>

                    <?php if (isset($additional_sale_types_suspended)) : foreach ($additional_sale_types_suspended as $sale_suspend_type) { ?>
                    <li><a href="#" class="additional_suspend_button"
                            data-suspend-index="<?php echo H($sale_suspend_type['id']); ?>"><i
                                class="ion-arrow-graph-up-right"></i> <?php echo H($sale_suspend_type['name']); ?></a>
                    </li>
                    <?php }
												endif;
											}  ?>

                </ul>

            </div>
        </div>
    </div>

    <div id="operationsbox_modal" class="bg-white hidden-print" data-kt-drawer="true" data-kt-drawer-activate="true"
        data-kt-drawer-close="#kt_drawer_example_basic_close" data-kt-drawer-width="700px">

        <div class="card border-0 shadow-none rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4"
                id="kt_app_layout_builder_header"
                style="background-image:url('<?php echo base_url() ?>assets/css_good/media/misc/pattern-4.jpg')">

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-white flex-column m-0">
                    <?= lang('advance_details') ?>
                </h3>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1"
                        id="kt_app_layout_builder_close">
                        x </button>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body position-relative" id="kt_app_layout_builder_body">
                <!--begin::Content-->
                <div id="kt_app_settings_content" class="position-relative gotodrawer scroll-y me-n5 px-5"
                    data-kt-scroll="true" data-kt-scroll-height="auto"
                    data-kt-scroll-wrappers="#kt_app_layout_builder_body"
                    data-kt-scroll-dependencies="#kt_app_layout_builder_header, #kt_app_layout_builder_footer"
                    data-kt-scroll-offset="5px">


                    <div class="card-body p-0">


                        <div class="row">
                            <!-- Tiers if its greater than 1 -->
                            <?php if (count($tiers) > 1) {  ?>
                            <div class="tier-group col-12  border border-dashed rounded min-w-125px h-50px py-5 px-4 ">
                                <a tabindex="-1" href="#"
                                    class="item-tier <?php $this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id) ? 'enable-click' : ''; ?>">
                                    <?php echo lang('sales_item_tiers'); ?>: <span
                                        class="selected-tier"><?php echo H($tiers[$selected_tier_id]); ?></span>
                                </a>
                                <?php if ($this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id)) {	?>
                                <div class="list-group item-tiers " style="display:none">
                                    <?php foreach ($tiers as $key => $value) { ?>
                                    <a tabindex="-1" href="#" data-value="<?php echo $key; ?>"
                                        class="list-group-item"><?php echo H($value); ?></a>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                            <?php  }  ?>

                            <!-- Tiers if its greater than 1 -->
                            <?php if ($this->config->item('select_sales_person_during_sale')) {  ?>
                            <div
                                class="tier-group col-12  border border-dashed rounded min-w-125px  h-50px	 py-5 px-4 ">
                                <a href="#"
                                    class="select-sales-person <?php $this->config->item('select_sales_person_during_sale') ? 'enable-click' : ''; ?>">
                                    <?php echo lang('sales_person'); ?>: <span class="selected-sales-person"></span>
                                </a>


                                <div class="list-group select-sales-persons" style="display:none">
                                    <?php foreach ($employees as $key => $employee) { ?>
                                    <a href="#" data-value="<?php echo $key; ?>"  data-permission_edit_sale_price="<?php if ($this->Employee->has_module_action_permission('sales', 'edit_sale_price', $key)) { echo "1"; }else{   echo "0"; }  ?>"
                                        class="list-group-item"><?php echo H($employee); ?></a>
                                    <?php } ?>
                                </div>

                            </div>
                            <?php  }  ?>
                            <?php if ($this->Employee->has_module_action_permission('sales', 'change_sale_date', $this->Employee->get_logged_in_employee_info()->person_id) && ($this->cart->get_previous_receipt_id() || $this->config->item('change_sale_date_for_new_sale'))) { ?>
                            <div
                                class="change-date form-check  col-12  border border-dashed rounded min-w-125px py-2  px-4">
                                <div class="d-flex justify-content-start">
                                    <?php echo form_checkbox(array(
										'name' => 'change_date_enable',
										'id' => 'change_date_enable',
										'value' => '1',
										'class' => 'form-check-input ml-0',
										'checked' => (bool) $change_date_enable
									));
									echo '<label class="form-check-label w-20" for="change_date_enable"><span></span>' . lang('change_date') . '</label>';

									?>

                                    <div id="change_cart_date_picker" class="w-62 date datepicker">
                                        <div class="input-group">
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
                            </div>

                            <?php } ?>

                            <div class="comment-block col-12  border border-dashed rounded min-w-125px py-1  px-4">
                                <?php
							foreach ($markup_predictions as $mark_payment_type => $mark_payment_data) {
								$amount = $mark_payment_data['amount'];
							?>
                                <div class="markup_predictions" id="<?php echo $mark_payment_data['id']; ?>"
                                    style="display: none;">
                                    <span
                                        style="font-size: 19px;font-weight: bold;"><?php echo lang('sales_total_with_markup'); ?>
                                    </span> <span
                                        style="color: #6FD64B;font-size: 24px;font-weight: bold;float: right"><?php echo to_currency($total + $amount) ?></span>
                                </div>
                                <?php
							}
							?>

                                <div class="d-flex justify-content-start">

                                    <?php echo form_label(lang('comments_receipt'), lang('comments_receipt'), array('class' => 'control-label w-25 mt-3 ')); ?>
                                    <?php 
                            echo form_input(array(
											'name' => "receipt-comment",
											'id' => "receipt-comment",
											'class' =>  ' form-control custom-fields customFields',
											'value' => ''
										)); ?>



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
                            <div
                                class="custom_field_block col-12 my-1  border border-dashed rounded min-w-125px  px-4 d-flex <?php echo "custom_field_${k}_value"; ?>">
                                <?php echo form_label($custom_field, "custom_field_${k}_value", array('class' => 'control-label w-25 mt-3 ' . $text_alert)); ?>

                                <?php if ($this->Sale->get_custom_field($k, 'type') == 'checkbox') { ?>
                                <div class="form-check">
                                    <?php echo form_checkbox("custom_field_${k}_value", '1', (bool) $cart->{"custom_field_${k}_value"}, "id='custom_field_${k}_value' class='custom-fields-checkbox customFields form-check-input' $required_text"); ?>
                                    <label class="form-check-label w-25"
                                        for="<?php echo "custom_field_${k}_value"; ?>"><span></span></label>
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
                                <div id="finish_sale_form"
                                    class="finish-sale col-6  border border-dashed rounded min-w-125px py-1  px-4 d-flex">
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
                                <div id="finish_sale_form"
                                    class="finish-sale col-6  border border-dashed rounded min-w-125px py-4 px-4 d-flex">
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
                                    <div class="btn-group btn-group-lg .btn-group-justified" role="group"
                                        aria-label="..." id="ebt-balance-buttons" style="display: none;">
                                        <a role="button"
                                            href="<?php echo site_url('sales/get_emv_ebt_balance/Foodstamp'); ?>"
                                            class="btn btn-default"><span class="icon ti-wallet"></span>
                                            <?php echo lang('sales_ebt_balance'); ?></a>
                                        <a role="button"
                                            href="<?php echo site_url('sales/get_emv_ebt_balance/Cash'); ?>"
                                            class="btn btn-default"><span class="icon ti-money"></span>
                                            <?php echo lang('sales_ebt_cash_balance'); ?></a>
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
                                <td class="sp_sale_id text-center">
                                    <?php echo anchor('sales/receipt/' . $unpaid_sale['sale_id'], ($this->config->item('sale_prefix') ? $this->config->item('sale_prefix') : 'POS') . ' ' . $unpaid_sale['sale_id'], array('target' => '_blank')); ?>
                                </td>
                                <td class="sp_date text-center">
                                    <?php echo date(get_date_format() . ' ' . get_time_format(), strtotime($unpaid_sale['sale_time'])); ?>
                                </td>
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
                                    <button type="submit"
                                        class="btn <?php echo $btn_class; ?> pay_store_account_sale"><?php echo isset($unpaid_sale['paid']) && $unpaid_sale['paid'] == TRUE  ? lang('remove_payment') : lang('pay'); ?></button>
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
    </div>

    <!-- need this div for change_sale </div> -->

    <div id="kt_drawer_example_basic" class="bg-white drawer drawer-end" data-kt-drawer="true"
        data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_drawer_goto"
        data-kt-drawer-close="#kt_drawer_example_basic_close" data-kt-drawer-width="500px"
        style="width: 500px !important;">
        <div class="card border-0 shadow-none rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4"
                id="kt_app_layout_builder_header"
                style="background-image:url('<?= base_url(); ?>assets/css_good/media/misc/pattern-4.jpg')">

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-white flex-column m-0">
                    Go To
                </h3>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1"
                        id="kt_app_layout_builder_close">
                        <i class="ki-duotone ki-cross-square fs-2"><span class="path1"></span><span
                                class="path2"></span></i> </button>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body position-relative" id="kt_app_layout_builder_body">
                <!--begin::Content-->
                <div id="kt_app_settings_content" class="position-relative gotodrawer scroll-y me-n5 pe-5"
                    data-kt-scroll="true" data-kt-scroll-height="auto"
                    data-kt-scroll-wrappers="#kt_app_layout_builder_body"
                    data-kt-scroll-dependencies="#kt_app_layout_builder_header, #kt_app_layout_builder_footer"
                    data-kt-scroll-offset="5px">

                    <!--begin::Form-->
                    <form class="form" method="POST" id="kt_app_layout_builder_form" action="#">
                        <input type="hidden" id="kt_app_layout_builder_action" name="layout-builder[action]">

                        <!--begin::Card body-->
                        <div class="card-body p-0">
                            <!--begin::template-->



                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-info text-inverse-bg-info">
                                        <i class="ion-card text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/new_giftcard" target="_self" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="Sell GiftCard">Sell GiftCard</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/new_giftcard" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="Sell GiftCard"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-warning text-inverse-bg-warning">
                                        <i class="ion-ios-list-outline text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/suspended" target="_self" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="Suspended Sales">Suspended Sales</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/suspended" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="Suspended Sales"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-bg-danger">
                                        <i class="ion-ios-list-outline text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/work_orders" target="_self" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="Work Orders">Work Orders</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/work_orders" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="Work Orders"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-dark text-inverse-bg-dark">
                                        <i class="ion-ios-list-outline text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>deliveries" target="_self" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="Delivery Orders">Delivery Orders</a>
                                    </div>
                                    <a href="<?= base_url(); ?>deliveries" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="Delivery Orders"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-secondary text-inverse-bg-secondary">
                                        <i class="ion-search text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>reports/sales_generator" target="_self" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="Search Sales">Search Sales</a>
                                    </div>
                                    <a href="<?= base_url(); ?>reports/sales_generator" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="Search Sales"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-primary text-inverse-bg-primary">
                                        <i class="ion-toggle-filled text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/change_mode/store_account_payment/1"
                                            target="_self" id="" class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="Store Account Payment">Store Account Payment</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/change_mode/store_account_payment/1" target="_self"
                                        id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="Store Account Payment"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-info text-inverse-bg-info">
                                        <i class="ion-bag text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/batch_sale/" target="_self" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold none suspended_sales_btn"
                                            title="Batch Sale">Batch Sale</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/batch_sale/" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px none suspended_sales_btn"
                                        title="Batch Sale"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-warning text-inverse-bg-warning">
                                        <i class="ion-document text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/receipt/83" target="_blank" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold look-up-receipt"
                                            title="Show Last Sale Receipt">Show Last Sale Receipt</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/receipt/83" target="_blank" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px look-up-receipt"
                                        title="Show Last Sale Receipt"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-dark text-inverse-bg-dark">
                                        <i class="ion-ios-monitor-outline text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/customer_display/1" target="_blank"
                                            id="customer_facing_display_link"
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="Customer Facing Display">Customer Facing Display</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/customer_display/1" target="_blank"
                                        id="customer_facing_display_link"
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="Customer Facing Display"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-secondary text-inverse-bg-secondary">
                                        <i class="ion-android-open text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/open_drawer" target="_blank" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold pop_open_cash_drawer"
                                            title="Pop Open Cash Drawer">Pop Open Cash Drawer</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/open_drawer" target="_blank" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px pop_open_cash_drawer"
                                        title="Pop Open Cash Drawer"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-primary text-inverse-bg-primary">
                                        <i class="ion-cash text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/register_add_subtract/add/common_cash"
                                            target="_self" id="" class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="Add Cash To Register">Add Cash To Register</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/register_add_subtract/add/common_cash"
                                        target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="Add Cash To Register"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-warning text-inverse-bg-warning">
                                        <i class="ion-log-out text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/register_add_subtract/subtract/common_cash"
                                            target="_self" id="" class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="Remove Cash From Register">Remove Cash From Register</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/register_add_subtract/subtract/common_cash"
                                        target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="Remove Cash From Register"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-bg-danger">
                                        <i class="ion-close-circled text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/closeregister?continue=closeoutreceipt"
                                            target="_self" id="" class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="Close Register">Close Register</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/closeregister?continue=closeoutreceipt"
                                        target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="Close Register"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-secondary text-inverse-bg-secondary">
                                        <i class="ion-ios-settings-strong text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/enable_test_mode" target="_self" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="Enable Test Mode">Enable Test Mode</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/enable_test_mode" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="Enable Test Mode"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-info text-inverse-bg-info">
                                        <i class="ion-wrench text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/custom_fields" target="_self" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="Custom Field Config">Custom Field Config</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/custom_fields" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="Custom Field Config"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-primary text-inverse-bg-primary">
                                        <i class="ion-document text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="#look-up-receipt" target="_self" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold look-up-receipt"
                                            title="Lookup Receipt">Lookup Receipt</a>
                                    </div>
                                    <a href="#look-up-receipt" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px look-up-receipt"
                                        title="Lookup Receipt"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-info text-inverse-bg-info">
                                        <i class="ion-document text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/receipts?date=2024-07-09&amp;location_id=1"
                                            target="_blank" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold look-up-receipt"
                                            title="Show All Receipts For Today">Show All Receipts For Today</a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/receipts?date=2024-07-09&amp;location_id=1"
                                        target="_blank" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px look-up-receipt"
                                        title="Show All Receipts For Today"><span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span></a>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-1"></div>





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
        <div id="drag-handle"
            style="cursor: ew-resize;width: 7px;position: relative;background-color: #0009;height: 100%;float: right;z-index: 99;">
        </div>
        <div class="d-flex">
            <div id="kt_app_sidebar_toggle" class="w-100px text-center pt-2  text-light cursor-pointer bg-black rotate"
                data-kt-rotate="true">

                <span class="svg-icon svg-icon-muted svg-icon-2x rotate-180" style="margin: 0 auto;"><svg width="24"
                        height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14.4 11H2.99999C2.39999 11 1.99999 11.4 1.99999 12C1.99999 12.6 2.39999 13 2.99999 13H14.4V11Z"
                            fill="currentColor"></path>
                        <path
                            d="M17.7762 13.2561C18.4572 12.5572 18.4572 11.4429 17.7762 10.7439L13.623 6.48107C13.1221 5.96697 12.25 6.32158 12.25 7.03934V16.9607C12.25 17.6785 13.1221 18.0331 13.623 17.519L17.7762 13.2561Z"
                            fill="currentColor"></path>
                        <rect opacity="0.5" width="2" height="16" rx="1" transform="matrix(-1 0 0 1 22 4)"
                            fill="currentColor"></rect>
                    </svg>
                </span>
                <!--end::Svg Icon-->
                <!--end::Svg Icon-->
            </div>
            <div class="register-box register-items-form w-100 d-flex justify-content-space-between h-70px">
                <a tabindex="-1" href="#" class="dismissfullscreen hidden"><i class="ion-close-circled"></i></a>
                <div id="itemForm" class="item-form bg-light-100 w-60">
                    <!-- Item adding form -->

                    <form action="<?= base_url(); ?>sales/add" id="add_item_form" class="form-inline" autocomplete="off"
                        method="post" accept-charset="utf-8">

                        <div class="input-group input-group-mobile contacts">
                            <span class="input-group-text">
                                <a href="<?= base_url(); ?>items/view/-1?redirect=sales/index/1&amp;progression=1"
                                    class="none add-new-item" title="New Item" id="new-item-mobile" tabindex="-1"><i
                                        class="icon ti-pencil-alt"></i> <span class="register-btn-text">New
                                        Item</span></a> </span>
                            <div class="input-group-text register-mode sale-mode dropdown">
                                <a href="<?= base_url(); ?>#" class="none active" tabindex="-1" title="Sale"
                                    id="select-mode-1" data-target="#" data-toggle="dropdown" aria-haspopup="true"
                                    role="button" aria-expanded="false"><i class="icon ti-shopping-cart"></i> <span
                                        class="register-btn-text mode_text">Sale</span></a>
                                <ul class="dropdown-menu sales-dropdown">
                                    <li><a tabindex="-1" href="#" data-mode="return" class="change-mode">Return</a></li>
                                    <li><a tabindex="-1" href="#" data-mode="estimate" class="change-mode">Estimate</a>
                                    </li>
                                    <li><a tabindex="-1" href="#" data-mode="store_account_payment"
                                            class="change-mode">Store Account Payment</a></li>
                                </ul>
                            </div>

                            <span class="input-group-text grid-buttons ">
                                <a href="<?= base_url(); ?>#" class="none show-grid hidden" tabindex="-1"
                                    title="Show Grid"><i class="icon ti-layout"></i> <span
                                        class="register-btn-text">Show Grid</span></a> <a href="<?= base_url(); ?>#"
                                    class="none hide-grid" tabindex="-1" title="Hide Grid"><i
                                        class="icon ti-layout"></i> <span class="register-btn-text">Hide Grid</span></a>
                            </span>
                        </div>

                        <div class="input-group contacts register-input-group d-flex">

                            <!-- Css Loader  -->
                            <div class="spinner" id="ajax-loader" style="display:none">
                                <div class="rect1"></div>
                                <div class="rect2"></div>
                                <div class="rect3"></div>
                            </div>

                            <div class="input-group-text register-mode sale-mode dropdown">
                                <a href="<?= base_url(); ?>#"
                                    class="none active text-light  text-hover-primary mode_text" tabindex="-1"
                                    title="Sale" id="select-mode-2" data-target="#" data-toggle="dropdown"
                                    aria-haspopup="true" role="button" aria-expanded="false"><i
                                        class="icon ti-shopping-cart"></i>Sale</a>
                                <ul class="dropdown-menu sales-dropdown">
                                    <li><a tabindex="-1" href="#" data-mode="return" class="change-mode">Return</a></li>
                                    <li><a tabindex="-1" href="#" data-mode="estimate" class="change-mode">Estimate</a>
                                    </li>
                                    <li><a tabindex="-1" href="#" data-mode="store_account_payment"
                                            class="change-mode">Store Account Payment</a></li>
                                </ul>
                            </div>
                            <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>


                            <input type="text" id="item" name="item"
                                class="add-item-input   w-50  pull-left keyboardTop  ui-autocomplete-input"
                                placeholder=<?php echo json_encode(lang('start_typing_item_name')); ?>
                                data-title=<?php echo json_encode(lang('item_name')); ?>>

                            <input type="hidden" name="secondary_supplier_id" id="secondary_supplier_id">
                            <input type="hidden" name="default_supplier_id" id="default_supplier_id">


                            <span class="input-group-text d-none grid-buttons  ">
                                <a href="<?= base_url(); ?>#" class="none show-grid hidden" tabindex="-1"
                                    title="Show Grid"><i class="icon ti-layout"></i> Show Grid</a> <a
                                    href="<?= base_url(); ?>#" class="none hide-grid" tabindex="-1" title="Hide Grid"><i
                                        class="icon ti-layout"></i> Hide Grid</a> </span>
                            <span class="input-group-text  grid-buttons ">
                                <div class="card-toolbar">
                                    <!--begin::Menu-->
                                    <button id="category_selection_btn"
                                        class="btn h-20px w-70px btn-icon btn-color-light-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">
                                        Categories </button>
                                    <div id="grid_selection"
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                        data-kt-menu="true" style="">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Select Option
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="javascript:void(0);" class="btn active menu-link px-3"
                                                id="by_category">Categories</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="javascript:void(0);" class=" menu-link px-3" id="by_tag">Tags</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="javascript:void(0);" class=" menu-link px-3"
                                                id="by_supplier">Suppliers</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="javascript:void(0);" class=" menu-link px-3"
                                                id="by_favorite">Favorite</a>
                                        </div>
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
                    <div class="d-flex flex-column bg-primary p-3 flex-center w-75px h-50px me-1 "
                        id="kt_drawer_suspend" class="menu-icon w-100 " data-bs-custom-class="tooltip-inverse"
                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click"
                        data-bs-trigger="hover" data-bs-original-title="Metronic Builder" data-kt-initialized="1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
                        <span class="svg-icon  svg-icon-3x mt-3">
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/general/gen056.svg-->
                            <svg class="pos-top-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.0077 19.2901L12.9293 17.5311C12.3487 17.1993 11.6407 17.1796 11.0426 17.4787L6.89443 19.5528C5.56462 20.2177 4 19.2507 4 17.7639V5C4 3.89543 4.89543 3 6 3H17C18.1046 3 19 3.89543 19 5V17.5536C19 19.0893 17.341 20.052 16.0077 19.2901Z"
                                    fill="currentColor" />
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <!--end::Svg Icon-->
                        <div class=" py-2">
                            <?= lang('save_as') ?> </div>
                    </div>
                    <div class="d-flex flex-column bg-primary  p-3 flex-center w-75px h-50px me-1 "
                        id="cancel_sale_button">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
                        <span class="svg-icon svg-icon-3x mt-3">
                            <svg class="pos-top-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="4" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                <path
                                    d="M5.86875 11.6927L7.62435 10.2297C8.09457 9.83785 8.12683 9.12683 7.69401 8.69401C7.3043 8.3043 6.67836 8.28591 6.26643 8.65206L3.34084 11.2526C2.89332 11.6504 2.89332 12.3496 3.34084 12.7474L6.26643 15.3479C6.67836 15.7141 7.3043 15.6957 7.69401 15.306C8.12683 14.8732 8.09458 14.1621 7.62435 13.7703L5.86875 12.3073C5.67684 12.1474 5.67684 11.8526 5.86875 11.6927Z"
                                    fill="currentColor" />
                                <path
                                    d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z"
                                    fill="currentColor" />
                            </svg>
                            <!--end::Svg Icon-->


                        </span>
                        <!--end::Svg Icon-->
                        <div class=" py-2">
                            <?php echo $this->cart->get_previous_receipt_id() ||  $this->cart->suspended ? lang('back') : lang('clear'); ?>
                        </div>
                    </div>

                    <?php } ?>
                    <?php } ?>


                    <?php
                        if (($this->cart->get_previous_receipt_id() || $this->cart->suspended) && $this->Employee->has_module_action_permission('sales', 'delete_sale', $this->Employee->get_logged_in_employee_info()->person_id)) {
                        ?>

                    <div class="d-flex flex-column bg-primary  p-3 flex-center w-75px h-50px me-1 "
                        id="delete_sale_button">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
                        <span class="svg-icon svg-icon-3x text-danger svg-icon-light mt-3">

                            <svg class="pos-top-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                    fill="currentColor" />
                                <path opacity="0.5"
                                    d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                    fill="currentColor" />
                                <path opacity="0.5"
                                    d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                    fill="currentColor" />
                            </svg>
                            <!--end::Svg Icon-->


                        </span>
                        <!--end::Svg Icon-->

                        <div class=" py-2"><?php echo lang('void'); ?></div>
                    </div>


                    <?php
                        }
                        ?>
                    <div class="d-flex flex-column bg-primary p-3 flex-center w-75px h-50px ddd " id="advance_details">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
                        <span class="svg-icon svg-icon-3x mt-3">
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/general/gen045.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg class="pos-top-icon" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                        fill="currentColor" />
                                    <rect x="11" y="17" width="7" height="2" rx="1" transform="rotate(-90 11 17)"
                                        fill="currentColor" />
                                    <rect x="11" y="9" width="2" height="2" rx="1" transform="rotate(-90 11 9)"
                                        fill="currentColor" />
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
        </div>
        <div class="d-flex">

            <?php
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;


		?>
            <div class="w-100px bg-black pos-sidebar">
                <!--begin::Sidebar menu-->
                <div class="app-sidebar-menu app-sidebar-menu-arrow hover-scroll-overlay-y my-5 my-lg-5 px-3  pos-menu"
                    id="kt_app_sidebar_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto"
                    data-kt-scroll-dependencies="#kt_app_sidebar_toolbar, #kt_app_sidebar_footer"
                    data-kt-scroll-offset="0" style="height: 490px;">
                    <!--begin::Menu-->
                    <div class="menu menu-column menu-sub-indention menu-active-bg fw-semibold     "
                        id="#kt_sidebar_menu" data-kt-menu="true">
                        <!--begin:Menu item-->



                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                            class="menu-item <?php echo $this->uri->segment(1) == 'home' && $this->uri->segment(2) != 'payvantage'  ? 'here show' : ''; ?>  ">



                            <span class=" menu-link ">
                                <span id="kt_drawer_goto" class="menu-icon w-100 "
                                    data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip"
                                    data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover"
                                    data-bs-original-title="Metronic Builder" data-kt-initialized="1">
                                    <span class="svg-icon svg-icon-muted svg-icon-2x  w-100"><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M17 6H3C2.4 6 2 6.4 2 7V21C2 21.6 2.4 22 3 22H17C17.6 22 18 21.6 18 21V7C18 6.4 17.6 6 17 6Z"
                                                fill="currentColor" />
                                            <path
                                                d="M17.8 4.79999L9.3 13.3C8.9 13.7 8.9 14.3 9.3 14.7C9.5 14.9 9.80001 15 10 15C10.2 15 10.5 14.9 10.7 14.7L19.2 6.20001L17.8 4.79999Z"
                                                fill="currentColor" />
                                            <path opacity="0.3" d="M22 9.09998V3C22 2.4 21.6 2 21 2H14.9L22 9.09998Z"
                                                fill="currentColor" />
                                        </svg>
                                        <span class="menu-title w-100"><?= lang('go_to'); ?></span>
                                    </span>
                                </span>
                            </span>




                            <span class=" menu-link ">
                                <span id="kt_drawer_example_basic_button" class="menu-icon w-100 "
                                    data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip"
                                    data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover"
                                    data-bs-original-title="Metronic Builder" data-kt-initialized="1">
                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/text/txt001.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2x  w-100"><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z"
                                                fill="currentColor" />
                                            <path opacity="0.3"
                                                d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z"
                                                fill="currentColor" />
                                        </svg>
                                        <span class="menu-title w-100"><?= lang('pos_builder'); ?></span>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                            <div class="menu-item">
                                <a class=" menu-link " href="<?php echo site_url('sales/sales_list'); ?>">
                                    <span class="menu-icon  w-100 ">
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/arrows/arr043.svg-->
                                        <span class="svg-icon svg-icon-muted svg-icon-2x w-100 "><svg width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                    d="M21 22H12C11.4 22 11 21.6 11 21V3C11 2.4 11.4 2 12 2H21C21.6 2 22 2.4 22 3V21C22 21.6 21.6 22 21 22Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M19 11H6.60001V13H19C19.6 13 20 12.6 20 12C20 11.4 19.6 11 19 11Z"
                                                    fill="currentColor" />
                                                <path opacity="0.3"
                                                    d="M6.6 17L2.3 12.7C1.9 12.3 1.9 11.7 2.3 11.3L6.6 7V17Z"
                                                    fill="currentColor" />
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
                                <span class="fw-bold menu-heading fs-7"
                                    style="color: var(--bs-app-light-sidebar-logo-icon-custom-color);font-family: Inter, sans-serif;font-style: italic;font-weight: bold;"
                                    onclick="show_quick_access()">&nbsp; &nbsp;
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
                                    <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M22 19V17C22 16.4 21.6 16 21 16H8V3C8 2.4 7.6 2 7 2H5C4.4 2 4 2.4 4 3V19C4 19.6 4.4 20 5 20H21C21.6 20 22 19.6 22 19Z"
                                                fill="currentColor" />
                                            <path
                                                d="M20 5V21C20 21.6 19.6 22 19 22H17C16.4 22 16 21.6 16 21V8H8V4H19C19.6 4 20 4.4 20 5ZM3 8H4V4H3C2.4 4 2 4.4 2 5V7C2 7.6 2.4 8 3 8Z"
                                                fill="currentColor" />
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
                            <a class="menu-link  <?= ($this->uri->segment(1) == 'items') ?  'active' : '' ?>"
                                href="<?php echo site_url('items'); ?>">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/general/gen002.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M4.05424 15.1982C8.34524 7.76818 13.5782 3.26318 20.9282 2.01418C21.0729 1.98837 21.2216 1.99789 21.3618 2.04193C21.502 2.08597 21.6294 2.16323 21.7333 2.26712C21.8372 2.37101 21.9144 2.49846 21.9585 2.63863C22.0025 2.7788 22.012 2.92754 21.9862 3.07218C20.7372 10.4222 16.2322 15.6552 8.80224 19.9462L4.05424 15.1982ZM3.81924 17.3372L2.63324 20.4482C2.58427 20.5765 2.5735 20.7163 2.6022 20.8507C2.63091 20.9851 2.69788 21.1082 2.79503 21.2054C2.89218 21.3025 3.01536 21.3695 3.14972 21.3982C3.28408 21.4269 3.42387 21.4161 3.55224 21.3672L6.66524 20.1802L3.81924 17.3372ZM16.5002 5.99818C16.2036 5.99818 15.9136 6.08615 15.6669 6.25097C15.4202 6.41579 15.228 6.65006 15.1144 6.92415C15.0009 7.19824 14.9712 7.49984 15.0291 7.79081C15.0869 8.08178 15.2298 8.34906 15.4396 8.55884C15.6494 8.76862 15.9166 8.91148 16.2076 8.96935C16.4986 9.02723 16.8002 8.99753 17.0743 8.884C17.3484 8.77046 17.5826 8.5782 17.7474 8.33153C17.9123 8.08486 18.0002 7.79485 18.0002 7.49818C18.0002 7.10035 17.8422 6.71882 17.5609 6.43752C17.2796 6.15621 16.8981 5.99818 16.5002 5.99818Z"
                                                fill="currentColor" />
                                            <path
                                                d="M4.05423 15.1982L2.24723 13.3912C2.15505 13.299 2.08547 13.1867 2.04395 13.0632C2.00243 12.9396 1.9901 12.8081 2.00793 12.679C2.02575 12.5498 2.07325 12.4266 2.14669 12.3189C2.22013 12.2112 2.31752 12.1219 2.43123 12.0582L9.15323 8.28918C7.17353 10.3717 5.4607 12.6926 4.05423 15.1982ZM8.80023 19.9442L10.6072 21.7512C10.6994 21.8434 10.8117 21.9129 10.9352 21.9545C11.0588 21.996 11.1903 22.0083 11.3195 21.9905C11.4486 21.9727 11.5718 21.9252 11.6795 21.8517C11.7872 21.7783 11.8765 21.6809 11.9402 21.5672L15.7092 14.8442C13.6269 16.8245 11.3061 18.5377 8.80023 19.9442ZM7.04023 18.1832L12.5832 12.6402C12.7381 12.4759 12.8228 12.2577 12.8195 12.032C12.8161 11.8063 12.725 11.5907 12.5653 11.4311C12.4057 11.2714 12.1901 11.1803 11.9644 11.1769C11.7387 11.1736 11.5205 11.2583 11.3562 11.4132L5.81323 16.9562L7.04023 18.1832Z"
                                                fill="currentColor" />
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
                            <a class="menu-link  <?= ($this->uri->segment(1) == 'receivings' && $this->uri->segment(2) != 'transfer') ?  'active' : '' ?>"
                                href="<?php echo site_url('receivings'); ?>">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/abstract/abs027.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z"
                                                fill="currentColor" />
                                            <path
                                                d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z"
                                                fill="currentColor" />
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
                            <a class="menu-link  <?= ($this->uri->segment(1) == 'customers') ?  'active' : '' ?> "
                                href="<?php echo site_url('customers'); ?>">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/communication/com013.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2x rotate-0"><svg width="24"
                                            height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z"
                                                fill="currentColor" />
                                            <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4"
                                                fill="currentColor" />
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
                <div id="sale-grid-big-wrapper" class="clearfix register ">
                    <div class="clearfix" style="" id="category_item_selection_wrapper">
                        <div id="grid_breadcrumbs"
                            class="py-1 pos-bg-dark h-45px p-5 rounded-1 d-flex align-items-center flex-wrap"> </div>

                        <div class="horizontal-scroll h-120px ">
                            <ul id="category_item_selection"
                                class="scrollable-list register-grid nav nav-pills nav-pills-custom  p-0 mt-1 m-0">

                            </ul>

                        </div>

                    </div>
                </div>


                <!-- Register Items. @contains : Items table -->

                <div class="row" id="category_item_selection_wrapper_new">



                    <!--end::Card widget 14-->

                </div>

            </div>
        </div>



    </div>
    <!-- /.Col-lg-8 @end of left Column -->

    <!-- col-lg-4 @start of right Column -->
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" id="sales_section">
        <style>
        #category_item_selection_wrapper_new {
            height: calc(100vh - 45vh);
            overflow-y: scroll;
        }

        #reloadMessage {
            display: none;
            /* Add more styling as needed */
        }
        </style>
        <script id="item-template" type="text/x-handlebars-template">
            {{#each this}}
						<tbody  class="fw-bold text-gray-600" data-line="{{@index}}">
                   
							<tr class="register-item-details">


								<td class="text-center  fs-6">



									<span
										class="toggle_rows btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"
										style="position:relative">
										<!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
										<span class="svg-icon svg-icon-3 m-0 toggle-off">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
												xmlns="http://www.w3.org/2000/svg">
												<rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1"
													transform="rotate(-90 11 18)" fill="currentColor"></rect>
												<rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>
											</svg>
										</span>
										<!--end::Svg Icon-->
										<!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
										<span class="svg-icon svg-icon-3 m-0 toggle-on">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
												xmlns="http://www.w3.org/2000/svg">
												<rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</span> &nbsp;
								</td>

								<td class="fs-6">

									<a tabindex="-1"
										href="<?= base_url(); ?>/home/view_item_modal/{{item_id}}?redirect=sales"
										data-target="#kt_drawer_general" data-target-title="View Item"
										data-target-width="xl" class="register-item-name text-gray-800 text-hover-primary "
										data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse"
										data-bs-placement="top" title="Box Master Sandwich - Original">{{name}}</a>
								</td>
								<td class="text-center fs-6">
									<a href="#" id="price_{{@index}}" class="xeditable xeditable-price editable editable-click"
										data-validate-number="true" data-type="text" data-value="{{price}}" data-pk="1"
										data-name="unit_price" data-url="<?= base_url(); ?>/sales/edit_item/0"
										data-title="Price">{{currency}} {{price}}</a>


								</td>
								<td class="text-center fs-6">
								<button type="button"  onclick="inc_de_qty('{{@index}}', -1)" class="btn w-25px h-25px  btn-icon rounded-circle btn-light"><i class="bi bi-dash fs-1"></i></button> 
									<a href="#" id="quantity_{{@index}}" class="xeditable edit-quantity editable editable-click"
										data-type="text" data-validate-number="true" data-pk="{{@index}}" data-name="quantity"
										data-url="<?= base_url(); ?>/sales/edit_item/{{@index}}"
										data-title="Quantity">
									
										 {{qty}}
		
										</a><button type="button" onclick="inc_de_qty('{{@index}}', 1)" class="btn w-25px h-25px  btn-icon rounded-circle btn-light"> <i class="bi bi-plus fs-1"></i></button>
								</td>

								<td class="text-center fs-6" style="padding-right:10px">

									<a href="#" id="total_{{@index}}" class="xeditable editable editable-click" data-type="text"
										data-validate-number="true" data-pk="1" data-name="total" data-value="{{multiply price qty}}"
										data-url="<?= base_url(); ?>/sales/edit_line_total/{{@index}}"
										data-title="Total">{{currency}} {{multiply price qty}}</a>


									<a href="<?= base_url(); ?>/sales/delete_item/{{@index}}"
										class="delete-item pull-right" tabindex="-1" data-cart-index="{{@index}}" data-id="{{@index}}"><i
											class="icon ion-android-cancel"></i></a>

								</td>
							</tr>
							<tr class="register-item-bottom collapse">
								<td>&nbsp;</td>
								<td colspan="5">



									<div class="row">
										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">Discount Percentage</div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"> <a
													href="#" id="discount_0" class="xeditable editable editable-click"
													data-type="text" data-validate-number="true" data-pk="1"
													data-name="discount" data-value="0"
													data-url="<?= base_url(); ?>/sales/edit_item/0"
													data-title="Discount Percentage">0%</a>

											</div>
										</div>


										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">Supplier</div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><a
													href="#" id="supplier_0" data-name="supplier" data-type="select"
													data-pk="1"
													data-url="<?= base_url(); ?>/sales/edit_item_supplier/0"
													data-title="Supplier" class="editable editable-click">Cafe Store inc</a>
											</div>
										</div>

									


										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">Description</div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
												None </div>
										</div>

										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">Category</div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">FOR
												ONE</div>
										</div>

										<!-- Serial Number if exists -->

										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">
												SKU/UPC/EAN/ISBN </div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
												None </div>
										</div>
										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">Stock</div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">0
											</div>
										</div>




									</div>
								</td>
							</tr>
						
						</tbody>
						{{/each}}
</script>



        <script id="sale-template" type="text/x-handlebars-template">


            <span
                    class="list-group-item global-discount-group border border-light border-dashed rounded min-w-125px h-80px py-3 px-4  ">




                    <div class="side-heading text-center fw-semibold fs-6 text-dark-400">
                        Discount ({{currency}}) <i class="fonticon-content-marketing" id="discount_details_reload"></i>
                    </div>

                    <div class="fs-1 fw-bold counted text-center">

                    {{total_discount}} </div>
                </span>

				
                <span class="svg-icon   svg-icon-primary svg-icon-2x">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>
                    </svg>
                </span>


    

                <div
                    class="sub-total list-group-item bg-light  border border-light border-dashed rounded min-w-125px h-80px py-3 px-4 ">
                    <div class="fw-semibold fs-6 text-dark-400">Sub Total ({{currency}}) <a
                            href="<?= base_url(); ?>/sales/edit_taxes/" class="" id="edit_taxes"
                            data-target="#kt_drawer_general" data-target-title="Edit Taxes" data-target-width="lg"><i
                                class="icon ti-pencil-alt"></i></a>
                        <i class="fonticon-content-marketing" data-dismiss="true" data-placement="top" data-html="true"
                            title="" id="tax-paid-popover" data-original-title="Tax"></i>
                    </div>
                    <div class="fs-1 fw-bold counted">



                        <a href="#" id="sub_total" class="xeditable xeditable-price editable editable-click"
                            data-validate-number="true" data-type="text" data-value="{{subtotal}}" data-pk="1" data-name="subtotal"
                            data-url="<?= base_url(); ?>/sales/edit_subtotal" data-title="Sub Total"> {{subtotal}}</a>



                    </div>


                </div>

                <span class="svg-icon   svg-icon-primary svg-icon-2x">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                            transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                    </svg>
                </span>
                <div class="d-none" id="list_tax">
                    <div class="list-group-item  border border-dashed rounded min-w-125px h-80px py-3 px-4 me-3  mb-3">
                        <div class="fw-semibold fs-6 text-dark-400">
                            <a href="<?= base_url(); ?>/sales/delete_tax/5%25%20VAT%20Rate%201"
                                class="delete-tax remove"><i class="icon ion-android-cancel"></i></a>
                            5% VAT Rate 1:
                        </div>
                        <div class="fs-1 fw-bold counted">
                            0 </div>
                    </div>



                </div>
             


                <div class="amount-block border border-light border-dashed rounded min-w-125px h-80px py-3 px-4 ">
                    <div class="tax amount">
                        <div class="side-heading text-center fw-semibold fs-6 text-dark-400">
                            Tax ({{currency}}) </div>
                        <div class="amount total-tax fs-1 fw-bold counted" data-speed="1000" data-currency="OMR"
                            data-decimals="0">
                            {{tax}}
                        </div>
                    </div>
                </div>
                <span class="svg-icon   mt-3 svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/arrows/arr080.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg class="pos-top-icon" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5"
                                d="M9.63433 11.4343L5.45001 7.25C5.0358 6.83579 5.0358 6.16421 5.45001 5.75C5.86423 5.33579 6.5358 5.33579 6.95001 5.75L12.4929 11.2929C12.8834 11.6834 12.8834 12.3166 12.4929 12.7071L6.95001 18.25C6.5358 18.6642 5.86423 18.6642 5.45001 18.25C5.0358 17.8358 5.0358 17.1642 5.45001 16.75L9.63433 12.5657C9.94675 12.2533 9.94675 11.7467 9.63433 11.4343Z"
                                fill="currentColor"></path>
                            <path
                                d="M15.6343 11.4343L11.45 7.25C11.0358 6.83579 11.0358 6.16421 11.45 5.75C11.8642 5.33579 12.5358 5.33579 12.95 5.75L18.4929 11.2929C18.8834 11.6834 18.8834 12.3166 18.4929 12.7071L12.95 18.25C12.5358 18.6642 11.8642 18.6642 11.45 18.25C11.0358 17.8358 11.0358 17.1642 11.45 16.75L15.6343 12.5657C15.9467 12.2533 15.9467 11.7467 15.6343 11.4343Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>

                <div class="amount-block  min-w-125px h-80px py-3 px-4 bg-primary ">
                    <div class="total amount">
                        <div class="side-heading text-center fw-semibold fs-6 text-dark-400">
                            Total ({{currency}})
                        </div>
                        <div class="amount total-amount fs-1 fw-bold counted" data-speed="1000" data-currency="OMR"
                            data-decimals="0">
                            {{total_amount}}
                        </div>
                    </div>
                </div>


                <span class="svg-icon   mt-3 svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/arrows/arr080.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg class="pos-top-icon" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5"
                                d="M9.63433 11.4343L5.45001 7.25C5.0358 6.83579 5.0358 6.16421 5.45001 5.75C5.86423 5.33579 6.5358 5.33579 6.95001 5.75L12.4929 11.2929C12.8834 11.6834 12.8834 12.3166 12.4929 12.7071L6.95001 18.25C6.5358 18.6642 5.86423 18.6642 5.45001 18.25C5.0358 17.8358 5.0358 17.1642 5.45001 16.75L9.63433 12.5657C9.94675 12.2533 9.94675 11.7467 9.63433 11.4343Z"
                                fill="currentColor"></path>
                            <path
                                d="M15.6343 11.4343L11.45 7.25C11.0358 6.83579 11.0358 6.16421 11.45 5.75C11.8642 5.33579 12.5358 5.33579 12.95 5.75L18.4929 11.2929C18.8834 11.6834 18.8834 12.3166 18.4929 12.7071L12.95 18.25C12.5358 18.6642 11.8642 18.6642 11.45 18.25C11.0358 17.8358 11.0358 17.1642 11.45 16.75L15.6343 12.5657C15.9467 12.2533 15.9467 11.7467 15.6343 11.4343Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <div class="amount-block  min-w-125px h-80px py-3 px-4 bg-due  me-3">
                    <div class="total amount-due">
                        <div class="side-heading text-center fw-semibold fs-6 text-dark-400">
                            Amount Due ({{currency}})
                        </div>
                        <div class="amount fs-1 fw-bold counted">
                           {{amount_due}} </div>
                    </div>
                </div>
                <!-- ./amount block -->

                <!-- Payment Applied -->

                <!-- Add Payment -->
                
</script>

        <script>
        function amount_tendered_input_changed() {

            if ($("#payment_types").val() == "Giftcard") {
                $('#finish_sale').removeClass('hidden');
                $('#add_payment_button').addClass('hidden');
            } else if ($("#payment_types").val() == "Points") {
                $('#finish_sale').addClass('hidden');
                $('#add_payment_button').removeClass('hidden');
            } else {

                if (
                    $('#amount_tendered').val() > 0
                ) {
                    console.log("yes amojnt", $("#payment_types").val(), $('#amount_tendered').val());
                    $('#finish_sale').addClass('hidden');
                    $('#add_payment_button').removeClass('hidden');


                } else {

                    $('#finish_sale').removeClass('hidden');
                    $('#add_payment_button').addClass('hidden');





                }
            }

        }
        </script>




        <!-- col-lg-4 @start of right Column -->

        <div id="discountbox_modal_reload_data" style="display:none">

            <div class="card border-0 shadow-none rounded-0 w-100">
                <!--begin::Card header-->
                <div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4"
                    id="kt_app_layout_builder_header"
                    style="background-image:url('<?= base_url(); ?>assets/css_good/media/misc/pattern-4.jpg')">

                    <!--begin::Card title-->
                    <h3 class="card-title fs-3 fw-bold text-white flex-column m-0">
                        Discount Details </h3>
                    <!--end::Card title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1"
                            id="kt_app_layout_builder_close">
                            x </button>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body position-relative" id="kt_app_layout_builder_body">
                    <!--begin::Content-->
                    <div id="kt_app_settings_content" class="position-relative gotodrawer scroll-y me-n5 pe-5"
                        data-kt-scroll="true" data-kt-scroll-height="auto"
                        data-kt-scroll-wrappers="#kt_app_layout_builder_body"
                        data-kt-scroll-dependencies="#kt_app_layout_builder_header, #kt_app_layout_builder_footer"
                        data-kt-scroll-offset="5px">


                        <div class="card-body p-0">
                            <div class="row p-5">

                                <div class="mb-10">
                                    <label for="exampleFormControlInput1" class=" form-label">Discount %: </label>
                                    <input type="number" id="discount_all_percent" value=""
                                        class="form-control form-control-solid discount_all_percent">
                                </div>

                                <div class="mb-10">
                                    <label for="exampleFormControlInput1" class=" form-label">Discount Fixed: <span
                                            id="TEST"></span></label>
                                    <input type="number" id="discount_all_flat" value=""
                                        class="form-control form-control-solid discount_all_flat">
                                </div>



                                <button type="button"
                                    class="btn btn-primary w-100px update_discount_details">Update</button>

                                <div class="separator separator-dashed my-4"></div>


                                <div class="d-flex justify-content-between flex-column">
                                    <!--begin::Table-->
                                    <div class="fw-bold fs-3 text-gray-800 mb-8 mt-3"><?= lang('Discount_details');  ?>
                                    </div>
                                    <div class="table-responsive border-bottom mb-9">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">


                                            <tbody class="fw-semibold text-gray-600">
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">


                                                            <!--begin::Title-->
                                                            <div class="ms-5">
                                                                <div class="fw-bold">
                                                                    <?= lang('Discount_from_items');  ?></div>

                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                    </td>

                                                    <td class="text-end" id="Discount_from_items">

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">


                                                            <!--begin::Title-->
                                                            <div class="ms-5">
                                                                <div class="fw-bold"><?= lang('Flat_discount');  ?>
                                                                </div>
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                    </td>

                                                    <td class="text-end" id="Flat_discount">

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="1" class="fs-3 text-gray-900 fw-bold text-end">
                                                        <?= lang('Total_discount');  ?>
                                                    </td>
                                                    <td class="text-gray-900 fs-3 fw-bolder text-end"
                                                        id="total_discount_detail">

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="tab-content" id="myTabContent">

            <div class="register-box register-right " id="select_customer_form">

                <!-- Sale Top Buttons  -->


                <!-- If customer is added to the sale -->

                <div class="customer-form d-flex flex-wrap">

                    <!-- if the customer is not set , show customer adding form -->
                    <form action="<?= base_url(); ?>sales/select_customer" autocomplete="off"
                        class="form-inline w-100 mb-2" method="post" accept-charset="utf-8">
                        <div class="input-group contacts d-flex">
                            <span class="input-group-text">
                                <a href="<?= base_url(); ?>customers/quick_modal/-1/1" class="none "
                                    title="New Customer" id="new-customer" data-target="#kt_drawer_general"
                                    data-target-title="New Customer" data-target-width="xl" tabindex="-1"><i
                                        class="ion-person-add"></i></a> </span>
                            <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>


                            <input type="text" id="customer" name="customer"
                                class="add-customer-input w-75 keyboardLeft ui-autocomplete-input"
                                data-title=<?php echo json_encode(lang('customer_name')); ?>
                                placeholder=<?php echo json_encode(lang('sales_start_typing_customer_name')); ?>>


                        </div>
                    </form>


                </div>


            </div>


            <div class="register-box register-right" id="selected_customer_form">

                <!-- Sale Top Buttons  -->


                <!-- If customer is added to the sale -->
                <div class="d-flex flex-wrap flex-sm-nowrap p-2 pb-0">

                    <div class="ribbon ribbon-triangle ribbon-top-end border-danger">

                        <div class="ribbon-icon mt-n8 me-n6"><a href="#" id="remove_customer">

                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/communication/com009.svg-->
                                <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" style="
														height: 1.5rem !important;
														width: 1.5rem !important;
														color: black;
													">
                                        <path opacity="0.3"
                                            d="M5.78001 21.115L3.28001 21.949C3.10897 22.0059 2.92548 22.0141 2.75004 21.9727C2.57461 21.9312 2.41416 21.8418 2.28669 21.7144C2.15923 21.5869 2.06975 21.4264 2.0283 21.251C1.98685 21.0755 1.99507 20.892 2.05201 20.7209L2.886 18.2209L7.22801 13.879L10.128 16.774L5.78001 21.115Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M21.7 8.08899L15.911 2.30005C15.8161 2.2049 15.7033 2.12939 15.5792 2.07788C15.455 2.02637 15.3219 1.99988 15.1875 1.99988C15.0531 1.99988 14.92 2.02637 14.7958 2.07788C14.6717 2.12939 14.5589 2.2049 14.464 2.30005L13.74 3.02295C13.548 3.21498 13.4402 3.4754 13.4402 3.74695C13.4402 4.01849 13.548 4.27892 13.74 4.47095L14.464 5.19397L11.303 8.35498C10.1615 7.80702 8.87825 7.62639 7.62985 7.83789C6.38145 8.04939 5.2293 8.64265 4.332 9.53601C4.14026 9.72817 4.03256 9.98855 4.03256 10.26C4.03256 10.5315 4.14026 10.7918 4.332 10.984L13.016 19.667C13.208 19.859 13.4684 19.9668 13.74 19.9668C14.0115 19.9668 14.272 19.859 14.464 19.667C15.3575 18.77 15.9509 17.618 16.1624 16.3698C16.374 15.1215 16.1932 13.8383 15.645 12.697L18.806 9.53601L19.529 10.26C19.721 10.452 19.9814 10.5598 20.253 10.5598C20.5245 10.5598 20.785 10.452 20.977 10.26L21.7 9.53601C21.7952 9.44108 21.8706 9.32825 21.9221 9.2041C21.9737 9.07995 22.0002 8.94691 22.0002 8.8125C22.0002 8.67809 21.9737 8.54505 21.9221 8.4209C21.8706 8.29675 21.7952 8.18392 21.7 8.08899Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>
                        </div>

                        <!--end::Ribbon icon-->
                    </div>



                    <!--begin: Pic-->
                    <div class="me-1 mb-1 w-50px">
                        <div class="symbol symbol-50px  symbol-fixed position-relative">
                            <img src="<?= base_url(); ?>assets/img/user.png"
                                onerror="this.onerror=null; this.src='<?= base_url(); ?>assets/css_good/media/avatars/blank.png';"
                                alt="image">


                        </div>
                    </div>
                    <!--end::Pic-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                            <!--begin::User-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center">
                                    <a href="#" class="text-gray-900 text-hover-primary fs-6 fw-bold me-1"> </a><a
                                        href="<?= base_url(); ?>sales/customer_recent_sales/40" data-toggle="modal"
                                        data-target="#myModal"
                                        class="text-gray-700 text-hover-primary fs-5 fw-bold me-1 name"
                                        id="customer_name"></a>


                                </div>
                                <!--end::Name-->
                                <!--begin::Info-->






                                <!-- Start: ++++++++++++++++++++++++++++++++++++++++++++++++++ Customer added info +++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

                                <!-- Customer Balance -->
                                <div class="d-flex flex-wrap fw-semibold fs-6 pe-2">
                                    <a href="#"
                                        class="d-flex align-items-center text-gray-500 fw-normal fs-7 text-hover-primary me-5 text-success balance">
                                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                    d="M20 18H4C3.4 18 3 17.6 3 17V7C3 6.4 3.4 6 4 6H20C20.6 6 21 6.4 21 7V17C21 17.6 20.6 18 20 18ZM12 8C10.3 8 9 9.8 9 12C9 14.2 10.3 16 12 16C13.7 16 15 14.2 15 12C15 9.8 13.7 8 12 8Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M18 6H20C20.6 6 21 6.4 21 7V9C19.3 9 18 7.7 18 6ZM6 6H4C3.4 6 3 6.4 3 7V9C4.7 9 6 7.7 6 6ZM21 17V15C19.3 15 18 16.3 18 18H20C20.6 18 21 17.6 21 17ZM3 15V17C3 17.6 3.4 18 4 18H6C6 16.3 4.7 15 3 15Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span>

                                        <!--end::Svg Icon-->

                                        <span id="customer_balance"></span>
                                    </a>
                                    <!-- End Customer Balance -->

                                    <!-- Customer Loyalty Points -->





                                    <div class="loyalty">
                                        <?php if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'simple') { ?>
                                        <span 
                                            class="d-flex align-items-center text-gray-500 fw-normal fs-7 text-hover-primary me-5 text-danger sales_until_discount_main">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z"
                                                        fill="currentColor"></path>
                                                    <path opacity="0.3"
                                                        d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <div class="fs-6 fw-bold counted  sales_until_discount"
                                                data-kt-countup="true" data-kt-countup-value="4500"
                                                data-kt-countup-prefix="$" data-kt-initialized="1">
                                                <span id="sud_val"></span>
                                                <span title="  <?php echo lang('redeem') ?>" id="redeem_discount" style="display: none;">[<?php echo lang('redeem') ?>]</span>
                                                <span title="  <?php echo lang('unredeem') ?>" id="unredeem_discount" style="display: none;">[<?php echo lang('unredeem') ?>]</span>
                                            </div>

                                        </span>

                                        <?php } ?>

                                        <?php if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced') { ?>
                                        <span title="  <?php echo lang('points') ?>"
                                            class="d-flex align-items-center text-gray-500 fw-normal fs-7 text-hover-primary me-5 text-danger points_main">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z"
                                                        fill="currentColor"></path>
                                                    <path opacity="0.3"
                                                        d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <div class="fs-6 fw-bold counted  points" data-kt-countup="true"
                                                data-kt-countup-value="4500" data-kt-countup-prefix="$"
                                                data-kt-initialized="1">

                                            </div>

                                        </span>

                                        <?php } ?>

                                    </div>

                                    <a href="#" id="internal_notes"
                                        class="xeditable-comment edit-internal_notes d-flex align-items-center text-gray-500 text-hover-primary fw-normal fs-7  editable-click"
                                        data-type="text" data-validate-number="false" data-pk="1"
                                        data-name="internal_notes"
                                       
                                        data-placement="bottom" data-value="t">
                                        <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                    d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span> <span id="customer_internal_notes"></span>
                                    </a>







                                </div>


                            </div>
                            <!--end::User-->
                            <!--begin::Actions-->
                            <div class="d-flex my-4 me-15">
                                <div id="popover-content" class="d-none">
                                    <!--begin::ShareArea-->
                                    <div class="d-flex flex-wrap justify-content-around fw-semibold fs-6 mb-4 pe-2">


                                        <div class="symbol round w-50px h-50px text-center p-4  bg-success me-2">
                                            <i class="fa-solid fa-square-phone fs-2rem text-light"></i>
                                        </div>


                                        <div class="symbol round w-50px h-50px text-center p-4  bg-danger me-2">

                                            <i class="fa-regular fa-envelope fs-2rem text-light  "
                                                id="toggle_email_receipt"></i>
                                        </div>




                                    </div>





                                    <!--End::ShareArea-->
                                </div>




                                <!--begin::Menu-->
                                <button type="button" class="btn btn-sm btn-icon btn-primary btn-active-light-primary"
                                    data-kt-menu-trigger="click" data-kt-menu-overflow="true"
                                    data-kt-menu-placement="top-end">
                                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/general/gen052.svg-->
                                    <span class="svg-icon svg-icon-white svg-icon-muted svg-icon-2hx"><svg width="24"
                                            height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                            <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                            <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                    data-kt-menu="true" style="">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions
                                        </div>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <div class="separator mb-3 opacity-75"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->

                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->

                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">


                                        <a href="<?= base_url(); ?>sales/view_delivery_modal/" class="menu-link px-3 "
                                            id="open_delivery_modal" data-toggle="modal" data-target="#myModal"> <i
                                                class="ion-android-car"></i>Delivery</a>

                                    </div>





                                    <div class="menu-item px-3">
                                        <a href="<?= base_url(); ?>customers/redeem_series/40" id="redeem_series"
                                            class="menu-link px-3" title="Redeem Series"><i
                                                class="ion-ios-compose-outline"></i> Redeem Series</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="<?= base_url(); ?>customers/pay_now/40" id="pay_now"
                                            class="menu-link px-3" title="Pay Now"><i
                                                class="ion-ios-compose-outline"></i> Pay Now</a>
                                    </div>

                                    <div class="menu-item px-3">



                                        <a href="<?= base_url(); ?>customers/quick_modal/40/1" id="edit_customer"
                                            data-target="#kt_drawer_general" data-target-title="New Customer"
                                            data-target-width="xl" class="menu-link px-3" title="Update Customer"><i
                                                class="ion-ios-compose-outline"></i> Update Customer</a>
                                    </div>

                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->

                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <div class="separator mt-3 opacity-75"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content px-3 py-3">




                                            <a target="_blank"
                                                href="<?= base_url(); ?>reports/generate/specific_customer?report_type=complex&amp;start_date=2023-07-11&amp;start_date_formatted=07/11/2023 12:00 am&amp;end_date=2024-07-11%2023:59:59&amp;end_date_formatted=07/11/2024 11:59 pm&amp;customer_id=40&amp;sale_type=all&amp;export_excel=0"
                                                class="btn btn-success btn-sm px-4">View Report
                                            </a>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->
                                </div>

                                <!--begin::Menu 2-->

                                <!--end::Menu 2-->
                                <!--end::Menu-->




                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Info-->
                </div>
                <!-- Customer Badge when customer is added -->

                <div class="customer-action-buttons  btn-group btn-group-justified  d-flex justify-content-center mb-2">







                    <input type="checkbox" name="email_receipt" value="1" id="email_receipt"
                        class="email_receipt_checkbox hidden">
                    <input type="checkbox" name="sms_receipt" value="1" id="sms_receipt"
                        class="sms_receipt_checkbox hidden">
                    <input type="checkbox" name="delivery" value="1" id="delivery" class="delivery_checkbox hidden">













                </div>


            </div>



            <div class="register-box register-items  itemboxnew">


                <div class="register-items-holder">




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
                    <div class="spinner" id="grid-loader2" style="display: none;">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                    </div>
                    <table id="register"
                        class="table table-striped align-middle table-row-dashed fs-6 gy-3 dataTable no-footer">
                        <thead>
                            <tr
                                class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 bg-light-primary pos-bg-dark">
                                <th class=" py-1 min-w-50px text-center  text-light "><a href="javascript:void(0);"
                                        id="sale_details_expand_collapse" class="expand">+</a><span id="total_items"
                                        class=" symbol-badge badge    badge-circle badge-warning  ">1</span></th>
                                <th class=" py-1 item_sort_able  text-light item_name_heading ">Item Name</th>
                                <th class=" py-1 item_sort_able min-w-150px text-center text-light sales_price ">Price
                                </th>
                                <th class=" py-1 item_sort_able sales_quantity  text-light"><span
                                        class=" symbol-badge badge   badge-circle badge-warning  "
                                        id="total_items_qty">1</span>Quantity</th>
                                <th class=" py-1 item_sort_able min-w-150px text-center sales_total text-light">Total
                                </th>
                            </tr>
                        </thead>

                    </table>

                </div>

                <!-- End of Store Account Payment Mode -->

                <!-- /.Register Items first pan end here -->
                <div class="register-box register-summary paper-cut  pos_footer d-flex flex-wrap bg-light-100"
                    id="pos_footer">


                    <span
                        class="list-group-item global-discount-group border border-light border-dashed rounded min-w-125px h-80px py-3 px-4  ">




                        <div class="side-heading text-center fw-semibold fs-6 text-dark-400">
                            Discount (OMR) <i class="fonticon-content-marketing" id="discount_details_reload"></i>
                        </div>

                        <div class="fs-1 fw-bold counted text-center" id="total_discount">

                            0 </div>
                    </span>


                    <span class="svg-icon   svg-icon-primary svg-icon-2x">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>
                        </svg>
                    </span>




                    <div
                        class="sub-total list-group-item bg-light  border border-light border-dashed rounded min-w-125px h-80px py-3 px-4 ">
                        <div class="fw-semibold fs-6 text-dark-400">Sub Total (OMR)


                        </div>
                        <div class="fs-1 fw-bold counted">



                            <a href="#" id="sub_total" class=" editable-click" data-validate-number="true"
                                data-type="text" data-value="5" data-pk="1" data-title="Sub Total"> 0</a>



                        </div>


                    </div>

                    <span class="svg-icon   svg-icon-primary svg-icon-2x">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                        </svg>
                    </span>
                    <div class="d-none" id="list_tax">
                        <div
                            class="list-group-item  border border-dashed rounded min-w-125px h-80px py-3 px-4 me-3  mb-3">
                            <div class="fw-semibold fs-6 text-dark-400">
                                <a href="<?= base_url(); ?>/sales/delete_tax/5%25%20VAT%20Rate%201"
                                    class="delete-tax remove"><i class="icon ion-android-cancel"></i></a>
                                5% VAT Rate 1:
                            </div>
                            <div class="fs-1 fw-bold counted">
                                0 </div>
                        </div>



                    </div>



                    <div class="amount-block border border-light border-dashed rounded min-w-125px h-80px py-3 px-4 ">
                        <div class="tax amount">
                            <div class="side-heading text-center fw-semibold fs-6 text-dark-400">
                                Tax (OMR) <a href="#" class="" id="edit_taxes_gen" data-id="-1"
                                    data-target="#kt_drawer_general" data-target-title="Edit Taxes"
                                    data-target-width="lg"><i class="fonticon-content-marketing"></i></a>
                            </div>
                            <div class="amount total-tax fs-1 fw-bold counted" data-speed="1000" data-currency="OMR"
                                data-decimals="0" id="taxes">
                                0
                            </div>
                        </div>
                    </div>
                    <span class="svg-icon   mt-3 svg-icon-primary svg-icon-2x">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/arrows/arr080.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg class="pos-top-icon" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.5"
                                    d="M9.63433 11.4343L5.45001 7.25C5.0358 6.83579 5.0358 6.16421 5.45001 5.75C5.86423 5.33579 6.5358 5.33579 6.95001 5.75L12.4929 11.2929C12.8834 11.6834 12.8834 12.3166 12.4929 12.7071L6.95001 18.25C6.5358 18.6642 5.86423 18.6642 5.45001 18.25C5.0358 17.8358 5.0358 17.1642 5.45001 16.75L9.63433 12.5657C9.94675 12.2533 9.94675 11.7467 9.63433 11.4343Z"
                                    fill="currentColor"></path>
                                <path
                                    d="M15.6343 11.4343L11.45 7.25C11.0358 6.83579 11.0358 6.16421 11.45 5.75C11.8642 5.33579 12.5358 5.33579 12.95 5.75L18.4929 11.2929C18.8834 11.6834 18.8834 12.3166 18.4929 12.7071L12.95 18.25C12.5358 18.6642 11.8642 18.6642 11.45 18.25C11.0358 17.8358 11.0358 17.1642 11.45 16.75L15.6343 12.5657C15.9467 12.2533 15.9467 11.7467 15.6343 11.4343Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>

                    <div class="amount-block  min-w-125px h-80px py-3 px-4 bg-primary ">
                        <div class="total amount">
                            <div class="side-heading text-center fw-semibold fs-6 text-dark-400">
                                Total (OMR)
                            </div>
                            <div class="amount total-amount fs-1 fw-bold counted" data-speed="1000" data-currency="OMR"
                                data-decimals="0" id="total">

                            </div>
                        </div>
                    </div>


                    <span class="svg-icon   mt-3 svg-icon-primary svg-icon-2x">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/arrows/arr080.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg class="pos-top-icon" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.5"
                                    d="M9.63433 11.4343L5.45001 7.25C5.0358 6.83579 5.0358 6.16421 5.45001 5.75C5.86423 5.33579 6.5358 5.33579 6.95001 5.75L12.4929 11.2929C12.8834 11.6834 12.8834 12.3166 12.4929 12.7071L6.95001 18.25C6.5358 18.6642 5.86423 18.6642 5.45001 18.25C5.0358 17.8358 5.0358 17.1642 5.45001 16.75L9.63433 12.5657C9.94675 12.2533 9.94675 11.7467 9.63433 11.4343Z"
                                    fill="currentColor"></path>
                                <path
                                    d="M15.6343 11.4343L11.45 7.25C11.0358 6.83579 11.0358 6.16421 11.45 5.75C11.8642 5.33579 12.5358 5.33579 12.95 5.75L18.4929 11.2929C18.8834 11.6834 18.8834 12.3166 18.4929 12.7071L12.95 18.25C12.5358 18.6642 11.8642 18.6642 11.45 18.25C11.0358 17.8358 11.0358 17.1642 11.45 16.75L15.6343 12.5657C15.9467 12.2533 15.9467 11.7467 15.6343 11.4343Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <div class="amount-block  min-w-125px h-80px py-3 px-4 bg-due  me-3">
                        <div class="total amount-due">
                            <div class="side-heading text-center fw-semibold fs-6 text-dark-400">
                                Amount Due (OMR)


                                <i class="fonticon-content-marketing" title="" id="kt_drawer_payments_list"></i>



                            </div>
                            <div class="amount fs-1 fw-bold counted" id="amount_due">
                                0 </div>
                        </div>
                    </div>
                    <!-- ./amount block -->

                    <!-- Payment Applied -->

                    <!-- Add Payment -->
                    <div class=" add-payment border border-light border-dashed rounded min-w-125px py-3 px-4">
                        <!-- Check Work Order Permission -->
                        <div class="row">
                            <div id="create_invoice_holder" class="create_invoice_holder col-md-6 hidden">
                                <div class="text-left">
                                    <label for="create_invoice" class="control-label wide">Create Invoice</label> <input
                                        type="checkbox" name="create_invoice" value="1" id="create_invoice">
                                    <label for="create_invoice"
                                        style="padding-left: 10px; margin-top:0px;"><span></span></label>
                                </div>
                            </div>
                        </div>
                        <form action="#" id="add_payment_form" autocomplete="off" method="post" accept-charset="utf-8">

                            <div class="input-group add-payment-form">





                                <div class="input-group-text register-mode sale-mode dropup">


                                    <a tabindex="-1" href="#"
                                        class="none active text-light  text-hover-primary payment_option_selected"
                                        title="Sales Sale" id="select-mode-3" data-target="#" data-toggle="dropdown"
                                        aria-haspopup="true" role="button" aria-expanded="false"><i
                                            class="fa fa-money-bill"></i>
                                        Cash </a>



                                    <ul class="dropdown-menu sales-dropdown payment_dropdown">
                                        <?php foreach ($payment_options as $key => $value) {
										
										$active_payment =  ($default_payment_type == $value) ? "selected" : "";
									?>
                                        <li> <a tabindex="-1" href="#"
                                                class="btn btn-pay select-payment <?php echo $active_payment; ?>"
                                                data-payment="<?php echo H($value); ?>"> <i
                                                    class="fa fa-money-bill"></i>
                                                <?php echo H($value); ?>
                                            </a> </li>
                                        <?php } ?>



                                    </ul>
                                </div>

                                <input type="hidden" name="payment_types" id="payment_types" value="Cash">
                                <input type="input" name="amount_tendered" value="2" id="amount_tendered"
                                    class="form-control" data-title="Payment Amount" placeholder="Enter Cash Amount">

                                <span class="input-group-text">
                                    <a href="#" class="" id="add_payment_button">Add Payment</a>
                                </span>
                                <span class="input-group-text" id="finish_sale">

                                    <a href="#" class="text-white" id="finish_sale_button">Complete Sale</a>
                                </span>

                                <!-- <div class="form-group">
					<label for="exampleInputPassword1"></label>
					<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
					</div> -->
                            </div>

                        </form>
                    </div>

                </div>


                <!-- End of pos footer -->
            </div>
















        </div>
    </div>
</div>
</div>


<script id="sale-receipt-template" type="text/x-handlebars-template">
    <div class="row manage-table  card p-5 receipt_small" id="receipt_wrapper">
		<div class="col-md-12 text-center hidden-print">
			<div class="row">
				<button class="btn btn-primary btn-lg" id="print_button" onclick="window.print()" > <?php echo lang('print','',array(),TRUE); ?> </button>		
			</div>
				<br />
				<br />
			<div class="row">
				<button class="btn btn-primary btn-lg" id="print_button" onclick="display_sale_register()" > <?php echo lang('sales_new_sale','',array(),TRUE); ?> </button>		
			</div>
				<br />
		</div>
		<div class="col-md-12" id="receipt_wrapper_inner">
			<div class="card ">
				<div class="card-body panel-pad">
				    <div class="row">
				        <!-- from address-->
				        <div class="col-md-4 col-sm-4 col-xs-12">
				            <ul class="list-unstyled invoice-address" style="margin-bottom:2px;">
	            				<li class="company-title"><?php echo H($this->config->item('company')); ?></li>
				                <li class="nl2br"><?php echo H($this->Location->get_info_for_key('address')); ?></li>
				                <li><?php echo H($this->Location->get_info_for_key('phone')); ?></li>
								{{#if customer.customer_name}}
									<li><?php echo lang('customer_name')?>: {{ customer.customer_name}}</li>
								{{/if}}
				            </ul>
				        </div>
					</div>
				    <!-- invoice heading-->
			
		    <div class="invoice-table">
		        <div class="row">
		            <div class="col-md-12 col-sm-12 col-xs-12">
		                <div class="invoice-head item-name"><?php echo lang('item_name','',array(),TRUE); ?></div>
		            </div>
		            <div class="col-md-3 col-sm-3 col-xs-3 gift_receipt_element">
		                <div class="invoice-head text-right item-price"><?php echo lang('price','',array(),TRUE);?></div>
		            </div>
		            <div class="col-md-3 col-sm-3 col-xs-3">
		                <div class="invoice-head text-right item-qty"><?php echo lang('quantity','',array(),TRUE); ?></div>
		            </div>

		            <div class="col-md-3 col-sm-3 col-xs-3 gift_receipt_element">
		                <div class="invoice-head text-right item-discount"><?php echo lang('discount_percent','',array(),TRUE); ?></div>
		            </div>
           
		            <div class="col-md-3 col-sm-3 col-xs-3">
		                <div class="invoice-head pull-right item-total gift_receipt_element"><?php echo lang('total','',array(),TRUE).($this->config->item('show_tax_per_item_on_receipt') ? '/'.lang('tax','',array(),TRUE) : ''); ?></div>
		            </div>
		
		        </div>
				    </div>
			
				{{#each items}}
		
		   	 		<div class="invoice-table-content">
				        <div class="row receipt-row-item-holder">
				            
							
							<div class="col-md-12 col-sm-12 col-xs-12">
				                <div class="invoice-content invoice-con">
				                    <div class="invoice-content-heading">
										{{this.name}}
				                    </div>
										
									    {{#each this.modifiers}}
										<div class="invoice-desc">
											   {{this.modifier_name}} > {{this.modifier_item_name}} {{ to_currency_no_money this.unit_price}}</li>
										   </div>
									     {{/each}}
										
									
									
			                    	<div class="invoice-desc">
										{{this.selected_variation_name}}
									</div>
			                 		
									<div class="invoice-desc">
	 									{{this.description}}
					                 </div>
								</div>
								
				            </div>
							
				            <div class="col-md-3 col-sm-3 col-xs-3 gift_receipt_element">
				                <div class="invoice-content item-price text-right">							
									{{ this.price }}
								</div>
				            </div>
				            <div class="col-md-3 col-sm-3 col-xs-3 ">
				                <div class="invoice-content item-qty text-right">
									{{ this.quantity }}
								</div>
				            </div>
				      		<div class="col-md-3 col-sm-3 col-xs-3 gift_receipt_element">
				              <div class="invoice-content item-discount text-right">
				              	
								{{ this.discount_percent }}
				              </div>
							  
				            </div>
							
							<div class="col-md-3 col-sm-3 col-xs-3 gift_receipt_element">      
						         <div class="invoice-content item-total pull-right">
									{{ this.line_total }}
								</div>
							 </div>
				    	 </div>					
				    </div>
					{{/each}}
		
				    <div class="invoice-footer gift_receipt_element">
					
				
				        <div class="row">
				            <div class="col-md-offset-4 col-sm-offset-4 col-md-6 col-sm-6 col-xs-8">
				                <div class="invoice-footer-heading"><?php echo lang('sub_total','',array(),TRUE); ?></div>
				            </div>
						
				            <div class="col-md-2 col-sm-2 col-xs-4">
				                <div class="invoice-footer-value">
					
									{{subtotal}}		
									
								</div>
				            </div>
		       
				        </div>
					
				
							<div class="row">
					            <div class="col-md-offset-4 col-sm-offset-4 col-md-6 col-sm-6 col-xs-8">
					                <div class="invoice-footer-heading"><?php echo lang('sale_tax','',array(),TRUE); ?></div>
					            </div>
					            <div class="col-md-2 col-sm-2 col-xs-4">
					                <div class="invoice-footer-value">
						
										{{total_tax}}		
										
									</div>
					            </div>
					        </div>
				
                            <div class="row">
					            <div class="col-md-offset-4 col-sm-offset-4 col-md-6 col-sm-6 col-xs-8">
					                <div class="invoice-footer-heading"><?php echo lang('general_tax','',array(),TRUE); ?></div>
					            </div>
					            <div class="col-md-2 col-sm-2 col-xs-4">
					                <div class="invoice-footer-value">
						
										{{gen_tax}}		
										
									</div>
					            </div>
					        </div>
			
				        <div class="row">
				            <div class="col-md-offset-4 col-sm-offset-4 col-md-6 col-sm-6 col-xs-8">
				                <div class="invoice-footer-heading"><?php echo lang('total','',array(),TRUE); ?></div>
				            </div>
				            <div class="col-md-2 col-sm-2 col-xs-4">
				                <div class="invoice-footer-value invoice-total"  style="font-size: 150%;font-weight: bold;;">
									{{ total}}
								</div>
				            </div>
				        </div> 
			
				        <div class="row">
					            <div class="col-md-offset-4 col-sm-offset-4 col-md-6 col-sm-6 col-xs-8">
					                <div class="invoice-footer-heading"><?php echo lang('items_sold','',array(),TRUE); ?></div>
					            </div>
					            <div class="col-md-2 col-sm-2 col-xs-4">
					                <div class="invoice-footer-value invoice-total">{{ total_items_sold }}</div>
					            </div>
				
					
				
				        </div> 
			
						{{#each payments}}
			
							<div class="row">
					            <div class="col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-md-4 col-sm-4 col-xs-4">
					                <div class="invoice-footer-heading"><?php echo lang('payment','',array(),TRUE); ?></div>
					            </div>
					            <div class="col-md-2 col-sm-2 col-xs-4">
										<div class="invoice-footer-value">{{ this.type }}</div>																				
					            </div>
					            <div class="col-md-2 col-sm-2 col-xs-4">
										<div class="invoice-footer-value">{{ to_currency_no_money this.amount }}</div>																				
					            </div>
					
							</div>
							
							{{/each}}
							
					
				    <!-- invoice footer-->						 
				    <div class="row">
				        <div class="col-md-12 col-sm-12 col-xs-12">
				            <div class="invoice-policy" id="invoice-policy-return">
				                <?php echo nl2br(H($this->config->item('return_policy'))); ?>
				            </div>
			
				    </div>
				</div>
				<!--container-->
			</div>		
		</div>
	</div>
	</script>

<script id="saved-sale-template" type="text/x-handlebars-template">

    <div class="d-flex align-items-center mb-6">
                            <!--begin::Bullet-->
                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span>
                            <!--end::Bullet-->
                            
                            <!--begin::Info-->
                            <div class="flex-grow-1 me-5">
                                <!--begin::Time-->
                                <div class="text-gray-800 fw-semibold fs-2">
                                <?php echo lang('sale'); ?> {{index}}  (
                                <?php echo lang('customer'); ?>: {{customer}} )
                                </div>
                                <!--end::Time-->

                                <div class="text-gray-700 fw-semibold fs-6">
                                    {{topItems}}                              </div>

                                <!--begin::Link-->
                                <div class="text-gray-500 fw-semibold fs-7">
                                <span class="badge badge-success">  <?php echo lang('total'); ?>: {{total}}</span>          
                              
                                <span class="badge badge-info">  <?php echo lang('items_sold'); ?>: {{items_sold}}</span>   
                                    <!--end::Name-->  
                                </div>
                                <!--end::Link-->
                            </div>
                            <!--end::Info-->

                            <!--begin::Action-->                            
                            <a href="#" class="btn btn-sm btn-success view_saved_sale" data-index={{index}} ><?php echo lang('recp');?></a>         
                            <a href="#" class="btn btn-sm btn-warning edit_saved_sale mx-1" data-index={{index}} ><?php echo lang('edit');?></a>        
                            <a href="#" class="btn btn-sm btn-danger delete_saved_sale" data-index={{index}}><?php echo lang('delete');?> </a>                              
                            <!--end::Action-->  
                        </div>


                        
   
</script>
<script id="cart-payment-template" type="text/x-handlebars-template">

    <li class="list-group-item">
			<span class="key">
				<a href="#" class="delete-payment remove" id="delete_payment_{{index}}" data-payment-index="{{index}}"><i class="icon ion-android-cancel"></i></a>
				{{type}}
			</span>
			<span class="value">{{amount}}</span>
            
		</li>
</script>
<script id="list-category-template" type="text/x-handlebars-template">
    <li data-category_count="{{sub_categories}}" data-category_id="{{value}}" class="category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6 top_category" role="presentation"><a class="border border-gray-900  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active symbol" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"> {{#greaterThanZero items_count}}  <span class="symbol-badge badge badge-circle bg-success top-10 start-80">{{items_count}}</span> {{/greaterThanZero}}   {{#greaterThanZero sub_categories}}<span class="symbol-badge badge badge-circle bg-danger top-10 start-15">{{sub_categories}}</span>   {{/greaterThanZero}}<div class="nav-icon "> <img class="rounded-3 mb-4" alt="" src="{{default_image}}"></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>{{name}}</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>                          

</script>


<script id="list-item-template" type="text/x-handlebars-template">
    <div class="col-sm-4  col-md-3 col-lg-2 mb-2 col-xxl-2 category_item item  register-holder has-image item_parent_class " data-has-variations="0" data-max_discount="10.000" data-can_override_price_adjustments="0"
                        data-tax_percent="0" data-override_default_tax="0" data-tax_included="0"
                        data-name="{{label}}" data-price="2" data-id="{{value}}" >
                        <div class=" card card-flush
                            bg-light h-xl-100">
                            <!--begin::Body-->
                                <div class="card-body text-center pb-5">
                                    <!--begin::Overlay-->
                                    <div class="d-block overlay">
                                        <!--begin::Image-->
                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded mb-7"
                                            style="height: 90px;background-image:url({{image}})">
                                            <span
                                                class="position-absolute symbol-badge badge  badge-light top-75 end-0 price_of_item ">
                                                {{unit_price}}
                                            </span>
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Action-->
                                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25"><i
                                                class="bi  fs-2x text-white"></i></div>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Overlay-->
                                    <span
                                        class="fw-bold text-left text-gray-800 cursor-pointer text-hover-primary fs-6 d-block mt-minus-10">{{label}}</span>
                                    <div class="d-flex align-items-end flex-stack mb-1"></div>

                                </div>
                            <span class="position-absolute symbol-badge badge   badge-circle badge-light-primary fs-2 h-30px w-30px  bottom-5 end-5 ">+</span>
                        </div>
                        </div>
</script>

<script id="cart-item-template" type="text/x-handlebars-template">


    <tbody class="fw-bold text-gray-600" data-line="{{index}}">

        <tr class="register-item-details">


            <td class="text-center  fs-6">



                <span
                    class="toggle_rows btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"
                    style="position:relative">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                    <span class="svg-icon svg-icon-3 m-0 toggle-off">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1"
                                transform="rotate(-90 11 18)" fill="currentColor"></rect>
                            <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
                    <span class="svg-icon svg-icon-3 m-0 toggle-on">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span> &nbsp;
            </td>

            <td class="fs-6">

                <a tabindex="-1" href="<?= base_url(); ?>/home/view_item_modal/{{item_id}}?redirect=sales"
                    data-target="#kt_drawer_general" data-target-title="View Item"
                    data-target-width="xl" class="register-item-name text-gray-800 text-hover-primary "
                    data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse"
                    data-bs-placement="top" title="{{name}}">{{name}}</a>
            </td>
            <td class="text-center fs-6">
                

                    <a href="#" id="price_{{index}}" class="xeditable xeditable-price editable" data-validate-number="true" data-type="text" data-pk="1" data-name="price" data-index="{{index}}" data-title="Price">{{to_currency_no_money price}}</a>									 


            </td>
            <td class="text-center fs-6">
                <button type="button" onclick="inc_de_qty('{{index}}', -1)"
                    class="btn w-25px h-25px  btn-icon rounded-circle btn-light"><i
                        class="bi bi-dash fs-1"></i></button>
            
                <a href="#" id="quantity_{{index}}" class="xeditable edit-quantity " data-type="text"  data-validate-number="true"  data-pk="1" data-name="quantity" data-index="{{index}}" data-title="Qty.">{{to_quantity quantity}}</a>
            
                
                <button type="button" onclick="inc_de_qty('{{index}}', 1)"
                    class="btn w-25px h-25px  btn-icon rounded-circle btn-light"> <i
                        class="bi bi-plus fs-1"></i></button>
            </td>

            <td class="text-center fs-6" style="padding-right:10px">

                <a href="#" id="total_{{index}}" class=" editable editable-click">{{to_currency_no_money line_total}}</a>


                <a href="<?= base_url(); ?>/sales/delete_item/{{index}}" data-cart-index="{{index}}" class="delete-item pull-right"
                    tabindex="-1" data-id="{{index}}" data-item_id="{{item_id}}"><i class="icon ion-android-cancel"></i></a>





                    {{#sn_check all_data.is_serialized name }}
                    {{#sn_modal_check  serialnumber  permissions.require_to_add_serial_number_in_pos }}
                                <div class="modal fade look-up-receipt" id="add_sn_modal_{{index}}"
                                    role="dialog" aria-labelledby="lookUpReceipt" aria-hidden="true">
                                    <div class="modal-dialog customer-recent-sales">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label=<?php echo json_encode(lang('close')); ?>><span
                                                        aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="lookUpReceipt">
                                                    <?php echo lang('add_serial_number') ?> <? lang('item') ?>: {{name}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <label><?php echo lang('Please_select_Serial_Number') ?></label>


                                                {{#count all_data.serial_numbers  }}
                                                    <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                                        <a href="#" id="sserialnumber_{{index}}" data-name="serialnumber" data-index="{{index}}"   data-type="select" data-pk="1"  data-title="<?php echo H(lang('serial_number')); ?>">
                                                        {{serialnumberText}}
                                                        </a>
                                                    </div>
                                                {{else}}
                                                <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                                        
                                                        
                                                    {{#if  permissions.edit_serail_no}}
                                                                                
                                                        <a href="#" id="sserialnumber_{{index}}" data-name="serialnumber" data-index="{{index}}"   data-type="text" data-pk="1"  data-title="<?php echo H(lang('serial_number')); ?>">
                                                        {{serialnumberText}} 
                                                        </a>
                                                        {{else}}
                                                        <span id="sserialnumber_{{index}}>" data-type="text" data-pk="1" data-name="serialnumber" data-title="<?php echo H(lang('serial_number')); ?>">              
                                                            {{serialnumberText}}
                                                        </span>
                                                        
                                                        {{/if}}

                                                    </div>

                                                {{/count}}


                                            </div>
                                        </div>
                                    </div>
                                </div>
                             
                                                        
                        {{/sn_modal_check}}
                    {{/sn_check}}
            </td>

        </tr>
        <tr class="register-item-bottom collapse">
            <td>&nbsp;</td>
            <td colspan="5">



                <div class="row">


                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('discount_percent'); ?></div>
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"> <a
                                href="#" id="discount_{{index}}" class="xeditable-item-percentage editable editable-click"
                                data-type="text" data-validate-number="true" data-index="{{index}}" data-pk="1"
                                data-name="discount_percent" data-value="{{discount_percent}}"
                                
                                data-title="Discount Percentage">{{discount_percent}}%</a>

                        </div>
                    </div>

                    {{#if selected_variation}}
                        <?php if ($this->Employee->has_module_action_permission('sales', 'edit_variation', $this->Employee->get_logged_in_employee_info()->person_id)) : ?>
                                <div class="col-md-3 mt-3">
                                    <div class="text-gray-800 fs-7"><?php echo lang('variation'); ?></div>
                                    <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                    <a style="cursor:pointer;" onclick="edit_variation({{index}});"><?php echo lang('edit'); ?></a>

                                    </div>
                                </div>
                        <?php endif; ?>
                    {{/if}}

                    {{#if modifiers}}
                                <div class="col-md-3 mt-3">
                                    <div class="text-gray-800 fs-7"><?php echo lang('modifiers'); ?></div>
                                    <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                    <a style="cursor:pointer;" onclick="enable_popup_modifier({{index}});"><?php echo lang('edit'); ?></a>

                                    {{#if selected_item_modifiers}}
                                        <div class="text-muted fs-7 fw-bold">
                                            <ul>
                                        {{#each selected_item_modifiers}}
                                                <li>
                                                   {{name}} >> {{modifier_item_name}}:  {{unit_price_currency}}
                                                </li>
                                                
                                        {{/each}}
                                            </ul>
                                        </div>
                                    {{/if}}
                                    </div>
                                </div>
                    {{/if}}


                    <?php
													if (count($tiers) > 1) { ?>
														<div class="col-md-3 mt-3">
															<!-- cart items details  tier  -->
															<div class="text-gray-800 fs-7"><?php echo lang('tier'); ?> </div>
															<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                                            {{#or permissions.allow_price_override_regardless_of_permissions  permission_edit_sale_price}}
																
																<a href="#" id="tier_{{index}}" data-index="{{index}}" data-name="tier_id" data-type="select" data-pk="1" data-url="" data-title="<?php echo H(lang('tier')); ?>">
                                                                    {{#if tier_id}}
                                                                                <span>{{tier_name}}</span>
                                                                    {{/if}}

                                                                </a>

                                                                {{else}}

                                                                {{#if tier_id}}
                                                                                <span>{{tier_name}}</span>
                                                                    {{/if}}
                                                            {{/or}}
															</div>
														</div>
													
													
												<?php } ?>
                                             
                {{#if is_suspended }}
                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('qty_picked_up'); ?></div>
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"> <a
                                href="#" id="discount_{{index}}" class="xeditable-item-quantity-received  editable-click"
                                data-type="text" data-validate-number="true" data-index="{{index}}"  data-total-qty="{{quantity}}" data-pk="1"
                                data-name="quantity_received" data-value="{{quantity_received}}"
                                
                                data-title="Discount Percentage">{{quantity_received}}</a>

                        </div>
                    </div>
                {{/if}}


                

                {{#if quantity_units }}
                    <div class="col-md-3 mt-3">
                        <!-- cart items details  tier  -->
                        <div class="text-gray-800 fs-7"><?php echo lang('quantity_units'); ?> </div>
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                            
                            <a href="#" id="quantity_unit_{{index}}" data-index="{{index}}" data-name="quantity_unit_id" data-type="select" data-pk="1" data-url="" data-title="<?php echo H(lang('quantity_unit_id')); ?>">
                                {{#if quantity_unit_id}}
                                            <span>{{quantity_unit_name}}</span>
                                {{/if}}

                            </a>

                        
                        
                        </div>
                    </div>
                {{/if}}


                {{#cost_price_permission permissions.always_use_average_cost_method permissions.change_cost_price permissions.allow_price_override_regardless_of_permissions  permission_edit_sale_price }}
                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('cost_price'); ?></div>
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"> <a
                                href="#" id="cost_price_{{index}}" class="xeditable-cost_price  editable-click"
                                data-type="text" data-validate-number="true" data-index="{{index}}" data-pk="1"
                                data-name="cost_price" data-value="{{cost_price}}"
                                
                                data-title="Discount Percentage">{{cost_price}}</a>

                        </div>
                    </div>
                {{/cost_price_permission}}



                {{#supplier_permission permissions.hide_supplier_on_sales_interface  permissions.disable_supplier_selection_on_sales_interface }}
                <div class="col-md-3 mt-3">
                    <div class="text-gray-800 fs-7"><?php echo lang('supplier'); ?> </div>
                    <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                
                        
                        <a href="#" id="supplier_{{index}}" data-index="{{index}}" data-name="supplier_id" data-type="select" data-pk="1" data-url="" data-title="<?php echo H(lang('supplier')); ?>">
                            {{#if supplier_id}}
                                        <span>{{supplier_name}}</span>
                            {{/if}}

                        </a>

                   
                    </div>
                </div>
                {{/supplier_permission}}

                {{#not permissions.hide_description_on_sales_and_recv  }}
                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('description'); ?></div>
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                            {{#greaterThanZero permissions.allow_alt_description }}
                        <a
                                href="#" id="description_{{index}}" class="xeditable-description  editable-click"
                                data-type="text" data-validate-number="true" data-index="{{index}}" data-pk="1"
                                data-name="description" data-value="{{description}}"
                                
                                data-title="Discount Percentage">{{description}}</a>

                                {{else}}
                                <span>{{description}}</span>

                                {{/greaterThanZero}}

                        </div>
                    </div>
                {{/not}}

                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('category'); ?></div>
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                {{all_data.category_name}}
                                                        

                        </div>
                    </div>
                    {{#if selected_rule}}
                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7">{{selected_rule.name}}</div>
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                {{to_currency_no_money selected_rule.rule_discount}}
                                                        

                        </div>
                    </div>

                    {{/if}}
                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('tax'); ?></div>
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                            <a href="#" class=" edit_taxes_item"
                                 data-target="#kt_drawer_general"
                                data-target-title="Edit Taxes" id="" data-id="{{index}}" data-target-width="lg">Edit Taxes</a>
                        </div>
                    </div>
                    {{#sn_check all_data.is_serialized name }}
                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('serial_number'); ?></div>

                        {{#count all_data.serial_numbers  }}
                            <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                <a href="#" id="serialnumber_{{index}}" data-name="serialnumber" data-index="{{index}}"   data-type="select" data-pk="1"  data-title="<?php echo H(lang('serial_number')); ?>">
                                   {{serialnumberText}}
                                </a>
                            </div>
                        {{else}}
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                
                                
                               {{#if  permissions.edit_serail_no}}
                                                        
                                <a href="#" id="serialnumber_{{index}}" data-name="serialnumber" data-index="{{index}}"   data-type="text" data-pk="1"  data-title="<?php echo H(lang('serial_number')); ?>">
                                   {{serialnumberText}} 
                                </a>
                                {{else}}
                                <span id="serialnumber_{{index}}>" data-type="text" data-pk="1" data-name="serialnumber" data-title="<?php echo H(lang('serial_number')); ?>">              
                                    {{serialnumberText}}
                                </span>
                                
                                {{/if}}

                            </div>

                        {{/count}}

                        



                    </div>

                    {{/sn_check}}



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
                                {{all_data.id_to_show_on_sale_interface_val}}
                        </div>
                    </div>


                </div>
               
               
            </td>
           
        </tr>
        
    </tbody>
   
</script>

<script id="list-hold-cart-template" type="text/x-handlebars-template">

    <div class="d-flex align-items-center mb-6">
                            <!--begin::Bullet-->
                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-warning"></span>
                            <!--end::Bullet-->
                            
                            <!--begin::Info-->
                            <div class="flex-grow-1 me-5">
                                <!--begin::Time-->
                                <div class="text-gray-800 fw-semibold fs-2">
                                {{readableDate}}
                                  
                                </div>
                                <!--end::Time-->

                                <!--begin::Description-->
                                <div class="text-gray-700 fw-semibold fs-6">
                                   {{topItems}}                            </div>
                                <!--end::Description-->

                                <!--begin::Link-->
                                <div class="text-gray-500 fw-semibold fs-7">
                                 
                                    <!--begin::Name-->
                                    <span class="badge badge-secondary">   Sub Total : {{subtotal}}</span>
                                    <span class="badge badge-success">   Sub Tax : {{totaltax}}</span>
                                    <span class="badge badge-primary">   Total Amount : {{totalAmount}}</span> 
                                    <span class="badge badge-warning">   Total Due : {{totaldue}}</span> 
                                    <!--end::Name-->  
                                </div>
                                <!--end::Link-->
                            </div>
                            <!--end::Info-->

                            <!--begin::Action-->                            
                            <a href="#" data-suspend-index="{{index}}"  class="btn btn-sm btn-primary unsuspend_offline" >Unsuspend </a>                               
                            <!--end::Action-->  
                        </div>


        <!--end::Separator-->
</script>





<div id="kt_drawer_general_body_lg_container" style="display: none;">


    <script src="<?php echo base_url() ?>assets/css_good/plugins/custom/formrepeater/formrepeater.bundle.js"></script>

    <div class="" style="width: inherit;">
        <!--begin::Modal content-->
        <div class="">
            <!--begin::Form-->

            <!--begin::Modal body-->
            <div class="  px-lg-17">
                <!--begin::Scroll-->
                <div class="scroll-y me-n7 pe-7" id="kt_modal_create_api_key_scroll" data-kt-scroll="true"
                    data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_create_api_key_header"
                    data-kt-scroll-wrappers="#kt_modal_create_api_key_scroll" data-kt-scroll-offset="300px">
                    <!--begin::Notice-->

                    <!--end::Notice-->
                    <!--begin::Input group-->
                    <div class="row">
                        <div class="col-md-12">



                            <input type="hidden" class="current_cart_item">
                            <!-- /////////// -->

                            <div class="mb-2 fv-row">

                                <label
                                    class=" fs-5 fw-semibold mb-2 "><?php echo form_label(lang('tax_class') . ': ', 'tax_class'); ?></label>

                                <select name="tax_class" id="tax_class"
                                    class="form-control form-control-solid tax_class_main">
                                    <!-- Options will be loaded here -->
                                </select>
                            </div>

                            <div id="all_taxes" class="all_taxes">
                                <h4 class="text-center"><?php echo lang('or') ?></h4>
                                <!-- ///// -->


                                <!--begin::Repeater-->
                                <div id="kt_docs_repeater_basic">
                                    <!--begin::Form group-->
                                    <div class="">
                                        <div data-repeater-list="kt_docs_repeater_basic">


                                            <div class="repeater-item" data-repeater-item>
                                                <div class=" row">
                                                    <div class="col-md-5">
                                                        <label class="form-label">Tax:</label>

                                                        <input type="text" name="tax_names"
                                                            class="form-control mb-2 mb-md-0" placeholder="Name" />
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label class="form-label">Percent:</label>
                                                        <input type="hidden" name="tax_cumulatives" value="0">
                                                        <input type="text" name="tax_percents"
                                                            class="form-control mb-2 mb-md-0" placeholder="Percent" />
                                                    </div>

                                                    <div class="col-md-2">
                                                        <a href="javascript:;" data-repeater-delete
                                                            class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

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
                        <input type="button" name="submitf" value="Save" id="submitf"
                            class="submit_button btn btn-primary pt-2">
                        <!--begin::Button-->

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
        </div>


      


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
            var maxItems = 6;

            $('#kt_docs_repeater_basic').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function() {
                    // Check the current number of items
                    var currentItems = $('#kt_docs_repeater_basic .repeater-item')
                        .length; // +1 includes the one being added now
                    console.log("s", currentItems);
                    if (currentItems <= maxItems) {
                        $(this).slideDown();
                    } else {
                        alert('Maximum of 5 items can be added.');
                        // This is crucial: prevents the item from being added if max is reached
                        $(this).remove();
                    }
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });
        });
        </script>
    </div>
    <div id="kt_drawer_general_body_lg_tax_list"></div>
</div>
<div class="modal fade" id="attributeModal" tabindex="-1" role="dialog" aria-labelledby="attributeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="attributeModalLabel">Select an Option</h5>
       
      </div>
      <div class="modal-body">

     
        <!-- Options will be dynamically inserted here -->
        <div id="attributeOptions"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="backAttribute">Back</button>
        <button type="button" class="btn btn-primary" id="nextAttribute">Next</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade look-up-receipt" id="choose_modifiers" role="dialog" aria-labelledby="lookUpReceipt" aria-hidden="true">
				<div class="modal-dialog customer-recent-sales">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="lookUpReceipt"><?php echo lang('modifiers'); ?></h4>
						</div>
						<div class="modal-body clearfix">
                        <div id="modifiersOptions"></div>
						</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="saveAttribute">Save</button>
                        </div>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->


<?php $this->load->view("sales/offline/js/offline_js"); ?>


<?php $this->load->view("partial/offline_footer"); ?>