<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
	
	function reload_items_table()
	{
		clearSelections();
			$("#table_holder").load(<?php echo json_encode(site_url("$controller_name/reload_table")); ?>);
	}
	
	$(document).ready(function()
	{	

		// Merge Items
		$('#merge').click(function()
		{
			var selected = get_selected_values();

			if (selected.length == 0)
			{
				bootbox.alert(<?php echo json_encode(lang('must_select_item_for_barcode')); ?>);
				return false;
			}

			$("#items_to_merge").empty();
			$.post(<?php echo json_encode(site_url("$controller_name/get_items_info")); ?>, {items:selected}, function(json)
			{
				for(var k=0;k<json.length;k++)
				{
					var item_id 	= json[k]['item_id'];
					var item_name 	= json[k]['name'];
					$("#items_to_merge").append('<option value='+item_id+'>'+item_name+'</option>')
				}
				$("#merge-items").modal('show');
			},'json');
			
			return false;
		});
			
		$("#merge_items_form").submit(function(e)
		{
			e.preventDefault();
			var selected = get_selected_values();

			$.post(<?php echo json_encode(site_url("$controller_name/merge_items")); ?>, {items:selected,items_to_merge:$("#items_to_merge").val()}, function(json)
			{
				$("#merge-items").modal('hide');
				show_feedback('success', <?php echo json_encode(lang('items_merge_successful')); ?>, <?php echo json_encode(lang('success')); ?>);
				
				reload_items_table();
			});
				
		});
		$("#fields").select2({dropdownAutoWidth : true});
		$("#category_id").select2({dropdownAutoWidth : true});
				
		$("#sortable").sortable({
			items : '.sort',
			containment: "#sortable",
			cursor: "move",
			handle: ".handle",
			revert: 100,
			update: function( event, ui ) {
				$input = ui.item.find("input[type=checkbox]");
				$input.trigger('change');
			}
		});
		
		$("#sortable").disableSelection();
		
		$("#config_columns a").on("click", function(e) {
			e.preventDefault();
			
			if($(this).attr("id") == "reset_to_default")
			{
				//Send a get request wihtout columns will clear column prefs
				$.get(<?php echo json_encode(site_url("$controller_name/save_column_prefs")); ?>, function()
				{
					reload_items_table();
					var $checkboxs = $("#config_columns a").find("input[type=checkbox]");
					$checkboxs.prop("checked", false);
					
					<?php foreach($default_columns as $default_col) { ?>
							$("#config_columns a").find('#'+<?php echo json_encode($default_col);?>).prop("checked", true);
					<?php } ?>
				});
			}
			
			if(!$(e.target).hasClass("handle"))
			{
				var $checkboxs = $(this).find("input[type=checkbox]");
				$checkboxs.prop("checked", !$checkboxs.prop("checked")).trigger("change");
			}
			
			return false;
		});
		
		
		$("#config_columns input[type=checkbox]").change(
			function(e) {
				var columns = $("#config_columns input:checkbox:checked").map(function(){
      		return $(this).val();
    		}).get();
				
				$.post(<?php echo json_encode(site_url("$controller_name/save_column_prefs")); ?>, {columns:columns}, function(json)
				{
					reload_items_table();
				});
				
		});
		
		enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>");
		enable_select_all();
		enable_checkboxes();
		enable_row_selection();
		enable_search('<?php echo site_url("$controller_name");?>',<?php echo json_encode(lang("confirm_search"));?>);
		
		<?php if(!$deleted) { ?>
			mgs= '<?php echo json_encode(lang($controller_name."_confirm_delete"));?> </br><div class="form-check"><input id="is_cleanup" class="form-check-input" type="checkbox" value=""id="flexCheckDefault" /> <label style="margin-left:-7px" class="form-check-label" for="flexCheckDefault"><?= lang('you_want_to_cleanup') ?>?</label></div>';
			enable_delete(mgs,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
		<?php } else { ?>
			enable_delete(<?php echo json_encode(lang($controller_name."_confirm_undelete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
		<?php } ?>
		
		enable_cleanup(<?php echo json_encode(lang("items_confirm_cleanup"));?>);

		<?php if ($controller_name == 'items') { ?>
			enable_sync_ig_bestsellers(<?php echo json_encode(lang($controller_name."_confirm_sync_ig_bestsellers"));?>);
			enable_sync_wgp_inventory(<?php echo json_encode(lang($controller_name."_confirm_sync_wgp_inventory"));?>);
			enable_sync_p4_inventory(<?php echo json_encode(lang($controller_name."_confirm_sync_p4_inventory"));?>);
		<?php } ?>

		$('#generate_barcodes').click(function()
		{
			var selected = get_selected_values();
			
			if (selected.length == 0)
			{
				bootbox.alert(<?php echo json_encode(lang('must_select_item_for_barcode')); ?>);
				return false;
			}

			$("#skip-labels").modal('show');
			return false;
		});
		
		$("#generate_barcodes_form").submit(function()
		{
			var selected = get_selected_values();
			var num_labels_skip = $("#num_labels_skip").val() ? $("#num_labels_skip").val() : 0;
			var url = '<?php echo site_url("items/generate_barcodes");?>'+'/'+selected.join('~')+'/'+num_labels_skip;
			window.location = url;
			return false;
		});

		$('#generate_barcode_labels').click(function()
		{
			var selected = get_selected_values();
			if (selected.length == 0)
			{
				bootbox.alert(<?php echo json_encode(lang('must_select_item_for_barcode')); ?>);
				return false;
			}

			$(this).attr('href','<?php echo site_url("items/generate_barcode_labels");?>/'+selected.join('~'));
		});		

		<?php if ($this->session->flashdata('manage_success_message')) { ?>
			show_feedback('success', <?php echo json_encode($this->session->flashdata('manage_success_message')); ?>, <?php echo json_encode(lang('success')); ?>);
			<?php } ?>
		});
	



function toggleFieldsAndCategoriesSearchListener(x) {		
    if (sm.matches) { 			
			$('#fields').prop('disabled', false);
			$("#category_id").prop('disabled', false);
    } 
		else
		{
			$('#fields').val("all");
			$("#category_id").val("");
			
			$('#fields').prop('disabled', true);
			$("#category_id").prop('disabled', true);
    }
}

var sm = window.matchMedia("(min-width: 768px)");
toggleFieldsAndCategoriesSearchListener(sm) // Call listener function at run time
sm.addListener(toggleFieldsAndCategoriesSearchListener) // Attach listener function on state changes
		

function post_bulk_form_submit(response)
{
	$("#myModal").modal('hide');
	show_feedback(response.success ? 'success' : 'error',response.message,response.success ? <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);
	reload_items_table();
}

function select_inv()
{	
	bootbox.confirm(<?php echo json_encode(lang('items_select_all_message')); ?>, function(result)
	{
		if (result)
		{
			$('#select_inventory').val(1);
			$('#selectall').css('display','none');
			$('#selectnone').css('display','block');
			$.post('<?php echo site_url("items/select_inventory");?>', {select_inventory: $('#select_inventory').val()});
		}
	});
}
function select_inv_none()
{
	$('#select_inventory').val(0);
	$('#selectnone').css('display','none');
	$('#selectall').css('display','block');
	$.post('<?php echo site_url("items/clear_select_inventory");?>', {select_inventory: $('#select_inventory').val()});	
}

$.post('<?php echo site_url("items/clear_select_inventory");?>', {select_inventory: $('#select_inventory').val()});	

</script>


<div class="modal fade skip-labels" id="merge-items" role="dialog" aria-labelledby="skipLabels" aria-hidden="true">
    <div class="modal-dialog customer-recent-sales">
      	<div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true">&times;</span></button>
	          	<h4 class="modal-title" id="skipLabels"><?php echo lang('items_merge_items') ?></h4>
	        </div>
	        <div class="modal-body">
				
	          	<?php echo form_open("customers/do_merge", array('id'=>'merge_items_form','autocomplete'=> 'off')); ?>
							<label for="items_to_merge"><?php echo lang('customers_merge_into');?></label>
							<select id="items_to_merge" name="items_to_merge" class="form form-control">
							</select>
							<br />
							
					<?php echo form_submit('merge_items_form',lang("submit"),'class="btn btn-block btn-primary"'); ?>
				<?php echo form_close(); ?>
				
	        </div>
    	</div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade skip-labels" id="skip-labels" role="dialog" aria-labelledby="skipLabels" aria-hidden="true">
    <div class="modal-dialog customer-recent-sales">
      	<div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal" aria-label=<?php echo json_encode(lang('close')); ?>><span aria-hidden="true">&times;</span></button>
	          	<h4 class="modal-title" id="skipLabels"><?php echo lang('skip_labels') ?></h4>
	        </div>
	        <div class="modal-body">
				
	          	<?php echo form_open("items/generate_barcodes", array('id'=>'generate_barcodes_form','autocomplete'=> 'off')); ?>				
				<input type="text" class="form-control text-center" name="num_labels_skip" id="num_labels_skip" placeholder="<?php echo lang('skip_labels') ?>">
					<?php echo form_submit('generate_barcodes_form',lang("submit"),'class="btn btn-block btn-primary"'); ?>
				<?php echo form_close(); ?>
				
	        </div>
    	</div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<nav class="">
			
	<!-- Css Loader  -->
	<div class="spinner" id="ajax-loader" style="display:none">
	  <div class="rect1"></div>
	  <div class="rect2"></div>
	  <div class="rect3"></div>
	</div>
		
		<div class="manage-row-options hidden row">
		
		<div class="email_buttons items">
			<div class="row">
				
			<div class="col-md-12 pull-left">
			<?php if(!$deleted) { ?>
			
			<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
			<?php echo
				anchor("$controller_name/bulk_edit/",
				'<span class="">'.lang("edit").'</span>',
				array('id'=>'bulk_edit','data-toggle'=>'modal','data-target'=>'#myModal',
					'class' => 'btn btn-primary btn-lg  disabled',
					'title'=>lang('items_edit_multiple_items'))); 
			?>
			<?php } ?>
			
			<a href="#" class="btn btn-lg btn-select-all btn-primary"><span class="ion-android-checkbox-outline"></span> <span class="hidden-xs"><?php echo lang('select_all'); ?></span></a>
			
			<div class="btn-group piluku-dropdown" role="group">
			  <button class="btn btn-primary btn-lg dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			    <?php echo lang("labels"); ?>
			    <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
			    <li><?php echo anchor("$controller_name/generate_barcode_labels", lang("label_printer"), array('id' => 'generate_barcode_labels')); ?></li>
			    <li><?php echo anchor("$controller_name/generate_barcodes", lang("standard_printer"), array('id' => 'generate_barcodes')); ?></li>
			  </ul>
			</div>
			
			<a href="#" class="btn btn-lg btn-clear-selection btn-warning"><span class="ion-close-circled"></span> <span class="hidden-xs"><?php echo lang('clear_selection'); ?></span></a>
		

			<?php 
			echo 
				anchor("$controller_name/merge",
				'<span class="ion-document"></span> <span class="hidden-xs">'.lang("merge").'</span>',
				array('id'=>'merge', 
					'class' => 'btn btn-primary btn-lg  disabled',
					'target' => '_blank',
					'title'=>lang('merge'))); 
			?>
			<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>				
			<?php echo 
				anchor("$controller_name/delete",
				'<span class="ion-trash-a"></span> '.'<span class="hidden-xs">'.lang("delete").'</span>',
				array('id'=>'delete','class'=>'btn btn-danger btn-lg','title'=>lang("delete"))); 
			?>
			<?php } ?>
		<?php } else { ?>
				<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
				<?php echo anchor("$controller_name/undelete",
						'<span class="ion-trash-a"></span> '.'<span class="hidden-xs">'.lang("undelete").'</span>',
						array('id'=>'delete','class'=>'btn btn-success btn-lg disabled delete_inactive','title'=>lang("undelete"))); ?>
				<?php } ?>

				<a href="#" class="btn btn-lg btn-clear-selection btn-warning"><span class="ion-close-circled"></span> <?php echo lang('clear_selection'); ?></a>		
		<?php } ?>
		</div><!-- end col-->
		</div> <!-- end row -->
			
		
		</div>
	</div>

	
</nav>
													

<div class="row alert-select-all">
	<div class="col-md-12">

		<div id="selectall" class="selectall text-center" onclick="select_inv()">
			<div class="alert alert-warning">
				<?php echo lang('items_all').' '.lang('items_select_inventory').' <strong>'.lang('items_for_current_search').'</strong>'; ?>
			</div>
		</div>

		<div id="selectnone" class="selectnone text-center" onclick="select_inv_none()" >
			<div class="alert alert-success">
				<?php echo '<strong>'.lang('items_selected_inventory_total').' '.lang('items_select_inventory_none').'</strong>'; ?>
			</div>
		</div>
		
		<?php echo form_input(array(
			'name'=>'select_inventory',
			'id'=>'select_inventory',
			'style'=>'display:none',
			)); 
		?>
	</div>
</div>

	<div class="">
		<div class="row manage-table m-0">

			<div class="progress" id="progress_container" style="display:none;margin-bottom:10px;">
				<div class="progress-bar progress-bar-striped active" role="progressbar" id="progessbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
				<span id="progress_percent">0</span>% <span id="progress_title"><?php echo lang('migrate_complete');?></span> <span id="progress_message"></span>
				</div>
			</div>

			<div class="card">
				<div class="card-header   ">
					<!-- <h3 class="card-title">
					<?php echo ($deleted ? lang('deleted').' ' : '').lang('module_'.$controller_name); ?>
						<span title="<?php echo $total_rows; ?> total <?php echo $controller_name?>" class="badge bg-danger tip-left" id="manage_total_items"><?php echo $total_rows; ?></span>
						
						<div class="panel-options custom">
								
						</div>
					</h3> -->
					<div class=" card-toolbar w-100 d-flex justify-content-between">
					<?php echo form_open("$controller_name/search",array('id'=>'search_form', 'autocomplete'=> 'off', 'class'=>'')); ?>
						<div class="search search-items no-left-border">
							
						
							<ul class="list-inline  ">
								<li>
									&nbsp;
									<input type="text" class="form-control form-control-solid w-250px ps-14" name='search' id='search' value="<?php echo H($search); ?>" placeholder="<?php echo $deleted ? lang('search_deleted') : lang('search'); ?> <?php echo lang('module_'.$controller_name); ?>"/>
								</li>
								<li class="hidden-xs advance_search hidden">
									<?php
								$searchable_fields = array(
									'all'=>lang('all'),
									$this->db->dbprefix('items').'.item_id' => lang('item_id'),
									$this->db->dbprefix('items').'.item_number' => lang('item_number_expanded'),
									$this->db->dbprefix('locations').'.company' => lang('company'),
									$this->db->dbprefix('locations').'.business_type' => lang('business_type'),
									$this->db->dbprefix('items').'.product_id' => lang('product_id'),
									$this->db->dbprefix('items').'.name' => lang('item_name'),
									$this->db->dbprefix('items').'.description' => lang('description'),
									$this->db->dbprefix('items').'.size' => lang('size'),
									$this->db->dbprefix('items').'.cost_price' => lang('cost_price'),
									$this->db->dbprefix('items').'.unit_price' => lang('unit_price'),
									$this->db->dbprefix('items').'.promo_price' => lang('items_promo_price'),
									$this->db->dbprefix('location_items').'.quantity' =>lang('items_quantity'),
									$this->db->dbprefix('items').'.reorder_level' => lang('items_reorder_level'),
									$this->db->dbprefix('suppliers').'.company_name' => lang('supplier'),
									$this->db->dbprefix('manufacturers').'.name' => lang('manufacturer'),
									$this->db->dbprefix('tags').'.name' => lang('tag'),
									);
									for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++)
									{
										if($this->Item->get_custom_field($k) !== false)
										{
											$searchable_fields[$this->db->dbprefix('items').".custom_field_${k}_value"] = $this->Item->get_custom_field($k);
										}
									}
									?>
								<?php echo lang('fields'); ?>: 
								<?php echo form_dropdown('fields', 
								$searchable_fields,$fields, 'class="" id="fields"');
									?>
									</li>
								<li class="hidden-xs advance_search hidden">
									<?php echo lang('category'); ?>: 	
									<?php echo form_dropdown('category_id', $categories,$category_id, 'class="" id="category_id"'); ?>
								</li>
								<li>
									<button type="submit" class="btn btn-light btn-active-light-primary btn-lg"><span class="ion-ios-search-strong"></span><span class="hidden-xs hidden-sm"> <?php echo lang("search"); ?></span></button>
								</li>
								<li>
									<div class="clear-block items-clear-block <?php echo ($search=='') ? 'hidden' : ''  ?>">
										<a class="clear" href="<?php echo site_url($controller_name.'/clear_state'); ?>">
											<i class="ion ion-close-circled"></i>
										</a>	
									</div>
								</li>
								<li>
									<span class="btn btn-light toggle_advance_close  "  title="Close Advance Search" >
									<img src="<?php echo base_url() ?>assets/css_good/media/icons/duotune/general/gen031.svg"/>
									</span>
								</li>


							</ul>


						</div>
					<?php echo form_close() ?>

			<div class="buttons-list items-buttons">
				<div class="pull-right-btn">
					<div class="spinner hidden" id="ajax-loader">
						<div class="rect1"></div>
						<div class="rect2"></div>
						<div class="rect3"></div>
					</div>
					<?php if ($deleted) 
					{
						echo 
						anchor("$controller_name/toggle_show_deleted/0",
							'<span class="ion-android-exit"></span> <span class="hidden-xs">'.lang('done').'</span>',
							array('class'=>'btn btn-light btn-active-light-primary btn-lg toggle_deleted','title'=> lang('done')));
					}	
					?>     
					
						
					<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id) && !$deleted) {?>	

						<?php if($this->config->item('enable_quick_items')) { ?>
						<?php echo anchor($controller_name."/quick_modal",
						'<span class="ion-plus"> '.lang($controller_name.'_new').'</span>',
						array('id' => 'new-person-btn', 'data-toggle'=>"modal", 'data-target'=>"#myModalDisableClose", 'class'=>'btn btn-primary btn-active-light-primary btn-lg hidden-sm hidden-xs', 'title'=>lang($controller_name.'_new'))); ?>

						<?php } else {
						 $query = http_build_query(array('redirect' => 'items', 'progression' =>  1, 'quick_edit' => null));
						 echo	anchor("$controller_name/view/-1?".$query,
							'<span class="ion-plus"></span> '.lang($controller_name.'_new'),
							array('class'=>'btn btn-primary btn-active-light-primary btn-lg hidden-sm hidden-xs', 
								'title'=>lang($controller_name.'_new')));
						?>
					<?php } } ?>
					<?php if(!$deleted) { ?>
					
					<div class="piluku-dropdown btn-group">
						<button type="button" class="btn btn-more btn-light btn-active-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						More
						<i class="visible-xs ion-android-more-vertical"></i>
					</button>
					<ul class="dropdown-menu dropdown-menu-right" role="menu">
						
						<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>				
						<li class="visible-sm visible-xs">
							<?php echo 
								anchor("$controller_name/view/-1?redirect=items&progression=1",
								'<span class="ion-plus-round"> '.lang('add').' '.lang($controller_name.'_new').'</span>',
								array('class'=>'', 
									'title'=>lang($controller_name.'_new')));
							?>
						</li>
						<?php } ?>
	
						
							

						<?php if ($this->Employee->has_module_action_permission($controller_name, 'count_inventory', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

						<li>
							<?php echo anchor("$controller_name/damage_count?redirect=items",
								'<span class="ion-ios-paper-outline"> '.lang("items_count_damage_inventory").'</span>',
								array('class'=>'', 'title'=>lang('items_count_inventory')));
							?>
						</li>
						
						<li>
							<?php echo anchor("$controller_name/count?redirect=items",
								'<span class="ion-ios-paper-outline"> '.lang("items_count_inventory").'</span>',
								array('class'=>'', 'title'=>lang('items_count_inventory')));
							?>
						</li>			
						<?php } ?>

						<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>				
							<li>
								<?php echo anchor("$controller_name/excel_import?redirect=items",
								'<span class="ion-ios-download-outline"> '.lang("excel_import").'</span>',
								array('class'=>' ', 'title'=>lang('excel_import')));
								?>
							</li>
							
							<?php if ($this->Employee->has_module_action_permission($controller_name, 'excel_export', $this->Employee->get_logged_in_employee_info()->person_id)) {?>				
							
							<li>
								<?php echo anchor("$controller_name/excel_export/",
								'<span class="ion-ios-upload-outline"> '.lang("excel_export").'</span>',
								array('class'=>' ', 'title'=>lang('excel_export')));
								?>
							</li>
							
							<?php } ?>

							<?php if (
							$this->config->item('branding')['code'] == 'phpsalesmanager' &&
							$this->config->item('ig_api_bearer_token') && $this->config->item('enable_ig_integration')) {?>
							<li>
								<?php echo anchor(
									"$controller_name/sync_ig_bestsellers/",
									'<span class="ion-loop"> '.lang("items_sync_ig_bestsellers").'</span>',
									array(
										'id'=>'items_sync_ig_bestsellers',
										'class'=>'hidden-xs import',
										'title'=>lang('items_sync_ig_bestsellers')
									)
								);
								?>
							</li>
							<?php
							}
							if( $this->config->item('branding')['code'] == 'phpsalesmanager' &&
							$this->config->item('wgp_integration_pkey') && $this->config->item('enable_wgp_integration')) {?>
							<li>
								<?php echo anchor(
									"$controller_name/sync_wgp_inventory/",
									'<span class="ion-loop"> '.lang("items_sync_wgp_inventory").'</span>',
									array(
										'id'=>'items_sync_wgp_inventory',
										'class'=>'hidden-xs import',
										'title'=>lang('items_sync_wgp_inventory')
									)
								);
								?>
							</li>
							<?php } ?>
							<?php if (
							$this->config->item('branding')['code'] == 'phpsalesmanager' &&
							$this->config->item('p4_api_bearer_token') && $this->config->item('enable_p4_integration')) {?>
							<li>
								<?php echo anchor(
									"$controller_name/sync_p4_inventory/",
									'<span class="ion-loop"> '.lang("items_sync_p4_inventory").'</span>',
									array(
										'id'=>'items_sync_p4_inventory',
										'class'=>'hidden-xs import',
										'title'=>lang('items_sync_p4_inventory')
									)
								);
								?>
							</li>
							<?php
							}
							?>
							<?php if ($this->Employee->has_module_action_permission($controller_name, 'view_inventory_print_list', $this->Employee->get_logged_in_employee_info()->person_id)) {?>				
							<li>
								<?php echo anchor("$controller_name/inventory_print_list/",
								'<span class="ion-printer"> '.lang("items_inventory_print_list").'</span>',
								array('class'=>' ', 'title'=>lang('items_inventory_print_list')));
								?>
							</li>
							
							<li>
								<?php echo anchor("$controller_name/inventory_print_list/1",
								'<span class="ion-printer"> '.lang("items_inventory_print_list_summary").'</span>',
								array('class'=>' ', 'title'=>lang('items_inventory_print_list_summary')));
								?>
							</li>
							
							<?php } ?>
							
							
						<?php }?>
						<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
							<li>
								<?php echo 
									anchor("$controller_name/cleanup",
									'<span class="ion-loop"> '.lang("items_cleanup_old_items").'</span>',
									array('id'=>'cleanup', 'class'=>'','title'=>lang("items_cleanup_old_items"))); 
								?>
							</li>
						<?php }?>
						<li>
							<?php echo anchor("$controller_name/custom_fields", '<span class="ion-wrench"> '.lang('custom_field_config').'</span>',
								array('id'=>'custom_fields', 'class'=>'','title'=> lang('custom_field_config'))); ?>
						</li>
						
						<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
							<li>
									<?php echo anchor("$controller_name/toggle_show_deleted/1", '<span class="ion-trash-a"> '.lang($controller_name."_manage_deleted").'</span>',
										array('class'=>'toggle_deleted','title'=> lang($controller_name."_manage_deleted"))); ?>
							</li>
						<?php }?>
						</ul>
					</div>
					<?php } ?>

					<form id="config_columns">
							<div class="piluku-dropdown btn-group table_buttons ">
								<button type="button" class="btn btn-more btn-light btn-active-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<i class="ion-gear-a"></i>
								</button>
								
								<ul id="sortable" class="dropdown-menu dropdown-menu-right col-config-dropdown" role="menu">
										<li class="dropdown-header"><a id="reset_to_default" class="pull-right"><span class="ion-refresh"></span> Reset</a><?php echo lang('column_configuration'); ?></li>
																			
										<?php foreach($all_columns as $col_key => $col_value) { 
											$checked = '';
											
											if (isset($selected_columns[$col_key]))
											{
												$checked = 'checked ="checked" ';
											}
											?>
											<li class="sort "><a class="form-check form-check-sm form-check-custom form-check-solid"><input <?php echo $checked; ?> name="selected_columns[]" type="checkbox" class="columns form-check-input" id="<?php echo $col_key; ?>" value="<?php echo $col_key; ?>"><label class="form-check-label" for="<?php echo $col_key; ?>"><span></span><?php echo H($col_value['label']); ?></label><span class="handle ion-drag pull-right"></span></a></li>									
										<?php } ?>
									</ul>
							</div>
						</form>
				</div>
			</div>
					</div>
					
					
					
				</div>
				<div class="panel-body nopadding table_holder table-responsive" id="table_holder" >
						<div class="pagination pagination-top hidden-print  text-center" id="pagination_top">
											<?php echo $pagination;?>		
						</div>
					<?php echo $manage_table; ?>	
					
					
					<div class="pagination pagination-top hidden-print  text-center" id="pagination_bottom" >
						<?php echo $pagination;?>
					</div>
				</div>		
				
			</div>
		</div>
	</div>

</div>
<?php $this->load->view("partial/footer"); ?>
