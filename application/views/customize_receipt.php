<?php 
	$this->load->view("partial/header");

?>
<script src="<?php echo base_url(); ?>assets/css_good/plugins/custom/draggable/draggable.bundle.js"></script>
<style>
	.required{
		color: black;
	}

	#border_line{
		border-top: solid 1px black;
		width: 100% !important;
	}
	#border_line2{
		border-top: solid 1px black;
		width: 100% !important;
	}
        .draggable {
            width: 50px;
            height: 30px;
            cursor: move;
			position: absolute;
			padding: 0px;
        }
		#dropZone{
			min-height: 900px;
			position: relative;
		}

		#items-drag{
			min-height: 300px;
		}
		.items-list{
			width: 100% !important;
		}
</style>
<?php $positions = json_decode($receipt['positions']); ?>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<div class="docs-content d-flex flex-column flex-column-fluid" id="kt_docs_content">
						<!--begin::Container-->
						<div class="container p-0 d-flex flex-column flex-lg-row" id="kt_docs_content_container">
							<!--begin::Card-->
							<div class="card card-docs flex-row-fluid mb-2">
								<!--begin::Card Body-->
								<div class="card-body fs-6  text-gray-700" style="padding: 0px;">
									<!--begin::Notice-->
									<div class="d-flex align-items-center rounded py-5 px-4 bg-light-info">
										<!--begin::Icon-->
										<div class="d-flex h-80px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">
											<!--begin::Svg Icon | path: icons/duotune/abstract/abs051.svg-->
											<span class="svg-icon svg-icon-info position-absolute opacity-10">
												<svg class=". w-80px h-80px ." xmlns="http://www.w3.org/2000/svg" width="70px" height="70px" viewBox="0 0 70 70" fill="none">
													<path d="M28 4.04145C32.3316 1.54059 37.6684 1.54059 42 4.04145L58.3109 13.4585C62.6425 15.9594 65.3109 20.5812 65.3109 25.5829V44.4171C65.3109 49.4188 62.6425 54.0406 58.3109 56.5415L42 65.9585C37.6684 68.4594 32.3316 68.4594 28 65.9585L11.6891 56.5415C7.3575 54.0406 4.68911 49.4188 4.68911 44.4171V25.5829C4.68911 20.5812 7.3575 15.9594 11.6891 13.4585L28 4.04145Z" fill="currentColor" />
												</svg>
											</span>
											<!--end::Svg Icon-->
											<!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
											<span class="svg-icon svg-icon-3x svg-icon-info position-absolute">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M22 19V17C22 16.4 21.6 16 21 16H8V3C8 2.4 7.6 2 7 2H5C4.4 2 4 2.4 4 3V19C4 19.6 4.4 20 5 20H21C21.6 20 22 19.6 22 19Z" fill="currentColor" />
													<path d="M20 5V21C20 21.6 19.6 22 19 22H17C16.4 22 16 21.6 16 21V8H8V4H19C19.6 4 20 4.4 20 5ZM3 8H4V4H3C2.4 4 2 4.4 2 5V7C2 7.6 2.4 8 3 8Z" fill="currentColor" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</div>
										<!--end::Icon-->
										<!--begin::Description-->
										<div class="text-gray-700 fw-bold fs-6 lh-lg">Drag and drop to customize receipt.</div>
										<!--end::Description-->
									</div>
									<!--end::Notice-->
									<!--begin::Section-->
									<div class="pt-10">
										<!--begin::Heading-->
										<h1 class="anchor fw-bold mb-5" data-kt-scroll-offset="85" id="swappable">
										<a href="#swappable" data-kt-scroll-toggle=""></a><?= $receipt['title'] ?></h1>
										<button type="button" class="btn btn-primary" onclick="save()">Save</button>
										<!--end::Heading-->
										<!--end::Block-->
										<!--begin::Block-->
										<div class="py-5">
											<!--begin::Row-->
											<div class="row  g-10" style="padding: 0px;">
												<!--begin::Col-->
												<div class="col-md-12">
													<!--begin::Card-->
													<div class="card card-bordered mb-10">
														<!--begin::Card header-->
														<div class="card-header">
															<div class="card-title">
																<h3 class="card-label">List</h3>
															</div>
														</div>
														<!--end::Card header-->
														<!--begin::Card body-->
														<div class="card-body">
															<!--begin::Row-->
															<div class="row  " id="items-drag">
															
																
																<?php 
																$company_name = false;
																$location_name = false;
																$location_address= false;
																$location_phone= false;
																$datetime = false;
																$saleid = false;
																$register_name = false;
																$employee_name = false;
																$customer_name = false;
																$customer_address = false;
																$customer_phone = false;
																$customer_email = false;
																$items_list = false;
																$subtotal =false;
																$total =false;
																$weight= false;
																$no_of_items = false;
																$points = false;
																$amount_due= false;
																$barcode = false;
																$border_line = false;
																$border_line2 = false;
																$i=0;
																foreach ($positions as $subArray) {
																	if (isset($subArray->id) && $subArray->id === 'company_name') {
																		$company_name = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'location_name') {
																		$location_name = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'location_address') {
																		$location_address = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'location_phone') {
																		$location_phone = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'datetime') {
																		$datetime = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'saleid') {
																		$saleid = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'register_name') {
																		$register_name = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'employee_name') {
																		$employee_name = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'customer_name') {
																		$customer_name = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'customer_address') {
																		$customer_address = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'customer_phone') {
																		$customer_phone = $i;
																	}

																	if (isset($subArray->id) && $subArray->id === 'customer_email') {
																		$customer_email = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'items_list') {
																		$items_list = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'subtotal') {
																		$subtotal = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'total') {
																		$total = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'weight') {
																		$weight = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'no_of_items') {
																		$no_of_items = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'points') {
																		$points = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'amount_due') {
																		$amount_due = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'barcode') {
																		$barcode = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'border_line') {
																		$border_line = $i;
																	}
																	if (isset($subArray->id) && $subArray->id === 'border_line2') {
																		$border_line2 = $i;
																	}
																	$i++;
																}
																if ($company_name == false) {
																	?>
																		<div class=" draggable fw-bold" style="position: relative; text-wrap:nowrap; width:20%;" id="company_name">Company Name</div>
	
																	<?php } 

																if ($location_name == false) {
																?>
																	<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="location_name">Location Name</div>

																<?php } ?>
																<?php 
																if ($location_address == false) {
																?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="location_address">Location Address</div>
																<?php } ?>
																<?php 

																if ($location_phone == false) {
																?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="location_phone">Location Phone</div>
																<?php } ?>
																<?php 
																
																if ($datetime == false) {
																?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="datetime">DateTime</div>
																<?php } ?>
																<?php 


																if ($saleid == false) {
																?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="saleid">Sale ID: POS 43</div>
																<?php } ?>
																<?php 

																if ($register_name == false) {
																?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="register_name">Register Name:cachier 1</div>
																<?php } ?>
																<?php 

																if ($employee_name == false) {
																?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="employee_name">Employee:John Doe</div>
																<?php } ?>
																<?php 

																if ($customer_name == false) {
																?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="customer_name">Bill To: <br> Customer: John</div>
																<?php } ?>
																<?php 

																if ($customer_address == false) {
																?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="customer_address">C-Address : steet # 2 Arozona</div>
																<?php } ?>
																<?php 

																if ($customer_phone == false) {
																?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="customer_phone">C-Phone Number : 0-303-392-6343</div>
																<?php } ?>
																<?php 

																if ($customer_email == false) {
																?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="customer_email">C-E-Mail : test@gmail.com</div>

																<?php } ?>
																

																
																<?php if ($items_list == false) { ?>
																<div class=" draggable items-list" style="position: relative; text-wrap:nowrap; width:20%;" id="items_list">
																	<table style="width:100%;" id="receipt-draggable">
																		<thead>
																			<tr>
																				<!-- invoice heading-->
																				<th class="invoice-table">
																					<div class="row">
																						<div class="col-md-12 col-sm-12 col-xs-12">
																							<div class="invoice-head item-name">Item Name</div>
																						</div>
																						<div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element">
																							<div class="invoice-head text-right item-price">
																								Price										</div>
																						</div>
																						<div class="col-md-4 col-sm-4 col-xs-4">
																							<div class="invoice-head text-right item-qty">Qty.</div>
																						</div>

																															<div class="col-md-4 col-sm-4 col-xs-4">
																							<div class="invoice-head pull-right item-total gift_receipt_element">Total</div>
																						</div>

																					</div>
																				</th>
																			</tr>
																		</thead>
																								<tbody data-line="1" data-sale-id="43" data-item-id="5" data-item-name="Burger food" data-item-qty="1.0000000000" data-item-price="33" data-item-total="33" data-item-class="item">
																				<tr class="invoice-item-details">
																					<!-- invoice items-->
																					<td class="invoice-table-content">
																						<div class="row receipt-row-item-holder">
																							<div class="col-md-12 col-sm-12 col-xs-12">
																								<div class="invoice-content invoice-con">
																									<div class="invoice-content-heading">
																										Burger food												</div>

																																					<div class="invoice-desc">
																																						</div>
																									<div class="invoice-desc">
																																						</div>
																									<div class="invoice-desc">
																																						</div>

																																				</div>
																							</div>
																							<div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element">
																								<div class="invoice-content item-price text-right">

																									
																									$33.00											</div>
																							</div>
																							<div class="col-md-4 col-sm-4 col-xs-4 ">
																								<div class="invoice-content item-qty text-right">
																									1
																								</div>
																							</div>
																							
																							<div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element">
																								<div class="invoice-content item-total pull-right">
																									$33.00
																																																</div>
																							</div>
																						</div>
																														</td>
																				</tr>

																			</tbody>
																								<tbody data-line="0" data-sale-id="43" data-item-id="8" data-item-name="Chicken salad" data-item-qty="1.0000000000" data-item-price="38" data-item-total="38" data-item-class="item">
																				<tr class="invoice-item-details">
																					<!-- invoice items-->
																					<td class="invoice-table-content">
																						<div class="row receipt-row-item-holder">
																							<div class="col-md-12 col-sm-12 col-xs-12">
																								<div class="invoice-content invoice-con">
																									<div class="invoice-content-heading">
																										Chicken salad												</div>

																																					<div class="invoice-desc">
																																						</div>
																									<div class="invoice-desc">
																																						</div>
																									<div class="invoice-desc">
																																						</div>

																																				</div>
																							</div>
																							<div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element">
																								<div class="invoice-content item-price text-right">

																									
																									$38.00											</div>
																							</div>
																							<div class="col-md-4 col-sm-4 col-xs-4 ">
																								<div class="invoice-content item-qty text-right">
																									1
																								</div>
																							</div>
																							
																							<div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element">
																								<div class="invoice-content item-total pull-right">
																									$38.00
																																																</div>
																							</div>
																						</div>
																														</td>
																				</tr>

																			</tbody>
																						</table>
																</div>
																<?php } ?>
																<?php if ($subtotal == false) { ?>

																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="subtotal">Sub Total    $71.00</div>
																<?php } ?>
																<?php if ($total == false) { ?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="total">Total $71.00</div>
																<?php } ?>
																<?php if ($weight == false) { ?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="weight">Weight 0</div>
																<?php } ?>
																<?php if ($no_of_items == false) { ?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="no_of_items">Number of items sold 2</div>
																<?php } ?>
																<?php if ($points == false) { ?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="points">Points 558</div>
																<?php } ?>
																<?php if ($amount_due == false) { ?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="amount_due">Amount Due $71.00</div>
																<?php } ?>
																<?php if ($barcode == false) { ?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="barcode">Change return policy <br>
																
																<img src="<?php echo base_url(); ?>barcode/index/svg?barcode=POS 43&amp;text=POS 43" alt="">
															</div>
															<?php } ?>

															<?php if ($border_line == false) { ?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="border_line"></div>
																<?php } ?>
																<?php if ($border_line2 == false) { ?>
																<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="border_line2"></div>
																<?php } ?>
															</div>
															<!--end::Row-->
														</div>
														<!--end::Card body-->
													</div>
													<!--end::Card-->
												</div>
												<!--end::Col-->
												<!--begin::Col-->
												<div class="col-md-12" style="padding: 0px;">
													<!--begin::Card-->
													<div class="card card-bordered">
														<!--begin::Card header-->
														<div class="card-header">
															<div class="card-title">
																<h3 class="card-label">Receipt</h3>
															</div>
														</div>
														<!--end::Card header-->
														<!--begin::Card body-->
														<div class="card-body">
															<!--begin::Row-->
															<div class="row row-cols-1 g-10 " id="dropZone">
															<!--begin::Col-->
															
																<?php 
																
																if ($company_name !== false) {
																?>
																	<div class=" draggable " style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$location_name]->newleft;  ?>; top:<?= $positions[$company_name]->newtop;  ?>; "  data-left="<?= $positions[$company_name]->newleft;  ?>"  data-top="<?= $positions[$company_name]->newtop;  ?>" id="company_name">Company Name</div>

																<?php } ?>

																<!--begin::Col-->

																<?php 
																
																if ($location_name !== false) {
																?>
																	<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$location_name]->newleft;  ?>; top:<?= $positions[$location_name]->newtop;  ?>; "  data-left="<?= $positions[$location_name]->newleft;  ?>"  data-top="<?= $positions[$location_name]->newtop;  ?>" id="location_name">Location Name</div>

																<?php } ?>
																<?php 
																if ($location_address !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$location_address]->newleft;  ?>; top:<?= $positions[$location_address]->newtop;  ?>; "  data-left="<?= $positions[$location_address]->newleft;  ?>"  data-top="<?= $positions[$location_address]->newtop;  ?>" id="location_address">Location Address</div>
																<?php } ?>
																<?php 
																if ($location_phone !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$location_phone]->newleft;  ?>; top:<?= $positions[$location_phone]->newtop;  ?>; "  data-left="<?= $positions[$location_phone]->newleft;  ?>"  data-top="<?= $positions[$location_phone]->newtop;  ?>" id="location_phone">Location Phone</div>
																<?php } ?>
																<?php 
																if ($datetime !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$datetime]->newleft;  ?>; top:<?= $positions[$datetime]->newtop;  ?>; "  data-left="<?= $positions[$datetime]->newleft;  ?>"  data-top="<?= $positions[$datetime]->newtop;  ?>" id="datetime">DateTime</div>
																<?php } ?>
																<?php 
																if ($saleid !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$saleid]->newleft;  ?>; top:<?= $positions[$saleid]->newtop;  ?>; "  data-left="<?= $positions[$saleid]->newleft;  ?>"  data-top="<?= $positions[$saleid]->newtop;  ?>" id="saleid">Sale ID: POS 43</div>
																<?php } ?>
																<?php 
																if ($register_name !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$register_name]->newleft;  ?>; top:<?= $positions[$register_name]->newtop;  ?>; "  data-left="<?= $positions[$register_name]->newleft;  ?>"  data-top="<?= $positions[$register_name]->newtop;  ?>" id="register_name">Register Name:cachier 1</div>
																<?php } ?>
																<?php 
																if ($employee_name !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$employee_name]->newleft;  ?>; top:<?= $positions[$employee_name]->newtop;  ?>; "  data-left="<?= $positions[$employee_name]->newleft;  ?>"  data-top="<?= $positions[$employee_name]->newtop;  ?>" id="employee_name">Employee:John Doe</div>
																<?php } ?>
																<?php 
																if ($customer_name !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$customer_name]->newleft;  ?>; top:<?= $positions[$customer_name]->newtop;  ?>; "  data-left="<?= $positions[$customer_name]->newleft;  ?>"  data-top="<?= $positions[$customer_name]->newtop;  ?>" id="customer_name">Bill To: <br> Customer: John</div>
																<?php } ?>
																<?php 
																if ($customer_address !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$customer_address]->newleft;  ?>; top:<?= $positions[$customer_address]->newtop;  ?>; "  data-left="<?= $positions[$customer_address]->newleft;  ?>"  data-top="<?= $positions[$customer_address]->newtop;  ?>" id="customer_address">C-Address : steet # 2 Arozona</div>
																<?php } ?>
																<?php 
																if ($customer_phone !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$customer_phone]->newleft;  ?>; top:<?= $positions[$customer_phone]->newtop;  ?>; "  data-left="<?= $positions[$customer_phone]->newleft;  ?>"  data-top="<?= $positions[$customer_phone]->newtop;  ?>" id="customer_phone">C-Phone Number : 0-303-392-6343</div>
																<?php } ?>
																<?php 
																if ($customer_email !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$customer_email]->newleft;  ?>; top:<?= $positions[$customer_email]->newtop;  ?>; "  data-left="<?= $positions[$customer_email]->newleft;  ?>"  data-top="<?= $positions[$location_name]->newtop;  ?>" id="customer_email">C-E-Mail : test@gmail.com</div>
																<?php } ?>


																<?php 
																if ($items_list !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:100%; left:<?= $positions[$items_list]->newleft;  ?>; top:<?= $positions[$items_list]->newtop;  ?>; "  data-left="<?= $positions[$items_list]->newleft;  ?>"  data-top="<?= $positions[$items_list]->newtop;  ?>" id="items_list"><table style="width:100%;" id="receipt-draggable">
																		<thead>
																			<tr>
																				<!-- invoice heading-->
																				<th class="invoice-table">
																					<div class="row">
																						<div class="col-md-12 col-sm-12 col-xs-12">
																							<div class="invoice-head item-name">Item Name</div>
																						</div>
																						<div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element">
																							<div class="invoice-head text-right item-price">
																								Price										</div>
																						</div>
																						<div class="col-md-4 col-sm-4 col-xs-4">
																							<div class="invoice-head text-right item-qty">Qty.</div>
																						</div>

																															<div class="col-md-4 col-sm-4 col-xs-4">
																							<div class="invoice-head pull-right item-total gift_receipt_element">Total</div>
																						</div>

																					</div>
																				</th>
																			</tr>
																		</thead>
																								<tbody data-line="1" data-sale-id="43" data-item-id="5" data-item-name="Burger food" data-item-qty="1.0000000000" data-item-price="33" data-item-total="33" data-item-class="item">
																				<tr class="invoice-item-details">
																					<!-- invoice items-->
																					<td class="invoice-table-content">
																						<div class="row receipt-row-item-holder">
																							<div class="col-md-12 col-sm-12 col-xs-12">
																								<div class="invoice-content invoice-con">
																									<div class="invoice-content-heading">
																										Burger food												</div>

																																					<div class="invoice-desc">
																																						</div>
																									<div class="invoice-desc">
																																						</div>
																									<div class="invoice-desc">
																																						</div>

																																				</div>
																							</div>
																							<div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element">
																								<div class="invoice-content item-price text-right">

																									
																									$33.00											</div>
																							</div>
																							<div class="col-md-4 col-sm-4 col-xs-4 ">
																								<div class="invoice-content item-qty text-right">
																									1
																								</div>
																							</div>
																							
																							<div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element">
																								<div class="invoice-content item-total pull-right">
																									$33.00
																																																</div>
																							</div>
																						</div>
																														</td>
																				</tr>

																			</tbody>
																								<tbody data-line="0" data-sale-id="43" data-item-id="8" data-item-name="Chicken salad" data-item-qty="1.0000000000" data-item-price="38" data-item-total="38" data-item-class="item">
																				<tr class="invoice-item-details">
																					<!-- invoice items-->
																					<td class="invoice-table-content">
																						<div class="row receipt-row-item-holder">
																							<div class="col-md-12 col-sm-12 col-xs-12">
																								<div class="invoice-content invoice-con">
																									<div class="invoice-content-heading">
																										Chicken salad												</div>

																																					<div class="invoice-desc">
																																						</div>
																									<div class="invoice-desc">
																																						</div>
																									<div class="invoice-desc">
																																						</div>

																																				</div>
																							</div>
																							<div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element">
																								<div class="invoice-content item-price text-right">

																									
																									$38.00											</div>
																							</div>
																							<div class="col-md-4 col-sm-4 col-xs-4 ">
																								<div class="invoice-content item-qty text-right">
																									1
																								</div>
																							</div>
																							
																							<div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element">
																								<div class="invoice-content item-total pull-right">
																									$38.00
																																																</div>
																							</div>
																						</div>
																														</td>
																				</tr>

																			</tbody>
																						</table></div>
																<?php } ?>
																
																<?php 
																if ($subtotal !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; left:<?= $positions[$subtotal]->newleft;  ?>; top:<?= $positions[$subtotal]->newtop;  ?>; "  data-left="<?= $positions[$subtotal]->newleft;  ?>"  data-top="<?= $positions[$subtotal]->newtop;  ?>" id="subtotal">Sub Total &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  $71.00</div>
																<?php } ?>


																<?php 
																if ($total !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$total]->newleft;  ?>; top:<?= $positions[$total]->newtop;  ?>; "  data-left="<?= $positions[$total]->newleft;  ?>"  data-top="<?= $positions[$total]->newtop;  ?>" id="total">Total &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;   $71.00</div>
																<?php } ?>


																<?php 
																if ($weight !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$weight]->newleft;  ?>; top:<?= $positions[$weight]->newtop;  ?>; "  data-left="<?= $positions[$weight]->newleft;  ?>"  data-top="<?= $positions[$weight]->newtop;  ?>" id="weight">Weight  &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;   0</div>
																<?php } ?>

																<?php 
																if ($no_of_items !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$no_of_items]->newleft;  ?>; top:<?= $positions[$no_of_items]->newtop;  ?>; "  data-left="<?= $positions[$no_of_items]->newleft;  ?>"  data-top="<?= $positions[$no_of_items]->newtop;  ?>" id="no_of_items">Number of items sold  &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;   2</div>
																<?php } ?>
																<?php 
																if ($points !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$points]->newleft;  ?>; top:<?= $positions[$points]->newtop;  ?>; "  data-left="<?= $positions[$points]->newleft;  ?>"  data-top="<?= $positions[$points]->newtop;  ?>" id="points">Points &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; 558</div>
																<?php } ?>
																<?php 
																if ($amount_due !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$amount_due]->newleft;  ?>; top:<?= $positions[$amount_due]->newtop;  ?>; "  data-left="<?= $positions[$amount_due]->newleft;  ?>"  data-top="<?= $positions[$amount_due]->newtop;  ?>" id="amount_due">Amount Due  &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;   $71.00</div>
																<?php } ?>
																<?php 
																if ($barcode !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$barcode]->newleft;  ?>; top:<?= $positions[$barcode]->newtop;  ?>; "  data-left="<?= $positions[$barcode]->newleft;  ?>"  data-top="<?= $positions[$barcode]->newtop;  ?>" id="barcode">Change return policy <br>
																
																<img src="<?php echo base_url(); ?>barcode/index/svg?barcode=POS 43&amp;text=POS 43" alt=""></div>
																<?php } ?>
																<?php
																if ($border_line !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$border_line]->newleft;  ?>; top:<?= $positions[$border_line]->newtop;  ?>; "  data-left="<?= $positions[$border_line]->newleft;  ?>"  data-top="<?= $positions[$border_line]->newtop;  ?>" id="border_line"></div>
																<?php } ?>
																<?php
																if ($border_line2 !== false) {
																?>
																<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$border_line2]->newleft;  ?>; top:<?= $positions[$border_line2]->newtop;  ?>; "  data-left="<?= $positions[$border_line2]->newleft;  ?>"  data-top="<?= $positions[$border_line2]->newtop;  ?>" id="border_line2"></div>
																<?php } ?>

															</div>
															<!--end::Row-->
														</div>
														<!--end::Card body-->
													</div>
													<!--end::Card-->
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
										</div>
										<!--end::Block-->
										<!--begin::Code-->
										
									</div>
									<!--end::Section-->
								</div>
								<!--end::Card Body-->
							</div>
							<!--end::Card-->
						</div>
						<!--end::Container-->
					</div>
					<script>
		$(function() {
			$(".draggable").draggable({
				revert: "invalid",
				containment: "document",  // Limit movement within the specified boundary.
				start: function(event, ui) {
					$(this).draggable('option', 'revert', 'invalid');
					$(this).css(
					{
						'border' : '5px dotted black'
					}
				);
				},
				stop: function(event, ui) {
				$(this).css(
					{
						'border' : 'none'
					}
				);
				}
			});

			$("#dropZone").droppable({
				accept: ".draggable",
				drop: function(event, ui) {

				
					var droppedRelativeLeft = ui.offset.left - $(this).offset().left;
					var droppedRelativeTop = ui.offset.top - $(this).offset().top;

					// Append the dragged item to the drop zone
					ui.draggable.appendTo(this).css({
						top: droppedRelativeTop + 'px',
						left: droppedRelativeLeft + 'px',
						position: 'absolute' ,
						width:(ui.draggable.appendTo(this).attr('id')=='items_list')?'100%':'20%',
					});
					ui.draggable.appendTo(this).attr('data-left' , droppedRelativeLeft +'px' );
					ui.draggable.appendTo(this).attr('data-top' , droppedRelativeTop +'px' );

				}
			});

			$("#items-drag").droppable({
				accept: ".draggable",
				drop: function(event, ui) {
					// Append the dragged item back to the items container and reset its position
					ui.draggable.appendTo(this).css({
						top: '',
						left: '',
						position: 'relative',
						width:'20%',
					});
				}
			});

		});

	$(document).on("mouseup", ".draggable", function(){

		var elem = $(this),
		id = elem.attr('id'),
		desc = elem.attr('data-desc'),
		pos = elem.position();
		elem.attr('data-left' , pos.left +'px' );
		elem.attr('data-top' , pos.top +'px' );
		console.log('Left: '+pos.left+'; Top:'+pos.top);

	});

	function save(){
		pos= [];
		$("#dropZone .draggable").each(function(){
			var elem = $(this),
				id = elem.attr('id');
				newleft = (elem.attr('data-left'))?elem.attr('data-left'):'0px';
				newtop = (elem.attr('data-top'))?elem.attr('data-top'):'0px';
				pos.push({'id':id, 'newleft': newleft, 'newtop':newtop , })
		})

		$.ajax({
				type: 'POST',
				url: '<?php echo site_url("Receipt/update_receipt"); ?>',
				data: { 'tables' : JSON.stringify(pos) , 'receipt' : '<?php echo $receipt['id']; ?>'  },
				success: function(result){
					show_feedback('success', <?php echo json_encode(lang('common_success')); ?>, <?php echo json_encode(lang('common_success')); ?>);
				}
			}) 

	}

	
</script>

<?php $this->load->view("partial/footer"); ?>

