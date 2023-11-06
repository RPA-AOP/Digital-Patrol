@php use App\Helpers\Constant; @endphp
@extends('layouts/layoutMaster')
@section('title', 'Detail Perusahaan')

@section('vendor-style')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/pages/app-user.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin="">
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
            integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
            crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

@endsection
@section('vendor-style')
    <style nonce="{{ csp_nonce() }}">
        .group_0 td {
            padding-left: 1rem !important;
            background-color: #7b71df;
            color: #fff;
        }
    </style>
@endsection
@section('breadcrumbs')
    {{  Breadcrumbs::render('master.company.show')  }}
@endsection

@section('content')
    <section class="app-user-view">
        <!-- User Card & Plan Starts -->
        <div class="row">
            <div class="col-12">
                <div class="card user-card">
                    <div class="card-header">
                        <div class="head-label">
                            <h6>Tambah Perusahaan</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form-edit" action="{{route('master.company.edit', $data->id_company)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="content-header">
                                        <h5 class="mb-0">Perusahaan</h5>
                                        <small>Silahkan Isi Detail Perusahaan</small>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="form-label" for="modern-twitter">Nama Perusahaan</label>
                                            <input type="text" id="nama_perusahaan" name="nama_perusahaan" class="form-control" value="{{$data->company_name}}"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="form-label" for="modern-twitter">Lokasi Perusahaan</label>
                                            <div id="map" style="width:100%; height: 300px;z-index: 0"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="lattitude" name="lat" class="form-control">
                                    <input type="hidden" id="longitude" name="long" class="form-control">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="form-label" for="modern-twitter">Detail Alamat</label>
                                            <textarea class="form-control" name="alamat" id="alamat" cols="5"
                                                      rows="5">{{$data->alamat}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="form-label" for="modern-twitter">Nama Produk</label>
                                            <input type="text" id="nama_produk" name="nama_produk" class="form-control" value="{{$data->nama_produk}}"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="form-label" for="modern-twitter">Proses Utama</label>
                                            <input type="text" id="proses_utama" name="proses_utama" class="form-control" value="{{$data->proses_utama}}"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="modern-google">Luas Tanah</label>
                                            <input type="text" id="luas_tanah" name="luas_tanah" class="form-control" value="{{$data->luas_tanah}}"/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="modern-linkedin">Luas Bangunan</label>
                                            <input type="text" id="luas_bangunan" name="luas_bangunan" class="form-control" value="{{$data->luas_bangunan}}"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="form-label" for="modern-google">Status Bangunan</label>
                                            <input type="text" id="status_bangunan" name="status_bangunan" class="form-control" value="{{$data->status_bangunan}}"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="form-label" for="modern-google">Jumlah Karyawan Tetap</label>
                                            <input type="text" id="karyawan_tetap" name="karyawan_tetap" class="form-control" value="{{$data->jumlah_karyawan_tetap}}"/>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="form-label" for="modern-linkedin">Jumlah Karyawan
                                                Kontrak</label>
                                            <input type="text" id="karyawan_kontrak" name="karyawan_kontrak" class="form-control" value="{{$data->jumlah_karyawan_kontrak}}"/>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="form-label" for="modern-google">Jumlah Karyawan
                                                Outsource</label>
                                            <input type="text" id="karyawan_outsource" name="karyawan_outsource" class="form-control" value="{{$data->jumlah_karyawan_outsource}}"/>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-5">
                                        <a class="btn btn-outline-secondary btn-prev" href="{{route('master.company.index')}}">
                                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Back</span>
                                        </a>

                                        <button class="btn btn-primary btn-next" type="submit">
                                            <span class="align-middle d-sm-inline-block d-none">Update</span>
                                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- User Card & Plan Ends -->
    </section>
@endsection

@section('page-script')

    <script nonce="{{ csp_nonce() }}">
        $(document).ready(function () {
            function onLocationError(e) {
                alert(e.message);
            }
            var map = L.map('map').setView([-6.200000, 106.816666], 8);
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                tileSize: 512,
                maxZoom: 18,
                zoomOffset: -1,
                id: 'mapbox/streets-v11',
                accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
            }).addTo(map);
            map.locate({setView: true, maxZoom: 18});
            // map.on('locationfound', onLocationFound);
            map.on('locationerror', onLocationError);

            var marker = L.marker([-6.200000, 106.816666]).addTo(map);
            $('#lattitude').val(-6.200000);
            $('#longitude').val(106.816666);

            map.on('move', function () {
                let coords = map.getCenter();
                marker.setLatLng(coords);
                var lattitude = $("#lattitude").val(coords.lat);
                var longitude = $("#longitude").val(coords.lng);
            });

            L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            L.Control.geocoder().addTo(map);

            $('#tambah_data').click(function (event) {
                let coords = map.getCenter();
                marker.setLatLng(coords);
                var lattitude = $("#lattitude")
                var longitude = $("#longitude")

                lattitude.val(coords.lat)
                longitude.val(coords.lng)
                event.preventDefault();
                let nama_pimpinan = $('#nama_pimpinan').val(),
                    lat = lattitude.val(),
                    long = longitude.val(),
                    email_pimpinan = $('#email_pimpinan').val(),
                    tlp_pimpinan = $('#tlp_pimpinan').val(),
                    nama_manager = $('#nama_manager').val(),
                    email_manager = $('#email_manager').val(),
                    tlp_manager = $('#tlp_manager').val(),
                    nama_pic_asms = $('#nama_pic_asms').val(),
                    email_pic_asms = $('#email_pic_asms').val(),
                    tlp_pic_asms = $('#tlp_pic_asms').val(),
                    nama_perusahaan = $('#nama_perusahaan').val(),
                    nama_produk = $('#nama_produk').val(),
                    proses_utama = $('#proses_utama').val(),
                    luas_tanah = $('#luas_tanah').val(),
                    luas_bangunan = $('#luas_bangunan').val(),
                    status_bangunan = $('#status_bangunan').val(),
                    karyawan_tetap = $('#karyawan_tetap').val(),
                    karyawan_kontrak = $('#karyawan_kontrak').val(),
                    karyawan_outsource = $('#karyawan_outsource').val(),
                    satpam_kontrak = $('#satpam_kontrak').val(),
                    satpam_tetap = $('#satpam_tetap').val(),
                    satpam_outsource = $('#satpam_outsource').val();

                let form = $("#form_tambah");
                let frmData = new FormData(form[0]);
                frmData.append('nama_pimpinan', nama_pimpinan);
                frmData.append('email_pimpinan', email_pimpinan);
                frmData.append('tlp_pimpinan', tlp_pimpinan);
                frmData.append('nama_manager', nama_manager);
                frmData.append('email_manager', email_manager);
                frmData.append('tlp_manager', tlp_manager);
                frmData.append('nama_pic_asms', nama_pic_asms);
                frmData.append('email_pic_asms', email_pic_asms);
                frmData.append('nama_perusahaan', nama_perusahaan);
                frmData.append('nama_produk', nama_produk);
                frmData.append('proses_utama', proses_utama);
                frmData.append('luas_tanah', luas_tanah);
                frmData.append('luas_bangunan', luas_bangunan);
                frmData.append('status_bangunan', status_bangunan);
                frmData.append('karyawan_tetap', karyawan_tetap);
                frmData.append('karyawan_kontrak', karyawan_kontrak);
                frmData.append('karyawan_outsource', karyawan_outsource);
                frmData.append('satpam_kontrak', satpam_kontrak);
                frmData.append('satpam_tetap', satpam_tetap);
                frmData.append('satpam_outsource', satpam_outsource);
                frmData.append('lat', lat);
                frmData.append('long', long);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: '{{ ENV('APP_URL')}}perusahaan/store',
                    method: 'POST',
                    data: frmData,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function (resp) {

                        if (resp.status == true) {
                            Swal.fire('Success', resp.message)
                                .then(function () {
                                    window.location.href = "{{env('APP_URL')}}perusahaan";
                                })
                        } else {
                            Swal.fire('Error', resp.message)
                        }
                    }
                });
            });
        });
    </script>
@endsection
