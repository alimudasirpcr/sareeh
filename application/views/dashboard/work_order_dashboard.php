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
                    <span class="card-label fw-bold text-dark">Sales This Months</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Users from all channels</span>
                </h3>
                <!--end::Title-->>
            </div>
            <!--end::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                <!--begin::Statistics-->
                <div class="px-9 mb-5">
                    <!--begin::Statistics-->
                    <div class="d-flex mb-2">
                        <span class="fs-4 fw-semibold text-gray-400 me-1">$</span>
                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">14,094</span>
                    </div>
                    <!--end::Statistics-->
                    <!--begin::Description-->
                    <span class="fs-6 fw-semibold text-gray-400">Another $48,346 to Goal</span>
                    <!--end::Description-->
                </div>
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div id="chart_wrapper">
					<div id="chart-legend" class="chart-legend"></div>
					<!-- <canvas id="chart"></canvas> -->
					<div id="chart"> </div>
				</div>

                <script>
                    $(document).ready(function () {
                        $.ajax({
                            type: "GET",
                            url: "http://localhost/sareeh/reports/generate_ajax/graphical_summary_work_order?tier_id=&report_type=simple&report_date_range_simple=ALL_TIME&start_date=&end_date=&with_time=1&end_date_end_of_day=0&item_id=&category_id=0&payment_type=&sale_type=all&group_by=&location_ids%5B%5D=1&company=All&business_type=All&items%5B%5D=pos&items%5B%5D=items&items%5B%5D=receivings&items%5B%5D=customers",
                            success: function (response) {
                               var data =  JSON.parse(response);
                               
                                var indicesArray = Object.keys(data.output_data.data);
                                var dataset = Object.values(data.output_data.data);

                                console.log(JSON.stringify(indicesArray) );
                                console.log(JSON.stringify(dataset) );
                            var element = document.getElementById('chart');

                            var height = parseInt(KTUtil.css(element, 'height'));
                            var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
                            var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
                            var baseColor = KTUtil.getCssVariableValue('--kt-info');
                            var lightColor = KTUtil.getCssVariableValue('--kt-info-light');


                            var options = {
                                series: [{
                                    name: data.output_data.title,
                                    data: JSON.stringify(dataset)
                                }],
                                chart: {
                                    fontFamily: 'inherit',
                                    type: 'area',
                                    height: height,
                                    toolbar: {
                                        show: false
                                    }
                                },
                                plotOptions: {

                                },
                                legend: {
                                    show: false
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
                                    colors: [baseColor]
                                },
                                xaxis: {
                                    categories: JSON.stringify(indicesArray),
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
                                            return '$' + val + ' thousands'
                                        }
                                    }
                                },
                                colors: [lightColor],
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
                    });
                   
</script>
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Chart widget 3-->
    </div>
    <!--end::Col-->
</div>
<?php $this->load->view("partial/footer"); ?>