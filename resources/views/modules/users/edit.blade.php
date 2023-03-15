@extends('layouts/layoutMaster')
@section('title', 'Edit Users')

@section('vendor-style')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/pages/app-user.css')}}">
  <link rel="stylesheet" type="text/css"
        href="{{asset('assets/vendor/css/pickers/flatpickr/flatpickr.min.css')}}">
@endsection

@section('breadcrumbs')
  {{ Breadcrumbs::render('user-edit') }}
@endsection

@section('content')
  <section class="app-user-edit">
    <div class="card">
      <div class="card-body">
        <!-- Account Tab starts -->
        <div class="" id="account">
          <!-- users edit media object start -->
          <div class="media mb-2">
            <img src="{{$user->image??asset('assets/images/no-img.png')}}" alt="users avatar"
                 class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90"
                 width="90"/>
            <div class="media-body mt-50">
              <h4>{{ $user->nama }}</h4>
              <div class="col-12 d-flex mt-1 px-0">
                <label class="form-label" class="btn btn-primary mr-75 mb-0" for="change-picture">
                  <span class="d-none d-sm-block">Change</span>
                  <input class="form-control" type="file" id="change-picture" hidden
                         accept="image/png, image/jpeg, image/jpg"/>
                  <span class="d-block d-sm-none">
                                                        <i class="mr-0" data-feather="edit"></i>
                                                    </span>
                </label>
              </div>
            </div>
          </div>
          <!-- users edit media object ends -->
          <!-- users edit account form start -->
          <form class="form-validate" method="POST"
                action="{{route('management-user.update', $user->id_user)}}">
            @csrf
            <div class="row g-3">
              <div class="col-md-4">

                <label class="form-label" for="username">Username</label>
                <input type="text" class="form-control" placeholder="Username"
                       value="{{ $user->username }}" name="username" id="username"/>

              </div>
              <div class="col-md-4">

                <label class="form-label" for="name">Name</label>
                <input type="text" class="form-control" placeholder="Name"
                       value="{{ $user->nama }}" name="name" id="name"/>
              </div>
              <div class="col-md-4">

                <label class="form-label" for="email">E-mail</label>
                <input type="email" class="form-control" placeholder="Email"
                       value="{{ $user->email }}" name="email" id="email"/>
              </div>
              <div class="col-md-4">

                <label class="form-label" for="npk">NPK</label>
                <input type="text" class="form-control" placeholder="NPK"
                       value="{{ $user->npk }}" name="npk" id="npk"/>
              </div>
              <div class="col-lg-4">
                <label class="form-label" for="mobile">Phone Number</label>
                <input id="mobile" type="text" class="form-control" value="{{ $user->phone }}"
                       name="phone"/>
              </div>
              <div class="col-md-4">

                <label class="form-label" for="role">Group User</label>
                <select class="form-control" id="user-group" name="userGroup">
                  @foreach($userGroup as $group)
                    <option value="{{$group->id_user_group}}"
                            @if($group->id_user_group==$user->id_user_group) selected @endif>{{$group->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">

                <label class="form-label" for="status">Status</label>
                <select class="form-control" id="status">
                  <option>Active</option>
                  <option>Blocked</option>
                  <option>Deactivated</option>
                </select>
              </div>


              <div class="col-12">
                <div class="table-responsive border rounded mt-1">
                  <h6 class="py-1 mx-1 mb-0 font-medium-2">
                    <i data-feather="lock" class="font-medium-3 mr-25"></i>
                    <span class="align-middle">Permission</span>
                  </h6>
                  <table class="table table-striped table-borderless">
                    <thead class="thead-light">
                    <tr>
                      <th>Menu</th>
                      <th>Read</th>
                      <th>Write</th>
                      <th>Create</th>
                      <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user->privileges as $key =>$privilege)
                      <tr>
                        <td>{{$privilege->menu->name}}</td>
                        <td>

                          <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="1"
                                   id="view_{{strtolower(str_replace(" ","_",$privilege->menu->title))}}"
                                   @if($privilege->has_edit) checked @endif
                                   name="privilege[{{$privilege->id_user_group_privilege}}][has_view]"
                            />
                          </div>
                        </td>
                        <td>
                          <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="1"
                                   id="write_{{strtolower(str_replace(" ","_",$privilege->menu->title))}}"
                                   @if($privilege->has_edit) checked @endif
                                   name="privilege[{{$privilege->id_user_group_privilege}}][has_edit]"
                            />
                          </div>
                        </td>
                        <td>
                          <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="1"
                                   id="create_{{strtolower(str_replace(" ","_",$privilege->menu->title))}}"
                                   @if($privilege->has_edit) checked @endif
                                   name="privilege[{{$privilege->id_user_group_privilege}}][has_create]"
                            />
                          </div>
                        </td>
                        <td>
                          <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="1"
                                   id="delete_{{strtolower(str_replace(" ","_",$privilege->menu->title))}}"
                                   @if($privilege->has_edit) checked @endif
                                   name="privilege[{{$privilege->id_user_group_privilege}}][has_delete]"
                            />
                          </div>

                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Submit</button>
                <button type="reset" class="btn btn-label-secondary waves-effect">Cancel</button>
              </div>
            </div>
          </form>
          <!-- users edit account form ends -->
        </div>
        <!-- Account Tab ends -->
      </div>
    </div>
  </section>
@endsection

@section('vendor-script')
  <!-- BEGIN: Page Vendor JS-->
  <script src="{{asset('assets/vendor/js/forms/select/select2.full.min.js')}}"></script>
  <script src="{{asset('assets/vendor/js/forms/validation/jquery.validate.min.js')}}"></script>
  <script src="{{asset('assets/vendor/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
  <!-- END: Page Vendor JS-->
@endsection

@section('page-script')
  <script src="{{asset('assets/js/scripts/pages/app-user-edit.js')}}"></script>
@endsection
