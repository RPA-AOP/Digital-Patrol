@push('dynamic_form_css')
    <!--CSS DYNAMIC FORM -->
    <script nonce="{{ csp_nonce() }}">
        .cke_chrome {
            border-radius: 0px !important;
            border: 1px solid #d8d6de !important;
            /*border-width: thin;*/
        }

        .cke_top {
            border: 1px solid #d8d6de !important;
        }

    </style>
@endsection
<div class="col-12">
    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title"><i data-feather='file-text' class="font-medium-2 mr-25"></i>Cetak Dokumen KAK</h4>
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
                <div class="form-control-repeater">
                    <div class="row">
                        <!-- KAK repeater -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="kak-repeater">
                                        <div data-repeater-list="data-kak">
                                            <div data-repeater-item>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h5 style="font-weight: 700;" class="step_text">Nomor #1</h5>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label for="point">Judul Uraian</label>

                                                            <div class="input-group">
                                                                <input class="form-control" name="point"
                                                                       placeholder="Judul Uraian">
                                                                <div class="input-group-append" id="button-addon2">
                                                                    <button
                                                                        class="btn btn-sm btn-outline-danger text-nowrap px-1 "
                                                                        data-repeater-delete type="button">
                                                                        <i data-feather="x" class="mr-25"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-2 d-flex align-items-end">
                                                        <div class="form-group">
                                                            <button
                                                                class="btn btn-primary text-nowrap px-1 " type="button"
                                                                onclick="insertTableComponent(this)">Insert table komponen
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="uraian">Uraian</label>
                                                            <textarea class="form-control editor" rows="7"
                                                                      required
                                                                      name="uraian"
                                                                      placeholder="Uraian"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-sm btn-primary" type="button"
                                                        data-repeater-create>
                                                    <i data-feather="plus" class="mr-25"></i>
                                                    <span>Tambah Point</span>
                                                </button>
                                                <a href="javascript:"
                                                   class="btn btn-sm btn-outline-primary waves-effect"
                                                   onclick="previewKAK()">
                                                    <i data-feather="info" class="font-medium-2 mr-50"></i>
                                                    Preview Dokumen KAK</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- KAK repeater -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('dynamic_form_js')
    <!-- JS DYNAMIC FORM -->
    <script nonce="{{ csp_nonce() }}">
        function insertTableComponent(e) {
            let table = `<table class="komponen" width="100%" style="width: 100%!important;">
                            <thead>
                            <tr>
                                <td>
                                    <strong>No</strong>
                                </td>
                                <td>
                                    <strong>Nama Barang</strong>
                                </td>
                                <td>
                                    <strong>Spesifikasi</strong>
                                </td>
                                <td>
                                    <strong>Jumlah</strong>
                                </td>
                                <td>
                                    <strong>Satuan</strong>
                                </td>
                            </tr>
                         </thead>
                      <tbody>`;
            $('[name="data-kak-datakomponen[]"]').each(function () {
                var dataComponent = JSON.parse($(this).val());
                console.log(dataComponent)
                table = table
                    + `<tr><td>
                        <b>` + dataComponent['kode'] + `</b>
                    </td>
                    <td colspan="4">
                        ` + dataComponent['nama'] + `
                    </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>` + dataComponent['volume'] + `</td>
                        <td>` + dataComponent['satuan'] + `</td>
                    </tr>`
            });
            table = table + `</tbody></table>`;
            var txArea = $(e).parent().parent().parent().find('textarea');
            var txAreaName = $(txArea).attr('name')
            CKEDITOR.instances[txAreaName].insertHtml(table);
        }


        $(document).ready(function () {
            // editor
            $('.kak-repeater, .repeater-default').repeater({
                isFirstItemUndeletable: true,
                show: function () {
                    $(this).slideDown();
                    // Feather Icons
                    if (feather) {
                        feather.replace({width: 14, height: 14});
                    }
                    var repeaterLength = $("div[data-repeater-item]").length
                    if (repeaterLength > 0) {
                        console.log($(this).find('.step_text'))
                        $(this).find('.step_text').text("Nomor #" + repeaterLength)
                    }
                    initCkEDITOR()

                },
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function (setIndexes) {
                    initCkEDITOR()
                },
            });

        })

    </script>
@endsection
