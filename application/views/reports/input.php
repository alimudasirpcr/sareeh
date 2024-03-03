<div class="row hidden-print">

    <div class="col-md-12">

        <div class="card">

            <div
                class="card-header rounded rounded-3 p-5  rounded border-primary border border-dashed rounded-3 report-options">
                <?php echo $input_report_title; ?>
                <?php if (isset($output_data) && $output_data) { ?>
                <div class="table_buttons pull-right" style="margin-top: -12px;">
                    <button type="button" class="btn btn-more btn-light-primary expand-collapse" data-toggle="dropdown"
                        aria-expanded="false"><i id="expand-collapse-icon" class="ion-chevron-down"></i></button>
                </div>
                <?php } ?>
            </div>

            <div class="row" id="options" >
                <div class="col-md-12">
                    <div class="py-5 mb-5">
                        <div class="rounded border p-10">
						<form class="form-horizontal form-horizontal-mobiles" id="report_input_form" method="get"
                    action="<?php echo site_url('reports/generate/'.$report); ?>">
                            <div class="mb-10">
                                <div class="form-check" data-keyword="<?php echo H(lang('config_keyword_payment')) ?>">
								<?php 
					$this->load->helper('view');
					foreach($input_params as $input_param) 
					{
							load_cleaned_view('reports/inputs/'.$input_param['view'],$input_param);
					} 
					?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</div>
<script>
$('#generate_report').click(function(e) {
    e.preventDefault();
    $('#options').slideToggle(function() {
        $('#report_input_form').submit();
    });
});
</script>