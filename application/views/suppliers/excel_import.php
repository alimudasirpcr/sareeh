<?php $this->load->view("partial/header"); ?>
<div class="row" id="form">
	<div class="spinner" id="grid-loader" style="display:none">
	  <div class="rect1"></div>
	  <div class="rect2"></div>
	  <div class="rect3"></div>
	</div>
	<div class="col-md-12">
		<div class="card ">
			<div class="card-header rounded rounded-3 p-5">
				<?php echo lang('mass_import_from_excel'); ?>
			</div>
			<div class="card-body">
				
				<?php echo form_open_multipart('suppliers/do_excel_import/',array('id'=>'supplier_form','class'=>'form-horizontal')); ?>
					<h3><?php echo lang('step_1'); ?>: </h3>
					<p><?php echo lang('suppliers_step_1_desc'); ?></p>
					
					<ul class="list-inline">
						<li>
							<a class="btn btn-success btn-sm " href="<?php echo site_url('suppliers/excel'); ?>"><?php echo lang('suppliers_new_suppliers_import'); ?></a>
						</li>
						<li>
							<?php echo lang('or');?>
						</li>
						<li>
							<a class="btn btn-success btn-sm " href="<?php echo site_url('suppliers/excel_export'); ?>"><?php echo lang('suppliers_update_suppliers_import'); ?></a>
						</li>
					</ul>
			
										
					<h3><?php echo lang('step_2'); ?>: </h3>
					<p><?php echo lang('suppliers_step_2_desc'); ?></p>						
					<div class="form-group">
						<ul class="text-danger" id="error_message_box"></ul>
						<?php echo form_label(lang('file_path').':', 'file_path',array('class'=>'col-sm-12 control-label text-left')); ?>
						<div class="col-sm-12">
							<ul class="list-inline">
								<li class="w-40">
									<input type="file" name="file_path" id="file_path" class="filestyle" data-icon="false" >
								</li>
								<li>
									<?php echo form_submit(array(
									'name'=>'submitf',
									'id'=>'submitf',
									'value'=>lang('save'),
									'class'=>'btn btn-primary')
									); ?>
								</li>
							</ul>
						</div>
					</div>
				<?php echo form_close() ?>
			</div>
		</div>	
	</div>
</div>
</div>
		
<script type='text/javascript'>
	//validation and submit handling
	$(document).ready(function()
	{	
		var submitting = false;
		$('#supplier_form').validate({
			submitHandler:function(form)
			{
				if (submitting) return;
				submitting = true;
$('#grid-loader').show();
				$(form).ajaxSubmit({
					success:function(response)
					{
$('#grid-loader').hide();
						if(!response.success)
						{ 
							show_feedback('error', response.message, <?php echo json_encode(lang('error')); ?>,{timeOut:0, extendedTimeOut:0});
						}
						else
						{
							show_feedback('success', response.message, <?php echo json_encode(lang('success')); ?>,{timeOut:0, extendedTimeOut:0});
						}
						submitting = false;
					},
					dataType:'json',
					resetForm: true
				});
			},
			errorLabelContainer: "#error_message_box",
	 		wrapper: "li",
			highlight:function(element, errorClass, validClass) {
				$(element).parents('.form-group').addClass('error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('error');
				$(element).parents('.form-group').addClass('success');
			},
			rules: 
			{
				file_path:"required"
	   		},
			messages: 
			{
	   			file_path:<?php echo json_encode(lang('full_path_to_excel_required')); ?>
			}
		});
	});
</script>
<?php $this->load->view("partial/footer"); ?>