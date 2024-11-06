<?php $this->load->view("partial/header"); ?>


<style>

@media print {
	.card {
    border: none !important;
}
}
</style>
<?php 
			$company = ($company = $this->Location->get_info_for_key('company', isset($override_location_id) ? $override_location_id : FALSE)) ? $company : $this->config->item('company');
			$company_logo = ($company_logo = $this->Location->get_info_for_key('company_logo', isset($override_location_id) ? $override_location_id : FALSE)) ? $company_logo : $this->config->item('company_logo');
			$tax_id = ($tax_id = $this->Location->get_info_for_key('tax_id', isset($override_location_id) ? $override_location_id : FALSE)) ? $tax_id : $this->config->item('tax_id');
			$website = ($website = $this->Location->get_info_for_key('website', isset($override_location_id) ? $override_location_id : FALSE)) ? $website : $this->config->item('website');
			
			?>




<div class="card  invoice_body">
    <div class="card-header rounded rounded-3 p-5  rounded border-primary  rounded-3 hidden-print">

        <span class="pull-right">
            <button class="btn btn-primary btn-sm hidden-print" id="print_button" onclick="window.print()">
                <?php echo lang('print'); ?> </button>
            <?php if (to_currency_no_money($invoice_info->balance) != '0.00') { ?>
            <button class="btn btn-primary btn-sm hidden-print" id="email_button">
                <?php echo lang('email'); ?>
            </button>
            <?php } ?>
            <?php echo anchor("invoices/index/$invoice_type",' Back To Invoices', array('class'=>'hidden-print btn btn-primary btn-sm')); ?>
        </span>
    </div>

    <div class="card-body" style="position:relative; ">

        <?php if($invoice_info->balance <= 0){?>
        <style>
        .watermark {
            position: absolute;
            font-size: 150px;
            z-index: 1000;
            opacity: 0.2;
            width: 100%;
            text-align: center;
            pointer-events: none;
            text-transform: uppercase;
            transform: rotate(-20deg);
            margin-top: 50px;
        }
        </style>
        <div class="watermark"><?php echo lang('paid')?></div>
        <?php } ?>

        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Content-->
            <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                <!--begin::Invoice 2 content-->
                <div class="mt-n1">
                    <!--begin::Top-->
                    <div class="d-flex flex-stack pb-10">
                        <!--begin::Logo-->
                        <?php 
						if ($company_logo) { ?>

                        <?php
		if (!(isset($standalone) && $standalone)) {
		?>

                        <a href="#">
                            <?php echo img(array( 'class' => 'w-100px' , 'src' => secure_app_file_url($company_logo))); ?>
                        </a>
                        <?php } ?>
                        <?php } ?>



                        <!--end::Logo-->

                        <!--begin::Action-->

                        <!--end::Action-->
                    </div>
                    <!--end::Top-->

                    <!--begin::Wrapper-->
                    <div class="m-0">
                        <!--begin::Label-->
                        <div class="fw-bold fs-3 text-gray-800 mb-8"><?= lang('invoice'); ?> #<?php echo $invoice_id; ?>
                        </div>
                        <!--end::Label-->
                        <div class="card-body">

                            <?php 
						
						$D = date(get_date_format(), strtotime($invoice_info->due_date));
						$due_date = new DateTime($D);
$today = new DateTime(); // Current date

// Calculate the difference in days
$interval = $today->diff($due_date);
$days_due = $interval->days; // Number of days between today and due date
$is_past_due = $due_date < $today; // Check if due date is in the past

// Determine the due message
if ($is_past_due) {
    $due_message = "Past due by $days_due days";
} elseif ($days_due == 0) {
    $due_message = "Due today";
} elseif ($days_due <= 7) {
    $due_message = "Due in $days_due days";
} else {
    $due_message = "Due in more than 7 days";
}



						?>

                        </div>
                        <!--begin::Row-->
                        <div class="row g-5 mb-11">
                            <!--end::Col-->
                            <div class="col-sm-6">
                                <!--end::Label-->
                                <div class="fw-semibold fs-7 text-gray-600 mb-1">
                                    <?php echo lang('invoices_invoice_date');?>:</div>
                                <!--end::Label-->

                                <!--end::Col-->
                                <div class="fw-bold fs-6 text-gray-800">
								

                                    <?php echo date(get_date_format(), strtotime($invoice_info->invoice_date));?></div>
                                <!--end::Col-->
                            </div>
                            <!--end::Col-->

                            <!--end::Col-->
                            <div class="col-sm-6">
                                <!--end::Label-->
                                <div class="fw-semibold fs-7 text-gray-600 mb-1">
                                    <?php echo lang('invoices_due_date');?>:</div>
                                <!--end::Label-->

                                <!--end::Info-->
                                <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center flex-wrap">
                                    <span
                                        class="pe-2"><?php echo date(get_date_format(), strtotime($invoice_info->due_date));?></span>

                                    <span class="fs-7 text-danger d-flex align-items-center">
                                        <span class="bullet bullet-dot bg-danger me-2"></span>

                                        <?php echo $due_message;?>
                                    </span>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->


                        <!--begin::Row-->
                        <div class="row g-5 mb-12">
                            <!--end::Col-->
                            <div class="col-sm-6">
                                <!--end::Label-->
                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Issue For
                                    <?php echo lang("invoices_$invoice_type");?>:</div>
                                <!--end::Label-->

                                <!--end::Text-->
                                <div class="fw-bold fs-6 text-gray-800"><?php echo $invoice_info->person;?></div>
                                <!--end::Text-->

                                <!--end::Description-->
                                <div class="fw-semibold fs-7 text-gray-600">
                                    <?php echo $invoice_info->term_description; if($invoice_info->{"$invoice_type".'_po'}) {
							echo '<br>';
							echo lang('invoices_po_'.$invoice_type).': ';
							echo $invoice_info->{"$invoice_type".'_po'};
						} ?> <br>

<?php echo lang('invoices_terms');?>: <?php echo $invoice_info->term_name?>
                                </div>
                                <!--end::Description-->
                            </div>
                            <!--end::Col-->

                            <!--end::Col-->
                            <div class="col-sm-6">
                                <!--end::Label-->
                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Issued By:</div>
                                <!--end::Label-->

                                <!--end::Text-->
                                <div class="fw-bold fs-6 text-gray-800">
                                    <?php if ($this->Location->count_all() > 1) { ?>
                                    <?php echo H($company); ?></br>
                                    <?php if(!$this->config->item('hide_location_name_on_receipt')){ ?>
                                    <?php echo H($this->Location->get_info_for_key('name', isset($override_location_id) ? $override_location_id : FALSE)); ?>
                                    </br>
                                    <?php } ?>
                                    <?php } else {
			?>
                                    <?php echo H($company); ?></br>
                                    <?php
			}
			?></div>
                                <!--end::Text-->

                                <!--end::Description-->
                                <div class="fw-semibold fs-7 text-gray-600">


                                    <?php
			if ($tax_id) {
			?>
                                    <?php echo lang('tax_id') . ': ' . H($tax_id); ?></br>
                                    <?php
			}
			?>


                                    <?php echo H($this->Location->get_info_for_key('address', isset($override_location_id) ? $override_location_id : FALSE)); ?>
                                    </br>
                                    <?php echo H($this->Location->get_info_for_key('phone', isset($override_location_id) ? $override_location_id : FALSE)); ?>
                                    </br>
                                    <?php if ($website) { ?>
                                    <?php echo H($website); ?>
                                    <?php } ?>
                                </div>
                                <!--end::Description-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->


                        <!--begin::Content-->
                        <div class="flex-grow-1">

                            <?php $this->load->view('partial/invoices/details_view', array('details' => $details,'can_edit' => FALSE,'type_prefix' => $type_prefix)); ?>


                            <!--begin::Container-->
                            <div class="d-flex justify-content-end">
                                <!--begin::Section-->
                                <div class="mw-300px">
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack mb-3">
                                        <!--begin::Accountname-->
                                        <div class="fw-semibold pe-10 text-gray-600 fs-7"><?php echo lang('total')?>
                                        </div>
                                        <!--end::Accountname-->

                                        <!--begin::Label-->
                                        <div class="text-end fw-bold fs-6 text-gray-800">
                                            <?php echo to_currency($invoice_info->total)?></div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack mb-3">
                                        <!--begin::Accountname-->
                                        <div class="fw-semibold pe-10 text-gray-600 fs-7"><?php echo lang('balance')?>
                                        </div>
                                        <!--end::Accountname-->

                                        <!--begin::Label-->
                                        <div class="text-end fw-bold fs-6 text-gray-800">
                                            <?php echo to_currency($invoice_info->balance)?></div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->


                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Invoice 2 content-->
            </div>
            <!--end::Content-->

        </div>






        <?php $this->load->view('partial/invoices/payments', array('payments' => $payments));?>


    </div> <!-- close pannel body -->

    <div class="row" style="padding:0px 22px; text-align: right;">
        <div class="pull-right  visible-print">
            <h4><?php echo lang('total');?>: <?php echo to_currency($invoice_info->total)?></h4>
            <h4><?php echo lang('balance');?>: <?php echo to_currency($invoice_info->balance)?></h4>
        </div>
    </div>
    <script type="text/javascript">
    $("#email_button").click(function(e) {
        e.preventDefault();
        $.get(<?php echo json_encode(site_url("invoices/email_invoice/$invoice_type/$invoice_id"));?>);
        show_feedback('success', <?php echo json_encode(lang('invoice_sent')); ?>,
            <?php echo json_encode(lang('success')); ?>);

    });
    </script>
    <?php $this->load->view("partial/footer"); ?>