<?php $this->load->view("partial/header"); ?>

<style>
	.required{
		color: black;
	}
</style>

<div id="kt_app_content_container" class="app-container container-fluid">
									<!--begin::Navbar-->
									<div class="card mb-6">
									
									</div>
									<!--end::Navbar-->
									<!--begin::Toolbar-->
									<div class="d-flex flex-wrap flex-stack mb-6">
										<!--begin::Title-->
										<h3 class="fw-bold my-2">Receipts</h3>
										
										
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
                                            <button id="openModalBtn" class="btn btn-primary btn-sm " data-bs-toggle="modal" data-bs-target="#kt_modal_new_card_form" style="margin-left: 946px;">Add</button>
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

										<?php if($receipts){  ?>
											<?php foreach($receipts as $plan){ ?>
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
														<span class="fs-4 fw-semibold text-hover-primary text-gray-600 m-0"><?= $plan['title'] ?></span>
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
														
														<!--end::Menu-->
													</div>
													<!--end::Card toolbar-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body d-flex flex-column px-9 pt-6 pb-8">
													<!--begin::Heading-->
												
													<!--end::Heading-->
													<!--begin::Stats-->
													<!-- <div class="d-flex align-items-center flex-wrap mb-5 mt-auto fs-6">
													
														<div class="fw-bold text-danger me-2">+32.8%</div>
														
														<div class="fw-semibold text-gray-400">Less contributions</div>
													
													</div> -->
													<!--end::Stats-->
													
													<input type="hidden" name="form_id" id="<?= $plan['id'] ?>" value="<?= $plan['id'] ?>" />

													<a href="<?php echo base_url(); ?>Receipt/customize_receipt/<?php echo $plan['id'];   ?>" class="btn btn-primary btn-sm edit-btn"  data-bs-target="#edit_receipts" style="margin-left: 200px;" >Customize</a>

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
					<div class="modal-header" style="justify-content: flex-start;">
						<!--begin::Modal title-->
						<h2>Add receipt</h2>
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
									<span class="required">Title</span>
									<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Title"></i>
								</label>
								<!--end::Label-->
								<input type="text" name="title" id="name" class="form-control form-control-solid" placeholder="Title"   />
							</div>

						
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


		<div class="modal fade" id="edit_receipts" tabindex="-1" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-dialog-centered mw-650px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header" style="justify-content: flex-start;">
						<!--begin::Modal title-->
						<h2>Edit receipts</h2>
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

$(document).ready(function() {
  // Attach event listener to form submission
  $('#kt_modal_new_card_form').submit(function(e) {
    e.preventDefault(); // Prevent default form submission

    // Serialize form data
    var formData = $(this).serialize();

    // Send AJAX request
    $.ajax({
      url: '<?php echo base_url('Receipt/submitForm') ?>', // Replace with your controller URL
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
  // Attach event listener to delete button click
  $('.delete-btn').click(function() {
    var formId = $(this).data('form-id'); // Get the form ID from the button's data attribute

    // Send AJAX request to delete the record
    $.ajax({
      url: '<?php echo base_url('Receipt/delete')?>', // Replace with your controller URL for deleting data
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
   $('#edit_receipts').modal('hide');
});



</script>




<?php $this->load->view("partial/footer"); ?>