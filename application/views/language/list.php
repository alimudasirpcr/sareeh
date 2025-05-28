
<?php $this->load->view("partial/header"); ?>
<div class="card">
										<!--begin::Card header-->
										<div class="card-header border-0 pt-6">
											<!--begin::Card title-->
											<div class="card-title">
												<!--begin::Search-->
												<div class="d-flex align-items-center position-relative my-1">
													<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
													<span class="svg-icon svg-icon-1 position-absolute ms-6">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
															<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
														</svg>
													</span>
													<!--end::Svg Icon-->
													<input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search user">
												</div>
												<!--end::Search-->
											</div>
											<!--begin::Card title-->
										</div>
										<!--end::Card header-->
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
												<div class="table-responsive">
												<table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="newtable">
												<!--begin::Table head-->
												<thead>
													<!--begin::Table row-->
													<tr class="text-start text-muted fw-bold fs-7 gs-0">
                                                        
                                                    <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending" > <?= lang('Language') ?></th>
                                                   
                                                    <th class="text-end min-w-100px sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 50px;"><?= lang('Actions') ?></th></tr>
													<!--end::Table row-->
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
												<tbody class="text-gray-600 fw-semibold">
													
													<!--end::Table row-->
												<tr class="odd">
														<!--begin::Checkbox-->
														<?php foreach($langs as $lang): ?>
                                                        
														<!--end::Checkbox-->
														<!--begin::User=-->
														<td class="d-flex align-items-center">
                                                        
															<!--begin::User details-->
															<div class="d-flex flex-column">
                                                                <?php echo $lang; ?>
															</div>
															<!--begin::User details-->
														</td>
														<!--end::User=-->
														<!--begin::Role=-->
														
                                                        
														<!--begin::Action=-->
														<td class="text-end">
															<a href="<?php echo base_url(); ?>language/lang_update/<?php echo $lang; ?>" class="btn btn-light btn-active-light-primary btn-sm"><?= lang('Edit') ?>
															</a>
														</td>
														<!--end::Action=-->
													</tr>
                                                    <?php endforeach; ?>
                                                    
                                                </tbody>
												<!--end::Table body-->
											</table>
										</div>
										
										
										<!--end::Card body-->
									</div>
									<script>
$('#newtable').DataTable({
    "searching": true, // This should be set to true for the search field to appear
});
										
									</script>
                                    <?php $this->load->view("partial/footer"); ?>

									