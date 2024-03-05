<div class="row">
    <div class="col-md-6">
        <div class="py-5 mb-5">
            <div class="rounded border p-10">
                <div class="mb-10">
                    <div class="form-check">
                        <?php  
						$title_list = $this->Person->get_titles()->result_array();

						$titles = array( "0" => "" );

						foreach( $title_list as $index => $title ){
							if($index <= 11){
								$titles[$title['id']] =  lang($title['name']);
							}else{
								$titles[$title['id']] =  $title['name'];
							}
						}

						// $titles["-1"] = lang('add')."...";
						?>
                        <label class="form-check-label" for="flexCheckDefault"> <?php 
			$required = ($controller_name == "suppliers") ? "" : "required";
			echo form_label(lang('first_name'))?></label>

                        <?php echo form_input(array(
						'class'=>'form-control form-control-solid',
						'name'=>'first_name',
						'id'=>'first_name',
						'value'=>$person_info->first_name)
					);?>
                    </div>
                    <?php if($this->config->item('enable_name_prefix')){?>
                    <div style="margin-top:5px;">
                        <a href="javascript:void(0);" style="text-transform: lowercase;"
                            id="add_title"><?php echo lang('add').' '.lang('title'); ?></a>
                    </div>
                    <?php } ?>
                </div>
                <div class="mb-0">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckChecked">
                            <?php echo form_label(lang('last_name'))?></label>
                        <?php echo form_input(array(
				'class'=>'form-control form-control-solid',
				'name'=>'last_name',
				'id'=>'last_name',
				'value'=>$person_info->last_name)
			);?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="py-5 mb-5">
            <div class="rounded border p-10">
                <div class="mb-10">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckDefault"> <?php 
			
			echo form_label(lang('email'))?></label>

                        <?php echo form_input(array(
				'class'=>'form-control form-control-solid',
				'name'=>'email',
				'type'=>'text',
				'id'=>'email',
				'value'=>$person_info->email)
				);?>
                    </div>

                </div>
                <div class="mb-0">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckChecked">
                            <?php echo form_label(lang('phone_number'))?></label>
                        <?php echo form_input(array(
				'class'=>'form-control form-control-solid',
				'name'=>'phone_number',
				'id'=>'phone_number',
				'value'=>format_phone_number($person_info->phone_number)));?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="py-5 mb-5">
            <div class="rounded border p-10">
                <div class="mb-10">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckDefault"> <?php 
			
			echo form_label(lang('choose_avatar'))?></label>

                        <input type="file" name="image_id" id="image_id" class="form-control form-control-solid"
                            accept=".png,.jpg,.jpeg,.gif">
                        <?php echo $person_info->image_id ? '<div class="symbol symbol-100px mt-4" id="avatar">'.img(array('style' => '','src' => cacheable_app_file_url($person_info->image_id),'class'=>'img-polaroid img-polaroid-s')).'</div>' : '<div id="avatar">'.img(array('style' => 'width: 20%;padding-top: 9px;','src' => base_url().'assets/img/avatar.png','class'=>'img-polaroid','id'=>'image_empty')).'</div>'; ?>

                    </div>

                </div>
                <?php if($person_info->image_id) {  ?>
                <div class="mb-0">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckChecked">
                            <?php echo form_label(lang('del_image'))?></label>
                        <?php echo form_checkbox(array(
			'name'=>'del_image',
			'id'=>'del_image ',
			'class'=>'delete-checkbox form-check-input', 
			'value'=>1
		));
		echo '<label for="del_image"><span></span></label> ';
		
		?>
                    </div>
                </div>
                <?php }  ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="py-5 mb-5">
            <div class="rounded border p-10">
                <div class="mb-10">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckDefault"> <?php 
			
			echo form_label(lang('address_1'))?></label>

                        <?php echo form_input(array(
		'class'=>'form-control form-control-solid',
		'name'=>'address_1',
		'id'=>'address_1',
		'value'=>$person_info->address_1));?>
                    </div>

                </div>
                <div class="mb-0">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckDefault"> <?php 
			
			echo form_label(lang('address_2'))?></label>
                        <?php echo form_input(array(
		'class'=>'form-control form-control-solid',
		'name'=>'address_2',
		'id'=>'address_2',
		'value'=>$person_info->address_2));?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="py-5 mb-5">
            <div class="rounded border p-10">
                <div class="mb-10">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckDefault"> <?php 
			
			echo form_label(lang('city'))?></label>

                        <?php echo form_input(array(
		'class'=>'form-control form-control-solid ',
		'name'=>'city',
		'id'=>'city',
		'value'=>$person_info->city));?>
                    </div>

                </div>
                <div class="mb-0">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckDefault"> <?php 
			
			echo form_label(lang('state'))?></label>
                        <?php echo form_input(array(
		'class'=>'form-control form-control-solid',
		'name'=>'state',
		'id'=>'state',
		'value'=>$person_info->state));?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="py-5 mb-5">
            <div class="rounded border p-10">
                <div class="mb-10">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckDefault"> <?php 
			
			echo form_label(lang('zip'))?></label>

                        <?php echo form_input(array(
		'class'=>'form-control form-control-solid',
		'name'=>'zip',
		'id'=>'zip',
		'value'=>$person_info->zip));?>
                    </div>

                </div>
                <div class="mb-0">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckDefault"> <?php 
			
			echo form_label(lang('country'))?></label>
                        <?php echo form_input(array(
		'class'=>'form-control form-control-solid',
		'name'=>'country',
		'id'=>'country',
		'value'=>$person_info->country));?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="py-5 mb-5">
            <div class="rounded border p-10">
                <div class="mb-10">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('comments'))?></label>

                        <?php echo form_textarea(array(
					'name'=>'comments',
					'id'=>'comments',
					'class'=>'form-control form-control-solid text-area',
					'value'=>$person_info->comments,
					'rows'=>'5',
					'cols'=>'17')		
				);?>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php
if ($this->Location->get_info_for_key('mailchimp_api_key') && $controller_name != "login")
{
	$this->load->helper('mailchimp');
	
	$default_mailchimp_lists = array();
		
	if ($this->Location->get_info_for_key('default_mailchimp_lists'))
	{
		$default_mailchimp_lists =	unserialize($this->Location->get_info_for_key('default_mailchimp_lists'));
	}
	
	if (!$default_mailchimp_lists)
	{
		$default_mailchimp_lists = array();								
	}
	
?>
<div class="row">
    <div class="col-md-6">
        <div class="py-5 mb-5">
            <div class="rounded border p-10">
                <div class="mb-10">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('mailing_lists'))?></label>

<?php
	foreach(get_all_mailchimps_lists() as $list)
	{
		echo '<li>';
		echo form_checkbox(array('name'=> 'mailing_lists[]',
		'id' => $list['id'],
		'value' => $list['id'],
		'checked' => $person_info->id ? email_subscribed_to_list($person_info->email, $list['id']) : in_array($list['id'],$default_mailchimp_lists),
		'label'	=> $list['id']));
		
		echo '<label for="'.$list['id'].'"><span></span></label> '.$list['name'];
		echo '</li>';
	}
	?>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php
}
?>

<?php
if ($this->Location->get_info_for_key('platformly_api_key') && $controller_name != "login")
{
	$this->load->helper('platformly');
?>
<div class="row">
    <div class="col-md-6">
        <div class="py-5 mb-5">
            <div class="rounded border p-10">
                <div class="mb-10">
                    <div class="form-check">

                        <label class="form-check-label" for="flexCheckDefault"> <?php 
						
						echo form_label(lang('segments'))?></label>

<?php
    
	foreach(get_all_platformly_segments() as $segment)
	{
		echo '<li>';
		echo form_checkbox(array('name'=> 'segments[]',
		'id' => $segment['id'],
		'value' => $segment['id'],
		'checked' => email_subscribed_to_segment($person_info->email, $segment['id']),
		'label'	=> $segment['id']));
		
		echo '<label for="'.$segment['id'].'"><span></span></label> '.$segment['name'];
		echo '</li>';
	}
	?>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php
}
?>
