<div class="col-12">
    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title"><i data-feather='file-text' class="font-medium-2 mr-25"></i> Cetak Surat Permintaan
                Penawaran Harga</h4>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li>
                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="hal">Perihal</label>
                            <input type="text" id="perihal" class="form-control"
                                   name="perihal" placeholder="Perihal" value="Permintaan Penawaran Harga"/>
                        </div>
                        <div class="form-group">
                            <label for="kepada">Kepada</label>
                            <input type="text" id="kepada" class="form-control"
                                   name="kepada" placeholder="Kepada"/>
                        </div>
                        <div class="form-group">
                            <label for="label-textarea">Uraian</label>
                            <textarea class="form-control editor" id="label-textarea" rows="10" name="uraian-ssph"
                                      placeholder="Uraian">Sehubungan dengan adanya kebutuhan di Pusat Data dan Informasi Cipta Karya, Tata Ruang dan Pertanahan Provinsi DKI Jakarta, dimohon agar Saudara dapat memberikan harga untuk kebutuhan-kebutuhan sebagai berikut:</textarea>
                        </div>
                        <div class="form-label-group">
                            <h5>Tabel Spesifikasi</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Volume</th>
                                        <th>Satuan</th>
                                        <th width="40%">Spesifikasi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="spph-komponen">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="javascript:" onclick="previewSPPH()"
                               class="btn btn-sm btn-outline-primary round waves-effect">
                                <i data-feather="info" class="font-medium-2 mr-50"></i>
                                Preview Cetak Surat Permintaan Penawaran Harga</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('dynamic_form_js')
    <script nonce="{{ csp_nonce() }}">
    </script>
@endsection
