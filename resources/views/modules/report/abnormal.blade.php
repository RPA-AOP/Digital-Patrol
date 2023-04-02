@extends('layouts/layoutMaster')
@section('title', 'Patrol Report')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet"
          href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>
@endsection

@section('content')
    <!-- list start -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table" id="table-report-abnormal">
            </table>
        </div>
    </div>
@endsection

@section('page-script')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
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
