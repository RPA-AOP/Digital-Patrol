@extends('layouts.dashboard')
@push('subtitle', '- Management User Group')
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/css/extensions/sweetalert2.min.css') }}">
    <script nonce="{{ csp_nonce() }}">
        .page-wrapper .page-body-wrapper .page-body {
            min-height: calc(100vh - 150px);
        }

        #main_table_wrapper {
            width: 99%;
        }

        .modal-loader {
            display: none;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.7);
        }

        .modal-loader .loader-box {
            height: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h3>Management User Group</h3>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center pb-0">
            <h5>Daftar User Group</h5>
            @if($permission->has_create)
                <div class="btn btn-sm btn-primary btn-pills btn-air-primary" onclick="createData()">
                    Tambah Data
                </div>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="main_table" class="display">
                    <thead>
                    <th>#</th>
                    <th>Jabatan</th>
                    <th>Unit Kerja</th>
                    <th>Dibuat Oleh</th>
                    <th>Dibuat Pada</th>
                    <th>Diperbarui Oleh</th>
                    <th>Diperbarui Pada</th>
                    <th>Aksi</th>
                    </thead>
                    <!-- DATATABLES SERVER SIDE WILL HANDLE THIS ELEMENT -->
                </table>
            </div>
        </div>
    </div>

    @if($permission->has_create)
        <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-loader">
                    <div class="loader-box">
                        <div class="loader-15"></div>
                    </div>
                </div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel">Tambah User Group</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="jabatan_add">Jabatan <sup class="txt-danger">* Wajib
                                    diisi</sup></label>
                            <select class="form-control" id="jabatan_add">
                                <option style="display: none;" value="">--- PILIH JABATAN ---</option>
                                @foreach($jabatan as $jab)
                                    <option value="{{ $jab->id_jabatan }}">{{ $jab->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="unit_kerja_add">Unit Kerja <sup class="txt-danger">* Wajib
                                    diisi</sup></label>
                            <select class="form-control" id="unit_kerja_add">
                                <option style="display: none;" value="">--- PILIH UNIT KERJA ---</option>
                                @foreach($unit_kerja as $uk)
                                    <option value="{{ $uk->id_unit_kerja }}">{{ $uk->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="form-label" for="type_user_group_add">Tipe User Group <sup class="txt-danger">*
                                    Wajib diisi</sup></label>
                            <select class="form-control" id="type_user_group_add">
                                <option style="display: none;" value="">--- PILIH TIPE USER GROUP ---</option>
                                @foreach($type_user_group as $tug)
                                    <option value="{{ $tug['value'] }}">{{ $tug['label'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <span class="txt-primary">User Group Privileges</span>
                        <div class="privilege_container">
                            @foreach($default_privilege as $dp)
                                <hr/>
                                <span>{{ $dp->title }}</span>
                                <div class="form-group m-t-15 m-checkbox-inline mb-0">
                                    <div class="checkbox checkbox-primary">
                                        <input id="{{ $dp->id_menu }}_has_view" class="privileges-input"
                                               data-id_menu="{{ $dp->id_menu }}" data-section="has_view"
                                               type="checkbox">
                                        <label for="{{ $dp->id_menu }}_has_view">View</label>
                                    </div>

                                    <div class="checkbox checkbox-primary">
                                        <input id="{{ $dp->id_menu }}_has_create" class="privileges-input"
                                               data-id_menu="{{ $dp->id_menu }}" data-section="has_create"
                                               type="checkbox">
                                        <label for="{{ $dp->id_menu }}_has_create">Create</label>
                                    </div>

                                    <div class="checkbox checkbox-primary">
                                        <input id="{{ $dp->id_menu }}_has_edit" class="privileges-input"
                                               data-id_menu="{{ $dp->id_menu }}" data-section="has_edit"
                                               type="checkbox">
                                        <label for="{{ $dp->id_menu }}_has_edit">Edit</label>
                                    </div>

                                    <div class="checkbox checkbox-primary">
                                        <input id="{{ $dp->id_menu }}_has_download" class="privileges-input"
                                               data-id_menu="{{ $dp->id_menu }}" data-section="has_download"
                                               type="checkbox">
                                        <label for="{{ $dp->id_menu }}_has_download">Download</label>
                                    </div>

                                    <div class="checkbox checkbox-primary">
                                        <input id="{{ $dp->id_menu }}_has_delete" class="privileges-input"
                                               data-id_menu="{{ $dp->id_menu }}" data-section="has_delete"
                                               type="checkbox">
                                        <label for="{{ $dp->id_menu }}_has_delete">Delete</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" onclick="doCreate()">Simpan</button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($permission->has_view)
        <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-loader">
                    <div class="loader-box">
                        <div class="loader-15"></div>
                    </div>
                </div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalViewLabel">Detail User Group</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="jabatan_view">Jabatan</label>
                            <select class="form-control" id="jabatan_view" disabled>
                                <option style="display: none;">--- PILIH JABATAN ---</option>
                                @foreach($jabatan as $jab)
                                    <option value="{{ $jab->id_jabatan }}">{{ $jab->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="unit_kerja_view">Unit Kerja</label>
                            <select class="form-control" id="unit_kerja_view" disabled>
                                <option style="display: none;">--- PILIH UNIT KERJA ---</option>
                                @foreach($unit_kerja as $uk)
                                    <option value="{{ $uk->id_unit_kerja }}">{{ $uk->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="form-label" for="type_user_group_view">Tipe User Group</label>
                            <select class="form-control" id="type_user_group_view" disabled>
                                <option style="display: none;">--- PILIH TIPE USER GROUP ---</option>
                                @foreach($type_user_group as $tug)
                                    <option value="{{ $tug['value'] }}">{{ $tug['label'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <span class="txt-primary">User Group Privileges</span>
                        <div class="privilege_container">
                            @foreach($default_privilege as $dp)
                                <hr/>
                                <span>{{ $dp->title }}</span>
                                <div class="form-group m-t-15 m-checkbox-inline mb-0">
                                    <div class="checkbox checkbox-primary">
                                        <input id="{{ $dp->id_menu }}_has_view_view" type="checkbox" disabled>
                                        <label for="{{ $dp->id_menu }}_has_view_view">View</label>
                                    </div>

                                    <div class="checkbox checkbox-primary">
                                        <input id="{{ $dp->id_menu }}_has_create_view" type="checkbox" disabled>
                                        <label for="{{ $dp->id_menu }}_has_create_view">Create</label>
                                    </div>

                                    <div class="checkbox checkbox-primary">
                                        <input id="{{ $dp->id_menu }}_has_edit_view" type="checkbox" disabled>
                                        <label for="{{ $dp->id_menu }}_has_edit_view">Edit</label>
                                    </div>

                                    <div class="checkbox checkbox-primary">
                                        <input id="{{ $dp->id_menu }}_has_download_view" type="checkbox" disabled>
                                        <label for="{{ $dp->id_menu }}_has_download_view">Download</label>
                                    </div>

                                    <div class="checkbox checkbox-primary">
                                        <input id="{{ $dp->id_menu }}_has_delete_view" type="checkbox" disabled>
                                        <label for="{{ $dp->id_menu }}_has_delete_view">Delete</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($permission->has_edit)
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-loader">
                    <div class="loader-box">
                        <div class="loader-15"></div>
                    </div>
                </div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Edit User Group</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_user_group_edit"/>
                        <div class="mb-3">
                            <label class="form-label" for="jabatan_edit">Jabatan <sup class="txt-danger">* Wajib
                                    diisi</sup></label>
                            <select class="form-control" id="jabatan_edit">
                                <option style="display: none;">--- PILIH JABATAN ---</option>
                                @foreach($jabatan as $jab)
                                    <option value="{{ $jab->id_jabatan }}">{{ $jab->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="unit_kerja_edit">Unit Kerja <sup class="txt-danger">* Wajib
                                    diisi</sup></label>
                            <select class="form-control" id="unit_kerja_edit">
                                <option style="display: none;">--- PILIH UNIT KERJA ---</option>
                                @foreach($unit_kerja as $uk)
                                    <option value="{{ $uk->id_unit_kerja }}">{{ $uk->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="form-label" for="type_user_group_edit">Tipe User Group <sup
                                    class="txt-danger">* Wajib diisi</sup></label>
                            <select class="form-control" id="type_user_group_edit">
                                <option style="display: none;">--- PILIH TIPE USER GROUP ---</option>
                                @foreach($type_user_group as $tug)
                                    <option value="{{ $tug['value'] }}">{{ $tug['label'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="privilege_container"></div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" onclick="doEdit()">Simpan</button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('page_js')
    <script src="{{ asset('assets/vendor/js/extension/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
@endsection

@section('page-script')
    <script nonce="{{ csp_nonce() }}">
        let dataTabel = $('#main_table').DataTable({
            responsive: true,
            language: {
                "emptyTable": "Tidak Ada Data",
                "lengthMenu": "Menampilkan _MENU_ Data/Halaman",
                "zeroRecords": "Tidak Ada Data",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak Ada Data",
                "infoFiltered": "(memfilter data dari _MAX_ total total data)",
                "search": "Cari Data: ",
                "processing": "Sedang memproses...",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
            },
            processing: true,
            serverSide: true,
            ajax: "{{ env('APP_URL') }}management-user-group/list",
            columns: [{
                data: 'jabatan',
                render: function (item, type, data, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
                {
                    data: 'jabatan',
                },
                {
                    data: 'unit_kerja',
                },
                {
                    data: 'usercreated',
                    name: 'usercreated',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function (data) {
                        let date = new Date(data);
                        return date.toLocaleDateString('id-ID');
                    }
                },
                {
                    data: 'userupdated',
                    name: 'userupdated',
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                    render: function (data) {
                        let date = new Date(data);
                        return date.toLocaleDateString('id-ID');
                    }
                },
                {
                    data: 'id_user_group',
                    name: 'id_user_group',
                    sortable: false,
                    searchable: false,
                    render: function (data) {
                        return (`
                        <div class="btn-group">
                            @if($permission->has_view)
                        <div class="btn btn-outline-primary" onclick="viewData('${data}')" title="Lihat Data">
                                <i class="icon-eye"></i>
                            </div>
                            @endif

                        @if($permission->has_edit)
                        <div class="btn btn-outline-warning" onclick="editData('${data}')" title="Edit Data">
                                <i class="icon-pencil"></i>
                            </div>
                            @endif

                        @if($permission->has_delete)
                        <div class="btn btn-outline-danger" onclick="deleteData('${data}')" title="Hapus Data">
                                <i class="icon-trash"></i>
                            </div>
                            @endif
                        </div>
                    `);
                    }
                },
            ],
        });


        '@if($permission->has_view)'

        // VIEW HANDLER
        function viewData(id) {
            $("#modalView").modal('show');
            $("#modalView .modal-loader").fadeIn();

            $.ajax({
                url: `{{ env('APP_URL') }}management-user-group/detail/${id}`,
                success: function (res) {
                    resetModalView();
                    if (res.status == 'success') {
                        let jabatan = res.data.id_jabatan;
                        let unit_kerja = res.data.id_unit_kerja;
                        let type = res.data.type;
                        let privileges = res.data.privileges;


                        $("#jabatan_view").val(jabatan);
                        $("#unit_kerja_view").val(unit_kerja);
                        $("#type_user_group_view").val(type);
                        $("#modalView .privilege_container").html("");

                        privileges.forEach(function (el) {
                            $("#modalView .privilege_container").append(`
                            <hr />
                            <span>${el.title}</span>
                            <div class="form-group m-t-15 m-checkbox-inline mb-0">
                                <div class="checkbox checkbox-dark">
                                    <input id="${el.id_menu}_has_view_view" data-id_menu="${el.id_menu}" type="checkbox" disabled ${el.has_view == 1 && "checked"}>
                                    <label for="${el.id_menu}_has_view">View</label>
                                </div>

                                <div class="checkbox checkbox-dark">
                                    <input id="${el.id_menu}_has_create_view" data-id_menu="${el.id_menu}" type="checkbox" disabled ${el.has_create == 1 && "checked"}>
                                    <label for="${el.id_menu}_has_create_view">Create</label>
                                </div>

                                <div class="checkbox checkbox-dark">
                                    <input id="${el.id_menu}_has_edit_view" data-id_menu="${el.id_menu}" type="checkbox" disabled ${el.has_edit == 1 && "checked"}>
                                    <label for="${el.id_menu}_has_edit_view">Edit</label>
                                </div>

                                <div class="checkbox checkbox-dark">
                                    <input id="${el.id_menu}_has_download_view" data-id_menu="${el.id_menu}" type="checkbox" disabled ${el.has_download == 1 && "checked"}>
                                    <label for="${el.id_menu}_has_download_view">Download</label>
                                </div>

                                <div class="checkbox checkbox-dark">
                                    <input id="${el.id_menu}_has_delete_view" data-id_menu="${el.id_menu}" type="checkbox" disabled ${el.has_delete == 1 && "checked"}>
                                    <label for="${el.id_menu}_has_delete_view">Delete</label>
                                </div>
                            </div>
                        `);
                        });
                    } else {
                        Swal.fire("Error!", res.msg, "error");
                        $("#modalView").modal('hide');
                        resetModalView();
                    }
                },
                error: function () {
                    Swal.fire("Error!", "Terjadi kesalahan, Silahkan coba lagi", "error")
                }
            })
        }

        function resetModalView() {
            $("#modalView .modal-loader").fadeOut();
            $("#modalView input").val("");
            $("#modalView select").val("");
            $("#modalView input").prop('checked', false);
            $("#modalView .privilege_container").html(`
        @foreach($default_privilege as $dp)
            <hr />
            <span>{{ $dp->title }}</span>
            <div class="form-group m-t-15 m-checkbox-inline mb-0">
                <div class="checkbox checkbox-primary">
                    <input id="{{ $dp->id_menu }}_has_view_view" type="checkbox" disabled>
                    <label for="{{ $dp->id_menu }}_has_view_view">View</label>
                </div>

                <div class="checkbox checkbox-primary">
                    <input id="{{ $dp->id_menu }}_has_create_view" type="checkbox" disabled>
                    <label for="{{ $dp->id_menu }}_has_create_view">Create</label>
                </div>

                <div class="checkbox checkbox-primary">
                    <input id="{{ $dp->id_menu }}_has_edit_view" type="checkbox" disabled>
                    <label for="{{ $dp->id_menu }}_has_edit_view">Edit</label>
                </div>

                <div class="checkbox checkbox-primary">
                    <input id="{{ $dp->id_menu }}_has_download_view" type="checkbox" disabled>
                    <label for="{{ $dp->id_menu }}_has_download_view">Download</label>
                </div>

                <div class="checkbox checkbox-primary">
                    <input id="{{ $dp->id_menu }}_has_delete_view" type="checkbox" disabled>
                    <label for="{{ $dp->id_menu }}_has_delete_view">Delete</label>
                </div>
            </div>
        @endforeach
            `);
        }

        $('#modalView').on('hidden.bs.modal', function () {
            resetModalView();
        });
        // END VIEW HANDLER
        '@endif'

        '@if($permission->has_edit)'

        // EDIT HANDLER
        function editData(id) {
            $("#modalEdit").modal('show');
            $("#modalEdit .modal-loader").fadeIn();

            $.ajax({
                url: `{{ env('APP_URL') }}management-user-group/detail/${id}`,
                success: function (res) {
                    resetModalEdit();
                    if (res.status == 'success') {
                        let jabatan = res.data.id_jabatan;
                        let unit_kerja = res.data.id_unit_kerja;
                        let type = res.data.type;
                        let privileges = res.data.privileges;


                        $("#jabatan_edit").val(jabatan);
                        $("#unit_kerja_edit").val(unit_kerja);
                        $("#type_user_group_edit").val(type);
                        $("#id_user_group_edit").val(id);

                        privileges.forEach(function (el) {
                            $("#modalEdit .privilege_container").append(`
                            <hr />
                            <span>${el.title}</span>
                            <div class="form-group m-t-15 m-checkbox-inline mb-0">
                                <div class="checkbox checkbox-primary">
                                    <input id="${el.id_menu}_has_view_edit" class="privileges-input" data-id_menu="${el.id_menu}" type="checkbox" data-section="has_view" ${el.has_view == 1 && "checked"}>
                                    <label for="${el.id_menu}_has_view_edit">View</label>
                                </div>

                                <div class="checkbox checkbox-primary">
                                    <input id="${el.id_menu}_has_create_edit" class="privileges-input" data-id_menu="${el.id_menu}" type="checkbox" data-section="has_create" ${el.has_create == 1 && "checked"}>
                                    <label for="${el.id_menu}_has_create_edit">Create</label>
                                </div>

                                <div class="checkbox checkbox-primary">
                                    <input id="${el.id_menu}_has_edit_edit" class="privileges-input" data-id_menu="${el.id_menu}" type="checkbox" data-section="has_edit" ${el.has_edit == 1 && "checked"}>
                                    <label for="${el.id_menu}_has_edit_edit">Edit</label>
                                </div>

                                <div class="checkbox checkbox-primary">
                                    <input id="${el.id_menu}_has_download_edit" class="privileges-input" data-id_menu="${el.id_menu}" type="checkbox" data-section="has_download" ${el.has_download == 1 && "checked"}>
                                    <label for="${el.id_menu}_has_download_edit">Download</label>
                                </div>

                                <div class="checkbox checkbox-primary">
                                    <input id="${el.id_menu}_has_delete_edit" class="privileges-input" data-id_menu="${el.id_menu}" type="checkbox" data-section="has_delete" ${el.has_delete == 1 && "checked"}>
                                    <label for="${el.id_menu}_has_delete_edit">Delete</label>
                                </div>
                            </div>
                        `);
                        });
                    } else {
                        Swal.fire("Error!", res.msg, "error");
                        $("#modalEdit").modal('hide');
                        resetModalEdit();
                    }
                },
                error: function () {
                    Swal.fire("Error!", "Terjadi kesalahan, Silahkan coba lagi", "error")
                }
            })
        }

        $('#modalEdit').on('hidden.bs.modal', function () {
            resetModalEdit();
        });

        function resetModalEdit() {
            $("#modalEdit .modal-loader").fadeOut();
            $("#modalEdit input").val("");
            $("#modalEdit select").val("");
            $("#modalEdit input").prop('checked', false);
            $("#modalEdit .privilege_container").html("");
        }

        function doEdit() {
            let jabatan = $("#jabatan_edit").val();
            let unit_kerja = $("#unit_kerja_edit").val();
            let type = $("#type_user_group_edit").val();
            let id = $("#id_user_group_edit").val();

            if (jabatan && unit_kerja && type) {
                $("#modalEdit .modal-loader").fadeIn();

                // PRIVILEGE HANDLER
                let privileges_raw = [];
                let privileges_component = $('#modalEdit .privileges-input');
                $.each(privileges_component, function (index, el) {
                    let ins = $(el);
                    let value = ins.is(':checked') ? 1 : 0;
                    let id_menu = ins.data('id_menu');
                    let section = ins.data('section');
                    privileges_raw.push({
                        value,
                        id_menu,
                        section
                    });
                });

                // GROUP BY DATA BY ID_MENU
                let unique_id = privileges_raw.map(function (item) {
                    return item.id_menu;
                })
                    .filter(function (value, index, self) {
                        return self.indexOf(value) === index
                    })

                let privilege = [];

                unique_id.forEach(function (el) {
                    let data_group = privileges_raw.filter(function (item) {
                        return item.id_menu === el
                    });

                    let _obj = {};
                    data_group.forEach(function (el) {
                        _obj[el.section] = el.value;
                        _obj['id_menu'] = el.id_menu;
                    });
                    privilege.push(_obj);
                });
                // PRIVILEGE HANDLER END

                $.ajax({
                    url: "{{ env('APP_URL') }}management-user-group",
                    method: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        jabatan,
                        unit_kerja,
                        type,
                        privilege,
                        id
                    },
                    success: function (res) {
                        $("#modalEdit .modal-loader").fadeOut();
                        if (res.status == 'success') {
                            Swal.fire("Success!", res.msg, "success")
                                .then(function () {
                                    resetModalEdit()
                                    $("#modalEdit").modal('hide');
                                    dataTabel.ajax.reload(null, false);
                                })
                        } else {
                            Swal.fire("Perhatian!", res.msg, "warning")
                        }
                    },

                    error: function () {
                        Swal.fire("Error!", "Terjadi kesalahan yang tidak diketahui, silahkan coba lagi", "error");
                        $("#modalEdit .modal-loader").fadeOut();
                    }
                })

            } else {
                Swal.fire("Perhatian!", "Mohon isi seluruh field wajib terlebih dahulu", "warning");
            }
        }

        // END EDIT HANDLER
        '@endif'


        '@if($permission->has_create)'

        // CREATE HANDLER
        function createData() {
            $("#modalAdd").modal("show");
        }

        function doCreate() {

            let jabatan = $("#jabatan_add").val();
            let unit_kerja = $("#unit_kerja_add").val();
            let type = $("#type_user_group_add").val();

            if (jabatan && unit_kerja && type) {
                $("#modalAdd .modal-loader").fadeIn();

                // PRIVILEGE HANDLER
                let privileges_raw = [];
                let privileges_component = $('#modalAdd .privileges-input');
                $.each(privileges_component, function (index, el) {
                    let ins = $(el);
                    let value = ins.is(':checked') ? 1 : 0;
                    let id_menu = ins.data('id_menu');
                    let section = ins.data('section');
                    privileges_raw.push({
                        value,
                        id_menu,
                        section
                    });
                });

                // GROUP BY DATA BY ID_MENU
                let unique_id = privileges_raw.map(function (item) {
                    return item.id_menu;
                })
                    .filter(function (value, index, self) {
                        return self.indexOf(value) === index
                    })

                let privilege = [];

                unique_id.forEach(function (el) {
                    let data_group = privileges_raw.filter(function (item) {
                        return item.id_menu === el
                    });

                    let _obj = {};
                    data_group.forEach(function (el) {
                        _obj[el.section] = el.value;
                        _obj['id_menu'] = el.id_menu;
                    });
                    privilege.push(_obj);
                });
                // PRIVILEGE HANDLER END

                $.ajax({
                    url: "{{ env('APP_URL') }}management-user-group",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        jabatan,
                        unit_kerja,
                        type,
                        privilege
                    },
                    success: function (res) {
                        $("#modalAdd .modal-loader").fadeOut();
                        if (res.status == 'success') {
                            Swal.fire("Success!", res.msg, "success")
                                .then(function () {
                                    resetModalAdd()
                                    $("#modalAdd").modal('hide');
                                    dataTabel.ajax.reload(null, false);
                                })
                        } else {
                            Swal.fire("Perhatian!", res.msg, "warning")
                        }
                    },

                    error: function () {
                        Swal.fire("Error!", "Terjadi kesalahan yang tidak diketahui, silahkan coba lagi", "error");
                        $("#modalAdd .modal-loader").fadeOut();
                    }
                })
            } else {
                Swal.fire("Perhatian!", "Mohon isi seluruh field wajib terlebih dahulu", "warning");
            }
        }

        function resetModalAdd() {
            $("#modalAdd .modal-loader").fadeOut();
            $("#modalAdd input").val("");
            $("#modalAdd select").val("");
            $("#modalAdd input").prop('checked', false)
        }

        // END CREATE HANDLER
        '@endif'

        '@if($permission->has_delete)'

        // DELETE HANDLER
        function deleteData(id) {
            Swal
                .fire({
                    title: '',
                    text: 'Apakah Anda yakin akan menghapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: '<i class="la la-remove"></i> Batal',
                    confirmButtonText: '<i class="la la-trash"></i> Hapus'
                })
                .then(function (result) {
                    if (result.value) {
                        Swal.fire({
                            title: 'Menghapus Data...'
                        });
                        swal.showLoading();

                        $.ajax({
                            url: `{{ env('APP_URL') }}management-user-group`,
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            data: {
                                id
                            },
                            success: function (res) {
                                if (res.status == 'success') {
                                    Swal
                                        .fire("Berhasil!", res.msg, "success")
                                        .then(function () {
                                            dataTabel.ajax.reload(null, false);
                                        });
                                } else {
                                    Swal
                                        .fire({
                                            title: "Error!",
                                            html: res.msg,
                                            icon: "error"
                                        })
                                        .then(function () {
                                            dataTabel.ajax.reload(null, false);
                                        })
                                }
                            },
                            error: function () {
                                Swal
                                    .fire("Error!", "Terjadi kesalahan, Silahkan coba lagi", "error")
                            }
                        })
                    }
                });
        }

        // END DELETE HANDLER
        '@endif'
    </script>
@endsection
