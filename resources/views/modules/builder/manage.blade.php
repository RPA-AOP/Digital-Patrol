@php use App\Helpers\Constant; @endphp
@extends('layouts/layoutMaster')
@section('title', 'Manage Patrol Configurations')
@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/nestable/jquery.nestable.css')}}"/>

@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('patrolconfig.create') }}
@endsection

@section('content')
    <section>
        <div class="row h-100">
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-header  d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">
                                Manage Data Area And Object Patroli {{$company->company_name}}
                            </h5>
                        </div>

                        @if($dataConfig)
                            <div class="form-modal-ex">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="offcanvas"
                                        data-bs-toggle="offcanvas"
                                        data-target="#offcanvasAddUser" data-bs-target="#offcanvasAddUser">
                                    Add New Item
                                </button>
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
                                     aria-labelledby="offcanvasAddUserLabel">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add new config item</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
                                        <form class="form form-vertical" id="form-new-item">
                                            <div
                                                class="row  modal-body">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                               for="new_item_parent_id">Parent</label>
                                                        <select name="parent_id" id="new_item_parent_id"
                                                                class="form-control"
                                                                data-placeholder="Parent Id">
                                                            <option>-- PARENT ITEM</option>
                                                            @foreach($parentItem as $parent)
                                                                <option
                                                                    value="{{$parent['id_detail_patrol_config']}}">{{$parent['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="new_item_level_id">Level</label>
                                                        <select name="level_id" id="new_item_level_id"
                                                                class="form-control"
                                                                data-placeholder="Level">
                                                            <option>-- LEVEL ITEM</option>
                                                            @foreach($itemLevel as $level)
                                                                <option
                                                                    value="{{$level['level']}}">{{$level['level_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="new_item_code">Code</label>
                                                        <input type="text" id="new_item_code" class="form-control"
                                                               name="code" placeholder="Code">
                                                        <input type="hidden" id="new_item_id_detail_patrol_config"
                                                               class="form-control"
                                                               name="id_detail_patrol_config"
                                                               placeholder="id_detail_patrol_config">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="new_item_name">Name</label>
                                                        <input type="text" id="new_item_name" class="form-control"
                                                               name="name" placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="new_item_identification_key">Identification
                                                            Key</label>
                                                        <input type="text" id="new_item_identification_key"
                                                               class="form-control"
                                                               name="identification_key"
                                                               placeholder="Identification Key">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                               for="new_item_category">Category</label>
                                                        <select name="category_id" id="new_item_category"
                                                                class="form-control"
                                                                data-placeholder="Category">
                                                            @foreach($category as $c)
                                                                <option
                                                                    value="{{$c->id_category}}">{{$c->category_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                   name="status"
                                                                   id="new_item_status">
                                                            <label class="custom-control-label"
                                                                   for="new_item_status">Active</label>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button id="btn add-new-item"
                                                            class="btn btn-primary text-center btn-block waves-effect waves-float waves-light">
                                                        Add new item
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary d-flex align-items-center mb-0" role="alert">
                                <span class="alert-icon text-primary me-2">
                                    <i class="ti ti-info-circle ti-xs"></i>
                                </span>
                            @if($dataConfig)
                                Drag & drop item to change data level and click Update Hierarchy to save
                            @else
                                Upload configuration files (.xlsx)
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card overflow-hidden mb-4" style="height: 630px;">
                    <div class="card-header d-flex justify-content-between align-middle mb-0">
                        <h5 class="card-title">Area Configuration</h5>
                        @if($dataConfig)
                            <button id="update-hierarchy"
                                    class="btn btn-primary btn-sm text-center">
                                Update Hierarchy
                            </button>
                        @endif
                    </div>
                    <div class="card-body" id="nestablePatrolConfigCard">
                        @if($dataConfig)
                            <div class="dd " id="nestablePatrolConfig">
                                <ol class="dd-list">
                                    @foreach($dataConfig->patrolDetail as $level_1)
                                        <li class="dd-item dd3-item"
                                            data-id="{{$level_1->id_detail_patrol_config}}"
                                            id="{{$level_1->id_detail_patrol_config}}">
                                            <div class="dd-handle dd3-handle bg-primary text-white"></div>
                                            <div class="dd3-content"
                                                 data-id="{{$level_1->id_detail_patrol_config}}"
                                                 id="content_{{$level_1->id_detail_patrol_config}}"
                                                 data-level="{{$level_1->level}}"
                                                 data-config='{{json_encode($level_1)}}'>
                                                <div class="d-flex justify-content-between">
                                                    <span>{{$level_1->name}}</span>
                                                </div>
                                            </div>
                                            <ol class="dd-list">
                                                @foreach($level_1->child as $level_2)
                                                    <li class="dd-item dd3-item"
                                                        data-id="{{$level_2->id_detail_patrol_config}}"
                                                        id="{{$level_2->id_detail_patrol_config}}">
                                                        <div
                                                            class="dd-handle dd3-handle bg-secondary text-white">
                                                            Drag
                                                        </div>
                                                        <div class="dd3-content"
                                                             data-level="{{$level_2->level}}"
                                                             data-id="{{$level_2->id_detail_patrol_config}}"
                                                             id="content_{{$level_2->id_detail_patrol_config}}"
                                                             data-config='{{json_encode($level_2)}}'>
                                                            {{$level_2->name}}</div>
                                                        <ol class="dd-list">
                                                            @foreach($level_2->child as $level_3)
                                                                <li class="dd-item dd3-item"
                                                                    data-id="{{$level_3->id_detail_patrol_config}}"
                                                                    id="{{$level_3->id_detail_patrol_config}}">
                                                                    <div
                                                                        class="dd-handle dd3-handle bg-info text-white">
                                                                        Drag
                                                                    </div>
                                                                    <div class="dd3-content"
                                                                         data-config='{{json_encode($level_3)}}'
                                                                         data-level="{{$level_3->level}}"
                                                                         data-id="{{$level_3->id_detail_patrol_config}}"
                                                                         id="content_{{$level_3->id_detail_patrol_config}}"

                                                                    >{{$level_3->name}}</div>
                                                                    <ol class="dd-list">
                                                                        @foreach($level_3->child as $level_4)
                                                                            <li class="dd-item dd3-item dd-collapsed"
                                                                                data-id="{{$level_4->id_detail_patrol_config}}"
                                                                                id="{{$level_4->id_detail_patrol_config}}">
                                                                                <div
                                                                                    class="dd-handle dd3-handle bg-warning text-white">
                                                                                    Drag
                                                                                </div>
                                                                                <div
                                                                                    class="dd3-content"
                                                                                    data-level="{{$level_4->level}}"
                                                                                    data-config='{{json_encode($level_4)}}'
                                                                                    data-id="{{$level_4->id_detail_patrol_config}}"
                                                                                    id="content_{{$level_4->id_detail_patrol_config}}"
                                                                                >{{$level_4->name}}</div>
                                                                                <ol class="dd-list">
                                                                                    @foreach($level_4->child as $level_5)
                                                                                        <li class="dd-item dd3-item"
                                                                                            data-id="{{$level_5->id_detail_patrol_config}}"
                                                                                            id="{{$level_5->id_detail_patrol_config}}">
                                                                                            <div
                                                                                                class="dd-handle dd3-handle bg-success text-white">
                                                                                                Drag
                                                                                            </div>
                                                                                            <div
                                                                                                class="dd3-content"
                                                                                                data-level="{{$level_5->level}}"
                                                                                                data-config='{{json_encode($level_5)}}'
                                                                                                data-id="{{$level_5->id_detail_patrol_config}}"
                                                                                                id="content_{{$level_5->id_detail_patrol_config}}"
                                                                                            >{{$level_5->name}}</div>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ol>
                                                                            </li>
                                                                        @endforeach

                                                                    </ol>
                                                                </li>
                                                            @endforeach
                                                        </ol>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">

                    </div>
                </div>

            </div>
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-header  d-flex justify-content-between">
                        <h5 class="card-title">
                            Upload Object Patroli {{$company->company_name}}
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="form_import" action="{{route('patrolconfig.import')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="idCompany" value="{{$company->id_company}}">
                            <x-fileinput
                                label=""
                                id="import-data patroli"
                                placeholder="Choose configuration file (.xslx)"
                                :required="true"
                                :multiple="false"
                                :extensions="['xlsx']"
                            >
                            </x-fileinput>
                            <div class="row mt-2">
                                <button type="submit"
                                        class="btn btn-primary text-center btn-block waves-effect waves-float waves-light">
                                    UPLOAD
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @if($dataConfig)
                    <div class="card plan-card border-primary">
                        <div
                            class="card-header d-flex justify-content-between align-items-center pt-75 pb-1">
                            <h5 class="mb-0">Detail Area/Object</h5>
                            <span class="badge badge-light-secondary" data-toggle="tooltip"
                                  data-placement="top" title=""
                                  data-original-title="Level Area"><span id="level">Level Area: </span>
                                    </span>
                        </div>
                        <div class="card-body">
                            <form class="form form-vertical" id="form-detail">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="parent_id">Parent</label>
                                            <select name="parent_id" id="parent_id" class="form-control"
                                                    data-placeholder="Parent Id">
                                                <option>-- PARENT ITEM</option>
                                                @foreach($parentItem as $parent)
                                                    <option
                                                        value="{{$parent['id_detail_patrol_config']}}">{{$parent['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if($itemLevel)
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="level_id">Level</label>
                                            <select name="level_id" id="level_id" class="form-control"
                                                    data-placeholder="Level">
                                                <option>-- LEVEL ITEM</option>
                                                @foreach($itemLevel as $level)
                                                    <option
                                                        value="{{$level['level']}}">{{$level['level_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="code">Code</label>
                                            <input type="text" id="code" class="form-control"
                                                   name="code" placeholder="Code">
                                            <input type="hidden" id="id_detail_patrol_config"
                                                   class="form-control"
                                                   name="id_detail_patrol_config"
                                                   placeholder="id_detail_patrol_config">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input type="text" id="name" class="form-control"
                                                   name="name" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="identification_key">Identification
                                                Key</label>
                                            <input type="text" id="identification_key" class="form-control"
                                                   name="identification_key"
                                                   placeholder="Identification Key">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="category">Category</label>
                                            <select name="category_id" id="category" class="form-control"
                                                    data-placeholder="Category">
                                                @foreach($category as $c)
                                                    <option
                                                        value="{{$c->id_category}}">{{$c->category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                       name="status"
                                                       id="status">
                                                <label class="custom-control-label"
                                                       for="status">Active</label>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <button id="update-detail"
                                                class="btn btn-primary text-center btn-block waves-effect waves-float waves-light">
                                            Update Detail
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </section>

@endsection

@section('vendor-script')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>

    <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/nestable/jquery.nestable.js')}}"></script>

    <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <!-- END: Page Vendor JS-->
@endsection

@section('page-script')
    @if($dataConfig)
        <script nonce="{{ csp_nonce() }}">

            $(document).ready(function () {
                const configContainer = document.getElementById('nestablePatrolConfigCard');

                new PerfectScrollbar(configContainer, {
                    wheelPropagation: false
                });
                var updateOutput = function (e) {
                    var list = e.length ? e : $(e.target),
                        output = list.data('output');
                    if (window.JSON) {
                        console.log(window.JSON.stringify(list.nestable('serialize')))
                    } else {
                        output.html('JSON browser support required for this feature.');
                    }
                };

                $('#nestablePatrolConfig').nestable({
                    maxDepth: 5,
                    collapsedClass: 'dd-collapsed',
                }).on('change', updateOutput);

                $('#nestable-menu').on('click', function (e) {
                    var target = $(e.target),
                        action = target.data('action');
                    if (action === 'expand-all') {
                        $('.dd').nestable('expandAll');
                    }
                    if (action === 'collapse-all') {
                        $('.dd').nestable('collapseAll');
                    }
                });

            });
            var $category =  @json($category);
            $(".dd3-content").on('click', function (e) {
                e.preventDefault();
                var data = $(this).data('config');
                console.log(data);

                $('#name').val(data.name)
                $('#code').val(data.code)
                $('#parent_id').val(data.parent_id)
                $('#level_id').val(data.level)
                $('#id_detail_patrol_config').val(data.id_detail_patrol_config)

                $('#category').val(data.category_id)
                $('#identification_key').val(data.identification_key)
                $('#level').text('Level Area: ' + data.level_name)
                $('#status').prop('checked', data.status === '1');

            })
            @if($dataConfig)

            $("#update-hierarchy").on('click', function (e) {
                var data = $('#nestablePatrolConfig').nestable('serialize')
                if (window.JSON) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('patrolconfig.updateConfigHierarchy',  [$dataConfig->id_patrol_config])}}",
                        data: {data: window.JSON.stringify(data)},
                        success: function (response) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Update Success!',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then(function () {
                                window.location.reload()
                            });
                        },
                        error: function (xhr, status, error) {
                            console.log(error)
                            Swal.fire({
                                title: 'Error!',
                                text: error,
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then(function () {
                                // window.location.reload()
                            });
                        }
                    });
                } else {
                    Swal.fire('Error', 'JSON browser support required for this feature', 'error')
                }
            })

            $('#update-detail').on('click', function (e) {
                e.preventDefault();
                var dataForm = convertFormToJSON($("#form-detail"))
                $.ajax({
                    type: "POST",
                    url: "{{route('patrolconfig.update',  [$dataConfig->id_patrol_config])}}",
                    data: dataForm,
                    success: function (response) {
                        var configItem = $("#content_" + dataForm.id_detail_patrol_config)
                        configItem.data('config', response.data)
                        configItem.text(response.data['name'])
                        Swal.fire({
                            title: 'Success!',
                            text: 'Update Success!',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        }).then(function () {
                            // window.location.reload()
                        });
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                        Swal.fire({
                            title: 'Error!',
                            text: error,
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        }).then(function () {
                            // window.location.reload()
                        });
                    }
                });
            })
            @endif

        </script>
        <!-- END: Page JS-->
    @endif
@endsection
