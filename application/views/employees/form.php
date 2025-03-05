<?php $this->load->view("partial/header"); ?>
<script src="<?= site_url(); ?>assets/css_good/plugins/custom/typedjs/typedjs.bundle.js"></script>
<style>
.form-check-custom {
    display: block !important;
}
</style>
<div class="row " id="form">
    <div class="spinner" id="grid-loader" style="display:none">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
    </div>
    <div class="col-md-12">


        <?php if ($person_info->person_id && !isset($is_clone)) { ?>
        <div class="panel hidden">
            <div class="card-body ">
                <div class="user-badge">
                    <?php echo $person_info->image_id ? '<div class="user-badge-avatar symbol symbol-50px">' . img(array('src' => cacheable_app_file_url($person_info->image_id), 'class' => 'img-polaroid img-polaroid-s')) . '</div>' : '<div class="user-badge-avatar">' . img(array('src' => base_url('assets/assets/images/avatar-default.jpg'), 'class' => 'img-polaroid')) . '</div>'; ?>
                    <div class="user-badge-details">
                        <?php echo H($person_info->first_name . ' ' . $person_info->last_name); ?>
                        <p><?php echo H($person_info->username); ?></p>
                    </div>
                    <ul class="list-inline pull-right">
                        <?php
							$one_year_ago = date('Y-m-d', strtotime('-1 year'));
							$today = date('Y-m-d') . '%2023:59:59';
							?>
                        <li><a target="_blank"
                                href="<?php echo site_url('reports/generate/specific_employee?employee_type=logged_in_employee&report_type=complex&start_date=' . $one_year_ago . '&start_date_formatted=' . date(get_date_format() . ' ' . get_time_format(), strtotime($one_year_ago)) . '&end_date=' . $today . '&end_date_formatted=' . date(get_date_format() . ' ' . get_time_format(), strtotime(date('Y-m-d') . ' 23:59:59')) . '&employee_id=' . $person_info->person_id . '&sale_type=all&export_excel=0'); ?>"
                                class="btn btn-success"><?php echo lang('view_report'); ?></a></li>
                        <?php if ($person_info->email) { ?>
                        <li><a href="mailto:<?php echo H($person_info->email); ?>"
                                class="btn btn-primary"><?php echo lang('send_email'); ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php $current_employee_editing_self = $this->Employee->get_logged_in_employee_info()->person_id == $person_info->person_id;
		echo form_open_multipart('employees/save/' . (!isset($is_clone) ? $person_info->person_id : ''), array('id' => 'employee_form', 'class' => 'form-horizontal'));
		?>


        <div class="d-flex flex-column flex-xl-row">
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <?php $this->load->view("people/form_sidebar" , ['type' =>'employee' ]); ?>

            </div>
            <div class="flex-lg-row-fluid ms-lg-15">
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8"
                    role="tablist">
                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4 active" data-toggle="tab"
                            href="#kt_ecommerce_customer_overview" aria-selected="true" role="tab">Overview</a>
                    </li>
                    <!--end:::Tab item-->

                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-toggle="tab"
                            href="#kt_ecommerce_customer_general" aria-selected="false" role="tab" tabindex="-1">General
                            Settings</a>
                    </li>
                    <!--end:::Tab item-->

                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-toggle="tab"
                            href="#kt_ecommerce_customer_advanced" aria-selected="false" role="tab"
                            tabindex="-1">Advanced Settings</a>
                    </li>
                    <!--end:::Tab item-->

                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-toggle="tab"
                            href="#kt_ecommerce_customer_files" aria-selected="false" role="tab" tabindex="-1">Files
                            Upload</a>
                    </li>
                    <!--end:::Tab item-->

                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-toggle="tab"
                            href="#kt_ecommerce_customer_login_info" aria-selected="false" role="tab"
                            tabindex="-1">Login Info
                        </a>
                    </li>
                    <!--end:::Tab item-->

                    <!--begin:::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-toggle="tab"
                            href="#kt_ecommerce_customer_permissions" aria-selected="false" role="tab"
                            tabindex="-1">Employee Permission
                        </a>
                    </li>
                    <!--end:::Tab item-->

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="kt_ecommerce_customer_overview" role="tabpanel">
                        <div class="row row-cols-1 row-cols-md-2 mb-6 mb-xl-9">



                            <div class="col">
                                <!--begin::Card-->
                                <div class="card pt-4 h-md-100 mb-6 mb-md-0">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2 class="fw-bold"><?php 
						
						                    echo form_label(lang('total'))?></h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <div class="fw-bold fs-2">
                                            <div class="d-flex">
                                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/general/gen030.svg-->
                                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/finance/fin009.svg-->
                                                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M15.8 11.4H6C5.4 11.4 5 11 5 10.4C5 9.80002 5.4 9.40002 6 9.40002H15.8C16.4 9.40002 16.8 9.80002 16.8 10.4C16.8 11 16.3 11.4 15.8 11.4ZM15.7 13.7999C15.7 13.1999 15.3 12.7999 14.7 12.7999H6C5.4 12.7999 5 13.1999 5 13.7999C5 14.3999 5.4 14.7999 6 14.7999H14.8C15.3 14.7999 15.7 14.2999 15.7 13.7999Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M18.8 15.5C18.9 15.7 19 15.9 19.1 16.1C19.2 16.7 18.7 17.2 18.4 17.6C17.9 18.1 17.3 18.4999 16.6 18.7999C15.9 19.0999 15 19.2999 14.1 19.2999C13.4 19.2999 12.7 19.2 12.1 19.1C11.5 19 11 18.7 10.5 18.5C10 18.2 9.60001 17.7999 9.20001 17.2999C8.80001 16.8999 8.49999 16.3999 8.29999 15.7999C8.09999 15.1999 7.80001 14.7 7.70001 14.1C7.60001 13.5 7.5 12.8 7.5 12.2C7.5 11.1 7.7 10.1 8 9.19995C8.3 8.29995 8.79999 7.60002 9.39999 6.90002C9.99999 6.30002 10.7 5.8 11.5 5.5C12.3 5.2 13.2 5 14.1 5C15.2 5 16.2 5.19995 17.1 5.69995C17.8 6.09995 18.7 6.6 18.8 7.5C18.8 7.9 18.6 8.29998 18.3 8.59998C18.2 8.69998 18.1 8.69993 18 8.79993C17.7 8.89993 17.4 8.79995 17.2 8.69995C16.7 8.49995 16.5 7.99995 16 7.69995C15.5 7.39995 14.9 7.19995 14.2 7.19995C13.1 7.19995 12.1 7.6 11.5 8.5C10.9 9.4 10.5 10.6 10.5 12.2C10.5 13.3 10.7 14.2 11 14.9C11.3 15.6 11.7 16.1 12.3 16.5C12.9 16.9 13.5 17 14.2 17C15 17 15.7 16.8 16.2 16.4C16.8 16 17.2 15.2 17.9 15.1C18 15 18.5 15.2 18.8 15.5Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Svg Icon-->
                                                <div class="ms-2" id="total_sum">
                                                    <?php echo to_currency(0) ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>




                            <div class="col">
                                <!--begin::Reward Tier-->
                                <a href="#" class="card bg-info hoverable h-md-100">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/good/docs/core/html/src/media/icons/duotune/finance/fin008.svg-->
                                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                    d="M3.20001 5.91897L16.9 3.01895C17.4 2.91895 18 3.219 18.1 3.819L19.2 9.01895L3.20001 5.91897Z"
                                                    fill="currentColor" />
                                                <path opacity="0.3"
                                                    d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21C21.6 10.9189 22 11.3189 22 11.9189V15.9189C22 16.5189 21.6 16.9189 21 16.9189H16C14.3 16.9189 13 15.6189 13 13.9189ZM16 12.4189C15.2 12.4189 14.5 13.1189 14.5 13.9189C14.5 14.7189 15.2 15.4189 16 15.4189C16.8 15.4189 17.5 14.7189 17.5 13.9189C17.5 13.1189 16.8 12.4189 16 12.4189Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21V7.91895C21 6.81895 20.1 5.91895 19 5.91895H3C2.4 5.91895 2 6.31895 2 6.91895V20.9189C2 21.5189 2.4 21.9189 3 21.9189H19C20.1 21.9189 21 21.0189 21 19.9189V16.9189H16C14.3 16.9189 13 15.6189 13 13.9189Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <div class="text-white fw-bold fs-2 mt-5">
                                            <?php echo lang('profit').': '; ?>
                                        </div>

                                        <div class="fw-semibold text-white" id="profit_sum">
                                            <?php echo to_currency(0) ?>
                                        </div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                                <!--end::Reward Tier-->
                            </div>












                        </div>
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Transaction History</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <script type="text/javascript" src="https://cdn.datatables.net/2.1.7/js/dataTables.js">
                            </script>
                            <!-- ColReorder JS -->
                            <script src="https://cdn.datatables.net/colreorder/2.0.4/js/dataTables.colReorder.js">
                            </script>
                            <script src="https://cdn.datatables.net/colreorder/2.0.4/js/colReorder.dataTables.js">
                            </script>
                            <?php  $columns = get_table_columns('sales'); 
                                                $columnSearch = array_filter($columns, function($key) {
                                                    return $key !== 'default_order';
                                                }, ARRAY_FILTER_USE_KEY);
                                                
                                    ?>
                            <?php $this->load->view("sales/sales_header"); ?>
                            <input type="hidden" id="employee_id"
                                value="<?php echo $this->Employee->get_logged_in_employee_info()->id; ?>">
                            <!--begin::Card body-->
                            <div class="card-body pt-0 pb-5">
                                <!--begin::Table-->
                                <div id="kt_table_customers_payment_wrapper"
                                    class="dt-container dt-bootstrap5 dt-empty-footer">

                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped gy-7 gs-7" style="width:100%">
                                            <thead>
                                                <tr
                                                    class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                                    <?php $i=0; foreach($all_columns as $col_key => $col_value): ?>
                                                    <th><?php echo H($col_value['label']); ?></th>
                                                    <?php $i++; endforeach ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data rows will be inserted here by DataTables -->
                                            </tbody>
                                        </table>

                                        <script>
                                        $(document).ready(function() {

                                            // $("#customer_listd").hide();
                                            let openSelect2 = null;

                                            $("#location_listd").select2({
                                                dropdownAutoWidth: true
                                            });
                                            $("#customer_listd").select2({
                                                dropdownAutoWidth: true
                                            });
                                            $("#sale_type").select2({
                                                dropdownAutoWidth: true
                                            });




                                            var table = $('#example').DataTable({
                                                colReorder: true,
                                                "paging": true, // Ensure paging is enabled
                                                "pageLength": 5, // Adjust as per your requirement
                                                "pagingType": "full_numbers",
                                                "processing": true,
                                                "serverSide": true,
                                                "order": [],

                                                "ajax": {
                                                    "url": "<?php echo site_url('sales/ajaxList') ?>",
                                                    "type": "POST",
                                                    "data": function(d) {
                                                        d.from_date = $('#from_date').val();
                                                        d.to_date = $('#to_date').val();
                                                    },
                                                    "dataSrc": function(json) {
                                                        // Summing total and profit fields
                                                        var totalSum = 0;
                                                        var profitSum = 0;

                                                        json.data.forEach(function(row) {
                                                            totalSum += parseFloat(row
                                                                .total) || 0;
                                                            profitSum += parseFloat(row
                                                                .profit) || 0;
                                                        });

                                                        // Display the total and profit sum somewhere on the page
                                                        $('#total_sum').text(totalSum.toFixed(2) +
                                                            '<?= get_store_currency(); ?>');
                                                        $('#profit_sum').text(profitSum.toFixed(2) +
                                                            '<?= get_store_currency(); ?>');

                                                        return json
                                                        .data; // Return the data to be rendered in DataTable
                                                    }
                                                },
                                                "columns": [
                                                    <?php $i=0; foreach($all_columns as $key => $col): ?> {
                                                        "data": "<?= $key ?>"
                                                    },
                                                    <?php $i++; endforeach ?>

                                                ],
                                                "initComplete": function() {

                                                    this.api().search('<?php  if($this->uri->segment(3) > 0) {  echo H($person_info->first_name.' '.$person_info->last_name); }else{ echo 'dont_show_anything'; } ?>').draw();
                                                    // Apply the search for each column
                                                    $('#employee_id').on('change', function() {
                                                        this.api().search('<?php  if($this->uri->segment(3) > 0) {  echo H($person_info->first_name.' '.$person_info->last_name); }else{ echo 'dont_show_anything'; } ?>').draw();


                                                        var searchTerm =
                                                            '';
                                                        var colIndex = $(
                                                                '#sortable input:checkbox')
                                                            .index($('#employee_name'));
                                                        console.log(searchTerm);

                                                        // Apply the search to the specific column
                                                        if (colIndex !== -1) {
                                                            table.column(colIndex).search(
                                                                searchTerm).draw();
                                                        } else {
                                                            console.error(
                                                                "Column index not found. Check if the checkbox selector is correct."
                                                                );
                                                        }
                                                    });

                                                    $('#employee_id').trigger('change');
                                                },
                                                "drawCallback": function(settings) {
                                                    // Custom class for the pagination wrapper
                                                    $('.dt-paging').addClass('pagination');
                                                }
                                            });
                                            $('.columns').on('change', function(e) {
                                                //     console.log('callled');
                                                // // Get the column API object
                                                //     var column = table.column($(this).data('column-index'));



                                                //     // Toggle the visibility
                                                //     column.visible(!column.visible());
                                            });

                                            $('#employee_id').on('change', function() {

                                                var searchTerm =
                                                    '<?php echo $this->Employee->get_logged_in_employee_info()->id; ?>';
                                                var colIndex = $('#sortable input:checkbox').index($(
                                                    '#employee_name'));
                                                // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
                                                table.column(colIndex).search(searchTerm)
                                            .draw(); // Adjust the column index as necessary
                                            });


                                            // $('#s2id_customer_listd').hide();
                                            $('#location_listd').on('change', function() {

                                                var searchTerm = $(this).val();
                                                var colIndex = $('#sortable input:checkbox').index($(
                                                    '#location_name'));
                                                // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
                                                table.column(colIndex).search(searchTerm)
                                            .draw(); // Adjust the column index as necessary
                                            });

                                            $('#s2id_location_listd').on('click', function() {

                                                $('#customer_listd').select2(
                                                'close'); // Close the previously opened dropdown
                                                $('#sale_type').select2('close');

                                            });
                                            $('#customer_listd').on('change', function() {
                                                var searchTerm = $(this).val();
                                                var colIndex = $('#sortable input:checkbox').index($(
                                                    '#customer_name'));
                                                // console.log(colIndex);
                                                // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
                                                table.column(colIndex).search(searchTerm)
                                            .draw(); // Adjust the column index as necessary
                                            });

                                            $('#s2id_customer_listd').on('click', function() {

                                                $('#location_listd').select2(
                                                'close'); // Close the previously opened dropdown
                                                $('#sale_type').select2('close');

                                            });
                                            $('#sale_type').on('change', function() {
                                                var searchTerm = $(this).val();
                                                var colIndex = $('#sortable input:checkbox').index($(
                                                    '#suspended_type'));
                                                // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
                                                table.column(colIndex).search(searchTerm)
                                            .draw(); // Adjust the column index as necessary


                                                // var searchTerm ='<?php echo H($person_info->first_name.' '.$person_info->last_name); ?>';
                                                // var colIndex = $('#sortable input:checkbox').index($('#customer_name'));
                                                // // console.log(colIndex);
                                                // // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
                                                // table.column(colIndex).search(searchTerm).draw(); // Adjust the column index as necessary


                                            });
                                            $('#s2id_sale_type').on('click', function() {

                                                $('#location_listd').select2(
                                                'close'); // Close the previously opened dropdown
                                                $('#customer_listd').select2('close');

                                            });
                                            $('#from_date , #to_date').on('change', function() {
                                                var searchTerm = $(this).val();
                                                table.ajax.reload();
                                            });
                                            $('#resetButton').click(function() {
                                                $('#from_date').val('');
                                                $('#to_date').val('');

                                                <?php if(getenv('MASTER_USER') == $this->Employee->get_logged_in_employee_info()->id) { ?>
                                                $('#location_listd').val(-1).trigger('change');
                                                <?php } ?>


                                                var customerColIndex = $('#sortable input:checkbox')
                                                    .index($(
                                                    '#customer_name')); // Get the customer column index

                                                // $('#customer_listd').val(customerSearchTerm).trigger('change'); // Trigger change to keep customer filter

                                                table.state
                                            .clear(); // Clears the saved state of the table

                                                // Reset all column searches except the customer column
                                                table.columns().every(function(index) {
                                                    console.log('customerColIndex',
                                                        customerColIndex);
                                                    if (index !==
                                                        customerColIndex) { // Skip the customer column
                                                        this.search('');
                                                    }
                                                });

                                                table
                                            .draw(); // Redraw the table after clearing non-customer columns
                                            });
                                            var old_columns = [];
                                            $("#sortable input:checkbox").each(function() {
                                                old_columns.push($(this)
                                                    .val()
                                                    ); // Assuming checkbox values correspond to column indices
                                            });
                                            $("#sortable input:checkbox").each(function() {
                                                // Get the index of the checkbox within the collection of checkboxes
                                                var colIndex = $('#sortable input:checkbox').index(
                                                this);

                                                // Check if the checkbox is checked
                                                if ($(this).is(':checked')) {
                                                    // Show the corresponding column if checked
                                                    table.column(colIndex).visible(true);
                                                } else {
                                                    // Hide the corresponding column if unchecked
                                                    table.column(colIndex).visible(false);
                                                }
                                            });

                                            function setTableColumnOrder() {
                                                var columns = [];

                                                // Get checked checkboxes and reorder columns accordingly
                                                $("#sortable input:checkbox").each(function() {
                                                    columns.push($(this)
                                                        .val()
                                                        ); // Assuming checkbox values correspond to column indices
                                                });



                                                // Apply the new order
                                                // $i=0;
                                                newOrder = []
                                                columns.forEach(function(colIndex, i) {
                                                    newOrder.push(old_columns.indexOf(colIndex));

                                                });
                                                // var newOrder = [4, 0, 1, 2, 3, 5, 6, 7, 8, 9];
                                                table.colReorder.order(newOrder);

                                                old_columns = [];
                                                old_columns = columns;
                                                // Hide unchecked columns
                                                $("#sortable input:checkbox").each(function() {
                                                    // Get the index of the checkbox within the collection of checkboxes
                                                    var colIndex = $('#sortable input:checkbox').index(
                                                        this);

                                                    // Check if the checkbox is checked
                                                    if ($(this).is(':checked')) {
                                                        // Show the corresponding column if checked
                                                        table.column(colIndex).visible(true);
                                                    } else {
                                                        // Hide the corresponding column if unchecked
                                                        table.column(colIndex).visible(false);
                                                    }
                                                });
                                            }
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
                                            var columns = [];
                                            $("#sortable").disableSelection();

                                            $("#sortable input[type=checkbox]").on('change', function(e) {
                                                console.log("changed");
                                                var columns = [];

                                                // Get all checked checkboxes in the sorted order
                                                $("#sortable input:checkbox:checked").each(function() {
                                                    columns.push($(this)
                                                .val()); // Add the column's index or identifier
                                                });


                                                $.post(<?php echo json_encode(site_url("sales/save_list_column_prefs")); ?>, {
                                                    columns: columns
                                                }, function(json) {
                                                    setTableColumnOrder();
                                                    // table.draw();

                                                });

                                            });


                                        });
                                        </script>

                                    </div>





                                </div>
                                <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_ecommerce_customer_general" role="tabpanel">

                        <div class="card shadow-sm mt-5">
                            <div class="card-header rounded rounded-3 p-5">
                                <h3 class="card-title">

                                    <?php echo lang("employees_basic_information"); ?>
                                </h3>
                            </div>

                            <div class="card-body">


                                <?php $this->load->view("people/form_basic_info"); ?>





                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_ecommerce_customer_advanced" role="tabpanel">
                        <div class="card shadow-sm mt-5">
                            <div class="card-header rounded rounded-3 p-5">
                                <h3 class="card-title">

                                    <?php echo lang("employees_advance_information"); ?>
                                </h3>
                            </div>

                            <div class="card-body">
                                <?php $this->load->view("people/emp_advance_settings"); ?>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_ecommerce_customer_files" role="tabpanel">
                        <div class="card ">
                            <div class="card-header rounded rounded-3 p-5">
                                <h3 class="card-title">

                                    <?php echo lang("files"); ?>
                                </h3>
                            </div>

                            <?php if (isset($files) && count($files)) { ?>
                            <ul class="list-group">
                                <?php foreach ($files as $file) { ?>
                                <li class="list-group-item permission-action-item">

                                    <?php echo anchor($controller_name . '/delete_file/' . $file->file_id, '<i class="icon ion-android-cancel text-danger" style="font-size: 120%"></i>', array('class' => 'delete_file')); ?>
                                    <?php echo anchor($controller_name . '/download/' . $file->file_id, $file->file_name, array('target' => '_blank')); ?>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                            <h4 style="padding: 20px;"><?php echo lang('add_files'); ?></h4>
                            <div class="row">
                                <?php for($k=1;$k<=5;$k++) { ?>

                                <div class="col-md-6">
                                    <div class="py-5 mb-5 px-8">
                                        <div class=" ">
                                            <div class="mb-10">
                                                <div
                                                    class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5 active">

                                                    <label class="form-check-label" for="flexCheckDefault"> <?php 

								echo form_label(lang('file').' '.$k.':', 'files_'.$k)?></label>
                                                    <div class="file-upload">
                                                        <input type="file" class="form-control form-control-solid"
                                                            name="files[]" id="files_<?php echo $k; ?>">
                                                    </div>

                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <?php } ?>
                            </div>



                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_ecommerce_customer_login_info" role="tabpanel">
                        <div class="card ">
                            <div class="card-header rounded rounded-3 p-5">
                                <h3 class="card-title">
                                
                                    <?php echo lang("login_info"); ?>
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-5">

                                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                        <?php echo form_label(lang('username') . ':', 'username', array('class' => 'form-label required')); ?>

                                        <?php echo form_input(array(
							'name' => 'username',
							'id' => 'username',
							'class' => 'form-control',
							'value' => $person_info->username
						)); ?>

                                    </div>


                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                        <?php echo form_label(lang('password') . ':', 'password', array('class' => 'form-label')); ?>

                                        <?php echo form_password(array(
							'name' => 'password',
							'id' => 'password',
							'class' => 'form-control',
							'autocomplete' => 'off',
						)); ?>
                                    </div>
                                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                        <?php echo form_label(lang('repeat_password') . ':', 'repeat_password', array('class' => 'form-label')); ?>

                                        <?php echo form_password(array(
							'name' => 'repeat_password',
							'id' => 'repeat_password',
							'class' => 'form-control',
							'autocomplete' => 'off',
						)); ?>

                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-5">

                                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">

                                        <div class=" form-check form-check-custom form-check-solid">
                                            <?php
						echo	form_checkbox(array(
							'name' => 'force_password_change',
							'id' => 'force_password_change',
							'value' => 1,
							'class' =>'form-check-input' ,
							'checked' => $person_info->force_password_change,
						));
						echo '<label class="form-check-label" for="force_password_change">'.lang('employees_force_password_change_upon_login').'</label>';;
						?>
                                        </div>
                                    </div>

                                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <?php
						echo	form_checkbox(array(
							'name' => 'always_require_password',
							'id' => 'always_require_password',
							'value' => 1,
							'class' =>'form-check-input' ,
							'checked' => $person_info->always_require_password,
						));
						echo '<label class="form-check-label" for="always_require_password">'.lang('employees_always_require_password').'</label>';;
						?>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-5">


                                    <?php if ($this->config->item('timeclock')) { ?>
                                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                        <div class=" form-check form-check-custom form-check-solid">
                                            <?php
							echo	form_checkbox(array(
								'name' => 'not_required_to_clock_in',
								'id' => 'not_required_to_clock_in',
								'value' => 1,
								'class' =>'form-check-input' ,
								'checked' => $person_info->not_required_to_clock_in,
							));
							echo '<label class="form-check-label" for="not_required_to_clock_in">'.lang('employees_not_required_to_clock_in').'</label>';;
							?>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                        <div class=" form-check form-check-custom form-check-solid">
                                            <?php
						echo	form_checkbox(array(
							'name' => 'dark_mode',
							'id' => 'dark_mode',
							'value' => 1,
							'class' =>'form-check-input' ,
							'checked' => $person_info->dark_mode,
							));
							echo '<label class="form-check-label" for="dark_mode">'.lang('dark_mode').'</label>';;
						?>
                                        </div>
                                    </div>

                                    <div
                                        class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 <?php if($this->Employee->get_logged_in_employee_info()->person_id ==$person_info->person_id ) { echo 'd-none'; } ?>">

                                        <div class=" form-check form-check-custom form-check-solid">
                                            <?php
						echo	form_checkbox(array(
							'name' => 'inactive',
							'id' => 'inactive',
							'value' => 1,
							'class' =>'form-check-input' ,
							'checked' => $person_info->inactive,
						));
						echo '<label class="form-check-label" for="inactive">'.lang('employees_inactive').'</label>';;
						?>
                                        </div>
                                    </div>
                                </div>


                                <div id="inactive_info">

                                    <div class="d-flex flex-wrap gap-5">

                                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">


                                            <?php echo form_label(lang('employees_reason_inactive') . ':', 'reason_inactive', array('class' => 'form-label ')); ?>

                                            <?php echo form_textarea(array(
								'name' => 'reason_inactive',
								'id' => 'reason_inactive',
								'class' => 'form-control text-area',
								'value' => $person_info->reason_inactive,
								'rows' => '5',
								'cols' => '17'
							)); ?>
                                        </div>

                                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                            <?php echo form_label(lang('employees_termination_date') . ':', 'termination_date', array('class' => 'form-label text-info wide')); ?>

                                            <div class="input-group date">
                                                <span class="input-group-text bg">
                                                    <i class="ion ion-ios-calendar-outline"></i>
                                                </span>
                                                <?php echo form_input(array(
									'name' => 'termination_date',
									'id' => 'termination_date',
									'class' => 'form-control datepicker',
									'value' => $person_info->termination_date ? date(get_date_format(), strtotime($person_info->termination_date)) : ''
								)); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-5">

                                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                        <?php echo form_label(lang('employees_acess_ip_range').':', 'employees_acess_ip_range',array('class'=>'form-label')); ?>

                                        <input id="allowed_ip_address" name='allowed_ip_address'
                                            value='<?php echo is_array($person_info->allowed_ip_address) ? implode(",", $person_info->allowed_ip_address) : $person_info->allowed_ip_address; ?>'
                                            placeholder=<?php echo json_encode(lang('employees_enter_ip'));?>; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="kt_ecommerce_customer_permissions" role="tabpanel">

                        <div class="card ">
                            <div class="card-header rounded rounded-3 p-5">
                                <h3 class="card-title">

                                    <?php echo lang("employees_permission_info"); ?><br>
                                </h3>
                            </div>

                            <div class="card-body">

                                <div class="alert alert-info text-center" role="alert">
                                    <?php echo lang("employees_permission_desc"); ?>
                                </div>

                                <?php 
					$templates = array('' => lang('none'));
					foreach($permission_templates->result() as $template){
						$templates[$template->id] = $template->name;
					}
				?>

                                <div class="form-group row">
                                    <?php echo form_label(lang('permission_templates') . ': ', 'permission_templates', array('class' => 'form-label')); ?>
                                    <div class="">
                                        <?php echo form_dropdown(
							'permission_templates',
							$templates,
							$person_info->template_id,
							array(
								'class' => 'form-control',
								'id' => 'permission_templates'
							)
						)
						?>
                                    </div>
                                </div>

                                <?php
				foreach ($all_modules->result() as $module) {
					$checkbox_options = array(
						'name' => 'permissions[]',
						'id' => 'permissions' . $module->module_id,
						'value' => $module->module_id,
						'checked' => $this->Employee->has_module_permission($module->module_id, $person_info->person_id, FALSE, TRUE),
						'class' => 'module_checkboxes form-check-input '
					);

					if ($logged_in_employee_id != 1) {
						if (($current_employee_editing_self && $checkbox_options['checked']) || !$this->Employee->has_module_permission($module->module_id, $logged_in_employee_id, FALSE, TRUE)) {
							$checkbox_options['disabled'] = 'disabled';

							//Only send permission if checked
							if ($checkbox_options['checked']) {
								echo form_hidden('permissions[]', $module->module_id);
							}
						}
					}
				?>
                                <div class="card mt-2">
                                    <div class="card-header rounded rounded-3 p-5 my-3  rounded border-primary border border-none rounded-3 list-group-item form-check form-check-custom form-check-solid"
                                        id="<?php echo 'lmodule_' . $module->module_id; ?>">
                                        <?php echo form_checkbox($checkbox_options) . '<label class="form-check-label" for="permissions' . $module->module_id . '"><span></span></label>'; ?>
                                        <span
                                            class="text-success"><?php echo lang('module_' . $module->module_id); ?>:&nbsp;</span>
                                        <span
                                            class="text-warning"><?php echo lang('module_' . $module->module_id . '_desc'); ?></span>


                                        <span class="text-info pull-right">
                                            <div class="drop-down">
                                                <?php
									if ($this->Location->count_all() > 1) {
									?>
                                                <span style="color:#EAC841;"
                                                    onclick="getEmployeeLocation('<?php echo 'lmodule_' . $module->module_id; ?>')"
                                                    class="iconi"
                                                    id="<?php echo 'lmodule_head' . $module->module_id; ?>"
                                                    aria-haspopup="true">
                                                    <i class="icon ti-location-pin arrow"
                                                        aria-hidden="true"></i><?php echo lang('override_location'); ?>
                                                </span>
                                                <?php } ?>
                                                <div class="drop-menu">
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input
                                                            onclick="selectAllLocation('select-all-<?php echo $module->module_id; ?>')"
                                                            id="select-all-<?php echo $module->module_id; ?>"
                                                            class="form-check-input" type="checkbox"
                                                            name="<?php echo 'select-all-' . $module->module_id; ?>">
                                                        <label class="form-check-label"
                                                            for="select-all-<?php echo $module->module_id; ?>"><b><?= lang('Select_All') ?></b></label>
                                                    </div>
                                                    <hr>

                                                    <?php foreach ($locations_new as $lmk => $lmv) :
											$tmp_checkbox_id = 'module-location-' . $module->module_id . "-" . $lmk;
											$module_location_checkbox = array(
												'name' => "module_location[]",
												'id' => $tmp_checkbox_id,
												'value' => $module->module_id . "|" . $lmk,
												'checked' => $this->Employee->check_module_has_location($action_locations, $module->module_id, $lmk),
												'class' => 'form-check-input',
												'data-temp_name' => 'select-all-' . $module->module_id
											);

										?>
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <?php echo form_checkbox($module_location_checkbox); ?>
                                                        <label class="form-check-label"
                                                            for="<?php echo 'module-location-' . $module->module_id . "-" . $lmk; ?>"
                                                            class="text_align"><?php echo $lmv['name']; ?></label>
                                                    </div>
                                                    <?php endforeach; ?>

                                                </div>
                                            </div>
                                        </span>

                                    </div>

                                    <ul class="list-group">
                                        <?php
							foreach ($this->Module_action->get_module_actions($module->module_id)->result() as $mk => $module_action) {
								$checkbox_options = array(
									'name' => 'permissions_actions[]',
									'data-module-checkbox-id' => 'permissions' . $module->module_id,
									'class' => 'module_action_checkboxes form-check-input' ,
									'id' => 'permissions_actions' . $module_action->module_id . "-" . $module_action->action_id,
									'value' => $module_action->module_id . "|" . $module_action->action_id,
									'checked' => $this->Employee->has_module_action_permission($module->module_id, $module_action->action_id, $person_info->person_id, FALSE, TRUE)
								);

								if ($logged_in_employee_id != 1) {
									if (($current_employee_editing_self && $checkbox_options['checked']) || (!$this->Employee->has_module_action_permission($module->module_id, $module_action->action_id, $logged_in_employee_id, FALSE, TRUE))) {
										$checkbox_options['disabled'] = 'disabled';

										//Only send permission if checked
										if ($checkbox_options['checked']) {
											echo form_hidden('permissions_actions[]', $module_action->module_id . "|" . $module_action->action_id);
										}
									}
								}

							?>
                                        <li class="list-group-item permission-action-item form-check form-check-custom form-check-solid border-none"
                                            id="<?php echo 'permissions-actions-' . $module_action->module_id . "-" . $module_action->action_id . '-ext-' . $mk; ?>">
                                            <?php echo form_checkbox($checkbox_options) . '<label for="permissions_actions' . $module_action->module_id . "-" . $module_action->action_id . '"><span></span></label>'; ?>
                                            <span
                                                class="text-info"><?php echo lang($module_action->action_name_key); ?></span>
                                            <span class="text-info pull-right">
                                                <div class="drop-down">

                                                    <?php
											if ($this->Location->count_all() > 1) {
											?>
                                                    <span class="iconi"
                                                        onclick="getEmployeeLocation('<?php echo 'permissions-actions-' . $module_action->module_id . "-" . $module_action->action_id . '-ext-' . $mk; ?>')"
                                                        aria-haspopup="true">
                                                        <i class="icon ti-location-pin arrow"
                                                            aria-hidden="true"></i><?php echo lang('override_location'); ?>
                                                    </span>
                                                    <?php } ?>
                                                    <div class="drop-menu">
                                                        <div class="form-check form-check-custom form-check-solid">
                                                            <input class="form-check-input"
                                                                onclick="selectAllLocation('select-all-<?php echo $module_action->module_id . "-" . $module_action->action_id; ?>')"
                                                                id="select-all-<?php echo $module_action->module_id . "-" . $module_action->action_id; ?>"
                                                                type="checkbox"
                                                                name="<?php echo 'select-all-' . $module_action->module_id . "-" . $module_action->action_id; ?>">
                                                            <label
                                                                for="select-all-<?php echo $module_action->module_id . "-" . $module_action->action_id; ?>"
                                                                class="form-check-label"><b><?= lang('Select_All') ?></b></label>
                                                        </div>
                                                        <hr>
                                                        <?php
												foreach ($locations_new as $lk => $lv) :
													$checkbox_id = 'permissions-actions' . $lk . $module_action->module_id . "-" . $module_action->action_id . '-ext-' . $mk;
													$location_checkbox = array(
														'name' => "action-location[]",
														'id' => $checkbox_id,
														'class' => 'form-check-input',
														'value' => $module_action->module_id . "|" . $module_action->action_id . "|" . $lk,
														'checked' => $this->Employee->check_action_has_employee_location($action_locations, $module->module_id, $module_action->action_id, $lk),
														'data-temp_name' => 'select-all-' . $module_action->module_id . "-" . $module_action->action_id
													);
												?>
                                                        <div class="form-check form-check-custom form-check-solid">
                                                            <?php echo form_checkbox($location_checkbox); ?>
                                                            <label class="form-check-label"
                                                                for="<?php echo $checkbox_id; ?>"><?php echo $lv['name']; ?></label>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </span>
                                        </li>

                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>

                <?php
	echo form_submit(array(
		'name' => 'submitf',
		'id' => 'submitf',
		'value' => lang('save'),
		'class' => 'btn submit_button floating-button btn-primary btn-lg float_right'
	));

	?>

            </div>
        </div>
    </div>









    <div class="form-actions pull-right">
       
        <?php echo form_close(); ?>
    </div>
</div>
</div>

<script type='text/javascript'>
$('#image_id').imagePreview({
    selector: '#avatar'
}); // Custom preview container

//validation and submit handling
$(document).ready(function() {
    date_time_picker_field($(".datepicker"), JS_DATE_FORMAT + " " + JS_TIME_FORMAT);
    date_time_picker_field($(".timepicker"), JS_TIME_FORMAT);
    $("#inactive").change(check_inactive);

    check_inactive();

    function check_inactive() {
        if ($("#inactive").prop('checked')) {
            $("#inactive_info").show();
        } else {
            $("#inactive_info").hide();
        }
    }

    setTimeout(function() {
        $(":input:visible:first", "#employee_form").focus();
    }, 100);

    $(".module_checkboxes").change(function() {
        if ($(this).prop('checked')) {
            $(this).parent().parent().find('.module_action_checkboxes').not(':disabled').prop('checked',
                true);
        } else {
            $(this).parent().parent().find('.module_action_checkboxes').not(':disabled').prop('checked',
                false);
        }
    });

    $(".module_action_checkboxes").change(function() {
        if ($(this).prop('checked')) {
            $('#' + $(this).data('module-checkbox-id')).prop('checked', true);
        }
    });

    $('#employee_form').validate({
        submitHandler: function(form) {
            $.post('<?php echo site_url("employees/check_duplicate"); ?>', {
                    term: $('#first_name').val() + ' ' + $('#last_name').val()
                }, function(data) {
                    <?php if (!$person_info->person_id) { ?>
                    if (data.duplicate) {
                        bootbox.confirm(
                            <?php echo json_encode(lang('employees_duplicate_exists')); ?>,
                            function(result) {
                                if (result) {
                                    doEmployeeSubmit(form);
                                }
                            });
                    } else {
                        doEmployeeSubmit(form);
                    }
                    <?php } else { ?>
                    doEmployeeSubmit(form);
                    <?php } ?>
                }, "json")
                .error(function() {});
        },
        ignore: '',
        errorClass: "text-danger",
        errorElement: "p",
        errorPlacement: function(error, element) {
            error.insertBefore(element);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
        rules: {
            first_name: "required",
            <?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { 
					$custom_field = $this->Employee->get_custom_field($k);
					if($custom_field !== FALSE) {
						if( $this->Employee->get_custom_field($k,'required') && in_array($current_location, $this->Employee->get_custom_field($k,'locations'))){
							if(($this->Employee->get_custom_field($k,'type') == 'file' || $this->Employee->get_custom_field($k,'type') == 'image') && !$person_info->{"custom_field_${k}_value"}){
								echo "custom_field_${k}_value: 'required',\n";
							}
							
							if(($this->Employee->get_custom_field($k,'type') != 'file' && $this->Employee->get_custom_field($k,'type') != 'image')){
								echo "custom_field_${k}_value: 'required',\n";
							}
						}
					}
				}
					?>


            username: {
                <?php 
						
						
						 if (!$person_info->person_id || $person_info->username=='') { ?>
                remote: {
                    url: "<?php echo site_url('employees/exmployee_exists'); ?>",
                    type: "post"
                },
                <?php } ?>
                required: true,
                minlength: 1
            },

            password: {
                <?php
					if ($person_info->person_id == "") {
					?>
                required: true,
                <?php
					}
					?>
                minlength: 1
            },
            repeat_password: {
                equalTo: "#password"
            },
            email: {
                "required": true
            },

            "locations[]": "required"
        },
        messages: {
            first_name: <?php echo json_encode(lang('first_name_required')); ?>,
            last_name: <?php echo json_encode(lang('last_name_required')); ?>,
            <?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { 
					$custom_field = $this->Employee->get_custom_field($k);
					if($custom_field !== FALSE) {
						if( $this->Employee->get_custom_field($k,'required') && in_array($current_location, $this->Employee->get_custom_field($k,'locations'))){
							if(($this->Employee->get_custom_field($k,'type') == 'file' || $this->Employee->get_custom_field($k,'type') == 'image') && !$person_info->{"custom_field_${k}_value"}){
								$error_message = json_encode($custom_field." ".lang('is_required'));
								echo "custom_field_${k}_value: $error_message,\n";
							}

							if(($this->Employee->get_custom_field($k,'type') != 'file' && $this->Employee->get_custom_field($k,'type') != 'image')){
								$error_message = json_encode($custom_field." ".lang('is_required'));
								echo "custom_field_${k}_value: $error_message,\n";
							}
						}
					}
				}
				?>

            username: {
                <?php if (!$person_info->person_id  || $person_info->username=='') { ?>
                remote: <?php echo json_encode(lang('employees_username_exists')); ?>,
                <?php } ?>
                required: <?php echo json_encode(lang('username_required')); ?>,
                minlength: <?php echo json_encode(lang('username_minlength')); ?>
            },
            password: {
                <?php
					if ($person_info->person_id == "") {
					?>
                required: <?php echo json_encode(lang('employees_password_required')); ?>,
                <?php
					}
					?>
                minlength: <?php echo json_encode(lang('password_minlength')); ?>
            },
            repeat_password: {
                equalTo: <?php echo json_encode(lang('password_must_match')); ?>
            },
            email: <?php echo json_encode(lang('email_invalid_format')); ?>,
            "locations[]": <?php echo json_encode(lang('employees_one_location_required')); ?>
        }
    });

    $(document).on('change', '#permission_templates', function() {
        $(".module_checkboxes, .module_action_checkboxes, input[name='action-location[]'], input[name='module_location[]']")
            .prop('checked', false);

        var template_id = $(this).val();

        $.post('<?php echo site_url("employees/get_permission_template_wise_modules_actions_locations"); ?>', {
                template_id: template_id
            }, function(data) {
                console.log(data)
                $.each(data, function(key, value) {
                    if (value === true) {
                        $("#" + key).prop('checked', value);
                    }
                });
            }, "json")
            .error(function() {});
    });
});

var submitting = false;

function doEmployeeSubmit(form) {
    $("#grid-loader").show();
    if (submitting) return;
    submitting = true;

    $(form).ajaxSubmit({
        success: function(response) {
            $("#grid-loader").hide();
            submitting = false;
            if (response.redirect_code == 1 && response.success) {
                if (response.success) {
                    show_feedback('success', response.message, <?php echo json_encode(lang('success')); ?>);
                } else {
                    show_feedback('error', response.message, <?php echo json_encode(lang('error')); ?>);
                }
            } else if (response.redirect_code == 2 && response.success) {
                window.location.href = '<?php echo site_url('employees'); ?>';
            } else if (response.success) {
                show_feedback('success', response.message, <?php echo json_encode(lang('success')); ?>);
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");
                $(".form-group").removeClass('has-success has-error');
            } else {
                show_feedback('error', response.message, <?php echo json_encode(lang('error')); ?>);
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");
                $(".form-group").removeClass('has-success has-error');
            }
        },

        <?php if (!$person_info->person_id) { ?>
        resetForm: true,
        <?php } ?>
        dataType: 'json'
    });
}

$('.delete_file').click(function(e) {
    e.preventDefault();
    var $link = $(this);
    bootbox.confirm(<?php echo json_encode(lang('confirm_file_delete')); ?>, function(response) {
        if (response) {
            $.get($link.attr('href'), function() {
                $link.parent().fadeOut();
            });
        }
    });

});


function getEmployeeLocation(id) {
    var listid = ".list-group-item#" + id + " .drop-menu";
    var listarow = ".list-group-item#" + id + " .arrow";

    if ($(listid).hasClass('current')) {
        $('.drop-menu').removeClass('current');
    } else {
        $(listarow).animate({
            top: '-5px'
        });
        $(listarow).animate({
            top: '0px'
        });
        $(listarow).animate({
            top: '-5px'
        });
        $(listarow).animate({
            top: '0px'
        });
        $('.drop-menu').removeClass('current');
        $(listid).toggleClass('current');
    }
}

function selectAllLocation(id_name) {
    var name = ($('#' + id_name).attr("name"));

    if ($('#' + id_name).prop("checked") == true) {
        $('input[data-temp_name=' + name + ']').prop('checked', true);
    } else if ($('#' + id_name).prop("checked") == false) {
        $('input[data-temp_name=' + name + ']').prop('checked', false);
    }
}

$("#select_all").click(function(e) {

    if (!$(this).prop('checked')) {
        $(".location_checkboxes").prop('checked', false);
    } else {
        $(".location_checkboxes").prop('checked', true);
        check_boxes();
    }

});
$('.location_checkboxes').click(function() {
    check_boxes();
});
check_boxes();

function check_boxes() {
    var total_checkboxes = $(".location_checkboxes").length;
    var checked_boxes = 0;
    $(".location_checkboxes").each(function(index) {
        if ($(this).prop('checked')) {
            checked_boxes++;
        }
    });

    if (checked_boxes == total_checkboxes) {
        $("#select_all").prop('checked', true);
    } else {
        $("#select_all").prop('checked', false);
    }
}

$("#allowed_ip_address").selectize({
    create: true,
    render: {
        option_create: function(data, escape) {
            var add_new = <?php echo json_encode(lang('add_new_ip')) ?>;
            return '<div class="create">' + escape(add_new) + ' <strong>' + escape(data.input) +
                '</strong></div>';
        }
    },
});
</script>

<?php $this->load->view("partial/footer"); ?>
<style>
.drop-menu input {
    display: inline-block;
}

.list-group-item .iconi {
    position: relative;
    top: 0;
    left: -15px;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 60px;
    cursor: pointer;
}

.list-group-item .arrow {
    position: absolute;
    top: 0;
    left: -15px;
    animation: arrow 700ms linear infinite;
}

.list-group-item .open>.dropdown-menu {
    display: grid;
    position: relative;
    padding: 5px;
    left: -45px;
}

.list-group-item .open>.dropdown-menu:before {
    position: absolute;
    display: block;
    content: '';
    bottom: 100%;
    top: 5px;
    right: -4px;
    width: 7px;
    height: 7px;
    margin-bottom: -4px;
    border-top: 1px solid #b5b5b5;
    border-right: 1px solid #b5b5b5;
    background: #fff;
    transform: rotate(45deg);
    transition: all .4s ease-in-out;
}

.list-group-item .drop-down,
.dropup {
    position: relative;
}

.list-group-item .drop-menu {
    position: absolute;
    top: 100%;
    right: 95px;
    z-index: 1000;
    visibility: hidden;
    float: left;
    min-width: 160px;
    padding: 8px;
    margin: 2px 0 0;
    font-size: 14px;
    text-align: left;
    list-style: none;
    background-color: #fff;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, .15);
    border-radius: 4px;
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
    box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
    width: max-content;
    top: 20px;
    opacity: 0;
}

.list-group-item .current.drop-menu {
    visibility: visible;
    top: -3px;
    transition: all .6s;
    opacity: 1;
}

.list-group-item input+label {
    font-weight: 400;
    cursor: pointer;
}

.list-group-item input:checked+label {
    font-weight: 600;
    color: #6cadd1;
}

.list-group-item .drop-menu.current:before {
    position: absolute;
    display: block;
    content: '';
    bottom: 100%;
    top: 5px;
    right: -4px;
    width: 7px;
    height: 7px;
    margin-bottom: -4px;
    border-top: 1px solid #b5b5b5;
    border-right: 1px solid #b5b5b5;
    background: #fff;
    transform: rotate(45deg);
    transition: all .4s ease-in-out;
}

.list-group-item .text_align {
    transform: translateY(-2px);
    display: inline-block;
}

.list-group-item .text-info {
    margin-top: 8px;
}

.list-group-item i.icon.ti-location-pin.arrow {
    transform: translateY(2px);
}

.list-group-item hr {
    margin-top: 3px;
    margin-bottom: 8px;
    border: 0;
    border-top: 1px solid #eeeeee;
}
</style>