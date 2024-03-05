<!DOCTYPE html>
<html class="<?php echo $this->config->item('language');?>">

<head>
    <meta charset="UTF-8" />
    <title>
        <?php 
		 $this->load->helper('demo');
	 	 $company = ($company = $this->Location->get_info_for_key('company')) ? $company : $this->config->item('company');
		 echo !is_on_demo_host() ?  $company.' -- '.lang('powered_by').' '.$this->config->item('branding')['name'] : 'Demo - '.$this->config->item('branding')['name'].' | Easy to use Online POS Software' ?>
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
    .timer {

        
    color: #daf6ff;
    font-size: 18px;
    padding: 0px 16px 0px 11px;
    position: relative;
    margin-left: -14%;
    /* transform: translate(-37px, -10px); */
    background: #904545;
    border-radius: 0px 10px 10px 0px;
    width: 56%;
    font-weight: 900;
    font-family: Orbitron;
    text-shadow: 0 0 20px rgb(206 220 224), 0 0 20px rgba(10, 175, 230, 0);
    letter-spacing: 0.05em;

}
.view-btn{
 display: none !important;
}


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
    var CONFIRM_CLONE = <?php echo json_encode(lang('confirm_clone')); ?>;
    var CONFIRM_IMAGE_DELETE = <?php echo json_encode(lang('confirm_image_delete')); ?>;
    </script>

    <link rel="stylesheet" type="text/css"  href="<?php echo base_url()?>assets/css_good/css/custom.css" >
    <?php 
	$this->load->helper('assets');
	foreach(get_css_files() as $css_file) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().$css_file['path'].'?'.ASSET_TIMESTAMP;?>" />
    <?php } ?>
   

    
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="<?php echo base_url()?>assets/css_good/plugins/global/plugins.bundle.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used by this page)-->
		<script src="<?php echo base_url()?>assets/css_good/plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used by this page)-->
		<script src="<?php echo base_url()?>assets/css_good/js/custom/apps/ecommerce/sales/listing.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/widgets.bundle.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/custom/widgets.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/custom/apps/chat/chat.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/custom/utilities/modals/upgrade-plan.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/custom/utilities/modals/create-project/type.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/custom/utilities/modals/create-project/budget.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/custom/utilities/modals/create-project/settings.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/custom/utilities/modals/create-project/team.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/custom/utilities/modals/create-project/targets.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/custom/utilities/modals/create-project/files.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/custom/utilities/modals/create-project/complete.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/custom/utilities/modals/create-project/main.js"></script>
		<script src="<?php echo base_url()?>assets/css_good/js/custom/utilities/modals/users-search.js"></script>


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
    COMMON_SUCCESS = <?php echo json_encode(lang('success')); ?>;
    COMMON_ERROR = <?php echo json_encode(lang('error')); ?>;

    // bootbox.addLocale('ar', {
    //     OK: 'حسنا',
    //     CANCEL: 'إلغاء',
    //     CONFIRM: 'تأكيد'
    // });

    // bootbox.addLocale('km', {
    //     OK: 'យល់ព្រម',
    //     CANCEL: 'បោះបង់',
    //     CONFIRM: 'បញ្ជាក់ការ'
    // });
    // bootbox.setLocale(LOCALE);
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

    // $.fn.editableform.buttons =
    //     '<button tabindex="-1" type="submit" class="btn btn-primary btn-sm editable-submit">' +
    //     '<i class="icon ti-check"></i>' +
    //     '</button>' +
    //     '<button tabindex="-1" type="button" class="btn btn-default btn-sm editable-cancel">' +
    //     '<i class="icon ti-close"></i>' +
    // //     '</button>';

    // $.fn.editable.defaults.emptytext = <?php echo json_encode(lang('empty')); ?>;
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
    </script>
    <?php
$this->load->helper('demo');
if (is_on_demo_host()) { ?>
    <script src="//<?php echo $this->config->item('branding')['domain']; ?>/js/iframeResizer.contentWindow.min.js">
    </script>
    <?php } ?>

 <style>
.border-right-dotted {
    border-right: dotted;
}


 </style>
    </head>

    

<body data-kt-name="good" id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">
		<!--begin::Theme mode setup on page load-->

	
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper" style="margin: 0px;">
				
															
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-fluid">
                                   
							</div>
                            <!--end::Content container-->
						
						</div>
                        <!--end::Content-->

                        <script>

                       


                        function closebtn(){
									
                                    $('.modal').css('display', 'none');
                            }


                        function show_modal(d){
									$('#kt_modal_'+d).show();

									
								}

                                function show_view_modal(d){
									$('#kt_view_modal_'+d).show();

									
								}
                        function change_status(status , id){
                                                        $.ajax({
                                                        type: 'POST',
                                                        url: '<?php echo site_url("booking/change_status"); ?>',
                                                        data: { 'status' : status , 'id' : id  },
                                                        success: function(res){
                                                            get_tables();
                                                            }
                                                        });
                                                    }

                        function change_time(id){
                            $.ajax({
                            type: 'POST',
                            url: '<?php echo site_url("booking/change_time"); ?>',
                            data: {  'id' : id , 'time' : $('#time_selected_'+id).val() },
                            success: function(res){
                                    get_tables();
                                    closebtn();
                                }
                            });
                        }

                                                    
								var pre_html='';
								function get_tables(){
									
									
									$.ajax({
											type: 'POST',
											url: '<?php echo site_url("booking/load_kitchen_view_cateogry"); ?>',
											data: {  },
											success: function(result){
												var difference = result.replace(/\s/g, '').localeCompare(pre_html.replace(/\s/g, ''));
											
												if(difference!=0){
													$('#kt_app_content_container').html('');
													// console.log('result' , result.replace(/\s/g, ''));
													// console.log('pre_html' , pre_html.replace(/\s/g, ''));
													// console.log('update');
													$('#kt_app_content_container').html(result);

                                                   
                                                    
													pre_html = result.replace(/\s/g, '');

                                                    var timerConfigurations = $(".timer").map(function() {
                                                        return {
                                                            id: this.id,
                                                            remainingSeconds: $(this).data("id") - parseInt('<?php echo now(); ?>'),
                                                        };
                                                        }).get();

                                                        console.log(timerConfigurations);
                                                                                                            // Start each timer
                                                            timerConfigurations.forEach(function(config) {
                                                                startTimer(config.id, config.remainingSeconds);
                                                            });

                                                            function startTimer(timerId, remainingSeconds) {
                                                                var timerElement = $("#" + timerId);

                                                                // Update the timer every second
                                                                var timer = setInterval(updateTimer, 1000);

                                                                function updateTimer() {
                                                                // Check if the timer has reached zero
                                                                if (remainingSeconds <= 0) {
                                                                    clearInterval(timer);
                                                                    timerElement.text("Time up");
                                                                    timerElement.addClass("bg-warning");
                                                                } else {
                                                                    // Calculate the remaining minutes and seconds
                                                                    var minutes = Math.floor(remainingSeconds / 60);
                                                                    var seconds = remainingSeconds % 60;

                                                                    // Display the remaining time
                                                                    timerElement.text(minutes + ":" + seconds);

                                                                    // Decrease the remaining seconds by 1
                                                                    remainingSeconds--;
                                                                }
                                                                }
                                                            }

                                                    
													
												}
												
											}
										}) 
								}
								get_tables();

                                setInterval(function() {
										get_tables();
								}, 5000);

                                $(document).ready(function () {
                                $(document).on('click', '[data-kt-menunew-trigger="click"]', function (e) {
                                                            e.preventDefault();
                                                            var $this = $(this); // Save the reference to the trigger button
                                                            var $parentDiv = $this.parent().find('.menu-sub-dropdown');
                                                            // Set the desired CSS properties
                                                            // Set the CSS properties
                                                            var position = $this.offset();
                                                            $parentDiv.css({
                                                                'z-index': 105,
                                                                'position': 'absolute', // Use absolute instead of fixed for positioning relative to the offset parent
                                                                'top': position.top + $this.height() + 10, // Position below the button
                                                                'left': position.left + $this.width(), // Align with the left side of the button
                                                                'margin': '0px',
                                                                'display': 'block'
                                                            });

                                                            // Toggle the visibility of the dropdown
                                                                $parentDiv.toggle();
                                                                // Toggle the 'show' class on the dropdown menu
                                                                $parentDiv.toggleClass('show');
                                                            });
                                                        });
                                </script>

						<?php $this->load->view('partial/footer') ?>