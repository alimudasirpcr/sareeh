<div class="row hidden-print">

    <div class="col-md-12">

        <div class="card">

            <div
                class="card-header rounded rounded-3 p-5  rounded border-primary border border-dashed rounded-3 report-options">
                <?php echo $input_report_title; ?>
                <?php if (isset($output_data) && $output_data) { ?>
                <div class="table_buttons pull-right" style="margin-top: -12px;">
                    <button type="button" class="btn btn-more btn-light-primary expand-collapse" data-toggle="dropdown"
                        aria-expanded="false"><i id="expand-collapse-icon" class="ion-chevron-down"></i></button>
                </div>
                <?php } ?>

                <select id="country-dropdown">
                    <option value="">Select Module</option>
                    <?php
					if ($this->Employee->has_module_action_permission('reports', 'view_appointments', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="appointments"><i class="icon ti-calendar"></i>	<?php echo lang('reports_appointments'); ?></option>
					<?php } ?>
					
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_categories', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="categories"><i class="icon ti-layout-grid3"></i>	<?php echo lang('reports_categories'); ?></option>
					<?php } ?>
					

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_closeout', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="closeout"><i class="icon ti-close"></i>	<?php echo lang('reports_closeout'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_sales_generator', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="custom-report">
							<i class="icon ti-search"></i>	<?php echo lang('custom_report'); ?>
						</option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_commissions', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="commissions"><i class="icon ti-money"></i>	<?php echo lang('reports_commission'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_customers', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="customers"><i class="icon ti-user"></i>	<?php echo lang('reports_customers'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_deleted_sales', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>	
						<option  value="deleted-sales"><i class="icon ti-trash"></i>	<?php echo lang('reports_deleted_sales'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_deliveries', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>	
						<option  value="deliveries"><i class="icon ti-truck"></i>	<?php echo lang('reports_deliveries'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_discounts', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="discounts"><i class="icon ti-wand"></i>	<?php echo lang('reports_discounts'); ?></option>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_employees', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="employees"><i class="icon ti-id-badge"></i>	<?php echo lang('reports_employees'); ?></option>
					<?php } ?>
					
               <?php
					if ($this->Employee->has_module_action_permission('reports', 'view_expenses', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="expenses"><i class="icon ti-money"></i>	<?php echo lang('reports_expenses'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_giftcards', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="giftcards"><i class="icon ti-credit-card"></i>	<?php echo lang('reports_giftcards'); ?></option>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_inventory_reports', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>					
						<option  value="inventory"><i class="icon ti-bar-chart"></i>	<?php echo lang('reports_inventory_reports'); ?></option>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_invoices_reports', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="invoices"><i class="icon ti-bar-chart"></i>	<?php echo lang('reports_invoices_reports'); ?></option>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_item_kits', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>					
						<option  value="item-kits"><i class="icon ti-harddrives"></i>	<?php echo lang('module_item_kits'); ?></option>
					<?php } ?>


					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_items', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>					
						<option  value="items"><i class="icon ti-harddrive"></i>	<?php echo lang('reports_items'); ?></option>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_manufacturers', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="manufacturers"><i class="icon ti-layout-grid3"></i>	<?php echo lang('reports_manufacturers'); ?></option>
					<?php } ?>


					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_payments', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>					
						<option  value="payments"><i class="icon ti-money"></i>	<?php echo lang('common_payments'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_price_rules', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>					
						<option  value="price_rules"><i class="icon ti-harddrive"></i>	<?php echo lang('reports_price_rules'); ?></option>
					<?php } ?>
					
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_profit_and_loss', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="profit-and-loss"><i class="icon ti-shopping-cart-full"></i>	<?php echo lang('reports_profit_and_loss'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_receivings', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="receivings"><i class="icon ti-cloud-down"></i>	<?php echo lang('reports_receivings'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_register_log', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<?php 
						$track_payment_types =  $this->config->item('track_payment_types') ? unserialize($this->config->item('track_payment_types')) : array();
						if ($this->config->item('track_payment_types') && !empty($track_payment_types)) { ?>
							<option  value="register-log"><i class="icon ti-search"></i>	<?php echo lang('reports_register_log_title'); ?></option>
						<?php } ?>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_registers', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
							<option  value="registers"><i class="icon ti-search"></i>	<?php echo lang('reports_registers'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_sales', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="sales"><i class="icon ti-shopping-cart"></i>	<?php echo lang('reports_sales'); ?></option>

						<option  value="work_order"><i class="icon ti-shopping-cart"></i>	<?php echo lang('reports_work_order'); ?></option>


					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_store_account', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<?php if($this->config->item('customers_store_accounts') || $this->config->item('suppliers_store_accounts')) { ?>
							<option  value="store-accounts"><i class="icon ti-credit-card"></i>	<?php echo lang('reports_store_account'); ?></option>
						<?php } ?>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_suppliers', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="suppliers"><i class="icon ti-download"></i>	<?php echo lang('reports_suppliers'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_suspended_sales', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="suspended_sales"><i class="icon ti-download"></i>	<?php echo lang('reports_suspended_sales'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_tags', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="tags"><i class="icon ti-layout-grid3"></i>	<?php echo lang('common_tags'); ?></option>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_taxes', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="taxes"><i class="icon ti-agenda"></i>	<?php echo lang('reports_taxes'); ?></option>
					<?php } ?>
					

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_tiers', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<option  value="tiers"><i class="icon ti-stats-up"></i>	<?php echo lang('reports_tiers'); ?></option>
					<?php } ?>

					<?php
					if ($this->config->item('timeclock'))
					{
						if ($this->Employee->has_module_action_permission('reports', 'view_timeclock', $this->Employee->get_logged_in_employee_info()->person_id))
						{
							?>
							<option  value="timeclock"><i class="icon ti-bell"></i>	<?php echo lang('employees_timeclock'); ?></option>
							<?php } ?>
					
					<?php } ?> 
                </select>

                <select id="city-dropdown">
                    <option value="">Select Report</option>
                    <!-- Cities will be added here based on the selected country -->
                </select>


                
            </div>

            <div class="row" id="options" >
                <div class="col-md-12">
                    <div class="py-5 mb-5">
                        <div class="rounded border p-10">
						<form class="form-horizontal form-horizontal-mobiles" id="report_input_form" method="get"
                    action="<?php echo site_url('reports/generate/'.$report); ?>">
                            <div class="mb-10">
                                <div class="form-check" data-keyword="<?php echo H(lang('config_keyword_payment')) ?>">
								<?php 
					$this->load->helper('view');
					foreach($input_params as $input_param) 
					{
							load_cleaned_view('reports/inputs/'.$input_param['view'],$input_param);
					} 
					?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</div>
<script>
  $(document).ready(function(){
    var moduleToReports = {
   
    "categories": ['<?php echo lang('categories_graphical_reports'); ?>' ,  '<?php echo lang('categories_summary_reports'); ?>'],

    "discounts": ['<?php echo lang('discounts_summary_reports'); ?>'],
    "closeout": [ '<?php echo lang('closeout_summary_reports'); ?>', '<?php echo lang('closeout_condensed_summary'); ?>' ],


    "customers": ['<?php echo lang('reports_graphical_reports'); ?>', '<?php echo lang('reports_summary_reports'); ?>' , '<?php echo lang('reports_detailed_reports'); ?>' ,'<?php echo lang('reports_customer_series'); ?>' , '<?php echo lang('reports_new_customers'); ?>', '<?php echo lang('reports_zip_code_report'); ?>' ,'<?php echo lang('reports_graphical_zip_code_report'); ?>', '<?php echo lang('reports_non_taxable_customers'); ?>'],

    "items": ['<?php echo lang('items_graphical_reports'); ?>' , '<?php echo lang('items_summary_reports'); ?>' , '<?php echo lang('items_enhanced_summary_reports') ?>' ,'<?php echo lang('items_top_sellers'); ?>' , '<?php echo lang('reports_items_worse_sellers'); ?>','<?php echo lang('reports_price_variance_report'); ?>', '<?php echo lang('reports_pricing_history'); ?>', '<?php echo lang('reports_serial_numbers_sold'); ?>', '<?php echo lang('reports_serial_number_history'); ?>'],

    "tags": ['<?php echo lang('tags_graphical_reports'); ?>' , '<?php echo lang('tags_summary_reports'); ?>' ],

    "manufacturers": ['<?php echo lang('manufacturers_graphical_reports'); ?>' , '<?php echo lang('manufacturers_summary_reports'); ?>'],

    "item-kits": ['<?php echo lang('item_kits_graphical_reports'); ?>' , '<?php echo lang('item_kits_summary_reports'); ?>' , '<?php echo lang('reports_price_variance_report'); ?>' , '<?php echo lang('item_kits_pricing_history'); ?>'],
    
    "suppliers": ['<?php echo lang('suppliers_graphical_reports'); ?>' , '<?php echo lang('suppliers_summary_reports'); ?>' , '<?php echo lang('suppliers_detailed_reports'); ?>' , '<?php echo lang('suppliers_summary_items'); ?>' , '<?php echo lang('suppliers_graphical_receiving_reports'); ?>' , '<?php echo lang('suppliers_summary_receiving_reports'); ?>' , '<?php echo lang('suppliers_detailed_receiving_reports'); ?>'],


 
    "payments": ['<?php echo lang('payments_graphical_reports'); ?>' , '<?php echo lang('payments_summary_reports'); ?>' , '<?php echo lang('payments_summary_payments_registers'); ?>' , '<?php echo lang('payments_detailed_reports'); ?>'],

    "suspended_sales": ['<?php echo lang('suspended_sales_detailed_reports'); ?>' , '<?php echo lang('suspended_sales_layaway_statements'); ?>'],


    "taxes": ['<?php echo lang('taxes_graphical_reports'); ?>' , '<?php echo lang('taxes_summary_reports'); ?>'],

    
    "timeclock": ['<?php echo lang('timeclock_time_off_reports'); ?>' , '<?php echo lang('timeclock_summary_reports'); ?>' , '<?php echo lang('timeclock_detailed_reports'); ?>'],


    "tiers": ['<?php echo lang('tiers_summary_reports'); ?>'],

    "receivings": ['<?php echo lang('receivings_summary_categories'); ?>' , '<?php echo lang('receivings_transfers'); ?>' , '<?php echo lang('receivings_detailed_reports'); ?>', '<?php echo lang('receivings_suspended_receivings'); ?>', '<?php echo lang('receivings_deleted_recv_reports'); ?>' , '<?php echo lang('receivings_summary_taxes_reports'); ?>', '<?php echo lang('receivings_graphical_summary_taxes_reports'); ?>' , '<?php echo lang('receivings_cheapest_supplier'); ?>' ,'<?php echo lang('items_receivings_graphical_reports'); ?>', '<?php echo lang('items_receivings_summary_reports'); ?>', '<?php echo lang('receivings_graphical_reports_payments'); ?>' , '<?php echo lang('receivings_summary_reports_payments'); ?>' ,' <?php echo lang('receivings_detailed_reports_payments'); ?>' ],


    "inventory": ['<?php echo lang('inventory_low_inventory'); ?>' , '<?php echo lang('inventory_inventory_summary'); ?>' , '<?php echo lang('reports_inventory_at_past_date'); ?>', '<?php echo lang('inventory_detailed_reports'); ?>' , '<?php echo lang('inventory_summary_count_report'); ?>', '<?php echo lang('inventory_detailed_count_report'); ?>' , '<?php echo lang('inventory_expiring_items_report'); ?>' , '<?php echo lang('inventory_damaged_items_report'); ?>', ],

    
    "invoices": ['<?php echo lang('reports_customer_invoices'); ?>' , '<?php echo lang('reports_supplier_invoices'); ?>' ],

    "giftcards": ['<?php echo lang('giftcards_summary_reports'); ?>' , '<?php echo lang('giftcards_detailed_reports'); ?>' , '<?php echo lang('giftcards_audit_report'); ?>' , '<?php echo lang('gift_card_sales_reports'); ?>'],

    "store-accounts": ['<?php echo lang('customer_store_account_statements'); ?>' , '<?php echo lang('customer_summary_reports'); ?>' , '<?php echo lang('customer_detailed_reports'); ?>', '<?php echo lang('customer_activity'); ?>', '<?php echo lang('customer_activity_summary_report'); ?>' , '<?php echo lang('customer_outstanding_sales'); ?>','<?php echo lang('suppliers_store_account_statements'); ?>' , '<?php echo lang('suppliers_summary_reports'); ?>' , '<?php echo lang('suppliers_detailed_reports'); ?>', '<?php echo lang('suppliers_activity'); ?>', '<?php echo lang('suppliers_activity_summary_report'); ?>' , '<?php echo lang('suppliers_outstanding_sales'); ?>'],

    "profit-and-loss": ['<?php echo lang('profit_and_loss_summary_reports'); ?>' , '<?php echo lang('profit_and_loss_detailed_reports'); ?>'],


    "expenses": ['<?php echo lang('expenses_summary_reports'); ?>' , '<?php echo lang('expenses_detailed_reports'); ?>'],


    "commissions": ['<?php echo lang('commissions_graphical_reports'); ?>' , '<?php echo lang('commissions_summary_reports'); ?>' , '<?php echo lang('commissions_detailed_reports'); ?>'],


    "employees": ['<?php echo lang('employees_graphical_reports'); ?>' , '<?php echo lang('employees_summary_reports'); ?>' , '<?php echo lang('employees_detailed_reports'); ?>'],


    "sales": ['<?php echo lang('sales_summary_journal'); ?>' , '<?php echo lang('sales_graphical_reports'); ?>' , '<?php echo lang('sales_summary_reports'); ?>' , '<?php echo lang('sales_detailed_reports'); ?>', '<?php echo lang('sales_day_of_week_report'); ?>' , '<?php echo lang('sales_summary_sales_time_reports'); ?>', '<?php echo lang('sales_summary_sales_graphical_time_reports'); ?>' , '<?php echo lang('sales_ecommerce'); ?>' , '<?php echo lang('sales_locations'); ?>' , '<?php echo lang('sales_tips'); ?>' , '<?php echo lang('sales_search_last_4_credit_card'); ?>'],


    "work_order":  ['<?php echo lang('work_order_summary_journal'); ?>' , '<?php echo lang('work_order_graphical_reports'); ?>' , '<?php echo lang('work_order_summary_reports'); ?>' , '<?php echo lang('work_order_detailed_reports'); ?>', '<?php echo lang('work_order_day_of_week_report'); ?>' , '<?php echo lang('work_order_summary_sales_time_reports'); ?>', '<?php echo lang('work_order_summary_sales_graphical_time_reports'); ?>' , '<?php echo lang('work_order_ecommerce'); ?>' , '<?php echo lang('work_order_locations'); ?>' , '<?php echo lang('work_order_tips'); ?>' , '<?php echo lang('work_order_search_last_4_credit_card'); ?>'],



    "price_rules": ['<?php echo lang('price_rules_summary_reports'); ?>'],

    "deleted-sales": ['<?php echo lang('deleted_sales_detailed_reports'); ?>' , '<?php echo lang('deleted_sales_voided_transactions'); ?>'],

    "deliveries": ['<?php echo lang('deliveries_detailed_reports'); ?>'],

    "custom-report": [],
    "appointments": ['<?php echo lang('appointments_summary_reports'); ?>' , '<?php echo lang('appointments_graphical_reports'); ?>'],
 

    "register-log": [ '<?php echo lang('register_log_detailed_reports'); ?>'],

  


    "registers": ['<?php echo lang('registers_summary_reports'); ?>' , '<?php echo lang('registers_graphical_reports'); ?>'],
};
    $url='<?php echo site_url('reports/generate/'); ?>';


    var cityToURL = {


        

        //registers
        "<?php echo lang('registers_summary_reports'); ?>": $url+'summary_registers',
        "<?php echo lang('registers_graphical_reports'); ?>": $url+'graphical_summary_registers',
        //end registers

          //register-log
        "<?php echo lang('register_log_detailed_reports'); ?>": $url+'detailed_register_log',
        //end register-log




        //appointments
        "<?php echo lang('appointments_summary_reports'); ?>": $url+'summary_appointments',
        "<?php echo lang('appointments_graphical_reports'); ?>": $url+'detailed_appointments',
        //end appointments


         //deliveries
        "<?php echo lang('deliveries_detailed_reports'); ?>": $url+'detailed_deliveries',
        //end deliveries


        //price_rules
        "<?php echo lang('price_rules_summary_reports'); ?>": $url+'summary_price_rules',
        //end price_rules
        
        //deleted_sales
        "<?php echo lang('deleted_sales_detailed_reports'); ?>": $url+'deleted_sales',
        "<?php echo lang('deleted_sales_voided_transactions'); ?>": $url+'voided_transactions',
        //end deleted_sales


        //price_rules
        "<?php echo lang('price_rules_summary_reports'); ?>": $url+'summary_price_rules',
        //end price_rules


        //work_order
        "<?php echo lang('work_order_summary_journal'); ?>": $url+'summary_journal_work_order',
        "<?php echo lang('work_order_graphical_reports'); ?>": $url+'graphical_summary_work_order',
        "<?php echo lang('work_order_summary_reports'); ?>": $url+'summary_work_order',
        "<?php echo lang('work_order_detailed_reports'); ?>": $url+'detailed_work_order',
        "<?php echo lang('work_order_day_of_week_report'); ?>": $url+'summary_sales_day_of_week_work_order',
        "<?php echo lang('work_order_summary_work_order_time_reports'); ?>": $url+'summary_sales_time_work_order',
        "<?php echo lang('work_order_summary_work_order_graphical_time_reports'); ?>": $url+'graphical_summary_sales_time_work_order',
        "<?php echo lang('work_order_ecommerce'); ?>": $url+'detailed_ecommerce_sales_work_order',
        "<?php echo lang('work_order_locations'); ?>": $url+'summary_sales_locations_work_order',
        "<?php echo lang('work_order_tips'); ?>": $url+'summary_tips_work_order',
        "<?php echo lang('work_order_search_last_4_credit_card'); ?>": $url+'detailed_last_4_cc_work_order',
       
        //end work_order

        //sales
        "<?php echo lang('sales_summary_journal'); ?>": $url+'summary_journal',
        "<?php echo lang('sales_graphical_reports'); ?>": $url+'graphical_summary_sales',
        "<?php echo lang('sales_summary_reports'); ?>": $url+'summary_sales',
        "<?php echo lang('sales_detailed_reports'); ?>": $url+'detailed_sales',
        "<?php echo lang('sales_day_of_week_report'); ?>": $url+'summary_sales_day_of_week',
        "<?php echo lang('sales_summary_sales_time_reports'); ?>": $url+'summary_sales_time',
        "<?php echo lang('sales_summary_sales_graphical_time_reports'); ?>": $url+'graphical_summary_sales_time',
        "<?php echo lang('sales_ecommerce'); ?>": $url+'detailed_ecommerce_sales',
        "<?php echo lang('sales_locations'); ?>": $url+'summary_sales_locations',
        "<?php echo lang('sales_tips'); ?>": $url+'summary_tips',
        "<?php echo lang('sales_search_last_4_credit_card'); ?>": $url+'detailed_last_4_cc',
       
        //end sales



        //employees
        "<?php echo lang('employees_graphical_reports'); ?>": $url+'graphical_summary_employees',
        "<?php echo lang('employees_summary_reports'); ?>": $url+'summary_employees',
        "<?php echo lang('employees_detailed_reports'); ?>": $url+'specific_employee',
        //end employees

        //commissions
        "<?php echo lang('commissions_graphical_reports'); ?>": $url+'graphical_summary_commissions',
        "<?php echo lang('commissions_summary_reports'); ?>": $url+'summary_commissions',
        "<?php echo lang('commissions_detailed_reports'); ?>": $url+'detailed_commissions',
        //end commissions

        //expenses
        "<?php echo lang('expenses_summary_reports'); ?>": $url+'summary_expenses',
        "<?php echo lang('expenses_detailed_reports'); ?>": $url+'detailed_expenses',
        //end expenses

        //profit-and-loss
        "<?php echo lang('profit_and_loss_summary_reports'); ?>": $url+'summary_profit_and_loss',
        "<?php echo lang('profit_and_loss_detailed_reports'); ?>": $url+'detailed_profit_and_loss',
        //end profit-and-loss

        //store-accounts
        "<?php echo lang('customer_store_account_statements'); ?>": $url+'store_account_statements',
        "<?php echo lang('customer_summary_reports'); ?>": $url+'summary_store_accounts',
        "<?php echo lang('customer_detailed_reports'); ?>": $url+'specific_customer_store_account',
        "<?php echo lang('customer_activity'); ?>": $url+'store_account_activity',
        "<?php echo lang('customer_activity_summary_report'); ?>": $url+'store_account_activity_summary',
        "<?php echo lang('customer_outstanding_sales'); ?>": $url+'store_account_outstanding',
        "<?php echo lang('suppliers_store_account_statements'); ?>": $url+'supplier_store_account_statements',
        "<?php echo lang('suppliers_summary_reports'); ?>": $url+'supplier_summary_store_accounts',
        "<?php echo lang('suppliers_detailed_reports'); ?>": $url+'supplier_specific_store_account',
        "<?php echo lang('suppliers_activity'); ?>": $url+'supplier_store_account_activity',
        "<?php echo lang('suppliers_activity_summary_report'); ?>": $url+'supplier_store_account_activity_summary',
        "<?php echo lang('suppliers_outstanding_sales'); ?>": $url+'supplier_store_account_outstanding',
        //end store-accounts



        //giftcards
        "<?php echo lang('giftcards_summary_reports'); ?>": $url+'summary_giftcards',
        "<?php echo lang('giftcards_detailed_reports'); ?>": $url+'detailed_giftcards',
        "<?php echo lang('giftcards_audit_report'); ?>": $url+'giftcard_audit',
        "<?php echo lang('gift_card_sales_reports'); ?>": $url+'summary_giftcard_sales',
        //end giftcards


        //invoices
        "<?php echo lang('reports_customer_invoices'); ?>": $url+'customer_invoices',
        "<?php echo lang('reports_supplier_invoices'); ?>": $url+'supplier_invoices',
        //end invoices


        //inventory
        "<?php echo lang('inventory_low_inventory'); ?>": $url+'inventory_low',
        "<?php echo lang('inventory_inventory_summary'); ?>": $url+'inventory_summary',
        "<?php echo lang('reports_inventory_at_past_date'); ?>": $url+'reports_inventory_at_past_date',
        "<?php echo lang('inventory_detailed_reports'); ?>": $url+'detailed_inventory',
        "<?php echo lang('inventory_summary_count_report'); ?>": $url+'summary_count_report',
        "<?php echo lang('inventory_detailed_count_report'); ?>": $url+'detailed_count_report',
        "<?php echo lang('inventory_expiring_items_report'); ?>": $url+'expiring_inventory',
        "<?php echo lang('inventory_damaged_items_report'); ?>": $url+'detailed_damaged_items',
        //end inventory

        //receivings
        "<?php echo lang('receivings_summary_categories'); ?>": $url+'summary_categories_receivings',
        "<?php echo lang('receivings_transfers'); ?>": $url+'transfers',
        "<?php echo lang('receivings_detailed_reports'); ?>": $url+'detailed_receivings',
        "<?php echo lang('receivings_suspended_receivings'); ?>": $url+'detailed_suspended_receivings',
        "<?php echo lang('receivings_deleted_recv_reports'); ?>": $url+'deleted_receivings',
        "<?php echo lang('receivings_summary_taxes_reports'); ?>": $url+'summary_taxes_receivings',
        "<?php echo lang('receivings_graphical_summary_taxes_reports'); ?>": $url+'graphical_summary_taxes_receivings',
        "<?php echo lang('receivings_cheapest_supplier'); ?>": $url+'cheapest_supplier',
        "<?php echo lang('items_receivings_graphical_reports'); ?>": $url+'graphical_summary_items_receivings',
        "<?php echo lang('items_receivings_summary_reports'); ?>": $url+'summary_items_receivings',
        "<?php echo lang('receivings_graphical_reports_payments'); ?>": $url+'receivings_graphical_summary_payments',
        "<?php echo lang('receivings_summary_reports_payments'); ?>": $url+'summary_items_receivings',
        "<?php echo lang('receivings_detailed_reports_payments'); ?>": $url+'receivings_graphical_summary_payments',
        //end receivings

        //tiers
        "<?php echo lang('tiers_summary_reports'); ?>": $url+'summary_tiers',
        //end tiers

        //timeclock
        "<?php echo lang('timeclock_time_off_reports'); ?>": $url+'time_off',
        "<?php echo lang('timeclock_summary_reports'); ?>": $url+'summary_timeclock',
        "<?php echo lang('timeclock_detailed_reports'); ?>": $url+'detailed_timeclock',
        //end timeclock

        //suspended_sales
        "<?php echo lang('taxes_graphical_reports'); ?>": $url+'graphical_summary_taxes',
        "<?php echo lang('taxes_summary_reports'); ?>": $url+'summary_taxes',
        //end suspended_sales

        //suspended_sales
        "<?php echo lang('suspended_sales_detailed_reports'); ?>": $url+'detailed_suspended_sales',
        "<?php echo lang('suspended_sales_layaway_statements'); ?>": $url+'layaway_statements',
        //end suspended_sales

          //suppliers
        "<?php echo lang('suppliers_graphical_reports'); ?>": $url+'graphical_summary_suppliers',
        "<?php echo lang('suppliers_summary_reports'); ?>": $url+'summary_suppliers',
        "<?php echo lang('suppliers_detailed_reports'); ?>": $url+'specific_supplier',
        "<?php echo lang('suppliers_summary_items'); ?>": $url+'specific_supplier_summary',
        "<?php echo lang('suppliers_graphical_receiving_reports'); ?>": $url+'graphical_summary_suppliers_receivings',
        "<?php echo lang('suppliers_summary_receiving_reports'); ?>": $url+'summary_suppliers_receivings',
        "<?php echo lang('suppliers_detailed_receiving_reports'); ?>": $url+'specific_supplier_receivings',
        //end suppliers
        

        //payments
        "<?php echo lang('payments_graphical_reports'); ?>": $url+'graphical_summary_payments',
        "<?php echo lang('payments_summary_reports'); ?>": $url+'summary_payments',
        "<?php echo lang('payments_summary_payments_registers'); ?>": $url+'summary_payments_registers',
        "<?php echo lang('payments_detailed_reports'); ?>": $url+'detailed_payments',
        //end payments

          //item_kits
          "<?php echo lang('item_kits_graphical_reports'); ?>": $url+'graphical_summary_item_kits',
        "<?php echo lang('item_kits_summary_reports'); ?>": $url+'summary_item_kits',
        "<?php echo lang('item_kits_pricing_history'); ?>": $url+'item_kit_price_history',
        "<?php echo lang('reports_price_variance_report'); ?>": $url+'summary_item_kits_variance',
        //end item_kits


        //manufacturers
        "<?php echo lang('manufacturers_graphical_reports'); ?>": $url+'graphical_summary_manufacturers',
        "<?php echo lang('manufacturers_summary_reports'); ?>": $url+'summary_manufacturers',
        //end manufacturers

         //items
         "<?php echo lang('items_graphical_reports'); ?>": $url+'graphical_summary_items',
         "<?php echo lang('items_summary_reports'); ?>": $url+'summary_items',
         "<?php echo lang('items_enhanced_summary_reports'); ?>": $url+'enhanced_summary_items',
         "<?php echo lang('items_top_sellers'); ?>": $url+'top_sellers',
         "<?php echo lang('reports_items_worse_sellers'); ?>": $url+'worse_sellers',
         "<?php echo lang('reports_price_variance_report'); ?>": $url+'summary_items_variance',
         "<?php echo lang('reports_pricing_history'); ?>": $url+'item_price_history',
         "<?php echo lang('reports_serial_numbers_sold'); ?>": $url+'serial_numbers_sold',
         "<?php echo lang('reports_serial_number_history'); ?>": $url+'serial_number_history',
        //end items


        //discounts
        "<?php echo lang('discounts_summary_reports'); ?>": $url+'summary_discounts',
        //end discounts

          //categories
          "<?php echo lang('categories_graphical_reports'); ?>": $url+'graphical_summary_categories',
        "<?php echo lang('categories_summary_reports'); ?>": $url+'summary_categories',
        //end categories

         //tags
         "<?php echo lang('tags_graphical_reports'); ?>": $url+'graphical_summary_tags',
        "<?php echo lang('tags_summary_reports'); ?>": $url+'summary_tags',
        //end tags

        //closeout
        "<?php echo lang('closeout_summary_reports'); ?>": $url+'closeout_condensed',
        "<?php echo lang('closeout_condensed_summary'); ?>": $url+'reports_condensed_summary',
        //end closeout

        //customers
        "<?php echo lang('reports_graphical_reports'); ?>": $url+'graphical_summary_customers',
        "<?php echo lang('reports_summary_reports'); ?>": $url+'summary_customers',
        "<?php echo lang('reports_detailed_reports'); ?>": $url+'specific_customer',
        "<?php echo lang('reports_customer_series'); ?>": $url+'customers_series',
        "<?php echo lang('reports_new_customers'); ?>": $url+'new_customers',
        "<?php echo lang('reports_zip_code_report'); ?>": $url+'summary_customers_zip',
        "<?php echo lang('reports_graphical_zip_code_report'); ?>": $url+'graphical_customers_zip',
        "<?php echo lang('reports_non_taxable_customers'); ?>": $url+'summary_non_taxable_customers',
        //end customers


    };

    $("#country-dropdown").change(function() {
        var selectedCountry = $(this).val();
        var cities = moduleToReports[selectedCountry] || [];

        var cityDropdown = $("#city-dropdown");
        cityDropdown.empty(); // Remove existing options
        cityDropdown.append('<option value="">Select Report</option>');
        
        cities.forEach(function(city) {
            cityDropdown.append('<option value="' + city + '">' + city + '</option>');
        });
    });

    $("#city-dropdown").change(function() {
        var selectedCity = $(this).val();
        var cityURL = cityToURL[selectedCity];

        if (cityURL) {
            window.location.href = cityURL;
        }
    });
});
$('#generate_report').click(function(e) {
    e.preventDefault();
    $('#options').slideToggle(function() {
        $('#report_input_form').submit();
    });
});
</script>