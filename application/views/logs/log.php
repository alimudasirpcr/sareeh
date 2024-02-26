<?php $this->load->view("partial/header"); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<?php  $columns = get_table_columns('log'); 
                $columnSearch = array_filter($columns, function($key) {
                    return $key !== 'default_order';
                }, ARRAY_FILTER_USE_KEY);
                
    ?>
<div class="row g-5 g-xxl-10">
    <!--begin::Col-->

    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-12 mb-xxl-10">
        <!--begin::List widget 14-->
        <div class="card card-flush h-xl-100">
            <!--begin::Header-->
            <div class="card-header pt-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900"><?= lang('activity_&_logs_viewer') ?></span>
                    <span class="text-gray-500 pt-2 fw-semibold fs-6"><?= lang('Latest_activities') ?></span>
                </h3>
                <!--end::Title-->
                <ul class="list-inline">
					
					
                        <li class="hidden-xs text-gray-600">
							<?php echo lang('type'); ?>: 	
							<?php 
								echo form_dropdown('type',$types,$type, 'class="" id="type"'); 
							?>
						</li>
                       

                        <li class="hidden-xs text-gray-600">
							<?php echo lang('employees'); ?>: 	
							<?php 
								echo form_dropdown('employees',$employees,$employee, 'class="" id="employees"'); 
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
            <!--end::Header-->

            <!--begin::Body-->
            <div class="card-body pt-6">
                <div class="table-responsive">
                    <table id="example" class="table table-striped gy-7 gs-7" style="width:100%">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                <?php $i = 0;
                                foreach ($columns as $key => $col) : ?>
                                    <th><?= lang($key) ?></th>
                                <?php $i++;
                                endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data rows will be inserted here by DataTables -->
                        </tbody>
                    </table>

                </div>
            </div>
            <!--end: Card Body-->
        </div>
        <!--end: List widget 14-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->

    <!--end::Col-->
</div>
<script>
$(document).ready(function() {
    $("#location_listd").select2({dropdownAutoWidth : true});
    $("#employees").select2({dropdownAutoWidth : true});
    $("#type").select2({dropdownAutoWidth : true});
    var table =  $('#example').DataTable({
        "paging": true, // Ensure paging is enabled
        "pageLength": 10, // Adjust as per your requirement
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "order": [],
       
        "ajax": {
            "url": "<?php echo site_url('logs/ajaxList') ?>",
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
    $('#employees').on('change', function(){
        var searchTerm = $(this).val();
        
        // Apply the search to the specific DataTable column (e.g., the "Payment Type" column)
        table.column(3).search(searchTerm).draw(); // Adjust the column index as necessary
    });
    $('#type').on('change', function(){
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
    <?php } ?>
    $('#customer_listd').val(-1).trigger('change');
    table.state.clear(); // Clears the saved state of the table
    table.search('').columns().search('').draw();
});
});

</script>
<?php $this->load->view("partial/footer"); ?>