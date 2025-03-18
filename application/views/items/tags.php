
<?php $this->load->view("partial/header"); ?>

<div class="modal fade tag-input-data" id="tag-input-data" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Tag</h3>
				<button type="button" id="closemodal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span class="svg-icon svg-icon-1"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <?php echo form_open_multipart('items/save_tag/',array('id'=>'tags_form','class'=>'form-horizontal')); ?>
                <div class="rounded border p-10">
                    <div class="mb-10">
                        <div class="form-check" >
                            <label class="form-check-label"
                                for="flexCheckDefault"><?php echo form_label(lang('tag')) ?></label>

                            <?php echo form_input(array(
							'type'  => 'text',
							'name'  => 'tag_name',
							'id'    => 'tag_name',
							'style' => 'margin-left: -16px;',
							'value' => '',
							'class'=> 'form-control form-control-solid form-inps',
						)); ?>
                        </div>
                    </div>
					<div class="form-check" >

                    <div class="mb-0" id="locations_list">
                        <div class="form-check">
                            <label class="form-check-label" style="margin-top: 10px;"
                                for="flexCheckChecked"><?php echo form_label(lang('do_not_sell_at_locations') ) ?></label>

                            <?php
					
					$locations = array();
					foreach($this->Location->get_all()->result() as $row)
					{
						$locations[$row->location_id] = array('name' => $row->name);
					}
					
					foreach($locations as $location_id => $location) 
					{
						$checkbox_options = array(
						'name' => 'ban_locations[]',
						'class' => 'ban_locations form-check-input',
						'id' => 'ban_locations'.$location_id,
						'value' => $location_id,
						'checked' => false,
						);
																	
						echo form_checkbox($checkbox_options). '<label for="ban_locations'.$location_id.'"><span></span></label> '.$location['name'];
					}
					?>
                        </div>
                    </div>
                    </div>

					<?php
						foreach($this->Location->get_all()->result() as $location) { 
					
					echo form_hidden('locations['.$location->location_id.'][dummy_value_prevent_notice_and_get_loop_to_run]','1');
				?>
					<div class="form-check" >

					<div class="mb-10">
                        <div class="form-check" data-keyword="<?php echo H(lang('config_keyword_payment')) ?>">
                            <label class="form-check-label"
                                for="flexCheckDefault"><?php echo form_label($location->name.' '.lang('hide_from_grid')) ?></label>

								<?php echo form_checkbox(array(
							'name'=>'locations['.$location->location_id.'][hide_from_grid]',
							'id'=>'locations_'.$location->location_id.'_hide_from_grid',
							'class' => 'hide_from_grid_checkbox delete-checkbox form-check-input',
							'value'=>1,));
						?>
                        </div>
                    </div>
                    </div>

					<?php } ?>
                </div>
				
            </div>

            <div class="modal-footer">
			<?php
						echo form_submit(array(
							'name'=>'submitf',
							'id'=>'submitf',
							'value'=>lang('save'),
							'class'=>'submit_button pull-right btn btn-primary pt-2')
						);
					?>
                <button type="button" id="closemodalbutton" class="btn btn-light pt-2" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->

            </div>
			<?php echo form_close(); ?>
        </div>
    </div>
</div>



<?php if(isset($redirect)) { ?>
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

<?php echo form_open('items/save_tag/',array('id'=>'tag_form','class'=>'form-horizontal')); ?>
<div class="row  ">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header rounded rounded-3 p-5">
                <?php echo lang("items_manage_tags"); ?></div>
            <div class="card-body">
                <a href="javascript:void(0);" class="add_tag" data-tag_id="0">[<?php echo lang('items_add_tag'); ?>]</a>
                <div id="tag_list" class="tag-tree">
                    <?php echo $tag_list; ?>
                </div>
                <a href="javascript:void(0);" class="add_tag" data-tag_id="0">[<?php echo lang('items_add_tag'); ?>]</a>
            </div>
        </div>
    </div>
</div><!-- /row -->

<?php  echo form_close(); ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
<script>
    
	$('#closemodal').click(function() {
    $('#tag-input-data').modal('hide');
});

$('#closemodalbutton').click(function() {
    $('#tag-input-data').modal('hide');
});
</script>
<script type='text/javascript'>
jQuery.noConflict();
jQuery('#tag_list').jstree({

    "core": {
        "themes": {
            "responsive": false
        }
    },
    "types": {
        "default": {
            "icon": "fa fa-folder"
        },
        "file": {
            "icon": "fa fa-file"
        }
    },
    "plugins": ["types", "checkbox"]
}).on('ready.jstree', function() {
    // Open all nodes when the tree is ready
    $(this).jstree('open_all');
});

$("#tags_form").submit(function(event) {
    event.preventDefault();

    $(this).ajaxSubmit({
        success: function(response, statusText, xhr, $form) {
            show_feedback(response.success ? 'success' : 'error', response.message, response
                .success ? <?php echo json_encode(lang('success')); ?> :
                <?php echo json_encode(lang('error')); ?>);
            if (response.success) {
                $("#tag-input-data").modal('hide');
                $('#tag_list').load("<?php echo site_url("items/tag_list"); ?>");
                location.reload();


            }
        },
        dataType: 'json',
    });
});

$(document).on('click', ".edit_tag", function() {
    $("#tagModalDialogTitle").html(<?php echo json_encode(lang('edit')); ?>);

    var tag_id = $(this).data('tag_id');
    $("#tags_form").attr('action', SITE_URL + '/items/save_tag/' + tag_id);

    $("#tags_form").find('#tag_name').val($(this).data('name'));

    $('#del_image').prop('checked', false);

    $(".hide_from_grid_checkbox").prop('checked', false);
    $.getJSON(SITE_URL + '/items/get_hidden_locations_for_tag/' + tag_id, function(locations) {
        for (var k = 0; k < locations.length; k++) {
            $("#locations_" + locations[k] + "_hide_from_grid").prop('checked', true);
        }
    });

    $("#tag-modal .ban_locations").prop('checked', false);
    $.getJSON("<?php echo site_url('items/get_banned_locations_for_tag');?>/" + tag_id, function(
        banned_location_ids) {
        for (var k = 0; k < banned_location_ids.length; k++) {
            var location_id = banned_location_ids[k];

            $("#ban_locations" + location_id).prop('checked', true);

        }
    });

    //show
    $("#tag-input-data").modal('show');
});

$(document).on('click', ".add_tag", function() {
    bootbox.prompt(<?php echo json_encode(lang('items_please_enter_tag_name')); ?>, function(tag_name) {
        if (tag_name) {
            $.post('<?php echo site_url("items/save_tag");?>', {
                tag_name: tag_name
            }, function(response) {

                show_feedback(response.success ? 'success' : 'error', response.message, response
                    .success ? <?php echo json_encode(lang('success')); ?> :
                    <?php echo json_encode(lang('error')); ?>);

                //Refresh tree if success
                if (response.success) {
                    $('#tag_list').load("<?php echo site_url("items/tag_list"); ?>");
                    location.reload();

                }
            }, "json");

        }
    });
});

$(document).on('click', ".delete_tag", function() {
    var tag_id = $(this).data('tag_id');
    if (tag_id) {
        bootbox.confirm(<?php echo json_encode(lang('items_tag_delete_confirmation')); ?>, function(result) {
            if (result) {
                $.post('<?php echo site_url("items/delete_tag");?>', {
                    tag_id: tag_id
                }, function(response) {

                    show_feedback(response.success ? 'success' : 'error', response.message,
                        response.success ?
                        <?php echo json_encode(lang('success')); ?> :
                        <?php echo json_encode(lang('error')); ?>);

                    //Refresh tree if success
                    if (response.success) {
                        $('#tag_list').load("<?php echo site_url("items/tag_list"); ?>");
                        location.reload();

                    }
                }, "json");
            }
        });
    }

});
</script>
<?php $this->load->view('partial/footer'); ?>