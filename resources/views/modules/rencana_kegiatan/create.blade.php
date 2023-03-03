@php use App\Helpers\Constant; @endphp
@extends('layouts/layoutMaster')
@section('title', 'Tambah Rencana Kegiatan')
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
    {{ Breadcrumbs::render('rencana-kegiatan.create') }}
@endsection

@section('content')
    <!-- Horizontal Wizard -->
    <section class="horizontal-wizard">
        <div class="bs-stepper horizontal-wizard">
            <div class="bs-stepper-header">
                <div class="step" data-target="#sirup-rincian">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">1</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">SIRUP & Rincian Aktifitas</span>
                            <span class="bs-stepper-subtitle">Upload dokumen sirup & <br>pilih detail kegiatan.</span>
                        </span>
                    </button>
                </div>
                <div class="line">
                    <i data-feather="chevron-right" class="font-medium-2"></i>
                </div>
                <div class="step" data-target="#rekening-komponen">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">2</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Rekening & Komponen</span>
                            <span class="bs-stepper-subtitle">Pilih Rekening & <br> Komponen anggaran.</span>
                        </span>
                    </button>
                </div>
                <div class="line">
                    <i data-feather="chevron-right" class="font-medium-2"></i>
                </div>
                <div class="step" data-target="#dokumen-kak">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">3</span>
                        <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Dokumen KAK</span>
                                        <span
                                            class="bs-stepper-subtitle">Pembuatan dokumen <br>Kerangka Acuan Kerja</span>
                                    </span>
                    </button>
                </div>
                <div class="line">
                    <i data-feather="chevron-right" class="font-medium-2"></i>
                </div>
                <div class="step" data-target="#dokumen-spph">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">4</span>
                        <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Dokumen SPPH</span>
                                        <span
                                            class="bs-stepper-subtitle">Pembuatan Dokumen <br>Surat Permintaan Penawaran Harga </span>
                                    </span>
                    </button>
                </div>
                <div class="line">
                    <i data-feather="chevron-right" class="font-medium-2"></i>
                </div>
                <div class="step" data-target="#preview-submit">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-box">5</span>
                        <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Preview & Submit</span>
                                        <span
                                            class="bs-stepper-subtitle">Preview rencana kegiatan &<br> submit</span>
                                    </span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <div id="sirup-rincian" class="content">
                    <div class="content-header">
                        <h5 class="mb-0">SIRUP & Rincian Aktifitas</h5>
                        <small class="text-muted">Upload dokumen sirup & Pilih rincian aktifitas.</small>
                    </div>
                    <form id="form-detail-kegiatan">
                        <div class="row">
                            <div class="col-12">
                                <x-fileinput
                                    label="Dokumen SIRUP"
                                    id="sirup"
                                    placeholder="Dokumen SIRUP"
                                    :required="true"
                                    :multiple="false"
                                    :extension="['.pdf', '.doc', '.docx']"
                                >
                                </x-fileinput>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>No. SIRUP<span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Nomor SIRUP"
                                               required name="nomor_sirup" id="nomor_sirup">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Metode Pengadaan<span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2-field form-control" required
                                                name="metode_pengadaan" id="metode_pengadaan"
                                                data-placeholder="Pilih Metode Pengadaan">
                                            <option value=""></option>
                                            @foreach(Constant::METODE_PENGADAAN as $k => $v)
                                                <option value="{{$k}}">{{$v}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label">
                                        <label>Jenis Pengadaan<span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2-field form-control" required
                                                name="jenis_pengadaan" id="jenis_pengadaan"
                                                data-placeholder="Pilih Jenis Pengadaan">
                                            <option value=""></option>
                                            @foreach(Constant::JENIS_PENGADAAN as $k => $v)
                                                <option value="{{$k}}">{{$v}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <x-select2 id="program" label="Program"
                                           placeholder="Pilih Program"
                                           :required="true"
                                           model="master_program"
                                           primaryField="id_program"
                                           valueField="nama"
                                           searchField="kode"
                                           :multiple="false"></x-select2>
                            </div>
                            <div class="col-12">
                                <x-select2 id="kegiatan" label="Kegiatan"
                                           placeholder="Pilih Kegiatan"
                                           :required="true"
                                           model="master_kegiatan"
                                           primaryField="id_kegiatan"
                                           valueField="nama"
                                           searchField="kode"
                                           :multiple="false"
                                           :chainedConfig="['parent_selector'=>'program', 'parent_field'=>'id_program']"
                                ></x-select2>
                            </div>
                            <div class="col-12">
                                <x-select2 id="sub_kegiatan" label="Sub Kegiatan"
                                           placeholder="Pilih Sub Kegiatan"
                                           :required="true"
                                           model="master_sub_kegiatan"
                                           primaryField="id_sub_kegiatan"
                                           valueField="nama"
                                           searchField="kode"
                                           :multiple="false"
                                           :chainedConfig="['parent_selector'=>'kegiatan', 'parent_field'=>'id_kegiatan']"
                                ></x-select2>
                            </div>
                            <div class="col-12">
                                <x-select2 id="rincian_aktifitas" label="Rincian aktifitas"
                                           placeholder="Pilih Rincian aktifitas"
                                           :required="true"
                                           model="master_rincian_aktifitas"
                                           primaryField="id_rincian_aktifitas"
                                           valueField="nama"
                                           searchField="kode"
                                           :multiple="false"
                                           :chainedConfig="['parent_selector'=>'sub_kegiatan', 'parent_field'=>'id_sub_kegiatan']"
                                ></x-select2>
                            </div>
                        </div>
                    </form>


                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-secondary btn-prev" disabled>
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </div>
                <div id="rekening-komponen" class="content">
                    <div class="content-header">
                        <h5 class="mb-0">Rekening dan Komponen</h5>
                        <small>Pilih Rekening dan Komponen.</small>
                    </div>
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-datatable table-responsive">
                                        <table class="dt-row-grouping table table-striped"
                                               id="table-komponen">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Subtitle</th>
                                                <th>Kode Rekening</th>
                                                <th>Uraian</th>
                                                <th>Satuan</th>
                                                <th>Kofisien</th>
                                                <th>Harga</th>
                                                <th>PPN(Rp)</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Subtitle</th>
                                                <th>Kode Rekening</th>
                                                <th>Uraian</th>
                                                <th>Satuan</th>
                                                <th>Kofisien</th>
                                                <th>Harga</th>
                                                <th>PPN(Rp)</th>
                                                <th>Total</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">Rekening dan komponen yang dipilih</h4>
                                    </div>
                                    <div class="card-datatable table-responsive">
                                        <table class="dt-row-grouping table table-striped"
                                               id="table-selected-komponen">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Subtitle</th>
                                                <th>Kode Rekening</th>
                                                <th>Uraian</th>
                                                <th>Satuan</th>
                                                <th>Kofisien</th>
                                                <th>Harga</th>
                                                <th>PPN(Rp)</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Subtitle</th>
                                                <th>Kode Rekening</th>
                                                <th>Uraian</th>
                                                <th>Satuan</th>
                                                <th>Kofisien</th>
                                                <th>Harga</th>
                                                <th>PPN(Rp)</th>
                                                <th>Total</th>
                                            </tr>
                                            </tfoot>
                                        </table>

                                        <div class="col-12">
                                            <div class="form-group row">
                                                <div class="col-sm-3 col-form-label">
                                                    <label>Pagu Anggaran</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" readonly class="form-control totalSelected"
                                                           placeholder="Pagu Anggaran"
                                                           required name="pagu_anggaran" id="pagu_anggaran">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <div class="col-sm-3 col-form-label">
                                                    <label>Bilangan Pagu Anggaran<span
                                                            style="color: red;">*</span></label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control totalSelected"
                                                           placeholder="Bilangan Pagu Anggaran"
                                                           required name="pagu_anggaran_text" id="pagu_anggaran_text"
                                                           autocomplete="false">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </div>
                <div id="dokumen-kak" class="content">
                    <form action="{{ route('document.preview-kak') }}" target="_blank" method="POST" id="form-kak">
                        @csrf
                        @include('modules.rencana_kegiatan.document_form.kak')
                        <div id="kak-detailkegiatan">
                        </div>
                        <div id="kak-komponen"></div>
                        <input type="hidden" id="totalSelected" class="totalSelected" name="totalSelected">
                        <input type="hidden" id="totalSelectedtext" class="totalSelectedText" name="totalSelectedText">

                    </form>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </div>
                <div id="dokumen-spph" class="content">
                    <form action="{{ route('document.preview-spph') }}" target="_blank" method="POST" id="form-spph">
                        @csrf
                        @include('modules.rencana_kegiatan.document_form.spph')
                    </form>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </div>
                <div id="preview-submit" class="content">
                    <div id="form-review-submit">
                        <div class="row">
                            <div class="col-6">
                                <div class="card user-card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">Review Detail Rencana Kegiatan</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            {{-- START NO SIRUP--}}
                                            <div class="col-lg-12 mt-2 mt-xl-1">
                                                <div class="user-info-wrapper">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="user-info-title">
                                                            <span
                                                                class="card-text user-info-title font-weight-bold mb-0">Nomor SIRUP</span>
                                                        </div>
                                                        <p class="card-text mb-0">: <span id="review_no_sirup"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- END  NO SIRUP--}}
                                            {{-- START METODE--}}
                                            <div class="col-lg-12 mt-2 mt-xl-1">
                                                <div class="user-info-wrapper">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="user-info-title">
                                                            <span
                                                                class="card-text user-info-title font-weight-bold mb-0">Metode Pengadaan</span>
                                                        </div>
                                                        <p class="card-text mb-0">
                                                            : <span id="review_metode"></span></p>
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
                                                            : <span id="review_jenis"></span></p>
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
                                                        <p class="card-text mb-0">: <span id="review_program"></span>
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
                                                        <p class="card-text mb-0">: <span id="review_kegiatan"></span>
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
                                                            <span
                                                                class="card-text user-info-title font-weight-bold mb-0">Sub Kegiatan</span>
                                                        </div>
                                                        <p class="card-text mb-0">: <span
                                                                id="review_subkegiatan"></span>
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
                                                            <span
                                                                class="card-text user-info-title font-weight-bold mb-0">Rincian Aktifitas</span>
                                                        </div>
                                                        <p class="card-text mb-0">: <span
                                                                id="review_rincianAktifitas"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- END RINCIAN AKTIFITAS--}}
                                            {{-- START PAGU ANGGARAN--}}
                                            <div class="col-lg-12 mt-2 mt-xl-1">
                                                <div class="user-info-wrapper">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="user-info-title">
                                                            <span
                                                                class="card-text user-info-title font-weight-bold mb-0">Pagu Anggaran</span>
                                                        </div>
                                                        <p class="card-text mb-0">: <span
                                                                id="review_paguAnggaran"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- END RINCIAN PAGU ANGGARAN--}}
                                            {{-- START PAGU ANGGARAN TEXT--}}
                                            <div class="col-lg-12 mt-2 mt-xl-1">
                                                <div class="user-info-wrapper">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="user-info-title">
                                                            <span
                                                                class="card-text user-info-title font-weight-bold mb-0">Pagu Anggaran Terbilang</span>
                                                        </div>
                                                        <p class="card-text mb-0">: <span
                                                                id="review_paguAnggaranTerbilang"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- END RINCIAN PAGU ANGGARAN TExt--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div id="review_dokumen">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Lampiran</h4>
                                        </div>
                                    </div>
                                    <div class=" row">
                                        <div class="col-6">
                                            <!-- lampiran starts -->
                                            <div class="card bg-white" id="preview_kak">
                                                <div class="card-img-top file-logo-wrapper p-2 bg-gradient-primary">
                                                    <div class="d-flex align-items-center justify-content-center w-100">
                                                        <img src="{{asset('assets/images/icons/pdf.png')}}"
                                                             alt="file-icon"
                                                             height="35"/>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <h6 class="mb-0">Dokumen KAK</h6>
                                                    <div class="content-wrapper">
                                                        <p class="card-text font-small-3 mb-0">Kerangka Acuan
                                                            Kerja.pdf</p>
                                                    </div>
                                                    <a class="btn-link"
                                                       href="javascript:;" onclick="previewKAK()">Preview</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="card bg-white" id="preview_spph">
                                                <div class="card-img-top file-logo-wrapper p-2 bg-gradient-primary">
                                                    <div class="d-flex align-items-center justify-content-center w-100">
                                                        <img src="{{asset('assets/images/icons/pdf.png')}}"
                                                             alt="file-icon"
                                                             height="35"/>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <h6 class="mb-0">Dokumen SPPH</h6>
                                                    <div class="content-wrapper">
                                                        <p class="card-text font-small-3 mb-0">Surat Permintaan
                                                            Penawaran
                                                            Harga.pdf</p>
                                                    </div>
                                                    <a class="btn-link"
                                                       href="javascript:;" onclick="previewSPPH()">Preview</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="review_component">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">Rekening dan komponen yang dipilih</h4>
                                </div>
                                <div class="card-datatable table-responsive">
                                    <table class="dt-row-grouping table table-striped"
                                           id="review_table-selected-komponen">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subtitle</th>
                                            <th>Kode Rekening</th>
                                            <th>Uraian</th>
                                            <th>Satuan</th>
                                            <th>Kofisien</th>
                                            <th>Harga</th>
                                            <th>PPN(Rp)</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Subtitle</th>
                                            <th>Kode Rekening</th>
                                            <th>Uraian</th>
                                            <th>Satuan</th>
                                            <th>Kofisien</th>
                                            <th>Harga</th>
                                            <th>PPN(Rp)</th>
                                            <th>Total</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-prev">
                                <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                            </button>
                            <button class="btn btn-success btn-submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Horizontal Wizard -->
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
    <script src="{{asset('assets/vendor/js/forms/repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/vendor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/ckeditor/styles.js') }}"></script>
    <!-- END: Page Vendor JS-->
@endsection

@section('page-script')
    <!-- BEGIN: Page JS-->

    <script>
        var $selectField = $(".select2-field");

        $selectField.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this
                .select2({
                    dropdownParent: $this.parent()
                })
                .change(function () {
                    $(this).valid();
                });
        });
        let groupColumnIndex = [1, 2];
        var collapsedGroups = {};
        let groupingTable = $('#table-komponen').DataTable({
            ajax: {
                type: 'GET',
                url: "{{route('rencana-kegiatan.getDataRekeningKomponen')}}",
                data: function (d) {
                    d.id_rincian_aktifitas = $("#rincian_aktifitas").val();
                },
            },
            autoWidth: false,
            "bProcessing": true,
            columns: [
                {data: 'id_komponen'},
                {
                    data: 'subtitle',
                    render: function (data, type, row, meta) {
                        return data + "__" + row.id_subtitle;
                    },
                },
                {
                    data: 'kode_rekening',
                },
                {
                    data: 'nama',
                    render: function (data, type, row, meta) {
                        return data.replaceAll('\n', '<br/>')
                    },
                    orderable: false,

                },
                {data: 'satuan'},
                {data: 'volume'},
                {
                    data: 'harga_satuan',
                    render: $.fn.dataTable.render.number('.', ',')
                },
                {
                    data: 'pph_ppn_satuan',
                    render: $.fn.dataTable.render.number('.', ',')
                },
                {
                    data: 'total',
                    render: $.fn.dataTable.render.number('.', ',')
                }
            ],
            destroy: true,
            rowGroup: {
                dataSrc: groupColumnIndex,
                emptyDataGroup: null
            },
            columnDefs: [
                {
                    // For Checkboxes
                    targets: 0,
                    orderable: false,
                    responsivePriority: 3,
                    render: function (data, type, full, meta) {
                        return (
                            '<div class="custom-control custom-checkbox"> <input class="custom-control-input dt-checkboxes" type="checkbox" value="' + JSON.stringify(full) + '" id="checkbox_' +
                            data + '" /><label class="custom-control-label" for="checkbox_' + data + '"></label></div>'
                        );
                    },
                    checkboxes: {
                        selectAllRender:
                            '<div class="custom-control custom-checkbox"> <input class="custom-control-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="custom-control-label" for="checkboxSelectAll"></label></div>'
                    }
                },
                {
                    className: 'text-center',
                    orderable: false,
                    targets: 5
                },
                {visible: false, targets: groupColumnIndex},
            ],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            order: [[1, 'asc'], [2, 'asc']],
            dom:
                '<"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
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
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details of ' + data['full_name'];
                        }
                    }),
                    type: 'column',
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            }
        });
        let targetTable = $('#table-selected-komponen').DataTable({
            autoWidth: false,
            processing: true,
            "bProcessing": true,
            columns: [
                {
                    data: 'kode',
                },
                {
                    data: 'subtitle',
                    render: function (data, type, row, meta) {
                        return data + "__" + row.id_subtitle;
                    },
                },
                {
                    data: 'kode_rekening',
                },
                {
                    data: 'nama',
                    render: function (data, type, row, meta) {
                        return data.replaceAll('\n', '<br/>')
                    },
                    orderable: false,

                },
                {data: 'satuan'},
                {data: 'volume'},
                {
                    data: 'harga_satuan',
                    render: $.fn.dataTable.render.number('.', ',')
                },
                {
                    data: 'pph_ppn_satuan',
                    render: $.fn.dataTable.render.number('.', ',')
                },
                {
                    data: 'total',
                    render: $.fn.dataTable.render.number('.', ',')
                },
            ],
            destroy: true,  /* <---- this setting reinitialize the table */
            rowGroup: {
                dataSrc: groupColumnIndex,
                emptyDataGroup: null
            },
            columnDefs: [
                {
                    className: 'text-center',
                    orderable: false,
                    targets: 5
                },
                {visible: false, targets: groupColumnIndex},
            ],
            order: [[1, 'asc'], [2, 'asc']],
            dom:
                '<"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
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
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details of ' + data['full_name'];
                        }
                    }),
                    type: 'column',
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            }
        });
        let reviewTable = $('#review_table-selected-komponen').DataTable({
            autoWidth: false,
            processing: true,
            "bProcessing": true,
            columns: [
                {
                    data: 'kode',
                },
                {
                    data: 'subtitle',
                    render: function (data, type, row, meta) {
                        return data + "__" + row.id_subtitle;
                    },
                },
                {
                    data: 'kode_rekening',
                },
                {
                    data: 'nama',
                    render: function (data, type, row, meta) {
                        return data.replaceAll('\n', '<br/>')
                    },
                    orderable: false,

                },
                {data: 'satuan'},
                {data: 'volume'},
                {
                    data: 'harga_satuan',
                    render: $.fn.dataTable.render.number('.', ',')
                },
                {
                    data: 'pph_ppn_satuan',
                    render: $.fn.dataTable.render.number('.', ',')
                },
                {
                    data: 'total',
                    render: $.fn.dataTable.render.number('.', ',')
                }
            ],
            destroy: true,  /* <---- this setting reinitialize the table */
            rowGroup: {
                dataSrc: groupColumnIndex,
                emptyDataGroup: null
            },
            columnDefs: [
                {
                    className: 'text-center',
                    orderable: false,
                    targets: 5
                },
                {visible: false, targets: groupColumnIndex},
            ],
            order: [[1, 'asc'], [2, 'asc']],
            dom:
                '<"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
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
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details of ' + data['full_name'];
                        }
                    }),
                    type: 'column',
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            }
        });

        $('#table-komponen tbody').on('click', 'tr', function () {
            setTimeout(function () {
                var totalSelected = 0
                $('#kak-komponen').html('')
                $('#spph-komponen').html('')
                var rows_selected = groupingTable.rows('.selected').data();
                targetTable.clear().draw();
                reviewTable.clear().draw();
                $.each(rows_selected, function (index, value) {
                    targetTable.row.add(value);
                    targetTable.draw()

                    reviewTable.row.add(value);
                    reviewTable.draw()

                    totalSelected = totalSelected + parseFloat(value.total)
                    $('#kak-komponen').append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'data-kak-datakomponen[]')
                            .val(JSON.stringify(value))
                    );
                    $('#spph-komponen').append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'data-spph-komponen[' + index + ']')
                            .val(JSON.stringify(value))
                    );
                    $('#spph-komponen').append(
                        `<tr>
                            <td>` + (index + 1) + `</td>
                            <td>` + value.nama + `</td>
                            <td>` + value.volume + `</td>
                            <td>` + value.satuan + `</td>
                            <td><textarea name="speksifikasi[` + index + `]" data-kode="` + value.kode + `" class="form-control">` + value.nama + `</textarea></td>
                        </tr>`
                    );
                });
                $("#totalSelected").val(totalSelected)
                $("#pagu_anggaran").val($.fn.dataTable.render.number('.', ',').display(totalSelected))

                // }
            }, 200)

        });

        // $('#form-rencana-kegiatan').on('submit', function (e) {
        //     e.preventDefault();
        //     var form = this;
        //     var rows_selected = groupingTable.column(0).checkboxes.selected();
        //     $('input[name="id_komponen\[\]"]', form).remove();
        //     $.each(rows_selected, function (index, rowId) {
        //         // Create a hidden element
        //         $(form).append(
        //             $('<input>')
        //                 .attr('type', 'hidden')
        //                 .attr('name', 'id_komponen[]')
        //                 .val(rowId)
        //         );
        //     });
        //     // console.log($(form).serialize());
        //     // Prevent actual form submission
        //     form.submit();
        // });

        $("#rincian_aktifitas").change(function () {
            if ($(this).val()) {
                $('#table-komponen').DataTable().ajax.reload();
            }
        })

        function initCkEDITOR() {
            let ckEditorOptions = {
                toolbar: [
                    {
                        name: 'clipboard',
                        items: ['Undo', 'Redo']
                    },
                    {
                        name: 'styles',
                        items: ['Format', 'Font', 'FontSize']
                    },
                    {
                        name: 'basicstyles',
                        items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
                    },
                    {
                        name: 'colors',
                        items: ['TextColor', 'BGColor']
                    },
                    {
                        name: 'align',
                        items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink']
                    },
                    {
                        name: 'paragraph',
                        items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'textindent', '-', 'Blockquote']
                    },
                    {
                        name: 'insert',
                        items: ['Image', 'Table']
                    },
                    {
                        name: 'tools',
                        items: ['Maximize']
                    },
                    {
                        name: 'editing',
                        items: ['Scayt']
                    }
                ],
                height: 150,
                disallowedContent: 'img{width,height,float}',
                extraAllowedContent: 'img[width,height,align]',
                on: {
                    contentDom: function (evt) {
                        // Allow custom context menu only with table elemnts.
                        evt.editor.editable().on('contextmenu', function (contextEvent) {
                            var path = evt.editor.elementPath();

                            if (!path.contains('table')) {
                                contextEvent.cancel();
                            }
                        }, null, null, 5);
                    }
                }
            };
            CKEDITOR.replaceAll(function (textarea, config) {
                var instance = CKEDITOR.instances[$(textarea).attr('name')];
                if (instance) {
                    return false;
                }
                if (textarea.classList.contains("editor")) {
                    config.extraPlugins = 'textindent';
                    config.toolbar = [
                        {name: 'document', items: ['Source']},
                        {
                            name: 'clipboard',
                            items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
                        },
                        {name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
                        {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                        {
                            name: 'insert',
                            items: ['Table', 'HorizontalRule', 'SpecialChar', 'PageBreak', 'Iframe',]
                        },
                        {
                            name: 'basicstyles',
                            items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']
                        },
                        {
                            name: 'paragraph',
                            items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']
                        },
                        {name: 'tools', items: ['Maximize', 'ShowBlocks']},
                        {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
                        {name: 'colors', items: ['TextColor', 'BGColor']},
                        {name: 'about', items: ['About']}
                    ];
                    config.disableAutoInline = true;
                    config.height = 150;
                    return true;
                }
                return false;
            });
        }

        function previewKAK() {
            var detailKegiatan = $('#form-detail-kegiatan').serializeArray()
            $('#kak-detailkegiatan').html('')
            $.each(detailKegiatan, function (index, rowId) {
                $('#kak-detailkegiatan').append(
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'data-detailkegiatan[' + rowId['name'] + ']')
                        .val(rowId['value'])
                );
            });

            $("#totalSelectedtext").val($('#pagu_anggaran_text').val())

            $(`#form-kak`).submit();
            // $('#kak-detailkegiatan').html('')
        }

        function previewSPPH() {
            var detailKegiatan = $('#form-detail-kegiatan').serializeArray()
            $('#kak-detailkegiatan').html('')
            $.each(detailKegiatan, function (index, rowId) {
                $('#kak-detailkegiatan').append(
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'data-detailkegiatan[' + rowId['name'] + ']')
                        .val(rowId['value'])
                );
            });

            $("#totalSelectedtext").val($('#pagu_anggaran_text').val())

            $(`#form-spph`).submit();
            // $('#kak-detailkegiatan').html('')
        }

        function getFormData($form) {
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function (n, i) {
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        }

        var bsStepper = document.querySelectorAll('.bs-stepper');
        var horizontalWizard = document.querySelector('.horizontal-wizard');

        for (var el = 0; el < bsStepper.length; ++el) {
            bsStepper[el].addEventListener('show.bs-stepper', function (event) {
                var index = event.detail.indexStep;
                var numberOfSteps = $(event.target).find('.step').length - 1;
                var line = $(event.target).find('.step');

                // The first for loop is for increasing the steps,
                // the second is for turning them off when going back
                // and the third with the if statement because the last line
                // can't seem to turn off when I press the first item. ¯\_(ツ)_/¯

                for (var i = 0; i < index; i++) {
                    line[i].classList.add('crossed');

                    for (var j = index; j < numberOfSteps; j++) {
                        line[j].classList.remove('crossed');
                    }
                }
                if (event.detail.to === 0) {
                    for (var k = index; k < numberOfSteps; k++) {
                        line[k].classList.remove('crossed');
                    }
                    line[0].classList.remove('crossed');
                }
            });
        }
        var numberedStepper = new Stepper(horizontalWizard)
        var $form = $(horizontalWizard).find('form');
        $form.each(function () {
            var $this = $(this);
            $this.validate({
                errorPlacement: function (error, e) {
                    e.parents('.col-sm-9').append(error);
                },
                rules: {
                    sirup: {
                        required: true
                    }, 'nomor_sirup': {
                        required: true
                    },
                    'metode_pengadaan': {
                        required: true
                    },
                    'jenis_pengadaan': {
                        required: true,
                    },
                    'program': {
                        required: true
                    },
                    'kegiatan': {
                        required: true
                    },
                    'sub_kegiatan': {
                        required: true
                    },
                    'rincian_aktifitas': {
                        required: true
                    }
                }
            });
        });

        $(horizontalWizard)
            .find('.btn-next')
            .each(function () {
                $(this).on('click', function (e) {
                    var isValid = $(this).parent().siblings('form').valid();
                    if (isValid) {
                        numberedStepper.next();
                    } else {
                        e.preventDefault();
                    }
                });
            });

        $(horizontalWizard)
            .find('.btn-prev')
            .on('click', function () {
                numberedStepper.previous();
            });

        $(horizontalWizard)
            .find('.btn-submit')
            .on('click', function () {
                let fd = new FormData();
                let payload = {
                    'nomer_sirup': $('#nomor_sirup').val(),
                    'program': $('#program').select2('data')[0].id,
                    'kegiatan': $('#kegiatan').select2('data')[0].id,
                    'subkegiatan': $('#sub_kegiatan').select2('data')[0].id,
                    'rincianAktifitas': $('#rincian_aktifitas').select2('data')[0].id,
                    'jenis': $('#jenis_pengadaan').select2('data')[0].id,
                    'metode': $('#metode_pengadaan').select2('data')[0].id,
                    'pagu_anggaran': $('#pagu_anggaran').val(),
                    'pagu_anggaran_text': $('#pagu_anggaran_text').val(),
                    'komponen': JSON.stringify(targetTable.rows().data().toArray()),
                    'kak': JSON.stringify(getFormData($('#form-kak'))),
                    'spph': JSON.stringify(getFormData($('#form-spph')))
                };
                $.map(payload, function (value, key) {
                    fd.append(key, value);
                });

                // APPEND DOCUMENT SIRUP
                fd.append('sirup', $('#sirup')[0].files[0])
                console.log(fd);
                $.ajax({
                    type: "POST",
                    url: "{{route('rencana-kegiatan.store')}}",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        Swal.fire('Success', 'Rencana Kegiatan Berhasil disimpan', 'info')
                            .then(function () {
                                window.location.href = "{{route('rencana-kegiatan.index')}}"
                            });
                    }
                });
            });
        horizontalWizard.addEventListener('shown.bs-stepper', function (event) {
            if (event.detail.indexStep === 4) {
                $('#review_jenis').text($('#jenis_pengadaan').select2('data')[0].text)
                $('#review_metode').text($('#metode_pengadaan').select2('data')[0].text)
                $('#review_rincianAktifitas').text($('#rincian_aktifitas').select2('data')[0].text)
                $('#review_no_sirup').text($('#nomor_sirup').val())
                $('#review_program').text($('#program').select2('data')[0].text)
                $('#review_kegiatan').text($('#kegiatan').select2('data')[0].text)
                $('#review_subkegiatan').text($('#sub_kegiatan').select2('data')[0].text)
                $('#review_paguAnggaran').text($('#pagu_anggaran').val())
                $('#review_paguAnggaranTerbilang').text($('#pagu_anggaran_text').val())
            }
        })

    </script>
    <!-- END: Page JS-->

@endsection
