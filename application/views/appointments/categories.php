<?php $this->load->view("partial/header"); ?>


<?php echo form_open('appointments/save_category/',array('id'=>'category_form','class'=>'form-horizontal')); ?>
<div class="row">
	<div class="col-md-12">
		<div class="card ">
			<div class="card-header rounded rounded-3 p-5"><?php echo lang("items_manage_categories"); ?></div>
			<div class="card-body">
				<a href="javascript:void(0);" class="add_category" data-category_id="0">[<?php echo lang('add_category'); ?>]</a>
					<div id="category_list" class="category-tree">
						<?php echo $category_list; ?>
					</div>
				<a href="javascript:void(0);" class="add_category" data-category_id="0">[<?php echo lang('add_category'); ?>]</a>
			</div>
		</div>
	</div>
</div><!-- /row -->

<?php  echo form_close(); ?>
</div>

			
<script type='text/javascript'>
$('#category_list').jstree({
	
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
  $("#category_list").bind("changed.jstree",
    function (e, data) {
		if ($(data.node.a_attr.href).is('.form-check-input.hide_from_grid')) {
            // Prevent the checkbox click event from propagating to the parent <a> element
            data.event.stopPropagation();
       
            // Handle checkbox click actions here, if needed
        }
    });
$(document).on('click', ".edit_category",function()
{
	var category_id = $(this).data('category_id');
	bootbox.prompt({
	  title: <?php echo json_encode(lang('please_enter_category_name')); ?>,
	  value: $(this).data('name'),
	  callback: function(category_name) {
		  
	  	if (category_name)
	  	{
	  		$.post('<?php echo site_url("appointments/save_category");?>'+'/'+category_id, {category_name : category_name},function(response) {	
	  			show_feedback(response.success ? 'success' : 'error', response.message,response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);
	  			if (response.success)
	  			{
	  				$('#category_list').load("<?php echo site_url("appointments/category_list"); ?>");
	  			}
	  		}, "json");

	  	}
	  }
	});
});

$(document).on('click', ".add_category",function()
{
	bootbox.prompt(<?php echo json_encode(lang('please_enter_category_name')); ?>, function(category_name)
	{
		if (category_name)
		{
			$.post('<?php echo site_url("appointments/save_category");?>', {category_name : category_name},function(response) {
			
				show_feedback(response.success ? 'success' : 'error', response.message,response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);

				//Refresh tree if success
				if (response.success)
				{
					$('#category_list').load("<?php echo site_url("appointments/category_list"); ?>");
				}
			}, "json");

		}
	});
});

$(document).on('click', ".delete_category",function()
{
	var category_id = $(this).data('category_id');
	if (category_id)
	{
		bootbox.confirm(<?php echo json_encode(lang('items_category_delete_confirmation')); ?>, function(result)
		{
			if (result)
			{
				$.post('<?php echo site_url("appointments/delete_category");?>', {category_id : category_id},function(response) {
				
					show_feedback(response.success ? 'success' : 'error', response.message,response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);

					//Refresh tree if success
					if (response.success)
					{
						$('#category_list').load("<?php echo site_url("appointments/category_list"); ?>");
					}
				}, "json");
			}
		});
	}
	
});

</script>
<?php $this->load->view('partial/footer'); ?>
