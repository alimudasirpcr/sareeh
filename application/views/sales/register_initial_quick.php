<?php $this->load->view("partial/header"); ?>
<div id="sales_page_holder"> 
	<img onclick="full_screen()" src="<?php echo base_url().'assets/css_good/media/icons/icons8-full-screen.gif'; ?>" > 


	

	<div id="register_container" class="sales clearfix">
		<?php $this->load->view("sales/register"); ?>
	</div>
</div>



<script type="text/javascript">
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
			name: <?php echo json_encode(lang('common_all')); ?>
		}];

		function updateBreadcrumbs(item_name) {
			var breadcrumbs = '';
			for (var k = 0; k < categories_stack.length; k++) {
				var category_name = categories_stack[k].name;
				var category_id = categories_stack[k].category_id;

				breadcrumbs += (k != 0 ? '  ' : '') + '<a href="javascript:void(0);"class="category_breadcrumb_item btn btn-primary" data-category_id = "' + category_id + '">' + category_name + " 	&gt; </a>";
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
			$.get('<?php echo site_url("sales/categories_and_items"); ?>/' + current_category_id + '/' + offset, function(json) {
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
			if(category_count > 0 ){
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
		

		$('#category_item_selection_wrapper').on('click', '#by_category', function(event) {
			current_category_id = null;
			current_tag_id = null;
			$("#grid_breadcrumbs").html('');
			$('.btn-grid').removeClass('active');
			$(this).addClass('active');
			categories_stack = [{
				category_id: 0,
				name: <?php echo json_encode(lang('common_all')); ?>
			}];
			loadTopCategories();
		});

		$('#category_item_selection_wrapper').on('click', '#by_tag', function(event) {
			current_category_id = null;
			current_tag_id = null;
			$('.btn-grid').removeClass('active');
			$(this).addClass('active');
			$("#grid_breadcrumbs").html('');
			loadTags();
		});

		$('#category_item_selection_wrapper').on('click', '#by_favorite', function(event) {
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


		$('#category_item_selection_wrapper').on('click', '.category_item.item', function(event) {
			$('#grid-loader').show();
			event.preventDefault();

			var $that = $(this);
			if ($(this).data('has-variations')) {
				$.getJSON('<?php echo site_url("sales/item_variations"); ?>/' + $(this).data('id'), function(json) {
					$("#category_item_selection").html('');
					$("#category_item_selection_wrapper .pagination").html('');

					if (current_category_id) {
						//var back_button = $("<div/>").attr('id', 'back_to_category').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');

						var	back_button = '<li id="back_to_category" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					} else if(current_supplier_id) {
						//var back_button = $("<div/>").attr('id', 'back_to_supplier').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');

						var	back_button = '<li id="back_to_supplier" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


					} else if ($that.data('is_favorite')) {
						//var back_button = $("<div/>").attr('id', 'back_to_favorite').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');

						var	back_button = '<li id="back_to_favorite" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

					} else {
					//	var back_button = $("<div/>").attr('id', 'back_to_tag').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');
						var	back_button = '<li id="back_to_tag" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					}

					

					$("#category_item_selection").append(back_button);

					for (var k = 0; k < json.length; k++) {
						var image_src = json[k].image_src;
						var prod_image = "";
						var image_class = "no-image";
						var item_parent_class = "";
						if (image_src != '') {
							var item_parent_class = "item_parent_class";
							var prod_image = '<img src="' + image_src + '" alt="" />';
							var image_class = "";
						}else{
							var item_parent_class = "item_parent_class";
							var prod_image = '<img src="' + SITE_URL + '/assets/css_good/media/icons/varient.png" alt="" />';
							var image_class = "";
						}
                          /// dynamic attributes for item:varients

					//	var item = $("<div/>").attr('data-has-variations', 0).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json[k].id).append(prod_image + '<p>' + json[k].name + '<br /> <span class="text-bold">' + (json[k].price ? '(' + json[k].price + ')' : '') + '</span></p>');
						

						var item = '<li data-has-variations="0" data-id="'+json[k].id+'" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' +json[k].name + ' <span class="text-bold">' + (json[k].price ? '(' + decodeHtml(json[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
						$("#category_item_selection").append(item);
						if (current_category_id) {
							updateBreadcrumbs($that.text());
						}
					}

					$('#grid-loader').hide();

				});
			} else {

			
				$.post('<?php echo site_url("sales/add"); ?>', {
					item: $(this).data('id') + "|FORCE_ITEM_ID|"
				}, function(response) {
					<?php
					if (!$this->config->item('disable_sale_notifications')) {
						echo "show_feedback('success', " . json_encode(lang('common_successful_adding')) . ", " . json_encode(lang('common_success')) . ");";
					}

					?>
					$('#grid-loader').hide();
					$("#sales_section").html(response);
					$('.show-grid').addClass('hidden');
					$('.hide-grid').removeClass('hidden');
				});
			}
		});


		$('#category_item_selection_wrapper_new').on('click', '.category_item.item', function(event) {
			$('#grid-loader').show();
			event.preventDefault();

			var $that = $(this);
			if ($(this).data('has-variations')) {
				$.getJSON('<?php echo site_url("sales/item_variations"); ?>/' + $(this).data('id'), function(json) {
					$("#category_item_selection").html('');
					$("#category_item_selection_wrapper .pagination").html('');

					if (current_category_id) {
						//var back_button = $("<div/>").attr('id', 'back_to_category').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');

						var	back_button = '<li id="back_to_category" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					} else if(current_supplier_id) {
						//var back_button = $("<div/>").attr('id', 'back_to_supplier').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');

						var	back_button = '<li id="back_to_supplier" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


					} else if ($that.data('is_favorite')) {
						//var back_button = $("<div/>").attr('id', 'back_to_favorite').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');

						var	back_button = '<li id="back_to_favorite" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

					} else {
					//	var back_button = $("<div/>").attr('id', 'back_to_tag').attr('class', 'category_item register-holder no-image back-to-tags col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back')); ?> + '</p>');
						var	back_button = '<li id="back_to_tag" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					}

					

					$("#category_item_selection").append(back_button);

					for (var k = 0; k < json.length; k++) {
						var image_src = json[k].image_src;
						var prod_image = "";
						var image_class = "no-image";
						var item_parent_class = "";
						if (image_src != '') {
							var item_parent_class = "item_parent_class";
							var prod_image = '<img src="' + image_src + '" alt="" />';
							var image_class = "";
						}else{
							var item_parent_class = "item_parent_class";
							var prod_image = '<img src="' + SITE_URL + '/assets/css_good/media/icons/varient.png" alt="" />';
							var image_class = "";
						}
                          /// dynamic attributes for item:varients

					//	var item = $("<div/>").attr('data-has-variations', 0).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json[k].id).append(prod_image + '<p>' + json[k].name + '<br /> <span class="text-bold">' + (json[k].price ? '(' + json[k].price + ')' : '') + '</span></p>');
						

						var item = '<li data-has-variations="0" data-id="'+json[k].id+'" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' +json[k].name + ' <span class="text-bold">' + (json[k].price ? '(' + decodeHtml(json[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
						$("#category_item_selection").append(item);
						if (current_category_id) {
							updateBreadcrumbs($that.text());
						}
					}

					$('#grid-loader').hide();

				});
			} else {
				
				$.post('<?php echo site_url("sales/add"); ?>', {
					item: $(this).data('id') + "|FORCE_ITEM_ID|"
				}, function(response) {
					<?php
					if (!$this->config->item('disable_sale_notifications')) {
						echo "show_feedback('success', " . json_encode(lang('common_successful_adding')) . ", " . json_encode(lang('common_success')) . ");";
					}

					?>
					$('#grid-loader').hide();
					$("#sales_section").html(response);
					$('.show-grid').addClass('hidden');
					$('.hide-grid').removeClass('hidden');
				});
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
			$("#category_item_selection_wrapper .pagination").removeClass('categoriesAndItems').removeClass('tags').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('categories');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			$("#category_item_selection").html('');

			for (var k = 0; k < json.categories.length; k++) {
				var category_item = $("<div/>").attr('class', 'category_item category col-md-2 register-holder categories-holder col-sm-3 col-xs-6').css('background-color', json.categories[k].color).data('category_id', json.categories[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.categories[k].name + '</p>');

				if (json.categories[k].image_id) {
					category_item.css('background-color', 'white');
					category_item.css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.categories[k].image_id + '?timestamp=' + json.categories[k].image_timestamp + ')');
				}

			var categ_badge ='';
			if(json.categories[k].categories_count > 0){
				categ_badge ='<span class="symbol-badge badge badge-circle bg-danger top-10 start-15">'+json.categories[k].categories_count+'</span>';
			}
			var item_badge ='';
			if(json.categories[k].items_count>0){
				item_badge ='<span class="symbol-badge badge badge-circle bg-success top-10 start-80">'+json.categories[k].items_count+'</span>';
			}

			category_item = '<li data-category_count="'+json.categories[k].categories_count+'" data-category_id="'+json.categories[k].id+'" class=" col-2  category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-125px py-4 active symbol" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"> '+item_badge+' '+categ_badge+' <div class="nav-icon "> <img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.categories[k].image_id + '?timestamp=' + json.categories[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


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

			supplier_item = '<li data-supplier_id="'+json.suppliers[k].id+'" class=" col-2 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-125px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.suppliers[k].image_id + '?timestamp=' + json.suppliers[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.suppliers[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


			$("#category_item_selection").append(supplier_item);
		}
		$('#grid-loader').hide();
	}

		function processCategoriesAndItemsResult(json) {

			console.log("ss" , json);
			
			$("#category_item_selection_wrapper_new").html('');

			if(json.categories_count >0){
				$("#category_item_selection").html('');
				var	back_to_categories_button = '<li id="back_to_categories" class=" col-1 nav-item mb-3 me-3 pr-0 pl-0" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';

			$("#category_item_selection").append(back_to_categories_button);
			}
		

			for (var k = 0; k < json.categories_and_items.length; k++) {
				var categ_badge ='';
			if(json.categories_and_items[k].categories_count > 0){
				categ_badge ='<span class="symbol-badge badge badge-circle bg-danger top-10 start-15">'+json.categories_and_items[k].categories_count+'</span>';
			}
			var item_badge ='';
			if(json.categories_and_items[k].items_count>0){
				item_badge ='<span class="symbol-badge badge badge-circle bg-success top-10 start-80">'+json.categories_and_items[k].items_count+'</span>';
			}

				if (json.categories_and_items[k].type == 'category') {
					// var category_item = $("<div/>").attr('class', 'category_item category col-md-2 register-holder categories-holder col-sm-3 col-xs-6').css('background-color', json.categories_and_items[k].color).css('background-image', 'url(' + SITE_URL + '/app_files/view_cacheable/' + json.categories_and_items[k].image_id + '?timestamp=' + json.categories_and_items[k].image_timestamp + ')').data('category_id', json.categories_and_items[k].id).append('<p> <i class="ion-ios-folder-outline"></i> ' + json.categories_and_items[k].name + '</p>');

					var category_item = '<li data-category_id="'+json.categories_and_items[k].id+'" class=" col-2 category_item category nav-item mb-3 me-3  pr-0 pl-0" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-125px  px-1 py-4 active symbol" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab">'+categ_badge+''+item_badge+'<div class="nav-icon"><img class="rounded-3 mb-4 " alt="" src="' + SITE_URL + '/app_files/view_cacheable/' + json.categories_and_items[k].image_id + '?timestamp=' + json.categories_and_items[k].image_timestamp + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-8 lh-1"><p>' + json.categories_and_items[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


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

					//  var item = $("<div/>").attr('data-has-variations', has_variations).attr('class', 'category_item item col-md-2 register-holder ' + image_class + ' col-sm-3 col-xs-6  ' + item_parent_class).attr('data-id', json.categories_and_items[k].id).append(prod_image + '<p>' + json.categories_and_items[k].name + '<br /> <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>');

					//var item = '<li data-has-variations="'+has_variations+'" data-id="'+json.categories_and_items[k].id+'" class=" col-1 category_item item   ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.categories_and_items[k].name + '  <span class="text-bold">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span></p>  </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';
					//$("#category_item_selection").append(item);

					htm='<div class="col-sm-2  mb-2 col-xxl-2 category_item item  register-holder ' + image_class + ' '+ item_parent_class +' " data-has-variations="'+has_variations+'"  data-id="'+json.categories_and_items[k].id+'" "><div class="card card-flush bg-white h-xl-100"><!--begin::Body--><div class="card-body text-center pb-5"><!--begin::Overlay--><div class="d-block overlay" ><!--begin::Image--><div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded mb-7" style="height: 100px;background-image:url('+image_src+')"></div><!--end::Image--><!--begin::Action--><div class="overlay-layer card-rounded bg-dark bg-opacity-25"><i class="bi  fs-2x text-white"></i></div><!--end::Action--></div><!--end::Overlay--><!--begin::Info--><span class="fw-bold text-left text-gray-800 cursor-pointer text-hover-primary fs-6 d-block">' + json.categories_and_items[k].name + '</span><div class="d-flex align-items-end flex-stack mb-1"><!--begin::Title--><div class="text-start"><span class="text-gray-400 mt-1 fw-bold fs-6">Price</span></div><!--end::Title--><!--begin::Total--><span class="text-gray-600 text-end fw-bold fs-6">' + (json.categories_and_items[k].price ? '(' + decodeHtml(json.categories_and_items[k].price) + ')' : '') + '</span><!--end::Total--></div><!--end::Info--></div><!--end::Body--></div><!--end::Card widget 14--></div>';
					$("#category_item_selection_wrapper_new").append(htm);

				}
			}



			$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('items').removeClass('favorite').removeClass('suppliers').removeClass("supplierItems").addClass('categoriesAndItems');
			$("#category_item_selection_wrapper .pagination").html(json.pagination);

			updateBreadcrumbs();
			$('#grid-loader').hide();

		}

		function processTagItemsResult(json) {
			$("#category_item_selection").html('');
			//var back_to_categories_button = $("<div/>").attr('id', 'back_to_tags').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back_to_tags')); ?> + '</p>');

			var	back_to_categories_button = '<li id="back_to_tags" class=" col-2 nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-100px py-6 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + SITE_URL + '/assets/css_good/media/icons/icons8-back-50.png" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1" style="white-space:nowrap"></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


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

				var item = '<li data-has-variations="'+has_variations+'" data-id="'+json.items[k].id+'" class=" col-1 category_item item  ' + image_class + '  ' + item_parent_class + '  nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-100px  px-1 py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"> '+ prod_image +'</div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.items[k].name + ' <span class="text-bold">' + (json.items[k].price ? '(' + decodeHtml(json.items[k].price) + ')' : '') + '</span></p>   </span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


				$("#category_item_selection").append(item);

			}

			$("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('favorite').removeClass('suppliers').removeClass("supplierItems").addClass('items');
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

			item = '<li data-supplier_id="'+json.items[k].id+'" class=" col-2 category_item category register-holder categories-holder nav-item mb-3 me-3 me-lg-6" role="presentation"><a class="  nav-link d-flex justify-content-between flex-column flex-center overflow-hidden  h-125px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="true" role="tab"><div class="nav-icon"><img class="rounded-3 mb-4" alt="" src="' + image_src + '" class=""></div><span class="nav-text text-gray-700 fw-bold fs-6 lh-1"><p>' + json.items[k].name + '</p></span><span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span></a></li>';


 	       $("#category_item_selection").append(item);
		 	
 	 	 }
	 	 
     $("#category_item_selection_wrapper .pagination").removeClass('categories').removeClass('tags').removeClass('categoriesAndItems').removeClass('items').removeClass('suppliers').removeClass("supplierItems").addClass('favorite');
     $("#category_item_selection_wrapper .pagination").html(json.pagination);

     $('#grid-loader').hide();
  }

		function processSupplierItemsResult(json) {
			$("#category_item_selection").html('');
			var back_to_categories_button = $("<div/>").attr('id', 'back_to_suppliers').attr('class', 'category_item register-holder no-image back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; ' + <?php echo json_encode(lang('common_back_to_suppliers')); ?> + '</p>');
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
	});

	var last_focused_id = null;

	setTimeout(function() {
		$('#item').focus();
	}, 10);
</script>

<script type="text/javascript">
	//Keyboard events...only want to load once
	$(document).keyup(function(event) {
		var mycode = event.keyCode;

		//tab
		if (mycode == 9) {
			var $tabbed_to = $(event.target);

			if ($tabbed_to.hasClass('xeditable')) {
				$tabbed_to.trigger('click').editable('show');
			}
		}

	});

	$(document).keydown(function(event) {
		var mycode = event.keyCode;

		//F2
		if (mycode == 113) {
			$("#item").focus();
			return;
		}

		//F4
		if (mycode == 115) {
			event.preventDefault();
			$("#finish_sale_alternate_button").click();
			$("#finish_sale_button").click();
			return;
		}

		//F7
		if (mycode == 118) {
			event.preventDefault();
			$("#amount_tendered").focus();
			$("#amount_tendered").select();
			return;
		}

		//F8
		if (mycode == 119) {
			window.location = '<?php echo site_url('sales/suspended');?>';
			return;
		}

		//ESC
		if (mycode == 27) {
			event.preventDefault();
			$("#cancel_sale_button").click();
			return;
		}


	});
</script>

<script type="text/javascript">
var is_full_screen = false;
	function full_screen(){
		if(is_full_screen){
			$("#kt_app_header").show();
			$('#kt_app_sidebar').show();
			$('#kt_app_wrapper').removeAttr('style');
			is_full_screen = false;
		}else{
			$("#kt_app_header").hide();
			$('#kt_app_sidebar').hide();
			$('#kt_app_wrapper').attr('style' , 'margin-left:0px');
			is_full_screen = true;
		}
		
	}
	<?php
	if (isset($cash_in_register) && $cash_in_register && $this->config->item('cash_alert_low') !== NULL && $this->config->item('cash_alert_low') !== '' && $cash_in_register < $this->config->item('cash_alert_low')) {
		echo "show_feedback('warning', " . json_encode(lang('sales_cash_low') . ' (' . to_currency($this->config->item('cash_alert_low')) . ')') . ", " . json_encode(lang('common_warning')) . ",{timeOut: 10000});";
	}

	if (isset($cash_in_register) && $cash_in_register && $this->config->item('cash_alert_high') !== NULL && $this->config->item('cash_alert_high') !== '' && $cash_in_register > $this->config->item('cash_alert_high')) {
		echo "show_feedback('warning', " . json_encode(lang('sales_cash_high') . ' (' . to_currency($this->config->item('cash_alert_high')) . ')') . ", " . json_encode(lang('common_warning')) . ",{timeOut: 10000});";
	}

	if ($this->session->flashdata('error_if_total_is_zero')) {
		echo "show_feedback('warning', " . json_encode($this->session->flashdata('error_if_total_is_zero')) . ", " . json_encode(lang('common_warning')) . ",  {timeOut: 10000}  );";
	}

	?>
	
	<?php 
	if ($this->Location->get_info_for_key('enable_credit_card_processing') && $this->Location->get_info_for_key('blockchyp_api_key')) 
	{
	?>
		function update_blockchyp_terminal_status()
		{
			var register_id = <?php echo json_encode($this->Employee->get_logged_in_employee_current_register_id()); ?>;
		
			$.getJSON(SITE_URL+'/sales/get_blockchyp_terminal_status?register_id='+encodeURIComponent(register_id), function(terminal_status)
			{
				if(terminal_status.online)
				{
					$("#terminal_status_offline").hide();
				}
				else
				{
					$("#terminal_status_offline").show();
				}
			});
	
		}	

		update_blockchyp_terminal_status();
	<?php
	}	
	?>
</script>

<?php $this->load->view("partial/footer"); ?>