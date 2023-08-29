<?php $this->load->view("partial/header"); 
$this->load->helper('demo');
?>

<?php
		if(isset($announcement))
		{
		?>
		<div class="alert alert-danger" role="alert">
		<?php echo $announcement; ?>
		</div>
		<?php
		}
		?>

<?php
		if (is_on_saas_host()) {
		?>
			<?php if (isset($trial_on) && $trial_on === true) { ?>
				<div class="col-md-12">
					<div class="panel">
						<div class="panel-body">					
						   <div class="alert alert-success">
						    <?php echo lang('login_trail_info'). ' '.date(get_date_format(), strtotime($cloud_customer_info['trial_end_date'])).'. '.lang('login_trial_info_2'); ?>
						    </div>
						    <a class="btn btn-block btn-success" href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username'];?>&username=<?php echo $this->Employee->get_logged_in_employee_info()->username; ?>&password=<?php echo $this->Employee->get_logged_in_employee_info()->password; ?>" target="_blank"><?php echo lang('common_update_billing_info');?></a>
							</div>
						</div>
					</div>
			<?php } ?>


			<?php if (isset($subscription_payment_failed) && $subscription_payment_failed === true) { ?>
				<div class="col-md-12">
					<div class="panel">
						<div class="panel-body">
						   <div class="alert alert-danger">
						        <?php echo lang('login_payment_failed_text'); ?>
						    </div>
						    <a class="btn btn-block btn-success" href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username'];?>&username=<?php echo $this->Employee->get_logged_in_employee_info()->username; ?>&password=<?php echo $this->Employee->get_logged_in_employee_info()->password; ?>" target="_blank"><?php echo lang('common_update_billing_info');?></a>
							</div>
						</div>
					</div>
			<?php } ?>

			<?php if (isset($subscription_cancelled_within_5_days) && $subscription_cancelled_within_5_days === true) { ?>
				<div class="col-md-12">
					<div class="panel">
						<div class="panel-body">
						    <div class="alert alert-danger">
						        <?php echo lang('login_resign_text'); ?>
						    </div>
							<a class="btn btn-block btn-sm btn-success" href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username'];?>&username=<?php echo $this->Employee->get_logged_in_employee_info()->username; ?>&password=<?php echo $this->Employee->get_logged_in_employee_info()->password; ?>" target="_blank"><?php echo lang('login_resignup');?></a>
						</ul>
					</div>
				</div>
			</div>
			<?php } ?>
		<?php } ?>
	
<!--begin::Row-->

<?php if (isset($can_show_setup_wizard) && $can_show_setup_wizard) { ?>


<div class="row gy-5 g-xl-10">
										<!--begin::Col-->
										<div class="col-12">
											<!--begin::List widget 5-->
											<div class="card card-flush h-xl-100">
												<!--begin::Header-->
												<div class="card-header pt-7">
													<!--begin::Title-->
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-dark"><?php echo lang('home_setup_wizard');?></span>
													
													</h3>
													<!--end::Title-->
													<!--begin::Toolbar-->
													<div class="card-toolbar">
													
														<a id="dismiss_setup_wizard" href="<?php echo site_url('home/dismiss_setup_wizard') ?>" class="btn btn-sm btn-light"><?php echo lang('common_dismiss'); ?></a>
													</div>
													<!--end::Toolbar-->
												</div>
												<!--end::Header-->
												<!--begin::Body-->
												<div class="card-body">
													<!--begin::Scroll-->
													<div class="row pe-6 me-n6 " >
														<!--begin::Item-->
														<div class="col-4  <?php echo $this->config->item('wizard_configure_company') ? 'wizard_step_done' : '';?>">
															<div class=" border border-dashed border-gray-300 rounded px-7 py-3 mb-6  text-light bg-light-danger">
															<!--begin::Info-->
															<div class="d-flex flex-stack mb-3">
																<!--begin::Wrapper-->
																<div class="me-3">
																	<!--begin::Icon-->
																	<img src="<?php echo base_url('assets/img/gear.png') ?>"/>
																		
																	<!--end::Icon-->
																	<!--begin::Title-->
																		<a href="<?php echo base_url('config'); ?>" class="text-gray-800 text-hover-primary fw-bold"><h4><?php echo lang('module_config');?></h4></a>
																	<!--end::Title-->
																</div>
																<!--end::Wrapper-->
															
															</div>
															<!--end::Info-->
															<!--begin::Customer-->
															<div class="d-flex flex-stack">
																<!--begin::Name-->
																	<a href="<?php echo base_url('config'); ?>" class="text-gray-800 text-hover-primary fw-bold"><?php echo lang('home_wizard_configure_company');?></a>
																<!--end::Name-->
																<!--begin::Label-->
																<!-- <span class="badge badge-light-success">Delivered</span> -->
																<!--end::Label-->
															</div>
															<!--end::Customer-->
															</div>	
														
														</div>
														<!--end::Item-->
														
															<!--begin::Item-->
															<div class="col-4 <?php echo $this->config->item('wizard_configure_locations') ? 'wizard_step_done' : '';?>">
																<div class=" border border-dashed border-gray-300 rounded px-7 py-3 mb-6 bg-light-success">
																<!--begin::Info-->
																<div class="d-flex flex-stack mb-3">
																	<!--begin::Wrapper-->
																	<div class="me-3">
																		<!--begin::Icon-->
																		<img src="<?php echo base_url('assets/img/building.png') ?>"/>
																			
																		<!--end::Icon-->
																		<!--begin::Title-->
																		<a href="<?php echo base_url('locations'); ?>" class="text-gray-800 text-hover-primary fw-bold"><h4><?php echo lang('module_locations');?></h4></a>
																		<!--end::Title-->
																	</div>
																	<!--end::Wrapper-->
																
																</div>
																<!--end::Info-->
																<!--begin::Customer-->
																<div class="d-flex flex-stack">
																	<!--begin::Name-->
																		<a href="<?php echo base_url('locations'); ?>" class="text-gray-800 text-hover-primary fw-bold"><?php echo lang('home_wizard_configure_locations');?></a>
																	<!--end::Name-->
																	<!--begin::Label-->
																	<!-- <span class="badge badge-light-success">Delivered</span> -->
																	<!--end::Label-->
																</div>
																<!--end::Customer-->
																</div>
															
															</div>
														<!--end::Item-->
														
														<!--begin::Item-->
														<div class="col-4  <?php echo $this->config->item('wizard_add_inventory') ? 'wizard_step_done' : '';?>">
															<div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6 bg-light-info">
																													<!--begin::Info-->
															<div class="d-flex flex-stack mb-3">
																<!--begin::Wrapper-->
																<div class="me-3">
																	<!--begin::Icon-->
																	<img src="<?php echo base_url('assets/img/product.png') ?>"/>
																		
																	<!--end::Icon-->
																	<!--begin::Title-->
																	<a href="<?php echo base_url('items/view/-1'); ?>" class="text-gray-800 text-hover-primary fw-bold"><h4><?php echo lang('module_items');?></h4></a>
																	<!--end::Title-->
																</div>
																<!--end::Wrapper-->
															
															</div>
															<!--end::Info-->
															<!--begin::Customer-->
															<div class="d-flex flex-stack">
																<!--begin::Name-->
																	<a href="<?php echo base_url('items/view/-1'); ?>" class="text-gray-800 text-hover-primary fw-bold"><?php echo lang('home_wizard_add_inventory');?></a>
																<!--end::Name-->
																<!--begin::Label-->
																<!-- <span class="badge badge-light-success">Delivered</span> -->
																<!--end::Label-->
															</div>
															</div>
															<!--end::Customer-->
														</div>
														<!--end::Item-->
												
														<!--begin::Item-->
														<div class="col-4  <?php echo $this->config->item('wizard_edit_employees') ? 'wizard_step_done' : '';?>">
															
															<div  class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6 bg-light-success" >															<!--begin::Info-->
															<div class="d-flex flex-stack mb-3">
																<!--begin::Wrapper-->
																<div class="me-3">
																	<!--begin::Icon-->
																	<img src="<?php echo base_url('assets/img/user-group-man-man.png') ?>"/>
																		
																	<!--end::Icon-->
																	<!--begin::Title-->
																	<a href="<?php echo base_url('employees'); ?>" class="text-gray-800 text-hover-primary fw-bold"><h4><?php echo lang('module_employees');?></h4></a>
																	<!--end::Title-->
																</div>
																<!--end::Wrapper-->
															
															</div>
															<!--end::Info-->
															<!--begin::Customer-->
															<div class="d-flex flex-stack">
																<!--begin::Name-->
																	<a href="<?php echo base_url('employees'); ?>" class="text-gray-800 text-hover-primary fw-bold"><?php echo lang('home_wizard_edit_employees');?></a>
																<!--end::Name-->
																<!--begin::Label-->
																<!-- <span class="badge badge-light-success">Delivered</span> -->
																<!--end::Label-->
															</div>
															</div>
															<!--end::Customer-->
														</div>
														<!--end::Item-->
										
														<!--begin::Item-->
														<div class="col-4  <?php echo $this->config->item('wizard_add_customer') ? 'wizard_step_done' : '';?>">
														 
															<div class=" border border-dashed border-gray-300 rounded px-7 py-3 mb-6 bg-light-primary">											<!--begin::Info-->
															<div class="d-flex flex-stack mb-3">
																<!--begin::Wrapper-->
																<div class="me-3">
																	<!--begin::Icon-->
																	<img src="<?php echo base_url('assets/img/add-user-group-man-man.png') ?>"/>
																		
																	<!--end::Icon-->
																	<!--begin::Title-->
																	<a href="<?php echo base_url('customers/view/-1'); ?>" class="text-gray-800 text-hover-primary fw-bold"><h4><?php echo lang('module_customers');?></h4></a>
																	<!--end::Title-->
																</div>
																<!--end::Wrapper-->
															
															</div>
															<!--end::Info-->
															<!--begin::Customer-->
															<div class="d-flex flex-stack">
																<!--begin::Name-->
																	<a href="<?php echo base_url('customers/view/-1'); ?>" class="text-gray-800 text-hover-primary fw-bold"><?php echo lang('home_wizard_add_customer');?></a>
																<!--end::Name-->
																<!--begin::Label-->
																<!-- <span class="badge badge-light-success">Delivered</span> -->
																<!--end::Label-->
															</div>
															</div>					
															<!--end::Customer-->
														</div>
														<!--end::Item-->
											
														<!--begin::Item-->
														<div class="col-4   <?php echo $this->config->item('wizard_create_sale') ? 'wizard_step_done' : '';?>">
																																															<div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6 bg-light-danger">										
															<!--begin::Info-->
															<div class="d-flex flex-stack mb-3">
																<!--begin::Wrapper-->
																<div class="me-3">
																	<!--begin::Icon-->
																	<img src="<?php echo base_url('assets/img/cash-register.png') ?>"/>
																		
																	<!--end::Icon-->
																	<!--begin::Title-->
																	<a href="<?php echo base_url('sales'); ?>" class="text-gray-800 text-hover-primary fw-bold"><h4><?php echo lang('module_sales');?></h4></a>
																	<!--end::Title-->
																</div>
																<!--end::Wrapper-->
															
															</div>
															<!--end::Info-->
															<!--begin::Customer-->
															<div class="d-flex flex-stack">
																<!--begin::Name-->
																	<a href="<?php echo base_url('sales'); ?>" class="text-gray-800 text-hover-primary fw-bold"><?php echo lang('home_wizard_create_sale');?></a>
																<!--end::Name-->
																<!--begin::Label-->
																<!-- <span class="badge badge-light-success">Delivered</span> -->
																<!--end::Label-->
															</div>
															<!--end::Customer-->
															</div>
														</div>
														<!--end::Item-->


													</div>
													<!--end::Scroll-->
												</div>
												<!--end::Body-->
											</div>
											<!--end::List widget 5-->
										</div>
										<!--end::Col-->
									</div>
									<!--end::Row-->
								
		
<?php } ?>

		
<?php if (!is_on_demo_host() && $can_show_reseller_promotion) { ?>

		<!--begin::Alert-->
<div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10 mt-5">
    <!--begin::Close-->
    <a  href="<?php echo site_url('home/dismiss_reseller_message') ?>" class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-danger" data-bs-dismiss="alert">
        <span class="svg-icon svg-icon-1">x</span>
</a>
    <!--end::Close-->

    <!--begin::Wrapper-->
    <div class="text-center">
        <!--begin::Title-->
        <h1 class="fw-bold mb-5"><?php echo lang('home_resellers_program'); ?></h1>
        <!--end::Title-->

        <!--begin::Separator-->
        <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
        <!--end::Separator-->

        <!--begin::Content-->
        <div class="mb-9 text-dark">
		<?php echo lang('home_reseller_program_signup')?>
        </div>
        <!--end::Content-->

        <!--begin::Buttons-->
        <div class="d-flex flex-center flex-wrap">
            
            <a href="https://<?php echo $this->config->item('branding')['domain']; ?>/resellers_signup.php" class="btn btn-danger m-2"><?php echo lang('home_signup_now');?></a>
        </div>
        <!--end::Buttons-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->



<?php } ?>


<?php if (!is_on_demo_host() && $can_show_feedback_promotion) { ?>

	<!--begin::Alert-->
<div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
    <!--begin::Close-->
    <a  href="<?php echo site_url('home/dismiss_feedback_message') ?>" class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-danger" data-bs-dismiss="alert">
        <span class="svg-icon svg-icon-1">x</span>
</a>
    <!--end::Close-->



    <!--begin::Wrapper-->
    <div class="text-center">
        <!--begin::Title-->
        <h1 class="fw-bold mb-5"><?php echo lang('home_feedback'); ?></h1>
        <!--end::Title-->

        <!--begin::Separator-->
        <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
        <!--end::Separator-->

        <!--begin::Content-->
        <div class="mb-9 text-dark">
		<?php echo lang('home_feedback_program')?>
        </div>
        <!--end::Content-->

        <!--begin::Buttons-->
        <div class="d-flex flex-center flex-wrap">
            
            <a href="https://feedback.<?php echo $this->config->item('branding')['domain']; ?>" class="btn btn-danger m-2"><?php echo lang('home_visit_now');?></a>
        </div>
        <!--end::Buttons-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->


<!--end::Alert-->
<?php } ?>


	
<?php if ($can_show_mercury_activate) { ?>

		<!--begin::Alert-->
<div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
    <!--begin::Close-->
    <a  href="<?php echo site_url('home/dismiss_feedback_message') ?>" class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-danger" data-bs-dismiss="alert">
        <span class="svg-icon svg-icon-1">x</span>
</a>
    <!--end::Close-->



    <!--begin::Wrapper-->
    <div class="text-center">
        <!--begin::Title-->
        <h1 class="fw-bold mb-5"><?php echo lang('common_credit_card_processing'); ?></h1>
        <!--end::Title-->

        <!--begin::Separator-->
        <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
        <!--end::Separator-->

        <!--begin::Content-->
        <div class="mb-9 ">
		<a href="http://<?php echo $this->config->item('branding')['domain']; ?>/credit_card_processing.php" class="mercury_description" target="_blank">
							<?php echo lang('home_mercury_activate_promo_text');?>
						</a>
        </div>
        <!--end::Content-->

        
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->


<!--end::Alert-->



<?php } ?>

	
	
	
	




<?php 
$this->load->helper('demo');
if (!is_on_demo_host() && !$this->config->item('hide_test_mode_home') && !$this->config->item('disable_test_mode')) { ?>
	<?php if($this->config->item('test_mode')) { ?>
		
		<!--begin::Alert-->
<div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
    
    <!--end::Close-->



    <!--begin::Wrapper-->
    <div class="text-center">
        <!--begin::Title-->
        <h1 class="fw-bold mb-5"><?php echo lang('common_disable_test_mode'); ?></h1>
        <!--end::Title-->

        <!--begin::Separator-->
        <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
        <!--end::Separator-->

        <!--begin::Content-->
        <div class="mb-9 text-dark">
		<?php echo lang('common_in_test_mode')?>
        </div>
        <!--end::Content-->

        <!--begin::Buttons-->
        <div class="d-flex flex-center flex-wrap">
            
            <a href="<?php echo site_url('home/disable_test_mode') ?>" class="btn btn-danger m-2"><?php echo lang('common_disable_test_mode');?></a>
        </div>
        <!--end::Buttons-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->

	<?php } ?>

	<?php if(!$this->config->item('test_mode')  && !$this->config->item('disable_test_mode')) { ?>
	

			<!--begin::Alert-->
<div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
    <!--begin::Close-->
    <a  href="<?php echo site_url('home/dismiss_test_mode') ?>" class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-danger" data-bs-dismiss="alert">
        <span class="svg-icon svg-icon-1">x</span>
</a>
    <!--end::Close-->



    <!--begin::Wrapper-->
    <div class="text-center">
        <!--begin::Title-->
        <h1 class="fw-bold mb-5"><?php echo lang('common_enable_test_mode'); ?></h1>
        <!--end::Title-->

        <!--begin::Separator-->
        <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
        <!--end::Separator-->

        <!--begin::Content-->
        <div class="mb-9 text-dark">
		<?php echo lang('common_test_mode_desc')?>
        </div>
        <!--end::Content-->

        <!--begin::Buttons-->
        <div class="d-flex flex-center flex-wrap">
            
            <a href="<?php echo site_url('home/enable_test_mode') ?>" class="btn btn-danger m-2"><?php echo lang('common_enable_test_mode');?></a>
        </div>
        <!--end::Buttons-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->



	<?php } ?>
<?php } ?>


<div class="text-center">					

	<?php if ($this->Employee->has_module_action_permission('reports', 'view_dashboard_stats', $this->Employee->get_logged_in_employee_info()->person_id) && (!$this->agent->is_mobile() || $this->agent->is_tablet())) { ?>
	
	<?php
	if ($this->config->item('ecommerce_cron_running')) {
	?>
	<!-- ecommerce progress bar -->
	<div class="row" id="ecommerce_progress_container">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-heading rounded border-primary border border-dashed rounded-3 ">
					<h5><?php echo lang('home_ecommerce_platform_sync')?></h5>
				</div>
				<div class="panel-body">
					<div id="progress_bar">
						<div class="progress">
						  <div class="progress-bar progress-bar-striped active" id="progessbar" role="progressbar"
						  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
						    <span id="progress_percent">0</span>% <span id="progress_message"></span>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script>
	function check_ecommerce_status()
	{
		$.getJSON(SITE_URL+'/home/get_ecommerce_sync_progress', function(response)
		{
			set_progress(response.percent_complete,response.message);
		
			if (response.running)
			{
				setTimeout(check_ecommerce_status,5000);
			}
		});
	}
	
	function set_progress(percent, message)
	{
		$("#progress_container").show();
		$('#progessbar').attr('aria-valuenow', percent).css('width',percent+'%');
		$('#progress_percent').html(percent);
		if (message !='')
		{
			$("#progress_message").html('('+message+')');
		}
		else
		{
			$("#progress_message").html('');
		}
		
	}
	check_ecommerce_status();
	</script>
	
	<?php } ?>
	
	<?php
	if ($this->config->item('qb_cron_running')) {
	?>
	<!-- quickbooks progress bar -->
	<div class="row" id="quickbooks_progress_container">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-heading rounded border-primary border border-dashed rounded-3 ">
					<h5><?php echo lang('home_quickbooks_platform_sync')?></h5>
				</div>
				<div class="panel-body">
					<div id="progress_bar">
						<div class="progress">
						  <div class="progress-bar progress-bar-striped active" id="qb_progessbar" role="progressbar"
						  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
						    <span id="qb_progress_percent">0</span>% <span id="qb_progress_message"></span>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script>
	function check_quickbooks_status()
	{
		$.getJSON(SITE_URL+'/home/get_qb_sync_progress', function(response)
		{
			set_qb_progress(response.percent_complete,response.message);
		
			if (response.running)
			{
				setTimeout(check_quickbooks_status,5000);
			}
		});
	}
	
	function set_qb_progress(percent, message)
	{
		$("#qb_progress_container").show();
		$('#qb_progessbar').attr('aria-valuenow', percent).css('width',percent+'%');
		$('#qb_progress_percent').html(percent);
		if (message !='')
		{
			$("#qb_progress_message").html('('+message+')');
		}
		else
		{
			$("#qb_progress_message").html('');
		}
		
	}
	check_quickbooks_status();
	</script>
	
	<?php } ?>
	
	

	<!--begin::Row-->
	<div class="row g-5 g-xl-10">
										<!--begin::Col-->
										<div class="col-xl-4 mb-xl-10">
											<!--begin::Lists Widget 19-->
											<div class="card card-flush h-xl-100">
												<!--begin::Heading-->
												<div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px" style="background-image:url('<?php echo base_url();?>assets/css_good/media/svg/shapes/top-green.png" data-theme="light">
													<!--begin::Title-->
													<h3 class="card-title align-items-start flex-column text-white pt-15">
														<span class="fw-bold fs-2x mb-3">Hello, Admin</span>
														<div class="fs-4 text-white">
															<!-- <span class="opacity-75">You have</span>
															<span class="position-relative d-inline-block">
																<a href="../dist/pages/user-profile/projects.html" class="link-white opacity-75-hover fw-bold d-block mb-1">4 tasks</a>
															
																<span class="position-absolute opacity-50 bottom-0 start-0 border-2 border-body border-bottom w-100"></span>
															
															</span>
															<span class="opacity-75">to comlete</span> -->
														</div>
													</h3>
													<!--end::Title-->
												
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div class="card-body mt-n20">
													<!--begin::Stats-->
													<div class="mt-n20 position-relative">
														<!--begin::Row-->
														<div class="row g-3 g-lg-6">
															<!--begin::Col-->
															<div class="col-6">
																<!--begin::Items-->
																<div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
																	<!--begin::Symbol-->
																	<div class="symbol symbol-30px me-5 mb-8">
																		<span class="symbol-label">
																			<!--begin::Svg Icon | path: icons/duotune/medicine/med005.svg-->
																			<span class="svg-icon svg-icon-1 svg-icon-primary">
																			<i class="fas fa-shopping-cart text-primary"></i>
																			</span>
																			<!--end::Svg Icon-->
																		</span>
																	</div>
																	<!--end::Symbol-->
																	<!--begin::Stats-->
																	<div class="m-0">
																		<!--begin::Number-->
																		<span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $total_sales; ?></span>
																		<!--end::Number-->
																		<!--begin::Desc-->
																		<span class="text-gray-500 fw-semibold fs-6"><?php echo lang('common_total')." ".lang('module_sales'); ?></span>
																		<!--end::Desc-->
																	</div>
																	<!--end::Stats-->
																</div>
																<!--end::Items-->
															</div>
															<!--end::Col-->
															<!--begin::Col-->
															<div class="col-6">
																<!--begin::Items-->
																<div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
																	<!--begin::Symbol-->
																	<div class="symbol symbol-30px me-5 mb-8">
																		<span class="symbol-label">
																			<!--begin::Svg Icon | path: icons/duotune/finance/fin001.svg-->
																			<span class="svg-icon svg-icon-1 svg-icon-primary">
																			<i class="fas fa-users text-primary"></i>
																			</span>
																			<!--end::Svg Icon-->
																		</span>
																	</div>
																	<!--end::Symbol-->
																	<!--begin::Stats-->
																	<div class="m-0">
																		<!--begin::Number-->
																		<span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $total_customers; ?></span>
																		<!--end::Number-->
																		<!--begin::Desc-->
																		<span class="text-gray-500 fw-semibold fs-6"><?php echo lang('common_total')." ".lang('module_customers'); ?></span>
																		<!--end::Desc-->
																	</div>
																	<!--end::Stats-->
																</div>
																<!--end::Items-->
															</div>
															<!--end::Col-->
															<!--begin::Col-->
															<div class="col-6">
																<!--begin::Items-->
																<div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
																	<!--begin::Symbol-->
																	<div class="symbol symbol-30px me-5 mb-8">
																		<span class="symbol-label">
																			<!--begin::Svg Icon | path: icons/duotune/general/gen020.svg-->
																			<span class="svg-icon svg-icon-1 svg-icon-primary">
																			<i class="fas fa-hdd text-primary"></i>
																			</span>
																			<!--end::Svg Icon-->
																		</span>
																	</div>
																	<!--end::Symbol-->
																	<!--begin::Stats-->
																	<div class="m-0">
																		<!--begin::Number-->
																		<span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $total_items; ?></span>
																		<!--end::Number-->
																		<!--begin::Desc-->
																		<span class="text-gray-500 fw-semibold fs-6"><?php echo lang('common_total')." ".lang('module_items'); ?></span>
																		<!--end::Desc-->
																	</div>
																	<!--end::Stats-->
																</div>
																<!--end::Items-->
															</div>
															<!--end::Col-->

															<?php
															if ($this->Employee->has_module_permission('item_kits',$this->Employee->get_logged_in_employee_info()->person_id))
															{
															?>
															<!--begin::Col-->
															<div class="col-6">
																<!--begin::Items-->
																<div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
																	<!--begin::Symbol-->
																	<div class="symbol symbol-30px me-5 mb-8">
																		<span class="symbol-label">
																			<!--begin::Svg Icon | path: icons/duotune/general/gen013.svg-->
																			<span class="svg-icon svg-icon-1 svg-icon-primary">
																			<i class="fas fa-th-list text-primary"></i>
																			</span>
																			<!--end::Svg Icon-->
																		</span>
																	</div>
																	<!--end::Symbol-->
																	<!--begin::Stats-->
																	<div class="m-0">
																		<!--begin::Number-->
																		<span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $total_item_kits; ?></span>
																		<!--end::Number-->
																		<!--begin::Desc-->
																		<span class="text-gray-500 fw-semibold fs-6"><?php echo lang('common_total')." ".lang('module_item_kits'); ?></span>
																		<!--end::Desc-->
																	</div>
																	<!--end::Stats-->
																</div>
																<!--end::Items-->
															</div>
															<!--end::Col-->
															<?php } ?>

														</div>
														<!--end::Row-->
													</div>
													<!--end::Stats-->
												</div>
												<!--end::Body-->
											</div>
											<!--end::Lists Widget 19-->
										</div>
										<!--end::Col-->
										<!--begin::Col-->
										<div class="col-xl-8 mb-5 mb-xl-10">
											<!--begin::Row-->
											<div class="row g-5 g-xl-10">
												<!--begin::Col-->
												<div class="col-xl-6 mb-xl-10">
													<!--begin::Slider Widget 1-->
													<div id="kt_sliders_widget_1_slider" class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100" data-bs-ride="carousel" data-bs-interval="5000">
														<!--begin::Header-->
														<div class="card-header pt-5">
															<!--begin::Title-->
															<h4 class="card-title d-flex align-items-start flex-column">
																<span class="card-label fw-bold text-gray-800">Today’s Course</span>
																<span class="text-gray-400 mt-1 fw-bold fs-7">4 lessons, 3 hours 45 minutes</span>
															</h4>
															<!--end::Title-->
															<!--begin::Toolbar-->
															<div class="card-toolbar">
																<!--begin::Carousel Indicators-->
																<ol class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
																	<li data-bs-target="#kt_sliders_widget_1_slider" data-bs-slide-to="0" class="active ms-1"></li>
																	<li data-bs-target="#kt_sliders_widget_1_slider" data-bs-slide-to="1" class="ms-1"></li>
																	<li data-bs-target="#kt_sliders_widget_1_slider" data-bs-slide-to="2" class="ms-1"></li>
																</ol>
																<!--end::Carousel Indicators-->
															</div>
															<!--end::Toolbar-->
														</div>
														<!--end::Header-->
														<!--begin::Body-->
														<div class="card-body pt-6">
															<!--begin::Carousel-->
															<div class="carousel-inner mt-n5">
																<!--begin::Item-->
																<div class="carousel-item active show">
																	<!--begin::Wrapper-->
																	<div class="d-flex align-items-center mb-5">
																		<!--begin::Chart-->
																		<div class="w-80px flex-shrink-0 me-2">
																			<div class="min-h-auto ms-n3" id="kt_slider_widget_1_chart_1" style="height: 100px"></div>
																		</div>
																		<!--end::Chart-->
																		<!--begin::Info-->
																		<div class="m-0">
																			<!--begin::Subtitle-->
																			<h4 class="fw-bold text-gray-800 mb-3">Coming Soon</h4>
																			<!--end::Subtitle-->
																			<!--begin::Items-->
																			<div class="d-flex d-grid gap-5">
																				<!--begin::Item-->
																				<div class="d-flex flex-column flex-shrink-0 me-4">
																					<!--begin::Section-->
																					<span class="d-flex align-items-center fs-7 fw-bold text-gray-400 mb-2">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->3 Topics</span>
																					<!--end::Section-->
																					<!--begin::Section-->
																					<span class="d-flex align-items-center text-gray-400 fw-bold fs-7">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->1 Speakers</span>
																					<!--end::Section-->
																				</div>
																				<!--end::Item-->
																				<!--begin::Item-->
																				<div class="d-flex flex-column flex-shrink-0">
																					<!--begin::Section-->
																					<span class="d-flex align-items-center fs-7 fw-bold text-gray-400 mb-2">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->50 Min</span>
																					<!--end::Section-->
																					<!--begin::Section-->
																					<span class="d-flex align-items-center text-gray-400 fw-bold fs-7">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->72 students</span>
																					<!--end::Section-->
																				</div>
																				<!--end::Item-->
																			</div>
																			<!--end::Items-->
																		</div>
																		<!--end::Info-->
																	</div>
																	<!--end::Wrapper-->
																	<!--begin::Action-->
																	<div class="mb-1">
																		<a href="#" class="btn btn-sm btn-light me-2">Skip This</a>
																		<a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Continue</a>
																	</div>
																	<!--end::Action-->
																</div>
																<!--end::Item-->
																<!--begin::Item-->
																<div class="carousel-item">
																	<!--begin::Wrapper-->
																	<div class="d-flex align-items-center mb-5">
																		<!--begin::Chart-->
																		<div class="w-80px flex-shrink-0 me-2">
																			<div class="min-h-auto ms-n3" id="kt_slider_widget_1_chart_2" style="height: 100px"></div>
																		</div>
																		<!--end::Chart-->
																		<!--begin::Info-->
																		<div class="m-0">
																			<!--begin::Subtitle-->
																			<h4 class="fw-bold text-gray-800 mb-3">Coming Soon</h4>
																			<!--end::Subtitle-->
																			<!--begin::Items-->
																			<div class="d-flex d-grid gap-5">
																				<!--begin::Item-->
																				<div class="d-flex flex-column flex-shrink-0 me-4">
																					<!--begin::Section-->
																					<span class="d-flex align-items-center fs-7 fw-bold text-gray-400 mb-2">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->3 Topics</span>
																					<!--end::Section-->
																					<!--begin::Section-->
																					<span class="d-flex align-items-center text-gray-400 fw-bold fs-7">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->1 Speakers</span>
																					<!--end::Section-->
																				</div>
																				<!--end::Item-->
																				<!--begin::Item-->
																				<div class="d-flex flex-column flex-shrink-0">
																					<!--begin::Section-->
																					<span class="d-flex align-items-center fs-7 fw-bold text-gray-400 mb-2">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->50 Min</span>
																					<!--end::Section-->
																					<!--begin::Section-->
																					<span class="d-flex align-items-center text-gray-400 fw-bold fs-7">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->72 students</span>
																					<!--end::Section-->
																				</div>
																				<!--end::Item-->
																			</div>
																			<!--end::Items-->
																		</div>
																		<!--end::Info-->
																	</div>
																	<!--end::Wrapper-->
																	<!--begin::Action-->
																	<div class="mb-1">
																		<a href="#" class="btn btn-sm btn-light me-2">Skip This</a>
																		<a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Continue</a>
																	</div>
																	<!--end::Action-->
																</div>
																<!--end::Item-->
																<!--begin::Item-->
																<div class="carousel-item">
																	<!--begin::Wrapper-->
																	<div class="d-flex align-items-center mb-5">
																		<!--begin::Chart-->
																		<div class="w-80px flex-shrink-0 me-2">
																			<div class="min-h-auto ms-n3" id="kt_slider_widget_1_chart_3" style="height: 100px"></div>
																		</div>
																		<!--end::Chart-->
																		<!--begin::Info-->
																		<div class="m-0">
																			<!--begin::Subtitle-->
																			<h4 class="fw-bold text-gray-800 mb-3">Coming Soon</h4>
																			<!--end::Subtitle-->
																			<!--begin::Items-->
																			<div class="d-flex d-grid gap-5">
																				<!--begin::Item-->
																				<div class="d-flex flex-column flex-shrink-0 me-4">
																					<!--begin::Section-->
																					<span class="d-flex align-items-center fs-7 fw-bold text-gray-400 mb-2">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->3 Topics</span>
																					<!--end::Section-->
																					<!--begin::Section-->
																					<span class="d-flex align-items-center text-gray-400 fw-bold fs-7">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->1 Speakers</span>
																					<!--end::Section-->
																				</div>
																				<!--end::Item-->
																				<!--begin::Item-->
																				<div class="d-flex flex-column flex-shrink-0">
																					<!--begin::Section-->
																					<span class="d-flex align-items-center fs-7 fw-bold text-gray-400 mb-2">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->50 Min</span>
																					<!--end::Section-->
																					<!--begin::Section-->
																					<span class="d-flex align-items-center text-gray-400 fw-bold fs-7">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->72 students</span>
																					<!--end::Section-->
																				</div>
																				<!--end::Item-->
																			</div>
																			<!--end::Items-->
																		</div>
																		<!--end::Info-->
																	</div>
																	<!--end::Wrapper-->
																	<!--begin::Action-->
																	<div class="mb-1">
																		<a href="#" class="btn btn-sm btn-light me-2">Skip This</a>
																		<a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Continue</a>
																	</div>
																	<!--end::Action-->
																</div>
																<!--end::Item-->
															</div>
															<!--end::Carousel-->
														</div>
														<!--end::Body-->
													</div>
													<!--end::Slider Widget 1-->
												</div>
												<!--end::Col-->
												<!--begin::Col-->
												<div class="col-xl-6 mb-5 mb-xl-10">
													<!--begin::Slider Widget 2-->
													<div id="kt_sliders_widget_2_slider" class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100" data-bs-ride="carousel" data-bs-interval="5500">
														<!--begin::Header-->
														<div class="card-header pt-5">
															<!--begin::Title-->
															<h4 class="card-title d-flex align-items-start flex-column">
																<span class="card-label fw-bold text-gray-800">Today’s Events</span>
																<span class="text-gray-400 mt-1 fw-bold fs-7">24 events on all activities</span>
															</h4>
															<!--end::Title-->
															<!--begin::Toolbar-->
															<div class="card-toolbar">
																<!--begin::Carousel Indicators-->
																<ol class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-success">
																	<li data-bs-target="#kt_sliders_widget_2_slider" data-bs-slide-to="0" class="active ms-1"></li>
																	<li data-bs-target="#kt_sliders_widget_2_slider" data-bs-slide-to="1" class="ms-1"></li>
																	<li data-bs-target="#kt_sliders_widget_2_slider" data-bs-slide-to="2" class="ms-1"></li>
																</ol>
																<!--end::Carousel Indicators-->
															</div>
															<!--end::Toolbar-->
														</div>
														<!--end::Header-->
														<!--begin::Body-->
														<div class="card-body pt-6">
															<!--begin::Carousel-->
															<div class="carousel-inner">
																<!--begin::Item-->
																<div class="carousel-item active show">
																	<!--begin::Wrapper-->
																	<div class="d-flex align-items-center mb-9">
																		<!--begin::Symbol-->
																		<div class="symbol symbol-70px symbol-circle me-5">
																			<span class="symbol-label bg-light-success">
																				<!--begin::Svg Icon | path: icons/duotune/abstract/abs025.svg-->
																				<span class="svg-icon svg-icon-3x svg-icon-success">
																					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																						<path d="M16.925 3.90078V8.00077L12.025 10.8008V5.10078L15.525 3.10078C16.125 2.80078 16.925 3.20078 16.925 3.90078ZM2.525 13.5008L6.025 15.5008L10.925 12.7008L6.025 9.90078L2.525 11.9008C1.825 12.3008 1.825 13.2008 2.525 13.5008ZM18.025 19.7008V15.6008L13.125 12.8008V18.5008L16.625 20.5008C17.225 20.8008 18.025 20.4008 18.025 19.7008Z" fill="currentColor" />
																						<path opacity="0.3" d="M8.52499 3.10078L12.025 5.10078V10.8008L7.125 8.00077V3.90078C7.125 3.20078 7.92499 2.80078 8.52499 3.10078ZM7.42499 20.5008L10.925 18.5008V12.8008L6.02499 15.6008V19.7008C6.02499 20.4008 6.82499 20.8008 7.42499 20.5008ZM21.525 11.9008L18.025 9.90078L13.125 12.7008L18.025 15.5008L21.525 13.5008C22.225 13.2008 22.225 12.3008 21.525 11.9008Z" fill="currentColor" />
																					</svg>
																				</span>
																				<!--end::Svg Icon-->
																			</span>
																		</div>
																		<!--end::Symbol-->
																		<!--begin::Info-->
																		<div class="m-0">
																			<!--begin::Subtitle-->
																			<h4 class="fw-bold text-gray-800 mb-3">Coming Soon</h4>
																			<!--end::Subtitle-->
																			<!--begin::Items-->
																			<div class="d-flex d-grid gap-5">
																				<!--begin::Item-->
																				<div class="d-flex flex-column flex-shrink-0 me-4">
																					<!--begin::Section-->
																					<span class="d-flex align-items-center fs-7 fw-bold text-gray-400 mb-2">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->5 Topics</span>
																					<!--end::Section-->
																					<!--begin::Section-->
																					<span class="d-flex align-items-center text-gray-400 fw-bold fs-7">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->1 Speakers</span>
																					<!--end::Section-->
																				</div>
																				<!--end::Item-->
																				<!--begin::Item-->
																				<div class="d-flex flex-column flex-shrink-0">
																					<!--begin::Section-->
																					<span class="d-flex align-items-center fs-7 fw-bold text-gray-400 mb-2">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->60 Min</span>
																					<!--end::Section-->
																					<!--begin::Section-->
																					<span class="d-flex align-items-center text-gray-400 fw-bold fs-7">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->137 students</span>
																					<!--end::Section-->
																				</div>
																				<!--end::Item-->
																			</div>
																			<!--end::Items-->
																		</div>
																		<!--end::Info-->
																	</div>
																	<!--end::Wrapper-->
																	<!--begin::Action-->
																	<div class="mb-1">
																		<a href="#" class="btn btn-sm btn-light me-2">Details</a>
																		<a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign">Join Event</a>
																	</div>
																	<!--end::Action-->
																</div>
																<!--end::Item-->
																<!--begin::Item-->
																<div class="carousel-item">
																	<!--begin::Wrapper-->
																	<div class="d-flex align-items-center mb-9">
																		<!--begin::Symbol-->
																		<div class="symbol symbol-70px symbol-circle me-5">
																			<span class="symbol-label bg-light-danger">
																				<!--begin::Svg Icon | path: icons/duotune/abstract/abs026.svg-->
																				<span class="svg-icon svg-icon-3x svg-icon-danger">
																					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																						<path opacity="0.3" d="M7 20.5L2 17.6V11.8L7 8.90002L12 11.8V17.6L7 20.5ZM21 20.8V18.5L19 17.3L17 18.5V20.8L19 22L21 20.8Z" fill="currentColor" />
																						<path d="M22 14.1V6L15 2L8 6V14.1L15 18.2L22 14.1Z" fill="currentColor" />
																					</svg>
																				</span>
																				<!--end::Svg Icon-->
																			</span>
																		</div>
																		<!--end::Symbol-->
																		<!--begin::Info-->
																		<div class="m-0">
																			<!--begin::Subtitle-->
																			<h4 class="fw-bold text-gray-800 mb-3">Coming Soon</h4>
																			<!--end::Subtitle-->
																			<!--begin::Items-->
																			<div class="d-flex d-grid gap-5">
																				<!--begin::Item-->
																				<div class="d-flex flex-column flex-shrink-0 me-4">
																					<!--begin::Section-->
																					<span class="d-flex align-items-center fs-7 fw-bold text-gray-400 mb-2">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->12 Topics</span>
																					<!--end::Section-->
																					<!--begin::Section-->
																					<span class="d-flex align-items-center text-gray-400 fw-bold fs-7">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->1 Speakers</span>
																					<!--end::Section-->
																				</div>
																				<!--end::Item-->
																				<!--begin::Item-->
																				<div class="d-flex flex-column flex-shrink-0">
																					<!--begin::Section-->
																					<span class="d-flex align-items-center fs-7 fw-bold text-gray-400 mb-2">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->50 Min</span>
																					<!--end::Section-->
																					<!--begin::Section-->
																					<span class="d-flex align-items-center text-gray-400 fw-bold fs-7">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->72 students</span>
																					<!--end::Section-->
																				</div>
																				<!--end::Item-->
																			</div>
																			<!--end::Items-->
																		</div>
																		<!--end::Info-->
																	</div>
																	<!--end::Wrapper-->
																	<!--begin::Action-->
																	<div class="mb-1">
																		<a href="#" class="btn btn-sm btn-light me-2">Details</a>
																		<a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign">Join Event</a>
																	</div>
																	<!--end::Action-->
																</div>
																<!--end::Item-->
																<!--begin::Item-->
																<div class="carousel-item">
																	<!--begin::Wrapper-->
																	<div class="d-flex align-items-center mb-9">
																		<!--begin::Symbol-->
																		<div class="symbol symbol-70px symbol-circle me-5">
																			<span class="symbol-label bg-light-primary">
																				<!--begin::Svg Icon | path: icons/duotune/abstract/abs038.svg-->
																				<span class="svg-icon svg-icon-3x svg-icon-primary">
																					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																						<path d="M12.0444 17.9444V12.1444L17.0444 15.0444C18.6444 15.9444 19.1445 18.0444 18.2445 19.6444C17.3445 21.2444 15.2445 21.7444 13.6445 20.8444C12.6445 20.2444 12.0444 19.1444 12.0444 17.9444ZM7.04445 15.0444L12.0444 12.1444L7.04445 9.24445C5.44445 8.34445 3.44444 8.84445 2.44444 10.4444C1.54444 12.0444 2.04445 14.0444 3.64445 15.0444C4.74445 15.6444 6.04445 15.6444 7.04445 15.0444ZM12.0444 6.34444V12.1444L17.0444 9.24445C18.6444 8.34445 19.1445 6.24444 18.2445 4.64444C17.3445 3.04444 15.2445 2.54445 13.6445 3.44445C12.6445 4.04445 12.0444 5.14444 12.0444 6.34444Z" fill="currentColor" />
																						<path opacity="0.3" d="M7.04443 9.24445C6.04443 8.64445 5.34442 7.54444 5.34442 6.34444C5.34442 4.54444 6.84444 3.04443 8.64444 3.04443C10.4444 3.04443 11.9444 4.54444 11.9444 6.34444V12.1444L7.04443 9.24445ZM17.0444 15.0444C18.0444 15.6444 19.3444 15.6444 20.3444 15.0444C21.9444 14.1444 22.4444 12.0444 21.5444 10.4444C20.6444 8.84444 18.5444 8.34445 16.9444 9.24445L11.9444 12.1444L17.0444 15.0444ZM7.04443 15.0444C6.04443 15.6444 5.34442 16.7444 5.34442 17.9444C5.34442 19.7444 6.84444 21.2444 8.64444 21.2444C10.4444 21.2444 11.9444 19.7444 11.9444 17.9444V12.1444L7.04443 15.0444Z" fill="currentColor" />
																					</svg>
																				</span>
																				<!--end::Svg Icon-->
																			</span>
																		</div>
																		<!--end::Symbol-->
																		<!--begin::Info-->
																		<div class="m-0">
																			<!--begin::Subtitle-->
																			<h4 class="fw-bold text-gray-800 mb-3">Coming Soon</h4>
																			<!--end::Subtitle-->
																			<!--begin::Items-->
																			<div class="d-flex d-grid gap-5">
																				<!--begin::Item-->
																				<div class="d-flex flex-column flex-shrink-0 me-4">
																					<!--begin::Section-->
																					<span class="d-flex align-items-center fs-7 fw-bold text-gray-400 mb-2">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->3 Topics</span>
																					<!--end::Section-->
																					<!--begin::Section-->
																					<span class="d-flex align-items-center text-gray-400 fw-bold fs-7">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->1 Speakers</span>
																					<!--end::Section-->
																				</div>
																				<!--end::Item-->
																				<!--begin::Item-->
																				<div class="d-flex flex-column flex-shrink-0">
																					<!--begin::Section-->
																					<span class="d-flex align-items-center fs-7 fw-bold text-gray-400 mb-2">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->50 Min</span>
																					<!--end::Section-->
																					<!--begin::Section-->
																					<span class="d-flex align-items-center text-gray-400 fw-bold fs-7">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
																					<span class="svg-icon svg-icon-6 svg-icon-gray-600 me-2">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																							<path d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z" fill="currentColor" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->72 students</span>
																					<!--end::Section-->
																				</div>
																				<!--end::Item-->
																			</div>
																			<!--end::Items-->
																		</div>
																		<!--end::Info-->
																	</div>
																	<!--end::Wrapper-->
																	<!--begin::Action-->
																	<div class="mb-1">
																		<a href="#" class="btn btn-sm btn-light me-2">Details</a>
																		<a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign">Join Event</a>
																	</div>
																	<!--end::Action-->
																</div>
																<!--end::Item-->
															</div>
															<!--end::Carousel-->
														</div>
														<!--end::Body-->
													</div>
													<!--end::Slider Widget 2-->
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
											<!--begin::Engage widget 4-->
											<div class="card border-transparent" data-theme="light" style="background-color: #1C325E;">
												<!--begin::Body-->
												<div class="card-body d-flex ps-xl-15">
													<!--begin::Wrapper-->
													<div class="m-0">
														<!--begin::Title-->
														<div class="position-relative fs-2x z-index-2 fw-bold text-white mb-7">
														<span class="me-2"><?php echo lang('home_welcome_message');?></div>
														<!--end::Title-->
														<!--begin::Action-->
														
														<!--begin::Action-->
													</div>
													<!--begin::Wrapper-->
													<!--begin::Illustration-->
													<img src="assets/media/illustrations/sigma-1/17-dark.png" class="position-absolute me-3 bottom-0 end-0 h-200px" alt="" />
													<!--end::Illustration-->
												</div>
												<!--end::Body-->
											</div>
											<!--end::Engage widget 4-->
										</div>
										<!--end::Col-->
									</div>
									<!--end::Row-->

	
</div>

<?php } ?>


<!--begin::Row-->
<div class="row g-5 g-xl-10">
										<!--begin::Col-->
										<div class="col-xl-4 mb-xl-10">
											<!--begin::List widget 20-->
											<div class="card h-xl-100">
												<!--begin::Header-->
												<div class="card-header border-0 pt-5">
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-dark">List of Comman Tasks</span>
														</h3>
													<!--begin::Toolbar-->
													<!-- <div class="card-toolbar">
														<a href="#" class="btn btn-sm btn-light">All Courses</a>
													</div> -->
													<!--end::Toolbar-->
												</div>
												<!--end::Header-->
												<!--begin::Body-->
												<div class="card-body pt-6">

												<?php if ($this->Employee->has_module_permission('sales', $this->Employee->get_logged_in_employee_info()->person_id)) {	?>
	
													<!--begin::Item-->
													<div class="d-flex flex-stack">
														<!--begin::Symbol-->
														<div class="symbol symbol-40px me-4">
															<div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger">
																<i class="fas fa-shopping-cart text-light"></i>
															</div>
														</div>
														<!--end::Symbol-->
														<!--begin::Section-->
														<div class="d-flex align-items-center flex-row-fluid flex-wrap">
															<!--begin:Author-->
															<div class="flex-grow-1 me-2">
																<a href="<?php echo site_url('sales'); ?>" class="text-gray-800 text-hover-primary fs-6 fw-bold"><?php echo lang('common_start_new_sale'); ?></a>
																
															</div>
															<!--end:Author-->
															<!--begin::Actions-->
															<a href="<?php echo site_url('sales'); ?>" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
																<span class="svg-icon svg-icon-2">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
																		<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</a>
															<!--begin::Actions-->
														</div>
														<!--end::Section-->
													</div>
													<!--end::Item-->

													<?php } ?>


													<?php if ($this->Employee->has_module_permission('receivings', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
		<!--begin::Separator-->
		<div class="separator separator-dashed my-4"></div>
													<!--end::Separator-->
													<!--begin::Item-->
													<div class="d-flex flex-stack">
														<!--begin::Symbol-->
														<div class="symbol symbol-40px me-4">
															<div class="symbol-label fs-2 fw-semibold bg-success text-inverse-success">
																<i class="fas fa-cloud-download text-light"></i>
															</div>
														</div>
														<!--end::Symbol-->
														<!--begin::Section-->
														<div class="d-flex align-items-center flex-row-fluid flex-wrap">
															<!--begin:Author-->
															<div class="flex-grow-1 me-2">
																<a href="<?php echo site_url('receivings'); ?>" class="text-gray-800 text-hover-primary fs-6 fw-bold"><?php echo lang('home_receivings_start_new_receiving'); ?></a>
															</div>
															<!--end:Author-->
															<!--begin::Actions-->
															<a href="<?php echo site_url('receivings'); ?>" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
																<span class="svg-icon svg-icon-2">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
																		<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</a>
															<!--begin::Actions-->
														</div>
														<!--end::Section-->
													</div>
													<!--end::Item-->
													<?php } ?>	
													<?php if ($this->Employee->has_module_action_permission('reports', 'view_closeout', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
		<!--begin::Separator-->
		<div class="separator separator-dashed my-4"></div>
													<!--end::Separator-->
													<!--begin::Item-->
													<div class="d-flex flex-stack">
														<!--begin::Symbol-->
														<div class="symbol symbol-40px me-4">
															<div class="symbol-label fs-2 fw-semibold bg-info text-inverse-info">
																<i class="fas fa-clock text-light"></i>
															</div>
														</div>
														<!--end::Symbol-->
														<!--begin::Section-->
														<div class="d-flex align-items-center flex-row-fluid flex-wrap">
															<!--begin:Author-->
															<div class="flex-grow-1 me-2">
																<a href="<?php echo site_url('reports/generate/closeout?report_type=simple&report_date_range_simple=TODAY');?>&export_excel=0" class="text-gray-800 text-hover-primary fs-6 fw-bold"><?php echo lang('home_todays_closeout_report'); ?></a>
																</div>
															<!--end:Author-->
															<!--begin::Actions-->
															<a href="<?php echo site_url('reports/generate/closeout?report_type=simple&report_date_range_simple=TODAY');?>&export_excel=0" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
																<span class="svg-icon svg-icon-2">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
																		<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</a>
															<!--begin::Actions-->
														</div>
														<!--end::Section-->
													</div>
													<!--end::Item-->

													<?php } ?>


												
													<?php if ($this->Employee->has_module_action_permission('reports', 'view_sales', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
		<!--begin::Separator-->
		<div class="separator separator-dashed my-4"></div>
													<!--end::Separator-->
													<!--begin::Item-->
													<div class="d-flex flex-stack">
														<!--begin::Symbol-->
														<div class="symbol symbol-40px me-4">
															<div class="symbol-label fs-2 fw-semibold bg-primary text-inverse-primary">
															<i class="fas fa-clock text-light"></i>
															</div>
														</div>
														<!--end::Symbol-->
														<!--begin::Section-->
														<div class="d-flex align-items-center flex-row-fluid flex-wrap">
															<!--begin:Author-->
															<div class="flex-grow-1 me-2">
																<a href="<?php echo site_url('reports/generate/detailed_sales?report_type=simple&report_date_range_simple=TODAY&sale_type=all&with_time=1&excel_export=0');?>&export_excel=0" class="text-gray-800 text-hover-primary fs-6 fw-bold"><?php echo lang('home_todays_detailed_sales_report'); ?></a>
																
															</div>
															<!--end:Author-->
															<!--begin::Actions-->
															<a href="<?php echo site_url('reports/generate/detailed_sales?report_type=simple&report_date_range_simple=TODAY&sale_type=all&with_time=1&excel_export=0');?>&export_excel=0" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
																<span class="svg-icon svg-icon-2">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
																		<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</a>
															<!--begin::Actions-->
														</div>
														<!--end::Section-->
													</div>
													<?php } ?>
													<!--end::Item-->
												
													<?php if ($this->Employee->has_module_action_permission('reports', 'view_items', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
		<!--begin::Separator-->
		<div class="separator separator-dashed my-4"></div>
													<!--end::Separator-->
													<!--begin::Item-->
													<div class="d-flex flex-stack">
														<!--begin::Symbol-->
														<div class="symbol symbol-40px me-4">
															<div class="symbol-label fs-2 fw-semibold bg-warning text-inverse-warning">
															<i class="fas fa-chart-bar text-light"></i>
														
															</div>
														</div>
														<!--end::Symbol-->
														<!--begin::Section-->
														<div class="d-flex align-items-center flex-row-fluid flex-wrap">
															<!--begin:Author-->
															<div class="flex-grow-1 me-2">
																<a href="<?php echo site_url('reports/generate/summary_items?category_id=&supplier_id=&sale_type=all&items_to_show=items_with_sales&report_type=simple&report_date_range_simple=TODAY&export_excel=0&with_time=1'); ?>" class="text-gray-800 text-hover-primary fs-6 fw-bold"><?php echo lang('home_todays_summary_items_report'); ?></a>
																
															</div>
															<!--end:Author-->
															<!--begin::Actions-->
															<a href="<?php echo site_url('reports/generate/summary_items?category_id=&supplier_id=&sale_type=all&items_to_show=items_with_sales&report_type=simple&report_date_range_simple=TODAY&export_excel=0&with_time=1'); ?>" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
																<span class="svg-icon svg-icon-2">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
																		<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</a>
															<!--begin::Actions-->
														</div>
														<!--end::Section-->
													</div>
													<!--end::Item-->
													
													<?php } ?>

													<!--begin::Item-->
													<div class="d-flex flex-stack">
														<!--begin::Symbol-->
														<div class="symbol symbol-40px me-4">
															<div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger">
																<i class="fas fa-money-bill text-light"></i>
															</div>
														</div>
														<!--end::Symbol-->
														<!--begin::Section-->
														<div class="d-flex align-items-center flex-row-fluid flex-wrap">
															<!--begin:Author-->
															<div class="flex-grow-1 me-2">
																<a href="<?php echo site_url('sales'); ?>/select_regeister" class="text-gray-800 text-hover-primary fs-6 fw-bold">Change Register</a>
																
															</div>
															<!--end:Author-->
															<!--begin::Actions-->
															<a href="<?php echo site_url('sales'); ?>/select_regeister" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
																<span class="svg-icon svg-icon-2">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
																		<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</a>
															<!--begin::Actions-->
														</div>
														<!--end::Section-->
													</div>
													<!--end::Item-->
												
													<?php foreach($saved_reports as $key => $report) { 
		
		$report_url = $report['url'];
		$report_url.=(parse_url($report['url'], PHP_URL_QUERY) ? '&' : '?') . "key=$key";
		?>
			<!--begin::Separator-->
			<div class="separator separator-dashed my-4"></div>
													<!--end::Separator-->
													<!--begin::Item-->
													<div class="d-flex flex-stack">
														<!--begin::Symbol-->
														<div class="symbol symbol-40px me-4">
															<div class="symbol-label fs-2 fw-semibold bg-dark text-inverse-dark">
															<i class="fas fa-star text-light "></i>
															</div>
														</div>
														<!--end::Symbol-->
														<!--begin::Section-->
														<div class="d-flex align-items-center flex-row-fluid flex-wrap">
															<!--begin:Author-->
															<div class="flex-grow-1 me-2">
																<a href="<?php echo site_url($report_url);?>" class="text-gray-800 text-hover-primary fs-6 fw-bold"><?php echo $report['name']; ?></a>
															</div>
															<!--end:Author-->
															<!--begin::Actions-->
															<a href="<?php echo site_url($report_url);?>" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
																<span class="svg-icon svg-icon-2">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
																		<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</a>
															<!--begin::Actions-->
														</div>
														<!--end::Section-->
													</div>
													<!--end::Item-->
														<!--begin::Separator-->
														<div class="separator separator-dashed my-4"></div>
													<!--end::Separator-->
													<?php } ?>
												</div>
												<!--end::Body-->
											</div>
											<!--end::List widget 20-->
										</div>
										<!--end::Col-->
										<!--begin::Col-->
										<div class="col-xl-8 mb-5 mb-xl-10">
											<!--begin::Timeline Widget 1-->
											<div class="card card-flush h-xl-100">
												
												<!--begin::Card body-->
												<div class="card-body pb-0">
												<?php if ($this->Employee->has_module_action_permission('reports', 'view_dashboard_stats', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
													<div class="row ">
															<div class="col-md-12">
																<div class="panel">
																	<div class="panel-body">
																		
																		<?php if (can_display_graphical_report()) { ?>
																		<div class="panel-heading rounded border-primary border border-dashed rounded-3 ">
																			<h4 class="text-center"><?php echo lang('common_sales_info') ?></h4>	
																		</div>
																		<!-- Nav tabs -->
																	
																	


																			<ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
																				<li class="nav-item">
																					<a class="nav-link active" data-bs-toggle="tab" href="#monthly"><?php echo lang('common_month') ?></a></a>
																				</li>
																				<li class="nav-item">
																					<a class="nav-link" data-bs-toggle="tab" href="#weekly"><?php echo lang('common_week') ?></a></a>
																				</li>
																				

																			</ul>

																			<div class="tab-content" id="myTabContent">
																				<div class="tab-pane fade show active" id="monthly" role="tabpanel">
																				<div class="chart">
																											<?php if(isset($month_sale) && !isset($month_sale['message'])){ ?>
																												<canvas id="charts" width="400" height="100"></canvas>		
																											<?php } else{ 
																												echo $month_sale['message'];
																												} ?>
																										</div>
																				</div>
																				<div class="tab-pane fade" id="weekly" role="tabpanel">
																				
																				</div>


																			</div>

																			<?php } ?>
																	</div>
																</div>
															</div>
														</div>
														<?php } ?>
													</div>
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Timeline Widget 1-->
										</div>
										<!--end::Col-->

									
	

	<?php if(!$this->config->item('hide_expire_dashboard') && count($expiring_items) > 0) { ?> 
											<!--begin::Col-->
											<div class="col-xl-12">
											<!--begin::Tables widget 14-->
											<div class="card card-flush h-md-100">
												<!--begin::Header-->
												<div class="card-header pt-7">
													<!--begin::Title-->
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-gray-800"><?php echo lang('home_items_expiring_soon')?></span>
														
													</h3>
													<!--end::Title-->
													<!--begin::Toolbar
													<div class="card-toolbar">
														<a href="../dist/apps/ecommerce/catalog/add-product.html" class="btn btn-sm btn-light">History</a>
													</div>
													end::Toolbar-->
												</div>
												<!--end::Header-->
												<!--begin::Body-->
												<div class="card-body pt-6">
													<!--begin::Table container-->
													<div class="table-responsive">
														<!--begin::Table-->
														<table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
															<!--begin::Table head-->
															<thead>
																<tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
																	

																	<th><?php echo lang('common_name')?></th>
																	<th><?php echo lang('common_location')?></th>
																	<th><?php echo lang('common_expire_date')?></th>
																	<th><?php echo lang('reports_quantity_expiring')?></th>
																	<th><?php echo lang('common_category')?></th>
																	<th><?php echo lang('common_item_number')?></th>
																	<th><?php echo lang('common_product_id')?></th>
																													</tr>
																												</thead>
																												<!--end::Table head-->
																												<!--begin::Table body-->
																												<tbody>
																												

																													<?php foreach($expiring_items as $eitem) { ?>
																		<tr>
																			<td class="text-start pe-0"> <span class="text-gray-600 fw-bold fs-6"> <?php echo $eitem['name'];?></span></td>
																			<td class="text-start pe-0"> <span class="text-gray-600 fw-bold fs-6"><?php echo $eitem['location_name'];?></span></td>
																			<td class="text-start pe-0"> <span class="text-gray-600 fw-bold fs-6"><?php echo date(get_date_format(),strtotime($eitem['expire_date']));?></span></td>
																			<td class="text-start pe-0"> <span class="text-gray-600 fw-bold fs-6"><?php echo to_quantity($eitem['quantity_expiring']);?></span></td>
																			<td class="text-start pe-0"> <span class="text-gray-600 fw-bold fs-6"><?php echo $eitem['category'];?></span></td>
																			<td class="text-start pe-0"> <span class="text-gray-600 fw-bold fs-6"><?php echo $eitem['item_number'];?></span></td>
																			<td class="text-start pe-0"> <span class="text-gray-600 fw-bold fs-6"><?php echo $eitem['product_id'];?></span></td>
																		</tr>
																		
																<?php } ?>
															</tbody>
															<!--end::Table body-->
														</table>
													</div>
													<!--end::Table-->
												</div>
												<!--end: Card Body-->
											</div>
											<!--end::Tables widget 14-->
										</div>
										<!--end::Col-->
									</div>
									<!--end::Row-->



									<?php } ?>



<?php if($choose_location && count($authenticated_locations) > 1){ ?>
	

<!-- Modal -->
<div class="modal fade" id="choose_location_modal" tabindex="-1" role="dialog" aria-labelledby="chooseLocation" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="chooseLocation"><?php echo lang('common_locations_choose_location'); ?></h4>
      </div>
      <div class="modal-body">
        <ul class="list-inline choose-location-home">
        	<?php foreach ($authenticated_locations as $key => $value) { ?>
				<li><a class="set_employee_current_location_after_login" data-location-id="<?php echo $key; ?>" href="<?php echo site_url('home/set_employee_current_location_id/'.$key) ?>"> <?php echo $value; ?> </a></li>
			<?php } ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php } ?>


<!-- Location Message to employee -->
<script>
	$(document).ready(function(){


		$("#dismiss_mercury").click(function(e){
			e.preventDefault();
			$.get($(this).attr('href'));
			$("#mercury_container").fadeOut();
			
		});
		
		$("#dismiss_reseller").click(function(e){
			e.preventDefault();
			$.get($(this).attr('href'));
			$("#reseller_container").fadeOut();
			
		});
		
		$("#dismiss_feedback").click(function(e){
			e.preventDefault();
			$.get($(this).attr('href'));
			$("#feedback_container").fadeOut();
			
		});
				
		
		
		$("#dismiss_setup_wizard").click(function(e){
			e.preventDefault();
			$.get($(this).attr('href'));
			$("#setup_wizard_container").fadeOut();
			
		});
		

		$("#dismiss_test_mode").click(function(e){
			e.preventDefault();
			$.get($(this).attr('href'));
			$("#test_mode_container").fadeOut();
		});
	
		<?php if($choose_location && count($authenticated_locations) > 1) { ?>
			
			$('#choose_location_modal').modal('show');

			$(".set_employee_current_location_after_login").on('click',function(e)
			{
				e.preventDefault();

				var location_id = $(this).data('location-id');
				$.ajax({
				    type: 'POST',
				    url: '<?php echo site_url('home/set_employee_current_location_id'); ?>',
				    data: { 
				        'employee_current_location_id': location_id, 
				    },
				    success: function(){

				    	window.location = <?php echo json_encode(site_url('home')); ?>;
				    }
				});
				
			});
			
		<?php } ?>


		<?php if(isset($month_sale) && !isset($month_sale['message'])){ ?>
			var data = {
				labels: <?php echo $month_sale['day'] ?>,
				datasets: [
				{
					fillColor : "#5d9bfb",
					strokeColor : "#5d9bfb",
					highlightFill : "#5d9bfb",
					highlightStroke : "#5d9bfb",
					data: <?php echo $month_sale['amount'] ?>
				}
				]
			};
			var ctx = document.getElementById("charts").getContext("2d");
			var myBarChart = new Chart(ctx).Bar(data, {
				responsive : true
			});
		<?php } ?>

	        

		$('.piluku-tabs a').on('click',function(e) {
			e.preventDefault();
			$('.piluku-tabs li').removeClass('active');
			$(this).parent('li').addClass('active');
			var type = $(this).attr('data-type');
			$.post('<?php echo site_url("home/sales_widget/'+type+'"); ?>', function(res)
			{
				var obj = jQuery.parseJSON(res);
				if(obj.message)
				{
					$(".chart").html(obj.message);
					return false;
				}
				
				renderChart(obj.day, obj.amount);
				
				myBarChart.update();
			});
		});

		function renderChart(label,data){

		    $(".chart").html("").html('<canvas id="charts" width="400" height="400"></canvas>');
		    var lineChartData = {
		        labels : label,
		        datasets : [
		            {
		                fillColor : "#5d9bfb",
						strokeColor : "#5d9bfb",
						highlightFill : "#5d9bfb",
						highlightStroke : "#5d9bfb",
		                data : data
		            }
		        ]

		    }
		    var canvas = document.getElementById("charts");
		    var ctx = canvas.getContext("2d");

		    myLine = new Chart(ctx).Bar(lineChartData, {
		        responsive: true,
		        maintainAspectRatio: false
		    });
		}
	});
</script>

<?php $this->load->view("partial/footer"); ?>