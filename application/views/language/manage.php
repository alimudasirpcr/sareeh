<?php $this->load->view("partial/header"); ?>

<div class="card card-flush h-lg-100" id="kt_contacts_main">
												<!--begin::Card header-->
												<div class="card-header pt-7" id="kt_chat_contacts_header">
													<!--begin::Card title-->
													<div class="card-title">
														<!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
														<span class="svg-icon svg-icon-1 me-2">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"></path>
																<path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<h2>Update Language</h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-5">
													<!--begin::Form-->
													<form id="kt_ecommerce_settings_general_form" method="post" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="<?php echo base_url();?>language/update_arabic_lang">
														
														<!--begin::Row-->
														<div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
															<!--begin::Col-->
                                                            <input type="hidden" name="hidden_code_lanauge" value="<?php echo $code; ?>" > 

                                                             <?php 
																$i=0;
                                                             foreach ($langdata as $key => $value) { ?>
															<div class="col">
																<!--begin::Input group-->
																<div class="fv-row mb-7 fv-plugins-icon-container">
																	<!--begin::Label-->
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class=""> <?php echo $i; ?>) <?php echo str_replace('_', ' ', $key); ?></span>
																		
																	</label>
																	<!--end::Label-->
																	<!--begin::Input--> 
																	<input type="text" class="form-control form-control-solid" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
																	<!--end::Input-->
																<div class="fv-plugins-message-container invalid-feedback"></div></div>
																<!--end::Input group-->
															</div>
															<!--end::Col-->
                                                            <?php 
															
															$i++; 
														
														} ?>


														</div>
														<!--end::Input group-->
														<!--begin::Separator-->
														<div class="separator mb-6"></div>
														<!--end::Separator-->
														<!--begin::Action buttons-->
														<div class="d-flex justify-content-end">
															<!--begin::Button-->
															<a href="<?php echo base_url() ?>/language"  class="btn btn-light me-3">Back</a>
															<!--end::Button-->
															<!--begin::Button-->
															<button type="submit" data-kt-contacts-type="submit" class="btn btn-primary">
																<span class="indicator-label"><?php echo lang('save'); ?></span>
																<span class="indicator-progress">Please wait...
																<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
															</button>
															<!--end::Button-->
														</div>
														<!--end::Action buttons-->
													<div></div></form>
													<!--end::Form-->
												</div>
												<!--end::Card body-->
											</div>
<?php $this->load->view("partial/footer"); ?>