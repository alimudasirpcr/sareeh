<?php $this->load->view("partial/header"); ?>

<style>
	.required{
		color: black;
	}
</style>

<div id="kt_app_content_container" class="app-container container-fluid">
									
								<!--begin::Pricing-->
							<div class="text-center" id="kt_pricing">
								<!--begin::Nav group-->
								
								<!--end::Nav group-->
								<!--begin::Row-->
								<div class="row g-5 g-lg-10 ">
   			<?php
				$module_descriptions = [
					"appointments" => "Manage client appointment schedules.",
					"config" => "Tailor system configuration settings.",
					"customers" => "Manage and track customers.",
					"deliveries" => "Manage product delivery statuses.",
					"employees" => "Oversee employee details, roles.",
					"expenses" => "Record and analyze expenditures.",
					"giftcards" => "Manage promotional gift cards.",
					"invoices" => "Generate and track invoices.",
					"item_kits" => "Bundle products for offers.",
					"price_rules" => "Set dynamic product pricing.",
					"items" => "Manage inventory item details.",
					"locations" => "Manage business location specifics.",
					"messages" => "Internal team communication tool.",
					"receipt" => "Manage sales transaction receipts.",
					"receivings" => "Handle product supplier receipts.",
					"reports" => "Generate business performance reports.",
					"sales" => "Manage sales and interactions.",
					"suppliers" => "Manage supplier and sourcing.",
					"work_orders" => "Assign and manage tasks."
				];
 
 			?>
									<?php foreach($plans->packages as $plan): ?>
									<!--begin::Col-->
									<div class="col-md-4 col-xl-3">
										<div class="d-flex align-items-center">
											<!--begin::Option-->
											<div class="w-100 d-flex flex-column flex-center rounded-3 bg-gray-100 py-15 px-10">
												<!--begin::Heading-->
												<div class="mb-7 text-center">
													<!--begin::Title-->
													<h1 class="text-dark mb-5 fw-bolder"><?php echo $plan->name;  ?></h1>
													<!--end::Title-->
													<!--begin::Description-->
													<div class="text-gray-400 fw-semibold mb-5">Best Settings for <?php echo $plan->name;  ?></div>
													<!--end::Description-->
													<!--begin::Price-->
													<div class="text-center">
														<span class="mb-2 text-primary">$</span>
														<span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="<?php echo $plan->price;  ?>" data-kt-plan-price-annual="<?php echo $plan->price;  ?>"><?php echo $plan->price;  ?></span>
														<span class="fs-7 fw-semibold opacity-50" data-kt-plan-price-month="Mon" data-kt-plan-price-annual="Ann">/ Mon</span>
													</div>
													<!--end::Price-->
												</div>
												<!--end::Heading-->
												<!--begin::Features-->
												<div class="w-100 mb-10">


													<?php
													
													$modules = explode(',',  $plan->module_ids);
													
													foreach($module_descriptions as $key => $mod ): ?>
													<!--begin::Item-->
													<div class="d-flex flex-stack mb-5">
														<span class="fw-semibold fs-6 text-gray-600 text-start pe-3"><?php echo $mod; ?></span>
														<!--begin::Svg Icon | path: icons/duotune/general/gen043.svg-->
														<?php if(in_array($key,$modules)): ?>
														<span class="svg-icon svg-icon-2 svg-icon-primary">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
																<path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor" />
															</svg>
														</span>
														<?php else: ?>
														<span class="svg-icon svg-icon-2 svg-icon-secondary">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
																<rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"></rect>
																<rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"></rect>
															</svg>
														</span>
														<?php endif; ?>
														<!--end::Svg Icon-->
													</div>
													<!--end::Item-->
														<?php endforeach; ?>



												</div>
												<!--end::Features-->
												<!--begin::Select-->
											
												<?php
												if($plan->price > 0):
												
												if($plan->id==$_SESSION['package']): ?>
													<a href="<?php echo base_url() ?>plans" class="btn btn-primary btn-sm fw-bold rounded-1">Currently using</a>
												
													<?php else: ?>
												<a href="<?php echo base_url() ?>plans/select/<?php echo $plan->id; ?>" class="btn btn-primary btn-sm fw-bold rounded-1">Select</a>
														<?php endif; endif; ?>
												<!--end::Select-->
											</div>
											<!--end::Option-->
										</div>
									</div>
									<?php endforeach; ?>
									<!--end::Col-->
								</div>
								<!--end::Row-->
							</div>
							<!--end::Pricing-->	
									
									
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
					<div class="modal-header" style="justify-content: flex-start;">
						<!--begin::Modal title-->
						<h2>Add plans</h2>
						<!--end::Modal title-->
						<!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismis="modal">
							<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
							<button type="button" style="margin-left: 900px" class="btn-close" aria-label="Close"></button>
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
								
								<button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary pt-2">
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
					<div class="modal-header" style="justify-content: flex-start;">
						<!--begin::Modal title-->
						<h2>Edit plans</h2>
						<!--end::Modal title-->
						<!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
							<button type="button" style="margin-left: 900px" class="btn-close closemodaledit" aria-label="Close"></button>

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
            <input type="text" class="form-control form-control-solid"  id="modal_name" name="name" placeholder="Name">
          </div>
          <div class="form-group">
            <label for="modal_amount">Amount</label>
            <input type="text" class="form-control form-control-solid" id="modal_amount" name="amount" placeholder="Amount">
          </div>
          <div class="form-group">
            <label for="modal_frequency">Frequency</label>
            <input type="text" class="form-control form-control-solid" id="modal_frequency" name="frequency" placeholder="Frequency">
          </div>
          <input type="hidden" name="form_id" id="form_id" value="">
          <!-- End input fields -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary pt-2" id="modal_submit">Save changes</button>
            <button type="button" class="btn btn-secondary pt-2" data-dismiss="modal">Close</button>
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
  $('.edit-btn').click(function() {
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
        }).then(function() {
          // Reload the page
          location.reload();
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
        $('.delete-btn').prop('disabled', false); // Enable delete button
      }
    });
  });
});




$('.btn-close').click(function() {
   $('#kt_modal_new_card').modal('hide');
});
$('.closemodaledit').click(function() {
   $('#edit_plans').modal('hide');
});



</script>




<?php $this->load->view("partial/footer"); ?>