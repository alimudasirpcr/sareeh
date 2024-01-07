<script>


     <?php   $CI =& get_instance(); 

     //**********Tax code start *********//
$CI->load->model('Tax_class');
     $store_config_tax_class = $this->config->item('tax_class_id');
		
		if ($store_config_tax_class)
		{
			$return =  $CI->Tax_class->get_taxes($store_config_tax_class);
		}else{
		
            //Global Store Config
            $default_tax_1_rate = $this->config->item('default_tax_1_rate');
            $default_tax_1_name = $this->config->item('default_tax_1_name');
                    
            $default_tax_2_rate = $this->config->item('default_tax_2_rate');
            $default_tax_2_name = $this->config->item('default_tax_2_name');
            $default_tax_2_cumulative = $this->config->item('default_tax_2_cumulative') ? $this->config->item('default_tax_2_cumulative') : 0;
            
            $default_tax_3_rate = $this->config->item('default_tax_3_rate');
            $default_tax_3_name = $this->config->item('default_tax_3_name');
            
            $default_tax_4_rate = $this->config->item('default_tax_4_rate');
            $default_tax_4_name = $this->config->item('default_tax_4_name');
            
            $default_tax_5_rate = $this->config->item('default_tax_5_rate');
            $default_tax_5_name = $this->config->item('default_tax_5_name');
            
            $return = array();
            
            if ($default_tax_1_rate && is_numeric($default_tax_1_rate))
            {
                $return[] = array(
                    'id' => -1,
                    'item_id' => $item_id,
                    'name' => $default_tax_1_name,
                    'percent' => $default_tax_1_rate,
                    'cumulative' => 0
                );
            }
            
            if ($default_tax_2_rate && is_numeric($default_tax_2_rate))
            {
                $return[] = array(
                    'id' => -1,
                    'item_id' => $item_id,
                    'name' => $default_tax_2_name,
                    'percent' => $default_tax_2_rate,
                    'cumulative' => $default_tax_2_cumulative
                );
            }

            if ($default_tax_3_rate && is_numeric($default_tax_3_rate))
            {
                $return[] = array(
                    'id' => -1,
                    'item_id' => $item_id,
                    'name' => $default_tax_3_name,
                    'percent' => $default_tax_3_rate,
                    'cumulative' => 0
                );
            }

            if ($default_tax_4_rate && is_numeric($default_tax_4_rate))
            {
                $return[] = array(
                    'id' => -1,
                    'item_id' => $item_id,
                    'name' => $default_tax_4_name,
                    'percent' => $default_tax_4_rate,
                    'cumulative' => 0
                );
            }

            if ($default_tax_5_rate && is_numeric($default_tax_5_rate))
            {
                $return[] = array(
                    'id' => -1,
                    'item_id' => $item_id,
                    'name' => $default_tax_5_name,
                    'percent' => $default_tax_5_rate,
                    'cumulative' => 0
                );
            }
        }
        $get_taxes_offline = $CI->cart->get_taxes_offline();
        ?>

        localStorage.setItem('tax_class', JSON.stringify(<?php echo json_encode($return); ?>));

       const $currency_symbol = "<?php echo $this->config->item('currency_symbol'); ?>";
       const configDecimals = "<?php echo $this->config->item('number_of_decimals'); ?>";
       const decimalPoint = "<?php echo $this->config->item('decimal_point'); ?>";

       localStorage.setItem('amount_paid', 0);

       localStorage.setItem('get_taxes_offline', JSON.stringify(<?php echo json_encode($get_taxes_offline); ?>));
     
        cumulative_percent = 0
      <?php   if ($CI->Location->get_info_for_key('tax_cap'))
		{ ?>
            var tax_cap = '<?php echo $CI->Location->get_info_for_key('tax_cap'); ?>';

            <?php   }else{ ?>

            var tax_cap = 0;

     <?php   } ?>
     function update_tax_item() {
            const cart = JSON.parse(localStorage.getItem('cart_oc')) || [];
            const getTaxesOffline = JSON.parse(localStorage.getItem('get_taxes_offline')) || {};
            const taxClass = JSON.parse(localStorage.getItem('tax_class')) || [];
            const defaultTaxPercent = taxClass.length > 0 ? parseFloat(taxClass[0].percent) : 0;

            cart.forEach(item => {
                let taxInfo = getTaxesOffline[item.id] && getTaxesOffline[item.id][item.id];
                item.tax = taxInfo && taxInfo['percent'] !== undefined ? taxInfo['percent'] : defaultTaxPercent;
            });

            localStorage.setItem('cart_oc', JSON.stringify(cart));
        }
    //  function update_tax_item(){
    //     let cart = JSON.parse(localStorage.getItem('cart_oc'));
    //     let get_taxes_offline = JSON.parse(localStorage.getItem('get_taxes_offline'));
    //     let tax_class = JSON.parse(localStorage.getItem('tax_class'));
    //     cart.forEach(function(item, index) {
    //                 if(get_taxes_offline[item.id]!== undefined){
    //                     if(get_taxes_offline[item.id][item.id]!== undefined){
    //                         if(get_taxes_offline[item.id][item.id]['percent']!== undefined){
    //                             item.tax = get_taxes_offline[item.id][item.id]['percent'];
    //                         }else{
    //                     if(tax_class.length>0){
    //                         item.tax = parseFloat(tax_class[0].percent);
    //                     }
    //                 }
    //                     }else{
    //                     if(tax_class.length>0){
    //                         item.tax = parseFloat(tax_class[0].percent);
    //                     }
    //                 }
    //                 }else{
    //                     if(tax_class.length>0){
    //                         item.tax = parseFloat(tax_class[0].percent);
    //                     }
    //                 }

    //     });
    //       localStorage.setItem('cart_oc', JSON.stringify(cart));
    // }


    update_tax_item();
    function get_taxes() {
    const cart = JSON.parse(localStorage.getItem('cart_oc')) || [];
    let taxAmount = { tax_included: 0, not_included: 0 };
    let total = 0;

    cart.forEach(item => {
        const netPrice = item.price * item.qty * (1 - item.discount / 100);
        total += netPrice;

        let itemTax = 0;
        if (item.tax > 0) {
            itemTax = netPrice * item.tax / 100;

            const taxCap = parseFloat(localStorage.getItem('tax_cap')) || 0;
            if (taxCap > 0 && itemTax > taxCap) {
                itemTax = taxCap;
            }

            if (item.tax_included) {
                taxAmount.tax_included += itemTax;
            } else {
                taxAmount.not_included += itemTax;
            }
        }
    });

    return taxAmount;
}
//    function get_taxes(cumulative_percent=0){

//     let cart = JSON.parse(localStorage.getItem('cart_oc'));
//     let tax_class = JSON.parse(localStorage.getItem('tax_class'));
//         let tot =0;
//         $tax_amount= [];
//         $tax_amount['tax_included'] =0;
//         $tax_amount['not_included'] =0;
//         $total =0;
//         cart.forEach(function(item, index) {
//                 $total =    $total  + (item.price * item.qty - item.price * item.qty * item.discount / 100);
//                 if(item.tax > 0){
//                     current_tax = item.tax ;
                   
//                 }

//                 if(current_tax > 0){
//                         $item_tax= ( (item.price*item.qty-item.price*item.qty*item.discount/100)*((current_tax)/100) ); //300
//                 }
                               

//               // console.log('$item_tax' ,$item_tax );
//                //console.log('$tax_cap' ,tax_cap );
//                 if(tax_cap >0  &&  $item_tax >  tax_cap){
//                     $item_tax =  tax_cap;
//                 }
//                 if(item.tax_included){
//                     $tax_amount['tax_included'] =  $tax_amount['tax_included'] + parseFloat($item_tax);
//                 }else{
//                     $tax_amount['not_included'] =  $tax_amount['not_included'] + parseFloat($item_tax);
//                 }
                
//         });

//         //console.log($tax_amount );
//         return $tax_amount;
       
//    }

//**********Tax code end *********//
//**********discount code start *********//
function updateItemdiscountToCart(itemIndex, $discount) {
        let cart = JSON.parse(localStorage.getItem('cart_oc'));


        if (parseInt(itemIndex) !== -1) {

            if(!cart[parseInt(itemIndex)].can_override_price_adjustments & cart[parseInt(itemIndex)].max_discount!=='NULL' && parseFloat($discount) > parseFloat(cart[parseInt(itemIndex)].max_discount))
                    {
                            $discount = cart[parseInt(itemIndex)].max_discount;
                    }


            cart[parseInt(itemIndex)].discount = parseFloat($discount);

            localStorage.setItem('is_cart_oc_updated', 1);
            localStorage.setItem('cart_oc', JSON.stringify(cart));
            update_cart_ui();
        } else {
            console.log("updateItemqtyToCart: item not found");
        }

    }

        
//**********discount code end *********//


    function initializeCart() {
        if (localStorage.getItem('cart_oc') === null) {
            localStorage.setItem('cart_oc', JSON.stringify([]));
        }
        if (localStorage.getItem('is_cart_oc_updated') === null) {
            localStorage.setItem('is_cart_oc_updated', 0);
        }
        if (localStorage.getItem('lastUpdated') === null) {
            localStorage.setItem('lastUpdated', Date.now());
        }
        if (localStorage.getItem('cart_oc_all_discount') === null) {
            localStorage.setItem('cart_oc_all_discount', 0);
        }
    }

    function clear_cart(){
        localStorage.setItem('cart_oc', JSON.stringify([]));
        localStorage.setItem('is_cart_oc_updated', 0);
        localStorage.setItem('lastUpdated', null);
        localStorage.setItem('cart_oc_all_discount', 0);
        localStorage.setItem('amount_paid', 0);
        
    }

    function toCurrencyNoMoney(number, decimals = 2, useDefinedDecimalPoint = false) {
  
        number = parseFloat(number);
    if (isNaN(number)) {
        return '0'; // or handle the error as you see fit
    }

    let decimalsToUse = decimals;
    let systemDecideDecimals = true;

    // Only use override if decimals passed in is less than 5 and we have a config decimal override
    if (decimals <= 5 && configDecimals !== null && configDecimals !== '') {
        decimalsToUse = parseInt(configDecimals, 10);
        systemDecideDecimals = false;
    }

    let formattedNumber = number.toFixed(decimalsToUse);
    if (useDefinedDecimalPoint && decimalPoint !== '.') {
        formattedNumber = formattedNumber.replace('.', decimalPoint);
    }

    if (systemDecideDecimals && decimals >= 2) {
        return Math.round(formattedNumber.replace(/(\.\d*?[1-9])0+$/, '$1').replace(/\.$/, ''));
    } else {
        return Math.round(formattedNumber);
    }
}

    initializeCart();

    function update_cart_ui() {
        let cart = JSON.parse(localStorage.getItem('cart_oc'));
        let paid_amount = localStorage.getItem('amount_paid');
        let tot =0;
        let subtotal =0 ;
        let total =0;
        let amount_due =0;
        cart.forEach(function(item, index) {

            // Access item properties like item.id, item.price, item.qty
            // console.log(`ID: ${item.id}, Price: ${item.price}, Quantity: ${item.qty}`);
            $('#quantity_' + index).html(item.qty);
            $total =  item.price * item.qty - item.price * item.qty * item.discount / 100;
            $('#total_' + index).html($currency_symbol +toCurrencyNoMoney( $total));
             tot = tot + item.qty;
            // You can perform more operations inside this block

            subtotal = subtotal +  $total;
        });
         tax = get_taxes();


         total = subtotal +  tax['not_included'];;
       
         subtotal = subtotal - tax['tax_included'];
         amount_due = total  - paid_amount;
        console.log('subtotal' , paid_amount);
        $('#subtotal').html($currency_symbol + toCurrencyNoMoney(subtotal));
        $('.total_items_badge').html(cart.length); 
        $('.total_qty_badge').html(tot); 
        $('.total-amount').html($currency_symbol + toCurrencyNoMoney(total));

        $('#amount-due').html($currency_symbol + toCurrencyNoMoney(amount_due));
        $('#amount_tendered').val(Math.round(amount_due));
        
    }
    function add_cart_update_ui(id,name,price,qty , line) {
     
        $html='<tbody class="fw-bold text-gray-600" data-line="'+line+'"><tr class="register-item-details"><td class="text-center  fs-6"><span class="toggle_rows btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" style="position:relative"><span class="svg-icon svg-icon-3 m-0 toggle-off"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor"></rect><rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>	</svg></span><span class="svg-icon svg-icon-3 m-0 toggle-on"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>	</svg></span></span> &nbsp;</td>	<td class="fs-6">'+name+'</td><td class="text-center fs-6">	'+$currency_symbol+''+price+'</td><td class="text-center fs-6" id="quantity_'+line+'">	'+qty+'	</td>	<td class="text-center fs-6" style="padding-right:10px">'+$currency_symbol+''+price*qty+'<a href="<?php echo site_url("sales/delete_item"); ?>/'+line+'" class="delete-item pull-right" data-id="'+line+'" tabindex="-1"><i class="icon ion-android-cancel"></i></a>	</td></tr></tbody>';
        $('#register').prepend( $html);

    }

    function update_cart_for_all_discount_percent(value ){
        let cart = JSON.parse(localStorage.getItem('cart_oc'));
        should_update = true;
        cart.forEach(function(item, index) {
                if(item.id !=990099009900){
                    if(parseFloat(item.max_discount)  < parseFloat(value) ){ 
                        should_update = false;
                    }else{
                        item.discount =  parseFloat(value);
                    }
                }
        });
        if(should_update){
            localStorage.setItem('cart_oc_all_discount', value);
            localStorage.setItem('cart_oc', JSON.stringify(cart));
            update_cart_ui();
        }
        
    }

    function addItemToCart(itemId, price, qty ,name ='' ,  override_default_tax = 0, tax_included=0 , tax_percent = 0 , can_override_price_adjustments=0 , max_discount=0) {
        let cart = JSON.parse(localStorage.getItem('cart_oc'));

        let containsHash = itemId.toString().includes("#");
        if(!containsHash){
            itemId = parseInt(itemId);
        }else{
            itemId = itemId+Date.now();
        }
       
        // Check if the item already exists in the cart
        let existingItem = cart.find(item => item.id === itemId);

        if (existingItem) {
            // Update quantity if item exists
            if(itemId==990099009900){
                //for flat discount
                existingItem.price = price;
            }else{
                existingItem.qty += qty;
            }
           
            localStorage.setItem('is_cart_oc_updated', 1);
            localStorage.setItem('lastUpdated', Date.now());
    
            localStorage.setItem('cart_oc', JSON.stringify(cart));
            update_cart_ui();
        } else {
            
             discount =   localStorage.getItem('cart_oc_all_discount');
            

            // Add new item
            cart.push({
                id: itemId,
                name: name,
                price: price,
                qty: qty,
                discount:discount,
                tax:tax_percent,
                override_default_tax:override_default_tax,
                tax_included:tax_included,
                can_override_price_adjustments: can_override_price_adjustments,
                max_discount:max_discount

            });
            let new_index = cart.findIndex(item => item.id === itemId);

            
            localStorage.setItem('is_cart_oc_updated', 1);
            localStorage.setItem('lastUpdated', Date.now());
    
            localStorage.setItem('cart_oc', JSON.stringify(cart));
            add_cart_update_ui(itemId, name ,price, qty , new_index);
            update_cart_ui();
        }
       
    }

    function updateItemqtyToCart(itemIndex, qty) {
        let cart = JSON.parse(localStorage.getItem('cart_oc'));


        if (parseInt(itemIndex) !== -1) {
            // Update quantity if item exists
            cart[parseInt(itemIndex)].qty = parseInt(qty);

            localStorage.setItem('is_cart_oc_updated', 1);
            localStorage.setItem('cart_oc', JSON.stringify(cart));
            update_cart_ui();
        } else {
            console.log("updateItemqtyToCart: item not found");
        }

    }
    
    function check_if_item_already_exist_in_cart(itemId) {
        let cart = JSON.parse(localStorage.getItem('cart_oc'));

        // Check if the item already exists in the cart
        let existingItem = cart.find(item => item.id === itemId);

        if (existingItem) {
            return true;
        } else {
            return false;
        }
    }


    function removeItemFromCart(itemId) {
        let cart = JSON.parse(localStorage.getItem('cart_oc'));
        cart = cart.filter(item => item.id !== itemId);
        localStorage.setItem('cart_oc', JSON.stringify(cart));
    }

    function removeItemFromCartByIndex(index , item_obj) {
    
        localStorage.setItem('lastUpdated', Date.now());
        var $currentTr = $(item_obj).closest('tbody'); 
        // Remove the <tr> that contains the delete button
        $currentTr.remove();
        rearrange_cart_ui_ids();

        let cart = JSON.parse(localStorage.getItem('cart_oc') || '[]');
        index = parseInt(index);
        // Check if the index is valid
        if (index >= 0 && index < cart.length) {
            cart.splice(index, 1); // Remove 1 item at the specified index
            localStorage.setItem('cart_oc', JSON.stringify(cart));
        } else {
            console.log("Invalid index. No item removed.");
        }
    }

    function rearrange_cart_ui_ids(){
        
            var tbodyCount = $('#register tbody').length;
            $('#register tbody').each(function(index) {
                new_indx = tbodyCount - 1 - index;
                $(this).attr('data-line', new_indx);
                var newHref = '<?php echo site_url("sales/delete_item"); ?>/' + new_indx; 
                $(this).find('.delete-item').attr('href', newHref);
                $(this).find('.delete-item').attr('data-id', new_indx);


            });
      
    }

    function extractNameAndPrice(str) {
    // Regular expression to match the name and price
    // This assumes the format is always "name - currencyPrice"
    var match = str.match(/^(.*)\s-\s[^\d]*(\d+)$/);

    if (match) {
        var name = match[1].trim();
        var price = parseInt(match[2], 10);

        return { name, price };
    } else {
        // Return null or some default value if the string format doesn't match
        return null;
    }
}
</script>