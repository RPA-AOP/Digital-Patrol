<div class="form-group row">
    @if($label!='')
        <div class="col-sm-3">
            <label for="{{ $id }}">{{ $label }} @if($required)
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
      <div id="defaultFormControlHelp" class="form-text">Upload Files only support extensions <cite title="Source Title">{{ implode(',', $extensions) }}   </cite></div>
    </div>

</div>
