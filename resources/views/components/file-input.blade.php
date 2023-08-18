<div class="form-group row">
    @if($label!='')
        <div class="col-sm-3">
            <label for="{{ $id }}">{{ $lael }} @if($required)
                    <span style="color: red;">*</span>
                @endif</label>
        </div>
    @endif
    <div class="col">
        <label class="form-label" for="{{ $id }}">{{$placeholder}}</label>
        <input type="file" class="form-control" id="{{ $id }}"
               @if($required)required="required" @endif
               @if($multiple)multiple="multiple" name="{{ $id }}[]"
               @else name="{{ $id }}" @endif
               accept="@foreach($extensions as $key=>$ext).{{$ext}}@if(($key+1) != count($extensions)),@endif @endforeach"/>
        <div id="defaultFormControlHelp_{{ $id }}" class="form-text">Upload Files only support extensions <cite
                title="Source Title">{{ implode(',', $extensions) }}   </cite> and maximum size {{config('app.max_file_size_upload')}}MB</div>
    </div>

</div>

@push('js')
    <script nonce="{{csp_nonce()}}">
        $('#{{ $id }}').change(function () {
            @php
                $allowedExt = implode(',', $extensions);
            @endphp
            var ext = $(this).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, [@foreach($extensions as $key=>$ext)'{{$ext}}'@if(($key+1) != count($extensions)),@endif @endforeach]) === -1) {
                Swal.fire({
                    title: 'Perhatian!',
                    text: 'File extension tidak didukung, pastikan memilih file {{$allowedExt}}',
                    icon: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                }).then(function () {
                    $('#{{ $id }}').val(null)
                });
            }

            if (this.files.length > 0) {
                console.log(this.files[0].size, {{(int)config('app.max_file_size_upload')}} * 1024000)
                if (this.files[0].size > ({{(int)config('app.max_file_size_upload')}} * 1024000)) {
                    $(this).val(null);
                    Swal.fire({
                        title: 'Perhatian!',
                        text: 'Maksimal ukuran file  {{config('app.max_file_size_upload')}}Mb',
                        icon: 'warning',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    }).then(function () {
                        $('#{{ $id }}').val(null)

                    });
                    return false
                }
            }
        })
    </script>
@endpush
