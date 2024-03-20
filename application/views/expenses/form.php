<?php $this->load->view("partial/header"); ?>
<?php $this->load->view('partial/categories/expense_category_modal', array('categories' => $categories));?>
<div class="row" id="form">
	
	<div class="spinner" id="grid-loader" style="display:none">
	  <div class="rect1"></div>
	  <div class="rect2"></div>
	  <div class="rect3"></div>
	</div>
	<div class="col-md-12">
		 <?php echo form_open('expenses/save/'.$expense_info->id,array('id'=>'expenses_form','class'=>'form-horizontal')); ?>
		<div class="card ">
			<div class="card-header rounded rounded-3 p-5">
                    <h3 class="card-title">
                        <i class="ion-edit"></i> <?php if(!$expense_info->id) { echo lang('expenses_new'); } else { echo lang('expenses_update'); } ?>
								<small>(<?php echo lang('fields_required_message'); ?>)</small>
	                </h3>
						 
            </div>
			<div class="card-body">
			<h5><?php echo lang("expenses_basic_information"); ?></h5>
				
				<div class="form-group p-lr-15">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
					<?php echo form_label(lang('expenses_date').':', 'expenses_date_input', array('class'=>'required form-label')); ?>
					</div> 	
					<div class="col-sm-9 col-md-9 col-lg-10 cmp-inps">
					<div class="input-group date">
				    	<span class="input-group-text"><i class="ion-calendar"></i></span>
				    	<?php echo form_input(array(
				      		'name'=>'expenses_date',
							'id'=>'expenses_date_input',
							'class'=>'form-control form-inps datepicker',
							'value'=>$expense_info->expense_date ? date(get_date_format(), strtotime($expense_info->expense_date)) : date(get_date_format()))
				    	);?> 
				    </div>  
				</div>
				</div>  
				<div class="form-group">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
					<?php echo form_label(lang('expenses_amount').':', 'expenses_amount_input', array('class'=>'required form-label')); ?>
				</div>
					<div class="col-sm-9 col-md-9 col-lg-10 cmp-inps">
						<?php echo form_input(array(
							'class'=>'form-control form-inps',
							'name'=>'expenses_amount',
							'id'=>'expenses_amount_input',
							'value'=>$expense_info->expense_amount? to_currency_no_money($expense_info->expense_amount) : '')
						);?>
					</div>
				</div>
				
				
				<div class="form-group">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
					<?php echo form_label(lang('payment').':', 'expense_payment_type_input', array('class'=>'required form-label')); ?>
					</div>	<div class="col-sm-9 col-md-9 col-lg-10 cmp-inps">
						
						
						<?php echo form_dropdown('expense_payment_type', $payment_types,$expense_info->expense_payment_type,'class="form-control"');
					?>
					</div>
				</div>
				
				
				
				<div class="form-group">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
					<?php echo form_label(lang('tax').':', 'expenses_tax_input', array('class'=>'required form-label')); ?>
					</div>	<div class="col-sm-9 col-md-9 col-lg-10 cmp-inps">
						<?php echo form_input(array(
							'class'=>'form-control form-inps',
							'name'=>'expenses_tax',
							'id'=>'expenses_tax_input',
							'value'=>$expense_info->expense_tax? to_currency_no_money($expense_info->expense_tax) : to_currency_no_money(0))
						);?>
					</div>
				</div>
				
				
				<div class="form-group">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
				<?php echo form_label(lang('expenses_description').':', 'expenses_description_input', array('class'=>'required form-label')); ?>
				</div><div class="col-sm-9 col-md-9 col-lg-10 cmp-inps">
					<?php echo form_input(array(
						'class'=>'form-control form-inps',
						'name'=>'expenses_description',
						'id'=>'expenses_description_input',
						'value'=>$expense_info->expense_description)
					);?>
					</div>
				</div>
				
				
				<div class="form-group">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
					<?php echo form_label(lang('type').':', 'expenses_type_input', array('class'=>'required form-label')); ?>
					</div>	<div class="col-sm-9 col-md-9 col-lg-10 cmp-inps">
						<?php echo form_input(array(
							'class'=>'form-control form-inps',
							'name'=>'expenses_type',
							'id'=>'expenses_type_input',
							'value'=>$expense_info->expense_type)
						);?>
					</div>
				</div>
				
				
				<div class="form-group">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
					<?php echo form_label(lang('reason').':', 'expenses_reason_input', array('class'=>'2 control-label')); ?>
					</div>	<div class="col-sm-9 col-md-9 col-lg-10 cmp-inps">
						<?php echo form_input(array(
							'class'=>'form-control form-inps',
							'name'=>'expense_reason',
							'id'=>'expenses_reason_input',
							'value'=>$expense_info->expense_reason)
						);?>
					</div>
				</div>
				
				<div class="form-group">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
					<?php echo form_label(lang('category').':', 'category_id',array('class'=>' control-label  required wide')); ?>
					</div>	<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_dropdown('category_id', $categories,$expense_info->category_id, 'class="form-control form-inps" id ="category_id"');?>
							<?php if ($this->Employee->has_module_action_permission('expenses', 'manage_categories', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
							<div>
								<a href="javascript:void(0);" id="add_category"><?php echo lang('add_category'); ?></a>&nbsp;|&nbsp;<?php echo anchor("expenses/manage_categories",lang('items_manage_categories'),array('target' => '_blank', 'title'=>lang('items_manage_categories')));?>
							</div>
							<?php } ?>		
					</div>
				</div>
			
				<div class="form-group">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
					<?php echo form_label(lang('expenses_recipient_name').':', 'employee_id', array('class'=>' control-label')); ?>
					</div>	<div class="col-sm-9 col-md-9 col-lg-10 cmp-inps">
						<?php echo form_dropdown('employee_id',$employees, $expense_info->employee_id ? $expense_info->employee_id : $logged_in_employee_id , 'id="employee_id" class=""'); ?>
					</div>
				</div>


				<div class="form-group">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
					<?php echo form_label(lang('approved_by').':', 'approved_employee_id', array('class'=>' control-label')); ?>
					</div>	<div class="col-sm-9 col-md-9 col-lg-10 cmp-inps">
						<?php echo form_dropdown('approved_employee_id',$employees, $expense_info->approved_employee_id ? $expense_info->approved_employee_id : $logged_in_employee_id , 'id="approved_employee_id" class=""'); ?>
					</div>
				</div>
    
				<div class="form-group">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
					<?php echo form_label(lang('expenses_note').':', 'expenses_note_input', array('class'=>' control-label')); ?>
					</div>	<div class="col-sm-9 col-md-9 col-lg-10 cmp-inps">
						<?php echo form_textarea(array(
							'class'=>'form-control text-area',
							'name'=>'expenses_note',
							'id'=>'expenses_note_input',
							'rows'=>'5',
							'cols'=>'17',
							'value'=>$expense_info->expense_note)
						);?>
					</div>
				</div>
				<?php if($expense_info->id !=''): 
					?>
					<div class="col-sm-2 ">
					</div>
					<div class="col-sm-10 ">
				<div class="fv-row">
					<!--begin::Dropzone-->
					<div class="dropzone" id="kt_dropzonejs_example_344533">
						<!--begin::Message-->
						<div class="dz-message needsclick">
							<i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

							<!--begin::Info-->
							<div class="ms-4">
								<h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
								<span class="fs-7 fw-semibold text-gray-500">Upload up single</span>
							</div>
							<!--end::Info-->
						</div>
					</div>
					<!--end::Dropzone-->
				</div>
				</div>
				<?php else: ?>
				<!--end::Input group-->
				<div class="form-group">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
					<?php echo form_label(lang('upload_images').':', 'expense_image_id',array('class'=>'control-label ')); ?>
					</div>	<div class="col-sm-9 col-md-9 col-lg-10">
						<ul class="list-unstyled avatar-list">
							<li>
								<input type="file" name="expense_image_id" id="expense_image_id" class="filestyle" accept=".png,.jpg,.jpeg,.gif" >&nbsp;
							</li>	
						</ul>
					</div>
				</div>
				<?php endif; ?>
				<div class="col-sm-2 ">
					</div>
				<div class="col-sm-10 p-3">
				<?php echo $expense_info->expense_image_id ? '<div id="avatar" class="symbol symbol-200px ">'.img(array('src' => cacheable_app_file_url($expense_info->expense_image_id),'class'=>'img-polaroid img-polaroid-s')).'</div>' : '<div id="avatar">'.img(array('src' => base_url().'assets/img/empty.png','class'=>'img-polaroid','id'=>'image_empty')).'</div>'; ?>
					
				</div>
					

				<?php if($expense_info->expense_image_id) {  ?>

				<div class="form-group">
				<div class="col-sm-3 col-md-3 col-lg-2 cmp-inps">
					<?php echo form_label(lang('del_image').':', 'del_image',array('class'=>' control-label')); ?>
					</div>		<div class="col-sm-9 col-md-9 col-lg-10">
					<?php echo form_checkbox(array(
						'name'=>'del_image',
						'id'=>'del_image',
						'class'=>'delete-checkbox', 
						'value'=>1
					));
					echo '<label for="del_image"><span></span></label> ';
					?>
					</div>
				</div>

				<?php }  ?>

				<?php
				//Only allow removal from register for NEW expenses
				if ($this->config->item('track_payment_types') && !$expense_info->id)
				{
				?>	
					<div class="form-group">
					<?php echo form_label(lang('remove_cash_from_register').':', 'cash_register_id', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10 cmp-inps">
							<?php echo form_dropdown('cash_register_id', $registers, '' , 'id="cash_register_id" class=""'); ?>
						</div>
					</div>
					
					<div class="col-12">
						<?php if ($this->Employee->has_module_action_permission('sales', 'add_remove_amounts_from_cash_drawer', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
							<?php echo anchor_popup(site_url('sales/open_drawer'), '<i class="ion-android-open"></i> '.lang('pop_open_cash_drawer'),array('class'=>'', 'target' => '_blank')); ?>
						<?php } ?>
					</div>
				<?php } ?>

				<div class="card ">
					<div class="card-header rounded rounded-3 p-5">
						<h3 class="card-title">
							<i class="ion-folder"></i> 
							<?php echo lang("files"); ?>
						</h3>
					</div>
		
					<?php if (count($files)) {?>
					<ul class="list-group">
						<?php foreach($files as $file){?>
						<li class="list-group-item permission-action-item">
							<?php echo anchor($controller_name.'/delete_file/'.$file->file_id,'<i class="icon ion-android-cancel text-danger" style="font-size: 120%"></i>', array('class' => 'delete_file'));?>	
							<?php echo anchor($controller_name.'/download/'.$file->file_id,$file->file_name,array('target' => '_blank'));?>
						</li>
						<?php } ?>
					</ul>
					<?php } ?>
					<?php if($expense_info->id ==''): 
					?>
					<h4 style="padding: 20px;"><?php echo lang('add_files');?></h4>
					<?php for($k=1;$k<=5;$k++) { ?>
						<div class="form-group"  style="padding-left: 10px;">
				    	<?php echo form_label(lang('file').' '.$k.':', 'files_'.$k,array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
						      	<div class="file-upload">
								<input type="file" name="files[]" id="files_<?php echo $k; ?>" >
								</div>
							</div>
						</div>
					<?php } endif; ?>



				</div>
				<?php if($expense_info->id !=''): ?>
				<div class="form-group card">
        <!--begin::Label-->
	
        <label class="col-lg-2 col-form-label text-lg-right">Upload Files:</label>
        <!--end::Label-->

        <!--begin::Col-->
        <div class="col-lg-10">
            <!--begin::Dropzone-->
            <div class="dropzone dropzone-queue mb-2" id="kt_dropzonejs_example_3">
                <!--begin::Controls-->
                <div class="dropzone-panel mb-lg-0 mb-2">
                    <a class="dropzone-select btn btn-sm btn-primary me-2">Attach files</a>
                    <a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove All</a>
                </div>
                <!--end::Controls-->

                <!--begin::Items-->
                <div class="dropzone-items wm-200px">
                    <div class="dropzone-item" style="display:none">
                        <!--begin::File-->
                        <div class="dropzone-file">
                            <div class="dropzone-filename" title="some_image_file_name.jpg">
                                <span data-dz-name>some_image_file_name.jpg</span>
                                <strong>(<span data-dz-size>340kb</span>)</strong>
                            </div>

                            <div class="dropzone-error" data-dz-errormessage></div>
                        </div>
                        <!--end::File-->

                        <!--begin::Progress-->
                        <div class="dropzone-progress">
                            <div class="progress">
                                <div
                                    class="progress-bar bg-primary"
                                    role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                </div>
                            </div>
                        </div>
                        <!--end::Progress-->

                        <!--begin::Toolbar-->
                        <div class="dropzone-toolbar">
                            <span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                </div>
                <!--end::Items-->
            </div>
            <!--end::Dropzone-->

            <!--begin::Hint-->
            <span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
            <!--end::Hint-->
        </div>
        <!--end::Col-->
    </div>
	<?php endif; ?>
			<?php echo form_hidden('redirect', $redirect_code); ?>

			<div class="form-actions pull-right">
			<?php
				echo form_submit(array(
					'name'=>'submitf',
					'id'=>'submitf',
					'value'=>lang('save'),
					'class'=>'btn btn-primary btn-lg submit_button floating-button btn-large')
					);
			?>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>
</div>
</div>

<script type='text/javascript'>
	<?php if($expense_info->id !=''): 
					?>
	var myDropzone = new Dropzone("#kt_dropzonejs_example_344533", {
		url: "<?php echo base_url('expenses/upload_files/'.$expense_info->id) ?>", // Set the url for your upload script location
		paramName: "expense_image_id", // The name that will be used to transfer the file
		maxFiles: 1,
		maxFilesize: 10, // MB
		addRemoveLinks: true,
		uploadMultiple: false,
		accept: function(file, done) {
			if (file.name == "wow.jpg") {
				done("Naha, you don't.");
			} else {
				done();
			}
		}
	});

	// set the dropzone container id
const id = "#kt_dropzonejs_example_3";
const dropzone = document.querySelector(id);

// set the preview element template
var previewNode = dropzone.querySelector(".dropzone-item");
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);

var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
    url: "<?php echo base_url('expenses/upload_files/'.$expense_info->id) ?>", // Set the url for your upload script location
    parallelUploads: 20,
	
    maxFilesize: 1, // Max filesize in MB
    previewTemplate: previewTemplate,
    previewsContainer: id + " .dropzone-items", // Define the container to display the previews
    clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
});

myDropzone.on("addedfile", function (file) {
    // Hookup the start button
    const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
    dropzoneItems.forEach(dropzoneItem => {
        dropzoneItem.style.display = '';
    });
});

// Update the total progress bar
myDropzone.on("totaluploadprogress", function (progress) {
    const progressBars = dropzone.querySelectorAll('.progress-bar');
    progressBars.forEach(progressBar => {
        progressBar.style.width = progress + "%";
    });
});

myDropzone.on("sending", function (file) {
    // Show the total progress bar when upload starts
    const progressBars = dropzone.querySelectorAll('.progress-bar');
    progressBars.forEach(progressBar => {
        progressBar.style.opacity = "1";
    });
});

// Hide the total progress bar when nothing"s uploading anymore
myDropzone.on("complete", function (progress) {
    const progressBars = dropzone.querySelectorAll('.dz-complete');

    setTimeout(function () {
        progressBars.forEach(progressBar => {
            progressBar.querySelector('.progress-bar').style.opacity = "0";
            progressBar.querySelector('.progress').style.opacity = "0";
        });
    }, 300);
});


	<?php endif; ?>
<?php $this->load->view("partial/common_js"); ?>
var submitting = false;
//validation and submit handling
$(document).ready(function()
{
		$('#category_id').selectize({
			create: true,
			render: {
				item: function(item, escape) {
						var item = '<div class="item">'+ escape($('<div>').html(item.text).text()) +'</div>';
						return item;
				},
				option: function(item, escape) {
						var option = '<div class="option">'+ escape($('<div>').html(item.text).text()) +'</div>';
						return option;
				},
				option_create: function(data, escape) {
						var add_new = <?php echo json_encode(lang('new_category')) ?>;
					return '<div class="create">'+escape(add_new)+' <strong>' + escape(data.input) + '</strong></div>';
				}
			}
		});
	        	
        $('#expenses_form').validate({
		ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
		submitHandler:function(form)
		{
			$('#grid-loader').show();
			if (submitting) return;
			submitting = true;
			$(form).ajaxSubmit({
			error: function(data ) { 
				console.log(data); 
			},
			success:function(response)
			{
				$('#grid-loader').hide();
				submitting = false;
				
				show_feedback(response.success ? 'success' : 'error',response.message, response.success ? <?php echo json_encode(lang('success')); ?>  : <?php echo json_encode(lang('error')); ?>);
				
				if(response.redirect==1 && response.success)
				{ 
					$.post('<?php echo site_url("expenses");?>', {expense: response.id}, function()
					{
						window.location.href = '<?php echo site_url('expenses'); ?>'
					});					
				}
				if(response.redirect==2 && response.success)
				{ 
					window.location.href = '<?php echo site_url('expenses'); ?>'
				}

			},
			
			<?php if(!$expense_info->id) { ?>
			resetForm: true,
			<?php } ?>
			dataType:'json'
		});

		},
		errorClass: "text-danger",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		},
		rules: 
		{
        expenses_type: "required",
        expenses_description: "required",
        expenses_date: "required",
		expenses_amount: {
			required:true,
			number:true				
		},
		expenses_tax:"number",
        expenses_recipient_name: "required",
        category_id: "required"
		},
		messages: 
		{
     		expenses_type: <?php echo json_encode(lang('expenses_type_required')); ?>,
     		expenses_description: <?php echo json_encode(lang('expenses_description_required')); ?>,
     		expenses_date: <?php echo json_encode(lang('expenses_date_required')); ?>,
     		expenses_amount: 
			{
				required: <?php echo json_encode(lang('expenses_amount_required')); ?>,
				number: <?php echo json_encode(lang('this_field_must_be_a_number')); ?>
			},
			expenses_tax: <?php echo json_encode(lang('this_field_must_be_a_number')); ?>,
     		expenses_recipient_name: <?php echo json_encode(lang('expenses_recipient_name_required')); ?>,
     		category_id: <?php echo json_encode(lang('category_required')); ?>
		}
	});
});

date_time_picker_field($('.datepicker'), JS_DATE_FORMAT);

$("#employee_id").select2();
$("#approved_employee_id").select2();
$("#cash_register_id").select2();

// added for expense category

$(document).on('click', "#add_category",function()
{
	$("#categoryModalDialogTitle").html(<?php echo json_encode(lang('add_category')); ?>);
	var parent_id = $("#category_id").val();
	
	$parent_id_select = $('#parent_id');
	$parent_id_select[0].selectize.setValue(parent_id, false);
	
	$("#categories_form").attr('action',SITE_URL+'/expenses/save_category');
	
	//Clear form
	$(":file").filestyle('clear');
	$("#categories_form").find('#category_name').val("");

	
	//show
	$("#category-input-data").modal('show');
});

$("#categories_form").submit(function(event)
{
	event.preventDefault();

	$(this).ajaxSubmit({ 
		success: function(response, statusText, xhr, $form){
			show_feedback(response.success ? 'success' : 'error', response.message, response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);
			if(response.success)
			{
				$("#category-input-data").modal('hide');
				
				var category_id_selectize = $("#category_id")[0].selectize
				category_id_selectize.clearOptions();
				category_id_selectize.addOption(response.categories);		
				category_id_selectize.addItem(response.selected, true);			
			}		
		},
		dataType:'json',
	});
});

	$('#expense_image_id').imagePreview({ selector : '#avatar' }); // Custom preview container

	$('.delete_file').click(function(e)
	{
		e.preventDefault();
		var $link = $(this);
		bootbox.confirm(<?php echo json_encode(lang('confirm_file_delete')); ?>, function(response)
		{
			if (response)
			{
				$.get($link.attr('href'), function()
				{
					$link.parent().fadeOut();
				});
			}
		});
		
	});
</script>
<?php $this->load->view('partial/footer')?>
