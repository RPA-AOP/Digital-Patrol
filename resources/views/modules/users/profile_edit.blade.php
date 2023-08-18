@extends('layouts/layoutMaster')
@section('title', 'Edit Users')

@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/libs/select2/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>

@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-edit') }}
@endsection

@section('content')
    <section class="app-user-edit">
        <div class="row mb-4">
            <div class="col-3 ">
                <div class="card h-100">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column mt-4">
                            <img class="img-fluid rounded mb-3 pt-1 mt-4"
                                 src="{{$user->image??asset('assets/img/avatars/no-img.png')}}" height="100" width="100"
                                 alt="User avatar">
                            <div class="user-info text-center">
                                <h4 class="mb-2">{{ $user->name }}</h4>
                                <span class="badge bg-label-primary mt-1">{{ $user->userGroup->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <!-- Change Password -->
                <div class="card  h-100">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body">
                        <form id="formChangePassword" method="POST" action="{{route('management-user.change-password')}}">
                            <div class="alert alert-info" role="alert">
                                <span>Minimum 8 characters long, uppercase & symbol</span>
                            </div>
                            @csrf
                            <input type="hidden" value="{{$user->id_user}}" name="id_user">

                            <div class="row">
                                <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                    <label class="form-label" for="newPassword">New Password</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="newPassword"
                                            name="newPassword"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>

                                <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                    <label class="form-label" for="newPassword_confirmation">Confirm New Password</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            class="form-control"
                                            type="password"
                                            name="newPassword_confirmation"
                                            id="newPassword_confirmation"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary me-2">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <!-- Account Tab starts -->
                <div class="" id="account">

                    <!-- users edit account form start -->
                    <form class="form-validate" method="POST"
                          action="{{route('management-user.update', $user->id_user)}}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="hidden" value="{{$user->id_user}}" name="id_user">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                       placeholder="Username"
                                       value="{{ $user->username }}" name="username" id="username"/>
                                @error('username')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">

                                <label class="form-label" for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Name"
                                       value="{{ $user->name }}" name="name" id="name"/>
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="email">E-mail</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Email"
                                       value="{{ $user->email }}" name="email" id="email"/>
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="npk">NPK</label>
                                <input type="text" class="form-control @error('npk') is-invalid @enderror"
                                       placeholder="NPK"
                                       value="{{ $user->npk }}" name="npk" id="npk"/>
                                @error('npk')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label" for="mobile">Phone Number</label>
                                <input id="number" type="text" class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="Phone Number" value="{{ $user->phone }}"
                                       name="phone"/>
                                @error('phone')
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @enderror
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">
                                    Submit
                                </button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js" nonce="{{csp_nonce()}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/PasswordStrength.js')}}"></script>

    <!-- END: Page Vendor JS-->
@endsection

@section('page-script')
    <script nonce="{{csp_nonce()}}">
        $('.select2').select2();

        const formChangePass = document.querySelector('#formChangePassword');

        // Form validation for Change password
        if (formChangePass) {
            const fv = FormValidation.formValidation(formChangePass, {
                fields: {
                    newPassword: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter new password'
                            },
                            stringLength: {
                                min: 8,
                                message: 'Password must be more than 8 characters'
                            }
                        }
                    },
                    newPassword_confirmation: {
                        validators: {
                            notEmpty: {
                                message: 'Please confirm new password'
                            },
                            identical: {
                                compare: function () {
                                    return formChangePass.querySelector('[name="newPassword"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            },
                            stringLength: {
                                min: 8,
                                message: 'Password must be more than 8 characters'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        rowSelector: '.form-password-toggle'
                    }),
                    // Submit the form when all fields are valid
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    autoFocus: new FormValidation.plugins.AutoFocus(),
                    passwordStrength: new FormValidation.plugins.PasswordStrength({
                        field: 'newPassword',
                        message: 'The password is weak',
                        minimalScore: 3,
                        onValidated: function (valid, message, score) {
                            console.log(valid, message, score)
                        }

                    }),
                },
                init: instance => {
                    instance.on('plugins.message.placed', function (e) {
                        if (e.element.parentElement.classList.contains('input-group')) {
                            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                        }
                    });
                }
            });
        }
    </script>
@endsection
