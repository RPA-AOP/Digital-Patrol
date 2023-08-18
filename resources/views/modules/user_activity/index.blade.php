@extends('layouts/layoutMaster')
@section('title', 'List Users')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('user') }}
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <!-- Role Table -->
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table border-top table-sm" id="table-activity">

                    </table>
                </div>
            </div>
            <!--/ Role Table -->
        </div>
    </div>

@endsection

@section('vendor-script')
    <!-- BEGIN: Page Vendor JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js" nonce="{{csp_nonce()}}"></script>

    <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>


    <!-- END: Page Vendor JS-->
@endsection

@section('page-script')
    <script nonce="{{csp_nonce()}}">
        $('#table-activity').DataTable({
            ajax: "{{route('management-user.activity_list')}}",
            responsive: false,
            columns: [
                {
                    data: 'id',
                    render: function (item, data, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    title: 'LOG TIME',
                    width: '30%',
                    render: function (item) {
                        return `<p>${moment(item).format('DD MMMM YYYY, HH:mm:ss')}</p>`
                    }
                },
                {
                    data: 'log_name',
                    name: 'log_name',
                    title: 'LOG TYPE'
                },
                {
                    data: 'description',
                    name: 'description',
                    title: 'DESCRIPTION'
                },
                {
                    data: 'event',
                    name: 'event',
                    title: 'EVENT',
                    render: function (item, row, full) {
                        return item
                    }
                },
                {
                    data: 'properties',
                    name: 'properties',
                    title: 'PROPERTIES',
                    render: function (item,row, full) {
                        return `
                        <div style="width: 400px">
                            <a class="btn btn-outline-primary  btn-sm me-1 waves-effect waves-light collapsed" data-bs-toggle="collapse" href="#collapse_property_${full['id']}" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Detail Property </a>
                            <div class="collapse mt-1" id="collapse_property_${full['id']}" style="">
                                  <pre>${JSON.stringify(item, undefined, 2)}</pre>
                            </div>
                        </>`
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
            ],

        });
        $('div.head-label').html('<h5 class="card-title mb-0">Activity Report</h5>');

    </script>
@endsection
