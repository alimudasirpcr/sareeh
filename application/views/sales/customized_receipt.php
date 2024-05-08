<?php

if (isset($standalone) && $standalone) {
	$this->load->view("partial/header_standalone");
} else {
	$this->load->view("partial/header");
}
$positions = json_decode($receipt['positions']);
$checks = (json_decode($receipt['checks'])) ? json_decode($receipt['checks']) : [];
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.js" integrity="sha512-/fgTphwXa3lqAhN+I8gG8AvuaTErm1YxpUjbdCvwfTMyv8UZnFyId7ft5736xQ6CyQN4Nzr21lBuWWA9RTCXCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
	.transparent-rectangle {
		width: 100px;
		/* Width of the rectangle */
		height: 50px;
		/* Height of the rectangle */
		background-color: transparent;
		/* Black background with 50% transparency */
		/* Customize further as needed */
		border: 2px solid #000 !important;
		/* Optional: adds a solid border */
		border-radius: 5px;
		/* Optional: rounds the corners of the rectangle */
	}

	.required {
		color: black;
	}

	.border_line {
		width: 200px;
		/* Width of the rectangle */
		height: 50px !important;
		/* Height of the rectangle */
		background-color: transparent;
		/* Black background with 50% transparency */
		/* Customize further as needed */
		border-top: 2px solid #000 !important;
		/* Optional: adds a solid border */
		border-radius: 0px !important;
		/* Optional: rounds the corners of the rectangle */
	}
		.border-top-dotted {
    		border-top-style: dotted !important;
		}
		.border-top-double {
			border-top: 3px double #000 !important;
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
		height: 297mm;
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

	if ($receipt['background_image']) {
		$img_background_image = cacheable_app_file_url($receipt['background_image']);
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
<?php


$barcode = 'false';
$logo = 'false';
$custom_logo = 'false';
$items_list = 'false';



$dynamic_variable_names = []; 
$dynamic_variable_values = [];
foreach ($labels as $item) {
    // Create a variable with the name from label_name
    $variable_name = $item['label_name']."_var";  // Get the label name
    $$variable_name = 'false';  // Assign label_text to the variable
	$dynamic_variable_names[] = $variable_name;
	$dynamic_variable_values[$variable_name] = $item['label_text'];
}

foreach ($labels as $item) {
    // Create a variable with the name from label_name
    $variable_name = $item['label_name'];  // Get the label name


}



$i = 0;
$custom_images =[];
$shapes =[];
$lines =[];
$positions_array =[];
if (count($positions) > 0) :

	foreach ($positions as $subArray) {


		if (isset($subArray->id)){
        $positions_array[$subArray->id] = (array) $subArray;

		
			$string  = $subArray->id;
			
			if (strpos($string, 'custom_img_header_') !== false) {
				// Extract the number after 'custom_img_'
				preg_match('/custom_img_header_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$custom_images[$i]['number'] = $number;
					$custom_images[$i]['type'] = 'header';
					$custom_images[$i]['position'] = $subArray->id;
				}
		 
			} 
			if (strpos($string, 'custom_img_body_') !== false) {
				// Extract the number after 'custom_img_'
				preg_match('/custom_img_body_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$custom_images[$i]['number'] = $number;
					$custom_images[$i]['type'] = 'body';
					$custom_images[$i]['position'] = $subArray->id;
				} 
			} 
			if (strpos($string, 'custom_img_footer_') !== false) {
				// Extract the number after 'custom_img_'
				preg_match('/custom_img_footer_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$custom_images[$i]['number'] = $number;
					$custom_images[$i]['type'] = 'footer';
					$custom_images[$i]['position'] = $subArray->id;
				} 
			} 


			if (strpos($string, 'rectangle_header_') !== false) {
				// Extract the number after 'rectangle_'
				preg_match('/rectangle_header_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$shapes[$i]['number'] = $number;
					$shapes[$i]['type'] = 'header';
					$shapes[$i]['position'] = $subArray->id;
				}
		 
			} 
			if (strpos($string, 'rectangle_body_') !== false) {
				// Extract the number after 'rectangle_'
				preg_match('/rectangle_body_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$shapes[$i]['number'] = $number;
					$shapes[$i]['type'] = 'body';
					$shapes[$i]['position'] = $subArray->id;
				} 
			} 
			if (strpos($string, 'rectangle_footer_') !== false) {
				// Extract the number after 'rectangle_'
				preg_match('/rectangle_footer_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$shapes[$i]['number'] = $number;
					$shapes[$i]['type'] = 'footer';
					$shapes[$i]['position'] = $subArray->id;
				} 
			} 


			if (strpos($string, 'border_line_header_') !== false) {
				// Extract the number after 'border_line_'
				preg_match('/border_line_header_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$lines[$i]['number'] = $number;
					$lines[$i]['type'] = 'header';
					$lines[$i]['position'] = $subArray->id;
				}
		 
			}  
			if (strpos($string, 'border_line_body_') !== false) {
				// Extract the number after 'border_line_'
				preg_match('/border_line_body_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$lines[$i]['number'] = $number;
					$lines[$i]['type'] = 'body';
					$lines[$i]['position'] = $subArray->id;
				} 
			} 
			if (strpos($string, 'border_line_footer_') !== false) {
				// Extract the number after 'border_line_'
				preg_match('/border_line_footer_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$lines[$i]['number'] = $number;
					$lines[$i]['type'] = 'footer';
					$lines[$i]['position'] = $subArray->id;
				} 
			} 
		}
		
		if (isset($subArray->id) && $subArray->id === 'logo') {
			$logo = $i;
		}
		if (isset($subArray->id) && $subArray->id === 'custom_logo') {
			$custom_logo = $i;
		}
		if (isset($subArray->id) && $subArray->id === 'items_list') {

			$items_list = $i;
		}
		if (isset($subArray->id) && $subArray->id === 'barcode') {
			$barcode = $i;
		}

		foreach ($dynamic_variable_names as $dynamic_name) {
			if (isset($subArray->id) && $subArray->id === $dynamic_name."_var") {
				$$dynamic_name = $i;  // Assign the variable name dynamically
			}
		}

		
		
		$i++;
	}
endif;

// echo "<pre>";
// 	print_r($dynamic_variable_names );
// exit();
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

if (isset($error_message)) {
	echo '<h1 style="text-align: center;">' . $error_message . '</h1>';
	exit;
}
?>
<style>
	.receipt_wrapper_inner {
		position: relative;
		height: 600mm;
	}
</style>
<!-- Css Loader  -->
<div class="spinner hidden" id="ajax-loader" style="width:100vw;  height:100vh;">
	<div class="rect1"></div>
	<div class="rect2"></div>
	<div class="rect3"></div>
</div>

<?php
if (!(isset($standalone) && $standalone)) {
?>
	<div class="manage_buttons card hidden-print mb-3">

		<div class="d-flex justify-content-space-between">
			<div class="">
				<div class="hidden-print search no-left-border">
					<ul class="list-inline print-buttons">
						<li></li>




						<li>
							<button class="btn btn-primary btn-lg hidden-print gift_receipt" id="gift_receipt_button" onclick="toggle_gift_receipt()"> <?php echo lang('sales_gift_receipt', '', array(), TRUE); ?> </button>
						</li>
						<?php if ($sale_id_raw != lang('sales_test_mode_transaction', '', array(), TRUE) && !empty($customer_email)) { ?>
							<li>
								<?php echo anchor('sales/email_receipt/' . $sale_id_raw, lang('email_receipt', '', array(), TRUE), array('id' => 'email_receipt', 'class' => 'btn btn-primary btn-lg hidden-print')); ?>
							</li>

						<?php } ?>

						<?php if ($sale_id_raw != lang('sales_test_mode_transaction', '', array(), TRUE) && !empty($customer_phone) && $this->Location->get_info_for_key('twilio_sms_from')) { ?>
							<li>
								<?php echo anchor('sales/sms_receipt/' . $sale_id_raw, lang('sms_receipt', '', array(), TRUE), array('id' => 'sms_receipt', 'class' => 'btn btn-primary btn-lg hidden-print')); ?>
							</li>

						<?php } ?>


						<?php if ($sale_id_raw != lang('sales_test_mode_transaction', '', array(), TRUE)) { ?>
							<li>
								<?php echo anchor('sales/download_receipt/' . $sale_id_raw, '<span class="ion-arrow-down-a"></span>', array('id' => 'download_pdf', 'class' => 'btn btn-primary btn-lg hidden-print')); ?>
							</li>

						<?php } ?>

						<?php if ($this->Employee->has_module_action_permission('sales', 'process_returns', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
							<li>
								<?php echo anchor('sales/return_order/' . $sale_id_raw, lang('sales_return', '', array(), TRUE), array('id' => 'return_order', 'class' => 'btn btn-primary btn-lg hidden-print')); ?>
							</li>
						<?php } ?>
						<li>
							<button class="btn btn-primary btn-lg hidden-print" id="new_sale_button_1" onclick="window.location='<?php echo site_url('sales'); ?>'"> <?php echo lang('sales_new_sale', '', array(), TRUE); ?> </button>
						</li>
					</ul>
				</div>
			</div>
			<div class="">
				<div class="buttons-list">
					<div class="">
						<!-- // pull-right-btn -->
						<ul class="list-inline print-buttons">
							<li style="display: none;">
								<?php
								echo form_checkbox(array(
									'name'        => 'print_duplicate_receipt',
									'id'          => 'print_duplicate_receipt',
									'value'       => '1',
								)) . '&nbsp;<label for="print_duplicate_receipt"><span></span>' . lang('sales_duplicate_receipt', '', array(), TRUE) . '</label>';
								?>
							</li>
							<li><button class="btn btn-primary btn-lg hidden-print" id="toggle_button">Duplicate Receipt</button></li>
							<li>
								<button class="btn btn-primary btn-lg hidden-print" id="print_button" onclick="print_receipt()"> <?php echo lang('print', '', array(), TRUE); ?> </button>
							</li>
							<li>
								<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
									Switch Template
									<i class="ki-duotone ki-down fs-5 ms-1"></i> </a>
								<!--begin::Menu-->
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true" style="">
									<!--begin::Menu item-->

								
								<?php  foreach($all_templates as $temp): ?>
									<div class="menu-item px-3">
										<a href="#" onclick="load_preview(<?= $temp['id'] ?>, event)" class="menu-link px-3 hidden-print"> <?= $temp['title']." (".$temp['size'].")"; ?></a>
									</div>
								<?php endforeach; ?>

							

								</div>
							</li>

							<li>
								<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
									More
									<i class="ki-duotone ki-down fs-5 ms-1"></i> </a>
								<!--begin::Menu-->
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true" style="">
									<!--begin::Menu item-->

									<?php
									if ((empty($deleted) || (!$deleted))) { ?>
										<div class="menu-item px-3">
											<?php
											if ($sale_id_raw != lang('sales_test_mode_transaction', '', array(), TRUE) && !$store_account_payment && !$is_purchase_points && !$is_ecommerce && $this->Employee->has_module_action_permission('sales', 'edit_sale', $this->Employee->get_logged_in_employee_info()->person_id)) {

												$edit_sale_url = (isset($sale_type) && ($sale_type == ($this->config->item('user_configured_layaway_name') ? $this->config->item('user_configured_layaway_name') : lang('layaway', '', array(), TRUE)) || $sale_type == ($this->config->item('user_configured_estimate_name') ? $this->config->item('user_configured_estimate_name') : lang('estimate', '', array(), TRUE)))) ? 'unsuspend' : 'change_sale';
												echo form_open("sales/$edit_sale_url/" . $sale_id_raw, array('id' => 'sales_change_form')); ?>
												<button class="menu-link px-3 hidden-print" id="edit_sale"> <?php echo lang('sales_edit', '', array(), TRUE); ?> </button>
												</form>
										</div>
									<?php }	?>
									<!--end::Menu item-->
								<?php } ?>
								<?php if ($sale_id_raw != lang('sales_test_mode_transaction', '', array(), TRUE)) { ?>
									<div class="menu-item px-3">
										<a href="<?php echo site_url("sales/create_po/$sale_id_raw"); ?>" target="_blank" class="menu-link px-3 hidden-print" id="fufillment_sheet_button"> <?php echo lang('create_po', '', array(), TRUE); ?></a>
									</div>
								<?php } ?>

								<?php
								if ($sale_id_raw != lang('sales_test_mode_transaction', '', array(), TRUE)) {
								?>
									<div class="menu-item px-3">
										<a href="<?php echo site_url("sales/fulfillment/$sale_id_raw"); ?>" target="_blank" class="menu-link px-3 hidden-print" id="fufillment_sheet_button"> <?php echo lang('sales_fulfillment_sheet', '', array(), TRUE); ?></a>
									</div>

								<?php } ?>

								<?php if ($sale_id_raw != lang('sales_test_mode_transaction', '', array(), TRUE)) { ?>

									<?php if (!$this->config->item('disable_sale_cloning')) { ?>
										<div class="menu-item px-3">

											<?php echo anchor('sales/clone_sale/' . $sale_id_raw, lang('clone', '', array(), TRUE), array('id' => 'clone', 'class' => 'menu-link px-3 hidden-print')); ?>
										</div>
									<?php } ?>
								<?php } ?>
								<?php if ($this->Employee->has_module_action_permission('sales', 'add_remove_amounts_from_cash_drawer', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
									<div class="menu-item px-3">
										<?php echo anchor_popup(site_url('sales/open_drawer'), '<i class="ion-android-open"></i> ' . lang('pop_open_cash_drawer', '', array(), TRUE), array('class' => 'menu-link px-3 hidden-print', 'target' => '_blank')); ?>
									</div>
								<?php } ?>


								</div>
							</li>

						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } else {
?>
	<div class="col-md-12 text-center hidden-print">
		<div class="row">
			<button class="btn btn-primary btn-lg" id="print_button" onclick="print_receipt()"> <?php echo lang('print', '', array(), TRUE); ?> </button>
		</div>
		<br />
	</div>
<?php
} ?>
<?php

if ($receipt['background_image']) {
	$img_background_image = cacheable_app_file_url($receipt['background_image']);
}
?>
<div class="preview_receipt">

<div style="margin:0 auto; height:auto; <?php if ($receipt['background_image']) { ?> background-size: contain; background-position: center top;  
 background-repeat: repeat-y;   background-image: url(<?= $img_background_image; ?>); <?php } ?> <?php echo $this->config->item('uppercase_receipts') ? 'text-transform: uppercase !important' : ''; ?>" class="row manage-table elementWithBackground <?= $receipt['size'] ?> card p-5 mt-5 receipt_<?php echo $this->config->item('receipt_text_size') ? $this->config->item('receipt_text_size') : 'small'; ?>" id="receipt_wrapper">

                                   
<?php   $pages  = ['one' , 'two' , 'three'];
foreach($pages as $page): ?>

<div class="p-0 page-<?=  $page; ?> <?= $receipt['size'] ?>" id="receipt_wrapper_inner">
<?php 
         $parts = ['header' , 'body' , 'footer'];
                                                                                foreach ($parts as $part) {
                                                                            ?>
                                <div class="row row-cols-1 g-10  page_<?= $part; ?>"
                                    style="height:<?= $receipt[''.$part.'_percentage'] ?>">

																					<?php 
									if(count($shapes) > 0){ 
											foreach ($shapes as $key => $cus) {
												if($cus['type']==$part){
												// Access your properties like $position->id, $position->newleft, etc.
												 ?>
                                    <div class="resize transparent-rectangle <?= $positions_array[$cus['position']]['newtype']; ?>-border"
                                        style="position: absolute; width:<?= $positions_array[$cus['position']]['newwidth'];  ?>px;height:<?= $positions_array[$cus['position']]['newheight'];  ?>px; text-wrap:nowrap; left:<?= $positions_array[$cus['position']]['newleft'];  ?>; top:<?= $positions_array[$cus['position']]['newtop'];  ?>; "
                                        data-left="<?= $positions_array[$cus['position']]['newleft'];  ?>"
                                        data-top="<?= $positions_array[$cus['position']]['newtop'];  ?>"
                                        data-type="<?= $positions_array[$cus['position']]['newtype'];  ?>"
                                        data-current_width="<?= $positions_array[$cus['position']]['newwidth'];  ?>"
                                        data-current_height="<?= $positions_array[$cus['position']]['newheight'];  ?>"
                                        id="rectangle_<?= $part;  ?>_<?= $cus['number'];  ?>">
                                        <span
                                            class="position-absolute top-0 start-0 translate-middle  badge badge-circle badge-danger remove_shape">x</span>
                                        <?php 
													if($positions_array[$cus['position']]['newtype']!=''){
														if($positions_array[$cus['position']]['newtype'] == 'triangle-up'){
                                                           ?>
                                        <div class="triangle-up-border"><svg viewBox="0 0 100 100"
                                                preserveAspectRatio="none"
                                                style="width: 100%; height: 100%; display: block;">
                                                <polygon points="50,0 0,100 100,100" fill="transparent" stroke="#646e84"
                                                    stroke-width="2" />
                                            </svg></div>
                                        <?php 
                                                        }
													}

													if($positions_array[$cus['position']]['newtype']!=''){
														if($positions_array[$cus['position']]['newtype'] == 'triangle-down'){
                                                           ?>
                                        <div class="triangle-down-border"><svg viewBox="0 0 100 100"
                                                preserveAspectRatio="none"
                                                style="width: 100%; height: 100%; display: block;">
                                                <polygon points="50,100 0,0 100,0" fill="transparent" stroke="#646e84"
                                                    stroke-width="2" />
                                            </svg></div>
                                        <?php 
                                                        }
													}
												?>
                                    </div>

                                    <?php 
											}
										}

										}
										if(count($lines) > 0){ 
											foreach($lines  as $key => $cus){
												if($cus['type']==$part){
											// Access your properties like $position->id, $position->newleft, etc.
											 ?>
                                    <div class="resize border_line border-top-<?= $positions_array[$cus['position']]['newtype'];  ?>"
                                        style="position: absolute; width:<?= $positions_array[$cus['position']]['newwidth'];  ?>px;height:<?= $positions_array[$cus['position']]['newheight'];  ?>px; text-wrap:nowrap; left:<?= $positions_array[$cus['position']]['newleft'];  ?>; top:<?= $positions_array[$cus['position']]['newtop'];  ?>; "
                                        data-left="<?= $positions_array[$cus['position']]['newleft'];  ?>"
                                        data-top="<?= $positions_array[$cus['position']]['newtop'];  ?>"
                                        data-current_width="<?= $positions_array[$cus['position']]['newwidth'];  ?>"
                                        data-current_height="<?= $positions_array[$cus['position']]['newheight'];  ?>"
                                        id="border_line_<?= $part;  ?>_<?= $cus['number'];  ?>">
                                        <span
                                            class="position-absolute top-0 start-0 translate-middle  badge badge-circle badge-danger remove_shape">x</span>
                                    </div>

                                    <?php 
										}
									}
								}
								if(count($custom_images) > 0){ 
											
											foreach($custom_images  as $key => $cus){
												if($cus['type']==$part){

												
											?>
                                    <div class=" fixed-width "
                                        style="position: absolute; width:<?= $positions_array[$cus['position']]['newwidth'];  ?>px;height:<?= $positions_array[$cus['position']]['newheight'];  ?>px; text-wrap:nowrap; left:<?= $positions_array[$cus['position']]['newleft'];  ?>; top:<?= $positions_array[$cus['position']]['newtop'];  ?>; "
                                        data-left="<?= $positions_array[$cus['position']]['newleft'];  ?>"
                                        data-top="<?= $positions_array[$cus['position']]['newtop'];  ?>"
                                        data-current_width="<?= $positions_array[$cus['position']]['newwidth'];  ?>"
                                        data-current_height="<?= $positions_array[$cus['position']]['newheight'];  ?>"
                                        id="custom_img_<?= $part;  ?>_<?= $cus['number'];  ?>">
                                        <?php echo img(
														array(
															'src' => cacheable_app_file_url($cus['number']),

														)
													); ?>

                                        <span
                                            class="position-absolute top-0 start-0 translate-middle  badge badge-circle badge-danger remove_img">x</span>
                                    </div>

                                    <?php } } } ?>

									<?php 
									foreach ($dynamic_variable_names as $dynamic_name) {
										$dynamic_name = str_replace('_var' , '' ,$dynamic_name )
												   ?>
		   <div class="draggable        <?php  if(isset($positions_array[$part.'-'.$dynamic_name]) && $positions_array[$part.'-'.$dynamic_name]['display'] =='block'  ){ echo "already_shown"; }else { echo "already_hidden";} ?> <?= $part.'-'.$dynamic_name ?>"
			   style="position: absolute; ddddd  text-wrap:nowrap; 
												   <?php  if(isset($positions_array[$part.'-'.$dynamic_name])): ?>         
														   width:<?= $positions_array[$part.'-'.$dynamic_name]['newwidth'];  ?>;
														   height:<?= $positions_array[$part.'-'.$dynamic_name]['newheight'];   ?>; text-wrap:nowrap; 
														   left:<?= $positions_array[$part.'-'.$dynamic_name]['newleft'];    ?>; 
														   top:<?=  $positions_array[$part.'-'.$dynamic_name]['newtop'];    ?>; 
														   
														   <?php  if(isset($positions_array[$part.'-'.$dynamic_name]) && $positions_array[$part.'-'.$dynamic_name]['display'] =='block'  ){ echo "display:block;"; }else { echo "display:none;";} ?> 
														   <?php else: ?>
															   display:none;
															<?php endif; ?> "
			   <?php  if(isset($positions_array[$part.'-'.$dynamic_name])): ?>
			   data-left="<?= $positions_array[$part.'-'.$dynamic_name]['newleft'];  ?>"
			   data-top="<?= $positions_array[$part.'-'.$dynamic_name]['newtop'];   ?>"
			   data-current_width="<?= $positions_array[$part.'-'.$dynamic_name]['newwidth'];  ?>"
			   data-current_height="<?= $positions_array[$part.'-'.$dynamic_name]['newheight']; ?>"
			   <?php endif; ?> id="<?php echo $part.'-'.$dynamic_name; ?>">
			   <div class="d-flex flex-stack mb-3">

				   <div class="fw-semibold text-end text-gray-600 fs-7 w-75">


					   <?php 
						   if($dynamic_name=='barcode'): ?>
					   Change
					   return policy <br>

					   <img src="<?php echo base_url(); ?>barcode/index/svg?barcode=POS 43&amp;text=POS 43"
						   alt="">

			<?php   elseif($dynamic_name=='company_name'): ?>



								<?php if ($this->Location->count_all() > 1) { ?>
									<div class="company-title fw-bold" ><?php echo H($company); ?></div>
									

								<?php } else {
								?>
									<div class="company-title fw-bold"><?php echo H($company); ?></div>
								<?php
								}

								?>

			<?php   elseif($dynamic_name=='location_name'): ?>

									<?php if (!$this->config->item('hide_location_name_on_receipt')) { ?>
										<div ><?php echo H($this->Location->get_info_for_key('name', isset($override_location_id) ? $override_location_id : FALSE)); ?></div>
									<?php } ?>
	
									<?php   elseif($dynamic_name=='location_address'): ?>		
							
									
							
							<div ><?php echo H($this->Location->get_info_for_key('address', isset($override_location_id) ? $override_location_id : FALSE)); ?></div>
						
			<?php   elseif($dynamic_name=='tax_id'): ?>	
				
				
									<?php if ($tax_id) {?>
										<li class="tax-id-title"><?php echo lang('tax_id') . ': ' . H($tax_id); ?></li>
									<?php } ?>

			<?php   elseif($dynamic_name=='datetime'): ?>	
									<?php if ($transaction_time != false) : ?>
											<strong ><?php echo H($transaction_time) ?></strong>
										<?php

										endif;

										?>

<?php   elseif($dynamic_name=='saleid'): ?>	


						<span>
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
							


						</span>


				<?php   elseif($dynamic_name=='return_sale_id'): ?>	
							<div>
								<?php
								if ($return_sale_id) {
									echo ' (' . lang('sales_return') . ' ' . ($this->config->item('sale_prefix') ? $this->config->item('sale_prefix') : 'POS') . ' ' . $return_sale_id . ')';
								}
								?>
							</div>

				<?php   elseif($dynamic_name=='register_name'): ?>	

									<?php
									if ($this->Register->count_all(isset($override_location_id) ? $override_location_id : FALSE) > 1 && $register_name) {
									?>
										<div ><span><?php echo lang('register_name', '', array(), TRUE) . ':'; ?></span><?php echo H($register_name); ?></div>
									<?php
									}
									?>



				<?php   elseif($dynamic_name=='employee_name'): ?>				

											<span >
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


							<?php   elseif($dynamic_name=='customer_name'): ?>		
													<?php if (isset($customer)) { ?>
														<ul class="list-unstyled " >
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
											

												<?php } ?>
								<?php   elseif($dynamic_name=='customer_address'): ?>	

											<?php if (isset($customer)) { ?>
														<ul class="list-unstyled " >

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


												<?php } ?>

								<?php   elseif($dynamic_name=='customer_phone'): ?>	

													<?php if (isset($customer)) { ?>
														<ul class="list-unstyled ">

															<?php if (!empty($customer_phone)) { ?><li style="font-weight: bold;"><?php echo lang('phone_number', '', array(), TRUE); ?> : <?php echo H(format_phone_number($customer_phone)); ?></li><?php } ?>

														</ul>


												<?php } ?>



								<?php   elseif($dynamic_name=='customer_email'): ?>	

													<?php if (isset($customer)) { ?>
												<ul class="list-unstyled ">

													<?php if (!$this->config->item('hide_email_on_receipts')) { ?>
														<?php if (!empty($customer_email)) { ?><li><?php echo lang('email', '', array(), TRUE); ?> : <?php echo H($customer_email); ?></li><?php } ?>
													<?php } ?>

												</ul>

											<?php } ?>


							<?php   elseif($dynamic_name=='subtotal'): ?>	


											
										<?php if ($subtotal != false) : ?>
											<span class="add_top fw-bold" style="position: absolute;  left:<?= $positions[$subtotal - 1]->newleft;  ?>; top:<?= $positions[$subtotal - 1]->newtop;  ?>;  text-wrap:nowrap;">




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

						<?php   elseif($dynamic_name=='exchange_name'): ?>	
										<?php 
												if ($exchange_name) { ?>

													<div class="row add_top" >
														<div class="d-flex flex-stack mb-3">

															<div class="fw-semibold text-end text-gray-600 fs-7 w-75"><?php echo lang('exchange_to', '', array(), TRUE) . ' ' . H($exchange_name); ?></div>

															<div class="ps-10 fw-bold fs-6 text-gray-800">x <?php echo to_currency_no_money($exchange_rate); ?></div>

														</div>

													</div>

											<?php 
											} ?>

							<?php   elseif($dynamic_name=='tip_amount'): ?>	

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



																<?php } ?>

										<?php   elseif($dynamic_name=='tax_amount'): ?>	
																<?php
																$total_tax_amount = 0;
																
																	if ($this->config->item('group_all_taxes_on_receipt')) {
																		$total_tax = 0;
																		foreach ($taxes as $name => $value) {
																			$total_tax += $value;
																		}
																	?>
																		<div class="row " >

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
																			<div class="row " >
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
																
																?>
								<?php   elseif($dynamic_name=='total'): ?>	


										<span class="add_top fw-bold" >
											<?php echo lang('total', '', array(), TRUE); ?>
											&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
											<?php if (isset($exchange_name) && $exchange_name) { ?>
												<?php echo $total_invoice_amount = $this->config->item('round_cash_on_sales') && $is_sale_cash_payment ?  to_currency_as_exchange($cart, round_to_nearest_05($total + $tip_amount)) : to_currency_as_exchange($cart, $total + $tip_amount); ?>
											<?php } else {  ?>
												<?php echo $total_invoice_amount = $this->config->item('round_cash_on_sales') && $is_sale_cash_payment ?  to_currency(round_to_nearest_05($total + $tip_amount)) : to_currency($total + $tip_amount); ?>
											<?php } ?>
										</span>


										<?php   elseif($dynamic_name=='weight'): ?>	

										
														<?php
															// Check Condition for Weight from Config file 
															if (!$this->config->item('remove_weight_from_receipt')) {
																if ($cart->get_total_weight() > 0)
															?>
															

																	<span >
																		<?php echo lang('items_weight', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $cart->get_total_weight(); ?>
																	</span>

															<?php } ?>
									<?php   elseif($dynamic_name=='amount_discount'): ?>	

													<?php
													if ($this->config->item('show_total_discount_on_receipt') && $amount_discount && !$store_account_payment && $cart->get_total_discount()) { ?>
														<div class="row " >
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


						<?php   elseif($dynamic_name=='no_of_items'): ?>	

												<?php  if(isset($number_of_items_sold)){ ?>
												<span >
													<?php echo lang('items_sold', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo to_quantity($number_of_items_sold); ?>
												</span>

												<?php  } ?>
						<?php   elseif($dynamic_name=='item_returned'): ?>	
							<?php  if(isset($item_returned)){ ?>
												<?php
												$number_of_items_returned = 5;
												if ($number_of_items_returned && $item_returned != false) { ?>
													<div class="row  " > <?php echo lang('items_returned', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo to_quantity($number_of_items_returned); ?>

													</div>
												<?php } ?>

											<?php } ?>


											<?php   elseif($dynamic_name=='payments'): ?>


											<?php

											
													if ($payments != false) {
														foreach ($payments as $payment_id => $payment) {
															$pcounter = 0;

															$tip_amount_on_payment = 0;

															if ($pcounter == 0) {
																$tip_amount_on_payment = $tip_amount;
															}
													?>
															<div class="row " >
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

						<?php   elseif($dynamic_name=='giftcard_balance'): ?>

											<?php
															
																foreach ($payments as $payment) { ?>
																	<?php if (strpos($payment->payment_type, lang('giftcard', '', array(), TRUE)) === 0) { ?>
																		<?php $giftcard_payment_row = explode(':', $payment->payment_type); ?>

																		<div class="row " >
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
															?>
									<?php   elseif($dynamic_name=='ebt_balance'): ?>

												<?php
																if ($ebt_balance != false) {
																?><div class="row " > <?php
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
																			
																			
													<?php   elseif($dynamic_name=='customer_balance_for_sale'): ?>


																			<?php if (isset($customer_balance_for_sale) &&  $customer_balance_for_sale != false  && (float)$customer_balance_for_sale && !$this->config->item('hide_store_account_balance_on_receipt')) { ?>
																			<div class="row  " >
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
																<?php   elseif($dynamic_name=='sales_until_discount'): ?>
																		<?php if (!$disable_loyalty &&   $sales_until_discount != false && $this->config->item('enable_customer_loyalty_system') && isset($sales_until_discount) && !$this->config->item('hide_sales_to_discount_on_receipt') && $this->config->item('loyalty_option') == 'simple') { ?>
																			<div class="row   " >
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

														<?php   elseif($dynamic_name=='points'): ?>
																		<?php if (!$disable_loyalty && $this->config->item('enable_customer_loyalty_system') && isset($customer_points) && !$this->config->item('hide_points_on_receipt') && $this->config->item('loyalty_option') == 'advanced') { ?>
																			<?php if ($points != false) : ?>

																				<span >
																					<?php echo lang('points', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo to_quantity($customer_points); ?>
																				</span>



																			<?php endif; ?>
																		<?php
																		}
																		?>
																<?php   elseif($dynamic_name=='ref_no'): ?>

																		<?php
																		if ($ref_no && $ref_no != false) {
																		?>
																			<div class="row  ">
																				<div class="col-md-8">
																					<div class="invoice-footer-heading"><?php echo lang('sales_ref_no', '', array(), TRUE); ?></div>
																				</div>
																				<div class="col-md-4">
																					<div class="invoice-footer-value invoice-total"><?php echo H($ref_no); ?></div>
																				</div>
																			</div>
																		<?php
																		} ?>

														<?php   elseif($dynamic_name=='auth_code'): ?>
																		<?php 
																		if (isset($auth_code) && $auth_code && $auth_code != false) {
																		?>
																			<div class="row  ">
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



																		

							<?php

							else:
							   echo $dynamic_variable_values[$dynamic_name."_var"]; 
						   endif;
						   ?>

				   </div>


			   </div>
		   </div>



		   <?php
						   
				   }

				   ?>



																				
								</div>

								<?php } ?>
</div>
<?php endforeach; ?>

	
	<div >
		
	
	<div class=" " style="-webkit-box-shadow: none;border: none; display:none ">
			<div class=" panel-pad">
				<div class="row"> 

						
						
						<?php if ($location_phone != false) : ?>
							<div style="position: absolute; width:30%; left:<?= $positions[$location_phone - 1]->newleft;  ?>; top:<?= $positions[$location_phone - 1]->newtop;  ?>; "><?php echo H($this->Location->get_info_for_key('phone', isset($override_location_id) ? $override_location_id : FALSE)); ?></div>

						<?php

						endif;

						?>

						<ul class="list-unstyled invoice-address" style="margin-bottom:2px;">

							<?php if ($logo != false) : ?>
								<?php if ($company_logo) { ?>

									<?php
									if (!(isset($standalone) && $standalone)) {
									?>

										<li class="invoice-logo">
											<img style="position: absolute; width:<?= $positions[$logo - 1]->newwidth;  ?>px;height:<?= $positions[$logo - 1]->newheight;  ?>px; text-wrap:nowrap; left:<?= $positions[$logo - 1]->newleft;  ?>; top:<?= $positions[$logo - 1]->newtop;  ?>;" src="<?php echo secure_app_file_url($company_logo); ?>">

										</li>
									<?php } ?>
								<?php } ?>

							<?php endif; ?>




						

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


					<?php if ($saleid != false) : ?>
						<span style="position: absolute; width:30%; left:<?= $positions[$saleid - 1]->newleft;  ?>; top:<?= $positions[$saleid - 1]->newtop;  ?>; ">
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

					<?php if ($register_name != false) : ?>

						<?php
						if ($this->Register->count_all(isset($override_location_id) ? $override_location_id : FALSE) > 1 && $register_name) {
						?>
							<div style="position: absolute; width:30%; left:<?= $positions[$register_name - 1]->newleft;  ?>; top:<?= $positions[$register_name - 1]->newtop;  ?>; "><span><?php echo lang('register_name', '', array(), TRUE) . ':'; ?></span><?php echo H($register_name); ?></div>
						<?php
						}
						?>
					<?php endif; ?>

					<?php if ($employee_name != false) : ?>
						<span style="position: absolute; width:30%; left:<?= $positions[$employee_name - 1]->newleft;  ?>; top:<?= $positions[$employee_name - 1]->newtop;  ?>; ">
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
						<?php if ($customer_name != false) : ?>
							<ul class="list-unstyled " style="position: absolute; width:30%; left:<?= $positions[$customer_name - 1]->newleft;  ?>; top:<?= $positions[$customer_name - 1]->newtop;  ?>; ">
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
						<?php if ($customer_address != false) : ?>
							<ul class="list-unstyled " style="position: absolute; width:30%; left:<?= $positions[$customer_address - 1]->newleft;  ?>; top:<?= $positions[$customer_address - 1]->newtop;  ?>; ">

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
						<?php if ($customer_phone != false) : ?>
							<ul class="list-unstyled " style="position: absolute; width:30%; left:<?= $positions[$customer_phone - 1]->newleft;  ?>; top:<?= $positions[$customer_phone - 1]->newtop;  ?>; ">

								<?php if (!empty($customer_phone)) { ?><li style="font-weight: bold;"><?php echo lang('phone_number', '', array(), TRUE); ?> : <?php echo H(format_phone_number($customer_phone)); ?></li><?php } ?>

							</ul>
						<?php endif; ?>


					<?php } ?>



					<?php if (isset($customer)) { ?>
						<?php if ($customer_email != false) : ?>
							<ul class="list-unstyled " style="position: absolute; width:30%; left:<?= $positions[$customer_email - 1]->newleft;  ?>; top:<?= $positions[$customer_email - 1]->newtop;  ?>; ">

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
				<?php if ($items_list !== false) :
					
					?>
					<table id='receipt-draggable' style=" position: absolute; width:<?= $positions[$items_list - 1]->newwidth;  ?>px; left:<?= $positions[$items_list - 1]->newleft;  ?>; top:<?= $positions[$items_list - 1]->newtop;  ?>; ">
						<thead>
							<tr>
								<!-- invoice heading-->
								<th class="invoice-table">
									<div class="row">
										<div class="<?php echo $this->config->item('wide_printer_receipt_format') ? 'col-md-' . $x_col . ' col-sm-' . $x_col . ' col-xs-' . $x_col : 'col-md-12 col-sm-12 col-xs-12' ?>">
											<div class="invoice-head item-name" data-id="checkbox_item_name"><?php echo lang('item_name', '', array(), TRUE); ?></div>
										</div>
										<div class="col-md-<?php echo $xs_col; ?> col-sm-<?php echo $xs_col; ?> col-xs-<?php echo $xs_col; ?> gift_receipt_element" data-id="checkbox_item_price">
											<div class="invoice-head text-right item-price" >
												<?php echo lang('price', '', array(), TRUE) . ($this->config->item('show_tax_per_item_on_receipt') ? '/' . lang('tax', '', array(), TRUE) : ''); ?>
											</div>
										</div>
										<div class="col-md-<?php echo $xs_col; ?> col-sm-<?php echo $xs_col; ?> col-xs-<?php echo $xs_col; ?>"  data-id="checkbox_item_quantity">
											<div class="invoice-head text-right item-qty"><?php echo lang('quantity', '', array(), TRUE); ?></div>
										</div>

										<?php if ($discount_exists) { ?>
											<div class="col-md-<?php echo $xs_col; ?> col-sm-<?php echo $xs_col; ?> col-xs-<?php echo $xs_col; ?> gift_receipt_element" data-id="checkbox_element_discount">
												<div class="invoice-head text-right item-discount"><?php echo lang('discount_percent', '', array(), TRUE); ?></div>
											</div>

										<?php } ?>
										<div class="col-md-<?php echo $xs_col; ?> col-sm-<?php echo $xs_col; ?> col-xs-<?php echo $xs_col; ?>" data-id="checkbox_item_total">
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
													<div class="invoice-content-heading" data-id="checkbox_item_name">
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
														<div class="invoice-desc" >
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
													<div class="invoice-desc" data-id="checkbox_element_variation_name">
														<?php
														echo isset($item->variation_name) && $item->variation_name ? H($item->variation_name) : '';
														?>
													</div>
													<div class="invoice-desc" data-id="checkbox_element_description">
														<?php
														if (!$this->config->item('hide_desc_on_receipt') && !$item->description == "") {
															echo nl2br(clean_html($item->description));
														}
														?>
													</div>
													<div class="invoice-desc"  data-id="checkbox_element_item_serialnumber">
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
																<div class="invoice-desc" data-id="checkbox_custom_fields_to_display">
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
														<div class="invoice-desc" data-id="checkbox_element_item_kit_info_name">
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
																<div class="invoice-desc" data-id="checkbox_element_item_kit_custom_fields_to_display">
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
															echo '<div class="gift_receipt_element"  data-id="checkbox_element_discount"><i class="gift_receipt_element"><u class="gift_receipt_element">' . lang('discount', '', array(), TRUE) . ': ' . to_currency($item->rule['rule_discount']) . '</u></i></div>';
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
												<div class="invoice-desc" data-id="checkbox_element_image">
													<?php
													echo img(array(
														'width' => ($this->config->item('show_images_on_receipt_width_percent') ? $this->config->item('show_images_on_receipt_width_percent') : '10') . '%',
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


				<?php if ($subtotal != false) : ?>
					<span class="add_top fw-bold" style="position: absolute;  left:<?= $positions[$subtotal - 1]->newleft;  ?>; top:<?= $positions[$subtotal - 1]->newtop;  ?>;  text-wrap:nowrap;">




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
					<?php if ($exchange_name != false) {
						if ($exchange_name) { ?>

							<div class="row add_top" style="position: absolute;  left:<?= $positions[$exchange_name - 1]->newleft;  ?>; top:<?= $positions[$exchange_name - 1]->newtop;  ?>; ">
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
					if ($tax_amount != false) {
						if ($this->config->item('group_all_taxes_on_receipt')) {
							$total_tax = 0;
							foreach ($taxes as $name => $value) {
								$total_tax += $value;
							}
						?>
							<div class="row add_top" style="position: absolute;   width:25%; left:<?= $positions[$tax_amount - 1]->newleft;  ?>; top:<?= $positions[$tax_amount - 1]->newtop;  ?>;  ">

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
								<div class="row add_top" style="position: absolute;  width:25%;  left:<?= $positions[$tax_amount - 1]->newleft;  ?>; top:<?= $positions[$tax_amount - 1]->newtop;  ?>;  ">
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
					<?php if ($total != false) : ?>
						<span class="add_top fw-bold" style="position: absolute;   width:20%; left:<?= $positions[$total - 1]->newleft;  ?>; top:<?= $positions[$total - 1]->newtop;  ?>;  text-wrap:nowrap;">
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
						<?php if ($weight != false) : ?>

							<span class="add_top" style="position: absolute;  left:<?= $positions[$weight - 1]->newleft;  ?>; top:<?= $positions[$weight - 1]->newtop;  ?>;  text-wrap:nowrap;">
								<?php echo lang('items_weight', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $cart->get_total_weight(); ?>
							</span>

						<?php endif; ?>
					<?php } ?>


					<?php
					if ($this->config->item('show_total_discount_on_receipt') && $amount_discount && !$store_account_payment && $cart->get_total_discount()) { ?>
						<div class="row add_top" style="position: absolute;  left:<?= $positions[$amount_discount - 1]->newleft;  ?>; top:<?= $positions[$amount_discount - 1]->newtop;  ?>; ">
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


					<?php if ($no_of_items != false) : ?>

						<span class="add_top" style="position: absolute;  left:<?= $positions[$no_of_items - 1]->newleft;  ?>; top:<?= $positions[$no_of_items - 1]->newtop;  ?>;  text-wrap:nowrap;">
							<?php echo lang('items_sold', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo to_quantity($number_of_items_sold); ?>
						</span>



					<?php endif; ?>


					<?php
					$number_of_items_returned = 5;
					if ($number_of_items_returned && $item_returned != false) { ?>
						<div class="row  add_top" style="position: absolute;  width:35%; left:<?= $positions[$item_returned - 1]->newleft;  ?>; top:<?= $positions[$item_returned - 1]->newtop;  ?>;  "> <?php echo lang('items_returned', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo to_quantity($number_of_items_returned); ?>

						</div>
					<?php } ?>

				</div>

				<?php
				if ($payments != false) {
					foreach ($payments as $payment_id => $payment) {
						$pcounter = 0;

						$tip_amount_on_payment = 0;

						if ($pcounter == 0) {
							$tip_amount_on_payment = $tip_amount;
						}
				?>
						<div class="row add_top" style="position: absolute;  width:35%; left:<?= $positions[$payments - 1]->newleft;  ?>; top:<?= $positions[$payments - 1]->newtop;  ?>;  ">
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
				if ($giftcard_balance != false) {
					foreach ($payments as $payment) { ?>
						<?php if (strpos($payment->payment_type, lang('giftcard', '', array(), TRUE)) === 0) { ?>
							<?php $giftcard_payment_row = explode(':', $payment->payment_type); ?>

							<div class="row add_top" style="position: absolute;  width:35%; left:<?= $positions[$giftcard_balance - 1]->newleft;  ?>; top:<?= $positions[$giftcard_balance - 1]->newtop;  ?>;  ">
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
				if ($ebt_balance != false) {
				?><div class="row add_top" style="position: absolute;  width:35%; left:<?= $positions[$ebt_balance - 1]->newleft;  ?>; top:<?= $positions[$ebt_balance - 1]->newtop;  ?>;  "> <?php
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

				<?php if (isset($customer_balance_for_sale) &&  $customer_balance_for_sale != false  && (float)$customer_balance_for_sale && !$this->config->item('hide_store_account_balance_on_receipt')) { ?>
					<div class="row  add_top" style="position: absolute;  width:35%; left:<?= $positions[$customer_balance_for_sale - 1]->newleft;  ?>; top:<?= $positions[$customer_balance_for_sale - 1]->newtop;  ?>;  ">
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

				<?php if (!$disable_loyalty &&   $sales_until_discount != false && $this->config->item('enable_customer_loyalty_system') && isset($sales_until_discount) && !$this->config->item('hide_sales_to_discount_on_receipt') && $this->config->item('loyalty_option') == 'simple') { ?>
					<div class="row   add_top" style="position: absolute;  width:35%; left:<?= $positions[$sales_until_discount - 1]->newleft;  ?>; top:<?= $positions[$sales_until_discount - 1]->newtop;  ?>;  ">
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
					<?php if ($points != false) : ?>

						<span class="add_top" style="position: absolute;  left:<?= $positions[$points - 1]->newleft;  ?>; top:<?= $positions[$points - 1]->newtop;  ?>;  text-wrap:nowrap;">
							<?php echo lang('points', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo to_quantity($customer_points); ?>
						</span>



					<?php endif; ?>
				<?php
				}
				?>


				<?php
				if ($ref_no && $ref_no != false) {
				?>
					<div class="row  add_top" style="position: absolute;  width:35%; left:<?= $positions[$ref_no - 1]->newleft;  ?>; top:<?= $positions[$ref_no - 1]->newtop;  ?>;  ">
						<div class="col-md-8">
							<div class="invoice-footer-heading"><?php echo lang('sales_ref_no', '', array(), TRUE); ?></div>
						</div>
						<div class="col-md-4">
							<div class="invoice-footer-value invoice-total"><?php echo H($ref_no); ?></div>
						</div>
					</div>
				<?php
				}
				if (isset($auth_code) && $auth_code && $auth_code != false) {
				?>
					<div class="row  add_top" style="position: absolute;  width:35%; left:<?= $positions[$auth_code - 1]->newleft;  ?>; top:<?= $positions[$auth_code - 1]->newtop;  ?>;  ">
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
					<?php if ($taxable_subtotal != false) : ?>
						<div class="row  add_top" style="position: absolute;  width:35%; left:<?= $positions[$taxable_subtotal - 1]->newleft;  ?>; top:<?= $positions[$taxable_subtotal - 1]->newtop;  ?>;  ">
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

					<?php if ($this->config->item('taxes_summary_details_on_receipt' && $taxable_summary != false)) { ?>
						<br />
						<?php
						foreach ($taxes as $tax_name => $tax_value) {
							$tax_subtotal = $cart->get_tax_subtotal($tax_name);
							$tax_line_total = $tax_value + $tax_subtotal;
						?>
							<div class="row  add_top" style="position: absolute;  width:35%; left:<?= $positions[$taxable_summary - 1]->newleft;  ?>; top:<?= $positions[$taxable_summary - 1]->newtop;  ?>;  ">
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
					<?php if ($non_taxable_subtotal != false) : ?>
						<div class="row   add_top" style="position: absolute;  width:35%; left:<?= $positions[$non_taxable_subtotal - 1]->newleft;  ?>; top:<?= $positions[$non_taxable_subtotal - 1]->newtop;  ?>;  ">
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
					<?php if ($amount_due != false) : ?>

						<span class="add_top" style="position: absolute;  left:<?= $positions[$amount_due - 1]->newleft;  ?>; top:<?= $positions[$amount_due - 1]->newtop;  ?>;  text-wrap:nowrap;">
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
						<?php if ($amount_due != false) : ?>

							<span class="add_top" style="position: absolute;  left:<?= $positions[$amount_due - 1]->newleft;  ?>; top:<?= $positions[$amount_due - 1]->newtop;  ?>;  text-wrap:nowrap;">
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
						<?php if ($comment_on_receipt != false) : ?>
							<div class="text-center invoice-policy add_top" style="position: absolute;  left:<?= $positions[$comment_on_receipt - 1]->newleft;  ?>; top:<?= $positions[$comment_on_receipt - 1]->newtop;  ?>; ">

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
					<?php if ($barcode != false) : ?>
						<div class="col-md-12 col-sm-12 col-xs-12 add_top" style="position: absolute; width:30%; left:<?= $positions[$barcode - 1]->newleft;  ?>; top:<?= $positions[$barcode - 1]->newtop;  ?>; ">
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
						if (count($coupons) > 0 && $coupons != false) {
						?>

							<div class="row add_top" style="position: absolute; width:30%; left:<?= $positions[$coupons - 1]->newleft;  ?>; top:<?= $positions[$coupons - 1]->newtop;  ?>; ">
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
						<?php if ($announcement != false) : ?>
							<div id="announcement" class="invoice-policy add_top" style="position: absolute; width:30%; left:<?= $positions[$announcement - 1]->newleft;  ?>; top:<?= $positions[$announcement - 1]->newtop;  ?>; ">
								<?php echo H($this->config->item('announcement_special')) ?>
							</div>


							<div id="announcement-mobile" class="invoice-policy add_top" style=" display: none;line-height:1; position: absolute; width:30%; left:<?= $positions[$announcement - 1]->newleft;  ?>; top:<?= $positions[$announcement - 1]->newtop;  ?>; ">
								<?php
								//hack to fix bug in html-2-canvas
								echo (str_replace(' ', '<i></i> ', H($this->config->item('announcement_special'))));
								?>
							</div>

						<?php endif; ?>

						<?php if ($signature_needed && !$this->config->item('hide_signature') && $signature != false) { ?>
							<button class="btn btn-primary text-white hidden-print  add_top" style="position: absolute; width:30%; left:<?= $positions[$signature - 1]->newleft;  ?>; top:<?= $positions[$signature - 1]->newtop;  ?>; " id="capture_digital_sig_button"> <?php echo lang('sales_capture_digital_signature', '', array(), TRUE); ?> </button>
							<br />
						<?php
						}
						?>
					</div>

					<?php if (!$this->config->item('hide_signature') && $signature != false) { ?>
						<div class="col-md-6 col-sm-6  add_top" style="position: absolute; width:30%; left:<?= $positions[$signature - 1]->newleft;  ?>; top:<?= $positions[$signature - 1]->newtop;  ?>;  margin-top:100px">
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
</div>


<div id="duplicate_receipt_holder" style="display: none;">

</div>
<?php 
$table_elements = [
				[
					'id' => 'table_element_item_name',
					'name' => 'item name',
					'checkbox' => 'checkbox_item_name',
				],
				[
					'id' => 'table_element_item_price',
					'name' => 'item price',
					'checkbox' => 'checkbox_item_price',  // Assuming there's a typo in 'pric'
				],
				[
					'id' => 'table_element_item_quantity',
					'name' => 'item quantity',
					'checkbox' => 'checkbox_item_quantity',
				],
				[
					'id' => 'table_element_item_total',
					'name' => 'item total',
					'checkbox' => 'checkbox_item_total',
				],
				[
					'id' => 'table_element_variation_name',
					'name' => 'item variation name',
					'checkbox' => 'checkbox_element_variation_name',
				],
				[
					'id' => 'table_element_description',
					'name' => 'item description',
					'checkbox' => 'checkbox_element_description',  
				],
				[
					'id' => 'table_element_serialnumber',
					'name' => 'item serialnumber',
					'checkbox' => 'checkbox_element_item_serialnumber',
				],
				[
					'id' => 'table_element_custom_fields_to_display',
					'name' => 'item custom fields to display',
					'checkbox' => 'checkbox_custom_fields_to_display',
				],[
					'id' => 'table_element_item_kit_info_name',
					'name' => 'item kit info name',
					'checkbox' => 'checkbox_element_item_kit_info_name',
				],[
					'id' => 'table_element_item_kit_custom_fields_to_display',
					'name' => 'item kit custom fields to display',
					'checkbox' => 'checkbox_element_item_kit_custom_fields_to_display',
				],[
					'id' => 'table_element_discount',
					'name' => 'item discount',
					'checkbox' => 'checkbox_element_discount',
				],
                [
					'id' => 'table_element_image',
					'name' => 'item image',
					'checkbox' => 'checkbox_element_image',
				],
			];
			foreach($table_elements as $ele):
				?>
			  <script>
                            $(document).ready(function () {
                                    
                                    if('<?= (in_array($ele['checkbox'],$checks))?'checked':'nop';?>'=='checked'){
                                        $("[data-id='<?php echo $ele['checkbox']; ?>']").show();
                                    }else{
                                        $("[data-id='<?php echo $ele['checkbox']; ?>']").hide();
                                    }
                                
                                    
                            });

                        
                        </script>
                          <?php endforeach; ?>



<?php
if ($this->config->item('allow_reorder_sales_receipt')) {
?>
	<style>
		#receipt-draggable tbody {
			cursor: move;
			width: 100%;
		}

		.invoice-head {
			cursor: pointer;
		}
	</style>
<?php
}
?>

<?php if ($this->config->item('print_after_sale') && $this->uri->segment(2) == 'complete') {
?>
	<script type="text/javascript">
		$(window).bind("load", function() {
			<?php
			if ($this->agent->browser() == 'Chrome') {
			?>
				setTimeout(function() {
					print_receipt();
				}, 1500);
			<?php
			} else {
			?>
				print_receipt();
			<?php
			}
			?>
		});
	</script>
<?php }  ?>

<script type="text/javascript">
	<?php
	if ($this->session->userdata('amount_change')) { ?>
		show_feedback('success', <?php echo json_encode($this->session->userdata('manage_success_message')); ?>, <?php echo json_encode(lang('change_due') . ': ' . to_currency($this->session->userdata('amount_change'))); ?>, {
			timeOut: 30000
		});
	<?php
	}
	?>
function load_preview(id , e){
			e.preventDefault();
			$.ajax({
					type: "POST",
					url: SITE_URL + 'sales/preview_receipt/<?php echo $sale_id_raw; ?>/'+id,
					success: function(data) {
						// alert(data);
						$('.preview_receipt').html(data);
					},
					error: function() {
					}
				});
		}

	$(document).ready(function() {

		
		
		// load_preview();
		<?php if (isset($email_sent) && $email_sent) { ?>
			show_feedback('success', <?php echo json_encode(lang('receipt_sent', '', array(), TRUE)); ?>, <?php echo json_encode(lang('success', '', array(), TRUE)); ?>);
		<?php } ?>
		$("#edit_sale").click(function(e) {
			e.preventDefault();
			bootbox.confirm(<?php echo json_encode(lang('sales_sale_edit_confirm', '', array(), TRUE)); ?>, function(result) {
				if (result) {
					$("#sales_change_form").submit();
				}
			});
		});

		$("#email_receipt,#sms_receipt").click(function() {
			$.get($(this).attr('href'), function() {
				show_feedback('success', <?php echo json_encode(lang('receipt_sent', '', array(), TRUE)); ?>, <?php echo json_encode(lang('success', '', array(), TRUE)); ?>);

			});

			return false;
		});

		<?php
		if ($this->config->item('allow_reorder_sales_receipt')) {
			if (!$this->agent->is_mobile() && !$this->agent->is_tablet()) {
		?>
				$("#receipt-draggable").sortable({
					items: 'tbody',
					cursor: 'move',
					axis: 'y',
					dropOnEmpty: false,
					start: function(e, ui) {
						ui.item.addClass("selected");
						var td_width = [];
						var td_height = [];
						for (let i = 0; i < $("#receipt-draggable tbody").length; i++) {
							if ($($("#receipt-draggable tbody")[i]).hasClass('selected') || $($("#receipt-draggable tbody")[i]).hasClass('ui-sortable-placeholder')) {
								continue;
							} else {
								td_height = $($("#receipt-draggable tbody")[i]).height();
								for (let j = 0; j < $($("#receipt-draggable tbody")[i]).find(".invoice-item-details td").length; j++) {
									td_width.push($($($("#receipt-draggable tbody")[i]).find(".invoice-item-details td")[j]).width());
								}
								break;
							}
						}

						$(".ui-sortable-placeholder").html("<tr><td>&nbsp;</td></tr>");
						$(".ui-sortable-placeholder").height(td_height + 'px');

						for (let k = 0; k < $($("#register tbody.selected tr")[0]).find('td').length; k++) {
							$($($("#register tbody.selected tr")[0]).find('td')[k]).width(td_width[k] + 'px');
						}

					},
					stop: function(e, ui) {

						for (let k = 0; k < $($("#register tbody.selected tr")[0]).find('td').length; k++) {
							$($($("#register tbody.selected tr")[0]).find('td')[k]).attr('style', '');
						}
						ui.item.removeClass("selected");

						updateItemOrder();
					},
					sort: function(e) {
						$(".ui-sortable-helper").css("width", $("table#register").width() + 'px');
						$(".ui-sortable-helper tr").css("width", $("table#register").width() + 'px');
					}
				});
			<?php
			}
			?>

			function updateItemOrder() {
				var length = $("#receipt-draggable tbody").length;
				var item_lines = [];
				for (let i = 0; i < length; i++) {
					let item_id = $($("#receipt-draggable tbody")[i]).data('item-id');
					let sale_id = $($("#receipt-draggable tbody")[i]).data('sale-id');
					let item_class = $($("#receipt-draggable tbody")[i]).data('item-class');
					item_lines.push({
						item_id: item_id,
						sale_id: sale_id,
						item_class: item_class,
						receipt_line_sort_order: (length - i)
					});
				}

				$('#ajax-loader').removeClass('hidden');
				var href = '<?php echo site_url("ecommerce/manual_sync"); ?>';
				clear_order_icon();

				$.ajax({
					type: "POST",
					url: SITE_URL + '/sales/update_sales_item_order',
					data: {
						item_lines: item_lines
					},
					dataType: "json",
					success: function(data) {
						$('#ajax-loader').addClass('hidden');
						console.log("update");
					},
					error: function() {
						$('#ajax-loader').addClass('hidden');
						console.log("update");
					}
				});
			}

			function invoice_receipt_item_sort(obj, item_type, order_type) {
				var length = $("#receipt-draggable tbody").length;
				var item_lines = [];
				for (let i = 0; i < length; i++) {
					let item_id = $($("#receipt-draggable tbody")[i]).data('item-id');
					let sale_id = $($("#receipt-draggable tbody")[i]).data('sale-id');
					let item_name = $($("#receipt-draggable tbody")[i]).data('item-name');
					let item_price = $($("#receipt-draggable tbody")[i]).data('item-price');
					let item_qty = $($("#receipt-draggable tbody")[i]).data('item-qty');
					let item_total = $($("#receipt-draggable tbody")[i]).data('item-total');
					let item_class = $($("#receipt-draggable tbody")[i]).data('item-class');

					item_lines.push({
						item_id: item_id,
						sale_id: sale_id,
						item_class: item_class,
						item_name: item_name,
						item_price: item_price,
						item_qty: item_qty,
						item_total: item_total,
						line: (length - i)
					});
				}

				if (item_type == 'price') {
					if (order_type == 'down')
						item_lines.sort(function(a, b) {
							return b.item_price - a.item_price
						});
					else
						item_lines.sort(function(a, b) {
							return a.item_price - b.item_price
						});
				} else if (item_type == 'qty') {
					if (order_type == 'down')
						item_lines.sort(function(a, b) {
							return b.item_qty - a.item_qty
						});
					else
						item_lines.sort(function(a, b) {
							return a.item_qty - b.item_qty
						});
				} else if (item_type == 'total') {
					if (order_type == 'down')
						item_lines.sort(function(a, b) {
							return b.item_total - a.item_total
						});
					else
						item_lines.sort(function(a, b) {
							return a.item_total - b.item_total
						});
				} else if (item_type == 'name') {
					if (order_type == 'down')
						item_lines.sort(function(a, b) {
							if (a.item_name > b.item_name) {
								return -1;
							}
							if (b.item_name > a.item_name) {
								return 1;
							}
							return 0;
						});
					else
						item_lines.sort(function(a, b) {
							if (b.item_name > a.item_name) {
								return -1;
							}
							if (b.item_name > a.item_name) {
								return 1;
							}
							return 0;
						});
				}

				sort_items(item_lines);
				if (order_type == 'up') {
					$(obj).removeClass('ion-arrow-down-b');
					$(obj).addClass('ion-arrow-up-b');
				} else {
					$(obj).removeClass('ion-arrow-up-b');
					$(obj).addClass('ion-arrow-down-b');
				}
			}

			function sort_items(item_lines) {
				for (let i = 0; i < item_lines.length; i++) {
					var obj_origin = $("#receipt-draggable tbody[data-item-id='" + item_lines[i]['item_id'] + "']");
					var obj_new = obj_origin.clone();
					$("#receipt-draggable").append(obj_new);
					obj_origin.remove();
				}
				updateItemOrder();
			}

			function clear_order_icon() {
				$(".invoice-head.item-name, .invoice-head.item-price, .invoice-head.item-qty, .invoice-head.item-total").removeClass('ion-arrow-up-b');
				$(".invoice-head.item-name, .invoice-head.item-price, .invoice-head.item-qty, .invoice-head.item-total").removeClass('ion-arrow-down-b');
			}

			$(".invoice-head.item-name, .invoice-head.item-price, .invoice-head.item-qty, .invoice-head.item-total").on('click', function() {
				var type = "price";
				if ($(this).hasClass('item-name')) {
					type = 'name';
				} else if ($(this).hasClass('item-qty')) {
					type = 'qty';
				} else if ($(this).hasClass('item-total')) {
					type = 'total';
				} else if ($(this).hasClass('item-price')) {
					type = 'price';
				}

				if ($(this).hasClass('ion-arrow-down-b')) {
					invoice_receipt_item_sort(this, type, 'up');
				} else if ($(this).hasClass('ion-arrow-up-b')) {
					invoice_receipt_item_sort(this, type, 'down');
				} else {
					invoice_receipt_item_sort(this, type, 'down');
				}
			});
		<?php
		}
		?>
	});

	$('#toggle_button').click(function() {
		// Toggle the checkbox
		var isChecked = $('#print_duplicate_receipt').prop('checked');
		$('#print_duplicate_receipt').prop('checked', !isChecked);
		$(this).toggleClass('btn-primary btn-secondary');
		// Rest of the code remains the same
		if ($('#print_duplicate_receipt').prop('checked')) {
			var receipt = $('#receipt_wrapper').clone();
			$('#duplicate_receipt_holder').html(receipt);
			$("#duplicate_receipt_holder").addClass('visible-print-block');
			$("#duplicate_receipt_holder #signature_holder").addClass('hidden');
			$("#duplicate_receipt_holder .receipt_type_label").text(<?php echo json_encode(lang('sales_duplicate_receipt', '', array(), TRUE)); ?>);
			$(".receipt_type_label").show();
			$(".receipt_type_label").addClass('show_receipt_labels');
		} else {
			$("#duplicate_receipt_holder").empty();
			$("#duplicate_receipt_holder").removeClass('visible-print-block');
			$("#duplicate_receipt_holder #signature_holder").removeClass('hidden');
			$(".receipt_type_label").hide();
			$(".receipt_type_label").removeClass('show_receipt_labels');
		}
	});

	<?php
	$this->load->helper('sale');
	if ($this->config->item('always_print_duplicate_receipt_all') || ($this->config->item('automatically_print_duplicate_receipt_for_cc_transactions') && $is_credit_card_sale)) {
	?>
		$("#print_duplicate_receipt").trigger('click');
	<?php
	}
	?>

	<?php
	if ($this->config->item('redirect_to_sale_or_recv_screen_after_printing_receipt')) {
	?>
		window.onafterprint = function() {
			window.location = '<?php echo site_url('sales'); ?>';
		}
	<?php
	}
	?>

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

	function toggle_gift_receipt() {
		var gift_receipt_text = <?php echo json_encode(lang('sales_gift_receipt', '', array(), TRUE)); ?>;
		var regular_receipt_text = <?php echo json_encode(lang('sales_regular_receipt', '', array(), TRUE)); ?>;

		if ($("#gift_receipt_button").hasClass('regular_receipt')) {
			$('#gift_receipt_button').addClass('gift_receipt');
			$('#gift_receipt_button').removeClass('regular_receipt');
			$("#gift_receipt_button").text(gift_receipt_text);
			$('.gift_receipt_element').show();
		} else {
			$('#gift_receipt_button').removeClass('gift_receipt');
			$('#gift_receipt_button').addClass('regular_receipt');
			$("#gift_receipt_button").text(regular_receipt_text);
			$('.gift_receipt_element').hide();
		}

	}

	//timer for sig refresh
	var refresh_timer;
	var sig_canvas = document.getElementById('sig_cnv');

	<?php
	//Only use Sig touch on mobile
	if ($this->agent->is_mobile()) {
	?>
		var signaturePad = new SignaturePad(sig_canvas);
	<?php
	}
	?>
	$("#capture_digital_sig_button").click(function() {
		<?php
		//Only use Sig touch on mobile
		if ($this->agent->is_mobile()) {
		?>
			signaturePad.clear();
		<?php
		} else {
		?>
			try {
				if (TabletConnectQuery() == 0) {
					bootbox.alert(<?php echo json_encode(lang('unable_to_connect_to_signature_pad', '', array(), TRUE)); ?>);
					return;
				}
			} catch (exception) {
				bootbox.alert(<?php echo json_encode(lang('unable_to_connect_to_signature_pad', '', array(), TRUE)); ?>);
				return;
			}

			var ctx = document.getElementById('sig_cnv').getContext('2d');
			SigWebSetDisplayTarget(ctx);
			SetDisplayXSize(500);
			SetDisplayYSize(100);
			SetJustifyMode(0);
			refresh_timer = SetTabletState(1, ctx, 50);
			KeyPadClearHotSpotList();
			ClearSigWindow(1);
			ClearTablet();
		<?php
		}
		?>

		$("#capture_digital_sig_button").hide();
		$("#digital_sig_holder").show();
	});

	$("#capture_digital_sig_clear_button").click(function() {
		<?php
		//Only use Sig touch on mobile
		if ($this->agent->is_mobile()) {
		?>
			signaturePad.clear();
		<?php
		} else {
		?>
			ClearTablet();
		<?php
		}
		?>
	});

	$("#capture_digital_sig_done_button").click(function() {
		<?php
		//Only use Sig touch on mobile
		if ($this->agent->is_mobile()) {
		?>
			if (signaturePad.isEmpty()) {
				bootbox.alert(<?php echo json_encode(lang('no_sig_captured', '', array(), TRUE)); ?>);
			} else {
				SigImageCallback(signaturePad.toDataURL().split(",")[1]);
				$("#capture_digital_sig_button").show();
			}
		<?php
		} else {
		?>
			if (NumberOfTabletPoints() == 0) {
				bootbox.alert(<?php echo json_encode(lang('no_sig_captured', '', array(), TRUE)); ?>);
			} else {
				SetTabletState(0, refresh_timer);
				//RETURN TOPAZ-FORMAT SIGSTRING
				SetSigCompressionMode(1);
				var sig = GetSigString();

				//RETURN BMP BYTE ARRAY CONVERTED TO BASE64 STRING
				SetImageXSize(500);
				SetImageYSize(100);
				SetImagePenWidth(5);
				GetSigImageB64(SigImageCallback);
				$("#capture_digital_sig_button").show();
			}
		<?php
		}
		?>
	});

	function SigImageCallback(str) {
		$("#digital_sig_holder").hide();
		$.post('<?php echo site_url('sales/sig_save'); ?>', {
			sale_id: <?php echo json_encode($sale_id_raw); ?>,
			image: str
		}, function(response) {
			$("#signature_holder").empty();
			$("#signature_holder").append('<img src="' + SITE_URL + '/app_files/view_cacheable/' + response.file_id + '?timestamp=' + response.file_timestamp + '" width="250" />');
		}, 'json');

	}

	<?php
	//EMV Usb Reset
	if (isset($reset_params)) {
	?>
		var data = {};
		<?php
		foreach ($reset_params['post_data'] as $name => $value) {
			if ($name && $value) {
		?>
				data['<?php echo $name; ?>'] = '<?php echo $value; ?>';
		<?php
			}
		}
		?>

		mercury_emv_pad_reset(<?php echo json_encode($reset_params['post_host']); ?>, <?php echo $this->Location->get_info_for_key('listener_port'); ?>, data);
	<?php
	}
	if (isset($trans_cloud_reset) && $trans_cloud_reset) {
	?>
		$.get(<?php echo json_encode(site_url('sales/reset_pin_pad')); ?>);
	<?php
	}
	?>

	<?php
	if (isset($prompt_for_customer_info) && $prompt_for_customer_info) {
	?>
		$.get(<?php echo json_encode(site_url('sales/prompt_for_customer_info/' . $sale_id_raw)); ?>);
	<?php
	}
	?>

	<?php if ($this->config->item('auto_capture_signature')) { ?>
		$("#capture_digital_sig_button").click();
	<?php } ?>
</script>

<?php if (($is_integrated_credit_sale || $is_sale_integrated_ebt_sale) && $is_sale) { ?>
	<script type="text/javascript">
		show_feedback('success', <?php echo json_encode(lang('sales_credit_card_processing_success', '', array(), TRUE)); ?>, <?php echo json_encode(lang('success', '', array(), TRUE)); ?>);
	</script>
<?php } ?>

<script>
	html2canvas(document.querySelector("#receipt_wrapper"), {
		height: $("#receipt_wrapper").height(),
		windowWidth: 280,
		onclone: function(doc) {
			doc.querySelector('#invoice-policy-return').style.display = 'none';
			doc.querySelector('#invoice-policy-return-mobile').style.display = 'block';

			doc.querySelector('#announcement').style.display = 'none';
			doc.querySelector('#announcement-mobile').style.display = 'block';

			doc.querySelector('.remove_when_mobile').style.display = 'none';
			doc.querySelector('.keep_when_mobile').style.display = 'block';



			doc.querySelectorAll('.invoice-table-content').forEach(function(item) {
				item.style.borderBottom = 'none';
			});


			doc.querySelectorAll('.receipt-row-item-holder').forEach(function(item) {
				item.style.clear = 'both';
			});

			if ($("#capture_digital_sig_button").length) {
				doc.querySelector('#capture_digital_sig_button').style.display = 'none';
			}

		}
	}).then(canvas => {
		document.getElementById("print_image_output").innerHTML = canvas.toDataURL();
	});

	$(document).ready(function() {
		// $('#receipt_wrapper').css('min-height', (1200 + parseInt('<?php echo $number_of_items_sold * 35; ?>') )+'px' );

		var morepx = parseInt('<?php echo $number_of_items_sold * 45; ?>'); // Example additional pixels value, change as needed
		const height = $('#receipt-draggable').height();
		console.log("height", height);
		$('.add_top').each(function() {
			var $element = $(this); // The current .add_top element being iterated
			var currentTop = parseInt($element.css('top'), 10); // Gets the current top value as an integer
			var newTop = currentTop + height - 300; // Calculate the new top value
			$element.css('top', newTop + 'px'); // Set the new top value back to the element
		});


	});
</script>
<script type="text/print-image" id="print_image_output"></script>
<!-- This is used for mobile apps to print receipt-->
<script type="text/print" id="print_output">




	<?php echo $company; ?>

<?php echo H($this->Location->get_info_for_key('address', isset($override_location_id) ? $override_location_id : FALSE)); ?>

<?php echo H($this->Location->get_info_for_key('phone', isset($override_location_id) ? $override_location_id : FALSE)); ?>

<?php if ($website) { ?>
<?php echo H($website); ?>
	
<?php } ?>

<?php echo H($receipt_title); ?>

<?php echo H($transaction_time); ?>

<?php if (isset($customer)) { ?>
	<?php echo lang('customer', '', array(), TRUE) . ": " . H($customer); ?>
	<?php if (!$this->config->item('remove_customer_contact_info_from_receipt')) { ?>
	
	<?php if (!empty($customer_address_1)) { ?><?php echo lang('address', '', array(), TRUE); ?>: <?php echo H($customer_address_1 . ' ' . $customer_address_2); ?><?php } ?>
	<?php if (!empty($customer_city)) {
			echo H($customer_city . ' ' . $customer_state . ', ' . $customer_zip); ?><?php } ?>
	<?php if (!empty($customer_country)) {
			echo H($customer_country); ?> <?php } ?>
	<?php if (!empty($customer_phone)) { ?><?php echo lang('phone_number', '', array(), TRUE); ?> : <?php echo H(format_phone_number($customer_phone)); ?> <?php } ?>

	<?php if (!empty($customer_email)) { ?><?php echo lang('email', '', array(), TRUE); ?> : <?php echo H($customer_email); ?><?php } ?>

<?php } else { ?>
	
<?php
	}
}
?>
<?php echo lang('sale_id', '', array(), TRUE) . ": " . $sale_id; ?>
<?php if (isset($sale_type)) { ?>
<?php echo $sale_type; ?>
<?php } ?>
	
<?php if (!$this->config->item('remove_employee_from_receipt')) { ?>
<?php echo lang('employee', '', array(), TRUE) . ": " . $this->config->item('remove_employee_lastname_from_receipt') ? $employee_firstname : $employee; ?>
<?php } ?>
	
<?php
if ($this->Location->get_info_for_key('enable_credit_card_processing', isset($override_location_id) ? $override_location_id : FALSE)) {
	echo lang('merchant_id', '', array(), TRUE) . ': ' . H($this->Location->get_merchant_id(isset($override_location_id) ? $override_location_id : FALSE));
}
?>

<?php echo lang('item', '', array(), TRUE); ?>            <?php echo lang('price', '', array(), TRUE); ?> <?php echo lang('quantity', '', array(), TRUE); ?><?php if ($discount_exists) {
																																								echo ' ' . lang('discount_percent', '', array(), TRUE);
																																							} ?> <?php echo lang('total', '', array(), TRUE); ?>

---------------------------------------
<?php
foreach (array_reverse($cart_items, true) as $line => $item) {

	if ($this->config->item('hide_repair_items_on_receipt')) {
		if ($item->is_repair_item == 1) {
			continue;
		}
	}
?>
<?php echo character_limiter(H($item->name), 14, '...'); ?><?php echo strlen($item->name) < 14 ? str_repeat(' ', 14 - strlen(H($item->name))) : ''; ?> <?php echo str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency($item->unit_price, 10)); ?> <?php echo to_quantity($item->quantity); ?><?php if ($discount_exists) {
																																																																														echo ' ' . $item->discount;
																																																																													} ?> <?php echo str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency($item->unit_price * $item->quantity - $item->unit_price * $item->quantity * $item->discount / 100, 10)); ?>

  <?php echo clean_html($item->description); ?>  <?php echo isset($item->serialnumber) ? H($item->serialnumber) : ''; ?>
	

<?php
}
?>

<?php echo lang('sub_total', '', array(), TRUE); ?>: <?php echo str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency($subtotal)); ?>


<?php foreach ($taxes as $name => $value) { ?>
<?php echo $name; ?>: <?php echo str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency($value)); ?>

<?php }; ?>

<?php echo lang('total', '', array(), TRUE); ?>: <?php echo $this->config->item('round_cash_on_sales') && $is_sale_cash_payment ?  str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency(round_to_nearest_05($total))) : str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency($total)); ?>

<?php echo lang('items_sold', '', array(), TRUE); ?>: <?php echo to_quantity($number_of_items_sold); ?>

<?php
foreach ($payments as $payment_id => $payment) { ?>

<?php echo (isset($show_payment_times) && $show_payment_times) ?  date(get_date_format() . ' ' . get_time_format(), strtotime($payment->payment_date)) : lang('payment', '', array(), TRUE); ?>  <?php if (($is_integrated_credit_sale || sale_has_partial_credit_card_payment($cart) || sale_has_partial_ebt_payment($cart)) && ($payment->payment_type == lang('credit', '', array(), TRUE) ||  $payment->payment_type == lang('sales_partial_credit', '', array(), TRUE) || $payment->payment_type == lang('ebt', '', array(), TRUE) || $payment->payment_type == lang('partial_ebt', '', array(), TRUE) ||  $payment->payment_type == lang('ebt_cash', '', array(), TRUE) ||  $payment->payment_type == lang('partial_ebt_cash', '', array(), TRUE))) {
																																																		echo $payment->card_issuer . ': ' . $payment->truncated_card; ?> <?php } else { ?><?php $splitpayment = explode(':', $payment->payment_type);
																																																																								echo $splitpayment[0]; ?> <?php } ?><?php echo $this->config->item('round_cash_on_sales') && $payment->payment_type == lang('cash', '', array(), TRUE) ?  str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency(round_to_nearest_05($payment->payment_amount))) : str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency($payment->payment_amount)); ?>

<?php if ($payment->entry_method) { ?>
	
<?php echo lang('sales_entry_method', '', array(), TRUE) . ': ' . H($payment->entry_method); ?>
	
<?php } ?>
<?php if ($payment->tran_type) { ?><?php echo lang('sales_transaction_type', '', array(), TRUE) . ': ' . H($payment->tran_type); ?>
	
<?php } ?>
<?php if ($payment->application_label) { ?><?php echo lang('sales_application_label', '', array(), TRUE) . ': ' . H($payment->application_label); ?>
	
<?php } ?>
<?php if ($payment->ref_no) { ?><?php echo lang('sales_ref_no', '', array(), TRUE) . ': ' . H($payment->ref_no); ?>
	
<?php } ?>
<?php if ($payment->auth_code) { ?><?php echo lang('sales_auth_code', '', array(), TRUE) . ': ' . H($payment->auth_code); ?>
	
<?php } ?>
<?php if ($payment->aid) { ?><?php echo 'AID: ' . H($payment->aid); ?>
	
<?php } ?>
<?php if ($payment->tvr) { ?><?php echo 'TVR: ' . H($payment->tvr); ?>

<?php } ?>
<?php if ($payment->tsi) { ?><?php echo 'TSI: ' . H($payment->tsi); ?>
	
<?php } ?>
<?php if ($payment->arc) { ?><?php echo 'ARC: ' . H($payment->arc); ?>
	
<?php } ?>
<?php if ($payment->cvm) { ?><?php echo 'CVM: ' . H($payment->cvm); ?>
<?php } ?>
<?php
}
?>	
<?php foreach ($payments as $payment) {
	$giftcard_payment_row = explode(':', $payment->payment_type); ?>
<?php if (strpos($payment->payment_type, lang('giftcard', '', array(), TRUE)) === 0) { ?><?php echo lang('sales_giftcard_balance', '', array(), TRUE); ?>  <?php echo $payment->payment_type; ?>: <?php echo str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency($this->Giftcard->get_giftcard_value(end($giftcard_payment_row)))); ?>
	<?php } ?>
<?php } ?>
<?php if ($amount_change >= 0) { ?>
<?php echo lang('change_due', '', array(), TRUE); ?>: <?php echo $this->config->item('round_cash_on_sales')  && $is_sale_cash_payment ?  str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency(round_to_nearest_05($amount_change))) : str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency($amount_change)); ?>
<?php
} else {
?>
<?php echo lang('amount_due', '', array(), TRUE); ?>: <?php echo $this->config->item('round_cash_on_sales')  && $is_sale_cash_payment ?  str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency(round_to_nearest_05($amount_change * -1))) : str_replace('<span style="white-space:nowrap;">-</span>', '-', to_currency($amount_change * -1)); ?>
<?php
}
?>
<?php if (!$disable_loyalty && $this->config->item('enable_customer_loyalty_system') && isset($customer_points) && !$this->config->item('hide_points_on_receipt')) { ?>
	
<?php echo lang('points', '', array(), TRUE); ?>: <?php echo to_currency_no_money($customer_points); ?>
<?php } ?>

<?php if (isset($customer_balance_for_sale) && (float)$customer_balance_for_sale && !$this->config->item('hide_store_account_balance_on_receipt')) { ?>

<?php echo lang('sales_customer_account_balance', '', array(), TRUE); ?>: <?php echo to_currency($customer_balance_for_sale); ?>
<?php
}
?>
<?php
if ($ref_no) {
?>

<?php echo lang('sales_ref_no', '', array(), TRUE); ?>: <?php echo $ref_no; ?>
<?php
}
if (isset($auth_code) && $auth_code) {
?>

<?php echo lang('sales_auth_code', '', array(), TRUE); ?>: <?php echo H($auth_code); ?>
<?php
}
?>
<?php if ($show_comment_on_receipt == 1) {
	echo H($comment);
} ?>

<?php if (!$this->config->item('hide_signature')) { ?>
<?php if ($signature_needed) { ?>
			
<?php echo lang('sales_signature', '', array(), TRUE); ?>: 
------------------------------------------------



<?php
		if ($is_credit_card_sale) {
			echo $sales_card_statement;
		}
?><?php } ?><?php } ?>
<?php if ($return_policy) {
	echo wordwrap(H($return_policy), 40);
} ?>


</script>
<?php
if (isset($standalone) && $standalone) {
	$this->load->view("partial/footer_standalone");
	echo '<div style="page-break-after: always">&nbsp;</div>';
} else {
	$this->load->view("partial/footer");
}
?>