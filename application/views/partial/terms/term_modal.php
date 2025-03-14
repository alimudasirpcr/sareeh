<div class="modal fade" id="term-modal" tabindex="-1" role="dialog" aria-labelledby="termData" aria-hidden="true">
    <div class="modal-dialog customer-recent-sales">
		<div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true">&times;</span></button>
	          	<h4 class="modal-title" id="termModalDialogTitle"><?php echo H(lang('term'));?></h4>
	        </div>
	        <div class="modal-body">
				<!-- Form -->
				<?php echo form_open('invoices/save_term/',array('id'=>'terms_form','class'=>'form-horizontal')); ?>
				
				<input type="hidden" name="term_id" id="term_id">
				<div class="form-group">
					<?php echo form_label(lang('term_name').':', 'term_name',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-9">
						<?php echo form_input(array(
							'type'  => 'text',
							'name'  => 'name',
							'id'    => 'name',
							'value' => '',
							'class'=> 'form-control form-inps',
						)); ?>
					</div>
				</div>
				
				
				<div class="form-group">
					<?php echo form_label(lang('description').':', 'description',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-9">
					<?php echo form_textarea(array(
							'name' => 'description',
							'id' => 'description',
							'class' => 'form-control text-area',
							'rows' => '4',
							'cols' => '30',
							'value' => '')); ?>
					</div>
				</div>
				
					
				<div class="form-group">
					<?php echo form_label(lang('days_due').':', 'term_name',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-9">
						<?php echo form_input(array(
							'type'  => 'text',
							'name'  => 'days_due',
							'id'    => 'days_due',
							'value' => '30',
							'class'=> 'form-control form-inps',
						)); ?>
					</div>
				</div>				
								
								
				<div class="form-actions">
					<?php
						echo form_submit(array(
							'name'=>'submitf',
							'id'=>'submitf',
							'value'=>lang('save'),
							'class'=>'submit_button pull-right btn btn-primary')
						);
					?>
					<div class="clearfix">&nbsp;</div>
				</div>
			
				<?php echo form_close(); ?>
	        </div>
    	</div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
	
</script>
