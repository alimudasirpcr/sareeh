
<style>
	<?php
$img_background_image='';
	if ($receipt_pos['background_image']) {
		$img_background_image = cacheable_app_file_url($receipt_pos['background_image']);
	}
	?>@media print {
		.elementWithBackground {

			background-position: center center !important;
			background-repeat: no-repeat !important;
			-webkit-print-color-adjust: exact;
			print-color-adjust: exact;
			background-image: url(<?php echo $img_background_image; ?>) !important;
			page-break-after: always !important;
		}

		#border_line {
			/* border-top: solid 1px black; */
			background-size: 210mm 1mm !important;
			background-color: black;
			-webkit-print-color-adjust: exact;
			print-color-adjust: exact;
		}

		#border_line2 {
			/* border-top: solid 1px black; */
			background-size: 210mm 2mm !important;
			background-color: black !important;
			-webkit-print-color-adjust: exact;
			print-color-adjust: exact;
		}

		.A4 {
			background-size: 210mm 297mm !important;
		}

		.A3 {
			background-size: 260mm 420mm !important;
		}

		.A5 {

			background-size: 148mm 210mm !important;
		}

		.Letter {

			background-size: 216mm 279mm !important;
		}

		.Legal {

			background-size: 216mm 356mm !important;
		}

		.Executive {

			background-size: 184mm 267mm !important;
		}

		.B4 {

			background-size: 250mm 353mm !important;
		}

		.B5 {
			background-size: 176mm 250mm !important;
		}
	}
</style>
<?php $positions = json_decode($receipt_pos['positions']);


$pos_company_name = false;
$pos_location_name = false;
$pos_location_address = false;
$pos_location_phone = false;
$pos_datetime = false;
$pos_saleid = false;
$pos_register_name = false;
$pos_employee_name = false;
$pos_customer_name = false;
$pos_customer_address = false;
$pos_customer_phone = false;
$pos_customer_email = false;
$pos_items_list = false;
$pos_subtotal = false;
$pos_total = false;
$pos_weight = false;
$pos_no_of_items = false;
$pos_points = false;
$pos_amount_due = false;
$pos_barcode = false;
$pos_logo = false;
$custom_text = false;
$custom_logo = false;
$pos_exchange_name = false;
$pos_exchange_rate = false;
$pos_tax_amount = false;
$pos_comment_on_receipt = false;
$pos_item_returned = false;
$pos_payments = false;
$pos_giftcard_balance = false;
$pos_ebt_balance = false;
$pos_customer_balance_for_sale = false;
$pos_sales_until_discount = false;
$pos_ref_no = false;
$pos_auth_code = false;
$pos_taxable_subtotal = false;
$pos_taxable_summary = false;
$pos_non_taxable_subtotal = false;
$pos_amount_change = false;
$pos_amount_discount = false;
$pos_coupons = false;
$pos_announcement = false;
$pos_signature = false;

$i = 1;
foreach ($positions as $subArray) {
	if (isset($subArray->id) && $subArray->id === 'company_name') {
		$pos_company_name = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'location_name') {
		$pos_location_name = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'location_address') {
		$pos_location_address = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'location_phone') {
		$pos_location_phone = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'datetime') {
		$pos_datetime = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'saleid') {
		$pos_saleid = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'register_name') {
		$pos_register_name = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'employee_name') {
		$pos_employee_name = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'customer_name') {
		$pos_customer_name = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'customer_address') {
		$pos_customer_address = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'customer_phone') {
		$pos_customer_phone = $i;
	}

	if (isset($subArray->id) && $subArray->id === 'customer_email') {
		$pos_customer_email = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'items_list') {
		$pos_items_list = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'subtotal') {
		$pos_subtotal = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'total') {
		$pos_total = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'weight') {
		$pos_weight = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'no_of_items') {
		$pos_no_of_items = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'points') {
		$pos_points = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'amount_due') {
		$pos_amount_due = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'barcode') {
		$pos_barcode = $i;
	}

	if (isset($subArray->id) && $subArray->id === 'logo') {
		$pos_logo = $i;
	}
	if (isset($subArray->id) && $subArray->id === 'custom_text') {
		$pos_custom_text = $i;
	}

	if (isset($subArray->id) && $subArray->id === 'custom_logo') {
		$pos_custom_logo = $i;
	}

	if (isset($subArray->id) && $subArray->id === 'exchange_name') {
		$pos_exchange_name = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'exchange_rate') {
		$pos_exchange_rate = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'tax_amount') {
		$pos_tax_amount = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'comment_on_receipt') {
		$pos_comment_on_receipt = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'item_returned') {
		$pos_item_returned = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'payments') {
		$pos_payments = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'giftcard_balance') {
		$pos_giftcard_balance = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'ebt_balance') {
		$pos_ebt_balance = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'customer_balance_for_sale') {
		$pos_customer_balance_for_sale = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'sales_until_discount') {
		$pos_sales_until_discount = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'ref_no') {
		$pos_ref_no = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'auth_code') {
		$pos_auth_code = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'taxable_subtotal') {
		$pos_taxable_subtotal = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'taxable_summary') {
		$pos_taxable_summary = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'non_taxable_subtotal') {
		$pos_non_taxable_subtotal = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'amount_change') {
		$pos_amount_change = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'amount_discount') {
		$pos_amount_discount = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'coupons') {
		$pos_coupons = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'announcement') {
		$pos_announcement = $i;
	} elseif (isset($subArray->id) && $subArray->id === 'signature') {
		$pos_signature = $i;
	}



	$i++;
}




?>
<?php
$this->load->helper('sale');

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



if ($receipt_pos['background_image']) {
	$img_background_image = cacheable_app_file_url($receipt_pos['background_image']);
}
?>
<div style="margin:0 auto; height:auto; <?php if ($receipt_pos['background_image']) { ?> background-size: contain; background-position: center top;  
 background-repeat: repeat-y;   background-image: url(<?= $img_background_image; ?>); <?php } ?> <?php echo $this->config->item('uppercase_receipts') ? 'text-transform: uppercase !important' : ''; ?>" class="row manage-table elementWithBackground <?= $receipt_pos['size'] ?> card p-5 mt-5 receipt_<?php echo $this->config->item('receipt_text_size') ? $this->config->item('receipt_text_size') : 'small'; ?>" id="receipt_wrapper">
	<div class="col-md-12 <?= $receipt_pos['size'] ?>" id="receipt_wrapper_inner">
		<div class=" " style="-webkit-box-shadow: none;border: none;">
			<div class=" panel-pad">
				<div class="row"> <?php
									// Filter the array to include only items with 'rectangle' in the id
									$filteredPositions = array_filter($positions, function ($item) {
										return strpos($item->id, 'rectangle') !== false;
									});

									// If you need to access the filtered array, you can loop through $filteredPositions
									foreach ($filteredPositions as $position) {
										// Access your properties like $position->id, $position->newleft, etc.
									?>
						<div class="resize transparent-rectangle" style="position: absolute; width:<?= $position->newwidth;  ?>px;height:<?= $position->newheight;  ?>px; text-wrap:nowrap; left:<?= $position->newleft;  ?>; top:<?= $position->newtop;  ?>; " data-left="<?= $position->newleft;  ?>" data-top="<?= $position->newtop;  ?>" data-current_width="<?= $position->newwidth;  ?>" data-current_height="<?= $position->newheight;  ?>" id="<?= $position->id ?>"></div>

					<?php
									}

									// Filter the array to include only items with 'rectangle' in the id
									$filteredPositions_border = array_filter($positions, function ($item) {
										return strpos($item->id, 'border_line') !== false;
									});

									// If you need to access the filtered array, you can loop through $filteredPositions
									foreach ($filteredPositions_border as $position) {
										// Access your properties like $position->id, $position->newleft, etc.
					?>
						<div class="resize border_line" style="position: absolute; width:<?= $position->newwidth;  ?>px;height:<?= $position->newheight;  ?>px; text-wrap:nowrap; left:<?= $position->newleft;  ?>; top:<?= $position->newtop;  ?>; " data-left="<?= $position->newleft;  ?>" data-top="<?= $position->newtop;  ?>" data-current_width="<?= $position->newwidth;  ?>" data-current_height="<?= $position->newheight;  ?>" id="<?= $position->id ?>"></div>

					<?php
									}

									if ($pos_custom_text !== 'false') {
					?>
						<div class="add_top draggable fw-bold" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$pos_custom_text - 1]->newleft;  ?>; top:<?= $positions[$pos_custom_text - 1]->newtop;  ?>; " data-left="<?= $positions[$pos_custom_text - 1]->newleft;  ?>" data-top="<?= $positions[$pos_custom_text - 1]->newtop;  ?>" id="custom_text"><?= $receipt_pos['custom_text']; ?></div>

					<?php }
					?>

					<div class="col-md-12 col-sm-12 col-xs-12 ">

						<?php if ($pos_company_name != false) : ?>

							<?php if ($this->Location->count_all() > 1) { ?>
								<div class="company-title fw-bold" style="position: absolute; width:30%; left:<?= $positions[$pos_company_name - 1]->newleft;  ?>; top:<?= $positions[$pos_company_name - 1]->newtop;  ?>; "><?php echo H($company); ?></div>
								<?php if ($pos_location_name != false) : ?>
									<?php if (!$this->config->item('hide_location_name_on_receipt')) { ?>
										<div style="position: absolute; width:30%; left:<?= $positions[$pos_location_name - 1]->newleft;  ?>; top:<?= $positions[$pos_location_name - 1]->newtop;  ?>; "><?php echo H($this->Location->get_info_for_key('name', isset($override_location_id) ? $override_location_id : FALSE)); ?></div>
									<?php } ?>
								<?php

								endif;

								?>

							<?php } else {
							?>
								<div class="company-title fw-bold" style="position: absolute; width:30%; left:<?= $positions[$pos_company_name - 1]->newleft;  ?>; top:<?= $positions[$pos_company_name - 1]->newtop;  ?>; "><?php echo H($company); ?></div>
						<?php
							}
						endif;

						?>
						<?php if ($pos_location_address != false) : ?>
							<div class="nl2br" style="position: absolute; width:30%; left:<?= $positions[$pos_location_address - 1]->newleft;  ?>; top:<?= $positions[$pos_location_address - 1]->newtop;  ?>; "><?php echo H($this->Location->get_info_for_key('address', isset($override_location_id) ? $override_location_id : FALSE)); ?></div>
						<?php

						endif;

						?>
						<?php if ($pos_location_phone != false) : ?>
							<div style="position: absolute; width:30%; left:<?= $positions[$pos_location_phone - 1]->newleft;  ?>; top:<?= $positions[$pos_location_phone - 1]->newtop;  ?>; "><?php echo H($this->Location->get_info_for_key('phone', isset($override_location_id) ? $override_location_id : FALSE)); ?></div>

						<?php

						endif;

						?>

						<ul class="list-unstyled invoice-address" style="margin-bottom:2px;">

							<?php if ($pos_logo != false) : ?>
								<?php if ($company_logo) { ?>

									<?php
									if (!(isset($standalone) && $standalone)) {
									?>

										<li class="invoice-logo">
											<img style="position: absolute; width:<?= $positions[$pos_logo - 1]->newwidth;  ?>px;height:<?= $positions[$pos_logo - 1]->newheight;  ?>px; text-wrap:nowrap; left:<?= $positions[$pos_logo - 1]->newleft;  ?>; top:<?= $positions[$pos_logo - 1]->newtop;  ?>;" src="<?php echo secure_app_file_url($company_logo); ?>">

										</li>
									<?php } ?>
								<?php } ?>

							<?php endif; ?>




							<?php
							if ($tax_id) {
							?>
								<li class="tax-id-title"><?php echo lang('tax_id') . ': ' . H($tax_id); ?></li>
							<?php
							}
							?>

							<?php if ($website) { ?>
								<li><?php echo H($website); ?></li>
							<?php } ?>
						</ul>
					</div>
					<!--  sales-->

					<?php if ($receipt_title && (!isset($sale_type) || $sale_type != $this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate'))) { ?>
						<?php echo H($receipt_title); ?><?php echo ($total) < 0 ? ' (' . lang('sales_return', '', array(), TRUE) . ')' : ''; ?>
						<br>
					<?php } ?>

					<?php if ($pos_datetime != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_datetime - 1]->newleft;  ?>; top:<?= $positions[$pos_datetime - 1]->newtop;  ?>; "><?php echo H($transaction_time) ?></strong>
					<?php

					endif;

					?>

					<?php if ($pos_saleid != false) : ?>
						<span style="position: absolute; width:30%; left:<?= $positions[$pos_saleid - 1]->newleft;  ?>; top:<?= $positions[$pos_saleid - 1]->newtop;  ?>; ">
							<?php
							if (version_compare(PHP_VERSION, '7.2', '>=')  && function_exists('bcadd')) {
								require_once(APPPATH . "libraries/hashids/vendor/autoload.php");

								$hashids = new Hashids\Hashids(base_url());
								$sms_id = $hashids->encode($sale_id_raw);
								$signature = $this->Sale->get_receipt_signature($sale_id_raw);

							?>
								<div class="remove_when_mobile"><span><?php echo lang('sale_id', '', array(), TRUE) . ":"; ?></span><?php echo anchor(site_url('r/' . $sms_id . '?signature=' . $signature), $sale_id); ?>
									<div class="keep_when_mobile" style="display: none"><span><?php echo lang('sale_id', '', array(), TRUE) . ":"; ?></span><?php echo H($sale_id); ?> </div>
								</div>
							<?php
							} else {
							?>
								<div><span><?php echo lang('sale_id', '', array(), TRUE) . ":"; ?></span><?php echo H($sale_id); ?> </div>
							<?php
							}
							?>
							<div>
								<?php
								if ($return_sale_id) {
									echo ' (' . lang('sales_return') . ' ' . ($this->config->item('sale_prefix') ? $this->config->item('sale_prefix') : 'POS') . ' ' . $return_sale_id . ')';
								}
								?>
							</div>


						</span>

					<?php endif; ?>

					<?php if ($pos_register_name != false) : ?>

						<?php
						if ($this->Register->count_all(isset($override_location_id) ? $override_location_id : FALSE) > 1 && $register_name) {
						?>
							<div style="position: absolute; width:30%; left:<?= $positions[$pos_register_name - 1]->newleft;  ?>; top:<?= $positions[$pos_register_name - 1]->newtop;  ?>; "><span><?php echo lang('register_name', '', array(), TRUE) . ':'; ?></span><?php echo H($register_name); ?></div>
						<?php
						}
						?>
					<?php endif; ?>

					<?php if ($pos_employee_name != false) : ?>
						<span style="position: absolute; width:30%; left:<?= $positions[$pos_employee_name - 1]->newleft;  ?>; top:<?= $positions[$pos_employee_name - 1]->newtop;  ?>; ">
							<ul class="list-unstyled">
								<?php
								if (!$this->config->item('remove_employee_from_receipt')) { ?>
									<li><span><?php echo $this->config->item('override_employee_label_on_receipt') ? $this->config->item('override_employee_label_on_receipt') : lang('employee', '', array(), TRUE) . ":"; ?></span><?php echo H($this->config->item('remove_employee_lastname_from_receipt') ? $employee_firstname : $employee); ?></li>
									<?php
									foreach ($employee_custom_fields_to_display as $custom_field_id) {
										$employee_info = $this->Employee->get_info($sold_by_employee_id);

										if ($employee_info->{"custom_field_${custom_field_id}_value"}) { ?>
											<div class="invoice-desc">
												<?php
												if ($this->Employee->get_custom_field($custom_field_id, 'type') == 'checkbox') {
													$format_function = 'boolean_as_string';
												} elseif ($this->Employee->get_custom_field($custom_field_id, 'type') == 'date') {
													$format_function = 'date_as_display_date';
												} elseif ($this->Employee->get_custom_field($custom_field_id, 'type') == 'email') {
													$format_function = 'strsame';
												} elseif ($this->Employee->get_custom_field($custom_field_id, 'type') == 'url') {
													$format_function = 'strsame';
												} elseif ($this->Employee->get_custom_field($custom_field_id, 'type') == 'phone') {
													$format_function = 'format_phone_number';
												} elseif ($this->Employee->get_custom_field($custom_field_id, 'type') == 'image') {
													$this->load->helper('url');
													$format_function = 'file_id_to_image_thumb_right';
												} elseif ($this->Employee->get_custom_field($custom_field_id, 'type') == 'file') {
													$this->load->helper('url');
													$format_function = 'file_id_to_download_link';
												} else {
													$format_function = 'strsame';
												}
												echo '<li><span>' . lang('employee', '', array(), TRUE) . ' ' . ($this->Employee->get_custom_field($custom_field_id, 'hide_field_label') ? '' : $this->Employee->get_custom_field($custom_field_id, 'name') . ':') . '</span> ' . $format_function($employee_info->{"custom_field_${custom_field_id}_value"}) . '</li>';
												?>
											</div>
								<?php
										}
									}
								}
								?>
							</ul>
						</span>
					<?php endif; ?>

					<div class="col-md-4 col-sm-4 col-xs-12">
						<ul class="list-unstyled invoice-detail" style="margin-bottom:2px;">





							<?php if (isset($deleted) && $deleted) { ?>
								<li><span class="text-danger" style="color: #df6c6e;"><strong><?php echo lang('sales_deleted_voided', '', array(), TRUE); ?></strong></span></li>
							<?php } ?>
							<?php if (isset($sale_type)) { ?>
								<li><?php echo H($sale_type); ?></li>
							<?php } ?>

							<?php if ($is_ecommerce) { ?>
								<li><?php echo lang('ecommerce', '', array(), TRUE); ?></li>
							<?php } ?>



							<?php
							if ($tier && !$this->config->item('hide_tier_on_receipt')) {
							?>
								<li><span><?php echo $this->config->item('override_tier_name') ? $this->config->item('override_tier_name') : lang('tier_name', '', array(), TRUE) . ':'; ?></span><?php echo H($tier); ?></li>
							<?php
							}
							?>

							<?php


							if (H($this->Location->get_info_for_key('enable_credit_card_processing', isset($override_location_id) ? $override_location_id : FALSE))) {
								if (!$this->config->item('hide_merchant_id_from_receipt')) {
									echo '<li id="merchant_id"><span>' . lang('merchant_id', '', array(), TRUE) . ':</span> ' . H($this->Location->get_merchant_id(isset($override_location_id) ? $override_location_id : FALSE)) . '</li>';
								}
							}
							?>
						</ul>
					</div>
					<?php if (isset($customer)) { ?>
						<?php if ($pos_customer_name != false) : ?>
							<ul class="list-unstyled " style="position: absolute; width:30%; left:<?= $positions[$pos_customer_name - 1]->newleft;  ?>; top:<?= $positions[$pos_customer_name - 1]->newtop;  ?>; ">
								<?php if (!$this->config->item('remove_customer_name_from_receipt')) { ?>
									<li class="invoice-to"><?php echo lang('sales_invoice_to', '', array(), TRUE); ?>:</li>
									<li><?php echo lang('customer', '', array(), TRUE) . ": " . H($customer); ?></li>

								<?php } ?>

								<?php if ($this->config->item('show_person_id_on_receipt') && $customer_id) { ?>
									<li><?php echo lang('person_id', '', array(), TRUE) . ": " . H($customer_id); ?></li>
								<?php } ?>

								<?php if (!$this->config->item('remove_customer_company_from_receipt')) { ?>
									<?php if (!empty($customer_company)) { ?><li><?php echo lang('company', '', array(), TRUE) . ": " . H($customer_company); ?></li><?php } ?>
								<?php } ?>
							</ul>
						<?php endif; ?>


					<?php } ?>

					<?php if (isset($customer)) { ?>
						<?php if ($pos_customer_address != false) : ?>
							<ul class="list-unstyled " style="position: absolute; width:30%; left:<?= $positions[$pos_customer_address - 1]->newleft;  ?>; top:<?= $positions[$pos_customer_address - 1]->newtop;  ?>; ">

								<?php if (!$this->config->item('remove_customer_contact_info_from_receipt')) { ?>
									<?php if (!empty($customer_address_1) || !empty($customer_address_2)) { ?><li><?php echo lang('address', '', array(), TRUE); ?> : <?php echo H($customer_address_1 . ' ' . $customer_address_2); ?></li><?php } ?>
								<?php } ?>

								<?php if (!empty($customer_city)) {
									echo '<li>' . H($customer_city . ' ' . $customer_state . ', ' . $customer_zip) . '</li>';
								} ?>
								<?php if (!empty($customer_country)) {
									echo '<li>' . H($customer_country) . '</li>';
								} ?>


							</ul>
						<?php endif; ?>


					<?php } ?>

					<?php if (isset($customer)) { ?>
						<?php if ($pos_customer_phone != false) : ?>
							<ul class="list-unstyled " style="position: absolute; width:30%; left:<?= $positions[$pos_customer_phone - 1]->newleft;  ?>; top:<?= $positions[$pos_customer_phone - 1]->newtop;  ?>; ">

								<?php if (!empty($customer_phone)) { ?><li style="font-weight: bold;"><?php echo lang('phone_number', '', array(), TRUE); ?> : <?php echo H(format_phone_number($customer_phone)); ?></li><?php } ?>

							</ul>
						<?php endif; ?>


					<?php } ?>



					<?php if (isset($customer)) { ?>
						<?php if ($pos_customer_email != false) : ?>
							<ul class="list-unstyled " style="position: absolute; width:30%; left:<?= $positions[$pos_customer_email - 1]->newleft;  ?>; top:<?= $positions[$pos_customer_email - 1]->newtop;  ?>; ">

								<?php if (!$this->config->item('hide_email_on_receipts')) { ?>
									<?php if (!empty($customer_email)) { ?><li><?php echo lang('email', '', array(), TRUE); ?> : <?php echo H($customer_email); ?></li><?php } ?>
								<?php } ?>

							</ul>
						<?php endif; ?>




					<?php } ?>

					<!-- to address-->
					<div class="col-md-4 col-sm-4 col-xs-12">

						<?php if (isset($customer)) { ?>
							<ul class="list-unstyled invoice-address invoiceto" style="margin-bottom:2px;">



								<?php
								foreach ($customer_custom_fields_to_display as $custom_field_id) {
								?>
									<?php
									$customer_info = $this->Customer->get_info($customer_id);

									if ($customer_info->{"custom_field_${custom_field_id}_value"}) {
									?>
										<div class="invoice-desc">
											<?php

											if ($this->Customer->get_custom_field($custom_field_id, 'type') == 'checkbox') {
												$format_function = 'boolean_as_string';
											} elseif ($this->Customer->get_custom_field($custom_field_id, 'type') == 'date') {
												$format_function = 'date_as_display_date';
											} elseif ($this->Customer->get_custom_field($custom_field_id, 'type') == 'email') {
												$format_function = 'strsame';
											} elseif ($this->Customer->get_custom_field($custom_field_id, 'type') == 'url') {
												$format_function = 'strsame';
											} elseif ($this->Customer->get_custom_field($custom_field_id, 'type') == 'phone') {
												$format_function = 'format_phone_number';
											} elseif ($this->Customer->get_custom_field($custom_field_id, 'type') == 'image') {
												$this->load->helper('url');
												$format_function = 'file_id_to_image_thumb_right';
											} elseif ($this->Customer->get_custom_field($custom_field_id, 'type') == 'file') {
												$this->load->helper('url');
												$format_function = 'file_id_to_download_link';
											} else {
												$format_function = 'strsame';
											}

											echo '<li>' . ($this->Customer->get_custom_field($custom_field_id, 'hide_field_label') ? '' : $this->Customer->get_custom_field($custom_field_id, 'name') . ':') . ' ' . $format_function($customer_info->{"custom_field_${custom_field_id}_value"}) . '</li>';
											?>
										</div>
								<?php
									}
								}
								?>
							</ul>
						<?php } ?>
					</div>

					<!-- delivery address-->
					<div class="col-md-12 col-sm-12 col-xs-12">

						<?php if (isset($delivery_person_info)) { ?>
							<ul class="list-unstyled invoice-address" style="margin-bottom:10px;">
								<li class="invoice-to"><?php echo lang('deliveries_shipping_address', '', array(), TRUE); ?>:</li>
								<li><?php echo lang('name', '', array(), TRUE) . ": " . H($delivery_person_info['first_name'] . ' ' . $delivery_person_info['last_name']); ?></li>

								<?php if (!empty($delivery_person_info['address_1']) || !empty($delivery_person_info['address_2'])) { ?><li><?php echo lang('address', '', array(), TRUE); ?> : <?php echo H($delivery_person_info['address_1'] . ' ' . $delivery_person_info['address_2']); ?></li><?php } ?>
								<?php if (!empty($delivery_person_info['city'])) {
									echo '<li>' . H($delivery_person_info['city'] . ' ' . $delivery_person_info['state'] . ', ' . $delivery_person_info['zip']) . '</li>';
								} ?>
								<?php if (!empty($delivery_person_info['country'])) {
									echo '<li>' . H($delivery_person_info['country']) . '</li>';
								} ?>
								<?php if (!empty($delivery_person_info['phone_number'])) { ?><li><?php echo lang('phone_number', '', array(), TRUE); ?> : <?php echo H(format_phone_number($delivery_person_info['phone_number'])); ?></li><?php } ?>
								<?php if (!empty($delivery_person_info['email'])) { ?><li><?php echo lang('email', '', array(), TRUE); ?> : <?php echo H($delivery_person_info['email']); ?></li><?php } ?>
								<?php if (!empty($delivery_info['contact_preference'])) { ?><li><?php echo lang('deliveries_contact_preference', '', array(), TRUE); ?> : <?php echo implode(", ", is_serialized($delivery_info['contact_preference']) ? unserialize($delivery_info['contact_preference']) : $delivery_info['contact_preference']); ?></li><?php } ?>
							</ul>
						<?php } ?>

						<?php if (!empty($delivery_info['estimated_delivery_or_pickup_date']) || !empty($delivery_info['tracking_number']) ||  !empty($delivery_info['comment'])) { ?>
							<ul class="list-unstyled invoice-address" style="margin-bottom:10px;">
								<li class="invoice-to"><?php echo lang('deliveries_delivery_information', '', array(), TRUE); ?>:</li>
								<?php if (!empty($delivery_info['estimated_delivery_or_pickup_date'])) { ?><li><?php echo lang('deliveries_estimated_delivery_or_pickup_date', '', array(), TRUE); ?> : <?php echo date(get_date_format() . ' ' . get_time_format(), strtotime($delivery_info['estimated_delivery_or_pickup_date'])); ?></li><?php } ?>
								<?php if (!empty($delivery_info['tracking_number'])) { ?><li><?php echo lang('deliveries_tracking_number', '', array(), TRUE); ?> : <?php echo H($delivery_info['tracking_number']); ?></li><?php } ?>
								<?php if (!empty($delivery_info['comment'])) { ?><li><?php echo lang('comment', '', array(), TRUE); ?> : <?php echo H($delivery_info['comment']); ?></li><?php } ?>


							</ul>
						<?php } ?>
					</div>

				</div>
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
				<?php if ($pos_items_list != false) : ?>
					<table id='receipt-draggable' style=" position: absolute; width:<?= $positions[$pos_items_list - 1]->newwidth;  ?>px; left:<?= $positions[$pos_items_list - 1]->newleft;  ?>; top:<?= $positions[$pos_items_list - 1]->newtop;  ?>; ">
						<thead>
							<tr>
								<!-- invoice heading-->
								<th class="invoice-table">
									<div class="row">
										<div class="<?php echo $this->config->item('wide_printer_receipt_format') ? 'col-md-' . $x_col . ' col-sm-' . $x_col . ' col-xs-' . $x_col : 'col-md-12 col-sm-12 col-xs-12' ?>">
											<div class="invoice-head item-name"><?php echo lang('item_name', '', array(), TRUE); ?></div>
										</div>
										<div class="col-md-<?php echo $xs_col; ?> col-sm-<?php echo $xs_col; ?> col-xs-<?php echo $xs_col; ?> gift_receipt_element">
											<div class="invoice-head text-right item-price">
												<?php echo lang('price', '', array(), TRUE) . ($this->config->item('show_tax_per_item_on_receipt') ? '/' . lang('tax', '', array(), TRUE) : ''); ?>
											</div>
										</div>
										<div class="col-md-<?php echo $xs_col; ?> col-sm-<?php echo $xs_col; ?> col-xs-<?php echo $xs_col; ?>">
											<div class="invoice-head text-right item-qty"><?php echo lang('quantity', '', array(), TRUE); ?></div>
										</div>

										<?php if ($discount_exists) { ?>
											<div class="col-md-<?php echo $xs_col; ?> col-sm-<?php echo $xs_col; ?> col-xs-<?php echo $xs_col; ?> gift_receipt_element">
												<div class="invoice-head text-right item-discount"><?php echo lang('discount_percent', '', array(), TRUE); ?></div>
											</div>

										<?php } ?>
										<div class="col-md-<?php echo $xs_col; ?> col-sm-<?php echo $xs_col; ?> col-xs-<?php echo $xs_col; ?>">
											<div class="invoice-head pull-right item-total gift_receipt_element"><?php echo lang('total', '', array(), TRUE) . ($this->config->item('show_tax_per_item_on_receipt') ? '/' . lang('tax', '', array(), TRUE) : ''); ?></div>
										</div>

									</div>
								</th>
							</tr>
						</thead>
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

							if ($this->config->item('hide_repair_items_on_receipt')) {
								if ($item->is_repair_item == 1) {
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

							if ($item->quantity > 0 && $item->name != lang('store_account_payment', '', array(), FALSE) && $item->name != lang('discount', '', array(), FALSE) && $item->name != lang('refund', '', array(), FALSE) && $item->name != lang('fee', '', array(), FALSE)) {
								$number_of_items_sold = $number_of_items_sold + $item->quantity;
							} elseif ($item->quantity < 0 && $item->name != lang('store_account_payment', '', array(), FALSE) && $item->name != lang('discount', '', array(), FALSE) && $item->name != lang('refund', '', array(), FALSE) && $item->name != lang('fee', '', array(), FALSE)) {
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
							<tbody data-line="<?php echo $line; ?>" data-sale-id="<?php echo $item->cart->sale_id; ?>" data-item-id="<?php echo get_class($item) == "PHPPOSCartItemSale" ? $item->item_id : (get_class($item) == "PHPPOSCartItemKitSale" ? $item->item_kit_id : ''); ?>" data-item-name="<?php echo H($item->name); ?><?php if ($item_number_for_receipt) { ?> - <?php echo $item_number_for_receipt; ?><?php } ?><?php if ($item->size) { ?> (<?php echo H($item->size); ?>)<?php } ?>" data-item-qty="<?php echo $item->quantity; ?>" data-item-price="<?php echo $unit_price; ?>" data-item-total="<?php echo ($unit_price * $item->quantity - $unit_price * $item->quantity * $item->discount / 100) + ($item->get_modifiers_subtotal() - ($item->get_modifiers_subtotal() * $item->discount / 100)); ?>" data-item-class="<?php echo get_class($item) == "PHPPOSCartItemSale" ? 'item' : (get_class($item) == "PHPPOSCartItemKitSale" ? 'item-kit' : ''); ?>">
								<tr class="invoice-item-details">
									<!-- invoice items-->
									<td class="invoice-table-content">
										<div class="row receipt-row-item-holder">
											<div class="<?php echo $this->config->item('wide_printer_receipt_format') ? 'col-md-' . $x_col . ' col-sm-' . $x_col . ' col-xs-' . $x_col : 'col-md-12 col-sm-12 col-xs-12' ?>">
												<div class="invoice-content invoice-con">
													<div class="invoice-content-heading">
														<?php echo H($item->name); ?><?php if ($item_number_for_receipt) { ?> - <?php echo $item_number_for_receipt; ?><?php } ?><?php if ($item->size) { ?> (<?php echo H($item->size); ?>)<?php } ?>
													</div>

													<?php
													if (property_exists($item, 'quantity_unit_quantity') && $item->quantity_unit_quantity !== NULL) {
													?>
														<div class="invoice-desc">
															<?php
															echo 	lang('quantity_unit_name') . ': ' . $item->quantity_units[$item->quantity_unit_id] . ', ' . lang('quantity_units') . ': ' . H(to_quantity($item->quantity_unit_quantity));
															?>
														</div>
													<?php
													}
													if (count($item->modifier_items) > 0) { ?>
														<div class="invoice-desc">
															<?php echo to_currency($unit_price); ?>
														</div>
													<?php
													}
													foreach ($item->modifier_items as $modifier) {
													?>
														<div class="invoice-desc">
															<?php
															echo $modifier['display_name'];
															?>
														</div>
													<?php } ?>
													<div class="invoice-desc">
														<?php
														echo isset($item->variation_name) && $item->variation_name ? H($item->variation_name) : '';
														?>
													</div>
													<div class="invoice-desc">
														<?php
														if (!$this->config->item('hide_desc_on_receipt') && !$item->description == "") {
															echo nl2br(clean_html($item->description));
														}
														?>
													</div>
													<div class="invoice-desc">
														<?php
														if (isset($item->serialnumber) && $item->serialnumber != "") {
															echo H($item->serialnumber);
														}
														?>
													</div>

													<?php
													foreach ($item_custom_fields_to_display as $custom_field_id) {
														if (get_class($item) == 'PHPPOSCartItemSale' && $this->Item->get_custom_field($custom_field_id) !== false) {
															$item_info = $this->Item->get_info($item->item_id);

															if ($item_info->{"custom_field_${custom_field_id}_value"}) {
													?>
																<div class="invoice-desc">
																	<?php

																	if ($this->Item->get_custom_field($custom_field_id, 'type') == 'checkbox') {
																		$format_function = 'boolean_as_string';
																	} elseif ($this->Item->get_custom_field($custom_field_id, 'type') == 'date') {
																		$format_function = 'date_as_display_date';
																	} elseif ($this->Item->get_custom_field($custom_field_id, 'type') == 'email') {
																		$format_function = 'strsame';
																	} elseif ($this->Item->get_custom_field($custom_field_id, 'type') == 'url') {
																		$format_function = 'strsame';
																	} elseif ($this->Item->get_custom_field($custom_field_id, 'type') == 'phone') {
																		$format_function = 'format_phone_number';
																	} elseif ($this->Item->get_custom_field($custom_field_id, 'type') == 'image') {
																		$this->load->helper('url');
																		$format_function = 'file_id_to_image_thumb_right';
																	} elseif ($this->Item->get_custom_field($custom_field_id, 'type') == 'file') {
																		$this->load->helper('url');
																		$format_function = 'file_id_to_download_link';
																	} else {
																		$format_function = 'strsame';
																	}

																	echo ($this->Item->get_custom_field($custom_field_id, 'hide_field_label') ? '' : $this->Item->get_custom_field($custom_field_id, 'name') . ':') . ' ' . $format_function($item_info->{"custom_field_${custom_field_id}_value"});
																	?>
																</div>
														<?php
															}
														}
													}

													if (get_class($item) == 'PHPPOSCartItemKitSale' && $this->config->item('show_item_kit_items_on_receipt')) {
														$this->load->model('Item_kit_items');
														?>
														<div class="invoice-desc">
															<?php
															foreach ($this->Item_kit_items->get_info_kits($item->get_id()) as $ikik) {
																$item_kit_info = $this->Item_kit->get_info($ikik->item_kit_id);
																echo to_quantity($ikik->quantity) . '- ' . $item_kit_info->name . '<br />';
															}

															foreach ($this->Item_kit_items->get_info($item->get_id()) as $iki) {
																$item_info = $this->Item->get_info($iki->item_id);
																echo to_quantity($iki->quantity) . '- ' . $item_info->name . '<br />';
															}
															?>
														</div>
														<?php
													}

													foreach ($item_kit_custom_fields_to_display as $custom_field_id) {
														if (get_class($item) == 'PHPPOSCartItemKitSale' && $this->Item_kit->get_custom_field($custom_field_id) !== false && $this->Item_kit->get_custom_field($custom_field_id) !== false) {
															$item_info = $this->Item_kit->get_info($item->item_kit_id);

															if ($item_info->{"custom_field_${custom_field_id}_value"}) {
														?>
																<div class="invoice-desc">
																	<?php

																	if ($this->Item_kit->get_custom_field($custom_field_id, 'type') == 'checkbox') {
																		$format_function = 'boolean_as_string';
																	} elseif ($this->Item_kit->get_custom_field($custom_field_id, 'type') == 'date') {
																		$format_function = 'date_as_display_date';
																	} elseif ($this->Item_kit->get_custom_field($custom_field_id, 'type') == 'email') {
																		$format_function = 'strsame';
																	} elseif ($this->Item_kit->get_custom_field($custom_field_id, 'type') == 'url') {
																		$format_function = 'strsame';
																	} elseif ($this->Item_kit->get_custom_field($custom_field_id, 'type') == 'phone') {
																		$format_function = 'format_phone_number';
																	} elseif ($this->Item_kit->get_custom_field($custom_field_id, 'type') == 'image') {
																		$this->load->helper('url');
																		$format_function = 'file_id_to_image_thumb_right';
																	} elseif ($this->Item_kit->get_custom_field($custom_field_id, 'type') == 'file') {
																		$this->load->helper('url');
																		$format_function = 'file_id_to_download_link';
																	} else {
																		$format_function = 'strsame';
																	}

																	echo ($this->Item_kit->get_custom_field($custom_field_id, 'hide_field_label') ? '' : $this->Item_kit->get_custom_field($custom_field_id, 'name') . ':') . ' ' . $format_function($item_info->{"custom_field_${custom_field_id}_value"});
																	?>
																</div>
														<?php
															}
														}
														?>
													<?php
													}
													if (isset($item->rule['type'])) {
														echo '<div class="gift_receipt_element">' . H($item->rule['name']) . '</i></div>';
														if (isset($item->rule['rule_discount'])) {
															echo '<div class="gift_receipt_element"><i class="gift_receipt_element"><u class="gift_receipt_element">' . lang('discount', '', array(), TRUE) . ': ' . to_currency($item->rule['rule_discount']) . '</u></i></div>';
														}
													}
													?>
												</div>
											</div>
											<div class="col-md-<?php echo $xs_col; ?> col-sm-<?php echo $xs_col; ?> col-xs-<?php echo $xs_col; ?> gift_receipt_element">
												<div class="invoice-content item-price text-right">

													<?php if ($this->config->item('show_orig_price_if_marked_down_on_receipt') && $item->regular_price > $unit_price) { ?>
														<span class="strikethrough"><?php echo to_currency($item->regular_price, 10); ?></span>
													<?php } ?>

													<?php echo to_currency($unit_price + $item->get_modifier_unit_total(), 10) . ($this->config->item('show_tax_per_item_on_receipt') ? '/' . to_currency($item_tax_amount) : ''); ?>
												</div>
											</div>
											<div class="col-md-<?php echo $xs_col; ?> col-sm-<?php echo $xs_col; ?> col-xs-<?php echo $xs_col; ?> ">
												<div class="invoice-content item-qty text-right">
													<?php
													if ($this->config->item('number_of_decimals_for_quantity_on_receipt') && floor($item->quantity) != $item->quantity) {
														echo to_currency_no_money($item->quantity, $this->config->item('number_of_decimals_for_quantity_on_receipt'));
													} else {
														echo to_quantity($item->quantity);
													}
													?>

												</div>
											</div>
											<?php if ($discount_exists) { ?>
												<div class="col-md-<?php echo $xs_col; ?> col-sm-<?php echo $xs_col; ?> col-xs-<?php echo $xs_col; ?> gift_receipt_element">
													<div class="invoice-content item-discount text-right"><?php echo to_quantity($item->discount); ?></div>
												</div>
											<?php } ?>

											<div class="col-md-<?php echo $xs_col; ?> col-sm-<?php echo $xs_col; ?> col-xs-<?php echo $xs_col; ?> gift_receipt_element">
												<div class="invoice-content item-total pull-right">
													<?php echo to_currency(($unit_price * $item->quantity - $unit_price * $item->quantity * $item->discount / 100) + $item->get_modifiers_subtotal() - ($item->get_modifiers_subtotal() * $item->discount / 100), 10) . ($this->config->item('show_tax_per_item_on_receipt') ? '/' . to_currency($item_tax_amount * $item->quantity) : ''); ?>

													<?php if ($this->config->item('indicate_taxable_on_receipt') && $item->taxable && !empty($taxes)) {
														echo '<small>*' . lang('taxable', '', array(), TRUE) . '</small>';
													}
													?>
													<?php
													if ($this->config->item('indicate_non_taxable_on_receipt') && !($item->taxable && !empty($taxes))) {
														$label = lang('no_tax');
														if ($this->config->item('override_symbol_non_taxable') != "")
															$label = $this->config->item('override_symbol_non_taxable');
														echo '<small>*' . $label . '</small>';
													}
													?>
												</div>
											</div>
										</div>
										<?php
										$can_display_image = $this->config->item('show_images_on_receipt') && $item->main_image_id;
										if ($can_display_image) {
										?>
											<div class="row">
												<div class="invoice-desc">
													<?php
													echo img(array(
														'width' => ($this->config->item('show_images_on_receipt_width_percent') ? $this->config->item('show_images_on_receipt_width_percent') : '25') . '%',
														'src' => secure_app_file_url($item->main_image_id)
													));
													?>
												</div>
											</div>
										<?php } ?>
									</td>
								</tr>

							</tbody>
						<?php
						}
						?>
					</table>
				<?php endif; ?>
				<?php
				foreach ($sale_custom_fields_to_display as $custom_field_id) {
					if ($this->Sale->get_custom_field($custom_field_id) !== false && $this->Sale->get_custom_field($custom_field_id) !== false) {
						if ($cart->{"custom_field_${custom_field_id}_value"}) {
							if ($this->Sale->get_custom_field($custom_field_id, 'type') == 'checkbox') {
								$format_function = 'boolean_as_string';
							} elseif ($this->Sale->get_custom_field($custom_field_id, 'type') == 'date') {
								$format_function = 'date_as_display_date';
							} elseif ($this->Sale->get_custom_field($custom_field_id, 'type') == 'email') {
								$format_function = 'strsame';
							} elseif ($this->Sale->get_custom_field($custom_field_id, 'type') == 'url') {
								$format_function = 'strsame';
							} elseif ($this->Sale->get_custom_field($custom_field_id, 'type') == 'phone') {
								$format_function = 'format_phone_number';
							} elseif ($this->Sale->get_custom_field($custom_field_id, 'type') == 'image') {
								$this->load->helper('url');
								$format_function = 'file_id_to_image_thumb_right';
							} elseif ($this->Sale->get_custom_field($custom_field_id, 'type') == 'file') {
								$this->load->helper('url');
								$format_function = 'file_id_to_download_link';
							} else {
								$format_function = 'strsame';
							}
				?>
							<div class="invoice-table-content custom_fieldsssss">
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<div class="invoice-content invoice-con">
											<div class="invoice-content-heading">
												<?php
												if (!$this->Sale->get_custom_field($custom_field_id, 'hide_field_label')) {
													echo $this->Sale->get_custom_field($custom_field_id, 'name');
												} else {
													echo $format_function($cart->{"custom_field_${custom_field_id}_value"});
												}
												?>
											</div>
											<div class="invoice-desc">
												<?php
												if (!$this->Sale->get_custom_field($custom_field_id, 'hide_field_label')) {
													echo $format_function($cart->{"custom_field_${custom_field_id}_value"});
												}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
					<?php
						}
					}
					?>
					<?php
				}
				foreach ($work_order_custom_fields_to_display as $custom_field_id) {
					if ($this->Work_order->get_custom_field($custom_field_id) !== false && $this->Work_order->get_custom_field($custom_field_id) !== false) {
						if ($cart->{"work_order_custom_field_${custom_field_id}_value"}) {
							if ($this->Work_order->get_custom_field($custom_field_id, 'type') == 'checkbox') {
								$format_function = 'boolean_as_string';
							} elseif ($this->Work_order->get_custom_field($custom_field_id, 'type') == 'date') {
								$format_function = 'date_as_display_date';
							} elseif ($this->Work_order->get_custom_field($custom_field_id, 'type') == 'email') {
								$format_function = 'strsame';
							} elseif ($this->Work_order->get_custom_field($custom_field_id, 'type') == 'url') {
								$format_function = 'strsame';
							} elseif ($this->Work_order->get_custom_field($custom_field_id, 'type') == 'phone') {
								$format_function = 'format_phone_number';
							} elseif ($this->Work_order->get_custom_field($custom_field_id, 'type') == 'image') {
								$this->load->helper('url');
								$format_function = 'file_id_to_image_thumb_right';
							} elseif ($this->Work_order->get_custom_field($custom_field_id, 'type') == 'file') {
								$this->load->helper('url');
								$format_function = 'file_id_to_download_link';
							} else {
								$format_function = 'strsame';
							}
					?>
							<div class="invoice-table-content">
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<div class="invoice-content invoice-con">
											<div class="invoice-content-heading">
												<?php
												if (!$this->Work_order->get_custom_field($custom_field_id, 'hide_field_label')) {
													echo $this->Work_order->get_custom_field($custom_field_id, 'name');
												} else {
													echo $format_function($cart->{"work_order_custom_field_${custom_field_id}_value"});
												}
												?>
											</div>
											<div class="invoice-desc">
												<?php
												if (!$this->Work_order->get_custom_field($custom_field_id, 'hide_field_label')) {
													echo $format_function($cart->{"work_order_custom_field_${custom_field_id}_value"});
												}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
				<?php
						}
					}
				}
				?>


				<?php if ($pos_subtotal != false) : ?>
					<span class="add_top fw-bold" style="position: absolute;  left:<?= $positions[$pos_subtotal - 1]->newleft;  ?>; top:<?= $positions[$pos_subtotal - 1]->newtop;  ?>;  text-wrap:nowrap;">




						<?php echo lang('sub_total', '', array(), TRUE); ?>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php
															if (isset($exchange_name) && $exchange_name) {
																echo to_currency_as_exchange($cart, $subtotal);
															} else {
																echo to_currency($subtotal);
															}
															?>

					</span>
				<?php endif; ?>


				<div class="invoice-footer gift_receipt_element">
					<?php if ($pos_exchange_name != false) {
						if ($exchange_name) { ?>

							<div class="row add_top" style="position: absolute;  left:<?= $positions[$pos_exchange_name - 1]->newleft;  ?>; top:<?= $positions[$pos_exchange_name - 1]->newtop;  ?>; ">
								<div class="d-flex flex-stack mb-3">

									<div class="fw-semibold text-end text-gray-600 fs-7 w-75"><?php echo lang('exchange_to', '', array(), TRUE) . ' ' . H($exchange_name); ?></div>

									<div class="ps-10 fw-bold fs-6 text-gray-800">x <?php echo to_currency_no_money($exchange_rate); ?></div>

								</div>

							</div>

					<?php }
					} ?>


					<?php
					if ($is_on_device_tip_processor && (float)$tip_amount > 0) {
					?>
						<div class="row">
							<div class="col-md-8">
								<div class="invoice-footer-heading"><?php echo lang('tip', '', array(), TRUE); ?></div>
							</div>
							<div class="col-md-4">
								<div class="invoice-footer-value">
									<?php echo to_currency($tip_amount); ?>
								</div>
							</div>
						</div>



						<?php }
					$total_tax_amount = 0;
					if ($pos_tax_amount != false) {
						if ($this->config->item('group_all_taxes_on_receipt')) {
							$total_tax = 0;
							foreach ($taxes as $name => $value) {
								$total_tax += $value;
							}
						?>
							<div class="row add_top" style="position: absolute;   width:25%; left:<?= $positions[$pos_tax_amount - 1]->newleft;  ?>; top:<?= $positions[$pos_tax_amount - 1]->newtop;  ?>;  ">

								<div class="d-flex flex-stack mb-3">
									<div class="fw-semibold text-end text-gray-600 fs-7 w-75"><?php echo lang('tax', '', array(), TRUE); ?></div>
									<div class="ps-10 fw-bold fs-6 text-gray-800"><?php
																					if (isset($exchange_name) && $exchange_name) {
																						echo $total_tax_amount = to_currency_as_exchange($cart, $total_tax * $exchange_rate);
																					} else {
																						echo $total_tax_amount = to_currency($total_tax * $exchange_rate);
																					}
																					?></div>

								</div>

							</div>

							<?php
						} else {
							$total_tax = 0;
							foreach ($taxes as $name => $value) {
								$total_tax += $value;
							?>
								<div class="row add_top" style="position: absolute;  width:25%;  left:<?= $positions[$pos_tax_amount - 1]->newleft;  ?>; top:<?= $positions[$pos_tax_amount - 1]->newtop;  ?>;  ">
									<div class="d-flex flex-stack mb-3">
										<div class="fw-semibold text-end text-gray-600 fs-7 w-75"><?php echo H($name); ?></div>
										<div class="ps-10 fw-bold fs-6 text-gray-800"><?php
																						if (isset($exchange_name) && $exchange_name) {
																							echo to_currency_as_exchange($cart, $value * $exchange_rate);
																						} else {
																							echo to_currency($value);
																						}
																						?></div>
									</div>


								</div>
					<?php
							}
							$total_tax_amount = to_currency($total_tax);
						}
					}
					?>
					<?php if ($pos_total != false) : ?>
						<span class="add_top fw-bold" style="position: absolute;   width:20%; left:<?= $positions[$pos_total - 1]->newleft;  ?>; top:<?= $positions[$pos_total - 1]->newtop;  ?>;  text-wrap:nowrap;">
							<?php echo lang('total', '', array(), TRUE); ?>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<?php if (isset($exchange_name) && $exchange_name) { ?>
								<?php echo $total_invoice_amount = $this->config->item('round_cash_on_sales') && $is_sale_cash_payment ?  to_currency_as_exchange($cart, round_to_nearest_05($total + $tip_amount)) : to_currency_as_exchange($cart, $total + $tip_amount); ?>
							<?php } else {  ?>
								<?php echo $total_invoice_amount = $this->config->item('round_cash_on_sales') && $is_sale_cash_payment ?  to_currency(round_to_nearest_05($total + $tip_amount)) : to_currency($total + $tip_amount); ?>
							<?php } ?>
						</span>


					<?php endif; ?>

					<?php
					// Check Condition for Weight from Config file 
					if (!$this->config->item('remove_weight_from_receipt')) {
						if ($cart->get_total_weight() > 0)
					?>
						<?php if ($pos_weight != false) : ?>

							<span class="add_top" style="position: absolute;  left:<?= $positions[$pos_weight - 1]->newleft;  ?>; top:<?= $positions[$pos_weight - 1]->newtop;  ?>;  text-wrap:nowrap;">
								<?php echo lang('items_weight', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $cart->get_total_weight(); ?>
							</span>

						<?php endif; ?>
					<?php } ?>


					<?php
					if ($this->config->item('show_total_discount_on_receipt') && $pos_amount_discount && !$store_account_payment && $cart->get_total_discount()) { ?>
						<div class="row add_top" style="position: absolute;  left:<?= $positions[$pos_amount_discount - 1]->newleft;  ?>; top:<?= $positions[$pos_amount_discount - 1]->newtop;  ?>; ">
							<div class="col-md-8">
								<div class="invoice-footer-heading"><?php echo lang('sales_total_discount', '', array(), TRUE); ?></div>
							</div>
							<div class="col-md-4">
								<div class="invoice-footer-value invoice-total"><?php echo to_currency($cart->get_total_discount()); ?></div>
							</div>
						</div>

					<?php
					}
					?>


					<?php if ($pos_no_of_items != false) : ?>

						<span class="add_top" style="position: absolute;  left:<?= $positions[$pos_no_of_items - 1]->newleft;  ?>; top:<?= $positions[$pos_no_of_items - 1]->newtop;  ?>;  text-wrap:nowrap;">
							<?php echo lang('items_sold', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo to_quantity($number_of_items_sold); ?>
						</span>



					<?php endif; ?>


					<?php
					$number_of_items_returned = 5;
					if ($number_of_items_returned && $pos_item_returned != false) { ?>
						<div class="row  add_top" style="position: absolute;  width:35%; left:<?= $positions[$pos_item_returned - 1]->newleft;  ?>; top:<?= $positions[$pos_item_returned - 1]->newtop;  ?>;  "> <?php echo lang('items_returned', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo to_quantity($number_of_items_returned); ?>

						</div>
					<?php } ?>

				</div>

				<?php
				if ($pos_payments != false) {
					foreach ($payments as $payment_id => $payment) {
						$pcounter = 0;

						$tip_amount_on_payment = 0;

						if ($pcounter == 0) {
							$tip_amount_on_payment = $tip_amount;
						}
				?>
						<div class="row add_top" style="position: absolute;  width:35%; left:<?= $positions[$pos_payments - 1]->newleft;  ?>; top:<?= $positions[$pos_payments - 1]->newtop;  ?>;  ">
							<div class=" col-md-4 ">
								<div class="invoice-footer-heading"><?php echo (isset($show_payment_times) && $show_payment_times) ?  date(get_date_format() . ' ' . get_time_format(), strtotime($payment->payment_date)) : lang('payment', '', array(), TRUE); ?></div>
							</div>
							<div class="col-md-4 ">
								<?php if (($is_integrated_credit_sale || sale_has_partial_credit_card_payment($cart) || $is_sale_integrated_ebt_sale || sale_has_partial_ebt_payment($cart)) && ($payment->payment_type == lang('credit', '', array(), TRUE) ||  $payment->payment_type == lang('sales_partial_credit', '', array(), TRUE) || $payment->payment_type == lang('ebt', '', array(), TRUE) || $payment->payment_type == lang('partial_ebt', '', array(), TRUE) ||  $payment->payment_type == lang('ebt_cash', '', array(), TRUE) ||  $payment->payment_type == lang('partial_ebt_cash', '', array(), TRUE))) { ?>
									<div class="invoice-footer-value"><?php echo $is_sale_integrated_ebt_sale ? 'EBT ' : ''; ?><?php echo H($payment->card_issuer . ': ' . $payment->truncated_card); ?></div>
								<?php } else { ?>
									<div class="invoice-footer-value"><?php $splitpayment = explode(':', $payment->payment_type);
																		echo H($splitpayment[0]); ?></div>
								<?php } ?>
							</div>

							<div class="col-md-4">
								<div class="invoice-footer-value invoice-payment">



									<?php

									if (isset($exchange_name) && $exchange_name) {
									?>
										<?php echo $this->config->item('round_cash_on_sales') && $payment->payment_type == lang('cash', '', array(), TRUE) ?  to_currency_as_exchange($cart, round_to_nearest_05($payment->payment_amount + $tip_amount_on_payment)) : to_currency_as_exchange($cart, $payment->payment_amount + $tip_amount_on_payment); ?>
									<?php } else {  ?>
										<?php echo $this->config->item('round_cash_on_sales') && $payment->payment_type == lang('cash', '', array(), TRUE) ?  to_currency(round_to_nearest_05($payment->payment_amount + $tip_amount_on_payment)) : to_currency($payment->payment_amount + $tip_amount_on_payment); ?>
									<?php
									}


									?>


								</div>
							</div>

							<?php if (($is_integrated_credit_sale || sale_has_partial_credit_card_payment($cart) || $is_sale_integrated_ebt_sale || sale_has_partial_ebt_payment($cart)) && ($payment->payment_type == lang('credit', '', array(), TRUE) ||  $payment->payment_type == lang('sales_partial_credit', '', array(), TRUE) || $payment->payment_type == lang('ebt', '', array(), TRUE) || $payment->payment_type == lang('partial_ebt', '', array(), TRUE) ||  $payment->payment_type == lang('ebt_cash', '', array(), TRUE) ||  $payment->payment_type == lang('partial_ebt_cash', '', array(), TRUE))) { ?>

								<div class="col-md-offset-6 col-sm-offset-6 col-xs-offset-3 col-md-6 col-sm-6 col-xs-9">
									<?php if ($payment->entry_method) { ?>
										<div class="invoice-footer-value invoice-footer-value-cc"><?php echo lang('sales_entry_method', '', array(), TRUE) . ': ' . H($payment->entry_method); ?></div>
									<?php } ?>

									<?php if ($payment->tran_type) { ?>
										<div class="invoice-footer-value invoice-footer-value-cc"><?php echo lang('sales_transaction_type', '', array(), TRUE) . ': ' . ($is_sale_integrated_ebt_sale ? 'EBT ' : '') . H($payment->tran_type); ?></div>
									<?php } ?>

									<?php if ($payment->application_label) { ?>
										<div class="invoice-footer-value invoice-footer-value-cc"><?php echo lang('sales_application_label', '', array(), TRUE) . ': ' . H($payment->application_label); ?></div>
									<?php } ?>

									<?php if ($payment->ref_no) { ?>
										<div class="invoice-footer-value invoice-footer-value-cc"><?php echo lang('sales_ref_no', '', array(), TRUE) . ': ' . H($payment->ref_no); ?></div>
									<?php } ?>
									<?php if ($payment->auth_code) { ?>
										<div class="invoice-footer-value invoice-footer-value-cc"><?php echo lang('sales_auth_code', '', array(), TRUE) . ': ' . H($payment->auth_code); ?></div>
									<?php } ?>


									<?php if ($payment->aid) { ?>
										<div class="invoice-footer-value invoice-footer-value-cc"><?php echo 'AID: ' . H($payment->aid); ?></div>
									<?php } ?>

									<?php if ($payment->tvr) { ?>
										<div class="invoice-footer-value invoice-footer-value-cc"><?php echo 'TVR: ' . H($payment->tvr); ?></div>
									<?php } ?>


									<?php if ($payment->tsi) { ?>
										<div class="invoice-footer-value invoice-footer-value-cc"><?php echo 'TSI: ' . H($payment->tsi); ?></div>
									<?php } ?>


									<?php if ($payment->arc) { ?>
										<div class="invoice-footer-value invoice-footer-value-cc"><?php echo 'ARC: ' . H($payment->arc); ?></div>
									<?php } ?>

									<?php if ($payment->cvm) { ?>
										<div class="invoice-footer-value invoice-footer-value-cc"><?php echo 'CVM: ' . H($payment->cvm); ?></div>
									<?php } ?>
								</div>
							<?php } ?>

						</div>
				<?php
						$pcounter++;
					}
				}
				?>

				<?php
				if ($pos_giftcard_balance != false) {
					foreach ($payments as $payment) { ?>
						<?php if (strpos($payment->payment_type, lang('giftcard', '', array(), TRUE)) === 0) { ?>
							<?php $giftcard_payment_row = explode(':', $payment->payment_type); ?>

							<div class="row add_top" style="position: absolute;  width:35%; left:<?= $positions[$pos_giftcard_balance - 1]->newleft;  ?>; top:<?= $positions[$pos_giftcard_balance - 1]->newtop;  ?>;  ">
								<div class=" col-md-4 ">
									<div class="invoice-footer-heading"><?php echo lang('sales_giftcard_balance', '', array(), TRUE); ?></div>
								</div>
								<div class="col-md-4 ">
									<div class="invoice-footer-value"><?php echo H($payment->payment_type); ?></div>
								</div>
								<div class="col-md-4 ">
									<div class="invoice-footer-value invoice-payment"><?php echo to_currency($this->Giftcard->get_giftcard_value(end($giftcard_payment_row))); ?></div>
								</div>
							</div>
						<?php } ?>
				<?php }
				} ?>

				<?php
				if ($pos_ebt_balance != false) {
				?><div class="row add_top" style="position: absolute;  width:35%; left:<?= $positions[$pos_ebt_balance - 1]->newleft;  ?>; top:<?= $positions[$pos_ebt_balance - 1]->newtop;  ?>;  "> <?php
																																																					foreach ($integrated_gift_card_balances as $integrated_giftcard_number => $balance) { ?>

							<div class="col-md-4 ">
								<div class="invoice-footer-heading"><?php echo lang('sales_giftcard_balance', '', array(), TRUE); ?></div>
							</div>
							<div class="col-md-4 ">
								<div class="invoice-footer-value"><?php echo H($integrated_giftcard_number); ?></div>
							</div>
							<div class="col-md-4 ">
								<div class="invoice-footer-value invoice-payment"><?php echo to_currency($balance); ?></div>
							</div>

						<?php } ?>

						<?php if (isset($ebt_balance) && ($ebt_balance) !== FALSE) { ?>

							<div class="col-md-8 ">
								<div class="invoice-footer-heading"><?php echo lang('sales_ebt_balance_amount', '', array(), TRUE); ?></div>
							</div>
							<div class="col-md-4">
								<div class="invoice-footer-value invoice-total"><?php echo to_currency($ebt_balance); ?></div>
							</div>

						<?php
						} ?>
					</div> <?php   }
							?>

				<?php if (isset($customer_balance_for_sale) &&  $pos_customer_balance_for_sale != false  && (float)$customer_balance_for_sale && !$this->config->item('hide_store_account_balance_on_receipt')) { ?>
					<div class="row  add_top" style="position: absolute;  width:35%; left:<?= $positions[$pos_customer_balance_for_sale - 1]->newleft;  ?>; top:<?= $positions[$pos_customer_balance_for_sale - 1]->newtop;  ?>;  ">
						<div class="col-md-8">
							<div class="invoice-footer-heading"><?php echo lang('sales_customer_account_balance', '', array(), TRUE); ?></div>
						</div>
						<div class="col-md-4 ">
							<div class="invoice-footer-value invoice-total"><?php echo to_currency($customer_balance_for_sale); ?></div>
						</div>
					</div>
				<?php
				}
				?>

				<?php if (!$disable_loyalty &&   $pos_sales_until_discount != false && $this->config->item('enable_customer_loyalty_system') && isset($sales_until_discount) && !$this->config->item('hide_sales_to_discount_on_receipt') && $this->config->item('loyalty_option') == 'simple') { ?>
					<div class="row   add_top" style="position: absolute;  width:35%; left:<?= $positions[$pos_sales_until_discount - 1]->newleft;  ?>; top:<?= $positions[$pos_sales_until_discount - 1]->newtop;  ?>;  ">
						<div class="col-md-8">
							<div class="invoice-footer-heading"><?php echo lang('sales_until_discount', '', array(), TRUE); ?></div>
						</div>
						<div class="col-md-4">
							<div class="invoice-footer-value invoice-total"><?php echo $sales_until_discount <= 0 ? lang('sales_redeem_discount_for_next_sale', '', array(), TRUE) : to_quantity($sales_until_discount); ?></div>
						</div>
					</div>
				<?php
				}
				?>


				<?php if (!$disable_loyalty && $this->config->item('enable_customer_loyalty_system') && isset($customer_points) && !$this->config->item('hide_points_on_receipt') && $this->config->item('loyalty_option') == 'advanced') { ?>
					<?php if ($pos_points != false) : ?>

						<span class="add_top" style="position: absolute;  left:<?= $positions[$pos_points - 1]->newleft;  ?>; top:<?= $positions[$pos_points - 1]->newtop;  ?>;  text-wrap:nowrap;">
							<?php echo lang('points', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo to_quantity($customer_points); ?>
						</span>



					<?php endif; ?>
				<?php
				}
				?>


				<?php
				if ($ref_no && $pos_ref_no != false) {
				?>
					<div class="row  add_top" style="position: absolute;  width:35%; left:<?= $positions[$pos_ref_no - 1]->newleft;  ?>; top:<?= $positions[$pos_ref_no - 1]->newtop;  ?>;  ">
						<div class="col-md-8">
							<div class="invoice-footer-heading"><?php echo lang('sales_ref_no', '', array(), TRUE); ?></div>
						</div>
						<div class="col-md-4">
							<div class="invoice-footer-value invoice-total"><?php echo H($ref_no); ?></div>
						</div>
					</div>
				<?php
				}
				if (isset($auth_code) && $auth_code && $pos_auth_code != false) {
				?>
					<div class="row  add_top" style="position: absolute;  width:35%; left:<?= $positions[$pos_auth_code - 1]->newleft;  ?>; top:<?= $positions[$pos_auth_code - 1]->newtop;  ?>;  ">
						<div class="col-md-8 ">
							<div class="invoice-footer-heading"><?php echo lang('sales_auth_code', '', array(), TRUE); ?></div>
						</div>
						<div class="col-md-4">
							<div class="invoice-footer-value invoice-total"><?php echo H($auth_code); ?></div>
						</div>
					</div>
				<?php
				}
				?>


				<?php if ($this->config->item('taxes_summary_on_receipt')) { ?>
					<?php if ($pos_taxable_subtotal != false) : ?>
						<div class="row  add_top" style="position: absolute;  width:35%; left:<?= $positions[$pos_taxable_subtotal - 1]->newleft;  ?>; top:<?= $positions[$pos_taxable_subtotal - 1]->newtop;  ?>;  ">
							<div class="col-md-8">
								<?php
								if ($this->config->item('override_symbol_taxable_summary')) {
								?>
									<div class="invoice-footer-heading"><?php echo $this->config->item('override_symbol_taxable_summary'); ?></div>
								<?php
								} else {
								?>
									<div class="invoice-footer-heading"><?php echo lang('taxable', '', array(), TRUE); ?></div>
								<?php
								}
								?>
							</div>
							<div class="col-md-4">
								<div class="invoice-footer-value">
									<?php echo to_currency($taxable_subtotal); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<?php if ($this->config->item('taxes_summary_details_on_receipt' && $pos_taxable_summary != false)) { ?>
						<br />
						<?php
						foreach ($taxes as $tax_name => $tax_value) {
							$tax_subtotal = $cart->get_tax_subtotal($tax_name);
							$tax_line_total = $tax_value + $tax_subtotal;
						?>
							<div class="row  add_top" style="position: absolute;  width:35%; left:<?= $positions[$pos_taxable_summary - 1]->newleft;  ?>; top:<?= $positions[$pos_taxable_summary - 1]->newtop;  ?>;  ">
								<div class="col-md-8">
									<div class="invoice-footer-heading"><?php echo $tax_name . ' ' . lang('sub_total', '', array(), TRUE); ?></div>
								</div>
								<div class="col-md-4">
									<div class="invoice-footer-value">
										<?php echo to_currency($tax_subtotal); ?>
									</div>
								</div>

								<div class="col-md-8">
									<div class="invoice-footer-heading"><?php echo $tax_name . ' ' . lang('tax', '', array(), TRUE); ?></div>
								</div>
								<div class="col-md-4">
									<div class="invoice-footer-value">
										<?php echo to_currency($tax_value); ?>
									</div>
								</div>
								<div class="col-md-8">
									<div class="invoice-footer-heading"><?php echo $tax_name . ' ' . lang('total', '', array(), TRUE); ?></div>
								</div>
								<div class="col-md-4">
									<div class="invoice-footer-value">
										<?php echo to_currency($tax_line_total); ?>
									</div>
								</div>
							</div>
							<br /><br />
					<?php
						}
					}
					?>
					<?php if ($pos_non_taxable_subtotal != false) : ?>
						<div class="row   add_top" style="position: absolute;  width:35%; left:<?= $positions[$pos_non_taxable_subtotal - 1]->newleft;  ?>; top:<?= $positions[$pos_non_taxable_subtotal - 1]->newtop;  ?>;  ">
							<div class="col-md-8">
								<?php
								if ($this->config->item('override_symbol_non_taxable_summary')) {
								?>
									<div class="invoice-footer-heading"><?php echo $this->config->item('override_symbol_non_taxable_summary'); ?></div>
								<?php
								} else {
								?>
									<div class="invoice-footer-heading"><?php echo lang('reports_non_taxable', '', array(), TRUE); ?></div>
								<?php
								}
								?>
							</div>
							<div class="col-md-4">
								<div class="invoice-footer-value">
									<?php echo to_currency($non_taxable_subtotal); ?>
								</div>
							</div>


						</div>
					<?php endif; ?>
				<?php } ?>

				<?php
				$amount_change -= $tip_amount;
				if ($amount_change >= 0 && !$store_account_payment) { ?>
					<?php if ($pos_amount_due != false) : ?>

						<span class="add_top" style="position: absolute;  left:<?= $positions[$pos_amount_due - 1]->newleft;  ?>; top:<?= $positions[$pos_amount_due - 1]->newtop;  ?>;  text-wrap:nowrap;">
							<?php echo lang('change_due', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php if (isset($exchange_name) && $exchange_name) {
																														$amount_change_default_currency = $amount_change * pow($exchange_rate, -1);

																													?>

								<?php

																														if ($amount_change_default_currency != $amount_change) {
								?>
									<?php echo $this->config->item('round_cash_on_sales')  && $is_sale_cash_payment ?  to_currency_as_exchange($cart, round_to_nearest_05($amount_change)) : to_currency_as_exchange($cart, $amount_change); ?>
									<br /><?php echo lang('or', '', array(), TRUE); ?><br />
								<?php
																														}
								?>
								<?php echo $this->config->item('round_cash_on_sales')  && $is_sale_cash_payment ?  to_currency(round_to_nearest_05($amount_change_default_currency)) : to_currency($amount_change_default_currency); ?>

							<?php } else {  ?>
								<?php echo $this->config->item('round_cash_on_sales')  && $is_sale_cash_payment ?  to_currency(round_to_nearest_05($amount_change)) : to_currency($amount_change); ?>
							<?php
																													}
							?>
						</span>



					<?php endif; ?>
				<?php
				} else {
				?>
					<?php if (!$is_ecommerce) { ?>
						<?php if ($pos_amount_due != false) : ?>

							<span class="add_top" style="position: absolute;  left:<?= $positions[$pos_amount_due - 1]->newleft;  ?>; top:<?= $positions[$pos_amount_due - 1]->newtop;  ?>;  text-wrap:nowrap;">
								<?php echo lang('amount_due', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<?php if (isset($exchange_name) && $exchange_name) {
								?>
									<?php echo $this->config->item('round_cash_on_sales')  && $is_sale_cash_payment ?  to_currency_as_exchange($cart, round_to_nearest_05($amount_change * -1)) : to_currency_as_exchange($cart, $amount_change * -1); ?>
								<?php } else {  ?>
									<?php echo $this->config->item('round_cash_on_sales')  && $is_sale_cash_payment ?  to_currency(round_to_nearest_05($amount_change * -1)) : to_currency($amount_change * -1); ?>
								<?php
								}
								?>
							</span>



						<?php endif; ?>
				<?php
					}
				}
				?>


				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<?php if ($pos_comment_on_receipt != false) : ?>
							<div class="text-center invoice-policy add_top" style="position: absolute;  left:<?= $positions[$pos_comment_on_receipt - 1]->newleft;  ?>; top:<?= $positions[$pos_comment_on_receipt - 1]->newtop;  ?>; ">

								<?php if ($show_comment_on_receipt == 1) {
									echo H($comment);
								}
								?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<!-- invoice footer-->

			<div class="">
				<div class="row" style=" width:100%;">
					<?php if ($pos_barcode != false) : ?>
						<div class="col-md-12 col-sm-12 col-xs-12 add_top" style="position: absolute; width:30%; left:<?= $positions[$pos_barcode - 1]->newleft;  ?>; top:<?= $positions[$pos_barcode - 1]->newtop;  ?>; ">
							<div class="invoice-policy" id="invoice-policy-return">
								<?php echo nl2br(H($return_policy)); ?>
							</div>

							<div class="invoice-policy" id="invoice-policy-return-mobile" style="display: none;line-height:1;">
								<?php
								//hack to fix bug in html-2-canvas
								echo (str_replace(' ', '<i></i> ', H($return_policy)));
								?>
							</div>

							<div id="receipt_type_label" style="display: none;" class="receipt_type_label invoice-policy">
								<?php echo lang('sales_merchant_copy', '', array(), TRUE); ?>
							</div>

							<?php if (!$this->config->item('hide_barcode_on_sales_and_recv_receipt')) { ?>
								<?php if (!(isset($standalone) && $standalone)) { ?>
									<div id='barcode' class="invoice-policy">
										<?php echo "<img src='" . site_url('barcode/index/svg') . "?barcode=$sale_id&text=$sale_id' alt=''/>"; ?>
									</div>
								<?php } ?>
							<?php } ?>

							<?php if ($this->config->item('show_qr_code_for_sale') && !$store_account_payment) { ?>
								<?php if (!(isset($standalone) && $standalone)) { ?>
									<div id='qrcode' class="invoice-policy">
										<?php
										$qrcode = '';
										if ($this->config->item('qr_code_format') == 'sale_summary_info') {
											$qrcode_info = array(
												lang('company') . ': ' . $this->config->item('company'),
												lang('tax_id') . ': ' . $this->config->item('tax_id'),
												lang('sales_invoice_date') . ': ' . H($transaction_time),
												lang('total', '', array(), TRUE) . ': ' . strip_tags($total_invoice_amount),
												lang('tax', '', array(), TRUE) . ': ' . strip_tags($total_tax_amount)
											);

											$qrcode = implode("," . PHP_EOL, $qrcode_info);
										} else if ($this->config->item('qr_code_format') == 'saudi_arabia_digital_receipt') {

											require_once(APPPATH . "libraries/Tlvstr.php");

											$qrdata = array(
												'seller_name' => $this->config->item('company') ? $this->config->item('company') : '',
												'tax_number' => $this->config->item('tax_id') ? $this->config->item('tax_id') : '',
												'invoice_date' => date(DATE_ISO8601, strtotime($transaction_time)),
												'invoice_total_amount' => make_currency_no_money(strip_tags($total_invoice_amount)),
												'invoice_tax_amount' => make_currency_no_money(strip_tags($total_tax_amount)),
											);

											$tlvstr = new Tlvstr($qrdata);
											$qrcode = $tlvstr->generate();
										} else {
											require_once(APPPATH . "libraries/hashids/vendor/autoload.php");

											$hashids = new Hashids\Hashids(base_url());
											$sms_id = $hashids->encode($sale_id_raw);
											$qrcode = site_url('r/' . $sms_id);
										}
										?>

										<?php echo "<img src='" . site_url('qrcodegenerator/index?qrcode=' . urlencode($qrcode)) . "' alt='$sale_id'/>"; ?>
										<p style="font-size: 12px; font-family: 'themify';"> <?php echo $sale_id; ?> </p>

									</div>

								<?php } ?>
							<?php } ?>
						</div>
					<?php endif; ?>

					<div class="col-md-12 col-sm-12 col-xs-12">
						<?php
						$this->load->model('Price_rule');
						$coupons = $this->Price_rule->get_coupons_for_receipt($total);
						if (count($coupons) > 0 && $pos_coupons != false) {
						?>

							<div class="row add_top" style="position: absolute; width:30%; left:<?= $positions[$pos_coupons - 1]->newleft;  ?>; top:<?= $positions[$pos_coupons - 1]->newtop;  ?>; ">
								<div class="col-md-8">
									<div class="invoice-policy">
										<h3 class='text-center'><?php echo lang('coupons', '', array(), TRUE); ?></h3>

									</div>
								</div>
								<div class="col-md-4">
									<?php


									foreach ($coupons as $coupon) {
									?>
										<div class="invoice-policy coupon">
											<?php
											$coupon_text = H($coupon['name'] . ' - ' . $coupon['description']);
											$coupon_barcode = H($coupon['coupon_code']);
											$begins = date(get_date_format(), strtotime($coupon['start_date']));
											$expires = date(get_date_format(), strtotime($coupon['end_date']));
											?>
											<div><strong><?php echo H($coupon_text); ?></strong></div>

											<?php
											if (!(isset($standalone) && $standalone)) {
											?>
												<?php echo "<img src='" . site_url('barcode/index/svg') . "?barcode=$coupon_barcode' alt=''/>"; ?>
											<?php } ?>
											<div><?php echo lang('coupon_code', '', array(), TRUE) . ': ' . H($coupon_barcode); ?></div>
											<div><?php echo lang('begins', '', array(), TRUE) . ': ' . H($begins); ?></div>
											<div><?php echo lang('expires', '', array(), TRUE) . ': ' . H($expires); ?></div>
										</div><br />

									<?php
									}
									?>
								</div>
							</div>
						<?php
						} ?>
						<?php if ($pos_announcement != false) : ?>
							<div id="announcement" class="invoice-policy add_top" style="position: absolute; width:30%; left:<?= $positions[$pos_announcement - 1]->newleft;  ?>; top:<?= $positions[$pos_announcement - 1]->newtop;  ?>; ">
								<?php echo H($this->config->item('announcement_special')) ?>
							</div>


							<div id="announcement-mobile" class="invoice-policy add_top" style=" display: none;line-height:1; position: absolute; width:30%; left:<?= $positions[$pos_announcement - 1]->newleft;  ?>; top:<?= $positions[$pos_announcement - 1]->newtop;  ?>; ">
								<?php
								//hack to fix bug in html-2-canvas
								echo (str_replace(' ', '<i></i> ', H($this->config->item('announcement_special'))));
								?>
							</div>

						<?php endif; ?>

						<?php if ($signature_needed && !$this->config->item('hide_signature') && $pos_signature != false) { ?>
							<button class="btn btn-primary text-white hidden-print  add_top" style="position: absolute; width:30%; left:<?= $positions[$pos_signature - 1]->newleft;  ?>; top:<?= $positions[$pos_signature - 1]->newtop;  ?>; " id="capture_digital_sig_button"> <?php echo lang('sales_capture_digital_signature', '', array(), TRUE); ?> </button>
							<br />
						<?php
						}
						?>
					</div>

					<?php if (!$this->config->item('hide_signature') && $pos_signature != false) { ?>
						<div class="col-md-6 col-sm-6  add_top" style="position: absolute; width:30%; left:<?= $positions[$pos_signature - 1]->newleft;  ?>; top:<?= $positions[$pos_signature - 1]->newtop;  ?>;  margin-top:100px">
							<div id="signature">
								<?php if ($signature_needed) { ?>

									<div id="digital_sig_holder">
										<canvas id="sig_cnv" name="sig_cnv" class="signature" width="500" height="100"></canvas>
										<div id="sig_actions_container" class="pull-right">
											<?php
											if ($this->agent->is_mobile()) //Display done button first
											{
											?>
												<button class="btn btn-primary btn-radius btn-lg hidden-print" id="capture_digital_sig_done_button"> <?php echo lang('sales_done_capturing_sig', '', array(), TRUE); ?> </button>
												<button class="btn btn-primary btn-radius btn-lg hidden-print" id="capture_digital_sig_clear_button"> <?php echo lang('sales_clear_signature', '', array(), TRUE); ?> </button>
											<?php
											} else  //Display done button 2nd
											{
											?>
												<button class="btn btn-primary btn-radius btn-lg hidden-print" id="capture_digital_sig_clear_button"> <?php echo lang('sales_clear_signature', '', array(), TRUE); ?> </button>
												<button class="btn btn-primary btn-radius btn-lg hidden-print" id="capture_digital_sig_done_button"> <?php echo lang('sales_done_capturing_sig', '', array(), TRUE); ?> </button>
											<?php
											}
											?>
										</div>
									</div>

									<div id="signature_holder" style="text-align:left;">
										<?php
										if (isset($signature_file_id) && $signature_file_id) {
											if (!(isset($standalone) && $standalone)) {
												echo img(array('src' => secure_app_file_url($signature_file_id), 'width' => 250));
											}
										} else {
											if (!$is_on_device_tip_processor && $this->config->item('enable_tips') && ($is_credit_card_sale || $is_debit_card_sale)) {
												echo lang('total', '', array(), TRUE); ?>: <?php echo to_currency_as_exchange($cart, $total); ?><br /><br /><br />
										<span style='width:70px; display: inline-block;'><?php echo lang('tip', '', array(), true); ?></span> ____________________________________ <br /><br /><br />
										<span style='width:70px; display: inline-block;'><?php echo lang('sales_total_with_tip', '', array(), TRUE); ?></span> ____________________________________ <br /><br /><br />
										<?php
											} elseif ($this->config->item('enable_tips') && $tip_amount) {
												echo lang('tip', '', array(), TRUE); ?>: <?php echo to_currency($tip_amount); ?><br /><br />

									<?php
											}
									?>
									<span style='width:70px; display: inline-block; margin-bottom: 20px;'><?php echo lang('sales_signature', '', array(), TRUE); ?></span> ____________________________________

								<?php
										}
								?>

									</div>
								<?php } ?>

								<?php
								$this->load->helper('sale');
								if ($is_credit_card_sale) {
									echo $sales_card_statement;
								}
								?>

							</div>
						</div>

					<?php } ?>
				</div>
			</div>

		</div>
		<!--container-->
	</div>
</div>
</div>
</div>

<script>
    
	$(document).ready(function() {
		// $('#receipt_wrapper').css('min-height', (1200 + parseInt('<?php echo $number_of_items_sold * 35; ?>') )+'px' );

		var morepx = parseInt('<?php echo $number_of_items_sold * 45; ?>'); // Example additional pixels value, change as needed
		const height = $('#receipt-draggable').height();
		console.log(height);
		$('.add_top').each(function() {
			var $element = $(this); // The current .add_top element being iterated
			var currentTop = parseInt($element.css('top'), 10); // Gets the current top value as an integer
			var newTop = currentTop + height - 150; // Calculate the new top value
			$element.css('top', newTop + 'px'); // Set the new top value back to the element
		});


	});
</script>