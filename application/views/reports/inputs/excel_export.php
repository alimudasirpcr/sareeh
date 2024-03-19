<style>

.form-group .form-check-inputs {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}


.form-group .form-check-inputs + label::before {
    content: "";
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 1px solid #ccc;
	background-color: #f6f1e9;
    border-radius: 3px;
    margin-right: 5px;
    vertical-align: middle;
}


.form-group .form-check-inputs:checked + label::before {
    background-color: #4FC9DA;
}


.form-group .form-check-inputs + label input[type="checkbox"] {
    display: none;
}

</style>
<div class="form-group">
	<?php echo form_label(lang('reports_export_to_excel').':', '', array('class'=>'col-sm-3 col-md-3 col-lg-2 form-label  ')); ?> 
	<div class="col-sm-9 col-md-9 col-lg-10 form-check form-check-custom form-check-solid">
		<input type="radio" name="export_excel" class="form-check-input" id="export_excel_yes" value='1' <?php echo $this->input->get('export_excel') == '1' ? 'checked="checked"' : '';?>>
		<label for="export_excel_yes" class="form-check-label text-wrap"><span> <?php echo lang('yes'); ?> </span></label>
		<input type="radio" name="export_excel"  class="form-check-input"  id="export_excel_no" value='0' <?php echo !$this->input->get('export_excel') ? 'checked="checked"' : '';?> /> 
		<label for="export_excel_no" class="form-check-label text-wrap"><span><?php echo lang('no'); ?> </span></label>
	</div>

    
</div>

