<div class="form-group row">
    <div class="col-sm-3 col-form-label">

        <label for="{{ $id }}">{{ $label }} @if($required)
                <span style="color: red;">*</span>
            @endif</label>
    </div>
    <div class="col-sm-9">
        <select id="{{$id}}" class="select2 form-control" @if($required)required="required" @endif>
            <option value="0">{{ $placeholder }}</option>
        </select>
    </div>
</div>

@section('page-script')
    <!-- START SELECT2 {{strtoupper($label)}}-->
    <script>
        var nowYear = new Date().getFullYear();
        var lastYear = nowYear - 10;
        var data = [];

        for (let i = nowYear; i >= lastYear; i--) {
            data.push({"id":i, "text":i});
        }

        $('#{{ $id }}').select2(
        {
            placeholder: "{{ $placeholder }}",
            data: data
        });
    </script>
    <!-- END SELECT2 {{strtoupper($label)}}-->
@endsection
