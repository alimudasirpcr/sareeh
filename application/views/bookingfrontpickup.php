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
     var CONFIRM_CLONE = <?php echo json_encode(lang('confirm_clone')); ?>;
    var CONFIRM_IMAGE_DELETE = <?php echo json_encode(lang('confirm_image_delete')); ?>;
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
    COMMON_SUCCESS = <?php echo json_encode(lang('success')); ?>;
    COMMON_ERROR = <?php echo json_encode(lang('error')); ?>;

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

    $.fn.editable.defaults.emptytext = <?php echo json_encode(lang('empty')); ?>;
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
    top: 202%;
    left: 98%;
    line-height: 16px;
    height: 42px;
    width: 109%;
    font-weight: bold;
    color: black;
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
	width: 1400px;
    height: 783px;
    margin: 0 auto;
    border: 2px solid #ccc;
    padding: 10px;
    background-size: contain;
    position: relative;
  }
  .imagebg{
    background-image: url('<?php echo base_url() ?>assets/img/resturantplan.png');
	background-size: cover;
}
#toastr-container>.toastr-success{
	background-color: green;
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
											<div class="row bg-shoping-image-right" >
											
												<div class=" col-md-12 col-lg-2">
												<div class="mb-5">
												
														<label for="" class="form-label fw-bold fs-6">Type</label>
														<select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" name="payment_method" id="kt_ecommerce_edit_order_payment">
																
																<option <?php if($booking_type=='Dine In'){ echo "selected"; } ?> value="<?php echo base_url();?>booking/table">Dine In</option>
																<option <?php if($booking_type=='Pickup'){ echo "selected"; } ?> value="<?php echo base_url();?>booking/Pickup">Pickup</option>
																<option <?php if($booking_type=='Home Delivery'){ echo "selected"; } ?> value="<?php echo base_url();?>booking/HomeDelivery">Home Delivery</option>
															</select>
													</div>
													</div>
													<div class="col-md-12 col-lg-2">
													<div class="mb-5">
													<label class="form-label fw-bold fs-6">Date Time</label>
														<input class="form-control flatpickr-input" placeholder="Pick date" id="kt_datepicker_1" type="text" readonly="readonly">
													</div>

												</div>

														<script>
																	$(document).ready(function() {
																		$('#kt_ecommerce_edit_order_payment').on('select2:select', function (e) {
        var url = $(this).val(); // Get selected value (in this case it's a URL)
        
        // Redirect to the selected URL
        window.location.href = url;
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
												
													
											</div>

										

											
																
										</div>
										
									</div>
                                     
									</div>
                                        <div class="col-md-12">
                                        <div class="card card-flush h-xl-100 " style="background-color: #f2f5fa;">
										
												<!--begin::Card body-->
												<div class="card-body pt-2 pb-4 d-flex align-items-center w-xl-100">
											

												<!--begin::Stepper-->
											<div class="stepper stepper-links d-flex flex-column pt-10 w-xl-100" id="kt_create_account_stepper_pickup">
												<!--begin::Nav-->
												<div class="stepper-nav mb-5 bg-white rounded ">
													
													<!--begin::Step 1-->
													<div class="stepper-item" data-kt-stepper-element="nav">
														<h3 class="stepper-title">Menu</h3>
													</div>
													<!--end::Step 1-->
													<!--begin::Step 2-->
													<div class="stepper-item" data-kt-stepper-element="nav">
														<h3 class="stepper-title">User Details</h3>
													</div>
													<!--end::Step 2-->
													<!--begin::Step 4-->
													<div class="stepper-item" data-kt-stepper-element="nav">
														<h3 class="stepper-title">Completed</h3>
													</div>
													<!--end::Step 4-->

															</div>
															<div> <h3 class="stepper-title order-history btn btn-primary pull-right mb-4">Order History</h3></div>
									
												<!--end::Nav-->
												<!--begin::Form-->
												<div class="order-history-view " style="display: none;">
													
												</div>
												<form class="mx-auto  w-100  pb-10 kt_create_account_form_pickup" novalidate="novalidate" id="kt_create_account_form_pickup" action="<?php echo site_url("booking/add_booking"); ?>">
													
												
													<!--begin::Step 1-->
													<div class="current" data-kt-stepper-element="content">
														<!--begin::Wrapper-->
														<div class="w-100">
														
															<div class="row">
																<div class="col-md-9">
																<div class="mb-10 fv-row">
																<input type="hidden" value="<?php echo $booking_type; ?>" name="delivery_type">
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
																					<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'tags' ? 'btn active' : ''; ?> btn btn-grid btn-danger" id="by_tag"><?php echo lang('tags') ?></a>
																					<?php }
																					if($this->config->item('hide_suppliers_sales_grid') != 1 ){ ?>
																					<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'suppliers' ? 'btn active' : ''; ?> btn btn-grid btn-info" id="by_supplier"><?php echo lang('suppliers') ?></a>
																					<?php }
																					if($this->config->item('hide_favorites_sales_grid') != 1 ){ ?>
																					<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'favorites' ? 'btn active' : ''; ?> btn btn-grid btn-primary" id="by_favorite"><?php echo lang('favorite') ?></a>
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
																	<th class="item_sort_able  text-dark item_name_heading <?php echo $this->cart->sort_column && $this->cart->sort_column == 'name'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('sales_item_name'); ?></th>
																	<th class="item_sort_able sales_price <?php echo $this->cart->sort_column && $this->cart->sort_column == 'unit_price'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('price'); ?></th>
																	<th class="item_sort_able sales_quantity  text-dark<?php echo $this->cart->sort_column && $this->cart->sort_column == 'quantity'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('quantity'); ?></th>
																	<th class="item_sort_able sales_discount <?php echo $this->cart->sort_column && $this->cart->sort_column == 'discount'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('discount_percent'); ?></th>
																	<th class="item_sort_able sales_total <?php echo $this->cart->sort_column && $this->cart->sort_column == 'total'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('total'); ?></th>
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
																				<h3><?php echo lang('no_items_in_cart'); ?><span class="flatGreenc"> [<?php echo lang('module_sales') ?>]</span></h3>
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

																		if ($item->quantity > 0 && $item->name != lang('store_account_payment') && $item->name != lang('discount')) {
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
																					
																					<a tabindex="-1" href="<?php echo isset($item->item_id) ? site_url('home/view_item_modal/' . $item->item_id) . "?redirect=sales" : site_url('home/view_item_kit_modal/' . $item->item_kit_id) . "?redirect=sales"; ?>" data-target="#kt_drawer_general" data-target-title="<?= lang('view_item') ?>"  data-target-width="xl" class="register-item-name"><?php echo H($item->name).(property_exists($item, 'variation_name') && $item->variation_name ? '<span class="show-collpased" style="display:none">  ['.$item->variation_name.']</span>' : '') ?><?php echo $item->size ? ' (' . H($item->size) . ')' : ''; ?></a>
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
													<!--end::Step 1-->
													<!--begin::Step 2-->
													<div data-kt-stepper-element="content">
														<!--begin::Wrapper-->
														<div class="w-100">
															<!--begin::Heading-->
															<div class="pb-10 pb-lg-12">
																<!--begin::Title-->
																<h2 class="fw-bold text-dark">User Details</h2>
																<!--end::Title-->
																<div class="rounded border p-10">
																	<div class=" row">
																		<div class=" col-md-6 fv-row">
																			
																				<label class="form-label">First Name</label>
																				<input type="text" class="form-control"
																				name="first_name" placeholder="First Name">
																			
																		</div>

																		<div class=" col-md-6 fv-row">
																			
																				<label class="form-label">Last Name</label>
																				<input type="text" 
																				name="last_name" class="form-control" placeholder="Last Name">
																			
																		</div>
																		<div class=" col-md-6 fv-row">
																			
																				<label class="form-label">Email</label>
																				<input type="text" 
																				name="email" class="form-control" placeholder="Email" id="email">
																			
																		</div>
																		<div class=" col-md-6 fv-row">
																			
																				<label class="form-label">Phone</label>
																				<input type="text" 
																				name="phone" class="form-control" placeholder="Phone">
																			
																		</div>
																		<div class=" col-md-6 fv-row">
																			
																				<label class="form-label">Address</label>
																				<input type="text" 
																				name="address" class="form-control" placeholder="Address">
																			
																		</div>
																	</div>
																</div>
																
																
															</div>
															<!--end::Heading-->

															
														</div>
														<!--end::Wrapper-->
													</div>
													<!--end::Step 2-->
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
																<div class="text-muted fw-semibold fs-6">If you want to view history please cick
																
																<h3 class="stepper-title order-history link-primary fw-bold">Order History</h3>.
																</div>
																<!--end::Notice-->
															</div>
															<!--end::Heading-->
															<!--begin::Body-->
															<div class="mb-0">
																<!--begin::Text-->
																<div class="fs-6 text-gray-600 mb-5">Please wait we will back to you soon. </div>
																<!--end::Text-->
																
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
									
						



								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>


						<div class="modal fade" tabindex="-1" id="kt_modal_thank">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Thanks for payment</h3>

											<!--begin::Close-->
											<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
												<span class="svg-icon svg-icon-1"></span>
											</div>
											<!--end::Close-->
										</div>

										<div class="modal-body">
											
											<img class="w-100" src="<?php echo base_url();?>assets/css_good/media/thanks.gif">
													

										</div>

										<div class="modal-footer">
											<button type="button" onclick="closebtn()"  class="btn btn-light" data-bs-dismiss="modal">Ok</button>
											
										</div>
									</div>
								</div>
							</div>


						<script type="text/javascript">
    
											
						function cancel_order(id ,t){
							$(t).remove();
							$.ajax({
											type: 'POST',
											url: '<?php echo site_url("booking/change_status"); ?>',
											data: { 'id' : id , status:'Cancel' },
											success: function(result){
											}
							});
						}
						function resume_order(id , t){
							$(t).remove();
							$.ajax({
											type: 'POST',
											url: '<?php echo site_url("booking/change_status"); ?>',
											data: { 'id' : id , status:'New' },
											success: function(result){
											}
							});
						}
						<?php if(isset($_GET['success'])): ?>
								$('#kt_modal_thank').show();
								
								<?php endif; ?>
								function closebtn(){
									
									$('.modal').css('display', 'none');
							}
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
			name: <?php echo json_encode(lang('all')); ?>
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
				name: <?php echo json_encode(lang('all')); ?>
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
						//var back_button = $("<div/>").attr('id', 'back_to_category').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');

						var	back_button = '<li id="back_to_category" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					} else if(current_supplier_id) {
						//var back_button = $("<div/>").attr('id', 'back_to_supplier').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');

						var	back_button = '<li id="back_to_supplier" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


					} else if ($that.data('is_favorite')) {
						//var back_button = $("<div/>").attr('id', 'back_to_favorite').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');

						var	back_button = '<li id="back_to_favorite" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

					} else {
					//	var back_button = $("<div/>").attr('id', 'back_to_tag').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');
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
						echo "show_feedback('success', " . json_encode(lang('successful_adding')) . ", " . json_encode(lang('success')) . ");";
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
						//var back_button = $("<div/>").attr('id', 'back_to_category').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');

						var	back_button = '<li id="back_to_category" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					} else if(current_supplier_id) {
						//var back_button = $("<div/>").attr('id', 'back_to_supplier').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');

						var	back_button = '<li id="back_to_supplier" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


					} else if ($that.data('is_favorite')) {
						//var back_button = $("<div/>").attr('id', 'back_to_favorite').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');

						var	back_button = '<li id="back_to_favorite" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

					} else {
					//	var back_button = $("<div/>").attr('id', 'back_to_tag').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back')); ?> + '</p>');
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
						echo "show_feedback('success', " . json_encode(lang('successful_adding')) . ", " . json_encode(lang('success')) . ");";
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
			if(json.categories[k].color !=''){
				category_style ="style='background-color:"+json.categories[k].color+" '";
			}else{
				category_style="";
			}

			category_item = '<li data-category_id="'+json.categories[k].id+'" class=" col-2 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation" '+category_style+'><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.categories[k].image_id + '?timestamp=' + json.categories[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


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
					}else{
						image_src = '' + SITE_URL + '/assets/css_good/media/placeholder.png';
					}

					//  var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.categories_and_items[k].id).append(prod_image + '<p>' + json.categories_and_items[k].name + '<br /> <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>');

					//var item = '<li data-has-variations="'+has_variations+'" data-id="'+json.categories_and_items[k].id+'" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-150px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories_and_items[k].name + '  <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					//$("#category_item_selection").append(item);

					htm='<div class="col-sm-2  col-xxl-2 category_item item  register-holder mb-2 ' + image_class + ' '+ item_parent_class +' " data-has-variations="'+has_variations+'"  data-id="'+json.categories_and_items[k].id+'" "><div class="card card-flush bg-white h-xl-100"><!--begin::Body--><div class="card-body text-center pb-5"><!--begin::Overlay--><div class="d-block overlay" ><!--begin::Image--><div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded mb-7" style="height: 90px;background-image:url('+image_src+')"></div><!--end::Image--><!--begin::Action--><div class="overlay-layer card-rounded bg-dark bg-opacity-25"><i class="bi  fs-2x text-white"></i></div><!--end::Action--></div><!--end::Overlay--><!--begin::Info--> <span class="fw-bold text-gray-800 cursor-pointer text-left text-hover-primary fs-6 d-block">' + json.categories_and_items[k].name + '</span><div class="d-flex align-items-end flex-stack mb-1"><!--begin::Title--><div class="text-start"><span class="text-gray-400 mt-1 fw-bold fs-6">Price</span></div><!--end::Title--><!--begin::Total--><span class="text-gray-600 text-end fw-bold fs-6">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span><!--end::Total--></div><!--end::Info--></div><!--end::Body--></div><!--end::Card widget 14--></div>';
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
			//var back_to_categories_button = $("<div/>").attr('id', 'back_to_tags').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back_to_tags')); ?> + '</p>');

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

				 //var item = $("<div/>").attr('data-is_favorite', 'yes').attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.items[k].id).append(prod_image + '<p>' + json.items[k].name + '<br /> <span class="text-bold">' + (json.items[k].price ? '(' + json.items[k].price + ')' : '') + '</span></p>');
				
				var item = '<li data-id="'+json.items[k].id+'" data-is_favorite="yes" data-has-variations="'+has_variations+'" class=" col-2 category_item item no-image register-holder ' + image_class + '   '+item_parent_class+' nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-150px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="'+image_src+'"></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.items[k].name + ' <br /> <span class="text-bold">' + (json.items[k].price ? '(' + json.items[k].price + ')' : '') + '</span></p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
				//'<div data-is_favorite="yes" data-has-variations="0" class="category_item item col-md-2 register-holder  col-sm-3 col-xs-6  item_parent_class" data-id="1"><img src="http://localhost/sareeh/app_files/view_cacheable/10?timestamp=1683183130" alt=""><p>Food <br> <span class="text-bold">($952.00)</span></p></div>'

				
				$("#category_item_selection").append(item);

			}

			$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('favorite');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			$('#grid-loader').hide();
		}

		function processSupplierItemsResult(json) {
			$("#category_item_selection").html('');
			var back_to_categories_button = $("<div/>").attr('id', 'back_to_suppliers').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back_to_suppliers')); ?> + '</p>');
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


	var pre_html='';
								function get_orders(){
								
									
									var storedEmail = localStorage.getItem("email");
									if($('.order-history-view').html().replace(/\s/g, '')!=''){
										var pre_html = localStorage.getItem("pre_html") || '';
									}else{
										var pre_html='';
									}
									$.ajax({
											type: 'POST',
											url: '<?php echo site_url("booking/load_order_list"); ?>',
											data: { 'storedEmail' : storedEmail },
											success: function(result){
												var current_html = result.replace(/\s/g, '');
    											if (pre_html !== current_html) {
													
													pre_html = current_html;
													localStorage.setItem('pre_html', pre_html); // Store the new HTML content in local storage
													$('.order-history-view').html('');
													$('.order-history-view').html(result);
													

													


														$('.remaing_time').each(function() {
															var id = $(this).data('id');
															var totalTime = $(this).data('totaltime');
															var storedTime = localStorage.getItem('totaltime-' + id);

															if (storedTime != totalTime) {
																console.log('storedTime='+storedTime+'totalTime='+totalTime+'id='+id);
															// Update local storage
															localStorage.setItem('totaltime-' + id, totalTime);
															var endTimeKey = 'end_time_' + id;
															 localStorage.setItem(endTimeKey , '');
															// Update the countdown or do something else if there's a change
															// ...
															}
														});

														startCountdown();
													
												}
												
											}
										}) 
								}
								get_orders();

                                setInterval(function() {
									get_orders();
								}, 5000);
								function startCountdown() {
										$('.remaing_time').each(function() {
											var countdownContainer = $(this);
											var dataId = countdownContainer.data('id');
											var totalTime = countdownContainer.data('totaltime') * 60 * 1000; // Convert minutes to milliseconds
											console.log(totalTime);
											var endTimeKey = 'end_time_' + dataId;
											var endTime = localStorage.getItem(endTimeKey) || new Date().getTime() + totalTime;
											localStorage.setItem(endTimeKey, endTime);

											var intervalId = setInterval(function() {
											var now = new Date().getTime();
											var distance = endTime - now;

											var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
											var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
											var seconds = Math.floor((distance % (1000 * 60)) / 1000);
											if(hours < 1)
											{
												countdownContainer.text(minutes + "m " + seconds + "s ");
											}else{
												countdownContainer.text(hours + "h " + minutes + "m " + seconds + "s ");
											}
								
											

											if (distance < 0) {
												clearInterval(intervalId);
												countdownContainer.html('<span class="badge badge-success">READY</span>');
											}
											}, 1000);
										});
										}


								$(document).ready(function () {
									$('.remaing_time').each(function() {
														
													var id = $(this).data('id');
													console.log(id);
													var storedTime = localStorage.getItem('totaltime-' + id);
													if (storedTime) {
														$(this).attr('data-totaltime', storedTime);
													}
													});

													startCountdown();
								});

</script>


<script type="text/javascript">
// When an element with the 'order-history' class is clicked...
$('.order-history').click(function() {
    // Show elements with the 'order-history-view' class...
    $('.order-history-view').show();
    // And hide elements with the 'kt_create_account_form_pickup' class.
    $('.kt_create_account_form_pickup').hide();
});

// When an element with the 'stepper-item' class is clicked...
$('.stepper-item').click(function() {
    // Show elements with the 'kt_create_account_form_pickup' class...
    $('.kt_create_account_form_pickup').show();
    // And hide elements with the 'order-history-view' class.
    $('.order-history-view').hide();
});
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
		echo "show_feedback('warning', " . json_encode(lang('sales_cash_low') . ' (' . to_currency($this->config->item('cash_alert_low')) . ')') . ", " . json_encode(lang('warning')) . ",{timeOut: 10000});";
	}

	if (isset($cash_in_register) && $cash_in_register && $this->config->item('cash_alert_high') !== NULL && $this->config->item('cash_alert_high') !== '' && $cash_in_register > $this->config->item('cash_alert_high')) {
		echo "show_feedback('warning', " . json_encode(lang('sales_cash_high') . ' (' . to_currency($this->config->item('cash_alert_high')) . ')') . ", " . json_encode(lang('warning')) . ",{timeOut: 10000});";
	}

	if ($this->session->flashdata('error_if_total_is_zero')) {
		echo "show_feedback('warning', " . json_encode($this->session->flashdata('error_if_total_is_zero')) . ", " . json_encode(lang('warning')) . ",  {timeOut: 10000}  );";
	}

	?>
	
	
</script>

						<?php $this->load->view('partial/footer') ?>
						