<div class="modal-content">
    <div class="modal-header">
        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-dismiss="modal" aria-label="Close">
            <span class="svg-icon svg-icon-1">x</span>
        </div>
        <!--end::Close-->


        <h3 class="modal-title">Store Account Payment</h3>


    </div>
    <div class="modal-body">
        <div class="table-responsive">
            <table id="register" class="table table-hover  table-striped">

                <thead>
                    <tr class="register-items-header">
                        <th><?php echo lang('sales_item_name'); ?></th>
                        <th><?php echo lang('payment_amount'); ?></th>
                        <?php if (!empty($unpaid_store_account_sales)) { ?>
                        <th>&nbsp;</th>
                        <?php
						} ?>
                    </tr>
                </thead>
                <tbody id="cart_contents">
                    <?php
                        $total_amount =0;
						foreach (array_reverse($cart_items, true) as $line => $item) {
                            $total_amount = $total_amount + $item->unit_price;
			?>

                    <tr id="reg_item_top">
                        <td class="text text-center text-success"><a tabindex="-1"
                                href="<?php echo isset($item->item_id) ? site_url("home/view_item_modal/" . $item->item_id) : site_url('home/view_item_kit_modal/' . $item->item_kit_id . "?redirect=sales"); ?>"
                                data-target="#kt_drawer_general" data-target-title="<?= lang('view_item') ?>"
                                data-target-width="xl"><?php echo H($item->name); ?></a></td>
                        <td class="text-center">
                            <?php
							echo form_open("sales/edit_item/$line", array('class' => 'line_item_form', 'autocomplete' => 'off'));

						?>
                            <a href="#" id="price_<?php echo $line; ?>" class="xeditable" data-validate-number="true"
                                data-type="text"
                                data-value="<?php echo H(to_currency_no_money($item->unit_price, 10)); ?>" data-pk="1"
                                data-name="unit_price" data-url="<?php echo site_url('sales/edit_item_speedy/' . $line); ?>"
                                data-title="<?php echo H(lang('price')); ?>"><?php echo to_currency_no_money($item->unit_price, 10); ?></a>
                            <?php
							echo form_hidden('quantity', to_quantity($item->quantity));
							echo form_hidden('description', '');
							echo form_hidden('serialnumber', '');
						?>

                            </form>
                        </td>
                        <?php if (!empty($unpaid_store_account_sales)) {
								$pay_all_btn_class = count($paid_store_account_ids) > 0 ? 'btn-danger' : 'btn-primary';
								$pay_all_btn_text = count($paid_store_account_ids) > 0 ? lang('unpay_all') : lang('pay_all');
					?>
                        <td>
                            <button id="pay_or_unpay_all" type="button"
                                class="btn <?php echo $pay_all_btn_class; ?>  pull-right"><?php echo $pay_all_btn_text ?></button>
                        </td>
                        <?php } ?>
                    </tr>



                    <?php } /*Foreach*/ ?>
                </tbody>
            </table>
        </div>
        <?php
				
					if (!empty($unpaid_store_account_sales)) {
				?>
        <table id="unpaid_sales" class="table table-hover ">
            <thead>
                <tr class="register-items-header">
                    <th class="sp_sale_id"><?php echo lang('sale_id'); ?></th>
                    <th class="sp_date"><?php echo lang('date'); ?></th>
                    <th class="sp_charge"><?php echo lang('total_charge_to_account'); ?></th>
                    <th class="sp_comment"><?php echo lang('comment'); ?></th>
                    <th class="sp_pay"><?php echo lang('pay'); ?></th>
                </tr>
            </thead>

            <tbody id="unpaid_sales_data">

                <?php
								foreach ($unpaid_store_account_sales as $unpaid_sale) {

									$row_class = isset($unpaid_sale['paid']) && $unpaid_sale['paid'] == TRUE ? 'success' : 'active';
									$btn_class = isset($unpaid_sale['paid']) && $unpaid_sale['paid'] == TRUE ? 'btn-danger' : 'btn-primary';
								?>
                <tr class="<?php echo $row_class; ?>">
                    <td class="sp_sale_id text-center">
                        <?php echo anchor('sales/receipt/' . $unpaid_sale['sale_id'], ($this->config->item('sale_prefix') ? $this->config->item('sale_prefix') : 'POS') . ' ' . $unpaid_sale['sale_id'], array('target' => '_blank')); ?>
                    </td>
                    <td class="sp_date text-center">
                        <?php echo date(get_date_format() . ' ' . get_time_format(), strtotime($unpaid_sale['sale_time'])); ?>
                    </td>
                    <td class="sp_charge text-center">
                        <?php
											if (isset($exchange_name) && $exchange_name) {
												echo to_currency_as_exchange($cart, $unpaid_sale['payment_amount'] * $exchange_rate);
											} else {
												echo to_currency($unpaid_sale['payment_amount']);
											}
											?>
                    </td>
                    <td class="sp_comment text-center"><?php echo $unpaid_sale['comment'] ?></td>
                    <td class="sp_pay text-center">

                        <a href="<?php echo  site_url("sales/" . ((isset($unpaid_sale['paid']) && $unpaid_sale['paid'] == TRUE) ? "delete" : "pay") . "_store_account_sale/" . $unpaid_sale['sale_id'] . "/" . to_currency_no_money($unpaid_sale['payment_amount'])) ?>"
                            class="btn <?php echo $btn_class; ?> pay_store_account_sale"><?php echo isset($unpaid_sale['paid']) && $unpaid_sale['paid'] == TRUE  ? lang('remove_payment') : lang('pay'); ?></a>

                    </td>
                </tr>
                <?php
								}
							}


							?>
            </tbody>
        </table>
                <input type="hidden" id="total_amount" value="<?php echo $total_amount; ?>">
                <input type="hidden" id="payment_types" value="Cash">
               
    

    <div class="modal-footer">

    <div class="input-group-text register-mode sale-mode dropup">


<a tabindex="-1" href="#" class="none active text-light  text-hover-primary payment_option_selected"
    title="Sales Sale" id="select-mode-3" data-target="#" data-toggle="dropdown"
    aria-haspopup="true" role="button" aria-expanded="false"><i
        class="fa fa-money-bill"></i>
    Cash </a>



<ul class="dropdown-menu sales-dropdown">
    <?php
    $default_payment_type ='Cash';
    
    foreach ($payment_options as $key => $value) {
    
    $active_payment =  ($default_payment_type == $value) ? "selected" : "";
?>
    <li> <a tabindex="-1" href="#"
            class="btn btn-pay select-payment <?php echo $active_payment; ?>"
            data-payment="<?php echo H($value); ?>"> <i
                class="fa fa-money-bill"></i>
            <?php echo H($value); ?>
        </a> </li>
    <?php } ?>



</ul>
</div>
       
        <button type="button" id="comp_sale" class="btn btn-primary"><?php echo lang('complete_sales')?></button>
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
    </div>
</div>

<script>
$(document).ready(function() {

    $('.xeditable').editable({
							validate: function(value) {
								if ($.isNumeric(value) == '' && $(this).data('validate-number')) {
									return <?php echo json_encode(lang('only_numbers_allowed')); ?>;
								}
							},
							success: function(response, newValue) {
								last_focused_id = $(this).attr('id');
                                $("#pay_now_content").html(response);
							},
							savenochange: true
						});


    function selectPayment(e) {
    e.preventDefault();
    $('#payment_types').val($(this).data('payment'));
    $('.select-payment').removeClass('active');
    $(this).addClass('active');
    $('.payment_option_selected').html('<i class="fa fa-money-bill"></i> '+$(this).data('payment'));
}
    $('.select-payment').on('click mousedown', selectPayment);



    $("#comp_sale").click(function(e) {
    e.preventDefault();
    if($('#total_amount').val() != 0){
    // First POST request
    $.post('<?php echo site_url("sales/add_payment"); ?>', {
        payment_type: $('#payment_types').val(),
        amount_tendered: $('#total_amount').val()
    }, function(response) {
           
       
    }, 'json').always(function() {
             $.post('<?php echo site_url("sales/complete/1"); ?>', {}, function(response) {

            

        }, 'json').always(function() {
                    $.ajax({
                    url: '<?php echo site_url("customers/pay_now/").$customer_id; ?>',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        // $("#pay_now").modal("show");
                        $("#pay_now_content").html(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors that occur during the AJAX request
                        console.error('An error occurred: ' + error);
                    }
                });
        });
    });

}
    
});

    $(".pay_store_account_sale").click(function(e) {
        e.preventDefault();


        $.ajax({
            url: $(this).attr("href"),
            type: 'POST',
            processData: false,
            contentType: false,
            success: function(response) {

                // $("#pay_now").modal("show");
                $("#pay_now_content").html(response);
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the AJAX request
                console.error('An error occurred: ' + error);
            }
        });

    });

    $("#pay_or_unpay_all").click(function(e) {
        e.preventDefault();


        $.ajax({
            url: '<?php echo site_url("sales/toggle_pay_all_store_account"); ?>',
            type: 'POST',
            processData: false,
            contentType: false,
            success: function(response) {

                // $("#pay_now").modal("show");
                $("#pay_now_content").html(response);
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the AJAX request
                console.error('An error occurred: ' + error);
            }
        });

    });
});
</script>