<script src="<?= site_url(); ?>assets/css_good/plugins/custom/typedjs/typedjs.bundle.js"></script>
<div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-4">
    <!--begin::Thumbnail settings-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2> <?= lang('Thumbnail'); ?></h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body text-center pt-0">
            <!--begin::Image input-->
            <!--begin::Image input placeholder-->

           

<style>
    .custom-img {
        width: 150px;  /* Adjust width */
        height: 150px; /* Adjust height */
        object-fit: cover; /* Ensures the image is properly scaled */
        border-radius: 10px; /* Optional: adds rounded corners */
        display: block; /* Ensures proper alignment */
        margin: 10px auto; /* Centers the image */
    }
</style>
<?php
           
           //    $img =   $this->item->get_item_main_image($item_info->item_id , $item_info->main_image_id); 
            //   dd($item_kit_info);
           $url = site_url('assets/img/blank-image.svg');
           if($item_kit_info->main_image_id){
               $url =  cacheable_app_file_url($item_kit_info->main_image_id);
           }
         
           //  
              
              ?>


            <style>
            .image-input-placeholder {
                background-image: url('<?= $url; ?>');
            }

            [data-bs-theme="dark"] .image-input-placeholder {
                background-image: url('<?= $url; ?>');
            }
            </style>
            <!--end::Image input placeholder-->

            <div class="image-input image-input-empty image-input-outline  mb-3"
                data-kt-image-input="true">
                <!--begin::Preview existing avatar-->
                <div class="image-input-wrapper w-150px h-150px image-input-placeholder"></div>
                <!--end::Preview existing avatar-->

                <!--begin::Label-->
                <?php 
$image_query_param = isset($first_image_id) ? '?image_id=' . $first_image_id : '';
?>

<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow">
    <i class="fa fa-pencil fs-7 myimg" style="margin-left: 3px;" 
       data-link="<?php 
       if(isset($item_kit_info)) { 
           echo site_url("item_kit_info/images/" . ($item_kit_info->item_kit_id ? $item_kit_info->item_kit_id : -1) . $image_query_param);
       } else { 
           echo site_url("item_kit_info/images/" . ($item_kit_info->item_id ? $item_kit_info->item_id : -1) . $image_query_param);
       } 
       ?>">
    </i>
</label>

                <!--end::Label-->

                <!--begin::Cancel-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar"
                    data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                    <i class="fa fa-trash  fs-7 text-danger"><span class="path1"></span><span class="path2"></span></i>
                </span>
                <!--end::Cancel-->

                <!--begin::Remove-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar"
                    data-bs-original-title="Remove avatar" data-kt-initialized="1">
                    <i class="fa fa-trash fs-7 text-danger"><span class="path1"></span><span class="path2"></span></i>
                </span>
                <!--end::Remove-->
            </div>
            <!--end::Image input-->

            <!--begin::Description-->
       
            <!--end::Description-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Thumbnail settings-->
    <!--begin::Status-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2><?= lang('Thumbnail'); ?></h2>
            </div>
            <!--end::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
            </div>
            <!--begin::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Select2-->
                        <?php
                        
                            $item_statuses = array(
                                '0' => lang('draft'),
                                '1' => lang('active'),
                                '2' => lang('inactive'),

                            );
                        ?>
            <?php echo form_label(lang('item_status').':', 'item_status',array('class'=>'form-label  required wide')); ?>

                        <?php echo form_dropdown('item_status', $item_statuses,(isset($item_info->item_status))?$item_info->item_status:0, 'class="form-control form-inps" id="item_status"');?>


           
            <!--end::Select2-->

            <!--begin::Description-->
            <div class="text-muted fs-7"><?= lang('Set_the_product_status'); ?>.</div>
            <!--end::Description-->

        </div>
        <!--end::Card body-->
    </div>
    <!--end::Status-->

    <!--begin::Category & tags-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2> <?= lang('Product_Details'); ?></h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Input group-->
            <!--begin::Label-->

            <label class="form-label"><?= lang('name'); ?></label>
          


          
            <!--end::Label-->


            <?php if( $this->uri->segment(2) !='view'): ?>
                
           

                  

                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 my-5">


                        <a href="javascript:void(0);" class="btn btn-light-primary" id="add_secondary_category"><i
                                class="fas fa-plus fs-4 me-2"></i><?php echo lang('add_secondary_category'); ?></a>

                    </div>

<?php endif; ?>
          
            <!--end::Select2-->

            <!--begin::Description-->
            <div class="text-muted fs-7 mb-7"> <?= lang('Add_product_to_a_category'); ?>.</div>
            <!--end::Description-->
            <!--end::Input group-->

         
            <!--end::Description-->
            <!--end::Input group-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Category & tags-->
    <!--begin::Weekly sales-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>  <?= lang('Monthly_Sales'); ?></h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0" id="sale_monthly">
    
        <span id="kt_typedjs_example_1" class="fs-1 fw-bold"></span>
           
        </div>
       
        <!--end::Card body-->
    </div>
    <!--end::Weekly sales-->
</div>

<?php if( $this->uri->segment(2) !='view'): ?>
<script id="secondary-category-template" type="text/x-handlebars-template">

    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
		<?php echo form_label(lang('secondary_category').':', 'secondary_category_id_{{index}}',array('class'=>'form-label  wide')); ?>
		
			<?php echo form_dropdown('secondary_categories[{{index}}]', $categories,'', 'class="form-control form-inps" id="secondary_category_id_{{index}}"');?>
		
	</div>
</script>
<script id="secondary-supplier-template" type="text/x-handlebars-template">

    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
		<?php echo form_label(lang('secondary_supplier').':', 'secondary_supplier_id_{{index}}',array('class'=>'form-label  wide')); ?>
		
			<?php echo form_dropdown('secondary_suppliers[{{index}}]', $suppliers,'', 'class="form-control form-inps" id="secondary_supplier_id_{{index}}"');?>
		
	</div>
</script>
<?php endif; ?>
<script>
    $(document).ready(function () {
        var typed = new Typed("#kt_typedjs_example_1", {
    strings: ["<?php echo lang('Please_wait_while_we_load_your_content');?>.", "<?php echo lang('Hold_on_a_moment');?>"],
    typeSpeed: 30
});
        <?php if( $this->uri->segment(2) !='view'): ?>

var secondary_category_index = -1;
var secondary_category_template = Handlebars.compile(document.getElementById("secondary-category-template").innerHTML);

$(document).on('click', "#add_secondary_category", function() {
    $("#add_secondary_category").parent().before(secondary_category_template({
        index: secondary_category_index
    }));
    secondary_category_index -= 1;
});

$(document).on('click', '.delete_secondary_category', function(e) {
    var index = $(this).data('index');
    $(this).parent().parent().remove();

    if (index > 0) {
        $("#item_form").append(
            '<input type="hidden" class="secondary_categories_to_delete" name="secondary_categories_to_delete[]" value="' +
            index + '" />');
    }
});

var secondary_supplier_index = -1;
var secondary_supplier_template = Handlebars.compile(document.getElementById("secondary-supplier-template").innerHTML);
$(document).on('click', "#add_secondary_supplier", function() {
    console.log($("#supplier_id").val());
    if ($("#supplier_id").val() == -1) {
        show_feedback('error',
            <?php echo json_encode(lang('item_first_level_supplier_is_required_to_add_secondary_supplier_message')); ?>,
            <?php echo json_encode(lang('error')); ?>);
        return false;
    }
    $("#add_secondary_supplier").parent().parent().before(secondary_supplier_template({
        index: secondary_supplier_index
    }));
    secondary_supplier_index -= 1;
});


$(document).on('click', '.delete_secondary_supplier', function(e) {
    var index = $(this).data('index');
    $(this).parent().parent().parent().remove();

    if (index > 0) {
        $("#item_form").append(
            '<input type="hidden" class="secondary_suppliers_to_delete" name="secondary_suppliers_to_delete[]" value="' +
            index + '" />');
    }
});



$(document).on('click', "#add_category", function() {
    $("#categoryModalDialogTitle").html(<?php echo json_encode(lang('add_category')); ?>);
    var parent_id = $("#category_id").val();

    $parent_id_select = $('#parent_id');
    $parent_id_select[0].selectize.setValue(parent_id, false);

    $("#categories_form").attr('action', SITE_URL + '/items/save_category');

    //Clear form
    $(":file").filestyle('clear');
    $("#categories_form").find('#category_name').val("");
    $("#categories_form").find('#category_color').val("");
    $('#category_color').colorpicker('setValue', '');
    $("#categories_form").find('#category_image').val("");
    $("#categories_form").find('#image-preview').attr('src', '');
    $('#del_image').prop('checked', false);
    $('#preview-section').hide();

    //show
    $("#category-input-data").modal('show');
});

$("#categories_form").submit(function(event) {
    event.preventDefault();

    $(this).ajaxSubmit({
        success: function(response, statusText, xhr, $form) {
            show_feedback(response.success ? 'success' : 'error', response.message, response
                .success ? <?php echo json_encode(lang('success')); ?> :
                <?php echo json_encode(lang('error')); ?>);
            if (response.success) {
                $("#category-input-data").modal('hide');

                var category_id_selectize = $("#category_id")[0].selectize
                category_id_selectize.clearOptions();
                category_id_selectize.addOption(response.categories);
                category_id_selectize.addItem(response.selected, true);
            }
        },
        dataType: 'json',
    });
});

<?php if ($this->session->flashdata('manage_success_message')) { ?>
show_feedback('success', <?php echo json_encode($this->session->flashdata('manage_success_message')); ?>,
    <?php echo json_encode(lang('success')); ?>);
<?php } ?>
<?php endif; ?>


        $('.myimg').on('click', function(){
                // Window.Location($(this).data('link'));
                window.location.href = $(this).data('link');
        });



        url =  '<?= site_url(); ?>/reports/generate_ajax/summary_items?tier_id=&report_type=simple&report_date_range_simple=LAST_30&start_date_formatted=10%2F01%2F2024+12%3A00+am&start_date=2024-10-01+00%3A00&end_date_formatted=10%2F01%2F2024+11%3A59+pm&end_date=2024-10-01+23%3A59&with_time=1&end_date_end_of_day=0&supplier_id=&manufacturer_id=&customer_id=&category_id=&register_id=&item_id=<?= $item_kit_info->item_kit_id; ?>&sale_type=all&items_to_show=items_with_sales&select_all=1&location_ids%5B%5D=1&company=All&business_type=All&sale_type_suspended=&items%5B%5D=pos&items%5B%5D=items&items%5B%5D=customers&items%5B%5D=work_orders&items%5B%5D=sales_list&compare=no&export_excel=false';

        is_item = '<?= $item_kit_info->item_kit_id; ?>';

        if(is_item != -1 && is_item !=''){
            setTimeout(function(){
            $.ajax({
    type: "GET",
    url: url,
    success: function(response) {
        var data = JSON.parse(response);

        var headers = data.headers[0]; // Get the headers array
        var details = data.full[0][0]; // Get the details (first row of full data)
        
        var requiredHeaders = [
            "Quantity Purchased",
            "Subtotal",
            "Total",
            "Tax",
            "Profit",
            "Cost Of Goods Sold"
        ];

        if(details){
            $("#sale_monthly").html(""); // Clear existing content
            var index = 0; // Initialize index for recursive function

            function typeData() {
                // Check if index is within bounds
                if (index < headers.length) {
                    var headerText = headers[index].data; // Get the header text
                    var detailValue = details[index].data; // Get the corresponding value

                    if (requiredHeaders.includes(headerText)) {
                        // Create a unique ID for each Typed.js element
                        var typedElementId = 'typed-' + index;
                        // Append the container for Typed.js
                        $("#sale_monthly").append("<p><strong>" + headerText + ":</strong> <span id='" + typedElementId + "'></span></p>");
                        // Initialize Typed.js for the current element
                        new Typed('#' + typedElementId, {
                            strings: [detailValue],
                            typeSpeed: 50, // Adjust typing speed as needed
                            backSpeed: 0,
                            loop: false,
                            showCursor: false,
                            onComplete: function() {
                                index++; // Move to the next item
                                typeData(); // Recursively call the function
                            }
                        });
                    } else {
                        // Skip headers that are not required
                        index++;
                        typeData(); // Recursively call the function
                    }
                }
            }

            // Start the typing effect
            typeData();
        } else {
            $("#sale_monthly").html("<p><strong><?= lang('No_data_available'); ?></strong></p>");
        }
    }
});
    }, 5000); 
        }

        

    });




</script>