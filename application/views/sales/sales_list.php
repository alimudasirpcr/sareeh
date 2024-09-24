<?php $this->load->view("partial/header"); ?>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
<!-- ColReorder JS -->
<script src="https://cdn.datatables.net/colreorder/2.0.4/js/dataTables.colReorder.js"></script>
<script src="https://cdn.datatables.net/colreorder/2.0.4/js/colReorder.dataTables.js"></script>
<?php  $columns = get_table_columns('sales'); 
                $columnSearch = array_filter($columns, function($key) {
                    return $key !== 'default_order';
                }, ARRAY_FILTER_USE_KEY);
                
    ?>


<div class="card">
    <?php $this->load->view("sales/sales_header"); ?>

    <div class="card-body pt-0">

        <div class="table-responsive">
            <table id="example" class="table table-striped gy-7 gs-7" style="width:100%">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
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
                    "pageLength": 10, // Adjust as per your requirement
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
                        }
                    },
                    "columns": [
                        <?php $i=0; foreach($all_columns as $key => $col): ?> {
                            "data": "<?= $key ?>"
                        },
                        <?php $i++; endforeach ?>

                    ],
                    "drawCallback": function(settings) {
                        // Custom class for the pagination wrapper
                        $('.dt-paging').addClass('pagination');
                        // setTimeout(function() {

                        //     $(".dt-paging-button").each(function() {
                        //         $(this).html('<span class="page-link" > ' + $(this).html()+ '</span>'  );
                        //     });
                        //         $('.dt-paging').find('.dt-paging-button').addClass('page-item');
                        //         $('.dt-paging').find('.dt-paging-button').addClass('page-item-class');
                        //         $('.dt-paging').find('.current').addClass('active');

                        //     }, 10);  // Adjust the delay as needed
                        // $('.dt-paging').find('.dt-paging-button').addClass('page-item');
                        // console.log('dt-paging-pagination' ,  $('.dt-paging').find('.dt-paging-button').addClass());
                        // Iterate over each paginate button and modify
                        // $('.dt-paging-button').each(function() {
                        //     console.log('dt-paging-button');
                        //     $(this).addClass('page-item-new');
                        //     $(this).children('a').addClass('page-link');
                        // });

                        // Handle the active class
                        // $('.dataTables_paginate .paginate_button.current').addClass('active');

                        // // Optionally, handle the disabled state for previous/next buttons
                        // $('.dataTables_paginate .paginate_button.previous.disabled, .dataTables_paginate .paginate_button.next.disabled')
                        //     .addClass('disabled');
                    }
                });
                $('.columns').on('change', function(e) {
                    //     console.log('callled');
                    // // Get the column API object
                    //     var column = table.column($(this).data('column-index'));



                    //     // Toggle the visibility
                    //     column.visible(!column.visible());
                });


                $('#location_listd').on('change', function() {

                    var searchTerm = $(this).val();
                    var colIndex = $('#config_columns input:checkbox').index($('#location_name'));
                    // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
                    table.column(colIndex).search(searchTerm).draw(); // Adjust the column index as necessary
                });

                $('#s2id_location_listd').on('click', function() {

                    $('#customer_listd').select2('close'); // Close the previously opened dropdown
                    $('#sale_type').select2('close');

                });
                $('#customer_listd').on('change', function() {
                    var searchTerm = $(this).val();
                    var colIndex = $('#config_columns input:checkbox').index($('#customer_name'));
                    // console.log(colIndex);
                    // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
                    table.column(colIndex).search(searchTerm).draw(); // Adjust the column index as necessary
                });
                
                $('#s2id_customer_listd').on('click', function() {
                    
                    $('#location_listd').select2('close'); // Close the previously opened dropdown
                    $('#sale_type').select2('close');

                });
                $('#sale_type').on('change', function() {
                    var searchTerm = $(this).val();
                    var colIndex = $('#config_columns input:checkbox').index($('#suspended_type'));
                    // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
                    table.column(colIndex).search(searchTerm).draw(); // Adjust the column index as necessary
                });
                $('#s2id_sale_type').on('click', function() {

                    $('#location_listd').select2('close'); // Close the previously opened dropdown
                    $('#customer_listd').select2('close');

                });
                $('#from_date , #to_date').on('change', function() {
                    var searchTerm = $(this).val();
                    table.ajax.reload();
                });
                $('#resetButton').click(function() {
                    $('#from_date').val('');
                    $('#to_date').val('');
                    <?php if(getenv('MASTER_USER')==$this->Employee->get_logged_in_employee_info()->id){ ?>
                    $('#location_listd').val(-1).trigger('change');
                    <?php } ?>
                    $('#customer_listd').val(-1).trigger('change');
                    table.state.clear(); // Clears the saved state of the table
                    table.search('').columns().search('').draw();
                });
                var old_columns = [];
                $("#config_columns input:checkbox").each(function() {
                    old_columns.push($(this)
                .val()); // Assuming checkbox values correspond to column indices
                });
                $("#config_columns input:checkbox").each(function() {
                    // Get the index of the checkbox within the collection of checkboxes
                    var colIndex = $('#config_columns input:checkbox').index(this);

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
                    $("#config_columns input:checkbox").each(function() {
                        columns.push($(this)
                    .val()); // Assuming checkbox values correspond to column indices
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
                    $("#config_columns input:checkbox").each(function() {
                        // Get the index of the checkbox within the collection of checkboxes
                        var colIndex = $('#config_columns input:checkbox').index(this);

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

                $("#config_columns input[type=checkbox]").on('change', function(e) {
                    console.log("changed");
                    var columns = [];

                    // Get all checked checkboxes in the sorted order
                    $("#config_columns input:checkbox:checked").each(function() {
                        columns.push($(this).val()); // Add the column's index or identifier
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
</div>

<?php $this->load->view('partial/footer.php'); ?>