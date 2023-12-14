<?php $this->load->view("partial/header");
$this->load->helper('demo');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/css_good/plugins/custom/apexcharts/apexcharts.min.js"></script>

<div class="row g-5 g-xl-10 mb-xl-10">
    <!--begin::Col-->

    <!--end::Col-->
    <!--begin::Col-->

    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
        <!--begin::Chart widget 3-->
        <div class="card card-flush overflow-hidden h-md-100">
            <!--begin::Header-->
            <div class="card-header py-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="title_1"><?= lang('work_order'); ?></span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">

            <div class="row px-5 summary-row_1">
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">
                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted sub_1">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Subtotal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted total_1">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted profit_1">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Profit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
	            </div>
               
                
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="chart_wrapper_1" class="overlay overlay-block"> 
					
					<!-- <canvas id="chart"></canvas> -->
					<div id="chart_1" style="height: 300px;"> </div>
                     <!--begin::Overlay Layer-->
                <div class="overlay-layer bg-opacity-5 chart_wrapper_1">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <!--end::Overlay Layer-->
				</div>

                
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Chart widget 3-->
    </div>
    <!--end::Col-->
 <!--begin::Col-->
 <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
        <!--begin::Chart widget 3-->
        <div class="card card-flush overflow-hidden h-md-100">
            <!--begin::Header-->
            <div class="card-header py-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="title_2"><?= lang('work_order'); ?></span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">

            <div class="row px-5 summary-row_2">
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">
                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted sub_2">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Subtotal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted total_2">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted profit_2">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Profit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
	            </div>
               
                
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="chart_wrapper_2" class="overlay overlay-block"> 
					
					<!-- <canvas id="chart"></canvas> -->
					<div id="chart_2" style="height: 300px;"> </div>
                     <!--begin::Overlay Layer-->
                <div class="overlay-layer bg-opacity-5 chart_wrapper_2">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <!--end::Overlay Layer-->
				</div>

                
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Chart widget 3-->
    </div>
    <!--end::Col-->

 <!--begin::Col-->
 <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
        <!--begin::Chart widget 3-->
        <div class="card card-flush overflow-hidden h-md-100">
            <!--begin::Header-->
            <div class="card-header py-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="title_3"><?= lang('work_order'); ?></span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">

            <div class="row px-5 summary-row_3">
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">
                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted sub_3">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Subtotal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted total_3">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted profit_3">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Profit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
	            </div>
               
                
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="chart_wrapper_3" class="overlay overlay-block"> 
					
					<!-- <canvas id="chart"></canvas> -->
					<div id="chart_3" style="height: 300px;"> </div>
                     <!--begin::Overlay Layer-->
                <div class="overlay-layer bg-opacity-5 chart_wrapper_3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <!--end::Overlay Layer-->
				</div>

                
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Chart widget 3-->
    </div>
    <!--end::Col-->
 <!--begin::Col-->
 <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
        <!--begin::Chart widget 3-->
        <div class="card card-flush overflow-hidden h-md-100">
            <!--begin::Header-->
            <div class="card-header py-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="title_4"><?= lang('work_order'); ?></span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">

            <div class="row px-5 summary-row_4">
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">
                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted sub_4">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Subtotal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted total_4">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted profit_4">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Profit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
	            </div>
               
                
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="chart_wrapper_4" class="overlay overlay-block"> 
					
					<!-- <canvas id="chart"></canvas> -->
					<div id="chart_4" style="height: 300px;"> </div>
                     <!--begin::Overlay Layer-->
                <div class="overlay-layer bg-opacity-5 chart_wrapper_4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <!--end::Overlay Layer-->
				</div>

                
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Chart widget 3-->
    </div>
    <!--end::Col-->

     <!--begin::Col-->
     <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
        <!--begin::Chart widget 3-->
        <div class="card card-flush overflow-hidden h-md-100">
            <!--begin::Header-->
            <div class="card-header py-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="title_5"><?= lang('work_order'); ?></span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">

            <div class="row px-5 summary-row_5">
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">
                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted sub_5">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Subtotal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted total_5">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted profit_5">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Profit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
	            </div>
               
                
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="chart_wrapper_5" class="overlay overlay-block"> 
					
					<!-- <canvas id="chart"></canvas> -->
					<div id="chart_5" style="height: 300px;"> </div>
                     <!--begin::Overlay Layer-->
                <div class="overlay-layer bg-opacity-5 chart_wrapper_5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <!--end::Overlay Layer-->
				</div>

                
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Chart widget 3-->
    </div>
    <!--end::Col-->
 <!--begin::Col-->
<div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
        <!--begin::Chart widget 3-->
        <div class="card card-flush overflow-hidden h-md-100">
            <!--begin::Header-->
            <div class="card-header py-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="title_6"><?= lang('work_order'); ?></span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">

            <div class="row px-5 summary-row_6">
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">
                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted sub_6">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Subtotal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted total_6">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted profit_6">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Profit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
	            </div>
               
                
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="chart_wrapper_6" class="overlay overlay-block"> 
					
					<!-- <canvas id="chart"></canvas> -->
					<div id="chart_6" style="height: 300px;"> </div>
                     <!--begin::Overlay Layer-->
                <div class="overlay-layer bg-opacity-5 chart_wrapper_6">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <!--end::Overlay Layer-->
				</div>

                
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Chart widget 3-->
</div>
    <!--end::Col-->

 <!--begin::Col-->
 <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
        <!--begin::Chart widget 3-->
        <div class="card card-flush overflow-hidden h-md-100">
            <!--begin::Header-->
            <div class="card-header py-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="title_7"><?= lang('work_order'); ?></span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">

            <div class="row px-5 summary-row_7">
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">
                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted sub_7">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Subtotal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted total_7">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted profit_7">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Profit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
	            </div>
               
                
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="chart_wrapper_7" class="overlay overlay-block"> 
					
					<!-- <canvas id="chart"></canvas> -->
					<div id="chart_7" style="height: 300px;"> </div>
                     <!--begin::Overlay Layer-->
                <div class="overlay-layer bg-opacity-5 chart_wrapper_7">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <!--end::Overlay Layer-->
				</div>

                
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Chart widget 3-->
</div>
    <!--end::Col-->

     <!--begin::Col-->
<div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
        <!--begin::Chart widget 3-->
        <div class="card card-flush overflow-hidden h-md-100">
            <!--begin::Header-->
            <div class="card-header py-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="title_8"><?= lang('work_order'); ?></span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">

            <div class="row px-5 summary-row_8">
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">
                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted sub_8">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Subtotal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted total_8">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted profit_8">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Profit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
	            </div>
               
                
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="chart_wrapper_8" class="overlay overlay-block"> 
					
					<!-- <canvas id="chart"></canvas> -->
					<div id="chart_8" style="height: 300px;"> </div>
                     <!--begin::Overlay Layer-->
                <div class="overlay-layer bg-opacity-5 chart_wrapper_8">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <!--end::Overlay Layer-->
				</div>

                
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Chart widget 3-->
</div>
    <!--end::Col-->

 <!--begin::Col-->
 <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
        <!--begin::Chart widget 3-->
        <div class="card card-flush overflow-hidden h-md-100">
            <!--begin::Header-->
            <div class="card-header py-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="title_9"><?= lang('work_order'); ?></span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">

            <div class="row px-5 summary-row_9">
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">
                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted sub_9">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Subtotal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted total_9">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted profit_9">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Profit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
	            </div>
               
                
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="chart_wrapper_9" class="overlay overlay-block"> 
					
					<!-- <canvas id="chart"></canvas> -->
					<div id="chart_9" style="height: 300px;"> </div>
                     <!--begin::Overlay Layer-->
                <div class="overlay-layer bg-opacity-5 chart_wrapper_9">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <!--end::Overlay Layer-->
				</div>

                
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Chart widget 3-->
</div>
    <!--end::Col-->

 <!--begin::Col-->
<div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
        <!--begin::Chart widget 3-->
        <div class="card card-flush overflow-hidden h-md-100">
            <!--begin::Header-->
            <div class="card-header py-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="title_10"><?= lang('work_order'); ?></span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">

            <div class="row px-5 summary-row_10">
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">
                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted sub_10">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Subtotal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted total_10">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-6 summary-data">

                        <div class="card card-flush  mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header p-1">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted profit_10">0</span>							
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Reports Profit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
	            </div>
               
                
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="chart_wrapper_10" class="overlay overlay-block"> 
					
					<!-- <canvas id="chart"></canvas> -->
					<div id="chart_10" style="height: 300px;"> </div>
                     <!--begin::Overlay Layer-->
                <div class="overlay-layer bg-opacity-5 chart_wrapper_10">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <!--end::Overlay Layer-->
				</div>

                
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Chart widget 3-->
</div>
    <!--end::Col-->


    
    
    

    
    

    

    <script>
                    $(document).ready(function () {

                        function load_chart( urls ='graphical_summary_work_order', title,id , location , report_date_range_simple , company='All' , compare = 'no'  ){
                            var url ='';
                            if(compare=='no'){
                                url = "<?php echo base_url() ?>/reports/generate_ajax/"+urls+"?tier_id=&report_type=simple&report_date_range_simple="+report_date_range_simple+"&start_date=&end_date=&with_time=1&end_date_end_of_day=0&item_id=&category_id=0&payment_type=&sale_type=all&group_by=&location_ids%5B%5D="+location+"&company="+company+"&business_type=All&items%5B%5D=pos&items%5B%5D=items&items%5B%5D=receivings&items%5B%5D=customers&compare=no&interval=3600&export_excel=0"
                            }else{
                                url =  "<?php echo base_url() ?>/reports/generate_ajax/"+urls+"?tier_id=&report_type=simple&report_date_range_simple="+report_date_range_simple+"&start_date=&end_date=&with_time=1&end_date_end_of_day=0&item_id=&category_id=0&payment_type=&sale_type=all&group_by=&location_ids%5B%5D=1&company="+company+"&business_type=All&items%5B%5D=pos&items%5B%5D=items&items%5B%5D=receivings&items%5B%5D=customers&compare=yes&interval=3600&export_excel=0";
                            }
                        $.ajax({
                            type: "GET",

                            url : url,
                            success: function (response) {

                                $('.chart_wrapper_'+id+'').hide();
                                var data =  JSON.parse(response);
                                if(compare=='no'){
                                       $('.sub_'+id+'').html(data.summary[0].subtotal);
                                       $('.total_'+id+'').html(data.summary[0].total);
                                       $('.profit_'+id+'').html(data.summary[0].profit);
                                       $('.summary-row_'+id+'').show();
                                }else{
                                    $('.summary-row_'+id+'').hide();
                                }
                                $('#title_'+id+'').html(title);
                                // console.log(Object.values(data.series));
                                //    $('#title_'+id+'').html(title);
                                //    $('.sub_'+id+'').html(data.output_data.summary_data.subtotal);
                                //    $('.total_'+id+'').html(data.output_data.summary_data.total);
                                //    $('.profit_'+id+'').html(data.output_data.summary_data.profit);
                                //     var indicesArray = Object.keys(data.output_data.data);
                                //     var dataset = Object.values(data.output_data.data);

                                // console.log(JSON.stringify(indicesArray) );
                                // console.log(JSON.stringify(dataset) );
                                var element = document.getElementById('chart_'+id+'');

                                var height =300;
                                var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
                                var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
                                var baseColor = KTUtil.getCssVariableValue('--kt-info');
                                var lightColor = KTUtil.getCssVariableValue('--kt-info-light');
                                colorPalette =  
                                [
                                    '#008FFB' , '#00E396' , '#FEB019', "#FF0000", "#00FF00", "#0000FF", "#FFFF00", "#FF00FF","#00FFFF", "#FF4500", "#FF8C00", "#FFD700", "#ADFF2F","#32CD32", "#00FF7F", "#00FA9A", "#008B8B", "#000080","#4B0082", "#9400D3", "#8A2BE2", "#800080", "#7B68EE","#483D8B", "#000000", "#FFFFFF", "#FFA07A", "#FA8072","#E9967A", "#F08080", "#CD5C5C", "#DC143C", "#B22222","#FF6347", "#FF4500", "#FFD700", "#FF8C00", "#FFA500","#DAA520", "#B8860B", "#A52A2A", "#800000", "#808080","#696969", "#708090", "#2F4F4F", "#008080", "#006400","#556B2F", "#228B22", "#008000", "#32CD32", "#00FF00"
                                ];
                               
                            
                                var options = {
                                    series: Object.values(data.series),
                                    chart: {
                                        fontFamily: 'inherit',
                                        type: 'line',
                                        height: height,
                                        toolbar: {
                                            show: false
                                        }
                                    },
                                    plotOptions: {

                                    },
                                    legend: {
                                            show: true,
                                            showForSingleSeries: false,
                                            showForNullSeries: true,
                                            showForZeroSeries: true,
                                            position: 'bottom',
                                            horizontalAlign: 'center', 
                                            floating: false,
                                            fontSize: '14px',
                                            fontFamily: 'Helvetica, Arial',
                                            fontWeight: 400,
                                            formatter: undefined,
                                            inverseOrder: false,
                                            width: undefined,
                                            height: undefined,
                                            tooltipHoverFormatter: undefined,
                                            customLegendItems: [],
                                            offsetX: 0,
                                            offsetY: 0,
                                            labels: {
                                                colors: undefined,
                                                useSeriesColors: false
                                            },
                                            markers: {
                                                width: 12,
                                                height: 12,
                                                strokeWidth: 0,
                                                strokeColor: '#fff',
                                                fillColors: undefined,
                                                radius: 12,
                                                customHTML: undefined,
                                                onClick: undefined,
                                                offsetX: 0,
                                                offsetY: 0
                                            },
                                            itemMargin: {
                                                horizontal: 5,
                                                vertical: 0
                                            },
                                            onItemClick: {
                                                toggleDataSeries: true
                                            },
                                            onItemHover: {
                                                highlightDataSeries: true
                                            },
                                    },
                                    dataLabels: {
                                        enabled: true
                                    },
                                    fill: {
                                        type: 'solid',
                                        opacity: 1
                                    },
                                    stroke: {
                                        curve: 'smooth',
                                        show: true,
                                        width: 3,
                                        colors: colorPalette
                                    },
                                    xaxis: {
                                        categories: data.labels,
                                        axisBorder: {
                                            show: false,
                                        },
                                        axisTicks: {
                                            show: false
                                        },
                                        labels: {
                                            style: {
                                                colors: labelColor,
                                                fontSize: '12px'
                                            }
                                        },
                                        crosshairs: {
                                            position: 'front',
                                            stroke: {
                                                color: baseColor,
                                                width: 1,
                                                dashArray: 3
                                            }
                                        },
                                        tooltip: {
                                            enabled: true,
                                            formatter: undefined,
                                            offsetY: 0,
                                            style: {
                                                fontSize: '12px'
                                            }
                                        }
                                    },
                                    yaxis: {
                                        labels: {
                                            style: {
                                                colors: labelColor,
                                                fontSize: '12px'
                                            }
                                        }
                                    },
                                    states: {
                                        normal: {
                                            filter: {
                                                type: 'none',
                                                value: 0
                                            }
                                        },
                                        hover: {
                                            filter: {
                                                type: 'none',
                                                value: 0
                                            }
                                        },
                                        active: {
                                            allowMultipleDataPointsSelection: false,
                                            filter: {
                                                type: 'none',
                                                value: 0
                                            }
                                        }
                                    },
                                    tooltip: {
                                        style: {
                                            fontSize: '12px'
                                        },
                                        y: {
                                            formatter: function (val) {
                                                return '$' + val + ' '
                                            }
                                        }
                                    },
                                    colors: [ ],
                                    grid: {
                                        borderColor: borderColor,
                                        strokeDashArray: 4,
                                        yaxis: {
                                            lines: {
                                                show: true
                                            }
                                        }
                                    },
                                    markers: {
                                        strokeColor: baseColor,
                                        strokeWidth: 3
                                    }
                                };
                            

                                var chart = new ApexCharts(element, options);
                                chart.render();
                            
                            }
                        });
                    }

                    function load_chart_donut( urls ='graphical_summary_work_order', title,ids , location , report_date_range_simple , company='All' , compare = 'no'  ){
                            var url ='';
                            if(compare=='no'){
                                url = "<?php echo base_url() ?>/reports/generate_ajax/"+urls+"?tier_id=&report_type=simple&report_date_range_simple="+report_date_range_simple+"&start_date=&end_date=&with_time=1&end_date_end_of_day=0&item_id=&category_id=0&payment_type=&sale_type=all&group_by=&location_ids%5B%5D="+location+"&company="+company+"&business_type=All&items%5B%5D=pos&items%5B%5D=items&items%5B%5D=receivings&items%5B%5D=customers&compare=no&interval=3600&export_excel=0"
                            }else{
                                url =  "<?php echo base_url() ?>/reports/generate_ajax/"+urls+"?tier_id=&report_type=simple&report_date_range_simple="+report_date_range_simple+"&start_date=&end_date=&with_time=1&end_date_end_of_day=0&item_id=&category_id=0&payment_type=&sale_type=all&group_by=&location_ids%5B%5D=1&company="+company+"&business_type=All&items%5B%5D=pos&items%5B%5D=items&items%5B%5D=receivings&items%5B%5D=customers&compare=yes&interval=3600&export_excel=0";
                            }
                        $.ajax({
                            type: "GET",

                            url : url,
                            success: function (response) {
                                var i=0;
                                for (const id of ids) {
                                $('.chart_wrapper_'+id+'').hide();
                                var data =  JSON.parse(response);
                                if(compare=='no'){
                                       $('.sub_'+id+'').html(data.summary[0].subtotal);
                                       $('.total_'+id+'').html(data.summary[0].total);
                                       $('.profit_'+id+'').html(data.summary[0].profit);
                                       $('.summary-row_'+id+'').show();
                                }else{
                                    $('.summary-row_'+id+'').hide();
                                }
                                
                                var element = document.getElementById('chart_'+id+'');

                                var height =300;
                                var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
                                var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
                                var baseColor = KTUtil.getCssVariableValue('--kt-info');
                                var lightColor = KTUtil.getCssVariableValue('--kt-info-light');
                                colorPalette =  
                                [
                                    '#008FFB' , '#00E396' , '#FEB019', "#FF0000", "#00FF00", "#0000FF", "#FFFF00", "#FF00FF","#00FFFF", "#FF4500", "#FF8C00", "#FFD700", "#ADFF2F","#32CD32", "#00FF7F", "#00FA9A", "#008B8B", "#000080","#4B0082", "#9400D3", "#8A2BE2", "#800080", "#7B68EE","#483D8B", "#000000", "#FFFFFF", "#FFA07A", "#FA8072","#E9967A", "#F08080", "#CD5C5C", "#DC143C", "#B22222","#FF6347", "#FF4500", "#FFD700", "#FF8C00", "#FFA500","#DAA520", "#B8860B", "#A52A2A", "#800000", "#808080","#696969", "#708090", "#2F4F4F", "#008080", "#006400","#556B2F", "#228B22", "#008000", "#32CD32", "#00FF00"
                                ];
                               
                                var seriesedont;
                                if(i==0){
                                    seriesedont =    Object.values(data.series.total_sale);
                                    $('#title_'+id+'').html(title + " (<?= lang('total_sale_count') ?>)");
                                }else if(i==1){
                                    seriesedont = Object.values(data.series.total_sale_amount);
                                    $('#title_'+id+'').html(title + " (<?= lang('total_sale_amount') ?>)");
                                }else if(i==2){
                                    seriesedont = Object.values(data.series.total_sale_profit);
                                    $('#title_'+id+'').html(title + " (<?= lang('total_sale_profit') ?>)");
                                }
                                
                                i++;
                                var options = {
                                    chart: {
                                        type: 'donut',
                                        width: '100%',
                                        height: 400
                                    },
                                    dataLabels: {
                                        enabled: false,
                                    },
                                    plotOptions: {
                                        pie: {
                                        customScale: 0.8,
                                        donut: {
                                            size: '75%',
                                        },
                                        offsetY: 20,
                                        },
                                        stroke: {
                                        colors: undefined
                                        }
                                    },
                                    colors: colorPalette,
                                    title: {
                                        text: '<?php echo lang('locations');?>',
                                        style: {
                                        fontSize: '18px'
                                        }
                                    },
                                    series: seriesedont,
                                    labels: Object.values(data.labels),
                                    legend: {
                                        position: 'left',
                                        offsetY: 80
                                    }
                                };
                            

                                var chart = new ApexCharts(element, options);
                                chart.render();
                            }
                            
                            }
                        });
                    }

                    load_chart('graphical_summary_work_order' , '<?php echo lang('All_time_work_order_current_location') ; ?>' ,1, <?php echo $current_logged_in_location_id ; ?> ,'ALL_TIME' , 'All' , 'no');

                    load_chart( 'graphical_summary_sales_time_work_order','<?php echo lang('Today_work_order_current_location') ; ?>' ,2, <?php echo $current_logged_in_location_id ; ?>, 'TODAY' , 'All' , 'no');

                    load_chart( 'graphical_summary_work_order','<?php echo lang('All_time_work_order_all_companies') ; ?>' ,3, <?php echo $current_logged_in_location_id ; ?>, 'ALL_TIME' , 'All' , 'yes');
                    
                    load_chart( 'graphical_summary_sales_time_work_order','<?php echo lang('Today_work_order_all_companies') ; ?>', 4, <?php echo $current_logged_in_location_id ; ?>, 'TODAY' , 'All' , 'yes');
                    
                    load_chart_donut('summary_sales_locations_work_order' , '<?php echo lang('All_time_work_order_all_companies') ; ?>', [5,7,9], <?php echo $current_logged_in_location_id ; ?>, 'ALL_TIME' , 'All' , 'yes'  );

                    load_chart_donut('summary_sales_locations_work_order' , '<?php echo lang('Today_work_order_all_companies') ; ?>', [6,8,10], <?php echo $current_logged_in_location_id ; ?>, 'TODAY' , 'All' , 'yes' );


                    });

                    

                    



                   
</script>


</div>
<?php $this->load->view("partial/footer"); ?>