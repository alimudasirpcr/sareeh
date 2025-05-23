<?php $this->load->view("partial/header"); ?>

<?php echo form_open('work_orders/save_template/',array('id'=>'template_form','class'=>'form-horizontal')); ?>
<div class="row  ">


	<div class="col-md-8 form-horizontal">
		<div class="card ">
			<div class="card-header rounded rounded-3 p-5">
				<?php echo lang('deliveries_manage_email_template');?>
				<p class="pull-right btn btn-primary preview_enable"><?php echo lang('preview')?></p>
				<p class="pull-right btn btn-primary preview_disable hide"><?php echo lang('edit')?></p>
			</div>
			<div class="card-body">
				<div id="statuses_list" class="status-tree">
					<textarea name="email_template" cols="17" rows="7" id="template" class="form-control text-area" spellcheck="false"></textarea>
					<span class="preview-text-area hide" id="preview"></span>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 form-horizontal">
		<div class="card ">
			<div class="card-header rounded rounded-3 p-5">
				<?php echo lang('status');?>
				<small>(<?php echo lang('required');?>)</small>
			</div>
			<div class="card-body">
				<select name="status_id" id="status_id" class="form-control change_delivery_status">
					<option value=""><?php echo lang('please_select');?></option>
					<option value="0" data-status_value="<?php echo $default;?>"><?php echo lang('default');?></option>
					<?php   
						$statuses = array('' => lang('change_status'));
						foreach($delivery_statuses as $status_id => $status) { ?>
							<option value="<?php echo $status_id;?>" data-status_value="<?php echo str_ireplace('<br />', "\r\n", $status['data']);?>">
								<?php echo $status['name'];?>
							</option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="card ">
			<div class="card-header rounded rounded-3 p-5"><?php echo lang('shortcode');?></div>
			<div class="card-body shortcuts">
				<a href="javascript:void(0);" class="add_status" data-value="%company_name%">
					<?php echo lang('company');?>
				</a> <br>
				<a href="javascript:void(0);" class="add_status" data-value="%customer_name%">
					<?php echo lang('customer_name');?>
				</a><br>
				<a href="javascript:void(0);" class="add_status" data-value="%work_order_id%">
					<?php echo lang('work_orders_work_order_id');?>
				</a> <br>
				<a href="javascript:void(0);" class="add_status" data-value="%estimated_parts%">
					<?php echo lang('work_orders_estimated_parts');?>
				</a> <br>
				<a href="javascript:void(0);" class="add_status" data-value="%estimated_labor%">
					<?php echo lang('work_orders_estimated_labor');?>
				</a><br>
				<a href="javascript:void(0);" class="add_status" data-value="%estimated_repair_date%">
					<?php echo lang('work_orders_estimated_repair_date');?>
				</a><br>
				<a href="javascript:void(0);" class="add_status" data-value="%work_order_status%">
					<?php echo lang('status');?>
				</a><br>
				<a href="javascript:void(0);" class="add_status" data-value="%warranty_repair%">
					<?php echo lang('work_orders_warranty_repair');?>
				</a><br>
				<a href="javascript:void(0);" class="add_status" data-value="%customer_notes%">
					<?php echo lang('notes');?>
				</a><br>
				

				<?php 
				for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { 
				$custom_field = $this->Work_order->get_custom_field($k);

				if($custom_field !== FALSE)
				{ 
					$replace_value = str_replace(' ', '_', strtolower($custom_field)); 
				?>
					<a href="javascript:void(0);" class="add_status" data-value="%custom_field_<?php echo $replace_value;?>%">
						Custom <?php echo $custom_field;?>
					</a><br>
				<?php } } ?>
				
			</div>
		</div>
	</div>
</div><!-- /row -->
<div class="form-actions">
	<?php
		echo form_submit(array(
			'name'	=>	'submitf',
			'id'	=>	'submitf',
			'value'	=>	lang('save'),
			'class'	=>	'submit_button floating-button btn btn-primary'
		));
	?>
</div>

<script type='text/javascript'>	

$(document).ready(function()
{
    


    $("#template_form").submit(function(event)
		{
			event.preventDefault();
			$(this).ajaxSubmit({ 
				success: function(response, statusText, xhr, $form){
					show_feedback(response.success ? 'success' : 'error', response.message, response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);
					if(response.success)
					{
						
					}		
				},
				dataType:'json',
			});
		});
 
 	// On Shortcuts Click Get Value and Replace with Text
	$('.shortcuts a').click(function() { 

		

        val 		= $(this).data('value');
        var text 	= $('#template').val();
		$('#template').insertAtCursor(val);
    }); 

	// On Change Status ID Get data-status_value and Replace with Textarea
	$("#status_id").change(function() {
		var option_value 		 	= $("#status_id :selected").val();
        var option_status_value 	= $(this).children("option:selected").data('status_value');
        var option_name 			= $(this).children("option:selected").text();
        $('.text-area').val(option_status_value);
       	
        
        if (option_value >= '0') {
        	if (option_status_value) {
        		var text_content = $.trim($(".text-area").val());
        		$.trim($(".text-area").val(text_content));
        	} else {
        		renderTemplate(option_name);
        	}
    	}
    });

	// On Preview Button Click Hide Text Editor, Hide Preview Button & Show Edit Button
	$(".preview_enable").click(function(){
	    $("#template").toggleClass("hide");
	    $("#preview").toggleClass("show");
	    $(".preview_disable").removeClass("hide");
	    $(".preview_enable").addClass("hide");

	    renderTemplate();
	});

	// On Edit Button Click Hide Preview Editor, Hide Edit Button & Show Preview Button
	$(".preview_disable").click(function() {
		$("#template").toggleClass("hide");
	    $("#preview").toggleClass("show");
	    $(".preview_enable").removeClass("hide");
	    $(".preview_disable").addClass("hide");

	    unrenderTemplate();
	});


	// Render Template 
	function renderTemplate(status_value)
	{
		var text_content = $.trim($(".text-area").val());

		if (!text_content) {
			pre_template 	= "Your Order # %work_order_id% status is";
			preview 		= pre_template+ ' ' +$.trim(status_value);
			
		} else {
			preview = text_content.replaceAll(/\n/g, "<br />")
					.replaceAll('%company_name%', '<?php echo $this->config->item('company');?>')
					.replaceAll('%customer_name%', '<?php echo lang('customer_name');?>')
					.replaceAll('%work_order_id%', "<?php echo $this->config->item('sale_prefix')?> 125")
					.replaceAll('%estimated_parts%', "5263")
					.replaceAll('%estimated_labor%', "3410")
					.replaceAll('%work_order_status%', 'Work Order Status')
					.replaceAll('%estimated_repair_date%', "<?php echo lang('work_orders_estimated_repair_date');?>")
					.replaceAll('%warranty_repair%', "<?php echo lang('work_orders_warranty_repair');?>")
					.replaceAll('%customer_notes%', '<?php echo lang('notes');?>')
					.replaceAll('%custom_field_1%', "Custom Field 1")

					<?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { 
						$custom_field 	= $this->Work_order->get_custom_field($k);
						$replace_value 	= str_replace(' ', '_', strtolower($custom_field));
						if($custom_field !== FALSE) {
					?>
					.replaceAll('%<?php echo $replace_value;?>%', "<?php echo $custom_field;?>")
					<?php  } } ?>
					.replaceAll('%work_images%', "<?php echo lang('images');?>");

		}
		$.trim($(".text-area").val(preview));
		$('.preview-text-area').html(preview);
	}

	// Render Template 
	function unrenderTemplate()
	{

		var text_content = $.trim($(".text-area").val());
		console.log(text_content);
		preview = text_content.replaceAll(/\<br\>/g, "\n").replaceAll(/\<br \/\>/g, "\n")
					.replaceAll('<?php echo $this->config->item('company');?>', '%company_name%')
					.replaceAll("<?php echo lang('customer_name');?>", '%customer_name%')
					.replaceAll("<?php echo $this->config->item('sale_prefix')?> 125",'%work_order_id%')
					.replaceAll("5263", '%estimated_parts%')
					.replaceAll("3410", '%estimated_labor%')
					.replaceAll("01", '%delivery_id%')
					.replaceAll('Work Order Status', '%work_order_status%')
					.replaceAll("<?php echo lang('work_orders_estimated_repair_date');?>", '%estimated_repair_date%')
					.replaceAll("<?php echo lang('work_orders_warranty_repair');?>", '%warranty_repair%')
					.replaceAll("<?php echo lang('notes');?>", '%customer_notes%')

					<?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { 
						$custom_field 	= $this->Work_order->get_custom_field($k);
						$replace_value 	= str_replace(' ', '_', strtolower($custom_field));
						if($custom_field !== FALSE) {
					?>
					.replaceAll("<?php echo $custom_field;?>", '%<?php echo $replace_value;?>%')
					
					<?php  } } ?>
					.replaceAll("<?php echo lang('images');?>", '%work_images%');

		
		$.trim($(".text-area").val(preview));		
	}

	$.fn.extend({
	    insertAtCursor: function(option_value) {
	        this.each(function() {
	            if (document.selection) {
	                this.focus();
	                var sel = document.selection.createRange();
	                sel.text = option_value;
	                this.focus();
	            } else if (this.selectionStart || this.selectionStart == '0') {
	                var startPos = this.selectionStart;
	                var endPos = this.selectionEnd;
	                var scrollTop = this.scrollTop;
	                this.value = this.value.substring(0, startPos) +
	                    option_value + this.value.substring(endPos, this.value.length);
	                this.focus();
	                this.selectionStart = startPos + option_value.length;
	                this.selectionEnd = startPos + option_value.length;
	                this.scrollTop = scrollTop;
	            } else {
	                this.value += option_value;
	                this.focus();
	            }
	        });
	        return this;
	    }
	});
});
</script>
<?php $this->load->view('partial/footer'); ?>
