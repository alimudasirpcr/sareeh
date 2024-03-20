<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
	
	
	function date_time_callback()
	{
		save_filters();
	}
	
	function save_filters()
	{
		$("form#config_filters input[type=hidden]").each(function (i) {
			if (this.value == '') {
				$(this).attr("disabled",true);
			} else {
				$(this).attr("disabled",false);
			}
    });
								
		$("#config_filters").ajaxSubmit({
			success:function(response)
			{
				reload_delivery_table();
			},
			dataType:'json',
			resetForm: false
		});
	}
	
	function reload_appointment_table()
	{
		clearSelections();
		$("#table_holder").load(<?php echo json_encode(site_url("$controller_name/reload_appointment_table")); ?>);
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

		
		
		enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>");
		enable_select_all();
		enable_checkboxes();
		enable_row_selection();
		enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("confirm_search"));?>);
		
		<?php if(!$deleted) { ?>
			enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
		<?php } else { ?>
			enable_delete(<?php echo json_encode(lang($controller_name."_confirm_undelete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
		<?php } ?>
	});
</script>




<div class="container-fluid">
		<div class="row manage-table  card p-5">
			<div class="card ">
				<div class="card-header align-items-center py-1 gap-2 gap-md-5">
				<h3 class="card-title">

				<div class="manage_buttons mb-5">
<div class="manage-row-options hidden">
	<div class="email_buttons appointments text-center">		
		
	<?php if(!$deleted) { ?>
		<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
		<?php echo anchor("$controller_name/delete",
			'<span class="ion-trash-a"></span> <span class="hidden-xs">'.lang('delete').'</span>'
			,array('id'=>'delete', 'class'=>'btn btn-danger btn-lg disabled delete_inactive ','title'=>lang("delete"))); ?>
		<?php } ?>

		<a href="#" class="btn btn-lg btn-clear-selection btn-warning"><span class="ion-close-circled"></span> <span class="hidden-xs"><?php echo lang('clear_selection'); ?></span></a>
		
	<?php } else { ?>
			<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
			<?php echo anchor("$controller_name/undelete",
					'<span class="ion-trash-a"></span> '.'<span class="hidden-xs">'.lang("undelete").'</span>',
					array('id'=>'delete','class'=>'btn btn-success btn-lg disabled delete_inactive','title'=>lang("undelete"))); ?>
			<?php } ?>

			<a href="#" class="btn btn-lg btn-clear-selection btn-warning"><span class="ion-close-circled"></span> <?php echo lang('clear_selection'); ?></a>		
	<?php } ?>
		
	</div>
</div>

	<div class="">
		<div class="">
			<?php echo form_open("$controller_name/search",array('id'=>'search_form', 'autocomplete'=> 'off')); ?>
				<div class="search no-left-border">
					<ul class="list-inline">
						<li>
							<input type="text" class="form-control form-control form-control-solid" name ='search' id='search' value="<?php echo H($search); ?>" placeholder="<?php echo $deleted ? lang('search_deleted') : lang('search'); ?> <?php echo lang('module_'.$controller_name); ?>"/>
						</li>
						<li>
							<button type="submit" class="btn btn-primary btn-lg">
								<span class="ion-ios-search-strong"></span>
								<span class="hidden-xs hidden-sm"> <?php echo lang("search"); ?></span>
							</button>
						</li>
						<li>
							<div class="clear-block <?php echo ($search=='') ? 'hidden' : ''  ?>">
								<a class="clear" href="<?php echo site_url($controller_name.'/clear_state'); ?>">
									<i class="ion ion-close-circled"></i>
								</a>
							</div>
						</li>
					</ul>
				</div>				
			</form>	
		</div>
		
	</div>
</div>
				
					
		
						
						<span class="panel-options custom">
							<div class="pagination pagination-top hidden-print  text-center" id="pagination_top">
								<?php echo $pagination;?>		
							</div>
					</span>
				</h3>

				<div class="card-toolbar flex-row-fluid justify-content-end gap-5">	
			<div class="buttons-list">
				<div class="pull-right-btn">
					<!-- right buttons-->
					<?php if ($this->Employee->has_module_action_permission($controller_name, 'add', $this->Employee->get_logged_in_employee_info()->person_id) && !$deleted) {?>				
						<?php
						 echo	anchor("$controller_name/view/-1",
							'<span class="ion-plus"></span> '.lang($controller_name.'_new'),
							array('class'=>'btn btn-primary btn-lg hidden-sm hidden-xs', 
								'title'=>lang($controller_name.'_new')));
						?>
					<?php } ?>
					
					<div class="piluku-dropdown btn-group">						
					<button onclick="window.location='<?php echo site_url("appointments/calendar"); ?>'" type="button" class="btn btn-more btn-light-primary dropdown-toggle hidden-sm hidden-xs" data-toggle="dropdown" aria-expanded="false">
						<span class="visible-xs ion-android-more-vertical"></span>
						<span class="hidden-xs"><span class="ion-calendar"></span> <?php echo lang('appointments_calendar'); ?></span>
					</button>
					</div>
					
					<?php if($deleted) { 
						echo 
						anchor("$controller_name/toggle_show_deleted/0",
							'<span class="ion-android-exit"></span> <span class="hidden-xs">'.lang('done').'</span>',
							array('class'=>'btn btn-primary btn-lg toggle_deleted','title'=> lang('done')));
					} ?>
					
					<?php if(!$deleted) { ?>
								
					<div class="piluku-dropdown btn-group">
						<button type="button" class="btn btn-more btn-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<!-- <span class="hidden-xs ion-android-more-horizontal"> </span>
						<i class="visible-xs ion-android-more-vertical"></i> -->

							<i class="las la-wallet fs-2 "></i>
					</button>
					<ul class="dropdown-menu dropdown-menu-right" role="menu">										
						<li class="visible-sm visible-xs">
							<a href="<?php echo site_url("appointments/calendar"); ?>"><span class="ion-calendar"> </span> <?php echo lang('appointments_calendar'); ?></a>
						</li>
						<li class="visible-sm visible-xs">
							<?php if ($this->Employee->has_module_action_permission($controller_name, 'add', $this->Employee->get_logged_in_employee_info()->person_id) && !$deleted) {?>				
								<?php
								 echo	anchor("$controller_name/view/-1",
									'<span class="ion-plus"></span> '.lang($controller_name.'_new'),
									array('class'=>'', 
										'title'=>lang($controller_name.'_new')));
								?>
							<?php } ?>	
						</li>
						<li>
								<?php
								$year = date('Y');
								$month = date('m');
								$day = date('d');
								 echo anchor("$controller_name/calendar/$year/$month/-1/$day", '<span class="ti ti-calendar"> '.lang($controller_name."_todays_appointments").'</span>',
									array('class'=>'','title'=> lang($controller_name."_manage_appointment_types"))); ?>
						</li>
						
						
						<li>
								<?php echo anchor("$controller_name/manage_appointment_types", '<span class="ion-ios-copy"> '.lang($controller_name."_manage_appointment_types").'</span>',
									array('class'=>'','title'=> lang($controller_name."_manage_appointment_types"))); ?>
						</li>
						
						<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
							<li>
									<?php echo anchor("$controller_name/toggle_show_deleted/1", '<span class="ion-trash-a"> '.lang($controller_name."_manage_deleted").'</span>',
										array('class'=>'toggle_deleted','title'=> lang($controller_name."_manage_deleted"))); ?>
							</li>
						<?php }?>
					</ul>
					</div>
					<?php } ?>
				</div>
			</div>				
		</div>

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

