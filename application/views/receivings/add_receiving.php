
<?php
$has_cost_price_permission = $this->Employee->has_module_action_permission('items', 'see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id);
?>
<div id="kt_ecommerce_edit_order_form" class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework" data-kt-redirect="/good/apps/ecommerce/sales/listing.html">
    <!--begin::Aside column-->
    <div class="w-100 flex-lg-row-auto w-lg-300px mb-7 me-7 me-lg-10">

        <!--begin::Order details-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>Order Details</h2>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
            <div class="register-box register-right">


<!-- Receive  Top Buttons  -->
<div class="sale-buttons">
    <!-- Extra links -->
    <div class="btn-group">
        <button type="button" class="btn btn-more btn-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="ion-android-more-horizontal"></i>
        </button>
        <ul class="dropdown-menu sales-dropdown" role="menu">


            <li>
                <?php echo anchor(
                    "receivings/suspended/",
                    '<i class="ion-ios-list-outline"></i> ' . lang('suspended_receivings') . ' ' . lang('and') . ' <br /> ' . lang('receivings_purchase_orders'),
                    array('class' => 'none suspended_sales_btn', 'title' => lang('suspended_receivings'))
                );
                ?>
            </li>


            <?php
            if ($this->Location->count_all() > 1) {
            ?>
                <li>
                    <?php echo anchor(
                        "receivings/suspended/2",
                        '<i class="ion-ios-list-outline"></i> ' . lang('transfer_requests'),
                        array('class' => 'none suspended_sales_btn', 'title' => lang('transfer_requests'))
                    );
                    ?>
                </li>

                <li>
                    <?php echo anchor(
                        "receivings/suspended/2/receivings.transfer_to_location_id",
                        '<i class="ion-ios-list-outline"></i> ' . lang('receivings_incoming_transfers'),
                        array('class' => 'none suspended_sales_btn', 'title' => lang('receivings_incoming_transfers'))
                    );
                    ?>
                </li>

            <?php } ?>


            <li>
                <?php echo anchor(
                    "receivings/po/",
                    '<i class="ion-ios-paper"></i> ' . lang('receivings_create_purchase_order'),
                    array('class' => 'none suspended_sales_btn', 'title' => lang('receivings_create_purchase_order'))
                );
                ?>
            </li>

            <li>
                <?php echo '<a href="#look-up-receipt" class="look-up-receipt" data-toggle="modal"><i class="ion-document"></i> ' . lang('receivings_lookup_receipt') . '</a>'; ?>
            </li>


            <?php
            if ($last_receiving_id = $this->Receiving->get_last_receiving_id()) {
                echo '<li>';
                echo anchor(
                    "receivings/receipt/$last_receiving_id",
                    '<i class="ion-document"></i> ' . lang('receivings_last_receiving_receipt'),
                    array('target' => '_blank', 'class' => 'look-up-receipt', 'title' => lang('receivings_last_receiving_receipt'))
                );

                echo '</li>';
            }
            ?>


            <li>
                <?php echo anchor(
                    "receivings/batch_receiving/",
                    '<i class="ion-bag"></i> ' . lang('batch_receivings'),
                    array('class' => 'none suspended_sales_btn', 'title' => lang('batch_receivings'))
                );
                ?>
            </li>

            <li>
                <?php echo anchor(
                    "receivings/custom_fields",
                    '<span class="ion-wrench"> ' . lang('custom_field_config') . '</span>',
                    array('id' => 'custom_fields', 'class' => '', 'title' => lang('custom_field_config'))
                ); ?>
            </li>

        </ul>
    </div>
    <?php if (count($cart_items) > 0) { ?>
        <?php echo form_open("receivings/cancel_receiving", array('id' => 'cancel_sale_form', 'autocomplete' => 'off')); ?>

        <?php

        if (!$cart->get_previous_receipt_id() || $cart->suspended) { ?>
            <a href="" class="btn btn-suspended" id="suspend_recv_button">
                <i class="ion-pause"></i>
                <?php echo lang('receivings_suspend_recv'); ?>
            </a>
        <?php } ?>
        <a href="" class="btn btn-cancel" id="cancel_sale_button">
            <i class="ion-close-circled"></i>
            <?php echo $cart->get_previous_receipt_id() ? lang('cancel_edit') : lang('receivings_cancel_receiving'); ?>
        </a>
        </form>

    <?php } ?>

</div>
<!-- /.End of receive Buttons -->


    <?php if (isset($supplier)) {  ?>
        <!-- Customer Badge when customer is added -->
        <div class="customer-badge">
            <div class="avatar">
                <img src="<?php echo $avatar; ?>" onerror="this.onerror=null; this.src='<?php echo base_url() ?>assets/css_good/media/avatars/blank.png';" alt="">
            </div>
            <div class="details">
                <a tabindex="-1" href="<?php echo site_url("suppliers/view/$supplier_id/1"); ?>" class="name">
                    <?php echo character_limiter(H($supplier), 30); ?>
                    <?php if ($this->config->item('suppliers_store_accounts') && isset($supplier_balance)) { ?>
                        <span class="<?php echo $has_balance ? 'text-danger' : 'text-success'; ?> balance">(<?php echo to_currency($supplier_balance); ?>)</span>
                    <?php } ?>
                </a>

                <!-- supplier Email  -->
                <?php if (!empty($supplier_email)) { ?>
                    <span class="email">
                        <a href="mailto:<?php echo $supplier_email; ?>"><?php echo character_limiter(H($supplier_email), 25); ?></a>
                    </span>
                <?php } ?>

                <?php if ($this->config->item('capture_internal_notes_during_receiving')) { ?>
                <span class="internal_notes">

                    <?php echo form_textarea(array(
                        'name' => 'internal_notes',
                        'id' => 'internal_notes',
                        'class' => 'form-control text-area',
                        'rows' => '2',
                        'cols' => '5',
                        'placeholder' => lang('internal_notes'),
                        'value' => $supplier_internal_notes
                    )); ?>
                </span>
            <?php } ?>

                <!-- supplier edit -->
                
                
                <?php
                if ($this->Employee->has_module_action_permission('suppliers', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) { 
                    if ($this->config->item('enable_supplier_quick_add') && $this->Employee->has_module_action_permission('suppliers', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id))
                    {
                    ?>
                        <?php echo anchor("suppliers/quick_modal/$supplier_id/1", '<i class="ion-ios-compose-outline"></i>',  array('id' => 'edit_supplier', 'data-toggle'=>"modal", 'data-target'=>"#myModalDisableClose",'class' => 'btn btn-edit btn-primary pull-right', 'title' => lang('receivings_update_supplier'))) . ''; ?>
                    <?php	
                    }
                    else
                    {
                    ?>
                        <?php echo anchor("suppliers/view/$supplier_id/1", '<i class="ion-ios-compose-outline"></i>',  array('id' => 'edit_supplier', 'class' => 'btn btn-edit btn-primary pull-right', 'title' => lang('receivings_update_supplier'))) . ''; ?>
                <?php } } ?>
                
                

            </div>

        </div>


        <div class="customer-action-buttons btn-group btn-group-justified ">
            <?php if (!empty($supplier_email)) { ?>
                <a href="#" class="btn <?php echo (bool) $email_receipt ? 'checked' : ''; ?>" id="toggle_email_receipt">
                    <i class="ion-android-mail"></i>
                    <?php echo $is_po ? lang('receivings_email_po') : lang('email_receipt'); ?>?
                </a>
                <?php } else { ?>
                <?php if ($this->Employee->has_module_action_permission('suppliers', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                    <a href="<?php echo site_url('suppliers/view/' . $supplier_id . '/1');  ?>" class="btn">
                        <i class="ion-ios-compose-outline"></i>
                        <?php echo lang('receivings_update_supplier'); ?>
                    </a>
                <?php } ?>
            <?php } ?>


            <?php
            echo form_checkbox(array(
                'name' => 'email_receipt',
                'id' => 'email_receipt',
                'value' => '1',
                'class'       => 'email_receipt_checkbox hidden',
                'checked' => (bool) $email_receipt
            ));

            ?>


            <?php echo '' . anchor("receivings/delete_supplier", '<i class="ion-close-circled"></i> ' . lang('detach'), array('id' => 'delete_supplier', 'class' => 'btn')); ?>
        </div>
    <?php } else {  ?>

        <div class="customer-form">

            <!-- if the supplier is not set , show supplier adding form -->
            <?php echo form_open("receivings/select_supplier", array('id' => 'select_supplier_form', 'autocomplete' => 'off')); ?>
            <div class="input-group contacts d-flex">
                <span class="input-group-text">
                    
                    <?php
                if ($this->config->item('enable_supplier_quick_add') && $this->Employee->has_module_action_permission('suppliers', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id))
                {
                    ?>
                        <?php echo anchor("suppliers/quick_modal/-1/1", "<i class='ion-plus'></i>", array('class' => 'none', 'title' => lang('receivings_new_supplier'), 'id' => 'new-customer', 'data-toggle'=>"modal", 'data-target'=>"#myModalDisableClose")); ?>
            
                    <?php	
                    }
                    else
                    {
                    ?>
                        <?php echo anchor("suppliers/view/-1/1", "<i class='ion-plus'></i>", array('class' => 'none', 'title' => lang('receivings_new_supplier'), 'id' => 'new-customer')); ?>
                    <?php
                    }
                    ?>
                    
                </span>
                <input type="text" id="supplier" name="supplier" class="add-customer-input keyboardLeft w-75" data-title="<?php echo lang('supplier'); ?>" placeholder="<?php echo lang('receivings_start_typing_supplier_name') . ($this->config->item('require_supplier_for_recv') ? ' (' . lang('required') . ')' : ''); ?>" />

            </div>
            </form>

        </div>


    <?php }  ?>


</div>
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Order details-->
    </div>
    <!--end::Aside column-->

    <!--begin::Main column-->
    <div class="d-flex flex-column flex-lg-row-fluid gap-7 gap-lg-10">

        <!--begin::Order details-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>Select Products</h2>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <div class="d-flex flex-column gap-10">
                    <!--begin::Input group-->
                    <div>
                        <!--begin::Label-->
                        <label class="form-label">Add products to this order</label>
                        <!--end::Label-->

                        <!--begin::Selected products-->
                        <div class="row row-cols-1 row-cols-xl-3 row-cols-md-2 border border-dashed rounded pt-3 pb-1 px-2 mb-5 mh-300px overflow-scroll" id="kt_ecommerce_edit_order_selected_products">
                            <!--begin::Empty message-->
                            <span class="w-100 text-muted ">Select one or more products from the list below by ticking the checkbox.</span>
                            <!--end::Empty message-->

                        </div>
                        <!--begin::Selected products-->

                        <!--begin::Total price-->
                        <div class="fw-bold fs-4">
                            Total Cost: $
                            <span id="kt_ecommerce_edit_order_total_price">
                                0.00
                            </span>
                        </div>
                        <!--end::Total price-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Separator-->
                    <div class="separator"></div>
                    <!--end::Separator-->

                    <!--begin::Search products-->
                    <div class="d-flex align-items-center position-relative mb-n7 ">
                        <div class="register-box register-items-form w-100">

                            <div class="item-form">
                                <!-- Item adding form -->
                                <?php echo form_open("receivings/add_new", array('id' => 'add_item_form', 'class' => 'form-inline', 'autocomplete' => 'off')); ?>
                                <div class="input-group input-group-mobile contacts">
                                    <span class="input-group-text">
                                        <?php echo anchor("items/view/-1/?redirect=receivings/&progression=1", "<i class='icon ti-pencil-alt'></i> <span class='register-btn-text'>" . lang('new_item') . "</span>", array('class' => 'none add-new-item', 'title' => lang('new_item'), 'id' => 'new-item-mobile')); ?>
                                    </span>
                                    <div class="input-group-text register-mode <?php echo $mode; ?>-mode dropdown">
                                        <?php echo anchor("#", "<i class='icon ti-shopping-cart'></i><span class='register-btn-text'>" . $modes[$mode] . "</span>", array('class' => 'none active', 'title' => $modes[$mode], 'id' => 'register-mode-mobile', 'data-target' => '#', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true', 'role' => 'button', 'aria-expanded' => 'false')); ?>
                                        <ul class="dropdown-menu sales-dropdown">
                                            <?php foreach ($modes as $key => $value) {
                                                if ($key != $mode) {
                                            ?>
                                                    <li><a tabindex="-1" href="#" data-mode="<?php echo $key; ?>" class="change-mode"><?php echo $value; ?></a></li>
                                            <?php }
                                            } ?>
                                        </ul>
                                    </div>

                                    <span class="input-group-text grid-buttons <?php echo $mode == 'store_account_payment' ? 'hidden' : ''; ?>">
                                        <?php echo anchor("#", "<i class='icon ti-layout'></i> <span class='register-btn-text'> " . lang('show_grid') . "</span>", array('class' => 'none show-grid', 'title' => lang('show_grid'))); ?>
                                        <?php echo anchor("#", "<i class='icon ti-layout'></i> <span class='register-btn-text'> " . lang('hide_grid') . "</span>", array('class' => 'none hide-grid hidden', 'title' => lang('hide_grid'))); ?>
                                    </span>
                                </div>

                                <div class="input-group contacts  register-input-group d-flex">
                                    <!-- Css Loader  -->
                                    <div class="spinner" id="ajax-loader" style="display:none">
                                        <div class="rect1"></div>
                                        <div class="rect2"></div>
                                        <div class="rect3"></div>
                                    </div>
                                    <span class="input-group-text">
                                        <?php echo anchor("items/view/-1/?redirect=receivings/&progression=1", "<i class='icon ti-pencil-alt'></i>", array('class' => 'none add-new-item', 'title' => lang('new_item'), 'id' => 'new-item')); ?>
                                    </span>

                                    <input type="text" id="item" name="item" <?php echo ($mode == "store_account_payment") ? 'disabled="disabled"' : '' ?> class="add-item-input pull-left keyboardTop" placeholder="<?php echo lang('start_typing_item_name'); ?>" data-title="<?php echo lang('item_name'); ?>" style="width:64%">
                                    <input type="hidden" name="secondary_supplier_id" id="secondary_supplier_id" />
                                    <input type="hidden" name="default_supplier_id" id="default_supplier_id" />
                                    <div class="input-group-text register-mode <?php echo $mode; ?>-mode dropdown">
                                        <?php echo anchor("#", "<i class='icon ti-shopping-cart'></i>" . $modes[$mode], array('class' => 'none active', 'title' => $modes[$mode], 'id' => 'register-mode', 'data-target' => '#', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true', 'role' => 'button', 'aria-expanded' => 'false')); ?>
                                        <ul class="dropdown-menu sales-dropdown">
                                            <?php foreach ($modes as $key => $value) {
                                                if ($key != $mode) {
                                            ?>
                                                    <li><a tabindex="-1" href="#" data-mode="<?php echo $key; ?>" class="change-mode"><?php echo $value; ?></a></li>
                                            <?php }
                                            } ?>
                                        </ul>
                                    </div>

                                    <span class="input-group-text grid-buttons <?php echo $mode == 'store_account_payment' ? 'hidden' : ''; ?>">
                                        <?php echo anchor("#", "<i class='icon ti-layout'></i> " . lang('show_grid'), array('class' => 'none show-grid', 'title' => lang('show_grid'))); ?>
                                        <?php echo anchor("#", "<i class='icon ti-layout'></i> " . lang('hide_grid'), array('class' => 'none hide-grid hidden', 'title' => lang('hide_grid'))); ?>
                                    </span>
                                </div>
</form>
</div>

</div>
</div>
<!--end::Search products-->

<!--begin::Table-->
<div id="kt_ecommerce_edit_order_product_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
    <div class="table-responsive">
        <div class="dataTables_scroll">
         
            <div class="dataTables_scrollBody" style="position: relative; overflow: auto; max-height: 400px; width: 100%;">
              

                <div class="register-items-holder">

				<?php if ($mode != 'store_account_payment') { ?>

					<?php if ($pagination) { ?>
						<div class="page_pagination pagination-top hidden-print  text-center" id="pagination_top">
							<?php echo $pagination; ?>
						</div>
					<?php } ?>

					<?php if ($this->config->item('allow_drag_drop_recv') && !$this->agent->is_mobile() && !$this->agent->is_tablet()) {  ?>

					<style>
						#register tbody{
							cursor: move;
						}
						#register th.item_sort_able{
							cursor: pointer;
						}

						#grid-loader2.spinner > div {
							height: 100px;
							width: 8px;
							margin-right: 2px;
							margin-top: 30px;
							top: 50%;
						}						
					</style>
					<?php } ?>

					<div class="spinner" id="grid-loader2" style="display: none;">
						<div class="rect1"></div>
						<div class="rect2"></div>
						<div class="rect3"></div>
					</div>					
					<table id="register" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_ecommerce_edit_order_product_table" style="width: 100%;">

						<thead>
							<tr class="register-items-header text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0" style="height: 0px;">
								<th><a href="javascript:void(0);" id="sale_details_expand_collapse" class="expand">-</a></th>
								<th class="item_sort_able  text-dark item_name_heading <?php echo $this->cart->sort_column && $this->cart->sort_column == 'name'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('sales_item_name'); ?></th>
								<th class="item_sort_able sales_price <?php echo $this->cart->sort_column && $this->cart->sort_column == 'unit_price'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('receivings_cost'); ?></th>
								<th class="item_sort_able sales_quantity  text-dark<?php echo $this->cart->sort_column && $this->cart->sort_column == 'quantity'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('quantity'); ?></th>
								<th class="item_sort_able sales_discount <?php echo $this->cart->sort_column && $this->cart->sort_column == 'discount'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('discount_percent'); ?></th>
								<th class="item_sort_able sales_total <?php echo $this->cart->sort_column && $this->cart->sort_column == 'total'? ($this->cart->sort_type=='asc'?"ion-arrow-down-b":"ion-arrow-up-b"):"";?>"><?php echo lang('total'); ?></th>
							</tr>
						</thead>


						<?php
						$cart_count = 0;
						if($this->config->item('allow_drag_drop_recv') == 1 && !$this->agent->is_mobile() && !$this->agent->is_tablet()){
							$cart_items = $cart->get_list_sort_by_receipt_sort_order();
						}

						if (count($cart_items) == 0) { ?>
							<tbody class="register-item-content">
								<tr class="cart_content_area">
									<td colspan='6'>
										<div class='text-center text-warning'>
											<h3><?php echo lang('no_items_in_cart'); ?> <span class="flatRedc"> [<?php echo lang('module_receivings') ?>]</span></h3>
										</div>
									</td>
								</tr>
							</tbody>
							<?php
						} else {


							$start_index = $cart->offset + 1;
							$end_index = $cart->offset + $cart->limit;

							$the_cart_row_counter = 1;

							foreach (array_reverse($cart_items, true) as $line => $item) {
								if($this->config->item('allow_drag_drop_recv') == 1 && !$this->agent->is_mobile() && !$this->agent->is_tablet()){
									$line = $item->line_index;
								}
								if ($item->quantity > 0 && $item->name != lang('store_account_payment')) {
									$cart_count = $cart_count + $item->quantity;
								} elseif ($mode == 'transfer') {
									$cart_count = $cart_count + abs($item->quantity);
								}

								if (!(($start_index <= $the_cart_row_counter) && ($the_cart_row_counter <= $end_index))) {
									$the_cart_row_counter++;
									continue;
								}
								$the_cart_row_counter++;

							?>
							<tbody class="register-item-content" data-line="<?php echo $line; ?>">
								<tr class="register-item-details">
									<td class="text-center"> <?php echo anchor("receivings/delete_item_new/$line", '<i class="icon ion-android-cancel"></i>', array('class' => 'delete-item')); ?> </td>
									<td>
										<a tabindex="-1" href="<?php echo isset($item->item_id) ? site_url('home/view_item_modal/' . $item->item_id) . "?redirect=receivings" : site_url('home/view_item_kit_modal/' . $item->item_kit_id) . "?redirect=receivings"; ?>" data-target="#kt_drawer_general" data-target-title="<?= lang('view_item') ?>"  data-target-width="xl"class="register-item-name"><?php echo H($item->name).($item->variation_name ? '<span class="show-collpased" style="display:none">  ['.$item->variation_name.']</span>' : ''); ?><?php echo $item->size ? ' (' . H($item->size) . ')' : ''; ?></a>
									</td>


									<td class="text-center">
										<?php
										if ($has_cost_price_permission) {
										?>
											<?php if ($items_module_allowed) { ?>
												<a href="#" id="unit_price_<?php echo $line; ?>" class="xeditable xeditable-price" data-validate-number="true" data-type="text" data-value="<?php echo H(to_currency_no_money($item->unit_price, 10)); ?>" data-pk="1" data-name="unit_price" data-url="<?php echo site_url('receivings/edit_item/' . $line); ?>" data-title="<?php echo H(lang('price')); ?>"><?php echo to_currency($item->unit_price, 10); ?></a>
										<?php } else {
												echo to_currency($item->unit_price);
											}
										} ?>
									</td>

									<td class="text-center">
										<a href="#" id="quantity_<?php echo $line; ?>" class="xeditable edit-quantity" data-type="text" data-validate-number="true" data-value="<?php echo H(to_quantity($mode == "transfer" ? abs($item->quantity) : $item->quantity)); ?>" data-pk="1" data-name="quantity" data-url="<?php echo site_url('receivings/edit_item/' . $line); ?>" data-title="<?php echo lang('quantity') ?>"><?php echo to_quantity($mode == "transfer" ? abs($item->quantity) : $item->quantity); ?></a>
									</td>

									<td class="text-center">
										<?php if ($line !== $line_for_flat_discount_item && $this->Employee->has_module_action_permission('receivings', 'give_discount', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
											<a href="#" id="discount_<?php echo $line; ?>" class="xeditable" data-type="text" data-validate-number="true" data-pk="1" data-name="discount" data-value="<?php echo H($item->discount); ?>" data-url="<?php echo site_url('receivings/edit_item/' . $line); ?>" data-title="<?php echo lang('discount_percent') ?>"><?php echo to_quantity($item->discount); ?>%</a>
										<?php } else { ?>
											<?php echo to_quantity($item->discount); ?>%
										<?php }	?>
									</td>

									<td class="text-center">

										<?php
										if ($has_cost_price_permission) {
										?>

											<?php if ($items_module_allowed) { ?>
												<a href="#" id="total_<?php echo $line; ?>" class="xeditable" data-type="text" data-validate-number="true" data-pk="1" data-name="total" data-value="<?php echo H(to_currency_no_money($item->unit_price * $item->quantity - $item->unit_price * $item->quantity * $item->discount / 100)); ?>" data-url="<?php echo site_url('receivings/edit_line_total/' . $line); ?>" data-title="<?php echo lang('total') ?>"><?php echo to_currency($item->unit_price * $item->quantity - $item->unit_price * $item->quantity * $item->discount / 100); ?></a>
											<?php } else {
												echo to_currency($item->unit_price * $item->quantity - $item->unit_price * $item->quantity * $item->discount / 100);
											}	?>
										<?php } ?>
									</td>


								</tr>
								<tr class="register-item-bottom">
									<td>&nbsp;</td>
									<td colspan="5">
										<dl class="register-item-extra-details dl-horizontal">

											<?php
											if (count($item->quantity_units) > 0) { ?>
												<dt class=""><?php echo lang('quantity_units'); ?> </dt>
												<dd class="">
													<a href="#" id="quantity_unit_<?php echo $line; ?>" data-name="quantity_unit_id" data-type="select" data-pk="1" data-url="<?php echo site_url('receivings/edit_item/' . $line); ?>" data-title="<?php echo H(lang('quantity_units')); ?>"><?php echo character_limiter(H($item->quantity_unit_id ? $item->quantity_units[$item->quantity_unit_id] : lang('none')), 50); ?></a></dd>
												<?php
												$source_data = array();
												$source_data[] = array('value' => 0, 'text' => lang('none'));

												foreach ($item->quantity_units as $quantity_unit_id => $quantity_unit_name) {
													$source_data[] = array('value' => $quantity_unit_id, 'text' => $quantity_unit_name);
												}
												?>
												<script>
													$('#quantity_unit_<?php echo $line; ?>').editable({
														value: <?php echo (H($item->quantity_unit_id) ? H($item->quantity_unit_id) : 0); ?>,
														source: <?php echo json_encode($source_data); ?>,
														success: function(response, newValue) {
															last_focused_id = $(this).attr('id');
															$("#register_container").html(response);
														}
													});
												</script>
											<?php } ?>
						
											<dt class="list" id="list">
												<?php echo lang('serial_number'); ?>
											</dt>
											<dd class="list">
												<a href="#" id="serialnumber_<?php echo $line; ?>" class="xeditable" data-type="textarea" data-pk="1" data-name="serialnumber" data-value="<?php echo H($item->serialnumber); ?>" data-url="<?php echo site_url('receivings/edit_item/' . $line); ?>" data-title="<?php echo H(lang('serial_number')); ?>"><?php echo character_limiter(H($item->serialnumber), 50); ?></a>
											</dd>

											<script>
												$("#serialnumber_<?php echo $line; ?>")
												  .on("shown", function(ev, editable) {
												    const buttons = editable.container.$form.find(".editable-buttons")[0];
												    buttons.insertAdjacentHTML("beforeend", '<br><button type="submit" class="btn btn-danger btn-sm serial_range editable-submit btn-block margin-top-10"><?php echo lang('range');?></button>')
												  }),

											  	$(".list").on("click", ".serial_range", function() {
												  	bootbox.prompt({
														title: '<?php echo lang('starting_and_ending_range_seprate_by_dash');?> <br> e.g. KT100-KT105 will add the following serial numbers: KT100,KT101,KT102,KT103,KT104,KT105',
														inputType: 'text',
														callback: function(serial_range) {
															if (serial_range) {
																$.post(<?php echo json_encode(site_url('receivings/edit_item/' . $line)); ?>, {
																	name: 'generate_serial_range',
																	value: serial_range
																}, function(response) {
																	$("#register_container").html(response);
																});
															}
														}
													})
												});
											</script>
											<?php if ($cart->get_previous_receipt_id() && $mode !='transfer') { ?>
												<dt><?php echo lang('qty_received'); ?></dt>
												<dd><a href="#" id="quantity_received_<?php echo $line; ?>" class="xeditable" data-type="text" data-validate-number="true" data-pk="1" data-name="quantity_received" data-value="<?php echo H(to_quantity($item->quantity_received)); ?>" data-url="<?php echo site_url('receivings/edit_item/' . $line); ?>" data-title="<?php echo H(lang('qty_received')); ?>"><?php echo H(to_quantity($item->quantity_received)); ?></a></dd>
											<?php } ?>

											<?php if (isset($item->item_id) && $item->item_id) {
												if ($item->variation_id) {
													$item_variation_location_info = $this->Item_variation_location->get_info($item->variation_id, false, true);
													$item_location_info = $this->Item_location->get_info($item->item_id, false, true);

													$cur_quantity = $item_variation_location_info->quantity;
												} else {
													$item_location_info = $this->Item_location->get_info($item->item_id, false, true);

													$cur_quantity = $item_location_info->quantity;
												}

											?>
												<dt><?php echo lang('stock'); ?></dt>
												<dd><?php echo to_quantity($cur_quantity); ?></dd>

												<?php if ($this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id)) {	?>
													<dt><?php echo lang('unit_price'); ?></dt>
													<dd>
														<a href="#" id="selling_price_<?php echo $line; ?>" class="xeditable" data-type="text" data-pk="1" data-name="selling_price" data-value="<?php echo to_currency_no_money($item->selling_price, 10); ?>" data-url="<?php echo site_url('receivings/edit_item/' . $line); ?>" data-title="<?php echo H(lang('unit_price')); ?>"><?php echo to_currency_no_money($item->selling_price, 10) ?></a>
													</dd>

													<?php if ($item_location_info->unit_price != '' && $item_location_info->unit_price !== NULL && (float) $item_location_info->unit_price != (float) $item->selling_price) { ?>
														<dt><?php echo lang('location') . ' ' . lang('unit_price'); ?></dt>
														<dd>
															<?php if ($this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id)) {	?>
																<a href="#" id="location_selling_price_<?php echo $line; ?>" class="xeditable" data-type="text" data-pk="1" data-name="location_selling_price" data-value="<?php echo to_currency_no_money($item->location_selling_price, 10); ?>" data-url="<?php echo site_url('receivings/edit_item/' . $line); ?>" data-title="<?php echo H(lang('location') . ' ' . lang('unit_price')); ?>"><?php echo to_currency_no_money($item->location_selling_price, 10) ?></a>
															<?php
															} else {
															?>
																<?php echo to_currency_no_money($item_location_info->unit_price, 10) ?>
															<?php } ?>
														</dd>

													<?php } ?>
												<?php } ?>
												<?php
												$supplier_name = lang('none');
												$cart_supplier_id = $item->cart_line_supplier_id;
												$variation_choices = $item->variation_choices;

												if (!empty($variation_choices)) { ?>
													<dt class=""><?php echo lang('variation'); ?> </dt>
													<?php
													?>
													<a style="cursor:pointer;" onclick="enable_popup(<?php echo $line; ?>);"><?php echo lang('edit'); ?></a>
													<dd class=""><a href="#" id="variation_<?php echo $line; ?>" data-name="variation" data-type="select" data-pk="1" data-url="<?php echo site_url('receivings/edit_item_variation/' . $line); ?>" data-title="<?php echo H(lang('variation')); ?>"><?php echo character_limiter(H($item->variation_name), 50); ?></a></dd>

													<?php
													$source_data = array();

													foreach ($variation_choices as $variation_id => $variation_name) {
														$variation_info = $this->Item_variations->get_info($variation_id);

														if(isset($item->variation_id)){
															if($variation_id == $item->variation_id){
																if(isset($variation_info->supplier_id)){
																	$cart_supplier_id = $variation_info->supplier_id;
																}
															}
														}

														$temp_supplier = false;
														if(isset($variation_info->supplier_id)){
															$temp_supplier = $this->Supplier->get_name($variation_info->supplier_id);
														}

														if($temp_supplier){
															$source_data[] = array('value' => $variation_id, 'text' => $variation_name.", ".lang("supplier").": ".$temp_supplier);
														}else{
															$source_data[] = array('value' => $variation_id, 'text' => $variation_name);
														}
														
													}
													?>
													<script>
														$('#variation_<?php echo $line; ?>').editable({
															value: <?php echo json_encode(H($item->variation_id) ? H($item->variation_id) : ''); ?>,
															source: <?php echo json_encode($source_data); ?>,
															success: function(response, newValue) {
																last_focused_id = $(this).attr('id');
																$("#register_container").html(response);
															}

														});
													</script>
												<?php } ?>
											<?php } ?>


											<?php 
												
											if($cart_supplier_id && !$this->config->item('hide_supplier_on_recv_interface')){
													$supplier_name =  $this->Supplier->get_name($cart_supplier_id);
											?>
											
											<dt><?php echo lang('supplier'); ?> </dt>

											<dd class=""><a href="#" id="supplier_<?php echo $line; ?>" data-name="supplier" data-type="select" data-pk="1" data-url="<?php echo site_url('receivings/edit_item_supplier/' . $line); ?>" data-title="<?php echo H(lang('supplier')); ?>"><?php echo character_limiter(H($supplier_name), 50); ?></a></dd>

											<?php 
												$source_data = array();
												foreach($this->Item->get_all_suppliers_of_an_item($item->item_id)->result_array() as $row)
												{
													$source_data[] = array('value' => $row['supplier_id'], 'text' => $row['company_name'] .' ('.$row['full_name'].')');
												}
											?>

											<script>
												$('#supplier_<?php echo $line; ?>').editable({
													value: <?php echo json_encode(H($cart_supplier_id) ? H($cart_supplier_id) : ''); ?>,
													source: <?php echo json_encode($source_data); ?>,
													success: function(response, newValue) {
														last_focused_id = $(this).attr('id');
														$("#register_container").html(response);
													}
												});
											</script>
											<?php } ?>

											<?php
											if ($this->config->item('calculate_average_cost_price_from_receivings') && $has_cost_price_permission) {
											?>
												<dt><?php echo lang('receivings_cost_price_preview'); ?></dt>
												<dd><?php echo $item->cost_price_preview; ?></dd>
											<?php
											}
											?>

											<?php if (!$this->config->item('hide_description_on_sales_and_recv')) { ?>
												<dt><?php echo lang('description'); ?></dt>
												<dd>
													<?php if (isset($item->allow_alt_description) && $item->allow_alt_description == 1) { ?>
														<a href="#" id="description_<?php echo $line; ?>" class="xeditable" data-type="text" data-pk="1" data-name="description" data-value="<?php echo clean_html($item->description); ?>" data-url="<?php echo site_url('receivings/edit_item/' . $line); ?>" data-title="<?php echo H(lang('sales_description_abbrv')); ?>"><?php echo clean_html(character_limiter($item->description), 50); ?></a>
													<?php	} else {
														if ($item->description != '') {
															echo clean_html($item->description);
														} else {
															echo lang('none');
														}
													}
													?>
												</dd>
											<?php } ?>

											<?php if ($item->expire_date) { ?>
												<dt><?php echo lang('expire_date'); ?></dt>
												<dd><a href="#" id="expire_date_<?php echo $line; ?>" class="expire_date" data-type="combodate" data-template="<?php echo get_js_date_format(); ?>" data-pk="1" data-name="expire_date" data-value="<?php echo date('Y-m-d', strtotime($item->expire_date)); ?>" data-url="<?php echo site_url('receivings/edit_item/' . $line); ?>" data-title="<?php echo H(lang('expire_date')); ?>"><?php echo H($item->expire_date); ?></a></dd>
											<?php } ?>
											<dt class="visible-lg">
												<?php
												switch ($this->config->item('id_to_show_on_sale_interface')) {
													case 'number':
														echo lang('item_number_expanded');
														break;

													case 'product_id':
														echo lang('product_id');
														break;

													case 'id':
														echo lang('item_id');
														break;

													default:
														echo lang('item_number_expanded');
														break;
												}
												?>
											</dt>
											<dd class="visible-lg">
												<?php
												switch ($this->config->item('id_to_show_on_sale_interface')) {
													case 'number':
														echo property_exists($item,'item_number') ? H($item->item_number) : lang('none');
														break;

													case 'product_id':
														echo property_exists($item,'product_id') ? H($item->product_id) : lang('none');
														break;

													case 'id':
														echo property_exists($item,'item_id') ? H($item->item_id) : lang('none');
														break;

													default:
														echo property_exists($item,'item_number') ? H($item->item_number) : lang('none');
														break;
												}
												?>
											</dd>

											<?php if ($this->config->item('charge_tax_on_recv')) { ?>

												<?php if ($this->Employee->has_module_action_permission('receivings', 'edit_taxes', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>

													<dt><?php echo lang('tax'); ?></dt>
													<dd>
														<a href="<?php echo site_url("receivings/edit_taxes_line/$line") ?>" class="" id="edit_taxes" data-toggle="modal" data-target="#myModal"><?php echo lang('edit_taxes'); ?></a>
													</dd>
												<?php } ?>
											<?php } ?>

										</dl>
									</td>
								</tr>
							</tbody>
						<?php }
						}  ?>
					</table>

					<?php if ($pagination) { ?>
						<div class="page_pagination pagination-top hidden-print  text-center" id="pagination_top">
							<?php echo $pagination; ?>
						</div>
					<?php } ?>

			</div>

			<!-- End of Sales or Return Mode -->
		<?php } else {  ?>

			<table id="register" class="table table-hover ">

				<thead>
					<tr class="register-items-header">
						<th><?php echo lang('receivings_item_name'); ?></th>
						<th><?php echo lang('payment_amount'); ?></th>
						<?php if (!empty($unpaid_store_account_receivings)) { ?>
							<th>&nbsp;</th>
						<?php
						} ?>
					</tr>
				</thead>
				<tbody id="cart_contents">
					<?php
					$cart_count = 0;
					foreach (array_reverse($cart_items, true) as $line => $item) {
					?>

						<tr id="reg_item_top">
							<td class="text text-center text-success"><a tabindex="-1" href="<?php echo isset($item->item_id) ? site_url('home/view_item_modal/' . $item->item_id) . "?redirect=receivings" : site_url('home/view_item_kit_modal/' . $item->item_kit_id) . "?redirect=receivings"; ?>" data-target="#kt_drawer_general" data-target-title="<?= lang('view_item') ?>"  data-target-width="xl"><?php echo H($item->name); ?></a></td>
							<td class="text-center">
								<?php
								echo form_open("receivings/edit_item/$line", array('class' => 'line_item_form', 'autocomplete' => 'off'));

								?>

								<a href="#" id="unit_price_<?php echo $line; ?>" class="xeditable" data-validate-number="true" data-type="text" data-value="<?php echo H(to_currency_no_money($item->unit_price, 10)); ?>" data-pk="1" data-name="unit_price" data-url="<?php echo site_url('receivings/edit_item/' . $line); ?>" data-title="<?php echo H(lang('price')); ?>"><?php echo to_currency_no_money($item->unit_price, 10); ?></a>
								<?php
								echo form_hidden('quantity', to_quantity($item->quantity));
								echo form_hidden('description', '');
								echo form_hidden('serialnumber', '');
								?>

								</form>
							</td>
							<?php if (!empty($unpaid_store_account_receivings)) {
								$pay_all_btn_class = count($paid_store_account_ids) > 0 ? 'btn-danger' : 'btn-primary';
								$pay_all_btn_text = count($paid_store_account_ids) > 0 ? lang('unpay_all') : lang('pay_all');
							?>
								<td>
									<button id="pay_or_unpay_all" type="submit" class="btn <?php echo $pay_all_btn_class; ?> pay_store_account_sale pull-right"><?php echo $pay_all_btn_text ?></button>
								</td>
							<?php } ?>
						</tr>
					<?php } /*Foreach*/ ?>
				</tbody>
			</table>

		</div>

	<?php }  ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div>
        <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"></div>
    </div>
</div>
<!--end::Table-->
</div>
</div>
<!--end::Card header-->
</div>
<!--end::Order details-->

<!--begin::Order details-->
<div class="card card-flush py-4">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">
            <h2>Delivery Details</h2>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Billing address-->
        <div class="d-flex flex-column gap-5 gap-md-7">
            <!--begin::Title-->
            <div class="fs-3 fw-bold mb-n2">Billing Address</div>
            <!--end::Title-->

            <!--begin::Input group-->
            <div class="d-flex flex-column flex-md-row gap-5">
                <div class="fv-row flex-row-fluid fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required form-label">Address Line 1</label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <input class="form-control" name="billing_order_address_1" placeholder="Address Line 1" value="">
                    <!--end::Input-->
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>

                <div class="flex-row-fluid">
                    <!--begin::Label-->
                    <label class="form-label">Address Line 2</label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <input class="form-control" name="billing_order_address_2" placeholder="Address Line 2">
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="d-flex flex-column flex-md-row gap-5">
                <div class="flex-row-fluid">
                    <!--begin::Label-->
                    <label class="form-label">City</label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <input class="form-control" name="billing_order_city" placeholder="" value="">
                    <!--end::Input-->
                </div>

                <div class="fv-row flex-row-fluid fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required form-label">Postcode</label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <input class="form-control" name="billing_order_postcode" placeholder="" value="">
                    <!--end::Input-->
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>

                <div class="fv-row flex-row-fluid fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required form-label">State</label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <input class="form-control" name="billing_order_state" placeholder="" value="">
                    <!--end::Input-->
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>
            </div>
            <!--end::Input group-->



            <!--begin::Checkbox-->
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" value="" id="same_as_billing" checked="">
                <label class="form-check-label" for="same_as_billing">
                    Shipping address is the same as billing address
                </label>
            </div>
            <!--end::Checkbox-->

            <!--begin::Shipping address-->
            <div class="d-none d-flex flex-column gap-5 gap-md-7" id="kt_ecommerce_edit_order_shipping_form">
                <!--begin::Title-->
                <div class="fs-3 fw-bold mb-n2">Shipping Address</div>
                <!--end::Title-->

                <!--begin::Input group-->
                <div class="d-flex flex-column flex-md-row gap-5">
                    <div class="fv-row flex-row-fluid">
                        <!--begin::Label-->
                        <label class="form-label">Address Line 1</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input class="form-control" name="kt_ecommerce_edit_order_address_1" placeholder="Address Line 1" value="">
                        <!--end::Input-->
                    </div>

                    <div class="flex-row-fluid">
                        <!--begin::Label-->
                        <label class="form-label">Address Line 2</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input class="form-control" name="kt_ecommerce_edit_order_address_2" placeholder="Address Line 2">
                        <!--end::Input-->
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="d-flex flex-column flex-md-row gap-5">
                    <div class="flex-row-fluid">
                        <!--begin::Label-->
                        <label class="form-label">City</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input class="form-control" name="kt_ecommerce_edit_order_city" placeholder="" value="">
                        <!--end::Input-->
                    </div>

                    <div class="fv-row flex-row-fluid">
                        <!--begin::Label-->
                        <label class="form-label">Postcode</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input class="form-control" name="kt_ecommerce_edit_order_postcode" placeholder="" value="">
                        <!--end::Input-->
                    </div>

                    <div class="fv-row flex-row-fluid">
                        <!--begin::Label-->
                        <label class="form-label">State</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input class="form-control" name="kt_ecommerce_edit_order_state" placeholder="" value="">
                        <!--end::Input-->
                    </div>
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Shipping address-->
        </div>
        <!--end::Billing address-->


    </div>
    <!--end::Card body-->
</div>
<!--end::Order details-->
<div class="d-flex justify-content-end">
    <!--begin::Button-->
    <a href="/good/apps/ecommerce/catalog/products.html" id="kt_ecommerce_edit_order_cancel" class="btn btn-light me-5">
        Cancel
    </a>
    <!--end::Button-->

    <!--begin::Button-->
    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
        <span class="indicator-label">
            Save Changes
        </span>
        <span class="indicator-progress">
            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
    </button>
    <!--end::Button-->
</div>
</div>
<!--end::Main column-->
                                        </div>


<script type="text/javascript">
$(document).ready(function()
{
	$(window).load(function()
	{
		setTimeout(function()
		{
		<?php if ($fullscreen) { ?>
			$('.fullscreen').click();
		<?php }
		else {
		?>
		$('.dismissfullscreen').click();	
		<?php
		} ?>
		
		}, 0);
	});	
	<?php if ($this->config->item('always_show_item_grid') && $mode != 'store_account_payment') { ?>
		$(".show-grid").click();
	<?php } ?>
	
 	var current_category_id = null;
	var current_tag_id = null;
	var current_supplier_id = null;
	
  var categories_stack = [{category_id: 0, name: <?php echo json_encode(lang('all')); ?>}];
  
  function updateBreadcrumbs(item_name)
  {
     var breadcrumbs = '';
     for(var k = 0; k< categories_stack.length;k++)
     {
       var category_name = categories_stack[k].name;
       var category_id = categories_stack[k].category_id;
   
       breadcrumbs += (k != 0 ? ' &raquo ' : '' )+'<a href="javascript:void(0);"class="category_breadcrumb_item" data-category_id = "'+category_id+'">'+category_name+"</a>";
     }
 		 
		 if (typeof item_name != "undefined" && item_name)
		 {
		 	 breadcrumbs +=' &raquo '+item_name;
		 }
		 
     $("#grid_breadcrumbs").html(breadcrumbs);		  
  }
  
  $(document).on('click', ".category_breadcrumb_item",function()
  {
      var clicked_category_id = $(this).data('category_id');      
      var categories_size = categories_stack.length;
      current_category_id = clicked_category_id;
      
      for(var k = 0; k< categories_size; k++)
      {
        var current_category = categories_stack[k]
        var category_id = current_category.category_id;
        
        if (category_id == clicked_category_id)
        {
          if (categories_stack[k+1] != undefined)
          {
            categories_stack.splice(k+1,categories_size - k - 1);
          }
          break;
        }
      }
      
      if (current_category_id != 0)
      {
        loadCategoriesAndItems(current_category_id,0);
      }
      else
      {
        loadTopCategories();
      }
  });
  
	function loadTopCategories()
	{    
		$('#grid-loader').show();
		$.get('<?php echo site_url("receivings/categories");?>', function(json)
		{
			processCategoriesResult(json);
		}, 'json');	
	}
	
	function loadTags()
	{
		$('#grid-loader').show();
		$.get('<?php echo site_url("receivings/tags");?>', function(json)
		{
			processTagsResult(json);
		}, 'json');	
	}

	function loadSuppliers() {
		$('#grid-loader').show();
		$.get('<?php echo site_url("receivings/suppliers"); ?>', function(json) {
			processSuppliersResult(json);
		}, 'json');
	}
  
  function loadCategoriesAndItems(category_id, offset)
  {
	  $('#grid-loader').show();
    current_category_id = category_id;
    //Get sub categories then items
    $.get('<?php echo site_url("receivings/categories_and_items");?>/'+current_category_id+'/'+offset, function(json)
    {
        processCategoriesAndItemsResult(json);
    }, "json");
  }
	
	function loadCategoriesAndItemsUrl(category_id, url)
	{
    $('#grid-loader').show();
    current_category_id = category_id;
    //Get sub categories then items
    $.get(url, function(json)
    {
        processCategoriesAndItemsResult(json);
    }, "json");
	}
  
  function loadTagItems(tag_id, offset)
  {
	  $('#grid-loader').show();
	  current_tag_id = tag_id;
     //Get sub categories then items
     $.get('<?php echo site_url("receivings/tag_items");?>/'+tag_id+'/'+offset, function(json)
     {
         processTagItemsResult(json);
     }, "json");
  }
	
	function loadTagItemsUrl(tag_id, url)
	{
    $('#grid-loader').show();
 	 current_tag_id = tag_id;
    //Get sub categories then items
    $.get(url, function(json)
    {
        processTagItemsResult(json);
    }, "json");
	}
	
  function loadFavoriteItems(offset)
  {
     $('#grid-loader').show();
     //Get sub categories then items
     $.get('<?php echo site_url("sales/favorite_items");?>/'+offset, function(json)
     {
         processFavoriteItemsResult(json);
     }, "json");
  }
  
	function loadFavoriteItemsUrl(url)
	{
    $('#grid-loader').show();
    $.get(url, function(json)
    {
        processFavoriteItemsResult(json);
    }, "json");
	}

	function loadSupplierItem(supplier_id, offset) {
		$('#grid-loader').show();
		current_supplier_id = supplier_id;
		//Get sub categories then items
		$.get('<?php echo site_url("receivings/supplier_items"); ?>/' + supplier_id + '/' + offset, function(json) {
			processSupplierItemsResult(json);
		}, "json");
	}

	function loadSupplierItemsUrl(supplier_id, url) {
		$('#grid-loader').show();
		current_supplier_id = supplier_id;
		//Get sub categories then items
		$.get(url, function(json) {
			processSupplierItemsResult(json);
		}, "json");
	}

	$(document).on('click', ".pagination.categories a", function(event)
	{
		$('#grid-loader').show();
		event.preventDefault();	
		$.get($(this).attr('href'), function(json)
		{
			processCategoriesResult(json);
      
		}, "json");
	});
	
	$(document).on('click', ".pagination.tags a", function(event)
	{
		$('#grid-loader').show();
		event.preventDefault();
	
		$.get($(this).attr('href'), function(json)
		{
			processTagsResult(json);
      
		}, "json");
	});

	$(document).on('click', ".pagination.suppliers a", function(event) {
		$('#grid-loader').show();
		event.preventDefault();

		$.get($(this).attr('href'), function(json) {
			processSuppliersResult(json);

		}, "json");
	});
  
	$(document).on('click', ".pagination.categoriesAndItems a", function(event)
	{
		$('#grid-loader').show();
		event.preventDefault();
		loadCategoriesAndItemsUrl(current_category_id, $(this).attr('href'));
	});
	 
 	$(document).on('click', ".pagination.items a", function(event)
 	{
 		$('#grid-loader').show();
 		event.preventDefault();
 	  loadTagItemsUrl(current_tag_id, $(this).attr('href'));
 	 });

 	$(document).on('click', ".pagination.favorite a", function(event)
 	{
 		$('#grid-loader').show();
 		event.preventDefault();
 	  loadFavoriteItemsUrl($(this).attr('href'));
 	});

	 $(document).on('click', ".pagination.supplierItems a", function(event) {
		$('#grid-loader').show();
		event.preventDefault();
		loadSupplierItemsUrl(current_supplier_id, $(this).attr('href'));
	});

	$('#category_item_selection_wrapper').on('click','.category_item.category', function(event)
	{
      event.preventDefault();
      current_category_id = $(this).data('category_id');
      var category_obj = {category_id: current_category_id, name: $(this).find('p').text()};
      categories_stack.push(category_obj);
      loadCategoriesAndItems($(this).data('category_id'), 0);
	});
	
	$('#category_item_selection_wrapper').on('click','.category_item.tag', function(event)
	{
      event.preventDefault();
		current_tag_id = $(this).data('tag_id');
      loadTagItems($(this).data('tag_id'), 0);
	});

	$('#category_item_selection_wrapper').on('click', '.category_item.supplier', function(event) {
		event.preventDefault();
		current_supplier_id = $(this).data('supplier_id');
		loadSupplierItem($(this).data('supplier_id'), 0);
	});
	
	$('#category_item_selection_wrapper').on('click','#by_category', function(event)
	{
	 	current_category_id = null;
		current_tag_id = null;
		$('.btn-grid').removeClass('active');
		$(this).addClass('active');
		$("#grid_breadcrumbs").html('');
		categories_stack = [{category_id: 0, name: <?php echo json_encode(lang('all')); ?>}];
		loadTopCategories();
	});
	
	$('#category_item_selection_wrapper').on('click','#by_tag', function(event)
	{
	 	current_category_id = null;
		current_tag_id = null;
		$('.btn-grid').removeClass('active');
		$(this).addClass('active');
		$("#grid_breadcrumbs").html('');
		loadTags();
	});
	
	$('#category_item_selection_wrapper').on('click','#by_favorite', function(event)
	{
	 	current_category_id = null;
		current_tag_id = null;
		$('.btn-grid').removeClass('active');
		$(this).addClass('active');
		$("#grid_breadcrumbs").html('');
		loadFavoriteItems(0);
	});

	$('#category_item_selection_wrapper').on('click', '#by_supplier', function(event) {
		current_category_id = null;
		current_tag_id = null;
		current_supplier_id = null;
		$("#grid_breadcrumbs").html('');
		$('.btn-grid').removeClass('active');
		$(this).addClass('active');
		loadSuppliers();
	});
	
	$('#category_item_selection_wrapper').on('click','.category_item.item', function(event)
	{		
		$('#grid-loader').show();
		event.preventDefault();
		
		var $that = $(this);
		if($(this).data('has-variations'))
		{
   	 $.post('<?php echo site_url("receivings/add_new");?>', {item: $(this).data('id')+"|FORCE_ITEM_ID|" }, function(response)
			{
				<?php
				if (!$this->config->item('disable_sale_notifications')) 
				{
					echo "show_feedback('success', ".json_encode(lang('successful_adding')).", ".json_encode(lang('success')).");";
				}
				?>
				$('#grid-loader').hide();			
				$("#register_container").html(response);
				$('.show-grid').addClass('hidden');
				$('.hide-grid').removeClass('hidden');
			});
		}
		else
		{
			$.post('<?php echo site_url("receivings/add_new");?>', {item: $(this).data('id')+"|FORCE_ITEM_ID|" }, function(response)
			{
				<?php  
				if (!$this->config->item('disable_sale_notifications')) 
				{
					echo "show_feedback('success', ".json_encode(lang('successful_adding')).", ".json_encode(lang('success')).");";
				}
				?>
				$('#grid-loader').hide();			
				$("#register_container").html(response);
				$('.show-grid').addClass('hidden');
				$('.hide-grid').removeClass('hidden');
			});
		}
	});

	$("#category_item_selection_wrapper").on('click', '#back_to_categories', function(event)
	{ 
		$('#grid-loader').show();		
		event.preventDefault();
    //Remove element from stack
    categories_stack.pop();
    
    //Get current last element
    var back_category = categories_stack[categories_stack.length - 1];
    
    if (back_category.category_id != 0)
    {
      loadCategoriesAndItems(back_category.category_id,0);
    }
    else 
    {
      loadTopCategories();
    }
  });
  
	$("#category_item_selection_wrapper").on('click', '#back_to_tags', function(event)
	{ 
		$('#grid-loader').show();
		event.preventDefault();
	   loadTags();
	});
	
	$("#category_item_selection_wrapper").on('click', '#back_to_tag', function(event)
	{ 
		$('#grid-loader').show();
		event.preventDefault();
		loadTagItems(current_tag_id,0);
		});

	$("#category_item_selection_wrapper").on('click', '#back_to_category', function(event)
	{ 
		$('#grid-loader').show();		
		event.preventDefault();
    
    //Get current last element
    var back_category = categories_stack[categories_stack.length - 1];
    
    if (back_category.category_id != 0)
    {
      loadCategoriesAndItems(back_category.category_id,0);
    }
    else 
    {
      loadTopCategories();
    }
	});
	
	$("#category_item_selection_wrapper").on('click', '#back_to_favorite', function(event)
	{ 
		$('#grid-loader').show();
		event.preventDefault();
		loadFavoriteItems(0);
	});

	$("#category_item_selection_wrapper").on('click', '#back_to_suppliers', function(event) {
		$('#grid-loader').show();
		event.preventDefault();
		loadSuppliers();
	});

	$("#category_item_selection_wrapper").on('click', '#back_to_supplier', function(event) {
		$('#grid-loader').show();
		event.preventDefault();
		loadSuppliersItems(current_supplier_id, 0);
	});
	
  

	function processCategoriesResult(json) {
			$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('tags').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('categories');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			$("#category_item_selection").html('');

			for (var k = 0; k < json.categories.length; k++) {
				var category_item = $("<div/>").attr('class', 'category_item category col-md-2 register-holder categories-holder col-sm-3 col-xs-6').css('background-color', json.categories[k].color).data('category_id', json.categories[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.categories[k].name + '</p>');

				if (json.categories[k].image_id) {
					category_item.css('background-color', 'white');
					category_item.css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.categories[k].image_id + '?timestamp=' + json.categories[k].image_timestamp + ')');
				}
			category_item = '<li data-category_id="'+json.categories[k].id+'" class=" col-1 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.categories[k].image_id + '?timestamp=' + json.categories[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


				$("#category_item_selection").append(category_item);
			}
			
			updateBreadcrumbs();
			$('#grid-loader').hide();
		}
	
	
		function processTagsResult(json) {
			$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('categories').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('tags');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			$("#category_item_selection").html('');

			for (var k = 0; k < json.tags.length; k++) {
				//var tag_item = $("<div/>").attr('class', 'category_item tag col-md-2 register-holder tags-holder col-sm-3 col-xs-6').data('tag_id', json.tags[k].id).append('<p> <i class="ion-ios-pricetag-outline"></i> ' + json.tags[k].name + '</p>');

				var tag_item = '<li data-tag_id="'+json.tags[k].id+'"  class=" col-1  category_item tag register-holder tags-holder  nav-item mb-3 me-3 me-lg-6" role="presentation"><div class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active " data-bs-toggle="pill"  aria-selected="true" role="tab"><div class="nav-icon"><i class="ion-ios-pricetag-outline text-danger " style="font-size:60px"></i> </div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.tags[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></div></li>';

				$("#category_item_selection").append(tag_item);
			}

			$('#grid-loader').hide();
		}

	function processSuppliersResult(json) {
		$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('tags').removeClass('items').removeClass('categories').removeClass("supplierItems").addClass('suppliers');
		$("#category_item_selection_wrapper .pagination").html(json.pagination);

		$("#category_item_selection").html('');

		for (var k = 0; k < json.suppliers.length; k++) {
			// var supplier_item = $("<div/>").attr('class', 'category_item supplier col-md-2 register-holder categories-holder col-sm-3 col-xs-6').data('supplier_id', json.suppliers[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.suppliers[k].name + '</p>');

			// if (json.suppliers[k].image_id) {
			// 	supplier_item.css('background-color', 'white');
			// 	supplier_item.css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.suppliers[k].image_id + '?timestamp=' + json.suppliers[k].image_timestamp + ')');
			// }

			supplier_item = '<li data-supplier_id="'+json.suppliers[k].id+'" class=" col-1 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.suppliers[k].image_id + '?timestamp=' + json.suppliers[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.suppliers[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


			$("#category_item_selection").append(supplier_item);
		}
		$('#grid-loader').hide();
	}
  
	function processCategoriesAndItemsResult(json) {

console.log("ss" , json);
$("#category_item_selection").html('');
$("#category_item_selection_wrapper_new").html('');

var	back_to_categories_button = '<li id="back_to_categories" class=" col-1  nav-item mb-3 me-3 pr-0 pl-0 register-holder" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

$("#category_item_selection").append(back_to_categories_button);

for (var k = 0; k < json.categories_and_items.length; k++) {
	if (json.categories_and_items[k].type == 'category') {
		// var category_item = $("<div/>").attr('class', 'category_item category col-md-2 register-holder categories-holder col-sm-3 col-xs-6').css('background-color', json.categories_and_items[k].color).css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.categories_and_items[k].image_id + '?timestamp=' + json.categories_and_items[k].image_timestamp + ')').data('category_id', json.categories_and_items[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.categories_and_items[k].name + '</p>');

		var category_item = '<li data-category_id="'+json.categories_and_items[k].id+'" class=" col-1 category_item category nav-item mb-3 me-3  pr-0 pl-0" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4 " alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.categories_and_items[k].image_id + '?timestamp=' + json.categories_and_items[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-8 lh-1"><p>' + json.categories_and_items[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


		$("#category_item_selection").append(category_item);
	} else if (json.categories_and_items[k].type == 'item') {
		var image_src = json.categories_and_items[k].image_src;
		var has_variations = json.categories_and_items[k].has_variations ? 1 : 0;

		var prod_image = "";
		var image_class = "no-image";
		var item_parent_class = "";
		if (image_src != '') {
			var item_parent_class = "item_parent_class";
			var prod_image = '<img class="rounded-3 mb-4 h-auto" src="' + image_src + '" alt="" />';
			var image_class = "has-image";
		}else{
						image_src = '' + SITE_URL + '/assets/css_good/media/placeholder.png';
					}

		  var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.categories_and_items[k].id).append(prod_image + '<p>' + json.categories_and_items[k].name + '<br /> <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>');

		var item = '<li data-has-variations="'+has_variations+'" data-id="'+json.categories_and_items[k].id+'" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories_and_items[k].name + '  <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
		$("#category_item_selection").append(item);

		//htm='<div class="col-sm-2  mb-2 col-xxl-2 category_item item  register-holder ' + image_class + ' '+ item_parent_class +' " data-has-variations="'+has_variations+'"  data-id="'+json.categories_and_items[k].id+'" "><div class="card card-flush bg-white h-xl-100"><!--begin::Body--><div class="card-body text-center pb-5"><!--begin::Overlay--><div class="d-block overlay" ><!--begin::Image--><div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded mb-7" style="height: 90px;background-image:url('+image_src+')"></div><!--end::Image--><!--begin::Action--><div class="overlay-layer card-rounded bg-dark bg-opacity-25"><i class="bi  fs-2x text-white"></i></div><!--end::Action--></div><!--end::Overlay--><!--begin::Info--><span class="fw-bold text-left text-gray-800 cursor-pointer text-hover-primary fs-6 d-block">' + json.categories_and_items[k].name + '</span><div class="d-flex align-items-end flex-stack mb-1"><!--begin::Title--><div class="text-start"><span class="text-gray-400 mt-1 fw-bold fs-6">Price</span></div><!--end::Title--><!--begin::Total--><span class="text-gray-600 text-end fw-bold fs-6">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span><!--end::Total--></div><!--end::Info--></div><!--end::Body--></div><!--end::Card widget 14--></div>';
		//$("#category_item_selection").append(htm);

	}
}



$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('items').removeClass('favorite').removeClass('suppliers').removeClass("supplierItems").addClass('categoriesAndItems');
$("#category_item_selection_wrapper .pagination").html(json.pagination);

updateBreadcrumbs();
$('#grid-loader').hide();

}
  
  function processTagItemsResult(json)
  {
 	 $("#category_item_selection").html('');
     var back_to_categories_button = $("<div/>").attr('id', 'back_to_tags').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; '+<?php echo json_encode(lang('back_to_tags')); ?>+'</p>');
     $("#category_item_selection").append(back_to_categories_button);

     for(var k=0;k<json.items.length;k++)
     {
 	       var image_src = json.items[k].image_src;
      	 var has_variations = json.items[k].has_variations ? 1 : 0;
 	       var prod_image = "";
 	       var image_class = "no-image";
 	       var item_parent_class = "";
 	       if (image_src != '' ) {
 	         var item_parent_class = "item_parent_class";
 	         var prod_image = '<img src="'+image_src+'" alt="" />';
 	         var image_class = "";
 	       }
      
 	       var item = $("<div/>").attr('data-has-variations',has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  '+item_parent_class).attr('data-id', json.items[k].id).append(prod_image+'<p>'+json.items[k].name+'<br /> <span class="text-bold">'+(json.items[k].price ? '('+json.items[k].price+')' : '')+'</span></p>');
 	       $("#category_item_selection").append(item);
		 	
 	 }
	 	 
     $("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('suppliers').removeClass("supplierItems").addClass('items');
     $("#category_item_selection_wrapper .pagination").html(json.pagination);

     $('#grid-loader').hide();
  }
  
  function processFavoriteItemsResult(json)
  {
 	 $("#category_item_selection").html('');
     for(var k=0;k<json.items.length;k++)
     {
 	       var image_src = json.items[k].image_src;
      	 var has_variations = json.items[k].has_variations ? 1 : 0;
 	       var prod_image = "";
 	       var image_class = "no-image";
 	       var item_parent_class = "";
 	       if (image_src != '' ) {
 	         var item_parent_class = "item_parent_class";
 	         var prod_image = '<img src="'+image_src+'" alt="" />';
 	         var image_class = "";
 	       }
      
 	    //    var item = $("<div/>").attr('data-is_favorite','yes').attr('data-has-variations',has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  '+item_parent_class).attr('data-id', json.items[k].id).append(prod_image+'<p>'+json.items[k].name+'<br /> <span class="text-bold">'+(json.items[k].price ? '('+json.items[k].price+')' : '')+'</span></p>');

			item = '<li data-supplier_id="'+json.items[k].id+'" class=" col-1 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + image_src + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.items[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


 	       $("#category_item_selection").append(item);
		 	
 	 	 }
	 	 
     $("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('favorite');
     $("#category_item_selection_wrapper .pagination").html(json.pagination);

     $('#grid-loader').hide();
  }

  	function processSupplierItemsResult(json) {
		$("#category_item_selection").html('');
		var back_to_categories_button = $("<div/>").attr('id', 'back_to_suppliers').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back_to_suppliers')); ?> + '</p>');
		$("#category_item_selection").append(back_to_categories_button);

		for (var k = 0; k < json.items.length; k++) {
			var image_src = json.items[k].image_src;
			var has_variations = json.items[k].has_variations ? 1 : 0;
			var prod_image = "";
			var image_class = "no-image";
			var item_parent_class = "";
			if (image_src != '') {
				var item_parent_class = "item_parent_class";
				var prod_image = '<img src="' + image_src + '" alt="" />';
				var image_class = "";
			}

			var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.items[k].id).append(prod_image + '<p>' + json.items[k].name + '<br /> <span class="text-bold">' + (json.items[k].price ? '(' + json.items[k].price + ')' : '') + '</span></p>');
			$("#category_item_selection").append(item);

		}

		$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('favorite').removeClass('suppliers').removeClass('items').addClass("supplierItems");
		$("#category_item_selection_wrapper .pagination").html(json.pagination);

		$('#grid-loader').hide();
	}
  
	<?php if ($this->config->item('default_type_for_grid') == 'tags') {  ?>
		loadTags();
	<?php } else if ($this->config->item('default_type_for_grid') == 'favorites') { ?>
		loadFavoriteItems(0);
	<?php } else if ($this->config->item('default_type_for_grid') == 'suppliers') { ?>
		loadSuppliers();
	<?php } else { ?>
		loadTopCategories();
	<?php	} ?>
	});

<?php if (!$this->agent->is_mobile()) { ?>
	var last_focused_id = null;
	
	setTimeout(function(){$('#item').focus();}, 10);
<?php } ?>
</script>

<script>
//Keyboard events...only want to load once
$(document).keyup(function(event)
{
	var mycode = event.keyCode;
	
	//tab
	if (mycode == 9)
	{
		var $tabbed_to = $(event.target);
		
		if ($tabbed_to.hasClass('xeditable'))
		{
			$tabbed_to.trigger('click').editable('show');
		}
	}

});

$(document).on('mouseover', ".register-holder.item.has-image",function()
{
	$(this).find('p').css('visibility','hidden');
});

$(document).on('mouseout', ".register-holder.item.has-image",function()
{
	$(this).find('p').css('visibility','visible');
});

</script>
<script>
	function fetch_attr_values($attr_id) {
		jQuery('#choose_var').modal('show');
		jQuery.ajax({
			url: "<?php echo site_url('receivings/get_attributes_values'); ?>",
			data: {
				"attr_id": $attr_id
			},
			cache: false,
			success: function(response) {
				jQuery(".customer-recent-sales .modal-body .placeholder_attribute_vals").html(response);
				$('#choose_var').load();
			}
		});
	}

	function fetch_attr_value($attr_id) {
		jQuery.ajax({
			url: "<?php echo site_url('receivings/get_attributes_values'); ?>",
			data: {
				"attr_id": $attr_id
			},
			cache: false,
			success: function(html) {
				jQuery(".customer-recent-sales .modal-body .placeholder_attribute_vals").html(html);

				// location.reload();
			}
		});
	}

	function enable_popup($attr_id) {
		jQuery('#choose_var').modal('show');
		jQuery.ajax({
			url: "<?php echo site_url('receivings/get_attribute_values'); ?>",
			data: {
				"attr_id": $attr_id
			},
			cache: false,
			success: function(response) {
				jQuery(".customer-recent-sales .modal-body .placeholder_attribute_vals").html(response);

			}
		});
	}
	// Look up receipt form handling

	$('#look-up-receipt').on('shown.bs.modal', function() {
		$('#receiving_id').focus();
	});

	$('.look-up-receipt-form').on('submit', function(e) {
		e.preventDefault();

		$('.look-up-receipt-form').ajaxSubmit({
			success: function(response) {
				if (response.success) {
					window.location.href = '<?php echo site_url("receivings/receipt"); ?>/' + response.receiving_id;
				} else {
					$('.look-up-receipt-error').html(response.message);
				}
			},
			dataType: 'json'
		});
	});
	<?php
	if (isset($prompt_convert_sale_to_return) && $prompt_convert_sale_to_return == TRUE) {
	?>

		bootbox.confirm({
			message: <?php echo json_encode(lang("receivings_confirm_convert_sale_to_return")); ?>,
			buttons: {
				confirm: {
					label: <?php echo json_encode(lang('yes')) ?>,
					className: 'btn-primary'
				},
				cancel: {
					label: <?php echo json_encode(lang('no')) ?>,
					className: 'btn-default'
				}
			},
			callback: function(result) {
				if (result) {
					$.get('<?php echo site_url("receivings/convert_sale_to_return"); ?>', function(response) {
						$("#register_container").html(response);
					});
				}
			}
		});

	<?php
	}
	?>


	<?php
	if (isset($prompt_convert_return_to_sale) && $prompt_convert_return_to_sale == TRUE) {
	?>

		bootbox.confirm({
			message: <?php echo json_encode(lang("receivings_confirm_convert_return_to_sale")); ?>,
			buttons: {
				confirm: {
					label: <?php echo json_encode(lang('yes')) ?>,
					className: 'btn-primary'
				},
				cancel: {
					label: <?php echo json_encode(lang('no')) ?>,
					className: 'btn-default'
				}
			},
			callback: function(result) {
				if (result) {
					$.get('<?php echo site_url("receivings/convert_return_to_sale"); ?>', function(response) {
						$("#register_container").html(response);
					});
				}
			}
		});

	<?php
	}
	?>
</script>

<?php if ($this->config->item('confirm_error_adding_item') && isset($error)) { ?>
	<script type="text/javascript">
		bootbox.confirm(<?php echo json_encode($error); ?>, function(result) {
			setTimeout(function() {
				$('#item').focus();
			}, 50);
		});
	</script>
<?php } ?>

<script type="text/javascript">
	<?php
	if (isset($error) && !$this->config->item('confirm_error_adding_item')) {
		echo "show_feedback('error', " . json_encode($error) . ", " . json_encode(lang('error')) . ");";
	}

	if(isset($vendor_search) && count($vendor_search) > 0){
	?>
		setTimeout(function(){
			var search_item_key = localStorage.getItem('item_search_key');
			if(search_item_key.trim() != ""){

				$("#add_item_form #item").val(search_item_key);
				bootbox.dialog({
					message: '<?php echo lang("sales_ask_search_in_other_vendors"); ?>',
					size: 'large',
					onEscape: true,
					backdrop: true,
					buttons: {
						<?php
						if(in_array("ig_api_bearer_token", $vendor_search)){
						?>
						api_ig: {
							label: 'Injured Gadgets',
							className: 'btn-info',
							callback: function(){

								$("#item").autocomplete('option', 'source', '<?php echo site_url("home/sync_ig_item_search"); ?>');

								$("#item").autocomplete('option', 'response', 
									function(event, ui){
										$("#add_item_form .spinner").hide();
										var source_url = $("#item").autocomplete('option', 'source');

										if(ui.content.length == 0 && (source_url.indexOf('sales/item_search') > -1) && $("#add_item_form #item").val().trim() != "" ){

										}else if(ui.content.length == 0 && (source_url.indexOf('home/sync_ig_item_search') > -1)){
											var noResult = {
												value:"",
												image:"<?php echo base_url()."assets/img/item.png"; ?>",
												label:"<?php echo lang("sales_no_result_found_ig"); ?>" 
											};
											ui.content.push(noResult);
											$("#item").autocomplete('option', 'source', '<?php echo site_url("sales/item_search"); ?>');
										}else{
											$("#item").autocomplete('option', 'source', '<?php echo site_url("sales/item_search"); ?>');
										}
									}
								);

								$("#item").autocomplete('search');
								$("#add_item_form .spinner").show();

							}
						},
						<?php
						}
						if(in_array("wgp_integration_pkey", $vendor_search)){
						?>
						api_wgp: {
							label: 'WGP',
							className: 'btn-info',
							callback: function(){

								$("#item").autocomplete('option', 'source', '<?php echo site_url("home/sync_wgp_inventory_search"); ?>');

								$("#item").autocomplete('option', 'response', 
									function(event, ui){
										$("#add_item_form .spinner").hide();
										var source_url = $("#item").autocomplete('option', 'source');

										if(ui.content.length == 0 && (source_url.indexOf('sales/item_search') > -1) && $("#add_item_form #item").val().trim() != "" ){

										}else if(ui.content.length == 0 && (source_url.indexOf('home/sync_wgp_inventory_search') > -1)){
											var noResult = {
												value:"",
												image:"<?php echo base_url()."assets/img/item.png"; ?>",
												label:"<?php echo lang("sales_no_result_found_wgp"); ?>" 
											};
											ui.content.push(noResult);
											$("#item").autocomplete('option', 'source', '<?php echo site_url("sales/item_search"); ?>');
										}else{
											$("#item").autocomplete('option', 'source', '<?php echo site_url("sales/item_search"); ?>');
										}
									}
								);

								$("#item").autocomplete('search');
								$("#add_item_form .spinner").show();

							}
						},
						<?php
						}
						?>
						<?php
						if(in_array("p4_api_bearer_token", $vendor_search)){
						?>
						api_p4: {
							label: 'Parts4cells',
							className: 'btn-info',
							callback: function(){

								$("#item").autocomplete('option', 'source', '<?php echo site_url("home/sync_p4_item_search"); ?>');

								$("#item").autocomplete('option', 'response', 
									function(event, ui){
										$("#add_item_form .spinner").hide();
										var source_url = $("#item").autocomplete('option', 'source');

										if(ui.content.length == 0 && (source_url.indexOf('sales/item_search') > -1) && $("#add_item_form #item").val().trim() != "" ){

										}else if(ui.content.length == 0 && (source_url.indexOf('home/sync_p4_item_search') > -1)){
											var noResult = {
												value:"",
												image:"<?php echo base_url()."assets/img/item.png"; ?>",
												label:"<?php echo lang("sales_no_result_found_p4"); ?>" 											};
											ui.content.push(noResult);
											$("#item").autocomplete('option', 'source', '<?php echo site_url("sales/item_search"); ?>');
										}else{
											$("#item").autocomplete('option', 'source', '<?php echo site_url("sales/item_search"); ?>');
										}
									}
								);

								$("#item").autocomplete('search');
								$("#add_item_form .spinner").show();

							}
						},
						<?php
						}
						?>
						cancel: {
							label: '<?php echo lang("cancel"); ?>',
							className: 'btn-info',
							callback: function(){
							}
						}
					}
				})
			}
		}, 100);
	<?php
	}


	if (isset($warning)) {
		echo "show_feedback('warning', " . json_encode($warning) . ", " . json_encode(lang('warning')) . ");";
	}

	if (isset($success)) {
		if (isset($success_no_message)) {
	?>
			if (ENABLE_SOUNDS) {
				$.playSound(BASE_URL + 'assets/sounds/success');
			}
	<?php
		} else {
			echo "show_feedback('success', " . json_encode($success) . ", " . json_encode(lang('success')) . ");";
		}
	}
	?>
</script>


<script type="text/javascript" language="javascript">
	var submitting = false;

	$(document).ready(function() {

		$("#exchange_to").change(function() {
			var rate = $(this).val();
			$.post('<?php echo site_url("receivings/exchange_to"); ?>', {
				'rate': rate
			}, function(response) {
				$("#register_container").html(response);
			});
		});



		$(".pay_store_account_receiving_form").submit(function(e) {
			e.preventDefault();

			var action = $(this).attr('action');
			var is_delete_payment = action.indexOf('delete_store_account') !== -1;

			if (!is_delete_payment) {
				var that = this
				bootbox.prompt({
					title: <?php echo json_encode(lang('please_enter_payment_amount')); ?>,
					inputType: 'text',
					value: $(this).data('full-amount'),
					callback: function(amount) {
						if (amount) {
							var new_action = action.replace($(that).data('full-amount'), amount);
							$(that).attr('action', new_action);
							$(that).ajaxSubmit({
								target: "#register_container"
							});
						}
					}
				});
			} else {
				$(this).ajaxSubmit({
					target: "#register_container"
				});
			}
		});

		$('#pay_or_unpay_all').click(function() {
			$("#register_container").load(<?php echo json_encode(site_url('receivings/toggle_pay_all_store_account')); ?>);
		});

		$('#toggle_email_receipt').on('click', function(e) {
			e.preventDefault();
			var checkBoxes = $("#email_receipt");
			checkBoxes.prop("checked", !checkBoxes.prop("checked")).trigger("change");
			$(this).toggleClass('checked');

		})

		$('#email_receipt').change(function(e) {
			e.preventDefault();
			$.post('<?php echo site_url("receivings/set_email_receipt"); ?>', {
				email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'
			});
		});


		$('#change_date_enable').is(':checked') ? $("#change_cart_date_picker").show() : $("#change_cart_date_picker").hide();

		$('#change_date_enable').click(function() {
			if ($(this).is(':checked')) {
				$("#change_cart_date_picker").show();
			} else {
				$("#change_cart_date_picker").hide();
			}
		});

		date_time_picker_field($("#change_cart_date"), JS_DATE_FORMAT + " " + JS_TIME_FORMAT);

		$("#change_cart_date").on("dp.change", function(e) {
			$.post('<?php echo site_url("receivings/set_change_cart_date"); ?>', {
				change_cart_date: $('#change_cart_date').val()
			});
		});

		//Input change
		$("#change_cart_date").change(function() {
			$.post('<?php echo site_url("receivings/set_change_cart_date"); ?>', {
				change_cart_date: $('#change_cart_date').val()
			});
		});

		$('#change_date_enable').change(function() {
			$.post('<?php echo site_url("receivings/set_change_date_enable"); ?>', {
				change_date_enable: $('#change_date_enable').is(':checked') ? '1' : '0'
			});
		});

		//Here just in case the loader doesn't go away for some reason
		$("#ajax-loader").hide();

		<?php if (!$this->agent->is_mobile()) { ?>
			<?php if (!$this->config->item('auto_focus_on_item_after_sale_and_receiving')) {
			?>
				if (last_focused_id && last_focused_id != 'item') {
					setTimeout(function() {
						$('#' + last_focused_id).focus();
						$('#' + last_focused_id).select();
					}, 10);
				}
			<?php
			} else {
			?>
				setTimeout(function() {
					$('#item').focus();
				}, 10);
			<?php
			}
			?>

			$(document).focusin(function(event) {
				last_focused_id = $(event.target).attr('id');
			});
			<?php } else {
			if ($this->config->item('wireless_scanner_support_focus_on_item_field')) {
			?>
				setTimeout(function() {
					$('#item').focus();
				}, 10);
		<?php
			}
		} ?>



		$("#save-qty-form").submit(function(e) {
			e.preventDefault();
			var item_id = $('.variation-qty-table').data('item-id');

			var query = [];
			$('.variation-qty-table').find('tr.variation-type').each(function() {
				var id = $(this).data('id');
				var qty = $(this).closest('tr').find('input').val();
				if (qty != '0') {
					query.push(qty + '*' + item_id + '#' + id + '|FORCE_ITEM_ID|');
				}
			});

			var secondary_supplier_id = $('input[name="secondary_supplier"]:checked').val();

				if (query.length != 0 && secondary_supplier_id) {
					var variations_qty = JSON.stringify(query);

					var data = {}
					data['items'] = variations_qty;
					data['secondary_supplier_id'] = secondary_supplier_id;

					$.post('<?php echo site_url('receivings/add_variations_qty'); ?>', data, function() {
						$('#var_popup').modal('hide');

						setTimeout(function() {
							$("#register_container").load('<?php echo site_url("receivings/reload"); ?>');
						}, 200);
					});
				}else if(query.length != 0 && !secondary_supplier_id){
				var variations_qty = JSON.stringify(query);

				var data = {}
				data['items'] = variations_qty;

				$.post('<?php echo site_url('receivings/add_variations_qty'); ?>', data, function() {
					$('#var_popup').modal('hide');

					setTimeout(function() {
						$("#register_container").load('<?php echo site_url("receivings/reload"); ?>');
					}, 200);
				});
				}else if(secondary_supplier_id){

				}

		});

		$(document).on('click', '#add_supplier', function(){

			var default_supplier_id = $("#default_supplier_id").val();
			var secondary_supplier_id = $("#secondary_supplier_id").val();

			if(!default_supplier_id && !secondary_supplier_id){
				$("#default_supplier_id").val($(".default_supplier_row").find(".default_supplier").val());
			}
			
			$('#var_popup_ss').modal('hide');
			$('#var_popup_ss_1').modal('hide');
			$('#add_item_form').ajaxSubmit({
				target: "#register_container",
				beforeSubmit: receivingsBeforeSubmit,
				success: itemScannedSuccess
			});
		});

		$('#select_supplier_form,#select_location_form').ajaxForm({
			target: "#register_container",
			beforeSubmit: receivingsBeforeSubmit
		});

		$(document).on("click", ".secondary_supplier_row", function(){
			$(this).find(".secondary_supplier").prop("checked", true);
			$("#secondary_supplier_id").val($(this).find(".secondary_supplier").val());
			$(".default_supplier_row").find(".default_supplier").prop("checked", false);
			$("#default_supplier_id").val("");
		});

		$(document).on("click", ".default_supplier_row", function(){
			$(this).find(".default_supplier").prop("checked", true);
			$("#default_supplier_id").val($(this).find(".default_supplier").val());
			$("#secondary_supplier_id").val("");

			$(".secondary_supplier_row").each(function(){
				$(this).find(".secondary_supplier").prop("checked", false);
			});
		});

		$(document).on("change", ".secondary_supplier", function(){
			$("#secondary_supplier_id").val($(this).val());
		});

		<?php if ($this->Employee->has_module_action_permission('receivings', 'allow_item_search_suggestions_for_receivings', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
			$("#item").autocomplete({
				source: '<?php echo site_url("receivings/item_search"); ?>',
				delay: 500,
				autoFocus: false,
				minLength: 0,
				select: function(event, ui) {
					if(ui.item.value == "") return;
					// if isset secondary suppliers length else 0 
					if (typeof(ui.item.secondary_suppliers) !== "undefined" && typeof(ui.item.secondary_suppliers.length) !== "undefined") {
						var secondary_suppliers_length = ui.item.secondary_suppliers.length;
					} else {
						var secondary_suppliers_length = 0;
					}
					<?php if(!$this->config->item('disable_variation_popup_in_receivings')){?>
						if ( typeof ui.item.attributes != 'undefined' && ui.item.attributes != null && ui.item.secondary_suppliers.length > 0) {
							$('#var-customize').text(ui.item.label);
							$('#var_popup').modal('show');
							console.log(ui);
							$('.variation-qty-table').data('item-id', decodeHtml(ui.item.value).split('#')[0]);
							$.ajax({
								type: "POST",
								url: "<?php echo site_url("receivings/get_item_attr"); ?>",
								data: 'item=' + decodeHtml(ui.item.value) + '|FORCE_ITEM_ID|',
								dataType: "json",
								success: function(data) {
									$('.variation-qty-table tr').not(':first').remove();
									$('.placeholder_supplier_vals .secondary-supplier-table tr').not(':first').remove();
									$.each(data, function(k, v) {
										$('.variation-qty-table tr:last').after('<tr class="variation-type" data-id="' + k + '"><td>' + v + '</td><td><input type="text" class="variation-control form-control input-sm" style="padding-right: 24px;" value="0"></td></tr>');
									});

									$.each(ui.item.default_supplier, function(supplier_key, supplier){
										$('.placeholder_supplier_vals .secondary-supplier-table tr:last').after('<tr class="default_supplier_row" style="cursor:pointer;" data-supplier_id="' + supplier.supplier_id + '"> <td><input class="default_supplier" type="radio" style="display:block;" value="'+supplier.supplier_id+'" name="default_supplier" ></td> <td>'+supplier.company_name+', '+supplier.full_name+'</td> <td>'+parseFloat(supplier.cost_price).toFixed(2)+'</td> <td>'+parseFloat(supplier.unit_price).toFixed(2)+'</td> </tr>');
										$("#default_supplier_id").val(supplier.supplier_id);
									});

									$(".default_supplier_row").find(".default_supplier").prop("checked", true);

									$.each(ui.item.secondary_suppliers, function(supplier_key, supplier){
										$('.placeholder_supplier_vals .secondary-supplier-table tr:last').after('<tr class="secondary_supplier_row" style="cursor:pointer;" data-supplier_id="' + supplier.supplier_id + '"> <td><input class="secondary_supplier" type="radio" style="display:block;" value="'+supplier.supplier_id+'" name="secondary_supplier" ></td> <td>'+supplier.company_name+', '+supplier.full_name+'</td> <td>'+parseFloat(supplier.cost_price).toFixed(2)+'</td> <td>'+parseFloat(supplier.unit_price).toFixed(2)+'</td></tr>');
									});
								},
								failure: function(errMsg) {
									alert(errMsg);
								}
							});
							return true;
						}else if(typeof ui.item.attributes != 'undefined' && ui.item.attributes != null){
							$('#var-customize').text(ui.item.label);
							$('#var_popup').modal('show');

							$('.variation-qty-table').data('item-id', decodeHtml(ui.item.value).split('#')[0]);
							$.ajax({
								type: "POST",
								url: "<?php echo site_url("receivings/get_item_attr"); ?>",
								data: 'item=' + decodeHtml(ui.item.value) + '|FORCE_ITEM_ID|',
								dataType: "json",
								success: function(data) {
									$('.variation-qty-table tr').not(':first').remove();
									$('.secondary-supplier-table').remove();
									$.each(data, function(k, v) {
										$('.variation-qty-table tr:last').after('<tr class="variation-type" data-id="' + k + '"><td>' + v + '</td><td><input type="text" class="variation-control form-control input-sm" style="padding-right: 24px;" value="0"></td></tr>');
									});
								},
								failure: function(errMsg) {
									alert(errMsg);
								}
							});
							return true;
						}else if(secondary_suppliers_length > 0){
							console.log(ui.item);
							$('#var-customize-ss').text(ui.item.label);
							$('#var_popup_ss').modal('show');
							$('.placeholder_supplier_vals2 .secondary-supplier-table tr').not(':first').remove();

							$.each(ui.item.default_supplier, function(supplier_key, supplier){
								$('.placeholder_supplier_vals2 .secondary-supplier-table tr:last').after('<tr class="default_supplier_row" style="cursor:pointer;" data-supplier_id="' + supplier.supplier_id + '"> <td><input class="default_supplier" type="radio" style="display:block;" value="'+supplier.supplier_id+'" name="default_supplier" ></td> <td>'+supplier.company_name+', '+supplier.full_name+'</td> <td>'+parseFloat(supplier.cost_price).toFixed(2)+'</td> <td>'+parseFloat(supplier.unit_price).toFixed(2)+'</td> </tr>');
								$("#default_supplier_id").val(supplier.supplier_id);
							});

							$(".default_supplier_row").find(".default_supplier").prop("checked", true);

							$.each(ui.item.secondary_suppliers, function(supplier_key, supplier){
								$('.placeholder_supplier_vals2 .secondary-supplier-table tr:last').after('<tr class="secondary_supplier_row" style="cursor:pointer;" data-supplier_id="' + supplier.supplier_id + '"> <td><input class="secondary_supplier" type="radio" style="display:block;" value="'+supplier.supplier_id+'" name="secondary_supplier" ></td> <td>'+supplier.company_name+', '+supplier.full_name+'</td> <td>'+parseFloat(supplier.cost_price).toFixed(2)+'</td> <td>'+parseFloat(supplier.unit_price).toFixed(2)+'</td> </tr>');
							});

								if (ui.item.serial_number != undefined &&  ui.item.serial_number !=''){
												$("#item").val(decodeHtml(ui.item.serial_number));
											}else{
												$("#item").val(decodeHtml(ui.item.value) + '|FORCE_ITEM_ID|');
											}
							return true;
						}
					<?php } ?>
					if (ui.item.serial_number != undefined &&  ui.item.serial_number !=''){
												$("#item").val(decodeHtml(ui.item.serial_number));
											}else{
												$("#item").val(decodeHtml(ui.item.value) + '|FORCE_ITEM_ID|');
											}

					$('#add_item_form').ajaxSubmit({
						target: "#register_container",
						beforeSubmit: receivingsBeforeSubmit,
						success: itemScannedSuccess
					});
				},
			}).data("ui-autocomplete")._renderItem = function(ul, item) {
				return $("<li class='item-suggestions'></li>")
					.data("item.autocomplete", item)
					.append('<a class="suggest-item" data-value="' + item.value + '" data-attributes="' + item.attributes + '"><div class="item-image symbol symbol-50px">' +
						'<img src="' + item.image + '" alt="">' +
						'</div>' +
						'<div class="details">' +
						'<div class="name">' +
						decodeHtml(item.label) +
						'</div>' +
						'<span class="attributes">' + '<?php echo lang("category"); ?>' + ' : <span class="value">' + (item.category ? item.category : <?php echo json_encode(lang('none')); ?>) + '</span></span>' +
						<?php if ($this->Employee->has_module_action_permission('items', 'see_item_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
							(typeof item.quantity !== 'undefined' && item.quantity !== null ? '<span class="attributes">' + '<?php echo lang("quantity"); ?>' + ' <span class="value">' + item.quantity + '</span></span>' : '') +
						<?php } ?>
						(item.attributes ? '<span class="attributes">' + '<?php echo lang("attributes"); ?>' + ' : <span class="value">' + item.attributes + '</span></span>' : '') +
						'<?php if(!$this->config->item('hide_supplier_in_item_search_result')){ ?>'+
						(item.supplier_name ? '<span class="attributes">' + '<?php echo lang("supplier"); ?>' + ' : <span class="value">' + item.supplier_name + '</span></span>' : '') +
						'<?php } ?>'+
						'</div>')
					.appendTo(ul);
			};
		<?php } ?>
		// if #mode is changed
		$('.change-mode').click(function(e) {
			e.preventDefault();
			if ($(this).data('mode') == "store_account_payment") { // Hiding the category grid
				$('#show_hide_grid_wrapper, #category_item_selection_wrapper').fadeOut();
			} else { // otherwise, show the categories grid
				$('#show_hide_grid_wrapper, #show_grid').fadeIn();
				$('#hide_grid').fadeOut();
			}
			$.post('<?php echo site_url("receivings/change_mode"); ?>', {
				mode: $(this).data('mode')
			}, function(response) {
				$("#register_container").html(response);
			});
		});


		//make username editable
		$('.xeditable').editable({
			validate: function(value) {
				if ($.isNumeric(value) == '' && $(this).data('validate-number')) {
					return <?php echo json_encode(lang('only_numbers_allowed')); ?>;
				}
			},
			success: function(response, newValue) {
				last_focused_id = $(this).attr('id');
				$("#register_container").html(response);
			},
			savenochange: true
		});

		$(".expire_date").editable({
			validate: function(value) {
				if (!value) {
					return <?php echo json_encode(lang('receivings_invalid_date')); ?>;
				}
			},
			combodate: {
				maxYear: <?php echo date("Y") + 20; ?>,
				minYear: <?php echo date("Y"); ?>,
			},
			success: function(response, newValue) {
				last_focused_id = $(this).attr('id');
				$("#register_container").html(response);
			}
		});

		$('.xeditable').on('shown', function(e, editable) {

			$(this).closest('.table-responsive').css('overflow-x', 'hidden');

			editable.input.postrender = function() {
				//Set timeout needed when calling price_to_change.editable('show') (Not sure why)
				setTimeout(function() {
					editable.input.$input.select();
				}, 200);
			};
		});

		$('.xeditable').on('hidden', function(e, editable) {
			$(this).closest('.table-responsive').css('overflow-x', 'auto');
		});


		$('.xeditable').on('hidden', function(e, editable) {
			last_focused_id = $(this).attr('id');
			$('#' + last_focused_id).focus();
			$('#' + last_focused_id).select();
		});

		<?php if (isset($cart_count)) { ?>
			$('.cart-number').html(<?php echo $cart_count; ?>);
		<?php } ?>

		$('#location').change(function() {
			$('#select_location_form').ajaxSubmit({
				target: "#register_container",
				beforeSubmit: receivingsBeforeSubmit
			});
		});

		$('#location_from').change(function() {
			$('#select_location_from_form').ajaxSubmit({
				target: "#register_container",
				beforeSubmit: receivingsBeforeSubmit
			});
		});

		// Select Location 
		<?php if ($mode == "transfer" and !isset($location)) { ?>


			$("#location").autocomplete({
				source: '<?php echo site_url("receivings/location_search"); ?>',
				delay: 500,
				autoFocus: false,
				minLength: 0,
				select: function(event, ui) {
					$.post('<?php echo site_url("receivings/select_location"); ?>', {
						location: decodeHtml(ui.item.value)
					}, function(response) {
						$("#register_container").html(response);
					});
				},
			}).data("ui-autocomplete")._renderItem = function(ul, item) {
				return $("<li class='customer-badge suggestions'></li>")
					.data("item.autocomplete", item)
					.append('<a class="suggest-item location-suggest"><div class="avatar">' +
						'<span class="badge" style="background-color:' + item.color + '">&nbsp;</span>' +
						'</div>' +
						'<div class="details">' +
						'<div class="name">' +
						item.label +
						'</div>' +
						'</div></a>')
					.appendTo(ul);

			};
		<?php } ?>

		// Select Location From
		<?php if ($mode == "transfer" and !isset($location_from)) { ?>


			$("#location_from").autocomplete({
				source: '<?php echo site_url("receivings/location_search"); ?>',
				delay: 500,
				autoFocus: false,
				minLength: 0,
				select: function(event, ui) {
					$.post('<?php echo site_url("receivings/select_location_from"); ?>', {
						location_from: decodeHtml(ui.item.value)
					}, function(response) {
						$("#register_container").html(response);
					});
				},
			}).data("ui-autocomplete")._renderItem = function(ul, item) {
				return $("<li class='customer-badge suggestions'></li>")
					.data("item.autocomplete", item)
					.append('<a class="suggest-item location-suggest"><div class="avatar">' +
						'<span class="badge" style="background-color:' + item.color + '">&nbsp;</span>' +
						'</div>' +
						'<div class="details">' +
						'<div class="name">' +
						item.label +
						'</div>' +
						'</div></a>')
					.appendTo(ul);

			};
		<?php } ?>



		$('#location_from_from').change(function() {
			$('#select_location_form').ajaxSubmit({
				target: "#register_container",
				beforeSubmit: receivingsBeforeSubmit
			});
		});

		// Select Location 
		<?php if ($mode == "transfer" and !isset($location)) { ?>


			$("#location").autocomplete({
				source: '<?php echo site_url("receivings/location_search"); ?>',
				delay: 500,
				autoFocus: false,
				minLength: 0,
				select: function(event, ui) {
					$.post('<?php echo site_url("receivings/select_location"); ?>', {
						location: decodeHtml(ui.item.value)
					}, function(response) {
						$("#register_container").html(response);
					});
				},
			}).data("ui-autocomplete")._renderItem = function(ul, item) {
				return $("<li class='customer-badge suggestions'></li>")
					.data("item.autocomplete", item)
					.append('<a class="suggest-item location-suggest"><div class="avatar">' +
						'<span class="badge" style="background-color:' + item.color + '">&nbsp;</span>' +
						'</div>' +
						'<div class="details">' +
						'<div class="name">' +
						item.label +
						'</div>' +
						'</div></a>')
					.appendTo(ul);

			};
		<?php } ?>


		// Select Supplier 
		<?php if ($mode != "transfer" and !isset($supplier)) { ?>


			<?php
			if ($this->Employee->has_module_action_permission('receivings', 'allow_supplier_search_suggestions_for_suppliers', $this->Employee->get_logged_in_employee_info()->person_id)) {
			?>

				$("#supplier").autocomplete({
					source: '<?php echo site_url("receivings/supplier_search"); ?>',
					delay: 500,
					autoFocus: false,
					minLength: 0,
					select: function(event, ui) {
						$.post('<?php echo site_url("receivings/select_supplier"); ?>', {
							supplier: decodeHtml(ui.item.value) + "|FORCE_PERSON_ID|"
						}, function(response) {
							$("#register_container").html(response);
						});
					},
				}).data("ui-autocomplete")._renderItem = function(ul, item) {
					return $("<li class='customer-badge suggestions'></li>")
						.data("item.autocomplete", item)
						.append('<a class="suggest-item"><div class="avatar">' +
							'<img src="' + item.avatar + '" alt="">' +
							'</div>' +
							'<div class="details">' +
							'<div class="name">' +
							item.label +
							'</div>' +
							'<span class="email">' +
							item.subtitle +
							'</span>' +
							'</div></a>')
						.appendTo(ul);

				};
			<?php } ?>
		<?php } ?>



		//Add payment to the sale 
		$("#add_payment_button").click(function(e) {
			e.preventDefault();

			if (noPaymentSelected()) {
				return false;
			}

			$('#add_payment_form').ajaxSubmit({
				target: "#register_container",
				beforeSubmit: receivingsBeforeSubmit
			});
		});


		$('#select_supplier_form').bind('keypress', function(e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				$('#select_supplier_form').ajaxSubmit({
					target: "#register_container",
					beforeSubmit: receivingsBeforeSubmit
				});
			}
		});

		$('#select_location_form').bind('keypress', function(e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				$('#select_location_form').ajaxSubmit({
					target: "#register_container",
					beforeSubmit: receivingsBeforeSubmit
				});
			}
		});

		$('#select_location_from_form').bind('keypress', function(e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				$('#select_location_from_form').ajaxSubmit({
					target: "#register_container",
					beforeSubmit: receivingsBeforeSubmit
				});
			}
		});


		$('#add_item_form').ajaxForm({
			target: "#register_container",
			beforeSubmit: receivingsBeforeSubmit,
			success: itemScannedSuccess
		});

		$('#add_item_form').bind('keypress', function(e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				localStorage.setItem('item_search_key', $("#add_item_form #item").val());
				$('#add_item_form').ajaxSubmit({
					target: "#register_container",
					beforeSubmit: receivingsBeforeSubmit,
					success: itemScannedSuccess
				});
			}
		});

		//Add payment to the sale when hit enter on amount tendered input
		$('#amount_tendered').bind('keypress', function(e) {
			if (e.keyCode == 13) {
				e.preventDefault();

				//Quick complete possible
				if ($("#finish_sale_alternate_button").is(":visible")) {
					if (noPaymentSelected()) {
						return false;
					}

					$('#add_payment_form').ajaxSubmit({
						target: "#register_container",
						beforeSubmit: receivingsBeforeSubmit,
						complete: function() {
							$('#finish_sale_button').trigger('click');
						}
					});
				} else {
					if (noPaymentSelected()) {
						return false;
					}

					$('#add_payment_form').ajaxSubmit({
						target: "#register_container",
						beforeSubmit: receivingsBeforeSubmit
					});
				}
			}
		});

		//Select all text in the input when input is clicked
		$("input:text, textarea").not(".description,#comment,#internal_notes").click(function() {
			$(this).select();
		});

		<?php if (!$this->config->item('disable_quick_complete_sale')) { ?>

			if ((<?php echo $amount_due; ?> >= 0 && $('#amount_tendered').val() >= <?php echo $amount_due; ?>) || (<?php echo $amount_due; ?> < 0 && $('#amount_tendered').val() <= <?php echo $amount_due; ?>)) {
				$('#finish_sale_alternate_button').removeClass('hidden');
				$('#add_payment_button').addClass('hidden');
			} else {
				$('#finish_sale_alternate_button').addClass('hidden');
				$('#add_payment_button').removeClass('hidden');
			}


			$('#amount_tendered').on('input', function() {
				if ((<?php echo $amount_due; ?> >= 0 && $('#amount_tendered').val() >= <?php echo $amount_due; ?>) || (<?php echo $amount_due; ?> < 0 && $('#amount_tendered').val() <= <?php echo $amount_due; ?>)) {
					$('#finish_sale_alternate_button').removeClass('hidden');
					$('#add_payment_button').addClass('hidden');
				} else {
					$('#finish_sale_alternate_button').addClass('hidden');
					$('#add_payment_button').removeClass('hidden');
				}

			});

			$('#finish_sale_alternate_button').on('click', function(e) {
				e.preventDefault();

				if (noPaymentSelected()) {
					return false;
				}

				$('#add_payment_form').ajaxSubmit({
					target: "#register_container",
					beforeSubmit: receivingsBeforeSubmit,
					complete: function() {
						$('#finish_sale_button').trigger('click');
					}
				});
			});

		<?php } ?>

		// Show or hide item grid
		$("#show_grid, .show-grid").on('click', function(e) {
			e.preventDefault();
			$("#category_item_selection_wrapper").slideDown();

			$('.show-grid').addClass('hidden');
			$('.hide-grid').removeClass('hidden');
		});

		$("#hide_grid,#hide_grid_top, .hide-grid").on('click', function(e) {
			e.preventDefault();
			$("#category_item_selection_wrapper").slideUp();

			$('.hide-grid').addClass('hidden');
			$('.show-grid').removeClass('hidden');
		});


		$("#cart_contents input").change(function() {
			$(this.form).ajaxSubmit({
				target: "#register_container",
				beforeSubmit: receivingsBeforeSubmit
			});
		});

		$('#item,#supplier,#location').click(function() {
			$(this).attr('value', '');
		});

		$('#mode').change(function() {
			$('#mode_form').ajaxSubmit({
				target: "#register_container",
				beforeSubmit: receivingsBeforeSubmit
			});
		});

		$('#comment').change(function() {
			$.post('<?php echo site_url("receivings/set_comment"); ?>', {
				comment: $('#comment').val()
			});
		});
		
		$('#create_invoice').change(function()
		{
			$.post('<?php echo site_url("receivings/set_create_invoice");?>', {create_invoice:$('#create_invoice').is(':checked') ? '1' : '0'});
		});
		

		$('#internal_notes').change(function() {
			$.post('<?php echo site_url("receivings/set_internal_notes"); ?>', {
				internal_notes: $('#internal_notes').val()
			});
		});

		<?php if (!$is_po) { ?>
			$("#finish_sale_form").submit(function() {
				<?php if ($mode == "transfer" and !isset($location)) { ?>
					bootbox.alert(<?php echo json_encode(lang("receivings_location_required")); ?>);
					$('#location').focus();
					return;
				<?php } ?>

				var finishForm = this;

				<?php if (!$this->config->item('disable_confirm_recv')) { ?>

					bootbox.confirm(<?php echo json_encode(lang("receivings_confirm_finish_receiving")); ?>, function(result) {
						if (result) {
							//Prevent double submission of form
							$("#finish_sale_button").hide();
							finishForm.submit();
						}
					});
					return false;
				<?php } ?>
			});
			$("#finish_sale_button_transfer_request").click(function(e) {
				e.preventDefault();

				bootbox.confirm(<?php echo json_encode(lang("receivings_confirm_finish_receiving_transfer_request")); ?>, function(result) {
					if (result) {
						doSuspendRecvTransferRequest();
					}
				})

			});

			$("#finish_sale_button").click(function(e) {
				e.preventDefault();

				if ($("#comment").val()) {
					$.post('<?php echo site_url("receivings/set_comment"); ?>', {
						comment: $('#comment').val()
					}, function() {
						$('#finish_sale_form').submit();
					});
				} else {
					$('#finish_sale_form').submit();
				}


			});
		<?php } ?>
		$("#cancel_sale_button").click(function(e) {
			e.preventDefault();
			bootbox.confirm(<?php echo json_encode(lang("receivings_confirm_cancel_receiving")); ?>, function(result) {
				if (result) {
					$('#cancel_sale_form').ajaxSubmit({
						target: "#register_container",
						beforeSubmit: receivingsBeforeSubmit
					});
				}
			});
		});

		//Select Payment
		$('.select-payment').on('click', selectPayment);

		$('.delete-item, .delete-payment, #delete_supplier, #delete_location,#delete_location_from').click(function(event) {
			event.preventDefault();
			$("#register_container").load($(this).attr('href'));
		});

		$('.delete-tax').click(function(event) {
			event.preventDefault();
			var $that = $(this);
			bootbox.confirm(<?php echo json_encode(lang("confirm_sale_tax_delete")); ?>, function(result) {
				if (result) {
					$("#register_container").load($that.attr('href'));
				}
			});
		});


		$("input[type=text]").click(function() {
			$(this).select();
		});

		$("#suspend_recv_button<?php echo $is_po ? ', #finish_sale_button' : ''; ?>").click(function(e) {
			e.preventDefault();
			bootbox.confirm(<?php echo json_encode(lang("receivings_confim_suspend_recv")); ?>, function(result) {
				if (result) {
					if ($("#comment").val()) {
						$.post('<?php echo site_url("receivings/set_comment"); ?>', {
							comment: $('#comment').val()
						}, function() {
							doSuspendRecv();
						});
					} else {
						doSuspendRecv();
					}
				}
			});
		});

		$('.fullscreen').on('click', function(e) {
			e.preventDefault();
			salesRecvFullScreen();
			$.get('<?php echo site_url("home/set_fullscreen/1"); ?>');
		});

		$('.dismissfullscreen').on('click', function(e) {
			e.preventDefault();
			salesRecvDismissFullscren();
			$.get('<?php echo site_url("home/set_fullscreen/0"); ?>');
		});
	});

	function doSuspendRecv() {
		<?php if (!$is_po) { ?>
			<?php if ($this->config->item('show_receipt_after_suspending_sale')) { ?>
				window.location = '<?php echo site_url("receivings/suspend"); ?>';
			<?php } else { ?>
				$("#register_container").load('<?php echo site_url("receivings/suspend"); ?>');
			<?php } ?>
		<?php
		} else {
		?>
			window.location = '<?php echo site_url("receivings/suspend"); ?>';
		<?php
		}
		?>

	}

	function doSuspendRecvTransferRequest() {
		$("#register_container").load('<?php echo site_url("receivings/suspend/2"); ?>');
	}

	function receivingsBeforeSubmit(formData, jqForm, options) {
		if (submitting) {
			return false;
		}
		submitting = true;

		$('.cart-number').html(<?php echo $cart_count; ?>);
		$("#ajax-loader").show();
		$("#finish_sale_button").hide();
	}

	function itemScannedSuccess(responseText, statusText, xhr, $form) {
		<?php if ($this->config->item('clean_input_after_add_item')) { ?>
			$('#item').val('');
		<?php } ?>
		setTimeout(function() {
			$('#item').focus();
		}, 10);
	}

	function checkPaymentTypes() {
		var paymentType = $("#payment_types").val();
		switch (paymentType) {
			case <?php echo json_encode(lang('cash')); ?>:
				$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('cash') . ' ' . lang('amount')); ?>);
				break;
			case <?php echo json_encode(lang('check')); ?>:
				$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('check') . ' ' . lang('amount')); ?>);
				break;
			case <?php echo json_encode(lang('debit')); ?>:
				$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('debit') . ' ' . lang('amount')); ?>);
				break;
			case <?php echo json_encode(lang('credit')); ?>:
				$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('credit') . ' ' . lang('amount')); ?>);
				break;
			case <?php echo json_encode(lang('store_account')); ?>:
				$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter') . ' ' . lang('store_account') . ' ' . lang('amount')); ?>);
				break;
			default:
				$("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
				$("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter')); ?> + ' ' + paymentType + ' ' + <?php echo json_encode(lang('amount')); ?>);
		}
	}

	function selectPayment(e) {
		e.preventDefault();
		$.post('<?php echo site_url("receivings/set_selected_payment"); ?>', {
			payment: $(this).data('payment')
		});
		$('#payment_types').val($(this).data('payment'));
		$('.select-payment').removeClass('active');
		$(this).addClass('active');
		$("#amount_tendered").focus();
		$("#amount_tendered").select();
		$("#amount_tendered").attr('placeholder', '');

		checkPaymentTypes();
		
		if ($(this).data('payment') == <?php echo json_encode(lang('store_account')) ?>)
		{
			$("#create_invoice_holder").removeClass('hidden');
		}
		else
		{
			$("#create_invoice_holder").addClass('hidden');
		}
		
	}

	checkPaymentTypes();

	$(".delete-custom-image-recv a").click(function(e) {
		e.preventDefault();
		var $that = $(this);
		bootbox.confirm(CONFIRM_IMAGE_DELETE, function(result) {
			if (result) {
				$.get($that.attr('href'), function() {
					//face out image and link
					$that.parent().fadeOut();
					$that.parent().prev().fadeOut();
				});
			}
		});
	});

	function noPaymentSelected() {
		var no_payment = $(".select-payment.active").length == 0;
		if (no_payment) {
			bootbox.alert(<?php echo json_encode(lang('must_select_payment')); ?>);
		}
		return no_payment
	}


	<?php
	if (isset($quantity_set) && $quantity_set) {
	?>
		var quantity_to_change = $('#register a[data-name="quantity"]').first();
		quantity_to_change.editable('show');
	<?php
	}
	?>

	$("#sale_details_expand_collapse").click(function() {
		$('.register-item-bottom').toggleClass('collapse');

		if ($('.register-item-bottom').hasClass('collapse')) {
			$.post('<?php echo site_url("receivings/set_details_collapsed"); ?>', {
				value: '1'
			});
			$("#sale_details_expand_collapse").text('+');
			$(".show-collpased").show();
			
		} else {
			$.post('<?php echo site_url("receivings/set_details_collapsed"); ?>', {
				value: '0'
			});
			$("#sale_details_expand_collapse").text('-');
			$(".show-collpased").hide();
			
		}
	});

	<?php if ($details_collapsed) { ?>
		$("#sale_details_expand_collapse").text('+');
		$('.register-item-bottom').addClass('collapse');
		$(".show-collpased").show();
	<?php } ?>

	$(".page_pagination a").click(function(e) {
		e.preventDefault();
		$("#register_container").load($(this).attr('href'));
	});

	<?php 
	$denominations = $this->Register->get_register_currency_denominations()->result();

	$bills = array();
	foreach($denominations as $denom){
		if($denom->value >= 1 && count($bills) <= 8){
			$bills[] = $denom->value;
		}
	}

	sort($bills);
	?>

	var $bills = <?php echo json_encode($bills, JSON_NUMERIC_CHECK); ?>;

	<?php if(count($bills) > 0) { ?>

	$(".btn-pay").dblclick(function(){
		var $currency_symbol = "<?php echo $this->config->item('currency_symbol'); ?>";
		var $amount_tendered = $("#amount_tendered").val();


		var $possible_amount  = get_possible_amount($amount_tendered, $bills);


		var $html = '';

		$.each($possible_amount, function($index, $value) {
	
			$html += '<div class="col-md-3" style="margin-bottom:15px;">';
				$html += '<button tabindex="'+($index)+'" class="btn btn-primary btn-block quick_amount" data-quick_amount="'+$value+'.00" style="height:50px; border-radius:0px; font-size:16px; font-weight:bold;">'+$currency_symbol+''+$value+'.00</button>';
			$html += '</div>';

		});

		$("#quick_cash_holder").html($html);
		
		$("#choose_quick_cash").modal("show");
	});

	<?php }?>
	var get_possible_amount = function($sales_amount, $bills) {
		
		var $found_amount, $get_extra, $key, $bill, $current_bill, $previous_bill, $qutnt, $mod, $quotient, $new_extra_amount, $possible_amount_using_this_bill;
		
		$sales_amount = Math.ceil($sales_amount);
		
		$found_amount = [$sales_amount];
		
		$get_extra = [];
		
		for ($key in $bills) { $bill = $bills[$key];
			if($key == 0){
				$get_extra.push(0);
				continue;
				}else{
				$current_bill = $bill;
				$previous_bill = $bills[$key-1];
				
				$qutnt = $current_bill/$previous_bill;
				
				$mod = $current_bill%$previous_bill;
				
				if($mod != 0){
					$get_extra.push($previous_bill * Math.ceil($qutnt));
					}else{
					$get_extra.push(0);
				}
			}
		}
		
		for ($key in $bills) { $bill = $bills[$key];
			$quotient = $sales_amount / $bill;
			
			if($sales_amount % $bill == 0){
				$new_extra_amount = ($sales_amount-$bill)+$get_extra[$key];
				if($new_extra_amount >= $sales_amount && !inArray($new_extra_amount, $found_amount)){
					$found_amount.push($new_extra_amount);
				}
			}
			
			$possible_amount_using_this_bill = $bill * Math.ceil($quotient);
			
			if (inArray($possible_amount_using_this_bill, $found_amount)) {
				continue;
			}
			
			if (isNaN($possible_amount_using_this_bill))
			{
				continue;
			}
			
			
			$found_amount.push($possible_amount_using_this_bill);
		}

		$found_amount.sort();

		return $found_amount.sort(function(a, b){return a-b});
	
	}


	function inArray(needle, haystack) {
		var length = haystack.length;
		for(var i = 0; i < length; i++) {
			if(haystack[i] == needle) return true;
		}
		return false;
	}

	$('#choose_quick_cash').on('shown.bs.modal', function (e) {
		$("#custom_amount").focus();
	});

	$(document).on('click', '.quick_amount', function(){
		var amount_tendered = $(this).data("quick_amount");
		$("#amount_tendered").val(amount_tendered);
		$('#choose_quick_cash').modal('hide');
		$("#finish_sale_alternate_button").trigger('click');
		$("#finish_sale_button").trigger('click');
	});

	$(document).on('keyup', '#custom_amount', function(){
		var amount_tendered = $(this).val();
		$("#collect_amount").data("quick_amount", amount_tendered);
	});

	$(window).keydown(function(event) {
		if( event.ctrlKey && event.which == 81 ) { 
			$('.btn-pay').trigger("dblclick");
			event.preventDefault(); 
		}

		if($("#custom_amount").focus() && $("#custom_amount").val() > 0  && event.which == 13 ) { 
			$('#collect_amount').trigger("click");
			event.preventDefault(); 
		}
	});

</script>

<script>
	$(document).ready(function() {
		
		<?php if ($this->config->item('allow_drag_drop_recv') && !$this->agent->is_mobile() && !$this->agent->is_tablet()) {  ?>

			$("#register th").on("click", function(){
				var column = ""
				if($(this).hasClass("item_name_heading")){
					column = "name";
				}else if($(this).hasClass("sales_price")){
					column = "price";
				}else if($(this).hasClass("sales_quantity")){
					column = "quantity";
				}else if($(this).hasClass("sales_discount")){
					column = "discount";
				}else if($(this).hasClass("sales_total")){
					column = "total";
				}
				if(column == '') return;

				var type = "asc";
				if($(this).hasClass("ion-arrow-down-b")){
					type = "desc";
					$("#register th").removeClass("ion-arrow-down-b");
					$("#register th").removeClass("ion-arrow-up-b");
					$(this).addClass("ion-arrow-up-b");
				}else if($(this).hasClass("ion-arrow-up-b")){
					type = "asc";
					$("#register th").removeClass("ion-arrow-down-b");
					$("#register th").removeClass("ion-arrow-up-b");
					$(this).addClass("ion-arrow-down-b");
				}else{
					type = "asc";
					$("#register th").removeClass("ion-arrow-down-b");
					$("#register th").removeClass("ion-arrow-up-b");
					$(this).addClass("ion-arrow-down-b");
				}
				$('#grid-loader2').show();
				$.post('<?php echo site_url("receivings/sort"); ?>', {
						sort_column: column,
						sort_type: type,
				}, function(response) {
					$('#grid-loader2').hide();
					$("#register_container").html(response);
				});			
			})

			$(function () {
			var start_pos = 0;
			if($("#register tbody").length > 1){
				$("#register").sortable({
					items: 'tbody',
					cursor: 'pointer',
					axis: 'y',
					dropOnEmpty: false,
					start: function (e, ui) {
						ui.item.addClass("selected");
						var td_width = [];
						var td_height = [];
						for( let i = 0; i < $("#register tbody").length; i ++){
							if($($("#register tbody")[i]).hasClass('selected') || $($("#register tbody")[i]).hasClass('ui-sortable-placeholder')){
								continue;
							}else{
								td_height = $($("#register tbody")[i]).height();
								for(let j = 0; j<$($("#register tbody")[i]).find(".register-item-details td").length; j++){
									td_width.push($($($("#register tbody")[i]).find(".register-item-details td")[j]).width());
								}
								break;
							}
						}
						$(".ui-sortable-placeholder").html("<tr><td>&nbsp;</td></tr>");
						$(".ui-sortable-placeholder").height(td_height+'px');
						for(let k=0; k<$($("#register tbody.selected tr")[0]).find('td').length; k++){
							$($($("#register tbody.selected tr")[0]).find('td')[k]).width(td_width[k]+'px');
						}
						start_pos = $("#register tbody.selected").parent().children().index($("#register tbody.selected"));
					},
					stop: function (e, ui) {

						let current_pos = $("#register tbody.selected").parent().children().index($("#register tbody.selected"));
						var drop_index = 0;
						if(current_pos < start_pos) // up
						{
							drop_index = $("#register tbody.selected").next().data('line');
						}else if(current_pos > start_pos){ // dwon
							drop_index = $("#register tbody.selected").prev().data('line');
						}else{
							return;
						}

						var drag_index = $("#register tbody.selected").data('line');

						for(let k=0; k<$($("#register tbody.selected tr")[0]).find('td').length; k++){
							$($($("#register tbody.selected tr")[0]).find('td')[k]).attr('style','');
						}						
						ui.item.removeClass("selected");
						$("#register th").removeClass("ion-arrow-down-b");
						$("#register th").removeClass("ion-arrow-up-b");

						if(drag_index != drop_index){
							$('#grid-loader2').show();
							$.post('<?php echo site_url("receivings/sort"); ?>', {
								'drag_index': drag_index,
								'drop_index': drop_index,
								'sort_column': 'drag_drop',
							}, function(response) {
								$('#grid-loader2').hide();
								$("#register_container").html(response);
							});			
						}
					},
					sort:function(e){
						$(".ui-sortable-helper").css("width", $("table#register").width()+'px');
						$(".ui-sortable-helper tr").css("width", $("table#register").width()+'px');
					}
				});
			}
        });	
		<?php } ?>	
	});

	<?php
	if (isset($async_inventory_updates) && $async_inventory_updates && $_SESSION['do_async_inventory_updates'])
	{
		if (!empty($_SESSION['async_inventory_updates']))
		{
			?>
			$.get(<?php echo json_encode(site_url('home/async_inventory_updates')); ?>);
			<?php
		}
	
		unset($_SESSION['do_async_inventory_updates']);
	}
	?>
</script>
