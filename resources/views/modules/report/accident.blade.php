@extends('layouts/layoutMaster')
@section('title', 'Accident Report')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet"
          href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/magnific-popup/magnific-popup.css')}}"/>

@endsection

@section('content')
    <!-- list start -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table" id="table-report-patrol">
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
    <script src="{{asset('assets/vendor/libs/magnific-popup/magnific-popup.min.js')}}"></script>

    <script nonce="{{ csp_nonce() }}">
        $('#table-report-patrol').DataTable({
            ajax: "{{route('report.accident.list')}}",
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
                    title: 'USER'
                },
                {
                    data: 'company.company_name',
                    name: 'company.company_name',
                    title: 'PERUSAHAAN',
                    render: function (item, data, row, meta) {
                        if (item) {
                            return item
                        }
                        return '-'
                    }
                },
                {
                    data: 'title',
                    name: 'title',
                    title: 'KEJADIAN'
                },
                {
                    data: 'description',
                    name: 'description',
                    title: 'DESKRIPSI'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    title: 'Waktu Laporan',
                    render: function (item) {
                        return moment(item).format('DD MMMM YYYY, HH:mm:ss')
                    }
                },
                {
                    data: 'attachment',
                    name: 'attachment',
                    title: 'Lampiran',
                    render: function (data, type, row, meta) {
                        if (data) {
                            let thumb = ``;
                            $.each(data, function (k, v) {
                                console.log()
                                let path = "{{url('report-patrol/preview')}}?path="+v.path
                                 thumb += `
                                    <div class="avatar">
                                        <a href="${path}"
                                            title="${row.title}"
                                            data-note="${row.description}">
                                        <img
                                            src="${path}"
                                            alt="Avatar"
                                            class="rounded-circle pull-up"
                                            title="${row.title}"
                                            data-note="${row.description}">
                                        </a>
                                    </div>
                                    `;
                            })
                            return  `<div class="d-flex align-items-center avatar-group thumb_${row.report_accident_id}">${thumb}</div>`;
                        }
                        return '-';
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
            initComplete: function () {
                // init popup once table initialized
                this.api()
                    .rows()
                    .every(function (rowIdx, tableLoop, rowLoop) {
                        let row = this.data();
                        $(`.thumb_${row.report_accident_id}`).magnificPopup({
                            delegate: 'a',
                            type: 'image',
                            tLoading: 'Loading image #%curr%...',
                            mainClass: 'mfp-img-mobile',
                            gallery: {
                                enabled: true,
                                navigateByImgClick: true,
                                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                            },
                            image: {
                                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                                titleSrc: function (item) {
                                    return item.el.attr('title') + '<small>' + item.el.data('note') + '</small>';
                                }
                            }
                        });
                    });
            }

        });
        $('div.head-label').html('<h5 class="card-title mb-0">Laporan Kejadian</h5>');

    </script>
@endsection
