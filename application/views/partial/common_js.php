var submitting = false;

function hashDiff(h1, h2) {
  var d = {};
  for (k in h2) {
    if (h1[k] !== h2[k]) d[k] = h2[k];
  }
  return d;
}

function convertSerializedArrayToHash(a) { 
	var form = a;
	a = a.serializeArray();
	
	//add file inputs to check
	form.find('input[type=file]').each(function()
	{
		var file_input_name = $(this).attr('name');
		var file_input_value = $(this).val();
		a.push({name:file_input_name,value:file_input_value });
	});
	
  var r = {}; 
  for (var i = 0;i<a.length;i++) {
		if(a[i].name !== 'submitf')
		{
			r[a[i].name] += a[i].value;
		}
  }
  return r;
}

var $form = $('#item_form, #item_kit_form').eq(0);

var startItems;

$(document).ready(function() {		
	if(!startItems)
	{
		startItems = convertSerializedArrayToHash($form);
	}
});

function doItemSubmit(form, args)
{
  var currentItems = convertSerializedArrayToHash($form);
	
	var startItems_length = $.map(startItems, function(n, i) { return i; }).length;
	var currentItems_length = $.map(currentItems, function(n, i) { return i; }).length;
	
  var itemsToSubmit = hashDiff(startItems, currentItems);
		
	if($.isEmptyObject(itemsToSubmit) && startItems_length == currentItems_length)
	{
		show_feedback('warning',<?php echo json_encode(lang('common_warning')); ?>,<?php echo json_encode(lang('common_nothing_to_save_warning_message')); ?>);
		
		return;
	}
	
	if (submitting) return;
	submitting = true;
	
	$('#grid-loader').show();
	
	$(form).ajaxSubmit({
	success:function(response)
	{
		$('#grid-loader').hide();
			startItems = convertSerializedArrayToHash($form);
			submitting = false;		
			<?php if ((isset($item_info) && $item_info->item_id)) { ?>
				show_feedback(response.success ? 'success' : 'error', response.message,response.success ? <?php echo json_encode(lang('common_success')); ?> +' #' + response.item_id : <?php echo json_encode(lang('common_error')); ?>);
			<?php } ?>
			<?php if ((isset($item_kit_info) && $item_kit_info->item_kit_id)) { ?>
				show_feedback(response.success ? 'success' : 'error', response.message, response.success ? <?php echo json_encode(lang('common_success')); ?> +' #' + response.item_kit_id : <?php echo json_encode(lang('common_error')); ?>);
			<?php } ?>
			
			<?php if(isset($item_kit_info) && !$item_kit_info->item_kit_id) { ?>
			//If we have a new item, make sure we hide the tax containers to "reset"
			$(".tax-container").addClass('hidden');
			$(".item-kit-location-price-container").addClass('hidden');
			$('.commission-container').addClass('hidden');
			$('.item_kit_item_row').remove();
		
			var selectize = $("#tags")[0].selectize;
			selectize.clear();
			selectize.clearOptions();
			<?php } ?>
			if(response.quick_edit==null && response.redirect=='' && response.success && response.item_id!=0)
			{ 
				if (!$.fn.DataTable.isDataTable('#serial_numbers')) {
				var table =  $('#serial_numbers').DataTable({
        "paging": true, // Ensure paging is enabled
        "pageLength": 10, // Adjust as per your requirement
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "order": [],
       
        "ajax": {
            "url": "<?php echo site_url('items/ajaxList/') ?>"+response.item_id+"",
            "type": "POST"
        },
        "drawCallback": function(settings) {
			$(".delete_serial_number").click(function(e)
				{
					e.preventDefault();
					$("#item_form").append('<input type="hidden" name="serials_to_delete[]" value="'+$(this).data('serial-number')+'" />');
					
					$(this).parent().parent().parent().parent().remove();
				});
			$(".show_log").click(function(e)
			{	
				e.preventDefault();
				$.ajax({
					url: '<?php echo base_url() ?>items/get_sn_log',
					type: 'POST',
					data: { id:$(this).data('id')},
					success: function (response) {
						$('.sn-body').html(response);
						$("#modal_serial_log").modal('show');
					}
				});
				
			});
			// Attach click event listener inside drawCallback
            $('[data-kt-menu-trigger="click"]').off('click').on('click', function(e) {
                e.preventDefault();

                var $currentMenu = $(this).next('.menu.menu-sub.menu-sub-dropdown');
                var $dataTableWrapper = $(this).closest('.dataTables_wrapper');

                // Hide and reset all other menus
                $('.menu.menu-sub.menu-sub-dropdown').removeClass('show').removeAttr('style');

                // Calculate position
                var btnOffset = $(this).offset();
                var scrollTop = $(window).scrollTop();
                var scrollLeft = $(window).scrollLeft();

                // Adjust for scrolling
                var topPosition = btnOffset.top - scrollTop + $(this).outerHeight();
                var leftPosition = btnOffset.left - scrollLeft;

                // Adjust if the menu goes beyond the viewport
                var menuWidth = $currentMenu.outerWidth();
                var windowWidth = $(window).width();
                if (leftPosition + menuWidth > windowWidth) {
                    leftPosition -= (leftPosition + menuWidth - windowWidth);
                }

                // Show and position the menu
                $currentMenu.addClass('show').css({
                    "position": "fixed", // Use fixed to position relative to the viewport
                    "top": topPosition + "px",
                    "left": leftPosition + "px",
                    "z-index": "105" // Ensure it's above other content
                });
            });

			// Optional: Clicking outside hides any open dropdown and removes styles
			 // Optional: Close menus when clicking outside
			 $(document).on('click', function(e) {
        if (!$(e.target).closest('.btn-active-light-primary, .menu.menu-sub.menu-sub-dropdown').length) {
            $('.menu.menu-sub.menu-sub-dropdown').removeClass('show').removeAttr('style');
        }
    });
		// 	loadScript("path/to/your/dynamic/content/script.js", function() {
        //     console.log("Dynamic content script loaded.");
        //     // Initialization or function calls related to the DataTable content
        // });
        // Custom class for the pagination wrapper
        $('.dataTables_paginate').addClass('pagination');

        // Iterate over each paginate button and modify
        $('.dataTables_paginate .paginate_button').each(function() {
            $(this).addClass('page-item-new');
            $(this).children('a').addClass('page-link');
        });

        // Handle the active class
        $('.dataTables_paginate .paginate_button.current').addClass('active');
        
        // Optionally, handle the disabled state for previous/next buttons
        $('.dataTables_paginate .paginate_button.previous.disabled, .dataTables_paginate .paginate_button.next.disabled').addClass('disabled');
    }
    });
}


				$('#item_id').val(response.item_id);
				$('.show_upload_btns').show();
				$('.show_upload_link').attr('href','<?php echo base_url('items/serial_number_template_export/'); ?>'+response.item_id+'');
			}
			
			if(response.progression && response.redirect=='sales/index/1' && response.success)
			{ 
				item_save_confirm_dialog({
					reload: response.reload ? true : false,
					id: response.item_id,
					confirm: {
						label: <?php echo json_encode(lang('common_add_item_to_sale')) ?>,
						post_url: <?php echo json_encode(site_url("sales/add")); ?>,
						redirect: <?php echo json_encode(site_url('sales/index/1')); ?>
					},
					cancel: {
						label: args.next.label,
						redirect: args.next.url
					}
				});
			}
			else if(response.progression && response.redirect=='receivings/' && response.success)
			{
				item_save_confirm_dialog({
					reload: response.reload ? true : false,
					id: response.item_id,
					confirm: {
						label: <?php echo json_encode(lang('common_add_item_to_receiving')) ?>,
						post_url: <?php echo json_encode(site_url("receivings/add"));?>,
						redirect: <?php echo json_encode(site_url('receivings')); ?>
					},
					cancel: {
						label: args.next.label,
						redirect: args.next.url
					}
				});
			}
			else if(response.progression && response.redirect == 'items' && response.success)
			{
				if(args.next.redirect)
				{
					item_save_confirm_dialog({
						reload: response.reload ? true : false,
						id: response.item_id,
						confirm: {
							label: <?php echo json_encode(lang('common_return_to_items')) ?>,
							post_url: null,
							redirect: <?php echo json_encode(site_url('items')); ?>
						},
						cancel: {
							label: <?php echo json_encode(lang('common_continue_editing')) ?>,
							redirect: null
						}
					});
				}
				else
				{
					if(response.reload)
					{
						window.location.reload();
					}
					else
					{
						window.location.href = args.next.url.replace(/-1/g, response.item_id);
					}	
				}
			}
			else if(response.progression && response.redirect == 'item_kits' && response.success)
			{
				if(args.next.redirect)
				{
					item_save_confirm_dialog({
						reload: response.reload ? true : false,
						id: response.item_kit_id,
						confirm: {
							label: <?php echo json_encode(lang('common_return_to_item_kits')) ?>,
							post_url: null,
							redirect: <?php echo json_encode(site_url('item_kits')); ?>
						},
						cancel: {
							label: <?php echo json_encode(lang('common_continue_editing')) ?>,
							redirect: null
						}
					});
				}
				else
				{
					window.location.href = args.next.url.replace(/-1/g, response.item_kit_id);
				}
			}
			else if(response.redirect == 'items' && response.success)
			{
				if(response.quick_edit)
				{
					window.location.href = <?php echo json_encode(site_url('items')); ?>;
				}
				else
				{
						item_save_confirm_dialog({
							reload: response.reload ? true : false,
							id: response.item_id,
							confirm: {
								label: <?php echo json_encode(lang('common_return_to_items')) ?>,
								post_url: null,
								redirect: <?php echo json_encode(site_url('items')); ?>
							},
							cancel: {
								label: <?php echo json_encode(lang('common_continue_editing')) ?>,
								redirect: null
							}
						});
					
				}
			}
			else if(response.redirect == 'item_kits' && response.success)
			{
				if(response.quick_edit)
				{
					window.location.href = <?php echo json_encode(site_url('item_kits')); ?>;
				}
				else
				{
					item_save_confirm_dialog({
						reload: response.reload ? true : false,
						id: response.item_id,
						confirm: {
							label: <?php echo json_encode(lang('common_return_to_item_kits')) ?>,
							post_url: null,
							redirect: <?php echo json_encode(site_url('item_kits')); ?>
						},
						cancel: {
							label: <?php echo json_encode(lang('common_continue_editing')) ?>,
							redirect: null
						}
					});
				}
			}
			else if(response.progression && response.redirect=='work_orders/index/0' && response.success)
			{ 
				item_save_confirm_dialog({
					reload: response.reload ? true : false,
					id: response.item_id,
					confirm: {
						label: <?php echo json_encode(lang('common_add_item_to_work_order'));?>,
						post_url: <?php echo json_encode(site_url("work_orders/added_new_item_for_work_order"));?>,
						redirect: <?php echo json_encode(site_url('work_orders/index/0/1')); ?>
					},
					cancel: {
						label: args.next.label,
						redirect: args.next.url
					}
				});
			} 
	},
	dataType:'json'
	});
}

$('a.outbound_link').click(function(e)
{
	var $that = $(this);
	
  var currentItems = convertSerializedArrayToHash($form);
  var itemsToSubmit = hashDiff(startItems, currentItems);
		
	$form.validate();
		
	if(!$form.valid())
	{
		e.preventDefault();
		bootbox.alert(<?php echo json_encode(lang('common_required_fields_not_filled_out')); ?>);
		return;
	}
		
	if($.isEmptyObject(itemsToSubmit))
	{
		return;
	}
		
	e.preventDefault();
		
	$('#grid-loader').show();
	
	$form.ajaxSubmit({
		success: function(response,status)
		{
			var id = response.item_id ? response.item_id : response.item_kit_id;

			var updated_href = $that.attr('href').replace(/-1/g, id);
			$(e.target).attr('href', updated_href);
			$('#grid-loader').hide();
			window.location = updated_href;

		},
		dataType:'json'
	});
	
});

function item_save_confirm_dialog(args) {
	
	bootbox.confirm({
	    message: <?php echo json_encode(lang('common_redirect_prompt')); ?>,
	    buttons: {
	        confirm: {
	            label: args.confirm.label,
	            className: 'btn-primary'
	        },
	        cancel: {
	            label: args.cancel.label,
							className: 'btn-default'
	            
	        }
	    },
	    callback: function (result) {
				if(result)
				{
					
					var done = function() {
							window.location.href = args.confirm.redirect;
					};
					
					if(args.confirm.post_url)
					{
						$.post(args.confirm.post_url, {item: args.id}, done);
					} else {
						done();
					}
					
				} else {
					if(args.cancel.redirect)
					{
						window.location.href = args.cancel.redirect.replace(/-1/g, args.id);
					}
					
					if(args.reload)
					{
						window.location.reload();
					}
				}
	    }
	});
}