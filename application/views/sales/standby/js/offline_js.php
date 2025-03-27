<script>
function getSalePrice(params) {

let itemInfo = params.all_data;
console.log(params);
let quantityUnitId = params.quantity_unit_id || null;
let quantityUnitQuantity = itemInfo.quantity_unit_quantity ? itemInfo.quantity_unit_quantity : 1;
let itemId = params.item_id;
let tierId = params.tier_id || false;
let variationId = params.variation_id || false;
let supplier_id = params.supplier_id || false;
let itemLocationInfo = itemInfo.item_location_info;
let secondary_supplier_details = itemInfo.secondary_supplier_details;
console.log('itemLocationInfo' , itemLocationInfo);


if(supplier_id && supplier_id!='' ){
    secondary_supplier_details = itemInfo.secondary_supplier_details[supplier_id]?itemInfo.secondary_supplier_details[supplier_id]:null;
     if(secondary_supplier_details){    
        params.orig_price = secondary_supplier_details.unit_price;
        params.cost_price=secondary_supplier_details.cost_price;
        params.price=secondary_supplier_details.unit_price;
     }else{
        params.orig_price = itemInfo.regular_price;
        params.cost_price=itemInfo.cost_price;
        params.price=itemInfo.regular_price;
     }
}else{
        params.orig_price = itemInfo.regular_price;
        params.cost_price=itemInfo.cost_price;
        params.price=itemInfo.regular_price;
}

console.log(itemInfo.item_tier_row);
let itemTierRow = ( typeof itemInfo.item_tier_row[tierId] !='undefined')?itemInfo.item_tier_row[tierId]: null;
console.log('itemTierRow' , itemTierRow);
let itemLocationTierRow = itemInfo.item_location_tier_row[tierId]?itemInfo.item_location_tier_row[tierId]: null; 
console.log('itemLocationTierRow' , itemLocationTierRow); 
let resultString = '';

if(typeof params.selectedAttributes !='undefined'){
    selectedAttributes = params.selectedAttributes;

    console.log('selectedAttributes' , selectedAttributes);
    $.each(selectedAttributes, function(attributeKey, selectedValueKey) {
        resultString += selectedValueKey;

    });
}

console.log('resultString' , resultString); 
let  matchingVariation = [];
if(itemInfo.has_variations != false){
    console.log('called means have variaons' , itemInfo.has_variations ); 

    if(supplier_id && supplier_id!='' ){
        matchingVariation =  itemInfo.has_variations.find(variation => variation.attribute_string ==
            resultString && variation.supplier_id ==supplier_id );
    }else{
        matchingVariation =  itemInfo.has_variations.find(variation => variation.attribute_string ==
            resultString  );
    }
  
}

console.log('variationInfo' , matchingVariation); 
let variationInfo = matchingVariation;
let variationLocationInfo = variationInfo.item_variation_location_info;

console.log('variationInfo' , variationInfo); 
console.log('variationLocationInfo' , variationLocationInfo); 

let tierInfo = itemInfo.all_tier_info[tierId];

    


if (quantityUnitId) {
    console.log("step 2");
    let qui =  itemInfo.quantity_units_info[quantityUnitId];
    if(qui && qui.unit_price !== null){
        params.orig_price = qui.unit_price;
        params.cost_price=qui.cost_price;
        params.price=qui.unit_price;
    }else{
        params.orig_price = itemInfo.regular_price;
        params.cost_price=itemInfo.cost_price;
        params.price=itemInfo.regular_price;
    }

    return to_currency_no_money(params.price );
}

if (itemLocationTierRow?.unit_price) return to_currency_no_money(itemLocationTierRow.unit_price * quantityUnitQuantity);

if (itemLocationTierRow?.percent_off) {
    console.log("step 3" , variationLocationInfo);
    let itemUnitPrice = variationLocationInfo?.unit_price || variationInfo?.price_without_currency || itemLocationInfo?.unit_price || params.orig_price;
    console.log("itemUnitPrice" , itemUnitPrice);
    return to_currency_no_money((itemUnitPrice * (1 - itemLocationTierRow.percent_off / 100)) * quantityUnitQuantity);
}
if (itemLocationTierRow?.cost_plus_percent) {
    console.log("step 4");
    let itemCostPrice = variationInfo?.cost_price || itemLocationInfo?.cost_price || itemInfo.cost_price;
    return to_currency_no_money((itemCostPrice * (1 + itemLocationTierRow.cost_plus_percent / 100)) * quantityUnitQuantity);
}
if (itemLocationTierRow?.cost_plus_fixed_amount) {
    console.log("step 4.1" , itemLocationTierRow.cost_plus_fixed_amount);
    let itemCostPrice = variationInfo?.cost_price || itemLocationInfo?.cost_price || itemInfo.cost_price;
    return to_currency_no_money(  parseFloat(itemCostPrice) + parseFloat(itemLocationTierRow.cost_plus_fixed_amount));
}
if (itemTierRow?.unit_price){
    console.log("step 5");
    return to_currency_no_money(itemTierRow.unit_price);
} 
if (itemTierRow?.percent_off) {
    console.log("step 6");
    let basePrice = variationLocationInfo?.unit_price || variationInfo?.price_without_currency || itemLocationInfo.unit_price || params.orig_price;
    return to_currency_no_money(basePrice * (1 - itemTierRow.percent_off / 100));
}
if (itemTierRow?.cost_plus_percent) {
    console.log("step 7");
    let costPrice = variationInfo?.cost_price || itemLocationInfo.cost_price || itemInfo.cost_price;
    return to_currency_no_money(costPrice * (1 + itemTierRow.cost_plus_percent / 100));
}
if (itemTierRow?.cost_plus_fixed_amount) {
    console.log("step 8");
    let costPrice = variationInfo?.cost_price || itemLocationInfo.cost_price || itemInfo.cost_price;
    return to_currency_no_money(parseFloat(costPrice) + parseFloat(itemTierRow.cost_plus_fixed_amount));
}
if (tierInfo?.default_percent_off) {
    console.log("step 9");
    let basePrice = variationLocationInfo?.unit_price || variationInfo?.price_without_currency || itemLocationInfo.unit_price || params.orig_price;
    return to_currency_no_money(basePrice * (1 - tierInfo.default_percent_off / 100));
}
if (tierInfo?.default_cost_plus_percent) {
    console.log("step 10");
    let costPrice = variationLocationInfo?.cost_price || variationInfo?.cost_price || itemLocationInfo.cost_price || params.orig_price;
    return to_currency_no_money(costPrice * (1 + tierInfo.default_cost_plus_percent / 100));
}
if (tierInfo?.default_cost_plus_fixed_amount) {
    console.log("step 11");
    let costPrice = variationLocationInfo?.cost_price || variationInfo?.cost_price || itemLocationInfo.cost_price || params.orig_price;
    console.log("step 11 costPrice" , costPrice);
    return to_currency_no_money(parseFloat(costPrice) + parseFloat(tierInfo.default_cost_plus_fixed_amount));
}

// Condition for variation price and promotion
if ((variationId && variationInfo.price_without_currency) || 
    (variationId && variationLocationInfo && variationLocationInfo.unit_price) || 
    (variationId && variationInfo.promo_price) || 
    (variationId && variationLocationInfo && 'promo_price' in variationLocationInfo)) {
        console.log("step 12");
    
    let today = new Date().setHours(0, 0, 0, 0);
    let isVariationDatePromo = variationInfo.start_date !== null && variationInfo.end_date !== null &&
        new Date(variationInfo.start_date) <= today && new Date(variationInfo.end_date) >= today;

    if (variationInfo.promo_price && variationInfo.start_date === null && variationInfo.end_date === null) {
        console.log("step 12 1");
        return to_currency_no_money(variationInfo.promo_price * quantityUnitQuantity);

    } else if (isVariationDatePromo && variationInfo.promo_price) {
        console.log("step 12 2");
        return to_currency_no_money(variationInfo.promo_price * quantityUnitQuantity);
    }
    console.log("step 12 3");
    return to_currency_no_money(((variationLocationInfo && variationLocationInfo.unit_price) ? variationLocationInfo.unit_price : variationInfo.price_without_currency) * quantityUnitQuantity);
}


console.log("step 13");
let today = new Date();
let isItemLocationPromo = itemLocationInfo.start_date && itemLocationInfo.end_date && new Date(itemLocationInfo.start_date) <= today && new Date(itemLocationInfo.end_date) >= today;
let isItemPromo = itemInfo.start_date && itemInfo.end_date && new Date(itemInfo.start_date) <= today && new Date(itemInfo.end_date) >= today;

if (itemLocationInfo.promo_price && !itemLocationInfo.start_date) return to_currency_no_money(itemLocationInfo.promo_price * quantityUnitQuantity);
if (itemInfo.promo_price && !itemInfo.start_date) return to_currency_no_money(itemInfo.promo_price * quantityUnitQuantity);
if (isItemLocationPromo && itemLocationInfo.promo_price) return to_currency_no_money(itemLocationInfo.promo_price * quantityUnitQuantity);
if (isItemPromo && itemInfo.promo_price) return to_currency_no_money(itemInfo.promo_price * quantityUnitQuantity);

let itemUnitPrice = itemLocationInfo?.unit_price || params.orig_price;
console.log("itemUnitPrice" , itemUnitPrice);
return to_currency_no_money(itemUnitPrice * quantityUnitQuantity);


}



 categories_stack = [{
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
$('#grid-loader2').hide();
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

$('#grid-loader2').hide();
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
$('#grid-loader2').hide();
}






$(document).ready(function () {
for (let i = 0; i < 20; i++) { // Adjust the number of placeholders
$("#category_item_selection_wrapper_new").append(`
    <div class="col-sm-4 col-md-3 col-lg-2 mb-2 col-xxl-2 category_item item register-holder dummy-card">
        <div class="card card-flush bg-light h-xl-100 w-100 ">
            <div class="card-body text-center pb-5">
                <div class="dummy-image"></div>
                <div class="dummy-text"></div>
                <div class="dummy-text short"></div>
            </div>
        </div>
    </div>
`);
}
});


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

$('#grid-loader2').hide();
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

$('#grid-loader2').hide();
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

$('#grid-loader2').hide();
}



function close_all_drawers(){
$('.drawer').removeClass('drawer-on');
$('#kt_drawer_gen_sm').removeClass('drawer-on');
$('#kt_drawer_example_basic').removeClass('drawer-on');
    $('#kt_drawer_gen_md').removeClass('drawer-on');
    $('#kt_drawer_gen_lg').removeClass('drawer-on');
    $('#kt_drawer_gen_xl').removeClass('drawer-on');
    $('#operationsbox_modal').removeClass('drawer-on');
    $('#discountbox_modal').removeClass('drawer-on');
    $('#kt_drawer_example_basic_save_as').removeClass('drawer-on');
    $('#discountbox_modal_reload').removeClass('drawer-on');
    
    $('.drawer-overlay').remove();
    $('body').attr("data-kt-drawer", "off");
    $('body').attr("data-kt-drawer-null" ,"off");
}
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

function check_and_get_suspended_sale(sale_id , is_return ) {
console.log("Checking and getting" , sale_id  , is_return);

$.post('<?php echo site_url("sales/check_and_get_suspended_sale/"); ?>', {
        offline_sales: '',
        sale_id: sale_id,
        is_returned: is_return,
    },
    function(response) {
        
      
        if( typeof response.error == "string" ) {
            show_feedback('error', response.error,
                "<?php echo  lang('error') ?>");
            return false;
        }

        close_all_drawers();

        $('#delete_sale_button').addClass('d-flex');
        $('#delete_sale_button').removeAttr('style' );
        $('#cancel_sale_button').removeAttr('style' );
        $('#clear_sale_button').attr('style' , 'display: none !important' );


        
        console.log(response);
        // console.log('is_return' , is_return);
        cart = response;
        console.log(cart);

        md = (is_return=='1')?'return' : 'sale';
        var dropdownItem = $('.dropdown-menu a[data-mode="'+md+'"]');

       if(is_return){
        cart.extra.return_sale_id = sale_id;
       }else{
        cart.extra.return_sale_id = null;
       }


      


        // Simulate a click or trigger any event you want
        dropdownItem.trigger('click');


        if(typeof cart.extra.coupons !="undefined"){
            var tokens = cart.extra.coupons;
            // console.log( "cart extra copoin" , cart.extra.coupons);
            // console.log("token testing" , tokens);

            tokens.forEach(function(token) {

                $('.coupon_codes').tokenfield('createToken', token[0]);
            });
        }
        
        $('#delete_sale_button').removeAttr('style');

        renderUi();
        // console.log(response);
    }, 'json');


}



function set_tier_id(tire, only_current = false) {

previous_tier_id = (cart['extra']['tier_id']) ? cart['extra']['tier_id'] : 0;

var sale = localStorage.getItem('cart');
    $i=0;
cart.items.forEach(item => {
        $price =     getSalePrice(item);
        cart['items'][$i]['price'] = $price;
        console.log($price);
        $i++;

    });
    renderUi();

//     var allSales = [];
//     allSales.push(JSON.parse(sale));

//     $.post('<?php


//  echo site_url("sales/set_tier_id_speedy"); ?>', {
//             offline_sales: JSON.stringify(allSales),
//             tier_id: tire,
//             only_current: only_current ? 'true' : 'false',
//             previous_tier_id: previous_tier_id,
//         },
//         function(response) {
  
//             cart = JSON.parse(JSON.stringify(response));
//             renderUi();
//         }, 'json');
}


function get_price_rule_for_item($item_id = false) {

$('#ajax-loader').show();
// cart = JSON.parse(localStorage.getItem("cart"));
// console.log(" get_price_rule_for_item" , cart);
$.post('<?php 
                echo site_url("sales/set_price_rule_speedy"); ?>', {
        items: JSON.stringify(cart.items),
        all_items: 'true',
        coupons: cart.extra,
    },
    function(response) {
        $('#ajax-loader').hide();
        cart.items = JSON.parse(JSON.stringify(response));
        // console.log(response);
        renderUi();
    }, 'json');




}



function out_of_stock(index = 0 , $quanity_added) {

$item = cart.items[index];
 
$suspended_change_sale_id = ($item.all_data.is_suspended) ? $item.extra.sale_id : 0;
$quantity_in_sale = 0;
if ($suspended_change_sale_id) {
    $suspended_type = $item.extra.suspended_type;

    //Not an estiamte
    if ($suspended_type != 2) {
        $quantity_in_sale = item.all_data.quantity_in_sale;
    }
}

if ($item.selected_variation) {
    // console.log('$item.selected_variation' , $item.selected_variation);


    let resultString = '';
    selectedAttributes = $item.selectedAttributes;
    $.each(selectedAttributes, function(attributeKey, selectedValueKey) {
        resultString += selectedValueKey;

    });
    // resultString = $item.selected_variation;
    let matchingVariation = $item.all_data.has_variations.find(variation => variation.attribute_string ===
        resultString);
    // console.log('$matchingVariation' , matchingVariation);
    $item_location_quantity = matchingVariation.item_location_quantity;


} else {
    $item_location_quantity = $item.all_data.item_location_quantity;
}

// $quanity_added = $item.quantity;

if ($item.all_data.is_service == '0' && $item_location_quantity !== null && $item_location_quantity -
    $quanity_added + $quantity_in_sale < 0) {
    return true;
} else {
    return false;
}


//  console.log('$item_location_quantity' , $item_location_quantity);


}
function below_cost_price($item , $price)
{
    // console.log('$item' , $item);
        // $price = $item.price;				
        $discount = $item.discount_percent;	
        $cost_price = $item.cost_price;
        $total_for_one = $price-(($price*$discount)/100);
        return $total_for_one < $cost_price;		
}

function check_allow_added(cart, itemIndex, $type, val) {
$can_edit = true;

if ($type == 'quantity' ||  $type == 'quantity_bulk') {
    if ($type == 'quantity'){
        qty = $item = parseInt(cart.items[itemIndex].quantity) +  parseInt(val);
    }else{

      

        qty = val;

        if (!cart.items[parseInt(itemIndex)].all_data.permissions.process_returns && (parseInt(qty)) < 0) {

         
            $can_edit = false;
            show_feedback('error', cart.items[parseInt(itemIndex)].all_data.permissions.process_returns_error,
                "<?php echo  lang('error') ?>");
            return false;
        }

    }
    
   
 
    if (cart.items[parseInt(itemIndex)].all_data.permissions.do_not_allow_out_of_stock_items_to_be_sold =='1') {


        $cart_mode = (cart['extra']['mode'])? cart['extra']['mode'] : 'sale'; /// this need to be set
        if ($cart_mode != 'estimate' && out_of_stock(itemIndex ,qty )) {
            $can_edit = false;
          
        }


        if (qty != parseInt(qty)) {
            // $data['error']=lang('must_be_whole_number');
            show_feedback('error', "<?= lang('must_be_whole_number');  ?>", "<?php echo  lang('error') ?>");
            $can_edit = false;
         
        }



        if (!$can_edit) {
            show_feedback('error', "<?= lang('sales_unable_to_add_item_out_of_stock');  ?>",
                "<?php echo  lang('error') ?>");
        }
    }
}


if ($type == 'price') {
    $unit_price = val;
    $max = cart.items[parseInt(itemIndex)].all_data.max_edit_price;
    $min = cart.items[parseInt(itemIndex)].all_data.min_edit_price;

    $can_override_price_adjustments = cart.items[parseInt(itemIndex)].all_data.can_override_price_adjustments;
    if ($can_override_price_adjustments == '0' && typeof $min !== 'undefined' && parseFloat($unit_price) <
        parseFloat($min)) {


        show_feedback('error', "<?= lang('sales_could_not_set_item_price_bellow_min');  ?>" + " " +
            currency_symbol + $min , "<?php echo  lang('error') ?>");
            $can_edit = false;
    }

    if ($can_override_price_adjustments == '0' && typeof $max !== 'undefined' && parseFloat($unit_price) >
        parseFloat($max)) {
        show_feedback('error', "<?= lang('sales_could_not_set_item_price_above_max');  ?>" + " " + currency_symbol +
            $max, "<?php echo  lang('error') ?>");
            $can_edit = false;
    }

    if (below_cost_price(cart.items[parseInt(itemIndex)] , val))
    {

        
        if (cart.items[parseInt(itemIndex)].all_data.permissions.do_not_allow_below_cost!="0")
        {
            
            show_feedback('error', "<?= lang('sales_selling_item_below_cost');  ?>", "<?php echo  lang('error') ?>");
            $can_edit = false;

        }
        else
        {
            show_feedback('warning', "<?= lang('sales_selling_item_below_cost');  ?>", "<?php echo  lang('warning') ?>");
        }
    }


}

if ($type == 'price-line-total') {
    

    $old_price = cart.items[parseInt(itemIndex)].price;
    cart.items[parseInt(itemIndex)].price = -1*((100*val)/(cart.items[parseInt(itemIndex)].quantity * (cart.items[parseInt(itemIndex)].discount_percent-100)));

    
   
    $max = cart.items[parseInt(itemIndex)].all_data.max_edit_price;
    $min = cart.items[parseInt(itemIndex)].all_data.min_edit_price;
    $can_override_price_adjustments = parseInt(cart.items[parseInt(itemIndex)].all_data.can_override_price_adjustments);
   

    if (  parseFloat(cart.items[parseInt(itemIndex)].price)  < 0 &&   !cart.items[parseInt(itemIndex)].all_data.permissions.process_returns)
        {
             show_feedback('error', "<?= lang('sales_not_allowed_returns');  ?>", "<?php echo  lang('error') ?>");
            $can_edit = false;

        }
     
        if(!$can_override_price_adjustments  && parseFloat(cart.items[parseInt(itemIndex)].price) < parseFloat($min))
    {
      
        cart.items[parseInt(itemIndex)].price = $min;
        
        show_feedback('warning', "<?= lang('sales_could_not_set_item_price_bellow_min')." ";  ?>"+to_currency_no_money($min), "<?php echo  lang('warning') ?>");
        
    }

    if(!$can_override_price_adjustments && parseFloat(cart.items[parseInt(itemIndex)].price) > parseFloat($max))
    {
        
        cart.items[parseInt(itemIndex)].price = $max;
        
        show_feedback('warning', "<?= lang('sales_could_not_set_item_price_above_max')." ";  ?>"+to_currency_no_money($max), "<?php echo  lang('warning') ?>");

    }


    if (below_cost_price(cart.items[parseInt(itemIndex)] , val))
    {

        
        if (cart.items[parseInt(itemIndex)].all_data.permissions.do_not_allow_below_cost!="0")
        {
            
            show_feedback('error', "<?= lang('sales_selling_item_below_cost');  ?>", "<?php echo  lang('error') ?>");
            $can_edit = false;

        }
        else
        {
            show_feedback('warning', "<?= lang('sales_selling_item_below_cost');  ?>", "<?php echo  lang('warning') ?>");
        }
    }

    if (!$can_edit)
    {
       
        cart.items[parseInt(itemIndex)].price = $old_price;
        
    }



}



return $can_edit;
}

function set_quantity_unit_id(quantity_unit_id, index) {



cart = JSON.parse(localStorage.getItem('cart'));
$price  =  getSalePrice(cart.items[index]);

 cart.items[index]['price'] = $price;

 if(cart.items[index].all_data.quantity_units_info  && cart.items[index].all_data.quantity_units_info[quantity_unit_id] &&   cart.items[index].all_data.quantity_units_info[quantity_unit_id].unit_price!=null){
    cart.items[index]['quantity_unit_quantity'] = cart.items[index].all_data.quantity_units_info[quantity_unit_id].unit_quantity;
 }else{
    cart.items[index]['quantity_unit_quantity']=1;
 }
 localStorage.setItem("cart", JSON.stringify(cart));
 renderUi();
}

function set_supplier_id(supplier_id, index) {

cart = JSON.parse(localStorage.getItem('cart'));
 $price  =  getSalePrice(cart.items[index]);

 cart.items[index]['price'] = $price;
 localStorage.setItem("cart", JSON.stringify(cart));
 renderUi();
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
return !a;  // !undefined evaluates to true
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
//data structures for cart
var currency_symbol = '<?php echo $this->config->item('currency_symbol'); ?>';
var cart_item_template = Handlebars.compile(document.getElementById("cart-item-template").innerHTML);
var cart_payment_template = Handlebars.compile(document.getElementById("cart-payment-template").innerHTML);
var saved_sale_template = Handlebars.compile(document.getElementById("saved-sale-template").innerHTML);
var sale_receipt_template = Handlebars.compile(document.getElementById("sale-receipt-template").innerHTML);
var list_item_template = Handlebars.compile(document.getElementById("list-item-template").innerHTML);
var list_category_template = Handlebars.compile(document.getElementById("list-category-template").innerHTML);
var list_hold_cart_template = Handlebars.compile(document.getElementById("list-hold-cart-template").innerHTML);
var selected_customer_template = Handlebars.compile(document.getElementById("selected-customer-form-template").innerHTML);
var items_list = [];
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

$(document).on("click", '#clear_sale_button', function(event) {
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
            
            $('#delete_sale_button').removeClass('d-flex');
            $('#delete_sale_button').attr('style' , 'display: none !important');

            var dropdownItem = $('.dropdown-menu a[data-mode="sale"]');
            
            // Simulate a click or trigger any event you want
            dropdownItem.trigger('click');
             $.post('<?php echo site_url("sales/cancel_sale"); ?>', 'json');

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

function get_single_category_data(categoryId){
    $('#category_item_selection_wrapper_new').html('');

    

        if(categoryId=='top_items'){
            results =  Object.values(items_list).filter(item => parseInt(item.all_data.is_top_item) ==1);
        }else{
            results =  Object.values(items_list).filter(item => parseInt(item.all_data.category_id) === categoryId);
        }

      

    
        var db_response = [];

        for (var k = 0; k < results.length; k++) {

            var row = results[k];

           

            var image_src = row.all_data.image_src;
        var has_variations = (row.variations)?row.variations:row.has_variations;

        var prod_image = "";
        var image_class = "no-image";
        var item_parent_class = "";
        if (image_src != '') {
            var item_parent_class = "item_parent_class";
            var prod_image = '<img class="rounded-3 mb-4 h-auto" src="' + image_src + '" alt="" />';
            var image_class = "has-image";
        } 
 
        currency_ = "<?php echo get_store_currency(); ?>"
        price = (row.price ? ' ' + decodeHtml(row
            .price) + ' ' : '');
        price_val = (row.price ? decodeHtml(row
            .price) : '');
        price_val = price_val.replace(currency_, '');
        price_val = parseFloat(price_val.replace(/,/g, ''));
        price_val_reg = (row.regular_price ? decodeHtml(row
            .regular_price) : '');
             price_val_reg = parseFloat(price_val_reg.replace(/,/g, ''));




        //check_and_get_suspended_sale $item_attributes_available = $this->Item_attribute->get_attributes_for_item_with_attribute_values($item->item_id);
        $stock ='';
        $info ='';

        $info = '';

        
        if(row.id=='add_item'){
            $plus_button = '<a class=" position-absolute badge   badge-circle badge-primary fs-6 h-18px w-18px  bottom-5 end-5  " href="#" id="new-person-btn" data-toggle="modal" data-target="#myModalDisableClose">+</a>';
        }else{
            $plus_button = '<span class=" position-absolute badge   badge-circle badge-primary fs-6 h-18px w-18px  bottom-5 end-5  ">+</span>';
            
            if(has_variations){
                if(typeof row.all_data.cur_quantity != 'undefined' ){
                    $stock ='<div class="ribbon-label bg-success"><i class="fa fa-layer-group text-white"></i></div>';
                }
            }else{
                if(typeof row.all_data.cur_quantity != 'undefined' ){
                    if( parseInt(row.all_data.cur_quantity) <= 0  ){
                        $stock ='<div class="ribbon-label bg-danger">'+row.all_data.cur_quantity+'</div>';
                    }else if( parseInt(row.all_data.cur_quantity) <= 10  ){
                        $stock ='<div class="ribbon-label bg-warning">'+row.all_data.cur_quantity+'</div>';
                    }else{
                        $stock ='<div class="ribbon-label bg-success">'+row.all_data.cur_quantity+'</div>';
                    }

                    
                }
            }
            
            
           
        }
        

        htm =
            '<div class="col-sm-4  col-md-3 col-lg-2 mb-2 col-xxl-2 category_item item  register-holder ' +
            image_class + ' ' + item_parent_class + ' " data-has-variations="' + has_variations +
            '" data-max_discount="' + row.max_discount +
            '" data-can_override_price_adjustments="' + row
            .can_override_price_adjustments + '" data-tax_percent="' + row
            .tax_percent + '" data-override_default_tax="' + row
            .override_default_tax + '" data-tax_included="' + row
            .tax_included + '"   data-name="' + row.name + '"  data-price="' +
            price_val + '" data-id="' + row.item_id +
            '" "><div class="card card-flush bg-light h-xl-100 ribbon  ribbon ribbon-top ribbon-clip "> '+$stock+' <!--begin::Body--><div class="card-body text-center pb-5"><!--begin::Overlay--><div class="d-block overlay" ><!--begin::Image--><div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded mb-7" style="height: 70px;background-image:url(' +
            image_src +
            ')"></div><!--end::Image--><!--begin::Action--><div class="overlay-layer card-rounded bg-dark bg-opacity-25"><i class="bi  fs-2x text-white"></i></div><!--end::Action--></div><!--end::Overlay--><!--begin::Info--><span   class="position-absolute symbol-badge badge  badge-light top-55 fs-9 end-0 price_of_item  ">' +
            price +
            '</span><div class="d-flex align-items-end flex-stack mb-1"><span class="fw-bold text-left text-gray-800 cursor-pointer  fs-8 d-block mt-1 w-80">' +
            row.name +
            '</span><!--end::Info--><!--end::Body--><div class="w-20"> '+$plus_button+'</div></div>'+$info+'</div><!--end::Card widget 14--></div></div>';
        $("#category_item_selection_wrapper_new").append(htm);




        }

        // $('.item_parent_class').on('click', function() {

        //     var value = $(this).data('id');
        //     getDocumentById(value);

        // });



}
async function getAllItemsData(category = false) {
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
            
           

            var image_src = row.image_src;
        var has_variations = (row.variations)?row.variations:row.has_variations;

        var prod_image = "";
        var image_class = "no-image";
        var item_parent_class = "";
        if (image_src != '') {
            var item_parent_class = "item_parent_class";
            var prod_image = '<img class="rounded-3 mb-4 h-auto" src="' + image_src + '" alt="" />';
            var image_class = "has-image";
        } 
 
        currency_ = "<?php echo get_store_currency(); ?>"
        price = (row.price ? ' ' + decodeHtml(row
            .price) + ' ' : '');
        price_val = (row.price ? decodeHtml(row
            .price) : '');
        price_val = price_val.replace(currency_, '');
        price_val = parseFloat(price_val.replace(/,/g, ''));
        price_val_reg = (row.regular_price ? decodeHtml(row
            .regular_price) : '');
             price_val_reg = parseFloat(price_val_reg.replace(/,/g, ''));



        items_list[row.item_id] = {
            permissions: row.permissions,
            all_data: row.all_data,
            name: row.name,
            description: row.description,
            item_id: row.item_id,
            quantity: 1,
            category:(typeof row.all_data.category_id !='undefined')?row.all_data.category_id:1,
            cost_price: row.cost_price,
            price: price_val,
            orig_price: price_val_reg,
            discount_percent: 0,
            variations: has_variations,
            item_attributes_available: row.item_attributes_available,
            quantity_units: row.quantity_units,
            modifiers: row.modifiers,
            taxes: row.item_taxes,
            tax_included: row.tax_included
        }





        }

     
        // $('#category_item_selection li:first-child').trigger('click');


        // $('.item_parent_class').on('click', function() {

        //     var value = $(this).data('id');
        //     getDocumentById(value);

        // });

    } catch (error) {
        console.error('Error fetching documents:', error);
    }
    $('#category_item_selection li:first-child').trigger('click');
    // get_single_category_data('top_items');
}

// Call the function to fetch all data

window.onload = function() {
    setTimeout(function() {
        getAllItemsData();
    }, 5000); // 5000ms = 5 seconds
};
// getAllItemsData();




// getAllItemsData(15);





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
                console.log(results);
                // Populate the global map
                results.forEach(result => {
                    categoryMap[result.doc._id.replace('_category', '')] = result.doc;
                });
                console.log(categoryMap);
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


               

                if(contentHTML==''){
                    let item = {
                    image: '<?php echo base_url().'assets/img/item.png'; ?>',
                    name: 'Top Items',
                    id: 'top_items',
                    value: 'top_items',
                    default_image: '<?php echo base_url().'assets/img/item.png'; ?>',
                    sub_categories: [],
                    items_count: 0,
                    sub_categories_list: [],
                    };
                    contentHTML += list_category_template(item);
                }

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

           

            if(categoryId !='top_items' && categoryMap[categoryId].sub_categories > 0) {
                let categoryName = $(this).find('.nav-text').text();
                let newTrail = breadcrumbTrail.concat({
                    id: categoryId,
                    name: categoryName,
                    sub_categories: categoryMap[categoryId]
                });


                CrumbTrailSaved = newTrail;
                getAllCategories(categoryId, newTrail);
            }

           
            get_single_category_data(categoryId);
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
            if (typeof(row.image_src) !== "undefined") {
                default_image = row.image_src;
            }
            var item =  items_list[row.item_id];
            item.image= default_image;
            item.label = item.name;
            item.value =  row.item_id;

           
            
            db_response.push(item);
        }
        response(db_response);


    },
    delay: 500,
    autoFocus: false,
    minLength: 0,
    select: function(event, ui) {

        var item_id = ui.item.value;
     
        console.log("selected" , items_list[item_id]);
        addItem(items_list[item_id]);
        renderUi();
        $(this).val('');
        return false;
    },
}).data("ui-autocomplete")._renderItem = function(ul, item) {
    console.log(item);
    return $("<li class='item-suggestions'></li>")
        .data("item.autocomplete", item)
        .append('<a class="suggest-item"><div class="item-image symbol symbol-50px">' +
            '<img src="' + item.image + '" alt="">' +
            '</div>' +
            '<div class="details">' +
            '<div class="name">' +
            item.label +
            '</div>' +
            '<span class="attributes">' + '<?php echo lang("category"); ?>' + ' : <span class="value">' + (item.all_data
                .category_name ? item.all_data
                .category_name : <?php echo json_encode(lang('none')); ?>) + '</span></span>' +
            <?php if ($this->Employee->has_module_action_permission('items', 'see_item_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>(
                typeof item.all_data.cur_quantity !== 'undefined' && item.all_data.cur_quantity !== null ? '<span class="attributes">' +
                '<?php echo lang("quantity"); ?>' + ' <span class="value">' + item.all_data.cur_quantity + '</span></span>' : ''
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
                taxes  = cart.items[item_id].all_data.taxes;
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

        function renderUi() {

$("#saved_sales_list").empty();
// console.log("UiRefreshed");
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


if( typeof cart['extra']['mode'] =='undefined') {

    cart['extra']['mode'] = 'sale';
}

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


    customArray_source_serial_no = [];
    if (typeof cart_item['all_data']['serial_numbers'] !== 'undefined' ) {
        customArray_source_serial_no = Object.entries(cart_item['all_data']['serial_numbers']).map(([key,
        value]) => {
            return {
                text: value.serial_number,
                value: value.id,
                all_val: value
            };
        });
    }
    var serialnumber = '<?= lang('empty') ?>';
    if (typeof cart_item['serialnumber'] !== 'undefined') {
        serialnumber = cart_item['serialnumber'];
    }

    $('#serialnumber_' + k).editable({
        value: serialnumber,
        source: customArray_source_serial_no,
        success: function(response, newValue) {

            var field = $(this).data('name');
            var index = $(this).data('index');

            if (typeof index !== 'undefined') {

                cart['items'][index][field] = newValue;

                all_sns = cart['items'][index]['all_data']['serial_numbers'];
                var selectedsn = all_sns.find(function(item) {
                    return item.id ==
                    newValue; // Match the newValue with the value in the array
                });
                if (selectedsn) {
                    cart['items'][index]['serialnumberText'] = selectedsn.serial_number;
                    cart['items'][index]['cost_price'] = (selectedsn.cost_price) ? selectedsn
                        .cost_price : cart['items'][index]['cost_price'];
                    cart['items'][index]['orig_price'] = (selectedsn.unit_price) ? selectedsn
                        .unit_price : cart['items'][index]['orig_price'];
                    cart['items'][index]['price'] = (selectedsn.unit_price) ? selectedsn.unit_price :
                        cart['items'][index]['price'];
                } else {
                    cart['items'][index]['serialnumberText'] = newValue;
                }


            }
            localStorage.setItem("cart", JSON.stringify(cart));
            renderUi();
        }

    });

    if(typeof cart['items'][k]['all_data']['permissions'] != 'undefined' ){
        if ((typeof cart['items'][k]['serialnumber'] == 'undefined' || cart['items'][k]['serialnumber'] == '') && cart[
            'items'][k]['all_data']['permissions']['require_to_add_serial_number_in_pos']) {
            $('#add_sn_modal_' + k).show();
        }
    }


    $('#sserialnumber_' + k).editable({
        value: serialnumber,
        source: customArray_source_serial_no,
        success: function(response, newValue) {

            var field = $(this).data('name');
            var index = $(this).data('index');

            if (typeof index !== 'undefined') {

                cart['items'][index][field] = newValue;
                all_sns = cart['items'][index]['all_data']['serial_numbers'];
                var selectedsn = all_sns.find(function(item) {
                    return item.id ==
                    newValue; // Match the newValue with the value in the array
                });
                if (selectedsn) {
                    cart['items'][index]['serialnumberText'] = selectedsn.serial_number;
                    cart['items'][index]['cost_price'] = (selectedsn.cost_price && !selectedsn.cost_price) ? selectedsn
                        .cost_price : (cart['items'][index]['cost_price'])?cart['items'][index]['cost_price']:0;
                    cart['items'][index]['orig_price'] = (selectedsn.unit_price && !selectedsn.unit_price) ? selectedsn
                        .unit_price : (cart['items'][index]['orig_price'])?cart['items'][index]['orig_price']:0;
                    cart['items'][index]['price'] = (selectedsn.unit_price && !selectedsn.unit_price) ? selectedsn.unit_price :
                    (cart['items'][index]['price'])?cart['items'][index]['price']:0;

                } else {
                    cart['items'][index]['serialnumberText'] = newValue;
                }


            }
            localStorage.setItem("cart", JSON.stringify(cart));
            renderUi();
        }

    });

  


    $('#damaged_qty_' + k).editable({
        success: function(response, newValue) {
            //persist data
            var field = $(this).data('name');
            var index = $(this).data('index');
            // console.log(index, field);
            if (typeof index !== 'undefined') {

                cart['items'][index][field] = newValue;
            }
            renderUi();
        }
    });




    customArray_source_supplier_data = [];
        if (typeof cart_item['all_data']['source_supplier_data'] !== 'undefined') {
            customArray_source_supplier_data = Object.entries(cart_item['all_data']['source_supplier_data']).map(([key,
                value
            ]) => {
                return {
                    text: value.text,
                    value: value.value
                };
            });
        }

    $('#supplier_' + k).editable({
        value: cart_item['supplier_id'],
        source: customArray_source_supplier_data,
        success: function(response, newValue) {

            var field = $(this).data('name');
            var index = $(this).data('index');

            if (typeof index !== 'undefined') {
                // console.log(newValue);
                cart['items'][index][field] = newValue;
                console.log(newValue);
                console.log(index);
            

                cart['items'][index].supplier_name = cart['items'][index]['all_data']['source_supplier_data'][newValue].text;
            }


            localStorage.setItem("cart", JSON.stringify(cart));


            refresh_cart_var();

            set_supplier_id(newValue, index);

        }

    });

//  console.log('quantity_units' , cart_item);
customArray = [];
if (typeof cart_item['quantity_units'] !== 'undefined') {

    customArray = Object.entries(cart_item['quantity_units']).map(([key, value]) => {
        return {
            text: value.text,
            value: value.value
        };
    });

}

    // customArray.push(['text' : 'none' , 'value' :  '0'])
    // console.log(customArray);
    $('#quantity_unit_' + k).editable({
        value: cart_item['quantity_unit_id'],
        source: customArray,
        success: function(response, newValue) {

            var field = $(this).data('name');
            var index = $(this).data('index');

            if (typeof index !== 'undefined') {

                cart['items'][index][field] = newValue;
                cart['items'][index].quantity_units_name = cart['items'][index]['all_data']['quantity_units'][newValue].text;
            }


            localStorage.setItem("cart", JSON.stringify(cart));


            refresh_cart_var();


            set_quantity_unit_id(newValue, index);

        }

    });
    customArrayTire = [];

    if (typeof cart_item['quantity_units'] !== 'undefined') {

customArrayTire = Object.entries(cart_item.all_data.all_tier_info).map(([key, value]) => {
    return {
        text: value.name,
        value: value.id
    };
});

}



    $('#tier_' + k).editable({
        value: cart_item['tier_id'],
        source: customArrayTire,
        success: function(response, newValue) {

            var field = $(this).data('name');
            var index = $(this).data('index');

            if (typeof index !== 'undefined') {

                cart['items'][index].previous_tier_id = (cart['items'][index][field]) ? cart['items'][index][field] : 0;
                cart['items'][index][field] = newValue;
                cart['items'][index].tier_name = cart['items'][index].all_data.all_tier_info[newValue].name;
            }


            localStorage.setItem("cart", JSON.stringify(cart));


            refresh_cart_var();


            set_tier_id(newValue, true);

        }

    });





}


$('.xeditable-item-percentage').editable({
    success: function(response, newValue) {
        //persist data
        var field = $(this).data('name');
        var index = $(this).data('index');
        if (typeof index !== 'undefined') {

            if (parseFloat(cart['items'][index]['all_data']['max_discount']) < parseFloat(newValue)) {
                show_feedback('error', cart['items'][index]['all_data']['permissions'][
                        'sales_could_not_discount_item_above_max'
                    ] + " " + parseFloat(cart['items'][index]['all_data']['max_discount']),
                    "<?php echo  lang('error') ?>");
                return false;
            }
            cart['items'][index][field] = newValue;
        }
        renderUi();
    }
});

$('.xeditable-cost_price').editable({
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

$('.xeditable-description').editable({
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

function item_subtotal($item){
    // return to_currency_no_money((get_modifiers_subtotal($item) - (get_modifiers_subtotal($item) * $item['discount'] / 100))+ ($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100));
    // console.log( 'discount' ,  $item['discount']);
    return (get_modifiers_subtotal($item) - (get_modifiers_subtotal($item) * $item['discount_percent'] / 100))+ ($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount_percent']/100);
}

function edit_subtotal($new_subtotal)
{
    var item_discount = get_item_discount(cart);
    var subtotal = get_subtotal(cart);

    // Adjusting subtotal by subtracting item discount
    subtotal = parseFloat(subtotal) - parseFloat(item_discount);


    $cur_subtotal = subtotal;
    $subtotal_change = $new_subtotal - $cur_subtotal;
            


    for (var k = 0; k < cart.items.length; k++) {
        $item = cart.items[k];

        if ($cur_subtotal == 0)
        {
            if ($cur_subtotal == 0)
            {
                $percentage_of_cart = 1;
            }
            else
            {
                $percentage_of_cart = 0;
            }
        }
        else
        {
            $percentage_of_cart = (item_subtotal($item) + get_modifiers_subtotal($item)) / $cur_subtotal;		
        }


        $item_sub_total = item_subtotal($item)  + ($subtotal_change * $percentage_of_cart);	
        cart['items'][k]['price'] = -1*((100*$item_sub_total)/($item['quantity']*($item['discount_percent']-100)));

    }
    
}


$('.xeditable-subtotal').editable({
    success: function(response, newValue) {

        edit_subtotal(newValue);
        var item_discount = get_item_discount(cart);
        var subtotal = get_subtotal(cart);

        // Adjusting subtotal by subtracting item discount
        subtotal = parseFloat(subtotal) - parseFloat(item_discount);

        renderUi();

    

    }
});

$('.xeditable-item-quantity-received').editable({
    success: function(response, newValue) {
        qty = $(this).data('total-qty');
        if (newValue > qty) {
            show_feedback('error',
                "<?php echo  lang('quantity_received_should_not_be_greater_than_item_qty') ?>",
                "<?php echo  lang('error') ?>");
            return false;
        } else {
            var field = $(this).data('name');
            var index = $(this).data('index');
            if (typeof index !== 'undefined') {
                cart['items'][index][field] = newValue;
            }
            renderUi();
        }


    }
});




$('#total_items').html(cart['items'].length);
$('#total_items_qty').html(total_qty);

$('.toggle_rows').click(function() {

    $(this).parent().parent().next().toggleClass('collapse');

    if ($(this).parent().parent().next().hasClass("collapse")) {
        $(this).html('<i class="icon ti-angle-down"></i>');
        $(this).parent().parent().next().addClass("d-none")
    } else {
        $(this).html('<i class="icon ti-angle-up"></i>');
        $(this).parent().parent().next().removeClass("d-none")
    }
});

$("#sale_details_expand_collapse").click(function() {
    $('.register-item-bottom').toggleClass('collapse');

    if ($('.register-item-bottom').hasClass('collapse')) {
        $.post('<?php echo site_url("sales/set_details_collapsed"); ?>', {
            value: '1'
        });
        $("#sale_details_expand_collapse").html('<i class="icon ti-angle-down"></i>');
        $(".show-collpased").show();

    } else {
        $.post('<?php echo site_url("sales/set_details_collapsed"); ?>', {
            value: '0'
        });
        $("#sale_details_expand_collapse").html('<i class="icon ti-angle-up"></i>');
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
        'sold_by_employee_id'
    ] + '"]');

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


$('#customer-panel').html(selected_customer_template(cart));
$('#redeem_discount').on('click', function(e) {
redeem_discount();
});
$('#unredeem_discount').on('click', function(e) {
unredeem_discount();
});
$('.xeditable-comment').editable({
        success: function(response, newValue) {
            cart['customer']['internal_notes'] = newValue;
            renderUi();
        }
    });

$(".btn[data-kt-menu-trigger='custom']").on("click", function (e) {
    e.stopPropagation(); // Prevent event from bubbling up

    let button = $(this); // Get the clicked button
    let menu = button.next(".menu-sub-dropdown"); // Get the associated menu

    if (menu.is(":visible")) {
        menu.hide(); // Hide menu if already visible
    } else {
        $(".menu-sub-dropdown").hide(); // Hide all other open menus first

        // Calculate position
        let buttonOffset = button.offset();
        let buttonHeight = button.outerHeight();
        let buttonWidth = button.outerWidth();
        let menuWidth = menu.outerWidth();
        let right = $(window).width() - (buttonOffset.left + buttonWidth);
        menu.css({
            display: "block",
            position: "absolute",
            top: buttonOffset.top + buttonHeight + 5 + "px", // Below the button with 5px gap
            right: right  + "px", // Centered horizontally
            display: "block", // Show menu
            zIndex: 100, // Ensure it's above other elements
        });
    }
});

// Hide menu when clicking outside
$(document).on("click", function (e) {
    if (!$(e.target).closest(".menu, .btn[data-kt-menu-trigger='custom']").length) {
        $(".menu-sub-dropdown").hide();
    }
});

// Handle window resize to reposition the menu
$(window).on("resize", function () {
    $(".menu:visible").each(function () {
        let menu = $(this);
        let button = menu.prev(".btn[data-kt-menu-trigger='custom']");
                // Check if button exists
        if (button.length === 0) {
            return; // Skip iteration if no button found
        }

        let buttonOffset = button.offset();
        let buttonHeight = button.outerHeight();
        let buttonWidth = button.outerWidth();
        let menuWidth = menu.outerWidth();

        menu.css({
            top: buttonOffset.top + buttonHeight + 5 + "px",
            left: buttonOffset.left + buttonWidth / 2 - menuWidth / 2 + "px",
        });
    });
});



// if (cart['extra']['coupons']) {

//     var tokens = [{ value: "blue", label: "Blau" }, { value: "red", label: "Rot" }];

//         // Convert the tokens array into a string of values
//         var tokenValues = tokens.map(function(token) {
//             return token.value;
//         }).join(',');
//         console.log( 'ssssss' , tokenValues);
//         // Set the tokens
//         $('.coupon_codes').tokenfield('setTokens', tokenValues);
// }
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


$("#sub_total").attr('data-value', subtotal).html(subtotal);
localStorage.setItem('cart_sub_total' ,subtotal );

$("#taxes").html(taxes);
localStorage.setItem('cart_taxes' ,taxes );
$("#total").html(total);
localStorage.setItem('cart_total' ,total );
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
localStorage.setItem('cart_amount_due' ,amount_due );
// console.log(cart['customer']);
$('.balance').removeClass(' text-success text-danger');
if (cart['customer'] && cart['customer']['person_id']) {






    $("#customer-panel").removeClass('hidden');
    $("#select_customer_form").addClass('hidden');
} else {
    $("#customer").val('');
    $("#customer-panel").addClass('hidden');
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


$('.xeditable').editable({
    success: function(response, newValue) {
        //persist data
        var field = $(this).data('name');
        var index = $(this).data('index');
        // console.log(index);
        if (typeof index !== 'undefined') {

            if (cart.items[parseInt(index)].all_data.permissions.process_returns && (field ==
                    'quantity' || field == 'price' || field == 'modifier_price') && parseInt(
                    newValue) < 0) {

                    


                show_feedback('error', cart.items[parseInt(index)].all_data.permissions
                    .process_returns_error, "<?php echo  lang('error') ?>");
                return false;
            }

            if(field=='price'){
                    if (!check_allow_added(cart, index, 'price', newValue)) {
                        return false;
                    }

                }
                if(field=='price-line-total'){
                    if (!check_allow_added(cart, index, 'price-line-total', newValue)) {
                        return false;
                    }

                }

            if (field == 'modifier_price') {
                cart.items[parseInt(index)].selected_item_modifiers[parseInt($(this).data(
                    'modifier-item-id'))].unit_price = newValue;
                cart.items[parseInt(index)].selected_item_modifiers[parseInt($(this).data(
                    'modifier-item-id'))].unit_price_currency = currency_symbol + newValue;

            } else {

                if(field=='quantity'){
                    if (!check_allow_added(cart, index, 'quantity_bulk', newValue)) {
                        return false;
                    }

                }
            
                cart['items'][index][field] = newValue;
            }


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

$('.slider_button').click(function() { 

        close_all_drawers();
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


    var tax_info = cart_item.all_data.taxes;
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
        if( typeof cart_item.is_returned =='undefined'){
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
                        if (cart_item.modifiers[j]['modifier_item_id'] == cart_item.selected_item_modifiers[modifier_id]
                            .id) {
                            if (cart_item.tax_included == '1') {
                                var modifier_price = get_price_without_tax_for_tax_incuded_modifier_item(cart_item,
                                    cart_item.selected_item_modifiers[modifier_id])

                            } else {
                                var modifier_price = parseFloat(to_currency_no_money(cart_item.selected_item_modifiers[
                                    modifier_id].unit_price));
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


edit_variation_index = 'none';

function showNextAttribute(currentIndex, attributeKeys) {
    if (currentIndex >= attributeKeys.length) {
        $('#attributeModal').modal('hide');
        // alert('All attributes selected!');
        // console.log('selectedAttributes:', selectedAttributes);
        // console.log('item_obj:', item_obj);
        // console.log('item_obj var:', item_obj.variations);
        let resultString = '';
        $.each(selectedAttributes, function(attributeKey, selectedValueKey) {
            resultString += selectedValueKey;

        });
        // console.log('resultString',resultString);

        let matchingVariation = item_obj.variations.find(variation => variation.attribute_string ===
            resultString);
        // var selling_price = parseFloat(matchingVariation.price);

       

        if( typeof matchingVariation != 'undefined' ){

            selling_price = matchingVariation.price_without_currency;

            $price  =    getSalePrice({
                    permissions: item_obj.permissions,
                    all_data: item_obj.all_data,
                    quantity_units: item_obj.quantity_units,
                    name: item_obj.name + " [ " + matchingVariation.name + " ]",
                    description: item_obj.description,
                    item_id: matchingVariation.id,
                    variation_id:matchingVariation.id.split("#")[1],
                    quantity: 1,
                    selected_variation: resultString,
                    selectedAttributes: selectedAttributes,
                    price: 0,
                    cost_price: item_obj.cost_price,
                    orig_price: selling_price,
                    discount_percent: 0,
                    variations: matchingVariation.has_variations,
                    modifiers: item_obj.modifiers,
                    taxes: matchingVariation.item_taxes,
                    tax_included: matchingVariation.tax_included
                });
                console.log("vartion price " , $price);



                addItem({
                    permissions: item_obj.permissions,
                    all_data: item_obj.all_data,
                    quantity_units: item_obj.quantity_units,
                    name: item_obj.name + " [ " + matchingVariation.name + " ]",
                    description: item_obj.description,
                    item_id: matchingVariation.id,
                    variation_id:matchingVariation.id.split("#")[1],
                    quantity: 1,
                    selected_variation: resultString,
                    selectedAttributes: selectedAttributes,
                    price: $price,
                    cost_price: item_obj.cost_price,
                    orig_price: selling_price,
                    discount_percent: 0,
                    variations: matchingVariation.has_variations,
                    modifiers: item_obj.modifiers,
                    taxes: matchingVariation.item_taxes,
                    tax_included: matchingVariation.tax_included
                });
              
                 // addItem(matchingVariation);
            renderUi();
           
              
            // console.log('Selected Attributes:', matchingVariation);

        }else{
            show_feedback('error', "<?php echo  lang('variation_not_found') ?>" , "<?php echo  lang('error') ?>");
        }

        return;
    }
    
    
    
    const currentAttributeKey = attributeKeys[currentIndex];
    const currentAttribute = attributes[currentAttributeKey];
    const options = currentAttribute.attr_values;
    // console.log('Current selectedAttributes Attributes:',selectedAttributes)
    // console.log('Current options Attributes:',options)
    // console.log('Current currentAttributeKey Attributes:',currentAttributeKey)
    let optionsHtml = ``;
   
    optionsHtml +=
        `
                <div class="fv-row mb-15 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid" data-kt-buttons="true" data-kt-initialized="1">`;
    for (let key in options) {
        var isChecked = '';
        var $stockHtml = "";
        var $stock_val = 'Not Set';
        if(typeof selectedAttributes != 'undefined'){
             isChecked = selectedAttributes[currentAttributeKey] === key ? 'checked' : '';
        }
       
        if(currentIndex + 1  == attributeKeys.length){


                let resultString_n = '';
                var lastKey ='KEY';
                if(edit_variation_index!='none'){
                    var keys = Object.keys(selectedAttributes); // Get all keys as an array
                    var lastKey = keys[keys.length - 1]; // Get the last key
                }
            


                $.each(selectedAttributes, function(attributeKey, selectedValueKey) {
                    if (attributeKey != lastKey) { // Skip the last item
                            resultString_n += selectedValueKey;
                        }
                });
                resultString_n += key;
                let matchingVariation = [];
                if(item_obj.variations!=false && item_obj.variations.length > 0 ){
                    matchingVariation = item_obj.variations.find(variation => variation.attribute_string == resultString_n);
                }else{
                    let matchingVariation = item_obj.all_data.has_variations.find(variation => variation.attribute_string == resultString_n);
                }

                if(matchingVariation){
                    $stock_val = parseInt(matchingVariation.item_location_quantity);
                    if($stock_val > 10){
                        $bg = 'primary';
                    }else if($stock_val < 10 && $stock_val >0){
                        $bg = 'warning';
                    }else{
                        $bg = 'danger';
                    }
                    $stock_val = isNaN( $stock_val) ? "Not Set" :  $stock_val;
                    $stockHtml = '<span class="badge badge-'+$bg+' badge">'+$stock_val+'</span>';
                
                    
                }
                //     console.log('matchingVariation last step',matchingVariation)

                }


        
        optionsHtml += ` <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active   ">
 
                <!--begin::Input-->
                <input class="form-check-input" type="radio" name="attributeOption" id="option-${key}" data-stock="${$stock_val}" value="${key}" ${isChecked}>
                <!--end::Input-->

                <!--begin::Label-->
                <span class="d-flex">
                
                    <span class="ms-4">
                        <span class="fs-3 fw-bold text-gray-900   mt-3 d-block" for="option-${key}">${options[key].name}  ${$stockHtml}  </span>

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

function edit_variation(index) {

    cart_item = cart.items[index];
    // console.log("edit variant", item_obj);

    if (cart_item.item_id.includes('#')) {
        // Extract the value before '#'
        valueBeforeHash = cart_item.item_id.split('#')[0];
        item_obj = items_list[valueBeforeHash];
        attributes = item_obj.item_attributes_available;
        attributeKeys = Object.keys(attributes);
        currentIndex = 0;
        selectedAttributes = cart_item.selectedAttributes;
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
    currency_ = "<?php echo get_store_currency(); ?>"
       
    let found = false;

    if (cart['extra']['discount_all_percent'] >  0  &&  newItem.discount_percent ==0  &&  newItem.name !='discount' ) {
            newItem.discount_percent = cart['extra']['discount_all_percent'];
        }


    <?php if(!$this->config->item('do_not_group_same_items')): ?>
    if (edit_variation_index == 'none') {
        if (parseInt(newItem.item_id) != 0) {
            for (let item of cart.items) {

                if (item.item_id === newItem.item_id && (typeof item.free_item == 'undefined' || (typeof item
                        .free_item != 'undefined' && item.free_item == false)) && typeof  item.is_returned =='undefined' ) {

                            // if (cart['extra']['mode'] == 'sale') {
                            //     item.quantity = parseInt(item.quantity) + 1;
                            // }else{
                            //     item.quantity = parseInt(item.quantity) - 1;
                            // }

                     item.quantity = parseInt(item.quantity) + 1; // example: updating quantity

                    if (typeof item.all_data.rules !== 'undefined' && typeof item.all_data.rules.rule_item !=
                        'undefined' && item.all_data.rules.rule_item == true) {

                        get_price_rule_for_item();
                    }


                    found = true;
                    break;
                }
            }
        }
    }

    <?php endif; ?>
    if (!found) {
        if (cart['extra']['redeem'] == true  &&  newItem.name !='discount') {
            newItem.discount_percent = cart['extra']['discount_all_percent'];
        }
        if (cart['extra']['tier_id']) {
            newItem.previous_tier_id = 0;
            newItem.tier_id = cart['extra']['tier_id'];
            newItem.tier_name = $all_tiers[cart['extra']['tier_id']].text;

        }

        // if (cart['extra']['mode'] != 'sale') {
            
        //     newItem.quantity = parseInt(newItem.quantity) - 2;
        // }

        if(newItem.price ==''){
            newItem.price = 0;
        }
        if(newItem.orig_price ==''){

            newItem.orig_price = newItem.all_data.regular_price;
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
        if (typeof newItem.all_data.rules !== 'undefined' && typeof newItem.all_data.rules.rule_item != 'undefined' &&
            newItem.all_data.rules.rule_item == true) {

            get_price_rule_for_item();
        }
        var newIndex = cart['items'].length - 1;





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
        percentageLeft = Math.max(45, Math.min(percentageLeft, 55)); // Ensure the width is between 40% and 60%
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
        attr_stock = $('input[name="attributeOption"]:checked').data('stock');
        if(attr_stock !='Not Set'){
            if(  parseInt(attr_stock) <= 0   &&  item_obj.all_data.permissions.do_not_allow_out_of_stock_items_to_be_sold =='1' ){
                show_feedback('error', "<?= lang('sales_unable_to_add_item_out_of_stock');  ?>",
                    "<?php echo  lang('error') ?>");
                return false;
            }
        }

        currentAttributeKey = attributeKeys[currentIndex];
        if (!selectedAttributes) {
            selectedAttributes = {}; // Initialize as an empty object
        }
        if (!selectedAttributes[currentAttributeKey]) {
            selectedAttributes[currentAttributeKey] = {}; // Initialize the key if undefined
        }

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

        // console.log(indexedModifiers);
        cart.items[selected_line_modifier].selected_item_modifiers = indexedModifiers;
        // console.log(selectedModifiers);
        selected_line_modifier = 'none';
        jQuery('#choose_modifiers').modal('hide');
        renderUi();
    });
    $('#category_item_selection_wrapper_new').on('click', '.category_item.item', function(event) {
        // console.log("clicked");
        $('#grid-loader2').show();
        event.preventDefault();

       

        if ($(event.target).closest('a').length) {
            return; // Simply return without stopping propagation
        }


        edit_variation_index = 'none';
        var $that = $(this);
        if ($(this).data('has-variations') !='undefined') {

            item_obj = items_list[$(this).data('id')];
            attributes = item_obj.item_attributes_available;
            attributeKeys = Object.keys(attributes);
            currentIndex = 0;
            selectedAttributes = {};




            // Start the process
            showNextAttribute(currentIndex, attributeKeys);



        } else {
            if($(this).data('id') !='add_item'){
            item_obj = items_list[$(this).data('id')];
            cart = JSON.parse(localStorage.getItem('cart'));
            j = 0;
            if(  parseInt(item_obj.all_data.item_location_quantity) <= 0   &&  item_obj.all_data.permissions.do_not_allow_out_of_stock_items_to_be_sold  =='1' ){
                show_feedback('error', "<?= lang('sales_unable_to_add_item_out_of_stock');  ?>",
                    "<?php echo  lang('error') ?>");
                return false;
            }
            for (let item of cart.items) {

                    if (item.item_id === item_obj.item_id){
                        if (!check_allow_added(cart, j , 'quantity', 1) ) {
                            return false;
                        }
                    }

                    j++;
            }



          
           
            // console.log(item_obj);
            addItem(item_obj);
            localStorage.setItem('is_cart_oc_updated', 0);
            let lastUpdated = localStorage.getItem('lastUpdated');
            renderUi();
            $('#grid-loader2').hide();
            }
        }
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
        statusDiv.textContent = '<?= lang('Online_Mode') ?>';

        bootbox.alert({
            title: '<?= lang('Alert') ?>',
            closeButton: false,
            message: <?php echo json_encode(lang("You_are_online_now_To_sync_latest_data_please_reload_Your_saved_data_is_preserved")); ?>,
            callback: function() {
                window.location.href = "<?php echo base_url() ?>sales";
            }
        });


        
    } else {
        statusDiv.className = 'offline';
        statusDiv.textContent = '<?= lang('Offline_Mode') ?>';
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