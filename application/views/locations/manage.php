<?php $this->load->view("partial/header"); 
$this->load->helper('demo');
?>
<script type="text/javascript">
$(document).ready(function()
{	
	enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>");
	 enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name");?>',<?php echo json_encode(lang("confirm_search"));?>);
				
		<?php if(!$deleted) { ?>
			enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
		<?php } else { ?>
			enable_delete(<?php echo json_encode(lang($controller_name."_confirm_undelete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
		<?php } ?>
			
	 <?php if ($this->session->flashdata('manage_success_message')) { ?>
		show_feedback('success', <?php echo json_encode($this->session->flashdata('manage_success_message')); ?>, <?php echo json_encode(lang('success')); ?>);
	 <?php } ?>
});

</script>
<div class="manage_buttons">
	<!-- Css Loader  -->
	<div class="spinner" id="ajax-loader" style="display:none">
	  <div class="rect1"></div>
	  <div class="rect2"></div>
	  <div class="rect3"></div>
	</div>
	<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $this->session->flashdata('error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="manage-row-options   px-5 hidden">
	<div class="email_buttons locations">
		<?php if(!$deleted) {?>
		<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>					
			<?php echo 
				anchor("$controller_name/delete",
				'<span class="ion-trash-a"></span> '.lang('delete'),
				array('id'=>'delete', 
					'class'=>'btn btn-danger btn-lg tip-bottom disabled','title'=>lang("delete"))); 
			?>
		<?php } ?>
		
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

	
</div>

<div class="add-location-link">
	<div class="col-md-12 text-center">
		<?php
		$total_locations = $this->Location->count_all();
		$allowed = getenv('ALLOWED_LOCATIONS');
		if($allowed <= $total_locations){
		if (!is_on_demo_host() && !$deleted) { ?>
			<div class="alert alert-info" role="alert"><?php echo lang('locations_adding_location_requires_addtional_license'); ?>: <strong><a href="http://<?php echo $this->config->item('branding')['domain']; ?>/buy_additional.php" target="_blank"><?php echo lang('locations_purchase_additional_locations'); ?></a></strong></div>
		<?php }
		
		}?>
	</div>
</div>


	<div class="container-fluid">
		<div class="row <?php echo !$deleted ?  'manage-table  ' : ''; ?>">
			<div class="card ">
				<div class="card-header align-items-center py-1 gap-2 gap-md-5">
				<!-- <h3 class="panel-title">
					<?php echo ($deleted ? lang('deleted').' ' : '').lang('module_'.$controller_name); ?>
					<span title="<?php echo $total_rows; ?> total <?php echo $controller_name?>" class="badge bg-primary tip-left" id="manage_total_items"><?php echo $total_rows; ?></span>
					<span class="panel-options custom">
							<div class="pagination hidden-print alternate text-center fg-toolbar ui-toolbar" id="pagination_top" >
								<?php echo $pagination;?>
							</div>
					</span>

				</h3> -->
			
		<div class="card-title">
			<?php echo form_open("$controller_name/search",array('id'=>'search_form', 'autocomplete'=> 'off')); ?>
				<div class="search no-left-border d-flex justify-content-evenly gap-2">
					<input type="text" class="form-control form-control-solid" name ='search' id='search' value="<?php echo H($search); ?>" placeholder="<?php echo $deleted ? lang('search_deleted') : lang('search'); ?> <?php echo lang('module_'.$controller_name); ?>"/>
					<select class="form-select" aria-label="Select example" name="company" id="company">
					<option  value="">Select Company</option>
						<?php if(count($companies->result()) > 0):
								foreach($companies->result() as $c):?>
									<option value="<?php echo  $c->company ?>"><?php echo  $c->company ?></option>
						

						<?php endforeach; endif; ?>
						
					</select>
					<select class="form-select" aria-label="Select example" name="business_type" id="business_type">
						<option value="">Select Business type</option>
						<?php if(count($business_types->result()) > 0):
								foreach($business_types->result() as $b):?>
									<option value="<?php echo  $b->business_type ?>"><?php echo  $b->business_type ?></option>
						

						<?php endforeach; endif; ?>
					</select>
					<button type="submit" class="btn btn-primary">Search</button>
					<div class="clear-block <?php echo ($search=='') ? 'hidden' : ''  ?>">
					<a class="clear" href="<?php echo site_url($controller_name.'/clear_state'); ?>">
						<i class="ion ion-close-circled"></i>
					</a>	
				</div>
				</div>
				
				
			<?php echo form_close() ?>
			
		</div>
		<div class="card-toolbar flex-row-fluid justify-content-end gap-5">	
			<div class="buttons-list">
				<div class="pull-right-btn">
					
					<?php if ($deleted) 
					{
						echo 
						anchor("$controller_name/toggle_show_deleted/0",
							'<span class="ion-android-exit"></span> <span class="hidden-xs">'.lang('done').'</span>',
							array('class'=>'btn btn-primary btn-lg toggle_deleted','title'=> lang('done')));
					}
					?>
					<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id) && !$deleted) {?>				
						<?php echo 
							anchor("$controller_name/view/-1/",
							'<span class="ion-plus"></span> '.lang($controller_name.'_new'),
							array('class'=>'btn btn-primary btn-lg hidden-sm hidden-xs', 
								'title'=>lang($controller_name.'_new'),
								'id' => 'new_location_btn'));
						?>
					<?php } ?>
					
					<?php if(!$deleted) { ?>
					
					<div class="piluku-dropdown btn-group">
						<button type="button" class="btn btn-more btn-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<!-- <span class="hidden-xs ion-android-more-horizontal"> </span>
						<i class="visible-xs ion-android-more-vertical"></i> -->
						<i class="las la-wallet fs-2 "></i>
					</button>
					<!-- <ul class="dropdown-menu" role="menu"> -->
					<ul class="dropdown-menu dropdown-menu-right" role="menu">

							
							<li class="visible-sm visible-xs">
									<?php echo anchor("$controller_name/view/-1", '<span class="ion-plus"> '.lang($controller_name."_new").'</span>',
										array('class'=>'new_location','title'=> lang($controller_name."_new"))); ?>
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
			<div class="card-body nopadding table_holder table-responsive" >
				<?php echo $manage_table; ?>			
			</div>		
		</div>
	</div>
</div>

<div class="row pagination hidden-print alternate text-center fg-toolbar ui-toolbar" id="pagination_bottom" >
	<?php echo $pagination;?>
</div>
</div>
<?php if (!is_on_demo_host()) { ?>
	<script type="text/javascript">
	$('#new_location_btn').click(function()
	{
		bootbox.confirm({
			message: <?php echo json_encode(lang('locations_confirm_purchase')); ?>, 
			buttons: {
	      confirm: {
	          label: <?php echo json_encode(lang('yes')); ?>,
	          className: 'btn-primary'
	      },
	      cancel: {
	          label: <?php echo json_encode(lang('no')); ?>,
	          className: 'btn-default'
	      }
			},
			callback: function(result)
			{
				if (result)
				{
					window.location='http://<?php echo $this->config->item('branding')['domain']; ?>/buy_additional.php';
				}
				else
				{
					window.location = $("#new_location_btn").attr('href');
				}
			} 
		});
		
		return false;
	})
	</script>	
<?php } ?>		

<?php $this->load->view("partial/footer"); ?>