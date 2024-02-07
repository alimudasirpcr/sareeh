<?php $this->load->view("partial/header_standalone"); ?>
 <style>
    /* Custom styles */
    .header {
      background-color: #489ee7;
      color: white;
      text-align: center;
      padding: 10px;
    }
    .search-box {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .input-group-lg {
      margin-top: 20px;
    }
    .form-control {
      font-size: 32px;
      height: auto;
      padding: 10px;
    }
    .input-group-addon {
      font-size: 24px;
    }
    .btn-lg {
      font-size: 32px;
      padding: 20px 40px;
      background-color: #489ee7;
      border: none;
      margin-top: 20px;
    }
    .container {
      margin-top: 80px;
    }
	
    .error-message {
         background-color: #ff8080;
         color: white;
         font-size: 28px;
         font-weight: bold;
         padding: 15px;
         border-radius: 10px;
         margin-bottom: 20px;
       }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.js" integrity="sha512-/fgTphwXa3lqAhN+I8gG8AvuaTErm1YxpUjbdCvwfTMyv8UZnFyId7ft5736xQ6CyQN4Nzr21lBuWWA9RTCXCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
	 .transparent-rectangle {
    width: 100px; /* Width of the rectangle */
    height: 50px; /* Height of the rectangle */
    background-color: transparent; /* Black background with 50% transparency */
    /* Customize further as needed */
    border: 2px solid #000 !important; /* Optional: adds a solid border */
    border-radius: 5px; /* Optional: rounds the corners of the rectangle */
  }
	.required {
		color: black;
	}

	.border_line {
		width: 200px; /* Width of the rectangle */
		height: 50px !important;  /* Height of the rectangle */
		background-color: transparent; /* Black background with 50% transparency */
		/* Customize further as needed */
		border-top: 2px solid #000 !important; /* Optional: adds a solid border */
		border-radius: 0px !important; /* Optional: rounds the corners of the rectangle */
	}
	
	.draggable {
		width: 50px;
		height: 30px;
		cursor: move;
		position: absolute;
		padding: 0px;
	}

	#dropZone {
		min-height: 1123px;
		position: relative;
		margin: 0 auto;
		border: gray 1px solid;
	}

	#items-drag {
		min-height: 300px;
	}

	.items-list {
		width: 100% !important;
	}

	.A4 {
		width: 210mm;
		height: auto;
	}

	.A3 {
		width: 260mm;
		height: 420mm;
	}

	.A5 {
		width: 148mm;
		height: 210mm;
	}

	.Letter {
		width: 216mm;
		height: 279mm;
	}

	.Legal {
		width: 216mm;
		height: 356mm;
	}

	.Executive {
		width: 184mm;
		height: 267mm;
	}

	.B4 {
		width: 250mm;
		height: 353mm;
	}

	.B5 {
		width: 176mm;
		height: 250mm;
	}

	.receipt_padd {
		margin: 0 auto;
		padding-left: 18px;
		padding-right: 17px;
	}

	<?php

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
$pos_bill_no = false;
$pos_bill_month = false;
$pos_bill_note = false;
$pos_bill_meter_no = false;
$pos_bill_area = false;
$pos_bill_current = false;
$pos_bill_previous = false;
$pos_bill_consumption = false;
$pos_bill_extra_money = false;
$pos_bill_over_dues = false;
$pos_bill_fine	= false;
$pos_bill_over_dues = false;

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
} elseif (isset($subArray->id) && $subArray->id === 'bill_no') {
    $pos_bill_no = $i;
} elseif (isset($subArray->id) && $subArray->id === 'bill_month') {
    $pos_bill_month = $i;
} elseif (isset($subArray->id) && $subArray->id === 'bill_note') {
    $pos_bill_note = $i;
} elseif (isset($subArray->id) && $subArray->id === 'bill_meter_no') {
    $pos_bill_meter_no = $i;
} elseif (isset($subArray->id) && $subArray->id === 'bill_area') {
    $pos_bill_area = $i;
} elseif (isset($subArray->id) && $subArray->id === 'bill_current') {
    $pos_bill_current = $i;
} elseif (isset($subArray->id) && $subArray->id === 'bill_previous') {
    $pos_bill_previous = $i;
} elseif (isset($subArray->id) && $subArray->id === 'bill_consumption') {
    $pos_bill_consumption= $i;
} elseif (isset($subArray->id) && $subArray->id === 'bill_extra_money') {
    $pos_bill_extra_money = $i;
} elseif (isset($subArray->id) && $subArray->id === 'bill_over_dues') {
    $pos_bill_over_dues = $i;
} elseif (isset($subArray->id) && $subArray->id === 'bill_fine') {
    $pos_bill_fine= $i;
}



	$i++;
}




?>
 <!-- Header -->
   <div class="header">
     <h1><?php echo $this->config->item('company')?></h1>
   </div>
   <div class="col-md-12 text-center hidden-print">
		<div class="row">
			<button class="btn btn-primary btn-lg" id="print_button" onclick="print_receipt()"> <?php echo lang('common_print', '', array(), TRUE); ?> </button>
		</div>
		<br />
	</div>
   <!-- Main Content -->
   <div class="container">
   <?php
$return_policy = ($loc_return_policy = $this->Location->get_info_for_key('return_policy', isset($override_location_id) ? $override_location_id : FALSE)) ? $loc_return_policy : $this->config->item('return_policy');
$company = ($company = $this->Location->get_info_for_key('company', isset($override_location_id) ? $override_location_id : FALSE)) ? $company : $this->config->item('company');
$tax_id = ($tax_id = $this->Location->get_info_for_key('tax_id', isset($override_location_id) ? $override_location_id : FALSE)) ? $tax_id : $this->config->item('tax_id');
$website = ($website = $this->Location->get_info_for_key('website', isset($override_location_id) ? $override_location_id : FALSE)) ? $website : $this->config->item('website');
$company_logo = ($company_logo = $this->Location->get_info_for_key('company_logo', isset($override_location_id) ? $override_location_id : FALSE)) ? $company_logo : $this->config->item('company_logo');

if ($receipt_pos['background_image']) {
	$img_background_image = cacheable_app_file_url($receipt_pos['background_image']);
}
?>
<div style="margin: 0px auto;height: auto;padding-top: 36px !important; <?php if ($receipt_pos['background_image']) { ?> background-size: cover; background-position: center top;  
 background-repeat: repeat-y;   background-image: url(<?= $img_background_image; ?>); <?php } ?> <?php echo $this->config->item('uppercase_receipts') ? 'text-transform: uppercase !important' : ''; ?>" class="row manage-table elementWithBackground <?= $receipt_pos['size'] ?> card p-5 receipt_<?php echo $this->config->item('receipt_text_size') ? $this->config->item('receipt_text_size') : 'small'; ?>" id="receipt_wrapper" >
	<div class="col-md-12" id="receipt_wrapper_inner" style="height: 210mm;">
		<div class="panel panel-piluku" style="-webkit-box-shadow: none;border: none;">
			<div class="panel-body panel-pad">
				<div class="row"> <?php 
				// Filter the array to include only items with 'rectangle' in the id
											$filteredPositions = array_filter($positions, function($item) {
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
											$filteredPositions_border = array_filter($positions, function($item) {
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
													<div class="add_top draggable fw-bold" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$pos_custom_text - 1]->newleft;  ?>; top:<?= $positions[$pos_custom_text -1]->newtop;  ?>; " data-left="<?= $positions[$pos_custom_text - 1 ]->newleft;  ?>" data-top="<?= $positions[$pos_custom_text -1]->newtop;  ?>" id="custom_text"><?= $receipt_pos['custom_text']; ?></div>
	
												<?php } ?>

                        <?php if ($pos_customer_address != false) : ?>
                            <div class="nl2br" style="position: absolute; width:30%; left:<?= $positions[$pos_customer_address - 1]->newleft;  ?>; top:<?= $positions[$pos_customer_address - 1]->newtop;  ?>; "><?= $meter_data['current']['address_1']; ?></div>
                        <?php endif; ?>

                          <?php if ($pos_customer_name != false) : ?>
                            <div class="nl2br" style="position: absolute; width:30%; left:<?= $positions[$pos_customer_name - 1]->newleft;  ?>; top:<?= $positions[$pos_customer_name - 1]->newtop;  ?>; "> <strong> <?= lang('customer_name') ?>: <?= $meter_data['current']['full_name']; ?> </strong></div>
                        <?php endif; ?>
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

                <?php if ($pos_datetime != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_datetime - 1]->newleft;  ?>; top:<?= $positions[$pos_datetime - 1]->newtop;  ?>; "><?= lang('billing_date') ?>: <br> <?= date(get_date_format(), strtotime($meter_data['current']['reading_date'])) ; ?></strong>
					<?php endif; ?>

                    <?php if ($pos_bill_month != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_bill_month - 1]->newleft;  ?>; top:<?= $positions[$pos_bill_month - 1]->newtop;  ?>; "><?= lang('billing_month') ?>: <br> <?= date('M Y', strtotime($meter_data['current']['reading_date'])) ; ?></strong>
					<?php endif; ?>

                    <?php if ($pos_bill_no != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_bill_no - 1]->newleft;  ?>; top:<?= $positions[$pos_bill_no - 1]->newtop;  ?>; "><?= lang('bill_no') ?>: <br> <?= $meter_data['current']['reading_id'] ; ?></strong>
					<?php endif; ?>

                    <?php if ($pos_bill_note != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_bill_note - 1]->newleft;  ?>; top:<?= $positions[$pos_bill_note - 1]->newtop;  ?>; "><?= lang('note') ?>: <br> <?= $meter_data['current']['description'] ; ?></strong>
					<?php endif; ?>
                    <?php if ($pos_bill_meter_no != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_bill_meter_no - 1]->newleft;  ?>; top:<?= $positions[$pos_bill_meter_no - 1]->newtop;  ?>; "><?= lang('meter_number') ?>: <br> <?= $meter_data['current']['meter_number'] ; ?></strong>
					<?php endif; ?>

                    <?php if ($pos_bill_area != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_bill_area - 1]->newleft;  ?>; top:<?= $positions[$pos_bill_area - 1]->newtop;  ?>; "><?= lang('bill_area') ?>: <br> <?= $meter_data['current']['city'] ; ?></strong>
					<?php endif; ?>
                    <?php if ($pos_bill_current != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_bill_current - 1]->newleft;  ?>; top:<?= $positions[$pos_bill_current - 1]->newtop;  ?>; "><?= lang('current_bill') ?>: <br> <?= $meter_data['current']['rate'] *  $meter_data['current']['reading_value'] ; ?></strong>
					<?php endif; ?>
                    <?php if ($pos_bill_previous != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_bill_previous - 1]->newleft;  ?>; top:<?= $positions[$pos_bill_previous - 1]->newtop;  ?>; "><?= lang('previous_bill') ?>: <br> <?= $meter_data['previous']['rate'] *  $meter_data['previous']['reading_value'] ; ?></strong>
					<?php endif; ?>

                    <?php if ($pos_bill_consumption != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_bill_consumption - 1]->newleft;  ?>; top:<?= $positions[$pos_bill_consumption - 1]->newtop;  ?>; "><?= lang('consumption') ?>: <br> <?=  $meter_data['current']['reading_value'] ; ?></strong>
					<?php endif; ?>

                    <?php if ($pos_bill_extra_money != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_bill_extra_money - 1]->newleft;  ?>; top:<?= $positions[$pos_bill_extra_money - 1]->newtop;  ?>; "><?= lang('extra_money') ?>: <br> <?=  $meter_data['current']['extra_money'] ; ?></strong>
					<?php endif; ?>

                    <?php if ($pos_bill_over_dues != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_bill_over_dues - 1]->newleft;  ?>; top:<?= $positions[$pos_bill_over_dues - 1]->newtop;  ?>; "><?= lang('over_dues') ?>: <br> <?=  $meter_data['current']['over_due'] ; ?></strong>
					<?php endif; ?>

                    <?php if ($pos_bill_fine != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_bill_fine - 1]->newleft;  ?>; top:<?= $positions[$pos_bill_fine - 1]->newtop;  ?>; "><?= lang('fine_delay') ?>: <br> <?=  $meter_data['current']['fine_delay'] ; ?></strong>
					<?php endif; ?>
                    <?php if ($pos_total != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_total - 1]->newleft;  ?>; top:<?= $positions[$pos_total - 1]->newtop;  ?>; "><?= lang('total') ?>: <br> <?=  $meter_data['current']['total'] ; ?></strong>
					<?php endif; ?>



                    <?php if ($pos_customer_phone != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_customer_phone - 1]->newleft;  ?>; top:<?= $positions[$pos_customer_phone - 1]->newtop;  ?>; "><?= lang('customer_phone') ?>:  <?= $meter_data['current']['phone_number'] ; ?></strong>
					<?php endif; ?>
                    <?php if ($pos_customer_email != false) : ?>
						<strong style="position: absolute; width:30%; left:<?= $positions[$pos_customer_email - 1]->newleft;  ?>; top:<?= $positions[$pos_customer_email - 1]->newtop;  ?>; "><?= lang('customer_email') ?>:  <?= $meter_data['current']['email'] ; ?></strong>
					<?php endif; ?>

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
				
                       </div>
                       </div>
                       </div>
                       </div>
                       </div>

   </div>
<script>
    function print_receipt() {
		//window.print();
		// html2canvas(document.getElementById('receipt_wrapper')).then(function(canvas) {
		// 	let imgData = canvas.toDataURL('image/png');
		// 	printJS({
		// 		printable: imgData,
		// 		type: 'image',
		// 		header: 'Your Header Here' // Optional header text
		// 	});
		// });

		let element = document.getElementById('receipt_wrapper');

		// Store original background color
		let originalBG = element.style.backgroundColor;

		// Temporarily change the background color to white
		element.style.backgroundColor = 'white';

		// Capture the element with html2canvas
		html2canvas(element).then(function(canvas) {
			// Revert the background color back to its original
			element.style.backgroundColor = originalBG;

			let imgData = canvas.toDataURL('image/png');
			printJS({
				printable: imgData,
				type: 'image',
			});
		});

	}
</script>
<?php $this->load->view("partial/footer_standalone"); ?>