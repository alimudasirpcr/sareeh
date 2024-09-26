<!-- <nav class="navbar  panel-piluku manage-table  mt-7 card p-5"> -->
		<ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2 nav-wizard- <?php echo $progression ? '' : ''; ?>">
			<?php if($this->uri->segment(1) == 'items') { ?>
	 			<li class="nav-item">
				<?php echo anchor("items/view/".($item_info->item_id ? $item_info->item_id : -1).($query ? '?'.$query : ''),''.lang('item_info'),array('class'=>($this->uri->segment(2) == 'view') ? 'nav-link text-active-primary sp_link pb-4 active' : 'nav-link text-active-primary sp_link pb-4 ', 'role'=>'button', 'title'=>lang('item_info')))?>
			</li>
	 			<li class="nav-item">
				<?php echo anchor("items/variations/".($item_info->item_id ? $item_info->item_id : -1).($query ? '?'.$query : ''),''.lang('items_edit_variations'),array('class'=> ($this->uri->segment(2) == 'variations') ? 'nav-link text-active-primary sp_link pb-4 active' : 'nav-link text-active-primary sp_link pb-4', 'role'=>'button', 'title'=>lang('items_edit_variations')))?>
			</li>
				 <li  id="serial_numbers_list"  class="nav-item <?php if (!$item_info->is_serialized){echo 'hidden';} ?>" ><?php echo anchor("items/serial_numbers_list/".($item_info->item_id ? $item_info->item_id : -1).($query ? '?'.$query : ''),''.lang('serial_numbers_list'),array('class'=> ($this->uri->segment(2) == 'serial_numbers_list') ? 'active nav-link text-active-primary sp_link pb-4 sn_link' : 'nav-link text-active-primary sp_link pb-4 sn_link', 'role'=>'button', 'title'=>lang('serial_numbers_list')))?></li>
				<?php if ($this->Employee->has_module_action_permission('items','edit_prices', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
					<li class="nav-item" ><?php echo anchor("items/pricing/".($item_info->item_id ? $item_info->item_id : -1).($query ? '?'.$query : ''),''.lang('edit_pricing'),array('class'=> ($this->uri->segment(2) == 'pricing') ? 'class="nav-link text-active-primary sp_link pb-4 active"' : ' nav-link text-active-primary sp_link pb-4', 'role'=>'button', 'title'=>lang('edit_pricing')));?></li>
	 			<?php } ?>
				<li  class="is-service-toggle nav-item   <?php if ($item_info->is_service){ echo 'hidden';} ?>"><?php echo anchor("items/inventory/".($item_info->item_id ? $item_info->item_id : -1).($query ? '?'.$query : ''),''.lang('items_edit_inventory'),array('class'=> ($this->uri->segment(2) == 'inventory') ? 'nav-link text-active-primary sp_link pb-4 active' : 'nav-link text-active-primary sp_link pb-4', 'role'=>'button', 'title'=>lang('items_edit_inventory')));?></li>
				<li class="nav-item" > <?php echo anchor("items/images/".($item_info->item_id ? $item_info->item_id : -1).($query ? '?'.$query : ''),''.lang('images'),array('class'=> ($this->uri->segment(2) == 'images') ? 'nav-link text-active-primary sp_link pb-4 active' : 'nav-link text-active-primary sp_link pb-4', 'role'=>'button', 'title'=>lang('images')));?></li>
	 			<?php if ($this->Location->count_all() > 0) { ?>
	 			<li class="nav-item" ><?php echo anchor("items/location_settings/".($item_info->item_id ? $item_info->item_id : -1).($query ? '?'.$query : ''),''.lang('edit_location_settings'),array('class'=> ($this->uri->segment(2) == 'location_settings') ? 'nav-link text-active-primary sp_link pb-4 active' : 'nav-link text-active-primary sp_link pb-4', 'role'=>'button', 'title'=>lang('edit_location_settings')));?></li>
	 			<?php } /*End if for multi locations*/ ?>
			<?php } ?>
			<?php if($this->uri->segment(1) == 'item_kits') { ?>
				<li class="nav-item"  ><?php echo anchor("item_kits/view/".($item_kit_info->item_kit_id ? $item_kit_info->item_kit_id : -1).($query ? '?'.$query : ''),''.lang('item_kit_info'),array('class'=> ($this->uri->segment(2) == 'view') ? 'nav-link text-active-primary sp_link pb-4 active' : 'nav-link text-active-primary sp_link pb-4', 'role'=>'button', 'title'=>lang('item_kit_info')))?></li>
				<li  class="nav-item" ><?php echo anchor("item_kits/items/".($item_kit_info->item_kit_id ? $item_kit_info->item_kit_id : -1).($query ? '?'.$query : ''),''.lang('items'),array('class'=> ($this->uri->segment(2) == 'items' ) ? 'nav-link text-active-primary sp_link pb-4 active' : 'nav-link text-active-primary sp_link pb-4' , 'role'=>'button', 'title'=>lang('items')))?></li>
				<?php if ($this->Employee->has_module_action_permission('items','edit_prices', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
					<li   class="nav-item" ><?php echo anchor("item_kits/pricing/".($item_kit_info->item_kit_id ? $item_kit_info->item_kit_id : -1).($query ? '?'.$query : ''),''.lang('edit_pricing'),array('class'=>  ($this->uri->segment(2) == 'pricing') ? 'nav-link text-active-primary sp_link pb-4 active' : 'nav-link text-active-primary sp_link pb-4', 'role'=>'button', 'title'=>lang('edit_pricing')));?></li>
				<?php } ?>
				<li class="nav-item"  > <?php echo anchor("item_kits/images/".($item_kit_info->item_kit_id ? $item_kit_info->item_kit_id : -1).($query ? '?'.$query : ''),''.lang('images'),array('class'=> ($this->uri->segment(2) == 'images') ? 'nav-link text-active-primary sp_link pb-4 active' : 'nav-link text-active-primary sp_link pb-4', 'role'=>'button', 'title'=>lang('images')));?></li>
				<?php if ($this->Location->count_all() > 0) { ?>
				<li class="nav-item" ><?php echo anchor("item_kits/location_settings/".($item_kit_info->item_kit_id ? $item_kit_info->item_kit_id : -1).($query ? '?'.$query : ''),''.lang('edit_location_settings'),array('class'=> ($this->uri->segment(2) == 'location_settings') ? 'nav-link text-active-primary sp_link pb-4 active' : 'nav-link text-active-primary sp_link pb-4', 'role'=>'button', 'title'=>lang('edit_location_settings')));?></li>
				<?php } /*End if for multi locations*/ ?>
			<?php } ?>
		</ul>
<!-- </nav> -->