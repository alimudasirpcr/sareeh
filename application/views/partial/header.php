<!DOCTYPE html>
<html class="<?php echo $this->config->item('language');?>">

<head>
<script>
		//OAuth for square appends this, we need to reset to prevent issue with jquery
		if (window.location.hash == "#_=_")
		  window.location.hash = "";
	</script>
    <meta charset="UTF-8" />
    <title>
        <?php 
		 $this->load->helper('demo');
	 	 $company = ($company = $this->Location->get_info_for_key('company')) ? $company : $this->config->item('company');
		 echo !is_on_demo_host() ?  $company.' -- '.lang('common_powered_by').' '.$this->config->item('branding')['name'] : 'Demo - '.$this->config->item('branding')['name'].' | Easy to use Online POS Software' ?>
    </title>
    <link rel="icon" href="<?php echo base_url();?>favicon_<?php echo $this->config->item('branding_code');?>.ico"
        type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <!--320-->
    <base href="<?php echo base_url();?>" />

    <style>
    <?php if ($this->agent->browser()=='Chrome') {
        ?>@page {
            margin: 0;
            padding: 0;
        }

        <?php
    }

    ?>@media print {
        .invoice-table-content {
            page-break-inside: avoid !important;
            -webkit-page-break-inside: avoid !important;
        }

        .panel_inventory_print_list .panel-body {
            padding: 40px 30px !important;
            border: 0 !important;
        }

        .panel_inventory_print_list .report-header {
            display: block !important;
        }
    }

    <?php if($this->config->item('add_ck_editor_to_item')) {
        ?>.ck-editor__editable_inline {
            min-height: 250px;
        }

        <?php
    }

    ?>
    </style>

    <link rel="icon" href="<?php echo base_url();?>favicon_<?php echo $this->config->item('branding_code');?>.ico"
        type="image/x-icon" />
    <script type="text/javascript">
    var APPLICATION_VERSION = "<?php echo APPLICATION_VERSION; ?>";
    var SITE_URL = "<?php echo site_url(); ?>";
    var BASE_URL = "<?php echo base_url(); ?>";
    var ENABLE_SOUNDS = <?php echo $this->config->item('enable_sounds') ? 'true' : 'false'; ?>;
    var JS_DATE_FORMAT = <?php echo json_encode(get_js_date_format()); ?>;
    var JS_TIME_FORMAT = <?php echo json_encode(get_js_time_format()); ?>;
    var LOCALE = <?php echo json_encode(get_js_locale()); ?>;
    var MONEY_NUM_DECIMALS =
        <?php echo $this->config->item('number_of_decimals') ? (int)$this->config->item('number_of_decimals') : 2; ?>;
    var IS_MOBILE = <?php echo $this->agent->is_mobile() ? 'true' : 'false'; ?>;
    var ENABLE_QUICK_EDIT = <?php echo $this->config->item('enable_quick_edit') ? 'true' : 'false'; ?>;
    var PER_PAGE =
        <?php echo json_encode($this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20); ?>;
    var EMPLOYEE_PERSON_ID =
        <?php echo json_encode((!defined("ENVIRONMENT") or ENVIRONMENT == 'development') ? 'test' : $this->Employee->get_logged_in_employee_info()->person_id);?>;
    var INVOICE_NO =
        <?php echo json_encode(substr((date('mdy')).(time() - strtotime("today")).($this->Employee->get_logged_in_employee_info()->person_id), 0, 16)); ?>;
    var CONFIRM_CLONE = <?php echo json_encode(lang('common_confirm_clone')); ?>;
    var CONFIRM_IMAGE_DELETE = <?php echo json_encode(lang('common_confirm_image_delete')); ?>;
    </script>

    <link rel="stylesheet" type="text/css"  href="<?php echo base_url()?>assets/css_good/css/custom.css" >
    <?php 
	$this->load->helper('assets');
	foreach(get_css_files() as $css_file) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().$css_file['path'].'?'.ASSET_TIMESTAMP;?>" />
    <?php } ?>
    <?php
    
    foreach(get_js_files() as $js_file) { ?>
    <script src="<?php echo base_url().$js_file['path'].'?'.ASSET_TIMESTAMP;?>" type="text/javascript" charset="UTF-8">
    </script>
    <?php } ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.7/umd/popper.min.js" integrity="sha512-uaZ0UXmB7NHxAxQawA8Ow2wWjdsedpRu7nJRSoI2mjnwtY8V5YiCWavoIpo1AhWPMLiW5iEeavmA3JJ2+1idUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php if($this->config->item('add_ck_editor_to_item')){?>
    <script src="<?php echo base_url().'assets/js/ckeditor/ckeditor.js?'.ASSET_TIMESTAMP;?>" type="text/javascript"
        charset="UTF-8"></script>
    <?php } ?>
    
    <script type="text/javascript">
    <?php
		$week_start_day = $this->config->item('week_start_day') ? $this->config->item('week_start_day') : 'monday';
		
		$dow = $week_start_day == 'monday' ? 1 : 0;
		?>
    moment.locale(LOCALE, {
        week: {
            dow: <?php echo $dow; ?>
        }
    });

    var SCREEN_WIDTH = $(window).width();
    var SCREEN_HEIGHT = $(window).height();
    COMMON_SUCCESS = <?php echo json_encode(lang('common_success')); ?>;
    COMMON_ERROR = <?php echo json_encode(lang('common_error')); ?>;

    bootbox.addLocale('ar', {
        OK: 'حسنا',
        CANCEL: 'إلغاء',
        CONFIRM: 'تأكيد'
    });

    bootbox.addLocale('km', {
        OK: 'យល់ព្រម',
        CANCEL: 'បោះបង់',
        CONFIRM: 'បញ្ជាក់ការ'
    });
    bootbox.setLocale(LOCALE);
    var RATE_LIMIT_IN_MS = 60 * 1000;
    var NUMBER_OF_REQUESTS_ALLOWED = 120;
    var NUMBER_OF_REQUESTS = 0;

    setInterval(function() {
        NUMBER_OF_REQUESTS = 0;

    }, RATE_LIMIT_IN_MS);

    $.ajaxSetup({
        cache: false,
        headers: {
            "cache-control": "no-cache"
        },
        beforeSend: function canSendAjaxRequest() {
            var can_send = NUMBER_OF_REQUESTS < NUMBER_OF_REQUESTS_ALLOWED;
            NUMBER_OF_REQUESTS++;
            return can_send;
        }
    });

    $(document).on('show.bs.modal', '.bootbox.modal', function(e) {
        var isShown = ($(".bootbox.modal").data('bs.modal') || {}).isShown;
        //If we have a dialog already don't open another one
        if (isShown) {
            //Cleanup the dialog(s) that was added to dom
            $('.bootbox.modal:not(:first)').remove();

            //Prevent double modal from showing up
            return e.preventDefault();
        }
    });


    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    $.fn.editableform.buttons =
        '<button tabindex="-1" type="submit" class="btn btn-primary btn-sm editable-submit">' +
        '<i class="icon ti-check"></i>' +
        '</button>' +
        '<button tabindex="-1" type="button" class="btn btn-default btn-sm editable-cancel">' +
        '<i class="icon ti-close"></i>' +
        '</button>';

    $.fn.editable.defaults.emptytext = <?php echo json_encode(lang('common_empty')); ?>;
    //https://github.com/OwlCarousel2/OwlCarousel2/issues/1374
    // Disabling bs transitions makes the modals show again:
    // $.support.transition = false
    // https://getbootstrap.com/docs/3.3/javascript/#transitions
    // DO NOT REMOVE THIS
    $.support.transition = false;

    $(document).ready(function() {
        <?php if ($this->config->item('hover_to_expand_sub_modules') == 'true') { ?>
        $("#mainMenu .has_sub_menu").hover(
            function() {
                $(this).children('.collapse').show();
            },
            function() {
                $(this).children('.collapse').hide();
            }
        );
        <?php } ?>
        $(".wrapper.mini-bar .left-bar").hover(
            function() {
                $(this).parent().removeClass('mini-bar');
            },
            function() {
                $(this).parent().addClass('mini-bar');
            }
        );



        $('.menu-bar').click(function(e) {
            e.preventDefault();
            $(".wrapper").toggleClass('mini-bar');
        });

        //Ajax submit current location
        $(".set_employee_current_location_id").on('click', function(e) {
            e.preventDefault();

            var location_id = $(this).data('location-id');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('home/set_employee_current_location_id'); ?>',
                data: {
                    'employee_current_location_id': location_id,
                },
                success: function() {
                    window.location.reload(true);
                }
            });

        });


          //Ajax submit quick access
          $("#save_quick_access").on('click', function(e) {
            e.preventDefault();
            var formData = $("#formdataquick").serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('home/save_quick_access'); ?>',
                data: formData,
                success: function() {
                    window.location.reload(true);
                }
            });

        });

        $(".set_employee_language").on('click', function(e) {
            e.preventDefault();

            var language_id = $(this).data('language-id');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('employees/set_language'); ?>',
                data: {
                    'employee_language_id': language_id,
                },
                success: function() {
                    window.location.reload(true);
                }
            });

        });

        <?php
			$this->load->helper('update');
			if (!is_on_phppos_host())
			{
				//If we are using on browser close (NULL or ""; both false) then we want to keep session alive
				if ($this->db->table_exists('app_config') && !$this->Appconfig->get_raw_phppos_session_expiration())
				{		
					?>
        //Keep session alive by sending a request every 5 minutes
        setInterval(function() {
            $.get('<?php echo site_url('home/keep_alive'); ?>');
        }, 300000);
        <?php } ?>
        <?php } ?>
    });


    function show_quick_access(){
        $("#quick_access").modal('show');
    }
    </script>
    <?php
$this->load->helper('demo');
if (is_on_demo_host()) { ?>
    <script src="//<?php echo $this->config->item('branding')['domain']; ?>/js/iframeResizer.contentWindow.min.js">
    </script>
    <?php } ?>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script> -->
</head>

<body data-kt-name="good" id="kt_app_body" data-kt-app-layout="<?= (isset($is_pos))?'mini-sidebar':'light-sidebar' ?>" data-kt-app-sidebar-enabled="true"
    data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" class="app-default">

    <script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-theme-mode");
        } else {
            if (localStorage.getItem("data-theme") !== null) {
                themeMode = localStorage.getItem("data-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-theme", themeMode);
    }
    </script>


    <div class="modal fade hidden-print" id="myModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
    <div class="modal fade hidden-print" id="myModalDisableClose" tabindex="-1" role="dialog" aria-hidden="true"
        data-keyboard="false" data-backdrop="static">
    </div>



    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header">
                <!--begin::Header container-->
                <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
                    id="kt_app_header_container">
                    <!--begin::Mobile menu toggle-->
                    <div class="d-flex align-items-center d-lg-none ms-n2 me-2 hidden-print" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px"
                            id="kt_app_sidebar_mobile_toggle">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                            <span class="svg-icon svg-icon-1 hidden-print">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                        fill="currentColor" />
                                    <path opacity="0.3"
                                        d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                    </div>
                    <!--end::Mobile menu toggle-->
                    <!--begin::Mobile logo-->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <a href="../dist/index.html" class="d-lg-none">
                            <!-- <img alt="Logo" src="assets/media/logos/default.svg" class="theme-light-show h-30px" />
                            <img alt="Logo" src="assets/media/logos/default-dark.svg" class="theme-dark-show h-30px" /> -->

							<div class="admin-logo" style="<?php echo isset($location_color) && $location_color ? 'background-color: '.$location_color.' !important': ''; ?>">
				<div class="logo-holder pull-left">
					<?php echo img(
					array(
						'src' => base_url().$this->config->item('branding')['logo_path'],
						'class'=>'hidden-print logo',
						'id'=>'header-logo',

					)); ?>
				</div>
				<!-- logo-holder -->
				<?php  

				?>			
			</div>


                        </a>
                    </div>
                    <!--end::Mobile logo-->
                    <!--begin::Header wrapper-->
                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
                        id="kt_app_header_wrapper">
                        <!--begin::Page title-->
                        <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
                            data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
                            class="page-title d-flex flex-column justify-content-center flex-wrap me-3 mb-5 mb-lg-0">
                            <!--begin::Title-->
                            <h1
                                class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                      
                            </h1>
                            <?php 
						 $this->load->helper('breadcrumb');
						 echo create_breadcrumb(); ?>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Navbar-->
                        <div class="app-navbar align-items-center flex-shrink-0 hidden-print">
                        <?php  
					$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;


					?>
                                <?php 
                                    if($this->Employee->has_module_permission('sales', $employee_id) || $this->Employee->has_module_permission('work_orders', $employee_id) || $this->Employee->has_module_permission('receivings', $employee_id) || $this->Employee->has_module_action_permission('customers', 'add_update', $employee_id) || $this->Employee->has_module_action_permission('items', 'add_update', $employee_id)) {

                                ?>
                            <!--begin::Notifications-->
                            <div class="app-navbar-item ms-2 ms-lg-4">
                                <!--begin::Menu- wrapper-->
                                <a href="#"
                                    class="btn btn-custom btn-icon btn-outline btn-icon-gray-700 btn-active-icon-primary"
                                    data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                            <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2"
                                                fill="currentColor" />
                                            <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2"
                                                fill="currentColor" />
                                            <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px"
                                    data-kt-menu="true">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-10"
                                        style="background-image:url('<?php echo base_url() ?>assets/css_good/media/misc/menu-header-bg.jpg')">
                                        <!--begin::Title-->
                                        <h3 class="text-white fw-semibold mb-3"><?php echo lang('common_add');?></h3>
                                        <!--end::Title-->
                                       
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin:Nav-->
                                    <div class="row g-0">
                                        <!--begin:Item-->
                                        <?php if($this->Employee->has_module_permission('sales', $employee_id)) { ?>

                                        <div class="col-6">
                                            <a href="<?php echo site_url('sales'); ?>"
                                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                                <!--begin::Svg Icon | path: icons/duotune/finance/fin009.svg-->
                                                <span class="svg-icon svg-icon-3x svg-icon-primary mb-2">
                                              
                                                <i class="fa fa-shopping-cart text-primary "></i>
								
                                                </span>
                                                <!--end::Svg Icon-->
                                                <span class="fs-5 fw-semibold text-gray-800 mb-0"><?php echo lang('sales_new_sale');?></span>
                                            </a>
                                        </div>
                                        <!--end:Item-->
                                        <?php } ?>

                                        <?php if($this->Employee->has_module_permission('work_orders', $employee_id)) { ?>

                                            <div class="col-6">
                                                <a href="<?php echo site_url('work_orders?new=1'); ?>"
                                                    class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                                    <!--begin::Svg Icon | path: icons/duotune/finance/fin009.svg-->
                                                    <span class="svg-icon svg-icon-3x svg-icon-primary mb-2">
                                                
                                                    <i class="fa fa-hammer text-primary "></i>

                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <span class="fs-5 fw-semibold text-gray-800 mb-0"><?php echo lang('common_new_work_order');?></span>
                                                </a>
                                            </div>
                                            <!--end:Item-->
                                            <?php } ?>

                                            <?php if($this->Employee->has_module_permission('receivings', $employee_id)) { ?>

                                                <div class="col-6">
                                                    <a href="<?php echo site_url('receivings/po/'); ?>"
                                                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                                        <!--begin::Svg Icon | path: icons/duotune/finance/fin009.svg-->
                                                        <span class="svg-icon svg-icon-3x svg-icon-primary mb-2">
                                                    
                                                        <i class="fa fa-store text-primary "></i>

                                                        </span>
                                                        <!--end::Svg Icon-->
                                                        <span class="fs-5 fw-semibold text-gray-800 mb-0"><?php echo lang('common_new_purchase_order');?></span>
                                                    </a>
                                                </div>
                                                <!--end:Item-->
                                            <?php } ?>

                                            <?php if($this->Employee->has_module_permission('receivings', $employee_id)) { ?>

                                                <div class="col-6">
                                                    <a href="<?php echo site_url('receivings/po/'); ?>"
                                                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                                        <!--begin::Svg Icon | path: icons/duotune/finance/fin009.svg-->
                                                        <span class="svg-icon svg-icon-3x svg-icon-primary mb-2">
                                                    
                                                        <i class="fa fa-store text-primary "></i>

                                                        </span>
                                                        <!--end::Svg Icon-->
                                                        <span class="fs-5 fw-semibold text-gray-800 mb-0"><?php echo lang('common_new_purchase_order');?></span>
                                                    </a>
                                                </div>
                                                <!--end:Item-->
                                            <?php } ?>

                                            <?php if($this->Employee->has_module_action_permission('customers', 'add_update', $employee_id)) { ?>

                                                <div class="col-6">
                                                    <a href="<?php echo site_url('customers/view/-1/'); ?>"
                                                        class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                                        <!--begin::Svg Icon | path: icons/duotune/finance/fin009.svg-->
                                                        <span class="svg-icon svg-icon-3x svg-icon-primary mb-2">
                                                    
                                                        <i class="fa fa-user text-primary "></i>

                                                        </span>
                                                        <!--end::Svg Icon-->
                                                        <span class="fs-5 fw-semibold text-gray-800 mb-0"><?php echo lang('customers_new');?></span>
                                                    </a>
                                                </div>
                                                <!--end:Item-->
                                                <?php } ?>
                                                <?php if($this->Employee->has_module_action_permission('items', 'add_update', $employee_id)) { ?>

                                            <div class="col-6">
                                                <a href="<?php echo site_url('items/view/-1/'); ?>"
                                                    class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                                    <!--begin::Svg Icon | path: icons/duotune/finance/fin009.svg-->
                                                    <span class="svg-icon svg-icon-3x svg-icon-primary mb-2">
                                                
                                                    <i class="fa fa-hdd text-primary "></i>

                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <span class="fs-5 fw-semibold text-gray-800 mb-0"><?php echo lang('items_new');?></span>
                                                </a>
                                            </div>
                                            <!--end:Item-->
                                            <?php } ?>
                                      
                                    </div>
                                    <!--end:Nav-->
                                   
                                </div>
                                <!--end::Menu-->
                                <!--end::Menu wrapper-->
                            </div>
                            <?php } ?>
                            <!--end::Notifications-->

                            <!--begin::Theme mode-->
                            <div class="app-navbar-item ms-2 ms-lg-4">
                                <!--begin::Menu toggle-->
                                <a href="#"
                                    class="btn btn-custom btn-outline btn-icon btn-icon-gray-700 btn-active-icon-primary"
                                    data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen060.svg-->
                                    <span class="svg-icon theme-light-show svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.9905 5.62598C10.7293 5.62574 9.49646 5.9995 8.44775 6.69997C7.39903 7.40045 6.58159 8.39619 6.09881 9.56126C5.61603 10.7263 5.48958 12.0084 5.73547 13.2453C5.98135 14.4823 6.58852 15.6185 7.48019 16.5104C8.37186 17.4022 9.50798 18.0096 10.7449 18.2557C11.9818 18.5019 13.2639 18.3757 14.429 17.8931C15.5942 17.4106 16.5901 16.5933 17.2908 15.5448C17.9915 14.4962 18.3655 13.2634 18.3655 12.0023C18.3637 10.3119 17.6916 8.69129 16.4964 7.49593C15.3013 6.30056 13.6808 5.62806 11.9905 5.62598Z"
                                                fill="currentColor" />
                                            <path
                                                d="M22.1258 10.8771H20.627C20.3286 10.8771 20.0424 10.9956 19.8314 11.2066C19.6204 11.4176 19.5018 11.7038 19.5018 12.0023C19.5018 12.3007 19.6204 12.5869 19.8314 12.7979C20.0424 13.0089 20.3286 13.1274 20.627 13.1274H22.1258C22.4242 13.1274 22.7104 13.0089 22.9214 12.7979C23.1324 12.5869 23.2509 12.3007 23.2509 12.0023C23.2509 11.7038 23.1324 11.4176 22.9214 11.2066C22.7104 10.9956 22.4242 10.8771 22.1258 10.8771Z"
                                                fill="currentColor" />
                                            <path
                                                d="M11.9905 19.4995C11.6923 19.5 11.4064 19.6187 11.1956 19.8296C10.9848 20.0405 10.8663 20.3265 10.866 20.6247V22.1249C10.866 22.4231 10.9845 22.7091 11.1953 22.9199C11.4062 23.1308 11.6922 23.2492 11.9904 23.2492C12.2886 23.2492 12.5746 23.1308 12.7854 22.9199C12.9963 22.7091 13.1147 22.4231 13.1147 22.1249V20.6247C13.1145 20.3265 12.996 20.0406 12.7853 19.8296C12.5745 19.6187 12.2887 19.5 11.9905 19.4995Z"
                                                fill="currentColor" />
                                            <path
                                                d="M4.49743 12.0023C4.49718 11.704 4.37865 11.4181 4.16785 11.2072C3.95705 10.9962 3.67119 10.8775 3.37298 10.8771H1.87445C1.57603 10.8771 1.28984 10.9956 1.07883 11.2066C0.867812 11.4176 0.749266 11.7038 0.749266 12.0023C0.749266 12.3007 0.867812 12.5869 1.07883 12.7979C1.28984 13.0089 1.57603 13.1274 1.87445 13.1274H3.37299C3.6712 13.127 3.95706 13.0083 4.16785 12.7973C4.37865 12.5864 4.49718 12.3005 4.49743 12.0023Z"
                                                fill="currentColor" />
                                            <path
                                                d="M11.9905 4.50058C12.2887 4.50012 12.5745 4.38141 12.7853 4.17048C12.9961 3.95954 13.1147 3.67361 13.1149 3.3754V1.87521C13.1149 1.57701 12.9965 1.29103 12.7856 1.08017C12.5748 0.869313 12.2888 0.750854 11.9906 0.750854C11.6924 0.750854 11.4064 0.869313 11.1955 1.08017C10.9847 1.29103 10.8662 1.57701 10.8662 1.87521V3.3754C10.8664 3.67359 10.9849 3.95952 11.1957 4.17046C11.4065 4.3814 11.6923 4.50012 11.9905 4.50058Z"
                                                fill="currentColor" />
                                            <path
                                                d="M18.8857 6.6972L19.9465 5.63642C20.0512 5.53209 20.1343 5.40813 20.1911 5.27163C20.2479 5.13513 20.2772 4.98877 20.2774 4.84093C20.2775 4.69309 20.2485 4.54667 20.192 4.41006C20.1355 4.27344 20.0526 4.14932 19.948 4.04478C19.8435 3.94024 19.7194 3.85734 19.5828 3.80083C19.4462 3.74432 19.2997 3.71531 19.1519 3.71545C19.0041 3.7156 18.8577 3.7449 18.7212 3.80167C18.5847 3.85845 18.4607 3.94159 18.3564 4.04633L17.2956 5.10714C17.1909 5.21147 17.1077 5.33543 17.0509 5.47194C16.9942 5.60844 16.9649 5.7548 16.9647 5.90264C16.9646 6.05048 16.9936 6.19689 17.0501 6.33351C17.1066 6.47012 17.1895 6.59425 17.294 6.69878C17.3986 6.80332 17.5227 6.88621 17.6593 6.94272C17.7959 6.99923 17.9424 7.02824 18.0902 7.02809C18.238 7.02795 18.3844 6.99865 18.5209 6.94187C18.6574 6.88509 18.7814 6.80195 18.8857 6.6972Z"
                                                fill="currentColor" />
                                            <path
                                                d="M18.8855 17.3073C18.7812 17.2026 18.6572 17.1195 18.5207 17.0627C18.3843 17.006 18.2379 16.9767 18.0901 16.9766C17.9423 16.9764 17.7959 17.0055 17.6593 17.062C17.5227 17.1185 17.3986 17.2014 17.2941 17.3059C17.1895 17.4104 17.1067 17.5345 17.0501 17.6711C16.9936 17.8077 16.9646 17.9541 16.9648 18.1019C16.9649 18.2497 16.9942 18.3961 17.0509 18.5326C17.1077 18.6691 17.1908 18.793 17.2955 18.8974L18.3563 19.9582C18.4606 20.0629 18.5846 20.146 18.721 20.2027C18.8575 20.2595 19.0039 20.2887 19.1517 20.2889C19.2995 20.289 19.4459 20.26 19.5825 20.2035C19.7191 20.147 19.8432 20.0641 19.9477 19.9595C20.0523 19.855 20.1351 19.7309 20.1916 19.5943C20.2482 19.4577 20.2772 19.3113 20.277 19.1635C20.2769 19.0157 20.2476 18.8694 20.1909 18.7329C20.1341 18.5964 20.051 18.4724 19.9463 18.3681L18.8855 17.3073Z"
                                                fill="currentColor" />
                                            <path
                                                d="M5.09528 17.3072L4.0345 18.368C3.92972 18.4723 3.84655 18.5963 3.78974 18.7328C3.73294 18.8693 3.70362 19.0156 3.70346 19.1635C3.7033 19.3114 3.7323 19.4578 3.78881 19.5944C3.84532 19.7311 3.92822 19.8552 4.03277 19.9598C4.13732 20.0643 4.26147 20.1472 4.3981 20.2037C4.53473 20.2602 4.68117 20.2892 4.82902 20.2891C4.97688 20.2889 5.12325 20.2596 5.25976 20.2028C5.39627 20.146 5.52024 20.0628 5.62456 19.958L6.68536 18.8973C6.79007 18.7929 6.87318 18.6689 6.92993 18.5325C6.98667 18.396 7.01595 18.2496 7.01608 18.1018C7.01621 17.954 6.98719 17.8076 6.93068 17.671C6.87417 17.5344 6.79129 17.4103 6.68676 17.3058C6.58224 17.2012 6.45813 17.1183 6.32153 17.0618C6.18494 17.0053 6.03855 16.9763 5.89073 16.9764C5.74291 16.9766 5.59657 17.0058 5.46007 17.0626C5.32358 17.1193 5.19962 17.2024 5.09528 17.3072Z"
                                                fill="currentColor" />
                                            <path
                                                d="M5.09541 6.69715C5.19979 6.8017 5.32374 6.88466 5.4602 6.94128C5.59665 6.9979 5.74292 7.02708 5.89065 7.02714C6.03839 7.0272 6.18469 6.99815 6.32119 6.94164C6.45769 6.88514 6.58171 6.80228 6.68618 6.69782C6.79064 6.59336 6.87349 6.46933 6.93 6.33283C6.9865 6.19633 7.01556 6.05003 7.01549 5.9023C7.01543 5.75457 6.98625 5.60829 6.92963 5.47184C6.87301 5.33539 6.79005 5.21143 6.6855 5.10706L5.6247 4.04626C5.5204 3.94137 5.39643 3.8581 5.25989 3.80121C5.12335 3.74432 4.97692 3.71493 4.82901 3.71472C4.68109 3.71452 4.53458 3.7435 4.39789 3.80001C4.26119 3.85652 4.13699 3.93945 4.03239 4.04404C3.9278 4.14864 3.84487 4.27284 3.78836 4.40954C3.73185 4.54624 3.70287 4.69274 3.70308 4.84066C3.70329 4.98858 3.73268 5.135 3.78957 5.27154C3.84646 5.40808 3.92974 5.53205 4.03462 5.63635L5.09541 6.69715Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
                                    <span class="svg-icon theme-dark-show svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M19.0647 5.43757C19.3421 5.43757 19.567 5.21271 19.567 4.93534C19.567 4.65796 19.3421 4.43311 19.0647 4.43311C18.7874 4.43311 18.5625 4.65796 18.5625 4.93534C18.5625 5.21271 18.7874 5.43757 19.0647 5.43757Z"
                                                fill="currentColor" />
                                            <path
                                                d="M20.0692 9.48884C20.3466 9.48884 20.5714 9.26398 20.5714 8.98661C20.5714 8.70923 20.3466 8.48438 20.0692 8.48438C19.7918 8.48438 19.567 8.70923 19.567 8.98661C19.567 9.26398 19.7918 9.48884 20.0692 9.48884Z"
                                                fill="currentColor" />
                                            <path
                                                d="M12.0335 20.5714C15.6943 20.5714 18.9426 18.2053 20.1168 14.7338C20.1884 14.5225 20.1114 14.289 19.9284 14.161C19.746 14.034 19.5003 14.0418 19.3257 14.1821C18.2432 15.0546 16.9371 15.5156 15.5491 15.5156C12.2257 15.5156 9.48884 12.8122 9.48884 9.48886C9.48884 7.41079 10.5773 5.47137 12.3449 4.35752C12.5342 4.23832 12.6 4.00733 12.5377 3.79251C12.4759 3.57768 12.2571 3.42859 12.0335 3.42859C7.32556 3.42859 3.42857 7.29209 3.42857 12C3.42857 16.7079 7.32556 20.5714 12.0335 20.5714Z"
                                                fill="currentColor" />
                                            <path
                                                d="M13.0379 7.47998C13.8688 7.47998 14.5446 8.15585 14.5446 8.98668C14.5446 9.26428 14.7693 9.48891 15.0469 9.48891C15.3245 9.48891 15.5491 9.26428 15.5491 8.98668C15.5491 8.15585 16.225 7.47998 17.0558 7.47998C17.3334 7.47998 17.558 7.25535 17.558 6.97775C17.558 6.70015 17.3334 6.47552 17.0558 6.47552C16.225 6.47552 15.5491 5.76616 15.5491 4.93534C15.5491 4.65774 15.3245 4.43311 15.0469 4.43311C14.7693 4.43311 14.5446 4.65774 14.5446 4.93534C14.5446 5.76616 13.8688 6.47552 13.0379 6.47552C12.7603 6.47552 12.5357 6.70015 12.5357 6.97775C12.5357 7.25535 12.7603 7.47998 13.0379 7.47998Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--begin::Menu toggle-->
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px"
                                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3 my-0">
                                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                            data-kt-value="light">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen060.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.9905 5.62598C10.7293 5.62574 9.49646 5.9995 8.44775 6.69997C7.39903 7.40045 6.58159 8.39619 6.09881 9.56126C5.61603 10.7263 5.48958 12.0084 5.73547 13.2453C5.98135 14.4823 6.58852 15.6185 7.48019 16.5104C8.37186 17.4022 9.50798 18.0096 10.7449 18.2557C11.9818 18.5019 13.2639 18.3757 14.429 17.8931C15.5942 17.4106 16.5901 16.5933 17.2908 15.5448C17.9915 14.4962 18.3655 13.2634 18.3655 12.0023C18.3637 10.3119 17.6916 8.69129 16.4964 7.49593C15.3013 6.30056 13.6808 5.62806 11.9905 5.62598Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M22.1258 10.8771H20.627C20.3286 10.8771 20.0424 10.9956 19.8314 11.2066C19.6204 11.4176 19.5018 11.7038 19.5018 12.0023C19.5018 12.3007 19.6204 12.5869 19.8314 12.7979C20.0424 13.0089 20.3286 13.1274 20.627 13.1274H22.1258C22.4242 13.1274 22.7104 13.0089 22.9214 12.7979C23.1324 12.5869 23.2509 12.3007 23.2509 12.0023C23.2509 11.7038 23.1324 11.4176 22.9214 11.2066C22.7104 10.9956 22.4242 10.8771 22.1258 10.8771Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M11.9905 19.4995C11.6923 19.5 11.4064 19.6187 11.1956 19.8296C10.9848 20.0405 10.8663 20.3265 10.866 20.6247V22.1249C10.866 22.4231 10.9845 22.7091 11.1953 22.9199C11.4062 23.1308 11.6922 23.2492 11.9904 23.2492C12.2886 23.2492 12.5746 23.1308 12.7854 22.9199C12.9963 22.7091 13.1147 22.4231 13.1147 22.1249V20.6247C13.1145 20.3265 12.996 20.0406 12.7853 19.8296C12.5745 19.6187 12.2887 19.5 11.9905 19.4995Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M4.49743 12.0023C4.49718 11.704 4.37865 11.4181 4.16785 11.2072C3.95705 10.9962 3.67119 10.8775 3.37298 10.8771H1.87445C1.57603 10.8771 1.28984 10.9956 1.07883 11.2066C0.867812 11.4176 0.749266 11.7038 0.749266 12.0023C0.749266 12.3007 0.867812 12.5869 1.07883 12.7979C1.28984 13.0089 1.57603 13.1274 1.87445 13.1274H3.37299C3.6712 13.127 3.95706 13.0083 4.16785 12.7973C4.37865 12.5864 4.49718 12.3005 4.49743 12.0023Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M11.9905 4.50058C12.2887 4.50012 12.5745 4.38141 12.7853 4.17048C12.9961 3.95954 13.1147 3.67361 13.1149 3.3754V1.87521C13.1149 1.57701 12.9965 1.29103 12.7856 1.08017C12.5748 0.869313 12.2888 0.750854 11.9906 0.750854C11.6924 0.750854 11.4064 0.869313 11.1955 1.08017C10.9847 1.29103 10.8662 1.57701 10.8662 1.87521V3.3754C10.8664 3.67359 10.9849 3.95952 11.1957 4.17046C11.4065 4.3814 11.6923 4.50012 11.9905 4.50058Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M18.8857 6.6972L19.9465 5.63642C20.0512 5.53209 20.1343 5.40813 20.1911 5.27163C20.2479 5.13513 20.2772 4.98877 20.2774 4.84093C20.2775 4.69309 20.2485 4.54667 20.192 4.41006C20.1355 4.27344 20.0526 4.14932 19.948 4.04478C19.8435 3.94024 19.7194 3.85734 19.5828 3.80083C19.4462 3.74432 19.2997 3.71531 19.1519 3.71545C19.0041 3.7156 18.8577 3.7449 18.7212 3.80167C18.5847 3.85845 18.4607 3.94159 18.3564 4.04633L17.2956 5.10714C17.1909 5.21147 17.1077 5.33543 17.0509 5.47194C16.9942 5.60844 16.9649 5.7548 16.9647 5.90264C16.9646 6.05048 16.9936 6.19689 17.0501 6.33351C17.1066 6.47012 17.1895 6.59425 17.294 6.69878C17.3986 6.80332 17.5227 6.88621 17.6593 6.94272C17.7959 6.99923 17.9424 7.02824 18.0902 7.02809C18.238 7.02795 18.3844 6.99865 18.5209 6.94187C18.6574 6.88509 18.7814 6.80195 18.8857 6.6972Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M18.8855 17.3073C18.7812 17.2026 18.6572 17.1195 18.5207 17.0627C18.3843 17.006 18.2379 16.9767 18.0901 16.9766C17.9423 16.9764 17.7959 17.0055 17.6593 17.062C17.5227 17.1185 17.3986 17.2014 17.2941 17.3059C17.1895 17.4104 17.1067 17.5345 17.0501 17.6711C16.9936 17.8077 16.9646 17.9541 16.9648 18.1019C16.9649 18.2497 16.9942 18.3961 17.0509 18.5326C17.1077 18.6691 17.1908 18.793 17.2955 18.8974L18.3563 19.9582C18.4606 20.0629 18.5846 20.146 18.721 20.2027C18.8575 20.2595 19.0039 20.2887 19.1517 20.2889C19.2995 20.289 19.4459 20.26 19.5825 20.2035C19.7191 20.147 19.8432 20.0641 19.9477 19.9595C20.0523 19.855 20.1351 19.7309 20.1916 19.5943C20.2482 19.4577 20.2772 19.3113 20.277 19.1635C20.2769 19.0157 20.2476 18.8694 20.1909 18.7329C20.1341 18.5964 20.051 18.4724 19.9463 18.3681L18.8855 17.3073Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M5.09528 17.3072L4.0345 18.368C3.92972 18.4723 3.84655 18.5963 3.78974 18.7328C3.73294 18.8693 3.70362 19.0156 3.70346 19.1635C3.7033 19.3114 3.7323 19.4578 3.78881 19.5944C3.84532 19.7311 3.92822 19.8552 4.03277 19.9598C4.13732 20.0643 4.26147 20.1472 4.3981 20.2037C4.53473 20.2602 4.68117 20.2892 4.82902 20.2891C4.97688 20.2889 5.12325 20.2596 5.25976 20.2028C5.39627 20.146 5.52024 20.0628 5.62456 19.958L6.68536 18.8973C6.79007 18.7929 6.87318 18.6689 6.92993 18.5325C6.98667 18.396 7.01595 18.2496 7.01608 18.1018C7.01621 17.954 6.98719 17.8076 6.93068 17.671C6.87417 17.5344 6.79129 17.4103 6.68676 17.3058C6.58224 17.2012 6.45813 17.1183 6.32153 17.0618C6.18494 17.0053 6.03855 16.9763 5.89073 16.9764C5.74291 16.9766 5.59657 17.0058 5.46007 17.0626C5.32358 17.1193 5.19962 17.2024 5.09528 17.3072Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M5.09541 6.69715C5.19979 6.8017 5.32374 6.88466 5.4602 6.94128C5.59665 6.9979 5.74292 7.02708 5.89065 7.02714C6.03839 7.0272 6.18469 6.99815 6.32119 6.94164C6.45769 6.88514 6.58171 6.80228 6.68618 6.69782C6.79064 6.59336 6.87349 6.46933 6.93 6.33283C6.9865 6.19633 7.01556 6.05003 7.01549 5.9023C7.01543 5.75457 6.98625 5.60829 6.92963 5.47184C6.87301 5.33539 6.79005 5.21143 6.6855 5.10706L5.6247 4.04626C5.5204 3.94137 5.39643 3.8581 5.25989 3.80121C5.12335 3.74432 4.97692 3.71493 4.82901 3.71472C4.68109 3.71452 4.53458 3.7435 4.39789 3.80001C4.26119 3.85652 4.13699 3.93945 4.03239 4.04404C3.9278 4.14864 3.84487 4.27284 3.78836 4.40954C3.73185 4.54624 3.70287 4.69274 3.70308 4.84066C3.70329 4.98858 3.73268 5.135 3.78957 5.27154C3.84646 5.40808 3.92974 5.53205 4.03462 5.63635L5.09541 6.69715Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title"><?php echo lang('light') ?></span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3 my-0">
                                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                            data-kt-value="dark">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M19.0647 5.43757C19.3421 5.43757 19.567 5.21271 19.567 4.93534C19.567 4.65796 19.3421 4.43311 19.0647 4.43311C18.7874 4.43311 18.5625 4.65796 18.5625 4.93534C18.5625 5.21271 18.7874 5.43757 19.0647 5.43757Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M20.0692 9.48884C20.3466 9.48884 20.5714 9.26398 20.5714 8.98661C20.5714 8.70923 20.3466 8.48438 20.0692 8.48438C19.7918 8.48438 19.567 8.70923 19.567 8.98661C19.567 9.26398 19.7918 9.48884 20.0692 9.48884Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M12.0335 20.5714C15.6943 20.5714 18.9426 18.2053 20.1168 14.7338C20.1884 14.5225 20.1114 14.289 19.9284 14.161C19.746 14.034 19.5003 14.0418 19.3257 14.1821C18.2432 15.0546 16.9371 15.5156 15.5491 15.5156C12.2257 15.5156 9.48884 12.8122 9.48884 9.48886C9.48884 7.41079 10.5773 5.47137 12.3449 4.35752C12.5342 4.23832 12.6 4.00733 12.5377 3.79251C12.4759 3.57768 12.2571 3.42859 12.0335 3.42859C7.32556 3.42859 3.42857 7.29209 3.42857 12C3.42857 16.7079 7.32556 20.5714 12.0335 20.5714Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M13.0379 7.47998C13.8688 7.47998 14.5446 8.15585 14.5446 8.98668C14.5446 9.26428 14.7693 9.48891 15.0469 9.48891C15.3245 9.48891 15.5491 9.26428 15.5491 8.98668C15.5491 8.15585 16.225 7.47998 17.0558 7.47998C17.3334 7.47998 17.558 7.25535 17.558 6.97775C17.558 6.70015 17.3334 6.47552 17.0558 6.47552C16.225 6.47552 15.5491 5.76616 15.5491 4.93534C15.5491 4.65774 15.3245 4.43311 15.0469 4.43311C14.7693 4.43311 14.5446 4.65774 14.5446 4.93534C14.5446 5.76616 13.8688 6.47552 13.0379 6.47552C12.7603 6.47552 12.5357 6.70015 12.5357 6.97775C12.5357 7.25535 12.7603 7.47998 13.0379 7.47998Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title"><?php echo lang('dark') ?></span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3 my-0">
                                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                            data-kt-value="system">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen062.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M1.34375 3.9463V15.2178C1.34375 16.119 2.08105 16.8563 2.98219 16.8563H8.65093V19.4594H6.15702C5.38853 19.4594 4.75981 19.9617 4.75981 20.5757V21.6921H19.2403V20.5757C19.2403 19.9617 18.6116 19.4594 17.8431 19.4594H15.3492V16.8563H21.0179C21.919 16.8563 22.6562 16.119 22.6562 15.2178V3.9463C22.6562 3.04516 21.9189 2.30786 21.0179 2.30786H2.98219C2.08105 2.30786 1.34375 3.04516 1.34375 3.9463ZM12.9034 9.9016C13.241 9.98792 13.5597 10.1216 13.852 10.2949L15.0393 9.4353L15.9893 10.3853L15.1297 11.5727C15.303 11.865 15.4366 12.1837 15.523 12.5212L16.97 12.7528V13.4089H13.9851C13.9766 12.3198 13.0912 11.4394 12 11.4394C10.9089 11.4394 10.0235 12.3198 10.015 13.4089H7.03006V12.7528L8.47712 12.5211C8.56345 12.1836 8.69703 11.8649 8.87037 11.5727L8.0107 10.3853L8.96078 9.4353L10.148 10.2949C10.4404 10.1215 10.759 9.98788 11.0966 9.9016L11.3282 8.45467H12.6718L12.9034 9.9016ZM16.1353 7.93758C15.6779 7.93758 15.3071 7.56681 15.3071 7.1094C15.3071 6.652 15.6779 6.28122 16.1353 6.28122C16.5926 6.28122 16.9634 6.652 16.9634 7.1094C16.9634 7.56681 16.5926 7.93758 16.1353 7.93758ZM2.71385 14.0964V3.90518C2.71385 3.78023 2.81612 3.67796 2.94107 3.67796H21.0589C21.1839 3.67796 21.2861 3.78023 21.2861 3.90518V14.0964C15.0954 14.0964 8.90462 14.0964 2.71385 14.0964Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title"><?php echo lang('system') ?></span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--end::Theme mode-->
                            <!--begin::Quick links-->


                           
                    


                    <?php if (is_on_demo_host() || ($this->config->item('show_language_switcher') && $this->Employee->has_module_action_permission('employees','edit_profile',$this->Employee->get_logged_in_employee_info()->person_id))) { ?>
						<?php 
						$languages = array(
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
						);

						?>	

                        <div class="app-navbar-item ms-2 ms-lg-4">
                            <!--begin::Menu wrapper-->
                            <a href="#" class="btn btn-icon btn-outline  w-100 p-2 fw-bold" data-kt-menu-trigger="click"
                                data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"
                                data-kt-menu-flip="bottom" id="unread_message_count">
                                <span class="fs-8"><img class=
							"flag_img" src="<?php echo base_url(); ?>assets/assets/images/flags/<?php echo $user_info->language ? $user_info->language : "english";  ?>.png" alt="" style=" width: 18px; margin-bottom: 3px;"> <span class="hidden-sm hidden-xs"> <?php echo $user_info->language ? $languages[$user_info->language] : $languages["english"];  ?></span></span>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px"
                                data-kt-menu="true">
                                <!--begin::Heading-->
                                <div class="d-flex flex-column bgi-no-repeat rounded-top"
                                    style="background-image:url('<?php echo base_url() ?>assets/css_good/media/misc/menu-header-bg.jpg')">
                                    <!--begin::Title-->
                                    <h3 class="text-white fw-semibold  mb-3 p-10"><?php echo lang('languages') ?> 
                                     
                                    </h3>
                                    <!--end::Title-->
                                    <!--begin::Tabs-->
                                    <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark opacity-75 opacity-state-100 pb-4"
                                                data-bs-toggle="tab" href="#kt_topbar_notifications_5"><?php echo lang('list_languages') ?></a>
                                        </li>
                                       
                                    </ul>
                                    <!--end::Tabs-->
                                </div>
                                <!--end::Heading-->
                                <!--begin::Tab content-->
                                <div class="tab-content">
                                 
                                    <!--begin::Tab panel-->
                                    <div class="tab-pane fade show active" id="kt_topbar_notifications_5"
                                        role="tabpanel">
                                        <!--begin::Wrapper-->
                                          <!--begin::Items-->
                                            <div class="scroll-y mh-325px my-5 px-8">
                                    <?php if(count($languages) > 0 ): ?> 
                                            <?php foreach ($languages as $key => $value) {  
                                                if($user_info->language!=$key){
                                                ?>
                                
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack py-4">
                                                    <!--begin::Section-->
                                                    <div class="d-flex align-items-center me-2">
                                                        
                                                        <!--begin::Title-->
                                                        <a href="<?php echo site_url('employees/set_language/') ?>" data-language-id="<?php echo $key; ?>" class="text-gray-800 text-hover-primary fw-semibold set_employee_language"> <img class="flag_img" src="<?php echo base_url(); ?>assets/assets/images/flags/<?php echo $key; ?>.png" alt="flags" style=" width: 30px;margin: 5px;"><?php echo $value; ?> </a>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Section-->
                                                    
                                                </div>

                                                <?php	}} ?>
                                                <!--end::Item-->
                                                <?php else: ?>
                                                    <div class="d-flex flex-stack py-4">
                                                    <?php echo lang('no_languages') ?>
                                                        </div>
                                                    <?php endif; ?>

                                              
                                    
                                            </div>
                                            <!--end::Items-->
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Tab panel-->
                                   
                                </div>
                                <!--end::Tab content-->
                            </div>
                            <!--end::Menu-->
                            <!--end::Menu wrapper-->
                        </div>

                <?php } ?>
                    

                            <div class="app-navbar-item ms-2 ms-lg-4">
                                <!--begin::Menu wrapper-->
                                <?php $new_message_count =  count($this->Employee->get_notifications());  ?>
                                <a href="#" class="btn btn-icon btn-outline fw-bold count <?php echo $new_message_count > 0 ? 'bell': '';?>" data-kt-menu-trigger="click"
                                    data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"
                                    data-kt-menu-flip="bottom" id="unread_message_count">
                                    <span class="fs-8"><?php echo $new_message_count; ?></span>
                                </a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px"
                                    data-kt-menu="true">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-column bgi-no-repeat rounded-top"
                                        style="background-image:url('<?php echo base_url(); ?>assets/css_good/media/misc/menu-header-bg.jpg')">
                                        <!--begin::Title-->
                                        <h3 class="text-dark fw-semibold px-9 mt-10 mb-6">Messages
                                            <span class="fs-8 opacity-75 ps-3"><?php echo $new_message_count; ?> <?php echo lang('messages') ?></span>
                                        </h3>
                                        <!--end::Title-->
                                        <!--begin::Tabs-->
                                        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                                            <li class="nav-item">
                                                <a class="nav-link text-dark opacity-75 opacity-state-100 pb-4 active"
                                                    data-bs-toggle="tab" href="#" data-target="#kt_topbar_notifications_2"><?php echo lang('messages') ?></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-dark opacity-75 opacity-state-100 pb-4"
                                                    data-bs-toggle="tab" href="#" data-target="#kt_topbar_notifications_3"><?php echo lang('transfer_requests') ?></a>
                                            </li>
                                           
                                        </ul>
                                        <!--end::Tabs-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Tab content-->
                                    <div class="tab-content">
                                      <!--begin::Tab panel-->
                                      <div class="tab-pane fade " id="kt_topbar_notifications_3"
                                            role="tabpanel">
                                            <!--begin::Wrapper-->
                                          	<!--begin::Items-->
												<div class="scroll-y mh-325px my-5 px-8">
                                                <?php if(count($this->Employee->get_notifications(4)) > 0 ): ?> 
                                                        <?php foreach ($this->Employee->get_notifications(4) as $key => $value) { ?>
									
                                                            <!--begin::Item-->
                                                            <div class="d-flex flex-stack py-4">
                                                                <!--begin::Section-->
                                                                <div class="d-flex align-items-center me-2">
                                                                    <!--begin::Code-->
                                                                    <span class="w-70px badge badge-light-success me-4"><?php echo lang('new') ?></span>
                                                                    <!--end::Code-->
                                                                    <!--begin::Title-->
                                                                    <?php $href ='';
                                                                        if($value['module']=='transfer'){
                                                                            $href = site_url().'receivings/receipt/'.$value['module_id'].'?submit=Recp';
                                                                        }
                                                                    
                                                                    ?>
                                                                    <a href="<?php echo $href; ?>" class="text-gray-800 text-hover-primary fw-semibold"><?php echo H($value['message']); ?></a>
                                                                    <!--end::Title-->
                                                                </div>
                                                                <!--end::Section-->
                                                                <!--begin::Label-->
                                                                <span class="badge badge-light fs-8"><?php echo time_elapsed_string($value['created_at']) ?> </span>
                                                                <!--end::Label-->
                                                            </div>

                                                            <?php	} ?>
													<!--end::Item-->
                                                    <?php endif; ?>
                                                </div>
                                      </div>
                                        <!--begin::Tab panel-->
                                        <div class="tab-pane fade show active" id="kt_topbar_notifications_2"
                                            role="tabpanel">
                                            <!--begin::Wrapper-->
                                          	<!--begin::Items-->
												<div class="scroll-y mh-325px my-5 px-8">
                                                    <?php if(count($this->Employee->get_messages(4)) > 0 ): ?> 
                                                        <?php foreach ($this->Employee->get_messages(4) as $key => $value) { ?>
									
                                                            <!--begin::Item-->
                                                            <div class="d-flex flex-stack py-4">
                                                                <!--begin::Section-->
                                                                <div class="d-flex align-items-center me-2">
                                                                    <!--begin::Code-->
                                                                    <span class="w-70px badge badge-light-success me-4"><?php echo lang('new') ?></span>
                                                                    <!--end::Code-->
                                                                    <!--begin::Title-->
                                                                    <a href="<?php echo site_url('messages'); ?>" class="text-gray-800 text-hover-primary fw-semibold"><?php echo H($value['message']); ?></a>
                                                                    <!--end::Title-->
                                                                </div>
                                                                <!--end::Section-->
                                                                <!--begin::Label-->
                                                                <span class="badge badge-light fs-8"><?php echo time_elapsed_string($value['created_at']) ?> </span>
                                                                <!--end::Label-->
                                                            </div>

                                                            <?php	} ?>
													<!--end::Item-->
                                                    <?php endif; ?>
                                                   
                                   
												</div>
												<!--end::Items-->
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Tab panel-->
                                       
                                    </div>
                                    <!--end::Tab content-->
                                </div>
                                <!--end::Menu-->
                                </div>
                                <!--end::Menu wrapper-->
                                </div>
                            <!--end::Quick links-->
                            
                            <!--begin::User-->
                            <?php /**
                            <div class="app-sidebar-user d-flex flex-stack py-5 px-8">
                                <!--begin::User avatar-->
                                <div class="d-flex me-5">
                                    <!--begin::Menu wrapper-->
                                    <div class="me-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px cursor-pointer"
                                            data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                            data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
                                            <img src="<?php echo base_url('assets/css_good/media/avatars/300-1.jpg') ?>"
                                                alt="" />
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::User account menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content d-flex align-items-center px-3">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px me-5">
                                                        <img alt="Logo"
                                                            src="<?php echo base_url('assets/css_good/media/avatars/300-1.jpg') ?>" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Username-->
                                                    <div class="d-flex flex-column">
                                                        <div class="fw-bold d-flex align-items-center fs-5">
                                                            <?php echo H($user_info->first_name." ".$user_info->last_name); ?>
                                                            <span
                                                                class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span>
                                                        </div>
                                                        <a href="#"
                                                            class="fw-semibold text-muted text-hover-primary fs-7">Staff</a>
                                                    </div>
                                                    <!--end::Username-->
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator my-2"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a id="support_link" target="_blank"
                                                    href="https://support.<?php echo $this->config->item('branding')['domain']; ?>/"
                                                    class="menu-link px-5"><?php echo lang('common_support'); ?></a>


                                            </div>
                                            <!--end::Menu item-->
                                            <?php if ($this->Employee->has_module_permission('config', $user_info->person_id)) {?>
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">

                                                <?php echo anchor("config",'<span class="menu-link px-5">'.lang("common_settings").'</span>', array('tabindex' => '-1')); ?>

                                            </div>
                                            <!--end::Menu item-->

                                            <?php } ?>





                                            <?php 
													$this->load->helper('update');
													if (is_on_phppos_host() && !is_on_demo_host() && !empty($cloud_customer_info)) {?>

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a id="update_billing_link" target="_blank"
                                                    href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username'];?>&username=<?php echo $this->Employee->get_logged_in_employee_info()->username; ?>&password=<?php echo $this->Employee->get_logged_in_employee_info()->password; ?>"
                                                    class="menu-link px-5"><?php echo lang('common_update_billing_info'); ?></a>


                                            </div>
                                            <!--end::Menu item-->



                                            <?php } ?>


                                            <?php if ($this->Location->get_info_for_key('blockchyp_api_key') && $this->Employee->has_module_action_permission('sales', 'view_edit_transaction_history', $this->Employee->get_logged_in_employee_info()->person_id)) {?>


                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a htarget="_blank" tabindex="-1" title=""
                                                    href="<?php echo site_url('sales/coreclear_portal')?>"
                                                    class="menu-link px-5">
                                                    <span
                                                        class="menu-text"><?php echo lang('sales_coreclear_portal'); ?></span>

                                                </a>
                                            </div>
                                            <!--end::Menu item-->


                                            <?php } ?>



                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a tabindex="-1" id="change_log_link" target="_blank"
                                                    href="https://<?php echo $this->config->item('branding')['domain']; ?>/whats_new.php"
                                                    class="menu-link px-5">
                                                    <span
                                                        class="menu-text"><?php echo lang('common_change_log'); ?></span>

                                                </a>
                                            </div>
                                            <!--end::Menu item-->





                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <atabindex="-1" id="switch_user"
                                                    href="<?php echo site_url('login/switch_user/'.($this->uri->segment(1) == 'sales' ? '0' : '1'));  ?>"
                                                    data-toggle="modal" data-target="#myModalDisableClose"
                                                    class="menu-link px-5">
                                                    <span
                                                        class="menu-text"><?php echo lang('common_switch_user'); ?></span>

                                                    </a>
                                            </div>
                                            <!--end::Menu item-->

                                            <?php if ($this->Employee->has_module_action_permission('employees','edit_profile',$this->Employee->get_logged_in_employee_info()->person_id)) {  ?>




                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a tabindex="-1" id="edit_profile"
                                                    href="<?php echo site_url('employees/edit_profile_model/'.($this->uri->segment(1) == 'sales' ? '0' : '1'));  ?>"
                                                    data-toggle="modal" data-target="#myModalDisableClose"
                                                    class="menu-link px-5">
                                                    <span
                                                        class="menu-text"><?php echo lang('common_edit_profile'); ?></span>

                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <?php } ?>


                                            <?php
								if ($this->config->item('timeclock')) 
								{
								?>


                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a href="#" class="menu-link px-5">
                                                    <span class="menu-text"><?php
										echo anchor("timeclocks",'<i class="ion-clock"></i>'.lang("employees_timeclock"), array('tabindex' => '-1'));
					 				?></span>

                                                </a>
                                            </div>
                                            <!--end::Menu item-->


                                            <?php
								}
								?>


                                            <div class="menu-item px-5">
                                                <?php
									if ($this->config->item('track_payment_types') && $this->Register->is_register_log_open()) {
										$continue = $this->config->item('timeclock') && !$this->Employee->get_logged_in_employee_info()->not_required_to_clock_in ? 'timeclocks' : 'logout';
										echo anchor("sales/closeregister?continue=$continue",'<span class="menu-link px-5">'.lang("common_logout").'</span>',array('class'=>'logout_button','tabindex' => '-1'));
									} else {
										
										if ($this->config->item('timeclock') && !$this->Employee->get_logged_in_employee_info()->not_required_to_clock_in && $this->Employee->is_clocked_in())
										{
											echo anchor("timeclocks",'<span class="menu-link px-5">'.lang("common_logout").'</span>',array('class'=>'logout_button','tabindex' => '-1'));
										}
										else
										{
											echo anchor("home/logout",'<span class="menu-link px-5">'.lang("common_logout").'</span>',array('class'=>'logout_button','tabindex' => '-1'));
										}
									}
									?>
                                            </div>








                                        </div>
                                        <!--end::User account menu-->
                                    </div>
                                    <!--end::Menu wrapper-->
                                    <!--begin::Info-->
                                    <div class="me-2">
                                        <!--begin::Username-->
                                        <a href="#"
                                            class="app-sidebar-username text-gray-800 text-hover-primary fs-6 fw-semibold lh-0"><?php echo H($user_info->first_name." ".$user_info->last_name); ?></a>
                                        <!--end::Username-->
                                        <!--begin::Description-->
                                        <span
                                            class="app-sidebar-deckription text-gray-400 fw-semibold d-block fs-8">Staff</span>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User avatar-->

                            </div>
                              */ ?>
                            <!--end::User-->
                        </div>
                        <!--end::Navbar-->
                    </div>
                    <!--end::Header wrapper-->
                </div>
            </div>
  			<!--end::Header-->

			  <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					<!--begin::sidebar-->
					<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle" data-select2-id="select2-data-kt_app_sidebar">
						<!--begin::Logo-->
						<div class="app-sidebar-logo d-none d-lg-flex flex-stack flex-shrink-0 px-8 bg-primary" id="kt_app_sidebar_logo">
							<!--begin::Logo image-->
							<a href="../dist/index.html" style="<?php echo isset($location_color) && $location_color ? 'background-color: '.$location_color.' !important': ''; ?>">
								
                            <?php if(!isset($is_pos)): ?>
								<?php echo img(
					array(
						'src' => base_url().$this->config->item('branding')['logo_path'],
						'class'=>'theme-light-show h-50px',
						'id'=>'header-logo',

					)); ?>
						<?php echo img(
					array(
						'src' => base_url().$this->config->item('branding')['logo_path'],
						'class'=>'theme-dark-show h-50px',
						'id'=>'header-logo',

					)); ?>

<?php endif; ?>
							</a>
							<!--end::Logo image-->
						
						</div>
						<!--end::Logo-->
                        

                  <?php if($this->uri->segment(1)!='sales'): ?>
                       <!--begin::Toolbar-->
						<div class="app-sidebar-toolbar d-flex flex-stack py-6 px-8">
							<!--begin::Select-->
							<select class="form-select form-select-custom fw-bold testselect" >
								
                            
                                <option><?php echo lang('select_location') ?></option>
                                <?php if (count($authenticated_locations) > 1) { ?>
                                <?php if(count($authenticated_locations) > 0 ): ?> 
                                            <?php foreach ($authenticated_locations as $key => $value) { ?>
                                                <option <?php if( $current_logged_in_location_id ==$key) { echo "selected"; } ?> value="<?php echo $key; ?>" data-a="<?php echo site_url('home/set_employee_current_location_id/'.$key) ?>"><?php echo $value; ?></option> 
                                                
                                                <?php	} ?>
                                                <!--end::Item-->
                                                <?php  endif; ?>

                                <?php } ?>
							</select>
							<!--end::Select-->
							<!--begin::Button-->
                            <?php
                            $params = $this->session->userdata('locations_search_data') ? $this->session->userdata('locations_search_data') : array('offset' => 0, 'order_col' => 'location_id', 'order_dir' => 'asc', 'search' => FALSE,'deleted' => 0);
                            $deleted = $params['deleted'];
                            
                             ?>
                             <?php if ($this->Employee->has_module_action_permission('locations', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id) && !$deleted) {?>				
					
							<a id="new_location_btn" href="<?php echo base_url('locations/view/-1/') ?>" class="btn btn-icon btn-custom fw-bold flex-shrink-0 ms-3" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">
								<!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
								<span class="svg-icon svg-icon-2qx">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
										<rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</a>
                            <?php } ?>
							<!--end::Button-->

                            <?php if (!is_on_demo_host()) { ?>
                                <script type="text/javascript">
                                $('#new_location_btn').click(function()
                                {
                                    bootbox.confirm({
                                        message: <?php echo json_encode(lang('locations_confirm_purchase')); ?>, 
                                        buttons: {
                                    confirm: {
                                        label: <?php echo json_encode(lang('common_yes')); ?>,
                                        className: 'btn-primary'
                                    },
                                    cancel: {
                                        label: <?php echo json_encode(lang('common_no')); ?>,
                                        className: 'btn-default'
                                    }
                                        },
                                        callback: function(result)
                                        {
                                            if (result)
                                            {
                                                window.location='http://<?php echo $this->config->item('branding')['domain']; ?>/buy_additional.php';
                                            }
                                            else
                                            {
                                                window.location = $("#new_location_btn").attr('href');
                                            }
                                        } 
                                    });
                                    
                                    return false;
                                })
                                </script>	
                            <?php } ?>	
						</div>
                                <?php endif; ?>

						<!--end::Toolbar-->
                        <?php if(!isset($is_pos)): ?>
                            <div class="separator d-none d-lg-block"></div>
                                <?php endif; ?>
						
					
						<!--begin::Sidebar menu-->
						<div class="app-sidebar-menu app-sidebar-menu-arrow hover-scroll-overlay-y my-5 my-lg-5 px-3" id="kt_app_sidebar_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_toolbar, #kt_app_sidebar_footer" data-kt-scroll-offset="0" style="height: 490px;">
							<!--begin::Menu-->
							<div class="menu menu-column menu-sub-indention menu-active-bg fw-semibold" id="#kt_sidebar_menu" data-kt-menu="true">
								<!--begin:Menu item-->

                                <?php if(!isset($is_pos)): ?>
                                    <div data-kt-menu-trigger="click" class="menu-item <?php echo $this->uri->segment(1)=='home' && $this->uri->segment(2)!='payvantage'  ? 'here show' : ''; ?>  menu-accordion">
								 <?php  else: ?>	
                                    
                                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"class="menu-item <?php echo $this->uri->segment(1)=='home' && $this->uri->segment(2)!='payvantage'  ? 'here show' : ''; ?>  ">
                                <?php endif; ?>

								



									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/graphs/gra010.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.0021 10.9128V3.01281C13.0021 2.41281 13.5021 1.91281 14.1021 2.01281C16.1021 2.21281 17.9021 3.11284 19.3021 4.61284C20.7021 6.01284 21.6021 7.91285 21.9021 9.81285C22.0021 10.4129 21.5021 10.9128 20.9021 10.9128H13.0021Z" fill="currentColor"/>
                                                    <path opacity="0.3" d="M11.0021 13.7128V4.91283C11.0021 4.31283 10.5021 3.81283 9.90208 3.91283C5.40208 4.51283 1.90209 8.41284 2.00209 13.1128C2.10209 18.0128 6.40208 22.0128 11.3021 21.9128C13.1021 21.8128 14.7021 21.3128 16.0021 20.4128C16.5021 20.1128 16.6021 19.3128 16.1021 18.9128L11.0021 13.7128Z" fill="currentColor"/>
                                                    <path opacity="0.3" d="M21.9021 14.0128C21.7021 15.6128 21.1021 17.1128 20.1021 18.4128C19.7021 18.9128 19.0021 18.9128 18.6021 18.5128L13.0021 12.9128H20.9021C21.5021 12.9128 22.0021 13.4128 21.9021 14.0128Z" fill="currentColor"/>
                                                </svg>
                                                </span>
                                            <!--end::Svg Icon-->
										</span>

                                        <?php if(!isset($is_pos)): ?>
										<span class="menu-title"><?php echo lang('dashboard'); ?></span>
										<span class="menu-arrow"></span>
                                        <?php endif; ?>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
                                    <?php if(!isset($is_pos)): ?>
                                        <div class="menu-sub menu-sub-accordion">
                                    <?php  else: ?>
                                        <div class="menu-sub menu-sub-dropdown px-lg-2 py-lg-4 w-200px w-lg-225pxn">
                                <?php endif; ?>
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link <?php echo $this->uri->segment(1)=='home'&& $this->uri->segment(2)!='work_order_dashboard' && $this->uri->segment(2)!='payvantage'  ? 'active' : ''; ?>" href="<?php echo site_url('home'); ?>">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title"><?php echo lang('dashboard'); ?></span>
											</a>
											<!--end:Menu link-->
										</div>

                                        <div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link <?php echo $this->uri->segment(1)=='home' && $this->uri->segment(2)=='work_order_dashboard'  && $this->uri->segment(2)!='payvantage'  ? 'active' : ''; ?>" href="<?php echo site_url('home'); ?>/work_order_dashboard">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title"><?php echo lang('work_order_dashboard'); ?></span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->

										<?php
											if ($this->config->item('payvantage'))
											{?>
												

												<div class="menu-item">
																		<!--begin:Menu link-->
																		<a class="menu-link <?php echo $this->uri->segment(2)=='payvantage'  ? 'active' : ''; ?>" href="<?php echo site_url('home/payvantage'); ?>">
																			<span class="menu-bullet">
																				<span class="bullet bullet-dot"></span>
																			</span>
																			<span class="menu-title">PayVantage</span>
																		</a>
																		<!--end:Menu link-->
																	</div>
											<?php
											}
											?>


									
									
									</div>
									<!--end:Menu sub-->
								</div>



                                <div class="menu-item pt-5">
                                    <div class="menu-content">
                                        <span class="text-uppercase fw-bold menu-heading fs-7">
                                            <strong><?php echo lang('quick_access')?></strong>
                                        </span>
                                        <span class="fw-bold menu-heading fs-7" style="color: var(--bs-app-light-sidebar-logo-icon-custom-color);font-family: Inter, sans-serif;font-style: italic;font-weight: bold;" onclick="show_quick_access()">&nbsp; &nbsp;<?php echo lang('edit')?></span>
                                    </div>
                                </div>

                                    <?php 
                                    
                                            if(get_quick_access()):
                                                $quick_access = get_quick_access();
                                    ?>

                                    <?php if($this->Employee->has_module_permission('sales', $employee_id) && in_array('pos' ,$quick_access )) { ?>
                                        <div class="menu-item" <?php echo array_search('sales', $disable_modules) === false ? '': 'style="display: none;"' ?>>
                                            <a class="menu-link  <?= ($this->uri->segment(1) == 'sales') ?  'active': '' ?>" href="<?php echo site_url('sales'); ?>">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/art/art006.svg-->
                                                    <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M22 19V17C22 16.4 21.6 16 21 16H8V3C8 2.4 7.6 2 7 2H5C4.4 2 4 2.4 4 3V19C4 19.6 4.4 20 5 20H21C21.6 20 22 19.6 22 19Z" fill="currentColor"/>
                                                        <path d="M20 5V21C20 21.6 19.6 22 19 22H17C16.4 22 16 21.6 16 21V8H8V4H19C19.6 4 20 4.4 20 5ZM3 8H4V4H3C2.4 4 2 4.4 2 5V7C2 7.6 2.4 8 3 8Z" fill="currentColor"/>
                                                    </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <?php if(!isset($is_pos)): ?>
                                                <span class="menu-title"><?php echo lang('pos')?></span>
                                                <?php endif; ?>
                                            </a>
                                        </div>

                                    <?php } ?>


                                    <?php if ($this->Employee->has_module_permission('items', $this->Employee->get_logged_in_employee_info()->person_id) && in_array('items' ,$quick_access )) { ?>
                                    <div class="menu-item" >
                                        <a class="menu-link  <?= ($this->uri->segment(1) == 'items') ?  'active': '' ?>" href="<?php echo site_url('items'); ?>">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/general/gen002.svg-->
                                                    <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M4.05424 15.1982C8.34524 7.76818 13.5782 3.26318 20.9282 2.01418C21.0729 1.98837 21.2216 1.99789 21.3618 2.04193C21.502 2.08597 21.6294 2.16323 21.7333 2.26712C21.8372 2.37101 21.9144 2.49846 21.9585 2.63863C22.0025 2.7788 22.012 2.92754 21.9862 3.07218C20.7372 10.4222 16.2322 15.6552 8.80224 19.9462L4.05424 15.1982ZM3.81924 17.3372L2.63324 20.4482C2.58427 20.5765 2.5735 20.7163 2.6022 20.8507C2.63091 20.9851 2.69788 21.1082 2.79503 21.2054C2.89218 21.3025 3.01536 21.3695 3.14972 21.3982C3.28408 21.4269 3.42387 21.4161 3.55224 21.3672L6.66524 20.1802L3.81924 17.3372ZM16.5002 5.99818C16.2036 5.99818 15.9136 6.08615 15.6669 6.25097C15.4202 6.41579 15.228 6.65006 15.1144 6.92415C15.0009 7.19824 14.9712 7.49984 15.0291 7.79081C15.0869 8.08178 15.2298 8.34906 15.4396 8.55884C15.6494 8.76862 15.9166 8.91148 16.2076 8.96935C16.4986 9.02723 16.8002 8.99753 17.0743 8.884C17.3484 8.77046 17.5826 8.5782 17.7474 8.33153C17.9123 8.08486 18.0002 7.79485 18.0002 7.49818C18.0002 7.10035 17.8422 6.71882 17.5609 6.43752C17.2796 6.15621 16.8981 5.99818 16.5002 5.99818Z" fill="currentColor"/>
                                                        <path d="M4.05423 15.1982L2.24723 13.3912C2.15505 13.299 2.08547 13.1867 2.04395 13.0632C2.00243 12.9396 1.9901 12.8081 2.00793 12.679C2.02575 12.5498 2.07325 12.4266 2.14669 12.3189C2.22013 12.2112 2.31752 12.1219 2.43123 12.0582L9.15323 8.28918C7.17353 10.3717 5.4607 12.6926 4.05423 15.1982ZM8.80023 19.9442L10.6072 21.7512C10.6994 21.8434 10.8117 21.9129 10.9352 21.9545C11.0588 21.996 11.1903 22.0083 11.3195 21.9905C11.4486 21.9727 11.5718 21.9252 11.6795 21.8517C11.7872 21.7783 11.8765 21.6809 11.9402 21.5672L15.7092 14.8442C13.6269 16.8245 11.3061 18.5377 8.80023 19.9442ZM7.04023 18.1832L12.5832 12.6402C12.7381 12.4759 12.8228 12.2577 12.8195 12.032C12.8161 11.8063 12.725 11.5907 12.5653 11.4311C12.4057 11.2714 12.1901 11.1803 11.9644 11.1769C11.7387 11.1736 11.5205 11.2583 11.3562 11.4132L5.81323 16.9562L7.04023 18.1832Z" fill="currentColor"/>
                                                        </svg>
                                                    </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <?php if(!isset($is_pos)): ?>
                                            <span class="menu-title"><?php echo lang("module_items"); ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </div>

                                <?php } ?>

                                <?php if($this->Employee->has_module_permission('receivings', $employee_id) && in_array('receivings' ,$quick_access )) { ?>
                                    <div class="menu-item" >
                                        <a class="menu-link  <?= ($this->uri->segment(1) == 'receivings' && $this->uri->segment(2) != 'transfer') ?  'active': '' ?>" href="<?php echo site_url('receivings'); ?>">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/abstract/abs027.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor"/>
                                                    <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <?php if(!isset($is_pos)): ?>
                                            <span class="menu-title"><?php echo lang("common_receiving"); ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </div>

                                <?php } ?>

                                <?php if(check_allowed_module($allowed_modules->result() ,'customers' )  && in_array('customers' ,$quick_access )): ?>
                                       <!--begin:Menu item-->
                                       <?php if(module_access_check_view('invoices')){ ?>
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'customers') ?  'active': '' ?> " href="<?php echo site_url('customers'); ?>">
                                                <span class="menu-icon">
                                               <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/communication/com013.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>
                                                <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
                                                </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <?php if(!isset($is_pos)): ?>
                                                    <span class="menu-title"><?php echo lang('customers')?></span>
                                                    <?php endif; ?>
                                                </a>
                                            </div>

                                        <?php } ?>
								
                                       <?php endif; ?>


                                    <?php endif; ?>



                               

                                
                                <div class="menu-item pt-5">
                                    <div class="menu-content">
                                        <span class="text-uppercase fw-bold menu-heading fs-7">
                                            <strong>APPS</strong>
                                        </span>
                                     </div>
                                </div>

                                <?php if(!$this->Employee->has_module_permission('sales', $employee_id)  &&   !check_allowed_module($allowed_modules->result() ,'invoices' ) &&  !check_allowed_module($allowed_modules->result() ,'customers' ) ) { /** below menud will not be shown as no permisson **/  }else{ ?>


                                <?php if(!isset($is_pos)): ?>
                                <div data-kt-menu-trigger="click" class="menu-item <?php echo ($this->uri->segment(1)=='sales' ||   $this->uri->segment(1)=='customers' || ($this->uri->segment(1)=='invoices' && $this->uri->segment(3)=='customer'  )  )? 'here show' : ''; ?>  menu-accordion">
								 <?php  else: ?>	
                                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" class="menu-item <?php echo ($this->uri->segment(1)=='sales' ||   $this->uri->segment(1)=='customers' ||   ($this->uri->segment(1)=='invoices' && $this->uri->segment(3)=='customer'  )  )? 'here show' : ''; ?>  ">
							
                                <?php endif; ?>
                                <!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/ecommerce/ecm001.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M18.041 22.041C18.5932 22.041 19.041 21.5932 19.041 21.041C19.041 20.4887 18.5932 20.041 18.041 20.041C17.4887 20.041 17.041 20.4887 17.041 21.041C17.041 21.5932 17.4887 22.041 18.041 22.041Z" fill="currentColor"/>
                                                    <path opacity="0.3" d="M6.04095 22.041C6.59324 22.041 7.04095 21.5932 7.04095 21.041C7.04095 20.4887 6.59324 20.041 6.04095 20.041C5.48867 20.041 5.04095 20.4887 5.04095 21.041C5.04095 21.5932 5.48867 22.041 6.04095 22.041Z" fill="currentColor"/>
                                                    <path opacity="0.3" d="M7.04095 16.041L19.1409 15.1409C19.7409 15.1409 20.141 14.7409 20.341 14.1409L21.7409 8.34094C21.9409 7.64094 21.4409 7.04095 20.7409 7.04095H5.44095L7.04095 16.041Z" fill="currentColor"/>
                                                    <path d="M19.041 20.041H5.04096C4.74096 20.041 4.34095 19.841 4.14095 19.541C3.94095 19.241 3.94095 18.841 4.14095 18.541L6.04096 14.841L4.14095 4.64095L2.54096 3.84096C2.04096 3.64096 1.84095 3.04097 2.14095 2.54097C2.34095 2.04097 2.94096 1.84095 3.44096 2.14095L5.44096 3.14095C5.74096 3.24095 5.94096 3.54096 5.94096 3.84096L7.94096 14.841C7.94096 15.041 7.94095 15.241 7.84095 15.441L6.54096 18.041H19.041C19.641 18.041 20.041 18.441 20.041 19.041C20.041 19.641 19.641 20.041 19.041 20.041Z" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
										</span>
                                        <?php if(!isset($is_pos)): ?>
										<span class="menu-title"><?php echo lang("common_sell"); ?></span>
                                        <span class="menu-arrow"></span>
                                        <?php endif; ?>
										
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
                                  
                                    <?php if(!isset($is_pos)): ?>
									<div class="menu-sub menu-sub-accordion">
                                    <?php  else: ?>	
                                        <div class="  menu-sub menu-sub-dropdown px-lg-2 py-lg-4 w-200px w-lg-225px">
                                    <?php endif; ?>
										<!--begin:Menu item-->
                                        <?php if($this->Employee->has_module_permission('sales', $employee_id)) { ?>
                                            <div class="menu-item" <?php echo array_search('sales', $disable_modules) === false ? '': 'style="display: none;"' ?>>
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'sales') ?  'active': '' ?>" href="<?php echo site_url('sales'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">POS</span>
                                                </a>
                                            </div>

                                        <?php } ?>


                                        <?php if(check_allowed_module($allowed_modules->result() ,'invoices' )): ?>
                                       <!--begin:Menu item-->
                                       <?php if(module_access_check_view('invoices')){ ?>
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(3) == 'customer') ?  'active': '' ?> " href="<?php echo site_url('invoices/index/customer'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('common_sales_invoice')?></span>
                                                </a>
                                            </div>

                                        <?php } ?>

                                        <?php endif; ?>

                                        <?php if(check_allowed_module($allowed_modules->result() ,'customers' )): ?>
                                       <!--begin:Menu item-->
                                       <?php if(module_access_check_view('invoices')){ ?>
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'customers') ?  'active': '' ?> " href="<?php echo site_url('customers'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('reports_customers')?></span>
                                                </a>
                                            </div>

                                        <?php } ?>
								
                                       <?php endif; ?>
									
									</div>
									<!--end:Menu sub-->


                                   
								</div>


                                <?php } ?>



                                    <?php if(!check_allowed_module($allowed_modules->result() ,'work_orders' ) && !check_allowed_module($allowed_modules->result() ,'deliveries' ) && !check_allowed_module($allowed_modules->result() ,'appointments')    ){  }else{ ?>
                            
                                <?php if(!isset($is_pos)): ?>
                                    <div data-kt-menu-trigger="click" class="menu-item <?php echo ($this->uri->segment(1) == 'work_orders' || $this->uri->segment(1) == 'deliveries' || $this->uri->segment(1) == 'appointments' )  ? 'here show' : ''; ?>  menu-accordion">
								
                                    <?php  else: ?>
                                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" class="menu-item <?php echo ($this->uri->segment(3) == 'work_orders' || $this->uri->segment(1) == 'deliveries' || $this->uri->segment(1) == 'appointments' )  ? 'here show' : ''; ?>  menu-accordion">
								
                                <?php endif; ?>
                               	<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/ecommerce/ecm008.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="currentColor"/>
                                                    <path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="currentColor"/>
                                                    <path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="currentColor"/>
                                                </svg>
                                                </span>
                                            <!--end::Svg Icon-->
										</span>
                                        <?php if(!isset($is_pos)): ?>
                                            <span class="menu-title"><?php echo lang('common_work'); ?></span>
                                            <span class="menu-arrow"></span>
                                <?php endif; ?>
										
										
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
                                    <?php if(!isset($is_pos)): ?>
                                        <div class="menu-sub menu-sub-accordion">
                                    <?php  else: ?>
                                        <div class="menu-sub menu-sub-dropdown px-lg-2 py-lg-4 w-200px w-lg-225pxn">
                                <?php endif; ?>
									
                                    <?php if(check_allowed_module($allowed_modules->result() ,'work_orders' )): ?>
                                        <?php if($this->Employee->has_module_permission('work_orders', $employee_id)) { ?>
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'work_orders') ?  'active': '' ?> " href="<?php echo site_url('work_orders'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('common_workorder')?></span>
                                                </a>
                                            </div>

                                        <?php } ?>
                                        <?php endif; ?>
                                        <?php if(check_allowed_module($allowed_modules->result() ,'deliveries' )): ?>
                                        <?php if($this->Employee->has_module_permission('deliveries', $employee_id)) { ?>
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'deliveries') ?  'active': '' ?> " href="<?php echo site_url('deliveries'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('module_deliveries')?></span>
                                                </a>
                                            </div>

                                        <?php } ?>
                                        <?php endif; ?>

                                        <?php if(check_allowed_module($allowed_modules->result() ,'appointments' )): ?>
                                        <?php if($this->Employee->has_module_permission('appointments', $employee_id)) { ?>
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'appointments') ?  'active': '' ?> " href="<?php echo site_url('appointments'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('module_appointments')?></span>
                                                </a>
                                            </div>

                                        <?php } ?>
                                        <?php endif; ?>

                                        


									
									
									</div>
									<!--end:Menu sub-->
								</div>
                                <?php } ?>

                                        <?php if(!check_allowed_module($allowed_modules->result() ,'receivings' ) && !check_allowed_module($allowed_modules->result() ,'invoices' ) && !check_allowed_module($allowed_modules->result() ,'suppliers' )){}else{ ?>

                                <?php if(!isset($is_pos)): ?>
                                    <div data-kt-menu-trigger="click" class="menu-item <?php  echo  (($this->uri->segment(1) == 'receivings' &&  $this->uri->segment(2) != 'transfer')|| $this->uri->segment(3) == 'suppliers' || $this->uri->segment(1) == 'suppliers' || $this->uri->segment(2) == 'suspended')   ? 'here show' : ''; ?>  menu-accordion">
								
                                    <?php  else: ?>
                                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" class="menu-item <?php echo ($this->uri->segment(1) == 'receivings' || $this->uri->segment(3) == 'suppliers' || $this->uri->segment(1) == 'suppliers' || $this->uri->segment(2) == 'suspended')  ? 'here show' : ''; ?> ">
								
                                <?php endif; ?>
                               	<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/ecommerce/ecm008.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="currentColor"/>
                                                    <path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="currentColor"/>
                                                    <path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="currentColor"/>
                                                </svg>
                                                </span>
                                            <!--end::Svg Icon-->
										</span>
                                        <?php if(!isset($is_pos)): ?>
                                            <span class="menu-title"><?php echo lang('common_buy'); ?></span>
                                            <span class="menu-arrow"></span>
                                <?php endif; ?>
										
										
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
                                    <?php if(!isset($is_pos)): ?>
                                        <div class="menu-sub menu-sub-accordion">
                                    <?php  else: ?>
                                        <div class="menu-sub menu-sub-dropdown px-lg-2 py-lg-4 w-200px w-lg-225px">
                                <?php endif; ?>
									
                                 
                                       

                                    <?php if(check_allowed_module($allowed_modules->result() ,'receivings' )): ?>
                                        <?php if($this->Employee->has_module_permission('receivings', $employee_id)) { ?>
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'receivings' && $this->uri->segment(2) != 'transfer') ?  'active': '' ?> " href="<?php echo site_url('receivings'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('common_receiving')?></span>
                                                </a>
                                            </div>

                                        <?php } ?>
                                    <?php endif; ?>


                                    <?php if(check_allowed_module($allowed_modules->result() ,'invoices' )): ?>
                                        <?php if($this->Employee->has_module_permission('invoices', $employee_id)) { ?>
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(3) == 'suppliers') ?  'active': '' ?> " href="<?php echo site_url('invoices/index/supplier'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('common_purchase_invoice')?></span>
                                                </a>
                                            </div>

                                        <?php } ?>

                                        <?php if($this->config->item('use_saudi_tax_config')){ 
							$location_id = $this->Employee->get_logged_in_employee_current_location_id();
							$location_zatca_config = $this->Appconfig->get_zatca_config($location_id);
							if($location_zatca_config){
						?>
                         <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(3) == 'suppliers') ?  'active': '' ?> " href="<?php echo site_url('invoices/zatca_invoice'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('ZATCA')?></span>
                                                </a>
                                            </div>
							
						<?php 
							}
						} 
						?>


                                    <?php endif; ?>

                                
                                    <?php if(check_allowed_module($allowed_modules->result() ,'suppliers' )): ?>
                                        <?php if($this->Employee->has_module_permission('suppliers', $employee_id)) { ?>
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'suppliers') ?  'active': '' ?> " href="<?php echo site_url('suppliers'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('module_suppliers')?></span>
                                                </a>
                                            </div>

                                        <?php } ?>
                                    <?php endif; ?>




                                    <?php if(check_allowed_module($allowed_modules->result() ,'receivings' )): ?>
                                        <?php if($this->Employee->has_module_permission('receivings', $employee_id)) { ?>
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(2) == 'suspended') ?  'active': '' ?> " href="<?php echo site_url('receivings/suspended'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('common_suspended_receiving')?></span>
                                                </a>
                                            </div>

                                        <?php } ?>
                                    <?php endif; ?>




                               
									
									
									</div>
									<!--end:Menu sub-->
								</div>
                                <?php } ?>


                                    <?php if(!check_allowed_module($allowed_modules->result() ,'items' ) &&  !check_allowed_module($allowed_modules->result() ,'item_kits' ) && !$this->Employee->has_module_permission('items', $this->Employee->get_logged_in_employee_info()->person_id) && !$this->Employee->has_module_action_permission('items', 'manage_tags', $this->Employee->get_logged_in_employee_info()->person_id) && !$this->Employee->has_module_action_permission('items', 'manage_manufacturers', $this->Employee->get_logged_in_employee_info()->person_id)  && !check_allowed_module($allowed_modules->result() ,'receivings' )){ }else{ ?>

                                <?php if(!isset($is_pos)): ?>
                                    <div data-kt-menu-trigger="click" class="menu-item <?php echo ($this->uri->segment(1) == 'items' || $this->uri->segment(1) == 'item_kits' || $this->uri->segment(2) == 'manage_categories' || $this->uri->segment(2) == 'manage_modifiers' ||$this->uri->segment(2) == 'manage_tags'  || $this->uri->segment(2) == 'manage_attributes' || $this->uri->segment(2) == 'manage_manufacturers' || $this->uri->segment(2) == 'transfer')  ? 'here show' : ''; ?>  menu-accordion">
								
                                    <?php  else: ?>
                                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" class="menu-item <?php ($this->uri->segment(1) == 'items' || $this->uri->segment(1) == 'item_kits' || $this->uri->segment(2) == 'manage_categories' || $this->uri->segment(2) == 'manage_modifiers' ||$this->uri->segment(2) == 'manage_tags'  || $this->uri->segment(2) == 'manage_attributes' || $this->uri->segment(2) == 'manage_manufacturers' || $this->uri->segment(2) == 'transfer') ? 'here show' : ''; ?>  menu-accordion">
								
                                <?php endif; ?>
                               	<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/ecommerce/ecm008.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="currentColor"/>
                                                    <path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="currentColor"/>
                                                    <path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="currentColor"/>
                                                </svg>
                                                </span>
                                            <!--end::Svg Icon-->
										</span>
                                        <?php if(!isset($is_pos)): ?>
                                            <span class="menu-title"><?php echo lang('common_stock'); ?></span>
                                            <span class="menu-arrow"></span>
                                        <?php endif; ?>
										
										
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
                                    <?php if(!isset($is_pos)): ?>
                                        <div class="menu-sub menu-sub-accordion">
                                    <?php  else: ?>
                                        <div class="menu-sub menu-sub-dropdown px-lg-2 py-lg-4 w-200px w-lg-225px">
                                <?php endif; ?>
									
                                    <?php if(check_allowed_module($allowed_modules->result() ,'items' )): ?>
                                    <?php if ($this->Employee->has_module_permission('items', $this->Employee->get_logged_in_employee_info()->person_id)): ?>
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'items' && $this->uri->segment(2) != 'manage_categories' && $this->uri->segment(2) != 'manage_modifiers'  && $this->uri->segment(2) != 'manage_tags' && $this->uri->segment(2) != 'manage_attributes'  && $this->uri->segment(2) != 'manage_manufacturers') ?  'active': '' ?> " href="<?php echo site_url('items'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('module_items')?></span>
                                                </a>
                                            </div>

                                    <?php endif; ?>
                                    <?php endif; ?>


                                    <?php if(check_allowed_module($allowed_modules->result() ,'item_kits' )): ?>
                                    <?php if ($this->Employee->has_module_permission('item_kits', $this->Employee->get_logged_in_employee_info()->person_id)): ?>
                                       
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'item_kits') ?  'active': '' ?> " href="<?php echo site_url('item_kits'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('common_product_bundles')?></span>
                                                </a>
                                            </div>

                                    <?php endif; ?>
                                    <?php endif; ?>


                                    <?php if(check_allowed_module($allowed_modules->result() ,'items' )): ?>
                                    <?php if ($this->Employee->has_module_action_permission('items', 'manage_categories', $this->Employee->get_logged_in_employee_info()->person_id)): ?>
							
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(2) == 'manage_categories') ?  'active': '' ?> " href="<?php echo site_url('items/manage_categories'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('reports_categories')?></span>
                                                </a>
                                            </div>

                                    <?php endif; ?>
                                    <?php endif; ?>


                                    <div data-kt-menu-trigger="click" class="menu-item <?php echo ( $this->uri->segment(2) == 'manage_categories' || $this->uri->segment(2) == 'manage_modifiers' ||$this->uri->segment(2) == 'manage_tags'  || $this->uri->segment(2) == 'manage_attributes' || $this->uri->segment(2) == 'manage_manufacturers' )  ? 'hover show' : ''; ?>  menu-accordion"><span class="menu-link"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title"><?php echo lang('common_texonomy')?></span><span class="menu-arrow"></span></span>
                                        
                                    
                                    <div class="menu-sub menu-sub-accordion" style="<?php echo ( $this->uri->segment(2) == 'manage_categories' || $this->uri->segment(2) == 'manage_modifiers' ||$this->uri->segment(2) == 'manage_tags'  || $this->uri->segment(2) == 'manage_attributes' || $this->uri->segment(2) == 'manage_manufacturers' )  ? '' : 'display:none'; ?>  overflow: hidden;" kt-hidden-height="392">


                                            <?php if ($this->Employee->has_module_permission('items', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                            
                                                <div class="menu-item">
                                                    <a class="menu-link <?= ($this->uri->segment(2) == 'manage_modifiers') ?  'active': '' ?>" href="<?php echo site_url('items/manage_modifiers'); ?>">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title"><?php echo lang("common_modifiers"); ?></span>
                                                    </a>
                                                </div>


                                            <?php } ?>


                                            <?php if ($this->Employee->has_module_action_permission('items', 'manage_tags', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                                            
                                            <div class="menu-item">
                                                <a class="menu-link <?= ($this->uri->segment(2) == 'manage_tags') ?  'active': '' ?>" href="<?php echo site_url('items/manage_tags'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang("common_tags"); ?></span>
                                                </a>
                                            </div>


                                        <?php } ?>

                                        <?php if ($this->Employee->has_module_permission('items', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                            
                                            <div class="menu-item">
                                                <a class="menu-link <?= ($this->uri->segment(2) == 'manage_attributes') ?  'active': '' ?>" href="<?php echo site_url('items/manage_attributes'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang("common_attributes"); ?></span>
                                                </a>
                                            </div>


                                        <?php } ?>

                                        <?php if ($this->Employee->has_module_action_permission('items', 'manage_manufacturers', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
							
                                        <!--begin:Menu item-->
                            
                                        <div class="menu-item" >
                                            <a class="menu-link  <?= ($this->uri->segment(2) == 'manage_manufacturers') ?  'active': '' ?> " href="<?php echo site_url('items/manage_manufacturers'); ?>">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title"><?php echo lang('reports_manufacturers')?></span>
                                            </a>
                                        </div>

                                    <?php } ?>


                                        </div>
                                    </div>




                                    <?php if(check_allowed_module($allowed_modules->result() ,'receivings' )): ?>
                                        <?php if($this->Employee->has_module_permission('receivings', $employee_id)): ?>
							
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(2) == 'transfer') ?  'active': '' ?> " href="<?php echo site_url('receivings/transfer'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('common_transfer')?></span>
                                                </a>
                                            </div>

                                    <?php endif; ?>
                                    <?php endif; ?>

                                    
									
									
									</div>
									<!--end:Menu sub-->
								</div>
                                <?php } ?>


                                            <?php if(!check_allowed_module($allowed_modules->result() ,'giftcards' ) &&  
                                            !check_allowed_module($allowed_modules->result() ,'price_rules' )){}else{ ?>

                                <?php if(!isset($is_pos)): ?>
                                    <div data-kt-menu-trigger="click" class="menu-item <?php echo ($this->uri->segment(1) == 'giftcards' || $this->uri->segment(1) == 'price_rules')  ? 'here show' : ''; ?>  menu-accordion">
							
                                    <?php  else: ?>
                                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" class="menu-item <?php echo ($this->uri->segment(1) == 'giftcards' || $this->uri->segment(1) == 'price_rules' )  ? 'here show' : ''; ?>  menu-accordion">
							
                                <?php endif; ?>

                             		<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/ecommerce/ecm008.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="currentColor"/>
                                                    <path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="currentColor"/>
                                                    <path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="currentColor"/>
                                                </svg>
                                                </span>
                                            <!--end::Svg Icon-->
										</span>
                                        <?php if(!isset($is_pos)): ?>
                                    	<span class="menu-title"><?php echo lang('common_promote'); ?></span>
                                        <span class="menu-arrow"></span>
                                        <?php endif; ?>
									
										
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									
                                 
                                    <?php if(!isset($is_pos)): ?>
                                        <div class="menu-sub menu-sub-accordion">
                                    <?php  else: ?>
                                        <div class="menu-sub menu-sub-dropdown px-lg-2 py-lg-4 w-200px w-lg-225px">
                                <?php endif; ?>

                                    <?php if(check_allowed_module($allowed_modules->result() ,'giftcards' )): ?>
                                        <?php if($this->Employee->has_module_permission('giftcards', $employee_id)) { ?>
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'giftcards') ?  'active': '' ?> " href="<?php echo site_url('giftcards'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('module_giftcards')?></span>
                                                </a>
                                            </div>

                                        <?php } ?>
                                    <?php endif; ?>



                                    <?php if(check_allowed_module($allowed_modules->result() ,'price_rules' )): ?>
                                        <?php if($this->Employee->has_module_permission('price_rules', $employee_id)) { ?>
                                            <!--begin:Menu item-->
                                  
                                            <div class="menu-item" >
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'price_rules') ?  'active': '' ?> " href="<?php echo site_url('price_rules'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('module_price_rules')?></span>
                                                </a>
                                            </div>

                                        <?php } ?>
                                    <?php endif; ?>


                                    <div class="menu-item "  <?php echo array_search('items', $disable_modules) === false ? '': 'style="display: none;"' ?>>
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'price_rules') ?  'active': '' ?> " href="<?php echo site_url('items/price_check'); ?>">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title"><?php echo lang('common_price_check')?></span>
                                                </a>
                                            </div>



                                 
										


                               
									
									
									</div>
									<!--end:Menu sub-->
								</div>

                                <?php } ?>

                                
                                <div class="menu-item pt-5">
                                    <div class="menu-content">
                                        <span class="text-uppercase fw-bold menu-heading fs-7">
                                            <strong>Admin</strong>
                                        </span>
                                    </div>
                                </div>
                                <?php if(check_allowed_module($allowed_modules->result() ,'expenses' )): ?>
                                <?php if($this->Employee->has_module_permission('expenses', $employee_id)) { ?>
                                    <div class="menu-item" <?php echo array_search('expenses', $disable_modules) === false ? '': 'style="display: none;"' ?>>
                                        <a class="menu-link  <?= ($this->uri->segment(1) == 'expenses') ?  'active': '' ?>" href="<?php echo site_url('expenses'); ?>">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/finance/fin007.svg-->
                                                    <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M3 3V17H7V21H15V9H20V3H3Z" fill="currentColor"/>
                                                    <path d="M20 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H20C20.6 2 21 2.4 21 3V21C21 21.6 20.6 22 20 22ZM19 4H4V8H19V4ZM6 18H4V20H6V18ZM6 14H4V16H6V14ZM6 10H4V12H6V10ZM10 18H8V20H10V18ZM10 14H8V16H10V14ZM10 10H8V12H10V10ZM14 18H12V20H14V18ZM14 14H12V16H14V14ZM14 10H12V12H14V10ZM19 14H17V20H19V14ZM19 10H17V12H19V10Z" fill="currentColor"/>
                                                    </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                            </span>
                                            <?php if(!isset($is_pos)): ?>
                                                <span class="menu-title"><?php echo lang('module_expenses')?></span>
                                <?php endif; ?>
                                           
                                        </a>
                                    </div>

                                <?php } ?> 
                                <?php endif; ?>

                                <?php if(check_allowed_module($allowed_modules->result() ,'reports' )): ?>
                                <?php if($this->Employee->has_module_permission('reports', $employee_id)) { ?>
                                    <div class="menu-item" <?php echo array_search('reports', $disable_modules) === false ? '': 'style="display: none;"' ?>>
                                        <a class="menu-link  <?= ($this->uri->segment(1) == 'reports') ?  'active': '' ?>" href="<?php echo site_url('reports'); ?>">
                                            <span class="menu-icon">
                                               <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/general/gen005.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="currentColor"/>
                                                <rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor"/>
                                                <rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor"/>
                                                <rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor"/>
                                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"/>
                                                </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            
                                            <?php if(!isset($is_pos)): ?>
                                                <span class="menu-title"><?php echo lang('module_reports')?></span>
                                            <?php endif; ?>
                                        </a>
                                    </div>

                                <?php } ?> 
                                <?php endif; ?>


                                <?php if(check_allowed_module($allowed_modules->result() ,'employees' )): ?>
                                <?php if($this->Employee->has_module_permission('employees', $employee_id)) { ?>
                                    <div class="menu-item" <?php echo array_search('employees', $disable_modules) === false ? '': 'style="display: none;"' ?>>
                                        <a class="menu-link  <?= ($this->uri->segment(1) == 'employees') ?  'active': '' ?>" href="<?php echo site_url('employees'); ?>">
                                            <span class="menu-icon">
                                              <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/communication/com013.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>
                                                <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
                                                </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <?php if(!isset($is_pos)): ?>
                                                <span class="menu-title"><?php echo lang('module_employees')?></span>
                                            <?php endif; ?>
                                        </a>
                                    </div>

                                <?php } ?> 
                                <?php endif; ?>

                                <?php if(check_allowed_module($allowed_modules->result() ,'locations' )): ?>
                                <?php if($this->Employee->has_module_permission('locations', $employee_id)) { ?>
                                    <div class="menu-item" <?php echo array_search('locations', $disable_modules) === false ? '': 'style="display: none;"' ?>>
                                        <a class="menu-link  <?= ($this->uri->segment(1) == 'locations') ?  'active': '' ?>" href="<?php echo site_url('locations'); ?>">
                                            <span class="menu-icon">
                                              <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/maps/map004.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M18.4 5.59998C21.9 9.09998 21.9 14.8 18.4 18.3C14.9 21.8 9.2 21.8 5.7 18.3L18.4 5.59998Z" fill="currentColor"/>
                                                <path d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM19.9 11H13V8.8999C14.9 8.6999 16.7 8.00005 18.1 6.80005C19.1 8.00005 19.7 9.4 19.9 11ZM11 19.8999C9.7 19.6999 8.39999 19.2 7.39999 18.5C8.49999 17.7 9.7 17.2001 11 17.1001V19.8999ZM5.89999 6.90002C7.39999 8.10002 9.2 8.8 11 9V11.1001H4.10001C4.30001 9.4001 4.89999 8.00002 5.89999 6.90002ZM7.39999 5.5C8.49999 4.7 9.7 4.19998 11 4.09998V7C9.7 6.8 8.39999 6.3 7.39999 5.5ZM13 17.1001C14.3 17.3001 15.6 17.8 16.6 18.5C15.5 19.3 14.3 19.7999 13 19.8999V17.1001ZM13 4.09998C14.3 4.29998 15.6 4.8 16.6 5.5C15.5 6.3 14.3 6.80002 13 6.90002V4.09998ZM4.10001 13H11V15.1001C9.1 15.3001 7.29999 16 5.89999 17.2C4.89999 16 4.30001 14.6 4.10001 13ZM18.1 17.1001C16.6 15.9001 14.8 15.2 13 15V12.8999H19.9C19.7 14.5999 19.1 16.0001 18.1 17.1001Z" fill="currentColor"/>
                                                </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <?php if(!isset($is_pos)): ?>
                                                <span class="menu-title"><?php echo lang('module_locations')?></span>
                                            <?php endif; ?>
                                        </a>
                                    </div>

                                <?php } ?> 
                                <?php endif; ?>


                                <?php if(check_allowed_module($allowed_modules->result() ,'messages' )): ?>
                                <?php if($this->Employee->has_module_permission('messages', $employee_id)) { ?>
                                    <div class="menu-item" <?php echo array_search('messages', $disable_modules) === false ? '': 'style="display: none;"' ?>>
                                        <a class="menu-link  <?= ($this->uri->segment(1) == 'messages') ?  'active': '' ?>" href="<?php echo site_url('messages'); ?>">
                                            <span class="menu-icon">
                                              <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/communication/com012.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="currentColor"/>
                                                <rect x="6" y="12" width="7" height="2" rx="1" fill="currentColor"/>
                                                <rect x="6" y="7" width="12" height="2" rx="1" fill="currentColor"/>
                                                </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <?php if(!isset($is_pos)): ?>
                                                <span class="menu-title"><?php echo lang('module_messages')?></span>
                                            <?php endif; ?>
                                        </a>
                                    </div>

                                <?php } ?> 
                                <?php endif; ?>


                                

                                            <?php /** 
                               
                                
                                    <div class="menu-item" >
                                        <a class="menu-link  <?= ($this->uri->segment(1) == 'payments') ?  'active': '' ?>" href="<?php echo site_url('payments'); ?>">
                                            <span class="menu-icon">
                                              <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/finance/fin010.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M12.5 22C11.9 22 11.5 21.6 11.5 21V3C11.5 2.4 11.9 2 12.5 2C13.1 2 13.5 2.4 13.5 3V21C13.5 21.6 13.1 22 12.5 22Z" fill="currentColor"/>
                                                <path d="M17.8 14.7C17.8 15.5 17.6 16.3 17.2 16.9C16.8 17.6 16.2 18.1 15.3 18.4C14.5 18.8 13.5 19 12.4 19C11.1 19 10 18.7 9.10001 18.2C8.50001 17.8 8.00001 17.4 7.60001 16.7C7.20001 16.1 7 15.5 7 14.9C7 14.6 7.09999 14.3 7.29999 14C7.49999 13.8 7.80001 13.6 8.20001 13.6C8.50001 13.6 8.69999 13.7 8.89999 13.9C9.09999 14.1 9.29999 14.4 9.39999 14.7C9.59999 15.1 9.8 15.5 10 15.8C10.2 16.1 10.5 16.3 10.8 16.5C11.2 16.7 11.6 16.8 12.2 16.8C13 16.8 13.7 16.6 14.2 16.2C14.7 15.8 15 15.3 15 14.8C15 14.4 14.9 14 14.6 13.7C14.3 13.4 14 13.2 13.5 13.1C13.1 13 12.5 12.8 11.8 12.6C10.8 12.4 9.99999 12.1 9.39999 11.8C8.69999 11.5 8.19999 11.1 7.79999 10.6C7.39999 10.1 7.20001 9.39998 7.20001 8.59998C7.20001 7.89998 7.39999 7.19998 7.79999 6.59998C8.19999 5.99998 8.80001 5.60005 9.60001 5.30005C10.4 5.00005 11.3 4.80005 12.3 4.80005C13.1 4.80005 13.8 4.89998 14.5 5.09998C15.1 5.29998 15.6 5.60002 16 5.90002C16.4 6.20002 16.7 6.6 16.9 7C17.1 7.4 17.2 7.69998 17.2 8.09998C17.2 8.39998 17.1 8.7 16.9 9C16.7 9.3 16.4 9.40002 16 9.40002C15.7 9.40002 15.4 9.29995 15.3 9.19995C15.2 9.09995 15 8.80002 14.8 8.40002C14.6 7.90002 14.3 7.49995 13.9 7.19995C13.5 6.89995 13 6.80005 12.2 6.80005C11.5 6.80005 10.9 7.00005 10.5 7.30005C10.1 7.60005 9.79999 8.00002 9.79999 8.40002C9.79999 8.70002 9.9 8.89998 10 9.09998C10.1 9.29998 10.4 9.49998 10.6 9.59998C10.8 9.69998 11.1 9.90002 11.4 9.90002C11.7 10 12.1 10.1 12.7 10.3C13.5 10.5 14.2 10.7 14.8 10.9C15.4 11.1 15.9 11.4 16.4 11.7C16.8 12 17.2 12.4 17.4 12.9C17.6 13.4 17.8 14 17.8 14.7Z" fill="currentColor"/>
                                                </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <?php if(!isset($is_pos)): ?>
                                                <span class="menu-title"><?php echo lang('payments')?></span>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                   
*/ ?>
                                <!-- /////////////////// new menu -->


						
				
                                
                                <?php if(!isset($is_pos)): ?>
                                    <div data-kt-menu-trigger="click" class="menu-item <?php echo ($this->uri->segment(1)=='config' || $this->uri->segment(1)=='receipt')   ? 'here show' : ''; ?>  menu-accordion">
							
                                    <?php  else: ?>
                                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" class="menu-item <?php echo ($this->uri->segment(1)=='config'  || $this->uri->segment(1)=='receipt')  ? 'here show' : ''; ?>  menu-accordion">
							
                                <?php endif; ?>

                             		<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/ecommerce/ecm008.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="currentColor"/>
                                                    <path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="currentColor"/>
                                                    <path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="currentColor"/>
                                                </svg>
                                                </span>
                                            <!--end::Svg Icon-->
										</span>
                                        <?php if(!isset($is_pos)): ?>
                                    	<span class="menu-title"><?php echo lang('setup'); ?></span>
                                        <span class="menu-arrow"></span>
                                        <?php endif; ?>
									
										
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									
                                 
                                    <?php if(!isset($is_pos)): ?>
                                        <div class="menu-sub menu-sub-accordion">
                                    <?php  else: ?>
                                        <div class="menu-sub menu-sub-dropdown px-lg-2 py-lg-4 w-200px w-lg-225px">
                                <?php endif; ?>

                            


                                       <!-- setup -->
                                       <?php if(check_allowed_module($allowed_modules->result() ,'config' )): ?>
                                        <?php if($this->Employee->has_module_permission('config', $employee_id)) { ?>
                                            <div class="menu-item" <?php echo array_search('config', $disable_modules) === false ? '': 'style="display: none;"' ?>>
                                                <a class="menu-link  <?= ($this->uri->segment(1) == 'config' && $this->uri->segment(2) == '' ) ?  'active': '' ?>" href="<?php echo site_url('config'); ?>">
                                                    <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/coding/cod001.svg-->
                                                            <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3" d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z" fill="currentColor"/>
                                                            <path d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z" fill="currentColor"/>
                                                            </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                    </span>
                                                    <?php if(!isset($is_pos)): ?>
                                                        <span class="menu-title"><?php echo lang('module_config')?></span>
                                                    <?php endif; ?>
                                                </a>
                                            </div>

                                        <?php } ?> 
                                        <?php endif; ?>

                                        <div class="menu-item" >
                                            <a class="menu-link  <?= ($this->uri->segment(1) == 'language') ?  'active': '' ?>" href="<?php echo site_url('language'); ?>">
                                                <span class="menu-icon">
                                                <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/maps/map001.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M6 22H4V3C4 2.4 4.4 2 5 2C5.6 2 6 2.4 6 3V22Z" fill="currentColor"/>
                                                <path d="M18 14H4V4H18C18.8 4 19.2 4.9 18.7 5.5L16 9L18.8 12.5C19.3 13.1 18.8 14 18 14Z" fill="currentColor"/>
                                                </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                </span>
                                                <?php if(!isset($is_pos)): ?>
                                                    <span class="menu-title"><?php echo lang('languages')?></span>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <?php if(check_allowed_module($allowed_modules->result() ,'receipt' )): ?>
                                <?php if($this->Employee->has_module_permission('receipt', $employee_id)) { ?>
                                    <div class="menu-item" <?php echo array_search('receipt', $disable_modules) === false ? '': 'style="display: none;"' ?>>
                                        <a class="menu-link  <?= ($this->uri->segment(1) == 'receipt') ?  'active': '' ?>" href="<?php echo site_url('receipt'); ?>">
                                            <span class="menu-icon">
                                              <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/general/gen005.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="currentColor"/>
                                                <rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor"/>
                                                <rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor"/>
                                                <rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor"/>
                                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"/>
                                                </svg>
                                                </span>
                                            <!--end::Svg Icon-->
                                            </span>
                                            <?php if(!isset($is_pos)): ?>
                                                <span class="menu-title"><?php echo lang('receipt')?></span>
                                            <?php endif; ?>
                                        </a>
                                    </div>

                                <?php } ?> 
                                <?php endif; ?>
                                        <div class="menu-item" >
                                            <a class="menu-link  <?= ($this->uri->segment(2) == 'backup') ?  'active': '' ?>" href="<?php echo site_url('config/backup'); ?>">
                                                <span class="menu-icon">
                                                <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/maps/map001.svg-->
                                                <span class="ion-load-a"> </span>
                                                </span>
                                                <!--end::Svg Icon-->
                                                </span>
                                                <?php if(!isset($is_pos)): ?>
                                                    <span class="menu-title"><?php echo lang('backup_manager')?></span>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                      <?php   if (!is_on_phppos_host()) {?>
                                        <div class="menu-item" >
                                            <a class="menu-link  checkForUpdate <?= ($this->uri->segment(2) == 'is_update_available') ?  'active': '' ?>" href="<?php echo site_url('config/is_update_available'); ?>">
                                                <span class="menu-icon">
                                                <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/maps/map001.svg-->
                                                <span class="glyphicon glyphicon-import"></span>
                                                </span>
                                                <!--end::Svg Icon-->
                                                </span>
                                                <?php if(!isset($is_pos)): ?>
                                                    <span class="menu-title"><?php echo lang('system_update')?></span>
                                                <?php endif; ?>
                                            </a>
                                        </div>

                                                <?php } ?>
									
									
									</div>
									<!--end:Menu sub-->
								</div>


						
							</div>
							<!--end::Menu-->
						</div>
						<!--end::Sidebar menu-->
						<div class="app-sidebar-user <?php if(!isset($is_pos)): ?> d-flex  <?php else: ?> d-none <?php endif; ?> flex-stack py-5 px-8   ">
                                <!--begin::User avatar-->
                                <div class="d-flex me-5">
                                    <!--begin::Menu wrapper-->
                                    <div class="me-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px cursor-pointer"
                                            data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                            data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
                                            <img src="<?php echo base_url('assets/css_good/media/avatars/300-1.jpg') ?>"
                                                alt="" />
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::User account menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content d-flex align-items-center px-3">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px me-5">
                                                        <img alt="Logo"
                                                            src="<?php echo base_url('assets/css_good/media/avatars/300-1.jpg') ?>" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Username-->
                                                    <div class="d-flex flex-column">
                                                        <div class="fw-bold d-flex align-items-center fs-5">
                                                            <?php echo H($user_info->first_name." ".$user_info->last_name); ?>
                                                            <span
                                                                class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span>
                                                        </div>
                                                        <a href="#"
                                                            class="fw-semibold text-muted text-hover-primary fs-7">Staff</a>
                                                    </div>
                                                    <!--end::Username-->
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator my-2"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a id="support_link" target="_blank"
                                                    href="https://support.<?php echo $this->config->item('branding')['domain']; ?>/"
                                                    class="menu-link px-5"><?php echo lang('common_support'); ?></a>


                                            </div>
                                            <!--end::Menu item-->
                                            <?php if ($this->Employee->has_module_permission('config', $user_info->person_id)) {?>
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">

                                                <?php echo anchor("config",'<i class="ion-android-settings"></i><span class="menu-link px-5">'.lang("common_settings").'</span>', array('tabindex' => '-1')); ?>

                                            </div>
                                            <!--end::Menu item-->

                                            <?php } ?>





                                            <?php 
													$this->load->helper('update');
													if (is_on_phppos_host() && !is_on_demo_host() && !empty($cloud_customer_info)) {?>

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a id="update_billing_link" target="_blank"
                                                    href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username'];?>&username=<?php echo $this->Employee->get_logged_in_employee_info()->username; ?>&password=<?php echo $this->Employee->get_logged_in_employee_info()->password; ?>"
                                                    class="menu-link px-5"><?php echo lang('common_update_billing_info'); ?></a>


                                            </div>
                                            <!--end::Menu item-->



                                            <?php } ?>


                                            <?php if ($this->Location->get_info_for_key('blockchyp_api_key') && $this->Employee->has_module_action_permission('sales', 'view_edit_transaction_history', $this->Employee->get_logged_in_employee_info()->person_id)) {?>


                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a htarget="_blank" tabindex="-1" title=""
                                                    href="<?php echo site_url('sales/coreclear_portal')?>"
                                                    class="menu-link px-5">
                                                    <span
                                                        class="menu-text"><?php echo lang('sales_coreclear_portal'); ?></span>

                                                </a>
                                            </div>
                                            <!--end::Menu item-->


                                            <?php } ?>



                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a tabindex="-1" id="change_log_link" target="_blank"
                                                    href="https://<?php echo $this->config->item('branding')['domain']; ?>/whats_new.php"
                                                    class="menu-link px-5">
                                                    <span
                                                        class="menu-text"><?php echo lang('common_change_log'); ?></span>

                                                </a>
                                            </div>
                                            <!--end::Menu item-->





                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a tabindex="-1" id="switch_user"
                                                    href="<?php echo site_url('login/switch_user/'.($this->uri->segment(1) == 'sales' ? '0' : '1'));  ?>"
                                                    data-toggle="modal" data-target="#myModalDisableClose"
                                                    class="menu-link px-5">
                                                    <span
                                                        class="menu-text"><?php echo lang('common_switch_user'); ?></span>

                                                    </a>
                                            </div>
                                            <!--end::Menu item-->

                                            <?php if ($this->Employee->has_module_action_permission('employees','edit_profile',$this->Employee->get_logged_in_employee_info()->person_id)) {  ?>




                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a tabindex="-1" id="edit_profile"
                                                    href="<?php echo site_url('employees/edit_profile_model/'.($this->uri->segment(1) == 'sales' ? '0' : '1'));  ?>"
                                                    data-toggle="modal" data-target="#myModalDisableClose"
                                                    class="menu-link px-5">
                                                    <span
                                                        class="menu-text"><?php echo lang('common_edit_profile'); ?></span>

                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <?php } ?>


                                            <?php
								if ($this->config->item('timeclock')) 
								{
								?>


                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a href="#" class="menu-link px-5">
                                                    <span class="menu-text"><?php
										echo anchor("timeclocks",'<i class="ion-clock"></i>'.lang("employees_timeclock"), array('tabindex' => '-1'));
					 				?></span>

                                                </a>
                                            </div>
                                            <!--end::Menu item-->


                                            <?php
								}
								?>


                                            <div class="menu-item px-5">
                                                <?php
									if ($this->config->item('track_payment_types') && $this->Register->is_register_log_open()) {
										$continue = $this->config->item('timeclock') && !$this->Employee->get_logged_in_employee_info()->not_required_to_clock_in ? 'timeclocks' : 'logout';
										echo anchor("sales/closeregister?continue=$continue",'<i class="ion-power"></i><span class="menu-link px-5">'.lang("common_logout").'</span>',array('class'=>'logout_button','tabindex' => '-1'));
									} else {
										
										if ($this->config->item('timeclock') && !$this->Employee->get_logged_in_employee_info()->not_required_to_clock_in && $this->Employee->is_clocked_in())
										{
											echo anchor("timeclocks",'<i class="ion-power"></i><span class="menu-link px-5">'.lang("common_logout").'</span>',array('class'=>'logout_button','tabindex' => '-1'));
										}
										else
										{
											echo anchor("home/logout",'<i class="ion-power"></i><span class="menu-link px-5">'.lang("common_logout").'</span>',array('class'=>'logout_button','tabindex' => '-1'));
										}
									}
									?>
                                            </div>








                                        </div>
                                        <!--end::User account menu-->
                                    </div>
                                    <!--end::Menu wrapper-->
                                    <!--begin::Info-->
                                    <div class="me-2">
                                        <!--begin::Username-->
                                        <a href="#"
                                            class="app-sidebar-username text-gray-800 text-hover-primary fs-6 fw-semibold lh-0"><?php echo H($user_info->first_name." ".$user_info->last_name); ?></a>
                                        <!--end::Username-->
                                        <!--begin::Description-->
                                        <span
                                            class="app-sidebar-deckription text-gray-400 fw-semibold d-block fs-8">Staff</span>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User avatar-->

                            </div>
					</div>
					<!--end::sidebar-->
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-fluid">
									<!--begin::Row-->
									
					

            