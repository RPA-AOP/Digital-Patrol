@extends('layouts/layoutMaster')
@section('title', 'Tambah Data Perusahaan')

@section('vendor-style')

    <!-- END: Page CSS-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin="">
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
            integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
            crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"/>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

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
@section('content')
    <section id="responsive-datatable">
        <div class="card">
            <div class="card-header">
                <div class="head-label">
                    <h6>Add new company</h6>
                    <small>Please fill input with company details</small>
                </div>
            </div>
            <div class="card-body">
                <form id="form_tambah" action="{{route('master.company.store')}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="modern-twitter">Nama Perusahaan</label>
                                    <input type="text" id="nama_perusahaan" name="nama_perusahaan"
                                           value="{{old('nama_perusahaan')??''}}"
                                           class="form-control @error('nama_perusahaan') is-invalid @enderror"/>
                                    @error('nama_perusahaan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="modern-twitter">Lokasi Perusahaan</label>
                                    <div id="map" style="width:100%; height: 300px;z-index: 0"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Lattitude</label>
                                    <input type="text" id="lattitude" name="lat"
                                           class="form-control @error('lat') is-invalid @enderror " readonly>
                                    @error('lat')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" id="longitude" name="long"
                                           class="form-control @error('long') is-invalid @enderror " readonly>
                                    @error('long')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="modern-twitter">Detail Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                              id="alamat" cols="5"
                                              rows="5">{{old('alamat')??''}}</textarea>

                                    @error('alamat')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="modern-twitter">Nama Produk</label>
                                    <input type="text" id="nama_produk" name="nama_produk"
                                           value="{{old('nama_produk')??''}}"
                                           class="form-control @error('nama_produk') is-invalid @enderror"/>
                                    @error('nama_produk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="modern-twitter">Proses Utama</label>
                                    <input type="text" id="proses_utama" name="proses_utama"
                                           value="{{old('proses_utama')??''}}"
                                           class="form-control @error('proses_utama') is-invalid @enderror"/>
                                    @error('proses_utama')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="modern-google">Luas Tanah</label>
                                    <input type="number" id="luas_tanah" name="luas_tanah"
                                           value="{{old('luas_tanah')??''}}"
                                           class="form-control @error('luas_tanah') is-invalid @enderror"/>
                                    @error('luas_tanah')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="modern-linkedin">Luas Bangunan</label>
                                    <input type="number" id="luas_bangunan" name="luas_bangunan"
                                           value="{{old('luas_bangunan')??''}}"
                                           class="form-control @error('luas_bangunan') is-invalid @enderror"/>
                                    @error('luas_bangunan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="modern-google">Status Bangunan</label>
                                    <input type="text" id="status_bangunan" name="status_bangunan"
                                           value="{{old('status_bangunan')??''}}"
                                           class="form-control @error('status_bangunan') is-invalid @enderror"/>
                                    @error('status_bangunan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="modern-google">Jumlah Karyawan Tetap</label>
                                    <input type="number" id="karyawan_tetap" name="karyawan_tetap"
                                           value="{{old('karyawan_tetap')??''}}"
                                           class="form-control @error('karyawan_tetap') is-invalid @enderror"/>
                                    @error('karyawan_tetap')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="modern-linkedin">Jumlah Karyawan
                                        Kontrak</label>
                                    <input type="number" id="karyawan_kontrak" name="karyawan_kontrak"
                                           value="{{old('karyawan_kontrak')??''}}"
                                           class="form-control @error('karyawan_kontrak') is-invalid @enderror"/>
                                    @error('karyawan_kontrak')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="modern-google">Jumlah Karyawan
                                        Outsource</label>
                                    <input type="number" id="karyawan_outsource" name="karyawan_outsource"
                                           value="{{old('karyawan_outsource')??''}}"
                                           class="form-control @error('karyawan_outsource') is-invalid @enderror"/>
                                    @error('karyawan_outsource')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-between">
                                <a class="btn btn-outline-secondary btn-prev" href="{{route('master.company.index')}}">
                                    <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Back</span>
                                </a>

                                <button class="btn btn-primary btn-next" type="submit">
                                    <span class="align-middle d-sm-inline-block d-none">Simpan</span>
                                    <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('page-script')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <script type="text/javascript">
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
