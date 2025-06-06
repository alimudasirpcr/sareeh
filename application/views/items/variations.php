<?php $this->load->view("partial/header"); ?>

                <?php $this->load->view('partial/categories/category_modal', array('categories' => $categories));?>

<?php $query = http_build_query(array('redirect' => $redirect, 'progression' => $progression ? 1 : null, 'quick_edit' => $quick_edit ? 1 : null)); ?>
<?php $manage_query = http_build_query(array('redirect' => uri_string().($query ? "?".$query : ""), 'progression' => $progression ? 1 : null, 'quick_edit' => $quick_edit ? 1 : null)); ?>


	<div class="spinner" id="grid-loader" style="display:none">
	  <div class="rect1"></div>
	  <div class="rect2"></div>
	  <div class="rect3"></div>
	</div>

<div class="manage_buttons hidden">
	<div class="row">
		<div class="<?php echo isset($redirect) ? 'col-xs-9 col-sm-10 col-md-10 col-lg-10': 'col-xs-12 col-sm-12 col-md-12' ?> margin-top-10">
			<div class="modal-item-info padding-left-10">
				<div class="breadcrumb-item text-dark">
					<?php if(!$item_info->item_id) { ?>
			    <span class="modal-item-name new"><?php echo lang('items_new'); ?></span>
					<?php } else { ?>
		    	<span class="modal-item-name"><?php echo H($item_info->name).' ['.lang('id').': '.$item_info->item_id.']'; ?></span>
					<span class="badge badge-success fw-semibold fs-9 px-2 ms-2 cursor-default ms-2"><?php echo H($category); ?></span>
					<?php } ?>
				</div>
			</div>	
		</div>
		<?php if(isset($redirect) && !$progression) { ?>
		<div class="col-xs-3 col-sm-2 col-md-2 col-lg-2 margin-top-10">
			<div class="buttons-list">
				<div class="pull-right-btn">
				<?php echo 
					anchor(site_url($redirect), ' ' . lang('done'), array('class'=>'outbound_link btn btn-light-primary btn-lg ion-android-exit', 'title'=>''));
				?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>



<?php echo form_open('items/save_variations/'.(!isset($is_clone) ? $item_info->item_id : ''),array('id'=>'item_form','class'=>'form-horizontal form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework')); ?>

<?php $this->load->view('partial/item_side_bar', array('progression' => $progression, 'query' => $query, 'item_info' => $item_info)); ?>


<div class="d-flex flex-column flex-row-fluid gap-5">
<?php if(!$quick_edit) { ?>
<?php $this->load->view('partial/nav', array('progression' => $progression, 'query' => $query, 'item_info' => $item_info)); ?>
<?php } ?>
			<div class="card shadow-sm mt-3">
				<div class="card-header rounded rounded-3 p-5">
		      <h3 class="card-title"> <?php echo lang("quantity_units"); ?> </h3>
					
				</div>	
				<div class="card-body">
					
					<div class="form-group no-padding-right row">	
					<?php echo form_label(lang('quantity_units').':', '',array('class'=>'col-sm-12  ')); ?>
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="price_quantity_units" class="table">
									<thead>
										<tr>
										<th><?php echo lang('name'); ?></th>
										<th><?php echo lang('quantity'); ?></th>
										<th><?php echo lang('cost_price'); ?></th>
										<th><?php echo lang('unit_price'); ?></th>
										<th><?php echo lang('item_number'); ?></th>
										<th><?php echo lang('default_for_sale'); ?></th>
										<th><?php echo lang('default_for_recv'); ?></th>
										<th><?php echo lang('delete'); ?></th>
										</tr>
									</thead>
									
									<tbody>
																			
									<?php foreach($item_quantity_units as $iqu) { ?>
										<tr>
											<td><input type="text" data-index="<?php echo $iqu->id ?>" class="quantity_units_to_edit form-control" name="quantity_units_to_edit[<?php echo $iqu->id; ?>][unit_name]" value="<?php echo H($iqu->unit_name); ?>" /></td>
											<td><input type="text" data-index="<?php echo $iqu->id ?>" class="quantity_units_to_edit form-control" name="quantity_units_to_edit[<?php echo $iqu->id; ?>][unit_quantity]" value="<?php echo H(to_quantity($iqu->unit_quantity)); ?>" /></td>
											<td><input type="text" data-index="<?php echo $iqu->id ?>" class="quantity_units_to_edit form-control" name="quantity_units_to_edit[<?php echo $iqu->id; ?>][cost_price]" value="<?php echo H($iqu->cost_price !== NULL ? to_currency_no_money($iqu->cost_price) : '' ); ?>" /></td>
											<td><input type="text" data-index="<?php echo $iqu->id ?>" class="quantity_units_to_edit form-control" name="quantity_units_to_edit[<?php echo $iqu->id; ?>][unit_price]" value="<?php echo H($iqu->unit_price !== NULL ? to_currency_no_money($iqu->unit_price) : '' ); ?>" /></td>
											<td><input type="text" data-index="<?php echo $iqu->id ?>" class="quantity_units_to_edit form-control" name="quantity_units_to_edit[<?php echo $iqu->id; ?>][quantity_unit_item_number]" value="<?php echo H($iqu->quantity_unit_item_number !== NULL ? $iqu->quantity_unit_item_number : '' ); ?>" /></td>
											<td>
											<div class="form-check form-check-custom form-check-solid">		
																				
											<?php echo form_checkbox(array(
												'name'=>'quantity_units_to_edit['.$iqu->id.'][default_for_sale]',
												'id'=>'quantity_units_to_edit_default_for_sale_'.$iqu->id,
												'class' => 'quantity_units_to_edit  form-check-input quantity_units_to_edit_default_for_sale',
												'value'=>1,
												'checked'=>(boolean)$iqu->default_for_sale));
											?>
											<label class="form-check-label" for="quantity_units_to_edit_default_for_sale_<?php echo $iqu->id; ?>"><span></span></label>
											</div>
											
											</td>

											<td>
											<div class="form-check form-check-custom form-check-solid">												
											<?php echo form_checkbox(array(
												'name'=>'quantity_units_to_edit['.$iqu->id.'][default_for_recv]',
												'id'=>'quantity_units_to_edit_default_for_recv_'.$iqu->id,
												'class' => 'quantity_units_to_edit  quantity_units_to_edit_default_for_recv  form-check-input',
												'value'=>1,
												'checked'=>(boolean)$iqu->default_for_recv));
											?>
											<label class="form-check-label"  for="quantity_units_to_edit_default_for_recv_<?php echo $iqu->id; ?>"><span></span></label>
											
											</div>
											</td>
										<td>
											<a class="delete_quantity_unit btn btn-sm btn-icon btn-light-danger border-radius-5r" href="javascript:void(0);" data-quantity_unit-id='<?php echo $iqu->id; ?>'>
											<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span></a>
											</td>
									</tr>
									<?php } ?>
									</tbody>
								</table>
								
								<a href="javascript:void(0);" class="btn btn-light-primary" id="add_quantity_unit"><i class="fas fa-plus fs-4 me-2"></i><?php echo lang('add'); ?></a>
								</div>
							</div>
						</div>
					</div>

</div>
	
<div class="row <?php echo $redirect ? '  ' :''; ?>">
	<div class="col-md-12">
		<div class="card shadow-sm mt-3">
			<div class="card-header rounded rounded-3 p-5">
	      <h3 class="card-title"> <?php echo lang("items_variations"); ?> </h3>
				
				<div class="breadcrumb breadcrumb-dot text-muted fs-6 fw-semibold" id="pagination_top">
					<?php
					if (isset($prev_item_id) && $prev_item_id)
					{
							echo anchor('items/variations/'.$prev_item_id, '<span class="hidden-xs ion-chevron-left"> '.lang('items_prev_item').'</span>');
					}
					if (isset($next_item_id) && $next_item_id)
					{
							echo anchor('items/variations/'.$next_item_id,'<span class="hidden-xs">'.lang('items_next_item').' <span class="ion-chevron-right"></span</span>');
					}
					?>
	  		</div>
			</div>
			<div class="card-body">
				<div class="row">

				
		
			<div class="col-md-12">
				<label class="form-label"><?php echo lang('items_attributes').':' ?></label>
			

					<div class="input-group flex-direction-row-reverse">
						<?php echo form_dropdown('', $attribute_select_options, '','class="form-control" id="available_attributes"');?>
						<span class="input-group-btn w-50px">
						        <button id="add_attribute" class="btn btn-light-primary" type="button"><?php echo lang('add'); ?></button>
						</span>
					</div>

					<table id="attributes" class="table">
						<thead>
							<tr>
								<th><?php echo lang('name'); ?></th>
								<th><?php echo lang('values'); ?></th>
								<th><?php echo lang('delete'); ?></th>
							</tr>
						</thead>

						<tbody>
							<?php if (isset($attributes) && $attributes) {?>
									<?php foreach($attributes as $id => $attribute) {
										$values = '';
									
										if(isset($attribute['attr_values']))
										{
											$values = implode('|', array_values(array_column($attribute['attr_values'], 'name')));
										}
										
									?>
									<tr>
										<td><?php echo H($attribute['name']); ?> </td>
										<td><input type="text" class="form-control form-inps attribute_values <?php echo $attribute['item_id'] ? 'custom' : '' ?>" size="50" data-attr-id="<?php echo $id; ?>" data-attr-name="<?php echo H($attribute['name']); ?>" name="attributes[<?php echo $id; ?>]" value="<?php echo H($values); ?>" /></td>
										<td><a class="delete_attribute btn btn-sm btn-icon btn-light-danger border-radius-5 <?php echo $attribute['item_id'] ? 'custom' : '' ?>" href="javascript:void(0);">
										<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
									</a></td>
									</tr>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
					<div class="p-top-5">
						<?php echo anchor("items/manage_attributes".($manage_query ? '?'.$manage_query : ''),lang('manage_attributes'),array('class' => 'outbound_link btn btn-light-primary','title'=> lang('manage_attributes')));?>
					</div>
			
			</div>
			</div>
			<?php if ($item_info->item_id && !isset($is_clone)) { ?>
			<div class="form-group row">
				<label class="col-12"><?php echo lang('item_variations').':' ?></label>
				<div class="col-sm-12 table-responsive">
					<table id="item_variations" class="table">
						<thead>
							<tr>
								<th><?php echo lang('name'); ?></th>
								<th class="min-w-200px"><?php echo lang('attributes'); ?></th>
								<th><?php echo lang('item_number'); ?></th>
									<?php if ($this->config->item("ecommerce_platform")) { ?>
										<th class="text-center"><?php echo lang('items_is_ecommerce'); ?></th>
									<?php } ?>
									<th><?php echo lang('variation_id'); ?></th>
									<th><?php echo lang('supplier'); ?></th>
								<th><?php echo lang('delete'); ?></th>
							</tr>
						</thead>

						<tbody>
							<?php if (isset($item_variations) && $item_variations) { ?>
							<?php foreach($item_variations as $item_variation_id => $item_variation) { ?>
									<tr>
										<td><input type="text" class="form-control form-inps item_variation_name" size="20" name="item_variations[name][]" value='<?php echo H($item_variation['name']); ?>' /></td>
										<td><input type="text" class="form-control form-inps item_variation_attributes" size="50" name="item_variations[attributes][]" data-selectize-value='<?php echo H(json_encode($item_variation['attributes'])); ?>' /></td>
										<td><input type="text" class="form-control form-inps item-variation-numbers" size="10" name="item_variations[item_number][]" value="<?php echo H($item_variation['item_number']); ?>" /></td>
											<?php if ($this->config->item("ecommerce_platform")) { ?>
												<td class="text-center">
													<?php echo form_dropdown('item_variations[is_ecommerce][]',array('1' => lang('yes'),'0' => lang('no')),$item_variation['is_ecommerce'],'class="form-control"');?>
												</td>
											<?php } ?>
										<td><input type="hidden" class="item_variation_id" name="item_variations[item_variation_id][]" value="<?php echo H($item_variation_id); ?>" /><?php echo $item_info->item_id.'#'.$item_variation_id ?></td>
										<td><?php echo form_dropdown('item_variations[supplier_id][]', $all_suppliers_of_an_item, $item_variation['supplier_id'] ? $item_variation['supplier_id'] : $selected_supplier, 'class="form-control form-inps item_supplier_id"');?></td>
										<td class="d-flex gap-1">
											<a class="delete_item_variation btn btn-sm btn-icon btn-light-danger border-radius-5" href="javascript:void(0);">   <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span></a>
											<?php if($item_info->item_id!=null): ?>
												<a href="<?php echo base_url('items/serial_number_template_export/'.$item_info->item_id .'/'.$item_variation_id.''); ?>" class="btn btn-light-primary" ><i class="fas fa-download fs-4 me-2"></i><?php echo lang('download_template'); ?></a>
											<?php endif; ?>
										</td>
									</tr>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>

					<a href="javascript:void(0);" class="btn btn-light-primary" id="add_item_variation"><?php echo lang('items_add_item_variation'); ?></a><br /><br /><br /><br /><br /><br />
					<a href="<?php echo site_url('items/auto_create_variations/'.$item_info->item_id);?>" id="auto_create_all_cariations" class="btn btn-success"><?php echo lang('items_auto_create_variations'); ?></a>
				</div>
			</div>
			<?php } //end item variations ?>

			</div><!-- /card-body-->
		</div><!--/panel-piluku-->
		
	</div><!-- end col -->
	
	<div class="col-md-12 mt-5">

				<div class="card shadow-sm mt-3">
					<div class="card-header rounded rounded-3 p-5">
			      <h3 class="card-title"> <?php echo lang("modifiers"); ?></h3>
					
					</div>	
					<div class="card-body">
					
						<div class="form-group no-padding-right">	
							
								<?php
								foreach($this->Item_modifier->get_all()->result_array() as $modifier)
								{
								?>

									<div class="form-check form-check-custom form-check-solid mb-2">
										<input class="form-check-input modifier"  name="modifiers[]" <?php if($this->Item_modifier->item_has_modifier($item_info->item_id,$modifier['id'])){ ?>  checked="checked" <?php } ?> type="checkbox" id="<?= 'modifier_'.$modifier['id']; ?>" value="<?= $modifier['id']; ?> " data-gtm-form-interact-field-id="2">
										<label class="form-check-label" for="modifier_<?php echo $modifier['id']; ?>">
											<?= $modifier['name']; ?>
										</label>
									</div>


								
							
							<?php } ?>
						</div>
							</div>
						</div>

	</div>
</div><!-- /row -->

<?php echo form_hidden('redirect', isset($redirect) ? $redirect : ''); ?>
<?php echo form_hidden('progression', isset($redirect) ? $progression : ''); ?>
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
			
<script type='text/javascript'>
	<?php $this->load->view("partial/common_js"); ?>
	
	function init_attribute_values_for_item_variations($selector)
	{
			$selector.each(function() {
			
				$selectizeInstance = $(this).selectize({
					delimiter: '|',
					loadThrottle : 215,
					persist: false,
					valueField: 'value',
					labelField: 'label',
					searchField: 'label',
					preload: true,
					create: false,
					onInitialize: function() {
							var data = this.$input.attr('data-selectize-value');
						
							if(!data)
							{
								return;
							}
						
					    var existingOptions = JSON.parse(data);
					    var self = this;
					    if(Object.prototype.toString.call( existingOptions ) === "[object Array]") {
					        existingOptions.forEach( function (existingOption) {
					            self.addOption(existingOption);
					            self.addItem(existingOption[self.settings.valueField]);
					        });
					    }
					    else if (typeof existingOptions === 'object') {
					        self.addOption(existingOptions);
					        self.addItem(existingOptions[self.settings.valueField]);
					    }
					},
					onItemRemove: function(value_removed, $item)
					{
						var attribute_value_label = $item.html();
	
						this.addOption({label: attribute_value_label, value: value_removed});
						this.refreshOptions();
					},
					onItemAdd: function(value_added, $item)
	        {                                       
	        	var attribute_value_label = $item.html();
	          var attribute = attribute_value_label.split(": ")[0];
						
	          var that = this;
												
	          $.each( this.options, function( key, value ) 
	          {       
              if(value.label.split(": ")[0] == attribute && value.value != value_added)
              {
								// remove from selected
                that.removeItem(value.value);
                that.refreshItems();
              }
	          });
	        },
					load: function(query, callback) {
						if (!query.length) return callback();
						$.ajax({
							url:'<?php echo site_url("items/attribute_values_for_item_variations/").$item_info->item_id;?>' +'?term='+encodeURIComponent(query),
							type: 'GET',
							error: function() {
								callback();
							},
							success: function(res) {
								res = $.parseJSON(res);
								callback(res);
							}
						});
					}
				
				});			
			});
	}
		
	init_attribute_values_for_item_variations($('.item_variation_attributes'));

	$(document).on('click', '.delete_item_variation', function()
	{
		var $tr = $(this).closest('tr');
		var item_variation_id = $(this).closest('tr').find('.item_variation_id').val();
	
		if(item_variation_id > 0)
		{
			$("#item_form").append('<input type="hidden" name="item_variations_to_delete[]" value="'+ item_variation_id +'" />');
		}
	
		$tr.remove();
	});


	$("#add_item_variation").click(function()
	{
		$.ajax({
			url:'<?php echo site_url("items/attribute_values_for_item_variations/").$item_info->item_id;?>',
			type: 'GET',
			success: function(res) {
				res = $.parseJSON(res);
				if(res.length >= 1)
				{
					$tr = $('<tr>');
					$tr.append($('<td><input type="text" class="form-control form-inps item_variation_name" size="20" name="item_variations[name][]" value="" /></td>'));
		
					$td = $('<td>');
					$input = $('<input type="text" class="form-control form-inps item_variation_attributes" size="50" name="item_variations[attributes][]" value="" data-selectize-value="" />')
					$td.append($input).appendTo($tr);
		

					$tr.append($(
						'<td><input type="text" class="form-control form-inps" size="1" name="item_variations[item_number][]" value="" />'+
						'<input type="hidden" class="item_variation_id" name="item_variations[item_variation_id][]" value="" />'+
						'</td>'
					));
					
					<?php if ($this->config->item("ecommerce_platform")) { ?>
					$tr.append($(
						'<td class="text-center"><select class="form-control" name="item_variations[is_ecommerce][]" value="1"><option value="1"><?php echo lang('yes');?></option><option value="0"><?php echo lang('no');?></option></select>'+
						'</td>'
					));
					<?php } ?>
					$tr.append($(
						'<td><?php echo lang('none'); ?></td>'
					));

					$tr.append($(
					'<td><?php echo str_replace("\n", " ", form_dropdown('item_variations[supplier_id][]', $all_suppliers_of_an_item, -1, 'class="form-control form-inps item_supplier_id"'));?></td>'
					));
					
					$tr.append($(
						`<td><a class="delete_item_variation btn btn-sm btn-icon btn-light-danger border-radius-5" href="javascript:void(0);">
						<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
						</a></td>`
					));
	
					$("#item_variations tbody").append($tr);
	
					init_attribute_values_for_item_variations($input);
				}
				else
				{
					bootbox.alert(<?php echo json_encode(lang('items_must_add_item_attributes_first')); ?>);
				}
			}
		});
	});

	function init_attribute_values($selector, prepopulate)
	{
			prepopulate = typeof prepopulate !== 'undefined' ? prepopulate : false;
			$selector.each(function() {
				var attr_id = $(this).data('attr-id');
				var	custom = $(this).hasClass('custom');
				
				$(this).selectize({
					delimiter: '|',
					loadThrottle : 215,
					persist: false,
					valueField: 'label',
					labelField: 'label',
					searchField: 'label',
					onItemAdd: function(value_added, $item) {
						$.ajax({
							url:'<?php echo site_url("items/add_attribute_value_to_item/").$item_info->item_id ;?>',
							type: 'POST',
							data: {attr_id:attr_id,value_added:value_added}
						});
					},
					onItemRemove: function(value_removed, $item) {
						var attribute_value_label = $item.text();
						if(!custom)
						{
							this.addOption({label: attribute_value_label, value: value_removed});
							this.refreshOptions();
						}
												
						$.ajax({
							url:'<?php echo site_url("items/remove_attribute_value_for_item/").$item_info->item_id ;?>',
							type: 'POST',
							data: {attr_id:attr_id,value_removed:value_removed},
							success: function(attr_value_id) {
								if(attr_value_id){
				       		$('.item_variation_attributes.selectized').each(function() {
										var childSelectize = $(this)[0].selectize;
										childSelectize.removeItem(attr_value_id);
										childSelectize.removeOption(attr_value_id);
										childSelectize.refreshItems();
    								childSelectize.refreshOptions();
									});
								}
							}
						});
					},
					create: custom,
					createFilter: function(input) {
						for (cur_option in this.options) 
						{
							var option_label = this.options[cur_option].label.toLowerCase();
							if (input.toLowerCase() == option_label)
							{
								return false;
							}
						}
						return true;
					},
					render: {
					    option_create: function(data, escape) {
							var add_new = <?php echo json_encode(lang('add_new_attribute_value')) ?>;
					      return '<div class="create">'+escape(add_new)+' <strong>' + escape(data.input) + '</strong></div>';
					    }
					},
					load: function(query, callback) {
						if (!query.length) return callback();
						$.ajax({
							url:'<?php echo site_url("items/attribute_values/");?>'+attr_id+'?term='+encodeURIComponent(query),
							type: 'GET',
							error: function() {
								callback();
							},
							success: function(res) {
								res = $.parseJSON(res);
								callback(res);
							}
						});
					}
				});
				
				var selectize = $(this)[0].selectize;
				
				if(prepopulate)
				{					
					$.get('<?php echo site_url("$controller_name/get_values_for_attribute");?>'+'/'+ attr_id, {}, function(response)
					{
						selectize.addOption(response);		
						
						for(var k=0;k<response.length;k++)
						{
							selectize.addItem(response[k]['label']);
						}
					}, 'json');
				}
				
			});
	}
	
	init_attribute_values($('.attribute_values'));
	
	
	$('#add_attribute').on('click', function() {
		var selected_value = $('#available_attributes').val();
		
		if(selected_value == 0)
		{	
			bootbox.prompt({
			  title: <?php echo json_encode(lang('items_please_enter_custom_attribute_name')); ?>,
			  value: $(this).data('name'),
			  callback: function(attribute_name) {
			  	if (attribute_name)
			  	{
						//ajax to make new custom attribute
			  		$.post('<?php echo site_url("items/add_custom_attribute_to_item/").$item_info->item_id;?>', 
						{ name : attribute_name }, function(response) {	
			  			show_feedback(response.success ? 'success' : 'error', response.message,response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);
			  			if (response.success)
			  			{
								$custom_attribute_values_input = $('<input type="text" value="" class="form-control form-inps attribute_values custom" size="40" name="attributes['+ response.attribute_id +']">');
								$custom_attribute_values_input.data('attr-id', response.attribute_id);
								$custom_attribute_values_input.data('attr-name', attribute_name);
								
								$tr = $('<tr>');
								$tr.append($('<td>').html(attribute_name));
								$tr.append($('<td>').append($custom_attribute_values_input));
			
								$tr.append($(`<td><a class="delete_attribute custom btn btn-sm btn-icon btn-light-danger border-radius-5" href="javascript:void(0);"><span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span></a></td>`));
			
								$("#attributes").append($tr);
			
								init_attribute_values($custom_attribute_values_input, false);
								
			  			}
			  		}, "json");
			  	}
			  }
			});
		}
		if(selected_value > 0)
		{
			$selected_option = $('#available_attributes').find("option:selected");
			var attr_name = $selected_option.text();
			
  		$.post('<?php echo site_url("items/add_attribute_to_item/").$item_info->item_id;?>', 
			{ attr_id : selected_value }, function(response) {	
  			show_feedback(response.success ? 'success' : 'error', response.message,response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);
  			if (response.success)
  			{
					$selected_option.remove();
		
					$attribute_values_input = $('<input type="text" value="" class="form-control form-inps attribute_values" size="40" name="attributes['+selected_value+']">');
					$attribute_values_input.data('attr-id', selected_value);
					$attribute_values_input.data('attr-name', attr_name);
			
					$tr = $('<tr>');
					$tr.append($('<td>').text(attr_name));
					$tr.append($('<td>').append($attribute_values_input));
						
					$tr.append($(`<td><a class="delete_attribute btn btn-sm btn-icon btn-light-danger border-radius-5" href="javascript:void(0);"> <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span></a></td>`));
				
					$("#attributes").append($tr);
		
					init_attribute_values($attribute_values_input, true);
  			}
  		}, "json");			
		}
	});

	$(document).on('click', '.delete_attribute', function() {
		var custom = $(this).hasClass('custom');
		var $tr = $(this).closest('tr');
		var $input = $tr.find('.attribute_values.selectized');
		
		var selectize = $input[0].selectize;
		var to_remove = [];
		
		$.each(selectize.items, function(index, value)
		{
			to_remove.push(value);
		});
		
		bootbox.confirm(<?php echo json_encode(lang('items_confirm_remove_item_attribute')); ?>, function(response)
		{
			if (response)
			{
				for(var k=0;k<to_remove.length;k++)
				{					
					selectize.removeItem(to_remove[k]);
					selectize.refreshItems();
				}
				
				var attr_id = $input.data('attr-id');
				var attr_name = $input.data('attr-name');
	
				$.ajax({
					url:'<?php echo site_url("items/remove_attribute_for_item/").$item_info->item_id;?>',
					type: 'POST',
					data: {attr_id:attr_id},
					success: function(res) {
						$tr.remove();
						if(!custom)
						{
							var $option = $('<option>').val(attr_id).text(attr_name);
							$("#available_attributes").append($option);
						}
				}});				
			}
		});	
	});
	
	$('#item_form').validate({
			submitHandler:function(form)
			{			
				var args = {
					next: {
						label: <?php echo json_encode(lang('edit').' '.lang('pricing')) ?>,
						url: <?php echo json_encode(site_url("items/pricing/".($item_info->item_id ? $item_info->item_id : -1)."?$query")); ?>
					}
				};
		
				doItemSubmit(form, args);
			}
	});
	
	$("#auto_create_all_cariations").click(function(e)
	{
		e.preventDefault();
		bootbox.confirm(<?php echo json_encode(lang('items_confirm_auto_variations')); ?>, function(response)
		{
			if (response)
			{

				$.get($("#auto_create_all_cariations").attr('href'),{},function(json)
		{
			if (json.success)
			{
				show_feedback('success', json.msg, "<?php echo lang('success'); ?>");

				window.location.reload();

			}else{
				show_feedback('error', json.msg, "<?php echo lang('error'); ?>");
			}
		},'json');


			
			}
		});
	});
	
	$('.item-variation-numbers').selectize({
		delimiter: '|',
		create: true,
		render: {
	      option_create: function(data, escape) {
				var add_new = <?php echo json_encode(lang('add_value')) ?>;
	        return '<div class="create">'+escape(add_new)+' <strong>' + escape(data.input) + '</strong></div>';
	      }
		},
	})
	
	$(".delete_quantity_unit").click(function()
	{
		$("#item_form").append('<input type="hidden" name="quantity_units_to_delete[]" value="'+$(this).data('quantity_unit-id')+'" />');
		$(this).parent().parent().remove();
	});
	
	function set_default_sale_recv(){
		$(".quantity_units_to_edit_default_for_sale").on('click', function(){
			var current = $(this).prop('checked');
			$(".quantity_units_to_edit_default_for_sale").prop('checked', false);
			$(this).prop('checked', current);
		})

		$(".quantity_units_to_edit_default_for_recv").on('click', function(){
			var current = $(this).prop('checked');
			$(".quantity_units_to_edit_default_for_recv").prop('checked', false);
			$(this).prop('checked', current);
		})
	}
	set_default_sale_recv();

	var add_index = -1;
	
	$("#add_quantity_unit").click(function()
	{		
		
		$("#price_quantity_units tbody").append('<tr><td><input type="text" class="quantity_units_to_edit form-control" data-index="'+add_index+'" name="quantity_units_to_edit['+add_index+'][unit_name]" value="" /></td><td><input type="text" class="quantity_units_to_edit form-control" data-index="'+add_index+'" name="quantity_units_to_edit['+add_index+'][unit_quantity]" value=""/></td><td><input type="text" class="quantity_units_to_edit form-control" data-index="'+add_index+'" name="quantity_units_to_edit['+add_index+'][cost_price]" value=""/></td><td><input type="text" class="quantity_units_to_edit form-control" data-index="'+add_index+'" name="quantity_units_to_edit['+add_index+'][unit_price]" value=""/></td><td><input type="text" class="quantity_units_to_edit form-control quantity-unit-add-number" data-index="'+add_index+'" name="quantity_units_to_edit['+add_index+'][quantity_unit_item_number]" value=""/></td><td><div class="form-check form-check-custom form-check-solid"><input  type="checkbox" name="quantity_units_to_edit['+add_index+'][default_for_sale]" value="1" id="quantity_units_to_edit_default_for_sale_'+add_index+'" class="form-check-input quantity_units_to_edit   quantity_units_to_edit_default_for_sale"><label class="form-check-label" for="quantity_units_to_edit_default_for_sale_'+add_index+'"><span></span></label></div></td><td><div class="form-check form-check-custom form-check-solid"><input type="checkbox" name="quantity_units_to_edit['+add_index+'][default_for_recv]" value="1" id="quantity_units_to_edit_default_for_recv_'+add_index+'" class="form-check-input quantity_units_to_edit  quantity_units_to_edit_default_for_recv"><label class="form-check-label" for="quantity_units_to_edit_default_for_recv_'+add_index+'"><span></span></label></div></td><td>&nbsp;</td></tr>');
		add_index--;

		set_default_sale_recv();
	});

	$(document).on('change', ".quantity-unit-add-number",function(e)
	{
		var $that = $(this);;
		$.post(<?php echo json_encode(site_url('items/does_quantity_unit_exist')); ?>,{number: $(this).val()},function(json)
		{
			if (json.exists)
			{
				bootbox.alert(<?php echo json_encode(lang('items_item_quantity_unit_number_exists')); ?>);
				$that.val('');
			}
		},'json');
	});
	
</script>
<?php  echo form_close(); ?>
</div>
<?php $this->load->view('partial/footer'); ?>
