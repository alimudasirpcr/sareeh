<?php $this->load->view("partial/header"); ?>

<div class="row" id="form">
    <div class="spinner" id="grid-loader" style="display:none">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
    </div>

    <div class="col-md-12">

        <?php if($person_info->person_id)  { ?>
        <div class="card">
            <div class="card-body">
                <div class="user-badge">
                    <?php echo $person_info->image_id ? '<div class="user-badge-avatar">'.img(array('src' => cacheable_app_file_url($person_info->image_id),'class'=>'img-polaroid img-polaroid-s')).'</div>' : '<div class="user-badge-avatar">'.img(array('src' => base_url('assets/assets/images/avatar-default.jpg'),'class'=>'img-polaroid','id'=>'image_empty')).'</div>'; ?>
                    <div class="user-badge-details text-success">

                        <?php echo H($person_info->first_name.' '.$person_info->last_name); ?>
                        <?php if($this->config->item('customers_store_accounts')) { ?>
                        <div class="amount text-info">
                            <?php echo lang('store_account_balance').': '; ?>
                            <?php echo $person_info->balance ? to_currency($person_info->balance) : '0.00'; ?>
                        </div>
                        <?php } ?>
                        <?php
								if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'simple')
								{
								?>
                        <div class="amount text-secondary">
                            <?php echo lang('sales_until_discount').': '; ?>
                            <?php 
								   $sales_until_discount = $this->config->item('number_of_sales_for_discount') - $person_info->current_sales_for_discount;
									
									echo to_quantity($sales_until_discount); ?>
                        </div>

                        <?php
								}
								?>

                        <?php
								if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced')
								{
						        	 list($spend_amount_for_points, $points_to_earn) = explode(":",$this->config->item('spend_to_point_ratio'),2);
							 		$spend_amount_for_points = (float)$spend_amount_for_points;
							 		$points_to_earn = (float)$points_to_earn;
									
								?>
                        <div class="amount">
                            <?php echo lang('points').': '; ?>
                            <?php echo to_quantity($person_info->points); ?>
                        </div>

                        <div class="amount">
                            <?php echo lang('customers_amount_to_spend_for_next_point').': '; ?>
                            <?php echo to_currency($spend_amount_for_points - $person_info->current_spend_for_points); ?>
                        </div>

                        <?php
								}
								?>
                    </div>
                    <ul class="list-inline pull-right">
                        <?php
								$one_year_ago = date('Y-m-d', strtotime('-1 year'));
								$today = date('Y-m-d').'%2023:59:59';	
							?>

                        <li><a target="_blank"
                                href="<?php echo site_url('reports/generate/specific_customer?report_type=complex&start_date='.$one_year_ago.'&start_date_formatted='.date(get_date_format().' '.get_time_format(), strtotime($one_year_ago)).'&end_date='.$today.'&end_date_formatted='.date(get_date_format().' '.get_time_format(), strtotime(date('Y-m-d').' 23:59:59')).'&customer_id='.$person_info->person_id.'&sale_type=all&export_excel=0'); ?>"
                                class="btn btn-success"><?php echo lang('view_report'); ?></a></li>

                        <?php if($this->config->item('customers_store_accounts')) { ?>
                        <li><?php echo anchor($controller_name."/pay_now/$person_info->person_id",lang('pay'),array('title'=>lang('pay'),'class'=>'btn btn-primary ')); ?>
                        </li>
                        <?php } ?>
                        <?php if ($person_info->email) { ?>
                        <li><a href="mailto:<?php echo H($person_info->email); ?>"
                                class="btn btn-primary"><?php echo lang('send_email'); ?></a></li>
                        <?php } ?>
                    </ul>
                    <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-success translate rounded"></span>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php echo form_open_multipart('customers/save/'.$person_info->person_id,array('id'=>'customer_form','class'=>'form-horizontal')); 	?>

        <div class="card shadow-sm mt-5">
            <div class="card-header rounded rounded-3 p-5">
                <h3 class="card-title">
                    <i class="ion-edit"></i>
                    <?php echo lang("customers_basic_information"); ?>
                    <small>(<?php echo lang('fields_required_message'); ?>)</small>
                </h3>
            </div>

            <div class="card-body">


                <?php $this->load->view("people/form_basic_info"); ?>


                <div class="row">
                    <div class="col-md-6">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check">

                                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('internal_notes'))?></label>

                                        <?php echo form_textarea(array(
						'name'=>'internal_notes',
						'id'=>'internal_notes',
						'class'=>'form-control form-control-solid text-area',
						'value'=>$person_info->internal_notes,
						'rows'=>'5',
						'cols'=>'17')		
					);?>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check">

                                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('invoices_terms'))?></label>

                                        <?php
			
			echo form_dropdown('default_term_id', $terms, $person_info->default_term_id, 'class="form-select form-select-solid input_radius" id="section_names"');

			?>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <?php					
				if($this->config->item('customers_store_accounts') && $this->Employee->has_module_action_permission('customers', 'edit_store_account_balance', $this->Employee->get_logged_in_employee_info()->person_id)) 
				{
				?>
                    <div class="col-md-6">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check">

                                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('store_account_balance'))?></label>

                                        <?php echo form_input(array(
							'name'=>'balance',
							'id'=>'balance',
							'class'=>'form-control balance',
							'value'=>$person_info->balance ? to_currency_no_money($person_info->balance) : '0.00')
							);?>
                                    </div>
                                    <div class="form-check">

                                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('credit_limit'))?></label>

                                        <?php echo form_input(array(
							'name'=>'credit_limit',
							'id'=>'credit_limit',
							'class'=>'form-control credit_limit',
							'value'=>$person_info->person_id ? ($person_info->credit_limit ? to_currency_no_money($person_info->credit_limit) : '') : ($this->config->item('default_credit_limit') ? to_currency_no_money($this->config->item('default_credit_limit')): ''))
							);?>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
				}
				elseif($this->config->item('customers_store_accounts'))
				{
					echo form_hidden('credit_limit', $person_info->person_id ? ($person_info->credit_limit ? to_currency_no_money($person_info->credit_limit) : '') : ($this->config->item('default_credit_limit') ? to_currency_no_money($this->config->item('default_credit_limit')): ''));
				?>

                    <div class="col-md-6">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check">

                                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('credit_limit'))?></label>
                                        <h5><?php echo $person_info->balance ? to_currency($person_info->balance) : to_currency(0); ?>
                                    </div>
                                    <div class="form-check">

                                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('credit_limit'))?></label>

                                        <h5><?php echo $person_info->credit_limit ? to_currency($person_info->credit_limit) : lang('none'); ?>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
				}
				?>
                </div>




                <?php if ($this->config->item('enable_customer_loyalty_system'))
				{
				?>
                <div class="form-group">
                    <?php echo form_label(lang('customers_disable_loyalty').':', 'disable_loyalty',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_checkbox('disable_loyalty', '1', $person_info->disable_loyalty == '' ? ($this->config->item('disable_loyalty_by_default') ? TRUE : FALSE) : (boolean)$person_info->disable_loyalty,'id="disable_loyalty"');?>
                        <label for="disable_loyalty"><span></span></label>
                    </div>
                </div>
                <?php
				}
				
				if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'simple')
				{
				   $sales_until_discount = $this->config->item('number_of_sales_for_discount') - $person_info->current_sales_for_discount;
				
					if ($this->Employee->has_module_action_permission('customers', 'edit_customer_points', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
                <div class="form-group quantity-input">
                    <?php echo form_label(lang('sales_until_discount').':', '', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-12">
                        <?php echo form_input(array(
									'name'=>'sales_until_discount',
									'id'=>'sales_until_discount',
									'class'=>'form-control sales_until_discount',
									'value'=>to_quantity($sales_until_discount))
									);?>
                    </div>
                </div>

                <?php
					}
					else
					{
					?>
                <div class="form-group quantity-input">
                    <?php echo form_label(lang('sales_until_discount').':', '', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <h5><?php echo to_quantity($sales_until_discount); ?></h5>
                    </div>
                </div>
                <?php 
						echo form_hidden('sales_until_discount', $sales_until_discount);
						?>
                <?php
					}
				}
				
				if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced')
				{
		         	list($spend_amount_for_points, $points_to_earn) = explode(":",$this->config->item('spend_to_point_ratio'),2);
					$spend_amount_for_points = (float)$spend_amount_for_points;
					$points_to_earn = (float)$points_to_earn;
					
					if ($this->Employee->has_module_action_permission('customers', 'edit_customer_points', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
                <div class="form-group quantity-input">
                    <?php echo form_label(lang('customers_amount_to_spend_for_next_point').':', '', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-12">
                        <?php echo form_input(array(
									'name'=>'amount_to_spend_for_next_point',
                                    'type' => 'number',
									'id'=>'amount_to_spend_for_next_point',
									'class'=>'form-control amount_to_spend_for_next_point',
									'value'=>to_currency_no_money((float)$spend_amount_for_points - (float)$person_info->current_spend_for_points))
									);?>
                    </div>
                </div>

                <?php
					}
					else
					{
					?>
                <div class="form-group quantity-input">
                    <?php echo form_label(lang('customers_amount_to_spend_for_next_point').':', '', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <h5><?php echo to_currency((float)$spend_amount_for_points - (float)$person_info->current_spend_for_points); ?>
                        </h5>
                    </div>
                </div>
                <?php 
						echo form_hidden('amount_to_spend_for_next_point', to_currency_no_money($spend_amount_for_points - $person_info->current_spend_for_points));
						?>
                <?php
					}
				}
				?>

                <?php					
				if($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced' && $this->Employee->has_module_action_permission('customers', 'edit_customer_points', $this->Employee->get_logged_in_employee_info()->person_id)) 
				{
				?>

                <div class="form-group">
                    <?php echo form_label(lang('points').':', 'points',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-12">
                        <?php echo form_input(array(
							'name'=>'points',
							'id'=>'points',
							'class'=>'form-control points',
							'value'=>$person_info->points ? to_currency_no_money($person_info->points) : '0.00')
							);?>
                    </div>
                </div>


                <?php
				}
				?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check">

                                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('company'))?></label>

                                        <?php echo form_input(array(
							'name'=>'company_name',
							'id'=>'company_name',
							'class'=>'company_names form-control form-control-solid',
							'value'=>$person_info->company_name)
							);?>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check">

                                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('customers_account_number'))?></label>

                                        <?php echo form_input(array(
								'name'=>'account_number',
								'id'=>'account_number',
								'class'=>'company_names form-control form-control-solid',
								'value'=>$person_info->account_number)
								);?>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>




                <div class="form-group override-taxes-container">



                    <?php echo form_label(lang('customers_override_default_tax_for_sale').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_checkbox(array(
											'name'=>'override_default_tax',
											'id'=>'override_default_tax',
											'class' => 'override_default_tax_checkbox delete-checkbox form-check-input',
											'value'=>1,
											'checked'=>(boolean)$person_info->override_default_tax));
										?>
                        <label for="override_default_tax"><span></span></label>
                    </div>
                </div>

                <div class="tax-container main <?php if (!$person_info->override_default_tax){echo 'hidden';} ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check">

                                            <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('tax_class'))?></label>

                                            <?php echo form_dropdown('tax_class',  $tax_classes, $person_info->tax_class_id, array('id' =>'tax_class','class' => 'form-select form-select-solid tax_class'));?>

                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>

                       
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check">

                                            <label class="form-check-label" for="flexCheckDefault"> <?php 
						
										echo form_label(lang('tax_2'))?></label>

                                            <?php echo form_input(array(
												'name'=>'tax_names[]',
												'id'=>'tax_percent_2',
												'size'=>'8',
												'class'=>'form-control form-control-solid form-inps margin10',
												'placeholder' => lang('tax_name'),
												'value'=> isset($customer_tax_info[1]['name']) ? $customer_tax_info[1]['name'] : ($this->Location->get_info_for_key('default_tax_2_name') ? $this->Location->get_info_for_key('default_tax_2_name') : $this->config->item('default_tax_2_name')))
											);?>
                                            <?php echo form_input(array(
												'name'=>'tax_percents[]',
												'id'=>'tax_percent_name_2',
												'style' => 'margin-top: 7px;',
												'size'=>'3',
												'class'=>'form-control form-control-solid form-inps-tax',
												'placeholder' => lang('tax_percent'),
												'value'=> isset($customer_tax_info[1]['percent']) ? $customer_tax_info[1]['percent'] : '')
											);?>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check">

                                            <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('tax_1'))?></label>

                                            <?php echo form_input(array(
												'name'=>'tax_names[]',
												'id'=>'tax_percent_1',
												'size'=>'8',
												'class'=>'form-control form-control-solid margin10 form-inps',
												'placeholder' => lang('tax_name'),
												'value'=> isset($customer_tax_info[0]['name']) ? $customer_tax_info[0]['name'] : ($this->Location->get_info_for_key('default_tax_1_name') ? $this->Location->get_info_for_key('default_tax_1_name') : $this->config->item('default_tax_1_name')))
											);?>
                                            <?php echo form_input(array(
												'name'=>'tax_percents[]',
												'id'=>'tax_percent_name_1',
												'style' => 'margin-top: 7px;',
												'size'=>'3',
												'class'=>'form-control form-control-solid form-inps-tax',
												'placeholder' => lang('tax_percent'),
												'value'=> isset($customer_tax_info[0]['percent']) ? $customer_tax_info[0]['percent'] : '')
											);?>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-9 col-lg-offset-3 "
                        style="visibility: <?php echo isset($customer_tax_info[2]['name']) ? 'hidden' : 'visible';?>">
                        <a href="javascript:void(0);" class="show_more_taxes"><?php echo lang('show_more');?>
                            &raquo;</a>
                    </div>







                    <div class="more_taxes_container"
                        style="display: <?php echo isset($customer_tax_info[2]['name']) ? 'block' : 'none';?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="py-5 mb-5">
                                    <div class="rounded border p-10">
                                        <div class="mb-10">
                                            <div class="form-check">

                                                <label class="form-check-label" for="flexCheckDefault"> <?php 
						
										echo form_label(lang('tax_3'))?></label>

                                                <?php echo form_input(array(
													'name'=>'tax_names[]',
													'id'=>'tax_percent_3',
													'size'=>'8',
													'class'=>'form-control form-control-solid  form-inps margin10',
													'placeholder' => lang('tax_name'),
													'value'=> isset($customer_tax_info[2]['name']) ? $customer_tax_info[2]['name'] : ($this->Location->get_info_for_key('default_tax_3_name') ? $this->Location->get_info_for_key('default_tax_3_name') : $this->config->item('default_tax_3_name')))
												);?>


                                                <?php echo form_input(array(
													'name'=>'tax_percents[]',
													'id'=>'tax_percent_name_3',
													'size'=>'3',
												'style' => 'margin-top: 7px;',

												'class'=>'form-control form-control-solid form-inps-tax',

													'placeholder' => lang('tax_percent'),
													'value'=> isset($customer_tax_info[2]['percent']) ? $customer_tax_info[2]['percent'] : '')
												);?>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="py-5 mb-5">
                                    <div class="rounded border p-10">
                                        <div class="mb-10">
                                            <div class="form-check">

                                                <label class="form-check-label" for="flexCheckDefault"> <?php 
						
										echo form_label(lang('tax_4'))?></label>

                                                <?php echo form_input(array(
												'name'=>'tax_names[]',
												'id'=>'tax_percent_4',
												'size'=>'8',
												'class'=>'form-control form-control-solid  form-inps margin10',
												'placeholder' => lang('tax_name'),
												'value'=> isset($customer_tax_info[3]['name']) ? $customer_tax_info[3]['name'] : ($this->Location->get_info_for_key('default_tax_4_name') ? $this->Location->get_info_for_key('default_tax_4_name') : $this->config->item('default_tax_4_name')))
											);?>




                                                <?php echo form_input(array(
												'name'=>'tax_percents[]',
												'id'=>'tax_percent_name_4',
												'size'=>'3',
												'style' => 'margin-top: 7px;',

												'class'=>'form-control form-control-solid form-inps-tax',
												'placeholder' => lang('tax_percent'),
												'value'=> isset($customer_tax_info[3]['percent']) ? $customer_tax_info[3]['percent'] : '')
											);?>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="py-5 mb-5">
                                    <div class="rounded border p-10">
                                        <div class="mb-10">
                                            <div class="form-check">

                                                <label class="form-check-label" for="flexCheckDefault"> <?php 
						
										echo form_label(lang('tax_5'))?></label>

                                                <?php echo form_input(array(
													'name'=>'tax_names[]',
													'id'=>'tax_percent_5',
													'size'=>'8',
													'class'=>'form-control form-control-solid  form-inps margin10',
													'placeholder' => lang('tax_name'),
													'value'=> isset($customer_tax_info[4]['name']) ? $customer_tax_info[4]['name'] : ($this->Location->get_info_for_key('default_tax_5_name') ? $this->Location->get_info_for_key('default_tax_5_name') : $this->config->item('default_tax_5_name')))
												);?>





                                                <?php echo form_input(array(
													'name'=>'tax_percents[]',
													'id'=>'tax_percent_name_5',
													'size'=>'3',
													'style' => 'margin-top: 7px;',

												'class'=>'form-control form-control-solid form-inps-tax',
													'placeholder' => lang('tax_percent'),
													'value'=> isset($customer_tax_info[4]['percent']) ? $customer_tax_info[4]['percent'] : '')
												);?>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>
                    <!--End more Taxes Container-->
                    <div class="clear"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check">



                                        <?php echo form_checkbox('taxable', '1', $person_info->taxable == '' ? TRUE : (boolean)$person_info->taxable,'id="taxable" , class="form-check-input"');?>
                                        <label  class="form-check-label ml-0" for="flexCheckDefault"> <?php 
						
						echo lang('taxable')?></label>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="form-group" id="tax_certificate_holder" style="display: none;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-5 mb-5">
                                <div class="rounded border p-10">
                                    <div class="mb-10">
                                        <div class="form-check">

                                            <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						                    echo form_label(lang('customers_tax_certificate'))?></label>
                                            <?php echo form_input(array(
                                            'name'=>'tax_certificate',
                                            'id'=>'tax_certificate',
                                            'class'=>'company_names form-control form-control-solid',
                                            'value'=>$person_info->tax_certificate)
                                            );?>

                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group zatca_buyer_info" style="display: none;">
							<?php echo form_label(lang('customer_saudi_tax_buyer_tax_id').' (ZATCA)'.':', 'zatca_buyer_tax_id', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(
									array(
										'name'=>'zatca_buyer_tax_id',
										'id'=>'zatca_buyer_tax_id',
										'class'=>'form-control',
										'value'=>isset($customer_zatca_data['buyer_tax_id'])?$customer_zatca_data['buyer_tax_id']:""
									)
								);
								?>
							</div>
						</div>
						<div class="form-group zatca_buyer_info" style="display: none;">
							<?php echo form_label(lang('customer_saudi_tax_buyer_id').' '. '(ZATCA)'.':', 'zatca_buyer_id', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(
									array(
										'name'=>'zatca_buyer_id',
										'id'=>'zatca_buyer_id',
										'class'=>'form-control',
										'value'=>isset($customer_zatca_data['buyer_id'])?$customer_zatca_data['buyer_id']:""
									)
								);
								?>
							</div>
						</div>
						<div class="form-group zatca_buyer_info" style="display: none;">
							<?php echo form_label(lang('customer_saudi_tax_buyer_scheme_id').' (ZATCA)'.':', 'zatca_buyer_scheme_id', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_dropdown('zatca_buyer_scheme_id',
									array(
										''=>'Please select scheme ID',
										'CRN'=>'CRN(Commercial Registration BN)',
										'TIN'=>'TIN(Tax Identification Number)',
										'MOM'=>'MOM(Momra license)',
										'MLS'=>"MLS(MLSD license)",
										'700'=>"700(700 Number)",
										'SAG'=>"SAG(Sagia license)",
										'NAT'=>"NAT(National ID)",
										'GCC'=>"GCC(GCC ID)",
										'OTH'=>"OTH(Other ID)",
									),
									isset($customer_zatca_data['buyer_scheme_id'])?$customer_zatca_data['buyer_scheme_id']:"",
									'class="form-control" id="zatca_buyer_scheme_id"'
								);
								?>
							</div>
						</div>
						<div class="form-group zatca_buyer_info" style="display: none;">
							<?php echo form_label( lang('customer_saudi_tax_street_name').' (ZATCA)'.':', 'zatca_buyer_party_postal_street_name', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(
									array(
										'name'=>'zatca_buyer_party_postal_street_name',
										'id'=>'zatca_buyer_party_postal_street_name',
										'class'=>'form-control',
										'value'=>isset($customer_zatca_data['buyer_party_postal_street_name'])?$customer_zatca_data['buyer_party_postal_street_name']:""
									)
								);
								?>
							</div>
						</div>
						<div class="form-group zatca_buyer_info" style="display: none;">	
							<?php echo form_label( lang('customer_saudi_tax_building_number') . ' (ZATCA)'.':', 'zatca_buyer_party_postal_building_number', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(
									array(
										'name'=>'zatca_buyer_party_postal_building_number',
										'id'=>'zatca_buyer_party_postal_building_number',
										'class'=>'form-control',
										'value'=>isset($customer_zatca_data['buyer_party_postal_building_number'])?$customer_zatca_data['buyer_party_postal_building_number']:""
									)
								);
								?>
							</div>
						</div>
						<div class="form-group zatca_buyer_info" style="display: none;">	
							<?php echo form_label( lang('customer_saudi_tax_postal_code'). ' (ZATCA)'.':', 'zatca_buyer_party_postal_code', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(
									array(
										'name'=>'zatca_buyer_party_postal_code',
										'id'=>'zatca_buyer_party_postal_code',
										'class'=>'form-control',
										'value'=>isset($customer_zatca_data['buyer_party_postal_code'])?$customer_zatca_data['buyer_party_postal_code']:""
									)
								);
								?>
							</div>
						</div>
						<div class="form-group zatca_buyer_info" style="display: none;">
							<?php echo form_label( lang('customer_saudi_tax_city_name'). ' (ZATCA)'.':', 'zatca_buyer_party_postal_city', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(
									array(
										'name'=>'zatca_buyer_party_postal_city',
										'id'=>'zatca_buyer_party_postal_city',
										'class'=>'form-control',
										'value'=>isset($customer_zatca_data['buyer_party_postal_city'])?$customer_zatca_data['buyer_party_postal_city']:""
									)
								);
								?>
							</div>
						</div>
						<div class="form-group zatca_buyer_info" style="display: none;">	
							<?php echo form_label( lang('customer_saudi_tax_district_name') . ' (ZATCA)'.':', 'zatca_buyer_party_postal_district', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(
									array(
										'name'=>'zatca_buyer_party_postal_district',
										'id'=>'zatca_buyer_party_postal_district',
										'class'=>'form-control',
										'value'=>isset($customer_zatca_data['buyer_party_postal_district'])?$customer_zatca_data['buyer_party_postal_district']:""
									)
								);
								?>
							</div>
						</div>
						<div class="form-group zatca_buyer_info" style="display: none;">
							<?php echo form_label( lang('customer_saudi_tax_plot').' (ZATCA)'.':', 'zatca_buyer_party_postal_plot_id', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(
									array(
										'name'=>'zatca_buyer_party_postal_plot_id',
										'id'=>'zatca_buyer_party_postal_plot_id',
										'class'=>'form-control',
										'value'=>isset($customer_zatca_data['buyer_party_postal_plot_id']) ? $customer_zatca_data['buyer_party_postal_plot_id']:""
									)
								);
								?>
							</div>
						</div>
						<div class="form-group zatca_buyer_info" style="display: none;">
							<?php echo form_label( lang('customer_saudi_tax_country_name') . ' (ZATCA)'.':', 'zatca_buyer_party_postal_country', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php
								
								echo form_dropdown('zatca_buyer_party_postal_country',
									array(
										'SA'=>'SA',
									),
									isset($customer_zatca_data['buyer_party_postal_country'])? $customer_zatca_data['buyer_party_postal_country']:"",
									'class="form-control" id="zatca_buyer_party_postal_country"'
								);

								// echo form_input(
								// 	array(
								// 		'name'=>'zatca_buyer_party_postal_country',
								// 		'id'=>'zatca_buyer_party_postal_country',
								// 		'class'=>'form-control',
								// 		'placeholder'=>'2 letter code (ISO 3166 Alpha-2) e.g: SA',
								// 		'value'=>isset($customer_zatca_data['buyer_party_postal_country']) ? $customer_zatca_data['buyer_party_postal_country']:""
								// 	)
								// );
								?>
							</div>
						</div>



                <?php if (!empty($tiers)) { ?>

                <?php
								if ($this->Employee->has_module_action_permission('customers', 'edit_tier', $this->Employee->get_logged_in_employee_info()->person_id))
								{
								?>
                <div class="form-group">
                    <?php echo form_label(lang('customers_tier_type').':', 'tier_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-12">
                        <?php echo form_dropdown('tier_id', $tiers, $person_info->tier_id, 'class="form-control" id="tier_id"');?>
                    </div>
                </div>

                <?php
								}
								else
								{
									echo form_hidden('tier_id', $person_info->tier_id ? $person_info->tier_id : NULL);
								}
								?>
                <?php } ?>

                <?php if ($this->Location->count_all() > 1) {?>
                <div class="form-group">
                    <?php echo form_label(lang('location').': ', 'location_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_dropdown('location_id',  $locations, $person_info->location_id ? $person_info->location_id : ($this->config->item('default_new_customer_to_current_location') && !$person_info->person_id ? $this->Employee->get_logged_in_employee_current_location_id(): ''), array('id' =>'location_id','class' => 'form-control location_id'));?>
                    </div>
                </div>
                <?php } ?>

                <?php if($person_info->cc_token && $person_info->cc_preview) { ?>
                <div class="control-group">
                    <?php echo form_label(lang('customers_delete_cc_info').':', 'delete_cc_info',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_checkbox('delete_cc_info', '1', FALSE, 'id="delete_cc_info"');?>
                        <label for="delete_cc_info"><span></span></label>
                    </div>
                </div>
                <?php } ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check">

                                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('customer_info_popup'))?></label>
                                        <?php echo form_textarea(array(
									'name'=>'customer_info_popup',
									'id'=>'customer_info_popup',
									'value'=>$person_info->customer_info_popup,
									'class'=>'form-control form-control-solid  text-area',
									'rows'=>'5',
									'cols'=>'17')
								);?>

                                    </div>
                                    <div class="form-check" style="margin-top: 24px; padding-left: 52px;">

                                        
                                        <?php echo form_checkbox('auto_email_receipt', '1', (boolean)$person_info->auto_email_receipt,'id="auto_email_receipt" class="form-check-input"'); ?>

										<label class="form-check-label ml-0" for="flexCheckDefault"> <?php 

echo form_label(lang('customers_auto_email_receipt'))?></label>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>





                <?php if ($this->Location->get_info_for_key('twilio_sms_from')) { ?>
                <div class="form-group">
                    <?php echo form_label(lang('customers_always_sms_receipt').':', 'always_sms_receipt',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo form_checkbox('always_sms_receipt', '1', (boolean)$person_info->always_sms_receipt,'id="always_sms_receipt"'); ?>
                        <label for="always_sms_receipt"><span></span></label>
                    </div>
                </div>
                <?php } ?>
                <?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { ?>
                <?php
						 $custom_field = $this->Customer->get_custom_field($k);
						 if($custom_field !== FALSE) {

							$required = false;
							$required_text = '';
							if($this->Customer->get_custom_field($k,'required') && in_array($current_location,$this->Customer->get_custom_field($k,'locations'))){
								$required = true;
								$required_text = 'required';
							}
							
							?>
                <div class="form-group">
                    <?php echo form_label($custom_field . ' :', "custom_field_${k}_value", array("class"=>"col-sm-3 col-md-3 col-lg-2 control-label $required_text")); ?>

                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php if ($this->Customer->get_custom_field($k,'type') == 'checkbox') { ?>

                        <?php echo form_checkbox(array(
												"name" => "custom_field_${k}_value", 
												"id" => "custom_field_${k}_value",
												"value" => '1', 
												"checked" => (boolean)$person_info->{"custom_field_${k}_value"},
												($required ? $required_text : $required_text) => ($required ? $required_text : $required_text)
											)
											);
										?>
                        <label for="<?php echo "custom_field_${k}_value"; ?>"><span></span></label>

                        <?php } elseif($this->Customer->get_custom_field($k,'type') == 'date') { ?>

                        <?php echo form_input(array(
											'name'=>"custom_field_${k}_value",
											'id'=>"custom_field_${k}_value",
											'class'=>"custom_field_${k}_value".' form-control',
											'value'=>is_numeric($person_info->{"custom_field_${k}_value"}) ? date(get_date_format(), $person_info->{"custom_field_${k}_value"}) : '',
											($required ? $required_text : $required_text) => ($required ? $required_text : $required_text)
											)
											);?>
                        <script type="text/javascript">
                        var $field = <?php echo "\$('#custom_field_${k}_value')"; ?>;
                        $field.datetimepicker({
                            format: JS_DATE_FORMAT,
                            locale: LOCALE,
                            ignoreReadonly: IS_MOBILE ? true : false
                        });
                        </script>

                        <?php } elseif($this->Customer->get_custom_field($k,'type') == 'dropdown') { ?>

                        <?php 
											$choices = explode('|',$this->Customer->get_custom_field($k,'choices'));
											$select_options = array('' => lang('please_select'));
											foreach($choices as $choice)
											{
												$select_options[$choice] = $choice;
											}
											echo form_dropdown("custom_field_${k}_value", $select_options, $person_info->{"custom_field_${k}_value"}, 'class="form-control" '.$required_text);?>

                        <?php } elseif($this->Customer->get_custom_field($k,'type') == 'image') {
										echo form_input(
											array(
												'name'=>"custom_field_${k}_value",
												'id'=>"custom_field_${k}_value",
												'type' => 'file',
												'class'=>"custom_field_${k}_value".' form-control',
												'accept'=>".png,.jpg,.jpeg,.gif"
											),
											NULL,
											$person_info->{"custom_field_${k}_value"} ? "" : $required_text
										);

										if ($person_info->{"custom_field_${k}_value"})
										{
											echo "<img width='30%' src='".cacheable_app_file_url($person_info->{"custom_field_${k}_value"})."' />";
											echo "<div class='delete-custom-image'><a href='".site_url('customers/delete_custom_field_value/'.$person_info->person_id.'/'.$k)."'>".lang('delete')."</a></div>";
											
										}
									 ?>
                        <?php
									}
	 							 elseif($this->Customer->get_custom_field($k,'type') == 'file')
	 							 {
	 								 echo form_input(
										  array(
											'name'=>"custom_field_${k}_value",
											'id'=>"custom_field_${k}_value",
											'type' => 'file',
											'class'=>"custom_field_${k}_value".' form-control'
	 								 	),
										NULL,
										$person_info->{"custom_field_${k}_value"} ? "" : $required_text
									);

	 								 if ($person_info->{"custom_field_${k}_value"})
	 								 {
	 								 	echo anchor('customers/download/'.$person_info->{"custom_field_${k}_value"},$this->Appfile->get_file_info($person_info->{"custom_field_${k}_value"})->file_name,array('target' => '_blank'));
	 								 	echo "<div class='delete-custom-image'><a href='".site_url('customers/delete_custom_field_value/'.$person_info->person_id.'/'.$k)."'>".lang('delete')."</a></div>";
	 								 }
							 		
	 							 }
								 else 
									{
									
											echo form_input(array(
											'name'=>"custom_field_${k}_value",
											'id'=>"custom_field_${k}_value",
											'class'=>"custom_field_${k}_value".' form-control',
											'value'=>$person_info->{"custom_field_${k}_value"},
											($required ? $required_text : $required_text) => ($required ? $required_text : $required_text)
											)
											);?>
                        <?php } ?>
                    </div>
                </div>
                <?php } //end if?>
                <?php } //end for loop?>
                                        </div>
        </div>
                <div class="card shadow-sm mt-5">
                    <div class="card-header rounded rounded-3 p-5">
                        <h3 class="card-title">
                            <i class="ion-folder"></i>
                            <?php echo lang("files"); ?>
                        </h3>
                    </div>

                    <?php if (count($files)) {?>
                    <ul class="list-group">
                        <?php foreach($files as $file){?>
                        <li class="list-group-item permission-action-item">

                            <?php echo anchor($controller_name.'/delete_file/'.$file->file_id,'<i class="icon ion-android-cancel text-danger" style="font-size: 120%"></i>', array('class' => 'delete_file'));?>
                            <?php echo anchor($controller_name.'/download/'.$file->file_id,$file->file_name,array('target' => '_blank'));?>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>

       <div class="card-body">
                    <h4 style="padding: 20px;"><?php echo lang('add_files');?></h4>
					<div class="row">
                    <?php for($k=1;$k<=5;$k++) { ?>

						<div class="col-md-6">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5 active">

                                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('file').' '.$k.':', 'files_'.$k)?></label>
                                        <div class="file-upload">
                                <input type="file" class="form-control form-control-solid" name="files[]" id="files_<?php echo $k; ?>">
                            </div>

                                    </div>
                                   

                                </div>

                            </div>
                        </div>
                    </div>
                    
                    <?php } ?>
                </div>
                </div>


                <?php echo form_hidden('redirect_code', $redirect_code); ?>

                <div class="form-actions">
                    <?php
							if ($redirect_code == 1)
							{
								echo form_button(array(
							    'name' => 'cancel',
							    'id' => 'cancel',
								 'class' => 'submit_button btn btn-danger',
							    'value' => 'true',
							    'content' => lang('cancel')
								));
							
							}
							?>

                    <?php
							echo form_submit(array(
								'name'=>'submitf',
								'id'=>'submitf',
								'value'=>lang('save'),
								'class'=>' submit_button floating-button btn btn-lg btn-danger')
							);
							?>
               
        </div>
        <?php echo form_close(); ?>

    </div>
                        </div>
    <?php
				$this->load->view('people/add_title_modal');		
			?>

</div><!-- /row -->
</div>

<script type='text/javascript'>
$(".override_default_tax_checkbox").change(function() {
    $(this).parent().parent().next().toggleClass('hidden')
});

check_taxable();
$("#taxable").change(check_taxable);

function check_taxable() {
    if ($("#taxable").prop('checked')) {
        $("#tax_certificate_holder").hide();
        <?php if($this->config->item('use_saudi_tax_config')) { ?>
						$(".zatca_buyer_info").show();
					<?php } ?>
    } else {
        $("#tax_certificate_holder").show();
    }
}

$('#image_id').imagePreview({
    selector: '#avatar'
}); // Custom preview container
//validation and submit handling
$(document).ready(function() {
    $("#cancel").click(cancelCustomerAddingFromSale);
    setTimeout(function() {
        $(":input:visible:first", "#customer_form").focus();
    }, 100);
    var submitting = false;
    
    $.validator.addMethod(
								"zatca_customer",
								function(value1, element, type) {

									if($("#company_name").val().trim().length == 0)
										return true;

									var value = value1.trim();
									var check = false;
									if(type == "buyer_id"){
										if(value.length > 0)
											check = true;
									}else if(type == "buyer_scheme_id"){
										if(value.length > 0)
											check = true;
									}else if(type == "buyer_tax_id"){
										if(value.length > 0)
											check = true;
									}else if(type == "buyer_party_postal_street_name"){
										if(value.length > 0)
											check = true;
									}else if(type == "buyer_party_postal_building_number"){
										if(value.length == 4)
											check = true;
									}else if(type == "buyer_party_postal_code"){
										if(value.length == 5)
											check = true;
									}else if(type == "buyer_party_postal_city"){
										if(value.length > 0)
											check = true;
									}else if(type == "buyer_party_postal_district"){
										if(value.length > 0)
											check = true;
									}else if(type == "buyer_party_postal_plot_id"){
										if(value.length == 4)
											check = true;
									}else {
										check = true;
									}
									return check;
								},
								"Please check the ZATCA buyer input validation."
							);

    $('#customer_form').validate({
        submitHandler: function(form) {
            $.post('<?php echo site_url("customers/check_duplicate");?>', {
                    name: $('#first_name').val() + ' ' + $('#last_name').val(),
                    email: $("#email").val(),
                    phone_number: $("#phone_number").val()
                }, function(data) {
                    <?php if(!$person_info->person_id) { ?>
                    if (data.duplicate) {
                        bootbox.confirm(
                            <?php echo json_encode(lang('customers_duplicate_exists'));?>,
                            function(result) {
                                if (result) {
                                    doCustomerSubmit(form);
                                }
                            });
                    } else {
                        doCustomerSubmit(form);
                    }
                    <?php } else { ?>
                    doCustomerSubmit(form);
                    <?php } ?>
                }, "json")
                .error(function() {});

        },
        rules: {
            <?php if(!$person_info->person_id) { ?>
            account_number: {
                remote: {
                    url: "<?php echo site_url('customers/account_number_exists');?>",
                    type: "post"

                }
            },
            <?php } ?>
            first_name: "required",
            <?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { 
											$custom_field = $this->Customer->get_custom_field($k);
											if($custom_field !== FALSE) {
												if( $this->Customer->get_custom_field($k,'required') && in_array($current_location, $this->Customer->get_custom_field($k,'locations'))){

													if(($this->Customer->get_custom_field($k,'type') == 'file' || $this->Customer->get_custom_field($k,'type') == 'image') && !$person_info->{"custom_field_${k}_value"}){
														echo "custom_field_${k}_value: 'required',\n";
													}
													
													if(($this->Customer->get_custom_field($k,'type') != 'file' && $this->Customer->get_custom_field($k,'type') != 'image')){
														echo "custom_field_${k}_value: 'required',\n";
													}
												}
											}
										}
											?>

                                            
									<?php if($this->config->item('use_saudi_tax_config')){ ?>
										zatca_buyer_id:{
											zatca_customer: 'buyer_id',
										},
										zatca_buyer_scheme_id:{
											zatca_customer: 'buyer_scheme_id',
										},
										zatca_buyer_tax_id:{
											zatca_customer: 'buyer_tax_id',
										},
										zatca_buyer_party_postal_street_name:{
											zatca_customer: 'buyer_party_postal_street_name',
										},
										zatca_buyer_party_postal_building_number:{
											zatca_customer: 'buyer_party_postal_building_number',
										},
										zatca_buyer_party_postal_code:{
											zatca_customer: 'buyer_party_postal_code',
										},
										zatca_buyer_party_postal_city:{
											zatca_customer: 'buyer_party_postal_city',
										},
										zatca_buyer_party_postal_district:{
											zatca_customer: 'buyer_party_postal_district',
										},
										zatca_buyer_party_postal_plot_id: {
											zatca_customer: 'buyer_party_postal_plot_id',
										}
									<?php } ?>
        },
        errorClass: "text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
        messages: {
            <?php if(!$person_info->person_id) { ?>
            account_number: {
                remote: <?php echo json_encode(lang('account_number_exists')); ?>
            },
            <?php } ?>
            first_name: <?php echo json_encode(lang('first_name_required')); ?>,
            last_name: <?php echo json_encode(lang('last_name_required')); ?>,

            <?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { 
												$custom_field = $this->Customer->get_custom_field($k);
												if($custom_field !== FALSE) {
													if( $this->Customer->get_custom_field($k,'required') && in_array($current_location, $this->Customer->get_custom_field($k,'locations'))){

														if(($this->Customer->get_custom_field($k,'type') == 'file' || $this->Customer->get_custom_field($k,'type') == 'image') && !$person_info->{"custom_field_${k}_value"}){
															$error_message = json_encode($custom_field." ".lang('is_required'));
															echo "custom_field_${k}_value: $error_message,\n";
														}

														if(($this->Customer->get_custom_field($k,'type') != 'file' && $this->Customer->get_custom_field($k,'type') != 'image')){
															$error_message = json_encode($custom_field." ".lang('is_required'));
															echo "custom_field_${k}_value: $error_message,\n";
														}


													}
												}
											}
											?>


        }
    });
});

var submitting = false;

function doCustomerSubmit(form) {
    $("#grid-loader").show();
    if (submitting) return;
    submitting = true;

    $(form).ajaxSubmit({
        success: function(response) {
            $("#grid-loader").hide();
            submitting = false;
            show_feedback(response.success ? 'success' : 'error', response.message, response.success ?
                <?php echo json_encode(lang('success')); ?> :
                <?php echo json_encode(lang('error')); ?>);


            if (response.redirect_code == 1 && response.success) {
                $.post('<?php echo site_url("sales/select_customer");?>', {
                    customer: response.person_id + '|FORCE_PERSON_ID|'
                }, function() {
                    window.location.href = '<?php echo site_url('sales/index/1'); ?>';
                });
            } else if (response.redirect_code == 2 && response.success) {
                window.location.href = '<?php echo site_url('customers'); ?>';
            }
            if (response.redirect_code == 3 && response.success) {
                redirectAddNewWorkOrder(response.person_id);
            } else {
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");
                $(".form-group").removeClass('has-success has-error');
            }
        },
        <?php if(!$person_info->person_id) { ?>
        resetForm: true,
        <?php } ?>
        dataType: 'json'
    });
}

function cancelCustomerAddingFromSale() {
    bootbox.confirm(<?php echo json_encode(lang('customers_are_you_sure_cancel')); ?>, function(response) {
        if (response) {
            window.location = <?php echo json_encode(site_url('sales')); ?>;
        }
    });
}

<?php if($redirect_new_order != ""){ ?>

function redirectAddNewWorkOrder(customer) {
    bootbox.confirm({
        message: <?php echo json_encode(lang('redirect_prompt')); ?>,
        buttons: {
            confirm: {
                label: <?php echo json_encode(lang('add_customer_to_work_order')); ?>,
                className: 'btn-primary'
            },
            cancel: {
                label: <?php echo json_encode(lang('cancel')); ?>,
                className: 'btn-default'
            }
        },
        callback: function(result) {
            if (result) {
                var done = function() {
                    window.location.href = <?php echo json_encode(site_url($redirect_new_order)); ?>;
                };
                $.post(<?php echo json_encode(site_url('work_orders/select_customer'))?>, {
                    customer: customer
                }, done);
            }
        }
    });
}
<?php } ?>

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
</script>

<?php $this->load->view("partial/footer"); ?>