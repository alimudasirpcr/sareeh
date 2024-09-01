<script>
function getPromoPrice(promo_price, start_date, end_date) {
    if (parseFloat(promo_price) && start_date == null && end_date == null) {
        return parseFloat(promo_price);
    } else if (parseFloat(promo_price) && start_date != null && end_date != null) {
        var today = moment(new Date().toYMD());
        if (today.isBetween(start_date, end_date) || today.isSame(start_date) || today.isSame(end_date)) {
            return parseFloat(promo_price);
        }
    }

    return null;
}

function set_tier_id(tire , only_current = false) {

    previous_tier_id = (cart['extra']['tier_id']) ? cart['extra']['tier_id'] : 0;

    var sale = localStorage.getItem('cart');

    var allSales = [];
    allSales.push(JSON.parse(sale));

    $.post('<?php


 echo site_url("sales/set_tier_id_speedy"); ?>', {
            offline_sales: JSON.stringify(allSales),
            tier_id: tire,
            only_current : only_current?'true' : 'false' , 
            previous_tier_id: previous_tier_id,
        },
        function(response) {
            cart = JSON.parse(JSON.stringify(response));
            // console.log(JSON.parse(cart));
            renderUi();
        }, 'json');
}
(function() {
    Date.prototype.toYMD = Date_toYMD;

    function Date_toYMD() {
        var year, month, day;
        year = String(this.getFullYear());
        month = String(this.getMonth() + 1);
        if (month.length == 1) {
            month = "0" + month;
        }
        day = String(this.getDate());
        if (day.length == 1) {
            day = "0" + day;
        }
        return year + "-" + month + "-" + day;
    }
})();

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
Handlebars.registerHelper("checked", function(condition) {
    return (condition) ? "checked" : "";
});

Handlebars.registerHelper('or', function(v1, v2, options) {
    return (v1 == 1 || v2 == 1) ? options.fn(this) : options.inverse(this);
});


var currency_symbol = '<?php echo $this->config->item('currency_symbol'); ?>';
var cart_item_template = Handlebars.compile(document.getElementById("cart-item-template").innerHTML);
var cart_payment_template = Handlebars.compile(document.getElementById("cart-payment-template").innerHTML);
var saved_sale_template = Handlebars.compile(document.getElementById("saved-sale-template").innerHTML);
var sale_receipt_template = Handlebars.compile(document.getElementById("sale-receipt-template").innerHTML);
var list_item_template = Handlebars.compile(document.getElementById("list-item-template").innerHTML);
var list_category_template = Handlebars.compile(document.getElementById("list-category-template").innerHTML);
var list_hold_cart_template = Handlebars.compile(document.getElementById("list-hold-cart-template").innerHTML);
//data structures for cart

var items_list = [];
var current_edit_index = null;
var cart = JSON.parse(localStorage.getItem('cart')) || {};
let selectedAttributes = {};
if (typeof cart.items == 'undefined') {
    cart['items'] = [];
}
if (typeof cart.payments == 'undefined') {
    cart['payments'] = [];
}

if (typeof cart.customer == 'undefined') {
    cart['customer'] = {};
}

if (typeof cart.extra == 'undefined') {
    cart['extra'] = {};
}
if (typeof cart.custom_fields == 'undefined') {
    cart['custom_fields'] = {};
}
if (typeof cart.taxes == 'undefined') {
    cart['taxes'] = [];
}

if (typeof cart.employees == 'undefined') {
    cart['employees'] = <?php echo json_encode($employees); ?>;
}


$(document).on('click', '.delete_saved_sale', function(event) {
    event.preventDefault();

    var delete_index = $(this).data('index');
    bootbox.confirm(<?php echo json_encode(lang('sales_confirm_finish_sale')); ?>, function(result) {
        if (result) {
            var allSales = JSON.parse(localStorage.getItem("sales")) || [];
            allSales.splice(delete_index, 1);
            localStorage.setItem("sales", JSON.stringify(allSales));
            renderUi();

        }
    });
});



$(document).on('click', '.view_saved_sale', function(event) {
    event.preventDefault();

    var allSales = JSON.parse(localStorage.getItem("sales")) || [];

    displayReceipt(allSales[$(this).data('index')]);
});

$(document).on('click', '.edit_saved_sale', function(event) {
    event.preventDefault();
    var allSales = JSON.parse(localStorage.getItem("sales")) || [];
    cart = allSales[$(this).data('index')];
    current_edit_index = $(this).data('index');
    renderUi();
});

$(document).on("click", '#cancel_sale_button', function(event) {
    event.preventDefault();

    bootbox.confirm(<?php echo json_encode(lang("are_you_sure_want_to_clear")); ?>, function(result) {
        if (result) {
            cart = {};
            cart['items'] = [];
            cart['payments'] = [];
            cart['customer'] = {};
            cart['extra'] = {};
            cart['custom_fields'] = {};
            cart['taxes'] = [];
            current_edit_index = null;

            renderUi();
        }
    });
});

function checkRequiredFields() {

    console.log("checkRequiredFields");
    var allFilled = true; // Flag to track if all required fields are filled

    // Iterate over all required input fields and selects within #operationsbox_modal
    $('#operationsbox_modal input[required], #operationsbox_modal select[required]').each(function() {
        if ($(this).val() === '') {
            allFilled = false; // Set the flag to false if a field is empty
        }
    });
    if (!allFilled) {

        var operationsbox_modal = document.querySelector("#operationsbox_modal");

        var drawer = KTDrawer.getInstance(operationsbox_modal);
        drawer.show();
        return false; // Return false to indicate not all required fields are filled
    }

    return true; // Return true if all required fields are filled


}
$(document).on("click", '#finish_sale_button', function(e) {
    e.preventDefault();
    bootbox.confirm(<?php echo json_encode(lang('sales_confirm_finish_sale')); ?>, function(result) {
        if (result) {

            if (!checkRequiredFields()) {
                bootbox.hideAll();
                return false;
            }

            //Reset cart
            cart = {};
            cart['items'] = [];
            cart['payments'] = [];
            cart['customer'] = {};
            cart['extra'] = {};
            cart['custom_fields'] = {};

            cart['taxes'] = [];
            var sale = localStorage.getItem('cart');
            displayReceipt(JSON.parse(sale));


            check_for_custom = JSON.parse(sale).custom_fields;
            console.log(check_for_custom);
            for (var fieldName in check_for_custom) {
                if (check_for_custom.hasOwnProperty(fieldName)) {
                    // Use jQuery to find the input with the matching name and remove it
                    $('input[name="' + fieldName + '"]').val('');
                }
            }
            //Save sales
            var allSales = JSON.parse(localStorage.getItem("sales")) || [];

            if (current_edit_index !== null) {
                allSales[current_edit_index] = JSON.parse(sale);
            } else {
                allSales.push(JSON.parse(sale));
            }
            localStorage.setItem("sales", JSON.stringify(allSales));
            var allSales = JSON.parse(localStorage.getItem("sales")) || [];

            $.post('<?php echo site_url("sales/sync_offline_sales"); ?>', {
                    offline_sales: JSON.stringify(allSales),
                },
                function(response) {
                    if (response.success) {
                        $('#sync_offline_sales_button').remove();
                        localStorage.removeItem("sales");
                    }
                }, 'json');
            current_edit_index = null;
            renderUi();
        }
    });

});

$(document).on("click", '.modifier', function(event) {
    var index = $(this).data('index');

    if (typeof cart['items'][index]['selected_item_modifiers'] == 'undefined') {
        cart['items'][index]['selected_item_modifiers'] = {};
    }
    cart['items'][index]['selected_item_modifiers'][$(this).val()] = $(this).prop('checked');

    renderUi();
});

$(document).on("change", '.variation', function(event) {

    var price = false;
    var variation_name = '';
    var index = $(this).data('index');
    if (typeof index !== 'undefined') {
        for (var k = 0; k < cart['items'][index]['variations'].length; k++) {
            if (cart['items'][index]['variations'][k]['variation_id'] == $(this).val()) {
                if (cart['items'][index]['variations'][k]['unit_price']) {
                    price = cart['items'][index]['variations'][k]['unit_price'];

                    var promo_price = cart['items'][index]['variations'][k]['promo_price'];
                    var start_date = cart['items'][index]['variations'][k]['start_date']
                    var end_date = cart['items'][index]['variations'][k]['end_date']

                    var computed_promo_price = getPromoPrice(promo_price, start_date, end_date)

                    if (computed_promo_price) {
                        price = computed_promo_price;
                    }
                }

                variation_name = cart['items'][index]['variations'][k]['name'];

                break;
            }
        }

        if (price) {
            cart['items'][index]['price'] = price;
        } else {
            cart['items'][index]['price'] = $(this).data('orig-price');
        }

        cart['items'][index]['selected_variation'] = $(this).val();
        cart['items'][index]['selected_variation_name'] = variation_name;
        renderUi();

    }

});

$("#select_customer_form").submit(function(e) {
    e.preventDefault();

});


//Refactor for performance based on https://stackoverflow.com/questions/58999498/pouch-db-fast-search

$("#customer").autocomplete({
    source: '<?php echo site_url("sales/customer_search"); ?>',
    delay: 500,
    autoFocus: false,
    minLength: 0,
    select: function(event, ui) {

        // console.log(ui);
        var person_id = ui.item.value;
        var customer_name = ui.item.label.replace("<?php echo lang('customers_add_new_customer'); ?>", "");
        // var phone_number = ui.item.phone_number;
        var email = ui.item.subtitle;
        var balance = (ui.item.balance) ? ui.item.balance : 0;
        var internal_notes = (ui.item.internal_notes) ? ui.item.internal_notes : '';
        cart['customer']['person_id'] = person_id;
        cart['customer']['customer_name'] = customer_name;
        // cart['customer'].['phone_number'] = phone_number;
        cart['customer']['email'] = email;
        cart['customer']['balance']= balance;
        cart['customer']['internal_notes'] = internal_notes;
        cart['customer']['points'] = (ui.item.points) ? ui.item.points : 0;
        cart['customer']['sales_until_discount'] = (ui.item.sales_until_discount) ? ui.item
            .sales_until_discount : 0;
        cart['customer']['customer_credit_limit'] = (ui.item.customer_credit_limit) ? ui.item
            .customer_credit_limit : 0;
        cart['customer']['disable_loyalty'] = (ui.item.disable_loyalty) ? ui.item.disable_loyalty : 0;
        cart['customer']['is_over_credit_limit'] = (ui.item.is_over_credit_limit) ? ui.item
            .is_over_credit_limit : 0;
            // localStorage.setItem("cart", cart);
        renderUi();
        $(this).val('');
        return false;

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
            '<span class="email">' + '</span>' +
            '</div></a>')
        .appendTo(ul);
};
// async function getDocumentById(docId) {
//     try {
//         const doc = await db_items.get(docId + "_item"); // Fetch the document by its ID

//         newitem = doc;
//         var item_id = newitem.item_id;
//         var item_name = newitem.name + ' - ' + to_currency_no_money(newitem.unit_price);
//         var item_description = newitem.description;
//         var quantity = 1;
//         var variations = newitem.variations;
//         var modifiers = newitem.modifiers;
//         var taxes = newitem.taxes;
//         var tax_included = newitem.tax_included;
//         var unit_price = newitem.unit_price;
//         var promo_price = newitem.promo_price;
//         var start_date = newitem.start_date;
//         var end_date = newitem.end_date;

//         var selling_price = parseFloat(unit_price);

//         var computed_promo_price = getPromoPrice(promo_price, start_date, end_date)

//         if (computed_promo_price) {
//             selling_price = computed_promo_price;
//         }

//         selling_price = to_currency_no_money(selling_price);


//         addItem({
//             name: item_name,
//             description: item_description,
//             item_id: item_id,
//             quantity: 1,
//             price: selling_price,
//             orig_price: selling_price,
//             discount_percent: 0,
//             variations: variations,
//             modifiers: modifiers,
//             taxes: taxes,
//             tax_included: tax_included
//         });
//         renderUi();
//     } catch (error) {
//         console.error('Error fetching document:', error);
//         if (error.name === 'not_found') {
//             console.error('Document not found');
//         }
//     }
// }





// getAllData(15);





var categoryMap = {};

var CrumbTrailSaved = {};

function getObjectById(array, id) {
    const numericId = Number(id);
    const foundItem = array.find(item => {
        return Number(item.id) === numericId;
    });
    if (foundItem) {
        return foundItem;
    } else {
        return null; // Explicitly return null if not found
    }
}

function removeElementsAfterId(array, id) {
    id = Number(id);
    // Find the index of the object with the given ID
    const index = array.findIndex(element => element.id === id);

    // Check if the ID was found
    if (index === -1) {
        console.log("ID not found");
        return array; // ID not found, return original array
    }

    // Slice the array to keep only elements up to and including the found index
    return array.slice(0, index + 1);
}

async function getAllTaxes() {

    TaxesMap = {};


    const response = await $.get('<?php echo site_url("sales/taxes_offline_data"); ?>', 'json');
    ajaxtax = JSON.parse(response);



    // Populate the global map
    ajaxtax.forEach(result => {
        TaxesMap[result.id] = result;
    });

    TaxesMap = Object.entries(TaxesMap).map(([key, value]) => {
        return {
            key: key,
            value: value
        };
    });

    var select = $('#tax_class');
    select.empty(); // Ensure it's empty before loading new options
    select.append($('<option></option>').html('None'));
    // Assuming response is an array of tax classes
    TaxesMap.forEach(function(item) {
        select.append($('<option></option>').val(item.value.id).html(item.value.name));
    });


}



async function getSingleTax(id) {

    TaxesMap = {};


    const response = await $.get('<?php echo site_url("sales/taxes_offline_data"); ?>', 'json');
    ajaxtax = JSON.parse(response);


    ajaxtax.forEach(result => {
        if (result.id == id) {
            TaxesMap[result.id] = result;
        }

    });

    // console.log("id", id);
    // Populate the global map
    TaxesMapddd = Object.entries(TaxesMap).map(([key, value]) => {
        return {
            key: key,
            value: value
        };
    });
    // console.log("TaxesMapddd", TaxesMapddd);
    return TaxesMapddd[0].value.group;


}


getAllTaxes();

function salesBeforeSubmit() {



    <?php if (isset($cart_count)) { ?>
    $('.cart-number').html(<?php echo $cart_count; ?>);
    <?php } ?>
    $("#ajax-loader").show();
    $("#add_payment_button").hide();
    $("#finish_sale_button").hide();
}

function itemScannedSuccess() {
    <?php if ($this->config->item('clean_input_after_add_item')) { ?>
    $('#item').val('');
    <?php } ?>

    $('#item').val('');
    // console.log("itemScannedSuccess");
    $("#ajax-loader").hide();
    setTimeout(function() {
        $('#item').focus();
    }, 10);
}



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
                if (ui.item.secondary_suppliers.length > 0 && !ui.item.hasOwnProperty('attributes')) {
                    $('#var-customize-ss').text(ui.item.label);
                    $('#var_popup_ss').modal('show');
                    $('.placeholder_supplier_vals2 .secondary-supplier-table tr').not(':first').remove();

                    $.each(ui.item.default_supplier, function(supplier_key, supplier) {
                        $('.placeholder_supplier_vals2 .secondary-supplier-table tr:last').after(
                            '<tr class="default_supplier_row" style="cursor:pointer;" data-supplier_id="' +
                            supplier.supplier_id +
                            '"> <td><input class="default_supplier" type="radio" style="display:block;" value="' +
                            supplier.supplier_id + '" name="default_supplier" ></td> <td>' +
                            supplier.company_name + ', ' + supplier.full_name + '</td> <td>' +
                            parseFloat(supplier.cost_price).toFixed(2) + '</td> <td>' +
                            parseFloat(supplier.unit_price).toFixed(2) + '</td> </tr>');
                        $("#default_supplier_id").val(supplier.supplier_id);
                    });

                    $(".default_supplier_row").find(".default_supplier").prop("checked", true);

                    $.each(ui.item.secondary_suppliers, function(supplier_key, supplier) {
                        $('.placeholder_supplier_vals2 .secondary-supplier-table tr:last').after(
                            '<tr class="secondary_supplier_row" style="cursor:pointer;" data-supplier_id="' +
                            supplier.supplier_id +
                            '"> <td><input class="secondary_supplier" type="radio" style="display:block;" value="' +
                            supplier.supplier_id + '" name="secondary_supplier" ></td> <td>' +
                            supplier.company_name + ', ' + supplier.full_name + '</td> <td>' +
                            parseFloat(supplier.cost_price).toFixed(2) + '</td> <td>' +
                            parseFloat(supplier.unit_price).toFixed(2) + '</td> </tr>');
                    });

                    if (ui.item.serial_number != undefined && ui.item.serial_number != '') {
                        $("#item").val(decodeHtml(ui.item.serial_number));
                    } else {
                        $("#item").val(decodeHtml(ui.item.value) + '|FORCE_ITEM_ID|');
                    }

                    return true;
                }
            }
            <?php } ?>

            if (ui.item.serial_number != undefined && ui.item.serial_number != '') {
                $("#item").val(decodeHtml(ui.item.serial_number));
            } else {
                $("#item").val(decodeHtml(ui.item.value) + '|FORCE_ITEM_ID|');
            }

            // console.log("utess" , ui.item);
            addItem({
                name: ui.item.label,
                description: '',
                item_id: ui.item.value,
                quantity: 1,
                price: ui.item.price_field,
                orig_price: ui.item.price_field,
                discount_percent: 0,
                variations: ui.item.tax_included,
                modifiers: ui.item.modifiers,
                taxes: ui.item.item_taxes,
                tax_included: ui.item.tax_included
            });
            salesBeforeSubmit();
            itemScannedSuccess();
            renderUi();
            // item_obj =  items_list[ui.item.value];
            //     console.log(item_obj);
            // 		addItem(item_obj );



            // $('#add_item_form').ajaxSubmit({
            //     target: "#sales_section",
            //     beforeSubmit: salesBeforeSubmit,
            //     success: itemScannedSuccess
            // });

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
                '<span class="attributes">' + '<?php echo lang("category"); ?>' + ' : <span class="value">' + (item
                    .category ? item.category : <?php echo json_encode(lang('none')); ?>) + '</span></span>' +
                <?php if ($this->Employee->has_module_action_permission('items', 'see_item_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>(
                    typeof item.quantity !== 'undefined' && item.quantity !== null ? '<span class="attributes">' +
                    '<?php echo lang("quantity"); ?>' + ' <span class="value">' + item.quantity + '</span></span>' :
                    '') +
                <?php } ?>(item.attributes ? '<span class="attributes">' + '<?php echo lang("attributes"); ?>' +
                    ' : <span class="value">' + item.attributes + '</span></span>' : '') +
                '<?php if (!$this->config->item('hide_supplier_in_item_search_result')) { ?>' +
                (item.supplier_name ? '<span class="attributes">' + '<?php echo lang("supplier"); ?>' +
                    ' : <span class="value">' + item.supplier_name + '</span></span>' : '') +
                '<?php } ?>' +
                '</div>')
            .appendTo(ul);
    };
    <?php } ?>
}


function selectPayment(e) {
    e.preventDefault();
    $('#payment_types').val($(this).data('payment'));
    $('.select-payment').removeClass('active');
    $(this).addClass('active');
    $("#amount_tendered").focus();
    $("#amount_tendered").attr('placeholder', '');
    $('.payment_option_selected').html('<i class="fa fa-money-bill"></i> ' + $(this).data('payment'));
    if ($(this).data('payment') == <?php echo json_encode(lang('store_account')) ?>) {
        $("#create_invoice_holder").removeClass('hidden');
    } else {
        $("#create_invoice_holder").addClass('hidden');
    }
}

function updateRepeaterIndexes() {
    $('.repeater-item').each(function(index) {
        $(this).find('input, select, textarea').each(function() {
            var name = $(this).attr('name');
            if (name) {
                name = name.replace(/\[\d+\]/, '[' + index + ']'); // Replace the index
                $(this).attr('name', name);
            }
        });
    });
}

function gatherTaxData() {
    let taxes = [];

    $('[data-repeater-list="kt_docs_repeater_basic"] .repeater-item').each(function(index) {

        // Check if the item has a tax name and percent
        if ($(this).find('input[name="kt_docs_repeater_basic[' + index + '][tax_names]"]').val() &&
            $(this).find('input[name="kt_docs_repeater_basic[' + index + '][tax_percents]"]').val()) {
            let tax = {
                id: 1, // Assuming static for example; replace or dynamically fetch as needed
                item_id: 1, // Assuming static for example; replace or dynamically fetch as needed
                name: $(this).find('input[name="kt_docs_repeater_basic[' + index + '][tax_names]"]').val(),
                percent: $(this).find('input[name="kt_docs_repeater_basic[' + index + '][tax_percents]"]')
                    .val(),
                cumulative: 0 // Assuming static for example; replace or dynamically fetch as needed
            };
            taxes.push(tax);
        }


    });

    return taxes;
}

function removeAllExceptFirstRepeater() {
    let repeaterItems = $('#kt_drawer_general_body_lg .repeater-item');
    // console.log("Total repeater items before removal:", repeaterItems.length);

    if (repeaterItems.length > 1) {
        repeaterItems.not(':first').each(function(index, item) {
            // console.log("Removing repeater item:", item);
            $(item).remove();
        });
    }

    // Verify the result
    let remainingItems = $('#kt_drawer_general_body_lg .repeater-item');
    // console.log("Total repeater items after removal:", remainingItems.length);
}


function onclick_edit_taxes_item(item_id) {

    // console.log("item_id:", item_id);
    if (item_id >= 0) {
        taxes = cart.items[item_id].taxes;
    } else {
        taxes = cart.taxes;
    }



    $('.current_cart_item').val(item_id);

    $('#kt_drawer_general_body_lg').html($('#kt_drawer_general_body_lg_container').html());




    var lastRepeaterItem = $('.repeater-item:last');

    removeAllExceptFirstRepeater();

    var clonetop = lastRepeaterItem.clone(true);
    if (taxes.length > 0) {
        taxes.forEach(function(tax, index) {
            if (tax.hasOwnProperty('item_id')) {
                clone = clonetop;
                // this is override default tax
                $('.tax_class_main').val('None');


                // Clone the last item

                // Clear the values in the cloned item
                clone.find('input[type="text"]').val('');
                clone.find('input[type="hidden"]').val('0'); // Assuming you want to reset hidden fields to '0'

                clone.appendTo(
                    '[data-repeater-list="kt_docs_repeater_basic"]'); // Append the clone to the container
                updateRepeaterIndexes(); // Update indexes to ensure proper form submission
                $('input[name="kt_docs_repeater_basic[' + index + '][tax_names]"]').val(tax.name);
                $('input[name="kt_docs_repeater_basic[' + index + '][tax_percents]"]').val(tax.percent);
                // console.log(index);
                $('.all_taxes').show();
            } else {
                // this is not override default tax

                $('.tax_class_main').val(tax.tax_class_id);
                $('.all_taxes').hide();
                clonetop.find('input[type="text"]').val('');
                clonetop.find('input[type="hidden"]').val(
                    '0'); // Assuming you want to reset hidden fields to '0'

                clonetop.appendTo('[data-repeater-list="kt_docs_repeater_basic"]');
            }
        });
    }
    $(".submit_button").click(function(e) {
        item_id = $('.current_cart_item').val();
        if ($('.tax_class_main').val() !== 'None') {
            // update tax in cart 

            currently_selected_tax = $('.tax_class_main').val();
            new_taxes = {};
            // new_taxes  =  getSingleTax(currently_selected_tax);

            getSingleTax(currently_selected_tax)
                .then(new_taxes => {
                    // Process the response
                    if (item_id >= 0) {

                        // new_taxes.then(data => {
                        cart.items[item_id].taxes = {};
                        cart.items[item_id].taxes = new_taxes;

                        // });
                    } else {

                        cart.taxes = new_taxes;
                    }
                    renderUi();
                })
                .catch(error => {
                    // Handle errors
                    console.error("Error fetching new taxes:", error);
                });




            // console.log(new_taxes);

        } else {
            currently_selected_tax = $('.current_cart_item').val();
            taxobj = gatherTaxData();
            if (item_id >= 0) {
                cart.items[currently_selected_tax].taxes = taxobj;
            } else {
                cart.taxes = taxobj;
            }
            renderUi();
        }
    });

    // Initially hide the div if the selected value is not 'None'
    if ($('.tax_class_main').val() !== 'None') {
        $('.all_taxes').hide();
    }

    // Handle the change event of the dropdown
    $('.tax_class_main').change(function() {
        if ($(this).val() === 'None') {
            $('.all_taxes').show(); // Show the div if 'None' is selected
        } else {
            $('.all_taxes').hide(); // Hide the div otherwise
        }
    });

}

function refresh_cart_var() {
    cart = {};
    cart = JSON.parse(localStorage.getItem("cart"));

}

function get_payment_amount(type) {
    let totalCash = cart['payments'].reduce((total, payment) => {

        if (payment.type === type) {
            return total + parseFloat(payment.amount);
        }
        return total;
    }, 0);
    return totalCash;
}

function check_for_payment_options() {
    $allowed = false;
    $('#pay_type_<?php echo lang('points') ?>').remove();
    if (cart['customer'] && cart['customer']['disable_loyalty'] == '0') {
        $first_check = false;
        <?php 
        if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced' && count(explode(":",$this->config->item('spend_to_point_ratio'),2)) == 2){ ?>
        $first_check = true;
        <?php  }
        ?>
        if ($first_check == true && cart['customer']['points'] >= 1 && get_payment_amount(
                '<?php echo lang('points') ?>') <= 0) {
            $('.payment_dropdown').append(
                '<li id="pay_type_<?php echo lang('points') ?>"> <a tabindex="-1" href="#" class="btn btn-pay select-payment  " data-payment="<?php echo lang('points') ?>"> <i class="fa fa-money-bill"></i><?php echo lang('points') ?></a> </li>'
                );
            $('.select-payment').on('click mousedown', selectPayment);
            $allowed = true;
        }
    }
    return $allowed;
}

function calculateCartValues(cart) {
    var total_discount = get_discount(cart);
    var item_discount = get_item_discount(cart);
    var subtotal = get_subtotal(cart);
    var taxes = get_taxes(cart, true);

    // Adjusting subtotal by subtracting item discount
    subtotal = parseFloat(subtotal) - parseFloat(item_discount);

    // Calculating item price including tax
    var itemPriceIncludingTax = parseFloat(subtotal) + parseFloat(taxes);

    // Getting general tax and adding it to taxes
    var gen_tax = get_general_tax(itemPriceIncludingTax, cart);
    taxes = parseFloat(taxes) + parseFloat(gen_tax);

    // Calculating flat discount
    var flat_discount = get_flat_discount(cart);

    // Calculating total amount
    var total = (parseFloat(subtotal) + parseFloat(taxes)).toFixed(2);

    // Calculating amount due
    var amount_due = get_amount_due(cart, total);

    // Returning all the calculated values
    return {
        total_discount: total_discount,
        item_discount: item_discount,
        subtotal: subtotal.toFixed(2), // To ensure consistent formatting
        taxes: taxes.toFixed(2),
        gen_tax: gen_tax,
        flat_discount: flat_discount,
        total: total,
        amount_due: amount_due
    };
}

<?php
														$source_data = array();

														foreach ($tiers as $tier_id => $tier_name) {
															$source_data[$tier_id] = array('value' => $tier_id, 'text' => $tier_name);
														}

                                                       
													?>

$all_tiers = JSON.parse('<?php echo  json_encode(	$source_data); ?>');
                                                      
function renderUi() {

    $("#saved_sales_list").empty();
    console.log("UiRefreshed");

   

    localStorage.setItem("cart", JSON.stringify(cart));
   

    refresh_cart_var();

 

    $("#register").find('tbody').remove();
    var total_qty = 0;

    
    for (var k = 0; k < cart['items'].length; k++) {

        var cart_item = cart['items'][k];
        if (cart_item['quantity'] > 0) {
            total_qty = total_qty + parseInt(cart_item['quantity']);
        }

        cart['items'][k]['line_total'] = cart_item['price'] * cart_item['quantity'] - cart_item['price'] * cart_item[
            'quantity'] * cart_item['discount_percent'] / 100;
        cart['items'][k]['index'] = k;

        cart['items'][k]['index'] = k;
        cart['items'][k]['permission_edit_sale_price'] = (cart['extra']['permission_edit_sale_price'])?cart['extra']['permission_edit_sale_price']:0;
        
        $("#register").prepend(cart_item_template(cart['items'][k] ) );

        
                                                  
        $('#tier_'+k).editable({
            value: cart_item['tier_id'],
            source: <?php echo json_encode($source_data); ?>,
            success: function(response, newValue) {
             
                var field = $(this).data('name');
                var index = $(this).data('index');
               
                if (typeof index !== 'undefined') {
                    
                    cart['items'][index].previous_tier_id = (cart['items'][index][field])?cart['items'][index][field]:0;
                    cart['items'][index][field] = newValue;
                    cart['items'][index].tier_name =  $all_tiers[newValue].text;
                }
             

                localStorage.setItem("cart", JSON.stringify(cart));


                refresh_cart_var();


                set_tier_id(newValue , true);
              
            }

        });


    }


    $('.xeditable-item-percentage').editable({
        success: function(response, newValue) {
            //persist data
            var field = $(this).data('name');
            var index = $(this).data('index');
            if (typeof index !== 'undefined') {
                cart['items'][index][field] = newValue;
            }
            renderUi();
        }
    });

  

    $('#total_items').html(cart['items'].length);
    $('#total_items_qty').html(total_qty);

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



    if (cart['items'].length || cart['payments'].length || (cart['customer'] && cart['customer']['person_id'])) {
        $("#edit-sale-buttons").show();
    } else {
        $("#edit-sale-buttons").hide();
    }

    if (cart['extra']['tier_id']) {
        var tierElement = $('.item-tiers a[data-value="' + cart['extra']['tier_id'] + '"]');

        if (tierElement.length > 0) {
            var tierName = tierElement.text().trim(); // Get the text content and trim any extra spaces
            $('.selected-tier').html(tierName);
        }

    } else {
        $('.selected-tier').html('None');
    }


    if (cart['extra']['sold_by_employee_id']) {
        var sold_by_employee_idElement = $('.select-sales-persons a[data-value="' + cart['extra'][
            'sold_by_employee_id'] + '"]');

        if (sold_by_employee_idElement.length > 0) {
            var employeeName = sold_by_employee_idElement.text()
        .trim(); // Get the text content and trim any extra spaces
            $('.selected-sales-person').html(employeeName);
        } else {

            $('.selected-sales-person').html('Not Set');
        }

    } else {
        $('.selected-sales-person').html('Not Set');
    }

    $("#payments").empty();

    for (var k = 0; k < cart['payments'].length; k++) {
        var payment = cart['payments'][k];
        cart['payments'][k]['index'] = k;
        $("#payments").append(cart_payment_template(cart['payments'][k]));
    }

    if (cart.payments.length) {
        $("#finish_sale").show();
        $("#kt_drawer_payments_list").show();

    } else {
        $("#finish_sale").hide();
        $("#kt_drawer_payments_list").hide();
    }

    var cartValues = calculateCartValues(cart);


    var total_discount = cartValues.total_discount;
    var item_discount = cartValues.item_discount;
    var subtotal = cartValues.subtotal;
    var taxes = cartValues.taxes;
    subtotal = cartValues.subtotal;
    var gen_tax = cartValues.gen_tax;

    var flat_discount = cartValues.flat_discount;
    total = cartValues.total;
    var amount_due = cartValues.amount_due;


    $("#sub_total").html(subtotal);
    $("#taxes").html(taxes);
    $("#total").html(total);
    check_for_payment_options();
    $('#total_discount').html(total_discount.toFixed(2));
    $('#total_discount_detail').html(total_discount.toFixed(2) + ' ' + currency_symbol);
    $('.discount_all_percent').val(cart['extra']['discount_all_percent']);
    $('#Flat_discount').html(cart['extra']['discount_all_flat'] + ' ' +
        currency_symbol);
    $('#Discount_from_items').html(item_discount + ' ' +
        currency_symbol);

    $('.discount_all_flat').val(cart['extra']['discount_all_flat']);
    $("#amount_due").html(amount_due);
    $("#amount_tendered").val(amount_due);
    // console.log(cart['customer']);
    $('.balance').removeClass(' text-success text-danger');
    if (cart['customer'] && cart['customer']['person_id']) {
        $("#customer_name").html(cart['customer']['customer_name']);
        $("#customer_balance").html('Balance  ' + currency_symbol +
            to_currency_no_money(cart['customer']['balance']));
        $('.balance').addClass((cart['customer']['is_over_credit_limit']) ? 'text-danger' : 'text-success');

        if (cart['customer']['disable_loyalty'] == '0') {
            $('.loyalty').show();
        } else {
            $('.loyalty').hide();
        }

        $('.sales_until_discount_main').addClass((cart['customer']['sales_until_discount']) ? 'text-danger' :
            'text-success');
        $('#redeem_discount').hide();
        $('#unredeem_discount').hide();
        if (cart['customer']['sales_until_discount'] <= 0 && !cart['extra']['redeem']) {
            $('#sud_val').html(cart['customer']['sales_until_discount']);
            $('#redeem_discount').show();
            $('#unredeem_discount').hide();

        } else {
            if (cart['extra']['redeem']) {
                $('#sud_val').html(cart['customer']['sales_until_discount']);
                $('#redeem_discount').hide();
                $('#unredeem_discount').show();
            }
        }
        $('.points_main').addClass((cart['customer']['points'] <= 0) ? 'text-danger' : 'text-success');
        $('.points').html(cart['customer']['points']);


        $("#selected_customer_form").removeClass('hidden');
        $("#select_customer_form").addClass('hidden');
        $("#customer_internal_notes").html(cart['customer']['internal_notes']);
        // $('#internal_notes').data('value' , cart['customer']['internal_notes']);
        $('.xeditable-comment').editable({
            success: function(response, newValue) {
                cart['customer']['internal_notes'] = newValue;
                renderUi();
            }
        });


        // $('.xeditable-comment').editable('setValue', cart['customer']['internal_notes'], true);
    } else {
        $('.loyalty').hide();
        $("#customer").val('');
        $("#selected_customer_form").addClass('hidden');
        $("#select_customer_form").removeClass('hidden');
    }
    amount_tendered_input_changed();


    $(".edit_taxes_item").click(function(e) {
        item_id = $(this).data('id');

        onclick_edit_taxes_item(item_id);


    });

    $("#edit_taxes_gen").click(function(e) {
        // $('#kt_drawer_general_body_lg').html($('#kt_drawer_general_body_lg_container').html());

        item_id = $(this).data('id');

        onclick_edit_taxes_item(item_id);

        renderUi();

    });

}


function redeem_discount() {
    $discount_all_percent = '<?php echo $this->config->item('discount_percent_earned'); ?>';
    if ($discount_all_percent > 0) {
        cart['extra']['discount_all_percent'] = $discount_all_percent;
        cart['extra']['redeem'] = true;
        for (var k = 0; k < cart['items'].length; k++) {
            if (cart['items'][k]['item_id'] > 0 || cart['items'][k]['item_id'].includes('#') ) {
                cart['items'][k]['discount_percent'] = $discount_all_percent;
            }

        }
    }
    renderUi();

}

function unredeem_discount() {
    $discount_all_percent = '0';

    cart['extra']['discount_all_percent'] = $discount_all_percent;
    cart['extra']['redeem'] = false;
    for (var k = 0; k < cart['items'].length; k++) {
        if (cart['items'][k]['item_id'] > 0 || cart['items'][k]['item_id'].includes('#')) {
            cart['items'][k]['discount_percent'] = $discount_all_percent;
        }

    }


    renderUi();
}

$('#redeem_discount').on('click', function(e) {
    redeem_discount();
});
$('#unredeem_discount').on('click', function(e) {
    unredeem_discount();
});


function addPayment(e) {
    e.preventDefault();
    var amount = $("#amount_tendered").val();
    var type = $("#payment_types").val();
    cartValues = calculateCartValues(cart);
    if (type == '<?php echo lang('Points'); ?>') {

        minimum_points_to_redeem = parseFloat('<?php echo $this->config->item('minimum_points_to_redeem'); ?>');
        point_value = parseFloat('<?php echo $this->config->item('point_value'); ?>');
        if (amount > cart['customer']['points'] || amount <= 0 || cartValues.amount_due <= 0) {
            show_feedback('error', "<?php echo  lang('sales_points_to_much') ?>", "<?php echo  lang('error') ?>");
            return false;
        }

        if (cart['customer']['points'] < minimum_points_to_redeem) {

            show_feedback('error', "<?php echo  lang('sales_points_to_little') ?>", "<?php echo  lang('error') ?>");
            return false;

        }


        $('#payment_types').val('<?php echo lang('Cash'); ?>');
        $('.select-payment').removeClass('active');
        $(this).addClass('active');
        $("#amount_tendered").focus();
        $("#amount_tendered").attr('placeholder', '');
        $('.payment_option_selected').html('<i class="fa fa-money-bill"></i> ' + '<?php echo lang('Cash'); ?>');


        max_points = Math.ceil(cartValues.amount_due / point_value);
        $payment_amount = Math.min(max_points * point_value, amount * point_value, cartValues.amount_due);
        console.log(
            `Max Points Value: ${max_points * point_value}, Amount Value: ${amount * point_value}, Amount Due: ${cartValues.amount_due}`
            );


        amount = $payment_amount;
    }

    cart['payments'].push({
        amount: amount,
        type: type
    });
    renderUi();

}
$('#discount_details_reload').on('click', function() {
    $('#discountbox_modal_reload').html($('#discountbox_modal_reload_data').html());
    var discountbox_modal_reload = document.querySelector("#discountbox_modal_reload");
    var drawer = KTDrawer.getInstance(discountbox_modal_reload);

    $('.discount_all_percent').val(cart['extra']['discount_all_percent']);
    $('.discount_all_flat').val(cart['extra']['discount_all_flat']);

    renderUi();

    drawer.show();
    $('.update_discount_details').on('click', function() {
        $discount_all_percent = $('#discount_all_percent').val();

        $discount_all_flat = $('#discount_all_flat').val();


        if ($discount_all_flat > 0) {

            addItem({
                name: 'discount',
                description: 'discount added',
                item_id: '0',
                quantity: -1,
                price: $discount_all_flat,
                orig_price: $discount_all_flat,
                discount_percent: 0,
                variations: {},
                modifiers: {},
                taxes: {},
                tax_included: 0
            });


            cart['extra']['discount_all_flat'] = $discount_all_flat;
        }
        if ($discount_all_percent > 0) {
            cart['extra']['discount_all_percent'] = $discount_all_percent;
            for (var k = 0; k < cart['items'].length; k++) {
                if (cart['items'][k]['item_id'] > 0) {
                    cart['items'][k]['discount_percent'] = $discount_all_percent;
                }

            }
        }
        renderUi();
    });

});
$('.select-payment').on('click mousedown', selectPayment);

$("#add_payment_form").submit(addPayment);
$("#add_payment_button").click(addPayment);

$(document).on("click", 'a.delete-item', function(event) {
    event.preventDefault();
    if (parseInt($(this).data('item_id')) == 0) {

        // this is not actual item its discount
        cart['extra']['discount_all_flat'] = 0;

    }
    cart.items.remove($(this).data('cart-index'));

    renderUi();
});

$(document).on("click", 'a.delete-payment', function(event) {
    event.preventDefault();
    cart.payments.remove($(this).data('payment-index'));
    renderUi();
});

$(document).on("click", '#remove_customer', function(event) {
    event.preventDefault();
    cart.customer = {};
    renderUi();
});


renderUi();

function get_price_without_tax_for_tax_incuded_item(cart_item) {

    var tax_info = cart_item.taxes;
    var item_price_including_tax = cart_item.price;

    if (tax_info.length == 2 && tax_info[1]['cumulative'] == '1') {
        // console.log('get_price_without_tax_for_tax_incuded_item');
        var to_return = item_price_including_tax / (1 + (tax_info[0]['percent'] / 100) + (tax_info[1]['percent'] /
            100) + ((tax_info[0]['percent'] / 100) * ((tax_info[1]['percent'] / 100))));
    } else //0 or more taxes NOT cumulative
    {
        var total_tax_percent = 0;

        for (var k = 0; k < tax_info.length; k++) {
            var tax = tax_info[k]
            total_tax_percent += parseFloat(tax['percent']);
        }

        var to_return = item_price_including_tax / (1 + (total_tax_percent / 100));
    }

    return to_return;

}

function get_price_without_tax_for_tax_incuded_modifier_item(cart_item, modifier_item) {

    var tax_info = cart_item.taxes;
    var item_price_including_tax = modifier_item.unit_price;

    if (tax_info.length == 2 && tax_info[1]['cumulative'] == '1') {
        var to_return = item_price_including_tax / (1 + (tax_info[0]['percent'] / 100) + (tax_info[1]['percent'] /
            100) + ((tax_info[0]['percent'] / 100) * ((tax_info[1]['percent'] / 100))));
    } else //0 or more taxes NOT cumulative
    {
        var total_tax_percent = 0;

        for (var k = 0; k < tax_info.length; k++) {
            var tax = tax_info[k]
            total_tax_percent += tax['percent'];
        }

        var to_return = item_price_including_tax / (1 + (total_tax_percent / 100));
    }

    return to_return;

}


function get_subtotal(cart) {
    if (typeof cart.items != 'undefined') {
        var subtotal = 0;

        for (var k = 0; k < cart.items.length; k++) {
            var cart_item = cart.items[k];

            if (cart_item.tax_included == '1') {
                price = get_price_without_tax_for_tax_incuded_item(cart_item);
            } else {
                price = cart_item['price'];
            }
            console.log(cart_item.selected_item_modifiers);
            for (const modifier_id in cart_item.selected_item_modifiers) {
                if (cart_item.selected_item_modifiers[modifier_id]) {
                    for (var j = 0; j < cart_item.modifiers.length; j++) {
                        if (cart_item.modifiers[j]['modifier_item_id'] == cart_item.selected_item_modifiers[modifier_id].id) {
                            if (cart_item.tax_included == '1') {
                                console.log("yes text" , cart_item.selected_item_modifiers);
                                var modifier_price = get_price_without_tax_for_tax_incuded_modifier_item(cart_item,
                                    cart_item.modifiers[j])

                            } else {
                                var modifier_price = parseFloat(to_currency_no_money(cart_item.modifiers[j][
                                    'unit_price'
                                ]));
                            }

                            
                            price = parseFloat(price) + modifier_price;
                            break;
                        }
                    }
                }

            }
            subtotal += price * cart_item['quantity'];
        }

        return to_currency_no_money(subtotal.toFixed(2));
    }
    return 0;
}

function get_item_discount(cart) {
    if (typeof cart.items != 'undefined') {
        var total_discount = 0;

        for (var k = 0; k < cart.items.length; k++) {
            var cart_item = cart.items[k];

            if (cart_item.tax_included == '1') {
                price = get_price_without_tax_for_tax_incuded_item(cart_item);
            } else {
                price = cart_item['price'];
            }

            for (const modifier_id in cart_item.selected_item_modifiers) {
                if (cart_item.selected_item_modifiers[modifier_id]) {
                    for (var j = 0; j < cart_item.modifiers.length; j++) {
                        if (cart_item.modifiers[j]['modifier_item_id'] == cart_item.selected_item_modifiers[modifier_id].id) {
                            if (cart_item.tax_included == '1') {
                                var modifier_price = get_price_without_tax_for_tax_incuded_modifier_item(cart_item,
                                    cart_item.modifiers[j])

                            } else {
                                var modifier_price = parseFloat(to_currency_no_money(cart_item.modifiers[j][
                                    'unit_price'
                                ]));
                            }

                            price = parseFloat(price) + modifier_price;
                            break;
                        }
                    }
                }

            }
            discount_amount = price * cart_item['quantity'] * (cart_item['discount_percent'] / 100);

            // if(cart_item['orig_price'] !=  cart_item['price']  && cart_item['orig_price'] > cart_item['price']) {
            //     discount_amount += (cart_item['orig_price'] - cart_item['price']) * cart_item['quantity'] ;
            // }
            total_discount += discount_amount;
        }

        return to_currency_no_money(total_discount.toFixed(2));
    }
    return 0;
}

function get_flat_discount(cart) {
    discount_all_flat = 0;

    if (cart['extra'] && cart['extra']['discount_all_flat']) {
        discount_all_flat = parseFloat(cart['extra']['discount_all_flat']);
    }
    return discount_all_flat.toFixed(2);;
}

function get_tire_discount(cart) {
    if (typeof cart.items != 'undefined') {
        var total_discount = 0;

        for (var k = 0; k < cart.items.length; k++) {
            var cart_item = cart.items[k];
            if (cart_item['orig_price'] != cart_item['price'] && cart_item['orig_price'] > cart_item['price']) {
                total_discount += (cart_item['orig_price'] - cart_item['price']) * cart_item['quantity'];
            }

        }

        return to_currency_no_money(total_discount.toFixed(2));
    }
    return 0;
}


function get_discount(cart) {
    itemDiscountedPrice = get_item_discount(cart);
    discount_all_flat = get_flat_discount(cart);
    discount_tire = get_tire_discount(cart);
    return parseFloat(itemDiscountedPrice) + parseFloat(discount_all_flat) + parseFloat(discount_tire);
}


function get_general_tax(subtotal, cart) {

    // console.log("get_general_tax" , subtotal);
    let cumulativeTotal = subtotal; // Start with the initial subtotal
    let totalGeneralTax = 0; // Initialize total general tax

    if (cart.items !== undefined && cart.taxes.length > 0) {
        let taxes = cart.taxes;
        taxes.forEach(tax => {
            // Calculate tax based on whether it is cumulative or not
            let baseAmount = tax['cumulative'] === "1" ? cumulativeTotal : subtotal;
            let taxAmount = baseAmount * (parseFloat(tax['percent']) / 100);

            // If tax is cumulative, add it to the cumulative total for future calculations
            if (tax['cumulative'] === "1") {
                cumulativeTotal += taxAmount;
            }

            // Accumulate all taxes to the total general tax
            totalGeneralTax += taxAmount;

            // Log the calculation (optional)
            // console.log(`Tax "${tax['name']}" calculated on $${baseAmount.toFixed(2)} at ${tax['percent']}% is $${taxAmount.toFixed(2)}`);
        });
        $html =
            '<div class="separator separator-dashed my-4"></div><div class="d-flex flex-column content-justify-center w-100"> ';
        $html +=
            "<div class='d-flex fs-6 fw-semibold align-items-center'><div class='bullet w-8px h-6px rounded-2 bg-danger me-3'></div><div class='text-gray-500 flex-grow-1 me-4'> Total General Tax : </div> <div class='fw-bolder text-gray-700 text-xxl-end'> " +
            totalGeneralTax.toFixed(2) + currency_symbol + " </div> </div>  </div>";
        $('#kt_drawer_general_body_lg_tax_list').append($html);
        // console.log(`Cumulative total after all taxes: $${cumulativeTotal.toFixed(2)}`);
        return totalGeneralTax.toFixed(2);

    } else {
        return 0; // Return zero if no items or no taxes
    }
}

function get_taxes(cart, is_current_cart = false) {

    if (is_current_cart) {
        $('#kt_drawer_general_body_lg_tax_list').html('');
        $('#kt_drawer_general_body_lg_tax_list').append('<h3>Tax Details</h3>');
        $html = '<div class="d-flex flex-column content-justify-center w-100"> ';
    }


    if (typeof cart.items != 'undefined') {
        var total_tax = 0;
        var $tax_include = '';
        for (var k = 0; k < cart.items.length; k++) {
            var cart_item = cart.items[k];

            if (cart_item.tax_included == '1') {
                $tax_include = '(Tax Include)';
                price = get_price_without_tax_for_tax_incuded_item(cart_item);
            } else {
                price = cart_item['price'];
                $tax_include = '';
            }

            for (const modifier_id in cart_item.selected_item_modifiers) {
                if (cart_item.selected_item_modifiers[modifier_id]) {
                    for (var j = 0; j < cart_item.modifiers.length; j++) {
                        if (cart_item.modifiers[j]['modifier_item_id'] == cart_item.selected_item_modifiers[modifier_id].id) {
                            if (cart_item.tax_included == '1') {
                                var modifier_price = get_price_without_tax_for_tax_incuded_modifier_item(cart_item,
                                    cart_item.modifiers[j])

                            } else {
                                var modifier_price = parseFloat(to_currency_no_money(cart_item.modifiers[j][
                                    'unit_price'
                                ]));
                            }
                            price = parseFloat(price) + modifier_price;
                            break;
                        }
                    }
                }

            }

            $current_item_total_tax = 0;
            if (typeof cart_item.taxes != 'undefined') {
                for (var j = 0; j < cart_item.taxes.length; j++) {
                    var tax = cart_item.taxes[j]
                    var quantity = cart_item.quantity;
                    var discount = cart_item.discount_percent;

                    if (tax['cumulative'] != '0') {
                        if (j - 1 >= 0) {
                            var prev_tax = ((price * quantity - price * quantity * discount / 100)) * ((cart_item.taxes[
                                j - 1][
                                'percent'
                            ]) / 100);
                        } else {
                            var prev_tax = 0;
                        }

                        var tax_amount = (((price * quantity - price * quantity * discount / 100)) + prev_tax) * ((tax[
                            'percent']) / 100);
                    } else {

                        var tax_amount = ((price * quantity - price * quantity * discount / 100)) * ((tax['percent']) /
                            100);

                    }
                    $current_item_total_tax += tax_amount;
                    total_tax += tax_amount;

                }
            }
            if (is_current_cart) {



                $html +=
                    "<div class='d-flex fs-6 fw-semibold align-items-center'><div class='bullet w-8px h-6px rounded-2 bg-info me-3'></div><div class='text-gray-500 flex-grow-1 me-4'>" +
                    cart_item.name + "  " + $tax_include +
                    ": </div> <div class='fw-bolder text-gray-700 text-xxl-end'>" + $current_item_total_tax.toFixed(2) +
                    currency_symbol + "</div> </div> ";
            }

            //console.log("items taxes" , total_tax);
        }

        if (is_current_cart) {

            $html +=
                "<div class='separator separator-dashed my-4'></div><div class='d-flex fs-6 fw-semibold align-items-center'><div class='bullet w-8px h-6px rounded-2 bg-danger me-3'></div><div class='text-gray-500 flex-grow-1 me-4'> Total item tax : </div> <div class='fw-bolder text-gray-700 text-xxl-end '>" +
                total_tax.toFixed(2) + currency_symbol + " </div> </div>";
            $html += '</div>';
            $('#kt_drawer_general_body_lg_tax_list').append($html);
        }
        return to_currency_no_money(total_tax.toFixed(2));
    } else {
        return 0;
    }
}



function get_total(cart) {
    var subtotal = parseFloat(get_subtotal(cart));
    var itemDiscountedPrice = parseFloat(get_item_discount(cart));
    var discount_all_flat = parseFloat(get_flat_discount(cart));
    var discount = itemDiscountedPrice + discount_all_flat;

    var taxes = parseFloat(get_taxes(cart));
    var total = subtotal - discount + taxes;

    return to_currency_no_money(total.toFixed(2));
}

function get_payments_total(cart) {
    var total = 0;
    for (var k = 0; k < cart['payments'].length; k++) {
        total += parseFloat(cart['payments'][k]['amount']);
    }

    return to_currency_no_money(total.toFixed(2));
}

function get_amount_due(cart, total) {
    var total = parseFloat(total);
    var payments_total = parseFloat(get_payments_total(cart));
    var amount_due = total - payments_total;

    return to_currency_no_money(amount_due.toFixed(2));
}

function get_total_items_sold(cart) {
    var total = 0;
    if (typeof cart.items != 'undefined') {
        var subtotal = 0;

        for (var k = 0; k < cart.items.length; k++) {
            total += parseFloat(cart.items[k]['quantity']);
        }
    }

    return to_currency_no_money(total)
}

function display_sale_register() {
    $("#print_receipt_holder").hide();
    $('#print_modal').modal('hide');
    $("#sales_page_holder").show();
}

function get_modifier_unit_total(cart_item) {
    var unit_total = 0;

    for (var k = 0; k < cart_item.modifiers.length; k++) {
        var mod_item = cart_item.modifiers[k];
        unit_total += parseFloat(mod_item['unit_price']);
    }

    return unit_total;

}

function get_modifiers_subtotal(cart_item) {
    var sub_total = 0;

    for (var k = 0; k < cart_item.modifiers.length; k++) {
        var mod_item = cart_item.modifiers[k];
        sub_total += parseFloat(mod_item['unit_price']) * cart_item['quantity'];
    }

    return sub_total;
}

function displayReceipt(sale) {
    $("#print_receipt_holder").empty();

    sale.total_items_sold = get_total_items_sold(sale);
    sale.subtotal = get_subtotal(sale);



    var total_discount = get_discount(sale);
    var item_discount = get_item_discount(sale);
    var subtotal = get_subtotal(sale);
    var taxes = get_taxes(sale, true);
    // console.log('subtotal--' , subtotal);
    // console.log('taxes--' , taxes);
    subtotal = parseFloat(subtotal) - parseFloat(item_discount);
    var itemPriceIncludingTax = parseFloat(subtotal) + parseFloat(taxes);
    // console.log('itemPriceIncludingTax--' , itemPriceIncludingTax);
    var gen_tax = get_general_tax(itemPriceIncludingTax, sale);
    taxes = parseFloat(taxes) + parseFloat(gen_tax);
    // var total = get_total(cart);

    var flat_discount = get_flat_discount(sale);
    // console.log('taxes' , taxes);
    total = (parseFloat(subtotal) + parseFloat(taxes)).toFixed(2);
    var amount_due = get_amount_due(sale, total);



    sale.total_tax = taxes;
    sale.gen_tax = gen_tax;
    sale.subtotal = subtotal;
    sale.total = total;

    for (var k = 0; k < sale.items.length; k++) {
        sale.items[k].price = parseFloat(sale.items[k].price) + get_modifier_unit_total(sale.items[k]);
        sale.items[k].line_total = parseFloat(sale.items[k].line_total) + get_modifiers_subtotal(sale.items[k]);
    }

    $("#print_receipt_holder").append(sale_receipt_template(sale));
    $("#print_receipt_holder").show();
    $('#print_modal').modal('show');
    $("#sales_page_holder").hide();

}
$("#item").focus();

//Select all text in the input when input is clicked
$("input:text, textarea").not(".description,#comment,#internal_notes").click(function() {
    $(this).select();
});


$(document).ready(function() {
    var $scrollContainer = $('.horizontal-scroll');
    var scrollSpeed = 10; // Adjust this value for different scroll speeds

    $scrollContainer.on('mousemove', function(e) {
        var $this = $(this);
        var mouseX = e.pageX - $this.offset()
            .left; // Get the mouse X position relative to the scroll container
        var scrollWidth = $this.get(0).scrollWidth; // Width of the scroll container
        var outerWidth = $this.outerWidth(); // Visible width of the scroll container
        var scrollLeft = $this.scrollLeft(); // Current scroll position

        // If the mouse is on the right side of the container, scroll right
        if (mouseX > outerWidth *
            0.8
        ) { // The 0.8 here means "start scrolling when the mouse is at 80% of the container width"
            $this.scrollLeft(scrollLeft + scrollSpeed);
        }
        // If the mouse is on the left side of the container, scroll left
        else if (mouseX < outerWidth *
            0.2) { // The 0.2 means "start scrolling when the mouse is at 20% of the container width"
            $this.scrollLeft(scrollLeft - scrollSpeed);
        }
    });

    $scrollContainer.on('wheel', function(e) {
        // Prevents the default vertical scroll
        e.preventDefault();

        // Cross-browser wheel delta
        var delta = e.originalEvent.deltaX * -1 || e.originalEvent.deltaY;
        var scrollLeft = $scrollContainer.scrollLeft();
        $scrollContainer.scrollLeft(scrollLeft + delta);
    });






    $('.xeditable').editable({
        success: function(response, newValue) {
            //persist data
            var field = $(this).data('name');
            var index = $(this).data('index');
            if (typeof index !== 'undefined') {
                cart['items'][index][field] = newValue;
            }
            renderUi();
        }
    });

    $('.xeditable').on('shown', function(e, editable) {

        editable.input.postrender = function() {
            //Set timeout needed when calling price_to_change.editable('show') (Not sure why)
            setTimeout(function() {
                editable.input.$input.select();
            }, 200);
        };
    })

    $('.xeditable-comment').editable({
        success: function(response, newValue) {
            cart['customer']['internal_notes'] = newValue;
            renderUi();

        }
    });

    $('#create_invoice').change(function() {
        cart['extra']['create_invoice'] = $('#create_invoice').is(':checked') ? '1' : '0';
        renderUi();
    });


    $('#change_date_enable').is(':checked') ? $("#change_cart_date_picker").show() : $(
        "#change_cart_date_picker").hide();

    $('#change_date_enable').click(function() {
        if ($(this).is(':checked')) {
            $("#change_cart_date_picker").show();
        } else {
            $("#change_cart_date_picker").hide();
        }
    });

    date_time_picker_field($("#change_cart_date"), JS_DATE_FORMAT + " " + JS_TIME_FORMAT);

    $("#change_cart_date").on("dp.change", function(e) {

        cart['custom_fields']['change_cart_date'] = $('#change_cart_date').val();
        renderUi();

    });


    $("#receipt-comment").change(function() {

        cart['custom_fields']['receipt-comment'] = $('#receipt-comment').val();
        renderUi();

    });


    //Input change
    $("#change_cart_date").change(function() {

        cart['custom_fields']['change_cart_date'] = $('#change_cart_date').val();
        renderUi();

    });

    $('#prompt_for_card').change(function() {

        cart['custom_fields']['prompt_for_card'] = $('#prompt_for_card').is(':checked') ? '1' : '0';
        renderUi();
    });




    //Set Item tier after selection
    $('.item-tiers a').on('click', function(e) {
        e.preventDefault();
        $('.selected-tier').html($(this).text());
        cart.items.forEach(item => {
                item.previous_tier_id = (item.tier_id)?item.tier_id:0;
                item.tier_id = $(this).data('value'); 
                item.tier_name = $(this).text();
                
        });
        

        localStorage.setItem("cart", JSON.stringify(cart));


        refresh_cart_var();


        set_tier_id($(this).data('value'));

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
        $('.select-sales-persons').slideToggle("fast");
        cart['extra']['sold_by_employee_id'] = $(this).data('value');
        cart['extra']['permission_edit_sale_price'] = $(this).data('permission_edit_sale_price');
        renderUi();
    });

    //Slide Toggle item tier options
    $('.select-sales-person').on('click', function(e) {
        e.preventDefault();
        $('.select-sales-persons').slideToggle("fast");
    });


});

$(document).ready(function() {
    var isResizing = false;

    $('#drag-handle').on('mousedown', function(e) {
        e.preventDefault();
        isResizing = true;
        $(document).mousemove(mouseMoveHandler); // Bind mousemove when mousedown
        $(document).mouseup(stopResize); // Unbind mousemove when mouseup
    });

    function mouseMoveHandler(e) {
        if (!isResizing) return;

        var containerOffsetLeft = $('#main-container').offset().left;
        var containerWidth = $('#main-container').outerWidth();
        var leftWidth = e.clientX - containerOffsetLeft;

        var percentageLeft = (leftWidth / containerWidth) * 100;
        percentageLeft = Math.max(40, Math.min(percentageLeft, 60)); // Ensure the width is between 40% and 60%
        var percentageRight = 100 - percentageLeft;

        $('#left-section').css('width', `${percentageLeft}%`);
        $('#sales_section').css('width', `${percentageRight}%`);

        adjustColumnClasses(leftWidth); // Adjust columns continuously as the mouse moves
    }

    function stopResize() {
        $(document).off('mousemove', mouseMoveHandler); // Unbind mousemove
        isResizing = false;
    }

    function adjustColumnClasses() {
        var containerWidth = $('#left-section').width();
        // Example: Adjust based on the new width of the left-section
        if (containerWidth <= 576) { // Smaller devices
            $('#category_item_selection_wrapper_new .col-md-3, #category_item_selection_wrapper_new .col-lg-2')
                .addClass('col-sm-4').removeClass('col-md-3 col-lg-2');
        } else if (containerWidth > 576 && containerWidth <= 768) { // Medium devices
            $('#category_item_selection_wrapper_new .col-sm-4, #category_item_selection_wrapper_new .col-lg-2')
                .addClass('col-md-3').removeClass('col-sm-4 col-lg-2');
        } else { // Larger devices
            $('#category_item_selection_wrapper_new .col-sm-4, #category_item_selection_wrapper_new .col-md-3')
                .addClass('col-lg-2').removeClass('col-sm-4 col-md-3');
        }
    }








});


function inc_de_qty(itemIndex, qty) {
    cart = JSON.parse(localStorage.getItem('cart'));

    // console.log('cart', cart);

    if (parseInt(itemIndex) !== -1) {

        // Update quantity if item exists
        cart.items[parseInt(itemIndex)].quantity = (cart.items[parseInt(itemIndex)].quantity + parseInt(qty) > 0) ? cart
            .items[parseInt(itemIndex)]
            .quantity + parseInt(qty) : 1;

        // localStorage.setItem('cart', JSON.stringify(cart));
        localStorage.setItem("cart", JSON.stringify(cart));
        cart = JSON.parse(localStorage.getItem('cart'));
        renderUi();
    }

}

function updateOnlineStatus() {
    const statusDiv = document.getElementById('network-status');
    if (navigator.onLine) {
        statusDiv.className = 'online';
        statusDiv.textContent = 'Back to online';
    } else {
        statusDiv.className = 'offline';
        statusDiv.textContent = 'You are offline';
    }
    statusDiv.style.display = 'block'; // Ensure the div is visible before fading out

    // Set a timeout to fade out and hide the status bar after 5 seconds
    setTimeout(() => {
        //  statusDiv.style.opacity = '0'; // Start the fade-out
        setTimeout(() => {
            statusDiv.className = 'hidden'; // Fully hide after the opacity transition
        }, 500); // This should match the transition duration
    }, 5000); // Show the message for 5 seconds
}

// Event listeners for online and offline events
window.addEventListener('online', updateOnlineStatus);
window.addEventListener('offline', updateOnlineStatus);

// Initial check to set the correct status as soon as the script loads
updateOnlineStatus();
</script>


<script type="text/javascript">
edit_variation_index = 'none';
function showNextAttribute(currentIndex, attributeKeys) {
        if (currentIndex >= attributeKeys.length) {
            $('#attributeModal').modal('hide');
            // alert('All attributes selected!');
            console.log('item_obj:', item_obj);
            console.log('item_obj var:', item_obj.variations);
            let resultString = '';
            $.each(selectedAttributes, function(attributeKey, selectedValueKey) {
                resultString += selectedValueKey;
              
            });

            let matchingVariation = item_obj.variations.find(variation => variation.attribute_string ===
                resultString);
            // var selling_price = parseFloat(matchingVariation.price);
            // console.log(selling_price);

            selling_price = matchingVariation.price_without_currency;
            addItem({
                name: item_obj.name + " [ " + matchingVariation.name + " ]",
                description: '',
                item_id: matchingVariation.id,
                quantity: 1,
                selected_variation: selectedAttributes,
                price: selling_price,
                orig_price: selling_price,
                discount_percent: 0,
                variations: matchingVariation.has_variations,
                modifiers: item_obj.modifiers,
                taxes: matchingVariation.has_variations,
                tax_included: matchingVariation.tax_included
            });


            // addItem(matchingVariation);
            renderUi();
            console.log('Selected Attributes:', matchingVariation);
            return;
        }

        const currentAttributeKey = attributeKeys[currentIndex];
        const currentAttribute = attributes[currentAttributeKey];
        const options = currentAttribute.attr_values;

        let optionsHtml = ``;
        optionsHtml +=
            `
                <div class="fv-row mb-15 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid" data-kt-buttons="true" data-kt-initialized="1">`;
        for (let key in options) {
            const isChecked = selectedAttributes[currentAttributeKey] === key ? 'checked' : '';
            optionsHtml += ` <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
                <!--begin::Input-->
                <input class="form-check-input" type="radio" name="attributeOption" id="option-${key}" value="${key}" ${isChecked}>
                <!--end::Input-->

                <!--begin::Label-->
                <span class="d-flex">
                
                    <span class="ms-4">
                        <span class="fs-3 fw-bold text-gray-900   mt-3 d-block" for="option-${key}">${options[key].name}</span>

                    </span>
                    <!--end::Info-->
                </span>
                <!--end::Label-->
            </label> `;
        }
        optionsHtml += `</div`;
        $('#attributeOptions').html(optionsHtml);
        $('#attributeModalLabel').text(`Select ${currentAttribute.name}`);
        $('#attributeModal').modal('show');
    }
function edit_variation(index){
            
            cart_item =   cart.items[index];
            console.log("edit variant" , item_obj);

            if (cart_item.item_id.includes('#')) {
                // Extract the value before '#'
                valueBeforeHash = cart_item.item_id.split('#')[0];
                item_obj = items_list[valueBeforeHash];
                attributes = item_obj.item_attributes_available;
                attributeKeys = Object.keys(attributes);
                currentIndex = 0;
                selectedAttributes = cart_item.selected_variation;
                edit_variation_index = index;
                showNextAttribute(currentIndex, attributeKeys);
            } 


            // item_obj = items_list[$(this).data('id')];
            // attributes = item_obj.item_attributes_available;
            // attributeKeys = Object.keys(attributes);
            // currentIndex = 0;
            // selectedAttributes = {};




            // // Start the process
            // showNextAttribute(currentIndex, attributeKeys);


    }


function addItem(newItem) {

    //  console.log("yesses");
    let found = false;


    <?php if(!$this->config->item('do_not_group_same_items')): ?>
        if( edit_variation_index == 'none'){
            if (parseInt(newItem.item_id) != 0 ) {
                for (let item of cart.items) {

                    if (item.item_id === newItem.item_id) {
                        item.quantity = item.quantity + 1; // example: updating quantity
                        found = true;
                        break;
                    }
                }
            }
        }
   
    <?php endif; ?>
    if (!found) {
        if (cart['extra']['redeem'] == true) {
            newItem.discount_percent = cart['extra']['discount_all_percent'];
        }
        if (cart['extra']['tier_id'] ) {
            newItem.previous_tier_id = 0;
            newItem.tier_id = cart['extra']['tier_id'];
            newItem.tier_name = $all_tiers[cart['extra']['tier_id']].text;
            
        }
        // check if variation then append  parent name
        // if (newItem.item_id.includes('#')) {
        //     main_product_id = newItem.item_id.split('#')[0];
        //     newItem.name  = items_list[main_product_id].name + " [ " + newItem.name + " ]";
        // } 
      
        if (edit_variation_index !== 'none') {
            // Replace the item at the specific index
            cart['items'][edit_variation_index] = newItem;
        } else {
            // Add the new item to the end of the array
            cart['items'].push(newItem);
        }
    }

}
selected_line_modifier = 'none';

function enable_popup_modifier(line) {
                selected_line_modifier = line;
                      console.log("enable_popup_modifier" , cart.items[line].modifiers); 


                      console.log("selected_item_modifiers" , cart.items[line].selected_item_modifiers); 


                      options = cart.items[line].modifiers;
                      let optionsHtml = ``;
        optionsHtml +=
            `
                <div class="fv-row mb-15 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid" data-kt-buttons="true" data-kt-initialized="1">`;
        for (let key in options) {
            let modifier = cart.items[line].modifiers[key];
            if(!options[key].unit_price){
             continue;
            }
            // isChecked = '';
            let isChecked = false;
            if(cart.items[line].selected_item_modifiers){
                isChecked = cart.items[line].selected_item_modifiers.some(
                    selectedModifier => selectedModifier.id === modifier.id
                );
            }
             

        
           const isChecked_val = isChecked ? 'checked' : '';
            optionsHtml += ` <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
                <!--begin::Input-->
               <div class="form-check"> <input class="form-check-input" type="checkbox" name="modifierOption" id="option_modifier-${key}" value="${key}"  ${isChecked_val}> </div>
                <!--end::Input-->

                <!--begin::Label-->
                <span class="d-flex">
                
                    <span class="ms-4">
                        <span class="fs-3 fw-bold text-gray-900   mt-3 d-block" for="option_modifier-${key}"> <?= lang('name') ?> : ${options[key].name} <br> <?= lang('unit_price') ?> : ${options[key].unit_price_currency} </span>

                    </span>
                    <!--end::Info-->
                </span>
                <!--end::Label-->
            </label> `;
        }
        optionsHtml += `</div`;
        $('#modifiersOptions').html(optionsHtml);

        jQuery('#choose_modifiers').modal('show');
						
					}
$(document).ready(function() {
    <?php if ($this->config->item('require_employee_login_before_each_sale') && isset($dont_switch_employee) && !$dont_switch_employee) { ?>
    $('#switch_user').trigger('click');
    <?php } ?>

    $(window).load(function() {
        setTimeout(function() {
            <?php if ($fullscreen) { ?>
            $('.fullscreen').click();
            <?php } else {
				?>
            $('.dismissfullscreen').click();
            <?php
				} ?>

        }, 0);
    });

    <?php if ($this->config->item('always_show_item_grid') && $mode != 'store_account_payment') { ?>
    $(".show-grid").click();
    <?php } ?>

    var current_category_id = null;
    var current_tag_id = null;
    var current_supplier_id = null;

    var categories_stack = [{
        category_id: 0,
        name: <?php echo json_encode(lang('all')); ?>
    }];

    function updateBreadcrumbs(item_name) {
        var breadcrumbs =
            '<span class="svg-icon svg-icon-2 svg-icon-white me-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 12C22 12.2 22 12.5 22 12.7L19.5 10.2L16.9 12.8C16.9 12.5 17 12.3 17 12C17 9.5 15.2 7.50001 12.8 7.10001L10.2 4.5L12.7 2C17.9 2.4 22 6.7 22 12ZM11.2 16.9C8.80001 16.5 7 14.5 7 12C7 11.7 7.00001 11.5 7.10001 11.2L4.5 13.8L2 11.3C2 11.5 2 11.8 2 12C2 17.3 6.09999 21.6 11.3 22L13.8 19.5L11.2 16.9Z" fill="currentColor"/><path opacity="0.3" d="M22 12.7C21.6 17.9 17.3 22 12 22C11.8 22 11.5 22 11.3 22L13.8 19.5L11.2 16.9C11.5 16.9 11.7 17 12 17C14.5 17 16.5 15.2 16.9 12.8L19.5 10.2L22 12.7ZM10.2 4.5L12.7 2C12.5 2 12.2 2 12 2C6.7 2 2.4 6.1 2 11.3L4.5 13.8L7.10001 11.2C7.50001 8.8 9.5 7 12 7C12.3 7 12.5 7.00001 12.8 7.10001L10.2 4.5Z" fill="currentColor"/></svg></span> ';
        for (var k = 0; k < categories_stack.length; k++) {
            var category_name = categories_stack[k].name;
            var category_id = categories_stack[k].category_id;

            breadcrumbs += (k != 0 ? '  ' : '') +
                '<a href="javascript:void(0);"class="category_breadcrumb_item text-light" data-category_id = "' +
                category_id + '">' + category_name +
                ' 	<span class="svg-icon svg-icon-2 svg-icon-white mx-1"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path></svg></span> </a>';
        }

        if (typeof item_name != "undefined" && item_name) {
            breadcrumbs += '  : ' + item_name;
        }

        $("#grid_breadcrumbs").html(breadcrumbs);
    }

    $(document).on('click', ".category_breadcrumb_item", function() {
        var clicked_category_id = $(this).data('category_id');
        var categories_size = categories_stack.length;
        current_category_id = clicked_category_id;

        for (var k = 0; k < categories_size; k++) {
            var current_category = categories_stack[k]
            var category_id = current_category.category_id;

            if (category_id == clicked_category_id) {
                if (categories_stack[k + 1] != undefined) {
                    categories_stack.splice(k + 1, categories_size - k - 1);
                }
                break;
            }
        }

        if (current_category_id != 0) {
            loadCategoriesAndItems(current_category_id, 0);
        } else {
            loadTopCategories();
        }
    });

    function loadTopCategories() {
        $('#grid-loader').show();
        $.get('<?php echo site_url("sales/categories"); ?>', function(json) {
            processCategoriesResult(json);
            if ($('#category_item_selection li:first-child').data('category_id') == 'top' || $(
                    '#category_item_selection li:first-child').data('category_id') == 'my_sareeh') {
                $('#category_item_selection li:first-child').trigger('click');
            }
        }, 'json');
    }

    function loadTags() {
        $('#grid-loader').show();
        $.get('<?php echo site_url("sales/tags"); ?>', function(json) {
            processTagsResult(json);
        }, 'json');
    }

    function loadSuppliers() {
        $('#grid-loader').show();
        $.get('<?php echo site_url("sales/suppliers"); ?>', function(json) {
            processSuppliersResult(json);
        }, 'json');
    }


    function loadCategoriesAndItems(category_id, offset) {
        $('#grid-loader').show();
        current_category_id = category_id;
        //Get sub categories then items
        $.get('<?php echo site_url("sales/categories_and_items"); ?>/' + current_category_id + '/' + offset,
            function(json) {
                processCategoriesAndItemsResult(json);
            }, "json");
    }

    function loadCategoriesAndItemsUrl(category_id, url) {
        $('#grid-loader').show();
        current_category_id = category_id;
        //Get sub categories then items
        $.get(url, function(json) {
            processCategoriesAndItemsResult(json);
        }, "json");
    }

    function loadTagItems(tag_id, offset) {
        $('#grid-loader').show();
        current_tag_id = tag_id;
        //Get sub categories then items
        $.get('<?php echo site_url("sales/tag_items"); ?>/' + tag_id + '/' + offset, function(json) {
            processTagItemsResult(json);
        }, "json");
    }

    function loadTagItemsUrl(tag_id, url) {
        $('#grid-loader').show();
        current_tag_id = tag_id;
        //Get sub categories then items
        $.get(url, function(json) {
            processTagItemsResult(json);
        }, "json");
    }

    function loadFavoriteItems(offset) {
        $('#grid-loader').show();
        //Get sub categories then items
        $.get('<?php echo site_url("sales/favorite_items"); ?>/' + offset, function(json) {
            processFavoriteItemsResult(json);
        }, "json");
    }

    function loadFavoriteItemsUrl(url) {
        $('#grid-loader').show();
        $.get(url, function(json) {
            processFavoriteItemsResult(json);
        }, "json");
    }

    function loadSupplierItem(supplier_id, offset) {
        $('#grid-loader').show();
        current_supplier_id = supplier_id;
        //Get sub categories then items
        $.get('<?php echo site_url("sales/supplier_items"); ?>/' + supplier_id + '/' + offset, function(json) {
            processSupplierItemsResult(json);
        }, "json");
    }

    function loadSupplierItemsUrl(supplier_id, url) {
        $('#grid-loader').show();
        current_supplier_id = supplier_id;
        //Get sub categories then items
        $.get(url, function(json) {
            processSupplierItemsResult(json);
        }, "json");
    }



    $(document).on('click', ".pagination.categories a", function(event) {
        $('#grid-loader').show();
        event.preventDefault();
        $.get($(this).attr('href'), function(json) {
            processCategoriesResult(json);

        }, "json");
    });

    $(document).on('click', ".pagination.tags a", function(event) {
        $('#grid-loader').show();
        event.preventDefault();

        $.get($(this).attr('href'), function(json) {
            processTagsResult(json);

        }, "json");
    });

    $(document).on('click', ".pagination.suppliers a", function(event) {
        $('#grid-loader').show();
        event.preventDefault();

        $.get($(this).attr('href'), function(json) {
            processSuppliersResult(json);

        }, "json");
    });

    $(document).on('click', ".pagination.categoriesAndItems a", function(event) {
        $('#grid-loader').show();
        event.preventDefault();
        loadCategoriesAndItemsUrl(current_category_id, $(this).attr('href'));
    });

    $(document).on('click', ".pagination.items a", function(event) {
        $('#grid-loader').show();
        event.preventDefault();
        loadTagItemsUrl(current_tag_id, $(this).attr('href'));
    });

    $(document).on('click', ".pagination.favorite a", function(event) {
        $('#grid-loader').show();
        event.preventDefault();
        loadFavoriteItemsUrl($(this).attr('href'));
    });

    $(document).on('click', ".pagination.supplierItems a", function(event) {
        $('#grid-loader').show();
        event.preventDefault();
        loadSupplierItemsUrl(current_supplier_id, $(this).attr('href'));
    });



    $('#category_item_selection_wrapper').on('click', '.category_item.category', function(event) {
        event.preventDefault();
        current_category_id = $(this).data('category_id');
        category_count = $(this).data('category_count');
        var category_obj = {
            category_id: current_category_id,
            name: $(this).find('p').text()
        };
        if (category_count > 0) {
            categories_stack.push(category_obj);
        }

        loadCategoriesAndItems($(this).data('category_id'), 0);
    });

    $('#category_item_selection_wrapper').on('click', '.category_item.tag', function(event) {
        event.preventDefault();
        current_tag_id = $(this).data('tag_id');
        loadTagItems($(this).data('tag_id'), 0);
    });

    $('#category_item_selection_wrapper').on('click', '.category_item.supplier', function(event) {
        event.preventDefault();
        current_supplier_id = $(this).data('supplier_id');
        loadSupplierItem($(this).data('supplier_id'), 0);
    });


    $('#grid_selection').on('click', '#by_category', function(event) {
        current_category_id = null;
        current_tag_id = null;
        $("#grid_breadcrumbs").html('');
        $('.menu-link').removeClass('active');
        $(this).addClass('active');
        categories_stack = [{
            category_id: 0,
            name: <?php echo json_encode(lang('all')); ?>
        }];
        loadTopCategories();
    });

    $('#grid_selection').on('click', '#by_tag', function(event) {
        current_category_id = null;
        current_tag_id = null;
        $('.menu-link').removeClass('active');
        $(this).addClass('active');
        $("#grid_breadcrumbs").html('');
        loadTags();
    });

    $('#grid_selection').on('click', '#by_favorite', function(event) {
        current_category_id = null;
        current_tag_id = null;
        $('.menu-link').removeClass('active');
        $(this).addClass('active');
        $("#grid_breadcrumbs").html('');
        loadFavoriteItems(0);
    });

    $('#grid_selection').on('click', '#by_supplier', function(event) {
        current_category_id = null;
        current_tag_id = null;
        current_supplier_id = null;
        $("#grid_breadcrumbs").html('');
        $('.menu-link').removeClass('active');
        $(this).addClass('active');
        loadSuppliers();
    });


    $('#category_item_selection').on('click', '.category_item.item', function(event) {


        console.log("clicked");
        $('#grid-loader').show();
        event.preventDefault();

        var $that = $(this);
        if ($(this).data('has-variations')) {
            console.log("it has variants");
        } else {
            console.log(items_list);
            item_obj = items_list[$(this).data('id')];
            console.log(item_obj);
            addItem(item_obj);
            renderUi();
            let lastUpdated = localStorage.getItem('lastUpdated');
        }
    });



 

    attributes = {};
    attributeKeys = {};
    currentIndex = 0;
    selectedAttributes = {};
    item_obj = {};

    $('#nextAttribute').click(function() {
        selectedOption = $('input[name="attributeOption"]:checked').val();
        if (!selectedOption) {
            alert('Please select an option');
            return;
        }

        currentAttributeKey = attributeKeys[currentIndex];
        selectedAttributes[currentAttributeKey] = selectedOption;
       
        currentIndex++;
        showNextAttribute(currentIndex, attributeKeys);
    });

    $('#backAttribute').click(function() {
        if (currentIndex > 0) {
            currentIndex--;
            showNextAttribute(currentIndex, attributeKeys);
        }
    });

    $('#saveAttribute').click(function() {
        var selectedValues = $('input[name="modifierOption"]:checked').map(function() {
            return $(this).val();
        }).get();

        
        // cart.item.modifiers
        var selectedModifiers = selectedValues.map(function(key) {
            return cart.items[selected_line_modifier].modifiers[key];
        });

        const indexedModifiers = selectedModifiers.reduce((acc, item) => {
            acc[item.id] = item;
            return acc;
        }, {});

        console.log(indexedModifiers);
        cart.items[selected_line_modifier].selected_item_modifiers = indexedModifiers;
        // console.log(selectedModifiers);
        selected_line_modifier = 'none';
        jQuery('#choose_modifiers').modal('hide');
        renderUi();
    });
    $('#category_item_selection_wrapper_new').on('click', '.category_item.item', function(event) {
        // console.log("clicked");
        $('#grid-loader').show();
        event.preventDefault();
        edit_variation_index = 'none';
        var $that = $(this);
        if ($(this).data('has-variations')) {
         
            item_obj = items_list[$(this).data('id')];
            attributes = item_obj.item_attributes_available;
            attributeKeys = Object.keys(attributes);
            currentIndex = 0;
            selectedAttributes = {};




            // Start the process
            showNextAttribute(currentIndex, attributeKeys);



        } else {




            item_obj = items_list[$(this).data('id')];
            // console.log(item_obj);
            addItem(item_obj);
            localStorage.setItem('is_cart_oc_updated', 0);
            let lastUpdated = localStorage.getItem('lastUpdated');
            renderUi();
            $('#grid-loader').hide();
        }
    });





    $("#category_item_selection_wrapper").on('click', '#back_to_categories', function(event) {
        $('#grid-loader').show();
        event.preventDefault();

        //Remove element from stack
        categories_stack.pop();

        //Get current last element
        var back_category = categories_stack[categories_stack.length - 1];

        if (back_category.category_id != 0) {
            loadCategoriesAndItems(back_category.category_id, 0);
        } else {
            loadTopCategories();
        }
    });

    $("#category_item_selection_wrapper").on('click', '#back_to_tags', function(event) {
        $('#grid-loader').show();
        event.preventDefault();
        loadTags();
    });

    $("#category_item_selection_wrapper").on('click', '#back_to_tag', function(event) {
        $('#grid-loader').show();
        event.preventDefault();
        loadTagItems(current_tag_id, 0);
    });

    $("#category_item_selection_wrapper").on('click', '#back_to_category', function(event) {
        $('#grid-loader').show();
        event.preventDefault();

        //Get current last element
        var back_category = categories_stack[categories_stack.length - 1];

        if (back_category.category_id != 0) {
            loadCategoriesAndItems(back_category.category_id, 0);
        } else {
            loadTopCategories();
        }
    });

    $("#category_item_selection_wrapper").on('click', '#back_to_favorite', function(event) {
        $('#grid-loader').show();
        event.preventDefault();
        loadFavoriteItems(0);
    });

    $("#category_item_selection_wrapper").on('click', '#back_to_suppliers', function(event) {
        $('#grid-loader').show();
        event.preventDefault();
        loadSuppliers();
    });

    $("#category_item_selection_wrapper").on('click', '#back_to_supplier', function(event) {
        $('#grid-loader').show();
        event.preventDefault();
        loadSuppliersItems(current_supplier_id, 0);
    });



    function processCategoriesResult(json) {

        $("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('tags')
            .removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('categories');
        $("#category_item_selection_wrapper .pagination").html(json.pagination);

        $("#category_item_selection").html('');

        for (var k = 0; k < json.categories.length; k++) {
            var category_item = $("<div/>").attr('class',
                    'category_item category col-md-2 register-holder categories-holder col-sm-3 col-xs-6').css(
                    'background-color', json.categories[k].color).data('category_id', json.categories[k].id)
                .append('<p> <i class="ion-ios-folder-outline"></i> ' + json.categories[k].name + '</p>');

            if (json.categories[k].image_id) {
                category_item.css('background-color', 'white');
                category_item.css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json
                    .categories[k].image_id + '?timestamp=' + json.categories[k].image_timestamp + ')');
            }

            var categ_badge = '';
            if (json.categories[k].categories_count > 0) {
                categ_badge = '<span class="symbol-badge badge badge-circle bg-danger top-10 start-15">' + json
                    .categories[k].categories_count + '</span>';
            }
            var item_badge = '';
            if (json.categories[k].items_count > 0) {
                item_badge = '<span class="symbol-badge badge badge-circle bg-success top-10 start-80">' + json
                    .categories[k].items_count + '</span>';
            }
            if (json.categories[k].color != '') {
                category_style = "style='background-color:" + json.categories[k].color + " '";
            } else {
                category_style = "";
            }
            category_item = '<li data-category_count="' + json.categories[k].categories_count +
                '" data-category_id="' + json.categories[k].id +
                '" class="  category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation" ' +
                category_style +
                '><a class=" border border-gray-900  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active symbol" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"> ' +
                item_badge + ' ' + categ_badge +
                ' <div class="nav-icon "> <img class="rounded-3 mb-4" alt="" src="' + SITE_URL +
                '/app_files/view_cacheable/' + json.categories[k].image_id + '?timestamp=' + json.categories[k]
                .image_timestamp +
                '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories[
                    k].name +
                '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


            $("#category_item_selection").append(category_item);
            $('.register-holder.categories-holder').click(function() {
                if ($(this).data('category_count') == 0) {
                    // Remove selected-holder class from siblings
                    $(this).siblings().removeClass('selected-holder');

                    // Add selected-holder class to the clicked element
                    $(this).addClass('selected-holder');
                }
            })
        }

        updateBreadcrumbs();
        $('#grid-loader').hide();
    }

    function processTagsResult(json) {
        $("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass(
                'categories').removeClass('items').removeClass('suppliers').removeClass("supplierItems")
            .addClass('tags');
        $("#category_item_selection_wrapper .pagination").html(json.pagination);

        $("#category_item_selection").html('');

        for (var k = 0; k < json.tags.length; k++) {
            //var tag_item = $("<div/>").attr('class', 'category_item tag col-md-2 register-holder tags-holder col-sm-3 col-xs-6').data('tag_id', json.tags[k].id).append('<p> <i class="ion-ios-pricetag-outline"></i> ' + json.tags[k].name + '</p>');

            var tag_item = '<li data-tag_id="' + json.tags[k].id +
                '"  class=" col-1  category_item tag register-holder tags-holder  nav-item mb-3 me-3 me-lg-6" role="presentation"><div class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active " data-bs-toggle="pill"  aria-selected="true" role="tab"><div class="nav-icon"><i class="ion-ios-pricetag-outline text-danger " style="font-size:60px"></i> </div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' +
                json.tags[k].name +
                '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></div></li>';

            $("#category_item_selection").append(tag_item);
        }

        $('#grid-loader').hide();
    }

    function processSuppliersResult(json) {
        $("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('tags')
            .removeClass('items').removeClass('categories').removeClass("supplierItems").addClass('suppliers');
        $("#category_item_selection_wrapper .pagination").html(json.pagination);

        $("#category_item_selection").html('');

        for (var k = 0; k < json.suppliers.length; k++) {
            // var supplier_item = $("<div/>").attr('class', 'category_item supplier col-md-2 register-holder categories-holder col-sm-3 col-xs-6').data('supplier_id', json.suppliers[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.suppliers[k].name + '</p>');

            // if (json.suppliers[k].image_id) {
            // 	supplier_item.css('background-color', 'white');
            // 	supplier_item.css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.suppliers[k].image_id + '?timestamp=' + json.suppliers[k].image_timestamp + ')');
            // }

            supplier_item = '<li data-supplier_id="' + json.suppliers[k].id +
                '" class=" col-2 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-125px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' +
                SITE_URL + '/app_files/view_cacheable/' + json.suppliers[k].image_id + '?timestamp=' + json
                .suppliers[k].image_timestamp +
                '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.suppliers[
                    k].name +
                '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


            $("#category_item_selection").append(supplier_item);
        }
        $('#grid-loader').hide();
    }

    function processCategoriesAndItemsResult(json) {


        $("#category_item_selection_wrapper_new").html('');

        if (json.categories_count > 0) {
            $("#category_item_selection").html('');
            var back_to_categories_button =
                '<li id="back_to_categories" class="  nav-item mb-3 me-3 pr-0 pl-0 register-holder" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' +
                SITE_URL +
                '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

            $("#category_item_selection").append(back_to_categories_button);
        }


        for (var k = 0; k < json.categories_and_items.length; k++) {
            var categ_badge = '';
            if (json.categories_and_items[k].categories_count > 0) {
                categ_badge = '<span class="symbol-badge badge badge-circle bg-danger top-10 start-15">' + json
                    .categories_and_items[k].categories_count + '</span>';
            }
            var item_badge = '';
            if (json.categories_and_items[k].items_count > 0) {
                item_badge = '<span class="symbol-badge badge badge-circle bg-success top-10 start-80">' + json
                    .categories_and_items[k].items_count + '</span>';
            }

            if (json.categories_and_items[k].type == 'category') {
                // var category_item = $("<div/>").attr('class', 'category_item category col-md-2 register-holder categories-holder col-sm-3 col-xs-6').css('background-color', json.categories_and_items[k].color).css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.categories_and_items[k].image_id + '?timestamp=' + json.categories_and_items[k].image_timestamp + ')').data('category_id', json.categories_and_items[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.categories_and_items[k].name + '</p>');
                if (json.categories_and_items[k].color != '') {
                    category_style = "style='background-color:" + json.categories_and_items[k].color + " '";
                } else {
                    category_style = "";
                }
                var category_item = '<li data-category_id="' + json.categories_and_items[k].id +
                    '" class=" category_item category nav-item mb-3 me-3  pr-0 pl-0 register-holder" role="presentation" ' +
                    category_style +
                    '><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active symbol" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab">' +
                    categ_badge + '' + item_badge +
                    '<div class="nav-icon"><img class="rounded-3 mb-4 " alt="" src="' + SITE_URL +
                    '/app_files/view_cacheable/' + json.categories_and_items[k].image_id + '?timestamp=' + json
                    .categories_and_items[k].image_timestamp +
                    '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-8 lh-1"><p>' + json
                    .categories_and_items[k].name +
                    '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


                $("#category_item_selection").append(category_item);
            } else if (json.categories_and_items[k].type == 'item') {


                var image_src = json.categories_and_items[k].image_src;
                var has_variations = json.categories_and_items[k].has_variations;

                var prod_image = "";
                var image_class = "no-image";
                var item_parent_class = "";
                if (image_src != '') {
                    var item_parent_class = "item_parent_class";
                    var prod_image = '<img class="rounded-3 mb-4 h-auto" src="' + image_src + '" alt="" />';
                    var image_class = "has-image";
                } else {
                    image_src = '' + SITE_URL + '/assets/css_good/media/placeholder.png';
                }

                //  var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.categories_and_items[k].id).append(prod_image + '<p>' + json.categories_and_items[k].name + '<br /> <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>');

                //var item = '<li data-has-variations="'+has_variations+'" data-id="'+json.categories_and_items[k].id+'" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories_and_items[k].name + '  <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
                //$("#category_item_selection").append(item);   
                currency_ = "<?php echo get_store_currency(); ?>"
                price = (json.categories_and_items[k].price ? ' ' + decodeHtml(json.categories_and_items[k]
                    .price) + ' ' : '');
                price_val = (json.categories_and_items[k].price ? decodeHtml(json.categories_and_items[k]
                    .price) : '');
                price_val = price_val.replace(currency_, '');


                items_list[json.categories_and_items[k].id] = {
                    name: json.categories_and_items[k].name,
                    description: 'need data here',
                    item_id: json.categories_and_items[k].id,
                    quantity: 1,
                    price: price_val,
                    orig_price: price_val,
                    discount_percent: 0,
                    variations: has_variations,
                    item_attributes_available: json.categories_and_items[k].item_attributes_available,
                    allow_price_override_regardless_of_permissions: json.categories_and_items[k].allow_price_override_regardless_of_permissions,
                    modifiers: json.categories_and_items[k].modifiers,
                    taxes: json.categories_and_items[k].item_taxes,
                    tax_included: json.categories_and_items[k].tax_included
                }



                htm =
                    '<div class="col-sm-4  col-md-3 col-lg-2 mb-2 col-xxl-2 category_item item  register-holder ' +
                    image_class + ' ' + item_parent_class + ' " data-has-variations="' + has_variations +
                    '" data-max_discount="' + json.categories_and_items[k].max_discount +
                    '" data-can_override_price_adjustments="' + json.categories_and_items[k]
                    .can_override_price_adjustments + '" data-tax_percent="' + json.categories_and_items[k]
                    .tax_percent + '" data-override_default_tax="' + json.categories_and_items[k]
                    .override_default_tax + '" data-tax_included="' + json.categories_and_items[k]
                    .tax_included + '"   data-name="' + json.categories_and_items[k].name + '"  data-price="' +
                    price_val + '" data-id="' + json.categories_and_items[k].id +
                    '" "><div class="card card-flush bg-light h-xl-100"><!--begin::Body--><div class="card-body text-center pb-5"><!--begin::Overlay--><div class="d-block overlay" ><!--begin::Image--><div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded mb-7" style="height: 90px;background-image:url(' +
                    image_src +
                    ')"><span   class="position-absolute symbol-badge badge  badge-light top-75 end-0 price_of_item ">' +
                    price +
                    '</span></div><!--end::Image--><!--begin::Action--><div class="overlay-layer card-rounded bg-dark bg-opacity-25"><i class="bi  fs-2x text-white"></i></div><!--end::Action--></div><!--end::Overlay--><!--begin::Info--><span class="fw-bold text-left text-gray-800 cursor-pointer text-hover-primary fs-6 d-block mt-minus-10">' +
                    json.categories_and_items[k].name +
                    '</span><div class="d-flex align-items-end flex-stack mb-1"></div><!--end::Info--></div><!--end::Body--><span class="position-absolute symbol-badge badge   badge-circle badge-light-primary fs-2 h-30px w-30px  bottom-5 end-5 ">+</span></div><!--end::Card widget 14--></div>';
                $("#category_item_selection_wrapper_new").append(htm);

            }
        }

        // console.log('items_list' , items_list);

        $("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags')
            .removeClass('items').removeClass('favorite').removeClass('suppliers').removeClass("supplierItems")
            .addClass('categoriesAndItems');
        $("#category_item_selection_wrapper .pagination").html(json.pagination);

        updateBreadcrumbs();
        $('#grid-loader').hide();

    }

    function processTagItemsResult(json) {
        $("#category_item_selection").html('');
        //var back_to_categories_button = $("<div/>").attr('id', 'back_to_tags').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back_to_tags')); ?> + '</p>');

        var back_to_categories_button =
            '<li id="back_to_tags" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' +
            SITE_URL +
            '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


        $("#category_item_selection").append(back_to_categories_button);

        for (var k = 0; k < json.items.length; k++) {
            var image_src = json.items[k].image_src;
            var has_variations = json.items[k].has_variations ? 1 : 0;
            var prod_image = "";
            var image_class = "no-image";
            var item_parent_class = "";
            if (image_src != '') {
                var item_parent_class = "item_parent_class";
                var prod_image = '<img src="' + image_src + '" alt="" />';
                var image_class = "";
            }

            // var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.items[k].id).append(prod_image + '<p>' + json.items[k].name + '<br /> <span class="text-bold">' + (json.items[k].price ? '(' + json.items[k].price + ')' : '') + '</span></p>'); 
            currency_ = "<?php echo get_store_currency(); ?>"
            price = (json.items[k].price ? ' ' + decodeHtml(json.items[k].price) + ' ' : '');
            price_val = (json.items[k].price ? decodeHtml(json.items[k].price) : '');
            price_val = price_val.replace(currency_, '');


            var item = '<li data-max_discount="' + json.items[k].max_discount +
                '" data-can_override_price_adjustments="' + json.items[k].can_override_price_adjustments +
                '"  data-tax_percent="' + json.items[k].tax_percent + '" data-override_default_tax="' + json
                .items[k].override_default_tax + '" data-tax_included="' + json.items[k].tax_included +
                '"  data-name="' + json.items[k].name + '"  data-price="' + price_val + '" data-id="' + json
                .items[k].id + '"  data-has-variations="' + has_variations + '" data-id="' + json.items[k].id +
                '" class=" col-1 category_item item  ' + image_class + '  ' + item_parent_class +
                '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> ' +
                prod_image + '</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.items[k]
                .name + ' <span class="text-bold">' + (json.items[k].price ? '(' + decodeHtml(json.items[k]
                    .price) + ')' : '') +
                '</span></p>   </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


            $("#category_item_selection").append(item);

        }

        $("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags')
            .removeClass('categoriesAndItems').removeClass('favorite').removeClass('suppliers').removeClass(
                "supplierItems").addClass('items');
        $("#category_item_selection_wrapper .pagination").html(json.pagination);

        $('#grid-loader').hide();
    }

    function processFavoriteItemsResult(json) {
        $("#category_item_selection").html('');
        for (var k = 0; k < json.items.length; k++) {
            var image_src = json.items[k].image_src;
            var has_variations = json.items[k].has_variations ? 1 : 0;
            var prod_image = "";
            var image_class = "no-image";
            var item_parent_class = "";
            if (image_src != '') {
                var item_parent_class = "item_parent_class";
                var prod_image = '<img src="' + image_src + '" alt="" />';
                var image_class = "";
            }

            //    var item = $("<div/>").attr('data-is_favorite','yes').attr('data-has-variations',has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  '+item_parent_class).attr('data-id', json.items[k].id).append(prod_image+'<p>'+json.items[k].name+'<br /> <span class="text-bold">'+(json.items[k].price ? '('+json.items[k].price+')' : '')+'</span></p>');

            item = '<li data-supplier_id="' + json.items[k].id +
                '" class=" col-2 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-125px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' +
                image_src + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json
                .items[k].name +
                '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


            $("#category_item_selection").append(item);

        }

        $("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags')
            .removeClass('categoriesAndItems').removeClass('items').removeClass('suppliers').removeClass(
                "supplierItems").addClass('favorite');
        $("#category_item_selection_wrapper .pagination").html(json.pagination);

        $('#grid-loader').hide();
    }

    function processSupplierItemsResult(json) {
        $("#category_item_selection").html('');
        var back_to_categories_button = $("<div/>").attr('id', 'back_to_suppliers').attr('class',
            'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append(
            '<p>&laquo; ' + <?php echo json_encode(lang('back_to_suppliers')); ?> + '</p>');
        $("#category_item_selection").append(back_to_categories_button);

        for (var k = 0; k < json.items.length; k++) {
            var image_src = json.items[k].image_src;
            var has_variations = json.items[k].has_variations ? 1 : 0;
            var prod_image = "";
            var image_class = "no-image";
            var item_parent_class = "";
            if (image_src != '') {
                var item_parent_class = "item_parent_class";
                var prod_image = '<img src="' + image_src + '" alt="" />';
                var image_class = "";
            }

            var item = $("<div/>").attr('data-has-variations', has_variations).attr('class',
                'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' +
                item_parent_class).attr('data-id', json.items[k].id).append(prod_image + '<p>' + json.items[
                k].name + '<br /> <span class="text-bold">' + (json.items[k].price ? '(' + json.items[k]
                .price + ')' : '') + '</span></p>');
            $("#category_item_selection").append(item);

        }

        $("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags')
            .removeClass('categoriesAndItems').removeClass('favorite').removeClass('suppliers').removeClass(
                'items').addClass("supplierItems");
        $("#category_item_selection_wrapper .pagination").html(json.pagination);

        $('#grid-loader').hide();
    }


    <?php if ($this->config->item('default_type_for_grid') == 'tags') {  ?>
    <?php if($this->config->item('hide_tags_sales_grid') != 1 ){ ?>
    loadTags();
    <?php } ?>
    <?php } else if ($this->config->item('default_type_for_grid') == 'favorites') { ?>
    <?php if($this->config->item('hide_favorites_sales_grid') != 1 ){ ?>
    loadFavoriteItems(0);
    <?php } ?>
    <?php } else if ($this->config->item('default_type_for_grid') == 'suppliers') { ?>
    <?php if($this->config->item('hide_suppliers_sales_grid') != 1 ){ ?>
    loadSuppliers();
    <?php } ?>
    <?php } else { ?>
    <?php if($this->config->item('hide_categories_sales_grid') != 1 ){ ?>
    loadTopCategories();
    <?php } ?>
    <?php	} ?>









    $('.custom-fields').change(function() {
        console.log($(this).attr('name'));

        cart['custom_fields'][$(this).attr('name')] = $(this).val();
        renderUi();
        // $.post('<?php echo site_url("sales/save_custom_field"); ?>', {
        //     name: $(this).attr('name'),
        //     value: $(this).val()
        // });
    });

    $('.custom-fields-checkbox').change(function() {
        cart['custom_fields'][$(this).attr('name')] = $(this).val();
        renderUi();
        // $.post('<?php echo site_url("sales/save_custom_field"); ?>', {
        //     name: $(this).attr('name'),
        //     value: $(this).prop('checked') ? 1 : 0
        // });
    });

    $('.custom-fields-select').change(function() {
        cart['custom_fields'][$(this).attr('name')] = $(this).val();
        renderUi();
        // $.post('<?php echo site_url("sales/save_custom_field"); ?>', {
        //     name: $(this).attr('name'),
        //     value: $(this).val()
        // });
    });

    $(".custom-fields-date").on("dp.change", function(e) {
        cart['custom_fields'][$(this).attr('name')] = $(this).val();
        renderUi();
        // $.post('<?php echo site_url("sales/save_custom_field"); ?>', {
        //     name: $(this).attr('name'),
        //     value: $(this).val()
        // });
    });

    $('.custom-fields-file').change(function() {
        var name = $(this).attr('name');
        var formData = new FormData();
        formData.append('name', $(this).attr('name'));
        formData.append('value', $(this)[0].files[0]);

        $.ajax({
            url: '<?php echo site_url("sales/save_files_for_speedy"); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {

                cart['custom_fields'][name] = response;
                renderUi();
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the AJAX request
                console.error('An error occurred: ' + error);
            }
        });
    });


});

var last_focused_id = null;

setTimeout(function() {
    $('#item').focus();
}, 10);


$(document).ready(function() {
    const sidebarToggleElement = $('#kt_app_sidebar_toggle');
    const sidebarClass = 'pos-sidebar'; // Class to toggle on sidebar elements

    // Retrieve stored toggle state from localStorage (default to inactive)
    let isSidebarActive = localStorage.getItem('sidebarState') === 'active';



    // Apply initial toggle based on localStorage
    sidebarToggleElement.toggleClass('active', isSidebarActive);
    //   $(`.${sidebarClass}`).fadeToggle(isSidebarActive); // Use class selector with dot
    if (!isSidebarActive) {
        $(`.${sidebarClass}`).show();
    } else {
        $(`.${sidebarClass}`).hide();
    }
    // Handle click event on toggle element
    sidebarToggleElement.click(function() {
        isSidebarActive = !isSidebarActive; // Toggle active state

        // Update localStorage
        localStorage.setItem('sidebarState', isSidebarActive ? 'active' : 'inactive');

        // Toggle classes based on updated state
        $(this).toggleClass('active');
        $(`.${sidebarClass}`).fadeToggle();
    });



    function set_suspended_sale(id = '') {
        cart['extra']['comment'] = $('#comment').val();
        localStorage.setItem("cart", JSON.stringify(cart));



        //Reset cart
        cart = {};
        cart['items'] = [];
        cart['payments'] = [];
        cart['customer'] = {};
        cart['extra'] = {};
        cart['taxes'] = [];
        cart['custom_fields'] = {};
        var sale = localStorage.getItem('cart');

        <?php if ($this->config->item('show_receipt_after_suspending_sale')) { ?>

        displayReceipt(JSON.parse(sale));

        <?php } ?>


        //Save sales
        var allSales = JSON.parse(localStorage.getItem("sales")) || [];

        if (current_edit_index !== null) {
            allSales[current_edit_index] = JSON.parse(sale);
        } else {
            allSales.push(JSON.parse(sale));
        }
        localStorage.setItem("sales", JSON.stringify(allSales));
        var allSales = JSON.parse(localStorage.getItem("sales")) || [];

        $.post('<?php echo site_url("sales/suspend_speedy/"); ?>' + id + '', {
                offline_sales: JSON.stringify(allSales),
            },
            function(response) {
                if (response.success) {
                    $('#sync_offline_sales_button').remove();
                    localStorage.removeItem("sales");

                    <?php
					if (!$this->config->item('disable_sale_notifications')) {
                        ?>
                    show_feedback('success', "" + response.success + "", "<?php echo  lang('success') ?>");
                    <?php 
					}

					?>
                } else {
                    <?php
					if (!$this->config->item('disable_sale_notifications')) {
                        ?>
                    show_feedback('error', "" + response.error + "", "<?php echo  lang('error') ?>");
                    <?php 
					}

					?>
                }
            }, 'json');
        current_edit_index = null;
        renderUi();
    }

    //Layaway Sale
    $("#layaway_sale_button").click(function(e) {
        e.preventDefault();
        bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>, function(
            result) {
            if (result) {
                set_suspended_sale();
            }
        });
    });

    //Estimate Sale
    $("#estimate_sale_button").click(function(e) {
        e.preventDefault();
        bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>, function(
            result) {
            if (result) {
                set_suspended_sale(2);
            }
        });
    });

    $(".additional_suspend_button").click(function(e) {
        var suspend_index = $(this).data('suspend-index');
        e.preventDefault();
        bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>, function(
            result) {
            if (result) {
                set_suspended_sale(suspend_index);
            }
        });
    });



    $('#advance_details').on('click', function() {
        $('.drawer-overlay').remove();

        var operationsbox_modal = document.querySelector("#operationsbox_modal");

        var drawer = KTDrawer.getInstance(operationsbox_modal);
        drawer.show();
    });

});

<?php if($this->cart->suspended): ?>

function check_and_get_suspended_sale() {
    console.log("Checking and getting");

    $.post('<?php echo site_url("sales/check_and_get_suspended_sale/"); ?>', {
            offline_sales: '',
        },
        function(response) {
            cart = response;
            renderUi();
            // console.log(response);
        }, 'json');


}

check_and_get_suspended_sale();
<?php endif; ?>

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


                cart = {};
                cart['items'] = [];
                cart['payments'] = [];
                cart['customer'] = {};
                cart['extra'] = {};
                cart['custom_fields'] = {};
                cart['taxes'] = [];
                localStorage.removeItem("sales");
                localStorage.removeItem("cart");

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
</script>