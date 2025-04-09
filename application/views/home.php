<?php $this->load->view("partial/header");
$this->load->helper('demo');
?>

<?php
if (isset($announcement)) {
?>
<div class="alert alert-danger" role="alert">
    <?php echo $announcement; ?>
</div>
<?php
}
?>

<?php
if (is_on_phppos_host()) {
?>
<?php if (isset($trial_on) && $trial_on === true) { ?>
<div class="col-md-12">
    <div class="panel">
        <div class="card-body">
            <div class="alert alert-success">
                <?php echo lang('login_trail_info') . ' ' . date(get_date_format(), strtotime($cloud_customer_info['trial_end_date'])) . '. ' . lang('login_trial_info_2'); ?>
            </div>
            <a class="btn btn-block btn-success"
                href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username']; ?>&username=<?php echo $this->Employee->get_logged_in_employee_info()->username; ?>&password=<?php echo $this->Employee->get_logged_in_employee_info()->password; ?>"
                target="_blank"><?php echo lang('update_billing_info'); ?></a>
        </div>
    </div>
</div>
<?php } ?>


<?php if (isset($subscription_payment_failed) && $subscription_payment_failed === true) { ?>
<div class="col-md-12">
    <div class="panel">
        <div class="card-body">
            <div class="alert alert-danger">
                <?php echo lang('login_payment_failed_text'); ?>
            </div>
            <a class="btn btn-block btn-success"
                href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username']; ?>&username=<?php echo $this->Employee->get_logged_in_employee_info()->username; ?>&password=<?php echo $this->Employee->get_logged_in_employee_info()->password; ?>"
                target="_blank"><?php echo lang('update_billing_info'); ?></a>
        </div>
    </div>
</div>
<?php } ?>

<?php if (isset($subscription_cancelled_within_5_days) && $subscription_cancelled_within_5_days === true) { ?>
<div class="col-md-12">
    <div class="panel">
        <div class="card-body">
            <div class="alert alert-danger">
                <?php echo lang('login_resign_text'); ?>
            </div>
            <a class="btn btn-block btn-sm btn-success"
                href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username']; ?>&username=<?php echo $this->Employee->get_logged_in_employee_info()->username; ?>&password=<?php echo $this->Employee->get_logged_in_employee_info()->password; ?>"
                target="_blank"><?php echo lang('login_resignup'); ?></a>
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
                    <span class="card-label fw-bold text-dark"><?php echo lang('home_setup_wizard'); ?></span>

                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">

                    <a id="dismiss_setup_wizard" href="<?php echo site_url('home/dismiss_setup_wizard') ?>"
                        class="btn btn-sm btn-light"><?php echo lang('dismiss'); ?></a>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">
                <!--begin::Scroll-->
                <div class="row pe-6 me-n6 ">
                    <!--begin::Item-->
                    <div
                        class="col-4  <?php echo $this->config->item('wizard_configure_company') ? 'wizard_step_done' : ''; ?>">
                        <div
                            class=" border border-dashed border-gray-300 rounded px-7 py-3 mb-6  text-light bg-light-danger">
                            <!--begin::Info-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Wrapper-->
                                <div class="me-3">
                                    <!--begin::Icon-->
                                    <img src="<?php echo base_url('assets/img/gear.png') ?>" />

                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <a href="<?php echo base_url('config'); ?>"
                                        class="text-gray-800 text-hover-primary fw-bold">
                                        <h4><?php echo lang('module_config'); ?></h4>
                                    </a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Wrapper-->

                            </div>
                            <!--end::Info-->
                            <!--begin::Customer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Name-->
                                <a href="<?php echo base_url('config'); ?>"
                                    class="text-gray-800 text-hover-primary fw-bold"><?php echo lang('home_wizard_configure_company'); ?></a>
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
                    <div
                        class="col-4 <?php echo $this->config->item('wizard_configure_locations') ? 'wizard_step_done' : ''; ?>">
                        <div class=" border border-dashed border-gray-300 rounded px-7 py-3 mb-6 bg-light-success">
                            <!--begin::Info-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Wrapper-->
                                <div class="me-3">
                                    <!--begin::Icon-->
                                    <img src="<?php echo base_url('assets/img/building.png') ?>" />

                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <a href="<?php echo base_url('locations'); ?>"
                                        class="text-gray-800 text-hover-primary fw-bold">
                                        <h4><?php echo lang('module_locations'); ?></h4>
                                    </a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Wrapper-->

                            </div>
                            <!--end::Info-->
                            <!--begin::Customer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Name-->
                                <a href="<?php echo base_url('locations'); ?>"
                                    class="text-gray-800 text-hover-primary fw-bold"><?php echo lang('home_wizard_configure_locations'); ?></a>
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
                    <div
                        class="col-4  <?php echo $this->config->item('wizard_add_inventory') ? 'wizard_step_done' : ''; ?>">
                        <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6 bg-light-info">
                            <!--begin::Info-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Wrapper-->
                                <div class="me-3">
                                    <!--begin::Icon-->
                                    <img src="<?php echo base_url('assets/img/product.png') ?>" />

                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <a href="<?php echo base_url('items/view/-1'); ?>"
                                        class="text-gray-800 text-hover-primary fw-bold">
                                        <h4><?php echo lang('module_items'); ?></h4>
                                    </a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Wrapper-->

                            </div>
                            <!--end::Info-->
                            <!--begin::Customer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Name-->
                                <a href="<?php echo base_url('items/view/-1'); ?>"
                                    class="text-gray-800 text-hover-primary fw-bold"><?php echo lang('home_wizard_add_inventory'); ?></a>
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
                    <div
                        class="col-4  <?php echo $this->config->item('wizard_edit_employees') ? 'wizard_step_done' : ''; ?>">

                        <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6 bg-light-success">
                            <!--begin::Info-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Wrapper-->
                                <div class="me-3">
                                    <!--begin::Icon-->
                                    <img src="<?php echo base_url('assets/img/user-group-man-man.png') ?>" />

                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <a href="<?php echo base_url('employees'); ?>"
                                        class="text-gray-800 text-hover-primary fw-bold">
                                        <h4><?php echo lang('module_employees'); ?></h4>
                                    </a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Wrapper-->

                            </div>
                            <!--end::Info-->
                            <!--begin::Customer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Name-->
                                <a href="<?php echo base_url('employees'); ?>"
                                    class="text-gray-800 text-hover-primary fw-bold"><?php echo lang('home_wizard_edit_employees'); ?></a>
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
                    <div
                        class="col-4  <?php echo $this->config->item('wizard_add_customer') ? 'wizard_step_done' : ''; ?>">

                        <div class=" border border-dashed border-gray-300 rounded px-7 py-3 mb-6 bg-light-primary">
                            <!--begin::Info-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Wrapper-->
                                <div class="me-3">
                                    <!--begin::Icon-->
                                    <img src="<?php echo base_url('assets/img/add-user-group-man-man.png') ?>" />

                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <a href="<?php echo base_url('customers/view/-1'); ?>"
                                        class="text-gray-800 text-hover-primary fw-bold">
                                        <h4><?php echo lang('module_customers'); ?></h4>
                                    </a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Wrapper-->

                            </div>
                            <!--end::Info-->
                            <!--begin::Customer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Name-->
                                <a href="<?php echo base_url('customers/view/-1'); ?>"
                                    class="text-gray-800 text-hover-primary fw-bold"><?php echo lang('home_wizard_add_customer'); ?></a>
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
                    <div
                        class="col-4   <?php echo $this->config->item('wizard_create_sale') ? 'wizard_step_done' : ''; ?>">
                        <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6 bg-light-danger">
                            <!--begin::Info-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Wrapper-->
                                <div class="me-3">
                                    <!--begin::Icon-->
                                    <img src="<?php echo base_url('assets/img/cash-register.png') ?>" />

                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <a href="<?php echo base_url('sales'); ?>"
                                        class="text-gray-800 text-hover-primary fw-bold">
                                        <h4><?php echo lang('module_sales'); ?></h4>
                                    </a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Wrapper-->

                            </div>
                            <!--end::Info-->
                            <!--begin::Customer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Name-->
                                <a href="<?php echo base_url('sales'); ?>"
                                    class="text-gray-800 text-hover-primary fw-bold"><?php echo lang('home_wizard_create_sale'); ?></a>
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





<?php if ($can_show_mercury_activate) { ?>

<!--begin::Alert-->
<div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
    <!--begin::Close-->
    <a href="<?php echo site_url('home/dismiss_feedback_message') ?>"
        class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-danger" data-bs-dismiss="alert">
        <span class="svg-icon svg-icon-1">x</span>
    </a>
    <!--end::Close-->



    <!--begin::Wrapper-->
    <div class="text-center">
        <!--begin::Title-->
        <h1 class="fw-bold mb-5"><?php echo lang('credit_card_processing'); ?></h1>
        <!--end::Title-->

        <!--begin::Separator-->
        <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
        <!--end::Separator-->

        <!--begin::Content-->
        <div class="mb-9 ">
            <a href="http://<?php echo $this->config->item('branding')['domain']; ?>/credit_card_processing.php"
                class="mercury_description" target="_blank">
                <?php echo lang('home_mercury_activate_promo_text'); ?>
            </a>
        </div>
        <!--end::Content-->


    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->


<!--end::Alert-->



<?php } ?>

<script src="<?= site_url() ?>assets/js/gsap.min.js"></script>


<!--begin::Alert-->
<div class="alert alert-dismissible bg-primary d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10 rotating-bg" style="background-image: url('<?= base_url(); ?>assets/css_good/media/svg/misc/eolic-energy.svg');background-repeat: no-repeat;">

    <!--end::Close-->



    <!--begin::Wrapper-->
    <div class="text-center">
        <!--begin::Title-->
        <h1 class="fw-bold mb-5 text-light"><?php echo lang('Sync_offline_db'); ?></h1>
        <!--end::Title-->


        <!--begin::Buttons-->
        <div class="d-flex ">
        <div class="step-container" data-step="2">
            <img src="<?= site_url('assets/css_good/normal.gif') ?>" class="w-25 normal">
            <img src="<?= site_url('assets/css_good/success.gif') ?>" class="w-25 d-none success">
            <label class="text-light">Category</label>
        </div>
        <div class="step-container" data-step="1">
            <img src="<?= site_url('assets/css_good/normal.gif') ?>" class="w-25 normal">
            <img src="<?= site_url('assets/css_good/success.gif') ?>" class="w-25 d-none success">
            <label class="text-light">Customer </label>
        </div>
       
        <div class="step-container" data-step="3">
            <img src="<?= site_url('assets/css_good/normal.gif') ?>" class="w-25 normal">
            <img src="<?= site_url('assets/css_good/success.gif') ?>" class="w-25 d-none success">
            <label class="text-light">Items </label>
        </div>
    
    
  

    <script>

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('assets/js/load_sales_offline_data_worker.js')
        .then(reg => {
            console.log('Service Worker registered successfully.');

            if (reg.waiting) {
                reg.waiting.postMessage({ action: 'skipWaiting' });
            }
        })
        .catch(err => console.error('Service Worker registration failed:', err));
}

function startServiceWorkerProcess() {
    if (navigator.serviceWorker.controller) {
        startWorker('force');
    } else {
        console.warn("Service Worker is not ready yet.");
    }
}



    </script>
        </div>
        <button class="btn btn-danger h-50px" onclick="startServiceWorkerProcess()"><?php echo lang('sync'); ?></button>
        <!--end::Buttons-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->




<?php
$this->load->helper('demo');
if (!is_on_demo_host() && !$this->config->item('hide_test_mode_home') && !$this->config->item('disable_test_mode')) { ?>
<?php if ($this->config->item('test_mode')) { ?>

<!--begin::Alert-->
<div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">

    <!--end::Close-->



    <!--begin::Wrapper-->
    <div class="text-center">
        <!--begin::Title-->
        <h1 class="fw-bold mb-5"><?php echo lang('disable_test_mode'); ?></h1>
        <!--end::Title-->

        <!--begin::Separator-->
        <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
        <!--end::Separator-->

        <!--begin::Content-->
        <div class="mb-9 text-dark">
            <?php echo lang('in_test_mode') ?>
        </div>
        <!--end::Content-->

        <!--begin::Buttons-->
        <div class="d-flex flex-center flex-wrap">

            <a href="<?php echo site_url('home/disable_test_mode') ?>"
                class="btn btn-danger m-2"><?php echo lang('disable_test_mode'); ?></a>
        </div>
        <!--end::Buttons-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->

<?php } ?>

<?php if (!$this->config->item('test_mode')  && !$this->config->item('disable_test_mode')) { ?>


<!--begin::Alert-->
<div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
    <!--begin::Close-->
    <a href="<?php echo site_url('home/dismiss_test_mode') ?>"
        class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-danger" data-bs-dismiss="alert">
        <span class="svg-icon svg-icon-1">x</span>
    </a>
    <!--end::Close-->



    <!--begin::Wrapper-->
    <div class="text-center">
        <!--begin::Title-->
        <h1 class="fw-bold mb-5"><?php echo lang('enable_test_mode'); ?></h1>
        <!--end::Title-->

        <!--begin::Separator-->
        <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
        <!--end::Separator-->

        <!--begin::Content-->
        <div class="mb-9 text-dark">
            <?php echo lang('test_mode_desc') ?>
        </div>
        <!--end::Content-->

        <!--begin::Buttons-->
        <div class="d-flex flex-center flex-wrap">

            <a href="<?php echo site_url('home/enable_test_mode') ?>"
                class="btn btn-danger m-2"><?php echo lang('enable_test_mode'); ?></a>
        </div>
        <!--end::Buttons-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->



<?php } ?>
<?php } ?>


<div class="">

    <?php if ($this->Employee->has_module_action_permission('reports', 'view_dashboard_stats', $this->Employee->get_logged_in_employee_info()->person_id) && (!$this->agent->is_mobile() || $this->agent->is_tablet())) { ?>

    <?php
		if ($this->config->item('ecommerce_cron_running')) {
		?>
    <!-- ecommerce progress bar -->
    <div class="row" id="ecommerce_progress_container">
        <div class="col-md-12">
            <div class="panel">
                <div class="card-header rounded rounded-3 p-5">
                    <h5><?php echo lang('home_ecommerce_platform_sync') ?></h5>
                </div>
                <div class="card-body">
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
    function check_ecommerce_status() {
        $.getJSON(SITE_URL + '/home/get_ecommerce_sync_progress', function(response) {
            set_progress(response.percent_complete, response.message);

            if (response.running) {
                setTimeout(check_ecommerce_status, 5000);
            }
        });
    }

    function set_progress(percent, message) {
        $("#progress_container").show();
        $('#progessbar').attr('aria-valuenow', percent).css('width', percent + '%');
        $('#progress_percent').html(percent);
        if (message != '') {
            $("#progress_message").html('(' + message + ')');
        } else {
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
                <div class="card-header rounded rounded-3 p-5">
                    <h5><?php echo lang('home_quickbooks_platform_sync') ?></h5>
                </div>
                <div class="card-body">
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
    function check_quickbooks_status() {
        $.getJSON(SITE_URL + '/home/get_qb_sync_progress', function(response) {
            set_qb_progress(response.percent_complete, response.message);

            if (response.running) {
                setTimeout(check_quickbooks_status, 5000);
            }
        });
    }

    function set_qb_progress(percent, message) {
        $("#qb_progress_container").show();
        $('#qb_progessbar').attr('aria-valuenow', percent).css('width', percent + '%');
        $('#qb_progress_percent').html(percent);
        if (message != '') {
            $("#qb_progress_message").html('(' + message + ')');
        } else {
            $("#qb_progress_message").html('');
        }

    }
    check_quickbooks_status();
    </script>

    <?php } ?>

    <?php

		if (!$ecommerce_realtime) {
			if ($this->config->item("ecommerce_platform") == 'woocommerce') {
		?>
    <div class="alert alert-danger" style="text-align: left;">
        <strong><?php echo lang('config_woocommerce_oauth_set_alert'); ?></strong>
        <input type="hidden" id="woo_api_url" value="<?php echo $this->config->item('woo_api_url'); ?>"></input>
        <br />
        <button id="woo_oauth" type="button" class="btn btn-lg btn-primary"
            style="display: block; margin-top: 4px;"><?php echo lang('config_connect_to_woocommerce'); ?></button>
    </div>

    <?php
			} elseif ($this->config->item("ecommerce_platform") == 'shopify') {
			?>
    <div class="alert alert-danger" style="text-align: left;">
        <strong><?php echo lang('config_shopifycommerce_oauth_set_alert'); ?></strong>
        <br />
        <a href="<?php echo site_url('ecommerce/oauth_shopify'); ?>" class="btn btn-success"
            id="shopify_oauth_connectt"><?php echo lang('config_reconnect_to_shopify'); ?></a>
    </div>

    <?php
			}
			?>

    <?php
		}
		?>

    <!--begin::Row-->
    <div class="row g-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-xl-4 mb-xl-10">
            <!--begin::Lists Widget 19-->
            <div class="card card-flush h-xl-100">
                <!--begin::Heading-->
                <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px"
                    style="background-image:url('<?php echo base_url(); ?>assets/css_good/media/svg/shapes/top-green.png"
                    data-theme="light">
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
                                        <span
                                            class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $total_sales; ?></span>
                                        <!--end::Number-->
                                        <!--begin::Desc-->
                                        <span
                                            class="text-gray-600 fw-semibold fs-6"><?php echo lang('total') . " " . lang('module_sales'); ?></span>
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
                                        <span
                                            class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $total_customers; ?></span>
                                        <!--end::Number-->
                                        <!--begin::Desc-->
                                        <span
                                            class="text-gray-600 fw-semibold fs-6"><?php echo lang('total') . " " . lang('module_customers'); ?></span>
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
                                        <span
                                            class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $total_items; ?></span>
                                        <!--end::Number-->
                                        <!--begin::Desc-->
                                        <span
                                            class="text-gray-600 fw-semibold fs-6"><?php echo lang('total') . " " . lang('module_items'); ?></span>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Col-->

                            <?php
								if ($this->Employee->has_module_permission('item_kits', $this->Employee->get_logged_in_employee_info()->person_id)) {
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
                                        <span
                                            class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?php echo $total_item_kits; ?></span>
                                        <!--end::Number-->
                                        <!--begin::Desc-->
                                        <span
                                            class="text-gray-600 fw-semibold fs-6"><?php echo lang('total') . " " . lang('module_item_kits'); ?></span>
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

            <!--begin::Engage widget 4-->
            <div class="card border-transparent">
                <!--begin::Body-->

				<div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">	<?php echo lang('over_all_summary_in') . " " . $this->config->item('currency_symbol'); ?></span>
                </h3>
                <!--begin::Toolbar-->
                <!-- <div class="card-toolbar">
														<a href="#" class="btn btn-sm btn-light">All Courses</a>
													</div> -->
                <!--end::Toolbar-->
            </div>


                <div class="card-body d-flex ps-xl-15">
                    <!--begin::Wrapper-->

				
                    <div class="m-0 w-100">
                        <div id="main_chart" height="600"></div>
                    </div>
                    <!--begin::Wrapper-->
                    <!--begin::Illustration-->
                    <!-- <img src="assets/media/illustrations/sigma-1/17-dark.png" class="position-absolute me-3 bottom-0 end-0 h-200px" alt="" /> -->
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
                    <span class="card-label fw-bold text-dark"><?= lang('List_of_Common_Tasks'); ?></span>
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
                            <a href="<?php echo site_url('sales'); ?>"
                                class="text-gray-800 text-hover-primary fs-6 fw-bold"><?php echo lang('start_new_sale'); ?></a>

                        </div>
                        <!--end:Author-->
                        <!--begin::Actions-->
                        <a href="<?php echo site_url('sales'); ?>"
                            class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                        transform="rotate(-180 18 13)" fill="currentColor" />
                                    <path
                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                        fill="currentColor" />
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
                            <a href="<?php echo site_url('receivings'); ?>"
                                class="text-gray-800 text-hover-primary fs-6 fw-bold"><?php echo lang('home_receivings_start_new_receiving'); ?></a>
                        </div>
                        <!--end:Author-->
                        <!--begin::Actions-->
                        <a href="<?php echo site_url('receivings'); ?>"
                            class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                        transform="rotate(-180 18 13)" fill="currentColor" />
                                    <path
                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                        fill="currentColor" />
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
                            <a href="<?php echo site_url('reports/generate/closeout?report_type=simple&report_date_range_simple=TODAY'); ?>&export_excel=0"
                                class="text-gray-800 text-hover-primary fs-6 fw-bold"><?php echo lang('home_todays_closeout_report'); ?></a>
                        </div>
                        <!--end:Author-->
                        <!--begin::Actions-->
                        <a href="<?php echo site_url('reports/generate/closeout?report_type=simple&report_date_range_simple=TODAY'); ?>&export_excel=0"
                            class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                        transform="rotate(-180 18 13)" fill="currentColor" />
                                    <path
                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                        fill="currentColor" />
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
                            <a href="<?php echo site_url('reports/generate/detailed_sales?report_type=simple&report_date_range_simple=TODAY&sale_type=all&with_time=1&excel_export=0'); ?>&export_excel=0"
                                class="text-gray-800 text-hover-primary fs-6 fw-bold"><?php echo lang('home_todays_detailed_sales_report'); ?></a>

                        </div>
                        <!--end:Author-->
                        <!--begin::Actions-->
                        <a href="<?php echo site_url('reports/generate/detailed_sales?report_type=simple&report_date_range_simple=TODAY&sale_type=all&with_time=1&excel_export=0'); ?>&export_excel=0"
                            class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                        transform="rotate(-180 18 13)" fill="currentColor" />
                                    <path
                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                        fill="currentColor" />
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
                            <a href="<?php echo site_url('reports/generate/summary_items?category_id=&supplier_id=&sale_type=all&items_to_show=items_with_sales&report_type=simple&report_date_range_simple=TODAY&export_excel=0&with_time=1'); ?>"
                                class="text-gray-800 text-hover-primary fs-6 fw-bold"><?php echo lang('home_todays_summary_items_report'); ?></a>

                        </div>
                        <!--end:Author-->
                        <!--begin::Actions-->
                        <a href="<?php echo site_url('reports/generate/summary_items?category_id=&supplier_id=&sale_type=all&items_to_show=items_with_sales&report_type=simple&report_date_range_simple=TODAY&export_excel=0&with_time=1'); ?>"
                            class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                        transform="rotate(-180 18 13)" fill="currentColor" />
                                    <path
                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                        fill="currentColor" />
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
                            <a href="<?php echo site_url('sales'); ?>/select_regeister"
                                class="text-gray-800 text-hover-primary fs-6 fw-bold"><?= lang('Change_Register');?></a>

                        </div>
                        <!--end:Author-->
                        <!--begin::Actions-->
                        <a href="<?php echo site_url('sales'); ?>/select_regeister"
                            class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                        transform="rotate(-180 18 13)" fill="currentColor" />
                                    <path
                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </a>
                        <!--begin::Actions-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->

                <?php foreach ($saved_reports as $key => $report) {

					$report_url = $report['url'];
				
					$report_url .= (parse_url($report['url'], PHP_URL_QUERY) ? '&' : '?') . "key=$key";
					
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
                            <a href="<?php echo $report_url; ?>"
                                class="text-gray-800 text-hover-primary fs-6 fw-bold"><?php echo $report['name']; ?></a>
                        </div>
                        <!--end:Author-->
                        <!--begin::Actions-->
                        <a href="<?php echo $report_url; ?>"
                            class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                        transform="rotate(-180 18 13)" fill="currentColor" />
                                    <path
                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                        fill="currentColor" />
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
                            <div class="card-body">

                                <?php if (can_display_graphical_report()) { ?>
                                <div class="card-header rounded rounded-3 p-5">
                                    <h4 class="card-label fw-bold text-dark"><?php echo lang('Sales_charts') ?></h4>
                                </div>
                                <!-- Nav tabs -->




                                <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                                    <li class="nav-item">
                                        <a class="nav-link firsttab" data-toggle="tab"
                                            href="#monthly"><?php echo lang('monthly') ?></a></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " data-toggle="tab"
                                            href="#weekly"><?php echo lang('weekly') ?></a></a>
                                    </li>


                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane firsttab_ fade  show active" id="monthly" role="tabpanel">
                                        <div class="chart">
                                            <?php if (isset($month_sale) && !isset($month_sale['message'])) { ?>
                                            <div id="charts" width="400" height="100"></div>
                                            <?php } else {
														echo $month_sale['message'];
													} ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show active" id="weekly" role="tabpanel">
                                        <div class="charts">
                                            <?php if (isset($weekly_sale) && !isset($weekly_sale['message'])) { ?>
                                            <div id="charts_weekly" width="400" height="100"></div>
                                            <?php } else {
														echo $weekly_sale['message'];
													} ?>
                                        </div>
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
<div class="row gy-5 g-xl-10">
    <div class="col-xl-4">
        <div class="card card-flush h-xl-100">
            <!--begin::Card header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark"><?= lang('stats_items_purchased_this_week') ?></span>

                </h3>
                <!--end::Title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Row-->
                <div class="row g-3 g-lg-6">
                    <!--begin::Col-->
                    <div class="col-6">
                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5 mb-8">
                                <span class="symbol-label">
                                    <span class="svg-icon svg-icon-2 svg-icon-primary ">
                                        <i class="fas fa-shopping-cart text-primary fs-2"></i>
                                    </span>
                                </span>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Stats-->
                            <div class="m-0">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <span
                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 subtotal">0</span>
                                    <span class="fs-7 fw-semibold text-gray-500 me-1 align-self-start px-2">
                                        <?php echo $this->config->item('currency_symbol'); ?></span>
                                    <!--end::Number-->
                                </div>
                                <!--begin::Desc-->
                                <span class="text-gray-600 fw-semibold fs-6"><?= lang('subtotal') ?></span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Stats-->
                        </div>
                    </div>


                    <!--begin::Col-->
                    <div class="col-6">
                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5 mb-8">
                                <span class="symbol-label">
                                    <span class="svg-icon svg-icon-2 svg-icon-primary ">
                                        <i class="fas fa-money-bill  text-primary fs-2"></i>
                                    </span>
                                </span>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Stats-->
                            <div class="m-0">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 total">0</span>
                                    <span class="fs-7 fw-semibold text-gray-500 me-1 align-self-start px-2">
                                        <?php echo $this->config->item('currency_symbol'); ?></span>
                                    <!--end::Number-->
                                </div>
                                <!--begin::Desc-->
                                <span class="text-gray-600 fw-semibold fs-6"><?= lang('total') ?></span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Stats-->
                        </div>
                    </div>

                    <!--begin::Col-->
                    <div class="col-6">
                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5 mb-8">
                                <span class="symbol-label">
                                    <span class="svg-icon svg-icon-2 svg-icon-primary ">
                                        <i class="fas fa-hdd  text-primary fs-2"></i>
                                    </span>
                                </span>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Stats-->
                            <div class="m-0">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <span
                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 total_items_sold">0</span>

                                    <!--end::Number-->
                                </div>
                                <!--begin::Desc-->
                                <span class="text-gray-600 fw-semibold fs-6"><?= lang('total_items_sold') ?></span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Stats-->
                        </div>
                    </div>






                    <!--begin::Col-->
                    <div class="col-6">
                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5 mb-8">
                                <span class="symbol-label">
                                    <span class="svg-icon svg-icon-2 svg-icon-primary ">
                                        <i class="fas fa-th-list  text-primary fs-2"></i>
                                    </span>
                                </span>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Stats-->
                            <div class="m-0">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 profit">0</span>
                                    <span class="fs-7 fw-semibold text-gray-500 me-1 align-self-start px-2">
                                        <?php echo $this->config->item('currency_symbol'); ?></span>
                                    <!--end::Number-->
                                </div>
                                <!--begin::Desc-->
                                <span class="text-gray-600 fw-semibold fs-6"><?= lang('profit') ?></span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Stats-->
                        </div>
                    </div>





                </div>
                <!--end::Row-->
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <!--begin::Table Widget 5-->
        <div class="card card-flush h-xl-100">
            <!--begin::Card header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark"><?= lang('top_items_purchased_this_week') ?></span>

                </h3>
                <!--end::Title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-3" id="dTable_enhanced_summary_items">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th data-orderable="false" class="min-w-100px"><?= lang('item') ?></th>
                            <th data-orderable="false" class="text-end pe-3 min-w-100px"><?= lang('category') ?></th>
                            <th data-orderable="false" class="text-end pe-3 min-w-150px"><?= lang('avg_cost_price') ?>
                            </th>
                            <th data-orderable="false" class="text-end pe-3 min-w-100px"><?= lang('avg_unit_price') ?>
                            </th>
                            <th class="text-end pe-0 min-w-25px double_click"><?= lang('qty_purchased') ?></th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600" id="enhanced_summary_items">

                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Table Widget 5-->
    </div>
</div>



<script>
$(document).ready(function() {
    //const $currency_symbol = '<span class="fs-4 fw-semibold text-gray-500 me-1 align-self-start"><?php echo $this->config->item('currency_symbol'); ?></span>';

    function load_table(urls = 'graphical_summary_work_order', title, id, location, report_date_range_simple,
        company = 'All', compare = 'no', extra_url = '') {
        var url = '';
        if (compare == 'no') {
            url = "<?php echo base_url() ?>/reports/generate_ajax/" + urls +
                "?tier_id=&report_type=simple&report_date_range_simple=" + report_date_range_simple +
                "&start_date=&end_date=&with_time=1&end_date_end_of_day=0&item_id=&category_id=0&payment_type=&sale_type=all&group_by=&location_ids%5B%5D=" +
                location + "&company=" + company +
                "&business_type=All&items%5B%5D=pos&items%5B%5D=items&items%5B%5D=receivings&items%5B%5D=customers&compare=no&interval=3600&export_excel=0" +
                extra_url;
        } else {
            url = "<?php echo base_url() ?>/reports/generate_ajax/" + urls +
                "?tier_id=&report_type=simple&report_date_range_simple=" + report_date_range_simple +
                "&start_date=&end_date=&with_time=1&end_date_end_of_day=0&item_id=&category_id=0&payment_type=&sale_type=all&group_by=&location_ids%5B%5D=1&company=" +
                company +
                "&business_type=All&items%5B%5D=pos&items%5B%5D=items&items%5B%5D=receivings&items%5B%5D=customers&compare=yes&interval=3600&export_excel=0" +
                extra_url;
        }
        $.ajax({
            type: "GET",

            url: url,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.series[0].data) {
                    html = '';
                    $.each(data.series[0].data, function(key, val) {
                        console.log(val);
                        html +=
                            '<tr><td><a target="_blank" href="<?= site_url('items/view') ?>/' +
                            val[0].data + '" class="text-dark text-hover-primary">' + val[3]
                            .data + '</a></td><td class="text-end">' + val[5].data +
                            '</td><td class="text-end">' + val[8].data +
                            '</td><td class="text-end"</td>' + val[9].data +
                            '<td class="text-end" data-order="58"><span class="text-dark fw-bold">' +
                            val[7].data + '</span></td></tr>';
                    })
                    $('#' + urls).html(html);
                }
                var datatable = $('#dTable_' + urls).dataTable({
                    aaSorting: [
                        [4, 'desc']
                    ],
                    bPaginate: false,
                    bFilter: false,
                    bInfo: false,
                    bSortable: true,
                    bRetrieve: true
                });
                if (data.summary[0]) {
                    $('.total').html(data.summary[0].total);
                    $('.subtotal').html(data.summary[0].subtotal);
                    $('.profit').html(data.summary[0].profit);
                    $('.total_items_sold').html(data.summary[0].total_number_of_items_sold);
                }




            }
        })

    }
    load_table('enhanced_summary_items', '<?php echo lang('top_items_purchased'); ?>', 1,
        <?php echo $current_logged_in_location_id; ?>, 'LAST_7', 'All', 'no',
        '&items_to_show=items_with_sales&include_item_kits=1');


});
</script>


<?php if (!$this->config->item('hide_expire_dashboard') && count($expiring_items) > 0) { ?>
<!--begin::Col-->
<div class="col-xl-12 mt-3">
    <!--begin::Tables widget 14-->
    <div class="card card-flush h-md-100">
        <!--begin::Header-->
        <div class="card-header pt-7">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800"><?php echo lang('home_items_expiring_soon') ?></span>

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


                            <th><?php echo lang('name') ?></th>
                            <th><?php echo lang('location') ?></th>
                            <th><?php echo lang('expire_date') ?></th>
                            <th><?php echo lang('reports_quantity_expiring') ?></th>
                            <th><?php echo lang('category') ?></th>
                            <th><?php echo lang('item_number') ?></th>
                            <th><?php echo lang('product_id') ?></th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>


                        <?php foreach ($expiring_items as $eitem) { ?>
                        <tr>
                            <td class="text-start pe-0"> <span class="text-gray-600 fw-bold fs-6">
                                    <?php echo $eitem['name']; ?></span></td>
                            <td class="text-start pe-0"> <span
                                    class="text-gray-600 fw-bold fs-6"><?php echo $eitem['location_name']; ?></span>
                            </td>
                            <td class="text-start pe-0"> <span
                                    class="text-gray-600 fw-bold fs-6"><?php echo date(get_date_format(), strtotime($eitem['expire_date'])); ?></span>
                            </td>
                            <td class="text-start pe-0"> <span
                                    class="text-gray-600 fw-bold fs-6"><?php echo to_quantity($eitem['quantity_expiring']); ?></span>
                            </td>
                            <td class="text-start pe-0"> <span
                                    class="text-gray-600 fw-bold fs-6"><?php echo $eitem['category']; ?></span></td>
                            <td class="text-start pe-0"> <span
                                    class="text-gray-600 fw-bold fs-6"><?php echo $eitem['item_number']; ?></span></td>
                            <td class="text-start pe-0"> <span
                                    class="text-gray-600 fw-bold fs-6"><?php echo $eitem['product_id']; ?></span></td>
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

<div class="row gy-5 g-xl-10 my-1">
    <div class="col-xl-4">

        <div class="row" id="donts">
            <?php
			foreach ($stats as $key => $value) { ?>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-5 mb-xl-0 mt-4">
                <div class="card card-flush overflow-hidden h-md-100">
                    <div class="card-header py-5">
                        <h3 class="card-title align-items-start flex-column"><span class="card-label fw-bold text-dark"
                                id="title_<?= $key; ?>"><?= lang('Sales_of_top_employees'); ?></span></h3>
                        <div class="card-toolbar">
                            <div id="reportrange"
                                style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>

                        </div>
                    </div>
                    <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                        <div id="chart_wrapper_<?= $key; ?>" class="overlay overlay-block">
                            <div id="chart_<?= $key; ?>" style="height: 300px;"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
			?>
        </div>
    </div>
    <div class="col-xl-8 ">
        <div class="card card-flush overflow-hidden h-auto">
            <div class="card-header py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark"><?= lang('sale_types'); ?>
                    </span>
                </h3>
                <div class="apexcharts-toolbar" style="top: 10px; right: 10px;">
                    <a class="apexcharts-menu-icon" title="Menu" href="<?= site_url('sales/sales_list') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="none" d="M0 0h24v24H0V0z"></path>
                            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
                        </svg>
                    </a>

                </div>
            </div>
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">

                <div class="row mx-2">

                    <?php if($sale_status): ?>
                    <?php foreach($sale_status as $stat): ?>
                    <div class="col-xl-4">
                        <div
                            class="d-flex align-items-center flex-column mt-3 w-100 border border-dashed border-gray-300 rounded px-7 py-3 mb-6">
                            <div class="d-flex justify-content-between fw-bold fs-6  opacity-50 w-100 mt-auto mb-2">
                                <span><?= $stat->sale_type_name ?></span>
                                <span><?= $stat->percentage ?>%</span>
                            </div>

                            <div class="h-8px mx-3 w-100 bg-light-<?= $stat->color ?> rounded">
                                <div class="bg-<?= $stat->color ?> rounded h-8px" role="progressbar"
                                    style="width: <?= $stat->percentage ?>%;" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                    <?php endif; ?>

                </div>

            </div>
        </div>

    </div>




    <?php if ($choose_location && count($authenticated_locations) > 1) { ?>


    <!-- Modal -->
    <div class="modal fade" id="choose_location_modal" tabindex="-1" role="dialog" aria-labelledby="chooseLocation"
        data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="chooseLocation"><?php echo lang('locations_choose_location'); ?></h4>
                </div>
                <div class="modal-body">
                    <ul class="list-inline choose-location-home">
                        <?php foreach ($authenticated_locations as $key => $value) { ?>
                        <li><a class="set_employee_current_location_after_login" data-location-id="<?php echo $key; ?>"
                                href="<?php echo site_url('home/set_employee_current_location_id/' . $key) ?>">
                                <?php echo $value; ?> </a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>


    <!-- Location Message to employee -->
    <script>
    <?php
		foreach ($stats as $key => $value) {

			$totals = [];
			$fullNames = [];
			if (is_array($value)) {
				foreach ($value as $entry) {
					$totals[] = (int)$entry["total"];
					$fullNames[] = $entry["full_name"];
				}
			}



		?>

    var element = document.getElementById('chart_<?= $key ?>');

    var height = 300;
    var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
    var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
    var baseColor = KTUtil.getCssVariableValue('--kt-info');
    var lightColor = KTUtil.getCssVariableValue('--kt-info-light');
    colorPalette = [
        '#008FFB', '#00E396', '#FEB019', "#FF0000", "#00FF00", "#0000FF", "#FFFF00", "#FF00FF", "#00FFFF",
        "#FF4500", "#FF8C00", "#FFD700", "#ADFF2F", "#32CD32", "#00FF7F", "#00FA9A", "#008B8B", "#000080",
        "#4B0082", "#9400D3", "#8A2BE2", "#800080", "#7B68EE", "#483D8B", "#000000", "#FFFFFF", "#FFA07A",
        "#FA8072", "#E9967A", "#F08080", "#CD5C5C", "#DC143C", "#B22222", "#FF6347", "#FF4500", "#FFD700",
        "#FF8C00", "#FFA500", "#DAA520", "#B8860B", "#A52A2A", "#800000", "#808080", "#696969", "#708090",
        "#2F4F4F", "#008080", "#006400", "#556B2F", "#228B22", "#008000", "#32CD32", "#00FF00"
    ];

    var seriesedont;

    seriesedont = Object.values(<?= json_encode($totals); ?>);



    var options = {
        chart: {
            type: 'donut',
            width: '100%',
            height: 200
        },
        dataLabels: {
            enabled: false,
        },
        plotOptions: {
            pie: {
                customScale: 0.8,
                donut: {
                    size: '75%',
                },
                offsetY: 20,
            },
            stroke: {
                colors: undefined
            }
        },
        colors: colorPalette,
        title: {
            text: '',
            style: {
                fontSize: '18px'
            }
        },
        series: seriesedont,
        labels: Object.values(<?= json_encode($fullNames); ?>),
        legend: {
            position: 'left',
            offsetY: 80
        }
    };


    var chart<?= $key ?> = new ApexCharts(element, options);
    chart<?= $key ?>.render();

    <?php       }







		?>

var start = moment().subtract(30, 'days').startOf('day'); // 30 days ago from today
var end = moment().endOf('day'); // Today, end of the day

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $.ajax({
            url: '<?= site_url('home/ajax_get_stats_for_graph') ?>', // The endpoint where you process the dates
            type: 'POST',
            data: {
                from_date: start.format('YYYY-MM-DD'),
                to_date: end.format('YYYY-MM-DD'),
                time: 'CUSTOM'

            },
            success: function(response) {
                // Handle success
                let totals = [];
                let fullNames = [];
                stats = JSON.parse(response);
                if (stats) {



                    stats.forEach(entry => {
                        totals.push(parseInt(entry["total"], 10)); // Convert "total" to an integer
                        fullNames.push(entry["full_name"]); // Collect "full_name"
                    });



                } else {
                    // If stats is empty, you might want to clear the chart or display a message
                    // For example, you can reset totals and fullNames to contain a single dummy entry to indicate no data
                    totals = [0]; // A single entry with a value of 0
                    fullNames = ['No Data']; // A single entry indicating no data
                }
                // console.log(totals);
                var element = document.getElementById('chart_THIS_MONTH_sales_top_employees');

                var height = 300;
                var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
                var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
                var baseColor = KTUtil.getCssVariableValue('--kt-info');
                var lightColor = KTUtil.getCssVariableValue('--kt-info-light');
                colorPalette = [
                    '#008FFB', '#00E396', '#FEB019', "#FF0000", "#00FF00", "#0000FF", "#FFFF00",
                    "#FF00FF", "#00FFFF", "#FF4500", "#FF8C00", "#FFD700", "#ADFF2F", "#32CD32",
                    "#00FF7F", "#00FA9A", "#008B8B", "#000080", "#4B0082", "#9400D3", "#8A2BE2",
                    "#800080", "#7B68EE", "#483D8B", "#000000", "#FFFFFF", "#FFA07A", "#FA8072",
                    "#E9967A", "#F08080", "#CD5C5C", "#DC143C", "#B22222", "#FF6347", "#FF4500",
                    "#FFD700", "#FF8C00", "#FFA500", "#DAA520", "#B8860B", "#A52A2A", "#800000",
                    "#808080", "#696969", "#708090", "#2F4F4F", "#008080", "#006400", "#556B2F",
                    "#228B22", "#008000", "#32CD32", "#00FF00"
                ];

                var seriesedont;

                seriesedont = Object.values(totals);



                var options = {
                    chart: {
                        type: 'donut',
                        width: '100%',
                        height: 200
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    plotOptions: {
                        pie: {
                            customScale: 0.8,
                            donut: {
                                size: '75%',
                            },
                            offsetY: 20,
                        },
                        stroke: {
                            colors: undefined
                        }
                    },
                    colors: colorPalette,
                    title: {
                        text: '',
                        style: {
                            fontSize: '18px'
                        }
                    },
                    series: seriesedont,
                    labels: Object.values(fullNames),
                    legend: {
                        position: 'left',
                        offsetY: 80
                    }
                };

                if (chartTHIS_MONTH_sales_top_employees) {
                    chartTHIS_MONTH_sales_top_employees.updateSeries(seriesedont);
                    chartTHIS_MONTH_sales_top_employees.updateOptions({
                        labels: Object.values(fullNames),
                        colors: colorPalette, // Make sure colorPalette is defined in this scope
                    });
                }



            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Week': [moment().startOf('week'), moment().endOf('week')],
            'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf(
                'week')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                'month')],
            'This Quarter': [moment().startOf('quarter'), moment().endOf('quarter')],
            'Last Quarter': [moment().subtract(1, 'quarter').startOf('quarter'), moment().subtract(1, 'quarter')
                .endOf('quarter')
            ],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf(
                'year')],
            'Past 6 Months': [moment().subtract(6, 'months'), moment()]
        }
    }, cb);

    cb(start, end);

    $(document).ready(function() {


        $("#dismiss_mercury").click(function(e) {
            e.preventDefault();
            $.get($(this).attr('href'));
            $("#mercury_container").fadeOut();

        });

        $("#dismiss_reseller").click(function(e) {
            e.preventDefault();
            $.get($(this).attr('href'));
            $("#reseller_container").fadeOut();

        });

        $("#dismiss_feedback").click(function(e) {
            e.preventDefault();
            $.get($(this).attr('href'));
            $("#feedback_container").fadeOut();

        });



        $("#dismiss_setup_wizard").click(function(e) {
            e.preventDefault();
            $.get($(this).attr('href'));
            $("#setup_wizard_container").fadeOut();

        });


        $("#dismiss_test_mode").click(function(e) {
            e.preventDefault();
            $.get($(this).attr('href'));
            $("#test_mode_container").fadeOut();
        });

        <?php if ($choose_location && count($authenticated_locations) > 1) { ?>

        $('#choose_location_modal').modal('show');

        $(".set_employee_current_location_after_login").on('click', function(e) {
            e.preventDefault();

            var location_id = $(this).data('location-id');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('home/set_employee_current_location_id'); ?>',
                data: {
                    'employee_current_location_id': location_id,
                },
                success: function() {

                    window.location = <?php echo json_encode(site_url('home')); ?>;
                }
            });

        });

        <?php } ?>


        <?php if (isset($month_sale) && !isset($month_sale['message'])) { ?>
        var urls = <?php echo $month_sale['date'] ?>;


        var options = {
            series: [{
                data: <?php echo $month_sale['amount'] ?>
            }],
            chart: {
                type: 'bar',
                height: 350,
                events: {
                    click: function(event, chartContext, config) {

                        var dataPointIndex = config.dataPointIndex;
                        var seriesIndex = config.seriesIndex;
                        var url = urls[dataPointIndex];
                        if (url) {
                            window.open(url, '_blank'); // Open the URL in a new tab
                        }
                    }

                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: <?php echo $month_sale['day'] ?>,
            }
        };

        var chart = new ApexCharts(document.querySelector("#charts"), options);
        chart.render();

        <?php } ?>

        <?php if (isset($weekly_sale) && !isset($weekly_sale['message'])) { ?>
        var urls = <?php echo $weekly_sale['date'] ?>;


        var options = {
            series: [{
                data: <?php echo $weekly_sale['amount'] ?>
            }],
            chart: {
                type: 'bar',
                height: 350,
                events: {
                    click: function(event, chartContext, config) {

                        var dataPointIndex = config.dataPointIndex;
                        var seriesIndex = config.seriesIndex;
                        var url = urls[dataPointIndex];
                        if (url) {
                            window.open(url, '_blank'); // Open the URL in a new tab
                        }
                    }

                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: <?php echo $weekly_sale['day'] ?>,
            }
        };

        var chart = new ApexCharts(document.querySelector("#charts_weekly"), options);
        chart.render();
        <?php } ?>
        $.ajax({
            type: "GET",

            url: "<?php echo base_url() ?>reports/generate_ajax/summary_profit_and_loss?report_type=simple&report_date_range_simple=LAST_MONTH&start_date_formatted=01%2F17%2F2024+12%3A00+am&start_date=2024-01-17+00%3A00&end_date_formatted=01%2F17%2F2024+11%3A59+pm&end_date=2024-01-17+23%3A59&with_time=1&end_date_end_of_day=0&location_ids%5B%5D=<?= $current_logged_in_location_id; ?>&company=All&business_type=All&items%5B%5D=pos&items%5B%5D=items&items%5B%5D=receivings&items%5B%5D=customerss&compare=no",
            success: function(response) {
                var data = JSON.parse(response);
                var options = {
                    series: data.series,
                    chart: {
                        type: 'bar',
                        height: 350,
                        stacked: true,
                        stackType: '100%'
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                        },
                    },
                    stroke: {
                        width: 1,
                        colors: ['#fff']
                    },
                    title: {
                        text: ''
                    },
                    xaxis: {
                        categories: data.categories,
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val
                            }
                        }
                    },
                    fill: {
                        opacity: 1

                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'left',
                        offsetX: 40
                    }
                };


                var chart = new ApexCharts(document.querySelector("#main_chart"), options);
                chart.render();
            }
        })





        $('.tab-pane').removeClass('show active');
        $('.firsttab').addClass('active');
        $('.firsttab_').addClass('show active');


        // $('#myTabContent div').on('click',function(e) {

        // 	e.preventDefault();
        // 	$('#myTabContent div').removeClass('active');
        // 	$(this).parent('div').addClass('active');
        // 	var type = $(this).attr('data-type');
        // 	$.post('<?php echo site_url("home/sales_widget/'+type+'"); ?>', function(res)
        // 	{
        // 		var obj = jQuery.parseJSON(res);
        // 		if(obj.message)
        // 		{
        // 			$(".chart").html(obj.message);
        // 			return false;
        // 		}

        // 		renderChart(obj.day, obj.amount);

        // 		myBarChart.update();
        // 	});
        // });

        function renderChart(label, data) {

            $(".chart").html("").html('<canvas id="charts" width="400" height="400"></canvas>');
            var lineChartData = {
                labels: label,
                datasets: [{
                    fillColor: "#5d9bfb",
                    strokeColor: "#5d9bfb",
                    highlightFill: "#5d9bfb",
                    highlightStroke: "#5d9bfb",
                    data: data
                }]

            }
            var canvas = document.getElementById("charts");
            var ctx = canvas.getContext("2d");

            myLine = new Chart(ctx).Bar(lineChartData, {
                responsive: true,
                maintainAspectRatio: false
            });
        }


        // woo commerce oauth
        $('#woo_oauth').on('click', function() {
            var href = '<?php echo site_url("config/generate_woo_oauth_url"); ?>';
            $.ajax({
                type: "POST",
                url: href,
                data: {
                    'woo_url': $('#woo_api_url').val()
                },
                dataType: 'json',
                success: function(response) {
                    location.href = response.url;
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    show_feedback('error',
                        'Could not connect to WooCommerce. Please try again later.');
                }
            });
        });



    });
    </script>

    <?php $this->load->view("partial/footer"); ?>