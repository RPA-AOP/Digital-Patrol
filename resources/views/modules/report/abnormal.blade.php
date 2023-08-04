@php use App\Models\UserGroup; @endphp
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
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/magnific-popup/magnific-popup.css')}}"/>

@endsection

@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-basic table" id="table-report-abnormal">
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-basic table" id="table-report-abnormal-action">
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="abnormalAction" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-simple modal-add-new-cc">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Form tindakan objek abnormal</h3>
                        <p class="text-muted">Deskripsikan perbaikan pada objek abnormal</p>
                    </div>
                    <form id="formActionAbnormal" class="row g-3" action="{{route('report.abnormal.action')}}"
                          method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="id_report_patrol_detail" name="id_report_patrol_detail">
                        @csrf
                        <div class=" col-12">
                            <label for="action-at" class="form-label">Waktu Tindakan</label>
                            <input type="text"
                                   class="form-control"
                                   placeholder="DD-MM-YYYY HH:MM"
                                   id="action-at"
                                   required
                                   name="action_at"/>
                        </div>
                        <div class="col-12">
                            <label class="form-label w-100" for="actionNote">Catatan tindakan</label>
                            <div class="input-group input-group-merge">
                                <textarea id="actionNote"
                                          name="action_note"
                                          required
                                          class="form-control credit-card-mask"
                                          type="text"
                                          rows="8"
                                          placeholder="Catatan tindakan"></textarea>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="actionProof" class="form-label">Bukti tindakan</label>
                            <input class="form-control"
                                   required
                                   type="file"
                                   name="action_proof"
                                   accept="image/*"
                                   id="actionProof">
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Simpan</button>
                            <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal"
                                    aria-label="Close">Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
    <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>

    <script src="{{asset('assets/vendor/libs/magnific-popup/magnific-popup.min.js')}}"></script>

    <script nonce="{{ csp_nonce() }}">
        $('#action-at').flatpickr({
            enableTime: true,
            dateFormat: 'd-m-Y H:i'
        });
        $('#table-report-abnormal').DataTable({
            ajax: "{{route('report.abnormal.list', ['type'=>'abnormal'])}}",
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
                    data: 'quick_action',
                    name: 'quick_action',
                    title: 'STATUS TINDAKAN',
                    render: function (item, row, full) {
                        if (full.report_ga) {
                            if (full.action_status) {
                                return 'Telah diperbaiki PIC/GA'
                            }
                            return 'Belum ada tindakan PIC/GA'
                        } else if (full.quick_action) {
                            return 'Telah diperbaiki'
                        } else {
                            return 'Belum ada tindakan'
                        }
                    }
                },
                {
                    data: 'patrol_note',
                    name: 'patrol_note',
                    title: 'CATATAN',
                    render: function (item, row, full) {
                        if (full.report_ga) {
                            if (full.action_status) {
                                return full.action_note
                            }
                            return 'Repot KE PIC/GA'
                        }
                        if (full.quick_action) {
                            return full.quick_action_note
                        }
                        return item
                    }
                },


                {
                    data: 'created_at',
                    name: 'created_at',
                    title: 'Waktu temuan',
                    render: function (item) {
                        return moment(item).format('DD MMMM YYYY, HH:mm:ss')
                    }
                },
                    @if(Arr::has([UserGroup::ADMIN_COMPANY, UserGroup::ADMIN_COMPANY], auth()->user()->id_user_group))
                {
                    data: 'id_report_patrol_detail',
                    name: 'id_report_patrol_detail',
                    title: 'Aksi',
                    render: function (item, row, full) {
                        if (full.report_ga && !full.action_status) {
                            return `<button type="button" data-report-detail-id="${item}" class="btn btn-sm btn-label-primary waves-effect btn-action-modal"  data-bs-toggle="modal" data-bs-target="#abnormalAction">
                                  <span class="ti-xs ti ti-edit me-1"></span>Tindakan
                                </button>`
                        }
                        return ''
                    }
                },
                @endif
            ],
            order: [[0, 'asc']],
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center head-abnormal"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
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
        $('div.head-label.head-abnormal').html('<h5 class="card-title mb-0">Abnormality Report</h5>');

        $('#table-report-abnormal-action').DataTable({
            ajax: "{{route('report.abnormal.list',['type'=>'action'])}}",
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
                    data: 'quick_action',
                    name: 'quick_action',
                    title: 'STATUS TINDAKAN',
                    render: function (item, row, full) {
                        if (full.report_ga) {
                            if (full.action_status) {
                                return 'Telah diperbaiki PIC/GA'
                            }
                            return 'Belum ada tindakan PIC/GA'
                        } else if (full.quick_action) {
                            return 'Langsung diperbaiki Anggota'
                        } else {
                            return 'Belum ada tindakan'
                        }
                    }
                },
                {
                    data: 'patrol_note',
                    name: 'patrol_note',
                    title: 'CATATAN',
                    render: function (item, row, full) {
                        if (full.report_ga) {
                            if (full.action_status) {
                                return full.action_note
                            }
                            return 'Repot KE PIC/GA'
                        }
                        if (full.quick_action) {
                            return full.quick_action_note
                        }
                        return item
                    }
                },


                {
                    data: 'created_at',
                    name: 'created_at',
                    title: 'Waktu temuan',
                    render: function (item) {
                        return moment(item).format('DD MMMM YYYY, HH:mm:ss')
                    }
                },
                {
                    data: 'action_at',
                    name: 'action_at',
                    title: 'WAKTU TINDAKAN',
                    render: function (item, row, full) {
                        if (full.report_ga)
                            return moment(item).format('DD MMMM YYYY, HH:mm:ss')
                        if (full.quick_action)
                            return moment(full.created_at).format('DD MMMM YYYY, HH:mm:ss')

                    }
                },
                {
                    data: 'action_user',
                    name: 'action_user',
                    title: 'PELAKSANA',
                    render: function (data, type, row, meta) {
                        if (row.quick_action)
                            return row.report_patrol.activity.user.name
                        if (data)
                            return data.name

                        return ''
                    }
                },
                {
                    data: 'action_proof',
                    name: 'action_proof',
                    title: 'Bukti Lampiran',
                    className: 'text-center',
                    render: function (data, type, row, meta) {
                        let path = "{{url('report-patrol/preview')}}?path=" + data
                        let title = `BUKTI LAMPIRAN TINDAKAN OBJEK ${row.object.name}`;
                        let description = row.action_note;
                        if (row.quick_action) {
                            description = row.quick_action_note
                            if (row.files.length > 0)
                                path = "{{url('report-patrol/preview')}}?path=" + row.files[0].path
                        }
                        let thumb = `
                                    <div class="avatar">
                                        <a href="${path}"
                                            title="${title}"
                                            data-note="${description}">
                                        <img
                                            src="${path}"
                                            alt="Avatar"
                                            class="rounded-circle pull-up"
                                            title="${title}"
                                            data-note="${description}">
                                        </a>
                                    </div>
                                    `;
                        return `<div class="d-flex align-items-center justify-content-center avatar-group thumb_${row.id_report_patrol_detail}">${thumb}</div>`;

                    }
                },

            ],
            order: [[0, 'asc']],
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center head-action"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
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
                        $(`.thumb_${row.id_report_patrol_detail}`).magnificPopup({
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
        $('div.head-label.head-action').html('<h5 class="card-title mb-0">Tindakan Abnormality Report</h5>');

        let modalAction = document.getElementById('abnormalAction');
        $(document).on('click', '.btn-action-modal', function () {
            let idReportDetail = $(this).data('report-detail-id')
            $("#id_report_patrol_detail").val(idReportDetail)

        });
        modalAction.addEventListener('show.bs.modal', function (event) {
            $("#id_report_patrol_detail").val()
            $('#formActionAbnormal').get(0).reset()
        });
    </script>
@endsection
