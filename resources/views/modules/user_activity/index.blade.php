@extends('layouts/layoutMaster')
@section('title', 'List Users')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
    <style>
        pre {
            outline: 1px solid #ccc;
            padding: 5px;
            margin: 5px;
            background-color: #333333;
        }

        .string {
            color: green;
        }

        .number {
            color: darkorange;
        }

        .boolean {
            color: blue;
        }

        .null {
            color: magenta;
        }

        .key {
            color: red;
        }

    </style>
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
    <div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalScrollableTitle">Detail Property</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <pre id="modal-content" class="pre">

                    </pre>
                </div>
            </div>
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
            processing: true,
            serverSide: true,
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
                    title: 'DESCRIPTION',
                    render: function (item, row, full) {
                        return `
                        <p style="height: 200px; width: 300px" class="overflow-auto">
                          ${item}
                        </p>`
                    }
                },
                {
                    data: 'event',
                    name: 'event',
                    title: 'EVENT',
                    render: function (item, row, full) {
                        return `<span class="badge bg-label-primary">${item}</span>`
                    }
                },
                {
                    data: 'properties',
                    name: 'properties',
                    title: 'PROPERTIES',
                    render: function (item, row, full) {
                        return `
                        <button
                          type="button"
                          class="btn btn-sm btn-primary"
                          data-bs-toggle="modal"
                          data-bs-target="#modalScrollable"
                          onclick="showContent('${item}')"
                        >
                          Detail Property
                        </button>`
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
            buttons: [],

        });
        $('div.head-label').html('<h5 class="card-title mb-0">Activity Report</h5>');


        function syntaxHighlight(json) {
            if (typeof json != "string") {
                json = JSON.stringify(json, null, "\t");
            }

            json = json
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;");

            return json.replace(
                /("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g,
                function(match) {
                    var cls = "number";
                    if (/^"/.test(match)) {
                        if (/:$/.test(match)) {
                            cls = "key";
                        } else {
                            cls = "string";
                        }
                    } else if (/true|false/.test(match)) {
                        cls = "boolean";
                    } else if (/null/.test(match)) {
                        cls = "null";
                    }
                    return '<span class="' + cls + '">' + match + "</span>";
                }
            );
        }



        function showContent(item) {
            item = item.replaceAll('["','')
            item = item.replaceAll('"]','')
            let str = syntaxHighlight(JSON.parse(item));
            $('#modal-content').html(str)
        }
    </script>
@endsection
