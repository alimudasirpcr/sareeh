<?php $this->load->view("partial/header"); ?>

<div class="row" id="form">
	
	<div class="spinner" id="grid-loader" style="display:none">
	  <div class="rect1"></div>
	  <div class="rect2"></div>
	  <div class="rect3"></div>
	</div>
	<div class="col-md-12">
		 <?php echo form_open('appointments/save/'.$appointment_info->id,array('id'=>'appointments_form','class'=>'form-horizontal')); ?>
		<div class=" card shadow-sm">
			<div class=" card-header rounded rounded-3 p-5">
                    <h3 class=" card-title">
                        <i class="ion-edit"></i> <?php if(!$appointment_info->id) { echo lang('appointments_new'); } else { echo lang('appointments_update'); } ?>
								<small>(<?php echo lang('common_fields_required_message'); ?>)</small>
	                </h3>
						 
            </div>
			<div class=" card-body">
				
				<?php
				if (!$this->input->get('date'))
				{
					$_GET['date'] = date(get_date_format().' '.get_time_format());
				}
				?>
				
			

				<div class="form-group p-lr-15">
					<?php echo form_label(lang('appointments_start_date').':', 'appointments_start_date_input', array('class'=>'required form-label')); ?>
				  	<div class="input-group ">
				    	<span class="input-group-text"><i class="ion-calendar"></i></span>
				    	<?php echo form_input(array(
				      		'name'=>'start_time',
							'id'=>'start_time',
							'class'=>'form-control  daterangepickerd',
							'value'=>$appointment_info->start_time ? date(get_date_format().' '.get_time_format(), strtotime($appointment_info->start_time)) : date(get_date_format().' '.get_time_format(),strtotime($this->input->get('date'))))
				    	);?> 
				    </div>  
				</div>
				

				<div class="form-group p-lr-15">
					<?php echo form_label(lang('appointments_end_date').':', 'appointments_end_date_input', array('class'=>'required form-label')); ?>
				  	<div class="input-group ">
				    	<span class="input-group-text"><i class="ion-calendar"></i></span>
				    	<?php echo form_input(array(
				      		'name'=>'end_time',
							'id'=>'end_time',
							'class'=>'form-control  daterangepickerd',
							'value'=>$appointment_info->end_time ? date(get_date_format().' '.get_time_format(), strtotime($appointment_info->end_time)) : date(get_date_format().' '.get_time_format(),strtotime($this->input->get('date'))))
				    	);?> 
				    </div>  
				</div>
				
				<div class="form-group">	
					<?php echo form_label(lang('appointments_appointment_person').':', 'choose_person',array('class'=>'required wide col-12 form-label wide')); ?>
					<div class="col-12">
                          
					<input type="text" name="choose_person" id="choose_person" class="form-control required" value="<?php echo $appointment_info->person_id ? $selected_person_name : ''; ?>">
					
					<input type="hidden" id="person_id" name="person_id" class="form-control" value="<?php echo $appointment_info->person_id ? $appointment_info->person_id : ''; ?>" required>

					</div>
				</div>
				
				<div class="form-group">
					<?php echo form_label(lang('common_employee').':', 'employee_id',array('class'=>'col-12  form-label required ')); ?>
					<div class="col-12">
						<?php echo form_dropdown('employee_id', $employees,$appointment_info->employee_id, 'class="form-control form-inps" id="employee_id"');?>
					</div>
				</div>
				
				
				
				<div class="form-group">
					<?php echo form_label(lang('common_category').':', 'appointments_type_id',array('class'=>'col-12 form-label  required wide')); ?>
					<div class="col-12">
						<?php echo form_dropdown('appointments_type_id', $categories,$appointment_info->appointments_type_id, 'class="form-control form-inps" id="appointments_type_id"');?>
					</div>
				</div>
				
				
				
				<div class="form-group">	
				<?php echo form_label(lang('common_notes').':', 'notes',array('class'=>'col-12 form-label ')); ?>
					<div class="col-12">
					<?php echo form_textarea(array(
						'name'=>'notes',
						'id'=>'notes',
						'class'=>'form-control text-area',
						'value'=>$appointment_info->notes,
						'rows'=>'5',
						'cols'=>'17')		
					);?>
					</div>
				</div>
				

<div class="form-actions pull-right">
<?php
echo form_submit(array(
	'name'=>'submitf',
	'id'=>'submitf',
	'value'=>lang('common_save'),
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type='text/javascript'>
	
var submitting = false;
//validation and submit handling
$(document).ready(function()
{
    $('#appointments_form').validate({
		ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
		submitHandler:function(form)
		{
			$('#grid-loader').show();
			if (submitting) return;
			submitting = true;
			$(form).ajaxSubmit({
			success:function(response)
			{
				$('#grid-loader').hide();
				submitting = false;
				
				show_feedback(response.success ? 'success' : 'error',response.message, response.success ? <?php echo json_encode(lang('common_success')); ?>  : <?php echo json_encode(lang('common_error')); ?>);
				
				if(response.redirect==1 && response.success)
				{ 
					$.post('<?php echo site_url("appointments");?>', {appointment: response.id}, function()
					{
						window.location.href = '<?php echo site_url('appointments'); ?>'
					});					
				}
				if(response.redirect==2 && response.success)
				{ 
					window.location.href = '<?php echo site_url('appointments'); ?>'
				}

			},
			
			<?php if(!$appointment_info->id) { ?>
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
			start_time: "required",
			appointments_type_id: "required",
			end_time: "required"
		},
		messages: 
		{
			start_time: <?php echo json_encode(lang("common_this_field_required")); ?>,
			appointments_type_id: <?php echo json_encode(lang("common_this_field_required")); ?>,
			end_time: <?php echo json_encode(lang("common_this_field_required")); ?>
		}
	});
});

// date_time_picker_field($('#start_time'), JS_DATE_FORMAT+ " "+JS_TIME_FORMAT);
// date_time_picker_field($('#end_time'), JS_TIME_FORMAT);

// $('#start_time').on("dp.change", function(e) 
// {
// 	var date_time_prices = $('#start_time').val().split(' ');
// 	var time = date_time_prices[1];
	
// 	if (typeof date_time_prices[2]!=='undefined')
// 	{
// 		time+=' '+date_time_prices[2];
// 	}
// 	$('#end_time').val(time);
// });
$( "#choose_person" ).autocomplete({
	source: '<?php echo site_url("appointments/suggest_person");?>',
	delay: 500,
	autoFocus: false,
	minLength: 0,
	select: function( event, ui ) 
	{
		event.preventDefault();
		$("#choose_person").val(decodeHtml(ui.item.label));
		$("#person_id").val(decodeHtml(ui.item.value));
	}
}).data("ui-autocomplete")._renderItem = function (ul, item) {
       return $("<li class='customer-badge suggestions'></li>")
           .data("item.autocomplete", item)
           .append('<a class="suggest-item"><div class="avatar">' +
						'<img src="' + item.avatar + '" alt="">' +
					'</div>' +
					'<div class="details">' +
						'<div class="name">' + 
							item.label +
						'</div>' + 
						'<span class="email">' +
							item.subtitle + 
						'</span>' +
					'</div></a>')
           .appendTo(ul);
   };
	 
 	$('#appointments_type_id').selectize();

	

$(".daterangepickerd").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
		timePicker: true,
		locale: {
        format: "MM/DD/YYYY hh:mm A"
    }
    });
</script>
<?php $this->load->view('partial/footer')?>
