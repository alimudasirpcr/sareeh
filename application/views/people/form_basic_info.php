<div class="row">
    <div class="col-md-6">
        <div class="mb-7">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold mb-2">
                <span>Update Avatar</span>

                <?php $avatar = base_url().'assets/img/avatar.png'; 

                    if($person_info->image_id){
                        $avatar =  cacheable_app_file_url($person_info->image_id);
                    }
                    
                    
                    ?>

                <span class="ms-1" data-bs-toggle="tooltip" aria-label="Allowed file types: png, jpg, jpeg."
                    data-bs-original-title="Allowed file types: png, jpg, jpeg." data-kt-initialized="1">
                    <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                            class="path2"></span><span class="path3"></span></i> </span>
            </label>
            <!--end::Label-->

            <!--begin::Image input wrapper-->
            <div class="mt-1">
                <!--begin::Image input placeholder-->
                <style>
                .image-input-placeholder {
                    background-image: url('<?= $avatar ?>');
                }

                [data-bs-theme="dark"] .image-input-placeholder {
                    background-image: url('<?= $avatar ?>');
                }
                </style>
                <!--end::Image input placeholder-->

                <!--begin::Image input-->
                <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                    <!--begin::Preview existing avatar-->
                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?= $avatar ?>)">
                    </div>
                    <!--end::Preview existing avatar-->

                    <!--begin::Edit-->
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar"
                        data-bs-original-title="Change avatar" data-kt-initialized="1">
                        <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                        <!--begin::Inputs-->

                        <input type="file" name="image_id" id="image_id" class="form-control form-control-solid"
                            accept=".png,.jpg,.jpeg,.gif">
                        <input type="hidden" name="avatar_remove">
                        <!--end::Inputs-->
                    </label>
                    <!--end::Edit-->

                    <!--begin::Cancel-->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar"
                        data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                        <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                    </span>
                    <!--end::Cancel-->



                    <?php if($person_info->image_id) {  ?>
                    <div class="my-3">
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


                    <!--end::Remove-->
                </div>
                <!--end::Image input-->
            </div>
            <!--end::Image input wrapper-->
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-5">
            <div class="">
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

<?php

$full_name = $person_info->full_name;


$name_parts = explode(' ', $full_name);
$first_name = isset($name_parts[0]) ? $name_parts[0] : '';
$last_name = isset($name_parts[1]) ? $name_parts[1] : '';


echo form_input(array(
    'class' => 'form-control form-control-solid',
    'name' => 'first_name',
    'id' => 'first_name',
    'value' => $first_name
));
                    
                 
  
?>
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
				'value'=>$last_name)
			);?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-5">
            <div class="">
                <div class="mb-10">
                <div class="form-check">
    <label class="form-check-label" for="email"> 
   
        <?php echo lang('email'); ?>
    </label>

    <?php 
    echo form_input(array(
        'class' => 'form-control form-control-solid',
        'name'  => 'email',
        'id'    => 'email',
        'type'  => 'text',
        'value' => isset($person_info->email) ? $person_info->email : '' // Ensure it doesn't break if null
    ));
    ?>
</div>


                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-5">
            <div class="">


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
        <div class="mb-5">
            <div class=" ">
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
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-5">
            <div class=" ">

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
        <div class="mb-5">
            <div class=" ">
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
        <div class="mb-5">
            <div class=" ">
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
        <div class="">
            <div class=" ">
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
        <div class="mb-5">
            <div class=" ">
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
        <div class="mb-5">
            <div class=" ">
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