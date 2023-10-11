<?php
$this->load->view("partial/header"); 
$this->load->helper('demo');
$this->load->helper('update');


?>
<div class="manage_buttons d-none">
    <div class="manage-row-options">
        <div class="email_buttons text-center">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-2">
                    <div class="search-tpl">
                        <div class="input-group">
                            <span class="input-group-text" id="search-addon"><span
                                    class="glyphicon glyphicon-search"></span></span>
                            <input aria-describedby="search-addon" type="text" class="form-control form-control-solid" name="search"
                                id="search" placeholder="<?php echo lang('common_search') ?>"
                                value="<?php echo H($search); ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php echo form_dropdown('section_names', $section_names, '', 'class="form-control input_radius" id="section_names"'); ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-10 pull-right">
                    <div class="pull-left">
                        <?php echo anchor('config/backup', '<span class="ion-load-a"> </span><span class="">' . lang('config_backup_database') . '</span>', array('class' => 'btn btn-primary btn-lg dbBackup hidden-xs')); ?>
                        <?php
					 $this->load->helper('update');
					 if (!is_on_saas_host()) {?>
                        <?php echo anchor('config/is_update_available', '<span class="glyphicon glyphicon-import"></span> <span class="hidden-xs hidden-sm">' . lang('common_check_for_update'). '</span>', array('class' => 'checkForUpdate btn btn-success btn-lg hidden-xs')); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div><!-- end email_buttons -->
    </div><!-- manage-row-options -->
</div><!-- manage_buttons -->

<?php
	//for help window popups
	$popupAtts = array(
    'width'       => 800,
    'height'      => 600,
    'scrollbars'  => 'yes',
    'status'      => 'yes',
    'resizable'   => 'yes',
    'screenx'     => 0,
    'screeny'     => 0,
    'window_name' => '_blank'
	);
	
	function create_section($title)
	{
		return $title ;
	}
	?>

<?php echo form_open_multipart('config/save/',array('id'=>'config_form','class'=>'form-horizontal', 'autocomplete'=> 'off'));  ?>
        <?php 
		$this->load->helper('update');

        if (is_on_saas_host() && !is_on_demo_host() && !empty($cloud_customer_info)) {?>
            <!-- Billing Information -->
            <div class="col-md-12">
                <div class="panel panel-piluku">
                    <div class="panel-heading rounded rounded-3 p-5">
                        <?php echo lang("config_billing_info"); ?>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span>
                            <?php echo lang('config_update_billing');?></div>
                        <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_billing')) ?>">
                            <?php if ($cloud_customer_info['payment_provider'] == 'paypal') { ?>
    
                            <div class="row">
                                <div class="col-md-10 col-md-offset-2">
                                    <?php echo lang('config_billing_is_managed_through_paypal');?>
                                </div>
                            </div>
    
                            <?php } else { ?>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-2">
                                    <a class="btn btn-block btn-update-billing btn-primary"
                                        href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username'];?>&username=<?php echo $this->Employee->get_logged_in_employee_info()->username; ?>&password=<?php echo $this->Employee->get_logged_in_employee_info()->password; ?>"
                                        target="_blank"><?php echo lang('common_update_billing_info');?></a>
                                </div>
                                <div class="col-md-4">
                                    <a class="btn btn-block btn-update-billing btn-default"
                                        href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username'];?>&username=<?php echo $this->Employee->get_logged_in_employee_info()->username; ?>&password=<?php echo $this->Employee->get_logged_in_employee_info()->password; ?>&cancel=1"
                                        target="_blank"><?php echo lang('config_cancel_account');?></a>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>



        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Aside-->
            <div class="flex-column flex-md-row-auto w-100 w-lg-250px w-xxl-275px">
                <!--begin::Nav-->
                <div class="card mb-6 mb-xl-9" style="position: fixed;height: 600px;overflow: hidden;overflow-y: scroll;" data-kt-sticky="true" data-kt-sticky-name="account-settings" data-kt-sticky-offset="{default: false, lg: 300}" data-kt-sticky-width="{lg: '250px', xxl: '275px'}" data-kt-sticky-left="auto" data-kt-sticky-top="100px" data-kt-sticky-zindex="95">
                    <!--begin::Card body-->
                    <div class="card-body py-10 px-6">
                        <!--begin::Menu-->
                        <ul id="kt_account_settings" class="nav nav-flush menu menu-column menu-rounded menu-title-gray-600 menu-bullet-gray-300 menu-state-bg menu-state-bullet-primary fw-semibold fs-6 mb-2">
                            <li class="menu-item px-3 pt-0 pb-1">
                                <a href="#config_company_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link active">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-vertical"></span>
                                    </span>
                                    <span class="menu-title"><?php echo create_section(lang("config_company_info")) ?></span>
                                </a>
                            </li>
                            <li class="menu-item px-3 pt-0 pb-1">
                                <a href="#config_taxes_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-vertical"></span>
                                    </span>
                                    <span class="menu-title"><?php echo create_section(lang('config_taxes_info'))  ?></span>
                                </a>
                            </li>
                            <li class="menu-item px-3 pt-0 pb-1">
                                <a href="#config_currency_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-vertical"></span>
                                    </span>
                                    <span class="menu-title"><?php echo create_section(lang('config_currency_info'))  ?></span>
                                </a>
                            </li>
                            <li class="menu-item px-3 pt-0 pb-1">
                                <a href="#config_payment_types_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-vertical"></span>
                                    </span>
                                    <span class="menu-title"><?php echo create_section(lang('config_payment_types_info'))  ?></span>
                                </a>
                            </li>
                             <li class="menu-item px-3 pt-0 pb-1">
                             <a href="#config_price_rules_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                 <span class="menu-bullet">
                                     <span class="bullet bullet-vertical"></span>
                                 </span>
                                 <span class="menu-title"><?php echo create_section(lang('config_price_rules_info'))  ?></span>
                             </a>
                         </li>
                         <li class="menu-item px-3 pt-0 pb-1">
                             <a href="#config_orders_and_deliveries_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                 <span class="menu-bullet">
                                     <span class="bullet bullet-vertical"></span>
                                 </span>
                                 <span class="menu-title"><?php echo create_section(lang('config_orders_and_deliveries_info'))  ?></span>
                             </a>
                         </li>
                         <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_sales_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_sales_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_suspended_sales_layaways_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_suspended_sales_layaways_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_receipt_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_receipt_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_profit_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_profit_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_barcodes_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_barcodes_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_customer_loyalty_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_customer_loyalty_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_price_tiers_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_price_tiers_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_auto_increment_ids_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_auto_increment_ids_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_items_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_items_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_employee_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_employee_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_store_accounts_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_store_accounts_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_disable_modules" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo lang('config_disable_modules')  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_application_settings_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_application_settings_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_email_settings_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_email_settings_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_sso_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_sso_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_quickbooks_settings" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_quickbooks_settings'), 'store-configuration-options', 'section-api-settings')  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_ecommerce_settings_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_ecommerce_settings_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_shopify_settings_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_shopify_settings_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_woocommerce_settings_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_woocommerce_settings_info'))  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_api_settings_info" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_api_settings_info'), 'store-configuration-options', 'section-api-settings')  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_webhooks" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo create_section(lang('config_webhooks'), 'store-configuration-options', 'section-webhooks-settings')  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_work_order" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo lang('config_work_order');  ?></span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#config_lookup_api_integration" data-kt-scroll-toggle="true" class="menu-link tab_link px-3 nav-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-vertical"></span>
                                </span>
                                <span class="menu-title"><?php echo lang('config_lookup_api_integration');  ?></span>
                            </a>
                        </li>






                        
                        </ul>
                        <!--end::Menu-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Nav-->
            </div>
            <!--end::Aside-->
            <!--begin::Layout-->
            <div class="flex-md-row-fluid ms-lg-12">
                <!--begin::Overview-->
                <div class="card mb-5 mb-xl-10" id="config_company_info" data-kt-scroll-offset="{default: 100, md: 125}">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_overview">
                        <div class="card-title">
                            <a data-toggle="collapse" data-parent="#collapsePanels" href="#company_information" id="toggle_company_info">
                                <?php echo create_section(lang("config_company_info")) ?>
                            </a>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_company_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                        <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_company')) ?>">
                            <?php echo form_label(lang('common_company_logo').':', 'company_logo',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                            <div class="col-sm-9 col-md-9 col-lg-10">

                                <input type="file" name="company_logo" id="company_logo" class="filestyle"
                                    data-icon="false">
                            </div>
                        </div>
                        <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_company')) ?>">
                            <?php echo form_label(lang('common_delete_logo').':', 'delete_logo',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                <?php echo form_checkbox('delete_logo', '1', null,'id="delete_logo" class="form-check-input""');?>
                                <label for="delete_logo"><span></span></label>
                            </div>
                        </div>
                        <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_company')) ?>">
                            <?php echo form_label(lang('common_company').':', 'company',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label  required')); ?>
                            <div class="col-sm-9 col-md-9 col-lg-10 input-field">
                                <?php echo form_input(array(
									'class'=>'validate form-control form-control-solid form-inps',
								'name'=>'company',
								'id'=>'company',
								'value'=>$this->config->item('company')));?>
                            </div>
                        </div>

                        <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_company')) ?>">
                            <?php echo form_label(lang('common_tax_id').':', 'tax_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                            <div class="col-sm-9 col-md-9 col-lg-10 input-field">
                                <?php echo form_input(array(
									'class'=>'validate form-control form-control-solid form-inps',
								'name'=>'tax_id',
								'id'=>'tax_id',
								'value'=>$this->config->item('tax_id')));?>
                            </div>
                        </div>

                        <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_company')) ?>">
                            <?php echo form_label(lang('common_website').':', 'website',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                            <div class="col-sm-9 col-md-9 col-lg-10 input-field">
                                <?php echo form_input(array(
								'class'=>'form-control form-control-solid form-inps',
								'name'=>'website',
								'id'=>'website',
								'value'=>$this->config->item('website')));?>
                            </div>
                        </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Overview-->
                <!--begin::Sign-in Method-->
                <div class="card mb-5 mb-xl-10" id="config_taxes_info" data-kt-scroll-offset="{default: 100, md: 125}">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#config_taxes_info">
                        <div class="card-title m-0">
                        <a data-toggle="collapse" data-parent="#collapsePanels" href="#taxes" id="toggle_Taxes_info">
                            <?php echo create_section(lang('config_taxes_info'))  ?>
                        </a>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_taxes_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                      
                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">
                        <?php echo form_label(lang('config_taxjar_api_key').':', 'taxjar_api_key',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10 input-field">
                            <?php echo form_input(array(
								'class'=>'form-control form-control-solid form-inps',
								'name'=>'taxjar_api_key',
								'id'=>'taxjar_api_key',
								'value'=>$this->config->item('taxjar_api_key')));?>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'tax_jar_location',
														'id'=>'tax_jar_location',
														'class' => 'form-check-input',
														'value'=>'tax_jar_location',
														'checked'=>$this->config->item('tax_jar_location')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_tax_jar_location')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">

                                            <?php echo form_checkbox(array(
															'name'=>'tax_jar_location',
															'id'=>'tax_jar_location',
															'class' => 'form-check-input',

															'value'=>'tax_jar_location',
															'checked'=>$this->config->item('tax_jar_location')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_tax_jar_location')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-13">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'flat_discounts_discount_tax',
														'id'=>'flat_discounts_discount_tax',
														'class' => 'form-check-input',

														'value'=>'flat_discounts_discount_tax',
														'checked'=>$this->config->item('flat_discounts_discount_tax')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_flat_discounts_discount_tax')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">

                                            <?php echo form_checkbox(array(
													'name'=>'prices_include_tax',
													'class' => 'form-check-input',

													'id'=>'prices_include_tax',
													'value'=>'prices_include_tax',
													'checked'=>$this->config->item('prices_include_tax')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('common_prices_include_tax')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-13">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'charge_tax_on_recv',
														'class' => 'form-check-input',

														'id'=>'charge_tax_on_recv',
														'value'=>'charge_tax_on_recv',
														'checked'=>$this->config->item('charge_tax_on_recv')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_charge_tax_on_recv')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'use_tax_value_at_all_locations',
														'class' => 'form-check-input',

														'id'=>'use_tax_value_at_all_locations',
														'value'=>'use_tax_value_at_all_locations',
														'checked'=>$this->Appconfig->all_locations_use_global_tax()));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_use_tax_value_at_all_locations')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>






                    <!-- Tax Classes -->
                    <div class="form-group no-padding-right"
                        data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">
                        <?php echo form_label(lang('config_tax_classes').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="col-md-9 col-sm-9 col-lg-10">
                            <div class="table-responsive">
                                <table id="tax_classes" class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('common_name'); ?></th>
                                            <th><?php echo lang('common_tax_name'); ?></th>
                                            <th><?php echo lang('common_tax_percent'); ?></th>
                                            <th><?php echo lang('common_cumulative'); ?></th>
                                            <th><?php echo lang('common_default'); ?></th>
                                            <th><?php echo lang('common_delete'); ?></th>
                                            <th><?php echo lang('common_add'); ?></th>
                                            <th><?php echo lang('common_id'); ?></th>
                                            <th><?php echo lang('config_sort'); ?></th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php
											 foreach($tax_classes as $tax_class_id => $tax_class) { 
												 ?>
                                        <tr data-index="<?php echo H($tax_class_id); ?>">
                                            <td class="tax_class_name top">
                                                <input type="text" class="rates form-control form-control-solid"
                                                    name="tax_classes[<?php echo H($tax_class_id); ?>][name]"
                                                    value="<?php echo H($tax_class['name']);?>" />
                                                <?php foreach($tax_class['taxes'] as $tax_class_tax) { ?>
                                                <input class="form-control form-control-solid" type="hidden"
                                                    name="taxes[<?php echo H($tax_class_id); ?>][tax_class_tax_id][]"
                                                    value="<?php echo H($tax_class_tax['id']); ?>">
                                                <?php } ?>
                                            </td>
                                            <td class="tax_class_rate_name top">

                                                <?php foreach($tax_class['taxes'] as $tax_class_taxes_data) { 
															?>
                                                <input
                                                    data-tax-class-tax-id="<?php echo H($tax_class_taxes_data['id']); ?>"
                                                    type="text" class="rates form-control form-control-solid"
                                                    name="taxes[<?php echo H($tax_class_id); ?>][name][]"
                                                    value="<?php echo H($tax_class_taxes_data['name']);?>" />
                                                <?php } ?>
                                            </td>

                                            <td class="tax_class_rate_percent top">
                                                <?php foreach($tax_class['taxes'] as $tax_class_taxes_data) { ?>
                                                <input type="text" class="rates form-control form-control-solid"
                                                    name="taxes[<?php echo H($tax_class_id); ?>][percent][]"
                                                    value="<?php echo H($tax_class_taxes_data['percent']);?>" />
                                                <?php } ?>
                                            </td>

                                            <td class="tax_class_rate_cumulative top">
                                                <?php 
														$tax_class_cum_counter = 0;
														foreach($tax_class['taxes'] as $tax_class_data) { 
															$cum_id = 'tax_class_'.$tax_class_id.'_cumulative_'.$tax_class_cum_counter;
															
															if ($tax_class_cum_counter == 1)
															{
														?>
                                                <?php echo form_checkbox('taxes['.H($tax_class_id).'][cumulative][]', '1', $tax_class_data['cumulative'],'id="'.$cum_id.'" class="form-control form-check-input rates cumulative_checkbox"');  ?>
                                                <label class="tax_class_cumulative_element"
                                                    for="<?php echo $cum_id; ?>"><span></span></label>
                                                <?php
													}
													else
													{
														?>
                                                <?php 
																echo form_hidden('taxes['.H($tax_class_id).'][cumulative][]', '0');
																echo form_checkbox('taxes['.H($tax_class_id).'][cumulative][]', '1', $tax_class_data['cumulative'],'disabled id="'.$cum_id.'" class="form-control form-check-input rates cumulative_checkbox invisible"');  ?>
                                                <label class="tax_class_cumulative_element invisible"
                                                    for="<?php echo $cum_id; ?>"><span></span></label>
                                                <?php
													}
														$tax_class_cum_counter++;
													 } ?>
                                            </td>

                                            <td class="tax_class_rate_default">
                                                <?php 
														$tax_class_default_counter = 0;
															$default_id = 'tax_class_'.$tax_class_id.'_default_'.$tax_class_default_counter;
														
															echo form_radio(array(
																'id' => $default_id,
																'name' =>'tax_class_id',
																'value' => $tax_class_id,
																'checked' => $this->config->item('tax_class_id') == $tax_class_id ? 'checked' : '',
															)); 
														?>
                                                <label class="tax_class_default_element"
                                                    for="<?php echo $default_id; ?>"><span></span></label>

                                                <?php
														$tax_class_default_counter++;
														?>
                                            </td>



                                            <td>
                                                <a
                                                    class="delete_tax_rate tax_table_rate_text_element btn btn-danger btn-sm"><?php echo lang('common_delete'); ?></a>
                                            </td>
                                            <td><a href="javascript:void(0);"
                                                    class="add_tax_rate btn btn-info btn-sm"><?php echo lang('config_add_rate'); ?></a>
                                            </td>
                                            <td><?php echo $tax_class_id; ?></td>
                                            <td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td>
                                        </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>

                                <a href="javascript:void(0);"
                                    class="add_tax_class btn btn-info btn-sm"><?php echo lang('config_add_tax_class'); ?></a>
                            </div>
                        </div><!-- end col -->
                    </div>
                </div>
                <!-- end form-group -->

                <?php if (!$this->config->item('tax_class_id')) {?>

                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">
                    <?php echo form_label(lang('common_default_tax_rate_1').':', 'default_tax_1_rate',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                    <div class="col-sm-4 col-md-4 col-lg-5">
                        <?php echo form_input(array(
								'class'=>'form-control form-inps',
								'name'=>'default_tax_1_name',
								'placeholder' => lang('common_tax_name'),
								'id'=>'default_tax_1_name',
								'size'=>'10',
								'value'=>$this->config->item('default_tax_1_name')!==NULL ? $this->config->item('default_tax_1_name') : lang('common_sales_tax_1')));?>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-5">
                        <div class="input-group">
                            <?php echo form_input(array(
										'class'=>'form-control form-inps-tax',
										'placeholder' => lang('common_tax_percent'),
										'name'=>'default_tax_1_rate',
										'id'=>'default_tax_1_rate',
										'size'=>'4',
										'value'=>$this->config->item('default_tax_1_rate')));?>
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">
                    <?php echo form_label(lang('common_default_tax_rate_2').':', 'default_tax_1_rate',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                    <div class="col-sm-4 col-md-4 col-lg-5">
                        <?php echo form_input(array(
									'class'=>'form-control form-inps',
									'name'=>'default_tax_2_name',
									'placeholder' => lang('common_tax_name'),
									'id'=>'default_tax_2_name',
									'size'=>'10',
									'value'=>$this->config->item('default_tax_2_name')!==NULL ? $this->config->item('default_tax_2_name') : lang('common_sales_tax_2')));?>
                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-5">
                        <div class="input-group">
                            <?php echo form_input(array(
										'class'=>'form-control form-inps-tax',	
										'name'=>'default_tax_2_rate',
										'placeholder' => lang('common_tax_percent'),
										'id'=>'default_tax_2_rate',
										'size'=>'4',
										'value'=>$this->config->item('default_tax_2_rate')));?>
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="clear"></div>
                        <?php echo form_checkbox('default_tax_2_cumulative', '1', $this->config->item('default_tax_2_cumulative') ? true : false, 'id="default_tax_2_cumulative" class="cumulative_checkbox"');  ?>
                        <label for="default_tax_2_cumulative"><span></span></label>
                        <span class="cumulative_label">
                            <?php echo lang('common_cumulative'); ?>
                        </span>
                    </div>
                    <div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-9 col-lg-offset-3"
                        style="display: <?php echo $this->config->item('default_tax_3_rate') ? 'none' : 'block';?>">
                        <a href="javascript:void(0);"
                            class="show_more_taxes btn btn-orange btn-round"><?php echo lang('common_show_more');?>
                            &raquo;</a>
                    </div>

                    <div class="col-md-12 more_taxes_container"
                        style="display: <?php echo $this->config->item('default_tax_3_rate') ? 'block' : 'none';?>">
                        <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">
                            <?php echo form_label(lang('common_default_tax_rate_3').':', 'default_tax_3_rate',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                            <div class="col-sm-4 col-md-4 col-lg-5">
                                <?php echo form_input(array(
												'class'=>'form-control form-inps',
												'name'=>'default_tax_3_name',
												'placeholder' => lang('common_tax_name'),
												'id'=>'default_tax_3_name',
												'size'=>'10',
												'value'=>$this->config->item('default_tax_3_name')!==NULL ? $this->config->item('default_tax_3_name') : ''));?>
                            </div>

                            <div class="col-sm-4 col-md-4 col-lg-5">
                                <div class="input-group">
                                    <?php echo form_input(array(
													'class'=>'form-control form-inps-tax',
													'placeholder' => lang('common_tax_percent'),
													'name'=>'default_tax_3_rate',
													'id'=>'default_tax_3_rate',
													'size'=>'4',
													'value'=>$this->config->item('default_tax_3_rate')));?>
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>

                        <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">
                            <?php echo form_label(lang('common_default_tax_rate_4').':', 'default_tax_4_rate',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                            <div class="col-sm-4 col-md-4 col-lg-5">
                                <?php echo form_input(array(
												'class'=>'form-control form-inps',
												'placeholder' => lang('common_tax_name'),
												'name'=>'default_tax_4_name',
												'id'=>'default_tax_4_name',
												'size'=>'10',
												'value'=>$this->config->item('default_tax_4_name')!==NULL ? $this->config->item('default_tax_4_name') : ''));?>
                            </div>

                            <div class="col-sm-4 col-md-4 col-lg-5">
                                <div class="input-group">
                                    <?php echo form_input(array(
													'class'=>'form-control form-inps-tax',
													'placeholder' => lang('common_tax_percent'),
													'name'=>'default_tax_4_rate',
													'id'=>'default_tax_4_rate',
													'size'=>'4',
													'value'=>$this->config->item('default_tax_4_rate')));?>
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>

                        <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_taxes')) ?>">
                            <?php echo form_label(lang('common_default_tax_rate_5').':', 'default_tax_5_rate',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                            <div class="col-sm-4 col-md-4 col-lg-5">
                                <?php echo form_input(array(
												'class'=>'form-control form-inps',
												'placeholder' => lang('common_tax_name'),
												'name'=>'default_tax_5_name',
												'id'=>'default_tax_5_name',
												'size'=>'10',
												'value'=>$this->config->item('default_tax_5_name')!==NULL ? $this->config->item('default_tax_5_name') : ''));?>
                            </div>

                            <div class="col-sm-4 col-md-4 col-lg-5">
                                <div class="input-group">
                                    <?php echo form_input(array(
													'class'=>'form-control form-inps-tax',
													'placeholder' => lang('common_tax_percent'),
													'name'=>'default_tax_5_rate',
													'id'=>'default_tax_5_rate',
													'size'=>'4',
													'value'=>$this->config->item('default_tax_5_rate')));?>
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>

                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#config_currency_info">
                        <div class="card-title m-0">
                        <a data-toggle="collapse" data-parent="#collapsePanels" href="#currency" id="toggle_currency_info">
                            <?php echo create_section(lang('config_currency_info'))  ?>
                        </a>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_currency_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                      

                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_currency')) ?>">
                        <?php echo form_label(lang('config_currency_symbol').':', 'currency_symbol',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
								'name'=>'currency_symbol',
								'id'=>'currency_symbol',
								'value'=>$this->config->item('currency_symbol')));?>
                        </div>
                    </div>

                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_currency')) ?>">
                        <?php echo form_label(lang('config_currency_code').':', 'currency_code',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
								'name'=>'currency_code',
								'style' => 'margin-top: 12px;',
								'id'=>'currency_code',
								'value'=>$this->config->item('currency_code')));?>
                        </div>
                    </div>


                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_currency')) ?>">
                        <?php echo form_label(lang('config_currency_exchange_rates').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="table-responsive col-sm-9 col-md-9 col-lg-10">
                            <table id="currency_exchange_rates" class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('common_exchange_to'); ?></th>
                                        <th><?php echo lang('config_currency_symbol'); ?></th>
                                        <th><?php echo lang('config_currency_symbol_location'); ?></th>
                                        <th><?php echo lang('config_number_of_decimals'); ?></th>
                                        <th><?php echo lang('config_thousands_separator'); ?></th>
                                        <th><?php echo lang('config_decimal_point'); ?></th>
                                        <th><?php echo lang('config_exchange_rate'); ?></th>
                                        <th><?php echo lang('common_delete'); ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach($currency_exchange_rates->result() as $currency_exchange_rate) { ?>
                                    <tr>
                                        <td><input type="text" name="currency_exchange_rates_to[]"
                                                class="form-control form-control-solid"
                                                value="<?php echo H($currency_exchange_rate->currency_code_to); ?>" />
                                        </td>
                                        <td><input type="text" name="currency_exchange_rates_symbol[]"
                                                class="form-control form-control-solid"
                                                value="<?php echo H($currency_exchange_rate->currency_symbol); ?>" />
                                        </td>
                                        <td><?php echo form_dropdown('currency_exchange_rates_symbol_location[]', array(
				 							'before'    => lang('config_before_number'),
				 							'after'    => lang('config_after_number'),
										),$currency_exchange_rate->currency_symbol_location,'class="form-select form-select-solid"');?></td>
                                        <td><?php echo form_dropdown('currency_exchange_rates_number_of_decimals[]', array(
					 							''  => lang('config_let_system_decide'),
					 							'0'    => '0',
					 							'1'    => '1',
					 							'2'    => '2',
					 							'3'    => '3',
					 							'4'    => '4',
					 							'5'    => '5',
											),$currency_exchange_rate->number_of_decimals
					 							 , 'class="form-control" id="number_of_decimals"');
											?></td>
                                        <td><input type="text" name="currency_exchange_rates_thousands_separator[]"
                                                class="orm-control form-control-solid"
                                                value="<?php echo H($currency_exchange_rate->thousands_separator); ?>" />
                                        </td>
                                        <td><input type="text" name="currency_exchange_rates_decimal_point[]"
                                                class="orm-control form-control-solid"
                                                value="<?php echo H($currency_exchange_rate->decimal_point); ?>" /></td>
                                        <td><input type="text" name="currency_exchange_rates_rate[]"
                                                class="orm-control form-control-solid"
                                                value="<?php echo H(to_currency_no_money($currency_exchange_rate->exchange_rate,10)); ?>" />
                                        </td>
                                        <td><a class="delete_currency_exchange_rate text-primary"
                                                href="javascript:void(0);"><?php echo lang('common_delete'); ?></a></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <a href="javascript:void(0);" class="btn btn-info btn-sm"
                                id="add_exchange_rate"><?php echo lang('config_add_currency_exchange_rate'); ?></a>
                        </div>
                    </div>


                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_currency')) ?>">
                        <?php echo form_label(lang('config_currency_symbol_location').':', 'currency_symbol_location',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <?php echo form_dropdown('currency_symbol_location', array(
	 							'before'    => lang('config_before_number'),
	 							'after'    => lang('config_after_number'),
								'class' => 'form-select form-select-solid',
							),
	 							$this->config->item('currency_symbol_location')===NULL ? 'before' : $this->config->item('currency_symbol_location') , 'class="form-select form-select-solid" style="    padding-top: 13px; margin-top: 19px;" id="currency_symbol_location"');
	 							?>
                        </div>
                    </div>

                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_currency')) ?>">
                        <?php echo form_label(lang('config_number_of_decimals').':', 'number_of_decimals',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <?php echo form_dropdown('number_of_decimals', array(
	 							''  => lang('config_let_system_decide'),
	 							'0'    => '0',
	 							'1'    => '1',
	 							'2'    => '2',
	 							'3'    => '3',
	 							'4'    => '4',
	 							'5'    => '5',
							),
	 							$this->config->item('number_of_decimals')===NULL ? '' : $this->config->item('number_of_decimals') , 'class="form-select form-select-solid" style="margin-top: 12px;" id="number_of_decimals"');
	 							?>
                        </div>
                    </div>

                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_currency')) ?>">
                        <?php echo form_label(lang('config_thousands_separator').':', 'thousands_separator',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10 input-field">
                            <?php echo form_input(array(
									'class'=>'validate form-control form-control-solid form-inps',
								'name'=>'thousands_separator',
								'style' => 'margin-top: 12px;',
								'id'=>'thousands_separator',
								'value'=>$this->config->item('thousands_separator') ? $this->config->item('thousands_separator') : ','));?>
                        </div>
                    </div>

                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_currency')) ?>">
                        <?php echo form_label(lang('config_decimal_point').':', 'decimal_point',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10 input-field">
                            <?php echo form_input(array(
									'class'=>'validate form-control form-control-solid form-inps',
								'name'=>'decimal_point',
								'style' => 'margin-top: 12px',
								'id'=>'decimal_point',
								'value'=>$this->config->item('decimal_point') ? $this->config->item('decimal_point') : '.'));?>
                        </div>
                    </div>

                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_currency')) ?>">
                        <?php echo form_label(lang('config_currency_denoms').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="table-responsive col-sm-12 col-md-12 col-lg-12">
                            <table id="currency_denoms" class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('common_denomination'); ?></th>
                                        <th><?php echo lang('config_currency_value'); ?></th>
                                        <th><?php echo lang('common_delete'); ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach($currency_denoms->result() as $currency_denom) { ?>
                                    <tr>
                                        <td><input type="text" name="currency_denoms_name[]"
                                                class="form-control form-control-solid"
                                                value="<?php echo H($currency_denom->name); ?>" /></td>
                                        <td><input type="text" name="currency_denoms_value[]"
                                                class="form-control form-control-solid"
                                                value="<?php echo H(to_currency_no_money($currency_denom->value)); ?>" />
                                        </td>
                                        <td><a class="delete_currency_denom text-primary btn btn-danger btn-sm"
                                                data-id="<?php echo H($currency_denom->id); ?>"
                                                href="javascript:void(0);"><?php echo lang('common_delete'); ?></a></td>
                                        <input type="hidden" name="currency_denoms_ids[]"
                                            value="<?php echo H($currency_denom->id); ?>" />
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <a href="javascript:void(0);" id="add_denom"
                                class="btn btn-info btn-sm"><?php echo lang('config_add_currency_denom'); ?></a>
                        </div>
                    </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->




                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#config_payment_types_info">
                        <div class="card-title m-0">
                          
                            <h3 class="fw-bold m-0">  <?php echo create_section(lang('config_payment_types_info'))  ?></h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_payment_types_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            

<div class="form-group" data-keyword="<?php echo H(lang('config_keyword_payment')) ?>">
    <?php echo form_label(lang('config_payment_types').':', 'additional_payment_types',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
    <div class="col-sm-9 col-md-9 col-lg-10">
        <a href="#" class="btn btn-primary payment_types"><?php echo lang('common_cash'); ?></a>
        <a href="#" class="btn btn-primary payment_types"><?php echo lang('common_check'); ?></a>
        <a href="#" class="btn btn-primary payment_types"><?php echo lang('common_giftcard'); ?></a>
        <a href="#" class="btn btn-primary payment_types"><?php echo lang('common_debit'); ?></a>
        <a href="#" class="btn btn-primary payment_types"><?php echo lang('common_credit'); ?></a>
        <br>
        <br>
        <?php echo form_input(array(
                'class'=>'form-control form-inps',
                'name'=>'additional_payment_types',
                'id'=>'additional_payment_types',
                
                'size'=> 40,
                'value'=>$this->config->item('additional_payment_types')));?>
    </div>
</div>

<?php
    
    $markup_markdown = array();
    if ($this->config->item('markup_markdown'))
    {
        $markup_markdown = unserialize($this->config->item('markup_markdown'));
    }
    
    foreach(array_keys($this->Sale->get_payment_options_with_language_keys()) as $payment_type)
    {
    ?>

<div class="col-md-2">
</div>



<div class="col-md-10">
    <div class="form-check" data-keyword="<?php echo H(lang('config_keyword_payment')) ?>">
        <?php 
                $markup_down_value = isset($markup_markdown[$payment_type]) ? $markup_markdown[$payment_type] : '';
                echo form_input(array(
                'class'=>'form-control form-control-solid ',
                'name'=>'markup_markdown['.hex_encode($payment_type).']',
                'id'=>'sale_prefix',
                'value'=>$markup_down_value));?>
        <label class="form-check-label"
            for="flexCheckDefault"><?php echo form_label($payment_type.' '.lang('config_markup_markdown').' '.lang('common_percentage'), 'payment_type_markup_markdown') ?></label>
    </div>
</div>




<?php
    }
    ?>

<div class="row>">
    <div class="col-md-12">
        <div class="py-5 mb-5">
            <div class="rounded border p-10">
                <div class="mb-10">
                    <div class="form-check"
                        data-keyword="<?php echo H(lang('config_keyword_payment')) ?>">
                        <label class="form-check-label"
                            for="flexCheckDefault"><?php echo form_label(lang('config_default_payment_type')) ?></label>
                        <?php echo form_dropdown('default_payment_type', $payment_options, $this->config->item('default_payment_type'),'class="form-select form-select-solid" id="default_payment_type"'); ?>

                    </div>
                </div>
                <div class="mb-10">
                    <div class="form-check"
                        data-keyword="<?php echo H(lang('config_keyword_payment')) ?>">
                        <label class="form-check-label"
                            for="flexCheckDefault"><?php echo form_label(lang('config_default_payment_type_recv')) ?></label>
                        <?php echo form_dropdown('default_payment_type_recv', $payment_options, $this->config->item('default_payment_type_recv'),'class="form-select form-select-solid" id="default_payment_type_recv"'); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="py-5 mb-5">
            <div class="rounded border p-10">
                <div class="mb-10">
                    <div class="form-check"
                        data-keyword="<?php echo H(lang('config_keyword_payment')) ?>">
                        <?php echo form_checkbox(array(
            'name'=>'show_selling_price_on_recv',
            'id'=>'show_selling_price_on_recv',
            'class' => 'form-check-input',
            'value'=>'1',
            'checked'=>$this->config->item('show_selling_price_on_recv')));?>
                        <label class="form-check-label"
                            for="flexCheckDefault"><?php echo form_label(lang('config_show_selling_price_on_recv')) ?></label>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="form-check"
                        data-keyword="<?php echo H(lang('config_keyword_payment')) ?>">
                        <?php echo form_checkbox(array(
            'name'=>'enable_ebt_payments',
            'id'=>'enable_ebt_payments',
            'class' => 'form-check-input',

            'value'=>'1',
            'checked'=>$this->config->item('enable_ebt_payments')));?>
                        <label class="form-check-label"
                            for="flexCheckChecked"><?php echo form_label(lang('config_enable_ebt_payments')) ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row>">
    <div class="col-md-12">
    </div>

    <div class="col-md-12">
        <div class="py-5 mb-5">
            <div class="rounded border p-10">
                <div class="mb-10">
                    <div class="form-check"
                        data-keyword="<?php echo H(lang('config_keyword_payment')) ?>">
                        <?php echo form_checkbox(array(
            'name'=>'enable_wic',
            'id'=>'enable_wic',
            'class' => 'form-check-input',
            'value'=>'1',
            'checked'=>$this->config->item('enable_wic')));?>
                        <label class="form-check-label"
                            for="flexCheckDefault"><?php echo form_label(lang('config_enable_wic')) ?></label>
                    </div>
                </div>


                <div class="mb-0">
                    <div class="form-check"
                        data-keyword="<?php echo H(lang('config_keyword_payment')) ?>">
                        <?php echo form_checkbox(array(
            'name'=>'prompt_for_ccv_swipe',
            'id'=>'prompt_for_ccv_swipe',
            'class' => 'form-check-input',

            'value'=>'1',
            'checked'=>$this->config->item('prompt_for_ccv_swipe')));?>
                        <label class="form-check-label"
                            for="flexCheckChecked"><?php echo form_label(lang('config_prompt_for_ccv_swipe')) ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->



                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#config_price_rules_info">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> <?php echo create_section(lang('config_price_rules_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_price_rules_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">


                        <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_price_rules')) ?>">
                                        <?php echo form_checkbox(array(
								'name'=>'disable_price_rules_dialog',
								'id'=>'disable_price_rules_dialog',
								'class' => 'form-check-input',
								'value'=>'disable_price_rules_dialog',
								'checked'=>$this->config->item('disable_price_rules_dialog')));?>
                                        <label class="form-check-label"
                                            for="flexCheckDefault"><?php echo form_label(lang('config_disable_price_rules_dialog') ) ?></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->




                <!--begin::Sign-in Method-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">  <?php echo create_section(lang('config_orders_and_deliveries_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_orders_and_deliveries_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                        <div class="mb-10">
                        <div class="form-check"
                            data-keyword="<?php echo H(lang('config_keyword_orders_deliveries')) ?>">
                            <?php echo form_checkbox(array(
								'name'=>'do_not_tax_service_items_for_deliveries',
								'id'=>'do_not_tax_service_items_for_deliveries',
								'class' => 'form-check-input',
								'value'=>'1',
								'checked'=>$this->config->item('do_not_tax_service_items_for_deliveries')));?>
                            <label class="form-check-label"
                                for="flexCheckDefault"><?php echo form_label(lang('config_do_not_tax_service_items_for_deliveries')) ?></label>
                        </div>
                    </div>

                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_orders_deliveries')) ?>">
                        <?php echo form_label(lang('config_delivery_color_based_on').':', 'delivery_color_based_on',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <?php
									$color_options = array(
										'status' => lang('config_delivery_color_based_on_status'),
										'category' => lang('config_delivery_color_based_on_category')
									);
								 	echo form_dropdown('delivery_color_based_on', $color_options, $this->config->item('delivery_color_based_on'),'class="form-select form-select-solid" id="delivery_color_based_on"');
								?>
                        </div>
                    </div>

                    <div class="form-group no-padding-right"
                        data-keyword="<?php echo H(lang('config_keyword_orders_deliveries')) ?>">
                        <?php echo form_label(lang('config_shipping_providers').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="col-md-9 col-sm-9 col-lg-10">
                            <div class="table-responsive">
                                <table id="shipping_providers" class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('common_name'); ?></th>
                                            <th><?php echo lang('config_rate_name'); ?></th>
                                            <th><?php echo lang('config_rate_fee'); ?></th>
                                            <th><?php echo lang('config_delivery_time'); ?></th>

                                            <th><?php echo lang('common_default'); ?></th>
                                            <th><?php echo lang('common_delete'); ?></th>

                                            <th><?php echo lang('common_add'); ?></th>
                                            <th><?php echo lang('config_sort'); ?></th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php
											 foreach($shipping_providers->result_array() as $shipping_provider) { 
												 $provider_id = $shipping_provider['id'];
												 
												 $methods = $this->Shipping_method->get_all($provider_id)->result_array();
												 $sorted_shipping_methods = array();
												 
												 foreach($methods as $method)
												 {
													 $sorted_shipping_methods['id'][] = $method['id'];
													 $sorted_shipping_methods['name'][] = $method['name'];
													 $sorted_shipping_methods['fee'][] = $method['fee'];
													 $sorted_shipping_methods['time_in_days'][] = $method['time_in_days'];
													 $sorted_shipping_methods['is_default'][] = $method['is_default'];
												 }
													
												 //If we don't have any methods the 1st row should have blanks
												 if (empty($sorted_shipping_methods['name']))
												 {
			  										$sorted_shipping_methods['id'][] = '';
			 										 	$sorted_shipping_methods['name'][] = '';
													 	$sorted_shipping_methods['fee'][] = 0;
													 	$sorted_shipping_methods['fee_tax'][] = 0;
													 	$sorted_shipping_methods['time_in_days'][] = '';
													 	$sorted_shipping_methods['is_default'][] = '';
												 }
													
												 ?>
                                        <tr data-index="<?php echo H($provider_id); ?>">
                                            <td class="shipping_provider_name top">
                                                <input type="text" class="rates form-control"
                                                    name="providers[<?php echo H($provider_id); ?>][name]"
                                                    value="<?php echo H($shipping_provider['name']);?>" />
                                                <?php foreach($sorted_shipping_methods['name'] as $index => $name) { ?>
                                                <input type="hidden"
                                                    name="methods[<?php echo H($provider_id); ?>][method_id][]"
                                                    value="<?php echo H($sorted_shipping_methods['id'][$index]); ?>">
                                                <?php } ?>
                                            </td>
                                            <td class="delivery_rate_name top">

                                                <?php foreach($sorted_shipping_methods['name'] as $index => $name) { ?>
                                                <input
                                                    data-method-id="<?php echo H($sorted_shipping_methods['id'][$index]); ?>"
                                                    type="text" class="rates form-control"
                                                    name="methods[<?php echo H($provider_id); ?>][name][]"
                                                    value="<?php echo H($name);?>" />
                                                <?php } ?>
                                            </td>

                                            <td class="delivery_fee top">
                                                <?php foreach($sorted_shipping_methods['fee'] as $fee) { ?>
                                                <input type="text" class="rates form-control"
                                                    name="methods[<?php echo H($provider_id); ?>][fee][]"
                                                    value="<?php echo H(to_currency_no_money($fee));?>" />
                                                <?php } ?>
                                            </td>

                                            <td class="delivery_time top">
                                                <?php foreach($sorted_shipping_methods['time_in_days'] as $time_in_days) { ?>
                                                <input type="text" class="rates form-control"
                                                    name="methods[<?php echo H($provider_id); ?>][time_in_days][]"
                                                    value="<?php echo H(to_quantity($time_in_days, ''));?>" />
                                                <?php } ?>
                                            </td>


                                            <td class="delivery_default top">
                                                <?php 
														$i = 0;
														foreach($sorted_shipping_methods['is_default'] as $is_default) { 
															echo form_radio(array(
																'id' => 'default_shipping_rate_'. $provider_id . '_' . $i,
																'name' =>'methods['. H($provider_id) .']'.'[is_default][]',
																'value' => '1',
																'checked' => $is_default == 1 ? 'checked' : '',
															)); 
														?>
                                                <label class="shipping_table_rate_element"
                                                    for="<?php echo H('default_shipping_rate_' . $provider_id . '_' . $i); ?>"><span></span></label>
                                                <?php
															$i++;
														} ?>
                                            </td>
                                            <td>
                                                <a
                                                    class="delete_rate shipping_table_rate_text_element btn btn-danger btn-sm"><?php echo lang('common_delete'); ?></a>
                                            </td>
                                            <td><a href="javascript:void(0);"
                                                    class="add_delivery_rate btn btn-info btn-sm"><?php echo lang('config_add_rate'); ?></a>
                                            </td>
                                            <td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td>
                                        </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>

                                <a href="javascript:void(0);"
                                    class="add_shipping_provider btn btn-info btn-sm"><?php echo lang('config_add_shipping_provider'); ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group no-padding-right"
                        data-keyword="<?php echo H(lang('config_keyword_orders_deliveries')) ?>">
                        <?php echo form_label(lang('config_shipping_zones').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="col-md-9 col-sm-9 col-lg-10">
                            <div class="table-responsive">
                                <table id="shipping_zones" class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('common_name'); ?></th>
                                            <th><?php echo lang('common_zips').' ('.lang('config_support_regex'); ?>)
                                            </th>
                                            <th><?php echo lang('common_fee'); ?></th>
                                            <th><?php echo lang('config_tax_class'); ?></th>
                                            <th><?php echo lang('common_delete'); ?></th>
                                            <th><?php echo lang('config_sort'); ?></th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php
													 foreach($shipping_zones->result_array() as $shipping_zone) { 
														 $zone_id = $shipping_zone['id'];
														 $zips_for_zone = array();
														 $zips_for_zone_str = '';
														 foreach($this->Zip->get_zips_for_zone($zone_id)->result_array() as $zip_row)
														 {
														 	$zips_for_zone[] = $zip_row['name'];
														 }
														 
														 
														 $zips_for_zone_str = implode('|',$zips_for_zone);
														?>
                                        <tr data-index="<?php echo H($zone_id); ?>">
                                            <td class="shipping_zone_name top" style="width: 10%; min-width:100px;">
                                                <input type="text" class="zones form-control form-control-solid"
                                                    name="zones[<?php echo H($zone_id); ?>][name]"
                                                    value="<?php echo H($shipping_zone['name']);?>" />
                                            </td>

                                            <td class="shipping_zone_zips top" style="width: 50%;">
                                                <input type="text" class="zones form-control form-control-solid"
                                                    name="zones[<?php echo H($zone_id); ?>][zips]"
                                                    value="<?php echo H($zips_for_zone_str);?>" />
                                            </td>

                                            <td class="shipping_zone_fee top" style="width: 10%; min-width:100px;">
                                                <input type="text" class="zones form-control form-control-solid"
                                                    name="zones[<?php echo H($zone_id); ?>][fee]"
                                                    value="<?php echo H(to_currency_no_money($shipping_zone['fee']));?>" />
                                            </td>

                                            <td class="shipping_zone_tax_group top"
                                                style="width: 10%; min-width:200px;">
                                                <select class="zones form-select form-select-solid"
                                                    name="zones[<?php echo H($zone_id); ?>][tax_class_id]">
                                                    <?php foreach($tax_groups as $tax_group) { ?>
                                                    <option value="<?php echo $tax_group['val'] ?>"
                                                        <?php echo $shipping_zone['tax_class_id'] == $tax_group['val'] ? 'selected="selected"' : '' ?>>
                                                        <?php echo $tax_group['text'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <td style="width: 10%;">
                                                <a class="delete_zone"><?php echo lang('common_delete'); ?></a>
                                            </td>

                                            <td style="width: 10%;"><span
                                                    class="ui-icon ui-icon-arrowthick-2-n-s"></span></td>
                                        </tr>

                                        <?php } //end shipping zones ?>
                                    </tbody>
                                </table>

                                <a href="javascript:void(0);"
                                    class="add_shipping_zone btn btn-info btn-sm"><?php echo lang('config_add_shipping_zone'); ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_orders_deliveries')) ?>">
                        <?php echo form_label(lang('config_default_employee_for_deliveries').':', 'default_employee_for_deliveries',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <?php 
										$employees = array('' => lang('common_logged_in_employee'));

										foreach($this->Employee->get_all()->result() as $employee)
										{
											$employees[$employee->person_id] = $employee->first_name .' '.$employee->last_name;
										}
										
										echo form_dropdown('default_employee_for_deliveries', $employees, $this->config->item('default_employee_for_deliveries'), 'class="form-select form-select-solid"  style="margin-top: 12px;" id="default_employee_for_deliveries"'); 
									?>
                        </div>
                    </div>


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->



                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">  <?php echo create_section(lang('config_sales_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_sales_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                        <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                        <?php echo form_label(lang('config_prefix').':', 'sale_prefix',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label  required')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <?php echo form_input(array(
									'class'=>'form-control form-inps',
								'name'=>'sale_prefix',
								'id'=>'sale_prefix',
								'value'=>$this->config->item('sale_prefix')));?>
                        </div>
                    </div>

                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                        <?php echo form_label(lang('config_id_to_show_on_sale_interface').':', 'id_to_show_on_sale_interface',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label  required')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <?php echo form_dropdown('id_to_show_on_sale_interface', array(
								'number'  => lang('common_item_number_expanded'),
								'product_id'    => lang('common_product_id'),
								'id'   => lang('common_item_id')
								),
								$this->config->item('id_to_show_on_sale_interface'), 'class="form-control" id="id_to_show_on_sale_interface"')
								?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'hide_supplier_on_sales_interface',
														'id'=>'hide_supplier_on_sales_interface',
														'class' => 'form-check-input',
														'value'=>'1',
														'checked'=>$this->config->item('hide_supplier_on_sales_interface')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_hide_supplier_on_sales_interface')) ?></label>
                                        </div>
                                    </div>



                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
															'name'=>'hide_supplier_on_recv_interface',
															'id'=>'hide_supplier_on_recv_interface',
															'class' => 'form-check-input',

															'value'=>'1',
															'checked'=>$this->config->item('hide_supplier_on_recv_interface')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_hide_supplier_on_recv_interface')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
															'name'=>'allow_drag_drop_sale',
															'id'=>'allow_drag_drop_sale',
															'class' => 'form-check-input',

															'value'=>'1',
															'checked'=>$this->config->item('allow_drag_drop_sale')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_allow_drag_drop_sale')) ?></label>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'flat_discounts_discount_tax',
														'id'=>'allow_drag_drop_recv',
														'class' => 'form-check-input',

														'value'=>'1',

														'checked'=>$this->config->item('allow_drag_drop_recv')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_allow_drag_drop_recv')) ?></label>
                                        </div>
                                    </div>



                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
													'name'=>'disable_discounts_percentage_per_line_item',
													'class' => 'form-check-input',

													'id'=>'disable_discounts_percentage_per_line_item',
													'value'=>'1',

													'checked'=>$this->config->item('disable_discounts_percentage_per_line_item')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_disable_discounts_percentage_per_line_item')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
													'name'=>'disabled_fixed_discounts',
													'class' => 'form-check-input',

													'id'=>'disabled_fixed_discounts',
													'value'=>'1',

													'checked'=>$this->config->item('disabled_fixed_discounts')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('disabled_fixed_discounts')) ?></label>
                                        </div>
                                    </div>





                                </div>
                            </div>
                        </div>




                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'disable_discount_by_percentage',
														'class' => 'form-check-input',

														'id'=>'disable_discount_by_percentage',
														'value'=>'1',
														'checked'=>$this->config->item('disable_discount_by_percentage')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_disable_discount_by_percentage')) ?></label>
                                        </div>
                                    </div>



                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'disable_sale_cloning',
														'id'=>'disable_sale_cloning',
														'value'=>'1',
														'class' => 'form-check-input',

														'checked'=>$this->config->item('disable_sale_cloning')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_common_disable_sale_cloning')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'always_put_last_added_item_on_top_of_cart',
														'id'=>'always_put_last_added_item_on_top_of_cart',
														'value'=>'1',
														'class' => 'form-check-input',

														'checked'=>$this->config->item('always_put_last_added_item_on_top_of_cart')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_always_put_last_added_item_on_top_of_cart')) ?></label>
                                        </div>
                                    </div>





                                </div>
                            </div>

                        </div>

                    </div>



                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-12">

                            <div class="py-5 mb-5">
                                <div class="rounded border p-13">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'disable_recv_cloning',
														'class' => 'form-check-input',

														'id'=>'disable_recv_cloning',
														'value'=>'1',
														'checked'=>$this->config->item('disable_recv_cloning')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_disable_recv_cloning')) ?></label>
                                        </div>
                                    </div>






                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'scan_and_set_sales',
														'id'=>'scan_and_set_sales',
														'value'=>'1',
														'class' => 'form-check-input',

														'checked'=>$this->config->item('scan_and_set_sales')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_scan_and_set_sales')) ?></label>
                                        </div>
                                    </div>




                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'scan_and_set_recv',
														'id'=>'scan_and_set_recv',
														'value'=>'1',
														'class' => 'form-check-input',

														'checked'=>$this->config->item('scan_and_set_recv')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_scan_and_set_recv')) ?></label>
                                        </div>
                                    </div>





                                </div>
                            </div>

                        </div>
                    </div>






                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                        <?php echo form_label(lang('config_damaged_reasons').':', 'damaged_reasons',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <?php echo form_input(array(
								'class'=>'form-control form-inps',
								'name'=>'damaged_reasons',
								'id'=>'damaged_reasons',
								'size'=> 40,
								'value'=>$this->config->item('damaged_reasons')));?>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">

                            <div class="py-5 mb-5">
                                <div class="rounded border p-13">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'enable_tips',
														'class' => 'form-check-input',

														'id'=>'enable_tips',
														'value'=>'1',
														'checked'=>$this->config->item('enable_tips')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_not_all_processors_support_tips')) ?></label>
                                        </div>
                                    </div>






                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'enable_tips',
														'id'=>'enable_tips',
														'value'=>'1',
														'class' => 'form-check-input',

														'checked'=>$this->config->item('enable_tips')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_not_all_processors_support_tips')) ?></label>
                                        </div>
                                    </div>




                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'tip_preset_zero',
														'id'=>'tip_preset_zero',
														'value'=>'tip_preset_zero',
														'class' => 'form-check-input',

														'checked'=>$this->config->item('tip_preset_zero')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_tip_preset_zero')) ?></label>
                                        </div>
                                    </div>





                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="py-5 mb-5">
                                <div class="rounded border p-13">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'auto_focus_on_item_after_sale_and_receiving',
														'class' => 'form-check-input',

														'id'=>'auto_focus_on_item_after_sale_and_receiving',
														'value'=>'auto_focus_on_item_after_sale_and_receiving',
														'checked'=>$this->config->item('auto_focus_on_item_after_sale_and_receiving')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_auto_focus_on_item_after_sale_and_receiving')) ?></label>
                                        </div>
                                    </div>






                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'capture_internal_notes_during_sale',
														'id'=>'capture_internal_notes_during_sale',
														'value'=>'capture_internal_notes_during_sale',

														'class' => 'form-check-input',

														'checked'=>$this->config->item('capture_internal_notes_during_sale')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_capture_internal_notes_during_sale')) ?></label>
                                        </div>
                                    </div>




                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'capture_sig_for_all_payments',
														'id'=>'capture_sig_for_all_payments',
														'value'=>'capture_sig_for_all_payments',
														'class' => 'form-check-input',

														'checked'=>$this->config->item('capture_sig_for_all_payments')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_capture_sig_for_all_payments')) ?></label>
                                        </div>
                                    </div>





                                </div>
                            </div>

                        </div>
                    </div>

















                    <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                        <?php echo form_label(lang('config_number_of_recent_sales').':', 'number_of_recent_sales',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10">

                            <?php echo form_dropdown('number_of_recent_sales', 
							 array(
								'10'=>'10',
								'20'=>'20',
								'50'=>'50',
								'100'=>'100',
								'200'=>'200',
								'500'=>'500'
								), $this->config->item('number_of_recent_sales') ? $this->config->item('number_of_recent_sales') : '10', 'class="form-control" id="number_of_recent_sales"');
								?>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'hide_customer_recent_sales',
														'id'=>'hide_customer_recent_sales',
														'class' => 'form-check-input',
														'value'=>'hide_customer_recent_sales',

														'checked'=>$this->config->item('hide_customer_recent_sales')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_hide_customer_recent_sales')) ?></label>
                                        </div>
                                    </div>



                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
															'name'=>'enable_customer_quick_add',
															'id'=>'enable_customer_quick_add',
															'class' => 'form-check-input',

															'value'=>'enable_customer_quick_add',

															'checked'=>$this->config->item('enable_customer_quick_add')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_enable_customer_quick_add')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
															'name'=>'enable_supplier_quick_add',
															'id'=>'enable_supplier_quick_add',
															'class' => 'form-check-input',

															'value'=>'enable_supplier_quick_add',

															'checked'=>$this->config->item('enable_supplier_quick_add')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_enable_supplier_quick_add')) ?></label>
                                        </div>
                                    </div>





                                </div>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'collapse_sales_ui_by_default',
														'id'=>'collapse_sales_ui_by_default',
														'class' => 'form-check-input',

														'value'=>'collapse_sales_ui_by_default',


														'checked'=>$this->config->item('collapse_sales_ui_by_default')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_collapse_sales_ui_by_default')) ?></label>
                                        </div>
                                    </div>



                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
													'name'=>'collapse_recv_ui_by_default',
													'class' => 'form-check-input',

													'id'=>'collapse_recv_ui_by_default',
													'value'=>'collapse_recv_ui_by_default',


													'checked'=>$this->config->item('collapse_recv_ui_by_default')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_collapse_recv_ui_by_default')) ?></label>
                                        </div>
                                    </div>





                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
													'name'=>'disable_confirmation_sale',
													'class' => 'form-check-input',

													'id'=>'disable_confirmation_sale',
													'value'=>'disable_confirmation_sale',


													'checked'=>$this->config->item('disable_confirmation_sale')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('disable_confirmation_sale')) ?></label>
                                        </div>
                                    </div>





                                </div>
                            </div>
                        </div>




                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'disable_confirm_recv',
														'class' => 'form-check-input',

														'id'=>'disable_confirm_recv',
														'value'=>'disable_confirm_recv',

														'checked'=>$this->config->item('disable_confirm_recv')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_disable_confirm_recv')) ?></label>
                                        </div>
                                    </div>



                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'disable_quick_complete_sale',
														'id'=>'disable_quick_complete_sale',
														'value'=>'disable_quick_complete_sale',

														'class' => 'form-check-input',

														'checked'=>$this->config->item('disable_quick_complete_sale')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('disable_quick_complete_sale')) ?></label>
                                        </div>
                                    </div>



                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'calculate_average_cost_price_from_receivings',
														'id'=>'calculate_average_cost_price_from_receivings',
														'value'=>'1',
														'class' => 'form-check-input',

														'checked'=>$this->config->item('calculate_average_cost_price_from_receivings')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_automatically_calculate_average_cost_price_from_receivings')) ?></label>
                                        </div>
                                    </div>





                                </div>
                            </div>

                        </div>

                    </div>



                    <!-- /////////////			 -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_dropdown('averaging_method', array('moving_average' => lang('config_moving_average'), 'historical_average' => lang('config_historical_average'), 'dont_average' => lang('config_dont_average_use_current_recv_price')), $this->config->item('averaging_method'),'class="form-control" id="averaging_method"'); ?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_averaging_method')) ?></label>
                                        </div>
                                    </div>




                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
															'name'=>'update_base_cost_price_from_units',
															'id'=>'update_base_cost_price_from_units',
															'class' => 'form-check-input',

															'value'=>'update_base_cost_price_from_units',

															'checked'=>$this->config->item('update_base_cost_price_from_units')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_update_base_cost_price_from_units')) ?></label>
                                        </div>
                                    </div>



                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
															'name'=>'update_cost_price_on_transfer',
															'id'=>'update_cost_price_on_transfer',
															'class' => 'form-check-input',

															'value'=>'1',


															'checked'=>$this->config->item('update_cost_price_on_transfer')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_update_cost_price_on_transfer')) ?></label>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'require_supplier_for_recv',
														'id'=>'require_supplier_for_recv',
														'class' => 'form-check-input',

														'value'=>'1',


														'checked'=>$this->config->item('require_supplier_for_recv')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_require_supplier_recv')) ?></label>
                                        </div>
                                    </div>



                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
													'name'=>'track_shipping_cost_recv',
													'class' => 'form-check-input',

													'id'=>'track_shipping_cost_recv',
													'value'=>'1',


													'checked'=>$this->config->item('track_shipping_cost_recv')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_track_shipping_cost_for_receivings')) ?></label>
                                        </div>
                                    </div>





                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
													'name'=>'hide_suspended_recv_in_reports',
													'class' => 'form-check-input',

													'id'=>'hide_suspended_recv_in_reports',
													'value'=>'1',


													'checked'=>$this->config->item('hide_suspended_recv_in_reports')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_hide_suspended_recv_in_reports')) ?></label>
                                        </div>
                                    </div>

                                    <?php if ($this->config->item('always_use_average_cost_method')) { ?>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
													'name'=>'always_use_average_cost_method',
													'class' => 'form-check-input',

													'id'=>'always_use_average_cost_method',
													'value'=>'1',


													'checked'=>$this->config->item('always_use_average_cost_method')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_always_use_average_cost_method')) ?></label>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <?php
										$track_payment_types = $this->config->item('track_payment_types') ? unserialize($this->config->item('track_payment_types')) : array();
										?>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
													'name'=>'track_payment_types[]',
													'class' => 'form-check-input',

													'id'=>'track_cash',
													'value'=>'common_cash',


													'checked'=>in_array('common_cash',$track_payment_types)));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_keyword_sales')) ?></label>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>






                    </div>








                    <div class="py-5 mb-5">
                        <div class="rounded border p-10">
                            <div class="mb-10">
                                <div class="form-check" data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                    <label class="form-check-label"
                                        for="flexCheckDefault"><?php echo form_label(lang('config_amount_of_cash_to_be_left_in_drawer_at_closing')) ?></label>
                                    <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
								'name'=>'amount_of_cash_to_be_left_in_drawer_at_closing',
								'id'=>'amount_of_cash_to_be_left_in_drawer_at_closing',
								'value'=>$this->config->item('amount_of_cash_to_be_left_in_drawer_at_closing')));?>

                                </div>
                            </div>
                            <div class="mb-0">
                                <div class="form-check" data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                    <label class="form-check-label"
                                        for="flexCheckChecked"><?php echo form_label(lang('config_cash_alert_high')) ?></label>
                                    <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
								'name'=>'cash_alert_high',
								'id'=>'cash_alert_high',
								'value'=>$this->config->item('cash_alert_high')));?>

                                </div>
                            </div>

                            <div class="mb-0">
                                <div class="form-check" data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                    <label class="form-check-label"
                                        for="flexCheckChecked"><?php echo form_label(lang('config_cash_alert_low')) ?></label>
                                    <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
								'name'=>'cash_alert_low',
								'id'=>'cash_alert_low',
								'value'=>$this->config->item('cash_alert_low')));?>

                                </div>
                            </div>
                        </div>
                    </div>





                    <!-- ////////////////////// check box starting -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'track_payment_types',
														'id'=>'track_check',
														'class' => 'form-check-input',
														'value'=>'common_check',
														'checked'=>in_array('common_check',$track_payment_types)));?>

                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('common_track_checks_in_register')) ?></label>
                                        </div>
                                    </div>




                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
															'name'=>'track_payment_types[]',
															'id'=>'track_giftcard',
															'class' => 'form-check-input',

															'value'=>'common_giftcard',
															'checked'=>in_array('common_giftcard',$track_payment_types)));?>

                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('common_track_giftcards_in_register')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
															'name'=>'track_payment_types[]',
															'id'=>'track_debit_cards',
															'class' => 'form-check-input',

															'value'=>'common_debit',
															'checked'=>in_array('common_debit',$track_payment_types)));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('common_track_debit_cards_in_register')) ?></label>
                                        </div>
                                    </div>





                                </div>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'track_payment_types[]',
														'id'=>'track_credit_cards',
														'class' => 'form-check-input',


														'value'=>'1',

														'checked'=>in_array('common_credit',$track_payment_types)));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('common_track_credit_cards_in_register')) ?></label>
                                        </div>
                                    </div>





                                    <?php
												foreach($this->Appconfig->get_additional_payment_types() as $additional_payment_type)
												{
												?>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
								'name'=>'track_payment_types[]',
								'class' => 'form-check-input',

								'id'=>'track_'.$additional_payment_type,
								'value'=> $additional_payment_type,
								'checked'=>in_array($additional_payment_type,$track_payment_types)));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('common_track')) ?></label>
                                        </div>
                                    </div>

                                    <?php
						}
						?>





                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
													'name'=>'do_not_show_closing',
													'class' => 'form-check-input',

													'id'=>'do_not_show_closing',
													'value'=>'1',

													'checked'=>$this->config->item('do_not_show_closing')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_keyword_sales')) ?></label>
                                        </div>
                                    </div>





                                </div>
                            </div>
                        </div>




                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'hide_available_giftcards',
														'class' => 'form-check-input',

														'id'=>'hide_available_giftcards',
														'value'=>'1',
														'checked'=>$this->config->item('hide_available_giftcards')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_keyword_sales')) ?></label>
                                        </div>
                                    </div>



                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'show_giftcards_even_if_0_balance',
														'id'=>'show_giftcards_even_if_0_balance',
														'value'=>'1',
														'class' => 'form-check-input',

														'checked'=>$this->config->item('show_giftcards_even_if_0_balance')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_show_giftcards_even_if_0_balance')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'disable_giftcard_detection',
														'id'=>'disable_giftcard_detection',
														'value'=>'1',
														'class' => 'form-check-input',

														'checked'=>$this->config->item('disable_giftcard_detection')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_disable_giftcard_detection')) ?></label>
                                        </div>
                                    </div>





                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'always_show_item_grid',
														'class' => 'form-check-input',

														'id'=>'always_show_item_grid',
														'value'=>'1',
														'checked'=>$this->config->item('always_show_item_grid')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_always_show_item_grid')) ?></label>
                                        </div>
                                    </div>



                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'hide_images_in_grid',
														'id'=>'hide_images_in_grid',
														'value'=>'1',
														'class' => 'form-check-input',

														'checked'=>$this->config->item('hide_images_in_grid')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_hide_images_in_grid')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">

                                            <?php echo form_checkbox(array(
														'name'=>'quick_variation_grid',
														'id'=>'quick_variation_grid',
														'value'=>'1',
														'class' => 'form-check-input',

														'checked'=>$this->config->item('quick_variation_grid')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_quick_variation_grid')) ?></label>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'hide_out_of_stock_grid',
														'class' => 'form-check-input',

														'id'=>'hide_out_of_stock_grid',
														'value'=>'1',
														'checked'=>$this->config->item('hide_out_of_stock_grid')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_hide_out_of_stock_grid')) ?></label>
                                        </div>
                                    </div>





                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_default_type_for_grid')) ?></label>
                                            <?php echo form_dropdown('default_type_for_grid', array(
									'categories'  => lang('reports_categories'), 
									'tags'  => lang('common_tags'),
									'class' => 'form-select form-select-solid',
									'suppliers'  => lang('common_suppliers'),
									'favorites'  => lang('common_favorite'),
								),
								$this->config->item('default_type_for_grid'), 'class="form-control" id="default_type_for_grid"');
								?>

                                        </div>
                                    </div>




                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'require_customer_for_sale',
														'class' => 'form-check-input',

														'id'=>'require_customer_for_sale',
														'value'=>'1',
														'checked'=>$this->config->item('require_customer_for_sale')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_require_customer_for_sale')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
														'name'=>'select_sales_person_during_sale',
														'class' => 'form-check-input',

														'id'=>'select_sales_person_during_sale',
														'value'=>'1',
														'checked'=>$this->config->item('select_sales_person_during_sale')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_select_sales_person_during_sale')) ?></label>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">


                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_default_sales_person')) ?></label>
                                            <?php echo form_dropdown('default_sales_person', array('logged_in_employee' => lang('common_logged_in_employee'), 'not_set' => lang('common_not_set')), $this->config->item('default_sales_person'),'class="form-select form-select-solid" id="default_sales_person"'); ?>

                                        </div>
                                    </div>




                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('common_commission_default_rate')) ?></label>
                                            <?php echo form_input(array(
											'name'=>'commission_default_rate',
											'id'=>'commission_default_rate',
											'class'=>'form-control form-control-solid',
											'value'=>$this->config->item('commission_default_rate')));?>

                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('common_commission_percent_calculation')) ?></label>
                                            <?php echo form_dropdown('commission_percent_type', array(
													'selling_price'  => lang('common_unit_price'),
													'profit'    => lang('common_profit'),
													'class' => 'form-select form-select-solid',
													),
													$this->config->item('commission_percent_type'),
													array('id' => 'commission_percent_type', 'class' => 'form-select form-select-solid'))
													?>

                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10 ">
                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'disable_sale_notifications',
											'id'=>'disable_sale_notifications',
											'value'=>'1',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('disable_sale_notifications')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_disable_sale_notifications')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'confirm_error_adding_item',
											'id'=>'confirm_error_adding_item',
											'value'=>'1',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('confirm_error_adding_item')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_confirm_error_messages_modal')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'change_sale_date_for_new_sale',
											'id'=>'change_sale_date_for_new_sale',
											'value'=>'1',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('change_sale_date_for_new_sale')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_change_sale_date_for_new_sale')) ?></label>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10 ">
                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'do_not_group_same_items',
											'id'=>'do_not_group_same_items',
											'value'=>'1',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('do_not_group_same_items')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_do_not_group_same_items')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'do_not_allow_below_cost',
											'id'=>'do_not_allow_below_cost',
											'value'=>'1',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('do_not_allow_below_cost')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_do_not_allow_below_cost')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'do_not_allow_out_of_stock_items_to_be_sold',
											'id'=>'do_not_allow_out_of_stock_items_to_be_sold',
											'value'=>'do_not_allow_out_of_stock_items_to_be_sold',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('do_not_allow_out_of_stock_items_to_be_sold')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_do_not_allow_out_of_stock_items_to_be_sold')) ?></label>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10 ">
                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'do_not_allow_items_to_go_out_of_stock_when_transfering',
											'id'=>'do_not_allow_items_to_go_out_of_stock_when_transfering',
											'value'=>'do_not_allow_items_to_go_out_of_stock_when_transfering',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('do_not_allow_items_to_go_out_of_stock_when_transfering')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_do_not_allow_items_to_go_out_of_stock_when_transfering')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'do_not_allow_item_with_variations_to_be_sold_without_selecting_variation',
											'id'=>'do_not_allow_item_with_variations_to_be_sold_without_selecting_variation',
											'value'=>'do_not_allow_item_with_variations_to_be_sold_without_selecting_variation',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('do_not_allow_item_with_variations_to_be_sold_without_selecting_variation')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_do_not_allow_item_with_variations_to_be_sold_without_selecting_variation')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'edit_item_price_if_zero_after_adding',
											'id'=>'edit_item_price_if_zero_after_adding',
											'value'=>'edit_item_price_if_zero_after_adding',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('edit_item_price_if_zero_after_adding')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_edit_item_price_if_zero_after_adding')) ?></label>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10 ">
                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'remind_customer_facing_display',
											'id'=>'remind_customer_facing_display',
											'value'=>'remind_customer_facing_display',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('remind_customer_facing_display')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('configremind_customer_facing_display')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'do_not_allow_sales_with_zero_value',
											'id'=>'do_not_allow_sales_with_zero_value',
											'value'=>'do_not_allow_sales_with_zero_value',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('do_not_allow_sales_with_zero_value')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_do_not_allow_sales_with_zero_value')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'prompt_amount_for_cash_sale',
											'id'=>'prompt_amount_for_cash_sale',
											'value'=>'prompt_amount_for_cash_sale',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('prompt_amount_for_cash_sale')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_prompt_amount_for_cash_sale')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'prompt_amount_for_cash_sale',
											'id'=>'prompt_amount_for_cash_sale',
											'value'=>'prompt_amount_for_cash_sale',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('prompt_amount_for_cash_sale')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_prompt_amount_for_cash_sale')) ?></label>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10 ">
                                    <div class="mb-0">
                                        <div class="form-check">
                                            <?php echo form_checkbox(array(
											'name'=>'show_qr_code_for_sale',
											'id'=>'show_qr_code_for_sale',
											'value'=>'show_qr_code_for_sale',
											'class' => 'form-check-input',
											'checked'=>$this->config->item('show_qr_code_for_sale')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_show_qr_code_for_sale')) ?></label>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>






                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-4">
                                    <div class="mb-8">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_qr_code_format'))?></label>

                                            <?php echo form_dropdown('qr_code_format', array(
									'link_to_receipt' => lang('config_link_to_receipt'),
									'sale_summary_info' => lang('config_sale_summary_info'),
									'saudi_arabia_digital_receipt' => lang('config_saudi_arabia_digital_receipt'),
								),
								$this->config->item('qr_code_format'),
								array('id' => 'qr_code_format', 'class' => 'form-select form-select-solid'))
								?>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'disable_verification_for_qr_codes',
										'id'=>'disable_verification_for_qr_codes',
										'class' => 'form-check-input',
										'value'=>'disable_verification_for_qr_codes',
										'checked'=>$this->config->item('disable_verification_for_qr_codes')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_disable_verification_for_qr_codes')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
											'name'=>'hide_categories_sales_grid',
											'id'=>'hide_categories_sales_grid',
											'class' => 'form-check-input',
											'value'=>'hide_categories_sales_grid',
											'checked'=>$this->config->item('hide_categories_sales_grid')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_categories_sales_grid')) ?></label>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">

                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
											'name'=>'hide_tags_sales_grid',
											'id'=>'hide_tags_sales_grid',
											'class' => 'form-check-input',
											'value'=>'hide_tags_sales_grid',
											'checked'=>$this->config->item('hide_tags_sales_grid')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_tags_sales_grid')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'hide_suppliers_sales_grid',
										'id'=>'hide_suppliers_sales_grid',
										'class' => 'form-check-input',
										'value'=>'hide_suppliers_sales_grid',
										'checked'=>$this->config->item('hide_suppliers_sales_grid')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_suppliers_sales_grid')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'hide_favorites_sales_grid',
										'id'=>'hide_favorites_sales_grid',
										'class' => 'form-check-input',
										'value'=>'hide_favorites_sales_grid',
										'checked'=>$this->config->item('hide_favorites_sales_grid')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_favorites_sales_grid')) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- ////// -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-4">
                                    <div class="mb-8">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_number_of_decimals_displayed_on_sales_interface'))?></label>

                                            <?php echo form_dropdown('number_of_decimals_displayed_on_sales_interface', array(
			 							''  => lang('config_let_system_decide'),
			 							'0'    => '0',
			 							'1'    => '1',
			 							'2'    => '2',
			 							'3'    => '3',
			 							'4'    => '4',
			 							'5'    => '5',
			 							'6'    => '6',
			 							'7'    => '7',
			 							'8'    => '8',
			 							'9'    => '9',
			 							'10'    => '10',
									),$this->config->item('number_of_decimals_displayed_on_sales_interface')
			 							 , 'class="form-select form-select-solid" id="number_of_decimals_displayed_on_sales_interface"');
									?>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'do_not_allow_edit_of_overall_subtotal',
										'id'=>'do_not_allow_edit_of_overall_subtotal',
										'class' => 'form-check-input',
										'value'=>'do_not_allow_edit_of_overall_subtotal',
										'checked'=>$this->config->item('do_not_allow_edit_of_overall_subtotal')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_do_not_allow_edit_of_overall_subtotal')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
											'name'=>'disable_supplier_selection_on_sales_interface',
											'id'=>'disable_supplier_selection_on_sales_interface',
											'class' => 'form-check-input',
											'value'=>'1',
											'checked'=>$this->config->item('disable_supplier_selection_on_sales_interface')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_disable_supplier_selection_on_sales_interface')) ?></label>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">

                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                                            <?php echo form_checkbox(array(
											'name'=>'create_work_order_for_customer',
											'id'=>'create_work_order_for_customer',
											'class' => 'form-check-input',
											'value'=>'1',
											'checked'=>$this->config->item('create_work_order_for_customer')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_create_work_order_for_customer')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_create_work_order_is_checked_by_default_for_sale')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'create_work_order_is_checked_by_default_for_sale',
										'id'=>'create_work_order_is_checked_by_default_for_sale',
										'class' => 'form-check-input',
										'value'=>'1',
										'checked'=>$this->config->item('create_work_order_is_checked_by_default_for_sale')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_create_work_order_is_checked_by_default_for_sale')) ?></label>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->



                
                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> <?php echo create_section(lang('config_suspended_sales_layaways_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_suspended_sales_layaways_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                            
                    <div class="form-group no-padding-right"
                        data-keyword="<?php echo H(lang('config_keyword_suspended_layaways')) ?>">
                        <?php echo form_label(lang('config_additional_suspend_types').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="col-md-9 col-sm-9 col-lg-10">
                            <div class="table-responsive">
                                <table id="sale_types" class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('config_sort'); ?></th>
                                            <th><?php echo lang('common_id'); ?></th>
                                            <th><?php echo lang('common_suspended_sale_type'); ?></th>
                                            <th><?php echo lang('config_remove_quantity_suspending'); ?></th>
                                            <th><?php echo lang('common_delete'); ?></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach($sale_types->result() as $sale_type) { ?>
                                        <tr>
                                            <td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td>
                                            <td><?php echo $sale_type->id; ?></td>
                                            <td><input type="text" data-index="<?php echo $sale_type->id; ?>"
                                                    class="sale_types_to_edit form-control form-control-solid"
                                                    name="sale_types_to_edit[<?php echo $sale_type->id; ?>][name]"
                                                    value="<?php echo H($sale_type->name); ?>" /></td>

                                            <td class="text-center">
                                                <?php echo form_checkbox(array(
													'name'=>'sale_types_to_edit['.$sale_type->id.'][remove_quantity]',
													'id'=>'remove_quantity_'.$sale_type->id,
													'class' => 'form-check-input',
													'value'=>'1',
													'data-index' => $sale_type->id,
	 												'checked'=>$sale_type->remove_quantity));?>
                                                <label
                                                    for="remove_quantity_<?php echo $sale_type->id;?>"><span></span></label>
                                            </td>

                                            <td><a class="delete_sale_type btn btn-danger btn-sm"
                                                    href="javascript:void(0);"
                                                    data-sale-type-id='<?php echo $sale_type->id; ?>'><?php echo lang('common_delete'); ?></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <a href="javascript:void(0);" class="btn btn-info btn-sm"
                                    id="add_sale_type"><?php echo lang('config_add_suspended_sale_type'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-20">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_suspended_layaways')) ?>">
                                            <?php echo form_checkbox(array(
													'name'=>'require_customer_for_suspended_sale',
													'id'=>'require_customer_for_suspended_sale',
													'value'=>'1',
													'class' => 'form-check-input',
													'checked'=>$this->config->item('require_customer_for_suspended_sale')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_require_customer_for_suspended_sale')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_suspended_layaways')) ?>">
                                            <?php echo form_checkbox(array(
													'name'=>'dont_recalculate_cost_price_when_unsuspending_estimates',
													'id'=>'dont_recalculate_cost_price_when_unsuspending_estimates',
													'value'=>'1',
													'class' => 'form-check-input',
													'checked'=>$this->config->item('dont_recalculate_cost_price_when_unsuspending_estimates')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_dont_recalculate_cost_price_when_unsuspending_estimates')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-12">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_suspended_layaways')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_user_configured_layaway_name')) ?></label>
                                            <?php echo form_input(array(
												'class'=>'form-control form-control-solid form-inps',
											'name'=>'user_configured_layaway_name',
											'id'=>'user_configured_layaway_name',
											'value'=>$this->config->item('user_configured_layaway_name')));?>

                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_suspended_layaways')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_user_configured_layaway_name')) ?></label>
                                            <?php echo form_input(array(
												'class'=>'form-control form-control-solid form-inps',
											'name'=>'user_configured_layaway_name',
											'id'=>'user_configured_layaway_name',
											'value'=>$this->config->item('user_configured_layaway_name')));?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_suspended_layaways')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_override_estimate_name')) ?></label>

                                        <?php echo form_input(array(
															'class'=>'form-control form-control-solid form-inps',
														'name'=>'user_configured_estimate_name',
														'id'=>'user_configured_estimate_name',
														'value'=>$this->config->item('user_configured_estimate_name')));?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-20">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_suspended_layaways')) ?>">
                                            <?php echo form_checkbox(array(
													'name'=>'user_configured_estimate_name',
													'id'=>'user_configured_estimate_name',
													'value'=>'user_configured_estimate_name',
													'class' => 'form-check-input',
													'checked'=>$this->config->item('user_configured_estimate_name')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_override_estimate_name')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_suspended_layaways')) ?>">
                                            <?php echo form_checkbox(array(
													'name'=>'hide_layaways_sales_in_reports',
													'id'=>'hide_layaways_sales_in_reports',
													'value'=>'hide_layaways_sales_in_reports',
													'class' => 'form-check-input',
													'checked'=>$this->config->item('hide_layaways_sales_in_reports')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_hide_layaways_sales_in_reports')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_suspended_layaways')) ?>">
                                            <?php echo form_checkbox(array(
													'name'=>'show_receipt_after_suspending_sale',
													'id'=>'show_receipt_after_suspending_sale',
													'value'=>'show_receipt_after_suspending_sale',
													'class' => 'form-check-input',
													'checked'=>$this->config->item('show_receipt_after_suspending_sale')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_show_receipt_after_suspending_sale')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-12">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_suspended_layaways')) ?>">
                                            <?php echo form_checkbox(array(
													'name'=>'change_sale_date_when_suspending',
													'id'=>'change_sale_date_when_suspending',
													'value'=>'change_sale_date_when_suspending',
													'class' => 'form-check-input',
													'checked'=>$this->config->item('change_sale_date_when_suspending')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('common_hide_layaways_sales_in_reports')) ?></label>
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_suspended_layaways')) ?>">
                                            <?php echo form_checkbox(array(
													'name'=>'change_sale_date_when_completing_suspended_sale',
													'id'=>'change_sale_date_when_completing_suspended_sale',
													'value'=>'change_sale_date_when_completing_suspended_sale',
													'class' => 'form-check-input',
													'checked'=>$this->config->item('change_sale_date_when_completing_suspended_sale')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_change_sale_date_when_completing_suspended_sale')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>








                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_suspended_layaways')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_layaway_statement_message'))?></label>

                                        <?php echo form_textarea(array(
														'name'=>'layaway_statement_message',
														'id'=>'layaway_statement_message',
														'class'=>'form-control form-control-solid text-area',
														'rows'=>'4',
														'cols'=>'30',
														'value'=>$this->config->item('layaway_statement_message')));?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">  <?php echo create_section(lang('config_receipt_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_receipt_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                        <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_override_receipt_title')) ?></label>

                                            <?php echo form_input(array(
												'class'=>'form-control form-control-solid form-inps',
												'name'=>'override_receipt_title',
												'id'=>'override_receipt_title',
												'value'=>$this->config->item('override_receipt_title')));?>

                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_emailed_receipt_subject')) ?></label>
                                            <?php echo form_input(array(
												'class'=>'form-control form-control-solid form-inps',

												'name'=>'emailed_receipt_subject',
												'id'=>'emailed_receipt_subject',
												'placeholder' => lang('sales_receipt'),
												'value'=>$this->config->item('emailed_receipt_subject')));?>

                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_override_employee_label_on_receipt')) ?></label>
                                            <?php echo form_input(array(
												'class'=>'form-control form-control-solid form-inps',

												'name'=>'override_employee_label_on_receipt',
												'id'=>'override_employee_label_on_receipt',
												'value'=>$this->config->item('override_employee_label_on_receipt')));?>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'show_item_id_on_receipt',
								'id'=>'show_item_id_on_receipt',
								'class' => 'form-check-input',
								'value'=>'show_item_id_on_receipt',
								'checked'=>$this->config->item('show_item_id_on_receipt')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_show_item_id_on_receipt')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'class' => 'form-check-input',

								'name'=>'show_images_on_receipt',
								'id'=>'show_images_on_receipt',
								'value'=>'show_images_on_receipt',
								'checked'=>$this->config->item('show_images_on_receipt')));?>
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_show_images_on_receipt')) ?></label>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>











                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_show_images_on_receipt_width_percent')) ?></label>

                                        <?php 
								echo form_dropdown('show_images_on_receipt_width_percent', array(
		 								'1'    => '1%',
		 								'2'    => '2%',
		 								'3'    => '3%',
		 								'4'    => '4%',
		 								'5'    => '5%',
			 							'10'    => '10%',
			 							'15'    => '15%',
			 							'20'    => '20%',
			 							'25'    => '25%',
			 							'30'    => '30%',
			 							'35'    => '35%',
			 							'40'    => '40%',
			 							'45'    => '45%',
			 							'50'    => '50%',
			 							'55'    => '55%',
			 							'60'    => '60%',
			 							'65'    => '65%',
			 							'70'    => '70%',
			 							'75'    => '75%',
			 							'80'    => '80%',
			 							'85'    => '85%',
			 							'90'    => '90%',
			 							'95'    => '95%',
			 							'100'    => '100%',
									),
									$this->config->item('show_images_on_receipt_width_percent')?$this->config->item('show_images_on_receipt_width_percent'):25, 'class="form-select form-select-solid" id="show_images_on_receipt_width_percent"');
								?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">


                                            <?php echo form_checkbox(array(
								'name'=>'show_person_id_on_receipt',
								'id'=>'show_person_id_on_receipt',
								'class' => 'form-check-input',

								'value'=>'1',
								'checked'=>$this->config->item('show_person_id_on_receipt')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_show_person_id_on_receipt')) ?></label>

                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">


                                            <?php echo form_checkbox(array(
								'name'=>'show_tags_on_fulfillment_sheet',
								'id'=>'show_tags_on_fulfillment_sheet',
								'class' => 'form-check-input',

								'value'=>'show_tags_on_fulfillment_sheet',
								'checked'=>$this->config->item('show_tags_on_fulfillment_sheet')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_show_tags_on_fulfillment_sheet')) ?></label>

                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">


                                            <?php echo form_checkbox(array(
								'name'=>'show_total_on_fulfillment',
								'id'=>'show_total_on_fulfillment',
								'class' => 'form-check-input',

								'value'=>'show_total_on_fulfillment',
								'checked'=>$this->config->item('show_total_on_fulfillment')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_show_total_on_fulfillment')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'taxes_summary_on_receipt',
								'id'=>'taxes_summary_on_receipt',
								'class' => 'form-check-input',
								'value'=>'taxes_summary_on_receipt',
								'checked'=>$this->config->item('taxes_summary_on_receipt')));?>
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_taxes_summary_on_receipt')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>"
                                            <?php echo $this->config->item('taxes_summary_on_receipt')?"":"style='display:none;'" ?>
                                            id="override_symbol_taxable_summary_container">
                                            <label class="form-check-label"
                                                for="flexCheckChecked"><?php echo form_label(lang('config_override_symbol_taxable_summary')) ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-inps',
									'name'=>'override_symbol_taxable_summary',
									'id'=>'override_symbol_taxable_summary',
									'value'=>$this->config->item('override_symbol_taxable_summary')));?>

                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_override_symbol_non_taxable_summary')) ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'override_symbol_non_taxable_summary',
									'id'=>'override_symbol_non_taxable_summary',
									'value'=>$this->config->item('override_symbol_non_taxable_summary')));?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>






                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                        <?php echo form_checkbox(array(
								'name'=>'taxes_summary_details_on_receipt',
								'id'=>'taxes_summary_details_on_receipt',
								'class' => 'form-check-input',

								'value'=>'taxes_summary_details_on_receipt',
								'checked'=>$this->config->item('taxes_summary_details_on_receipt')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_taxes_summary_details_on_receipt')) ?></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>





                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_second_language')) ?></label>
                                        <?php echo form_dropdown('second_language', array(
								''  => lang('common_none'),
								'english'  => 'English',
								'indonesia'    => 'Indonesia',
								'spanish'   => 'Español', 
								'french'    => 'Fançais',
								'italian'    => 'Italiano',
								'german'    => 'Deutsch',
								'dutch'    => 'Nederlands',
								'portugues'    => 'Portugues',
								'arabic' => 'العَرَبِيةُ‎‎',
								'khmer' => 'Khmer',
								'vietnamese' => 'Vietnamese',
								'chinese' => '中文',
								'chinese_traditional' => '繁體中文',
								'tamil' => 'Tamil',
								),
								$this->config->item('second_language'), 'class="form-select form-select-solid" id="second_language"');
								?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'uppercase_receipts',
								'id'=>'uppercase_receipts',
								'class' => 'form-check-input',

								'value'=>'uppercase_receipts',
								'checked'=>$this->config->item('uppercase_receipts')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_uppercase_receipts')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'show_item_kit_items_on_receipt',
								'id'=>'show_item_kit_items_on_receipt',
								'class' => 'form-check-input',

								'value'=>'show_item_kit_items_on_receipt',
								'checked'=>$this->config->item('show_item_kit_items_on_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_show_item_kit_items_on_receipt')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'show_total_discount_on_receipt',
								'id'=>'show_total_discount_on_receipt',
								'class' => 'form-check-input',

								'value'=>'show_total_discount_on_receipt',
								'checked'=>$this->config->item('show_total_discount_on_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_show_total_discount_on_receipt')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'hide_prices_on_fill_sheet',
								'id'=>'hide_prices_on_fill_sheet',
								'class' => 'form-check-input',

								'value'=>'hide_prices_on_fill_sheet',
								'checked'=>$this->config->item('hide_prices_on_fill_sheet')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_prices_on_fill_sheet')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'show_item_id_on_recv_receipt',
								'id'=>'show_item_id_on_recv_receipt',
								'class' => 'form-check-input',

								'value'=>'show_item_id_on_recv_receipt',
								'checked'=>$this->config->item('show_item_id_on_recv_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_show_item_id_on_recv_receipt')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'hide_all_prices_on_recv',
								'id'=>'hide_all_prices_on_recv',
								'class' => 'form-check-input',

								'value'=>'hide_all_prices_on_recv',
								'checked'=>$this->config->item('hide_all_prices_on_recv')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_all_prices_on_recv')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>










                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_number_of_decimals_for_quantity_on_receipt')) ?></label>
                                        <?php echo form_dropdown('number_of_decimals_for_quantity_on_receipt', array(
			 							''  => lang('config_let_system_decide'),
			 							'0'    => '0',
			 							'1'    => '1',
			 							'2'    => '2',
			 							'3'    => '3',
			 							'4'    => '4',
			 							'5'    => '5',
			 							'6'    => '6',
			 							'7'    => '7',
			 							'8'    => '8',
			 							'9'    => '9',
			 							'10'    => '10',
									),$this->config->item('number_of_decimals_for_quantity_on_receipt')
			 							 , 'class="form-select form-select-solid" id="number_of_decimals_for_quantity_on_receipt"');
									?>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>





                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'indicate_taxable_on_receipt',
								'id'=>'indicate_taxable_on_receipt',
								'class' => 'form-check-input',

								'value'=>'indicate_taxable_on_receipt',
								'checked'=>$this->config->item('indicate_taxable_on_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('common_indicate_taxable_on_receipt')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'indicate_non_taxable_on_receipt',
								'id'=>'indicate_non_taxable_on_receipt',
								'class' => 'form-check-input',

								'value'=>'indicate_non_taxable_on_receipt',
								'checked'=>$this->config->item('indicate_non_taxable_on_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('common_indicate_non_taxable_on_receipt')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>"
                                            <?php echo $this->config->item('indicate_non_taxable_on_receipt')?"":"style='display:none;'" ?>
                                            id="override_symbol_non_taxable_container">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_override_symbol_non_taxable')) ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'override_symbol_non_taxable',
									'id'=>'override_symbol_non_taxable',
									'value'=>$this->config->item('override_symbol_non_taxable')));?>

                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'show_tax_per_item_on_receipt',
								'id'=>'show_tax_per_item_on_receipt',
								'class' => 'form-check-input',

								'value'=>'show_tax_per_item_on_receipt',
								'checked'=>$this->config->item('show_tax_per_item_on_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_show_tax_per_item_on_receipt')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'hide_merchant_id_from_receipt',
								'id'=>'hide_merchant_id_from_receipt',
								'class' => 'form-check-input',

								'value'=>'hide_merchant_id_from_receipt',
								'checked'=>$this->config->item('hide_merchant_id_from_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_merchant_id_from_receipt')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'hide_desc_emailed_receipts',
								'id'=>'hide_desc_emailed_receipts',
								'class' => 'form-check-input',

								'value'=>'hide_desc_emailed_receipts',
								'checked'=>$this->config->item('hide_desc_emailed_receipts')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_desc_emailed_receipts')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'hide_description_on_sales_and_recv',
								'id'=>'hide_description_on_sales_and_recv',
								'class' => 'form-check-input',

								'value'=>'hide_description_on_sales_and_recv',
								'checked'=>$this->config->item('hide_description_on_sales_and_recv')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_description_on_sales_and_recv')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'hide_description_on_suspended_sales',
								'id'=>'hide_description_on_suspended_sales',
								'class' => 'form-check-input',

								'value'=>'hide_description_on_suspended_sales',
								'checked'=>$this->config->item('hide_description_on_suspended_sales')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_description_on_suspended_sales')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'show_orig_price_if_marked_down_on_receipt',
								'id'=>'show_orig_price_if_marked_down_on_receipt',
								'class' => 'form-check-input',

								'value'=>'show_orig_price_if_marked_down_on_receipt',
								'checked'=>$this->config->item('show_orig_price_if_marked_down_on_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_show_orig_price_if_marked_down_on_receipt')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'print_after_sale',
								'id'=>'print_after_sale',
								'class' => 'form-check-input',

								'value'=>'print_after_sale',
								'checked'=>$this->config->item('print_after_sale')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_print_after_sale')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'wide_printer_receipt_format',
								'id'=>'wide_printer_receipt_format',
								'class' => 'form-check-input',

								'value'=>'wide_printer_receipt_format',
								'checked'=>$this->config->item('wide_printer_receipt_format')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_wide_printer_receipt_format')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'print_after_receiving',
								'id'=>'print_after_receiving',
								'class' => 'form-check-input',

								'value'=>'print_after_receiving',
								'checked'=>$this->config->item('print_after_receiving')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_print_after_receiving')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'hide_signature',
								'id'=>'hide_signature',
								'class' => 'form-check-input',

								'value'=>'hide_signature',
								'checked'=>$this->config->item('hide_signature')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_signature')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'disable_signature_capture_on_terminal_for_phppos_credit_card_processing',
								'id'=>'disable_signature_capture_on_terminal_for_phppos_credit_card_processing',
								'class' => 'form-check-input',

								'value'=>'disable_signature_capture_on_terminal_for_phppos_credit_card_processing',
								'checked'=>$this->config->item('disable_signature_capture_on_terminal_for_phppos_credit_card_processing')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_disable_signature_capture_on_terminal_for_phppos_credit_card_processing')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'auto_capture_signature',
								'id'=>'auto_capture_signature',
								'class' => 'form-check-input',

								'value'=>'auto_capture_signature',
								'checked'=>$this->config->item('auto_capture_signature')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_auto_capture_signature')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'remove_customer_name_from_receipt',
								'id'=>'remove_customer_name_from_receipt',
								'class' => 'form-check-input',

								'value'=>'remove_customer_name_from_receipt',
								'checked'=>$this->config->item('remove_customer_name_from_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_remove_customer_name_from_receipt')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'remove_customer_name_from_receipt',
								'id'=>'remove_customer_name_from_receipt',
								'class' => 'form-check-input',

								'value'=>'remove_customer_name_from_receipt',
								'checked'=>$this->config->item('remove_customer_name_from_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_remove_customer_name_from_receipt')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'remove_employee_lastname_from_receipt',
								'id'=>'remove_employee_lastname_from_receipt',
								'class' => 'form-check-input',

								'value'=>'remove_employee_lastname_from_receipt',
								'checked'=>$this->config->item('remove_employee_lastname_from_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_remove_employee_lastname_from_receipt')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>




                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'remove_employee_from_receipt',
								'id'=>'remove_employee_from_receipt',
								'class' => 'form-check-input',

								'value'=>'remove_employee_from_receipt',
								'checked'=>$this->config->item('remove_employee_from_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_remove_employee_from_receipt')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'remove_customer_company_from_receipt',
								'id'=>'remove_customer_company_from_receipt',
								'class' => 'form-check-input',

								'value'=>'remove_customer_company_from_receipt',
								'checked'=>$this->config->item('remove_customer_company_from_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_remove_customer_company_from_receipt')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'remove_customer_contact_info_from_receipt',
								'id'=>'remove_customer_contact_info_from_receipt',
								'class' => 'form-check-input',

								'value'=>'remove_customer_contact_info_from_receipt',
								'checked'=>$this->config->item('remove_customer_contact_info_from_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_remove_customer_contact_info_from_receipt')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'hide_email_on_receipts',
								'id'=>'hide_email_on_receipts',
								'class' => 'form-check-input',

								'value'=>'hide_email_on_receipts',
								'checked'=>$this->config->item('hide_email_on_receipts')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_email_on_receipts')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>








                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_sort_receipt_column')) ?></label>
                                        <?php echo form_dropdown('sort_receipt_column', array(
									''   => lang('common_none'),
									'name'   => lang('common_item_name'),
									'item_number'  => lang('common_item_number_expanded'),
									'product_id'    => lang('common_product_id'),
									),
									$this->config->item('sort_receipt_column'), 'class="form-control form-select-solid" id="sort_receipt_column"')
									?>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'automatically_email_receipt',
								'id'=>'automatically_email_receipt',
								'class' => 'form-check-input',

								'value'=>'automatically_email_receipt',
								'checked'=>$this->config->item('automatically_email_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_automatically_email_receipt')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'automatically_sms_receipt',
								'id'=>'automatically_sms_receipt',
								'class' => 'form-check-input',

								'value'=>'automatically_sms_receipt',
								'checked'=>$this->config->item('automatically_sms_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_automatically_sms_receipt')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'automatically_print_duplicate_receipt_for_cc_transactions',
								'id'=>'automatically_print_duplicate_receipt_for_cc_transactions',
								'class' => 'form-check-input',

								'value'=>'automatically_print_duplicate_receipt_for_cc_transactions',
								'checked'=>$this->config->item('automatically_print_duplicate_receipt_for_cc_transactions')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_automatically_print_duplicate_receipt_for_cc_transactions')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'always_print_duplicate_receipt_all',
								'id'=>'always_print_duplicate_receipt_all',
								'class' => 'form-check-input',

								'value'=>'always_print_duplicate_receipt_all',
								'checked'=>$this->config->item('always_print_duplicate_receipt_all')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_always_print_duplicate_receipt_all')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'automatically_show_comments_on_receipt',
								'id'=>'automatically_show_comments_on_receipt',
								'class' => 'form-check-input',

								'value'=>'automatically_show_comments_on_receipt',
								'checked'=>$this->config->item('automatically_show_comments_on_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_automatically_show_comments_on_receipt')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'hide_barcode_on_sales_and_recv_receipt',
								'id'=>'hide_barcode_on_sales_and_recv_receipt',
								'class' => 'form-check-input',

								'value'=>'hide_barcode_on_sales_and_recv_receipt',
								'checked'=>$this->config->item('hide_barcode_on_sales_and_recv_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_barcode_on_sales_and_recv_receipt')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'group_all_taxes_on_receipt',
								'id'=>'group_all_taxes_on_receipt',
								'class' => 'form-check-input',

								'value'=>'1',
								'checked'=>$this->config->item('group_all_taxes_on_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_group_all_taxes_on_receipt')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'redirect_to_sale_or_recv_screen_after_printing_receipt',
								'id'=>'redirect_to_sale_or_recv_screen_after_printing_receipt',
								'class' => 'form-check-input',

								'value'=>'1',
								'checked'=>$this->config->item('redirect_to_sale_or_recv_screen_after_printing_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_redirect_to_sale_or_recv_screen_after_printing_receipt')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>







                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_receipt_text_size')) ?></label>
                                        <?php echo form_dropdown('receipt_text_size', $receipt_text_size_options, $this->config->item('receipt_text_size'),'class="form-select form-select-solid" id="receipt_text_size"'); ?>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'hide_store_account_balance_on_receipt',
								'id'=>'hide_store_account_balance_on_receipt',
								'class' => 'form-check-input',

								'value'=>'1',
								'checked'=>$this->config->item('hide_store_account_balance_on_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_store_account_balance_on_receipt')) ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'round_cash_on_sales',
								'id'=>'round_cash_on_sales',
								'class' => 'form-check-input',

								'value'=>'round_cash_on_sales',
								'checked'=>$this->config->item('round_cash_on_sales')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_round_cash_on_sales')) ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('common_return_policy')) ?></label>

                                            <?php echo form_textarea(array(
								'name'=>'return_policy',
								'id'=>'return_policy',
								'class'=>'form-control form-control-solid text-area',
								'rows'=>'4',
								'cols'=>'30',
								'value'=>$this->config->item('return_policy')));?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('common_announcement_special')) ?></label>

                                            <?php echo form_textarea(array(
								'name'=>'announcement_special',
								'id'=>'announcement_special',
								'class'=>'form-control form-control-solid text-area',
								'rows'=>'4',
								'cols'=>'30',
								'value'=>$this->config->item('announcement_special')));?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'enable_pdf_receipts',
								'id'=>'enable_pdf_receipts',
								'class' => 'form-check-input',

								'value'=>'enable_pdf_receipts',
								'checked'=>$this->config->item('enable_pdf_receipts')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_enable_pdf_receipts')) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_pdf_receipt_message')) ?></label>

                                            <?php echo form_textarea(array(
								'name'=>'pdf_receipt_message',
								'id'=>'pdf_receipt_message',
								'class'=>'form-control form-control-solid text-area',
								'rows'=>'4',
								'cols'=>'30',
								'value'=>$this->config->item('pdf_receipt_message')));?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
								'name'=>'show_signature_on_receiving_receipt',
								'id'=>'show_signature_on_receiving_receipt',
								'class' => 'form-check-input',

								'value'=>'show_signature_on_receiving_receipt',
								'checked'=>$this->config->item('show_signature_on_receiving_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_show_signature_on_receiving_receipt')) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <label class="form-check-label"
                                                for="flexCheckDefault"><?php echo form_label(lang('config_override_signature_text')) ?></label>

                                            <?php echo form_textarea(array(
								'name'=>'override_signature_text',
								'id'=>'override_signature_text',
								'class'=>'form-control form-control-solid text-area',
								'rows'=>'4',
								'cols'=>'30',
								'value'=>$this->config->item('override_signature_text')));?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
											'name'=>'hide_categories_receivings_grid',
											'id'=>'hide_categories_receivings_grid',
											'class' => 'form-check-input',

											'value'=>'hide_categories_receivings_grid',
											'checked'=>$this->config->item('hide_categories_receivings_grid')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_categories_receivings_grid')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
											'name'=>'hide_tags_receivings_grid',
											'id'=>'hide_tags_receivings_grid',
											'class' => 'form-check-input',

											'value'=>'hide_tags_receivings_grid',
											'checked'=>$this->config->item('hide_tags_receivings_grid')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_tags_receivings_grid')) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">


                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
											'name'=>'hide_suppliers_receivings_grid',
											'id'=>'hide_suppliers_receivings_grid',
											'class' => 'form-check-input',

											'value'=>'hide_suppliers_receivings_grid',
											'checked'=>$this->config->item('hide_suppliers_receivings_grid')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_suppliers_receivings_grid')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
											'name'=>'hide_favorites_receivings_grid',
											'id'=>'hide_favorites_receivings_grid',
											'class' => 'form-check-input',

											'value'=>'hide_favorites_receivings_grid',
											'checked'=>$this->config->item('hide_favorites_receivings_grid')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_favorites_receivings_grid')) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                        <label class="form-check-label"
                                            for="flexCheckDefault"><?php echo form_label(lang('config_receipt_download_filename_prefix')) ?></label>

                                        <?php echo form_input(array(
											'class'=>'form-control form-control-solid form-inps',
											'name'=>'receipt_download_filename_prefix',
											'id'=>'receipt_download_filename_prefix',
											'size'=> 40,
											'value'=>$this->config->item('receipt_download_filename_prefix')));?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
					'name'=>'capture_internal_notes_during_receiving',
					'id'=>'capture_internal_notes_during_receiving',
					'class' => 'form-check-input',

					'value'=>'capture_internal_notes_during_receiving',
					'checked'=>$this->config->item('capture_internal_notes_during_receiving')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_capture_internal_notes_during_receiving')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
					'name'=>'disable_variation_popup_in_receivings',
					'id'=>'disable_variation_popup_in_receivings',
					'class' => 'form-check-input',

					'value'=>'disable_variation_popup_in_receivings',
					'checked'=>$this->config->item('disable_variation_popup_in_receivings')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_disable_variation_popup_in_receivings')) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
					'name'=>'hide_location_name_on_receipt',
					'id'=>'hide_location_name_on_receipt',
					'class' => 'form-check-input',

					'value'=>'hide_location_name_on_receipt',
					'checked'=>$this->config->item('hide_location_name_on_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_location_name_on_receipt')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
					'name'=>'allow_reorder_sales_receipt',
					'id'=>'allow_reorder_sales_receipt',
					'class' => 'form-check-input',

					'value'=>'allow_reorder_sales_receipt',
					'checked'=>$this->config->item('allow_reorder_sales_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_allow_reorder_sales_receipt')) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
					'name'=>'allow_reorder_receiving_receipt',
					'id'=>'allow_reorder_receiving_receipt',
					'class' => 'form-check-input',

					'value'=>'allow_reorder_receiving_receipt',
					'checked'=>$this->config->item('allow_reorder_receiving_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_allow_reorder_receiving_receipt')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                            <?php echo form_checkbox(array(
					'name'=>'remove_weight_from_receipt',
					'id'=>'remove_weight_from_receipt',
					'class' => 'form-check-input',

					'value'=>'remove_weight_from_receipt',
					'checked'=>$this->config->item('remove_weight_from_receipt')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_remove_weight_from_receipt')) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_receipt')) ?>">
                                        <?php echo form_checkbox(array(
					'name'=>'remove_tax_percent_on_receipt',
					'id'=>'remove_tax_percent_on_receipt',
					'class' => 'form-check-input',

					'value'=>'remove_tax_percent_on_receipt',
					'checked'=>$this->config->item('remove_tax_percent_on_receipt')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_remove_tax_percent_on_receipt')) ?></label>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                    <!--begin::Sign-in Method-->
                    <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">  <?php echo create_section(lang('config_profit_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_profit_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">


                        <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_profit')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_receipt_text_size')) ?></label>
                                        <?php echo form_dropdown('config_calculate_profit_for_giftcard_when', array(
									''  => lang('common_do_nothing'),
									'redeeming_giftcard'   => lang('config_redeeming_giftcard'), 
									'selling_giftcard'  => lang('config_selling_giftcard'),
								),
								$this->config->item('calculate_profit_for_giftcard_when'), 'class="form-control form-control-solid" id="calculate_profit_for_giftcard_when"');
								?>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_profit')) ?>">
                                        <?php echo form_checkbox(array(
										'name'=>'remove_commission_from_profit_in_reports',
										'id'=>'remove_commission_from_profit_in_reports',
										'class' => 'form-check-input',

										'value'=>'1',
										'checked'=>$this->config->item('remove_commission_from_profit_in_reports')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_remove_commission_from_profit_in_reports')) ?></label>
                                    </div>
                                </div>

                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_profit')) ?>">
                                        <?php echo form_checkbox(array(
										'name'=>'remove_points_from_profit',
										'id'=>'remove_points_from_profit',
										'class' => 'form-check-input',

										'value'=>'1',
										'checked'=>$this->config->item('remove_points_from_profit')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_remove_points_from_profit')) ?></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->



                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> <?php echo create_section(lang('config_barcodes_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_barcodes_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                                            

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_id_to_show_on_barcode')) ?></label>
                                            <?php echo form_dropdown('id_to_show_on_barcode', array(
												'id'   => lang('common_item_id'),
												'number'  => lang('common_item_number_expanded'),
												'product_id'    => lang('common_product_id'),
												),
												$this->config->item('id_to_show_on_barcode'), 'class="form-select form-select-solid" id="id_to_show_on_barcode"')
												?>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'hide_barcode_on_barcode_labels',
										'id'=>'hide_barcode_on_barcode_labels',
										'class' => 'form-check-input',

										'value'=>'hide_barcode_on_barcode_labels',
										'checked'=>$this->config->item('hide_barcode_on_barcode_labels')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_barcode_on_barcode_labels')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'barcode_price_include_tax',
										'id'=>'barcode_price_include_tax',
										'class' => 'form-check-input',

										'value'=>'barcode_price_include_tax',
										'checked'=>$this->config->item('barcode_price_include_tax')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_barcode_price_include_tax')) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'hide_expire_date_on_barcodes',
										'id'=>'hide_expire_date_on_barcodes',
										'class' => 'form-check-input',

										'value'=>'hide_expire_date_on_barcodes',
										'checked'=>$this->config->item('hide_expire_date_on_barcodes')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_expire_date_on_barcodes')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'hide_price_on_barcodes',
										'id'=>'hide_price_on_barcodes',
										'class' => 'form-check-input',

										'value'=>'hide_price_on_barcodes',
										'checked'=>$this->config->item('hide_price_on_barcodes')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_price_on_barcodes')) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'hide_name_on_barcodes',
										'id'=>'hide_name_on_barcodes',
										'class' => 'form-check-input',

										'value'=>'hide_name_on_barcodes',
										'checked'=>$this->config->item('hide_name_on_barcodes')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_name_on_barcodes')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'disable_recv_number_on_barcode',
										'id'=>'disable_recv_number_on_barcode',
										'class' => 'form-check-input',

										'value'=>'disable_recv_number_on_barcode',
										'checked'=>$this->config->item('disable_recv_number_on_barcode')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_disable_recv_number_on_barcode')) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>








                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'show_barcode_company_name',
										'id'=>'show_barcode_company_name',
										'class' => 'form-check-input',

										'value'=>'show_barcode_company_name',
										'checked'=>$this->config->item('show_barcode_company_name')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_show_barcode_company_name')) ?></label>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'use_rtl_barcode_library',
										'id'=>'use_rtl_barcode_library',
										'class' => 'form-check-input',

										'value'=>'use_rtl_barcode_library',
										'checked'=>$this->config->item('use_rtl_barcode_library')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_use_rtl_barcode_library')) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <?php echo form_checkbox(array(
										'name'=>'enable_scale',
										'id'=>'enable_scale',
										'class' => 'form-check-input',

										'value'=>'enable_scale',
										'checked'=>$this->config->item('enable_scale')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_enable_scale')) ?></label>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_scale_format')) ?></label>
                                            <?php echo form_dropdown('scale_format', array(
								'scale_1'   => lang('config_scale_1'),
								'scale_2'  => lang('config_scale_2'),
								'scale_3'    => lang('config_scale_3'),
								'scale_4'    => lang('config_scale_4'),
								'scale_5'    => lang('config_scale_5'),
								'scale_6'    => lang('config_scale_6'),
								'scale_7'    => lang('config_scale_7'),
								),
								$this->config->item('scale_format'), 'class="form-control form-control-solid" id="scale_format"')
								?>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_scale_divide_by')) ?></label>
                                            <?php echo form_dropdown('scale_divide_by', array(
								'1000'   => '1000',
								'100'   => '100',
								'10'  => '10',
								'1'    => '1',
								),
								$this->config->item('scale_divide_by'), 'class="form-control form-control-solid" id="scale_divide_by"')
								?>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->



                  <!--begin::Sign-in Method-->
                  <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">  <?php echo create_section(lang('config_customer_loyalty_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_customer_loyalty_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                        <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_customer_loyalty')) ?>">
                                        <?php echo form_checkbox(array(
										'name'=>'enable_customer_loyalty_system',
										'id'=>'enable_customer_loyalty_system',
										'class' => 'form-check-input',

										'value'=>'enable_customer_loyalty_system',
										'checked'=>$this->config->item('enable_customer_loyalty_system')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_enable_customer_loyalty_system')) ?></label>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                    <div id="loyalty_setup">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-5 mb-5">
                                    <div class="rounded border p-10">
                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_customer_loyalty')) ?>">
                                                <?php echo form_checkbox(array(
										'name'=>'disable_loyalty_by_default',
										'id'=>'disable_loyalty_by_default',
										'class' => 'form-check-input',

										'value'=>'disable_loyalty_by_default',
										'checked'=>$this->config->item('disable_loyalty_by_default')));?>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_disable_loyalty_by_default')) ?></label>
                                            </div>
                                        </div>
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_barcodes')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_loyalty_option')) ?></label>
                                            <?php echo form_dropdown('loyalty_option', 
								 array(
									'simple'=> lang('config_simple'),
									'advanced'=>lang('config_advanced'),
								), $this->config->item('loyalty_option') ? $this->config->item('loyalty_option') : '20', 'class="form-select form-select-solid" id="loyalty_option"');
									?>


                                        </div>


                                    </div>
                                </div>
                            </div>


                        </div>




                        <div id="loyalty_setup_simple" style="display: none;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="py-5 mb-5">
                                        <div class="rounded border p-10">
                                            <div class="mb-10">
                                                <div class="form-check"
                                                    data-keyword="<?php echo H(lang('config_keyword_customer_loyalty')) ?>">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?php echo form_label(lang('config_number_of_sales_for_discount')) ?></label>
                                                    <?php echo form_input(array(
										'class'=>'validate form-control form-control-solidl form-inps',
										'name'=>'number_of_sales_for_discount',
										'id'=>'number_of_sales_for_discount',
										'value'=>$this->config->item('number_of_sales_for_discount')));?>

                                                </div>
                                            </div>
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_customer_loyalty')) ?>">
                                                <?php echo form_checkbox(array(
										'name'=>'hide_sales_to_discount_on_receipt',
										'id'=>'hide_sales_to_discount_on_receipt',
										'class' => 'form-check-input',

										'value'=>'hide_sales_to_discount_on_receipt',
										'checked'=>$this->config->item('hide_sales_to_discount_on_receipt')));?>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('hide_sales_to_discount_on_receipt')) ?></label>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>








                        </div>


                        <div id="loyalty_setup_advanced" style="display: none;">
                            <?php
								$spend_amount_for_points = '';
								$points_to_earn= '';
								if (strpos($this->config->item('spend_to_point_ratio'),':') !== FALSE)
								{
						      		list($spend_amount_for_points, $points_to_earn) = explode(":",$this->config->item('spend_to_point_ratio'),2);
									$spend_amount_for_points = (float)$spend_amount_for_points;
									$points_to_earn = (float)$points_to_earn;
									
								}
								?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="py-5 mb-5">
                                        <div class="rounded border p-10">
                                            <div class="mb-10">
                                                <div class="form-check"
                                                    data-keyword="<?php echo H(lang('config_keyword_customer_loyalty')) ?>">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?php echo form_label(lang('config_spend_to_point_ratio')) ?></label>
                                                    <?php echo form_input(array(
									'class'=>'validate form-control form-control-solid form-inps',
									'name'=>'spend_amount_for_points',
									'id'=>'spend_amount_for_points',
									'placeholder' => lang('config_loyalty_explained_spend_amount'),
									'value'=>$spend_amount_for_points));?>
                                                    <?php echo form_input(array(
										'class'=>'validate form-control form-control-solid form-inps',
										'name'=>'points_to_earn',
										'id'=>'points_to_earn',
										'placeholder' => lang('config_loyalty_explained_points_to_earn'),
										'value'=>$points_to_earn));?>

                                                </div>
                                            </div>
                                            <div class="mb-10">
                                                <div class="form-check"
                                                    data-keyword="<?php echo H(lang('config_keyword_customer_loyalty')) ?>">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?php echo form_label(lang('config_point_value')) ?></label>
                                                    <?php echo form_input(array(
								'class'=>'validate form-control form-control-solid form-inps',
								'name'=>'point_value',
								'id'=>'point_value',
								'value'=>$this->config->item('point_value') ? $this->config->item('point_value') : ''));?>


                                                </div>
                                            </div>
                                            <div class="mb-10">
                                                <div class="form-check"
                                                    data-keyword="<?php echo H(lang('config_keyword_customer_loyalty')) ?>">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?php echo form_label(lang('config_minimum_points_to_redeem')) ?></label>
                                                    <?php echo form_input(array(
								'class'=>'validate form-control form-control-solid form-inps',
								'name'=>'minimum_points_to_redeem',
								'id'=>'minimum_points_to_redeem',
								
								'value'=>$this->config->item('minimum_points_to_redeem') ? $this->config->item('minimum_points_to_redeem') : ''));?>


                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>





                            <div class="row">
                                <div class="col-md-12">
                                    <div class="py-5 mb-5">
                                        <div class="rounded border p-10">
                                            <div class="mb-10">
                                                <div class="form-check"
                                                    data-keyword="<?php echo H(lang('config_keyword_customer_loyalty')) ?>">
                                                    <?php echo form_checkbox(array(
										'name'=>'loyalty_points_without_tax',
										'id'=>'loyalty_points_without_tax',
										'class' => 'form-check-input',

										'value'=>'loyalty_points_without_tax',
										'checked'=>$this->config->item('loyalty_points_without_tax')));?>
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?php echo form_label(lang('config_prompt_to_use_points')) ?></label>
                                                </div>
                                            </div>
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_customer_loyalty')) ?>">
                                                <?php echo form_checkbox(array(
										'name'=>'prompt_to_use_points',
										'id'=>'prompt_to_use_points',
										'class' => 'form-check-input',

										'value'=>'prompt_to_use_points',
										'checked'=>$this->config->item('prompt_to_use_points')));?>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_prompt_to_use_points')) ?></label>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="py-5 mb-5">
                                        <div class="rounded border p-10">
                                            <div class="mb-10">
                                                <div class="form-check"
                                                    data-keyword="<?php echo H(lang('config_keyword_customer_loyalty')) ?>">
                                                    <?php echo form_checkbox(array(
										'name'=>'hide_points_on_receipt',
										'id'=>'hide_points_on_receipt',
										'class' => 'form-check-input',

										'value'=>'hide_points_on_receipt',
										'checked'=>$this->config->item('hide_points_on_receipt')));?>
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?php echo form_label(lang('config_hide_points_on_receipt')) ?></label>
                                                </div>
                                            </div>
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_customer_loyalty')) ?>">
                                                <?php echo form_checkbox(array(
										'name'=>'disable_gift_cards_sold_from_loyalty',
										'id'=>'disable_gift_cards_sold_from_loyalty',
										'class' => 'form-check-input',

										'value'=>'disable_gift_cards_sold_from_loyalty',
										'checked'=>$this->config->item('disable_gift_cards_sold_from_loyalty')));?>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_disable_gift_cards_sold_from_loyalty')) ?></label>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="py-5 mb-5">
                                        <div class="rounded border p-10">
                                            <div class="mb-10">
                                                <div class="form-check"
                                                    data-keyword="<?php echo H(lang('config_keyword_customer_loyalty')) ?>">
                                                    <?php echo form_checkbox(array(
										'name'=>'enable_points_for_giftcard_payments',
										'id'=>'enable_points_for_giftcard_payments',
										'class' => 'form-check-input',

										'value'=>'enable_points_for_giftcard_payments',
										'checked'=>$this->config->item('enable_points_for_giftcard_payments')));?>
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?php echo form_label(lang('config_enable_points_for_giftcard_payments')) ?></label>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>










                        </div>

                    </div>


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> <?php echo create_section(lang('config_price_tiers_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_price_tiers_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                                                        
                    <div class="form-group no-padding-right"
                        data-keyword="<?php echo H(lang('config_keyword_price_tiers')) ?>">
                        <?php echo form_label(lang('config_price_tiers').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                        <div class="col-md-9 col-sm-9 col-lg-10">
                            <div class="table-responsive">
                                <table id="price_tiers" class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('config_sort'); ?></th>
                                            <th><?php echo lang('common_tier_name'); ?></th>
                                            <th><?php echo lang('config_default_percent_off'); ?></th>
                                            <th><?php echo lang('config_default_cost_plus_percent'); ?></th>
                                            <th><?php echo lang('config_default_cost_plus_fixed_amount'); ?></th>
                                            <th><?php echo lang('common_delete'); ?></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach($tiers->result() as $tier) { ?>
                                        <tr>
                                            <td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td>
                                            <td><input type="text" data-index="<?php echo $tier->id; ?>"
                                                    class="tiers_to_edit form-control form-control-solid"
                                                    name="tiers_to_edit[<?php echo $tier->id; ?>][name]"
                                                    value="<?php echo H($tier->name); ?>" /></td>
                                            <td><input type="text" data-index="<?php echo $tier->id; ?>"
                                                    class="tiers_to_edit form-control form-control-solidl default_percent_off"
                                                    name="tiers_to_edit[<?php echo $tier->id; ?>][default_percent_off]"
                                                    value="<?php echo $tier->default_percent_off ? to_quantity($tier->default_percent_off) : ''; ?>" />
                                            </td>
                                            <td><input type="text" data-index="<?php echo $tier->id; ?>"
                                                    class="tiers_to_edit form-control form-control-solid default_cost_plus_percent"
                                                    name="tiers_to_edit[<?php echo $tier->id; ?>][default_cost_plus_percent]"
                                                    value="<?php echo $tier->default_cost_plus_percent ? to_quantity($tier->default_cost_plus_percent) : ''; ?>" />
                                            </td>
                                            <td><input type="text" data-index="<?php echo $tier->id; ?>"
                                                    class="tiers_to_edit form-control form-control-solid default_cost_plus_fixed_amount"
                                                    name="tiers_to_edit[<?php echo $tier->id; ?>][default_cost_plus_fixed_amount]"
                                                    value="<?php echo $tier->default_cost_plus_fixed_amount ? to_currency_no_money($tier->default_cost_plus_fixed_amount) : ''; ?>" />
                                            </td>
                                            <td>
                                                <?php if ($this->Employee->has_module_action_permission('items', 'delete', $this->Employee->get_logged_in_employee_info()->person_id) || $this->Employee->has_module_action_permission('item_kits', 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                                                <a class="delete_tier btn btn-danger btn-sm" href="javascript:void(0);"
                                                    data-tier-id='<?php echo $tier->id; ?>'><?php echo lang('common_delete'); ?></a>
                                                <?php }else { ?>
                                                &nbsp;
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <a href="javascript:void(0);" id="add_tier"
                                    class="btn btn-info btn-sm"><?php echo lang('config_add_tier'); ?></a>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_price_tiers')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_override_tier_name')) ?></label>
                                            <?php echo form_input(array(
										'class'=>'form-select form-select-solid form-inps',
									'name'=>'override_tier_name',
									'id'=>'override_tier_name',
									'value'=>$this->config->item('override_tier_name')));?>

                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_price_tiers')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_tier_on_receipt')) ?></label>
                                            <?php echo form_checkbox(array(
									'name'=>'hide_tier_on_receipt',
									'id'=>'hide_tier_on_receipt',
									'value'=>'1',
									'class' => 'form-check-input',
									'checked'=>$this->config->item('hide_tier_on_receipt')));?>

                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_price_tiers')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_default_tier_percent_type_for_excel_import')) ?></label>
                                            <?php echo form_dropdown('default_tier_percent_type_for_excel_import', array(
		 							'percent_off'    => lang('common_percent_off'),
		 							'cost_plus_percent'    => lang('common_cost_plus_percent'),
								),
		 							$this->config->item('default_tier_percent_type_for_excel_import')===NULL ? 'before' : $this->config->item('default_tier_percent_type_for_excel_import') , 'class="form-select form-select-solid" id="default_tier_percent_type_for_excel_import"');
		 							?>

                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_price_tiers')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'round_tier_prices_to_2_decimals',
									'id'=>'round_tier_prices_to_2_decimals',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('round_tier_prices_to_2_decimals')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_round_tier_prices_to_2_decimals')) ?></label>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>



                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">  <?php echo create_section(lang('config_auto_increment_ids_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_auto_increment_ids_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                        <div class="">
                        <div class="col-sm-offset-3 col-md-offset-3 col-lg-offset-2 col-sm-9 col-md-9 col-lg-10">
                            <div class="alert alert-info" role="alert" style="margin-left: -195px;">
                                <strong><?php echo lang('common_note') ?>:</strong>
                                <?php echo lang('config_auto_increment_note') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_auto_increment')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_item_id_auto_increment')) ?></label>
                                            <?php echo form_input(array(
									'class'=>'validate form-control form-control-solid form-inps',
								'name'=>'item_id_auto_increment',
								'id'=>'item_id_auto_increment',
								'value'=>''));?>

                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_auto_increment')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_item_kit_id_auto_increment')) ?></label>
                                            <?php echo form_input(array(
									'class'=>'validate form-control form-control-solid form-inps',
								'name'=>'item_kit_id_auto_increment',
								'id'=>'item_kit_id_auto_increment',
								'value'=>''));?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>






                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_auto_increment')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_sale_id_auto_increment')) ?></label>
                                            <?php echo form_input(array(
									'class'=>'validate form-control form-control-solid form-inps',
								'name'=>'sale_id_auto_increment',
								'id'=>'sale_id_auto_increment',
								'value'=>''));?>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_auto_increment')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_receiving_id_auto_increment')) ?></label>
                                            <?php echo form_input(array(
									'class'=>'validate form-control form-control-solid form-inps',
								'name'=>'receiving_id_auto_increment',
								'id'=>'receiving_id_auto_increment',
								'value'=>''));?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">  <?php echo create_section(lang('config_items_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_items_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">



                        <div class="row">
                        <div class="col-md-6">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_number_of_items_per_page')) ?></label>
                                            <?php echo form_dropdown('number_of_items_per_page', 
											array(
												'20'=>'20',
												'50'=>'50',
												'100'=>'100',
												'200'=>'200',
												'500'=>'500'
												), $this->config->item('number_of_items_per_page') ? $this->config->item('number_of_items_per_page') : '20', 'class="form-select form-select-solid" id="number_of_items_per_page"');
												?>

                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_items_per_search_suggestions')) ?></label>
                                            <?php echo form_dropdown('items_per_search_suggestions', 
												array(
													'20'=>'20',
													'50'=>'50',
													'100'=>'100',
													'200'=>'200',
													'500'=>'500'
													), $this->config->item('items_per_search_suggestions') ? $this->config->item('items_per_search_suggestions') : '20', 'class="form-select form-select-solid" id="items_per_search_suggestions"');
													?>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>






                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_number_of_items_in_grid')) ?></label>
                                            <?php 
												$numbers = array();
												foreach(range(1, 50) as $number) 
												{ 
													$numbers[$number] = $number;
													
												}
												?>
                                            <?php echo form_dropdown('number_of_items_in_grid', 
												$numbers, $this->config->item('number_of_items_in_grid') ? $this->config->item('number_of_items_in_grid') : '14', 'class="form-select form-select-solid" id="number_of_items_in_grid"');
												?>

                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_default_reorder_level_when_creating_items')) ?></label>
                                            <?php echo form_input(array(
												'class'=>'form-control form-control-solid form-inps',
												'name'=>'default_reorder_level_when_creating_items',
												'id'=>'default_reorder_level_when_creating_items',
												'value'=>$this->config->item('default_reorder_level_when_creating_items')));?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_default_days_to_expire_when_creating_items')) ?></label>
                                            <?php echo form_input(array(
												'class'=>'form-control form-control-solid default_days_to_expire_when_creating_items-control-solid form-inps',
												'name'=>'default_days_to_expire_when_creating_items',
												'id'=>'default_days_to_expire_when_creating_items',
												'value'=>$this->config->item('default_days_to_expire_when_creating_items')));?>

                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <?php echo form_checkbox(array(
									'name'=>'default_new_items_to_service',
									'id'=>'default_new_items_to_service',
									'value'=>'default_new_items_to_service',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('default_new_items_to_service')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_default_new_items_to_service')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>






                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <?php echo form_checkbox(array(
									'name'=>'highlight_low_inventory_items_in_items_module',
									'id'=>'highlight_low_inventory_items_in_items_module',
									'value'=>'highlight_low_inventory_items_in_items_module',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('highlight_low_inventory_items_in_items_module')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_highlight_low_inventory_items_in_items_module')) ?></label>


                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <?php echo form_checkbox(array(
									'name'=>'limit_manual_price_adj',
									'id'=>'limit_manual_price_adj',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('limit_manual_price_adj')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_limit_manual_price_adj')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>







                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('common_max_discount_percent')) ?></label>
                                            <?php echo form_input(array(
												'class'=>'form-control form-control-solid  form-inps',
												'name'=>'max_discount_percent',
												'id'=>'max_discount_percent',
												'value'=>$this->config->item('max_discount_percent')));?>

                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <?php echo form_checkbox(array(
													'name'=>'enable_markup_calculator',
													'id'=>'enable_markup_calculator',
													'value'=>'enable_markup_calculator',
													'class' => 'form-check-input',

													'checked'=>$this->config->item('enable_markup_calculator')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_enable_markup_calculator')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>






                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <?php echo form_checkbox(array(
									'name'=>'enable_margin_calculator',
									'id'=>'enable_margin_calculator',
									'value'=>'enable_margin_calculator',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('enable_margin_calculator')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_enable_margin_calculator')) ?></label>


                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <?php echo form_checkbox(array(
									'name'=>'verify_age_for_products',
									'id'=>'verify_age_for_products',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('verify_age_for_products')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_verify_age_for_products')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>














                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            <?php if (!$this->config->item('verify_age_for_products')){echo 'hidden';} ?>
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'default_age_to_verify',
									'id'=>'default_age_to_verify',
									'value'=>'default_age_to_verify',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('default_age_to_verify')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_default_age_to_verify')) ?></label>

                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <?php echo form_checkbox(array(
									'name'=>'enable_markup_calculator',
									'id'=>'enable_markup_calculator',
									'value'=>'enable_markup_calculator',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('enable_markup_calculator')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_enable_markup_calculator')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>






                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <?php echo form_checkbox(array(
									'name'=>'strict_age_format_check',
									'id'=>'strict_age_format_check',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('strict_age_format_check')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_strict_age_format_check')) ?></label>


                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <?php echo form_checkbox(array(
									'name'=>'hide_supplier_in_item_search_result',
									'id'=>'hide_supplier_in_item_search_result',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('hide_supplier_in_item_search_result')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_supplier_in_item_search_result')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>







                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'hide_supplier_from_item_popup',
									'id'=>'hide_supplier_from_item_popup',
									'value'=>'hide_supplier_from_item_popup',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('hide_supplier_from_item_popup')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_supplier_from_item_popup')) ?></label>

                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <?php echo form_checkbox(array(
									'name'=>'easy_item_clone_button',
									'id'=>'easy_item_clone_button',
									'value'=>'easy_item_clone_button',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('easy_item_clone_button')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_easy_item_clone_button')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>






                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_items')) ?>">
                                            <?php echo form_checkbox(array(
									'name'=>'add_ck_editor_to_item',
									'id'=>'add_ck_editor_to_item',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('add_ck_editor_to_item')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_add_ck_editor')) ?></label>


                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>



                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                  <!--begin::Sign-in Method-->
                  <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> <?php echo create_section(lang('config_employee_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_employee_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                                                
                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_employees')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'allow_employees_to_use_2fa',
									'id'=>'allow_employees_to_use_2fa',
									'value'=>'allow_employees_to_use_2fa',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('allow_employees_to_use_2fa')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_allow_employees_to_use_2fa')) ?></label>

                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_employees')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'timeclock',
									'id'=>'timeclock',
									'value'=>'timeclock',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('timeclock')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_enable_timeclock')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>






                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_employees')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'logout_on_clock_out',
									'id'=>'logout_on_clock_out',
									'value'=>'logout_on_clock_out',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('logout_on_clock_out')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_logout_on_clock_out')) ?></label>

                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_employees')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'fast_user_switching',
									'id'=>'fast_user_switching',
									'value'=>'fast_user_switching',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('timeclock')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_fast_user_switching')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_employees')) ?>">

                                        <?php echo form_checkbox(array(
									'name'=>'require_employee_login_before_each_sale',
									'id'=>'require_employee_login_before_each_sale',
									'value'=>'require_employee_login_before_each_sale',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('require_employee_login_before_each_sale')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_require_employee_login_before_each_sale')) ?></label>

                                    </div>
                                </div>


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_employees')) ?>">

                                        <?php echo form_checkbox(array(
									'name'=>'reset_location_when_switching_employee',
									'id'=>'reset_location_when_switching_employee',
									'value'=>'reset_location_when_switching_employee',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('reset_location_when_switching_employee')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_reset_location_when_switching_employee')) ?></label>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>




                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->



                   <!--begin::Sign-in Method-->
                   <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">  <?php echo create_section(lang('config_store_accounts_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_store_accounts_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                        <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'customers_store_accounts',
									'id'=>'customers_store_accounts',
									'value'=>'customers_store_accounts',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('customers_store_accounts')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_customers_store_accounts')) ?></label>

                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'create_invoices_for_customer_store_account_charges',
									'id'=>'create_invoices_for_customer_store_account_charges',
									'value'=>'create_invoices_for_customer_store_account_charges',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('create_invoices_for_customer_store_account_charges')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_create_invoices_for_customer_store_account_charges')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'automatically_email_invoice',
									'id'=>'automatically_email_invoice',
									'value'=>'automatically_email_invoice',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('automatically_email_invoice')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_automatically_email_invoice')) ?></label>

                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_default_credit_limit')) ?></label>

                                            <?php echo form_input(array(
								'class'=>'form-control form-control-solid form-inps',
								'name'=>'default_credit_limit',
								'id'=>'default_credit_limit',
								'value'=>$this->config->item('default_credit_limit')));?>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'suppliers_store_accounts',
									'id'=>'suppliers_store_accounts',
									'value'=>'suppliers_store_accounts',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('suppliers_store_accounts')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_suppliers_store_accounts')) ?></label>

                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'create_invoices_for_supplier_store_account_charges',
									'id'=>'create_invoices_for_supplier_store_account_charges',
									'value'=>'create_invoices_for_supplier_store_account_charges',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('create_invoices_for_supplier_store_account_charges')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_create_invoices_for_supplier_store_account_charges')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'disable_store_account_when_over_credit_limit',
									'id'=>'disable_store_account_when_over_credit_limit',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('disable_store_account_when_over_credit_limit')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_disable_store_account_when_over_credit_limit')) ?></label>

                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_store_account_statement_message')) ?></label>
                                        <?php echo form_textarea(array(
								'name'=>'store_account_statement_message',
								'id'=>'store_account_statement_message',
								'class'=>'form-control form-control-solid text-area',
								'rows'=>'4',
								'cols'=>'30',
								'value'=>$this->config->item('store_account_statement_message')));?>


                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">

                                            <?php echo form_checkbox(array(
												'name'=>'hide_store_account_payments_in_reports',
												'id'=>'hide_store_account_payments_in_reports',
												'value'=>'1',
												'class' => 'form-check-input',

												'checked'=>$this->config->item('hide_store_account_payments_in_reports')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_store_account_payments_in_reports')) ?></label>

                                        </div>
                                    </div>


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'hide_store_account_payments_from_report_totals',
									'id'=>'hide_store_account_payments_from_report_totals',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('hide_store_account_payments_from_report_totals')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_store_account_payments_from_report_totals')) ?></label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_paypal_me')) ?></label>

                                            <?php echo form_input(array(
								'class'=>'form-control form-control-solid form-inps',
								'name'=>'paypal_me',
								'id'=>'paypal_me',
								'placeholder' => 'paypal.me '.lang('common_username'),
								'value'=>$this->config->item('paypal_me')));?>

                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>



                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->

                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">   <?php echo lang('config_disable_modules'); ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_disable_modules" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                        <div class="row">

                            <?php
                                foreach ($all_modules->result() as $module) {
                                    if($module->module_id=='config'){
                                        continue;
                                    }
                                    $checkbox_options = array(
                                        'name' => 'disable_modules[]',
                                        'id' => 'permissions' . $module->module_id,
                                        'value' => $module->module_id,
                                        'checked' => array_search($module->module_id, $disable_modules) === false ? false: true ,
                                        'class' => 'module_checkboxes form-check-input'
                                    );

                                    if ($logged_in_employee_id != 1) {
                                        if (($checkbox_options['checked']) || !$this->Employee->has_module_permission($module->module_id, $logged_in_employee_id, FALSE, TRUE)) {
                                            $checkbox_options['disabled'] = 'disabled';

                                            //Only send permission if checked
                                            if ($checkbox_options['checked']) {
                                                echo form_hidden('permissions[]', $module->module_id);
                                            }
                                        }
                                    }
                            ?>

                            <div class="col-md-4">
                                <div class="py-5 mb-5">
                                    <div class="rounded border p-10">
                                        <div class="mb-10">
                                            <div class="form-check" data-keyword="<?php echo H(lang('module_config')) ?>">

                                                <?php echo form_checkbox($checkbox_options, '1', null,'id="'.$module->module_id.'"');?>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('common_disable').' '.lang($module->name_lang_key)) ?></label>

                                            </div>
                                        </div>




                                    </div>
                                </div>
                            </div>


                            <?php } ?>
                            </div>

                            </div>

                            <div class="row">
                            <div class="col-md-6">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_modules')) ?>">

                                            <?php echo form_checkbox(array(
                                                    'name'=>'hover_to_expand_sub_modules',
                                                    'id'=>'hover_to_expand_sub_modules',
                                                    'value'=>'hover_to_expand_sub_modules',
                                                    'class' => 'form-check-input',

                                                    'checked'=>$this->config->item('hover_to_expand_sub_modules')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hover_to_expand_sub_modules')) ?></label>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            </div>



                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->




                <!--begin::Sign-in Method-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> <?php echo create_section(lang('config_application_settings_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_application_settings_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                      
                    <?php if(is_on_demo_host()) { ?>
                    <div class="form-group">
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <span class="text-danger"><?php echo lang('config_cannot_change_language'); ?></span>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('common_language')) ?></label>
                                            <?php echo form_dropdown('language', array(
											'english'  => 'English',
											'indonesia'    => 'Indonesia',
											'spanish'   => 'Español', 
											'french'    => 'Fançais',
											'italian'    => 'Italiano',
											'german'    => 'Deutsch',
											'dutch'    => 'Nederlands',
											'portugues'    => 'Portugues',
											'arabic' => 'العَرَبِيةُ‎‎',
											'khmer' => 'Khmer',
											'vietnamese' => 'Vietnamese',
											'chinese' => '中文',
											'chinese_traditional' => '繁體中文',
											'tamil' => 'Tamil',
										),
										$this->Appconfig->get_raw_language_value(), 'class="form-select form-select-solid" id="language"');
										?>


                                        </div>

                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_date_format')) ?></label>
                                            <?php echo form_dropdown('date_format', array(
									'middle_endian'    => '12/30/2000',
									'little_endian'  => '30-12-2000',
									'big_endian'   => '2000-12-30'), $this->config->item('date_format'), 'class="form-select form-select-solid" id="date_format"');
									?>


                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_time_format')) ?></label>
                                            <?php echo form_dropdown('time_format', array(
									'12_hour'    => '1:00 PM',
									'24_hour'  => '13:00'
									), $this->config->item('time_format'), 'class="form-select form-select-solid" id="time_format"');
									?>

                                        </div>

                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_week_start_day')) ?></label>
                                            <?php echo form_dropdown('week_start_day', array(
									'monday'    => lang('common_monday'),
									'sunday'  => lang('common_sunday')
									), $this->config->item('week_start_day'), 'class="form-select form-select-solid" id="week_start_day"');
									?>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_store_opening_time')) ?></label>
                                            <?php echo form_input(array(
			 						        'name'=>'store_opening_time',
			 						        'id'=>'store_opening_time',
			 										'class'=>'form-control form-control-solid timepicker',
			 						        'value'=> $this->config->item('store_opening_time') ? $this->config->item('store_opening_time') : ''
											));?>

                                        </div>

                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_store_closing_time')) ?></label>
                                            <?php echo form_input(array(
			 						        'name'=>'store_closing_time',
			 						        'id'=>'store_closing_time',
			 										'class'=>'form-control form-control-solid timepicker',
			 						        'value'=> $this->config->item('store_closing_time') ? $this->config->item('store_closing_time') : ''
											));?>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
												'name'=>'payvantage',
												'id'=>'payvantage',
												'class' => 'form-check-input',
												'value'=>'payvantage',
												'checked'=>$this->config->item('payvantage')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label('PayVantage:', 'payvantage'); ?></label>
                                        </div>
                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                                <?php echo form_checkbox(array(
												'name'=>'offline_mode',
												'id'=>'offline_mode',
												'class' => 'form-check-input',
												'value'=>'offline_mode',
												'checked'=>$this->config->item('offline_mode')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_offline_mode').':', 'offline_mode') ?></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
												'name'=>'auto_sync_offline_sales',
												'id'=>'auto_sync_offline_sales',
												'class' => 'form-check-input',
												'value'=>'auto_sync_offline_sales',
												'checked'=>$this->config->item('auto_sync_offline_sales')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label('config_auto_sync_offline_sales'); ?></label>
                                        </div>

                                        <div class="form-check" style="margin-top: 27px;"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <button
                                                onclick="delete_all_client_side_dbs(); bootbox.alert('<?php echo json_encode(lang('common_success')); ?>');"
                                                id="reset_offline_mode" type="button"
                                                class="btn btn-lg btn-primary"><?php echo lang('config_reset_offline_data');?></button>




                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'dark_mode',
									'id'=>'dark_mode',
									'value'=>'dark_mode',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('dark_mode')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('common_dark_mode')); ?></label>
                                        </div>
                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                                <?php echo form_checkbox(array(
												'name'=>'only_allow_current_location_customers',
												'id'=>'only_allow_current_location_customers',
												'class' => 'form-check-input',
												'value'=>'only_allow_current_location_customers',
												'checked'=>$this->config->item('only_allow_current_location_customers')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_only_allow_current_location_customers').':', 'offline_mode') ?></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'default_new_customer_to_current_location',
									'id'=>'default_new_customer_to_current_location',
									'value'=>'default_new_customer_to_current_location',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('default_new_customer_to_current_location')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_default_new_customer_to_current_location')); ?></label>
                                        </div>
                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                                <?php echo form_checkbox(array(
												'name'=>'only_allow_current_location_employees',
												'id'=>'only_allow_current_location_employees',
												'class' => 'form-check-input',
												'value'=>'only_allow_current_location_employees',
												'checked'=>$this->config->item('only_allow_current_location_employees')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_only_allow_current_location_employees').':', 'offline_mode') ?></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'force_https',
									'id'=>'force_https',
									'value'=>'force_https',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('force_https')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_force_https')); ?></label>
                                        </div>
                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                                <?php echo form_checkbox(array(
												'name'=>'do_not_delete_saved_card_after_failure',
												'id'=>'do_not_delete_saved_card_after_failure',
												'class' => 'form-check-input',
												'value'=>'do_not_delete_saved_card_after_failure',
												'checked'=>$this->config->item('do_not_delete_saved_card_after_failure')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_do_not_delete_saved_card_after_failure'))?></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'do_not_force_http',
									'id'=>'do_not_force_http',
									'value'=>'do_not_force_http',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('do_not_force_http')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_do_not_force_http')); ?></label>
                                        </div>
                                        <?php if (!is_on_demo_host()) { ?>
                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                                <?php echo form_checkbox(array(
												'name'=>'test_mode',
												'id'=>'test_mode',
												'class' => 'form-check-input',
												'value'=>'test_mode',
												'checked'=>$this->config->item('test_mode')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_test_mode').':', 'offline_mode') ?></label>
                                            </div>
                                        </div>
                                        <?php } ?>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>







                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'hide_item_descriptions_in_reports',
									'id'=>'hide_item_descriptions_in_reports',
									'value'=>'hide_item_descriptions_in_reports',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('hide_item_descriptions_in_reports')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_hide_item_descriptions_in_reports')); ?></label>
                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                                <?php echo form_checkbox(array(
												'name'=>'disable_test_mode',
												'id'=>'disable_test_mode',
												'class' => 'form-check-input',
												'value'=>'disable_test_mode',
												'checked'=>$this->config->item('disable_test_mode')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_disable_test_mode').':', 'offline_mode') ?></label>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'enable_sounds',
									'id'=>'enable_sounds',
									'value'=>'enable_sounds',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('enable_sounds')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_enable_sounds')); ?></label>
                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                                <?php echo form_checkbox(array(
												'name'=>'show_language_switcher',
												'id'=>'show_language_switcher',
												'class' => 'form-check-input',
												'value'=>'1',
												'checked'=>$this->config->item('show_language_switcher')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_show_language_switcher')) ?></label>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'show_clock_on_header',
									'id'=>'show_clock_on_header',
									'value'=>'show_clock_on_header',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('show_clock_on_header')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_show_clock_on_header')); ?></label>
                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                                <?php echo form_checkbox(array(
												'name'=>'legacy_detailed_report_export',
												'id'=>'legacy_detailed_report_export',
												'class' => 'form-check-input',
												'value'=>'1',
												'checked'=>$this->config->item('legacy_detailed_report_export')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_legacy_detailed_report_export')) ?></label>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>








                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'overwrite_existing_items_on_excel_import',
									'id'=>'overwrite_existing_items_on_excel_import',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('overwrite_existing_items_on_excel_import')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_overwrite_existing_items_on_excel_import')); ?></label>
                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_report_sort_order')) ?></label>
                                                <?php echo form_dropdown('report_sort_order', array('asc' => lang('config_asc'), 'desc' => lang('config_desc')), $this->config->item('report_sort_order'),'class="form-select form-select-solid" id="report_sort_order"'); ?>



                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'speed_up_search_queries',
									'id'=>'speed_up_search_queries',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('speed_up_search_queries')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_speed_up_search_queries')); ?></label>
                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                                <?php echo form_checkbox(array(
									'name'=>'customer_allow_partial_match',
									'id'=>'customer_allow_partial_match',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('customer_allow_partial_match')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_customer_allow_partial_match')); ?></label>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'enable_quick_edit',
									'id'=>'enable_quick_edit',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('enable_quick_edit')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_enable_quick_edit')); ?></label>
                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                                <?php echo form_checkbox(array(
									'name'=>'enable_quick_expense',
									'id'=>'enable_quick_expense',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('enable_quick_expense')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_enable_quick_expense')); ?></label>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php 
									$enhanced_search_options = array(
										'name'=>'enhanced_search_method',
										'id'=>'enhanced_search_method',
										'value'=>'1',
									'class' => 'form-check-input',

										'checked'=>$this->config->item('enhanced_search_method') && $this->config->item('supports_full_text'));
									
										if (!$this->config->item('supports_full_text'))
										{
											$enhanced_search_options['disabled'] = 'disabled';
										}
									
										echo form_checkbox($enhanced_search_options);
									
										?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_enhanced_search_method')); ?></label>
                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                                <?php echo form_checkbox(array(
									'name'=>'include_child_categories_when_searching_or_reporting',
									'id'=>'include_child_categories_when_searching_or_reporting',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('include_child_categories_when_searching_or_reporting')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_include_child_categories_when_searching_or_reporting')); ?></label>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'show_full_category_path',
									'id'=>'show_full_category_path',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('show_full_category_path')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_show_full_category_path')); ?></label>
                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_spreadsheet_format')) ?>">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_include_child_categories_when_searching_or_reporting')); ?></label>

                                                <?php echo form_dropdown('spreadsheet_format', array('CSV' => lang('config_csv'), 'XLSX' => lang('config_xlsx')), $this->config->item('spreadsheet_format'),'class="form-select form-select-solid" id="spreadsheet_format"'); ?>




                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_spreadsheet_format')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_mailing_labels_type')); ?></label>

                                            <?php echo form_dropdown('mailing_labels_type', array('pdf' => 'PDF', 'excel' => 'Excel'), $this->config->item('mailing_labels_type'),'class="form-select form-select-solid" id="mailing_labels_type"'); ?>




                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_spreadsheet_format')) ?>">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_phppos_session_expiration')); ?></label>



                                                <?php echo form_dropdown('phppos_session_expiration',$phppos_session_expirations, $this->config->item('phppos_session_expiration')!==NULL ? $this->config->item('phppos_session_expiration') : 0,'class="form-select form-select-solid" id="phppos_session_expiration"'); ?>


                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'always_minimize_menu',
									'id'=>'always_minimize_menu',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('always_minimize_menu')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_always_minimize_menu')); ?></label>
                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_spreadsheet_format')) ?>">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_item_lookup_order')); ?></label>

                                                <ul id="item_lookup_order_list" class="list-group">
                                                    <?php 
												foreach($item_lookup_order as $item_lookup_number)
												{
												?>
                                                    <li class="list-group-item"><input name="item_lookup_order[]"
                                                            type="hidden"
                                                            value="<?php echo H($item_lookup_number); ?>"><?php echo lang('common_'.$item_lookup_number); ?><span
                                                            class="ui-icon ui-icon-arrowthick-2-n-s pull-right"></span>
                                                    </li>
                                                    <?php 
												}
												?>
                                                </ul>



                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'allow_scan_of_customer_into_item_field',
									'id'=>'allow_scan_of_customer_into_item_field',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('allow_scan_of_customer_into_item_field')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_allow_scan_of_customer_into_item_field')); ?></label>
                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_spreadsheet_format')) ?>">

                                                <?php echo form_checkbox(array(
									'name'=>'send_sms_via_whatsapp',
									'id'=>'send_sms_via_whatsapp',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('send_sms_via_whatsapp')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_send_sms_via_whatsapp')); ?></label>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">

                                            <?php echo form_checkbox(array(
									'name'=>'enable_quick_customers',
									'id'=>'enable_quick_customers',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('enable_quick_customers')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_enable_quick_customers')); ?></label>
                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_spreadsheet_format')) ?>">

                                                <?php echo form_checkbox(array(
									'name'=>'enable_quick_items',
									'id'=>'enable_quick_items',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('enable_quick_items')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_enable_quick_items')); ?></label>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>





                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_application_settings')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <label class='col-sm-12 col-md-12 col-lg-12 control-label'
                                                    for="additional_appointment_note"><?php echo lang('config_additional_appointment_note'); ?>
                                                    <br>
                                                    <small>**<?php echo lang('common_bold');?>**,
                                                        ~~<?php echo lang('common_italic');?>~~,
                                                        ||<?php echo lang('common_underline');?>||</small>
                                                    <br>
                                                    <small
                                                        style="border-bottom: 1px dotted #000000;text-decoration: none;cursor:pointer;"
                                                        title="<?php echo implode("&#013;",$this->Appconfig->get_replaceable_keywords());?>"><?php echo lang("config_keywords_help_text"); ?></small>
                                                </label>


                                                <?php echo form_textarea(array(
								'name'=>'additional_appointment_note',
								'id'=>'additional_appointment_note',
								'class'=>'form-control form-control-solid text-area',
								'rows'=>'5',
								'cols'=>'30',
								'value'=>$this->config->item('additional_appointment_note')));?>


                                        </div>

                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_spreadsheet_format')) ?>">

                                                <?php echo form_checkbox(array(
									'name'=>'do_not_delete_serial_number_when_selling',
									'id'=>'do_not_delete_serial_number_when_selling',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('do_not_delete_serial_number_when_selling')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_do_not_delete_serial_number_when_selling')); ?></label>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">


                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_spreadsheet_format')) ?>">

                                                <?php echo form_checkbox(array(
									'name'=>'enable_name_prefix',
									'id'=>'enable_name_prefix',
									'value'=>'1',
									'class' => 'form-check-input',

									'checked'=>$this->config->item('enable_name_prefix')));?>

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_enable_name_prefix')); ?></label>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>



                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                <!--begin::Sign-in Method-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">  <?php echo create_section(lang('config_email_settings_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_email_settings_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                                                    

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_email')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label('Select A Provider'.':', 'email_provider'); ?></label>
                                            <?php
									$provider_options = array('Use System Default'=>'Use System Default', 'Gmail API'=>'Gmail API', 'Gmail'=>'Gmail', 'Office 365'=>'Office 365', 'Windows Live Hotmail'=>'Windows Live Hotmail', 'Other'=>'Other');
									echo form_dropdown('email_provider', $provider_options, $this->config->item('email_provider'), 'id="email_provider" class="form-select form-select-solid"');
								?>



                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="email_gmail_api">


                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-5 mb-5">
                                    <div class="rounded border p-10">


                                        <div class="mb-10">

                                            <a href="javaascript:void(0)" id="gmail_api_authorize_button"
                                                style="<?php echo $this->config->item('gmail_api_token')?"display:none;":""; ?>">
                                                <img src="assets/img/btn_google_signin_dark_pressed_web.png">
                                            </a>
                                            <a id="gmail_api_signout_button" class="btn btn-lg btn-danger"
                                                style="border:0px; <?php echo $this->config->item('gmail_api_token')?"":"display:none;"; ?>">
                                                <?php echo lang("gmail_api_remove"); ?>
                                            </a>


                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="email_basic">


                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-5 mb-5">
                                    <div class="rounded border p-10">


                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_email')) ?>">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_smtp_user')); ?></label>
                                                <?php echo form_input(array(
								'class'=>'form-control form-control-solid form-inps',
								'name'=>'smtp_user',
								'id'=>'smtp_user',
								'placeholder' => 'username@domain.com',
								'value'=>$this->config->item('smtp_user')));?>



                                            </div>


                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="py-5 mb-5">
                                    <div class="rounded border p-10">


                                        <div class="mb-10">
                                            <div class="form-check"
                                                data-keyword="<?php echo H(lang('config_keyword_email')) ?>">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?php echo form_label(lang('config_smtp_pass')); ?></label>
                                                <?php echo form_password(array(
								'class'=>'form-control form-control-solid form-inps',
								'name'=>'smtp_pass',
								'id'=>'smtp_pass',
								'placeholder'=> 'password',
								'value'=>$this->config->item('smtp_pass')));?>
                                            </div>



                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="email_advanced">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_email')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_smtp_crypto')); ?></label>
                                            <?php
									$smtp_crypto_options = array(''=>'','ssl'=>'ssl','tls'=>'tls');
									echo form_dropdown('smtp_crypto', $smtp_crypto_options, $this->config->item('smtp_crypto'), 'id="smtp_crypto" class="form-select form-select-solid"');
								?>



                                        </div>
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_keyword_email')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_email_protocol')); ?></label>
                                            <?php
									$protocol_options = array(''=>'','smtp'=>'smtp','mail'=>'mail','sendmail'=>'sendmail');
									echo form_dropdown('protocol', $protocol_options, $this->config->item('protocol'), 'id="protocol" class="form-select form-select-solid"');
								?>



                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_smtp_host')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_smtp_host')); ?></label>
                                            <?php echo form_input(array(
								'class'=>'form-control form-control-solid form-inps',
								'name'=>'smtp_host',
								'id'=>'smtp_host',
								'placeholder' => 'smtp.domain.com',
								'value'=>$this->config->item('smtp_host')));?>



                                        </div>

                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_smtp_port')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_smtp_port')); ?></label>
                                            <?php echo form_input(array(
								'class'=>'form-control form-control-solid form-inps',
								'name'=>'smtp_port',
								'id'=>'smtp_port',
								'placeholder' => 'smtp.domain.com',
								'value'=>$this->config->item('smtp_port')));?>



                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_email_charset')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_email_charset')); ?></label>
                                            <?php echo form_input(array(
								'class'=>'form-control form-control-solid form-inps',
								'name'=>'email_charset',
								'id'=>'email_charset',
								'placeholder'=>'utf-8',
								'value'=>$this->config->item('email_charset')));?>



                                        </div>

                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_email_newline')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_email_newline')); ?></label>
                                            <?php
									$newline_options = array('rn'=>'\r\n','n'=>'\n','r'=>'\r');
									$selected_option = 'rn';
									
									if ($option = $this->config->item('newline'))
									{
										if ($option == "\r\n")
										{
											$selected_option = 'rn';
										}
										elseif($option == "\n")
										{
											$selected_option = 'n';										
										}
										elseif($option == "\r")
										{
											$selected_option='r';
										}
									}
									
									echo form_dropdown('newline', $newline_options,$selected_option, 'id="newline" class="form-select form-select-solid"');
								?>



                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_email_charset')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_keyword_email')); ?></label>
                                            <?php
									$crlf_options = array('rn'=>'\r\n','n'=>'\n','r'=>'\r');
									$selected_option = 'rn';
									
									if ($option = $this->config->item('crlf'))
									{
										if ($option == "\r\n")
										{
											$selected_option = 'rn';
										}
										elseif($option == "\n")
										{
											$selected_option = 'n';										
										}
										elseif($option == "\r")
										{
											$selected_option='r';
										}
									}
									
									echo form_dropdown('crlf', $crlf_options,$selected_option, 'id="crlf" class="form-select form-select-solid"');
								?>



                                        </div>

                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_email_newline')) ?>">

                                            <?php echo form_input(array(
								'class'=>'form-control form-control-solid form-inps',
								'name'=>'smtp_timeout',
								'id'=>'smtp_timeout',
								'placeholder'=>'5',
								'value'=>$this->config->item('smtp_timeout')));?>

                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_smtp_timeout')); ?></label>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>






                </div> <!-- end advanced email -->
                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_email')) ?>">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <span class="pull-right">
                            <button id="test_email" type="button" class="btn btn-lg btn-primary"><span
                                    id="test_email_icon" class="glyphicon glyphicon-envelope"></span>
                                <?php echo lang('config_send_test_email');?></button>
                        </span>
                    </div>
                </div>

                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->



                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">   <?php echo create_section(lang("config_sso_info"))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_sso_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                      
                                                
                <div class="row">
                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_sso_protocol')); ?></label>
                                        <?php
										echo form_dropdown('sso_protocol', array('saml'=> 'saml','oidc' => 'oidc'), $this->config->item('sso_protocol'),'id="sso_protocol" class="sso_protocol form-select form-select-solid"');
									?>



                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>
                </div>


                <div id="saml_config" style="display: none;">



                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_saml_single_sign_on_service')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'saml_single_sign_on_service',
									'id'=>'saml_single_sign_on_service',
									'value'=>$this->config->item('saml_single_sign_on_service')));?>



                                        </div>
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_saml_single_logout_service')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'saml_single_logout_service',
									'id'=>'saml_single_logout_service',
									'value'=>$this->config->item('saml_single_logout_service')));?>



                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_saml_x509_cert')); ?></label>
                                            <?php echo form_textarea(array(
									'name'=>'saml_x509_cert',
									'id'=>'saml_x509_cert',
									'class'=>'form-control form-control-solid text-area',
									'rows'=>'4',
									'cols'=>'30',
									'value'=>$this->config->item('saml_x509_cert')));?>



                                        </div>
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_saml_idp_entity_id')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'saml_idp_entity_id',
									'id'=>'saml_idp_entity_id',
									'value'=>$this->config->item('saml_idp_entity_id')));?>



                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_saml_name_id_format')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'saml_name_id_format',
									'id'=>'saml_name_id_format',
									'value'=>$this->config->item('saml_name_id_format')));?>



                                        </div>
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_saml_groups_field')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'saml_groups_field',
									'id'=>'saml_groups_field',
									'value'=>$this->config->item('saml_groups_field')));?>



                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_saml_locations_field')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'saml_locations_field',
									'id'=>'saml_locations_field',
									'value'=>$this->config->item('saml_locations_field')));?>



                                        </div>
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_saml_first_name_field')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'saml_first_name_field',
									'id'=>'saml_first_name_field',
									'value'=>$this->config->item('saml_first_name_field')));?>



                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_saml_last_name_field')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'saml_last_name_field',
									'id'=>'saml_last_name_field',
									'value'=>$this->config->item('saml_last_name_field')));?>



                                        </div>
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_saml_email_field')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'saml_email_field',
									'id'=>'saml_email_field',
									'value'=>$this->config->item('saml_email_field')));?>



                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>








                </div>


                <div id="oidc_config" style="display: none;">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_oidc_host')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'oidc_host',
									'id'=>'oidc_host',
									'value'=>$this->config->item('oidc_host')));?>



                                        </div>
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_oidc_client_id')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'oidc_client_id',
									'id'=>'oidc_client_id',
									'value'=>$this->config->item('oidc_client_id')));?>



                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_oidc_host')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'oidc_host',
									'id'=>'oidc_host',
									'type' => 'password',
									
									'value'=>$this->config->item('oidc_host')));?>



                                        </div>
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_oidc_cert_url')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'oidc_cert_url',
									'id'=>'oidc_cert_url',
									'value'=>$this->config->item('oidc_cert_url')));?>



                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_oidc_additional_scopes')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'oidc_additional_scopes',
									'id'=>'oidc_additional_scopes',
									'value'=>$this->config->item('oidc_additional_scopes')));?>



                                        </div>
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_oidc_username_field')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'oidc_username_field',
									'id'=>'oidc_username_field',
									'value'=>$this->config->item('oidc_username_field')));?>



                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_oidc_groups_field')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'oidc_groups_field',
									'id'=>'oidc_groups_field',
									'value'=>$this->config->item('oidc_groups_field')));?>



                                        </div>
                                        <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_oidc_locations_field')); ?></label>
                                            <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'oidc_locations_field',
									'id'=>'oidc_locations_field',
									'value'=>$this->config->item('oidc_locations_field')));?>



                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>













                </div>




                <div class="col-md-12">
                    <div class="py-5 mb-5">
                        <div class="rounded border p-10">


                            <div class="mb-10">
                                <div class="form-check" data-keyword="<?php echo H(lang('config_sso_info')) ?>">

                                    <?php echo form_checkbox(array(
								'name'=>'only_allow_sso_logins',
								'id'=>'only_allow_sso_logins',
								'value'=>'1',
								'class' => 'form-check-input',
								'checked'=>$this->config->item('only_allow_sso_logins')));?>

                                    <label class="form-check-label" for="flexCheckDefault">
                                        <?php echo form_label(lang('config_oidc_groups_field')); ?></label>

                                </div>



                            </div>


                        </div>
                    </div>

                </div>

                <script>
                function sso_protocol_check() {
                    if ($("#sso_protocol").val() == 'saml') {
                        $("#saml_config").show();
                        $("#oidc_config").hide();
                    } else {
                        $("#saml_config").hide();
                        $("#oidc_config").show();
                    }
                }
                $("#sso_protocol").change(sso_protocol_check);
                sso_protocol_check();
                </script>


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->
                

                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> <?php echo create_section(lang('config_quickbooks_settings'), 'store-configuration-options', 'section-api-settings')  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_quickbooks_settings" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                        <div class="text-center">
                    <?php if ($this->config->item('quickbooks_access_token') && $this->config->item('quickbooks_access_token')){ ?>
                    <a href="<?php echo site_url('quickbooks/refresh_tokens/1');?>"
                        class="btn btn-primary"><?php echo lang('config_refresh_tokens'); ?></a>
                    <br />
                    <br />
                    <a href="<?php echo site_url('quickbooks/oauth');?>"
                        class="btn btn-primary"><?php echo lang('config_reconnect_quickbooks'); ?></a>
                    <br />
                    <br />
                    <button id="reset_quickbooks" type="button" class="btn btn-lg btn-danger">
                        <?php echo lang('config_reset_quickbooks');?></button>
                    <br />
                    <br />

                    <?php } else { ?>
                    <a href="<?php echo site_url('quickbooks/oauth');?>"
                        class="btn btn-primary"><?php echo lang('config_connect_to_qb_online'); ?></a>
                    <?php } ?>
                    <br />
                    <br />
                </div>

                <div class="form-group" data-keyword="<?php echo H(lang('common_quickbooks')) ?>">
                    <?php echo form_label(lang('config_qb_sync_operations').':', 'qb_sync_operations',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10 qb_sync_operations">
                        <ul id="check-list-box" data-name="qb_sync_operations[]" class="list-group checked-list-box">
                            <li class="list-group-item" data-value="export_journalentry_to_quickbooks"
                                data-color="success">
                                <?php echo lang('config_export_journalentry_to_quickbooks'); ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="form-group" data-keyword="<?php echo H(lang('common_quickbooks')) ?>">
                    <?php
												echo form_label(lang('config_qb_sync_logs').':', 'qb_sync_logs',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <ul>
                            <?php
														foreach($this->Appfile->get_files_with_name('quickbooks_log.txt') as $file) 
														{
																echo '<li>'.anchor($this->Appfile->get_url_for_file($file['file_id']),date(get_date_format().' '.get_time_format(), strtotime($file['timestamp'])),array('target' => '_blank')).'</li>';
														} 
														?>
                        </ul>
                    </div>
                </div>

                <div id="quickbooks_sync_progress" class="form-group hidden"
                    data-keyword="<?php echo H(lang('common_quickbooks')) ?>">
                    <?php echo form_label(lang('config_quickbooks_progress').':', 'quickbooks_progress',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <div class="well well-sm">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active" id="quickbooks_progessbar"
                                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                    style="width:0%">
                                    <span id="quickbooks_progress_percent">0</span>% <span
                                        id="quickbooks_progress_message"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="py-5 mb-5">
                        <div class="rounded border p-10">


                            <div class="mb-10">
                                <div class="form-check" data-keyword="<?php echo H(lang('common_quickbooks')) ?>">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        <?php echo form_label(lang('qb_export_start_date')); ?></label>
                                    <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
									'name'=>'export_start_date',
									'id'=>'export_start_date',
									'value'=>$this->config->item('qb_export_start_date')));?>



                                </div>
                                <div class="form-check" data-keyword="<?php echo H(lang('common_quickbooks')) ?>">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        <?php echo form_label(lang('config_last_sync_date')); ?></label>
                                    <div class="input-group">
                                        <input readonly type="text" class="form-control form-control-solid  form-inps"
                                            placeholder="<?php echo lang('config_last_qb_sync_date'); ?>"
                                            name="qb_sync_date" id="qb_sync_date"
                                            value="<?php echo $this->config->item('last_qb_sync_date') ?  date(get_date_format().' '.get_time_format(),strtotime($this->config->item('last_qb_sync_date'))) : ''; ?>"
                                            aria-describedby="input-group-btn">
                                        <span class="input-group-btn">
                                            <button id="sync_qb" type="button" class="btn btn-lg  btn-warning"><span
                                                    id="sync_qb_button_icon" class="glyphicon glyphicon-refresh"></span>
                                                <?php echo lang('config_sync');?></button>
                                        </span>

                                        <span class="input-group-btn hidden" id="qb-cancel-button">
                                            <button id="cancel_qb" type="button" class="btn btn-lg btn-danger">
                                                <?php echo lang('common_cancel');?></button>
                                        </span>

                                    </div>


                                </div>


                            </div>


                        </div>
                    </div>

                </div>
                      


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">  <?php echo create_section(lang('config_ecommerce_settings_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_ecommerce_settings_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                                        
                <div class="row">
                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_ecommerce_platform')); ?></label>
                                        <?php
											echo form_dropdown('ecommerce_platform', $ecommerce_platforms, $this->config->item('ecommerce_platform'),'id="ecommerce_platform" class="ecommerce_platform form-select form-select-solid"');
										?>



                                    </div>

                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_sku_sync_field')); ?></label>
                                        <?php echo form_dropdown('sku_sync_field', array(
								'item_number'  => lang('common_item_number_expanded'),
								'product_id'    => lang('common_product_id'),
								'item_id'   => lang('common_item_id')
								),
								$this->config->item('sku_sync_field') ? $this->config->item('sku_sync_field') : 'item_number', 'class="form-select form-select-solid" id="sku_sync_field"')
								?>



                                    </div>

                                </div>


                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">

                                        <?php echo form_checkbox(array(
									'name'=>'do_not_upload_images_to_ecommerce',
									'id'=>'do_not_upload_images_to_ecommerce',
									'value'=>'1',
									'class' => 'form-check-input',
									'checked'=>$this->config->item('do_not_upload_images_to_ecommerce')));?>

                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_do_not_upload_images_to_ecommerce')); ?></label>

                                    </div>

                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">

                                        <?php echo form_checkbox(array(
									'name'=>'ecommerce_only_sync_completed_orders',
									'id'=>'ecommerce_only_sync_completed_orders',
									'value'=>'1',
									'class' => 'form-check-input',
									'checked'=>$this->config->item('ecommerce_only_sync_completed_orders')));?>

                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_ecommerce_only_sync_completed_orders')); ?></label>

                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">

                                        <?php echo form_checkbox(array(
									'name'=>'import_ecommerce_orders_suspended',
									'id'=>'import_ecommerce_orders_suspended',
									'value'=>'1',
									'class' => 'form-check-input',
									'checked'=>$this->config->item('import_ecommerce_orders_suspended')));?>

                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_import_ecommerce_orders_suspended')); ?></label>

                                    </div>

                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">

                                        <?php echo form_checkbox(array(
									'name'=>'new_items_are_ecommerce_by_default',
									'id'=>'new_items_are_ecommerce_by_default',
									'value'=>'1',
									'class' => 'form-check-input',
									'checked'=>$this->config->item('new_items_are_ecommerce_by_default')));?>

                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_new_items_are_ecommerce_by_default')); ?></label>

                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">

                                        <?php echo form_checkbox(array(
									'name'=>'use_main_image_as_default_image_in_e_commerce',
									'id'=>'use_main_image_as_default_image_in_e_commerce',
									'value'=>'1',
									'class' => 'form-check-input',
									'checked'=>$this->config->item('use_main_image_as_default_image_in_e_commerce')));?>

                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_use_main_image_as_default_image_in_e_commerce')); ?></label>

                                    </div>

                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_store_location')); ?></label>
                                        <?php
											echo form_dropdown('ecom_store_location', $store_locations, $this->config->item('ecom_store_location'), 'class="form-select form-select-solid"');
										?>



                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>
                </div>









                <div class="row">
                    <?php						
							foreach($store_locations as $r_location_id=>$r_location_name)
							{
							?>
                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">

                                        <?php echo form_checkbox(array(
									'name'=>'ecommerce_locations[]',
									'class' =>'form-check-input',
									'id'=>"location_".$r_location_id,
									'value'=>$r_location_id,
									'checked'=>isset($ecommerce_locations[$r_location_id])))?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_sync_inventory_from_location')); ?></label>

                                    </div>




                                </div>


                            </div>
                        </div>

                    </div>
                    <?php	
							}
							?>
                </div>





                <?php if(count($online_price_tiers) > 1) { ?>
                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">
                    <?php
									echo form_label(lang('config_online_price_tier').':', 'online_price_tier',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php 
											echo form_dropdown('online_price_tier', $online_price_tiers, $this->config->item('online_price_tier'), 'class="form-control"');
										?>
                    </div>
                </div>
                <?php } ?>


                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">
                    <?php echo form_label(lang('config_ecommerce_cron_sync_operations').':', 'ecommerce_cron_sync_operations',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10 ecommerce_cron_sync_operations">
                        <ul id="check-list-box" data-name="ecommerce_cron_sync_operations[]"
                            class="list-group checked-list-box">
                            <li class="list-group-item" data-value="sync_inventory_changes" data-color="success">
                                <?php echo lang('config_sync_inventory_changes'); ?></li>
                            <li class="list-group-item woo-only" data-value="import_ecommerce_tags_into_phppos"
                                data-color="success">
                                <?php echo lang('config_import_ecommerce_tags_into_phppos'); ?>
                            </li>
                            <li class="list-group-item woo-only" data-value="import_ecommerce_categories_into_phppos"
                                data-color="success">
                                <?php echo lang('config_import_ecommerce_categories_into_phppos'); ?></li>
                            <li class="list-group-item woo-only" data-value="import_ecommerce_attributes_into_phppos"
                                data-color="success">
                                <?php echo lang('config_import_ecommerce_attributes_into_phppos'); ?></li>
                            <li class="list-group-item woo-only" data-value="import_tax_classes_into_phppos"
                                data-color="success">
                                <?php echo lang('config_import_tax_classes_into_phppos'); ?>
                            </li>
                            <li class="list-group-item woo-only" data-value="import_shipping_classes_into_phppos"
                                data-color="success">
                                <?php echo lang('config_import_shipping_classes_into_phppos'); ?></li>
                            <li class="list-group-item" data-value="import_ecommerce_items_into_phppos"
                                data-color="success">
                                <?php echo lang('config_import_ecommerce_items_into_phppos'); ?></li>
                            <li class="list-group-item" data-value="import_ecommerce_orders_into_phppos"
                                data-color="success">
                                <?php echo lang('config_import_ecommerce_orders_into_phppos'); ?></li>
                            <li class="list-group-item woo-only" data-value="export_phppos_tags_to_ecommerce"
                                data-color="success">
                                <?php echo lang('config_export_phppos_tags_to_ecommerce'); ?>
                            </li>
                            <li class="list-group-item" data-value="export_phppos_categories_to_ecommerce"
                                data-color="success">
                                <?php echo lang('config_export_phppos_categories_to_ecommerce'); ?></li>
                            <li class="list-group-item woo-only" data-value="export_phppos_attributes_to_ecommerce"
                                data-color="success">
                                <?php echo lang('config_export_phppos_attributes_to_ecommerce'); ?></li>
                            <li class="list-group-item woo-only" data-value="export_tax_classes_into_phppos"
                                data-color="success">
                                <?php echo lang('config_export_tax_classes_into_phppos'); ?>
                            </li>
                            <li class="list-group-item" data-value="export_phppos_items_to_ecommerce"
                                data-color="success">
                                <?php echo lang('config_export_phppos_items_to_ecommerce'); ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">
                    <?php
									echo form_label(lang('config_ecom_sync_logs').':', 'ecom_sync_logs',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <ul>
                            <?php
										foreach($this->Appfile->get_files_with_name('ecom_log.txt') as $file) 
										{
											echo '<li>'.anchor($this->Appfile->get_url_for_file($file['file_id']),date(get_date_format().' '.get_time_format(), strtotime($file['timestamp'])),array('target' => '_blank')).'</li>';
										} 
										?>
                        </ul>
                    </div>
                </div>

                <div id="ecommerce_sync_progress" class="form-group hidden"
                    data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">
                    <?php echo form_label(lang('config_ecommerce_progress').':', 'ecommerce_progress',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <div class="well well-sm">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active" id="ecommerce_progessbar"
                                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                    style="width:0%">
                                    <span id="ecommerce_progress_percent">0</span>% <span
                                        id="ecommerce_progress_message"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_last_sync_date')); ?></label>
                                        <div class="input-group">
                                            <input readonly type="text" class="form-control form-inps"
                                                placeholder="<?php echo lang('config_last_sync_date'); ?>"
                                                name="ecommerce_sync_date" id="ecommerce_sync_date"
                                                value="<?php echo $this->config->item('last_ecommerce_sync_date') ?  date(get_date_format().' '.get_time_format(),strtotime($this->config->item('last_ecommerce_sync_date'))) : ''; ?>"
                                                aria-describedby="input-group-btn">
                                            <span class="input-group-btn">
                                                <button id="sync_woo" type="button"
                                                    class="btn btn-lg  btn-warning"><span id="sync_woo_button_icon"
                                                        class="glyphicon glyphicon-refresh"></span>
                                                    <?php echo lang('config_sync');?></button>
                                            </span>

                                            <span class="input-group-btn hidden" id="ecommerce-cancel-button">
                                                <button id="cancel_woo" type="button" class="btn btn-lg btn-danger">
                                                    <?php echo lang('common_cancel');?></button>
                                            </span>

                                        </div>

                                    </div>




                                </div>


                            </div>
                        </div>

                    </div>
                </div>



                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_ecommerce')) ?>">
                    <?php
									echo form_label(lang('config_reset_ecommerce').':', 'reset_ecommerce',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <button id="reset_ecommerce" type="button" class="btn btn-lg btn-danger">
                            <?php echo lang('config_reset_ecommerce');?></button>
                    </div>
                </div>


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                <?php
		
		if($this->config->item('ecommerce_platform') == "woocommerce" )
			$woo_hidden_class ="";
		else
			$woo_hidden_class="hidden";

		if($this->config->item('ecommerce_platform') == "shopify" )
			$shopify_hidden_class ="";
		else
			$shopify_hidden_class="hidden";
		
		?>
                  <!--begin::Sign-in Method-->
                  <div class="card mb-5 mb-xl-10 <?php echo $shopify_hidden_class; ?>">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">  <?php echo create_section(lang('config_shopify_settings_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_shopify_settings_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                        <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_woocommerce')) ?>">


                <?php if (!is_on_saas_host()) { ?>
                <?php
				if (!$this->config->item('shopify_public') || !$this->config->item('shopify_private'))
				{
				?>
                <h3 style="text-align: center;">
                    <?php echo 'E-mail <a href="mailto:support@phpsalesmanager.com">support@phpsalesmanager.com</a> to obtain these values'?>
                </h3>
                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_woocommerce')) ?>">
                    <?php echo form_label(lang('shopify_public_key').':', 'shopify_public',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_input(array(
								'class'=>'form-control form-inps',
								'name'=>'shopify_public',
								'id'=>'shopify_public',
								'value'=>$this->config->item('shopify_public')));?>
                    </div>
                </div>

                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_woocommerce')) ?>">
                    <?php echo form_label(lang('shopify_private_key').':', 'shopify_private',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_input(array(
								'class'=>'form-control form-inps',
								'name'=>'shopify_private',
								'id'=>'shopify_private',
								'value'=>$this->config->item('shopify_private')));?>
                    </div>
                </div>
                <?php
			}
		}
	
			echo form_hidden('shopify_shop',$this->config->item('shopify_shop'));
			
			if ($this->config->item('shopify_shop'))
			{
			?>
                <div class='text-center'>
                    <p><?php echo lang('config_connected_to_shopify')?>
                        [<strong><?php echo $this->config->item('shopify_shop').'.myshopify.com' ?></strong>]
                    </p>
                    <br />
                    <br />
                    <?php
					if ($this->config->item('shopify_charge_id'))
					{
					?>

                    <br />
                    <br />

                    <?php
					if ($this->config->item('shopify_code'))
					{
					?>
                    <a href="<?php echo site_url('ecommerce/oauth_shopify_disconnect/0');?>" class="btn btn-danger"
                        id="shopify_oauth_disconnect"><?php echo lang('config_disconnect_to_shopify'); ?></a>
                    <?php
					}
					else
					{
					?>
                    <a href="<?php echo site_url('ecommerce/oauth_shopify');?>" class="btn btn-success"
                        id="shopify_oauth_connectt"><?php echo lang('config_reconnect_to_shopify'); ?></a>
                    <?php
					}
					?>

                    <br />
                    <br />

                    <a href="<?php echo site_url('ecommerce/cancel_shopify_billing');?>" class="btn btn-danger"
                        id="shopify_cancel_billing"><?php echo lang('config_cancel_shopify'); ?></a>
                    <script>
                    $("#shopify_cancel_billing").click(function(e) {
                        e.preventDefault();

                        bootbox.confirm(
                            <?php echo json_encode(lang('config_confirm_cancel_shopify')); ?>,
                            function(response) {
                                if (response) {
                                    window.location = $("#shopify_cancel_billing").attr('href');
                                }
                            });

                    })
                    </script>
                    <?php	
					}
					else
					{
					?>
                    <a href="<?php echo site_url('ecommerce/activate_shopify_billing');?>" class="btn btn-success"
                        id="shopify_activate_billing"><?php echo str_replace('{SHOPIFY_PRICE}',SHOPIFY_PRICE,lang('config_shopify_billing_terms')); ?></a>
                    <br /><br />
                    <a href="<?php echo site_url('ecommerce/oauth_shopify_disconnect');?>" class="btn btn-danger"
                        id="shopify_oauth_disconnect"><?php echo lang('config_disconnect_to_shopify'); ?></a>

                    <?php
					}
					?>

                </div>

                <?php
				}
				else
				{
					?>
                <div class='text-center'>
                    <?php
					if ($this->config->item('shopify_charge_id'))
					{
					?>

                    <br /><br />
                    <a href="<?php echo site_url('ecommerce/oauth_shopify');?>" class="btn btn-success"
                        id="shopify_oauth_connectt"><?php echo lang('config_reconnect_to_shopify'); ?></a>
                    <br /><br />
                    <?php
					}
				?>
                    <p><a href="https://apps.shopify.com/php-point-of-sale"
                            target="_blank"><?php echo lang('config_connect_shopify_in_app_store')?></a></p>
                    <br />
                    <br />
                </div>

                <?php
				}
				?>
            </div>

            <script>
            $("#shopify_oauth").click(function(e) {
                e.preventDefault();
                var url = $(th_pis).attr('href');
                $("#config_form").ajaxSubmit(function() {
                    window.location = url;
                });
            });
            </script>


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                <!--begin::Sign-in Method-->
                <div class="card mb-5 mb-xl-10 <?php echo $woo_hidden_class; ?>">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> <?php echo create_section(lang('config_woocommerce_settings_info'))  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_woocommerce_settings_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                        <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_woocommerce')) ?>">
                    <?php echo form_label(lang('config_woo_version').':', 'woo_version',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php
										echo form_dropdown('woo_version', $woo_versions, $this->config->item('woo_version'),'id="woo_version" class="woo_version form-control"');
									?>
                    </div>
                </div>

                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_woocommerce')) ?>">
                    <?php echo form_label(lang('config_woo_api_url').':', 'woo_api_url',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_input(array(
									'class'=>'form-control form-inps',
									'name'=>'woo_api_url',
									'id'=>'woo_api_url',
									'value'=>$this->config->item('woo_api_url')));?>
                    </div>
                </div>

                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_woocommerce')) ?>">
                    <?php echo form_label(lang('config_woo_api_key').':', 'woo_api_key',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_input(array(
											'class'=>'form-control form-inps',
										'name'=>'woo_api_key',
										'id'=>'woo_api_key',
										'value'=>$this->config->item('woo_api_key')));?>
                    </div>
                </div>

                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_woocommerce')) ?>">
                    <?php echo form_label(lang('config_woo_api_secret').':', 'woo_api_secret',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_input(array(
											'class'=>'form-control form-inps',
										'name'=>'woo_api_secret',
										'id'=>'woo_api_secret',
										'value'=>$this->config->item('woo_api_secret')));?>
                    </div>
                </div>


                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                    <?php echo form_label(lang('config_import_all_past_orders_for_woo_commerce').':', 'import_all_past_orders_for_woo_commerce',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_checkbox(array(
									'name'=>'import_allast_orders_for_woo_commerce',
									'id'=>'import_all_past_orders_for_woo_commerce',
									'value'=>'1',
									'checked'=>$this->config->item('import_all_past_orders_for_woo_commerce')));?>
                        <label for="import_all_past_orders_for_woo_commerce"><span></span></label>
                    </div>
                </div>



                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                    <?php echo form_label(lang('config_woo_enable_html_desc').':', 'woo_enable_html_desc',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_checkbox(array(
									'name'=>'woo_enable_html_desc',
									'id'=>'woo_enable_html_desc',
									'value'=>'1',
									'checked'=>$this->config->item('woo_enable_html_desc')));?>
                        <label for="woo_enable_html_desc"><span></span></label>
                    </div>
                </div>


                <div class="form-group" data-keyword="<?php echo H(lang('config_keyword_sales')) ?>">
                    <?php echo form_label(lang('config_do_not_treat_service_items_as_virtual').':', 'do_not_treat_service_items_as_virtual',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_checkbox(array(
									'name'=>'do_not_treat_service_items_as_virtual',
									'id'=>'do_not_treat_service_items_as_virtual',
									'value'=>'1',
									'checked'=>$this->config->item('do_not_treat_service_items_as_virtual')));?>
                        <label for="do_not_treat_service_items_as_virtual"><span></span></label>
                    </div>
                </div>
                      


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                <!--begin::Sign-in Method-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> <?php echo create_section(lang('config_api_settings_info'), 'store-configuration-options', 'section-api-settings')  ?> </h3>
                        <a href="https://<?php echo $this->config->item('branding')['domain']; ?>/api.php"
                onclick="window.open('https://<?php echo $this->config->item('branding')['domain']; ?>/api.php', '_blank', 'width=800,height=600,scrollbars=yes,menubar=no,status=yes,resizable=yes,screenx=0,screeny=0'); return false;">
                <span class="glyphicon glyphicon-info-sign"></span></a>  
                    </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_api_settings_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                        <div class="col-md-12">
                    <div class="py-5 mb-5">
                        <div class="rounded border p-10">


                            <div class="mb-10">
                                <div class="form-check" data-keyword="<?php echo H(lang('config_keyword_api')) ?>">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        <?php echo form_label(lang('config_api_keys')); ?></label>
                                    <div class="input-group">
                                        <div class="table-responsive">
                                            <table id="api_keys" class="table">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo lang('common_description'); ?></th>
                                                        <th><?php echo lang('config_api_key_ending_in'); ?></th>
                                                        <th><?php echo lang('config_permissions'); ?></th>
                                                        <th><?php echo lang('common_delete'); ?></th>
                                                    </tr>
                                                </thead>

                                                <tbody id="api_keys_body">
                                                    <?php foreach($api_keys as $key) { ?>
                                                    <tr>
                                                        <td><?php echo $key->description;?></td>
                                                        <td>...<?php echo $key->key_ending; ?></td>
                                                        <td>
                                                            <?php	echo  $key->level == 1 ? lang('config_read') : lang('config_read_write'); ?>
                                                        </td>
                                                        <td><a class="delete_api_key" href="javascript:void(0);"
                                                                data-key-id='<?php echo $key->id; ?>'><?php echo lang('common_delete'); ?></a>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                            <a tabindex="-1" class="btn btn-sm btn-primary"
                                                href="<?php echo site_url('config/add_api_key');?>" data-toggle="modal"
                                                data-target="#myModal"
                                                data-toggle="model"><?php echo lang('config_add_key'); ?></a>
                                        </div>

                                    </div>

                                </div>




                            </div>


                        </div>
                    </div>

                </div>


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                 <!--begin::Sign-in Method-->
                 <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> <?php echo create_section(lang('config_webhooks'), 'store-configuration-options', 'section-webhooks-settings')  ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_webhooks" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                      
                <div class="row">
                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_new_customer_web_hook')); ?></label>
                                        <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
								
									'name'=>'new_customer_web_hook',
									'id'=>'new_customer_web_hook',
									'placeholder' => 'http://URL',
									'value'=>$this->config->item('new_customer_web_hook')));?>



                                    </div>
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_new_sale_web_hook')); ?></label>
                                        <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
								
									'name'=>'new_sale_web_hook',
									'id'=>'new_sale_web_hook',
									'placeholder' => 'http://URL',
									'value'=>$this->config->item('new_sale_web_hook')));?>



                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_new_receiving_web_hook')); ?></label>
                                        <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
								
									'name'=>'new_receiving_web_hook',
									'id'=>'new_receiving_web_hook',
									'placeholder' => 'http://URL',
									'value'=>$this->config->item('new_receiving_web_hook')));?>



                                    </div>
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_edit_customer_web_hook')); ?></label>
                                        <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
								
									'name'=>'edit_customer_web_hook',
									'id'=>'edit_customer_web_hook',
									'placeholder' => 'http://URL',
									'value'=>$this->config->item('edit_customer_web_hook')));?>



                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_edit_sale_web_hook')); ?></label>
                                        <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
								
									'name'=>'edit_sale_web_hook',
									'id'=>'edit_sale_web_hook',
									'placeholder' => 'http://URL',
									'value'=>$this->config->item('edit_sale_web_hook')));?>



                                    </div>
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_keyword_store_accounts')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_edit_recv_web_hook')); ?></label>
                                        <?php echo form_input(array(
									'class'=>'form-control form-control-solid form-inps',
								
									'name'=>'edit_recv_web_hook',
									'id'=>'edit_recv_web_hook',
									'placeholder' => 'http://URL',
									'value'=>$this->config->item('edit_recv_web_hook')));?>



                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>
                </div>



                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->


                <!--begin::Sign-in Method-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0"> <?php echo lang('config_work_order'); ?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_work_order" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                                            
                <div class="row">
                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_work_order_notes_internal')) ?>">

                                        <?php echo form_checkbox(array(
										'name'=>'work_order_notes_internal',
										'id'=>'work_order_notes_internal',
										'value'=>'work_order_notes_internal',
										'class' => 'form-check-input',
										'checked'=>$this->config->item('work_order_notes_internal')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_work_order_notes_internal')); ?></label>


                                    </div>
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_work_repair_item_taxable')) ?>">

                                        <?php echo form_checkbox(array(
										'name'=>'work_repair_item_taxable',
										'id'=>'work_repair_item_taxable',
										'value'=>'work_repair_item_taxable',
										'class' => 'form-check-input',
										'checked'=>$this->config->item('work_repair_item_taxable')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_work_repair_item_taxable')); ?></label>


                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_work_order_notes_internal')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_work_order_device_locations')); ?></label>
                                        <?php echo form_input(array(
										'class'=>'form-control form-control-solid form-inps',
										'name'=>'work_order_device_locations',
										'id'=>'work_order_device_locations',
										'size'=> 40,
										'value'=>$this->config->item('work_order_device_locations')));?>



                                    </div>
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_default_tech_is_logged_employee')) ?>">

                                        <?php echo form_checkbox(array(
										'name'=>'default_tech_is_logged_employee',
										'id'=>'default_tech_is_logged_employee',
										'value'=>'default_tech_is_logged_employee',
										'class' => 'form-check-input',
										'checked'=>$this->config->item('default_tech_is_logged_employee')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_work_repair_item_taxable')); ?></label>


                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_work_order_notes_internal')) ?>">
                                        <?php echo form_checkbox(array(
										'name'=>'hide_repair_items_in_sales_interface',
										'id'=>'hide_repair_items_in_sales_interface',
										'value'=>'hide_repair_items_in_sales_interface',
										'class' => 'form-check-input',
										'checked'=>$this->config->item('hide_repair_items_in_sales_interface')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_hide_repair_items_in_sales_interface')); ?></label>


                                    </div>
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_default_tech_is_logged_employee')) ?>">

                                        <?php echo form_checkbox(array(
										'name'=>'hide_repair_items_on_receipt',
										'id'=>'hide_repair_items_on_receipt',
										'value'=>'hide_repair_items_on_receipt',
										'class' => 'form-check-input',
										'checked'=>$this->config->item('hide_repair_items_on_receipt')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_hide_repair_items_on_receipt')); ?></label>


                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_work_order_notes_internal')) ?>">
                                        <?php echo form_checkbox(array(
										'name'=>'show_item_description_service_tag',
										'id'=>'show_item_description_service_tag',
										'value'=>'show_item_description_service_tag',
										'class' => 'form-check-input',
										'checked'=>$this->config->item('show_item_description_service_tag')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_show_item_description_service_tag')); ?></label>


                                    </div>
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_default_tech_is_logged_employee')) ?>">

                                        <?php echo form_checkbox(array(
										'name'=>'show_phone_number_service_tag',
										'id'=>'show_phone_number_service_tag',
										'value'=>'show_phone_number_service_tag',
										'class' => 'form-check-input',
										'checked'=>$this->config->item('show_phone_number_service_tag')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_show_phone_number_service_tag')); ?></label>


                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_work_order_notes_internal')) ?>">
                                        <?php echo form_checkbox(array(
										'name'=>'change_work_order_status_from_sales',
										'id'=>'change_work_order_status_from_sales',
										'value'=>'change_work_order_status_from_sales',
										'class' => 'form-check-input',
										'checked'=>$this->config->item('change_work_order_status_from_sales')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_change_work_order_status_from_sales')); ?></label>


                                    </div>
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_default_tech_is_logged_employee')) ?>">

                                        <?php echo form_checkbox(array(
										'name'=>'work_order_warranty_checked_product_price_zero',
										'id'=>'work_order_warranty_checked_product_price_zero',
										'value'=>'work_order_warranty_checked_product_price_zero',
										'class' => 'form-check-input',
										'checked'=>$this->config->item('work_order_warranty_checked_product_price_zero')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_work_order_warranty_checked_product_price_zero')); ?></label>


                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_work_order_notes_internal')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_work_order_change_status_on_sales_complete')); ?></label>
                                        <?php echo form_dropdown('work_order_status_on_complete', $work_order_status, $this->config->item('work_order_status_on_complete'), 'class="form-select form-select-solid" id="work_order_status_on_complete"'); ?>




                                    </div>



                                </div>


                            </div>
                        </div>

                    </div>
                </div>




                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->

                <?php 
			if($this->config->item('branding')['code'] == 'phpsalesmanager'){
			?>

                <!--begin::Sign-in Method-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                        <h3 class="fw-bold m-0">   <?php echo lang('config_lookup_api_integration');?> </h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="config_lookup_api_integration" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                      
                <div class="row">
                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_default_tech_is_logged_employee')) ?>">

                                        <?php echo form_checkbox(array(
										'name'=>'config_enable_ig_integration',
										'id'=>'config_enable_ig_integration',
										'value'=>'1',
										'class' => 'form-check-input',
										'checked'=>$this->config->item('config_enable_ig_integration')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_enable_ig_integration')); ?></label>


                                    </div>
                                    <?php
							if(!is_on_saas_host()) { 
							?>
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_work_order_notes_internal')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_ig_api_bearer_token')); ?></label>
                                        <?php echo form_input(array(
										'class'=>'form-control form-control-solid form-inps',
										'name'=>'ig_api_bearer_token',
										'id'=>'ig_api_bearer_token',
										
										'value'=>$this->config->item('ig_api_bearer_token')));?>

                                        <?php
							}
							?>
                                    </div>



                                </div>


                            </div>
                        </div>

                    </div>
					<div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                <div class="mb-10">
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_default_tech_is_logged_employee')) ?>">

                                        <?php echo form_checkbox(array(
										'name'=>'enable_wgp_integration',
										'id'=>'enable_wgp_integration',
										'value'=>'1',
										'class' => 'form-check-input',
										'checked'=>$this->config->item('enable_wgp_integration')));?>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_enable_wgp_integration')); ?></label>


                                    </div>
                                    <?php
							if(!is_on_saas_host()) { 
							?>
                                    <div class="form-check"
                                        data-keyword="<?php echo H(lang('config_work_order_notes_internal')) ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo form_label(lang('config_wgp_integration_pkey')); ?></label>
                                        <?php echo form_input(array(
										'class'=>'form-control form-control-solid form-inps',
										'name'=>'wgp_integration_pkey',
										'id'=>'wgp_integration_pkey',
										
										'value'=>$this->config->item('wgp_integration_pkey')));?>

                                        <?php
							}
							?>
                                    </div>



                                </div>


                            </div>
                        </div>

                    </div>
					
                </div>

              
                

               
               

                <?php
							//echo form_hidden('wgp_integration_userid',$this->config->item('wgp_integration_userid'));
							?>

                <br /><br /><br />

				<div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">


                                    <div class="mb-10">
                                        <div class="form-check"
                                            data-keyword="<?php echo H(lang('config_default_tech_is_logged_employee')) ?>">

                                            <?php echo form_checkbox(array(
                                            'name'=>'enable_p4_integration',
                                            'id'=>'enable_p4_integration',
                                            'value'=>'1',
                                            'class' => 'form-check-input',
                                            'checked'=>$this->config->item('enable_p4_integration')));?>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <?php echo form_label(lang('config_enable_p4_integration')); ?></label>


                                        </div>
                                        <?php
                                        if(!is_on_saas_host()) { 
                                        ?>
                                                <div class="form-check"
                                                    data-keyword="<?php echo H(lang('config_work_order_notes_internal')) ?>">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?php echo form_label(lang('config_p4_api_bearer_token')); ?></label>
                                                    <?php echo form_input(array(
                                                    'class'=>'form-control form-control-solid form-inps',
                                                    'name'=>'p4_api_bearer_token',
                                                    'id'=>'p4_api_bearer_token',
                                                    
                                                    'value'=>$this->config->item('p4_api_bearer_token')));?>

                                                    <?php
                                        }
                                        ?>
                                    </div>



                                </div>


                            </div>
                        </div>

                    </div>


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->



                <?php
			}
			?>



               


            
            </div>
            <!--end::Layout-->
        </div>




<div class="manage_buttons buttons-list config-page container">

</div>
<div class="text-center location-settings">
    <?php echo lang('config_looking_for_location_settings').' '.anchor($this->Location->count_all() > 1 ? 'locations' : 'locations/view/1', lang('module_locations').' '.lang('config_module'), 'class="btn btn-info"');?>
</div>





<div class="form-actions">
    <?php echo form_submit(array(
				'name'=>'submitf',
				'id'=>'submitf',
				'value'=>lang('common_save'),
				'class'=>'submit_button floating-button btn btn-primary btn-lg pull-right')); ?>
</div>

<?php echo form_close(); ?>
</div>
</div>

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true" style="bottom:90px">
			<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
			<span class="svg-icon">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->
<script type='text/javascript'>

$(document).ready(function() {
    console.log("loaded");
  // Listen for a click on the link with id 'scrollLink'
  $('.tab_link').on('click', function(e) {
    // Prevent the default action of the link
    e.preventDefault();
    
    // Get the href attribute of the link
    var targetId = $(this).attr('href');
    
    // Get the position of the target div
    var targetPosition = $(targetId).offset().top;
    
    // Scroll to the target position
    $('html, body').animate({
      scrollTop: targetPosition
    }, 1000); // The number here represents the time in milliseconds the scroll animation should take
  });
});


//validation and submit handling
$(document).ready(function() {

    date_time_picker_field($('.timepicker'), JS_TIME_FORMAT);
    date_time_picker_field($('.datepicker'), 'YYYY-MM-DD');

    $("#section_names").change(function(data) {
        var section_name = $(this).val();
        if (section_name == '') {
            $('html,body').animate({
                    scrollTop: 0,
                },
                'fast');
        } else {
            $('html,body').animate({
                    scrollTop: $('.' + section_name).offset().top - ($(".email_buttons").height() +
                        36),
                },
                'fast');

            $('.' + section_name + ' > .panel > .collapse').collapse('show');
        }

    });


    $("#test_email").click(function() {
        bootbox.prompt({
            title: <?php echo json_encode(lang('config_please_enter_email_to_send_test_to')); ?>,
            value: <?php echo json_encode($this->Location->get_info_for_key('email')); ?>,
            callback: function(email) {
                $("#config_form").ajaxSubmit(function() {
                    $.post(<?php echo json_encode(site_url('config/send_smtp_test_email')); ?>, {
                        email: email
                    }, function(response) {
                        if (response.success) {
                            show_feedback('success', response.message,
                                <?php echo json_encode(lang('common_success')); ?>
                            );
                        } else {
                            show_feedback('error',
                                <?php echo json_encode(lang('common_error')); ?>,
                                <?php echo json_encode(lang('common_error')); ?>
                            );
                            bootbox.alert({
                                title: <?php echo json_encode(lang('common_error')); ?>,
                                message: response.message
                            });
                        }
                    }, 'json');
                })

            }
        });
    });

    var gmail = {
        smtp_crypto: 'ssl',
        protocol: 'smtp',
        smtp_host: 'smtp.gmail.com',
        smtp_user: 'username@gmail.com',
        smtp_pass: '',
        smtp_port: '465',
        email_charset: 'utf-8',
        newline: 0,
        crlf: 0,
        smtp_timeout: '10'
    };

    var gmail_api = {
        smtp_crypto: 'ssl',
        protocol: 'smtp',
        smtp_host: 'smtp.gmail.com',
        smtp_user: 'username@gmail.com',
        smtp_pass: '',
        smtp_port: '465',
        email_charset: 'utf-8',
        newline: 0,
        crlf: 0,
        smtp_timeout: '10'
    };

    var office_365 = {
        smtp_crypto: 'tls',
        protocol: 'smtp',
        smtp_host: 'smtp.office365.com',
        smtp_user: 'user@domain.com',
        smtp_pass: '',
        smtp_port: '587',
        email_charset: 'utf-8',
        newline: 0,
        crlf: 0,
        smtp_timeout: '10'
    };

    var windows_live_hotmail = {
        smtp_crypto: 'tls',
        protocol: 'smtp',
        smtp_host: 'smtp.live.com',
        smtp_user: 'user@outlook.com',
        smtp_pass: '',
        smtp_port: '587',
        email_charset: 'utf-8',
        newline: 0,
        crlf: 0,
        smtp_timeout: '10'
    };

    var other = {
        smtp_crypto: '',
        protocol: '',
        smtp_host: '',
        smtp_user: 'user@domain.com',
        smtp_pass: '',
        smtp_port: '',
        email_charset: '',
        newline: 0,
        crlf: 0,
        smtp_timeout: ''
    };

    var system_default = {
        smtp_crypto: '',
        protocol: '',
        smtp_host: '',
        smtp_user: '',
        smtp_pass: '',
        smtp_port: '',
        email_charset: '',
        newline: 0,
        crlf: 0,
        smtp_timeout: ''
    };

    if ($("#email_provider").val() !== "Other") {
        $(".email_advanced").hide();
    }

    if ($("#email_provider").val() == "Use System Default") {
        $(".email_basic").hide();
    }

    if ($("#email_provider").val() == "Gmail API") {
        $(".email_basic").hide();
        $(".email_advanced").hide();
        $(".email_gmail_api").show();
    } else {
        $(".email_gmail_api").hide();
    }

    $("#email_provider").change(function(e) {
        $(".email_gmail_api").hide();

        switch ($("#email_provider").val()) {
            case 'Use System Default':
                $(".email_basic").hide();
                $(".email_advanced").hide();
                var settings = false;
                break;
            case 'Gmail':
                $(".email_basic").show();
                $(".email_advanced").hide();
                var settings = gmail;
                break;
            case 'Gmail API':
                $(".email_basic").hide();
                $(".email_advanced").hide();
                $(".email_gmail_api").show();
                var settings = gmail_api;
                break;
            case 'Office 365':
                $(".email_basic").show();
                $(".email_advanced").hide();
                var settings = office_365;
                break;
            case 'Windows Live Hotmail':
                $(".email_basic").show();
                $(".email_advanced").hide();
                var settings = windows_live_hotmail;
                break;
            case 'Other':
                var settings = other;
                $(".email_basic").show();
                $(".email_advanced").show();
                break;
        }

        if (settings) {
            for (var key in settings) {
                if (key == 'smtp_user') {
                    $("#" + key).val('');
                    $("#" + key).attr('placeholder', settings[key]);
                } else if (key == 'newline' || key == 'crlf') {
                    $("#" + key).prop('selectedIndex', settings[key]);
                } else {
                    $("#" + key).val(settings[key]);
                }
            }
        } else {
            for (var key in system_default) {
                if (key == 'newline' || key == 'crlf') {
                    $("#" + key).prop('selectedIndex', settings[key]);
                } else {
                    $("#" + key).val(settings[key]);
                }
            }
        }
    });

    // $("#gmail_credential_json").on('change', function(){
    // 	var file_data = $(this).prop('files')[0];

    // 	var fileread = new FileReader();
    // 	fileread.onload = function(e) {
    // 		var content = e.target.result;
    // 		var credential = JSON.parse(content); // Array of Objects.
    // 		// console.log(credential);
    // 		if(credential.web && credential.web.client_id){
    // 			$("#gmail_client_id").val(credential.web.client_id);
    // 		}
    // 		if(credential.web && credential.web.client_secret){
    // 			$("#gmail_client_secret").val(credential.web.client_secret);
    // 		}

    // 		document.getElementById("gmail_credential_json").value = "";
    // 	};
    // 	fileread.readAsText(file_data);
    // });

    $("#gmail_api_authorize_button").on('click', function() {
        event.preventDefault();
        var href = '<?php echo site_url("configGmailAPI/gmail_api_credential");?>';
        $.ajax({
            type: "POST",
            url: href,
            dataType: 'json',
            data: {},
            success: function(result) {
                // Reset the form.
                if (result.status == 1) {
                    authorize_dialog_window = window.open(result.authURL, '_blank',
                        'width=500,height=600');
                } else {
                    alert(result.error);
                }
            }
        });
    });

    $("#gmail_api_signout_button").on("click", function() {
        event.preventDefault();
        var href = '<?php echo site_url("configGmailAPI/gmail_api_signout");?>';
        $.ajax({
            type: "POST",
            url: href,
            dataType: 'json',
            data: {},
            success: function(result) {
                // Reset the form.
                if (result.status == 1) {
                    $("#gmail_api_signout_button").hide();
                    document.getElementById("gmail_api_authorize_button").style.display =
                        "inline-block";
                    show_feedback('success', result.message,
                        "<?php echo lang("gmail_api_success");?>");
                    $("#submitf").trigger("click");
                } else {
                    show_feedback('error', result.message,
                        "<?php echo lang("gmail_api_error");?>");
                }
            }
        });
    });

    $(".ecommerce_platform").change(function() {
        if ($(".ecommerce_platform").val() == "woocommerce") {
            $(".woo_settings").removeClass('hidden');
            $(".shopify_settings").addClass('hidden');
            $('.woo-only').show();
        } else {
            $(".woo_settings").addClass('hidden');
        }

        if ($(".ecommerce_platform").val() == "shopify") {
            $(".shopify_settings").removeClass('hidden');
            $(".woo_settings").addClass('hidden');
            $('.woo-only').hide();
        } else {
            $(".shopify_settings").addClass('hidden');
        }

    });

    if ($(".ecommerce_platform").val() == "woocommerce") {
        $('.woo-only').show();
    } else if ($(".ecommerce_platform").val() == "shopify") {
        $('.woo-only').hide();
    }

    $(document).on('keyup', ".default_percent_off", function(e) {

        if ($(this).val()) {
            $(this).parent().parent().find('.default_cost_plus_percent').val('');
            $(this).parent().parent().find('.default_cost_plus_fixed_amount').val('');
        }
    });

    $(document).on('keyup', ".default_cost_plus_percent", function(e) {
        if ($(this).val()) {
            $(this).parent().parent().find('.default_percent_off').val('');
            $(this).parent().parent().find('.default_cost_plus_fixed_amount').val('');
        }
    });

    $(document).on('keyup', ".default_cost_plus_fixed_amount", function(e) {
        if ($(this).val()) {
            $(this).parent().parent().find('.default_percent_off').val('');
            $(this).parent().parent().find('.default_cost_plus_percent').val('');
        }
    });


    $(".delete_tier").click(function() {
        $("#config_form").append('<input type="hidden" name="tiers_to_delete[]" value="' + $(this).data(
            'tier-id') + '" />');
        $(this).parent().parent().remove();
    });

    $(".delete_api_key").click(function() {
        var api_key_id = $(this).data('key-id');

        bootbox.confirm(<?php echo json_encode(lang('config_api_key_confirm_delete')); ?>, function(
            response) {
            if (response) {
                post_submit('<?php echo site_url("config/delete_key"); ?>', 'POST', [{
                    name: 'api_key_id',
                    value: api_key_id
                }]);
            }
        });
    });

    $("#price_tiers tbody").sortable();

    var add_index = -1;

    $("#add_tier").click(function() {
        $("#price_tiers tbody").append(
            '<tr><td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td><td><input type="text" class="tiers_to_edit form-control form-control-solid" data-index="' +
            add_index + '" name="tiers_to_edit[' + add_index +
            '][name]" value="" /></td><td><input type="text" class="tiers_to_edit form-control form-control-solid default_percent_off" data-index="' +
            add_index + '" name="tiers_to_edit[' + add_index +
            '][default_percent_off]" value=""/></td><td><input type="text" class="tiers_to_edit form-control form-control-solid default_cost_plus_percent" data-index="' +
            add_index + '" name="tiers_to_edit[' + add_index +
            '][default_cost_plus_percent]" value=""/></td><td><input type="text" class="tiers_to_edit form-control form-control-solid default_cost_plus_fixed_amount" data-index="' +
            add_index + '" name="tiers_to_edit[' + add_index +
            '][default_cost_plus_fixed_amount]" value=""/></td><td>&nbsp;</td></tr>');

        add_index--;
    });

    $('#additional_payment_types').selectize({
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
    });

    $(".delete_sale_type").click(function() {
        $("#config_form").append('<input type="hidden" name="sale_types_to_delete[]" value="' + $(this)
            .data('sale-type-id') + '" />');
        $(this).parent().parent().remove();
    });

    $("#sale_types tbody").sortable();

    var add_sale_type = -1;

    $("#add_sale_type").click(function() {
        $("#sale_types tbody").append(
            '<tr><td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td><td></td><td><input type="text" class="sale_types_to_edit form-control form-control-solid" data-index="' +
            add_sale_type + '" name="sale_types_to_edit[' + add_sale_type +
            '][name]" value="" /></td><td class="text-center"><input type="checkbox" name="sale_types_to_edit[' +
            add_sale_type + '][remove_quantity]" value="1" id="remove_quantity_' + add_sale_type +
            '" data-index="' + add_sale_type + '"><label for="remove_quantity_' + add_sale_type +
            '"><span></span></label></td><td>&nbsp;</td></tr>');
        add_sale_type--;
    });

    $('#additional_payment_types').selectize({
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
    });

    $('#damaged_reasons').selectize({
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
    })


    $(".delete_currency_denom").click(function() {
        var id = $(this).data('id');
        $("#currency_denoms").append(
            '<input class="deleted_denmos" type="hidden" name="deleted_denmos[]" value="' + id +
            '" />');

        $(this).parent().parent().remove();
    });

    $(".delete_currency_exchange_rate").click(function() {
        $(this).parent().parent().remove();
    });

    $("#add_denom").click(function() {
        $("#currency_denoms tbody").append(
            '<tr><td><input type="text" class="form-control form-control-solid" name="currency_denoms_name[]" value="" /></td><td><input type="text" class="form-control form-control-solid" name="currency_denoms_value[]" value="" /></td><td>&nbsp;</td><input type="hidden" name="currency_denoms_ids[]" /></tr>'
        );
    });

    $("#add_exchange_rate").click(function() {
        $("#currency_exchange_rates tbody").append('<tr>' +
            '<td><input type="text" class="form-control form-control-solid" name="currency_exchange_rates_to[]" value="" /></td>' +
            '<td><input type="text" class="form-control form-control-solid" name="currency_exchange_rates_symbol[]" value="$" /></td>' +
            '<td><select name="currency_exchange_rates_symbol_location[]" class="form-select form-select-solid"><option value="before"><?php echo lang('config_before_number'); ?></option><option value="after"><?php echo lang('config_after_number'); ?></option></select></td>' +
            '<td><select name="currency_exchange_rates_number_of_decimals[]" class="form-select form-select-solid"><option value=""><?php echo lang('config_let_system_decide'); ?></option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select></td>' +
            '<td><input type="text" class="form-control form-control-solid" name="currency_exchange_rates_thousands_separator[]" value="," /></td>' +
            '<td><input type="text" class="form-control form-control-solid" name="currency_exchange_rates_decimal_point[]" value="." /></td>' +
            '<td><input type="text" class="form-control form-control-solid" name="currency_exchange_rates_rate[]" value="" /></td>' +
            '<td>&nbsp;</td></tr>');
    });

    $(".dbOptimize").click(function(event) {
        event.preventDefault();
        $('#ajax-loader').removeClass('hidden');

        $.getJSON($(this).attr('href'), function(response) {
            $('#ajax-loader').addClass('hidden');
            bootbox.alert(response.message);
        });

    });

    $(".checkForUpdate").click(function(event) {
        event.preventDefault();
        $('#ajax-loader').removeClass('hidden');

        $.getJSON($(this).attr('href'), function(update_available) {
            $('#ajax-loader').addClass('hidden');
            if (update_available) {
                bootbox.confirm(<?php echo json_encode(lang('common_update_available')); ?>,
                    function(response) {
                        if (response) {
                            window.location =
                                "http://<?php echo $this->config->item('branding')['domain']; ?>/downloads.php";
                        }
                    });
            } else {
                bootbox.alert(<?php echo json_encode(lang('common_not_update_available')); ?>);
            }
        });

    });


    $("#reset_ecommerce").click(function(event) {
        bootbox.confirm(<?php echo json_encode(lang('config_confirm_reset_ecom')); ?>, function(
            response) {
            if (response) {
                $.getJSON(<?php echo json_encode(site_url('config/reset_ecom')); ?>, function(
                    response) {
                    if (response.success) {
                        show_feedback('success', response.message,
                            <?php echo json_encode(lang('common_success')); ?>);
                    }
                });
            }
        });
    });
    var submitting = false;

    function objectifyForm(formArray) {
        //serialize data function
        var returnArray = {};
        for (var i = 0; i < formArray.length; i++) {
            if (returnArray[formArray[i]['name']]) {
                if (!Array.isArray(returnArray[formArray[i]['name']])) {
                    returnArray[formArray[i]['name']] = [returnArray[formArray[i]['name']]];
                }
                returnArray[formArray[i]['name']].push(formArray[i]['value']);
            } else {
                returnArray[formArray[i]['name']] = formArray[i]['value'];
            }
        }
        return returnArray;
    }

    $('#config_form').validate({
        submitHandler: function(form) {
            if (submitting) return;
            submitting = true;
            $(form).ajaxSubmit({
                success: function(response) {


                    //Don't let the tiers, taxes, providers, methods double submitted, so we change the name
                    $('.zones,.tiers_to_edit,.providers,.methods,.taxes,.tax_classes,.sale_types_to_edit')
                        .filter(function() {
                            return parseInt($(this).data('index')) < 0;
                        }).attr('name', 'items_added[]');

                    if (response.success) {

                        formDataArray = objectifyForm($("#config_form")
                            .serializeArray());
                        let disable_modules = formDataArray['disable_modules[]'];

                        if (!disable_modules) {
                            disable_modules = [];
                        }
                        $("#mainMenu>li").show();
                        for (let i = 0; i < disable_modules.length; i++) {
                            $("#mainMenu>li." + disable_modules[i]).hide();
                        }

                        show_feedback('success', response.message,
                            <?php echo json_encode(lang('common_success')); ?>);
                    } else {
                        show_feedback('error', response.message,
                            <?php echo json_encode(lang('common_error')); ?>);

                    }
                    submitting = false;
                },
                dataType: 'json'
            });

        },
        errorClass: "text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
        rules: {
            company: "required",
            sale_prefix: "required",
            return_policy: {
                required: true
            },
            item_id_auto_increment: {
                number: true,
                min: 1,
                max: 999999999
            },
            item_kit_id_auto_increment: {
                number: true,
                min: 1,
                max: 999999999
            },
            sale_id_auto_increment: {
                number: true,
                min: 1,
                max: 999999999
            },
            receiving_id_auto_increment: {
                number: true,
                min: 1,
                max: 999999999
            }
        },
        messages: {
            company: <?php echo json_encode(lang('config_company_required')); ?>,
            sale_prefix: <?php echo json_encode(lang('config_sale_prefix_required')); ?>,
            return_policy: {
                required: <?php echo json_encode(lang('config_return_policy_required')); ?>
            },

        }
    });

});

//gmail api integration
var authorize_dialog_window = null;

function authorize_dialog_message(msg) {
    // console.log("messge from authorize dialog:" + msg);
    if (msg == "success") {
        authorize_dialog_window.close();
        document.getElementById("gmail_api_signout_button").style.display = "inline-block";
        document.getElementById("gmail_api_authorize_button").style.display = "none";
        $("#submitf").trigger("click");
    }
}

$("#offline_mode").change(offline_mode_change).ready(offline_mode_change);

function offline_mode_change() {
    if ($("#offline_mode").prop('checked')) {
        $("#force_https").prop('checked', true);
    }
}

$("#calculate_average_cost_price_from_receivings").change(check_calculate_average_cost_price_from_receivings).ready(
    check_calculate_average_cost_price_from_receivings);

function check_calculate_average_cost_price_from_receivings() {
    if ($("#calculate_average_cost_price_from_receivings").prop('checked')) {
        $("#average_cost_price_from_receivings_methods").show();
        $("#update_cost_price_on_transfer_container").show();
    } else {
        $("#average_cost_price_from_receivings_methods").hide();
        $("#update_cost_price_on_transfer_container").hide();

    }
}

$("#enable_customer_loyalty_system,#loyalty_option").change(check_loyalty_setup).ready(check_loyalty_setup);

function check_loyalty_setup() {
    if ($("#enable_customer_loyalty_system").prop('checked')) {
        $("#loyalty_setup").show();
    } else {
        $("#loyalty_setup").hide();
    }

    if ($("#loyalty_option").val() == 'simple') {
        $("#loyalty_setup_simple").show();
        $("#loyalty_setup_advanced").hide();
    } else {
        $("#loyalty_setup_simple").hide();
        $("#loyalty_setup_advanced").show();
    }
}

<?php
if ($search = $this->input->get('search')) { ?>
$("#search").val(<?php echo json_encode($this->input->get('search')); ?>);
<?php } ?>

$(document).ready(function() {
    $(".config-panel").sieve({
        itemSelector: "div.form-group",
        searchInput: $('#search'),
        complete: function() {
            if (event.type == 'keyup') {
                $(".panel-body").each(function(index) {
                    var $this = $(this);

                    var $visible_element = $this.find('.form-group').filter(function() {
                        return $(this).css('display') != 'none'
                    });

                    if ($visible_element.length == 0) {
                        $this.closest('.col-md-12').hide();
                        $this.closest('.col-md-12').collapse('hide');
                        var section_name = 'col-md-12';
                        $('.' + section_name + ' > .panel > .collapse').collapse('show');
                    } else {
                        $this.closest('.col-md-12').show();
                        var section_name = 'col-md-12';
                        $('.' + section_name + ' > .panel > .collapse').collapse('hide');

                    }

                })
            }
        }
    });
    $("#search").focus().trigger('keyup');
});





<?php
$deleted_payment_types = $this->config->item('deleted_payment_types');
$deleted_payment_types = explode(',',$deleted_payment_types);

foreach($deleted_payment_types as $deleted_payment_type)
{
?>
$(".payment_types").each(function() {
    if ($(this).text() == <?php echo json_encode($deleted_payment_type); ?>) {
        $(this).removeClass('btn-primary');
        $(this).addClass('deleted btn-danger');
    }
});
<?php
}
?>
save_deleted_payments();

$(".payment_types").click(function(e) {
    e.preventDefault();
    $(this).toggleClass('btn-primary');
    $(this).toggleClass('deleted btn-danger');
    save_deleted_payments();
});

function save_deleted_payments() {
    $(".deleted_payment_types").remove();

    var deleted_payment_types = [];
    $(".payment_types.deleted").each(function() {
        deleted_payment_types.push($(this).text());
    });
    $("#config_form").append('<input class="deleted_payment_types" type="hidden" name="deleted_payment_types" value="' +
        deleted_payment_types.join() + '" />');

}

$("#cancel_woo").click(function() {

    bootbox.confirm({
        message: <?php echo json_encode(lang('confirmation_woocommerce_cron_cancel')); ?>,
        buttons: {
            cancel: {
                label: <?php echo json_encode(lang('common_no')); ?>,
                className: 'btn-default'
            },
            confirm: {
                label: <?php echo json_encode(lang('common_yes')); ?>,
                className: 'btn-primary'
            }
        },
        callback: function(response) {
            if (response) {
                $.get(<?php echo json_encode(site_url('ecommerce/cancel'));?>);
            }
        }
    });
});

function check_ecommerce_status() {
    $.getJSON(SITE_URL + '/home/get_ecommerce_sync_progress', function(response) {
        if (response.running) {
            $("#ecommerce-cancel-button").removeClass('hidden');
            set_ecommerce_progress(response.percent_complete, response.message);
            setTimeout(check_ecommerce_status, 5000);
        } else {
            $("#ecommerce-cancel-button").addClass('hidden');;
        }
    });
}

function set_ecommerce_progress(percent, message) {
    $("#ecommerce_sync_progress").toggleClass('hidden', false);
    $('#ecommerce_progessbar').attr('aria-valuenow', percent).css('width', percent + '%');
    $('#ecommerce_progress_percent').html(percent);
    if (message != '') {
        $("#ecommerce_progress_message").html('(' + message + ')');
    } else {
        $("#ecommerce_progress_message").html('');
    }

}

check_ecommerce_status();


$('#sync_woo').click(function() {
    bootbox.confirm({
        message: <?php echo json_encode(lang('confirmation_woocommerce_cron')); ?>,
        buttons: {
            cancel: {
                label: <?php echo json_encode(lang('common_no')); ?>,
                className: 'btn-default'
            },
            confirm: {
                label: <?php echo json_encode(lang('common_yes')); ?>,
                className: 'btn-primary'
            }
        },
        callback: function(response) {
            if (response) {
                $('#sync_woo_button_icon').toggleClass("glyphicon-refresh-animate", true);


                $("#ecommerce_sync_progress").toggleClass("hidden", false);


                $("#config_form").ajaxSubmit(function() {
                    //Wait 3 seconds before checking status for first time
                    setTimeout(function() {
                        check_ecommerce_status();
                    }, 3000);
                    var href = '<?php echo site_url("ecommerce/manual_sync");?>'
                    $.ajax(href, {
                        dataType: "json",
                        success: function(data) {
                            $('#ajax-loader').addClass('hidden');
                            if (data.success) {

                                if (data.cancelled) {
                                    show_feedback('error',
                                        <?php echo json_encode(lang('common_cron_cancelled')); ?>,
                                        <?php echo json_encode(lang('common_error')); ?>
                                    );
                                } else {
                                    show_feedback('success',
                                        <?php echo json_encode(lang('common_cron_success')); ?>,
                                        <?php echo json_encode(lang('common_success')); ?>
                                    );
                                }

                                $('#sync_woo').parents('.form-group').addClass(
                                    'has-success').removeClass('has-error');

                                $('#sync_woo_button_icon').toggleClass(
                                    "glyphicon-refresh-animate", false);

                                setTimeout(function() {
                                    $("#ecommerce_sync_progress")
                                        .toggleClass("hidden", true);
                                }, 1000);

                                $("#ecommerce_sync_date").val(
                                    <?php echo json_encode(lang('common_just_now')); ?>
                                );
                            } else {
                                show_feedback('error', data.message);
                                $('#sync_woo').parents('.form-group')
                                    .removeClass('has-success').addClass(
                                        'has-error');

                                $('#sync_woo_button_icon').toggleClass(
                                    "glyphicon-refresh-animate", false);
                                $("#ecommerce_sync_progress").toggleClass(
                                    "hidden", true);

                            }
                        },
                        error: function() {
                            show_feedback('error',
                                <?php echo json_encode(lang('common_access_denied')); ?>
                            );
                            $('#sync_woo').parents('.form-group').removeClass(
                                'has-success').addClass('has-error');
                            $('#sync_woo_button_icon').toggleClass(
                                "glyphicon-refresh-animate", false);
                            $("#ecommerce_sync_progress").toggleClass("hidden",
                                true);
                        }
                    });

                });
            }
        }
    });
});


$("#cancel_qb").click(function() {

    bootbox.confirm({
        message: <?php echo json_encode(lang('config_confirmation_qb_cron_cancel')); ?>,
        buttons: {
            cancel: {
                label: <?php echo json_encode(lang('common_no')); ?>,
                className: 'btn-default'
            },
            confirm: {
                label: <?php echo json_encode(lang('common_yes')); ?>,
                className: 'btn-primary'
            }
        },
        callback: function(response) {
            if (response) {
                $.get(<?php echo json_encode(site_url('quickbooks/cancel'));?>);
            }
        }
    });
});

function check_quickbooks_status() {
    $.getJSON(SITE_URL + '/home/get_qb_sync_progress', function(response) {
        if (response.running) {
            $("#qb-cancel-button").removeClass('hidden');
            set_quickbooks_progress(response.percent_complete, response.message);
            setTimeout(check_quickbooks_status, 5000);
        } else {
            $("#qb-cancel-button").addClass('hidden');;
        }
    });
}

function set_quickbooks_progress(percent, message) {
    $("#quickbooks_sync_progress").toggleClass('hidden', false);
    $('#quickbooks_progessbar').attr('aria-valuenow', percent).css('width', percent + '%');
    $('#quickbooks_progress_percent').html(percent);
    if (message != '') {
        $("#quickbooks_progress_message").html('(' + message + ')');
    } else {
        $("#quickbooks_progress_message").html('');
    }

}

check_quickbooks_status();


$('#sync_qb').click(function() {
    bootbox.confirm({
        message: <?php echo json_encode(lang('config_confirmation_qb_cron')); ?>,
        buttons: {
            cancel: {
                label: <?php echo json_encode(lang('common_no')); ?>,
                className: 'btn-default'
            },
            confirm: {
                label: <?php echo json_encode(lang('common_yes')); ?>,
                className: 'btn-primary'
            }
        },
        callback: function(response) {
            if (response) {
                $('#sync_qb_button_icon').toggleClass("glyphicon-refresh-animate", true);


                $("#quickbooks_sync_progress").toggleClass("hidden", false);


                $("#config_form").ajaxSubmit(function() {
                    //Wait 3 seconds before checking status for first time
                    var start_date = $('#export_start_date').val();
                    if (start_date == "") {
                        alert("Please fill start date");
                        return false;
                    }
                    //  return false;
                    setTimeout(function() {
                        check_quickbooks_status();
                    }, 3000);
                    var href = '<?php echo site_url("quickbooks/manual_sync");?>'
                    $.ajax(href, {
                        dataType: "json",
                        // type: 'POST',
                        // data:  { export_start_date: start_date} ,
                        success: function(data) {
                            $('#ajax-loader').addClass('hidden');
                            if (data.success) {

                                if (data.cancelled) {
                                    show_feedback('error',
                                        <?php echo json_encode(lang('common_cron_cancelled')); ?>,
                                        <?php echo json_encode(lang('common_error')); ?>
                                    );
                                } else {
                                    show_feedback('success',
                                        <?php echo json_encode(lang('common_cron_success_qb')); ?>,
                                        <?php echo json_encode(lang('common_success')); ?>
                                    );
                                }

                                $('#sync_qb').parents('.form-group').addClass(
                                    'has-success').removeClass('has-error');

                                $('#sync_qb_button_icon').toggleClass(
                                    "glyphicon-refresh-animate", false);

                                setTimeout(function() {
                                    $("#quickbooks_sync_progress")
                                        .toggleClass("hidden", true);
                                }, 1000);

                                $("#quickbooks_sync_date").val(
                                    <?php echo json_encode(lang('common_just_now')); ?>
                                );
                            } else {
                                show_feedback('error', data.message);
                                $('#sync_qb').parents('.form-group')
                                    .removeClass('has-success').addClass(
                                        'has-error');

                                $('#sync_qb_button_icon').toggleClass(
                                    "glyphicon-refresh-animate", false);
                                $("#quickbooks_sync_progress").toggleClass(
                                    "hidden", true);

                            }
                        },
                        error: function() {
                            show_feedback('error',
                                <?php echo json_encode(lang('common_access_denied')); ?>
                            );
                            $('#sync_qb').parents('.form-group').removeClass(
                                'has-success').addClass('has-error');
                            $('#sync_qb_button_icon').toggleClass(
                                "glyphicon-refresh-animate", false);
                            $("#quickbooks_sync_progress").toggleClass("hidden",
                                true);
                        }
                    });

                });
            }
        }
    });
});


$("#item_lookup_order_list").sortable();

var checklist_ecom = <?php echo json_encode(unserialize($this->config->item('ecommerce_cron_sync_operations'))); ?>;

$(function() {
    $group = $('.ecommerce_cron_sync_operations .list-group.checked-list-box');
    $group.find('.list-group-item').each(function() {
        // Settings
        var $widget = $(this),
            $checkbox = $('<input type="checkbox" class="hidden" />'),
            value = ($widget.data('value') ? $widget.data('value') : '1'),
            color = ($widget.data('color') ? $widget.data('color') : "primary"),
            style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        $widget.css('cursor', 'pointer');
        $checkbox.val(value).attr('name', $group.data('name'));
        $widget.append($checkbox);

        // Event Handlers
        $widget.on('click', function() {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
        });

        $checkbox.on('change', function() {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');
            // Set the button's state
            $widget.data('state', (isChecked) ? "on" : "off");
            // Set the button's icon
            $widget.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$widget.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $widget.addClass(style + color);
            } else {
                $widget.removeClass(style + color);
            }

            if (isChecked) {
                if (typeof $widget.data('requires') == 'object') {
                    $.each($widget.data('requires'), function(key, value) {
                        $(":checkbox[value=" + value + "]").prop("checked", true).trigger(
                            'change');
                    });
                }
            } else {
                $group.find('.list-group-item').each(function() {
                    if (typeof $(this).data('requires') == 'object') {
                        var that = this;
                        $.each($(this).data('requires'), function(key, value) {

                            if (value == $widget.data('value')) {
                                $(that).find(":checkbox").prop("checked", false)
                                    .trigger('change');
                            }
                        });
                    }
                });
            }
        }

        // Initialization
        function init() {
            if ($.inArray($widget.data('value'), checklist_ecom) !== -1) {
                $widget.data('checked', true);
            }

            if ($widget.data('checked') == true) {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
            }
            updateDisplay();

            // Inject the icon if applicable
            if ($widget.find('.state-icon').length == 0) {
                $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon +
                    '"></span>');
            }
        }
        init();
    });
});

$("#tax_classes tbody").sortable();

var tax_class_index = -1;

$(document).on('click', '.add_tax_class', function(e) {
    var $tbody = $("#tax_classes").find("tbody");

    var tax_rate_index = 0;

    var checkbox_template = '<input type="hidden" name="taxes[' + tax_class_index +
        '][cumulative][]" value="0" /><input disabled data-index="-1" type="checkbox" class="taxes invisible" id="tax_rate_' +
        tax_class_index + '_0_cumulative" name="taxes[' + tax_class_index + '][cumulative][]">' +
        '<label class="tax_class_cumulative_element invisible" for="tax_rate_' + tax_class_index +
        '_0_cumulative"><span></span></label>';

    var radio_template = '<input data-index="-1" type="radio" id="tax_class_' + tax_class_index +
        '_0_default" name="tax_class_id" value="' + tax_class_index + '">' +
        '<label class="tax_class_default_element" for="tax_class_' + tax_class_index +
        '_0_default"><span></span></label>';


    $("#tax_classes").find("tbody").append('<tr data-index="' + tax_class_index + '">' +
        '<td class="tax_class_name top">' +
        '<input type="text" data-index="-1" class="rates form-control form-control-solid tax_classes" name="tax_classes[' +
        tax_class_index + '][name]" value="" />' +
        '</td>' +
        '<td class="tax_class_rate_name top">' +
        '<input data-index="-1" data-tax-class-id="-1" type="text" class="rates form-control form-control-solid tax_classes" name="taxes[' +
        tax_class_index + '][name][]" />' +
        '</td>' +
        '<td class="tax_class_rate_percent top">' +
        '<input data-index="-1" data-tax-class-id="-1" type="text" class="rates form-control form-control-solid tax_classes" name="taxes[' +
        tax_class_index + '][percent][]" />' +
        '</td>' +
        '<td class="tax_class_rate_cumulative top">' +
        checkbox_template +
        '</td>' +
        '<td class="tax_class_rate_default">' +
        radio_template +
        '</td>' +
        '<td>' +
        '<a class="delete_tax_rate tax_table_rate_text_element"><?php echo lang('common_delete'); ?></a>' +
        '</td>' +
        '<td>' +
        '<a href="javascript:void(0);" class="add_tax_rate"><?php echo lang('config_add_rate'); ?></a>' +
        '</td>' +
        '<td>' +
        '&nbsp;' +
        '</td>' +
        '<td>' +
        '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>' +
        '</td>' +
        '</tr>');

    tax_class_index -= 1;
});

$(document).on('click', '.delete_tax_rate', function(e) {
    var $tr = $(this).closest("tr");

    var tax_class_index = $tr.data('index');
    var tax_rate_index = $tr.find('td.tax_class_rate_name > input').length;

    if (tax_rate_index > 1) {
        var tax_class_tax_id = parseInt($tr.find('.tax_class_rate_name input').last().data('tax-class-tax-id'));
        $tr.find('.tax_class_rate_name input').last().remove();
        $tr.find('.tax_class_rate_percent input').last().remove();
        $tr.find('.tax_class_rate_cumulative input').last().remove();

        if (tax_class_tax_id > 0) {
            $("#config_form").append('<input type="hidden" name="taxes_to_delete[]" value="' +
                tax_class_tax_id + '" />');
        }
    } else {

        $tr.remove();

        if (tax_class_index > 0) {
            $("#config_form").append('<input type="hidden" name="tax_classes_to_delete[]" value="' +
                tax_class_index + '" />');
        }
    }
});

$(document).on('click', '.add_tax_rate', function(e) {
    var $tr = $(this).closest("tr");
    var tax_class_index = $tr.data('index');
    var tax_rate_index = $tr.find('td.tax_class_rate_name > input').length;

    $tr.find('.tax_class_rate_name').append(
        '<input data-index="-1" type="text" data-tax-class-tax-id="-1" class="rates form-control form-control-solid taxes" name="taxes[' +
        tax_class_index + '][name][]" >');
    $tr.find('.tax_class_rate_percent').append(
        '<input data-index="-1" type="text" class="rates form-control form-control-solid taxes" name="taxes[' +
        tax_class_index + '][percent][]" >');

    if (tax_rate_index == 1) {
        var checkbox_template = '<input data-index="-1" type="checkbox" class="taxes" id="tax_rate_' +
            tax_class_index + '_' + tax_rate_index + '_cumulative" name="taxes[' + tax_class_index +
            '][cumulative][]">' +
            '<label class="tax_class_cumulative_element" for="tax_rate_' + tax_class_index + '_' +
            tax_rate_index + '_cumulative"><span></span></label>';
        $tr.find('.tax_class_rate_cumulative').append(checkbox_template);
    } else {
        var checkbox_template = '<input type="hidden" name="taxes[' + tax_class_index +
            '][cumulative][]" value="0" /><input disabled data-index="-1" type="checkbox" class="taxes invisible" id="tax_rate_' +
            tax_class_index + '_' + tax_rate_index + '_cumulative" name="taxes[' + tax_class_index +
            '][cumulative][]">' +
            '<label class="tax_class_cumulative_element invisible" for="tax_rate_' + tax_class_index + '_' +
            tax_rate_index + '_cumulative"><span></span></label>';
        $tr.find('.tax_class_rate_cumulative').append(checkbox_template);
    }

});

//delivery stuff
$("#shipping_zones tbody").sortable();

$('.shipping_zone_zips input').selectize({
    delimiter: '|',
    create: true,
    render: {
        option_create: function(data, escape) {
            var add_new = <?php echo json_encode(lang('common_add_value')) ?>;
            return '<div class="create">' + escape(add_new) + ' <strong>' + escape(data.input) +
                '</strong></div>';
        }
    },
});

var zone_index = -1;

$(document).on('click', '.add_shipping_zone', function(e) {

    var $tbody = $("#shipping_zones").find("tbody");

    $tbody.append('<tr data-index="' + zone_index + '">' +
        '<td class="shipping_zone_name top">' +
        '<input type="text" data-index="-1" class="zones form-control form-control-solid name" name="zones[' +
        zone_index + '][name]" value="" />' +
        '</td>' +
        '<td class="shipping_zone_zips top">' +
        '<input type="text" data-index="-1" class="zones form-control form-control-solid name" name="zones[' +
        zone_index + '][zips]" value="" />' +
        '</td>' +
        '<td class="shipping_zone_fee top">' +
        '<input data-index="-1" type="text" class="zones form-control form-control-solid fee" name="zones[' +
        zone_index + '][fee]" />' +
        '</td>');

    $tr = $tbody.find('tr').last();

    $tr.find('.shipping_zone_zips input').selectize({
        delimiter: '|',
        create: true,
        render: {
            option_create: function(data, escape) {
                var add_new = <?php echo json_encode(lang('common_add_value')) ?>;
                return '<div class="create">' + escape(add_new) + ' <strong>' + escape(data.input) +
                    '</strong></div>';
            }
        },
    });

    var tax_groups = <?php echo json_encode($tax_groups); ?>

    var tax_group_select = $('<select>').addClass('zones form-select form-select-solid').attr('name', 'zones[' +
        zone_index + '][tax_class_id]').attr('data-index', zone_index);
    $('<td class="shipping_zone_tax_group top" >').append(tax_group_select).appendTo($tr);

    $(tax_groups).each(function() {
        tax_group_select.append($("<option>").attr('value', this.val).text(this.text));
    });

    $tr.append(
        '<td>' +
        '<a class="delete_rate btn btn-danger btn-sm"><?php echo lang('common_delete'); ?></a>' +
        '</td>' +
        '<td>' +
        '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>' +
        '</td>'
    );

    zone_index--;
});

$("#shipping_providers tbody").sortable();


var provider_index = -1;

$(document).on('click', '.add_shipping_provider', function(e) {
    var $tbody = $("#shipping_providers").find("tbody");

    var rate_index = 0;
    var radio_template = '<input data-index="-1" type="radio" class="methods" id="default_shipping_rate_' +
        provider_index + '_0" name="methods[' + provider_index + '][is_default][]" checked="checked">' +
        '<label class="shipping_table_rate_element" for="default_shipping_rate_' + provider_index +
        '_0"><span></span></label>';

    $tbody.append('<tr data-index="' + provider_index + '">' +
        '<td class="shipping_provider_name top">' +
        '<input type="text" data-index="-1" class="rates form-control form-control-solid providers" name="providers[' +
        provider_index + '][name]" value="" />' +
        '</td>' +
        '<td class="delivery_rate_name top">' +
        '<input data-index="-1" data-method-id="-1" type="text" class="rates form-control form-control-solid methods" name="methods[' +
        provider_index + '][name][]" />' +
        '</td>' +
        '<td class="delivery_fee top">' +
        '<input type="text" data-index="-1" class="rates form-control form-control-solid methods" name="methods[' +
        provider_index + '][fee][]" />' +
        '</td>' +
        '<td class="delivery_time top">' +
        '<input type="text" data-index="-1" class="rates form-control form-control-solid methods" name="methods[' +
        provider_index + '][time_in_days][]" />' +
        '</td>' +
        '<td class="delivery_default top">' +
        radio_template +
        '</td>' +
        '<td>' +
        '<a class="delete_rate shipping_table_rate_text_element btn btn-danger btn-sm"><?php echo lang('common_delete'); ?></a>' +
        '</td>' +
        '<td>' +
        '<a href="javascript:void(0);" class="add_delivery_rate btn btn-info btn-sm"><?php echo lang('config_add_rate'); ?></a>' +
        '</td>' +
        '<td>' +
        '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>' +
        '</td>' +
        '</tr>');

    provider_index -= 1;
});

$(document).on('click', '.delete_zone', function(e) {
    var $tr = $(this).closest("tr");
    var index = $tr.data('index');

    $tr.remove();

    if (index > 0) {
        $("#config_form").append('<input type="hidden" class="delete_zone" name="zones_to_delete[]" value="' +
            index + '" />');
    }
});

$(document).on('click', '.delete_rate', function(e) {
    var $tr = $(this).closest("tr");

    var index = $tr.data('index');
    var rate_index = $tr.find('td.delivery_rate_name > input').length;
    var method_id = parseInt($tr.find('.delivery_rate_name input').last().data('method-id'));

    if (rate_index > 1) {
        $tr.find('.delivery_rate_name input').last().remove();
        $tr.find('.delivery_fee input').last().remove();
        $tr.find('.delivery_time input').last().remove();
        $tr.find('.delivery_default input').last().remove();
        $tr.find('.delivery_default label').last().remove();

        if (method_id > 0) {
            $("#config_form").append(
                '<input type="hidden" class="delete_method" name="methods_to_delete[]" value="' +
                method_id + '" />');
        }
    } else {

        $tr.remove();

        if (method_id > 0) {
            $("#config_form").append(
                '<input type="hidden" class="delete_method" name="methods_to_delete[]" value="' +
                method_id + '" />');
        }

        if (index > 0) {
            $("#config_form").append(
                '<input type="hidden" class="delete_provider" name="providers_to_delete[]" value="' +
                index + '" />');
        }
    }
});

$(document).on('click', '.add_delivery_rate', function(e) {
    var $tr = $(this).closest("tr");
    var index = $tr.data('index');
    var rate_index = $tr.find('td.delivery_rate_name > input').length;

    $tr.find('.delivery_rate_name').append(
        '<input data-index="-1" type="text" data-method-id="-1" class="rates form-control methods" name="methods[' +
        index + '][name][]" >');
    $tr.find('.delivery_fee').append(
        '<input data-index="-1" type="text" class="rates form-control methods" name="methods[' + index +
        '][fee][]" >');
    $tr.find('.delivery_time').append(
        '<input data-index="-1" type="text" class="rates form-control methods" name="methods[' + index +
        '][time_in_days][]" >');

    var radio_template = '<input data-index="-1" type="radio" class="methods" id="default_shipping_rate_' +
        index + "_" + rate_index + '" name="methods[' + index + '][is_default][]">' +
        '<label class="shipping_table_rate_element" for="default_shipping_rate_' + index + "_" + rate_index +
        '"><span></span></label>';

    $tr.find('.delivery_default').append(radio_template);

});

$("#verify_age_for_products").click(function() {
    if ($('#verify_age_for_products').prop('checked')) {
        $("#default_age_input_container").removeClass('hidden');
        $("#strict_age_format_check_container").removeClass('hidden');
    } else {
        $("#default_age_input_container").addClass('hidden');
        $("#strict_age_format_check_container").addClass('hidden');
    }

});



$("#reset_quickbooks").click(function(event) {
    bootbox.confirm(<?php echo json_encode(lang('config_confirm_reset_qb')); ?>, function(response) {
        if (response) {
            $.getJSON(<?php echo json_encode(site_url('config/reset_qb')); ?>, function(response) {
                if (response.success) {
                    show_feedback('success', response.message,
                        <?php echo json_encode(lang('common_success')); ?>);

                    setTimeout(function() {
                        window.location.reload();
                    }, 3000);

                }
            });
        }
    });
});


var checklist_qb = <?php echo json_encode(unserialize($this->config->item('qb_sync_operations'))); ?>;

$(function() {
    $group = $('.qb_sync_operations .list-group.checked-list-box');
    $group.find('.list-group-item').each(function() {
        // Settings
        var $widget = $(this),
            $checkbox = $('<input type="checkbox" class="hidden" />'),
            value = ($widget.data('value') ? $widget.data('value') : '1'),
            color = ($widget.data('color') ? $widget.data('color') : "primary"),
            style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        $widget.css('cursor', 'pointer');
        $checkbox.val(value).attr('name', $group.data('name'));
        $widget.append($checkbox);

        // Event Handlers
        $widget.on('click', function() {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
        });

        $checkbox.on('change', function() {
            updateDisplayQB();
        });


        // Actions
        function updateDisplayQB() {

            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $widget.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $widget.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$widget.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $widget.addClass(style + color);
            } else {
                $widget.removeClass(style + color);
            }

            if (isChecked) {
                if (typeof $widget.data('requires') == 'object') {
                    $.each($widget.data('requires'), function(key, value) {
                        $(":checkbox[value=" + value + "]").prop("checked", true).trigger(
                            'change');
                    });
                }
            } else {
                $group.find('.list-group-item').each(function() {
                    if (typeof $(this).data('requires') == 'object') {
                        var that = this;
                        $.each($(this).data('requires'), function(key, value) {

                            if (value == $widget.data('value')) {
                                $(that).find(":checkbox").prop("checked", false)
                                    .trigger('change');
                            }
                        });
                    }
                });
            }

        }

        // Initialization
        function initQB() {
            var checkboxValue = $widget.data('value');
            if ($.inArray(checkboxValue, checklist_qb) !== -1) {
                $widget.data('checked', true);
            }

            if ($widget.data('checked') == true) {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
            }

            updateDisplayQB();

            // Inject the icon if applicable
            if ($widget.find('.state-icon').length == 0) {
                $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon +
                    '"></span>');
            }
        }
        initQB();
    });
});

$("#indicate_non_taxable_on_receipt").change(function() {
    if (this.checked) {
        $("#override_symbol_non_taxable_container").show();
    } else {
        $("#override_symbol_non_taxable_container").hide();
    }
});

$("#taxes_summary_on_receipt").change(function() {
    if (this.checked) {
        $("#override_symbol_taxable_summary_container").show();
        $("#override_symbol_non_taxable_summary_container").show();
    } else {
        $("#override_symbol_taxable_summary_container").hide();
        $("#override_symbol_non_taxable_summary_container").hide();
    }
});

$('#work_order_device_locations').selectize({
    delimiter: ',',
    persist: false,
    create: function(input) {
        return {
            value: input,
            text: input
        }
    }
});
</script>
<script>
// Add an event listener to the button click
document.getElementById("toggle_company_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("company_information");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_Taxes_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("taxes");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_currency_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("currency");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_payment_types_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("payment_types");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_price_rules_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("price_rules");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_orders_deliveries_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("orders_deliveries");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_sales_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("sales");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_suspended_sales_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("suspended_sales");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_receipt_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("receipt");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_profit_calculation_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("profit_calculation");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_barcodes_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("barcodes");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_customer_loyalty_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("customer_loyalty");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_price_tiers_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("price_tiers");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_id_numbers_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("id_numbers");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_items_settings_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("items_settings");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_employee_settings_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("employee_settings");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_store_accounts_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("store_accounts");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_disable_modules_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("disable_modules");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_application_settings_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("application_settings");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_email_settings_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("email_settings");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_sso_info_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("sso_info");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_qb_settings_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("qb_settings");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_ecommerce_store_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("ecommerce_store");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_api_settings_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("api_settings");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_web_hooks_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("web_hooks");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_work_order_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("work_order");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});

document.getElementById("toggle_lookup_api_integration_info").addEventListener("click", function() {
    var companyInfoDiv = document.getElementById("lookup_api_integration");
    var isExpanded = companyInfoDiv.classList.contains("show");

    // Toggle the visibility of the first div
    if (isExpanded) {
        companyInfoDiv.classList.remove("show");
    } else {
        companyInfoDiv.classList.add("show");
    }
});




</script>
<?php $this->load->view("partial/footer"); ?>