<?php $this->load->view("partial/header"); ?>

<div class="row" id="form">

    <div class="spinner" id="grid-loader" style="display:none">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
    </div>
    <div class="col-md-12">
        <?php echo form_open('items/save_modifier/'.$modifier_info->id,array('id'=>'modifier_form','class'=>'form-horizontal')); ?>
        <div class="card ">
            <div class="card-header rounded rounded-3 p-5">
                <h3 class="panel-title">
                    <i class="ion-edit"></i>
                    <?php if(!$modifier_info->id) { echo lang('items_new_modifier'); } else { echo lang('items_update_modifier'); } ?>
                    <small>(<?php echo lang('fields_required_message'); ?>)</small>
                </h3>

            </div>
            <div class="card-body">


                <div class="row">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-10">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="mb-10">
                                    <div class="form-check">
                                        <label class="form-check-label"
                                            for="flexCheckDefault"><?php echo form_label(lang('name')) ?></label>

                                        <?php echo form_input(array(
                                            'class'=>'form-control form-control-solid form-inps',
                                            'name'=>'name',
                                            'id'=>'name_input',
                                            'required'=>'required',
                                            'value'=>$modifier_info->name)
                                        );?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">

                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-10">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10" >
                                <?php echo form_label(lang('items').':'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                    </div>
                </div>

                <div class="form-group no-padding-right">




                    <!-- <div class="row form-group"> -->
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-10">
                        <div class="py-5 mb-5">
                            <div class="rounded border p-10">
                                <div class="table-responsive">
                                    <table id="price_modifier_items" class="table">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('name'); ?></th>
                                                <th><?php echo lang('cost_price'); ?></th>
                                                <th><?php echo lang('unit_price'); ?></th>
                                                <th><?php echo lang('delete'); ?></th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
				foreach($modifier_items as $item)
				{
				?>
                                            <tr>
                                                <td><input type="text" data-index="<?php echo $item['id'] ?>"
                                                        class="modifier_items form-control form-control-solid"
                                                        name="modifier_items[<?php echo $item['id']; ?>][name]"
                                                        value="<?php echo H($item['name']); ?>" /></td>
                                                <td><input type="text" data-index="<?php echo $item['id'] ?>"
                                                        class="modifier_items form-control form-control-solid"
                                                        name="modifier_items[<?php echo $item['id']; ?>][cost_price]"
                                                        value="<?php echo H($item['cost_price'] !== NULL ? to_currency_no_money($item['cost_price']) : '' ); ?>" />
                                                </td>
                                                <td><input type="text" data-index="<?php echo $item['id'] ?>"
                                                        class="modifier_items form-control form-control-solid"
                                                        name="modifier_items[<?php echo $item['id']; ?>][unit_price]"
                                                        value="<?php echo H($item['unit_price'] !== NULL ? to_currency_no_money($item['unit_price']) : '' ); ?>" />
                                                </td>
                                                <td>
                                                    <a class="delete_modifier_item btn btn-sm btn-danger"
                                                        href="javascript:void(0);"
                                                        data-modifier_item-id='<?php echo $item['id']; ?>'><?php echo lang('delete'); ?></a>
                                                </td>
                                            </tr>
                                            <?php
				}
				?>

                                        </tbody>
                                    </table>

                                    <a href="javascript:void(0);" class="btn btn-sm btn-primary"
                                        id="add_modifier_item"><?php echo lang('add'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                    </div>
                    <!-- </div> -->


                </div>




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
$(".delete_modifier_item").click(function() {
    $("#modifier_form").append('<input type="hidden" name="modifier_items_to_delete[]" value="' + $(this).data(
        'modifier_item-id') + '" />');
    $(this).parent().parent().remove();
});


var add_index = -1;

$("#add_modifier_item").click(function() {
    $("#price_modifier_items tbody").append(
        '<tr><td><input type="text" class="modifier_items form-control form-control-solid" data-index="' +
        add_index +
        '" name="modifier_items[' + add_index +
        '][name]" value="" /></td><td><input type="text" class="modifier_items form-control form-control-solid" data-index="' +
        add_index + '" name="modifier_items[' + add_index +
        '][cost_price]" value=""/></td><td><input type="text" class="modifier_items form-control form-control-solid" data-index="' +
        add_index + '" name="modifier_items[' + add_index +
        '][unit_price]" value=""/></td><td>&nbsp;</td></tr>');
    add_index--;
});
</script>
<?php $this->load->view('partial/footer')?>