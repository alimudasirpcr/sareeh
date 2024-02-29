<?php $this->load->view("partial/header"); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<?php  $columns = get_table_columns('receivings'); 
                $columnSearch = array_filter($columns, function($key) {
                    return $key !== 'default_order';
                }, ARRAY_FILTER_USE_KEY);
                
    ?>
<div class="card">
    <div class="card-body">
        
    <ul class="list-inline">
					
					<?php if(getenv('MASTER_USER')==$this->Employee->get_logged_in_employee_info()->id){ ?>

						<li class="hidden-xs text-gray-600">
							<?php echo lang('locations'); ?>: 	
							<?php 
								echo form_dropdown('location', $locations,$location, 'class="" id="location_listd"'); 
							?>
						</li>

						<?php } ?>

                        <?php if(getenv('MASTER_USER')==$this->Employee->get_logged_in_employee_info()->id){ ?>

                            <li class="hidden-xs text-gray-600">
                                <?php echo lang('locations'); ?>: 	
                                <?php 
                                    echo form_dropdown('location_transfer_to', $locations,$location, 'class="" id="location_transfer_to_listd"'); 
                                ?>
                            </li>

                            <?php } ?>
                            <li class="hidden-xs text-gray-600">
                                <?php echo lang('Type'); ?>: 	
                                <?php
                                $types = array(
                                    '-1' => 'All',
                                    'Transfer Request' => 'Transfer Request',
                                    'Receiving' => 'Receiving',
                                    'Receiving suspended' => 'Receiving suspended',
                                    'Return' => 'Return',
                                    'Return suspended' => 'Return suspended',
                                    'Transfer' => 'Transfer',
                                    'Transfer suspended' => 'Transfer suspended',
                                );
                                $type = -1;
                                    echo form_dropdown('type', $types, $type ,'class="" id="type_status"'); 
                                ?>
                            </li>

                        <li class="hidden-xs text-gray-600">
							<?php echo lang('suppliers'); ?>: 	
							<?php 
								echo form_dropdown('supplier',$suppliers,$supplier, 'class="" id="supplier_listd"'); 
							?>
						</li>


                        <li class="hidden-xs text-gray-600">
							<?php echo lang('from_date'); ?>: 	
							<input type="date" class="form-control" name="from_date" id="from_date">
						</li>
                        <li class="hidden-xs text-gray-600">
                            <?php echo lang('to_date');?>:
                            <input type="date" class="form-control" name="to_date" id="to_date">
                        </li>
                        <li class="hidden-xs text-gray-600">
                            <button type="button" id="resetButton" class="btn btn-primary"><?= lang('reset') ?></button>
                        </li>
    </ul>
    </div>
</div>

<div class="card mt-5 ">
<?php $this->load->view("receivings/receivings_header"); ?>
  
  <div class="card-body">

    <div class="table-responsive">
    <table id="example" class="table table-striped gy-7 gs-7" style="width:100%">
    <thead>
        <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
        <?php $i=0; foreach($columns as $key => $col): ?>
            <th><?= lang($col) ?></th>
            <?php $i++; endforeach ?>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data rows will be inserted here by DataTables -->
    </tbody>
    </table>
    <div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Receipt</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-dismiss="modal" aria-label="Close">
                <i class="bi bi-x-lg"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body" id="modal_receipt">
           
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              
            </div>
        </div>
    </div>
</div>
<script>

$(document).ready(function() {

    
    $("#location_listd").select2({dropdownAutoWidth : true});
    $("#location_transfer_to_listd").select2({dropdownAutoWidth : true});
    
    $("#supplier_listd").select2({dropdownAutoWidth : true});
    $("#type_status").select2({dropdownAutoWidth : true});
    var table =  $('#example').DataTable({
        "paging": true, // Ensure paging is enabled
        "pageLength": 10, // Adjust as per your requirement
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "order": [],
       
        "ajax": {
            "url": "<?php echo site_url('receivings/ajaxList') ?>",
            "type": "POST",
            "data": function(d) {
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },
        "columns": [
            <?php $i=0; foreach($columns as $key => $col): ?>
            { "data": "<?= $key ?>" },
            <?php $i++; endforeach ?>
            { "data": "action" },

        ],
        "drawCallback": function(settings) {

            $('.view_receipt').click(function() {
                id =  $(this).data('id');
                

                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url('receivings/receipt_view_ajax/') ?>"+id+"",
                   
                    success: function (response) {
                            $('#kt_modal_1').modal('show');
                            $('#modal_receipt').html(response);
                    }
                });
            });

            $('[data-kt-menu-trigger="click_receiving"]').off('click').on('click', function(e) {
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
    $('.toggle-vis').on('change', function (e) {
    // Get the column API object
        var column = table.column($(this).data('column-index'));

        // Toggle the visibility
        column.visible(!column.visible());
    });
    $('#location_listd').on('change', function(){
    var searchTerm = $(this).val();
    
        // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
        table.column(2).search(searchTerm).draw(); // Adjust the column index as necessary
    });
   
    $('#location_transfer_to_listd').on('change', function(){
    var searchTerm = $(this).val();
    
        // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
        table.column(3).search(searchTerm).draw(); // Adjust the column index as necessary
    });
   
   


    
    $('#supplier_listd').on('change', function(){
        var searchTerm = $(this).val();
        
        // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
        table.column(4).search(searchTerm).draw(); // Adjust the column index as necessary
    });

    $('#type_status').on('change', function(){
    var searchTerm = $(this).val();
    
        // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
        table.column(5).search(searchTerm).draw(); // Adjust the column index as necessary
    });


    $('#from_date , #to_date').on('change', function(){
        var searchTerm = $(this).val();
        table.ajax.reload(); 
    });
    $('#resetButton').click(function() {
    $('#from_date').val('');
    $('#to_date').val('');
    <?php if(getenv('MASTER_USER')==$this->Employee->get_logged_in_employee_info()->id){ ?>
    $('#location_listd').val(-1).trigger('change');
    $('#location_transfer_to_listd').val(-1).trigger('change');
    <?php } ?>
    $('#supplier_listd').val(-1).trigger('change');
    $('#type_status').val(-1).trigger('change');
    table.state.clear(); // Clears the saved state of the table
    table.search('').columns().search('').draw();
});
});

</script>

    </div>
  </div>
</div>

<?php $this->load->view('partial/footer.php'); ?>