<!DOCTYPE html>
<html class="<?php echo $this->config->item('language');?>">

<head>
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
     var CONFIRM_CLONE = <?php echo json_encode(lang('common_confirm_clone')); ?>;
    var CONFIRM_IMAGE_DELETE = <?php echo json_encode(lang('common_confirm_image_delete')); ?>;
    </script>

    <link rel="stylesheet" type="text/css"  href="<?php echo base_url()?>assets/css_good/css/custom.css" >
    <?php 
	$this->load->helper('assets');
	foreach(get_css_files() as $css_file) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().$css_file['path'].'?'.ASSET_TIMESTAMP;?>" />
    <?php } ?>
    <?php foreach(get_js_files() as $js_file) { ?>
    <script src="<?php echo base_url().$js_file['path'].'?'.ASSET_TIMESTAMP;?>" type="text/javascript" charset="UTF-8">
    </script>
    <?php } ?>
	<script src="<?php echo base_url().'assets/css_good/plugins/global/plugins.bundle.js?'.ASSET_TIMESTAMP;?>" type="text/javascript" charset="UTF-8">
    </script>
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.7/umd/popper.min.js" integrity="sha512-uaZ0UXmB7NHxAxQawA8Ow2wWjdsedpRu7nJRSoI2mjnwtY8V5YiCWavoIpo1AhWPMLiW5iEeavmA3JJ2+1idUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php if($this->config->item('add_ck_editor_to_item')){?>
    <script src="<?php echo base_url().'assets/js/ckeditor/ckeditor.js?'.ASSET_TIMESTAMP;?>" type="text/javascript"
        charset="UTF-8"></script>
    <?php } ?>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
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
			if (!is_on_saas_host())
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
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script> -->
<style>
<?php
  $chairs = 4;

?>
/**
* Quarter Circles
*/
/* .color-wheel {
  --num-colors: 12;
  --color-size: calc(100% / var(--num-colors));
  width: 300px;
  height: 300px;
  position: relative;
  border-radius: 50%;
  background: conic-gradient(
    #f2f5fa calc(0 * var(--color-size)) calc(1 * var(--color-size)), 
    #f2f5fa calc(1 * var(--color-size)) calc(2 * var(--color-size)), 
    #f2f5fa calc(2 * var(--color-size)) calc(3 * var(--color-size)), 
    #f2f5fa calc(3 * var(--color-size)) calc(4 * var(--color-size)), 
    #fff calc(4 * var(--color-size)) calc(5 * var(--color-size))  , 
    #fff calc(5 * var(--color-size)) calc(6 * var(--color-size)), 
    #fff calc(6 * var(--color-size)) calc(7 * var(--color-size)), 
    #fff calc(7 * var(--color-size)) calc(8 * var(--color-size)), 
    #f2f5fa calc(8 * var(--color-size)) calc(9 * var(--color-size)), 
    #f2f5fa calc(9 * var(--color-size)) calc(10 * var(--color-size)), 
    #f2f5fa calc(10 * var(--color-size)) calc(11 * var(--color-size)), 
    #f2f5fa calc(11 * var(--color-size)) calc(12 * var(--color-size))
  );
  transform: rotate(calc(-180deg / var(--num-colors)));
  margin-top: -100px;
}

.color-wheel::after {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  border-radius: 50%;
  background: #f2f5fa;
  width: 50%;
  height: 50%;
  transform: translate(-50%, -50%);
}

.chair {
    width: 15%;
    height: 20px;
    border-radius: 5% 5% 50% 50%;
    margin-left: 14px;
    background: green;
    float: left;
    position: relative;
}

.chair:nth-child(2) {
    top: -24px;
    right: -15px;
    transform: rotate(31deg);
}

.chair:nth-child(3) {
    top: 2px;
    right: -4px;
    transform: rotate(8deg);
}

.chair:nth-child(4) {
    top: 5px;
    right: 1px;
    transform: rotate(355deg);
}
.chair:nth-child(5) {
    top: -8px;
    right: 9px;
    transform: rotate(337deg);
}
.chair:nth-child(6) {
    top: -37px;
    right: 23px;
    transform: rotate(315deg);
} */
#category_item_selection_wrapper{
	display: block;
}


.stepper.stepper-links .stepper-nav {
    border: 1px dashed var(--kt-card-border-color);
}




.table-text{
	margin: 0 auto;
    z-index: 999;
    position: relative;
    top: 173%;
    left: 46%;
	width: 150px;
    font-weight: 500;
    color: #d9dee4;
}

.draggable {
      width: 50px;
      height: 50px;
      padding: 0.5em;
      float: left;
      margin: 0 10px 10px 0;
        
      margin-bottom:20px;
  }

  #containment-wrapper {
      width: 1000px;
      height: 700px;
      border:2px solid #ccc;
      padding: 10px;
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
									<div class="row">
									<div class="col-md-12">
									<div class="card shadow-sm mt-6 mb-3">
    
										<div class="card-body">
											<div class="row">
											
        <div class="col-2">
		<div class="mb-5">
                <label for="" class="form-label">People</label>
                <input class="form-control " placeholder="Number of peoples" type="number" min="1" max="10"  id="numberInput">
            </div>
			</div>
			<div class="col-2">
            <div class="mb-5">
                <label for="" class="form-label">Pick DateTime</label>
                <input class="form-control flatpickr-input" placeholder="Pick date" id="kt_datepicker_1" type="text" readonly="readonly">
            </div>

        </div>

		<script>
		$(document).ready(function() {
    $('#numberInput').on('input', function() {
      var inputValue = $(this).val();
      if (inputValue > 10) {
        $(this).val(10);
      }
    });
  });


		$("#kt_datepicker_1").flatpickr({
			minDate: "today", // Disable past dates
    maxDate: new Date().fp_incr(10), // Allow selection for the next 10 days
    defaultDate: new Date(), // Set today's date as the default
    enableTime: true,
    dateFormat: "Y-m-d H:i",
});
		</script>
												<div class="col-5">
												<div class="d-flex justify-content-between fw-bold fs-6  opacity-50 w-100 mt-auto mb-2">
															<span>Seats</span>
														</div>
													<div class="d-flex justify-content-start ">
														<div class="mx-2"> <i style="background-color: #d9dee4;" class="far rounded bg-secondary fa-star fs-6 text-white p-1 "></i> Free | <span id="total_free_span">0</span>  </div> 
														<div class="mx-2"> <i style="background-color: #ffc144;" class="far rounded bg-warning fa-star fs-6 text-white p-1 "></i> Reserved | <span id="total_resereved_span">0</span>  </div> 
														<div class="mx-2"> <i style="background-color: #0dc266;" class="far rounded  fa-star fs-6 text-white p-1 "></i> Checked In | <span id="total_checkedin_span">0</span>  </div> 
													</div>
												</div>
												<div class="col-3">
													
													<div class="d-flex align-items-center flex-column mt-3 w-100">
														<div class="d-flex justify-content-between fw-bold fs-6  opacity-50 w-100 mt-auto mb-2">
															<span>Actual Capacity</span>
															<span id="progressbar_span">72%</span>
														</div>
														<div class="h-8px mx-3 w-100 bg-light-danger rounded">
															<div class="bg-danger rounded h-8px" role="progressbar" id="progressbar" style="width: 72%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
														</div>
													</div>
												</div>	
											</div>
																
										</div>
										
									</div>
                                     
									</div>
                                        <div class="col-md-12">
                                        <div class="card card-flush h-xl-100 " style="background-color: #f2f5fa;">
										
												<!--begin::Card body-->
												<div class="card-body pt-2 pb-4 d-flex align-items-center w-xl-100">
											

												<!--begin::Stepper-->
											<div class="stepper stepper-links d-flex flex-column pt-10 w-xl-100" id="kt_create_account_stepper">
												<!--begin::Nav-->
												<div class="stepper-nav mb-5 bg-white rounded ">
													<!--begin::Step 1-->
													<div class="stepper-item current" data-kt-stepper-element="nav">
														<h3 class="stepper-title">Tables</h3>
													</div>
													<!--end::Step 1-->
													<!--begin::Step 2-->
													<div class="stepper-item" data-kt-stepper-element="nav">
														<h3 class="stepper-title">Menu</h3>
													</div>
													<!--end::Step 2-->
													<!--begin::Step 3-->
													<div class="stepper-item" data-kt-stepper-element="nav">
														<h3 class="stepper-title">User Details</h3>
													</div>
													<!--end::Step 3-->
													<!--begin::Step 4-->
													<div class="stepper-item" data-kt-stepper-element="nav">
														<h3 class="stepper-title">Payments</h3>
													</div>
													<!--end::Step 4-->
													<!--begin::Step 5-->
													<div class="stepper-item" data-kt-stepper-element="nav">
														<h3 class="stepper-title">Completed</h3>
													</div>
													<!--end::Step 5-->
												</div>
												<!--end::Nav-->
												<!--begin::Form-->
												<form class="mx-auto  w-100  pb-10" novalidate="novalidate" id="kt_create_account_form">
													<!--begin::Step 1-->
													<div class="current" data-kt-stepper-element="content">
														<!--begin::Wrapper-->
														<div class="w-100">
															
															<!--begin::Input group-->
															<div class="fv-row">
																<!--begin::Row-->

														


																<div class="row w-100  " id="containment-wrapper">
                                                            

																	
																	

														</div>

														
																<!--end::Row-->
															</div>
															<!--end::Input group-->
														</div>
														<!--end::Wrapper-->
													</div>
													<!--end::Step 1-->
													<!--begin::Step 2-->
													<div data-kt-stepper-element="content">
														<!--begin::Wrapper-->
														<div class="w-100">
														
															<div class="row">
																<div class="col-md-9">
																<div class="mb-10 fv-row">
																<div id="sale-grid-big-wrapper" class="clearfix register <?php echo $this->config->item('hide_images_in_grid') ? 'hide_images' : ''; ?>">
																	<div class="clearfix" id="category_item_selection_wrapper">
																		<div class="">
																			<div class="spinner" id="grid-loader" style="display:none">
																				<div class="rect1"></div>
																				<div class="rect2"></div>
																				<div class="rect3"></div>
																			</div>

																			<div class="text-center">
																				<div id="grid_selection" class="btn-group engage-toolbar d-flex position-fixed px-5 fw-bold zindex-2 top-50 end-0 transform-90 mt-5 mt-lg-20 gap-2" role="group">
																					<?php if($this->config->item('hide_categories_sales_grid') != 1 ){ ?>
																					<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'categories' || !$this->config->item('default_type_for_grid') ? 'btn active' : ''; ?> btn btn-grid btn-success" id="by_category"><?php echo lang('reports_categories') ?></a>
																					<?php }
																					if($this->config->item('hide_tags_sales_grid') != 1 ){ ?>
																					<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'tags' ? 'btn active' : ''; ?> btn btn-grid btn-danger" id="by_tag"><?php echo lang('common_tags') ?></a>
																					<?php }
																					if($this->config->item('hide_suppliers_sales_grid') != 1 ){ ?>
																					<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'suppliers' ? 'btn active' : ''; ?> btn btn-grid btn-info" id="by_supplier"><?php echo lang('common_suppliers') ?></a>
																					<?php }
																					if($this->config->item('hide_favorites_sales_grid') != 1 ){ ?>
																					<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'favorites' ? 'btn active' : ''; ?> btn btn-grid btn-primary" id="by_favorite"><?php echo lang('common_favorite') ?></a>
																					<?php }?>
																				</div>
																			</div>

																			<div id="grid_breadcrumbs"></div>
																			<ul id="category_item_selection" class="row register-grid nav nav-pills nav-pills-custom mb-3"></ul>
																			<div class="pagination hidden-print alternate text-center"></div>
																		</div>
																		<button type="button" id="back_to_category"  class=" show-grid d-none" tabindex="-1" title="Show Grid"><i class="icon ti-layout"></i> Show Grid</button>
															
																	</div>
																</div>
															</div>
															<div class="row" id="category_item_selection_wrapper_new">
				
															</div>
																</div>
																<div class="col-md-3">
																<div id="register_container" class="sales clearfix">
															<?php 
															
															$cart_count = 0;
															if ($pagination) { ?>
															<div class="page_pagination pagination-top hidden-print  text-center" id="pagination_top">
																<?php echo $pagination; ?>
															</div>
														<?php } ?>

														<?php if ($this->config->item('allow_drag_drop_sale') && !$this->agent->is_mobile() && !$this->agent->is_tablet()) {  ?>

														<style>
															#register tbody{
																cursor: move;
															}
															#register th.item_sort_able{
																cursor: pointer;
															}
															#grid-loader2.spinner > div {
																height: 100px;
																width: 8px;
																margin-right: 2px;
																margin-top: 30px;
																top: 50%;
															}						
														</style>
														<?php } ?>
														<div class="spinner" id="grid-loader2" style="display: none;">
															<div class="rect1"></div>
															<div class="rect2"></div>
															<div class="rect3"></div>
														</div>	
														<table id="register" class="table table-striped gy-7 gs-7">
															<thead>
																<tr class="register-items-header">
																	<th><a href="javascript:void(0);" id="sale_details_expand_collapse" class="expand">-</a></th>
																	<th class="item_sort_able item_name_heading <?php echo $this->cart->sort_column && $this->cart->sort_column == 'name'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('sales_item_name'); ?></th>
																	<th class="item_sort_able sales_price <?php echo $this->cart->sort_column && $this->cart->sort_column == 'unit_price'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('common_price'); ?></th>
																	<th class="item_sort_able sales_quantity <?php echo $this->cart->sort_column && $this->cart->sort_column == 'quantity'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('common_quantity'); ?></th>
																	<th class="item_sort_able sales_discount <?php echo $this->cart->sort_column && $this->cart->sort_column == 'discount'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('common_discount_percent'); ?></th>
																	<th class="item_sort_able sales_total <?php echo $this->cart->sort_column && $this->cart->sort_column == 'total'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('common_total'); ?></th>
																</tr>
															</thead>

																<?php
																if($this->config->item('allow_drag_drop_sale') == 1 && !$this->agent->is_mobile() && !$this->agent->is_tablet()){
																	$cart_items = $cart->get_list_sort_by_receipt_sort_order();
																}

																if (count($cart_items) == 0) { ?>
																<tbody class="register-item-content">
																	<tr class="cart_content_area">
																		<td colspan='6'>
																			<div class='text-center text-warning'>
																				<h3><?php echo lang('common_no_items_in_cart'); ?><span class="flatGreenc"> [<?php echo lang('module_sales') ?>]</span></h3>
																			</div>
																		</td>
																	</tr>
																</tbody>
																	<?php
																} else {

																	$start_index = $cart->offset + 1;
																	$end_index = $cart->offset + $cart->limit;

																	$the_cart_row_counter = 1;
																	foreach (array_reverse($cart_items, true) as $line => $item) {
																		if($this->config->item('hide_repair_items_in_sales_interface')){
																			if($item->is_repair_item == 1){
																				continue;
																			}
																		}
																		if($this->config->item('allow_drag_drop_sale') == 1 && !$this->agent->is_mobile() && !$this->agent->is_tablet()){
																			$line = $item->line_index;
																		}

																		if ($item->quantity > 0 && $item->name != lang('common_store_account_payment') && $item->name != lang('common_discount')) {
																			$cart_count = $cart_count + $item->quantity;
																		}

																		if (!(($start_index <= $the_cart_row_counter) && ($the_cart_row_counter <= $end_index))) {
																			$the_cart_row_counter++;
																			continue;
																		}
																		$the_cart_row_counter++;

																		?>
																		<tbody class="register-item-content" data-line="<?php echo $line; ?>">
																			<tr class="register-item-details">

																				
																					<td class="text-center"> <?php echo anchor("sales/delete_item/$line", '<i class="icon ion-android-cancel"></i>', array('class' => 'delete-item', 'tabindex' => '-1')); ?> </td>
																				
																				<td>
																						<?php if (property_exists($item,'is_recurring') && $item->is_recurring)
																						{
																						?>	
																						<i class="icon ti-loop"></i>
																						
																						<?php
																						}
																						?>
																					
																					<a tabindex="-1" href="<?php echo isset($item->item_id) ? site_url('home/view_item_modal/' . $item->item_id) . "?redirect=sales" : site_url('home/view_item_kit_modal/' . $item->item_kit_id) . "?redirect=sales"; ?>" data-toggle="modal" data-target="#myModal" class="register-item-name"><?php echo H($item->name).(property_exists($item, 'variation_name') && $item->variation_name ? '<span class="show-collpased" style="display:none">  ['.$item->variation_name.']</span>' : '') ?><?php echo $item->size ? ' (' . H($item->size) . ')' : ''; ?></a>
																				</td>
																				<td class="text-center">
																				

																					<?php 
																						echo to_currency($item->unit_price);
																					
																					?>

																				</td>
																				<td class="text-center">
																					<?php  
																							if ($this->config->item('number_of_decimals_displayed_on_sales_interface')) {
																								echo to_currency_no_money($item->quantity, $this->config->item('number_of_decimals_displayed_on_sales_interface'));
																							} else {
																								echo to_quantity($item->quantity);
																							}
																						
																					?>
																				</td>
																				<td class="text-center">
																					<?php
																				
																						echo to_quantity($item->discount) . '%';
																					
																					?>
																				</td>
																				<td class="text-center">
																					<?php
																					
																						echo to_currency($item->unit_price * $item->quantity - $item->unit_price * $item->quantity * $item->discount / 100);
																					
																					?>

																				</td>
																			</tr>
																			
																		</tbody>
																<?php }
																}  ?>
														</table>

														<?php if ($pagination) { ?>
															<div class="page_pagination pagination-top hidden-print  text-center" id="pagination_top">
																<?php echo $pagination; ?>
															</div>
														<?php } ?>


												</div>
																</div>
															</div>
															<!--begin::Input group-->
															
															<!--end::Input group-->
														</div>
														<!--end::Wrapper-->
													</div>
													<!--end::Step 2-->
													<!--begin::Step 3-->
													<div data-kt-stepper-element="content">
														<!--begin::Wrapper-->
														<div class="w-100">
															<!--begin::Heading-->
															<div class="pb-10 pb-lg-12">
																<!--begin::Title-->
																<h2 class="fw-bold text-dark">Cart Details</h2>
																<!--end::Title-->
																<!--begin::Notice-->
																<div class="text-muted fw-semibold fs-6">If you need more info, please check out
																<a href="#" class="link-primary fw-bold">Help Page</a>.</div>
																<!--end::Notice-->
															</div>
															<!--end::Heading-->

															
														</div>
														<!--end::Wrapper-->
													</div>
													<!--end::Step 3-->
													<!--begin::Step 4-->
													<div data-kt-stepper-element="content">
														<!--begin::Wrapper-->
														<div class="w-100">
															<!--begin::Heading-->
															<div class="pb-10 pb-lg-15">
																<!--begin::Title-->
																<h2 class="fw-bold text-dark">Billing Details</h2>
																<!--end::Title-->
																<!--begin::Notice-->
																<div class="text-muted fw-semibold fs-6">If you need more info, please check out
																<a href="#" class="text-primary fw-bold">Help Page</a>.</div>
																<!--end::Notice-->
															</div>
															<!--end::Heading-->
															<!--begin::Input group-->
															<div class="d-flex flex-column mb-7 fv-row">
																<!--begin::Label-->
																<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
																	<span class="required">Name On Card</span>
																	<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i>
																</label>
																<!--end::Label-->
																<input type="text" class="form-control form-control-solid" placeholder="" name="card_name" value="Max Doe" />
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="d-flex flex-column mb-7 fv-row">
																<!--begin::Label-->
																<label class="required fs-6 fw-semibold form-label mb-2">Card Number</label>
																<!--end::Label-->
																<!--begin::Input wrapper-->
																<div class="position-relative">
																	<!--begin::Input-->
																	<input type="text" class="form-control form-control-solid" placeholder="Enter card number" name="card_number" value="4111 1111 1111 1111" />
																	<!--end::Input-->
																	<!--begin::Card logos-->
																	<div class="position-absolute translate-middle-y top-50 end-0 me-5">
																		<img src="assets/media/svg/card-logos/visa.svg" alt="" class="h-25px" />
																		<img src="assets/media/svg/card-logos/mastercard.svg" alt="" class="h-25px" />
																		<img src="assets/media/svg/card-logos/american-express.svg" alt="" class="h-25px" />
																	</div>
																	<!--end::Card logos-->
																</div>
																<!--end::Input wrapper-->
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="row mb-10">
																<!--begin::Col-->
																<div class="col-md-8 fv-row">
																	<!--begin::Label-->
																	<label class="required fs-6 fw-semibold form-label mb-2">Expiration Date</label>
																	<!--end::Label-->
																	<!--begin::Row-->
																	<div class="row fv-row">
																		<!--begin::Col-->
																		<div class="col-6">
																			<select name="card_expiry_month" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Month">
																				<option></option>
																				<option value="1">1</option>
																				<option value="2">2</option>
																				<option value="3">3</option>
																				<option value="4">4</option>
																				<option value="5">5</option>
																				<option value="6">6</option>
																				<option value="7">7</option>
																				<option value="8">8</option>
																				<option value="9">9</option>
																				<option value="10">10</option>
																				<option value="11">11</option>
																				<option value="12">12</option>
																			</select>
																		</div>
																		<!--end::Col-->
																		<!--begin::Col-->
																		<div class="col-6">
																			<select name="card_expiry_year" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Year">
																				<option></option>
																				<option value="2022">2022</option>
																				<option value="2023">2023</option>
																				<option value="2024">2024</option>
																				<option value="2025">2025</option>
																				<option value="2026">2026</option>
																				<option value="2027">2027</option>
																				<option value="2028">2028</option>
																				<option value="2029">2029</option>
																				<option value="2030">2030</option>
																				<option value="2031">2031</option>
																				<option value="2032">2032</option>
																			</select>
																		</div>
																		<!--end::Col-->
																	</div>
																	<!--end::Row-->
																</div>
																<!--end::Col-->
																<!--begin::Col-->
																<div class="col-md-4 fv-row">
																	<!--begin::Label-->
																	<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
																		<span class="required">CVV</span>
																		<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Enter a card CVV code"></i>
																	</label>
																	<!--end::Label-->
																	<!--begin::Input wrapper-->
																	<div class="position-relative">
																		<!--begin::Input-->
																		<input type="text" class="form-control form-control-solid" minlength="3" maxlength="4" placeholder="CVV" name="card_cvv" />
																		<!--end::Input-->
																		<!--begin::CVV icon-->
																		<div class="position-absolute translate-middle-y top-50 end-0 me-3">
																			<!--begin::Svg Icon | path: icons/duotune/finance/fin002.svg-->
																			<span class="svg-icon svg-icon-2hx">
																				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																					<path d="M22 7H2V11H22V7Z" fill="currentColor" />
																					<path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19ZM14 14C14 13.4 13.6 13 13 13H5C4.4 13 4 13.4 4 14C4 14.6 4.4 15 5 15H13C13.6 15 14 14.6 14 14ZM16 15.5C16 16.3 16.7 17 17.5 17H18.5C19.3 17 20 16.3 20 15.5C20 14.7 19.3 14 18.5 14H17.5C16.7 14 16 14.7 16 15.5Z" fill="currentColor" />
																				</svg>
																			</span>
																			<!--end::Svg Icon-->
																		</div>
																		<!--end::CVV icon-->
																	</div>
																	<!--end::Input wrapper-->
																</div>
																<!--end::Col-->
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="d-flex flex-stack">
																<!--begin::Label-->
																<div class="me-5">
																	<label class="fs-6 fw-semibold form-label">Save Card for further billing?</label>
																	<div class="fs-7 fw-semibold text-muted">If you need more info, please check budget planning</div>
																</div>
																<!--end::Label-->
																<!--begin::Switch-->
																<label class="form-check form-switch form-check-custom form-check-solid">
																	<input class="form-check-input" type="checkbox" value="1" checked="checked" />
																	<span class="form-check-label fw-semibold text-muted">Save Card</span>
																</label>
																<!--end::Switch-->
															</div>
															<!--end::Input group-->
														</div>
														<!--end::Wrapper-->
													</div>
													<!--end::Step 4-->
													<!--begin::Step 5-->
													<div data-kt-stepper-element="content">
														<!--begin::Wrapper-->
														<div class="w-100">
															<!--begin::Heading-->
															<div class="pb-8 pb-lg-10">
																<!--begin::Title-->
																<h2 class="fw-bold text-dark">Your Are Done!</h2>
																<!--end::Title-->
																<!--begin::Notice-->
																<div class="text-muted fw-semibold fs-6">If you need more info, please
																<a href="../dist/authentication/sign-in/basic.html" class="link-primary fw-bold">Sign In</a>.</div>
																<!--end::Notice-->
															</div>
															<!--end::Heading-->
															<!--begin::Body-->
															<div class="mb-0">
																<!--begin::Text-->
																<div class="fs-6 text-gray-600 mb-5">Writing headlines for blog posts is as much an art as it is a science and probably warrants its own post, but for all advise is with what works for your great &amp; amazing audience.</div>
																<!--end::Text-->
																<!--begin::Alert-->
																<!--begin::Notice-->
																<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
																	<!--begin::Icon-->
																	<!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
																	<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
																			<rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
																			<rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																	<!--end::Icon-->
																	<!--begin::Wrapper-->
																	<div class="d-flex flex-stack flex-grow-1">
																		<!--begin::Content-->
																		<div class="fw-semibold">
																			<h4 class="text-gray-900 fw-bold">We need your attention!</h4>
																			<div class="fs-6 text-gray-700">To start using great tools, please, please
																			<a href="#" class="fw-bold">Create Team Platform</a></div>
																		</div>
																		<!--end::Content-->
																	</div>
																	<!--end::Wrapper-->
																</div>
																<!--end::Notice-->
																<!--end::Alert-->
															</div>
															<!--end::Body-->
														</div>
														<!--end::Wrapper-->
													</div>
													<!--end::Step 5-->
													<!--begin::Actions-->
													<div class="d-flex flex-stack pt-15">
														<!--begin::Wrapper-->
														<div class="mr-2">
															<button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
															<!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
															<span class="svg-icon svg-icon-4 me-1">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1" fill="currentColor" />
																	<path d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z" fill="currentColor" />
																</svg>
															</span>
															<!--end::Svg Icon-->Back</button>
														</div>
														<!--end::Wrapper-->
														<!--begin::Wrapper-->
														<div>
															<button type="button" class="btn btn-lg btn-primary me-3" data-kt-stepper-action="submit">
																<span class="indicator-label">Submit
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
																<span class="svg-icon svg-icon-3 ms-2 me-0">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
																		<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon--></span>
																<span class="indicator-progress">Please wait...
																<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
															</button>
															<button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">Continue
															<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
															<span class="svg-icon svg-icon-4 ms-1 me-0">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
																	<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
																</svg>
															</span>
															<!--end::Svg Icon--></button>
														</div>
														<!--end::Wrapper-->
													</div>
													<!--end::Actions-->
												</form>
												<!--end::Form-->
											</div>
											<!--end::Stepper-->




												
												<!--end::Card body-->
											</div>
                                        </div>
                                        <div class="col-md-4">
										
									   </div>
                                    </div>
									
							<div class="modal fade" tabindex="-1" id="kt_modal_2">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Reserve Chair</h3>

											<!--begin::Close-->
											<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
												<span class="svg-icon svg-icon-1"></span>
											</div>
											<!--end::Close-->
										</div>

										<div class="modal-body">
											
										<!--begin::solid autosize textarea-->
										<div class=" d-flex flex-column p-10">
											<label for="" class="form-label">Status</label>
											<input type="hidden" id="chair_id">
											<select class="form-control form-control form-control-solid" id="status" name="status" data-kt-autosize="true"/>
												<option>free</option>
												<option>reserved</option>
												<option>checkin</option>
											</select>
										</div>
										
									<!--end::solid autosize textarea-->

										</div>

										<div class="modal-footer">
											<button type="button" onclick="closebtn()"  class="btn btn-light" data-bs-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" onclick="update_chair_status()">Save changes</button>
										</div>
									</div>
								</div>
							</div>

							<div class="modal fade" tabindex="-1" id="kt_modal_3">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Reserve Table</h3>

											<!--begin::Close-->
											<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
												<span class="svg-icon svg-icon-1"></span>
											</div>
											<!--end::Close-->
										</div>

										<div class="modal-body">
										<div class=" d-flex flex-column p-10 d-none">
											<label for="" class="form-label">Title</label>
											<input class="form-control form-control form-control-solid " id="table_title" name="table_title" data-kt-autosize="true"/>
										</div>
										<!--begin::solid autosize textarea-->
										<div class=" d-flex flex-column p-10">
											<label for="" class="form-label">Status</label>
											<input type="hidden" id="table_id">
											<select class="form-control form-control form-control-solid" id="table_status" name="table_status" data-kt-autosize="true"/>
												<option>Free</option>
												<option>Reserved</option>
												<option>Check-in</option>
											</select>
										</div>
										
									<!--end::solid autosize textarea-->

										</div>

										<div class="modal-footer">
											<button type="button" onclick="closebtn()"  class="btn btn-light" data-bs-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" onclick="update_table_status()">Save changes</button>
										</div>
									</div>
								</div>
							</div>
								<script>
								var pre_html='';
								function get_tables(){
									
									
									$.ajax({
											type: 'POST',
											url: '<?php echo site_url("booking/get_tables_for_datetime"); ?>',
											data: { 'selected_date' : $('#kt_datepicker_1').val() },
											success: function(result){
												var difference = result.replace(/\s/g, '').localeCompare(pre_html.replace(/\s/g, ''));
											
												if(difference!=0){
													$('#containment-wrapper').html('');
													// console.log('result' , result.replace(/\s/g, ''));
													// console.log('pre_html' , pre_html.replace(/\s/g, ''));
													// console.log('update');
													$('#containment-wrapper').html(result);
													pre_html = result.replace(/\s/g, '');
													$('#total_free_span').html($('#total_free').val());
													$('#total_resereved_span').html($('#total_resereved').val());
													$('#total_checkedin_span').html($('#total_checkedin').val());

													total = parseInt($('#total_free').val()) + parseInt($('#total_resereved').val()) + parseInt($('#total_checkedin').val());
													part  = parseInt($('#total_resereved').val()) + parseInt($('#total_checkedin').val());
													var percentage = (part / total) * 100;
													percentage = percentage;
													$('#progressbar_span').html(percentage + '%');
													$('#progressbar').css( 'width'  ,  percentage + '%');
												}
												
												
											}
										}) 
								}
								get_tables();
								$('#kt_datepicker_1').change(function() {
									get_tables();
  									});

									  setInterval(function() {
										
										// Code to be executed every 5 seconds
										get_tables();
										}, 5000);

								function change_table_status(d){
									$('#kt_modal_3').show();
									$('#table_id').val($(d).attr('id'));
									$('#table_status').val($(d).data('status'));
									$('#table_title').val($(d).data('title'));

									
								}
								function change_chair_status(chair){
									$('#kt_modal_2').show();
									$('#chair_id').val(chair);
								}
								function add_table(){
										$('#kt_modal_1').show();
								}
								function closebtn(){
									
										$('.modal').css('display', 'none');
								}
								function update_table_status(){
									$.ajax({
											type: 'POST',
											url: '<?php echo site_url("booking/update_table_status"); ?>',
											data: { 'table_status' : $('#table_status').val() , 'table_id' :  $('#table_id').val() , 'table_title' :  $('#table_title').val() },
											success: function(result){
												
												show_feedback('success', <?php echo json_encode(lang('common_success')); ?>, <?php echo json_encode(lang('common_success')); ?>);
												setTimeout(function(){
												window.location.reload(1);
												}, 1000);
											}
										}) 
								}


								function update_chair_status(){
									$.ajax({
											type: 'POST',
											url: '<?php echo site_url("booking/update_chair_status"); ?>',
											data: { 'status' : $('#status').val() , 'chair_id' :  $('#chair_id').val()  },
											success: function(result){
												
												show_feedback('success', <?php echo json_encode(lang('common_success')); ?>, <?php echo json_encode(lang('common_success')); ?>);
												setTimeout(function(){
												window.location.reload(1);
												}, 1000);
											}
										}) 
								}
								


								
								
								
								

								</script>



								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<script type="text/javascript">
	$(document).ready(function() {

		$("#back_to_category").click();
		<?php if ($this->config->item('require_employee_login_before_each_sale') && isset($dont_switch_employee) && !$dont_switch_employee) { ?>
			$('#switch_user').trigger('click');
		<?php } ?>

		
		
		
		var current_category_id = null;
		var current_tag_id = null;
		var current_supplier_id = null;

		var categories_stack = [{
			category_id: 0,
			name: <?php echo json_encode(lang('common_all')); ?>
		}];

		function updateBreadcrumbs(item_name) {
			var breadcrumbs = '';
			for (var k = 0; k < categories_stack.length; k++) {
				var category_name = categories_stack[k].name;
				var category_id = categories_stack[k].category_id;

				breadcrumbs += (k != 0 ? '  ' : '') + '<a href="javascript:void(0);"class="category_breadcrumb_item btn btn-primary" data-category_id = "' + category_id + '">' + category_name + " 	&gt; </a>";
			}

			if (typeof item_name != "undefined" && item_name) {
				breadcrumbs += '  : ' + item_name;
			}

			$("#grid_breadcrumbs").html(breadcrumbs);
		}

		$(document).on('click', ".category_breadcrumb_item", function() {
			var clicked_category_id = $(this).data('category_id');
			var categories_size = categories_stack.length;
			current_category_id = clicked_category_id;

			for (var k = 0; k < categories_size; k++) {
				var current_category = categories_stack[k]
				var category_id = current_category.category_id;

				if (category_id == clicked_category_id) {
					if (categories_stack[k + 1] != undefined) {
						categories_stack.splice(k + 1, categories_size - k - 1);
					}
					break;
				}
			}

			if (current_category_id != 0) {
				loadCategoriesAndItems(current_category_id, 0);
			} else {
				loadTopCategories();
			}
		});

		function loadTopCategories() {
			$('#grid-loader').show();
			$.get('<?php echo site_url("booking/categories"); ?>', function(json) {
				processCategoriesResult(json);
			}, 'json');
		}

		function loadTags() {
			$('#grid-loader').show();
			$.get('<?php echo site_url("booking/tags"); ?>', function(json) {
				processTagsResult(json);
			}, 'json');
		}

		function loadSuppliers() {
			$('#grid-loader').show();
			$.get('<?php echo site_url("booking/suppliers"); ?>', function(json) {
				processSuppliersResult(json);
			}, 'json');
		}


		function loadCategoriesAndItems(category_id, offset) {
			$('#grid-loader').show();
			current_category_id = category_id;
			//Get sub categories then items
			$.get('<?php echo site_url("booking/categories_and_items"); ?>/' + current_category_id + '/' + offset, function(json) {
				processCategoriesAndItemsResult(json);
			}, "json");
		}

		function loadCategoriesAndItemsUrl(category_id, url) {
			$('#grid-loader').show();
			current_category_id = category_id;
			//Get sub categories then items
			$.get(url, function(json) {
				processCategoriesAndItemsResult(json);
			}, "json");
		}

		function loadTagItems(tag_id, offset) {
			$('#grid-loader').show();
			current_tag_id = tag_id;
			//Get sub categories then items
			$.get('<?php echo site_url("sales/tag_items"); ?>/' + tag_id + '/' + offset, function(json) {
				processTagItemsResult(json);
			}, "json");
		}

		function loadTagItemsUrl(tag_id, url) {
			$('#grid-loader').show();
			current_tag_id = tag_id;
			//Get sub categories then items
			$.get(url, function(json) {
				processTagItemsResult(json);
			}, "json");
		}

		function loadFavoriteItems(offset) {
			$('#grid-loader').show();
			//Get sub categories then items
			$.get('<?php echo site_url("sales/favorite_items"); ?>/' + offset, function(json) {
				processFavoriteItemsResult(json);
			}, "json");
		}

		function loadFavoriteItemsUrl(url) {
			$('#grid-loader').show();
			$.get(url, function(json) {
				processFavoriteItemsResult(json);
			}, "json");
		}

		function loadSupplierItem(supplier_id, offset) {
			$('#grid-loader').show();
			current_supplier_id = supplier_id;
			//Get sub categories then items
			$.get('<?php echo site_url("sales/supplier_items"); ?>/' + supplier_id + '/' + offset, function(json) {
				processSupplierItemsResult(json);
			}, "json");
		}

		function loadSupplierItemsUrl(supplier_id, url) {
			$('#grid-loader').show();
			current_supplier_id = supplier_id;
			//Get sub categories then items
			$.get(url, function(json) {
				processSupplierItemsResult(json);
			}, "json");
		}



		$(document).on('click', ".pagination.categories a", function(event) {
			$('#grid-loader').show();
			event.preventDefault();
			$.get($(this).attr('href'), function(json) {
				processCategoriesResult(json);

			}, "json");
		});

		$(document).on('click', ".pagination.tags a", function(event) {
			$('#grid-loader').show();
			event.preventDefault();

			$.get($(this).attr('href'), function(json) {
				processTagsResult(json);

			}, "json");
		});

		$(document).on('click', ".pagination.suppliers a", function(event) {
			$('#grid-loader').show();
			event.preventDefault();

			$.get($(this).attr('href'), function(json) {
				processSuppliersResult(json);

			}, "json");
		});

		$(document).on('click', ".pagination.categoriesAndItems a", function(event) {
			$('#grid-loader').show();
			event.preventDefault();
			loadCategoriesAndItemsUrl(current_category_id, $(this).attr('href'));
		});

		$(document).on('click', ".pagination.items a", function(event) {
			$('#grid-loader').show();
			event.preventDefault();
			loadTagItemsUrl(current_tag_id, $(this).attr('href'));
		});

		$(document).on('click', ".pagination.favorite a", function(event) {
			$('#grid-loader').show();
			event.preventDefault();
			loadFavoriteItemsUrl($(this).attr('href'));
		});

		$(document).on('click', ".pagination.supplierItems a", function(event) {
			$('#grid-loader').show();
			event.preventDefault();
			loadSupplierItemsUrl(current_supplier_id, $(this).attr('href'));
		});



		$('#category_item_selection_wrapper').on('click', '.category_item.category', function(event) {
			event.preventDefault();
			current_category_id = $(this).data('category_id');
			var category_obj = {
				category_id: current_category_id,
				name: $(this).find('p').text()
			};
			categories_stack.push(category_obj);
			loadCategoriesAndItems($(this).data('category_id'), 0);
		});

		$('#category_item_selection_wrapper').on('click', '.category_item.tag', function(event) {
			event.preventDefault();
			current_tag_id = $(this).data('tag_id');
			loadTagItems($(this).data('tag_id'), 0);
		});

		$('#category_item_selection_wrapper').on('click', '.category_item.supplier', function(event) {
			event.preventDefault();
			current_supplier_id = $(this).data('supplier_id');
			loadSupplierItem($(this).data('supplier_id'), 0);
		});
		

		$('#category_item_selection_wrapper').on('click', '#by_category', function(event) {
			current_category_id = null;
			current_tag_id = null;
			$("#grid_breadcrumbs").html('');
			$('.btn-grid').removeClass('active');
			$(this).addClass('active');
			categories_stack = [{
				category_id: 0,
				name: <?php echo json_encode(lang('common_all')); ?>
			}];
			loadTopCategories();
		});

		$('#category_item_selection_wrapper').on('click', '#by_tag', function(event) {
			current_category_id = null;
			current_tag_id = null;
			$('.btn-grid').removeClass('active');
			$(this).addClass('active');
			$("#grid_breadcrumbs").html('');
			loadTags();
		});

		$('#category_item_selection_wrapper').on('click', '#by_favorite', function(event) {
			current_category_id = null;
			current_tag_id = null;
			$('.btn-grid').removeClass('active');
			$(this).addClass('active');
			$("#grid_breadcrumbs").html('');
			loadFavoriteItems(0);
		});

		$('#category_item_selection_wrapper').on('click', '#by_supplier', function(event) {
			current_category_id = null;
			current_tag_id = null;
			current_supplier_id = null;
			$("#grid_breadcrumbs").html('');
			$('.btn-grid').removeClass('active');
			$(this).addClass('active');
			loadSuppliers();
		});


		$('#category_item_selection_wrapper').on('click', '.category_item.item', function(event) {
			$('#grid-loader').show();
			event.preventDefault();

			var $that = $(this);
			if ($(this).data('has-variations')) {
				$.getJSON('<?php echo site_url("sales/item_variations"); ?>/' + $(this).data('id'), function(json) {
					$("#category_item_selection").html('');
					$("#category_item_selection_wrapper .pagination").html('');

					if (current_category_id) {
						//var back_button = $("<div/>").attr('id', 'back_to_category').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');

						var	back_button = '<li id="back_to_category" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					} else if(current_supplier_id) {
						//var back_button = $("<div/>").attr('id', 'back_to_supplier').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');

						var	back_button = '<li id="back_to_supplier" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


					} else if ($that.data('is_favorite')) {
						//var back_button = $("<div/>").attr('id', 'back_to_favorite').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');

						var	back_button = '<li id="back_to_favorite" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

					} else {
					//	var back_button = $("<div/>").attr('id', 'back_to_tag').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');
						var	back_button = '<li id="back_to_tag" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					}

					

					$("#category_item_selection").append(back_button);

					for (var k = 0; k < json.length; k++) {
						var image_src = json[k].image_src;
						var prod_image = "";
						var image_class = "no-image";
						var item_parent_class = "";
						if (image_src != '') {
							var item_parent_class = "item_parent_class";
							var prod_image = '<img src="' + image_src + '" alt="" />';
							var image_class = "";
						}else{
							var item_parent_class = "item_parent_class";
							var prod_image = '<img src="' + SITE_URL + '/assets/css_good/media/icons/varient.png" alt="" />';
							var image_class = "";
						}
                          /// dynamic attributes for item:varients

					//	var item = $("<div/>").attr('data-has-variations', 0).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json[k].id).append(prod_image + '<p>' + json[k].name + '<br /> <span class="text-bold">' + (json[k].price ? '(' + json[k].price + ')' : '') + '</span></p>');
						

						var item = '<li data-has-variations="0" data-id="'+json[k].id+'" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-150px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' +json[k].name + ' <span class="text-bold">' + (json[k].price ? '(' + decodeHtml(json[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
						$("#category_item_selection").append(item);
						if (current_category_id) {
							updateBreadcrumbs($that.text());
						}
					}

					$('#grid-loader').hide();

				});
			} else {
				$.post('<?php echo site_url("booking/add"); ?>', {
					item: $(this).data('id') + "|FORCE_ITEM_ID|"
				}, function(response) {
					<?php
					if (!$this->config->item('disable_sale_notifications')) {
						echo "show_feedback('success', " . json_encode(lang('common_successful_adding')) . ", " . json_encode(lang('common_success')) . ");";
					}

					?>
					$('#grid-loader').hide();
					$("#register_container").html(response);
					$('.show-grid').addClass('hidden');
					$('.hide-grid').removeClass('hidden');
				});
			}
		});


		$('#category_item_selection_wrapper_new').on('click', '.category_item.item', function(event) {
			$('#grid-loader').show();
			event.preventDefault();

			var $that = $(this);
			if ($(this).data('has-variations')) {
				$.getJSON('<?php echo site_url("sales/item_variations"); ?>/' + $(this).data('id'), function(json) {
					$("#category_item_selection").html('');
					$("#category_item_selection_wrapper .pagination").html('');

					if (current_category_id) {
						//var back_button = $("<div/>").attr('id', 'back_to_category').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');

						var	back_button = '<li id="back_to_category" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					} else if(current_supplier_id) {
						//var back_button = $("<div/>").attr('id', 'back_to_supplier').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');

						var	back_button = '<li id="back_to_supplier" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


					} else if ($that.data('is_favorite')) {
						//var back_button = $("<div/>").attr('id', 'back_to_favorite').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');

						var	back_button = '<li id="back_to_favorite" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

					} else {
					//	var back_button = $("<div/>").attr('id', 'back_to_tag').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');
						var	back_button = '<li id="back_to_tag" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					}

					

					$("#category_item_selection").append(back_button);

					for (var k = 0; k < json.length; k++) {
						var image_src = json[k].image_src;
						var prod_image = "";
						var image_class = "no-image";
						var item_parent_class = "";
						if (image_src != '') {
							var item_parent_class = "item_parent_class";
							var prod_image = '<img src="' + image_src + '" alt="" />';
							var image_class = "";
						}else{
							var item_parent_class = "item_parent_class";
							var prod_image = '<img src="' + SITE_URL + '/assets/css_good/media/icons/varient.png" alt="" />';
							var image_class = "";
						}
                          /// dynamic attributes for item:varients

					//	var item = $("<div/>").attr('data-has-variations', 0).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json[k].id).append(prod_image + '<p>' + json[k].name + '<br /> <span class="text-bold">' + (json[k].price ? '(' + json[k].price + ')' : '') + '</span></p>');
						

						var item = '<li data-has-variations="0" data-id="'+json[k].id+'" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-150px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' +json[k].name + ' <span class="text-bold">' + (json[k].price ? '(' + decodeHtml(json[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
						$("#category_item_selection").append(item);
						if (current_category_id) {
							updateBreadcrumbs($that.text());
						}
					}

					$('#grid-loader').hide();

				});
			} else {
				$.post('<?php echo site_url("booking/add"); ?>', {
					item: $(this).data('id') + "|FORCE_ITEM_ID|"
				}, function(response) {
					<?php
					if (!$this->config->item('disable_sale_notifications')) {
						echo "show_feedback('success', " . json_encode(lang('common_successful_adding')) . ", " . json_encode(lang('common_success')) . ");";
					}

					?>
					$('#grid-loader').hide();
					$("#register_container").html(response);
					$('.show-grid').addClass('hidden');
					$('.hide-grid').removeClass('hidden');
				});
			}
		});


		$("#category_item_selection_wrapper").on('click', '#back_to_categories', function(event) {
			$('#grid-loader').show();
			event.preventDefault();

			//Remove element from stack
			categories_stack.pop();

			//Get current last element
			var back_category = categories_stack[categories_stack.length - 1];

			if (back_category.category_id != 0) {
				loadCategoriesAndItems(back_category.category_id, 0);
			} else {
				loadTopCategories();
			}
		});

		$("#category_item_selection_wrapper").on('click', '#back_to_tags', function(event) {
			$('#grid-loader').show();
			event.preventDefault();
			loadTags();
		});

		$("#category_item_selection_wrapper").on('click', '#back_to_tag', function(event) {
			$('#grid-loader').show();
			event.preventDefault();
			loadTagItems(current_tag_id, 0);
		});

		$("#category_item_selection_wrapper").on('click', '#back_to_category', function(event) {
			$('#grid-loader').show();
			event.preventDefault();

			//Get current last element
			var back_category = categories_stack[categories_stack.length - 1];

			if (back_category.category_id != 0) {
				loadCategoriesAndItems(back_category.category_id, 0);
			} else {
				loadTopCategories();
			}
		});

		$("#category_item_selection_wrapper").on('click', '#back_to_favorite', function(event) {
			$('#grid-loader').show();
			event.preventDefault();
			loadFavoriteItems(0);
		});

		$("#category_item_selection_wrapper").on('click', '#back_to_suppliers', function(event) {
			$('#grid-loader').show();
			event.preventDefault();
			loadSuppliers();
		});

		$("#category_item_selection_wrapper").on('click', '#back_to_supplier', function(event) {
			$('#grid-loader').show();
			event.preventDefault();
			loadSuppliersItems(current_supplier_id, 0);
		});



		function processCategoriesResult(json) {
			$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('tags').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('categories');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			$("#category_item_selection").html('');

			for (var k = 0; k < json.categories.length; k++) {
				var category_item = $("<div/>").attr('class', 'category_item category col-md-2 register-holder categories-holder col-sm-3 col-xs-6').css('background-color', json.categories[k].color).data('category_id', json.categories[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.categories[k].name + '</p>');

				if (json.categories[k].image_id) {
					category_item.css('background-color', 'white');
					category_item.css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.categories[k].image_id + '?timestamp=' + json.categories[k].image_timestamp + ')');
				}
			category_item = '<li data-category_id="'+json.categories[k].id+'" class=" col-2 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.categories[k].image_id + '?timestamp=' + json.categories[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


				$("#category_item_selection").append(category_item);
			}
			
			updateBreadcrumbs();
			$('#grid-loader').hide();
		}

		function processTagsResult(json) {
			$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('categories').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('tags');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			$("#category_item_selection").html('');

			for (var k = 0; k < json.tags.length; k++) {
				//var tag_item = $("<div/>").attr('class', 'category_item tag col-md-2 register-holder tags-holder col-sm-3 col-xs-6').data('tag_id', json.tags[k].id).append('<p> <i class="ion-ios-pricetag-outline"></i> ' + json.tags[k].name + '</p>');

				var tag_item = '<li data-tag_id="'+json.tags[k].id+'"  class=" col-1  category_item tag register-holder tags-holder  nav-item mb-3 me-3 me-lg-6" role="presentation"><div class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-4 active " data-bs-toggle="pill"  aria-selected="true" role="tab"><div class="nav-icon"><i class="ion-ios-pricetag-outline text-danger " style="font-size:60px"></i> </div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.tags[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></div></li>';

				$("#category_item_selection").append(tag_item);
			}

			$('#grid-loader').hide();
		}

		function processSuppliersResult(json) {
			$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('tags').removeClass('items').removeClass('categories').removeClass("supplierItems").addClass('suppliers');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			$("#category_item_selection").html('');

			for (var k = 0; k < json.suppliers.length; k++) {
				var supplier_item = $("<div/>").attr('class', 'category_item supplier col-md-2 register-holder categories-holder col-sm-3 col-xs-6').data('supplier_id', json.suppliers[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.suppliers[k].name + '</p>');

				if (json.suppliers[k].image_id) {
					supplier_item.css('background-color', 'white');
					supplier_item.css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.suppliers[k].image_id + '?timestamp=' + json.suppliers[k].image_timestamp + ')');
				}
				$("#category_item_selection").append(supplier_item);
			}
			$('#grid-loader').hide();
		}

		function processCategoriesAndItemsResult(json) {
			$("#category_item_selection").html('');
			$("#category_item_selection_wrapper_new").html('');

		var	back_to_categories_button = '<li id="back_to_categories" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

			$("#category_item_selection").append(back_to_categories_button);

			for (var k = 0; k < json.categories_and_items.length; k++) {
				if (json.categories_and_items[k].type == 'category') {
					// var category_item = $("<div/>").attr('class', 'category_item category col-md-2 register-holder categories-holder col-sm-3 col-xs-6').css('background-color', json.categories_and_items[k].color).css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.categories_and_items[k].image_id + '?timestamp=' + json.categories_and_items[k].image_timestamp + ')').data('category_id', json.categories_and_items[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.categories_and_items[k].name + '</p>');

					var category_item = '<li data-category_id="'+json.categories_and_items[k].id+'" class=" col-2 category_item category nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-150px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4 " alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.categories_and_items[k].image_id + '?timestamp=' + json.categories_and_items[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories_and_items[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


					$("#category_item_selection").append(category_item);
				} else if (json.categories_and_items[k].type == 'item') {
					var image_src = json.categories_and_items[k].image_src;
					var has_variations = json.categories_and_items[k].has_variations ? 1 : 0;

					var prod_image = "";
					var image_class = "no-image";
					var item_parent_class = "";
					if (image_src != '') {
						var item_parent_class = "item_parent_class";
						var prod_image = '<img class="rounded-3 mb-4 h-auto" src="' + image_src + '" alt="" />';
						var image_class = "has-image";
					}

					//  var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.categories_and_items[k].id).append(prod_image + '<p>' + json.categories_and_items[k].name + '<br /> <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>');

					//var item = '<li data-has-variations="'+has_variations+'" data-id="'+json.categories_and_items[k].id+'" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-150px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories_and_items[k].name + '  <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					//$("#category_item_selection").append(item);

					htm='<div class="col-sm-6  col-xxl-3 category_item item  register-holder ' + image_class + ' '+ item_parent_class +' " data-has-variations="'+has_variations+'"  data-id="'+json.categories_and_items[k].id+'" "><div class="card card-flush bg-white h-xl-100"><!--begin::Body--><div class="card-body text-center pb-5"><!--begin::Overlay--><div class="d-block overlay" ><!--begin::Image--><div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded mb-7" style="height: 266px;background-image:url('+image_src+')"></div><!--end::Image--><!--begin::Action--><div class="overlay-layer card-rounded bg-dark bg-opacity-25"><i class="bi  fs-2x text-white"></i></div><!--end::Action--></div><!--end::Overlay--><!--begin::Info--><div class="d-flex align-items-end flex-stack mb-1"><!--begin::Title--><div class="text-start"><span class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-4 d-block">' + json.categories_and_items[k].name + '</span><span class="text-gray-400 mt-1 fw-bold fs-6">Price</span></div><!--end::Title--><!--begin::Total--><span class="text-gray-600 text-end fw-bold fs-6">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span><!--end::Total--></div><!--end::Info--></div><!--end::Body--></div><!--end::Card widget 14--></div>';
					$("#category_item_selection_wrapper_new").append(htm);

				}
			}



			$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('items').removeClass('favorite').removeClass('suppliers').removeClass("supplierItems").addClass('categoriesAndItems');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			updateBreadcrumbs();
			$('#grid-loader').hide();

		}

		function processTagItemsResult(json) {
			$("#category_item_selection").html('');
			//var back_to_categories_button = $("<div/>").attr('id', 'back_to_tags').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back_to_tags')); ?> + '</p>');

			var	back_to_categories_button = '<li id="back_to_tags" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


			$("#category_item_selection").append(back_to_categories_button);

			for (var k = 0; k < json.items.length; k++) {
				var image_src = json.items[k].image_src;
				var has_variations = json.items[k].has_variations ? 1 : 0;
				var prod_image = "";
				var image_class = "no-image";
				var item_parent_class = "";
				if (image_src != '') {
					var item_parent_class = "item_parent_class";
					var prod_image = '<img src="' + image_src + '" alt="" />';
					var image_class = "";
				}

				// var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.items[k].id).append(prod_image + '<p>' + json.items[k].name + '<br /> <span class="text-bold">' + (json.items[k].price ? '(' + json.items[k].price + ')' : '') + '</span></p>');

				var item = '<li data-has-variations="'+has_variations+'" data-id="'+json.items[k].id+'" class=" col-1 category_item item  ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-150px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.items[k].name + ' <span class="text-bold">' + (json.items[k].price ? '(' + decodeHtml(json.items[k].price) + ')' : '') + '</span></p>   </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


				$("#category_item_selection").append(item);

			}

			$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('favorite').removeClass('suppliers').removeClass("supplierItems").addClass('items');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			$('#grid-loader').hide();
		}

		function processFavoriteItemsResult(json) {
			$("#category_item_selection").html('');
			for (var k = 0; k < json.items.length; k++) {
				var image_src = json.items[k].image_src;
				var has_variations = json.items[k].has_variations ? 1 : 0;
				var prod_image = "";
				var image_class = "no-image";
				var item_parent_class = "";
				if (image_src != '') {
					var item_parent_class = "item_parent_class";
					var prod_image = '<img src="' + image_src + '" alt="" />';
					var image_class = "";
				}

				var item = $("<div/>").attr('data-is_favorite', 'yes').attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.items[k].id).append(prod_image + '<p>' + json.items[k].name + '<br /> <span class="text-bold">' + (json.items[k].price ? '(' + json.items[k].price + ')' : '') + '</span></p>');

				
				$("#category_item_selection").append(item);

			}

			$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('favorite');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			$('#grid-loader').hide();
		}

		function processSupplierItemsResult(json) {
			$("#category_item_selection").html('');
			var back_to_categories_button = $("<div/>").attr('id', 'back_to_suppliers').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back_to_suppliers')); ?> + '</p>');
			$("#category_item_selection").append(back_to_categories_button);

			for (var k = 0; k < json.items.length; k++) {
				var image_src = json.items[k].image_src;
				var has_variations = json.items[k].has_variations ? 1 : 0;
				var prod_image = "";
				var image_class = "no-image";
				var item_parent_class = "";
				if (image_src != '') {
					var item_parent_class = "item_parent_class";
					var prod_image = '<img src="' + image_src + '" alt="" />';
					var image_class = "";
				}

				var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.items[k].id).append(prod_image + '<p>' + json.items[k].name + '<br /> <span class="text-bold">' + (json.items[k].price ? '(' + json.items[k].price + ')' : '') + '</span></p>');
				$("#category_item_selection").append(item);

			}

			$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('favorite').removeClass('suppliers').removeClass('items').addClass("supplierItems");
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			$('#grid-loader').hide();
		}


		<?php if ($this->config->item('default_type_for_grid') == 'tags') {  ?>
			<?php if($this->config->item('hide_tags_sales_grid') != 1 ){ ?>
				loadTags();
			<?php } ?>
		<?php } else if ($this->config->item('default_type_for_grid') == 'favorites') { ?>
			<?php if($this->config->item('hide_favorites_sales_grid') != 1 ){ ?>
				loadFavoriteItems(0);
			<?php } ?>
		<?php } else if ($this->config->item('default_type_for_grid') == 'suppliers') { ?>
			<?php if($this->config->item('hide_suppliers_sales_grid') != 1 ){ ?>
				loadSuppliers();
			<?php } ?>
		<?php } else { ?>
			<?php if($this->config->item('hide_categories_sales_grid') != 1 ){ ?>
				loadTopCategories();
			<?php } ?>
		<?php	} ?>
	});

	var last_focused_id = null;

	setTimeout(function() {
		$('#item').focus();
	}, 10);
</script>

<script type="text/javascript">
	//Keyboard events...only want to load once
	$(document).keyup(function(event) {
		var mycode = event.keyCode;

		//tab
		if (mycode == 9) {
			var $tabbed_to = $(event.target);

			if ($tabbed_to.hasClass('xeditable')) {
				$tabbed_to.trigger('click').editable('show');
			}
		}

	});

	$(document).keydown(function(event) {
		var mycode = event.keyCode;

		//F2
		if (mycode == 113) {
			$("#item").focus();
			return;
		}

		//F4
		if (mycode == 115) {
			event.preventDefault();
			$("#finish_sale_alternate_button").click();
			$("#finish_sale_button").click();
			return;
		}

		//F7
		if (mycode == 118) {
			event.preventDefault();
			$("#amount_tendered").focus();
			$("#amount_tendered").select();
			return;
		}

		//F8
		if (mycode == 119) {
			window.location = '<?php echo site_url('sales/suspended');?>';
			return;
		}

		//ESC
		if (mycode == 27) {
			event.preventDefault();
			$("#cancel_sale_button").click();
			return;
		}


	});
</script>

<script type="text/javascript">
var is_full_screen = false;
	function full_screen(){
		if(is_full_screen){
			$("#kt_app_header").show();
			$('#kt_app_sidebar').show();
			$('#kt_app_wrapper').removeAttr('style');
			is_full_screen = false;
		}else{
			$("#kt_app_header").hide();
			$('#kt_app_sidebar').hide();
			$('#kt_app_wrapper').attr('style' , 'margin-left:0px');
			is_full_screen = true;
		}
		
	}
	<?php
	if (isset($cash_in_register) && $cash_in_register && $this->config->item('cash_alert_low') !== NULL && $this->config->item('cash_alert_low') !== '' && $cash_in_register < $this->config->item('cash_alert_low')) {
		echo "show_feedback('warning', " . json_encode(lang('sales_cash_low') . ' (' . to_currency($this->config->item('cash_alert_low')) . ')') . ", " . json_encode(lang('common_warning')) . ",{timeOut: 10000});";
	}

	if (isset($cash_in_register) && $cash_in_register && $this->config->item('cash_alert_high') !== NULL && $this->config->item('cash_alert_high') !== '' && $cash_in_register > $this->config->item('cash_alert_high')) {
		echo "show_feedback('warning', " . json_encode(lang('sales_cash_high') . ' (' . to_currency($this->config->item('cash_alert_high')) . ')') . ", " . json_encode(lang('common_warning')) . ",{timeOut: 10000});";
	}

	if ($this->session->flashdata('error_if_total_is_zero')) {
		echo "show_feedback('warning', " . json_encode($this->session->flashdata('error_if_total_is_zero')) . ", " . json_encode(lang('common_warning')) . ",  {timeOut: 10000}  );";
	}

	?>
	
	
</script>

						<?php $this->load->view('partial/footer') ?>
						