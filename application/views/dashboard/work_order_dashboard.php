<?php $this->load->view("partial/header");
$this->load->helper('demo');
?>

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

            </div>
        </div>
</div>
    <!--end::Col-->
    <div class="card border-primary">
			<div class="card-header">
			<h3 class="card-title">			<?php echo  lang('work_order_all_status') ?>  </h3>
       
                             
			
			</div>
		 
		  <div class="card-body">
			<div class="row" id="options">
				<div class="  col-6 " style="
    border-right: 2px dotted black;
">
					<div id="donutChart"   ></div>
				</div>
				<div class="  col-6 ">
					<div id="donutChart2"   ></div>
				</div>
			</div>
		  </div>
		</div>

 <!--stats for employee-->

<div class="row" id="employee_donts">
   <?php 
   foreach ($stats as $key => $value) { ?>
        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-5 mb-xl-0 mt-4"><div class="card card-flush overflow-hidden h-md-100"><div class="card-header py-5"><h3 class="card-title align-items-start flex-column"><span class="card-label fw-bold text-dark" id="title_<?= $key; ?>"><a target="_blank" class="mb-1 text-dark text-hover-primary fw-bold" href="<?php echo site_url('reports/generate/detailed_work_order'); ?>"> <?= lang($key); ?> </a>  </span></h3></div><div class="card-body d-flex justify-content-between flex-column pb-1 px-0"><div id="chart_wrapper_<?= $key; ?>" class="overlay overlay-block"><div id="chart_<?= $key; ?>" style="height: 300px;"> </div></div></div></div></div>
   <?php }
   ?>

<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-5 mb-xl-0 mt-4"><div class="card card-flush overflow-hidden h-md-100"><div class="card-header py-5"><h3 class="card-title align-items-start flex-column"><span class="card-label fw-bold text-dark" id="title_THIS_YEAR"><a target="_blank" class="mb-1 text-dark text-hover-primary fw-bold" href="<?php echo site_url('reports/generate/detailed_work_order'); ?>"> <?= lang('employee_wise'); ?> </a>  </span></h3><div class="card-toolbar">   
							<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
								<i class="fa fa-calendar"></i>&nbsp;
								<span></span> <i class="fa fa-caret-down"></i>
							</div> 
                            <select  id="THIS_YEAR_STATUS" name="reportrange">
                                <option value="0">All</option>
                            <?php foreach ($status_boxes as $status_box) { 
			
			?>
            <option value="<?php echo $status_box['id']; ?>"><?php echo $this->Work_order->get_status_name($status_box['name']); ?></option>
		<?php } ?>
                            </select>
														
							</div></div><div class="card-body d-flex justify-content-between flex-column pb-1 px-0"><div id="chart_wrapper_THIS_YEAR" class="overlay overlay-block"><div id="work_orders_THIS_YEAR" style="height: 300px;"> </div></div></div></div></div>


<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-5 mb-xl-0 mt-4"><div class="card card-flush overflow-hidden h-md-100"><div class="card-header py-5"><h3 class="card-title align-items-start flex-column"><span class="card-label fw-bold text-dark" id="title_status_wise_THIS_YEAR"><a target="_blank" class="mb-1 text-dark text-hover-primary fw-bold" href="<?php echo site_url('reports/generate/detailed_work_order'); ?>"> <?= lang('status_wise'); ?> </a>  </span></h3></div><div class="card-body d-flex justify-content-between flex-column pb-1 px-0"><div id="chart_wrapper_status_wise_THIS_YEAR" class="overlay overlay-block"><div id="work_orders_status_wise_THIS_YEAR" style="height: 300px;"> </div></div></div></div></div>
</div>
 
    


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
                                                return '<?= get_store_currency(); ?>' + val + ' '
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


                    <?php
                        foreach($stats as $key =>$value){ 
                            
                            $totals = [];
                            $fullNames = [];
                                if(is_array($value)){
                                    foreach ($value as $entry) {
                                        $totals[] = (int)$entry["total"];
                                        $fullNames[] = $entry["full_name"];
                                    }
                                }
                               
                            
                            
                            ?>

                            var element = document.getElementById('chart_<?=$key ?>');

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
                            
                                seriesedont =    Object.values(<?=  json_encode($totals); ?>);
                                console.log(seriesedont);
                           

                            var options = {
                                chart: {
                                    type: 'donut',
                                    width: '100%',
                                    height: 200,
                                   
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
                                    text: '',
                                    style: {
                                    fontSize: '18px'
                                    }
                                },
                                series: seriesedont,
                                labels: Object.values(<?=  json_encode($fullNames); ?>),
                                legend: {
                                    position: 'left',
                                    offsetY: 80
                                }
                            };


                            var chart<?=$key ?> = new ApexCharts(element, options);
                            chart<?=$key ?>.render();

                  <?php       }
                    


                    $totals = [];
                    $fullNames = [];
                    if(is_array($work_orders_THIS_YEAR)){
                        foreach ($work_orders_THIS_YEAR as $entry) {
                            $totals[] = (int)$entry["total"];
                            $fullNames[] = $entry["full_name"];
                        }
                    }

                    ?>


                var element = document.getElementById('work_orders_THIS_YEAR');

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

                    seriesedont =    Object.values(<?=  json_encode($totals); ?>);
                    console.log(seriesedont);


                var options = {
                    chart: {
                        type: 'donut',
                        width: '100%',
                        height: 200,
                    
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
                        text: '',
                        style: {
                        fontSize: '18px'
                        }
                    },
                    series: seriesedont,
                    labels: Object.values(<?=  json_encode($fullNames); ?>),
                    legend: {
                        position: 'left',
                        offsetY: 80
                    }
                };


                var work_orders_THIS_YEAR = new ApexCharts(element, options);
                work_orders_THIS_YEAR.render();

                var start = moment().startOf('month'); // This sets 'start' to the first day of the current month
var end = moment(); // 'end' remains the current moment

    function cb(start, end) {
    
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		$.ajax({
            url: '<?= site_url('home/ajax_get_stats_for_graph_wo') ?>', // The endpoint where you process the dates
            type: 'POST',
            data: {
                from_date: start.format('YYYY-MM-DD'),
                to_date: end.format('YYYY-MM-DD'),
				time: 'CUSTOM',
                status: $('#THIS_YEAR_STATUS').val(),
            },
            success: function(response) {
                // Handle success
				let totals = [];
						let fullNames = [];
						stats= JSON.parse(response);
                if(stats){
				
					
						
						stats.forEach(entry => {
							totals.push(parseInt(entry["total"], 10)); // Convert "total" to an integer
							fullNames.push(entry["full_name"]); // Collect "full_name"
						});


									
				} else {
					// If stats is empty, you might want to clear the chart or display a message
					// For example, you can reset totals and fullNames to contain a single dummy entry to indicate no data
					totals = [0]; // A single entry with a value of 0
					fullNames = ['No Data']; // A single entry indicating no data
				}
				// console.log(totals);
				var element = document.getElementById('work_orders_THIS_YEAR');

                var height = 300;
                var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
                var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
                var baseColor = KTUtil.getCssVariableValue('--kt-info');
                var lightColor = KTUtil.getCssVariableValue('--kt-info-light');
                colorPalette = [
                    '#008FFB', '#00E396', '#FEB019', "#FF0000", "#00FF00", "#0000FF", "#FFFF00", "#FF00FF", "#00FFFF", "#FF4500", "#FF8C00", "#FFD700", "#ADFF2F", "#32CD32", "#00FF7F", "#00FA9A", "#008B8B", "#000080", "#4B0082", "#9400D3", "#8A2BE2", "#800080", "#7B68EE", "#483D8B", "#000000", "#FFFFFF", "#FFA07A", "#FA8072", "#E9967A", "#F08080", "#CD5C5C", "#DC143C", "#B22222", "#FF6347", "#FF4500", "#FFD700", "#FF8C00", "#FFA500", "#DAA520", "#B8860B", "#A52A2A", "#800000", "#808080", "#696969", "#708090", "#2F4F4F", "#008080", "#006400", "#556B2F", "#228B22", "#008000", "#32CD32", "#00FF00"
                ];

                var seriesedont;

                seriesedont = Object.values(totals);



                var options = {
                    chart: {
                        type: 'donut',
                        width: '100%',
                        height: 200
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
                        text: '',
                        style: {
                            fontSize: '18px'
                        }
                    },
                    series: seriesedont,
                    labels: Object.values(fullNames),
                    legend: {
                        position: 'left',
                        offsetY: 80
                    }
                };

                if (work_orders_THIS_YEAR) {
                    work_orders_THIS_YEAR.updateSeries(seriesedont);
                    work_orders_THIS_YEAR.updateOptions({
                            labels: Object.values(fullNames),
                            colors: colorPalette, // Make sure colorPalette is defined in this scope
                        });
                    }



            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Week': [moment().startOf('week'), moment().endOf('week')],
			'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'This Quarter': [moment().startOf('quarter'), moment().endOf('quarter')],
			'Last Quarter': [moment().subtract(1, 'quarter').startOf('quarter'), moment().subtract(1, 'quarter').endOf('quarter')],
			'This Year': [moment().startOf('year'), moment().endOf('year')],
			'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
			'Past 6 Months': [moment().subtract(6, 'months'), moment()]
        }
    }, cb);

    cb(start, end);

    

    $('#THIS_YEAR_STATUS').on('change', function(event) {
        cb(start, end);
    });






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
<script>
			

var options = {
    series: [<?php foreach ($status_boxes as $status_box) { 
		if($status_box['name']=='lang:work_orders_new' || $status_box['name']=='lang:work_orders_in_progress' || $status_box['name']=='lang:work_orders_out_for_repair' || $status_box['name']=='lang:work_orders_waiting_on_customer'):
		?>
		<?php echo $status_box['total_number'] ?>, 
		
		<?php endif; } ?>], // Example data
    chart: {
        type: 'donut',
		width: '400',
		height: '180',
		events: {
        	dataPointSelection: function(event, chartContext, config) {
				// Identify the clicked slice
				const selectedSliceIndex = config.dataPointIndex;
				console.log(selectedSliceIndex);
				var url = '<?php echo base_url() ?>reports/generate/detailed_work_order?report_type=simple&report_date_range_simple=ALL_TIME&start_date_formatted=10/1/2023+12:00+am&with_time=1&end_date_end_of_day=0&sale_type=all&currency=&register_id=&email=&export_excel=0&select_all=1';
				switch (selectedSliceIndex) {
				    case 0:
						url = url + +'&status=1';
				        window.location.href = url;
				        break;
				    case 1:
						url = url + +'&status=2';
				        window.location.href = url;
				        break;
				    case 2:
						url = url + +'&status=3';
				        window.location.href = url;
				        break;
					case 3:
						url = url + +'&status=4';
				        window.location.href = url;
				        break;
				    default:
				        console.log('Unknown slice clicked.');
				}
			}
        }
    },
	colors: [<?php foreach ($status_boxes as $status_box) { 
			if($status_box['name']=='lang:work_orders_new' || $status_box['name']=='lang:work_orders_in_progress' || $status_box['name']=='lang:work_orders_out_for_repair' || $status_box['name']=='lang:work_orders_waiting_on_customer'):
			?>
			'<?php echo $status_box['color']; ?>', 
		<?php endif; } ?>], 
    labels: [  

		<?php foreach ($status_boxes as $status_box) { 
			if($status_box['name']=='lang:work_orders_new' || $status_box['name']=='lang:work_orders_in_progress' || $status_box['name']=='lang:work_orders_out_for_repair' || $status_box['name']=='lang:work_orders_waiting_on_customer'):
			?>
			'<?php echo $this->Work_order->get_status_name($status_box['name']); ?>', 
		<?php endif; } ?>
	
	], // Corresponding labels for the data
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 1400
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};

var chart = new ApexCharts(document.querySelector("#donutChart"), options);
chart.render();


var options2 = {
    series: [<?php foreach ($status_boxes as $status_box) { 
		if($status_box['name']=='lang:work_orders_new' || $status_box['name']=='lang:work_orders_repaired' || $status_box['name']=='lang:work_orders_complete' || $status_box['name']=='lang:work_orders_cancelled'):
		?>
		<?php echo $status_box['total_number'] ?>, 
		
		<?php endif;  } ?>], // Example data
    chart: {
        type: 'donut',
		width: '400',
		height: '180',
		events: {
        	dataPointSelection: function(event, chartContext, config) {
				// Identify the clicked slice
				var url = '<?php echo base_url() ?>reports/generate/detailed_work_order?report_type=simple&report_date_range_simple=ALL_TIME&start_date_formatted=10/25/2023+12:00+am&with_time=1&end_date_end_of_day=0&sale_type=all&currency=&register_id=&email=&export_excel=0&select_all=1';
				const selectedSliceIndex = config.dataPointIndex;
				console.log(selectedSliceIndex);
				switch (selectedSliceIndex) {
				    case 0:
						url = url + +'&status=1';
				        window.location.href = url;
				        break;
				    case 1:
						url = url + +'&status=5';
				        window.location.href = url;
				        break;
				    case 2:
				        url = url + +'&status=6';
				        window.location.href = url;
				        break;
					case 3:
				        url = url + +'&status=7';
				        window.location.href = url;
				        break;
				    default:
				        console.log('Unknown slice clicked.');
				}
			}
        }
    },
	colors: [	<?php foreach ($status_boxes as $status_box) { 
			if($status_box['name']=='lang:work_orders_new' || $status_box['name']=='lang:work_orders_repaired' || $status_box['name']=='lang:work_orders_complete' || $status_box['name']=='lang:work_orders_cancelled'):
			?>
			'<?php echo $status_box['color']; ?>', 
		<?php  endif; } ?>], 
    labels: [  

		<?php foreach ($status_boxes as $status_box) { 
			if($status_box['name']=='lang:work_orders_new' || $status_box['name']=='lang:work_orders_repaired' || $status_box['name']=='lang:work_orders_complete' || $status_box['name']=='lang:work_orders_cancelled'):
			?>
			'<?php echo $this->Work_order->get_status_name($status_box['name']); ?>', 
		<?php  endif; } ?>
	
	], // Corresponding labels for the data
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 1400
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};

var chart2 = new ApexCharts(document.querySelector("#donutChart2"), options2);
chart2.render();


</script>


</div>
<?php $this->load->view("partial/footer"); ?>