<div class="row">

    <div class="col-md-12">
        <div class="card ">
            <div class="card-header rounded rounded-3 p-5">
                <?php echo lang('reports_reports'); ?> - <?php echo lang('reports_profit_and_loss') ?>
                <?php echo $subtitle ?>
                <?php if($key) { ?>
                <a href="<?php echo site_url("reports/delete_saved_report/".$key);?>"
                    class="btn btn-primary text-white hidden-print delete_saved_report pull-right">
                    <?php echo lang('reports_unsave_report'); ?></a>
                <?php } else { ?>
                <button class="btn btn-primary text-white hidden-print save_report_button pull-right"
                    style="margin-top: -12px;" data-message="<?php echo H(lang('reports_enter_report_name'));?>">
                    <?php echo lang('reports_save_report'); ?></button>
                <?php } ?>
            </div>
            <div class="card-body">
                <div class="col-md-6">
                    <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <!--end::Currency-->

                                    <!--begin::Amount-->
                                    <span
                                        class="fs-2x fw-bold text-dark me-2 lh-1 ls-n2"><?php echo lang('reports_sales'); ?></span>
                                    <!--end::Amount-->

                                </div>
                                <!--end::Info-->

                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">


                            <!--begin::Labels-->
                            <div class="d-flex flex-column content-justify-center w-100">
                                <span
                                    class="text-dark-900 pt-1 fw-semibold fs-6 mb-3 "><?php echo lang('Sale_by_Payment_Types'); ?>
                                </span>


                                <?php foreach($details_data['sales_by_payments'] as $sale_payment) { ?>



                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo $sale_payment['payment_type']; ?></div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($sale_payment['payment_amount']); ?></div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->

                                <?php } ?>
                                <div class="separator separator-dashed my-4"></div>

                                <span class="text-dark-900 pt-1 fw-semibold fs-6  mb-3 ">
                                    <?php echo lang('Sale_by_Category'); ?> </span>
                                <?php foreach($details_data['sales_by_category'] as $category) { ?>
                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo $this->Category->get_full_path($category['category_id']); ?></div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($category['total']); ?></div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                                <?php } ?>
                            </div>
                            <!--end::Labels-->
                        </div>
                        <!--end::Card body-->
                    </div>




                    <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <!--end::Currency-->

                                    <!--begin::Amount-->
                                    <span
                                        class="fs-2x fw-bold text-dark me-2 lh-1 ls-n2"><?php echo lang('reports_returns'); ?></span>
                                    <!--end::Amount-->

                                </div>
                                <!--end::Info-->

                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">


                            <!--begin::Labels-->
                            <div class="d-flex flex-column content-justify-center w-100">
                                <span
                                    class="text-dark-900 pt-1 fw-semibold fs-6 mb-3 "><?php echo lang('returns_by_payments'); ?>
                                </span>


                                <?php foreach($details_data['returns_by_payments'] as $sale_payment) { ?>



                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo $sale_payment['payment_type']; ?>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($sale_payment['payment_amount']); ?>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->

                                <?php } ?>
                                <div class="separator separator-dashed my-4"></div>

                                <span class="text-dark-900 pt-1 fw-semibold fs-6  mb-3 ">
                                    <?php echo lang('returns_by_category'); ?> </span>
                                <?php foreach($details_data['returns_by_category'] as $category) { ?>
                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo $category['category']; ?>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($category['total']); ?>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                                <?php } ?>
                            </div>
                            <!--end::Labels-->
                        </div>
                        <!--end::Card body-->
                    </div>


                    <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <!--end::Currency-->

                                    <!--begin::Amount-->
                                    <span
                                        class="fs-2x fw-bold text-dark me-2 lh-1 ls-n2"><?php echo lang('discounts'); ?></span>
                                    <!--end::Amount-->

                                </div>
                                <!--end::Info-->

                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">


                            <!--begin::Labels-->
                            <div class="d-flex flex-column content-justify-center w-100">




                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo lang('discount'); ?>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($details_data['discount_total']['discount']); ?>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->

                            </div>
                            <!--end::Labels-->
                        </div>
                        <!--end::Card body-->
                    </div>



                    <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <!--end::Currency-->

                                    <!--begin::Amount-->
                                    <span
                                        class="fs-2x fw-bold text-dark me-2 lh-1 ls-n2"><?php echo lang('reports_taxes'); ?></span>
                                    <!--end::Amount-->

                                </div>
                                <!--end::Info-->

                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">


                            <!--begin::Labels-->
                            <div class="d-flex flex-column content-justify-center w-100">




                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo lang('sale_taxes'); ?>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($details_data['taxes']['tax']- $details_data['general_total_tax']['tax']); ?>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->


								 <!--begin::Label-->
								 <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo lang('general_total_tax'); ?>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($details_data['general_total_tax']['tax']); ?>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->


								 <!--begin::Label-->
								 <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo lang('total_tax'); ?>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($details_data['taxes']['tax']); ?>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->

                            </div>
                            <!--end::Labels-->
                        </div>
                        <!--end::Card body-->
                    </div>





                    <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <!--end::Currency-->

                                    <!--begin::Amount-->
                                    <span
                                        class="fs-2x fw-bold text-dark me-2 lh-1 ls-n2"><?php echo lang('reports_total_profit_and_loss'); ?></span>
                                    <!--end::Amount-->

                                </div>
                                <!--end::Info-->

                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">


                            <!--begin::Labels-->
                            <div class="d-flex flex-column content-justify-center w-100">




                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo lang('reports_total'); ?>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($details_data['total']); ?>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->

                            </div>
                            <!--end::Labels-->
                        </div>
                        <!--end::Card body-->
                    </div>


                </div>
                <div class="col-md-6">


                    <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <!--end::Currency-->

                                    <!--begin::Amount-->
                                    <span
                                        class="fs-2x fw-bold text-dark me-2 lh-1 ls-n2"><?php echo lang('reports_receivings'); ?></span>
                                    <!--end::Amount-->

                                </div>
                                <!--end::Info-->

                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">


                            <!--begin::Labels-->
                            <div class="d-flex flex-column content-justify-center w-100">


                                <?php foreach($details_data['receivings_by_category'] as $category) { ?>

                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo $category['category']; ?>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($category['total']); ?>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                                <?php } ?>
                            </div>
                            <!--end::Labels-->
                        </div>
                        <!--end::Card body-->
                    </div>




                    <?php
					if($this->Employee->has_module_action_permission('reports','view_expenses',$this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>




                    <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <!--end::Currency-->

                                    <!--begin::Amount-->
                                    <span
                                        class="fs-2x fw-bold text-dark me-2 lh-1 ls-n2"><?php echo lang('reports_expenses'); ?></span>
                                    <!--end::Amount-->

                                </div>
                                <!--end::Info-->

                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">


                            <!--begin::Labels-->
                            <div class="d-flex flex-column content-justify-center w-100">


                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo lang('reports_total'); ?>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($details_data['expense_amount']); ?>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Labels-->
                        </div>
                        <!--end::Card body-->
                    </div>

                    <?php } ?>

                    <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <!--end::Currency-->

                                    <!--begin::Amount-->
                                    <span
                                        class="fs-2x fw-bold text-dark me-2 lh-1 ls-n2"><?php echo lang('reports_commission'); ?></span>
                                    <!--end::Amount-->

                                </div>
                                <!--end::Info-->

                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">


                            <!--begin::Labels-->
                            <div class="d-flex flex-column content-justify-center w-100">


                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo lang('reports_commission'); ?>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($details_data['commission']); ?>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Labels-->
                        </div>
                        <!--end::Card body-->
                    </div>





                    <?php
					if($this->Employee->has_module_action_permission('reports','show_profit',$this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>


                    <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <!--end::Currency-->

                                    <!--begin::Amount-->
                                    <span
                                        class="fs-2x fw-bold text-dark me-2 lh-1 ls-n2"><?php echo lang('profit'); ?></span>
                                    <!--end::Amount-->

                                </div>
                                <!--end::Info-->

                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">


                            <!--begin::Labels-->
                            <div class="d-flex flex-column content-justify-center w-100">


                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="text-dark-500 flex-grow-1 me-4">
                                        <?php echo lang('reports_total'); ?>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        <?php echo to_currency($details_data['profit']); ?>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Labels-->
                        </div>
                        <!--end::Card body-->
                    </div>


                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <br />
</div>
</div>
</div>
</div>