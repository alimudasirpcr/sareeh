
<style>
ul.ui-autocomplete {
    margin-right: 30px !important;
    z-index: 999999999;
}

</style>



<div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1" role="dialog" aria-labelledby="invoiceData" aria-hidden="true">
    <div class="modal-dialog customer-recent-sales">
		<div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true">&times;</span></button>
	          	<h4 class="modal-title" id="invoiceModalDialogTitle"><?php echo H(lang('add_items'));?></h4>
	        </div>
	        <div class="modal-body">
				<!-- Form -->
				<?php echo form_open($action,array('id'=>'invoices_form','class'=>'form-horizontal')); ?>
				
				
                               
				
				
								
				<div class="form-actions">
					<?php
						echo form_submit(array(
							'name'=>'submitf',
							'id'=>'submitf',
							'value'=>lang('save'),
							'class'=>'submit_button pull-right btn btn-primary')
						);
					?>
					<div class="clearfix">&nbsp;</div>
				</div>
			
				<?php echo form_close(); ?>
	        </div>
    	</div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
    $(document).ready(function () {
        
        if ($("#item").length) {
            $("#item").autocomplete({
                source: '<?php echo site_url("items/item_search");?>',
                delay: 150,
                autoFocus: false,
                minLength: 0,
                appendTo: '#new_work_order_modal',
                select: function(event, ui) {
                    if (ui.item.value == false) {
                        add_additional_item($("#item_description").val());
                    } else {
                       
                        item_select(ui.item.value, ui.item.serial_number);
                       
                    }
                },
            }).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li class='item-suggestions'></li>")
                    .data("item.autocomplete", item)
                    .append(
                        '<a class="suggest-item"><div class="item-image  symbol symbol-circle symbol-50px overflow-hidden">' +
                        '<img src="' + item.image + '" alt="">' +
                        '</div>' +
                        '<div class="details">' +
                        '<div class="name">' +
                        item.label +
                        '</div>' +
                        '<span class="name small">' +
                        (item.subtitle ? item.subtitle : '') +
                        '</span>' +
                        '<span class="name small"> <?php echo lang('serial_number'); ?> : ' +
                        (item.serial_number ? item.serial_number : '') +
                        '</span>' +
                        (item.warranty != '' ? '<span class="name small"><?php echo lang('warranty'); ?> : ' + item
                            .warranty + '</span>' : '') +
                        '<span class="attributes">' + '<?php echo lang("common_category"); ?>' +
                        ' : <span class="value">' + (item.category ? item.category :
                            <?php echo json_encode(lang('common_none')); ?>) + '</span></span>' +
                        <?php if ($this->Employee->has_module_action_permission('items', 'see_item_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>(
                            typeof item.quantity !== 'undefined' && item.quantity !== null ?
                            '<span class="attributes">' + '<?php echo lang("common_quantity"); ?>' +
                            ' <span class="value">' + item.quantity + '</span></span>' : '') +
                        <?php } ?>(item.attributes ? '<span class="attributes">' +
                            '<?php echo lang("common_attributes"); ?>' + ' : <span class="value">' + item
                            .attributes + '</span></span>' : '') +

                        '</div>')
                    .appendTo(ul);
            };

            $('#item').bind('keypress', function(e) {
                    if (e.keyCode == 13) {
                        localStorage.setItem('item_search_key', $("#new_work_order_form #item").val());
                        e.preventDefault();
                        var search_value = $("#item").val();
                        item_found = true;
                        $.post('<?php echo site_url("work_orders/add_but_not_save");?>', {
                            item: search_value
                        }, function(response) {
                            item_found = false;
                            var data = JSON.parse(response);
                            if (data.redirect) {
                                location.href = data.redirect;
                                return false;
                            } else if (data.item_info.length > 0) {
                                item_found = true;
                                $("#firearms_tbody").html('');
                                $.each(data.item_info, function(index, item) {
                                    if (item.is_serialized == 1) {
                                        var s_id = 'serial_number_' + item.item_id + '_' + index;
                                        var new_item_tr =
                                            '<tr><td class="serial"><a href="#" id="' + s_id +
                                            '" class="xeditable" data-value="' + item
                                            .serial_number + '" data-name="' + s_id +
                                            '" data-url="<?php echo site_url('work_orders/edit_item_serialnumber/');?>' +
                                            index +
                                            '" data-type="text" data-pk="1" data-title="<?php echo H(lang('common_serial_number')); ?>">' +
                                            item.serial_number + '</a></td><td>' + item
                                            .description + '</td><td>' + item.model +
                                            '</td><td class="text-center"><i class="delete-item icon ion-android-cancel" data-index="' +
                                            index + '"></i></td></tr>';
                                        $("#firearms_tbody").append(new_item_tr);

                                        setTimeout(function() {
                                            $("#" + s_id).editable('setValue', item
                                                .serial_number);
                                        }, 100, s_id);

                                        $("#" + s_id).editable({
                                            success: function(response, newValue) {
                                                var ret = JSON.parse(response);
                                                $('#' + ret.id).val(newValue);
                                                $('#' + ret.id).attr('data-value',
                                                    newValue);
                                            }
                                        });
                                    } else {
                                        var new_item_tr = '<tr><td class="serial"></td><td>' + item
                                            .description + '</td><td>' + item.model +
                                            '</td><td class="text-center"><i class="delete-item icon ion-android-cancel" data-index="' +
                                            index + '"></i></td></tr>';
                                        $("#firearms_tbody").append(new_item_tr);
                                    }
                                });

                                return false;
                            } else if (data.success && data.message) {
                                //item found with error
                                item_found = true;
                                show_feedback('error', data.message,
                                    <?php echo json_encode(lang('common_error')); ?>);
                                return false;
                            }
                        }).done(function() {
                                if (!item_found) {
                                    $.get('<?php echo site_url("work_orders/item_search");?>', {
                                            term: $("#item").val()
                                        }, function(response) {
                                            var data = JSON.parse(response);

                                         
                                                item_select(data[0].value, data[0].serial_number);
                                           
                                            });
                                    }
                                });
                        }
                    });

            }
            function init_item_fields() {
                $("#serial_number").val('');
            }


            function item_select(item_id, serial_numbers, item_variation_id = false) {
                $.post("<?php echo site_url('work_orders/select_item') ?>", {
                    item_id: item_id,
                    item_variation_id: item_variation_id
                }, function(response) {
                     $('#item').val('');
                    var item_info = response.item_info;
                    var model = item_info.name;
                    var item_id = item_info.item_id;
                    var item_kit_id = item_info.item_kit_id;
                    var item_is_serialized = item_info.is_serialized;
                    var last_item_key = response.total_item;
                    var item_variation_id = item_info.item_variation_id;
                    var unit_price = item_info.unit_price;
                    $('#items_table tbody  tr:last input[name="name[]"]').val(model);
                    $('#items_table tbody  tr:last input[name="item_id[]"]').val(item_id);
                    $('#items_table tbody  tr:last input[name="variation_id[]"]').val(item_variation_id);
                    $('#items_table tbody  tr:last input[name="is_custom[]"]').val(0);
                    
                    $('#items_table tbody  tr:last input[name="price[]"]').val(unit_price);
                    $('#items_table tbody  tr:last .total_amount').html(unit_price);


                    $('#<?php echo $modal_id; ?>').modal('hide');
                    // $('#item').val(item_id);
                }, 'json');
            }



            function calculateTotals() {
        let grandTotal = 0;

        $('tr[data-kt-element="item"]').each(function () {
            // Get quantity and price for the row
            let quantity = parseFloat($(this).find('input[name="quantity[]"]').val()) || 0;
            let price = parseFloat($(this).find('input[name="price[]"]').val()) || 0;

            // Calculate row total
            let rowTotal = quantity * price;
            $(this).find('span[data-kt-element="total"]').text(rowTotal.toFixed(2));

            // Add to grand total
            grandTotal += rowTotal;
        });

        // Display grand total somewhere in the DOM, e.g., in a specific element
        // $('#grandTotal').text(grandTotal.toFixed(2));
    }

    // Trigger calculation on input change
    $(document).on('input', 'input[name="quantity[]"], input[name="price[]"]', calculateTotals);

    // Remove row and recalculate totals
    $(document).on('click', 'button[data-kt-element="remove-item"]', function () {
        $(this).closest('tr').remove();
        calculateTotals();
    });

    });
</script>