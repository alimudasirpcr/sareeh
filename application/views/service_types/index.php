<?php $this->load->view("partial/header"); ?>
<script src="<?php echo base_url(); ?>assets/css_good/plugins/global/plugins.bundle.js"></script>
<div class="row manage-table  card p-5">
    <div class="card ">
        <div class="card-header d-flex justify-content-between">
        <h3 class="panel-title">
					Service Types						
						
						<div class="panel-options custom">
								<div class="pagination pagination-top hidden-print  text-center" id="pagination_top">
											
								</div>
						</div>
					</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" id="openModalBtn" data-bs-target="#kt_modal_1">Add Service Type</button>
        </div>
        <div class="card-body nopadding table_holder table-responsive mt-5">
            <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer " id="sortable_table">
                <thead>
                        <tr class="text-start text-muted fw-bold fs-7 gs-0">
                            <th>NO</th>
                            <th>Name</th>
                            <th>status</th>
                            <th>action</th>

                        </tr>
                </thead>
                <tbody>
                    <?php
                        if($rec){
                            foreach($rec as $r):
                                ?>  <tr>
                                        <td><?php echo $r->id ?></td>
                                        <td><?php echo $r->title; ?></td>
                                        <td><?php echo $r->status; ?></td>
                                        <td>
                                            <button class="btn btn-primary" onclick="get_edit(<?php echo $r->id ?>)" >Edit</button>
                                            <button class="btn btn-danger" onclick="delete_item(<?php echo $r->id ?>)" >Delete</button>
                                    </td>
                                    </tr>
                             <?php    
                            endforeach;
                        }
                    
                    ?>

                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="myModaladd">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="kt_docs_formvalidation_add" class="form" action="#" autocomplete="off">
            <div class="modal-header d-flex justify-align-content-space-between ">
                <h3 class="modal-title">Service Type</h3>

                <!--begin::Close-->
               
                <button type="button" class="close btn btn-icon btn-sm btn-active-light-primary ms-2" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="mb-10 fv-row">
                    <label for="exampleFormControlInput1" class="required form-label">Title</label>
                    <input type="text" name="title" class="form-control form-control-solid" id="title" placeholder="Title"/>
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid fv-row">
                    <input class="form-check-input" name="status" type="checkbox" value="1" id="flexSwitchDefault"/>
                    <label class="form-check-label" for="flexSwitchDefault">
                        Status
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button id="kt_docs_formvalidation_add_submit" type="submit" class="btn btn-primary" >Save</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="myModaledit">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="kt_docs_formvalidation_edit" class="form" action="#" autocomplete="off">
            <div class="modal-header d-flex justify-align-content-space-between ">
                <h3 class="modal-title">Edit Service Type</h3>

                <!--begin::Close-->
               
                <button type="button" class="close btn btn-icon btn-sm btn-active-light-primary ms-2" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="mb-10 fv-row">
                    <label for="exampleFormControlInput1" class="required form-label">Title</label>
                    <input type="text" name="title_edit" class="form-control form-control-solid" id="title_edit" placeholder="Title"/>
                    <input type="hidden" name="edit_id" id="edit_id">
                </div>
                <div class="form-check form-switch form-check-custom form-check-solid fv-row">
                    <input class="form-check-input" name="status_edit" type="checkbox" value="1" id="flexSwitchDefaultedit"/>
                    <label class="form-check-label" for="flexSwitchDefault">
                        Status
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button id="kt_docs_formvalidation_edit_submit" type="submit" class="btn btn-primary" >Save</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('openModalBtn').addEventListener('click', function() {
  // Select the modal element by its ID
  var modal = document.getElementById('myModaladd');

  // Use Bootstrap's modal function to show the modal
  $(modal).modal('show');
});


function delete_item(id){

    Swal.fire({
  title: 'Are you sure?',
  text: "Do you want to delete?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, do it!',
  cancelButtonText: 'Cancel'
}).then((result) => {
  if (result.isConfirmed) {
    // Perform your action here
    

    // Optionally, you can show another Swal to indicate success
    $.ajax({
        type: "post",
        url: "<?PHP echo base_url(); ?>Service_types/delete_item",
        data: {id:id},
        success: function (response) {
            Swal.fire({
                            text: "Successfully delete!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reload the page when the user clicks on "Yes, do it!"
                                location.reload();
                            }
                            });
        }
    });
  }
});


 
}
function get_edit(id){
    $.ajax({
        type: "post",
        url: "<?PHP echo base_url(); ?>Service_types/get_service_types",
        data: {id:id},
        success: function (response) {
            response = JSON.parse(response);
            if(response.status){
                var modal = document.getElementById('myModaledit');
                $('#title_edit').val(response.data.title);
                $('#edit_id').val(response.data.id);
                if(response.data.status=='1'){
                    $("#flexSwitchDefaultedit").prop("checked", true);
                }else{
                    $("#flexSwitchDefaultedit").prop("checked", false);
                }
                
                $(modal).modal('show');
            }else{
                Swal.fire({
                            text: "Did not find any data!",
                            icon: "error", // success , error , warning , info ,  question
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
            }
        }
    });
}

// Define form element
const form = document.getElementById('kt_docs_formvalidation_add');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            'title': {
                validators: {
                    notEmpty: {
                        message: 'Title is required'
                    }
                }
            },
        },

        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.fv-row',
                eleInvalidClass: '',
                eleValidClass: ''
            })
        }
    }
);

// Submit button handler
const submitButton = document.getElementById('kt_docs_formvalidation_add_submit');
submitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (validator) {
        validator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                submitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                submitButton.disabled = true;

                $.ajax({
                    type: "POST",
                    url: "<?PHP echo base_url(); ?>Service_types/save_service_types",
                    data: {'title': $('#title').val() , 'status' : ($('#flexSwitchDefault').is(':checked'))?1:0},
                    success: function (response) {
                        submitButton.removeAttribute('data-kt-indicator');
                        var modal = document.getElementById('myModaladd');

// Use Bootstrap's modal function to show the modal
                        $(modal).modal('hide');
                        // Enable button
                        submitButton.disabled = false;

                        // Show popup confirmation
                        Swal.fire({
                            text: "Form has been successfully submitted!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reload the page when the user clicks on "Yes, do it!"
                                location.reload();
                            }
                            });
                    }
                });

                
            }
        });
    }
});





// Define form element
const form_edit = document.getElementById('kt_docs_formvalidation_edit');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator_edit = FormValidation.formValidation(
    form_edit,
    {
        fields: {
            'title_edit': {
                validators: {
                    notEmpty: {
                        message: 'Title is required'
                    }
                }
            },
        },

        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.fv-row',
                eleInvalidClass: '',
                eleValidClass: ''
            })
        }
    }
);

// Submit button handler
const submitButtonedit = document.getElementById('kt_docs_formvalidation_edit_submit');
submitButtonedit.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (validator_edit) {
        validator_edit.validate().then(function (status) {
            console.log('validated update!');

            if (status == 'Valid') {
                // Show loading indication
                submitButtonedit.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                submitButtonedit.disabled = true;

                $.ajax({
                    type: "POST",
                    url: "<?PHP echo base_url(); ?>Service_types/update_service_types",
                    data: {
                        'id' :   $('#edit_id').val() ,
                        'title': $('#title_edit').val() , 
                        'status' : ($('#flexSwitchDefaultedit').is(':checked'))?1:0
                    },
                    success: function (response) {
                        submitButtonedit.removeAttribute('data-kt-indicator');
                        var modal = document.getElementById('myModaledit');

// Use Bootstrap's modal function to show the modal
                        $(modal).modal('hide');
                        // Enable button
                        submitButtonedit.disabled = false;

                        // Show popup confirmation
                        Swal.fire({
                            text: "Form has been successfully submitted!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reload the page when the user clicks on "Yes, do it!"
                                location.reload();
                            }
                            });
                    }
                });

                
            }
        });
    }
});
</script>
<?php $this->load->view("partial/footer"); ?>