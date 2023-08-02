<div id="kt_app_content_container" class="app-container container-fluid">
														<!--begin::Products-->
														<div class="card card-flush">
															<!--begin::Card header-->
															<div class="card-header align-items-center py-5 gap-2 gap-md-5">
																<!--begin::Card title-->
																<div class="card-title">
																	<!--begin::Search-->
																	<div class="d-flex align-items-center position-relative my-1">
																		<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
																		<span class="svg-icon svg-icon-1 position-absolute ms-4">
																			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																				<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
																				<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
																			</svg>
																		</span>
																		<!--end::Svg Icon-->
																		<input type="text" data-kt-ecommerce-order-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Order" />
																	</div>
																	<!--end::Search-->
																</div>
																<!--end::Card title-->
																<!--begin::Card toolbar-->
																<div class="card-toolbar flex-row-fluid justify-content-end gap-5">
																	<!--begin::Flatpickr-->
																	<div class="input-group w-250px">
																		<input class="form-control form-control-solid rounded rounded-end-0" placeholder="Pick date range" id="kt_ecommerce_sales_flatpickr" />
																		<button class="btn btn-icon btn-light" id="kt_ecommerce_sales_flatpickr_clear">
																			<!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
																			<span class="svg-icon svg-icon-2">
																				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																					<rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
																					<rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
																				</svg>
																			</span>
																			<!--end::Svg Icon-->
																		</button>
																	</div>
																	<!--end::Flatpickr-->
																	<div class="w-100 mw-150px">
																		<!--begin::Select2-->
																		<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-order-filter="status">
																			<option></option>
																			<option value="all">All</option>
																			<option value="New">New</option>
																			<option value="Completed">Completed</option>
																			<!-- <option value="Denied">Denied</option>
																			<option value="Expired">Expired</option>
																			<option value="Failed">Failed</option>
																			<option value="Pending">Pending</option> -->
																			<option value="Processing">Processing</option>
																			<!-- <option value="Refunded">Refunded</option>
																			<option value="Delivered">Delivered</option>
																			<option value="Delivering">Delivering</option> -->
																		</select>
																		<!--end::Select2-->
																	</div>
																</div>
																<!--end::Card toolbar-->
															</div>
															<!--end::Card header-->
															<!--begin::Card body-->
															<div class="card-body pt-0">
																<!--begin::Table-->
																<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_sales_table">
																	<!--begin::Table head-->
																	<thead>
																		<!--begin::Table row-->
																		<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																			<th class="w-10px pe-2">
																				<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
																					<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_sales_table .form-check-input" value="1" />
																				</div>
																			</th>
																			<th class="min-w-100px">Order ID</th>
																			<th class="min-w-175px">Customer</th>
																			<th class="min-w-175px">Type</th>
																			<th class="text-end min-w-70px">Status</th>
																			<th class="text-end min-w-100px">Total</th>
																			<th class="text-end min-w-100px">Date Added</th>
																			<th class="text-end min-w-100px">Date Modified</th>
																			<th class="text-end min-w-100px">Actions</th>
																		</tr>
																		<!--end::Table row-->
																	</thead>
																	<!--end::Table head-->
																	<!--begin::Table body-->
																	<tbody class="fw-semibold text-gray-600">
																		<!--begin::Table row-->
                                                                        <?php if(isset($orders)):  foreach($orders as $order): ?>

                                                                            <?php

// echo "<pre>";
// print_r( $order);
// 	exit();
	$cart = $order['receipt']['cart'];
	$discount_exists = $order['receipt']['discount_exists'];
	$cart_items = $order['receipt']['cart_items'];
	$taxes = $order['receipt']['taxes'];
	$total=  $order['receipt']['total'];
	$customername = $order['receipt']['customer'];
$this->load->helper('sale');
$sale_id_raw = $order['sales']->sale_id;
$is_on_device_tip_processor = $this->Location->get_info_for_key('credit_card_processor', isset($override_location_id) ? $override_location_id : FALSE) == 'card_connect' || $this->Location->get_info_for_key('credit_card_processor', isset($override_location_id) ? $override_location_id : FALSE) == 'coreclear2';

$tip_amount = 0;

if ($is_on_device_tip_processor) {
	$sale_info = $this->Sale->get_info($sale_id_raw)->row_array();

	$tip_amount = $sale_info['tip'];
}

$return_policy = ($loc_return_policy = $this->Location->get_info_for_key('return_policy', isset($override_location_id) ? $override_location_id : FALSE)) ? $loc_return_policy : $this->config->item('return_policy');
$company = ($company = $this->Location->get_info_for_key('company', isset($override_location_id) ? $override_location_id : FALSE)) ? $company : $this->config->item('company');
$tax_id = ($tax_id = $this->Location->get_info_for_key('tax_id', isset($override_location_id) ? $override_location_id : FALSE)) ? $tax_id : $this->config->item('tax_id');
$website = ($website = $this->Location->get_info_for_key('website', isset($override_location_id) ? $override_location_id : FALSE)) ? $website : $this->config->item('website');
$company_logo = ($company_logo = $this->Location->get_info_for_key('company_logo', isset($override_location_id) ? $override_location_id : FALSE)) ? $company_logo : $this->config->item('company_logo');

$is_integrated_credit_sale = is_sale_integrated_cc_processing($cart);
$is_sale_integrated_ebt_sale = is_sale_integrated_ebt_sale($cart);
$is_credit_card_sale = is_credit_card_sale($cart);
$is_debit_card_sale = is_debit_card_sale($cart);

$signature_needed = ($this->config->item('enable_tips') && ($is_credit_card_sale || $is_debit_card_sale)) || $this->config->item('capture_sig_for_all_payments') || (($is_credit_card_sale && !$is_integrated_credit_sale) ||  is_store_account_sale($cart));
$item_custom_fields_to_display = array();
$sale_custom_fields_to_display = array();
$item_kit_custom_fields_to_display = array();
$customer_custom_fields_to_display = array();
$employee_custom_fields_to_display = array();
$work_order_custom_fields_to_display  = array();


for ($k = 1; $k <= NUMBER_OF_PEOPLE_CUSTOM_FIELDS; $k++) {
	$item_custom_field = $this->Item->get_custom_field($k, 'show_on_receipt');
	$sale_custom_field = $this->Sale->get_custom_field($k, 'show_on_receipt');
	$item_kit_custom_field = $this->Item_kit->get_custom_field($k, 'show_on_receipt');
	$customer_custom_field = $this->Customer->get_custom_field($k, 'show_on_receipt');
	$employee_custom_field = $this->Employee->get_custom_field($k, 'show_on_receipt');
	$work_order_custom_field = $this->Work_order->get_custom_field($k, 'show_on_receipt');

	if ($item_custom_field) {
		$item_custom_fields_to_display[] = $k;
	}

	if ($sale_custom_field) {
		$sale_custom_fields_to_display[] = $k;
	}

	if ($item_kit_custom_field) {
		$item_kit_custom_fields_to_display[] = $k;
	}

	if ($customer_custom_field) {
		$customer_custom_fields_to_display[] = $k;
	}

	if ($employee_custom_field) {
		$employee_custom_fields_to_display[] = $k;
	}

	if ($work_order_custom_field) {
		$work_order_custom_fields_to_display[] = $k;
	}
}

//Check for EMV signature for non pin verified
if (!$signature_needed && $is_integrated_credit_sale) {
	foreach ($payments as $payment_id => $payment) {
		if ($payment->cvm != 'PIN VERIFIED') {
			$signature_needed = TRUE;
			break;
		}
	}
}


?>




	
		
				
				<?php
				$x_col = 6;
				$xs_col = 4;
				if ($discount_exists) {
					$x_col = 4;
					$xs_col = 3;

					if ($this->config->item('wide_printer_receipt_format')) {
						$x_col = 4;
						$xs_col = 2;
					}
				} else {
					if ($this->config->item('wide_printer_receipt_format')) {
						$x_col = 6;
						$xs_col = 2;
					}
				}
				?>

			
					
					<?php

					$cart_items = $cart->get_list_sort_by_receipt_sort_order($cart_items);
					if ($discount_item_line = $cart->get_index_for_flat_discount_item()) {
						$discount_item = $cart->get_item($discount_item_line);
						$cart->delete_item($discount_item_line);
						$cart->add_item($discount_item, false);
						// $cart_items = $cart->get_items();
						$cart_items = $cart->get_list_sort_by_receipt_sort_order();
					}

					$number_of_items_sold = 0;
					$number_of_items_returned = 0;

					if ($credit_card_fee_item_line = $cart->get_index_for_credit_card_fee_item()) {
						$credit_card_fee_item = $cart->get_item($credit_card_fee_item_line);
						$cart->delete_item($credit_card_fee_item_line);
						$cart->add_item($credit_card_fee_item, false);
						// $cart_items = $cart->get_items();
						$cart_items = $cart->get_list_sort_by_receipt_sort_order();
					}

					foreach (array_reverse($cart_items, true) as $line1 => $item) {

						if($this->config->item('hide_repair_items_on_receipt')){
							if($item->is_repair_item == 1){
								continue;
							}
						}

						$line = $item->line_index;

						if ($item->tax_included) {
							if (get_class($item) == 'PHPPOSCartItemSale') {
								if ($item->tax_included) {
									$this->load->helper('items');
									$unit_price = to_currency_no_money(get_price_for_item_including_taxes($item->item_id, $item->unit_price));
									$price_including_tax = $unit_price;
									$price_excluding_tax = get_price_for_item_excluding_taxes($item->item_id, $unit_price);
								}
							} else {
								if ($item->tax_included) {
									$this->load->helper('item_kits');
									$unit_price = to_currency_no_money(get_price_for_item_kit_including_taxes($item->item_kit_id, $item->unit_price));
									$price_including_tax = $unit_price;
									$price_excluding_tax = get_price_for_item_kit_excluding_taxes($item->item_kit_id, $unit_price);
								}
							}
						} else {
							$unit_price = $item->unit_price;

							//item
							if (get_class($item) == 'PHPPOSCartItemSale') {
								$this->load->helper('items');
								$price_excluding_tax = $unit_price;
								$price_including_tax = get_price_for_item_including_taxes($item->item_id, $item->unit_price);
							} else //Kit
							{
								$this->load->helper('item_kits');
								$price_excluding_tax = $unit_price;
								$price_including_tax = get_price_for_item_kit_including_taxes($item->item_kit_id, $item->unit_price);
							}
						}
						$price_including_tax = $price_including_tax * (1 - ($item->discount / 100));
						$price_excluding_tax = $price_excluding_tax * (1 - ($item->discount / 100));
						$item_tax_amount = ($price_including_tax - $price_excluding_tax);

						if ($item->quantity > 0 && $item->name != lang('common_store_account_payment', '', array(), FALSE) && $item->name != lang('common_discount', '', array(), FALSE) && $item->name != lang('common_refund', '', array(), FALSE) && $item->name != lang('common_fee', '', array(), FALSE)) {
							$number_of_items_sold = $number_of_items_sold + $item->quantity;
						} elseif ($item->quantity < 0 && $item->name != lang('common_store_account_payment', '', array(), FALSE) && $item->name != lang('common_discount', '', array(), FALSE) && $item->name != lang('common_refund', '', array(), FALSE) && $item->name != lang('common_fee', '', array(), FALSE)) {
							$number_of_items_returned = $number_of_items_returned + abs($item->quantity);
						}

						$item_number_for_receipt = false;

						if ($this->config->item('show_item_id_on_receipt')) {
							switch ($this->config->item('id_to_show_on_sale_interface')) {
								case 'number':
									$item_number_for_receipt = property_exists($item, 'item_number') ? H($item->item_number) : H($item->item_kit_number);
									break;

								case 'product_id':
									$item_number_for_receipt = property_exists($item, 'product_id') ? H($item->product_id) : '';
									break;

								case 'id':
									$item_number_for_receipt = property_exists($item, 'item_id') ? H($item->item_id) : 'KIT ' . H($item->item_kit_id);
									break;

								default:
									$item_number_for_receipt = property_exists($item, 'item_number') ? H($item->item_number) : H($item->item_kit_number);
									break;
							}
						}

					?>
						
									
									
								
					<?php
					}
					?>
				

				<?php
			
				
				?>
				
					
					<?php
					$total_tax_amount = 0;
					if ($this->config->item('group_all_taxes_on_receipt')) {
						$total_tax = 0;
						foreach ($taxes as $name => $value) {
							$total_tax += $value;
						}
					?>
					

						<?php
					} else {
						$total_tax = 0;
						foreach ($taxes as $name => $value) { 
							$total_tax += $value;
						?>
							
					<?php
						}
						$total_tax_amount = to_currency($total_tax);

					}
					?>

					

								



																		<!--begin::Table row-->
																		<tr>
																			<!--begin::Checkbox-->
																			<td>
																				<div class="form-check form-check-sm form-check-custom form-check-solid">
																					<input class="form-check-input" type="checkbox" value="1" />
																				</div>
																			</td>
																			<!--end::Checkbox-->
																			<!--begin::Order ID=-->
																			<td data-kt-ecommerce-order-filter="order_id">
                                                                            <?php echo $order['sales']->sale_id ?>
																			</td>
																			<!--end::Order ID=-->
																			<!--begin::Customer=-->
																			<td>
																				<div class="d-flex align-items-center">
																						<?php echo $customername; ?>
																				</div>
																			</td>
																			<td data-kt-ecommerce-order-filter="order_id">
                                                                            <?php echo $order['sales']->delivery_type ?>
																			</td>
																			<!--end::Customer=-->
																			<!--begin::Status=-->
																			<td class="text-end pe-0" data-order="<?php echo $order['sales']->order_status ?>">
																				<!--begin::Badges-->
																				<div class="badge badge-primary"><?php echo $order['sales']->order_status ?></div>
																				<!--end::Badges-->
																			</td>
																			<!--end::Status=-->
																			<!--begin::Total=-->
																			<td class="text-end pe-0">
																				<span class="fw-bold"><?php if (isset($exchange_name) && $exchange_name) { ?>
																			<?php echo $total_invoice_amount = $this->config->item('round_cash_on_sales') && $is_sale_cash_payment ?  to_currency_as_exchange($cart, round_to_nearest_05($total + $tip_amount)) : to_currency_as_exchange($cart, $total + $tip_amount); ?>
																		<?php } else {  ?>
																			<?php echo $total_invoice_amount = $this->config->item('round_cash_on_sales') && $is_sale_cash_payment ?  to_currency(round_to_nearest_05($total + $tip_amount)) : to_currency($total + $tip_amount); ?>
																		<?php } ?></span>
																			</td>
																			<!--end::Total=-->
																			<!--begin::Date Added=-->
																			<td class="text-end" data-order="2022-06-21">
																				<span class="fw-bold"><?php echo date( "d/m/Y" , strtotime ($order['sales']->from_new_time)); ?></span>
																			</td>
																			<!--end::Date Added=-->
																			<!--begin::Date Modified=-->
																			<td class="text-end" data-order="2022-06-22">
																				<span class="fw-bold">22/06/2022</span>
																			</td>
																			<!--end::Date Modified=-->
																			<!--begin::Action=-->
																			<td class="text-end">
																				<a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
																				<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
																				<span class="svg-icon svg-icon-5 m-0">
																					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																						<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
																					</svg>
																				</span>
																				<!--end::Svg Icon--></a>
																				<!--begin::Menu-->
																				<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																					<!--begin::Menu item-->
																					<div class="menu-item px-3">
																						<a href="../dist/apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
																					</div>
																					<!--end::Menu item-->
																					<!--begin::Menu item-->
																					<div class="menu-item px-3">
																						<a href="../dist/apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
																					</div>
																					<!--end::Menu item-->
																					<!--begin::Menu item-->
																					<div class="menu-item px-3">
																						<a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
																					</div>
																					<!--end::Menu item-->
																				</div>
																				<!--end::Menu-->
																			</td>
																			<!--end::Action=-->
																		</tr>

                                                                        <?php endforeach; endif; ?>
																		<!--end::Table row-->
																	</tbody>
																	<!--end::Table body-->
																</table>
																<!--end::Table-->
															</div>
															<!--end::Card body-->
														</div>
														<!--end::Products-->
													</div>



 <script src="<?php echo base_url().'assets/css_good/plugins/custom/datatables/datatables.bundle.js?'.ASSET_TIMESTAMP;?>" type="text/javascript" charset="UTF-8"> </script>

<script src="<?php echo base_url().'assets/css_good/js/custom/apps/ecommerce/sales/listing.js?'.ASSET_TIMESTAMP;?>" type="text/javascript" charset="UTF-8"></script>
