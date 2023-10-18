<?php $this->load->view("partial/header"); ?>
<div class="row">

                                            
	<?php
		foreach($this->Register->get_all()->result() as $register) 
		{ 
	?>
    <div class="col-md-6 mb-10">
        <div class="bg-light bg-opacity-50 rounded-3 p-10 mx-md-5 h-md-100">
            <div class="d-flex flex-center w-60px h-60px rounded-3 bg-light-info bg-opacity-90 mb-10">
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                <span class="svg-icon svg-icon-info svg-icon-3x">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor"></path>
                        <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor"></path>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
            <h1 class="mb-5"><?php echo $register->name ?></h1>
            <div class="fs-4 text-gray-600 py-3">Build whatever you want without a single line of CSS/SASS code by just using our low-level utility classes and base components.</div>
            <a href="<?php echo site_url('sales/choose_register').'/'.$register->register_id ?>" class="btn btn-lg btn-flex btn-link btn-color-info"><?php echo lang('choose') ?>
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
            <span class="svg-icon ms-2 svg-icon-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                    <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                </svg>
            </span>
            <!--end::Svg Icon--></a>
        </div>
    </div>
		
	<?php } ?>	
</div>
<?php $this->load->view('partial/footer.php'); ?>