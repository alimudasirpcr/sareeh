<?php $this->load->view("partial/header"); ?>
<div id="sales_page_holder">
	<div id="sale-grid-big-wrapper" class="clearfix register card <?php echo $this->config->item('hide_images_in_grid') ? 'hide_images' : ''; ?>">
	<div class="clearfix" id="category_item_selection_wrapper">
		<div class="">
				<div class="spinner" id="grid-loader" style="display:none">
			<div class="rect1"></div>
			<div class="rect2"></div>
			<div class="rect3"></div>
			</div>

			<div class="text-center">
				<div id="grid_selection" class="btn-group" role="group">
					<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'categories' || !$this->config->item('default_type_for_grid') ? 'btn active' : '';?> btn btn-grid btn-success" id="by_category"><?php echo lang('reports_categories')?></a>
					<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'tags' ? 'btn active' : '';?> btn btn-grid btn-success" id="by_tag"><?php echo lang('tags')?></a>
					<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'suppliers' ? 'btn active' : '';?> btn btn-grid btn-success" id="by_supplier"><?php echo lang('suppliers') ?></a>
					<a href="javascript:void(0);" class="<?php echo $this->config->item('default_type_for_grid') == 'favorites' ? 'btn active' : '';?> btn btn-grid btn-success" id="by_favorite"><?php echo lang('favorite')?></a>
				</div>
			</div>

		<div id="grid_breadcrumbs"></div>
			<div id="category_item_selection" class="row register-grid nav nav-pills nav-pills-custom  p-0 mt-1 m-0"></div>
			<div id="category_item_selection_wrapper_new" class="row register-grid nav nav-pills nav-pills-custom  p-0 mt-1 m-0"></div>
			<div class="pagination hidden-print alternate text-center"></div>
		</div>
	</div>
	</div>

	<div id="register_container" class="sales clearfix">
		<?php $this->load->view("receivings/receiving"); ?>
	</div>
</div> 
<script type="text/javascript">
$(document).ready(function()
{
	$(window).load(function()
	{
		setTimeout(function()
		{
		<?php if ($fullscreen) { ?>
			$('.fullscreen').click();
		<?php }
		else {
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
	
  var categories_stack = [{category_id: 0, name: <?php echo json_encode(lang('all')); ?>}];
  
  function updateBreadcrumbs(item_name)
  {
     var breadcrumbs = '';
     for(var k = 0; k< categories_stack.length;k++)
     {
       var category_name = categories_stack[k].name;
       var category_id = categories_stack[k].category_id;
   
       breadcrumbs += (k != 0 ? ' &raquo ' : '' )+'<a href="javascript:void(0);"class="category_breadcrumb_item" data-category_id = "'+category_id+'">'+category_name+"</a>";
     }
 		 
		 if (typeof item_name != "undefined" && item_name)
		 {
		 	 breadcrumbs +=' &raquo '+item_name;
		 }
		 
     $("#grid_breadcrumbs").html(breadcrumbs);		  
  }
  
  $(document).on('click', ".category_breadcrumb_item",function()
  {
      var clicked_category_id = $(this).data('category_id');      
      var categories_size = categories_stack.length;
      current_category_id = clicked_category_id;
      
      for(var k = 0; k< categories_size; k++)
      {
        var current_category = categories_stack[k]
        var category_id = current_category.category_id;
        
        if (category_id == clicked_category_id)
        {
          if (categories_stack[k+1] != undefined)
          {
            categories_stack.splice(k+1,categories_size - k - 1);
          }
          break;
        }
      }
      
      if (current_category_id != 0)
      {
        loadCategoriesAndItems(current_category_id,0);
      }
      else
      {
        loadTopCategories();
      }
  });
  
	function loadTopCategories()
	{    
		$('#grid-loader').show();
		$.get('<?php echo site_url("receivings/categories");?>', function(json)
		{
			processCategoriesResult(json);
		}, 'json');	
	}
	
	function loadTags()
	{
		$('#grid-loader').show();
		$.get('<?php echo site_url("receivings/tags");?>', function(json)
		{
			processTagsResult(json);
		}, 'json');	
	}

	function loadSuppliers() {
		$('#grid-loader').show();
		$.get('<?php echo site_url("receivings/suppliers"); ?>', function(json) {
			processSuppliersResult(json);
		}, 'json');
	}
  
  function loadCategoriesAndItems(category_id, offset)
  {
	  $('#grid-loader').show();
    current_category_id = category_id;
    //Get sub categories then items
    $.get('<?php echo site_url("receivings/categories_and_items");?>/'+current_category_id+'/'+offset, function(json)
    {
        processCategoriesAndItemsResult(json);
    }, "json");
  }
	
	function loadCategoriesAndItemsUrl(category_id, url)
	{
    $('#grid-loader').show();
    current_category_id = category_id;
    //Get sub categories then items
    $.get(url, function(json)
    {
        processCategoriesAndItemsResult(json);
    }, "json");
	}
  
  function loadTagItems(tag_id, offset)
  {
	  $('#grid-loader').show();
	  current_tag_id = tag_id;
     //Get sub categories then items
     $.get('<?php echo site_url("receivings/tag_items");?>/'+tag_id+'/'+offset, function(json)
     {
         processTagItemsResult(json);
     }, "json");
  }
	
	function loadTagItemsUrl(tag_id, url)
	{
    $('#grid-loader').show();
 	 current_tag_id = tag_id;
    //Get sub categories then items
    $.get(url, function(json)
    {
        processTagItemsResult(json);
    }, "json");
	}
	
  function loadFavoriteItems(offset)
  {
     $('#grid-loader').show();
     //Get sub categories then items
     $.get('<?php echo site_url("sales/favorite_items");?>/'+offset, function(json)
     {
         processFavoriteItemsResult(json);
     }, "json");
  }
  
	function loadFavoriteItemsUrl(url)
	{
    $('#grid-loader').show();
    $.get(url, function(json)
    {
        processFavoriteItemsResult(json);
    }, "json");
	}

	function loadSupplierItem(supplier_id, offset) {
		$('#grid-loader').show();
		current_supplier_id = supplier_id;
		//Get sub categories then items
		$.get('<?php echo site_url("receivings/supplier_items"); ?>/' + supplier_id + '/' + offset, function(json) {
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

	$(document).on('click', ".pagination.categories a", function(event)
	{
		$('#grid-loader').show();
		event.preventDefault();	
		$.get($(this).attr('href'), function(json)
		{
			processCategoriesResult(json);
      
		}, "json");
	});
	
	$(document).on('click', ".pagination.tags a", function(event)
	{
		$('#grid-loader').show();
		event.preventDefault();
	
		$.get($(this).attr('href'), function(json)
		{
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
  
	$(document).on('click', ".pagination.categoriesAndItems a", function(event)
	{
		$('#grid-loader').show();
		event.preventDefault();
		loadCategoriesAndItemsUrl(current_category_id, $(this).attr('href'));
	});
	 
 	$(document).on('click', ".pagination.items a", function(event)
 	{
 		$('#grid-loader').show();
 		event.preventDefault();
 	  loadTagItemsUrl(current_tag_id, $(this).attr('href'));
 	 });

 	$(document).on('click', ".pagination.favorite a", function(event)
 	{
 		$('#grid-loader').show();
 		event.preventDefault();
 	  loadFavoriteItemsUrl($(this).attr('href'));
 	});

	 $(document).on('click', ".pagination.supplierItems a", function(event) {
		$('#grid-loader').show();
		event.preventDefault();
		loadSupplierItemsUrl(current_supplier_id, $(this).attr('href'));
	});

	$('#category_item_selection_wrapper').on('click','.category_item.category', function(event)
	{
      event.preventDefault();
      current_category_id = $(this).data('category_id');
      var category_obj = {category_id: current_category_id, name: $(this).find('p').text()};
      categories_stack.push(category_obj);
      loadCategoriesAndItems($(this).data('category_id'), 0);
	});
	
	$('#category_item_selection_wrapper').on('click','.category_item.tag', function(event)
	{
      event.preventDefault();
		current_tag_id = $(this).data('tag_id');
      loadTagItems($(this).data('tag_id'), 0);
	});

	$('#category_item_selection_wrapper').on('click', '.category_item.supplier', function(event) {
		event.preventDefault();
		current_supplier_id = $(this).data('supplier_id');
		loadSupplierItem($(this).data('supplier_id'), 0);
	});
	
	$('#category_item_selection_wrapper').on('click','#by_category', function(event)
	{
	 	current_category_id = null;
		current_tag_id = null;
		$('.btn-grid').removeClass('active');
		$(this).addClass('active');
		$("#grid_breadcrumbs").html('');
		categories_stack = [{category_id: 0, name: <?php echo json_encode(lang('all')); ?>}];
		loadTopCategories();
	});
	
	$('#category_item_selection_wrapper').on('click','#by_tag', function(event)
	{
	 	current_category_id = null;
		current_tag_id = null;
		$('.btn-grid').removeClass('active');
		$(this).addClass('active');
		$("#grid_breadcrumbs").html('');
		loadTags();
	});
	
	$('#category_item_selection_wrapper').on('click','#by_favorite', function(event)
	{
	 	current_category_id = null;
		current_tag_id = null;
		$('.btn-grid').removeClass('active');
		$(this).addClass('active');
		$("#grid_breadcrumbs").html('');
		loadFavoriteItems(0);
	});

	$('#category_item_selection_wrapper').on('click', '#by_supplier', function(event) {
		current_category_id = null;
		current_tag_id = null;
		current_supplier_id = null;
		$("#grid_breadcrumbs").html('');
		$('.btn-grid').removeClass('active');
		$(this).addClass('active');
		loadSuppliers();
	});
	
	$('#category_item_selection_wrapper').on('click','.category_item.item', function(event)
	{		
		$('#grid-loader').show();
		event.preventDefault();
		
		var $that = $(this);
		if($(this).data('has-variations'))
		{
   	 $.post('<?php echo site_url("receivings/add");?>', {item: $(this).data('id')+"|FORCE_ITEM_ID|" }, function(response)
			{
				<?php
				if (!$this->config->item('disable_sale_notifications')) 
				{
					echo "show_feedback('success', ".json_encode(lang('successful_adding')).", ".json_encode(lang('success')).");";
				}
				?>
				$('#grid-loader').hide();			
				$("#register_container").html(response);
				$('.show-grid').addClass('hidden');
				$('.hide-grid').removeClass('hidden');
			});
		}
		else
		{
			$.post('<?php echo site_url("receivings/add");?>', {item: $(this).data('id')+"|FORCE_ITEM_ID|" }, function(response)
			{
				<?php
				if (!$this->config->item('disable_sale_notifications')) 
				{
					echo "show_feedback('success', ".json_encode(lang('successful_adding')).", ".json_encode(lang('success')).");";
				}
				?>
				$('#grid-loader').hide();			
				$("#register_container").html(response);
				$('.show-grid').addClass('hidden');
				$('.hide-grid').removeClass('hidden');
			});
		}
	});

	$("#category_item_selection_wrapper").on('click', '#back_to_categories', function(event)
	{ 
		$('#grid-loader').show();		
		event.preventDefault();
    //Remove element from stack
    categories_stack.pop();
    
    //Get current last element
    var back_category = categories_stack[categories_stack.length - 1];
    
    if (back_category.category_id != 0)
    {
      loadCategoriesAndItems(back_category.category_id,0);
    }
    else 
    {
      loadTopCategories();
    }
  });
  
	$("#category_item_selection_wrapper").on('click', '#back_to_tags', function(event)
	{ 
		$('#grid-loader').show();
		event.preventDefault();
	   loadTags();
	});
	
	$("#category_item_selection_wrapper").on('click', '#back_to_tag', function(event)
	{ 
		$('#grid-loader').show();
		event.preventDefault();
		loadTagItems(current_tag_id,0);
		});

	$("#category_item_selection_wrapper").on('click', '#back_to_category', function(event)
	{ 
		$('#grid-loader').show();		
		event.preventDefault();
    
    //Get current last element
    var back_category = categories_stack[categories_stack.length - 1];
    
    if (back_category.category_id != 0)
    {
      loadCategoriesAndItems(back_category.category_id,0);
    }
    else 
    {
      loadTopCategories();
    }
	});
	
	$("#category_item_selection_wrapper").on('click', '#back_to_favorite', function(event)
	{ 
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
			$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('tags').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('categories');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			$("#category_item_selection").html('');

			for (var k = 0; k < json.categories.length; k++) {
				var category_item = $("<div/>").attr('class', 'category_item category col-md-2 register-holder categories-holder col-sm-3 col-xs-6').css('background-color', json.categories[k].color).data('category_id', json.categories[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.categories[k].name + '</p>');

				if (json.categories[k].image_id) {
					category_item.css('background-color', 'white');
					category_item.css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.categories[k].image_id + '?timestamp=' + json.categories[k].image_timestamp + ')');
				}
			category_item = '<li data-category_id="'+json.categories[k].id+'" class=" col-1 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.categories[k].image_id + '?timestamp=' + json.categories[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


				$("#category_item_selection").append(category_item);
			}
			
			updateBreadcrumbs();
			$('#grid-loader').hide();
		}
	
	
		function processTagsResult(json) {
			$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('categories').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('tags');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			$("#category_item_selection").html('');

			for (var k = 0; k < json.tags.length; k++) {
				//var tag_item = $("<div/>").attr('class', 'category_item tag col-md-2 register-holder tags-holder col-sm-3 col-xs-6').data('tag_id', json.tags[k].id).append('<p> <i class="ion-ios-pricetag-outline"></i> ' + json.tags[k].name + '</p>');

				var tag_item = '<li data-tag_id="'+json.tags[k].id+'"  class=" col-1  category_item tag register-holder tags-holder  nav-item mb-3 me-3 me-lg-6" role="presentation"><div class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active " data-bs-toggle="pill"  aria-selected="true" role="tab"><div class="nav-icon"><i class="ion-ios-pricetag-outline text-danger " style="font-size:60px"></i> </div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.tags[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></div></li>';

				$("#category_item_selection").append(tag_item);
			}

			$('#grid-loader').hide();
		}

	function processSuppliersResult(json) {
		$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('tags').removeClass('items').removeClass('categories').removeClass("supplierItems").addClass('suppliers');
		$("#category_item_selection_wrapper .pagination").html(json.pagination);

		$("#category_item_selection").html('');

		for (var k = 0; k < json.suppliers.length; k++) {
			// var supplier_item = $("<div/>").attr('class', 'category_item supplier col-md-2 register-holder categories-holder col-sm-3 col-xs-6').data('supplier_id', json.suppliers[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.suppliers[k].name + '</p>');

			// if (json.suppliers[k].image_id) {
			// 	supplier_item.css('background-color', 'white');
			// 	supplier_item.css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.suppliers[k].image_id + '?timestamp=' + json.suppliers[k].image_timestamp + ')');
			// }

			supplier_item = '<li data-supplier_id="'+json.suppliers[k].id+'" class=" col-1 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.suppliers[k].image_id + '?timestamp=' + json.suppliers[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.suppliers[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


			$("#category_item_selection").append(supplier_item);
		}
		$('#grid-loader').hide();
	}
  
	function processCategoriesAndItemsResult(json) {

console.log("ss" , json);
$("#category_item_selection").html('');
$("#category_item_selection_wrapper_new").html('');

var	back_to_categories_button = '<li id="back_to_categories" class=" col-1 nav-item mb-3 me-3 pr-0 pl-0" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

$("#category_item_selection").append(back_to_categories_button);

for (var k = 0; k < json.categories_and_items.length; k++) {
	if (json.categories_and_items[k].type == 'category') {
		// var category_item = $("<div/>").attr('class', 'category_item category col-md-2 register-holder categories-holder col-sm-3 col-xs-6').css('background-color', json.categories_and_items[k].color).css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.categories_and_items[k].image_id + '?timestamp=' + json.categories_and_items[k].image_timestamp + ')').data('category_id', json.categories_and_items[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.categories_and_items[k].name + '</p>');

		var category_item = '<li data-category_id="'+json.categories_and_items[k].id+'" class=" col-1 category_item category nav-item mb-3 me-3  pr-0 pl-0" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4 " alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.categories_and_items[k].image_id + '?timestamp=' + json.categories_and_items[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-8 lh-1"><p>' + json.categories_and_items[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


		$("#category_item_selection").append(category_item);
	} else if (json.categories_and_items[k].type == 'item') {
		var image_src = json.categories_and_items[k].image_src;
		var has_variations = json.categories_and_items[k].has_variations ? 1 : 0;

		var prod_image = "";
		var image_class = "no-image";
		var item_parent_class = "";
		if (image_src != '') {
			var item_parent_class = "item_parent_class";
			var prod_image = '<img class="rounded-3 mb-4 h-auto" src="' + image_src + '" alt="" />';
			var image_class = "has-image";
		}

		  var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.categories_and_items[k].id).append(prod_image + '<p>' + json.categories_and_items[k].name + '<br /> <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>');

		var item = '<li data-has-variations="'+has_variations+'" data-id="'+json.categories_and_items[k].id+'" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories_and_items[k].name + '  <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
		$("#category_item_selection").append(item);

		//htm='<div class="col-sm-2  mb-2 col-xxl-2 category_item item  register-holder ' + image_class + ' '+ item_parent_class +' " data-has-variations="'+has_variations+'"  data-id="'+json.categories_and_items[k].id+'" "><div class="card card-flush bg-white h-xl-100"><!--begin::Body--><div class="card-body text-center pb-5"><!--begin::Overlay--><div class="d-block overlay" ><!--begin::Image--><div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded mb-7" style="height: 100px;background-image:url('+image_src+')"></div><!--end::Image--><!--begin::Action--><div class="overlay-layer card-rounded bg-dark bg-opacity-25"><i class="bi  fs-2x text-white"></i></div><!--end::Action--></div><!--end::Overlay--><!--begin::Info--><span class="fw-bold text-left text-gray-800 cursor-pointer text-hover-primary fs-6 d-block">' + json.categories_and_items[k].name + '</span><div class="d-flex align-items-end flex-stack mb-1"><!--begin::Title--><div class="text-start"><span class="text-gray-400 mt-1 fw-bold fs-6">Price</span></div><!--end::Title--><!--begin::Total--><span class="text-gray-600 text-end fw-bold fs-6">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span><!--end::Total--></div><!--end::Info--></div><!--end::Body--></div><!--end::Card widget 14--></div>';
		//$("#category_item_selection").append(htm);

	}
}



$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('items').removeClass('favorite').removeClass('suppliers').removeClass("supplierItems").addClass('categoriesAndItems');
$("#category_item_selection_wrapper .pagination").html(json.pagination);

updateBreadcrumbs();
$('#grid-loader').hide();

}
  
  function processTagItemsResult(json)
  {
 	 $("#category_item_selection").html('');
     var back_to_categories_button = $("<div/>").attr('id', 'back_to_tags').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; '+<?php echo json_encode(lang('back_to_tags')); ?>+'</p>');
     $("#category_item_selection").append(back_to_categories_button);

     for(var k=0;k<json.items.length;k++)
     {
 	       var image_src = json.items[k].image_src;
      	 var has_variations = json.items[k].has_variations ? 1 : 0;
 	       var prod_image = "";
 	       var image_class = "no-image";
 	       var item_parent_class = "";
 	       if (image_src != '' ) {
 	         var item_parent_class = "item_parent_class";
 	         var prod_image = '<img src="'+image_src+'" alt="" />';
 	         var image_class = "";
 	       }
      
 	       var item = $("<div/>").attr('data-has-variations',has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  '+item_parent_class).attr('data-id', json.items[k].id).append(prod_image+'<p>'+json.items[k].name+'<br /> <span class="text-bold">'+(json.items[k].price ? '('+json.items[k].price+')' : '')+'</span></p>');
 	       $("#category_item_selection").append(item);
		 	
 	 }
	 	 
     $("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('suppliers').removeClass("supplierItems").addClass('items');
     $("#category_item_selection_wrapper .pagination").html(json.pagination);

     $('#grid-loader').hide();
  }
  
  function processFavoriteItemsResult(json)
  {
 	 $("#category_item_selection").html('');
     for(var k=0;k<json.items.length;k++)
     {
 	       var image_src = json.items[k].image_src;
      	 var has_variations = json.items[k].has_variations ? 1 : 0;
 	       var prod_image = "";
 	       var image_class = "no-image";
 	       var item_parent_class = "";
 	       if (image_src != '' ) {
 	         var item_parent_class = "item_parent_class";
 	         var prod_image = '<img src="'+image_src+'" alt="" />';
 	         var image_class = "";
 	       }
      
 	    //    var item = $("<div/>").attr('data-is_favorite','yes').attr('data-has-variations',has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  '+item_parent_class).attr('data-id', json.items[k].id).append(prod_image+'<p>'+json.items[k].name+'<br /> <span class="text-bold">'+(json.items[k].price ? '('+json.items[k].price+')' : '')+'</span></p>');

			item = '<li data-supplier_id="'+json.items[k].id+'" class=" col-1 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + image_src + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.items[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


 	       $("#category_item_selection").append(item);
		 	
 	 	 }
	 	 
     $("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('favorite');
     $("#category_item_selection_wrapper .pagination").html(json.pagination);

     $('#grid-loader').hide();
  }

  	function processSupplierItemsResult(json) {
		$("#category_item_selection").html('');
		var back_to_categories_button = $("<div/>").attr('id', 'back_to_suppliers').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('back_to_suppliers')); ?> + '</p>');
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

			var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.items[k].id).append(prod_image + '<p>' + json.items[k].name + '<br /> <span class="text-bold">' + (json.items[k].price ? '(' + json.items[k].price + ')' : '') + '</span></p>');
			$("#category_item_selection").append(item);

		}

		$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('favorite').removeClass('suppliers').removeClass('items').addClass("supplierItems");
		$("#category_item_selection_wrapper .pagination").html(json.pagination);

		$('#grid-loader').hide();
	}
  
	<?php if ($this->config->item('default_type_for_grid') == 'tags') {  ?>
		loadTags();
	<?php } else if ($this->config->item('default_type_for_grid') == 'favorites') { ?>
		loadFavoriteItems(0);
	<?php } else if ($this->config->item('default_type_for_grid') == 'suppliers') { ?>
		loadSuppliers();
	<?php } else { ?>
		loadTopCategories();
	<?php	} ?>
	});

<?php if (!$this->agent->is_mobile()) { ?>
	var last_focused_id = null;
	
	setTimeout(function(){$('#item').focus();}, 10);
<?php } ?>
</script>

<script>
//Keyboard events...only want to load once
$(document).keyup(function(event)
{
	var mycode = event.keyCode;
	
	//tab
	if (mycode == 9)
	{
		var $tabbed_to = $(event.target);
		
		if ($tabbed_to.hasClass('xeditable'))
		{
			$tabbed_to.trigger('click').editable('show');
		}
	}

});

$(document).on('mouseover', ".register-holder.item.has-image",function()
{
	$(this).find('p').css('visibility','hidden');
});

$(document).on('mouseout', ".register-holder.item.has-image",function()
{
	$(this).find('p').css('visibility','visible');
});

</script>

<?php $this->load->view("partial/footer"); ?>
