
<?php 

$this->load->view("partial/offline_header"); ?>

<?php $this->load->view("sales/offline/css/offline_css"); ?>
<div id="network-status"><?= lang('You_are_offline'); ?></div>
<div class="modal fade look-up-receipt" id="print_modal" role="dialog" aria-labelledby="lookUpReceipt"
    aria-hidden="true">
    <div class="modal-dialog customer-recent-sales">
        <div class="modal-content border-none" >
            <div class="modal-header hidden-print">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="<?php echo lang('close'); ?>"><span
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

<script src="<?php echo base_url() ?>assets/css_good/plugins/custom/formrepeater/formrepeater.bundle.js"></script>

<div id="sales_page_holder">

</div>
<div class=" register d-flex pos-container hidden-print" id="main-container">

    <!--begin::View component-->
    <div id="kt_drawer_example_basic" class="bg-white drawer drawer-end" data-kt-drawer="true"
        data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_drawer_example_basic_button"
        data-kt-drawer-close="#kt_drawer_example_basic_close" data-kt-drawer-width="500px"
        style="width: 500px !important;">
        <div class="card border-0 shadow-none rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4"
                id="kt_app_layout_builder_header"
                >

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-dark flex-column m-0">
                <?= lang('Pos_Builder'); ?>
                    <small class="text-white opacity-50 fs-7 fw-semibold pt-1">
                    <?= lang('Get_Ready_To_Customize_Your_Own_Pos_Interface'); ?> </small>
                </h3>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon text-black fs-2 p-0 w-20px h-20px rounded-1 slider_button"
                        id="kt_app_layout_builder_close">
                        x </button>
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
                                    <h4 class="fw-bold text-gray-900"><?= lang('Hide_Categories'); ?></h4>
                                    <div class="fs-7 fw-semibold text-muted">
                                    <?= lang('Click_On_Toggle_To_Hide_Show_The_Categories'); ?>

                                    </div>
                                </div>
                                <!--end::Heading-->

                                <!--begin::Option-->
                                <div class="d-flex justify-content-end">
                                    <!--begin::Check-->
                                    <div
                                        class="form-check form-check-custom form-check-solid form-check-success form-switch">

                                        <input class="form-check-input w-45px h-30px" type="checkbox" value="true"
                                            name="hide_categories" <?= ($register_info->hide_categories) ? 'checked' : ''; ?>>
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
                                    <h4 class="fw-bold text-gray-900"><?= lang('Hide_Search_Bar'); ?></h4>
                                    <div class="fs-7 fw-semibold text-muted">
                                    <?= lang('Click_On_Toggle_To_Hide_Show_Search_Bar'); ?>

                                    </div>
                                </div>
                                <!--end::Heading-->

                                <!--begin::Option-->
                                <div class="d-flex justify-content-end">
                                    <!--begin::Check-->
                                    <div
                                        class="form-check form-check-custom form-check-solid form-check-success form-switch">

                                        <input class="form-check-input w-45px h-30px" type="checkbox" value="true"
                                            name="hide_search_bar" <?= ($register_info->hide_search_bar) ? 'checked' : ''; ?>>
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
                                    <h4 class="fw-bold text-gray-900"><?= lang('Hide_Top_Buttons'); ?></h4>
                                    <div class="fs-7 fw-semibold text-muted">
                                    <?= lang('Click_On_Toggle_To_Hide_Show_Top_Buttons'); ?>

                                    </div>
                                </div>
                                <!--end::Heading-->

                            </div>
                            <!--end::Form group-->
                            <div class="separator separator-dashed my-5"></div>

                            <!--begin::Form group-->
                            <div class="form-group d-flex flex-stack">
                                <!--begin::Heading-->
                                <div class="d-flex flex-column">
                                    <h4 class="fw-bold text-gray-900"><?= lang('Hide_Top_Item_Details'); ?></h4>
                                    <div class="fs-7 fw-semibold text-muted">
                                    <?= lang('Click_On_Toggle_To_Hide_Show_Item_Details'); ?>

                                    </div>
                                </div>
                                <!--end::Heading-->

                                <!--begin::Option-->
                                <div class="d-flex justify-content-end">
                                    <!--begin::Check-->
                                    <div
                                        class="form-check form-check-custom form-check-solid form-check-success form-switch">

                                        <input class="form-check-input w-45px h-30px" type="checkbox" value="true"
                                            name="hide_top_item_details"  <?= ($register_info->hide_top_item_details) ? 'checked' : ''; ?>>
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
                                    <h4 class="fw-bold text-gray-900"><?= lang('Hide_Top_Category_Navigation'); ?></h4>
                                    <div class="fs-7 fw-semibold text-muted">
                                    <?= lang('Click_On_Toggle_To_Hide_Show_Category_Navigation'); ?>

                                    </div>
                                </div>
                                <!--end::Heading-->

                                <!--begin::Option-->
                                <div class="d-flex justify-content-end">
                                    <!--begin::Check-->
                                    <div
                                        class="form-check form-check-custom form-check-solid form-check-success form-switch">

                                        <input class="form-check-input w-45px h-30px" type="checkbox" value="true"
                                            name="hide_top_category_navigation" <?= ($register_info->hide_top_category_navigation) ? 'checked' : ''; ?>>
                                    </div>
                                    <!--end::Check-->
                                </div>
                                <!--end::Option-->
                            </div>
                            <!--end::Form group-->
                            <div class="separator separator-dashed my-5"></div>

                            <div>
                              <h4> <?php echo lang('sales_keyboard_help_title'); ?> </h4>
                            </div>

                            <div class="d-flex flex-column content-justify-center w-100">
                               <!--begin::Label-->
                               <div class="d-flex fs-6 fw-semibold align-items-center">
                                        <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4">[F2] </div>
                                        <div class="fw-bolder text-gray-700 text-xxl-end"><?php echo lang('sales_set_focus_item'); ?></div>
                                    </div>

                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                        <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4">[F4] </div>
                                        <div class="fw-bolder text-gray-700 text-xxl-end"><?php echo lang('sales_completes_currrent_sale'); ?></div>
                                    </div>

                                 
                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                        <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4">[F6] </div>
                                        <div class="fw-bolder text-gray-700 text-xxl-end"><?php echo lang('focus_on_customer'); ?></div>
                                    </div>
                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                        <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4">[F7] </div>
                                        <div class="fw-bolder text-gray-700 text-xxl-end"><?php echo lang('sales_set_focus_payment'); ?></div>
                                    </div>

                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                        <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4">[F8] </div>
                                        <div class="fw-bolder text-gray-700 text-xxl-end"><?php echo lang('reports_suspended_sales'); ?></div>
                                    </div>

                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                        <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4">[ESC]</div>
                                        <div class="fw-bolder text-gray-700 text-xxl-end"><?php echo lang('sales_esc_cancel_sale'); ?></div>
                                    </div>

                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                        <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4">[CTRL + Q] </div>
                                        <div class="fw-bolder text-gray-700 text-xxl-end"><?php echo lang('quick_cash_help'); ?></div>
                                    </div>
                                   
                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                        <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                                        <div class="text-gray-500 flex-grow-1 me-4">[ + or - ] </div>
                                        <div class="fw-bolder text-gray-700 text-xxl-end"><?php echo lang('press_+_or_-_to_change_item_quantity'); ?></div>
                                    </div>
                            </div>

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
                >

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-dark flex-column m-0">
                <?= lang('Pos_Builder'); ?>
                    <small class="text-white opacity-50 fs-7 fw-semibold pt-1">
                    <?= lang('Get_Ready_To_Customize_Your_Own_Pos_Interface'); ?></small>
                </h3>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon text-black fs-2 p-0 w-20px h-20px rounded-1 slider_button"
                        id="kt_app_layout_builder_close">
                        x </button>
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
                >

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-dark flex-column m-0">
                <?= lang('Saved_Sales'); ?>
                    <small class="text-white opacity-50 fs-7 fw-semibold pt-1">
                    <?= lang('Get_Ready_To_Customize_Your_Own_Pos_Interface'); ?> </small>
                </h3>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon text-black fs-2 p-0 w-20px h-20px rounded-1 slider_button"
                        id="kt_app_layout_builder_close">
                       x</button>
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

                    <div id="sync_offline_sales" class="pull-right" style="display: none;">
                            <br />
                        
                            <button class="btn btn-primary" id="sync_offline_sales_button"> 
                                <?php echo lang('sales_sync_offline_sales'); ?> [<span id="number_of_offline_sales"></span>]
                                <span id="offline_sync_spining" style="display: none" class="glyphicon glyphicon-refresh spinning"></span>    
                            </button>
                        
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
    <div id="kt_drawer_example_basic_save_as" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#kt_drawer_suspend" data-kt-drawer-close="#kt_drawer_example_basic_close"
        data-kt-drawer-width="500px">
        <div class="card border-0 shadow-none rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4"
                id="kt_app_layout_builder_header" >

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-black flex-column m-0">
                    <?php echo lang("save_as") ?>

                </h3>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon text-black fs-2 p-0 w-20px h-20px rounded-1 slider_button"
                        id="kt_app_layout_builder_close">
                        x </button>
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
                id="kt_app_layout_builder_header" >

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-black flex-column m-0">
                    <?= lang('advance_details') ?>
                </h3>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon text-black fs-2 p-0 w-20px h-20px rounded-1 slider_button"
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
                                        class="selected-tier"></span>
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
                                    <a href="#" data-value="<?php echo $key; ?>"
                                        data-permission_edit_sale_price="<?php if ($this->Employee->has_module_action_permission('sales', 'edit_sale_price', $key)) { echo "1"; }else{   echo "0"; }  ?>"
                                        class="list-group-item"><?php echo H($employee); ?></a>
                                    <?php } ?>
                                </div>

                            </div>
                            <?php  }  ?>
                            <?php if ($this->Employee->has_module_action_permission('sales', 'change_sale_date', $this->Employee->get_logged_in_employee_info()->person_id) && ($this->cart->get_previous_receipt_id() || $this->config->item('change_sale_date_for_new_sale'))) { ?>
                            <div
                                class="change-date form-check  col-12  border border-dashed rounded min-w-125px py-2  px-4">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <?php 
									echo '<label class="form-check-label w-20 pull-right mb-0 mt-3" for="change_date_enable"><span></span>' . lang('change_date') . '</label>';
                                    echo form_checkbox(array(
										'name' => 'change_date_enable',
										'id' => 'change_date_enable',
										'value' => '1',
										'class' => 'form-check-input ml-0',
										'checked' => (bool) $change_date_enable
									));
                                    

									?>

                                    <div id="change_cart_date_picker" class=" date datepicker fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ion-calendar text-light"></i></span>

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
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="kt_app_layout_builder_close_submit"><?= lang('submit') ?></button>
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
                >

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-dark flex-column m-0">
                <?= lang('Go_To'); ?>
                </h3>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon text-black fs-2 p-0 w-20px h-20px rounded-1 slider_button"
                        id="kt_app_layout_builder_close">x</button>
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
                                            title="<?= lang('Sell_GiftCard'); ?>"><?= lang('Sell_GiftCard'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/new_giftcard" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Sell_GiftCard'); ?>"><span class="svg-icon svg-icon-2">
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
                                            title="<?= lang('Suspended_Sales'); ?>"><?= lang('Suspended_Sales'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/suspended" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Suspended_Sales'); ?>"><span class="svg-icon svg-icon-2">
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
                                            title="<?= lang('Work_Orders'); ?>"><?= lang('Work_Orders'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/work_orders" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Work_Orders'); ?>"><span class="svg-icon svg-icon-2">
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
                                            title="<?= lang('Delivery_Orders'); ?>"><?= lang('Delivery_Orders'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>deliveries" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Delivery_Orders'); ?>"><span class="svg-icon svg-icon-2">
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
                                            title="<?= lang('Search_Sales'); ?>"><?= lang('Search_Sales'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>reports/sales_generator" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Search_Sales'); ?>"><span class="svg-icon svg-icon-2">
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
                                            title="<?= lang('Store_Account_Payment'); ?>"><?= lang('Store_Account_Payment'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/change_mode/store_account_payment/1" target="_self"
                                        id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Store_Account_Payment'); ?>"><span class="svg-icon svg-icon-2">
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
                                            title="<?= lang('Batch_Sale'); ?>"><?= lang('Batch_Sale'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/batch_sale/" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px none suspended_sales_btn"
                                        title="<?= lang('Batch_Sale'); ?>"><span class="svg-icon svg-icon-2">
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

                            <?php
					
					if ($this->Employee->has_module_action_permission('sales', 'can_lookup_last_receipt', $this->Employee->get_logged_in_employee_info()->person_id)) {
						if ($last_sale_id = $this->Sale->get_last_sale_id()) { ?>
                            <div class="d-flex flex-stack">
                                <div class="symbol symbol-30px me-4">
                                    <div class="symbol-label fs-2 fw-semibold bg-warning text-inverse-bg-warning">
                                        <i class="ion-document text-light"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/receipt/<?= $last_sale_id; ?>" target="_blank" id="last_sale_id"
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold look-up-receipt"
                                            title="<?= lang('Show_Last_Sale_Receipt'); ?>"><?= lang('Show_Last_Sale_Receipt'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/receipt/83" target="_blank" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px look-up-receipt"
                                        title="<?= lang('Show_Last_Sale_Receipt'); ?>"><span class="svg-icon svg-icon-2">
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


                            <?php } } ?> 


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
                                            title="<?= lang('Customer_Facing_Display'); ?>"><?= lang('Customer_Facing_Display'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/customer_display/1" target="_blank"
                                        id="customer_facing_display_link"
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Customer_Facing_Display'); ?>"><span class="svg-icon svg-icon-2">
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
                                            title="<?= lang('Pop_Open_Cash_Drawer'); ?>"><?= lang('Pop_Open_Cash_Drawer'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/open_drawer" target="_blank" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px pop_open_cash_drawer"
                                        title="<?= lang('Pop_Open_Cash_Drawer'); ?>"><span class="svg-icon svg-icon-2">
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
                                            title="<?= lang('Add_Cash_To_Register'); ?>"><?= lang('Add_Cash_To_Register'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/register_add_subtract/add/common_cash"
                                        target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Add_Cash_To_Register'); ?>"><span class="svg-icon svg-icon-2">
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
                                            title="<?= lang('Add_Cash_To_Register'); ?>"><?= lang('Add_Cash_To_Register'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/register_add_subtract/subtract/common_cash"
                                        target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Add_Cash_To_Register'); ?>"><span class="svg-icon svg-icon-2">
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
                                            title="<?= lang('Close_Register'); ?>"><?= lang('Close_Register'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/closeregister?continue=closeoutreceipt"
                                        target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Close_Register'); ?>"><span class="svg-icon svg-icon-2">
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

                                <?php if($this->config->item('test_mode')): ?>
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/disable_test_mode" target="_self" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="<?= lang('Disable_Test_Mode'); ?>"><?= lang('Disable_Test_Mode'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/disable_test_mode" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Disable_Test_Mode'); ?>"><span class="svg-icon svg-icon-2">
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

                                <?php else: ?>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <div class="flex-grow-1 me-2">
                                        <a href="<?= base_url(); ?>sales/enable_test_mode" target="_self" id=""
                                            class="text-gray-800 text-hover-primary fs-6 fw-bold "
                                            title="<?= lang('Enable_Test_Mode'); ?>"><?= lang('Enable_Test_Mode'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/enable_test_mode" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Enable_Test_Mode'); ?>"><span class="svg-icon svg-icon-2">
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


                                <?php endif; ?>
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
                                            title="<?= lang('Custom_Field_Config'); ?>"><?= lang('Custom_Field_Config'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/custom_fields" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px "
                                        title="<?= lang('Custom_Field_Config'); ?>"><span class="svg-icon svg-icon-2">
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
                                            title="<?= lang('Lookup_Receipt'); ?>"><?= lang('Lookup_Receipt'); ?></a>
                                    </div>
                                    <a href="#look-up-receipt" target="_self" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px look-up-receipt"
                                        title="<?= lang('Lookup_Receipt'); ?>"><span class="svg-icon svg-icon-2">
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
                                            title="<?= lang('Show_All_Receipts_For_Today'); ?>"><?= lang('Show_All_Receipts_For_Today'); ?></a>
                                    </div>
                                    <a href="<?= base_url(); ?>sales/receipts?date=2024-07-09&amp;location_id=1"
                                        target="_blank" id=""
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px look-up-receipt"
                                        title="<?= lang('Show_All_Receipts_For_Today'); ?>"><span class="svg-icon svg-icon-2">
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
            style="cursor: ew-resize;width: 7px;position: relative;background-color: #6a6fdf;height: 100%;float: right;z-index: 99;">
        </div>
        <div class="d-flex top-left-pos">
            <div id="kt_app_sidebar_toggle" class="w-70px text-center pt-2  text-light cursor-pointer  rotate"
                data-kt-rotate="true">

                <span class="svg-icon svg-icon-muted svg-icon-2x rotate-180" style="margin: 0 auto;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"/>
<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"/>
</svg>
            </span>


            </div>
            <div class="register-box register-items-form  d-flex justify-content-space-between h-70px">
                <a tabindex="-1" href="#" class="dismissfullscreen hidden"><i class="ion-close-circled"></i></a>
                <div id="itemForm" class="item-form bg-light-100 w-60 d-flex justify-content-start align-item-center">
                    <!-- Item adding form -->

                    <form action="<?= base_url(); ?>sales/add" id="add_item_form" class="form-inline w-100 mx-2" autocomplete="off"
                        method="post" accept-charset="utf-8">

                        <div class="input-group input-group-mobile contacts">
                            <span class="input-group-text">
                                <a href="<?= base_url(); ?>items/view/-1?redirect=sales/index/1&amp;progression=1"
                                    class="none add-new-item" title="New Item" id="new-item-mobile" tabindex="-1"><i
                                        class="icon ti-pencil-alt"></i> <span class="register-btn-text"><?= lang('New_Item'); ?></span></a> </span>
                            <div class="input-group-text register-mode sale-mode dropdown bg-primary border-radius-left">
                                <a href="<?= base_url(); ?>#" class="none active" tabindex="-1" title="Sale"
                                    id="select-mode-1" data-target="#" data-toggle="dropdown" aria-haspopup="true"
                                    role="button" aria-expanded="false"> <?= lang('Sale'); ?> <i class="icon ti-shopping-cart m-2 text-light"></i>  <span
                                        class="register-btn-text mode_text"></span></a>
                                <ul class="dropdown-menu sales-dropdown">
                                    <li><a tabindex="-1" href="#" data-mode="Return" class="change-mode Return-mode" ><?= lang('Return'); ?></a></li>
                                    <li><a tabindex="-1" href="#" data-mode="Sale" class="change-mode Sale-mode "><?= lang('Sale'); ?></a></li>
                                </ul>
                            </div>

                            <span class="input-group-text grid-buttons ">
                                <a href="<?= base_url(); ?>#" class="none show-grid hidden" tabindex="-1"
                                    title="<?= lang('Show_Grid'); ?>"><i class="icon ti-layout"></i> <span
                                        class="register-btn-text"><?= lang('Show_Grid'); ?></span></a> <a href="<?= base_url(); ?>#"
                                    class="none hide-grid" tabindex="-1" title="<?= lang('Hide_Grid'); ?>"><i
                                        class="icon ti-layout"></i> <span class="register-btn-text"><?= lang('Hide_Grid'); ?></span></a>
                            </span>
                        </div>

                        <div class="input-group contacts register-input-group d-flex">

                            <!-- Css Loader  -->
                            <div class="spinner" id="ajax-loader" style="display:none">
                                <div class="rect1"></div>
                                <div class="rect2"></div>
                                <div class="rect3"></div>
                            </div>

                            <div class="input-group-text register-mode sale-mode dropdown bg-primary border-radius-left">
                                <a href="<?= base_url(); ?>#"
                                    class="none active text-light  text-hover-primary mode_text w-75px " tabindex="-1"
                                    title="Sale" id="select-mode-2" data-target="#" data-toggle="dropdown"
                                    aria-haspopup="true" role="button" aria-expanded="false">Sale<i
                                        class="icon ti-shopping-cart m-2 text-light"></i> </a>
                                <ul class="dropdown-menu sales-dropdown">
                                <li><a tabindex="-1" href="#" data-mode="Return" class="change-mode Return-mode" ><?= lang('Return'); ?></a></li>
                                    <li><a tabindex="-1" href="#" data-mode="Sale" class="change-mode Sale-mode "><?= lang('Sale'); ?></a></li>
                                   
                                   
                                </ul>
                            </div>
                            <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>


                            <input type="text" id="item" name="item"
                                class="add-item-input   w-30  pull-left keyboardTop  ui-autocomplete-input"
                                placeholder="<?php echo lang('start_typing_item_name'); ?>"
                                data-title="<?php echo lang('item_name'); ?>">

                            <input type="hidden" name="secondary_supplier_id" id="secondary_supplier_id">
                            <input type="hidden" name="default_supplier_id" id="default_supplier_id">


                            <span class="input-group-text d-none grid-buttons  ">
                                <a href="<?= base_url(); ?>#" class="none show-grid hidden" tabindex="-1"
                                    title="<?= lang('Show_Grid'); ?>"><i class="icon ti-layout"></i> <?= lang('Show_Grid'); ?></a> <a
                                    href="<?= base_url(); ?>#" class="none hide-grid" tabindex="-1" title="<?= lang('Hide_Grid'); ?>"><i
                                        class="icon ti-layout"></i> <?= lang('Hide_Grid'); ?></a> </span>
                            <span class="input-group-text  grid-buttons bg-primary border-radius-right  p-0">
                                <div class="card-toolbar">
                                    <!--begin::Menu-->
                                    <button id="category_selection_btn"
                                        class="btn h-20px w-100px btn-icon btn-color-light-400 btn-active-color-primary justify-content-end  d-inline-flex"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">
                                        <?= lang('Categories'); ?> <i class="icon ti-angle-down m-2 text-light"></i> </button>
                                    <div id="grid_selection"
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                        data-kt-menu="true" style="">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4"><?= lang('Select_Option'); ?>
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="javascript:void(0);" class="btn active menu-link px-3"
                                                id="by_category"> <?= lang('Categories'); ?></a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="javascript:void(0);" class=" menu-link px-3"
                                                id="by_supplier"><?= lang('Suppliers'); ?></a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="javascript:void(0);" class=" menu-link px-3" id="by_tag"><?= lang('Tags'); ?></a>
                                        </div>
                                      
                                        <!-- <div class="menu-item px-3">
                                            <a href="javascript:void(0);" class=" menu-link px-3"
                                                id="by_favorite">Favorite</a>
                                        </div> -->
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

                <div class="d-flex justify-content-end w-40 align-item-center">


                    <?php echo form_open("sales/cancel_sale", array('id' => 'cancel_sale_form', 'autocomplete' => 'off', 'class' => 'd-flex    h-42px')); ?>

                    <?php
                     if ($mode != 'store_account_payment' && $mode != 'purchase_points') { ?>

                    <?php if ($this->Employee->has_module_action_permission('sales', 'suspend_sale', $this->Employee->get_logged_in_employee_info()->person_id) &&   !$this->config->item('test_mode')) { ?>
                    <div class="d-flex bg-primary p-3 flex-center w-100px h-42px me-1 "
                        id="kt_drawer_suspend" class="menu-icon w-100 " data-bs-custom-class="tooltip-inverse"
                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click"
                        data-bs-trigger="hover" data-bs-original-title="Metronic Builder" data-kt-initialized="1">
                        <div class=" py-2">
                        <?= lang('save_as') ?>
                         
                        </div>
                        <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
                        <span class="svg-icon svg-icon-3x svg-icon-2hx text-light">
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
                     
                      
                        
                       
                    </div>
                   


                    <div class="d-flex  bg-primary  p-3 flex-center w-100px h-42px me-1 "  <?php if($this->cart->get_previous_receipt_id() ||  $this->cart->suspended): ?>   <?php  else: ?>  style="display:none !important" <?php endif; ?>
                        id="cancel_sale_button">

                        <div class=" py-2">
                            <?php echo  lang('back');  ?>
                        </div>
                        <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
                        <span class="svg-icon svg-icon-3x svg-icon-2hx text-light">
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
                      
                    </div>

                   

                    <?php } ?>


                    <?php } ?>


                    

                    <div class="d-flex  bg-primary  p-3 flex-center w-100px h-42px me-1 "
                        id="delete_sale_button" <?php
                        if (($this->cart->get_previous_receipt_id() || $this->cart->suspended) && $this->Employee->has_module_action_permission('sales', 'delete_sale', $this->Employee->get_logged_in_employee_info()->person_id)) {
                        ?>  <?php }else{ ?>   style="display:none !important"   <?php } ?>>
                        <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->

                        <div class=" py-2"><?php echo lang('void'); ?></div>


                        <span class="svg-icon svg-icon-3x svg-icon-2hx  text-danger">

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

                     
                    </div>


                    <div class="d-flex  bg-primary p-3 flex-center w-100px  h-42px me-1 " id="advance_details">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->

                        <div class=" py-2">
                            <?= lang('add_info') ?> </div>
                    
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/general/gen045.svg-->
                            <span class="svg-icon svg-icon-3x svg-icon-2hx text-light"><svg class="pos-top-icon" width="24"
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
                        <!--end::Svg Icon-->
                        </div>

                    </form>




                </div>

            </div>
        </div>
        <div class="d-flex">

            <?php
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;


		?>
            <div class="w-75px pos-sidebar">
                <!--begin::Sidebar menu-->
                <div class="app-sidebar-menu app-sidebar-menu-arrow hover-scroll-overlay-y    pos-menu"
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
                                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="16.9497" y="8.46448" width="13" height="2" rx="1" transform="rotate(135 16.9497 8.46448)" fill="currentColor"/>
                                    <path d="M14.8284 9.97157L14.8284 15.8891C14.8284 16.4749 15.3033 16.9497 15.8891 16.9497C16.4749 16.9497 16.9497 16.4749 16.9497 15.8891L16.9497 8.05025C16.9497 7.49797 16.502 7.05025 15.9497 7.05025L8.11091 7.05025C7.52512 7.05025 7.05025 7.52513 7.05025 8.11091C7.05025 8.6967 7.52512 9.17157 8.11091 9.17157L14.0284 9.17157C14.4703 9.17157 14.8284 9.52975 14.8284 9.97157Z" fill="currentColor"/>
                                    </svg>
                                    </span>
                                </span>
                            </span>




                            <span class=" menu-link ">
                                <span id="kt_drawer_example_basic_button" class="menu-icon w-100 "
                                    data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip"
                                    data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover"
                                    data-bs-original-title="Metronic Builder" data-kt-initialized="1">
                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/text/txt001.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2x "><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z"
                                                fill="currentColor" />
                                            <path opacity="0.3"
                                                d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>

                            <span class=" menu-link ">

                            <a tabindex="-1" class="menu-icon w-100 suspened_sale_button " href="<?= base_url(); ?>/sales/suspended_quick"
                    data-target="#kt_drawer_general" data-target-title="<?= lang('Suspended_Sales'); ?>"
                    data-target-width="xl" class="register-item-name text-gray-800 text-hover-none "
                    data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse"
                    data-bs-placement="top" title="hold cart"><span class="svg-icon svg-icon-muted svg-icon-2x  ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
                                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                    <!-- Cart Icon -->
                                                    <path d="M6 6h15l-1.68 9H6.75A4.75 4.75 0 0 1 2 10.25v-.5A4.75 4.75 0 0 1 6.75 5H19M6 6H4">
                                                    </path>
                                                    <circle cx="9" cy="19" r="1"></circle>
                                                    <circle cx="18" cy="19" r="1"></circle>
                                                    <line x1="3" y1="3" x2="21" y2="21"></line>
                                                </g>
                                            </svg>

                                        </span></a>


                            </span>


                         
                            <div class="menu-item" >
                                <a class=" menu-link " href="<?php echo site_url('sales/sales_list'); ?>">
                                    <span class="menu-icon  w-100 ">
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/arrows/arr043.svg-->
                                        <span class="svg-icon svg-icon-muted svg-icon-2x "><svg width="24"
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
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>

                                </a>
                            </div>

                            <div class="menu-item" >
                                <span class=" menu-link  bg-success" id="kt_drawer_completed_sales"  data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip"
                                        data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover"
                                        data-bs-original-title="Metronic Builder" data-kt-initialized="1">
                                    <span  class="menu-icon   w-100" 
                                       >
                                        <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/text/txt001.svg-->
                                        <span class="svg-icon svg-icon-muted svg-icon-2x text-light ">
                                            <span id="offline_sync_spining"
                                                class="glyphicon glyphicon-refresh spinning"></span>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                            </div>
                            <div class="menu-item">
                            <div class="row">
                                    <div class=" hidden-print alternate text-center" id="pagination"  ></div>
                                </div>
                            </div>

                        </div>


                     

                       
                    </div>
                </div>
            </div>
            <div class="sale-grid-big-wrapper-parent">
                <div id="sale-grid-big-wrapper" class="clearfix register ">
                    <div class="clearfix" style="" id="category_item_selection_wrapper">
                        <div id="grid_breadcrumbs"
                            class="py-1 pos-bg-dark h-45px p-5 rounded-1 d-flex align-items-center flex-wrap"> </div>

                        <div class="horizontal-scroll h-120px "  id="category_item_selection_parent">
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
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 pos_bg_dark" id="sales_section">
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
<script id="selected-customer-store-account-template" type="text/x-handlebars-template">
    <div class="table-responsive" style="height:70vh">
        <table class="table table-hover table-striped">
            <thead>
                <tr class="register-items-header">
                    <th class="sp_sale_id text-left fs-3"><?php echo lang('sale_id'); ?></th>
                    <th class="sp_date text-left fs-3"><?php echo lang('date'); ?></th>
                    <th class="sp_charge text-left fs-3"><?php echo lang('total_charge_to_account'); ?></th>
                    <th class="sp_comment text-left fs-3"><?php echo lang('comment'); ?></th>
                    <th class="sp_pay text-left fs-3"><?php echo lang('pay'); ?></th>
                </tr>
            </thead>
            <tbody id="unpaid_sales_data">
                {{#if customer.unpaid_store_account_sale_ids.length}}
                    {{#each customer.unpaid_store_account_sale_ids}}
                        <tr>
                            <td><a href="sales/receipt/{{sale_id}}" target="_blank">
      <?=  ($this->config->item('sale_prefix') ? $this->config->item('sale_prefix') : 'POS') ?> {{sale_id}}
    </a></td>
                            <td>{{sale_time}}</td>
                            <td>{{payment_amount}}</td>
                            <td>{{comment}}</td>
                            <td>
                            <button  data-id="{{sale_id}}"
                                class="btn btn-primary pay_store_account_sale" onclick="toggleSalePaid(   '{{sale_id}}' , '{{payment_amount}}' )">
                                {{#if paid}}
                                    <?php echo lang('remove_payment'); ?>
                                {{else}}
                                    <?php echo lang('pay'); ?>
                                {{/if}}
                                </button>
                            </td>
                        </tr>
                    {{/each}}
                {{else}}
                    <tr>
                        <td colspan="5" class="text-center text-muted"><?php echo lang('no_unpaid_sales_found'); ?></td>
                    </tr>
                {{/if}}
            </tbody>
        </table>

        <div class="d-flex gap-1 right-bottom">
       

                        <div class="input-group-text register-mode sale-mode dropup h-43px border-radius-left">


                                <a tabindex="-1" href="#"
                                class="none active text-light  text-hover-primary payment_option_selected_store"
                                title="Sales Sale" id="select-mode-3" data-target="#" data-toggle="dropdown"
                                aria-haspopup="true" role="button" aria-expanded="false"><i
                                    class="fa fa-money-bill"></i>
                                <?= lang('Cash') ?> </a>



                                <ul class="dropdown-menu sales-dropdown payment_dropdown">
                                    <?php foreach ($payment_options as $key => $value) {
                                    
                                                $active_payment =  ($default_payment_type == $value) ? "selected" : "";
                                            ?>
                                                <li> <a tabindex="-1" href="#"
                                                        class="btn btn-pay select-payment-store text-left pt-2 <?php echo $active_payment; ?>"
                                                        data-payment="<?php echo H($value); ?>"> <i
                                                            class="fa fa-money-bill"></i>
                                                        <?php echo H($value); ?>
                                                    </a> </li>
                                                <?php } ?>

                            
                                </ul>
                        </div>
                        <input type="hidden" name="payment_types_store" id="payment_types_store" value="<?= lang('Cash') ?>">
                            <span class="input-group-text h-43px border-radius-right" id="finish_sale_">
                                <a href="#" class="text-white {{#unless customer.paid_store_account_sale_ids.length}}disabled pointer-events-none opacity-50{{/unless}}"  id="finish_sale_button_store"   >
                                    <?= lang('Complete_Sale'); ?>
                                </a>
                            </span>
            <button type="button" class="btn btn-danger"  onclick="cancelStoreAccountPayment()">Cancel</button>
        </div>


    </div>

    
</script>

<script id="selected-customer-form-template" type="text/x-handlebars-template">

                <!-- Sale Top Buttons  -->


                <!-- If customer is added to the sale -->
                <div class="d-flex flex-wrap flex-sm-nowrap p-2 pb-0 gap-2">

                    


                    <!--begin: Pic-->
                    <div class="me-1 mb-1 w-50px">
                        <div class="symbol symbol-50px  symbol-fixed position-relative symbol-circle">
                            <img src="{{customer.avatar}}"
                                onerror="this.onerror=null; this.src='<?= base_url(); ?>assets/img/user.png';"
                                alt="image">


                        </div>
                    </div>
                    <!--end::Pic-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                            <!--begin::User-->
                            <div class="d-flex flex-column mt-1">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center">
                                    <a href="#" class="text-gray-900 text-hover-info fs-6 fw-bold"> </a><a
                                        href="<?= base_url(); ?>sales/customer_recent_sales/{{customer.person_id}}" data-toggle="modal"
                                        data-target="#myModal"
                                        class="text-gray-700 text-hover-info fs-7 fw-bold me-1 name"
                                        id="customer_name">{{customer.customer_name}}</a>


                                </div>
                                <!--end::Name-->
                                <!--begin::Info-->






                                <!-- Start: ++++++++++++++++++++++++++++++++++++++++++++++++++ Customer added info +++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

                                <!-- Customer Balance -->
                                <div class="d-flex flex-wrap fw-semibold fs-6 pe-2 mt-1 gap-10 vertical-center text-hover-info">
                                    <div>
                                            <i class="fa fa-money-bill me-2"></i>
                                     

                                        <!--end::Svg Icon-->

                                        <span id="customer_balance" class=""> {{customer.balance}}</span>
                                    </div>
                                
                                    <!-- End Customer Balance -->

                                    <!-- Customer Loyalty Points -->





                                    <div class="loyalty {{#equal customer.disable_loyalty 0}} d-none  {{/equal}} ">
                                        <?php if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'simple') { ?>
                                        <span
                                            class="d-flex align-items-center text-gray-500 fw-normal fs-7 text-hover-info me-5 {{#if customer.sales_until_discount}} text-danger {{else}} text-success {{/if}}  sales_until_discount_main">
                                            <i class="fa fa-gift me-2"></i>
                                            <div class="fs-6 fw-bold counted  sales_until_discount"
                                                data-kt-countup="true" data-kt-countup-value="4500"
                                                data-kt-countup-prefix="$" data-kt-initialized="1">
                                                <span id="sud_val">
                                                {{#greaterThanZero customer.sales_until_discount}}  {{customer.sales_until_discount}} {{else}} 0 {{/greaterThanZero}}
                                                </span>
                                                {{#conditionCheck (lt customer.sales_until_discount 0) (not extra.redeem)}}

                                                <span title="  <?php echo lang('redeem') ?>" id="redeem_discount"
                                                    >[<?php echo lang('redeem') ?>]</span>
                                                    {{else}}
                                                <span title="  <?php echo lang('unredeem') ?>" id="unredeem_discount"
                                                   >[<?php echo lang('unredeem') ?>]</span>

                                                    {{/conditionCheck}}
                                            </div>

                                        </span>

                                        <?php } ?>

                                        <?php if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced') { ?>
                                        <span title="  <?php echo lang('points') ?>"
                                            class="d-flex align-items-center text-gray-500 fw-normal fs-7 text-hover-info me-5  {{#LessThanEqual customer.points 0}} text-danger {{else}} text-success  {{/LessThanEqual}} points_main">
                                            <i class="fa fa-gift me-2"></i>
                                            <div class="fs-6 fw-bold counted  points" data-kt-countup="true"
                                                data-kt-countup-value="4500" data-kt-countup-prefix="$"
                                                data-kt-initialized="1"> {{customer.points}}

                                            </div>

                                        </span>

                                        <?php } ?>

                                    </div>
                                    <div class="d-flex">
                                    <i class="fa fa-comments me-2 mt-2"></i>
                                    <a href="#" id="internal_notes"
                                        class="xeditable-comment edit-internal_notes d-flex align-items-center text-gray-500 text-hover-info fw-normal fs-7  editable-click px-2"
                                        data-type="text" data-validate-number="false" data-pk="1"
                                        data-name="internal_notes" data-placement="bottom" data-value="{{customer.internal_notes}}">
                                        <span id="customer_internal_notes">{{customer.internal_notes}}</span>
                                    </a>
                                    </div>


                                    <div class="d-flex ">
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
                                        <button type="button" class="btn btn-sm btn-icon "
                                            data-kt-menu-trigger="custom" data-kt-menu-overflow="true"
                                            data-kt-menu-placement="top-end">
                                           <i class=" ti ti-more-alt vertical"></i>
                                        </button>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                            data-kt-menu="true" style="">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4"><?= lang('Quick_Actions'); ?>
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

                                            <!--begin::Menu item ftd-->
                                            <div class="menu-item px-3 d-none">


                                                <a href="<?= base_url(); ?>sales/view_delivery_modal/" class="menu-link px-3 "
                                                    id="open_delivery_modal" data-toggle="modal" data-target="#myModal"> <i
                                                        class="ion-android-car"></i><?= lang('Delivery'); ?></a>

                                            </div>





                                            <div class="menu-item px-3 d-none">
                                                <a href="<?= base_url(); ?>customers/redeem_series/{{customer.person_id}}" id="redeem_series"
                                                    class="menu-link px-3" title="Redeem Series"><i
                                                        class="ion-ios-compose-outline"></i><?= lang('Redeem_Series'); ?></a>
                                            </div>

                                          

                                            <div class="menu-item px-3">
                                                <a href="#" id="pay_now"
                                                data-target="#kt_drawer_general"  data-target-title="Pay Now"
                                                    data-target-width="full" class="menu-link px-3" title="Pay Now"><i
                                                        class="ion-ios-compose-outline"></i> <?= lang('Pay_Now'); ?></a>
                                            </div>

                                            <div class="menu-item px-3">



                                                <a href="<?= base_url(); ?>customers/quick_modal/{{customer.person_id}}/1" id="edit_customer"
                                                    data-target="#kt_drawer_general" data-target-title="New Customer"
                                                    data-target-width="xl" class="menu-link px-3" title="<?= lang('Update_Customer'); ?>"><i
                                                        class="ion-ios-compose-outline"></i> <?= lang('Update_Customer'); ?></a>
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
                                                        href="<?= base_url(); ?>reports/generate/specific_customer?report_type=complex&amp;start_date=2023-07-11&amp;start_date_formatted=07/11/2023 12:00 am&amp;end_date=2024-07-11%2023:59:59&amp;end_date_formatted=07/11/2024 11:59 pm&amp;customer_id={{customer.person_id}}&amp;sale_type=all&amp;export_excel=0"
                                                        class="btn btn-success btn-sm px-4"><?= lang('View_Report'); ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>

                                        <!--begin::Menu 2-->

                                        <!--end::Menu 2-->
                                        <!--end::Menu-->




                                    </div>

                                    <a href="#" id="remove_customer" class="vertical-center">

                                        <i class="icon ti-close m-2 text-danger" ></i>
                                    </a>

                                   


                                </div>


                            </div>
                            <!--end::User-->
                            <!--begin::Actions-->
                            
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


            </script>


        <script id="item-template" type="text/x-handlebars-template">
            {{#each this}}
						<tbody  class="fw-bold text-gray-600" data-line="{{@index}}">
                   
							<tr class="register-item-details">


								<td class="text-center  fs-6">



									<span
										class="toggle_rows "
										style="position:relative">
                                        <i class="icon ti-angle-down"></i>
									</span> &nbsp;
								</td>

								<td class="fs-6">

									<a tabindex="-1"
										href="<?= base_url(); ?>/home/view_item_modal/{{item_id}}?redirect=sales"
										data-target="#kt_drawer_general" data-target-title="<?= lang('View_item'); ?>"
										data-target-width="xl" class="register-item-name text-gray-800 text-hover-none "
										data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse"
										data-bs-placement="top" title="{{name}}">{{name}}</a>
								</td>
								<td class="text-center fs-6">
									<a href="#" id="price_{{@index}}" class="xeditable xeditable-price editable editable-click"
										data-validate-number="true" data-type="text" data-value="{{price}}" data-pk="1"
										data-name="unit_price" data-url="<?= base_url(); ?>/sales/edit_item/0"
										data-title="Price">{{currency}} {{price}}</a>


								</td>
								<td class="text-center fs-6">

                                            
                                {{#notequal name 'discount'}}
								        <button type="button"  onclick="inc_de_qty('{{@index}}', -1)" class="btn w-25px h-25px  btn-icon rounded-circle btn-light"><i class="bi bi-dash fs-1"></i></button> 
									    <a href="#" id="quantity_{{@index}}" class="xeditable edit-quantity editable editable-click"
										data-type="text" data-validate-number="true" data-pk="{{@index}}" data-name="quantity"
										data-url="<?= base_url(); ?>/sales/edit_item/{{@index}}"
										data-title="Quantity">
									
										 {{qty}}
		
										</a><button type="button" onclick="inc_de_qty('{{@index}}', 1)" class="btn w-25px h-25px  btn-icon rounded-circle btn-light"> <i class="bi bi-plus fs-1"></i></button>
                                {{else}}
                                    {{qty}}
                                {{/notequal}}
								</td>

								<td class="text-center fs-6" style="padding-right:10px">

									<a href="#" id="total_{{@index}}" class="xeditable editable editable-click" data-type="text"
										data-validate-number="true" data-pk="1" data-name="total" data-value="{{multiply price qty}}"
										data-url="<?= base_url(); ?>/sales/edit_line_total/{{@index}}"
										data-title="Total">{{currency}} {{multiply price qty}}</a>


									

								</td>
                                <td class="text-center fs-7"><a href="<?= base_url(); ?>/sales/delete_item/{{@index}}"
										class="delete-item " tabindex="-1" data-cart-index="{{@index}}" data-id="{{@index}}"><i
											class="fa fa-trash text-danger"></i></a></td>
							</tr>
							<tr class="register-item-bottom collapse">
								<td>&nbsp;</td>
								<td colspan="5">



									<div class="row">

                                   
										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7"><?= lang('Discount_Percentage'); ?></div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"> <a
													href="#" id="discount_0" class="xeditable editable editable-click"
													data-type="text" data-validate-number="true" data-pk="1"
													data-name="discount" data-value="0"
													data-url="<?= base_url(); ?>/sales/edit_item/0"
													data-title="<?= lang('Discount_Percentage'); ?>">0%</a>

											</div>
										</div>

										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7"><?= lang('Supplier'); ?></div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><a
													href="#" id="supplier_0" data-name="supplier" data-type="select"
													data-pk="1"
													data-url="<?= base_url(); ?>/sales/edit_item_supplier/0"
													data-title="<?= lang('Supplier'); ?>" class="editable editable-click">Cafe Store inc</a>
											</div>
										</div>

									


										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7"><?= lang('Description'); ?></div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
												None </div>
										</div>

										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7"><?= lang('Category'); ?></div>
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
											<div class="text-gray-800 fs-7"><?= lang('Stock'); ?></div>
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
                    <?= lang('Discount'); ?> ({{currency}}) <i class="fonticon-content-marketing" id="discount_details_reload"></i>
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
                    <div class="fw-semibold fs-6 text-dark-400"><?= lang('sub_total'); ?> ({{currency}}) <a
                            href="<?= base_url(); ?>/sales/edit_taxes/" class="" id="edit_taxes"
                            data-target="#kt_drawer_general" data-target-title="<?= lang('Edit_Taxes'); ?>" data-target-width="lg"><i
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
                                class="delete-tax remove"><i class="fa fa-trash text-danger"></i></a>
                            5% VAT Rate 1:
                        </div>
                        <div class="fs-1 fw-bold counted">
                            0 </div>
                    </div>



                </div>
             


                <div class="amount-block border border-light border-dashed rounded min-w-125px h-80px py-3 px-4 ">
                    <div class="tax amount">
                        <div class="side-heading text-center fw-semibold fs-6 text-dark-400">
                        <?= lang('tax'); ?> ({{currency}}) </div>
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
                        <?= lang('total'); ?> ({{currency}})
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
                        <?= lang('Amount_Due'); ?> ({{currency}})
                        </div>
                        <div class="amount fs-1 fw-bold counted">
                           {{amount_due}} </div>
                    </div>
                </div>
                <!-- ./amount block -->

                <!-- Payment Applied -->

                <!-- Add Payment -->
                
</script>

        




        <!-- col-lg-4 @start of right Column -->

        <div id="discountbox_modal_reload_data" style="display:none">

            <div class="card border-0 shadow-none rounded-0 w-100">
                <!--begin::Card header-->
                <div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4"
                    id="kt_app_layout_builder_header"
                    >

                    <!--begin::Card title-->
                    <h3 class="card-title fs-3 fw-bold text-dark flex-column m-0">
                    <?= lang('Discount_Details'); ?> </h3>
                    <!--end::Card title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-sm btn-icon text-black fs-2 p-0 w-20px h-20px rounded-1 slider_button"
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
                                    <label for="exampleFormControlInput1" class=" form-label"><?= lang('Discount'); ?> %: </label>
                                    <input type="number" id="discount_all_percent" value=""
                                        class="form-control form-control-solid discount_all_percent">
                                </div>

                                <div class="mb-10">
                                    <label for="exampleFormControlInput1" class=" form-label"><?= lang('Discount_Fixed'); ?>: <span
                                            id="TEST"></span></label>
                                    <input type="number" id="discount_all_flat" value=""
                                        class="form-control form-control-solid discount_all_flat">
                                </div>



                                <button type="button"
                                    class="btn btn-primary w-100px update_discount_details"><?= lang('Update'); ?></button>

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

            <div class="register-right " id="select_customer_form">

                <!-- Sale Top Buttons  -->


                <!-- If customer is added to the sale -->

                <div class="customer-form d-flex flex-wrap px-1">

                    <!-- if the customer is not set , show customer adding form -->
                    <form action="<?= base_url(); ?>sales/select_customer" autocomplete="off"
                        class="form-inline w-100 mb-2" method="post" accept-charset="utf-8">
                        <div class="input-group contacts register-input-group d-flex">
                            
                            <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>


                            <input type="text" id="customer" name="customer"
                                class="add-customer-input  keyboardLeft ui-autocomplete-input border-radius-left w-92 "
                                data-title="<?php echo lang('customer_name'); ?>"
                                placeholder="<?php echo lang('sales_start_typing_customer_name'); ?>">
                                <span class="input-group-text   bg-primary border-radius-right ">
                                <a href="<?= base_url(); ?>customers/quick_modal/-1/1" class="none "
                                    title="New Customer" id="new-customer" data-target="#kt_drawer_general"
                                    data-target-title="New Customer" data-target-width="xl" tabindex="-1"><i
                                        class="ion-person-add text-white"></i></a> </span>

                        </div>
                    </form>


                </div>


            </div>


            
            <div id="customer-panel"></div>


            <div class="py-1 pos-bg-dark h-42px p-5 rounded-1 d-flex align-items-center flex-flex justify-content-space-between mt-1 order_detail_margin" >
                <div>
                    <span class="text-light"><?= lang('Order_Details'); ?></span>
                    <span class="badge badge-light badge-md text-black p-2 mx-5" ><?= lang('Items'); ?>:  <span id="total_items">0</span> </span>
                    
                    <span class="badge badge-light badge-md text-black p-2"><?= lang('QTY'); ?>: <span id="total_items_qty"> 0 </span> </span>
                </div>

                <div>
                        <span class="badge badge-light badge-md text-danger p-2 bg-light-danger" id="clear_sale_button" <?php if($this->cart->get_previous_receipt_id() ||  $this->cart->suspended): ?> style="display:none !important"   <?php  else: ?>   <?php endif; ?>>  <?= lang('Clear'); ?>  <i class="icon ti-close m-2 text-danger"></i></span>
                  
                </div>
                

            </div>
            <div class=" register-items  itemboxnew">


                <div class="register-items-holder">




                    <style>
                    /* #register tbody {
                        cursor: move;
                    } */

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
                    <div class="spinner" id="grid-loader2test" style="display: none;">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                    </div>
                    <table id="register"
                        class="table table-striped align-middle table-row-dashed fs-6 gy-3 dataTable no-footer">
                        <thead>
                            <tr
                                class="text-start text-gray-400 fw-bold fs-7  gs-0  pos_bg_dark">
                                <th class=" py-1  text-center  text-black  min-w-50px"><a href="javascript:void(0);"
                                        id="sale_details_expand_collapse" class="expand"> <i class="icon ti-angle-down"></i>  </a></th>
                                <th class=" py-1 item_sort_able  text-black item_name_heading vertical-align "><?= lang('Item_Name'); ?></th>
                                <th class=" py-1 item_sort_able min-w-100px text-center text-black sales_price vertical-align "><?= lang('Price'); ?>
                                </th>
                                <th class=" py-1 item_sort_able min-w-100px sales_quantity  text-black vertical-align text-center"><?= lang('Quantity'); ?></th>
                                <th class=" py-1 item_sort_able min-w-100px text-center sales_total text-black vertical-align "><?= lang('Total'); ?>
                                </th>
                                <th class="min-w-50px"></th>
                            </tr>
                        </thead>

                    </table>

                </div>

                <!-- End of <?= lang('Store_Account_Payment'); ?> Mode -->

                <!-- /.Register Items first pan end here -->
                <div class=" register-summary paper-cut  pos_footer d-flex flex-wrap bg-light-100 pos_bg_dark justify-content-space-between"
                    id="pos_footer">
                    <div class=" d-flex flex-wrap ">

                    <div class=" d-flex  border border-light  rounded min-w-125px h-80px py-3 px-4 align-item-center flex-direction-column">



                       
                        <div class="side-heading text-center fw-semibold fs-8 text-dark-400">
                            <i class="fonticon-content-marketing fs-6" id="discount_details_reload"></i>
                            <?= lang('Discount'); ?> (OMR) 
                        </div>

                        <div class="fs-2 fw-bold counted text-center" id="total_discount">0 </div>
                    </div>


                    <span class="svg-icon   svg-icon-primary svg-icon-2x vertical-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>
                        </svg>
                    </span>




                    <div class="sub-total  min-w-125px h-80px py-3 px-4 d-flex align-item-center flex-direction-column  bg-unset">
                        <div class="fw-semibold fs-8 text-dark-400 my-2"><?= lang('Sub_Total'); ?> (OMR)
                        </div>
                        <div class="fs-1 fw-bold counted">
                            <a href="#" id="sub_total" class=" xeditable-subtotal editable-click" data-validate-number="true" data-type="text" data-value="0" data-pk="1" data-title="Sub Total"> 0</a>
                        </div>

                    </div>

                    <span class="svg-icon   svg-icon-primary svg-icon-2x vertical-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                        </svg>
                    </span>


                    <div class=" d-flex  border border-light  rounded min-w-125px h-80px py-3 px-4 align-item-center flex-direction-column">



                           
                        <div class="side-heading text-center fw-semibold fs-8 text-dark-400">
                        <a href="#" class="" id="edit_taxes_gen" data-id="-1"
                                    data-target="#kt_drawer_general" data-target-title="<?= lang('Edit_Taxes'); ?>"
                                    data-target-width="lg"><i class="fonticon-content-marketing fs-6"></i>
                            </a>
                            <?= lang('tax'); ?> (OMR)
                        </div>

                        <div class="amount total-tax fs-2 fw-bold counted" data-speed="1000" data-currency="OMR"
                                data-decimals="0" id="taxes">
                                0
                            </div>
                    </div>




                  
                    <span class="svg-icon   mt-3 svg-icon-primary svg-icon-2x vertical-center">
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

                    <div class="amount-block  min-w-125px h-80px py-3 px-4 bg-unset ">
                        <div class="total amount">
                            <div class="side-heading text-center fw-semibold fs-6 text-dark-400">
                            <?= lang('Total'); ?> (OMR)
                            </div>
                            <div class="amount total-amount fs-1 fw-bold counted" data-speed="1000" data-currency="OMR"
                                data-decimals="0" id="total">

                            </div>
                        </div>
                    </div>


                    <span class="svg-icon   mt-3 svg-icon-primary svg-icon-2x vertical-center">
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
                    <div class="d-flex flex-direction-column align-items-center rounded amount-block  min-w-125px h-80px py-3 px-4 bg-primary  me-3">
                    
                        
                            <div class="side-heading text-center fw-semibold fs-8 text-dark-400">
                            <i class="fonticon-content-marketing fs-6 text-light" title="" id="kt_drawer_payments_list"></i>    <?= lang('Amount_Due'); ?>   (OMR)


                               



                            </div>
                        <div class="amount fs-2 fw-bold counted" id="amount_due">
                                0 </div>
                    </div>
                    <!-- ./amount block -->

                    <!-- Payment Applied -->

                    <div id="create_invoice_holder" class="  min-w-125px h-80px py-3 px-4 bg-unset create_invoice_holder  hidden"">
                        <div class="total amount">
                        <div class="text-right">
                                    <label for="create_invoice" class="control-label wide"><?= lang('Create_Invoice'); ?></label> <input
                                        type="checkbox" name="create_invoice" value="1" id="create_invoice">
                                    <label for="create_invoice"
                                        style="padding-left: 10px; margin-top:0px;"><span></span></label>
                                </div>
                        </div>
                    </div>



                    </div>

                    <!-- Add Payment -->
                    <div class=" add-payment border border-light border-dashed rounded w-25 py-3 px-4 vertical-center">
                        <!-- Check Work Order Permission -->
                      
                        <form action="#" id="add_payment_form" autocomplete="off" method="post" accept-charset="utf-8" >
                       
                            <div class="input-group add-payment-form">





                                <div class="input-group-text register-mode sale-mode dropup h-43px border-radius-left">


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
                                                            class="btn btn-pay select-payment text-left pt-2 <?php echo $active_payment; ?>"
                                                            data-payment="<?php echo H($value); ?>"> <i
                                                                class="fa fa-money-bill"></i>
                                                            <?php echo H($value); ?>
                                                        </a> </li>
                                                    <?php } ?>

                                       <?php  if ($has_coupons_for_today) { ?>
                                        <li> <a tabindex="-1" href="#"
                                                class="btn btn-pay select-payment text-left pt-2 "
                                                data-payment="Coupon"> <i
                                                    class="fa fa-money-bill"></i>
                                                    <?php echo lang('add_coupon'); ?>
                                            </a> </li>

                                            <?php } ?>
                                    </ul>
                                </div>

                                <?php
							$this->load->helper('sale');
 ?>



                                <input type="hidden" name="payment_types" id="payment_types" value="Cash">
                                <input type="input" name="amount_tendered" value="2" id="amount_tendered"
                                    class="form-control h-43px" data-title="Payment Amount" placeholder="Enter Cash Amount">

                                <span class="input-group-text h-43px border-radius-right">
                                    <a href="#" class="" id="add_payment_button"> <?= lang('Add_Payment'); ?></a>
                                </span>
                                <span class="input-group-text h-43px border-radius-right" id="finish_sale">

                                    <a href="#" class="text-white" id="finish_sale_button"><?= lang('Complete_Sale'); ?></a>
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
    <div class="row manage-table  card p-5 receipt_small border-none" id="receipt_wrapper">
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
				<a href="#" class="delete-payment remove" id="delete_payment_{{index}}" data-payment-index="{{index}}"><i class="fa fa-trash text-danger"></i></a>
				{{type}}
			</span>
			<span class="value">{{amount}}</span>
            
		</li>
</script>
<script id="cart-coupon-template" type="text/x-handlebars-template">

    <li class="list-group-item">
			<span class="key">
				<a href="#" class="delete-coupon remove" id="delete_coupon_{{index}}" data-coupon-index="{{index}}"><i class="fa fa-trash text-danger"></i></a>
				 <?= lang('Coupon'); ?>: 
			</span>
			<span class="value">{{label}}</span>
            
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
                            <span class="position-absolute badge   badge-circle badge-light-primary fs-2 h-30px w-30px  bottom-5 end-5 ">+</span>
                        </div>
                        </div>
</script>

<script id="cart-item-template" type="text/x-handlebars-template">


    <tbody class="fw-bold text-gray-600" data-line="{{index}}">

        <tr class="register-item-details">


            <td class="text-center  fs-7">



                <span
                    class="toggle_rows   "
                    style="position:relative">
                    <i class="icon ti-angle-down"></i>
                </span> &nbsp;
            </td>

            <td class="fs-7">

                <a tabindex="-1" href="<?= base_url(); ?>/home/view_item_modal/{{item_id}}?redirect=sales"
                    data-target="#kt_drawer_general" data-target-title="<?= lang('View_item'); ?>"
                    data-target-width="xl" class="register-item-name text-gray-800 text-hover-none "
                    data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse"
                    data-bs-placement="top" title="{{name}}">{{name}}</a>
            </td>
            <td class="text-center fs-7">
                

                    <a href="#" id="price_{{index}}" class="xeditable xeditable-price editable" data-validate-number="true" data-type="text" data-pk="1" data-name="price" data-index="{{index}}" data-title="Price">{{to_currency_no_money price}}</a>									 


            </td>
            <td class="text-center fs-7">

            {{#notequal name 'discount'}}
                <i onclick="inc_de_qty('{{index}}', -1)"
                        class="icon ti-minus text-black cursor-pointer"></i>
            
                <a href="#" id="quantity_{{index}}" class="xeditable edit-quantity mx-1" data-type="text"  data-validate-number="true"  data-pk="1" data-name="quantity" data-index="{{index}}" data-title="Qty.">{{to_quantity quantity}}</a>
            
                
               <i
                        class="icon ti-plus text-black cursor-pointer" onclick="inc_de_qty('{{index}}', 1)"></i>

                {{else}}
                     {{to_quantity quantity}}

                {{/notequal}}

            </td>

            <td class="text-center fs-7" style="padding-right:10px">

                <a href="#" id="total_{{index}}" class=" xeditable edit-price-line-total" data-validate-number="true"  data-pk="1" data-name="price-line-total" data-index="{{index}}">{{to_currency_no_money line_total}}</a>


                





                    {{#sn_check all_data.is_serialized name }}
                    {{#sn_modal_check  serialnumber  permissions.require_to_add_serial_number_in_pos }}
                                <div class="modal fade look-up-receipt" id="add_sn_modal_{{index}}"
                                    role="dialog" aria-labelledby="lookUpReceipt" aria-hidden="true">
                                    <div class="modal-dialog customer-recent-sales">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label=<?php echo lang('close'); ?>><span
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
            <td class="text-center fs-7"><a href="<?= base_url(); ?>/sales/delete_item/{{index}}" data-cart-index="{{index}}" class="delete-item "
                    tabindex="-1" data-id="{{index}}" data-item_id="{{item_id}}"><i class="fa fa-trash text-danger"></i></a></td>

        </tr>
        <tr class="register-item-bottom bg-white collapse">
            <td>&nbsp;</td>
            <td colspan="5">



                <div class="row">

                {{#notequal name 'discount'}}
                                 
                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('discount_percent'); ?></div>
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"> <a
                                href="#" id="discount_{{index}}" class="xeditable-item-percentage editable editable-click"
                                data-type="text" data-validate-number="true" data-index="{{index}}" data-pk="1"
                                data-name="discount_percent" data-value="{{discount_percent}}"
                                
                                data-title="<?= lang('Discount_Percentage'); ?>">{{discount_percent}}%</a>

                        </div>
                    </div>
                {{/notequal}}

                    {{#if all_data.has_variations}}
                        <?php if ($this->Employee->has_module_action_permission('sales', 'edit_variation', $this->Employee->get_logged_in_employee_info()->person_id)) : ?>
                                <div class="col-md-3 mt-3">
                                    <div class="text-gray-800 fs-7"><?php echo lang('variation'); ?></div>
                                    <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                    <a class="myeditable" style="cursor:pointer;" onclick="edit_variation({{index}});"><?php echo lang('edit'); ?></a>

                                    </div>
                                </div>
                        <?php endif; ?>
                    {{/if}}

                    {{#if modifiers}}
                                <div class="col-md-3 mt-3">
                                    <div class="text-gray-800 fs-7"><?php echo lang('modifiers'); ?></div>
                                    <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                    <a style="cursor:pointer;" onclick="enable_popup_modifier({{index}});" class="myeditable"><?php echo lang('edit'); ?></a>

                                    {{#if selected_item_modifiers}}
                                        <div class="text-muted fs-7 fw-bold mt-3">
                                            <ul>
                                        {{#each selected_item_modifiers as |modifier modifierIndex|}}
                                                <li>
                                                    <!-- {{../index}} is used for outer item_index -->
                                               <a href="#" id="modifier_{{modifierIndex}}"  data-index="{{../index}}" class="xeditable edit-price" data-type="text" data-validate-number="true" data-pk="1" data-name="modifier_price" data-modifier-item-id="{{modifier_item_id}}" data-title="<?php echo lang('price'); ?>" data-value="{{unit_price}}">{{unit_price_currency}}</a>
                                               : 
                                                   {{name}} >>  {{modifier_item_name}} 
                                                </li>
                                                
                                        {{/each}}
                                            </ul>
                                        </div>
                                    {{/if}}
                                    </div>
                                </div>
                    {{/if}}


                {{#if is_suspended }}
                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('qty_picked_up'); ?></div>
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"> <a
                                href="#" id="discount_{{index}}" class="xeditable-item-quantity-received  editable-click"
                                data-type="text" data-validate-number="true" data-index="{{index}}"  data-total-qty="{{quantity}}" data-pk="1"
                                data-name="quantity_received" data-value="{{quantity_received}}"
                                
                                data-title="<?= lang('Discount_Percentage'); ?>">{{quantity_received}}</a>

                        </div>
                    </div>
                {{/if}}


                {{#if all_data.all_tier_info }}
														<div class="col-md-3 mt-3">
															<!-- cart items details  tier  -->
															<div class="text-gray-800 fs-7"><?php echo lang('tier'); ?> </div>
															<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                                            {{#or permissions.allow_price_override_regardless_of_permissions  permission_edit_sale_price}}
																
																<a href="# " class="myeditable" id="tier_{{index}}" data-index="{{index}}" data-name="tier_id" data-type="select" data-pk="1" data-url="" data-title="<?php echo H(lang('tier')); ?>">
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
                                
                                data-title="<?= lang('Discount_Percentage'); ?>">{{cost_price}}</a>

                        </div>
                    </div>
                {{/cost_price_permission}}



                {{#supplier_permission permissions.hide_supplier_on_sales_interface  permissions.disable_supplier_selection_on_sales_interface }}
                <div class="col-md-3 mt-3">
                    <div class="text-gray-800 fs-7"><?php echo lang('supplier'); ?> </div>
                    <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                
                        
                        <a href="#" id="supplier_{{index}}" class="myeditable" data-index="{{index}}" data-name="supplier_id" data-type="select" data-pk="1" data-url="" data-title="<?php echo H(lang('supplier')); ?>">
                            {{#if supplier_id}}
                                        <span>{{supplier_name}}</span>
                            {{/if}}

                        </a>

                   
                    </div>
                </div>
                {{/supplier_permission}}

            

                    
                    {{#if selected_rule}}
                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('Coupon'); ?></div>
                        <div class="text-muted fs-7 fw-bold text-black" data-kt-table-widget-4="template_cost">
                                {{selected_rule.name}}
                                                        

                        </div>
                    </div>

                    {{/if}}
                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('tax'); ?></div>
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                            <a href="#" class=" edit_taxes_item myeditable"
                                 data-target="#kt_drawer_general"
                                data-target-title="<?= lang('Edit_Taxes'); ?>" id="" data-id="{{index}}" data-target-width="lg"><?= lang('Edit_Taxes'); ?></a>
                        </div>
                    </div>
                    {{#sn_check all_data.is_serialized name }}
                    <div class="col-md-3 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('serial_number'); ?></div>

                        {{#count all_data.serial_numbers  }}
                            <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                <a href="#" id="serialnumber_{{index}}" data-name="serialnumber"  class="  myeditable" data-index="{{index}}"   data-type="select" data-pk="1"  data-title="<?php echo H(lang('serial_number')); ?>">
                                   {{serialnumberText}}
                                </a>
                            </div>
                        {{else}}
                        <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                                
                                
                               {{#if  permissions.edit_serail_no}}
                                                        
                                <a href="#" id="serialnumber_{{index}}" data-name="serialnumber" data-index="{{index}}"  class="  myeditable"  data-type="text" data-pk="1"  data-title="<?php echo H(lang('serial_number')); ?>">
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

                        <div class="text-muted fs-7 fw-bold text-black" data-kt-table-widget-4="template_cost">
                                {{all_data.id_to_show_on_sale_interface_val}}
                        </div>
                    </div>
                    {{#notval permissions.hide_description_on_sales_and_recv  }}
                    <div class="col-md-6 mt-3">
                        <div class="text-gray-800 fs-7"><?php echo lang('description'); ?></div>
                        <div class="text-muted fs-7 fw-bold text-black" data-kt-table-widget-4="template_cost">
                            {{#greaterThanZero permissions.allow_alt_description }}
                        <a
                                href="#" id="description_{{index}}" class="xeditable-description  editable-click"
                                data-type="text" data-validate-number="true" data-index="{{index}}" data-pk="1"
                                data-name="description" data-value="{{description}}"
                                
                                data-title="<?= lang('description'); ?>">{{description}}</a>

                                {{else}}
                                <span>{{description}}</span>

                                {{/greaterThanZero}}

                        </div>
                    </div>
                {{/notval}}

                   

              



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
                                    <span class="badge badge-secondary">  <?= lang('Sub_Total'); ?>  : {{subtotal}}</span>
                                    <span class="badge badge-success">   <?= lang('Sub_Tax'); ?> : {{totaltax}}</span>
                                    <span class="badge badge-primary">   <?= lang('Total_Amount'); ?> : {{totalAmount}}</span> 
                                    <span class="badge badge-warning">   <?= lang('Total_Due'); ?>  : {{totaldue}}</span> 
                                    <!--end::Name-->  
                                </div>
                                <!--end::Link-->
                            </div>
                            <!--end::Info-->

                            <!--begin::Action-->                            
                            <a href="#" data-suspend-index="{{index}}"  class="btn btn-sm btn-primary unsuspend_offline" > <?= lang('Unsuspend'); ?> </a>                               
                            <!--end::Action-->  
                        </div>


        <!--end::Separator-->
</script>





<div id="kt_drawer_general_body_lg_container" style="display: none;">


  

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
                                                        <label class="form-label"><?= lang('Tax'); ?>:</label>

                                                        <input type="text" name="tax_names"
                                                            class="form-control mb-2 mb-md-0" placeholder="Name" />
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label class="form-label"> <?= lang('Percent'); ?>:</label>
                                                        <input type="hidden" name="tax_cumulatives" value="0">
                                                        <input type="text" name="tax_percents"
                                                            class="form-control mb-2 mb-md-0" placeholder="Percent" />
                                                    </div>

                                                    <div class="col-md-2">
                                                        <a href="javascript:;" data-repeater-delete
                                                            class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                            <i class="fa fa-trash text-danger"></i>
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
                                            <?= lang('Add'); ?>
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
<div class="modal fade" id="attributeModal" tabindex="-1" role="dialog" aria-labelledby="attributeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="attributeModalLabel"> <?= lang('Select_an_Option'); ?></h5>

            </div>
            <div class="modal-body">


                <!-- Options will be dynamically inserted here -->
                <div id="attributeOptions"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('Cancel'); ?></button>
                <button type="button" class="btn btn-primary" id="backAttribute"><?= lang('Back'); ?></button>
                <button type="button" class="btn btn-primary" id="nextAttribute"><?= lang('Next'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade look-up-receipt" id="choose_modifiers" role="dialog" aria-labelledby="lookUpReceipt"
    aria-hidden="true">
    <div class="modal-dialog customer-recent-sales">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label=<?php echo lang('close'); ?>><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="lookUpReceipt"><?php echo lang('modifiers'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <div id="modifiersOptions"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('Cancel'); ?></button>
                <button type="button" class="btn btn-primary" id="saveAttribute"><?= lang('Save'); ?></button>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<div class="modal fade " id="get_return_id" tabindex="-1" role="dialog" aria-labelledby="attributeModalLabel"
    aria-hidden="true" >
                                    <div class="modal-dialog customer-recent-sales">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" id="cancel_return"
                                                    aria-label=<?php echo lang('close'); ?>><span
                                                        aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="lookUpReceipt">
                                                    <?php echo lang('return') ?> </h4>
                                            </div>
                                            <div class="modal-body">
                                                <label><?php echo lang('sale_id') ?></label>
                                                <input type="text" id="return_sale_id" name="return_sale_id" class="form-control" placeholder="<?php echo lang('return_sale_id') ?>" >


                                            </div>
                                            <div class="modal-footer ">
                                          
                                           <button type="button" id="submit_return_sale" class="btn btn-primary"><?= lang('submit') ?>
                                                </button> 
                                        </div>
                                        </div>
                                    </div>
                                </div>
<?php $this->load->view("sales/offline/js/offline_js"); ?>

<?php


$this->cart->destroy();
$CI =& get_instance();
		if ($CI->session->userdata('sale'))
		{
            $CI->session->unset_userdata('sale');

        }

?>
<?php $this->load->view("partial/offline_footer"); ?>

