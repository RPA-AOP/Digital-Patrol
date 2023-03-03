@php use App\Helpers\Constant; @endphp
@extends('layouts/layoutMaster')
@section('title', 'List Rencana Kegiatan')

@section('vendor-style')

    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendor/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendor/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendor/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendor/css/tables/datatable/select.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendor/css/tables/datatable/rowGroup.bootstrap4.min.css') }}">
@endsection

@section('vendor-style')
    <style>
        .child-table {
            background-color: #f3f2f7 !important;
        }

        .group_0 td {
            padding-left: 1rem !important;
            background-color: #7b71df;
            color: #fff;
        }
    </style>
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('rencana-kegiatan') }}
@endsection

@section('content')
    <!-- list start -->
    <section id="responsive-datatable">
        <!--  filter start -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Search</h4>
            </div>
            <div class="d-flex justify-content-between align-items-center mx-50 row pt-0 pb-2">
                <div class="col-md-6 metode_pengadaan">
                    <select id="filterMetode" class="form-control select2 text-capitalize mb-md-0 mb-2"
                            data-placeholder="Pilih Metode Pengadaan">
                        <option value="">Pilih Metode Pengadaan</option>
                    </select>
                </div>
                <div class="col-md-6 jenis_pengadaan">
                    <select id="filterJenis" class="form-control select2 text-capitalize mb-md-0 mb-2"
                            data-placeholder="Pilih Jenis Pengadaan">
                        <option value="">Pilih Jenis Pengadaan</option>
                    </select>
                </div>

            </div>
        </div>
        <!--  filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="table-responsive pt-0">
                <table class="datatables-ajax table dataTable " id="table-rencana-kegiatan">
                    <thead class="thead-light w-100">
                    <tr>
                        <th>#</th>
                        <th>No. Sirup</th>
                        <th>Metode Pengadaan</th>
                        <th>Jenis Pengadaan</th>
                        <th>Program</th>
                        <th>Kegiatan</th>
                        <th>Sub Kegiatan</th>
                        {{--                        <th>Total Rincian</th>--}}
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                </table>


            </div>
        </div>
        <!-- list section end -->
    </section>
    <!--  list ends -->
@endsection

@section('vendor-script')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('assets/vendor/js/forms/validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/forms/validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/ui/jquery.sticky.js')}}"></script>

    <!-- END: Page Vendor JS-->
@endsection

@section('page-script')

    {{--JS SECTION--}}
    <script>

        var statusObj = {
            1: {title: 'Pending', class: 'badge-light-warning'},
            2: {title: 'Active', class: 'badge-light-success'},
            3: {title: 'Inactive', class: 'badge-light-secondary'}
        };
        const metodePengadaan = {!! json_encode(Constant::METODE_PENGADAAN) !!};
        const jenisPengadaan = {!! json_encode(Constant::JENIS_PENGADAAN) !!};

        function createChild(row, d, myClass) {
            var detailRencanaKegiatan = d.detail_rencana_kegiatan;
            var idTable = "new_" + d.id_rencana_kegiatan;
            var htmlAccordion = `
            <div class="collapse-margin" id="accordion_` + idTable + `">
                    <div class="card m-0">
                        <div class="card-header bg-gradient-primary bg-lighten-1 text-white" id="heading_` + idTable + `" data-toggle="collapse" role="button" data-target="#collapse_` + idTable + `" aria-expanded="false" aria-controls="collapse_` + idTable + `">
                            <span class="lead collapse-title"> Detail</span>
                        </div>

                        <div id="collapse_` + idTable + `" class="collapse" aria-labelledby="heading_` + idTable + `" data-parent="#accordion_` + idTable + `">
                            <div class="card-datatable table-responsive">
                                <table id="` + idTable + `" class="table px-2" width="100%"/>
                            </div>
                        </div>
                    </div>
                </div>
            `
            row.child(htmlAccordion).show();
            $('#accordion_' + idTable).parent().addClass(myClass + ' collapse-icon');
            let groupColumnIndex = [0, 1];
            var childTable = $('#' + idTable).DataTable({
                data: detailRencanaKegiatan,
                responsive: true,
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
        }

        $('#table-rencana-kegiatan').DataTable({
            ajax: "{{route('rencana-kegiatan.list')}}",
            responsive: false,
            columns: [
                {
                    data: 'id_rencana_kegiatan',
                    render: function (item, data, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'no_sirup',},
                {
                    data: 'metode_pengadaan',
                    render: function (item, data, row, meta) {
                        return metodePengadaan[item]
                    }
                },
                {
                    data: 'jenis_pengadaan',
                    render: function (item, data, row, meta) {
                        return jenisPengadaan[item]
                    }
                },
                {data: 'program',},
                {data: 'kegiatan',},
                {data: 'sub_kegiatan',},
                {
                    data: 'nama_workflow',
                    width: "20%",
                    render: function (data) {
                        return `<span class="badge badge-primary" style="white-space: break-spaces">${data}</span>`;
                    }
                },
                {
                    data: 'id_rencana_kegiatan',
                    name: 'id_rencana_kegiatan',
                    sortable: false,
                    searchable: false,
                    render: function (item, data, row) {
                        var actionDetail = '';
                        if (row.id_user_group === {{Auth::user()->id_user_group}}) {
                            actionDetail = `
                        <a href="{{ url('rencana-kegiatan/approval/') }}/${row.id_rencana_kegiatan}" class="btn  btn-sm btn-outline-primary" title="Lihat Data">Proses
                            ` + feather.icons['list'].toSvg({class: 'font-medium-1 text-primary'}) + `
                            </a>`;
                        }

                        var action = `
                        <div class="btn-group">
                            @if($permission->has_view)
                        <a href="{{ url('rencana-kegiatan/detail/') }}/${row.id_rencana_kegiatan}" class="btn  btn-sm btn-outline-primary" title="Lihat Data">
                            ` + feather.icons['eye'].toSvg({class: 'font-medium-1 text-primary'}) + `
                            </a>` + actionDetail;
                            @endif
                            return action;
                    }
                },

            ],
            order: [[1, 'asc']],
            dom:
                '<"d-flex justify-content-between align-items-center header-actions m-1 row mt-75"' +
                '<"col-lg-12 col-xl-6" l>' +
                '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
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
            // Buttons with Dropdown
            buttons: [
                    @if($permission->has_create)
                {
                    text: 'Tambah Rencana Kegiatan',
                    className: 'add-new btn btn-primary mt-50',
                    action: function (e, dt, button, config) {
                        window.location = "{{ route('rencana-kegiatan.create') }}"
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                }
                @endif

            ],
            initComplete: function () {
                // Adding role filter once table initialized
                this.api()
                    .columns(2)
                    .every(function () {
                        var column = this;
                        var select = $('#filterMetode').on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                            });
                    });
                this.api()
                    .columns(3)
                    .every(function () {
                        var column = this;
                        var select = $('#filterJenis').on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                            });
                    });

                this.api()
                    .rows()
                    .every(function () {
                        createChild(this, this.data(), 'child-table')
                    });
            }
        });

        $('.select2').each(function () {
            var $this = $(this);
            $this.select2({
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $this.parent()
            });
        });
        // To initialize tooltip with body container
        $('body').tooltip({
            selector: '[data-toggle="tooltip"]',
            container: 'body'
        });
    </script>

@endsection
