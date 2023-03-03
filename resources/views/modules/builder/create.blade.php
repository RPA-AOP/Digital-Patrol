@php use App\Helpers\Constant; @endphp
@extends('layouts/layoutMaster')
@section('title', 'Tambah Konfigurasi Patroli')
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/css/forms/wizard/bs-stepper.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/forms/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/forms/form-wizard.css')}}">

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
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/pages/app-user.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/vendor/css/pickers/flatpickr/flatpickr.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/vendor/css/nestable/jquery.nestable.css')}}">
@endsection
@section('vendor-style')
    <style>
        .dd-handle {
            border-color: rgba(225, 225, 225, 0.7);
            color: #575757;
        }

        .dd-handle:hover {
            background-color: #f0f0f0;
        }

        .dark .dd-handle {
            color: #575757;
            background: #e7e7e7;
        }

        .dark .dd-handle:hover {
            background-color: #f0f0f0;
        }

        .dark .dd-placeholder {
            background-color: #e1e1e1;
        }

        .dd3-content {
            background: #fff;
            border-color: rgba(225, 225, 225, 0.7);
            color: #575757;
        }

        .dd3-content:hover {
            background-color: #f0f0f0;
        }

        .dd3-handle {
            background: transparent;
            text-indent: 9999px;
        }

        .dd3-handle:before {
            font-family: 'feather' !important;
            color: #575757;
            content: "\e88f";
            font-size: 11px;
            top: 5px;
        }

        .dd-placeholder {
            background: #e7e7e7;
            border-color: rgba(87, 87, 87, 0.35);
        }

        .dd-empty {
            background-image: none;
            background: #e7e7e7;
            border-color: rgba(87, 87, 87, 0.5);
        }

        .dd-item > button {
            font-size: 11px;
        }

        .dd-item > button:before {
            font-family: 'feather' !important;
            content: "\e842";
        }

        .dd-item > button[data-action="collapse"]:before {
            font-family: 'feather' !important;
            content: "\e845";
        }

        /* Responsive Handlers : Nestables
        ------------------------------------
        */
        @media only screen and (min-width: 700px) {
            .dd {
                width: 100%;
            }

            .nestable-lists .dd {
                float: left;
            }
        }
    </style>
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('patrolconfig.create') }}
@endsection

@section('content')
    <section>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Import data Patroli <small>(PT. ABCDE)</small>
                        </h5>
                    </div>
                    <div class="card-body">
                        <x-fileinput
                            label=""
                            id="import-data patroli"
                            placeholder="Pilih file"
                            :required="true"
                            :multiple="false"
                            :extensions="['xlsx']"
                        >
                        </x-fileinput>
                    </div>
                </div>

            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Hasil Import data Patroli <small>(PT. ABCDE)</small>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="dd" id="nestable3">
                            <ol class="dd-list">
                                <li class="dd-item dd3-item" data-id="13">
                                    <div class="dd-handle dd3-handle">Drag</div>
                                    <div class="dd3-content">Item 13</div>
                                </li>
                                <li class="dd-item dd3-item" data-id="14">
                                    <div class="dd-handle dd3-handle">Drag</div>
                                    <div class="dd3-content">Item 14</div>
                                </li>
                                <li class="dd-item dd3-item" data-id="15">
                                    <div class="dd-handle dd3-handle">Drag</div>
                                    <div class="dd3-content">Item 15</div>
                                    <ol class="dd-list">
                                        <li class="dd-item dd3-item" data-id="16">
                                            <div class="dd-handle dd3-handle">Drag</div>
                                            <div class="dd3-content">Item 16</div>
                                        </li>
                                        <li class="dd-item dd3-item" data-id="17">
                                            <div class="dd-handle dd3-handle">Drag</div>
                                            <div class="dd3-content">Item 17</div>
                                        </li>
                                        <li class="dd-item dd3-item" data-id="18">
                                            <div class="dd-handle dd3-handle">Drag</div>
                                            <div class="dd3-content">Item 18</div>
                                        </li>
                                    </ol>
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-script')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('assets/vendor/js/forms/wizard/bs-stepper.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/forms/validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/dataTables.select.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/jszip.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js/nestable/jquery.nestable.js')}}"></script>
    <!-- END: Page Vendor JS-->
@endsection

@section('page-script')
    <!-- BEGIN: Page JS-->

    <script>

        $(document).ready(function () {
            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    console.log(window.JSON.stringify(list.nestable('serialize')))
                } else {
                    output.html('JSON browser support required for this demo.');
                }
            };
            $('#nestable3').nestable().on('change', updateOutput);

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

    </script>
    <!-- END: Page JS-->

@endsection
