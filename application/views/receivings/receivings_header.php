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

                        <?php if(getenv('MASTER_USER')==$this->Employee->get_logged_in_employee_info()->id){ ?>

                            <li class="hidden-xs text-gray-600">
                               
                                <?php 
                                    echo form_dropdown('location_transfer_to', $locations,$location, 'class="" id="location_transfer_to_listd"'); 
                                ?>
                            </li>

                            <?php } ?>
                            <li class="hidden-xs text-gray-600">
                            
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
						
							<?php 
								echo form_dropdown('supplier',$suppliers,$supplier, 'class="" id="supplier_listd"'); 
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

    <?php  $columns = get_table_columns('sales'); 
                $columnSearch = array_filter($columns, function($key) {
                    return $key !== 'default_order';
                }, ARRAY_FILTER_USE_KEY);
                
    ?>

    <form id="config_columns">
        <div class="piluku-dropdown btn-group table_buttons">
            <button type="button" class="btn btn-more btn-light btn-active-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="ion-gear-a"></i>
            </button>

            <ul id="sortable" class="dropdown-menu dropdown-menu-right col-config-dropdown ui-sortable" role="menu" style="">
                <li class="dropdown-header"><a id="reset_to_default" class="pull-right"><span class="ion-refresh"></span> <?= lang('Reset'); ?> </a>Column Configuration</li>
            <?php $i=0; foreach($columns as $key => $col): ?>
                <li class="sort">
                    <a class="d-flex justify-content-space-between ">
                        <div class="form-check">
                            <input type="checkbox" class="toggle-vis form-check-input" data-column-index="<?= $i ?>" id="check<?= $i ?>" checked>
                            <label class="form-check-label" for="check<?= $i ?>"><span></span><?= $col ?></label>
                        </div>
                        <span class="handle ion-drag"></span>
                    </a>
                </li>
            <?php $i++; endforeach ?>
            </ul>
        </div>
    </form>
</div></div>
