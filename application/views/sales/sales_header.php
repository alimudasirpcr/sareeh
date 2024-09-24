<div class="card-header align-items-center py-1 gap-2 gap-md-5">

	<div class="card-title">


	<ul class="list-inline">
					
					<?php if(getenv('MASTER_USER')==$this->Employee->get_logged_in_employee_info()->id){ ?>

						<li class="hidden-xs text-gray-600">
                          
							<?php 
								echo form_dropdown('location', $locations,$location, 'class="" id="location_listd"'); 
							?>
						</li>

						<?php } ?>

                        <li class="hidden-xs text-gray-600">
								
							<?php 
								echo form_dropdown('customers',$customers,$customer, 'class="" id="customer_listd"'); 
							?>
						</li>

                        <li class="hidden-xs text-gray-600">
							
							<?php 
								echo form_dropdown('sale_type',$sales_types,$sales_type, 'class="" id="sale_type"'); 
							?>
						</li>


                        <li class="hidden-xs text-gray-600">
							
							<input type="date" class="form-control" name="from_date" id="from_date">
						</li>
                        <li class="hidden-xs text-gray-600">
                          
                            <input type="date" class="form-control" name="to_date" id="to_date">
                        </li>
                        <li class="hidden-xs text-gray-600">
                            <button type="button" id="resetButton" class="btn btn-primary"><?= lang('reset') ?></button>
                        </li>
    </ul>
					</div>
					<div class="card-toolbar flex-row-fluid justify-content-end gap-5">

 

    <form id="config_columns">
        <div class="piluku-dropdown btn-group table_buttons">
            <button type="button" class="btn btn-more btn-light btn-active-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="ion-gear-a"></i>
            </button>

                <ul id="sortable" class="dropdown-menu dropdown-menu-right col-config-dropdown" role="menu">
										<li class="dropdown-header">
											<a id="reset_to_default" class="pull-right btn"><span class="ion-refresh"></span> Reset</a><?php echo lang('column_configuration'); ?></li>
																			
										<?php foreach($all_columns as $col_key => $col_value) { 
											$checked = '';
											
											if (isset($selected_columns[$col_key]))
											{
												$checked = 'checked ="checked" ';
											}
											?>
											<li class="sort "><a class="form-check form-check-sm form-check-custom form-check-solid"><input   <?php echo $checked; ?> name="selected_columns[]" type="checkbox" class="columns form-check-input" id="<?php echo $col_key; ?>" value="<?php echo $col_key; ?>"><label class="form-check-label" for="<?php echo $col_key; ?>"><span></span><?php echo H($col_value['label']); ?></label><span class="handle ion-drag pull-right"></span></a></li>									
										<?php } ?>
									</ul>
            </ul>
        </div>
    </form>
	</div>
</div>