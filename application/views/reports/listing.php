<?php $this->load->view("partial/header"); ?>
<div class="row report-listing">
	<div class="col-md-4  ">
		<div class="panel">
			<div class="panel-body">
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 parent-list">
					<a href="#" class="list-group-item text-gray-600  fw-bold" id="saved"><i class="icon ti-heart" style="color: #fb5d5d"></i>	<?php echo lang('reports_saved_reports'); ?></a>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_appointments', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="appointments"><i class="icon ti-calendar"></i>	<?php echo lang('reports_appointments'); ?></a>
					<?php } ?>
					
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_categories', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="categories"><i class="icon ti-layout-grid3"></i>	<?php echo lang('reports_categories'); ?></a>
					<?php } ?>
					

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_closeout', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="closeout"><i class="icon ti-close"></i>	<?php echo lang('reports_closeout'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_sales_generator', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="custom-report">
							<i class="icon ti-search"></i>	<?php echo lang('custom_report'); ?>
						</a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_commissions', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="commissions"><i class="icon ti-money"></i>	<?php echo lang('reports_commission'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_customers', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="customers"><i class="icon ti-user"></i>	<?php echo lang('reports_customers'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_deleted_sales', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>	
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="deleted-sales"><i class="icon ti-trash"></i>	<?php echo lang('reports_deleted_sales'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_deliveries', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>	
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="deliveries"><i class="icon ti-truck"></i>	<?php echo lang('reports_deliveries'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_discounts', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="discounts"><i class="icon ti-wand"></i>	<?php echo lang('reports_discounts'); ?></a>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_employees', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="employees"><i class="icon ti-id-badge"></i>	<?php echo lang('reports_employees'); ?></a>
					<?php } ?>
					
               <?php
					if ($this->Employee->has_module_action_permission('reports', 'view_expenses', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="expenses"><i class="icon ti-money"></i>	<?php echo lang('reports_expenses'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_giftcards', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="giftcards"><i class="icon ti-credit-card"></i>	<?php echo lang('reports_giftcards'); ?></a>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_inventory_reports', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>					
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="inventory"><i class="icon ti-bar-chart"></i>	<?php echo lang('reports_inventory_reports'); ?></a>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_invoices_reports', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="invoices"><i class="icon ti-bar-chart"></i>	<?php echo lang('reports_invoices_reports'); ?></a>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_item_kits', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>					
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="item-kits"><i class="icon ti-harddrives"></i>	<?php echo lang('module_item_kits'); ?></a>
					<?php } ?>


					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_items', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>					
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="items"><i class="icon ti-harddrive"></i>	<?php echo lang('reports_items'); ?></a>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_manufacturers', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="manufacturers"><i class="icon ti-layout-grid3"></i>	<?php echo lang('reports_manufacturers'); ?></a>
					<?php } ?>


					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_payments', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>					
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="payments"><i class="icon ti-money"></i>	<?php echo lang('common_payments'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_price_rules', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>					
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="price_rules"><i class="icon ti-harddrive"></i>	<?php echo lang('reports_price_rules'); ?></a>
					<?php } ?>
					
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_profit_and_loss', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="profit-and-loss"><i class="icon ti-shopping-cart-full"></i>	<?php echo lang('reports_profit_and_loss'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_receivings', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="receivings"><i class="icon ti-cloud-down"></i>	<?php echo lang('reports_receivings'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_register_log', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<?php 
						$track_payment_types =  $this->config->item('track_payment_types') ? unserialize($this->config->item('track_payment_types')) : array();
						if ($this->config->item('track_payment_types') && !empty($track_payment_types)) { ?>
							<a href="#" class="list-group-item text-gray-600  fw-bold" id="register-log"><i class="icon ti-search"></i>	<?php echo lang('reports_register_log_title'); ?></a>
						<?php } ?>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_registers', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
							<a href="#" class="list-group-item text-gray-600  fw-bold" id="registers"><i class="icon ti-search"></i>	<?php echo lang('reports_registers'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_sales', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="sales"><i class="icon ti-shopping-cart"></i>	<?php echo lang('reports_sales'); ?></a>

						<a href="#" class="list-group-item text-gray-600  fw-bold" id="work_order"><i class="icon ti-shopping-cart"></i>	<?php echo lang('reports_work_order'); ?></a>


					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_store_account', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<?php if($this->config->item('customers_store_accounts') || $this->config->item('suppliers_store_accounts')) { ?>
							<a href="#" class="list-group-item text-gray-600  fw-bold" id="store-accounts"><i class="icon ti-credit-card"></i>	<?php echo lang('reports_store_account'); ?></a>
						<?php } ?>
					<?php } ?>

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_suppliers', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="suppliers"><i class="icon ti-download"></i>	<?php echo lang('reports_suppliers'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_suspended_sales', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="suspended_sales"><i class="icon ti-download"></i>	<?php echo lang('reports_suspended_sales'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_tags', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="tags"><i class="icon ti-layout-grid3"></i>	<?php echo lang('common_tags'); ?></a>
					<?php } ?>
					
					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_taxes', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="taxes"><i class="icon ti-agenda"></i>	<?php echo lang('reports_taxes'); ?></a>
					<?php } ?>
					

					<?php
					if ($this->Employee->has_module_action_permission('reports', 'view_tiers', $this->Employee->get_logged_in_employee_info()->person_id))
					{
					?>
						<a href="#" class="list-group-item text-gray-600  fw-bold" id="tiers"><i class="icon ti-stats-up"></i>	<?php echo lang('reports_tiers'); ?></a>
					<?php } ?>

					<?php
					if ($this->config->item('timeclock'))
					{
						if ($this->Employee->has_module_action_permission('reports', 'view_timeclock', $this->Employee->get_logged_in_employee_info()->person_id))
						{
							?>
							<a href="#" class="list-group-item text-gray-600  fw-bold" id="timeclock"><i class="icon ti-bell"></i>	<?php echo lang('employees_timeclock'); ?></a>
							<?php } ?>
					
					<?php } ?> 
					
				</div>
			</div>
		</div> <!-- /panel -->
	</div>
	<div class="col-md-12" id="report_selection">
		<div class="panel">
			<div class="panel-body child-list">
			<h3 id="right_heading" class="page-header text-info"><i class="icon ti-angle-double-left"></i><?php echo lang('reports_make_a_selection')?></h3>
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 custom-report hidden ">
					<a href="<?php echo site_url('reports/sales_generator');?>" class="list-group-item text-gray-600  fw-bold ">
						<i class="icon ti-search report-icon"></i>  <?php echo lang('reports_sales_search'); ?>
					</a>
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 saved ">
					<?php 
					$favorites = Report::get_saved_reports();
					if(count($favorites) > 0)
					{
						?>
						<table style="width: 100%;border: none">
							<tbody id="favorites_tbody">
						<?php
						foreach ($favorites as $key => $report)
						{
								$report_url = $report['url'];
								$base_report_url = $report['url'];
								$report_url.=(parse_url($report['url'], PHP_URL_QUERY) ? '&' : '?') . "key=$key";
										?>
										<tr><td>
								    <a href="<?php echo site_url($report_url);?>" class="list-group-item text-gray-600  fw-bold clearfix report_url" style="border-color: #e9ecf2;" data-relative-url="<?php echo $base_report_url; ?>">
								      <span class="icon ti-heart" style="font-size: 16px;margin-right: 4px;color: #fb5d5d;"></span>
								      <span class="report_name"><?php echo $report['name']; ?></span>
								      <span class="pull-right">
								        <button data-url="<?php echo site_url("reports/delete_saved_report/".$key);?>" style="display:block;" class="remove_fav_report btn btn-xs btn-default">
								          <span class="ion-close"></span>
								        </button>
								      </span>
								    </a></td></tr>
										<?php 
						}
						?>
					</tbody>
				</table>
						<?php
					} else { ?>
						<div class="" role="alert"><?php echo lang('reports_no_favorites'); ?></div>
						
				<?php	} ?>
				</div>
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 customers ">
				<h4 class="text-info"><?php echo lang('Customer_Reports'); ?></h4>
				
					
					<?php if (can_display_graphical_report() ){ ?>
						<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/graphical_summary_customers');?>" ><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_customers');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/specific_customer');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/customers_series');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_customer_series'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/new_customers');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_new_customers'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_customers_zip');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_zip_code_report'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/graphical_customers_zip');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_graphical_zip_code_report'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_non_taxable_customers');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_non_taxable_customers'); ?></a>
					
					
				</div>

				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 commissions ">
				<h4 class="text-info"><?php echo lang('commissions_reports'); ?></h4>
					<?php if (can_display_graphical_report() ){ ?>
						<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/graphical_summary_commissions');?>" ><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_commissions');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_commissions');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 employees ">
					<?php if (can_display_graphical_report() ){ ?>
						<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/graphical_summary_employees');?>" ><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_employees');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/specific_employee');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>

				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 sales ">
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_journal');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_journal'); ?></a>
					
					<?php if (can_display_graphical_report() ){ ?>
						<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/graphical_summary_sales');?>" ><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_sales');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_sales');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_sales_day_of_week');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_day_of_week_report'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_sales_time');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_sales_time_reports'); ?></a>
					<?php if (can_display_graphical_report() ){ ?>
						<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/graphical_summary_sales_time');?>" ><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_summary_sales_graphical_time_reports'); ?></a>
					<?php } ?>
					<?php if ($this->config->item('ecommerce_platform')) { ?>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_ecommerce_sales');?>" ><i class="icon ti-calendar"></i> <?php echo lang('common_ecommerce'); ?></a>
					<?php } ?>
					
					<?php if ($this->Location->count_all() > 1) { ?>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_sales_locations');?>" ><i class="icon ti-receipt"></i> <?php echo lang('common_locations'); ?></a>
					<?php } ?>
					
					<?php if ($this->config->item('enable_tips')) { ?>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_tips');?>" ><i class="ion-cash"></i> <?php echo lang('common_tips'); ?></a>
					<?php } ?>
					
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_last_4_cc');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_search_last_4_credit_card'); ?></a>
					
					
				</div>

				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 work_order ">
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_journal_work_order');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_journal'); ?></a>
					
					<?php if (can_display_graphical_report() ){ ?>
						<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/graphical_summary_work_order');?>" ><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_work_order');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_work_order');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_sales_day_of_week_work_order');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_day_of_week_report'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_sales_time_work_order');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_sales_time_reports'); ?></a>
					<?php if (can_display_graphical_report() ){ ?>
						<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/graphical_summary_sales_time_work_order');?>" ><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_summary_sales_graphical_time_reports'); ?></a>
					<?php } ?>
					<?php if ($this->config->item('ecommerce_platform')) { ?>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_ecommerce_sales_work_order');?>" ><i class="icon ti-calendar"></i> <?php echo lang('common_ecommerce'); ?></a>
					<?php } ?>
					
					<?php if ($this->Location->count_all() > 1) { ?>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_sales_locations_work_order');?>" ><i class="icon ti-receipt"></i> <?php echo lang('common_locations'); ?></a>
					<?php } ?>
					
					<?php if ($this->config->item('enable_tips')) { ?>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_tips_work_order');?>" ><i class="ion-cash"></i> <?php echo lang('common_tips'); ?></a>
					<?php } ?>
					
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_last_4_cc_work_order');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_search_last_4_credit_card'); ?></a>
					
					
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 price_rules ">
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_price_rules');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
				</div>
				
				
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 deleted-sales ">
					<a href="<?php echo site_url('reports/generate/deleted_sales');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<?php
					if ($this->Location->get_info_for_key('enable_credit_card_processing') && $this->Location->get_info_for_key('credit_card_processor') == 'coreclear2')
					{
					?>
						<a href="<?php echo site_url('reports/generate/voided_transactions');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_voided_transactions'); ?></a>
					<?php } ?>
					
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 deliveries ">
					<a href="<?php echo site_url('reports/generate/detailed_deliveries');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>
				
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 registers ">
					<a href="<?php echo site_url('reports/generate/summary_registers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/graphical_summary_registers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 register-log ">
					<a href="<?php echo site_url('reports/generate/detailed_register_log');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>
				
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 appointments ">
					<a href="<?php echo site_url('reports/generate/summary_appointments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/detailed_appointments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					
				</div>
				
				
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 categories ">
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_categories');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_categories');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
				</div>
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 discounts ">
					<a href="<?php echo site_url('reports/generate/summary_discounts');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
				</div>
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 items ">
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_items');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_items');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/enhanced_summary_items');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_enhanced_summary_reports') ?></a>
					<a href="<?php echo site_url('reports/generate/top_sellers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_items_top_sellers'); ?></a>
					<a href="<?php echo site_url('reports/generate/worse_sellers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_items_worse_sellers'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_items_variance');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_price_variance_report'); ?></a>
					<a href="<?php echo site_url('reports/generate/item_price_history');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart"></i> <?php echo lang('reports_pricing_history'); ?></a>
					<a href="<?php echo site_url('reports/generate/serial_numbers_sold');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_serial_numbers_sold'); ?></a>
					<a href="<?php echo site_url('reports/generate/serial_number_history');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_serial_number_history'); ?></a>
					
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 manufacturers ">
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_manufacturers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_manufacturers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
				</div>
				
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 item-kits ">
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_item_kits');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_item_kits');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_item_kits_variance');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_price_variance_report'); ?></a>
				<a href="<?php echo site_url('reports/generate/item_kit_price_history');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart"></i> <?php echo lang('reports_pricing_history'); ?></a>
				
				</div>
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 payments ">
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_payments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_payments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/summary_payments_registers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_payments_registers'); ?></a>
					<a href="<?php echo site_url('reports/generate/detailed_payments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 suppliers ">
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_suppliers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_suppliers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/specific_supplier');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/specific_supplier_summary');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_summary_items'); ?></a>
					
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_suppliers_receivings');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_receiving_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_suppliers_receivings');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_receiving_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/specific_supplier_receivings');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_receiving_reports'); ?></a>
					
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 suspended_sales ">
					<a href="<?php echo site_url('reports/generate/detailed_suspended_sales');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/layaway_statements');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_layaway_statements'); ?></a>
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 taxes ">
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_taxes');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_taxes');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 timeclock ">
					<a href="<?php echo site_url('reports/generate/time_off');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_time_off_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/summary_timeclock');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>			
					<a href="<?php echo site_url('reports/generate/detailed_timeclock');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				
				</div>
				
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 tiers ">
					<a href="<?php echo site_url('reports/generate/summary_tiers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>			
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 receivings ">
					
					<a href="<?php echo site_url('reports/generate/summary_categories_receivings');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_categories'); ?></a>
					
					<?php if ($this->Location->count_all() > 1) { ?>
					<a href="<?php echo site_url('reports/generate/transfers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('common_transfers'); ?></a>
						<?php } ?>
						
					<a href="<?php echo site_url('reports/generate/detailed_receivings');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/detailed_suspended_receivings');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('common_suspended_receivings'); ?></a>
					<a href="<?php echo site_url('reports/generate/deleted_receivings');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_deleted_recv_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/summary_taxes_receivings');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_taxes_reports'); ?></a>
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_taxes_receivings');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_summary_taxes_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/cheapest_supplier');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-download"></i> <?php echo lang('reports_cheapest_supplier'); ?></a>
					<br>
					<h4 class="text-info"><?php echo lang('reports_items')?></h4>
					
						<?php if (can_display_graphical_report() ){ ?>
							<a href="<?php echo site_url('reports/generate/graphical_summary_items_receivings');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
						<?php } ?>
						<a href="<?php echo site_url('reports/generate/summary_items_receivings');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<br />
					<h4 class="text-info"><?php echo lang('reports_payments')?></h4>
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/receivings_graphical_summary_payments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/receivings_summary_payments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/receivings_detailed_payments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					
				</div>
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 inventory ">
					<a href="<?php echo site_url('reports/generate/inventory_low');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-stats-down"></i> <?php echo lang('reports_low_inventory'); ?></a>
					<a href="<?php echo site_url('reports/generate/inventory_summary');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_inventory_summary'); ?></a>
					<a href="<?php echo site_url('reports/generate/inventory_at_past_date');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_inventory_at_past_date'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_inventory');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/summary_count_report');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-stats-down"></i> <?php echo lang('reports_summary_count_report'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_count_report');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_count_report'); ?></a>
					<a href="<?php echo site_url('reports/generate/expiring_inventory');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_expiring_items_report'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_damaged_items');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_damaged_items_report'); ?></a>
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 invoices ">
					<a href="<?php echo site_url('reports/generate/customer_invoices');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-stats-down"></i> <?php echo lang('reports_customer_invoices'); ?></a>
					<a href="<?php echo site_url('reports/generate/supplier_invoices');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_supplier_invoices'); ?></a>
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 giftcards ">
					<a href="<?php echo site_url('reports/generate/summary_giftcards');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>			
					<a href="<?php echo site_url('reports/generate/detailed_giftcards');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/giftcard_audit');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_audit_report'); ?></a>
					<a href="<?php echo site_url('reports/generate/summary_giftcard_sales');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_gift_card_sales_reports'); ?></a>			
					
				</div>
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 store-accounts ">
					
					<?php if ($this->config->item('customers_store_accounts') && $this->Employee->has_module_action_permission('reports', 'view_store_account', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>					
						<h4 class="text-info"><?php echo lang('reports_customers')?></h4>
						<a href="<?php echo site_url('reports/generate/store_account_statements');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_store_account_statements'); ?></a>
						<a href="<?php echo site_url('reports/generate/summary_store_accounts');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
						<a href="<?php echo site_url('reports/generate/specific_customer_store_account');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
						<a href="<?php echo site_url('reports/generate/store_account_activity');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_activity'); ?></a>
						<a href="<?php echo site_url('reports/generate/store_account_activity_summary');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_activity_summary_report'); ?></a>
						<a href="<?php echo site_url('reports/generate/store_account_outstanding');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-stats-down"></i> <?php echo lang('reports_outstanding_sales'); ?></a>
					<?php } ?>
					<br>
					<?php if ($this->config->item('suppliers_store_accounts') && $this->Employee->has_module_action_permission('reports', 'view_store_account_suppliers', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
						<h4 class="text-info"><?php echo lang('reports_suppliers')?></h4>
						<a href="<?php echo site_url('reports/generate/supplier_store_account_statements');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_store_account_statements'); ?></a>
						<a href="<?php echo site_url('reports/generate/supplier_summary_store_accounts');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
						<a href="<?php echo site_url('reports/generate/supplier_specific_store_account');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
						<a href="<?php echo site_url('reports/generate/supplier_store_account_activity');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_activity'); ?></a>
						<a href="<?php echo site_url('reports/generate/supplier_store_account_activity_summary');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_activity_summary_report'); ?></a>	
						<a href="<?php echo site_url('reports/generate/supplier_store_account_outstanding');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-stats-down"></i> <?php echo lang('reports_outstanding_recv'); ?></a>
					<?php } ?>
				</div>
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 profit-and-loss ">
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_profit_and_loss');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_profit_and_loss');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 expenses ">
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_expenses');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_expenses');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 closeout ">
					<a href="<?php echo site_url('reports/generate/closeout');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/closeout_condensed');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_condensed_summary'); ?></a>
					
					<?php if ($cc_processor_class_name == 'CORECLEARBLOCKCHYPPROCESSOR' && $this->Employee->has_module_action_permission('sales', 'view_edit_transaction_history', $this->Employee->get_logged_in_employee_info()->person_id)) {?>				
						<a href="<?php echo site_url('sales/view_transaction_history');?>" class="list-group-item text-gray-600  fw-bold"><i class="ion-card"></i> <?php echo lang('sales_view_edit_transaction_history'); ?></a>
						<a href="<?php echo site_url('sales/batches');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('sales_batches'); ?></a>
					<?php } ?>
					
				</div>
				
				<div class="card hover-elevate-up shadow-sm parent-hover col-md-4 tags ">
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_tags');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_tags');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
				</div>
				
				
			</div>
		</div> <!-- /panel -->
	</div>
</div>

<script type="text/javascript">
 $('.parent-list a').click(function(e){
 	e.preventDefault();
 	$('.parent-list a').removeClass('active');
 	$(this).addClass('active');
 	var currentClass='.child-list .'+ $(this).attr("id");
 	$('.child-list .page-header').html($(this).html());
 	$('.child-list .list-group').addClass('hidden');
 	$(currentClass).removeClass('hidden');
	$('#right_heading').addClass('active');
	$('html, body').animate({
	    scrollTop: $("#report_selection").offset().top
	 }, 500);
 });
 
 $(".remove_fav_report").click(function(e)
{
	e.preventDefault();
	var $that = $(this);
	
	bootbox.confirm(<?php echo json_encode(lang('reports_delete_confirm')); ?>, function(response)
	{
		if (response)
		{
			$.get($that.data('url'), function()
			{
				$that.parent().parent().fadeOut('fast');
			});
		}
	});
	
});

$("#favorites_tbody").sortable(
	{
	  update: function( event, ui ) {
			
			var reports = [];
			$("#favorites_tbody tr").each(function(index,ele){
			
				reports.push({name:$(ele).find('.report_name').text(), url: $(ele).find('.report_url').data('relative-url')});
			});
			
			$.post(<?php echo json_encode(site_url('reports/save_reports')); ?>,{reports: reports});
	  }
	}
);
 </script>


<?php $this->load->view("partial/footer"); ?>