<!DOCTYPE html>
<html>
<head>
    <title><?php 
		$this->load->helper('demo');
		echo !is_on_demo_host() ?  $this->config->item('company').' -- '.lang('common_powered_by').' '.$this->config->item('branding')['name'] : 'Demo - '.$this->config->item('branding')['name'].' | Easy to use Online POS Software' ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <base href="<?php echo base_url();?>" />
    <link rel="icon" href="<?php echo base_url();?>favicon_<?php echo $this->config->item('branding_code');?>.ico" type="image/x-icon"/>
 	
		<?php 
		$this->load->helper('assets');
		foreach(get_css_files() as $css_file) { ?>
 			<link rel="stylesheet" type="text/css" href="<?php echo base_url().$css_file['path'].'?'.ASSET_TIMESTAMP;?>" />
 		<?php } ?>

    <script src="<?php echo base_url();?>assets/js/jquery.js?<?php echo ASSET_TIMESTAMP; ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <style type="text/css">
        body
        {
            padding: 5px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function()
        {
            //If we have an empty username focus
            if ($("#username").val() == '')
            {
                $("#username").focus();                   
            }
            else
            {
                $("#password").focus();
            }
				
				$(".checkForUpdate").click(function(event)
				{
					event.preventDefault();
					$('#spin').removeClass('hidden');
		
					$.getJSON($(this).attr('href'), function(update_available) 
					{
						$('#spin').addClass('hidden');
						if(update_available)
						{
							$(".checkForUpdate").parent().html(<?php echo json_encode(lang('common_update_available').' <a href="http://'.$this->config->item('branding')['domain'].'/downloads.php" target="_blank">'.lang('common_download_now').'</a>');?>);
						}
						else
						{
							$(".checkForUpdate").parent().html(<?php echo json_encode(lang('common_not_update_available')); ?>);
						}
					});
		
				});
		});
		
		
    </script>
<?php
$this->load->helper('demo');
if (is_on_demo_host()) { ?>		
	<script src="//<?php echo $this->config->item('branding')['domain']; ?>/js/iframeResizer.contentWindow.min.js"></script>
<?php } ?>		
</head>
<body data-kt-name="good" id="kt_body" class="auth-bg app-blank">

<?php
		if(isset($announcement))
		{
		?>
     <div class="text-center">
				<?php echo $announcement; ?>
			</div>
		<?php
		}
		?>
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Aside-->
				<div class="d-flex flex-column flex-lg-row-auto bg-primary w-xl-600px positon-xl-relative">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px ">
						<!--begin::Header-->
						<div class="d-flex flex-row-fluid flex-center flex-column text-center p-5 p-lg-20">
							<!--begin::Logo-->
							<a href="../dist/index.html" class="py-9 pt-lg-20">
								<img alt="Logo" src="<?php echo $this->Appconfig->get_logo_image() ?>" class="h-35px h-lg-40px" />
							</a>
							<!--end::Logo-->
							<!--begin::Title-->
                            <?php if ($ie_browser_warning) { ?>
		                 <div class="holder">
                        <div class="alert alert-danger">
                           <strong><?php echo lang('login_unsupported_browser');?></strong>
                        </div>
								<br />
								<br />
							</div>
                    <?php
                    } ?>
							<h1 class="d-none d-lg-block fw-bold text-white fs-2qx pb-5 pb-md-10">Welcome to Sareeh</h1>
							<!--end::Title-->
							<!--begin::Description-->
							<p class="d-none d-lg-block fw-semibold fs-2 text-white"><?php 
									echo lang('login_welcome_message'); 
									
									?></p>
							<!--end::Description-->
						</div>
						<!--end::Header-->
						<!--begin::Illustration-->
						<div class="d-none d-lg-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-200px min-h-lg-350px mb-20" style="background-image: url(<?php echo base_url() ?>/assets/css_good/media/illustrations/sketchy-1/2.png)"></div>
						<!--end::Illustration-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--begin::Aside-->
				<!--begin::Body-->
				<div class="d-flex flex-column flex-lg-row-fluid py-10">
					<!--begin::Content-->
					<div class="d-flex flex-center flex-column flex-column-fluid">
						<!--begin::Wrapper-->
						<div class="w-lg-500px p-10 p-lg-15 mx-auto">
							<!--begin::Form-->
								<!--begin::Heading-->
								<div class="text-center mb-10">
									<!--begin::Title-->
									<h1 class="text-dark mb-3">Sign In to Sareeh</h1>
									<!--end::Title-->
									<!--begin::Link-->
									<div class="text-gray-400 fw-semibold fs-4">New Here?
									<a href="../dist/authentication/sign-up/basic.html" class="link-primary fw-bold">Create an Account</a></div>
									<!--end::Link-->
								</div>
								<?php
									if(($this->config->item('sso_protocol') == 'saml' && $this->config->item('saml_single_sign_on_service')) || ($this->config->item('sso_protocol') == 'oidc' && $this->config->item('oidc_host')))
									{
									?>							
		                        		<button onclick="window.location='<?php echo site_url($this->config->item('sso_protocol') == 'saml' ? 'login/samlassertionconsumerservice?sso' : 'login/oidc') ?>'"type="button" class="btn btn-primary btn-block"><?php echo lang('common_sso_login'); ?></button>
									<?php } ?>
							
									<?php
							       if (is_on_demo_host()) 
									 {
							           echo '<h2 class="text-center">'.lang('login_press_login_to_continue').'</h2>';
									 }
									?>
								</p>
								
						<?php
						if (!$this->config->item('only_allow_sso_logins'))
						{
						?>
					
	                    <?php echo form_open('login?continue='.rawurlencode($this->input->get('continue') ? $this->input->get('continue') : ''), array('class' => 'form login-form', 'id'=>'loginform', 'autocomplete'=> 'off')) ?>            
						
                        <?php if (validation_errors()) {?>
                        <div class="alert alert-danger">
                            <strong><?php echo lang('common_error'); ?></strong>
                            <?php echo validation_errors(); ?>
                        </div>
                        <?php } ?>
						
                        <?php echo form_input(array(
                            'name'=>'username', 
                            'id'=>'username', 
                            'value'=> $username,
                            'class'=> 'form-control mb-10',
                            'placeholder'=> lang('login_username'),
                            'size'=>'20')); 
                        ?>

                        <?php echo form_password(array(
                            'name'=>'password', 
                            'id' => 'password',
                            'value'=>$password,
                            'class'=>'form-control mb-10',
                            'placeholder'=> lang('login_password'),
                            'size'=>'20')); 
                        ?>
                
                        <div class="bottom_info mb-10">
							
							
                            <a href="<?php echo site_url('login/reset_password') ?>" class="pull-right flip-link to-recover"><?php echo lang('login_reset_password').'?'; ?></a>
                            
                            <?php 
									 $this->load->helper('update');
									 if (!is_on_saas_host()) {?>
                                <span><?php echo anchor('login/is_update_available', lang('common_check_for_update'), array('class' => 'checkForUpdate pull-left')); ?></span>&nbsp;
                                <span id="spin" class="hidden">
                                    <i class="ion ion-load-d ion-spin"></i>
                                </span>
                            <?php } ?>
                        </div>      
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-primary btn-block mb-10"><?php echo lang('login_login'); ?></button>
                    <?php echo form_close() ?>  
					<?php } ?>
                    <div class="version">
                        <p>
                            <span class="badge bg-success"><?php echo APPLICATION_VERSION; ?></span> <?php echo lang('common_built_on'). ' '.BUILT_ON_DATE;?>
                        </p>
							
                        <?php if (isset($trial_on) && $trial_on === true && !isset($trial_over)) { ?>
                           <div class="alert alert-success">
                            <?php echo lang('login_trail_info'). ' '.date(get_date_format(), strtotime($cloud_customer_info['trial_end_date'])).'. '.lang('login_trial_info_2'); ?>
                            </div>
                            <a class="btn btn-block btn-success" href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username'];?>" target="_blank"><?php echo lang('common_update_billing_info');?></a>
                        <?php } ?>
						
							
                        <?php if (isset($subscription_payment_failed) && $subscription_payment_failed === true) { ?>
                           <div class="alert alert-danger">
                                <?php echo lang('login_payment_failed_text'); ?>
                            </div>
                            <a class="btn btn-block btn-success" href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username'];?>" target="_blank"><?php echo lang('common_update_billing_info');?></a>
                        <?php } ?>
								
                        <?php if (isset($subscription_cancelled_within_5_days) && $subscription_cancelled_within_5_days === true) { ?>
                            <div class="alert alert-danger">
                                <?php echo lang('login_resign_text'); ?>
                            </div>
                        
                            <ul class="list-inline">
                            <li>
                                <a class="btn btn-block btn-sm btn-success" href="https://<?php echo $this->config->item('branding')['domain']; ?>/update_billing.php?store_username=<?php echo $cloud_customer_info['username'];?>" target="_blank"><?php echo lang('login_resignup');?></a>
                            </li>
						</ul>

                        <?php } ?>
								
							<!--end::Form-->
						</div>
						<!--end::Wrapper-->
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					<div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
						<!--begin::Links-->
						<div class="d-flex flex-center fw-semibold fs-6">
							<a href="https://keenthemes.com" class="text-muted text-hover-primary px-2" target="_blank">About</a>
							<a href="https://devs.keenthemes.com" class="text-muted text-hover-primary px-2" target="_blank">Support</a>
							<a href="https://themes.getbootstrap.com/product/good-bootstrap-5-admin-dashboard-template" class="text-muted text-hover-primary px-2" target="_blank">Purchase</a>
						</div>
						<!--end::Links-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used by this page)-->
		<script src="assets/js/custom/authentication/sign-in/general.js"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	
	
	
    
 

<?php if ($this->input->get('demologin')) { ?>
<script>	
	$("#loginform").submit();
</script>
	<?php } ?>
</html>