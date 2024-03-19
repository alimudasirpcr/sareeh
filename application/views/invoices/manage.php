<?php $this->load->view("partial/header"); ?>


<div class="spinner" id="grid-loader" style="display:none">
	<div class="rect1"></div>
	<div class="rect2"></div>
	<div class="rect3"></div>
</div>

<script type="text/javascript">

	function reload_invoice_table()
	{
		clearSelections();
		$("#table_holder").load(<?php echo json_encode(site_url("$controller_name/reload_invoice_table/$invoice_type")); ?>);
	}

	$(document).ready(function()
	{
		$("#sortable").sortable({
			items : '.sort',
			containment: "#sortable",
			cursor: "move",
			handle: ".handle",
			revert: 100,
			update: function( event, ui ) {
				$input = ui.item.find("input[type=checkbox]");
				$input.trigger('change');
			}
		});

		$("#sortable").disableSelection();

		$("#config_columns a").on("click", function(e) {
			e.preventDefault();

			if($(this).attr("id") == "reset_to_default")
			{
				//Send a get request wihtout columns will clear column prefs
				$.get(<?php echo json_encode(site_url("$controller_name/save_column_prefs/$invoice_type")); ?>, function()
				{
					reload_invoice_table();
					var $checkboxs = $("#config_columns a").find("input[type=checkbox]");
					$checkboxs.prop("checked", false);

					<?php foreach($default_columns as $default_col) { ?>
							$("#config_columns a").find('#'+<?php echo json_encode($default_col);?>).prop("checked", true);
					<?php } ?>
				});
			}

			if(!$(e.target).hasClass("handle"))
			{
				var $checkbox = $(this).find("input[type=checkbox]");

				if($checkbox.length == 1)
				{
					$checkbox.prop("checked", !$checkbox.prop("checked")).trigger("change");
				}
			}

			return false;
		});


		$("#config_columns input[type=checkbox]").change(
			function(e) {
				var columns = $("#config_columns input:checkbox:checked").map(function(){
      		return $(this).val();
    		}).get();

				$.post(<?php echo json_encode(site_url("$controller_name/save_column_prefs/$invoice_type")); ?>, {columns:columns}, function(json)
				{
					reload_invoice_table();
				});

		});


		enable_sorting("<?php echo site_url("$controller_name/sorting/$invoice_type"); ?>");
		enable_select_all();
		enable_checkboxes();
		enable_row_selection();
		enable_search('<?php echo site_url("$controller_name/suggest/$invoice_type");?>',<?php echo json_encode(lang("confirm_search"));?>);

		<?php if(!$deleted) { ?>
			enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
		<?php } else { ?>
			enable_delete(<?php echo json_encode(lang($controller_name."_confirm_undelete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
		<?php } ?>

	});
</script>

<div class="card card-flush border-0 h-xl-100 statistics"  style="background-color: #817fed; display:none">
    <!--begin::Header-->
    <div class="card-header pt-2">
        <!--begin::Title-->
        <h3 class="card-title">            
            <span class="text-white fs-3 fw-bold me-2"><?= lang('statasics') ?></span>

            <!-- <span class="badge badge-success">Active</span> -->
       </h3>
        <!--end::Title-->        

        <!--begin::Toolbar-->
        
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body d-flex justify-content-between flex-column pt-1 px-0 pb-0">  
        <!--begin::Wrapper-->               
        <div class="d-flex flex-wrap px-9 mb-5">
            <!--begin::Stat-->
            <div class="rounded min-w-125px py-3 px-4 my-1 me-6 days_past_due_btn <?php echo $days_past_due == 'current'?'selected_days_past_due':''; ?>" data-past_due="current"  style="border: 1px dashed rgba(255, 255, 255, 0.15)">
                <!--begin::Number-->
                <div class="d-flex align-items-center">                    
                    <div class="text-white fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="4368" data-kt-countup-prefix="$" data-kt-initialized="1"><?php echo to_currency($this->Invoice->get_balance_past_due($invoice_type,'current'),2,false); ?></div>
                </div>
                <!--end::Number-->

                <!--begin::Label-->
                <div class="fw-semibold fs-6 text-white opacity-50"><?php echo lang('invoices_current'); ?></div>
                <!--end::Label-->
            </div>
            <!--end::Stat-->

			<?php
	foreach (range(30, 120, 30) as $days_past_due_option)
	{ ?>


     <!--begin::Stat-->
	 <div class="rounded min-w-125px py-3 px-4 my-1 me-6 days_past_due_btn <?php echo $days_past_due_option == $days_past_due ?'selected_days_past_due':''; ?>"
								data-past_due="<?php echo $days_past_due_option; ?>" style="border: 1px dashed rgba(255, 255, 255, 0.15)">
                <!--begin::Number-->
                <div class="d-flex align-items-center">                    
                    <div class="text-white fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="120,000" data-kt-initialized="1"><?php echo to_currency($this->Invoice->get_balance_past_due($invoice_type,$days_past_due_option),2,false); ?></div>
                </div>
                <!--end::Number-->

                <!--begin::Label-->
                <div class="fw-semibold fs-6 text-white opacity-50"><?php echo lang('balance_past_due_in')." ".$days_past_due_option." ".lang('days'); ?></div>
                <!--end::Label-->
            </div>
            <!--end::Stat-->
	<?php } ?>

       



        </div>
        <!--end::Wrapper-->

        <!--begin::Chart-->
        
        <!--end::Chart--> 
    </div>
    <!--end::Body-->
</div>

	

<?php
function getStatusCardClass($days_past_due_option)
{
    switch ($days_past_due_option) {
        case '60':
            return 'bg-primary';
        case 'New':
            return 'bg-info';
		
		case 'In Progress':
			return 'bg-primary';	

		case 'Waiting On Customer':
		return 'bg-warning';
		
		case 'Out For Repair':
			return 'bg-secondary';

		case 'Cancelled':
			return 'bg-danger';
       
        default:
            return 'bg-light';
    }
}
?>
<!-- Css Loader  -->
<div class="spinner" id="ajax-loader" style="display:none">
	<div class="rect1"></div>
	<div class="rect2"></div>
	<div class="rect3"></div>
</div>
<div class="manage-row-options hidden">
	<div class="email_buttons invoices text-center">

	<?php if(!$deleted) { ?>
		<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
		<?php echo anchor("$controller_name/delete/$invoice_type",
			'<span class="ion-trash-a"></span> <span class="hidden-xs">'.lang('delete').'</span>'
			,array('id'=>'delete', 'class'=>'btn btn-danger btn-lg disabled delete_inactive ','title'=>lang("delete"))); ?>
		<?php } ?>

		<a href="#" class="btn btn-lg btn-clear-selection btn-warning"><span class="ion-close-circled"></span> <span class="hidden-xs"><?php echo lang('clear_selection'); ?></span></a>

		<?php } else { ?>
			<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
			<?php echo anchor("$controller_name/undelete/$invoice_type",
					'<span class="ion-trash-a"></span> '.'<span class="hidden-xs">'.lang("undelete").'</span>',
					array('id'=>'delete','class'=>'btn btn-success btn-lg disabled delete_inactive','title'=>lang("undelete"))); ?>
			<?php } ?>

			<a href="#" class="btn btn-lg btn-clear-selection btn-warning"><span class="ion-close-circled"></span> <?php echo lang('clear_selection'); ?></a>
	<?php } ?>

	</div>
</div>

	

<div class="container-fluid mt-5">
		<div class="row manage-table  card p-5">
			<div class="card ">
				<div class="card-header rounded rounded-3 p-5">
				<h3 class="card-title w-100">

				<div class="row w-100" >
	<div class="col-md-1 col-sm-10 col-xs-10">
	</div>
		<div class="col-md-7 col-sm-10 col-xs-10">
			<?php echo form_open("$controller_name/search/$invoice_type",array('id'=>'search_form', 'autocomplete'=> 'off')); ?>
				<div class="search no-left-border">
					<ul class="list-inline">
						<li>
							<input type="text" class="form-control form-control form-control-solid" name ='search' id='search' value="<?php echo H($search); ?>" placeholder="<?php echo $deleted ? lang('search_deleted') : lang('search'); ?> <?php echo lang('module_'.$controller_name); ?>"/>
						</li>
						<li class="hidden-xs">
							<?php echo form_dropdown('status', $invoice_status,$status, 'class="form-control form-select form-select-solid" id="status"'); ?>
						</li>
						<li>
							<button type="submit" class="btn btn-primary btn-lg"><span class="ion-ios-search-strong"></span><span class="hidden-xs hidden-sm"> <?php echo lang("search"); ?></span></button>
						</li>

						<li>
							<div class="clear-block <?php echo ($search=='' && $days_past_due == '') ? 'hidden' : ''  ?>">
								<a class="clear" href="<?php echo site_url("invoices/clear_state/$invoice_type"); ?>">
									<i class="ion ion-close-circled"></i>
								</a>
							</div>
						</li>

					</ul>
				</div>

				<input type="hidden" name="days_past_due" id="days_past_due" value="<?php echo $days_past_due; ?>">

			</form>
		</div>
		<div class="col-md-4 col-sm-2 col-xs-2">
			<div class="buttons-list">
				<div class="pull-right">
					<!-- right buttons-->
					<?php if ($this->Employee->has_module_action_permission($controller_name, 'edit', $this->Employee->get_logged_in_employee_info()->person_id) && !$deleted) {?>
					<?php echo anchor("invoices/view/$invoice_type/-1",
						'<span class="ion-plus"> '.lang('invoices_new').'</span>',
						array('id' => 'new_invoice_btn', 'class'=>'btn btn-primary btn-lg hidden-sm hidden-xs', 'title'=>lang('invoices_new')));
					}
					?>


					<div class="piluku-dropdown btn-group">
						<button type="button" class="btn btn-more btn-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<!-- <span class="hidden-xs ion-android-more-horizontal"> </span>
						<i class="visible-xs ion-android-more-vertical"></i> -->
						<i class="las la-wallet fs-2 "></i>
					</button>
					<!-- <ul class="dropdown-menu" role="menu"> -->
					<ul class="dropdown-menu dropdown-menu-right" role="menu">

							<li>
								<?php echo anchor("$controller_name/manage_terms", '<span class="ion-ios-download-outline"> '.lang($controller_name."_manage_terms").'</span>',
									array('class'=>'','title'=> lang($controller_name."_manage_terms"))); ?>
							</li>
						</ul>

				
					</div>
					<button class="btn btn-light btn-icon-success btn-text-success togglestats">
						<span class="svg-icon svg-icon-muted svg-icon-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path opacity="0.3" d="M14 12V21H10V12C10 11.4 10.4 11 11 11H13C13.6 11 14 11.4 14 12ZM7 2H5C4.4 2 4 2.4 4 3V21H8V3C8 2.4 7.6 2 7 2Z" fill="currentColor"/>
						<path d="M21 20H20V16C20 15.4 19.6 15 19 15H17C16.4 15 16 15.4 16 16V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z" fill="currentColor"/>
						</svg>
						</span>
						Toggle Stats
						</button>
				</div>
			</div>
		</div>
			<div class="row">
					<div class="col-md-3">
					<?php echo ($deleted ? lang('deleted').' ' : '').lang('module_'.$controller_name); ?>
					<span title="<?php echo $total_rows; ?> total invoices" class="badge bg-primary tip-left" id="manage_total_items"><?php echo $total_rows; ?></span>
					</div>
					<div class="col-md-9">

					<form id="config_columns"  >
						<div class="piluku-dropdown btn-group table_buttons pull-right">
							<button type="button" class="btn btn-more btn-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<i class="ion-gear-a"></i>
							</button>

							<ul id="sortable" class="dropdown-menu dropdown-menu-left col-config-dropdown" role="menu">
									<li class="dropdown-header"><a id="reset_to_default" class="pull-right"><span class="ion-refresh"></span> <?php echo lang('reset'); ?></a> <?php echo lang('column_configuration'); ?></li>

									<?php foreach($all_columns as $col_key => $col_value) {
										$checked = '';

										if (isset($selected_columns[$col_key]))
										{
											$checked = 'checked ="checked" ';
										}
										?>
										<li class="sort"><a><input <?php echo $checked; ?> name="selected_columns[]" type="checkbox" class="columns" id="<?php echo $col_key; ?>" value="<?php echo $col_key; ?>"><label class="sortable_column_name" for="<?php echo $col_key; ?>"><span></span><?php echo H($col_value['label']); ?></label><span class="handle ion-drag"></span></a></li>
									<?php } ?>
								</ul>
						</div>
					</form>
					</div>
				</div>
					<span class="panel-options custom">
							<div class="pagination pagination-top hidden-print  text-center mt-4" id="pagination_top">
								<?php echo $pagination;?>
							</div>
					</span>
				</h3>

			
			</div>
				<div class="card-body nopadding table_holder table-responsive" id="table_holder">
					<?php echo $manage_table; ?>
				</div>
		</div>
		<div class="text-center">
		<div class="pagination hidden-print alternate text-center" id="pagination_bottom" >
			<?php echo $pagination;?>
		</div>
		</div>
	</div>
</div>
<script type="text/javascript">

	$(".days_past_due_btn").click(function(){
		$(".days_past_due_btn").removeClass('selected_days_past_due');
		$(this).addClass('selected_days_past_due');
		$("#days_past_due").val($(this).data('past_due'));
		$("#search_form").submit();
	});

	$(document).ready(function()
	{
		<?php if ($this->session->flashdata('success')) { ?>
		show_feedback('success', <?php echo json_encode($this->session->flashdata('success')); ?>, <?php echo json_encode(lang('success')); ?>);
		<?php } ?>

		<?php if ($this->session->flashdata('error')) { ?>
		show_feedback('error', <?php echo json_encode($this->session->flashdata('error')); ?>, <?php echo json_encode(lang('error')); ?>);
		<?php } ?>

	});
</script>

<?php $this->load->view("partial/footer"); ?>

