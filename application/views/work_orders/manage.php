<?php $this->load->view("partial/header"); ?>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/css_good/plugins/custom/apexcharts/apexcharts.min.js"></script>


<div class="modal fade new_work_order_modal" id="new_work_order_modal" tabindex="-1" role="dialog"
    aria-labelledby="new_work_order" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:65%;">
        <div class="modal-content">
            <div class="spinner" id="grid-loader1" style="display:none">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
            </div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label=<?php echo json_encode(lang('common_close')); ?>><span style="font-size: 30px;"
                        aria-hidden="true">&times;</span></button>
                <h5 style="font-size: 20px;text-transform: none;" class="modal-title">
                    <?php echo lang('work_orders_new_work_order'); ?></h5>
            </div>
            <div class="modal-body stepper stepper-pills" id="kt_stepper_example_modal">

                <?php echo form_open_multipart('work_orders/save_new_work_order/', array('id' => 'new_work_order_form')); ?>





                <!--begin::Stepper-->
                <div>
                    <!--begin::Nav-->
                    <div class="stepper-nav d-fle flex-center flex-wrap mb-5">
                        <!--begin::Step 1-->
                        <div class="stepper-item mx-4 my-4 current" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">1</span>
                                </div>
                                <!--end::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        <?php echo lang("select_customer"); ?>
                                    </h3>

                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 1-->

                        <!--begin::Step 2-->
                        <div class="stepper-item mx-4 my-4 pending" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">2</span>
                                </div>
                                <!--begin::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        <?php echo lang("select_item"); ?>
                                    </h3>

                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step 2-->


                    </div>
                    <!--end::Nav-->

                    <!--begin::Group-->
                    <div class=" mb-5 scroll-y mh-300px">
                        <!--begin::Step 1-->
                        <div class="flex-column current" data-kt-stepper-element="content">
                            <div class="card  customer_info">
                                <div class="card-header rounded rounded-3 p-5">
                                    <div class="row w-100">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <h4 class="card-title"> <?php echo lang("common_customer"); ?></h4>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="customer_search">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <?php echo anchor("customers/view/-1/3?redirect_new_order=work_orders/index/0/1", "<i class='ion-person-add'></i>", array('class' => 'none', 'title' => lang('common_new_customer'), 'id' => 'new-customer', 'tabindex' => '-1')); ?>
                                                    </span>
                                                    <input type="text" id="customer" name="customer"
                                                        class="add-customer-input keyboardLeft form-control"
                                                        data-title="<?php echo lang('common_customer_name'); ?>"
                                                        placeholder="<?php echo lang('sales_start_typing_customer_name'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="flex-grow-1 customer_data" style="display: none;">
                                        <!--begin::Title-->
                                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                            <!--begin::User-->
                                            <div class="d-flex flex-column">
                                                <!--begin::Name-->
                                                <div class="d-flex align-items-center mb-2">
                                                    <a href="#"
                                                        class="text-gray-900 text-hover-primary fs-2 fw-bold me-1 customer_name">
                                                        <?php if ($customer_id_for_new_work_order) { ?>
                                                            <?php echo $customer_info->first_name . ' ' . $customer_info->last_name; ?>
                                                        <?php }  ?>
                                                    </a>


                                                </div>
                                                <!--end::Name-->

                                                <!--begin::Info-->
                                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                    <a href="#"
                                                        class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2 gap-1">
                                                        <i class="fa fa-envelope"></i><span
                                                            class="customer_email"></span>
                                                    </a>
                                                    <a href="#"
                                                        class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2 gap-1">
                                                        <i class="fa fa-address-book"></i><span
                                                            class="customer_address"><?php if ($customer_id_for_new_work_order) { ?>
                                                                <?php echo $customer_info->address_1 . ' ' . $customer_info->address_2; ?>
                                                            <?php }  ?></span>
                                                    </a>

                                                </div>
                                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2 gap-1">

                                                    <a href="#"
                                                        class="d-flex align-items-center text-gray-500 text-hover-primary mb-2 gap-1">
                                                        <i class="fa-solid fa-city"></i><span
                                                            class="customer_city_state_zip"><?php if ($customer_id_for_new_work_order) { ?>
                                                                <?php echo $customer_info->state . ' ' . $customer_info->zip; ?>
                                                            <?php }  ?></span>
                                                    </a>
                                                    <a href="#"
                                                        class="d-flex align-items-center text-gray-500 text-hover-primary mb-2 gap-1">
                                                        <i class="fa-solid fa-phone"></i><span
                                                            class="customer_phonenumber "></span>
                                                    </a>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::User-->

                                            <!--begin::Actions-->
                                            <div class="d-flex my-4">
                                                <i class="fa fa-trash text-danger delete-customer"></i>

                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Title-->

                                    </div>


                                    <div class='clearfix'></div>
                                </div>
                                <!--/card-body -->
                            </div><!-- /panel-piluku -->

                        </div>
                        <!--end::Step 1-->

                        <!--begin::Step 2-->
                        <div class="flex-column" data-kt-stepper-element="content">
                            <div class="card mt-5">
                                <div class="card-header rounded rounded-3 p-5">
                                    <div class="row w-100">
                                        <div
                                            class="col-lg-6 col-md-6 col-sm-12 col-xs-12 item_being_repaired_info_title">
                                            <h4 class="card-title">
                                                <?php echo lang("work_orders_items_in_this_work_order"); ?></h4>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="item_search">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <?php echo anchor("items/view/-1?redirect=work_orders/index/0&progression=1", "<i class='icon ti-pencil-alt'></i>", array('class' => 'none add-new-item', 'title' => lang('common_new_item'), 'id' => 'new-item', 'tabindex' => '-1')); ?>
                                                    </span>

                                                    <!-- Css Loader  -->
                                                    <div class="spinner" id="ajax-loader" style="display:none">
                                                        <div class="rect1"></div>
                                                        <div class="rect2"></div>
                                                        <div class="rect3"></div>
                                                    </div>

                                                    <input type="text" id="item" name="item"
                                                        class="add-item-input keyboardTop form-control"
                                                        placeholder="<?php echo lang('common_start_typing_item_name'); ?>"
                                                        data-title="<?php echo lang('common_item_name'); ?>">
                                                    <input type="hidden" id="item_description">
                                                </div>
                                            </div>

                                            <div class="text-center"><?php echo lang('common_or'); ?></div>
                                            <div class="text-center"><a id="add_generic_item"
                                                    class="btn btn-primary"><?php echo lang('items_add_as_repair_item'); ?></a>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 item_being_repaired_info_title mt-5">
								<h3 class="card-title"><i class="icon ti-harddrive"></i> <?php echo lang("sale_item"); ?></h3>
							</div>	
							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-5">
							<input type="text" id="item_new" name="item_new"  class="add-item-input-new keyboardTop form-control" placeholder="<?php echo lang('common_start_typing_item_name'); ?>" data-title="<?php echo lang('common_item_name'); ?>">
										<input type="hidden" id="item_new_description">
							</div> -->
                                    </div>
                                </div>

                                <div class="card-body">
                                    <table class="firearms_table table">
                                        <thead>
                                            <tr>
                                                <th class="font-weight-bold">
                                                    <?php echo lang('common_serial_number_full'); ?></th>
                                                <th class="font-weight-bold"><?php echo lang('variation'); ?></th>
                                                <th class="font-weight-bold"><?php echo lang('common_name'); ?></th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody id="firearms_tbody">
                                            <?php
                                            $last_key = 0;
                                            foreach ($items_for_new_work_order as $key => $item) {

                                                $last_key = $key;
                                            ?>
                                                <tr>
                                                    <?php
                                                    if (isset($item['is_serialized']) && $item['is_serialized'] == 1) {
                                                        $s_id = 'serial_number_' . $item['item_id'] . '_' . $key;
                                                        $new_item_td = '<td class="serial"><a href="#" id="' . $s_id . '" class="xeditable" data-value="' . $item['serial_number'] . '" data-name="' . $s_id . '" data-url="' . site_url('work_orders/edit_item_serialnumber/') . $key . '" data-type="text" data-pk="1" data-title="' . H(lang('common_serial_number')) . '"></a></td>';
                                                    } else {
                                                        $new_item_td = '<td></td>';
                                                    }
                                                    echo $new_item_td;
                                                    ?>
                                                    <td><?php echo $item['description'] ?></td>
                                                    <td><?php echo $item['model'] ?></td>
                                                    <td class="text-center"><i class="delete-item icon ion-android-cancel"
                                                            data-index="<?php echo $key; ?>"></i></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--end::Step 2-->

                    </div>
                    <!--end::Group-->
                </div>
                <!--end::Stepper-->







                <input type="hidden" name="customer_id" id="customer_id"
                    value="<?php echo $customer_id_for_new_work_order; ?>">
                <div class="modal-footer d-flex justify-content-end">
                    <!--begin::Wrapper-->
                    <div class="me-2">
                        <button type="button" class="btn btn-light btn-active-light-primary"
                            data-kt-stepper-action="previous">
                            <?php echo lang('Back'); ?>
                        </button>
                    </div>
                    <!--end::Wrapper-->

                    <!--begin::Wrapper-->
                    <div>
                        <button type="submit" name="sale_item_notes_save_btn" id="sale_item_notes_save_btn" class="btn btn-primary sale_item_notes_save_btn" data-kt-stepper-action="submit">
                            <span class="indicator-label">
                                <?php echo lang('Submit'); ?>
                            </span>
                            <span class="indicator-progress">
                                <?php echo lang('Please_wait'); ?>... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>

                        <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                            <?php echo lang('Continue'); ?>
                        </button>
                        <?php


                        echo form_input(
                            array(
                                'type' => 'button',
                                'value' => lang('common_cancel'),
                                'data-dismiss' => 'modal',
                                'style' => 'margin-right: 10px;',
                                'class' => 'pull-right btn btn-warning'
                            )
                        );


                        ?>
                    </div>
                    <!--end::Wrapper-->
                </div>
                <div class="form-actions d-none">

                    <div class="clearfix">&nbsp;</div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="spinner" id="grid-loader" style="display:none">
    <div class="rect1"></div>
    <div class="rect2"></div>
    <div class="rect3"></div>
</div>

<script type="text/javascript">
    // Stepper lement
    var element = document.querySelector("#kt_stepper_example_modal");

    // Initialize Stepper
    var stepper = new KTStepper(element);

    // Handle next step
    stepper.on("kt.stepper.next", function() {

        if ($('#customer_id').val() == '') {
            show_feedback('error', '<?php echo lang('you_must_select_a_customer'); ?>', <?php echo json_encode(lang('common_error')); ?>);
            return false;
        }
        stepper.goNext(); // go next step
    });

    // Handle previous step
    stepper.on("kt.stepper.previous", function() {
        stepper.goPrevious(); // go previous step
    });

    function reload_work_order_table() {
        clearSelections();
        $("#table_holder").load(<?php echo json_encode(site_url("$controller_name/reload_work_order_table")); ?>);
    }

    $(document).ready(function() {

        $('.delete-customer').on('click', function(e) {
            $('#customer_id').val('');
            $('.customer_data').hide();

        });
        $("#technician").select2({
            dropdownAutoWidth: true
        });
        $("#location_listd").select2({
            dropdownAutoWidth: true
        });
        $("#sortable").sortable({
            items: '.sort',
            containment: "#sortable",
            cursor: "move",
            handle: ".handle",
            revert: 100,
            update: function(event, ui) {
                $input = ui.item.find("input[type=checkbox]");
                $input.trigger('change');
            }
        });

        $("#sortable").disableSelection();

        $(document).on(
            'click.bs.dropdown.data-api',
            '[data-toggle="collapse"]',
            function(e) {
                e.stopPropagation()
            }
        );

        $("#config_columns a").on("click", function(e) {
            e.preventDefault();

            if ($(this).attr("id") == "reset_to_default") {
                //Send a get request wihtout columns will clear column prefs
                $.get(<?php echo json_encode(site_url("$controller_name/save_column_prefs")); ?>,
                    function() {
                        reload_work_order_table();
                        var $checkboxs = $("#config_columns a").find("input[type=checkbox]");
                        $checkboxs.prop("checked", false);

                        <?php foreach ($default_columns as $default_col) { ?>
                            $("#config_columns a").find('#' + <?php echo json_encode($default_col); ?>).prop(
                                "checked", true);
                        <?php } ?>
                    });
            }

            if (!$(e.target).hasClass("handle")) {
                var $checkbox = $(this).find("input[type=checkbox]");

                if ($checkbox.length == 1) {
                    $checkbox.prop("checked", !$checkbox.prop("checked")).trigger("change");
                }
            }

            return false;
        });


        $("#config_columns input[type=checkbox]").change(
            function(e) {
                var columns = $("#config_columns input:checkbox:checked").map(function() {
                    return $(this).val();
                }).get();

                $.post(<?php echo json_encode(site_url("$controller_name/save_column_prefs")); ?>, {
                    columns: columns
                }, function(json) {
                    reload_work_order_table();
                });

            });


        enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>");
        enable_select_all();
        enable_checkboxes();
        enable_row_selection();
        enable_search('<?php echo site_url("$controller_name/suggest"); ?>',
            <?php echo json_encode(lang("common_confirm_search")); ?>);

        <?php if (!$deleted) { ?>
            enable_delete(<?php echo json_encode(lang($controller_name . "_confirm_delete")); ?>,
                <?php echo json_encode(lang($controller_name . "_none_selected")); ?>);
        <?php } else { ?>
            enable_delete(<?php echo json_encode(lang($controller_name . "_confirm_undelete")); ?>,
                <?php echo json_encode(lang($controller_name . "_none_selected")); ?>);
        <?php } ?>

        $('#print_work_order_btn').click(function() {
            var selected = get_selected_values();

            $(this).attr('href', '<?php echo site_url("$controller_name/print_work_order"); ?>/' + selected
                .join('~'));
        });

        $('#print_service_tag_btn').click(function() {
            var selected = get_selected_values();
            if (selected.length == 0) {
                bootbox.alert(<?php echo json_encode(lang('common_must_select_item_for_barcode')); ?>);
                return false;
            }

            var default_to_raw_printing = "<?php echo $this->config->item('default_to_raw_printing'); ?>";
            if (default_to_raw_printing == "1") {
                $(this).attr('href', '<?php echo site_url("work_orders/raw_print_service_tag"); ?>/' +
                    selected.join('~'));
            } else {
                $(this).attr('href', '<?php echo site_url("work_orders/print_service_tag"); ?>/' + selected
                    .join('~'));
            }
        });

        $("#change_status").change(function() {
            var status = $(this).val();
            if (status != '') {
                bootbox.confirm(<?php echo json_encode(lang($controller_name . "_confirm_status_change")); ?>,
                    function(result) {
                        if (result) {
                            $.get('<?php echo site_url("work_orders/get_work_order_status_info"); ?>', {
                                status_id: status
                            }, function(response) {
                                change_status();
                            }, 'json');
                        }
                    });
            }

        });

        function change_status(supplier_id = '') {
            $('#grid-loader').show();
            var work_order_ids = get_selected_values();
            var status = $("#change_status").val();
            $.post('<?php echo site_url("work_orders/work_orders_status_change/"); ?>', {
                    work_order_ids: work_order_ids,
                    status: status,
                    supplier_id: supplier_id
                },
                function(response) {
                    $('#grid-loader').hide();
                    show_feedback(response.success ? 'success' : 'error', response.message, response.success ?
                        <?php echo json_encode(lang('common_success')); ?> :
                        <?php echo json_encode(lang('common_error')); ?>);

                    //Refresh tree if success
                    if (response.success) {
                        setTimeout(function() {
                            location.href = location.href;
                        }, 800);
                    }
                },
                "json"
            );
        }





        $(".excel_export_btn").click(function(e) {
            var selected = get_selected_values();
            $(this).attr('href', '<?php echo site_url("$controller_name/excel_export_selected_rows"); ?>/' +
                selected.join('~'));
        });

        // $("#firearms_tbody tr td.serial>a").editable();

        $("#firearms_tbody tr td.serial>a").editable({
            success: function(response, newValue) {
                var ret = JSON.parse(response);
                $('#' + ret.id).val(newValue);
                $('#' + ret.id).attr('data-value', newValue);
            }
        });

    });
</script>



<?php if ($status_boxes) { ?>
    <div class="">




        <div class="card border-primary statistics-wo">
            <div class="card-header">
                <h3 class="card-title"> <?php echo  lang('work_order_stats') ?> </h3>



            </div>

            <div class="card-body">
                <div class="row">
                    <div class="  col-12 ">
                        <div id="donutChart" style="min-height: 400px;"></div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="modal_serial_log">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><?= lang('view_serial_no_log'); ?></h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-dismiss="modal"
                            aria-label="Close">
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


        <script>
            var options = {
                series: [<?php foreach ($status_boxes as $status_box) {
                            ?>
                        <?php echo $status_box['total'] ?>,

                    <?php  } ?>
                ], // Example data
                chart: {
                    type: 'donut',
                    height: '200',
                    events: {
                        dataPointSelection: function(event, chartContext, config) {
                            // Identify the clicked slice
                            const selectedSliceIndex = config.dataPointIndex;
                            console.log(selectedSliceIndex);
                            var url =
                                '<?php echo base_url() ?>reports/generate/detailed_work_order?report_type=simple&report_date_range_simple=ALL_TIME&start_date_formatted=10/1/2023+12:00+am&with_time=1&end_date_end_of_day=0&sale_type=all&currency=&register_id=&email=&export_excel=0&select_all=1';
                            switch (selectedSliceIndex) {
                                case 0:
                                    url = url + +'&status=1';
                                    window.location.href = url;
                                    break;
                                case 1:
                                    url = url + +'&status=2';
                                    window.location.href = url;
                                    break;
                                case 2:
                                    url = url + +'&status=3';
                                    window.location.href = url;
                                    break;
                                case 3:
                                    url = url + +'&status=4';
                                    window.location.href = url;
                                    break;
                                default:
                                    console.log('Unknown slice clicked.');
                            }
                        }
                    }
                },
                colors: [<?php foreach ($status_boxes as $status_box) {

                            ?> '<?php echo $status_box['colors']; ?>',
                    <?php  } ?>
                ],
                labels: [

                    <?php foreach ($status_boxes as $status_box) {

                    ?> '<?php echo lang($this->Work_order->get_status_name($status_box['full_name'])); ?>',
                    <?php } ?>

                ], // Corresponding labels for the data
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 1400
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#donutChart"), options);
            chart.render();
        </script>


    <?php } ?>
    <?php
    function getStatusCardClass($status_name)
    {
        switch ($status_name) {
            case 'Complete':
                return 'bg-primary';
            case 'New':
                return 'bg-info';

            case 'In Progress':
                return 'bg-primary';

            case 'Waiting On Customer':
                return 'bg-warning';

            case 'Out For Repair':
                return 'bg-secondary';

            case 'Cancelled':
                return 'bg-danger';

            default:
                return 'bg-light';
        }
    }
    ?>



    <div class="container-fluid">
        <div class="row manage-table  card p-5">
            <div class=" ">
                <div class="card-header align-items-center p-0 gap-2 gap-md-5">
                    <div class="manage-row-options   px-5 hidden">
                        <div class="email_buttons work_orders pt-0 text-center border-none d-flex">

                            <?php if (!$deleted) { ?>
                                <?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                    <?php echo anchor(
                                        "$controller_name/delete",
                                        '<span class="ion-trash-a"></span> <span class="hidden-xs">' . lang('common_delete') . '</span>',
                                        array('id' => 'delete', 'class' => 'btn btn-danger btn-lg disabled delete_inactive ', 'title' => lang("common_delete"))
                                    ); ?>
                                <?php } ?>

                                <a href="#" class="btn btn-lg btn-clear-selection btn-warning"><span
                                        class="ion-close-circled"></span> <span
                                        class="hidden-xs"><?php echo lang('common_clear_selection'); ?></span></a>
                                <a href="#" class="btn btn-lg btn-primary"
                                    id="print_work_order_btn"><?php echo lang('work_orders_print_work_order'); ?></a>
                                <a href="#" class="btn btn-lg btn-primary"
                                    id="print_service_tag_btn"><?php echo lang('work_orders_print_service_tag'); ?></a>
                                <a href="#"
                                    class="btn btn-lg btn-success excel_export_btn"><?php echo lang('common_excel_export'); ?></a>

                            <?php } else { ?>
                                <?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                    <?php echo anchor(
                                        "$controller_name/undelete",
                                        '<span class="ion-trash-a"></span> ' . '<span class="hidden-xs">' . lang("common_undelete") . '</span>',
                                        array('id' => 'delete', 'class' => 'btn btn-success btn-lg disabled delete_inactive', 'title' => lang("common_undelete"))
                                    ); ?>
                                <?php } ?>

                                <a href="#" class="btn btn-lg btn-clear-selection btn-warning"><span
                                        class="ion-close-circled"></span> <?php echo lang('common_clear_selection'); ?></a>
                            <?php } ?>
                            <?php
                            echo form_dropdown('change_status', $change_status_array, '', 'class="panel_heading_option visibility-hidden form-select form-select-solid" style="width: 30%;display: inline;" id="change_status"');
                            ?>
                        </div>
                    </div>


                    <h3 class="card-title">

                        <div class="manage_buttons mb-5">
                            <!-- Css Loader  -->
                            <div class="spinner" id="ajax-loader" style="display:none">
                                <div class="rect1"></div>
                                <div class="rect2"></div>
                                <div class="rect3"></div>
                            </div>

                        </div>



                        <!-- <?php echo ($deleted ? lang('common_deleted') . ' ' : '') . lang('module_' . $controller_name); ?>
					<span title="<?php echo $total_rows; ?> total work orders" class="badge bg-primary tip-left "  id="manage_total_items"><?php echo $total_rows; ?></span> -->




                        <span class="panel-options custom">
                            <div class="pagination pagination-top hidden-print  text-center" id="pagination_top">
                                <?php echo $pagination; ?>
                            </div>
                        </span>
                    </h3>
                    <div class="card-toolbar display-flex justify-content-between ">
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="fa fa-filter fs-2"></i> <?= lang('Filter'); ?>
                        </button>

                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" style="">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-gray-900 fw-bold"> <?= lang('Filter_Options'); ?></div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->

                            <!--begin::Content-->
                            <div class="px-7 py-5" data-kt-user-table-filter="form">
                                <?php echo form_open("$controller_name/search", array('id' => 'search_form', 'autocomplete' => 'off')); ?>
                                <!--begin::Input group-->

                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold"><?= lang('search') ?>:</label>
                                    <input type="text"
                                        class="form-control form-control form-control-solid w-100"
                                        name='search' id='search' value="<?php echo H($search); ?>"
                                        placeholder="<?php echo $deleted ? lang('common_search_deleted') : lang('common_search'); ?> <?php echo lang('module_' . $controller_name); ?>" />

                                </div>


                                <?php if (getenv('MASTER_USER') == $this->Employee->get_logged_in_employee_info()->id) { ?>

                                    <div class="mb-10">
                                        <label class="form-label fs-6 fw-semibold"><?= lang('location') ?>:</label>



                                        <?php
                                        echo form_dropdown('location', $locations, $location, 'class="" id="location_listd"');
                                        ?>




                                    </div>
                                <?php } ?>
                                <!--end::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold"><?= lang('technician') ?>:</label>
                                    <?php
                                    echo form_dropdown('technician', $employees, $technician, 'class="" id="technician"');
                                    ?>
                                </div>
                                <div class="mb-10">
                                    <button type="submit" class="btn btn-primary btn-sm py-4 "
                                        id="hide_completed_work_orders_btn">
                                        <?php echo form_checkbox(array(
                                            'name' => 'hide_completed_work_orders',
                                            'id' => 'hide_completed_work_orders',
                                            'class' => 'form-check-input p-0 m-0 hidden',
                                            'value' => '1',
                                            'checked' => $hide_completed_work_orders ? true : false
                                        )); ?>

                                        <?php echo form_label(lang('hide_completed'), 'hide_completed_work_orders', array('class' => 'control-label text-light p-0 m-0', 'style' => 'padding-right: 30px; margin-left:0px')); ?>

                                    </button>
                                </div>

                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter"><?= lang('Apply'); ?></button>
                                </div>
                                <!--end::Actions-->
                                </form>
                            </div>
                            <!--end::Content-->
                        </div>
                        <div class="">
                            <div class="">
                                <div class="">
                                    <div class="search no-left-border">
                                        <ul class="list-inline">

                                            <li>
                                                <div
                                                    class="clear-block <?php echo ($search == '' && $status == '' && $technician == '-1') ? 'hidden' : ''  ?>">
                                                    <a class="clear btn btn-danger"
                                                        href="<?php echo site_url($controller_name . '/clear_state'); ?>">
                                                        <?= lang('clear_filter') ?>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="status" id="status" value="<?php echo $status; ?>">


                                </div>

                            </div>
                        </div>
                        <?php if ($this->session->flashdata('error')) { ?>
                            show_feedback('error', <?php echo json_encode($this->session->flashdata('error')); ?>, <?php echo json_encode(lang('common_error')); ?>);
                        <?php } ?>


                        <div class="buttons-list">
                            <div class="pull-right-btn">
                                <!-- right buttons-->
                                <?php if ($this->Employee->has_module_action_permission($controller_name, 'edit', $this->Employee->get_logged_in_employee_info()->person_id) && !$deleted) { ?>
                                <?php echo anchor(
                                        "",
                                        '<span class="ion-plus"> ' . lang('work_orders_new_work_order') . '</span>',
                                        array('id' => 'new_work_order_btn', 'class' => 'btn btn-primary btn-lg', 'title' => lang('work_orders_new_work_order'))
                                    );
                                }
                                ?>
                                <?php if ($deleted) {
                                    echo
                                    anchor(
                                        "$controller_name/toggle_show_deleted/0",
                                        '<span class="ion-android-exit"></span> <span class="hidden-xs">' . lang('common_done') . '</span>',
                                        array('class' => 'btn btn-primary btn-lg toggle_deleted', 'title' => lang('common_done'))
                                    );
                                } ?>
                                <button class="btn btn-light btn-icon-success btn-text-success togglestats">
                                    <span class="svg-icon svg-icon-muted svg-icon-2"><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M14 12V21H10V12C10 11.4 10.4 11 11 11H13C13.6 11 14 11.4 14 12ZM7 2H5C4.4 2 4 2.4 4 3V21H8V3C8 2.4 7.6 2 7 2Z"
                                                fill="currentColor" />
                                            <path
                                                d="M21 20H20V16C20 15.4 19.6 15 19 15H17C16.4 15 16 15.4 16 16V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <?= lang('Toggle_Stats'); ?>
                                </button>
                                <?php if (!$deleted) { ?>

                                    <div class="piluku-dropdown btn-group">
                                        <button type="button" class="btn btn-more btn-light-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-expanded="false">
                                            <span class="hidden-xs ion-android-more-horizontal"> </span>
                                            <i class="visible-xs ion-android-more-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            <?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                                <li>
                                                    <?php echo anchor(
                                                        "$controller_name/toggle_show_deleted/1",
                                                        '<span class="ion-trash-a"> ' . lang($controller_name . "_manage_deleted") . '</span>',
                                                        array('class' => 'toggle_deleted', 'title' => lang($controller_name . "_manage_deleted"))
                                                    ); ?>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->Employee->has_module_action_permission($controller_name, 'manage_statuses', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                                <li>
                                                    <?php echo anchor(
                                                        "$controller_name/manage_statuses?redirect=work_orders",
                                                        '<span class="ion-settings"> ' . lang('module_manage_statuses') . '</span>',
                                                        array('class' => 'manage_statuses', 'title' => lang('module_manage_statuses'))
                                                    ); ?>
                                                </li>
                                            <?php } ?>
                                            <li>
                                                <?php echo anchor(
                                                    "work_orders/import_work_orders",
                                                    '<span class="ion-ios-download-outline"> ' . lang('work_orders_import') . '</span>',
                                                    array('title' => lang('work_orders_import'))
                                                ); ?>
                                            </li>
                                            <li>
                                                <?php echo anchor("$controller_name/custom_fields", '<span class="ion-wrench"> ' . lang('common_custom_field_config') . '</span>', array('id' => 'custom_fields', 'class' => '', 'title' => lang('common_custom_field_config'))); ?>
                                            </li>

                                            <li>
                                                <?php echo anchor(
                                                    "$controller_name/manage_template?redirect=work_orders",
                                                    '<span class="ion-email"> ' . lang('deliveries_manage_email_template') . '</span>',
                                                    array('class' => 'manage_statuses', 'title' => lang('deliveries_manage_email_template'))
                                                ); ?>
                                            </li>
                                            <li>
                                                <?php echo anchor(
                                                    "$controller_name/manage_checkboxes?redirect=work_orders",
                                                    '<span class="ion-settings"> ' . lang('module_manage_checkboxes') . '</span>',
                                                    array('class' => 'manage_checkboxes', 'title' => lang('module_manage_checkboxes'))
                                                ); ?>
                                            </li>
                                        </ul>
                                    </div>
                                <?php } ?>
                                <form id="config_columns">
                                    <div class="piluku-dropdown btn-group table_buttons pull-right">
                                        <button type="button" class="btn btn-more btn-light-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-expanded="false">
                                            <i class="ion-gear-a"></i>
                                        </button>

                                        <ul id="sortable" class="dropdown-menu dropdown-menu-left col-config-dropdown"
                                            role="menu">
                                            <li class="dropdown-header"><a id="reset_to_default"
                                                    class="pull-right"><span class="ion-refresh"></span>
                                                    <?php echo lang('common_reset'); ?></a>
                                                <?php echo lang('common_column_configuration'); ?></li>

                                            <?php foreach ($all_columns as $col_key => $col_value) {
                                                $checked = '';

                                                if (isset($selected_columns[$col_key])) {
                                                    $checked = 'checked ="checked" ';
                                                }
                                            ?>
                                                <li class="sort">
                                                    <span class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input <?php echo $checked; ?>
                                                            name="selected_columns[]" type="checkbox"
                                                            class="columns form-check-input pull-left " id="<?php echo $col_key; ?>"
                                                            value="<?php echo $col_key; ?>">
                                                        <label
                                                            class="form-check-label"
                                                            for="<?php echo $col_key; ?>"><span></span><?php echo H($col_value['label']); ?></label>
                                                        <span
                                                            class="handle ion-drag pull-right"></span></span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body nopadding table_holder table-responsive" id="table_holder">
                    <?php echo $manage_table; ?>
                </div>
            </div>
            <div class="text-center">
                <div class="pagination hidden-print alternate text-center" id="pagination_bottom">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#hide_completed_work_orders_btn').on('click', function() {
                console.log("hide_completed_work_orders_btn");
                if ($("#hide_completed_work_orders").is(":checked")) {

                    $('#hide_completed_work_orders').prop('checked', false);
                    $("label[for='hide_completed_work_orders']").text("<?= lang('Hide_Completed'); ?>");
                } else {
                    $('#hide_completed_work_orders').prop('checked', true);
                    $("label[for='hide_completed_work_orders']").text("<?= lang('Show_Completed'); ?>");
                }
            });

            $("#hide_completed_work_orders").change(function() {
                // Check if the checkbox is checked
                if ($(this).is(":checked")) {
                    // Update the label to "Show Completed"
                    $("label[for='hide_completed_work_orders']").text("<?= lang('Show_Completed'); ?>");
                } else {
                    // Update the label to "Hide Completed"
                    $("label[for='hide_completed_work_orders']").text("<?= lang('Hide_Completed'); ?>");
                }
            });
            if ($("#hide_completed_work_orders").is(":checked")) {
                // Update the label to 
                $("label[for='hide_completed_work_orders']").text("<?= lang('Show_Completed'); ?>");
            } else {
                // Update the label to 
                $("label[for='hide_completed_work_orders']").text("<?= lang('Hide_Completed'); ?>");
            }

            // Check localStorage on page load and apply the correct state
            if (localStorage.getItem("statsVisibility-wo") === "hidden") {
                $(".statistics-wo").hide(); // Hide the statistics section if stored state is "hidden"
            } else {
                $(".statistics-wo").show(); // Show the statistics section otherwise
            }

            // On toggle button click, toggle visibility and update localStorage
            $(".togglestats").click(function() {



                $(".statistics-wo").fadeToggle();




                setTimeout(function() {
                    // Store the new state in localStorage
                    if ($(".statistics-wo").is(":visible")) {
                        localStorage.setItem("statsVisibility-wo",
                            "visible"); // Save the state as visible
                    } else {
                        localStorage.setItem("statsVisibility-wo",
                            "hidden"); // Save the state as hidden
                    }
                }, 500)


            });
        });
        var last_item_key = <?php echo $last_key + 1; ?>;
        let search_result = '';
        let online_items_ammo = '';
        let online_items_barcodelookup = '';

        $('#supplier_id').selectize({
            create: false,
            render: {
                item: function(item, escape) {
                    var item = '<div class="item">' + escape($('<div>').html(item.text).text()) + '</div>';
                    return item;
                },
                option: function(item, escape) {
                    var option = '<div class="option">' + escape($('<div>').html(item.text).text()) + '</div>';
                    return option;
                }
            }
        });

        $(document).ready(function() {

            $('#s2id_location_listd').on('click', function() {

                $('#technician').select2('close'); // Close the previously opened dropdown

            });


            $('#s2id_technician').on('click', function() {

                $('#location_listd').select2('close'); // Close the previously opened dropdown

            });



            <?php if ($this->session->flashdata('success')) { ?>
                show_feedback('success', <?php echo json_encode($this->session->flashdata('success')); ?>,
                    <?php echo json_encode(lang('common_success')); ?>);
            <?php } ?>

            <?php if ($this->session->flashdata('error')) { ?>
                show_feedback('error', <?php echo json_encode($this->session->flashdata('error')); ?>,
                    <?php echo json_encode(lang('common_error')); ?>);
            <?php } ?>

            <?php if ($open_new) { ?>
                // $("#new_work_order_btn").trigger('click');
                console.log("added_new_item_id_work_order");
                var added_new_item_id_work_order =
                    "<?php echo $this->session->flashdata('added_new_item_id_work_order') ?>"
                if (added_new_item_id_work_order) {
                    item_select(added_new_item_id_work_order);
                    $("#new_work_order_modal").modal('show');
                } else {
                    $("#new_work_order_modal").modal('show');
                }
            <?php } ?>
        });

        // $("#new_work_order_btn").click(function(e) {
        //     e.preventDefault();
        //     $.post('<?php echo site_url("work_orders/init_for_new_work_order"); ?>', function(response) {
        //         init_for_new_work_order();
        //         $("#new_work_order_modal").modal('show');
        //     }, 'json');

        //     $("#new_work_order_modal").on('shown.bs.modal', function(e) {
        //         $('#item').focus();
        //     });
        // });
        $("#new_work_order_btn").click(function(e) {
            e.preventDefault();

            // Check work order limitations
            $.post('<?php echo site_url("work_orders/check_limit"); ?>', function(response) {
                if (!response.success) {
                    show_feedback('error', response.message, '<?php echo lang("common_error"); ?>');
                } else {
                    // Proceed with opening the modal
                    $.post('<?php echo site_url("work_orders/init_for_new_work_order"); ?>', function(initResponse) {
                        init_for_new_work_order();
                        $("#new_work_order_modal").modal('show');
                    }, 'json');
                }
            }, 'json');
        });


        $("#customer").autocomplete({
            source: '<?php echo site_url("work_orders/customer_search"); ?>',
            delay: 150,
            autoFocus: false,
            minLength: 0,
            appendTo: '#new_work_order_modal',
            select: function(event, ui) {
                $('#customer_id').val(decodeHtml(ui.item.value));

                $.post('<?php echo site_url("work_orders/select_customer"); ?>', {
                    customer: decodeHtml(ui.item.value)
                }, function(response) {
                    $('.customer_data').show();
                    var customer_info = response.customer_data;
                    $('#customer_id').val(customer_info.person_id);
                    $('#customer').val('');
                    $('.customer_name').html(customer_info.first_name + ' ' + customer_info.last_name);
                    $('.customer_address').html(customer_info.address_1 + ' ' + customer_info
                        .address_2);
                    $('.customer_city_state_zip').html(customer_info.city + ',' + customer_info.state +
                        ' ' + customer_info.zip);

                    $('.customer_email').html(customer_info.email);
                    $('.customer_email').attr('href', 'mailto:' + customer_info.email);

                    $('.customer_phonenumber').html(customer_info.phone_number);
                    $('.customer_phonenumber').attr('href', 'tel:' + customer_info.phone_number);


                }, 'json');
            },
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li class='customer-badge suggestions'></li>")
                .data("item.autocomplete", item)
                .append('<a class="suggest-item"><div class="avatar">' +
                    '<img src="' + item.avatar + '" alt="">' +
                    '</div>' +
                    '<div class="details">' +
                    '<div class="name">' +
                    item.label +
                    '</div>' +
                    '<span class="email">' +
                    item.subtitle +
                    '</span>' +
                    '</div></a>')
                .appendTo(ul);
        };

        <?php
        $vendor_list = array();
        if ($this->config->item('branding')['code'] == 'phpsalesmanager') {
            if ($this->config->item('ig_api_bearer_token') && $this->config->item('enable_ig_integration')) {
                array_push($vendor_list, 'ig_api_bearer_token');
            }
            if ($this->config->item('wgp_integration_pkey') && $this->config->item('enable_wgp_integration')) {
                array_push($vendor_list, 'wgp_integration_pkey');
            }
            if ($this->config->item('p4_api_bearer_token') && $this->config->item('enable_p4_integration')) {
                array_push($vendor_list, 'p4_api_bearer_token');
            }
        }
        ?>

        $("#add_generic_item").click(function(e) {
            e.preventDefault();

            bootbox.prompt({
                title: <?php echo json_encode(lang('common_description')); ?>,
                inputType: 'text',
                callback: function(desc) {
                    if (desc) {
                        add_additional_item(desc);
                    }
                }
            });




        });

        if ($("#item_new").length) {
            $("#item_new").autocomplete({
                source: '<?php echo site_url("work_orders/item_new_search"); ?>',
                delay: 150,
                autoFocus: false,
                minLength: 0,
                appendTo: '#new_work_order_modal',
                select: function(event, ui) {
                    if (ui.item.value == false) {
                        add_additional_item($("#item_description").val());
                    } else {
                        <?php if ($work_orders_repair_item) { ?>
                            if (ui.item.value == <?php echo $work_orders_repair_item; ?>) {
                                add_additional_item($("#item_new_description").val());
                            } else {
                                item_select(ui.item.value, ui.item.serial_number);
                            }
                        <?php } else { ?>
                            item_select(ui.item.value, ui.item.serial_number);
                        <?php } ?>
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
                            .warranty + ' </span>' : '') +
                        '<span class="attributes">' + '<?php echo lang("common_category"); ?>' +
                        ' : <span class="value">' + (item.category ? item.category :
                            <?php echo json_encode(lang('common_none')); ?>) + '</span></span>' +
                        <?php if ($this->Employee->has_module_action_permission('items', 'see_item_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>(
                                typeof item.quantity !== 'undefined' && item.quantity !== null ?
                                '<span class="attributes">' + '<?php echo lang("common_quantity"); ?>' +
                                ' <span class="value">' + item.quantity + '</span></span>' : '') +
                        <?php } ?>(item.attributes ? '<span class="attributes">' +
                            '<?php echo lang("common_attributes"); ?>' + ' : <span class="value">' + item.attributes +
                            '</span></span>' : '') +

                        '</div>')
                    .appendTo(ul);
            };

            $('#item_new').bind('keypress', function(e) {
                    if (e.keyCode == 13) {
                        localStorage.setItem('item_search_key', $("#new_work_order_form #item_new").val());
                        e.preventDefault();
                        var search_value = $("#item_new").val();
                        item_found = true;
                        $.post('<?php echo site_url("work_orders/add_but_not_save"); ?>', {
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
                                        var new_item_tr = '<tr><td class="serial"><a href="#" id="' +
                                            s_id + '" class="xeditable" data-value="' + item
                                            .serial_number + '" data-name="' + s_id +
                                            '" data-url="<?php echo site_url('work_orders/edit_item_serialnumber/'); ?>' +
                                            index +
                                            '" data-type="text" data-pk="1" data-title="<?php echo H(lang('common_serial_number')); ?>">' +
                                            item.serial_number + '</a></td><td>' + item.description +
                                            '</td><td>' + item.model +
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
                                    $.get('<?php echo site_url("work_orders/item_new_search"); ?>', {
                                            term: $("#item_new").val()
                                        }, function(response) {
                                            var data = JSON.parse(response);

                                            <?php if (!$work_orders_repair_item) { ?>
                                                if (data.length == 1 && data[0].value) {
                                                    item_select(data[0].value, data[0].serial_number);
                                                } else if (data.length == 1 && !data[0].value &&
                                                    <?php echo count($vendor_list) > 0 ? 1 : 0 ?>) {
                                                <?php } else { ?>
                                                    if (data.length == 1 && data[0].value && data[0].value !=
                                                        <?php echo $work_orders_repair_item; ?>) {
                                                        item_select(data[0].value, data[0].serial_number);
                                                    } else if (data.length == 1 && data[0].value ==
                                                        <?php echo $work_orders_repair_item; ?> &&
                                                        <?php echo count($vendor_list) > 0 ? 1 : 0 ?>) {
                                                    <?php } ?>

                                                    setTimeout(function() {
                                                        var search_item_key = localStorage.getItem(
                                                            'item_search_key');
                                                        if (search_item_key.trim() != "") {

                                                            $("#new_work_order_form #item").val(
                                                                search_item_key);
                                                            bootbox.dialog({
                                                                message: <?php echo json_encode(lang("sales_ask_search_in_other_vendors")); ?>,
                                                                size: 'large',
                                                                onEscape: true,
                                                                backdrop: true,
                                                                buttons: {
                                                                    <?php if (in_array('ig_api_bearer_token', $vendor_list)) { ?>
                                                                        api_ig: {
                                                                            label: 'Injured Gadgets',
                                                                            className: 'btn-info',
                                                                            callback: function() {

                                                                                $("#item_new")
                                                                                    .autocomplete(
                                                                                        'option',
                                                                                        'source',
                                                                                        '<?php echo site_url("home/sync_ig_item_search"); ?>'
                                                                                    );

                                                                                $("#item_new")
                                                                                    .autocomplete(
                                                                                        'option',
                                                                                        'response',
                                                                                        function(
                                                                                            event,
                                                                                            ui
                                                                                        ) {
                                                                                            $("#new_work_order_form .spinner")
                                                                                                .hide();
                                                                                            var source_url =
                                                                                                $(
                                                                                                    "#item_new"
                                                                                                )
                                                                                                .autocomplete(
                                                                                                    'option',
                                                                                                    'source'
                                                                                                );

                                                                                            if (ui
                                                                                                .content
                                                                                                .length ==
                                                                                                0 &&
                                                                                                (source_url
                                                                                                    .indexOf(
                                                                                                        'work_orders/item_new_search'
                                                                                                    ) >
                                                                                                    -
                                                                                                    1
                                                                                                ) &&
                                                                                                $(
                                                                                                    "#new_work_order_form #item_new"
                                                                                                )
                                                                                                .val()
                                                                                                .trim() !=
                                                                                                ""
                                                                                            ) {

                                                                                            } else if (
                                                                                                ui
                                                                                                .content
                                                                                                .length ==
                                                                                                0 &&
                                                                                                (source_url
                                                                                                    .indexOf(
                                                                                                        'home/sync_ig_item_search'
                                                                                                    ) >
                                                                                                    -
                                                                                                    1
                                                                                                )
                                                                                            ) {
                                                                                                var noResult = {
                                                                                                    value: "",
                                                                                                    image: "<?php echo base_url() . "assets/img/item.png"; ?>",
                                                                                                    label: <?php echo json_encode(lang("sales_no_result_found_ig")); ?>
                                                                                                };
                                                                                                ui.content
                                                                                                    .push(
                                                                                                        noResult
                                                                                                    );
                                                                                                $("#item_new")
                                                                                                    .autocomplete(
                                                                                                        'option',
                                                                                                        'source',
                                                                                                        '<?php echo site_url("work_orders/item_new_search"); ?>'
                                                                                                    );
                                                                                            } else {
                                                                                                $("#item_new")
                                                                                                    .autocomplete(
                                                                                                        'option',
                                                                                                        'source',
                                                                                                        '<?php echo site_url("work_orders/item_new_search"); ?>'
                                                                                                    );
                                                                                            }
                                                                                        }
                                                                                    );

                                                                                $("#item_new")
                                                                                    .autocomplete(
                                                                                        'search'
                                                                                    );
                                                                                $("#new_work_order_form .spinner")
                                                                                    .show();

                                                                            }
                                                                        },
                                                                    <?php } ?>

                                                                    <?php if (in_array('wgp_integration_pkey', $vendor_list)) { ?>
                                                                        api_wgp: {
                                                                            label: 'WGP',
                                                                            className: 'btn-info',
                                                                            callback: function() {

                                                                                $("#item_new")
                                                                                    .autocomplete(
                                                                                        'option',
                                                                                        'source',
                                                                                        '<?php echo site_url("home/sync_wgp_inventory_search"); ?>'
                                                                                    );

                                                                                $("#item_new")
                                                                                    .autocomplete(
                                                                                        'option',
                                                                                        'response',
                                                                                        function(
                                                                                            event,
                                                                                            ui
                                                                                        ) {
                                                                                            $("#new_work_order_form .spinner")
                                                                                                .hide();
                                                                                            var source_url =
                                                                                                $(
                                                                                                    "#item_new"
                                                                                                )
                                                                                                .autocomplete(
                                                                                                    'option',
                                                                                                    'source'
                                                                                                );

                                                                                            if (ui
                                                                                                .content
                                                                                                .length ==
                                                                                                0 &&
                                                                                                (source_url
                                                                                                    .indexOf(
                                                                                                        'work_orders/item_new_search'
                                                                                                    ) >
                                                                                                    -
                                                                                                    1
                                                                                                ) &&
                                                                                                $(
                                                                                                    "#new_work_order_form #item_new"
                                                                                                )
                                                                                                .val()
                                                                                                .trim() !=
                                                                                                ""
                                                                                            ) {

                                                                                            } else if (
                                                                                                ui
                                                                                                .content
                                                                                                .length ==
                                                                                                0 &&
                                                                                                (source_url
                                                                                                    .indexOf(
                                                                                                        'home/sync_wgp_inventory_search'
                                                                                                    ) >
                                                                                                    -
                                                                                                    1
                                                                                                )
                                                                                            ) {
                                                                                                var noResult = {
                                                                                                    value: "",
                                                                                                    image: "<?php echo base_url() . "assets/img/item.png"; ?>",
                                                                                                    label: <?php echo json_encode(lang("sales_no_result_found_wgp")); ?>
                                                                                                };
                                                                                                ui.content
                                                                                                    .push(
                                                                                                        noResult
                                                                                                    );
                                                                                                $("#item_new")
                                                                                                    .autocomplete(
                                                                                                        'option',
                                                                                                        'source',
                                                                                                        '<?php echo site_url("work_orders/item_new_search"); ?>'
                                                                                                    );
                                                                                            } else {
                                                                                                $("#item_new")
                                                                                                    .autocomplete(
                                                                                                        'option',
                                                                                                        'source',
                                                                                                        '<?php echo site_url("work_orders/item_new_search"); ?>'
                                                                                                    );
                                                                                            }
                                                                                        }
                                                                                    );

                                                                                $("#item_new")
                                                                                    .autocomplete(
                                                                                        'search'
                                                                                    );
                                                                                $("#new_work_order_form .spinner")
                                                                                    .show();
                                                                            }
                                                                        },
                                                                    <?php } ?>

                                                                    <?php if (in_array('p4_api_bearer_token', $vendor_list)) { ?>
                                                                        api_p4: {
                                                                            label: 'Parts4Cells',
                                                                            className: 'btn-info',
                                                                            callback: function() {

                                                                                $("#item_new")
                                                                                    .autocomplete(
                                                                                        'option',
                                                                                        'source',
                                                                                        '<?php echo site_url("home/sync_p4_item_search"); ?>'
                                                                                    );

                                                                                $("#item_new")
                                                                                    .autocomplete(
                                                                                        'option',
                                                                                        'response',
                                                                                        function(
                                                                                            event,
                                                                                            ui
                                                                                        ) {
                                                                                            $("#new_work_order_form .spinner")
                                                                                                .hide();
                                                                                            var source_url =
                                                                                                $(
                                                                                                    "#item_new"
                                                                                                )
                                                                                                .autocomplete(
                                                                                                    'option',
                                                                                                    'source'
                                                                                                );

                                                                                            if (ui
                                                                                                .content
                                                                                                .length ==
                                                                                                0 &&
                                                                                                (source_url
                                                                                                    .indexOf(
                                                                                                        'work_orders/item_new_search'
                                                                                                    ) >
                                                                                                    -
                                                                                                    1
                                                                                                ) &&
                                                                                                $(
                                                                                                    "#new_work_order_form #item_new"
                                                                                                )
                                                                                                .val()
                                                                                                .trim() !=
                                                                                                ""
                                                                                            ) {

                                                                                            } else if (
                                                                                                ui
                                                                                                .content
                                                                                                .length ==
                                                                                                0 &&
                                                                                                (source_url
                                                                                                    .indexOf(
                                                                                                        'home/sync_p4_item_search'
                                                                                                    ) >
                                                                                                    -
                                                                                                    1
                                                                                                )
                                                                                            ) {
                                                                                                var noResult = {
                                                                                                    value: "",
                                                                                                    image: "<?php echo base_url() . "assets/img/item.png"; ?>",
                                                                                                    label: <?php echo json_encode(lang("sales_no_result_found_p4")); ?>
                                                                                                };
                                                                                                ui.content
                                                                                                    .push(
                                                                                                        noResult
                                                                                                    );
                                                                                                $("#item_new")
                                                                                                    .autocomplete(
                                                                                                        'option',
                                                                                                        'source',
                                                                                                        '<?php echo site_url("work_orders/item_new_search"); ?>'
                                                                                                    );
                                                                                            } else {
                                                                                                $("#item_new")
                                                                                                    .autocomplete(
                                                                                                        'option',
                                                                                                        'source',
                                                                                                        '<?php echo site_url("work_orders/item_new_search"); ?>'
                                                                                                    );
                                                                                            }
                                                                                        }
                                                                                    );

                                                                                $("#item_new")
                                                                                    .autocomplete(
                                                                                        'search'
                                                                                    );
                                                                                $("#new_work_order_form .spinner")
                                                                                    .show();

                                                                            }
                                                                        },
                                                                    <?php } ?>

                                                                    cancel: {
                                                                        label: <?php echo json_encode(lang("common_cancel")); ?>,
                                                                        className: 'btn-info',
                                                                        callback: function() {}
                                                                    }
                                                                }
                                                            })
                                                        }
                                                    }, 100);

                                                    }
                                                });
                                    }
                                });
                        }
                    });

            }

            if ($("#item").length) {
                $("#item").autocomplete({
                    source: '<?php echo site_url("work_orders/item_search"); ?>',
                    delay: 150,
                    autoFocus: false,
                    minLength: 0,
                    appendTo: '#new_work_order_modal',
                    select: function(event, ui) {
                        if (ui.item.value == false) {
                            add_additional_item($("#item_description").val());
                        } else {
                            <?php if ($work_orders_repair_item) { ?>
                                if (ui.item.value == <?php echo $work_orders_repair_item; ?>) {
                                    add_additional_item($("#item_description").val());
                                } else {
                                    item_select(ui.item.value, ui.item.serial_number);
                                }
                            <?php } else { ?>
                                item_select(ui.item.value, ui.item.serial_number);
                            <?php } ?>
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
                            $.post('<?php echo site_url("work_orders/add_but_not_save"); ?>', {
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
                                                '" data-url="<?php echo site_url('work_orders/edit_item_serialnumber/'); ?>' +
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
                                        $.get('<?php echo site_url("work_orders/item_search"); ?>', {
                                                term: $("#item").val()
                                            }, function(response) {
                                                var data = JSON.parse(response);

                                                <?php if (!$work_orders_repair_item) { ?>
                                                    if (data.length == 1 && data[0].value) {
                                                        item_select(data[0].value, data[0].serial_number);
                                                    } else if (data.length == 1 && !data[0].value &&
                                                        <?php echo count($vendor_list) > 0 ? 1 : 0 ?>) {
                                                    <?php } else { ?>
                                                        if (data.length == 1 && data[0].value && data[0].value !=
                                                            <?php echo $work_orders_repair_item; ?>) {
                                                            item_select(data[0].value, data[0].serial_number);
                                                        } else if (data.length == 1 && data[0].value ==
                                                            <?php echo $work_orders_repair_item; ?> &&
                                                            <?php echo count($vendor_list) > 0 ? 1 : 0 ?>) {
                                                        <?php } ?>

                                                        setTimeout(function() {
                                                            var search_item_key = localStorage.getItem(
                                                                'item_search_key');
                                                            if (search_item_key.trim() != "") {

                                                                $("#new_work_order_form #item").val(
                                                                    search_item_key);
                                                                bootbox.dialog({
                                                                    message: <?php echo json_encode(lang("sales_ask_search_in_other_vendors")); ?>,
                                                                    size: 'large',
                                                                    onEscape: true,
                                                                    backdrop: true,
                                                                    buttons: {
                                                                        <?php if (in_array('ig_api_bearer_token', $vendor_list)) { ?>
                                                                            api_ig: {
                                                                                label: 'Injured Gadgets',
                                                                                className: 'btn-info',
                                                                                callback: function() {

                                                                                    $("#item")
                                                                                        .autocomplete(
                                                                                            'option',
                                                                                            'source',
                                                                                            '<?php echo site_url("home/sync_ig_item_search"); ?>'
                                                                                        );

                                                                                    $("#item")
                                                                                        .autocomplete(
                                                                                            'option',
                                                                                            'response',
                                                                                            function(
                                                                                                event,
                                                                                                ui
                                                                                            ) {
                                                                                                $("#new_work_order_form .spinner")
                                                                                                    .hide();
                                                                                                var source_url =
                                                                                                    $(
                                                                                                        "#item"
                                                                                                    )
                                                                                                    .autocomplete(
                                                                                                        'option',
                                                                                                        'source'
                                                                                                    );

                                                                                                if (ui
                                                                                                    .content
                                                                                                    .length ==
                                                                                                    0 &&
                                                                                                    (source_url
                                                                                                        .indexOf(
                                                                                                            'work_orders/item_search'
                                                                                                        ) >
                                                                                                        -
                                                                                                        1
                                                                                                    ) &&
                                                                                                    $(
                                                                                                        "#new_work_order_form #item"
                                                                                                    )
                                                                                                    .val()
                                                                                                    .trim() !=
                                                                                                    ""
                                                                                                ) {

                                                                                                } else if (
                                                                                                    ui
                                                                                                    .content
                                                                                                    .length ==
                                                                                                    0 &&
                                                                                                    (source_url
                                                                                                        .indexOf(
                                                                                                            'home/sync_ig_item_search'
                                                                                                        ) >
                                                                                                        -
                                                                                                        1
                                                                                                    )
                                                                                                ) {
                                                                                                    var noResult = {
                                                                                                        value: "",
                                                                                                        image: "<?php echo base_url() . "assets/img/item.png"; ?>",
                                                                                                        label: <?php echo json_encode(lang("sales_no_result_found_ig")); ?>
                                                                                                    };
                                                                                                    ui.content
                                                                                                        .push(
                                                                                                            noResult
                                                                                                        );
                                                                                                    $("#item")
                                                                                                        .autocomplete(
                                                                                                            'option',
                                                                                                            'source',
                                                                                                            '<?php echo site_url("work_orders/item_search"); ?>'
                                                                                                        );
                                                                                                } else {
                                                                                                    $("#item")
                                                                                                        .autocomplete(
                                                                                                            'option',
                                                                                                            'source',
                                                                                                            '<?php echo site_url("work_orders/item_search"); ?>'
                                                                                                        );
                                                                                                }
                                                                                            }
                                                                                        );

                                                                                    $("#item")
                                                                                        .autocomplete(
                                                                                            'search'
                                                                                        );
                                                                                    $("#new_work_order_form .spinner")
                                                                                        .show();

                                                                                }
                                                                            },
                                                                        <?php } ?>

                                                                        <?php if (in_array('wgp_integration_pkey', $vendor_list)) { ?>
                                                                            api_wgp: {
                                                                                label: 'WGP',
                                                                                className: 'btn-info',
                                                                                callback: function() {

                                                                                    $("#item")
                                                                                        .autocomplete(
                                                                                            'option',
                                                                                            'source',
                                                                                            '<?php echo site_url("home/sync_wgp_inventory_search"); ?>'
                                                                                        );

                                                                                    $("#item")
                                                                                        .autocomplete(
                                                                                            'option',
                                                                                            'response',
                                                                                            function(
                                                                                                event,
                                                                                                ui
                                                                                            ) {
                                                                                                $("#new_work_order_form .spinner")
                                                                                                    .hide();
                                                                                                var source_url =
                                                                                                    $(
                                                                                                        "#item"
                                                                                                    )
                                                                                                    .autocomplete(
                                                                                                        'option',
                                                                                                        'source'
                                                                                                    );

                                                                                                if (ui
                                                                                                    .content
                                                                                                    .length ==
                                                                                                    0 &&
                                                                                                    (source_url
                                                                                                        .indexOf(
                                                                                                            'work_orders/item_search'
                                                                                                        ) >
                                                                                                        -
                                                                                                        1
                                                                                                    ) &&
                                                                                                    $(
                                                                                                        "#new_work_order_form #item"
                                                                                                    )
                                                                                                    .val()
                                                                                                    .trim() !=
                                                                                                    ""
                                                                                                ) {

                                                                                                } else if (
                                                                                                    ui
                                                                                                    .content
                                                                                                    .length ==
                                                                                                    0 &&
                                                                                                    (source_url
                                                                                                        .indexOf(
                                                                                                            'home/sync_wgp_inventory_search'
                                                                                                        ) >
                                                                                                        -
                                                                                                        1
                                                                                                    )
                                                                                                ) {
                                                                                                    var noResult = {
                                                                                                        value: "",
                                                                                                        image: "<?php echo base_url() . "assets/img/item.png"; ?>",
                                                                                                        label: <?php echo json_encode(lang("sales_no_result_found_wgp")); ?>
                                                                                                    };
                                                                                                    ui.content
                                                                                                        .push(
                                                                                                            noResult
                                                                                                        );
                                                                                                    $("#item")
                                                                                                        .autocomplete(
                                                                                                            'option',
                                                                                                            'source',
                                                                                                            '<?php echo site_url("work_orders/item_search"); ?>'
                                                                                                        );
                                                                                                } else {
                                                                                                    $("#item")
                                                                                                        .autocomplete(
                                                                                                            'option',
                                                                                                            'source',
                                                                                                            '<?php echo site_url("work_orders/item_search"); ?>'
                                                                                                        );
                                                                                                }
                                                                                            }
                                                                                        );

                                                                                    $("#item")
                                                                                        .autocomplete(
                                                                                            'search'
                                                                                        );
                                                                                    $("#new_work_order_form .spinner")
                                                                                        .show();
                                                                                }
                                                                            },
                                                                        <?php } ?>

                                                                        <?php if (in_array('p4_api_bearer_token', $vendor_list)) { ?>
                                                                            api_p4: {
                                                                                label: 'Parts4Cells',
                                                                                className: 'btn-info',
                                                                                callback: function() {

                                                                                    $("#item")
                                                                                        .autocomplete(
                                                                                            'option',
                                                                                            'source',
                                                                                            '<?php echo site_url("home/sync_p4_item_search"); ?>'
                                                                                        );

                                                                                    $("#item")
                                                                                        .autocomplete(
                                                                                            'option',
                                                                                            'response',
                                                                                            function(
                                                                                                event,
                                                                                                ui
                                                                                            ) {
                                                                                                $("#new_work_order_form .spinner")
                                                                                                    .hide();
                                                                                                var source_url =
                                                                                                    $(
                                                                                                        "#item"
                                                                                                    )
                                                                                                    .autocomplete(
                                                                                                        'option',
                                                                                                        'source'
                                                                                                    );

                                                                                                if (ui
                                                                                                    .content
                                                                                                    .length ==
                                                                                                    0 &&
                                                                                                    (source_url
                                                                                                        .indexOf(
                                                                                                            'work_orders/item_search'
                                                                                                        ) >
                                                                                                        -
                                                                                                        1
                                                                                                    ) &&
                                                                                                    $(
                                                                                                        "#new_work_order_form #item"
                                                                                                    )
                                                                                                    .val()
                                                                                                    .trim() !=
                                                                                                    ""
                                                                                                ) {

                                                                                                } else if (
                                                                                                    ui
                                                                                                    .content
                                                                                                    .length ==
                                                                                                    0 &&
                                                                                                    (source_url
                                                                                                        .indexOf(
                                                                                                            'home/sync_p4_item_search'
                                                                                                        ) >
                                                                                                        -
                                                                                                        1
                                                                                                    )
                                                                                                ) {
                                                                                                    var noResult = {
                                                                                                        value: "",
                                                                                                        image: "<?php echo base_url() . "assets/img/item.png"; ?>",
                                                                                                        label: <?php echo json_encode(lang("sales_no_result_found_p4")); ?>
                                                                                                    };
                                                                                                    ui.content
                                                                                                        .push(
                                                                                                            noResult
                                                                                                        );
                                                                                                    $("#item")
                                                                                                        .autocomplete(
                                                                                                            'option',
                                                                                                            'source',
                                                                                                            '<?php echo site_url("work_orders/item_search"); ?>'
                                                                                                        );
                                                                                                } else {
                                                                                                    $("#item")
                                                                                                        .autocomplete(
                                                                                                            'option',
                                                                                                            'source',
                                                                                                            '<?php echo site_url("work_orders/item_search"); ?>'
                                                                                                        );
                                                                                                }
                                                                                            }
                                                                                        );

                                                                                    $("#item")
                                                                                        .autocomplete(
                                                                                            'search'
                                                                                        );
                                                                                    $("#new_work_order_form .spinner")
                                                                                        .show();

                                                                                }
                                                                            },
                                                                        <?php } ?>

                                                                        cancel: {
                                                                            label: <?php echo json_encode(lang("common_cancel")); ?>,
                                                                            className: 'btn-info',
                                                                            callback: function() {}
                                                                        }
                                                                    }
                                                                })
                                                            }
                                                        }, 100);

                                                        }
                                                    });
                                        }
                                    });
                            }
                        });

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
                        $.post('<?php echo site_url("work_orders/add_item"); ?>', {
                            description: item_info.description,
                            serial_number: serial_numbers,
                            model: model,
                            item_id: item_id,
                            is_serialized: item_is_serialized,
                            item_kit_id: item_kit_id,
                            selected_item_variation_id: item_variation_id
                        }, function(response) {
                            if (response.success) {

                                if (item_is_serialized == 1) {

                                    if (serial_numbers != undefined && serial_numbers != null) {
                                        var s_id = 'serial_number_' + item_id + '_' + last_item_key;
                                        var new_item_tr = '<tr><td class="serial"><a data-id="' + response
                                            .sn_id + '" href="#" id="' + serial_numbers +
                                            '" class=" show_log" data-value="' + serial_numbers +
                                            '" data-name="' + item_id +
                                            '" data-url="<?php echo site_url('work_orders/edit_item_serialnumber/'); ?>' +
                                            last_item_key +
                                            '" data-type="text" data-pk="1" data-title="<?php echo H(lang('common_serial_number')); ?>">' +
                                            serial_numbers + '</a></td><td>' + response.description +
                                            '</td><td>' + model +
                                            '</td><td class="text-center"><i class="delete-item icon ion-android-cancel" data-index="' +
                                            last_item_key + '"></i></td></tr>';
                                    } else {
                                        var s_id = 'serial_number_' + item_id + '_' + last_item_key;
                                        var new_item_tr = '<tr><td class="serial"><a href="#" id="' +
                                            last_item_key +
                                            '" class="xeditable" data-value="" data-name="' + item_id +
                                            '" data-url="<?php echo site_url('work_orders/edit_item_serialnumber/'); ?>' +
                                            last_item_key +
                                            '" data-type="text" data-pk="1" data-title="<?php echo H(lang('common_serial_number')); ?>"></a></td><td>' +
                                            item_info.description + '</td><td>' + model +
                                            '</td><td class="text-center"><i class="delete-item icon ion-android-cancel" data-index="' +
                                            last_item_key + '"></i></td></tr>';
                                    }

                                    $("#firearms_tbody").append(new_item_tr);

                                    setTimeout(function() {
                                        $("#" + s_id).editable('setValue', "");
                                    }, 100, s_id);

                                    $("#" + s_id).editable({
                                        success: function(response, newValue) {
                                            var ret = JSON.parse(response);
                                            $('#' + ret.id).val(newValue);
                                            $('#' + ret.id).attr('data-value', newValue);
                                        }
                                    });
                                } else {
                                    var new_item_tr = '<tr><td class="serial"></td><td>' + item_info
                                        .description + '</td><td>' + model +
                                        '</td><td class="text-center"><i class="delete-item icon ion-android-cancel" data-index="' +
                                        last_item_key + '"></i></td></tr>';
                                    $("#firearms_tbody").append(new_item_tr);
                                }

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

                                init_item_fields();
                            } else {
                                show_feedback('error', response.message,
                                    <?php echo json_encode(lang('common_error')); ?>);
                            }
                        }, 'json');
                    }, 'json');
                }

                function init_item_fields() {
                    $("#serial_number").val('');
                }

                function init_for_new_work_order() {
                    $('#customer_id').val('');
                    $('#customer').val('');
                    $('.customer_name').html('');
                    $('.customer_address').html('');
                    $('.customer_city_state_zip').html('');
                    $('.customer_email').html('');
                    $('.customer_email').attr('href', '');
                    $('.customer_phonenumber').html('');
                    $('.customer_phonenumber').attr('href', '');

                    init_item_fields();
                    $("#firearms_tbody").html('');
                }
                // $('#serial_number').editable({
                // 	success: function(response, newValue) {
                // 		$('#item_serial_number').val(newValue);

                // 	}
                // });

                $(".calcel_btn").click(function() {
                    $.post('<?php echo site_url("work_orders/init_for_new_work_order"); ?>', function(response) {
                        init_for_new_work_order();
                        $("#new_work_order_modal").modal('hide');
                    }, 'json');
                });

                $(document).on('click', '.delete-item', function(e) {
                    e.preventDefault();
                    $(this).parent().parent().remove();
                    $.post('<?php echo site_url("work_orders/remove_items_for_new_work_order"); ?>', {
                        index: $(this).data('index')
                    }, function(response) {}, 'json');
                });

                $("#new_work_order_form").submit(function(e) {
                    e.preventDefault();
                    var customer_id = $("#customer_id").val();

                    if (customer_id == '') {
                        show_feedback('error', <?php echo json_encode(lang('work_orders_must_select_customer')); ?>,
                            <?php echo json_encode(lang('common_error')); ?>);
                        return false;
                    }

                    $("#grid-loader1").show()
                    $(this).ajaxSubmit({
                        success: function(response, statusText, xhr, $form) {
                            $("#grid-loader1").hide()
                            if (response.success) {
                                location.href = "<?php echo site_url('work_orders/view/'); ?>" +
                                    response.work_order_id;
                            } else {
                                if (response.missing_required_information) {
                                    bootbox.confirm(response.message, function(result) {
                                        if (result) {
                                            location.href =
                                                "<?php echo site_url('items/view/'); ?>" +
                                                item_id +
                                                "?redirect=work_orders/index/0&progression=1";
                                        }
                                    });
                                } else {
                                    show_feedback('error', response.message,
                                        <?php echo json_encode(lang('common_error')); ?>);
                                }
                            }
                        },
                        dataType: 'json',
                    });
                });

                $(".status_box_btn").click(function() {
                    $(".status_box_btn").removeClass('selected_status');
                    $(this).addClass('selected_status');
                    $("#status").val($(this).data('status_id'));
                    $("#search_form").submit();
                });

                function add_additional_item(item_description) {
                    $.post("<?php echo site_url('work_orders/save_additional_item') ?>", {
                        item_description: item_description,
                        sale_id: ''
                    }, function(response) {
                        var data = JSON.parse(response);
                        $('#item').val('');
                        $("#firearms_tbody").html('');
                        $.each(data.item_info, function(index, item) {
                            if (item.is_serialized == 1) {
                                var s_id = 'serial_number_' + item.item_id + '_' + index;
                                var new_item_tr = '<tr><td class="serial"><a href="#" id="' + s_id +
                                    '" class="xeditable" data-value="" data-name="' + s_id +
                                    '" data-url="<?php echo site_url('work_orders/edit_item_serialnumber/'); ?>' +
                                    index +
                                    '" data-type="text" data-pk="1" data-title=<?php echo json_encode(H(lang('common_serial_number'))); ?>></a></td><td>' +
                                    item.description + '</td><td>' + item.model +
                                    '</td><td class="text-center"><i class="delete-item icon ion-android-cancel" data-index="' +
                                    index + '"></i></td></tr>';
                                $("#firearms_tbody").append(new_item_tr);

                                setTimeout(function() {
                                    $("#" + s_id).editable('setValue', "");
                                }, 100, s_id);

                                $("#" + s_id).editable({
                                    success: function(response, newValue) {
                                        var ret = JSON.parse(response);
                                        $('#' + ret.id).val(newValue);
                                        $('#' + ret.id).attr('data-value', newValue);
                                    }
                                });
                            } else {
                                var new_item_tr = '<tr><td class="serial"></td><td>' + item.description +
                                    '</td><td>' + item.model +
                                    '</td><td class="text-center"><i class="delete-item icon ion-android-cancel" data-index="' +
                                    index + '"></i></td></tr>';
                                $("#firearms_tbody").append(new_item_tr);
                            }
                        });
                    });
                }

                $(document).on('keyup', '#item', function() {
                    $('#item_description').val($(this).val());
                });
    </script>


    <?php $this->load->view("partial/footer"); ?>