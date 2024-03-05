<?php $this->load->view("partial/header"); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<?php $query = http_build_query(array('redirect' => $redirect, 'progression' => $progression ? 1 : null, 'quick_edit' => $quick_edit ? 1 : null)); ?>
<?php $manage_query = http_build_query(array('redirect' => uri_string().($query ? "?".$query : ""), 'progression' => $progression ? 1 : null, 'quick_edit' => $quick_edit ? 1 : null)); ?>



<div class="spinner" id="grid-loader" style="display:none">
    <div class="rect1"></div>
    <div class="rect2"></div>
    <div class="rect3"></div>
</div>

<div class="manage_buttons">
    <div class="row">
        <div class="<?php echo isset($redirect) ? 'col-xs-9 col-sm-10 col-md-10 col-lg-10' : 'col-xs-12 col-sm-12 col-md-12' ?> margin-top-10">
            <div class="modal-item-info padding-left-10">
                <div class="breadcrumb-item text-dark">
                    <?php if (!$item_info->item_id) { ?>
                        <span class="modal-item-name new"><?php echo lang('items_new'); ?></span>
                    <?php } else { ?>
                        <span class="modal-item-name"><?php echo H($item_info->name) . ' [' . lang('id') . ': ' . $item_info->item_id . ']'; ?></span>
                        <span class="badge badge-success fw-semibold fs-9 px-2 ms-2 cursor-default ms-2"><?php echo H($category); ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if (isset($redirect) && !$progression) { ?>
            <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2 margin-top-10">
                <div class="buttons-list">
                    <div class="pull-right-btn">
                        <?php echo
                        anchor(site_url($redirect), ' ' . lang('done'), array('class' => 'outbound_link btn btn-primary btn-lg ion-android-exit', 'title' => ''));
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php if (!$quick_edit) { ?>
    <?php $this->load->view('partial/nav', array('progression' => $progression, 'query' => $query, 'item_info' => $item_info)); ?>
<?php } ?>
<?php echo form_open('items/save_serial_numbers/'.(!isset($is_clone) ? $item_info->item_id : ''),array('id'=>'item_form','class'=>'form-horizontal')); ?>

<div class="col-md-12">

    <div class="card shadow-sm mt-3">
        <div class="card-header rounded rounded-3 p-5">
            <h3 class="card-title"><i class="ion-ios-toggle-outline fs-2"></i> <?php echo lang('items_serial_numbers') ?> <small>(<?php echo lang('fields_required_message'); ?>)</small></h3>

        </div>
        <div class="card-body">

            <div id="serial_container" class="form-group serial-input ">
               
                <div class="col-12 table-responsive">

                    <table id="serial_numbers" class="table table-row-dashed  table-rounded border gy-7 gs-7">
                        <thead>
                            <tr>
                                <th><?php echo lang('items_serial_number'); ?></th>
                                <th><?php echo lang('items_add_to_inventory'); ?></th>
                                <th><?php echo lang('replace_sale_warranty'); ?></th>
                                <th><?php echo lang('cost_price'); ?></th>
                                <th><?php echo lang('price'); ?></th>
                                <th><?php echo lang('variation'); ?></th>
                                <th><?php echo lang('location'); ?></th>
                                <th><?php echo lang('warranty_start'); ?></th>
                                <th><?php echo lang('warranty_end'); ?></th>
                                <th><?php echo lang('action'); ?><span class=" form-check form-check-sm form-check-custom form-check-solid leftmost"><input class="form-check-input" type="checkbox" id="select_all"><label for="select_all"><span></span></label></span>
                                    <button type="button" class="btn btn-primary " style="display: none;" id="edit_bulk_sn"><?= lang('edit') ?></button>

                                </th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
       
                            <div class="d-flex " style="margin-top: 70px;">
                                <a href="javascript:void(0);" class="btn btn-primary" id="add_serial_number"><i class="fas fa-plus fs-4 me-2"></i><?php echo lang('items_add_serial_number'); ?></a>
                                <a href="javascript:void(0);" class="btn btn-primary" id="add_serial_number_bulk"><i class="fas fa-plus fs-4 me-2"></i><?php echo lang('items_add_serial_number_bulk'); ?></a>

                                <input type="hidden" name="item_id" id="item_id" value="<?php echo $item_info->item_id; ?>">
                                <a <?php if ($item_info->item_id == null) : ?> style="display: none;" <?php endif; ?> href="<?php echo base_url('items/serial_number_template_export/' . $item_info->item_id . ''); ?>" class="btn btn-primary show_upload_btns show_upload_link"><i class="fas fa-download fs-4 me-2"></i><?php echo lang('download_template'); ?></a>

                                <input <?php if ($item_info->item_id == null) : ?> style="display: none;" <?php endif; ?> type="file" class="form-control show_upload_btns" name="sn_file_name" id="sn_excel">
                                <button <?php if ($item_info->item_id == null) : ?> style="display: none;" <?php endif; ?> type="button" class="btn btn-primary show_upload_btns" id="uploadButton"> upload </button>

                            </div>
                            </div>
    </div>
                            <script id="item-variation-template" type="text/x-handlebars-template">

                                <td>
	<?php
    $item_var_options = array('' => lang('none'));
    foreach ($item_variations as $item_variation_id => $item_variation) {
        $item_var_options[$item_variation_id] = $item_variation['name'] ? $item_variation['name'] : implode(', ', array_column($item_variation['attributes'], 'label'));
    }

    echo form_dropdown("serial_number_prices_variations[{{index_id}}]", $item_var_options, '', 'class="form-control"');

    ?>
</td>
</script>

                            <script id="serial-location-template" type="text/x-handlebars-template">

                                <td>

<?php
$serial_locations = array('' => lang('all'));

//Get all locations
foreach ($locations as $location) {
    $serial_locations[$location->location_id] = $location->name;
}

echo form_dropdown("serial_locations[{{index_id}}]", $serial_locations, '', 'class="form-control"');

?>
</td>
</script>



                            <script>
                                var table = $('#serial_numbers').DataTable({
                                    "paging": true, // Ensure paging is enabled
                                    "pageLength": 10, // Adjust as per your requirement
                                    "pagingType": "full_numbers",
                                    "processing": true,
                                    "serverSide": true,
                                    "order": [],
                                    "columnDefs": [{
                                            orderable: false,
                                            targets: -1
                                        } // Disables ordering on the last column
                                    ],

                                    "ajax": {
                                        "url": "<?php echo site_url('items/ajaxList/' . $item_info->item_id . '') ?>",
                                        "type": "POST"
                                    },
                                    "drawCallback": function(settings) {
                                        $(".delete_serial_number").click(function(e) {
                                            e.preventDefault();
                                            $("#item_form").append('<input type="hidden" name="serials_to_delete[]" value="' + $(this).data('serial-number') + '" />');

                                            $(this).parent().parent().parent().parent().remove();
                                        });
                                        $(".show_log").click(function(e) {
                                            e.preventDefault();
                                            $.ajax({
                                                url: '<?php echo base_url() ?>items/get_sn_log',
                                                type: 'POST',
                                                data: {
                                                    id: $(this).data('id')
                                                },
                                                success: function(response) {
                                                    $('.sn-body').html(response);
                                                    $("#modal_serial_log").modal('show');
                                                }
                                            });

                                        });
                                        // Attach click event listener inside drawCallback
                                        $('[data-kt-menu-trigger="click_items"]').off('click').on('click', function(e) {
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
                            </script>

                            <script>
                                function call_selected_values_checkboxes() {
                                    var checkboxValues = []; // Array to store checkbox values

                                    // Loop through checkboxes with class 'edit'
                                    $("#serial_numbers tbody :checkbox.edit").each(function() {
                                        if ($(this).is(":checked")) { // Check if the checkbox is checked
                                            checkboxValues.push($(this).val()); // Add the value to the array
                                        }
                                    });

                                    // Convert the array to a comma-separated string
                                    var commaSeparatedValues = checkboxValues.join(",");

                                    // Set the value of the hidden input
                                    $("#edit_sn_ids").val(commaSeparatedValues);
                                }

                                $(document).on('change', "#select_all", function(e) {
                                    if ($(this).prop('checked')) {
                                        var checkboxValues = []; // Array to store checkbox values
                                        $('#edit_bulk_sn').show();
                                        $("#serial_numbers tbody :checkbox.edit").each(function() {

                                            $(this).prop('checked', true);
                                            $(this).parent().parent().find("td").addClass('selected').css("backgroundColor", "");

                                        });
                                    } else {

                                        $('#edit_bulk_sn').hide();
                                        $("#serial_numbers tbody :checkbox.edit").each(function() {
                                            $(this).prop('checked', false);
                                            $(this).parent().parent().find("td").removeClass('selected');
                                        });
                                    }

                                    call_selected_values_checkboxes();
                                });


                                $(document).on('change', "#serial_numbers tbody :checkbox.edit", function(e) {
                                    var checkboxValues = []; // Array to store checkbox values

                                    // Loop through checkboxes with class 'edit'
                                    $("#serial_numbers tbody :checkbox.edit").each(function() {
                                        if ($(this).is(":checked")) { // Check if the checkbox is checked
                                            checkboxValues.push($(this).val()); // Add the value to the array
                                        }
                                    });

                                    // Convert the array to a comma-separated string
                                    var commaSeparatedValues = checkboxValues.join(",");

                                    // Set the value of the hidden input
                                    $("#edit_sn_ids").val(commaSeparatedValues);

                                });

                                $(document).ready(function() {
                                    $("#generate_edit").click(function() {
                                        var formData = new FormData();
                                        formData.append('replace_sale_date_edit', $('#replace_sale_date_edit').is(":checked"));
                                        formData.append('cost_price_edit', $('#cost_price_edit').val());
                                        formData.append('price_edit', $('#price_edit').val());
                                        formData.append('warranty_start_edit', $('#warranty_start_edit').val());
                                        formData.append('warranty_end_edit', $('#warranty_end_edit').val());
                                        formData.append('edit_sn_ids', $('#edit_sn_ids').val());
                                        $.ajax({
                                            url: '<?php echo base_url('items/update_serial_numbers'); ?>', // the server script
                                            type: 'POST',
                                            data: formData,
                                            processData: false, // tell jQuery not to process the data
                                            contentType: false, // tell jQuery not to set contentType
                                            success: function(data) {
                                                show_feedback('success', <?php echo json_encode(lang('serial_numbers_successfully_updated')); ?>, <?php echo json_encode(lang('success')); ?>);
                                                location.reload();
                                            }
                                        });
                                    });
                                });

                                $(document).ready(function() {
                                    $("#uploadButton").click(function() {
                                        var formData = new FormData();
                                        formData.append('file', $('#sn_excel')[0].files[0]);
                                        formData.append('item_id', $('#item_id').val());
                                        $.ajax({
                                            url: '<?php echo base_url('items/import_serial_number_excel'); ?>', // the server script
                                            type: 'POST',
                                            data: formData,
                                            processData: false, // tell jQuery not to process the data
                                            contentType: false, // tell jQuery not to set contentType
                                            success: function(data) {
                                                show_feedback('success', <?php echo json_encode(lang('serial_numbers_successfully_uploaded')); ?>, <?php echo json_encode(lang('success')); ?>);
                                                location.reload();
                                            }
                                        });
                                    });
                                });
                                var item_variation_template = Handlebars.compile(document.getElementById("item-variation-template").innerHTML);
                                var serial_number_location_template = Handlebars.compile(document.getElementById("serial-location-template").innerHTML);
                                $(document).ready(function() {
                                    var add_to_inventory_index = -1;
                                    $("#add_serial_number_bulk").click(function() {
                                        $("#modal_serial").modal('show');
                                    });
                                    $("#edit_bulk_sn").click(function() {
                                        $("#modal_serial_edit").modal('show');
                                    });


                                    function incrementSerial(serial) {
                                        // Split the serial into a number part and the rest
                                        let match = serial.match(/([a-zA-Z]*)(\d+)$/);
                                        let prefix = match[1];
                                        let number = match[2];

                                        // Increment the number part
                                        let newNumber = (parseInt(number, 10) + 1).toString();

                                        // Pad with zeros to maintain the same length
                                        while (newNumber.length < number.length) {
                                            newNumber = '0' + newNumber;
                                        }

                                        return prefix + newNumber;
                                    }

                                    $('#generate').click(function() {
                                        let fromSerial = $('#from_serial').val();
                                        let toSerial = $('#to_serial').val();
                                        let prefix = $('#prefix').val();
                                        let add_to_inventory = '';
                                        if ($('#add_to_inventory').is(':checked')) {
                                            add_to_inventory = 'checked="checked"';
                                        }
                                        let replace_sale_date = 0;
                                        if ($('#replace_sale_date').is(':checked')) {
                                            replace_sale_date = 'checked="checked"';
                                        }
                                        let cost_price = $('#cost_price').val();
                                        let price = $('#price').val();
                                        let warranty_start = $('#warranty_start').val();
                                        let warranty_end = $('#warranty_end').val();

                                        let currentSerial = fromSerial;

                                        while (currentSerial <= toSerial) {
                                            // serials.push(prefix+currentSerial);
                                            var context_data = {
                                                "index_id": add_to_inventory_index
                                            };
                                            $("#serial_numbers tbody").append('<tr><td><input type="text" data-id="0" class="form-control form-inps serial_numbers_check" size="40" name="serial_numbers[' + add_to_inventory_index + ']" value="' + prefix + currentSerial + '" /><span class="error_message text-danger"></span></td><td><div class="form-check form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" ' + add_to_inventory + ' name="add_to_inventory[' + add_to_inventory_index + ']" value="1" id="add_to_inventory' + add_to_inventory_index + '" /><label class="form-check-label" for="add_to_inventory' + add_to_inventory_index + '"><span></span></label></div></td><td><div class="form-check form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" ' + replace_sale_date + ' name="replace_sale_date[' + add_to_inventory_index + ']" value="1" id="replace_sale_date' + add_to_inventory_index + '" /><label class="form-check-label" for="replace_sale_date' + add_to_inventory_index + '"><span></span></label></div></td><td><input type="text" class="form-control form-inps" size="40" name="serial_number_cost_prices[' + add_to_inventory_index + ']" value="' + cost_price + '" /></td><td><input type="text" class="form-control form-inps" size="20" name="serial_number_prices[' + add_to_inventory_index + ']" value="' + price + '" /></td>' + item_variation_template(context_data) + serial_number_location_template(context_data) + '<td><input type="date" class="form-control form-inps" size="40" name="serial_number_warranty_start[' + add_to_inventory_index + ']" value="' + warranty_start + '" /></td><td><input type="date" class="form-control form-inps" size="40" name="serial_number_warranty_end[' + add_to_inventory_index + ']" value="' + warranty_end + '" /></td><td>&nbsp;</td></tr>');
                                            add_to_inventory_index--;

                                            currentSerial = incrementSerial(currentSerial);
                                        }
                                        $('#from_serial').val('');
                                        $('#to_serial').val('');
                                        $('#prefix').val('');
                                        $("#modal_serial").modal('hide');
                                    });


                                    $("#add_serial_number").click(function() {
                                        var context_data = {
                                            "index_id": add_to_inventory_index
                                        };
                                        $("#serial_numbers tbody").append('<tr><td><input type="text" data-id="0" class="form-control form-inps serial_numbers_check" size="40" name="serial_numbers[' + add_to_inventory_index + ']" value="" /><span class="error_message text-danger"></span></td><td><div class="form-check form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" name="add_to_inventory[' + add_to_inventory_index + ']" value="1" id="add_to_inventory' + add_to_inventory_index + '" /><label class="form-check-label" for="add_to_inventory' + add_to_inventory_index + '"><span></span></label></div></td><td><div class="form-check form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" name="replace_sale_date[' + add_to_inventory_index + ']" value="1" id="replace_sale_date' + add_to_inventory_index + '" /><label class="form-check-label" for="replace_sale_date' + add_to_inventory_index + '"><span></span></label></div></td><td><input type="text" class="form-control form-inps" size="40" name="serial_number_cost_prices[' + add_to_inventory_index + ']" value="" /></td><td><input type="text" class="form-control form-inps" size="20" name="serial_number_prices[' + add_to_inventory_index + ']" value="" /></td>' + item_variation_template(context_data) + serial_number_location_template(context_data) + '<td><input type="date" class="form-control form-inps" size="40" name="serial_number_warranty_start[' + add_to_inventory_index + ']" value="" /></td><td><input type="date" class="form-control form-inps" size="40" name="serial_number_warranty_end[' + add_to_inventory_index + ']" value="" /></td><td>&nbsp;</td></tr>');
                                        add_to_inventory_index--;


                                        $(".serial_numbers_check").keyup(function() {
                                            var serialNumber = $(this).val();
                                            var id = $(this).data('id');
                                            var errorMessage = $(this).next('.error_message'); // assuming the error message span is right after the input

                                            if (serialNumber.length >= 5) {
                                                $.ajax({
                                                    url: '<?php echo base_url() ?>items/check_serial_number',
                                                    type: 'POST',
                                                    data: {
                                                        serial: serialNumber,
                                                        id: id
                                                    },
                                                    success: function(response) {
                                                        if (response == 'exists') {
                                                            errorMessage.text("<?php echo lang('Serial_Number_already_exists'); ?>!");
                                                        } else {
                                                            errorMessage.text("");
                                                        }
                                                    },
                                                    error: function() {
                                                        errorMessage.text("<?php echo lang('Error_while_checking'); ?>.");
                                                    }
                                                });
                                            } else {
                                                errorMessage.text("");
                                            }
                                        });


                                    });
                                });
                            </script>

                            <div class="modal fade" tabindex="-1" id="modal_serial_log">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title"><?= lang('view_serial_no_log'); ?></h3>

                                            <!--begin::Close-->
                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-dismiss="modal" aria-label="Close">
                                                <span class="svg-icon svg-icon-1">x</span>
                                            </div>
                                            <!--end::Close-->
                                        </div>

                                        <div class="modal-body sn-body">


                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal"><?= lang('Close'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" tabindex="-1" id="modal_serial">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title"><?= lang('Enter_Serial_range'); ?></h3>

                                            <!--begin::Close-->
                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-dismiss="modal" aria-label="Close">
                                                <span class="svg-icon svg-icon-1">x</span>
                                            </div>
                                            <!--end::Close-->
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class="required form-label"><?= lang('Prefix'); ?></label>
                                                <input type="text" id="prefix" class="form-control form-control-solid" placeholder="<?= lang('Prefix'); ?>" />
                                            </div>
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class="required form-label"><?= lang('From'); ?></label>
                                                <input type="text" id="from_serial" class="form-control form-control-solid" placeholder="<?= lang('From'); ?>" />
                                            </div>
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class="required form-label"><?= lang('To'); ?></label>
                                                <input type="text" id="to_serial" class="form-control form-control-solid" placeholder="<?= lang('To'); ?>" />
                                            </div>

                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" id="add_to_inventory" />
                                                <label class="form-check-label" for="add_to_inventory">
                                                    <?= lang('add_to_inventory') ?>
                                                </label>
                                            </div>

                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" id="replace_sale_date" />
                                                <label class="form-check-label" for="replace_sale_date">
                                                    <?= lang('replace_sale_date') ?>
                                                </label>
                                            </div>
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class="required form-label"><?= lang('cost_price'); ?></label>
                                                <input type="text" id="cost_price" class="form-control form-control-solid" placeholder="<?= lang('cost_price'); ?>" />
                                            </div>
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class="required form-label"><?= lang('price'); ?></label>
                                                <input type="text" id="price" class="form-control form-control-solid" placeholder="<?= lang('price'); ?>" />
                                            </div>


                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class="required form-label"><?= lang('warranty_start'); ?></label>
                                                <input type="date" id="warranty_start" class="form-control form-control-solid" placeholder="<?= lang('warranty_start'); ?>" />
                                            </div>
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class="required form-label"><?= lang('warranty_end'); ?></label>
                                                <input type="date" id="warranty_end" class="form-control form-control-solid" placeholder="<?= lang('warranty_end'); ?>" />
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal"><?= lang('Close'); ?></button>
                                            <button type="button" id="generate" class="btn btn-primary"><?= lang('Add'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" tabindex="-1" id="modal_serial_edit">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title"><?= lang('edit_Serial_numbers'); ?></h3>

                                            <!--begin::Close-->
                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-dismiss="modal" aria-label="Close">
                                                <span class="svg-icon svg-icon-1">x</span>
                                            </div>
                                            <!--end::Close-->
                                        </div>

                                        <div class="modal-body">

                                            <!--begin::Alert-->
                                            <div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row p-5 mb-10">
                                                <!--begin::Icon-->
                                                <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
                                                    <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/general/gen007.svg-->
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="currentColor" />
                                                        <path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Icon-->

                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                                    <!--begin::Title-->
                                                    <h4 class="mb-2 light"><?= lang("alert") ?></h4>
                                                    <!--end::Title-->

                                                    <!--begin::Content-->
                                                    <span><?= lang("Only_fill_in_the_fields_you_wish_to_update") . ", " . lang("leave_any_others_empty") ?>.</span>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Wrapper-->

                                                <!--begin::Close-->
                                                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                                    <span class="svg-icon svg-icon-2x svg-icon-light">...</span>
                                                </button>
                                                <!--end::Close-->
                                            </div>
                                            <!--end::Alert-->




                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" id="replace_sale_date_edit" />
                                                <label class="form-check-label" for="replace_sale_date_edit">
                                                    <?= lang('replace_sale_date') ?>
                                                </label>
                                            </div>
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class=" form-label"><?= lang('cost_price'); ?></label>
                                                <input type="text" id="cost_price_edit" class="form-control form-control-solid" placeholder="<?= lang('cost_price'); ?>" />
                                            </div>
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class=" form-label"><?= lang('price'); ?></label>
                                                <input type="text" id="price_edit" class="form-control form-control-solid" placeholder="<?= lang('price'); ?>" />
                                            </div>


                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class=" form-label"><?= lang('warranty_start'); ?></label>
                                                <input type="date" id="warranty_start_edit" class="form-control form-control-solid" placeholder="<?= lang('warranty_start'); ?>" />
                                            </div>
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class=" form-label"><?= lang('warranty_end'); ?></label>
                                                <input type="date" id="warranty_end_edit" class="form-control form-control-solid" placeholder="<?= lang('warranty_end'); ?>" />
                                            </div>

                                            <input type="hidden" name="edit_sn_ids" id="edit_sn_ids" value="" />

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal"><?= lang('Close'); ?></button>
                                            <button type="button" id="generate_edit" class="btn btn-primary"><?= lang('Update'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
	<?php
		echo form_submit(array(
			'name'=>'submitf',
			'id'=>'submitf',
			'value'=>lang('save'),
			'class'=>'submit_button floating-button btn btn-lg btn-danger')
		);
	?>
</div>
<?php echo form_hidden('redirect', isset($redirect) ? $redirect : ''); ?>
<?php echo form_hidden('progression', isset($redirect) ? $progression : ''); ?>
<?php echo form_hidden('quick_edit', isset($quick_edit) ? $quick_edit : ''); ?>

<?php  echo form_close(); ?>
<script type='text/javascript'>
    $('#item_form').validate({
			submitHandler:function(form)
			{			
				var args = {
					next: {
						label: <?php echo json_encode(lang('edit').' '.lang('pricing')) ?>,
						url: <?php echo json_encode(site_url("items/pricing/".($item_info->item_id ? $item_info->item_id : -1)."?$query")); ?>
					}
				};
		
				doItemSubmit(form, args);
			}
	});
	<?php $this->load->view("partial/common_js"); ?>
    </script>
                            <?php $this->load->view('partial/footer'); ?>