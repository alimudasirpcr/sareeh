<?php $this->load->view("partial/header"); ?>


<div class="d-flex flex-column flex-lg-row">
										<!--begin::Sidebar-->
										<div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
											<!--begin::Contacts-->
											<div class="card card-flush">
												<!--begin::Card header-->
												<div class="card-header pt-7" id="kt_chat_contacts_header">
													<!--begin::Form-->
													<form class="w-100 position-relative" autocomplete="off">
														<!--begin::Icon-->
														<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
														<span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
																<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--end::Icon-->
														<!--begin::Input-->
														<input id="search" type="text" class="form-control form-control-solid px-15" name="search" value="" placeholder=" <?= lang('Search_by_username_or_email');  ?>...">
														<!--end::Input-->
													</form>
													<!--end::Form-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-5" id="kt_chat_contacts_body">
													<!--begin::List-->
													<div  id="user_list" class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header" data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="5px" style="max-height: 229px;">
													
													</div>
													<!--end::List-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Contacts-->
										</div>
										<!--end::Sidebar-->
										<!--begin::Content-->
										<div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
											<!--begin::Messenger-->
											<div class="card" id="kt_chat_messenger">
												<!--begin::Card header-->
												<div class="card-header" id="kt_chat_messenger_header">
													<!--begin::Title-->
													<div class="card-title">
														<!--begin::User-->
														<div class="d-flex justify-content-center flex-column me-3">
															<a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1" id="main_name"></a>
															<!--begin::Info-->
															<div class="mb-0 lh-1" id="if_main_active" style="display: none;">
																<span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
																<span class="fs-7 fw-semibold text-muted">Active</span>
															</div>
															<div class="mb-0 lh-1" id="if_main_inactive">
																<span class="badge badge-secondary badge-circle w-10px h-10px me-1"></span>
																<span class="fs-7 fw-semibold text-muted"><?= lang('Inactive');  ?></span>
															</div>
															<!--end::Info-->
														</div>
														<!--end::User-->
													</div>
													<!--end::Title-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body" id="kt_chat_messenger_body">
													<!--begin::Messages-->
													<div id="chat_message_area" class="scroll-y me-n5 pe-5 h-500px " data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px" style="max-height: 87px;">
														<!--begin::Message(in)-->
														<div class="mb-2">
															<!--begin::Title-->
															<h1 class="fw-semibold text-gray-800 text-center lh-lg"><?php echo lang('click_on_user') ?>
															<br>
															<span class="fw-bolder"><?php echo lang('and_start') ?></span></h1>
															<!--end::Title-->
															<!--begin::Illustration-->
															<div class="py-10 text-center">
																<img src="<?php echo base_url() ?>assets/css_good/media/svg/illustrations/easy/4.svg" class="w-200px" alt="">
															</div>
															<!--end::Illustration-->
														</div>
													</div>
													<!--end::Messages-->
												</div>
												<!--end::Card body-->
												<!--begin::Card footer-->
												<div class="card-footer pt-4" id="kt_chat_messenger_footer" style="display: none">
													<!--begin::Input-->
													<textarea name="txt_message" id="messageText" class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="<?php echo lang('Type_a_message') ?>"></textarea>
													<!--end::Input-->
													<!--begin:Toolbar-->
													<div class="d-flex flex-stack">
														<!--begin::Actions-->
														<div class="d-flex align-items-center me-2 d-none">
															<button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" aria-label="Coming soon" data-kt-initialized="1">
																<i class="bi bi-paperclip fs-3"></i>
															</button>
															<button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" aria-label="Coming soon" data-kt-initialized="1">
																<i class="bi bi-upload fs-3"></i>
															</button>
														</div>
														<!--end::Actions-->
														<!--begin::Send-->
														<button id="send_message" class="btn btn-primary" type="button" data-kt-element="send"><?php echo lang('Send') ?></button>
														<!--end::Send-->
													</div>
													<!--end::Toolbar-->
												</div>
												<!--end::Card footer-->
											</div>
											<!--end::Messenger-->
										</div>
										<!--end::Content-->
									</div>
									<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/gsap.min.js"></script>
<?php 
	include('main.php');
?>



<?php $this->load->view("partial/footer"); ?>