<?php $this->load->view("partial/header"); ?>

<div id="kt_app_content_container" class="app-container container-fluid">
									<!--begin::Navbar-->
									<div class="card mb-6">
									
									</div>
									<!--end::Navbar-->
									<!--begin::Toolbar-->
									<div class="d-flex flex-wrap flex-stack mb-6">
										<!--begin::Title-->
										<h3 class="fw-bold my-2">Plans</h3>
										
										
										<!--end::Title-->
										<!--begin::Controls-->
										<div class="d-flex align-items-center my-2">
											<!--begin::Select wrapper-->
											<div class="w-100px me-5">
												<!--begin::Select-->
												<!-- <select name="status" data-control="select2" data-hide-search="true" class="form-select form-select-sm form-select-solid">
													<option value="1" selected="selected">30 Days</option>
													<option value="2">90 Days</option>
													<option value="3">6 Months</option>
													<option value="4">1 Year</option>
												</select> -->
												<!--end::Select-->
											</div>
											<!--end::Select wrapper-->
                                            <button id="openModalBtn" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_new_card_form" style="margin-left: 946px;">Add</button>
										</div>
										<!--end::Controls-->
									</div>
									
									<!--end::Toolbar-->
									<!--begin::Row-->
									<div class="row g-6 g-xl-9" id="your_div_id">
										<!--begin::Col-->
										
										<!--end::Col-->
										<!--begin::Col-->
										
										<!--end::Col-->
										<!--begin::Col-->
										
										<!--end::Col-->
										<!--begin::Col-->
									
										<!--end::Col-->
										<!--begin::Col-->

										<?php if($plans){  ?>
											<?php foreach($plans as $plan){ ?>
										<div class="col-sm-6 col-xl-4">
											<!--begin::Card-->
											<div class="card h-100">
												<!--begin::Card header-->
												<div class="card-header flex-nowrap border-0 pt-9">
													<!--begin::Card title-->
													<div class="card-title m-0">
														<!--begin::Icon-->
														<!-- <div class="symbol symbol-45px w-45px bg-light me-5">
															<img src="assets/media/svg/brand-logos/github.svg" alt="image" class="p-3" />
														</div> -->
														<!--end::Icon-->
														<!--begin::Title-->
														<a href="#" class="fs-4 fw-semibold text-hover-primary text-gray-600 m-0"><?= $plan['name'] ?></a>
														<!--end::Title-->
													</div>
													<!--end::Card title-->
													<!--begin::Card toolbar-->
													<div class="card-toolbar m-0">
														<!--begin::Menu-->
														<input type="hidden" name="form_id" id="<?= $plan['id'] ?>" value="<?= $plan['id'] ?>" />

														<button class="btn btn-danger btn-sm delete-btn" data-form-id="<?= $plan['id'] ?>">Delete</button>

															<!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
															
															<!--end::Svg Icon-->
														</button>
														<!--begin::Menu 3-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
															<!--begin::Heading-->
															<div class="menu-item px-3">
																<div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
															</div>
															<!--end::Heading-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="#" class="menu-link px-3">Create Invoice</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="#" class="menu-link flex-stack px-3">Create Payment
																<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference"></i></a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="#" class="menu-link px-3">Generate Bill</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
																<a href="#" class="menu-link px-3">
																	<span class="menu-title">Subscription</span>
																	<span class="menu-arrow"></span>
																</a>
																<!--begin::Menu sub-->
																<div class="menu-sub menu-sub-dropdown w-175px py-4">
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																		<a href="#" class="menu-link px-3">Plans</a>
																	</div>
																	<!--end::Menu item-->
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																		<a href="#" class="menu-link px-3">Billing</a>
																	</div>
																	<!--end::Menu item-->
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																		<a href="#" class="menu-link px-3">Statements</a>
																	</div>
																	<!--end::Menu item-->
																	<!--begin::Menu separator-->
																	<div class="separator my-2"></div>
																	<!--end::Menu separator-->
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																		<div class="menu-content px-3">
																			<!--begin::Switch-->
																			<label class="form-check form-switch form-check-custom form-check-solid">
																				<!--begin::Input-->
																				<input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
																				<!--end::Input-->
																				<!--end::Label-->
																				<span class="form-check-label text-muted fs-6">Recuring</span>
																				<!--end::Label-->
																			</label>
																			<!--end::Switch-->
																		</div>
																	</div>
																	<!--end::Menu item-->
																</div>
																<!--end::Menu sub-->
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3 my-1">
																<a href="#" class="menu-link px-3">Settings</a>
															</div>
															<!--end::Menu item-->
														</div>
														<!--end::Menu 3-->
														<!--end::Menu-->
													</div>
													<!--end::Card toolbar-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body d-flex flex-column px-9 pt-6 pb-8">
													<!--begin::Heading-->
													<div class="fs-2tx fw-bold mb-3"><?= $plan['amount'] ?></div>
													<!--end::Heading-->
													<!--begin::Stats-->
													<!-- <div class="d-flex align-items-center flex-wrap mb-5 mt-auto fs-6">
													
														<div class="fw-bold text-danger me-2">+32.8%</div>
														
														<div class="fw-semibold text-gray-400">Less contributions</div>
													
													</div> -->
													<!--end::Stats-->
													<!--begin::Indicator-->
													<div class="d-flex align-items-center fw-semibold">
														<!-- <span class="badge bg-light text-gray-700 px-3 py-2 me-2"></span> -->
														<span class="text-gray-400 fs-7"><?= $plan['frequency'] ?></span>
														<i class="fas fa-exclamation-circle fs-7 ms-2" data-bs-toggle="tooltip" title="This is the total number of new non-trial"></i>
													</div>
													<input type="hidden" name="form_id" id="<?= $plan['id'] ?>" value="<?= $plan['id'] ?>" />

													<button id="edit_modal" class="btn btn-primary btn-sm" data-form-id="<?= $plan['id'] ?>" data-bs-toggle="modal" data-bs-target="#edit_plans" style="margin-left: 200px;" >Edit</button>

													<!--end::Indicator-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Card-->
										</div>
										<!--end::Col-->
										<?php }  ?>
										<?php }  ?>

										<!--begin::Col-->
									
										<!--end::Col-->
										<!--begin::Col-->
										
      
						<!--end::Form-->
					
					<!--end::Modal body-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
<!-- Bootstrap JavaScript -->


             <!--begin::Modal - New Card-->
			 <div class="modal fade" id="kt_modal_new_card" tabindex="-1" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-dialog-centered mw-650px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
						<!--begin::Modal title-->
						<h2>Add plans</h2>
						<!--end::Modal title-->
						<!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
							<span class="svg-icon svg-icon-1">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</div>
						<!--end::Close-->
					</div>
					<!--end::Modal header-->
					<!--begin::Modal body-->
					<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
						<!--begin::Form-->
						<form id="kt_modal_new_card_form" class="form" action="#">
							<!--begin::Input group-->
							<div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<span class="required">Name</span>
									<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Name"></i>
								</label>
								<!--end::Label-->
								<input type="text" name="name" id="name" class="form-control form-control-solid" placeholder="Name" name="Name"  />
							</div>

							<div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<span class="required">Amount</span>
									<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Amount"></i>
								</label>
								<!--end::Label-->
								<input type="text" name="amount" id="amount" class="form-control form-control-solid" placeholder="Amount" name="Amount"  />
							</div>

							<div class="d-flex flex-column mb-7 fv-row">
								<!--begin::Label-->
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<span class="required">Frequency</span>
									<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Frequency"></i>
								</label>
								<!--end::Label-->
								<input type="text" name="frequency" id="frequency" class="form-control form-control-solid" placeholder="Frequency" name="Frequency"  />
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							
							<!--end::Input group-->
							<!--begin::Input group-->
							
							<!--end::Input group-->
							<!--begin::Input group-->
							
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center pt-15">
								
								<button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary">
									<span class="indicator-label">Submit</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Modal body-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>


		<div class="modal fade" id="edit_plans" tabindex="-1" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-dialog-centered mw-650px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
						<!--begin::Modal title-->
						<h2>Edit plans</h2>
						<!--end::Modal title-->
						<!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
							<span class="svg-icon svg-icon-1">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</div>
						<!--end::Close-->
					</div>
					<!--end::Modal header-->
					<!--begin::Modal body-->
					<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
						<!--begin::Form-->
						<form id="edit_form" class="form" action="#">
          <!-- Input fields for editing form values -->
          <div class="form-group">
            <label for="modal_name">Name</label>
            <input type="text" class="form-control"  id="modal_name" name="name" placeholder="Name">
          </div>
          <div class="form-group">
            <label for="modal_amount">Amount</label>
            <input type="text" class="form-control" id="modal_amount" name="amount" placeholder="Amount">
          </div>
          <div class="form-group">
            <label for="modal_frequency">Frequency</label>
            <input type="text" class="form-control" id="modal_frequency" name="frequency" placeholder="Frequency">
          </div>
          <input type="hidden" name="form_id" id="form_id" value="">
          <!-- End input fields -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="modal_submit">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>


$('#openModalBtn').click(function() {
   $('#kt_modal_new_card').modal('show');
});

// $(document).ready(function() {
//   // Attach event listener to form submission
//   $('#kt_modal_new_card_form').submit(function(e) {
//     e.preventDefault(); // Prevent default form submission

//     // Serialize form data
//     var formData = $(this).serialize();

//     // Send AJAX request
//     $.ajax({
//       url: '<?php echo base_url('Plans/submitForm') ?>', // Replace with your controller URL
//       type: 'POST',
//       data: formData,
//       dataType: 'json',
//       beforeSend: function() {
//         // Show loading spinner or any other pre-submit actions
//         $('#kt_modal_new_card_submit').prop('disabled', true); // Disable submit button
//       },
//       success: function(response) {
//         // Handle the response from the server
//         if (response.success) {
//           // Close the modal
//           $('#kt_modal_new_card').modal('hide').on('hidden.bs.modal', function() {
//             Swal.fire({
//               icon: 'success',
//               title: 'Success',
//               text: 'Form submitted successfully!',
//             }).then(function() {
//               // Reset the form if needed
//               $('#kt_modal_new_card_form')[0].reset();
//               // Reload data in the specified div
//               $('#your_div_id').load('your_url'); // Replace 'your_div_id' and 'your_url' with the appropriate values
//             });
//           });
//         } else {
//           // Form submission failed
//           Swal.fire({
//             icon: 'error',
//             title: 'Error',
//             text: 'Form submission failed!',
//           });
//         }
//       },
//       error: function() {
//         // AJAX request error
//         Swal.fire({
//           icon: 'error',
//           title: 'Error',
//           text: 'An error occurred during form submission.',
//         });
//       },
//       complete: function() {
//         // Hide loading spinner or any other post-submit actions
//         $('#kt_modal_new_card_submit').prop('disabled', false); // Enable submit button
//       }
//     });
//   });
// });
$(document).ready(function() {
  // Attach event listener to form submission
  $('#kt_modal_new_card_form').submit(function(e) {
    e.preventDefault(); // Prevent default form submission

    // Serialize form data
    var formData = $(this).serialize();

    // Send AJAX request
    $.ajax({
      url: '<?php echo base_url('Plans/submitForm') ?>', // Replace with your controller URL
      type: 'POST',
      data: formData,
      dataType: 'json',
      beforeSend: function() {
        // Show loading spinner or any other pre-submit actions
        $('#kt_modal_new_card_submit').prop('disabled', true); // Disable submit button
      },
      success: function(response) {
        // Handle the response from the server
        if (response.success) {
          // Close the modal
          $('#kt_modal_new_card').modal('hide').on('hidden.bs.modal', function() {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Form submitted successfully!',
            }).then(function() {
              // Reset the form if needed
              $('#kt_modal_new_card_form')[0].reset();
              // Reload the page
              location.reload();
            });
          });
        } else {
          // Form submission failed
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Form submission failed!',
          });
        }
      },
      error: function() {
        // AJAX request error
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred during form submission.',
        });
      },
      complete: function() {
        // Hide loading spinner or any other post-submit actions
        $('#kt_modal_new_card_submit').prop('disabled', false); // Enable submit button
      }
    });
  });
});







$(document).ready(function() {
  // Attach event listener to form edit button click
  $('#edit_modal').click(function() {
    var formId = $(this).data('form-id'); // Get the form ID from the button's data attribute

    // Send AJAX request to get form data
    $.ajax({
      url: '<?php echo base_url('Plans/edit')?>', // Replace with your controller URL
      type: 'POST',
      data: {form_id: formId},
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          var data = response.data;
          $('#form_id').val(data.id);
          $('#modal_name').val(data.name);
          $('#modal_amount').val(data.amount);
          $('#modal_frequency').val(data.frequency);
          $('#edit_plans').modal('show');
        } else {
          alert('Error retrieving form data');
        }
      },
      error: function() {
        alert('An error occurred during form data retrieval.');
      }
    });
  });

  // Attach event listener to modal form submission
  $('#edit_form').submit(function(e) {
    e.preventDefault(); // Prevent default form submission

    // Serialize form data
    var formData = $(this).serialize();

  
  });
});



// Attach event listener to modal form submission
$('#edit_form').submit(function(e) {
  e.preventDefault(); // Prevent default form submission

  // Serialize form data
  var formData = $(this).serialize();

  // Send AJAX request
  $.ajax({
    url: '<?php echo base_url('Plans/update')?>', // Replace with your controller URL for updating data
    type: 'POST',
    data: formData,
    dataType: 'json',
    beforeSend: function() {
      // Show loading spinner or any other pre-submit actions
      $('#modal_submit').prop('disabled', true); // Disable submit button
    },
    success: function(response) {
      // Handle the response from the server
      if (response.success) {
        // Data update successful
        $('#edit_plans').modal('hide');
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Data updated successfully!',
        });
      } else {
        // Data update failed
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Data update failed!',
        });
      }
    },
    error: function() {
      // AJAX request error
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'An error occurred during data update.',
      });
    },
    complete: function() {
      // Hide loading spinner or any other post-submit actions
      $('#modal_submit').prop('disabled', false); // Enable submit button
    }
  });
});



$(document).ready(function() {
  // Attach event listener to delete button click
  $('.delete-btn').click(function() {
    var formId = $(this).data('form-id'); // Get the form ID from the button's data attribute

    // Send AJAX request to delete the record
    $.ajax({
      url: '<?php echo base_url('Plans/delete')?>', // Replace with your controller URL for deleting data
      type: 'POST',
      data: { form_id: formId },
      dataType: 'json',
      beforeSend: function() {
        // Show loading spinner or any other pre-delete actions
        $('.delete-btn').prop('disabled', true); // Disable delete button
      },
      success: function(response) {
        // Handle the response from the server
        if (response.success) {
          // Record deletion successful
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Record deleted successfully!',
          }).then(function() {
            // Optionally, you can reload the page or update the UI after deletion
            location.reload(); // Reload the page
          });
        } else {
          // Record deletion failed
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Record deletion failed!',
          });
        }
      },
      error: function() {
        // AJAX request error
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred during record deletion.',
        });
      },
      complete: function() {
        // Hide loading spinner or any other post-delete actions
        $('.delete-btn').prop('disabled', false); // Enable delete button
      }
    });
  });
});


</script>




<?php $this->load->view("partial/footer"); ?>