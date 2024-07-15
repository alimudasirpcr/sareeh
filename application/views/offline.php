<?php 

$this->load->view("partial/offline_header"); ?>

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
    <div class="alert alert-danger  hidden-print"><?php echo lang('offline');?></div>
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

                    <div id="saved_sales">
            <ul class="list-group saved_sales" id="saved_sales_list" style="list-style: none;">

            </ul>
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

    <div id="kt_drawer_example_basic" class="bg-white drawer drawer-end" data-kt-drawer="true"
        data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_drawer_suspend"
        data-kt-drawer-close="#kt_drawer_example_basic_close" data-kt-drawer-width="500px"
        style="width: 500px !important;">
        <div class="card border-0 shadow-none rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4"
                id="kt_app_layout_builder_header"
                style="background-image:url('<?= base_url(); ?>assets/css_good/media/misc/pattern-4.jpg')">

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-white flex-column m-0">
                    Save As
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

                <ul>
                    <li><a href="#" id="layaway_sale_button" class="text-danger"><i class="ion-pause"></i> Layaway</a>
                    </li>
                    <li><a href="#" id="estimate_sale_button"><i class="ion-help-circled"></i> Estimate</a></li>

                    <li><a href="#" class="additional_suspend_button" data-suspend-index="1"><i
                                class="ion-arrow-graph-up-right"></i> common_layaway</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="2"><i
                                class="ion-arrow-graph-up-right"></i> common_estimate</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="6"><i
                                class="ion-arrow-graph-up-right"></i> common_sale</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="15"><i
                                class="ion-arrow-graph-up-right"></i> hold_cart</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="4"><i
                                class="ion-arrow-graph-up-right"></i> Draft</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="5"><i
                                class="ion-arrow-graph-up-right"></i> order confirmed with 30% paid</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="7"><i
                                class="ion-arrow-graph-up-right"></i> sales layways one</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="8"><i
                                class="ion-arrow-graph-up-right"></i> sales layways two</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="9"><i
                                class="ion-arrow-graph-up-right"></i> sales layways three</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="10"><i
                                class="ion-arrow-graph-up-right"></i> sales layways four</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="11"><i
                                class="ion-arrow-graph-up-right"></i> sales layways five</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="12"><i
                                class="ion-arrow-graph-up-right"></i> sales layways six</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="13"><i
                                class="ion-arrow-graph-up-right"></i> sales layways seven</a></li>
                    <li><a href="#" class="additional_suspend_button" data-suspend-index="14"><i
                                class="ion-arrow-graph-up-right"></i> sales layways eight</a></li>

                </ul>

            </div>
        </div>
    </div>


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
                                    <a href="<?= base_url(); ?>sales/change_mode/store_account_payment/1"
                                        target="_self" id=""
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

                    <form action="<?= base_url(); ?>sales/add" id="add_item_form" class="form-inline"
                        autocomplete="off" method="post" accept-charset="utf-8">

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
                                        class="register-btn-text">Show Grid</span></a> <a
                                    href="<?= base_url(); ?>#" class="none hide-grid" tabindex="-1"
                                    title="Hide Grid"><i class="icon ti-layout"></i> <span
                                        class="register-btn-text">Hide Grid</span></a> </span>
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
                                    href="<?= base_url(); ?>#" class="none hide-grid" tabindex="-1"
                                    title="Hide Grid"><i class="icon ti-layout"></i> Hide Grid</a> </span>
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


                    <form action="<?= base_url(); ?>sales/cancel_sale" id="cancel_sale_form" autocomplete="off"
                        class="d-flex    h-75px" method="post" accept-charset="utf-8">


                        <div class="flex-column bg-primary p-3 flex-center w-75px h-50px me-1  d-flex"
                            id="kt_drawer_suspend" data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip"
                            data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover"
                            data-bs-original-title="Metronic Builder" data-kt-initialized="1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
                            <span class="svg-icon  svg-icon-3x mt-3">
                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/general/gen056.svg-->
                                <svg class="pos-top-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.0077 19.2901L12.9293 17.5311C12.3487 17.1993 11.6407 17.1796 11.0426 17.4787L6.89443 19.5528C5.56462 20.2177 4 19.2507 4 17.7639V5C4 3.89543 4.89543 3 6 3H17C18.1046 3 19 3.89543 19 5V17.5536C19 19.0893 17.341 20.052 16.0077 19.2901Z"
                                        fill="currentColor"></path>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <!--end::Svg Icon-->
                            <div class=" py-2">
                                Save As </div>
                        </div>
                        <div class="flex-column bg-primary  p-3 flex-center w-75px h-50px me-1  d-flex"
                            id="cancel_sale_button">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
                            <span class="svg-icon svg-icon-3x mt-3">
                                <svg class="pos-top-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.3" x="4" y="11" width="12" height="2" rx="1" fill="currentColor">
                                    </rect>
                                    <path
                                        d="M5.86875 11.6927L7.62435 10.2297C8.09457 9.83785 8.12683 9.12683 7.69401 8.69401C7.3043 8.3043 6.67836 8.28591 6.26643 8.65206L3.34084 11.2526C2.89332 11.6504 2.89332 12.3496 3.34084 12.7474L6.26643 15.3479C6.67836 15.7141 7.3043 15.6957 7.69401 15.306C8.12683 14.8732 8.09458 14.1621 7.62435 13.7703L5.86875 12.3073C5.67684 12.1474 5.67684 11.8526 5.86875 11.6927Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z"
                                        fill="currentColor"></path>
                                </svg>
                                <!--end::Svg Icon-->


                            </span>
                            <!--end::Svg Icon-->
                            <div class=" py-2">Clear</div>
                        </div>



                        <div class="flex-column bg-primary p-3 flex-center w-75px h-50px ddd  d-flex"
                            id="advance_details">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
                            <span class="svg-icon svg-icon-3x mt-3">
                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/general/gen045.svg-->
                                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg class="pos-top-icon" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                            fill="currentColor"></rect>
                                        <rect x="11" y="17" width="7" height="2" rx="1" transform="rotate(-90 11 17)"
                                            fill="currentColor"></rect>
                                        <rect x="11" y="9" width="2" height="2" rx="1" transform="rotate(-90 11 9)"
                                            fill="currentColor"></rect>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <!--end::Svg Icon-->
                            <div class=" py-2">
                                Add Info </div>
                        </div>

                    </form>




                </div>

            </div>
        </div>
        <div class="d-flex">
            <div class="w-100px bg-black pos-sidebar">
                <!--begin::Sidebar menu-->
                <div class="app-sidebar-menu app-sidebar-menu-arrow hover-scroll-overlay-y my-5 my-lg-5 px-3  pos-menu"
                    id="kt_app_sidebar_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto"
                    data-kt-scroll-dependencies="#kt_app_sidebar_toolbar, #kt_app_sidebar_footer"
                    data-kt-scroll-offset="0" style="height: 544px;">
                    <!--begin::Menu-->
                    <div class="menu menu-column menu-sub-indention menu-active-bg fw-semibold     "
                        id="#kt_sidebar_menu" data-kt-menu="true">
                        <!--begin:Menu item-->



                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" class="menu-item   ">








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
                                                fill="currentColor"></path>
                                            <path opacity="0.3"
                                                d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span class="menu-title w-100">Pos Builder</span>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                            <span class=" menu-link ">
                                <span id="kt_drawer_completed_sales" class="menu-icon w-100 "
                                    data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip"
                                    data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover"
                                    data-bs-original-title="Metronic Builder" data-kt-initialized="1">
                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/text/txt001.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2x  w-100">
                                        <span id="offline_sync_spining"  class="glyphicon glyphicon-refresh spinning"></span>
                                        <span class="menu-title w-100">Saved Sales</span>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                            <div class="menu-item">
                                <a class=" menu-link " href="<?= base_url(); ?>sales/sales_list">
                                    <span class="menu-icon  w-100 ">
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/arrows/arr043.svg-->
                                        <span class="svg-icon svg-icon-muted svg-icon-2x w-100 "><svg width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                    d="M21 22H12C11.4 22 11 21.6 11 21V3C11 2.4 11.4 2 12 2H21C21.6 2 22 2.4 22 3V21C22 21.6 21.6 22 21 22Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M19 11H6.60001V13H19C19.6 13 20 12.6 20 12C20 11.4 19.6 11 19 11Z"
                                                    fill="currentColor"></path>
                                                <path opacity="0.3"
                                                    d="M6.6 17L2.3 12.7C1.9 12.3 1.9 11.7 2.3 11.3L6.6 7V17Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <span class="menu-title w-100">Back To Sale</span>
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
                                        Quick Access </strong>
                                </span>
                                <span class="fw-bold menu-heading fs-7"
                                    style="color: var(--bs-app-light-sidebar-logo-icon-custom-color);font-family: Inter, sans-serif;font-style: italic;font-weight: bold;"
                                    onclick="show_quick_access()">&nbsp; &nbsp;
                                    Edit </span>
                            </div>
                        </div>


                        <div class="menu-item">
                            <a class="menu-link  " href="<?= base_url(); ?>sales">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/art/art006.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M22 19V17C22 16.4 21.6 16 21 16H8V3C8 2.4 7.6 2 7 2H5C4.4 2 4 2.4 4 3V19C4 19.6 4.4 20 5 20H21C21.6 20 22 19.6 22 19Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M20 5V21C20 21.6 19.6 22 19 22H17C16.4 22 16 21.6 16 21V8H8V4H19C19.6 4 20 4.4 20 5ZM3 8H4V4H3C2.4 4 2 4.4 2 5V7C2 7.6 2.4 8 3 8Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </a>
                        </div>



                        <div class="menu-item">
                            <a class="menu-link  " href="<?= base_url(); ?>items">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/general/gen002.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M4.05424 15.1982C8.34524 7.76818 13.5782 3.26318 20.9282 2.01418C21.0729 1.98837 21.2216 1.99789 21.3618 2.04193C21.502 2.08597 21.6294 2.16323 21.7333 2.26712C21.8372 2.37101 21.9144 2.49846 21.9585 2.63863C22.0025 2.7788 22.012 2.92754 21.9862 3.07218C20.7372 10.4222 16.2322 15.6552 8.80224 19.9462L4.05424 15.1982ZM3.81924 17.3372L2.63324 20.4482C2.58427 20.5765 2.5735 20.7163 2.6022 20.8507C2.63091 20.9851 2.69788 21.1082 2.79503 21.2054C2.89218 21.3025 3.01536 21.3695 3.14972 21.3982C3.28408 21.4269 3.42387 21.4161 3.55224 21.3672L6.66524 20.1802L3.81924 17.3372ZM16.5002 5.99818C16.2036 5.99818 15.9136 6.08615 15.6669 6.25097C15.4202 6.41579 15.228 6.65006 15.1144 6.92415C15.0009 7.19824 14.9712 7.49984 15.0291 7.79081C15.0869 8.08178 15.2298 8.34906 15.4396 8.55884C15.6494 8.76862 15.9166 8.91148 16.2076 8.96935C16.4986 9.02723 16.8002 8.99753 17.0743 8.884C17.3484 8.77046 17.5826 8.5782 17.7474 8.33153C17.9123 8.08486 18.0002 7.79485 18.0002 7.49818C18.0002 7.10035 17.8422 6.71882 17.5609 6.43752C17.2796 6.15621 16.8981 5.99818 16.5002 5.99818Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M4.05423 15.1982L2.24723 13.3912C2.15505 13.299 2.08547 13.1867 2.04395 13.0632C2.00243 12.9396 1.9901 12.8081 2.00793 12.679C2.02575 12.5498 2.07325 12.4266 2.14669 12.3189C2.22013 12.2112 2.31752 12.1219 2.43123 12.0582L9.15323 8.28918C7.17353 10.3717 5.4607 12.6926 4.05423 15.1982ZM8.80023 19.9442L10.6072 21.7512C10.6994 21.8434 10.8117 21.9129 10.9352 21.9545C11.0588 21.996 11.1903 22.0083 11.3195 21.9905C11.4486 21.9727 11.5718 21.9252 11.6795 21.8517C11.7872 21.7783 11.8765 21.6809 11.9402 21.5672L15.7092 14.8442C13.6269 16.8245 11.3061 18.5377 8.80023 19.9442ZM7.04023 18.1832L12.5832 12.6402C12.7381 12.4759 12.8228 12.2577 12.8195 12.032C12.8161 11.8063 12.725 11.5907 12.5653 11.4311C12.4057 11.2714 12.1901 11.1803 11.9644 11.1769C11.7387 11.1736 11.5205 11.2583 11.3562 11.4132L5.81323 16.9562L7.04023 18.1832Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </a>
                        </div>


                        <div class="menu-item">
                            <a class="menu-link  " href="<?= base_url(); ?>receivings">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/abstract/abs027.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </a>
                        </div>


                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link   " href="<?= base_url(); ?>customers">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/communication/com013.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2x rotate-0"><svg width="24"
                                            height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z"
                                                fill="currentColor"></path>
                                            <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4"
                                                fill="currentColor"></rect>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </a>
                        </div>




                    </div>
                </div>
            </div>
            <div class="w-100">
                <div id="sale-grid-big-wrapper" class="clearfix register ">
                    <div class="clearfix"  style="" id="category_item_selection_wrapper">

                    <div  class="horizontal-scroll h-120px " >
                        <ul id="category_item_selection" class="scrollable-list register-grid nav nav-pills nav-pills-custom  p-0 mt-1 m-0">

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
										href="<?= base_url(); ?>/home/view_item_modal/6?redirect=sales"
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



										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">Tax</div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
												<a href="<?= base_url(); ?>/sales/edit_taxes_line/0" class=""
													id="edit_taxes" data-target="#kt_drawer_general"
													data-target-title="Edit Taxes" data-target-width="lg">Edit Taxes</a>
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

                        0 </div>
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
                                        class="form-control form-control-solid">
                                </div>

                                <div class="mb-10">
                                    <label for="exampleFormControlInput1" class=" form-label">Discount Fixed: <span
                                            id="TEST"></span></label>
                                    <input type="number" id="discount_all_flat" value=""
                                        class="form-control form-control-solid">
                                </div>



                                <button type="button"
                                    class="btn btn-primary w-100px update_discount_details">Update</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="tab-content" id="myTabContent">

            <div class="register-box register-right">

                <!-- Sale Top Buttons  -->


                <!-- If customer is added to the sale -->

                <div class="customer-form d-flex flex-wrap">

                    <!-- if the customer is not set , show customer adding form -->
                    <form action="<?= base_url(); ?>sales/select_customer" id="select_customer_form"
                        autocomplete="off" class="form-inline w-100 mb-2" method="post" accept-charset="utf-8">
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
                                        href="<?= base_url(); ?>sales/customer_recent_sales/40"
                                        data-toggle="modal" data-target="#myModal"
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

                                <a onclick="event.preventDefault();" data-dismiss="true" data-placement="bottom"
                                    data-toggle="popover" data-html="true" title="" href="#"
                                    class="btn btn-sm btn-light me-2 p-2" id="share-popover"
                                    data-original-title="Send Receipt Via">

                                    <i class="fa-solid fa-share"></i>
                                    <!--end::Svg Icon-->
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Share</span>
                                    <!--end::Indicator label-->
                                </a>
                                <script>
                                $(function() {

                                    $('#share-popover').popover({
                                        container: 'body',
                                        template: '<div class="popover fade bottom in bg-dark border-dark min-w-300px " role="tooltip"><div class="arrow" style="left: 25%;"></div><h3 class="popover-header"></h3><div class="popover-body">' +
                                            $('#popover-content').html() + '</div></div>',
                                        content: function() {
                                            return $('#popover-content').html();
                                        }
                                    })


                                })
                                </script>


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


                                        <a href="<?= base_url(); ?>sales/view_delivery_modal/"
                                            class="menu-link px-3 " id="open_delivery_modal" data-toggle="modal"
                                            data-target="#myModal"> <i class="ion-android-car"></i>Delivery</a>

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

                        <div class="fs-1 fw-bold counted text-center">

                            0 </div>
                    </span>


                    <span class="svg-icon   svg-icon-primary svg-icon-2x">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>
                        </svg>
                    </span>




                    <div
                        class="sub-total list-group-item bg-light  border border-light border-dashed rounded min-w-125px h-80px py-3 px-4 ">
                        <div class="fw-semibold fs-6 text-dark-400">Sub Total (OMR) <a
                                href="<?= base_url(); ?>/sales/edit_taxes/" class="" id="edit_taxes"
                                data-target="#kt_drawer_general" data-target-title="Edit Taxes"
                                data-target-width="lg"><i class="icon ti-pencil-alt"></i></a>
                            <i class="fonticon-content-marketing" data-dismiss="true" data-placement="top"
                                data-html="true" title="" id="tax-paid-popover" data-original-title="Tax"></i>
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
                                Tax (OMR) </div>
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


                                <i class="fonticon-content-marketing"  title="" id="kt_drawer_payments_list"></i>


                              
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


                                    <a tabindex="-1" href="#" class="none active text-light  text-hover-primary"
                                        title="Sales Sale" id="select-mode-3" data-target="#" data-toggle="dropdown"
                                        aria-haspopup="true" role="button" aria-expanded="false"><i
                                            class="fa fa-money-bill"></i>
                                        Cash </a>



                                    <ul class="dropdown-menu sales-dropdown">
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

                                    <a href="#" class="" id="finish_sale_button">Complete Sale</a>
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
					                <div class="invoice-footer-heading"><?php echo lang('tax','',array(),TRUE); ?></div>
					            </div>
					            <div class="col-md-2 col-sm-2 col-xs-4">
					                <div class="invoice-footer-value">
						
										{{total_tax}}		
										
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
    <li>
    <div class="bullet w-8px h-6px rounded-2 bg-primary me-3"></div> <?php echo lang('sale'); ?> <strong>{{index}}</strong> <a href="#" data-index={{index}} class='view_saved_sale text-danger fw-bold me-1'><?php echo lang('recp');?> </a> | <a href="#" data-index={{index}} class='edit_saved_sale text-danger fw-bold me-1'><?php echo lang('edit');?> </a> | <a href="#" data-index={{index}} class='delete_saved_sale text-danger fw-bold me-1'><?php echo lang('delete');?> </a><?php echo lang('total'); ?>: {{total}}, {{customer}}, <?php echo lang('items_sold');?>: {{items_sold}}
    <div class="separator separator-dashed my-4"></div>
	</li>
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



    <tbody class="fw-bold text-gray-600" data-line="2">

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

        <a tabindex="-1" href="<?= base_url(); ?>/home/view_item_modal/6?redirect=sales"
            data-target="#kt_drawer_general" data-target-title="View Item"
            data-target-width="xl" class="register-item-name text-gray-800 text-hover-primary "
            data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse"
            data-bs-placement="top" title="{{name}}">{{name}}</a>
    </td>
    <td class="text-center fs-6">
        

            <a href="#" id="price_{{index}}" class="xeditable xeditable-price editable" data-validate-number="true" data-type="text" data-pk="1" data-name="price" data-index="{{index}}" data-title="Price">{{to_currency_no_money price}}</a>									 


    </td>
    <td class="text-center fs-6">
        <button type="button" onclick="inc_de_qty('2', -1)"
            class="btn w-25px h-25px  btn-icon rounded-circle btn-light"><i
                class="bi bi-dash fs-1"></i></button>
      
        <a href="#" id="quantity_{{index}}" class="xeditable edit-quantity " data-type="text"  data-validate-number="true"  data-pk="1" data-name="quantity" data-index="{{index}}" data-title="Qty.">{{to_quantity quantity}}</a>
	
        
        <button type="button" onclick="inc_de_qty('2', 1)"
            class="btn w-25px h-25px  btn-icon rounded-circle btn-light"> <i
                class="bi bi-plus fs-1"></i></button>
    </td>

    <td class="text-center fs-6" style="padding-right:10px">

        <a href="#" id="total_{{index}}" class=" editable editable-click">{{to_currency_no_money line_total}}	</a>


        <a href="<?= base_url(); ?>/sales/delete_item/{{index}}" data-cart-index="{{index}}" class="delete-item pull-right"
            tabindex="-1" data-id="{{index}}"><i class="icon ion-android-cancel"></i></a>

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



            <div class="col-md-3 mt-3">
                <div class="text-gray-800 fs-7">Tax</div>
                <div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
                    <a href="<?= base_url(); ?>/sales/edit_taxes_line/0" class=""
                        id="edit_taxes" data-target="#kt_drawer_general"
                        data-target-title="Edit Taxes" data-target-width="lg">Edit Taxes</a>
                </div>
            </div>

        </div>
    </td>
</tr>

</tbody>



 
	
</script>

<script>
function getPromoPrice(promo_price, start_date, end_date) {
    if (parseFloat(promo_price) && start_date == null && end_date == null) {
        return parseFloat(promo_price);
    } else if (parseFloat(promo_price) && start_date != null && end_date != null) {
        var today = moment(new Date().toYMD());
        if (today.isBetween(start_date, end_date) || today.isSame(start_date) || today.isSame(end_date)) {
            return parseFloat(promo_price);
        }
    }

    return null;
}
(function() {
    Date.prototype.toYMD = Date_toYMD;

    function Date_toYMD() {
        var year, month, day;
        year = String(this.getFullYear());
        month = String(this.getMonth() + 1);
        if (month.length == 1) {
            month = "0" + month;
        }
        day = String(this.getDate());
        if (day.length == 1) {
            day = "0" + day;
        }
        return year + "-" + month + "-" + day;
    }
})();

Handlebars.registerHelper("to_currency_no_money", function(val) {
    return to_currency_no_money(val);
});

Handlebars.registerHelper("to_quantity", function(val) {
    return to_quantity(val);
});

Handlebars.registerHelper('select', function(value, options) {
    var $el = $('<select />').html(options.fn(this));
    $el.find('[value="' + value + '"]').attr({
        'selected': 'selected'
    });
    return $el.html();
});
Handlebars.registerHelper('greaterThanZero', function(value, options) {
  if (value > 0) {
    return options.fn(this);
  } else {
    return options.inverse(this);
  }
});
Handlebars.registerHelper("checked", function(condition) {
    return (condition) ? "checked" : "";
});

var cart_item_template = Handlebars.compile(document.getElementById("cart-item-template").innerHTML);
var cart_payment_template = Handlebars.compile(document.getElementById("cart-payment-template").innerHTML);
var saved_sale_template = Handlebars.compile(document.getElementById("saved-sale-template").innerHTML);
var sale_receipt_template = Handlebars.compile(document.getElementById("sale-receipt-template").innerHTML);
var list_item_template = Handlebars.compile(document.getElementById("list-item-template").innerHTML);
var list_category_template = Handlebars.compile(document.getElementById("list-category-template").innerHTML);
//data structures for cart

var current_edit_index = null;
var cart = JSON.parse(localStorage.getItem('cart')) || {};

if (typeof cart.items == 'undefined') {
    cart['items'] = [];
}
if (typeof cart.payments == 'undefined') {
    cart['payments'] = [];
}

if (typeof cart.customer == 'undefined') {
    cart['customer'] = {};
}


try {
    var db_customers = new PouchDB('phppos_customers', {
        revs_limit: 1
    });
    var db_items = new PouchDB('phppos_items', {
        revs_limit: 1
    });
    var db_category = new PouchDB('phppos_category', {
        revs_limit: 1
    });
} catch (exception_var) {

}
$(document).on('click', '.delete_saved_sale', function(event) {
    event.preventDefault();

    var delete_index = $(this).data('index');
    bootbox.confirm(<?php echo json_encode(lang('sales_confirm_finish_sale')); ?>, function(result) {
        if (result) {
            var allSales = JSON.parse(localStorage.getItem("sales")) || [];
            allSales.splice(delete_index, 1);
            localStorage.setItem("sales", JSON.stringify(allSales));
            renderUi();

        }
    });
});



$(document).on('click', '.view_saved_sale', function(event) {
    event.preventDefault();

    var allSales = JSON.parse(localStorage.getItem("sales")) || [];

    displayReceipt(allSales[$(this).data('index')]);
});

$(document).on('click', '.edit_saved_sale', function(event) {
    event.preventDefault();
    var allSales = JSON.parse(localStorage.getItem("sales")) || [];
    cart = allSales[$(this).data('index')];
    current_edit_index = $(this).data('index');
    renderUi();
});

$(document).on("click", '#cancel_sale_button', function(event) {
    event.preventDefault();
    cart = {};
    cart['items'] = [];
    cart['payments'] = [];
    cart['customer'] = {};
    current_edit_index = null;

    renderUi();
});

$(document).on("click", '#finish_sale_button', function(e) {
    e.preventDefault();
    bootbox.confirm(<?php echo json_encode(lang('sales_confirm_finish_sale')); ?>, function(result) {
        if (result) {
            //Reset cart
            cart = {};
            cart['items'] = [];
            cart['payments'] = [];
            cart['customer'] = {};

            var sale = localStorage.getItem('cart');
            displayReceipt(JSON.parse(sale));
            //Save sales
            var allSales = JSON.parse(localStorage.getItem("sales")) || [];

            if (current_edit_index !== null) {
                allSales[current_edit_index] = JSON.parse(sale);
            } else {
                allSales.push(JSON.parse(sale));
            }
            localStorage.setItem("sales", JSON.stringify(allSales));

            current_edit_index = null;
            renderUi();
        }
    });

});

$(document).on("click", '.modifier', function(event) {
    var index = $(this).data('index');

    if (typeof cart['items'][index]['selected_item_modifiers'] == 'undefined') {
        cart['items'][index]['selected_item_modifiers'] = {};
    }
    cart['items'][index]['selected_item_modifiers'][$(this).val()] = $(this).prop('checked');

    renderUi();
});

$(document).on("change", '.variation', function(event) {

    var price = false;
    var variation_name = '';
    var index = $(this).data('index');
    if (typeof index !== 'undefined') {
        for (var k = 0; k < cart['items'][index]['variations'].length; k++) {
            if (cart['items'][index]['variations'][k]['variation_id'] == $(this).val()) {
                if (cart['items'][index]['variations'][k]['unit_price']) {
                    price = cart['items'][index]['variations'][k]['unit_price'];

                    var promo_price = cart['items'][index]['variations'][k]['promo_price'];
                    var start_date = cart['items'][index]['variations'][k]['start_date']
                    var end_date = cart['items'][index]['variations'][k]['end_date']

                    var computed_promo_price = getPromoPrice(promo_price, start_date, end_date)

                    if (computed_promo_price) {
                        price = computed_promo_price;
                    }
                }

                variation_name = cart['items'][index]['variations'][k]['name'];

                break;
            }
        }

        if (price) {
            cart['items'][index]['price'] = price;
        } else {
            cart['items'][index]['price'] = $(this).data('orig-price');
        }

        cart['items'][index]['selected_variation'] = $(this).val();
        cart['items'][index]['selected_variation_name'] = variation_name;
        renderUi();

    }

});

$("#select_customer_form").submit(function(e) {
    e.preventDefault();

});
$("#add_item_form").submit(function(e) {
    e.preventDefault();

    var search = $("#item").val().toLocaleLowerCase();
    db_items.find({
        selector: {
            "$or": [{
                    item_id: search
                },
                {
                    product_id: search
                },
                {
                    item_number: search
                }
            ]
        },
        fields: ['_id', 'name', 'description', 'unit_price', 'promo_price', 'start_date', 'end_date',
            'category', 'quantity', 'item_id', 'variations', 'modifiers', 'taxes', 'tax_included'
        ]
    }, function(err, result) {
        if (err) {
            return console.log(err);
        }

        var results = result.docs;
        if (results.length) {
            var item = results[0];

            var item_id = item.item_id;
            var item_name = item.name;
            var item_description = item.description;
            var quantity = 1;
            var unit_price = to_currency_no_money(item.unit_price);
            var promo_price = to_currency_no_money(item.promo_price);
            var start_date = item.start_date;
            var end_date = item.end_date;

            var selling_price = parseFloat(unit_price);


            var computed_promo_price = getPromoPrice(promo_price, start_date, end_date)

            if (computed_promo_price) {
                selling_price = computed_promo_price;
            }

            selling_price = to_currency_no_money(selling_price);

            var variations = item.variations;
            var modifiers = item.modifiers;
            var taxes = item.taxes;
            var tax_included = item.tax_included;
            addItem({
                name: item_name,
                description: item_description,
                item_id: item_id,
                quantity: 1,
                price: selling_price,
                orig_price: selling_price,
                discount_percent: 0,
                variations: variations,
                modifiers: modifiers,
                taxes: taxes,
                tax_included: tax_included
            });

            $("#item").val("");
            renderUi();
        }
    });
});

//Refactor for performance based on https://stackoverflow.com/questions/58999498/pouch-db-fast-search

$("#customer").autocomplete({
    source: async function(request, response) {
        var default_image = '<?php echo base_url(); ?>' + 'assets/img/user.png';

        var search = escapeRegExp($("#customer").val() ? $("#customer").val() : ' ').toLocaleLowerCase();

        var descending = false;

        const search_results = await db_customers.query('search', {
            include_docs: true,
            limit: 20,
            reduce: false,
            descending: descending,
            startkey: descending ? search + '\uFFF0' : search,
            endkey: descending ? search : search + '\uFFF0'
        });

        var results = search_results.rows;
        var db_response = [];
        for (var k = 0; k < results.length; k++) {
            var row = results[k].doc;
            var customer = {
                image: default_image,
                label: row.first_name + ' ' + row.last_name,
                value: row.person_id,
                phone_number: row.phone_number,
                email: row.email,
                balance: row.balance
            };
            db_response.push(customer);
        }
        response(db_response);
    },
    delay: 500,
    autoFocus: false,
    minLength: 0,
    select: function(event, ui) {
        var person_id = ui.item.value;
        var customer_name = ui.item.label;
        var phone_number = ui.item.phone_number;
        var email = ui.item.email;
        var balance = ui.item.balance;

        cart['customer']['person_id'] = person_id;
        cart['customer']['customer_name'] = customer_name;
        cart['customer']['phone_number'] = phone_number;
        cart['customer']['email'] = email;
        cart['customer']['balance'] = balance;
        renderUi();
        $(this).val('');
        return false;

    },

}).data("ui-autocomplete")._renderItem = function(ul, item) {
    return $("<li class='customer-badge suggestions'></li>")
        .data("item.autocomplete", item)
        .append('<a class="suggest-item"><div class="avatar">' +
            '<img src="' + item.image + '" alt="">' +
            '</div>' +
            '<div class="details">' +
            '<div class="name">' +
            item.label +
            '</div>' +
            '<span class="email">' + '</span>' +
            '</div></a>')
        .appendTo(ul);
};
async function getDocumentById(docId) {
    try {
        const doc = await db_items.get(docId + "_item"); // Fetch the document by its ID
        // console.log('Document found:', doc);
        newitem = doc;
        var item_id = newitem.item_id;
        var item_name = newitem.name + ' - ' + to_currency_no_money(newitem.unit_price);
        var item_description = newitem.description;
        var quantity = 1;
        var variations = newitem.variations;
        var modifiers = newitem.modifiers;
        var taxes = newitem.taxes;
        var tax_included = newitem.tax_included;
        var unit_price = newitem.unit_price;
        var promo_price = newitem.promo_price;
        var start_date = newitem.start_date;
        var end_date = newitem.end_date;

        var selling_price = parseFloat(unit_price);

        var computed_promo_price = getPromoPrice(promo_price, start_date, end_date)

        if (computed_promo_price) {
            selling_price = computed_promo_price;
        }

        selling_price = to_currency_no_money(selling_price);

        console.log({
            name: item_name,
            description: item_description,
            item_id: item_id,
            quantity: 1,
            price: selling_price,
            orig_price: selling_price,
            discount_percent: 0,
            variations: variations,
            modifiers: modifiers,
            taxes: taxes,
            tax_included: tax_included
        });

        addItem({
            name: item_name,
            description: item_description,
            item_id: item_id,
            quantity: 1,
            price: selling_price,
            orig_price: selling_price,
            discount_percent: 0,
            variations: variations,
            modifiers: modifiers,
            taxes: taxes,
            tax_included: tax_included
        });
        renderUi();
    } catch (error) {
        console.error('Error fetching document:', error);
        if (error.name === 'not_found') {
            console.error('Document not found');
        }
    }
}
async function getAllData(category = false) {
    $('#category_item_selection_wrapper_new').html('');
    try {
        const allDocs = await db_items.allDocs({
            include_docs: true, // Include document contents
            attachments: true // Include attachments if there are any
        });

        results = allDocs.rows;

         console.log('all items', results);


        var db_response = [];

        for (var k = 0; k < results.length; k++) {
           
            var row = results[k].doc;
            if(category){
              
                 if(category!=row.category_id){
                    continue;
                 }
            }
            if (typeof(row.name) == "undefined") {
                continue;
            }
            if (typeof(row.img_src) !== "undefined") {
                default_image = row.img_src;
            }

            var item = {
                tax_included: row.tax_included,
                taxes: row.taxes,
                variations: row.variations,
                modifiers: row.modifiers,
                description: row.description,
                unit_price: to_currency_no_money(row.unit_price),
                promo_price: row.promo_price,
                start_date: row.start_date,
                end_date: row.end_date,
                image: default_image,
                label: row.name + ' - ' + to_currency_no_money(row.unit_price),
                category: row.category,
                quantity: to_quantity(row.quantity),
                value: row.item_id
            };
            $('#category_item_selection_wrapper_new').append(list_item_template(item));




        }

        $('.item_parent_class').on('click', function() {

            var value = $(this).data('id');
            getDocumentById(value);

        });

    } catch (error) {
        console.error('Error fetching documents:', error);
    }
}

// Call the function to fetch all data
getAllData();




// getAllData(15);


async function fetchAndDisplayCategories(categoryId) {
    console.log('Fetching categories', categoryId+'_category');
    try {
        s = categoryId+'_category';
        const response = await db_category.get(s);
        const subCategories = response.sub_categories_list || [];

        var subCategoryItems = [];
        for (let i = 0; i < subCategories.length; i++) {
            let subCategoryDoc = await db_category.get(subCategories[i]);
            let subItem = {
                image: subCategoryDoc.img_src || default_image, // Use the default_image if img_src is not available
                name: subCategoryDoc.name,
                value: subCategoryDoc._id.replace('_category', ''),
                default_image: subCategoryDoc.img_src || default_image,
                sub_categories: subCategoryDoc.sub_categories,
                items_count: subCategoryDoc.items_count,
                sub_categories_list: subCategoryDoc.sub_categories_list,
            };
            subCategoryItems.push(subItem);
            // Recursive call if there are more subcategories
            if (subCategoryDoc.sub_categories_list && subCategoryDoc.sub_categories_list.length > 0) {
                await fetchAndDisplayCategories(subCategoryDoc._id);
            }
        }
        
        // Append subcategories or update the UI
        $('#sub_category_container').empty(); // Clear previous subcategories
        subCategoryItems.forEach(item => {
            $('#sub_category_container').append(list_category_template(item));
        });
    } catch (error) {
        console.error('Error fetching subcategories:', error);
    }
}




async function getAllCategories() {
    try {
        const allDocs = await db_category.allDocs({
            include_docs: true, // Include document contents
            attachments: true // Include attachments if there are any
        });

        results = allDocs.rows;

        console.log('results', results);


        var db_response = [];

        for (var k = 0; k < results.length; k++) {
            var row = results[k].doc;

            if (typeof(row.name) == "undefined") {
                continue;
            }
            if (typeof(row.img_src) !== "undefined") {
                default_image = row.img_src;
            }

            var item = {
               
                image: default_image,
                name: row.name ,
                value:  row._id.replace('_category', ''),
                default_image: default_image,
                sub_categories: row.sub_categories,
                items_count: row.items_count,
                sub_categories_list: row.sub_categories_list,
            };
            $('#category_item_selection').append(list_category_template(item));




        }
        $(".top_category").on('click', function(event) {
            event.preventDefault();
            var categoryId = $(this).data('category_id');
            var categoryCount = $(this).data('category_count');

            $(this).addClass('selected-holder').siblings().removeClass('selected-holder');

            if (categoryCount > 0) {

               fetchAndDisplayCategories(categoryId);
            }
        });



        $('.item_parent_class').on('click', function() {

            var value = $(this).data('id');
            getDocumentById(value);

        });

    } catch (error) {
        console.error('Error fetching documents:', error);
    }
}

// Call the function to fetch all data
getAllCategories();

//Refactor for performance based on https://stackoverflow.com/questions/58999498/pouch-db-fast-search





$("#item").autocomplete({
    source: async function(request, response) {
        var default_image = '<?php echo base_url(); ?>' + 'assets/img/item.png';



        var search = escapeRegExp($("#item").val() ? $("#item").val() : ' ').toLocaleLowerCase();

        var descending = false;

        const search_results = await db_items.query('search', {
            include_docs: true,
            limit: 20,
            reduce: false,
            descending: descending,
            startkey: descending ? search + '\uFFF0' : search,
            endkey: descending ? search : search + '\uFFF0'
        });

        var results = search_results.rows;
        var db_response = [];




        for (var k = 0; k < results.length; k++) {
            var row = results[k].doc;
            if (typeof(row.img_src) !== "undefined") {
                default_image = row.img_src;
            }

            console.log("row.img_src", row.img_src);
            var item = {
                tax_included: row.tax_included,
                taxes: row.taxes,
                variations: row.variations,
                modifiers: row.modifiers,
                description: row.description,
                unit_price: to_currency_no_money(row.unit_price),
                promo_price: row.promo_price,
                start_date: row.start_date,
                end_date: row.end_date,
                image: default_image,
                label: row.name + ' - ' + to_currency_no_money(row.unit_price),
                category: row.category,
                quantity: to_quantity(row.quantity),
                value: row.item_id
            };
            db_response.push(item);
        }
        response(db_response);


    },
    delay: 500,
    autoFocus: false,
    minLength: 0,
    select: function(event, ui) {

        console.log("sss", ui.item);
        var item_id = ui.item.value;
        var item_name = ui.item.label;
        var item_description = ui.item.description;
        var quantity = 1;
        var variations = ui.item.variations;
        var modifiers = ui.item.modifiers;
        var taxes = ui.item.taxes;
        var tax_included = ui.item.tax_included;
        var unit_price = ui.item.unit_price;
        var promo_price = ui.item.promo_price;
        var start_date = ui.item.start_date;
        var end_date = ui.item.end_date;

        var selling_price = parseFloat(unit_price);

        var computed_promo_price = getPromoPrice(promo_price, start_date, end_date)

        if (computed_promo_price) {
            selling_price = computed_promo_price;
        }

        selling_price = to_currency_no_money(selling_price);

        addItem({
            name: item_name,
            description: item_description,
            item_id: item_id,
            quantity: 1,
            price: selling_price,
            orig_price: selling_price,
            discount_percent: 0,
            variations: variations,
            modifiers: modifiers,
            taxes: taxes,
            tax_included: tax_included
        });
        renderUi();
        $(this).val('');
        return false;
    },
}).data("ui-autocomplete")._renderItem = function(ul, item) {
    return $("<li class='item-suggestions'></li>")
        .data("item.autocomplete", item)
        .append('<a class="suggest-item"><div class="item-image symbol symbol-50px">' +
            '<img src="' + item.image + '" alt="">' +
            '</div>' +
            '<div class="details">' +
            '<div class="name">' +
            item.label +
            '</div>' +
            '<span class="attributes">' + '<?php echo lang("category"); ?>' + ' : <span class="value">' + (item
                .category ? item.category : <?php echo json_encode(lang('none')); ?>) + '</span></span>' +
            <?php if ($this->Employee->has_module_action_permission('items', 'see_item_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>(
                typeof item.quantity !== 'undefined' && item.quantity !== null ? '<span class="attributes">' +
                '<?php echo lang("quantity"); ?>' + ' <span class="value">' + item.quantity + '</span></span>' : ''
            ) +
            <?php } ?>(item.attributes ? '<span class="attributes">' + '<?php echo lang("attributes"); ?>' +
                ' : <span class="value">' + item.attributes + '</span></span>' : '') +

            '</div>')
        .appendTo(ul);
};

function selectPayment(e) {
    e.preventDefault();
    $('#payment_types').val($(this).data('payment'));
    $('.select-payment').removeClass('active');
    $(this).addClass('active');
    $("#amount_tendered").focus();
    $("#amount_tendered").attr('placeholder', '');
}

function renderUi() {

    $("#saved_sales_list").empty();


    var saved_sales = JSON.parse(localStorage.getItem('sales')) || {};

    for (var k = saved_sales.length - 1; k >= 0; k--) {
        var saved_sale = saved_sales[k];
        var total = get_total(saved_sale);
        var items_sold = get_total_items_sold(saved_sale);


        var customer = <?php echo json_encode(lang('none')) ?>;

        if (saved_sale['customer'] && saved_sale['customer']['person_id']) {
            customer = saved_sale['customer']['customer_name'];
        }

        var sale = {
            index: k,
            total: total,
            customer: customer,
            items_sold: items_sold
        };
        $("#saved_sales_list").append(saved_sale_template(sale));
    }


    localStorage.setItem("cart", JSON.stringify(cart));
    $("#register").empty();

    for (var k = 0; k < cart['items'].length; k++) {
        var cart_item = cart['items'][k];
        cart['items'][k]['line_total'] = cart_item['price'] * cart_item['quantity'] - cart_item['price'] * cart_item[
            'quantity'] * cart_item['discount_percent'] / 100;
        cart['items'][k]['index'] = k;
        $("#register").prepend(cart_item_template(cart['items'][k]));
    }

    if (cart['items'].length || cart['payments'].length || (cart['customer'] && cart['customer']['person_id'])) {
        $("#edit-sale-buttons").show();
    } else {
        $("#edit-sale-buttons").hide();
    }

    $('.xeditable').editable({
        success: function(response, newValue) {
            //persist data
            var field = $(this).data('name');
            var index = $(this).data('index');
            if (typeof index !== 'undefined') {
                cart['items'][index][field] = newValue;
            }
            renderUi();
        }
    });

    $('.xeditable').on('shown', function(e, editable) {

        editable.input.postrender = function() {
            //Set timeout needed when calling price_to_change.editable('show') (Not sure why)
            setTimeout(function() {
                editable.input.$input.select();
            }, 200);
        };
    })

    $("#payments").empty();

    for (var k = 0; k < cart['payments'].length; k++) {
        var payment = cart['payments'][k];
        cart['payments'][k]['index'] = k;
        $("#payments").append(cart_payment_template(cart['payments'][k]));
    }

    if (cart.payments.length) {
        $("#finish_sale").show();
        $("#kt_drawer_payments_list").show();
        
    } else {
        $("#finish_sale").hide();
        $("#kt_drawer_payments_list").hide();
    }

    var subtotal = get_subtotal(cart);
    var taxes = get_taxes(cart);

    var total = get_total(cart);
    var amount_due = get_amount_due(cart);
    $("#sub_total").html(subtotal);
    $("#taxes").html(taxes);
    $("#total").html(total);
    $("#amount_due").html(amount_due);
    $("#amount_tendered").val(amount_due);

    console.log('cartcustomer' , cart['customer']);
    if (cart['customer'] && cart['customer']['person_id']) {
        $("#customer_name").html(cart['customer']['customer_name']);
        $("#customer_balance").html('Balance <?php echo $this->config->item('currency_symbol'); ?>' + to_currency_no_money(cart['customer']['balance']));
        $("#selected_customer_form").removeClass('hidden');
        $("#select_customer_form").addClass('hidden');
    } else {
        $("#customer").val('');
        $("#selected_customer_form").addClass('hidden');
        $("#select_customer_form").removeClass('hidden');
    }
    amount_tendered_input_changed();
}

function addPayment(e) {
    e.preventDefault();
    var amount = $("#amount_tendered").val();
    var type = $("#payment_types").val();

    cart['payments'].push({
        amount: amount,
        type: type
    });
    renderUi();

}

$('.select-payment').on('click mousedown', selectPayment);

$("#add_payment_form").submit(addPayment);
$("#add_payment_button").click(addPayment);

$(document).on("click", 'a.delete-item', function(event) {
    event.preventDefault();
    cart.items.remove($(this).data('cart-index'));
    renderUi();
});

$(document).on("click", 'a.delete-payment', function(event) {
    event.preventDefault();
    cart.payments.remove($(this).data('payment-index'));
    renderUi();
});

$(document).on("click", '#remove_customer', function(event) {
    cart.customer = {};
    renderUi();
});


renderUi();

function get_price_without_tax_for_tax_incuded_item(cart_item) {

    var tax_info = cart_item.taxes;
    var item_price_including_tax = cart_item.price;

    if (tax_info.length == 2 && tax_info[1]['cumulative'] == '1') {
        var to_return = item_price_including_tax / (1 + (tax_info[0]['percent'] / 100) + (tax_info[1]['percent'] /
            100) + ((tax_info[0]['percent'] / 100) * ((tax_info[1]['percent'] / 100))));
    } else //0 or more taxes NOT cumulative
    {
        var total_tax_percent = 0;

        for (var k = 0; k < tax_info.length; k++) {
            var tax = tax_info[k]
            total_tax_percent += tax['percent'];
        }

        var to_return = item_price_including_tax / (1 + (total_tax_percent / 100));
    }

    return to_return;

}

function get_price_without_tax_for_tax_incuded_modifier_item(cart_item, modifier_item) {

    var tax_info = cart_item.taxes;
    var item_price_including_tax = modifier_item.unit_price;

    if (tax_info.length == 2 && tax_info[1]['cumulative'] == '1') {
        var to_return = item_price_including_tax / (1 + (tax_info[0]['percent'] / 100) + (tax_info[1]['percent'] /
            100) + ((tax_info[0]['percent'] / 100) * ((tax_info[1]['percent'] / 100))));
    } else //0 or more taxes NOT cumulative
    {
        var total_tax_percent = 0;

        for (var k = 0; k < tax_info.length; k++) {
            var tax = tax_info[k]
            total_tax_percent += tax['percent'];
        }

        var to_return = item_price_including_tax / (1 + (total_tax_percent / 100));
    }

    return to_return;

}


function get_subtotal(cart) {
    if (typeof cart.items != 'undefined') {
        var subtotal = 0;

        for (var k = 0; k < cart.items.length; k++) {
            var cart_item = cart.items[k];

            if (cart_item.tax_included == '1') {
                price = get_price_without_tax_for_tax_incuded_item(cart_item);
            } else {
                price = cart_item['price'];
            }

            for (const modifier_id in cart_item.selected_item_modifiers) {
                if (cart_item.selected_item_modifiers[modifier_id]) {
                    for (var j = 0; j < cart_item.modifiers.length; j++) {
                        if (cart_item.modifiers[j]['modifier_item_id'] == modifier_id) {
                            if (cart_item.tax_included == '1') {
                                var modifier_price = get_price_without_tax_for_tax_incuded_modifier_item(cart_item,
                                    cart_item.modifiers[j])

                            } else {
                                var modifier_price = parseFloat(to_currency_no_money(cart_item.modifiers[j][
                                    'unit_price'
                                ]));
                            }

                            price = parseFloat(price) + modifier_price;
                            break;
                        }
                    }
                }

            }
            subtotal += price * cart_item['quantity'] - cart_item['price'] * cart_item['quantity'] * cart_item[
                'discount_percent'] / 100;
        }

        return to_currency_no_money(subtotal);
    }
    return 0;
}

function get_taxes(cart) {

    if (typeof cart.items != 'undefined') {
        var total_tax = 0;

        for (var k = 0; k < cart.items.length; k++) {
            var cart_item = cart.items[k];

            if (cart_item.tax_included == '1') {
                price = get_price_without_tax_for_tax_incuded_item(cart_item);
            } else {
                price = cart_item['price'];
            }

            for (const modifier_id in cart_item.selected_item_modifiers) {
                if (cart_item.selected_item_modifiers[modifier_id]) {
                    for (var j = 0; j < cart_item.modifiers.length; j++) {
                        if (cart_item.modifiers[j]['modifier_item_id'] == modifier_id) {
                            if (cart_item.tax_included == '1') {
                                var modifier_price = get_price_without_tax_for_tax_incuded_modifier_item(cart_item,
                                    cart_item.modifiers[j])

                            } else {
                                var modifier_price = parseFloat(to_currency_no_money(cart_item.modifiers[j][
                                    'unit_price'
                                ]));
                            }
                            price = parseFloat(price) + modifier_price;
                            break;
                        }
                    }
                }

            }

            for (var j = 0; j < cart_item.taxes.length; j++) {
                var tax = cart_item.taxes[j]
                var quantity = cart_item.quantity;
                var discount = cart_item.discount_percent;

                if (tax['cumulative'] != '0') {
                    var prev_tax = ((price * quantity - price * quantity * discount / 100)) * ((cart_item.taxes[j - 1][
                        'percent'
                    ]) / 100);
                    var tax_amount = (((price * quantity - price * quantity * discount / 100)) + prev_tax) * ((tax[
                        'percent']) / 100);
                } else {
                    var tax_amount = ((price * quantity - price * quantity * discount / 100)) * ((tax['percent']) /
                        100);
                }

                total_tax += tax_amount;

            }
        }

        return to_currency_no_money(total_tax);
    } else {
        return 0;
    }
}

function get_total(cart) {
    return to_currency_no_money(parseFloat(get_subtotal(cart)) + parseFloat(get_taxes(cart)));
}

function get_payments_total(cart) {
    var total = 0;
    for (var k = 0; k < cart['payments'].length; k++) {
        total += parseFloat(cart['payments'][k]['amount']);
    }

    return to_currency_no_money(total);
}

function get_amount_due(cart) {
    return to_currency_no_money(parseFloat(get_total(cart)) - parseFloat(get_payments_total(cart)));
}

function get_total_items_sold(cart) {
    var total = 0;
    if (typeof cart.items != 'undefined') {
        var subtotal = 0;

        for (var k = 0; k < cart.items.length; k++) {
            total += parseFloat(cart.items[k]['quantity']);
        }
    }

    return to_currency_no_money(total)
}

function display_sale_register() {
    $("#print_receipt_holder").hide();
    $('#print_modal').modal('hide');
    $("#sales_page_holder").show();
}

function get_modifier_unit_total(cart_item) {
    var unit_total = 0;

    for (var k = 0; k < cart_item.modifiers.length; k++) {
        var mod_item = cart_item.modifiers[k];
        unit_total += parseFloat(mod_item['unit_price']);
    }

    return unit_total;

}

function get_modifiers_subtotal(cart_item) {
    var sub_total = 0;

    for (var k = 0; k < cart_item.modifiers.length; k++) {
        var mod_item = cart_item.modifiers[k];
        sub_total += parseFloat(mod_item['unit_price']) * cart_item['quantity'];
    }

    return sub_total;
}

function displayReceipt(sale) {
    $("#print_receipt_holder").empty();

    sale.total_items_sold = get_total_items_sold(sale);
    sale.subtotal = get_subtotal(sale);
    sale.total_tax = get_taxes(sale);
    sale.total = get_total(sale);

    for (var k = 0; k < sale.items.length; k++) {
        sale.items[k].price = parseFloat(sale.items[k].price) + get_modifier_unit_total(sale.items[k]);
        sale.items[k].line_total = parseFloat(sale.items[k].line_total) + get_modifiers_subtotal(sale.items[k]);
    }

    $("#print_receipt_holder").append(sale_receipt_template(sale));
    $("#print_receipt_holder").show();
    $('#print_modal').modal('show');
    $("#sales_page_holder").hide();

}
$("#item").focus();

//Select all text in the input when input is clicked
$("input:text, textarea").not(".description,#comment,#internal_notes").click(function() {
    $(this).select();
});

function addItem(item) {
    cart['items'].push(item);
}

$(document).ready(function() {
  var $scrollContainer = $('.horizontal-scroll');
  var scrollSpeed = 10; // Adjust this value for different scroll speeds

  $scrollContainer.on('mousemove', function(e) {
    var $this = $(this);
    var mouseX = e.pageX - $this.offset().left; // Get the mouse X position relative to the scroll container
    var scrollWidth = $this.get(0).scrollWidth; // Width of the scroll container
    var outerWidth = $this.outerWidth(); // Visible width of the scroll container
    var scrollLeft = $this.scrollLeft(); // Current scroll position

    // If the mouse is on the right side of the container, scroll right
    if (mouseX > outerWidth * 0.8) { // The 0.8 here means "start scrolling when the mouse is at 80% of the container width"
      $this.scrollLeft(scrollLeft + scrollSpeed);
    } 
    // If the mouse is on the left side of the container, scroll left
    else if (mouseX < outerWidth * 0.2) { // The 0.2 means "start scrolling when the mouse is at 20% of the container width"
      $this.scrollLeft(scrollLeft - scrollSpeed);
    }
  });

  $scrollContainer.on('wheel', function(e) {
    // Prevents the default vertical scroll
    e.preventDefault();
    
    // Cross-browser wheel delta
    var delta = e.originalEvent.deltaX * -1 || e.originalEvent.deltaY;
    var scrollLeft = $scrollContainer.scrollLeft();
    $scrollContainer.scrollLeft(scrollLeft + delta);
  });
});
</script>


<?php $this->load->view("partial/offline_footer"); ?>