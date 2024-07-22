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
        var db_response = [];
        for (var k = 0; k < results.length; k++) {
            var row = results[k].doc;
            var customer = {
                image: default_image,
                label: row.first_name + ' ' + row.last_name,
                value: row.person_id,
                phone_number: row.phone_number,
                email: row.email,
                balance: row.balance,
                internal_notes: row.internal_notes,
            };
            db_response.push(customer);
        }
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
            if(category){
              
                 if(category!=row.category_id){
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


async function getAllCategories(categoryId = null, breadcrumbTrail = [] , is_crumb = false) {

    
    try {
        let results = [];
        let contentHTML = '';


        if(is_crumb){
            const categoryDoc = getObjectById(CrumbTrailSaved, categoryId).sub_categories;


            breadcrumbTrail = removeElementsAfterId(CrumbTrailSaved, categoryId); 
            
            
            results = (categoryDoc.sub_categories_list)?categoryDoc.sub_categories_list:categoryDoc.sub_categories;
             results = Object.entries(results).map(([key, value]) => {
                    return { key: key, value: value };
                });
          // working here to be continue 
          categoryMap = {};
            res =(categoryDoc.sub_categories_list)?categoryDoc.sub_categories_list:categoryDoc.sub_categories;;
                res.forEach(result => {
                    categoryMap[(result.id)?result.id:result._id] = result;
                });
               

        }else{
            if (categoryId) {
              
                // Access subcategories from the global map
                let categoryDoc = categoryMap[categoryId];

                results = (categoryDoc.sub_categories_list)?categoryDoc.sub_categories_list:categoryDoc.sub_categories;
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

                if(is_crumb){
                    var row = results[k].value;
                }else{
                    var row = results[k];
                }

                
           
            if (typeof(row.name) == "undefined") {
                continue;
            }
            let image = row.img_src || '<?php echo base_url().'assets/img/item.png'; ?>';;
            id =(row.id) ? row.id : row._id;
            id = id.toString();
            id = id.replace('_category', '');
           
            var item = {
               
                image: image,
                name: row.name ,
                value:  id,
                id: id,
                default_image: image,
                sub_categories: (row.sub_categories_list)?row.sub_categories_list.length:row.sub_categories.length,
                items_count: row.items_count,
                sub_categories_list: (row.sub_categories_list)?row.sub_categories_list:row.sub_categories,
            };
            
          
              contentHTML += list_category_template(item);
        }
    }else{
            results.forEach(({ doc: row }) => {
            
            if (!row.name) return;

            let image = row.img_src ||   '<?php echo base_url().'assets/img/item.png'; ?>';


            let item = {
                image: image,
                name: row.name,
                id: row._id,
                value:  row._id.replace('_category', ''),
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
            let newTrail = breadcrumbTrail.concat({ id: categoryId, name: categoryName , sub_categories: categoryMap[categoryId]});

          
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
    console.log('CrumbTrailSaved' , CrumbTrailSaved);
    getAllCategories(categoryId, breadcrumbTrail = []  , true );
}
// Function to update breadcrumbs
function updateBreadcrumbs(breadcrumbTrail) {
    console.log('breadcrumbTrail' , breadcrumbTrail);
    let breadcrumbsHTML = ' <span class="svg-icon svg-icon-2 svg-icon-white me-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 12C22 12.2 22 12.5 22 12.7L19.5 10.2L16.9 12.8C16.9 12.5 17 12.3 17 12C17 9.5 15.2 7.50001 12.8 7.10001L10.2 4.5L12.7 2C17.9 2.4 22 6.7 22 12ZM11.2 16.9C8.80001 16.5 7 14.5 7 12C7 11.7 7.00001 11.5 7.10001 11.2L4.5 13.8L2 11.3C2 11.5 2 11.8 2 12C2 17.3 6.09999 21.6 11.3 22L13.8 19.5L11.2 16.9Z" fill="currentColor"></path><path opacity="0.3" d="M22 12.7C21.6 17.9 17.3 22 12 22C11.8 22 11.5 22 11.3 22L13.8 19.5L11.2 16.9C11.5 16.9 11.7 17 12 17C14.5 17 16.5 15.2 16.9 12.8L19.5 10.2L22 12.7ZM10.2 4.5L12.7 2C12.5 2 12.2 2 12 2C6.7 2 2.4 6.1 2 11.3L4.5 13.8L7.10001 11.2C7.50001 8.8 9.5 7 12 7C12.3 7 12.5 7.00001 12.8 7.10001L10.2 4.5Z" fill="currentColor"></path></svg></span> <a href="javascript:void(0);" onclick="getAllCategories()" class="category_breadcrumb_item text-light" data-category_id="0">All 	<span class="svg-icon svg-icon-2 svg-icon-white mx-1"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path></svg></span> </a> ';
    breadcrumbTrail.forEach((crumb, index) => {
      
        breadcrumbsHTML += `<a onclick="getAllCategories_crumb('${crumb.id}')" href="javascript:void(0);" class="category_breadcrumb_item text-light" data-category_id="15">${crumb.name} 	<span class="svg-icon svg-icon-2 svg-icon-white mx-1"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor"></path></svg></span> </a>  `;
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
            topItems: topItems
        };
        $("#saved_sales_list").append(saved_sale_template(sale));
    }


    localStorage.setItem("cart", JSON.stringify(cart));
    $("#register").find('tbody').remove();
   var total_qty = 0;
    for (var k = 0; k < cart['items'].length; k++) {
        
        var cart_item = cart['items'][k];
        total_qty = total_qty + cart_item['quantity'];
        cart['items'][k]['line_total'] = cart_item['price'] * cart_item['quantity'] - cart_item['price'] * cart_item[
            'quantity'] * cart_item['discount_percent'] / 100;
        cart['items'][k]['index'] = k;
        $("#register").prepend(cart_item_template(cart['items'][k]));
    }
   
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

    var subtotal = get_subtotal(cart);
    var taxes = get_taxes(cart);

    var total = get_total(cart);
    var amount_due = get_amount_due(cart);
    $("#sub_total").html(subtotal);
    $("#taxes").html(taxes);
    $("#total").html(total);
    $("#amount_due").html(amount_due);
    $("#amount_tendered").val(amount_due);
    console.log(cart['customer']);

    if (cart['customer'] && cart['customer']['person_id']) {
        $("#customer_name").html(cart['customer']['customer_name']);
        $("#customer_balance").html('Balance <?php echo $this->config->item('currency_symbol'); ?>' + to_currency_no_money(cart['customer']['balance']));
        $("#selected_customer_form").removeClass('hidden');
        $("#select_customer_form").addClass('hidden');
        $("#customer_internal_notes").html(cart['customer']['internal_notes']);
    } else {
        $("#customer").val('');
        $("#selected_customer_form").addClass('hidden');
        $("#select_customer_form").removeClass('hidden');
    }
    amount_tendered_input_changed();
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

$('.select-payment').on('click mousedown', selectPayment);

$("#add_payment_form").submit(addPayment);
$("#add_payment_button").click(addPayment);

$(document).on("click", 'a.delete-item', function(event) {
    event.preventDefault();
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
            subtotal += price * cart_item['quantity'] - cart_item['price'] * cart_item['quantity'] * cart_item[
                'discount_percent'] / 100;
        }

        return to_currency_no_money(subtotal);
    }
    return 0;
}

function get_taxes(cart) {

    if (typeof cart.items != 'undefined') {
        var total_tax = 0;

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

            for (var j = 0; j < cart_item.taxes.length; j++) {
                var tax = cart_item.taxes[j]
                var quantity = cart_item.quantity;
                var discount = cart_item.discount_percent;

                if (tax['cumulative'] != '0') {
                    var prev_tax = ((price * quantity - price * quantity * discount / 100)) * ((cart_item.taxes[j - 1][
                        'percent'
                    ]) / 100);
                    var tax_amount = (((price * quantity - price * quantity * discount / 100)) + prev_tax) * ((tax[
                        'percent']) / 100);
                } else {
                    var tax_amount = ((price * quantity - price * quantity * discount / 100)) * ((tax['percent']) /
                        100);
                }

                total_tax += tax_amount;

            }
        }

        return to_currency_no_money(total_tax);
    } else {
        return 0;
    }
}

function get_total(cart) {
    return to_currency_no_money(parseFloat(get_subtotal(cart)) + parseFloat(get_taxes(cart)));
}

function get_payments_total(cart) {
    var total = 0;
    for (var k = 0; k < cart['payments'].length; k++) {
        total += parseFloat(cart['payments'][k]['amount']);
    }

    return to_currency_no_money(total);
}

function get_amount_due(cart) {
    return to_currency_no_money(parseFloat(get_total(cart)) - parseFloat(get_payments_total(cart)));
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
    sale.total_tax = get_taxes(sale);
    sale.total = get_total(sale);

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

function addItem(item) {
    cart['items'].push(item);
}

$(document).ready(function() {
  var $scrollContainer = $('.horizontal-scroll');
  var scrollSpeed = 10; // Adjust this value for different scroll speeds

  $scrollContainer.on('mousemove', function(e) {
    var $this = $(this);
    var mouseX = e.pageX - $this.offset().left; // Get the mouse X position relative to the scroll container
    var scrollWidth = $this.get(0).scrollWidth; // Width of the scroll container
    var outerWidth = $this.outerWidth(); // Visible width of the scroll container
    var scrollLeft = $this.scrollLeft(); // Current scroll position

    // If the mouse is on the right side of the container, scroll right
    if (mouseX > outerWidth * 0.8) { // The 0.8 here means "start scrolling when the mouse is at 80% of the container width"
      $this.scrollLeft(scrollLeft + scrollSpeed);
    } 
    // If the mouse is on the left side of the container, scroll left
    else if (mouseX < outerWidth * 0.2) { // The 0.2 means "start scrolling when the mouse is at 20% of the container width"
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

    function display_holded_carts(){
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
                var totaldue = get_amount_due(cart.data);



                var html = list_hold_cart_template({
                    index: index,
                    readableDate: readableDate,
                    topItems: topItems + '....',
                    subtotal:subtotal,
                    totaltax:totaltax,
                    totaldue:totaldue,
                    totalAmount: totalAmount,
                    details: JSON.stringify(cart.data)
                });

                // Append the compiled HTML to the list
                $("#holded_list").prepend(html);
            });

            $(".unsuspend_offline").click(function(e) {
                    var suspend_index = $(this).data('suspend-index');
                    e.preventDefault();
                    bootbox.confirm(<?php echo json_encode(lang("are_you_sure_want_to_unsuspend")); ?>, function(result) {
                        if (result) {
                            
                            restoreAndRemoveHeldCart(suspend_index);
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
        renderUi();
        console.log('Cart has been held' , JSON.parse(localStorage.getItem('hold_cart')));
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
			var suspend_index = $(this).data('suspend-index');
			e.preventDefault();
			bootbox.confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>, function(result) {
				if (result) {
					holdCurrentCart();
				}
			});
		});
        $(".unsuspend_offline").click(function(e) {
			var suspend_index = $(this).data('suspend-index');
			e.preventDefault();
			bootbox.confirm(<?php echo json_encode(lang("are_you_sure_want_to_unsuspend")); ?>, function(result) {
				if (result) {
					
                    restoreAndRemoveHeldCart(suspend_index);
				}
			});
		});

    

});


function inc_de_qty(itemIndex, qty) {
     cart = JSON.parse(localStorage.getItem('cart'));

     console.log('cart' , cart);
	
    if (parseInt(itemIndex) !== -1) {

        // Update quantity if item exists
        cart.items[parseInt(itemIndex)].quantity = (cart.items[parseInt(itemIndex)].quantity + parseInt(qty) > 0) ? cart.items[parseInt(itemIndex)]
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
    window.addEventListener('online',  updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);

    // Initial check to set the correct status as soon as the script loads
    updateOnlineStatus();
 
</script>