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
										<h3 class="fw-bold my-2">Payments</h3>
										
										
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
                                          
										</div>
										<!--end::Controls-->
									</div>
									
									<!--end::Toolbar-->
									<!--begin::Row-->
									<div class="row g-6 g-xl-9" id="your_div_id">
									<div class="box box-info">
									<?php
		if($this->session->flashdata('error')) {
			?>
			<div class="alert alert-danger">
				<p><?php echo $this->session->flashdata('error'); ?></p>
			</div>
			<?php
		}


		if($this->session->flashdata('success')) {
			?>
			<div class="alert alert-success">
				<p><?php echo $this->session->flashdata('success'); ?></p>
			</div>
			<?php
		}
		?>
		<?php
if($invoices) {
	foreach($invoices as $inv):
			?>
			<div class="alert alert-danger">
				<p>Please click pay you have pending payment invoices due date <?php echo $inv->duedate; ?> <a href="<?php echo base_url()."payments/pay_thawani/".$inv->id; ?>" >Pay Now</a> </p>
			</div>
			<?php

	endforeach;
		} 
		
		?>
        <div class="box-body table-responsive" >
          <table id="sortable_table" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
			<thead>
			    <tr>
			        <th >Id</th>
			        <!-- <th>Session ID</th> -->
			        <th >Amount</th>
					<th >Payment Status</th>
					<th>Currency</th>
					<th>Mode</th>
					<th>Created At</th>
			    </tr>
			</thead>
            <tbody>
			<?php if($payments): 

			
					foreach($payments as $payment):
				?>
					
			<tr>
				
			        <td ><?php echo $payment['id'] ?></td>
			        <!-- <td><?php //echo $payment['session_id'] ?></td> -->
			        <td ><?php echo $payment['total_amount'] ?></td>
					<td ><?php  if($payment['payment_status']!=null){ 
						if($payment['payment_status']=='paid'){
							?> <span class="badge badge-success">Paid</span> <?php
						}else if($payment['payment_status']=='unpaid'){
							?> <span class="badge badge-info">Unpaid</span> <?php
						}else{
							?> <span class="badge badge-danger">cancelled</span> <?php
						}
					
					}else{
					?> <a class="btn btn-info" href="<?php echo get_thawani_pay_url($payment['session_id']); ?>">Pay</a> <?php 
					} ?></td>
					<td><?php echo $payment['currency'] ?></td>
					<td><?php echo $payment['mode'] ?></td>
					<td><?php echo date('d M Y' , strtotime($payment['created_at']))  ?></td>
			    </tr>
				<?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
									</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
<!-- Bootstrap JavaScript -->


         

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
 $(document).ready(function() {
  var table = $('#sortable_table').DataTable({
	"processing": true,
    "searching": true,
	"paging": true,      // Enable Pagination
    "info": true,        // Show the record count
	"dom": 'lfrtip',
	"order": [[0,'desc']],  
  })
 });
</script>




<?php $this->load->view("partial/footer"); ?>