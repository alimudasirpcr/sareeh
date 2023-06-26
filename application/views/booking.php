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
    <?php foreach(get_js_files() as $js_file) { ?>
    <script src="<?php echo base_url().$js_file['path'].'?'.ASSET_TIMESTAMP;?>" type="text/javascript" charset="UTF-8">
    </script>
    <?php } ?>
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
.table {
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

.table::after {
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
  position: absolute;
  width: 50px;
  height: 25px;
  border-radius: 0 0 50% 50%;
  background-color: gray;
}

.chair:nth-child(1) {
	left: -5px;
    top: 246px;
    transform: rotate(49deg);
}
<?php if($chairs==3): ?>

	.chair:nth-child(2) {
	left: 124px;
    top: 305px;
    transform: rotate(3deg);
}


.chair:nth-child(3) {
	right: -5px;
    transform: rotate(313deg);
    top: 248px;
}
<?php elseif($chairs==4): ?>
	.chair:nth-child(2) {
	left: 92px;
    top: 301px;
    transform: rotate(12deg);
}
.chair:nth-child(3) {
	left: 182px;
    transform: rotate(342deg);
    top: 297px;
}
.chair:nth-child(4) {
	right: -5px;
    transform: rotate(313deg);
    top: 248px;
}
<?php endif; ?>



<?php foreach($tablest as $tables){ ?>
		.table-square-<?php echo $tables['table']['id']; ?> {
			width: <?php echo calculateTableWidth(count($tables['chairs'])) ?>px;
			background: white;
			border-radius: 9px;
			height: 100px;
			margin: 0 auto;
			position: relative;
			color: #d9dee4;
			font-weight: 500;
		}
		.table-square-<?php echo $tables['table']['id']; ?>::before {
			content: "";
			position: absolute;
			border-radius: 10px 0px 0px 10px;
			height: 100%;
			width: 6px;
			left: 0px;
			background-color: <?php if($tables['table']['status']=='Free'){
				echo "#d9dee4";
			}elseif($tables['table']['status']=='Reserved'){
				echo "#ffc144";
			}else{
				echo "#0dc266";
			} ?>;
		}
		.chair-square-<?php echo $tables['table']['id']; ?> {
			position: absolute;
			width: 50px;
			height: 25px;
			border-radius: 0 0 50% 50%;
			
		}
		
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(1) {
			left: -44px;
			top: 35px;
			transform: rotate(90deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(2) {
			left: <?php echo calculatesecondchairposition(count($tables['chairs'])) ?>px;
			top: 35px;
			transform: rotate(270deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(3) {
			left: 26px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(4) {
			left: 26px;
			top: 104px;
			transform: rotate(0deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(5) {
			left: <?= 26 + 100 ?>px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(6) {
			left: <?= 26 + 100 ?>px;
			top: 104px;
			transform: rotate(0deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(7) {
			left: <?= 26 + 200 ?>px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(8) {
			left: <?= 26 + 200 ?>px;
			top: 104px;
			transform: rotate(0deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(9) {
			left: <?= 26 + 300 ?>px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(10) {
			left: <?= 26 + 300 ?>px;
			top: 104px;
			transform: rotate(0deg);
		}
 <?php } ?>


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
      cursor:move;      
      margin-bottom:20px;
  }

  #containment-wrapper {
      width: 1000px;
      height: 1000px;
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
										<button id="save" class="btn btn-primary" onclick="save()">Save Position</button>
										<button class="btn btn-info" onclick="add_table()">Add Table</button>
                                     
									</div>
                                        <div class="col-md-12">
                                        <div class="card card-flush h-xl-100 " style="background-color: #f2f5fa;">
										
												<!--begin::Card body-->
												<div class="card-body pt-2 pb-4 d-flex align-items-center">
											
												<div class="row w-100 mt-10 " id="containment-wrapper">
                                                            
                                                            <div class="col-4 draggable d-none">
                                                          
															  	

																<div class="table">
																	<div class="chair"></div>
																	<div class="chair"></div>
																	<div class="chair"></div>
																	<div class="chair"></div>
																</div>
                                                            </div>
															


															<?php foreach($tablest as $tablesd){ ?>


															<div  data-rotate="<?= ($tablesd['table']['rotate']=='')?'0':$tablesd['table']['rotate']; ?>" data-title="<?php echo $tablesd['table']['title'] ?>" data-status="<?php echo $tablesd['table']['status'] ?>"  ondblclick="change_table_status(this)" data-title="<?php echo $tablesd['table']['id'] ?>"  id="<?php echo $tablesd['table']['id'] ?>" data-left="<?php echo $tablesd['table']['pleft'] ?>" data-top="<?php echo $tablesd['table']['ptop'] ?>" class="  draggable col-<?= (count($tablesd['chairs']) >6)?6:4; ?> " style="position: absolute; left:<?php echo $tablesd['table']['pleft'] ?>; top:<?php echo $tablesd['table']['ptop'] ?>; transform: rotate(<?php echo $tablesd['table']['rotate'] ?>deg)">
															<div  class=" table-text">
															<span class="rotate"><i class="fas fa-redo"></i></span> <br>
															<?php echo $tablesd['table']['title'] ?>  <br>
																<?php echo $tablesd['table']['status'] ?> 
																
																</div>	
																
															<div class="table-square-<?php echo $tablesd['table']['id'] ?>">
																
																	<?php foreach( $tablesd['chairs'] as $chair ){ ?>
																			<div onclick="change_chair_status(<?php echo $chair['id'] ?>)" class="chair-square-<?php echo $tablesd['table']['id'] ?>" style="background-color: <?php if($chair['status']=='free'){
																		echo "#d9dee4";
																	}elseif($chair['status']=='reserved'){
																		echo "#ffc144";
																	}else{
																		echo "#0dc266";
																	} ?>;"></div>
																	<?php } ?>
																</div>
                                                            </div>
															<?php } ?>
															


															
                                                     </div>
												</div>
												<!--end::Card body-->
											</div>
                                        </div>
                                        <div class="col-md-4">
										
									   </div>
                                    </div>
									<div class="modal fade" tabindex="-1" id="kt_modal_1">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Add Table</h3>

											<!--begin::Close-->
											<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
												<span class="svg-icon svg-icon-1"></span>
											</div>
											<!--end::Close-->
										</div>

										<div class="modal-body">
											
										<!--begin::solid autosize textarea-->
										<div class=" d-flex flex-column p-10">
											<label for="" class="form-label">Title</label>
											<input class="form-control form-control form-control-solid" id="title" name="title" data-kt-autosize="true"/>
										</div>
										<div class=" d-flex flex-column p-10">
											<label for="" class="form-label">Chairs</label>
											<input min="1" max="10" class="form-control form-control form-control-solid" id="chairs" name="chairs" data-kt-autosize="true"/>
												<div class="text-danger " id="tbl_error" style="display: none;">Chairs must be between 1 and 10</div>
											</div>
									<!--end::solid autosize textarea-->

										</div>

										<div class="modal-footer">
											<button type="button" onclick="closebtn()"  class="btn btn-light" data-bs-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" onclick="add_table_action()">Save changes</button>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" tabindex="-1" id="kt_modal_2">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Change Status Chair</h3>

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
											<h3 class="modal-title">Change Status Table</h3>

											<!--begin::Close-->
											<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
												<span class="svg-icon svg-icon-1"></span>
											</div>
											<!--end::Close-->
										</div>

										<div class="modal-body">
										<div class=" d-flex flex-column p-10">
											<label for="" class="form-label">Title</label>
											<input class="form-control form-control form-control-solid" id="table_title" name="table_title" data-kt-autosize="true"/>
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
								$('.rotate').on('click', function() {
									
									let el = $(this);
								
									let transform = el.css("transform");
									let angle;
									
									if (el.parent().parent().data('rotate')=='') {
										angle = 0;
									} else {
										console.log('yes');
										angle =parseInt(el.parent().parent().data('rotate'));
										
									}

									// Normalizing the angle to be between 0 and 360
									angle = angle < 0 ? angle + 360 : angle;
									angle = (angle + 90) % 360;
								
									el.parent().parent().data('rotate' , angle  );
									//el.css({'transform': 'rotate(' + angle + 'deg)'});
									setTimeout(function(){
													el.parent().parent().data('title' , angle);
													console.log(el.parent().parent().data('title'));
												}, 1000);
									
									$(this).parent().parent().css('transform', 'rotate(' + angle + 'deg)');
								
								});

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
								function add_table_action(){
									$('#tbl_error').hide();
									if($('#chairs').val() > 0 && $('#chairs').val() < 11){
										$.ajax({
											type: 'POST',
											url: '<?php echo site_url("booking/add_table"); ?>',
											data: { 'title' : $('#title').val() , 'chairs' :  $('#chairs').val()  },
											success: function(result){
												
												show_feedback('success', <?php echo json_encode(lang('common_success')); ?>, <?php echo json_encode(lang('common_success')); ?>);
												setTimeout(function(){
												window.location.reload(1);
												}, 1000);
											}
										}) 
									}else{
										$('#tbl_error').show();
									}
									
								}


								$(document).on("ready", function(){
									$(".draggable").draggable({
										containment: "#containment-wrapper"
									});
								})

								$(document).on("mouseup", ".draggable", function(){

									var elem = $(this),
										id = elem.attr('id'),
										desc = elem.attr('data-desc'),
										pos = elem.position();
										elem.attr('data-left' , pos.left +'px' );
										elem.attr('data-top' , pos.top +'px' );
									console.log('Left: '+pos.left+'; Top:'+pos.top);

									transform =  elem.css("transform");
											console.log(transform);
											let values = transform.split('(')[1].split(')')[0].split(',');
											let a = values[0];
											let b = values[1];
											angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
											console.log(angle);
											elem.attr('data-rotate' , angle );
									
								});
								
								function save(){
									pos= [];
									$(".draggable").each(function(){
										var elem = $(this),
											id = elem.attr('id');
											newleft = elem.attr('data-left'),
											newtop = elem.attr('data-top');
											rotate = elem.attr('data-rotate');
											pos.push({'id':id, 'newleft': newleft, 'newtop':newtop , 'rotate':rotate})
									})
								
									$.ajax({
											type: 'POST',
											url: '<?php echo site_url("booking/save_position"); ?>',
											data: { 'tables' : JSON.stringify(pos)},
											success: function(result){
												show_feedback('success', <?php echo json_encode(lang('common_success')); ?>, <?php echo json_encode(lang('common_success')); ?>);
											}
										}) 

								}

								</script>



								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>


						<?php $this->load->view('partial/footer') ?>
						