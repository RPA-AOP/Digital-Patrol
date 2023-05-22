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
    <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>


    <script>
        $('#table-report-abnormal').DataTable({
            ajax: "{{route('report.abnormal.list')}}",
            responsive: false,
            columns: [
                {
                    data: 'id_report_patrol_detail',
                    render: function (item, data, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'company.company_name',
                    name: 'company.company_name',
                    title: 'PERUSAHAAN'
                },
                {
                    data: 'object.name',
                    name: 'object.name',
                    title: 'NAMA OBJEK'
                },
                {
                    data: 'patrol_note',
                    name: 'patrol_note',
                    title: 'CATATAN',
                    render: function (item, row, full) {
                        if (full.report_ga) {
                            return 'Repot KE PIC/GA'
                        }
                        if (full.quick_action) {
                            return full.quick_action_note
                        }
                        return item
                    }
                },
                {
                    data: 'report_ga',
                    name: 'report_ga',
                    title: 'SHIFT'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    title: 'Create at',
                    render: function (item) {
                        return moment(item).format('DD MMMM YYYY, HH:mm:ss')
                    }
                },
            ],
            order: [[0, 'asc']],
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: '_MENU_',
                search: '',
                searchPlaceholder: 'Search..',
            },
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-label-primary btn-sm dropdown-toggle ms-2',
                    text: '<i class="ti ti-file-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
                    buttons: [
                        {
                            extend: 'print',
                            text: '<i class="ti ti-printer me-1" ></i>Print',
                            className: 'dropdown-item',
                        },
                        {
                            extend: 'csv',
                            text: '<i class="ti ti-file-text me-1" ></i>Csv',
                            className: 'dropdown-item'
                        },
                        {
                            extend: 'excel',
                            text: '<i class="ti ti-file-spreadsheet me-1"></i>Excel',
                            className: 'dropdown-item',

                        },
                        {
                            extend: 'pdf',
                            text: '<i class="ti ti-file-description me-1"></i>Pdf',
                            className: 'dropdown-item',

                        },
                        {
                            extend: 'copy',
                            text: '<i class="ti ti-copy me-1" ></i>Copy',
                            className: 'dropdown-item',
                        }
                    ]
                }
            ],

        });
        $('div.head-label').html('<h5 class="card-title mb-0">Abnormality Report</h5>');

    </script>
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

    <script>
        function getData(param, callback) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: '{{route('dashboard.chart')}}',
                method: 'GET',
                data: param,
                dataType: "JSON",
                success: function (resp) {
                    if (resp.data) {
                        callback(resp)
                    }
                }
            });
        }
    </script>
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

        <div class="col-12 order-1 order-lg-2 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-basic table" id="table-report-abnormal">
                    </table>
                </div>
            </div>
        </div>
        <!--/ Projects table -->
    </div>

@endsection
