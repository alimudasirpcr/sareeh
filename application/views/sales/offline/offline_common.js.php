<script>
       const $currency_symbol = "<?php echo $this->config->item('currency_symbol'); ?>";
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
    }

    initializeCart();

    function update_cart_ui() {
        let cart = JSON.parse(localStorage.getItem('cart_oc'));
        cart.forEach(function(item, index) {

            // Access item properties like item.id, item.price, item.qty
            // console.log(`ID: ${item.id}, Price: ${item.price}, Quantity: ${item.qty}`);
            $('#quantity_' + index).html(item.qty);
            $('#total_' + index).html($currency_symbol + item.qty * item.price);

            // You can perform more operations inside this block
        });
    }
    function add_cart_update_ui(id,name,price,qty , line) {
     
        $html='<tbody class="fw-bold text-gray-600" data-line="'+line+'"><tr class="register-item-details"><td class="text-center  fs-6"><span class="toggle_rows btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" style="position:relative"><span class="svg-icon svg-icon-3 m-0 toggle-off"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor"></rect><rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>	</svg></span><span class="svg-icon svg-icon-3 m-0 toggle-on"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor"></rect>	</svg></span></span> &nbsp;</td>	<td class="fs-6">'+name+'</td><td class="text-center fs-6">	'+$currency_symbol+''+price+'</td><td class="text-center fs-6">	'+qty+'	</td>	<td class="text-center fs-6" style="padding-right:10px">'+$currency_symbol+''+price*qty+'<a href="<?php echo site_url("sales/delete_item"); ?>/'+line+'" class="delete-item pull-right" data-id="'+line+'" tabindex="-1"><i class="icon ion-android-cancel"></i></a>	</td></tr></tbody>';
        $('#register').prepend( $html);

    }

    function addItemToCart(itemId, price, qty ,name ='') {
        let cart = JSON.parse(localStorage.getItem('cart_oc'));

        // Check if the item already exists in the cart
        let existingItem = cart.find(item => item.id === itemId);

        if (existingItem) {
            // Update quantity if item exists
            existingItem.qty += qty;
            update_cart_ui();
        } else {
            // Add new item
            cart.push({
                id: itemId,
                name: name,
                price: price,
                qty: qty
            });
            let new_index = cart.findIndex(item => item.id === itemId);

            add_cart_update_ui(itemId, name ,price, qty , new_index);
        }
        localStorage.setItem('is_cart_oc_updated', 1);
        localStorage.setItem('lastUpdated', Date.now());
   
        localStorage.setItem('cart_oc', JSON.stringify(cart));
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