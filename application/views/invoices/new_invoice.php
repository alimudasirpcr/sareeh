<?php $this->load->view("partial/header"); ?>
<style type="text/css">

</style>
<?php echo form_open("invoices/save_new/$invoice_type/$invoice_id",array('id'=>'invoice_save_form','class'=>'form-horizontal')); ?>


<div class="d-flex flex-column  flex-lg-row" data-select2-id="select2-data-189-65xj">
    <!--begin::Content-->
    <div class="flex-lg-row mb-10 mb-lg-0 me-lg-7 me-xl-10">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body p-12">
                <!--begin::Form-->
                <form action="" id="kt_invoice_form">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column align-items-start flex-xxl-row">
                        <!--begin::Input group-->
                        <div class="d-flex align-items-center flex-equal fw-row me-4 order-2" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-original-title="Specify invoice date"
                            data-kt-initialized="1">
                            <!--begin::Date-->
                            <div class="fs-6 fw-bold text-gray-700 text-nowrap"><?php echo lang('Date');?>:</div>
                            <!--end::Date-->

                            <!--begin::Input-->
                            <div class="position-relative d-flex align-items-center w-150px">


                                <?php echo form_input(array(
							'name'	=>	'invoice_date',
							'id'	=>	'invoice_date',
							'class'	=>	'datepicker form-control form-control-transparent fw-bold pe-5',
							'value'	=>	$invoice_info->invoice_date ? date(get_date_format().' '.get_time_format(), strtotime($invoice_info->invoice_date)) : date(get_date_format())
						));?>


                                <!--begin::Icon-->
                                <i class="ki-duotone ki-down fs-4 position-absolute ms-4 end-0"></i>
                                <!--end::Icon-->
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4"
                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                            data-bs-original-title="Enter invoice number" data-kt-initialized="1">
                            <span class="fs-2x fw-bold text-gray-800">Invoice #</span>
                            <input type="text" class="form-control form-control-flush fw-bold text-muted fs-3 w-125px"
                                value="<?= ($invoice_info->invoice_id)?$invoice_info->invoice_id:'' ?>" placehoder="..." readonly>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="d-flex align-items-center justify-content-end flex-equal order-3 fw-row"
                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                            data-bs-original-title="Specify invoice due date" data-kt-initialized="1">
                            <!--begin::Date-->
                            <div class="fs-6 fw-bold text-gray-700 text-nowrap"> <?php echo lang('Due_Date');?>:</div>
                            <!--end::Date-->

                            <!--begin::Input-->
                            <div class="position-relative d-flex align-items-center w-150px">
                                <!--begin::Datepicker-->

                                <?php echo form_input(array(
							'name'	=>	'due_date',
							'id'	=>	'due_date',
							'class'	=>	'form-control form-control-transparent fw-bold pe-5  datepicker',
							'value'	=>	$invoice_info->due_date ? date(get_date_format().' '.get_time_format(), strtotime($invoice_info->due_date)) : ''
						));?>


                                <!--end::Datepicker-->

                                <!--begin::Icon-->
                                <i class="ki-duotone ki-down fs-4 position-absolute end-0 ms-4"></i>
                                <!--end::Icon-->
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Top-->

                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-10"></div>
                    <!--end::Separator-->

                    <!--begin::Wrapper-->
                    <div class="mb-0">
                        <!--begin::Row-->
                        <div class="col-md-12">


                            <div id="invoice_date_field" class="form-group">
                                <?php echo form_label(lang('invoices_po_'.$invoice_type).':', 'invoice_date',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
                                <div class="col-sm-9 col-md-9 col-lg-10">
                                    <div class="input-group date">
                                        <?php echo form_input(array(
							'name'	=>	"$invoice_type".'_po',
							'id'	=> 	"$invoice_type".'_po',
							'placeholder' => 'PO Number',
							'class'	=>	'form-control form-control-solid',
							'value' => 	$invoice_info->{"$invoice_type".'_po'},
						));?>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <?php echo form_label(lang("invoices_$invoice_type"), '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                                <div class="col-sm-9 col-md-9 col-lg-10">
                                    <?php
					if ($invoice_id == -1)
					{
						echo form_input(array(
							'name'		=> 	"$invoice_type".'_id',
							'id'		=> 	"$invoice_type".'_id',
							'size'		=>	'10',
							'value' 	=> 	$invoice_info->{"$invoice_type".'_id'}));
					} else {
						echo form_input(array(
							'name'		=> "$invoice_type".'_name',
							'id'		=> 	"",
							'size'		=>	'10',
							'class' 	=> 	'form-control form-control-solid',
							'disabled' 	=> 	'disabled',
							'value' 	=> 	$invoice_info->person));
					?>
                                    <input type="hidden" name="<?php echo "$invoice_type".'_id';?>"
                                        value="<?php echo $invoice_info->{"$invoice_type".'_id'};?>">
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php echo form_label(lang("invoices_terms"),'',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
                                <div class="col-sm-9 col-md-9 col-lg-10">
                                    <?php
					echo form_dropdown('term_id', $terms, $invoice_info->term_id, 'class="form-control form-control-solid input_radius" id="term_id"');
					?>
                                </div>
                            </div>



                            <div class="form-controls form-actions">
                                <ul class="list-inline pull-right">
                                    <li>
                                        <?php
							echo form_submit(array(
								'name'	=>	'submitf',
								'id'	=>	'submitf',
								'value'	=>	lang('save'),
								'class'	=>	'submit_button floating-button btn btn-lg btn-danger')
							);
						?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php $this->load->view('partial/invoices/details', array('details' => isset($details) ? $details : NULL,'can_edit' => TRUE,'type_prefix' => $type_prefix)); ?>

                        <?php $this->load->view('partial/invoices/payments', array('payments' => $payments)); ?>


                        <?php
								if(isset($orders) && !empty($orders))
								{
									$type_prefix = $invoice_type == 'customer' ? 'sale' : 'receiving';
								?>
                        <Br>

                        <div class="">
                            <h5><strong><?php echo lang('invoices_recent_unpaid_orders');?></strong></h5>
                        </div>

                        <div class="row" id="invoice_details">
                            <div class="col-md-12">
                                <table class="table table-row-bordered">
                                    <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                        <th><?php echo lang('id');?></th>
                                        <th><?php echo lang('time');?></th>
                                        <th><?php echo lang('amount_due');?></th>
                                        <th><?php echo lang('comment');?></th>
                                        <th><?php echo lang('invoices_add_to_invoice');?></th>
                                    </tr>

                                    <?php foreach($orders as $order) { ?>
                                    <tr>
                                        <td><?php echo $order[$type_prefix.'_id'];?></td>
                                        <td><?php echo date(get_date_format().' '.get_time_format(),strtotime($order[$type_prefix.'_time']));?>
                                        </td>
                                        <td><?php echo to_currency($order['payment_amount']);?></td>
                                        <td><?php echo $order['comment'] ? $order['comment'] : lang('none');?></td>
                                        <td>
                                            <?php if (!$this->Invoice->is_order_in_invoice($invoice_type,$order[$type_prefix.'_id'])) { ?>
                                            <a href="<?php echo site_url("invoices/add_to_invoice/$invoice_type/$invoice_id/".$order[$type_prefix.'_id']);?>"
                                                class="btn btn-primary"><?php echo lang('invoices_add_to_invoice');?></a>
                                            <?php } else { ?>
                                            <?php echo lang('invoices_already_invoiced');?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>

                        <?php } ?>

                    </div>
                    <!--end::Wrapper-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content-->

    <!--begin::Sidebar-->
    <div class="flex-lg-auto min-w-lg-300px  1" data-select2-id="select2-data-188-tiag">
        <!--begin::Card-->
        <div class="card w-400px" data-kt-sticky="true" data-kt-sticky-name="invoice"
            data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '250px', lg: '300px'}"
            data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false"
            data-kt-sticky-zindex="95">

            <!--begin::Card body-->
            <div class="card-body p-10">
                <!--begin::Input group-->
                <div class="mb-10">
                    <div class="d-flex flex-wrap">

                        
		
		
                        <!--begin::Stat-->
                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                    <!--begin::Number-->
                    <div class="d-flex align-items-center">
                        <div class="fs-4 fw-bold"><?php echo to_currency($invoice_info->total)?></div>
                    </div>
                    <!--end::Number-->

                    <!--begin::Label-->
                    <div class="fw-semibold fs-6 text-gray-500"><?php echo lang('total');?></div>
                    <!--end::Label-->
                </div>
                <!--end::Stat-->

                <!--begin::Stat-->
                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                    <!--begin::Number-->
                    <div class="d-flex align-items-center">

                        <div class="fs-4 fw-bold counted" data-kt-countup="true" data-kt-countup-value="75"
                            data-kt-initialized="1"><?php echo to_currency($invoice_info->balance)?></div>


                    </div>
                    <!--end::Number-->

                    <!--begin::Label-->
                    <div class="fw-semibold fs-6 text-gray-500"><?php echo lang('balance');?></div>
                    <!--end::Label-->
                </div>
                <!--end::Stat-->

                        <!--begin::Stat-->
                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                    <!--begin::Number-->
                    <div class="d-flex align-items-center">

                        <div class="fs-4 fw-bold counted total_tax" data-kt-countup="true" data-kt-countup-value="75"
                            data-kt-initialized="1"><?php echo to_currency(0)?></div>


                    </div>
                    <!--end::Number-->

                    <!--begin::Label-->
                    <div class="fw-semibold fs-6 text-gray-500"><?php echo lang('tax');?></div>
                    <!--end::Label-->
                </div>
                <!--end::Stat-->
                  
                


               
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Separator-->
        <div class="separator separator-dashed mb-8"></div>
        <!--end::Separator-->

        <!--end::Separator-->
		
        <!--begin::Actions-->
        <div class="mb-0">
            <!--begin::Row-->
            <div class="row mb-5">
                <!--begin::Col-->
                <div class="col">
                    <a id="add_line_item" href="javascript:void(0);" class="btn btn-light btn-active-light-primary w-100 d-none">      <?php echo lang('invoices_add_invoice_line_item');?></a>
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-12">
                    <a id="add_credit_memo" href="javascript:void(0);"  class="btn btn-light btn-active-light-primary w-100"> <?php echo lang('invoices_add_credit_memo');?></a>
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col mt-3">
                    <a id="add_item" href="javascript:void(0);"  class="btn btn-light btn-active-light-primary w-100 d-none"> <?php echo lang('invoices_add_item');?></a>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->

			<?php
		
		if($invoice_id > 0 && (float)$invoice_info->balance > 0)
		{
			echo anchor("invoices/pay/$invoice_type/$invoice_id", lang('pay'),array('class' => 'btn btn-primary w-100'));
		}
		?>
            <?php echo anchor("invoices/index/$invoice_type",lang('Back_To_Invoices'), array('class'=>'hidden-print mt-3 btn btn-primary w-100')); ?>
       

        </div>
        <!--end::Actions-->
	






    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->
</div>
<!--end::Sidebar-->
</div>





  
        <!-- Load Invoice Details -->
        <!-- Load Invoice Payments -->

       


    <?php echo form_close(); ?>
    <?php $this->load->view('partial/invoices/invoice_detail_modal', array('modal_id' => 'invoice-modal','action' => "invoices/add_to_invoice_manual/$invoice_type/$invoice_id", 'invoice_type' => $invoice_type,'invoice_id' => $invoice_id));?>
    <?php $this->load->view('partial/invoices/invoice_detail_modal', array('modal_id' => 'invoice-modal-memo','action' => "invoices/add_to_invoice_credit_memo/$invoice_type/$invoice_id", 'invoice_type' => $invoice_type,'invoice_id' => $invoice_id));?>
    <?php $this->load->view('partial/invoices/invoice_detail_modal_item', array('modal_id' => 'invoice-modal-item','action' => "invoices/add_item_to_invoice/$invoice_type/$invoice_id", 'invoice_type' => $invoice_type,'invoice_id' => $invoice_id));?>

    <script type="text/javascript">
    $(".delete-invoice-detail").click(function(e) {
        var $that = $(this);
        e.preventDefault();

        bootbox.confirm('Are you you sure you want to delete this invoice item?', function(result) {
            if (result) {
                window.location = $that.attr('href');
            }
        });
    });

    $("#add_line_item").click(function() {
        $("#invoice-modal").modal('show');
    });
    $("#add_item").click(function() {
        $("#invoice-modal-item").modal('show');
    });
    $("#add_credit_memo").click(function() {
        $("#invoice-modal-memo").modal('show');
    });


    $('.xeditable').editable({
        validate: function(value) {
            if ($.isNumeric(value) == '' && $(this).data('validate-number')) {
                return <?php echo json_encode(lang('only_numbers_allowed')); ?>;
            }
        },
        success: function(response, newValue) {}
    });

    $('.xeditable').on('shown', function(e, editable) {

        $(this).closest('.table-responsive').css('overflow-x', 'hidden');

        editable.input.postrender = function() {
            //Set timeout needed when calling price_to_change.editable('show') (Not sure why)
            setTimeout(function() {
                editable.input.$input.select();
            }, 200);
        };
    });


    date_time_picker_field($('.datepicker'), JS_DATE_FORMAT);



    $("#<?php echo $invoice_type;?>_id").select2({
        width: '100%',
        placeholder: <?php echo json_encode(lang('search')); ?>,
        ajax: {
            url: <?php echo json_encode(site_url("invoices/suggest_$invoice_type")); ?>,
            dataType: 'json',
            data: function(term, page) {
                return {
                    'term': term
                };
            },
            results: function(data, page) {
                return {
                    results: data
                };
            }
        },
        id: function(suggestion) {
            return suggestion.value
        },
        formatSelection: function(suggestion) {
            return suggestion.label;
        },
        formatResult: function(suggestion) {
            return suggestion.label;
        }
    });

    $("#term_id").change(function(e) {
        var url = '<?php echo site_url("invoices/get_term_default_due_date"); ?>' + '/' + $(this).val();
        $.getJSON(url, function(json) {
            var term_default_due_date = json.term_default_due_date;
            $("#due_date").val(term_default_due_date);

        });
    });

    $("#<?php echo $invoice_type;?>_id").change(function(e) {
        var url = '<?php echo site_url("invoices/get_default_terms/".$invoice_type); ?>' + '/' + $(this).val();
        $.getJSON(url, function(json) {
            var default_term_id = json.default_term_id;
            $("#term_id").val(default_term_id);
            $("#term_id").trigger('change');

        });
    });
    $('#invoice_save_form').ajaxForm({
        success: function(response) {
            var response = JSON.parse(response);
            $('#grid-loader').hide();
            submitting = false;

            show_feedback(response.success ? 'success' : 'error', response.message, response.success ?
                <?php echo json_encode(lang('success')); ?> : <?php echo json_encode(lang('error')); ?>);

            if (response.reload == 1 && response.success) {
                window.location.reload();
            } else if (response.redirect == 1 && response.success) {
                window.location.href = '<?php echo site_url('invoices/index/'.$invoice_type); ?>';
            } else if (response.redirect == 2 && response.success) {
                window.location.href = '<?php echo site_url('invoices/view/'.$invoice_type.'/'); ?>' +
                    response
                    .invoice_id;
            }

        }
    });
    </script>
    <?php $this->load->view("partial/footer"); ?>