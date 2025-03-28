<?php $this->load->view("partial/header"); ?>

<?php if($redirect) { ?>
<div class="manage_buttons">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top-10">
			<div class="buttons-list">
				<div class="pull-right-btn">
				<?php echo 
					anchor(site_url($redirect), ' ' . lang('done'), array('class'=>'btn btn-primary btn-lg ion-android-exit', 'title'=>''));
				?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<?php echo form_open('items/save_manufacturer/',array('id'=>'manufacturer_form','class'=>'form-horizontal')); ?>
	<div class="row  ">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header rounded rounded-3 p-5"><?php echo lang("items_manage_manufacturers"); ?></div>
					<div class="card-body">
						<a href="javascript:void(0);" class="add_manufacturer" data-manufacturer_id="0">[<?php echo lang('items_add_manufacturer'); ?>]</a>
							<div id="manufacturers_list" class="manufacturer-tree">
								<?php echo $manufacturers_list; ?>
							</div>
						<a href="javascript:void(0);" class="add_manufacturer" data-manufacturer_id="0">[<?php echo lang('items_add_manufacturer'); ?>]</a>
					</div>
				</div>
			</div>
		</div><!-- /row -->
		<?php  echo form_close(); ?>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>

			
<script type='text/javascript'>
	jQuery.noConflict();
	jQuery('#manufacturers_list').jstree({
	
    "core" : {
        "themes" : {
            "responsive": false
        }
    },
    "types" : {
        "default" : {
            "icon" : "fa fa-folder"
        },
        "file" : {
            "icon" : "fa fa-file"
        }
    },
    "plugins": ["types" , "checkbox"]
}).on('ready.jstree', function() {
    // Open all nodes when the tree is ready
    $(this).jstree('open_all');
  });

$(document).on('click', ".edit_manufacturer",function()
{
	var manufacturer_id = $(this).data('manufacturer_id');
	bootbox.prompt({
	  title: <?php echo json_encode(lang('items_please_enter_manufacturer_name')); ?>,
	  value: $(this).data('name'),
	  callback: function(manufacturer_name) {
		  
	  	if (manufacturer_name)
	  	{
	  		$.post('<?php echo site_url("items/save_manufacturer");?>'+'/'+manufacturer_id, {manufacturer_name : manufacturer_name},function(response) {	
	  			show_feedback(response.success ? 'success' : 'error', response.message,response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);
	  			if (response.success)
	  			{
	  				$('#manufacturers_list').load("<?php echo site_url("items/manufacturers_list"); ?>");
					  location.reload();
	  			}

	  		}, "json");

	  	}
	  }
	});
});

$(document).on('click', ".add_manufacturer",function()
{
	bootbox.prompt(<?php echo json_encode(lang('items_please_enter_manufacturer_name')); ?>, function(manufacturer_name)
	{
		if (manufacturer_name)
		{
			$.post('<?php echo site_url("items/save_manufacturer");?>', {manufacturer_name : manufacturer_name},function(response) {
			
				show_feedback(response.success ? 'success' : 'error', response.message,response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);

				//Refresh tree if success
				if (response.success)
				{
					$('#manufacturers_list').load("<?php echo site_url("items/manufacturers_list"); ?>");
					location.reload();

				}
			}, "json");

		}
	});
});

$(document).on('click', ".delete_manufacturer",function()
{
	var manufacturer_id = $(this).data('manufacturer_id');
	if (manufacturer_id)
	{
		bootbox.confirm(<?php echo json_encode(lang('items_manufacturer_delete_confirmation')); ?>, function(result)
		{
			if (result)
			{
				$.post('<?php echo site_url("items/delete_manufacturer");?>', {manufacturer_id : manufacturer_id},function(response) {
				
					show_feedback(response.success ? 'success' : 'error', response.message,response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);

					//Refresh tree if success
					if (response.success)
					{
						$('#manufacturers_list').load("<?php echo site_url("items/manufacturers_list"); ?>");
						location.reload();

					}
				}, "json");
			}
		});
	}
	
});

</script>
<?php $this->load->view('partial/footer'); ?>
