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
        </tr>
    </thead>
    <tbody>
        <!-- Data rows will be inserted here by DataTables -->
    </tbody>
    </table>

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

        ],
        "drawCallback": function(settings) {
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