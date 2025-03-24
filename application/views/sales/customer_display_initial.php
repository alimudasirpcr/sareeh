<?php $this->load->view("partial/header");
$company = ($company = $this->Location->get_info_for_key('company', isset($override_location_id) ? $override_location_id : FALSE)) ? $company : $this->config->item('company');
$website = ($website = $this->Location->get_info_for_key('website', isset($override_location_id) ? $override_location_id : FALSE)) ? $website : $this->config->item('website');
$company_logo = ($company_logo = $this->Location->get_info_for_key('company_logo', isset($override_location_id) ? $override_location_id : FALSE)) ? $company_logo : $this->config->item('company_logo');
?>
<div id="sales_page_holder" class="card">
	<?php
	if (!$this->agent->is_mobile() || $this->agent->is_tablet()) {

	?>
		<?php if ($this->config->item('announcement_special')): ?>
			<div id="announcement" class="col-md-6 col-sm-6 col-xs-6 text-left">
				<h4><?php echo nl2br($this->config->item('announcement_special')) ?></h4>
			</div>
		<?php endif; ?>

		<div class="col-md-6 col-sm-6 col-xs-6 text-right">
			<ul class="list-unstyled" style="margin-bottom:2px;">
				<?php if ($company_logo) { ?>
					<li class="company-title">
						<?php echo img(array('src' => $this->Appfile->get_url_for_file($company_logo))); ?>
					</li>
				<?php } ?>
				<li class="company-title">
					<h4><?php echo H($company); ?></h4>
				</li>
				<?php if ($website) { ?>
					<li class="company-title"><?php echo H($website); ?></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
	<div id="digital_sig_holder" style="display: none;" class="clearfix">
		<h2><?php echo lang('sales_signature'); ?></h2>
		<canvas id="sig_cnv" name="sig_cnv" class="signature" width="500" height="100"></canvas>
		<div id="sig_actions_container" class="pull-right">


			<button class="btn btn-default btn-radius btn-lg hidden-print" style="font-size:18px" id="capture_digital_sig_clear_button"> <?php echo lang('sales_clear_signature'); ?> </button>
			<button class="btn btn-primary btn-radius btn-lg hidden-print" style="font-size:18px" id="capture_digital_sig_done_button"> <?php echo lang('sales_done_capturing_sig'); ?> </button>
		</div>
		<div id="digital_sig_holder_signature">
		</div>
		<?php if ($this->config->item('enable_tips')) { ?>
			<style>
				.btn-tip {
					font-size: 40px;
					padding: 30px;
				}
			</style>
			<input type="text" class="form-control" style="font-size: 36px; padding: 25px; width: 100%;" placeholder=<?php echo json_encode(lang('tip')); ?> name="tip" id="tip" />
			<div id="tips_buttons" class="text-center">
			</div>
		<?php } ?>
	</div>
	<?php
$font_size = $this->agent->is_mobile() && !$this->agent->is_tablet() ? '50%' : '70%';
?>
	<div id="customer_display_container" class="sales clearfix"><!-- Sales register Clone -->
		<div class="row register" style="font-size: <?php echo $font_size; ?>;">
			<div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 no-padding-right no-padding-left">
				<!-- Register Items. @contains : Items table -->
				<div class="register-box register-items paper-cut">
					<div class="register-items-holder">

						<table id="register" class="table table-hover">

							<thead>
								<tr class="register-items-header">
									<th class="item_name_heading">Item Name</th>
									<th class="sales_price">Price</th>
									<th class="sales_quantity">Quantity</th>
									<th class="sales_discount">Discount Percentage</th>
									<th>Total</th>
								</tr>
							</thead>

							<tbody class="register-item-content">
								<tr class="cart_content_area">
									<td colspan="8">
										<div class="text-center text-warning">
											<h3>No Items In Cart</h3>
										</div>
									</td>
								</tr>
							</tbody>
						</table>

					</div>

					<!-- End of Sales or Return Mode -->
					<!-- End of Store Account Payment Mode -->

				</div>
				<!-- /.Register Items -->
			</div>
			<!-- /.Col-lg-8 @end of left Column -->

			<!-- col-lg-4 @start of right Column -->
			<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 ">
				<!-- If customer is added to the sale -->
				<div class="register-box register-right" id="customer_reg">
					<!-- Customer Badge when customer is added -->
					<div class="customer-badge">
						<div class="avatar">
							<img src="" id="customer_avatar"  onerror="this.onerror=null; this.src='<?php echo base_url() ?>assets/img/user.png';" alt="">
						</div>
						<div class="details">
							<span id="customer_name"></span>
							<br />
							<span class="email" id="customer_email">
							</span>

						</div>
					</div><!-- /.customer-badge -->
				</div>

				<div class="register-box register-summary paper-cut">


					<ul class="list-group">

						<li class="sub-total list-group-item">
							<span class="key">Sub Total:</span>
							<span class="value" id="cart_sub_total">

								OMR0.00
							</span>
						</li>
						<li class="list-group-item">
							<span class="key">
								Tax:
							</span>
							<span class="value pull-right" id="cart_taxes">
								OMR0.00
							</span>
						</li>

					</ul>

					<div class="amount-block">
						<div class="total amount">
							<div class="side-heading">
								Total
							</div>
							<div class="amount total-amount" data-speed="1000" data-currency="OMR" data-decimals="2" id="cart_total">
								OMR0.00
							</div>
						</div>
						<div class="total amount-due">
							<div class="side-heading">
								Amount Due </div>
							<div class="amount" id="cart_amount_due">
								OMR0.00
							</div>
						</div>
					</div>
					<!-- ./amount block -->


				</div>
			</div>
		</div>
		<!-- /.Sales register clone -->
	</div>
	<br /><br />
	<div class="text-center" id="msg_box">
		<?php echo '<h1>' . lang('sales_thank_you_for_shopping_at') . ' ' . $this->config->item('company') . '!</h1>'; ?>
	</div>
</div>
<script id="cart-item-template" type="text/x-handlebars-template">


	<tbody class="fw-bold text-gray-600 register-item-content" data-line="{{index}}">

        <tr class="register-item-details">


            

            <td class="fs-7 px-2">

                {{name}}
            </td>
            <td class="text-center fs-7">
                

                    {{to_currency_no_money price}}						 


            </td>
            <td class="text-center fs-7">
            
                {{to_quantity quantity}}
            
                
              
            </td>
			<td class="fs-7 text-center">

                {{discount_percent}}
            </td>

            <td class="text-center fs-7" style="padding-right:10px">

                {{to_currency_no_money line_total}}


                





                 
            </td>
           

        </tr>
    
    </tbody>
   
</script>
<script>
	Handlebars.registerHelper("to_currency_no_money", function(val) {
		return to_currency_no_money(val);
	});

	Handlebars.registerHelper("to_quantity", function(val) {
		return to_quantity(val);
	});

	Handlebars.registerHelper('select', function(value, options) {
		var $el = $('<select />').html(options.fn(this));
		$el.find('[value="' + value + '"]').attr({
			'selected': 'selected'
		});
		return $el.html();
	});
	Handlebars.registerHelper('greaterThanZero', function(value, options) {
		if (value > 0) {
			return options.fn(this);
		} else {
			return options.inverse(this);
		}
	});
	Handlebars.registerHelper('LessThanZero', function(value, options) {
		if (value < 0) {
			return options.fn(this);
		} else {
			return options.inverse(this);
		}
	});
	Handlebars.registerHelper("checked", function(condition) {
		return (condition) ? "checked" : "";
	});
	Handlebars.registerHelper('conditionCheck', function(condition1, condition2, options) {
		if (condition1 && condition2) {
			return options.fn(this);
		} else {
			return options.inverse(this);
		}
	});
	Handlebars.registerHelper('equal', function(v1, v2, options) {
		return (v1 === v2) ? options.fn(this) : options.inverse(this);
	});
	Handlebars.registerHelper('or', function(v1, v2, options) {
		return (v1 == 1 || v2 == 1) ? options.fn(this) : options.inverse(this);
	});
	Handlebars.registerHelper('lt', function(a, b) {
		return a < b;
	});

	Handlebars.registerHelper('LessThanEqual', function(a, b) {
		return a <= b;
	});

	Handlebars.registerHelper('and', function(v1, v2, options) {
		return (v1 == 1 && v2 == 1) ? options.fn(this) : options.inverse(this);
	});
	Handlebars.registerHelper('not', function(a) {
		return !a; // !undefined evaluates to true
	});

	Handlebars.registerHelper('notval', function(v1, options) {
		return (v1 == 0) ? options.fn(this) : options.inverse(this);
	});


	Handlebars.registerHelper('cost_price_permission', function(v1, v2, v3, v4, options) {

		return (v1 == 0 && v2 == 1 && (v3 == 1 || v4 == 1)) ? options.fn(this) : options.inverse(this);
	});

	Handlebars.registerHelper('supplier_permission', function(v1, v2, options) {

		return (v1 == 0 && v2 == 0) ? options.fn(this) : options.inverse(this);
	});
	Handlebars.registerHelper('sn_check', function(v1, v2, options) {

		return (v1 == 1 && v2 != '<?= lang('giftcard') ?>') ? options.fn(this) : options.inverse(this);


	});
	Handlebars.registerHelper('sn_modal_check', function(v1, v2, options) {
		// console.log("sn_modal_check", v1, v2)
		return ((typeof v1 == 'undefined' || v1 == '') && v2 == 1) ? options.fn(this) : options.inverse(this);


	});
	Handlebars.registerHelper('count', function(v1, options) {
		// Ensure v1 is an array and count its length
		return (Array.isArray(v1) && v1.length > 0) ? options.fn(this) : options.inverse(this);
	});
	var currency_symbol = '<?php echo $this->config->item('currency_symbol'); ?>';
	var cart_item_template = Handlebars.compile(document.getElementById("cart-item-template").innerHTML);
	var sale_id = false;
	customer_display_update();

	function customer_display_update() {
		$(".register-item-content").remove('');
		cart = JSON.parse(localStorage.getItem("cart"));

		var total_qty = 0;
		if (typeof cart['customer'] != 'undefined' && typeof cart['customer']['customer_name'] != 'undefined') {
			$('#customer_name').html(cart['customer']['customer_name']);
			$('#customer_email').html(cart['customer']['email']);
			$('#customer_avatar').attr( 'src' , cart['customer']['avatar']);
			
			$('#customer_reg').show();
		} else {
			$('#customer_name').html('');
			$('#customer_email').html('');
			$('#customer_reg').hide();
		}
		if (typeof cart['items'] != 'undefined' && cart['items'].length > 0) {

			
			for (var k = 0; k < cart['items'].length; k++) {

				var cart_item = cart['items'][k];
				if (cart_item['quantity'] > 0) {
					total_qty = total_qty + parseInt(cart_item['quantity']);
				}


				cart['items'][k]['line_total'] = cart_item['price'] * cart_item['quantity'] - cart_item['price'] * cart_item[
					'quantity'] * cart_item['discount_percent'] / 100;


				cart['items'][k]['index'] = k;


				// console.log("length " , cart_item['selected_rule'].length);
				if (typeof cart_item['selected_rule'] != 'undefined' && typeof cart_item['selected_rule'].length ==
					'undefined') {

					cart['extra']['permission_edit_sale_price'] = 0;
					if (typeof cart['items'][k]['permissions'] !== 'undefined' &&
						typeof cart['items'][k]['permissions']['allow_price_override_regardless_of_permissions'] !== 'undefined'
					) {

						// Set 'allow_price_override_regardless_of_permissions' to 0 if it exists
						cart['items'][k]['permissions']['allow_price_override_regardless_of_permissions'] = 0;
					}

					cart['items'][k]['tier_id'] = 0;
				}

				// console.log( cart['extra']['permission_edit_sale_price']);

				cart['items'][k]['permission_edit_sale_price'] = (cart['extra']['permission_edit_sale_price']) ? cart['extra'][
					'permission_edit_sale_price'
				] : 0;


				$("#register").prepend(cart_item_template(cart['items'][k]));


			}

			$('#customer_display_container').show();
			$('#msg_box').hide();
		} else {
			$('#customer_display_container').hide();
			$('#msg_box').show();
		}


		cart_sub_total = localStorage.getItem("cart_sub_total");
		if (typeof cart_sub_total == "undefined") {
			cart_sub_total = 0;
		}
		$('#cart_sub_total').html(currency_symbol + '' + to_currency_no_money(cart_sub_total));

		cart_taxes = localStorage.getItem("cart_taxes");
		if (typeof cart_taxes == "undefined") {
			cart_taxes = 0;
		}
		$('#cart_taxes').html(currency_symbol + '' + to_currency_no_money(cart_taxes));

		cart_total = localStorage.getItem("cart_total");
		if (typeof cart_taxes == "cart_total") {
			cart_total = 0;
		}
		$('#cart_total').html(currency_symbol + '' + to_currency_no_money(cart_total));

		cart_amount_due = localStorage.getItem("cart_amount_due");
		if (typeof cart_taxes == "cart_amount_due") {
			cart_amount_due = 0;
		}
		$('#cart_amount_due').html(currency_symbol + '' + to_currency_no_money(cart_amount_due));

		setTimeout(customer_display_update, 1000);

		// $("#customer_display_container").load('<?php echo site_url('sales/customer_display_update/' . $register_id); ?>', function()
		// {

		// 	// setTimeout(customer_display_update, 1000);
		// 	// $.get('<?php echo site_url('sales/customer_display_info/' . $register_id); ?>', function(json)
		// 	// {
		// 	// 	if (json.sale_id)
		// 	// 	{
		// 	// 		sale_id = json.sale_id;
		// 	// 		if (json.signature_needed)
		// 	// 		{
		// 	// 			$("#digital_sig_holder").show();
		// 	// 		}
		// 	// 	}
		// 	// 	else
		// 	// 	{
		// 	// 		$("#digital_sig_holder_signature").empty();
		// 	// 		$("#digital_sig_holder").hide();
		// 	// 	}
		// 	// 	render_tips_buttons();
		// 	// 	setTimeout(customer_display_update, 1000);	

		// 	// },'json').fail(function() 
		// 	// {
		// 	// 	setTimeout(customer_display_update, 1000);
		// 	// });
		// });
	}
	$(document).on('click', "#email_receipt", function() {
		$.get($(this).attr('href'), function() {
			show_feedback('success', <?php echo json_encode(lang('receipt_sent')); ?>, <?php echo json_encode(lang('success')); ?>);

		});

		return false;
	});

	$(document).ready(function() {

		$(window).load(function() {
			setTimeout(function() {
				salesRecvFullScreen();
			}, 0);
		});
	});


	var sig_canvas = document.getElementById('sig_cnv');
	var signaturePad = new SignaturePad(sig_canvas);

	$("#capture_digital_sig_button").click(function() {
		signaturePad.clear();
		$("#capture_digital_sig_button").hide();
	});

	$("#capture_digital_sig_clear_button").click(function() {
		signaturePad.clear();
	});

	$("#capture_digital_sig_done_button").click(function() {
		SigImageCallback(signaturePad.toDataURL().split(",")[1]);
		$("#capture_digital_sig_button").show();
	});

	function SigImageCallback(str) {
		if (sale_id) {
			$.post('<?php echo site_url('sales/sig_save/' . $register_id); ?>', {
				sale_id: sale_id,
				image: str
			}, function(response) {
				if ($("#tip").val()) {
					$.post('<?php echo site_url('sales/save_tip/'); ?>' + sale_id, {
						tip: $("#tip").val()
					}, function(response) {
						$("#ajax_responses").html(response);
					});
				}

				$("#digital_sig_holder_signature").html('<img src="' + SITE_URL + '/app_files/view_cacheable/' + response.file_id + '?timestamp=' + response.file_timestamp + '" width="250" />');
				signaturePad.clear();
			}, 'json');
		} else {
			bootbox.alert(<?php echo json_encode(lang('sales_cannot_sign')); ?>);
			signaturePad.clear();
		}

	}

	var total;

	function render_tips_buttons() {
		var updated_total = $('input[name=sale_total]').val();
		if (total && ((total >= 10 && updated_total >= 10) || (total < 10 && updated_total < 10))) return;
		total = updated_total;
		var html = '<div class="btn-group">';
		if (total >= 10) {
			html += '<button type="button" class="btn btn-default btn-tip" ref="0">' + <?php echo json_encode(lang('sales_no_tip')); ?> + '</button>';
			html += '<button type="button" class="btn btn-default btn-tip" ref="15">15%</button>';
			html += '<button type="button" class="btn btn-default btn-tip" ref="20">20%</button>';
			html += '<button type="button" class="btn btn-default btn-tip" ref="25">25%</button>';
		} else {
			html += '<button type="button" class="btn btn-default btn-tip" ref="0">' + <?php echo json_encode(lang('sales_no_tip')); ?> + '</button>';
			html += '<button type="button" class="btn btn-default btn-tip" ref="1">' + <?php echo json_encode(to_currency(1)); ?> + '</button>';
			html += '<button type="button" class="btn btn-default btn-tip" ref="2">' + <?php echo json_encode(to_currency(2)); ?> + '</button>';
			html += '<button type="button" class="btn btn-default btn-tip" ref="3">' + <?php echo json_encode(to_currency(3)); ?> + '</button>';
		}
		html += '</div>';
		$('#tips_buttons').html(html);

		$('.btn-tip').on('click', function() {
			$('.btn-tip').removeClass('active');
			$(this).addClass('active');

			var value = $(this).attr('ref');
			var tip = $('#tip');
			var text = '';
			if (value > 0 && value < 10) {
				text = Math.round(value, 2).toFixed(2);
			} else if (value >= 10) {
				text = Math.round(total * value / 100, 2).toFixed(2);
			}
			tip.val(text);
		})
	}
</script>

<div id="ajax_responses"></div>
<?php $this->load->view("partial/footer"); ?>