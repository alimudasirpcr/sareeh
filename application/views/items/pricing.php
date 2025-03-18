<?php $this->load->view("partial/header"); ?>
<?php if( $this->uri->segment(2) !='view'): ?>
                <?php $this->load->view('partial/categories/category_modal', array('categories' => $categories));?>
<?php endif; ?>
<?php $query = http_build_query(array('redirect' => $redirect, 'progression' => $progression ? 1 : null, 'quick_edit' => $quick_edit ? 1 : null)); ?>

<div class="spinner" id="grid-loader" style="display:none">
    <div class="rect1"></div>
    <div class="rect2"></div>
    <div class="rect3"></div>
</div>

<div class="manage_buttons hidden">
    <div class="row">
        <div
            class="<?php echo isset($redirect) ? 'col-xs-9 col-sm-10 col-md-10 col-lg-10': 'col-xs-12 col-sm-12 col-md-12' ?> margin-top-10">
            <div class="modal-item-info padding-left-10">
                <div class="breadcrumb-item text-dark">
                    <?php if(!$item_info->item_id) { ?>
                    <span class="modal-item-name new"><?php echo lang('items_new'); ?></span>
                    <?php } else { ?>
                    <span
                        class="modal-item-name"><?php echo H($item_info->name).' ['.lang('id').': '.$item_info->item_id.']'; ?></span>
                    <span
                        class="badge badge-success fw-semibold fs-9 px-2 ms-2 cursor-default ms-2"><?php echo H($category); ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if(isset($redirect) && !$progression) { ?>
        <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2 margin-top-10">
            <div class="buttons-list">
                <div class="pull-right-btn">
                    <?php echo 
					anchor(site_url($redirect), ' ' . lang('done'), array('class'=>'outbound_link btn btn-primary btn-lg ion-android-exit', 'title'=>''));
				?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>



<?php echo form_open('items/save_item_pricing/'.(!isset($is_clone) ? $item_info->item_id : ''),array('id'=>'item_form','class'=>'form-horizontal form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework')); ?>
<?php $this->load->view('partial/item_side_bar', array('progression' => $progression, 'query' => $query, 'item_info' => $item_info)); ?>
<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
    <?php if(!$quick_edit) { ?>
    <?php $this->load->view('partial/nav', array('progression' => $progression, 'query' => $query, 'item_info' => $item_info)); ?>
    <?php } ?>
    <div class="row  ">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div
                    class="card-header rounded rounded-3 p-5  rounded border-primary border border-dashed rounded-3pricing-widget">
                    <h3 class="card-title"> <?php echo lang("pricing"); ?>
                      
                    </h3>

                    <div class="breadcrumb breadcrumb-dot text-muted fs-6 fw-semibold" id="pagination_top">
                        <?php
					if (isset($prev_item_id) && $prev_item_id)
					{
							echo anchor('items/pricing/'.$prev_item_id, '<span class="hidden-xs ion-chevron-left"> '.lang('items_prev_item').'</span>');
					}
					if (isset($next_item_id) && $next_item_id)
					{
							echo anchor('items/pricing/'.$next_item_id,'<span class="hidden-xs">'.lang('items_next_item').' <span class="ion-chevron-right"></span</span>');
					}
					?>
                    </div>
                </div>

                <div class="card-body">

                    <div class="d-flex flex-wrap gap-5">

                        <?php if ($progression || $this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                            <?php echo form_label(lang('cost_price').' ('.lang('without_tax').')'.':', 'cost_price',array('class'=>'form-label required wide')); ?>

                            <div class="input-group">

                                <?php echo form_input(array(
									'name'=>'cost_price',
									'size'=>'8',
									'id'=>'cost_price',
									'class'=>'form-control form-inps',
									'value'=>$item_info->cost_price ? to_currency_no_money($item_info->cost_price,10) : '')
								);?>
                                <span class="input-group-text bg"><span
                                        class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>
                            </div>
                        </div>
                        <?php 
				}
				else
				{
					echo form_hidden('cost_price', $item_info->cost_price);
				}
				?>

                        <?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id) or $item_info->name=="") { ?>
                        <?php if ($this->config->item('enable_markup_calculator')) { ?>
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                            <?php echo form_label(lang('markup').':', 'margin',array('class'=>'form-label wide')); ?>

                            <div class="input-group">
                                <?php echo form_input(array(
									'type'=> 'number',
									'min'=> '0',
									'max'=> '',
					        		'name'=>'markup',
					        		'size'=>'8',
									'class'=>'form-control',
					        		'id'=>'markup',
					        		'value'=>'',
								  'placeholder' => lang('enter_markup_percent'),
								)
						    );?>
                                <span class="input-group-text bg"><span class="">%</span></span>
                            </div>

                        </div>
                        <?php } ?>
                    </div>
                    <div class="d-flex flex-wrap gap-5">
                        <?php if ($this->config->item('enable_margin_calculator')) { ?>
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('margin').':', 'margin',array('class'=>'form-label wide')); ?>

                            <div class="input-group">
                                <?php echo form_input(array(
									'type'=> 'number',
									'min'=> '0',
									'max'=> '',
					        'name'=>'margin',
					        'size'=>'8',
									'class'=>'form-control',
					        'id'=>'margin',
					        'value'=>'',
								  'placeholder' => lang('enter_margin_percent'),
								)
						    );?>
                                <span class="input-group-text bg"><span class="">%</span></span>
                            </div>

                        </div>
                        <?php } ?>

                        <?php } ?>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('unit_price').':', 'unit_price',array('class'=>'form-label required wide')); ?>

                            <div class="input-group">

                                <?php echo form_input(array(
								'name'=>'unit_price',
								'size'=>'8',
								'id'=>'unit_price',
										'class'=>'form-control form-inps',
								'value'=>$item_info->unit_price ? to_currency_no_money($item_info->unit_price, 10) : '')
							);?>
                                <span class="input-group-text bg"><span
                                        class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-5">
                        <?php foreach($tiers as $tier) { 
					
					$selected_tier_type_option = '';
					$tier_price_value = '';
					
					if ($tier_prices[$tier->id] !== FALSE)
					{
						if ($tier_prices[$tier->id]->unit_price !== NULL)
						{
							$selected_tier_type_option = 'unit_price';
							$tier_price_value = to_currency_no_money($tier_prices[$tier->id]->unit_price,10);
							
						}
						elseif($tier_prices[$tier->id]->percent_off !== NULL)
						{
							$selected_tier_type_option = 'percent_off';		
							$tier_price_value = to_quantity($tier_prices[$tier->id]->percent_off,false);						
														
						}
						elseif($tier_prices[$tier->id]->cost_plus_percent !== NULL)
						{
							$selected_tier_type_option = 'cost_plus_percent';		
							$tier_price_value = to_quantity($tier_prices[$tier->id]->cost_plus_percent,false);						
																							
						}
						elseif($tier_prices[$tier->id]->cost_plus_fixed_amount !== NULL)
						{
							$selected_tier_type_option = 'cost_plus_fixed_amount';
							$tier_price_value = to_currency_no_money($tier_prices[$tier->id]->cost_plus_fixed_amount,10);						
																
						}
					}
					
					?>
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label($tier->name.':', 'tier_'.$tier->id,array('class'=>'form-label wide')); ?>

                            <div class="input-group">

                                <span
                                    class="input-group-text tier_dropdown_group"><?php	echo form_dropdown('tier_type['.$tier->id.']', $tier_type_options, $selected_tier_type_option,'class="form-control tier_dropdown"');?></span>
                                <?php echo form_input(array(
									'name'=>'item_tier['.$tier->id.']',
									'size'=>'8',
									'id'=>'tier_'.$tier->id,
									'class'=>'form-control form-inps margin10',
									'placeholder'=>'value',
									'value'=> $tier_price_value,
								));?>
                                <span class="input-group-text bg"><span
                                        class="flat"><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span><span
                                        class="percent hidden">%</span></span>

                            </div>
                        </div>
                        <?php } ?>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('items_promo_price').':', 'promo_price',array('class'=>'form-label wide')); ?>

                            <div class="input-group">

                                <?php echo form_input(array(
						        'name'=>'promo_price',
						        'size'=>'8',
										'class'=>'form-control',
						        'id'=>'promo_price',
						        'value'=> $item_info->promo_price ? to_currency_no_money($item_info->promo_price,10) : '')
						    );?>
                                <span class="input-group-text bg"><span
                                        class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-5">
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('items_promo_start_date').':', 'start_date',array('class'=>'form-label  wide')); ?>

                            <div class="input-group date"
                                data-date="<?php echo $item_info->start_date ? date(get_date_format(), strtotime($item_info->start_date)) : ''; ?>">

                                <?php echo form_input(array(
						        'name'=>'start_date',
						        'id'=>'start_date',
										'class'=>'form-control datepicker',
						        'value'=>$item_info->start_date ? date(get_date_format(), strtotime($item_info->start_date)) : '')
						    );?>
                                <span class="input-group-text bg">
                                    <i class="ion ion-ios-calendar-outline"></i>
                                </span>
                            </div>
                        </div>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('items_promo_end_date').':', 'end_date',array('class'=>'form-label  wide')); ?>

                            <div class="input-group date"
                                data-date="<?php echo $item_info->end_date ? date(get_date_format(), strtotime($item_info->end_date)) : ''; ?>">

                                <?php echo form_input(array(
						        'name'=>'end_date',
						        'id'=>'end_date',
										'class'=>'form-control form-inps datepicker',
						        'value'=>$item_info->end_date ? date(get_date_format(), strtotime($item_info->end_date)) : '')
						    );?>
                                <span class="input-group-text bg">
                                    <i class="ion ion-ios-calendar-outline"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php if($item_variations) { ?>
                    <div class="row fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                        <label class="form-label"><?php echo lang('items_variations').':' ?></label>

                        <div class="table-responsive">
                            <table id="item_variation_prices" class="table">
                                <thead>
                                    <tr>
                                        <th width="15%"><?php echo lang('supplier'); ?></th>
                                        <th width="16%">
                                            <?php echo lang('name'); ?>/<?php echo lang('items_attributes'); ?></th>
                                        <?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                        <th width="15%"><?php echo lang('cost_price'); ?></th>
                                        <?php } ?>
                                        <th width="15%"><?php echo lang('unit_price'); ?></th>
                                        <th width="15%"><?php echo lang('items_promo_price'); ?></th>
                                        <th width="12%"><?php echo lang('items_promo_start_date'); ?></th>
                                        <th width="12%"><?php echo lang('items_promo_end_date'); ?></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
								 foreach($item_variations as $variation_id => $item_variation) { 
						 
									 $variation_name = $item_variation['name'];
						 
									 ?>
                                    <tr data-index="<?php echo H($variation_id); ?>">
                                        <td class="item_supplier_name">
                                            <?php echo H($item_variation['supplier_name']); ?></td>
                                        <td class="item_variation_name">
                                            <?php echo $variation_name ? H($variation_name) : implode(', ',array_column($item_variation['attributes'],'label'));?>
                                        </td>

                                        <?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                        <td class="cost_price top">
                                            <input type="text" class="form-control" size="20"
                                                name="variations[<?php echo H($variation_id); ?>][cost_price]"
                                                value="<?php echo $item_variation['cost_price'] ? to_currency_no_money(H($item_variation['cost_price']),10) : '';?>" />
                                        </td>

                                        <?php 
											} else {
												echo form_hidden('cost_price', $item_info->cost_price);
											}
											?>

                                        <td class="unit_price top">
                                            <input type="text" class="form-control" size="20"
                                                name="variations[<?php echo H($variation_id); ?>][unit_price]"
                                                value="<?php echo $item_variation['unit_price'] ? to_currency_no_money(H($item_variation['unit_price']),10) : '';?>" />
                                        </td>

                                        <td class="promo_price top">
                                            <input type="text" class="form-control" size="20"
                                                name="variations[<?php echo H($variation_id); ?>][promo_price]"
                                                value="<?php echo $item_variation['promo_price'] ? to_currency_no_money(H($item_variation['promo_price']),10) : '';?>" />
                                        </td>

                                        <td class="promo_start top">
                                            <?php echo form_input(array(
											        'name'=>"variations[$variation_id][start_date]",
											        'id'=>'start_date_<?php echo $variation_id; ?>',
                                            'class'=>'form-control datepicker',
                                            'value'=> $item_variation['start_date'] ? date(get_date_format(),
                                            strtotime($item_variation['start_date'])) : '')
                                            );?>
                                        </td>

                                        <td class="promo_end top">
                                            <?php echo form_input(array(
											        'name'=>"variations[$variation_id][end_date]",
											        'id'=>"end_date_$variation_id",
															'class'=>'form-control datepicker',
											        'value'=> $item_variation['end_date'] ? date(get_date_format(), strtotime($item_variation['end_date'])) : '')
											    );?>
                                        </td>

                                    </tr>

                                    <?php
									 }
									 ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <?php } ?>

                    <?php
				if ($cc_processor_class_name == 'CORECLEARBLOCKCHYPPROCESSOR')
				{
				?>
                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                        <?php echo form_label(lang('items_is_recurring').':', 'is_recurring',array('class'=>'form-label wide')); ?>
                        <div class="form-check form-check-custom form-check-solid">
                            <?php echo form_checkbox(array(
							'name'=>'is_recurring',
							'id'=>'is_recurring',
							'class'=>'delete-checkbox form-check-input',
							'value'=>1,
							'checked'=>$item_info->is_recurring ? 1 : 0,
						));?>
                            <label for="is_recurring"><span></span></label>
                        </div>
                    </div>

                    <div id="recurring_options" style="display: none;">


                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('items_startup_cost').':', 'startup_cost',array('class'=>'form-label wide')); ?>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-text bg"><span
                                            class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>
                                    <?php echo form_input(array(
								'name'=>'startup_cost',
								'size'=>'8',
								'id'=>'startup_cost',
								'class'=>'form-control form-inps',
								'value'=>$item_info->startup_cost ? to_currency_no_money($item_info->startup_cost, 10) : '')
							);?>
                                </div>
                            </div>
                        </div>


                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('items_prorated').':', 'prorated',array('class'=>'form-label wide')); ?>
                            <div class="form-check form-check-custom form-check-solid">
                                <?php echo form_checkbox(array(
							'name'=>'prorated',
							'id'=>'prorated',
							'class'=>'delete-checkbox form-check-input',
							'value'=>1,
							'checked'=>$item_info->prorated ? 1 : 0,
						));?>
                                <label for="prorated"><span></span></label>
                            </div>
                        </div>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('items_interval').':', 'interval',array('class'=>'form-label wide ')); ?>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                <?php echo form_dropdown('interval', array('weekly' => lang('items_weekly'),'monthly_on_day_of_month' => lang('items_monthly_on_day_of_month'),'monthly_on_day_of_week' => lang('items_monthly_on_day_of_week'), 'yearly_on_date' => lang('items_yearly_on_date'), 'yearly_on_month_on_day_of_week' => lang('items_yearly_on_month_on_day_of_week')), $item_info->interval,'class="form-control" id="interval"');?>
                            </div>
                        </div>



                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5" id="month_container"
                            style="display:none;">
                            <?php echo form_label(lang('month').':', 'month',array('class'=>'form-label wide ')); ?>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                <?php echo form_dropdown('month', get_months('n'), $item_info->month,'class="form-control" id="month"');?>
                            </div>
                        </div>


                        <?php
					$day_numbers = array();
					
					foreach(range(1,31) as $day)
					{
						$day_numbers[$day] = $day;
					}
				?>
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5" id="day_number_container"
                            style="display:none;">
                            <?php echo form_label(lang('items_day_number').':', 'day_number',array('class'=>'form-label wide ')); ?>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                <?php echo form_dropdown('day_number', $day_numbers, $item_info->day_number,'class="form-control" id="day_number"');?>
                            </div>
                        </div>


                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5" id="day_container"
                            style="display:none;">
                            <?php echo form_label(lang('day').':', 'day',array('class'=>'form-label wide ')); ?>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                <?php echo form_dropdown('day', array(1=> 'First', 2 => 'Second',  3=> 'Third', 4 => 'Fourth', 5 =>'Last'), $item_info->day,'class="form-control" id="day"');?>
                            </div>
                        </div>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5" id="weekday_container"
                            style="display:none;">
                            <?php echo form_label(lang('items_weekday').':', 'weekday',array('class'=>'form-label wide ')); ?>
                            <div class="col-sm-9 col-md-9 col-lg-10">
                                <?php echo form_dropdown('weekday', array('0' => lang('sunday'),'1' => lang('monday'),'2' => lang('tuesday'), '3' => lang('wednesday'), '4' => lang('thursday'), '5' => lang('friday'), '6' => lang('saturday')), $item_info->weekday,'class="form-control" id="weekday"');?>
                            </div>
                        </div>





                        <script>
                        function interval_calc() {
                            switch ($("#interval").val()) {
                                case 'weekly':
                                    $("#day_number_container").hide();
                                    $("#month_container").hide();
                                    $("#weekday_container").show();
                                    $("#day_container").hide();
                                    break;
                                case 'monthly_on_day_of_month':
                                    $("#day_number_container").show();
                                    $("#month_container").hide();
                                    $("#weekday_container").hide();
                                    $("#day_container").hide();

                                    break;

                                case 'monthly_on_day_of_week':
                                    $("#day_number_container").hide();
                                    $("#month_container").hide();
                                    $("#weekday_container").show();
                                    $("#day_container").show();

                                    break;

                                case 'yearly_on_date':

                                    $("#day_number_container").show();
                                    $("#month_container").show();
                                    $("#weekday_container").hide();
                                    $("#day_container").hide();

                                    break;

                                case 'yearly_on_month_on_day_of_week':

                                    $("#day_number_container").hide();
                                    $("#month_container").show();
                                    $("#weekday_container").show();
                                    $("#day_container").show();
                                    break;
                            }
                        }
                        $("#interval").change(interval_calc);
                        interval_calc();



                        $("#is_recurring").change(function() {
                            if ($(this).prop('checked')) {
                                $("#recurring_options").show();
                            } else {
                                $("#recurring_options").hide();
                            }
                        });

                        if ($('#is_recurring').prop('checked')) {
                            $("#recurring_options").show();
                        } else {
                            $("#recurring_options").hide();
                        }
                        </script>




                    </div>

                    <?php } ?>
                    <div class="d-flex flex-wrap gap-5">
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">

                            <div class="form-check form-check-custom form-check-solid">
                                <?php echo form_checkbox(array(
							'name'=>'disable_from_price_rules',
							'id'=>'disable_from_price_rules',
							'class'=>'delete-checkbox form-check-input',
							'value'=>1,
							'checked'=>$item_info->disable_from_price_rules ? 1 : 0,
						));?>
                                <label class="form-check-label" for="disable_from_price_rules">
                                    <?= lang('disable_from_price_rules');  ?></label>
                            </div>
                        </div>


                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">

                            <div class="form-check form-check-custom form-check-solid">
                                <?php echo form_checkbox(array(
							'name'=>'allow_price_override_regardless_of_permissions',
							'id'=>'allow_price_override_regardless_of_permissions',
							'class'=>'delete-checkbox form-check-input',
							'value'=>1,
							'checked'=>$item_info->allow_price_override_regardless_of_permissions ? 1 : 0,
						));?>
                                <label class="form-check-label"
                                    for="allow_price_override_regardless_of_permissions"><?= lang('allow_price_override_regardless_of_permissions');  ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-5">
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <div class="form-check form-check-custom form-check-solid">
                                <?php echo form_checkbox(array(
							'name'=>'tax_included',
							'id'=>'tax_included',
							'class'=>'delete-checkbox form-check-input',
							'value'=>1,
							'checked'=>$item_info->tax_included ? 1 : 0,
						));?>
                                <label class="form-check-label" for="tax_included"><?= lang('prices_include_tax');  ?>
                                </label>
                            </div>
                        </div>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <div class="form-check form-check-custom form-check-solid">
                                <?php echo form_checkbox(array(
							'name'=>'only_integer',
							'id'=>'only_integer',
							'class'=>'delete-checkbox form-check-input',
							'value'=>1,
							'checked'=>$item_info->only_integer ? 1 : 0,
						));?>
                                <label class="form-check-label" for="only_integer"><?= lang('only_integer');  ?></label>
                            </div>
                        </div>
                    </div>
                    <?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id) or $item_info->name=="") { ?>


                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">


                        <div class="form-check form-check-custom form-check-solid">
                            <?php echo form_checkbox(array(
							'name'=>'change_cost_price',
							'id'=>'change_cost_price',
							'class' => 'delete-checkbox form-check-input',
							'value'=>1,
							'checked'=>(boolean)(($item_info->change_cost_price))));
						?>
                            <label class="form-check-label"
                                for="change_cost_price"><?= lang('change_cost_price_during_sale');  ?></label>
                        </div>
                    </div>
                    <?php } elseif($item_info->change_cost_price) { 
					echo form_hidden('change_cost_price', 1);
				?>

                    <?php } ?>


                    <?php if ($this->config->item('limit_manual_price_adj')) { ?>

                    <div class="d-flex flex-wrap gap-5">
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('min_edit_price').':', 'min_edit_price',array('class'=>'form-label wide')); ?>

                            <div class="input-group">

                                <?php echo form_input(array(
										'type'=> 'number',
										'step'=>"0.01",
										'min'=> '0',
						        'name'=>'min_edit_price',
										'class'=>'form-control',
						        'id'=>'min_edit_price',
						        'value'=> $item_info->min_edit_price ? to_quantity($item_info->min_edit_price) : '')
						    );?>
                                <span class="input-group-text bg"><span
                                        class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>
                            </div>

                        </div>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('max_edit_price').':', 'max_edit_price',array('class'=>'form-label wide')); ?>

                            <div class="input-group">

                                <?php echo form_input(array(
										'type'=> 'number',
										'step'=>"0.01",
										'min'=> '0',
						        'name'=>'max_edit_price',
										'class'=>'form-control',
						        'id'=>'max_edit_price',
						        'value'=> $item_info->max_edit_price ? to_quantity($item_info->max_edit_price) : '')
						    );?>
                                <span class="input-group-text bg"><span
                                        class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                        <?php echo form_label(lang('max_discount_percent').':', 'max_discount_percent',array('class'=>'form-label wide')); ?>

                        <div class="input-group">
                            <?php echo form_input(array(
										'type'=> 'number',
										'min'=> '0',
										'max'=> '100',
						        'name'=>'max_discount_percent',
										'class'=>'form-control',
						        'id'=>'max_discount_percent',
						        'value'=> $item_info->max_discount_percent ? to_quantity($item_info->max_discount_percent) : '')
						    );?>
                            <span class="input-group-text bg"><span class="">%</span></span>
                        </div>
                    </div>

                    <?php } ?>


                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 override-commission-container">

                        <div class="form-check form-check-custom form-check-solid">
                            <?php echo form_checkbox(array(
							'name'=>'override_default_commission',
							'id'=>'override_default_commission',
							'class' => 'override_default_commission delete-checkbox form-check-input',
							'value'=>1,
							'checked'=>(boolean)(($item_info->commission_percent != '') || ($item_info->commission_fixed != ''))));
						?>
                            <label class="form-check-label"
                                for="override_default_commission"><?= lang('override_default_commission'); ?></label>
                        </div>
                    </div>

                    <div
                        class="commission-container <?php if (!($item_info->commission_percent != '') && !($item_info->commission_fixed != '')){echo 'hidden';} ?>">
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                            <?php echo form_label(lang('reports_commission'), 'commission_value',array('class'=>'form-label wide')); ?>
                            <div class='form-check form-check-custom form-check-solid gap-1'>
                                <?php echo form_input(array(
								'name'=>'commission_value',
								'id'=>'commission_value',
								'size'=>'8',
								'class'=>'form-control margin10 form-inps', 
								'value'=> $item_info->commission_fixed != '' ? to_quantity($item_info->commission_fixed, FALSE) : to_quantity($item_info->commission_percent, FALSE))
							);?>

                                <?php echo form_dropdown('commission_type', array('percent' => lang('percentage') , 'fixed' => lang('fixed_amount')), $item_info->commission_fixed != '' ? 'fixed' : 'percent', 'id="commission_type" class="form-control"');?>
                            </div>
                        </div>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5"
                            id="commission-percent-calculation-container">
                            <?php echo form_label(lang('commission_percent_calculation').': ', 'commission_percent_type',array('class'=>'form-label')); ?>

                            <?php echo form_dropdown('commission_percent_type', array(
							'selling_price'  => lang('unit_price'),
							'profit'    => lang('profit'),
							),
							$item_info->commission_percent_type,
							array('id' =>'commission_percent_type' , 'class' => 'form-control'))
							?>
                        </div>
                    </div>

                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 override-taxes-container">
                        <div class="form-check form-check-custom form-check-solid">
                            <?php echo form_checkbox(array(
							'name'=>'override_default_tax',
							'id'=>'override_default_tax',
							'class' => 'override_default_tax_checkbox delete-checkbox form-check-input',
							'value'=>1,
							'checked'=>(boolean)$item_info->override_default_tax));
						?>
                            <label class="form-check-label" for="override_default_tax">
                                <?= lang('override_default_tax'); ?></label>
                        </div>
                    </div>
                    <div class="tax-container main <?php if (!$item_info->override_default_tax){echo 'hidden';} ?>">

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('tax_class').': ', 'tax_class',array('class'=>'form-label')); ?>
                            <div class="form-check form-check-custom form-check-solid">
                                <?php echo form_dropdown('tax_class', $tax_classes, $item_info->tax_class_id, array('id' =>'tax_class','class' => 'form-control tax_class'));?>
                            </div>
                        </div>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <h4 class="text-center"><?php echo lang('or') ?></h4>
                        </div>
                        <div class="d-flex flex-wrap gap-5">
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                <?php echo form_label(lang('tax_1').':', 'tax_percent_1',array('class'=>'form-label wide')); ?>

                                <?php echo form_input(array(
								'name'=>'tax_names[]',
								'id'=>'tax_percent_1',
								'size'=>'8',
								'class'=>'form-control margin10 form-inps',
								'placeholder' => lang('tax_name'),
								'value'=> isset($item_tax_info[0]['name']) ? $item_tax_info[0]['name'] : ($this->Location->get_info_for_key('default_tax_1_name') ? $this->Location->get_info_for_key('default_tax_1_name') : $this->config->item('default_tax_1_name')))
							);?>
                            </div>
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                <label class="form-label wide" for="tax_percent_name_1">
                                    <div class="tax-percent-icon">%</div>
                                </label>

                                <?php echo form_input(array(
								'name'=>'tax_percents[]',
								'id'=>'tax_percent_name_1',
								'size'=>'3',
								'class'=>'form-control form-inps-tax',
								'placeholder' => lang('tax_percent'),
								'value'=> isset($item_tax_info[0]['percent']) ? $item_tax_info[0]['percent'] : '')
							);?>

                                <div class="clear"></div>
                                <?php echo form_hidden('tax_cumulatives[]', '0'); ?>

                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-5">
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                <?php echo form_label(lang('tax_2').':', 'tax_percent_2',array('class'=>'form-label wide')); ?>

                                <?php echo form_input(array(
								'name'=>'tax_names[]',
								'id'=>'tax_percent_2',
								'size'=>'8',
								'class'=>'form-control form-inps margin10',
								'placeholder' => lang('tax_name'),
								'value'=> isset($item_tax_info[1]['name']) ? $item_tax_info[1]['name'] : ($this->Location->get_info_for_key('default_tax_2_name') ? $this->Location->get_info_for_key('default_tax_2_name') : $this->config->item('default_tax_2_name')))
							);?>
                            </div>
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                <label class="form-label  wide">
                                    <div class="tax-percent-icon">%</div>
                                </label>

                                <?php echo form_input(array(
								'name'=>'tax_percents[]',
								'id'=>'tax_percent_name_2',
								'size'=>'3',
								'class'=>'form-control form-inps-tax',
								'placeholder' => lang('tax_percent'),
								'value'=> isset($item_tax_info[1]['percent']) ? $item_tax_info[1]['percent'] : '')
							);?>

                                <div class="clear"></div>
                                <div class="form-check form-check-custom form-check-solid">
                                    <?php echo form_checkbox('tax_cumulatives[]', '1', (isset($item_tax_info[1]['cumulative']) && $item_tax_info[1]['cumulative']) ? (boolean)$item_tax_info[1]['cumulative'] : (boolean)$this->config->item('default_tax_2_cumulative'), 'class="cumulative_checkbox form-check-input" id="tax_cumulatives"'); ?>
                                    <label for="tax_cumulatives" class="form-check-label">
                                        <?php echo lang('cumulative'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5"
                            style="visibility: <?php echo isset($item_tax_info[2]['name']) ? 'hidden' : 'visible';?>">
                            <a href="javascript:void(0);" class="show_more_taxes"><?php echo lang('show_more');?>
                                &raquo;</a>
                        </div>
                        <div class="more_taxes_container w-100"
                            style="display: <?php echo isset($item_tax_info[2]['name']) ? 'block' : 'none';?>">
                            .
                            <div class="d-flex flex-wrap gap-5">
                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                    <?php echo form_label(lang('tax_3').':', 'tax_percent_3',array('class'=>'form-label wide')); ?>

                                    <?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_3',
									'size'=>'8',
									'class'=>'form-control form-inps margin10',
									'placeholder' => lang('tax_name'),
									'value'=> isset($item_tax_info[2]['name']) ? $item_tax_info[2]['name'] : ($this->Location->get_info_for_key('default_tax_3_name') ? $this->Location->get_info_for_key('default_tax_3_name') : $this->config->item('default_tax_3_name')))
								);?>
                                </div>
                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                    <label class="form-label wide">
                                        <div class="tax-percent-icon">%</div>
                                    </label>

                                    <?php echo form_input(array(
									'name'=>'tax_percents[]',
									'id'=>'tax_percent_name_3',
									'size'=>'3',
									'class'=>'form-control form-inps-tax margin10',
									'placeholder' => lang('tax_percent'),
									'value'=> isset($item_tax_info[2]['percent']) ? $item_tax_info[2]['percent'] : '')
								);?>

                                    <div class="clear"></div>
                                    <?php echo form_hidden('tax_cumulatives[]', '0'); ?>


                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-5">
                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                    <?php echo form_label(lang('tax_4').':', 'tax_percent_4',array('class'=>'form-label wide')); ?>

                                    <?php echo form_input(array(
								'name'=>'tax_names[]',
								'id'=>'tax_percent_4',
								'size'=>'8',
								'class'=>'form-control  form-inps margin10',
								'placeholder' => lang('tax_name'),
								'value'=> isset($item_tax_info[3]['name']) ? $item_tax_info[3]['name'] : ($this->Location->get_info_for_key('default_tax_4_name') ? $this->Location->get_info_for_key('default_tax_4_name') : $this->config->item('default_tax_4_name')))
							);?>
                                </div>
                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                    <label class="form-label wide">
                                        <div class="tax-percent-icon">%</div>
                                    </label>
                                    <?php echo form_input(array(
								'name'=>'tax_percents[]',
								'id'=>'tax_percent_name_4',
								'size'=>'3',
								'class'=>'form-control form-inps-tax', 
								'placeholder' => lang('tax_percent'),
								'value'=> isset($item_tax_info[3]['percent']) ? $item_tax_info[3]['percent'] : '')
							);?>

                                    <div class="clear"></div>
                                    <?php echo form_hidden('tax_cumulatives[]', '0'); ?>
                                </div>

                            </div>
                            <div class="d-flex flex-wrap gap-5">
                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                    <?php echo form_label(lang('tax_5').':', 'tax_percent_5',array('class'=>'form-label wide')); ?>

                                    <?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_5',
									'size'=>'8',
									'class'=>'form-control  form-inps margin10',
									'placeholder' => lang('tax_name'),
									'value'=> isset($item_tax_info[4]['name']) ? $item_tax_info[4]['name'] : ($this->Location->get_info_for_key('default_tax_5_name') ? $this->Location->get_info_for_key('default_tax_5_name') : $this->config->item('default_tax_5_name')))
								);?>
                                </div>
                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                                    <label class="form-label wide">
                                        <div class="tax-percent-icon">%</div>
                                    </label>

                                    <?php echo form_input(array(
									'name'=>'tax_percents[]',
									'id'=>'tax_percent_name_5',
									'size'=>'3',
									'class'=>'form-control form-inps-tax margin10',
									'placeholder' => lang('tax_percent'),
									'value'=> isset($item_tax_info[4]['percent']) ? $item_tax_info[4]['percent'] : '')
								);?>

                                    <div class="clear"></div>
                                    <?php echo form_hidden('tax_cumulatives[]', '0'); ?>
                                </div>
                            </div>
                        </div>
                        <!--End more Taxes Container-->
                        <div class="clear"></div>
                    </div>
                </div><!-- /card-body-->
            </div>
            <!--/card-piluku-->
        </div>
        <?php if($secondary_suppliers = $this->Item->get_secondary_suppliers($item_info->item_id)->result()) { ?>
        <div class="col-md-12 mt-5">
            <div class="card shadow-sm">
                <div
                    class="card-heading rounded rounded-3 p-5  rounded border-primary border border-dashed rounded-3pricing-widget">
                    <h3 class="card-title">
                        <?php echo lang("pricing_for_secondary_suppliers"); ?>
                       
                    </h3>
                </div>

                <div class="card-body">
                    <?php foreach($secondary_suppliers as $sec_supplier){?>
                    <?php if ($progression || $this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                        <?php echo form_label(lang('cost_price').' '.lang('for').' '.$suppliers[$sec_supplier->supplier_id].' ('.lang('without_tax').')'.':', 'cost_price_'.$sec_supplier->id, array('class'=>'form-label required wide')); ?>
                        
                            <div class="input-group">
                               
                                <?php echo form_input(array(
									'name'=>'secondary_supplier_cost_price['.$sec_supplier->id.']',
									'size'=>'8',
									'id'=>'cost_price_'.$sec_supplier->id,
									'class'=>'form-control form-inps',
									'value'=>$sec_supplier->cost_price ? to_currency_no_money($sec_supplier->cost_price,10) : '')
								);?>
								 <span class="input-group-text bg"><span
                                        class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>
                            </div>
                    </div>
                    <?php  
					} else {
						echo form_hidden('secondary_supplier_cost_price['.$sec_supplier->id.']', $sec_supplier->cost_price);
					}
					?>
                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                        <?php echo form_label(lang('unit_price').' '.lang('for').' '.$suppliers[$sec_supplier->supplier_id].':', 'unit_price_'.$sec_supplier->id, array('class'=>'form-label required wide')); ?>
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <div class="input-group">
                                
                                <?php echo form_input(array(
									'name'=>'secondary_supplier_unit_price['.$sec_supplier->id.']',
									'size'=>'8',
									'id'=>'unit_price_'.$sec_supplier->id,
									'class'=>'form-control form-inps',
									'value'=>$sec_supplier->unit_price ? to_currency_no_money($sec_supplier->unit_price,10) : '')
								);?>
								<span class="input-group-text bg"><span
                                        class=""><?php echo $this->config->item("currency_symbol") ? $this->config->item("currency_symbol") : '$';?></span></span>
                            </div>
                        </div>
                    </div>
                    <?php
				} 
				?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div><!-- /row -->

    <?php echo form_hidden('redirect', isset($redirect) ? $redirect : ''); ?>
    <?php echo form_hidden('progression', isset($progression) ? $progression : ''); ?>
    <?php echo form_hidden('quick_edit', isset($quick_edit) ? $quick_edit : ''); ?>

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

    <?php  echo form_close(); ?>
</div>

</div>
<script type='text/javascript'>
<?php $this->load->view("partial/common_js"); ?>

function commission_change() {
    if ($("#commission_type").val() == 'percent') {
        $("#commission-percent-calculation-container").show();
    } else {
        $("#commission-percent-calculation-container").hide();
    }
}

$("#commission_type").change(commission_change);

$(document).ready(commission_change);

function get_taxes() {
    var taxes = [];

    if (!$("#override_default_tax").prop('checked')) {
        var default_taxes = <?php echo json_encode($this->Item_taxes_finder->get_info($item_info->item_id)) ?>;

        for (var k = 0; k < default_taxes.length; k++) {
            taxes.push({
                'percent': parseFloat(default_taxes[k]['percent']),
                'cumulative': default_taxes[k]['cumulative'] == 1
            });
        }
    } else {
        var k = 0;

        $('.tax-container.main input[name="tax_percents[]"]').each(function() {
            if ($(this).val()) {
                taxes.push({
                    'percent': parseFloat($(this).val()),
                    'cumulative': k == 1 && $("#tax_cumulatives").prop('checked')
                });
            }

            k++;
        });
    }
    return taxes;

}

function get_total_tax_percent() {
    var total_tax_percent = 0;
    var taxes = get_taxes();
    for (var k = 0; k < taxes.length; k++) {
        total_tax_percent += parseFloat(taxes[k]['percent']);
    }

    return total_tax_percent;
}

function are_taxes_cumulative() {
    var taxes = get_taxes();

    return (taxes.length == 2 && taxes[1].cumulative);
}

function calculate_markup_percent() {
    if ($("#tax_included").prop('checked')) {
        var cost_price = parseFloat($('#cost_price').val());
        var unit_price = parseFloat($('#unit_price').val());

        var cumulative = are_taxes_cumulative();

        if (!cumulative) {
            //Markup amount
            //(100*.1)
            //100 + (100*.1) = 118.80 * .08 

            //cost price 100.00
            //8% tax
            //Markup 10%
            //110.00 before tax
            //selling price 118.80
            //100 * 1.1 = profit 10%	


            // X = COST PRICE
            // Y = MARKUP PERCENT
            // Z = SELLING PRICE
            // Q = TAX PERCENT
            //100 * (1+ (10/100)) = 118.80 - (100 * (1+ (10/100)) * 8/100);

            //X * (1+Y/100) = Z - (X * (1+(Y/100)) * Q/100)
            //Y = -(100 ((Q+100) X-100 Z))/((Q+100) X) and (Q+100) X!=0

            var tax_percent = parseFloat(get_total_tax_percent());

            var Z = unit_price;
            var X = cost_price;
            var Q = tax_percent;
            var markup_percent = -(100 * ((Q + 100) * X - 100 * Z)) / ((Q + 100) * X);
        } else {
            var taxes = get_taxes();
            var tax_1 = 1 + (taxes[0]['percent'] / 100);
            var tax_2 = 1 + (taxes[1]['percent'] / 100);
            markup_percent = (unit_price / (cost_price * tax_1 * tax_2) - 1) * 100;
        }

    } else {
        var cost_price = parseFloat($('#cost_price').val());
        var unit_price = parseFloat($('#unit_price').val());
        var markup_percent = -100 + (100 * (unit_price / cost_price));
    }

    markup_percent = parseFloat(Math.round(markup_percent * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);

    $('#markup').val(markup_percent);
}

function calculate_markup_price() {
    if ($("#tax_included").prop('checked')) {
        var cost_price = parseFloat($('#cost_price').val());
        var markup_percent = parseFloat($("#markup").val());

        var cumulative = are_taxes_cumulative();

        if (!cumulative) {
            //markup amount
            //(100*.1)
            //100 + (100*.1) = 118.80 * .08 

            //cost price 100.00
            //8% tax
            //markup 10%
            //110.00 before tax
            //selling price 118.80
            //100 * 1.1 = profit 10%	


            // X = COST PRICE
            // Y = MARKUP PERCENT
            // Z = SELLING PRICE
            // Q = TAX PERCENT
            //100 * (1+ (10/100)) = 118.80 - (100 * (1+ (10/100)) * 8/100);

            //X * (1+Y/100) = Z - (X * (1+(Y/100)) * Q/100)
            //Z = (Q X Y+100 Q X+100 X Y+10000 X)/10000

            var tax_percent = get_total_tax_percent();

            var X = cost_price;
            var Y = markup_percent;
            var Q = tax_percent;

            var markup_price = (Q * X * Y + 100 * Q * X + 100 * X * Y + 10000 * X) / 10000;
        } else {
            var marked_up_price_before_tax = cost_price * (1 + (markup_percent / 100));

            var taxes = get_taxes();
            var cumulative_tax_percent = taxes[1]['percent'];

            var first_tax = (marked_up_price_before_tax * (taxes[0]['percent'] / 100));
            var second_tax = (marked_up_price_before_tax + first_tax) * (taxes[1]['percent'] / 100);
            var markup_price = marked_up_price_before_tax + first_tax + second_tax;
        }

        markup_price = parseFloat(Math.round(markup_price * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);
    } else {
        var cost_price = parseFloat($('#cost_price').val());
        var markup_percent = parseFloat($("#markup").val());

        var markup_price = cost_price + (cost_price / 100 * (markup_percent));
        markup_price = parseFloat(Math.round(markup_price * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);

    }

    $('#unit_price').val(markup_price);
}

<?php if ($this->config->item('enable_markup_calculator')) { ?>

if ($('#unit_price').val() && $('#cost_price').val()) {
    calculate_markup_percent();
}

$('#markup, #cost_price,.tax-container.main input[name="tax_percents[]"]').keyup(function() {
    if ($("#markup").val() != '') {
        calculate_markup_price();
    }
});

<?php } ?>

function calculate_margin_percent() {
    if ($("#tax_included").prop('checked')) {
        var cost_price = parseFloat($('#cost_price').val());
        var unit_price = parseFloat($('#unit_price').val());

        var cumulative = are_taxes_cumulative();

        if (!cumulative) {
            var tax_percent = parseFloat(get_total_tax_percent());
            var cost_price_inc_tax = cost_price * (1 + (tax_percent / 100));
            var margin_percent = (100 * (unit_price - cost_price_inc_tax)) / unit_price;
        } else {
            var taxes = get_taxes();
            var first_tax = (cost_price * (taxes[0]['percent'] / 100));
            var second_tax = (cost_price + first_tax) * (taxes[1]['percent'] / 100);
            var cost_price_inc_tax = cost_price + first_tax + second_tax;
            //TODO this is wrong
            var margin_percent = ((unit_price - cost_price_inc_tax) / unit_price) * 100
        }
    } else {
        var cost_price = parseFloat($('#cost_price').val());
        var unit_price = parseFloat($('#unit_price').val());
        var margin_percent = ((unit_price - cost_price) / unit_price) * 100;
    }

    margin_percent = parseFloat(Math.round(margin_percent * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);
    $('#margin').val(margin_percent);
}

function calculate_margin_price() {
    if ($("#tax_included").prop('checked')) {
        var cost_price = parseFloat($('#cost_price').val());
        var margin_percent = parseFloat($("#margin").val());

        var cumulative = are_taxes_cumulative();

        if (!cumulative) {
            var tax_percent = get_total_tax_percent();

            var X = cost_price * (1 + (tax_percent / 100));
            var Y = margin_percent;

            var margin_price = -1 * ((100 * X) / (Y - 100));
        } else {
            var marked_up_price_before_tax = cost_price * (1 + (margin_percent / 100));

            var taxes = get_taxes();

            var first_tax = (marked_up_price_before_tax * (taxes[0]['percent'] / 100));
            var second_tax = (marked_up_price_before_tax + first_tax) * (taxes[1]['percent'] / 100);

            var X = cost_price + first_tax + second_tax;
            var Y = margin_percent;

            var margin_price = -1 * ((100 * X) / (Y - 100));
        }

        margin_price = parseFloat(Math.round(margin_price * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);
    } else {
        var cost_price = parseFloat($('#cost_price').val());
        var margin_percent = parseFloat($("#margin").val());

        var margin_price = -1 * ((100 * cost_price) / (margin_percent - 100));
        margin_price = parseFloat(Math.round(margin_price * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);

    }

    $('#unit_price').val(margin_price);
}

<?php if ($this->config->item('enable_margin_calculator')) { ?>

if ($('#unit_price').val() && $('#cost_price').val()) {
    calculate_margin_percent();
}

$('#margin, #cost_price,.tax-container.main input[name="tax_percents[]"]').keyup(function() {
    if ($("#margin").val() != '') {
        calculate_margin_price();
    }
});

<?php } ?>


date_time_picker_field($('.datepicker'), JS_DATE_FORMAT);

$(".override_default_tax_checkbox, .override_prices_checkbox, .override_default_commission").change(function() {
    $(this).parent().parent().next().toggleClass('hidden')
});

$(".tier_dropdown").on('change', function() {
    if ($(this).val() == 'percent_off' || $(this).val() == 'cost_plus_percent') {
        $(this).siblings('.input-group-addon').find('.percent').toggleClass('hidden', false);
        $(this).siblings('.input-group-addon').find('.flat').toggleClass('hidden', true);
    } else {
        $(this).siblings('.input-group-addon').find('.percent').toggleClass('hidden', true);
        $(this).siblings('.input-group-addon').find('.flat').toggleClass('hidden', false);
    }
});

$('#item_form').validate({
    ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
    errorClass: "text-danger",
    errorElement: "span",
    highlight: function(element, errorClass, validClass) {
        $(element).parents('.fv-row w-100 flex-md-root fv-plugins-icon-container my-5').removeClass(
            'has-success').addClass('has-error');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).parents('.fv-row w-100 flex-md-root fv-plugins-icon-container my-5').removeClass(
            'has-error').addClass('has-success');
    },
    rules: {
        <?php foreach($tiers as $tier) { ?> "<?php echo 'item_tier['.$tier->id.']'; ?>": {
            number: true
        },
        <?php } ?>
        cost_price: {
            required: true,
            number: true
        },

        unit_price: {
            required: true,
            number: true
        },
        promo_price: {
            number: true
        },
    },
    submitHandler: function(form) {
        var args = {
            next: {
                label: <?php echo json_encode(lang('edit').' '.lang('inventory')) ?>,
                url: <?php echo json_encode(site_url("items/inventory/".($item_info->item_id ? $item_info->item_id : -1)."?$query")); ?>
            }
        };

        doItemSubmit(form, args);
    }

});
</script>
<?php $this->load->view('partial/footer'); ?>