<?php $this->load->view("partial/header"); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo site_url(); ?>assets/css_good/plugins/custom/draggable/draggable.bundle.js"></script>

<style type="text/css">
.column {
    /* border: 1px solid #ccc; */
    min-height: 100px;
    padding: 10px;
}

.item {
    margin: 10px;
    padding: 5px;
    background-color: #f6f6fb;
    border: 1px solid #ddd;
}	

.sortable-placeholder {
    border: 1px dashed #ccc;
    background-color: #f7f7f7;
    height: 50px; /* Adjust based on your item height */
    margin-bottom: 5px; /* Adjust based on your item margin */
}
.text-info {
    cursor: grab;
    padding-left: 5px;
}

.text-info:active {
    cursor: grabbing;
}
span.toggle-links.btn.btn-info {
	position: absolute;
    text-align: center;
    top: 13px;
    right: 21px;
    padding: 3px !important;
    width: 31px;
    height: 25px;
    border-radius: 4px;
}
.toggle-links i.fa.fa-arrow-down {
    font-size: 9px;
    width: 7px;
    margin: 0 auto;
}
.toggle-links i.fa.fa-arrow-up {
    font-size: 9px;
    width: 7px;
    margin: 0 auto;
}
</style>
<div class="row report-listing">

<div class="col-md-4  d-none">
		<div class="panel">
			<div class="panel-body">
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item parent-list">
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
	<div class="col-md-12 d-none" id="report_selection">
		<div class="panel">
			<div class="panel-body child-list">
			<h3 id="right_heading" class="page-header text-info"><i class="icon ti-angle-double-left"></i><?php echo lang('reports_make_a_selection')?></h3>
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item custom-report hidden ">
					<a href="<?php echo site_url('reports/sales_generator');?>" class="list-group-item text-gray-600  fw-bold ">
						<i class="icon ti-search report-icon"></i>  <?php echo lang('reports_sales_search'); ?>
					</a>
				</div>
				
				
				
				
				
				
				
				
				
				
			</div>
		</div> <!-- /panel -->
	</div>


	
	
</div>

<div class="card"> 
	<div class="card-header">
		<div class="card-title">
			<?= lang('reports') ?>
		</div>
		<div class="card-toolbar">
			<button id="toggle-all" class="btn btn-primary">Toggle All</button>
		</div>
	</div>
	<div class="card-body">
	
	
<div class="row">
    <div id="column1" class="col-md-4 column">


	<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item saved "  data-eid="saved">
	<h4 class="text-info"><?php echo lang('saved_Reports'); ?></h4>
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
								    <a href="<?php echo $report_url;?>" class="list-group-item text-gray-600  fw-bold clearfix report_url" style="border-color: #e9ecf2;" data-relative-url="<?php echo $base_report_url; ?>">
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


		<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item customers " data-eid="customers">
			
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
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item closeout " data-eid="closeout">
				<h4 class="text-info"><?php echo lang('closeout_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/closeout');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/closeout_condensed');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_condensed_summary'); ?></a>
					
					<?php if ($cc_processor_class_name == 'CORECLEARBLOCKCHYPPROCESSOR' && $this->Employee->has_module_action_permission('sales', 'view_edit_transaction_history', $this->Employee->get_logged_in_employee_info()->person_id)) {?>				
						<a href="<?php echo site_url('sales/view_transaction_history');?>" class="list-group-item text-gray-600  fw-bold"><i class="ion-card"></i> <?php echo lang('sales_view_edit_transaction_history'); ?></a>
						<a href="<?php echo site_url('sales/batches');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('sales_batches'); ?></a>
					<?php } ?>
					
				</div>
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item tags " data-eid="tags">
				<h4 class="text-info"><?php echo lang('tags_Reports'); ?></h4>
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_tags');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_tags');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
				</div>


				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item categories "  data-eid="categories"> 
				<h4 class="text-info"><?php echo lang('categories_Reports'); ?></h4>
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_categories');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_categories');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
				</div>


				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item discounts "  data-eid="discounts">
				<h4 class="text-info"><?php echo lang('discounts_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/summary_discounts');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
				</div>
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item items "  data-eid="items">
				<h4 class="text-info"><?php echo lang('items_Reports'); ?></h4>
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
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item manufacturers " data-eid="manufacturers">
				<h4 class="text-info"><?php echo lang('manufacturers_Reports'); ?></h4>
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_manufacturers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_manufacturers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
				</div>
				
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item item-kits " data-eid="item-kits">
				<h4 class="text-info"><?php echo lang('item_kits_Reports'); ?></h4>
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_item_kits');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_item_kits');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_item_kits_variance');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_price_variance_report'); ?></a>
				<a href="<?php echo site_url('reports/generate/item_kit_price_history');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart"></i> <?php echo lang('reports_pricing_history'); ?></a>
				
				</div>
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item payments " data-eid="payments">
				<h4 class="text-info"><?php echo lang('payments_Reports'); ?></h4>
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_payments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_payments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/summary_payments_registers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_payments_registers'); ?></a>
					<a href="<?php echo site_url('reports/generate/detailed_payments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>


				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item suppliers " data-eid="suppliers">
				<h4 class="text-info"><?php echo lang('suppliers_Reports'); ?></h4>
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
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item suspended_sales " data-eid="suspended_sales">
				<h4 class="text-info"><?php echo lang('suspended_sales_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/detailed_suspended_sales');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/layaway_statements');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_layaway_statements'); ?></a>
				</div>

				
    </div>
    <div id="column2" class="col-md-4 column">
						
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item taxes " data-eid="taxes">
			
				<h4 class="text-info"><?php echo lang('taxes_Reports'); ?></h4>
					<?php if (can_display_graphical_report() ){ ?>
						<a href="<?php echo site_url('reports/generate/graphical_summary_taxes');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a href="<?php echo site_url('reports/generate/summary_taxes');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
				</div>
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item timeclock " data-eid="timeclock">
				<h4 class="text-info"><?php echo lang('timeclock_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/time_off');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_time_off_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/summary_timeclock');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>			
					<a href="<?php echo site_url('reports/generate/detailed_timeclock');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				
				</div>
				
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item tiers " data-eid="tiers">
				<h4 class="text-info"><?php echo lang('tiers_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/summary_tiers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>			
				</div>


				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item receivings " data-eid="receivings">
				<h4 class="text-info"><?php echo lang('receivings_Reports'); ?></h4>
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

				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item inventory " data-eid="inventory">
				<h4 class="text-info"><?php echo lang('inventory_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/inventory_low');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-stats-down"></i> <?php echo lang('reports_low_inventory'); ?></a>
					<a href="<?php echo site_url('reports/generate/inventory_summary');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_inventory_summary'); ?></a>
					<a href="<?php echo site_url('reports/generate/inventory_at_past_date');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_inventory_at_past_date'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_inventory');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/summary_count_report');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-stats-down"></i> <?php echo lang('reports_summary_count_report'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_count_report');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_count_report'); ?></a>
					<a href="<?php echo site_url('reports/generate/expiring_inventory');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_expiring_items_report'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_damaged_items');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_damaged_items_report'); ?></a>
				</div>
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item invoices " data-eid="invoices">
				<h4 class="text-info"><?php echo lang('invoices_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/customer_invoices');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-stats-down"></i> <?php echo lang('reports_customer_invoices'); ?></a>
					<a href="<?php echo site_url('reports/generate/supplier_invoices');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_supplier_invoices'); ?></a>
				</div>
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item giftcards " data-eid="giftcards">
				<h4 class="text-info"><?php echo lang('giftcards_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/summary_giftcards');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>			
					<a href="<?php echo site_url('reports/generate/detailed_giftcards');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/giftcard_audit');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_audit_report'); ?></a>
					<a href="<?php echo site_url('reports/generate/summary_giftcard_sales');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_gift_card_sales_reports'); ?></a>			
					
				</div>
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item store-accounts " data-eid="store-accounts">
				<h4 class="text-info"><?php echo lang('store_accounts_Reports'); ?></h4>
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
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item profit-and-loss " data-eid="profit-and-loss">
				<h4 class="text-info"><?php echo lang('profit_and_loss_Reports'); ?></h4>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_profit_and_loss');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_profit_and_loss');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item expenses " data-eid="expenses">
				<h4 class="text-info"><?php echo lang('expenses_Reports'); ?></h4>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_expenses');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_expenses');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>
    </div>
    <div id="column3" class="col-md-4 column">
		<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item commissions " data-eid="commissions">
				<h4 class="text-info"><?php echo lang('commissions_reports'); ?></h4>
					<?php if (can_display_graphical_report() ){ ?>
						<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/graphical_summary_commissions');?>" ><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_commissions');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/detailed_commissions');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item employees " data-eid="employees">
				<h4 class="text-info"><?php echo lang('employees_Reports'); ?></h4>
					<?php if (can_display_graphical_report() ){ ?>
						<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/graphical_summary_employees');?>" ><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
					<?php } ?>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_employees');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/specific_employee');?>" ><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>

				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item sales " data-eid="sales">
				<h4 class="text-info"><?php echo lang('sales_Reports'); ?></h4>
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

				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item work_order " data-eid="work_order">
				<h4 class="text-info"><?php echo lang('work_order_Reports'); ?></h4>
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
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item price_rules " data-eid="price_rules">
				<h4 class="text-info"><?php echo lang('price_rules_Reports'); ?></h4>
					<a class="list-group-item text-gray-600  fw-bold" href="<?php echo site_url('reports/generate/summary_price_rules');?>" ><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
				</div>
				
				
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item deleted-sales " data-eid="deleted-sales">
				<h4 class="text-info"><?php echo lang('deleted_sales_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/deleted_sales');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					<?php
					if ($this->Location->get_info_for_key('enable_credit_card_processing') && $this->Location->get_info_for_key('credit_card_processor') == 'coreclear2')
					{
					?>
						<a href="<?php echo site_url('reports/generate/voided_transactions');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_voided_transactions'); ?></a>
					<?php } ?>
					
				</div>
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item deliveries " data-eid="deliveries">
				<h4 class="text-info"><?php echo lang('deliveries_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/detailed_deliveries');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>
				
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item registers " data-eid="registers">
				<h4 class="text-info"><?php echo lang('registers_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/summary_registers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/graphical_summary_registers');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-bar-chart-alt"></i> <?php echo lang('reports_graphical_reports'); ?></a>
				</div>
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item register-log " data-eid="iregister-logems">
				<h4 class="text-info"><?php echo lang('register_log_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/detailed_register_log');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
				</div>
				
				
				<div  draggable="true"  class="card hover-elevate-up shadow-sm parent-hover item appointments " data-eid="appointments">
				<h4 class="text-info"><?php echo lang('appointments_Reports'); ?></h4>
					<a href="<?php echo site_url('reports/generate/summary_appointments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-receipt"></i> <?php echo lang('reports_summary_reports'); ?></a>
					<a href="<?php echo site_url('reports/generate/detailed_appointments');?>" class="list-group-item text-gray-600  fw-bold"><i class="icon ti-calendar"></i> <?php echo lang('reports_detailed_reports'); ?></a>
					
				</div>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
// $(function() {
//     initializeDraggable();

//     $(".column").droppable({
//         accept: ".item",
//         activeClass: "drag-active",
//         hoverClass: "drop-hover",
//         drop: function(event, ui) {
//             var clone = ui.draggable.clone();
//             $(this).append(clone);
//             initializeDraggable(); // Reinitialize draggable on new clone
//             ui.draggable.remove(); // Remove the original item
//         }
//     });
// });

// function initializeDraggable() {
//     $(".item").draggable({
//         revert: "invalid",
//         helper: "clone",
//         start: function(event, ui) {
//             $(this).css("opacity", 0.5); // Optional: Change the opacity of the draggable item on start
//         },
//         stop: function(event, ui) {
//             $(this).css("opacity", 1); // Optional: Revert the opacity once dragging stops
//         }
//     });
// }


	function initializeSortable(){
    $(".column").sortable({
        connectWith: ".column",
        items: ".item",
        placeholder: "sortable-placeholder",
        revert: true,
        helper: "clone",
        dropOnEmpty: true,
        start: function(event, ui) {
            ui.item.css("opacity", 0.5); // Dim the item being dragged
        },
        stop: function(event, ui) {
            ui.item.css("opacity", 1); // Reset the opacity after dropping
        },
        receive: function(event, ui) {
            // Handle item being received from another list
        },
        update: function(event, ui) {
            // This event is triggered when an item is dragged and dropped within the same list or between lists
			if (!ui.sender) { // Only if the update is within the same list
				saveOrder(); // Save the new order
			}
			saveOrderAndVisibility();
        }
    }).disableSelection();
	}

function saveOrder() {
    $(".column").each(function() {
        var columnId = $(this).attr("id");
        var order = $(this).sortable("toArray", { attribute: "data-eid" }); // Assuming each item has a data-eid attribute
        localStorage.setItem(columnId, JSON.stringify(order));
		$.post(<?php echo json_encode(site_url('reports/save_report_columns')); ?>,{ 'columnId' : columnId , reports:  localStorage.getItem(columnId)});
    });

}
function saveOrderAndVisibility() {
        var itemsOrderAndVisibility = [];
        $(".column").each(function() {
            var columnId = $(this).attr('id');
            $(this).find('.item').each(function() {
                var itemId = $(this).data('eid');
				if($(this).find('table').length > 0){
					
					var isVisible = !$(this).find('table').hasClass('d-none');
				}else{
					var isVisible = !$(this).find('a').hasClass('d-none');
				}
                
                itemsOrderAndVisibility.push({ columnId: columnId, itemId: itemId, isVisible: isVisible });
            });
        });
        localStorage.setItem('itemsOrderAndVisibility', JSON.stringify(itemsOrderAndVisibility));
		$.post(<?php echo json_encode(site_url('reports/save_report_visibility')); ?>,{reports:  localStorage.getItem('itemsOrderAndVisibility')});
    }
	function restoreOrderAndVisibility() {
		
		localStorage.setItem('itemsOrderAndVisibility',  JSON.stringify(<?php echo Report::get_saved_report_visibility() ?>));
        var itemsOrderAndVisibility = JSON.parse(localStorage.getItem('itemsOrderAndVisibility'));
        if (itemsOrderAndVisibility) {
            $.each(itemsOrderAndVisibility, function(index, obj) {
                var itemSelector = '.item[data-eid="' + obj.itemId + '"]';
                var item = $(itemSelector);
				 var $toggleIcon = item.find('.toggle-links i');
                $("#" + obj.columnId).append(item);
                if (!obj.isVisible) {
                    item.find('a').addClass('d-none');
					item.find('table').addClass('d-none');
					 $toggleIcon.removeClass('fa-arrow-down').addClass('fa-arrow-up');
                } else {
                    item.find('a').removeClass('d-none');
					item.find('table').removeClass('d-none');
					 $toggleIcon.removeClass('fa-arrow-up').addClass('fa-arrow-down');
                }
            });
        }
    }

function restoreOrder() {
	localStorage.setItem('column1',  JSON.stringify(<?php echo Report::get_saved_report_columns(1) ?>));
	localStorage.setItem('column2',  JSON.stringify(<?php echo Report::get_saved_report_columns(2) ?>));
	localStorage.setItem('column3',  JSON.stringify(<?php echo Report::get_saved_report_columns(3) ?>));
    $(".column").each(function() {
        var columnId = $(this).attr("id");
        var savedOrder = JSON.parse(localStorage.getItem(columnId));
		
        if (savedOrder) {
            for (var i = 0; i < savedOrder.length; i++) {
				
                var itemId = savedOrder[i];
                $(".item[data-eid='" + itemId + "']").appendTo(this);
            }
        }
    });
}

$('#toggle-all').click(function() {
    var allCollapsed = $(this).data('collapsed') || false;
    
    // Toggle the state
    $(this).data('collapsed', !allCollapsed);

    // Update the button text or icon if needed
    // For simplicity, I'm using text changes here
    if (!allCollapsed) {
        $(this).text('Uncollapse All');
        $('.item a').addClass('d-none');
		$('.item table').addClass('d-none');
        $('.toggle-links i').removeClass('fa-arrow-down').addClass('fa-arrow-up');
    } else {
        $(this).text('Collapse All');
        $('.item a').removeClass('d-none');
		$('.item table').removeClass('d-none');
        $('.toggle-links i').removeClass('fa-arrow-up').addClass('fa-arrow-down');
    }

    saveOrderAndVisibility(); // Update this function as needed to handle saving
});

$(document).ready(function() {
    $('.item').each(function() {
        // Create a new span element
        var $toggleButton = $('<span>', {
            class: 'toggle-links btn btn-info',
			html: '<i class="fa fa-arrow-down"></i>'
        });

        // Prepend it before the h3 tag within each .item div
        $(this).find('h4').before($toggleButton);
    });

    // Add click event listener for dynamically added buttons
    $(document).on('click', '.toggle-links', function() {
		var $icon = $(this).find('i');
    var isDown = $icon.hasClass('fa-arrow-down');
    
    // Toggle the icon
    if (isDown) {
        $icon.removeClass('fa-arrow-down').addClass('fa-arrow-up');
    } else {
        $icon.removeClass('fa-arrow-up').addClass('fa-arrow-down');
    }
        $(this).siblings('a').toggleClass('d-none');
		$(this).siblings('table').toggleClass('d-none');
		$(this).siblings('table').find('a').toggleClass('d-none');
		saveOrderAndVisibility();
    });
});

$(function() {
    restoreOrder(); // Restore the order before initializing sortable
    initializeSortable(); // Your function to initialize sortable
	restoreOrderAndVisibility();
});
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