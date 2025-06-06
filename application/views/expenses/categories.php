<?php $this->load->view("partial/header"); ?>

<?php if ($redirect) { ?>
	<div class="manage_buttons">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top-10">
				<div class="buttons-list">
					<div class="pull-right-btn">
						<?php echo
							anchor(site_url($redirect), ' ' . lang('done'), array('class' => 'btn btn-primary btn-lg ion-android-exit', 'title' => ''));
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<?php $this->load->view('partial/categories/expense_category_modal', array('categories' => $categories)); ?>
<div class="row <?php echo $redirect ? 'manage-table  card p-5' : ''; ?>">
	<div class="col-md-12 form-horizontal">
		<div class="card">
			<div class="card-header rounded rounded-3 p-5"><?php echo lang("items_manage_categories"); ?></div>
			<div class="card-body">
				<a href="javascript:void(0);" class="add_child_category" data-category_id="0">[<?php echo lang('items_add_root_category'); ?>]</a>
				<div id="category_tree">
					<?php echo $category_tree; ?>
				</div>
				<a href="javascript:void(0);" class="add_child_category" data-category_id="0">[<?php echo lang('items_add_root_category'); ?>]</a>
			</div>
		</div>
	</div>
</div><!-- /row -->
</div>

<script type='text/javascript'>
	$(document).on('click', ".edit_category", function() {
		$("#categoryModalDialogTitle").html(<?php echo json_encode(lang('edit')); ?>);
		var parent_id = $(this).data('parent_id') ? $(this).data('parent_id') : 0;
		$("#categories_form").find('#parent_id').val(parent_id);

		$parent_id_select = $('#parent_id');
		$parent_id_select[0].selectize.setValue(parent_id, false);

		var category_id = $(this).data('category_id');
		$("#categories_form").attr('action', SITE_URL + '/expenses/save_category/' + category_id);

		//Populate form
		$("#categories_form").find('#category_name').val($(this).data('name'));
		$("#categories_form").find('#category_info_popup').val($(this).data('info-popup'));


		//show
		$("#category-input-data").modal('show');
	});

	$(document).on('click', ".add_child_category", function() {
		$("#categoryModalDialogTitle").html(<?php echo json_encode(lang('items_add_child_category')); ?>);
		var parent_id = $(this).data('category_id');

		$parent_id_select = $('#parent_id');
		$parent_id_select[0].selectize.setValue(parent_id, false);

		$("#categories_form").attr('action', SITE_URL + '/expenses/save_category');

		//Clear form
		$("#categories_form").find('#category_name').val("");

		$("#category-input-data").modal('show');

	});

	$("#categories_form").submit(function(event) {
		event.preventDefault();

		$(this).ajaxSubmit({
			success: function(response, statusText, xhr, $form) {
				show_feedback(response.success ? 'success' : 'error', response.message, response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);
				if (response.success) {
					$("#category-input-data").modal('hide');
					$('#category_tree').load("<?php echo site_url("expenses/get_category_tree_list"); ?>");
					var category_id_selectize = $("#parent_id")[0].selectize;
					response.categories.unshift({
						value: 0,
						text: <?php echo json_encode(lang('none')); ?>
					});
					category_id_selectize.clearOptions();
					category_id_selectize.addOption(response.categories);
					category_id_selectize.addItem(response.selected, true);

				}
			},
			dataType: 'json',
		});
	});

	$(document).on('click', ".delete_category", function() {
		var category_id = $(this).data('category_id');
		if (category_id) {
			bootbox.confirm(<?php echo json_encode(lang('items_category_delete_confirmation')); ?>, function(result) {
				if (result) {
					$.post('<?php echo site_url("expenses/delete_category"); ?>', {
						category_id: category_id
					}, function(response) {

						show_feedback(response.success ? 'success' : 'error', response.message, response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);

						//Refresh tree if success
						if (response.success) {
							$('#category_tree').load("<?php echo site_url("expenses/get_category_tree_list"); ?>");
						}
					}, "json");
				}
			});
		}
	});

</script>
<?php $this->load->view('partial/footer'); ?>