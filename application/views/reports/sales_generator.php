<?php $this->load->view("partial/header");



 ?>

<style type="text/css" scoped>
	.ui-autocomplete-loading {
        background: white url('images/spinner_small.gif') 0% 5% no-repeat;
    }
	.item_table { padding-left: 40px; font: 12px Arial;}
	span.required { color: #FF0000; }

	/* Add / Remove Images */
	/* a.AddCondition {
		background-image: url(data:image/gif;base64,R0lGODlhEAAQAPcAAAAAAP///5i+lTyGNUeNQEiOQVKVTJi+lN7p3d3o3ESMO0WMO0iPP1SVTLjRtUKNNkOPOEmOP3DBY16bVWCdV4HMdXm9boXNeYbJfI7Sg4nIf47MhJTTisXowFCZQXrGa2OgV37Hb4rPfYbJeozLgZXUipfVi5bUi5PNiJ3YkqDZlaDZlqXbm6/fprfgr73ktqTGnqPFnc7pydzx2GWrVXG+X2qsW3zDa2eiWpbTia/fpbPdqbXfrL7ittfu0tTrz8XawODy3OPs4eLr4FeeRWSgVGaiV3etaHWsZ5nRi5jMirTdqrLbqLbdrLjdr8bawebu5HC4WW61WGirU2+1WXnBZGuqWGyqWn7BaX25an25a3+5bYrCearUncvmw8jcwsncw2+1WHK5W3O6XHS3XHe8YH2+Z3i0ZIm+eI/CfZfMhZLFgIm5eJjLhpjMh7XbqLXRrLfTrnS3W3y6ZH28Zn6yaoK1boK0bo2+e4i3dpfHhaTOlKbQlqbPlqvUnLTaprPZpbTZpbfaqrvcr+bu44a2cZS/gZW/gurx54y7dpO/fpK+fsLatsHZtdXlzerw5/n5+f///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAJEALAAAAAAQABAAAAjPACEJHEiwYMFHjA4VusMmDiGDkBwt2uPlhwwnW46AKego0aAgL1is0NGBi5EnAxEpEjQjBYoNJ0pkcKEFhxCBjfT4UMFBQ4AAF26E4EEEhkBDTVqQwGDhp40yY5KsoSDQTg8TI35qDRAFSxcGAuvsEFFh688oZvwoEJhHSY4PEmicjSJGDZ4GAuFMWVKlRpmzUsj8gXBAIBQkWZhAjUIljBxAVwogGPilyJk3bujMaRPIygAHBYGA8JCGTx80DwiANjgkxoQICwwISACxdsGAADs=);	
		display: block;
		float: left;
		text-indent: -9999px;
		width: 16px;
		height: 16px;
	} */
	/* a.DelCondition {
		background-image: url(data:image/gif;base64,R0lGODlhEAAQAPcAAAAAAP///+FvcON4efDi3ePAtfDh3LpSNL5WOb9cP71bP8FmS9mjk9mklMRQNL9TOcBZPsNkS8ZqU/zHusFNM8BVPfaCaMhqVfaEbPiMdu6KdfCMd/GOeveTfviUf/qah/qjkfi2qN6mm/3b1PLj4MxSPPNzXfN5Y8tlVMxoV/iGcPCFcPmSfvqTf/eRfvCRf/qdi/qrnfq6rt6nnfzUzfnTzOnFv/Li3+5mUs1gUc5iU/J3Y/upnPWsofivpPWvpfS0qvm5r/nLxOrFv9BPPtNwZPSOge6MgferofarouvFwevGwv3c2OlZTeZYTOlbT+ZZTupcUNtWS/BkVuxfVNddUepmXNZgVO5qXuNrYeNuY+JwZtVtY+l7cO+GfvGdlvjDvuZWTOZaUuljW+BlXOR4cfCDe+l/eOJ7ddx3cu6EfeqDfe2TjvGclvWmofOno+etqeivrPTk4+ZWUOddWdtoZNtraNxuaeh6dd54c+6Sj/SinvWjn/Ktqt1rauJ4eOJ+fOF+fPSgnu2ysu2zs/LLy/bm5vn5+f///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAIgALAAAAAAQABAAAAjLAA8JHEiwYEFDhAL5sZMnjhyDhwr9YQOmhhAgW7gsKVhIQB8mMkDA4DGhi44hAw0NeDPiwwsOHlhkCKElBQmBg9bQgNFBA4afGE74IDJDIKAfMTZQWcp0h5EzFwTeCdJiRYCrWJtg+VJBYB0kKixgzWqlDQKBaY64MNGkrdsnZtBEEAhHSpIpONw2cSKGjwMGAuUUydKDSpQmUMLM2XMlAYGBSnKQceNlDB01gqocKFDQBooSePToKUNBAWeDN0RIgPBgQQMDEGMXDAgAOw==);		display: block;
		float: left;
		text-indent: -9999px;
		width: 16px;
		height: 16px;
	} */
	span.actionCondition {
		float: left;
		font-weight: bold;
		margin-right: 5px;
	}
	
	/*table.conditions {
		width: 100%;
		border: 1px solid #DDDDDD;
	}
	
	table.conditions tr.duplicate td {
		padding: 10px 0px;
	}

	table.conditions tr.duplicate td.field {
		padding: 5px;
	}

	table.conditions tr.duplicate td.field select {
		width: 200px;
	}
	
	table.conditions tr.duplicate td.value textarea {
		height: 20px;
		resize: none;
		overflow-y: hidden;
		padding: 16px;
		-webkit-transition:height .1s ease-in-out;
		-moz-transition:height .1s ease-in-out;
		-o-transition:height .1s ease-in-out;
		-ms-transition:height .1s ease-in-out;
		transition:height .1s ease-in-out;	
	}*/
	
</style>

<script type="text/javascript">
(function($) 
{
  	$.fn.tokenize = function(options)
	{
		var settings = $.extend({}, {prePopulate: false}, options);
    	return this.each(function() 
		{
      		$(this).tokenInput('<?php echo site_url("reports/sales_generator"); ?>?act=autocomplete',
			{
				theme: "facebook",
				queryParam: "term",
				extraParam: "w",
				hintText: <?php echo json_encode(lang("reports_sales_generator_autocomplete_hintText"));?>,
				noResultsText: <?php echo json_encode(lang("reports_sales_generator_autocomplete_noResultsText"));?>,
				searchingText: <?php echo json_encode(lang("reports_sales_generator_autocomplete_searchingText"));?>,
				preventDuplicates: true,
				prePopulate: settings.prePopulate
			});
    	});
 	}
})(jQuery);

$(document).on('change', "#matchType", function(){
	if ($(this).val() == 'matchType_All')
	{
		$("#matched_items_only").prop('disabled', false);
		$(".actions span.actionCondition").html(<?php echo json_encode(lang("reports_sales_generator_matchType_All_TEXT"));?>);
	}
	else 
	{
		$("#matched_items_only").prop('checked', false);
		$("#matched_items_only").prop('disabled', true);
		$(".actions span.actionCondition").html(<?php echo json_encode(lang("reports_sales_generator_matchType_Or_TEXT"));?>);
	}
});


$(document).on('click', "a.AddCondition", function(e){
	var sInput = $("<input />").attr({"type": "text", "name": "value[]", "w":"", "value":"", "class":"form-control form-control-solid"});
	$('.conditions tr.duplicate:last').clone().insertAfter($('.conditions tr.duplicate:last'));
	// $("input", $('.conditions tr.duplicate:last')).parent().html("").append(sInput).children("input").tokenize();
	$("option", $('.conditions tr.duplicate:last select')).removeAttr("disabled").removeAttr("selected").first().prop("selected", true);
	
	$('.conditions tr.duplicate:last').trigger('change');
	e.preventDefault();
})

$(document).on('click', "a.DelCondition", function(e){
	if ($(this).parent().parent().parent().children().length > 1)
		$(this).parent().parent().remove();
	
	e.preventDefault();
})

$(document).on('change', ".selectField", function(){
	var sInput = $("<input />").attr({"type": "text", "name": "value[]", "w":"", "value":"", "class":"form-control form-control-solid"});
	var field = $(this);
	// Remove Value Field
	field.parent().parent().children("td.value").html("");
	if ($(this).val() == 0) 
	{
		field.parent().parent().children("td.condition").children(".selectCondition").prop("disabled", true);	
		field.parent().parent().children("td.value").append(sInput.prop("disabled", true));		
	} 
	else 
	{
		field.parent().parent().children("td.condition").children(".selectCondition").removeAttr("disabled");	
		if ($(this).val() == 2 || $(this).val() == 7 || $(this).val() == 29 || $(this).val() == 10 || $(this).val() == 12 || $(this).val() == 16 || ($(this).val() >= 19 && $(this).val() <= 28)) 
		{
			field.parent().parent().children("td.value").append(sInput);		
		} 
		else 
		{
			if ($(this).val() == 6) 
			{
				field.parent().parent().children("td.value").append($("<input />").attr({"type": "hidden", "name": "value[]", "value":"", "class":"form-control form-control-solid"}));		
			} 
			else 
			{
	
				// field.parent().parent().children("td.value").append(sInput.attr("w", $("option:selected", field).attr('rel'))).children("input").tokenize();	

				field.parent().parent().children("td.value").append(sInput.attr("w", $("option:selected", field).attr('rel'))).children("input").eq(1).remove();
					
			}
		}
		disableConditions(field, true);
	}
});

$(function() {
	<?php 
		if (isset($prepopulate) and count($prepopulate) > 0) {
			echo "var prepopulate = ".json_encode($prepopulate).";";
		}
	?>
	var sInput = $("<input />").attr({"type": "text", "name": "value[]", "w":"", "value":"", "class":"form-control form-control-solid"});
	$(".selectField").each(function(i) {
		if ($(this).val() == 0) {
			$(this).parent().parent().children("td.condition").children(".selectCondition").prop("disabled", true);
			$(this).parent().parent().children("td.value").html("").append(sInput.prop("disabled", true));	
		} else {
			if ($(this).val() != 2 && $(this).val() != 6 && $(this).val() != 7 && $(this).val() != 10 && $(this).val() != 12 && $(this).val() != 16 && $(this).val() < 19) {
				$(this).parent().parent().children("td.value").children("input").attr("w", $("option:selected", $(this)).attr('rel')).tokenize({prePopulate: prepopulate.field[i][$(this).val()] });	
			}
			if ($(this).val() == 6) {
				$(this).parent().parent().children("td.value").html("").append($("<input />").attr({"type": "hidden", "name": "value[]", "value":"", "class":"form-control"}));	
			}
			disableConditions($(this), false);
		}
	});
});

function disableConditions(elm, q) {
	var allowed1 = ['1', '2','16','17'];
	var allowed2 = ['7', '8', '9'];
	var allowed3 = ['10', '11'];
	var allowed4 = ['1', '2', '7', '8', '9','29'];
	var allowed5 = ['1'];
	var disabled = elm.parent().parent().children("td.condition").children(".selectCondition");
	
	if (q == true)
		$("option", disabled).removeAttr("selected");
	
	$("option", disabled).prop("disabled", true);
	$("option", disabled).each(function() {
		if (elm.val() == 11 && $.inArray($(this).attr("value"), allowed5) != -1) {
			$(this).removeAttr("disabled");
		}else if (elm.val() == 10 && $.inArray($(this).attr("value"), allowed4) != -1) {
			$(this).removeAttr("disabled");
		} else if (elm.val() == 6 && $.inArray($(this).attr("value"), allowed3) != -1) {
			$(this).removeAttr("disabled");
		} else if (elm.val() == 7 && $.inArray($(this).attr("value"), allowed2) != -1) {
			$(this).removeAttr("disabled");
		} else if (elm.val() != 6 && elm.val() != 7 && elm.val() != 10 && elm.val() != 11 && $.inArray($(this).attr("value"), allowed1) != -1) {
			$(this).removeAttr("disabled");
		} 
		
	});
	
	if (q == true)
		$("option:not(:disabled)", disabled).first().prop("selected", true);
}

</script>
<div class="row">
	<div class="col-md-12">
		<div class="card">				
			<div class="card-header rounded rounded-3 p-5  rounded border-primary border border-dashed rounded-3hidden-print">
				<?php echo lang('reports_date_range'); ?>

				<div class="d-flex">
                <select id="country-dropdown"  class="form-control mx-1">
                    <option value=""><?php echo lang('Select_Module'); ?></option>
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
								<?php echo lang('custom_report'); ?>
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
						<option  value="payments"><i class="icon ti-money"></i>	<?php echo lang('payments'); ?></option>
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
						<option  value="tags"><i class="icon ti-layout-grid3"></i>	<?php echo lang('tags'); ?></option>
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

                <select id="city-dropdown"  class="form-contro">
                    <option value=""><?php echo lang('Select_Report'); ?></option>
                    <!-- Cities will be added here based on the selected country -->
                </select>

                </div>
			</div>
			<div class="card-body hidden-print">
				<form id="salesReportGenerator" name="salesReportGenerator" action="<?php echo site_url("reports/sales_generator"); ?>" method="get" class="form-horizontal form-horizontal-mobiles">
						<?php
						$this->load->helper('view');
						load_cleaned_view('reports/inputs/date_range',array('with_time' => FALSE,'report_type' => $report_type, 'date_range_simple_value' => $sreport_date_range_simple, 'start_date_value' => $this->input->get('start_date_formatted'), 'end_date_value' => $this->input->get('end_date_formatted')));
						?>
					<?php $this->load->view('partial/reports/locations_select');?>

					<div class="form-group">
						<?php echo form_label(lang('reports_sales_generator_matchType').':', 'matchType', array('class'=>'required text-danger col-sm-3 col-md-3 col-lg-2 control-label')); ?>
						<div class="controls col-sm-9 col-md-7 col-lg-7">
							<select name="matchType" id="matchType" class="form-control form-control-solid">
								<option value="matchType_All"<?php if ($matchType != 'matchType_All') { echo " selected='selected'"; }?>><?php echo lang('reports_sales_generator_matchType_All')?></option>
								<option value="matchType_Or"<?php if ($matchType == 'matchType_Or') { echo " selected='selected'"; }?>><?php echo lang('reports_sales_generator_matchType_Or')?></option>
							</select>
							<em>
								<?php echo lang('reports_sales_generator_matchType_Help')?>
							</em>
						</div>
						
					</div>

					<div class="form-group">
						<?php echo form_label(lang('reports_sales_generator_show_only_matched_items').':', 'matched_items_only', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
						<div class="controls col-sm-9 col-md-9 col-lg-9 form-check form-check-custom form-check-solid">
							<?php
								$matched_items_checkbox =	array(
							    'name'        => 'matched_items_only',
							    'id'          => 'matched_items_only',
							    'value'       => '1',
								'class' => 'form-check-input',
							    'checked'     => $matched_items_only,
						    	);
								
								if ($matchType == 'matchType_Or')
								{
									$matched_items_checkbox['disabled'] = 'disabled';
								}
							?>
							<?php echo form_checkbox($matched_items_checkbox).'<label for="matched_items_only"><span></span></label>'; ?>
						</div>
					</div>
					
					<div class="form-group">
						<?php echo form_label(lang('reports_tax_exempt').':', 'tax_exempt', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
						<div class="controls col-sm-9 col-md-9 col-lg-9 form-check form-check-custom form-check-solid">
							<?php echo form_checkbox(array(
						    'name'        => 'tax_exempt',
						    'id'          => 'tax_exempt',
						    'value'       => '1',

							'class' => 'form-check-input',
						    'checked'     => $tax_exempt,
							 
					    	)).'<label for="tax_exempt"><span></span></label>'; ?>
						</div>
					</div>
					
					<div class="form-group">
						<?php echo form_label(lang('reports_export_to_excel').':', 'export_excel', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
						<div class="controls col-sm-9 col-md-9 col-lg-9 form-check form-check-custom form-check-solid">
							<?php echo form_checkbox(array(
						    'name'        => 'export_excel',
						    'id'          => 'export_excel',
						    'value'       => '1',
							'class' => 'form-check-input'
					    	)).'<label for="export_excel" class="form-check-label"><span></span></label>'; ?>
						</div>
					</div>

					<div class="table-responsive">
						<table class="table conditions custom-report">
							<?php
							$this->lang->load('deliveries');
								if (isset($field) and $field[0] > 0) {
									foreach ($field as $k => $v) {
							?>
							<tr class="duplicate">
								<td class="field">
									<select name="field[]" class="selectField form-control  form-control-solid">
										<option value="0"><?php echo lang("Please_Select") ?></option>						
										<option value="1" rel="customers"<?php if($field[$k] == 1) echo " selected='selected'";?>><?php echo lang("customer_name") ?></option>
										<option value="2" rel="itemsSN"<?php if($field[$k] == 2) echo " selected='selected'";?>><?php echo lang("Item_Serial_number") ?></option>
										<option value="3" rel="employees"<?php if($field[$k] == 3) echo " selected='selected'";?>><?php echo lang("Employee_Name") ?></option>
										<option value="4" rel="itemsCategory"<?php if($field[$k] == 4) echo " selected='selected'";?>><?php echo lang("Item_Category") ?></option>
										<option value="5" rel="suppliers"<?php if($field[$k] == 5) echo " selected='selected'";?>><?php echo lang("Supplier_Name") ?></option>
										<option value="6" rel="saleType"<?php if($field[$k] == 6) echo " selected='selected'";?>><?php echo lang("Sale_type") ?></option>
										<option value="7" rel="saleAmount"<?php if($field[$k] == 7) echo " selected='selected'";?>><?php echo lang("Sale_Amount") ?></option>
										<option value="8" rel="itemsKitName"<?php if($field[$k] == 8) echo " selected='selected'";?>><?php echo lang("Item_Kit_Name") ?></option>
										<option value="9" rel="itemsName"<?php if($field[$k] == 9) echo " selected='selected'";?>><?php echo lang("Item_Name_/_UP_/_Product_ID") ?></option>
										<option value="10" rel="saleID"<?php if($field[$k] == 10) echo " selected='selected'";?>><?php echo lang("Sale_ID") ?></option>
										<option value="11" rel="paymentType"<?php if($field[$k] == 11) echo " selected='selected'";?>><?php echo lang("Payment_Type") ?></option>
										<option value="12" rel="saleItemDescription"<?php if($field[$k] == 12) echo " selected='selected'";?>><?php echo lang("Sale_item_Description") ?></option>
										<option value="13" rel="salesPerson"<?php if($field[$k] == 13) echo " selected='selected'";?>><?php echo lang("sales_person") ?></option>
										<option value="15" rel="manufacturer"<?php if($field[$k] == 15) echo " selected='selected'";?>><?php echo lang("manufacturer") ?></option>
										<option value="16" rel="saleComment"<?php if($field[$k] == 16) echo " selected='selected'";?>><?php echo lang("deliveries_sale_comment") ?></option>
										<option value="17" rel="itemVariationNumber"<?php if($field[$k] == 17) echo " selected='selected'";?>><?php echo lang("item_variation_item_number") ?></option>
										<option value="18" rel="tierName"<?php if($field[$k] == 18) echo " selected='selected'";?>><?php echo lang("tier_name") ?></option>
										<option value="29" rel="tierName"<?php if($field[$k] == 29) echo " selected='selected'";?>><?php echo lang("tag") ?></option>
										
										<?php
									 
 									 for($i=19,$counter=1;$i<=28;$i++,$counter++)
									 {
									 	 $custom_field = $this->Sale->get_custom_field($counter);
									 	 if($custom_field !== FALSE)
										 {
											?>
	 										<option value="<?php echo $i;?>" rel="customField<?php echo $i;?>"<?php if($field[$k] == $i) echo " selected='selected'";?>><?php echo $custom_field; ?></option>									 	
										 <?php
										 }
									 }
										?>
									</select>
								</td>
								<td class="condition">
									<select name="condition[]" class="selectCondition form-control form-control-solid">
										<option value="1"<?php if($condition[$k] == 1) echo " selected='selected'";?>><?php echo lang("is")?></option>
										<option value="2"<?php if($condition[$k] == 2) echo " selected='selected'";?>><?php echo lang("is_not")?></option>
										<option value="7"<?php if($condition[$k] == 7) echo " selected='selected'";?>><?php echo lang("Greater_than")?></option>
										<option value="8"<?php if($condition[$k] == 8) echo " selected='selected'";?>><?php echo lang("less_than")?></option>
										<option value="9"<?php if($condition[$k] == 9) echo " selected='selected'";?>><?php echo lang("equal_to")?></option>
										<option value="10"<?php if($condition[$k] == 10) echo " selected='selected'";?>><?php echo lang("sale")?></option>
										<option value="11"<?php if($condition[$k] == 11) echo " selected='selected'";?>><?php echo lang("return")?></option>
										<option value="16"<?php if($condition[$k] == 16) echo " selected='selected'";?>><?php echo lang("contains")?></option>
										<option value="17"<?php if($condition[$k] == 17) echo " selected='selected'";?>><?php echo lang("not_contains")?></option>
									</select>
								</td>
								<td class="value">
										<input type="text" name="value[]" w="" value="<?php echo $value[$k]; ?>" class="form-control"/>	
								</td>
								<td class="actions">
									<span class="actionCondition">
									<?php 
										if ($matchType == 'matchType_Or') {
											echo lang("reports_sales_generator_matchType_Or_TEXT");
										} else {
											echo lang("reports_sales_generator_matchType_All_TEXT");					
										}
									?>
									</span>
									<a class="AddCondition btn btn-light-primary"  href="#" title="<?php echo lang("reports_sales_generator_addCondition")?>"><i class="la la-plus"></i><?php echo lang("reports_sales_generator_addCondition")?></a>
									<a class="DelCondition" href="#" title="<?php echo lang("reports_sales_generator_delCondition")?>"><?php echo lang("reports_sales_generator_delCondition")?></a>
								</td>
							</tr>				
							<?php
									}
								} else {
							?>
							<tr class="duplicate">
								<td class="field">
									<select name="field[]" class="selectField span7 form-control form-control-solid">
									<option value="0"><?php echo lang("Please_Select") ?></option>						
										<option value="1" rel="customers"><?php echo lang("customer_name") ?></option>
										<option value="2" rel="itemsSN"><?php echo lang("Item_Serial_number") ?></option>
										<option value="3" rel="employees"><?php echo lang("Employee_Name") ?></option>
										<option value="4" rel="itemsCategory"><?php echo lang("Item_Category") ?></option>
										<option value="5" rel="suppliers"><?php echo lang("Supplier_Name") ?></option>
										<option value="6" rel="saleType"><?php echo lang("Sale_type") ?></option>
										<option value="7" rel="saleAmount"><?php echo lang("Sale_Amount") ?></option>
										<option value="8" rel="itemsKitName"><?php echo lang("Item_Kit_Name") ?></option>
										<option value="9" rel="itemsName"><?php echo lang("Item_Name_/_UP_/_Product_ID") ?></option>
										<option value="10" rel="saleID"><?php echo lang("Sale_ID") ?></option>
										<option value="11" rel="paymentType"><?php echo lang("Payment_Type") ?></option>
										<option value="12" rel="saleItemDescription"><?php echo lang("Sale_item_Description") ?></option>
										<option value="13" rel="salesPerson"><?php echo lang("sales_person") ?></option>
										<option value="15" rel="manufacturer"><?php echo lang("manufacturer") ?></option>
										<option value="16" rel="saleComment"><?php echo lang("deliveries_sale_comment") ?></option>
										<option value="17" rel="itemVariationNumber"><?php echo lang("item_variation_item_number") ?></option>
										<option value="18" rel="tierName"><?php echo lang("tier_name") ?></option>
										<option value="29" rel="tagName"><?php echo lang("tag") ?></option>
										
 										<?php
									 
										
 									 for($i=19,$counter=1;$i<=28;$i++,$counter++)
 									 {
 									 	 $custom_field = $this->Sale->get_custom_field($counter);
 									 	 if($custom_field !== FALSE)
 										 {
 											?>
 	 										<option value="<?php echo $i;?>" rel="customField<?php echo $i;?>"><?php echo $custom_field; ?></option>									 	
 										 <?php
 										 }
 									 }
 										?>
										
										
									</select>
								</td>
								<td class="condition">
									<select name="condition[]" class="selectCondition form-control form-control-solid">
									<option value="1"><?php echo lang("is")?></option>
										<option value="2"><?php echo lang("is_not")?></option>
										<option value="7"><?php echo lang("Greater_than")?></option>
										<option value="8"><?php echo lang("less_than")?></option>
										<option value="9"><?php echo lang("equal_to")?></option>
										<option value="10"><?php echo lang("sale")?></option>
										<option value="11"><?php echo lang("return")?></option>
										<option value="16"><?php echo lang("contains")?></option>
										<option value="17"><?php echo lang("not_contains")?></option>
									</select>
								</td>
								<td class="value">
									<input type="text" name="value[]" w="" value="" class="form-control form-control-solid"/>	
								</td>
								<td class="actions">
									<!-- <span class="actionCondition"> -->
									<!-- <?php 
										if ($matchType == 'matchType_Or') {
											echo lang("reports_sales_generator_matchType_Or_TEXT");
										} else {
											echo lang("reports_sales_generator_matchType_All_TEXT");					
										}
									?> -->
									</span>
									<a class="AddCondition btn btn-light-primary" href="#" title="<?php echo lang("reports_sales_generator_addCondition")?>"><i class="la la-plus"></i><?= lang('Add'); ?></a>
									<a class="DelCondition btn btn-sm btn-light-danger " href="#" title="<?php echo lang("reports_sales_generator_delCondition")?>"><i class="la la-trash-o fs-3"></i><?= lang('Delete'); ?></a>
								</td>
							</tr>
							
							<?php
								}
							?>
						</table>
					</div>

					<div class="form-actions text-center">
						<button name="generate_report" type="submit" value="1" id="generate_report" class="submit_button btn btn-primary btn-lg"><?php echo lang('submit')?></button>
					</div>
				</form>

				
			</div>
		</div>

		<?php 
			if (isset($results)) echo $results;
		?>
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

  
    "custom-report" :['<?php echo lang('custom_report'); ?>'],

    "registers": ['<?php echo lang('registers_summary_reports'); ?>' , '<?php echo lang('registers_graphical_reports'); ?>'],
};
    $url='<?php echo site_url('reports/generate/'); ?>';
	$customurl='<?php echo site_url('reports/'); ?>';

    var cityToURL = {


        "<?php echo lang('custom_report'); ?>": $customurl+'sales_generator',

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
        cityDropdown.append('<option value=""><?php echo lang('Select_Report'); ?></option>');
        
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


    function populateCountryDropdown() {
    var countryDropdown = document.getElementById('country-dropdown');
    Object.keys(moduleToReports).forEach(function(country) {
        var option = new Option(country, country);
        countryDropdown.add(option);
    });
}

    // Function to populate cities dropdown based on selected country
    function populateCitiesDropdown(country) {
    var citiesDropdown = document.getElementById('city-dropdown');
    citiesDropdown.innerHTML = '<option value=""><?php echo lang('Select_Report'); ?></option>'; // Clear existing options first
    var cities = moduleToReports[country] || [];
    cities.forEach(function(city) {
        var option = new Option(city,city);
        citiesDropdown.add(option);
    });
}


// Function to select country and city based on a part of the URL like "new-york"
function selectBasedOnUrlPart(urlPart) {
    for (var city in cityToURL) {
        if (cityToURL[city].includes(urlPart)) {
            // console.log(cityToURL[city]);
            // Find the country for this city
            for (var country in moduleToReports) {
                if (moduleToReports[country].includes(city)) {
                    document.getElementById('country-dropdown').value = country;
                    populateCitiesDropdown(country); // Populate cities for this country
                    // console.log(city);
                    setTimeout(function() { // Ensure cities dropdown is populated
                        document.getElementById('city-dropdown').value = city;
                    }, 0);
                    break; // Stop searching once the country is found
                }
            }
            break; // Stop searching once the city is found
        }
    }
}


// Example usage
var partialUrl = "<?= $this->uri->segment(2); ?>";
selectBasedOnUrlPart(partialUrl);

});
</script>
<script type="text/javascript" language="javascript">
var base_sheet_url = '';
$(document).ready(function()
{
	$(".tablesorter a.expand").click(function(event)
	{
		$(event.target).parent().parent().next().find('td.innertable').toggle();
		
		if ($(event.target).text() == '+')
		{
			$(event.target).text('-');
			id=$(event.target).attr("id");
			show_report_details(id);
		}
		else
		{
			$(event.target).text('+');
		}
		return false;
	});
	
	$(".tablesorter a.expand_all").click(function(event)
	{
		$('td.innertable').toggle();
		
		if ($(event.target).text() == '+')
		{
			$(event.target).text('-');
			$(".tablesorter a.expand").text('-');
			
			ids='<?php echo isset($ids)?$ids:''; ?>';
				show_report_details(ids);
			
		}
		else
		{
			$(event.target).text('+');
			$(".tablesorter a.expand").text('+');
		}
		return false;
	});
	
	$(".generate_barcodes_from_recv").click(function()
	{
		base_sheet_url = $(this).attr('href');
		$("#skip-labels").modal('show');
		return false;
	
	});
		
	$("#generate_barcodes_form").submit(function(e)
	{
		e.preventDefault()
		var num_labels_skip = $("#num_labels_skip").val() ? $("#num_labels_skip").val() : 0;
		var url = base_sheet_url+'/'+num_labels_skip;
		window.location = url;
		return false;
	});
});

function print_report()
{
	window.print();
}

function show_report_details(ids){
        if(ids){
            var report_model = '<?php echo isset($report_model)?$report_model:''; ?>';
			var url = '<?php echo site_url('reports/get_report_details'); ?>';
            var ids = ids.split(',');
			$.ajax({
                url: url,
				type: 'POST',
				data:{'ids':ids,'key':report_model},
				datatype: 'json',
				cache: false,
				success:function(data){
				
				var obj = JSON.parse(data);
				var headers = obj.headers['details'];
				var cellData= obj.details_data;
				var summary= obj.headers['summary'];
				for (i = 0; i < ids.length; i++) { 
					
					var res = '#res_'+ids[i];
					
					var tableData='<td colspan="' + (summary.length+1) +'" class="innertable"><table class="table table-bordered">';
					tableData+='<thead>';
					tableData+='<tr>';
					$.each(headers, function (k, v) {
						tableData += '<th align="'+ v.align + '">' + v.data + '</th>';					
					});
					tableData +='</tr></thead>';
					
					tableData+='<tbody>';
					$.each(cellData, function (x) {
					var transData= cellData[x];
						$.each(transData, function (key, value){
							var rowId=key;
							var rowData=value;
							if(rowId == ids[i])
							{
								tableData+='<tr>';
								$.each(rowData, function (a,b) {
									if(b.data == null){b.data='';}
									tableData += '<td align="'+ b.align + '">' + b.data + '</td>';					
								});
								tableData+='</tr>';
								
							}
						
						});
						
					});
					tableData+='</tbody>';
					tableData+='</table></td>';
					
					//document.getElementById(res).innerHTML = "";
					$(res).empty();
					$(res).append(tableData);
					$(res).css('display','');
				}
				
				},
				error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError);
				}
				
               
            });
        }
    }

$(document).ready(function()
{
	$('#print_button').click(function(e){
		e.preventDefault();
		print_report();
	});
});

<?php $this->load->view("partial/footer"); ?>

