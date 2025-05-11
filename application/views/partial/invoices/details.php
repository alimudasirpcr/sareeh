<style type="text/css">
.payment_heading {
    background: #f4f8fb;
}
</style>

<script src="<?= site_url(); ?>assets/css_good/js/custom/apps/invoices/create.js"></script>
<div class="">
    <h5><strong><?php echo lang('invoices_invoice_details').' - '.lang('invoices_charges')?></strong></h5>
</div>



<div class="" id="invoice_details">
    <div class="row w-100">
        <div class="col-lg-12 item_being_repaired_info_title">
            <h4 class="card-title">
                <?php echo lang("item"); ?></h4>
        </div>

        <div class="col-lg-12">
            <div class="item_search">
                <div class="input-group">
                    <span class="input-group-text">
                        <?php echo anchor("items/view/-1?redirect=work_orders/index/0&progression=1","<i class='icon ti-pencil-alt'></i>", array('class'=>'none add-new-item','title'=>lang('common_new_item'), 'id' => 'new-item', 'tabindex'=> '-1')); ?>
                    </span>

                    <!-- Css Loader  -->
                    <div class="spinner" id="ajax-loader" style="display:none">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                    </div>

                    <input type="text" id="item" name="item" class="add-item-input keyboardTop form-control"
                        placeholder="<?php echo lang('common_start_typing_item_name'); ?>"
                        data-title="<?php echo lang('common_item_name'); ?>">
                    <input type="hidden" id="item_description">
                </div>
            </div>


        </div>

    </div>
    <div class="table-responsive mb-10" id="kt_invoice_form">

        <table class="table d-none" data-kt-element="item-template">
            <tbody>
                <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                    <td class="pe-7">
                        <input type="text" class="form-control form-control-solid mb-2" name="name[]"
                            placeholder="Item name">
                        <input type="hidden" class="form-control form-control-solid mb-2 " name="item_id[]"
                            placeholder="Item name" value="0">
                            <input type="hidden" class="form-control form-control-solid mb-2 " name="variation_id[]"
                            placeholder="Item name" value="0">
                            <input type="hidden" name="is_custom[]"  value="1" >

                    </td>
                    <td class="pe-7">
                        <input type="text" class="form-control form-control-solid mb-2" name="account[]"
                            placeholder="Account">

                    </td>
                    <td class="ps-0 ">
                        <input type="number" class="form-control form-control-solid" value="1" min="1" name="quantity[]" 
                            placeholder="1" data-kt-element="quantity">
                    </td>

                    <td>
                        <input type="text" class="form-control form-control-solid" name="price[]" placeholder="0.00"
                            data-kt-element="price" value="0">
                    </td>
                    <td>
                    <span data-kt-element="total" >0.0</span>
                      
                    </td>

                    <td class="pt-5 text-end">
                        <button type="button" class="btn btn-sm btn-icon btn-active-color-danger"
                            data-kt-element="remove-item">
                            <i class="fa fa-trash fs-3"></i> </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!--begin::Table-->
        <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items" id="items_table">
            <!--begin::Table head-->
            <thead>
                <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                    <th class="min-w-300px w-475px"> <?php echo lang('Item')?></th>
                    <th class="min-w-100px w-475px"> <?php echo lang('Account')?></th>
                    <th class="min-w-100px w-100px"> <?php echo lang('QTY')?></th>
                    <th class="min-w-100px w-100px"> <?php echo lang('Price')?></th>
                    <th class="min-w-150px w-150px"> <?php echo lang('Total')?></th>
                    <?php   if ($can_edit)
					{
					?>
                    <th class="min-w-75px w-75px text-end"><?php echo lang('Action');?></th>
                    <?php } ?>

                </tr>
            </thead>
            <!--end::Table head-->

            <!--begin::Table body-->
            <tbody>
                <?php
    if(isset($details) && !empty($details))
    {
            
            
            foreach($details as $detail) {
					
					//We don't want to show credits here
					if ($detail['total'] < 0)
					{
						continue;
					}
                    $invoice_details_id = $detail['invoice_details_id'];

                    if($detail['description'] !='ordered_sale' ){
                    ?>
                        <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                            <td class="pe-7">
                                <input type="text" class="form-control form-control-solid mb-2 " name="name[]"
                                    placeholder="Item name" value="<?php echo $detail['description'];?>"
                                    <?=  (!$can_edit)? 'readonly':'';  ?>>
                                <input type="hidden" class="form-control form-control-solid mb-2 " name="item_id[]"
                                    placeholder="Item name" value="<?php echo $invoice_details_id; ?>">
                                    <input type="hidden" class="form-control form-control-solid mb-2 " name="variation_id[]"
                                    placeholder="Item name" value="0">
                                <input type="hidden" name="is_custom[]"  value="1" >
                            </td>
                            <td class="pe-7">
                                <input type="text" class="form-control form-control-solid mb-2 "
                                    value="<?php echo $detail['account'];?>" name="account[]"
                                    <?=  (!$can_edit)? 'readonly':'';  ?> placeholder="Account">
                            </td>

                            <td class="ps-0">
                                <input type="number" class="form-control form-control-solid"  min="1" name="quantity[]"
                                    placeholder="1" value="<?php echo $detail['quantity'];?>" data-kt-element="quantity">
                            </td>

                            <td>
                                <input type="text" class="form-control form-control-solid" name="price[]" placeholder="0.00"
                                    value="<?php echo to_currency_no_money($detail['price']);?>" data-kt-element="price"
                                    <?=  (!$can_edit)? 'readonly':'';  ?>>
                            </td>
                            <td>
                            <span data-kt-element="total"><?php echo to_currency($detail['total']);?></span>
                            
                            </td>
                            <?php   if ($can_edit)
                            {
                            ?>

                            <td class="pt-5 text-end">
                                <button  href="<?php echo site_url("invoices/delete_detail/$invoice_type/$invoice_details_id"); ?>" type="button" class="btn btn-sm btn-icon btn-active-color-danger delete-invoice-detail"
                                    data-kt-element="remove-item">
                                    <i class="fa fa-trash fs-3"></i> </button>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>

                <?php
                    if ($detail[$type_prefix.'_id'])
                    {

                        ?>
                <input type="hidden" class="form-control form-control-solid mb-2 " name="sale_id"
                            placeholder="Item name" value="<?php echo $detail[$type_prefix.'_id'];?>">
                        <?php 
                        $the_cart = NULL;
                       
                 
                        if ($type_prefix == 'sale')
                        {
                            $the_cart = PHPPOSCartSale::get_instance_from_sale_id($detail[$type_prefix.'_id']);
                        }
                        else
                        {
                            $the_cart = PHPPOSCartRecv::get_instance_from_recv_id($detail[$type_prefix.'_id']);							
                        }
                    
                        
                        // dd($the_cart->get_tax_total_amount());
                        foreach($the_cart->get_items() as $item)
                        {
                    //  dd($item);
                        $sale_subtotal = $the_cart->get_subtotal(0);

                        $over_all_taxes = $the_cart->get_over_all_taxes();
                    
                        $sale_total = $the_cart->get_total();
                        $sale_tax = $sale_total - $sale_subtotal;

                        
                        
                        
                    ?>
                    <script>
                    $(document).ready(function () {
                            $('.total_tax').html('<?=   to_currency($over_all_taxes + $sale_tax ); ?>');
                    });

                    </script>
                <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                    <td class="pe-7">
                        <input type="text" class="form-control form-control-solid mb-2 " name="name[]"
                            placeholder="Item name" value="<?php echo $item->name;?>"  
                           >
                        <input type="hidden" class="form-control form-control-solid mb-2 " name="item_id[]"
                            placeholder="Item name" value="<?php echo $item->item_id;?>">
                            <input type="hidden" class="form-control form-control-solid mb-2 " name="variation_id[]"
                            placeholder="Item name" value="<?php echo $item->variation_id;?>">
                            <input type="hidden" name="is_custom[]"  value="0" >
                    </td>
                    <td class="pe-7">
                        <input type="text" class="form-control form-control-solid mb-2 "
                            value="<?php echo $detail['account'];?>" name="account[]"
                            <?=  (!$can_edit)? 'readonly':'';  ?> placeholder="Account" >
                    </td>

                    <td class="ps-0">
                        <input type="number" class="form-control form-control-solid"  min="1" name="quantity[]"
                            placeholder="1" value="<?php echo to_quantity($item->quantity);?>" data-kt-element="quantity">
                    </td>

                    <td>
                        <input type="text" class="form-control form-control-solid" name="price[]" placeholder="0.00"
                        value="<?php echo to_quantity($item->unit_price);?>" data-kt-element="price" <?=  (!$can_edit)? 'readonly':'';  ?>>
                    </td>
                    <td>
                    <span data-kt-element="total"><?php echo to_currency($item->unit_price *  $item->quantity);   ?> </span>
                    </td>
                    <?php   if ($can_edit)
					{
					?>

                    <td class="pt-5 text-end">
                        <button type="button" class="btn btn-sm btn-icon btn-active-color-danger  " 
                            data-kt-element="remove-item">
                            <i class="fa fa-trash fs-3"></i> </button>
                    </td>
                    <?php } ?>
                </tr>
                <?php    }
                    
                        
                        ?>

                <?php 
                    }
                }

                
                } ?>
                <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                    <td class="pe-7">
                        <input type="text" class="form-control form-control-solid mb-2" name="name[]"
                            placeholder="<?php echo lang('Item_name');?>">
                        <input type="hidden" class="form-control form-control-solid mb-2 " name="item_id[]"
                            placeholder="<?php echo lang('Item_name');?>" value="0">
                            <input type="hidden" class="form-control form-control-solid mb-2 " name="variation_id[]"
                            placeholder="<?php echo lang('Item_name');?>" value="0">
                            <input type="hidden" name="is_custom[]"  value="1" >

                    </td>
                    <td class="pe-7">
                        <input type="text" class="form-control form-control-solid mb-2" name="account[]"
                            placeholder="<?php echo lang('Account');?>">

                    </td>
                    <td class="ps-0 ">
                        <input type="number" class="form-control form-control-solid" value="1" min="1" name="quantity[]" 
                            placeholder="1" data-kt-element="quantity">
                    </td>

                    <td>
                        <input type="text" class="form-control form-control-solid" name="price[]" placeholder="0.00"
                            data-kt-element="price" value="0">
                    </td>
                    <td>
                    
                    <span data-kt-element="total">0.0</span>
                      
                    </td>

                    <td class="pt-5 text-end">
                        <button type="button" class="btn btn-sm btn-icon btn-active-color-danger"
                            data-kt-element="remove-item">
                            <i class="fa fa-trash fs-3"></i> </button>
                    </td>
                </tr>
                

            </tbody>
            <!--end::Table body-->

            <!--begin::Table foot-->
            <tfoot>
                <tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                    <th class="text-primary">
                        <button type="button" class="btn btn-light-primary py-1" data-kt-element="add-item"><?php echo lang('add_item');?></button>
                    </th>


                </tr>

            </tfoot>
            <!--end::Table foot-->
        </table>
    </div>

    <div class="">
    <h5><strong><?php echo lang('invoices_invoice_details').' - '.lang('invoices_credits')?></strong></h5>
</div>
    <table class="table table-bordered">
        <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
            <?php
					if ($can_edit)
					{
					?>
            <th><?php echo lang('delete');?></th>
            <?php } ?>
            <th><?php echo lang('order_id');?></th>
            <th><?php echo lang('total');?></th>
            <th><?php echo lang('description');?></th>
            <th><?php echo lang('account');?></th>
        </tr>

        <?php foreach($details as $detail) {
					
					//We don't want to show charges here
					if ($detail['total'] > 0)
					{
						continue;
					} 
					
					$invoice_details_id = $detail['invoice_details_id'];
					?>
        <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
            <?php
					if ($can_edit)
					{
					?>
            <td>
                <a class="delete-invoice-detail"
                    href="<?php echo site_url("invoices/delete_detail/$invoice_type/$invoice_details_id"); ?>"><?php echo lang('delete');?></a>
            </td>
            <?php } ?>

            <td><?php echo $detail[$type_prefix.'_id'];?></td>

            <?php
					if ($can_edit)
					{
					?>
            <td>
                <a href="#" id="total_<?php echo $invoice_details_id;?>" class="xeditable xeditable-total"
                    data-validate-number="true" data-type="text"
                    data-value="<?php echo H(to_currency_no_money($detail['total'])); ?>" data-pk="1" data-name="total"
                    data-url="<?php echo site_url("invoices/edit_detail/$invoice_type/$invoice_details_id"); ?>"
                    data-title="<?php echo H(lang('total')); ?>"
                    data-invoice_details_id="<?php echo $invoice_details_id; ?>"><?php echo to_currency($detail['total']); ?></a>
            </td>
            <?php }
					else
					{
					?>
            <td><?php echo to_currency($detail['total']);?></td>
            <?php
					} 
					?>


            <?php
					if ($can_edit)
					{
					?>
            <td>
                <a href="#" id="description_<?php echo $invoice_details_id;?>" class="xeditable xeditable-description"
                    data-type="textarea" data-value="<?php echo H($detail['description']); ?>" data-pk="1"
                    data-name="description"
                    data-url="<?php echo site_url("invoices/edit_detail/$invoice_type/$invoice_details_id"); ?>"
                    data-title="<?php echo H(lang('description')); ?>"
                    data-invoice_details_id="<?php echo $invoice_details_id; ?>"><?php echo $detail['description']; ?></a>
            </td>
            <?php }
					else
					{
					?>
            <td><?php echo $detail['description'];?></td>
            <?php
					} 
					?>

            <?php
					if ($can_edit)
					{
					?>
            <td>
                <a href="#" id="account_<?php echo $invoice_details_id;?>" class="xeditable xeditable-account"
                    data-type="text" data-value="<?php echo H($detail['account']); ?>" data-pk="1" data-name="account"
                    data-url="<?php echo site_url("invoices/edit_detail/$invoice_type/$invoice_details_id"); ?>"
                    data-title="<?php echo H(lang('account')); ?>"
                    data-invoice_details_id="<?php echo $invoice_details_id; ?>"><?php echo $detail['account']; ?></a>
            </td>
            <?php }
					else
					{
					?>
            <td><?php echo $detail['account'];?></td>
            <?php
					} 
					?>

        </tr>
        <?php
						if ($detail[$type_prefix.'_id'])
						{
							$the_cart = NULL;
						
							if ($type_prefix == 'sale')
							{
								$the_cart = PHPPOSCartSale::get_instance_from_sale_id($detail[$type_prefix.'_id']);
							}
							else
							{
								$the_cart = PHPPOSCartRecv::get_instance_from_recv_id($detail[$type_prefix.'_id']);							
							}
						
							echo '<tr><td colspan="100">';
						
							echo '<table class="table table-bordered">';
							echo '<tr><th>'.lang('name').'</th><th>'.lang('quantity').'</th></tr>';
							foreach($the_cart->get_items() as $item)
							{
								echo '<tr><td>'.$item->name.'</td><td>'.to_quantity($item->quantity).'</td></tr>';
							}
						
							echo '</table></td></tr>'
							?>

        <?php } ?>
        <?php } ?>
    </table>
</div>
