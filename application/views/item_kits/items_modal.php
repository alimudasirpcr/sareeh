<div class="modal-dialog customer-recent-sales">
	<div class="modal-content">
		<div class="modal-header" id="myTabHeader">
			<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true" class="ti-close"></span></button>
			<div class="modal-item-details">
					<h4 class="modal-title"><?php echo H($item_kit_info->name); ?></h4>
			</div>
			<nav>
        <ul id="myTab" class="nav nav-tabs nav-line-tabs mb-5 fs-6">
					<li class="active"><a href="#ItemKitInfo" data-toggle="tab"><?php echo lang('item_kit_info'); ?></a></li>
          <li><a href="#Items" data-toggle="tab"><?php echo lang('items'); ?></a></li>
          <li><a href="#Pricing" data-toggle="tab"><?php echo lang('pricing'); ?></a></li>
					<?php if(!empty($suspended_receivings)) { ?><li><a href="#Suspended" data-toggle="tab"><?php echo lang('suspended_recievings'); ?></a></li><?php } ?>
        </ul>
			</nav>
		</div>
		<div class="modal-body">
			
			<div class="tab-content">
				<div class="tab-pane active" id="ItemKitInfo">
					
					<div class="card ">
						<div class="card-header rounded rounded-3 p-5">
							<div class="card-title">
								<h3><span class="ion-information-circled"></span> <?php echo lang('item_kit_information'); ?>
								<div class="panel-options custom">
			 						<?php if ($this->Employee->has_module_action_permission('item_kits','add_update', $this->Employee->get_logged_in_employee_info()->person_id) or $item_kit_info->name=="")	{ ?>
										<a href="<?php echo site_url("item_kits/view/".$item_kit_info->item_kit_id."?redirect=".$redirect)?>" class="btn btn-default pull-right"><?php echo lang("edit") ?></a>
									<?php } ?>
								</div>
								</h3> 
							</div>
						</div>
						
						<table class="table table-bordered table-hover table-striped">
							<tr><td width="70%"><?php echo lang('category'); ?></td> <td> <?php echo H($category); ?></td></tr>
							<tr><td width="70%"><?php echo lang('item_kit_id'); ?></td> <td> <?php echo H($item_kit_info->item_kit_id); ?></td></tr>
							<?php if($item_kit_info->product_id) { ?><tr><td><?php echo lang('product_id'); ?></td> <td> <?php echo H($item_kit_info->product_id); ?></td></tr><?php } ?>
							<?php if($item_kit_info->item_kit_number) { ?><tr><td><?php echo lang('item_number_expanded'); ?></td> <td> <?php echo H($item_kit_info->item_kit_number); ?></td></tr><?php } ?>
							<?php if (isset($additional_item_numbers) && $additional_item_numbers->num_rows() > 0) {?>
								<tr> <td colspan="2"><strong><?php echo lang('additional_item_numbers'); ?></strong></td></tr>
								<?php foreach($additional_item_numbers->result() as $additional_item_number) { ?>
									<tr><td colspan="2"><?php echo H($additional_item_number->item_number); ?></td></tr>
								<?php } ?>
							<?php } ?>
							<?php if($item_kit_info->description) { ?><tr><td width="70%"><?php echo lang('description'); ?></td> <td> <?php echo H($item_kit_info->description); ?></td></tr><?php } ?>
							<?php if($manufacturer) { ?><tr> <td><?php echo lang('manufacturer'); ?></td> <td> <?php echo H($manufacturer); ?></td></tr><?php } ?>
							<?php if (isset($supplier) && $supplier != '' && !$this->config->item('hide_supplier_from_item_popup')){ ?><tr><td><?php echo lang('supplier'); ?></td><td><?php echo $supplier; ?></td></tr> <?php } ?>
							<?php if($this->config->item("ecommerce_platform")) { ?><tr> <td><?php echo lang('items_is_ecommerce'); ?></td> <td> <?php echo $item_kit_info->is_ecommerce ? lang('yes') : lang('no'); ?></td></tr><?php } ?>
								
	 							<?php
	 						  for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) 
	 						  {
	 						 	 $item_kit_custom_field_name = $this->Item_kit->get_custom_field($k);
							 
	 							 if ($item_kit_custom_field_name)
	 							 {
	 							 	 $item_custom_field_value = $item_kit_info->{"custom_field_${k}_value"};
								 
	 								if ($this->Item_kit->get_custom_field($k,'type') == 'checkbox')
	 								{
	 									$format_function = 'boolean_as_string';
	 								}
	 								elseif($this->Item_kit->get_custom_field($k,'type') == 'date')
	 								{
	 									$format_function = 'date_as_display_date';				
	 								}
	 								elseif($this->Item_kit->get_custom_field($k,'type') == 'email')
	 								{
	 									$format_function = 'strsame';					
	 								}
	 								elseif($this->Item_kit->get_custom_field($k,'type') == 'url')
	 								{
	 									$format_function = 'strsame';					
	 								}
	 								elseif($this->Item_kit->get_custom_field($k,'type') == 'phone')
	 								{
	 									$format_function = 'format_phone_number';					
	 								}
	 								elseif($this->Item_kit->get_custom_field($k,'type') == 'image')
	 								{
	 									$this->load->helper('url');
	 									$format_function = 'file_id_to_image_thumb_right';					
	 								}
	 								elseif($this->Item_kit->get_custom_field($k,'type') == 'file')
	 								{
	 									$this->load->helper('url');
	 									$format_function = 'file_id_to_download_link';					
	 								}
	 								else
	 								{
	 									$format_function = 'strsame';
	 								}
	 								?>
	 	 								<tr><td><?php echo $item_kit_custom_field_name; ?></td> <td><?php echo $format_function($item_custom_field_value);?></td></tr>
	 							 <?php	
	 							 }
								
	 						 }
	 							?>
								
						</table>
						
					</div>
				</div>
				<div class="tab-pane" id="Items">
					<div class="card ">
						<div class="card-header rounded rounded-3 p-5">
							<div class="card-title">
								<h3><span class="icon ti-harddrive"></span> <?php echo lang('items'); ?>
								<div class="panel-options custom">
			 						<?php if ($this->Employee->has_module_action_permission('item_kits','add_update', $this->Employee->get_logged_in_employee_info()->person_id) or $item_kit_info->name=="")	{ ?>
										<a href="<?php echo site_url("item_kits/items/".$item_kit_info->item_kit_id."?redirect=".$redirect)?>" class="btn btn-default pull-right"><?php echo lang("edit") ?></a>
									<?php } ?>
								</div>
								</h3> 
							</div>
						</div>
						
						<table class="table table-bordered table-hover table-striped">
							
							<?php foreach ($this->Item_kit_items->get_info($item_kit_info->item_kit_id) as $item_kit_item) {?>
								<tr>
									<?php
									$item_info = $this->Item->get_info($item_kit_item->item_id);
									?>
									<td width="70%"><?php echo H($item_info->name).' ['.lang('id').': '.$item_info->item_id.']'; ?></td>
									<td> <?php echo to_quantity($item_kit_item->quantity) ?></td>
								</tr>
							<?php } ?>
						</table>
					</div>
				</div>
				
				<div class="tab-pane" id="Pricing">
					<div class="tab-pane" id="Items">
						<div class="card ">
							<div class="card-header rounded rounded-3 p-5">
								<div class="card-title">
									<h3><span class="ion-cash"></span> <?php echo lang('pricing'); ?>
									<div class="panel-options custom">
				 						<?php if ($this->Employee->has_module_action_permission('item_kits','add_update', $this->Employee->get_logged_in_employee_info()->person_id) or $item_kit_info->name=="")	{ ?>
											<a href="<?php echo site_url("item_kits/pricing/".$item_kit_info->item_kit_id."?redirect=".$redirect)?>" class="btn btn-default pull-right"><?php echo lang("edit") ?></a>
										<?php } ?>
									</div>
									</h3> 
								</div>
							</div>
							
							<table class="table table-bordered table-hover table-striped">
								<tr><td width="70%"><?php echo lang('unit_price'); ?></td> <td> <strong><?php echo to_currency($item_kit_info->unit_price, 10); ?></strong></td></tr>
								<?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id) or $item_kit_info->name=="")	{ ?>
	 						<tr><td><?php echo lang('cost_price'); ?></td><td colspan='5'><span id='cost_price_value' style='display: none;'><?php echo to_currency($item_kit_info->cost_price, 10); ?></span> <a id="cost_price_expand_collapse" href="javascript:void(0);">+</a></td></tr>
								<?php } ?>
								<?php 
								foreach($tier_prices as $tier_price)
								{
								?>
				 				<tr><td><?php echo H($tier_price['name']) ?></td> <td> <?php echo $tier_price['value']; ?></td></tr>
					
								<?php
								}
								?>
 				
							</table>
							
						</div>
				</div>
				<?php if(!empty($suspended_receivings)) { ?>
				<div class="tab-pane" id="Suspended">
					<div class="card ">
						<div class="card-header rounded rounded-3 p-5">
							<div class="panel-title">
								<h3><?php echo lang('receivings_list_of_suspended'); ?>
								<div class="panel-options custom">
								</div>
								</h3> 
							</div>
						</div>
						
						<table class="table table-bordered table-hover table-striped" width="1200px">
							<tr>
								<th><?php echo lang('receivings_id');?></th>
								<th><?php echo lang('items_quantity');?></th>
							</tr>
							<?php foreach($suspended_receivings as $receiving_item) {?>
								<tr>
									<td style="text-align: center;"><?php echo anchor('receivings/receipt/'.$receiving_item['receiving_id'], 'RECV '.$receiving_item['receiving_id'], array('target' => '_blank'));?></td>
									<td style="text-align: center;"><?php echo to_quantity($receiving_item['quantity_purchased']);?></td>
								</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
	$("#cost_price_expand_collapse").click(function()
	{
		if ($(this).text() == '+')
		{
			$("#cost_price_value").show();
			$(this).text('-');
		}
		else
		{
			$("#cost_price_value").hide();			
			$(this).text('+');
		}
	});
</script>


