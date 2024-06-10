<script>
var $border_type = '3px dotted #4f55da';
function back_to_labels(){
						$('.menu-link[data-id="lables"]').trigger('click');
					}
$(document).ready(function() {
    $('#search-input').on('keyup', function() {
        var searchText = $(this).val().toLowerCase();
        if (searchText.length >= 3) {
            $('#items-drag .align-items-center .kt-dark').each(function() {
                var text = $(this).text().toLowerCase();
                if (searchText === "" || text.includes(searchText)) {
                    $(this).parent().removeClass('d-none').addClass('d-flex');
                } else {
                    $(this).parent().removeClass('d-flex').addClass('d-none');
                }
            });
        } else {
            $('#items-drag .align-items-center').each(function() {
                $(this).removeClass('d-none').addClass('d-flex');
            });
        }
    });

    // Show all items by default if the input is empty
    $('#search-input').trigger('keyup');
});



function switch_pages(value) {

    if (value == 1) {
        $('.page-two').show();
        $('.page-three').show();
    } else {
        $('.page-two').hide();
        $('.page-three').hide();
    }
}


$(document).ready(function() {

    $("[name='number_of_page']").change(function() {
        var value = $(this).is(":checked") ? $(this).val() : "";
        switch_pages(value);
    });
    var value = $("[name='number_of_page']").is(":checked") ? $("[name='number_of_page']").val() : "";
    switch_pages(value);
});


function insert_img(img, id, section) {
    $img =
        '<div class="resize  ui-draggable ui-draggable-handle ui-resizable" style="position: absolute; width:90.5px;height:auto; text-wrap:nowrap; left:1px; top:1px; " data-left="1px" data-top="1px" data-current_width="90.5" data-current_height="24" id="custom_img_' +
        section + '_' +
        id +
        '"> <span class="position-absolute top-0 start-50 translate-middle  remove_img"><svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">  <path fill="currentColor"  d="M8 5a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3h4.25a.75.75 0 1 1 0 1.5H19V18a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V6.5H3.75a.75.75 0 0 1 0-1.5H8zM6.5 6.5V18c0 .83.67 1.5 1.5 1.5h8c.83 0 1.5-.67 1.5-1.5V6.5h-11zm3-1.5h5c0-.83-.67-1.5-1.5-1.5h-2c-.83 0-1.5.67-1.5 1.5zm-.25 4h1.5v8h-1.5V9zm4 0h1.5v8h-1.5V9z">  </path> </svg></span><img src="' +
        img +
        '" alt=""><span class="drag-handle ui-draggable-handle" style="display: flex;"><span class="svg-icon svg-icon-muted svg-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.22 6.573a.75.75 0 1 0 1.06-1.06l-2.145-2.146a1.25 1.25 0 0 0-1.77 0L9.22 5.513a.75.75 0 0 0 1.06 1.06l1.22-1.22v5.899H5.602l1.22-1.22a.75.75 0 0 0-1.06-1.06l-2.147 2.145a1.251 1.251 0 0 0 0 1.77l2.146 2.145a.75.75 0 1 0 1.06-1.06l-1.219-1.22H11.5v5.897l-1.22-1.22a.75.75 0 1 0-1.06 1.061l2.145 2.146a1.248 1.248 0 0 0 1.77 0l2.145-2.146a.75.75 0 1 0-1.06-1.06L13 18.65v-5.898h5.898l-1.22 1.22a.75.75 0 0 0 1.06 1.06l2.147-2.146a1.252 1.252 0 0 0 0-1.77l-2.146-2.145a.75.75 0 0 0-1.06 1.06l1.219 1.22H13V5.354l1.22 1.22Z" fill="currentColor"></path></svg></span></span>  <div class="ui-resizable-handle ui-resizable-e handle-right"id="handle-right"><i class="fa fa-ellipsis-v" style="position:absolute; top:50%"></i></div></div>';
    $('.elementWithBackground').find('.page_' + section).prepend($img);
    $(".resize").draggable({
        revert: "invalid",
        containment: "document", // Limit movement within the specified boundary.
        start: function(event, ui) {
            $(this).draggable('option', 'revert', 'invalid');
            $(this).css({
                'border': '3px dotted black'
            });
        },
        stop: function(event, ui) {
            $(this).css({
                'border': 'none'
            });
        }
    }).resizable({
        stop: function(event, ui) {
            $(this).attr('data-current_width', ui.size.width);
            $(this).attr('data-current_height', ui.size.height);
        }
    });

    $('.remove_img').on('click', function() {
        $(this).parent().remove();
    })
}
// Event handler for button clicks
function set_bg(backgroundUrl, id) {
    $(".elementWithBackground  ").css("background-image", "url(" + backgroundUrl + ")");
    $('#background_image_id').val(id);
}

function rm_bg() {
    $(".elementWithBackground  ").css("background-image", "none");
    $('#background_image_id').val('--');
}

function delete_img(id) {
    $('#img_cont_' + id).remove();

    $.ajax({
        type: "POST",
        url: "<?= site_url('home/delete_gallery_image')?>",
        data: {
            id: id
        },
        success: function(data) {

        }
    });
}
$(document).ready(function() {

    $('[data-toggle="popover"]').popover(); // Initialize all popovers

    // Stop propagation for the popover trigger
    $('[data-toggle="popover"]').on('click', function(e) {

		console.log("checking class");
		if($(this).hasClass('edit_text')  && $(this).hasClass('dialer')){

			console.log("yes has clas");
			$id = $(this).data('id');
		
		// code for inc decrease number of rows in payments
		var closestdraggable = $(this).closest('.draggable');
		var rowCount = closestdraggable.find('.exect_value_'+$id+' .row').length;
		$('.kt_dialer_example_'+$id+'input').val(rowCount);

		function duplicateDivs() {
			
                var numberOfDivs = parseInt($('.kt_dialer_example_'+$id+'input').val());
                var $container = $('.draggable .exect_value_'+$id+'');
				var $divToDuplicate = $('.draggable .exect_value_'+$id+' .row').first();
                $container.empty();
                for (var i = 0; i < numberOfDivs; i++) {
                    $container.append($divToDuplicate.clone());
                }
            }


		var dialerElement = document.querySelector(".kt_dialer_example_"+$id+"");
		var dialerObject = new KTDialer(dialerElement, {
			min: 1,
			max: 20,
			step: 1,
			prefix: "",
			decimals: 0
		});

		dialerObject.on('kt.dialer.increased', function(){
			duplicateDivs();
		});
		dialerObject.on('kt.dialer.decreased', function(){
			duplicateDivs();
		});
	
		// end code for inc decrease number of rows in payments

	}

		
        e.stopPropagation();

    });

    // Close popover on clicking outside
    $(document).on('click', function(e) {
		
		
        if (!$(e.target).is(':checkbox') && !$(e.target).parent().hasClass('custom_label_body') && !$(e.target).parent().hasClass('menu-item') ) {
			
            $('[data-toggle="popover"]').popover('hide');
        }
    });

    // Close popover on clicking inside the popover body
    $('.popover').on('click', '.popover-body', function() {

        if (!$(e.target).is(':checkbox') && !$(this).hasClass('custom_label_body')) {
		
            $('[data-toggle="popover"]').popover('hide');
        }
    });




});
Dropzone.autoDiscover = false;
Dropzone.options.dropzoneUpload = {
    url: "<?php echo site_url('home/gallery_upload'); ?>",
    autoProcessQueue: true,
    acceptedFiles: "image/*",
    uploadMultiple: true,
    parallelUploads: 100,
    maxFiles: 100,
    addRemoveLinks: true,
    dictRemoveFile: "Remove",
    init: function() {
        myDropzone = this;
        this.on("success", function(file, responseText) {
            $('.dz-image-preview').remove();
            $('#gallery_container').prepend(responseText);
            // window.location.reload();

            $('[data-toggle="popover"]').popover(); // Initialize all popovers

            // Stop propagation for the popover trigger
            $('[data-toggle="popover"]').on('click', function(e) {



                e.stopPropagation();

            });

            // Close popover on clicking outside
            $(document).on('click', function(e) {

                if (!$(e.target).is(':checkbox') && !$(e.target).parent().hasClass(
                        'custom_label_body')) {
                    $('[data-toggle="popover"]').popover('hide');
                }
            });

            // Close popover on clicking inside the popover body
            $('.popover').on('click', '.popover-body', function() {

                if (!$(e.target).is(':checkbox') && !$(this).hasClass(
                        'custom_label_body')) {
                    $('[data-toggle="popover"]').popover('hide');
                }
            });
        });
    }
};
$('#dropzoneUpload').dropzone();

// myDropzone.on('sending', function(file, xhr, formData){
// 	formData.append('work_order_id', work_order_id);
// });
function add_table_border(type, f, is_click = true) {
    // console.log("type",type);
    var isActive = $(f).attr('data-is_active');
    if (!is_click) {
        isActive = (isActive == 'true') ? 'false' : 'true';
    }

    if (isActive == 'false') {
        switch (type) {
            case 'all':
                // console.log("all",isActive);
                // Add borders to each cell
                $('.reciept_table_header, .reciept_table_header .w-25, .invoice-table-content').css({
                    'border': '1px solid black'
                });
                break;
            case 'horizontal':

                // Add horizontal lines
                $('.receipt-row-item-holder .w-20').css({
                    'border-bottom': '1px solid black'
                });
                break;
            case 'vertical':
                // Add vertical lines
                $('.receipt-row-item-holder .w-20').css({
                    'border-left': '1px solid black'
                });
                break;
            default:
                // Add header background
                $('.reciept_table_header').css({
                    'background-color': 'gray',
                    'border': '1px solid black'
                });
                break;
        }
    } else {
        switch (type) {
            case 'all':
                // Remove borders from each cell
                $('.reciept_table_header, .reciept_table_header .w-25, .invoice-table-content').css({
                    'border': 'none'
                });
                break;
            case 'horizontal':
                // Remove horizontal lines
                $('.receipt-row-item-holder .w-20').css({
                    'border-bottom': 'none'
                });
                break;
            case 'vertical':
                // Remove vertical lines
                $('.receipt-row-item-holder .w-20').css({
                    'border-left': 'none'
                });
                break;
            default:
                // Remove header background
                $('.reciept_table_header').css({
                    'background-color': '',
                    'border': 'none'
                });
                break;
        }
    }

    // Toggle the is_active data attribute
    if (is_click) {
        $(f).attr('data-is_active', (isActive == 'false') ? 'true' : 'false');
    }

}
$(document).ready(function() {

    add_table_border('horizontal', $('.tbl_horzontal_borders'), false);
    add_table_border('vertical', $('.tbl_vertical_borders'), false);
    add_table_border('header', $('.tbl_header_bg'), false);
    add_table_border('all', $('.tbl_all_borders'), false);
});

$(document).ready(function() {
    $(window).scroll(function() {
        $('.popover').hide(); // Hide the popover when scrolling
    });

    var $checkbox_element_image = $('.checkbox_element_image');
    var $table_image_position = $('#table_image_position');





    function update_image_position() {

        if ($('#checkbox_item_img').is(':checked')) {
            if ($(this).val() == 'left-side-of-item') {

                $('.receipt-row-item-holder').find('.w-25').removeClass('w-25').addClass('w-20');


                $('.bottom_image').hide();
                $('.img-column').show();
                $('.side_image').show();
            } else {

                $('.receipt-row-item-holder').find('.w-20').removeClass('w-20').addClass('w-25');
                $('.side_image').hide();
                $('.img-column').hide();
                $('.bottom_image').show();
            }
            $checkbox_element_image.attr('class', '');
            $checkbox_element_image.attr('class', 'd-flex checkbox_element_image ' + $(this).val() + ' ');
        } else {
            $('.side_image').hide();
            $('.img-column').hide();
            $('.bottom_image').hide();
        }


    }

    $table_image_position.change(update_image_position);
    $table_image_position.val('<?= $receipt['table_image_position'] ?>').trigger('change');



    var $table_image = $('.table_image');
    var $table_image_size = $('#table_image_size');

    function applychangeimagesize() {

        $table_image.css({
            'width': $table_image_size.val() + 'px',
        });
    }
    $table_image.click(function() {
        // // console.log("img_based_config");
        $('.text_based_config').hide();
        $('.img_based_config').show();
        $('.table_based_config').hide();



        $currentimg = $(this);
        $table_image_size.focus();
        $table_image_size.val($currentimg.css('width').replace('px', ''));
    });
    $table_image_size.change(applychangeimagesize);

    $table_image_size.val('<?= $receipt['table_image_size'] ?>').trigger('change');

    var $fontSizeSelector = $('#font-size-selector');
    var $fontWeightSelector = $('#font-weight-selector');
    var $colorpicker = $('#color');
    var $fontSizeSelectorTable = $('#font-size-selector-table');
    var $currentDiv = null;

    // Function to apply font size and weight to the selected div
    function applyFontStyles() {

        if ($currentDiv) {
            $currentDiv.css({
                'font-size': $fontSizeSelector.val(),
                'font-weight': $fontWeightSelector.val(),
                'color': $colorpicker.val()
            });
            $currentDiv.attr({
                'data-current_color': $colorpicker.val(),
                'data-current_size': $fontSizeSelector.val(),
                'data-current_weight': $fontWeightSelector.val()
            });
        }
    }


    function applyFontStylesTable() {
        if ($currentDiv) {
            $currentDiv.find('.invoice-desc, .invoice-content-heading , .invoice-content, .invoice-head').css({
                'font-size': $fontSizeSelectorTable.val(),
            });
            $currentDiv.attr({
                'data-current_size': $fontSizeSelectorTable.val(),
            });
        }
    }



    $('.table-data-column, thead').click(function() {
        // console.log('invoice-table-content');
        $('.text_based_config').hide();
        $('.img_based_config').hide();
        $('.table_based_config').show();
    })


    // Update the dropdowns when a div is clicked

    function update_border() {
        $('.resize').css({
            'border': 'none'
        });
        $('div[id^="header-"], div[id^="footer-"], div[id^="body-"]').css({
            'border': 'none'
        });
    }

    $('.resize').click(function() {
        update_border();
        $(this).css({
            'border': $border_type
        });
    });

    $('div[id^="header-"], div[id^="footer-"], div[id^="body-"]').click(function() {

        update_border();
        $(this).css({
            'border': $border_type
        });
        $('.menu-link[data-id="lables"]').trigger('click');
        $currentDiv = $(this); // Set the current div
        if ($currentDiv.attr('id') != 'body-items_list') {

            $('.text_based_config').show();
            $('.img_based_config').hide();
            $('.table_based_config').hide();
        } else {
            console.log($currentDiv.css('font-size'));
            $fontSizeSelectorTable.val($currentDiv.css('font-size'));
        }

        $('.remove-btn').unbind('click').click(function() {

            hide_show_label($currentDiv.attr('id'));
        });

        $fontSizeSelector.val($currentDiv.css('font-size')); // Update font size dropdown
        $fontWeightSelector.val($currentDiv.css('font-weight')); // Update font weight dropdown
        $colorpicker.val($currentDiv.css('color')); // Update font weight dropdown
        $('#color').colorpicker('setValue', $currentDiv.css('color'));

    });

    // Update the div's styles when dropdowns change
    $fontSizeSelector.change(applyFontStyles);
    $fontSizeSelectorTable.change(applyFontStylesTable);
    $fontWeightSelector.change(applyFontStyles);
    $colorpicker.change(applyFontStyles);
    $('#color').colorpicker();
    $('#color').on('changeColor', function(event) {
        applyFontStyles();
    });
});

function hide_show_all_headers(mainCheckbox) {
    // Determine if the main checkbox is checked or not
    var isChecked = $(mainCheckbox).is(':checked');

    // Find all checkboxes with the class "heading_checkbox" and set their checked state
    // $('.heading_checkbox').prop('checked', isChecked).trigger('change');
    if (isChecked) {
        $('.reciept_table_header').hide();
    } else {
        $('.reciept_table_header').show();
    }
}



function show_hide_item_detail(id) {

    // Get the checkbox by ID
    var checkbox = $("#" + id);

    // Get the elements with the matching data-id
    var elementsToToggle = $("[data-id='" + id + "']");

    // Check the checkbox state to show or hide elements
    if (checkbox.is(":checked")) {

        elementsToToggle.show();

        if (id == 'checkbox_item_img') {
            console.log('i am here');

            if ($('#table_image_position').val() == 'left-side-of-item') {

                $('.receipt-row-item-holder').find('.w-25').removeClass('w-25').addClass('w-20');
                $("[data-id='checkbox_element_image']").hide();

                $('.bottom_image').hide();
                $('.img-column').show();
                $('.side_image').show();
            } else {

                $('.receipt-row-item-holder').find('.w-20').removeClass('w-20').addClass('w-25');
                $('.side_image').hide();
                $('.img-column').hide();
                $('.bottom_image').show();
                $("[data-id='checkbox_element_image']").show();
            }
        }
    } else {
        // // console.log("unchecked", id);
        elementsToToggle.hide();
    }
}

function add_rect(type, section) {
    count = $('.transparent-rectangle').length + 1;

    while ($('#rectangle_' + count).length > 0) {
        count++; // If the ID exists, increment the count and check again
    }
    $svg = '';
    $type = type + '-border';
    if (type == 'triangle-up') {
        $svg = '<div class="' + $type +
            '"><svg viewBox="0 0 100 100" preserveAspectRatio="none" style="width: 100%; height: 100%; display: block;"><polygon points="50,0 0,100 100,100" fill="transparent" stroke="#646e84" stroke-width="2" /></svg></div>';
        $type = '';
    } else if (type == 'triangle-down') {
        $svg = '<div class="' + $type +
            '"><svg viewBox="0 0 100 100" preserveAspectRatio="none" style="width: 100%; height: 100%; display: block;"><polygon points="50,100 0,0 100,0" fill="transparent" stroke="#646e84" stroke-width="2" /></svg></div>';
        $type = '';
    }

    rect = '<div class="resize transparent-rectangle  ' + $type +
        ' " style="position: absolute; text-wrap:nowrap; " id="rectangle_' + section + '_' +
        count + '" data-left="14.25px" data-top="0px" data-type="' + type + '">' + $svg +
        ' <span class="position-absolute top-0 start-50 translate-middle  remove_img"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor"d="M8 5a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3h4.25a.75.75 0 1 1 0 1.5H19V18a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V6.5H3.75a.75.75 0 0 1 0-1.5H8zM6.5 6.5V18c0 .83.67 1.5 1.5 1.5h8c.83 0 1.5-.67 1.5-1.5V6.5h-11zm3-1.5h5c0-.83-.67-1.5-1.5-1.5h-2c-.83 0-1.5.67-1.5 1.5zm-.25 4h1.5v8h-1.5V9zm4 0h1.5v8h-1.5V9z"></path></svg></span><span class="drag-handle ui-draggable-handle" style="display: flex;"><span class="svg-icon svg-icon-muted svg-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.22 6.573a.75.75 0 1 0 1.06-1.06l-2.145-2.146a1.25 1.25 0 0 0-1.77 0L9.22 5.513a.75.75 0 0 0 1.06 1.06l1.22-1.22v5.899H5.602l1.22-1.22a.75.75 0 0 0-1.06-1.06l-2.147 2.145a1.251 1.251 0 0 0 0 1.77l2.146 2.145a.75.75 0 1 0 1.06-1.06l-1.219-1.22H11.5v5.897l-1.22-1.22a.75.75 0 1 0-1.06 1.061l2.145 2.146a1.248 1.248 0 0 0 1.77 0l2.145-2.146a.75.75 0 1 0-1.06-1.06L13 18.65v-5.898h5.898l-1.22 1.22a.75.75 0 0 0 1.06 1.06l2.147-2.146a1.252 1.252 0 0 0 0-1.77l-2.146-2.145a.75.75 0 0 0-1.06 1.06l1.219 1.22H13V5.354l1.22 1.22Z" fill="currentColor"></path></svg></span></span>  <div class="ui-resizable-handle ui-resizable-e handle-right"id="handle-right"><i class="fa fa-ellipsis-v" style="position:absolute; top:50%"></i></div></div>';

    $('.elementWithBackground').find('.page_' + section).prepend(rect);
    $(".resize").draggable({
        revert: "invalid",
        containment: "parent", // Limit movement within the specified boundary.
        handle: ".drag-handle",

        start: function(event, ui) {
            $(this).draggable('option', 'revert', 'invalid');
            $(this).css({
                'border': $border_type
            });
        },
        stop: function(event, ui) {
            $(this).css({
                'border': 'none'
            });
        }
    }).resizable({
        handles: 'e', //east
        start: function(event, ui) {
            // console.log("resizelssd");
            $(this).css({
                'border': $border_type
            });
        },
        stop: function(event, ui) {
            $(this).attr('data-current_width', ui.size.width);
            $(this).attr('data-current_height', ui.size.height);
            $(this).css({
                'border': 'none'
            });
        }
    });

    $('.remove_img').on('click', function() {
        $(this).parent().remove();
    })

}


function add_line(type, section) {
    count = $('.border_line').length + 1;

    while ($('#border_line' + count).length > 0) {
        count++; // If the ID exists, increment the count and check again
    }


    rect = '<div class="resize border_line  " style="position: absolute; text-wrap:nowrap; " id="border_line_' +
        section + '_' + count +
        '" data-left="14.25px" data-top="0px" data-type="' + type +
        '"><span class="border-inner-span border-top-' + type +
        '"  ></span><span class="position-absolute top-0 start-50 translate-middle  remove_img"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor"d="M8 5a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3h4.25a.75.75 0 1 1 0 1.5H19V18a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V6.5H3.75a.75.75 0 0 1 0-1.5H8zM6.5 6.5V18c0 .83.67 1.5 1.5 1.5h8c.83 0 1.5-.67 1.5-1.5V6.5h-11zm3-1.5h5c0-.83-.67-1.5-1.5-1.5h-2c-.83 0-1.5.67-1.5 1.5zm-.25 4h1.5v8h-1.5V9zm4 0h1.5v8h-1.5V9z"></path></svg></span><span class="drag-handle ui-draggable-handle" style="display: flex;"><span class="svg-icon svg-icon-muted svg-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.22 6.573a.75.75 0 1 0 1.06-1.06l-2.145-2.146a1.25 1.25 0 0 0-1.77 0L9.22 5.513a.75.75 0 0 0 1.06 1.06l1.22-1.22v5.899H5.602l1.22-1.22a.75.75 0 0 0-1.06-1.06l-2.147 2.145a1.251 1.251 0 0 0 0 1.77l2.146 2.145a.75.75 0 1 0 1.06-1.06l-1.219-1.22H11.5v5.897l-1.22-1.22a.75.75 0 1 0-1.06 1.061l2.145 2.146a1.248 1.248 0 0 0 1.77 0l2.145-2.146a.75.75 0 1 0-1.06-1.06L13 18.65v-5.898h5.898l-1.22 1.22a.75.75 0 0 0 1.06 1.06l2.147-2.146a1.252 1.252 0 0 0 0-1.77l-2.146-2.145a.75.75 0 0 0-1.06 1.06l1.219 1.22H13V5.354l1.22 1.22Z" fill="currentColor"></path></svg></span></span>  <div class="ui-resizable-handle ui-resizable-e handle-right"id="handle-right"><i class="fa fa-ellipsis-v" style="position:absolute; top:50%"></i></div></div>';
    $('.elementWithBackground').find('.page_' + section).prepend(rect);
    $(".resize").draggable({
        revert: "invalid",
        containment: "document", // Limit movement within the specified boundary.

        handle: ".drag-handle",
        start: function(event, ui) {
            $(this).draggable('option', 'revert', 'invalid');
            $(this).css({
                'border': $border_type
            });
        },
        stop: function(event, ui) {
            $(this).css({
                'border': 'none'
            });
        }
    }).resizable({
        stop: function(event, ui) {
            $(this).attr('data-current_width', ui.size.width);
            $(this).attr('data-current_height', ui.size.height);
        }
    });
    $('.remove_img').on('click', function() {
        $(this).parent().remove();
    })

}



function print_receipt() {
    //window.print();

    let element = document.getElementById('printzone');

    // // Store original background color
    let originalBG = element.style.backgroundColor;


    const printzone = document.getElementById('printzone');
    const pages = printzone.querySelectorAll('.pages'); // Select all pages
    $('.remove_img').hide();

    function capturePage(page) {
        return new Promise((resolve, reject) => {
            html2canvas(page).then(function(canvas) {
                // Revert the background color back to its original
                page.style.backgroundColor = originalBG;

                const imgData = canvas.toDataURL('image/png');
                resolve(imgData);
            }).catch(error => {
                reject(error);
            });
        });
    }

    // Use Promise.all to capture images for all pages asynchronously
    Promise.all(Array.from(pages).map(page => capturePage(page)))
        .then(pageImages => {
            // Call printJS after all images are captured
            printJS({
                printable: pageImages,
                type: 'image',
            });
            $('.remove_img').show();
        })
        .catch(error => {
            console.error('Error capturing page images:', error);
        });




}



$(function() {
    $('.remove_shape').on('click', function() {
        $(this).parent().remove();
    })
    $('.remove_img').on('click', function() {
        $(this).parent().remove();
    })


    $(".draggable").draggable({
        revert: "invalid",
        handle: ".drag-handle",
        containment: "parent", // Limit movement within the specified boundary.
        disabled: true,
        start: function(event, ui) {
            // var elementId = ui.helper.attr('id');
            // localStorage.setItem('draggedHTML-'+$(this).parent().attr('id')+'-' + elementId, ui.helper[0].innerHTML);
            $(this).draggable('option', 'revert', 'invalid');
            $(this).css({
                'border': $border_type
            });
        },
        stop: function(event, ui) {
            $(this).css({
                'border': 'none'
            });
        }
    });
    $(".resize").draggable({
        revert: "invalid",
        containment: "parent", // Limit movement within the specified boundary.
        handle: ".drag-handle",
        disabled: true,
        start: function(event, ui) {
            $(this).draggable('option', 'revert', 'invalid');
            $(this).css({
                'border': $border_type
            });
        },
        stop: function(event, ui) {
            $(this).css({
                'border': 'none'
            });
        }
    }).resizable({
        handles: 'e', //east
        start: function(event, ui) {
            // console.log("resizelssd");
            $(this).css({
                'border': $border_type
            });
        },
        stop: function(event, ui) {
            $(this).attr('data-current_width', ui.size.width);
            $(this).attr('data-current_height', ui.size.height);
            $(this).css({
                'border': 'none'
            });
        }
    });


    $(".page_header, .page_body , .page_footer ").droppable({
        accept: ".draggable , .resize",
        drop: function(event, ui) {

            var elementId = ui.draggable.attr('id');

            // console.log('elementId', elementId);



            var droppedRelativeLeft = ui.offset.left - $(this).offset().left;
            var droppedRelativeTop = ui.offset.top - $(this).offset().top;
            var width = $(this).data('current_width');
            var height = $(this).data('current_height');
            // if(!custom_img && !resizer){
            // 	width = 'fit-content';
            // }

            // Append the dragged item to the drop zone
            ui.draggable.appendTo(this).css({
                top: droppedRelativeTop + 'px',
                left: droppedRelativeLeft + 'px',
                position: 'absolute',
                width: width,
                height: height,
            });
            ui.draggable.appendTo(this).attr('data-left', droppedRelativeLeft + 'px');
            ui.draggable.appendTo(this).attr('data-top', droppedRelativeTop + 'px');

            ui.draggable.appendTo(this).css({
                top: droppedRelativeTop + 'px',
                left: droppedRelativeLeft + 'px',
                position: 'absolute',
                width: width,
                height: height,
            }).attr({
                'data-left': droppedRelativeLeft + 'px',
                'data-top': droppedRelativeTop + 'px'
            }); // Removing an old class





        }
    });






});



$(document).on("mouseup", ".draggable", function() {

    var elem = $(this),
        id = elem.attr('id'),
        desc = elem.attr('data-desc'),
        pos = elem.position();
    elem.attr('data-left', pos.left + 'px');
    elem.attr('data-top', pos.top + 'px');
    // console.log('Left: ' + pos.left + '; Top:' + pos.top);

});

function save() {
    pos = [];
    checks = [];
    $(".page-one .draggable").each(function() {

        var elem = $(this),
            id = elem.attr('id');

        newleft = (elem.attr('data-left')) ? elem.attr('data-left') : '0px';
        newtop = (elem.attr('data-top')) ? elem.attr('data-top') : '0px';

        newsize = (elem.attr('data-current_size')) ? elem.attr('data-current_size') : '11px';
        newweight = (elem.attr('data-current_weight')) ? elem.attr('data-current_weight') : '400';
        newcolor = (elem.attr('data-current_color')) ? elem.attr('data-current_color') : '#7c7676';
        // console.log('newcolor', newcolor);

        newtype = (elem.attr('data-type')) ? elem.attr('data-type') : '';


        display = elem.css('display');

        if (display === 'none') {
            var display = $(".page-two #" + id).css('display');
            if (display === 'none') {
                var display = $(".page-three #" + id).css('display');
                if (display != 'none') {
                    newleft = ($(".page-three #" + id).attr('data-left')) ? $(".page-three #" + id).attr(
                        'data-left') : '0px';
                    newtop = ($(".page-three #" + id).attr('data-top')) ? $(".page-three #" + id).attr(
                        'data-top') : '0px';
                    newtype = ($(".page-three #" + id).attr('data-type')) ? $(".page-three #" + id).attr(
                        'data-type') : '';
                }
            } else {
                newleft = ($(".page-two #" + id).attr('data-left')) ? $(".page-two #" + id).attr('data-left') :
                    '0px';
                newtop = ($(".page-two #" + id).attr('data-top')) ? $(".page-two #" + id).attr('data-top') :
                    '0px';
                newtype = ($(".page-two #" + id).attr('data-type')) ? $(".page-two #" + id).attr('data-type') :
                    '';
            }
        }




        newwidth = '0px';
        newheight = '0px';
        pos.push({
            'id': id,
            'newleft': newleft,
            'newtop': newtop,
            'newtype': newtype,
            'newwidth': newwidth,
            'newheight': newheight,
            'newsize': newsize,
            'newweight': newweight,
            'newcolor': newcolor,
            'display': display
        })
        console.log({
            'id': id,
            'newleft': newleft,
            'newtop': newtop,
            'newtype': newtype,
            'newwidth': newwidth,
            'newheight': newheight,
            'display': display
        });

    })
    $(" .page-one .resize").each(function() {
        // console.log("here");
        var elem = $(this),
            id = elem.attr('id');
        // console.log(id);

        newsize = (elem.attr('data-current_size')) ? elem.attr('data-current_size') : '11px';
        newweight = (elem.attr('data-current_weight')) ? elem.attr('data-current_weight') : '400';
        newleft = (elem.attr('data-left')) ? elem.attr('data-left') : '0px';
        newtop = (elem.attr('data-top')) ? elem.attr('data-top') : '0px';
        newtype = (elem.attr('data-type')) ? elem.attr('data-type') : '';
        newwidth = (elem.attr('data-current_width')) ? elem.attr('data-current_width') : '0px';
        newheight = (elem.attr('data-current_height')) ? elem.attr('data-current_height') : '0px';

        pos.push({
            'id': id,
            'newleft': newleft,
            'newtop': newtop,
            'newtype': newtype,
            'newwidth': newwidth,
            'newheight': newheight,
            'newsize': newsize,
            'newheight': newheight,
            display: elem.css('display'),
        })
        // console.log({
        //     'id': id,
        //     'newleft': newleft,
        //     'newtop': newtop,
        //     'newtype': newtype,
        //     'newwidth': newwidth,
        //     'newheight': newheight,
        //     display: elem.css('display'),
        // });
    })
    $(".save_checkbox ").each(function() {
        if ($(this).is(':checked')) {
            checks.push($(this).attr('id'));
        }
    });

    $.ajax({
        type: 'POST',
        url: '<?php echo site_url("Receipt/update_receipt"); ?>',
        data: {
            'tables': JSON.stringify(pos),
            'checks': JSON.stringify(checks),
            'receipt': '<?php echo $receipt['id']; ?>',
            'background_image_id': $('#background_image_id').val(),
            'first_page_items': $('#first_page_items').val(),
            'other_page_items': $('#other_page_items').val(),
            'table_image_position': $('#table_image_position').val(),
            'table_image_size': $('#table_image_size').val(),
            'table_element_order': $('#table_element_order').val(),
            'tbl_all_borders': $('.tbl_all_borders').attr('data-is_active'),
            'tbl_horzontal_borders': $('.tbl_horzontal_borders').attr('data-is_active'),
            'tbl_vertical_borders': $('.tbl_vertical_borders').attr('data-is_active'),
            'tbl_header_bg': $('.tbl_header_bg').attr('data-is_active'),

        },
        success: function(result) {
            show_feedback('success', <?php echo json_encode(lang('success')); ?>,
                <?php echo json_encode(lang('success')); ?>);
        }
    })

}

function hide_show_label(cl) {
    if ($('#' + cl).is(':checked')) {
        $('.' + cl).show();
    } else {
        $('.' + cl).hide();
    }
}

function close_popover() {
    $('.popover').popover('hide');
}
function update_custom_label(id) {
	var custom_label_id = $('#custom_label_id_edit_'+id).val();
	var custom_label_no_items = $('.kt_dialer_example_'+id+'input').val();
	if(custom_label_id){
		$.ajax({
            type: 'POST',
            url: '<?php echo site_url("Receipt/update_custom_label"); ?>',
            data: {
                'value': custom_label_id,
				'id': id,
            },
            success: function(result) {
				$('#exect_value_'+id).text(custom_label_id);
				
			}
		});
	}
}
function save_custom_label() {
    var custom_label_id = $('#custom_label_id').val();
    if (custom_label_id != '') {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("Receipt/add_custom_label"); ?>',
            data: {
                'custom_label_id': custom_label_id,
                'receipt': '<?php echo $receipt['id']; ?>'
            },
            success: function(result) {

                var modifiedString = custom_label_id.toLowerCase().replace(/ /g, '_');

                // Remove non-alphanumeric characters except underscores
                modifiedString = modifiedString.replace(/[^a-zA-Z0-9_]/g, '') + "_text";

                custom_label_id = custom_label_id + ' text';
                $content_header = '<div class="draggable already_hidden header-' + modifiedString +
                    ' ui-draggable ui-draggable-handle" style="position: absolute;   text-wrap:nowrap;  font-weight:800; font-size:11px; color:#000000; width:auto ;height:auto; text-wrap:nowrap; left:0px; top:0px; display:none;  " data-left="0px" data-top="0px" data-current_width="auto" data-current_height="auto" data-current_size="11px" data-current_weight="800" data-current_color="#000000" id="header-' +
                    modifiedString +
                    '"> <span class="position-absolute top-0 start-50 translate-middle  remove_img" style="display: none;"  ><svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24"viewBox="0 0 24 24"><path fill="currentColor"d="M8 5a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3h4.25a.75.75 0 1 1 0 1.5H19V18a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V6.5H3.75a.75.75 0 0 1 0-1.5H8zM6.5 6.5V18c0 .83.67 1.5 1.5 1.5h8c.83 0 1.5-.67 1.5-1.5V6.5h-11zm3-1.5h5c0-.83-.67-1.5-1.5-1.5h-2c-.83 0-1.5.67-1.5 1.5zm-.25 4h1.5v8h-1.5V9zm4 0h1.5v8h-1.5V9z"></path></svg></span><span class="position-absolute top-0 start-0 translate-middle  edit_text" style="display: none;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor" /><path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor" /> <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor" /> </svg> </span>  ' +
                    custom_label_id +
                    ' <span class="drag-handle" style="display: none;"> <span class="svg-icon svg-icon-muted svg-icon">  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd"  d="M14.22 6.573a.75.75 0 1 0 1.06-1.06l-2.145-2.146a1.25 1.25 0 0 0-1.77 0L9.22 5.513a.75.75 0 0 0 1.06 1.06l1.22-1.22v5.899H5.602l1.22-1.22a.75.75 0 0 0-1.06-1.06l-2.147 2.145a1.251 1.251 0 0 0 0 1.77l2.146 2.145a.75.75 0 1 0 1.06-1.06l-1.219-1.22H11.5v5.897l-1.22-1.22a.75.75 0 1 0-1.06 1.061l2.145 2.146a1.248 1.248 0 0 0 1.77 0l2.145-2.146a.75.75 0 1 0-1.06-1.06L13 18.65v-5.898h5.898l-1.22 1.22a.75.75 0 0 0 1.06 1.06l2.147-2.146a1.252 1.252 0 0 0 0-1.77l-2.146-2.145a.75.75 0 0 0-1.06 1.06l1.219 1.22H13V5.354l1.22 1.22Z"  fill="currentColor"></path>  </svg>  </span> </span></div>';
                $content_body = '<div class="draggable already_hidden body-' + modifiedString +
                    ' ui-draggable ui-draggable-handle" style="position: absolute;   text-wrap:nowrap;  font-weight:800; font-size:11px; color:#000000; width:auto;height:auto; text-wrap:nowrap; left:0px; top:0px; display:none;  " data-left="0px" data-top="0px" data-current_width="auto" data-current_height="auto" data-current_size="11px" data-current_weight="800" data-current_color="#000000" id="body-' +
                    modifiedString +
                    '"> <span class="position-absolute top-0 start-50 translate-middle  remove_img" style="display: none;"><svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24"viewBox="0 0 24 24"><path fill="currentColor"d="M8 5a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3h4.25a.75.75 0 1 1 0 1.5H19V18a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V6.5H3.75a.75.75 0 0 1 0-1.5H8zM6.5 6.5V18c0 .83.67 1.5 1.5 1.5h8c.83 0 1.5-.67 1.5-1.5V6.5h-11zm3-1.5h5c0-.83-.67-1.5-1.5-1.5h-2c-.83 0-1.5.67-1.5 1.5zm-.25 4h1.5v8h-1.5V9zm4 0h1.5v8h-1.5V9z"></path></svg></span><span class="position-absolute top-0 start-0 translate-middle  edit_text" style="display: none;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor" /><path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor" /> <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor" /> </svg> </span> ' +
                    custom_label_id +
                    ' <span class="drag-handle" style="display: none;"> <span class="svg-icon svg-icon-muted svg-icon">  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd"  d="M14.22 6.573a.75.75 0 1 0 1.06-1.06l-2.145-2.146a1.25 1.25 0 0 0-1.77 0L9.22 5.513a.75.75 0 0 0 1.06 1.06l1.22-1.22v5.899H5.602l1.22-1.22a.75.75 0 0 0-1.06-1.06l-2.147 2.145a1.251 1.251 0 0 0 0 1.77l2.146 2.145a.75.75 0 1 0 1.06-1.06l-1.219-1.22H11.5v5.897l-1.22-1.22a.75.75 0 1 0-1.06 1.061l2.145 2.146a1.248 1.248 0 0 0 1.77 0l2.145-2.146a.75.75 0 1 0-1.06-1.06L13 18.65v-5.898h5.898l-1.22 1.22a.75.75 0 0 0 1.06 1.06l2.147-2.146a1.252 1.252 0 0 0 0-1.77l-2.146-2.145a.75.75 0 0 0-1.06 1.06l1.219 1.22H13V5.354l1.22 1.22Z"  fill="currentColor"></path>  </svg>  </span> </span></div>';
                $content_footer = '<div class="draggable already_hidden footer-' + modifiedString +
                    ' ui-draggable ui-draggable-handle" style="position: absolute;   text-wrap:nowrap;  font-weight:800; font-size:11px; color:#000000; width:auto;height:auto; text-wrap:nowrap; left:0px; top:0px; display:none;  " data-left="0px" data-top="0px" data-current_width="auto" data-current_height="auto" data-current_size="11px" data-current_weight="800" data-current_color="#000000" id="footer-' +
                    modifiedString +
                    '"> <span class="position-absolute top-0 start-50 translate-middle  remove_img" style="display: none;"><svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24"viewBox="0 0 24 24"><path fill="currentColor"d="M8 5a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3h4.25a.75.75 0 1 1 0 1.5H19V18a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V6.5H3.75a.75.75 0 0 1 0-1.5H8zM6.5 6.5V18c0 .83.67 1.5 1.5 1.5h8c.83 0 1.5-.67 1.5-1.5V6.5h-11zm3-1.5h5c0-.83-.67-1.5-1.5-1.5h-2c-.83 0-1.5.67-1.5 1.5zm-.25 4h1.5v8h-1.5V9zm4 0h1.5v8h-1.5V9z"></path></svg></span><span class="position-absolute top-0 start-0 translate-middle  edit_text" style="display: none;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor" /><path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor" /> <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor" /> </svg> </span> ' +
                    custom_label_id +
                    ' <span class="drag-handle" style="display: none;"> <span class="svg-icon svg-icon-muted svg-icon">  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd"  d="M14.22 6.573a.75.75 0 1 0 1.06-1.06l-2.145-2.146a1.25 1.25 0 0 0-1.77 0L9.22 5.513a.75.75 0 0 0 1.06 1.06l1.22-1.22v5.899H5.602l1.22-1.22a.75.75 0 0 0-1.06-1.06l-2.147 2.145a1.251 1.251 0 0 0 0 1.77l2.146 2.145a.75.75 0 1 0 1.06-1.06l-1.219-1.22H11.5v5.897l-1.22-1.22a.75.75 0 1 0-1.06 1.061l2.145 2.146a1.248 1.248 0 0 0 1.77 0l2.145-2.146a.75.75 0 1 0-1.06-1.06L13 18.65v-5.898h5.898l-1.22 1.22a.75.75 0 0 0 1.06 1.06l2.147-2.146a1.252 1.252 0 0 0 0-1.77l-2.146-2.145a.75.75 0 0 0-1.06 1.06l1.219 1.22H13V5.354l1.22 1.22Z"  fill="currentColor"></path>  </svg>  </span> </span></div>';
                $('.page_header').prepend($content_header);

                $('.page_body').prepend($content_body);

                $('.page_footer').prepend($content_footer);

                $('#items-drag').prepend(result);
                show_feedback('success', <?php echo json_encode(lang('success')); ?>,
                    <?php echo json_encode(lang('success')); ?>);
                $('[data-toggle="popover"]').popover(); // Initialize all popovers

                // Stop propagation for the popover trigger
                $('[data-toggle="popover"]').on('click', function(e) {



                    e.stopPropagation();

                });

                // Close popover on clicking outside
                $(document).on('click', function(e) {

                    if (!$(e.target).is(':checkbox') && !$(e.target).parent().hasClass(
                            'custom_label_body')) {
                        $('[data-toggle="popover"]').popover('hide');
                    }
                });

                // Close popover on clicking inside the popover body
                $('.popover').on('click', '.popover-body', function() {

                    if (!$(e.target).is(':checkbox') && !$(this).hasClass('custom_label_body')) {
                        $('[data-toggle="popover"]').popover('hide');
                    }
                });

                $(".draggable").draggable({
                    handle: ".drag-handle",
                    revert: "invalid",
                    containment: "parent", // Limit movement within the specified boundary.
                    disabled: true,
                    start: function(event, ui) {
                        // var elementId = ui.helper.attr('id');
                        // localStorage.setItem('draggedHTML-'+$(this).parent().attr('id')+'-' + elementId, ui.helper[0].innerHTML);
                        $(this).draggable('option', 'revert', 'invalid');
                        $(this).css({
                            'border': $border_type
                        });
                    },
                    stop: function(event, ui) {
                        $(this).css({
                            'border': 'none'
                        });
                    }
                });
                $(".resize").draggable({
                    revert: "invalid",
                    containment: "parent", // Limit movement within the specified boundary.
                    handle: ".drag-handle",
                    disabled: true,
                    start: function(event, ui) {
                        $(this).draggable('option', 'revert', 'invalid');
                        $(this).css({
                            'border': $border_type
                        });
                    },
                    stop: function(event, ui) {
                        $(this).css({
                            'border': 'none'
                        });
                    }
                }).resizable({
                    handles: 'e', //east
                    start: function(event, ui) {
                        // console.log("resizelssd");
                        $(this).css({
                            'border': $border_type
                        });
                    },
                    stop: function(event, ui) {
                        $(this).attr('data-current_width', ui.size.width);
                        $(this).attr('data-current_height', ui.size.height);
                        $(this).css({
                            'border': 'none'
                        });
                    }
                });


                $(".page_header, .page_body , .page_footer ").droppable({
                    accept: ".draggable , .resize",
                    drop: function(event, ui) {

                        var elementId = ui.draggable.attr('id');

                        // console.log('elementId', elementId);



                        var droppedRelativeLeft = ui.offset.left - $(this).offset().left;
                        var droppedRelativeTop = ui.offset.top - $(this).offset().top;
                        var width = $(this).data('current_width');
                        var height = $(this).data('current_height');
                        // if(!custom_img && !resizer){
                        // 	width = 'fit-content';
                        // }

                        // Append the dragged item to the drop zone
                        ui.draggable.appendTo(this).css({
                            top: droppedRelativeTop + 'px',
                            left: droppedRelativeLeft + 'px',
                            position: 'absolute',
                            width: width,
                            height: height,
                        });
                        ui.draggable.appendTo(this).attr('data-left', droppedRelativeLeft +
                            'px');
                        ui.draggable.appendTo(this).attr('data-top', droppedRelativeTop + 'px');

                        ui.draggable.appendTo(this).css({
                            top: droppedRelativeTop + 'px',
                            left: droppedRelativeLeft + 'px',
                            position: 'absolute',
                            width: width,
                            height: height,
                        }).attr({
                            'data-left': droppedRelativeLeft + 'px',
                            'data-top': droppedRelativeTop + 'px'
                        }); // Removing an old class





                    }
                });

                close_popover();







                $(window).scroll(function() {
                    $('.popover').hide(); // Hide the popover when scrolling
                });

                var $checkbox_element_image = $('.checkbox_element_image');
                var $table_image_position = $('#table_image_position');





                function update_image_position() {

                    if ($('#checkbox_item_img').is(':checked')) {
                        if ($(this).val() == 'left-side-of-item') {

                            $('.receipt-row-item-holder').find('.w-25').removeClass('w-25').addClass(
                                'w-20');


                            $('.bottom_image').hide();
                            $('.img-column').show();
                            $('.side_image').show();
                        } else {

                            $('.receipt-row-item-holder').find('.w-20').removeClass('w-20').addClass(
                                'w-25');
                            $('.side_image').hide();
                            $('.img-column').hide();
                            $('.bottom_image').show();
                        }
                        $checkbox_element_image.attr('class', '');
                        $checkbox_element_image.attr('class', 'd-flex checkbox_element_image ' + $(this)
                            .val() + ' ');
                    } else {
                        $('.side_image').hide();
                        $('.img-column').hide();
                        $('.bottom_image').hide();
                    }


                }

                $table_image_position.change(update_image_position);
                $table_image_position.val('<?= $receipt['table_image_position'] ?>').trigger('change');



                var $table_image = $('.table_image');
                var $table_image_size = $('#table_image_size');

                function applychangeimagesize() {

                    $table_image.css({
                        'width': $table_image_size.val() + 'px',
                    });
                }
                $table_image.click(function() {
                    // // console.log("img_based_config");
                    $('.text_based_config').hide();
                    $('.img_based_config').show();
                    $('.table_based_config').hide();



                    $currentimg = $(this);
                    $table_image_size.focus();
                    $table_image_size.val($currentimg.css('width').replace('px', ''));
                });
                $table_image_size.change(applychangeimagesize);

                $table_image_size.val('<?= $receipt['table_image_size'] ?>').trigger('change');

                var $fontSizeSelector = $('#font-size-selector');
                var $fontWeightSelector = $('#font-weight-selector');
                var $colorpicker = $('#color');
                var $fontSizeSelectorTable = $('#font-size-selector-table');
                var $currentDiv = null;

                // Function to apply font size and weight to the selected div
                function applyFontStyles() {

                    if ($currentDiv) {
                        $currentDiv.css({
                            'font-size': $fontSizeSelector.val(),
                            'font-weight': $fontWeightSelector.val(),
                            'color': $colorpicker.val()
                        });
                        $currentDiv.attr({
                            'data-current_color': $colorpicker.val(),
                            'data-current_size': $fontSizeSelector.val(),
                            'data-current_weight': $fontWeightSelector.val()
                        });
                    }
                }


                function applyFontStylesTable() {
                    if ($currentDiv) {
                        $currentDiv.find(
                                '.invoice-desc, .invoice-content-heading , .invoice-content, .invoice-head')
                            .css({
                                'font-size': $fontSizeSelectorTable.val(),
                            });
                        $currentDiv.attr({
                            'data-current_size': $fontSizeSelectorTable.val(),
                        });
                    }
                }



                $('.table-data-column, thead').click(function() {
                    // console.log('invoice-table-content');
                    $('.text_based_config').hide();
                    $('.img_based_config').hide();
                    $('.table_based_config').show();
                })


                // Update the dropdowns when a div is clicked

                function update_border() {
                    $('.resize').css({
                        'border': 'none'
                    });
                    $('div[id^="header-"], div[id^="footer-"], div[id^="body-"]').css({
                        'border': 'none'
                    });
                }

                $('.resize').click(function() {
                    update_border();
                    $(this).css({
                        'border': $border_type
                    });
                });

                $('div[id^="header-"], div[id^="footer-"], div[id^="body-"]').click(function() {

                    update_border();
                    $(this).css({
                        'border': $border_type
                    });
                   

					
                    $currentDiv = $(this); // Set the current div
                    if ($currentDiv.attr('id') != 'body-items_list') {

                        $('.text_based_config').show();
                        $('.img_based_config').hide();
                        $('.table_based_config').hide();
                    } else {
                        console.log($currentDiv.css('font-size'));
                        $fontSizeSelectorTable.val($currentDiv.css('font-size'));
                    }

                    $('.remove-btn').unbind('click').click(function() {

                        hide_show_label($currentDiv.attr('id'));
                    });

                    $fontSizeSelector.val($currentDiv.css(
                        'font-size')); // Update font size dropdown
                    $fontWeightSelector.val($currentDiv.css(
                        'font-weight')); // Update font weight dropdown
                    $colorpicker.val($currentDiv.css('color')); // Update font weight dropdown
                    $('#color').colorpicker('setValue', $currentDiv.css('color'));

                });

                // Update the div's styles when dropdowns change
                $fontSizeSelector.change(applyFontStyles);
                $fontSizeSelectorTable.change(applyFontStylesTable);
                $fontWeightSelector.change(applyFontStyles);
                $colorpicker.change(applyFontStyles);
                $('#color').colorpicker();
                $('#color').on('changeColor', function(event) {
                    applyFontStyles();
                });

                $(".draggable").on('click', function() {
                    $(".drag-handle").hide();
                    $(".handle-right").hide();
                    $(".remove_img").hide();
                    $(".edit_text").hide();

                    var handle = $(this).find('.drag-handle');
                    handle.toggle(); // Toggle handle visibility
                    $(this).draggable('option', 'disabled', !handle.is(
                    ':visible')); // Enable/disable dragging


                    var handle = $(this).find('.handle-right');
                    handle.toggle(); // Toggle handle visibility


                    var handle = $(this).find('.remove_img');
                    handle.toggle(); // Toggle handle visibility

                    var handle = $(this).find('.edit_text');
                    handle.toggle(); // Toggle handle visibility


                });

				$('.remove_img').on('click', function() {
					$(this).parent().remove();
				})

            }
        })
    } else {
        show_feedback('error', <?php echo json_encode(lang('please enter label name')); ?>,
            <?php echo json_encode(lang('error')); ?>);
    }

}
$(document).ready(function() {
    // Add click event listener to menu-link elements
    $("#menu-container").on("click", ".menu-link", function() {
        if (!$(this).hasClass("redirect-link")) {
            if ($(this).hasClass("not-link")) {
                return; // Exit without doing anything
            }
            // Remove 'active' class from all menu-link siblings
            $(this).siblings().removeClass("active");

            // Add 'active' class to the clicked menu-link
            $(this).addClass("active");

            // Get the data-id of the clicked menu-link
            var relatedId = $(this).data("id");

            // Hide all menu-card divs by adding 'd-none'
            $(".menu-card").addClass("d-none");

            // Show the menu-card with ID matching data-id
            $("#" + relatedId).removeClass("d-none");
            // console.log("it should not redirect")
        } else {
            window.location.href = $(this).attr('href');
        }

    });

});


function show_detail_listing_table() {
    $(".menu-card").addClass("d-none");
    $("#detail_listing_table").removeClass("d-none");
}

$(document).ready(function() {
    // Hide the drag handle initially
    $(".drag-handle").hide();
    $(".handle-right").hide();
    $(".remove_img").hide();
    $(".edit_text").hide();


    $(".resize").on('click', function() {
        $(".drag-handle").hide();
        $(".handle-right").hide();
        $(".remove_img").hide();
        $(".edit_text").hide();
        var handle = $(this).find('.drag-handle');
        handle.toggle(); // Toggle handle visibility
        $(this).draggable('option', 'disabled', !handle.is(':visible')); // Enable/disable dragging



        var handle = $(this).find('.handle-right');
        handle.toggle(); // Toggle handle visibility

        var handle = $(this).find('.remove_img');
        handle.toggle(); // Toggle handle visibility

        var handle = $(this).find('.edit_text');
        handle.toggle(); // Toggle handle visibility


    });

    $(".draggable").on('click', function() {
        $(".drag-handle").hide();
        $(".handle-right").hide();
        $(".remove_img").hide();
        $(".edit_text").hide();

        var handle = $(this).find('.drag-handle');
        handle.toggle(); // Toggle handle visibility
        $(this).draggable('option', 'disabled', !handle.is(':visible')); // Enable/disable dragging


        var handle = $(this).find('.handle-right');
        handle.toggle(); // Toggle handle visibility


        var handle = $(this).find('.remove_img');
        handle.toggle(); // Toggle handle visibility

        var handle = $(this).find('.edit_text');
        handle.toggle(); // Toggle handle visibility


    });

});
</script>