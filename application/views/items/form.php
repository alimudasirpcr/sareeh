<?php $this->load->view("partial/header"); ?>
<?php $this->load->view('partial/categories/category_modal', array('categories' => $categories));?>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<?php $query = http_build_query(array('redirect' => $redirect, 'progression' => $progression ? 1 : null, 'quick_edit' => $quick_edit ? 1 : null)); ?>
<?php $manage_query = http_build_query(array('redirect' => uri_string().($query ? "?".$query : ""), 'progression' => $progression ? 1 : null, 'quick_edit' => $quick_edit ? 1 : null)); ?>
<div class="spinner" id="grid-loader" style="display:none;">
    <div class="rect1"></div>
    <div class="rect2"></div>
    <div class="rect3"></div>
</div>

<div class="manage_buttons hidden">
    <div class="row">
        <div
            class="<?php echo isset($redirect) ? 'col-xs-12 col-sm-12 col-md-12 col-lg-12': 'col-xs-12 col-sm-12 col-md-12' ?> margin-top-10">
            <div class="modal-item-info padding-left-10">
                <div class="breadcrumb-item text-dark">
                    <?php if(!$item_info->item_id) { ?>
                    <span class="modal-item-name new"><?php echo lang('items_new'); ?></span>
                    <?php } else { ?>
                    <span
                        class="modal-item-name"><?php echo H($item_info->name).' ['.lang('id').': '.$item_info->item_id.']'; ?></span>
                    <span
                        class="badge badge-success fw-semibold fs-9 px-2 ms-2 cursor-default ms-2"><?php echo H($category); ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if(isset($redirect) && !$progression) { ?>
        <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2 margin-top-10">
            <div class="buttons-list">
                <div class="pull-right-btn">
                    <?php echo 
					anchor(site_url($redirect), ' ' . lang('done'), array('class'=>'outbound_link btn btn-light-primary btn-lg ion-android-exit', 'title'=>''));
				?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>



<?php echo form_open_multipart('items/save/'.(!isset($is_clone) ? $item_info->item_id : ''),array('id'=>'item_form','class'=>'form-horizontal form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework')); ?>

<?php $this->load->view('partial/item_side_bar', array('progression' => $progression, 'query' => $query, 'item_info' => $item_info)); ?>



<div class="d-flex flex-column flex-row-fluid gap-5">
    <?php if(!$quick_edit) { ?>
    <?php $this->load->view('partial/nav', array('progression' => $progression, 'query' => $query, 'item_info' => $item_info)); ?>
    <?php } ?>
    <?php echo form_hidden('ecommerce_product_id', $item_info->ecommerce_product_id); ?>

    <div class="row  " id="form">
        <div class="col-md-12">



            <div class="card shadow-sm">
                <div class="card-header rounded rounded-3 p-5">
                    <h3 class="card-title"> 
                         <?php echo lang("item_information"); ?>
                         
                    </h3>

                    <div class="breadcrumb breadcrumb-dot text-muted fs-6 fw-semibold" id="pagination_top">
                        <?php
					if (isset($prev_item_id) && $prev_item_id)
					{
							echo anchor('items/view/'.$prev_item_id, '<span class="hidden-xs ion-chevron-left"> '.lang('items_prev_item').'</span>');
					}
					if (isset($next_item_id) && $next_item_id)
					{
							echo anchor('items/view/'.$next_item_id,'<span class="hidden-xs">'.lang('items_next_item').' <span class="ion-chevron-right"></span</span>');
					}
					?>
                    </div>
                </div>

                <div class="card-body">

                    <div class="d-flex flex-wrap gap-5">
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                            <?php echo form_label(lang('item_name').':', 'name',array('class'=>'form-label required wide')); ?>

                            <?php echo form_input(array(
							'name'=>'name',
							'id'=>'name',
							'class'=>'form-control form-inps',
							'value'=>$item_info->name)
						);?>
                        </div>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('barcode_name').':', 'name',array('class'=>'form-label wide')); ?>

                            <?php echo form_input(array(
							'name'=>'barcode_name',
							'id'=>'barcode_name',
							'class'=>'form-control form-inps',
							'value'=>$item_info->barcode_name)
						);?>
                        </div>
                    </div>

                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 my-5">
                        <?php echo form_label(lang('category').':', 'category_id',array('class'=>'form-label  required wide')); ?>

                        <?php echo form_dropdown('category_id', $categories,$item_info->category_id, 'class="form-control form-inps" id="category_id"');?>
                        <?php if ($this->Employee->has_module_action_permission('items', 'manage_categories', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                        <div>
                            <a href="javascript:void(0);" class="btn btn-light-primary my-3" id="add_category"><i
                                    class="fas fa-plus fs-4 me-2"></i><?php echo lang('add_category'); ?></a>
                        </div>
                        <?php } ?>


                    </div>

                    <?php
				foreach($this->Item->get_secondary_categories($item_info->item_id)->result() as $sec_category)
				{
				?>
                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                        <?php echo form_label(lang('secondary_category').':', 'secondary_category_id_'.$sec_category->id,array('class'=>'form-label  wide')); ?>

                        <?php echo form_dropdown('secondary_categories['.$sec_category->id.']', $categories,$sec_category->category_id, 'class="form-control form-inps secondary_category" id="secondary_category_id_'.$sec_category->id.'"');?>
                        <div>
                            <a data-index="<?php echo $sec_category->id ?>" href="javascript:void(0)"
                                class="delete_secondary_category"><?php echo lang('delete');?></a>
                        </div>


                    </div>
                    <?php
				}
				?>

                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 my-5">


                        <a href="javascript:void(0);" class="btn btn-light-primary" id="add_secondary_category"><i
                                class="fas fa-plus fs-4 me-2"></i><?php echo lang('add_secondary_category'); ?></a>

                    </div>

                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 my-5">
                        <?php echo form_label(lang('supplier').':', 'supplier_id',array('class'=>'form-label wide ')); ?>

                        <?php echo form_dropdown('supplier_id', $suppliers, $selected_supplier,'class="form-control" id="supplier_id"');?>

                    </div>

                    <?php foreach($this->Item->get_secondary_suppliers($item_info->item_id)->result() as $sec_supplier) { ?>
                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                        <?php echo form_label(lang('supplier').':', 'secondary_supplier_id_'.$sec_supplier->id,array('class'=>'form-label  wide')); ?>

                        <?php echo form_dropdown('secondary_suppliers['.$sec_supplier->id.']', $suppliers,$sec_supplier->supplier_id, 'class="form-control form-inps secondary_supplier" id="secondary_supplier_id_'.$sec_supplier->id.'"');?>
                        <div>
                            <a data-index="<?php echo $sec_supplier->id ?>" href="javascript:void(0)"
                                class="delete_secondary_supplier"><?php echo lang('delete');?></a>
                        </div>

                    </div>
                    <?php } ?>

                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                        <a href="javascript:void(0);" id="add_secondary_supplier" class="btn btn-light-primary"><i
                                class="fas fa-plus fs-4 me-2"></i><?php echo lang('add_supplier'); ?></a>

                    </div>

                    <div class="d-flex flex-wrap gap-5">
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('item_number_expanded').':', 'item_number',array('class'=>'form-label wide')); ?>

                            <?php echo form_input(array(
							'name'=>'item_number',
							'id'=>'item_number',
							'class'=>'form-control form-inps',
							'value'=>$item_info->item_number)
						);?>
                        </div>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5">
                            <?php echo form_label(lang('product_id').':', 'product_id',array('class'=>'form-label wide')); ?>

                            <?php echo form_input(array(
							'name'=>'product_id',
							'id'=>'product_id',
							'class'=>'form-control form-inps',
							'value'=>$item_info->product_id)
						);?>
                        </div>
                    </div>
                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                        <label class="form-label"><?php echo lang('additional_item_numbers') ?></label>

                        <table id="additional_item_numbers" class="table">
                            <thead>
                                <tr>
                                    <th><?php echo lang('item_number'); ?></th>
                                    <th><?php echo lang('delete'); ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (isset($additional_item_numbers) && $additional_item_numbers) {?>
                                <?php foreach($additional_item_numbers->result() as $additional_item_number) { ?>
                                <tr>
                                    <td><input type="text" class="form-control form-inps" size="50"
                                            name="additional_item_numbers[]"
                                            value="<?php echo H($additional_item_number->item_number); ?>" /></td>
                                    <td>
                                        <a class="delete_addtional_item_number btn btn-sm btn-icon btn-light-danger border-radius-5"
                                            href="javascript:void(0);">
                                            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>

                        <a href="javascript:void(0);" class="btn btn-light-primary" id="add_addtional_item_number"><i
                                class="fas fa-plus fs-4 me-2"></i><?php echo lang('items_add_item_number'); ?></a>

                    </div>

                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                        <?php echo form_label(lang('tags').':', 'tags',array('class'=>'form-label wide')); ?>

                        <?php $is_tags = $this->Employee->has_module_action_permission('items', 'manage_tags', $this->Employee->get_logged_in_employee_info()->person_id);?>
                        <div class="<?php echo $is_tags ? 'input-group' : '';?>">
                            <?php echo form_input(array(
								'name'=>'tags',
								'id'=>'tags',
								'class'=>'form-control form-control-sm form-inps',
								'value' => $tags,
							));?>
                            <?php if ($is_tags) {?>
                            <span class="input-group-btn">
                                <?php echo anchor("items/manage_tags".($manage_query ? '?'.$manage_query : ''),lang('items_manage_tags'),array('class'=> 'btn btn-light-primary padding-10', 'title'=>lang('items_manage_tags')));?>
                            </span>
                            <?php } ?>
                        </div>
                    </div>

                    <?php if (!$this->config->item('hide_size_field')) { ?>
                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                        <?php echo form_label(lang('size').':', 'size',array('class'=>'form-label wide')); ?>

                        <?php echo form_input(array(
							'name'=>'size',
							'id'=>'size',
							'class'=>'form-control form-inps',
							'value'=>$item_info->size)
						);?>
                    </div>
                    <?php }else {
					echo form_hidden('size','');
					
				} ?>


                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                        <?php echo form_label(lang('manufacturer').':', 'manufacturer_id',array('class'=>'form-label wide')); ?>

                        <?php $is_manufacturer = $this->Employee->has_module_action_permission('items', 'manage_manufacturers', $this->Employee->get_logged_in_employee_info()->person_id);?>

                        <div class="<?php echo $is_manufacturer ? 'input-group' : '';?>">
                            <?php echo form_dropdown('manufacturer_id', $manufacturers, $selected_manufacturer,'class="form-control form-control-sm" id="manufacturer_id"');?>
                            <?php if ($is_manufacturer) {?>
                            <span class="input-group-btn">
                                <?php echo anchor("items/manage_manufacturers".($manage_query ? '?'.$manage_query : ''),lang('manage_manufacturers'),array('class'=> 'btn btn-light-primary padding-12', 'title'=>lang('manage_manufacturers')));?>
                            </span>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                        <?php echo form_label(lang('description').':', 'description',array('class'=>'form-label wide')); ?>

                        <?php echo form_textarea(array(
							'name'=>'description',
							'id'=>'description',
							'value'=>$item_info->description,
							'class'=>'form-control  text-area',
							'rows'=>'5',
							'cols'=>'17')
						);?>
                    </div>

                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                        <?php echo form_label(lang('long_description').':', 'long_description',array('class'=>'form-label wide')); ?>

                        <?php echo form_textarea(array(
							'name'=>'long_description',
							'id'=>'long_description',
							'value'=>$item_info->long_description,
							'class'=>'form-control  text-area',
							'rows'=>'15',
							'cols'=>'17')
						);?>
                    </div>

                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                        <?php echo form_label(lang('info_popup').':', 'info_popup',array('class'=>'form-label wide')); ?>

                        <?php echo form_textarea(array(
							'name'=>'info_popup',
							'id'=>'info_popup',
							'value'=>$item_info->info_popup,
							'class'=>'form-control  text-area',
							'rows'=>'5',
							'cols'=>'17')
						);?>
                    </div>

                    <div class="d-flex flex-wrap gap-5">
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                            <?php echo form_label(lang('items_weight').':', 'weight',array('class'=>'form-label wide')); ?>

                            <?php echo form_input(array(
							'name'=>'weight',
							'id'=>'weight',
							'class'=>'form-control form-inps',
							'value'=>$item_info->weight ? to_quantity($item_info->weight, false) : '')
						);?>
                        </div>

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                            <?php echo form_label(lang('items_weight_unit').':', 'weight_unit',array('class'=>'form-label wide ')); ?>

                            <?php echo form_dropdown('weight_unit', array('' => lang('none'),'lb' => 'lb','oz' => 'oz','kg' => 'kg', 'g' => 'g', 'l' => 'l', 'ml' => 'ml', 'cf' => 'cf'), $item_info->weight_unit,'class="form-control" id="weight_unit"');?>

                        </div>

                    </div>
                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                    <div class="">
                        <?php echo form_label(lang('items_dimensions').':', 'dimensions',array('class'=>'form-label wide')); ?>
                        </div>
                    </div>
                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5  d-flex gap-1">
                        
                        <?php echo form_input(array(
							'name'=>'length',
							'id'=>'length',
							'placeholder' => lang('items_length'),
							'class'=>'form-control form-inps',
							'value'=>$item_info->length ? to_quantity($item_info->length, false) : '')
						);?><br />
                        <?php echo form_input(array(
							'name'=>'width',
							'id'=>'width',
							'placeholder' => lang('items_width'),
							'class'=>'form-control form-inps',
							'value'=>$item_info->width ? to_quantity($item_info->width, false) : '')
						);?><br />
                        <?php echo form_input(array(
							'name'=>'height',
							'id'=>'height',
							'placeholder' => lang('items_height'),
							'class'=>'form-control form-inps',
							'value'=>$item_info->height ? to_quantity($item_info->height, false) : '')
						);?>

                    </div>

                    <div class="d-flex flex-wrap gap-5">
                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5  is-service-toggle">
                            <?php echo form_label(lang('default_quantity').':', 'default_quantity',array('class'=>'form-label wide')); ?>

                            <?php echo form_input(array(
							'name'=>'default_quantity',
							'id'=>'default_quantity',
							'class'=>'form-control form-inps',
							'value'=>$item_info->default_quantity || $item_info->item_id ? to_quantity($item_info->default_quantity, FALSE) : '')
						);?>
                        </div>


                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5  is-service-toggle">
                            <?php echo form_label(lang('warranty').' ('.lang('in_days').'):', 'warranty',array('class'=>'form-label wide')); ?>

                            <?php echo form_input(array(
							'name'=>'warranty_days',
							'type' =>'number',
							'id'=>'warranty_days',
							'class'=>'form-control form-inps',
							'value'=>isset($item_info->warranty_days) ? $item_info->warranty_days : 0)
						);?>
                        </div>
                    </div>
                    <div class="form-check form-check-custom form-check-solid  ">

                      

                        <?php echo form_checkbox(array(
							'name'=>'item_inactive',
							'id'=>'item_inactive',
							'class' => 'item_inactive form-check-input delete-checkbox',
							'value'=>1,
							'checked'=>(boolean)(($item_info->item_inactive))));
						?>
                        <label class="form-check-label" for="item_inactive"> <?php echo lang('inactive'); ?></label>

                    </div>

                    <div class="form-check form-check-custom form-check-solid  ">


                        <?php echo form_checkbox(array(
							'name'=>'is_barcoded',
							'id'=>'is_barcoded',
							'class' => 'is_barcoded form-check-input delete-checkbox',
							'value'=>1,
							'checked'=>(boolean)(($item_info->is_barcoded)) || !$item_info->item_id));
						?>
                        <label class="form-check-label" for="is_barcoded"><?php echo lang('is_barcoded'); ?></label>

                    </div>

                    <div class="form-check form-check-custom form-check-solid ">

                        <?php echo form_checkbox(array(
									'name'=>'is_favorite',
									'id'=>'is_favorite',
									'class' => 'is_favorite form-check-input',
									'value'=>1,
									'checked'=>(boolean)(($item_info->is_favorite))
								)
							);
							?>
                        <label class="form-check-label" for="is_favorite"><?php echo lang('is_favorite'); ?></label>

                    </div>



                    <?php if ($this->config->item("ecommerce_platform")) { ?>
                    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                        <?php echo form_label(lang('items_ecommerce_shipping_class').':', 'ecommerce_shipping_class_id',array('class'=>'form-label wide ')); ?>

                        <?php echo form_dropdown('ecommerce_shipping_class_id', $ecommerce_shipping_classes, $item_info->ecommerce_shipping_class_id,'class="form-control" id="ecommerce_shipping_class_id"');?>

                    </div>
                    <?php } ?>
                    <?php
				if ($this->config->item('enable_ebt_payments')) { ?>
                    <div class="form-check form-check-custom form-check-solid  margin-top-minus-10">

                        <?php echo form_label(lang('is_ebt_item').':', '',array('class'=>'form-label wide')); ?>

                        <?php echo form_checkbox(array(
						'name'=>'is_ebt_item',
						'id'=>'is_ebt_item',
						'class' => 'is_ebt_item  form-check-input delete-checkbox',
						'value'=>1,
						'checked'=>(boolean)(($item_info->is_ebt_item))));
					?>
                        <label class="form-check-label" for="is_ebt_item"><span></span></label>

                    </div>
                    <?php } ?>
                    <div class="form-check form-check-custom form-check-solid ">

                        <?php echo form_checkbox(array(
						'name'=>'is_series_package',
						'id'=>'is_series_package',
							'class'=>'delete-checkbox form-check-input',
						'value'=>1,
						'checked'=>($item_info->is_series_package)
					));?>
                        <label class="form-check-label" for="is_series_package"><?php echo lang('items_sold_in_a_series'); ?></label>

                    </div>

                    <div class="<?php if (!$item_info->is_series_package){echo 'hidden';} ?> d-flex flex-wrap gap-5"
                        id="series_package_options">

                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                            <?php echo form_label(lang('series_quantity').':', 'series_quantity',array('class'=>'form-label wide ')); ?>

                            <?php echo form_input(array(
						'class'=>'form-control form-inps',
						'name'=>'series_quantity',
						'id'=>'series_quantity',
						'value'=>$item_info->series_quantity));?>

                        </div>


                        <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                            <?php echo form_label(lang('series_days_to_use_within').':', 'series_days_to_use_within',array('class'=>'form-label wide ')); ?>

                            <?php echo form_input(array(
						'class'=>'form-control form-inps',
						'name'=>'series_days_to_use_within',
						'id'=>'series_days_to_use_within',
						'value'=>$item_info->series_days_to_use_within));?>

                        </div>

                    </div>

                    <div class="form-check form-check-custom form-check-solid  ">

                        <?php echo form_checkbox(array(
							'name'=>'is_service',
							'id'=>'is_service',
								'class'=>'delete-checkbox form-check-input',
							'value'=>1,
							'checked'=>($item_info->is_service || (!$item_info->item_id && $this->config->item('default_new_items_to_service'))) ? 1 : 0)
						);?>
                        <label class="form-check-label" for="is_service"><?php echo lang('items_is_service'); ?></label>

                    </div>

                    <?php if ($this->config->item("ecommerce_platform")) { ?>

                    <div class="form-check form-check-custom form-check-solid  ">

                        <?php echo form_checkbox(array(
							'name'=>'is_ecommerce',
							'id'=>'is_ecommerce',
								'class'=>'delete-checkbox form-check-input',
							'value'=>1,
							'checked'=>($item_info->is_ecommerce || (!$item_info->item_id && $this->config->item('new_items_are_ecommerce_by_default'))) ? 1 : 0)
						);?>
                        <label class="form-check-label" for="is_ecommerce"><?php echo lang('items_is_ecommerce'); ?></label>

                    </div>
                    <?php } ?>
                    <div class="form-check form-check-custom form-check-solid  ">

                        <?php echo form_checkbox(array(
							'name'=>'allow_alt_description',
							'id'=>'allow_alt_description',
							'class'=>'delete-checkbox  form-check-input',
							'value'=>1,
							'checked'=>($item_info->allow_alt_description)? 1  :0)
						);?>
                        <label class="form-check-label" for="allow_alt_description"><?php echo lang('items_allow_alt_desciption'); ?></label>

                    </div>

                    <div class="form-check form-check-custom form-check-solid ">

                        <?php echo form_checkbox(array(
							'name'=>'is_serialized',
							'id'=>'is_serialized',
								'class'=>'delete-checkbox  form-check-input',
							'value'=>1,
							'checked'=>($item_info->is_serialized)? 1 : 0)
						);?>
                        <label class="form-check-label" for="is_serialized"><?php echo lang('items_is_serialized'); ?></label>

                    </div>




                    <script>
                    function loadScript(url, callback) {
                        if (document.querySelector(`script[src="${url}"]`)) {
                            console.log("Script already loaded:", url);
                            if (callback) callback();
                            return; // Script is already loaded
                        }

                        var script = document.createElement("script");
                        script.type = "text/javascript";

                        if (script.readyState) { // IE
                            script.onreadystatechange = function() {
                                if (script.readyState == "loaded" || script.readyState == "complete") {
                                    script.onreadystatechange = null;
                                    if (callback) callback();
                                }
                            };
                        } else { // Other browsers
                            script.onload = function() {
                                if (callback) callback();
                            };
                        }

                        script.src = url;
                        document.getElementsByTagName("head")[0].appendChild(script);
                    }

                    $('.xeditable').editable();
                    </script>




             

                <?php if ($this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced') { ?>

                <div class="form-check form-check-custom form-check-solid  ">

                    <?php echo form_checkbox(array(
							'name'=>'disable_loyalty',
							'id'=>'disable_loyalty',
								'class'=>'delete-checkbox   form-check-input',
							'value'=>1,
							'checked'=>($item_info->disable_loyalty)? 1 : 0)
						);?>
                    <label class="form-check-label" for="disable_loyalty"><?php echo lang('disable_loyalty'); ?></label>

                </div>

                <?php } ?>

                <?php if($this->config->item('loyalty_option') == 'advanced'){?>
                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                    <?php echo form_label(lang('loyalty_multiplier').':', 'loyalty_multiplier', array('class'=>'form-label wide')); ?>

                    <?php echo form_input(array(
						'class'=>'form-control form-inps',
						'name'=>'loyalty_multiplier',
						'id'=>'loyalty_multiplier',
						'value'=>$item_info->loyalty_multiplier ? to_quantity($item_info->loyalty_multiplier, false) : ''));?>

                </div>
                <?php }?>

                <?php if ($this->config->item('verify_age_for_products')) { ?>

                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                    <?php echo form_label(lang('requires_age_verification').':', 'verify_age',array('class'=>'form-label wide')); ?>

                    <?php echo form_checkbox(array(
								'name'=>'verify_age',
								'id'=>'verify_age',
									'class'=>'delete-checkbox',
								'value'=>1,
								'checked'=>($item_info->verify_age)? 1 : 0)
							);?>
                    <label for="verify_age"><span></span></label>

                </div>

                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5  <?php if (!$item_info->verify_age){echo 'hidden';} ?>"
                    id="required_age_container">
                    <?php echo form_label(lang('required_age').':', 'required_age',array('class'=>'form-label wide')); ?>

                    <?php echo form_input(array(
								'name'=>'required_age',
								'id'=>'required_age',
								'class'=>'form-control form-inps',
								'value' => $item_info->item_id ? $item_info->required_age : $this->config->item('default_age_to_verify'),
							));?>

                </div>

                <?php } ?>
                <?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { ?>
                <?php
				 $custom_field = $this->Item->get_custom_field($k);
				 if($custom_field !== FALSE) { 
					 
					$required = false;
					$required_text = '';
					if($this->Item->get_custom_field($k,'required') && in_array($current_location,$this->Item->get_custom_field($k,'locations'))){
						$required = true;
						$required_text = 'required';
					}
					 
					 ?>
                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
                    <?php echo form_label($custom_field . ' :', "custom_field_${k}_value", array('class'=>"form-label $required_text")); ?>


                    <?php if ($this->Item->get_custom_field($k,'type') == 'checkbox') { ?>

                    <?php echo form_checkbox("custom_field_${k}_value", '1', (boolean)$item_info->{"custom_field_${k}_value"},"id='custom_field_${k}_value' $required_text");?>
                    <label for="<?php echo "custom_field_${k}_value"; ?>"><span></span></label>

                    <?php } elseif($this->Item->get_custom_field($k,'type') == 'date') { ?>

                    <?php echo form_input(array(
									'name'=>"custom_field_${k}_value",
									'id'=>"custom_field_${k}_value",
									'class'=>"custom_field_${k}_value".' form-control',
									'value'=>is_numeric($item_info->{"custom_field_${k}_value"}) ? date(get_date_format(), $item_info->{"custom_field_${k}_value"}) : '',
									($required ? $required_text : $required_text) => ($required ? $required_text : $required_text)
									)
									);?>
                    <script type="text/javascript">
                    var $field = <?php echo "\$('#custom_field_${k}_value')"; ?>;
                    $field.datetimepicker({
                        format: JS_DATE_FORMAT,
                        locale: LOCALE,
                        ignoreReadonly: IS_MOBILE ? true : false
                    });
                    </script>

                    <?php } elseif($this->Item->get_custom_field($k,'type') == 'dropdown') { ?>

                    <?php 
									$choices = explode('|',$this->Item->get_custom_field($k,'choices'));
									$select_options = array('' => lang('please_select'));
									foreach($choices as $choice)
									{
										$select_options[$choice] = $choice;
									}
									echo form_dropdown("custom_field_${k}_value", $select_options, $item_info->{"custom_field_${k}_value"}, 'class="form-control" '.$required_text);?>

                    <?php } elseif($this->Item->get_custom_field($k,'type') == 'image') {
								echo form_input(
									array(
										'name'=>"custom_field_${k}_value",
										'id'=>"custom_field_${k}_value",
										'type' => 'file',
										'class'=>"custom_field_${k}_value".' form-control',
										'accept'=>".png,.jpg,.jpeg,.gif"
									),
									NULL,
									$item_info->{"custom_field_${k}_value"} ? "" : $required_text
								);
							
								if ($item_info->{"custom_field_${k}_value"})
								{
									echo "<img width='30%' src='".cacheable_app_file_url($item_info->{"custom_field_${k}_value"})."' />";
									echo "<div class='delete-custom-image'><a href='".site_url('items/delete_custom_field_value/'.$item_info->item_id.'/'.$k)."'>".lang('delete')."</a></div>";
								}
							 }
							 elseif($this->Item->get_custom_field($k,'type') == 'file')
							 {
								echo form_input(
									array(
									  'name'=>"custom_field_${k}_value",
									  'id'=>"custom_field_${k}_value",
									  'type' => 'file',
									  'class'=>"custom_field_${k}_value".' form-control'
									),
								  NULL,
								  $item_info->{"custom_field_${k}_value"} ? "" : $required_text
							  );

								 if ($item_info->{"custom_field_${k}_value"})
								 {
								 	echo anchor('items/download/'.$item_info->{"custom_field_${k}_value"},$this->Appfile->get_file_info($item_info->{"custom_field_${k}_value"})->file_name,array('target' => '_blank'));
								 	echo "<div class='delete-custom-image'><a href='".site_url('items/delete_custom_field_value/'.$item_info->item_id.'/'.$k)."'>".lang('delete')."</a></div>";
								 }
							 		
							 }
							 else
							 {
									echo form_input(array(
									'name'=>"custom_field_${k}_value",
									'id'=>"custom_field_${k}_value",
									'class'=>"custom_field_${k}_value".' form-control',
									'value'=>$item_info->{"custom_field_${k}_value"},
									($required ? $required_text : $required_text) => ($required ? $required_text : $required_text)
									)
									);?>
                    <?php } ?>

                </div>
                <?php } //end if?>
                <?php } //end for loop?>

                </div>
            </div>
            <!--/card-body -->
        </div><!-- /panel-piluku -->


        <?php echo form_hidden('redirect', isset($redirect) ? $redirect : ''); ?>
        <?php echo form_hidden('progression', isset($progression) ? $progression : ''); ?>
        <?php echo form_hidden('quick_edit', isset($quick_edit) ? $quick_edit : ''); ?>

        <div class="form-actions">
            <?php
			if (isset($redirect) && $redirect == 'sales')
			{
				echo form_button(array(
			    'name' => 'cancel',
			    'id' => 'cancel',
				 	'class' => 'submit_button btn btn-lg btn-danger',
			    'value' => 'true',
			    'content' => lang('cancel')
				));
			}
			?>
            <?php
				echo form_submit(array(
					'name'=>'submitf',
					'id'=>'submitf',
					'value'=>lang('save'),
					'class'=>'submit_button floating-button btn btn-lg btn-danger')
				);
			?>
        </div>
    </div>
</div>
</div>


<script id="secondary-category-template" type="text/x-handlebars-template">

    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
		<?php echo form_label(lang('secondary_category').':', 'secondary_category_id_{{index}}',array('class'=>'form-label  wide')); ?>
		
			<?php echo form_dropdown('secondary_categories[{{index}}]', $categories,'', 'class="form-control form-inps" id="secondary_category_id_{{index}}"');?>
		
	</div>
</script>
<script id="secondary-supplier-template" type="text/x-handlebars-template">

    <div class="fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ">
		<?php echo form_label(lang('secondary_supplier').':', 'secondary_supplier_id_{{index}}',array('class'=>'form-label  wide')); ?>
		
			<?php echo form_dropdown('secondary_suppliers[{{index}}]', $suppliers,'', 'class="form-control form-inps" id="secondary_supplier_id_{{index}}"');?>
		
	</div>
</script>

<script type='text/javascript'>
<?php $this->load->view("partial/common_js"); ?>

function check_service_inputs() {
    var $reorder_inputs = $(".is-service-toggle");

    if ($('#is_service').prop('checked')) {
        $reorder_inputs.addClass('hidden');
    } else {
        $reorder_inputs.removeClass('hidden');
    }
}







$(document).ready(function() {
    $("#is_serialized").change(function() {
        if ($(this).prop('checked')) {
            $("#serial_numbers_list").removeClass('hidden');
        } else {
            $("#serial_numbers_list").addClass('hidden');
        }
    });






    $(".delete_addtional_item_number").click(function() {
        $(this).parent().parent().remove();
    });

    $("#add_addtional_item_number").click(function() {
        $("#additional_item_numbers tbody").append(
            '<tr><td><input type="text" class="form-control form-inps" size="40" name="additional_item_numbers[]" value="" /></td><td>&nbsp;</td></tr>'
        );
    });

    $('#supplier_id').selectize();
    $('#category_id').selectize({
        create: true,
        render: {
            item: function(item, escape) {
                var item = '<div class="item">' + escape($('<div>').html(item.text).text()) +
                    '</div>';
                return item;
            },
            option: function(item, escape) {
                var option = '<div class="option">' + escape($('<div>').html(item.text).text()) +
                    '</div>';
                return option;
            },
            option_create: function(data, escape) {
                var add_new = <?php echo json_encode(lang('new_category')) ?>;
                return '<div class="create">' + escape(add_new) + ' <strong>' + escape(data.input) +
                    '</strong></div>';
            }
        }
    });

    $("#cancel").click(cancelItemAddingFromSaleOrRecv);

    setTimeout(function() {
        $(":input:visible:first", "#item_form").focus();
    }, 100);

    $(document).on('change', '#is_service', check_service_inputs);

    $('#tags').selectize({
        delimiter: ',',
        loadThrottle: 215,
        persist: false,
        valueField: 'value',
        labelField: 'label',
        searchField: 'label',
        create: true,
        render: {
            option_create: function(data, escape) {
                var add_new = <?php echo json_encode(lang('add_new_tag')) ?>;
                return '<div class="create">' + escape(add_new) + ' <strong>' + escape(data.input) +
                    '</strong></div>';
            }
        },
        load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: '<?php echo site_url("items/tags");?>' + '?term=' + encodeURIComponent(
                    query),
                type: 'GET',
                error: function() {
                    callback();
                },
                success: function(res) {
                    res = $.parseJSON(res);
                    callback(res);
                }
            });
        }
    });

    $('#item_form').validate({
        ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
        submitHandler: function(form) {
            var args = {
                next: {
                    label: <?php echo json_encode(lang('edit').' '.lang('items_variations')) ?>,
                    url: <?php echo json_encode(site_url("items/variations/".($item_info->item_id ? $item_info->item_id : -1)."?$query")); ?>,
                }
            };

            $.post('<?php echo site_url("items/check_duplicate");?>', {
                term: $('#name').val()
            }, function(data) {
                <?php if(!$item_info->item_id) {  ?>
                if (data.duplicate) {
                    bootbox.confirm(
                        <?php echo json_encode(lang('items_duplicate_exists'));?>,
                        function(result) {
                            if (result) {
                                doItemSubmit(form, args);
                            }
                        });
                } else {
                    doItemSubmit(form, args);
                }
                <?php } else { ?>
                doItemSubmit(form, args);
                <?php } ?>
            }, "json");
        },
        errorClass: "text-danger",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ')
                .removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.fv-row w-100 flex-md-root fv-plugins-icon-container my-5 ')
                .removeClass('has-error').addClass('has-success');
        },
        rules: {
            <?php if(!$item_info->item_id) {  ?>
            item_number: {
                remote: {
                    url: "<?php echo site_url('items/item_number_exists');?>",
                    type: "post"
                }
            },
            product_id: {
                remote: {
                    url: "<?php echo site_url('items/product_id_exists');?>",
                    type: "post"
                }
            },
            <?php } ?>
            name: "required",
            category_id: "required",

            <?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { 
				$custom_field = $this->Item->get_custom_field($k);
				if($custom_field !== FALSE) {
					if( $this->Item->get_custom_field($k,'required') && in_array($current_location, $this->Item->get_custom_field($k,'locations'))){
						if(($this->Item->get_custom_field($k,'type') == 'file' || $this->Item->get_custom_field($k,'type') == 'image') && !$item_info->{"custom_field_${k}_value"}){
							echo "custom_field_${k}_value: 'required',\n";
						}
						
						if(($this->Item->get_custom_field($k,'type') != 'file' && $this->Item->get_custom_field($k,'type') != 'image')){
							echo "custom_field_${k}_value: 'required',\n";
						}
					}
				}
			}
			?>

            reorder_level: {
                number: true
            }
        },
        messages: {
            <?php if(!$item_info->item_id) {  ?>
            item_number: {
                remote: function() {
                    var link =
                        <?php echo json_encode('<a id="item_number_validation_link" target="_blank" href="#">'.lang('item_info').'</a>')?>;

                    $.post(<?php echo json_encode(site_url('items/find_item_info')); ?>, {
                        scan_item_number: $("#item_number").val()
                    }, function(response) {
                        $("#item_number_validation_link").attr('href', response.link);
                    }, 'json');
                    return <?php echo json_encode(lang('items_item_number_exists')); ?> + ' ' +
                        link;
                }

            },
            <?php for($k=1;$k<=NUMBER_OF_PEOPLE_CUSTOM_FIELDS;$k++) { 
					$custom_field = $this->Item->get_custom_field($k);
					if($custom_field !== FALSE) {
						if( $this->Item->get_custom_field($k,'required') && in_array($current_location, $this->Item->get_custom_field($k,'locations'))){
							if(($this->Item->get_custom_field($k,'type') == 'file' || $this->Item->get_custom_field($k,'type') == 'image') && !$item_info->{"custom_field_${k}_value"}){
								$error_message = json_encode($custom_field." ".lang('is_required'));
								echo "custom_field_${k}_value: $error_message,\n";
							}

							if(($this->Item->get_custom_field($k,'type') != 'file' && $this->Item->get_custom_field($k,'type') != 'image')){
								$error_message = json_encode($custom_field." ".lang('is_required'));
								echo "custom_field_${k}_value: $error_message,\n";
							}
						}
					}
				}
				?>
            product_id: {
                remote: function() {
                    var link =
                        <?php echo json_encode('<a id="product_id_validation_link" target="_blank" href="#">'.lang('item_info').'</a>')?>;

                    $.post(<?php echo json_encode(site_url('items/find_item_info')); ?>, {
                        scan_item_number: $("#product_id").val()
                    }, function(response) {
                        $("#product_id_validation_link").attr('href', response.link);
                    }, 'json');
                    return <?php echo json_encode(lang('items_product_id_exists')); ?> + ' ' + link;
                }
            },
            <?php } ?>

            <?php foreach($tiers as $tier) { ?> "<?php echo 'item_tier['.$tier->id.']'; ?>": {
                number: <?php echo json_encode(lang('this_field_must_be_a_number')); ?>
            },
            <?php } ?>

            <?php foreach($locations as $location) { ?> "<?php echo 'locations['.$location->location_id.'][quantity]'; ?>": {
                number: <?php echo json_encode(lang('this_field_must_be_a_number')); ?>
            },
            "<?php echo 'locations['.$location->location_id.'][reorder_level]'; ?>": {
                number: <?php echo json_encode(lang('this_field_must_be_a_number')); ?>
            },
            "<?php echo 'locations['.$location->location_id.'][cost_price]'; ?>": {
                number: <?php echo json_encode(lang('this_field_must_be_a_number')); ?>
            },
            "<?php echo 'locations['.$location->location_id.'][unit_price]'; ?>": {
                number: <?php echo json_encode(lang('this_field_must_be_a_number')); ?>
            },
            "<?php echo 'locations['.$location->location_id.'][promo_price]'; ?>": {
                number: <?php echo json_encode(lang('this_field_must_be_a_number')); ?>
            },
            <?php foreach($tiers as $tier) { ?> "<?php echo 'locations['.$location->location_id.'][item_tier]['.$tier->id.']'; ?>": {
                number: <?php echo json_encode(lang('this_field_must_be_a_number')); ?>
            },
            <?php } ?>
            <?php } ?>

            name: <?php echo json_encode(lang('item_name_required')); ?>,
            category_id: <?php echo json_encode(lang('category_required')); ?>,
            cost_price: {
                required: <?php echo json_encode(lang('items_cost_price_required')); ?>,
                number: <?php echo json_encode(lang('cost_price_number')); ?>
            },
            unit_price: {
                required: <?php echo json_encode(lang('items_unit_price_required')); ?>,
                number: <?php echo json_encode(lang('unit_price_number')); ?>
            },
            promo_price: {
                number: <?php echo json_encode(lang('this_field_must_be_a_number')); ?>
            }
        }
    });
});

function cancelItemAddingFromSaleOrRecv() {
    bootbox.confirm(<?php echo json_encode(lang('items_are_you_sure_cancel')); ?>, function(result) {
        if (result) {
            <?php if (isset($sale_or_receiving) && $sale_or_receiving == 'sale') {?>
            window.location = <?php echo json_encode(site_url('sales')); ?>;
            <?php } else { ?>
            window.location = <?php echo json_encode(site_url('receivings')); ?>;
            <?php } ?>
        }
    });
}

$("#verify_age").click(function() {
    if ($('#verify_age').prop('checked')) {
        $("#required_age_container").removeClass('hidden');
    } else {
        $("#required_age_container").addClass('hidden');
    }

});

$("#is_series_package").click(function() {
    if ($('#is_series_package').prop('checked')) {
        $("#series_package_options").removeClass('hidden');
    } else {
        $("#series_package_options").addClass('hidden');
    }

});


var secondary_category_index = -1;
var secondary_category_template = Handlebars.compile(document.getElementById("secondary-category-template").innerHTML);

$(document).on('click', "#add_secondary_category", function() {
    $("#add_secondary_category").parent().before(secondary_category_template({
        index: secondary_category_index
    }));
    secondary_category_index -= 1;
});

$(document).on('click', '.delete_secondary_category', function(e) {
    var index = $(this).data('index');
    $(this).parent().parent().remove();

    if (index > 0) {
        $("#item_form").append(
            '<input type="hidden" class="secondary_categories_to_delete" name="secondary_categories_to_delete[]" value="' +
            index + '" />');
    }
});

var secondary_supplier_index = -1;
var secondary_supplier_template = Handlebars.compile(document.getElementById("secondary-supplier-template").innerHTML);
$(document).on('click', "#add_secondary_supplier", function() {
    console.log($("#supplier_id").val());
    if ($("#supplier_id").val() == -1) {
        show_feedback('error',
            <?php echo json_encode(lang('item_first_level_supplier_is_required_to_add_secondary_supplier_message')); ?>,
            <?php echo json_encode(lang('error')); ?>);
        return false;
    }
    $("#add_secondary_supplier").parent().parent().before(secondary_supplier_template({
        index: secondary_supplier_index
    }));
    secondary_supplier_index -= 1;
});


$(document).on('click', '.delete_secondary_supplier', function(e) {
    var index = $(this).data('index');
    $(this).parent().parent().parent().remove();

    if (index > 0) {
        $("#item_form").append(
            '<input type="hidden" class="secondary_suppliers_to_delete" name="secondary_suppliers_to_delete[]" value="' +
            index + '" />');
    }
});



$(document).on('click', "#add_category", function() {
    $("#categoryModalDialogTitle").html(<?php echo json_encode(lang('add_category')); ?>);
    var parent_id = $("#category_id").val();

    $parent_id_select = $('#parent_id');
    $parent_id_select[0].selectize.setValue(parent_id, false);

    $("#categories_form").attr('action', SITE_URL + '/items/save_category');

    //Clear form
    $(":file").filestyle('clear');
    $("#categories_form").find('#category_name').val("");
    $("#categories_form").find('#category_color').val("");
    $('#category_color').colorpicker('setValue', '');
    $("#categories_form").find('#category_image').val("");
    $("#categories_form").find('#image-preview').attr('src', '');
    $('#del_image').prop('checked', false);
    $('#preview-section').hide();

    //show
    $("#category-input-data").modal('show');
});

$("#categories_form").submit(function(event) {
    event.preventDefault();

    $(this).ajaxSubmit({
        success: function(response, statusText, xhr, $form) {
            show_feedback(response.success ? 'success' : 'error', response.message, response
                .success ? <?php echo json_encode(lang('success')); ?> :
                <?php echo json_encode(lang('error')); ?>);
            if (response.success) {
                $("#category-input-data").modal('hide');

                var category_id_selectize = $("#category_id")[0].selectize
                category_id_selectize.clearOptions();
                category_id_selectize.addOption(response.categories);
                category_id_selectize.addItem(response.selected, true);
            }
        },
        dataType: 'json',
    });
});

<?php if ($this->session->flashdata('manage_success_message')) { ?>
show_feedback('success', <?php echo json_encode($this->session->flashdata('manage_success_message')); ?>,
    <?php echo json_encode(lang('success')); ?>);
<?php } ?>
</script>

<?php echo form_close(); ?>
</div>

<?php if($this->config->item('add_ck_editor_to_item')){?>
<script>
//used this ck editor online builder https://ckeditor.com/ckeditor-5/online-builder/
ClassicEditor.create(document.querySelector('#long_description'), {
        placeholder: '',
    })
    .then(editor => {
        // editor.ui.view.editable.element.style.height = '200px';
    })
    .catch(error => {
        console.error(error);
    });

ClassicEditor.create(document.querySelector('#description'), {
        placeholder: '',
    })
    .then(editor => {
        // editor.ui.view.editable.element.style.height = '200px';
    })
    .catch(error => {
        console.error(error);
    });
</script>
<?php } ?>

<script>
$(document).ready(function() {
    $(".serial_numbers_check").keyup(function() {
        var serialNumber = $(this).val();
        var id = $(this).data('id');
        var errorMessage = $(this).next(
            '.error_message'); // assuming the error message span is right after the input

        if (serialNumber.length >= 5) {
            $.ajax({
                url: '<?php echo base_url() ?>items/check_serial_number',
                type: 'POST',
                data: {
                    serial: serialNumber,
                    id: id
                },
                success: function(response) {
                    if (response == 'exists') {
                        errorMessage.text(
                            "<?php echo lang('Serial_Number_already_exists'); ?>!");
                    } else {
                        errorMessage.text("");
                    }
                },
                error: function() {
                    errorMessage.text("<?php echo lang('Error_while_checking'); ?>.");
                }
            });
        } else {
            errorMessage.text("");
        }
    });
});
</script>
<?php $this->load->view('partial/footer'); ?>