@php use App\Helpers\Constant; @endphp
@extends('layouts/layoutMaster')
@section('title', 'Cetak Dokumen Rencana Kegiatan')

@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/app-user.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendor/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/app-file-manager.css') }}">
@endsection
@section('vendor-style')
    <style>
        .group_0 td {
            padding-left: 1rem !important;
            background-color: #7b71df;
            color: #fff;
        }
    </style>
@endsection
@section('breadcrumbs')
    {{  Breadcrumbs::render('rencana-kegiatan.show')  }}
@endsection

@section('content')
    <section class="app-user-view">
        <!-- User Card & Plan Starts -->
        <div class="row">
            <div class="col-9">
                <!-- User Card starts-->
                <div class="col-12">
                    <div class="card user-card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Detail Rencana Kegiatan</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- START NO SIRUP--}}
                                <div class="col-lg-12 mt-2 mt-xl-1">
                                    <div class="user-info-wrapper">
                                        <div class="d-flex flex-wrap">
                                            <div class="user-info-title">
                                                <span class="card-text user-info-title font-weight-bold mb-0">Nomor SIRUP</span>
                                            </div>
                                            <p class="card-text mb-0">: {{$rencanaKegiatan->no_sirup}}</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- END  NO SIRUP--}}
                                {{-- START METODE--}}
                                <div class="col-lg-12 mt-2 mt-xl-1">
                                    <div class="user-info-wrapper">
                                        <div class="d-flex flex-wrap">
                                            <div class="user-info-title">
                                                <span class="card-text user-info-title font-weight-bold mb-0">Metode Pengadaan</span>
                                            </div>
                                            <p class="card-text mb-0">
                                                : {{ Constant::METODE_PENGADAAN[$rencanaKegiatan->metode_pengadaan]}}</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- END METODE--}}
                                {{-- START JENIS--}}
                                <div class="col-lg-12 mt-2 mt-xl-1">
                                    <div class="user-info-wrapper">
                                        <div class="d-flex flex-wrap">
                                            <div class="user-info-title">
                                                <span
                                                    class="card-text user-info-title font-weight-bold mb-0">Jenis Pengadaan</span>
                                            </div>
                                            <p class="card-text mb-0">
                                                : {{ Constant::JENIS_PENGADAAN[$rencanaKegiatan->jenis_pengadaan]}}</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- END JENIS--}}
                                {{-- START PROGRAM--}}
                                <div class="col-lg-12 mt-2 mt-xl-1">
                                    <div class="user-info-wrapper">
                                        <div class="d-flex flex-wrap">
                                            <div class="user-info-title">
                                                <span
                                                    class="card-text user-info-title font-weight-bold mb-0">Program</span>
                                            </div>
                                            <p class="card-text mb-0">: <span
                                                    class="card-text user-info-title font-weight-bold mb-0">{{ $rencanaKegiatan->program->kode }}</span> {{ $rencanaKegiatan->program->nama }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                {{-- END PROGRAM--}}
                                {{-- START KEGIATAN--}}
                                <div class="col-lg-12 mt-2 mt-xl-1">
                                    <div class="user-info-wrapper">
                                        <div class="d-flex flex-wrap">
                                            <div class="user-info-title">
                                                <span
                                                    class="card-text user-info-title font-weight-bold mb-0">Kegiatan</span>
                                            </div>
                                            <p class="card-text mb-0">: <span
                                                    class="card-text user-info-title font-weight-bold mb-0">{{ $rencanaKegiatan->kegiatan->kode }}</span> {{$rencanaKegiatan->kegiatan->nama}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                {{-- END KEGIATAN--}}
                                {{-- START SUB KEGIATAN--}}
                                <div class="col-lg-12 mt-2 mt-xl-1">
                                    <div class="user-info-wrapper">
                                        <div class="d-flex flex-wrap">
                                            <div class="user-info-title">
                                                <span class="card-text user-info-title font-weight-bold mb-0">Sub Kegiatan</span>
                                            </div>
                                            <p class="card-text mb-0">: <span
                                                    class="card-text user-info-title font-weight-bold mb-0">{{$rencanaKegiatan->subKegiatan->kode}}</span> {{$rencanaKegiatan->subKegiatan->nama}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                {{-- END SUB KEGIATAN--}}
                                {{-- START RINCIAN AKTIFITAS--}}
                                <div class="col-lg-12 mt-2 mt-xl-1">
                                    <div class="user-info-wrapper">
                                        <div class="d-flex flex-wrap">
                                            <div class="user-info-title">
                                                <span class="card-text user-info-title font-weight-bold mb-0">Rincian Aktifitas</span>
                                            </div>
                                            <p class="card-text mb-0">: <span
                                                    class="card-text user-info-title font-weight-bold mb-0">{{$rencanaKegiatan->rincianAktifitas->kode}}</span> {{ $rencanaKegiatan->rincianAktifitas->nama}}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- END RINCIAN AKTIFITAS--}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Rekening & Komponen</h4>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show card-datatable table-responsive">
                            <table class="table" id="table-detail-rencana-kegiatan"></table>
                        </div>
                    </div>
                </div>
                @include('modules.rencana_kegiatan.document_form.kak')
            </div>
            <div class="col-3">
                <!-- approval starts -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Approval</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="m-1 d-flex justify-content-center align-items-center">
                                <form class="form form-vertical w-100">
                                    <div class="form-group">
                                        <textarea type="text" id="catatan" class="form-control" autofocus="autofocus"
                                                  name="catatan" placeholder="Catatan"></textarea>
                                    </div>
                                    <div class="btn-group w-100" role="group" aria-label="Basic example">
                                        <button type="submit" value="approve" name="action" class="btn btn-primary">
                                            <i data-feather="check" class=""></i>
                                            <span>Setujui</span>
                                        </button>
                                        <button type="submit" value="reject" name="action" class="btn btn-danger">
                                            <i data-feather="x" class=""></i>
                                            <span>Tolak</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- approval Ends -->
                @if($docSirup)
                    <!-- lampiran starts -->
                    <div class="col-12">
                        <div class="card file-manager-item file">
                            <div class="card-img-top file-logo-wrapper p-2 bg-gradient-primary">
                                <div class="d-flex align-items-center justify-content-center w-100">
                                    <img src="{{asset('assets/images/icons/pdf.png')}}" alt="file-icon"
                                         height="35"/>
                                </div>
                            </div>
                            <div class="card-body p-1">
                                <div class="content-wrapper">
                                    <p class="card-text font-small-3 mb-0">{{$docSirup->nama_lampiran}}</p>
                                </div>
                                <a class="file-accessed text-muted" href="{{$docSirup->pathfile}}">Download</a>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- lampiran end -->
                <!-- timeline starts -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Timeline</h4>
                        </div>
                        <div class="card-body">
                            <ul class="timeline mt-1">
                                <li class="timeline-item">
                                    <span
                                        class="timeline-point  timeline-point-success timeline-point-indicator"></span>
                                    <div class="timeline-event">
                                        <div
                                            class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                            <h6>Rencana Kegiatan Dibuat</h6>
                                        </div>
                                        <span
                                            class="timeline-event-time">{{$rencanaKegiatan->created_at->diffForHumans()}}</span>
                                    </div>
                                </li>
                                @foreach($rencanaKegiatan->progress as $progress)
                                    <li class="timeline-item">
                                        <span class="timeline-point timeline-point-indicator"></span>
                                        <div class="timeline-event">
                                            <div
                                                class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                <h6>{{$progress->workflow->nama}}</h6>
                                            </div>
                                            <span
                                                class="timeline-event-time">{{$progress->created_at->diffForHumans()}}</span>

                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- timeline Ends -->
            </div>
        </div>
        <!-- User Card & Plan Ends -->
    </section>
@endsection

@section('vendor-script')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('assets/vendor/js/extensions/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/tables/datatable/buttons.bootstrap4.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
@endsection

@section('page-script')
    <script>
        let groupColumnIndex = [0, 1];
        var childTable = $('#table-detail-rencana-kegiatan').DataTable({
            data: {!! $rencanaKegiatan->detailRencanaKegiatan !!},
            columns: [
                {
                    data: 'subtitle',
                    title: 'Subtitle'
                },
                {
                    data: 'kode_rekening',
                    title: 'Kode Rekening',
                    render: function (data, type, row, meta) {
                        return row.kode_rekening + " " + row.nama_kode_rekening
                    }
                },
                {
                    data: 'kode_komponen',
                    title: 'Kode Komponen',
                    render: function (data, type, row, meta) {
                        return '<span class="pl-1">' + data + '</span>'
                    }
                },
                {
                    data: 'nama_komponen',
                    title: 'Nama Komponen'
                },
                {
                    data: 'volume',
                    title: 'Volume'
                },
                {
                    data: 'satuan',
                    title: 'Satuan'
                },
                {
                    data: 'harga_satuan',
                    title: 'Harga Satuan',
                    render: $.fn.dataTable.render.number('.', ',')

                },
                {
                    data: 'pph_ppn_satuan',
                    title: 'PPN',
                    render: $.fn.dataTable.render.number('.', ',')
                },
                {
                    data: 'total',
                    title: 'TOTAL',
                    render: $.fn.dataTable.render.number('.', ',')
                },
            ],
            order: [[1, 'asc']],
            dom:
                '<"d-flex justify-content-between align-items-center header-actions m-1 row mt-75"' +
                '<"col-lg-12 col-xl-6" l>' +
                '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '>',
            language: {
                sLengthMenu: 'Show _MENU_',
                search: '',
                searchPlaceholder: 'Search..',
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            displayLength: 5,
            lengthMenu: [5, 10, 25, 50],
            rowGroup: {
                dataSrc: groupColumnIndex,
                emptyDataGroup: null
            },
            columnDefs: [
                {visible: false, targets: groupColumnIndex},
            ],

            drawCallback: function (settings) {
                var api = this.api();
                var rows = api.rows({page: 'current'}).nodes();
                var last = null;
                var total = [];
                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === "string"
                        ? i.replace(/[\$,]/g, "") * 1
                        : typeof i === "number"
                            ? i
                            : 0;
                };
                $.each(groupColumnIndex, function (k, c) {
                    api.column(c, {page: 'current'})
                        .data()
                        .each(function (group, i) {
                            var group_assoc = group.toLowerCase().replace(/[^A-Z0-9]/ig, "_");
                            if (typeof total[k + '_' + group_assoc] != "undefined") {
                                total[k + '_' + group_assoc] =
                                    total[k + '_' + group_assoc] + intVal(api.column(8).data()[i]);
                            } else {
                                total[k + '_' + group_assoc] = intVal(api.column(8).data()[i]);
                            }
                            if (last !== group) {
                                $(rows)
                                    .eq(i)
                                    .before('<tr class="group group_' + k + '">' +
                                        '<td colspan="6" class="font-weight-bolder">' + group + '</td>' +
                                        '<td colspan="2" class="font-weight-bolder ' + k + '_' + group_assoc + '"></td>' +
                                        '</tr>');
                                // }
                                last = group;
                            }
                        });
                })

                for (var key in total) {
                    var _total = $.fn.dataTable.render.number('.', ',').display(total[key]);
                    $("." + key).html(_total);
                }
            },

        });

        $('a[data-action="reload"]').on('click', function () {
            childTable.ajax().reload()
        });
    </script>
@endsection
