
 <!--begin::Card-->
 <div class="card mb-5 mb-xl-8">
     <!--begin::Card body-->
     <div class="card-body pt-15">
         <!--begin::Summary-->
         <div class="d-flex flex-center flex-column mb-5">
             <!--begin::Avatar-->
             <div class="symbol symbol-150px symbol-circle mb-7">
                 <?php $user_img = site_url('assets/assets/images/avatar-default.jpg');
                                        if($person_info->image_id){
                                            $user_img = cacheable_app_file_url($person_info->image_id);
                                        }
                                    
                                    ?>
                 <img src="<?= $user_img; ?>"
                     alt="  <?php echo H($person_info->first_name.' '.$person_info->last_name); ?>">
             </div>
             <!--end::Avatar-->

             <!--begin::Name-->
             <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1 typed-text">
                 <?php echo H($person_info->first_name.' '.$person_info->last_name); ?> </a>
             <!--end::Name-->

             <!--begin::Email-->
             <a href="#" class="fs-5 fw-semibold text-muted text-hover-primary mb-6 typed-text">
                 <?= $person_info->email ?></a>
             <!--end::Email-->
         </div>
         <!--end::Summary-->

         <!--begin::Details toggle-->
         <div class="d-flex flex-stack fs-4 py-3">
             <div class="fw-bold">
                 Details
             </div>

             <!--begin::Badge-->
             <div class="badge badge-light-info d-inline">Premium user</div>
             <!--begin::Badge-->
         </div>
         <!--end::Details toggle-->

         <div class="separator separator-dashed my-3"></div>

         <!--begin::Details content-->
         <div class="pb-5 fs-6" id="detailed_data" style="display:none;">
             <!--begin::Details item-->
             <div class="fw-bold mt-5">Account ID</div>
             <div class="text-gray-600">ID-<?= $person_info->person_id; ?></div>
             <!--begin::Details item-->

             <!--begin::Details item-->
             <div class="fw-bold mt-5">Company</div>
             <div class="text-gray-600"><a href="#"
                     class="text-gray-600 text-hover-primary"><?= $person_info->company_name; ?></a>
             </div>
             <!--begin::Details item-->
             <!--begin::Details item-->
             <div class="fw-bold mt-5">Address</div>
             <div class="text-gray-600"><?= $person_info->address_1; ?></div>
             <!--begin::Details item-->
             <!--begin::Details item-->
             <div class="fw-bold mt-5">Zip</div>
             <div class="text-gray-600"><?= $person_info->zip; ?></div>
             <!--begin::Details item-->


             <div class="fw-bold mt-5"><?php 
						
                        echo form_label(lang('credit_limit'))?></div>
             <div class="text-gray-600">
                 <?php echo $person_info->credit_limit ? to_currency($person_info->credit_limit) : lang('none'); ?>
             </div>
             <!--begin::Details item-->

             <?php if($this->config->item('customers_store_accounts')) { ?>



             <!--begin::Details item-->
             <div class="fw-bold mt-5"> <?php echo lang('store_account_balance').': '; ?></div>
             <div class="text-gray-600">
                 <?php echo $person_info->balance ? to_currency($person_info->balance) : '0.00'; ?></div>
             <!--begin::Details item-->



             <?php } 


if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'simple')
    {
    ?>



             <!--begin::Details item-->
             <div class="fw-bold mt-5"> <?php echo lang('sales_until_discount').': '; ?></div>
             <div class="text-gray-600"> <?php 
       $sales_until_discount = $this->config->item('number_of_sales_for_discount') - $person_info->current_sales_for_discount;
        
        echo to_quantity($sales_until_discount); ?></div>
             <!--begin::Details item-->




             <?php
    }
    ?>

             <?php
    if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced')
    {
         list($spend_amount_for_points, $points_to_earn) = explode(":",$this->config->item('spend_to_point_ratio'),2);
         $spend_amount_for_points = (float)$spend_amount_for_points;
         $points_to_earn = (float)$points_to_earn;
        
    ?>

 <!--begin::Details item-->
 <div class="fw-bold mt-5">  <?php echo lang('points').': '; ?></div>
             <div class="text-gray-600"><?php echo to_quantity($person_info->points); ?></div>
          

              <!--begin::Details item-->
 <div class="fw-bold mt-5">  <?php echo lang('customers_amount_to_spend_for_next_point').': '; ?></div>
             <div class="text-gray-600">   <?php echo to_currency($spend_amount_for_points - $person_info->current_spend_for_points); ?></div>

             <?php
    }
    ?>

             <!--begin::Details item-->

             <!--begin::Details item-->
         </div>
         <!--end::Details content-->
     </div>
     <!--end::Card body-->
 </div>
 <!--end::Card-->


 <script>
$(document).ready(function() {
    // Hide the detailed_data div initially
    $('#detailed_data').hide();

    setTimeout(function() {
        $('#detailed_data').fadeIn(); // Show the div

        // Function to initialize Typed.js for all dynamic text
        function initializeTyped() {
            // Loop through all child divs with 'text-gray-600' class
            $('#detailed_data').children('.fw-bold').each(function() {
                var label = $(this); // Target the label div
                var valueDiv = label.next('.text-gray-600'); // Get the corresponding value div
                if (valueDiv.length > 0) {
                    var text = valueDiv.text().trim(); // Get the text from value div
                    
                    // Clear the content of valueDiv before typing starts
                    valueDiv.html('');

                    // Initialize Typed.js for each item with dynamic text
                    new Typed(valueDiv.get(0), {
                        strings: [text], // Dynamic content from the div
                        typeSpeed: 50,
                        backSpeed: 25,
                        loop: false,
                        showCursor: false
                    });
                }
            });
        }

        // Call the function to initialize Typed.js for each dynamic item
        initializeTyped();

    }, 1000); // Adjust the delay as needed
});
</script>