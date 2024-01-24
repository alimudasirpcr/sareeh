<?php $this->load->view("partial/header"); ?>

<div class="container-fluid">
		

<div class="row card p-5">
	<div class="col-md-12">

				<?php echo form_open('meters/save/'.(!isset($is_clone) ? $meter_info->meter_id : ''),array('id'=>'meter_form','class'=>'form-horizontal')); ?>
			<div class="panel panel-piluku">
				<div class="panel-heading rounded rounded-3 p-5">
	                <h3 class="panel-title">
	                    <i class="ion-edit"></i> 
	                    <?php echo lang("meters_basic_information"); ?>
    					<small>(<?php echo lang('fields_required_message'); ?>)</small>
	                </h3>
		        </div>

			<div class="panel-body">
				
				
				
				
					<div class="form-group" id="meter_number_holder">	
						<?php echo form_label(lang('meter_number').':', 'meter_number',array('class'=>' col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'meter_number',
								'size'=>'8',
								'placeholder' =>'Meter Number',
								'id'=>'meter_number',
								'class'=>'form-control form-inps form-control-solid',
								'value'=>$meter_info->meter_number)
								);?>
						</div>
					</div>


						<div class="form-group">	
						<?php echo form_label(lang('description').':', 'description',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_textarea(array(
								'name'=>'description',
								'id'=>'description',
								'class'=>'form-control text-area form-control-solid',
								'rows'=>'4',
								'placeholder' =>'Description',

								'cols'=>'30',
								'value'=>$meter_info->description));?>
							</div>
						</div>

				<?php if ($this->Employee->has_module_action_permission('meters','edit_meter_value', $this->Employee->get_logged_in_employee_info()->person_id)  || $meter_id == -1) { ?>

					<div class="form-group">	
						<?php echo form_label(lang('edit_meter_type').':', 'value',array('class'=>' col-sm-3 col-md-3 col-lg-2 control-label')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
							'name'=>'value',
							'size'=>'8',
							'class'=>'form-control form-inps form-control-solid ',
							'id'=>'value',
							'placeholder' =>'Value',

							'value'=>$meter_info->meter_type ? $meter_info->meter_type : '')
							);?>
						</div>
					</div>
					
					<?php } else { ?>
						
						<div class="form-group">	
							<?php echo form_label(lang('edit_meter_type').':', '',array('class'=>'required wide col-sm-3 col-md-3 col-lg-2 control-label required wide')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<h5><?php echo $meter_info->meter_type ? $meter_info->meter_type : ''; ?></h5>
							</div>
						</div>
					
					<?php	
						echo form_hidden('value', $meter_info->meter_type);
					}
					?> 
					<div class="form-group">	
						<?php echo form_label(lang('customer_name').':', 'choose_customer',array('class'=>'wide col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
                            
						<input type="text" placeholder="Customer name" name="choose_customer" id="choose_customer" class="form-control form-control-solid" value="<?php echo $meter_info->customer_id ? $selected_customer_name : ''; ?>">
						
						<input type="hidden" id="customer_id" name="customer_id" class="form-control" value="<?php echo $meter_info->customer_id ? $meter_info->customer_id : ''; ?>">

						</div>
					</div>
					
					<div class="form-group">	
						<?php echo form_label(lang('inactive').':', 'inactive',array('class'=>'wide col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'inactive',
							'id'=>'inactive',
							'class'=>'delete-checkbox form-check-input',
							'value'=>1,
							'checked'=>($meter_info->inactive ? 1 : 0)
						));?>
						<label for="inactive"><span></span></label>
						

						</div>
					</div>
					
					<?php if(!isset($is_clone)) { ?>
						
						<h5><?php echo lang('meters_log')?>:</h5>
						<div id="meter_log">
							<?php echo $meter_logs; ?>
						</div>
					<?php } ?>
						
					<?php echo form_hidden('redirect', $redirect); ?>
				
					<div class="form-actions pull-right">
						<?php echo form_submit(array(
						'name'=>'submit',
						'id'=>'submit',
						'value'=>lang('save'),
						'class'=>'btn submit_button floating-button btn-lg btn-primary')
						); ?>	
					</div>
					
					
			</div>
		</div>
			<input type="hidden" name="integrated_auth_code" id ="integrated_auth_code" value="" />
			<?php echo form_close(); ?>
	</div>
</div>
</div>
</div>
<script type='text/javascript'>
$("#delete").click(function()
{
	bootbox.confirm(<?php echo json_encode(lang('meters_confirm_delete')); ?>, function(response)
	{
		if (response)
		{
			void_issue_integrated_meter(parseFloat($("#value").val()).toFixed(2),$("#integrated_auth_code").val(),$("#manually_enter_card").prop('checked'),<?php echo json_encode(get_meter_processor() ? get_object_vars(get_meter_processor()) : FALSE); ?>,
			function success(response)
			{
				var data = response.split("&");
				var processed_data = {};

				for(var i = 0; i < data.length; i++)
				{
				    var m = data[i].split("=");
				    processed_data[m[0]] = m[1];
				}

				if (processed_data.CmdStatus == 'Approved')
				{
					show_feedback('success', <?php echo json_encode(lang('meters_successful_deleted')); ?>, <?php echo json_encode(lang('success')); ?>);
					$.post('<?php echo site_url('meters/delete'); ?>', {ids: [<?php echo $meter_id; ?>]}, function()
					{
						window.location.href = '<?php echo site_url('meters'); ?>';
					});
				}
				else
				{
					show_feedback('error',decodeURIComponent(processed_data.TextResponse.replace(/\+/g, '%20')), <?php echo json_encode(lang('error')); ?>);
				}
			},
			function error()
			{
				
			});
		}
	});
});
function check_integrated_meter()
{
	if ($("#integrated_gift_card").prop('checked'))
	{
		$("#meter_number_holder").hide();
		$("#manually_enter_card_holder").show();
	}
	else
	{
		$("#meter_number_holder").show();
		$("#manually_enter_card_holder").hide();
	}
}	

function processAddMeter(form)
{
	$(form).ajaxSubmit({
	success:function(response)
	{
		$('#grid-loader').hide();
		show_feedback(response.success ? 'success' : 'error',response.message, response.success ? <?php echo json_encode(lang('success')); ?>  : <?php echo json_encode(lang('error')); ?>);
		if(response.redirect==2 && response.success)
		{
			window.location.href = '<?php echo site_url('meters'); ?>';
		}
		else
		{
			$("html, body").animate({ scrollTop: 0 }, "slow");
			$(".form-group").removeClass('has-success has-error');
		}
	},
	<?php if(!$meter_info->meter_id) { ?>
	resetForm:true,
	<?php } ?>
	dataType:'json'
	});
}

function integrated_meter_success(response)
{
	var data = response.split("&");
	var processed_data = {};

	for(var i = 0; i < data.length; i++)
	{
	    var m = data[i].split("=");
	    processed_data[m[0]] = m[1];
	}
	
	if (typeof processed_data.AcctNo !== 'undefined')
	{
		$("#meter_number").val(decodeURIComponent(processed_data.AcctNo.replace(/\+/g, '%20')));
	}
	
	//Only save for new gift cards
	if(<?php echo $meter_id; ?> == -1 && typeof processed_data.AuthCode !== 'undefined')
	{
		$("#integrated_auth_code").val(decodeURIComponent(processed_data.AuthCode.replace(/\+/g, '%20')));
	}
	
	if (processed_data.Balance)
	{
		$("#value").val(parseFloat(decodeURIComponent(processed_data.Balance.replace(/\+/g, '%20'))).toFixed(2))
	}
	
	if (processed_data.CmdStatus == 'Approved')
	{
		processAddMeter(meter_form);
	}
	else
	{
		show_feedback('error',decodeURIComponent(processed_data.TextResponse.replace(/\+/g, '%20')), <?php echo json_encode(lang('error')); ?>);
	}
}

function integrated_meter_error()
{

}

$("#integrated_gift_card").click(check_integrated_meter);
<?php if (!$this->config->item('disable_meter_detection')) { ?>
	meter_swipe_field($('#meter_number'));
<?php
}
?>			
	//validation and submit handling
	$(document).ready(function()
	{
			check_integrated_meter();
			$( "#choose_customer" ).autocomplete({
		 		source: '<?php echo site_url("meters/suggest_customer");?>',
				delay: 500,
		 		autoFocus: false,
		 		minLength: 0,
		 		select: function( event, ui ) 
		 		{
					event.preventDefault();
					$("#choose_customer").val(decodeHtml(ui.item.label));
					$("#customer_id").val(decodeHtml(ui.item.value));
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
	     
	    setTimeout(function(){$(":input:visible:first","#meter_form").focus();},100);
			$('#meter_form').validate({
			submitHandler:function(form)
			{
				meter_form = form;
        if(!$("#choose_customer").val())
        {
						$("#customer_id").val("");
        }
				
				$('#grid-loader').show();
				processAddMeter(form);
				
				
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
				meter_number:
				{
					<?php if(!$meter_info->meter_id) { ?>
					remote: 
					    { 
						url: "<?php echo site_url('meters/meter_exists');?>", 
						type: "post"
		
					    }, 
					<?php } ?>
					required:true
	
				},
				value:
				{
					required:true,
					number:true
				}
	   		},
			messages:
			{
				meter_number:
				{
					<?php if(!$meter_info->meter_id) { ?>
					remote:<?php echo json_encode(lang('meters_exists')); ?>,
					<?php } ?>
					required:<?php echo json_encode(lang('meters_number_required')); ?>,

				},
				value:
				{
					required:<?php echo json_encode(lang('meters_value_required')); ?>,
					number:<?php echo json_encode(lang('meters_value')); ?>
				}
			}
		});
	});
</script>
<?php $this->load->view("partial/footer"); ?>