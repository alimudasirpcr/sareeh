<?php $this->load->view("partial/header"); ?>
<?php if( $this->uri->segment(2) !='view'): ?>
                <?php $this->load->view('partial/categories/category_modal', array('categories' => $categories));?>
<?php endif; ?>
<?php $query = http_build_query(array('redirect' => $redirect, 'progression' => $progression ? 1 : null, 'quick_edit' => $quick_edit ? 1 : null)); ?>
<?php $manage_query = http_build_query(array('redirect' => uri_string().($query ? "?".$query : ""), 'progression' => $progression ? 1 : null, 'quick_edit' => $quick_edit ? 1 : null)); ?>

<div class="spinner" id="grid-loader" style="display:none;">
  <div class="rect1"></div>
  <div class="rect2"></div>
  <div class="rect3"></div>
</div>

<div class="manage_buttons hidden">
	<div class="row">
		<div class="<?php echo isset($redirect) ? 'col-xs-9 col-sm-10 col-md-10 col-lg-10': 'col-xs-12 col-sm-12 col-md-12' ?> margin-top-10">
			<div class="modal-item-info padding-left-10">
				<div class="breadcrumb-item text-dark">
					<?php if(!$item_info->item_id) { ?>
			    <span class="modal-item-name new"><?php echo lang('items_new'); ?></span>
					<?php } else { ?>
		    	<span class="modal-item-name"><?php echo H($item_info->name).' ['.lang('id').': '.$item_info->item_id.']'; ?></span>
					<span class="badge badge-success fw-semibold fs-9 px-2 ms-2 cursor-default ms-2"><?php echo H($category); ?></span>
					<?php } ?>
				</div>
			</div>	
		</div>
		<?php if(isset($redirect) && !$progression) { ?>
		<div class="col-xs-3 col-sm-2 col-md-2 col-lg-2 margin-top-10">
			<div class="buttons-list">
				<div class="pull-right-btn">
				<?php echo 
					anchor(site_url($redirect), ' ' . lang('done'), array('class'=>'outbound_link btn btn-primary btn-lg ion-android-exit', 'title'=>''));
				?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>

<div class="row  " id="form">
	<div class="col-md-12">
		
	<?php echo form_open_multipart('items/save_images/'.(!isset($is_clone) ? $item_info->item_id : ''),array('id'=>'item_form','class'=>'form-horizontal form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework')); ?>
	

	<?php $this->load->view('partial/item_side_bar', array('progression' => $progression, 'query' => $query, 'item_info' => $item_info)); ?>

<div class="d-flex flex-column flex-row-fluid gap-5">

    <?php if(!$quick_edit) { ?>
    <?php $this->load->view('partial/nav', array('progression' => $progression, 'query' => $query, 'item_info' => $item_info)); ?>
    <?php } ?>


	<?php $data = array(
    'type'  => 'hidden',
    'name'  => 'has_files',
    'id'    => 'has_files',
    'value' => '0',
	);

	echo form_input($data); ?>
	
	<?php echo form_hidden('ecommerce_product_id', $item_info->ecommerce_product_id); ?>

	<div class="card ">
		<div class="card-header rounded rounded-3 p-5">
	      <h3 class="panel-title"> <?php echo lang("upload_images"); ?> </h3>
				
				<div class="breadcrumb breadcrumb-dot text-muted fs-6 fw-semibold" id="pagination_top">
					<?php
					if (isset($prev_item_id) && $prev_item_id)
					{
							echo anchor('items/images/'.$prev_item_id, '<span class="hidden-xs ion-chevron-left"> '.lang('items_prev_item').'</span>');
					}
					if (isset($next_item_id) && $next_item_id)
					{
							echo anchor('items/images/'.$next_item_id,'<span class="hidden-xs">'.lang('items_next_item').' <span class="ion-chevron-right"></span</span>');
					}
					?>
	  		</div>
		</div>

			<div class="card-body">
				
				<div class="form-group">
	      	<?php echo form_label(lang('select_images').':', 'image_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
	        	<div class="image-upload">
	          	<input type="file" name="image_files[]" id="image_id" class="filestyle " data-icon="false" multiple accept="image/png,image/gif,image/jpeg" >
	           </div>
	        </div>
				</div>

				<div class="row">
				<div id="image_preview" class="item_image_preview"></div>
				</div>
			</div><!--/card-body -->
		</div><!-- /panel-piluku -->
		
			<?php if($item_images) { ?>
			<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
			<section id="pinBoot">
			<?php
			$i = 0;
			foreach($item_images as $item_image) {
				$i ++;
			?>
			<article class="white-panel">
				<div class="form-check form-check-custom form-check-solid mb-2"> 	
					<?php echo form_checkbox(array(
						'name'=>'del_images['.$item_image['image_id'].']',
						'id'=>'del_image_'.$item_image['image_id'],
						'class'=>'delete-checkbox form-check-input',
						'value'=>1
					));?>
					<label class="form-check-label"  for="del_image_<?php echo $item_image['image_id']; ?>"><?= lang('del_image'); ?></label>
				</div>
				<?php echo img(array('src' => cacheable_app_file_url($item_image['image_id']),'class'=>'img-polaroid img-polaroid-s')); ?>
				
				<?php 
				
				echo form_label(lang('items_image_title').':', 'item_image_title',array('class'=>'control-label'));
				
				$data = array(
				        'name'          => 'titles['.$item_image['image_id'].']',
				        'id'            => 'titles_'.$item_image['image_id'],
				        'placeholder'   => lang('items_enter_a_title'),
				        'class'         => 'form-control',
								'value'					=> $item_image['title'],

				);

				echo form_input($data);

				echo form_label(lang('items_image_alt_text').':', 'item_image_alt_text',array('class'=>'control-label'));

				$data = array(
				        'name'          => 'alt_texts['.$item_image['image_id'].']',
				        'id'            => 'alt_texts_'.$item_image['image_id'],
				        'placeholder'   => lang('items_enter_alt_text'),
				        'class'         => 'form-control',
								'value'					=> $item_image['alt_text'],
				);

				echo form_input($data); 
				
				echo form_label(lang('items_variation').':', 'item_image_item_variation',array('class'=>'control-label'));
				
				$options = array('' => lang('none'));
				
				foreach($item_variations as $id => $variation)
				{
					$options[$id] = $variation['name'] ? $variation['name'] : implode(', ', array_column($variation['attributes'], 'label'));
				}
	
				echo form_dropdown('variations['.$item_image['image_id'].']', $options, $item_image['item_variation_id'], array('id' => 'item_image_item_variation_'.$item_image['image_id'], 'class' => 'form-control variation_select'));
				?>
				
				<div class="form-check form-check-custom form-check-solid mb-2">
					

					<?php echo form_checkbox(array(
						'name'=>'main_image['.$item_image['image_id'].']',
						'id'=>'main_image_'.$item_image['image_id'],
						'class'=>'main-image form-check-input',
						'value'=>1,
						'checked'=> $item_info->main_image_id == $item_image['image_id']
					));?>
					<label  class="form-check-label" for="main_image_<?php echo $item_image['image_id']; ?>"> <?= lang('items_main_image'); ?></label>
				</div>
			</article>	
			<?php } ?>
			</section>
			</div><!-- end col -->
			</div><!-- end row -->
		<?php } ?>
		
	<?php echo form_hidden('redirect', isset($redirect) ? $redirect : ''); ?>
	<?php echo form_hidden('progression', isset($progression) ? $progression : ''); ?>
	<?php echo form_hidden('quick_edit', isset($quick_edit) ? $quick_edit : ''); ?>
	
	<div class="form-actions">
		<?php
		if (isset($redirect) && $redirect == 'sales')
		{
			echo form_button(array('name' => 'cancel', 'id' => 'cancel', 'class' => 'submit_button btn btn-lg btn-danger', 'value' => 'true', 'content' => lang('cancel')));
		}
		?>
		<?php echo form_submit(array('name'=>'submitf', 'id'=>'submitf', 'value'=>lang('save'), 'class'=>'submit_button floating-button btn btn-lg btn-danger')); ?>
	</div>
	<?php echo form_close(); ?>
	
	<div class="item_navigation text-center">
		<div class="row pagination hidden-print alternate text-center" id="pagination_bottom" >
			<?php
			if (isset($prev_item_id) && $prev_item_id)
			{
					echo anchor('items/view/'.$prev_item_id, '&lt; '.lang('items_prev_item'));
			}
			if (isset($next_item_id) && $next_item_id)
			{
					echo anchor('items/view/'.$next_item_id,lang('items_next_item').' &gt;');
			}
			?>
		</div>
	</div> <!-- /item_navigation -->
</div>
</div>
<script type='text/javascript'>
<?php $this->load->view("partial/common_js"); ?>

$(document).ready(function()
{
	$('#image_id').itemImagePreview({ selector : '#image_preview' }); // Custom preview container

  setTimeout(function(){$(":input:visible:first","#item_form").focus();},100);

	$('#item_form').validate({
		submitHandler: function(form)
		{
			var args = {
				next:
				{
					label: <?php echo json_encode(lang('edit').' '.lang('locations')) ?>,
					url: <?php echo json_encode(site_url("items/location_settings/".($item_info->item_id ? $item_info->item_id : -1)."?$query")); ?>,
				}
			};

			doItemSubmit(form, args);
		}

	});
});

$(document).ready(function() {
	$('#pinBoot').pinterest_grid({
		no_columns: 4,
		padding_x: 10,
		padding_y: 10,
		markup_bottom: 50,
		single_column_breakpoint: 700
	});
});

//new image preview
(function($){
	$.fn.itemImagePreview = function(params){
		$(this).change(function(evt){
			$(params.selector).html('');
			if(typeof FileReader == "undefined") return true; // File reader not available.

			var fileInput = $(this);
			
	    if(fileInput.val())
			{
				$('#has_files').val('1');
			} else {
				$('#has_files').val('0');
			}
			
			var files = evt.target.files; // FileList object
			var files_to_skip;
			
			$(document).on('hide.bs.collapse', '.image-preview-column',function(e) {
				var index = $(this).data('file-index');
				var fileName = $(this).data('file-name');
				var fileDisplay = $('.bootstrap-filestyle').find('input').eq(0);
				var fileDisplayValues = fileDisplay.val().split(', ');
				fileDisplayValues.splice(fileDisplayValues.indexOf(fileName), 1);
				fileDisplayValues = fileDisplayValues.join(', ');
				fileDisplay.val(fileDisplayValues);
				
				$('<input>').attr({
				    type: 'hidden',
				    name: 'ignore[]',
						value: index
				}).appendTo(fileInput.closest('form'));
				
			});
			
			// Loop through the FileList and render image files as thumbnails.
			for (var i = 0, f; f = files[i]; i++) {

				// Only process image files.
				if (!f.type.match('image.*')) {
					continue;
				}

				var reader = new FileReader();
				var j = 0;
				// Closure to capture the file information.
				reader.onload = (function(theFile) {
					return function(e) {
						// Render thumbnail.
						var panelTemplateTop =
						'<div class="col-lg-4 col-md-4 col-xs-12 image-preview-column fade in collapse" data-file-name="'+theFile.name+'" data-file-index="'+j+'" id="image-'+j+'">' +
							'<div class="card  panel-equal">' +
								'<div class="card-header rounded rounded-3 p-5" style="min-height: 45px;">'+ theFile.name +'<a data-toggle="collapse" href="#image-'+j+'" class="close">&times </a></div>' +
									'<div class="card-body">' +
										'<div class="thumbnail item_image_preview_thumb">';

						var panelTemplateBottom =
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>';

						var columnTemplate = panelTemplateTop +
								'<img class="file-input-thumb" width="150" src="' + e.target.result + '" title="' + theFile.name + '"/>' +
								panelTemplateBottom;


						if(j % 3 == 0)
						{
							//var rowTemplate = '<div class="row">';
							//$(params.selector).append(rowTemplate)
						}
						
						$(params.selector).append(columnTemplate);
						//$(params.selector).find('.row').last().append(columnTemplate);
						j++;
					};
					
				})(f);

				// Read in the image file as a data URL.
				reader.readAsDataURL(f);
			}
		});
	};
})(jQuery);


$(function() {
	var selectedOptions = [];
	$('.variation_select').each(function(index, select) {
		if($(this).val())
		{
			selectedOptions.push($(this).val());
		}
	});
	
	$('.variation_select').each(function(index, select) {
		var selectedValue = $(this).val();
		$(select).children().each(function(index, option) {
			var currentOptionValue = $(option).val();
			if(currentOptionValue !== selectedValue)
			{
				if(selectedOptions.indexOf(currentOptionValue) !== -1)
				{
					$(option).prop('disabled', true);
				}
				else
				{
					$(option).prop('disabled', false);
				}
			}
		});
	});		
});

//limit variation images to 1
$(document).on("change", ".variation_select", function(e) {
	var selectedOptions = [];
	$('.variation_select').each(function(index, select) {
		if($(this).val())
		{
			selectedOptions.push($(this).val());
		}
	});
	
	$('.variation_select').each(function(index, select) {
		var selectedValue = $(this).val();
		$(select).children().each(function(index, option) {
			var currentOptionValue = $(option).val();
			if(currentOptionValue !== selectedValue)
			{
				if(selectedOptions.indexOf(currentOptionValue) !== -1)
				{
					$(option).prop('disabled', true);
				}
				else
				{
					$(option).prop('disabled', false);
				}
			}
		});
	});
});

<?php if ($this->session->flashdata('manage_success_message')) { ?>
	show_feedback('success', <?php echo json_encode($this->session->flashdata('manage_success_message')); ?>, <?php echo json_encode(lang('success')); ?>);
<?php } ?>

$(".main-image").click(function()
{
	var check_status = $(this).prop('checked');
	$(".main-image").prop('checked',false);
	if (check_status)
	{
		$(this).prop('checked',true);
	}
});
</script>
</div>

<?php $this->load->view('partial/footer'); ?>
