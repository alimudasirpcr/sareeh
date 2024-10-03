<?php $this->load->view("partial/header_standalone"); ?>
<?php $company_logo = ($company_logo = $this->Location->get_info_for_key('company_logo', 1)) ? $company_logo : $this->config->item('company_logo');

 ?>
<form action="" method="POST">
    <div class="container">
    <div class="row">
    <div class="col-12">
   

         
                <!--begin::Story-->
<div class="text-center mb-10 mb-md-0">  
    <!--begin::Illustration-->  
    <?php if ($company_logo) { ?>
    <img src="<?php echo secure_app_file_url($company_logo); ?>" class="mb-11 h-125px" alt="<?php echo lang('logo');?>"> 
    <!--end::Illustration-->
    <?php } ?>
   
    <!--end::Description-->               

<!--end::Story-->

 

             </div>

<h1 class="text-center position-relative z-index-1"><?php echo lang('customer_intake_form');?></h1>
            </div>

            </div>
       
        <div class="position-absolute top-0 end-0 overflow-hidden w-150px h-450px h-lg-auto w-lg-auto">
            <img src="<?= site_url(); ?>/assets/css_good/media/svg/layout/1.svg" class=" " alt="">

			<img src="<?= site_url(); ?>/assets/css_good/media/svg/illustrations/easy-2/1.svg" class="position-absolute top-50 end-0 translate-middle z-index-2 w-200px w-lg-auto d-none d-md-block" alt="">


        </div>

		<div class="position-absolute top-0 start-0 overflow-hidden w-150px h-450px h-lg-auto w-lg-auto">
            <img src="<?= site_url(); ?>/assets/css_good/media/svg/layout/3.svg" class=" " alt="">

			<img src="<?= site_url(); ?>/assets/css_good/media/illustrations/easy/8.svg" class="position-absolute top-50 start-25 translate-middle z-index-2 w-200px  d-none d-md-block" alt="">


        </div>

        <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
          
            <div class="col">
                <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2"> <?= lang('first_name'); ?> </label>
                    <!--end::Label-->

                    <div class="input-group" style="width:100%">
                        <div class="input-group-text" style="width: 8rem;
    height: 46px;
    border: 1px #bfc7d7 solid !important;
    background-color: #f6f8fc !important;
    padding: 11px;
    z-index: 3;">
                            <?php  
						$titles = array(
						
							"Mr." 		=> lang('mr.'),
							"Mrs." 		=> lang('mrs.'),
							"Dr." 		=> lang('dr.'),
							"Hon." 		=> lang('hon.'),
							"Prof." 	=> lang('prof.'),
							"Rev." 		=> lang('rev.'),
							"Rt.Hon." 	=> lang('rt_hon.'),
							"Sr." 		=> lang('sr.'),
							"Jr." 		=> lang('jr.'),
							"St." 		=> lang('st.'),

							);
						?>
                            <?php echo form_dropdown('title', $titles,'', 'class="form-control form-control-sm form-inps" id="title"  style="height: 90%;" ');?>
                        </div>
                        <?php echo form_input(array(
						'class'=>'form-control',
						'name'=>'first_name',
						'id'=>'first_name',
						'value'=>'')
					);?>
                    </div>
                </div>
            </div>


            <div class="col">
                <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2"><?= lang('last_name'); ?></label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <?php echo form_input(array(
							'class'=>'form-control',
							'name'=>'last_name',
							'id'=>'last_name',
							'value'=>'')
						);?>

                </div>
            </div>

            <div class="col">
                <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2"><?= lang('email'); ?></label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <?php echo form_input(array(
						'class'=>'form-control',
						'name'=>'email',
						'type'=>'text',
						'id'=>'email',
						'value'=>'')
						);?>

                </div>
            </div>


            <div class="col">
                <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2"><?= lang('phone_number'); ?></label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <?php echo form_input(array(
						'class'=>'form-control',
						'name'=>'phone_number',
						'id'=>'phone_number',
						'value'=>''));?>

                </div>
            </div>


            <div class="col">
                <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2"><?= lang('address_1'); ?></label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <?php echo form_input(array(
							'class'=>'form-control',
							'name'=>'address_1',
							'id'=>'address_1',
							'value'=>''));?>

                </div>
            </div>


            <div class="col">
                <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2"><?= lang('address_2'); ?></label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <?php echo form_input(array(
						'class'=>'form-control',
						'name'=>'address_2',
						'id'=>'address_2',
						'value'=>''));?>

                </div>
            </div>



            <div class="col">
                <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2"><?= lang('city'); ?></label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <?php echo form_input(array(
						'class'=>'form-control ',
						'name'=>'city',
						'id'=>'city',
						'value'=>''));?>

                </div>
            </div>

            <div class="col">
                <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2"><?= lang('state'); ?></label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <?php echo form_input(array(
							'class'=>'form-control ',
							'name'=>'state',
							'id'=>'state',
							'value'=>''));?>

                </div>
            </div>



            <div class="col">
                <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2"><?= lang('zip'); ?></label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <?php echo form_input(array(
							'class'=>'form-control ',
							'name'=>'zip',
							'id'=>'zip',
							'value'=>''));?>

                </div>
            </div>


            <div class="col">
                <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2"><?= lang('country'); ?></label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <?php echo form_input(array(
		'class'=>'form-control ',
		'name'=>'country',
		'id'=>'country',
		'value'=>''));?>

                </div>
            </div>

        </div>




        <div class="row">
            <div class="col-md-12">



                <div class="form-group pull-right">
                    <br />
                    <input type="submit" class="btn btn-primary">
                </div>
            </div>

        </div><!-- /col-md-12 -->
    </div><!-- /row -->
    </div>
</form>
<?php $this->load->view("partial/footer_standalone"); ?>