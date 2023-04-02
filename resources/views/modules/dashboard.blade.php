@extends('layouts/layoutMaster')

@section('title', 'Analytics')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/swiper/swiper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}"/>
    <link rel="stylesheet"
          href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}"/>
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/cards-advance.css')}}">
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/swiper/swiper.js')}}">
    </script>
    <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('page-script')

    <script>
        let cardColor, headingColor, labelColor, shadeColor, grayColor;
        if (isDarkStyle) {
            cardColor = config.colors_dark.cardColor;
            labelColor = config.colors_dark.textMuted;
            headingColor = config.colors_dark.headingColor;
            shadeColor = 'dark';
            grayColor = '#5E6692'; // gray color is for stacked bar chart
        } else {
            cardColor = config.colors.cardColor;
            labelColor = config.colors.textMuted;
            headingColor = config.colors.headingColor;
            shadeColor = '';
            grayColor = '#817D8D';
        }

        // --------------------------------------------------------------------
        const supportTrackerEl = document.querySelector('#supportTracker'),
            supportTrackerOptions = {
                series: [{{$today['percentage']}}],
                labels: ['Rata-rata penyelesaian patroli'],
                chart: {
                    height: 360,
                    type: 'radialBar'
                },
                plotOptions: {
                    radialBar: {
                        offsetY: 10,
                        startAngle: -140,
                        endAngle: 130,
                        hollow: {
                            size: '65%'
                        },
                        track: {
                            background: cardColor,
                            strokeWidth: '100%'
                        },
                        dataLabels: {
                            name: {
                                offsetY: -20,
                                color: labelColor,
                                fontSize: '13px',
                                fontWeight: '400',
                                fontFamily: 'Public Sans'
                            },
                            value: {
                                offsetY: 10,
                                color: headingColor,
                                fontSize: '38px',
                                fontWeight: '600',
                                fontFamily: 'Public Sans'
                            }
                        }
                    }
                },
                colors: [config.colors.primary],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        shadeIntensity: 0.5,
                        gradientToColors: [config.colors.primary],
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 0.6,
                        stops: [30, 70, 100]
                    }
                },
                stroke: {
                    dashArray: 10
                },
                grid: {
                    padding: {
                        top: -20,
                        bottom: 5
                    }
                },
                states: {
                    hover: {
                        filter: {
                            type: 'none'
                        }
                    },
                    active: {
                        filter: {
                            type: 'none'
                        }
                    }
                },
                responsive: [
                    {
                        breakpoint: 1025,
                        options: {
                            chart: {
                                height: 330
                            }
                        }
                    },
                    {
                        breakpoint: 769,
                        options: {
                            chart: {
                                height: 280
                            }
                        }
                    }
                ]
            };
        if (typeof supportTrackerEl !== undefined && supportTrackerEl !== null) {
            const supportTracker = new ApexCharts(supportTrackerEl, supportTrackerOptions);
            supportTracker.render();
        }
    </script>
    <script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
    <script src="{{asset('assets/js/cards-statistics.js')}}"></script>
@endsection

@section('content')

    <div class="row">
        <!-- Support Tracker -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Laporan Patroli Hari Ini</h5>
                        {{--            <small class="text-muted">Last 7 Days</small>--}}
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="supportTrackerMenu" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="supportTrackerMenu">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-12 col-lg-4">
                            <div class="mt-lg-4 mt-lg-2 mb-lg-4 mb-2 pt-1">
                                <h1 class="mb-0">{{$today['objectAbnormal']}}</h1>
                                <p class="mb-0">Total Objek Abnormal</p>
                            </div>
                            <ul class="p-0 m-0">
                                <li class="d-flex gap-3 align-items-center mb-lg-3 pt-2 pb-1">
                                    <div class="badge rounded bg-label-primary p-1"><i
                                            class="ti ti-circle-check ti-sm"></i></div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Objek Normal</h6>
                                        <small class="text-muted">{{$today['objectNormal']}}</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center mb-lg-3 pb-1">
                                    <div class="badge rounded bg-label-info p-1"><i class="ti ti-clock ti-sm"></i></div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Tindakan Cepat</h6>
                                        <small class="text-muted">{{$today['quickAction']}}</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center pb-1">
                                    <div class="badge rounded bg-label-warning p-1"><i class="ti ti-report ti-sm"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Laporkan PIC/GA</h6>
                                        <small class="text-muted">{{$today['reportPic']}}</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-8 col-md-12 col-lg-8">
                            <div id="supportTracker"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Support Tracker -->

        <!-- Earning Reports -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Patrol Report</h5>
                        <small class="text-muted">Last week report</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="earningReportsId" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsId">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4 d-flex flex-column align-self-end">
                            <div class="d-flex gap-1 align-items-center mb-2 pb-1 flex-wrap">
                                <h1 class="mb-0">{{$totalPatrolReport['abnormality']}}</h1>
                                {{--                                <div class="badge rounded bg-label-danger">+4.2%</div>--}}
                            </div>
                            <small class="text-muted">You informed of this report compared to last week</small>
                        </div>
                        <div class="col-12 col-md-8">
                            <div id="weeklyEarningReports"></div>
                        </div>
                    </div>
                    <div class="border rounded p-3 mt-2">
                        <div class="row gap-4 gap-sm-0">
                            <div class="col-12 col-sm-4">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="badge rounded bg-label-primary p-1"><i
                                            class="ti ti-currency-dollar ti-sm"></i></div>
                                    <h6 class="mb-0">Objek Normal</h6>
                                </div>
                                <h4 class="my-2 pt-1">{{$totalPatrolReport['normalObject']}}</h4>
                                <div class="progress w-75" style="height:4px">
                                    <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="badge rounded bg-label-info p-1">
                                        <i class="ti ti-chart-pie-2 ti-sm"></i>
                                    </div>
                                    <h6 class="mb-0">Tindakan Cepat</h6>
                                </div>
                                <h4 class="my-2 pt-1">{{$totalPatrolReport['quickAction']}}</h4>
                                <div class="progress w-75" style="height:4px">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="badge rounded bg-label-danger p-1"><i
                                            class="ti ti-brand-paypal ti-sm"></i></div>
                                    <h6 class="mb-0">Objek Telah di Tangani</h6>
                                </div>
                                <h4 class="my-2 pt-1">{{$totalPatrolReport['solvedAbnormal']}}</h4>
                                <div class="progress w-75" style="height:4px">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 65%"
                                         aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Earning Reports -->

        <!-- Orders last week -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-header pb-3">
                    <h5 class="card-title mb-0">Abnormality</h5>
                    <small class="text-muted">Last week</small>
                </div>
                <div class="card-body">
                    <div id="ordersLastWeek"></div>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <h4 class="mb-0">124k</h4>
                        <small class="text-success">+12.6%</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales last year -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="card-title mb-0">Avg. Completion Patrol</h5>
                    <small class="text-muted">Last Year</small>
                </div>
                <div id="salesLastYear"></div>
                <div class="card-body pt-0">
                    <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                        <h4 class="mb-0">175k</h4>
                        <small class="text-danger">-16.2%</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profit last month -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                    <small class="text-muted">Last Month</small>
                </div>
                <div class="card-body">
                    <div id="profitLastMonth"></div>
                    <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                        <h4 class="mb-0">624k</h4>
                        <small class="text-success">+8.24%</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sessions Last month -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="card-title mb-0">Normal Object</h5>
                    <small class="text-muted">Last Month</small>
                </div>
                <div class="card-body">
                    <div id="sessionsLastMonth"></div>
                    <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                        <h4 class="mb-0">45.1k</h4>
                        <small class="text-success">+12.6%</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="col-lg-8 mb-4 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Statistics</h5>
                    <small class="text-muted">Updated 1 month ago</small>
                </div>
                <div class="card-body pt-2">
                    <div class="row gy-3">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-primary me-3 p-2"><i
                                        class="ti ti-chart-pie-2 ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">230k</h5>
                                    <small>Sales</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-users ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">8.549k</h5>
                                    <small>Customers</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-danger me-3 p-2"><i
                                        class="ti ti-shopping-cart ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">1.423k</h5>
                                    <small>Products</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-success me-3 p-2"><i
                                        class="ti ti-currency-dollar ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0">$9745</h5>
                                    <small>Revenue</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="col-lg-2 col-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="badge rounded-pill p-2 bg-label-danger mb-2"><i class="ti ti-briefcase ti-sm"></i></div>
                    <h5 class="card-title mb-2">97.8k</h5>
                    <small>Orders</small>
                </div>
            </div>
        </div>

        <!-- Reviews -->
        <div class="col-lg-2 col-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="badge rounded-pill p-2 bg-label-success mb-2"><i class="ti ti-message-dots ti-sm"></i>
                    </div>
                    <h5 class="card-title mb-2">3.4k</h5>
                    <small>Review</small>
                </div>
            </div>
        </div>

        <!-- Projects table -->
        <div class="col-12 order-1 order-lg-2 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="datatables-projects table border-top">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Name</th>
                            <th>Leader</th>
                            <th>Team</th>
                            <th class="w-px-200">Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!--/ Projects table -->
    </div>

@endsection
