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
        <div class="d-flex flex-wrap ">

        <?php if(isset($person_info->credit_limit)):  ?>
            <!--begin::Stats-->
            <div class="w-50 px-1 ">
            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3 min-h-100px">
                <div class="fs-4 fw-bold text-gray-700">
                    <span class="w-75px"> <?php echo $person_info->credit_limit ? to_currency($person_info->credit_limit) : lang('none'); ?></span>
                </div>
                <div class="fw-semibold text-muted"><?php 
						
                        echo form_label(lang('credit_limit'))?></div>
            </div>
            <!--end::Stats-->
            </div>
            <?php endif; ?>


            <?php if($this->config->item('customers_store_accounts') && isset($person_info->balance) ):  ?>
            <!--begin::Stats-->
            <div class="w-50 px-1">
            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3 min-h-100px">
                <div class="fs-4 fw-bold text-gray-700">
                    <span class="w-75px"> <?php echo $person_info->balance ? to_currency($person_info->balance) : '0.00'; ?></span>
                </div>
                <div class="fw-semibold text-muted"><?php 
						
                        echo form_label(lang('store_account_balance'))?></div>
            </div>
            </div>
            
            <!--end::Stats-->

            <?php endif; ?>
            </div>
            <div class="d-flex flex-wrap 1">
            <?php if($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'simple' && isset($person_info->current_sales_for_discount) ):  ?>
            <!--begin::Stats-->
            <div class="w-50 px-1 ">
            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3  min-h-100px">
                <div class="fs-4 fw-bold text-gray-700">
                    <span class="w-75px"> <?php 
                        $sales_until_discount = $this->config->item('number_of_sales_for_discount') - $person_info->current_sales_for_discount;
                            
                            echo to_quantity($sales_until_discount); ?></span>
                </div>
                <div class="fw-semibold text-muted"><?php 
						
                        echo form_label(lang('number_of_sales_for_discount'))?></div>
            </div>
            </div>
            <!--end::Stats-->

            <?php endif; ?>



            <?php if($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced' && isset($person_info->current_spend_for_points) ):
                 list($spend_amount_for_points, $points_to_earn) = explode(":",$this->config->item('spend_to_point_ratio'),2);
                 $spend_amount_for_points = (float)$spend_amount_for_points;
                 $points_to_earn = (float)$points_to_earn;
                
                ?>
            <!--begin::Stats-->
            <div class="w-50 px-1 ">
            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3 min-h-100px">
                <div class="fs-4 fw-bold text-gray-700">
                    <span class="w-75px"> <?php 
                     echo to_quantity($person_info->points); ?></span>
                </div>
                <div class="fw-semibold text-muted"><?php 
						
                        echo form_label(lang('points'))?></div>
            </div>
            </div>
            <!--end::Stats-->


               <!--begin::Stats-->
               <div class="w-50 px-1 ">
               <div class="border border-gray-300 border-dashed rounded py-3 px-2 mb-3  min-h-100px">
                <div class="fs-4 fw-bold text-gray-700">
                    <span class="w-75px">  <?php echo to_currency($spend_amount_for_points - $person_info->current_spend_for_points); ?></span>
                </div>
                <div class="fw-semibold text-muted"><?php 
						
                        echo form_label(lang('customers_amount_to_spend_for_next_point'))?></div>
            </div>
            </div>
            <!--end::Stats-->

            <?php endif; ?>


        </div>



        

  




        <div class="d-flex flex-stack  py-3 gap-1">

            <!--begin::Badge-->

            <?php if($type=='employee' && $person_info->person_id && !isset($is_clone)): 
                
                ?>

            <?php
							$one_year_ago = date('Y-m-d', strtotime('-1 year'));
							$today = date('Y-m-d') . '%2023:59:59';
							?>
            <a target="_blank"
                href="<?php echo site_url('reports/generate/specific_employee?employee_type=logged_in_employee&report_type=complex&start_date=' . $one_year_ago . '&start_date_formatted=' . date(get_date_format() . ' ' . get_time_format(), strtotime($one_year_ago)) . '&end_date=' . $today . '&end_date_formatted=' . date(get_date_format() . ' ' . get_time_format(), strtotime(date('Y-m-d') . ' 23:59:59')) . '&employee_id=' . $person_info->person_id . '&sale_type=all&export_excel=0'); ?>"
                class="btn btn-success"><?php echo lang('view_report'); ?></a>
            <?php if ($person_info->email) { ?>
            <a href="mailto:<?php echo H($person_info->email); ?>"
                class="btn btn-primary"><?php echo lang('send_email'); ?></a>
            <?php } ?>




            <?php endif; ?>

            <?php if($type=='customer' && $person_info->person_id ): ?>

            <?php
                        $one_year_ago = date('Y-m-d', strtotime('-1 year'));
                        $today = date('Y-m-d').'%2023:59:59';	
                    ?>
            <a target="_blank"
                href="<?php echo site_url('reports/generate/specific_customer?report_type=complex&start_date='.$one_year_ago.'&start_date_formatted='.date(get_date_format().' '.get_time_format(), strtotime($one_year_ago)).'&end_date='.$today.'&end_date_formatted='.date(get_date_format().' '.get_time_format(), strtotime(date('Y-m-d').' 23:59:59')).'&customer_id='.$person_info->person_id.'&sale_type=all&export_excel=0'); ?>"
                class="btn btn-success"><?php echo lang('view_report'); ?></a>

            <?php if($this->config->item('customers_store_accounts')) { ?>
            <?php echo anchor($controller_name."/pay_now/$person_info->person_id",lang('pay'),array('title'=>lang('pay'),'class'=>'btn btn-primary ')); ?>

            <?php } ?>

            <?php if ($person_info->email) { ?>
            <a href="mailto:<?php echo H($person_info->email); ?>"
                class="btn btn-primary"><?php echo lang('send_email'); ?></a>
            <?php } ?>


            <?php endif; ?>
            <!--begin::Badge-->


        </div>
       
        <div class="d-flex flex-stack fs-4 py-3">
            <div class="fw-bold rotate collapsible active" data-toggle="collapse" href="#kt_customer_view_details_col"
                role="button" aria-expanded="true" aria-controls="kt_customer_view_details_col">
                Details
                <span class="ms-2 rotate-180">
                    <i class="fa fa-chevron-up fs-3"></i>
                    </span>
            </div>
        </div>

        <!--end::Details toggle-->

        <div class="separator separator-dashed my-3"></div>

        <!--begin::Details content-->
        <div class="pb-5 fs-6 collapse in " id="kt_customer_view_details_col">
            <div class="pb-5 fs-6 collapse " id="kt_customer_view_details" style="display:none;">
                <!--begin::Details item-->
                <?php if(isset($person_info->person_id)): ?>
                <div class="fw-bold mt-5">Account ID</div>
                <div class="text-gray-600">ID-<?= $person_info->person_id; ?></div>
                <?php endif ?>
                <!--begin::Details item-->
                <?php if(isset($person_info->company_name)): ?>
                <!--begin::Details item-->
                <div class="fw-bold mt-5">Company</div>
                <div class="text-gray-600"><a href="#"
                        class="text-gray-600 text-hover-primary"><?= $person_info->company_name; ?></a>
                </div>
                <?php endif ?>
                <!--begin::Details item-->
                <!--begin::Details item-->
                <div class="fw-bold mt-5">Address</div>
                <div class="text-gray-600"><?= $person_info->address_1; ?></div>
                <!--begin::Details item-->
                <!--begin::Details item-->
                <div class="fw-bold mt-5">Zip</div>
                <div class="text-gray-600"><?= $person_info->zip; ?></div>
                <!--begin::Details item-->


                <!--begin::Details item-->

                <!--begin::Details item-->
            </div>
        </div>
        <!--end::Details content-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->


<script>
$(document).ready(function() {
    // Hide the kt_customer_view_details div initially
    $('#kt_customer_view_details').hide();

    setTimeout(function() {
        $('#kt_customer_view_details').fadeIn(); // Show the div

        // Function to initialize Typed.js for all dynamic text
        function initializeTyped() {
            // Loop through all child divs with 'text-gray-600' class
            $('#kt_customer_view_details').children('.fw-bold').each(function() {
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