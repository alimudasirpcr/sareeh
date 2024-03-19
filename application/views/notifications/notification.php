<?php $this->load->view("partial/header"); ?>
<div class="card">
    <!--begin::Card head-->
    <div class="card-header card-header-stretch">
        <!--begin::Title-->
        <div class="card-title d-flex align-items-center">
            <i class="ki-duotone ki-calendar-8 fs-1 text-primary me-3 lh-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>

            <h3 class="fw-bold m-0 text-gray-800"><?= lang('notification_center') ?></h3>
        </div>
        <!--end::Title-->

        <!--begin::Toolbar-->
        <?php   if (count($notifications) > 0) : ?>
            <div class="card-toolbar m-0">
                <button id="mark_read" type="button" class="btn btn-danger h-50px mt-4 me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_offer_a_deal"><?= lang('mark_as_read'); ?></button>
                <button class="btn btn-primary h-50px mt-4 me-3" id="checkAll"><?= lang('Check_All') ?></button>
                <button class="btn btn-primary h-50px mt-4 me-3" id="messagecheckAll"><?= lang('Message_Check_All') ?></button>
                <button class="btn btn-primary h-50px mt-4" id="transfercheckAll"><?= lang('Transfer_Check_All') ?></button>
            </div>
            <?php endif; ?>
        <!--end::Toolbar-->
    </div>
    <!--end::Card head-->
    
    <!--begin::Card body-->
    <div class="card-body">
        <form id="notification_Form">
        <!--begin::Tab Content-->
       
            <!--begin::Tab panel-->
            <div id="kt_activity_today" class="card-body p-0 tab-pane fade active show" role="tabpanel" aria-labelledby="kt_activity_today_tab">
                <!--begin::Timeline-->
                <div class="timeline timeline-border-dashed">

                    <?php
                    $userImages = []; // Array to store user images


                    if (count($notifications) > 0) :
                        foreach ($notifications as $notification) :
                    ?>
                            <!--begin::Timeline item-->
                            <div class="timeline-item">
                                <!--begin::Timeline line-->
                                <div class="timeline-line"></div>
                                <!--end::Timeline line-->

                                <!--begin::Timeline icon-->
                                <div class="timeline-icon">

                                <?php  if (!isset($notification['module_id'])):  ?>
                                    <span class="svg-icon svg-icon-warning svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="currentColor" />
                                            <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <?php else : ?>
                                    <span class="svg-icon svg-icon-3 svg-icon-success"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.39961 20.5073C7.29961 20.5073 6.39961 19.6073 6.39961 18.5073C6.39961 17.4073 7.29961 16.5073 8.39961 16.5073H9.89961C11.7996 16.5073 13.3996 14.9073 13.3996 13.0073C13.3996 11.1073 11.7996 9.50732 9.89961 9.50732H8.09961L6.59961 11.2073C6.49961 11.3073 6.29961 11.4073 6.09961 11.5073C6.19961 11.5073 6.19961 11.5073 6.29961 11.5073H9.79961C10.5996 11.5073 11.2996 12.2073 11.2996 13.0073C11.2996 13.8073 10.5996 14.5073 9.79961 14.5073H8.39961C6.19961 14.5073 4.39961 16.3073 4.39961 18.5073C4.39961 20.7073 6.19961 22.5073 8.39961 22.5073H15.3996V20.5073H8.39961Z" fill="currentColor" />
                                            <path opacity="0.3" d="M8.89961 8.7073L6.69961 11.2073C6.29961 11.6073 5.59961 11.6073 5.19961 11.2073L2.99961 8.7073C2.19961 7.8073 1.7996 6.50732 2.0996 5.10732C2.3996 3.60732 3.5996 2.40732 5.0996 2.10732C7.6996 1.50732 9.99961 3.50734 9.99961 6.00734C9.89961 7.00734 9.49961 8.0073 8.89961 8.7073Z" fill="currentColor" />
                                            <path d="M5.89961 7.50732C6.72804 7.50732 7.39961 6.83575 7.39961 6.00732C7.39961 5.1789 6.72804 4.50732 5.89961 4.50732C5.07119 4.50732 4.39961 5.1789 4.39961 6.00732C4.39961 6.83575 5.07119 7.50732 5.89961 7.50732Z" fill="currentColor" />
                                            <path opacity="0.3" d="M17.3996 22.5073H15.3996V13.5073C15.3996 12.9073 15.7996 12.5073 16.3996 12.5073C16.9996 12.5073 17.3996 12.9073 17.3996 13.5073V22.5073Z" fill="currentColor" />
                                            <path d="M21.3996 18.5073H15.3996V13.5073H21.3996C22.1996 13.5073 22.5996 14.4073 22.0996 15.0073L21.2996 16.0073L22.0996 17.0073C22.6996 17.6073 22.1996 18.5073 21.3996 18.5073Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <?php endif; ?>

                                </div>
                                <!--end::Timeline icon-->

                                <!--begin::Timeline content-->
                                <div class="timeline-content mb-10 mt-n1">
                                    <!--begin::Timeline heading-->
                                    <div class="pe-3 mb-5">
                                        <!--begin::Title-->
                                        <div class="fs-5 fw-semibold mb-2"> <?php
                                                                            if (!isset($notification['module_id'])) :  echo lang('message') ?> : <?php else : ?>
                                                <?= lang('transfer') ?>:
                                            <?php endif; ?> <?= $notification['message'] ?> </div>
                                        <!--end::Title-->

                                        <!--begin::Description-->
                                        <div class="d-flex align-items-center mt-1 fs-6">
                                            <!--begin::Info-->
                                            <div class="text-muted me-2 fs-7"><?= lang('sent_at') ?> <?= date('d M Y h:i A', strtotime($notification['created_at'])); ?> by </div>
                                            <!--end::Info-->
                                            <?php
                                            if (!isset($notification['module_id'])) :

                                                if (!array_key_exists($notification['sender_id'], $userImages)) {
                                                    $person_info = $this->Employee->get_info($notification['sender_id']);
                                                    $profile_image = $person_info->image_id ? cacheable_app_file_url($person_info->image_id) : base_url('assets/assets/images/avatar-default.jpg');
                                                    $userImages[$notification['sender_id']] = $profile_image;
                                                } else {
                                                    $profile_image = $userImages[$notification['sender_id']];
                                                }
                                                // dd( $profile_image);
                                            ?>
                                                <!--begin::User-->
                                                <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="<?= $person_info->full_name ?>" aria-label="Nina Nilson" data-bs-original-title="Nina Nilson" data-kt-initialized="1">
                                                    <img src="<?= $profile_image ?>" alt="img">
                                                </div>
                                            <?php else : ?>
                                                <?= lang('location') ?>
                                            <?php endif; ?>

                                           
                                            <!--end::User-->
                                        </div>
                                        <?php
                                                 if (!isset($notification['module_id'])) :  ?> 
                                                 <div class="form-check pull-right">
                                                        <input class="form-check-input myCheckbox messages"  type="checkbox" value="<?= $notification['id'] ?>" name="message[]"  id="message_<?= $notification['id'] ?>" />
                                                </div> 
                                                 
                                                 <?php else : ?>
                                                    <div class="form-check pull-right">
                                                        <input class="form-check-input myCheckbox transfers" type="checkbox" value="<?= $notification['id']?> " name="transfer[]" id="transfer_<?= $notification['id'] ?>" />
                                                </div> 
                                            <?php endif; ?>


                                        
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Timeline heading-->
                                </div>
                                <!--end::Timeline content-->
                            </div>
                            <!--end::Timeline item-->
                        <?php
                        endforeach;

                    else : ?>
                        <?= lang('no_notifications_found') ?>
                    <?php endif; ?>


                </div>
                <!--end::Timeline-->
            </div>
            <!--end::Tab panel-->

            <!--begin::Tab panel-->

            <!--end::Tab panel-->

            <!--begin::Tab panel-->

            <!--end::Tab panel-->

            <!--begin::Tab panel-->

            <!--end::Tab panel-->
        </form>
    </div>
    <!--end::Card body-->
</div>
<script>
    $('#mark_read').click(function() {
        $('#notification_Form').submit();
    });
    $("#notification_Form").submit(function(e) {
    e.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize(); // Serialize form data
    $("#overlay").fadeIn();
    $.ajax({
        url: "<?= site_url('notifications/update') ?>", // Your form processing file URL
        type: "POST",
        data: formData,
        success: function(response) {
            $('.myCheckbox:checked').each(function() {
                $(this).parent('div').parent('div').parent('div').parent('div').remove();
            });
            $("#overlay").fadeOut();

            // Handle success (response from server)
            console.log(response);
        },
        error: function(xhr, status, error) {
            $("#overlay").fadeOut();
            // Handle error
            console.error(error);
        }
    });
});
$(document).ready(function() {
    function updateButtonText() {
        toggleMarkReadButton();
        if ($('.myCheckbox:checked').length == $('.myCheckbox').length) {
            $('#checkAll').text('Uncheck All');
        } else {
            $('#checkAll').text('Check All');
        }
    }
    function updateButtonTextmessage() {
        toggleMarkReadButton();
        if ($('.messages:checked').length == $('.messages').length) {
            $('#messagecheckAll').text('Message Uncheck All');
        } else {
            $('#messagecheckAll').text('Message Check All');
        }
        updateButtonText();
    }
    function updateButtonTexttransfer() {
        toggleMarkReadButton();
        if ($('.transfers:checked').length == $('.transfers').length) {
            $('#transfercheckAll').text('Transfer Uncheck All');
        } else {
            $('#transfercheckAll').text('Transfer Check All');
        }
        updateButtonText();
    }

    $('#checkAll').click(function() {
        let allChecked = $('.myCheckbox:checked').length == $('.myCheckbox').length;
        $('.myCheckbox').prop('checked', !allChecked);
        updateButtonText();
        updateButtonTextmessage();
        updateButtonTexttransfer();
    });
    $('#messagecheckAll').click(function() {
        let allChecked = $('.messages:checked').length == $('.messages').length;
        $('.messages').prop('checked', !allChecked);
        updateButtonTextmessage();
    });
    $('#transfercheckAll').click(function() {
        let allChecked = $('.transfers:checked').length == $('.transfers').length;
        $('.transfers').prop('checked', !allChecked);
        updateButtonTexttransfer();
    });

    // Update button text when any checkbox is manually clicked
    $('.myCheckbox').click(function() {
        updateButtonText();
    });

    function toggleMarkReadButton() {
        if ($('.myCheckbox:checked').length > 0) {
            $('#mark_read').show();
        } else {
            $('#mark_read').hide();
        }
    }

    toggleMarkReadButton();

    // Check every time a checkbox is clicked
    $('.myCheckbox').click(function() {
        toggleMarkReadButton();
    });
    $('.messages').click(function() {
        updateButtonTextmessage();
    });
    $('.transfers').click(function() {
        updateButtonTexttransfer();
    });
});

</script>
<?php $this->load->view("partial/footer"); ?>