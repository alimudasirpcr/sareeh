<?php $this->load->view("partial/header"); ?>

<style>
.required {
    color: black;
}
</style>

<div id="kt_app_content_container" class="app-container container-fluid ">
  <div class="card p-3">

<?php 
$CI = &get_instance();
// $packages = isset($packages) ? $packages : $CI->perfex_saas_model->packages();
$currency = 'OMR';
$is_client = 1;
$showing_subscribed_card = isset($list_active_only) && $list_active_only;
$single_pricing_mode = 0;
// $modules = $CI->perfex_saas_model->modules();

// Prevent user from trial when have a cancelled subscription
// $_can_trial = $is_client ? perfex_saas_client_can_trial_package(get_client_user_id()) : true;
$_can_trial = true;

$enable_grouping = 1;

// Group and sort the data by interval alias
$grouped_packages = $enable_grouping ? perfex_saas_group_pricing_by_interval_alias($packages) : ['0' => $packages];

$package_groups = array_keys($grouped_packages);

$filter_groups = array_values(array_filter($package_groups, function ($group) {
    return !str_starts_with($group, 'private_');
}));

$total_groups = count($filter_groups);

if ($enable_grouping && $total_groups < 2)
    $enable_grouping = false;

// Ensure unique instalce of this component
$filter_wrapper_class = 'list_' . rand(10000, 999999);
?>

<div class="<?= $filter_wrapper_class; ?>" style="<?= $enable_grouping ? 'display:none;' : ''; ?> ">

    <?php if ($enable_grouping) require(__DIR__ . '/pricing-filter.php'); ?>

    <div
        class="<?= $showing_subscribed_card || $single_pricing_mode ? '' : 'tw-grid tw-gap-3 ' ; ?> row gap-3 mt-3">
        <?php foreach ($grouped_packages as $package_group => $_packages) : ?>

        <?php
            foreach ($_packages as $package) :

                $subscribed = !empty($invoice->{perfex_saas_column('packageid')}) && $invoice->{perfex_saas_column('packageid')} == $package->id;
                if ($subscribed)
                    echo "<template data-package-default-group='$package_group'></template>";

                if ($showing_subscribed_card && !$subscribed) continue;
                if ($is_client && $package->is_private && !$subscribed) continue;

                if ($is_client && $single_pricing_mode) {
                    if ($package->is_default != '1') continue;
                    else $package->name = '';
                }

                require(__DIR__ . '/pricing-card-item.php');

            endforeach;
            ?>
        <?php endforeach ?>
    </div>

</div>






    <!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
<!-- Bootstrap JavaScript -->
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
                $('#kt_modal_new_card_submit').prop('disabled',
                true); // Disable submit button
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
                $('#kt_modal_new_card_submit').prop('disabled',
                false); // Enable submit button
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
            data: {
                form_id: formId
            },
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
            data: {
                form_id: formId
            },
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