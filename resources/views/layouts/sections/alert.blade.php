@php
    $type = null;
if (Session::has('success')){
    $message = Session::get('success');
    $type = 'alert-success';
}
if (Session::has('error')){
    $message = Session::get('error');
    $type = 'alert-danger';
}
if (Session::has('info')){
    $message = Session::get('info');
    $type = 'alert-info';
}
if ($errors->any()){
    $type = 'alert-info';
    $message ='Please check the form below for errors';
}

@endphp
@if($type)
    <div class="alert {{$type}}" role="alert">
        <div class="alert-body">
            <span>{{$message}}</span>
        </div>
    </div>
@endif
