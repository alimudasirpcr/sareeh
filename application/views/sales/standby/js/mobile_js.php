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
var currency_symbol = '<?php echo $this->config->item('currency_symbol'); ?>';
var cart_item_template = Handlebars.compile(document.getElementById("cart-item-template").innerHTML);
var cart_payment_template = Handlebars.compile(document.getElementById("cart-payment-template").innerHTML);
var saved_sale_template = Handlebars.compile(document.getElementById("saved-sale-template").innerHTML);
var sale_receipt_template = Handlebars.compile(document.getElementById("sale-receipt-template").innerHTML);
var list_item_template = Handlebars.compile(document.getElementById("list-item-template").innerHTML);
var list_category_template = Handlebars.compile(document.getElementById("list-category-template").innerHTML);
var list_hold_cart_template = Handlebars.compile(document.getElementById("list-hold-cart-template").innerHTML);
//data structures for cart

var current_edit_index = null;
var cart = JSON.parse(localStorage.getItem('cart')) || {};

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
if (typeof cart.taxes == 'undefined') {
    cart['taxes'] = [];
}
try {
    var db_customers = new PouchDB('phppos_customers', {
        revs_limit: 1
    });
    var db_items = new PouchDB('phppos_items', {
        revs_limit: 1
    });
    var db_category = new PouchDB('phppos_category', {
        revs_limit: 1
    });
    var db_taxes = new PouchDB('phppos_taxes', {
        revs_limit: 1
    });
} catch (exception_var) {

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
            cart['taxes'] = [];
            current_edit_index = null;

            renderUi();
        }
    });
});

$(document).on("click", '#finish_sale_button', function(e) {
    e.preventDefault();
    bootbox.confirm(<?php echo json_encode(lang('sales_confirm_finish_sale')); ?>, function(result) {
        if (result) {
            //Reset cart
            cart = {};
            cart['items'] = [];
            cart['payments'] = [];
            cart['customer'] = {};
            cart['extra'] = {};
            cart['taxes'] = [];
            var sale = localStorage.getItem('cart');
            displayReceipt(JSON.parse(sale));
            //Save sales
            var allSales = JSON.parse(localStorage.getItem("sales")) || [];

            if (current_edit_index !== null) {
                allSales[current_edit_index] = JSON.parse(sale);
            } else {
                allSales.push(JSON.parse(sale));
            }
            localStorage.setItem("sales", JSON.stringify(allSales));

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
$("#add_item_form").submit(function(e) {
    e.preventDefault();

    var search = $("#item").val().toLocaleLowerCase();
    db_items.find({
        selector: {
            "$or": [{
                    item_id: search
                },
                {
                    product_id: search
                },
                {
                    item_number: search
                }
            ]
        },
        fields: ['_id', 'name', 'description', 'unit_price', 'promo_price', 'start_date', 'end_date',
            'category', 'quantity', 'item_id', 'variations', 'modifiers', 'taxes', 'tax_included'
        ]
    }, function(err, result) {
        if (err) {
            return console.log(err);
        }

        var results = result.docs;
        if (results.length) {
            var item = results[0];

            var item_id = item.item_id;
            var item_name = item.name;
            var item_description = item.description;
            var quantity = 1;
            var unit_price = to_currency_no_money(item.unit_price);
            var promo_price = to_currency_no_money(item.promo_price);
            var start_date = item.start_date;
            var end_date = item.end_date;

            var selling_price = parseFloat(unit_price);


            var computed_promo_price = getPromoPrice(promo_price, start_date, end_date)

            if (computed_promo_price) {
                selling_price = computed_promo_price;
            }

            selling_price = to_currency_no_money(selling_price);

            var variations = item.variations;
            var modifiers = item.modifiers;
            var taxes = item.taxes;
            var tax_included = item.tax_included;
            addItem({
                name: item_name,
                description: item_description,
                item_id: item_id,
                quantity: 1,
                price: selling_price,
                orig_price: selling_price,
                discount_percent: 0,
                variations: variations,
                modifiers: modifiers,
                taxes: taxes,
                tax_included: tax_included
            });

            $("#item").val("");
            renderUi();
        }
    });
});

//Refactor for performance based on https://stackoverflow.com/questions/58999498/pouch-db-fast-search

$("#customer").autocomplete({
    source: async function(request, response) {
        var default_image = '<?php echo base_url(); ?>' + 'assets/img/user.png';

        var search = escapeRegExp($("#customer").val() ? $("#customer").val() : ' ').toLocaleLowerCase();

        var descending = false;

        const search_results = await db_customers.query('search', {
            include_docs: true,
            limit: 20,
            reduce: false,
            descending: descending,
            startkey: descending ? search + '\uFFF0' : search,
            endkey: descending ? search : search + '\uFFF0'
        });

        var results = search_results.rows;
        console.log("autocomplete", results);
        var db_response = [];

        var customersById = {};
        for (var k = 0; k < results.length; k++) {

            var row = results[k].doc;


            if (results[k].id == '40_customer') {
                console.log("Duplicates removed successfully.", row._rev);
            }



            var customer = {
                image: default_image,
                label: row.first_name + ' ' + row.last_name,
                value: row.person_id,
                phone_number: row.phone_number,
                email: row.email,
                balance: row.balance,
                internal_notes: row.internal_notes,
            };

            customersById[row.person_id] = customer;

        }
        db_response = Object.values(customersById);
        response(db_response);
    },
    delay: 500,
    autoFocus: false,
    minLength: 0,
    select: function(event, ui) {
        var person_id = ui.item.value;
        var customer_name = ui.item.label;
        var phone_number = ui.item.phone_number;
        var email = ui.item.email;
        var balance = ui.item.balance;
        var internal_notes = ui.item.internal_notes;
        cart['customer']['person_id'] = person_id;
        cart['customer']['customer_name'] = customer_name;
        cart['customer']['phone_number'] = phone_number;
        cart['customer']['email'] = email;
        cart['customer']['balance'] = balance;
        cart['customer']['internal_notes'] = internal_notes;
        renderUi();
        $(this).val('');
        return false;

    },

}).data("ui-autocomplete")._renderItem = function(ul, item) {
    return $("<li class='customer-badge suggestions'></li>")
        .data("item.autocomplete", item)
        .append('<a class="suggest-item"><div class="avatar">' +
            '<img src="' + item.image + '" alt="">' +
            '</div>' +
            '<div class="details">' +
            '<div class="name">' +
            item.label +
            '</div>' +
            '<span class="email">' + '</span>' +
            '</div></a>')
        .appendTo(ul);
};
async function getDocumentById(docId) {
    try {
        const doc = await db_items.get(docId + "_item"); // Fetch the document by its ID

        newitem = doc;
        var item_id = newitem.item_id;
        var item_name = newitem.name + ' - ' + to_currency_no_money(newitem.unit_price);
        var item_description = newitem.description;
        var quantity = 1;
        var variations = newitem.variations;
        var modifiers = newitem.modifiers;
        var taxes = newitem.taxes;
        var tax_included = newitem.tax_included;
        var unit_price = newitem.unit_price;
        var promo_price = newitem.promo_price;
        var start_date = newitem.start_date;
        var end_date = newitem.end_date;

        var selling_price = parseFloat(unit_price);

        var computed_promo_price = getPromoPrice(promo_price, start_date, end_date)

        if (computed_promo_price) {
            selling_price = computed_promo_price;
        }

        selling_price = to_currency_no_money(selling_price);


        addItem({
            name: item_name,
            description: item_description,
            item_id: item_id,
            quantity: 1,
            price: selling_price,
            orig_price: selling_price,
            discount_percent: 0,
            variations: variations,
            modifiers: modifiers,
            taxes: taxes,
            tax_included: tax_included
        });
        renderUi();
    } catch (error) {
        console.error('Error fetching document:', error);
        if (error.name === 'not_found') {
            console.error('Document not found');
        }
    }
}
async function getAllData(category = false) {
    $('#category_item_selection_wrapper_new').html('');
    try {
        const allDocs = await db_items.allDocs({
            include_docs: true, // Include document contents
            attachments: true // Include attachments if there are any
        });

        results = allDocs.rows;



        var db_response = [];

        for (var k = 0; k < results.length; k++) {

            var row = results[k].doc;
            if (category) {

                if (category != row.category_id) {
                    continue;
                }
            }
            if (typeof(row.name) == "undefined") {
                continue;
            }
            if (typeof(row.img_src) !== "undefined") {
                default_image = row.img_src;
            }

            var item = {
                tax_included: row.tax_included,
                taxes: row.taxes,
                variations: row.variations,
                modifiers: row.modifiers,
                description: row.description,
                unit_price: to_currency_no_money(row.unit_price),
                promo_price: row.promo_price,
                start_date: row.start_date,
                end_date: row.end_date,
                image: default_image,
                label: row.name + ' - ' + to_currency_no_money(row.unit_price),
                category: row.category,
                quantity: to_quantity(row.quantity),
                value: row.item_id
            };
            $('#category_item_selection_wrapper_new').append(list_item_template(item));




        }

        $('.item_parent_class').on('click', function() {

            var value = $(this).data('id');
            getDocumentById(value);

        });

    } catch (error) {
        console.error('Error fetching documents:', error);
    }
}

// Call the function to fetch all data
getAllData();




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
    const allDocs = await db_taxes.allDocs({
        include_docs: true,
        attachments: true
    });
    results = allDocs.rows;
    var taxesItems = results.filter(function(item) {
      return item.id.includes('_taxes');
  });


    // Populate the global map
    taxesItems.forEach(result => {
        TaxesMap[result.doc._id.replace('_taxes', '')] = result.doc;
    });

    TaxesMap = Object.entries(TaxesMap).map(([key, value]) => {
                return {
                    key: key,
                    value: value
                };
            });

    
    var select = $('#tax_class');
      select.empty();  // Ensure it's empty before loading new options
      select.append($('<option></option>').html('None'));
      // Assuming response is an array of tax classes
      TaxesMap.forEach(function(item) {
        select.append($('<option></option>').val(item.value.id).html(item.value.name));
      });


}


 
async function getSingleTax(id) {

TaxesMap = {};
const allDocs = await db_taxes.allDocs({
    include_docs: true,
    attachments: true
});
results = allDocs.rows;


var taxesItems = results.filter(function(item) {
  return item.id.includes('_taxes');
});

console.log("id", id);
// Populate the global map
taxesItems.forEach(result => {
    if(result.doc._id.replace('_taxes', '')==id){
        TaxesMap[result.doc._id.replace('_taxes', '')] = result.doc;
    }
    
});

TaxesMapddd = Object.entries(TaxesMap).map(([key, value]) => {
            return {
                key: key,
                value: value
            };
        });
        console.log("TaxesMapddd", TaxesMapddd);
        return TaxesMapddd[0].value.group;


}


getAllTaxes();
async function getAllCategories(categoryId = null, breadcrumbTrail = [], is_crumb = false) {


    try {
        let results = [];
        let contentHTML = '';


        if (is_crumb) {
            const categoryDoc = getObjectById(CrumbTrailSaved, categoryId).sub_categories;


            breadcrumbTrail = removeElementsAfterId(CrumbTrailSaved, categoryId);


            results = (categoryDoc.sub_categories_list) ? categoryDoc.sub_categories_list : categoryDoc
                .sub_categories;
            results = Object.entries(results).map(([key, value]) => {
                return {
                    key: key,
                    value: value
                };
            });
            // working here to be continue 
            categoryMap = {};
            res = (categoryDoc.sub_categories_list) ? categoryDoc.sub_categories_list : categoryDoc.sub_categories;;
            res.forEach(result => {
                categoryMap[(result.id) ? result.id : result._id] = result;
            });


        } else {
            if (categoryId) {

                // Access subcategories from the global map
                let categoryDoc = categoryMap[categoryId];

                results = (categoryDoc.sub_categories_list) ? categoryDoc.sub_categories_list : categoryDoc
                    .sub_categories;
                categoryMap = {};
                results.forEach(result => {
                    categoryMap[result.id] = result;
                });


            } else {

                // Fetch top-level categories
                const allDocs = await db_category.allDocs({
                    include_docs: true,
                    attachments: true
                });
                results = allDocs.rows;
                // Populate the global map
                results.forEach(result => {
                    categoryMap[result.doc._id.replace('_category', '')] = result.doc;
                });
            }
        }


        // Update breadcrumbs navigation
        updateBreadcrumbs(breadcrumbTrail);


        $('#category_item_selection').html('');
        if (categoryId) {


            for (var k = 0; k < results.length; k++) {

                if (is_crumb) {
                    var row = results[k].value;
                } else {
                    var row = results[k];
                }



                if (typeof(row.name) == "undefined") {
                    continue;
                }
                let image = row.img_src || '<?php echo base_url().'assets/img/item.png'; ?>';;
                id = (row.id) ? row.id : row._id;
                id = id.toString();
                id = id.replace('_category', '');

                var item = {

                    image: image,
                    name: row.name,
                    value: id,
                    id: id,
                    default_image: image,
                    sub_categories: (row.sub_categories_list) ? row.sub_categories_list.length : row
                        .sub_categories.length,
                    items_count: row.items_count,
                    sub_categories_list: (row.sub_categories_list) ? row.sub_categories_list : row
                        .sub_categories,
                };


                contentHTML += list_category_template(item);
            }
        } else {
            results.forEach(({
                doc: row
            }) => {

                if (!row.name) return;

                let image = row.img_src || '<?php echo base_url().'assets/img/item.png'; ?>';


                let item = {
                    image: image,
                    name: row.name,
                    id: row._id,
                    value: row._id.replace('_category', ''),
                    default_image: image,
                    sub_categories: row.sub_categories,
                    items_count: row.items_count,
                    sub_categories_list: row.sub_categories_list,
                };

                contentHTML += list_category_template(item);
            });
        }

        $('#category_item_selection').html(contentHTML);

        // Bind click event to each category item to load its subcategories
        $(".top_category").on('click', function(event) {
            event.preventDefault();
            let categoryId = $(this).data('category_id');
            let categoryName = $(this).find('.nav-text').text();
            let newTrail = breadcrumbTrail.concat({
                id: categoryId,
                name: categoryName,
                sub_categories: categoryMap[categoryId]
            });


            CrumbTrailSaved = newTrail;
            getAllCategories(categoryId, newTrail);
            getAllData(categoryId);
            $(this).addClass('selected-holder').siblings().removeClass('selected-holder');
        });

    } catch (error) {
        console.error('Error fetching documents:', error);
        $('#category_item_selection').html('<p>Error loading categories. Please try again later.</p>');
    }
}

function getAllCategories_crumb(categoryId = null) {
    console.log('CrumbTrailSaved', CrumbTrailSaved);
    getAllCategories(categoryId, breadcrumbTrail = [], true);
}
// Function to update breadcrumbs
function updateBreadcrumbs(breadcrumbTrail) {
    console.log('breadcrumbTrail', breadcrumbTrail);
    let breadcrumbsHTML =
        ' <span class="svg-icon svg-icon-2 svg-icon-white me-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 12C22 12.2 22 12.5 22 12.7L19.5 10.2L16.9 12.8C16.9 12.5 17 12.3 17 12C17 9.5 15.2 7.50001 12.8 7.10001L10.2 4.5L12.7 2C17.9 2.4 22 6.7 22 12ZM11.2 16.9C8.80001 16.5 7 14.5 7 12C7 11.7 7.00001 11.5 7.10001 11.2L4.5 13.8L2 11.3C2 11.5 2 11.8 2 12C2 17.3 6.09999 21.6 11.3 22L13.8 19.5L11.2 16.9Z" fill="currentColor"></path><path opacity="0.3" d="M22 12.7C21.6 17.9 17.3 22 12 22C11.8 22 11.5 22 11.3 22L13.8 19.5L11.2 16.9C11.5 16.9 11.7 17 12 17C14.5 17 16.5 15.2 16.9 12.8L19.5 10.2L22 12.7ZM10.2 4.5L12.7 2C12.5 2 12.2 2 12 2C6.7 2 2.4 6.1 2 11.3L4.5 13.8L7.10001 11.2C7.50001 8.8 9.5 7 12 7C12.3 7 12.5 7.00001 12.8 7.10001L10.2 4.5Z" fill="currentColor"></path></svg></span> <a href="javascript:void(0);" onclick="getAllCategories()" class="category_breadcrumb_item text-light" data-category_id="0">All 	<span class="svg-icon svg-icon-2 svg-icon-white mx-1"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path></svg></span> </a> ';
    breadcrumbTrail.forEach((crumb, index) => {

        breadcrumbsHTML +=
            `<a onclick="getAllCategories_crumb('${crumb.id}')" href="javascript:void(0);" class="category_breadcrumb_item text-light" data-category_id="15">${crumb.name} 	<span class="svg-icon svg-icon-2 svg-icon-white mx-1"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path></svg></span> </a>  `;
    });
    $('#grid_breadcrumbs').html(breadcrumbsHTML);


}

// Initial call to load top-level categories
getAllCategories();

//Refactor for performance based on https://stackoverflow.com/questions/58999498/pouch-db-fast-search





$("#item").autocomplete({
    source: async function(request, response) {
        var default_image = '<?php echo base_url(); ?>' + 'assets/img/item.png';



        var search = escapeRegExp($("#item").val() ? $("#item").val() : ' ').toLocaleLowerCase();

        var descending = false;

        const search_results = await db_items.query('search', {
            include_docs: true,
            limit: 20,
            reduce: false,
            descending: descending,
            startkey: descending ? search + '\uFFF0' : search,
            endkey: descending ? search : search + '\uFFF0'
        });

        var results = search_results.rows;
        var db_response = [];




        for (var k = 0; k < results.length; k++) {
            var row = results[k].doc;
            if (typeof(row.img_src) !== "undefined") {
                default_image = row.img_src;
            }

            var item = {
                tax_included: row.tax_included,
                taxes: row.taxes,
                variations: row.variations,
                modifiers: row.modifiers,
                description: row.description,
                unit_price: to_currency_no_money(row.unit_price),
                promo_price: row.promo_price,
                start_date: row.start_date,
                end_date: row.end_date,
                image: default_image,
                label: row.name + ' - ' + to_currency_no_money(row.unit_price),
                category: row.category,
                quantity: to_quantity(row.quantity),
                value: row.item_id
            };
            db_response.push(item);
        }
        response(db_response);


    },
    delay: 500,
    autoFocus: false,
    minLength: 0,
    select: function(event, ui) {

        var item_id = ui.item.value;
        var item_name = ui.item.label;
        var item_description = ui.item.description;
        var quantity = 1;
        var variations = ui.item.variations;
        var modifiers = ui.item.modifiers;
        var taxes = ui.item.taxes;
        var tax_included = ui.item.tax_included;
        var unit_price = ui.item.unit_price;
        var promo_price = ui.item.promo_price;
        var start_date = ui.item.start_date;
        var end_date = ui.item.end_date;

        var selling_price = parseFloat(unit_price);

        var computed_promo_price = getPromoPrice(promo_price, start_date, end_date)

        if (computed_promo_price) {
            selling_price = computed_promo_price;
        }

        selling_price = to_currency_no_money(selling_price);

        addItem({
            name: item_name,
            description: item_description,
            item_id: item_id,
            quantity: 1,
            price: selling_price,
            orig_price: selling_price,
            discount_percent: 0,
            variations: variations,
            modifiers: modifiers,
            taxes: taxes,
            tax_included: tax_included
        });
        renderUi();
        $(this).val('');
        return false;
    },
}).data("ui-autocomplete")._renderItem = function(ul, item) {
    return $("<li class='item-suggestions'></li>")
        .data("item.autocomplete", item)
        .append('<a class="suggest-item"><div class="item-image symbol symbol-50px">' +
            '<img src="' + item.image + '" alt="">' +
            '</div>' +
            '<div class="details">' +
            '<div class="name">' +
            item.label +
            '</div>' +
            '<span class="attributes">' + '<?php echo lang("category"); ?>' + ' : <span class="value">' + (item
                .category ? item.category : <?php echo json_encode(lang('none')); ?>) + '</span></span>' +
            <?php if ($this->Employee->has_module_action_permission('items', 'see_item_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>(
                typeof item.quantity !== 'undefined' && item.quantity !== null ? '<span class="attributes">' +
                '<?php echo lang("quantity"); ?>' + ' <span class="value">' + item.quantity + '</span></span>' : ''
            ) +
            <?php } ?>(item.attributes ? '<span class="attributes">' + '<?php echo lang("attributes"); ?>' +
                ' : <span class="value">' + item.attributes + '</span></span>' : '') +

            '</div>')
        .appendTo(ul);
};

function selectPayment(e) {
    e.preventDefault();
    $('#payment_types').val($(this).data('payment'));
    $('.select-payment').removeClass('active');
    $(this).addClass('active');
    $("#amount_tendered").focus();
    $("#amount_tendered").attr('placeholder', '');
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
                        id: 1,  // Assuming static for example; replace or dynamically fetch as needed
                        item_id: 1,  // Assuming static for example; replace or dynamically fetch as needed
                        name: $(this).find('input[name="kt_docs_repeater_basic[' + index + '][tax_names]"]').val(),
                        percent: $(this).find('input[name="kt_docs_repeater_basic[' + index + '][tax_percents]"]').val(),
                        cumulative: 0  // Assuming static for example; replace or dynamically fetch as needed
                    };
                    taxes.push(tax);
            } 
        
       
    });

    return taxes;
}

function removeAllExceptFirstRepeater() {
        let repeaterItems = $('#kt_drawer_general_body_lg .repeater-item');
        console.log("Total repeater items before removal:", repeaterItems.length);

        if (repeaterItems.length > 1) {
            repeaterItems.not(':first').each(function(index, item) {
                console.log("Removing repeater item:", item);
                $(item).remove();
            });
        }

        // Verify the result
        let remainingItems = $('#kt_drawer_general_body_lg .repeater-item');
        console.log("Total repeater items after removal:", remainingItems.length);
    }


function onclick_edit_taxes_item(item_id){

            console.log("item_id:", item_id);
            if(item_id >= 0){
                taxes  = cart.items[item_id].taxes;
            }else{
                taxes  = cart.taxes;
            }

            
           
            $('.current_cart_item').val(item_id);
            
            $('#kt_drawer_general_body_lg').html($('#kt_drawer_general_body_lg_container').html());

           


            var lastRepeaterItem = $('.repeater-item:last');
          
            removeAllExceptFirstRepeater();
          
            var clonetop = lastRepeaterItem.clone(true);
            if(taxes.length > 0) {
                taxes.forEach(function(tax , index) {
                    if (tax.hasOwnProperty('item_id')) {
                      clone = clonetop;
                       // this is override default tax
                       $('.tax_class_main').val('None');

                       
                         // Clone the last item

                        // Clear the values in the cloned item
                        clone.find('input[type="text"]').val('');
                        clone.find('input[type="hidden"]').val('0'); // Assuming you want to reset hidden fields to '0'

                        clone.appendTo('[data-repeater-list="kt_docs_repeater_basic"]'); // Append the clone to the container
                        updateRepeaterIndexes(); // Update indexes to ensure proper form submission
                        $('input[name="kt_docs_repeater_basic['+index+'][tax_names]"]').val(tax.name);
                        $('input[name="kt_docs_repeater_basic['+index+'][tax_percents]"]').val(tax.percent);
                        console.log(index);
                        $('.all_taxes').show();
                    }else{
                       // this is not override default tax
                       
                       $('.tax_class_main').val(tax.tax_class_id);
                       $('.all_taxes').hide();
                       clonetop.find('input[type="text"]').val('');
                       clonetop.find('input[type="hidden"]').val('0'); // Assuming you want to reset hidden fields to '0'

                       clonetop.appendTo('[data-repeater-list="kt_docs_repeater_basic"]');
                    }
                });
            }
            $(".submit_button").click(function(e) {
                item_id =   $('.current_cart_item').val();
                if ($('.tax_class_main').val() !== 'None') {
                        // update tax in cart 
                  
                        currently_selected_tax = $('.tax_class_main').val();
                        new_taxes = {};
                        // new_taxes  =  getSingleTax(currently_selected_tax);

                        getSingleTax(currently_selected_tax)
                    .then(new_taxes => {
                        // Process the response
                        if(item_id >= 0){

                           // new_taxes.then(data => {
                            cart.items[item_id].taxes =  {};
                            cart.items[item_id].taxes =  new_taxes;
                            
                           // });
                        }else{
                            
                            cart.taxes = new_taxes;
                        }
                        renderUi();
                    })
                    .catch(error => {
                        // Handle errors
                        console.error("Error fetching new taxes:", error);
                    });



                        
                        // console.log(new_taxes);

                }else{
                    currently_selected_tax = $('.current_cart_item').val();
                        taxobj = gatherTaxData();
                        if(item_id >= 0){
                            cart.items[currently_selected_tax].taxes =  taxobj;
                        }else{
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
                $('.all_taxes').show();  // Show the div if 'None' is selected
                } else {
                $('.all_taxes').hide();  // Hide the div otherwise
                }
            });

        }

function renderUi() {

    $("#saved_sales_list").empty();


    var saved_sales = JSON.parse(localStorage.getItem('sales')) || {};

    for (var k = saved_sales.length - 1; k >= 0; k--) {
        var saved_sale = saved_sales[k];
        var total = get_total(saved_sale);
        var items_sold = get_total_items_sold(saved_sale);



        let topItems = saved_sales[k].items
            .map(item => item.name) // Extract names
            .slice(0, 2) // Limit to first 5 items
            .join(', '); // Join names with commas
        // Compile the template with cart data



        var customer = <?php echo json_encode(lang('none')) ?>;

        if (saved_sale['customer'] && saved_sale['customer']['person_id']) {
            customer = saved_sale['customer']['customer_name'];
        }




        var sale = {
            index: k,
            total: total,
            customer: customer,
            items_sold: items_sold,
            topItems: topItems,
        };
        $("#saved_sales_list").append(saved_sale_template(sale));
    }


    localStorage.setItem("cart", JSON.stringify(cart));
    $("#register").find('tbody').remove();
    var total_qty = 0;
    for (var k = 0; k < cart['items'].length; k++) {

        var cart_item = cart['items'][k];
        if(  cart_item['quantity'] > 0){
            total_qty = total_qty + cart_item['quantity'];
        }
       
        cart['items'][k]['line_total'] = cart_item['price'] * cart_item['quantity'] - cart_item['price'] * cart_item[
            'quantity'] * cart_item['discount_percent'] / 100;
        cart['items'][k]['index'] = k;
        $("#register").prepend(cart_item_template(cart['items'][k]));
    }



    
    $('#total_items').html(cart['items'].length);
    $('#show_cart').html( 'Cart ['+cart['items'].length+']');
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
            // console.log(newValue);
            //persist data
            // var field = $(this).data('name');
            // var index = $(this).data('index');
            // if (typeof index !== 'undefined') {
            //     cart['items'][index][field] = newValue;
            // }

        }
    });



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
    var total_discount = get_discount(cart);
    var item_discount = get_item_discount(cart);
    var subtotal = get_subtotal(cart);
    var taxes = get_taxes(cart , true);
    // console.log('subtotal--' , subtotal);
    // console.log('taxes--' , taxes);
    subtotal = parseFloat(subtotal) - parseFloat(item_discount); 
    var itemPriceIncludingTax = parseFloat(subtotal)  + parseFloat(taxes) ;
    // console.log('itemPriceIncludingTax--' , itemPriceIncludingTax);
    var gen_tax = get_general_tax(itemPriceIncludingTax, cart);
    taxes = parseFloat(taxes) + parseFloat(gen_tax);
    // var total = get_total(cart);
   
    var flat_discount = get_flat_discount(cart);
    // console.log('subtotal' , subtotal);
  
    // console.log('taxes' , taxes);
    total = (parseFloat(subtotal) + parseFloat(taxes)).toFixed(2);
    var amount_due = get_amount_due(cart , total);
    $("#sub_total").html(subtotal.toFixed(2));
    $("#taxes").html(taxes.toFixed(2));
    $("#total").html(total);
    $('#total_discount').html(total_discount.toFixed(2));
    $('#total_discount_detail').html(total_discount.toFixed(2) + ' ' + currency_symbol);
    $('.discount_all_percent').val(cart['extra']['discount_all_percent']);
    $('#Flat_discount').html(cart['extra']['discount_all_flat'] + ' ' +
    currency_symbol);
    $('#Discount_from_items').html( item_discount+ ' ' +
    currency_symbol);

    $('.discount_all_flat').val(cart['extra']['discount_all_flat']);
    $("#amount_due").html(amount_due);
    $("#amount_tendered").val(amount_due);
    $("#show_total").html(amount_due);
    console.log(cart['customer']);

    if (cart['customer'] && cart['customer']['person_id']) {
        $("#customer_name").html(cart['customer']['customer_name']);
        $("#customer_balance").html('Balance  ' + currency_symbol +
            to_currency_no_money(cart['customer']['balance']));
        $("#selected_customer_form").removeClass('hidden');
        $("#select_customer_form").addClass('hidden');
        $("#customer_internal_notes").html(cart['customer']['internal_notes']);
        // $('#internal_notes').data('value' , cart['customer']['internal_notes']);
        $('.xeditable-comment').editable('setValue', cart['customer']['internal_notes'], true);
    } else {
        $("#customer").val('');
        $("#selected_customer_form").addClass('hidden');
        $("#select_customer_form").removeClass('hidden');
    }
    amount_tendered_input_changed();


    $(".edit_taxes_item").click(function(e) {
            item_id = $(this).data('id');

            onclick_edit_taxes_item(item_id);
        
          
        });



}

function addPayment(e) {
    e.preventDefault();
    var amount = $("#amount_tendered").val();
    var type = $("#payment_types").val();

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
        console.log('get_price_without_tax_for_tax_incuded_item');
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

            for (const modifier_id in cart_item.selected_item_modifiers) {
                if (cart_item.selected_item_modifiers[modifier_id]) {
                    for (var j = 0; j < cart_item.modifiers.length; j++) {
                        if (cart_item.modifiers[j]['modifier_item_id'] == modifier_id) {
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
            subtotal += price * cart_item['quantity'];
        }

        return to_currency_no_money(subtotal.toFixed(2));
    }
    return 0;
}

function get_item_discount(cart){
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
                        if (cart_item.modifiers[j]['modifier_item_id'] == modifier_id) {
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
            total_discount += discount_amount;
        }

        return to_currency_no_money(total_discount.toFixed(2));
    }
    return 0;
}
function get_flat_discount(cart){
    discount_all_flat=0;

    if (cart['extra'] && cart['extra']['discount_all_flat']) {
        discount_all_flat =  parseFloat(cart['extra']['discount_all_flat']);
        }
    return discount_all_flat.toFixed(2);;
}


function get_discount(cart) {
    itemDiscountedPrice = get_item_discount(cart);
    discount_all_flat  = get_flat_discount(cart);
    return parseFloat(itemDiscountedPrice) + parseFloat(discount_all_flat);
}


function get_general_tax(subtotal, cart) {

    console.log("get_general_tax" , subtotal);
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
        $html = '<div class="separator separator-dashed my-4"></div><div class="d-flex flex-column content-justify-center w-100"> ';
        $html += "<div class='d-flex fs-6 fw-semibold align-items-center'><div class='bullet w-8px h-6px rounded-2 bg-danger me-3'></div><div class='text-gray-500 flex-grow-1 me-4'> Total General Tax : </div> <div class='fw-bolder text-gray-700 text-xxl-end'> "+ totalGeneralTax.toFixed(2) +  currency_symbol + " </div> </div>  </div>";
        $('#kt_drawer_general_body_lg_tax_list').append($html);
        // console.log(`Cumulative total after all taxes: $${cumulativeTotal.toFixed(2)}`);
        return totalGeneralTax.toFixed(2);

    } else {
        return 0; // Return zero if no items or no taxes
    }
}

function get_taxes(cart , is_current_cart = false) {

    if(is_current_cart){
        $('#kt_drawer_general_body_lg_tax_list').html('');
        $('#kt_drawer_general_body_lg_tax_list').append('<h3>Tax Details</h3>');
        $html = '<div class="d-flex flex-column content-justify-center w-100"> ';
    }
  

    if (typeof cart.items != 'undefined') {
        var total_tax = 0;
        var $tax_include ='';
        for (var k = 0; k < cart.items.length; k++) {
            var cart_item = cart.items[k];
           
            if (cart_item.tax_included == '1') {
                $tax_include ='(Tax Include)';
                price = get_price_without_tax_for_tax_incuded_item(cart_item);
            } else {
                price = cart_item['price'];
                $tax_include ='';
            }

            for (const modifier_id in cart_item.selected_item_modifiers) {
                if (cart_item.selected_item_modifiers[modifier_id]) {
                    for (var j = 0; j < cart_item.modifiers.length; j++) {
                        if (cart_item.modifiers[j]['modifier_item_id'] == modifier_id) {
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

            $current_item_total_tax =0;
            for (var j =0; j < cart_item.taxes.length; j++) {
                var tax = cart_item.taxes[j]
                var quantity = cart_item.quantity;
                var discount = cart_item.discount_percent;

                if (tax['cumulative'] != '0') {
                    if(j-1 >=0 ){
                        var prev_tax = ((price * quantity - price * quantity * discount / 100)) * ((cart_item.taxes[j-1][
                        'percent'
                    ]) / 100);
                    }else{
                        var prev_tax = 0 ;
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
            if(is_current_cart){
                

                
                $html += "<div class='d-flex fs-6 fw-semibold align-items-center'><div class='bullet w-8px h-6px rounded-2 bg-info me-3'></div><div class='text-gray-500 flex-grow-1 me-4'>" + cart_item.name + "  "+  $tax_include +": </div> <div class='fw-bolder text-gray-700 text-xxl-end'>"+ $current_item_total_tax.toFixed(2) + currency_symbol +"</div> </div> ";
            }
            
            //console.log("items taxes" , total_tax);
        }
        
        if(is_current_cart){
           
            $html += "<div class='separator separator-dashed my-4'></div><div class='d-flex fs-6 fw-semibold align-items-center'><div class='bullet w-8px h-6px rounded-2 bg-danger me-3'></div><div class='text-gray-500 flex-grow-1 me-4'> Total item tax : </div> <div class='fw-bolder text-gray-700 text-xxl-end '>"+ total_tax.toFixed(2) + currency_symbol + " </div> </div>";
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

function get_amount_due(cart , total) {
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
    var taxes = get_taxes(sale , true);
     // console.log('subtotal--' , subtotal);
    // console.log('taxes--' , taxes);
    subtotal = parseFloat(subtotal) - parseFloat(item_discount); 
    var itemPriceIncludingTax = parseFloat(subtotal)  + parseFloat(taxes) ;
    // console.log('itemPriceIncludingTax--' , itemPriceIncludingTax);
    var gen_tax = get_general_tax(itemPriceIncludingTax, sale);
    taxes = parseFloat(taxes) + parseFloat(gen_tax);
    // var total = get_total(cart);
   
    var flat_discount = get_flat_discount(sale);
    // console.log('taxes' , taxes);
    total = (parseFloat(subtotal) + parseFloat(taxes)).toFixed(2);
    var amount_due = get_amount_due(sale , total);



    sale.total_tax = taxes;
    sale.gen_tax = gen_tax;
    sale.subtotal  = subtotal;
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

function addItem(newItem) {

    let found = false;
    if (parseInt(newItem.item_id) == 0) {
        for (let item of cart.items) {
            if (item.item_id === newItem.item_id) {
                console.log("Added dicounmt");
                // Update item logic
                //item.quantity += newItem.quantity;    // example: updating quantity
                item.line_total = newItem.price;
                item.price = newItem.price; // update price if needed
                item.orig_price = newItem.price;
                item.discount_percent = 0;
                found = true;
                break;
            }
        }
    }

    if (!found) {
        cart['items'].push(newItem);
    }
}

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
            0.8) { // The 0.8 here means "start scrolling when the mouse is at 80% of the container width"
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

    
    function display_holded_carts() {
        $("#holded_list").html('');
        heldCarts = JSON.parse(localStorage.getItem('hold_cart')) || [];

        heldCarts.forEach((cart, index) => {
            const readableDate = new Date(cart.timestamp).toLocaleString('en-US', {

                year: 'numeric', // "2020"
                month: 'long', // "July"
                day: 'numeric', // "20"
                hour: '2-digit', // "11 PM"
                minute: '2-digit' // "30"
            });
            let topItems = cart.data.items
                .map(item => item.name) // Extract names
                .slice(0, 2) // Limit to first 5 items
                .join(', '); // Join names with commas
            // Compile the template with cart data


            var subtotal = get_subtotal(cart.data);
            var totaltax = get_taxes(cart.data);

            var totalAmount = get_total(cart.data);
            var totaldue = get_amount_due(cart.data , totalAmount);



            var html = list_hold_cart_template({
                index: index,
                readableDate: readableDate,
                topItems: topItems + '....',
                subtotal: subtotal,
                totaltax: totaltax,
                totaldue: totaldue,
                totalAmount: totalAmount,
                details: JSON.stringify(cart.data)
            });

            // Append the compiled HTML to the list
            $("#holded_list").prepend(html);
        });

        $(".unsuspend_offline").click(function(e) {
            var suspend_index = $(this).data('suspend-index');
            e.preventDefault();
            bootbox.confirm(<?php echo json_encode(lang("are_you_sure_want_to_unsuspend")); ?>,
                function(result) {
                    if (result) {

                        restoreAndRemoveHeldCart(suspend_index);
                    }
                });
        });


        
        $(".edit_taxes_item").click(function(e) {
            item_id = $(this).data('id');
            onclick_edit_taxes_item(item_id);        
        });

        $("#edit_taxes_gen").click(function(e) {
            // $('#kt_drawer_general_body_lg').html($('#kt_drawer_general_body_lg_container').html());

            item_id = $(this).data('id');

            onclick_edit_taxes_item(item_id);

            renderUi();

            if ($('.tax_class_main').val() !== 'None') {
                $('.all_taxes').hide();
            }

            // Handle the change event of the dropdown
            $('.tax_class_main').change(function() {
                if ($(this).val() === 'None') {
                $('.all_taxes').show();  // Show the div if 'None' is selected
                } else {
                $('.all_taxes').hide();  // Hide the div otherwise
                }
            });


        });

    }


    function holdCurrentCart() {



        heldCarts = JSON.parse(localStorage.getItem('hold_cart')) || [];
        cartWithTimestamp = {
            timestamp: new Date().getTime(), // Unique identifier
            data: cart
        };

        // Add the current cart to the held carts array
        heldCarts.push(cartWithTimestamp);
        localStorage.setItem('hold_cart', JSON.stringify(heldCarts));

        //Reset cart
        cart = {};
        cart['items'] = [];
        cart['payments'] = [];
        cart['customer'] = {};
        cart['extra'] = {};
        cart['taxes'] = [];
        renderUi();
        console.log('Cart has been held', JSON.parse(localStorage.getItem('hold_cart')));
        display_holded_carts();
    }



    display_holded_carts();

    function restoreAndRemoveHeldCart(suspend_index) {
        // Parse the held carts from local storage
        let heldCarts = JSON.parse(localStorage.getItem('hold_cart')) || [];

        // Check if the index is valid
        if (suspend_index < 0 || suspend_index >= heldCarts.length) {
            console.error('Invalid index provided');
            return;
        }

        // Retrieve the cart object using the suspend_index
        cart = heldCarts[suspend_index].data;

        // Remove the cart from heldCarts array
        heldCarts.splice(suspend_index, 1);

        // Update the held carts in local storage
        localStorage.setItem('hold_cart', JSON.stringify(heldCarts));

        // Set the retrieved cart as the current cart in local storage or handle it as needed
        localStorage.setItem('cart', JSON.stringify(cart));

        // Optional: Refresh the display or handle the UI update
        display_holded_carts(); // Assuming this is the function to refresh your held carts display
        renderUi();
        console.log('Cart restored and removed from held carts.');
    }


    $(".additional_suspend_button").click(function(e) {
        e.preventDefault();
        is_empty = cart.items.length;
        console.log('is_empty', is_empty);
        if (is_empty > 0) {
            bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>, function(
                result) {
                if (result) {
                    holdCurrentCart();
                }
            });
        } else {
            bootbox.alert(<?php echo json_encode(lang("sorry_cart_have_no_items")); ?>);
        }


    });
    $(".unsuspend_offline").click(function(e) {
        var suspend_index = $(this).data('suspend-index');
        e.preventDefault();
        bootbox.confirm(<?php echo json_encode(lang("are_you_sure_want_to_unsuspend")); ?>, function(
            result) {
            if (result) {

                restoreAndRemoveHeldCart(suspend_index);
            }
        });
    });



});


function inc_de_qty(itemIndex, qty) {
    cart = JSON.parse(localStorage.getItem('cart'));

    console.log('cart', cart);

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




$(document).ready(function () {
    $('#show_products').on('click touchstart', function() {    
        $('#sales_section').hide();
        $('#left-section').show();
        $('.footer-btn').removeClass('btn-primary');
        $('.footer-btn').addClass('btn-secondary');
        $(this).removeClass('btn-secondary');
        $(this).addClass('btn-primary');
    });
    $('#show_cart').on('click touchstart', function() {    
        $('#sales_section').show();
        $('#left-section').hide();
        $('.footer-btn').removeClass('btn-primary');
        $('.footer-btn').addClass('btn-secondary');
        $(this).removeClass('btn-secondary');
        $(this).addClass('btn-primary');
    });
});

</script>