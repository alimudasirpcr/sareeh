<?php $this->load->view("partial/header"); ?>

<div class="row" id="form">
    <div class="spinner" id="grid-loader" style="display:none">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
    </div>

    <div class="col-md-12 ">

        <?php if($person_info->person_id)  { ?>
        <div class="card hidden">
            <div class="card-body">
                <div class="user-badge">
                    <?php echo $person_info->image_id ? '<div class="user-badge-avatar">'.img(array('src' => cacheable_app_file_url($person_info->image_id),'class'=>'img-polaroid img-polaroid-s')).'</div>' : '<div class="user-badge-avatar">'.img(array('src' => base_url('assets/assets/images/avatar-default.jpg'),'class'=>'img-polaroid','id'=>'image_empty')).'</div>'; ?>
                    <div class="user-badge-details text-success">


                        <?php if($this->config->item('customers_store_accounts')) { ?>
                        <div class="amount text-info">
                            <?php echo lang('store_account_balance').': '; ?>
                            <?php echo $person_info->balance ? to_currency($person_info->balance) : '0.00'; ?>
                        </div>
                        <?php } ?>
                        <?php
								if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'simple')
								{
								?>
                        <div class="amount text-secondary">
                            <?php echo lang('sales_until_discount').': '; ?>
                            <?php 
								   $sales_until_discount = $this->config->item('number_of_sales_for_discount') - $person_info->current_sales_for_discount;
									
									echo to_quantity($sales_until_discount); ?>
                        </div>

                        <?php
								}
								?>

                        <?php
								if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced')
								{
						        	 list($spend_amount_for_points, $points_to_earn) = explode(":",$this->config->item('spend_to_point_ratio'),2);
							 		$spend_amount_for_points = (float)$spend_amount_for_points;
							 		$points_to_earn = (float)$points_to_earn;
									
								?>
                        <div class="amount">
                            <?php echo lang('points').': '; ?>
                            <?php echo to_quantity($person_info->points); ?>
                        </div>

                        <div class="amount">
                            <?php echo lang('customers_amount_to_spend_for_next_point').': '; ?>
                            <?php echo to_currency($spend_amount_for_points - $person_info->current_spend_for_points); ?>
                        </div>

                        <?php
								}
								?>
                    </div>
                    <ul class="list-inline pull-right">
                        <?php
								$one_year_ago = date('Y-m-d', strtotime('-1 year'));
								$today = date('Y-m-d').'%2023:59:59';	
							?>

                        <li><a target="_blank"
                                href="<?php echo site_url('reports/generate/specific_customer?report_type=complex&start_date='.$one_year_ago.'&start_date_formatted='.date(get_date_format().' '.get_time_format(), strtotime($one_year_ago)).'&end_date='.$today.'&end_date_formatted='.date(get_date_format().' '.get_time_format(), strtotime(date('Y-m-d').' 23:59:59')).'&customer_id='.$person_info->person_id.'&sale_type=all&export_excel=0'); ?>"
                                class="btn btn-success"><?php echo lang('view_report'); ?></a></li>

                        <?php if($this->config->item('customers_store_accounts')) { ?>
                        <li><?php echo anchor($controller_name."/pay_now/$person_info->person_id",lang('pay'),array('title'=>lang('pay'),'class'=>'btn btn-primary ')); ?>
                        </li>
                        <?php } ?>
                        <?php if ($person_info->email) { ?>
                        <li><a href="mailto:<?php echo H($person_info->email); ?>"
                                class="btn btn-primary"><?php echo lang('send_email'); ?></a></li>
                        <?php } ?>
                    </ul>
                    <span
                        class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-success translate rounded"></span>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php echo form_open_multipart('customers/save/'.$person_info->person_id,array('id'=>'customer_form','class'=>'form-horizontal')); 	?>

        <div class="d-flex flex-column flex-xl-row">
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">

                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Card body-->
                    <div class="card-body pt-15">
                        <!--begin::Summary-->
                        <div class="d-flex flex-center flex-column mb-5">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-150px symbol-circle mb-7">
                                <?php $user_img = site_url('assets/assets/images/avatar-default.jpg');
                                        if($person_info->image_id){
                                            $user_img = cacheable_app_file_url($person_info->image_id);
                                        }
                                    
                                    ?>
                                <img src="<?= $user_img; ?>"
                                    alt="  <?php echo H($person_info->first_name.' '.$person_info->last_name); ?>">
                            </div>
                            <!--end::Avatar-->

                            <!--begin::Name-->
                            <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">
                                <?php echo H($person_info->first_name.' '.$person_info->last_name); ?> </a>
                            <!--end::Name-->

                            <!--begin::Email-->
                            <a href="#" class="fs-5 fw-semibold text-muted text-hover-primary mb-6">
                                <?= $person_info->email ?></a>
                            <!--end::Email-->
                        </div>
                        <!--end::Summary-->

                        <!--begin::Details toggle-->
                        <div class="d-flex flex-stack fs-4 py-3">
                            <div class="fw-bold">
                                Details
                            </div>

                            <!--begin::Badge-->
                            <div class="badge badge-light-info d-inline">Premium user</div>
                            <!--begin::Badge-->
                        </div>
                        <!--end::Details toggle-->

                        <div class="separator separator-dashed my-3"></div>

                        <!--begin::Details content-->
                        <div class="pb-5 fs-6">
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Account ID</div>
                            <div class="text-gray-600">ID-<?= $person_info->person_id; ?></div>
                            <!--begin::Details item-->

                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Company</div>
                            <div class="text-gray-600"><a href="#"
                                    class="text-gray-600 text-hover-primary"><?= $person_info->company_name; ?></a>
                            </div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Address</div>
                            <div class="text-gray-600"><?= $person_info->address_1; ?></div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Zip</div>
                            <div class="text-gray-600"><?= $person_info->zip; ?></div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->

                            <!--begin::Details item-->
                        </div>
                        <!--end::Details content-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <div class="flex-lg-row-fluid ms-lg-15">
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8"
                    role="tablist">
                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4 active" data-toggle="tab"
                            href="#kt_ecommerce_customer_overview" aria-selected="true" role="tab">Overview</a>
                    </li>
                    <!--end:::Tab item-->

                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-toggle="tab"
                            href="#kt_ecommerce_customer_general" aria-selected="false" role="tab" tabindex="-1">General
                            Settings</a>
                    </li>
                    <!--end:::Tab item-->

                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-toggle="tab"
                            href="#kt_ecommerce_customer_advanced" aria-selected="false" role="tab"
                            tabindex="-1">Advanced Settings</a>
                    </li>
                    <!--end:::Tab item-->

                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-toggle="tab"
                            href="#kt_ecommerce_customer_files" aria-selected="false" role="tab" tabindex="-1">Files
                            Upload</a>
                    </li>
                    <!--end:::Tab item-->

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="kt_ecommerce_customer_overview" role="tabpanel">
                        <div class="row row-cols-1 row-cols-md-2 mb-6 mb-xl-9">



                            <div class="col">
                                <!--begin::Card-->
                                <div class="card pt-4 h-md-100 mb-6 mb-md-0">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2 class="fw-bold"><?php 
						
						                    echo form_label(lang('credit_limit'))?></h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <div class="fw-bold fs-2">
                                            <div class="d-flex">
                                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/general/gen030.svg-->
                                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/finance/fin009.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M15.8 11.4H6C5.4 11.4 5 11 5 10.4C5 9.80002 5.4 9.40002 6 9.40002H15.8C16.4 9.40002 16.8 9.80002 16.8 10.4C16.8 11 16.3 11.4 15.8 11.4ZM15.7 13.7999C15.7 13.1999 15.3 12.7999 14.7 12.7999H6C5.4 12.7999 5 13.1999 5 13.7999C5 14.3999 5.4 14.7999 6 14.7999H14.8C15.3 14.7999 15.7 14.2999 15.7 13.7999Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M18.8 15.5C18.9 15.7 19 15.9 19.1 16.1C19.2 16.7 18.7 17.2 18.4 17.6C17.9 18.1 17.3 18.4999 16.6 18.7999C15.9 19.0999 15 19.2999 14.1 19.2999C13.4 19.2999 12.7 19.2 12.1 19.1C11.5 19 11 18.7 10.5 18.5C10 18.2 9.60001 17.7999 9.20001 17.2999C8.80001 16.8999 8.49999 16.3999 8.29999 15.7999C8.09999 15.1999 7.80001 14.7 7.70001 14.1C7.60001 13.5 7.5 12.8 7.5 12.2C7.5 11.1 7.7 10.1 8 9.19995C8.3 8.29995 8.79999 7.60002 9.39999 6.90002C9.99999 6.30002 10.7 5.8 11.5 5.5C12.3 5.2 13.2 5 14.1 5C15.2 5 16.2 5.19995 17.1 5.69995C17.8 6.09995 18.7 6.6 18.8 7.5C18.8 7.9 18.6 8.29998 18.3 8.59998C18.2 8.69998 18.1 8.69993 18 8.79993C17.7 8.89993 17.4 8.79995 17.2 8.69995C16.7 8.49995 16.5 7.99995 16 7.69995C15.5 7.39995 14.9 7.19995 14.2 7.19995C13.1 7.19995 12.1 7.6 11.5 8.5C10.9 9.4 10.5 10.6 10.5 12.2C10.5 13.3 10.7 14.2 11 14.9C11.3 15.6 11.7 16.1 12.3 16.5C12.9 16.9 13.5 17 14.2 17C15 17 15.7 16.8 16.2 16.4C16.8 16 17.2 15.2 17.9 15.1C18 15 18.5 15.2 18.8 15.5Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Svg Icon-->
                                                <div class="ms-2">
                                                    <?php echo $person_info->credit_limit ? to_currency($person_info->credit_limit) : lang('none'); ?>
                                                </div>
                                            </div>
                                            <div class="fs-7 fw-normal text-muted">Earn reward points with every
                                                purchase.</div>
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>

                            <?php if($this->config->item('customers_store_accounts')) { ?>


                            <div class="col">
                                <!--begin::Reward Tier-->
                                <a href="#" class="card bg-info hoverable h-md-100">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/finance/fin008.svg-->
                                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                    d="M3.20001 5.91897L16.9 3.01895C17.4 2.91895 18 3.219 18.1 3.819L19.2 9.01895L3.20001 5.91897Z"
                                                    fill="currentColor" />
                                                <path opacity="0.3"
                                                    d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21C21.6 10.9189 22 11.3189 22 11.9189V15.9189C22 16.5189 21.6 16.9189 21 16.9189H16C14.3 16.9189 13 15.6189 13 13.9189ZM16 12.4189C15.2 12.4189 14.5 13.1189 14.5 13.9189C14.5 14.7189 15.2 15.4189 16 15.4189C16.8 15.4189 17.5 14.7189 17.5 13.9189C17.5 13.1189 16.8 12.4189 16 12.4189Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21V7.91895C21 6.81895 20.1 5.91895 19 5.91895H3C2.4 5.91895 2 6.31895 2 6.91895V20.9189C2 21.5189 2.4 21.9189 3 21.9189H19C20.1 21.9189 21 21.0189 21 19.9189V16.9189H16C14.3 16.9189 13 15.6189 13 13.9189Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <div class="text-white fw-bold fs-2 mt-5">
                                            <?php echo lang('store_account_balance').': '; ?>
                                        </div>

                                        <div class="fw-semibold text-white">
                                            <?php echo $person_info->balance ? to_currency($person_info->balance) : '0.00'; ?>
                                        </div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                                <!--end::Reward Tier-->
                            </div>


                            <?php } 


                            if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'simple')
								{
								?>
                       

                        <div class="col">
                                <!--begin::Reward Tier-->
                                <a href="#" class="card  hoverable h-md-100">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/finance/fin008.svg-->
                                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                    d="M3.20001 5.91897L16.9 3.01895C17.4 2.91895 18 3.219 18.1 3.819L19.2 9.01895L3.20001 5.91897Z"
                                                    fill="currentColor" />
                                                <path opacity="0.3"
                                                    d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21C21.6 10.9189 22 11.3189 22 11.9189V15.9189C22 16.5189 21.6 16.9189 21 16.9189H16C14.3 16.9189 13 15.6189 13 13.9189ZM16 12.4189C15.2 12.4189 14.5 13.1189 14.5 13.9189C14.5 14.7189 15.2 15.4189 16 15.4189C16.8 15.4189 17.5 14.7189 17.5 13.9189C17.5 13.1189 16.8 12.4189 16 12.4189Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21V7.91895C21 6.81895 20.1 5.91895 19 5.91895H3C2.4 5.91895 2 6.31895 2 6.91895V20.9189C2 21.5189 2.4 21.9189 3 21.9189H19C20.1 21.9189 21 21.0189 21 19.9189V16.9189H16C14.3 16.9189 13 15.6189 13 13.9189Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <div class="text-white fw-bold fs-2 mt-5">
                                        <?php echo lang('sales_until_discount').': '; ?>
                                        </div>

                                        <div class="fw-semibold text-white">
                                        <?php 
								   $sales_until_discount = $this->config->item('number_of_sales_for_discount') - $person_info->current_sales_for_discount;
									
									echo to_quantity($sales_until_discount); ?>
                                        </div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                                <!--end::Reward Tier-->
                            </div>

                        <?php
								}
								?>

<?php
								if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced')
								{
						        	 list($spend_amount_for_points, $points_to_earn) = explode(":",$this->config->item('spend_to_point_ratio'),2);
							 		$spend_amount_for_points = (float)$spend_amount_for_points;
							 		$points_to_earn = (float)$points_to_earn;
									
								?>
                      


                        <div class="col mt-5">
                                <!--begin::Reward Tier-->
                                <a href="#" class="card bg-info hoverable h-md-100">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/finance/fin008.svg-->
                                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                    d="M3.20001 5.91897L16.9 3.01895C17.4 2.91895 18 3.219 18.1 3.819L19.2 9.01895L3.20001 5.91897Z"
                                                    fill="currentColor" />
                                                <path opacity="0.3"
                                                    d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21C21.6 10.9189 22 11.3189 22 11.9189V15.9189C22 16.5189 21.6 16.9189 21 16.9189H16C14.3 16.9189 13 15.6189 13 13.9189ZM16 12.4189C15.2 12.4189 14.5 13.1189 14.5 13.9189C14.5 14.7189 15.2 15.4189 16 15.4189C16.8 15.4189 17.5 14.7189 17.5 13.9189C17.5 13.1189 16.8 12.4189 16 12.4189Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21V7.91895C21 6.81895 20.1 5.91895 19 5.91895H3C2.4 5.91895 2 6.31895 2 6.91895V20.9189C2 21.5189 2.4 21.9189 3 21.9189H19C20.1 21.9189 21 21.0189 21 19.9189V16.9189H16C14.3 16.9189 13 15.6189 13 13.9189Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <div class="text-white fw-bold fs-2 mt-5">
                                        <?php echo lang('points').': '; ?> <?php echo to_quantity($person_info->points); ?>
                                        </div>
                                     
                                       
                                    </div>
                                    <!--end::Body-->
                                </a>
                                <!--end::Reward Tier-->
                            </div>

                            <div class="col mt-5">
                               


                            <div class="card pt-4 h-md-100 mb-6 mb-md-0">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2 class="fw-bold"><label><?php echo lang('customers_amount_to_spend_for_next_point').': '; ?>  </label></h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <div class="fw-bold fs-2">
                                            <div class="d-flex">
                                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/general/gen030.svg-->
                                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/finance/fin009.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M15.8 11.4H6C5.4 11.4 5 11 5 10.4C5 9.80002 5.4 9.40002 6 9.40002H15.8C16.4 9.40002 16.8 9.80002 16.8 10.4C16.8 11 16.3 11.4 15.8 11.4ZM15.7 13.7999C15.7 13.1999 15.3 12.7999 14.7 12.7999H6C5.4 12.7999 5 13.1999 5 13.7999C5 14.3999 5.4 14.7999 6 14.7999H14.8C15.3 14.7999 15.7 14.2999 15.7 13.7999Z" fill="currentColor"></path>
                                                        <path d="M18.8 15.5C18.9 15.7 19 15.9 19.1 16.1C19.2 16.7 18.7 17.2 18.4 17.6C17.9 18.1 17.3 18.4999 16.6 18.7999C15.9 19.0999 15 19.2999 14.1 19.2999C13.4 19.2999 12.7 19.2 12.1 19.1C11.5 19 11 18.7 10.5 18.5C10 18.2 9.60001 17.7999 9.20001 17.2999C8.80001 16.8999 8.49999 16.3999 8.29999 15.7999C8.09999 15.1999 7.80001 14.7 7.70001 14.1C7.60001 13.5 7.5 12.8 7.5 12.2C7.5 11.1 7.7 10.1 8 9.19995C8.3 8.29995 8.79999 7.60002 9.39999 6.90002C9.99999 6.30002 10.7 5.8 11.5 5.5C12.3 5.2 13.2 5 14.1 5C15.2 5 16.2 5.19995 17.1 5.69995C17.8 6.09995 18.7 6.6 18.8 7.5C18.8 7.9 18.6 8.29998 18.3 8.59998C18.2 8.69998 18.1 8.69993 18 8.79993C17.7 8.89993 17.4 8.79995 17.2 8.69995C16.7 8.49995 16.5 7.99995 16 7.69995C15.5 7.39995 14.9 7.19995 14.2 7.19995C13.1 7.19995 12.1 7.6 11.5 8.5C10.9 9.4 10.5 10.6 10.5 12.2C10.5 13.3 10.7 14.2 11 14.9C11.3 15.6 11.7 16.1 12.3 16.5C12.9 16.9 13.5 17 14.2 17C15 17 15.7 16.8 16.2 16.4C16.8 16 17.2 15.2 17.9 15.1C18 15 18.5 15.2 18.8 15.5Z" fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Svg Icon-->
                                                <div class="ms-2">
                                                <?php echo to_currency($spend_amount_for_points - $person_info->current_spend_for_points); ?>                                       </div>
                                            </div>
                                            <div class="fs-7 fw-normal text-muted">Earn reward points with every
                                                purchase.</div>
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                </div>

                        <?php
								}
								?>






                        </div>
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Transaction History</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <script type="text/javascript" src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
<!-- ColReorder JS -->
<script src="https://cdn.datatables.net/colreorder/2.0.4/js/dataTables.colReorder.js"></script>
<script src="https://cdn.datatables.net/colreorder/2.0.4/js/colReorder.dataTables.js"></script>
<?php  $columns = get_table_columns('sales'); 
                $columnSearch = array_filter($columns, function($key) {
                    return $key !== 'default_order';
                }, ARRAY_FILTER_USE_KEY);
                
    ?> <?php $this->load->view("sales/sales_header"); ?>
                            <!--begin::Card body-->
                            <div class="card-body pt-0 pb-5">
                                <!--begin::Table-->
                                <div id="kt_table_customers_payment_wrapper"
                                    class="dt-container dt-bootstrap5 dt-empty-footer">
                                    
                                    <div class="table-responsive">
            <table id="example" class="table table-striped gy-7 gs-7" style="width:100%">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <?php $i=0; foreach($all_columns as $col_key => $col_value): ?>
                        <th><?php echo H($col_value['label']); ?></th>
                        <?php $i++; endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data rows will be inserted here by DataTables -->
                </tbody>
            </table>

            <script>
            $(document).ready(function() {

                // $("#customer_listd").hide();
                let openSelect2 = null;

                $("#location_listd").select2({
                    dropdownAutoWidth: true
                });
                $("#customer_listd").select2({
                    dropdownAutoWidth: true
                });
                $("#sale_type").select2({
                    dropdownAutoWidth: true
                });




                var table = $('#example').DataTable({
                    colReorder: true,
                    "paging": true, // Ensure paging is enabled
                    "pageLength": 5, // Adjust as per your requirement
                    "pagingType": "full_numbers",
                    "processing": true,
                    "serverSide": true,
                    "order": [],

                    "ajax": {
                        "url": "<?php echo site_url('sales/ajaxList') ?>",
                        "type": "POST",
                        "data": function(d) {
                            d.from_date = $('#from_date').val();
                            d.to_date = $('#to_date').val();
                        }
                    },
                    "columns": [
                        <?php $i=0; foreach($all_columns as $key => $col): ?> {
                            "data": "<?= $key ?>"
                        },
                        <?php $i++; endforeach ?>

                    ],
                    "initComplete": function () {
                        // Apply the search for each column
                        $('#customer_listd').on('change', function() {
                                var searchTerm = '<?php echo H($person_info->first_name.' '.$person_info->last_name); ?>';
                                var colIndex = $('#sortable input:checkbox').index($('#customer_name'));
                                console.log(colIndex);
                                
                                // Apply the search to the specific column
                                if (colIndex !== -1) {
                                    table.column(colIndex).search(searchTerm).draw();
                                } else {
                                    console.error("Column index not found. Check if the checkbox selector is correct.");
                                }
                            });

                            // Trigger the search on the first load based on the current customer selection
                            $('#customer_listd').trigger('change');
                    },
                    "drawCallback": function(settings) {
                        // Custom class for the pagination wrapper
                        $('.dt-paging').addClass('pagination');
                    }
                });
                $('.columns').on('change', function(e) {
                    //     console.log('callled');
                    // // Get the column API object
                    //     var column = table.column($(this).data('column-index'));



                    //     // Toggle the visibility
                    //     column.visible(!column.visible());
                });
                
                $('#s2id_customer_listd').hide();
                $('#location_listd').on('change', function() {

                    var searchTerm = $(this).val();
                    var colIndex = $('#config_columns input:checkbox').index($('#location_name'));
                    // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
                    table.column(colIndex).search(searchTerm).draw(); // Adjust the column index as necessary
                });

                $('#s2id_location_listd').on('click', function() {

                    $('#customer_listd').select2('close'); // Close the previously opened dropdown
                    $('#sale_type').select2('close');

                });
                $('#customer_listd').on('change', function() {
                    var searchTerm ='<?php echo H($person_info->first_name.' '.$person_info->last_name); ?>';
                    var colIndex = $('#config_columns input:checkbox').index($('#customer_name'));
                    // console.log(colIndex);
                    // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
                    table.column(colIndex).search(searchTerm).draw(); // Adjust the column index as necessary
                });
                
                $('#s2id_customer_listd').on('click', function() {
                    
                    $('#location_listd').select2('close'); // Close the previously opened dropdown
                    $('#sale_type').select2('close');

                });
                $('#sale_type').on('change', function() {
                    var searchTerm = $(this).val();
                    var colIndex = $('#config_columns input:checkbox').index($('#suspended_type'));
                    // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
                    table.column(colIndex).search(searchTerm).draw(); // Adjust the column index as necessary


                    // var searchTerm ='<?php echo H($person_info->first_name.' '.$person_info->last_name); ?>';
                    // var colIndex = $('#config_columns input:checkbox').index($('#customer_name'));
                    // // console.log(colIndex);
                    // // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
                    // table.column(colIndex).search(searchTerm).draw(); // Adjust the column index as necessary


                });
                $('#s2id_sale_type').on('click', function() {

                    $('#location_listd').select2('close'); // Close the previously opened dropdown
                    $('#customer_listd').select2('close');

                });
                $('#from_date , #to_date').on('change', function() {
                    var searchTerm = $(this).val();
                    table.ajax.reload();
                });
                $('#resetButton').click(function() {
                    $('#from_date').val('');
                    $('#to_date').val('');
                    <?php if(getenv('MASTER_USER')==$this->Employee->get_logged_in_employee_info()->id){ ?>
                    $('#location_listd').val(-1).trigger('change');
                    <?php } ?>
                    $('#customer_listd').val(-1).trigger('change');
                    table.state.clear(); // Clears the saved state of the table
                    table.search('').columns().search('').draw();
                });
                var old_columns = [];
                $("#config_columns input:checkbox").each(function() {
                    old_columns.push($(this)
                .val()); // Assuming checkbox values correspond to column indices
                });
                $("#config_columns input:checkbox").each(function() {
                    // Get the index of the checkbox within the collection of checkboxes
                    var colIndex = $('#config_columns input:checkbox').index(this);

                    // Check if the checkbox is checked
                    if ($(this).is(':checked')) {
                        // Show the corresponding column if checked
                        table.column(colIndex).visible(true);
                    } else {
                        // Hide the corresponding column if unchecked
                        table.column(colIndex).visible(false);
                    }
                });

                function setTableColumnOrder() {
                    var columns = [];

                    // Get checked checkboxes and reorder columns accordingly
                    $("#config_columns input:checkbox").each(function() {
                        columns.push($(this)
                    .val()); // Assuming checkbox values correspond to column indices
                    });



                    // Apply the new order
                    // $i=0;
                    newOrder = []
                    columns.forEach(function(colIndex, i) {
                        newOrder.push(old_columns.indexOf(colIndex));

                    });
                    // var newOrder = [4, 0, 1, 2, 3, 5, 6, 7, 8, 9];
                    table.colReorder.order(newOrder);

                    old_columns = [];
                    old_columns = columns;
                    // Hide unchecked columns
                    $("#config_columns input:checkbox").each(function() {
                        // Get the index of the checkbox within the collection of checkboxes
                        var colIndex = $('#config_columns input:checkbox').index(this);

                        // Check if the checkbox is checked
                        if ($(this).is(':checked')) {
                            // Show the corresponding column if checked
                            table.column(colIndex).visible(true);
                        } else {
                            // Hide the corresponding column if unchecked
                            table.column(colIndex).visible(false);
                        }
                    });
                }
                $("#sortable").sortable({
                    items: '.sort',
                    containment: "#sortable",
                    cursor: "move",
                    handle: ".handle",
                    revert: 100,
                    update: function(event, ui) {
                        $input = ui.item.find("input[type=checkbox]");
                        $input.trigger('change');
                    }
                });
                var columns = [];
                $("#sortable").disableSelection();

                $("#config_columns input[type=checkbox]").on('change', function(e) {
                    console.log("changed");
                    var columns = [];

                    // Get all checked checkboxes in the sorted order
                    $("#config_columns input:checkbox:checked").each(function() {
                        columns.push($(this).val()); // Add the column's index or identifier
                    });


                    $.post(<?php echo json_encode(site_url("sales/save_list_column_prefs")); ?>, {
                        columns: columns
                    }, function(json) {
                        setTableColumnOrder();
                        // table.draw();

                    });

                });


            });
            </script>

        </div>





                                </div>
                                <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_ecommerce_customer_general" role="tabpanel">

                        <div class="card shadow-sm mt-5">
                            <div class="card-header rounded rounded-3 p-5">
                                <h3 class="card-title">
                                    <i class="ion-edit"></i>
                                    <?php echo lang("customers_basic_information"); ?>
                                    <small>(<?php echo lang('fields_required_message'); ?>)</small>
                                </h3>
                            </div>

                            <div class="card-body">


                                <?php $this->load->view("people/form_basic_info"); ?>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="py-5 mb-5">
                                            <div class=" ">
                                                <div class="mb-10">
                                                    <div class="form-check">

                                                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
                                                            echo form_label(lang('internal_notes'))?></label>

                                                        <?php echo form_textarea(array(
                                                            'name'=>'internal_notes',
                                                            'id'=>'internal_notes',
                                                            'class'=>'form-control form-control-solid text-area',
                                                            'value'=>$person_info->internal_notes,
                                                            'rows'=>'5',
                                                            'cols'=>'17')		
                                                        );?>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="py-5 mb-5">
                                            <div class=" ">
                                                <div class="mb-10">
                                                    <div class="form-check">

                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            <?php 
						
                                                                        echo form_label(lang('invoices_terms'))?></label>

                                                        <?php
                                                            
                                                            echo form_dropdown('default_term_id', $terms, $person_info->default_term_id, 'class="form-select form-select-solid input_radius" id="section_names"');

                                                            ?>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="kt_ecommerce_customer_advanced" role="tabpanel">
                        <?php $this->load->view("people/advance_detail"); ?>

                    </div>
                    <div class="tab-pane fade" id="kt_ecommerce_customer_files" role="tabpanel">
                        <div class="card shadow-sm mt-5">
                            <div class="card-header rounded rounded-3 p-5">
                                <h3 class="card-title">
                                    <i class="ion-folder"></i>
                                    <?php echo lang("files"); ?>
                                </h3>
                            </div>

                            <?php if (count($files)) {?>
                            <ul class="list-group">
                                <?php foreach($files as $file){?>
                                <li class="list-group-item permission-action-item">

                                    <?php echo anchor($controller_name.'/delete_file/'.$file->file_id,'<i class="icon ion-android-cancel text-danger" style="font-size: 120%"></i>', array('class' => 'delete_file'));?>
                                    <?php echo anchor($controller_name.'/download/'.$file->file_id,$file->file_name,array('target' => '_blank'));?>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>

                            <div class="card-body">
                                <h4 style="padding: 20px;"><?php echo lang('add_files');?></h4>
                                <div class="row">

                                    <?php for($k=1;$k<=5;$k++) { ?>

                                    <div class="col-md-6">
                                        <div class="py-5 mb-5 px-8">
                                            <div class=" ">
                                                <div class="mb-10">
                                                    <div
                                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5 active">

                                                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('file').' '.$k.':', 'files_'.$k)?></label>
                                                        <div class="file-upload">
                                                            <input type="file" class="form-control form-control-solid"
                                                                name="files[]" id="files_<?php echo $k; ?>">
                                                        </div>

                                                    </div>


                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <?php } ?>
                                </div>
                            </div>


                            <?php echo form_hidden('redirect_code', $redirect_code); ?>

                            <div class="form-actions">
                                <?php
							if ($redirect_code == 1)
							{
								echo form_button(array(
							    'name' => 'cancel',
							    'id' => 'cancel',
								 'class' => 'submit_button btn btn-danger',
							    'value' => 'true',
							    'content' => lang('cancel')
								));
							
							}
							?>



                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php
							echo form_submit(array(
								'name'=>'submitf',
								'id'=>'submitf',
								'value'=>lang('save'),
								'class'=>' submit_button floating-button btn btn-lg btn-danger')
							);
							?>
        <?php echo form_close(); ?>


    </div>
    <?php
				$this->load->view('people/add_title_modal');		
			?>

</div><!-- /row -->
</div>

<script type='text/javascript'>
$(".override_default_tax_checkbox").change(function() {
    $(this).parent().parent().next().toggleClass('hidden')
});

check_taxable();
$("#taxable").change(check_taxable);

function check_taxable() {
    if ($("#taxable").prop('checked')) {
        $("#tax_certificate_holder").hide();
        <?php if($this->config->item('use_saudi_tax_config')) { ?>
        $(".zatca_buyer_info").show();
        <?php } ?>
    } else {
        $("#tax_certificate_holder").show();
    }
}

$('#image_id').imagePreview({
    selector: '#avatar'
}); // Custom preview container
//validation and submit handling
$(document).ready(function() {
    $("#cancel").click(cancelCustomerAddingFromSale);
    setTimeout(function() {
        $(":input:visible:first", "#customer_form").focus();
    }, 100);
    var submitting = false;

    $.validator.addMethod(
        "zatca_customer",
        function(value1, element, type) {

            if ($("#company_name").val().trim().length == 0)
                return true;

            var value = value1.trim();
            var check = false;
            if (type == "buyer_id") {
                if (value.length > 0)
                    check = true;
            } else if (type == "buyer_scheme_id") {
                if (value.length > 0)
                    check = true;
            } else if (type == "buyer_tax_id") {
                if (value.length > 0)
                    check = true;
            } else if (type == "buyer_party_postal_street_name") {
                if (value.length > 0)
                    check = true;
            } else if (type == "buyer_party_postal_building_number") {
                if (value.length == 4)
                    check = true;
            } else if (type == "buyer_party_postal_code") {
                if (value.length == 5)
                    check = true;
            } else if (type == "buyer_party_postal_city") {
                if (value.length > 0)
                    check = true;
            } else if (type == "buyer_party_postal_district") {
                if (value.length > 0)
                    check = true;
            } else if (type == "buyer_party_postal_plot_id") {
                if (value.length == 4)
                    check = true;
            } else {
                check = true;
            }
            return check;
        },
        "Please check the ZATCA buyer input validation."
    );

    $('#customer_form').validate({
        submitHandler: function(form) {
            $.post('<?php echo site_url("customers/check_duplicate");?>', {
                    name: $('#first_name').val() + ' ' + $('#last_name').val(),
                    email: $("#email").val(),
                    phone_number: $("#phone_number").val()
                }, function(data) {
                    <?php if(!$person_info->person_id) { ?>
                    if (data.duplicate) {
                        bootbox.confirm(
                            <?php echo json_encode(lang('customers_duplicate_exists'));?>,
                            function(result) {
                                if (result) {
                                    doCustomerSubmit(form);
                                }
                            });
                    } else {
                        doCustomerSubmit(form);
                    }
                    <?php } else { ?>
                    doCustomerSubmit(form);
                    <?php } ?>
                }, "json")
                .error(function() {});

        },
        rules: {
            <?php if(!$person_info->person_id) { ?>
            account_number: {
                remote: {
                    url: "<?php echo site_url('customers/account_number_exists');?>",
                    type: "post"

                }
            },
            <?php } ?>
            first_name: "required",
            <?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { 
											$custom_field = $this->Customer->get_custom_field($k);
											if($custom_field !== FALSE) {
												if( $this->Customer->get_custom_field($k,'required') && in_array($current_location, $this->Customer->get_custom_field($k,'locations'))){

													if(($this->Customer->get_custom_field($k,'type') == 'file' || $this->Customer->get_custom_field($k,'type') == 'image') && !$person_info->{"custom_field_${k}_value"}){
														echo "custom_field_${k}_value: 'required',\n";
													}
													
													if(($this->Customer->get_custom_field($k,'type') != 'file' && $this->Customer->get_custom_field($k,'type') != 'image')){
														echo "custom_field_${k}_value: 'required',\n";
													}
												}
											}
										}
											?>


            <?php if($this->config->item('use_saudi_tax_config')){ ?>
            zatca_buyer_id: {
                zatca_customer: 'buyer_id',
            },
            zatca_buyer_scheme_id: {
                zatca_customer: 'buyer_scheme_id',
            },
            zatca_buyer_tax_id: {
                zatca_customer: 'buyer_tax_id',
            },
            zatca_buyer_party_postal_street_name: {
                zatca_customer: 'buyer_party_postal_street_name',
            },
            zatca_buyer_party_postal_building_number: {
                zatca_customer: 'buyer_party_postal_building_number',
            },
            zatca_buyer_party_postal_code: {
                zatca_customer: 'buyer_party_postal_code',
            },
            zatca_buyer_party_postal_city: {
                zatca_customer: 'buyer_party_postal_city',
            },
            zatca_buyer_party_postal_district: {
                zatca_customer: 'buyer_party_postal_district',
            },
            zatca_buyer_party_postal_plot_id: {
                zatca_customer: 'buyer_party_postal_plot_id',
            }
            <?php } ?>
        },
        errorClass: "text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
        messages: {
            <?php if(!$person_info->person_id) { ?>
            account_number: {
                remote: <?php echo json_encode(lang('account_number_exists')); ?>
            },
            <?php } ?>
            first_name: <?php echo json_encode(lang('first_name_required')); ?>,
            last_name: <?php echo json_encode(lang('last_name_required')); ?>,

            <?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { 
												$custom_field = $this->Customer->get_custom_field($k);
												if($custom_field !== FALSE) {
													if( $this->Customer->get_custom_field($k,'required') && in_array($current_location, $this->Customer->get_custom_field($k,'locations'))){

														if(($this->Customer->get_custom_field($k,'type') == 'file' || $this->Customer->get_custom_field($k,'type') == 'image') && !$person_info->{"custom_field_${k}_value"}){
															$error_message = json_encode($custom_field." ".lang('is_required'));
															echo "custom_field_${k}_value: $error_message,\n";
														}

														if(($this->Customer->get_custom_field($k,'type') != 'file' && $this->Customer->get_custom_field($k,'type') != 'image')){
															$error_message = json_encode($custom_field." ".lang('is_required'));
															echo "custom_field_${k}_value: $error_message,\n";
														}


													}
												}
											}
											?>


        }
    });
});

var submitting = false;

function doCustomerSubmit(form) {
    $("#grid-loader").show();
    if (submitting) return;
    submitting = true;

    $(form).ajaxSubmit({
        success: function(response) {
            $("#grid-loader").hide();
            submitting = false;
            show_feedback(response.success ? 'success' : 'error', response.message, response.success ?
                <?php echo json_encode(lang('success')); ?> :
                <?php echo json_encode(lang('error')); ?>);


            if (response.redirect_code == 1 && response.success) {
                $.post('<?php echo site_url("sales/select_customer");?>', {
                    customer: response.person_id + '|FORCE_PERSON_ID|'
                }, function() {
                    window.location.href = '<?php echo site_url('sales/index/1'); ?>';
                });
            } else if (response.redirect_code == 2 && response.success) {
                window.location.href = '<?php echo site_url('customers'); ?>';
            }
            if (response.redirect_code == 3 && response.success) {
                redirectAddNewWorkOrder(response.person_id);
            } else {
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");
                $(".form-group").removeClass('has-success has-error');
            }
        },
        <?php if(!$person_info->person_id) { ?>
        resetForm: true,
        <?php } ?>
        dataType: 'json'
    });
}

function cancelCustomerAddingFromSale() {
    bootbox.confirm(<?php echo json_encode(lang('customers_are_you_sure_cancel')); ?>, function(response) {
        if (response) {
            window.location = <?php echo json_encode(site_url('sales')); ?>;
        }
    });
}

<?php if($redirect_new_order != ""){ ?>

function redirectAddNewWorkOrder(customer) {
    bootbox.confirm({
        message: <?php echo json_encode(lang('redirect_prompt')); ?>,
        buttons: {
            confirm: {
                label: <?php echo json_encode(lang('add_customer_to_work_order')); ?>,
                className: 'btn-primary'
            },
            cancel: {
                label: <?php echo json_encode(lang('cancel')); ?>,
                className: 'btn-default'
            }
        },
        callback: function(result) {
            if (result) {
                var done = function() {
                    window.location.href = <?php echo json_encode(site_url($redirect_new_order)); ?>;
                };
                $.post(<?php echo json_encode(site_url('work_orders/select_customer'))?>, {
                    customer: customer
                }, done);
            }
        }
    });
}
<?php } ?>

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
</script>

<?php $this->load->view("partial/footer"); ?>