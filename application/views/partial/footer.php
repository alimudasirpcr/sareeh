</div>  </div>
			</div>
			<!--begin::Footer-->
			<div id="kt_app_footer" class="app-footer">
							<!--begin::Footer container-->
							<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
								<!--begin::Copyright-->
								<div class="text-dark order-2 order-md-1 hidden-print d-none">
								<?php echo lang('please_visit_my'); ?>
			<a tabindex="-1" href="http://<?php echo $this->config->item('branding')['domain']; ?>" target="_blank"><?php echo lang('website'); ?></a> <?php echo lang('learn_about_project'); ?>.
			<span class="text-info"><?php echo lang('you_are_using_phppos') ?> <span class="badge bg-primary"> <?php echo APPLICATION_VERSION; ?></span></span> <?php echo lang('built_on') . ' ' . BUILT_ON_DATE; ?>
									<span class="text-muted fw-semibold me-1">2023©</span>
									<a href="<?php  echo base_url(); ?>" target="_blank" class="text-gray-800 text-hover-primary">Sareeh App</a>
								</div>
								<!--end::Copyright-->
								
							</div>
							<!--end::Footer container-->
						</div>
						<!--end::Footer-->
					</div>
					<!--end:::Main-->
				</div>
	</div>
	<!---content -->
</div> <!-- wrapper -->
<div class="modal fade" tabindex="-1" id="pay_now" >
                                <div class="modal-dialog modal-xl"   id="pay_now_content">
								

										
								</div>
</div>
<div class="modal fade" tabindex="-1" id="quick_access">
                                <div class="modal-dialog">
                                    <form id="formdataquick" class="modal-content" method="post" action="<?php echo base_url() ?>home/save_quick_access">
                                        <div class="modal-header">
											 <!--begin::Close-->
											 <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-dismiss="modal" aria-label="Close">
                                                <span class="svg-icon svg-icon-1">x</span>
                                            </div>
                                            <!--end::Close-->


                                            <h3 class="modal-title"><?php echo lang('set_quick_access')?></h3>

                                           
                                        </div>

                                        <div class="modal-body">
										<?php 
                                    $quick_access = array();
									if(get_quick_access()):
										$quick_access = get_quick_access();
							?>

							<?php endif; ?>

							<?php  
					$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;


					?>
							<div class="row">
							 <?php if($this->Employee->has_module_permission('sales', $employee_id)): ?>
								<div class="col-md-6">
									<div class="form-check form-check-custom form-check-solid">
										<input <?php if(in_array('pos' , $quick_access)): ?> checked <?php endif; ?> class="form-check-input quick_access" type="checkbox" value="pos" name="items[]" id="flexCheckDefault"/>
										<label class="form-check-label" for="flexCheckDefault">
											<?php echo lang('pos')?>
										</label>
									</div>
								</div>
								<?php endif; ?>
								<?php if($this->Employee->has_module_permission('items', $employee_id)): ?>
								<div class="col-md-6">
									<div class="form-check form-check-custom form-check-solid">
										<input <?php if(in_array('items' , $quick_access)): ?> checked <?php endif; ?> class="form-check-input quick_access" type="checkbox" value="items" name="items[]" id="flexCheckDefault"/>
										<label class="form-check-label" for="flexCheckDefault">
										<?php echo lang('items')?>
										</label>
									</div>
								</div>
								<?php endif; ?>
								<?php if($this->Employee->has_module_permission('receivings', $employee_id)): ?>
								<div class="col-md-6">
									<div class="form-check form-check-custom form-check-solid">
											<input <?php if(in_array('receivings' , $quick_access)): ?> checked <?php endif; ?> class="form-check-input quick_access" type="checkbox" value="receivings" name="items[]" id="flexCheckDefault"/>
											<label class="form-check-label" for="flexCheckDefault">
											<?php echo lang('receivings')?>
											</label>
										</div>
								</div>


								<div class="col-md-6">
									<div class="form-check form-check-custom form-check-solid">
											<input <?php if(in_array('transfer' , $quick_access)): ?> checked <?php endif; ?> class="form-check-input quick_access" type="checkbox" value="transfer" name="items[]" id="flexCheckDefault"/>
											<label class="form-check-label" for="flexCheckDefault">
											<?php echo lang('transfer')?>
											</label>
										</div>
								</div>
								<?php endif; ?>
								<?php if($this->Employee->has_module_permission('customers', $employee_id)): ?>
								<div class="col-md-6">
									<div class="form-check form-check-custom form-check-solid">
										<input <?php if(in_array('customers' , $quick_access)): ?> checked <?php endif; ?> class="form-check-input quick_access" type="checkbox" value="customers" name="items[]" id="flexCheckDefault"/>
										<label class="form-check-label" for="flexCheckDefault">
										<?php echo lang('customers')?>
										</label>
									</div>
								</div>
								<?php endif; ?>
								<?php if($this->Employee->has_module_permission('work_orders', $employee_id)): ?>
								<div class="col-md-6">
									<div class="form-check form-check-custom form-check-solid">
										<input <?php if(in_array('work_orders' , $quick_access)): ?> checked <?php endif; ?> class="form-check-input quick_access" type="checkbox" value="work_orders" name="items[]" id="flexCheckDefault"/>
										<label class="form-check-label" for="flexCheckDefault">
										<?php echo lang('work_orders')?>
										</label>
									</div>
								</div>
								<?php endif; ?>

								<?php if($this->Employee->has_module_permission('deliveries', $employee_id)): ?>
								<div class="col-md-6">
									<div class="form-check form-check-custom form-check-solid">
										<input <?php if(in_array('deliveries' , $quick_access)): ?> checked <?php endif; ?> class="form-check-input quick_access" type="checkbox" value="deliveries" name="items[]" id="flexCheckDefault"/>
										<label class="form-check-label" for="flexCheckDefault">
										<?php echo lang('deliveries')?>
										</label>
									</div>
								</div>
								<?php endif; ?>

								<?php if($this->Employee->has_module_permission('suppliers', $employee_id)): ?>
								<div class="col-md-6">
									<div class="form-check form-check-custom form-check-solid">
										<input <?php if(in_array('suppliers' , $quick_access)): ?> checked <?php endif; ?> class="form-check-input quick_access" type="checkbox" value="suppliers" name="items[]" id="flexCheckDefault"/>
										<label class="form-check-label" for="flexCheckDefault">
										<?php echo lang('suppliers')?>
										</label>
									</div>
								</div>
								<?php endif; ?>



								<?php if ($this->Employee->has_module_action_permission('receivings', 'list', $employee_id)) : ?>
								<div class="col-md-6">
									<div class="form-check form-check-custom form-check-solid">
										<input <?php if(in_array('receivings_list' , $quick_access)): ?> checked <?php endif; ?> class="form-check-input quick_access" type="checkbox" value="receivings_list" name="items[]" id="flexCheckDefault"/>
										<label class="form-check-label" for="flexCheckDefault">
										<?php echo lang('receivings_list')?>
										</label>
									</div>
								</div>
								<?php endif; ?>

								<?php if($this->Employee->has_module_permission('sales', $employee_id)): ?>
								<div class="col-md-6">
									<div class="form-check form-check-custom form-check-solid">
										<input <?php if(in_array('sales_list' , $quick_access)): ?> checked <?php endif; ?> class="form-check-input quick_access" type="checkbox" value="sales_list" name="items[]" id="flexCheckDefault"/>
										<label class="form-check-label" for="flexCheckDefault">
										<?php echo lang('sales_list')?>
										</label>
									</div>
								</div>
								<?php endif; ?>
							</div>
											
											
											

											

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal"><?php echo lang('close')?></button>
                                            <button type="submit" id="save_quick_access" class="btn btn-primary"><?php echo lang('save_changes')?></button>
                                        </div>
</form>
                                </div>
                            </div>
</body>
<?php
if (($this->uri->segment(1) == 'sales' || $this->uri->segment(1) == 'receivings')) {
?>
	<script>
		function getBodyScrollTop() {
			var el = document.scrollingElement || document.documentElement;

			return el.scrollTop;
		}

		$(window).on("beforeunload", function() {

			var scroll_top =
				$.ajax(<?php echo json_encode(site_url('home/save_scroll')); ?>, {
					async: false,
					data: {
						scroll_to: getBodyScrollTop()
					}
				});
		});
	</script>
	<?php
	if ($this->session->userdata('scroll_to')) {
	?>
		<script>
			$([document.documentElement, document.body]).animate({
				scrollTop: <?php echo json_encode($this->session->userdata('scroll_to')); ?>
			}, 100);
		</script>
<?php
		$this->session->unset_userdata('scroll_to');
	}
}
?>

<script>
$(document).ready(function(){

	
	$('#pay_now').on('hidden.bs.modal', function (e) {

		

		$.ajax({
                                    url: '<?php echo site_url('sales/clear_sale'); ?>',
                                    type: 'POST',
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                            
                                        },
                                        error: function(xhr, status, error) {
                                            // Handle any errors that occur during the AJAX request
                                            console.error('An error occurred: ' + error);
                                        }
                                    });


	});


	$(".btn.btn-primary.btn-pay").click(function(e){
		e.preventDefault();

		
		$.ajax({
                                    url: $(this).attr("href"),
                                    type: 'POST',
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                            
											$("#pay_now").modal("show");
											$("#pay_now_content").html(response);
                                        },
                                        error: function(xhr, status, error) {
                                            // Handle any errors that occur during the AJAX request
                                            console.error('An error occurred: ' + error);
                                        }
                                    });

	});
	$(document).ready(function() {


		function toggleAccordion(className, buttonId) {
        var accordion = $("." + className);
        var button = $("#" + buttonId);

        // Toggle accordion visibility by adding/removing the 'hidden' class
        accordion.toggleClass('hidden');

        // Change button text based on state
        if (accordion.hasClass("hidden")) {
            button.text("<?= lang("Expand"); ?>");
            localStorage.setItem(className, "collapsed");  // Store state as collapsed
        } else {
            button.text("<?= lang("Collapse"); ?>");
            localStorage.setItem(className, "expanded");  // Store state as expanded
        }
    }

    // Restore accordion state from localStorage
    function restoreAccordionState(className, buttonId) {
        var accordion = $("." + className);
        var button = $("#" + buttonId);

        var state = localStorage.getItem(className);
        if (state === "collapsed") {
            accordion.addClass("hidden");
            button.text("<?= lang("Expand"); ?>");
        } else {
            accordion.removeClass("hidden");
            button.text("<?= lang("Collapse"); ?>");
        }
    }

    // Handle span clicks for toggling
    $("#admin_accordion").click(function() {
        toggleAccordion("admin_accordion", "admin_accordion");
    });
    $("#apps_accordion").click(function() {
        toggleAccordion("apps_accordion", "apps_accordion");
    });

    // Restore the initial state from localStorage
    restoreAccordionState("admin_accordion", "admin_accordion");
    restoreAccordionState("apps_accordion", "apps_accordion");


    // Check localStorage on page load and apply the correct state
    if (localStorage.getItem("statsVisibility-inv-supplier") === "hidden") {
        $(".statistics").hide();  // Hide the statistics section if stored state is "hidden"
    } else {
        $(".statistics").show();  // Show the statistics section otherwise
    }

    // On toggle button click, toggle visibility and update localStorage
    $(".togglestats").click(function() {

		

        $(".statistics").fadeToggle();
		setTimeout(function() {
        // Store the new state in localStorage
        if ($(".statistics").is(":visible")) {
            localStorage.setItem("statsVisibility-inv-supplier", "visible");  // Save the state as visible
        } else {
            localStorage.setItem("statsVisibility-inv-supplier", "hidden");  // Save the state as hidden
        }
		}, 500)

		
    });
});
        });
$(document).ready(function() {
  $('.toggle_advance, .toggle_advance_close').click(function() {
    $('.advance_search').toggleClass('hidden');
	$('.toggle_advance').toggleClass('hidden');
  });

});


	async function delete_all_client_side_dbs()
	{
		//If we can list out all datbases this is the best method in case we are in an odd state
		//Supports chrome, safari
		if (window.indexedDB.databases)
		{
			 window.indexedDB.databases().then((r) => 
			 {
			     for (var i = 0; i < r.length; i++)
		         {
		             window.indexedDB.deleteDatabase(r[i].name);     
		         } 
			 })
		}
		else //For firefox
		{
			try
			{
	 			var phppos_customers = new PouchDB('phppos_customers',{revs_limit: 1});
	 			var phppos_items = new PouchDB('phppos_items',{revs_limit: 1});
				var phppos_settings = new PouchDB('phppos_settings',{revs_limit: 1});
				await phppos_customers.destroy();
				await phppos_items.destroy();
				await phppos_category.destroy();
				await phppos_settings.destroy();
			}
			catch(exception_var)
			{
				
			}
		}
		
	}

	
</script>

<script src="<?php echo base_url().'assets/css_good/js/custom/apps/ecommerce/sales/listing.js?'.ASSET_TIMESTAMP;?>" type="text/javascript" charset="UTF-8"></script>



<script src="<?= site_url() ?>assets/js/axios.min.js"></script>
<?php




if ($this->config->item('offline_mode'))
{
?>
<script>
	<?php
	$offline_assets = array();
	$total_items = get_all_count_items();
	$total_categories = get_all_categories(); 
	$total_customers =get_all_customers();


	foreach(get_css_files() as $css_file)
	{
		$offline_assets[] = base_url().$css_file['path'].'?'.ASSET_TIMESTAMP;
	}
	foreach(get_js_files() as $js_file) 
	{
		$offline_assets[] = base_url().$js_file['path'].'?'.ASSET_TIMESTAMP;		
	}	
	
	$offline_assets[] = base_url().'favicon_'.$this->config->item('branding_code').'.ico';
	$offline_assets[] = base_url().'assets/fonts/themify.woff?-fvbane';
	$offline_assets[] = base_url().'assets/fonts/themify.ttf?-fvbane';
	$offline_assets[] = base_url().'assets/fonts/ionicons.woff?v=2.0.0';
	$offline_assets[] = base_url().'assets/fonts/ionicons.ttf?v=2.0.0';
	$offline_assets[] = base_url().'assets/assets/images/avatar-default.jpg';
	$offline_assets[] = base_url().'assets/img/item.png';
	$offline_assets[] = base_url().$this->config->item('branding')['logo_path'];
	$offline_assets[] = base_url().'assets/img/user.png';
	
	  $item_images = get_query_data('select image_id from phppos_item_images ');

	foreach ($item_images as $img){
		$offline_assets[] = base_url().'app_files/view_cacheable/'.$img->image_id;
	}
	

	

	?>
	function updateStepUI(data) {
		var total = {}; // Create an object
			 total['items'] = parseInt(<?= $total_items;  ?>);
			 total['categories'] = parseInt(<?= $total_categories;  ?>);
			 total['customers'] = parseInt(<?= $total_customers;  ?>);


			const step = document.querySelector(`.step-container[data-step="${data.entity}"]`);

			
			if (!step) return;

			const normalImg = step.querySelector(".normal");
			const successImg = step.querySelector(".success");
			

			// Show progress (e.g., "Syncing 42 customers")
			if (data.type === 'progress') {

				let progressBar = step.querySelector('.progress-bar');
				let percentage = Math.round((data.count / total[data.entity]) * 100);
			

				progressBar.style.width = percentage + '%';
				progressBar.setAttribute('aria-valuenow', percentage);
				progressBar.innerText = percentage + '%'; // Optional
			}
			if (data.type === 'started') {
				let progressBar = step.querySelector('.progress-bar');
				let percentage = 0;
				progressBar.style.width = percentage + '%';
				progressBar.setAttribute('aria-valuenow', percentage);
				progressBar.innerText = percentage + '%'; // Optional
			}
			// Show success and animation
			if (data.type === 'sync-complete') {
				// Animate from normal to success
				gsap.to(normalImg, {
				opacity: 0,
				duration: 0.3,
				onComplete: () => {
					normalImg.classList.add("d-none");
					successImg.classList.remove("d-none");

					gsap.fromTo(successImg, { opacity: 0 }, { opacity: 1, duration: 0.5 });

					// Optional: update label to show total synced
					let label = step.querySelector("label");
					if (label) {
					label.innerText = `✔ All ${data.entity} synced`;
					}

					let progressBar = step.querySelector('.progress-bar');
						let percentage = 100;
						progressBar.style.width = percentage + '%';
						progressBar.setAttribute('aria-valuenow', percentage);
						progressBar.innerText = percentage + '%'; // Optional
				}
				});
			}
		}

	var offline_mode_sync_period = parseInt("<?php echo $this->config->item('offline_mode_sync_period')?$this->config->item('offline_mode_sync_period'): '24'; ?>");

	//Offline support
	// UpUp.start({
	// 	'cache-version': '<?php echo BUILD_TIMESTAMP; ?>',
	// 	'content-url': '<?php echo site_url('home/offline/').BUILD_TIMESTAMP?>',
	// 	'assets': <?php echo json_encode($offline_assets); ?>,
	// 	'service-worker-url': '<?php echo  base_url().'upup.sw.min.js?'.BUILD_TIMESTAMP;?>',
	// 	'content': '<h1>Offline Mode</h1><p>Please check your internet connection.</p>'
	// });

	//Background worker for syncing offline data
	var w;
	function startWorker(force='') 
	{
		offline_mode_sync_period =1;
	
	
		if (typeof(Worker) !== "undefined") {
			
			
				
				w = new Worker('<?php echo base_url(); ?>'+"assets/js/load_sales_offline_data_worker.js?<?php echo BUILD_TIMESTAMP;?>");
					
				//Event handler coming back from worker that posts messages
				w.onmessage = function(event) 
				{
					var data = event.data;
					console.log("event " , data);
					
					if (data == 'delete_all_client_side_dbs')
					{
						delete_all_client_side_dbs();
					}else{
						updateStepUI(data);
					}
					
				};

				//Post message to worker; some init params
				w.postMessage({
					base_url:BASE_URL,
					site_url:SITE_URL,
					msg : force,
					offline_mode_sync_period: offline_mode_sync_period
				});
			
		} else{
			document.getElementById("result").innerHTML = "Sorry! No Web Worker support.";
		}
	}

	function stopWorker() 
	{ 
	   w.terminate();
	   w = undefined;
	}
	localStorage.setItem('APPLICATION_VERSION',<?php echo json_encode(APPLICATION_VERSION); ?>);
	localStorage.setItem('BUILD_TIMESTAMP',<?php echo json_encode(BUILD_TIMESTAMP); ?>);

	startWorker();	
	

</script>

<script>
  const buildTimestamp = "<?php echo BUILD_TIMESTAMP; ?>";
  const offlineAssets = <?php echo json_encode($offline_assets); ?>;
  const isLocalhost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';

  // Expose to service worker
  self.__ASSETS__ = offlineAssets;

  const offlineURL = isLocalhost 
    ? `/home/offline-local/${buildTimestamp}`  // for local testing
    : `/home/offline/${buildTimestamp}`;

  
	console.log("navigator" , navigator);

  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register(`<?= site_url(); ?>service-worker.js?ts=${buildTimestamp}&offline_url=${encodeURIComponent(offlineURL)}`)
      .then(reg => console.log('[SW] Registered offline'))
      .catch(err => console.error('[SW] Error:', err));
  }
</script>


<?php } ?>

<script>
	$(document).ready(function () {
		$('#unread_message_count').on('click', function(){
			$('.first_active').trigger('click');
		});
		
	});

// $(document).ajaxStart(function() {
//   // Show loader & overlay
//   $("#overlay").fadeIn();
// }).ajaxStop(function() {
//   // Hide loader & overlay
//   $("#overlay").fadeOut();
// });

	$(".checkForUpdate").click(function(event) {
        event.preventDefault();
        $('#ajax-loader').removeClass('hidden');

        $.getJSON($(this).attr('href'), function(update_available) {
            $('#ajax-loader').addClass('hidden');
            if (update_available) {
                bootbox.confirm(<?php echo json_encode(lang('update_available')); ?>,
                    function(response) {
                        if (response) {
                            window.location =
                                "http://<?php echo $this->config->item('branding')['domain']; ?>/downloads.php";
                        }
                    });
            } else {
                bootbox.alert(<?php echo json_encode(lang('not_update_available')); ?>);
            }
        });

    });
	$(document).ready(function() {
                                            var eventLog = $(".testselect")
                                        
                                            eventLog.select2();
                                            eventLog.on("change", function (e) { 
                                                var selectedValue = $(this).val();
                                                var location_id = selectedValue;
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
                                        
                                    });

									$(document).ready(function() {


  $('.nav-link').click(function(e) {
    // Prevent the default anchor behavior

	if($(this).hasClass('sp_link')){

	}else{
		e.preventDefault();
	}
  

    // Get the target tab pane id from the data-target attribute
    var target = $(this).data('target');

    // Remove "show active" from all tab panes
    $('.tab-pane').removeClass('show active');

    // Add "show active" to the targeted tab pane
    $(target).addClass('show active');

    // Update the nav links to reflect the active state
    $('.nav-link').removeClass('active');
    $(this).addClass('active');
  });
});

$(document).ready(function() {
  var $scrollContainer = $('.horizontal-scroll');
  var scrollSpeed = 10; // Adjust this value for different scroll speeds

  $scrollContainer.on('mousemove', function(e) {
    var $this = $(this);
    var mouseX = e.pageX - $this.offset().left; // Get the mouse X position relative to the scroll container
    var scrollWidth = $this.get(0).scrollWidth; // Width of the scroll container
    var outerWidth = $this.outerWidth(); // Visible width of the scroll container
    var scrollLeft = $this.scrollLeft(); // Current scroll position

    // If the mouse is on the right side of the container, scroll right
    if (mouseX > outerWidth * 0.8) { // The 0.8 here means "start scrolling when the mouse is at 80% of the container width"
      $this.scrollLeft(scrollLeft + scrollSpeed);
    } 
    // If the mouse is on the left side of the container, scroll left
    else if (mouseX < outerWidth * 0.2) { // The 0.2 means "start scrolling when the mouse is at 20% of the container width"
      $this.scrollLeft(scrollLeft - scrollSpeed);
    }
  });

  $scrollContainer.on('wheel', function(e) {
    // Prevents the default vertical scroll
    e.preventDefault();
    
    // Cross-browser wheel delta
    var delta = e.originalEvent.deltaX * -1 || e.originalEvent.deltaY;
    var scrollLeft = $scrollContainer.scrollLeft();
    $scrollContainer.scrollLeft(scrollLeft + delta);
  });
});

function change_pos_settings(id , status){
	$.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo site_url('sales/change_pos_settings'); ?>',
                                                    data: {
                                                        'id': id,
														'status': status,
                                                    },
                                                    success: function() {
                                                        // window.location.reload(true);
                                                    }
                                                });
}




</script>
</html>
