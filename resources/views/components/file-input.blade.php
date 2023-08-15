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
                title="Source Title">{{ implode(',', $extensions) }}   </cite></div>
    </div>

</div>

@push('js')
    <script nonce="{{csp_nonce()}}">
        $('#{{ $id }}').change(function () {
            @php
                $allowedExt = implode(',', $extensions)
            @endphp
            var ext = $(this).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, [@foreach($extensions as $key=>$ext)'{{$ext}}'@if(($key+1) != count($extensions)),@endif @endforeach]) === -1) {
                Swal.fire({
                    title: 'Error!',
                    text: 'File extension tidak didukung, pastikan memilih file {{$allowedExt}}',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                }).then(function () {
                });
                $('#{{ $id }}').val(null)
            }
        })
    </script>
@endpush
