<?php $this->load->view("partial/header"); ?>
<script src="<?php echo base_url() ?>assets/css_good/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
<div class="spinner" id="grid-loader" style="display:none">
    <div class="rect1"></div>
    <div class="rect2"></div>
    <div class="rect3"></div>
</div>

<!-- Note Image Modal -->
<div class="modal fade" id="sale_item_notes_image_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="width: 550px;">
        <div class="modal-content" style="background-color: #abe1db;">
            <div class="modal-body">
                <img src="" class="img-responsive sale_item_notes_image">
            </div>
            <div class="text-center" style="padding-bottom: 15px;">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo lang('close') ?></button>
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
                    aria-label=<?php echo json_encode(lang('close')); ?>><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="lookUpReceipt"><?php echo lang('modifiers'); ?></h4>
            </div>
            <div class="modal-body clearfix">

            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<div class="card mb-9">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
            <!--begin::Image-->
            <div
                class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                <img class="mw-50px mw-lg-75px"
                    src="<?php echo site_url(); ?>/assets/css_good/media/svg/brand-logos/volicity-9.svg" alt="image">
            </div>
            <!--end::Image-->

            <!--begin::Wrapper-->
            <div class="flex-grow-1">
                <!--begin::Head-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::Details-->
                    <div class="d-flex flex-column">
                        <!--begin::Status-->
                        <div class="d-flex align-items-center mb-1">
                            <a href="#"
                                class="text-gray-800 text-hover-primary fs-2 fw-bold me-3"><?php echo lang('work_orders_work_order').': '; ?></span><?php echo $sale_id = $work_order_info['sale_id']; ?></a>
                            <span class="badge badge-light-success me-auto"
                                style="background-color:<?php echo $status_color = $work_order_status_info->color; ?>"><?php echo $this->Work_order->get_status_name($work_order_status_info->name); ?></span>
                        </div>
                        <!--end::Status-->

                        <!--begin::Description-->

                        <!--end::Description-->
                    </div>
                    <!--end::Details-->

                    <!--begin::Actions-->
                    <div class="d-flex mb-4 gap-1">
                        <?php if ($this->Location->get_info_for_key('blockchyp_work_order_pre_auth')) { ?>
                        <?php echo anchor(site_url('work_orders/pre_auth_capture/'.$work_order_info['id']), lang('work_rders_capture_pre_auth'), array('class'=>'btn btn-light-danger btn-sm capture_signature')); ?>
                        <?php } ?>
                        <?php if ($this->Location->get_info_for_key('blockchyp_work_order_post_auth')) { ?>
                        <?php echo anchor(site_url('work_orders/post_auth_capture/'.$work_order_info['id']), lang('work_rders_capture_post_auth'), array('class'=>'btn btn-light-danger btn-sm capture_signature')); ?>
                        <?php } ?>

                        <?php 

							$edit_sale_url = $sale_info->suspended ? 'unsuspend' : 'change_sale';
							echo anchor(site_url("sales/$edit_sale_url/").$sale_id,lang('work_orders_edit_sale'), array('class'=>'btn btn-light-primary btn-sm')); ?>

                        <?php echo anchor('', lang('work_orders_service_tag'), array('class'=>'btn btn-light-primary btn-sm service_tag_btn')); ?>
                        <?php echo anchor(site_url('work_orders'), ' ' . lang('done'), array('class'=>'btn btn-light-primary btn-sm ion-android-exit','id'=>'done_btn')); ?>


                        <!--begin::Menu-->
                        <div class="me-0">
                            <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="fa fa-ellipsis"></i></button>

                            <!--begin::Menu 3-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                data-kt-menu="true">
                                <!--begin::Heading-->
                                <div class="menu-item px-3">
                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                        <?php echo lang('print')?>
                                    </div>
                                </div>
                                <!--end::Heading-->


                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-1">
                                    <a target="_blank"
                                        href="<?php echo site_url('work_orders/print_work_order/'.$work_order_info['id']); ?>"
                                        class="menu-link px-3">
                                        <?php echo lang('workorder')?>
                                    </a>
                                </div>
                                <!--end::Menu item-->



                                <?php if ($this->config->item('work_order_show_receipt_dropdown')) {?>
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-1">
                                    <a href="<?php echo site_url('sales/receipt/'.$work_order_info['sale_id']); ?>"
                                        class="menu-link px-3">
                                        <?php echo lang('sales_receipt')?>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <?php  }  ?>
                            </div>
                            <!--end::Menu 3-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Head-->

                <!--begin::Info-->
                <div class="d-flex flex-wrap justify-content-start">
                    <!--begin::Stats-->

                    <div class="d-flex flex-wrap">
                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2"><span
                                        class="path1"></span><span class="path2"></span></i>
                                <div class="fs-4 fw-bold counted" data-kt-countup="true" data-kt-countup-value="15000"
                                    data-kt-countup-prefix="$" data-kt-initialized="1">
                                    <?= $summary['net_customer_will_pay'] ?></div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-500"><?= lang('net_customer_will_pay'); ?></div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2"><span
                                        class="path1"></span><span class="path2"></span></i>
                                <div class="fs-4 fw-bold counted" data-kt-countup="true" data-kt-countup-value="15000"
                                    data-kt-countup-prefix="$" data-kt-initialized="1">
                                    <?= $summary['owner_have_to_pay_to_sp'] ?></div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-500"><?= lang('owner_have_to_pay_to_sp'); ?></div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2"><span
                                        class="path1"></span><span class="path2"></span></i>
                                <div class="fs-4 fw-bold counted" data-kt-countup="true" data-kt-countup-value="15000"
                                    data-kt-countup-prefix="$" data-kt-initialized="1">
                                    <?= $summary['owner_have_to_pay_for_parts'] ?></div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-500"><?= lang('owner_have_to_pay_for_parts'); ?>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->


                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2"><span
                                        class="path1"></span><span class="path2"></span></i>
                                <div class="fs-4 fw-bold counted" data-kt-countup="true" data-kt-countup-value="15000"
                                    data-kt-countup-prefix="$" data-kt-initialized="1">
                                    <?= $summary['net_amount_for_owner'] ?></div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-500"><?= lang('net_amount_for_owner'); ?></div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->



                    </div>
                    <!--end::Stats-->

                    <div class="d-flex flex-wrap">
                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">
                                    <?php echo date(get_date_format(), strtotime($work_order_info['sale_time'])); ?>
                                </div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-500"><?php echo lang('sale_time'); ?></div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">
                                    <?php echo $customer_info['first_name'].' '.$customer_info['last_name']; ?> </div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-500"><?php echo lang('customer'); ?></div>
                            <!--end::Label-->

                            
                        </div>
                        <!--end::Stat-->


                         <!--begin::Stat-->
                         <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">
                                <div class="workorder_status">
                                <?php
                             echo work_order_status_badge($work_order_info['status']  , $work_order_info['id'] ); ?>
                            </div></div>
                            </div>
                            <!--end::Number-->

                           
                        </div>
                        <!--end::Stat-->
                    </div>

                    <!--begin::Users-->
                    <div class="symbol-group symbol-hover mb-3">

                        <?php $user_img = site_url('assets/assets/images/avatar-default.jpg');
                                        if($customer_info['image_id']){
                                            $user_img = cacheable_app_file_url($customer_info['image_id']);
                                        }
                                    
                                    ?>



                        <!--begin::User-->
                        <div class="symbol symbol-35px symbol-circle" data-toggle="tooltip"
                            title="<?php echo $customer_info['first_name'].' '.$customer_info['last_name']; ?>"
                            data-original-title="<?php echo $customer_info['first_name'].' '.$customer_info['last_name']; ?>"
                            data-kt-initialized="1">
                            <img alt="Pic" src="<?= $user_img; ?>">
                        </div>
                        <!--end::User-->

                    </div>
                    <!--end::Users-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Details-->

        <div class="separator"></div>

        <!--begin::Nav-->
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold" role="tablist">


            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 active" data-toggle="tab" href="#kt_Settings">
                    <?= lang('Home'); ?> </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 " data-toggle="tab" href="#kt_Repair_items"
                    aria-selected="true" role="tab">
                    <?= lang('Repair_items'); ?> </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item">
            <a class="nav-link text-active-primary py-5 me-6" data-toggle="tab" href="#kt_Modify_Parts_and_labor">
            <?= lang('Modify_Parts_and_labor'); ?>
        </a>
            </li>
            <!--end::Nav item-->

            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 " data-toggle="tab" href="#kt_Files">
                    <?= lang('Files'); ?> </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 " data-toggle="tab" href="#kt_Activity">
                    <?= lang('Activity'); ?> </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 " data-toggle="tab" href="#kt_Notes">
                    <?= lang('Notes'); ?> </a>
            </li>
            <!--end::Nav item-->

        </ul>
        <!--end::Nav-->
    </div>
</div>

<div class="tab-content">

    <?php echo form_open('work_orders/save/'.$work_order_info['id'],array('id'=>'work_order_form','class'=>'')); ?>
    <!--begin::Tab pane-->
    <div id="kt_Repair_items" class="tab-pane fade" role="tabpanel">

        <div class="d-flex flex-wrap flex-stack pt-2 pb-8">


            <!--begin::Controls-->
            <div class="d-flex flex-wrap my-1">
                <div class="item_search">
                    <div class="input-group">
                        <!-- Css Loader  -->
                        <div class="spinner" id="ajax-loader-ri" style="display:none">
                            <div class="rect1"></div>
                            <div class="rect2"></div>
                            <div class="rect3"></div>
                        </div>


                        <span class="input-group-text">
                            <?php echo anchor("items/view/-1","<i class='icon ti-pencil-alt'></i>", array('class'=>'none add-new-item','title'=>lang('new_item'), 'id' => 'new-item', 'tabindex'=> '-1')); ?>
                        </span>
                        <input type="text" id="repair_item" name="item"
                            class="add-item-input pull-left keyboardTop form-control"
                            placeholder="<?php echo lang('start_typing_item_name'); ?>"
                            data-title="<?php echo lang('item_name'); ?>" style="background:white !important">
                        <span class="input-group-text plus-minus add_additional_item">
                            <i class='icon ti-plus'></i>
                        </span>
                        <input type="hidden" id="item_identifier">
                    </div>
                </div>
            </div>
            <!--end::Controls-->
        </div>





        <div class="row g-9">

            <?php $employee_source_data = array();
															foreach ($employees as $person_id => $employee) {
																$employee_source_data[] = array('value' => $person_id, 'text' => $employee);
															}
															$repair_source_data = array();  
															
															?>
            <?php 
																foreach($items_being_repaired as $item_being_repaired_info) { 
																	$item_id 			= $item_being_repaired_info['item_id'] ?? '';
																	$item_kit_id 		= $item_being_repaired_info['item_kit_id'] ?? '';
																	$line 				= $item_being_repaired_info['line'];
																	$item_variation_id 	= $item_being_repaired_info['item_variation_id'] ?? '';
																	$approved_by 		= $item_being_repaired_info['approved_by'] ?? '';
																	$assigned_to 		= $item_being_repaired_info['assigned_to'] ?? '';
																	
													
																	$is_item_kit = 0;
																	if(empty($item_id)) {
																		$item_id = $item_kit_id;
																		$is_item_kit = 1;
																	}
																	$repair_source_data[] = array('value' => $item_id, 'text' =>$item_being_repaired_info['item_name']);
																	?>
            <!--begin::Col-->
            <div class="col-md-4">
                <!--begin::Card-->
                <div class="card mb-6 mb-xl-9">
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Header-->
                        <div class="d-flex flex-stack mb-3">
                            <!--begin::Badge-->
                            <div class="badge badge-success">
                                <?php echo $this->Category->get_full_path($item_being_repaired_info['category_id']); ?>
                            </div>
                            <!--end::Badge-->

                            <!--begin::Menu-->

                            <!--end::Menu-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Title-->
                        <div class="mb-2 d-flex justify-content-between">


                            <?php if(!empty($item_kit_id)) { ?>
                            <a class="fs-4 fw-bold mb-1 text-gray-900 text-hover-primary" tabindex="-1"
                                href="<?php echo site_url('home/view_item_kit_modal/'.$item_kit_id)."?redirect=work_orders/view/".$work_order_id; ?>"
                                data-toggle="modal"
                                data-target="#myModal"><?php echo H($item_being_repaired_info['item_name']); ?>
                                <?php  if($item_variation_id): echo '-'.$this->Item_variations->get_info($item_variation_id)->name; endif; ?>
                            </a>
                            <?php echo anchor("work_orders/delete_item_kit/".$sale_id."/".$line, '<span class=""><i class="ion-android-delete fs-3 text-danger" aria-hidden="true"></i></span>', array('class' => 'delete-item'));?>
                            <?php } else { ?>
                            <a class="fs-4 fw-bold mb-1 text-gray-900 text-hover-primary" tabindex="-1"
                                href="<?php echo site_url('home/view_item_modal/'.$item_id)."?redirect=work_orders/view/".$work_order_id; ?>"
                                data-target="#kt_drawer_general" data-target-title="<?= lang('view_item') ?>"
                                data-target-width="xl"><?php echo H($item_being_repaired_info['item_name']); ?>
                                <?php if($item_variation_id): echo '-'.$this->Item_variations->get_info($item_variation_id)->name; endif; ?></a>
                            <?php echo anchor("work_orders/delete_item/".$sale_id."/".$line, '<span class=""><i class="ion-android-delete fs-3 text-danger" aria-hidden="true"></i></span>', array('class' => 'delete-item'));?>

                            <?php } ?>


                        </div>
                        <!--end::Title-->

                        <!--begin::Content-->
                        <div class="fs-6 fw-semibold text-gray-600 mb-5">
                            <?php if (isset($item_being_repaired_info['allow_alt_description']) && $item_being_repaired_info['allow_alt_description'] == 1) { ?>
                            <a class="fs-7 text-gray-800 text-hover-primary fw-bold mb-1 xeditable" href="#"
                                id="description_<?php echo $line; ?>" data-type="textarea" data-pk="1"
                                data-name="description"
                                data-value="<?php echo clean_html($item_being_repaired_info['description']); ?>"
                                data-url="<?php echo site_url('work_orders/edit_sale_item_description/' .$sale_id.'/'.$item_id.'/'.$line.($item_variation_id ? '/'.$item_variation_id : '')); ?>"
                                data-title="<?php echo H(lang('sales_description_abbrv')); ?>"><?php echo clean_html(character_limiter($item_being_repaired_info['description']), 50); ?></a>
                            <?php } else { 
																					echo clean_html($item_being_repaired_info['description']);
																				}
																				?>



                            <dl class="dl-horizontal dl-horizontal-right min-h-200px" >
                                <dt><?php echo lang('work_orders_quantity') ?></dt>
                                <dd><a class="fs-7 text-gray-800 text-hover-primary fw-bold mb-1" href="#"
                                        id="quantity_<?php echo $item_being_repaired_info['line']; ?>" class="xeditable"
                                        data-type="text" data-validate-number="true" data-pk="1" data-name="quantity"
                                        data-url="<?php echo site_url('work_orders/edit_item_quantity/' .$sale_id.'/'.$item_id.'/'.$line.($item_variation_id ? '/'.$item_variation_id : '/0/'.$is_item_kit)); ?>"
                                        data-title="<?php echo H(to_quantity($item_being_repaired_info['quantity_purchased'])); ?>"><?php echo to_quantity($item_being_repaired_info['quantity_purchased']); ?></a>
                                </dd>

                                <?php if ($this->config->item('disable_discounts_percentage_per_line_item') != 1) {?>
                                <?php if ($this->Employee->has_module_action_permission('sales', 'give_discount', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                <dt><?php echo lang('discount') ?></dt>
                                <dd><a class="fs-7 text-gray-800 text-hover-primary fw-bold mb-1" href="#"
                                        id="discount_<?php echo $item_being_repaired_info['line']; ?>" class="xeditable"
                                        data-type="text" data-validate-number="true" data-pk="1" data-name="discount"
                                        data-value="<?php echo H(to_quantity($item_being_repaired_info['discount_percent'])); ?>"
                                        data-url="<?php echo site_url('work_orders/edit_item_discount/' .$sale_id.'/'.$item_id.'/'.$line.($item_variation_id ? '/'.$item_variation_id : '/0/'.$is_item_kit)); ?>"
                                        data-title="<?php echo to_quantity($item_being_repaired_info['discount_percent']); ?>"><?php echo to_quantity($item_being_repaired_info['discount_percent']); ?>%</a>
                                </dd>
                                <?php } }?>


                                </dd>

                                <?php
																				
																				$serial_numbers = $this->Item_serial_number->get_all($item_being_repaired_info['item_id'],$this->Employee->get_logged_in_employee_current_location_id());
																					
																				
																				if ($serial_numbers != false && isset($item_being_repaired_info['is_serialized']) && $item_being_repaired_info['is_serialized'] == 1  && $item_being_repaired_info['item_name'] != lang('giftcard')) { ?>
                                <dt><?php echo lang('serial_number') ?></dt>
                                <?php
																					$source_data = array();
																					if (count($serial_numbers) > 0) {
																					?>
                                <dd class=""><a class="fs-7 text-gray-800 text-hover-primary fw-bold mb-1" href="#"
                                        id="serialnumber_<?php echo $item_being_repaired_info['line']; ?>"
                                        data-name="serialnumber" data-type="select" data-pk="1"
                                        data-url="<?php echo site_url('work_orders/edit_sale_item_serial_number/' .$sale_id.'/'.$item_id.'/'.$line.($item_variation_id ? '/'.$item_variation_id : '')); ?>"
                                        data-title="<?php echo H(lang('serial_number')); ?>"><?php echo character_limiter(H($item_being_repaired_info['serialnumber']), 50); ?></a>
                                </dd>
                                <?php
																					} else {
																					?>
                                <dd class="">
                                    <a href="#" class="fs-7 text-gray-800 text-hover-primary fw-bold mb-1"
                                        id="serialnumber_<?php echo $item_being_repaired_info['line']; ?>"
                                        class="xeditable" data-type="text" data-pk="1" data-name="serialnumber"
                                        data-value="<?php echo H($item_being_repaired_info['serialnumber']); ?>"
                                        data-url="<?php echo site_url('work_orders/edit_sale_item_serial_number/' .$sale_id.'/'.$item_id.'/'.$line.($item_variation_id ? '/'.$item_variation_id : '')); ?>"
                                        data-title="<?php echo H(lang('serial_number')); ?>"><?php echo character_limiter(H($item_being_repaired_info['serialnumber']), 50); ?></a>
                                </dd>
                                <?php
																					}
																				?>

                                <?php
																					if (count($serial_numbers) > 0) {
																						$source_data[] = array('value' => '-1', 'text' => lang('sales_new_serial_number'));

																						foreach ($serial_numbers as $serial_number) {
																							$source_data[] = array('value' => $serial_number['serial_number'], 'text' => $serial_number['serial_number']);
																						}
																					?>
                                <script>
                                $('#serialnumber_<?php echo $line; ?>').editable({
                                    value: <?php echo json_encode(H($item_being_repaired_info['serialnumber']) ? H($item_being_repaired_info['serialnumber']) : ''); ?>,
                                    source: <?php echo json_encode($source_data); ?>,
                                    success: function(response, newValue) {
                                        if (newValue == -1) {

                                            bootbox.prompt({
                                                title: <?php echo json_encode(lang('sales_enter_serial_number')); ?>,
                                                inputType: 'text',
                                                value: '',
                                                callback: function(serial_number) {
                                                    if (serial_number) {
                                                        $.post(<?php echo json_encode(site_url('work_orders/edit_sale_item_serial_number/' .$sale_id.'/'.$item_id.'/'.$line.($item_variation_id ? '/'.$item_variation_id : ''))); ?>, {
                                                            name: 'serialnumber',
                                                            value: serial_number
                                                        }, function(response) {
                                                            window.location.reload();
                                                        });
                                                    }
                                                }
                                            })

                                        } else {
                                            last_focused_id = $(this).attr('id');
                                            window.location.reload();
                                        }
                                    }

                                });
                                </script>
                                <?php } ?>

                                <?php } ?>


                                <?php  if ($serial_numbers != false && count($serial_numbers) > 0) { ?>
                                <dt><?php echo lang('warranty') ?></dt>

                                <dd class="">
                                    <?php
																							$warranty='';
																							$this->db->from('items_serial_numbers');
																							$this->db->where('serial_number',  $item_being_repaired_info['serialnumber']);
																							$query = $this->db->get();
																							$givenDate='';
																								if($query->num_rows() >= 1)
																								{
																									 if($query->row()->is_sold==1 &&  $query->row()->replace_sale_date==0 || ($query->row()->warranty_start==null || $query->row()->warranty_end ==null ) ){
																										$warranty =lang('from').": ".$query->row()->sold_warranty_start." ".lang('To')." :".$query->row()->sold_warranty_end;
																										$givenDate= $query->row()->sold_warranty_end;
																									 }else{
																										
																										$warranty =lang('from').": ".$query->row()->warranty_start." ".lang('To')." :".$query->row()->warranty_end;
																										$givenDate= $query->row()->warranty_end;
																									 }
																								}
																								$expired='';
																								if($givenDate!=null){
																									$now = new DateTime();
																									$dateToCheck = new DateTime($givenDate);
																									
																									if ($dateToCheck < $now) {
																										$expired =  " <span class='badge badge-danger'>".lang('expired')."</span>";
																									}else{
																										$expired =  " <span class='badge badge-success'>".lang('under_warranty')."</span>";
																									}
																								}
																								
																							echo $warranty.$expired;

																							?>

                                </dd>


                                <?php } ?>

                                <dt><?php echo lang('item_number_expanded') ?></dt>
                                <dd><?php echo H(isset($item_being_repaired_info['item_number'])); ?></dd>

                                <dt><?php echo lang('price') ?></dt>
                                <dd><a href="#" class="fs-7 text-gray-800 text-hover-primary fw-bold mb-1"
                                        id="unit_price_<?php echo $item_being_repaired_info['line']; ?>"
                                        class="xeditable" data-type="text" data-validate-number="true" data-pk="1"
                                        data-name="unit_price"
                                        data-url="<?php echo site_url('work_orders/edit_sale_item_unit_price/'.$item_being_repaired_info['sale_id'].'/'.$item_id.'/'.($item_variation_id ? '/'.$item_variation_id : '/0/').'/'.$line.'/'. $is_item_kit); ?>"
                                        data-value="<?php echo H(to_currency_no_money($item_being_repaired_info['item_unit_price'] - $this->Work_order->get_modifiers_unit_total($sale_id,$item_id,$line))); ?>"
                                        data-title="<?php echo lang('price') ?>"><?php echo to_currency($item_being_repaired_info['item_unit_price'] - $this->Work_order->get_modifiers_unit_total($sale_id,$item_id,$line)); ?>
                                        <script>
                                        $('#unit_price_<?php echo $item_being_repaired_info['line'];?>').editable();
                                        </script>
                                    </a></dd>

                                <dt><?php echo lang('approved_by')?></dt>
                                <dd><a href="#"
                                        class=" fs-7 text-gray-800 text-hover-primary fw-bold mb-1 choose_approved_by_<?php echo $item_id;?>"
                                        data-name="choose_approved_by" data-type="select" data-pk="1"
                                        data-url="<?php echo site_url('work_orders/edit_approved_by/'.$sale_id.'/'.$item_id.($item_variation_id?'/'.$item_variation_id: '/0').'/'.$line.'/'.$is_item_kit); ?>"
                                        data-title="<?php echo H(lang('approved_by')); ?>">
                                        <?php echo character_limiter(H($approved_by ? $this->Employee->get_info($item_being_repaired_info['approved_by'])->full_name : lang('none')), 50); ?></a>
                                </dd>
                                <script>
                                $('.choose_approved_by_<?php echo $item_id; ?>').editable({
                                    value: <?php echo (H($item_being_repaired_info['approved_by']) ? H($item_being_repaired_info['approved_by']) : 0); ?>,
                                    source: <?php echo json_encode($employee_source_data); ?>,
                                    success: function(response, newValue) {
                                        window.location.reload();
                                    }
                                });
                                </script>

                                <dt><?php echo lang('assigned_to')?></dt>
                                <dd><a href="#"
                                        class="fs-7 text-gray-800 text-hover-primary fw-bold mb-1 choose_assigned_to_<?php echo $item_id;?>"
                                        data-name="choose_assigned_to_" data-type="select" data-pk="1"
                                        data-url="<?php echo site_url('work_orders/edit_assigned_to/'.$sale_id.'/'.$item_id.($item_variation_id?'/'.$item_variation_id: '/0').'/'.$line.'/'.$is_item_kit); ?>"
                                        data-title="<?php echo H(lang('assigned_to')); ?>">
                                        <?php echo character_limiter(H($assigned_to ? $this->Employee->get_info($item_being_repaired_info['assigned_to'])->full_name : lang('none')), 50); ?></a>
                                </dd>
                                <script>
                                $('.choose_assigned_to_<?php echo $item_id;?>').editable({
                                    value: <?php echo (H($item_being_repaired_info['assigned_to']) ? H($item_being_repaired_info['assigned_to']) : 0); ?>,
                                    source: <?php echo json_encode($employee_source_data); ?>,
                                    success: function(response, newValue) {
                                        window.location.reload();
                                    }
                                });
                                </script>
                                <?php
																			$mods_for_item = $this->Item_modifier->get_modifiers_for_work_order_item($item_id)->result_array();

																			if (count($mods_for_item) > 0) {
																			?>
                                <dt><?php echo lang('modifiers') ?></dt>
                                <dd>
                                    <a class="editable-click" style="cursor:pointer;"
                                        onclick="enable_popup_modifier(<?php echo $sale_id; ?>,<?php echo $item_id; ?>, <?php echo $line; ?>);"><?php echo lang('edit'); ?></a>
                                    <?php
																				$modifier_items = $this->Sale->get_sale_item_modifiers($sale_id, $item_id, $line)->result_array();
																				if (count($modifier_items)) {
																					foreach ($modifier_items as $modifier_item) {
																						$modifier_item_id = $modifier_item['modifier_item_id'];
																						$modifier_item_info = $this->Item_modifier->get_modifier_item_info($modifier_item_id);
																						$edit_modifier_price ='<a href="#" id="modifier_'.$line.'" class="xeditable edit-price" data-type="text" data-validate-number="true" data-pk="1" data-name="modifier_price" data-modifier-item-id="'.$modifier_item_id.'" data-url="'.site_url('work_orders/edit_item_modifier_price/'.$sale_id.'/'.$item_id.'/'.$line.'/'.$modifier_item_id ).'" data-title="'.lang('price').'" data-value="'.H(to_currency_no_money($modifier_item['unit_price'])).'">'.to_currency($modifier_item['unit_price']).'</a>';

																						$display_name = $edit_modifier_price.': '.$modifier_item_info['modifier_name'].' > '.$modifier_item_info['modifier_item_name'];

																						echo '<p>' . $display_name . '</p>';
																					}
																				}
																				?>
                                </dd>
                                <?php } ?>
                            </dl>

                        </div>
                        <!--end::Content-->

                        <!--begin::Footer-->
                        <div class="d-flex flex-stack flex-wraper">


                            <!--begin::Stats-->
                            <div class="d-flex my-1">
                                <!--begin::Stat-->
                                <div
                                    class="border border-dashed border-gray-300 rounded d-flex align-items-center py-2 px-3">
                                    <div class='item_name_and_warranty pull-right'>
                                        <div class='warranty_repair form-check form-check-custom form-check-solid'>
                                            <?php echo form_checkbox(array(
																		'name'=>'warranty_'.$item_id.'',
																		'id'=>'warranty_'.$item_id.'',
																		'value'=>'warranty',
																		'class' => 'warranty form-check-input',
																		'checked'=>$item_being_repaired_info['warranty'],
																		));?>
                                            <label class="form-check-label "
                                                for="<?php echo 'warranty_'.$item_id.''; ?>"><?= lang('work_orders_warranty_repair'); ?></label>

                                        </div>
                                    </div>
                                </div>
                                <!--end::Stat-->

                            </div>

                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <?php } ?>

        </div>
        <!--end::Col-->

    </div>

    <div id="kt_Modify_Parts_and_labor" class="tab-pane fade" role="tabpanel">
        <div class="d-flex flex-wrap flex-stack pt-2 pb-8">


            <!--begin::Controls-->
            <div class="d-flex flex-wrap my-1">
                <div class="item_search">
                    <div class="input-group">
                        <!-- Css Loader  -->
                        <div class="spinner" id="ajax-loader" style="display:none">
                            <div class="rect1"></div>
                            <div class="rect2"></div>
                            <div class="rect3"></div>
                        </div>

                        <span class="input-group-text">
                            <?php echo anchor("items/view/-1","<i class='icon ti-pencil-alt'></i>", array('class'=>'none add-new-item','title'=>lang('new_item'), 'id' => 'new-item', 'tabindex'=> '-1')); ?>
                        </span>
                        <input type="text" id="item" name="item" style="background:white !important"
                            class="add-item-input pull-left keyboardTop form-control"
                            placeholder="<?php echo lang('start_typing_item_name'); ?>"
                            data-title="<?php echo lang('item_name'); ?>">
                        <input type="hidden" id="item_description">
                    </div>
                </div>


            </div>
            <!--end::Controls-->
        </div>
        <div class="card">
            <div class="card-body">
                <div class="work_order_items">
                    <div class="register-box register-items paper-cut">
                        <div class="register-items-holder table-responsive">
                            <table id="register" class="table align-middle table-row-dashed gy-5 dataTable no-footer">

                                <thead>
                                    <tr class="register-items-header">
                                        <th></th>
                                        <th class="min-w-100px"><?php echo lang('quantity'); ?></th>
                                        <th class="min-w-100px"><?php echo lang('item_name'); ?></th>
                                        <th class="min-w-100px"><?php echo lang('approved_by'); ?></th>
                                        <th class="min-w-100px"><?php echo lang('assigned_to'); ?></th>
                                        <th class="min-w-100px"><?php echo lang('repair_item'); ?></th>
                                        <?php if($this->Employee->has_module_action_permission('work_orders', 'show_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)): ?>
                                        <th class="min-w-100px"><?php echo lang('cost_price'); ?></th>
                                        <?php endif; ?>
                                        <th class="min-w-100px"><?php echo lang('price'); ?></th>
                                    </tr>
                                </thead>

                                <tbody class="register-item-content">

                                    <?php
                                        $total_cost = 0;
                                        $total_price = 0;
                                        foreach($work_order_items as $item) {
                                            $item_id = 0;
                                            if(isset($item['item_id'])) {
                                                $item_id = $item['item_id'];
                                            }
                                            $item_kit_id 		= isset($item['item_kit_id']);
                                            $line 				= $item['line'];
                                            $item_variation_id 	= isset($item['item_variation_id'])?$item['item_variation_id']:0;
                                            $total_cost 		+= $item['item_cost_price']*$item['quantity_purchased'];
                                            $total_price 		+=($item['item_unit_price'] - $this->Work_order->get_modifiers_unit_total($sale_id,$item_id,$line))*$item['quantity_purchased'];
                                            $is_item_kit 	= 0;
                                            if(empty($item_id)) {
                                                $item_id 		= $item_kit_id;
                                                $is_item_kit 	= 1;
                                            }
                                            ?>
                                    <tr class="register-item-details">
                                        <td class="text-center">
                                            <?php if(!empty($item_kit_id)) { ?>
                                            <?php echo anchor("work_orders/delete_item_kit/".$sale_id."/".$line,'<i class="icon ion-android-cancel"></i>', array('class' => 'delete-item'));?>
                                            <?php } else { ?>
                                            <?php echo anchor("work_orders/delete_item/".$sale_id."/".$line,'<i class="icon ion-android-cancel"></i>', array('class' => 'delete-item'));?>
                                            <?php } ?>

                                        </td>
                                        <td class="text-center">
                                            <a href="#" id="quantity_<?php echo $item_id;?>" class="xeditable"
                                                data-type="text" data-validate-number="true" data-pk="1"
                                                data-name="quantity"
                                                data-url="<?php echo site_url('work_orders/edit_sale_item_quantity/'.$sale_id.'/'.$item_id.'/'.$line.($item_variation_id?'/'.$item_variation_id:'/0/'.$is_item_kit)); ?>"
                                                data-title="<?php echo lang('quantity') ?>"><?php echo to_quantity($item['quantity_purchased']); ?></a>
                                        </td>
                                        <td>
                                            <?php
                                                        echo $item['item_name'];
                                                        if($item_variation_id){
                                                            echo '-'.$this->Item_variations->get_info($item_variation_id)->name;
                                                        }
                                                    ?>

                                            <?php if (isset($item['allow_alt_description']) && $item['allow_alt_description'] == 1) { ?>
                                            : <a href="#" id="description_<?php echo $line; ?>" class="xeditable"
                                                data-type="textarea" data-pk="1" data-name="description"
                                                data-value="<?php echo clean_html($item['description']); ?>"
                                                data-url="<?php echo site_url('work_orders/edit_sale_item_description/' .$sale_id.'/'.$item_id.'/'.$line.($item_variation_id ? '/'.$item_variation_id : '')); ?>"
                                                data-title="<?php echo H(lang('sales_description_abbrv')); ?>"><?php echo clean_html(character_limiter($item['description']), 50); ?></a>
                                            <?php	} ?>

                                            <?php
                                                        $mods_for_item = $this->Item_modifier->get_modifiers_for_work_order_item($item_id)->result_array();

                                                        if (count($mods_for_item) > 0) {
                                                        ?>
                                            <dl>
                                                <dt><?php echo lang('modifiers') ?>: <a class="editable-click"
                                                        style="cursor:pointer;"
                                                        onclick="enable_popup_modifier(<?php echo $sale_id; ?>,<?php echo $item_id; ?>, <?php echo $line; ?>);"><?php echo lang('edit'); ?></a>
                                                </dt>
                                                <dd>
                                                    <?php
                                                                $modifier_items = $this->Sale->get_sale_item_modifiers($sale_id, $item_id, $line)->result_array();
                                                                if (count($modifier_items)) {
                                                                    foreach ($modifier_items as $modifier_item) {
                                                                        $modifier_item_id = $modifier_item['modifier_item_id'];
                                                                        $modifier_item_info = $this->Item_modifier->get_modifier_item_info($modifier_item_id);
                                                                        $edit_modifier_price ='<a href="#" id="modifier_'.$line.'" class="xeditable edit-price" data-type="text" data-validate-number="true" data-pk="1" data-name="modifier_price" data-modifier-item-id="'.$modifier_item_id.'" data-url="'.site_url('work_orders/edit_item_modifier_price/'.$sale_id.'/'.$item_id.'/'.$line.'/'.$modifier_item_id ).'" data-title="'.lang('price').'" data-value="'.H(to_currency_no_money($modifier_item['unit_price'])).'">'.to_currency($modifier_item['unit_price']).'</a>';

                                                                        $display_name = $edit_modifier_price.': '.$modifier_item_info['modifier_name'].' > '.$modifier_item_info['modifier_item_name'];

                                                                        echo '<p>' . $display_name . '</p>';
                                                                    }
                                                                }
                                                                ?>
                                                </dd>
                                            </dl>
                                            <?php } ?>

                                        </td>

                                        <td class="text-center">
                                            <dd><a href="#" class="choose_approved_by_<?php echo $item_id;?>"
                                                    data-name="choose_approved_by" data-type="select" data-pk="1"
                                                    data-url="<?php echo site_url('work_orders/edit_approved_by/'.$sale_id.'/'.$item_id.($item_variation_id?'/'.$item_variation_id: '/0').'/'.$line.'/'.$is_item_kit); ?>"
                                                    data-title="<?php echo H(lang('approved_by')); ?>">
                                                    <?php echo character_limiter(H($item['approved_by'] ? $this->Employee->get_info($item['approved_by'])->full_name : lang('none')), 50); ?></a>
                                            </dd>
                                            <script>
                                            $('.choose_approved_by_<?php echo $item_id;?>').editable({
                                                value: <?php echo (H($item['approved_by']) ? H($item['approved_by']) : 0); ?>,
                                                source: <?php echo json_encode($employee_source_data); ?>,
                                                success: function(response, newValue) {
                                                    window.location.reload();
                                                }
                                            });
                                            </script>
                                        </td>

                                        <td class="text-center">
                                            <dd><a href="#" class="choose_assigned_to_<?php echo $item_id;?>"
                                                    data-name="choose_assigned_to_" data-type="select" data-pk="1"
                                                    data-url="<?php echo site_url('work_orders/edit_assigned_to/'.$sale_id.'/'.$item_id.($item_variation_id?'/'.$item_variation_id: '/0').'/'.$line.'/'.$is_item_kit); ?>"
                                                    data-title="<?php echo H(lang('assigned_to')); ?>">
                                                    <?php echo character_limiter(H($item['assigned_to'] ? $this->Employee->get_info($item['assigned_to'])->full_name : lang('none')), 50); ?></a>
                                            </dd>
                                            <script>
                                            $('.choose_assigned_to_<?php echo $item_id;?>').editable({
                                                value: <?php echo (H($item['assigned_to']) ? H($item['assigned_to']) : 0); ?>,
                                                source: <?php echo json_encode($employee_source_data); ?>,
                                                success: function(response, newValue) {
                                                    window.location.reload();
                                                }
                                            });
                                            </script>
                                        </td>
                                        <td>

                                            <dd><a href="#" class="assigned_repair_item<?php echo $item_id;?>"
                                                    data-name="assigned_repair_item" data-type="select" data-pk="1"
                                                    data-url="<?php echo site_url('work_orders/edit_assigned_repair_item/'.$sale_id.'/'.$item_id.($item_variation_id?'/'.$item_variation_id: '/0').'/'.$line.'/'.$is_item_kit); ?>"
                                                    data-title="<?php echo H(lang('assigned_repair_item')); ?>">
                                                    <?php echo character_limiter(H($item['assigned_repair_item'] ? $this->Item->get_info($item['assigned_repair_item'])->name : lang('none')), 50); ?></a>
                                            </dd>
                                            <script>
                                            $('.assigned_repair_item<?php echo $item_id;?>').editable({
                                                value: <?php echo (H($item['assigned_repair_item']) ? H($item['assigned_repair_item']) : 0); ?>,
                                                source: <?php echo json_encode($repair_source_data); ?>,
                                                success: function(response, newValue) {
                                                    window.location.reload();
                                                }
                                            });
                                            </script>

                                        </td>
                                        <?php if($this->Employee->has_module_action_permission('work_orders', 'show_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)): ?>

                                        <td>
                                            <?php echo to_currency($item['item_cost_price']); ?>
                                        </td>
                                        <?php endif; ?>
                                        <td>
                                            <a href="#" id="unit_price_<?php echo $item_id;?>" class="xeditable"
                                                data-type="text" data-validate-number="true" data-pk="1"
                                                data-name="unit_price"
                                                data-url="<?php echo site_url('work_orders/edit_sale_item_unit_price/'.$item['sale_id'].'/'.$item_id.($item_variation_id ? '/'.$item_variation_id : '/0/').$line.'/'. $is_item_kit); ?>"
                                                data-value="<?php echo H(to_currency_no_money($item['item_unit_price'] - $this->Work_order->get_modifiers_unit_total($sale_id,$item_id,$line))); ?>"
                                                data-title="<?php echo lang('price') ?>"><?php echo to_currency($item['item_unit_price'] - $this->Work_order->get_modifiers_unit_total($sale_id,$item_id,$line)); ?></a>
                                            <script>
                                            $('#unit_price_<?php echo $item_id;?>').editable();
                                            </script>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>

                                <tfoot>
                                    <tr class="register-items-header">
                                        <td colspan="6" class="text-left"><strong><?php echo lang('total');?></strong>
                                        </td>
                                        <?php if($this->Employee->has_module_action_permission('work_orders', 'show_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)): ?>

                                        <td><?php echo to_currency($total_cost); ?></td>
                                        <?php endif; ?>
                                        <td><?php echo to_currency($total_price); ?></td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <!--/card-body -->
        </div>
    </div>

    <div id="kt_Files" class="tab-pane fade " role="tabpanel">


        <div class="card">
            <div class="card-body">

                <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
                    <div class="col-md-8">
                        <?php if (count($files)) {?>
                        <?php foreach($files as $file){?>
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <!--begin::Card-->
                            <div class="card h-100 ">
                                <!--begin::Card body-->
                                <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                    <!--begin::Name-->
                                    <?php   $extension = pathinfo($file->file_name, PATHINFO_EXTENSION); 
                                    if($extension =='jpg' || $extension =='png' | $extension =='gif'  ){
                                        $img_url_light = $controller_name.'/download/'.$file->file_id;
                                        $img_url_dark = $controller_name.'/download/'.$file->file_id;
                                    }else{
                                        $img_url_light = site_url().'assets/css_good/media/svg/files/'.$extension.'.svg';
                                        $img_url_dark = site_url().'assets/css_good/media/svg/files/'.$extension.'-dark.svg';
                                    }
                                  
                                  ?>
                                    <a href="<?=  $controller_name.'/download/'.$file->file_id; ?>"
                                        title="<?= $file->file_name ?>" target="_blank"
                                        class="text-gray-800 text-hover-primary d-flex flex-column">
                                        <!--begin::Image-->
                                        <div class="symbol symbol-60px mb-5">
                                            <img src="<?= $img_url_light; ?>" class="theme-light-show" alt="">
                                            <img src="<?= $img_url_dark; ?>" class="theme-dark-show" alt="">

                                        </div>
                                        <!--end::Image-->

                                        <!--begin::Title-->
                                        <div class="fs-5 fw-bold mb-2">
                                            <?= $file->file_name; ?> </div>
                                        <!--end::Title-->
                                    </a>
                                    <!--end::Name-->

                                    <!--begin::Description-->
                                    <div class="fs-7 fw-semibold text-gray-500">
                                        <?php echo anchor($controller_name.'/delete_file/'.$file->file_id,'<i class="fa fa-trash text-danger" style="font-size: 120%"></i>', array('class' => 'delete_file'));?>
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Col-->
                        <?php } ?>
                        <?php }else{

                                echo lang('no_files_found');

                        } ?>

                    </div>
                    <div class="col-md-4">
                        <h4 style="padding: 20px;"><?php echo lang('add_files');?></h4>
                        <!--begin::Repeater-->
                        <div id="kt_docs_repeater_basic">
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div data-repeater-list="kt_docs_repeater_basic">
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <label class="form-label"><?php echo  lang('file') ?>:</label>
                                                <input type="file" name="files" class="form-control " />
                                            </div>
                                            <div class="col-md-4">
                                                <a href="javascript:;" data-repeater-delete
                                                    class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                    <i class="la la-trash-o"></i><?php echo  lang('Delete') ?>
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
                                    <i class="la la-plus"></i><?php echo  lang('Add') ?>
                                </a>
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Repeater-->
                    </div>


                    <!--end::Col-->
                </div>









                <script>
                $('#kt_docs_repeater_basic').repeater({
                    initEmpty: false,

                    defaultValues: {
                        'text-input': 'foo'
                    },

                    show: function() {
                        $(this).slideDown();
                    },

                    hide: function(deleteElement) {
                        $(this).slideUp(deleteElement);
                    }
                });
                </script>

            </div>
            <!--/card-body -->
        </div>



    </div>
    <div id="kt_Activity" class="tab-pane fade " role="tabpanel">


        <div class="card">
            <div class="card-body">
                <div class="timeline-label">

                    <?php
                        foreach($this->Work_order->get_activity($work_order_info['id']) as $activity_row)
                        {
                        ?>
                    <!--begin::Item-->
                    <div class="timeline-item">
                        <!--begin::Label-->
                        <div class="timeline-label fw-bold text-gray-800 fs-6 min-w-100px">
                            <?php echo date(get_time_format(), strtotime($activity_row['activity_date']))?></div>
                        <!--end::Label-->
                        <!--begin::Badge-->
                        <div class="timeline-badge">
                            <i class="fa fa-genderless text-gray-600 fs-1"></i>
                        </div>
                        <!--end::Badge-->
                        <!--begin::Text-->
                        <div class="fw-semibold text-gray-700 ps-3 fs-7">
                            <?php echo $this->Employee->get_info($activity_row['employee_id'])->full_name;?> -
                            <?php echo date(get_date_format().' '.get_time_format(), strtotime($activity_row['activity_date']))?>:
                            <strong><?php echo $activity_row['activity_text'];?></strong>

                            <?php if($this->Employee->has_module_action_permission('work_orders', 'delete_log_activity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                            <a href="" title="<?php echo lang("delete"); ?>" class=" delete_activity"
                                title="<?php echo lang('delete'); ?>"
                                data-activity_id="<?php echo $activity_row['id']; ?>"><span class=""><i
                                        class="ion-android-delete text-danger" aria-hidden="true"></i></span></a>
                            <?php } ?>


                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <?php	
                        }
                        ?>


                </div>

            </div>
        </div>



    </div>

    <div id="kt_Settings" class="tab-pane fade show active" role="tabpanel">

        <div class="d-flex gap-4">

            <div class="  card  w-50 estimates_info">
                <div class="card-header rounded rounded-3 p-5">
                    <h3 class="panel-title"> <?php echo lang("work_orders_estimates"); ?></h3>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="input-group date">
                                <span class="input-group-text"><i class="ion-calendar"></i></span>
                                <?php echo form_input(array(
																			'type' =>'date',
																			'name'=>'estimated_repair_date',
																			'id'=>'estimated_repair_date',
																			'class'=>'form-control form-inps ',
																			'placeholder' => lang('work_orders_estimated_repair_date'),
																			'value'=>$work_order_info['estimated_repair_date'] ? date(get_date_format().' '.get_time_format(), strtotime($work_order_info['estimated_repair_date'])) : '')
																		);?>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?php echo form_input(array(
																		'class'=>'form-control',
																		'name'=>'estimated_parts',
																		'id'=>'estimated_parts',
																		'value'=>$work_order_info['estimated_parts'] ? to_currency_no_money($work_order_info['estimated_parts']) : '',
																		'placeholder' => lang("work_orders_estimated_parts")
																	)); ?>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?php echo form_input(array(
																		'class'=>'form-control',
																		'name'=>'estimated_labor',
																		'id'=>'estimated_labor',
																		'value'=>$work_order_info['estimated_labor'] ? to_currency_no_money($work_order_info['estimated_labor']) : '',
																		'placeholder' => lang("work_orders_estimated_labor")
																	)); ?>
                        </div>


                    </div>
                </div>
                <!--/card-body -->
            </div><!-- /panel-piluku -->


            <div class="card w-50 ">
                <div class="card-header rounded rounded-3 p-5">
                    <h3 class="panel-title"> <?php echo lang("work_orders_technician"); ?>
                    </h3>
                </div>

                <div class="card-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php 
																	if(!$work_order_info['employee_id']){
																		echo form_dropdown('employee_id', $employees, $work_order_info['employee_id'], 'class="form-inps" id="employee_id"');
																	}
																	else{
																?>
                        <p><strong><?php echo $work_order_info['employee_name']; ?></strong></p>
                        <p>
                            <a class="text-gray-800 text-hover-primary fs-7 fw-bold lh-0"
                                href="mailto:<?php echo $work_order_info['email']; ?>"><i
                                    class="ion-android-mail fs-5"></i>
                                <?php echo $work_order_info['email']; ?></a>
                            <a class="text-gray-800 text-hover-primary fs-7 fw-bold lh-0"
                                href="tel:<?php echo $work_order_info['phone_number']; ?>"><i
                                    class="ion-android-phone-portrait fs-7"></i>
                                <?php echo $work_order_info['phone_number']; ?></a>
                        </p>
                        <p><a class="text-gray-800 text-hover-primary fs-7 fw-bold lh-0 change_technician"
                                href="<?php echo site_url('work_orders/remove_technician') ?>"><i
                                    class="ion-android-refresh fs-7"></i>
                                <?php echo lang('work_orders_change_technician'); ?></a></p>
                        <?php 
																	}	
																?>
                    </div>
                </div>
                <!--/card-body -->
            </div><!-- /panel-piluku -->
        </div>
        <div class="d-flex gap-4">
            <?php if($this->input->get('form_id') == 'edit'){ ?>

            <div class="card  w-50  mt-3 additional_info">
                <div class="card-header rounded rounded-3 p-5">
                    <h3 class="panel-title">
                        <?php echo lang("work_orders_additional_information"); ?></h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { ?>
                        <?php
																	$custom_field = $this->Work_order->get_custom_field($k);
																	if($custom_field !== FALSE)
																	{ ?>
                        <div class="col-xs-12  m-b-20">
                            <div class="form-group">
                                <?php echo form_label($custom_field . ' :', "custom_field_${k}_value", array('class'=>'col-sm-3 control-label ')); ?>

                                <div class="col-sm-6">
                                    <?php if ($this->Work_order->get_custom_field($k,'type') == 'checkbox') { ?>

                                    <?php echo form_checkbox("custom_field_${k}_value", '1', (boolean)$work_order_info_object->{"custom_field_${k}_value"},"id='custom_field_${k}_value'");?>
                                    <label for="<?php echo "custom_field_${k}_value"; ?>"><span></span></label>

                                    <?php } elseif($this->Work_order->get_custom_field($k,'type') == 'date') { ?>

                                    <?php echo form_input(array(
																							'name'=>"custom_field_${k}_value",
																							'id'=>"custom_field_${k}_value",
																							'class'=>"custom_field_${k}_value".' form-control',
																							'value'=>is_numeric($work_order_info_object->{"custom_field_${k}_value"}) ? date(get_date_format(), $work_order_info_object->{"custom_field_${k}_value"}) : '')
																							);?>
                                    <script>
                                    var $field = <?php echo "\$('#custom_field_${k}_value')"; ?>;
                                    $field.datetimepicker({
                                        format: JS_DATE_FORMAT,
                                        locale: LOCALE,
                                        ignoreReadonly: IS_MOBILE ? true : false
                                    });
                                    </script>

                                    <?php } elseif($this->Work_order->get_custom_field($k,'type') == 'dropdown') { ?>

                                    <?php 
																							$choices = explode('|',$this->Work_order->get_custom_field($k,'choices'));
																							$select_options = array();
																							foreach($choices as $choice)
																							{
																								$select_options[$choice] = $choice;
																							}
																							echo form_dropdown("custom_field_${k}_value", $select_options, $work_order_info_object->{"custom_field_${k}_value"}, 'class="form-control"');?>

                                    <?php } elseif($this->Work_order->get_custom_field($k,'type') == 'image') {
																						echo form_input(
																							array(
																								'name'	=>	"custom_field_${k}_value",
																								'id'	=>	"custom_field_${k}_value",
																								'type' 	=> 	'file',
																								'class'	=>	"custom_field_${k}_value".' form-control',
																								'accept'=>	".png,.jpg,.jpeg,.gif"
																							),
																							NULL,
																							$work_order_info_object->{"custom_field_${k}_value"} ? "" : ''
																						);
												
																						if ($work_order_info_object->{"custom_field_${k}_value"})
																						{
																							echo "<img width='30%' src='".cacheable_app_file_url($work_order_info_object->{"custom_field_${k}_value"})."' />";
																							echo "<div class='delete-custom-image'><a href='".site_url('work_orders/delete_custom_field_value/'.$work_order_info_object->id.'/'.$k)."'>".lang('delete')."</a></div>";
																							
																						} ?>

                                    <?php }  elseif($this->Work_order->get_custom_field($k,'type') == 'file') {
																							echo form_input(
																								array(
																									'name'=>"custom_field_${k}_value",
																									'id'=>"custom_field_${k}_value",
																									'type' => 'file',
																									'class'=>"custom_field_${k}_value".' form-control'
																								),
																								NULL,
																								$work_order_info_object->{"custom_field_${k}_value"} ? "" : ''
																							);

																							if ($work_order_info_object->{"custom_field_${k}_value"})
																							{
																								echo anchor('work_orders/download/'.$work_order_info_object->{"custom_field_${k}_value"},$this->Appfile->get_file_info($work_order_info_object->{"custom_field_${k}_value"})->file_name,array('target' => '_blank'));
																								echo "<div class='delete-custom-image'><a href='".site_url('work_orders/delete_custom_field_value/'.$work_order_info_object->id.'/'.$k)."'>".lang('delete')."</a></div>";
																							}
																							
																						?>
                                    <?php } else {
																					
																							echo form_input(array(
																							'name'=>"custom_field_${k}_value",
																							'id'=>"custom_field_${k}_value",
																							'class'=>"custom_field_${k}_value".' form-control',
																							'value'=>$work_order_info_object->{"custom_field_${k}_value"})
																							);?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php } //end if?>
                        <?php } //end for loop?>
                    </div>
                </div>
                <!--/card-body -->
            </div><!-- /panel-piluku -->

            <?php } ?>

            <?php if($this->input->get('form_id') != 'edit'){ ?>

            <div class="card  w-50 mt-3 additional_info">
                <div class="card-header rounded rounded-3 p-5">
                    <h3 class="panel-title">
                        <?php echo lang("work_orders_additional_information"); ?></h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { ?>
                        <?php
																	$custom_field = $this->Work_order->get_custom_field($k);
																	if($custom_field !== FALSE)
																	{ ?>
                        <div class="col-xs-12 m-b-20">
                            <div class="form-group">
                                <?php echo form_label($custom_field . ' :', "custom_field_${k}_value", array('class'=>'col-sm-3 control-label ')); ?>

                                <div class="col-sm-6">
                                    <?php if ($this->Work_order->get_custom_field($k,'type') == 'checkbox') { ?>

                                    <?php echo form_checkbox("custom_field_${k}_value", '1', (boolean)$work_order_info_object->{"custom_field_${k}_value"},"id='custom_field_${k}_value'");?>
                                    <label for="<?php echo "custom_field_${k}_value"; ?>"><span></span></label>

                                    <?php } elseif($this->Work_order->get_custom_field($k,'type') == 'date') { ?>

                                    <?php echo form_input(array(
																							'name'=>"custom_field_${k}_value",
																							'id'=>"custom_field_${k}_value",
																							'class'=>"custom_field_${k}_value".' form-control',
																							'value'=>is_numeric($work_order_info_object->{"custom_field_${k}_value"}) ? date(get_date_format(), $work_order_info_object->{"custom_field_${k}_value"}) : '')
																							);?>
                                    <script>
                                    var $field = <?php echo "\$('#custom_field_${k}_value')"; ?>;
                                    $field.datetimepicker({
                                        format: JS_DATE_FORMAT,
                                        locale: LOCALE,
                                        ignoreReadonly: IS_MOBILE ? true : false
                                    });
                                    </script>

                                    <?php } elseif($this->Work_order->get_custom_field($k,'type') == 'dropdown') { ?>

                                    <?php 
																							$choices = explode('|',$this->Work_order->get_custom_field($k,'choices'));
																							$select_options = array();
																							foreach($choices as $choice)
																							{
																								$select_options[$choice] = $choice;
																							}
																							echo form_dropdown("custom_field_${k}_value", $select_options, $work_order_info_object->{"custom_field_${k}_value"}, 'class="form-control"');?>

                                    <?php } else {
																				
																							echo form_input(array(
																							'name'=>"custom_field_${k}_value",
																							'id'=>"custom_field_${k}_value",
																							'class'=>"custom_field_${k}_value".' form-control',
																							'value'=>$work_order_info_object->{"custom_field_${k}_value"})
																							);?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php } //end if?>
                        <?php } //end for loop?>
                    </div>
                </div>
                <!--/card-body -->
            </div><!-- /panel-piluku -->

            <?php } ?>


            <div class="card w-50 mt-3  additional_info">
                <div class="card-header rounded rounded-3 p-5">
                    <h3 class="panel-title">
                        <?php lang('work_orders_pre')." ".lang("work_orders_checkbox_list"); echo lang('work_orders_work_order_checkbox_groups'); ?>
                    </h3>&nbsp;
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#work_order_checkbox_modal"><?php echo lang('work_orders_change_group'); ?></button>
                </div>

                <div class="card-body">
                    <?php $num_itemss = count($selected_checkbox_groups); $ik = 0; foreach($selected_checkbox_groups as $group){ ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <label><?php echo $group->name; ?></label>

                            <?php
																		$preorder_list = null;
																		$postorder_list = null;
																		foreach ( $this->Work_order->get_all_checkboxes($group->id, 1) as $checkbox_pre ){
																			if($this->Work_order->workorder_checkbox_exists($work_order_id, $checkbox_pre['id'])){
																				$preorder_list .= '<div class="col-lg-3 "><label class="control-label wide" style="margin-right:38px;">'.$checkbox_pre['name'].'</label></div>';
																			}
																		}

																		foreach ( $this->Work_order->get_all_checkboxes($group->id, 2) as $checkbox_post ){
																			if($this->Work_order->workorder_checkbox_exists($work_order_id, $checkbox_post['id'])){
																				$postorder_list .= '<div class="col-lg-6"><label class="control-label wide" style="margin-right:38px;">'.$checkbox_post['name'].'</label></div>';
																			}
																		}

																	?>

                            <?php if($preorder_list) {?>
                            <ul style="list-style:none;">
                                <li><?php echo form_label(lang('work_orders_pre')." ".lang("work_orders_checkbox_list"), 'checkbox_type_pre_'.$group->id, array('class'=>'','style'=>'margin-right:38px;font-width:bold;')); ?>
                                </li>

                                <li>
                                    <div class="row">
                                        <?php echo $preorder_list; ?>
                                    </div>
                                </li>
                            </ul>
                            <br>
                            <?php } ?>

                            <?php if($postorder_list) {?>
                            <ul style="list-style:none;">
                                <li><?php echo form_label(lang('work_orders_post')." ".lang("work_orders_checkbox_list"), 'checkbox_type_post_'.$group->id, array('class'=>'','style'=>'margin-right:38px;font-width:bold;')); ?>
                                </li>

                                <li>
                                    <div class="row">
                                        <?php echo $postorder_list; ?>
                                    </div>
                                </li>
                            </ul>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if(++$ik !== $num_itemss) { echo "<hr>";} } ?>

                </div>
                <!--/card-body -->
            </div><!-- /panel-piluku -->


            <?php if ($work_order_info['pre_auth_signature_file_id'] || $work_order_info['post_auth_signature_file_id']) { ?>

            <div class="card w-50 mt-3 additional_info">
                <div class="card-header rounded rounded-3 p-5">
                    <h3 class="panel-title"><i class="ion-information"></i> <?php echo lang("work_orders_auth"); ?>
                    </h3>
                </div>

                <div class="card-body">

                    <?php
																if ($work_order_info['pre_auth_signature_file_id'])
																{
																	echo "<div class='row item_name_and_warranty'>";
																	echo "<div class='col-md-8'>";
																	
																	echo '<span>'.lang('locations_blockchyp_work_order_pre_auth').'</span>';
																	echo img(array('src' => secure_app_file_url($work_order_info['pre_auth_signature_file_id'])));
																	echo '</div></div>';
																}
																?>

                    <?php
																if ($work_order_info['post_auth_signature_file_id'])
																{
																	echo "<div class='row item_name_and_warranty'>";
																	echo "<div class='col-md-8'>";
																	
																	echo '<span>'.lang('locations_blockchyp_work_order_post_auth').'</span>';
																	echo img(array('src' => secure_app_file_url($work_order_info['post_auth_signature_file_id'])));
																	echo '</div></div>';
																}
																?>

                </div>
                <!--/card-body -->
            </div><!-- /panel-piluku -->

            <?php } ?>


        </div>





        <div class="card mt-3  images_info">
            <div class="card-header rounded rounded-3 p-5">
                <h3 class="panel-title"><?php echo lang("work_orders_images"); ?></h3>
            </div>

            <div class="card-body">
                <div class="form-group d-flex-rtl">
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <div class="dropzone dz-clickable" id="dropzoneUpload">
                            <div class="dz-message">
                                <?php echo lang('drag_and_drop_or_click'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-8 col-lg-8">
                        <div class="owl-carousel owl-theme note_images">
                            <?php foreach($work_order_images as $key => $image){ ?>
                            <div class="col-lg-12">
                                <!--begin::Item-->
                                <a class="d-block card-rounded overlay" data-fslightbox="lightbox-projects"
                                    href="<?php echo app_file_url($image); ?>">
                                    <!--begin::Image-->
                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-250px"
                                        style="background-image:url('<?php echo app_file_url($image); ?>')">
                                    </div>
                                    <!--end::Image-->

                                    <!--begin::Action-->
                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                        <i class="bi bi-eye-fill fs-3x text-white"></i>
                                    </div>
                                    <!--end::Action-->
                                </a>
                                <!--end::Item-->
                            </div>
                            <?php } ?>


                        </div>
                    </div>
                </div>
            </div>
            <!--/card-body -->
        </div><!-- /panel-piluku -->






    </div>

    <?php echo form_close(); ?>

    <div id="kt_Notes" class="tab-pane fade " role="tabpanel">





        <?php echo form_open_multipart('work_orders/save_repaired_item_notes/',array('id'=>'sale_item_notes_form')); ?>
        <!-- item_id_being_repaired to save notes -->
        <?php $status_name = $this->Work_order->get_status_name($work_order_status_info->name); ?>
        <input type="hidden" name="item_id_being_repaired" id="item_id_being_repaired"
            value="<?php echo $item_id ?? 0; ?>">
        <input type="hidden" name="sale_id" id="sale_id" value="<?php echo $sale_id; ?>">
        <input type="hidden" name="note_id" id="note_id" value="">
        <input type="hidden" name="sale_item_note" id="sale_item_note" value="<?php echo $status_name; ?>">
        <input type="hidden" name="status_id" id="status_id" value="<?php echo $work_order_info['status']; ?>">
        <input type="hidden" name="device_location" id="device_location" value="">



        <div class="row">
            <div class="col-md-8">
                <?php foreach($notes as $note){ ?>

                <div class="col-md-6  <?php echo $note['internal'] ? 'interal_note' : ''; ?>">
                    <div class="card mb-6 mb-xl-9">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Header-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Badge-->
                                <div class="badge badge-success"><?php echo $note['note']; ?></div>
                                <!--end::Badge-->

                                <!--begin::Menu-->
                                <div>
                                    <button type="button"
                                        class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <span class="svg-icon svg-icon-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4"
                                                    fill="currentColor"></rect>
                                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3"
                                                    fill="currentColor"></rect>
                                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3"
                                                    fill="currentColor"></rect>
                                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3"
                                                    fill="currentColor"></rect>
                                            </svg>
                                        </span></button>

                                    <!--begin::Menu 3-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                        data-kt-menu="true">
                                        <!--begin::Heading-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                Payments
                                            </div>
                                        </div>
                                        <!--end::Heading-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" title="<?php echo lang("edit"); ?>"
                                                class="edit_note_btn menu-link px-3" title="<?php echo lang('edit'); ?>"
                                                data-note_id="<?php echo $note['note_id']; ?>"
                                                data-note="<?php echo $note['note']; ?>"
                                                data-detailed_notes="<?php echo $note['detailed_notes']; ?>"
                                                data-internal="<?php echo $note['internal']; ?>"
                                                data-device_location="<?php echo $note['device_location'] ? $note['device_location'] : lang('location'); ?>"><span
                                                    class=""><i class="ion-edit" aria-hidden="true"></i></span>
                                                <?php echo lang('Edit') ?></a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" title="<?php echo lang("delete"); ?>"
                                                class="delete_note_btn menu-link px-3"
                                                title="<?php echo lang('delete'); ?>"
                                                data-note_id="<?php echo $note['note_id']; ?>"><span class=""><i
                                                        class="ion-android-delete" aria-hidden="true">
                                                        <?php echo lang('Delete') ?></i></span></a>

                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->


                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Title-->
                            <div class="mb-2">
                                <a href="#"
                                    class="fs-4 fw-bold mb-1 text-gray-900 text-hover-primary"><?= lang('note'). '# ' .$note['note_id'];  ?></a>
                            </div>
                            <!--end::Title-->

                            <!--begin::Content-->
                            <div class="fs-6 fw-semibold text-gray-600 mb-5"><?php echo $note['detailed_notes']; ?>
                            </div>
                            <!--end::Content-->

                            <!--begin::Footer-->
                            <div class="d-flex flex-stack flex-wrapr">


                                <!--begin::Stats-->
                                <div class="d-flex my-1 gap-2">
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-dashed border-gray-300 rounded d-flex align-items-center py-2 px-3">
                                        <i class="ion-person"></i> <span
                                            class="ms-1 fs-7 fw-bold text-gray-600"><?php echo $note['first_name'].' '.$note['last_name']; ?></span>
                                    </div>
                                    <!--end::Stat-->
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-dashed border-gray-300 rounded d-flex align-items-center py-2 px-3">
                                        <i class="ion-clock"></i> <span
                                            class="ms-1 fs-7 fw-bold text-gray-600"><?php echo date(get_date_format().' '.get_time_format(), strtotime($note['note_timestamp'])); ?></span>
                                    </div>
                                    <!--end::Stat-->

                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Footer-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>








                <?php } ?>

            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <?php echo form_label(lang('sales_detailed_note'), 'sale_item_detailed_notes',array('class'=>'control-label wide')); ?>
                            <?php echo form_textarea(array(
																'name'=>'sale_item_detailed_notes',
																'id'=>'sale_item_detailed_notes',
																'class'=>'form-control text-area input_radius',
																'cols'=>'17')
															);?>

                        </div>
                        <!--/card-body -->

                        <div class="">
                            <table style="width:100%;">
                                <tr>
                                    <td class="form-check form-check-custom form-check-solid" style="width:100%">
                                        <?php echo form_checkbox(array(
																		'name'=>'sale_item_note_internal',
																		'id'=>'sale_item_note_internal',
																		'value'=>'sale_item_note_internal',
																		'class' => 'form-check-input',
																		'checked'=> $this->config->item('work_order_notes_internal') ? 1 : 0 )
																		);?>

                                        <label for="sale_item_note_internal"
                                            style="padding-left: 10px;"><span></span></label>
                                        <?php echo form_label(lang('sales_internal_note'), 'sale_item_note_internal',array('class'=>'form-check-label w-100px','style'=>'padding-top:4px;')); ?>
                                    </td>

                                    <td style="width:33%">
                                        <?php if($this->config->item('work_order_device_locations')) {?>
                                        <div class="input-append">
                                            <div class="btn-group dropup">
                                                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                    <span
                                                        id="device_location_btn"><?php echo lang('location'); ?></span>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <?php foreach(explode(',', $this->config->item('work_order_device_locations')) as $location) { ?>
                                                    <li class="dropdown_submenu device_locations"
                                                        onclick="$('#device_location_btn').html('<?php echo $location; ?>'); $('#device_location').val('<?php echo $location; ?>');">
                                                        <?php echo $location; ?></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </td>

                                    <td style="width:33%">
                                        <div class="input-append">
                                            <div class="btn-group dropup">
                                                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                                    style="background-color:<?php echo $status_color = $work_order_status_info->color; ?>">
                                                    <span id="current_status"><?php echo $status_name; ?></span>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <?php foreach($all_workorder_statuses as $id => $status) { ?>
                                                    <li class="dropdown_submenu change_workorder_status"
                                                        data-status_name="<?php echo $status['name']; ?>"
                                                        data-status_id="<?php echo $id; ?>"
                                                        data-status_color="<?php echo $status['color']; ?>"><span
                                                            class="status_color"
                                                            style="background-color:<?php echo $status['color']; ?>;">&nbsp;&nbsp;</span>
                                                        <?php echo $status['name']; ?></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <button type="submit" class="btn btn-success btn-block"
                                id="note_button"><?php echo lang('work_orders_save_note'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>







        <?php echo form_close(); ?>




    </div>



</div>


<!--end::Tab pane-->
</div>
<div class="modal fade" id="work_order_checkbox_modal" tabindex="-1" role="dialog"
    aria-labelledby="work_order_checkbox_modal" aria-hidden="true">
    <div class="modal-dialog" style="width:75%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true"
                        class="ti-close"></span></button>
                <h4 class="modal-title"> <?php echo lang('work_orders_work_order_checkbox_groups'); ?></h4>
            </div>
            <div class="modal-body">
                <?php $num_items = count($checkbox_groups); $ik = 0; foreach($checkbox_groups as $group){ ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-check">
                            <?php
									echo form_checkbox(array(
										'name'=>'checkbox_group',
										'id'=>'checkbox_group_'.$group->id,
										'value'=> $group->id,
										'class'=>"checkbox_group form-check-input",
										'checked'=> false,
										'data-workorder-id'=>$work_order_id,
										'data-group-id'=>$group->id
									));
								?>

                            <label class="form-check-label"
                                for="<?php echo 'checkbox_group_'.$group->id;?>"><span></span></label>
                            <?php echo form_label($group->name, 'checkbox_group_'.$group->id, array('class'=>'form-check-label','style'=>'margin-right:38px;font-width:bold;')); ?>
                        </div>
                        <ul style="list-style:none;">
                            <li class="form-check">
                                <?php
											echo form_checkbox(array(
												'name'=>'checkbox_type_pre['.$group->id.']',
												'id'=>'checkbox_type_pre_'.$group->id,
												'value'=> 'pre',
												'class'=>"checkbox_type checkbox_type_pre form-check-input",
												'checked'=> false,
												'data-group-id'=>$group->id
											));
										?>

                                <label class="form-check-label"
                                    for="<?php echo 'checkbox_type_pre_'.$group->id;?>"><span></span></label>
                                <?php echo form_label(lang('work_orders_pre')." ".lang("work_orders_checkbox_list"), 'checkbox_type_pre_'.$group->id, array('class'=>'form-check-label','style'=>'margin-right:38px;font-width:bold;')); ?>
                            </li>

                            <li>
                                <div class=" d-flex">
                                    <?php foreach ( $this->Work_order->get_all_checkboxes($group->id, 1) as $checkbox_pre ){ ?>

                                    <div class="form-check">
                                        <?php
														echo form_checkbox(array(
															'name'=>'checkbox_pre['.$group->id.']['.$checkbox_pre['id'].']',
															'id'=>'checkbox_pre_'.$checkbox_pre['id'],
															'value'=>$checkbox_pre['id'],
															'class'=>'single_checkbox pre_checkboxes form-check-input checkbox_pre_'.$group->id.' checkbox_'.$group->id,
															'checked'=> $this->Work_order->workorder_checkbox_exists($work_order_id, $checkbox_pre['id']),
															'data-group-id'=>$group->id,
															'data-checkbox-id'=>$checkbox_pre['id']
														));
													?>
                                        <label class="form-check-label"
                                            for="<?php echo 'checkbox_pre_'.$checkbox_pre['id'];?>"><span></span></label>
                                        <?php echo form_label($checkbox_pre['name'], 'checkbox_pre_'.$checkbox_pre['id'],array('class'=>'control-label form-check-label wide','style'=>'margin-right:38px;')); ?>
                                    </div>

                                    <?php } ?>
                                </div>
                            </li>
                        </ul>
                        <br>

                        <ul style="list-style:none;">
                            <li class="form-check">
                                <?php
											echo form_checkbox(array(
												'name'=>'checkbox_type_post['.$group->id.']',
												'id'=>'checkbox_type_post_'.$group->id,
												'value'=> 'post',
												'class'=>"checkbox_type checkbox_type_post form-check-input",
												'checked'=> false,
												'data-group-id'=>$group->id
											));
										?>

                                <label class="form-check-label"
                                    for="<?php echo 'checkbox_type_post_'.$group->id;?>"><span></span></label>
                                <?php echo form_label(lang('work_orders_post')." ".lang("work_orders_checkbox_list"), 'checkbox_type_post_'.$group->id, array('class'=>'form-check-label','style'=>'margin-right:38px;font-width:bold;')); ?>
                            </li>

                            <li>
                                <div class="d-flex">
                                    <?php foreach ( $this->Work_order->get_all_checkboxes($group->id, 2) as $checkbox_post ){ ?>

                                    <div class="form-check">
                                        <?php
														echo form_checkbox(array(
															'name'=>'checkbox_post['.$group->id.']['.$checkbox_post['id'].']',
															'id'=>'checkbox_post_'.$checkbox_post['id'],
															'value'=>$checkbox_post['id'],
															'class'=>'single_checkbox post_checkboxes  form-check-input checkbox_post_'.$group->id.' checkbox_'.$group->id,
															'checked'=> $this->Work_order->workorder_checkbox_exists($work_order_id, $checkbox_post['id']),
															'data-group-id'=>$group->id,
															'data-checkbox-id'=>$checkbox_post['id'],
														));
													?>
                                        <label class="form-check-label"
                                            for="<?php echo 'checkbox_post_'.$checkbox_post['id'];?>"><span></span></label>
                                        <?php echo form_label($checkbox_post['name'], 'checkbox_post_'.$checkbox_post['id'], array('class'=>'control-label form-check-label wide','style'=>'margin-right:38px;')); ?>
                                    </div>

                                    <?php } ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php if(++$ik !== $num_items) { echo "<hr>";} } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('submit');?></button>
            </div>
        </div>
    </div>
</div>
</div>
<br>

<div class="form-actions">
    <input type="button" name="submitf" value="Save" id="submitf"
        class="submit_button floating-button btn btn-lg btn-danger">
</div>
</div>


<script type='text/javascript'>
var work_order_id = <?php echo $work_order_info['id']; ?>;
date_time_picker_field($('.datepicker'), JS_DATE_FORMAT + " " + JS_TIME_FORMAT);

var $form = $('#work_order_form');

$(document).ready(function() {


    var $owl = $('.note_images');
    $owl.trigger('destroy.owl.carousel');

    $owl.owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        navText: ['<i class="ion-ios-arrow-back"></i>', '<i class="ion-ios-arrow-forward"></i>'],
        dots: false,
        items: 4
    });

    $("#employee_id").select2();
});

$('.checkbox_group').change(function() {
    var group_id = $(this).data('group-id');

    $(".checkbox_type_pre").prop('checked', false);
    $(".checkbox_type_post").prop('checked', false);

    $(".pre_checkboxes").prop('checked', false);
    $(".post_checkboxes").prop('checked', false);

    var checkbox_state = 0;
    if ($(this).is(":checked")) {
        checkbox_state = 1;
    }

    check_pre_checkboxes(group_id, checkbox_state);
    check_post_checkboxes(group_id, checkbox_state);
    get_selected_checkboxes(group_id);
});

$('.checkbox_type_pre').change(function() {
    var group_id = $(this).data('group-id');

    var checkbox_state = 0;
    if ($(this).is(":checked")) {
        checkbox_state = 1;
    }

    $(".checkbox_group").prop('checked', false);
    $(".checkbox_type_pre").prop('checked', false);
    $(".pre_checkboxes").prop('checked', false);

    check_pre_checkboxes(group_id, checkbox_state);
    get_selected_checkboxes(group_id);
});

$('.checkbox_type_post').change(function() {
    var group_id = $(this).data('group-id');

    var checkbox_state = 0;
    if ($(this).is(":checked")) {
        checkbox_state = 1;
    }

    $(".checkbox_group").prop('checked', false);
    $(".checkbox_type_post").prop('checked', false);
    $(".post_checkboxes").prop('checked', false);

    check_post_checkboxes(group_id, checkbox_state);
    get_selected_checkboxes(group_id);
});

$(".pre_checkboxes").change(function() {
    var group_id = $(this).data('group-id');

    var checkbox_state = 0;
    $(".pre_checkboxes").each(function() {

        if ($(this).is(":checked")) {
            checkbox_state = 1;
        }
    });

    $("#checkbox_type_pre_" + group_id).prop('checked', checkbox_state);

    check_group(group_id);
    get_selected_checkboxes(group_id);
});

$(".post_checkboxes").change(function() {
    var group_id = $(this).data('group-id');

    var checkbox_state = 0;
    $(".post_checkboxes").each(function() {

        if ($(this).is(":checked")) {
            checkbox_state = 1;
        }
    });

    $("#checkbox_type_post_" + group_id).prop('checked', checkbox_state);

    check_group(group_id);
    get_selected_checkboxes(group_id);

});

$(".pre_checkboxes").each(function() {
    if ($(this).is(":checked")) {
        var group_id = $(this).data("group-id");
        $("#checkbox_type_pre_" + group_id).prop('checked', true);
        check_group(group_id);
        return false;
    }
});

$(".post_checkboxes").each(function() {
    if ($(this).is(":checked")) {
        var group_id = $(this).data("group-id");
        $("#checkbox_type_post_" + group_id).prop('checked', true);
        check_group(group_id);
        return false;
    }
});

function get_selected_checkboxes(group_id) {
    var selected_checkboxes = [];
    $(".checkbox_" + group_id).each(function() {
        if ($(this).is(":checked")) {
            selected_checkboxes.push($(this).val());
        }
    });

    $.ajax({
        type: 'POST',
        url: '<?php echo site_url('work_orders/set_checkbox'); ?>',
        data: {
            'workorder_id': work_order_id,
            'checkbox_ids': selected_checkboxes,
        },
        success: function(ret) {
            var response = JSON.parse(ret);
            show_feedback(response.success ? 'success' : 'error', response.message, response.success ?
                <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);
        }
    });
}

function check_pre_checkboxes($group_id, $checkbox_state) {
    $("#checkbox_type_pre_" + $group_id).prop('checked', $checkbox_state);
    $(".checkbox_pre_" + $group_id).prop('checked', $checkbox_state);
    check_group($group_id);
}

function check_post_checkboxes($group_id, $checkbox_state) {
    $("#checkbox_type_post_" + $group_id).prop('checked', $checkbox_state);
    $(".checkbox_post_" + $group_id).prop('checked', $checkbox_state);
    check_group($group_id);
}

function check_group($group_id) {
    is_group_checked = false;
    $(".checkbox_" + $group_id).each(function() {
        if ($(this).is(":checked")) {
            is_group_checked = true;
        }
    });

    $("#checkbox_group_" + $group_id).prop('checked', is_group_checked);

    $(".single_checkbox").each(function() {
        if ($(this).is(":checked")) {
            if ($(this).data("group-id") != $group_id) {
                $(this).prop('checked', false);
            }
        }
    });

    $(".checkbox_type").each(function() {
        if ($(this).is(":checked")) {
            if ($(this).data("group-id") != $group_id) {
                $(this).prop('checked', false);
            }
        }
    });

    $(".checkbox_group").each(function() {
        if ($(this).is(":checked")) {
            if ($(this).data("group-id") != $group_id) {
                $(this).prop('checked', false);
            }
        }
    });

}

$(".new_note_icon").click(function() {

    $("#sale_item_note").val('');
    $("#sale_item_detailed_notes").val('');

    var internal_default_value = false;
    <?php if($this->config->item('work_order_notes_internal') == 1){ ?>
    internal_default_value = true;
    <?php } ?>

    $("#sale_item_note_internal").prop('checked', internal_default_value);
    $("#note_id").val('');

    $(".sale_item_notes_modal").modal('show');

    $(".sale_item_notes_modal").on('shown.bs.modal', function(e) {
        $('#sale_item_note').focus();
    });
});

$(document).on('click', '.note_images .owl_carousel_item_img', function() {
    $(".sale_item_notes_image").attr('src', $(this).attr('src'));
    $("#sale_item_notes_image_modal").modal('show');
});

$("#sale_item_notes_form").submit(function(event) {

    event.preventDefault();
    $('#work_order_form').ajaxSubmit({
        success: function(response, status) {
            if ($("#item_id_being_repaired").val() == '') {
                show_feedback('error', '<?php echo lang('work_orders_must_select_item'); ?>',
                    '<?php echo lang('error'); ?>');
                $("#work_orders_please_enter_note").focus();
                return;
            }
            $("#grid-loader").show();
            $("#sale_item_notes_form").ajaxSubmit({
                success: function(response, statusText, xhr, $form) {
                    $(".sale_item_notes_modal").modal('hide');
                    $("#grid-loader").hide();
                    window.location.reload();
                }
            });
        },
        dataType: 'json'
    });
});

$(".change_workorder_status").click(function() {
    var sale_item_note = $(this).data("status_name");
    $("#sale_item_note").val(sale_item_note);

    if ($("#item_id_being_repaired").val() == '') {
        show_feedback('error', '<?php echo lang('work_orders_must_select_item'); ?>',
            '<?php echo lang('error'); ?>');
        $("#work_orders_please_enter_note").focus();
        return false;
    }

    var status_id = $(this).data("status_id");
    $("#status_id").val(status_id);

    $("#current_status").html(sale_item_note);
    $("#current_status").parent().css('background-color', $(this).data('status_color'));
    if ($("#note_id").val()) {
        return;
    }
    $("#grid-loader").show();
    $('#sale_item_notes_form').submit();
    return true;
});

Dropzone.autoDiscover = false;
Dropzone.options.dropzoneUpload = {
    url: "<?php echo site_url('work_orders/workorder_images_upload'); ?>",
    autoProcessQueue: true,
    acceptedFiles: "image/*",
    uploadMultiple: true,
    parallelUploads: 100,
    maxFiles: 100,
    addRemoveLinks: true,
    dictRemoveFile: "Remove",
    init: function() {
        myDropzone = this;
        this.on("success", function(file, responseText) {
            window.location.reload();
        });
    }
};
$('#dropzoneUpload').dropzone();

myDropzone.on('sending', function(file, xhr, formData) {
    formData.append('work_order_id', work_order_id);
});

$('.delete-item').click(function(event) {
    event.preventDefault();
    $.post($(this).attr('href'), function(response) {
        window.location.reload();
    });
});

if ($("#item").length) {
    $("#item").autocomplete({
        source: '<?php echo site_url("work_orders/item_search");?>',
        delay: 150,
        autoFocus: false,
        minLength: 0,
        select: function(event, ui) {
            var item_description = $("#item_description").val();

            if (ui.item.value == false) {
                add_additional_item(item_description);
            } else {
                <?php if($work_orders_repair_item){?>
                if (ui.item.value == <?php echo $work_orders_repair_item; ?>) {
                    add_additional_item(item_description);
                } else {
                    item_select(ui.item.value);
                }
                <?php } else { ?>
                item_select(ui.item.value);
                <?php } ?>
            }
        },
    }).data("ui-autocomplete")._renderItem = function(ul, item) {
        var item_details = '<a class="suggest-item">' +
            '<div class="item-image">' +
            '<img src="' + item.image + '" alt="">' +
            '</div>' +

            '<div class="details">' +
            '<div class="name">' +
            item.label +
            '</div>' +
            '<span class="name small">' +
            (item.subtitle ? item.subtitle : '') +
            '</span>' +
            '<span class="attributes">' + '<?php echo lang("category"); ?>' + ' : <span class="value">' + (item
                .category ? item.category : <?php echo json_encode(lang('none')); ?>) + '</span></span>' +
            <?php if ($this->Employee->has_module_action_permission('items', 'see_item_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>(
                typeof item.quantity !== 'undefined' && item.quantity !== null ? '<span class="attributes">' +
                '<?php echo lang("quantity"); ?>' + ' <span class="value">' + item.quantity + '</span></span>' : ''
            ) +
            <?php } ?>(item.attributes ? '<span class="attributes">' + '<?php echo lang("attributes"); ?>' +
                ' : <span class="value">' + item.attributes + '</span></span>' : '') +
            '</div>' +
            '</a>';

        return $("<li class='item-suggestions'></li>")
            .data("item.autocomplete", item)
            .append(item_details)
            .appendTo(ul);
    };

    <?php
		$vendor_list = array();
		if($this->config->item('branding')['code'] == 'phpsalesmanager'){
			if($this->config->item('ig_api_bearer_token') && $this->config->item('enable_ig_integration')){
				array_push($vendor_list, 'ig_api_bearer_token');
			}

			if($this->config->item('wgp_integration_pkey') && $this->config->item('enable_wgp_integration')){
				array_push($vendor_list, 'wgp_integration_pkey');
			}

			if($this->config->item('p4_api_bearer_token') && $this->config->item('enable_p4_integration')){
				array_push($vendor_list, 'p4_api_bearer_token');
			}
		}
		?>

    var search_outside_buttons = {
        <?php if( in_array('ig_api_bearer_token', $vendor_list)){ ?>
        api_ig: {
            label: 'Injured Gadgets',
            className: 'btn-info',
            callback: function() {
                $("#item").autocomplete('option', 'source',
                    '<?php echo site_url("home/sync_ig_item_search"); ?>');

                $("#item").autocomplete('option', 'response',
                    function(event, ui) {
                        $("#work_order_form .spinner").hide();
                        var source_url = $("#item").autocomplete('option', 'source');

                        if (ui.content.length == 0 && (source_url.indexOf('work_orders/item_search') > -
                                1) && $("#work_order_form #item").val().trim() != "") {

                        } else if (ui.content.length == 0 && (source_url.indexOf(
                                'home/sync_ig_item_search') > -1)) {
                            var noResult = {
                                value: "",
                                image: "<?php echo base_url()."assets/img/item.png"; ?>",
                                label: "<?php echo lang("sales_no_result_found_ig"); ?>"
                            };
                            ui.content.push(noResult);
                            $("#item").autocomplete('option', 'source',
                                '<?php echo site_url("work_orders/item_search"); ?>');
                        } else {
                            $("#item").autocomplete('option', 'source',
                                '<?php echo site_url("work_orders/item_search"); ?>');
                        }
                    }
                );

                $("#item").autocomplete('search');
                $("#work_order_form .spinner").show();

            }
        },

        <?php } if( in_array('wgp_integration_pkey', $vendor_list)) { ?>
        api_wgp: {
            label: 'WGP',
            className: 'btn-info',
            callback: function() {

                $("#item").autocomplete('option', 'source',
                    '<?php echo site_url("home/sync_wgp_inventory_search"); ?>');

                $("#item").autocomplete('option', 'response',
                    function(event, ui) {
                        $("#work_order_form .spinner").hide();

                        var source_url = $("#item").autocomplete('option', 'source');

                        if (ui.content.length == 0 && (source_url.indexOf('work_orders/item_search') > -
                                1) && $("#work_order_form #item").val().trim() != "") {

                        } else if (ui.content.length == 0 && (source_url.indexOf(
                                'home/sync_wgp_inventory_search') > -1)) {
                            var noResult = {
                                value: "",
                                image: "<?php echo base_url()."assets/img/item.png"; ?>",
                                label: "<?php echo lang("sales_no_result_found_wgp"); ?>"
                            };
                            ui.content.push(noResult);
                            $("#item").autocomplete('option', 'source',
                                '<?php echo site_url("work_orders/item_search"); ?>');
                        } else {
                            $("#item").autocomplete('option', 'source',
                                '<?php echo site_url("work_orders/item_search"); ?>');
                        }
                    }
                );

                $("#item").autocomplete('search');
                $("#work_order_form .spinner").show();

            }
        },

        <?php } if(in_array("p4_api_bearer_token", $vendor_list)){ ?>
        api_p4: {
            label: 'Parts4Cells',
            className: 'btn-info',
            callback: function() {
                $("#item").autocomplete('option', 'source',
                    '<?php echo site_url("home/sync_p4_item_search"); ?>');

                $("#item").autocomplete('option', 'response',
                    function(event, ui) {
                        $("#work_order_form .spinner").hide();

                        var source_url = $("#item").autocomplete('option', 'source');

                        if (ui.content.length == 0 && (source_url.indexOf('work_orders/item_search') > -
                                1) && $("#work_order_form #item").val().trim() != "") {

                        } else if (ui.content.length == 0 && (source_url.indexOf(
                                'home/sync_p4_item_search') > -1)) {
                            var noResult = {
                                value: "",
                                image: "<?php echo base_url()."assets/img/item.png"; ?>",
                                label: "<?php echo lang("sales_no_result_found_p4"); ?>"
                            };
                            ui.content.push(noResult);
                            $("#item").autocomplete('option', 'source',
                                '<?php echo site_url("work_orders/item_search"); ?>');
                        } else {
                            $("#item").autocomplete('option', 'source',
                                '<?php echo site_url("work_orders/item_search"); ?>');
                        }
                    }
                );

                $("#item").autocomplete('search');
                $("#work_order_form .spinner").show();

            }
        },
        <?php } ?>

        cancel: {
            label: '<?php echo lang("cancel"); ?>',
            className: 'btn-info',
            callback: function() {}
        }
    }

    $('#item').bind('keypress', function(e) {
            if (e.keyCode == 13) {
                auto_save_form();
                e.preventDefault();

                localStorage.setItem('item_search_key', $("#work_order_form #item").val());
                var search_value = $("#item").val();

                var item_found = true;
                $.post('<?php echo site_url("work_orders/add_sale_item");?>', {
                    item: search_value,
                    sale_id: "<?php echo $sale_id; ?>"
                }, function(response) {

                    item_found = false;
                    var data = JSON.parse(response);

                    if (data.redirect) {
                        // location.href = data.redirect;
                        return false;
                    } else if (data.success) {
                        item_found = true;
                        // window.location.reload();
                        return false;
                    } else if (data.success == false && data.message) {
                        item_found = true;
                        show_feedback('error', data.message, <?php echo json_encode(lang('error')); ?>);
                        return false;
                    }
                }).done(function() {

                        if (!item_found) {

                            var term = $("#repair_item").val();

                            $.get('<?php echo site_url("work_orders/item_search");?>', {
                                    term: term
                                }, function(response) {
                                    var data = JSON.parse(response);
                                    <?php if(!$work_orders_repair_item) { ?>
                                    if (data.length == 1 && data[0].value) {
                                        item_select(data[0].value);
                                    } else if (data.length == 1 && !data[0].value &&
                                        <?php echo count($vendor_list) > 0 ? 1 : 0 ?>) {
                                        <?php } else { ?>
                                        if (data.length == 1 && data[0].value && data[0].value !=
                                            <?php echo $work_orders_repair_item; ?>) {
                                            item_select(data[0].value);
                                        } else if (data.length == 1 && data[0].value ==
                                            <?php echo $work_orders_repair_item; ?> &&
                                            <?php echo count($vendor_list) > 0 ? 1 : 0 ?>) {
                                            <?php } ?>

                                            setTimeout(function() {
                                                var search_item_key = localStorage.getItem(
                                                    'item_search_key');
                                                if (search_item_key.trim() != "") {

                                                    $("#work_order_form #item").val(
                                                        search_item_key);

                                                    bootbox.dialog({
                                                        message: <?php echo json_encode(lang("sales_ask_search_in_other_vendors")); ?>,
                                                        size: 'large',
                                                        onEscape: true,
                                                        backdrop: true,
                                                        buttons: search_outside_buttons
                                                    })
                                                }
                                            }, 100);

                                        }
                                    });
                            }

                        });
                }
            });
    }

    if ($("#repair_item").length) {
        $("#repair_item").autocomplete({
            source: '<?php echo site_url("work_orders/item_search");?>',
            delay: 150,
            autoFocus: false,
            minLength: 0,
            select: function(event, ui) {
                var item_identifier = $("#item_identifier").val();
                var item_description = $("#item_description").val();

                if (ui.item.value == false) {
                    add_additional_item(item_description, item_identifier);
                } else {
                    <?php if($work_orders_repair_item){?>
                    if (ui.item.value == <?php echo $work_orders_repair_item; ?>) {
                        add_additional_item(item_description, item_identifier);
                    } else {
                        item_select(ui.item.value, item_identifier);
                    }
                    <?php } else { ?>
                    item_select(ui.item.value, item_identifier);
                    <?php } ?>
                }
            },
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            var item_details = '<a class="suggest-item">' +
                '<div class="item-image">' +
                '<img src="' + item.image + '" alt="">' +
                '</div>' +

                '<div class="details">' +
                '<div class="name">' +
                item.label +
                '</div>' +
                '<span class="name small">' +
                (item.subtitle ? item.subtitle : '') +
                '</span>' +
                '<span class="attributes">' + '<?php echo lang("category"); ?>' + ' : <span class="value">' + (item
                    .category ? item.category : <?php echo json_encode(lang('none')); ?>) + '</span></span>' +
                <?php if ($this->Employee->has_module_action_permission('items', 'see_item_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>(
                    typeof item.quantity !== 'undefined' && item.quantity !== null ? '<span class="attributes">' +
                    '<?php echo lang("quantity"); ?>' + ' <span class="value">' + item.quantity + '</span></span>' :
                    '') +
                <?php } ?>(item.attributes ? '<span class="attributes">' + '<?php echo lang("attributes"); ?>' +
                    ' : <span class="value">' + item.attributes + '</span></span>' : '') +
                '</div>' +
                '</a>';

            return $("<li class='item-suggestions'></li>")
                .data("item.autocomplete", item)
                .append(item_details)
                .appendTo(ul);
        };

        <?php
		$vendor_list = array();
		if($this->config->item('branding')['code'] == 'phpsalesmanager'){
			if($this->config->item('ig_api_bearer_token') && $this->config->item('enable_ig_integration')){
				array_push($vendor_list, 'ig_api_bearer_token');
			}

			if($this->config->item('wgp_integration_pkey') && $this->config->item('enable_wgp_integration')){
				array_push($vendor_list, 'wgp_integration_pkey');
			}

			if($this->config->item('p4_api_bearer_token') && $this->config->item('enable_p4_integration')){
				array_push($vendor_list, 'p4_api_bearer_token');
			}
		}
		?>

        var search_outside_buttons = {
            <?php if( in_array('ig_api_bearer_token', $vendor_list)){ ?>
            api_ig: {
                label: 'Injured Gadgets',
                className: 'btn-info',
                callback: function() {
                    $("#repair_item").autocomplete('option', 'source',
                        '<?php echo site_url("home/sync_ig_item_search"); ?>');
                    $("#repair_item").autocomplete('option', 'response',
                        function(event, ui) {
                            $("#work_order_form .spinner").hide();

                            var source_url = $("#repair_item").autocomplete('option', 'source');

                            if (ui.content.length == 0 && (source_url.indexOf('work_orders/item_search') > -
                                    1) && $("#work_order_form #repair_item").val().trim() != "") {

                            } else if (ui.content.length == 0 && (source_url.indexOf(
                                    'home/sync_ig_item_search') > -1)) {
                                var noResult = {
                                    value: "",
                                    image: "<?php echo base_url()."assets/img/item.png"; ?>",
                                    label: "<?php echo lang("sales_no_result_found_ig"); ?>"
                                };
                                ui.content.push(noResult);
                                $("#repair_item").autocomplete('option', 'source',
                                    '<?php echo site_url("work_orders/item_search"); ?>');
                            } else {
                                $("#repair_item").autocomplete('option', 'source',
                                    '<?php echo site_url("work_orders/item_search"); ?>');
                            }
                        }
                    );

                    $("#repair_item").autocomplete('search');
                    $("#work_order_form .spinner").show();

                }
            },

            <?php } if( in_array('wgp_integration_pkey', $vendor_list)) { ?>
            api_wgp: {
                label: 'WGP',
                className: 'btn-info',
                callback: function() {
                    $("#repair_item").autocomplete('option', 'source',
                        '<?php echo site_url("home/sync_wgp_inventory_search"); ?>');

                    $("#repair_item").autocomplete('option', 'response',
                        function(event, ui) {
                            $("#work_order_form .spinner").hide();

                            var source_url = $("#repair_item").autocomplete('option', 'source');

                            if (ui.content.length == 0 && (source_url.indexOf('work_orders/item_search') > -
                                    1) && $("#work_order_form #repair_item").val().trim() != "") {

                            } else if (ui.content.length == 0 && (source_url.indexOf(
                                    'home/sync_wgp_inventory_search') > -1)) {
                                var noResult = {
                                    value: "",
                                    image: "<?php echo base_url()."assets/img/item.png"; ?>",
                                    label: "<?php echo lang("sales_no_result_found_wgp"); ?>"
                                };
                                ui.content.push(noResult);
                                $("#repair_item").autocomplete('option', 'source',
                                    '<?php echo site_url("work_orders/item_search"); ?>');
                            } else {
                                $("#repair_item").autocomplete('option', 'source',
                                    '<?php echo site_url("work_orders/item_search"); ?>');
                            }
                        }
                    );

                    $("#repair_item").autocomplete('search');
                    $("#work_order_form .spinner").show();

                }
            },

            <?php } if(in_array("p4_api_bearer_token", $vendor_list)){ ?>
            api_p4: {
                label: 'Parts4Cells',
                className: 'btn-info',
                callback: function() {
                    $("#repair_item").autocomplete('option', 'source',
                        '<?php echo site_url("home/sync_p4_item_search"); ?>');

                    $("#repair_item").autocomplete('option', 'response',
                        function(event, ui) {
                            $("#work_order_form .spinner").hide();
                            var source_url = $("#repair_item").autocomplete('option', 'source');

                            if (ui.content.length == 0 && (source_url.indexOf('work_orders/item_search') > -
                                    1) && $("#work_order_form #repair_item").val().trim() != "") {

                            } else if (ui.content.length == 0 && (source_url.indexOf(
                                    'home/sync_p4_item_search') > -1)) {
                                var noResult = {
                                    value: "",
                                    image: "<?php echo base_url()."assets/img/item.png"; ?>",
                                    label: "<?php echo lang("sales_no_result_found_p4"); ?>"
                                };
                                ui.content.push(noResult);
                                $("#repair_item").autocomplete('option', 'source',
                                    '<?php echo site_url("work_orders/item_search"); ?>');
                            } else {
                                $("#repair_item").autocomplete('option', 'source',
                                    '<?php echo site_url("work_orders/item_search"); ?>');
                            }
                        }
                    );

                    $("#repair_item").autocomplete('search');
                    $("#work_order_form .spinner").show();

                }
            },
            <?php } ?>

            cancel: {
                label: '<?php echo lang("cancel"); ?>',
                className: 'btn-info',
                callback: function() {}
            }
        }

        $("#repair_item").bind('keypress', function(e) {
                if (e.keyCode == 13) {
                    auto_save_form();
                    e.preventDefault();

                    localStorage.setItem('item_search_key', $("#work_order_form #repair_item").val());
                    var search_value = $("#repair_item").val();

                    var item_found = true;
                    $.post('<?php echo site_url("work_orders/add_sale_item");?>', {
                        item: search_value,
                        sale_id: "<?php echo $sale_id; ?>",
                        item_identifier: $("#item_identifier").val()
                    }, function(response) {

                        item_found = false;
                        var data = JSON.parse(response);

                        if (data.redirect) {
                            // location.href = data.redirect;
                            return false;
                        } else if (data.success) {
                            item_found = true;
                            // window.location.reload();
                            return false;
                        } else if (data.success == false && data.message) {
                            item_found = true;
                            show_feedback('error', data.message, <?php echo json_encode(lang('error')); ?>);
                            return false;
                        }
                    }).done(function() {

                            if (!item_found) {

                                var term = $("#repair_item").val();

                                $.get('<?php echo site_url("work_orders/item_search");?>', {
                                        term: term
                                    }, function(response) {
                                        var data = JSON.parse(response);
                                        <?php if(!$work_orders_repair_item) { ?>
                                        if (data.length == 1 && data[0].value) {
                                            item_select(data[0].value, $("#item_identifier").val());
                                        } else if (data.length == 1 && !data[0].value &&
                                            <?php echo count($vendor_list) > 0 ? 1 : 0 ?>) {
                                            <?php } else { ?>
                                            if (data.length == 1 && data[0].value && data[0].value !=
                                                <?php echo $work_orders_repair_item; ?>) {
                                                item_select(data[0].value, $("#item_identifier").val());
                                            } else if (data.length == 1 && data[0].value ==
                                                <?php echo $work_orders_repair_item; ?> &&
                                                <?php echo count($vendor_list) > 0 ? 1 : 0 ?>) {
                                                <?php } ?>

                                                setTimeout(function() {
                                                    var search_item_key = localStorage.getItem(
                                                        'item_search_key');
                                                    if (search_item_key.trim() != "") {

                                                        $("#work_order_form #repair_item").val(
                                                            search_item_key);

                                                        bootbox.dialog({
                                                            message: <?php echo json_encode(lang("sales_ask_search_in_other_vendors")); ?>,

                                                            size: 'large',
                                                            onEscape: true,
                                                            backdrop: true,
                                                            buttons: search_outside_buttons
                                                        })
                                                    }
                                                }, 100);

                                            }
                                        });
                                }

                            });
                    }
                });
        }
//  var activeTab = localStorage.getItem('activeTab');
//     if (activeTab) {
//         // Activate the stored tab
//         $('.nav-link[href="' + activeTab + '"]').tab('show');
//         // Remove the stored tab from localStorage
//         localStorage.removeItem('activeTab');
//     }

//     // Add click event to store the active tab in localStorage
//     $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
//         var tabId = $(e.target).attr('href');
//         localStorage.setItem('activeTab', tabId);
//     });
//         function item_select(item_id, item_identifier = false) {
//             // auto_save_form();
//             $("#ajax-loader").show();
//             var item_description = '';
//             if (item_identifier == 'repair_item') {
//                 item_description = $("#repair_item").val();
//             } else {
//                 item_description = $("#item").val();
//             }

//             $.post("<?php //echo site_url('work_orders/add_sale_item') ?>", {
//                 item: item_id,
//                 sale_id: "<?php //echo $sale_id; ?>",
//                 item_description: item_description,
//                 item_identifier: item_identifier
//             }, function(response) {
//                 $('#ajax-loader').hide();

//                 console.log(response);
//                 //Refresh if success
//                 if (response.success) {
//                      // Store the tab to be active after reload
//             localStorage.setItem('activeTab', '#kt_Modify_Parts_and_labor');
//             window.location.reload();
//                 } else {
//                     $("#item").val('');
//                     $("#repair_item").val('');
//                     show_feedback('error', response.message, <?php //echo json_encode(lang('error')); ?>);
//                 }
//             }, 'json');
//         }
  // Remove active class from all tabs and tab links
  $('.tab-pane').removeClass('show active');
    $('.nav-link').removeClass('active'); // Ensure no other tab links are active

    // Retrieve active tab from localStorage
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        $('.nav-link[href="' + activeTab + '"]').addClass('active');
        $(activeTab).addClass('show active');
    } else {
        // Default to Modify Parts and Labor tab if no tab is saved
        $('#kt_Modify_Parts_and_labor').addClass('show active');
        $('.nav-link[href="#kt_Modify_Parts_and_labor"]').addClass('active');
    }

    
    $('.nav-link[data-toggle="tab"]').on('click', function() {
        var tabId = $(this).attr('href');
        localStorage.setItem('activeTab', tabId);
    });


    function item_select(item_id, item_identifier = false) {
        $("#ajax-loader").show();
        var item_description = item_identifier == 'repair_item' ? $("#repair_item").val() : $("#item").val();

        $.post("<?php echo site_url('work_orders/add_sale_item') ?>", {
            item: item_id,
            sale_id: "<?php echo $sale_id; ?>",
            item_description: item_description,
            item_identifier: item_identifier
        }, function(response) {
            $('#ajax-loader').hide();

            if (response.success) {
                localStorage.setItem('activeTab', '#kt_Modify_Parts_and_labor'); 
                localStorage.setItem('onlyShowModifyParts', 'true'); 
                window.location.reload();
            } else {
                $("#item").val('');
                $("#repair_item").val('');
                show_feedback('error', response.message, <?php echo json_encode(lang('error')); ?>);
            }
        }, 'json');
    }

    
    if (localStorage.getItem('onlyShowModifyParts') === 'true') {
        $('.tab-pane').removeClass('show active'); 
        $('.nav-link').removeClass('active'); 
        $('#kt_Modify_Parts_and_labor').addClass('show active'); 
        $('.nav-link[href="#kt_Modify_Parts_and_labor"]').addClass('active'); 
        localStorage.removeItem('onlyShowModifyParts'); 
    }

        $('.xeditable').editable({
            validate: function(value) {
                if ($.isNumeric(value) == '' && $(this).data('validate-number')) {
                    return <?php echo json_encode(lang('only_numbers_allowed')); ?>;
                }
            },
            success: function(response, newValue) {
                window.location.reload();
            }
        });

        $('.xeditable').on('shown', function(e, editable) {

            editable.input.postrender = function() {
                //Set timeout needed when calling price_to_change.editable('show') (Not sure why)
                setTimeout(function() {
                    editable.input.$input.select();
                }, 200);
            };
        });

        $('#done_btn').click(function(e) {
            var $that = $(this);

            e.preventDefault();

            $('#grid-loader').show();

            $form.ajaxSubmit({
                success: function(response, status) {
                    $('#grid-loader').hide();
                    window.location = $that.attr('href');

                },
                dataType: 'json'
            });
        });

        $('#print_btn').click(function(e) {
            var $that = $(this);

            e.preventDefault();

            $('#grid-loader').show();

            $form.ajaxSubmit({
                success: function(response, status) {
                    $('#grid-loader').hide();
                    window.location = $that.attr('href');
                },
                dataType: 'json'
            });
        });

        function auto_save_form($needreload = true) {
            $form.ajaxSubmit({
                success: function(response, status) {
                    if (response.success) {
                        if ($needreload) {
                            window.location.reload();
                        } else {
                            show_feedback('success',
                                <?php echo json_encode(lang('successfully_updated')); ?>,
                                <?php echo json_encode(lang('done')); ?>);
                        }

                        // window.location.reload();
                    } else {
                        show_feedback('error', response.message, <?php echo json_encode(lang('error')); ?>);
                    }
                },
                dataType: 'json'
            });
        }
        $('#submitf').click(function(e) {
            auto_save_form();
        })
        $('.warranty').click(function(e) {
            auto_save_form();
        })

        var $form_field_value = "";
        var form_field_value_change_detect_timer = 0;
        var form_field_value_change_save_timer = 0;
        $("#estimated_repair_date").on("focusin", function() {
            $form_field_value = $('#estimated_repair_date').val();
            form_field_value_change_detect_timer = setInterval(function() {
                var $estimated_repair_date_current = $('#estimated_repair_date').val();
                if ($form_field_value != $estimated_repair_date_current) {
                    clearTimeout(form_field_value_change_save_timer);
                    form_field_value_change_save_timer = setTimeout(function() {
                        auto_save_form(false)
                    }, 1000);
                    $form_field_value = $estimated_repair_date_current;
                }
            }, 100);
        });

        $("#estimated_repair_date").on("focusout", function() {
            clearInterval(form_field_value_change_detect_timer);
        });

        $("#estimated_parts").on("focusin", function() {
            $form_field_value = $('#estimated_parts').val();
            form_field_value_change_detect_timer = setInterval(function() {
                var $estimated_parts_current = $('#estimated_parts').val();
                if ($form_field_value != $estimated_parts_current) {
                    clearTimeout(form_field_value_change_save_timer);
                    form_field_value_change_save_timer = setTimeout(function() {
                        auto_save_form(false)
                    }, 1000);
                    $form_field_value = $estimated_parts_current;
                }
            }, 100);
        });

        $("#estimated_parts").on("focusout", function() {
            clearInterval(form_field_value_change_detect_timer);
        });

        $("#estimated_labor").on("focusin", function() {
            $form_field_value = $('#estimated_labor').val();
            form_field_value_change_detect_timer = setInterval(function() {
                var $estimated_labor_current = $('#estimated_labor').val();
                if ($form_field_value != $estimated_labor_current) {
                    clearTimeout(form_field_value_change_save_timer);
                    form_field_value_change_save_timer = setTimeout(function() {
                        auto_save_form(false)
                    }, 1000);
                    $form_field_value = $estimated_labor_current;
                }
            }, 100);
        });

        $("#estimated_labor").on("focusout", function() {
            clearInterval(form_field_value_change_detect_timer);
        });

        $("#employee_id").change(function() {
            $('#grid-loader').show();
            $.post('<?php echo site_url("work_orders/select_technician/");?>', {
                work_order_id: work_order_id,
                employee_id: $(this).val()
            }, function(response) {
                $('#grid-loader').hide();
                window.location.reload();
            });
        });

        $(".change_technician").click(function(e) {
            e.preventDefault();

            $.post('<?php echo site_url("work_orders/remove_technician/");?>', {
                work_order_id: work_order_id
            }, function(response) {
                window.location.reload();
            });
        });

        $('.service_tag_btn').click(function(e) {
            var default_to_raw_printing = "<?php echo $this->config->item('default_to_raw_printing'); ?>";
            if (default_to_raw_printing == "1") {
                $(this).attr('href', '<?php echo site_url("work_orders/raw_print_service_tag");?>/' +
                    work_order_id);
            } else {
                $(this).attr('href', '<?php echo site_url("work_orders/print_service_tag");?>/' +
                    work_order_id);
            }
        });

        $(".delete_note_btn").click(function(e) {
            var note_id = $(this).data('note_id');
            e.preventDefault();
            bootbox.confirm(<?php echo json_encode(lang('work_orders_note_delete_confirmation')); ?>, function(
                result) {
                if (result) {
                    $.post('<?php echo site_url("work_orders/delete_note");?>', {
                        note_id: note_id
                    }, function(response) {
                        show_feedback(response.success ? 'success' : 'error', response.message,
                            response.success ? <?php echo json_encode(lang('success')); ?> :
                            <?php echo json_encode(lang('error')); ?>);
                        if (response.success) {
                            window.location.reload();
                        }
                    }, "json");

                }
            });
        })

        $(".edit_note_btn").click(function(e) {
            e.preventDefault();

            var note_id = $(this).data('note_id');
            var note = $(this).data('note');
            var detailed_notes = $(this).data('detailed_notes');
            var internal = $(this).data('internal');
            var device_location = $(this).data('device_location');
            $("#note_button").text(<?php echo json_encode(lang('update')); ?>).removeClass('btn-success')
                .addClass('btn-warning');
            $("#note_id").val(note_id);
            $("#sale_item_note").val(note);
            $("#sale_item_detailed_notes").val(detailed_notes);
            if (note) {
                $("#current_status").html(note);
            }

            var bgc = '';
            $('.change_workorder_status').each(function(index, value) {
                var status_name = $(this).data('status_name');
                if (status_name == note) {
                    bgc = $(this).data('status_color');
                }
            });

            $("#current_status").parent().css('background-color', bgc);

            if (internal) {
                $("#sale_item_note_internal").prop('checked', true);
            } else {
                $("#sale_item_note_internal").prop('checked', false);
            }

            $("#device_location_btn").html(device_location);
            $(".sale_item_notes_modal").modal('show');
        });

        $(".delete_work_order_image").click(function(e) {
            e.preventDefault();
            var image_index = $(this).data('index');
            bootbox.confirm(<?php echo json_encode(lang('work_orders_image_delete_confirmation')); ?>, function(
                result) {
                if (result) {
                    $.post('<?php echo site_url("work_orders/delete_work_order_image");?>', {
                        work_order_id: work_order_id,
                        image_index: image_index
                    }, function(response) {
                        show_feedback(response.success ? 'success' : 'error', response.message,
                            response.success ? <?php echo json_encode(lang('success')); ?> :
                            <?php echo json_encode(lang('error')); ?>);
                        if (response.success) {
                            window.location.reload();
                        }
                    }, "json");

                }
            });

        });

        $('.delete_file').click(function(e) {
            e.preventDefault();
            var $link = $(this);
            bootbox.confirm(<?php echo json_encode(lang('confirm_file_delete')); ?>, function(response) {
                if (response) {
                    $.get($link.attr('href'), function() {
                        $link.parent().fadeOut();
                    });
                }
            });
        });

        $('.capture_signature').click(function(e) {
            e.preventDefault();
            var $link = $(this);
            bootbox.alert(<?php echo json_encode(lang('work_orders_capture_signature')); ?>, function(
                response) {
                $.get($link.attr('href'), function() {
                    window.location.reload();
                });
            });

        });

        $('#work_order_checkbox_modal').on('hidden.bs.modal', function() {
            window.location.reload();
        });

        function add_additional_item(item_description, item_identifier = false) {
            $("#ajax-loader").show();

            $.post("<?php echo site_url('work_orders/save_additional_item') ?>", {
                item_description: item_description,
                sale_id: "<?php echo $sale_id; ?>",
                item_identifier: item_identifier
            }, function(response) {
                $('#ajax-loader').hide();
                $('#item').val('');
                $('#repair_item').val('');
                //Refresh if success
                if (response.success) {
                    window.location.reload();
                } else {
                    show_feedback('error', response.message, <?php echo json_encode(lang('error')); ?>);
                }
            }, 'json');
        }

        $(document).on('keyup', '#item, #repair_item', function() {
            $("#item_identifier").val('');
            if ($(this).attr('id') == 'item') {
                $("#item_identifier").val('parts_and_labor');
            } else {
                $("#item_identifier").val('repair_item');
            }

            $('#item_description').val($(this).val());
        });

        $('.add_additional_item').on('click', function(e) {

            var item_identifier = $("#item_identifier").val();
            var item_description = false;
            if (item_identifier == 'parts_and_labor') {
                item_description = $("#item").val();
            } else {
                item_description = $("#repair_item").val();
            }

            if (item_description) {
                add_additional_item(item_description, item_identifier);
            }
        });

        function enable_popup_modifier(sale_id, item_id, line) {
            $('#choose_modifiers').modal('show');
            $.ajax({
                url: "<?php echo site_url('work_orders/get_modifiers'); ?>",
                data: {
                    "sale_id": sale_id,
                    "item_id": item_id,
                    "line": line
                },
                cache: false,
                success: function(response) {
                    $("#choose_modifiers .modal-body").html(response);
                }
            });
        }

        function itemScannedSuccess(responseText, statusText, xhr, $form) {
            <?php if ($this->config->item('clean_input_after_add_item')) { ?>
            $('#item').val('');
            <?php } ?>
            setTimeout(function() {
                window.location.reload();
            }, 10);
        }

        // if click delete_activity button then delete activity and reload page 
        $(".delete_activity").click(function(e) {
            var activity_id = $(this).data('activity_id');
            e.preventDefault();
            bootbox.confirm(<?php echo json_encode(lang('work_orders_activity_delete_confirmation')); ?>,
                function(result) {
                    if (result) {
                        $.post('<?php echo site_url("work_orders/delete_activity_log");?>', {
                            activity_id: activity_id
                        }, function(response) {
                            show_feedback(response.success ? 'success' : 'error', response.message,
                                response.success ? <?php echo json_encode(lang('success')); ?> :
                                <?php echo json_encode(lang('error')); ?>);
                            if (response.success) {
                                window.location.reload();
                            }
                        }, "json");

                    }
                });
        })
</script>
<?php $this->load->view("partial/footer"); ?>