<?php $this->load->view("partial/header"); ?>

<?php if($redirect) { ?>
<div class="manage_buttons">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top-10">
			<div class="buttons-list">
				<div class="pull-right-btn">
				<?php echo 
					anchor(site_url($redirect), ' ' . lang('common_done'), array('class'=>'btn btn-primary btn-lg ion-android-exit', 'title'=>''));
				?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

 <div class="row <?php echo $redirect ? 'manage-table  ' :''; ?>"> 
	<div class="col-md-12 card p-5">
		
			<div class="card-header rounded rounded-3 p-5">
				<?php echo lang("work_orders_manage_checkbox"); ?>
			</div>
			<div class="card-toolbar">
				<!--begin::Toolbar-->
				<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

					<a href="<?php echo site_url('work_orders/checkbox_group'); ?>" class="add_checkbox btn btn-primary" style="margin:10px"> <span class="svg-icon svg-icon-2">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
							<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
						</svg>
					</span> <?php echo lang('work_orders_add_checkbox'); ?></a>
					<!--end::Add user-->
				</div>
				<!--end::Toolbar-->
			</div>
			<div class="card-body">
				<div class="row">	
					<div class="col-md-12 col-sm-12 col-lg-12">
						<div class="table-responsive">
							<table id="modifiers" class="table table-rounded table-striped border gy-7 gs-7">
								<thead>
									<tr>
										<th><?php echo lang('common_edit'); ?></th>
										<th><?php echo lang('common_name'); ?></th>
										<th><?php echo lang('work_orders_pre'); ?></th>
										<th><?php echo lang('work_orders_post'); ?></th>
										<th><?php echo lang('common_delete'); ?></th>
									</tr>
								</thead>
						
								<tbody>
									<?php foreach($checkbox_groups as $group) { ?>
										<tr data-id="<?php echo H($group->id); ?>">
											<td> <a class="edit_modifier btn btn-primary" href="<?php echo site_url('work_orders/checkbox_group/'.$group->id); ?>"><?php echo lang('common_edit'); ?></a></td>	
											<td class="group_name"> <?php echo H($group->name); ?></td>
											<td class="pre_checkboxes"><?php echo $group->pre_checkboxes; ?></td>
											<td class="post_checkboxes"><?php echo $group->post_checkboxes; ?></td>
											<td style="cursor: pointer;"><a class="delete_checkbox_group btn btn-danger"><?php echo lang('common_delete'); ?></a></td>	
										</tr>
									<?php } ?>
								</tbody>
							</table>

							

						</div>
					</div>
				</div>
			</div>
	</div>
</div>

</div>
<script type='text/javascript'>
	$(document).on('click', '.delete_checkbox_group', function(e) {
		var $tr = $(this).closest("tr");
		var id = $tr.data('id');
		
		bootbox.confirm(<?php echo json_encode(lang('work_orders_checkbox_delete_confirmation')); ?>, function(res){
			if (res){
				$.post(<?php echo json_encode(site_url('work_orders/delete_checkbox'));?>,{group_id: id}, function(response){
					$tr.remove();
					show_feedback(response.success ? 'success' : 'error', response.message, response.success ? <?php echo json_encode(lang('common_success')); ?> : <?php echo json_encode(lang('common_error')); ?>);
				}, "json");
			}
		});
	});
	
</script>
<?php $this->load->view('partial/footer'); ?>
