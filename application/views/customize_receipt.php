<?php
$this->load->view("partial/header");

?>
<script src="<?php echo base_url(); ?>assets/css_good/plugins/custom/draggable/draggable.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.js" integrity="sha512-/fgTphwXa3lqAhN+I8gG8AvuaTErm1YxpUjbdCvwfTMyv8UZnFyId7ft5736xQ6CyQN4Nzr21lBuWWA9RTCXCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
	.required {
		color: black;
	}

	#border_line {
		/* border-top: solid 1px black; */
		width: 100% !important;
		height: 1px;
		background-color: black;
	}

	#border_line2 {
		/* border-top: solid 1px black; */
		width: 100% !important;
		height: 1px;
		background-color: black;
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
<?php $positions = (json_decode($receipt['positions'])) ? json_decode($receipt['positions']) : []; ?>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<div class="docs-content d-flex flex-column flex-column-fluid" id="kt_docs_content">
	<!--begin::Container-->
	<div class="container p-0 d-flex flex-column flex-lg-row" id="kt_docs_content_container">
		<!--begin::Card-->
		<div class="card card-docs flex-row-fluid mb-2">
			<!--begin::Card Body-->
			<div class="card-body fs-6  text-gray-700" style="padding: 0px;">
				<!--begin::Notice-->
				<div class="hidden-print">
					<div class="d-flex align-items-center rounded py-5 px-4 bg-light-info  ">
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
				</div>
				<!--end::Notice-->
				<!--begin::Section-->
				<div class="pt-10">
					<!--begin::Heading-->
					<div class="hidden-print">
						<h1 class="anchor fw-bold mb-5 hidden-print" data-kt-scroll-offset="85" id="swappable">
							<a href="#swappable" data-kt-scroll-toggle=""></a><?= $receipt['title'] ?>
						</h1>

						<div class="d-flex justify-content-end hidden-print" data-kt-subscription-table-toolbar="base" data-select2-id="select2-data-202-3x90">
							<!--begin::Filter-->
							<button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
								<!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
								<span class="svg-icon svg-icon-2">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor"></path>
									</svg>
								</span>
								<!--end::Svg Icon-->Filter</button>
							<!--begin::Menu 1-->
							<form class="menu menu-sub menu-sub-dropdown w-500px w-md-500px" data-kt-menu="true" style="" id="filterForm" method="post" action="<?php echo site_url("Receipt/update_receipt_detail"); ?>" enctype="multipart/form-data">
								<input type="hidden" name="id" value="<?php echo $receipt['id']; ?>">
								<!--begin::Header-->
								<div class="px-7 py-5">
									<div class="fs-5 text-dark fw-bold">Filter Options</div>
								</div>
								<!--end::Header-->
								<!--begin::Separator-->
								<div class="separator border-gray-200"></div>
								<!--end::Separator-->
								<!--begin::Content-->



								<div class="px-7 py-5">
									<!--begin::Input group-->
									<div class="mb-10 ">
										<label class="form-label fs-6 fw-semibold">Name:</label>
										<input type="text" value="<?= $receipt['title'] ?>" class="form-control" id="title" name="title">
									</div>
									<!--end::Input group-->
									<!--begin::Input group-->
									<div class="mb-10" data-select2-id="select2-data-200-4jj8">
										<label class="form-label fs-6 fw-semibold">Paper size:</label>
										<select id="papersize" class="form-select form-select-solid fw-bold " data-placeholder="Select option" name="size">
											<option <?= ($receipt['size'] == 'A4') ? 'selected' : ''; ?> value="A4">A4</option>
											<option <?= ($receipt['size'] == 'A3') ? 'selected' : ''; ?> value="A3">A3</option>
											<option <?= ($receipt['size'] == 'A5') ? 'selected' : ''; ?> value="A5">A5</option>
											<option <?= ($receipt['size'] == 'Letter') ? 'selected' : ''; ?> value="Letter">Letter</option>
											<option <?= ($receipt['size'] == 'Legal') ? 'selected' : ''; ?> value="Legal">Legal</option>
											<option <?= ($receipt['size'] == 'Executive') ? 'selected' : ''; ?> value="Executive">Executive</option>
											<option <?= ($receipt['size'] == 'B4') ? 'selected' : ''; ?> value="B4">B4</option>
											<option <?= ($receipt['size'] == 'B5') ? 'selected' : ''; ?> value="B5">B5</option>
											<option <?= ($receipt['size'] == 'custom') ? 'selected' : ''; ?> value="custom">Custom</option>
										</select>
									</div>
									<!--end::Input group-->
									<div class="row customSizeInputs" style="display: <?= ($receipt['size'] == 'custom') ? 'block' : 'none'; ?>;">
										<!--begin::Input group-->
										<div class="mb-10 col-6">
											<label class="form-label fs-6 fw-semibold">Width:</label>
											<input type="number" value="<?= $receipt['width'] ?>" class="form-control" id="width" name="width">
										</div>
										<!--end::Input group-->

										<!--begin::Input group-->
										<div class="mb-10  col-6">
											<label class="form-label fs-6 fw-semibold">Height:</label>
											<input type="number" value="<?= $receipt['height'] ?>" class="form-control" id="height" name="height">
										</div>
										<!--end::Input group-->
									</div>
									<div class="form-group">
										<?php echo form_label(lang('custom_text') . ':', 'custom_text', array('class' => 'form-label fs-6 fw-semibold')); ?>
										<div class="">
											<?php echo form_textarea(array(
												'class' => 'validate form-control form-control-solid form-inps',
												'name' => 'custom_text',
												'id' => 'kt_docs_ckeditor_classic',
												'value' => $receipt['custom_text']
											)); ?>
										</div>
									</div>
									<?php
									$img_logo_image = base_url() . 'assets/css_good/media/svg/avatars/blank.svg';
									if ($receipt['logo_image']) {
										$img_logo_image = cacheable_app_file_url($receipt['logo_image']);
									}
									$img_background_image = '/assets/media/svg/avatars/blank.svg';
									if ($receipt['background_image']) {
										$img_background_image = cacheable_app_file_url($receipt['background_image']);
									}

									?>
									<div class="image-input image-input-empty" data-kt-image-input="true" style="background-image: url(<?= $img_logo_image; ?>)">
										<!--begin::Image preview wrapper-->
										<div class="image-input-wrapper w-125px h-125px"></div>
										<!--end::Image preview wrapper-->

										<!--begin::Edit button-->
										<label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change custom logo">
											<i class="bi bi-pencil-fill fs-7"></i>

											<!--begin::Inputs-->
											<input type="file" name="custom_logo" accept=".png, .jpg, .jpeg" />
											<input type="hidden" name="avatar_remove" />
											<input type="hidden" name="delete_custom_logo" value="<?= $receipt['logo_image'] ?>" />
											<!--end::Inputs-->
										</label>
										<!--end::Edit button-->

										<!--begin::Cancel button-->
										<span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel avatar">
											<i class="bi bi-x fs-2"></i>
										</span>
										<!--end::Cancel button-->

										<!--begin::Remove button-->
										<span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove avatar">
											<i class="bi bi-x fs-2"></i>
										</span>
										<!--end::Remove button-->
									</div>
									<!--end::Image input-->

									<div class="image-input image-input-empty" data-kt-image-input="true" style="background-image: url(<?= $img_background_image; ?>)">
										<!--begin::Image preview wrapper-->
										<div class="image-input-wrapper w-125px h-125px"></div>
										<!--end::Image preview wrapper-->

										<!--begin::Edit button-->
										<label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change background image">
											<i class="bi bi-pencil-fill fs-7"></i>

											<!--begin::Inputs-->
											<input type="file" name="background_image" accept=".png, .jpg, .jpeg" />
											<input type="hidden" name="avatar_remove" />
											<input type="hidden" name="delete_background_image" value="<?= $receipt['background_image'] ?>" />
											<!--end::Inputs-->
										</label>
										<!--end::Edit button-->

										<!--begin::Cancel button-->
										<span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel avatar">
											<i class="bi bi-x fs-2"></i>
										</span>
										<!--end::Cancel button-->

										<!--begin::Remove button-->
										<span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove avatar">
											<i class="bi bi-x fs-2"></i>
										</span>
										<!--end::Remove button-->
									</div>
									<!--end::Image input-->

									<div class="form-check form-check-custom form-check-solid">
										<input class="form-check-input" type="checkbox" value="1" name="default_wo" id="default_work_order" <?= ($receipt['default_wo']) ? 'checked' : ''; ?> />
										<label class="form-check-label" for="default_work_order">
											Default work order
										</label>
									</div>
									<div class="form-check form-check-custom form-check-solid">
										<input class="form-check-input" type="checkbox" <?= ($receipt['default_pos']) ? 'checked' : ''; ?> value="1" name="default_pos" id="default_pos" />
										<label class="form-check-label" for="default_pos">
											Default pos receipt
										</label>
									</div>
									<div class="form-check form-check-custom form-check-solid">
										<input class="form-check-input" type="checkbox" <?= ($receipt['default_estimate']) ? 'checked' : ''; ?> value="1" name="default_estimate" id="default_est" />
										<label class="form-check-label" for="default_est">
											Default for estimate
										</label>
									</div>


									<!--begin::Actions-->
									<div class="d-flex justify-content-end">
										<button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-subscription-table-filter="reset">Cancel</button>
										<button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true">Apply</button>
									</div>
									<!--end::Actions-->
							</form>
							<!--end::Content-->
						</div>
						<!--end::Menu 1-->
						<!--end::Filter-->
						<!--begin::Export-->
						<button type="button" class="btn btn-primary" onclick="save()">Save</button>
						<button class="btn btn-primary btn-lg hidden-print" id="print_button" onclick="print_receipt()"> <?php echo lang('common_print', '', array(), TRUE); ?> </button>
					</div>
				</div>

				<!--end::Heading-->
				<!--end::Block-->
				<!--begin::Block-->
				<div class="py-5">
					<!--begin::Row-->
					<div class="row  g-10" style="padding: 0px;">
						<!--begin::Col-->
						<div class="col-md-12">
							<!--begin::Card-->
							<div class="card card-bordered mb-10 hidden-print">
								<!--begin::Card header-->
								<div class="card-header ">
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
										$company_name = 'false';
										$location_name = 'false';
										$location_address = 'false';
										$location_phone = 'false';
										$datetime = 'false';
										$saleid = 'false';
										$register_name = 'false';
										$employee_name = 'false';
										$customer_name = 'false';
										$customer_address = 'false';
										$customer_phone = 'false';
										$customer_email = 'false';
										$items_list = 'false';
										$subtotal = 'false';
										$total = 'false';
										$weight = 'false';
										$no_of_items = 'false';
										$points = 'false';
										$amount_due = 'false';
										$barcode = 'false';
										$border_line = 'false';
										$border_line2 = 'false';
										$logo = 'false';
										$custom_text = 'false';
										$custom_logo = 'false';
										$exchange_name = 'false';
										$exchange_rate = 'false';
										$tax_amount = 'false';
										$comment_on_receipt = 'false';
										$item_returned = 'false';
										$payments = 'false';
										$giftcard_balance = 'false';
										$ebt_balance = 'false';
										$customer_balance_for_sale = 'false';
										$sales_until_discount = 'false';
										$ref_no = 'false';
										$auth_code = 'false';
										$taxable_subtotal = 'false';
										$taxable_summary = 'false';
										$non_taxable_subtotal = 'false';
										$amount_change = 'false';
										$amount_discount = 'false';
										$coupons = 'false';
										$announcement = 'false';
										$signature = 'false';

										$i = 0;
										

										if (count($positions) > 0) :

											foreach ($positions as $subArray) {
												if (isset($subArray->id) && $subArray->id === 'logo') {
													$logo = $i;
												}
												if (isset($subArray->id) && $subArray->id === 'custom_logo') {
													$custom_logo = $i;
												}
												if (isset($subArray->id) && $subArray->id === 'company_name') {
													$company_name = $i;
												}


												if (isset($subArray->id) && $subArray->id === 'custom_text') {
													$custom_text = $i;
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
												if (isset($subArray->id) && $subArray->id === 'exchange_name') {
													$exchange_name = $i;
												}
												if (isset($subArray->id) && $subArray->id === 'exchange_rate') {
													$exchange_rate = $i;
												}
												if (isset($subArray->id) && $subArray->id === 'tax_amount') {
													$tax_amount = $i;
												}
												if (isset($subArray->id) && $subArray->id === 'comment_on_receipt') {
													$comment_on_receipt = $i;
												}
												if (isset($subArray->id) && $subArray->id === 'item_returned') {
													$item_returned = $i;
												}

												if (isset($subArray->id) && $subArray->id === 'payments') {
													$payments = $i;
												}



												if (isset($subArray->id) && $subArray->id === 'giftcard_balance') {
													$giftcard_balance = $i;
												}
												if (isset($subArray->id) && $subArray->id === 'ebt_balance') {
													$ebt_balance = $i;
												}

												if (isset($subArray->id) && $subArray->id === 'customer_balance_for_sale') {
													$customer_balance_for_sale = $i;
												}



												if (isset($subArray->id) && $subArray->id === $sales_until_discount) {
													$sales_until_discount = $i;
												}


												if (isset($subArray->id) && $subArray->id === 'ref_no') {
													$ref_no = $i;
												}


												if (isset($subArray->id) && $subArray->id === 'auth_code') {
													$auth_code = $i;
												}



												if (isset($subArray->id) && $subArray->id === 'taxable_subtotal') {
													$taxable_subtotal = $i;
												}

												if (isset($subArray->id) && $subArray->id === 'taxable_summary') {
													$taxable_summary = $i;
												}

												if (isset($subArray->id) && $subArray->id === 'non_taxable_subtotal') {
													$non_taxable_subtotal = $i;
												}

												if (isset($subArray->id) && $subArray->id === 'amount_change') {
													$amount_change = $i;
												}

												if (isset($subArray->id) && $subArray->id === 'amount_discount') {
													$amount_discount = $i;
												}


												if (isset($subArray->id) && $subArray->id === 'coupons') {
													$coupons = $i;
												}

												if (isset($subArray->id) && $subArray->id === 'announcement') {
													$announcement = $i;
												}


												if (isset($subArray->id) && $subArray->id == 'signature') {
													$signature = $i;
												}
												$i++;
											}
										endif;
										if ($company_name === 'false') {
										?>
											<div class=" draggable fw-bold" style="position: relative; text-wrap:nowrap; width:20%;" id="company_name">Company Name</div>

										<?php }
										if ($custom_text === 'false') {
										?>
											<div class=" draggable fw-bold" style="position: relative; text-wrap:nowrap; width:20%;" id="custom_text"><?= $receipt['custom_text']; ?></div>

										<?php }
										if ($logo === 'false') {
										?>
											<div class=" resize fw-bold" style="position: relative; text-wrap:nowrap; width:20%;" id="logo">
												<?php echo img(
													array(
														'src' => base_url() . $this->config->item('branding')['logo_path'],


													)
												); ?></div>

										<?php }
										if ($custom_logo === 'false') {
										?>
											<div class=" resize fw-bold" style="position: relative; text-wrap:nowrap; width:20%;" id="custom_logo">
												<?php echo img(
													array(
														'src' => $img_logo_image,


													)
												); ?></div>

										<?php }



										if ($location_name === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="location_name">
										<div class="d-flex flex-stack mb-3">
										
											<div class="fw-semibold text-end text-gray-600 fs-7">Exchange name</div>
											
											<div class="ps-10 fw-bold fs-6 text-gray-800">5%</div>
								
										</div></div>

										<?php } ?>


                    <?php 

										
										 
										?>
<?php if ($exchange_name === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:35%;" id="exchange_name"><div class="d-flex flex-stack mb-3">
										
										<div class="fw-semibold text-end text-gray-600 fs-7 w-75">Exchange To exchange name
</div>
										
										<div class="ps-10 fw-bold fs-6 text-gray-800">5</div>
							
									</div></div>

										<?php } ?>
									<?php if ($exchange_rate === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="exchange_rate">Exchange rate</div>

										<?php } ?>

										<?php if($tax_amount==='false'){ ?>
											<div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="tax_amount">
												
												<div class="d-flex flex-stack mb-3">
													<div class="fw-semibold text-end text-gray-600 fs-7">5.000% Global Tax</div>
													<div class="ps-10 fw-bold fs-6 text-gray-800">$5</div>
																		
												</div>


											</div>
											<?php } ?>

											


											<?php if ($comment_on_receipt == 'false') { ?> <div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="comment_on_receipt"> comment on receipt </div> <?php } ?>



										<?php if ($item_returned == 'false') { ?> <div class="draggable" style="position: relative; width:20%;" id="item_returned"> <div class="d-flex flex-stack mb-3">
																			<div class="fw-semibold text-end text-gray-600 fs-7"><?php echo lang('common_items_returned', '', array(), TRUE); ?></div>
																			<div class="ps-10 fw-bold fs-6 text-gray-800">5</div>
																		
														</div></div> <?php } ?>


										<?php if ($payments == 'false') { ?> <div class="draggable" style="position:relative; text-wrap:nowrap; width:20%;" id="payments"> payments </div> <?php } ?>

									

										<?php if($giftcard_balance == 'false') { ?> <div class="draggable" style="position:relative; text-wrap:nowrap; width:20%;" id="giftcard_balance"> giftcards balance </div> <?php } ?>


										 <?php if ($ebt_balance == 'false') { ?> <div class="draggable" style="position:relative; text-wrap:nowrap; width:20%;" id="ebt_balance"> ebt balance </div> <?php } ?> 

										
										
										<?php if($customer_balance_for_sale == 'false') { ?> <div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="customer_balance_for_sale"> customer balance for sale</div> <?php } ?>
										
										
											<?php if ($sales_until_discount == 'false') { ?> <div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="sales_until_discount"> sales until discount</div> <?php } ?>

								

										<?php if ($ref_no == 'false') { ?> <div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="ref_no"> ref no </div> <?php } ?>
									
										<?php if($auth_code == 'false') { ?> <div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="auth_code"> auth code </div> <?php } ?>

										

										<?php if($taxable_subtotal == 'false') { ?> <div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="taxable_subtotal" > taxable_subtotal </div> <?php } ?>
										<?php if($taxable_summary =='false') { ?> <div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="taxable_summary" > taxable summary </div> <?php } ?>
										<?php if ($non_taxable_subtotal == 'false') {  ?> <div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;"  id="non_taxable_subtotal"> non-taxable subtotal </div> <?php }  ?>
									
										<?php if($amount_change == 'false') { ?> <div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="amount_change" > amount change </div> <?php } ?>
										
										<?php if($amount_discount == 'false') { ?> <div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;"  id="amount_discount"> amount discount </div> <?php } ?>
									
										<?php if($coupons == 'false') { ?> <div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;"  id="coupons"> coupons </div> <?php } ?>
									
										<?php if($announcement =='false'){ ?> <div class="draggable" style="position: relative; text-wrap:nowrap; width:20%;"  id="announcement"> announcements </div> <?php } ?>

											<?php if($signature =='false') {?> <div class="draggable" style="position: relative; text-wrap: nowrap; width:20%;"  id="signature"> signatures </div> <?php } ?>


										<?php
										if ($location_address === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="location_address">Location Address</div>
										<?php } ?>
										<?php

										if ($location_phone === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="location_phone">Location Phone</div>
										<?php } ?>
										<?php

										if ($datetime === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="datetime">DateTime</div>
										<?php } ?>
										<?php


										if ($saleid === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="saleid">Sale ID: POS 43</div>
										<?php } ?>
										<?php

										if ($register_name === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="register_name">Register Name:cachier 1</div>
										<?php } ?>
										<?php

										if ($employee_name === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="employee_name">Employee:John Doe</div>
										<?php } ?>
										<?php

										if ($customer_name === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="customer_name">Bill To: <br> Customer: John</div>
										<?php } ?>
										<?php

										if ($customer_address === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="customer_address">C-Address : steet # 2 Arozona</div>
										<?php } ?>
										<?php

										if ($customer_phone === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="customer_phone">C-Phone Number : 0-303-392-6343</div>
										<?php } ?>
										<?php

										if ($customer_email === 'false') {
										?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="customer_email">C-E-Mail : test@gmail.com</div>

										<?php } ?>



										<?php

										if ($items_list === 'false') {

										?>
											<div class=" resize items-list" style="position: relative; text-wrap:nowrap; width:20%;" id="items_list">
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
																			Price </div>
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
																				Burger food </div>

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


																			$33.00 </div>
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
																				Chicken salad </div>

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


																			$38.00 </div>
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
										<?php if ($subtotal === 'false') { ?>

											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="subtotal">Sub Total $71.00</div>
										<?php } ?>
										<?php if ($total === 'false') { ?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="total">Total $71.00</div>
										<?php } ?>
										<?php if ($weight === 'false') { ?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="weight"><?php echo lang('items_weight', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4</div>
										<?php } ?>
										<?php if ($no_of_items === 'false') { ?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="no_of_items"><?php echo lang('common_items_sold', '', array(), TRUE); ?>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2</div>
										<?php } ?>
										<?php if ($points === 'false') { ?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="points">Points 558</div>
										<?php } ?>
										<?php if ($amount_due === 'false') { ?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="amount_due">Amount Due $71.00</div>
										<?php } ?>
										<?php if ($barcode === 'false') { ?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="barcode">Change return policy <br>

												<img src="<?php echo base_url(); ?>barcode/index/svg?barcode=POS 43&amp;text=POS 43" alt="">
											</div>
										<?php } ?>

										<?php if ($border_line === 'false') { ?>
											<div class=" draggable" style="position: relative; text-wrap:nowrap; width:20%;" id="border_line"></div>
										<?php } ?>
										<?php if ($border_line2 === 'false') { ?>
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
								<div class="card-header hidden-print">
									<div class="card-title">
										<h3 class="card-label">Receipt</h3>
									</div>
								</div>
								<!--end::Card header-->
								<!--begin::Card body-->
								<?php

									if ($receipt['background_image']) {
										$img_background_image = cacheable_app_file_url($receipt['background_image']);
									}
									?>
								<div class="card-body elementWithBackground  <?= $receipt['size'] ?> p-0 m-auto" id="receipt_wrapper_inner" <?php if ($receipt['background_image']) { ?>style="  background-size: contain; background-position: center top;  
 background-repeat: repeat-y; height:auto;  background-image: url(<?= $img_background_image; ?>)" <?php } ?>>
									<!--begin::Row-->
									


									<div class="row row-cols-1 g-10  "  id="dropZone" style="height: 600mm;">
										<!--begin::Col-->

										<?php
										if (count($positions) > 0) :

											// echo "<pre>";
											// print_r($positions);
											// exit();
											if ($company_name !== 'false') {
										?>
												<div class=" draggable " style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$company_name]->newleft;  ?>; top:<?= $positions[$company_name]->newtop;  ?>; " data-left="<?= $positions[$company_name]->newleft;  ?>" data-top="<?= $positions[$company_name]->newtop;  ?>" id="company_name">Company Name</div>

											<?php }

											if ($custom_text !== 'false') {
											?>
												<div class=" draggable fw-bold" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$custom_text]->newleft;  ?>; top:<?= $positions[$custom_text]->newtop;  ?>; " data-left="<?= $positions[$custom_text]->newleft;  ?>" data-top="<?= $positions[$custom_text]->newtop;  ?>" id="custom_text"><?= $receipt['custom_text']; ?></div>

											<?php }

											if ($logo !== 'false') {
											?>
												<div class=" resize " style="position: absolute; width:<?= $positions[$logo]->newwidth;  ?>px;height:<?= $positions[$logo]->newheight;  ?>px; text-wrap:nowrap; left:<?= $positions[$logo]->newleft;  ?>; top:<?= $positions[$logo]->newtop;  ?>; " data-left="<?= $positions[$logo]->newleft;  ?>" data-top="<?= $positions[$logo]->newtop;  ?>" data-current_width="<?= $positions[$logo]->newwidth;  ?>" data-current_height="<?= $positions[$logo]->newheight;  ?>" id="logo">
													<?php echo img(
														array(
															'src' => base_url() . $this->config->item('branding')['logo_path'],


														)
													); ?>


												</div>

											<?php }

											if ($custom_logo !== 'false') {
											?>
												<div class=" resize " style="position: absolute; width:<?= $positions[$custom_logo]->newwidth;  ?>px;height:<?= $positions[$custom_logo]->newheight;  ?>px; text-wrap:nowrap; left:<?= $positions[$custom_logo]->newleft;  ?>; top:<?= $positions[$custom_logo]->newtop;  ?>; " data-left="<?= $positions[$custom_logo]->newleft;  ?>" data-top="<?= $positions[$custom_logo]->newtop;  ?>" data-current_width="<?= $positions[$custom_logo]->newwidth;  ?>" data-current_height="<?= $positions[$custom_logo]->newheight;  ?>" id="custom_logo">
													<?php echo img(
														array(
															'src' => $img_logo_image,


														)
													); ?>


												</div>

											<?php } ?>



											<!--begin::Col-->

											<?php

											if ($location_name !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$location_name]->newleft;  ?>; top:<?= $positions[$location_name]->newtop;  ?>; " data-left="<?= $positions[$location_name]->newleft;  ?>" data-top="<?= $positions[$location_name]->newtop;  ?>" id="location_name">Location Name</div>

											<?php } ?>
											<?php
											if ($location_address !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$location_address]->newleft;  ?>; top:<?= $positions[$location_address]->newtop;  ?>; " data-left="<?= $positions[$location_address]->newleft;  ?>" data-top="<?= $positions[$location_address]->newtop;  ?>" id="location_address">Location Address</div>
											<?php } ?>
											<?php
											if ($location_phone !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$location_phone]->newleft;  ?>; top:<?= $positions[$location_phone]->newtop;  ?>; " data-left="<?= $positions[$location_phone]->newleft;  ?>" data-top="<?= $positions[$location_phone]->newtop;  ?>" id="location_phone">Location Phone</div>
											<?php } ?>
											<?php
											if ($datetime !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$datetime]->newleft;  ?>; top:<?= $positions[$datetime]->newtop;  ?>; " data-left="<?= $positions[$datetime]->newleft;  ?>" data-top="<?= $positions[$datetime]->newtop;  ?>" id="datetime">DateTime</div>
											<?php } ?>
											<?php
											if ($saleid !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$saleid]->newleft;  ?>; top:<?= $positions[$saleid]->newtop;  ?>; " data-left="<?= $positions[$saleid]->newleft;  ?>" data-top="<?= $positions[$saleid]->newtop;  ?>" id="saleid">Sale ID: POS 43</div>
											<?php } ?>
											<?php
											if ($register_name !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$register_name]->newleft;  ?>; top:<?= $positions[$register_name]->newtop;  ?>; " data-left="<?= $positions[$register_name]->newleft;  ?>" data-top="<?= $positions[$register_name]->newtop;  ?>" id="register_name">Register Name:cachier 1</div>
											<?php } ?>
											<?php
											if ($employee_name !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$employee_name]->newleft;  ?>; top:<?= $positions[$employee_name]->newtop;  ?>; " data-left="<?= $positions[$employee_name]->newleft;  ?>" data-top="<?= $positions[$employee_name]->newtop;  ?>" id="employee_name">Employee:John Doe</div>
											<?php } ?>
											<?php
											if ($customer_name !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$customer_name]->newleft;  ?>; top:<?= $positions[$customer_name]->newtop;  ?>; " data-left="<?= $positions[$customer_name]->newleft;  ?>" data-top="<?= $positions[$customer_name]->newtop;  ?>" id="customer_name">Bill To: <br> Customer: John</div>
											<?php } ?>
											<?php
											if ($customer_address !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$customer_address]->newleft;  ?>; top:<?= $positions[$customer_address]->newtop;  ?>; " data-left="<?= $positions[$customer_address]->newleft;  ?>" data-top="<?= $positions[$customer_address]->newtop;  ?>" id="customer_address">C-Address : steet # 2 Arozona</div>
											<?php } ?>
											<?php
											if ($customer_phone !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$customer_phone]->newleft;  ?>; top:<?= $positions[$customer_phone]->newtop;  ?>; " data-left="<?= $positions[$customer_phone]->newleft;  ?>" data-top="<?= $positions[$customer_phone]->newtop;  ?>" id="customer_phone">C-Phone Number : 0-303-392-6343</div>
											<?php } ?>
											<?php
											if ($customer_email !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$customer_email]->newleft;  ?>; top:<?= $positions[$customer_email]->newtop;  ?>; " data-left="<?= $positions[$customer_email]->newleft;  ?>" data-top="<?= $positions[$customer_email]->newtop;  ?>" id="customer_email">C-E-Mail : test@gmail.com</div>
											<?php } ?>


											<?php
											if ($items_list !== 'false') {
											?>
												<div class=" resize" style="position: absolute; width:<?= $positions[$items_list]->newwidth;  ?>px;height:<?= $positions[$items_list]->newheight;  ?>px; left:<?= $positions[$items_list]->newleft;  ?>; top:<?= $positions[$items_list]->newtop;  ?>; " data-left="<?= $positions[$items_list]->newleft;  ?>" data-top="<?= $positions[$items_list]->newtop;  ?>" data-current_width="<?= $positions[$items_list]->newwidth;  ?>" data-current_height="<?= $positions[$items_list]->newheight;  ?>" id="items_list">
													<table style="width:90%; margin: 0 auto; " id="receipt-draggable">
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
																				Price </div>
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
																					Burger food </div>

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


																				$33.00 </div>
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
																					Chicken salad </div>

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


																				$38.00 </div>
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

											<?php
											if ($subtotal !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; left:<?= $positions[$subtotal]->newleft;  ?>; top:<?= $positions[$subtotal]->newtop;  ?>; " data-left="<?= $positions[$subtotal]->newleft;  ?>" data-top="<?= $positions[$subtotal]->newtop;  ?>" id="subtotal">Sub Total &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; $71.00</div>
											<?php } ?>


											<?php
											if ($total !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$total]->newleft;  ?>; top:<?= $positions[$total]->newtop;  ?>; " data-left="<?= $positions[$total]->newleft;  ?>" data-top="<?= $positions[$total]->newtop;  ?>" id="total">Total &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; $71.00</div>
											<?php } ?>


											<?php
											if ($weight !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$weight]->newleft;  ?>; top:<?= $positions[$weight]->newtop;  ?>; " data-left="<?= $positions[$weight]->newleft;  ?>" data-top="<?= $positions[$weight]->newtop;  ?>" id="weight"><?php echo lang('items_weight', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 0</div>
											<?php } ?>

											<?php
											if ($no_of_items !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$no_of_items]->newleft;  ?>; top:<?= $positions[$no_of_items]->newtop;  ?>; " data-left="<?= $positions[$no_of_items]->newleft;  ?>" data-top="<?= $positions[$no_of_items]->newtop;  ?>" id="no_of_items"><?php echo lang('common_items_sold', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2</div>
											<?php } ?>
											<?php
											if ($points !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$points]->newleft;  ?>; top:<?= $positions[$points]->newtop;  ?>; " data-left="<?= $positions[$points]->newleft;  ?>" data-top="<?= $positions[$points]->newtop;  ?>" id="points">Points &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 558</div>
											<?php } ?>
											<?php
											if ($amount_due !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$amount_due]->newleft;  ?>; top:<?= $positions[$amount_due]->newtop;  ?>; " data-left="<?= $positions[$amount_due]->newleft;  ?>" data-top="<?= $positions[$amount_due]->newtop;  ?>" id="amount_due">Amount Due &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; $71.00</div>
											<?php } ?>
											<?php
											if ($barcode !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$barcode]->newleft;  ?>; top:<?= $positions[$barcode]->newtop;  ?>; " data-left="<?= $positions[$barcode]->newleft;  ?>" data-top="<?= $positions[$barcode]->newtop;  ?>" id="barcode">Change return policy <br>

													<img src="<?php echo base_url(); ?>barcode/index/svg?barcode=POS 43&amp;text=POS 43" alt="">
												</div>
											<?php } ?>
											<?php
											if ($border_line !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$border_line]->newleft;  ?>; top:<?= $positions[$border_line]->newtop;  ?>; " data-left="<?= $positions[$border_line]->newleft;  ?>" data-top="<?= $positions[$border_line]->newtop;  ?>" id="border_line"></div>
											<?php } ?>
											<?php
											if ($border_line2 !== 'false') {
											?>
												<div class=" draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$border_line2]->newleft;  ?>; top:<?= $positions[$border_line2]->newtop;  ?>; " data-left="<?= $positions[$border_line2]->newleft;  ?>" data-top="<?= $positions[$border_line2]->newtop;  ?>" id="border_line2"></div>
										<?php } ?>

													

													<?php if ($exchange_name !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:25%; text-wrap:nowrap; left:<?= $positions[$exchange_name]->newleft; ?>; top:<?= $positions[$exchange_name]->newtop; ?>;" data-left="<?= $positions[$exchange_name]->newleft; ?>" data-top="<?= $positions[$exchange_name]->newtop; ?>" id="exchange_name">
										<div class="d-flex flex-stack mb-3">
										
											<div class="fw-semibold text-end text-gray-600 fs-7 w-75">Exchange To exchange name
</div>
											
											<div class="ps-10 fw-bold fs-6 text-gray-800">5%</div>
								
										</div></div>
													<?php } ?>

													<?php if ($exchange_rate !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$exchange_rate]->newleft; ?>; top:<?= $positions[$exchange_rate]->newtop; ?>;" data-left="<?= $positions[$exchange_rate]->newleft; ?>" data-top="<?= $positions[$exchange_rate]->newtop; ?>" id="exchange_rate">exchange rate</div>
													<?php } ?>

													<?php if ($tax_amount !== 'false') { ?>
													<div class="draggable" style="position: absolute;  width:25%; text-wrap:nowrap; left:<?= $positions[$tax_amount]->newleft; ?>; top:<?= $positions[$tax_amount]->newtop; ?>;" data-left="<?= $positions[$tax_amount]->newleft; ?>" data-top="<?= $positions[$tax_amount]->newtop; ?>" id="tax_amount">
													<div class="d-flex flex-stack mb-3">
													<div class="fw-semibold text-end text-gray-600 fs-7 w-75">5.000% Global Tax</div>
													<div class="ps-10 fw-bold fs-6 text-gray-800">$5</div>
																		
												</div>
													</div>
													<?php } ?>

													<?php if ($comment_on_receipt !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$comment_on_receipt]->newleft; ?>; top:<?= $positions[$comment_on_receipt]->newtop; ?>;" data-left="<?= $positions[$comment_on_receipt]->newleft; ?>" data-top="<?= $positions[$comment_on_receipt]->newtop; ?>" id="comment_on_receipt">comment on receipt</div>
													<?php } ?>

													<?php if ($item_returned !== 'false') { ?>
													<div class="draggable " style="position: absolute;  width:35%; left:<?= $positions[$item_returned]->newleft; ?>; top:<?= $positions[$item_returned]->newtop; ?>;" data-left="<?= $positions[$item_returned]->newleft; ?>" data-top="<?= $positions[$item_returned]->newtop; ?>" id="item_returned">

													<?php echo lang('common_items_returned', '', array(), TRUE); ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5
																		
														</div>
													
					
													</div>
													<?php } ?>

													<?php if ($payments !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$payments]->newleft; ?>; top:<?= $positions[$payments]->newtop; ?>;" data-left="<?= $positions[$payments]->newleft; ?>" data-top="<?= $positions[$payments]->newtop; ?>" id="payments">payments</div>
													<?php } ?>

													<?php if ($giftcard_balance !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$giftcard_balance]->newleft; ?>; top:<?= $positions[$giftcard_balance]->newtop; ?>;" data-left="<?= $positions[$giftcard_balance]->newleft; ?>" data-top="<?= $positions[$giftcard_balance]->newtop; ?>" id="giftcard_balance">giftcard balance</div>
													<?php } ?>

													<?php if ($ebt_balance !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$ebt_balance]->newleft; ?>; top:<?= $positions[$ebt_balance]->newtop; ?>;" data-left="<?= $positions[$ebt_balance]->newleft; ?>" data-top="<?= $positions[$ebt_balance]->newtop; ?>" id="ebt_balance">ebt balance</div>
													<?php } ?>

													<?php if ($customer_balance_for_sale !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$customer_balance_for_sale]->newleft; ?>; top:<?= $positions[$customer_balance_for_sale]->newtop; ?>;" data-left="<?= $positions[$customer_balance_for_sale]->newleft; ?>" data-top="<?= $positions[$customer_balance_for_sale]->newtop; ?>" id="customer_balance_for_sale">customer balance for sale</div>
													<?php } ?>

													<?php if ($sales_until_discount !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$sales_until_discount]->newleft; ?>; top:<?= $positions[$sales_until_discount]->newtop; ?>;" data-left="<?= $positions[$sales_until_discount]->newleft; ?>" data-top="<?= $positions[$sales_until_discount]->newtop; ?>" id="sales_until_discount">sales until discount</div>
													<?php } ?>

													<?php if ($ref_no !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$ref_no]->newleft; ?>; top:<?= $positions[$ref_no]->newtop; ?>;" data-left="<?= $positions[$ref_no]->newleft; ?>" data-top="<?= $positions[$ref_no]->newtop; ?>" id="ref_no">ref no</div>
													<?php } ?>

													<?php if ($auth_code !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$auth_code]->newleft; ?>; top:<?= $positions[$auth_code]->newtop; ?>;" data-left="<?= $positions[$auth_code]->newleft; ?>" data-top="<?= $positions[$auth_code]->newtop; ?>" id="auth_code">auth code</div>
													<?php } ?>

													<?php if ($taxable_subtotal !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$taxable_subtotal]->newleft; ?>; top:<?= $positions[$taxable_subtotal]->newtop; ?>;" data-left="<?= $positions[$taxable_subtotal]->newleft; ?>" data-top="<?= $positions[$taxable_subtotal]->newtop; ?>" id="taxable_subtotal">taxable subtotal</div>
													<?php } ?>

													<?php if ($taxable_summary !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$taxable_summary]->newleft; ?>; top:<?= $positions[$taxable_summary]->newtop; ?>;" data-left="<?= $positions[$taxable_summary]->newleft; ?>" data-top="<?= $positions[$taxable_summary]->newtop; ?>" id="taxable_summary">taxable summary</div>
													<?php } ?>

													<?php if ($non_taxable_subtotal !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$non_taxable_subtotal]->newleft; ?>; top:<?= $positions[$non_taxable_subtotal]->newtop; ?>;" data-left="<?= $positions[$non_taxable_subtotal]->newleft; ?>" data-top="<?= $positions[$non_taxable_subtotal]->newtop; ?>" id="non_taxable_subtotal">non taxable subtotal</div>
													<?php } ?>

													<?php if ($amount_change !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$amount_change]->newleft; ?>; top:<?= $positions[$amount_change]->newtop; ?>;" data-left="<?= $positions[$amount_change]->newleft; ?>" data-top="<?= $positions[$amount_change]->newtop; ?>" id="amount_change">amount change</div>
													<?php } ?>

													<?php if ($amount_discount !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$amount_discount]->newleft; ?>; top:<?= $positions[$amount_discount]->newtop; ?>;" data-left="<?= $positions[$amount_discount]->newleft; ?>" data-top="<?= $positions[$amount_discount]->newtop; ?>" id="amount_discount">amount discount</div>
													<?php } ?>

													<?php if ($coupons !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$coupons]->newleft; ?>; top:<?= $positions[$coupons]->newtop; ?>;" data-left="<?= $positions[$coupons]->newleft; ?>" data-top="<?= $positions[$coupons]->newtop; ?>" id="coupons">coupons</div>
													<?php } ?>

													<?php if ($announcement !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$announcement]->newleft; ?>; top:<?= $positions[$announcement]->newtop; ?>;" data-left="<?= $positions[$announcement]->newleft; ?>" data-top="<?= $positions[$announcement]->newtop; ?>" id="announcement">announcement</div>
													<?php } ?>

													<?php if ($signature !== 'false') { ?>
													<div class="draggable" style="position: absolute; width:20%; text-wrap:nowrap; left:<?= $positions[$signature]->newleft; ?>; top:<?= $positions[$signature]->newtop; ?>;" data-left="<?= $positions[$signature]->newleft; ?>" data-top="<?= $positions[$signature]->newtop; ?>" id="signature">signature</div>
													<?php } 


										



										endif;
										?>
									</div>
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

		let element = document.getElementById('dropZone');

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
	ClassicEditor
		.create(document.querySelector('#kt_docs_ckeditor_classicddd'))
		.then(editor => {
			console.log(editor.getData());
			$('textarea[name="custom_text"]').val(editor.getData());

		})
		.catch(error => {
			console.error(error);
		});
	$(document).ready(function() {
		$('#papersize').change(function() {
			if ($(this).val() === 'custom') {
				$('.customSizeInputs').show();
			} else {
				$('.customSizeInputs').hide();
			}
		});
	});


	$(function() {
		$(".draggable").draggable({
			revert: "invalid",
			containment: "document", // Limit movement within the specified boundary.
			start: function(event, ui) {
				$(this).draggable('option', 'revert', 'invalid');
				$(this).css({
					'border': '5px dotted black'
				});
			},
			stop: function(event, ui) {
				$(this).css({
					'border': 'none'
				});
			}
		});
		$(".resize").draggable({
			revert: "invalid",
			containment: "document", // Limit movement within the specified boundary.
			start: function(event, ui) {
				$(this).draggable('option', 'revert', 'invalid');
				$(this).css({
					'border': '5px dotted black'
				});
			},
			stop: function(event, ui) {
				$(this).css({
					'border': 'none'
				});
			}
		}).resizable({
			stop: function(event, ui) {
				$(this).attr('data-current_width', ui.size.width);
				$(this).attr('data-current_height', ui.size.height);
			}
		});

		$("#dropZone").droppable({
			accept: ".draggable , .resize",
			drop: function(event, ui) {


				var droppedRelativeLeft = ui.offset.left - $(this).offset().left;
				var droppedRelativeTop = ui.offset.top - $(this).offset().top;
				var width = $(this).data('current_width');
				var height = $(this).data('current_height');
				// Append the dragged item to the drop zone
				ui.draggable.appendTo(this).css({
					top: droppedRelativeTop + 'px',
					left: droppedRelativeLeft + 'px',
					position: 'absolute',
					width: width,
					height: height,
				});
				ui.draggable.appendTo(this).attr('data-left', droppedRelativeLeft + 'px');
				ui.draggable.appendTo(this).attr('data-top', droppedRelativeTop + 'px');

			}
		});


		$("#items-drag").droppable({
			accept: ".draggable , .resize",


			drop: function(event, ui) {
				var width = $(this).data('current_width');
				var height = $(this).data('current_height');
				// Append the dragged item back to the items container and reset its position
				ui.draggable.appendTo(this).css({
					top: '',
					left: '',
					position: 'relative',
					width: width,
					height: height,
				});
			}
		});


	});

	$(document).on("mouseup", ".draggable", function() {

		var elem = $(this),
			id = elem.attr('id'),
			desc = elem.attr('data-desc'),
			pos = elem.position();
		elem.attr('data-left', pos.left + 'px');
		elem.attr('data-top', pos.top + 'px');
		console.log('Left: ' + pos.left + '; Top:' + pos.top);

	});

	function save() {
		pos = [];
		$("#dropZone .draggable").each(function() {
			console.log("here");
			var elem = $(this),
				id = elem.attr('id');
			newleft = (elem.attr('data-left')) ? elem.attr('data-left') : '0px';
			newtop = (elem.attr('data-top')) ? elem.attr('data-top') : '0px';
			newwidth = '0px';
			newheight = '0px';
			pos.push({
				'id': id,
				'newleft': newleft,
				'newtop': newtop,
				'newwidth': newwidth,
				'newheight': newheight
			})
		})
		$("#dropZone .resize").each(function() {
			console.log("here");
			var elem = $(this),
				id = elem.attr('id');
			newleft = (elem.attr('data-left')) ? elem.attr('data-left') : '0px';
			newtop = (elem.attr('data-top')) ? elem.attr('data-top') : '0px';
			newwidth = (elem.attr('data-current_width')) ? elem.attr('data-current_width') : '0px';
			newheight = (elem.attr('data-current_height')) ? elem.attr('data-current_height') : '0px';
			pos.push({
				'id': id,
				'newleft': newleft,
				'newtop': newtop,
				'newwidth': newwidth,
				'newheight': newheight
			})
		})

		$.ajax({
			type: 'POST',
			url: '<?php echo site_url("Receipt/update_receipt"); ?>',
			data: {
				'tables': JSON.stringify(pos),
				'receipt': '<?php echo $receipt['id']; ?>'
			},
			success: function(result) {
				show_feedback('success', <?php echo json_encode(lang('common_success')); ?>, <?php echo json_encode(lang('common_success')); ?>);
			}
		})

	}

	$('#filterForm').on('submit', function(e) {
		//     e.preventDefault();

		//     var formData = new FormData(this); // 'this' refers to the form element
		// console.log(formData);
		// //AJAX request
		// $.ajax({
		// 	url: '<?php echo site_url("Receipt/update_receipt_detail"); ?>',
		// 	type: 'POST',
		// 	data: formData,
		// 	success: function(response) {
		// 		// Handle success
		// 		show_feedback('success', <?php echo json_encode(lang('common_success')); ?>, <?php echo json_encode(lang('common_success')); ?>);
		// 	},
		// 	error: function(xhr, status, error) {
		// 		// Handle errors
		// 		console.error('Form submission failed:', error);
		// 	}
		// });
	});
</script>

<?php $this->load->view("partial/footer"); ?>