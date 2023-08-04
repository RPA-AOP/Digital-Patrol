@extends('layouts/layoutMaster')

@section('title', 'User Profile - Profile')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet"
          href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
@endsection

<!-- Page -->
@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-profile.css')}}"/>
@endsection


@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('page-script')
    {{--      <script src="{{asset('assets/js/pages/profile.js')}}"></script>--}}
    <script>
        $('#table-user-report-patrol').DataTable({
            ajax: "{{route('management-user.user-list-patrol', ['id'=>$user->id_user])}}",
            responsive: false,
            columns: [
                {
                    data: 'id_report_patrol',
                    render: function (item, data, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'user.name',
                    name: 'user.name',
                    title: 'NAMA'
                },
                {
                    data: 'user.npk',
                    name: 'user.npk',
                    title: 'NPK'
                },
                {
                    data: 'company.company_name',
                    name: 'company.company_name',
                    title: 'PERUSAHAAN'
                },
                {
                    data: 'patrol_shift.shift_name',
                    name: 'patrol_shift.shift_name',
                    title: 'SHIFT'
                },
                {
                    data: 'patrol_start_time',
                    name: 'patrol_start_time',
                    title: 'Waktu Mulai',
                    render: function (item) {
                        return moment(item).format('DD MMMM YYYY, HH:mm:ss')
                    }
                },
                {
                    data: 'patrol_end_time',
                    name: 'patrol_end_time',
                    title: 'Waktu Berakhir',
                    render: function (item) {
                        if (item)
                            return moment(item).format('DD MMMM YYYY, HH:mm:ss')
                        return '-'
                    }

                },
                {
                    data: 'id_report_patrol',
                    name: 'id_report_patrol',
                    title: 'Action',
                    sortable: false,
                    searchable: false,
                    render: function (item, data, row) {
                        @if($permission->has_create)
                            return ('<div class="d-flex align-items-center">' +
                            '<a href="{{ url('report-patrol/detail/') }}/' + row.id_patrol_activity + '" class="text-body"><i class="ti ti-edit ti-sm me-2"></i></a>' +
                            '</div>')
                        @endif
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
        $('div.head-label').html('<h5 class="card-title mb-0">User Patrol Report</h5>');
    </script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">User Profile /</span> Profile
    </h4>


    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="user-profile-header-banner">
                    <img src="{{ asset('assets/img/pages/profile-banner.png') }}" alt="Banner image"
                         class="rounded-top">
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="{{ $user->image?? asset('assets/img/avatars/no-img.png') }}" alt="user image"
                             class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img bg-white">
                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div
                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <h4>{{$user->name}}</h4>
                                <ul
                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item">
                                        <i class='ti ti-color-swatch'></i> {{$user->userGroup->name }}
                                    </li>
                                    <li class="list-inline-item">
                                        <i class='ti ti-map-pin'></i> {{$user->company->company_name??"-" }}
                                    </li>
                                    <li class="list-inline-item">
                                        <i class='ti ti-calendar'></i> Join
                                        at {{$user->created_at->toFormattedDateString() }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Header -->


    <!-- User Profile Content -->
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5">
            <!-- About User -->
            <div class="card mb-4">
                <div class="card-body">
                    <small class="card-text text-uppercase">About</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3"><i class="ti ti-user"></i><span
                                class="fw-bold mx-2">Full Name:</span> <span>{{$user->name}}</span></li>
                        <li class="d-flex align-items-center mb-3"><i class="ti ti-file-description"></i><span
                                class="fw-bold mx-2">NPK:</span>
                            <span>{{$user->npk}}</span></li>
                        <li class="d-flex align-items-center mb-3"><i class="ti ti-check"></i><span
                                class="fw-bold mx-2">Status:</span> <span>{{$user->status==1?'Active':'Suspend'}}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3"><i class="ti ti-crown"></i><span
                                class="fw-bold mx-2">Role:</span> <span>{{$user->userGroup->name??'-'}}</span></li>
                        <li class="d-flex align-items-center mb-3"><i class="ti ti-flag"></i><span
                                class="fw-bold mx-2">Company:</span> <span>{{$user->company->company_name??'-'}}</span>
                        </li>

                    </ul>
                    <small class="card-text text-uppercase">Contacts</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3"><i class="ti ti-phone-call"></i><span
                                class="fw-bold mx-2">Contact:</span>
                            <span>{{$user->phone??'-'}}</span></li>
                        <li class="d-flex align-items-center mb-3"><i class="ti ti-mail"></i><span
                                class="fw-bold mx-2">Email:</span> <span>{{$user->email??'-'}}</span></li>
                    </ul>
                </div>
            </div>
            <!--/ About User -->
            <!-- Profile Overview -->
            <div class="card mb-4">
                <div class="card-body">
                    <p class="card-text text-uppercase">Patrol Overview</p>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-center mb-3"><i class="ti ti-check"></i><span
                                class="fw-bold mx-2">Patrol Compiled:</span>
                            <span>{{$summary['total_patroli']}}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3"><i class="ti ti-layout-grid"></i><span
                                class="fw-bold mx-2">Patrol Achievement Compiled:</span>
                            <span>{{$summary['percentage_patroli']}}%</span>
                        </li>
                        <li class="d-flex align-items-center"><i class="ti ti-users"></i><span
                                class="fw-bold mx-2">Patrol Abnormality founding:</span>
                            <span>{{$summary['total_abnormality']}}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!--/ Profile Overview -->
        </div>
        <div class="col-xl-8 col-lg-7 col-md-7">
            <!-- Projects table -->
            <div class="card mb-4">
                <div class="card-datatable table-responsive">
                    <table class="datatables-basic table" id="table-user-report-patrol">
                    </table>
                </div>
            </div>
            <!--/ Projects table -->
        </div>
    </div>
    <!--/ User Profile Content -->
@endsection
