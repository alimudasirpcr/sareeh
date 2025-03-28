<style>
#category_item_selection_wrapper_new {
    height: calc(100vh - 45vh);
    overflow-y: scroll;
}

#reloadMessage {
    display: none;
    /* Add more styling as needed */
}
</style>


<script id="item-template" type="text/x-handlebars-template">

<thead>
                            <tr
                                class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 bg-light-primary pos-bg-dark">
                                <th class=" py-1 min-w-50px text-center  text-light "><a href="javascript:void(0);"
                                        id="sale_details_expand_collapse" class="expand">+</a><span id="total_items"
                                        class=" symbol-badge badge    badge-circle badge-warning  ">{{no_of_items}}</span></th>
                                <th class=" py-1 item_sort_able  text-light item_name_heading w-20 ">Item Name</th>
                                <th class=" py-1 item_sort_able min-w-50px text-center text-light sales_price ">Price
                                </th>
                                <th class=" py-1 item_sort_able sales_quantity  text-light"><span
                                        class=" symbol-badge badge   badge-circle badge-warning  "
                                        id="total_items_qty">{{qty}}</span>Quantity</th>
                                <th class=" py-1 item_sort_able min-w-50px text-center sales_total text-light">Total
                                </th>
                            </tr>
                        </thead>


					{{#each this}}
						<tbody  class="fw-bold text-gray-600" data-line="{{@index}}">
                   
							<tr class="register-item-details">


								<td class="text-center  fs-6">



									<span
										class="toggle_rows btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"
										style="position:relative">
										<!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
										<span class="svg-icon svg-icon-3 m-0 toggle-off">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
												xmlns="http://www.w3.org/2000/svg">
												<rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1"
													transform="rotate(-90 11 18)" fill="currentColor"></rect>
												<rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>
											</svg>
										</span>
										<!--end::Svg Icon-->
										<!--begin::Svg Icon | path: icons/duotune/arrows/arr089.svg-->
										<span class="svg-icon svg-icon-3 m-0 toggle-on">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
												xmlns="http://www.w3.org/2000/svg">
												<rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</span> &nbsp;
								</td>

								<td class="fs-6">

									<a tabindex="-1"
										href="<?php echo base_url(); ?>/home/view_item_modal/6?redirect=sales"
										data-target="#kt_drawer_general" data-target-title="View Item"
										data-target-width="xl" class="register-item-name text-gray-800 text-hover-primary "
										data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse"
										data-bs-placement="top" title="Box Master Sandwich - Original">{{name}}</a>
								</td>
								<td class="text-center fs-6">
									<a href="#" id="price_{{@index}}" class="xeditable xeditable-price editable editable-click"
										data-validate-number="true" data-type="text" data-value="{{price}}" data-pk="1"
										data-name="unit_price" data-url="<?php echo base_url(); ?>/sales/edit_item/0"
										data-title="Price">{{currency}} {{price}}</a>


								</td>
								<td class="text-center fs-6">
								<button type="button"  onclick="inc_de_qty('{{@index}}', -1)" class="btn w-25px h-25px  btn-icon rounded-circle btn-light"><i class="bi bi-dash fs-1"></i></button> 
									<a href="#" id="quantity_{{@index}}" class="xeditable edit-quantity editable editable-click"
										data-type="text" data-validate-number="true" data-pk="{{@index}}" data-name="quantity"
										data-url="<?php echo base_url(); ?>/sales/edit_item/{{@index}}"
										data-title="Quantity">
									
										 {{qty}}
		
										</a><button type="button" onclick="inc_de_qty('{{@index}}', 1)" class="btn w-25px h-25px  btn-icon rounded-circle btn-light"> <i class="bi bi-plus fs-1"></i></button>
								</td>

								<td class="text-center fs-6" style="padding-right:10px">

									<a href="#" id="total_{{@index}}" class="xeditable editable editable-click" data-type="text"
										data-validate-number="true" data-pk="1" data-name="total" data-value="{{multiply price qty}}"
										data-url="<?php echo base_url(); ?>/sales/edit_line_total/{{@index}}"
										data-title="Total">{{currency}} {{multiply price qty}}</a>


									<a href="<?php echo base_url(); ?>/sales/delete_item/{{@index}}"
										class="delete-item pull-right" tabindex="-1" data-id="{{@index}}"><i
											class="icon ion-android-cancel"></i></a>

								</td>
							</tr>
							<tr class="register-item-bottom collapse">
								<td>&nbsp;</td>
								<td colspan="5">



									<div class="row">
										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">Discount Percentage</div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"> <a
													href="#" id="discount_0" class="xeditable editable editable-click"
													data-type="text" data-validate-number="true" data-pk="1"
													data-name="discount" data-value="0"
													data-url="<?php echo base_url(); ?>/sales/edit_item/0"
													data-title="Discount Percentage">0%</a>

											</div>
										</div>


										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">Supplier</div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost"><a
													href="#" id="supplier_0" data-name="supplier" data-type="select"
													data-pk="1"
													data-url="<?php echo base_url(); ?>/sales/edit_item_supplier/0"
													data-title="Supplier" class="editable editable-click">Cafe Store inc</a>
											</div>
										</div>

									


										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">Description</div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
												None </div>
										</div>

										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">Category</div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">FOR
												ONE</div>
										</div>

										<!-- Serial Number if exists -->

										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">
												SKU/UPC/EAN/ISBN </div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
												None </div>
										</div>
										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">Stock</div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">0
											</div>
										</div>



										<div class="col-md-3 mt-3">
											<div class="text-gray-800 fs-7">Tax</div>
											<div class="text-muted fs-7 fw-bold" data-kt-table-widget-4="template_cost">
												<a href="<?php echo base_url(); ?>/sales/edit_taxes_line/0" class=""
													id="edit_taxes" data-target="#kt_drawer_general"
													data-target-title="Edit Taxes" data-target-width="lg">Edit Taxes</a>
											</div>
										</div>

									</div>
								</td>
							</tr>
						
						</tbody>
						{{/each}}
</script>



<script id="sale-template" type="text/x-handlebars-template">



                    <!-- ./amount block -->
                    <div class="d-flex flex-column content-justify-center w-100 cart_summary">
                        <!--begin::Label-->
                        <div class="d-flex fs-6 fw-semibold align-items-center ">
                    

                            <!--begin::Label-->
                            <div class="flex-grow-1 me-4">  Discount ({{currency}})<i class="fonticon-content-marketing" id="discount_details_reload"></i>:  </div>
                            <!--end::Label-->

                            <!--begin::Stats-->
                            <div class="fw-bolder text-gray-700 text-xxl-end" id="total_discount">0</div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Label-->

                   

                  

                    <!--begin::Label-->
                    <div class="d-flex fs-6 fw-semibold align-items-center my-3">
                        

                        <!--begin::Label-->
                        <div class=" flex-grow-1 me-4">Sub Total ({{currency}}):</div>
                        <!--end::Label-->

                        <!--begin::Stats-->
                        <div class="fw-bolder text-gray-700 text-xxl-end"><a href="#" id="subtotal" class="xeditable xeditable-price editable editable-click"
                            data-validate-number="true" data-type="text" data-value="{{subtotal}}" data-pk="1" data-name="subtotal"
                            data-url="<?php echo base_url(); ?>/sales/edit_subtotal" data-title="Sub Total"> {{subtotal}}</a></div>
                        <!--end::Stats-->                    
                    </div>
                    <!--end::Label-->

                    <!--begin::Label-->
                    <div class="d-flex fs-6 fw-semibold align-items-center my-3">
                        

                        <!--begin::Label-->
                        <div class=" flex-grow-1 me-4"> Tax ({{currency}}):</div>
                        <!--end::Label-->

                        <!--begin::Stats-->
                        <div class="fw-bolder text-gray-700 text-xxl-end">{{tax}}</div>
                        <!--end::Stats-->                    
                    </div>
                    <!--end::Label-->

                    <!--begin::Label-->
                    <div class="d-flex fs-6 fw-semibold align-items-center my-3">
                        

                        <!--begin::Label-->
                        <div class=" flex-grow-1 me-4">     Total ({{currency}}):</div>
                        <!--end::Label-->

                        <!--begin::Stats-->
                        <div class="fw-bolder text-gray-700 text-xxl-end"> {{total_amount}}</div>
                        <!--end::Stats-->                    
                    </div>
                    <!--end::Label-->
                    
                    <!--begin::Label-->
                    <div class="d-flex fs-6 fw-semibold align-items-center my-3">
                        

                        <!--begin::Label-->
                        <div class=" flex-grow-1 me-4">      Amount Due ({{currency}}):</div>
                        <!--end::Label-->

                        <!--begin::Stats-->
                        <div class="fw-bolder text-gray-700 text-xxl-end">  {{amount_due}}</div>
                        <!--end::Stats-->                    
                    </div>
                    <!--end::Label-->

    
                    </div>
          

                <div class="d-none" id="list_tax">
                    <div class="list-group-item  border border-dashed rounded min-w-125px h-80px py-3 px-4 me-3  mb-3">
                        <div class="fw-semibold fs-6 text-dark-400">
                            <a href="<?php echo base_url(); ?>/sales/delete_tax/5%25%20VAT%20Rate%201"
                                class="delete-tax remove"><i class="icon ion-android-cancel"></i></a>
                            5% VAT Rate 1:
                        </div>
                        <div class="fs-1 fw-bold counted">
                            0 </div>
                    </div>



                </div>
             
                 


                <!-- Add Payment -->
                <div class=" add-payment border border-light border-dashed rounded min-w-125px py-3 px-4">
                    <!-- Check Work Order Permission -->
                    <div class="row">
                        <div id="create_invoice_holder" class="create_invoice_holder col-md-6 hidden">
                            <div class="text-left">
                                <label for="create_invoice" class="control-label wide">Create Invoice</label> <input
                                    type="checkbox" name="create_invoice" value="1" id="create_invoice">
                                <label for="create_invoice"
                                    style="padding-left: 10px; margin-top:0px;"><span></span></label>
                            </div>
                        </div>
                    </div>
                    <form action="<?php echo base_url(); ?>/sales/add_payment" id="add_payment_form"
                        autocomplete="off" method="post" accept-charset="utf-8">

                        <div class="input-group add-payment-form">
                            <select name="payment_type" id="payment_types" class="hidden">
                                <option value="Cash" selected="selected">Cash</option>
                                <option value="Check">Check</option>
                                <option value="Debit">Debit</option>
                                <option value="Store Account">Store Account</option>
                                <option value="Thawani">Thawani</option>
                                <option value="Mobile Transfer Bank Muscut">Mobile Transfer Bank Muscut</option>
                            </select>
                            <div class="input-group-text register-mode sale-mode dropup">


                                <a tabindex="-1" href="#" class="none active text-light  text-hover-primary"
                                    title="Sales Sale" id="select-mode-3" data-target="#" data-toggle="dropdown"
                                    aria-haspopup="true" role="button" aria-expanded="false"><i
                                        class="fa fa-money-bill"></i>
                                    Cash </a>



                                <ul class="dropdown-menu sales-dropdown">


                                    <li><a tabindex="-1" href="#"
                                            class=" select-payment pt-2 text-gray-800 text-hover-primary active"
                                            data-payment="Cash"><i class="fa fa-money-bill"></i>
                                            Cash </a></li>
                                    <li><a tabindex="-1" href="#"
                                            class=" select-payment pt-2 text-gray-800 text-hover-primary "
                                            data-payment="Check"><i class="fa fa-money-bill"></i>
                                            Check </a></li>
                                    <li><a tabindex="-1" href="#"
                                            class=" select-payment pt-2 text-gray-800 text-hover-primary "
                                            data-payment="Debit"><i class="fa fa-money-bill"></i>
                                            Debit </a></li>
                                    <li><a tabindex="-1" href="#"
                                            class=" select-payment pt-2 text-gray-800 text-hover-primary "
                                            data-payment="Store Account"><i class="fa fa-money-bill"></i>
                                            Store Account </a></li>
                                    <li><a tabindex="-1" href="#"
                                            class=" select-payment pt-2 text-gray-800 text-hover-primary "
                                            data-payment="Thawani"><i class="fa fa-money-bill"></i>
                                            Thawani </a></li>
                                    <li><a tabindex="-1" href="#"
                                            class=" select-payment pt-2 text-gray-800 text-hover-primary "
                                            data-payment="Mobile Transfer Bank Muscut"><i class="fa fa-money-bill"></i>
                                            Mobile Transfer Bank Muscut </a></li>

                                </ul>
                            </div>
                            <input type="input" name="amount_tendered" value="2" id="amount_tendered"
                                class="form-control" data-title="Payment Amount" placeholder="Enter Cash Amount">
                            <span class="input-group-text">
                                <a href="#" class="" id="add_payment_button">Add Payment</a>
                                <a href="#" class="hidden" id="finish_sale_alternate_button">Complete Sale</a>
                            </span>

                            <!-- <div class="form-group">
					<label for="exampleInputPassword1"></label>
					<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
					</div> -->
                        </div>

                    </form>
                </div>

</script>
<?php require_once('offline_common.js.php'); ?>
<script>
function amount_tendered_input_changed() {
    if ($("#payment_types").val() == <?php echo json_encode(lang('giftcard')); ?>) {
        $('#finish_sale_alternate_button').removeClass('hidden');
        $('#add_payment_button').addClass('hidden');
    } else if ($("#payment_types").val() == <?php echo json_encode(lang('points')); ?>) {
        $('#finish_sale_alternate_button').addClass('hidden');
        $('#add_payment_button').removeClass('hidden');
    } else {
        if ((<?php echo $amount_due; ?> >= 0 && $('#amount_tendered').val() >= <?php echo $amount_due; ?>) || (
                <?php echo $amount_due; ?> < 0 && $('#amount_tendered').val() <= <?php echo $amount_due; ?>)) {
            $('#finish_sale_alternate_button').removeClass('hidden');
            $('#add_payment_button').addClass('hidden');
        } else {
            $('#finish_sale_alternate_button').addClass('hidden');
            $('#add_payment_button').removeClass('hidden');
        }
    }

}
</script>
<?php $this->load->helper('demo'); ?>




<!-- col-lg-4 @start of right Column -->

<div id="discountbox_modal_reload_data" style="display:none">
	
	<div class="card border-0 shadow-none rounded-0 w-100">
		<!--begin::Card header-->
		<div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4" id="kt_app_layout_builder_header" style="background-image:url('<?php echo base_url() ?>assets/css_good/media/misc/pattern-4.jpg')">

			<!--begin::Card title-->
			<h3 class="card-title fs-3 fw-bold text-white flex-column m-0" >
			<?= lang('discount_details') ?>
			</h3>
			<!--end::Card title-->

			<!--begin::Card toolbar-->
			<div class="card-toolbar">
				<button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1" id="kt_app_layout_builder_close">
					x </button>
			</div>
			<!--end::Card toolbar-->
		</div>
		<!--end::Card header-->
		<!--begin::Card body-->
		<div class="card-body position-relative" id="kt_app_layout_builder_body">
			<!--begin::Content-->
			<div id="kt_app_settings_content" class="position-relative gotodrawer scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_app_layout_builder_body" data-kt-scroll-dependencies="#kt_app_layout_builder_header, #kt_app_layout_builder_footer" data-kt-scroll-offset="5px">

			
					<div class="card-body p-0" >
						<div class="row p-5">

								<?php if (!$this->config->item('disable_discount_by_percentage')) { ?>
								<div class="mb-10">
									<label for="exampleFormControlInput1" class=" form-label"><?php echo lang('discount') . ' %: '; ?></label>
									<input type="number" id="discount_all_percent" value="<?php echo isset($discount_all_percent) &&  $discount_all_percent > 0 ?  to_quantity($discount_all_percent) : '' ?>" class="form-control form-control-solid" />
								</div>
								<?php } ?>

								<?php if (!$this->config->item('disabled_fixed_discounts')) { ?>
								<div class="mb-10">
									<label for="exampleFormControlInput1" class=" form-label"><?php echo lang('discount_fixed') . ': '; ?> 	<?php
											$symbol = "";
											if (isset($discount_all_fixed) &&  $discount_all_fixed) {
												$symbol = ($this->config->item('currency_symbol') ? $this->config->item('currency_symbol') : '$');
											}
											?>
											<span id="TEST"><?php echo $symbol; ?></span></label>
									<input type="number"  id="discount_all_flat" value="<?php echo isset($discount_all_fixed) &&  $discount_all_fixed ? $discount_all_fixed : ''; ?>" class="form-control form-control-solid" />
								</div>
								<?php } ?>


								<?php if ($has_discount) { ?>
								<div class="mb-10">
									<label for="exampleFormControlInput1" class=" form-label"><?php echo lang('reason'); ?></label>
									<textarea   id="discount_reason" class="form-control form-control-solid" ><?php echo  isset($discount_reason) &&  $discount_reason ? $discount_reason : ''; ?></textarea>
								</div>
								<?php } ?>

								<button type="button" class="btn btn-primary w-100px update_discount_details"  ><?= lang('update') ?></button>

						</div>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="tab-content" id="myTabContent">

    <div class="register-box register-right">

        <!-- Sale Top Buttons  -->


        <!-- If customer is added to the sale -->
        <?php if (isset($customer)) { ?>
        <div class="d-flex flex-wrap flex-sm-nowrap mb-3 my-4">
            <!--begin: Pic-->
            <div class="me-7 mb-4 w-50px">
                <div class="symbol symbol-50px  symbol-fixed position-relative">
                    <img src="<?php echo $avatar; ?>"
                        onerror="this.onerror=null; this.src='<?php echo base_url() ?>assets/css_good/media/avatars/blank.png';"
                        alt="image">

                    <?php
							if ($this->config->item('enable_customer_quick_add')) {
							?>
                    <?php echo anchor("customers/quick_modal/$customer_id/1", '<i class="ion-ios-compose-outline"></i>',  array('id' => 'edit_customer', 'data-target' => "#kt_drawer_general", 'data-target-title' =>lang('new_customer'), 'data-target-width' =>'xl', 'class' => 'position-absolute translate-middle bottom-0 start-100 mb-6 rounded-circle bg-light text-center border border-2 border-body h-25px w-25px p-1', 'title' => lang('update_customer'))) . ''; ?>

                    <?php
							} else {
							?>
                    <?php echo anchor("customers/view/$customer_id/1", '<i class="ion-ios-compose-outline"></i>',  array('id' => 'edit_customer', 'class' => 'position-absolute translate-middle bottom-0 start-100 mb-6 rounded-circle bg-light text-center border border-2 border-body h-25px w-25px p-1', 'title' => lang('update_customer'))) . ''; ?>
                    <?php
							}
							?>
                </div>
            </div>
            <!--end::Pic-->
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::User-->
                    <div class="d-flex flex-column w-25  ">
                        <!--begin::Name-->
                        <div class="d-flex align-items-center mb-2">
                            <a href="#"
                                class="text-gray-900 text-hover-primary fs-5 fw-bold me-1"><?php if (!$this->config->item('hide_customer_recent_sales') && isset($customer)) { ?>
                                <a href="<?php echo site_url('sales/customer_recent_sales/' . $customer_id); ?>"
                                    data-toggle="modal" data-target="#myModal"
                                    class="name"><?php echo character_limiter(H($customer), 30); ?></a>
                                <?php } else if (isset($customer)) { ?>
                                <a href="<?php echo site_url('customers/view/' . $customer_id . '/1'); ?>"
                                    class="name"><?php echo character_limiter(H($customer), 30); ?></a>
                                <?php } else { ?>
                                <?php echo character_limiter(H($customer), 30); ?>
                                <?php } ?></a>

                        </div>
                        <!--end::Name-->
                        <!--begin::Info-->
                        <div class="d-flex flex-wrap fw-semibold fs-8 mb-4 pe-2">

                            <?php if (!empty($customer_email)) { ?>

                            <a href="mailto:<?php echo $customer_email; ?>"
                                class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                <span class="svg-icon svg-icon-4 me-1">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon--><?php echo character_limiter(H($customer_email), 25); ?>
                            </a>
                            <?php } ?>
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->
                    <!--begin::Actions-->
                    <?php //  dd($this->cC->sale_id); 
							?>
                    <div class="d-flex my-4">
                        <div id="popover-content" class="d-none">
                            <!--begin::ShareArea-->
                            <div class="d-flex flex-wrap justify-content-around fw-semibold fs-6 mb-4 pe-2">


                                <div class="symbol round w-50px h-50px text-center p-4  bg-success me-2">
                                    <i class="fa-solid fa-square-phone fs-2rem text-light"></i>
                                </div>

                                <?php if (!empty($customer_email)) { ?>

                                <div class="symbol round w-50px h-50px text-center p-4  bg-danger me-2">

                                    <i class="fa-regular fa-envelope fs-2rem text-light <?php echo ((bool) $email_receipt || (bool) $auto_email_receipt) ? 'checked' : ''; ?> "
                                        id="toggle_email_receipt"></i>
                                </div>
                                <?php }  ?>

                                <?php if ($this->Location->get_info_for_key('twilio_sms_from') && $this->Location->get_info_for_key('twilio_token') && $this->Location->get_info_for_key('twilio_sid')) { ?>
                                <?php if (!empty($customer_phone)) { ?>

                                <div class="symbol round w-50px h-50px text-center p-4  bg-warning me-2">
                                    <i class="fa-solid fa-comment-sms fs-2rem text-light <?php echo ((bool) $sms_receipt || (bool) $always_sms_receipt) ? 'checked' : ''; ?>"
                                        id="toggle_sms_receipt"></i>
                                </div>
                                <?php }
										} ?>



                            </div>





                            <!--End::ShareArea-->
                        </div>

                        <a onclick="event.preventDefault();" data-dismiss="true" data-placement="bottom"
                            data-toggle="popover" data-html="true" title="<?= lang('send_receipt_via') ?>" href="#"
                            class="btn btn-sm btn-light me-2 p-2" id="share-popover">

                            <i class="fa-solid fa-share"></i>
                            <!--end::Svg Icon-->
                            <!--begin::Indicator label-->
                            <span class="indicator-label"><?php echo lang('share') ?></span>
                            <!--end::Indicator label-->
                        </a>
                        <script>
                        $(function() {

                            $('#share-popover').popover({
                                container: 'body',
                                template: '<div class="popover fade bottom in bg-dark border-dark min-w-300px " role="tooltip"><div class="arrow" style="left: 25%;"></div><h3 class="popover-header"></h3><div class="popover-body">' +
                                    $('#popover-content').html() + '</div></div>',
                                content: function() {
                                    return $('#popover-content').html();
                                }
                            })


                        })
                        </script>
                        <?php if ($mode != 'store_account_payment' && $this->Employee->has_module_action_permission('deliveries', 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                        <a href="<?php echo site_url('sales/view_delivery_modal/') ?>"
                            class="btn btn-sm btn-light me-2 p-2 <?php echo (bool) $has_delivery ? 'checked' : ''; ?>"
                            id="open_delivery_modal" data-toggle="modal" data-target="#myModal">
                            <i class="ion-android-car"></i>
                            <?php echo lang('Delivery'); ?>
                        </a>
                        <?php } ?>
                        <a href="<?php echo site_url("sales/delete_customer");  ?>"
                            class="btn btn-sm btn-light me-2 p-2" id="delete_customer">

                            <i class="ion-close-circled text-danger"></i>
                            <!--end::Svg Icon-->
                            <!--begin::Indicator label-->
                            <span class="indicator-label"><?php echo lang('detach') ?></span>
                            <!--end::Indicator label-->
                        </a>


                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Title-->
                <!--begin::Stats-->
                <div class="d-flex flex-wrap flex-stack" style="margin-top:-20px">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-grow-1 ">
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap">

                            <div class="<?php echo $is_over_credit_limit ? 'text-danger' : 'text-success'; ?> balance">
                            </div>


                            <?php if ($this->config->item('customers_store_accounts') && isset($customer_balance)) { ?>
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded w-25 py-3 px-1 me-2  mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->

                                    <!--end::Svg Icon-->
                                    <div class="fs-6 fw-bold counted <?php echo $is_over_credit_limit ? 'text-danger' : 'text-success'; ?> balance"
                                        data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$"
                                        data-kt-initialized="1">
                                        <?php echo (isset($exchange_name) && $exchange_name ? (to_currency($customer_balance) . ' (' . (to_currency_as_exchange($cart, $customer_balance * $exchange_rate)) . ')') : to_currency($customer_balance)); ?>
                                    </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fw-semibold fs-8 text-gray-400"><?php echo lang('sales_balance') ?></div>
                                <!--end::Label-->
                            </div>
                            <?php } ?>
                            <!--end::Stat-->
                            <?php if (!$disable_loyalty) { ?>
                            <?php if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'simple' && isset($sales_until_discount)) { ?>
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded w-25 py-3 px-1 me-2  mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->

                                    <!--end::Svg Icon-->
                                    <div class="fs-6 fw-bold counted <?php echo $sales_until_discount > 0 ? 'text-danger' : 'text-success'; ?> sales_until_discount"
                                        data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$"
                                        data-kt-initialized="1">
                                        <?php echo   to_quantity($sales_until_discount) . ($sales_until_discount <= 0 && !$redeem ? ' ' . anchor('sales/redeem_discount', '<i class="ion-ios-compose-outline"></i>', array('id' => 'redeem_discount')) . '' : ($redeem ? ' ' . anchor('sales/unredeem_discount', '<i class="ion-ios-compose-outline"></i>', array('id' => 'unredeem_discount')) . '' : '')) ?>
                                    </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fw-semibold fs-8 text-gray-400"><?php echo lang('sales_until_discount') ?>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <?php } ?>
                            <?php if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced' && isset($points)) { ?>
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded w-25 py-3 px-1 me-2  mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->

                                    <!--end::Svg Icon-->
                                    <div class="fs-6 fw-bold counted <?php echo $points < 1 ? 'text-danger' : 'text-success'; ?> points"
                                        data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$"
                                        data-kt-initialized="1"><?php echo  to_quantity($points); ?></div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fw-semibold fs-8 text-gray-400"><?php echo lang('points') ?></div>
                                <!--end::Label-->
                            </div>
                            <?php } ?>
                            <!--end::Stat-->
                            <?php } ?>

                            <div
                                class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-2 w-45">
                                <!--begin::Icon-->


                                <!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/communication/com007.svg-->
                                <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z"
                                            fill="currentColor" />
                                        <path
                                            d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                    <!--begin::Content-->
                                    <div class="mb-3 mb-md-0 fw-semibold">
                                        <div class="fs-6 text-gray-700 pe-7">
                                            <?php if ($this->config->item('capture_internal_notes_during_sale')) { ?>


                                            <a href="#" id="internal_notes"
                                                class="xeditable-comment edit-internal_notes" data-type="text"
                                                data-validate-number="false" data-pk="1" data-name="internal_notes"
                                                data-url="<?php echo site_url("sales/set_internal_notes"); ?>"
                                                data-title="<?php echo lang('internal_notes') ?>"><?php echo  $customer_internal_notes; ?></a>


                                            <?php } ?>

                                        </div>
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                        </div>
                        <!--end::Stats-->



                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Info-->
        </div>
        <!-- Customer Badge when customer is added -->

        <div class="customer-action-buttons  btn-group btn-group-justified  d-flex justify-content-center mb-2">







            <?php
					echo form_checkbox(array(
						'name' => 'email_receipt',
						'id' => 'email_receipt',
						'value' => '1',
						'class'       => 'email_receipt_checkbox hidden',
						'checked' => (bool) $email_receipt
					));

					echo form_checkbox(array(
						'name' => 'sms_receipt',
						'id' => 'sms_receipt',
						'value' => '1',
						'class'       => 'sms_receipt_checkbox hidden',
						'checked' => (bool) $sms_receipt
					));

					echo form_checkbox(array(
						'name' => 'delivery',
						'id' => 'delivery',
						'value' => '1',
						'class' => 'delivery_checkbox hidden',
						'checked' => (bool) $has_delivery
					));

					?>




            <?php $btn_w = "w-100px";
			} else {  ?>

            <div class="customer-form d-flex flex-wrap">

                <!-- if the customer is not set , show customer adding form -->
                <?php echo form_open("sales/select_customer", array('id' => 'select_customer_form', 'autocomplete' => 'off', 'class' => 'form-inline w-100 mb-2')); ?>
                <div class="input-group contacts d-flex">
                    <span class="input-group-text">
                        <?php
								if ($this->config->item('enable_customer_quick_add')) {
								?>
                        <?php echo anchor("customers/quick_modal/-1/1", "<i class='ion-person-add'></i>", array('class' => 'none ', 'title' => lang('new_customer'), 'id' => 'new-customer', 'data-target' => "#kt_drawer_general", 'data-target-title' =>lang('new_customer'), 'data-target-width' =>'xl', 'tabindex' => '-1')); ?>
                        <?php
								} else {
								?>
                        <?php echo anchor("customers/view/-1/1", "<i class='ion-person-add'></i>", array('class' => 'none', 'title' => lang('new_customer'), 'id' => 'new-customer', 'tabindex' => '-1')); ?>
                        <?php
								}
								?>
                    </span>
                    <input type="text" id="customer" name="customer" class="add-customer-input keyboardLeft w-75"
                        data-title="<?php echo lang('customer_name'); ?>"
                        placeholder="<?php echo lang('sales_start_typing_customer_name') . ($this->config->item('require_customer_for_sale') ? ' (' . lang('required') . ')' : ''); ?>">
                </div>
                </form>




                <?php $btn_w = "";
				} ?>





            </div>


        </div>



        <div class="register-box register-items  ">


            <div class="register-items-holder itemboxnew">
                <?php

						$cart_count = 0;
						if ($mode != 'store_account_payment') { ?>


                <?php if ($pagination) { ?>
                <div class="page_pagination pagination-top hidden-print  text-center" id="pagination_top">
                    <?php echo $pagination; ?>
                </div>
                <?php } ?>

                <?php if ($this->config->item('allow_drag_drop_sale') && !$this->agent->is_mobile() && !$this->agent->is_tablet()) {  ?>

                <style>
                #register tbody {
                    cursor: move;
                }

                #register th.item_sort_able {
                    cursor: pointer;
                }

                #grid-loader2.spinner>div {
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
                <table id="register"
                    class="table table-striped align-middle table-row-dashed fs-6 gy-3 dataTable no-footer">
                    <?php

								if ($this->config->item('allow_drag_drop_sale') == 1 && !$this->agent->is_mobile() && !$this->agent->is_tablet()) {
									$cart_items = $cart->get_list_sort_by_receipt_sort_order();
								}
								$total_items = 0;
								$total_quantity = 0;
								if (count($cart_items) > 0) {
									$total_items = count($cart_items);
									foreach ($cart_items as $line => $item) {
										$total_quantity = $total_quantity + $item->quantity;
									}
								}

								?>
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 bg-light-primary">
                            <th class="min-w-50px text-center"><a href="javascript:void(0);"
                                    id="sale_details_expand_collapse"
                                    class="expand">-</a><?php if ($total_items > 0) : ?><span
                                    class=" symbol-badge badge   badge-circle badge-warning  "><?= $total_items; ?></span><?php endif; ?>
                            </th>
                            <th
                                class="item_sort_able  text-dark item_name_heading <?php echo $this->cart->sort_column && $this->cart->sort_column == 'name' ? ($this->cart->sort_type == 'asc' ? "ion-arrow-down-b" : "ion-arrow-up-b") : ""; ?>">
                                <?php echo lang('sales_item_name'); ?></th>
                            <th
                                class="item_sort_able min-w-150px text-center text-dark sales_price <?php echo $this->cart->sort_column && $this->cart->sort_column == 'unit_price' ? ($this->cart->sort_type == 'asc' ? "ion-arrow-down-b" : "ion-arrow-up-b") : ""; ?>">
                                <?php echo lang('price'); ?></th>
                            <th
                                class="item_sort_able sales_quantity  text-dark<?php echo $this->cart->sort_column && $this->cart->sort_column == 'quantity' ? ($this->cart->sort_type == 'asc' ? "ion-arrow-down-b" : "ion-arrow-up-b") : ""; ?>">
                                <?php echo lang('quantity'); ?><?php if ($total_quantity > 0) : ?><span
                                    class=" symbol-badge badge   badge-circle badge-warning  "><?= $total_quantity; ?></span><?php endif; ?>
                            </th>
                            <th
                                class="item_sort_able min-w-150px text-center sales_total text-dark<?php echo $this->cart->sort_column && $this->cart->sort_column == 'total' ? ($this->cart->sort_type == 'asc' ? "ion-arrow-down-b" : "ion-arrow-up-b") : ""; ?>">
                                <?php echo lang('total'); ?></th>
                        </tr>
                    </thead>

		
			




                </table>

            </div>

            <?php }  ?>
            <!-- End of Store Account Payment Mode -->

            <!-- /.Register Items first pan end here -->
            <div class="register-box register-summary paper-cut  pos_footer d-flex flex-wrap bg-light-100" id="pos_footer_mob">




            </div>


            <!-- End of pos footer -->
        </div>


















        <div class="modal fade look-up-receipt" id="look-up-receipt" role="dialog" aria-labelledby="lookUpReceipt"
            aria-hidden="true">
            <div class="modal-dialog customer-recent-sales">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label=<?php echo json_encode(lang('close')); ?>><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="lookUpReceipt"><?php echo lang('lookup_receipt') ?></h4>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open("sales/receipt_validate", array('class' => 'look-up-receipt-form', 'autocomplete' => 'off')); ?>
                        <span class="text-danger text-center has-error look-up-receipt-error"></span>
                        <input type="text" class="form-control text-center" name="sale_id" id="sale_id"
                            placeholder="<?php echo lang('sale_id') ?>">
                        <?php echo form_submit('submit_look_up_receipt_form', lang("lookup_receipt"), 'class="btn btn-block btn-primary"'); ?>
                        <?php echo form_close(); ?>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <div class="modal fade look-up-receipt" id="choose_var" role="dialog" aria-labelledby="lookUpReceipt"
            aria-hidden="true">
            <div class="modal-dialog customer-recent-sales">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label=<?php echo json_encode(lang('close')); ?>><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title choose_var_title" id="lookUpReceipt"><?php
																					if (isset($vair_type)) {
																						echo $vair_type[0]['name'];
																					} else {
																						echo lang('variation');
																					} ?></h4>
                    </div>
                    <div class="modal-body clearfix">

                        <?php

						echo "<div class='placeholder_attribute_vals pull-left'>";
						if (isset($show_model)) {
							foreach ($show_model as $key => $variation) {
								echo "<a href='javascript:fetch_attr_values(" . htmlspecialchars(json_encode(trim($key)), ENT_QUOTES) . ");' class='popup_button' style='margin:5px;' id='attri_" . htmlspecialchars(trim($key), ENT_QUOTES) . "'>" . trim($key) . "</a>";
							}
						}
						echo "</div>";

						?>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <div class="modal fade look-up-receipt" id="choose_modifiers" role="dialog" aria-labelledby="lookUpReceipt"
            aria-hidden="true">
            <div class="modal-dialog customer-recent-sales">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label=<?php echo json_encode(lang('close')); ?>><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="lookUpReceipt"><?php echo lang('modifiers'); ?></h4>
                    </div>
                    <div class="modal-body clearfix">

                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->

        <div class="modal fade look-up-receipt" id="choose_quick_cash" role="dialog" aria-labelledby="lookUpReceipt"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label=<?php echo json_encode(lang('close')); ?>><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo lang('amount_tendered'); ?>&nbsp;<span
                                id="amount_holder"></span>
                        </h4>
                    </div>
                    <div class="modal-body clearfix">
                        <?php $currency_symbol = $this->config->item('currency_symbol'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-text"><?php echo $currency_symbol; ?></div>
                                        <input type="text" class="form-control" id="custom_amount" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="quick_cash_holder">

                        </div>


                    </div>

                    <div class="modal-footer">
                        <button data-dismiss="modal" type="button"
                            class="btn btn-default"><?php echo lang('close'); ?></button>
                        <button data-bb-handler="confirm" data-quick_amount="0" type="button"
                            class="btn btn-primary quick_amount"
                            id="collect_amount"><?php echo lang('collect'); ?></button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->

        <div class="modal fade" id="var_popup_ss" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label=<?php echo json_encode(lang('close')); ?>><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><span id="var-customize-ss"></span></h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="placeholder_supplier_vals2">
                            <table style="width: 100%" class="table table-hover secondary-supplier-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th><?php echo H(lang('suppliers')); ?></th>
                                        <?php if ($this->Employee->has_module_action_permission('items', 'see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                        <th><?php echo H(lang('cost_price')); ?></th>
                                        <th><?php echo H(lang('unit_price')); ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="add_supplier"
                            class="btn btn-primary"><?php echo lang('save'); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="var_popup_ss_1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label=<?php echo json_encode(lang('close')); ?>><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo H(lang('suppliers')); ?> <span id="var-customize-ss"></span>
                        </h4>
                    </div>

                    <div class="modal-body clearfix">
                        <div class="placeholder_supplier_vals2">
                            <table style="width: 100%" class="table table-hover secondary-supplier-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th><?php echo H(lang('suppliers')); ?></th>
                                        <?php if ($this->Employee->has_module_action_permission('items', 'see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                        <th><?php echo H(lang('cost_price')); ?></th>
                                        <th><?php echo H(lang('unit_price')); ?></th>
                                        <?php } ?>
                                    </tr>

                                    <?php if (isset($default_supplier)) {
										foreach ($default_supplier as $supplier) { ?>
                                    <tr class="default_supplier_row" style="cursor:pointer;"
                                        data-supplier_id="<?php echo $supplier->supplier_id; ?>">
                                        <td><input class="default_supplier" type="radio" style="display:block;"
                                                value="<?php echo $supplier->supplier_id; ?>" name="default_supplier"
                                                checked>
                                        </td>
                                        <td><?php echo $supplier->company_name; ?>, <?php echo $supplier->full_name; ?>
                                        </td>
                                        <?php if ($this->Employee->has_module_action_permission('items', 'see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                        <td><?php echo to_currency($supplier->cost_price); ?></td>
                                        <td><?php echo to_currency($supplier->unit_price); ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php }
									} ?>

                                    <?php if (isset($secondary_suppliers_cart)) {
										foreach ($secondary_suppliers_cart as $supplier) { ?>
                                    <tr class="secondary_supplier_row" style="cursor:pointer;"
                                        data-supplier_id="<?php echo $supplier->supplier_id; ?>">
                                        <td><input class="secondary_supplier" type="radio" style="display:block;"
                                                value="<?php echo $supplier->supplier_id; ?>" name="secondary_supplier">
                                        </td>
                                        <td><?php echo $supplier->company_name; ?>, <?php echo $supplier->full_name; ?>
                                        </td>
                                        <?php if ($this->Employee->has_module_action_permission('items', 'see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                        <td><?php echo to_currency($supplier->cost_price); ?></td>
                                        <td><?php echo to_currency($supplier->unit_price); ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php }
									} ?>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="add_supplier"
                            class="btn btn-primary"><?php echo lang('save'); ?></button>
                    </div>
                </div>
            </div>

            <script>
            $(document).ready(function() {

                // When any tab header is clicked
                $(".tab-header").on("click", function(e) {


                    e.preventDefault(); // Prevent the default anchor action


                    $(".tab-pane").removeClass("show active");



                    // Get the ID of the associated content from the href of the clicked tab header
                    var contentId = $(this).attr("href");
                    console.log(contentId);
                    // Add 'active' and 'show' classes to the associated content
                    $(contentId).addClass("show active");
                });
            });
            </script>
            <?php
		if (isset($number_of_points_to_use) && $number_of_points_to_use > 0 && $this->config->item('prompt_to_use_points') && $customer_points >= $this->config->item('minimum_points_to_redeem')) {
		?>
            <script>
            bootbox.confirm({
                message: <?php echo json_encode(lang("sales_use_points")); ?>,
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
                        $.post('<?php echo site_url("sales/add_payment"); ?>', {
                            amount_tendered: <?php echo json_encode($number_of_points_to_use); ?>,
                            payment_type: <?php echo json_encode(lang('points')); ?>
                        }, function(response) {
                            $("#sales_section").html(response);
                        });
                    }
                }
            });
            </script>

            <?php
		}
		?>


            <!-- price rules prompt-->
            <?php
		if (isset($number_to_add) && isset($item_to_add)) {
		?>

            <script>
            var dialog = bootbox.confirm({
                message: <?php echo json_encode(lang("sales_price_rules_bogo_prompt")); ?>,
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
                        $.post('<?php echo site_url("sales/add"); ?>', {
                            item: <?php echo json_encode($item_to_add); ?>,
                            quantity: <?php echo json_encode($number_to_add); ?>
                        }, function(response) {


                            $("#sales_section").html(response);
                        });
                    }
                }
            });
            </script>

            <?php
		}
		?>




            <?php if ($this->config->item('confirm_error_adding_item') && isset($error)) { ?>
            <script type="text/javascript">
            bootbox.alert(<?php echo json_encode($error); ?>, function(result) {
                setTimeout(function() {
                    $('#item').focus();
                }, 50);
            });
            </script>
            <?php } ?>

            <?php if (!$this->config->item('disable_sale_notifications')) { ?>
            <script type="text/javascript">
            <?php

				if (isset($error) && isset($prompt_to_create_giftcard)) {
				?>
            bootbox.confirm(<?php echo json_encode(lang("sales_giftcard_not_exist")); ?>, function(result) {
                if (result) {
                    $.post(<?php echo json_encode(site_url('sales/create_return_on_giftcard')); ?>, {
                        giftcard_number: <?php echo json_encode($prompt_to_create_giftcard); ?>
                    }, function() {
                        $("#sales_section").load('<?php echo site_url("sales/sales_reload"); ?>');
                    });
                }
            });

            <?php
				} elseif (isset($error) && !$this->config->item('confirm_error_adding_item')) {
					echo "show_feedback('error', " . json_encode($error) . ", " . json_encode(lang('error')) . ");";
				}

				if (isset($vendor_search) && count($vendor_search) > 0) {
				?>
            setTimeout(function() {
                var search_item_key = localStorage.getItem('item_search_key');
                if (search_item_key.trim() != "") {

                    $("#add_item_form #item").val(search_item_key);
                    bootbox.dialog({
                        message: '<?php echo lang("sales_ask_search_in_other_vendors"); ?>',
                        size: 'large',
                        onEscape: true,
                        backdrop: true,
                        buttons: {
                            <?php
									if (in_array("ig_api_bearer_token", $vendor_search)) {
									?>
                            api_ig: {
                                label: 'Injured Gadgets',
                                className: 'btn-info',
                                callback: function() {

                                    $("#item").autocomplete('option', 'source',
                                        '<?php echo site_url("home/sync_ig_item_search"); ?>');

                                    $("#item").autocomplete('option', 'response',
                                        function(event, ui) {
                                            $("#add_item_form .spinner").hide();
                                            var source_url = $("#item").autocomplete('option',
                                                'source');

                                            if (ui.content.length == 0 && (source_url.indexOf(
                                                    'sales/item_search') > -1) && $(
                                                    "#add_item_form #item").val().trim() !=
                                                "") {

                                            } else if (ui.content.length == 0 && (source_url
                                                    .indexOf(
                                                        'home/sync_ig_item_search') > -1)) {
                                                var noResult = {
                                                    value: "",
                                                    image: "<?php echo base_url() . "assets/img/item.png"; ?>",
                                                    label: "<?php echo lang("sales_no_result_found_ig"); ?>"
                                                };
                                                ui.content.push(noResult);
                                                $("#item").autocomplete('option', 'source',
                                                    '<?php echo site_url("sales/item_search"); ?>'
                                                    );
                                            } else {
                                                $("#item").autocomplete('option', 'source',
                                                    '<?php echo site_url("sales/item_search"); ?>'
                                                    );
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
									if (in_array("wgp_integration_pkey", $vendor_search)) {
									?>
                            api_wgp: {
                                label: 'WGP',
                                className: 'btn-info',
                                callback: function() {

                                    $("#item").autocomplete('option', 'source',
                                        '<?php echo site_url("home/sync_wgp_inventory_search"); ?>'
                                        );

                                    $("#item").autocomplete('option', 'response',
                                        function(event, ui) {
                                            $("#add_item_form .spinner").hide();
                                            var source_url = $("#item").autocomplete('option',
                                                'source');

                                            if (ui.content.length == 0 && (source_url.indexOf(
                                                    'sales/item_search') > -1) && $(
                                                    "#add_item_form #item").val().trim() !=
                                                "") {

                                            } else if (ui.content.length == 0 && (source_url
                                                    .indexOf(
                                                        'home/sync_wgp_inventory_search') > -1
                                                    )) {
                                                var noResult = {
                                                    value: "",
                                                    image: "<?php echo base_url() . "assets/img/item.png"; ?>",
                                                    label: "<?php echo lang("sales_no_result_found_wgp"); ?>"
                                                };
                                                ui.content.push(noResult);
                                                $("#item").autocomplete('option', 'source',
                                                    '<?php echo site_url("sales/item_search"); ?>'
                                                    );
                                            } else {
                                                $("#item").autocomplete('option', 'source',
                                                    '<?php echo site_url("sales/item_search"); ?>'
                                                    );
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
									if (in_array("p4_api_bearer_token", $vendor_search)) {
									?>
                            api_p4: {
                                label: 'Parts4cells',
                                className: 'btn-info',
                                callback: function() {

                                    $("#item").autocomplete('option', 'source',
                                        '<?php echo site_url("home/sync_p4_item_search"); ?>');

                                    $("#item").autocomplete('option', 'response',
                                        function(event, ui) {
                                            $("#add_item_form .spinner").hide();
                                            var source_url = $("#item").autocomplete('option',
                                                'source');

                                            if (ui.content.length == 0 && (source_url.indexOf(
                                                    'sales/item_search') > -1) && $(
                                                    "#add_item_form #item").val().trim() !=
                                                "") {

                                            } else if (ui.content.length == 0 && (source_url
                                                    .indexOf(
                                                        'home/sync_p4_item_search') > -1)) {
                                                var noResult = {
                                                    value: "",
                                                    image: "<?php echo base_url() . "assets/img/item.png"; ?>",
                                                    label: "<?php echo lang("sales_no_result_found_p4"); ?>"
                                                };
                                                ui.content.push(noResult);
                                                $("#item").autocomplete('option', 'source',
                                                    '<?php echo site_url("sales/item_search"); ?>'
                                                    );
                                            } else {
                                                $("#item").autocomplete('option', 'source',
                                                    '<?php echo site_url("sales/item_search"); ?>'
                                                    );
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
                                callback: function() {}
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

				if ($this->session->flashdata('cash_drawer_add_subtract_message')) {
					echo "show_feedback('success', " . json_encode($this->session->flashdata('cash_drawer_add_subtract_message')) . ", " . json_encode(lang('success')) . ");";
				}

				?>
            </script>
            <?php } ?>

            <?php if (isset($info_popup_message) && $info_popup_message) { ?>
            <script type="text/javascript">
            bootbox.alert(<?php echo json_encode(nl2br($info_popup_message)); ?>, function(result) {
                setTimeout(function() {
                    $('#item').focus();
                }, 50);
            });
            </script>
            <?php } ?>
            <!--- Variation Popup --->
            <script type="text/javascript" language="javascript">
            if (has_offline_sales()) {
                $("#sync_offline_sales").show();
                $("#number_of_offline_sales").text(get_number_of_offline_sales());
            }

            $("#sync_offline_sales_button").click(sync_offline_sales);

            function sync_offline_sales() {
                $('#sync_offline_sales_button').prop('disabled', true);
                $("#offline_sync_spining").show();
                var allSales = JSON.parse(localStorage.getItem("sales")) || [];

                $.post('<?php echo site_url("sales/sync_offline_sales"); ?>', {
                        offline_sales: JSON.stringify(allSales),
                    },
                    function(response) {
                        if (response.success) {
                            $('#sync_offline_sales_button').remove();
                            localStorage.removeItem("sales");
                            bootbox.alert(<?php echo json_encode(lang('sales_offline_synced_successfully')); ?> +
                                " [" +
                                response.sale_ids.length + "]");
                        }
                    }, 'json');
            }


            <?php
			if ($this->config->item('auto_sync_offline_sales')) {
			?>
            if (has_offline_sales()) {
                sync_offline_sales();
            }
            <?php
			}
			?>

            function has_offline_sales() {
                var allSales = JSON.parse(localStorage.getItem("sales")) || [];
                return allSales.length > 0;
            }

            function get_number_of_offline_sales() {
                var allSales = JSON.parse(localStorage.getItem("sales")) || [];
                return allSales.length
            }

            $all_attributes = [];
            $i = 1;
            <?php if (isset($vair_type)) {  ?>
            $all_attributes = <?php echo json_encode($vair_type); ?>;
            <?php 		} ?>

            function fetch_attr_values($attr_id) {
                console.log($all_attributes);
                jQuery('#choose_var').modal('show');
                jQuery.ajax({
                    url: "<?php echo site_url('sales/get_attributes_values'); ?>",
                    data: {
                        "attr_id": $attr_id
                    },
                    cache: false,
                    success: function(response) {
                        jQuery(".customer-recent-sales .modal-body .placeholder_attribute_vals").html(
                            response);
                        $('#choose_var').load();
                        if ($all_attributes.length > 0) {
                            $('.choose_var_title').html($all_attributes[$i]['name']);
                            $i++;
                        }
                    }
                });
            }

            function fetch_attr_value($attr_id) {
                console.log($all_attributes);
                jQuery.ajax({
                    url: "<?php echo site_url('sales/get_attributes_values'); ?>",
                    data: {
                        "attr_id": $attr_id
                    },
                    cache: false,
                    success: function(html) {
                        jQuery(".customer-recent-sales .modal-body .placeholder_attribute_vals").html(html);

                    }
                });
            }

            function enable_popup($attr_id, ) {
                jQuery('#choose_var').modal('show');
                jQuery.ajax({
                    url: "<?php echo site_url('sales/get_attribute_values'); ?>",
                    data: {
                        "attr_id": $attr_id
                    },
                    cache: false,
                    success: function(response) {
                        jQuery(".customer-recent-sales .modal-body .placeholder_attribute_vals").html(
                            response);

                    }
                });
            }

            function enable_popup_modifier(line) {
                jQuery('#choose_modifiers').modal('show');
                jQuery.ajax({
                    url: "<?php echo site_url('sales/get_modifiers'); ?>",
                    data: {
                        "line": line
                    },
                    cache: false,
                    success: function(response) {
                        jQuery("#choose_modifiers .modal-body").html(response);

                    }
                });
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

            mercury_emv_pad_reset(<?php echo json_encode($reset_params['post_host']); ?>,
                <?php echo $this->Location->get_info_for_key('listener_port'); ?>, data);
            <?php
			}

			?>

            var submitting = false;

            $(document).ready(function() {

                var hasSuggestions = false;
                $('.coupon_codes').tokenfield({
                    tokens: <?php echo json_encode($coupon_codes); ?>,
                    autocomplete: {
                        source: '<?php echo site_url("sales/search_coupons"); ?>',
                        delay: 100,
                        autoFocus: true,
                        minLength: 0,
                        showAutocompleteOnFocus: false,
                        create: function() {
                            $(this).data('ui-autocomplete')._renderItem = function(ul, item) {
                                return $("<li class='item-suggestions'></li>")
                                    .data("item.autocomplete", item)
                                    .append('<a class="suggest-item">' +

                                        '<div class="name">' +
                                        item.label +
                                        '</div>'
                                    )
                                    .appendTo(ul);
                            }
                        },
                        open: function() {
                            hasSuggestions = true;
                        },
                        close: function() {
                            hasSuggestions = false;
                        }
                    }
                });

                $('.coupon_codes').on("change", function() {
                    $.post('<?php echo site_url("sales/set_coupons"); ?>', {
                            coupons: $('.coupon_codes').tokenfield('getTokens'),
                        },
                        function(response) {
                            $("#sales_section").html(response);
                        });
                });

                $('.coupon_codes').on('tokenfield:createtoken', function(event) {
                    var existingTokens = $(this).tokenfield('getTokens');
                    $.each(existingTokens, function(index, token) {
                        if (token.value === event.attrs.value) {
                            event.preventDefault();
                        }
                    });

                    var menu = $("#coupons-tokenfield").data("uiAutocomplete").menu.element,
                        focused = menu.find("li:has(a.ui-state-focus)");

                    if (focused.length !== 1 || !hasSuggestions) {
                        event.preventDefault();
                    }
                });

                $("#ebt_voucher_no").bind('keyup change', function() {
                    $.post('<?php echo site_url("sales/set_ebt_voucher_no"); ?>', {
                        ebt_voucher_no: $(this).val()
                    });
                });

                $("#ebt_auth_code").bind('keyup change', function() {
                    $.post('<?php echo site_url("sales/set_ebt_auth_code"); ?>', {
                        ebt_auth_code: $(this).val()
                    });
                });

                $("#keyboard_toggle").click(function(e) {
                    e.preventDefault();
                    $("#keyboardhelp").toggle();
                });

                $.fn.editable.defaults.mode = 'popup';

                $('.fullscreen').on('click', function(e) {
                    e.preventDefault();
                    salesRecvFullScreen();
                    $.get('<?php echo site_url("home/set_fullscreen/1"); ?>');
                });

                $('.customer-giftcard-item').on('click', function(e) {
                    e.preventDefault();
                    $.post('<?php echo site_url("sales/set_selected_payment"); ?>', {
                        payment: <?php echo json_encode(lang('giftcard')); ?>
                    });
                    $('#select-mode-3').html('<i class="fa fa-money-bill"></i>' + $(this).data(
                        'payment'));
                    $('#payment_types').val(<?php echo json_encode(lang('giftcard')); ?>);

                    $('.select-payment').removeClass('active');
                    $('a[data-payment=<?php echo json_encode(lang('giftcard')); ?>]').addClass(
                    'active');
                    $("#amount_tendered").focus();

                    $("#amount_tendered").val($(this).data('giftcard-number'));

                });


                $('.dismissfullscreen').on('click', function(e) {
                    e.preventDefault();
                    salesRecvDismissFullscren();
                    $.get('<?php echo site_url("home/set_fullscreen/0"); ?>');
                });

                $('.xeditable').editable({
                    validate: function(value) {
                        if ($.isNumeric(value) == '' && $(this).data('validate-number')) {
                            return <?php echo json_encode(lang('only_numbers_allowed')); ?>;
                        }
                    },
                    success: function(response, newValue) {
                        last_focused_id = $(this).attr('id');
                        $("#sales_section").html(response);
                    },
                    savenochange: true
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
				$('.xeditable-comment').editable();
                <?php
				if (isset($price_zero) && $price_zero) {
				?>
                var price_to_change = $('#register a[data-name="unit_price"]').first();
                price_to_change.editable('show');
                <?php
				}
				?>

                <?php
				if (isset($quantity_set) && $quantity_set) {
				?>
                var quantity_to_change = $('#register a[data-name="quantity"]').first();
                quantity_to_change.editable('show');
                <?php
				}
				?>

                <?php
				if (isset($do_verify_age) && $do_verify_age) {
				?>
                bootbox.prompt({
                    title: <?php echo json_encode(lang('sales_please_enter_date_of_birth')); ?>,
                    inputType: 'text',
                    placeholder: <?php echo json_encode(get_date_format_extended()); ?>,
                    callback: function(dob) {
                        if (dob) {
                            $.post('<?php echo site_url("sales/save_dob/" . (count($cart_items) - 1)); ?>', {
                                dob: dob
                            }, function(response) {
                                if (response.success) {
                                    show_feedback('success', response.message,
                                        <?php echo json_encode(lang('success')); ?>);
                                } else {
                                    show_feedback('error', response.message,
                                        <?php echo json_encode(lang('error')); ?>);
                                    $("#sales_section").load(
                                        '<?php echo site_url("sales/reload"); ?>');
                                }
                            }, "json");
                        } else {
                            $('#register a.delete-item pull-right').first().click();
                        }
                    }
                });

                <?php
				}
				?>
                // Look up receipt form handling

                $('#look-up-receipt').on('shown.bs.modal', function() {
                    $('#sale_id').focus();
                });

                $('.look-up-receipt-form').on('submit', function(e) {
                    e.preventDefault();

                    $('.look-up-receipt-form').ajaxSubmit({
                        success: function(response) {
                            if (response.success) {
                                window.location.href =
                                    '<?php echo site_url("sales/receipt"); ?>/' +
                                    response.sale_id;
                            } else {
                                $('.look-up-receipt-error').html(response.message);
                            }
                        },
                        dataType: 'json'
                    });
                });

                //Set Item tier after selection
                $('.item-tiers a').on('click', function(e) {
                    e.preventDefault();

                    $('.selected-tier').html($(this).text());
                    $.post('<?php echo site_url("sales/set_tier_id"); ?>', {
                        tier_id: $(this).data('value')
                    }, function(response) {
                        $('.item-tiers').slideToggle("fast", function() {
                            $("#sales_section").html(response);
                        });
                    });
                });

                //Slide Toggle item tier options
                $('.item-tier').on('click', function(e) {
                    e.preventDefault();
                    $('.item-tiers').slideToggle("fast");
                });

                //Set Item tier after selection
                $('.select-sales-persons a').on('click', function(e) {
                    e.preventDefault();

                    $('.selected-sales-person').html($(this).text());
                    $.post('<?php echo site_url("sales/set_sold_by_employee_id"); ?>', {
                        sold_by_employee_id: $(this).data('value')
                    }, function() {
                        $('.select-sales-persons').slideToggle("fast");
                        $("#sales_section").load(
                            '<?php echo site_url("sales/sales_reload"); ?>');
                    });
                });

                //Slide Toggle item tier options
                $('.select-sales-person').on('click', function(e) {
                    e.preventDefault();
                    $('.select-sales-persons').slideToggle("fast");
                });

                checkPaymentTypes();

                $('#toggle_email_receipt').on('click', function(e) {
                    e.preventDefault();
                    var checkBox = $("#email_receipt");
                    checkBox.prop("checked", !checkBox.prop("checked")).trigger("change");
                    $(this).toggleClass('checked');
                });

                $('#email_receipt').change(function(e) {
                    e.preventDefault();
                    $.post('<?php echo site_url("sales/set_email_receipt"); ?>', {
                        email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'
                    });
                });

                $('#toggle_sms_receipt').on('click', function(e) {
                    e.preventDefault();
                    var checkBox = $("#sms_receipt");
                    checkBox.prop("checked", !checkBox.prop("checked")).trigger("change");
                    $(this).toggleClass('checked');
                });

                $('#sms_receipt').change(function(e) {
                    e.preventDefault();
                    $.post('<?php echo site_url("sales/set_sms_receipt"); ?>', {
                        sms_receipt: $('#sms_receipt').is(':checked') ? '1' : '0'
                    });
                });

                $('#delivery').change(function(e) {
                    e.preventDefault();
                    $.post('<?php echo site_url("sales/set_delivery"); ?>', {
                        delivery: $('#delivery').is(':checked') ? '1' : '0'
                    }, function(response) {
                        if (!$('#delivery').is(':checked')) {
                            $("#sales_section").html(response);
                        }
                    });
                });

                // Customer form script
                $('#item,#customer').click(function() {
                    $(this).attr('value', '');
                });


                // if #mode is changed
                $('.change-mode').click(function(e) {
                    e.preventDefault();
                    $('.mode_text').html("<i class='icon ti-shopping-cart'></i>" + $(this).data(
                    'mode'));
                    $(".sales-dropdown li:first-child").remove();
                    if ($(this).data('mode') == 'sale') {
                        $('.sales-dropdown').prepend(
                            '<li><a tabindex="-1" href="#" data-mode="return" class="change-mode"><?php echo lang('return'); ?></a></li>'
                        );
                    } else {
                        $('.sales-dropdown').prepend(
                            '<li><a tabindex="-1" href="#" data-mode="sale" class="change-mode"><?php echo lang('sale'); ?></a></li>'
                        );
                    }

                    if ($(this).data('mode') == "store_account_payment") { // Hiding the category grid
                        $('#show_hide_grid_wrapper, #category_item_selection_wrapper').fadeOut();
                    } else { // otherwise, show the categories grid
                        $('#show_hide_grid_wrapper, #show_grid').fadeIn();
                        $('#hide_grid').fadeOut();
                    }
                    $.post('<?php echo site_url("sales/change_mode"); ?>', {
                        mode: $(this).data('mode')
                    }, function(response) {
                        $("#sales_section").html(response);
                    });
                });


                <?php if (!$this->agent->is_mobile()) { ?>
                <?php if (!$this->config->item('auto_focus_on_item_after_sale_and_receiving')) { ?>
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
                    $("#item").focus();
                }, 10);
                <?php
					}
					?>
                $(document).off('focusin');
                $(document).focusin(function(event) {
                    last_focused_id = $(event.target).attr('id');
                });
                <?php
				} else {
					if ($this->config->item('wireless_scanner_support_focus_on_item_field')) {
					?>
                setTimeout(function() {
                    $("#item").focus();
                }, 10);
                <?php } ?>


                <?php } ?>

                $(".pay_store_account_sale_form").submit(function(e) {
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
                                    var new_action = action.replace($(that).data(
                                            'full-amount'),
                                        amount);
                                    $(that).attr('action', new_action);
                                    $(that).ajaxSubmit({
                                        target: "#sales_section"
                                    });
                                }
                            }
                        });
                    } else {
                        $(this).ajaxSubmit({
                            target: "#sales_section"
                        });
                    }
                });

                $('#pay_or_unpay_all').click(function() {
                    $("#sales_section").load(
                        <?php echo json_encode(site_url('sales/toggle_pay_all_store_account')); ?>);
                });

                $(document).on("click", ".secondary_supplier_row", function() {
                    $(this).find(".secondary_supplier").prop("checked", true);
                    $("#secondary_supplier_id").val($(this).find(".secondary_supplier").val());
                    $(".default_supplier_row").find(".default_supplier").prop("checked", false);
                    $("#default_supplier_id").val("");
                });

                $(document).on("click", ".default_supplier_row", function() {
                    $(this).find(".default_supplier").prop("checked", true);
                    $("#default_supplier_id").val($(this).find(".default_supplier").val());
                    $("#secondary_supplier_id").val("");

                    $(".secondary_supplier_row").each(function() {
                        $(this).find(".secondary_supplier").prop("checked", false);
                    });
                });

                $(document).on("change", ".secondary_supplier", function() {
                    $("#secondary_supplier_id").val($(this).val());
                });

                $(document).on('click', '#add_supplier', function() {

                    var default_supplier_id = $("#default_supplier_id").val();
                    var secondary_supplier_id = $("#secondary_supplier_id").val();

                    if (!default_supplier_id && !secondary_supplier_id) {
                        $("#default_supplier_id").val($(".default_supplier_row").find(
                                ".default_supplier")
                            .val());
                    }

                    $('#var_popup_ss').modal('hide');
                    $('#add_item_form').ajaxSubmit({
                        target: "#sales_section",
                        beforeSubmit: salesBeforeSubmit,
                        success: itemScannedSuccess
                    });
                });

                if ($("#item").length) {

                    <?php
					if ($this->Employee->has_module_action_permission('sales', 'allow_item_search_suggestions_for_sales', $this->Employee->get_logged_in_employee_info()->person_id)) {
					?>
                    $("#item").autocomplete({
                        source: '<?php echo site_url("sales/item_search"); ?>',
                        delay: 500,
                        autoFocus: false,
                        minLength: 0,
                        select: function(event, ui) {

                            if (ui.item.value == "") return;

                            //if item has secondary suppliers and has no variation
                            <?php if (!$this->config->item('disable_supplier_selection_on_sales_interface')) { ?>
                            if (ui.item.hasOwnProperty('secondary_suppliers')) {
                                if (ui.item.secondary_suppliers.length > 0 && !ui.item
                                    .hasOwnProperty(
                                        'attributes')) {
                                    $('#var-customize-ss').text(ui.item.label);
                                    $('#var_popup_ss').modal('show');
                                    $('.placeholder_supplier_vals2 .secondary-supplier-table tr')
                                        .not(
                                            ':first').remove();

                                    $.each(ui.item.default_supplier, function(supplier_key,
                                        supplier) {
                                        $('.placeholder_supplier_vals2 .secondary-supplier-table tr:last')
                                            .after(
                                                '<tr class="default_supplier_row" style="cursor:pointer;" data-supplier_id="' +
                                                supplier.supplier_id +
                                                '"> <td><input class="default_supplier" type="radio" style="display:block;" value="' +
                                                supplier.supplier_id +
                                                '" name="default_supplier" ></td> <td>' +
                                                supplier
                                                .company_name + ', ' + supplier.full_name +
                                                '</td> <td>' + parseFloat(supplier
                                                    .cost_price)
                                                .toFixed(2) + '</td> <td>' + parseFloat(
                                                    supplier
                                                    .unit_price).toFixed(2) + '</td> </tr>'
                                                );
                                        $("#default_supplier_id").val(supplier.supplier_id);
                                    });

                                    $(".default_supplier_row").find(".default_supplier").prop(
                                        "checked",
                                        true);

                                    $.each(ui.item.secondary_suppliers, function(supplier_key,
                                        supplier) {
                                        $('.placeholder_supplier_vals2 .secondary-supplier-table tr:last')
                                            .after(
                                                '<tr class="secondary_supplier_row" style="cursor:pointer;" data-supplier_id="' +
                                                supplier.supplier_id +
                                                '"> <td><input class="secondary_supplier" type="radio" style="display:block;" value="' +
                                                supplier.supplier_id +
                                                '" name="secondary_supplier" ></td> <td>' +
                                                supplier
                                                .company_name + ', ' + supplier.full_name +
                                                '</td> <td>' + parseFloat(supplier
                                                    .cost_price)
                                                .toFixed(2) + '</td> <td>' + parseFloat(
                                                    supplier
                                                    .unit_price).toFixed(2) + '</td> </tr>'
                                                );
                                    });

                                    if (ui.item.serial_number != undefined && ui.item
                                        .serial_number != '') {
                                        $("#item").val(decodeHtml(ui.item.serial_number));
                                    } else {
                                        $("#item").val(decodeHtml(ui.item.value) +
                                            '|FORCE_ITEM_ID|');
                                    }


                                    return true;
                                }
                            }
                            <?php } ?>
                            console.log(ui.item.serial_number);
                            if (ui.item.serial_number != undefined && ui.item.serial_number != '') {
                                $("#item").val(decodeHtml(ui.item.serial_number));
                            } else {
                                $("#item").val(decodeHtml(ui.item.value) + '|FORCE_ITEM_ID|');
                            }


                            $('#add_item_form').ajaxSubmit({
                                target: "#sales_section",
                                beforeSubmit: salesBeforeSubmit,
                                success: itemScannedSuccess
                            });

                        },
                    }).data("ui-autocomplete")._renderItem = function(ul, item) {
                        return $("<li class='item-suggestions'></li>")
                            .data("item.autocomplete", item)
                            .append('<a class="suggest-item"><div class="item-image symbol symbol-50px">' +
                                '<img src="' + item.image + '" alt="">' +
                                '</div>' +
                                '<div class="details">' +
                                '<div class="name">' +
                                decodeHtml(item.label) +
                                '</div>' +
                                '<span class="attributes">' + '<?php echo lang("category"); ?>' +
                                ' : <span class="value">' + (item.category ? item.category :
                                    <?php echo json_encode(lang('none')); ?>) + '</span></span>' +
                                <?php if ($this->Employee->has_module_action_permission('items', 'see_item_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>(
                                    typeof item.quantity !== 'undefined' && item.quantity !== null ?
                                    '<span class="attributes">' + '<?php echo lang("quantity"); ?>' +
                                    ' <span class="value">' + item.quantity + '</span></span>' : '') +
                                <?php } ?>(item.attributes ? '<span class="attributes">' +
                                    '<?php echo lang("attributes"); ?>' + ' : <span class="value">' + item
                                    .attributes + '</span></span>' : '') +
                                '<?php if (!$this->config->item('hide_supplier_in_item_search_result')) { ?>' +
                                (item.supplier_name ? '<span class="attributes">' +
                                    '<?php echo lang("supplier"); ?>' + ' : <span class="value">' + item
                                    .supplier_name + '</span></span>' : '') +
                                '<?php } ?>' +
                                '</div>')
                            .appendTo(ul);
                    };
                    <?php } ?>
                }

                <?php if (!isset($customer)) { ?>


                <?php
					if ($this->Employee->has_module_action_permission('sales', 'allow_customer_search_suggestions_for_sales', $this->Employee->get_logged_in_employee_info()->person_id)) {
					?>

                $("#customer").autocomplete({
                    source: '<?php echo site_url("sales/customer_search"); ?>',
                    delay: 500,
                    autoFocus: false,
                    minLength: 0,
                    select: function(event, ui) {
                        $.post('<?php echo site_url("sales/select_customer"); ?>', {
                            customer: decodeHtml(ui.item.value) + '|FORCE_PERSON_ID|'
                        }, function(response) {
                            $("#sales_section").html(response);
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

                $('#change_date_enable').is(':checked') ? $("#change_cart_date_picker").show() : $(
                    "#change_cart_date_picker").hide();

                $('#change_date_enable').click(function() {
                    if ($(this).is(':checked')) {
                        $("#change_cart_date_picker").show();
                    } else {
                        $("#change_cart_date_picker").hide();
                    }
                });

                $('#comment').change(function() {
                    $.post('<?php echo site_url("sales/set_comment"); ?>', {
                        comment: $('#comment').val()
                    });
                });



                $('#show_comment_on_receipt').change(function() {
                    $.post('<?php echo site_url("sales/set_comment_on_receipt"); ?>', {
                        show_comment_on_receipt: $('#show_comment_on_receipt').is(':checked') ?
                            '1' : '0'
                    });
                });

                $('#create_invoice').change(function() {
                    $.post('<?php echo site_url("sales/set_create_invoice"); ?>', {
                        create_invoice: $('#create_invoice').is(':checked') ? '1' : '0'
                    });
                });


                // Create Work Order 
                $('#create_work_order').change(function() {
                    $.post('<?php echo site_url("sales/set_create_work_order"); ?>', {
                        create_work_order: $('#create_work_order').is(':checked') ? '1' : '0'
                    });
                });


                date_time_picker_field($("#change_cart_date"), JS_DATE_FORMAT + " " + JS_TIME_FORMAT);

                $("#change_cart_date").on("dp.change", function(e) {
                    $.post('<?php echo site_url("sales/set_change_cart_date"); ?>', {
                        change_cart_date: $('#change_cart_date').val()
                    });
                });

                //Input change
                $("#change_cart_date").change(function() {
                    $.post('<?php echo site_url("sales/set_change_cart_date"); ?>', {
                        change_cart_date: $('#change_cart_date').val()
                    });
                });

                $('#change_date_enable').change(function() {
                    $.post('<?php echo site_url("sales/set_change_date_enable"); ?>', {
                        change_date_enable: $('#change_date_enable').is(':checked') ? '1' : '0'
                    });
                });


                $('.delete-item, .delete-payment, #delete_customer').click(function(event) {
                    event.preventDefault();

                    $.get($(this).attr('href'), function(response) {
                        $("#sales_section").html(response);
                    });
                });

                $('.delete-tax').click(function(event) {
                    event.preventDefault();
                    var $that = $(this);
                    bootbox.confirm(<?php echo json_encode(lang("confirm_sale_tax_delete")); ?>,
                        function(
                            result) {
                            if (result) {
                                $("#sales_section").load($that.attr('href'));
                            }
                        });
                });


                $('#redeem_discount,#unredeem_discount').click(function(event) {
                    event.preventDefault();
                    $("#sales_section").load($(this).attr('href'));
                });

                //Layaway Sale
                $("#layaway_sale_button").click(function(e) {
                    e.preventDefault();
                    bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>,
                        function(
                            result) {
                            if (result) {
                                $.post('<?php echo site_url("sales/set_comment"); ?>', {
                                    comment: $('#comment').val()
                                }, function() {
                                    <?php if ($this->config->item('show_receipt_after_suspending_sale')) { ?>
                                    window.location =
                                        '<?php echo site_url("sales/suspend"); ?>';
                                    <?php } else { ?>
                                    $("#sales_section").load(
                                        '<?php echo site_url("sales/suspend"); ?>');
                                    <?php } ?>
                                });
                            }
                        });
                });

                //Estimate Sale
                $("#estimate_sale_button").click(function(e) {
                    e.preventDefault();
                    bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>,
                        function(
                            result) {
                            if (result) {
                                $.post('<?php echo site_url("sales/set_comment"); ?>', {
                                    comment: $('#comment').val()
                                }, function() {
                                    <?php if ($this->config->item('show_receipt_after_suspending_sale')) { ?>
                                    window.location =
                                        '<?php echo site_url("sales/suspend/2"); ?>';
                                    <?php } else { ?>
                                    $("#sales_section").load(
                                        '<?php echo site_url("sales/suspend/2"); ?>');
                                    <?php } ?>
                                });
                            }
                        });
                });

                // Work Order Status Update 
                // On work_order_status_button click Call Ajax to update status

                $(".work_order_status_button").click(function(e) {
                    e.preventDefault();
                    var workOrderID = <?php echo $work_order_id ?? 0; ?>;
                    var getID = $(this).data('suspend-index');
                    var makeURL = '<?php echo site_url("work_orders/change_status/"); ?>' +
                        workOrderID + '/' +
                        getID;
                    bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>,
                        function(
                            result) {
                            if (result) {
                                $.get(makeURL, {}, function() {
                                    $("#sales_section").load(
                                        '<?php echo site_url("sales/suspend/2"); ?>');
                                });
                            }
                        });
                });
                $(".additional_suspend_button").click(function(e) {
                    var suspend_index = $(this).data('suspend-index');
                    e.preventDefault();
                    bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>,
                        function(
                            result) {
                            if (result) {
                                $.post('<?php echo site_url("sales/set_comment"); ?>', {
                                    comment: $('#comment').val()
                                }, function() {
                                    <?php if ($this->config->item('show_receipt_after_suspending_sale')) { ?>
                                    window.location =
                                        '<?php echo site_url("sales/suspend"); ?>/' +
                                        suspend_index;
                                    <?php } else { ?>
                                    $("#sales_section").load(
                                        '<?php echo site_url("sales/suspend"); ?>/' +
                                        suspend_index);
                                    <?php } ?>
                                });
                            }
                        });
                });

                //Cancel Sale
                $("#cancel_sale_button").click(function(e) {
                    e.preventDefault();
                    bootbox.confirm(<?php echo json_encode(lang("sales_confirm_cancel_sale")); ?>,
                        function(
                            result) {
                            if (result) {
                                localStorage.setItem('cart_oc', JSON.stringify([]));
                                $('#cancel_sale_form').ajaxSubmit({
                                    target: "#sales_section",
                                    beforeSubmit: salesBeforeSubmit
                                });
                            }
                        });
                });
                //Select Payment
                $('.select-payment').on('click mousedown', selectPayment);

                <?php
				if ($selected_payment == lang('integrated_gift_card') || ($selected_payment == lang('credit') && $this->Location->get_info_for_key('enable_credit_card_processing')) || ($selected_payment == lang('ebt') && $this->Location->get_info_for_key('enable_credit_card_processing')) || ($selected_payment == lang('ebt_cash') && $this->Location->get_info_for_key('enable_credit_card_processing'))) {
				?>
                $("#credit_card_options").show();

                <?php
				}
				?>

                <?php
				if ($selected_payment == lang('ebt') && $this->Location->get_info_for_key('enable_credit_card_processing')) {
				?>
                if ($('#ebt_voucher_toggle').is(':checked')) {
                    $("#ebt_voucher").show();
                } else {
                    $("#ebt_voucher").hide();
                }
                <?php } ?>


                <?php
				if (($selected_payment == lang('ebt') || $selected_payment == lang('ebt_cash')) && $this->Location->get_info_for_key('enable_credit_card_processing')) {
				?>
                $("#ebt-balance-buttons").show();
                <?php } ?>


                function selectPayment(e) {
                    showMarkupIfNeeded($(this).data('payment'));
                    e.preventDefault();
                    $.post('<?php echo site_url("sales/set_selected_payment"); ?>', {
                        payment: $(this).data('payment')
                    });
                    $('#payment_types').val($(this).data('payment'));
                    $('#select-mode-3').html('<i class="fa fa-money-bill"></i>' + $(this).data('payment'));
                    <?php if ($this->Location->get_info_for_key('enable_credit_card_processing')) { ?>
                    if ($(this).data('payment') == <?php echo json_encode(lang('integrated_gift_card')) ?> || $(
                            this)
                        .data('payment') == <?php echo json_encode(lang('credit')) ?> || $(this).data(
                        'payment') ==
                        <?php echo json_encode(lang('ebt')) ?> || $(this).data('payment') ==
                        <?php echo json_encode(lang('ebt_cash')) ?>) {
                        $("#credit_card_options").show();
                    } else {
                        $("#credit_card_options").hide();
                    }

                    if ($(this).data('payment') == <?php echo json_encode(lang('ebt')) ?> || $(this).data(
                            'payment') ==
                        <?php echo json_encode(lang('ebt_cash')) ?>) {
                        $("#ebt-balance-buttons").show();
                    } else {
                        $("#ebt-balance-buttons").hide();
                    }
                    if ($(this).data('payment') == <?php echo json_encode(lang('ebt')) ?>) {
                        $("#ebt_voucher_toggle_holder").show();
                    } else {
                        $("#ebt_voucher_toggle_holder").hide();
                    }

                    if ($('#ebt_voucher_toggle').is(':checked') && $(this).data('payment') ==
                        <?php echo json_encode(lang('ebt')) ?>) {
                        $("#ebt_voucher").show();
                    } else {
                        $("#ebt_voucher").hide();
                    }

                    <?php } ?>
                    // start_cc_processing
                    $('.select-payment').removeClass('active');
                    $(this).addClass('active');
                    $("#amount_tendered").focus();
                    $("#amount_tendered").attr('placeholder', '');

                    checkPaymentTypes();

                    if ($(this).data('payment') == <?php echo json_encode(lang('store_account')) ?>) {
                        $("#create_invoice_holder").removeClass('hidden');
                    } else {
                        $("#create_invoice_holder").addClass('hidden');
                    }


                }

                //Add payment to the sale 
                $("#add_payment_button").click(function(e) {
                    e.preventDefault();

                    $('#add_payment_form').ajaxSubmit({
                        target: "#sales_section",
                        beforeSubmit: addPaymentSalesBeforeSubmit
                    });
                });

                $('#select_customer_form').bind('keypress', function(e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        $('#select_customer_form').ajaxSubmit({
                            target: "#sales_section",
                            beforeSubmit: salesBeforeSubmit
                        });
                    }
                });

                $('#add_item_form').ajaxForm({
                    target: "#sales_section",
                    beforeSubmit: salesBeforeSubmit,
                    success: itemScannedSuccess
                });

                $('#add_item_form').bind('keypress', function(e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        localStorage.setItem('item_search_key', $("#add_item_form #item").val());

                        $('#add_item_form').ajaxSubmit({
                            target: "#sales_section",
                            beforeSubmit: salesBeforeSubmit,
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
                            $('#add_payment_form').ajaxSubmit({
                                target: "#sales_section",
                                beforeSubmit: addPaymentSalesBeforeSubmit,
                                complete: function() {
                                    $('#finish_sale_button').trigger('click');
                                }
                            });
                        } else {
                            $('#add_payment_form').ajaxSubmit({
                                target: "#sales_section",
                                beforeSubmit: addPaymentSalesBeforeSubmit
                            });
                        }
                    }
                });

                //Select all text in the input when input is clicked
                $("input:text, textarea").not(".description,#comment,#internal_notes").click(function() {
                    $(this).select();
                });

                // Finish Sale button
                $("#finish_sale_button").click(function(e) {
                    e.preventDefault();

                    var confirm_messages = [];

                    //Prevent double submission of form
                    $("#finish_sale_button").hide();
                    $('#grid-loader').show();


                    <?php if ($this->cart->get_payment_amount(lang('store_account')) > 0) { ?>
                    <?php if ($is_over_credit_limit && $mode != 'store_account_payment' && !$this->config->item('disable_store_account_when_over_credit_limit')) { ?>
                    confirm_messages.push(
                        <?php echo json_encode(lang('sales_over_credit_limit_warning')); ?>);
                    <?php } elseif ($is_over_credit_limit && $mode != 'store_account_payment' && $this->config->item('disable_store_account_when_over_credit_limit')) {
							echo "show_feedback('error', " . json_encode(lang('sales_over_credit_limit_error')) . ", " . json_encode(lang('error')) . ");";
							echo '$("#finish_sale_button").show();';
							echo "$('#grid-loader').hide();";
							echo 'return;';
						} ?>
                    <?php } ?>
                    <?php if (!$payments_cover_total) { ?>
                    confirm_messages.push(
                        <?php echo json_encode(lang('sales_payment_not_cover_total_confirmation')); ?>
                        );
                    <?php } ?>

                    <?php if (!$this->config->item('disable_confirmation_sale')) { ?>
                    confirm_messages.push(
                    <?php echo json_encode(lang("sales_confirm_finish_sale")); ?>);
                    <?php } ?>

                    if (confirm_messages.length) {
                        bootbox.confirm(confirm_messages.join("<br />"), function(result) {
                            if (result) {
                                finishSale();
                            } else {
                                //Bring back submit and unmask if fail to confirm
                                $("#finish_sale_button").show();
                                $('#grid-loader').hide();
                            }
                        });
                    } else {
                        finishSale();
                    }
                });

                <?php if (!$this->config->item('disable_quick_complete_sale')) { ?>

                if ($("#payment_types").val() == <?php echo json_encode(lang('giftcard')); ?>) {
                    $('#finish_sale_alternate_button').removeClass('hidden');
                    $('#add_payment_button').addClass('hidden');
                } else if ($("#payment_types").val() == <?php echo json_encode(lang('points')); ?>) {
                    $('#finish_sale_alternate_button').addClass('hidden');
                    $('#add_payment_button').removeClass('hidden');
                } else {
                    if ((<?php echo $amount_due; ?> >= 0 && $('#amount_tendered').val() >=
                            <?php echo $amount_due; ?>) || (<?php echo $amount_due; ?> < 0 && $(
                                '#amount_tendered')
                            .val() <=
                            <?php echo $amount_due; ?>)) {
                        $('#finish_sale_alternate_button').removeClass('hidden');
                        $('#add_payment_button').addClass('hidden');
                    } else {
                        $('#finish_sale_alternate_button').addClass('hidden');
                        $('#add_payment_button').removeClass('hidden');
                    }
                }

                $('#amount_tendered').on('input', amount_tendered_input_changed);

                $('#finish_sale_alternate_button').on('click', function(e) {
                    e.preventDefault();

                    if (noPaymentSelected()) {
                        return false;
                    }
                    if (!checkRequiredFields()) {
                        return false;
                    }


                    $('#add_payment_form').ajaxSubmit({
                        target: "#sales_section",
                        beforeSubmit: salesBeforeSubmit,
                        complete: function() {
                            $('#finish_sale_button').trigger('click');
                        }
                    });
                });

                <?php } ?>



                function show_grid() {
                    $("#category_item_selection_wrapper").promise().done(function() {
                        $("#category_item_selection_wrapper").slideDown();
                        $('.show-grid').addClass('hidden');
                        $('.hide-grid').removeClass('hidden');
                    });
                }

                function hide_grid() {
                    $("#category_item_selection_wrapper").promise().done(function() {
                        $("#category_item_selection_wrapper").slideUp();
                        $('.hide-grid').addClass('hidden');
                        $('.show-grid').removeClass('hidden');
                    });
                }

                // Show or hide item grid
                $("#show_grid, .show-grid").on('click', function(e) {
                    e.preventDefault();
                    if (!$(':animated').length) {}

                    show_grid();
                });

                $("#hide_grid,#hide_grid_top, .hide-grid").on('click', function(e) {
                    e.preventDefault();
                    if (!$(':animated').length) {}

                    hide_grid();
                });



                // Save credit card info
                $('#save_credit_card_info').change(function() {
                    $.post('<?php echo site_url("sales/set_save_credit_card_info"); ?>', {
                        save_credit_card_info: $('#save_credit_card_info').is(':checked') ?
                            '1' : '0'
                    });
                });

                // Use saved cc info
                $('#use_saved_cc_info').change(function() {
                    $.post('<?php echo site_url("sales/set_use_saved_cc_info"); ?>', {
                        use_saved_cc_info: $('#use_saved_cc_info').is(':checked') ? '1' : '0'
                    });
                });

                // Prompt for cc info (EMV integration only)
                $('#prompt_for_card').change(function() {
                    $.post('<?php echo site_url("sales/set_prompt_for_card"); ?>', {
                        prompt_for_card: $('#prompt_for_card').is(':checked') ? '1' : '0'
                    });
                });

                $('#show_terms_and_conditions').change(function() {
                    $.post('<?php echo site_url("sales/set_show_terms_and_conditions"); ?>', {
                        show_terms_and_conditions: $('#show_terms_and_conditions').is(
                                ':checked') ?
                            '1' : '0'
                    });
                });


                $('#ebt_voucher_toggle').change(function() {
                    if ($('#ebt_voucher_toggle').is(':checked')) {
                        $("#ebt_voucher").show();
                    } else {
                        $("#ebt_voucher").hide();
                    }

                    $.post('<?php echo site_url("sales/set_ebt_voucher"); ?>', {
                        ebt_voucher: $('#ebt_voucher_toggle').is(':checked') ? '1' : '0'
                    });
                });

                <?php if (isset($cart_count)) { ?>
                $('.cart-number').html(<?php echo $cart_count; ?>);
                <?php } ?>


            });
            // end of document ready


            // Re-usable Functions 


            function showMarkupIfNeeded(payment_type) {
                var payments_added = <?php echo json_encode((bool) count($this->cart->get_payments())); ?>;

                if (!payment_type || payments_added) {
                    return;
                }

                $('.markup_predictions').hide();

                var markup_predictions = <?php echo json_encode($markup_predictions); ?>;

                if (markup_predictions.length == 0) {
                    return;
                }

                var amount = markup_predictions[payment_type]['amount'];
                var id = markup_predictions[payment_type]['id'];

                if (amount) {
                    $('#' + id).show();
                }
            }

            function checkPaymentTypes() {
                var paymentType = $("#payment_types").val();

                switch (paymentType) {
                    <?php if (!$this->config->item('prompt_amount_for_cash_sale')) { ?>
                    case <?php echo json_encode(lang('cash')); ?>:
                        $("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
                        $("#amount_tendered").attr('placeholder',
                            <?php echo json_encode(lang('enter') . ' ' . lang('cash') . ' ' . lang('amount')); ?>);
                        break;
                        <?php } else { ?>
                    case <?php echo json_encode(lang('cash')); ?>:
                        $("#amount_tendered").val("");
                        $("#amount_tendered").attr('placeholder',
                            <?php echo json_encode(lang('enter') . ' ' . lang('cash') . ' ' . lang('amount')); ?>);
                        break;
                        <?php } ?>

                    case <?php echo json_encode(lang('check')); ?>:
                        $("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
                        $("#amount_tendered").attr('placeholder',
                            <?php echo json_encode(lang('enter') . ' ' . lang('check') . ' ' . lang('amount')); ?>);
                        break;
                    case <?php echo json_encode(lang('giftcard')); ?>:
                        $("#amount_tendered").val('');
                        $("#amount_tendered").attr('placeholder',
                            <?php echo json_encode(lang('sales_swipe_type_giftcard')); ?>);
                        <?php if (!$this->config->item('disable_giftcard_detection')) { ?>
                        giftcard_swipe_field($("#amount_tendered"));
                        <?php } ?>
                        break;
                    case <?php echo json_encode(lang('debit')); ?>:
                        $("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
                        $("#amount_tendered").attr('placeholder',
                            <?php echo json_encode(lang('enter') . ' ' . lang('debit') . ' ' . lang('amount')); ?>);
                        break;
                    case <?php echo json_encode(lang('credit')); ?>:
                        $("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
                        $("#amount_tendered").attr('placeholder',
                            <?php echo json_encode(lang('enter') . ' ' . lang('credit') . ' ' . lang('amount')); ?>);
                        break;
                    case <?php echo json_encode(lang('store_account')); ?>:
                        $("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
                        $("#amount_tendered").attr('placeholder',
                            <?php echo json_encode(lang('enter') . ' ' . lang('store_account') . ' ' . lang('amount')); ?>
                            );
                        break;
                    case <?php echo json_encode(lang('points')); ?>:
                        $("#amount_tendered").val(
                            <?php echo (isset($number_of_points_to_use) && $number_of_points_to_use) ? $number_of_points_to_use : '""'; ?>
                        );
                        $("#amount_tendered").attr('placeholder',
                            <?php echo json_encode(lang('enter') . ' ' . lang('points') . ' ' . lang('amount')); ?>);
                        break;
                    case <?php echo json_encode(lang('ebt')); ?>:
                        <?php
						if (count($payments) == 0) {
						?>
                        $("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($ebt_total)); ?>);
                        <?php
						}
						?>
                        $("#amount_tendered").attr('placeholder',
                            <?php echo json_encode(lang('enter') . ' ' . lang('ebt') . ' ' . lang('amount')); ?>);
                        break;
                    case <?php echo json_encode(lang('wic')); ?>:
                        <?php
						if (count($payments) == 0) {
						?>
                        $("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($ebt_total)); ?>);
                        <?php
						}
						?>
                        $("#amount_tendered").attr('placeholder',
                            <?php echo json_encode(lang('enter') . ' ' . lang('wic') . ' ' . lang('amount')); ?>);
                        break;
                    case <?php echo json_encode(lang('ebt_cash')); ?>:
                        $("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
                        $("#amount_tendered").attr('placeholder',
                            <?php echo json_encode(lang('enter') . ' ' . lang('ebt_cash') . ' ' . lang('amount')); ?>
                            );
                        break;
                    default:
                        $("#amount_tendered").val(<?php echo json_encode(to_currency_no_money($amount_due)); ?>);
                        $("#amount_tendered").attr('placeholder', <?php echo json_encode(lang('enter')); ?> + ' ' +
                            paymentType + ' ' + <?php echo json_encode(lang('amount')); ?>);
                }

                showMarkupIfNeeded(paymentType);
                <?php if (!$this->config->item('disable_quick_complete_sale')) { ?>
                amount_tendered_input_changed();
                <?php } ?>

            }

            function salesBeforeSubmit(formData, jqForm, options) {
                if (submitting) {
                    return false;
                }
                submitting = true;


                <?php if (isset($cart_count)) { ?>
                $('.cart-number').html(<?php echo $cart_count; ?>);
                <?php } ?>
                $("#ajax-loader").show();
                $("#add_payment_button").hide();
                $("#finish_sale_button").hide();
            }

            function addPaymentSalesBeforeSubmit(formData, jqForm, options) {
                if (submitting) {
                    return false;
                }
                submitting = true;

                if (noPaymentSelected()) {
                    submitting = false;
                    return false;
                }
                // if (!checkRequiredFields()) {
                // 	submitting = false;
                // 	return false;
                // }
                if ($('#amount_tendered').val().length >= 10) {
                    bootbox.confirm(<?php echo json_encode(lang("large_payment_amount")); ?>, function(result) {

                        if (result) {
                            $('#add_payment_form').ajaxSubmit({
                                target: "#sales_section"
                            });
                        }
                    });

                    submitting = false;
                    return false;

                }


                if (<?php echo $amount_due; ?> == 0) {
                    bootbox.confirm(<?php echo json_encode(lang("sales_no_amount_due_confirm")); ?>, function(result) {
                        if (result) {
                            $('#add_payment_form').ajaxSubmit({
                                target: "#sales_section"
                            });
                        }
                    });

                    submitting = false;
                    //Prevent form form submitting
                    return false;
                }

                <?php if (isset($cart_count)) { ?>
                $('.cart-number').html(<?php echo $cart_count; ?>);
                <?php } ?>
                $("#ajax-loader").show();
                $("#add_payment_button").hide();
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

            function finishSale() {
                if ($("#comment").val()) {
                    $.post('<?php echo site_url("sales/set_comment"); ?>', {
                        comment: $('#comment').val()
                    }, function() {
                        $('#finish_sale_form').submit();
                    });
                } else {
                    $('#finish_sale_form').submit();
                }

            }

            <?php
			if (isset($prompt_convert_sale_to_return) && $prompt_convert_sale_to_return == TRUE) {
			?>

            bootbox.confirm({
                message: <?php echo json_encode(lang("sales_confirm_convert_sale_to_return")); ?>,
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
                        $.get('<?php echo site_url("sales/convert_sale_to_return"); ?>', function(
                        response) {
                            $("#sales_section").html(response);
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
                message: <?php echo json_encode(lang("sales_confirm_convert_return_to_sale")); ?>,
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
                        $.get('<?php echo site_url("sales/convert_return_to_sale"); ?>', function(
                        response) {
                            $("#sales_section").html(response);
                        });
                    }
                }
            });

            <?php
			}
			?>

            $("#exchange_to").change(function() {
                var rate = $(this).val();
                $.post('<?php echo site_url("sales/exchange_to"); ?>', {
                    'rate': rate
                }, function(response) {
                    $("#sales_section").html(response);
                });
            });

            $("#delete_sale_button").click(function() {
                bootbox.confirm({
                    message: <?php echo json_encode(lang("sales_confirm_void_delete")); ?>,
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
                            var post_data = [];

                            post_data.push({
                                'name': 'sales_void_and_refund_credit_card',
                                'value': <?php echo json_encode($was_cc_sale); ?>
                            });

                            post_data.push({
                                'name': 'sales_void_and_cancel_return',
                                'value': <?php echo json_encode($was_cc_return); ?>
                            });

                            post_data.push({
                                'name': 'do_delete',
                                'value': 1
                            });

                            post_data.push({
                                'name': 'clear_sale',
                                'value': 1
                            });

                            post_submit(
                                '<?php echo site_url("sales/delete/$sale_id_of_edit_or_suspended_sale"); ?>',
                                'POST', post_data);
                        }
                    }

                });
            });


            <?php
			if ($this->session->userdata('amount_change')) { ?>
            show_feedback('success', <?php echo json_encode($this->session->userdata('manage_success_message')); ?>,
                <?php echo json_encode(lang('change_due') . ': ' . to_currency($this->session->userdata('amount_change'))); ?>, {
                    timeOut: 30000
                });
            <?php
				$this->session->unset_userdata('amount_change');
			}
			?>

            $("#customer_facing_display_link").click(function() {
                $("#customer_facing_display_warning").hide();
                $.get(<?php echo json_encode(site_url('sales/opened_customer_facing_display')); ?>);
            });

            $(".delete-custom-image-sale a").click(function(e) {
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

            function checkRequiredFields() {

                var allFilled = true; // Flag to track if all required fields are filled

                // Iterate over all required input fields and selects within #operationsbox_modal
                $('#operationsbox_modal input[required], #operationsbox_modal select[required]').each(function() {
                    if ($(this).val() === '') {
                        allFilled = false; // Set the flag to false if a field is empty
                    }
                });
                if (!allFilled) {

                    var operationsbox_modal = document.querySelector("#operationsbox_modal");

                    // Check if the drawer instance is already created
                    if (!operationsbox_modal.drawerInstance) {
                        // Create the drawer instance and attach it to the DOM element
                        operationsbox_modal.drawerInstance = KTDrawer.getInstance(operationsbox_modal);
                    }

                    // Show the drawer
                    operationsbox_modal.drawerInstance.show();

                    return false; // Return false to indicate not all required fields are filled
                }

                return true; // Return true if all required fields are filled


            }



            $('.toggle_rows').click(function() {

                $(this).parent().parent().next().toggleClass('collapse');

                if ($(this).parent().parent().next().hasClass("collapse")) {
                    $(this).text("+");
                    $(this).parent().parent().next().addClass("d-none")
                } else {
                    $(this).text("-");
                    $(this).parent().parent().next().removeClass("d-none")
                }



            });
            $("#sale_details_expand_collapse").click(function() {
                $('.register-item-bottom').toggleClass('collapse');

                if ($('.register-item-bottom').hasClass('collapse')) {
                    $.post('<?php echo site_url("sales/set_details_collapsed"); ?>', {
                        value: '1'
                    });
                    $("#sale_details_expand_collapse").text('+');
                    $(".show-collpased").show();

                } else {
                    $.post('<?php echo site_url("sales/set_details_collapsed"); ?>', {
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
                $("#sales_section").load($(this).attr('href'));
            });

            <?php
			$denominations = $this->Register->get_register_currency_denominations()->result();

			$bills = array();
			foreach ($denominations as $denom) {
				if ($denom->value >= 1 && count($bills) <= 8) {
					$bills[] = $denom->value;
				}
			}

			sort($bills);
			?>

            var $bills = <?php echo json_encode($bills, JSON_NUMERIC_CHECK); ?>;

            <?php if (count($bills) > 0) { ?>

            $(".btn-pay").dblclick(function() {
                var $currency_symbol = "<?php echo $this->config->item('currency_symbol'); ?>";
                var $amount_tendered = $("#amount_tendered").val();


                var $possible_amount = get_possible_amount($amount_tendered, $bills);


                var $html = '';

                $.each($possible_amount, function($index, $value) {

                    $html += '<div class="col-md-3" style="margin-bottom:15px;">';
                    $html += '<button tabindex="' + ($index) +
                        '" class="btn btn-primary btn-block quick_amount" data-quick_amount="' +
                        $value +
                        '.00" style="height:50px; border-radius:0px; font-size:16px; font-weight:bold;">' +
                        $currency_symbol + '' + $value + '.00</button>';
                    $html += '</div>';

                });

                $("#quick_cash_holder").html($html);

                $("#choose_quick_cash").modal("show");
            });

            <?php } ?>
            var get_possible_amount = function($sales_amount, $bills) {

                var $found_amount, $get_extra, $key, $bill, $current_bill, $previous_bill, $qutnt, $mod, $quotient,
                    $new_extra_amount, $possible_amount_using_this_bill;

                $sales_amount = Math.ceil($sales_amount);

                $found_amount = [$sales_amount];

                $get_extra = [];

                for ($key in $bills) {
                    $bill = $bills[$key];
                    if ($key == 0) {
                        $get_extra.push(0);
                        continue;
                    } else {
                        $current_bill = $bill;
                        $previous_bill = $bills[$key - 1];

                        $qutnt = $current_bill / $previous_bill;

                        $mod = $current_bill % $previous_bill;

                        if ($mod != 0) {
                            $get_extra.push($previous_bill * Math.ceil($qutnt));
                        } else {
                            $get_extra.push(0);
                        }
                    }
                }

                for ($key in $bills) {
                    $bill = $bills[$key];
                    $quotient = $sales_amount / $bill;

                    if ($sales_amount % $bill == 0) {
                        $new_extra_amount = ($sales_amount - $bill) + $get_extra[$key];
                        if ($new_extra_amount >= $sales_amount && !inArray($new_extra_amount, $found_amount)) {
                            $found_amount.push($new_extra_amount);
                        }
                    }

                    $possible_amount_using_this_bill = $bill * Math.ceil($quotient);

                    if (inArray($possible_amount_using_this_bill, $found_amount)) {
                        continue;
                    }

                    if (isNaN($possible_amount_using_this_bill)) {
                        continue;
                    }

                    $found_amount.push($possible_amount_using_this_bill);
                }

                $found_amount.sort();

                return $found_amount.sort(function(a, b) {
                    return a - b
                });

            }


            function inArray(needle, haystack) {
                var length = haystack.length;
                for (var i = 0; i < length; i++) {
                    if (haystack[i] == needle) return true;
                }
                return false;
            }

            $('#choose_quick_cash').on('shown.bs.modal', function(e) {
                $("#custom_amount").focus();
            });

            $(document).on('click', '.quick_amount', function() {
                var amount_tendered = $(this).data("quick_amount");
                $("#amount_tendered").val(amount_tendered);
                $('#choose_quick_cash').modal('hide');
                $("#finish_sale_alternate_button").trigger('click');
                $("#finish_sale_button").trigger('click');
            });

            $(document).on('keyup', '#custom_amount', function() {
                var amount_tendered = $(this).val();
                $("#collect_amount").data("quick_amount", amount_tendered);
            });

            $(window).keydown(function(event) {
                if (event.ctrlKey && event.which == 81) {
                    $('.btn-pay').trigger("dblclick");
                    event.preventDefault();
                }

                if ($("#custom_amount").focus() && $("#custom_amount").val() > 0 && event.which == 13) {
                    $('#collect_amount').trigger("click");
                    event.preventDefault();
                }
            });

            <?php
			if (isset($update_transaction_display) && $update_transaction_display) {
			?>
            $.get('<?php echo site_url("sales/update_transaction_display"); ?>');
            <?php
			}
			?>

            $(document).ready(function() {

                $(document).on('click', '#kt_app_layout_builder_close', function(event) {
                    $('#kt_drawer_gen_sm').removeClass('drawer-on');
                    $('#kt_drawer_gen_md').removeClass('drawer-on');
                    $('#kt_drawer_gen_lg').removeClass('drawer-on');
                    $('#kt_drawer_gen_xl').removeClass('drawer-on');
                    $('#operationsbox_modal').removeClass('drawer-on');
                    $('#discountbox_modal').removeClass('drawer-on');
                    $('.drawer-overlay').remove();
                    $('body').attr("data-kt-drawer", "off");
                    $('body').attr("data-kt-drawer-null", "off");
                });


                $('body').click(function(event) {

                    // Check if the clicked element is not within the #kt_drawer_gen div
                    if (!$(event.target).closest(
                            '#kt_drawer_gen_sm , #kt_drawer_gen_md , #kt_drawer_gen_lg , #kt_drawer_gen_xl '
                            )
                        .length) {

                        if ($(
                                '#kt_drawer_gen_sm , #kt_drawer_gen_md , #kt_drawer_gen_lg , #kt_drawer_gen_xl  ')
                            .hasClass('drawer-on')) {
                          
                            if ($('body').attr("data-kt-drawer") == "on") {
                                $('#kt_drawer_gen_sm').removeClass('drawer-on');
                                $('#kt_drawer_gen_md').removeClass('drawer-on');
                                $('#kt_drawer_gen_lg').removeClass('drawer-on');
                                $('#kt_drawer_gen_xl').removeClass('drawer-on');
                                $('#operationsbox_modal').removeClass('drawer-on');
                                $('#discountbox_modal').removeClass('drawer-on');
                                $('.drawer-overlay').remove();
                                $('body').attr("data-kt-drawer", "off");
                                $('body').attr("data-kt-drawer-null", "off");
                            }
                        }

                        // If not, trigger an alert

                    }
                });

                <?php if ($this->config->item('allow_drag_drop_sale') && !$this->agent->is_mobile() && !$this->agent->is_tablet()) {  ?>

                $("#register th").on("click", function() {
                    var column = ""
                    if ($(this).hasClass("item_name_heading")) {
                        column = "name";
                    } else if ($(this).hasClass("sales_price")) {
                        column = "price";
                    } else if ($(this).hasClass("sales_quantity")) {
                        column = "quantity";
                    } else if ($(this).hasClass("sales_discount")) {
                        column = "discount";
                    } else if ($(this).hasClass("sales_total")) {
                        column = "total";
                    }
                    if (column == '') return;

                    var type = "asc";
                    if ($(this).hasClass("ion-arrow-down-b")) {
                        type = "desc";
                        $("#register th").removeClass("ion-arrow-down-b");
                        $("#register th").removeClass("ion-arrow-up-b");
                        $(this).addClass("ion-arrow-up-b");
                    } else if ($(this).hasClass("ion-arrow-up-b")) {
                        type = "asc";
                        $("#register th").removeClass("ion-arrow-down-b");
                        $("#register th").removeClass("ion-arrow-up-b");
                        $(this).addClass("ion-arrow-down-b");
                    } else {
                        type = "asc";
                        $("#register th").removeClass("ion-arrow-down-b");
                        $("#register th").removeClass("ion-arrow-up-b");
                        $(this).addClass("ion-arrow-down-b");
                    }
                    $('#grid-loader2').show();
                    $.post('<?php echo site_url("sales/sort"); ?>', {
                        sort_column: column,
                        sort_type: type,
                    }, function(response) {
                        $('#grid-loader2').hide();
                        $("#sales_section").html(response);
                    });
                });

                $(function() {
                    var start_pos = 0;
                    if ($("#register tbody").length > 1) {
                        $("#register").sortable({
                            items: 'tbody',
                            cursor: 'pointer',
                            axis: 'y',
                            dropOnEmpty: false,
                            start: function(e, ui) {
                                ui.item.addClass("selected");
                                var td_width = [];
                                var td_height = [];
                                for (let i = 0; i < $("#register tbody").length; i++) {
                                    if ($($("#register tbody")[i]).hasClass('selected') ||
                                        $($(
                                            "#register tbody")[i]).hasClass(
                                            'ui-sortable-placeholder')) {
                                        continue;
                                    } else {
                                        td_height = $($("#register tbody")[i]).height();
                                        for (let j = 0; j < $($("#register tbody")[i]).find(
                                                ".register-item-details td").length; j++) {
                                            td_width.push($($($("#register tbody")[i]).find(
                                                    ".register-item-details td")[j])
                                                .width());
                                        }
                                        break;
                                    }
                                }
                                $(".ui-sortable-placeholder").html(
                                    "<tr><td>&nbsp;</td></tr>");
                                $(".ui-sortable-placeholder").height(td_height + 'px');
                                for (let k = 0; k < $($("#register tbody.selected tr")[0])
                                    .find(
                                        'td').length; k++) {
                                    $($($("#register tbody.selected tr")[0]).find('td')[k])
                                        .width(
                                            td_width[k] + 'px');
                                }
                                start_pos = $("#register tbody.selected").parent()
                                .children().index(
                                    $("#register tbody.selected"));
                            },
                            stop: function(e, ui) {

                                let current_pos = $("#register tbody.selected").parent()
                                    .children()
                                    .index($("#register tbody.selected"));
                                var drop_index = 0;
                                if (current_pos < start_pos) // up
                                {
                                    drop_index = $("#register tbody.selected").next().data(
                                        'line');
                                } else if (current_pos > start_pos) { // dwon
                                    drop_index = $("#register tbody.selected").prev().data(
                                        'line');
                                } else {
                                    return;
                                }
                                var drag_index = $("#register tbody.selected").data('line');

                                for (let k = 0; k < $($("#register tbody.selected tr")[0])
                                    .find(
                                        'td').length; k++) {
                                    $($($("#register tbody.selected tr")[0]).find('td')[k])
                                        .attr(
                                            'style', '');
                                }
                                ui.item.removeClass("selected");
                                $("#register th").removeClass("ion-arrow-down-b");
                                $("#register th").removeClass("ion-arrow-up-b");

                                if (drag_index != drop_index) {
                                    $('#grid-loader2').show();
                                    $.post('<?php echo site_url("sales/sort"); ?>', {
                                        'drag_index': drag_index,
                                        'drop_index': drop_index,
                                        'sort_column': 'drag_drop',
                                    }, function(response) {
                                        $('#grid-loader2').hide();
                                        $("#sales_section").html(response);
                                    });
                                }
                            },
                            sort: function(e) {
                                $(".ui-sortable-helper").css("width", $("table#register")
                                    .width() +
                                    'px');
                                $(".ui-sortable-helper tr").css("width", $("table#register")
                                    .width() + 'px');
                            }
                        });
                    }
                });
                <?php } ?>
            });

            $(document).ajaxComplete(function() {
                $("#ajax-loader").hide();
                $('.popover').remove();
            });
            </script>