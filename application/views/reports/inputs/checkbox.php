<div class="row">
	<div class="col-md-2">
</div>
<div class="col-md-6">

    <div class="mb-8">
        <div class="form-check" data-keyword="<?php echo H(lang('config_keyword_payment')) ?>">
            <?php echo form_checkbox(array(
			'name'=>$checkbox_name,
			'id'=>$checkbox_name,
			'value'=>'1',
			'class' => 'form-check-input',
			'checked' => $this->input->get($checkbox_name),
			));?>
            <label class="form-check-label"
                for="flexCheckDefault"><?php echo form_label($checkbox_label.':', $checkbox_name ) ?></label>
        </div>
    </div>
    </div>

</div>