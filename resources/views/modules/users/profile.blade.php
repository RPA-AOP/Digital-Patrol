@extends('layouts/layoutMaster')

@section('title', 'User Profile - Profile')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
@endsection

<!-- Page -->
@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-profile.css')}}"/>
@endsection


@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/pages/profile.js')}}"></script>
@endsection

@section('content')
  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">User Profile /</span> Profile
  </h4>


  <!-- Header -->
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="user-profile-header-banner">
          <img src="{{ asset('assets/img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top">
        </div>
        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
          <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
            <img src="{{ $user->image?? asset('assets/img/avatars/no-img.png') }}" alt="user image"
                 class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img bg-white">
          </div>
          <div class="flex-grow-1 mt-3 mt-sm-5">
            <div
              class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
              <div class="user-profile-info">
                <h4>{{$user->nama}}</h4>
                <ul
                  class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                  <li class="list-inline-item">
                    <i class='ti ti-color-swatch'></i> {{$user->userGroup->name }}
                  </li>
                  <li class="list-inline-item">
                    <i class='ti ti-map-pin'></i> {{$user->company->name??"-" }}
                  </li>
                  <li class="list-inline-item">
                    <i class='ti ti-calendar'></i> Join at {{$user->created_at->toFormattedDateString() }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Header -->


  <!-- User Profile Content -->
  <div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5">
      <!-- About User -->
      <div class="card mb-4">
        <div class="card-body">
          <small class="card-text text-uppercase">About</small>
          <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3"><i class="ti ti-user"></i><span
                class="fw-bold mx-2">Full Name:</span> <span>{{$user->nama}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-file-description"></i><span class="fw-bold mx-2">NPK:</span>
              <span>{{$user->npk}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-check"></i><span
                class="fw-bold mx-2">Status:</span> <span>{{$user->status==1?'Active':'Suspend'}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-crown"></i><span
                class="fw-bold mx-2">Role:</span> <span>{{$user->userGroup->name??'-'}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-flag"></i><span
                class="fw-bold mx-2">Company:</span> <span>{{$user->company->name??'-'}}</span></li>

          </ul>
          <small class="card-text text-uppercase">Contacts</small>
          <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3"><i class="ti ti-phone-call"></i><span class="fw-bold mx-2">Contact:</span>
              <span>{{$user->phone??'-'}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-mail"></i><span
                class="fw-bold mx-2">Email:</span> <span>{{$user->email??'-'}}</span></li>
          </ul>
        </div>
      </div>
      <!--/ About User -->
      <!-- Profile Overview -->
      <div class="card mb-4">
        <div class="card-body">
          <p class="card-text text-uppercase">Patrol Overview</p>
          <ul class="list-unstyled mb-0">
            <li class="d-flex align-items-center mb-3"><i class="ti ti-check"></i><span class="fw-bold mx-2">Patroli Compiled:</span>
              <span>135</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-layout-grid"></i><span class="fw-bold mx-2">Achievement Compiled:</span>
              <span>99%</span></li>
            <li class="d-flex align-items-center"><i class="ti ti-users"></i><span
                class="fw-bold mx-2">Abnormality founding:</span> <span>897</span></li>
          </ul>
        </div>
      </div>
      <!--/ Profile Overview -->
    </div>
    <div class="col-xl-8 col-lg-7 col-md-7">
      <!-- Projects table -->
      <div class="card mb-4">
        <div class="card-datatable table-responsive">
          <table class="datatables-projects table border-top">
            <thead>
            <tr>
              <th></th>
              <th></th>
              <th>Name</th>
              <th>Leader</th>
              <th>Team</th>
              <th class="w-px-200">Status</th>
              <th>Action</th>
            </tr>
            </thead>
          </table>
        </div>
      </div>
      <!--/ Projects table -->
    </div>
  </div>
  <!--/ User Profile Content -->
@endsection
